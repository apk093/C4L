<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2016
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");

?>
<div class="fright">

	<?php
			echo LinkTile
				 (
					"site_management",
					"custom_titles_regions",
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
?>

<h3>Modify the custom title and meta description</h3>
<br/>
<?php

$_REQUEST["select-width"] = 300;
?>


<?php

$str_job_types="combobox";


AddEditForm
(
	array($M_CATEGORY.":",
	$M_TITLE.":",$M_DESCRIPTION.":"),
	array("job_category",
	"title","description"),
	
	array(),
	array(
	
	"combobox_special",
	"textbox_80","textarea_70_4"),
	"custom_titles",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
);
?>