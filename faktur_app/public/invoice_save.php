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

// ambil data dari form
$tgl = $_POST['tgl_faktur'];
$due = $_POST['due_date'];
$metode = $_POST['metode_bayar'];
$id_perusahaan = $_POST['id_perusahaan'];
$id_customer = $_POST['id_customer'];
$produk = $_POST['produk'] ?? [];
$qty = $_POST['qty'] ?? [];

// buat nomor faktur unik
$no_faktur = 'F' . date('YmdHis');

// pakai transaction supaya atomic
try {
  $db->beginTransaction();

  // hitung subtotal dan siapkan array detail
  $subtotal = 0;
  $details = [];

  for ($i = 0; $i < count($produk); $i++) {
    $id = $produk[$i];
    $q = (int) ($qty[$i] ?? 0);

    if ($q <= 0) continue;

    // ambil harga produk
    $stmtP = $db->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmtP->execute([$id]);
    $p = $stmtP->fetch(PDO::FETCH_ASSOC);
    if (!$p) continue;

    $harga = (float) $p['price'];
    $sub = $harga * $q;
    $subtotal += $sub;

    // simpan detail ke array
    $details[] = [
      'id_produk' => $id,
      'qty' => $q,
      'harga' => $harga,
      'subtotal' => $sub
    ];

    // update stok
    $newStock = max(0, (int)$p['stock'] - $q);
    $upd = $db->prepare("UPDATE produk SET stock = ? WHERE id_produk = ?");
    $upd->execute([$newStock, $id]);
  }

  // hitung pajak dan grand total
  $ppn = $subtotal * 0.11;
  $dp = $subtotal * 0.5;
  $grand = $subtotal + $ppn;

  // simpan ke tabel faktur (pastikan kolom no_faktur ada di tabel faktur)
  $stmt = $db->prepare("INSERT INTO faktur 
    (no_faktur, tgl_faktur, due_date, metode_bayar, ppn, dp, grand_total, id_customer, id_perusahaan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([$no_faktur, $tgl, $due, $metode, $ppn, $dp, $grand, $id_customer, $id_perusahaan]);

  // insert ke faktur_detail
  $insDet = $db->prepare("INSERT INTO faktur_detail (no_faktur, id_produk, qty, harga, subtotal) VALUES (?, ?, ?, ?, ?)");
  foreach ($details as $d) {
    $insDet->execute([$no_faktur, $d['id_produk'], $d['qty'], $d['harga'], $d['subtotal']]);
  }

  $db->commit();

  // buka cetak di tab baru dan reload daftar
  echo "<script>
    alert('✅ Faktur berhasil disimpan dan stok produk otomatis berkurang!');
    window.open('invoice_print.php?no={$no_faktur}', '_blank');
    $('#mainContent').load('invoice_list.php');
  </script>";
  exit;

} catch (Exception $e) {
  $db->rollBack();
  die("Gagal menyimpan faktur: " . $e->getMessage());
}
