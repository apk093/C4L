<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php 	

if(isset($_REQUEST["renew"])&&$_REQUEST["renew"]==1)
{
	$banner = $_REQUEST["id"];
	
	$website->ms_i($banner);
	
	$arrBanner=$database->DataArray("banners","id=".$banner);
	
	$arrSelectedArea = $database->DataArray("banner_areas","id=".$arrBanner["banner_type"]);
							
	
	$database->SQLUpdate_SingleValue
	(
		"banners",
		"id",
		$banner,
		"expires",
		(time()+$arrSelectedArea["days"]*86400)
		
	);	

}

if(isset($_POST["Delete"])&&sizeof($_POST["CheckList"])>0)
{

	$arrImgIds = array();
	foreach($_POST["CheckList"] as $strID)
	{
		$website->ms_i($strID);
		$arrB = $database->DataArray("banners","id=".$strID." ");
		
		if(!isset($arrB["id"]))
		{
			die("");
		}
		
		array_push($arrImgIds,$arrB["image_id"]);		
	}
	
	$database->SQLDelete("image","image_id",$arrImgIds);
	$database->SQLDelete("banners","id",$_POST["CheckList"]);	
}
?>


<div class="fright">

	<?php
	echo LinkTile
		 (
			"settings",
			"banner_areas",
			$M_BANNER_AREAS,
			"",
			
			"blue"
		 );
		 
	echo LinkTile
		 (
			"settings",
			"place_banner",
			$M_ADD_NEW_B,
			"",
			
			"green"
		 );
		?>
</div>
<div class="clear"></div>
<br/>
		
		<b><?php echo $M_LIST_CURRENT_B;?>:</b>
		
		
		<br>
		
		<?php

		if($database->SQLCount("banners","")==0)
		{
		
			echo "<br>[".$M_CURRENTLY_NO_BANNERS."]";
		
		}
		else
		{
			
			RenderTable
			(
				"banners",
				array("EditNote","ShowRenew","name","active","banner_type","date","image_id"),
				array($MODIFY,$M_RENEW,$NOM,$ACTIVE,$M_AREA2,$DATE_MESSAGE,$M_IMAGE),
				600,
				" ",
				$EFFACER,
				"id",
				"index.php"
			);
						
						
		}
		?>
	