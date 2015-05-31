<?php
// Modules list in order.
$menu_arr = array(
'aboutus' => '关于我们',
'memberintro' => '会员介绍',
'memberactive' => '会员活动',
'project' => '创投项目',
'history' => '历史档案',
'partner' => '外联伙伴',
'joinus' => '申请加入');
?>

     <div id="siteHeader" class="siteheader">
       <div id="mainMenu" class="mainmenu">
	 <ul>
<?php
  $module = $_GET['module'];
  if (empty($module) || $module == 'demo') {
    $module = 'aboutus';
  }
  foreach ($menu_arr as $k => $v) {
    $href = 'wyeic.php?module=' . $k;
    if ($k == $module) {
      print '<li class="selected">';
    } else {
      print '<li>';
    }
    print '<a href="' . $href . '">' . $v . '</a></li>';
  }
?>
	 </ul>
       </div>
       <div id="headerContent">
	 <div id="siteLogo">
	   <a href="#">
	     <img src="wyeic_files/logo.jpg" alt="WYEIC" height="160" width="160">
	   </a>
	 </div>
	 <div id="siteLogoWord">
	   <p id="pageSlogan">
	     <span>Life is cool!</span>
	   </p>
	 </div>
       </div>
     </div>
