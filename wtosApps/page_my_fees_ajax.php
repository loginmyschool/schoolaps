<?php
session_start();

include('../wtosConfig.php'); // load configuration

include('os.php'); // load wtos Library

if($os->get('paynow_form')=='OK' && $os->post('paynow_form')=='OK'  )
{
echo "##-paynow_form_result-##";
?><div style="background:#FFFFFF">
  <input type="radio" name="payment_method[]"  value="cheque" /> Cheque <br />
  <input type="radio" name="payment_method[]" value="ourportal"  /> Online Transfer from our website <br />
  <input type="radio" name="payment_method[]" value="otherportal"  /> Online Transfer other website <br />
  <input type="radio" name="payment_method[]" value="Paytm"  /> Paytm <br />
  <input type="radio" name="payment_method[]" value="Other"  /> Other <br />
  <input type="button" value="Continue" onclick="paynow_continue();" />
  </div>
  <style>.ui-widget.ui-widget-content{ background-color:#FFFFFF;}
  </style>
<?
echo "##-paynow_form_result-##"; 
exit();
}


if($os->get('paynow_continue')=='OK' && $os->post('paynow_continue')=='OK'  )
{

$payment_method_selected=$os->post('payment_method_selected');
    $payment_method_selected=str_replace(',','',$payment_method_selected);
echo "##-paynow_process_result-##";

 
?>
   <? if($payment_method_selected=='cheque'  ||$payment_method_selected=='otherportal'  || $payment_method_selected=='Paytm'  || $payment_method_selected=='Other'     ){ ?>
   <strong>Please send us your Cheque/transaction Informations.</strong><br />
   Details<br />
   <textarea name="details"> </textarea>
   
    <br /> <br />Attachment<br />
  <input type="file" /> <br /> <br />
  <input type="button" value="Submit" />
  <br /> <br />
   
   <?  } ?>
    <? if($payment_method_selected=='ourportal'     ){ 
	
	?>
	<img src="<? echo $site['themePath'] ?>images/payment.png" />
	
	
	
	<?  } ?>
   
   
   
<?
echo "##-paynow_process_result-##"; 
exit();
}



