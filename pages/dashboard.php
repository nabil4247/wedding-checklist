<?php
$statStmt = $pdo->query("SELECT status, COUNT(*) c FROM checklists GROUP BY status");
$stats = ['todo'=>0,'in_progress'=>0,'done'=>0];
foreach($statStmt as $r){ $stats[$r['status']] = (int)$r['c']; }

$upcoming = $pdo->query("SELECT * FROM checklists WHERE due_date IS NOT NULL AND status <> 'done' ORDER BY due_date ASC LIMIT 10")->fetchAll();
?>
<div class="row">
  <div class="col-12 col-sm-4">
    <div class="small-box bg-secondary"><div class="inner"><h3><?=$stats['todo']?></h3><p>To Do</p></div><div class="icon"><i class="fas fa-clipboard-list"></i></div><a href="?page=checklist&status=todo" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a></div>
  </div>
  <div class="col-12 col-sm-4">
    <div class="small-box bg-warning"><div class="inner"><h3><?=$stats['in_progress']?></h3><p>In Progress</p></div><div class="icon"><i class="fas fa-spinner"></i></div><a href="?page=checklist&status=in_progress" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a></div>
  </div>
  <div class="col-12 col-sm-4">
    <div class="small-box bg-success"><div class="inner"><h3><?=$stats['done']?></h3><p>Selesai</p></div><div class="icon"><i class="fas fa-check"></i></div><a href="?page=checklist&status=done" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a></div>
  </div>
</div>

<div class="card">
  <div class="card-header"><h3 class="card-title">Jadwal Terdekat</h3><div class="card-tools"><a href="?page=checklist" class="btn btn-sm btn-primary"><i class="fas fa-tasks mr-1"></i> Kelola Checklist</a></div></div>
  <div class="card-body p-0 table-responsive">
    <table class="table table-striped mb-0">
      <thead><tr>
        <th>Judul</th><th>Kategori</th><th>Subevent</th><th>Fase</th><th>Lokasi</th><th>Jatuh Tempo</th><th>Status</th>
      </tr></thead>
      <tbody>
      <?php if(!$upcoming): ?>
        <tr><td colspan="7" class="text-center text-muted">Tidak ada jadwal terdekat.</td></tr>
      <?php else: foreach($upcoming as $c): ?>
        <tr>
          <td><?=e($c['title'])?></td>
          <td><?=e(categoryLabel($c['category']))?></td>
          <td><?=e(subeventLabel($c['subevent']))?></td>
          <td><?=e(phaseLabel($c['phase']))?></td>
          <td><?=e(locationLabel($c['location']))?></td>
          <td><?= $c['due_date'] ? e(date('d M Y H:i', strtotime($c['due_date']))) : '-' ?></td>
          <td><?=badgeStatus($c['status'])?></td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
