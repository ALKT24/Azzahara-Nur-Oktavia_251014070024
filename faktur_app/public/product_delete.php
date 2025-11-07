<?php
require_once __DIR__.'/../app/Models/Product.php';
require_once __DIR__.'/../app/Helpers/auth.php';
checkAuth();

$model = new Product();
$id = $_GET['id'] ?? null;

if ($id) {
  $stmt = $model->db->prepare("DELETE FROM produk WHERE id_produk=?");
  $stmt->execute([$id]);
}

require 'product_list.php';
