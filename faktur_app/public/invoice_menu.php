<?php
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();
?>

<div class="container">
  <h3 class="mb-4">🧾 Menu Faktur Penjualan</h3>
  <p>Pilih salah satu menu di bawah untuk melanjutkan:</p>

  <div class="d-flex flex-column flex-md-row gap-3 mt-3">
    <a href="invoice_create.php" data-load="true" class="btn btn-primary btn-lg w-100 w-md-auto">
      ➕ Buat Faktur Baru
    </a>

    <a href="invoice_list.php" data-load="true" class="btn btn-outline-primary btn-lg w-100 w-md-auto">
      📋 Lihat Daftar Faktur
    </a>
  </div>
</div>
