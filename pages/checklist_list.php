<?php
$where  = [];
$params = [];

/** ========== FILTERS ========== */
$filters = ['category','subevent','phase','location','status'];
foreach ($filters as $f) {
  if (isset($_GET[$f]) && $_GET[$f] !== '') {
    $where[]           = "$f = :$f";
    $params[":$f"]     = $_GET[$f];
  }
}
if (!empty($_GET['assigned_to'])) {
  $where[]                 = "(assigned_to LIKE :assigned_to)";
  $params[':assigned_to']  = '%'.$_GET['assigned_to'].'%';
}
if (!empty($_GET['q'])) {
  $where[]        = "(title LIKE :q OR detail LIKE :q)";
  $params[':q']   = '%'.$_GET['q'].'%';
}

/** ========== QUERY ========== */
$sql = 'SELECT * FROM checklists';
if ($where) { $sql .= ' WHERE '.implode(' AND ', $where); }
$sql .= " ORDER BY FIELD(status,'todo','in_progress','done'), COALESCE(due_date,'9999-12-31') ASC, id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

/** ========== OPTIONS PENANGGUNG JAWAB ========== */
$assignedOpts = $pdo->query("
  SELECT DISTINCT assigned_to AS x
  FROM checklists
  WHERE assigned_to IS NOT NULL AND assigned_to <> ''
  ORDER BY x
")->fetchAll();
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Checklist</h3>
    <div class="card-tools">
      <a href="?page=checklist_add" class="btn btn-sm btn-success"><i class="fas fa-plus mr-1"></i> Tambah</a>
    </div>
  </div>

  <div class="card-body">
    <form class="mb-3" method="get">
      <input type="hidden" name="page" value="checklist">

      <div class="form-row">
        <div class="col-md-2">
          <input type="text" name="q" class="form-control" placeholder="Cari..." value="<?= e($_GET['q'] ?? '') ?>">
        </div>
        <div class="col-md-2">
          <select name="category" class="form-control">
            <option value="">Kategori</option><?= optionTags($CATEGORIES, $_GET['category'] ?? '') ?>
          </select>
        </div>
        <div class="col-md-2">
          <select name="subevent" class="form-control">
            <option value="">Subevent</option><?= optionTags($SUBEVENTS, $_GET['subevent'] ?? '') ?>
          </select>
        </div>
        <div class="col-md-2">
          <select name="phase" class="form-control">
            <option value="">Fase</option><?= optionTags($PHASES, $_GET['phase'] ?? '') ?>
          </select>
        </div>
        <div class="col-md-2">
          <select name="location" class="form-control">
            <option value="">Lokasi</option><?= optionTags($LOCATIONS, $_GET['location'] ?? '') ?>
          </select>
        </div>

        <!-- Paksa baris baru di layar md ke atas (biar rapi), boleh dihapus jika tidak perlu -->
        <div class="w-100 d-none d-md-block"></div>

        <div class="col-md-2">
          <input list="assigned_list" name="assigned_to" class="form-control"
                 placeholder="Penanggung Jawab"
                 value="<?= e($_GET['assigned_to'] ?? '') ?>">
          <datalist id="assigned_list">
            <?php foreach ($assignedOpts as $r): ?>
              <option value="<?= e($r['x']) ?>"></option>
            <?php endforeach; ?>
          </datalist>
        </div>
        <div class="col-md-2">
          <select name="status" class="form-control">
            <option value="">Status</option><?= optionTags($STATUS, $_GET['status'] ?? '') ?>
          </select>
        </div>
      </div>

      <div class="mt-2">
        <button class="btn btn-primary btn-sm" type="submit">
          <i class="fas fa-filter mr-1"></i> Filter
        </button>
        <a class="btn btn-default btn-sm" href="?page=checklist">
          <i class="fas fa-undo mr-1"></i> Reset
        </a>
      </div>
    </form>

    <div class="table-responsive">
      <table id="tbl" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Subevent</th>
            <th>Fase</th>
            <th>Lokasi</th>
            <th>Jatuh Tempo</th>
            <th>Penanggung Jawab</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $i => $c): ?>
          <tr>
            <td><?= ($i+1) ?></td>
            <td><?= e($c['title']) ?></td>
            <td><?= e(categoryLabel($c['category'])) ?></td>
            <td><?= e(subeventLabel($c['subevent'])) ?></td>
            <td><?= e(phaseLabel($c['phase'])) ?></td>
            <td><?= e(locationLabel($c['location'])) ?></td>
            <td><?= $c['due_date'] ? e(date('d M Y H:i', strtotime($c['due_date']))) : '-' ?></td>
            <td><?= e($c['assigned_to'] ?: '-') ?></td>
            <td><?= e(priorityLabel($c['priority'])) ?></td>
            <td><?= badgeStatus($c['status']) ?></td>
            <td>
              <!-- Edit -->
              <a class="btn btn-xs btn-primary" href="?page=checklist_edit&id=<?= $c['id'] ?>" title="Edit">
                <i class="fas fa-edit"></i>
              </a>

              <!-- On Progress (hanya muncul jika masih To Do) -->
              <?php if ($c['status'] === 'todo'): ?>
                <a class="btn btn-xs btn-warning"
                   href="actions/update_status.php?id=<?= $c['id'] ?>&to=in_progress"
                   onclick="return confirm('Tandai sebagai On Progress?')"
                   title="Tandai On Progress">
                  <i class="fas fa-hourglass-half"></i>
                </a>
              <?php endif; ?>

              <!-- Done -->
              <a class="btn btn-xs btn-success"
                 href="actions/update_status.php?id=<?= $c['id'] ?>&to=done"
                 onclick="return confirm('Tandai selesai?')"
                 title="Tandai Selesai">
                <i class="fas fa-check"></i>
              </a>

              <!-- Delete -->
              <a class="btn btn-xs btn-danger"
                 href="actions/delete_checklist.php?id=<?= $c['id'] ?>"
                 onclick="return confirm('Hapus item ini?')"
                 title="Hapus">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  $(function(){
    $('#tbl').DataTable({ pageLength: 25 });
    // Auto-submit saat dropdown diganti (opsional)
    $('form select').on('change', function(){ this.form.submit(); });
  });
</script>
