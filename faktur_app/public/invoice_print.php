<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();

try {
  $db = new PDO('mysql:host=localhost;dbname=faktur_app', 'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Koneksi gagal: " . $e->getMessage());
}

$no = $_GET['no'] ?? '';
if (!$no) die("Nomor faktur tidak ditemukan!");

// Ambil data faktur utama
$stmt = $db->prepare("
  SELECT f.*, c.nama_customer, c.alamat AS alamat_cust,
         p.nama_perusahaan, p.alamat AS alamat_perusahaan
  FROM faktur f
  LEFT JOIN customer c ON f.id_customer = c.id_customer
  LEFT JOIN perusahaan p ON f.id_perusahaan = p.id_perusahaan
  WHERE f.no_faktur = ?
");
$stmt->execute([$no]);
$faktur = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$faktur) die("Data faktur tidak ditemukan!");

// Ambil detail faktur dari tabel faktur_detail
$stmt2 = $db->prepare("
  SELECT fd.*, pr.nama_produk
  FROM faktur_detail fd
  LEFT JOIN produk pr ON fd.id_produk = pr.id_produk
  WHERE fd.no_faktur = ?
");
$stmt2->execute([$no]);
$items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Hitung subtotal otomatis
$subtotal = array_sum(array_column($items, 'subtotal'));
$ppn = $subtotal * 0.11;
$dp = $subtotal * 0.5;
$grand = $subtotal + $ppn;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Cetak Faktur - <?= htmlspecialchars($no) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { font-size: 14px; }
  .table th, .table td { vertical-align: middle; font-size: 13px; }
  .nota-header { text-align: center; margin-bottom: 20px; }
  .nota-header h5 { font-weight: bold; margin-bottom: 0; }
  .nota-header p { margin: 0; font-size: 13px; color: #444; }
  .table th { background-color: #f8f9fa; }
  @media print { .btn-print { display: none; } }
</style>
</head>

<body class="container mt-3">
<div class="nota-header">
  <h5><?= htmlspecialchars($faktur['nama_perusahaan']) ?></h5>
  <p><?= htmlspecialchars($faktur['alamat_perusahaan']) ?></p>
  <h6 class="mt-3 text-decoration-underline">FAKTUR PENJUALAN</h6>
</div>

<div class="row mb-3">
  <div class="col-md-6">
    <p><strong>No. Faktur:</strong> <?= htmlspecialchars($faktur['no_faktur']) ?></p>
    <p><strong>Customer:</strong> <?= htmlspecialchars($faktur['nama_customer']) ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($faktur['alamat_cust']) ?></p>
  </div>
  <div class="col-md-6 text-end">
    <p><strong>Tanggal:</strong> <?= htmlspecialchars($faktur['tgl_faktur']) ?></p>
    <p><strong>Due Date:</strong> <?= htmlspecialchars($faktur['due_date']) ?></p>
    <p><strong>Metode Bayar:</strong> <?= htmlspecialchars($faktur['metode_bayar']) ?></p>
  </div>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th style="width:5%;">No</th>
      <th>Nama Produk</th>
      <th style="width:10%;">Qty</th>
      <th style="width:15%;">Harga</th>
      <th style="width:15%;">Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($items) > 0): ?>
      <?php $noUrut = 1; foreach ($items as $item): ?>
        <tr>
          <td><?= $noUrut++ ?></td>
          <td><?= htmlspecialchars($item['nama_produk']) ?></td>
          <td><?= htmlspecialchars($item['qty']) ?></td>
          <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
          <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="5" class="text-center text-muted">Tidak ada produk</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="row">
  <div class="col-md-6">
    <p><strong>Catatan:</strong><br>
    Barang yang sudah dibeli tidak dapat dikembalikan.<br>
    Terima kasih atas kepercayaannya.</p>
  </div>
  <div class="col-md-6 text-end">
    <p>Subtotal: Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
    <p>PPN (11%): Rp <?= number_format($ppn, 0, ',', '.') ?></p>
    <p>DP (50%): Rp <?= number_format($dp, 0, ',', '.') ?></p>
    <h5><strong>Grand Total: Rp <?= number_format($grand, 0, ',', '.') ?></strong></h5>
  </div>
</div>

<div class="text-center mt-4">
  <button class="btn btn-primary btn-print" onclick="window.print()">🖨 Cetak</button>
</div>
</body>
</html>
