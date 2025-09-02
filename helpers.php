<?php
require_once __DIR__.'/config.php';

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function selected($a, $b){ return (string)$a === (string)$b ? 'selected' : ''; }
function checked($a, $b){ return (string)$a === (string)$b ? 'checked' : ''; }

function optionTags(array $opts, $current=null){
  $out='';
  foreach($opts as $val=>$label){
    $out .= '<option value="'.e($val).'" '.selected($current,$val).'>'.e($label)."</option>";
  }
  return $out;
}

function badgeStatus($status){
  $map = [
    'todo'        => 'secondary',
    'in_progress' => 'warning',
    'done'        => 'success',
  ];
  $cls = $map[$status] ?? 'secondary';
  return '<span class="badge badge-'.$cls.'">'.e(statusLabel($status)).'</span>';
}

function statusLabel($key){
  global $STATUS; return $STATUS[$key] ?? $key;
}
function categoryLabel($key){ global $CATEGORIES; return $CATEGORIES[$key] ?? $key; }
function subeventLabel($key){ global $SUBEVENTS;  return $SUBEVENTS[$key]  ?? $key; }
function phaseLabel($key){    global $PHASES;     return $PHASES[$key]     ?? $key; }
function locationLabel($key){ global $LOCATIONS;  return $LOCATIONS[$key]  ?? $key; }
function priorityLabel($key){ global $PRIORITIES; return $PRIORITIES[$key] ?? $key; }
