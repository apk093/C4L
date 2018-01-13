<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php 
if(!defined('IN_SCRIPT')) die("");

if(!isset($_FILES[isset($input_field)?$input_field:'images']))
{

}
else
if(isset($_FILES))
{

	$files=array();
	$fdata=$_FILES[isset($input_field)?$input_field:'images'];
	
	
	if(is_array($fdata['name']))
	{
		for($i=0;$i<count($fdata['name']);++$i)
		{
			if(trim($fdata['name'][$i])==""||trim($fdata['tmp_name'][$i])=="") continue;
			
			$size	= getimagesize($fdata['tmp_name'][$i]);
			$mime	= $size['mime'];
			
			if (substr($mime, 0, 6) != 'image/') continue;

			if(isset($limit_pictures)&&$limit_pictures>0)
			{
				if($i>=$limit_pictures) break;
			}

			$files[]=array
			(
				'name'    =>$fdata['name'][$i],
				'type'  => $fdata['type'][$i],
				'tmp_name'=>$fdata['tmp_name'][$i],
				'mime' => $mime, 
				'size'  => $fdata['size'][$i]  
			);
		}
	}else $files[]=$fdata;

	
	$is_first_image = true;
	
	foreach ($files as $file) 
	{ 
	
		if(trim($file['tmp_name'])=="") continue;
		
		$i_random=rand(200,100000000);

		$save_file_name = (isset($path)?$path:"")."uploaded_images/" .$i_random.".jpg";
	
		$uploaded_file = $file['tmp_name'];
		
		if($uploaded_file == "") continue;
	
		 list($width, $height) = getimagesize($uploaded_file) ; 

		if($width < 600)
		{
			$modwidth = $width;
		}
		else
		{
			$modwidth = 600; 
		}
		
		
		$diff =  $modwidth / $width;
		
		$modheight = $height * $diff; 
		
		
		$tn = imagecreatetruecolor($modwidth, $modheight) ; 
		
		
		$mime_type = "";
		
		if(isset($file['mime']))
		{
			$mime_type = $file['mime'];
		}
		
		if(isset($file['type']))
		{
			$mime_type = $file['type'];
		}
		
		switch ($mime_type)
		{
			case 'image/gif':
				$creationFunction	= 'ImageCreateFromGif';
				$outputFunction		= 'ImagePng';
				$mime				= 'image/png'; // We need to convert GIFs to PNGs
			break;
			
			case 'image/x-png':
			case 'image/png':
				$creationFunction	= 'ImageCreateFromPng';
				$outputFunction		= 'ImagePng';
			break;
			
			default:
				$creationFunction	= 'ImageCreateFromJpeg';
				$outputFunction	 	= 'ImageJpeg';
			
			break;
		}

		$image	= $creationFunction($uploaded_file);

		
		imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
		imagejpeg($tn, $save_file_name, 70) ; 
		
		//thumbnails generation
			if($width < 240)
			{
				$thumb_width = $width;
			}
			else
			{
				$thumb_width = 240; 
			}
			$thumb_diff = $thumb_width / $width;
			$thumb_height = $height * $thumb_diff; 
			$thumb = imagecreatetruecolor($thumb_width, $thumb_height) ; 
			
			imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height) ; 
			imagejpeg($thumb, (isset($path)?$path:"")."thumbnails/" .$i_random.".jpg", 90) ; 
			
		//end thumbnails
	
		
		if($str_images_list!="")
		{
			$str_images_list.=",";
		}
		
		$str_images_list.=$i_random;
		
		$is_first_image = false;
	}
}
?>