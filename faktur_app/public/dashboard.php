<link rel="stylesheet" href="assets/css/style.css">

<div class="dashboard-container">
  <h4 class="dashboard-title">Dashboard</h4>
  <p class="dashboard-subtitle">Selamat datang di sistem faktur penjualan. Berikut ringkasan datanya:</p>

  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon bg-blue">🏢</div>
      <div class="stat-info">
        <h5>Total Perusahaan</h5>
        <p>
          <?php
            require_once __DIR__.'/../config/database.php';
            $db = Database::getInstance();
            echo $db->query("SELECT COUNT(*) FROM perusahaan")->fetchColumn();
          ?>
        </p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon bg-green">📦</div>
      <div class="stat-info">
        <h5>Total Produk</h5>
        <p><?= $db->query("SELECT COUNT(*) FROM produk")->fetchColumn(); ?></p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon bg-yellow">👥</div>
      <div class="stat-info">
        <h5>Total Customer</h5>
        <p><?= $db->query("SELECT COUNT(*) FROM customer")->fetchColumn(); ?></p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon bg-red">🧾</div>
      <div class="stat-info">
        <h5>Total Faktur</h5>
        <p><?= $db->query("SELECT COUNT(*) FROM faktur")->fetchColumn(); ?></p>
      </div>
    </div>
  </div>
</div>
