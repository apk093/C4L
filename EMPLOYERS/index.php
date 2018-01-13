<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
define("IN_SCRIPT","1");
$is_mobile=false;
if(isset($_POST["Export"])) ob_start();
include("../config.php");
if(!$DEBUG_MODE) error_reporting(0);
include("../include/SiteManager.class.php");
include("../include/Database.class.php");
$website = new SiteManager();
$website->isAdminPanel = true;
$database = new Database();
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
$website->SetDatabase($database);
include("security.php");
$website->LoadSettings();

$is_parnter = strpos($website->params[137], $AuthUserName);

if($is_parnter !== false) 
{
	$website->params[899]=0;
}

include("include/AdminUser.class.php");
if(!isset($AuthUserName) || !isset($AuthGroup)) $website->ForceLogin();
$currentUser = new AdminUser($AuthUserName, $AuthGroup);
$currentUser->LoadPermissions();
$lang = $currentUser->GetLanguage();

if(file_exists("../ADMIN/texts_".$lang.".php"))
{
	include("../ADMIN/texts_".$lang.".php");
}
else
{
	include("../ADMIN/texts_en.php");
}
include("../include/texts_".$lang.".php");


$website->LoadTemplate(-1);
$website->TemplateHTML=str_replace('"images/','"../images/',$website->TemplateHTML);

include("include/page_functions.php");
include("include/AdminPage.class.php");
$currentPage = new AdminPage();
$currentPage->Process($is_mobile);
$website->Render();
if(isset($_POST["Export"])) ob_end_flush();
?>