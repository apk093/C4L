<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
	
	
			echo LinkTile
				 (
					"site_management",
					"custom_titles_regions",
					"Custom Titles for Regions",
					"",
					
					"blue"
				 );
		?>
</div>
<div class="clear"></div>

<?php
if(!isset($_POST["SpecialProcessAddForm"]))
{
?>
<h3>
	Add a new custom meta title and description for a selected category
</h3>
<br/>
<?php
}
?>
<script>
function NewJob(x)
{

	document.getElementById("job_category").value=get_cat_value("category_1");
	
	return true;
}

</script>


<?php
$_REQUEST["message-column-width"]=140;
$_REQUEST["select-width"]=400;
$insertID = AddNewForm
(
	array
	(
		
		$M_CATEGORY.":",
	
	
		$M_TITLE.":",
		$M_META_DESCRIPTION.":"
	),
	array
	(
	
		"job_category",
		
	
		"title",
		"description"
	),
	array
	(
	
		"global_category",
		
		
		"textbox_80",
	
		"textarea_70_4"
	),
	$ADD_POSTING,
	"custom_titles",
	'The new custom meta title and description were added successfully.<br/><br/>
	<a href="index.php?category=site_management&action=custom_titles" class="underline-link">Click here to add another one.</a>',
	false,
	array(),
	"NewJob"
);


?>

<?php
if(!isset($_POST["SpecialProcessAddForm"]))
{
?>
<div class="clearfix"></div>
<br/>
<h3>List of the current custom titles for categories</h3>

<br/>
<?php
}
?>

<?php
if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	$database->SQLDelete("custom_titles","id",$_REQUEST["CheckList"]);
}


RenderTable
(
	"custom_titles",
	array("EditNote","show_category_name","title","description"),
	array($MODIFY,$M_CATEGORY,$M_TITLE,$M_DESCRIPTION),
	"100%",
	"WHERE job_category<>''",
	$EFFACER,
	"id",
	
	"index.php"
);
?>



