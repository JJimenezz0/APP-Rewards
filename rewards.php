<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}


$userId = $_SESSION['user_id'];


$sqlQuery = "SELECT points FROM users WHERE user_id = :user_id";
$statement = $pdoConnection->prepare($sqlQuery);
$statement->execute(['user_id' => $userId]);

$userData = $statement->fetch(PDO::FETCH_ASSOC);


$points = $userData ? $userData['points'] : 0;

$pointsValue = $points * 100;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recompensas - APP Rewards</title>

    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>

<body style="flex-direction: column; justify-content: flex-start; padding: 20px;">

    <nav class="tactical-menu">
        <a href="dashboard.php" class="menu-item">Inventario</a>

        <a href="rewards.php" class="menu-item active">Recompensas</a>

        <a href="#" class="menu-item">Registro</a>

        <a href="#" class="menu-item">Sistema</a>

        <a href="logout.php" class="menu-item" style="color: #ff7b72; margin-left: auto;">
            Cerrar sesión
        </a>
    </nav>

    <div style="margin-top: 40px; text-align: center;">

        <h2 style="color: var(--accent-white);">
            SISTEMA DE RECOMPENSAS
        </h2>

        <p style="color: var(--text-muted);">
            Saldo actual de puntos
        </p>

        <h1 style="color: var(--accent-yellow); margin-top: 20px;">
            ⭐ <?php echo $points; ?> PUNTOS
        </h1>

        <p style="color: var(--text-muted); margin-top: 15px;">
            Valor disponible: $<?php echo number_format($pointsValue, 0, ',', '.'); ?>
        </p>

    </div>

</body>
</html>