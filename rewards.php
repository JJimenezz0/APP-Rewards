<?php
session_start();
require_once 'db_connection.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pointsToRedeem = (int)($_POST['pointsToRedeem'] ?? 0);
    $pdoConnection->prepare("UPDATE users SET points = GREATEST(0, points - ?) WHERE user_id = ?")->execute([$pointsToRedeem, $userId]);
    header("Location: rewards.php");
    exit();
}

$stmt = $pdoConnection->prepare("SELECT points FROM users WHERE user_id = ?");
$stmt->execute([$userId]);
$points = $stmt->fetchColumn() ?: 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recompensas</title>
    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>
<body style="flex-direction: column; justify-content: flex-start; padding: 20px;">
    <nav class="tactical-menu">
        <a href="dashboard.php" class="menu-item">Inventario</a>
        <a href="rewards.php" class="menu-item active">Recompensas</a>
        <a href="logout.php" class="menu-item" style="color: #ff7b72; margin-left: auto;">Cerrar sesión</a>
    </nav>
    <div style="margin-top: 40px; text-align: center;">
        <h2>SISTEMA DE RECOMPENSAS</h2>
        <h1 style="color: var(--accent-yellow); margin-top: 20px;">⭐ <?php echo $points; ?> PUNTOS</h1>
        <p style="color: var(--text-muted); margin-top: 15px;">Valor disponible: $<?php echo number_format($points * 100, 0, ',', '.'); ?></p>
        <form method="POST" style="margin-top: 30px;">
            <input type="number" name="pointsToRedeem" min="1" max="<?php echo $points; ?>" placeholder="Puntos a redimir" required style="max-width: 250px;">
            <button type="submit" style="max-width: 250px; margin-top: 10px;">Redimir puntos</button>
        </form>
    </div>
</body>
</html>