<?php
function GetRoomPassArray() {
  include("config.php");
  if (! file_exists($room_list_file)) {
    return null;
  }
  return file($room_list_file);
}

function GetRoomArray() {
  include("config.php");
  $lines = GetRoomPassArray();
  if (! $lines) {
    return null;
  }
  $ar = array();
  foreach ($lines as $line) {
    $room_ps = explode($split, $line);
    array_push($ar, $room_ps[0]);
  }
  return $ar;
}

function CreateFile() {
  include("config.php");
  if (file_exists($room_list_file)) {
    return false;
  }
  $fh = fopen($room_list_file, 'w') or die('Could not open '.$room_list_file);
  fwrite($fh, '');
  fclose($fh);
  return true;
}

function ValidUserRoomPass($user, $room, $ps) {
  include("config.php");
  if (! file_exists($room_list_file)) {
    return -1;
  }
  $room_arr = GetRoomPassArray();
  if (! $room_arr) {
    return -1;
  }
  foreach ($room_arr as $line) {
    $ar = explode($split, $line);
    if ($room == $ar[0]) {
      if ($ps == $empty_pass || $ps == trim($ar[1])) {
        return 1;
      }
    }
  }
  return 0;
}

function HasRoom($room) {
  include("config.php");
  return 1 == ValidUserRoomPass("", $room, $empty_pass);
}

function CreateRoom($room, $ps) {
  include("config.php");
  if (! file_exists($room_list_file)) {
    CreateFile();
  } else if (HasRoom($room)) {
    return false;
  }
  if (empty($ps)) {
    $ps = $empty_pass;
  }
  $fh = fopen($room_list_file, "a+") or die('could not open file: '.$room_list_file);
  fwrite($fh, $room.$split.$ps."\r\n");
  fclose($fh);
  return true;
}
?>
