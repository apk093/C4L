<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><div class="fright">
	<?php
	echo LinkTile
	 (
		"settings",
		"payments",
		$M_GO_BACK,
		"",
		
		"red"
	 );
	?>
</div>
<div class="clear"></div>
<h3>
		
		<?php echo $M_ADD_NEW_JOBSEEKER_PACKAGE;?>
		
</h3>
<br/>

<div id="addnews" >
<?php

$_REQUEST["message-column-width"] = 170;

AddNewForm(
		array
		(
						"Name:","Description:",
						"Price, ex. \"14.99\" :<br><i>put 0.00 if free</i>",
						"Billed (Months):"
		),
		array
		(
						"name","description",
						"price",
						"billed"
		),
		array
		(
						"textbox_67","textarea_50_6","textbox_5",
						
						"combobox_1_3_6_12_24"
		),

		" $AJOUTER",
		"jobseeker_packages",
		$M_NEW_PACKAGE_ADDED_SUCC."<br><br>"
	);
?>
</div>

<?php
if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]))
{
	
	if(isset($_REQUEST["CheckList"])&&sizeof($_REQUEST["CheckList"])>0)
	{
		$website->ms_ia($_REQUEST["CheckList"]);
		$database->SQLDelete("jobseeker_packages","id",$_REQUEST["CheckList"]);
	
	}

}
?>

<br>
<?php

$arrTDSizes = array("50","20","100","*","100","100","50","50");

RenderTable
(
	"jobseeker_packages",
	array("EditNote","id","name","description","price","billed"),
	array("Modify","ID","Name","Description","Price","Billed"),
	"100%",
	
	(isset($order_type)?"":"ORDER BY id DESC"),
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);
?>


