<?php

// Usage: choose.php?firstn=3
//
// Question: There're 10 trees, go through all trees and
// cannot go back, how to choose the biggest fruit.

$first_n = $_GET['firstn'];

function GenArray($num) {
  $arr = array();
  for ($j=0; $j < $num; $j++) {
    array_push($arr, rand(1, 100));
  }
  return $arr;
}

function Choose1($arr, $n) {
  $arr2 = array_slice($arr, 0, $n);
  $bar = max($arr2);
  for ($j=$n; $j < count($arr) - 1; $j++) {
    if ($arr[$j] >= $bar) {
      return $arr[$j];
    }
  }
  return $arr[count($arr) - 1];
}

$total_n = 1000;
$select_n = 0;
for ($j=0; $j < $total_n; $j++) {
  $arr = GenArray(10);
  $selected = Choose1($arr, $first_n);
  $maxn = max($arr);
  if ($selected >= $maxn) {
    echo '<font color="green"> [Y] </font> ';
    $selected_n++;
  } else {
    echo '<font color="red"> [N] </font> ';
  }
  echo $selected.' vs '.$maxn.' ';
  print_r($arr);
  echo '<br />';
}
echo 'selected: '.$selected_n;
?>
