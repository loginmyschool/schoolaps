<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');
include($site['root-wtos'].'barCode.php');
$bCode=new wtbarcode;
$pluginName='';

$os->loadPluginConstant($pluginName);

include($site['root-wtos'].'admission_admin_function_helpers.php');

if($os->get('re_admission_admin')=='OK' && $os->post('re_admission_admin')=='OK')
{

 $asession=$os->post('asession');
 $classList_s=$os->post('classList_s');
 $studentId=$os->post('studentId');
 $historyId=$os->post('historyId');

echo '##--ADMISSION-FORM-page1--##';
form_RE_admission($asession, $classList_s,$studentId,$historyId);
echo '##--ADMISSION-FORM-page1--##';

echo '##--ADMISSION-FORM-page2--##';
//  echo 'not in use this section';
echo '##--ADMISSION-FORM-page2--##';


echo '##--ADMISSION-STUDENT-list--##';
  list_admission($asession, $classList_s);
echo '##--ADMISSION-STUDENT-list--##';

echo '##--meritlist-list-for-admission--##';
  list_re_admission_todo($asession, $classList_s);
echo '##--meritlist-list-for-admission--##';


exit();
}




if($os->get('payment_details')=='OK' && $os->post('payment_details')=='OK')
{


    $name = $os->post("name");
		$asession=$os->post('asession');
		$class=$classList_s=$os->post('classList_s');
		$student_type=$os->post('student_type');
		$admission_date=$os->post('admission_date');
		$vehicle_price=$os->post('vehicle_price');
		$vehicle_distance_id=$os->post('vehicle_distance_id');
		$vehicle_type_id=$os->post('vehicle_type_id');
		$vehicle=$os->post('vehicle');

		$discountTypeAdmission=$os->post('discountTypeAdmission');
		$discountValueAdmission=$os->post('discountValueAdmission');
		$discountTypeMonthly=$os->post('discountTypeMonthly');
		$discountValueMonthly=$os->post('discountValueMonthly');
		
		$donation=$os->post('donation');
		$donation_installment=$os->post('donation_installment');
		$donation_amount_paid=$os->post('donation_amount_paid');		 
		$pending_donation=$donation - $donation_amount_paid;
		

		$feesType='Readmission';
		$config_array=array();
		//  and student_type='$student_type'

		$config_array= getFeesConfig($asession,$class,$student_type);
		//$os->feesBoxDesign('Admission',$config_array['Admission']);


		$admissionFees=array_sum($config_array['Readmission']);
		$only_monthly_fees=array_sum($config_array['Monthly']);
		if($vehicle=='1'){ $config_array['Monthly']['Vehicle']=$vehicle_price;}
		$total_monthly_fees=array_sum($config_array['Monthly']); // no discount on vehicle

		$month_academic=$os->month_academic($asession,$class,$admission_date);


		 $discountAmount_admission=calculate_discount($discountTypeAdmission,$discountValueAdmission,$admissionFees);
		 $discountAmount_monthly=calculate_discount($discountTypeMonthly,$discountValueMonthly,$only_monthly_fees);


       
  

		//fees month calculation----
		$totalfees=$admissionFees-$discountAmount_admission;

		echo '##--PAYMENT-FORM--##';

		//$os->feesBoxDesign('Readmission',$config_array['Readmission']);
		//$os->feesBoxDesign('Monthly',$config_array['Monthly']);
?>

    <div style="position: sticky; top: 0; z-index: 2" class="p-s background-color-white border-none border-bottom-xxs border-color-light-grey">
        <div class="grid">
            <div class="grid-item p-s">
                <h1 style="font-size: 24px" class="text-xxl color-primary"><? echo $name;?></h1>
                <p >
                    Session : <? echo $asession;?>
                </p>
            </div>

            <div class="p-s grid-item" style="max-width: 170px;display:flex; align-items: center; justify-content: flex-end">
                <button type="button" class="material-button" onclick="step1();">
                    <i class="la la-arrow-left"></i>
                    <span>BACK</span>
                </button>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="grid-item p-m" style="max-width: 200px">

            <h3 class="p-s font-weight-m">Fees Structure</h3>
            <div style="max-height: 350px; overflow-y: auto">
                <h4 class="p-s">Admission</h4>
                <div class="p-s">
                    <? $os->feesBoxDesignForAdmission('Admission',$config_array['Admission']);?>
                </div>
                <h4 class="p-s">Monthly</h4>
                <div class="p-s">
                    <? $os->feesBoxDesignForAdmission('Monthly',$config_array['Monthly']); ?>
                </div>
            </div>

        </div>
        <div class="grid-item p-m" style="max-width: 280px">
            <h3 class="p-s font-weight-m">Monthly Fees</h3>
            <div   style="height: calc(100% - 40px); display: grid; grid-template-columns: repeat(2, auto); grid-template-rows: repeat(6, auto)" >

                <? foreach($month_academic as $key=>$val) {
                    $month=$val['month_str'];
                    $year=$val['year'];

                    ?>
                    <div class="p-s month-selector">
                        <label for="month<? echo $key ?>">
                            <input  type="checkbox" id="month<? echo $key ?>" value="<? echo $val['month_int'] ?>-<? echo $val['year'] ?>" name="month_academic[]" onchange="select_months_for_bill()"/>

                            <div class=" p-m">
                                <? echo  $month ?>, <? echo $year ?>
                                <span class="display-block color-primary m-top-s text-m">Rs. <? echo $total_monthly_fees; ?></span>
                            </div>

                        </label>
                    </div>

                <? } ?>
                <style>
                    .month-selector{

                        position: relative;
                    }
                    .month-selector input{
                        position: absolute;
                        bottom: 10px;
                        right: 10px;
                    }
                    .month-selector input::after{
                        content: '\f00c';
                        font-family: "Line Awesome Free";
                        font-weight: 900;
                        position: absolute;
                        top: 0;
                        right: 0;
                        height: calc(100% - 4px);
                        width: calc(100% - 4px);
                        background-color: white;
                        border:2px solid #666666;
                        font-size: var(--text-m);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: transparent;
                        border-radius: 3px;
                    }
                    .month-selector input:checked::after{
                        border:0px;
                        height: 100%;
                        width: 100%;
                        background-color: var(--color-primary);
                        color: white;
                    }
                    .month-selector input + div{
                        border: 1px solid #eeeeee;
                        background-color: #fafafa;
                        cursor: pointer;
                        font-weight: 600;
                        text-transform: uppercase;
                        font-size: var(--text-s)
                    }
                    .month-selector input + div:hover{
                        border: 1px solid #eeeeee;
                        background-color: #eeeeee;
                        cursor: pointer;
                    }
                    .month-selector input:checked + div{
                        border: 1px solid rgba(0,0,255,0.2);
                        background-color: rgba(0,0,255,0.2);
                    }
                </style>
            </div>
        </div>
        <div class="grid-item p-m" >
            <h3 class="p-s font-weight-m">Academic Information</h3>


            <div class="p-s">
                <table style="border-collapse: collapse; width: 100%" class="border-less-input-table">
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s color-deep-grey">Admission Fees</td>
                        <td class="p-top-s p-bottom-s  color-primary" colspan="2">
                            <input type="text" id="admission_fees_amount" value="<? echo $admissionFees; ?>"  readonly="readonly" class="color-primary full-width right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">- Admission Discount <? echo $discountValueAdmission  ?> <? echo $discountTypeAdmission  ?> </td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="admission_discount_amount" value="<? echo $discountAmount_admission; ?>"  readonly="readonly"  class="color-primary full-width right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey" style="display: none" id="total_monthly_row">
                        <td class="p-top-s p-bottom-s ">+ Monthly  <b> <? echo $only_monthly_fees; ?> x <span id="total_month_count"> </span> </b> </td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="monthly_total_fees_amount" readonly="readonly"  class="color-primary full-width right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey"  style="display: none"  id="total_monthly_discount_row">
                        <td class="p-top-s p-bottom-s ">- Monthly Discount <b><? echo $discountValueMonthly  ?> <? echo $discountTypeMonthly  ?> x <span id="total_month_count_discount"> </span> </b></td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="monthly_total_discount_amount" readonly="readonly"  class="color-primary right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">Total Payble</td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="totalfees" value="<? echo $totalfees; ?>" readonly="readonly"  class="color-primary full-width right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">Paid</td>
                        <td class="p-top-s p-bottom-s right" colspan="2">
                            <input type="text" id="paid_amount" style="width: 80px; border: 1px dashed #666666" class="font-weight-xxl text-l color-primary right border-xxs" placeholder="Paid" onkeyup="select_months_for_bill()"  />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">Due</td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="due_amount"  readonly="readonly"  value="<? echo $totalfees; ?>"   class="color-primary full-width right"  />
                        </td>
                    </tr>
                    <tr>
                        <td class="p-top-s p-bottom-s ">Payment Notes</td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="payment_note"  class="border-none font-weight-xxl full-width right" />
                        </td>
                    </tr>
					<tr class="border-none border-bottom-xxs border-color-light-grey"  style="<?php if ($donation>0){}else{ echo 'display:none;';  }?> " >
                        <td class="p-top-s p-bottom-s ">Donation payment if any<br /> Amount: <? echo $donation ?></td>
                        <td class="p-top-s p-bottom-s right" colspan="2">
                            <input type="text" id="donation_amount_paid" style="width: 80px; border: 1px dashed #666666" class="font-weight-xxl text-l color-primary right border-xxs" placeholder=""  />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="" >
                <div id="monthly_data" >
                    <input type="text" id="monthly_single_fees_amount" value="<? echo $total_monthly_fees; ?>" readonly="readonly" class="disabled_input" style="display:none;" />
                    <input type="text" id="monthly_single_discount_amount" value="<? echo $discountAmount_monthly; ?>"  readonly="readonly" class="disabled_input"  style="display:none;"  />
                </div>

                <span class="p-s" style="color: red"> You can add monthly fees with this transaction.</span>

                <span class="p-s display-inline-block">
                    <button id="admission_process_button" type="button" onclick="admission_process()" class="material-button big">Generate Receipt</button>
                </span>
                <div id="admission_process_DIV">
                    <!-- button link -->
                </div>
            </div>
        </div>
    </div>


<?

  echo '##--PAYMENT-FORM--##';




exit();
}



if($os->get('re_admission_process')=='OK' && $os->post('re_admission_process')=='OK')
{
	$paid_amount=$os->post('paid_amount');
	$studentId=$os->post('studentId');
    // payment-parameters---------------------------

	$discountTypeAdmission=$os->post('discountTypeAdmission');
	$discountValueAdmission=$os->post('discountValueAdmission');
	$discountTypeMonthly=$os->post('discountTypeMonthly');
	$discountValueMonthly=$os->post('discountValueMonthly');
	
	$donation=$os->post('donation');
	$donation_installment=$os->post('donation_installment');
	$donation_amount_paid=$os->post('donation_amount_paid'); 



	$month_academic_list_selected=$os->post('month_academic_list');
	$payment_note=$os->post('payment_note');
	$asession=$os->post('asession');
	$classList_s=$os->post('classList_s');

	$student_type=$os->post('student_type');
	$admission_date=$os->post('admission_date');
	$vehicle_price=$os->post('vehicle_price');
	$vehicle_distance_id=$os->post('vehicle_distance_id');
	$vehicle_type_id=$os->post('vehicle_type_id');
	$vehicle=$os->post('vehicle');
	if(!$vehicle)
	{
		$vehicle_price=0;
		$vehicle_distance_id=0;
		$vehicle_type_id='';

	}



	$building_name=$os->post('building_name');
	$floor_name=$os->post('floor_name');
	$room_name=$os->post('room_name');
	$bed_no=$os->post('bed_no');
	$hostel_room_id=$os->post('hostel_room_id');


	$class=$os->post('class');
	$admission_date=$os->saveDate($os->post('admission_date'));


 //------------HISTORY DATA------
	$dataToSave['discountTypeAdmission']=$discountTypeAdmission;
	$dataToSave['discountValueAdmission']=$discountValueAdmission;
	$dataToSave['discountTypeMonthly']=$discountTypeMonthly;
	$dataToSave['discountValueMonthly']=$discountValueMonthly;
	
	$dataToSave['donation']=$donation;
	$dataToSave['donation_installment']=$donation_installment;
	 
	
	
	$dataToSave['asession']=addslashes($os->post('asession'));

	$dataToSave['class']=addslashes($os->post('class'));
	$dataToSave['section']=addslashes($os->post('section'));
	$dataToSave['admission_date']=$os->saveDate($os->post('admission_date'));
	$dataToSave['roll_no']=addslashes($os->post('roll_no'));
	$dataToSave['board']=addslashes($os->post('board'));


	$dataToSave['stream']=addslashes($os->post('stream'));
	$dataToSave['admissionType']='Readmission';
	$dataToSave['student_type']=$student_type;
	$dataToSave['vehicle']=$vehicle;
	$dataToSave['vehicle_type_id']=$vehicle_type_id;
	$dataToSave['vehicle_distance_id']=$vehicle_distance_id;
	$dataToSave['vehicle_price']=$vehicle_price;
	$dataToSave['historyStatus']='Active';
	$dataToSave['building_name']=$building_name;
	$dataToSave['floor_name']=$floor_name;
	$dataToSave['room_name']=$room_name;
	$dataToSave['bed_no']=$bed_no;
	$dataToSave['hostel_room_id']=$hostel_room_id;
	$dataToSave['addedDate']=$os->now();
	$dataToSave['addedBy']=$os->userDetails['adminId'];
 //------------END HISTORY DATA------




	$hide_button='';
if( $paid_amount>0)
 {

	$filepath=$site['root'].'barCode/';
	//$bCode->barcode($studentId,$filepath);
	/// barcode 66677

	$dataToSave['studentId']=$studentId;
	$qResult=$os->save('history',$dataToSave,'historyId','');///    allowed char '\*#@/"~$^.,()|+_-=:��

	$historyId=$qResult;

 // get fees details
	$config_array= getFeesConfig($asession,$class,$student_type);
	$global_setting=getGlobalConfig($asession,$class);
	$hide_button='OK';
	$fees_student_id_array=  createFeesRecord($studentId,$historyId,$config_array,$global_setting,$feesType='Readmission',$month_academic_list_selected);
	$paymentData= createPayment($fees_student_id_array,$historyId,$studentId,$paid_amount,$payment_note);
	
	$fees_student_id_array_donation= createFeesRecord_donation($studentId,$historyId) ;
    $paymentData_donation= createPayment_donation($fees_student_id_array_donation,$historyId,$studentId,$donation_amount_paid,$payment_note='Donation-installment');

	}
	echo '##--admission_process--##';

	if( $paid_amount>0){

		?>  <div onclick="print_receipt_fees(<? echo $paymentData['fees_payment_id'] ?>,'')" style="padding:10px; background-color:#009900; color:#FFFFFF; cursor:pointer;"> <? echo $paymentData['receipt_no'] ?> |<? echo $os->showDate($paymentData['paidDate']) ?> |<? echo $paymentData['paidAmount'] ?></div>

		 
		<?
	}else
	{
	?>
		echo 'No payment enter. Please close and retry again.'; <div style="color:#000066;" class="close_registration_process" onclick="step1();re_admission_admin();"> Close </div>
	 <?
	}

if( $donation_amount_paid>0){ 

		?>  <div onclick="print_receipt_fees(<? echo $paymentData_donation['fees_payment_id'] ?>,'')" style="padding:10px; background-color:#009900; color:#FFFFFF; cursor:pointer;"> <? echo $paymentData_donation['receipt_no'] ?> |<? echo $os->showDate($paymentData_donation['paidDate']) ?> |<? echo $paymentData_donation['paidAmount'] ?></div>

		
		<?
	}
?>
  <div style="color:#000066;" class="close_registration_process" onclick="step1();admission_admin('');"> Close </div>
  <? 
	echo '##--admission_process--##';

	echo '##--admission_process_button--##';
	echo  $hide_button;
	echo '##--admission_process_button--##';


	echo '##--ADMISSION-STUDENT-list--##';
	list_admission($asession, $classList_s);
	echo '##--ADMISSION-STUDENT-list--##';
	
	echo '##--meritlist-list-for-readmission--##';
	list_re_admission_todo($asession, $classList_s);
	echo '##--meritlist-list-for-readmission--##';
	
	
	
	exit();
}

if($os->get('calculate_room_no')=='OK' && $os->post('calculate_room_no')=='OK')
{
	$asession=$os->post('asession');
	$class_id=$os->post('class_id');
	$section=$os->post('section');
	$roomdata=calculate_room_no_function($asession,$class_id,$section);
	
	$building_name=$roomdata['building_name'];
	$floor_name=$roomdata['floor_name'];
	$bed_no=$roomdata['bed_no'];
	$hostel_room_id=$roomdata['hostel_room_id'];

	echo '##--calculate_room-building_name--##'; echo $building_name;  echo '##--calculate_room-building_name--##';
	echo '##--calculate_room-floor_name--##'; echo $floor_name;  echo '##--calculate_room-floor_name--##';
	echo '##--calculate_room-room_name--##'; echo $room_name;  echo '##--calculate_room-room_name--##';
	echo '##--calculate_room-bed_no--##'; echo $bed_no;  echo '##--calculate_room-bed_no--##';
	echo '##--calculate_room-hostel_room_id--##'; echo $hostel_room_id;  echo '##--calculate_room-hostel_room_id--##';


}

if($os->get('calculate_room_no----------------------------not-in-use--------------')=='OK' && $os->post('calculate_room_no')=='OK')
{

	$building_name='';
	$floor_name='';
	$room_name='';
	$bed_no='';
	$hostel_room_id='';

	$total_bed_list_id=array();
	$used_bed_list_id=array();
	$remains_bed_list_id=array();

	$asession=$os->post('asession');
	$class_id=$os->post('class_id');
	$section=$os->post('section');

	 // get used bed list-- hostel_room_id

    $dataQuery="SELECT bed_no,hostel_room_id FROM `history` where class='$class_id' and  section LIKE '%$section%' and  asession ='$asession' ";
	$rsResults=$os->mq($dataQuery);


		while($record=$os->mfa( $rsResults))
		{
				$room_id=$record['hostel_room_id'];
				$bed=$record['bed_no'];
				$bed_key=$room_id.'-'.$bed;
				$used_bed_list_id[$bed_key]=$bed_key;


		}


	// get total bed list--
	$dataQuery="SELECT * FROM `room_setting` where class_id='$class_id' and  section LIKE '%$section%' ";
	$rsResults=$os->mq($dataQuery);


		while($record=$os->mfa( $rsResults))
		{

		$room_ids=explode(',',$record['room_name']);
		$bed_list=explode(',',$record['bed_list']);
		$room_ids=array_filter($room_ids);
			foreach($room_ids as $k=>$room_id)
			{
			 $beds=$bed_list[$k];
			 $bedA=explode('-',$beds);

					 foreach($bedA as $bed)
					 {
							$bed_key=$room_id.'-'.$bed;
							$total_bed_list_id[$bed_key]=$bed;
							if(!in_array($bed_key,$used_bed_list_id))
							{
							  $remains_bed_list_id[$bed_key]=$bed;
							}


					 }



			}


		}

  // take a value

  $key = key($remains_bed_list_id);



   if($key!='')
   {
		$roomdata= explode('-',$key);
		$hostel_room_id=$roomdata['0'];
		$bed_no=$roomdata['1'];

		$dataQuery="SELECT * FROM `hostel_room` WHERE `hostel_room_id` ='$hostel_room_id'";
		$rsResults=$os->mq($dataQuery);
		$roomDetails=$os->mfa($rsResults);

		$building_name=$roomDetails['building_name'];
		$floor_name=$roomDetails['floor_name'];
		$room_name=$roomDetails['room_name'];

		$hostel_room_id=$roomDetails['hostel_room_id'];

   }


echo '##--calculate_room-building_name--##'; echo $building_name;  echo '##--calculate_room-building_name--##';
echo '##--calculate_room-floor_name--##'; echo $floor_name;  echo '##--calculate_room-floor_name--##';
echo '##--calculate_room-room_name--##'; echo $room_name;  echo '##--calculate_room-room_name--##';
echo '##--calculate_room-bed_no--##'; echo $bed_no;  echo '##--calculate_room-bed_no--##';
echo '##--calculate_room-hostel_room_id--##'; echo $hostel_room_id;  echo '##--calculate_room-hostel_room_id--##';

exit();
}





