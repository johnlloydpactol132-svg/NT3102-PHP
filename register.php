<?php
require __DIR__ . '/includes/auth.php';
$error = ''; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean($_POST['fullname'] ?? '');
    $email = strtolower(clean($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $confirm = (string)($_POST['confirmPassword'] ?? '');
    if (!valid_name($name)) $error = 'Enter a valid full name (2–80 characters).';
    elseif (!valid_email($email)) $error = 'Enter a valid email address.';
    elseif (!valid_password($password)) $error = 'Password needs 8+ characters, a letter and a number.';
    elseif ($password !== $confirm) $error = 'Passwords do not match.';
    elseif (find_user($email)) $error = 'Email is already registered.';
    elseif (!save_user($name, $email, $password)) $error = 'Unable to create account. Check data folder permissions.';
    else $success = 'Registration successful! You can now log in.';
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register</title><link rel="stylesheet" href="assets/register.css"></head><body>
<section class="page"><main class="box"><h1>Create Account</h1>
<form method="post" action="register.php">
<input type="text" name="fullname" placeholder="Full name" value="<?= h($_POST['fullname'] ?? '') ?>" required minlength="2" maxlength="80">
<input type="email" name="email" placeholder="Email address" value="<?= h($_POST['email'] ?? '') ?>" required>
<input type="password" name="password" placeholder="Password (8+ chars, letter and number)" required minlength="8">
<input type="password" name="confirmPassword" placeholder="Confirm password" required>
<button type="submit">CREATE ACCOUNT</button></form>
<?php if ($error): ?><div class="message error"><?= h($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="message success"><?= h($success) ?></div><?php endif; ?>
<p>Already have an account? <a href="login.php">Login</a></p><p><a href="index.php">Back to Home</a></p>
</main></section></body></html>
