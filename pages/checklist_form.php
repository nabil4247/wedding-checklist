<?php
$editing = ($page==='checklist_edit');
$item = [
  'id' => null,
  'title' => '',
  'detail' => '',
  'category' => 'pra',
  'subevent' => 'akad',
  'phase' => 'sebelum',
  'location' => 'masjid',
  'due_date' => '',
  'assigned_to' => '',
  'priority' => 'normal',
  'status' => 'todo',
];

if($editing){
  $id = (int)($_GET['id'] ?? 0);
  $stmt = $pdo->prepare('SELECT * FROM checklists WHERE id=?');
  $stmt->execute([$id]);
  $item = $stmt->fetch() ?: $item;
}
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><?= $editing ? 'Edit' : 'Tambah' ?> Checklist</h3>
    <div class="card-tools"><a href="?page=checklist" class="btn btn-sm btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a></div>
  </div>
  <form method="post" action="actions/save_checklist.php">
    <input type="hidden" name="id" value="<?=e($item['id'])?>">
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-8">
          <label class="required">Judul</label>
          <input type="text" name="title" class="form-control" required value="<?=e($item['title'])?>" placeholder="Mis. Cek dokumen KUA">
        </div>
        <?php $resp = $pdo->query("SELECT label, COALESCE(person_name,'') person_name FROM responsibles WHERE is_active=1 ORDER BY label, person_name")->fetchAll(); ?>
        <div class="form-group col-md-4">
          <label>Penanggung Jawab</label>
          <input list="responsible_list" name="assigned_to" class="form-control" value="<?=e($item['assigned_to'])?>" placeholder="Pilih atau ketik jabatan/nama">
          <datalist id="responsible_list">
            <?php foreach($resp as $r): $opt = trim($r["label"].($r["person_name"]? " - ".$r["person_name"] : "")); ?>
              <option value="<?= e($opt) ?>"></option>
            <?php endforeach; ?>
          </datalist>
          <small class="form-text text-muted">Kelola daftar di menu <a href="?page=responsibles">Penanggung Jawab</a>.</small>
        </div>

      </div>

      <div class="form-row">
        <div class="form-group col-md-3">
          <label class="required">Kategori</label>
          <select name="category" class="form-control" required><?=optionTags($CATEGORIES, $item['category'])?></select>
        </div>
        <div class="form-group col-md-3">
          <label class="required">Subevent</label>
          <select name="subevent" class="form-control" required><?=optionTags($SUBEVENTS, $item['subevent'])?></select>
        </div>
        <div class="form-group col-md-3">
          <label class="required">Fase</label>
          <select name="phase" class="form-control" required><?=optionTags($PHASES, $item['phase'])?></select>
        </div>
        <div class="form-group col-md-3">
          <label class="required">Lokasi</label>
          <select name="location" class="form-control" required><?=optionTags($LOCATIONS, $item['location'])?></select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label>Jatuh Tempo</label>
          <input type="datetime-local" name="due_date" class="form-control" value="<?= $item['due_date'] ? e(date('Y-m-d\TH:i', strtotime($item['due_date']))) : '' ?>">
        </div>
        <div class="form-group col-md-4">
          <label class="required">Prioritas</label>
          <select name="priority" class="form-control" required><?=optionTags($PRIORITIES, $item['priority'])?></select>
        </div>
        <div class="form-group col-md-4">
          <label class="required">Status</label>
          <select name="status" class="form-control" required><?=optionTags($STATUS, $item['status'])?></select>
        </div>
      </div>

      <div class="form-group">
        <label>Detail / Catatan</label>
        <textarea name="detail" class="form-control" rows="5" placeholder="Tambahkan catatan teknis, daftar berkas, vendor, dsb."><?=e($item['detail'])?></textarea>
      </div>
    </div>
    <div class="card-footer">
      <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
      <?php if($editing): ?>
        <a class="btn btn-danger float-right" href="actions/delete_checklist.php?id=<?=$item['id']?>" onclick="return confirm('Hapus item ini?')"><i class="fas fa-trash mr-1"></i> Hapus</a>
      <?php endif; ?>
    </div>
  </form>
</div>
