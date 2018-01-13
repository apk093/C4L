<?php
// Jobs Portal All Rights Reserved
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
		"settings",
		"payments",
		$M_PAYMENTS,
		"",
		"green"
	 );
	 ?>
	 <div class="clearfix"></div>
	 <?php
			 
	echo LinkTile
	 (
		"settings",
		"categories",
		$M_CATEGORIES,
		"",
		"yellow"
	 );
	 ?>
	 <div class="clearfix"></div>
	
	 <?php
	 
	 echo LinkTile
	 (
		"settings",
		"feeds",
		$M_JOB_FEEDS,
		"",
		"red"
	 );
	  ?>
	 <div class="clearfix"></div>
	<?php
	 echo LinkTile
	 (
		"settings",
		"locations",
		$M_LOCATIONS,
		"",
		"lila"
	 );
	?>
	 <div class="clearfix"></div>
	 <?php
	 
	 echo LinkTile
	 (
		"settings",
		"field_values",
		$M_FIELD_VALUES,
		"",
		"gray"
	 );
	 ?>
	
</div>

<span class="medium-font">
<?php echo $M_CONFIGURATION_OPTIONS;?>
</span>
<br/>
<br/>
<br/>
		
<?php

$_REQUEST["message-column-width"]="240";
$_REQUEST["select-width"]="200";

$values_list="94,95,96,97,99,102,103,104,105,106,107,108,109,110,111,114,115,129,130,131,132,133,134,135,136,137,141,142,143,144,145,146,147,148,149,150,151,152,153,154,410,411,812,813,814,815";

	EditParams
	(
		$values_list,
		array
		(
			"textbox_50",
			"textbox_50",
			"textbox_50",
			"textbox_10",
			"combobox_".$M_YES."^1_".$M_NO."^0",
			
			"textbox_30",
			"textbox_30",
			"combobox_".$M_YES."^1_".$M_NO."^0",//send email when approve
			"textbox_30",
			"textarea_53_4",
			"textbox_5",
			"textbox_30",
			"textbox_5",
			"textbox_30",
			"textarea_53_4",
			"combobox_".$M_YES."^1_".$M_NO."^0",
			"textbox_50",
			"textbox_50",
			"textbox_50",
			"textbox_30",
			"textbox_30",
			"combobox_".$M_YES."^1_".$M_NO."^0",
			"combobox_".$M_YES."^1_".$M_NO."^0",
			"textbox_30",
			"textbox_30",
			
			"textarea_53_4",
			
			
			"combobox_".$M_YES."^1_".$M_NO."^0", //twitter
			"textbox_30",
			"textbox_30",
	
			
			"combobox_".$M_YES."^1_".$M_NO."^0", //linkedin
			"textbox_30",
			"textbox_30",
			"textbox_70",
			
			"combobox_".$M_NO."^0_".$M_YES."^1", // use external smtp server
			"textbox_70",
			"textbox_70",
			"textbox_70",
			"combobox_none_ssl_tls",
			"textbox_30",
			"textbox_70",
			"combobox_".$M_YES."^1_".$M_NO."^0",
			"combobox_".$M_YES."^1_".$M_NO."^0",
			
			"textarea_53_4",
			"textbox_50",
			
			"textarea_53_4",
			"textbox_50"
			
			
		),
			$M_SAVE,
			$M_NEW_VALUES_SAVED
	);

?>
		
		
	<br>

