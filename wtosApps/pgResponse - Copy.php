<?php
global $site, $os;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$success = true;
$error = "Payment Failed";
$razorpay_order_id = $_SESSION["razorpay_order_id"];
$school_setting_data=$os->school_setting();

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
echo $html;

// $subscription_details_q="SELECT * from subscription 
// where subscription_id>0 and subscription_id='$subscription_id' ORDER BY subscription_id desc";
// $subscription_details_mq=$os->mq($subscription_details_q);
$subscription_data=$os->rowByField('','subscription','subscription_id',$subscription_id,$where=" ",$orderby='');
// _d($subscription_data);
_d($subscription_data['sub_fees_details']);
 $sub_fees_details_a=json_decode($subscription_data['sub_fees_details'],true);
// _d($sub_fees_details_a);

$studentId=$subscription_data['studentId'];
$historyId=$subscription_data['historyId'];
$student_data=$os->rowByField('','student','studentId',$studentId,$where=" ",$orderby='');
$history_data=$os->rowByField('','history','historyId',$historyId,$where=" ",$orderby='');

?>
<script type="text/javascript">
	const subscription_print=()=>{
		$('.printBtn').hide();
		window.print();
		$('.printBtn').show();
	}
</script>
<div class="uk-text-center uk-margin"><input type="button" value=" Print " onclick="subscription_print();" class="uk-button uk-button-primary printBtn"/>&nbsp;&nbsp;<a href="<?echo $site['url']?>download-pdf" target="_blank"   class="uk-button uk-button-primary printBtn"/>Download Invoice</a> </div>

<link rel="stylesheet" type="text/css" href="<?= $site["themePath"]?>css/uikit.css">
<link rel="stylesheet" type="text/css" href="<?= $site["themePath"]?>css/common.css">
<style>
	*{
		font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif;
	}
	body{
		color: #111111;
	}
	.uk-card-outline{
		border:1px solid #e5e5e5;
	}
	.header-table{
		border-collapse: collapse;
		width: 100%;
	}
	.header-table > tr > td:nth-last-child(1){
		text-align: right;
	}
</style>

<div>
    <div class="header uk-background-primary uk-padding-small uk-text-center" style="background-color: #054b66;padding: 15px;">
        <img src="<? echo $site['url']?><? echo $school_setting_data['logoimage']?>" style="max-width: 130px"/>
    </div>

    <div class="uk-background-default uk-padding-small" style="padding: 15px;">
        <table class="uk-table uk-table-justify">
            <tr>
                <td class="uk-text-small">
                    <h5 class="uk-text-bold">Subscription</h5>
                    <p class="uk-margin-remove">Ref No: #<?= $subscription_data['subscription_id']?></p>
                    <p class="uk-margin-remove">Invoice Date: <?=$os->showDate($subscription_data['dated'])?></p>
                    <!-- <p class="uk-margin-remove">From: <?=$os->showDate($subscription_data['from_date'])?></p>
                    <p class="uk-margin-remove">To: <?=$os->showDate($subscription_data['to_date'])?></p> -->
                    <!-- <p class="uk-margin-remove">Class: <?=$os->classList[$history_data['class']]?></p> -->
                    <p class="uk-margin-remove">Session: <?=$history_data['asession']?></p>
                    <!-- <p class="uk-margin-remove">Duration: <?=$subscription_data['month_count']?> Month (s)</p> -->
                    <p class="uk-margin-remove">Status: <?= $subscription_data['payment_status']?$subscription_data['payment_status']:'Unpaid'?></p>


                    <h5 class="uk-text-bold">Bill To:</h5>
                    <p class="uk-margin-remove">Name : <?= $student_data['name']?></p>
                    <p class="uk-margin-remove">Mobile No : <?= $student_data['mobile_student']?></p>
                    <p class="uk-margin-remove">Class : <?= @$os->classList[$history_data['class']]?></p>
                </td>
                <td class="uk-table-shrink uk-text-small">
                    <h5 class="uk-text-bold uk-text-nowrap"><?= $school_setting_data["school_name"]?></h5>
                    <p class="uk-margin-remove"><?= $school_setting_data["address"]?></p>
                    <p class="uk-margin-remove uk-text-nowrap">Tel: <?= $school_setting_data["contact"]?></p>
                    <p class="uk-margin-remove uk-text-nowrap">Email : <?= $school_setting_data["email"]?></p>
                </td>
            </tr>
        </table>





        <h5 class="uk-text-bold">Details</h5>


        <div class="uk-card-outline">
            <table class="uk-table uk-table-small uk-table-divider uk-text-small uk-margin-remove">
                <thead>
                <tr class="uk-background-muted">
                    <!-- <th>#</th> -->
                    <td class="uk-text-nowrap uk-text-bold">Online Class</td>
                    <td class="uk-text-nowrap uk-text-bold">Online Exam</td>
                    <td class="uk-text-nowrap uk-text-bold uk-text-right uk-table-shrink">Total</td>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- <td><?php echo $subscription_details_c;?></td> -->
                        <td class="uk-text-nowrap"><?php echo $sub_fees_details_a['online_class']?$sub_fees_details_a['online_class']." INR":""; ?></td>
                        <td class="uk-text-nowrap"><?php echo $sub_fees_details_a['online_exam']?$sub_fees_details_a['online_exam']." INR":""; ?></td>
                        <td class="uk-text-nowrap uk-text-right uk-text-bold"><?= $sub_fees_details_a['online_class']+$sub_fees_details_a['online_exam']; ?> INR</td>
                    </tr>

                    <tr>
                        <td colspan="1"></td>
                        <td class="uk-text-nowrap uk-text-bold"> </td>
                        <td class="uk-text-nowrap uk-text-bold uk-text-right">Discount: <?=$sub_fees_details_a['full_package_discount']?> INR</td>
                    </tr>
                    <tr>
                        <td  colspan="1"></td>
                        <td class="uk-text-nowrap uk-text-bold"></td>
                        <td class="uk-text-nowrap uk-text-bold uk-text-right"> Total Amount: <?= $sub_fees_details_a['online_class']+$sub_fees_details_a['online_exam']-$sub_fees_details_a['full_package_discount']?> INR</td>
                    </tr>
                </tbody>
            </table>
        </div>



        <?if(!is_array($subscription_data)){ ?> 
            <div class="uk-text-center">No data available at the moment.</div>
        <? } ?>

    </div>

</div>