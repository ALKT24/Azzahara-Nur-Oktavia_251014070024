<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../app/Controllers/AuthController.php';
session_start();
$auth = new AuthController();
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  if($auth->login($_POST['username'],$_POST['password'])){
    header('Location: layout.php');exit;
  }else{$error='Username atau password salah';}
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
<div class="card p-4" style="width:300px">
  <h4>Login</h4>
  <?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <form method="post">
    <input name="username" class="form-control mb-2" placeholder="Username" required>
    <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
    <button class="btn btn-primary w-100">Masuk</button>
  </form>
</div></body></html>
