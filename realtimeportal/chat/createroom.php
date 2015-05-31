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
echo $T["createroomtitle"];
?>
  </title>
  <link href="chat.css" rel="stylesheet" type="text/css" />
</head>
<?php
$room = urldecode($_GET["room"]);
$user = urldecode($_GET["user"]);
$ps = $_GET["ps"];
if(!empty($room) && !empty($user) && !empty($ps)) {
  include_once("roommanager.php");
  $roomexist = ! CreateRoom($room, $ps);
  if (! $roomexist) {
    echo '<meta http-equiv="refresh" content="1;URL=receive.php?room='.urlencode($room).'&amp;user='.urlencode($user).'&amp;ps='.$ps.'" />';
  }
}
?>
<body class="h">
  <div id="nav" class="g">
    <?php
      echo '<a class="c" href="index.php?hl='.$hl.'">'.$T["home_page"].'</a>';
    ?>
  </div>
  <div class="cr">
    <form class="f" action="createroom.php" method="get">
      <div>
        <span><?php echo $T["roomdispname"] ?></span>
      </div>
      <div>
        <?php
        if(!empty($user)) {
          echo '<input type="text" name="user" value="'.$user.'" />';
        } else {
          echo '<input type="text" name="user" />';
        }
        ?>
      </div>
      <div>
        <span><?php echo $T["roomname"] ?></span>
      </div>
      <div>
        <?php
        if(!empty($room)) {
          echo '<input type="text" name="room" value="'.$room.'" />';
          if ($roomexist) {
            echo '<div><font color="red">'.$T["room_exist"].'</font></div>';
          }
        } else {
          echo '<input type="text" name="room" />';
        }
        ?>
      </div>
      <div>
        <span><?php echo $T["roompassword"] ?></span>
      </div>
      <div>
        <input type="password" name="ps" />
      </div>
      <div align="left">
        <?php
          echo '<input type="submit" name="submit" value="'.$T["createroombutton"].'" />';
        ?>
      </div>
    </form>
  </div>
</body>
</html>
