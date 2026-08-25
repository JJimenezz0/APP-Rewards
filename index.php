<?php
session_start();
require_once 'db_connection.php';

$errorText = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputEmail = trim($_POST['userEmail'] ?? '');
    $inputPassword = $_POST['userPassword'] ?? '';

    if (!empty($inputEmail) && !empty($inputPassword)) {
        $sqlQuery = "SELECT * FROM users WHERE user_email = :email";
        $statement = $pdoConnection->prepare($sqlQuery);
        $statement->execute(['email' => $inputEmail]);
        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userData && $inputPassword === $userData['user_password']) {
            $_SESSION['user_id'] = $userData['user_id'];
            $_SESSION['user_email'] = $userData['user_email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $errorText = "Invalid credentials. Access denied.";
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
    <title>Vintage Store - Login</title>
    <!-- Ruta absoluta basada en la raíz del servidor para evitar fallos de CSS -->
    <link rel="stylesheet" href="/APP-Rewards/assets/css/styles.css">
</head>
<body>

    <div class="login-container">
        <h2>Secure Login</h2>
        
        <?php if (!empty($errorText)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorText); ?></div>
        <?php endif; ?>

        <form action="index.php" method="POST" id="loginForm">
            <div class="form-group">
                <label for="userEmail">Email</label>
                <input type="email" id="userEmail" name="userEmail" required>
            </div>
            <div class="form-group">
                <label for="userPassword">Password</label>
                <input type="password" id="userPassword" name="userPassword" required>
            </div>
            <button type="submit">Authenticate</button>
        </form>
    </div>

    <script src="/APP-Rewards/assets/js/app.js"></script>
</body>
</html>