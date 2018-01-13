<?php
if(!defined('IN_SCRIPT')) die("");
?>

<?php

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]))
{
	$database->SQLDelete("newsletter_log","id",$_REQUEST["CheckList"]);
}
?>

<?php
		$oCol=array("email","date","newsletter_id","status");
		$oNames=array($EMAIL,$DATE_MESSAGE,$NEWSLETTER_ID,$STATUS);

		RenderTable("newsletter_log",$oCol,$oNames,550,"ORDER BY id desc  ","$EFFACER","id","index.php?action=$action&category=".$category);
?>
