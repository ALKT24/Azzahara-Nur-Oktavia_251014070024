<?php
require_once 'BaseModel.php';
class Product extends BaseModel {
  public function all() {
    return $this->db->query("SELECT * FROM produk ORDER BY id_produk DESC")->fetchAll();
  }
}
