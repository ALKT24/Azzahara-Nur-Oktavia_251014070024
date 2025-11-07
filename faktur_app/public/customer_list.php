<?php 
require_once __DIR__.'/../app/Models/Customer.php';
require_once __DIR__.'/../app/Helpers/auth.php';
$model = new Customer();
$data = $model->all();
?>

<div>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Data Customer</h4>
    <a href="customer_add.php" data-load="true" class="btn btn-success btn-sm">+ Tambah</a>
  </div>
  <table class="table table-striped table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>Nama Customer</th>
        <th>Perusahaan</th>
        <th>Alamat</th>
        <th style="width: 120px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($data as $d): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($d['nama_customer']) ?></td>
        <td><?= htmlspecialchars($d['perusahaan_cust']) ?></td>
        <td><?= htmlspecialchars($d['alamat']) ?></td>
        <td>
          <a href="customer_edit.php?id=<?= $d['id_customer'] ?>" data-load="true" class="btn btn-sm btn-primary">Edit</a>
          <button class="btn btn-sm btn-danger btn-delete" data-file="customer_delete.php" data-id="<?= $d['id_customer'] ?>">Hapus</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
