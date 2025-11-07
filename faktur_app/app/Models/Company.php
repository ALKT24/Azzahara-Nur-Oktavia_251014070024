<?php
require_once 'BaseModel.php';

class Company extends BaseModel {
  public function all() {
    return $this->db->query("SELECT * FROM perusahaan ORDER BY id_perusahaan DESC")->fetchAll();
  }
  public function find($id) {
    $stmt = $this->db->prepare("SELECT * FROM perusahaan WHERE id_perusahaan=?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }
  public function create($data) {
    $stmt = $this->db->prepare("INSERT INTO perusahaan (nama_perusahaan, alamat, no_telp, fax) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$data['nama_perusahaan'],$data['alamat'],$data['no_telp'],$data['fax']]);
  }
  public function update($id, $data) {
    $stmt = $this->db->prepare("UPDATE perusahaan SET nama_perusahaan=?, alamat=?, no_telp=?, fax=? WHERE id_perusahaan=?");
    return $stmt->execute([$data['nama_perusahaan'],$data['alamat'],$data['no_telp'],$data['fax'],$id]);
  }
  public function delete($id) {
    $stmt = $this->db->prepare("DELETE FROM perusahaan WHERE id_perusahaan=?");
    return $stmt->execute([$id]);
  }
}
