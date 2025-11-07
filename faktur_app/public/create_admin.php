<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/BaseModel.php';

$db = Database::getInstance();

// Ganti data ini kalau mau nama user lain
$username = 'admin';
$password = 'admin123';
$role = 'admin';

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Masukkan ke tabel users
$stmt = $db->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
$stmt->execute([$username, $hash, $role]);

echo "User baru berhasil dibuat!<br>";
echo "Username: <b>$username</b><br>";
echo "Password: <b>$password</b><br><br>";
echo "Sekarang coba login di <a href='login.php'>login.php</a>";
