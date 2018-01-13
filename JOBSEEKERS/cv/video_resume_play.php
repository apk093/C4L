<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		
	echo LinkTile
		 (
			"cv",
			"video_resume",
			$M_GO_BACK,
			"",
			"red"
		 );
	
	?>

</div>
<div class="clear"></div>
<br/><br/>
<center>

<?php
if($arrUser["video_id"]=="") die("");
$video_types = Array 
(
	array("video/mp4","mp4"),
	array("video/webm","webm"),
	array("video/quicktime","mov"),
	array("video/ogg","ogg")
);

if(is_numeric($arrUser["video_id"]))
{
	
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

	/*
	include("../include/video.php");
	if($video_file!="")
	{
 		echo "<script>ShowVideo('".$video_file_type."','".$video_file."',320,240,'center');</script>";
	}
	*/
	?>
	<video width="560" height="315" autoplay>
	  <source src="<?php echo $video_file;?>" type="<?php echo $video_file_type;?>">
	 
		Your browser does not support the video tag.
	</video>
	
	<?php
	
}
else
{
	$video_id=$arrUser["video_id"];
	$video_id=str_replace("http://www.youtube.com/watch?v=","",$video_id);
	$video_id=str_replace("https://www.youtube.com/watch?v=","",$video_id);
	$video_id=str_replace("http://youtu.be/","",$video_id);
	$video_id=str_replace("https://youtu.be/","",$video_id);
	?>
	<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen></iframe>
<?php
}
?>


</center>
<br/>
