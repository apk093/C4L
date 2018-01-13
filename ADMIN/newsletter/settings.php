<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
			echo LinkTile
				 (
					"newsletter",
					"home",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>

<span class="medium-font"><?php echo $M_CONFIGURATION_OPTIONS;?></span>
<br><br><br>
<?php
$_REQUEST["message-column-width"]=200;
EditParams
(
		"3003,3004",
		array("textbox_40","textbox_40"),
		$SAVE_SETTINGS,
		$M_NEW_VALUES_SAVED
	);
//"3000,3001,3002,3003,3004",
//array("textarea_50_4","textarea_50_4","combobox_YES_NO","textbox_40","textbox_40"),
?>

