<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* Verificar que el usuario haya iniciado sesión */
if (!isset($_SESSION['id'])) {
   // die("Debe iniciar sesión para generar la factura.");
    $_SESSION['factura']= 1;
    header("Location:usuypass2.php");
}
else{
     $_SESSION['factura']= 0;
}

/* Verificar que existan productos en el carrito */
if (
    !isset($_SESSION['productos']) ||
    empty($_SESSION['productos'])
) {
    die("El carrito de compras está vacío.");
}


/* Conexión a la base de datos */
$conn = new PDO(
    "mysql:host=localhost;dbname=bd_glow_smec;charset=utf8",
    "root",
    ""
);

$conn->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);


/*
La variable de sesión id contiene la cédula
del usuario que inició sesión.
*/
$cedula = $_SESSION['id'];


/* Buscar los datos del cliente */
$query = "SELECT identificacion, nombres, direccion, telefono, correo
          FROM persona
          WHERE identificacion = :cedula";

$stmt = $conn->prepare($query);
$stmt->bindParam(':cedula', $cedula);
$stmt->execute();

$cliente = $stmt->fetch(PDO::FETCH_ASSOC);


/* Verificar que el cliente exista */
if (!$cliente) {
    die("No se encontraron los datos del usuario.");
}


/* Obtener los productos del carrito */
$productos = $_SESSION['productos'];


/* Calcular el total */
$total = 0;

foreach ($productos as $producto) {

    $subtotal = $producto['price'] * $producto['qty'];

    $total = $total + $subtotal;
}


/* Datos generales de la factura */
$fecha = date("d/m/Y");

$numeroFactura = $_SESSION['numero_factura'];


/*
Generar PDF cuando la dirección contenga:

factura_kitty.php?pdf=1
*/
if (isset($_GET['pdf']) && $_GET['pdf'] == 1) {

    require_once("fpdf/fpdf.php");


    /*
    Función sencilla para mostrar tildes y caracteres
    especiales dentro del PDF.
    */
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


    /* Título */
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
        textoPDF('FACTURA DE COMPRA'),
        0,
        1,
        'C'
    );


    $pdf->Ln(5);


    /* Información de la factura */
    $pdf->SetFont('Arial', '', 11);

    $pdf->Cell(
        95,
        7,
        textoPDF('Factura No: ' . $numeroFactura),
        0,
        0
    );

    $pdf->Cell(
        95,
        7,
        textoPDF('Fecha: ' . $fecha),
        0,
        1,
        'R'
    );


    $pdf->Ln(5);


    /* Información del cliente */
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
        textoPDF('Cédula: ' . $cliente['identificacion']),
        0,
        1
    );

    $pdf->Cell(
        0,
        7,
        textoPDF('Nombre: ' . $cliente['nombres']),
        0,
        1
    );

    $pdf->Cell(
        0,
        7,
        textoPDF('Dirección: ' . $cliente['direccion']),
        0,
        1
    );

    $pdf->Cell(
        0,
        7,
        textoPDF('Teléfono: ' . $cliente['telefono']),
        0,
        1
    );

    $pdf->Cell(
        0,
        7,
        textoPDF('Correo: ' . $cliente['correo']),
        0,
        1
    );


    $pdf->Ln(7);


    /* Encabezado de los productos */
    $pdf->SetFont('Arial', 'B', 10);

    $pdf->Cell(25, 9, textoPDF('Código'), 1, 0, 'C');

    $pdf->Cell(70, 9, textoPDF('Producto'), 1, 0, 'C');

    $pdf->Cell(30, 9, textoPDF('Precio'), 1, 0, 'C');

    $pdf->Cell(25, 9, textoPDF('Cantidad'), 1, 0, 'C');

    $pdf->Cell(35, 9, textoPDF('Subtotal'), 1, 1, 'C');


    /* Productos */
    $pdf->SetFont('Arial', '', 9);

    foreach ($productos as $producto) {

        $subtotal = $producto['price'] * $producto['qty'];

        $pdf->Cell(
            25,
            9,
            textoPDF($producto['codigo']),
            1,
            0,
            'C'
        );

        $pdf->Cell(
            70,
            9,
            textoPDF(substr($producto['name'], 0, 35)),
            1,
            0
        );

        $pdf->Cell(
            30,
            9,
            '$ ' . number_format(
                $producto['price'],
                0,
                ',',
                '.'
            ),
            1,
            0,
            'R'
        );

        $pdf->Cell(
            25,
            9,
            $producto['qty'],
            1,
            0,
            'C'
        );

        $pdf->Cell(
            35,
            9,
            '$ ' . number_format(
                $subtotal,
                0,
                ',',
                '.'
            ),
            1,
            1,
            'R'
        );
    }


    /* Total */
    $pdf->SetFont('Arial', 'B', 11);

    $pdf->Cell(
        150,
        10,
        textoPDF('TOTAL A PAGAR'),
        1,
        0,
        'R'
    );

    $pdf->Cell(
        35,
        10,
        '$ ' . number_format(
            $total,
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


    /*
    La letra I muestra el PDF en el navegador.

    Para descargarlo directamente, cambia I por D.
    */
    $pdf->Output(
        'I',
        'factura_' . $numeroFactura . '.pdf'
    );

    exit();
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Factura de compra</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap');

:root {
    --color-primary: #D45B7A;
    --color-primary-dark: #B84362;
    --color-primary-light: #FBE2E8;
    --color-dark: #0B0B0C;
    --color-text: #1C1C1C;
    --color-bg-page: #F8F8F9;
    --color-bg-card: #FFFFFF;
    --color-border: rgba(212, 91, 122, 0.15);
    --font-heading: 'Playfair Display', 'Didot', serif;
    --font-body: 'Montserrat', 'Helvetica Neue', sans-serif;
    --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.04);
    --shadow-md: 0 8px 25px rgba(11, 11, 12, 0.05);
    --shadow-hover: 0 6px 18px rgba(212, 91, 122, 0.25);
    --border-radius-sm: 8px;
    --border-radius-md: 16px;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: var(--color-bg-page);
    font-family: var(--font-body);
    color: var(--color-text);
    min-height: 100vh;
}

header {
    background-color: var(--color-dark);
    color: #FFFFFF;
    padding: 15px 30px;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    border-bottom: 3px solid var(--color-primary);
    box-shadow: var(--shadow-sm);
}

.logo-glowsmec {
    grid-column: 1;
    display: flex;
    align-items: center;
}

.logo-glowsmec a {
    font-family: var(--font-heading);
    font-size: 1.6rem;
    font-weight: 600;
    color: #FFFFFF;
    text-decoration: none;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.logo-glowsmec a span {
    color: var(--color-primary);
}

header h1 {
    grid-column: 2;
    font-family: var(--font-heading);
    font-size: 1.5rem;
    font-weight: 500;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #FFFFFF;
    margin: 0;
    text-align: center;
}

.factura {
    width: 900px;
    max-width: 90%;
    margin: 40px auto;
    background-color: var(--color-bg-card);
    padding: 35px;
    border: 1px solid var(--color-border);
    border-radius: var(--border-radius-md);
    box-shadow: var(--shadow-md);
}

.datos-factura {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--color-primary-light);
    font-size: 15px;
    color: var(--color-text);
}

.datos-factura div:first-child strong {
    font-family: var(--font-heading);
    font-size: 22px;
    color: var(--color-primary);
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.datos-factura div:last-child {
    text-align: right;
    line-height: 1.5;
}

.datos-cliente {
    background-color: var(--color-primary-light);
    padding: 20px 25px;
    margin-bottom: 30px;
    border-radius: var(--border-radius-sm);
    border-left: 4px solid var(--color-primary);
}

.datos-cliente h3 {
    margin-top: 0;
    margin-bottom: 12px;
    font-family: var(--font-heading);
    color: var(--color-dark);
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.datos-cliente p {
    margin: 6px 0;
    font-size: 14px;
    color: var(--color-text);
}

.datos-cliente p strong {
    font-family: var(--font-heading);
    color: var(--color-dark);
    display: inline-block;
    width: 95px;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-bottom: 25px;
    overflow: hidden;
    border-radius: var(--border-radius-sm);
    border: 1px solid var(--color-border);
}

th {
    background-color: var(--color-dark);
    color: #FFFFFF;
    font-family: var(--font-heading);
    padding: 12px 15px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
}

td {
    padding: 14px 15px;
    border-bottom: 1px solid var(--color-border);
    font-size: 14px;
    color: var(--color-text);
    text-align: center;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr:nth-child(even) {
    background-color: #FAF8F9;
}

tbody tr:hover {
    background-color: var(--color-primary-light);
}

.total {
    text-align: right;
    font-size: 20px;
    font-weight: 600;
    margin-top: 25px;
    padding-top: 15px;
    color: var(--color-dark);
    border-top: 2px dashed var(--color-border);
}

.total strong {
    font-family: var(--font-heading);
    color: var(--color-primary);
}

.botones {
    text-align: center;
    margin-top: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.boton {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    background-color: var(--color-dark);
    color: #FFFFFF !important;
    text-decoration: none;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    box-shadow: var(--shadow-sm);
}

.boton:hover {
    background-color: var(--color-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.boton-pdf {
    background-color: var(--color-primary);
}

.boton-pdf:hover {
    background-color: var(--color-primary-dark);
}

@media (max-width: 650px) {
    header {
        grid-template-columns: 1fr;
        gap: 10px;
        text-align: center;
    }

    .logo-glowsmec, header h1 {
        grid-column: 1;
        justify-content: center;
    }

    .factura {
        padding: 20px;
    }
    
    .datos-factura {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .datos-factura div:last-child {
        text-align: left;
    }

    .botones {
        flex-direction: column;
    }

    .boton, form {
        width: 100%;
    }

    button.boton {
        width: 100%;
    }
}

    </style>
</head>


<body>

<header>
    
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>
    <h1>Factura de Compra</h1>

</header>


<div class="factura">

    <div class="datos-factura">

        <div>
            <strong>GlowSmec</strong>
        </div>

        <div>
            <strong>
                Factura No:
                <?php echo $numeroFactura; ?>
            </strong>

            <br>

            Fecha:
            <?php echo $fecha; ?>
        </div>

    </div>


    <div class="datos-cliente">

        <h3>Datos del cliente</h3>

        <p>
            <strong>Cédula:</strong>

            <?php
            echo htmlspecialchars($cliente['identificacion']);
            ?>
        </p>

        <p>
            <strong>Nombre:</strong>

            <?php
            echo htmlspecialchars($cliente['nombres']);
            ?>
        </p>

        <p>
            <strong>Dirección:</strong>

            <?php
            echo htmlspecialchars($cliente['direccion']);
            ?>
        </p>

        <p>
            <strong>Teléfono:</strong>

            <?php
            echo htmlspecialchars($cliente['telefono']);
            ?>
        </p>

        <p>
            <strong>Correo:</strong>

            <?php
            echo htmlspecialchars($cliente['correo']);
            ?>
        </p>

    </div>


    <table>

        <thead>

            <tr>

                <th>Código</th>

                <th>Producto</th>

                <th>Precio</th>

                <th>Cantidad</th>

                <th>Subtotal</th>

            </tr>

        </thead>

        <tbody>

        <?php foreach ($productos as $producto): ?>

            <?php

            $subtotal =
                $producto['price'] *
                $producto['qty'];

            ?>

            <tr>

                <td>
                    <?php
                    echo htmlspecialchars(
                        $producto['codigo']
                    );
                    ?>
                </td>

                <td>
                    <?php
                    echo htmlspecialchars(
                        $producto['name']
                    );
                    ?>
                </td>

                <td>
                    $
                    <?php
                    echo number_format(
                        $producto['price'],
                        0,
                        ',',
                        '.'
                    );
                    ?>
                </td>

                <td>
                    <?php
                    echo $producto['qty'];
                    ?>
                </td>

                <td>
                    $
                    <?php
                    echo number_format(
                        $subtotal,
                        0,
                        ',',
                        '.'
                    );
                    ?>
                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>


    <div class="total">

        <strong>
            Total a pagar:
            $
            <?php
            echo number_format(
                $total,
                0,
                ',',
                '.'
            );
            ?>
        </strong>

    </div>


    <div class="botones">

        <a href="carrito1_kitty.php"
              class="boton">
             <?php $_SESSION['carrito']= "vaciarcarrito"; ?>
            Volver al carrito

        </a>

        <a href="factura_kitty.php?pdf=1"
           class="boton boton-pdf"
           target="_blank">

            Generar PDF

        </a>

          

        </form>

    </div>

</div>

</body>

</html>