<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
require("config.php");
if(!$DEBUG_MODE) error_reporting(0);
require("include/SiteManager.class.php");
include("include/Database.class.php");

$website = new SiteManager();
$database = new Database();

$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
$website->SetDatabase($database);
$website->LoadSettings();

$log_file = "include/IPN_REPORT.php";   

$writeToLog = true;

if (!$file_handle = fopen($log_file,"a")) 
{
	$writeToLog = false;
}
else
{
	fclose($file_handle); 
}

function WriteToIPNLog($strText)
{
	global $writeToLog,$log_file,$SYSTEM_EMAIL_ADDRESS;
	if($writeToLog)
	{
		if (!$file_handle = fopen($log_file,"a")) 
		{
			 return;
		}  
		
		if (!fwrite($file_handle, $strText)) 
		{ 
			return;
		}  
		fclose($file_handle); 
	}
}



$req = 'cmd=_notify-validate';

$logVars ="";

foreach ($_POST as $key => $value) 
{
	$value = urlencode(stripslashes($value));
	$req .= "&".$key."=".$value;
	$logVars .= $key.">>".$value." ";
}

date_default_timezone_set("Europe/London");
WriteToIPNLog
(
	"NEW IPN REPORT ".date("F j, Y, g:i a")."\n".
	"********************\n".
	$logVars."\n"
);

$header = "POST /cgi-bin/webscr HTTP/1.1\r\n"; // HTTP POST request
$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
$header.= "Host: www.paypal.com\r\n";
$header.= "Content-Length: " . strlen($req) . "\r\n";
$header.= "Connection: Close\r\n\r\n";


$fp = fsockopen ("ssl://www.paypal.com", 443, $errno, $errstr, 30);


if (!$fp) 
{
	WriteToIPNLog
	(
		"System failed to connect to paypal!\n"
	);
	
} 
else 
{

	fputs ($fp, $header . $req);
	  
	$strReport = "";
	
	 while (!feof($fp)) 
	 {

		$res = fgets ($fp, 1024);
		
		$strReport .= $res;

		if(strcmp(trim($res), "VERIFIED") == 0) 
		{
					
			WriteToIPNLog
			(
				"\nSUCCESSFUL PAYMENT\n"
			);

			$username = $_POST["custom"];
			$arrUser = $database->DataArray("jobseekers","username='".$username."'");
			$arrPackage = $database->DataArray("jobseeker_packages","id=".$arrUser["package"]);

			if(SQLCount("jobseekers","WHERE username='".$username."' ")==1) 
			{
				if(isset($_POST["txn_type"]) &&strtolower($_POST["txn_type"]) == "subscr_payment") 
				{
					$database->SQLUpdate_SingleValue
					(
						"jobseekers",
						"id",
						$arrUser["id"],
						"active",
						"1"
					);
					
					SQLInsert
					( 
						"jobseeker_payments",
						array("date","user","method","validated","amount"),
						array(time(),$username,"paypal","1",$arrPackage["price"])
					);
					
					WriteToIPNLog
					(
						"successful payment for user: ".$username."\n"
					);
		
				} 
				else
				if(isset($_POST["txn_type"]) 
					 &&
					(
						strtolower($_POST["txn_type"]) == "subscr_cancel"
						||
						strtolower($_POST["txn_type"]) == "subscr_failed"
					) 
					)
				{
					$database->SQLUpdate_SingleValue
					(
						"jobseekers",
						"id",
						$arrUser["id"],
						"active",
						"0"
					);
				} 

			}
		
		} 
		else 
		if(strcmp ($res, "INVALID") == 0) 
		{

			WriteToIPNLog
			(
				">>>INVALID<<<\n".$strReport."\n"
			);

		}

	} 

}

WriteToIPNLog
(
	"Final Report: \n".$strReport."\n<<<END\n\n"
);
?>