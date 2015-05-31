<?php
$tab11 = new Tab(
  true,
  'ttt11',
  '合作商会1',
  '<p>...</p>'
);

$item1 = new Item(true, '合作商会', 'wyeic_files/yukewei.png',
		  array($tab11));

$tab21 = new Tab(
  true,
  'ttt21',
  '合作企业',
  '<p>...</p>'
);

$item2 = new Item(false, '合作企业', 'wyeic_files/liuxijun.png',
		  array($tab21));

$tab31 = new Tab(
  true,
  'ttt31',
  '合作俱乐部',
  '<p>...</p>'
);

$item3 = new Item(false, '合作俱乐部', 'wyeic_files/jiangyingrong.png',
		  array($tab31));

$tab41 = new Tab(
  true,
  'ttt41',
  '合作高校',
  '<p>...</p>'
);

$item4 = new Item(false, '合作高校', 'wyeic_files/jiangyingrong.png',
		  array($tab41));

$tab51 = new Tab(
  true,
  'ttt51',
  '其他组织',
  '<p>...</p>'
);

$item5 = new Item(false, '其他组织', 'wyeic_files/jiangyingrong.png',
		  array($tab51));

$overview = array($item1, $item2, $item3, $item4, $item5);
?>