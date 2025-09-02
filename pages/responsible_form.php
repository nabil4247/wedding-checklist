<?php
$editing = ($page==='responsible_edit');
$item = [
  'id' => null, 'label' => '', 'person_name' => '',
  'phone' => '', 'whatsapp' => '', 'email' => '',
  'notes' => '', 'is_active' => 1,
];
if ($editing) {
  $id = (int)($_GET['id'] ?? 0);
  $stmt = $pdo->prepare("SELECT * FROM responsibles WHERE id=?");
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  if ($data) { $item = $data; }
}
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><?= $editing ? 'Edit' : 'Tambah' ?> Penanggung Jawab</h3>
    <div class="card-tools"><a href="?page=responsibles" class="btn btn-sm btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a></div>
  </div>
  <form method="post" action="actions/save_responsible.php">
    <input type="hidden" name="id" value="<?= e($item['id']) ?>">
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label class="required">Jabatan / Koordinator</label>
          <input type="text" name="label" class="form-control" required placeholder="Mis. Koor Acara" value="<?= e($item['label']) ?>">
        </div>
        <div class="form-group col-md-6">
          <label>Nama Orangnya (opsional)</label>
          <input type="text" name="person_name" class="form-control" placeholder="Mis. Ahmad" value="<?= e($item['person_name']) ?>">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4"><label>Telepon</label><input type="text" name="phone" class="form-control" value="<?= e($item['phone']) ?>"></div>
        <div class="form-group col-md-4"><label>WhatsApp</label><input type="text" name="whatsapp" class="form-control" value="<?= e($item['whatsapp']) ?>"></div>
        <div class="form-group col-md-4"><label>Email</label><input type="email" name="email" class="form-control" value="<?= e($item['email']) ?>"></div>
      </div>
      <div class="form-group"><label>Catatan</label><textarea name="notes" rows="3" class="form-control"><?= e($item['notes']) ?></textarea></div>
      <div class="form-group form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="activeChk" <?= (int)$item['is_active']===1 ? 'checked' : '' ?>>
        <label for="activeChk" class="form-check-label">Aktif</label>
      </div>
    </div>
    <div class="card-footer">
      <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
      <?php if($editing): ?><a class="btn btn-danger float-right" href="actions/delete_responsible.php?id=<?= e($item['id']) ?>" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash mr-1"></i> Hapus</a><?php endif; ?>
    </div>
  </form>
</div>
