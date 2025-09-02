<?php
$q = trim($_GET['q'] ?? '');
$active = $_GET['active'] ?? '';

$where = [];
$params = [];
if ($q !== '') {
  $where[] = "(label LIKE :q OR person_name LIKE :q OR phone LIKE :q OR whatsapp LIKE :q OR email LIKE :q)";
  $params[':q'] = '%'.$q.'%';
}
if ($active !== '') {
  $where[] = "is_active = :active";
  $params[':active'] = (int)($active === '1' ? 1 : 0);
}

$sql = "SELECT * FROM responsibles";
if ($where) { $sql .= " WHERE ".implode(" AND ", $where); }
$sql .= " ORDER BY is_active DESC, label ASC, person_name ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Penanggung Jawab</h3>
    <div class="card-tools">
      <a href="?page=responsible_add" class="btn btn-sm btn-success"><i class="fas fa-plus mr-1"></i> Tambah</a>
    </div>
  </div>
  <div class="card-body">
    <form class="mb-3">
      <div class="form-row">
        <div class="col-md-4"><input type="text" name="q" class="form-control" placeholder="Cari jabatan/nama/kontak..." value="<?=e($q)?>"></div>
        <div class="col-md-2">
          <select name="active" class="form-control">
            <option value="">Semua Status</option>
            <option value="1" <?= selected($active,'1') ?>>Aktif</option>
            <option value="0" <?= selected($active,'0') ?>>Nonaktif</option>
          </select>
        </div>
      </div>
      <div class="mt-2">
        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-filter mr-1"></i> Filter</button>
        <a class="btn btn-default btn-sm" href="?page=responsibles"><i class="fas fa-undo mr-1"></i> Reset</a>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr><th>#</th><th>Jabatan</th><th>Nama</th><th>Kontak</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php foreach($rows as $i=>$r): ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td><?= e($r['label']) ?></td>
            <td><?= e($r['person_name'] ?: '-') ?></td>
            <td>
              <?php if($r['phone']): ?>📞 <?= e($r['phone']) ?><br><?php endif; ?>
              <?php if($r['whatsapp']): ?>🟢 WA: <?= e($r['whatsapp']) ?><br><?php endif; ?>
              <?php if($r['email']): ?>✉️ <?= e($r['email']) ?><?php endif; ?>
            </td>
            <td>
              <?php if((int)$r['is_active']===1): ?><span class="badge badge-success">Aktif</span><?php else: ?><span class="badge badge-secondary">Nonaktif</span><?php endif; ?>
            </td>
            <td>
              <a class="btn btn-xs btn-primary" href="?page=responsible_edit&id=<?= $r['id'] ?>" title="Edit"><i class="fas fa-edit"></i></a>
              <a class="btn btn-xs btn-danger" href="actions/delete_responsible.php?id=<?= $r['id'] ?>" onclick="return confirm('Hapus data ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if(empty($rows)): ?><tr><td colspan="6" class="text-center text-muted">Belum ada data.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
