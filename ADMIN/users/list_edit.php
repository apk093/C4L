<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
					array("Title".":","Message".":","Active:","Notification:","Featured:"),
					array("title","message","active","notification","featured"),
					
					array(),
					array("textbox_50","textarea_37_10","combobox_YES_NO","combobox_YES_NO","combobox_YES_NO"),
					"jobs",
					"id",
					$id,
					$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
<br>
<?php
generateBackLink("list");
?>
