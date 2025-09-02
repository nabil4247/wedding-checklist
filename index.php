<?php
require_once __DIR__.'/db.php';
require_once __DIR__.'/helpers.php';

$page = $_GET['page'] ?? 'dashboard';
$allowed = ['dashboard','checklist','checklist_add','checklist_edit','responsibles','responsible_add','responsible_edit'];
if(!in_array($page,$allowed,true)) $page='dashboard';

function isActive($p){ global $page; return $page===$p ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wedding Checklist</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"/>
  <style>.required:after{content:'*'; color:#e3342f; margin-left:4px}</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="?page=dashboard" class="nav-link">Dashboard</a></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a target="_blank" href="https://adminlte.io" class="nav-link">AdminLTE</a></li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="?page=dashboard" class="brand-link">
      <i class="fas fa-ring ml-2"></i>
      <span class="brand-text font-weight-light ml-2">Wedding Checklist</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item"><a href="?page=dashboard" class="nav-link <?=isActive('dashboard')?>"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="?page=checklist" class="nav-link <?=isActive('checklist')?>"><i class="nav-icon fas fa-tasks"></i><p>Checklist</p></a></li>
          <li class="nav-item"><a href="?page=checklist_add" class="nav-link <?=isActive('checklist_add')?>"><i class="nav-icon fas fa-plus-circle"></i><p>Tambah Checklist</p></a></li>
          <li class="nav-item">
          <a href="?page=responsibles" class="nav-link <?=isActive('responsibles')?>">
            <i class="nav-icon fas fa-users-cog"></i><p>Penanggung Jawab</p>
          </a>
        </li>

          <li class="nav-item"><a href="pages/export_csv.php" class="nav-link"><i class="nav-icon fas fa-file-csv"></i><p>Export CSV</p></a></li>
          <li class="nav-header">Bantuan</li>
          <li class="nav-item"><a href="#" class="nav-link" onclick="alert('Checklist Islamic Wedding - sederhana & cepat.');"><i class="nav-icon fas fa-info-circle"></i><p>Tentang Aplikasi</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        <?php
          if($page==='dashboard')      require __DIR__.'/pages/dashboard.php';
          elseif($page==='checklist')   require __DIR__.'/pages/checklist_list.php';
          elseif($page==='checklist_add') require __DIR__.'/pages/checklist_form.php';
          elseif($page==='checklist_edit') require __DIR__.'/pages/checklist_form.php';
          elseif($page==='responsibles')      require __DIR__.'/pages/responsible_list.php';
          elseif($page==='responsible_add')   require __DIR__.'/pages/responsible_form.php';
          elseif($page==='responsible_edit')  require __DIR__.'/pages/responsible_form.php';
        ?>
      </div>
    </section>
  </div>

  <footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-inline">v1.0</div>
    <strong>&copy; <?=date('Y')?> Wedding Checklist. By @nabil4247</strong>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>
