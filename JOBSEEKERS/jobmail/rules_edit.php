<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<h3>
	<?php echo $MODIFY_RULE;?>
</h3>
<br/>

<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

$strRegions = Parameter(802);

$strRegionComboList = "";

$arrComboItems = explode("\n",$strRegions);

foreach($arrComboItems as $comboItem)
{
	$arrComboItems2 = explode(".",$comboItem);
	$strRegionComboList .= "_" . $arrComboItems2[1];
}

$MessageTDLength = 130;

$SubmitButtonText = $SAUVEGARDER;

$MessageTDLength = 130;
$SelectWidth=400;

$DropDownWidth = 200;


AddEditForm
	(
	array($M_REGION.":",$CONTAINING_WORD.":",$M_CATEGORY.":"),
	array("region","rule","job_category"),
	array(),
	array("combobox_special","textbox_30","combobox_special"),
	"rules",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);

?>