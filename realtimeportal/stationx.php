<?php header('Content-type: application/vnd.wap.xhtml+xml;charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include_once("bus/logbase.php");
saveLog();
$hl = strtolower($_GET['hl']);
if (empty($hl)) {
  $hl = 'zh-cn';
}
include_once("bus/${hl}.php");
?>
<head>
  <?php $station = $_GET['station'] ?>
  <title><?php print $T['station'] ?> - <?php print $station; ?></title>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="refresh" content="5"/>
</head>

<body>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <p>
        <?php print $T['bus'] ?>:
        <select name="bus">
<?php
  $buses= array('324', '34', '444', '874', '809', '343');
  foreach($buses as $bus) {
    echo '<option value="'.$bus.'">'.$bus.'</option>';
  }
?>
        </select>
        <input type="submit"/>
<?php
        echo '<input type="hidden" name="station" value="'.$station.'"/>';
        echo '<input type="hidden" name="op" value="report"/>';
?>
      </p>
    </form>
<?php
  $file = $station.'data.html';
  $op = $_GET['op'];
  if ($op == 'report') {
    $bus = $_GET['bus'];
    if (!empty($bus)) {
      $dest = $_GET['dest'];
      if (!empty($dest)) {
        // open file 
        $fh = fopen($file, 'r') or die('Could not open file!');
        // read file contents 
        $data = fread($fh, filesize($file)) or die('Could not read file!');
        // close file 
        fclose($fh);

        $fh = fopen($file, 'w') or die('could not open file: ' + $file);
        fwrite($fh, '<li>'.$dest.'</li>');
        fwrite($fh, $data);
        fclose($fh);
        echo $dest.'<br/>';
        echo 'Thank you for your reporting!<br/>';
      } else {
        $dest = $bus.'_to_dest1';
        echo '<a href="?station='.$station.'&amp;op=report&amp;bus='.$bus.'&amp;dest='.$dest.'">';
        echo $dest.'</a><br/>';
        $dest = $bus.'_to_dest2';
        echo '<a href="?station='.$station.'&amp;op=report&amp;bus='.$bus.'&amp;dest='.$dest.'">';
        echo $dest.'</a><br/>';
      }
    }
  }
?>
    <hr/>
<?php
  echo '<ul>';
  if (! @include $file) {
    echo '<li>no '.$file.'</li>';
  }
  echo '</ul>';
?>
</body>
</html>
