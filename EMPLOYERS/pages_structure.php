<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
$oLinkTexts=array($M_HOME,$M_MY_LISTINGS,$M_APPLICATIONS,$M_PROFILE2);
$oLinkActions=array("home","jobs","application_management","profile");

$profile_oLinkTexts=array($M_EDIT,$M_CHANGE_PASSWORD,$M_LOGO,$M_VIDEO_PRESENTATION);
$profile_oLinkActions=array("edit","password","logo","video");

$application_management_oLinkTexts=array($JOBSEEKERS_APPLIED,$M_APPROVED_APPLICATIONS,$M_REJECTED_APPLICATIONS);
$application_management_oLinkActions=array("list","approved","rejected");

$jobs_oLinkTexts=array($M_NEW_JOB,$MY_JOB_ADS,$M_COURSES,$M_BANNERS,$EXPIRED_ADS);
$jobs_oLinkActions=array("add","my","courses","banners","expired_ads");

$jobseekers_oLinkTexts=array($SEARCH,$M_BROWSE);
$jobseekers_oLinkActions=array("search","list");

if($website->GetParam("CHARGE_TYPE")==0||$website->GetParam("CHARGE_TYPE")==3)
{
	$home_oLinkTexts=array($M_DASHBOARD,$M_SUB_ACCOUNTS);
	$home_oLinkActions=array("welcome","sub_accounts");
}
else
{
	$home_oLinkTexts=array($M_DASHBOARD,($website->GetParam("CHARGE_TYPE")==2?$M_CREDITS:$M_SUBSCRIPTIONS),$M_SUB_ACCOUNTS);
	$home_oLinkActions=array("welcome","credits","sub_accounts");
}

$exit_oLinkTexts=array($M_THANK_YOU);
$exit_oLinkActions=array("exit");
?>