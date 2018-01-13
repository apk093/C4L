<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br/>
<span class="medium-font">
<?php echo $M_MODULES;?>
</span>
<br/><br/><br/>
<?php
	echo LinkTile
		 (
			"news",
			"news",
			$M_NEWS,
			"",
			"blue"
		 );

		 echo LinkTile
		 (
			"faq_manager",
			"home",
			$M_FAQ_MANAGER,
			"",
			"lila"
		 );
	?>

<?php	 
		

		 echo LinkTile
		 (
			"newsletter",
			"home",
			$M_NEWSLETTER,
			"",
			"red"
		 );
		 
		
		 
?>
		