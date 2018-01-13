<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
					"list",
					$M_ADS_LIST,
					"",
					
					"blue"
				 );
		?>
</div>
<div class="clear"></div>

<h3>
	<?php echo $POST_NEW_ADD;?>
</h3>
<!--
<table summary="" border="0" class="pull-right">
  	<tr>
  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
  		<td><a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=export" style="color:#6d6d6d;text-transform:uppercase;font-weight:800"><?php echo $M_EXPORT_OR_IMPORT;?></a></td>
  	</tr>
  </table>
  -->
<br>

<script>
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function NewJob(x)
{

	document.getElementById("job_category").value=get_cat_value("category_1");
	document.getElementById("region").value=get_cat_value("region");
	
		
	if(x.title.value=="")
	{
		alert("<?php echo $JOB_TITLE_EMPTY;?>");
		x.title.focus();
		return false;
	}
	
	var wEditor = new nicEditors.findEditor('message');
	
	
	wEditor.saveContent();
	
	if(x.message.value=="")
	{
		alert("<?php echo $JOB_DESCRIPTION_EMPTY;?>");
		x.message.focus();
		return false;
	}
	
	return true;
}

</script>

<?php

if(is_array(unserialize($website->params["280"])))
{
	$arrJobFields = unserialize($website->params["280"]);
}
else
{
	$arrJobFields = array();
}	
$arrPValues = array();

if(isset($_POST["SpecialProcessAddForm"]))
{
	
	
	$iFCounter = 0;
	
	foreach($arrJobFields as $arrJobField)
	{		
		
		$arrPValues[$arrJobField[0]]=$_POST["pfield".$iFCounter];
		$iFCounter++;
	}

}
else
{


	$iFCounter = 0;
	$strSpecialHiddenFieldsToAdd="";
	foreach($arrJobFields as $arrJobField)
	{
		
		$strSpecialHiddenFieldsToAdd.="<tr>";
		
		$strSpecialHiddenFieldsToAdd.= "<td ><i>".str_show($arrJobField[0], true).":</i></td>";	
		
		$strSpecialHiddenFieldsToAdd.= "<td >";
		
		if(trim($arrJobField[2]) != "")
		{
				$strSpecialHiddenFieldsToAdd.= "<select  name=\"pfield".$iFCounter."\" style=\"width:150px\">";
				
				
				$arrFieldValues = explode("\n", trim($arrJobField[2]));
						
							
				if(sizeof($arrFieldValues) > 0)
				{
					foreach($arrFieldValues as $strFieldValue)
					{
						$strFieldValue = trim($strFieldValue);
						if(strstr($strFieldValue,"{"))
						{
						
							$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
							
							$strSpecialHiddenFieldsToAdd.= "<option ".(trim($$strVName)==$arrPropFields[$arrJobField[0]]?"selected":"").">".trim($$strVName)."</option>";
							
						}
						else
						{
							$strSpecialHiddenFieldsToAdd.= "<option ".(isset($arrPropFields[$arrJobField[0]])&&trim($strFieldValue)==$arrPropFields[$arrJobField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
						}		
					
					}
				}
				
				$strSpecialHiddenFieldsToAdd.= "</select>";
		}
		else
		{
				$strSpecialHiddenFieldsToAdd.= "<input value=\"".(isset($arrPropFields[$arrJobField[0]])?$arrPropFields[$arrJobField[0]]:"")."\" type=text name=\"pfield".$iFCounter."\" style=\"width:220px\">";
		}
		
		$strSpecialHiddenFieldsToAdd.= "</td>";
		
		
			$strSpecialHiddenFieldsToAdd.= "</tr>";
		
	
		$iFCounter++;		
	}
	
	$_REQUEST["strSpecialHiddenFieldsToAdd"]=$strSpecialHiddenFieldsToAdd;
}

$strJobType="";

foreach($website->GetParam("arrJobTypes") as $key=>$value)
{

	$strJobType.="_".$value."^".$key;
}

$jsValidation="NewJob";
$arrOtherValues = array(array("date",date("F j, Y, g:i a")) );

$_REQUEST["arrNames2"] = array("date","expires","more_fields");
$_REQUEST["arrValues2"] = array(time(), (time() + $website->GetParam("EXPIRE_DAYS")*86400) ,serialize($arrPValues));
$_REQUEST["message-column-width"]=120;
$_REQUEST["select-width"]=400;

$_REQUEST["hide_form"]=true;

?>


<?php
$insertID = AddNewForm
(
	array
	(
		$M_EMPLOYER.":",
		$M_CATEGORY.":",
	
		$M_JOB_TYPE.":",
		$M_TITLE.":",
		$M_DESCRIPTION.":",
		$M_REGION.":",
		$M_ZIP.":",
	
		$M_DATE_AVAILABLE.":",
		$M_APPLICATION_URL.":",
		$ACTIVE.":"
	),
	array
	(
		"employer",
		"job_category",
		
		"job_type",
		"title",
		"message",
		"region",
		"zip",
	
		"date_available",
		"application_url",
		"active"
	),
	array
	(
		"combobox_table~employers~username~company",
		"global_category",
		
		"combobox".$strJobType,
		"textbox_67",
	
		"textarea_90_12",
		"global_location",
		"textbox_8",
		
		"textbox_20",
		"textbox_67",
		"combobox_".$M_YES."^YES_".$M_NO."^NO"
	),
	$ADD_POSTING,
	"jobs",
	'<a class="underline-link" href="index.php?category=jobs&action=list">'.$NEW_POSTING_ADDED.'</a>',
	false,
	array(),
	"NewJob"
);


?>

<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">

	new nicEditor({buttonList : ['fontSize','bold','italic','forecolor','fontFamily','link','unlink','left','center','right','justify','ol','ul','removeformat','indent','outdent','hr','bgcolor','underline','html'],iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('message');

</script>
