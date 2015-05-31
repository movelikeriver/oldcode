<?php header('Content-type: application/vnd.wap.xhtml+xml;charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
<?php
$hl = strtolower($_GET["hl"]);
if (empty($hl)) {
  $hl = "zh-cn";
}
include_once("${hl}.php");
echo $T["indextitle"];
?>
  </title>
  <link href="chat.css" rel="stylesheet" type="text/css" />
</head>

<body class="h">
  <div id="nav" class="g">
    <?php
      echo '<a class="c" href="createroom.php?hl='.$hl.'">'.$T['createroomtitle'] .'</a>';
    ?>
  </div>

<?php
include_once("roommanager.php");
$room_arr = GetRoomArray();
if($room_arr != null) {
  echo '<div class="a">';
  echo '<span>'.$T["chooseroom"].'</span>';
  foreach ($room_arr as $room) {
    echo '<div class="a">';
    echo '<a href="receive.php?hl='.$hl.'&amp;room='.urlencode($room).'">'.$room.'</a>';
    echo '</div>';
  }
  echo '</div>';
}
?>

</body>
</html>
