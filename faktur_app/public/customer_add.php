<?php
require_once __DIR__ . '/../app/Models/Customer.php';
require_once __DIR__ . '/../app/Models/Company.php';
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();

$model = new Customer();
$companyModel = new Company();
$companies = $companyModel->all(); // ambil semua perusahaan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'nama_customer' => $_POST['nama_customer'],
    'perusahaan_cust' => $_POST['perusahaan_cust'],
    'alamat' => $_POST['alamat']
  ];
  $stmt = $model->db->prepare("INSERT INTO customer (nama_customer, perusahaan_cust, alamat) VALUES (?, ?, ?)");
  $stmt->execute([$data['nama_customer'], $data['perusahaan_cust'], $data['alamat']]);
  echo "<script>$('#mainContent').load('customer_list.php');</script>";
  exit;
}
?>

<div class="container">
  <h4>Tambah Data Customer</h4>
  <form id="formAddCustomer" method="post">
    <div class="mb-2">
      <label>Nama Customer</label>
      <input type="text" name="nama_customer" class="form-control" required>
    </div>

    <div class="mb-2">
      <label>Perusahaan</label>
      <select name="perusahaan_cust" class="form-select" required>
        <option value="">-- Pilih Perusahaan --</option>
        <?php foreach ($companies as $c): ?>
          <option value="<?= htmlspecialchars($c['nama_perusahaan']) ?>">
            <?= htmlspecialchars($c['nama_perusahaan']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-2">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="customer_list.php" data-load="true" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
$('#formAddCustomer').on('submit', function(e){
  e.preventDefault();
  $.post('customer_add.php', $(this).serialize(), function(response){
    $('#mainContent').html(response);
  });
});
</script>
