<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vintage Store - Dashboard</title>
    <!-- Ruta absoluta basada en la raíz del servidor para garantizar el CSS -->
    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>
<body style="flex-direction: column; justify-content: flex-start; padding: 20px;">

    <!-- Menú táctico superior estilo Arc Raiders -->
    <nav class="tactical-menu">
        <a href="dashboard.php" class="menu-item active">Inventory</a>
        <a href="#" class="menu-item">Logbook</a>
        <a href="#" class="menu-item">System</a>
        <a href="logout.php" class="menu-item" style="color: #ff7b72; margin-left: auto;">Disconnect</a>
    </nav>

    <div style="margin-top: 40px; text-align: center;">
        <h2 style="color: var(--accent-white);">Main Inventory Stash</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Product grid section ready for integration.</p>
    </div>

</body>
</html>