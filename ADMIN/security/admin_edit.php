<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<div class="fright">
	<?php
	echo LinkTile
	 (
		"security",
		"admin",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>
<div class="clear"></div>
<?php

$id=$_REQUEST["id"];
$website->ms_i($id);
$MessageTDLength=120;
$SubmitButtonText=$M_SAVE;

AddEditForm
(
	array($M_USERNAME.":",$M_TYPE.":","$TELEPHONE:","$EMAIL:"),
	array("username","type","telephone","email"),
	array("username"),
	array("textbox_20","combobox_table~admin_users_type~type~type","textbox_20","textbox_20"),
	"admin_users",
	"id",
	$id,
	"$INFORMATION_UTILISATEUR_MODIFIEE!"
);
	
?>

