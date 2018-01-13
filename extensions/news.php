<?php
if (!defined('IN_SCRIPT')) die("");
?>
<br/>
<div class="page-wrap">
<?php
if(isset($_REQUEST["id"]))
{
	$news_id = $_REQUEST["id"];
	$website->ms_i($news_id);
	$arrNews = $database->DataArray("news","id=".$news_id);
	
	if(!isset($arrNews["id"]))
	{
		die("");
	}
	
	
	$website->Title(strip_tags(stripslashes($arrNews["title"])));
	$website->MetaDescription($website->text_words(strip_tags(stripslashes($arrNews["html"])),25));
	$website->MetaKeywords($website->format_keywords($website->text_words(strip_tags(stripslashes($arrNews["html"])),35)));
	
	echo "<div class=\"pull-right\">".date($website->GetParam("DATE_FORMAT"),$arrNews["date"])."</div>";
	
	$news_content = stripslashes($arrNews["html"]);
	
	$news_content =preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<br/><iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>",$news_content);
	
	echo '
	<h2 class="no-decoration">
		'.stripslashes($arrNews["title"]).'
	</h2>
	<hr/>
	<div class="news-content">
		'.$news_content.'
	</div>';
}
else
{
	$tableNews=$database->DataTable("news","WHERE active='YES' ORDER BY id DESC");

	while($arrNews = $database->fetch_array($tableNews))
	{
		echo "<div class=\"pull-right\">".date($website->GetParam("DATE_FORMAT"),$arrNews["date"])."</div>";
		
		echo "<a class=\"underline-link\" href=\"".$website->news_link($arrNews["id"],$arrNews["title"])."\"><h3 class=\"no-decoration\">".stripslashes(strip_tags($arrNews["title"]))."</h3></a>
		<span class=\"sub-text\">
		".$website->text_words(stripslashes(strip_tags($arrNews["html"])),40);
		
		if(trim(strip_tags($arrNews["html"]))!="")
		{
			echo "<a title=\"".stripslashes($arrNews["title"])."\" href=\"".$website->news_link($arrNews["id"],$arrNews["title"])."\">...</a>";
		}
		echo "
		</span>
		<hr/>";
	}

}
?>
</div>