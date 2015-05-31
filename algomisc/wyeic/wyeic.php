<?php include('header.php'); ?>
 <body>
   <div name="siteWrapper" id="siteWrapper" class="sitewrapper">
    <?php include('site_header.php'); ?>
     <div id="siteBody" class="sitebody">
       <div id="siteContent">
	 <div id="mainContent">
	   <div class="contentItems">
	     <ul id="overview" class="overview jsSlider">
    <?php
    $module = $_GET['module'];
    if (empty($module)) {
      $module = 'demo';
    }
    include_once('overview_item.php');
    ?>
	   </ul>
	 </div>
       </div>
     </div>
   </div>		
   <div id="siteFooter">
     <div id="footerleft"></div>
     <div id="shortcuts">
       <div>
	 <ul class="nav first">
	   <li><a href="wyeic.php?module=aboutus">关于我们</a></li>
	   <li><a href="wyeic.php?module=joinus">联系我们</a></li>
	 </ul>
       </div>
     </div>
   </div>
  </div>
</body>

<script type="text/javascript" src="wyeic_files/jquery-1.js"></script>
<script type="text/javascript" src="wyeic_files/jquery-ui-personalized-1.js"></script>
<script type="text/javascript" src="wyeic_files/accordion.js"></script>

<script type="text/javascript">
	    $(function() {
		    $('.servicesMenu ul').tabs();
	 	    $(".contentItems ul li:first-child").addClass("jsShow")
		    $(".contentItems ul li:first-child").css('display', 'block');

		    firstLi = $(".contentItems ul li:first-child");
		    content = $(".servicesOverviewContent",firstLi);
    		
		    $(content).css('display', 'block');
	     });
	</script>
	<script type="text/javascript">
	jQuery().ready(function(){	
		// applying the settings
		jQuery('#overview').Accordion({
			active: 'h2.selected',
			header: 'h2.unselected',
			alwaysOpen: false,
			animated: true,
			showSpeed: 400,
			hideSpeed: 800
		});
	});	
</script>

<script language="javascript" type="text/javascript">
function update(e,panelID) {
    
    WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(panelID, "", true, "", "", false, true));
    
   
}

function resultsBlock()
{
    this.Show=function(e){
        var clicked = $(e.target).parents().andSelf();
        if ( !(clicked.is("#searchSuggest")|| clicked.is("#slHeader_searchBox_siteSearchSubmit"))) $("#searchSuggest").addClass("hide");
    }
}
var ResultsBlock=new resultsBlock();
</script>


</html>
