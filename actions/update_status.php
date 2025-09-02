<?php
require_once __DIR__.'/../db.php';
$id = (int)($_GET['id'] ?? 0);
$to = $_GET['to'] ?? 'done';
$allowed = ['todo','in_progress','done'];
if(!in_array($to,$allowed,true)) $to='done';

if($id>0){
  $stmt = $pdo->prepare('UPDATE checklists SET status=? WHERE id=?');
  $stmt->execute([$to,$id]);
}
header('Location: ../index.php?page=checklist');
