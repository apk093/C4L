<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
define("IN_SCRIPT","1");
$is_mobile=false;
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
$website->TemplateHTML=str_replace('"css/','"../css/',$website->TemplateHTML);
$website->TemplateHTML=str_replace('"images/','"../images/',$website->TemplateHTML);

include("include/page_functions.php");
include("include/AdminPage.class.php");
$currentPage = new AdminPage();
$currentPage->Process($is_mobile);
$website->Render();
?>