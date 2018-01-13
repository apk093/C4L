<?php
$ProductName="Jobs Portal";

$oLinkTexts=array($M_HOME,$M_PROFILE2,$M_CV,$M_JOB_ALERTS2);
$oLinkActions=array("home","profile","cv","jobmail");

$profile_oLinkTexts=array($MODIFY,$M_CHANGE_PASSWORD,$M_STATISTICS);
$profile_oLinkActions=array("edit","password","statistics");

$cv_oLinkTexts=array($DESCRIPTION,$M_RESUME_CREATOR,$M_VIDEO_RESUME);
$cv_oLinkActions=array("description","resume_creator","video_resume");

$documents_oLinkTexts=array($ADD_A_NEW,$M_MY_FILES);
$documents_oLinkActions=array("add","list");

$jobmail_oLinkTexts=array($M_RULES,$ADD_A_NEW_RULE);
$jobmail_oLinkActions=array("rules","add");

if($website->GetParam("CHARGE_THE_JOBSEEKERS")==1)
{
	$home_oLinkTexts=array($M_DASHBOARD,$M_CREDITS,$M_APPLY_HISTORY);
	$home_oLinkActions=array("welcome","credits","apply");
}
else
{
	$home_oLinkTexts=array($M_DASHBOARD,$M_APPLY_HISTORY);
	$home_oLinkActions=array("welcome","apply");
}
$exit_oLinkTexts=array($M_THANK_YOU);
$exit_oLinkActions=array("exit");
?>