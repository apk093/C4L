<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><div class="fright">

<?php
	
		 
		echo LinkTile
		 (
			"users",
			"jobseekers",
			$M_JOBSEEKERS,
			"",
			
			"yellow"
		 );
?>
</div>
<div class="clear"></div>

<h3>
	<?php echo $M_LIST_ALERTS;?>
</h3>
	
<?php

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
		$database->SQLDelete("rules","id",$_REQUEST["CheckList"]);
}
?>

<?php

if($database->SQLCount("rules","")==0)
{
?>

<br>

<i><?php echo $M_NO_ALERTS;?></i>


<?php
}
else
{
	

	RenderTable
	(
		"rules",
		array("user","show_location","show_category_name","rule"),
		array($UTILISATEUR,$M_REGION,$M_CATEGORY,$CONTAINING_WORD),
		
		700,
		"",
		$EFFACER,
		"id",
		"index.php"
	);
}

?>
