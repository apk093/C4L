<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$link_suffix="";

if($MULTI_LANGUAGE_SITE)
{
	$link_suffix="lang=".$this->lang;
}

if(isset($_COOKIE["saved_listings"])&&trim($_COOKIE["saved_listings"])!="")
{

	$items=explode(",",$_COOKIE["saved_listings"]);
?>
	<li class="shortlisted-jobs">
		<a href="<?php echo $this->mod_link("saved");?>"><img src="images/shortlisted-white.png"/> <?php echo (sizeof($items)-1);?> <?php echo $M_JOBS;?></a>
	</li>
<?php
}
?>
