<?php
require_once 'db_connection.php';

$errorText = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['userName'] ?? '';
    $email = $_POST['userEmail'] ?? '';
    $password = $_POST['userPassword'] ?? '';

    // Verificar si el correo ya existe en la base de datos
    $check = $pdoConnection->prepare("SELECT user_id FROM users WHERE user_email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $errorText = "Este correo ya está registrado.";
    } else {
        $stmt = $pdoConnection->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Registrarse</h2>

        <?php if (!empty($errorText)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorText); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="userName" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="userEmail" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="userPassword" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
        <div class="form-footer"><a href="index.php">Iniciar sesión</a></div>
    </div>
</body>
</html>