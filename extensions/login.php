<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br/>
<div class="page-wrap">
	<h3 class="no-margin">
	

	<?php
	if(isset($_REQUEST["error"])&&$_REQUEST["error"]=="login")
	{
		echo $LOGIN_ERROR_MESSAGE;
	}
	else
	if(isset($_REQUEST["error"])&&$_REQUEST["error"]=="no")
	{
		echo $LOGIN_EMPTY_FIELD_MESSAGE;
	}
	else
	if(isset($_REQUEST["error"])&&$_REQUEST["error"]=="expired")
	{
		echo $LOGIN_EXPIRED_MESSAGE;
	}
	else
	{
	  echo $M_LOGIN;
	}
	?>
	
	</h3>
<hr/>

<div class="clearfix"></div>

	
		<?php

		$logged_user_type="";
		?>

			<script>
			function ValidateLoginForm(x)
			{
				if(x.Email.value=="")
				{
					document.getElementById("top_msg_header").innerHTML=
					"<?php echo $USERNAME_EMPTY_FIELD_MESSAGE;?>";
					x.Email.focus();
					return false;
				}
				else
				if(x.Password.value=="")
				{
				
					document.getElementById("top_msg_header").innerHTML=
					"<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>";
					x.Password.focus();
					return false;
				}
				return true;
			}
			</script>
			<?php

			if(isset($_REQUEST["return_url"])&&$_REQUEST["return_url"]!="")
			{

			}
			else
			{
				$return_url="";
				if(isset($_REQUEST["return_category"])) $return_url.="&category=".$_REQUEST["return_category"];
				if(isset($_REQUEST["return_action"])) $return_url.="&action=".$_REQUEST["return_action"];
				
			}


				
			?>
			
			<form class="no-margin" action="loginaction.php" method="post" onsubmit="return ValidateLoginForm(this)">
			<input type="hidden" name="mod" value="login"/>
			<table>
			<?php
			if(isset($MULTI_LANGUAGE_SITE))
			{
			?>
				<input type="hidden" name="lang" value="<?php echo $website->lang;?>">
			<?php
			}
			
			if(isset($_REQUEST["return_url"]))
			{
			?>
				<input type="hidden" name="return_url" value="<?php echo $_REQUEST["return_url"];?>">
			<?php
			}
			?>
				<tr height="36">
				
					<td width="25%"><?php echo $M_USERNAME;?>: </td>
					<td><input type="text" size="40" class="form-field width-100" value="<?php if(isset($_REQUEST["Email"])) echo $_REQUEST["Email"];?>" name="Email"/></td>
					
				</tr>
				<tr>
					<td width="25%"><?php echo $M_PASSWORD;?>: </td>
					<td><input  size="40" class="form-field width-100" type="password" name="Password"/></td>
					
				</tr>
				<tr>
					<td colspan="2">  
					
					<br/>
					<input type="submit" class="pull-right btn btn-primary" value="<?php echo $M_LOGIN;?>"/>
					<br/>
					<a class="underline-link" href="<?php echo $website->mod_link("forgotten_password");?>"><?php echo $FORGOTTEN_PASSWORD;?></a> 
			
					</td>
				</tr>
				
			</table>
			</form>
			<br/><br/>
					
					
		

<?php
$website->Title($M_LOGIN);
$website->MetaDescription("");
$website->MetaKeywords("");
?>
</div>


<div class="clearfix"></div>

<br/><br/>