<div class="fright">
	<?php
	echo LinkTile
	 (
		"settings",
		"jobseeker_packages",
		$M_GO_BACK,
		"",
		
		"red"
	 );
	?>
</div>
<div class="clear"></div>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
?>



<?php
$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
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
		array(),
		array
		(
						"textbox_67","textarea_50_6","textbox_5",
						
						"combobox_1_3_6_12_24"
		),
	"jobseeker_packages",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES,
	"",
	180
);

?>
<br><br>

