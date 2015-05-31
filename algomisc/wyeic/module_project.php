<?php
$tab11 = new Tab(
  true,
  'ttt11',
  '会员项目',
  '<p>...</p>'
);

$tab12 = new Tab(
  false,
  'ttt12',
  '推荐项目',
  '<p>...</p>'
);

$item1 = new Item(true, '项目介绍', 'wyeic_files/yukewei.png',
		  array($tab11, $tab12));

$overview = array($item1);
?>