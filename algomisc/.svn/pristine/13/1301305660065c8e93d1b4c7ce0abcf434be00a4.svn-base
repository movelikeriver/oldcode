<?php
class Tab {
  var $stat;
  var $id;
  var $title;
  var $text;
  function __construct($stat, $id, $title, $text) {
    $this->stat = $stat;
    $this->id = $id;
    $this->title = $title;
    $this->text = $text;
  }
};

class Item {
  var $stat;
  var $title;
  var $pic;
  var $tabs;
  function __construct($stat, $title, $pic, $tabs) {
    $this->stat = $stat;
    $this->title = $title;
    $this->pic = $pic;
    $this->tabs = $tabs;
  }
};


// Loading data.
$module = $_GET['module'];
if (empty($module)) {
  $module = 'aboutus';
}
$modulefile = 'module_' . $module . '.php';
if (!file_exists($modulefile)) {
  $modulefile = 'module_demo.php';
}
include($modulefile);


$hasfirst = false;
$html_arr = array();
foreach($overview as $item) {
  if (!$hasfirst) {
    $hasfirst = true;
    array_push(
      $html_arr,
      '<li class="servicesOverview jsShow" style="display:block">',
      '<h2 class="unselected selected">',
      '<a href="#">' . $item->title . '</a></h2>',
      '<div style="display:block;" class="servicesOverviewContentArea">'
    );
  } else {
    array_push(
      $html_arr,
      '<li class="servicesOverview">',
      '<h2 class="unselected">',
      '<a href="#">' . $item->title . '</a></h2>',
      '<div style="display:none;" class="servicesOverviewContentArea">'
    );
  }
  array_push(
    $html_arr,
    '<img class="alignLeft" src="',
    $item->pic,
    '" alt="" style="border-width: 0px; height: 428px; width: 480px;">'
  );
  $ul_arr = array();
  $ul_arr2 = array();
  foreach ($item->tabs as $tab) {
    if ($tab->stat) {
      array_push(
	$ul_arr,
	'<li style="display: block;" class="ui-tabs-selected jsShow">'
      );
      array_push(
	$ul_arr2,
	'<div style="display: block;" class="servicesOverviewText clickable jsClickable jsIconOnLastElement ui-tabs-panel" id="',
	$tab->id,
	'">'
      );
    } else {
      array_push(
        $ul_arr,
	'<li class="">'
      );
      array_push(
	$ul_arr2,
	'<div class="servicesOverviewText clickable jsClickable OnLastElement ui-tabs-panel ui-tabs-hide" id="',
	$tab->id,
	'">'
      );
    }
    array_push(
      $ul_arr,
      '<a href="#' . $tab->id . '">' . $tab->title . '</a>',
      '</li>'
    );
    array_push(
      $ul_arr2,
      '<h3><span>' . $tab->title . '</span>',
      '</h3><p>',
      $tab->text,
      '</p></div>'
    );
  }
  array_push(
    $html_arr,
    '<div class="servicesMenu">',
    '<ul class="ui-tabs-nav">'
  );
  $html_arr = array_merge($html_arr, $ul_arr);
  array_push($html_arr, '</ul></div>');
  $html_arr = array_merge($html_arr, $ul_arr2);
  array_push($html_arr, '</div></li>');
}

print join('', $html_arr);

?>