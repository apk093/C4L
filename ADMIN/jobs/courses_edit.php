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
					"courses",
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

<h3>Modify course listing #<?php echo $id;$website->ms_i($id);?></h3>

<?php


if(isset($_REQUEST["renew"])&&$_REQUEST["renew"]=="1")
{
	$database->SQLUpdate_SingleValue
		(
			"courses",
			"id",
			$id,
			"expires",
			time()+$website->GetParam("EXPIRE_DAYS")*86400
		);
		
	$database->SQLUpdate_SingleValue
	(
			"courses",
			"id",
			$id,
			"date",
			time()
	);
}

$arrCurrentAdd = $database->DataArray("courses","id=".$id);

if($website->GetParam("ADS_EXPIRE")!=-1&&$arrCurrentAdd["expires"] < time())
{
?>
<div class="pull-right">[<a href="index.php?category=jobs&folder=courses&page=edit&id=<?php echo $id;?>&renew=1" style="text-decoration:underline">THIS LISTING HAS EXPIRED, CLICK HERE TO RENEW IT</a>]</div>

<?php
}
else
{
	echo "<br>";
}
?>


<?php
if(is_array(unserialize(aParameter(280))))
{
	$arrCustomFields = unserialize(aParameter(280));
}
else
{
	$arrCustomFields = array();
}	


if(isset($_REQUEST["SpecialProcessEditForm"]))
{
	if(isset($_REQUEST["featured"])&&$_REQUEST["featured"]=="1")
	{
		$database->SQLUpdate_SingleValue( "courses", "id", $id, "featured_expires", time()+$website->GetParam("FEATURED_ADS_EXPIRE")*86400 );
	}
	
	
	$iFCounter = 0;

	$arrPValues = array();
	
	foreach($arrCustomFields as $arrCustomField)
	{		
		$arrPValues[$arrCustomField[0]]=get_param("pfield".$iFCounter);
		$iFCounter++;
	}		
	$id=$_POST["id"];
	$database->SQLUpdate_SingleValue
	(
			"courses",
			"id",
			$id,
			"more_fields",
			serialize($arrPValues)
	);
	$arrCurrentAdd = $database->DataArray("courses","id=".$id);


}

$_REQUEST["select-width"] = 300;
?>
<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','forecolor','fontFamily','link','unlink','left','center','right','justify','ol','ul','removeformat','indent','outdent','hr','bgcolor','underline','html'],iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('message');
});
</script>


<script>
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function EditJob(x)
{

	
		
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
$arrPropFields = array();
							
if(is_array(unserialize($arrCurrentAdd["more_fields"])))
{
	$arrPropFields = unserialize($arrCurrentAdd["more_fields"]);
}

$strSpecialHiddenFieldsToAdd="";
$iFCounter = 0;
foreach($arrCustomFields as $arrCustomField)
{
	
	$strSpecialHiddenFieldsToAdd.="<tr height=\"38\">";
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">".str_show($arrCustomField[0], true).":</td>";	
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">";
	
	if(trim($arrCustomField[2]) != "")
	{
			$strSpecialHiddenFieldsToAdd.= "<select  name=\"pfield".$iFCounter."\" ".(isset($_REQUEST["select-width"])?" style=\"width:".$_REQUEST["select-width"]."px !important\"":"").">";
			
			
			$arrFieldValues = explode("\n", trim($arrCustomField[2]));
					
						
			if(sizeof($arrFieldValues) > 0)
			{
				foreach($arrFieldValues as $strFieldValue)
				{
					$strFieldValue = trim($strFieldValue);
					if(strstr($strFieldValue,"{"))
					{
					
						$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
						
						$strSpecialHiddenFieldsToAdd.= "<option ".(trim($$strVName)==$arrPropFields[$arrCustomField[0]]?"selected":"").">".trim($$strVName)."</option>";
						
					}
					else
					{
						$strSpecialHiddenFieldsToAdd.= "<option ".(isset($arrPropFields[$arrCustomField[0]])&&trim($strFieldValue)==$arrPropFields[$arrCustomField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
					}		
				
				}
			}
			
			$strSpecialHiddenFieldsToAdd.= "</select>";
	}
	else
	{
			$strSpecialHiddenFieldsToAdd.= "<input ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px !important\"":"")." value=\"".(isset($arrPropFields[$arrCustomField[0]])?$arrPropFields[$arrCustomField[0]]:"")."\" type=text name=\"pfield".$iFCounter."\">";
	}
	
	$strSpecialHiddenFieldsToAdd.= "</td>";
	
	
	$strSpecialHiddenFieldsToAdd.= "</tr>";
	

	$iFCounter++;		
}

$_REQUEST["strSpecialHiddenFieldsToAdd"]=$strSpecialHiddenFieldsToAdd;
$strJobType="_".$M_PLEASE_SELECT."^";

foreach($website->GetParam("arrStudyModes") as $key=>$value)
{
	if($value=="") continue;
	$strJobType.="_".$value."^".$key;

}


AddEditForm
	(
		array
		(
			$M_COURSE_SUBJECT.":",
			$M_MODE_STUDY.":",
			$M_TITLE.":",
			$M_DESCRIPTION.":",
			
			$M_QUALIFICATION.":",
			$M_START_DATE.":",
			$M_DURATION.":",
		
			$M_REGION.":",
			$M_ZIP.":",
			$ACTIVE.":"
		),
		array
		(
			"job_category",
			"mode_study",
			"title",
			"message",
			
			"qualification",
			"date_available",
			"duration",
			
			"region",
			"zip",
			"active"
		),
		array(),
		array
		(
			"combobox_special",
			"combobox".$strJobType,
			"textbox_67",
			"textarea_80_10",
			
			"textbox_67",
			"textbox_36",
			"textbox_36",
			
			"combobox_region",
			"textbox_8",
			"combobox_".$M_YES."^YES_".$M_NO."^NO"
		),
		"courses",
		"id",
		$id,
		$VALEURS_MODFIEES_SUCCESS
	);
?>