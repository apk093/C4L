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
					"site_management",
					"languages",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>

<span id="page-header" class="medium-font">
<?php echo $AJOUTER_NOUVEAU_LANGUAGE;?>
</span>


<br/><br/><br/>
<?php
$arrExamples = array(" ex. \"Deutsch\""," ex. \"DE\"");


if(isset($_REQUEST["SpecialProcessAddForm"]))
{

	$code = substr(strtoupper($_REQUEST["code"]),0,2);
	
	$website->ms_w($code);
	
	$database->SQLQuery
	(
	"
		ALTER TABLE `".$DBprefix."pages` ADD `active_".strtolower($code)."` TINYINT NOT NULL ,
		ADD `name_".strtolower($code)."` VARCHAR( 255 ) NOT NULL ,
		ADD `link_".strtolower($code)."` VARCHAR( 255 ) NOT NULL ,
		ADD `description_".strtolower($code)."` TEXT NOT NULL ,
		ADD `keywords_".strtolower($code)."` TEXT NOT NULL ,
		ADD `html_".strtolower($code)."` TEXT NOT NULL ,
		ADD `custom_link_".strtolower($code)."` TEXT NOT NULL
	"
	);
	
	$database->SQLQuery("UPDATE
		".$DBprefix."pages 
 		SET active_".strtolower($code)."=active_en,
		name_".strtolower($code)."=name_en,
		link_".strtolower($code)."=link_en,
		description_".strtolower($code)."=description_en,
		keywords_".strtolower($code)."=keywords_en,
		html_".strtolower($code)."=html_en,
		custom_link_".strtolower($code)."=custom_link_en");
		
		
	$new_language_pages=$database->DataTable("pages","");
	
	if(file_exists("../include/texts_".strtolower($code).".php"))
	{
		include("../include/texts_".strtolower($code).".php");
	}
	
	while($new_language_page = $database->fetch_array($new_language_pages))
	{
		
		$str_page_name=$new_language_page["link_".strtolower($code)];
		
		$str_var_name="M_".str_replace(" ","_",strtoupper($str_page_name));
		
				
		if($code!="en"&&isset($$str_var_name))
		{
			$str_new_page_name=$$str_var_name;
			
			
			$database->Query("UPDATE ".$DBprefix."pages 
			SET link_".strtolower($code)."='".$str_new_page_name."'
			WHERE link_en='".$str_page_name."' ");
		}
		
		
						
	}
	
	include("../include/texts_".$lang.".php");
	
}



AddNewForm
(
	array($LANGUAGE.": ",$CODE.": ",$ACTIVE.": "),
	array("name","code","active"),
	array("textbox_30","textbox_6","combobox_$M_YES^1_$M_NO^0"),
	$AJOUTER,
	"languages",
	$AJOUTER_SUCCES,
	true,
	$arrExamples
);

?>

<br/>
<br/>