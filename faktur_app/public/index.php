<?php
require_once __DIR__.'/../app/Helpers/auth.php';
checkAuth();
$user = $_SESSION['user']['username'];
?>
<!doctype html><html><head><meta charset="utf-8"><title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<nav class="navbar navbar-dark bg-dark p-2"><span class="navbar-brand">Faktur App</span>
<span class="text-light">Hi, <?= htmlspecialchars($user) ?> | <a href="logout.php" class="text-light">Logout</a></span></nav>
<div class="d-flex">
  <aside class="bg-light border-end p-3" style="width:220px;">
  <ul class="nav flex-column" id="sidebarMenu">
    <li class="nav-item"><a href="dashboard.php" class="nav-link active" data-page="dashboard.php">🏠 Dashboard</a></li>
    <li class="nav-item"><a href="company_list.php" class="nav-link" data-page="company_list.php">🏢 Perusahaan</a></li>
    <li class="nav-item"><a href="product_list.php" class="nav-link" data-page="product_list.php">📦 Produk</a></li>
    <li class="nav-item"><a href="customer_list.php" class="nav-link" data-page="customer_list.php">👥 Customer</a></li>

    <li class="nav-item">
      <a href="#" class="nav-link text-primary fw-bold">🧾 Faktur</a>
      <ul class="nav flex-column ms-3">
        <li><a href="invoice_create.php" class="nav-link" data-page="invoice_create.php">➕ Buat Faktur</a></li>
        <li><a href="invoice_list.php" class="nav-link" data-page="invoice_list.php">📋 Daftar Faktur</a></li>
      </ul>
    </li>
  </ul>
</aside>

  <main class="p-3 flex-fill">
    <h3>Selamat datang di Sistem Faktur Penjualan</h3>
    <p>Gunakan menu di samping untuk mengelola data.</p>
  </main>
</div>
<footer class="bg-dark text-light text-center p-2 mt-auto">© 2025 Faktur App</footer>
</body></html>
