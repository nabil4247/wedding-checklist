<?php
@date_default_timezone_set('Asia/Jakarta');

$DB_HOST = 'localhost';
$DB_NAME = 'wedding_checklist';
$DB_USER = 'root';
$DB_PASS = '';

$CATEGORIES = [
  'pra'         => 'Pra-Pernikahan',
  'pernikahan'  => 'Hari Pernikahan',
  'pasca'       => 'Pasca-Pernikahan',
];

$SUBEVENTS = [
  'akad'    => 'Akad',
  'resepsi' => 'Resepsi',
];

$PHASES = [
  'sebelum' => 'Sebelum Acara',
  'saat'    => 'Saat Acara',
  'sesudah' => 'Sesudah Acara',
];

$LOCATIONS = [
  'masjid' => 'Masjid',
  'cafe'   => 'Café',
];

$PRIORITIES = [
  'low'    => 'Low',
  'normal' => 'Normal',
  'high'   => 'High',
  'urgent' => 'Urgent',
];

$STATUS = [
  'todo'        => 'To Do',
  'in_progress' => 'In Progress',
  'done'        => 'Done',
];
