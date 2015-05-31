<?php header('Content-type: application/vnd.wap.xhtml+xml;charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$hl = strtolower($_GET['hl']);
if (empty($hl)) {
  $hl = 'zh-cn';
}
include_once("${hl}.php");
?>
<head>
  <title>
<?php
$room = urldecode(trim($_GET['room']));
if (empty($room)) {
  $room = "test";
}
$user = urldecode(trim($_GET['user']));
if (empty($user)) {
  $user = "test";
}
$ps = $_GET['ps'];
if (empty($ps)) {
  $ps = "test";
}
print $room.' - '.$user.$T['send_title'];
?>
  </title>
  <link href="chat.css" rel="stylesheet" type="text/css" />
</head>

<body class="h">
  <div id="nav" class="g">
    <?php
      echo '<a class="c" href="index.php?hl='.$hl.'">'.$T['home_page'].'</a>';
    ?>
  </div>
  <div>
    <form class="f" method="get" action="receive.php">
      <div>
        <?php print $T['input'] ?>
      </div>
      <div>
        <textarea type="text" name="text" />
      </div>
      <div>
        <?php
          echo '<input type="submit" value="'.$T["sendmsgbutton"].'" />';
        ?>
        <input type="hidden" name="op" value="send" />
<?php
echo '<input type="hidden" name="room" value="'.$room.'" />';
echo '<input type="hidden" name="user" value="'.$user.'" />';
echo '<input type="hidden" name="ps" value="'.$ps.'" />';
echo '<input type="hidden" name="hl" value="'.$hl.'" />'
?>
      </div>
    </form>
  </div>
</body>
</html>
