<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007") die("ACCESS DENIED");
?>
<div class="fright">
	<?php
			 
	echo LinkTile
	(
		"settings",
		"options",
		$M_CONFIGURATION_OPTIONS,
		"",
		"blue"
	);
?>
</div>
<div class="clear"></div>
<span class="medium-font">
<?php echo $M_JOB_FEEDS;?> - <?php echo $M_SETTINGS;?>
</span>
<br/>
<br/>
<br/>

<script>
function SaveFeeds(x)
{
	if(x.val600.value==2)
	{
		if(x.val601.value==x.val602.value)
		{
			alert("<?php echo $M_MIX_SAME;?>");
			x.val602.focus();
			return false;
		}
		
		if(x.val601.value==x.val603.value)
		{
			alert("<?php echo $M_MIX_SAME;?>");
			x.val603.focus();
			return false;
		}
		
		if(x.val602.value!=0&&x.val602.value==x.val603.value)
		{
			alert("<?php echo $M_MIX_SAME;?>");
			x.val603.focus();
			return false;
		}
		
		if((parseInt(x.val604.value)+parseInt(x.val605.value)+parseInt(x.val606.value))!=10)
		{
			alert(x.val604.value+x.val605.value+x.val606.value);
			alert("<?php echo $M_TOTAL_SUM_100;?>");
			x.val604.focus();
			return false;
		}
	}

	return true;
}
</script>
		
<?php

$_REQUEST["message-column-width"]="240";
$_REQUEST["select-width"]="200";

	EditParams
	(
		"600,601,602,603,604,605,606,607,608,609,610,611,612,613,614",
		array
		(
			"combobox_Don't use any feeds^0_Use one main feed^1_Mix feeds^2",
			"combobox_Indeed^1_SimplyHired^2_CareerJet^3",
			"combobox_None^0_Indeed^1_SimplyHired^2_CareerJet^3",
			"combobox_None^0_Indeed^1_SimplyHired^2_CareerJet^3",
			"combobox_100%^10_90%^9_80%^8_70%^7_60%^6_50%^5_40%^4_30%^3_20%^2_10%^1_0%^0",
			"combobox_100%^10_90%^9_80%^8_70%^7_60%^6_50%^5_40%^4_30%^3_20%^2_10%^1_0%^0",
			"combobox_100%^10_90%^9_80%^8_70%^7_60%^6_50%^5_40%^4_30%^3_20%^2_10%^1_0%^0",
			"textbox_40","textbox_5","textarea_50_4",
			"textbox_40","textbox_40","textbox_40","textbox_40","textbox_80"
		),
			$M_SAVE,
			$M_NEW_VALUES_SAVED,
			"SaveFeeds"
	);

?>
		
		
	<br>

