<?php
global $site, $os;
$subscription_id=isset($_SESSION['paytm']['subscription_id'])?$_SESSION['paytm']['subscription_id']:'';


if(!$subscription_id){
    die('Error:Something went wrong...');
}
$subscription_data=$os->rowByField('','subscription','subscription_id',$subscription_id,$where=" ",$orderby='');
$studentId=$subscription_data['studentId'];
$student_data=$os->rowByField('','student','studentId',$studentId,$where=" ",$orderby='');
$order_id = $subscription_data["subscription_id"];

//Razorpay Subscription
use Razorpay\Api\Api;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
$orderData = [
    'receipt'         => $studentId,
    'amount'          => $subscription_data['total_amount'] * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1,
    'notes' => [
        "subscription_id" =>$order_id
    ]
];
$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];
$_SESSION['razorpay_order_id'] = $razorpayOrderId;
$displayAmount = $amount = $orderData['amount'];
$checkout = 'automatic';
?>
<p class="uk-text-bold uk-text-warning">Dear <?= $student_data['name']?>,<!-- You have choose a course for <?=$subscription_data['month_count']?> months. From <?=$os->showDate($subscription_data['from_date'])?> to <?=$os->showDate($subscription_data['to_date'])?>. -->Please pay the amount of RS-<?=$subscription_data['total_amount']?></p>

<div class="uk-card uk-card-default uk-card-outline">
    <table class="uk-table uk-table-divider uk-margin-remove" >
        <tbody>
        <tr>

            <td><label>SUBSCRIPTION REFFERENCE NO:</label></td>
            <td><?=$order_id?></td>
        </tr>

        <tr>
            <td><label>Amount:</label></td>
            <td><?=$subscription_data['total_amount']?></td>
        </tr>
        <tr>
            <td>
                <button id="rzp-button1" class="uk-button uk-button-primary">Pay with Razorpay</button>&nbsp;&nbsp;&nbsp;
                <button  class="uk-button uk-button-danger" onclick="window.location.href='<?echo $site['url']?>my-subscription';">Back</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="<? echo $site['url'].'apply-confirmation'?>" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
    // Checkout details as a json
    var options = {
        "key":"<?= RAZORPAY_KEY_ID?>",
        "amount": <?= $amount?>,
        "name":"<?= $student_data["name"]?>",
        "description":"Subscription Payment",
        "prefill":{
            "name":"<?= $student_data["name"]?>",
            "email":"<?= $student_data["email_student"]?>",
            "contact":"<?= $student_data["mobile_student"]?>"
        },
        "notes":{
            "merchant_order_id":"<?= $order_id?>"
        },"theme":{
            "color":"#194C66"
        },
        "order_id":"<?= $razorpayOrderId?>",

    }

    /**
     * The entire list of Checkout fields is available at
     * https://docs.razorpay.com/docs/checkout-form#checkout-fields
     */
    options.handler = function (response){
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.razorpayform.submit();
    };

    // Boolean whether to show image inside a white frame. (default: true)
    options.theme.image_padding = false;

    options.modal = {
        ondismiss: function() {
            console.log("This code runs when the popup is closed");
        },
        // Boolean indicating whether pressing escape key
        // should close the checkout form. (default: true)
        escape: true,
        // Boolean indicating whether clicking translucent blank
        // space outside checkout form should close the form. (default: false)
        backdropclose: false
    };

    var rzp = new Razorpay(options);

    document.getElementById('rzp-button1').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
</script>

