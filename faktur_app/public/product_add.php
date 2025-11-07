<?php
require_once __DIR__ . '/../app/Models/Product.php';
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();
$model = new Product();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $model->db->prepare("INSERT INTO produk (nama_produk, price, jenis, stock) VALUES (?, ?, ?, ?)");
  $stmt->execute([$_POST['nama_produk'], $_POST['price'], $_POST['jenis'], $_POST['stock']]);
  echo "<script>$('#mainContent').load('product_list.php');</script>";
  exit;
}
?>

<div class="container">
  <h4>Tambah Data Produk</h4>
  <form id="formAddProduct" method="post">
    <div class="mb-2">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Harga</label>
      <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Jenis</label>
      <input type="text" name="jenis" class="form-control">
    </div>
    <div class="mb-2">
      <label>Stok</label>
      <input type="number" name="stock" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="product_list.php" data-load="true" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
$('#formAddProduct').on('submit', function(e){
  e.preventDefault();
  $.post('product_add.php', $(this).serialize(), function(response){
    $('#mainContent').html(response);
  });
});
</script>
