<?php
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();
$user = $_SESSION['user']['username'];
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard Faktur App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <!-- HEADER -->
  <nav class="navbar navbar-dark bg-primary text-light px-3">
    <span class="navbar-brand fw-semibold">Sistem Faktur Penjualan</span>
    <div>
      <span class="me-3">👋 Hi, <?= htmlspecialchars($user) ?></span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </nav>

  <!-- BODY -->
  <div class="d-flex" style="height: calc(100vh - 56px);">
    
    <!-- SIDEBAR -->
    <aside class="bg-light border-end p-3" style="width:220px;">
      <ul class="nav flex-column" id="sidebarMenu">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link active" data-page="dashboard.php">🏠 Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="company_list.php" class="nav-link" data-page="company_list.php">🏢 Perusahaan</a>
        </li>
        <li class="nav-item">
          <a href="product_list.php" class="nav-link" data-page="product_list.php">📦 Produk</a>
        </li>
        <li class="nav-item">
          <a href="customer_list.php" class="nav-link" data-page="customer_list.php">👥 Customer</a>
        </li>
        <li class="nav-item">
          <a href="invoice_menu.php" class="nav-link" data-page="invoice_menu.php">🧾 Faktur</a>
        </li>
      </ul>
    </aside>


    <!-- MAIN CONTENT -->
    <main class="flex-fill p-4" id="mainContent">
      <h3>Selamat datang di Sistem Faktur Penjualan</h3>
      <p>Pilih menu di kiri untuk mulai mengelola data.</p>
    </main>
    <div id="loadingIndicator" style="
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  display: none;
">
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

  </div>

<!-- jQuery & App Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>

