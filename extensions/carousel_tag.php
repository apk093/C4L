<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$csTable = $this->db->DataTable("employers","WHERE logo<>'' AND active=1 ORDER BY featured_employer DESC, RAND() LIMIT 0,20");
if($this->db->num_rows($csTable) > 0)
{	
?>
<div id="companies-carousel">
	<div class="container text-center">
	<script type="text/javascript">
	var companies_carousel_itemList = [
	<?php
	
	$b_first_item = true;
	while($csArray = $this->db->fetch_array($csTable))
	{
		$strImageUrl = "";													
		
		$strImageUrl = "thumbnails/".$csArray["logo"].".jpg";
			
		$headline=strip_tags(stripslashes($csArray["company"]));
		
		if(strlen($headline)>38)
		{
			$headline=substr($headline,0,38)."...";
		}
		
		$strALink = $this->company_link($csArray["id"],$csArray["company"]);
		
		
		if(!$b_first_item) echo ",\n";
		?>
		{url: "<?php echo $strImageUrl;?>", title: "", link: "<?php echo $strALink;?>"}

		<?php
		$b_first_item = false;
		
	}

	if($this->db->num_rows($csTable) > 0)
	{
	?>
	];
	</script>
	<script src="js/carousel.js"></script>
	<?php
	}
	?>
	<br/>
	<h3 class="no-margin"><?php echo $M_FIND_NEXT_JOB_LEADING_COMPANIES;?></h3>
	<div id="ads-rotator" <?php if($b_first_item) echo "style=\"display:none\"";?> >
	<br/>

		<div id="wrap">
			<ul id="companies_carousel"  class="jcarousel-skin-ie7">
		
			</ul>
		</div>
	</div>

	
	<div class="clear"></div>	
	
	</div>
</div>
<?php
}
?>