<?php
session_start();
function clean($value) { return trim((string)$value); }
function valid_name($name) { return preg_match('/^[\p{L}][\p{L} .\x27-]{1,79}$/u', $name) === 1; }
function valid_email($email) { return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[^\s@]+@[^\s@]+\.[A-Za-z]{2,}$/', $email); }
function valid_password($password) { return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password); }
function users_path() { return __DIR__ . '/../data/users.json'; }
function find_user($email) {
    $users = json_decode(@file_get_contents(users_path()) ?: '[]', true);
    foreach (($users ?: []) as $user) if ($user['email'] === strtolower($email)) return $user;
    return null;
}
function save_user($name, $email, $password) {
    $path = users_path();
    $handle = fopen($path, 'c+');
    if (!$handle || !flock($handle, LOCK_EX)) return false;
    $raw = stream_get_contents($handle);
    $users = json_decode($raw ?: '[]', true) ?: [];
    foreach ($users as $user) {
        if ($user['email'] === strtolower($email)) { flock($handle, LOCK_UN); fclose($handle); return false; }
    }
    $users[] = ['fullname'=>$name, 'email'=>strtolower($email), 'password_hash'=>password_hash($password, PASSWORD_DEFAULT)];
    rewind($handle); ftruncate($handle, 0);
    $ok = fwrite($handle, json_encode($users, JSON_PRETTY_PRINT)) !== false;
    fflush($handle); flock($handle, LOCK_UN); fclose($handle);
    return $ok;
}
function h($text) { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); }
