<?php
// Start the session immediately
session_start();

$correct_pin = "3189"; 
$error = "";

$redirect_to = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. trim() removes any accidental invisible spaces
    $entered_pin = trim($_POST['pin']);
    
    if ($entered_pin === $correct_pin) {
        $_SESSION['authenticated'] = true;

        // 2. The Bulletproof Redirect: Try PHP first...
        if (!headers_sent()) {
            header("Location: " . $redirect_to);
        }
        // ...and if PHP crashes, use unstoppable JavaScript!
        echo "<script>window.location.replace('" . htmlspecialchars($redirect_to, ENT_QUOTES, 'UTF-8') . "');</script>";
        exit();
        
    } else {
        $error = "رمز المرور خاطئ! / Incorrect PIN!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Login</title>
    <style>
        body { font-family: system-ui, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); text-align: center; width: 100%; max-width: 350px; }
        .login-card h2 { color: #007bff; margin-bottom: 10px; }
        .login-card p { color: #666; margin-bottom: 25px; }
        input[type="password"] { width: 80%; padding: 15px; font-size: 1.5rem; text-align: center; letter-spacing: 10px; border: 2px solid #ddd; border-radius: 8px; margin-bottom: 20px; transition: 0.3s; }
        input[type="password"]:focus { border-color: #007bff; outline: none; box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15); }
        button { width: 80%; background: #28a745; color: white; padding: 12px; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: #dc3545; font-weight: bold; margin-bottom: 15px; }
        .back-link { display: block; margin-top: 20px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>🔒 Security Lock</h2>
        <p>الرجاء إدخال الرمز السري <br> Enter PIN to access</p>
        
        <?php if($error != ""): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php?redirect=<?php echo htmlspecialchars($redirect_to); ?>">
            <input type="password" name="pin" maxlength="4" required autofocus placeholder="••••">
            <br>
            <button type="submit">Unlock / دخول</button>
        </form>
        
        <a href="index.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>