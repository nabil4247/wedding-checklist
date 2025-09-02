<?php
require_once __DIR__.'/../db.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="checklists.csv"');
$out = fopen('php://output','w');

fputcsv($out, ['ID','Judul','Detail','Kategori','Subevent','Fase','Lokasi','Jatuh Tempo','PIC','Prioritas','Status','Dibuat','Diubah']);
foreach($pdo->query('SELECT * FROM checklists ORDER BY id DESC') as $r){
  fputcsv($out, [
    $r['id'],$r['title'],$r['detail'],$r['category'],$r['subevent'],$r['phase'],$r['location'],$r['due_date'],$r['assigned_to'],$r['priority'],$r['status'],$r['created_at'],$r['updated_at']
  ]);
}
fclose($out);
