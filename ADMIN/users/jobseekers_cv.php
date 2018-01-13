<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

$id=$_REQUEST["id"];
$website->ms_i($id);

$arrUser = $arrSeeker = $database->DataArray("jobseekers","id=".$id);

$arrResume = $database->DataArray("jobseeker_resumes","username='".$arrSeeker["username"]."'");

$jobseeker_user_name=$arrSeeker["username"];

?>
<style>
.select-checkbox
{
	position:relative;
	top:9px;
}
</style>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"users",
			"jobseekers",
			$M_GO_BACK,
			"",
			"red"
		 );
	
	?>

</div>
<div class="clear"></div>		
		<?php
		if(isset($_POST["ProceedSaveResume"]))
		{
			if($database->SQLCount("jobseeker_resumes","WHERE username='".$jobseeker_user_name."'") == 0)
			{
				$database->SQLInsert("jobseeker_resumes",array("username"),array($jobseeker_user_name));
			}

			$database->SQLUpdate
				(
					"jobseeker_resumes",
					
					array
					(
						 		 "employer_name_1",
								  "employer_address_1",
								  "job_1_dates",
								  "job_1_title",
								  "job_1_duties",
								  "employer_name_2",
								  "employer_address_2",
								  "job_2_dates",
								  "job_2_title",
								  "job_2_duties",
								  "employer_name_3",
								  "employer_address_3",
								  "job_3_dates",
								  "job_3_title",
								  "job_3_duties",
								  "employer_name_4",
								  "employer_address_4",
								  "job_4_dates",
								  "job_4_title",
								  "job_4_duties",
								  "skills",
								  "experience_level",
								  "education_level",
								  "native_language",
								  "language_1",
								  "language_1_level",
								  "language_2",
								  "language_2_level",
								  "language_3",
								  "language_3_level",
								  "school_1_name",
								  "school_1_courses",
								  "school_1_dates",
								  "school_1_degree",
								  "school_2_name",
								  "school_2_courses",
								  "school_2_dates",
								  "school_2_degree",
								  "school_3_name",
								  "school_3_courses",
								  "school_3_dates",
								  "school_3_degree"
					)
					,
					array
					(
						 		  get_param("employer_name_1"),
								  get_param("employer_address_1"),
								  get_param("job_1_dates"),
								  get_param("job_1_title"),
								  get_param("job_1_duties"),
								  get_param("employer_name_2"),
								  get_param("employer_address_2"),
								  get_param("job_2_dates"),
								  get_param("job_2_title"),
								  get_param("job_2_duties"),
								  get_param("employer_name_3"),
								  get_param("employer_address_3"),
								  get_param("job_3_dates"),
								  get_param("job_3_title"),
								  get_param("job_3_duties"),
								  get_param("employer_name_4"),
								  get_param("employer_address_4"),
								  get_param("job_4_dates"),
								  get_param("job_4_title"),
								  get_param("job_4_duties"),
								  get_param("skills"),
								  get_param("experience_level"),
								  get_param("education_level"),
								  get_param( "native_language"),
								  get_param("language_1"),
								  get_param("language_1_level"),
								  get_param("language_2"),
								  get_param("language_2_level"),
								  get_param("language_3"),
								  get_param("language_3_level"),
								  get_param("school_1_name"),
								  get_param("school_1_courses"),
								  get_param("school_1_dates"),
								  get_param("school_1_degree"),
								  get_param("school_2_name"),
								  get_param("school_2_courses"),
								  get_param("school_2_dates"),
								  get_param("school_2_degree"),
								  get_param("school_3_name"),
								  get_param("school_3_courses"),
								  get_param("school_3_dates"),
								  get_param("school_3_degree")
					)
					,
					
					"username='".$jobseeker_user_name."'"
				);
				
				
				$database->SQLUpdate
				(
					"jobseekers",
					array("industry_sector","preferred_locations","profile_description","expected_salary","experience","availability","job_type"),
					array( (isset($_POST["industry_sector"])?serialize($_POST["industry_sector"]):"") ,(isset($_POST["preferred_locations"])?serialize($_POST["preferred_locations"]):""),$_POST["profile_description"],preg_replace("/[^0-9]/","",$_POST["expected_salary"]),$_POST["experience"],$_POST["availability"],$_POST["job_type"]),
					"username='".$jobseeker_user_name."'"
				);
				
				$arrUser = $arrSeeker = $database->DataArray("jobseekers","id=".$id);

				$arrResume = $database->DataArray("jobseeker_resumes","username='".$arrSeeker["username"]."'");

		}
		
		?>
		
						<br>
						
						<form action="index.php" method="post">
						<input type="hidden" name="ProceedSaveResume" value="1">
						<input type="hidden" name="folder" value="<?php echo $_REQUEST["folder"];?>">
						<input type="hidden" name="page" value="<?php echo $_REQUEST["page"];?>">
						<input type="hidden" name="category" value="<?php echo $category;?>">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					
						
					<br>
						<span style="font-size:14px;font-weight:400">
							<h3><?php echo $M_WORK_HISTORY;?></h3>
						</span>
						
						<font size=2><i><?php echo $M_WORK_HISTORY_EXPL;?> </i></font>
						
						<br><br>
						
						<strong><?php echo $M_NAME_RECENT_EMPLOYER;?></strong>
						
						<br>
						<input type="text" value="<?php echo $arrResume["employer_name_1"];?>" name="employer_name_1" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_EMPLOYER_ADDRESS;?></strong>
						<br>
						<textarea name="employer_address_1" style="height:60px;width:350px"><?php echo $arrResume["employer_address_1"];?></textarea>
						
						<br><br>
						
						<strong><?php echo $M_DATES_STARTED_ENDED;?></strong>
						<br>
						<input type="text" name="job_1_dates" value="<?php echo $arrResume["job_1_dates"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JOB_TITLE;?></strong>
						<br>
						<input type="text" name="job_1_title" value="<?php echo $arrResume["job_1_title"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JUB_DUTIES;?></strong>
						<br>
						
						<textarea name="job_1_duties" style="height:60px;width:350px"><?php echo $arrResume["job_1_duties"];?></textarea>
						
						<br><br>
				


						<br><br>
						
						<strong><?php echo $M_NAME_PREVIOUS_EMPLOYER;?></strong>
						
						<br>
						<input type="text" name="employer_name_2" value="<?php echo $arrResume["employer_name_2"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_EMPLOYER_ADDRESS;?></strong>
						<br>
						<textarea name="employer_address_2" style="height:60px;width:350px"><?php echo $arrResume["employer_address_2"];?></textarea>
						
						
						<br><br>
						
						<strong><?php echo $M_DATES_STARTED;?> </strong>
						<br>
						<input type="text" name="job_2_dates" value="<?php echo $arrResume["job_2_dates"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JOB_TITLE;?></strong>
						<br>
						<input type="text" name="job_2_title" value="<?php echo $arrResume["job_2_title"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JUB_DUTIES;?></strong>
						<br>
						
						<textarea name="job_2_duties" style="height:60px;width:350px"><?php echo $arrResume["job_2_duties"];?></textarea>
						
						<br><br>
						
						
						
						<br><br>
						
						<strong><?php echo $M_NAME_PREVIOUS_EMPLOYER;?></strong>
						
						<br>
						<input type="text" name="employer_name_3" value="<?php echo $arrResume["employer_name_3"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_EMPLOYER_ADDRESS;?></strong>
						<br>
						<textarea name="employer_address_3" style="height:60px;width:350px"><?php echo $arrResume["employer_address_3"];?></textarea>
						<br><br>
						
						<strong><?php echo $M_DATES_STARTED;?></strong>
						<br>
						<input type="text" name="job_3_dates" value="<?php echo $arrResume["job_3_dates"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JOB_TITLE;?></strong>
						<br>
						<input type="text" name="job_3_title" value="<?php echo $arrResume["job_3_title"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JUB_DUTIES;?></strong>
						<br>
						
						<textarea name="job_3_duties" style="height:60px;width:350px"><?php echo $arrResume["job_3_duties"];?></textarea>
						
						<br><br>
						
						
						<br><br>
						
						<strong><?php echo $M_NAME_PREVIOUS_EMPLOYER;?></strong>
						
						<br>
						<input type="text" name="employer_name_4" value="<?php echo $arrResume["employer_name_4"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_EMPLOYER_ADDRESS;?></strong>
						<br>
						<textarea name="employer_address_4" style="height:60px;width:350px"><?php echo $arrResume["employer_address_4"];?></textarea>
						<br><br>
						
						<strong><?php echo $M_DATES_STARTED;?></strong>
						<br>
						<input type="text" name="job_4_dates" value="<?php echo $arrResume["job_4_dates"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JOB_TITLE;?></strong>
						<br>
						<input type="text" name="job_4_title" value="<?php echo $arrResume["job_4_title"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_YOUR_JUB_DUTIES;?></strong>
						<br>
						
						<textarea name="job_4_duties" style="height:60px;width:350px"><?php echo $arrResume["job_4_duties"];?></textarea>
						
						
						
						<br><br>
						
						<span style="font-size:14px;font-weight:400">
							<h3><?php echo $M_SKILLS;?></h3>
						</span>
						
						<br>
						
						<strong><?php echo $M_YOUR_SKILLS;?></strong>
						<br>
						<textarea name="skills" style="height:150px;width:350px"><?php echo $arrResume["skills"];?></textarea>
						
						<br><br>
						<strong><?php echo $M_NATIVE_LANGUAGE;?></strong>
						<br>
						<select name="native_language">
						<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
						<?php
						foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
						{
							echo "<option value=\"".$key."\" ".($key==$arrResume["native_language"]?"selected":"").">".$value."</option>";
						}
						?>
						</select>
						
						<br><br>
						
						
						<?php
						for($i=1;$i<=3;$i++)
						{
						?>
						
						<table summary="" border="0">
				      	<tr>
				      		<td>
							
								<strong><?php echo $M_FOREIGN_LANGUAGE;?> <?php echo $i;?></strong>
							
							
							</td>
							<td> &nbsp; </td>
				      		<td>
							
										<strong><?php echo $M_PROFICIENCY;?></strong>
							
							</td>
				      	</tr>
				      	<tr>
				      		<td>
									<select name="language_<?php echo $i;?>">
										<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
										<?php
										foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
										{
											echo "<option value=\"".$key."\" ".($key==$arrResume["language_".$i]?"selected":"").">".$value."</option>";
										}
										?>
										</select>
									
							
							</td>
							<td> &nbsp; </td>
				      		<td>
							
										<select name="language_<?php echo $i;?>_level">
										<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
										<?php
										foreach($website->GetParam("arrProficiencies") as $key=>$value)
										{
											echo "<option value=\"".$key."\" ".($key==$arrResume["language_".$i."_level"]?"selected":"").">".$value."</option>";
										}
										?>
										</select>
							
							
							</td>
				      	</tr>
				      </table>
					  
					  <br>
					  
					  <?php
					  }
					  ?>
						
						
						
						
						
						
						
						<span style="font-size:14px;font-weight:400">
							<h3><?php echo $M_EDUCATION;?></h3>
						</span>
						<br>
						
						<font size=1><i>
						<?php echo $M_EDUCATION_EXPL;?>
						</i></font>
						
						<br><br><br>
						
						<strong><?php echo $M_EDUCATION_LEVEL;?> </strong>
						<br>
						<select name="education_level">
						<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
						<?php
						foreach($website->GetParam("arrEducationLevels") as $key=>$value)
						{
								echo "<option value=\"".$key."\" ".($key==$arrResume["education_level"]?"selected":"").">".$value."</option>";
						}
						?>
						</select>
						
						<br><br><br>
						
						
							<strong><?php echo $M_NAME_LAST_SCHOOL;?></strong>
						
						<br>
						<input type="text" name="school_1_name" value="<?php echo $arrResume["school_1_name"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_COURSES_STUDIED;?></strong>
						<br>
						<input type="text" name="school_1_courses" value="<?php echo $arrResume["school_1_courses"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_DATES_ATTENDED;?> </strong>
						<br>
						<input type="text" name="school_1_dates" value="<?php echo $arrResume["school_1_dates"];?>" style="width:350px">
						<br>
						<font size=1><i><?php echo $M_CURRENT_EDUCATION_EXPL;?></i></font>
						<br><br>
						
						<strong><?php echo $M_DEGREE_EARNED;?></strong>
						<br>
						<input type="text" name="school_1_degree" value="<?php echo $arrResume["school_1_degree"];?>" style="width:350px">
					
						<br><br><br><br>
						
						
						
							<strong><?php echo $M_NAME_PREVIOUS_SCHOOL;?></strong>
						
						<br>
						<input type="text" name="school_2_name" value="<?php echo $arrResume["school_2_name"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_COURSES_STUDIED;?></strong>
						<br>
						<input type="text" name="school_2_courses" value="<?php echo $arrResume["school_2_courses"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_DATES_ATTENDED;?> </strong>
						<br>
						<input type="text" name="school_2_dates" value="<?php echo $arrResume["school_2_dates"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_DEGREE_EARNED;?></strong>
						<br>
						<input type="text" name="school_2_degree" value="<?php echo $arrResume["school_2_degree"];?>" style="width:350px">
					
						<br><br><br><br>
						
						
						
							<strong><?php echo $M_NAME_PREVIOUS_SCHOOL;?></strong>
						
						<br>
						<input type="text" name="school_3_name" value="<?php echo $arrResume["school_3_name"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_COURSES_STUDIED;?></strong>
						<br>
						<input type="text" name="school_3_courses" value="<?php echo $arrResume["school_3_courses"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_DATES_ATTENDED;?> </strong>
						<br>
						<input type="text" name="school_3_dates" value="<?php echo $arrResume["school_3_dates"];?>" style="width:350px">
						<br><br>
						
						<strong><?php echo $M_DEGREE_EARNED;?></strong>
						<br>
						<input type="text" name="school_3_degree" value="<?php echo $arrResume["school_3_degree"];?>" style="width:350px">
					
					<br>
					
					
					
					
					<br/>
<h3><?php echo $M_JOB_PREFERENCES;?></h3>
<i>
	<?php echo $M_PREFERRED_JOB_CATEGORIES;?>
</i><br/><br/><h4><?php echo $BRIEFLY_DESCRIBE;?>:</h4>


<textarea id="profile_description" name="profile_description" rows="5" cols="70"><?php echo stripslashes($arrUser["profile_description"]);?></textarea>

<br/>
<br/>

 <i><?php echo $M_EXPECTED_SALARY;?>:</i>
  <br>

	<input type="text" name="expected_salary" value="<?php if($arrUser["expected_salary"]!="0") echo $arrUser["expected_salary"];?>" style="width:300px"/>

   
	<br><br>
	
	
 <i><?php echo $M_JOB_TYPE;?>:</i>
  <br>

	<select name="job_type" style="width:300px">
	<?php 
	
		foreach($website->GetParam("arrJobTypes") as $key=>$value)
		{
			echo '<option '.($arrUser["job_type"]==$key?"selected":"").' value="'.$key.'">'.$value.'</option>';
		}
	?>
	</select>
   
	<br><br>

  
  <i><?php echo $M_EXPERIENCE;?>:</i>
  <br>

	<select name="experience" style="width:300px">
	<?php 
		foreach($website->GetParam("arrExperienceLevels") as $key=>$value)
		{
			echo '<option '.($arrUser["experience"]==$key?"selected":"").' value="'.$key.'">'.$value.'</option>';
		}
		
	?>
	</select>
   
	<br><br>
  
  <i><?php echo $M_AVAILABILITY;?>:</i>
  <br>

	<select name="availability" style="width:300px">
	<?php 
	
		foreach($website->GetParam("arrAvailabilityTypes") as $key=>$value)
		{
			echo '<option '.($arrUser["availability"]==$key?"selected":"").' value="'.$key.'">'.$value.'</option>';
		}
	?>
	</select>
   
	<br><br>



    
	
	<?php
	
	  	$arrSelectedCategories = array(); 
		$arrSelectedLocations = array(); 
		$strLevelExperience = $arrUser["level_experience"]; 
		
		if($arrUser["industry_sector"] != "")
		{
			$arrSelectedCategories = unserialize($arrUser["industry_sector"]); 
		}
	   
   
	   if($arrUser["preferred_locations"] != "" && is_array(unserialize($arrUser["preferred_locations"])))
		{
		
			$arrSelectedLocations = unserialize($arrUser["preferred_locations"]); 
		}
	
	?>
	
	<h4>
		<?php echo $M_PREFERRED_LOCATIONS;?>
	</h4>
	   
	 <div class="clear"></div>

  
  <?php
$iCounter = 0;	
include_once("../locations/locations_array.php");

foreach($loc as $key=>$value)
{
	if(!is_string($value)) continue;
	
	
	echo "<div class=\"col-md-2 col-sm-3\">\n";
	
	echo "\n <input class=\"select-checkbox\" type=\"checkbox\" ".(in_array(trim($key), $arrSelectedLocations)?"checked":"")." value=\"".trim($key)."\" name=\"preferred_locations[]\"> ".trim($value);
		
	echo "</div>\n";
	
	
	$iCounter ++;
}
	
?>
    
    <div class="clear"></div>
	 <br/>
	 
	  <h4><?php echo $M_JOB_CATEGORIES;?></h4>
	
	
	   <?php
	  

	   if(!is_array($arrSelectedCategories))
	   {
	   		$arrSelectedCategories=array();
	   }
	  
	   
	   $iCounter = 0;
	   
	   global $lines;
						

	if(file_exists('../categories/categories_'.strtolower($website->lang).'.php'))
	{
		$lines = file('../categories/categories_'.strtolower($website->lang).'.php');
	}
	else
	{
		$lines = file('../categories/categories_en.php');
	}
	
	$arrCategories = array();
	
	foreach ($lines as $line_num => $line) 
	{
		if(trim($line) != "")
		{
			$arrLine = explode(".",$line);
			if(sizeof($arrLine) == 2)
			{
				$arrCategories[trim($arrLine[0])] = trim($arrLine[1]);			
			}
		}
	}

	asort($arrCategories);
						
						
	while (list($key, $val) = each($arrCategories)) 
	{
	
		$arr_sub_cats = get_sub_cats($key,$lines);
		echo "<div class=\"col-md-2 col-sm-3\">";
		
		echo " 
		<h5>
		<input class=\"select-checkbox\" type=\"checkbox\" ".(in_array(trim($key), $arrSelectedCategories)?"checked":"")." value=\"".trim($key)."\" name=\"industry_sector[]\">
		".$val."</h5>";
			
		if(sizeof($arr_sub_cats)>0)
		
		{
			while (list($s_key, $s_val) = each($arr_sub_cats)) 
			{
				echo "
				<span class=\"left-margin-30px small-font\">
				<input class=\"select-checkbox\" type=\"checkbox\" ".(in_array(trim($s_key), $arrSelectedCategories)?"checked":"")." value=\"".trim($s_key)."\" name=\"industry_sector[]\">
				".$s_val."</span>";
				echo "<br>";
				
			}
			$iCounter ++;
		}
		
		echo "</div>";
		
		if($iCounter%6==0)
		{
			echo "<div class=\"clear\"></div>";
		}
	}
				
		?>
	   
	<div class="clear"></div>		
	<br/>
					
					
					
					
					
					
					
					
					
					
					
					<br>
						<table summary="" border="0" width="100%">
				      	<tr>
				      		<td align="left">
								<input type="submit" value=" <?php echo $SAUVEGARDER;?> " class="btn btn-primary">
							</td>
				      	</tr>
				      </table>
						
						</form>
		
		<?php
		
		?>