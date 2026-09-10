<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* ==========================================================
   1. VERIFICAR SESIÓN Y ROL
   ========================================================== */

if (!isset($_SESSION['id'])) {
    header("Location: usuypass2.php");
    exit();
}

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != '01') {
    die("No tienes permisos para facturar citas.");
}

/* ==========================================================
   2. VALIDAR ID DE LA CITA
   ========================================================== */

$idCita = filter_input(INPUT_GET, 'id_cita', FILTER_VALIDATE_INT);

if (!$idCita && $_SERVER["REQUEST_METHOD"] === "POST") {
    $idCita = filter_input(INPUT_POST, 'id_cita', FILTER_VALIDATE_INT);
}

if (!$idCita) {
    die("No se recibió una cita válida.");
}

/* ==========================================================
   3. CONEXIÓN A LA BASE DE DATOS
   ========================================================== */

try {

    $conexion = new PDO(
        "mysql:host=localhost;port=3306;dbname=bd_glow_smec;charset=utf8mb4",
        "root",
        ""
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Error de conexión: " . $e->getMessage());

}

/* ==========================================================
   4. CONSULTAR LA CITA Y LOS DATOS DEL CLIENTE
   ========================================================== */

$sql = "
    SELECT
        c.id,
        c.identificacion,
        c.fecha,
        c.hora,
        c.servicio,
        c.observaciones,
        c.estatus,

        p.nombres,
        p.apellidos,
        p.correo,

        ps.descripcion AS nombre_servicio,
        ps.precio

    FROM cita c

    INNER JOIN persona p
        ON c.identificacion = p.identificacion

    INNER JOIN producto_servicio ps
        ON c.servicio = ps.cod_prod_ser

    WHERE c.id = :id_cita
      AND ps.tipo_prod_ser = 'S'
";

$stmt = $conexion->prepare($sql);
$stmt->execute([
    ":id_cita" => $idCita
]);

$cita = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cita) {
    die("No se encontró la cita.");
}

/* ==========================================================
   5. BUSCAR SI YA EXISTE UNA FACTURA PARA ESTA CITA
   ========================================================== */

$sqlFacturaExistente = "
    SELECT no_factura
    FROM factura
    WHERE id_cita = :id_cita
    LIMIT 1
";

$stmtFacturaExistente = $conexion->prepare($sqlFacturaExistente);
$stmtFacturaExistente->execute([
    ":id_cita" => $idCita
]);

$facturaExistente = $stmtFacturaExistente->fetch(PDO::FETCH_ASSOC);

$numeroFactura = $facturaExistente['no_factura'] ?? null;
$estaFacturada = ((int)$cita['estatus'] === 2) || !empty($numeroFactura);
$mensaje = "";
$error = "";

/* ==========================================================
   6. GENERAR LA FACTURA
   ========================================================== */

if ($_SERVER["REQUEST_METHOD"] === "POST" && !$facturaExistente && !$estaFacturada) {

    try {

        $conexion->beginTransaction();

        /*
         * Volvemos a comprobar el estado dentro de la transacción
         * para evitar facturar dos veces la misma cita.
         */

        $sqlBloqueo = "
            SELECT estatus
            FROM cita
            WHERE id = :id_cita
            FOR UPDATE
        ";

        $stmtBloqueo = $conexion->prepare($sqlBloqueo);
        $stmtBloqueo->execute([
            ":id_cita" => $idCita
        ]);

        $estadoCita = $stmtBloqueo->fetch(PDO::FETCH_ASSOC);

        if (!$estadoCita) {
            throw new Exception("La cita no existe.");
        }

        if ((int)$estadoCita['estatus'] === 2) {
            throw new Exception("Esta cita ya está facturada.");
        }

        /* ------------------------------------------
           GENERAR NÚMERO DE FACTURA
           ------------------------------------------ */

        $numeroFactura = date("YmdHis") . $idCita;

        /* ------------------------------------------
           INSERTAR ENCABEZADO DE FACTURA
           ------------------------------------------ */

        $sqlInsertFactura = "
            INSERT INTO factura
            (
                no_factura,
                id_cita,
                cliente,
                nombre_cliente,
                correo,
                fecha,
                notas
            )
            VALUES
            (
                :no_factura,
                :id_cita,
                :cliente,
                :nombre_cliente,
                :correo,
                NOW(),
                :notas
            )
        ";

        $stmtInsertFactura = $conexion->prepare($sqlInsertFactura);

        $stmtInsertFactura->execute([
            ":no_factura" => $numeroFactura,
            ":id_cita" => $idCita,
            ":cliente" => $cita['identificacion'],
            ":nombre_cliente" =>
                $cita['nombres'] . " " . $cita['apellidos'],
            ":correo" => $cita['correo'],
            ":notas" => "Factura generada desde la cita #" . $idCita
        ]);

        /* ------------------------------------------
           INSERTAR DETALLE DE FACTURA
           ------------------------------------------ */

        $sqlDetalle = "
            INSERT INTO detalle_factura
            (
                cod_factura,
                cod_producto_servicio,
                cantidad,
                valor_unitario,
                subtotal,
                fecha_servicio,
                hora_servicio
            )
            VALUES
            (
                :cod_factura,
                :cod_producto_servicio,
                1,
                :valor_unitario,
                :subtotal,
                :fecha_servicio,
                :hora_servicio
            )
        ";

        $stmtDetalle = $conexion->prepare($sqlDetalle);

        $stmtDetalle->execute([
            ":cod_factura" =>
                $numeroFactura,

            ":cod_producto_servicio" =>
                $cita['servicio'],

            ":valor_unitario" =>
                $cita['precio'],

            ":subtotal" =>
                $cita['precio'],

            ":fecha_servicio" =>
                $cita['fecha'],

            ":hora_servicio" =>
                $cita['hora']
        ]);

        /* ------------------------------------------
           CAMBIAR ESTATUS DE LA CITA

           1 = NO FACTURADA
           2 = FACTURADA
           ------------------------------------------ */

        $sqlActualizarCita = "
            UPDATE cita
            SET estatus = 2
            WHERE id = :id_cita
        ";

        $stmtActualizarCita =
            $conexion->prepare($sqlActualizarCita);

        $stmtActualizarCita->execute([
            ":id_cita" => $idCita
        ]);

        $conexion->commit();

        $mensaje =
            "Factura generada correctamente. "
            . "Número de factura: "
            . $numeroFactura;

        $facturaExistente = [
            'no_factura' => $numeroFactura
        ];

        $estaFacturada = true;

    } catch (Exception $e) {

        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }

        $numeroFactura = null;
        $error = $e->getMessage();
    }
}

/* ==========================================================
   7. FECHA DE LA FACTURA
   ========================================================== */

$fechaFactura = date("d/m/Y");

/* ==========================================================
   8. GENERAR PDF
   ========================================================== */

if (
    isset($_GET['pdf']) &&
    $_GET['pdf'] == '1'
) {

    if (!$facturaExistente) {
        die("Primero debes generar la factura.");
    }

    require_once("fpdf/fpdf.php");

    function textoPDF($texto)
    {
        return iconv(
            'UTF-8',
            'windows-1252//TRANSLIT',
            $texto
        );
    }

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetMargins(15, 15, 15);

    /* TÍTULO */

    $pdf->SetFont('Arial', 'B', 18);

    $pdf->Cell(
        0,
        10,
        textoPDF('GLOW SMEC'),
        0,
        1,
        'C'
    );

    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(
        0,
        10,
        textoPDF('FACTURA DE SERVICIO'),
        0,
        1,
        'C'
    );

    $pdf->Ln(5);

    /* DATOS DE FACTURA */

    $pdf->SetFont('Arial', '', 11);

    $pdf->Cell(
        95,
        7,
        textoPDF(
            'Factura No: ' .
            $facturaExistente['no_factura']
        ),
        0,
        0
    );

    $pdf->Cell(
        95,
        7,
        textoPDF(
            'Fecha: ' .
            $fechaFactura
        ),
        0,
        1,
        'R'
    );

    $pdf->Ln(5);

    /* ENCABEZADO - CLIENTE */

    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(
        0,
        8,
        textoPDF('Datos del cliente'),
        0,
        1
    );

    $pdf->SetFont('Arial', '', 11);

    $pdf->Cell(
        0,
        7,
        textoPDF(
            'Identificación: ' .
            $cita['identificacion']
        ),
        0,
        1
    );

    $pdf->Cell(
        0,
        7,
        textoPDF(
            'Cliente: ' .
            $cita['nombres'] .
            ' ' .
            $cita['apellidos']
        ),
        0,
        1
    );

    $pdf->Cell(
        0,
        7,
        textoPDF(
            'Correo: ' .
            $cita['correo']
        ),
        0,
        1
    );

    $pdf->Ln(7);

    /* DETALLE */

    $pdf->SetFont('Arial', 'B', 10);

    $pdf->Cell(35, 9, textoPDF('Fecha'), 1, 0, 'C');
    $pdf->Cell(30, 9, textoPDF('Hora'), 1, 0, 'C');
    $pdf->Cell(75, 9, textoPDF('Servicio'), 1, 0, 'C');
    $pdf->Cell(45, 9, textoPDF('Precio'), 1, 1, 'C');

    $pdf->SetFont('Arial', '', 9);

    $pdf->Cell(
        35,
        9,
        textoPDF($cita['fecha']),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        30,
        9,
        textoPDF($cita['hora']),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        75,
        9,
        textoPDF(
            substr(
                $cita['nombre_servicio'],
                0,
                40
            )
        ),
        1,
        0
    );

    $pdf->Cell(
        45,
        9,
        '$ ' .
        number_format(
            $cita['precio'],
            0,
            ',',
            '.'
        ),
        1,
        1,
        'R'
    );

    /* TOTAL */

    $pdf->SetFont('Arial', 'B', 11);

    $pdf->Cell(
        140,
        10,
        textoPDF('TOTAL A PAGAR'),
        1,
        0,
        'R'
    );

    $pdf->Cell(
        45,
        10,
        '$ ' .
        number_format(
            $cita['precio'],
            0,
            ',',
            '.'
        ),
        1,
        1,
        'R'
    );

    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(
        0,
        8,
        textoPDF('Gracias por su compra'),
        0,
        1,
        'C'
    );

    $pdf->Output(
        'I',
        'factura_' .
        $facturaExistente['no_factura'] .
        '.pdf'
    );

    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Factura de servicio</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background:
                linear-gradient(
                    135deg,
                    #fdf0f3,
                    #ffffff
                );
            min-height: 100vh;
            padding: 30px;
            color: #222;
        }

        .contenedor {
            max-width: 950px;
            width: 100%;
            margin: auto;
        }

        .volver {
            display: inline-block;
            background: #121214;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .volver:hover {
            background: #D45B7A;
        }

        .factura {
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow:
                0 10px 30px
                rgba(0,0,0,.08);
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #D45B7A;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .encabezado h1 {
            color: #D45B7A;
            font-size: 28px;
        }

        .numero {
            text-align: right;
            font-size: 14px;
            line-height: 1.7;
        }

        .numero strong {
            color: #D45B7A;
        }

        .mensaje {
            background: #e7f7ed;
            color: #176b36;
            border: 1px solid #b9e6c8;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            background: #fde8e8;
            color: #9b1c1c;
            border: 1px solid #f5b5b5;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .datos-cliente {
            background: #FBE2E8;
            padding: 20px 25px;
            margin-bottom: 30px;
            border-radius: 8px;
            border-left: 4px solid #D45B7A;
        }

        .datos-cliente h2 {
            margin-bottom: 15px;
            color: #121214;
            font-size: 18px;
        }

        .datos-cliente p {
            margin: 7px 0;
            font-size: 14px;
        }

        .datos-cliente strong {
            display: inline-block;
            width: 130px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th {
            background: #121214;
            color: white;
            padding: 13px;
            text-align: center;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            padding-top: 15px;
            border-top: 2px dashed #D45B7A;
        }

        .total span {
            color: #D45B7A;
        }

        .botones {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .boton {
            display: inline-block;
            padding: 12px 22px;
            background: #121214;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton:hover {
            background: #D45B7A;
        }

        

        .boton-ver,
        .boton-volver {
            text-decoration: none;
            display: inline-block;
        }

        .boton-ver {
            background: #d9577b;
            color: white;
        }

        .boton-volver {
            background: #555;
            color: white;
        }
.boton-pdf {
            background: #D45B7A;
        }

        .boton-pdf:hover {
            background: #B84362;
        }

        .confirmacion {
            margin-top: 25px;
            padding: 20px;
            background: #faf8f9;
            border: 1px solid #eed8df;
            border-radius: 10px;
            text-align: center;
        }

        .confirmacion p {
            margin-bottom: 15px;
        }

        @media (max-width: 650px) {

            body {
                padding: 15px;
            }

            .factura {
                padding: 20px;
            }

            .encabezado {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .numero {
                text-align: left;
            }

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 8px;
            }

            .boton {
                width: 100%;
                text-align: center;
            }
        }

    </style>

</head>

<body>

<div class="contenedor">

    <a
        href="agenda.php"
        class="volver"
    >
        ← Volver a la agenda
    </a>

    <?php if (!empty($mensaje)): ?>

        <div class="mensaje">
            <?php
            echo htmlspecialchars($mensaje);
            ?>
        </div>

    <?php endif; ?>

    <?php if (!empty($error)): ?>

        <div class="error">
            <?php
            echo htmlspecialchars($error);
            ?>
        </div>

    <?php endif; ?>

    <div class="factura">

        <div class="encabezado">

            <div>
                <h1>GlowSmec</h1>
                <p>Factura de servicio</p>
            </div>

            <div class="numero">

                <strong>
                    Factura No:
                </strong>

                <?php
                echo htmlspecialchars(
                    $numeroFactura ??
                    'Pendiente'
                );
                ?>

                <br>

                Fecha:
                <?php echo $fechaFactura; ?>

            </div>

        </div>

        <!-- ==========================================
             ENCABEZADO DE FACTURA
             ========================================== -->

        <div class="datos-cliente">

            <h2>
                Datos del cliente
            </h2>

            <p>
                <strong>Identificación:</strong>

                <?php
                echo htmlspecialchars(
                    $cita['identificacion']
                );
                ?>
            </p>

            <p>
                <strong>Cliente:</strong>

                <?php
                echo htmlspecialchars(
                    $cita['nombres'] .
                    ' ' .
                    $cita['apellidos']
                );
                ?>
            </p>

            <p>
                <strong>Correo:</strong>

                <?php
                echo htmlspecialchars(
                    $cita['correo']
                );
                ?>
            </p>

        </div>

        <!-- ==========================================
             DETALLE DE FACTURA
             ========================================== -->

        <table>

            <thead>

                <tr>

                    <th>
                        Fecha del servicio
                    </th>

                    <th>
                        Hora
                    </th>

                    <th>
                        Servicio
                    </th>

                    <th>
                        Precio
                    </th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $cita['fecha']
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $cita['hora']
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $cita['nombre_servicio']
                        );
                        ?>
                    </td>

                    <td>
                        $
                        <?php
                        echo number_format(
                            $cita['precio'],
                            0,
                            ",",
                            "."
                        );
                        ?>
                    </td>

                </tr>

            </tbody>

        </table>

        <div class="total">

            Total a pagar:

            <span>
                $
                <?php
                echo number_format(
                    $cita['precio'],
                    0,
                    ",",
                    "."
                );
                ?>
            </span>

        </div>

        <!-- ==========================================
             BOTONES
             ========================================== -->

        <div class="botones">

            <?php if ($estaFacturada): ?>

                <a
                    href="factura_kitty.php?id_cita=<?php echo urlencode($idCita); ?>"
                    class="boton boton-ver"
                >
                    Ver factura
                </a>

                <?php if ($numeroFactura): ?>
                    <a
                        href="factura_kitty.php?id_cita=<?php echo urlencode($idCita); ?>&pdf=1"
                        class="boton boton-pdf"
                        target="_blank"
                    >
                        Generar PDF
                    </a>
                <?php endif; ?>

            <?php else: ?>

                <form
                    action="factura_kitty.php?id_cita=<?php echo urlencode($idCita); ?>"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="id_cita"
                        value="<?php echo htmlspecialchars($idCita); ?>"
                    >

                    <button
                        type="submit"
                        class="boton boton-pdf"
                    >
                        Confirmar y facturar
                    </button>

                </form>

            <?php endif; ?>

            <a
                href="agenda.php"
                class="boton boton-volver"
            >
                Volver
            </a>

        </div>

        <?php if ($estaFacturada): ?>

            <div class="confirmacion">

                <p>
                    Esta cita ya está facturada.
                </p>

                <strong>
                    Estado: FACTURADA
                </strong>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
