<?php
require_once __DIR__ . '/../Models/BaseModel.php';
class AuthController {
  private $db;
  public function __construct(){
    $this->db = Database::getInstance();
  }
  public function register($u,$p){
    $hash = password_hash($p,PASSWORD_DEFAULT);
    $stmt = $this->db->prepare("INSERT INTO users (username,password_hash,role) VALUES (?,?, 'admin')");
    return $stmt->execute([$u,$hash]);
  }
  public function login($u,$p){
    $stmt = $this->db->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->execute([$u]);
    $usr=$stmt->fetch();
    if($usr && password_verify($p,$usr['password_hash'])){
      $_SESSION['user']=$usr; return true;
    }
    return false;
  }
}
