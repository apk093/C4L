<?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"jobs",
			"my",
			$MY_JOB_ADS,
			"",
			"blue"
		 );
	?>
</div>
<div class="clear"></div>
<?php
$arrFieldsToSkip = array("employer","date","places","featured","featured_expires","expires","contact_person","more_fields");

if(isset($_POST["Export"]))
{
	header("Location: jobs/export.php?fs=".implode("-",$_POST["exp_fields"]));
}


if(isset($_REQUEST["show"]) && $_REQUEST["show"] ==1)
{



	if(isset($_POST["proceed"]))
	{

		$importedCounter=0;

		$deletedCounter=0;
		$expiredCounter=0;

				
			foreach($_POST["import_ids"] as $import_id)
			{
			
					if(get_param("import".$import_id) == "0")
					{
					
					}
					else
					if(get_param("import".$import_id) == "1")
					{
							
							if($website->GetParam("CHARGE_TYPE") == 2)
							{
								if(($arrUser["credits"]-$website->GetParam("PRICE_LISTING_CREDITS"))<=0)
								{
									continue;
								} 
							}
							
							
							
							$insert_id=$database->Query
							(
								"
									INSERT INTO ".$DBprefix."jobs(date,employer,job_category,region,title,message,active,featured,expires,zip,job_type,featured_expires,salary,date_available)
									SELECT date,employer,job_category,region,title,message,active,featured,expires,zip,job_type,featured_expires,salary,date_available FROM ".$DBprefix."imported_ads
									WHERE id=".$import_id." 
									AND employer='".$AuthUserName."' 
								 "
							) ;
							
						
							
							$database->Query
								(
									"UPDATE ".$DBprefix."jobs
										SET 
											date=".(time()).",
											expires=".(time() + $website->GetParam("EXPIRE_DAYS")*86400)."
										WHERE id=".$insert_id."
								");
							
										
							$database->Query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." AND employer='".$AuthUserName."' ");	
						
							
							$database->SQLUpdate_SingleValue
							(
								"employers",
								"id",
								$AdminUser["id"],
								"credits",
								($AdminUser["credits"]-$website->GetParam("PRICE_LISTING_CREDITS"))
							);
			
							$importedCounter++;
							
					}
					else
					if(get_param("import".$import_id) == "2")
					{
							$database->Query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." AND employer='".$AuthUserName."' ");
							$deletedCounter++;
					}
					else
					if(get_param("import".$import_id) == "3")
					{
						
							$insert_id=$database->Query
							(
								"
									INSERT INTO ".$DBprefix."jobs(date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available)
									SELECT date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available FROM ".$DBprefix."imported_ads
									WHERE id=".$import_id." 
									AND employer='".$AuthUserName."' 
								 "
							) ;
						
							$database->Query
							(
								"UPDATE ".$DBprefix."jobs
									SET 
										date=".(time()-1).",
										expires=".(time()-1)."
									WHERE id=".$insert_id."
							") ;
										
							$database->Query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." AND employer='".$AuthUserName."' ");	
						
						
							$expiredCounter=0;
					}
					
						
			}


				
		echo "<table width=\"100%\"><tr><td>";

		if($importedCounter>0)
		{
			echo "<a class=\"underline-link\" href=\"index.php?category=jobs&action=my\"><i><b>".$importedCounter."</b> ".$M_ADS_POSTED_SUCCESS.".</i></a><br><br>";
		}

		if($deletedCounter>0)
		{
			echo "<i><b>".$deletedCounter."</b> ".$M_ADS_DELETED_SUCCESS.".</i><br><br>";
		}

		if($expiredCounter>0)
		{
			echo "<i><b>".$expiredCounter."</b> ".$M_ADS_SET_EXPIRED_SUCCESS.".</i><br><br>";
		}			
					
		echo "</td></tr></table>";		
									
	}

	?>

	<table summary="" border="0" width="100%">
		<tr>
			<td>
			<form action="index.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">
					<input type="hidden" name="folder" value="my">
					<input type="hidden" name="page" value="export">
					<input type="hidden" name="show" value="1">
					<input type="hidden" name="proceed" value="1">

							
					
			
					<br>
					<h3><?php echo $M_ADS_TO_BE_IMPORTED;?></h3>
					
					
					
					<?php
					$tableImported= $database->DataTable("imported_ads","WHERE employer='".$AuthUserName."'");
					
					
					if($database->num_rows($tableImported) == 0)
					{
						
							echo "<br/><br/><i>".$M_NO_ADS_TO_IMPORT.".</i>";
					?>
						
					<?php
					}
					else
					{
					
					while($arrImported = $database->fetch_array($tableImported))
					{
					?>
					
					
						<table summary="" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="right">
										<input type="hidden" name="import_ids[]" value="<?php echo $arrImported["id"];?>">
										
										<input type="radio" checked name="import<?php echo $arrImported["id"];?>" value="0">
										<?php echo $M_NO_ACTION;?>
										<?php
										
										$enable_import=true;
										
										
										if($website->GetParam("CHARGE_TYPE") == 1)
										{
											if($arrUser["subscription"]==0)
											{
												$enable_import=false;
											}
											else
											{
												
												$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
											
												if(($database->SQLCount("jobs","WHERE employer='".$AuthUserName."'") + $database->SQLCount("courses","WHERE employer='".$AuthUserName."'"))>= $arrSubscription["listings"])
												{
													$enable_import=false;
												}
											
											}
										}
										else
										if($website->GetParam("CHARGE_TYPE") == 2)
										{
											if(($arrUser["credits"]-$website->GetParam("PRICE_LISTING_CREDITS"))<=0)
											{
												$enable_import=false;
											}
										}


										if($enable_import)
										{
										?>
										
											<input type="radio"  name="import<?php echo $arrImported["id"];?>" value="1">
											<?php echo $M_IMPORT;?>
											&nbsp;
										<?php
										}
										?>
										<input type="radio" name="import<?php echo $arrImported["id"];?>" value="2">
										<?php echo $EFFACER;?>
										
										<input type="radio" name="import<?php echo $arrImported["id"];?>" value="3">
										<?php echo $M_SET_EXPIRED;?>
								
								</td>
							</tr>
						 </table>
						<b><?php echo $M_TITLE;?>:</b>
						<br>
						<?php echo $arrImported["title"];?>
						<br><br>
						<b><?php echo $M_DESCRIPTION;?>:</b>
						<br>
						<?php echo $arrImported["message"];?>
						
						<hr size="1" width="100%">
						
						
						
						<?php
						}
					
						?>
					
					
					<input type="submit" class="adminButton" value=" <?php echo $M_PROCEED;?> ">
					
					
					
					</form>
					
					<?php
					}
					?>
					
					
			</td>
		</tr>
	</table>

	<?php

}
else
{


?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<form action="index.php" method="post">
		<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">
		<input type="hidden" name="folder" value="my">
		<input type="hidden" name="page" value="export">
		<input type="hidden" name="doExport" value="1">
		<input type="hidden" name="Export" value="1">
		
		<br>
		<b><?php echo $M_EXPORT_CSV;?></b>
		
		<br><br><br>
		<i><?php echo $M_SELECT_FIELDS;?>:</i>
		<br><br>
		<table width="100%">
		<?php
		
				$arr_fields=$database->GetFieldsInTable("jobs");
			
				
				if (sizeof($arr_fields) > 0) 
				{
				
 	 				$fields = count($arr_fields);
  					$i = 0;
					$ic = 0;
  
					  while ($i < $fields)
					  {
					  
						  if(in_array($arr_fields[$i], $arrFieldsToSkip))
						  {
							$i++;
							continue;
							
						   }
						  
						  if($ic%4==0) echo "<tr>";
						  
						  ?>
							
							
							
							<td width="20%">
							<input type="checkbox" name="exp_fields[]" value="<?php echo $arr_fields[$i];?>" checked>
							
							  <?php echo strtoupper($arr_fields[$i]);?>
							</td>
							
							  
							<?php
							
							 if(($ic+1)%4==0) echo "</tr>";
							 
							  $i++;
							  $ic++;
					  }
				  
				  }
  
		?>
		</table>
		<br>
		
		<input type="submit" value=" <?php echo $M_EXPORT;?> " class="adminButton">
		
		
		
		</form>
		
		
		<?php
		
		$hideUploadForm=false;
		

		$map_fields = array();
		$map_fields["job_category"]="job_category";
		$map_fields["region"]="region";
		$map_fields["title"]="title";
		$map_fields["message"]="message";
		$map_fields["active"]="active";
		$map_fields["notification"]="notification";
		$map_fields["zip"]="zip";
		$map_fields["job_type"]="job_type";
		$map_fields["salary"]="salary";
		$map_fields["date_available"]="date_available";
		
		
		if(isset($_POST["Import"]))
		{
			
			$result=parse_csv($_FILES['import_file']['tmp_name']);
			
			$import_counter = 0;
			
			foreach($result as $line)
			{
				$arr_import_fields=array();
				$arr_import_values=array();
		
				foreach($map_fields as $key=>$value)
				{
					if(isset($line[$key]))
					{
						array_push($arr_import_fields, trim($value));
						array_push($arr_import_values, trim($line[$key]));
					}
				}
				
				
				if (!in_array('employer', $arr_import_fields))
				{
					array_push($arr_import_fields,"employer");
					array_push($arr_import_values,$AuthUserName);
				}
				
				$database->SQLInsert("imported_ads",$arr_import_fields,$arr_import_values);
				$import_counter++;
			}
			
			
			
			if($import_counter!=0)
			{
				echo "<br><br>";
				$hideUploadForm=true;
				
				if(true)
				{
				?>
					<script>
					document.location.href='index.php?category=jobs&folder=my&page=export&show=1';
					</script>
					<table summary="" border="0">
						<tr>
							<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
							<td><a href="index.php?category=jobs&folder=my&page=export&show=1" style="color:#ff0000;text-transform:uppercase;font-weight:800"><?php echo $M_CLICK_IMPORT;?></a></td>
						</tr>
					  </table>
					
				
					
					
				<?php	
				}
			
			}
			
			
			
		}
		
		?>
		
		<?php
		if(!$hideUploadForm)
		{
		?>
		<br><br>
		
		<b><?php echo $M_IMPORT_CSV;?></b>
		<br><br>
		
		<i><?php echo $M_SELECT_TO_BE_IMPORTED;?>:</i>
		<br><br>
		
		<form action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">
		<input type="hidden" name="folder" value="my">
		<input type="hidden" name="page" value="export">
		<input type="hidden" name="Import" value="1">
		<?php echo $FILE;?>:
		<input type="file" name="import_file">
		
		<br><br>
		
		<input type="submit" value=" <?php echo $M_IMPORT;?> " class="adminButton">
		
		</form>
		
		<br><br>
		

		
		<table summary="" border="0">
  	<tr>
  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
  		<td><a href="index.php?category=<?php echo $category;?>&folder=my&page=export&show=1" style="color:#6d6d6d;text-transform:uppercase;font-weight:800"><?php echo $M_NOT_IMPORTED;?></a></td>
  	</tr>
  </table>
		
		
		<?php
		}
		?>
		
		</td>
	</tr>
</table>

<?php
}


function parse_csv($file, $delimiter=',') 
{
	$field_names=array();
	$res=array();
	
	if (($handle = fopen($file, "r")) !== FALSE) 
	{ 
		$i = 0; 
		while (($lineArray = fgetcsv($handle, 4000, $delimiter)) !== FALSE) 
		{ 
			
			if($i==0)
			{
				for ($j=0; $j<count($lineArray); $j++) 
				{ 
					$field_names[$j] = $lineArray[$j]; 
				}
			}
			else
			{
				for ($j=0; $j<count($lineArray); $j++) 
				{ 
					if(isset($field_names[$j]))
					{
						$data2DArray[$i-1][$field_names[$j]] = $lineArray[$j]; 
					}
				}
			}				
			$i++; 
		} 
		fclose($handle); 
    } 
		
	
    return $data2DArray; 
	
} 
?>
