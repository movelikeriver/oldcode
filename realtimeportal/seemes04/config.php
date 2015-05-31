<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 MagicWare
Filename: config.php
Description: Seemes configuration file.

*/

$seemesversion = "0.4"; // Seemes version number
$websiteactiondir = "actions/"; // The actions data folder. MUST HAVE LEADING SLASH!
$websiteadmindir = "admin/"; // The admin data folder. MUST HAVE LEADING SLASH!
$websiteadminindex = "admin"; // The main admin PHP file.
$websitecopyright = "&copy;2008 Your Name"; // The website copyright
$websitedatadir = "data/"; // The website data folder. MUST HAVE LEADING SLASH!
$websitedataextension = ".txt"; // File extension for the data files. Period needed.
$websitedefaultpage = "home"; // The filename of the default page. No extension.
$websiteerrorpage = "error.inc"; // The default error page (404).
$websiteheaderpretext = "<h2>"; // Pre-page header HTML.
$websiteheaderposttext = "</h2>\n"; // Post-page header HTML.
$websiteimagedir = "img/"; // The image folder. MUST HAVE LEADING SLASH!
$websiteindex = "index"; // The main PHP file.
$websitemenucurrentitem = " class=\"currentitem\"";
$websitemenuformatting = "<li><a href=\"%menuhref%\" id=\"menu%menuid%\"%menucurrentitem%>%menuname%</a></li>\n"; // The formatting for menu items. This is explained further in docs/advancedusage.htm.
$websitemenuindent = "&bull;&nbsp;";
$websitename = "Seemes Site"; // The name of the site.
$websitepassword = "4b319db5395fe125d3107245535433965b98efc3"; // The admin password, SHA-1 encrypted.
$websiteuploaddir = "files/"; // The folder for uploads. MUST HAVE LEADING SLASH!
$websitetheme = "defaulttheme.txt"; // The php file for the the template you want to use.
$websitethemedir = "themes/"; // The theme directory.

?>