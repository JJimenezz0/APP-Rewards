<?php
session_start();
require_once 'db_connection.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'checkout') {
    $cartData = json_decode($_POST['cart_items'] ?? '[]', true);
    $earned = array_reduce($cartData, fn($acc, $item) => $acc + ($item['points'] * $item['qty']), 0);

    if ($earned > 0) {
        $pdoConnection->prepare("UPDATE users SET points = points + ? WHERE user_id = ?")->execute([$earned, $userId]);
        header("Location: dashboard.php");
        exit();
    }
}

$stmt = $pdoConnection->prepare("SELECT points FROM users WHERE user_id = ?");
$stmt->execute([$userId]);
$userPoints = $stmt->fetchColumn() ?: 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>
<body style="flex-direction: column; justify-content: flex-start; padding: 20px;">

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div style="background: rgba(46, 160, 67, 0.2); border: 1px solid #2ea043; color: #3fb950; padding: 10px 20px; border-radius: 6px; margin-bottom: 20px; text-align: center;">
            ¡Compra exitosa! Has ganado <strong><?php echo intval($_GET['earned']); ?> puntos</strong> añadidos a tu cuenta.
        </div>
    <?php endif; ?>

    <nav class="tactical-menu"> 
        <a href="dashboard.php" class="menu-item active">Inventario</a>
        <a href="rewards.php" class="menu-item">Recompensas</a>
        <a href="logout.php" class="menu-item" style="color: #ff7b72; margin-left: auto;">Cerrar sesión</a>
    </nav>

    <div style="margin-top: 40px; text-align: center;">
        <h2 style="color: var(--accent-white);">Menú principal</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Explora tu perfil y navega por la tienda.</p>
    </div>

    <!-- Panel de puntos del usuario -->
    <div class="points-panel">
        <div class="user-name">👤 <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuario'); ?></div>
        <div class="points-label">Tus puntos</div>
        <div class="points-value">⭐ <?php echo $userPoints; ?></div>
    </div>

    <!-- Grid de productos -->
    <div class="product-grid" id="productGrid"></div>

    <button type="button" class="cart-toggle-btn" id="cartToggleBtn" onclick="toggleCart(true)">
        🛒 Carrito <span class="cart-badge" id="cartBadge">0</span>
    </button>

    <!-- Carrito lateral -->
    <aside class="cart-sidebar" id="cartSidebar">
        <button type="button" class="cart-close" onclick="toggleCart(false)">✕</button>
        <h3>Tu carrito</h3>
        <div class="cart-items" id="cartItems">
            <p class="empty-cart-msg" id="emptyCartMsg">Aún no has añadido items.</p>
        </div>
        <div class="cart-summary">
            <p><span>Total a pagar</span> <strong id="cartTotalPrice">$0</strong></p>
            <p><span>Puntos a recibir</span> <strong id="cartTotalPoints">0 ⭐</strong></p>
            <button type="button" class="cart-pay-btn" id="cartPayBtn" onclick="payCart()" disabled>Pagar</button>
        </div>
    </aside>

    <script src="/APP-Rewards/assets/js/app.js"></script>
    <script src="/APP-Rewards/assets/js/cart.js"></script>
</body>
</html>