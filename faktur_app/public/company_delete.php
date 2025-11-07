<?php
require_once __DIR__.'/../app/Models/Company.php';
require_once __DIR__.'/../app/Helpers/auth.php';
checkAuth();

$model = new Company();
$id = $_GET['id'] ?? null;

if ($id) {
  $stmt = $model->db->prepare("DELETE FROM perusahaan WHERE id_perusahaan=?");
  $stmt->execute([$id]);
}

// langsung kirim ulang tampilan tabel perusahaan
require 'company_list.php';
