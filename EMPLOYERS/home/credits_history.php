<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<h3><?php echo $M_CREDITS_HISTORY_INVOICES;?>
		
		</h3>
<br>
<?php
RenderTable
(
	"credits",
	array("date_start","credits","amount","payment","show_invoice"),
	array($DATE_MESSAGE,$M_CREDITS,$M_AMOUNT,$M_PAYMENT,$M_INVOICE),
	750,
	"WHERE employer='$AuthUserName' and status=1   ",
	"",
	"id",
	"index.php?category=home&folder=credits&page=history"
);
?>