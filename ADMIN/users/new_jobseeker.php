<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?><div class="fright"> 
  <?php 
   echo LinkTile 
    ( 
		"users", 
		"jobseekers", 
		$M_GO_BACK, 
		"", 
		"red" 
    ); 
  ?> 
</div> 
<div class="clear"></div> 

<h3><?php echo $M_ADD_JOBSEEKER;?></h3>
<script>
function validateEmail(email) 
{ 
 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ 
 
 if(email.match(re))
 {
	return true;
 }
 else
 {
	alert(email+" <?php echo $IS_NOT_VALID;?>");
	return false;
 }
}

function ValidateSignupForm(x)
{
	if(x.username.value=="")
	{
		alert("<?php echo $PLEASE_ENTER_YOUR_EMAIL;?>");
		x.username.focus();
		return false;
	}	
		
	if(x.password.value==""){
		alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>");
		x.password.focus();
		return false;
	}	
				
	
	
	if(x.first_name.value==""){
		alert("<?php echo $PLEASE_ENTER_FIRST_NAME;?>");
		x.first_name.focus();
		return false;
	}	
	
	if(x.last_name.value=="")
	{
		alert("<?php echo $PLEASE_ENTER_LAST_NAME;?>");
		x.last_name.focus();
		return false;
	}	
	
	
	return true;
}
</script>

<br>
<?php

$_REQUEST["arrNames2"] = array("active","date");
$_REQUEST["arrValues2"] = array("1",time());


if(is_array(unserialize($website->GetParam("JOBSEEKER_FIELDS"))))
{
	$arrUserFields = unserialize($website->GetParam("JOBSEEKER_FIELDS"));
}
else
{
	$arrUserFields = array();
}


if(isset($_POST["SpecialProcessAddForm"]))
{
	$user_email=$_REQUEST["username"];
	if($database->SQLCount("employers","WHERE username='$user_email' ") > 0 || $database->SQLCount("jobseekers","WHERE username='$user_email' ") > 0)
	{
		echo "<h3 class=\"red_font\">
		There is already an user registered with this email address - 
		please choose a different email address!
		</h3><br/><br/>";
		
		unset($_REQUEST["SpecialProcessAddForm"]);
	}
	
	$arrPValues=array();
	$iFCounter = 0;
	foreach($arrUserFields as $arrUserField)
	{		
		$arrPValues[$arrUserField[0]]=get_param("pfield".$iFCounter);
		$iFCounter++;
	}

	if(sizeof($arrPValues)>0)	
	{
		array_push($_REQUEST["arrNames2"],"jobseeker_fields");
		array_push($_REQUEST["arrValues2"],serialize($arrPValues));	
	}
		
}

$custom_user_fields="";

$iFCounter = 0;	
			
foreach($arrUserFields as $arrUserField)
{
	
	$custom_user_fields .= "<tr>";
	
	$custom_user_fields .=  "<td>".str_show($arrUserField[0], true).":</td><td>";	
	
	
	if(trim($arrUserField[2]) != "")
	{
			$custom_user_fields .=  "<select  name=\"pfield".$iFCounter."\" class=\"280px-field\">";
			
			
			$arrFieldValues = explode("\n", trim($arrUserField[2]));
					
						
			if(sizeof($arrFieldValues) > 0)
			{
				foreach($arrFieldValues as $strFieldValue)
				{
					$strFieldValue = trim($strFieldValue);
					if(strstr($strFieldValue,"{"))
					{
					
						$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
						
						$custom_user_fields .=  "<option ".(trim($$strVName)==$arrPropFields[$arrUserField[0]]?"selected":"").">".trim($$strVName)."</option>";
						
					}
					else
					{
						$custom_user_fields .=  "<option ".(isset($arrPropFields[$arrUserField[0]])&&trim($strFieldValue)==$arrPropFields[$arrUserField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
					}		
				
				}
			}
			
			$custom_user_fields .=  "</select>";
	}
	else
	{
			$custom_user_fields .=  "<input value=\"".(get_param("pfield".$iFCounter)!=""?get_param("pfield".$iFCounter):"")."\" type=text name=\"pfield".$iFCounter."\" class=\"280px-field\">";
	}
		
	$custom_user_fields .=  "</td></tr>";
	
	$iFCounter++;		
}

$_REQUEST["FieldsToAdd"]=$custom_user_fields;


AddNewForm
(
	array($M_EMAIL.":",$M_PASSWORD.":",$FIRST_NAME.":",$LAST_NAME.":",$M_ADDRESS.":",$M_PHONE.":",$M_MOBILE.":",$M_DOB.":"),
	array("username","password","first_name","last_name","address","phone","mobile","dob"),
	array("textbox_50","textbox_50","textbox_50","textbox_50","textarea_37_4","textbox_50","textbox_50","textbox_50"),
	$AJOUTER,
	"jobseekers",
	$M_JOBSEEKER_ADDED,
	false,
	array(),
	"ValidateSignupForm"
);
?>

