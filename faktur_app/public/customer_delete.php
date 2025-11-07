<?php
require_once __DIR__.'/../app/Models/Customer.php';
require_once __DIR__.'/../app/Helpers/auth.php';
checkAuth();

$model = new Customer();
$id = $_GET['id'] ?? null;

if ($id) {
  $stmt = $model->db->prepare("DELETE FROM customer WHERE id_customer=?");
  $stmt->execute([$id]);
}

require 'customer_list.php';
