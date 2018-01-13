<?php
if(!defined('IN_SCRIPT')) die("");
?>

<?php
if($website->GetParam("CHARGE_TYPE") == 1)
{
?>	
	<div class="fright">

		<?php
			echo LinkTile
			 (
				"home",
				"welcome",
				$M_DASHBOARD,
				"",
				"blue"
			 );
		
		?>

	</div>
	<div class="clear"></div>


	<h3><?php echo $M_SUBSCRIPTIONS;?></h3>
	<br/>
	<?php echo $M_PURCHASE_SUBSCRIPTION_EXPL;?>
	<br/><br/>
	<?php
	if($arrUser["subscription"]==0)
	{
	?>
		<?php echo $M_ANY_SUBSCRIPTION;?>
		<br/><br/>
	<?php
	}
	else
	{
	?>
	<br/>
		<strong><?php echo $M_YOUR_CURRENT_SUBSCRIPTION;?>:</strong>
		
	<?php
		$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
	
		echo "<b>".stripslashes($arrSubscription["name"])."</b><br/>".stripslashes($arrSubscription["description"]);
		echo "<br/>"
		.$M_MAX_LISTINGS.": <b>".$arrSubscription["listings"]."</b>, ".
		$M_MAX_FEATURED_LISTINGS.": <b>".$arrSubscription["featured_listings"]."</b>, ".
		$M_MAX_BANNERS.": <b>".$arrSubscription["banners"]."</b>";
	}
	?>
	<br/><br/><br/>
	<h3><?php echo $M_CHOOSE_NEW_SUBSCRIPTION;?></h3>
	<hr style="margin-bottom:0px"/>
	<?php
	$subscriptions = $database->DataTable("subscriptions","WHERE id<>".$arrUser["subscription"]);
	
	while($current_subscription = $database->fetch_array($subscriptions))
	{
		?>
		<div class="col-md-3 pricing-container">
			<div class="price-column">
				<h2 class="price-h2" style="min-height:110px"><?php echo stripslashes($current_subscription["name"]);?></h2>
				<h3 class="price-h3">
				
					<?php 
					if($current_subscription["price"]!=""&&$current_subscription["price"]!=0)
					{
						echo $website->GetParam("WEBSITE_CURRENCY").$current_subscription["price"]." / ".$current_subscription["billed"]." ".($current_subscription["billed"]==1?$M_MONTHS:$M_MONTHS);
					}
					else
					{
						echo $M_FREE;
					}
					?>
				</h3>
				<p class="text-center">
					<?php 
						echo stripslashes($current_subscription["description"]);
					?>
				</p>
				
				<ul class="text-center price-ul">
					<li>
						<?php echo $M_MAX_LISTINGS.": <strong>".$current_subscription["listings"]."</strong>";?>
					</li>
					<li>
						<?php echo $M_MAX_FEATURED_LISTINGS.": <strong>".$current_subscription["featured_listings"]."</strong>";?>
					</li>
					<li>
						<?php echo $M_MAX_BANNERS.": <strong>".$current_subscription["banners"]."</strong>";?>
					</li>
					
				</ul>
				
				<div class="price-bottom">
					<a href="index.php?category=home&action=new_subscription&id=<?php echo $current_subscription["id"];?>" class="btn btn-default price-btn"><?php echo $M_SELECT;?></a>
				</div>
			</div>
		</div>
			
		
		<?php
	}
	
	?>

<?php
}
?>	
	
<?php
if($website->GetParam("CHARGE_TYPE") == 2)
{
?>
	<div class="fright">

	<?php
		echo LinkTile
		 (
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"blue"
		 );
		
		echo LinkTile
		 (
			"home",
			"credits_purchase",
			$M_PURCHASE_CREDITS,
			"",
			"green"
		 );
	?>

</div>
<div class="clear"></div>
	<h3><?php echo $M_CREDIT_PURCHASE;?></h3>
					
	<br/>
		
		
		<?php echo $M_CURRENTLY_YOU_HAVE;?> <font color="red"><?php if($arrUser["credits"]>=0) echo $arrUser["credits"];else echo "0";?> <?php echo $M_CREDITS;?> </font>
		&nbsp;
		,&nbsp; <?php echo $M_PRICE_FOR;?> 1 <?php echo $M_CREDIT;?> 
		<font color=red>
		<?php echo $website->GetParam("WEBSITE_CURRENCY");?><?php echo aParameter(700);?>
		</font>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="index.php?category=home&folder=credits&page=purchase">[<?php echo $M_PURCHASE_CREDITS;?>]</a>
		
		
		<br><br><br><br><br>
		<b><?php echo $M_VIEW_CANCEL_PENDING_PAYMENTS;?>:</b>
		<br><br>
	
		<?php
		
		if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
		{
			$website->ms_ia($_REQUEST["CheckList"]);
			$database->SQLDeletePlus("employer",$AuthUserName,"credits","id",$_REQUEST["CheckList"]);
		}
		
		if($database->SQLCount("credits","WHERE employer='".$AuthUserName."' and status=0   ")==0)
		{
			echo "<br>[".$M_ANY_PENDING_PAYMENTS."]";
		
		}
		else
		{
			
			RenderTable
			(
				"credits",
				array("date_start","credits","amount","payment"),
				array($DATE_MESSAGE,$M_CREDITS,$M_AMOUNT,$M_PAYMENT),
				"600",
				"WHERE employer='$AuthUserName' and status=0   ",
				"Cancel",
				"id",
				"index.php?action=".$action."&category=".$category
			);
			
		}
				
		?>
		<div class="clearfix"></div>
		<br/>
		<br/>
		<br/>
		<h3><?php echo $M_PRICES_CREDITS;?></h3>
		<br>	
			<strong><?php echo $M_SUBMIT_LISTING;?></strong>
			<br/>
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo $website->GetParam("PRICE_LISTING_CREDITS");?></b></font>
			
			<br><br>
						
			<strong><?php echo $M_PRICE_FEATURED_AD;?></strong>
			<br/>
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo aParameter(703);?></b></font>
			
			<br><br>
			
			<?php
			if($database->SQLCount("banner_areas","")>0)
			{
			?>
			
			<strong><?php echo $M_BANNERS;?></strong>
		<br>
			
			<?php echo $M_PRICES_FROM;?>
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo $database->SQLMin("banner_areas","price");?></b></font>
			&nbsp; <?php echo strtolower($M_TO);?> &nbsp; 
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo $database->SQLMax("banner_areas","price");?></b></font>
			&nbsp;&nbsp; 
			<?php echo $M_DEPENDING_ZONE;?>
			<br><br>
		
			<?php
			}
			?>
			
			
			<strong>Price to open a CV from the database</strong>
			<br/>
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo $website->params[704];?></b></font>
			
		
		
		
<?php
}
?>	