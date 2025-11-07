<?php
require_once 'BaseModel.php';
class Customer extends BaseModel {
  public function all() {
    return $this->db->query("SELECT * FROM customer ORDER BY id_customer DESC")->fetchAll();
  }
}
