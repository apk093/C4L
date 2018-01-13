<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?>
<?php
$arrTemplate=DataArray("templates","id=$id");
?>

<script>
function ToggleBorders(){

	toggle="off";
	var allTables = Container.getElementsByTagName("TABLE");
	for (i=0; i < allTables.length; i++) {
		
		allTables[i].contentEditable = "true"
				if (toggle == "off") {
					allTables[i].runtimeStyle.border = "1px dotted #BFBFBF"
					
				} else {
					allTables[i].runtimeStyle.cssText = ""
				}
				
				allRows = allTables[i].rows
				for (y=0; y < allRows.length; y++) {
				 	allCellsInRow = allRows[y].cells
						for (x=0; x < allCellsInRow.length; x++) {
							if (toggle == "off") {
								
								allCellsInRow[x].runtimeStyle.border = "1px dotted #BFBFBF"
								
							} else {
								allCellsInRow[x].runtimeStyle.cssText = ""
							}
						}
				}
		}
}
</script>


<!--

<table summary="" border="0" align=center >
	<tr>
		<td>
			<br>
			<wsm languages_menu/>
			
			<wsm menu/>
			<br>
			<wsm content/>
		</td>
	</tr>
</table>
-->

<div id="Container" style="position:absolute;top:200;left:200;width:750;height:500" contenteditable>

<?php 
//echo stripslashes($arrTemplate["html"]);
?>


<table summary="" border="0" align=center >
	<tr>
		<td>
			<br>
			
			<img src="images/mainblock.gif" border="0" width="48" height="48" alt="">
			<br>
			<img src="images/topicsman.gif" border="0" width="48" height="48" alt="">
			<br>
			<img src="images/postnew.gif" border="0" width="48" height="48" alt="">
			
		</td>
	</tr>
</table>

</div>

<script>
ToggleBorders();
</script>