<?php 
require_once __DIR__.'/../app/Models/Product.php';
require_once __DIR__.'/../app/Helpers/auth.php';
$model = new Product();
$data = $model->all();
?>

<div>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Data Produk</h4>
    <a href="product_add.php" data-load="true" class="btn btn-success btn-sm">+ Tambah</a>
  </div>
  <table class="table table-striped table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Jenis</th>
        <th>Stok</th>
        <th style="width: 120px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($data as $p): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($p['nama_produk']) ?></td>
        <td><?= number_format($p['price'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($p['jenis']) ?></td>
        <td><?= htmlspecialchars($p['stock']) ?></td>
        <td>
          <a href="product_edit.php?id=<?= $p['id_produk'] ?>" data-load="true" class="btn btn-sm btn-primary">Edit</a>
          <button class="btn btn-sm btn-danger btn-delete" data-file="product_delete.php" data-id="<?= $p['id_produk'] ?>">Hapus</button>

      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
