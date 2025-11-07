<?php
require_once __DIR__ . '/../app/Models/Company.php';
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();
$model = new Company();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'nama_perusahaan' => $_POST['nama_perusahaan'],
    'alamat' => $_POST['alamat'],
    'no_telp' => $_POST['no_telp'],
    'fax' => $_POST['fax']
  ];
  $model->create($data);
  // setelah insert, langsung load ulang company_list
  echo "<script>$('#mainContent').load('company_list.php');</script>";
  exit;
}
?>

<div class="container">
  <h4>Tambah Data Perusahaan</h4>
  <form id="formAddCompany" method="post">
    <div class="mb-2">
      <label>Nama Perusahaan</label>
      <input type="text" name="nama_perusahaan" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control"></textarea>
    </div>
    <div class="mb-2">
      <label>No Telp</label>
      <input type="text" name="no_telp" class="form-control">
    </div>
    <div class="mb-2">
      <label>Fax</label>
      <input type="text" name="fax" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="company_list.php" data-load="true" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
// Kirim form tanpa reload halaman
$('#formAddCompany').on('submit', function(e){
  e.preventDefault();
  $.post('company_add.php', $(this).serialize(), function(response){
    $('#mainContent').html(response);
  });
});
</script>
