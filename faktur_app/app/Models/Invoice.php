<?php
require_once 'BaseModel.php';
class Invoice extends BaseModel {
  public function create($data, $items) {
    $this->db->beginTransaction();
    $stmt = $this->db->prepare("INSERT INTO faktur (no_faktur, tgl_faktur, due_date, metode_bayar, ppn, dp, grand_total, user_create, id_customer, id_perusahaan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$data['no_faktur'],$data['tgl_faktur'],$data['due_date'],$data['metode_bayar'],$data['ppn'],$data['dp'],$data['grand_total'],$data['user_create'],$data['id_customer'],$data['id_perusahaan']]);

    $stmtItem = $this->db->prepare("INSERT INTO faktur_items (no_faktur, id_produk, qty, price, sub_total) VALUES (?, ?, ?, ?, ?)");
    foreach ($items as $it) {
      $stmtItem->execute([$data['no_faktur'],$it['id_produk'],$it['qty'],$it['price'],$it['sub_total']]);
      $this->db->prepare("UPDATE produk SET stock=stock-? WHERE id_produk=?")->execute([$it['qty'],$it['id_produk']]);
    }
    $this->db->commit();
  }
}
