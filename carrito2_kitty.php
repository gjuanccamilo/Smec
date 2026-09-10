<?php
session_start();

$total = 0;

if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

$productosCarrito = $_SESSION['productos'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Compra</title>

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
    margin: 0;
    padding: 0;
}

body {
    font-family: var(--font-body);
    background-color: var(--color-bg-card);
    color: var(--color-text);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    letter-spacing: 0.3px;
}

header {
    background-color: var(--color-dark);
    color: var(--color-white);
    padding: 15px 30px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    display: grid;
    grid-template-columns: 1fr auto 1fr; /* Distribuye Logo (Izq), Título (Centro), Botones (Der) */
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    border-bottom: 2px solid var(--color-primary);
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
    gap: 16px;
    align-items: center;
}

.header-btn {
    background-color: transparent;
    color: var(--color-white);
    border: 1px solid rgba(255, 255, 255, 0.25);
    text-decoration: none;
    padding: 10px 22px;
    border-radius: 4px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.header-btn:hover {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
    color: var(--color-white);
}

main {
    width: min(1000px, 92%);
    margin: 50px auto 90px;
}

.page-title {
    text-align: center;
    margin-bottom: 40px;
    margin-top:80px;
}

.page-title h1 {
    font-family: var(--font-heading);
    color: var(--color-dark);
    font-size: 36px;
    font-weight: 400;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.page-title p {
    color: #777;
    font-size: 14px;
    font-style: italic;
}

.summary-card {
    background: var(--color-white);
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(11, 11, 12, 0.03);
    border: var(--border-elegant);
}

.summary-table {
    width: 100%;
    border-collapse: collapse;
}

.summary-table th {
    background-color: var(--color-dark);
    color: var(--color-white);
    padding: 18px;
    text-align: center;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 500;
}

.summary-table td {
    padding: 20px 16px;
    text-align: center;
    border-bottom: 1px solid #F0F0F0;
    font-size: 14px;
}

.summary-table tr:last-child td {
    border-bottom: none;
}

.summary-image {
    width: 70px;
    height: 70px;
    object-fit: contain;
    background: var(--color-bg-card);
    border-radius: 4px;
    padding: 8px;
    border: 1px solid #ECECEC;
}

.item-name {
    font-family: var(--font-heading);
    font-size: 16px;
    font-weight: 600;
    color: var(--color-dark);
}

.quantity-badge {
    display: inline-block;
    min-width: 32px;
    padding: 4px 12px;
    border-radius: 50px;
    background: var(--color-primary-light);
    color: var(--color-primary);
    font-weight: 700;
    font-size: 13px;
}

.remove-btn {
    display: inline-block;
    color: #999;
    text-decoration: none;
    padding: 6px 12px;
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: color 0.3s ease;
}

.remove-btn:hover {
    color: var(--color-primary);
}

.total-box {
    padding: 28px 32px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 20px;
    background: #FAFAFA;
    border-top: var(--border-elegant);
}

.total-label {
    font-family: var(--font-heading);
    font-size: 18px;
    color: var(--color-dark);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.total-price {
    font-size: 30px;
    color: var(--color-primary);
    font-weight: 700;
}

.actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 35px;
    flex-wrap: wrap;
}

.btn {
    text-decoration: none;
    padding: 15px 36px;
    border-radius: 4px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-back {
    background: transparent;
    color: var(--color-dark);
    border: 1px solid var(--color-dark);
}

.btn-back:hover {
    background: var(--color-dark);
    color: var(--color-white);
}

.btn-pay {
    background: var(--color-primary);
    color: var(--color-white);
    border: 1px solid var(--color-primary);
}

.btn-pay:hover {
    background: #b54763;
    border-color: #b54763;
    box-shadow: 0 8px 20px rgba(212, 91, 122, 0.25);
}

.empty {
    padding: 70px 20px;
    text-align: center;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 15px;
    opacity: 0.7;
}

.empty h2 {
    font-family: var(--font-heading);
    color: var(--color-dark);
    font-weight: 400;
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

@media (max-width: 720px) {
    header {
        flex-direction: column;
        padding: 20px;
    }

    .page-title h1 {
        font-size: 28px;
    }

    .summary-table thead {
        display: none;
    }

    .summary-table, .summary-table tbody, .summary-table tr, .summary-table td {
        display: block;
        width: 100%;
    }

    .summary-table tr {
        padding: 16px;
        border-bottom: 1px solid #ECECEC;
    }

    .summary-table td {
        border: none;
        padding: 8px;
    }

    .summary-table td::before {
        content: attr(data-label);
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--color-primary);
        margin-bottom: 4px;
    }

    .total-box {
        flex-direction: column;
        text-align: center;
    }
}
    </style>
</head>

<body>

<header>
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>

    <div class="header-actions">
        <a href="usuypass2.php" class="header-btn">Login / Regístrese</a>
        <a href="inicio.php" class="header-btn">Página Principal</a>
    </div>
</header>

<main>
    <div class="page-title">
        <h1>Resumen de compra</h1>
        <p>Verifica los productos y el total antes de realizar el pago.</p>
    </div>

    <?php if (!empty($productosCarrito)): ?>
        <section class="summary-card">
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Artículo</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($productosCarrito as $key => $product): ?>
                    <?php
                        $subtotal = $product['price'] * $product['qty'];
                        $total += $subtotal;
                    ?>

                    <tr>
                        <td data-label="Imagen">
                            <img class="summary-image"
                                 src="<?php echo htmlspecialchars($product['image']); ?>"
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </td>

                        <td data-label="Artículo" class="item-name">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </td>

                        <td data-label="Precio">
                            $<?php echo number_format($product['price'], 0, ',', '.'); ?>
                        </td>

                        <td data-label="Cantidad">
                            <span class="quantity-badge">
                                <?php echo (int)$product['qty']; ?>
                            </span>
                        </td>

                        <td data-label="Subtotal">
                            <strong>
                                $<?php echo number_format($subtotal, 0, ',', '.'); ?>
                            </strong>
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

            <div class="total-box">
                <span class="total-label">Total a pagar:</span>
                <span class="total-price">
                    $<?php echo number_format($total, 0, ',', '.'); ?>
                </span>
            </div>
        </section>

        <div class="actions">
            <a class="btn btn-back" href="carrito1_kitty.php">
                ← Volver al carrito
            </a>

            <a class="btn btn-pay" href="factura_kitty.php">
                 Pagar
            </a>
        </div>

    <?php else: ?>
        <section class="summary-card empty">
            <div class="empty-icon">🛒</div>
            <h2>No hay productos para comprar</h2>
            <p>Regresa al carrito y agrega algún producto.</p>

            <div class="actions">
                <a class="btn btn-back" href="carrito1_kitty.php">
                    ← Ir al carrito
                </a>
            </div>
        </section>
    <?php endif; ?>
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