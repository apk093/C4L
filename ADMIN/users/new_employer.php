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
		"employers", 
		$M_GO_BACK, 
		"", 
		"red" 
    ); 
  ?> 
</div> 
<div class="clear"></div> 
<h3><?php echo $M_ADD_NEW_EMPLOYER;?></h3>
<br/>	
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

	function ValidateSignupForm(x){
		
		
			if(x.username.value==""){
				alert("<?php echo $PLEASE_ENTER_YOUR_EMAIL;?>");
				x.username.focus();
				return false;
			}	
			
			
						
			if(x.password.value==""){
				alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>");
				x.password.focus();
				return false;
			}	
						
			if(x.user_email.value != x.confirm_email.value)
			{
				alert("<?php echo $EMAILS_MISMATCH;?>");
				x.user_email.focus();
				return false;
			}	
			
			if(x.company.value==""){
				alert("<?php echo $ENTER_COMPANY_NAME;?>");
				x.company.focus();
				return false;
			}	
			
			
			return true;
		}
</script>
<?php
$_REQUEST["arrNames2"] = array("active","date");
$_REQUEST["arrValues2"] = array("1",time());



if(is_array(unserialize($website->GetParam("EMPLOYER_FIELDS"))))
{
	$arrUserFields = unserialize($website->GetParam("EMPLOYER_FIELDS"));
}
else
{
	$arrUserFields = array();
}





if(isset($_REQUEST["credits"])&&$_REQUEST["credits"]=="") $_REQUEST["credits"]=0;

if(isset($_REQUEST["SpecialProcessAddForm"]))
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
		array_push($_REQUEST["arrNames2"],"employer_fields");
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



if($website->GetParam("CHARGE_TYPE")==1)
{

	$subscriptions=$database->DataTable("subscriptions","");
	$str_subscr="combobox_".$M_NO_SUBSCRIPTION."^0";
	while($arr_subscription=$database->fetch_array($subscriptions))
	{
		$str_subscr.="_".$arr_subscription["name"]."^".$arr_subscription["id"];
		
	}

	AddNewForm
	(

		array($M_EMAIL.":",$M_PASSWORD.":",$M_COMPANY.":",$CONTACT_PERSON.":",$M_COMPANY_DESCRIPTION.":",$M_ADDRESS.":",$M_PHONE.":",$M_WEBSITE.":",$M_SUBSCRIPTION.":"),
		array("username","password","company","contact_person","company_description","address","phone","website","subscription"),
					
		array("textbox_40","textbox_40","textbox_40","textbox_40","textarea_50_4","textarea_50_4","textbox_40","textbox_40",$str_subscr),
					
		$AJOUTER,
		"employers",
		$M_NEW_EMPLOYER_ADDED,
		false,
		array(),
		"ValidateSignupForm"
	);

}
else
{

	AddNewForm
	(

		array($M_EMAIL.":",$M_PASSWORD.":",$M_COMPANY.":",$CONTACT_PERSON.":",$M_COMPANY_DESCRIPTION.":",$M_ADDRESS.":",$M_PHONE.":",$M_WEBSITE.":",$M_CREDITS.":"),
		array("username","password","company","contact_person","company_description","address","phone","website","credits"),
					
		array("textbox_40","textbox_40","textbox_40","textbox_40","textarea_50_4","textarea_50_4","textbox_40","textbox_40","textbox_4"),
					
		$AJOUTER,
		"employers",
		$M_NEW_EMPLOYER_ADDED,
		false,
		array(),
		"ValidateSignupForm"
	);
}
?>

