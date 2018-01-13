<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<script>


</script>
<?php
if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]))
{
	$database->SQLDelete("messages","id",$_REQUEST["CheckList"]);
}
?>


<div class="fright">

<?php
	
echo LinkTile
	 (
		"home",
		"welcome",
		$M_DASHBOARD,
		"",
		"blue"
	 );
?>
		
	
</div>
<div class="clear"></div>
<h3>
<?php echo $M_RECEIVED_MESSAGES;?>
</h3>
<?php
	
if($database->SQLCount("messages","")==0)
{
	echo "<br/><br/><i>".$M_NO_NEW_MESSAGES."</i>";
}
else
{

	RenderTable
	(
		"messages",
		array("date","name","email","phone","subject","message"),
		array($M_DATE,$NOM,$M_EMAIL,$M_PHONE,$SUBJECT,$M_MESSAGE),
		750,
		"",
		$M_DELETE,
		"id",
		"index.php",
		true,
		20,
		false,
		-1,
		"ORDER BY ID desc"
	);
}
?>

