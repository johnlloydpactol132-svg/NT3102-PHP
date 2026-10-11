<?php
require __DIR__ . '/includes/auth.php';
$error = ''; $success = '';
if (!isset($_SESSION['attempts'])) $_SESSION['attempts'] = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(clean($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if ($_SESSION['attempts'] >= 4) $error = 'Too many failed attempts in this session. Try again later.';
    elseif (!valid_email($email) || $password === '') $error = 'Enter a valid email and password.';
    else {
        $user = find_user($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['attempts'] = 0;
            $_SESSION['user'] = $user['fullname'];
            $success = 'Login successful! Welcome, ' . $user['fullname'] . '!';
        } else {
            $_SESSION['attempts']++;
            $error = 'Incorrect email or password.';
        }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title><link rel="stylesheet" href="assets/login.css"></head><body>
<section class="page"><main class="login"><h1>Welcome</h1><p class="subtitle">Sign in to continue your journey</p>
<form method="post" action="login.php">
<input type="email" name="email" placeholder="Email address" value="<?= h($_POST['email'] ?? '') ?>" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" <?= $_SESSION['attempts'] >= 4 ? 'disabled' : '' ?>>LOGIN</button></form>
<?php if ($error): ?><div class="message error"><?= h($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="message success"><?= h($success) ?></div><?php endif; ?>
<div class="attempts">Failed attempts: <?= (int)$_SESSION['attempts'] ?> / 4</div>
<p class="bottom">Don't have an account? <a href="register.php"><b>Sign up</b></a></p><p class="bottom"><a href="index.php">Back to Home</a></p>
</main></section></body></html>
