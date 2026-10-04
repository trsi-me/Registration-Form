<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // تشفير بسيط
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: form.php');
        exit();
    } else {
        $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>تسجيل الدخول</h2>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label>اسم المستخدم:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn">دخول</button>
            </form>
        </div>
    </div>
</body>
</html>

