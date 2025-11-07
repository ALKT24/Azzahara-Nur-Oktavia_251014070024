<?php
require_once __DIR__.'/../app/Models/Company.php';
require_once __DIR__.'/../app/Helpers/auth.php';
checkAuth();

$model = new Company();
$id = $_GET['id'] ?? null;

if (!$id) {
  echo "<script>alert('ID tidak ditemukan!'); $('#mainContent').load('company_list.php');</script>";
  exit;
}

$company = $model->db->query("SELECT * FROM perusahaan WHERE id_perusahaan=$id")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $model->db->prepare("UPDATE perusahaan SET nama_perusahaan=?, alamat=?, no_telp=?, fax=? WHERE id_perusahaan=?");
  $stmt->execute([$_POST['nama_perusahaan'], $_POST['alamat'], $_POST['no_telp'], $_POST['fax'], $id]);
  echo "<script>$('#mainContent').load('company_list.php');</script>";
  exit;
}
?>

<div class="container">
  <h4>Edit Data Perusahaan</h4>
  <form id="formEditCompany" method="post">
    <div class="mb-2">
      <label>Nama Perusahaan</label>
      <input name="nama_perusahaan" value="<?= htmlspecialchars($company['nama_perusahaan']) ?>" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control"><?= htmlspecialchars($company['alamat']) ?></textarea>
    </div>
    <div class="mb-2">
      <label>No Telp</label>
      <input name="no_telp" value="<?= htmlspecialchars($company['no_telp']) ?>" class="form-control">
    </div>
    <div class="mb-2">
      <label>Fax</label>
      <input name="fax" value="<?= htmlspecialchars($company['fax']) ?>" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="company_list.php" data-load="true" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
// Kirim form edit tanpa reload halaman
$('#formEditCompany').on('submit', function(e){
  e.preventDefault();
  $.post('company_edit.php?id=<?= $id ?>', $(this).serialize(), function(res){
    $('#mainContent').html(res);
  });
});
</script>
