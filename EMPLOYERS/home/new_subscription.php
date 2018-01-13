<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$arrSubscription = $database->DataArray("subscriptions","id=".$id);error_reporting(0);
if(isset($_REQUEST["ProceedPurchase2"]))
{
	
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"id",
		$arrUser["id"],
		"new_subscription",
		$id
	);

	$s_num=rand(100000,999999);
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"id",
		$arrUser["id"],
		"subscription_code",
		$s_num
	);	
	
	require_once("include/AuthnetARB.class.php");
	
	$test = TRUE;

	$arb = new AuthnetARB($website->GetParam("AUTHORIZE_ID"), $website->GetParam("AUTHORIZE_KEY"), $test);

	$arb->setParameter('interval_length', $arrSubscription["billed"]); 
	$arb->setParameter('interval_unit', 'months'); 
	$arb->setParameter('startDate', date("Y-m-d")); 
	$arb->setParameter('totalOccurrences', 12); 
	$arb->setParameter('trialOccurrences', 0); 
	$arb->setParameter('trialAmount', 0.00);
	$arb->setParameter('amount', $arrSubscription["price"]); 
	$arb->setParameter('refId', $s_num); 
	$arb->setParameter('cardNumber', $_POST["CardNumber"]); 
	$arb->setParameter('expirationDate', $_POST["year"].'-'.$_POST["month"]);
	$arb->setParameter('firstName', stripslashes($_POST["FirstName"])); 
	$arb->setParameter('lastName', stripslashes($_POST["LastName"])); 
	$arb->setParameter('address', stripslashes($_POST["CustomerAddress"])); 
	$arb->setParameter('phoneNumber', $_POST["Phone"]);
	$arb->setParameter('email', $_POST["CustomerEmail"]);
	$arb->setParameter('country', 'us');
	$arb->setParameter('subscrName', $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"); 
	$arb->createAccount();

	if ($arb->isSuccessful()) 
	{ 
		$database->SQLUpdate_SingleValue
		(
			"employers",
			"id",
			$arrUser["id"],
			"subscription",
			$id
		); 
		echo '<h3>Thank you! The new subscription has been added successfully to your account!</h3><br/>';
	} 
	else 
	{ 
		echo 
		'
			<h3>There was an error while trying to proceed your payment!</h3>
			<br/>Error Code: '.$arb->getResultCode().'
			<br/>Error Message: '.$arb->getResponse().'
		'; 
	}

				
}
else
{	
	if($arrSubscription["price"]==0)
	{
		$database->SQLUpdate_SingleValue
		(
			"employers",
			"id",
			$arrUser["id"],
			"subscription",
			$id
		);
		
		echo "<br/><h4>".$M_THANK_YOU_PACKAGE_ADDED."</h4>";
	}
	else
	{	
		$database->SQLUpdate_SingleValue
		(
			"employers",
			"id",
			$arrUser["id"],
			"new_subscription",
			$id
		);

		$s_num=rand(100000,999999);
		$database->SQLUpdate_SingleValue
		(
			"employers",
			"id",
			$arrUser["id"],
			"subscription_code",
			$s_num
		);
			
		?>
		<h3>
		<?php echo $M_PLEASE_SELECT_PAYMENT;?>
		</h3>
		<br/>		
					
		<?php
		if(trim($website->GetParam("PAYPAL_ID")) !="")
		{
		?>

		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="image" src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
		 <input type="hidden" name="cmd" value="_xclick-subscriptions">
		<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>"> 
		<input type="hidden" name="item_name" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>"> 
		<input type="hidden" name="item_number" value="<?php echo $s_num;?>"> 
		<input type="hidden" name="no_note" value="1"> 
		<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE");?>"> 
		<input type="hidden" name="a3" value="<?php echo $arrSubscription["price"]; ?>"> 
		<input type="hidden" name="p3" value="<?php echo $arrSubscription["billed"]; ?>"> 
		<input type="hidden" name="t3" value="M"> 
		<input type="hidden" name="src" value="1"> 
		<input type="hidden" name="sra" value="1"> 
		<input type="hidden" name="return" value="http://<?php echo $DOMAIN_NAME;?>/EMPLOYERS/index.php"> 
		<input type="hidden" name="cancel_return" value="http://<?php echo $DOMAIN_NAME;?>/EMPLOYERS/index.php"> 
		<input type="hidden" name="notify_url" value="<?php echo "http://".$DOMAIN_NAME."/ipn.php";?>">
						
		<input type="hidden" name="custom" value="<?php echo $AuthUserName; ?>"> 
		</form>
		<?php
		}
		
		
		if(trim($website->GetParam("MONEYBOOKERS_ID")) !="")
		{
		?>
			<br/><br/>
				<form action="https://www.moneybookers.com/app/payment.pl" method="post"> 
				<input type="hidden" name="pay_to_email" value="<?php echo $website->GetParam("MONEYBOOKERS_ID");?>"> 
				<input type="hidden" name="status_url" value="<?php echo $website->GetParam("MONEYBOOKERS_ID");?>"> 
				<input type="hidden" name="transaction_id" value="<?php echo $s_num;?>"> 
				<input type="hidden" name="language" value="EN"> 
				<input type="hidden" name="rec_amount" value="<?php echo $arrSubscription["price"]; ?>"> 
				<input type="hidden" name="rec_cycle" value="month"/>
				<input type="hidden" name="rec_period" value="<?php echo $arrSubscription["billed"]; ?>"/>
				<input type="hidden" name="currency" value="<?php echo $website->GetParam("CURRENCY_CODE");?>"> 
				<input type="hidden" name="detail1_description" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>"> 
				<input type="hidden" name="detail1_text" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>"> 
				<input type="hidden" name="confirmation_note" value=""> 
				<input type="image"  src="../images/skrill.jpg" border="0">
				</form> 
				
		<?php
		}

		if(trim($website->GetParam("2CHECKOUT_ID")) !="")
		{
		?>
		<br/><br/>
		
		<form action="https://www.2checkout.com/2co/buyer/purchase" method="POST">
		<input type="hidden" name="sid" value="<?php echo $website->GetParam("2CHECKOUT_ID");?>">
		<input type="hidden" name="mode" value="2CO">
		<input type="hidden" name="li_1_price" value="<?php echo $arrSubscription["price"]; ?>">
		<input type="hidden" name="li_1_name" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>">
		<input type="hidden" name="li_1_tangible" value="N">
		<input type="hidden" name="li_1_quanity" value="1">
		<input type="hidden" name="li_1_startup_fee" value="0">
		<input type="hidden" name="li_1_type" value="product">
		<input type="hidden" name="li_1_recurrence" value="<?php echo $arrSubscription["billed"]; ?> Month">
		<input type="hidden" name="li_1_duration" value="Forever">
		<input type="image" src="../images/2checkout.gif" border="0" name="submit" >
		
		</form>

		<?php
		}
		
		///authorize.net
		if($website->GetParam("AUTHORIZE_ID")!="" && $website->GetParam("AUTHORIZE_KEY")!="")
		{
			?>
			<script>
			
			function SubmitPaymentForm(x)
			{
				if(x.CardNumber.value == "")
				{
					alert("The credit card number can not be empty!");			
					x.CardNumber.focus();
					return false;
				}

				if(x.FirstName.value == "")
				{
					alert("The first name can not be empty!");			
					x.FirstName.focus();
					return false;
				}
				
				if(x.LastName.value == "")
				{
					alert("The last name can not be empty!");			
					x.LastName.focus();
					return false;
				}		
			
				return true;
			}
			
			</script>
			
			
			<form action="index.php" method="post" onsubmit="return SubmitPaymentForm(this)">
			<input type="hidden" name="ProceedPurchase2" value="1">
			<input type="hidden" name="category" value="<?php echo $category;?>">
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			
			
			<i><?php echo $M_BILLING_INFORMATION;?></i>
			
			<br><br>
			<b>
					
						<table summary="" border="0" cellspacing="5" style="border-spacing:5px;border-collapse: separate;">
						<tr height="24">
							<td width="140"><b><?php echo $M_CREDIT_CARD;?>:</b></td>
							<td><input type="text" name="CardNumber" id="CardNumber" size="33" value=""></td>
						</tr>
						<tr height="24">
							<td><b><?php echo $M_EXP_DATE;?>:</b></td>
							<td>
							
							 <select name="month" id="hide">
									<option label="January" value="01">January</option>
									<option label="February" value="02">February</option>
									<option label="March" value="03">March</option>
									<option label="April" value="04">April</option>
									<option label="May" value="05">May</option>
									<option label="June" value="06">June</option>
									<option label="July" value="07">July</option>
									<option label="August" value="08">August</option>
									<option label="September" value="09">September</option>
									<option label="October" value="10">October</option>
									<option label="November" value="11">November</option>
									<option label="December" value="12">December</option>
							</select>
					
						  <select name="year" id="hide">
								
									
									<option label="2016" value="16">2016</option>
									<option label="2017" value="17">2017</option>
									<option label="2018" value="18">2018</option>
									<option label="2019" value="19">2019</option>
									<option label="2020" value="20">2020</option>
									<option label="2021" value="20">2021</option>
									<option label="2022" value="20">2022</option>
									<option label="2023" value="20">2023</option>
									<option label="2024" value="20">2024</option>
									<option label="2025" value="20">2025</option>
									<option label="2025" value="20">2026</option>
							</select>
							
							</td>
						</tr>
						<tr height="24">
							<td><b><?php echo $FIRST_NAME;?>:</b></td>
							<td><input type="text" name="FirstName" id="FirstName" size="33" value=""></td>
						</tr>
						<tr height="24">
							<td><b><?php echo $LAST_NAME;?>:</b></td>
							<td><input type="text" name="LastName" id="LastName" size="33" value=""></td>
						</tr>
						
						
						<tr height="24">
							<td><b><?php echo $M_ADDRESS;?>:</b></td>
							<td><textarea name="CustomerAddress" style="width:287px" rows="3" cols="30"><?php echo $arrUser["address"];?></textarea></td>
						</tr>
						
						
						<tr height="24">
							<td><b><?php echo $M_PHONE;?>:</b></td>
							<td><input type="text" name="Phone" size="33" value="<?php echo $arrUser["phone"];?>"></td>
						</tr>
						  <tr height="24">
							<td><b><?php echo $M_EMAIL;?>:</td>
							<td><input type="text" name="CustomerEmail" size="33" value="<?php echo $arrUser["username"];?>"></td>
						</tr>
					  </table>
					
							
							<br><br>
							
							<input type="submit" value=" <?php echo $M_CONTINUE;?> " class="btn btn-primary">
							
							</b>
							</form>
							<br><br>
		
			<?php
		}	
		///end authorize.net
		
		
		
		
		
		
		


		if(trim($website->GetParam("BANK_ACCOUNT"))!="")
		{
			echo "<br/>";
			echo "<h4>".nl2br(stripslashes($website->GetParam("BANK_ACCOUNT")))."</h4>";
		}

		if(trim($website->GetParam("CHEQUES_ADDRESS"))!="")
		{
			echo "<br/>";
			echo "<h4>".nl2br(stripslashes($website->GetParam("CHEQUES_ADDRESS")))."</h4>";
		}
	}
}
?>