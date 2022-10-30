<?php
global $os,$site,$session_selected;
$ajaxFilePath=$site['url'].'wtosApps/page_my_fees_ajax.php';

if(! $os->isLogin() )
{
    header("Location: ".$site['url']."login");
}else{

    $studentId=$os->userDetails['studentId'];
    $name=$os->userDetails['name'];
     
	$student_id=$studentId;
    $fees_student_id=array();
    $fees_array=array();

    $fees_student_details=array();
    $feesStudent=$os->get_fees_student('',"    studentId='$studentId'");
  //  $feesPayment=$os->get_fees_payment('',"    studentId='$studentId'");

    while( $fees =$os->mfa($feesStudent))
    {


        $fees_array[$fees['classId']][$fees['fees_student_id']] =$fees;
        $fees_student_id[$fees['fees_student_id']]=$fees['fees_student_id'];
    }
    $fees_student_id_str='';
    if(count($fees_student_id)>0)
    {
        $fees_student_id_str=implode(',',$fees_student_id);
        $fees_student_id_str_query=" and fees_student_id IN($fees_student_id_str)";

        $feesStudent_details=$os->get_fees_student_details('',"    studentId='$studentId' $fees_student_id_str_query ");

        while( $rec =$os->mfa($feesStudent_details))
        {

            $fees_student_details[$rec['fees_student_id']][$rec['fees_student_details_id']]=$rec;

        }

    }



    //_d($fees_array);

    //_d($fees_student_details);



    while( $payment =$os->mfa($feesPayment))
    {
         // _d($payment);


    }

    ?>
    <ul  uk-accordion>
        <?
        $c=0;
        foreach($fees_array as $class_id => $fees){ 
		
		 $history_id=0;
		
		 
		?>
            <li class="<?=$c==0?"uk-open":"" ?>">

                <a class="uk-accordion-title secondory-text-dark uk-text-bolder">
                    Class : <? echo $os->classList[$class_id]; ?>
                </a>

                <div class="uk-accordion-content ">
                    <div class="uk-overflow-auto">
					Background colour green indicates paid fees.
                            <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                                <thead>
                                <tr>
                                    <th>For</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th class="uk-hidden">Status</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <? foreach($fees as $fees_student_id => $fees_value){
								
								    $history_id=$fees_value['historyId'];
								
                                    $fees_value_month=str_pad($fees_value['month'], 2, "0", STR_PAD_LEFT);

                                    $ym=(int)$fees_value['year'].$fees_value_month;
                                    $cym=(int)date('Ym');
                                    $details=$os->val(  $fees_student_details,$fees_value['fees_student_id']);


                                    $show_pay_now_button = false;
                                    $rowcolor="background-color:#e6ffe6 ";
                                    if($fees_value['paymentStatus']!='paid')
                                    {

                                        $rowcolor="";
                                        $show_pay_now_button = true;
                                        if($ym<=$cym)
                                        {
                                            $show_pay_now_button = true;
                                            $rowcolor="background-color:#ffe3e3";

                                        }

                                    }
                                    ?>


                                    <tr  style="<?= $rowcolor;?>">
                                        <td class="uk-text-primary">
                                            <? if($fees_value['paymentStatus']!='paid'){?>
                                                <input class="uk-checkbox uk-margin-small-right" type="checkbox" name="totalPayble[]" value="<? echo $fees_value['totalPayble'] ?>"  />
                                            <? }else{?>
                                                <input class="uk-checkbox uk-margin-small-right" style="opacity: 0" type="checkbox"   />

                                            <? } ?>
                                            <? echo $fees_value['feesType'] ?>
                                            <span class="uk-hidden@s">
                                                for <? echo  $os->feesMonth[$fees_value['month']] ?>  <? echo $fees_value['year'] ?>
                                            </span>
                                        </td>
                                        <td nowrap="" class="uk-visible@s">
                                            <? echo  $os->feesMonth[$fees_value['month']] ?>  <? echo $fees_value['year'] ?>
                                        </td>
                                        <td class="uk-text-primary">
                                              <a class="uk-button uk-border-roundeduk-border-rounded uk-text-small  uk-button uk-border-roundeduk-border-rounded-secondary uk-border-rounded secondory-background secondory-background-hover uk-button uk-border-roundeduk-border-rounded-small" uk-toggle="target: #aa<? echo $fees_value['fees_student_id'] ?>" >₹<? echo $fees_value['totalPayble'] ?></a>
                                        </td>
                                        <td class="uk-hidden" nowrap="">
                                            <? echo $fees_value['paymentStatus'] ?>
                                            <div id="aa<? echo $fees_value['fees_student_id'] ?>" uk-modal>
                                                <div class="uk-modal-dialog uk-modal-body">



                                                    <? if($details){?>
                                                        <div class="uk-margin-small">
                                                            <h4>Amount details</h4>
                                                            <table class="uk-table uk-table-small uk-table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>For</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                                </thead>
                                                                <?
                                                                foreach($details as   $details_value){ ?>
                                                                    <tr>
                                                                        <td><? echo $details_value['fees_head'] ?></td>
                                                                        <td><? echo $details_value['amount'] ?></td>
                                                                    </tr>

                                                                <? } ?>
                                                            </table>
                                                        </div>
                                                    <? } ?>
                                                    <? if($fees_value['receipt_no'] ){ ?>
                                                        <div class="uk-margin-small">
                                                            <h4>Receipt details</h4>

                                                            <table class="uk-table uk-table-small uk-table-striped">

                                                                <tr>
                                                                    <td>Receipt No</td>
                                                                    <td><? echo $fees_value['receipt_no'] ?></td>
                                                                </tr>

                                                                
                                                            </table>

                                                        </div>
                                                    <? } ?>

                                                </div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        <a class="uk-button uk-border-roundeduk-border-rounded uk-button uk-border-roundeduk-border-rounded-secondary uk-border-rounded primary-background primary-background-hover uk-button uk-border-roundeduk-border-rounded-small" onclick="paynow()">Pay Now</a>
						
						
						
						  <div style="padding:5px; background-color:#008A23;  color:#FFFFFF; font-size:16px; font-weight:bold;">Payments Details</div> 			
			<div class="payment list " style="padding:5px; background-color:#DDFFDD; margin-bottom:10px;" >
		  <?  
		  $fees_payment_rs=$os->rowsByField('','fees_payment','historyId',$history_id);
	  ?>
		  <table   border="0" cellspacing="0" cellpadding="0">
							  <tr>
							  
							    <td style="width:100px;">Date</td>
								<td style="width:70px;">Amount</td>
								<td style="width:50px;">discount</td>
								<td style="width:80px;">Payble</td>
								<td style="width:50px;">Paid</td>
								<td style="width:100px;">Due Amt.</td>
								<td style="width:100px;">Receipt</td>
								 
								 
							  </tr>
							 
							 
				
				 <? 
				 
				  // _d($os->post());
				    
				   
				   
				    $total_paid=0;
				   
				  while($row=$os->mfa( $fees_payment_rs))
		                {
				 
				  $fees_student_id=$row['fees_student_id'];
				  
				   $total_paid=$total_paid + $row['paidAmount'];
				     
									 
				  ?>
				 
				 
				     <tr>
					 
								
					
								<td><? echo $os->showDate($row['paidDate']); ?></td>
								<td><? echo (int)$row['amount_total']; ?></td>
								<td><? echo (int)$row['special_discount']; ?></td>
								<td><? echo (int)$row['paybleAmount']; ?></td>
								<td><? echo (int)$row['paidAmount']; ?></td>
								<td><? echo (int)$row['currentDueAmount']; ?></td>
								 
								 
								<td><div style="cursor:pointer; font-weight:bold"  onclick="print_receipt_fees(<? echo $row['fees_payment_id'] ?>)"> <? echo $row['receipt_no']; ?> </div></td>
								  					 
							  </tr>
				
				<? 
				 }?>
				 
				  <tr style="background:#DDFFBB;">
					 
								
					
								<td> </td>
								<td> </td>
								<td> </td>
								<td> Total </td>
								<td><b><? echo (int)$total_paid; ?> </b> </td>
								<td> </td>
								 
								 
								<td> </td>
								 				 
							  </tr>
				 
							</table>
		
		
		</div>			
						
						
                    </div>

                </div>
				
					
		
				
				
				
				
            </li>
            <?
            $c++;
        }
        ?>
    </ul>
<? } ?>


<div id="paynow_DIV" style="display:none" title="PAY NOW">

    <div id="payment_process_div">

    </div>




</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    .class_id{ font-size:18px; font-weight:bold; padding:10px; background-color:#93C9FF; color:#0063C6; }
    .feesall{ font-size:14px; font-weight:normal; padding:10px; background-color:#F2F2F2; }
    .fees_value{ font-size:14px; font-weight:normal; padding:4px; cursor:pointer;border-bottom:1px solid #D7D7D7;  }
    .fees_value:hover{ background-color:#BBDDFF}
    .feesall_details{font-size:14px; font-weight:normal; padding:6px; background-color:#FFFFD2 }
    .feesall_details_value{font-size:11px; font-weight:normal; padding:2px;  }
</style>
<script>
    function paynow()
    {
        popDialog('paynow_DIV','Pay Now',{})
        paynow_form();

    }

    function paynow_form()
    {
        var formdata = new FormData();

        formdata.append('paynow_form','OK' );
        var url='<? echo $ajaxFilePath ?>?paynow_form=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage">  <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('paynow_form_result',url,formdata);

    }
    function paynow_form_result(data)
    {
        var result_val=getData(data,'##-paynow_form_result-##');
        os.setHtml('payment_process_div',result_val);

    }

    function paynow_continue()
    {
        var formdata = new FormData();
        var payment_method_selected=getValuesFromCheckedBox('payment_method[]');



        formdata.append('paynow_continue','OK' );
        formdata.append('payment_method_selected',payment_method_selected );
        var url='<? echo $ajaxFilePath ?>?paynow_continue=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage">  <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('paynow_continue_result',url,formdata);

    }
    function paynow_continue_result(data)
    {
        var result_val=getData(data,'##-paynow_process_result-##');
        os.setHtml('payment_process_div',result_val);




    }


</script>
