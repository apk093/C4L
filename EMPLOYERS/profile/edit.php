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
			"profile",
			"logo",
			$M_LOGO,
			"",
			"yellow"
		);
	
		echo LinkTile
		(
			"profile",
			"video",
			$M_VIDEO_PRESENTATION,
			"",
			"lila"
		);
	
	
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $EDIT_YOUR_PROFILE;?>
</h3>
<br/>

<?php


$strSpecialHiddenFieldsToAdd="";


if(is_array(unserialize(aParameter(270))))
{
		$arrFields = unserialize(aParameter(270));
}
else
{
		$arrFields = array();
}	


if(isset($_POST["SpecialProcessEditForm"]))
{
		$iFCounter = 0;

		$arrPValues = array();
			
		$iFCounter = 0;
			
		foreach($arrFields as $arrField)
		{		
			$arrPValues[$arrField[0]]=get_param("pfield".$iFCounter);
			$iFCounter++;
		}		
		$id=$_POST["id"];
		$database->SQLUpdate_SingleValue
		(
				"employers",
				"id",
				$id,
				"employer_fields",
				serialize($arrPValues)
		);
		$arrUser = $database->DataArray("employers","username='$AuthUserName'");

}
		

$arrEmployerFields = array();
							
if(is_array(unserialize($arrUser["employer_fields"])))
{
				
		$arrEmployerFields = unserialize($arrUser["employer_fields"]);
}


$iFCounter = 0;
$SelectWidth=280;

foreach($arrFields as $arrField)
{
	
	$strSpecialHiddenFieldsToAdd.="<tr height=\"38\">";
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">".str_show($arrField[0], true).":</td>";	
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">";
	
	if(trim($arrField[2]) != "")
	{
			$strSpecialHiddenFieldsToAdd.= "<select  name=\"pfield".$iFCounter."\" ".(isset($SelectWidth)?" style=\"width:".$SelectWidth."px !important\"":"").">";
			
			
			$arrFieldValues = explode("\n", trim($arrField[2]));
					
						
			if(sizeof($arrFieldValues) > 0)
			{
				foreach($arrFieldValues as $strFieldValue)
				{
					$strFieldValue = trim($strFieldValue);
					if(strstr($strFieldValue,"{"))
					{
					
						$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
						
						$strSpecialHiddenFieldsToAdd.= "<option ".(trim($$strVName)==$arrEmployerFields[$arrField[0]]?"selected":"").">".trim($$strVName)."</option>";
						
					}
					else
					{
						$strSpecialHiddenFieldsToAdd.= "<option ".(isset($arrEmployerFields[$arrField[0]])&&trim($strFieldValue)==$arrEmployerFields[$arrField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
					}		
				
				}
			}
			
			$strSpecialHiddenFieldsToAdd.= "</select>";
	}
	else
	{
			$strSpecialHiddenFieldsToAdd.= "<input value=\"".(isset($arrEmployerFields[$arrField[0]])?$arrEmployerFields[$arrField[0]]:"")."\" type=text name=\"pfield".$iFCounter."\" ".(isset($SelectWidth)?"style=\"width:".$SelectWidth."px !important\"":"").">";
	}
	
	$strSpecialHiddenFieldsToAdd.= "</td>";
	
	
		$strSpecialHiddenFieldsToAdd.= "</tr>";
	

	$iFCounter++;		
}

$_REQUEST["strSpecialHiddenFieldsToAdd"]=$strSpecialHiddenFieldsToAdd;

		

$strAuthQuery = "username='".$AuthUserName."' ";

$_REQUEST["select-width"]=400;
$_REQUEST["message-column-width"]=200;
$_REQUEST["arrNames2"]=array();
$_REQUEST["arrValues2"]=array();

if(isset($_POST["latitude"]))
{
	array_push($_REQUEST["arrNames2"],"latitude");
	array_push($_REQUEST["arrValues2"],$_POST["latitude"]);
}

if(isset($_POST["longitude"]))
{
	array_push($_REQUEST["arrNames2"],"longitude");
	array_push($_REQUEST["arrValues2"],$_POST["longitude"]);
}

AddEditForm
(
	array
	(
		$M_USERNAME.":",
		$M_COMPANY.":",
		$M_COMPANY_DESCRIPTION.":",
		$CONTACT_PERSON.":",
		$M_ADDRESS.":",
		$TELEPHONE.":",
		$FAX.":",
		$M_WEBSITE.":",
		$M_I_WOULD_LIKE_SUBSCRIBE." ".$DOMAIN_NAME." ".$M_NEWSLETTER.":"
	),
	array
	(
		"username",
		"company",
		"company_description",
		"contact_person",
		"address",
		"phone",
		"fax",
		"website",
		"newsletter"
	),
	array("username"),
	array("textbox_40","textbox_40","textarea_50_4","textbox_40","address_field","textbox_40","textbox_40","textbox_40",
	"combobox_".$M_YES."^1_".$M_NO."^0"),
	"employers",
	"id",
	$arrUser["id"],
	$LES_VALEURS_MODIFIEES_SUCCES,
	"",
	"210"
);
?>