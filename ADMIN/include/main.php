<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><script src="../include/nmenu.js"></script>
<style>
.zh {position:absolute;visibility:hidden;z-index:1;}
.zl {display:block;padding:0px 0px 0px 0px;text-decoration:none;font-style:none;}
.zl:hover {text-decoration:none;font-style:none;}
.zls {color:#8c8c8c;font-size:10px;font-family:Arial;display:block;padding:1px 1px 1px 1px;text-decoration:none;font-style:none;}
.zls:hover {color:#b6b6b6;font-size:10px;font-family:Arial;text-decoration:none;font-style:none;}
.hon  {height:14px;margin:0;}
.hoff {height:14px;margin:0;}
.hson  {width:140px;height:18px;margin:0;background:#f3f3f3;border-width:0px 1px 1px 1px;border-color:#e0dfdf;border-style:solid;}
.hsoff {width:140px;height:18px;margin:0;background:#ffffff;border-width:0px 1px 1px 1px;border-color:#e0dfdf;border-style:solid;}
</style>
<script>
var z_BOTTOM = "bottom";
</script>


<?php
function RenderAZMenu()
{

}

function getBgColor($strPageName){
	global $category;
	if($strPageName==$category){
		return "leftNavigationSelectedTD";
	}
	else{
		return "leftNavigationTD";	
	}
}

function getLinkStyle($strPageName)
{
	global $category;
	if($strPageName==$category)
	{
		return "leftNavigationSelectedLink";
	}
	else{
		return "leftNavigationLink";	
	}
}



function GenerateInternalMenu($category,$oLinkTexts,$oLinkActions,$evLinkDescriptions){
	global $AuthGroup,$arrPermissions;
	
	$strOutput="";
	
	if(count($oLinkTexts)!=count($oLinkActions)){
			return "<font color=red>ERROR: the number of link texts mismatch the link actions</font>";
	}
	
		
	$bFirst = true;
	
	for($i=0;$i<count($oLinkTexts);$i++)
	{
	
		$CurrentPage="@".$AuthGroup."@".$category."@".$oLinkActions[$i];
				
		
	
	if(!strstr($oLinkTexts[$i],"add-on"))
	{
		$strOutput .= '<div class="hsoff" style="border-width:'.($bFirst?'"1px 1px 1px 1px"':'"0px 1px 1px 1px"').'" onmouseover="javascript:zon(this,1,\'hson\',\'hsoff\',\''.$category.'\',z_BOTTOM)"> <a class="zls" href="index.php?category='.$category.'&action='.$oLinkActions[$i].'">'.$oLinkTexts[$i].'</a></div>';
	}
	else
	{
		$strOutput .= '<div class="hsoff" style="border-width:'.($bFirst?'"1px 1px 1px 1px"':'"0px 1px 1px 1px"').'" onmouseover="javascript:zon(this,1,\'hson\',\'hsoff\',\''.$category.'\',z_BOTTOM)"> <a class="zls" href="index.php?category='.$oLinkActions[$i].'">'.$oLinkTexts[$i].'</a></div>';
	}
	
	$bFirst = false;
	
		
	}
	
	return $strOutput;
}
	
	$strOutput="";
	$strAZMenu="";
	$strAZScript="";
	
	if(count($oLinkTexts)!=count($oLinkActions)){
			return "<font color=red>ERROR: the number of link texts mismatch the link actions</font>";
	}
		
	$strOutput.="
							<table border=0 cellpadding=0 cellspacing=0 >
							<tr >
					";
	
	
	$iOffCounter=0;
	
	$bFirst = true;
	
	for($i=0;$i<count($oLinkTexts);$i++){
	
		$continueFlag=true;
		
		
		
		$vr1 = ($oLinkActions[$i]."_oLinkTexts");		
		$vr2 = ($oLinkActions[$i]."_oLinkActions");	
		$vr3 = ($oLinkActions[$i]."_oLinkDescriptions");	
		
		$evSLinkTexts=$$vr1;
		$evSLinkActions=$$vr2;
		$evSLinkDescriptions=$$vr3;
					
				
		if($continueFlag==true)
		{
			
			$strOutput .= '<td><div class="hoff" '.( $bFirst?'style="border-width:1px 1px 1px 1px"':'').' onmouseover="javascript:zon(this,0,\'hon\',\'hoff\',\'menu'.$i.'\',z_BOTTOM);"><div ><a class="zl" href="'.'index.php?category='.$oLinkActions[$i].'"><font color=#8c8c8c style="font-size:14px;font-weight:800;font-family:Arial">'.$oLinkTexts[$i].'</font></a></div></div></td>';
	
					if(strtolower($LANGUAGE2) == "cn")
					{
						$strOutput .= '<td width=51>&nbsp;</td>';
					}
					else
					{
						$strOutput .= '<td width=41>&nbsp;</td>';
					}
			
			$bFirst = false;
			
				
					$strAZMenu.="
				
		  				<div  id=menu".$i." class=zh style='padding-top:12px'> 
							".GenerateInternalMenu($oLinkActions[$i],$evSLinkTexts,$evSLinkActions,$evSLinkDescriptions)."						
						</div>
				
					";
		
			
			$iOffCounter++;
		}

		
		
	}
	if(strtolower($LANGUAGE2) == "it")
	{
		$strOutput .= '<td width=70>&nbsp;</td>';
	}
	else
	if(strtolower($LANGUAGE2) == "cn")
	{
		$strOutput .= '<td width=160>&nbsp;</td>';
	}
	else
	{
		$strOutput .= '<td width=50>&nbsp;</td>';
	}
	$strOutput.="		
								</tr>
							</table>				
					";

echo $strAZMenu;

echo $strOutput;

?>	
