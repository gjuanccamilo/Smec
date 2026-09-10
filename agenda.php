
<?php

session_start();

/* ==========================================================
   1. VERIFICAR QUE EL USUARIO HAYA INICIADO SESIÓN
   ========================================================== */

if (!isset($_SESSION['id'])) {

    header("Location: usuypass2.php");
    exit();

}


/* ==========================================================
   2. CONEXIÓN A LA BASE DE DATOS
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
   3. BUSCAR LA PERSONA DE LA SESIÓN
   ========================================================== */

$sqlUsuario = "

    SELECT
        p.identificacion,
        p.nombres,
        p.apellidos,
        p.correo,
        p.fecha_nacimiento,
        p.tipo_persona,
        p.ciudad_nacimiento,
        p.genero

    FROM persona p

    WHERE p.identificacion = :identificacion

";


$stmtUsuario = $conexion->prepare($sqlUsuario);

$stmtUsuario->execute([
    ":identificacion" => $_SESSION['id']
]);


$usuarioSesion = $stmtUsuario->fetch(PDO::FETCH_ASSOC);


/* ==========================================================
   4. SI NO EXISTE LA PERSONA
   ========================================================== */

if (!$usuarioSesion) {

    session_destroy();

    header("Location: usuypass2.php");
    exit();

}


/* ==========================================================
   5. GUARDAR DATOS IMPORTANTES EN SESIÓN
   ========================================================== */

$_SESSION['tipo_usuario'] =
    $usuarioSesion['tipo_persona'];

$_SESSION['usuario'] =
    $usuarioSesion['nombres'];

$_SESSION['correo'] =
    $usuarioSesion['correo'];


/* ==========================================================
   6. VARIABLES PARA MENSAJES
   ========================================================== */

$mensaje = "";

$error = "";


/* ==========================================================
   7. PROCESAR LA CITA
   ========================================================== */

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    /* ------------------------------------------------------
       COMO EL CLIENTE YA TIENE SUS DATOS EN LA BD,
       LOS TOMAMOS DIRECTAMENTE DE LA PERSONA.
       ------------------------------------------------------ */

    $identificacion =
        $usuarioSesion['identificacion'];

    $nombres =
        $usuarioSesion['nombres'];

    $apellidos =
        $usuarioSesion['apellidos'];

    $correo =
        $usuarioSesion['correo'];

    $fecha_nacimiento =
        $usuarioSesion['fecha_nacimiento'];

    $genero =
        $usuarioSesion['genero'];

    $ciudad_nacimiento =
        $usuarioSesion['ciudad_nacimiento'];


    /* ------------------------------------------------------
       DATOS QUE REALMENTE SE PIDEN PARA LA CITA
       ------------------------------------------------------ */

    $fecha_cita =
        $_POST['fecha_cita'] ?? "";

    $hora_cita =
        $_POST['hora_cita'] ?? "";

    $servicio =
        $_POST['servicio'] ?? "";

    $observaciones =
        trim($_POST['observaciones'] ?? "");


    /* ------------------------------------------------------
       VALIDAR DATOS
       ------------------------------------------------------ */

    if (
        empty($fecha_cita) ||
        empty($hora_cita) ||
        empty($servicio)
    ) {

        $error =
            "Debe seleccionar servicio, fecha y hora.";

    } else {


        try {


            /* ==================================================
               INICIAR TRANSACCIÓN
               ================================================== */

            $conexion->beginTransaction();


            /* ==================================================
               8. VERIFICAR QUE EL SERVICIO EXISTA
               Y QUE SEA TIPO S
               ================================================== */

            $sqlServicio = "

                SELECT
                    cod_prod_ser,
                    descripcion,
                    precio

                FROM producto_servicio

                WHERE cod_prod_ser = :servicio

                AND tipo_prod_ser = 'S'

            ";


            $stmtServicio =
                $conexion->prepare($sqlServicio);


            $stmtServicio->execute([
                ":servicio" => $servicio
            ]);


            $servicioExiste =
                $stmtServicio->fetch(PDO::FETCH_ASSOC);


            if (!$servicioExiste) {

                throw new Exception(
                    "El servicio seleccionado no existe."
                );

            }


            /* ==================================================
               9. VERIFICAR SI YA EXISTE CITA
               PARA ESA FECHA Y HORA
               ================================================== */

            $sqlVerificarCita = "

                SELECT id

                FROM cita

                WHERE fecha = :fecha

                AND hora = :hora

            ";


            $stmtVerificarCita =
                $conexion->prepare(
                    $sqlVerificarCita
                );


            $stmtVerificarCita->execute([

                ":fecha" =>
                    $fecha_cita,

                ":hora" =>
                    $hora_cita

            ]);


            $citaExistente =
                $stmtVerificarCita->fetch(
                    PDO::FETCH_ASSOC
                );


            if ($citaExistente) {

                throw new Exception(
                    "Ya existe una cita para esa fecha y hora."
                );

            }


            /* ==================================================
               10. CREAR LA CITA
               ================================================== */

            $sqlCita = "

                INSERT INTO cita
                (
                    identificacion,
                    fecha,
                    hora,
                    servicio,
                    observaciones,
                    estatus
                )

                VALUES
                (
                    :identificacion,
                    :fecha,
                    :hora,
                    :servicio,
                    :observaciones,
                    1
                )

            ";


            $stmtCita =
                $conexion->prepare($sqlCita);


            $stmtCita->execute([

                ":identificacion" =>
                    $identificacion,

                ":fecha" =>
                    $fecha_cita,

                ":hora" =>
                    $hora_cita,

                ":servicio" =>
                    $servicio,

                ":observaciones" =>
                    $observaciones

            ]);


            $idCita =
                $conexion->lastInsertId();


            /* ==================================================
               11. CONFIRMAR
               ================================================== */

            $conexion->commit();


            $mensaje =
                "¡Cita agendada correctamente! "
                . "Número de cita: "
                . $idCita;


        } catch (Exception $e) {


            /* --------------------------------------------------
               CANCELAR SI HUBO ERROR
               -------------------------------------------------- */

            if (
                $conexion->inTransaction()
            ) {

                $conexion->rollBack();

            }


            $error =
                $e->getMessage();

        }

    }

}


/* ==========================================================
   12. CONSULTAR CIUDADES
   ========================================================== */

$sqlCiudades = "

    SELECT
        cod_ciudad,
        descripcion

    FROM ciudad

    ORDER BY descripcion ASC

";


$stmtCiudades =
    $conexion->prepare($sqlCiudades);

$stmtCiudades->execute();

$ciudades =
    $stmtCiudades->fetchAll(
        PDO::FETCH_ASSOC
    );


/* ==========================================================
   13. CONSULTAR GÉNEROS
   ========================================================== */

$sqlGeneros = "

    SELECT
        cod_genero,
        descripcion

    FROM genero

    ORDER BY descripcion ASC

";


$stmtGeneros =
    $conexion->prepare($sqlGeneros);

$stmtGeneros->execute();

$generos =
    $stmtGeneros->fetchAll(
        PDO::FETCH_ASSOC
    );


/* ==========================================================
   14. CONSULTAR SERVICIOS
   SOLO LOS DE TIPO S
   ========================================================== */

$sqlServicios = "

    SELECT
        cod_prod_ser,
        descripcion,
        precio

    FROM producto_servicio

    WHERE tipo_prod_ser = 'S'

    ORDER BY descripcion ASC

";


$stmtServicios =
    $conexion->prepare($sqlServicios);

$stmtServicios->execute();

$servicios =
    $stmtServicios->fetchAll(
        PDO::FETCH_ASSOC
    );


/* ==========================================================
   15. CONSULTAR CITAS
   ========================================================== */

if (
    $_SESSION['tipo_usuario'] == '01'
) {


    /* ======================================================
       ADMINISTRADOR
       TODAS LAS CITAS
       ====================================================== */

    $sqlCitas = "

        SELECT

            c.id,

            c.identificacion,

            p.nombres,

            p.apellidos,

            p.correo,

            p.fecha_nacimiento,

            p.genero,

            p.ciudad_nacimiento,

            c.fecha,

            c.hora,

            c.servicio,

            c.observaciones,

            c.estatus,

            ps.descripcion AS nombre_servicio,

            ps.precio,

            ci.descripcion AS nombre_ciudad,

            g.descripcion AS nombre_genero

        FROM cita c

        INNER JOIN persona p

            ON c.identificacion =
               p.identificacion

        INNER JOIN producto_servicio ps

            ON c.servicio =
               ps.cod_prod_ser

        LEFT JOIN ciudad ci

            ON p.ciudad_nacimiento =
               ci.cod_ciudad

        LEFT JOIN genero g

            ON p.genero =
               g.cod_genero

        ORDER BY
            c.fecha ASC,
            c.hora ASC

    ";


    $stmtCitas =
        $conexion->prepare($sqlCitas);

    $stmtCitas->execute();


} else {


    /* ======================================================
       CLIENTE
       SOLO SUS CITAS
       ====================================================== */

    $sqlCitas = "

        SELECT

            c.id,

            c.identificacion,

            p.nombres,

            p.apellidos,

            p.correo,

            p.fecha_nacimiento,

            p.genero,

            p.ciudad_nacimiento,

            c.fecha,

            c.hora,

            c.servicio,

            c.observaciones,

            c.estatus,

            ps.descripcion AS nombre_servicio,

            ps.precio,

            ci.descripcion AS nombre_ciudad,

            g.descripcion AS nombre_genero

        FROM cita c

        INNER JOIN persona p

            ON c.identificacion =
               p.identificacion

        INNER JOIN producto_servicio ps

            ON c.servicio =
               ps.cod_prod_ser

        LEFT JOIN ciudad ci

            ON p.ciudad_nacimiento =
               ci.cod_ciudad

        LEFT JOIN genero g

            ON p.genero =
               g.cod_genero

        WHERE c.identificacion =
              :identificacion

        ORDER BY
            c.fecha ASC,
            c.hora ASC

    ";


    $stmtCitas =
        $conexion->prepare($sqlCitas);


    $stmtCitas->execute([

        ":identificacion" =>
            $_SESSION['id']

    ]);

}


$citas =
    $stmtCitas->fetchAll(
        PDO::FETCH_ASSOC
    );

?>


<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Agendar Cita
    </title>


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

            max-width: 1250px;

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


        .encabezado {

            background: #121214;

            color: white;

            padding: 30px;

            border-radius: 16px;

            margin-bottom: 25px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,.12);

        }


        .encabezado h1 {

            color: #D45B7A;

            margin-bottom: 10px;

        }


        .encabezado p {

            color: #ddd;

        }


        .usuario {

            margin-top: 18px;

            color: #ddd;

        }


        .usuario strong {

            color: #D45B7A;

        }


        .rol {

            background: #D45B7A;

            color: white;

            padding: 5px 10px;

            border-radius: 20px;

            font-weight: bold;

        }


        .formulario {

            background: white;

            padding: 30px;

            border-radius: 16px;

            margin-bottom: 30px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,.07);

        }


        .titulo {

            color: #121214;

            border-bottom:
                2px solid #D45B7A;

            padding-bottom: 10px;

            margin-bottom: 20px;

        }


        .grupo {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 18px;

        }


        .campo {

            display: flex;

            flex-direction: column;

        }


        .completo {

            grid-column: 1 / -1;

        }


        label {

            font-weight: bold;

            margin-bottom: 7px;

        }


        input,
        select,
        textarea {

            width: 100%;

            padding: 12px;

            border: 1px solid #ddd;

            border-radius: 8px;

            font-size: 14px;

            background: white;

        }


        input[readonly],
        select:disabled {

            background: #f3f3f3;

            color: #555;

            cursor: not-allowed;

        }


        textarea {

            min-height: 100px;

            resize: vertical;

        }


        .separador {

            border: 0;

            border-top:
                1px solid #eee;

            margin: 30px 0;

        }


        .boton {

            width: 100%;

            border: none;

            padding: 14px;

            background: #D45B7A;

            color: white;

            border-radius: 8px;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            margin-top: 20px;

        }


        .boton:hover {

            background: #121214;

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


        .tabla {

            background: white;

            padding: 25px;

            border-radius: 16px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,.07);

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 1000px;

        }


        th {

            background: #121214;

            color: white;

            padding: 12px;

            text-align: left;

        }


        td {

            padding: 12px;

            border-bottom:
                1px solid #eee;

        }


        tr:hover {

            background: #fdf0f3;

        }


        .texto-ayuda {

            color: #777;

            font-size: 13px;

            margin-bottom: 20px;

        }



        .estado {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .estado-facturada {
            background: #d4edda;
            color: #155724;
        }

        .boton-factura {
            display: inline-block;
            background: #121214;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        .boton-factura:hover {
            background: #D45B7A;
        }

        @media(max-width:700px) {

            body {

                padding: 15px;

            }


            .grupo {

                grid-template-columns: 1fr;

            }


            .completo {

                grid-column: auto;

            }

        }

    </style>

</head>


<body>


<div class="contenedor">


    <!-- ==================================================
         VOLVER
         ================================================== -->

    <a
        href="inicio.php"
        class="volver"
    >

        ← Volver al inicio

    </a>


    <!-- ==================================================
         ENCABEZADO
         ================================================== -->

    <div class="encabezado">

        <h1>
            Agenda de Citas
        </h1>

        <p>
            Agenda tu servicio de manera rápida y sencilla.
        </p>


        <div class="usuario">

            Usuario:

            <strong>

                <?php

                echo htmlspecialchars(
                    $usuarioSesion['nombres']
                    . " "
                    . $usuarioSesion['apellidos']
                );

                ?>

            </strong>


            &nbsp; | &nbsp;


            Identificación:

            <strong>

                <?php

                echo htmlspecialchars(
                    $usuarioSesion['identificacion']
                );

                ?>

            </strong>


            &nbsp; | &nbsp;


            Rol:

            <span class="rol">

                <?php

                if (
                    $_SESSION['tipo_usuario']
                    == '01'
                ) {

                    echo "Administrador";

                } else {

                    echo "Cliente";

                }

                ?>

            </span>

        </div>

    </div>


    <!-- ==================================================
         MENSAJES
         ================================================== -->

    <?php if (!empty($mensaje)): ?>

        <div class="mensaje">

            <?php

            echo htmlspecialchars(
                $mensaje
            );

            ?>

        </div>

    <?php endif; ?>


    <?php if (!empty($error)): ?>

        <div class="error">

            <?php

            echo htmlspecialchars(
                $error
            );

            ?>

        </div>

    <?php endif; ?>


    <!-- ==================================================
         FORMULARIO
         ================================================== -->

    <div class="formulario">


        <h2 class="titulo">

            Datos del cliente

        </h2>


        <p class="texto-ayuda">

            Tus datos personales se cargan automáticamente
            desde tu cuenta.

        </p>


        <form
            method="POST"
            action="agenda.php"
        >


            <div class="grupo">


                <!-- IDENTIFICACIÓN -->

                <div class="campo">

                    <label>
                        Identificación
                    </label>


                    <input
                        type="text"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'identificacion'
                            ]
                        );

                        ?>"
                        readonly
                    >


                    <input
                        type="hidden"
                        name="identificacion"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'identificacion'
                            ]
                        );

                        ?>"
                    >

                </div>


                <!-- NOMBRES -->

                <div class="campo">

                    <label>
                        Nombres
                    </label>


                    <input
                        type="text"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'nombres'
                            ]
                        );

                        ?>"
                        readonly
                    >


                    <input
                        type="hidden"
                        name="nombres"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'nombres'
                            ]
                        );

                        ?>"
                    >

                </div>


                <!-- APELLIDOS -->

                <div class="campo">

                    <label>
                        Apellidos
                    </label>


                    <input
                        type="text"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'apellidos'
                            ]
                        );

                        ?>"
                        readonly
                    >


                    <input
                        type="hidden"
                        name="apellidos"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'apellidos'
                            ]
                        );

                        ?>"
                    >

                </div>


                <!-- CORREO -->

                <div class="campo">

                    <label>
                        Correo electrónico
                    </label>


                    <input
                        type="email"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'correo'
                            ]
                        );

                        ?>"
                        readonly
                    >


                    <input
                        type="hidden"
                        name="correo"
                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'correo'
                            ]
                        );

                        ?>"
                    >

                </div>


                <!-- FECHA NACIMIENTO -->

                <div class="campo">

                    <label>
                        Fecha de nacimiento
                    </label>


                    <input
                        type="date"

                        value="<?php

                        if (
                            !empty(
                                $usuarioSesion[
                                    'fecha_nacimiento'
                                ]
                            )
                        ) {

                            echo date(
                                "Y-m-d",
                                strtotime(
                                    $usuarioSesion[
                                        'fecha_nacimiento'
                                    ]
                                )
                            );

                        }

                        ?>"

                        readonly
                    >


                    <input
                        type="hidden"
                        name="fecha_nacimiento"

                        value="<?php

                        if (
                            !empty(
                                $usuarioSesion[
                                    'fecha_nacimiento'
                                ]
                            )
                        ) {

                            echo date(
                                "Y-m-d",
                                strtotime(
                                    $usuarioSesion[
                                        'fecha_nacimiento'
                                    ]
                                )
                            );

                        }

                        ?>"
                    >

                </div>


                <!-- GÉNERO -->

                <div class="campo">

                    <label>
                        Género
                    </label>


                    <select disabled>


                        <?php foreach (
                            $generos
                            as $genero
                        ): ?>


                            <option

                                value="<?php

                                echo htmlspecialchars(
                                    $genero[
                                        'cod_genero'
                                    ]
                                );

                                ?>"

                                <?php

                                if (
                                    $genero[
                                        'cod_genero'
                                    ]
                                    ==
                                    $usuarioSesion[
                                        'genero'
                                    ]
                                ) {

                                    echo "selected";

                                }

                                ?>

                            >

                                <?php

                                echo htmlspecialchars(
                                    $genero[
                                        'descripcion'
                                    ]
                                );

                                ?>

                            </option>


                        <?php endforeach; ?>


                    </select>


                    <input
                        type="hidden"
                        name="genero"

                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'genero'
                            ]
                        );

                        ?>"
                    >

                </div>


                <!-- CIUDAD -->

                <div class="campo">

                    <label>
                        Ciudad de nacimiento
                    </label>


                    <select disabled>


                        <?php foreach (
                            $ciudades
                            as $ciudad
                        ): ?>


                            <option

                                value="<?php

                                echo htmlspecialchars(
                                    $ciudad[
                                        'cod_ciudad'
                                    ]
                                );

                                ?>"

                                <?php

                                if (
                                    $ciudad[
                                        'cod_ciudad'
                                    ]
                                    ==
                                    $usuarioSesion[
                                        'ciudad_nacimiento'
                                    ]
                                ) {

                                    echo "selected";

                                }

                                ?>

                            >

                                <?php

                                echo htmlspecialchars(
                                    $ciudad[
                                        'descripcion'
                                    ]
                                );

                                ?>

                            </option>


                        <?php endforeach; ?>


                    </select>


                    <input
                        type="hidden"
                        name="ciudad_nacimiento"

                        value="<?php

                        echo htmlspecialchars(
                            $usuarioSesion[
                                'ciudad_nacimiento'
                            ]
                        );

                        ?>"
                    >

                </div>


            </div>


            <hr class="separador">


            <!-- ==================================================
                 DATOS DE LA CITA
                 ================================================== -->

            <h2 class="titulo">

                Datos de la cita

            </h2>


            <p class="texto-ayuda">

                Selecciona únicamente el servicio, la fecha
                y la hora que deseas.

            </p>


            <div class="grupo">


                <!-- SERVICIO -->

                <div class="campo completo">

                    <label for="servicio">

                        Servicio *

                    </label>


                    <select
                        id="servicio"
                        name="servicio"
                        required
                    >

                        <option value="">

                            Seleccione un servicio

                        </option>


                        <?php foreach (
                            $servicios
                            as $servicio
                        ): ?>


                            <option
                                value="<?php

                                echo htmlspecialchars(
                                    $servicio[
                                        'cod_prod_ser'
                                    ]
                                );

                                ?>"
                            >

                                <?php

                                echo htmlspecialchars(
                                    $servicio[
                                        'descripcion'
                                    ]
                                );

                                ?>

                                -

                                $

                                <?php

                                echo number_format(
                                    $servicio[
                                        'precio'
                                    ],
                                    0,
                                    ",",
                                    "."
                                );

                                ?>

                            </option>


                        <?php endforeach; ?>


                    </select>

                </div>


                <!-- FECHA -->

                <div class="campo">

                    <label for="fecha_cita">

                        Fecha de la cita *

                    </label>


                    <input
                        type="date"
                        id="fecha_cita"
                        name="fecha_cita"

                        min="<?php
                            echo date("Y-m-d");
                        ?>"

                        required
                    >

                </div>


                <!-- HORA -->

                <div class="campo">

                    <label for="hora_cita">

                        Hora de la cita *

                    </label>


                    <input
                        type="time"
                        id="hora_cita"
                        name="hora_cita"
                        required
                    >

                </div>


                <!-- OBSERVACIONES -->

                <div class="campo completo">

                    <label for="observaciones">

                        Observaciones

                    </label>


                    <textarea
                        id="observaciones"
                        name="observaciones"
                        placeholder="Escribe alguna observación..."
                    ></textarea>

                </div>


            </div>


            <button
                type="submit"
                class="boton"
            >

                📅 Agendar cita

            </button>


        </form>

    </div>


    <!-- ==================================================
         LISTADO DE CITAS
         ================================================== -->

    <div class="tabla">


        <?php if (
            $_SESSION['tipo_usuario']
            == '01'
        ): ?>


            <h2 class="titulo">

                Todas las citas agendadas

            </h2>


        <?php else: ?>


            <h2 class="titulo">

                Mis citas

            </h2>


        <?php endif; ?>


        <?php if (
            count($citas) > 0
        ): ?>


            <table>

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Identificación
                        </th>

                        <th>
                            Cliente
                        </th>

                        <th>
                            Correo
                        </th>

                        <th>
                            Fecha
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

                        <th>
                            Ciudad
                        </th>

                        <th>
                            Género
                        </th>

                        <th>
                            Observaciones
                        </th>

                        <th>
                            Estado factura
                        </th>

                        <?php if ($_SESSION['tipo_usuario'] == '01'): ?>
                        <th>
                            Factura
                        </th>
                        <?php endif; ?>

                    </tr>

                </thead>


                <tbody>


                    <?php foreach (
                        $citas
                        as $cita
                    ): ?>


                        <tr>

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $cita['id']
                                );

                                ?>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $cita[
                                        'identificacion'
                                    ]
                                );

                                ?>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $cita['nombres']
                                    . " "
                                    . $cita['apellidos']
                                );

                                ?>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $cita['correo']
                                );

                                ?>

                            </td>


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
                                    $cita[
                                        'nombre_servicio'
                                    ]
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


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $cita[
                                        'nombre_ciudad'
                                    ] ?? ""
                                );

                                ?>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $cita[
                                        'nombre_genero'
                                    ] ?? ""
                                );

                                ?>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $cita[
                                        'observaciones'
                                    ] ?? ""
                                );

                                ?>

                            </td>

                            <td>

                                <?php if ((int)$cita['estatus'] === 2): ?>

                                    <span class="estado estado-facturada">
                                        Facturada
                                    </span>

                                <?php else: ?>

                                    <span class="estado estado-pendiente">
                                        No facturada
                                    </span>

                                <?php endif; ?>

                            </td>

                            <?php if ($_SESSION['tipo_usuario'] == '01'): ?>

                                <td>

                                    <a
                                        href="factura_kitty.php?id_cita=<?php echo urlencode($cita['id']); ?>"
                                        class="boton-factura"
                                    >
                                        <?php
                                        echo ((int)$cita['estatus'] === 2)
                                            ? 'Ver factura'
                                            : 'Facturar';
                                        ?>
                                    </a>

                                </td>

                            <?php endif; ?>


                        </tr>


                    <?php endforeach; ?>


                </tbody>

            </table>


        <?php else: ?>


            <p>

                No tienes citas agendadas todavía.

            </p>


        <?php endif; ?>


    </div>


</div>


</body>

</html>