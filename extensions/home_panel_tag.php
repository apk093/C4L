
<?php
if(!defined('IN_SCRIPT')) die("");
if(
	!isset($_REQUEST["mod"])&&!isset($_REQUEST["page"])
	||
	(
		isset($_REQUEST["page"])
		&&
		(
			$_REQUEST["page"]=="en_Home"
			||
			$_REQUEST["page"]=="es_Inicio"
			||
			$_REQUEST["page"]=="fr_Accueil"
			||
			$_REQUEST["page"]=="pt_Inicio"
			||
			$_REQUEST["page"]=="de_Startseite"
			||
			strcmp($_REQUEST["page"], "ar_الصفحة الرئيسية") === 0
		)
	)
)
{
$i_carousel_counter = 1;



?>

<?php
$animation_speed=$this->GetParam("ANIMATION_SPEED");
if($this->GetParam("SLIDER_TYPE")==8)
{
	?>
	<div>
		<div class="min-height-350">
	<?php
}
else
if($this->GetParam("SLIDER_TYPE")==1)
{
	?>
	<div class="home-panel-gray">
		<div class="slider-back custom-gradient padding-top-50">
	<?php
}
else
{

	if($this->GetParam("SLIDER_TYPE")==2||$this->GetParam("SLIDER_TYPE")==3||$this->GetParam("SLIDER_TYPE")==4)
	{
		$slide_images=explode(",",$this->params[172]);
		
		$background_url=$this->get_image_file("backgrounds",$slide_images[0]);
	?>
	
	<?php
	if($this->GetParam("SLIDER_TYPE")==2||$this->GetParam("SLIDER_TYPE")==3)
	{
	?>
	<style>
	#home_panel_wrap
	{
		background-image:url('<?php echo $background_url;?>');
	}
	</style>
	<?php
	}
	
	?>
	<div id="home_panel_wrap">
		<div class="min-height-350 padding-top-50">
	<?php
	}
}
?>

<?php

$inner_code = "";
$indicator_code = "";

if($this->GetParam("SLIDER_CONTENT")==3)
{
	$i_slide_counter=0;
	$first_slide=true;
	$slide_images=explode(",",$this->params[172]);
	
	
	for($i=173;$i<=185;$i=$i+3)
	{
		if(trim($this->params[$i])=="") continue;
		
		if($this->GetParam("SLIDER_TYPE")==4)
		{
			
			if(!isset($slide_images[$i_slide_counter]))
			{
				$i_slide_counter=0;
			}
		
			if(isset($slide_images[$i_slide_counter]))
			{
				
				$background_url=$this->get_image_file("backgrounds",$slide_images[$i_slide_counter]);
				
				
			}
			else
			{
				$background_url="";
			}
			
		}
		
		$inner_code .= '<div '.($background_url!=""?' style="background:url('.$background_url.');height:100%;background-size: cover;min-height:380px"':'').' class="'.($background_url!=""?'fill-back ':'').'item '.($first_slide?"active":"").' slide-back">
			<div class="container">
				<div class="xcarousel-caption">';
				
				$inner_code .= "
				<a class=\"carousel-link\" href=\"".$this->params[$i+2]."\">";
				
				
				 $inner_code .= '<h1 class="no-top-margin carousel-link'.($this->GetParam("SLIDER_TYPE")==1?'':' add-shadow').'">'.stripslashes(strip_tags($this->params[$i])).'</h1>
				  <p class="hide-sm'.($this->GetParam("SLIDER_TYPE")==1?'':' add-shadow').'">'.stripslashes(strip_tags($this->params[$i+1])).'</p>';
				  
				
				 $inner_code .= '
					</a>
				 <br/>
				</div>
			</div>
		</div>';
		$first_slide=false;
		$i_carousel_counter++;
		$i_slide_counter++;
	}
}
else
{
	if($this->GetParam("SLIDER_CONTENT")==1)
	{
		$add_query=" AND ".$DBprefix."jobs.featured=1 ORDER BY RAND() ";
	}
	else
	{
		$add_query=" ORDER BY ".$DBprefix."jobs.id ";
	}

	$SearchTable = $this->db->Query
	("
		SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.title,
		".$DBprefix."jobs.date,
		".$DBprefix."jobs.salary,
		".$DBprefix."jobs.applications,
		".$DBprefix."jobs.region,
		".$DBprefix."jobs.message,
		".$DBprefix."employers.company,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."jobs,".$DBprefix."employers  
		WHERE 
		".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
		AND ".$DBprefix."jobs.active='YES' 
		AND expires>".time()." 
		AND ".$DBprefix."jobs.status=1 
		".$add_query." 
		LIMIT 0,".$this->GetParam("NUMBER_OF_FEATURED_LISTINGS")."
	");

	

	if($this->db->num_rows($SearchTable)==0)
	{
	?>
	<style>.slider-back{display:none}</style>
	<?php
	}

		
	if($this->GetParam("SLIDER_TYPE")==4)
	{
		$slide_images=explode(",",$this->params[172]);
	}
		
	$i_slide_counter=0;
	
	while($listing = $this->db->fetch_array($SearchTable))
	{
		
		$headline=str_replace("\"","",strip_tags(stripslashes($listing["title"])));
		
		if(strlen($headline)>50)
		{
			$headline=substr($headline,0,50)."...";
		}
		
		
		$strLink = $this->job_link($listing["id"],$listing["title"]);

		$images=array("","");

		$indicator_code .= '<li data-target="#myCarousel" data-slide-to="'.($i_carousel_counter-1).'" '.($i_carousel_counter == 1?'class="active"':'').'><img src="'.($listing["logo"]==""?'images/no_pic.gif':'thumbnails/'.$listing["logo"].'.jpg').'"  class="img-shadow indicator-image" alt=""/></li>';
			
		
		
		$background_url="";
		
		if($this->GetParam("SLIDER_TYPE")==4)
		{
			
			if(!isset($slide_images[$i_slide_counter]))
			{
				$i_slide_counter=0;
			}
		
			if(isset($slide_images[$i_slide_counter]))
			{
				$background_url=$this->get_image_file("backgrounds",$slide_images[$i_slide_counter]);
			}
			else
			{
				$background_url="";
			}
			
		}
			
		$inner_code .= '<div '.($background_url!=""?' style="background:url('.$background_url.');height:100%;background-size: cover;min-height:380px"':'').' class="'.($background_url!=""?'fill-back ':'').'item '.($i_carousel_counter==1?"active":"").' slide-back">
			<div class="container">
				<div class="xcarousel-caption">';
				
				$inner_code .= "
				<a class=\"carousel-link\" href=\"".$strLink."\">";
				
				if(trim($listing["logo"])!="")
				{
					$inner_code .= "<img class=\"slide-product-image img-responsive right-margin-40\" src=\"".($listing["logo"]==""?'images/no_pic.gif':'thumbnails/'.$listing["logo"].'.jpg')."\" alt=\"".stripslashes(strip_tags($listing["company"]))."\" align=\"left\"/>";
				}
				 $inner_code .= '<h1  class="no-top-margin carousel-link'.($this->GetParam("SLIDER_TYPE")==1?'':' add-shadow').'">'.stripslashes(strip_tags($headline)).'</h1>
				  <p class="carousel-job-text hide-sm'.($this->GetParam("SLIDER_TYPE")==1||true?'':' add-shadow').'">'.$this->text_words(stripslashes(strip_tags($listing["message"])),35).'</p>';
				  
				
				 $inner_code .= '
					</a>
				 <br/>
				</div>
			</div>
		</div>';

		$i_carousel_counter++;
		$i_slide_counter++;
	}
}
?>		
	
<?php


if($this->GetParam("SLIDER_CONTENT")==3 || $this->db->num_rows($SearchTable) > 0)
{
?>
<div id="myCarousel" class="carousel slide">
  
	
	<div id="slider_container" class="carousel-inner">
	 	<?php
			echo $inner_code;
		?>
	</div>
	
	<?php
	if($this->GetParam("SLIDER_TYPE")==3)
	{
		
	}
	else
	if($this->GetParam("SLIDER_TYPE")==1||$this->GetParam("SLIDER_TYPE")==4)
	{
	?>
	  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><img src="images/carousel-arrow-left-white.png" alt="" class="carousel-icon-<?php if($this->GetParam("SLIDER_TYPE")==4) echo "slide";else echo "solid";?>"/></a>
	  <a class="right carousel-control" href="#myCarousel" data-slide="next"><img src="images/carousel-arrow-right-white.png" alt="" class="carousel-icon-<?php if($this->GetParam("SLIDER_TYPE")==4) echo "slide";else echo "solid";?>"/></a>
	<?php	
	}
	else
	{
	?>
	  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><img src="images/carousel-arrow-left.png" alt="" class="carousel-icon"/></a>
	  <a class="right carousel-control" href="#myCarousel" data-slide="next"><img src="images/carousel-arrow-right.png" alt="" class="carousel-icon"/></a>
	<?php
	}
	?>
</div>
<?php
}

if
(
	(
		$this->GetParam("SLIDER_CONTENT")==1 
		|| 
		$this->GetParam("SLIDER_CONTENT")==2
	)
	&&
	$this->db->num_rows($SearchTable) == 0)
{
	
}
else
if($this->GetParam("SLIDER_TYPE")==1||$this->GetParam("SLIDER_TYPE")==4||$this->GetParam("SLIDER_TYPE")==2)
{
?>
<script type="text/javascript">


if(document.getElementById("myCarousel"))
{
	$(document).ready(function() 
	{
		$('.carousel').carousel({
		  interval: <?php echo $animation_speed;?>
		})
	
	});
}
</script>
<?php

}
else
{
	?>

	<script>

	setInterval(function() { 
	  $('#slider_container > div:first')
		.hide()
		.next()
		.fadeIn(1000)
		.end()
		.appendTo('#slider_container');
	},  <?php echo $animation_speed;?>);

	</script>
	<?php
}
?>



</div>


<div class="container">
<?php
if($this->GetParam("SLIDER_TYPE")==4)
{
?>
<div class="search-form-wrap-no-back">
<?php
}
else
if($this->GetParam("SLIDER_TYPE")==1)
{
?>
<div class="solid-search-form-wrap">
<?php
}
else
{
?>
<div class="search-form-wrap">
<?php	
}
?>


	<div class="text-center">
	<h4 class="<?php if($this->GetParam("SLIDER_TYPE")==2||$this->GetParam("SLIDER_TYPE")==3) echo "white-font ";?>bottom-margin-5"><?php echo $M_SEARCH_FOR_JOBS;?></h4>
	</div>
	<form name="home_form" id="home_form" action="index.php"  style="margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px" method="post"> 
	<input type="hidden" name="mod" value="search">
	<input type="hidden" name="search" value="1">
	<input type="hidden" name="lang" value="<?php echo $this->lang;?>">
	<input type="hidden" name="advanced" id="advanced_s" value="0">

		<div class="col-md-5 form-group group-1">
			<span class="main-search-label"><br/></span>
			
			<input type="text" name="job_title" class="input-job" placeholder="<?php echo $M_KEYWORD;?>">
		</div>
	
		<div class="col-md-5 form-group group-3">
			<span id="label_location" class="main-search-label"><br/></span>
			
			<input type="hidden" name="field_location" id="field_location" value=""/>
			<select class="input-location" name="location" id="location"  onchange="dropDownChange(this,'location')">
				<option value=""><?php echo $M_REGION;?></option>
				<?php
				
					if(!isset($loc))
					{
						include("locations/locations_array.php");
					}
					
					if(isset($loc))
					{
						foreach($loc as $key=>$value)
						{
							if(!is_string($value)) continue;
							echo "\n<option value=\"".$key."@".$value."\">".$value."</option>";
						}
					}
					
					?>
			</select>
		</div>
		<div class="col-md-2 no-padding">
			<span class="main-search-label"><br/></span>
			<button type="submit" class="btn main-search-button <?php if($this->admin_settings["custom_color"]!="") echo 'custom-gradient';else echo 'btn-green';?> btn-default btn-green pull-right no-margin width-100"><?php echo $M_SEARCH;?></button>
		
		</div>
				
		<div class="clearfix"></div>
		
	</form>






		<?php
		if($this->GetParam("SLIDER_TYPE")==1||$this->GetParam("SLIDER_TYPE")==8)
		{
		?>
			<div class="solid-search-bottom-wrap">
		<?php
		}
		else
		{
			?>
			<div class="search-bottom-wrap"  >
			<?php
		}
		?>


					<a class="search-bottom-link" href="<?php echo $this->mod_link("advanced_search");?>"><?php echo $M_ADVANCED_SEARCH;?></a>

					<a class="search-bottom-link" href="<?php echo $this->mod_link("email_alerts");?>"><?php echo $M_CREATE_EMAIL_ALERT;?></a>
				
				
					<a class="search-bottom-link" href="<?php if(isset($_COOKIE["AuthE"])) echo "EMPLOYERS/index.php?category=jobs&action=add";else echo $this->mod_link("employers_registration");?>"><?php echo $M_POST_A_JOB;?></a>

						<div class="clearfix"></div>
				</div>



			</div>


</div>
<br/><br/>
</div>
<?php
}
else
{
	?>
	<div class="top-line"></div>
	
	<?php
	
}
?>
