<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br>
<?php
$HideSubmit = true;
$website->ms_ew($empl);
$MessageTDLength = 150;

 AddEditForm
	(
	array("$M_COMPANY:","$M_COMPANY_DESCRIPTION:","$CONTACT_PERSON:","$M_ADDRESS:","$TELEPHONE:","$FAX:","$M_WEBSITE:"),
	array("company","company_description","contact_person","address","phone","fax","website"),
	array("company","company_description","contact_person","address","phone","fax","website"),
	array("textbox_30","textarea_50_4","textbox_30","textarea_50_4","textbox_30","textbox_30","textbox_30"),
	"employers",
	"username",
	"'".$empl."'",
	"<b>$LES_VALEURS_MODIFIEES_SUCCES!</b>"
	);
?>
<br>
<?php
generateBackLink("statistics");
?>
