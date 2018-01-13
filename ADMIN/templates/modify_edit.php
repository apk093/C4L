<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?>
<?php
if(!defined('IN_SCRIPT')) die("");
?>


<div class="fright">

	<?php
			echo LinkTile
				 (
					"templates",
					"modify",
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

if(isset($_REQUEST["html"]))
{
	
	$_REQUEST["html"]=str_ireplace("&lt;textarea","<textarea",$_REQUEST["html"]);
	$_REQUEST["html"]=str_ireplace("&lt;/textarea>","</textarea>",$_REQUEST["html"]);
}

AddEditForm
(
	array($NOM.":",$DESCRIPTION.":","HTML".":"),
	array("name","description","html"),
	array(),
	array("textbox_60","textbox_60","textarea_80_20"),
	"templates",
	"id",
	$id,
	$M_TEMPLATE_MODIFIED
);
	
?>
<br>

