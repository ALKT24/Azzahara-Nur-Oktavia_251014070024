<?php 
require_once __DIR__.'/../app/Models/Company.php';
require_once __DIR__.'/../app/Helpers/auth.php';
$model = new Company();
$data = $model->all();
?>

<div>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Data Perusahaan</h4>
    <a href="company_add.php" data-load="true" class="btn btn-success btn-sm">+ Tambah</a>
  </div>
  <table class="table table-striped table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No Telp</th>
        <th>Fax</th>
        <th style="width: 120px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($data as $d): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($d['nama_perusahaan']) ?></td>
        <td><?= htmlspecialchars($d['alamat']) ?></td>
        <td><?= htmlspecialchars($d['no_telp']) ?></td>
        <td><?= htmlspecialchars($d['fax']) ?></td>
        <td>
          <a href="company_edit.php?id=<?= $d['id_perusahaan'] ?>" data-load="true" class="btn btn-sm btn-primary">Edit</a>
          <button class="btn btn-sm btn-danger btn-delete"
          data-file="company_delete.php"
          data-id="<?= $d['id_perusahaan'] ?>">
          Hapus
        </button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
