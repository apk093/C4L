<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br/>
<div class="page-wrap">
	<script>
	function ShowFaq(x)
	{
		
		if(document.getElementById("faq"+x).style.display=="none")
		{
			document.getElementById("faq"+x).style.display="block";
		}
		else
		{
			document.getElementById("faq"+x).style.display="none";
		}
	}
	</script>
	<br>
	<b><?php echo $M_FAQ;?></b>
	<br><br>
	<?php
	$faqTable = $database->DataTable("faq","ORDER BY date");

	$iFaqCounter = 0;

	while($faqArray = $database->fetch_array($faqTable))
	{
		$iFaqCounter++;
		
		echo $iFaqCounter.". <a href='javascript:ShowFaq(".$iFaqCounter.")'>".stripslashes($faqArray["title"])."</a>";	
		
		echo "
		<br>
			<div id=\"faq".$iFaqCounter."\" style=\"display:none\">
			<br>
			".stripslashes($faqArray["html"])."
			<br>
			</div>
			<br><br>
		";
	}
	?>
</div>
