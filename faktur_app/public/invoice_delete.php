<?php
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();

// koneksi database
try {
  $db = new PDO('mysql:host=localhost;dbname=faktur_app', 'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Koneksi gagal: " . $e->getMessage());
}

// ambil nomor faktur dari URL
$no = $_GET['no'] ?? '';
if (!$no) {
  die("<script>alert('Nomor faktur tidak ditemukan!'); history.back();</script>");
}

// hapus detail faktur (kalau ada tabel faktur_detail, bisa di-skip kalau gak ada)
try {
  $db->prepare("DELETE FROM faktur_detail WHERE no_faktur = ?")->execute([$no]);
} catch (PDOException $e) {
  // tabel faktur_detail mungkin gak ada, lewati aja
}

// hapus data utama faktur
$stmt = $db->prepare("DELETE FROM faktur WHERE no_faktur = ?");
$stmt->execute([$no]);

// cek: apakah dijalankan lewat AJAX (dari layout)
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
  echo "<script>
    alert('✅ Faktur berhasil dihapus!');
    $('#mainContent').load('invoice_list.php');
  </script>";
} else {
  echo "<script>
    alert('✅ Faktur berhasil dihapus!');
    window.location.href = 'layout.php';
  </script>";
}
exit;
