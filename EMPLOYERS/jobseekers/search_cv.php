<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

if($database->SQLCount("jobseekers","WHERE id=".$id." AND profile_public=1") < 1)
{
	die("");
}

$show_cv = true;

if($website->GetParam("CHARGE_TYPE") == 3&&!isset($_REQUEST["rsm"]))
{
	$show_cv = false;
?>
	<h4>Please click on the icon below to purchase this resume</h4>
	
	<?php
			if(trim($website->GetParam("PAYPAL_ID"))!="")
			{
			?>
				<br/><br/>				
				<form id="paypal_form" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>">
				<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE");?>">
				<input type="hidden" name="item_name" value="<?php echo "Payment for CV #".$id." on ".$DOMAIN_NAME;?> ">
				<input type="hidden" name="item_number" value="<?php echo $id;?>">
				<input type="hidden" name="amount" value="<?php echo number_format($website->params[712], 2, '.', '');?>">
				<input type="hidden" name="cancel_return" value="<?php echo "http://".$DOMAIN_NAME."/EMPLOYERS/index.php?category=jobseekers&action=search";?>">
				
				<input type="hidden" name="return" value="<?php echo "http://".$DOMAIN_NAME."/EMPLOYERS/index.php?category=jobseekers&folder=search&page=cv&rsm=".md5($DOMAIN_NAME.$id)."&id=".$id;?>">
				<input type="image"  src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
				</form>
				<script>
				document.getElementById("paypal_form").submit();
				</script>
				<br><br><br>
			<?php
			}
			?>
	
<?php
}
else

if($website->GetParam("CHARGE_TYPE") == 1&&$arrUser["subscription"]==0)
{
	$show_cv = false;
?>
	<br><br>
	<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_NEED_SUBSCRIPTION_RESUMES;?></a>
<?php
}
else	
if($website->GetParam("CHARGE_TYPE") == 2&&aParameter(704)>$arrUser["credits"])
{
	$show_cv = false;
?>
	<br><br>
	<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_NOT_ENOUGH_CREDITS_TO_VIEW_RESUME;?></a>
<?php
}
else
{

	if($website->GetParam("CHARGE_TYPE") == 2)
	{
		$database->SQLUpdate_SingleValue
		(
			"employers",
			"username",
			"'".$AuthUserName."'",
			"credits",
			$arrUser["credits"]-aParameter(704)
		);	
	}
	
	if($website->GetParam("CHARGE_TYPE") == 3&&!isset($_REQUEST["rsm"]))
	{
		if($_REQUEST["rsm"]!=md5($DOMAIN_NAME.$id)) die("Access denied");
	}
				$arrSeeker = $database->DataArray("jobseekers","id=".$id);
				
				$database->SQLInsert
				(
					"jobseekers_stat",
					array("date","jobseeker","ip","employer"),
					array(time(),$arrSeeker["username"],$_SERVER["REMOTE_ADDR"],$AuthUserName)
				);
				
				$arrResume = $database->DataArray("jobseeker_resumes","username='".$arrSeeker["username"]."'");
						
}

if($show_cv)		
{	
	$arrSeeker = $arrJobseeker = $database->DataArray("jobseekers","id=".$id);
	$arrResume = $database->DataArray("jobseeker_resumes","username='".$arrSeeker["username"]."'");
	
?>
	
	
	
<div class="fright">
	<?php
	
	
	echo LinkTile
		 (
			"",
			"",
			$M_SAVE_RESUME_AS_PDF,
			"",
			
			"green",
			"small",
			"true",
			"SubmitForm"
		 );
		 
		echo LinkTile
		 (
			"jobseekers",
			"list_message-id=".$id,
			$SEND_MESSAGE,
			"",
			
			"yellow",
			"small"
		 );
		 
		 
	echo LinkTile
	 (
		"jobseekers",
		"search",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>
<div class="clear"></div>
<br/>
	<form id="html_form" action="pdf/resume.php" method="post">
		<input id="html_field" type="hidden" name="html" value="">
	</form>
	
	<h3>
		<?php echo $CV_OF;?> <?php echo $arrSeeker["first_name"];?> <?php echo $arrSeeker["last_name"];?>
	</h3>
		
		<script>
		
		function SubmitForm()
		{
			
			document.getElementById("html_field").value=document.getElementById("resume_content").innerHTML;	
			document.getElementById("html_form").submit();
		}
		
		</script>
		
	
<div class="clear"></div><br/>
		
		<?php 
		
		if($arrSeeker["video_id"]>2)
		{
		?>
		<br>
		<a href="index.php?category=jobseekers&folder=search&page=play&video_id=<?php echo $arrSeeker["video_id"];?>"><b><?php echo $M_JOBSEEKER_UPLOADED_VIDEO_RESUME;?></b></a>&nbsp;&nbsp;
		<?php
		}
		?>
		
		
		
		<div id="resume_content">
		

			<span style="font-size:14px;font-weight:400">
				<i><b><?php echo $M_PERSONAL_INFORMATION;?></b></i>
			</span>
			
			<br><br>
					
					
		<?php
$MessageTDLength = 140;

$_REQUEST["HideSubmit"] = true;

	AddEditForm
	(
	array(
	
	" <i>".$FIRST_NAME.":</i>",
	" <i>".$LAST_NAME.":</i>",
	" <i>".$M_ADDRESS.":</i>",
	" <i>".$TELEPHONE.":</i>",
	" <i>".$M_MOBILE.":</i>",
	" <i>".$M_EMAIL.":</i>",
	" <i>".$M_DOB.":</i>",
	
	" <i>".$M_PICTURE.":</i>"),
	array("first_name","last_name","address","phone",
	"mobile","username","dob","logo"),
	array("profile_public","title","first_name","last_name","address","phone",
	"mobile","username","dob","logo"),
	array("textbox_30","textbox_30","textarea_50_4","textbox_30",
	"textbox_30","textbox_30","textbox_30","textbox_30"),
	"jobseekers",
	"id",
	$id,
	""
	);

?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		
<?php	
if($arrJobseeker["experience"]!=0)
{
?>
	<tr height="32">
		<td >
			<i><?php echo $M_EXPERIENCE;?>:</i>
		</td>
		<td><b><?php echo $website->show_value("arrExperienceLevels",$arrJobseeker["experience"]);?></b></td>
	</tr>
<?php
}

if($arrJobseeker["availability"]!=0)
{
?>
	<tr height="32">
		<td width="<?php echo $MessageTDLength;?>">
			<i><?php echo $M_AVAILABILITY;?>:</i>
		</td>
		<td><b><?php echo $website->show_value("arrAvailabilityTypes",$arrJobseeker["availability"]);?></b></td>
	</tr>
<?php
}

if($arrJobseeker["job_type"]!=0)
{
	
?>
	<tr height="32">
		<td width="<?php echo $MessageTDLength;?>">
			<i><?php echo $M_JOB_TYPE;?>:</i>
		</td>
		<td><b><?php echo $website->show_value("arrJobTypes",$arrJobseeker["job_type"]);?></b></td>
	</tr>
<?php
}


if(trim($arrJobseeker["jobseeker_fields"]) != "")
{

$arrJobseekerFields = array();

if(is_array(unserialize($arrJobseeker["jobseeker_fields"])))
{
	$arrJobseekerFields = unserialize($arrJobseeker["jobseeker_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrJobseekerFields)) 
{

?>
	<tr height="32">
		<td width="<?php echo $MessageTDLength;?>"><i><?php str_show($key);?>:</i></td>
		<td><b><?php str_show($val);?></b></td>
		</tr>
<?php

}
}

?>
</td>
	</tr>
</table>
						
	<br><br><br>
	<span style="font-size:14px;font-weight:400">
		<i><b><?php echo $M_WORK_HISTORY;?></b></i>
	</span>
	
	<?php
	if(trim($arrResume["employer_name_1"])!="")
	{
	?>
	<br><br>
	
	<?php echo $M_NAME_RECENT_EMPLOYER;?>:
	
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_name_1"];?></b>
	<br><br>
	
	<?php echo $M_EMPLOYER_ADDRESS;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_address_1"];?></b>
	<br><br>
	
	<?php echo $M_DATES_STARTED_ENDED;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_1_dates"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JOB_TITLE;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_1_title"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JUB_DUTIES;?>:
	<br><br style="line-height:2px">
	
	<b><?php echo $arrResume["job_1_duties"];?></b>
	
	
	<?php
	}
	?>
	
	
	<?php
	if(trim($arrResume["employer_name_2"])!="")
	{
	?>
	
	<br><br>



	<br><br>
	
	<?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:
	
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_name_2"];?></b>
	<br><br>
	
	<?php echo $M_EMPLOYER_ADDRESS;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_address_2"];?></b>
	<br><br>
	
	<?php echo $M_DATES_STARTED;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_2_dates"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JOB_TITLE;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_2_title"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JUB_DUTIES;?>:
	<br><br style="line-height:2px">
	
	<b><?php echo $arrResume["job_2_duties"];?></b>
	
	<?php
	}
	?>
	
	
	<?php
	if(trim($arrResume["employer_name_3"])!="")
	{
	?>
	<br><br>
	
	
	
	<br><br>
	
	<?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:
	
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_name_3"];?></b>
	<br><br>
	
	<?php echo $M_EMPLOYER_ADDRESS;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_address_3"];?></b>
	<br><br>
	
	<?php echo $M_DATES_STARTED;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_3_dates"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JOB_TITLE;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_3_title"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JUB_DUTIES;?>:
	<br><br style="line-height:2px">
	
	<b><?php echo $arrResume["job_3_duties"];?></b>
	
	<?php
	}
	?>
	
	
	<?php
	if(trim($arrResume["employer_name_4"])!="")
	{
	?>
	<br><br>
	
	
	<br><br>
	
	<?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:
	
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_name_4"];?></b>
	<br><br>
	
	<?php echo $M_EMPLOYER_ADDRESS;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["employer_address_4"];?></b>
	<br><br>
	
	<?php echo $M_DATES_STARTED;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_4_dates"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JOB_TITLE;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["job_4_title"];?></b>
	<br><br>
	
	<?php echo $M_YOUR_JUB_DUTIES;?>:
	<br><br style="line-height:2px">
	
	<b><?php echo $arrResume["job_4_duties"];?></b>
	
	<?php
	}
	?>
	
	
	<br><br>

	
	<span style="font-size:14px;font-weight:400">
		<i><b><?php echo $M_SKILLS;?></b></i>
	</span>
	
	<br><br>
	<?php
	if(trim($arrResume["skills"]) != "")
	{
	?>
	<?php echo $M_YOUR_SKILLS;?>:
	<br><br style="line-height:2px">
	<b><?php echo $arrResume["skills"];?></b>
	
	<br><br>
	<?php
	}
	?>
	
	
	<?php echo $M_NATIVE_LANGUAGE;?>:
	
	<b>
	<?php
	foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
	{
		if($key==$arrResume["native_language"])
		{
			echo $value;
		}
	}
	?>
	</b>
	
	<br/><br/>
	<?php

						
	for($i=1;$i<=3;$i++)
	{
	
		if($arrResume["language_".$i]!=-1)
		{
		?>
			<?php echo $M_FOREIGN_LANGUAGE;?> <?php echo $i;?>:
			<b>
				<?php
				foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
				{
					if($key==$arrResume["language_".$i])
					{
						echo $value;
					}
				}
				?>
			</b>, <?php echo $M_PROFICIENCY;?>:
			<b>
			<?php
				foreach($website->GetParam("arrProficiencies") as $key=>$value)
				{
					if($key==$arrResume["language_".$i."_level"])
					{
						echo $value;
					}
				}
				?>
			</b>	
			
	  
	  <br>
	  
	  <?php
	  }
  }
  ?>
					
		<br/><br/>
		
		<span style="font-size:14px;font-weight:400">
			<i><b><?php echo $M_EDUCATION;?></b></i>
		</span>
		
		<br/><br/>
		
		<?php echo $M_EDUCATION_LEVEL;?>:
		<?php
		if($arrResume["education_level"]!=""&&$arrResume["education_level"]!="0")
		{
		?>
			<b>
			<?php
			foreach($website->GetParam("arrEducationLevels") as $key=>$value)
			{
				if($key==$arrResume["education_level"])
				{
					echo $value;
				}
			}
			?>
			</b>
		<?php
		}
		?>
		<?php
		if(trim($arrResume["school_1_name"])!="")
		{
		?>
		<br><br><br>
		
		
		<?php echo $M_NAME_LAST_SCHOOL;?>:
		
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_1_name"];?></b>
		<br><br>
		
		<?php echo $M_COURSES_STUDIED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_1_courses"];?></b>
		<br><br>
		
		<?php echo $M_DATES_ATTENDED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_1_dates"];?></b>
		<br><br>
		
		<?php echo $M_DEGREE_EARNED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_1_degree"];?></b>
	
		<?php
		}
		?>
	
	
	<?php
		if(trim($arrResume["school_2_name"])!="")
		{
		?>
		<br><br><br><br>
		
		<?php echo $M_NAME_PREVIOUS_SCHOOL;?>:
		
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_2_name"];?></b>
		<br><br>
		
		<?php echo $M_COURSES_STUDIED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_2_courses"];?></b>
		<br><br>
		
		<?php echo $M_DATES_ATTENDED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_2_dates"];?></b>
		<br><br>
		
		<?php echo $M_DEGREE_EARNED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_2_degree"];?></b>
	
		<?php
		}
		?>
	
		<?php
		if(trim($arrResume["school_3_name"])!="")
		{
		?>
		<br><br><br><br>
		
		
		<?php echo $M_NAME_PREVIOUS_SCHOOL;?>:
		
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_3_name"];?></b>
		<br><br>
		
		<?php echo $M_COURSES_STUDIED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_3_courses"];?></b>
		<br><br>
		
		<?php echo $M_DATES_ATTENDED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_3_dates"];?></b>
		<br><br>
		
		<?php echo $M_DEGREE_EARNED;?>:
		<br><br style="line-height:2px">
		<b><?php echo $arrResume["school_3_degree"];?></b>
	
	
		<?php
		}
		?>
		
	<br>
		
<br><br>
<?php 

echo $arrSeeker["cv"];

?>
<br>
<br>


		<span style="font-size:14px;font-weight:400">
			<i><b><?php echo $M_JOB_PREFERENCES;?></b></i>
		</span>
						
		<br><br>


<table border="0" cellPadding="0" cellSpacing="0">
  <tbody>
	<?php
	if($arrJobseeker["expected_salary"]!="0"&&$arrJobseeker["expected_salary"]!="")
	{
		?>
		<tr>
			<td colspan="4">
				<?php echo $M_EXPECTED_SALARY;?>:
				<br/>
			
				<b><?php echo $arrJobseeker["expected_salary"];?></b>
				<br/><br/>
			</td>
		</tr>
		
		<?php
		
	}
	?>
    <tr>

      <td vAlign=top colSpan=4 class=basictext><?php echo $M_JOB_CATEGORIES;?>:</TD>
    </tr>
    <tr>
      <td colSpan=4>
       <b>
	   <?php
	  
	  	$arrSelectedCategories = array(); 
		$arrSelectedLocations = array(); 
		$strLevelExperience = $arrJobseeker["level_experience"]; 
		
		if($arrJobseeker["industry_sector"] != "")
		{
			$arrSelectedCategories = unserialize($arrJobseeker["industry_sector"]); 
		}
		
		$b_first=true;
		
		if(is_array($arrSelectedCategories))
		{
			foreach($arrSelectedCategories as $str_category)
			{
				if(!$b_first) echo "<br/>";
				echo $website->show_category($str_category);
				$b_first=false;
			}
		}
			
		?>
	   
	   </b>
	   
      </TD>
    </TR>

    <TR>
      <TD vAlign=top colSpan=4 height=27><br>
        <?php echo $M_PREFERRED_LOCATIONS;?>:</TD>
    </TR>
    <TR>
      <TD colSpan=4>
 
  <b>
  <?php
  
	if($arrJobseeker["preferred_locations"] != "")
	{
		$arrSelectedLocations = unserialize($arrJobseeker["preferred_locations"]); 
	}
	

  	if(is_array($arrSelectedLocations))
	{
		$b_first = true;
		foreach($arrSelectedLocations as $loc_id)
		{
			if(!$b_first) echo "<br/>";
			
			echo $website->show_full_location($loc_id);
			$b_first = false;
		}		
	}			
				 
		?>
  
  	</b>
  
  
      </TD>
    </TR>

    <TR>
      <TD valign="top" colspan="2" class="basictext"><br><?php echo $BRIEF_DESCRIPTION_PROFILE;?>:

<br><br>
<b>
       <?php echo $arrJobseeker["profile_description"];?>
		
</b>		
      </TD>
    </TR>
  </TBODY>
</TABLE>


</div>

<?php
if($database->SQLCount("files","WHERE user='".$arrSeeker["username"]."'  AND is_resume=0 ","file_id") == 0)
{

}
else
{
?>
<br><br>
	<span style="font-size:14px;font-weight:400">
		<i><b><?php echo $M_FILES_UPLOADED_JOBSEEKER;?>:</b></i>
	</span>
	<br><br>
						
<?php
	$JobseekerFiles=$database->DataTable("files","WHERE user='".$arrSeeker["username"]."' AND is_resume=0");
	
	while($js_file = $database->fetch_array($JobseekerFiles))
	{
		$file_show_link = "../file.php?id=".$js_file["file_id"];
		foreach($website->GetParam("ACCEPTED_FILE_TYPES") as $c_file_type)
		{	
			if(file_exists("../user_files/".$js_file["file_id"].".".$c_file_type[1]))
			{
				$file_show_link = "../user_files/".$js_file["file_id"].".".$c_file_type[1];
				break;
			}
		}
	?>
	
	<a target="_blank" href="<?php echo $file_show_link;?>"><b style="text-decoration:underline"><?php echo $js_file["file_name"];?></b></a>
	&nbsp;(<?php echo $js_file["description"];?>)
	<?php
	}
	

						
}
?>

<br><br>



<?php
if($arrJobseeker["video_id"]!="")
{
?><br>
	<span style="font-size:14px;font-weight:400">
		<i><b><?php echo $M_VIDEO_RESUME;?></b></i>
	</span>
	<br/><br/>
<?php
	if(is_numeric($arrUser["video_id"]))
	{
		$video_types = Array 
		(
			array("video/mp4","mp4"),
			array("video/webm","webm"),
			array("video/quicktime","mov"),
			array("video/ogg","ogg")
		);
		
		$video_file="";
		$video_file_type="";

		foreach($video_types as $c_file_type)
		{
			if(file_exists("../user_videos/".$arrUser["video_id"].".".$c_file_type[1]))
			{
				$video_file="../user_videos/".$arrUser["video_id"].".".$c_file_type[1];
				$video_file_type=$c_file_type[0];
			}
		}
		
		?>
		<video width="560" height="315" autoplay>
		  <source src="<?php echo $video_file;?>" type="<?php echo $video_file_type;?>">
		 
			Your browser does not support the video tag.
		</video>
		
		<?php
	}
	else
	{
		$video_id=$arrJobseeker["video_id"];
		$video_id=str_replace("http://www.youtube.com/watch?v=","",$video_id);
		$video_id=str_replace("https://www.youtube.com/watch?v=","",$video_id);
		$video_id=str_replace("http://youtu.be/","",$video_id);
		$video_id=str_replace("https://youtu.be/","",$video_id);
		?>
		<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen></iframe>
		
		<?php
	}
}
?>



<?php
}


?>
