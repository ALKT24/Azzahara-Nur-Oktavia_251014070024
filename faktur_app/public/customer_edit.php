<?php
require_once __DIR__.'/../app/Models/Customer.php';
require_once __DIR__.'/../app/Models/Company.php';
require_once __DIR__.'/../app/Helpers/auth.php';
checkAuth();

$model = new Customer();
$companyModel = new Company();
$companies = $companyModel->all();
$id = $_GET['id'] ?? null;

if (!$id) {
  echo "<script>alert('ID tidak ditemukan!'); $('#mainContent').load('customer_list.php');</script>";
  exit;
}

$customer = $model->db->query("SELECT * FROM customer WHERE id_customer=$id")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $model->db->prepare("UPDATE customer SET nama_customer=?, perusahaan_cust=?, alamat=? WHERE id_customer=?");
  $stmt->execute([$_POST['nama_customer'], $_POST['perusahaan_cust'], $_POST['alamat'], $id]);
  echo "<script>$('#mainContent').load('customer_list.php');</script>";
  exit;
}
?>

<div class="container">
  <h4>Edit Data Customer</h4>
  <form id="formEditCustomer" method="post">
    <div class="mb-2">
      <label>Nama Customer</label>
      <input name="nama_customer" value="<?= htmlspecialchars($customer['nama_customer']) ?>" class="form-control" required>
    </div>

    <div class="mb-2">
      <label>Perusahaan</label>
      <select name="perusahaan_cust" class="form-select" required>
        <option value="">-- Pilih Perusahaan --</option>
        <?php foreach ($companies as $c): ?>
          <option value="<?= htmlspecialchars($c['nama_perusahaan']) ?>" 
            <?= ($c['nama_perusahaan'] == $customer['perusahaan_cust']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['nama_perusahaan']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-2">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control"><?= htmlspecialchars($customer['alamat']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="customer_list.php" data-load="true" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
$('#formEditCustomer').on('submit', function(e){
  e.preventDefault();
  $.post('customer_edit.php?id=<?= $id ?>', $(this).serialize(), function(res){
    $('#mainContent').html(res);
  });
});
</script>
