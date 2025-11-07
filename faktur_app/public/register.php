<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../app/Controllers/AuthController.php';
session_start();

$auth = new AuthController();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($auth->register($_POST['username'], $_POST['password'])) {
    $msg = 'Akun berhasil dibuat! Silakan login.';
  } else {
    $msg = 'Gagal membuat akun.';
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
  <div class="card p-4" style="width:300px">
    <h4>Register</h4>
    <?php if($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
    <form method="post">
      <input name="username" class="form-control mb-2" placeholder="Username" required>
      <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
      <button class="btn btn-success w-100">Register</button>
    </form>
    <div class="mt-2 text-center"><a href="login.php">Sudah punya akun?</a></div>
  </div>
</body>
</html>
