<?php
session_start();
require_once 'db_connection.php';

$errorText = "";
$successText = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputName = trim($_POST['userName'] ?? '');
    $inputEmail = trim($_POST['userEmail'] ?? '');
    $inputPassword = $_POST['userPassword'] ?? '';

    if (!empty($inputName) && !empty($inputEmail) && !empty($inputPassword)) {
        // Verificar si el correo ya existe
        $checkQuery = "SELECT user_id FROM users WHERE user_email = :email";
        $checkStmt = $pdoConnection->prepare($checkQuery);
        $checkStmt->execute(['email' => $inputEmail]);
        
        if ($checkStmt->rowCount() > 0) {
            $errorText = "The email is already registered.";
        } else {
            // Insertar nuevo usuario
            $insertQuery = "INSERT INTO users (user_name, user_email, user_password) VALUES (:name, :email, :password)";
            $insertStmt = $pdoConnection->prepare($insertQuery);
            $insertResult = $insertStmt->execute([
                'name' => $inputName,
                'email' => $inputEmail,
                'password' => $inputPassword
            ]);

            if ($insertResult) {
                $successText = "Registration successful. You can now log in.";
            } else {
                $errorText = "Error registering user. Try again.";
            }
        }
    } else {
        $errorText = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vintage Store - Register</title>
    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>
<body>

    <div class="login-container">
        <h2>New Operative</h2>
        
        <?php if (!empty($errorText)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorText); ?></div>
        <?php endif; ?>

        <?php if (!empty($successText)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successText); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="userName">Name</label>
                <input type="text" id="userName" name="userName" required>
            </div>
            <div class="form-group">
                <label for="userEmail">Email</label>
                <input type="email" id="userEmail" name="userEmail" required>
            </div>
            <div class="form-group">
                <label for="userPassword">Password</label>
                <input type="password" id="userPassword" name="userPassword" required>
            </div>
            <button type="submit">Register</button>
        </form>

        <div class="form-footer">
            ¿Ya tienes cuenta? <a href="index.php">Inicia sesión aquí</a>
        </div>
    </div>

</body>
</html>