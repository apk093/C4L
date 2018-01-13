<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
$scheme=0;
session_start();
if(!file_exists("config.php")) die("<script>document.location.href='ADMIN/setup.php';</script>");
define("IN_SCRIPT","1");
require("config.php");
if(!$DEBUG_MODE) error_reporting(0);
require("include/SiteManager.class.php");
include("include/Database.class.php");

/// Initialization of the site manager and database objects
$database = new Database();

/// Connect to the website database
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
$website = new SiteManager();
$website->SetDatabase($database);



/// Loading the website default settings
$website->LoadSettings();

if(file_exists("include/color_scheme.php")) include("include/color_scheme.php");

include("include/texts_".$website->lang.".php");

include("include/functions.php");



$website->GenerateMenu();

if($website->IsExtension)
{
	include("include/Extension.class.php");
	$currentExtension = new Extension($website->ExtensionFile);
}
else
{
	include("include/Page.class.php");
	$currentPage = new Page(isset($_REQUEST["page"])?$_REQUEST["page"]:"");

	$currentPage->LoadPageData();
	
}

$website->LoadTemplate(isset($currentPage->templateID)?$currentPage->templateID:0);


if($website->IsExtension)
{
	$currentExtension->Process();
}
else
{
	$currentPage->Process();
}


$website->ProcessTags();

/// Rendering the final html of the website
$website->Render();

/// Inserrting the statistics information in the database
$website->Statistics();
?>