<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
			echo LinkTile
				 (
					"newsletter",
					"newsletter2",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>

<?php
$id = $_REQUEST["id"];
$website->ms_i($id);
AddEditForm
	(
	
		array($SUBJECT.":",$M_MESSAGE.":"),
		array("subject","html"),
					
		array(),
		array("textbox_57","textarea_60_8"),
		"newsletter",
		"id",
		$id,
		$M_NEW_VALUES_SAVED
	);
	
?>
<br><br>
