<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007")
{
	die("ACCESS DENIED");
}
?>
<?php
$database->Query("
	INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
	VALUES('".$AuthUserName."','".$_SERVER['REMOTE_ADDR']."','".time()."','logout','')
");

setcookie("Auth","",time()-1);
?>
		
<span class="medium-font">
<?php echo $NOUS_VOUS_REMERCIONS;?>
</span>
	
<script>

	setTimeout("document.location.href='login.php'",2000);
</script>
						
