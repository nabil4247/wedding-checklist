<?php
require_once __DIR__.'/../db.php';
$id = (int)($_GET['id'] ?? 0);
if($id>0){
  $stmt=$pdo->prepare('DELETE FROM responsibles WHERE id=?');
  $stmt->execute([$id]);
}
header('Location: ../index.php?page=responsibles');
