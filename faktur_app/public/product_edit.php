<?php
require_once __DIR__.'/../app/Models/Product.php';
require_once __DIR__.'/../app/Helpers/auth.php';
checkAuth();

$model = new Product();
$id = $_GET['id'] ?? null;

if (!$id) {
  echo "<script>alert('ID tidak ditemukan!'); $('#mainContent').load('product_list.php');</script>";
  exit;
}

$product = $model->db->query("SELECT * FROM produk WHERE id_produk=$id")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $model->db->prepare("UPDATE produk SET nama_produk=?, price=?, jenis=?, stock=? WHERE id_produk=?");
  $stmt->execute([$_POST['nama_produk'], $_POST['price'], $_POST['jenis'], $_POST['stock'], $id]);
  echo "<script>$('#mainContent').load('product_list.php');</script>";
  exit;
}
?>

<div class="container">
  <h4>Edit Data Produk</h4>
  <form id="formEditProduct" method="post">
    <div class="mb-2">
      <label>Nama Produk</label>
      <input name="nama_produk" value="<?= htmlspecialchars($product['nama_produk']) ?>" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Harga</label>
      <input name="price" value="<?= htmlspecialchars($product['price']) ?>" class="form-control" type="number" required>
    </div>
    <div class="mb-2">
      <label>Jenis</label>
      <input name="jenis" value="<?= htmlspecialchars($product['jenis']) ?>" class="form-control">
    </div>
    <div class="mb-2">
      <label>Stok</label>
      <input name="stock" value="<?= htmlspecialchars($product['stock']) ?>" class="form-control" type="number">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="product_list.php" data-load="true" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
$('#formEditProduct').on('submit', function(e){
  e.preventDefault();
  $.post('product_edit.php?id=<?= $id ?>', $(this).serialize(), function(res){
    $('#mainContent').html(res);
  });
});
</script>
