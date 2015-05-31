<?php
$tab11 = new Tab(
  true,
  'ttt11',
  '入会须知',
  '<p>...</p>'
);

$item1 = new Item(true, '入会须知', 'wyeic_files/yukewei.png',
		  array($tab11));

$tab21 = new Tab(
  true,
  'ttt21',
  '入会流程',
  '<p>...</p>'
);

$item2 = new Item(false, '入会流程', 'wyeic_files/liuxijun.png',
		  array($tab21));

$overview = array($item1, $item2);
?>
