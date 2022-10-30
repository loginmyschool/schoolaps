<?php
global $site, $os;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$success = true;
$error = "Payment Failed";
$razorpay_order_id = $_SESSION["razorpay_order_id"];
if (empty($_POST['razorpay_payment_id']) === false)
{
	$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
	try
	{
		// Please note that the razorpay order ID must
		// come from a trusted source (session here, but
		// could be database or something else)
		$attributes = array(
			'razorpay_order_id' => $_SESSION['razorpay_order_id'],
			'razorpay_payment_id' => $_POST['razorpay_payment_id'],
			'razorpay_signature' => $_POST['razorpay_signature']
		);
		$api->utility->verifyPaymentSignature($attributes);
	}
	catch(SignatureVerificationError $e)
	{
		$success = false;
		$error = 'Razorpay Error : ' . $e->getMessage();
	}
	$order  = $api->order->fetch($razorpay_order_id);
	// _d($order);
}
$payment_status='';
if ($success === true)
{
	$html = "<h3 class='uk-text-success printBtn'>Your payment was successful.</h3>
	";
	$payment_status='Paid';

}
else
{
	$html = "<h3 class='uk-text-danger printBtn'>Your payment failed.</h3>
	";
	$payment_status='Unpaid';
}
if (isset($order)){
    $subscription_id =$_SESSION['paytm']['subscription_id'];     
    $os->set_paytm_msg($subscription_id,$order,$payment_status);
}
echo $html;?>

<script type="text/javascript">
	const subscription_print=()=>{
		$('.printBtn').hide();
		window.print();
		$('.printBtn').show();
	}
</script>
<div class="uk-text-center uk-margin"><input type="button" value=" Print " onclick="subscription_print();" class="uk-button uk-button-primary printBtn"/>&nbsp;&nbsp;<a href="<?echo $site['url']?>download-pdf" target="_blank"   class="uk-button uk-button-primary printBtn"/>Download Invoice</a> </div>


<?include('subscription_invoice.php');?>

