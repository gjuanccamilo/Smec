<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* Verificar que el usuario haya iniciado sesión */
if (!isset($_SESSION['id'])) {
    die("Debe iniciar sesión para guardar la factura.");
}

/* Verificar que existan productos en el carrito */
if (!isset($_SESSION['productos']) || empty($_SESSION['productos'])) {
    die("El carrito de compras está vacío.");
}

/* Verificar que exista el número de factura */
if (!isset($_SESSION['numero_factura'])) {
    die("No existe un número de factura para guardar.");
}

$cedula = $_SESSION['id'];
$productos = $_SESSION['productos'];
$numeroFactura = $_SESSION['numero_factura'];

try {

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

    /* Iniciar la transacción */
    $conn->beginTransaction();

    /* Buscar la dirección del cliente */
    $sqlCliente = "SELECT direccion
                   FROM persona
                   WHERE identificacion = :cedula";

    $stmtCliente = $conn->prepare($sqlCliente);
    $stmtCliente->bindParam(':cedula', $cedula);
    $stmtCliente->execute();

    $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        throw new Exception("El cliente no existe.");
    }

    /* Evitar guardar dos veces la misma factura */
    $sqlExiste = "SELECT COUNT(*)
                  FROM factura
                  WHERE no_factura  = :id_factura";

    $stmtExiste = $conn->prepare($sqlExiste);
    $stmtExiste->bindParam(':id_factura', $numeroFactura);
    $stmtExiste->execute();

    if ($stmtExiste->fetchColumn() > 0) {
        throw new Exception("La factura ya fue guardada.");
    }

    /* Guardar el encabezado de la factura */
    $sqlEncabezado = "INSERT INTO factura
                      (no_factura , cliente, fecha)
                      VALUES
                      (:no_factura, :cliente, NOW())";

    $stmtEncabezado = $conn->prepare($sqlEncabezado);

    $stmtEncabezado->bindParam(
        ':no_factura',
        $numeroFactura
    );

    $stmtEncabezado->bindParam(
        ':cliente',
        $cedula
    );

   

    $stmtEncabezado->execute();

    /* Preparar el INSERT del detalle */
    $sqlDetalle = "INSERT INTO detalle_factura
                   (cod_factura, cod_producto_servicio, cantidad,
                    valor_unitario, subtotal)
                   VALUES
                   (:cod_factura, :cod_producto_servicio, :cantidad,
                    :valor_unitario, :subtotal)";

    $stmtDetalle = $conn->prepare($sqlDetalle);

    /* Guardar cada producto del carrito */
    foreach ($productos as $producto) {

        $codigo = $producto['codigo'];
        $cantidad = $producto['qty'];
        $valorUnitario = $producto['price'];
        $subtotal = $valorUnitario * $cantidad;

        $stmtDetalle->execute([
            ':cod_factura' => $numeroFactura,
            ':cod_producto_servicio' => $codigo,
            ':cantidad' => $cantidad,
            ':valor_unitario' => $valorUnitario,
            ':subtotal' => $subtotal
        ]);
    }

    /* Confirmar todos los INSERT */
    $conn->commit();

    header("Location: factura_kitty_guardada.php?");
    exit();

} catch (Exception $e) {

    /* Deshacer todo si ocurre un error */
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }

    echo "Error al guardar la factura: " . $e->getMessage();
}

?>
