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
$room = urldecode(trim($_GET["room"]));
$user = urldecode(trim($_GET["user"]));
// (TODO) user cannot pass the ps with "_".
$ps = trim($_GET["ps"]);
echo $room." - ".$user." ".$T["receive_title"];
?>
    </title>
    <link href="chat.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="h">
<?php
$pass = false;
if (! empty($ps)) {
  include_once("roommanager.php");
  if (1 == ValidUserRoomPass($user, $room, $ps)) {
    $pass = true;
  }
}
?>
<?php
$querystrings = explode('&', $_SERVER['QUERY_STRING']);
$query_string;
foreach ($querystrings as $q) {
  if (substr($q, 0, 3) == "op=") {
    continue;
  }
  if (empty($query_string)) {
    $query_string = $q;
  } else {
    $query_string = $query_string.'&amp;'.$q;
  }
}

if ($pass) {
  echo '<meta http-equiv="Cache-Control" content="no-cache" />';
  echo '<meta http-equiv="refresh" content="15;url=receive.php?'.$query_string.'"/>';
?>
<?php
}
?>
    <div id="nav" class="g">
<?php
echo '<a class="c" href="index.php?hl='.$hl.'">'.$T['home_page'].'</a>';
echo '<a class="c" href="send.php?'.$query_string.'">'.$T["send"].'</a>';
echo '<a class="c" href="createroom.php?hl='.$hl.'">'.$T["createroomtitle"].'</a>';
?>
    </div>

<?php
if ($pass) {
?>
    <div>
<?php
  $file_buddy = 'data/'.$room.'_buddy.html';
  $file_msg = 'data/'.$room.'_msg.html';
  $has_user = false;
  $buddy_arr = array();
  if (! file_exists($file_buddy)) {
    $fh = fopen($file_buddy, 'w') or die('Could not open '.$file_buddy);
    fwrite($fh, "");
    fclose($fh);
  } else {
    $buddy_arr = file($file_buddy);
    foreach ($buddy_arr as $buddy) {
      if (trim($buddy) == $user) {
        $has_user = true;
        break;
      }
    }
  }

  if (! $has_user) {
    $fh = fopen($file_buddy, "a+") or die('could not open file: '.$file_buddy);
    fwrite($fh, $user."\r\n");
    fclose($fh);
    array_push($buddy_arr, '<span class="c">'.$user.'</span>');
  }

  $buddy_html = join(", ", $buddy_arr);
  echo $T['buddy'].'<div class="cr">'.$buddy_html.'</div>';

  // Now, begin to generate messages.
  echo "<hr />";
  $msg_arr = array();
  if (! file_exists($file_msg)) {
    $fh = fopen($file_msg, 'w') or die('Could not open '.$file_msg);
    fwrite($fh, '');
    fclose($fh);
  } else {
    $msg_arr = file($file_msg);
  }

  // User just send a message.
  $text = $_GET["text"];
  date_default_timezone_set("Asia/Shanghai");
  $t = date("H:i");
  $text = "($t) ".$text;
  if ($_GET['op'] == 'send' && !empty($text)) {
    $inputline = $user.': '.$text;
    $fh = fopen($file_msg, "a+") or die('could not open file: '.$file_msg);
    fwrite($fh, $inputline."\r\n");
    fclose($fh);
    array_push($msg_arr, $inputline);
  }

  $showline = 1;
  $maxline = count($msg_arr);
  while ($showline <= 10) {
    $msg_html = $msg_html.'<div class="c">'.$msg_arr[$maxline - $showline].'</div>';
    $showline++;
  }
  echo '<div class="a">'.$T['chat'].$msg_html.'</div>';
?>
    </div>

<?php
} else {
?>
    <div class="cr">
      <form class="f" action="receive.php" method="get">
        <div>
          <span><?php echo $T["roomname"] ?></span>
        </div>
        <div>
          <?php
          if (!empty($room)) {
            echo '<input type="text" name="room" value="'.$room.'" />';
          } else {
            echo '<input type="text" name="room" />';
          }
          ?>
        </div>
        <div>
          <span><?php echo $T["roomdispname"] ?></span>
        </div>
        <div>
          <?php
          if (!empty($user)) {
            echo '<input type="text" name="user" value="'.$user.'" />';
          } else {
            echo '<input type="text" name="user" />';
          }
          ?>
        </div>
        <div>
          <span><?php echo $T["roompassword"] ?></span>
        </div>
        <div>
          <input type="password" name="ps" />
        </div>
        <div>
          <input type="submit" name="submit" />
        </div>
        <?php
          echo '<input type="hidden" name="hl" value="'.$hl.'" />';
        ?>
      </form>
    </div>
<?php
}  // else of $pass
?>
  </body>
</html>
