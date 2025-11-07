<?php
require_once __DIR__ . '/../../config/database.php';

class BaseModel {
  public $db;
  public function __construct() {
    $this->db = Database::getInstance();
  }
}
