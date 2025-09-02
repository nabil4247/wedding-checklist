<?php
require_once __DIR__.'/../db.php';
require_once __DIR__.'/../helpers.php';

$id          = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title       = trim($_POST['title'] ?? '');
$detail      = trim($_POST['detail'] ?? '');
$category    = $_POST['category'] ?? 'pra';
$subevent    = $_POST['subevent'] ?? 'akad';
$phase       = $_POST['phase'] ?? 'sebelum';
$location    = $_POST['location'] ?? 'masjid';
$due_date_in = $_POST['due_date'] ?? '';
$assigned_to = trim($_POST['assigned_to'] ?? '');
$priority    = $_POST['priority'] ?? 'normal';
$status      = $_POST['status'] ?? 'todo';

$due_date = $due_date_in ? date('Y-m-d H:i:s', strtotime($due_date_in)) : null;

if($title===''){
  header('Location: ../index.php?page=checklist_add');
  exit;
}

try{
  if($id>0){
    $sql = 'UPDATE checklists SET title=?, detail=?, category=?, subevent=?, phase=?, location=?, due_date=?, assigned_to=?, priority=?, status=? WHERE id=?';
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$title,$detail,$category,$subevent,$phase,$location,$due_date,$assigned_to,$priority,$status,$id]);
  }else{
    $sql = 'INSERT INTO checklists (title, detail, category, subevent, phase, location, due_date, assigned_to, priority, status) VALUES (?,?,?,?,?,?,?,?,?,?)';
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$title,$detail,$category,$subevent,$phase,$location,$due_date,$assigned_to,$priority,$status]);
  }
  header('Location: ../index.php?page=checklist');
}catch(Throwable $e){
  http_response_code(500);
  echo 'Error: '.e($e->getMessage());
}
