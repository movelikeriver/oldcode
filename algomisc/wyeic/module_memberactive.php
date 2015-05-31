<?php
$tab11 = new Tab(
  true,
  'ttt11',
  '活动预告1',
  '<p>...</p>'
);

$tab12 = new Tab(
  false,
  'ttt12',
  '活动预告2',
  '<p>...</p>'
);

$item1 = new Item(true, '活动预告', 'wyeic_files/yukewei.png',
		  array($tab11, $tab12));

$tab21 = new Tab(
  true,
  'ttt21',
  '活动回顾1',
  '<p>really should be in this category?????</p>'
);

$item2 = new Item(false, '活动回顾', 'wyeic_files/liuxijun.png',
		  array($tab21));

$tab31 = new Tab(
  true,
  'ttt31',
  '创投项目1',
  '<p>...</p>'
);


$item3 = new Item(false, '创投项目', 'wyeic_files/jiangyingrong.png',
		  array($tab31));

$tab41 = new Tab(
  true,
  'ttt41',
  '博客1',
  '<p>really should be here????</p>'
);

$item4 = new Item(false, '博客汇总', 'wyeic_files/jiangyingrong.png',
		  array($tab41));

$overview = array($item1, $item2, $item3, $item4);
?>