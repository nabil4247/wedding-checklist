<?php
require_once __DIR__.'/../db.php';
require_once __DIR__.'/../helpers.php';

$id          = (int)($_POST['id'] ?? 0);
$label       = trim($_POST['label'] ?? '');
$person_name = trim($_POST['person_name'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$whatsapp    = trim($_POST['whatsapp'] ?? '');
$email       = trim($_POST['email'] ?? '');
$notes       = trim($_POST['notes'] ?? '');
$is_active   = isset($_POST['is_active']) ? 1 : 0;

if($label===''){ header('Location: ../index.php?page=responsible_add'); exit; }

try{
  if($id>0){
    $stmt=$pdo->prepare('UPDATE responsibles SET label=?, person_name=?, phone=?, whatsapp=?, email=?, notes=?, is_active=? WHERE id=?');
    $stmt->execute([$label,$person_name,$phone,$whatsapp,$email,$notes,$is_active,$id]);
  }else{
    $stmt=$pdo->prepare('INSERT INTO responsibles (label, person_name, phone, whatsapp, email, notes, is_active) VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([$label,$person_name,$phone,$whatsapp,$email,$notes,$is_active]);
  }
  header('Location: ../index.php?page=responsibles');
}catch(Throwable $e){
  http_response_code(500);
  echo 'Error: '.e($e->getMessage());
}
