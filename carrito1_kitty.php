<?php
session_start();

$total = 0;

// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=bd_glow_smec", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Asegurar que exista el carrito
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

// Traer productos disponibles
$query = "SELECT * FROM producto_servicio";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Acción recibida
$action = $_GET['action'] ?? "";

// Añadir producto
if ($action === "adcarrito" && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'] ?? '';

    $query = "SELECT * FROM producto_servicio WHERE cod_prod_ser = :sku";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sku', $sku);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $currentQty = $_SESSION['productos'][$sku]['qty'] ?? 0;

        $_SESSION['productos'][$sku] = [
            'qty' => $currentQty + 1,
            'name' => $product['descripcion'],
            'image' => $product['foto'],
            'price' => $product['precio'],
            'codigo' => $product['cod_prod_ser']
        ];
    }

    header("Location: carrito1_kitty.php");
    exit;
}

// Aumentar cantidad
if ($action === "sumar") {
    $sku = $_GET['sku'] ?? '';

    if (isset($_SESSION['productos'][$sku])) {
        $_SESSION['productos'][$sku]['qty']++;
    }

    header("Location: carrito1_kitty.php");
    exit;
}

// Disminuir cantidad
if ($action === "restar") {
    $sku = $_GET['sku'] ?? '';

    if (isset($_SESSION['productos'][$sku])) {
        $_SESSION['productos'][$sku]['qty']--;

        if ($_SESSION['productos'][$sku]['qty'] <= 0) {
            unset($_SESSION['productos'][$sku]);
        }
    }

    header("Location: carrito1_kitty.php");
    exit;
}

// Eliminar un producto
if ($action === "empty") {
    $sku = $_GET['sku'] ?? '';

    if (isset($_SESSION['productos'][$sku])) {
        unset($_SESSION['productos'][$sku]);
    }

    header("Location: carrito1_kitty.php");
    exit;
}

// Vaciar carrito
if ($action === "vaciarcarrito") {
    $_SESSION['productos'] = [];
    header("Location: carrito1_kitty.php");
    exit;
}

// Cantidad total de artículos
$cantidadTotal = 0;
foreach ($_SESSION['productos'] as $product) {
    $cantidadTotal += (int)$product['qty'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>

    <style>
        :root {
    --color-primary: #D45B7A;
    --color-primary-light: #FBE2E8;
    --color-dark: #0B0B0C;
    --color-text: #1C1C1C;
    --color-bg-card: #F8F8F9;
    --color-white: #FFFFFF;
    --font-heading: 'Didot', 'Bodoni MT', 'Cinzel', 'Georgia', serif;
    --font-body: 'Montserrat', 'Helvetica Neue', sans-serif;
    --border-elegant: 1px solid rgba(212, 91, 122, 0.15);
}

* {
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    margin: 0;
    font-family: var(--font-body);
    background-color: var(--color-bg-card);
    color: var(--color-text);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    letter-spacing: 0.3px;
}

 header {
        position: sticky;
        top: 0;
        width: 100%;
        padding: 12px 40px;
        background-color: var(--color-dark);
        color: var(--color-white);
        z-index: 1000;
        border-bottom: 2px solid var(--color-primary);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: space-between; /* Mantiene logo a la izquierda y menú a la derecha */
    }

    /* Logo a la izquierda */
    .logo-glowsmec {
        display: flex;
        align-items: center;
    }

    .logo-glowsmec a {
        font-family: var(--font-heading);
        font-size: 1.6rem;
        font-weight: bold;
        color: var(--color-white);
        text-decoration: none;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .logo-glowsmec a span {
        color: var(--color-primary);
    }


.header-actions {
    display: flex;
    align-items: center;
    gap: 14px;
}

.header-btn {
    background-color: transparent;
    color: var(--color-white);
    border: 1px solid rgba(255, 255, 255, 0.25);
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.3s ease;
}

.header-btn:hover {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
    color: var(--color-white);
}

.cart-badge {
    background: var(--color-primary-light);
    color: var(--color-primary);
    border: 1px solid var(--color-primary);
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

main {
    width: min(1180px, 92%);
    margin: 45px auto 80px;
}

.hero {
    margin-bottom: 30px;
}

.hero h1 {
    font-family: var(--font-heading);
    margin: 0 0 8px;
    font-size: 36px;
    font-weight: 400;
    color: var(--color-dark);
    letter-spacing: 2px;
    text-transform: uppercase;
}

.hero p {
    margin: 0;
    color: #777;
    font-size: 14px;
    font-style: italic;
}

.section-title {
    margin: 50px 0 25px;
    border-bottom: 1px solid #EBEBEB;
    padding-bottom: 12px;
}

.section-title h2 {
    font-family: var(--font-heading);
    margin: 0;
    color: var(--color-dark);
    font-size: 26px;
    font-weight: 400;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.cart-card {
    background: var(--color-white);
    border-radius: 6px;
    box-shadow: 0 15px 35px rgba(11, 11, 12, 0.03);
    overflow: hidden;
    margin-bottom: 40px;
    border: var(--border-elegant);
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th {
    background: var(--color-dark);
    color: var(--color-white);
    padding: 18px 12px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 500;
}

.cart-table td {
    padding: 18px 12px;
    text-align: center;
    border-bottom: 1px solid #F0F0F0;
    font-size: 14px;
}

.cart-table tr:last-child td {
    border-bottom: none;
}

.product-thumb {
    width: 70px;
    height: 70px;
    object-fit: contain;
    border-radius: 4px;
    background: var(--color-bg-card);
    padding: 6px;
    border: 1px solid #ECECEC;
}

.product-name {
    font-family: var(--font-heading);
    font-weight: 600;
    font-size: 15px;
    color: var(--color-dark);
}

.price {
    font-weight: 600;
    color: var(--color-primary);
}

.quantity {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 1px solid #E0E0E0;
    padding: 4px 12px;
    border-radius: 4px;
    background: var(--color-white);
}

.quantity a {
    text-decoration: none;
    color: var(--color-dark);
    font-size: 16px;
    font-weight: 600;
    transition: color 0.2s;
}

.quantity a:hover {
    color: var(--color-primary);
}

.quantity span {
    min-width: 20px;
    font-weight: 600;
}

.remove-btn {
    color: #999;
    text-decoration: none;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: color 0.2s;
}

.remove-btn:hover {
    color: var(--color-primary);
}

.cart-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 30px;
    background: #FAFAFA;
    gap: 15px;
    flex-wrap: wrap;
    border-top: var(--border-elegant);
}

.total {
    font-family: var(--font-heading);
    font-size: 22px;
    color: var(--color-primary);
    letter-spacing: 1px;
}

.clear-btn {
    color: #888;
    text-decoration: none;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: color 0.2s;
}

.clear-btn:hover {
    color: var(--color-primary);
}

.checkout-btn {
    display: inline-block;
    background: var(--color-primary);
    color: var(--color-white);
    text-decoration: none;
    padding: 14px 32px;
    border-radius: 4px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.checkout-btn:hover {
    background: #b54763;
    box-shadow: 0 8px 20px rgba(212, 91, 122, 0.25);
}

.empty {
    padding: 60px 20px;
    text-align: center;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 10px;
    opacity: 0.6;
}

.empty h2 {
    font-family: var(--font-heading);
    color: var(--color-dark);
    font-weight: 400;
}

/* Catálogo */
.catalog {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.product-card {
    background: var(--color-white);
    border-radius: 6px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(11, 11, 12, 0.02);
    border: var(--border-elegant);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(212, 91, 122, 0.12);
    border-color: var(--color-primary);
}

.product-image {
    width: 100%;
    height: 190px;
    object-fit: contain;
    background: var(--color-bg-card);
    border-radius: 4px;
    margin-bottom: 18px;
    padding: 12px;
}

.product-code {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #888;
    margin-bottom: 6px;
}

.product-card h3 {
    font-family: var(--font-heading);
    margin: 0 0 10px;
    font-size: 18px;
    font-weight: 600;
    color: var(--color-dark);
    min-height: 44px;
}

.product-price {
    color: var(--color-primary);
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
}

.add-btn {
    width: 100%;
    border: 1px solid var(--color-dark);
    background: transparent;
    color: var(--color-dark);
    padding: 12px;
    border-radius: 4px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: auto;
}

.add-btn:hover {
    background: var(--color-primary);
    border-color: var(--color-primary);
    color: var(--color-white);
    box-shadow: 0 6px 15px rgba(212, 91, 122, 0.25);
}

footer {
    background-color: var(--color-dark);
    color: var(--color-white);
    text-align: center;
    padding: 28px;
    border-top: 1px solid rgba(212, 91, 122, 0.3);
    margin-top: auto;
}

.socials {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
}

.socials a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 12px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    transition: color 0.3s ease;
    padding: 0 8px;
}

.socials a:not(:last-child) {
    border-right: 1px solid rgba(255, 255, 255, 0.15);
}

.socials a:hover {
    color: var(--color-primary);
}

@media (max-width: 760px) {
    header {
        flex-direction: column;
        padding: 20px;
    }

    .hero h1 {
        font-size: 28px;
    }

    .cart-table thead {
        display: none;
    }

    .cart-table, .cart-table tbody, .cart-table tr, .cart-table td {
        display: block;
        width: 100%;
    }

    .cart-table tr {
        padding: 16px;
        border-bottom: 1px solid #ECECEC;
    }

    .cart-table td {
        border: none;
        padding: 8px;
    }

    .cart-table td::before {
        content: attr(data-label);
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--color-primary);
        margin-bottom: 4px;
    }

    .cart-footer {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
    }
}
    </style>
</head>

<body>

<header>
   <!-- Logo/Texto a la izquierda -->
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>

    <div class="header-actions">
        <a href="usuypass2.php" class="header-btn">Login / Regístrese</a>
        <a href="inicio.php" class="header-btn">Página Principal</a>
        <span class="cart-badge">🛒 <?php echo $cantidadTotal; ?> artículo(s)</span>
    </div>
</header>

<main>
    <section class="hero">
        <div>
            <h1>Carrito de compras</h1>
            <p>Revisa tus productos antes de continuar con la compra.</p>
        </div>
    </section>

    <?php if (!empty($_SESSION['productos'])): ?>
        <section class="cart-card">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($_SESSION['productos'] as $key => $product): ?>
                    <?php
                        $subtotal = $product['price'] * $product['qty'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td data-label="Producto">
                            <img class="product-thumb"
                                 src="<?php echo htmlspecialchars($product['image']); ?>"
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </td>

                        <td data-label="Descripción">
                            <span class="product-name">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </span>
                        </td>

                        <td data-label="Precio" class="price">
                            $<?php echo number_format($product['price'], 0, ',', '.'); ?>
                        </td>

                        <td data-label="Cantidad">
                            <div class="quantity">
                                <a href="carrito1_kitty.php?action=restar&sku=<?php echo urlencode($key); ?>">−</a>
                                <span><?php echo (int)$product['qty']; ?></span>
                                <a href="carrito1_kitty.php?action=sumar&sku=<?php echo urlencode($key); ?>">+</a>
                            </div>
                        </td>

                        <td data-label="Subtotal" class="price">
                            $<?php echo number_format($subtotal, 0, ',', '.'); ?>
                        </td>

                        <td data-label="Acción">
                            <a class="remove-btn"
                               href="carrito1_kitty.php?action=empty&sku=<?php echo urlencode($key); ?>">
                               🗑 Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-footer">
                <a class="clear-btn"
                   href="carrito1_kitty.php?action=vaciarcarrito"
                   onclick="return confirm('¿Seguro que quieres vaciar el carrito?');">
                    Vaciar carrito
                </a>

                <div class="total">
                    Total: $<?php echo number_format($total, 0, ',', '.'); ?>
                </div>

                <a class="checkout-btn" href="carrito2_kitty.php">
                    Continuar compra →
                </a>
            </div>
        </section>
    <?php else: ?>
        <section class="cart-card empty">
            <div class="empty-icon">🛒</div>
            <h2>Tu carrito está vacío</h2>
            <p>Agrega algunos productos para comenzar tu compra.</p>
        </section>
    <?php endif; ?>

    <div class="section-title">
        <h2>Productos disponibles</h2>
    </div>

    <section class="catalog">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <img class="product-image"
                     src="<?php echo htmlspecialchars($product['foto']); ?>"
                     alt="<?php echo htmlspecialchars($product['descripcion']); ?>">

                <div class="product-code">
                    Código: <?php echo htmlspecialchars($product['cod_prod_ser']); ?>
                </div>

                <h3><?php echo htmlspecialchars($product['descripcion']); ?></h3>

                <div class="product-price">
                    $<?php echo number_format($product['precio'], 0, ',', '.'); ?>
                </div>

                <form method="post" action="carrito1_kitty.php?action=adcarrito">
                    <input type="hidden"
                           name="sku"
                           value="<?php echo htmlspecialchars($product['cod_prod_ser']); ?>">

                    <button class="add-btn" type="submit">
                        🛒 Añadir al carrito
                    </button>
                </form>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<footer>
    <div class="socials">
        <a href="https://web.facebook.com/?locale=es_LA&_rdc=1&_rdr#" class="social">Facebook</a>
        <a href="https://x.com/?lang=es" class="social">Twitter</a>
        <a href="https://www.instagram.com/" class="social">Instagram</a>
        <a href="https://wa.me/3007764482">WhatsApp</a>
    </div>
</footer>

</body>
</html>