<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br/>
<div class="page-wrap">

	<div class="page-header">
		<h3 class="no-margin"><?php echo $M_ARE_YOU_JOBSEEKER;?></h3>
	</div>
		
		<?php echo $M_REGISTER_APPLY;?>
		<br/><br/>
		<a  href="<?php echo $website->mod_link("jobseekers");?>" class="min-width-200 btn btn-primary no-decoration">
			<?php echo $M_SIGNUP;?>
		</a>
		
		
	
	<br/>
	<br/>
	
	<div class="page-header">
		<h3 class="no-margin"><?php echo $M_ARE_YOU_RECRUITER;?></h3>
	</div>
	
	
	
		<?php echo $M_SIGNUP_POST;?>
		<br/><br/>
	
		<a  href="<?php echo $website->mod_link("employers_registration");?>" class="min-width-200 btn btn-primary no-decoration">
			<?php echo $M_CREATE_FREE_ACCOUNT;?>
		</a>
	
	<br/>
	<br/>
	
	
	
	
</div>
<br/>
<br/>
<?php
$website->Title($M_REGISTER);
$website->MetaDescription("");
$website->MetaKeywords("");
?>