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
			"jobs",
			"add",
			$M_NEW_JOB,
			"",
			"green"
		);
	
		echo LinkTile
		(
			"jobs",
			"my_export",
			$M_EXPORT_OR_IMPORT,
			"",
			"lila"
		);
	
	
	?>

</div>
<div class="clear"></div>

<h3>
	<?php echo $MANAGE_YOUR_JOB_ADS;?>
</h3>
<br/>
<?php


if(get_param("featured")=="0")
{
	$id=$_REQUEST["id"];
	$website->ms_i($id);
	$listing = $database->DataArray("jobs","id=".$id);
	
	if($listing["employer"]!=$AuthUserName) die("--".$listing["id"]);

	$database->SQLUpdate_SingleValue
	(
		"jobs",
		"id",
		$id,
		"featured",
		"0"
	);	
}

if(isset($_POST["Delete"])&&isset($_POST["CheckList"]))
{
	if(sizeof($_POST["CheckList"])>0)
	{
		$website->ms_ia($_POST["CheckList"]);
		$database->SQLDeletePlus("employer",$AuthUserName,"jobs","id",$_POST["CheckList"]);
	}
}


if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' ".($website->GetParam("ADS_EXPIRE")!=-1?" AND expires>".time()." ":"")."") == 0)
{

?>
<br/>
	<i>
		<?php echo $ANY_JOB_ADS;?>
	</i>
<br/>
<?php
}
else
{

	$_REQUEST["arrTDSizes"] = array("60","100","*","130","30");

	$ORDER_QUERY="ORDER BY id DESC";
	RenderTable
	(
		"jobs",
		array("EditPosting","date","title","job_info","_featured"),
		array($MODIFY,$DATE_MESSAGE,$M_TITLE,"",$M_FEATURED),
		"630",
		"WHERE employer='".$AuthUserName."'   ".($website->GetParam("ADS_EXPIRE")!=-1?" AND expires>".time()." ":"")."",
		$EFFACER,
		"id",
		
		"index.php",
		false,
		20,
		false,
		-1,
		"ORDER BY id DESC"
	);
}
?>
