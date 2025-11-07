<?php
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();

// koneksi database
try {
  $db = new PDO('mysql:host=localhost;dbname=faktur_app', 'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Koneksi gagal: " . $e->getMessage());
}

// ambil semua faktur
$query = "
  SELECT 
    f.no_faktur,
    f.tgl_faktur,
    f.due_date,
    f.metode_bayar,
    f.grand_total,
    c.nama_customer,
    p.nama_perusahaan
  FROM faktur f
  LEFT JOIN customer c ON f.id_customer = c.id_customer
  LEFT JOIN perusahaan p ON f.id_perusahaan = p.id_perusahaan
  ORDER BY f.tgl_faktur DESC
";

$stmt = $db->query($query);
$fakturs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>📋 Daftar Faktur Penjualan</h4>
    <a href="invoice_create.php" data-load="true" class="btn btn-primary btn-sm">+ Buat Faktur Baru</a>
  </div>

  <?php if (count($fakturs) > 0): ?>
  <table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>No Faktur</th>
        <th>Tanggal</th>
        <th>Due Date</th>
        <th>Perusahaan</th>
        <th>Customer</th>
        <th>Metode Bayar</th>
        <th>Grand Total</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($fakturs as $f): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($f['no_faktur']) ?></td>
        <td><?= htmlspecialchars($f['tgl_faktur']) ?></td>
        <td><?= htmlspecialchars($f['due_date']) ?></td>
        <td><?= htmlspecialchars($f['nama_perusahaan']) ?></td>
        <td><?= htmlspecialchars($f['nama_customer']) ?></td>
        <td><?= htmlspecialchars($f['metode_bayar']) ?></td>
        <td>Rp <?= number_format($f['grand_total'], 0, ',', '.') ?></td>
        <td>
          <a href="invoice_print.php?no=<?= $f['no_faktur'] ?>" target="_blank" class="btn btn-sm btn-success">Cetak</a>
          <a href="invoice_delete.php?no=<?= $f['no_faktur'] ?>"class="btn btn-sm btn-danger"
          onclick="return confirm('Yakin ingin menghapus faktur ini?')">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <div class="alert alert-warning text-center mt-4">
    Belum ada faktur yang dibuat.
  </div>
  <?php endif; ?>
</div>
