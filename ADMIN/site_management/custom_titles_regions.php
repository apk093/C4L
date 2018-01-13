<?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
	
	
			echo LinkTile
				 (
					"site_management",
					"custom_titles",
					"Tags for Categories",
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
	Add a new custom meta title and description for a selected location
</h3>
<br/>
<?php
}
?>
<script>
function NewJob(x)
{

	document.getElementById("region").value=get_cat_value("region");
	
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
		
		$M_REGION.":",
	
	
		$M_TITLE.":",
		$M_META_DESCRIPTION.":"
	),
	array
	(
	
		"region",
		
	
		"title",
		"description"
	),
	array
	(
	
		"global_location",
		
		
		"textbox_80",
	
		"textarea_70_4"
	),
	$ADD_POSTING,
	"custom_titles",
	'The new custom meta title and description were added successfully.<br/><br/>
	<a href="index.php?category=site_management&action=custom_titles_regions" class="underline-link">Click here to add another one.</a>',
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
<h3>List of the current custom titles for regions</h3>

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
	array("EditNote","show_location","title","description"),
	array($MODIFY,$M_REGION,$M_TITLE,$M_DESCRIPTION),
	"100%",
	"WHERE region<>''",
	$EFFACER,
	"id",
	
	"index.php"
);
?>



