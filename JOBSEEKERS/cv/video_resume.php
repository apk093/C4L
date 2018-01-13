<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
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
		"cv",
		"resume_creator",
		$M_RESUME_CREATOR,
		"",
		"green"
	 );
	
	
	?>

</div>
<div class="clear"></div>
<?php
/*
$video_types = Array 
(
	array("video/x-ms-wmv","wmv"),
	array("video/mpeg","mpg"),
	array("video/x-msvideo","avi"),
	array("video/avi","avi")
);
*/
$video_types = Array 
(
	array("video/mp4","mp4"),
	array("video/webm","webm"),
	array("video/quicktime","mov"),
	array("video/ogg","ogg")
);

	
$MAX_VIDEO_SIZE=50000000;

if(isset($_REQUEST["process_form"]))	
{
	
	if(isset($_FILES["video_file"]["name"]))
	{
		$s_file_id=0;
		$ir=rand(200,100000000);
		$file_name = $_FILES["video_file"]["name"];
		$file_size = $_FILES["video_file"]["size"];
		$file_type = $_FILES["video_file"]["type"];
		
		
		function GetVideoFileType($file_type)
		{

			$video_types = Array 
			(
				array("video/mp4","mp4"),
				array("video/webm","webm"),
				array("video/quicktime","mov"),
				array("video/ogg","ogg")
			);

			foreach($video_types as $c_file_type)
			{
				if($c_file_type[0] == $file_type)
				{
					return $c_file_type[1];
				}
			}
			return "";
		}


		$file_extension = GetVideoFileType($file_type);
		
		 if($file_extension == "")
		{
			echo "<b><font color=red>".$M_FILE_FORMAT_NOT_SUPPORTED."!</font></b>";
		}
		else
		{
			 $uploadedFile = "../user_videos/" . $ir.".".$file_extension;
		
			if($file_size > $MAX_VIDEO_SIZE)
			{
				echo "<b><font color=red>".$FILE_MAX_SIZE_EXCEEDED."</font></b>";
			}
			else 
			if (move_uploaded_file($_FILES["video_file"]['tmp_name'], $uploadedFile))
			{
				$database->SQLUpdate_SingleValue("jobseekers","username","'".$AuthUserName."'","video_id",$ir);
				
				$s_file_id=$ir;
				$arrUser["video_id"]=strip_tags($ir);	
			}
			else
			{
				  echo $M_ERROR_UPLOADING;
			}
			
		}
	}
	else
	if(trim($_REQUEST["video_file_id"])!="")
	{
		$database->SQLUpdate_SingleValue("jobseekers","username","'".$AuthUserName."'","video_id",strip_tags($_REQUEST["video_file_id"]));
		$arrUser["video_id"]=strip_tags($_REQUEST["video_file_id"]);	
	}
	
}

if(isset($_REQUEST["process_delete"]))
{
	foreach($video_types as $c_file_type)
	{	
		if(file_exists("../user_videos/".$arrUser["video_id"].".".$c_file_type[1]))
		{
			unlink("../user_videos/".$arrUser["video_id"].".".$c_file_type[1]);
		}
	}
	$database->SQLUpdate_SingleValue("jobseekers","username","'".$AuthUserName."'","video_id","");
	$arrUser["video_id"]="";	
}
?>
<script>
function DeleteVideo()
{
	if(confirm("<?php echo $M_ARE_YOU_SURE_DELETE;?>"))
	{
		document.location.href="index.php?category=cv&action=video_resume&process_delete=1";
	}
}

</script>

<h3>
	<?php echo $M_MANAGE_YOUR_VIDEO_RESUME;?>
</h3>
<br>
	
		<?php
		
		if($arrUser["video_id"]!=""&&$arrUser["video_id"]!="0")
		{
		?>
		<br/>
				<table summary="" border="0">
			  	<tr>
			  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
			  		<td><a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=play"><b><?php echo $M_PLAY_VIDEO_PRESENTATION;?></b></a></td>
					<td width="70">&nbsp;</td>
			  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
			  		<td><a href="javascript:DeleteVideo()"><b><?php echo $M_DELETE_VIDEO_PRESENTATION;?></b></a></td>
			  	</tr>
			  </table>
		<?php
		}
		?>		
	<br/>
	<br/>
	<form action="index.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="process_form" value="1">
	<input type="hidden" name="process_update" value="1">
	<input type="hidden" name="category" value="<?php echo $category;?>">
	<input type="hidden" name="action" value="<?php echo $action;?>">
	
	<table>
		<tr>
			<td valign="top" style="padding-top:6px;padding-right:4px">
				<?php echo $M_VIDEO_ID_URL;?>:
			</td>
			<td valign="top">
				<input type="text" name="video_file_id" value="<?php if(isset($_POST["video_file_id"])) echo $_POST["video_file_id"];else if(!is_numeric($arrUser["video_id"])) echo $arrUser["video_id"];?>" size="40"/>
				<br/>
				<span class="small-font">e.g. &nbsp; SxSP2mv_pVs &nbsp;  or  &nbsp; http://youtu.be/SxSP2mv_pVs</span>
	
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $M_OR;?>
				<span class="small-font"><br/><br/></span>
			</td>
		</tr>
		<tr>
			<td valign="top" style="padding-top:6px;padding-right:4px">
				<?php echo $M_UPLOAD_IT_FILE;?>: 
			</td>
			<td valign="top">			
				<input type="file" name="video_file" size="20">
				
				<span class="small-font"><?php echo $M_SUPPORTED_FORMATS;?></span>
	
			</td>
		</tr>
	</table>
	
	<br/>
	<input type="submit" value=" <?php echo $M_SAVE;?> " class="btn btn-primary">
	
	</form>
				
	