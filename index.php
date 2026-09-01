<?php
session_start();
require_once 'db_connection.php';

$errorText = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdoConnection->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ?");
    $stmt->execute([$_POST['userEmail'] ?? '', $_POST['userPassword'] ?? '']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        header("Location: dashboard.php");
        exit();
    } else {
        $errorText = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        
        <?php if (!empty($errorText)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorText); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="userEmail" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="userPassword" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <div class="form-footer"><a href="register.php">Registrarse</a></div>
    </div>
</body>
</html>