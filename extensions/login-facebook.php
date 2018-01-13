<?php
require_once 'include/Facebook/autoload.php';

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

$appId         = $website->GetParam("FACEBOOK_KEY"); //Facebook App ID
$appSecret     = $website->GetParam("FACEBOOK_SECRET"); //Facebook App Secret
$redirectURL   = 'http://'.$DOMAIN_NAME.'/index.php?mod=login-facebook'; //Callback URL
$fbPermissions = array('email');  

$fb = new Facebook(array(
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.2',
));


$helper = $fb->getRedirectLoginHelper();
global $DEBUG_MODE;

try {
    if(isset($_SESSION['facebook_access_token']))
	{
        $accessToken = $_SESSION['facebook_access_token'];
    }else
	{
         $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) 
{
	if($DEBUG_MODE)
	{
		echo 'Graph returned an error: ' . $e->getMessage();
	}
      exit;
} catch(FacebookSDKException $e) 
{
	if($DEBUG_MODE)
	{
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
	}
    exit;
}









if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token']))
	{
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
       
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
      
        $oAuth2Client = $fb->getOAuth2Client();
        
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
      
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    


   if(isset($_GET['code']))
   {
     
	   echo '<script>document.location.href="'.$redirectURL.'";</script>';
    }
    
  
    try 
	{
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,gender');
        $user_profile = $fbUserProfile = $profileRequest->getGraphNode()->asArray();
    } 
	catch(FacebookResponseException $e) 
	{
		if($DEBUG_MODE)
		{
			echo 'Graph returned an error: ' . $e->getMessage();
        }
    } 
	catch(FacebookSDKException $e) 
	{
		if($DEBUG_MODE)
		{
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
		}
        exit;
    }
  
	$uid = $fbUserProfile['id'];
	
	///jp user code
	
		if($database->SQLCount("jobseekers","WHERE facebook_id=".$uid)==0)
		{
			$email="";
			if(isset($user_profile['email']))
			{
				$email=$user_profile['email'];
			}
			if(isset($_POST["user_email"]))
			{
				$email=$_POST["user_email"];
			}
		
			if($email==""||$database->SQLCount("employers","WHERE username='".$email."' ") > 0 || $database->SQLCount("jobseekers","WHERE username='".$email."' ") > 0)
			{
				?>
				<h3><?php
				if($database->SQLCount("employers","WHERE username='".$email."' ") > 0 || $database->SQLCount("jobseekers","WHERE username='".$email."' ") > 0)
				{
					echo $USER_EXISTS;
				}
				else
				{
					echo $M_JUST_CONFIRM_USERNAME;
				}
				?></h3>


				<form id="main" action="index.php" method="post">
				<input type="hidden" name="mod" value="login-facebook">
				<fieldset>
					<ol>
					<li>
		
						<label>
						<?php echo $EMAIL;?>: (*) 
						</label>
			
						<input type="email" required name="user_email" id="user_email" value=""/> 
				
					</li>
					</ol>
				</fieldset>
				<br/>
				<button type="submit" class="btn btn-primary pull-right"><?php echo $M_SUBMIT;?></button>
				<div class="clearfix"></div>	
				</form>
				<?php
				$do_not_show_submit=true;
			}
			else
			{
				$name = $user_profile['name'];
				
			
				$first_name="";
				$last_name="";
				
				if(isset($user_profile["first_name"]))
				{
					$first_name=$user_profile["first_name"];	
				}
				
				if(isset($user_profile["last_name"]))
				{
					$last_name=$user_profile["last_name"];	
				}
				
				if(isset($user_profile["name"]))
				{
					$name_items=explode(" ",$user_profile["name"],2);
					
					$first_name=$name_items[0];	
					
					if(isset($name_items[1]))
					{
						$last_name=$name_items[1];
					}
				}
				$username=$email;
				
				$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
			
				$password = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
				.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);
			
				
				$database->SQLInsert
				(
					"jobseekers",
					array("facebook_id","active","date","username","password","first_name","last_name"),
					array($uid,"1",time(),$email,$password,$first_name,$last_name)
				
				);
				
				
				if($website->params[104]==1)
				{
					$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
				
					mail($user_email, $website->params[110], $website->params[111], $headers);
				}
			
			}
		}
		else
		{
		
			$arrUser=$database->DataArray("jobseekers","facebook_id=".$uid);
			
			$username=$arrUser["username"];
			$password=$arrUser["password"];
			
		}
		
		if(!isset($do_not_show_submit))
		{
	
		?>
			<form id="login_form" style="display:none" class="no-margin" action="loginaction.php" method="post">
			<input type="hidden" name="Email" value="<?php echo $username;?>"/>
			<?php
			if($MULTI_LANGUAGE_SITE)
			{
			?>
			<input type="hidden" name="lng" value="<?php echo $website->lang;?>"/>
			<?php
			}
			?>
			<input type="hidden" name="Password" value="<?php echo $password;?>"/>
			</form>
			<script>
			document.getElementById("login_form").submit();
			</script>

		<?php
		}	
	
	///end jp user code
    
    
}
else
{
   
    $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
    
	
	echo '<script>document.location.href="'.$loginURL.'";</script>';
   
}
$website->Title("Facebook Login");
?>