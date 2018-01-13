<?php
if(!defined('IN_SCRIPT')) die("");


$strSearchString = "";
		
foreach ($_POST as $key=>$value) 
{ 
	if($key != "num"&&$key!="i_start")
	{
		if($value=="") continue;
		$strSearchString .= $key."=".$value."&";
	}
}

foreach ($_GET as $key=>$value) 
{ 
	
	if($key != "num"&&$key!="i_start")
	{
		if($value=="") continue;
		$strSearchString .= $key."=".$value."&";
	}
}
$strSearchString = str_replace("latest=1&","search=1&advanced=0&",$strSearchString);
?>

<?php
if(isset($this->filters["types"]))
{
?>
<script>
function FilterResults(type,value)
{
	var search_string="<?php echo $strSearchString;?>";
	if(value!="")
	{
		if(search_string.indexOf(type+"=") !== -1)
		{
		
			var match_text=type+"=[^&]+";
			var re = new RegExp(match_text,"gi");
			search_string=search_string.replace(re, type+"="+value);
			document.location.href="index.php?<?php echo 'lang='.$this->lang.'&';?>search=1&"+search_string;
		}
		else
		{
			document.location.href="index.php?<?php echo 'lang='.$this->lang.'&';?>search=1"+search_string+"&"+type+"="+value;
		}
	}
}
</script>
<br/><br/>
<div class="gray-wrap">

	<h4 class="aside-header">
		<?php echo $M_JOB_TYPE;?>
	</h4>
	
	<hr class="top-bottom-margin"/>
	
		<select name="job_type" class="form-control" onchange="FilterResults('job_type',this.options[this.selectedIndex].value)">
			<option value="-1"><?php echo $M_ALL;?></option>
			<?php
			foreach($this->GetParam("arrJobTypes") as $key=>$value)
			{
				echo '<option value="'.$key.'" '. (isset($_REQUEST["job_type"])&&$_REQUEST["job_type"]==$key?"selected":"").'>'.$value.(false&&isset($this->filters["types"][$key])?" (".$this->filters["types"][$key].")":"").'</option>';
			}
			?>
		</select>
	
	<div class="clearfix"></div>
	<br/>
</div>
<br/>


<div class="gray-wrap">

	<h4 class="aside-header">
		<?php echo $M_DATE_POSTED;?>
	</h4>
	
	<hr class="top-bottom-margin"/>
	
		<select class="form-control" name="posting_date" onchange="FilterResults('posting_date',this.options[this.selectedIndex].value)">
			<option value=""><?php echo $M_ANY_DATE;?></option>
			<option value="1" <?php if(isset($_REQUEST["posting_date"])&&$_REQUEST["posting_date"]=="1") echo "selected";?>><?php echo $M_TODAY;?></option>
			<option value="2" <?php if(isset($_REQUEST["posting_date"])&&$_REQUEST["posting_date"]=="2") echo "selected";?>><?php echo $M_YESTERDAY;?></option>
			<option value="3" <?php if(isset($_REQUEST["posting_date"])&&$_REQUEST["posting_date"]=="3") echo "selected";?>><?php echo $M_LAST_3;?></option>
			<option value="7" <?php if(isset($_REQUEST["posting_date"])&&$_REQUEST["posting_date"]=="7") echo "selected";?>><?php echo $M_LAST_7;?></option>
			<option value="30" <?php if(isset($_REQUEST["posting_date"])&&$_REQUEST["posting_date"]=="30") echo "selected";?>><?php echo $M_LAST_30;?></option>
		</select>
	<div class="clearfix"></div>
	<br/>
</div>
<br/>


<?php

if(isset($this->filters["categories"])&&sizeof($this->filters["categories"])>0)
{
	if(isset($_GET["category"])&&$_GET["category"]!="")
	{
		
	}
	else
	{
		asort($this->filters["categories"]);

	?>	
		<div class="gray-wrap">

			<h4 class="aside-header">
				<?php echo $M_CATEGORY;?>
			</h4>
			
			<hr class="top-bottom-margin"/>
			
			<?php
			foreach($this->filters["categories"] as $key=>$value)
			{
				$category_name=$this->show_category($key);
				if(trim($category_name)=="") continue;
			?>
				<h5><a href="index.php?<?php echo $strSearchString;?>category=<?php echo $key;?>" class="aside-link">
					<?php echo $category_name;?> (<?php echo $value;?>)
				</a></h5>
			<?php
			}
			?>
			<div class="clearfix"></div>
			<br/>
		</div>
		<br/>
<?php
	}
}


if(isset($this->filters["locations"])&&sizeof($this->filters["locations"])>0)
{
	if(isset($_GET["location"])&&$_GET["location"]!="")
	{
		
	}
	else
	{

		asort($this->filters["locations"]);

	?>	
		<div class="gray-wrap">

			<h4 class="aside-header">
				<?php echo $LOCATION;?>
			</h4>
			
			<hr class="top-bottom-margin"/>
			
			<?php
			foreach($this->filters["locations"] as $key=>$value)
			{
				$location_name=$this->show_location($key);
				if(trim($location_name)=="") continue;
			?>
				<h5><a href="index.php?<?php echo $strSearchString;?>location=<?php echo $key;?>" class="aside-link">
					<?php echo $location_name;?> (<?php echo $value;?>)
				</a></h5>
			<?php
			}
			?>
			<div class="clearfix"></div>
			<br/>
		</div>
		<br/>
<?php
	}
}

?>

<div class="gray-wrap">

	<h4 class="aside-header">
		<?php echo $M_SALARY_RANGE;?>
	</h4>
	
	<hr class="top-bottom-margin"/>
	
		<div class="row">
			<div class="col-md-4" style="padding-right:0px">
				<?php echo $M_FROM;?> 
				<br/>
				
				<select name="salary_from" class="form-control" onchange="FilterResults('salary_from',this.options[this.selectedIndex].value)">
					<option value=""><?php echo $M_ANY;?></option>
					<?php
					
					$salary_items=explode("|",$this->GetParam("SALARY_RANGE"));
					foreach($salary_items as $salary_item)
					{
						echo '<option value="'.$salary_item.'" '.(isset($_REQUEST["salary_from"])&&$_REQUEST["salary_from"]==$salary_item?"selected":"").'>'.$this->GetParam("CURRENCY").number_format($salary_item,0,$this->GetParam("DEC_POINT"),$this->GetParam("THOUSANDS_SEP")).'</option>';
					}
					?>
				</select>
					
			</div>
			<div class="col-md-4" style="padding-right:0px">
				<?php echo $M_TO;?> 
				<br/>
				
				<select name="salary_to" class="form-control" onchange="FilterResults('salary_to',this.options[this.selectedIndex].value)">
					<option value=""><?php echo $M_ANY;?></option>
					<?php
					
					foreach($salary_items as $salary_item)
					{
						echo '<option value="'.$salary_item.'" '.(isset($_REQUEST["salary_to"])&&$_REQUEST["salary_to"]==$salary_item?"selected":"").'>'.$this->GetParam("CURRENCY").number_format($salary_item,0,$this->GetParam("DEC_POINT"),$this->GetParam("THOUSANDS_SEP")).'</option>';
					}
					?>
				</select>
			</div>
	
			<div class="col-md-4">
				<?php echo $M_PER;?>
				
				<br/>
			
				<select name="salary_type" class="form-control" >
					<option value="3" selected><?php echo $M_MONTH;?></option>
					<option value="4"><?php echo $M_YEAR;?></option>

				</select> 
			</div>
		</div>
			

				
				
	<div class="clearfix"></div>
	<br/>
</div>
<br/>
<?php
}
?>

<?php


if
(
	(isset($_REQUEST["page"])&&($_REQUEST["page"]=="en_Courses"||$_REQUEST["page"]=="es_Cursos"))
	||
	(isset($_REQUEST["mod"])&&$_REQUEST["mod"]=="courses")
	||
	(isset($_REQUEST["mod"])&&$_REQUEST["mod"]=="course_details")
)
{
//featured courses
$SearchTable = $this->db->Query
	("
		SELECT 
		".$DBprefix."courses.id,
		".$DBprefix."courses.title,
		
		".$DBprefix."courses.message,
		".$DBprefix."employers.company,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."courses,".$DBprefix."employers  
		WHERE 
		".$DBprefix."courses.employer =  ".$DBprefix."employers.username
		AND ".$DBprefix."courses.active='YES'
		AND status=1
		AND expires>".time()." 
		
		".((isset($_REQUEST["mod"])&&$_REQUEST["mod"]=="courses")?" AND featured=1 ":"")."
		".((isset($_REQUEST["mod"])&&$_REQUEST["mod"]=="course_details"&&isset($_REQUEST["id"]))?" AND ".$DBprefix."courses.id=<>".$_REQUEST["id"]:"")."
		 
		ORDER BY ".$DBprefix."courses.id DESC
		LIMIT 0,".$this->GetParam("NUMBER_OF_FEATURED_LISTINGS")."
	");

	if($this->db->num_rows($SearchTable)>0)
	{
	?>
	<br/>
	<br/>
	<div class="gray-wrap">

		<h4 class="aside-header">
		
			<?php 
			if(isset($_REQUEST["mod"])&&$_REQUEST["mod"]=="courses")
			{
				echo $M_LATEST_COURSES;
			}
			else
			{
				echo $M_FEATURED_COURSES;
			}
			?>
			
			
		</h4>
		<hr class="top-bottom-margin"/>
	<?php
		while($listing = $this->db->fetch_array($SearchTable))
		{	

			$headline = stripslashes($listing["title"]);

			$strLink = $this->course_link($listing["id"],$listing["title"]);
					
		?>

			<?php
			if($listing["logo"]!="")
			{
				
				if(file_exists("thumbnails/".$listing["logo"].".jpg"))
				{
					echo "<a href=\"".$strLink."\"><img align=\"left\" src=\"thumbnails/".$listing["logo"].".jpg\" width=\"50\" alt=\"".stripslashes(strip_tags($listing["company"]))."\" class=\"img-shadow img-right-margin\"/></a>";
				}
			}
			?>
			
			<h5 class="no-margin"><a href="<?php echo $strLink;?>" class="aside-link">
				<?php echo stripslashes(strip_tags($headline));?>
			</a></h5>
			<span class="sub-text">
			<?php echo $this->text_words(stripslashes(strip_tags($listing["message"])),10);?>
			</span>
			
			<hr class="top-bottom-margin"/>
			
			
		<?php
		}
		?>
		
		<br/>
		</div>
		<?php
	}

//end featured courses
}
else
{
	if(!isset($_REQUEST["mod"])&&(!isset($_REQUEST["page"])||$this->is_default_page))
	{

	}
	else
	{
		$is_featured=true;
	}

	$SearchTable = $this->db->Query
	("
		SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.title,
		".$DBprefix."jobs.message,
		".$DBprefix."employers.company,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."jobs,".$DBprefix."employers  
		WHERE 
		".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
		AND ".$DBprefix."jobs.active='YES'
		AND status=1
		AND expires>".time()." 
		".(isset($is_featured)?"AND featured=1 ":"")."
		ORDER BY 
		".(isset($is_featured)?"RAND()":$DBprefix."jobs.date DESC")."
		 
		LIMIT 0,".$this->GetParam("NUMBER_OF_FEATURED_LISTINGS")."
	");

	if($this->db->num_rows($SearchTable)>0)
	{
		if(isset($is_featured)) echo "<br/><br/>";
	?>
		
	<div class="gray-wrap">

		<h4 class="aside-header">
		<?php
		if(isset($is_featured))
		{
		?>
			<?php echo $FEATURED_JOBS;?>
		<?php
		}
		else
		{
		
		?>
			<?php echo $M_LATEST_JOBS;?>
			
		<?php
		}
		?>
		</h4>
			<hr class="top-bottom-margin"/>
	<?php
		while($listing = $this->db->fetch_array($SearchTable))
		{	

			$headline = stripslashes($listing["title"]);

			$strLink = $this->job_link($listing["id"],$listing["title"]);
					
		?>

			<?php
			if($listing["logo"]!="")
			{
				
				if(file_exists("thumbnails/".$listing["logo"].".jpg"))
				{
					echo "<a href=\"".$strLink."\"><img align=\"left\" src=\"thumbnails/".$listing["logo"].".jpg\" width=\"80\" alt=\"".stripslashes(strip_tags($listing["company"]))."\" class=\"img-shadow img-right-margin\"/></a>";
				}
			}
			?>
			
			<h5 class="no-margin"><a href="<?php echo $strLink;?>" class="aside-link">
				<?php echo stripslashes(strip_tags($headline));?>
			</a></h5>
			<span class="sub-text">
			<?php 
			$job_text = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/is', "$1$3", stripslashes($listing["message"]));
			echo $this->text_words(strip_tags($job_text),10);
			?>
			</span>
			<div class="clearfix"></div>
			<hr class="top-bottom-margin"/>
			
		<?php
		}
		?>
		
		<div class="text-center"><a class="underline-link" href="<?php echo $this->mod_link((isset($is_featured)?"featured":"latest")."-jobs");?>"><?php echo $M_SEE_ALL;?></a></div>
		<br/>
		</div>
		<?php
	}
}
?>
