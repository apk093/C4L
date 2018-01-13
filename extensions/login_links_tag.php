<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
$link_suffix="";

if($MULTI_LANGUAGE_SITE)
{
	$link_suffix="lang=".$this->lang;
}

if(isset($_COOKIE["AuthJ"])&&$_COOKIE["AuthJ"]!="")
{
	$cookie_items=explode("~",$_COOKIE["AuthJ"]);
	$this->ms_ew($cookie_items[0]);
	$arrJobseeker = $this->db->DataArray("jobseekers","username='".$cookie_items[0]."'");
	?>
	<li class="active"><a class="custom-back-color" href="JOBSEEKERS/index.php<?php if($MULTI_LANGUAGE_SITE) echo "?lng=".$this->lang;?>"><span class="btn-main-login underline-link"><?php echo stripslashes($arrJobseeker["first_name"]." ".$arrJobseeker["last_name"]);?></span></a></li>
	<?php
}
else
if(isset($_COOKIE["AuthE"])&&$_COOKIE["AuthE"]!="")
{
	$cookie_items=explode("~",$_COOKIE["AuthE"]);
	$this->ms_ew($cookie_items[0]);
	$arrEmployer = $this->db->DataArray("employers","username='".$cookie_items[0]."'");
	?>
	<li class="active"><a class="login-trigger custom-back-color" href="EMPLOYERS/index.php<?php if($MULTI_LANGUAGE_SITE) echo "?lng=".$this->lang;?>"><span class="btn-main-login underline-link"><?php echo stripslashes($arrEmployer["company"]);?></span></a></li>
	<?php
}
else
{

?>
	<li class="active"><a href="" class="login-trigger custom-back-color" data-toggle="modal" data-target="#login-modal"><?php echo $M_LOGIN;?></a></li>
<?php
}
?>