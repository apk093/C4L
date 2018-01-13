<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
class AdminPage
{
	
	var $templateHTML="";
	var $pageHTML="";
	public $page;
	
	var $arrElements=array("title","menu","content","keywords","description");
	var $arrElementsHTML=array();
	var $templateID=0;
	var $arrPage;
	
	function AdminPage($page_name="")
	{
		$this->page = $page_name;
		
	}
	
	
	function Process($is_mobile=false)
	{
		global $is_mobile;
		global $DOMAIN_NAME,$lang,$website,$AdminUser,$arrUser,$LoginInfo,$currentUser;

		
		include("../include/texts_".$lang.".php");
		
		include("pages_structure.php");
		include("wysiwyg/detect_browser.php");
		
		global $AuthUserName,$lang,$website,$database, $_REQUEST, $DBprefix;
		$iKEY = "AZ8007";
		$DN=2;
		$this->pageHTML=$website->TemplateHTML;
		include("include/check_php_version.php");
		
		if(isset($_REQUEST["category"]))
		{
			$category = $_REQUEST["category"];
		}
		else
		{
			$category = "home";
		}
		$website->ms_w($category);
		
		$HTML="";
		ob_start();
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$folder = $_REQUEST["folder"];
			$page = $_REQUEST["page"];
			$website->ms_w($folder);
			$website->ms_w($page);
			
			if(file_exists($category."/".$folder."_".$page.".php"))
			{
				include($category."/".$folder."_".$page.".php");
			}
		}
		else
		{
			if(isset($_REQUEST["action"]))
			{
				$action = $_REQUEST["action"];
			}
			else
			{
				$action = "welcome";
			}
		
			$website->ms_w($action);

			if(file_exists($category."/".$action.".php"))
			{
				
				include($category."/".$action.".php");
			}
			else
			{
				
			}
		}
		
		if($HTML=="")
		{
			$HTML = ob_get_contents();
		}
		ob_end_clean();

		if($is_mobile)
		{
			$mobile_start = strpos($HTML, '<!--mobile-start-->');
			$mobile_end   = strpos($HTML, '<!--mobile-end-->', $mobile_start);
			
			if($mobile_start !== false && $mobile_end !== false) 
			{
				$HTML   = substr($HTML, $mobile_start, ($mobile_end - $mobile_start));
			}
		}

		$logo_html = '<a href="index.php">';
		
		$main_admin = $database->DataArray("admin_users","id=1");
		if
		(
			$main_admin["logo"]!=""
			&&
			file_exists("../thumbnails/".$main_admin["logo"].".jpg")
		)
		{
			
			$logo_html .= '<img src="../thumbnails/'.$main_admin["logo"].'.jpg" class="img-responsive"/>';
		
		}
		
		else
		if
		(
			$main_admin["logo_text"]!=""
		)
		{
			$logo_html .= stripslashes($main_admin["logo_text"]);
		}
		else
		{
			$logo_html .= '<img src="../images/logo.png" class="img-responsive site-logo"/>';
		}
		$logo_html .= '</a>';
		$this->pageHTML = str_replace("<site logo/>",$logo_html,$this->pageHTML);
		
		
		$this->pageHTML = str_replace("<site content/>",$HTML,$this->pageHTML);
		$this->pageHTML = str_replace("<site title/>","",$this->pageHTML);
		
		global $M_LOGOUT,$M_MAIN_SITE;
		$login_links='
			
			<a class="btn btn-default btn-green btn-sm" href="../index.php?lang='.$lang.'">'.$M_MAIN_SITE.'</a>
			<a class="btn btn-default btn-blue btn-sm" href="../logout.php?lang='.$lang.'">'.$M_LOGOUT.'</a>
		';
		$this->pageHTML = str_replace("<site login_links/>",$login_links,$this->pageHTML);
			
			$this->pageHTML=
			str_replace
			(
				"<site languages_menu/>",
				$this->LanguagesMenu(),
				$this->pageHTML
			);
			
			$this->pageHTML=
			str_replace
			(
				"<site menu/>",
				$this->StartMenu(),
				$this->pageHTML
			);
			
		$this->pageHTML=
		str_replace
		(
			"<site top_notifications/>",
			$this->TopNotifications(),
			$this->pageHTML
		);
			
		$this->pageHTML=
		str_replace
		(
			"<site logged_user/>",
			$this->ShowLoggedUser(),
			$this->pageHTML
		);	
		
		$website->TemplateHTML=$this->pageHTML;
		
		$str_page_link = "";
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$str_page_link = "index.php?category=".$_REQUEST["category"]."&page=".$_REQUEST["page"]."&folder=".$_REQUEST["folder"]."&";
		}
		else
		if(isset($_REQUEST["category"])&&isset($_REQUEST["action"]))
		{
			$str_page_link = "index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&";	
		}
		else
		{
			$str_page_link = "index.php?";
		}
		
		if($is_mobile)
		{
			$website->TemplateHTML = 
			str_replace("[MOBILE-LINK]",$str_page_link."switch_mobile=0",$website->TemplateHTML);
			include("include/help_tips.php");
		}
		else
		{
			$website->TemplateHTML = 
			str_replace("[MOBILE-LINK]",$str_page_link."switch_mobile=1",$website->TemplateHTML);
			include("include/help_tips.php");
		}
		
	}
	
	
	function CheckPermissions($category, $action)
	{
		global $currentUser;
		
		
		if
		(
			true||
			$currentUser->AuthGroup == "Administrators"
			|| $category == "exit"
		)
		{
			return true;
		}
		else
		if(array_search("@".$currentUser->AuthGroup."@".$category."@".$action, $currentUser->arrPermissions,false))
		{
			return true;
		}
		else
		if($category != "" && $action=="")
		{
			$vr2 = ($category."_oLinkActions");	
			global $$vr2;
			$evLinkActions = $$vr2;

			if(isset($evLinkActions))
			{
				foreach($evLinkActions as $evAction)
				{
					if(array_search("@".$currentUser->AuthGroup."@".$category."@".$evAction, $currentUser->arrPermissions,false))
					{
						return true;
					}
				}
			}
			
			return false;
		}
		else
		{
			return false;
		}
		
	}
	
	function GetHTML()
	{
		global $is_mobile;
		global $lang,$AdminUser,$arrUser,$LoginInfo,$currentUser;
		
		include("../include/texts_".$lang.".php");

		include("pages_structure.php");
		include("wysiwyg/detect_browser.php");
		
		global $AuthUserName, $lang,$website,$database, $_REQUEST, $DBprefix;
		$iKEY = "AZ8007";
		$DN=2;
		
		if(isset($_REQUEST["category"]))
		{
			$category = $_REQUEST["category"];
		}
		else
		{
			$category = "home";
		}
		$website->ms_w($category);
		
		$HTML="";
		ob_start();
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$folder = $_REQUEST["folder"];
			$page = $_REQUEST["page"];
			$website->ms_w($folder);
			$website->ms_w($page);
			
			if(file_exists($category."/".$folder."_".$page.".php"))
			{
				include($category."/".$folder."_".$page.".php");
			}
		}
		else
		{
			if(isset($_REQUEST["action"]))
			{
				$action = $_REQUEST["action"];
			}
			else
			{
				$action = "welcome";
			}
		
			$website->ms_w($action);
			
			if($this->CheckPermissions($category,$action)
			&&file_exists($category."/".$action.".php"))
			{
				include($category."/".$action.".php");
			}
		}
		
		if($HTML=="")
		{
			$HTML = ob_get_contents();
		}
		ob_end_clean();

		return $HTML;
		
	}
	
	
	
	function StartMenu()
	{
		global $M_START,$M_ADD_ON,$lang,$website;
		include("../include/texts_".$lang.".php");
		include("pages_structure.php");
		
		$menu_html = "";
		$bottom_menu = "";
		
		for($i=0;$i<count($oLinkTexts);$i++)
		{
			$vr1 = ($oLinkActions[$i]."_oLinkTexts");		
			$vr2 = ($oLinkActions[$i]."_oLinkActions");	
		
			$evSLinkTexts=$$vr1;
			$evSLinkActions=$$vr2;
			
			$bottom_menu.="\n<div class=\"col-sm-2 no-right-padding\">";
			
			if($this->CheckPermissions($oLinkActions[$i], $evSLinkActions[0]))
			{
				
				$menu_html.="\n<li class=\"panel\"><a  href=\"javascript:;\" data-parent=\"#side\" data-toggle=\"collapse\" class=\"accordion-toggle\" data-target=\"#menu_".$oLinkActions[$i]."\">".$oLinkTexts[$i]."</a>";
			
				$bottom_menu.="\n<h5 class=\"upper\">".$oLinkTexts[$i]."</h5>";
			}
			
			if(sizeof($evSLinkTexts)>1)
			{
				$menu_html.="\n<ul class=\"".(isset($_REQUEST["category"])&&$_REQUEST["category"]==$oLinkActions[$i]?"":"collapse")." nav\" id=\"menu_".$oLinkActions[$i]."\">";
		
				for($j=0;$j<count($evSLinkTexts);$j++)
				{
					
					if(!strstr($evSLinkTexts[$j],$M_ADD_ON))
					{
						if($this->CheckPermissions($oLinkActions[$i], $evSLinkActions[$j]))
						{
							$no_ajax = false;
							if(strpos($evSLinkActions[$j],"_")!==false||strpos($evSLinkActions[$j],"-")!==false)
							{
								$no_ajax = true;
							}
							
							if($evSLinkActions[$j] == "add"||$evSLinkActions[$j] == "new_user"||$evSLinkActions[$j] == "newsletter2")
							{
								$no_ajax = true;
							}
							
							if($oLinkActions[$i]=="home"&&$evSLinkActions[$j]=="welcome")
							{
							  $str_link = "index.php";
							
							}
							else
							{
								
									$str_link = "index.php?category=".$oLinkActions[$i]."&action=".$evSLinkActions[$j];
								
							}
							$menu_html.="\n<li ondragstart=\"javascript:dragStart()\" id=\"".$oLinkActions[$i]."-".$evSLinkActions[$j]."\" class=\"menu-sub-link\"><a href=\"".$str_link."\">".$evSLinkTexts[$j]."</a></li>";
							
							
							$bottom_menu.="\n<a class=\"upper admin-bottom-link\" href=\"".$str_link."\">".$evSLinkTexts[$j]."</a>";
							
						}
					}
					else
					{
						if($this->CheckPermissions($evSLinkActions[$j], ""))
						{
							$menu_html.="\n<li><a href=\"index.php?category=".$evSLinkActions[$j]."&action=home\">".$evSLinkTexts[$j]."</a></li>";
						}
					}
					
					
				}
				
				$menu_html.="\n</ul>";
			}
			
			$bottom_menu.="\n</div>";
			$menu_html.="\n</li>";
			
			if($i==0) $bottom_menu="";
		}
		
		$this->pageHTML=
		str_replace
		(
			"<site bottom_menu/>",
			$bottom_menu,
			$this->pageHTML
		);
			
		return $menu_html;
	
	}
	
	function LanguagesMenu()
	{
		global $currentUser,$lang,$AdminPanelLanguages,$_REQUEST,$language,$website;
		
		$language_menu_html = "";
		
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$strPageLink="category=".$_REQUEST["category"]."&folder=".$_REQUEST["folder"]."&page=".$_REQUEST["page"]."&";
		}
		else
		if(isset($_REQUEST["category"])&&isset($_REQUEST["action"]))
		{
			$strPageLink="category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&";
		}
		else
		{
			$strPageLink="";
		}
										
		foreach($AdminPanelLanguages as $arrLang)
		{
			list($languageName,$languageCode)=$arrLang;
			
			if($languageCode == $lang) continue;
			
			$language_menu_html .= "<a class=\"language-link\" href=\"index.php?".$strPageLink."lng=".$languageCode."\">".$languageName."</a> ";
			
		}
		
		global $M_MAIN_WEBSITE,$M_MY_STORE;
		
		$language_menu_html .= "<a class=\"underline-link language-link left-margin-20px\" href=\"../index.php\">".$M_MAIN_WEBSITE."</a> ";
			
		return $language_menu_html;
	}
	
	function MobileLink()
	{
	
	}
	
	function CreateFooterMenu()
	{
	
	}
	
	
	
	function TopNotifications()
	{
		global $AuthUserName,$AdminUser,$database;
		global $M_NEW_MESSAGES,$M_MAIN_SITE,$M_LOGOUT;
		
		$notifications_html ="";
		
		$notifications_html .='<li>
			<a title="'.$M_MAIN_SITE.'" href="../index.php" class="notification-link">
				<img src="../images/monitor.png" width="21" height="21"/> 
			
			</a>
		 </li>';
		 
		$notifications_html .='<li>
			<a title="'.$M_NEW_MESSAGES.'" href="index.php?category=home&action=received" class="notification-link dropdown-toggle">
				<img  src="../images/email-icon.png" width="21" height="21"/> 
				<span class="number white-font pull-right">'.$database->SQLCount("user_messages","WHERE user_to='".$AuthUserName."' AND date_replied=0").'</span>
			</a>
		 </li>';
	   
	   
		$notifications_html .='<li>
			<a title="'.$M_LOGOUT.'" href="../logout.php" title="'.$M_LOGOUT.'" class="notification-link">
				<img src="../images/logout-2.png" width="20" height="20" alt="'.$M_LOGOUT.'"/> 
			</a>
		</li>';
		
		
		return $notifications_html;
		
	}
	
	function ShowLoggedUser()
	{
	
		global $AdminUser,$M_LOGGED_AS;
		
		$str_img_url="../images/no_pic.gif";
		$images=explode(",",trim($AdminUser["logo"],","));
		
		if(file_exists("../thumbnails/".$images[0].".jpg"))
		{
			$str_img_url="../thumbnails/".$images[0].".jpg";
		}
		
		return '<img class="img-circle img-responsive" src="'.$str_img_url.'" alt="" style="cursor: pointer;position:relative;left:-22px;top:5px" onclick="document.location.href=\'index.php?category=profile&action=edit\'"/>
		<p class="welcome">
			 '.$M_LOGGED_AS.'
		</p>
		<p class="name tooltip-sidebar-logout">
			<a href="index.php?category=profile&action=edit">
			<span class="last-name">'.stripslashes($AdminUser["first_name"]." ".$AdminUser["last_name"]).'</span></a>
			
			<a href="../logout.php"><img src="../images/logout.png" style="display:inline;position:relative;top:6px"/></a>
		</p>';
	}
	
	
	
}
?>