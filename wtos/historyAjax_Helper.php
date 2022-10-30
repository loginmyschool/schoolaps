<?
global $os;
if($os->get('bulkSchoolLeavingCertificate')=='OK' && $os->post('bulkSchoolLeavingCertificate')=='OK')
{

    echo 'WORK IN PROGRESS bulkSchoolLeavingCertificate';


    exit();
}

if($os->get('bulkReAdmission')=='OK' && $os->post('bulkReAdmission')=='OK')
{

    echo 'WORK IN PROGRESS bulkReAdmission';


    exit();
}
if($os->get('bulkAdmission')=='OK' && $os->post('bulkAdmission')=='OK')
{

    echo 'WORK IN PROGRESS bulkAdmission';


    exit();
}
if($os->get('bulkTransferCertificate')=='OK' && $os->post('bulkTransferCertificate')=='OK')
{

    echo 'WORK IN PROGRESS bulkTransferCertificate';


    exit();
}
if($os->get('bulkCharecterCertificate')=='OK' && $os->post('bulkCharecterCertificate')=='OK')
{

    echo 'WORK IN PROGRESS bulkCharecterCertificate';


    exit();
}
if($os->get('bulkFinalMarksheet')=='OK' && $os->post('bulkFinalMarksheet')=='OK')
{

    $andasession=  $os->postAndQuery('asession_s','asession','=');
    $andclass=  $os->postAndQuery('class_s','class','=');

    echo 'WORK IN PROGRESS bulkFinalMarksheet';


    exit();
}
if($os->get('get_class_exam')=='OK' && $os->post('get_class_exam')=='OK')
{

    $andasession=  $os->postAndQuery('asession_s','asession','=');
    $andclass=  $os->postAndQuery('class_s','class','=');

    $asession=$os->post('asession_s');
    $class=$os->post('class_s');

     $query="SELECT * FROM `exam` where  asession='$asession' and  class='$class'";
    $arr=array();

    $rsResults=$os->mq($query);
    while($record=$os->mfa( $rsResults))
    {
        $arr[$record['examId']]=$record['examTitle'];
    }
	
	 


    ?>
    <select name="examId" id="examId" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>

        <?   $os->onlyOption($arr);	?>

    </select>


    <br />

    <input type="button" onclick="PrintMarksheet('','historyIds[]','examId')" style="cursor:pointer" value=" Next >> "  />
    <?


    exit();
}
if($os->get('bulkClassCertificate')=='OK' && $os->post('bulkClassCertificate')=='OK')
{

    echo 'WORK IN PROGRESS bulkClassCertificate';


    exit();
}

if($os->get('bulkADmit')=='OK' && $os->post('bulkADmit')=='OK')
{

    echo 'WORK IN PROGRESS bulkADmit';
    exit();
}
if($os->get('student_fees')=='OK' && $os->post('student_fees')=='OK')
{

    $is_admission_fees_paid='NO';
    $historyId=$os->post('historyId');

    if(!$historyId){ echo 'Missing Student data ';exit();}



    $historyData=$os->rowByField('','history','historyId',$historyId);
    $history= $historyData;


    $feesData=$os->get_fees_alll($historyId);


    $admissionType=$history['admissionType']; // Admission/Readmission
    // $admissionType='Readmission';
    $vehicle=$history['vehicle'];
    $paymentData=$os->get_fees_payment_record($historyId);

    //$paymentData_array= $os->getArrayFromResource($paymentData);



    if(count($paymentData_array)>0){$is_admission_fees_paid='YES';}


    $asession=$historyData['asession'];
    $class=$historyData['class'];
    $student_type=$historyData['student_type'];
    //$donationFees=$history['donationFees'];// donationFees not in use
    $donation=$history['donation'];
    $discountTypeAdmission=$history['discountTypeAdmission'];
    $discountValueAdmission=$history['discountValueAdmission'];
    $discountTypeMonthly=$history['discountTypeMonthly'];
    $discountValueMonthly=$history['discountValueMonthly'];


    $donation_installment=$history['donation_installment'];


    $config_array=  getFeesConfig($asession,$class,$student_type);


    $admissionFees=0;
    if(isset($config_array[$admissionType]))
    {

        $admissionFees=array_sum($config_array[$admissionType]);
    }

    $only_monthly_fees=0;
    $total_monthly_fees=0;
    if(isset($config_array['Monthly']))
    {

        $only_monthly_fees=array_sum($config_array['Monthly']);
        if($vehicle=='1'){ $config_array['Monthly']['Vehicle']=$vehicle_price;}
        $total_monthly_fees=array_sum($config_array['Monthly']); // no discount on vehicle
    }



    $discountAmount_admission=calculate_discount($discountTypeAdmission,$discountValueAdmission,$admissionFees);
    $discountAmount_monthly=calculate_discount($discountTypeMonthly,$discountValueMonthly,$only_monthly_fees);

    $totalfees=0; // initial not need


    $admission_show='';
    if($is_admission_fees_paid=='YES')
    {
        $admissionFees=0;

        $admission_show='style="display:none;"';

    }


    $feesData2=$os->get_fees_alll($historyId);
    $kount=$os->getArrayFromResource($feesData2);




    echo '##--student_fees_result--##';
    if( count( $kount)) // fees created already
    {



        //$os->feesBoxDesign('Monthly',$config_array['Monthly']);
        ?>


        <div class="m-left-m border-xxs border-color-light-grey">
            <h3 class="p-m background-color-light-grey text-l">Fees Details</h3>
            <div class="uk-grid uk-grid-collapse" uk-grid>
                <div class="uk-width-auto">

                    <h4 class="p-m">Fees</h4>
                    <div id="student_fees_list_table_div" class="p-m p-top-none p-bottom-none">
                        <? student_fees_list_table($feesData); ?>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <h4 class="p-m">Payments</h4>
                    <div class="p-m p-top-none p-bottom-none">
                    <div id="fees_payment_list_table_div">
                        <?  fees_payment_list_table($paymentData);  ?>
                    </div>

                        

                         
                         
                    </div>



                    <input  type="hidden" id="historyId"value="<? echo $historyId; ?>"/>
                    <input  type="hidden" id="studentId"value="<? echo $historyData['studentId']; ?>"/>

                    <div id="payment_data_DIV"> </div>



                </div>
            </div>
        </div>


        <?




    } else{


        $asession=$history['asession'];
        $studentId=$history['studentId'];
        $classList_s=$history['class'];

        form_genarate_FEES($asession, $classList_s,$studentId,$historyId);





    }
    echo '##--student_fees_result--##';








    exit();
}
if($os->get('generate_receipt_for_fees_results')=='OK' && $os->post('generate_receipt_for_fees_results')=='OK')
{
    $paymentData['paidAmount']=0;
    $paid_amount=$os->post('paid_amount');

    if( $paid_amount>0)
    {
        $donation_amount_paid=$os->post('donation_amount_paid');
        $fees_student_ids=$os->post('fees_student_ids');
        if($fees_student_ids!='')
        {
            $historyId=$os->post('historyId');
            $studentId=$os->post('studentId');
            $fees_student_ids=$os->post('fees_student_ids');
            $payment_note=$os->post('payment_note');

            $fees_student_id_array=explode(',',$fees_student_ids);
            $fees_student_id_array=array_filter($fees_student_id_array);
            $paymentData= createPayment($fees_student_id_array,$historyId,$studentId,$paid_amount,$payment_note);
        }
        //$fees_student_id_array_donation= createFeesRecord_donation($studentId,$historyId) ;
        if($donation_amount_paid>0)
        {
            $fees_student_ids_donation=$os->post('fees_student_ids_donation');
            $fees_student_id_array_donation=explode(',',$fees_student_ids_donation);

            $paymentData_donation= createPayment_donation($fees_student_id_array_donation,$historyId,$studentId,$donation_amount_paid,$payment_note='Donation-installment');
        }


    }


    /// ///
    echo '##--payment_data--##';

    if( $paid_amount>0){

        ?>  <div onclick="print_receipt_fees(<? echo $paymentData['fees_payment_id'] ?>,'')" style="padding:10px; background-color:#009900; color:#FFFFFF; cursor:pointer;"> <? echo $paymentData['receipt_no'] ?> |<? echo $os->showDate($paymentData['paidDate']) ?> |<? echo $paymentData['paidAmount'] ?></div>


        <?
    }else
    {
        ?>
        No payment enter. Please close and retry again.  <div style="color:#000066;" class="close_registration_process" onclick="step1();admission_admin();"> Close </div>
        <?
    }

    if( $donation_amount_paid>0){

        ?>  <div onclick="print_receipt_fees(<? echo $paymentData_donation['fees_payment_id'] ?>,'')" style="padding:10px; background-color:#009900; color:#FFFFFF; cursor:pointer;"> <? echo $paymentData_donation['receipt_no'] ?> |<? echo $os->showDate($paymentData_donation['paidDate']) ?> |<? echo $paymentData_donation['paidAmount'] ?></div>


        <?
    }
    echo '##--payment_data--##';
    echo '##--student_fees_list_table_div--##';
    $feesData_rs=$os->get_fees_alll($historyId);
    student_fees_list_table($feesData_rs);
    echo '##--student_fees_list_table_div--##';
    echo '##--fees_payment_list_table_div--##';
    $paymentData_rs=$os->get_fees_payment_record($historyId);
    fees_payment_list_table($paymentData_rs);
    echo '##--fees_payment_list_table_div--##';


    exit();
}
if($os->get('student_results')=='OK' && $os->post('student_results')=='OK')
{

    $historyId=$os->post('historyId');
    if(!$historyId)
    { echo 'Missing Student data ';exit();}

    $resultsdetails_query="select * from  resultsdetails where  historyId='$historyId' ";

    $result_rs=$os->mq($resultsdetails_query);


    echo '##--student_results_result--##';

    $exam_data=array();

    while($data=$os->mfa($result_rs))
    {
        $key=$data['examTitle'] .' ' .$data['asession'];
        $exam_data[$key][$data['resultsdetailsId']]=$data;

    }

    // _d( $exam_data);

    foreach($exam_data as $key=> $val)
    {
        ?>
        <div class="exam_result_class">
            <h2 style="color:#0053A6;"> <? echo $key ?></h2>
            <table class="noBorder" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr class="borderTitle">
                    <td><b>Subject </b></td>
                    <td><b>Written </b></td>
                    <td><b>Viva</b></td>

                    <td><b>Practical</b></td>
                    <td><b>Total</b></td>
                    <td><b>Percentage</b></td>
                    <td><b>Grade</b></td>
                </tr>


                <?

                foreach($val as $key2=> $subject)
                {
                    ?>

                    <tr class="trListing">
                        <td><? echo $subject['subjectName']; ?> </td>
                        <td><? echo $subject['writtenMarks']; ?></td>

                        <td><? echo $subject['viva']; ?> </td>
                        <td><? echo $subject['practical']; ?> </td>
                        <td><? echo $subject['totalMarks']; ?> </td>
                        <td><? echo $subject['percentage']; ?> </td>
                        <td><? echo $subject['grade']; ?> </td>


                    </tr>


                    <?
                } ?>

                </tbody></table>
        </div>
        <?
    }
    echo '##--student_results_result--##';



    exit();
}
if($os->get('student_attendence')=='OK' && $os->post('student_attendence')=='OK')
{

    $historyId=$os->post('historyId');
    if(!$historyId)
    { echo 'Missing Student data ';exit();}


    $history=$os->rowByField('','history','historyId',$historyId);
    $asession=$history['asession'];
    $class=$history['class'];

    $query="select  * from attendance where  historyId='$historyId' and absent_present='P'";
    $query_rs=$os->mq($query);

    $data_grid=array();
    $subject_grid=array();
    $month_grid=array();
    while($data_att=$os->mfa($query_rs))
    {

        $month_year = date('Y-m',   strtotime($data_att['dated']) );
        $month = date('m',   strtotime($data_att['dated']) );
        $subjectId=$data_att['subjectId'];


        if(isset($data_grid[$month][$subjectId]))
        {
            $data_grid[$month][$subjectId]=$data_grid[$month][$subjectId]+1;
        }else
        {
            $data_grid[$month][$subjectId]=1;

        }

        $subject_grid[$subjectId]=$subjectId;
        $month_grid[$month_year]=$month;


    }




    $SubjectList= $os->getSubjectList($asession,$class);
    echo '##--student_attendence_result--##';


    if(count($data_grid)>0){

        ?>

        <table class="noBorder " cellspacing="0" cellpadding="0" border="0" title="attendance table">

            <tr class="borderTitle">
                <td>Subject</td>

                <? foreach($month_grid as $month){ ?>

                    <td><b>     <? echo  $os->feesMonth[(int)$month] ?> </b></td>
                <? } ?>


            </tr>




            <? foreach($subject_grid as $subjectId){ ?>

                <tr class="trListing">

                    <td><? echo $os->val($SubjectList,$subjectId);   ?></td>

                    <? foreach($month_grid as $month){

                        $att_count='';
                        if(isset($data_grid[$month][$subjectId]))
                        {
                            $att_count=$data_grid[$month][$subjectId];
                        }


                        ?>

                        <td><? echo  $att_count ?></td>
                    <? } ?>


                </tr>
            <? } ?>






        </table>
        <?
    }else{

        echo 'Attendance not entered for this session.';
    }
    echo '##--student_attendence_result--##';

    exit();
}
if($os->get('get_student_profile')=='OK' && $os->post('get_student_profile')=='OK'  )
{
    $historyId=$os->post('historyId');

    if($historyId>0)
    {
        $wheres=" where historyId='$historyId'";
    }
    $dataQuery=" select * from history  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record_1=$os->mfa( $rsResults);

    $record_1['admission_date']=$os->showDate($record_1['admission_date']);
    $record_1['outGoingTcDate']=$os->showDate($record_1['outGoingTcDate']);
    $record_1['inactiveDate']=$os->showDate($record_1['inactiveDate']);

    $studentId=$record_1['studentId'];
    $wheres=" where studentId='$studentId'";
    $dataQuery=" select * from student  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record_stu=$os->mfa( $rsResults);
    $record_stu['dob']=$os->showDate($record_stu['dob']);
    $record_stu['registerDate']=$os->showDate($record_stu['registerDate']);
    $record_stu['adhar_dob']=$os->showDate($record_stu['adhar_dob']);
    $record_stu['tc_date']=$os->showDate($record_stu['tc_date']);
    if($record_stu['image']!='')
    {
        $record_stu['image']=$site['url'].$record_stu['image'];
    }
    $record=array_merge($record_1,$record_stu);
    $record['image-barcode']=$site['url'].'barCode/'.$studentId.'-ean13.jpg';
	
	///// meta
	 
    $dataQuery=" select * from student_meta   where student_id='$studentId' ";
    $rsResults=$os->mq($dataQuery);
    $student_meta=$os->mfa( $rsResults);
	
	 

    echo '##--get_student_profile_data--##';
	
	
	
	?>
    <div>
        <div class="border-none background-color-light-grey p-m">
            <div class="uk-grid " uk-grid>
                <div class="uk-width-expand">
                    <h2 class="text-l" style=" color:#0080C0; font-weight:bold;">
                        <? echo $record['name'] ?>  
                    </h2>
					<h2 class="text-l" style="font-size:14px;">
                         [<? echo $record['registrationNo'] ?>]  <?php    echo $os->classList[$record['class']]; ?> -  <? echo $record['asession'] ?>
                    </h2>
                </div>
                <div class="uk-width-auto">
                    <span class="stdata_class_head">Id:  </span>
                    <span class="stdata_id"><? echo $record['studentId'] ?></span>
                </div>
            </div>
        </div>
        <div class="uk-grid uk-grid-collapse" uk-grid>
            <div class="uk-width-auto" >

                <div class="p-m">
                    <div>
                        <img src="<? echo $record['image'] ?>"    class=" uk-margin-small border-xxs border-color-grey  uk-border-rounded" style="height:130px; width: 130px; object-fit: cover; object-position: center"/><br>
                       <!-- <img src="<? echo $record['image-barcode'] ?>" style="width: 130px ; height:20px;"   />-->
                    </div>
                    <div class="text-s" style="width: 130px">
                        <div class="uk-grid uk-child-width-expand uk-grid-collapse">
                            <div class="color-deep-grey">
                                Class :
                                <span class="color-primary"><?php    echo $os->classList[$record['class']]; ?></span>
                            </div>
                            <div class="color-deep-grey uk-text-right">
                                Year  :
                                <span class="color-primary"><? echo $record['asession'] ?></span>
                            </div>
                        </div>
						<div class="uk-grid uk-child-width-expand uk-grid-collapse">
                            <div class="color-deep-grey">
                                Section :
                                <span class="color-primary"><?php    echo  $record['section'] ; ?></span>
                            </div>
                            <div class="color-deep-grey uk-text-right">
                                Roll  :
                                <span class="color-primary"><? echo $record['roll_no'] ?></span>
                            </div>
                        </div>
                    </div>
 
                </div>
            </div>
            <div class="uk-width-expand">
                <div class="p-m">
                    <b><? echo $record['name'] ?>   </b><br />
					Reg No : <? echo $record['registrationNo'] ?><br />
                   Dob:  <? echo $record['dob'] ?><br />
                    Mobile: <? echo $record['mobile_student'] ?><br /> 
					 Email: <? echo $record['email_student'] ?><br /> 
                    Father : <? echo $record['father_name'] ?><br />
					RFID : <? echo $record['rfid'] ?><br />
					
					 
                    <b>Address </b> <br />
                    <div class="address_stu">
                        <? echo $record['vill'] ?>, <? echo $record['po'] ?> <? echo $record['ps'] ?> <br />
                        <? echo $record['block'] ?>
                        <? echo $record['dist'] ?>, <? echo $record['pin'] ?>  <? echo $record['state'] ?> <br />
                        <br />
                    </div>
					Medium : <? echo $record['medium'] ?><br />
					Mother Tongue : <? echo $record['mother_tongue'] ?><br />
					APL/BPL : <? echo $record['apl_bpl'] ?><br />
					Nationality : <? echo $record['nationality'] ?><br />
					
					 
					 
                </div>
				
				
				
   
     
     
     
            </div>
        </div>
		
		<div class="uk-grid uk-grid-collapse" uk-grid>
		 <div class="uk-width-expand" >
		           
					
					<div class="p-m">
					
					<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="background-color:#FFFFFF; width:100%" >
   
  
						 
							<tr> 
							<td> Emergency  NO :</td>
							<td><span style="color:#FF0000; font-weight:bold;"><? echo $record['mobile_emergency'] ?> </span> </td>
							</tr>
							
							
							<tr> 
							<td> Caste:</td>
							<td><? echo $record['caste']; ?> </td>
							</tr>
							
							<tr> 
							<td> AADHAR NO :</td>
							<td><? echo $record['adhar_no']; ?> </td>
							</tr>
							
							<tr> 
							<td> Gurdian Email :</td>
							<td><? echo $record['email_guardian']; ?> </td>
							</tr>
							<tr> 
							<td> Gurdian Mobile :</td>
							<td><? echo $record['mobile_guardian']; ?> </td>
							</tr>
							<tr> 
							<td> Cast Certificate No :</td>
							<td><? echo $record['caste_cert_no']; ?> </td>
							</tr>
							<tr> 
							<td> Cert. Issue Auth. :</td>
							<td><? echo $record['cast_cert_issue_auth']; ?> </td>
							</tr>
							<tr> 
							<td> Cert Issue Date :</td>
							<td><? echo $record['cast_cert_issue_date']; ?> </td>
							</tr>
							<tr> 
							<td> Specially Challenge :</td>
							<td><? echo $record['disabled']; ?> </td>
							</tr>
							<tr> 
							<td> Description :</td>
							<td><? echo $record['disable_body_parts']; ?> </td>
							</tr>
							<tr> 
							<td> Percent :</td>
							<td><? echo $record['disable_percet']; ?> </td>
							</tr>
							<tr> 
							<td> Cert. No :</td>
							<td><? echo $record['disable_cert_no']; ?> </td>
							</tr>
							
							<tr> 
							<td> Issue Auth :</td>
							<td><? echo $record['disable_cert_issue_auth']; ?> </td>
							</tr>
							<tr> 
							<td> Issue Date :</td>
							<td><? echo $record['disable_cert_issue_date']; ?> </td>
							</tr>
							
							<tr> 
							<td> Kanyashree Type if applicable :</td>
							<td><? echo $record['kanyashree_type']; ?> </td>
							</tr>
							<tr> 
							<td> Kanyashree Id NO :</td>
							<td><? echo $record['kanyashree_ID_NO']; ?> </td>
							</tr>
							
						 
                </table>
					 
					 
                    
					 
					</div>
					 
                
				
				 
		</div>
		</div>
    </div>
    <?


    echo '##--get_student_profile_data--##';

    $Query="select * from history where historyId>0 and historyStatus='Active' and studentId='$studentId'";

    $result=$os->mq($Query);
    $record['image-barcode']=$site['url'].'barCode/'.$studentId.'-ean13.jpg';
    echo '##-HISTORY-LIST-CLASS-DATA-##';?>
    <div class="uk-grid uk-grid-collapse" uk-grid>
        <?php
        while($data=$os->mfa($result))
        {
            $class_year='class_year';
            if($historyId==$data['historyId'])
            {
                $class_year='color-primary background-color-white';
            }
            if(isset( $os->classList[$data['class']])){
                ?>

                <div class="">
                    <div class="p-m p-top-s p-bottom-s <?php echo $class_year;?> uk-text-center hover-background-color-light-grey pointable" onclick="get_student_profile('<? echo $data['historyId'];?>');">
                        <div class="text-xl"><?php    echo $os->classList[$data['class']]; ?> </div>
                        <div class="text-s"><?php echo $data['asession'];?></div>
                    </div>
                </div>

            <?php
            }
        }
        ?>
    </div>
    <?
    echo '##-HISTORY-LIST-CLASS-DATA-##';

    echo '##-STUDENT-DOCUMENTS-LINKS-##';
    ?>
    <div class="p-m background-color-light-grey uk-text-danger "> CLASS <?php if(isset($os->classList[$record_1['class']])){ echo $os->classList[$record_1['class']];}?>   [<?php echo $record_1['asession']; ?>]</div>

 <? if(false){ ?>
    <div class="p-s" >
        <div class="uk-grid uk-child-width-1-2 uk-grid-collapse" uk-grid>




            <div>
                <a class="p-s uk-display-block" onclick="student_fees('<? echo $historyId;?>')" >Fees </a>
            </div>
            <div >
                <a class="p-s uk-display-block" title="<? echo $historyId;?>" onclick=" student_edit_form('<? echo $historyId;?>');" > Edit Student  </a>
            </div>

            <div >
                <a class="p-s uk-display-block" onclick="student_results('<? echo $historyId;?>')" >Result </a>
            </div>
            <div >
                <a class="p-s uk-display-block" onclick="student_attendence('<? echo $historyId;?>')" > Attendence </a>
            </div>

            <div >
                <a class="p-s uk-display-block" onclick="student_icard_single('<? echo $historyId;?>')"> Icard</a>
            </div>


            <div >
                <a class="p-s uk-display-block" onclick="load_certificate('<? echo $historyId;?>','Charecter')"> Charecter Certificate </a></div>
            <div ><a class="p-s uk-display-block" onclick="load_certificate('<? echo $historyId;?>','School leaving')"> School Leaving Certificate </a></div>
            <div ><a class="p-s uk-display-block" onclick="load_certificate('<? echo $historyId;?>','Transfer')"> Transfer Certificate</a></div>

            <div ><a class="p-s uk-display-block" onclick="">   Certificate </a></div>
            <div ><a class="p-s uk-display-block" onclick="">  Marksheet </a></div>

        </div>
    </div>

    <?
	}

    echo '##-STUDENT-DOCUMENTS-LINKS-##';



    echo '##-student_data_form_DIV_ID_data-##';
    ?>
	
	<h3 class="p-m background-color-light-grey text-l head_stdetails"  >Addresses</h3>
	<div style="padding:10px;">
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="background-color:#FFFFFF; width:100%" >
  <tr class="trListing">
     
    <td colspan="2"> <b>Permanent Address </b></td>
     
    <td colspan="2"> <b>Correspondence Address</b></td>
     
  </tr>
  
  <tr>
     
    <td>Vill/Street</td>
    <td><? echo $record['vill'] ?> </td>
    <td>Vill/Street</td>
    <td><? echo $student_meta['corr_vill'] ?></td>
  </tr>
  
   <tr>
     
    <td>P.O.</td>
    <td><? echo $record['po'] ?></td>
    <td>P.O.</td>
    <td><? echo $student_meta['corr_po'] ?></td>
  </tr>
   <tr>
     
    <td>P.S.</td>
    <td><? echo $record['ps'] ?></td>
    <td>P.S.</td>
    <td><? echo $student_meta['corr_ps'] ?></td>
  </tr>
  <tr>
     
    <td>DIST</td>
    <td><? echo $record['dist'] ?></td>
    <td>DIST</td>
    <td><? echo $student_meta['corr__dist'] ?></td>
  </tr>
  
  <tr>
     
    <td>BLOCK</td>
    <td><? echo $record['block'] ?></td>
    <td>BLOCK</td>
    <td><? echo $student_meta['corr_block'] ?></td>
  </tr>
  
   <tr>
     
    <td>PIN</td>
    <td><? echo $record['pin'] ?></td>
    <td>PIN</td>
    <td><? echo $student_meta['corr_pin'] ?></td>
  </tr>
  
   <tr>
     
    <td>State</td>
    <td><? echo $record['state'] ?></td>
    <td>State</td>
    <td><? echo $student_meta['corr_state'] ?></td>
  </tr>
  
</table>
  
	</div>
	 
	 
	 <h3 class="p-m background-color-light-grey text-l head_stdetails"  >Gurdian Info</h3>
	<div style="padding:10px;">
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="background-color:#FFFFFF; width:100%" >
   
  
   <tr>
     
    <td> Father Name</td>
    <td><? echo $record['father_name'] ?> </td>
    <td> Mother Name</td>
    <td><? echo $record['mother_name'] ?></td>
  </tr>
  
  <tr>
     
    <td> Father Occupation</td>
    <td><? echo $record['father_ocu'] ?> </td>
    <td> Mother Occupation</td>
    <td><? echo $record['mother_ocu'] ?></td>
  </tr>
   <tr>
     
    <td> Father AADHAR</td>
    <td><? echo $student_meta['father_adhar'] ?> </td>
    <td> Mother AADHAR</td>
    <td><? echo $student_meta['mother_adhar'] ?></td>
  </tr>
  <tr>
     
    <td>Is Father Alive</td>
    <td><? echo $student_meta['is_father_alive'] ?> </td>
    <td>Is Mother Alive</td>
    <td><? echo $student_meta['is_mother_alive'] ?></td>
  </tr>
  
   <tr>
     
    <td>Father Date of Death</td>
    <td><? echo $student_meta['father_date_of_death'] ?></td>
    <td>Mother Date of Death</td>
    <td><? echo $student_meta['mother_date_of_death'] ?></td>
  </tr>
   <tr>
     
    <td>Father qualification</td>
    <td><? echo $student_meta['father_qualification'] ?></td>
    <td>Mother qualification</td>
    <td><? echo $student_meta['mother_qualification'] ?></td>
  </tr>
  <tr>
     
    <td>Father Monthly Income</td>
    <td><? echo $student_meta['father_monthly_income'] ?></td>
    <td>Mother Monthly Income</td>
    <td><? echo $student_meta['mother_monthly_income'] ?></td>
  </tr>
  
  <tr style="background-color:#DFDFFF">
     
    <td>Gurdian Qualification</td>
    <td><? echo $student_meta['gurdian_qualification'] ?></td>
    <td>Gurdian Monthly Income</td>
    <td><? echo $student_meta['gurdian_monthly_income'] ?></td>
  </tr>
  
  <tr style="background-color:#DFDFFF">
     
    <td>Gurdian Mobile</td>
    <td><? echo $student_meta['mobile_guardian'] ?></td>
    <td>Gurdian Email</td>
    <td><? echo $student_meta['email_guardian'] ?></td>
  </tr>
   
  
  
  
    
   
</table>

	</div>

 <h3 class="p-m background-color-light-grey text-l head_stdetails"  >SCHOOL   INFORMATION </h3>
	<div style="padding:10px;">	
	 
	<table class="uk-table congested-table uk-table-justify">
 <tbody> 

		 
		<tr><td colspan="5" style="font-weight:bold;">Previous / Last attend School Info </td> </tr>
		<tr><td>School Name  </td><td> <? echo $student_meta['last_school'] ?>    </td><td>Address </td><td> <? echo $student_meta['last_school_address'] ?>  </td>  </tr>  
		<tr><td>Last attendant Class  </td><td>  <? echo $student_meta['last_class'] ?>    </td><td>Session</td><td>  <? echo $student_meta['last_school_session'] ?>     </td>  </tr>  
		<tr><td>T.C No  </td><td> <? echo $student_meta['tc_no'] ?>    </td><td>Issue date of T.C </td><td> <? echo $student_meta['tc_date'] ?>     </td>  </tr>  
		<tr><td>Student ID No in T.C  </td><td>  <? echo $student_meta['student_id_in_TC'] ?>    </td><td>-</td><td> - </td>  </tr> 
		 
		 
		 
		 
		 
		<tr><td colspan="5" style="font-weight:bold;">Present School </td> </tr>
		<tr><td>Name of admitted School  </td><td> <? echo $student_meta['present_school'] ?>    </td><td>  </td><td>   </td>  </tr>  
		<tr><td>School Address </td><td><? echo $student_meta['present_school_address'] ?>      </td><td>School Phone No </td><td> <? echo $student_meta['present_school_contact'] ?>      </td>  </tr>  
		<tr><td>Admitted in class  </td><td> <? echo $student_meta['present_school_class'] ?>     </td><td>Admitted in session </td><td><? echo $student_meta['present_school_session'] ?>     </td>  </tr>  
		<tr><td>School Roll No   </td><td> <? echo $student_meta['present_school_roll'] ?>     </td><td>School Section </td><td> <? echo $student_meta['present_school_section'] ?>    </td>  </tr>  
		 
		
		        
   </tbody></table>
	</div>
	
 <h3 class="p-m background-color-light-grey text-l head_stdetails"  >Student Bank info</h3>
	<div style="padding:10px;"><table class="uk-table congested-table uk-table-justify">
 <tbody> 

		 
		 
		<tr><td>Name of the Bank  </td><td> <? echo $student_meta['bank_name'] ?>      </td><td>Bank Branch </td><td><? echo $student_meta['bank_branch'] ?>      </td>  </tr>      
		<tr><td>IFSC code   </td><td><? echo $student_meta['ifscCode'] ?>      </td><td>Account No  </td><td><? echo $student_meta['accNo'] ?>     </td>  </tr>  
		
		
		<tr><td colspan="5"> <h2> Kanyashree information (for female) </h2></td> </tr>

		 
		 
		<tr><td>Type  </td><td> <? echo $student_meta['kanyashree_type'] ?>    </td><td>ID No.  </td><td> <? echo $student_meta['kanyashree_ID_NO'] ?>     </td>  </tr>      
		     
		       
   </tbody></table>
	</div>
	
	 <h3 class="p-m background-color-light-grey text-l head_stdetails" style="display:none"  >BOARD EXAM INFORMATION </h3>
	<div style="padding:10px;"><table class="uk-table congested-table uk-table-justify" style="display:none">
 <tbody> 

		 
		<tr><td colspan="5" style="font-weight:bold;">10th Std. </td> </tr>
		<tr><td>Name of Board </td><td>  <? echo $student_meta['ten_name_of_board'] ?>  
		 
		
		 </td><td>Year of Passing</td><td> <? echo $student_meta['ten_passed_year'] ?>    </td>  </tr>     
		<tr><td>Roll </td><td><? echo $student_meta['ten_roll'] ?>     </td><td>No</td><td><? echo $student_meta['ten_no'] ?>     </td>  </tr>     
		<tr><td colspan="5">Mark Obtained </td> </tr>  
		<tr><td>Beng/Hindi </td><td><? echo $student_meta['ten_marks_beng_hindi'] ?>     </td><td>English</td><td> <? echo $student_meta['ten_marks_eng'] ?>     </td>  </tr>       
		<tr><td>Mathematics </td><td> <? echo $student_meta['ten_marks_math'] ?>     </td><td>Physical Science</td><td><? echo $student_meta['ten_marks_physc'] ?>     </td>  </tr>       
		<tr><td>Life Science </td><td><? echo $student_meta['ten_marks_lifesc'] ?>     </td><td>History</td><td> <? echo $student_meta['ten_marks_history'] ?>     </td>  </tr>       
		<tr><td>Geography </td><td> <? echo $student_meta['ten_marks_geography'] ?>     </td><td>Social Science</td><td> <? echo $student_meta['ten_marks_socialsc'] ?>    </td>  </tr>       
		<tr><td>Total Marks obt. </td><td> <? echo $student_meta['ten_marks_total_obt'] ?>     </td><td>out of</td><td><? echo $student_meta['ten_marks_out_of'] ?>     </td>  </tr>  
		<tr><td>Percentage </td><td> <? echo $student_meta['ten_marks_percent'] ?>     </td><td> -</td><td> - </td>  </tr>            
    
		 
		<tr><td colspan="5" style="font-weight:bold;">12th Std </td> </tr>
		<tr><td>Name of Board </td><td>  
		<? echo $student_meta['twelve_name_of_board'] ?>  
		 
		
		 </td><td>Year of Passing</td><td> <? echo $student_meta['twelve_passed_year'] ?>     </td>  </tr>     
		<tr><td>Roll </td><td> <? echo $student_meta['twelve_roll'] ?>    </td><td>No</td><td> <? echo $student_meta['twelve_no'] ?>      </td>  </tr>       
		<tr><td>Stream </td><td> 
		<? echo $student_meta['twelve_stream'] ?>   
		
		
		</td><td>-</td><td> - </td>  </tr>  
		
		 <tr><td colspan="5">Mark Obtained (For Sc. But other than sc Subjects should be blank for self written)  </td> </tr>    
		<tr><td>Beng/Hindi </td><td> <? echo $student_meta['twelve_marks_beng_hindi'] ?>     </td><td>English</td><td> <? echo $student_meta['twelve_marks_eng'] ?>     </td>  </tr>       
		<tr><td>Mathematics </td><td> <? echo $student_meta['twelve_marks_math'] ?>     </td><td>Physics</td><td><? echo $student_meta['twelve_marks_physc'] ?>    </td>  </tr>       
		<tr><td>Chemistry </td><td><? echo $student_meta['twelve_marks_chemistry'] ?>     </td><td>Biology</td><td> <? echo $student_meta['twelve_marks_chemistry'] ?>  </td>  </tr>       
		<tr><td>Total Marks obt. </td><td><? echo $student_meta['twelve_marks_total_obt'] ?>     </td><td>out of</td><td> <? echo $student_meta['twelve_marks_out_of'] ?>  </td>  </tr>            
   <tr><td>Percentage </td><td><? echo $student_meta['twelve_marks_percent'] ?>      </td><td>-</td><td> - </td>  </tr> 
   
      
  	 
   
   
   <tr><td colspan="5" style="font-weight:bold;">Graduate level (For Completive Exam) </td> </tr>
   
   <tr><td>Passed </td><td>  <? echo $student_meta['graduate_passed'] ?>  
    
   
  
   
    </td><td>If Passed with Hons. Subject</td><td> <? echo $student_meta['graduate_passed_subject'] ?>     </td>  </tr>  
   <tr><td>Year of Passing </td><td> <? echo $student_meta['graduate_passed_year'] ?>     </td><td>University</td><td> <? echo $student_meta['graduate_passed_university'] ?>     </td>  </tr>  
   <tr><td>Subjects Taken </td><td><? echo $student_meta['graduate_subjects'] ?>     </td><td>-</td><td> - </td>  </tr>  
   <tr><td>Marks obt. In final year </td><td><? echo $student_meta['graduate_subjects_marks'] ?>      </td><td>-</td><td> - </td>  </tr>  
   <tr><td>Total </td><td><? echo $student_meta['graduate_total_obt'] ?>      </td><td>Out of</td><td>  <? echo $student_meta['graduate_out_of'] ?>    </td>  </tr>  
   <tr><td>Percentage </td><td><? echo $student_meta['graduate_percent'] ?>     </td><td>-</td><td> - </td>  </tr>  
   
   </tbody></table>
	</div>
	
	 
   
		
		 

       
    
    
   
     
   
     
   
  
	
    
<? //  _d( $student_meta); _d($record) ;  ?>

 

<? 	$feesData=$os->get_fees_alll($historyId);
$paymentData=$os->get_fees_payment_record($historyId); ?>
    
	
	
	
	<h3 class="p-m background-color-light-grey text-l head_stdetails"  >Fees Details</h3>
            <div class="uk-grid uk-grid-collapse" uk-grid>
                <div class="uk-width-auto">

                    <h4 class="p-m">Fees</h4>
                    <div id="student_fees_list_table_div" class="p-m p-top-none p-bottom-none">
                        <? student_fees_list_table($feesData); ?>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <h4 class="p-m">Payments</h4>
                    <div class="p-m p-top-none p-bottom-none">
                    <div id="fees_payment_list_table_div">
                        <?  fees_payment_list_table($paymentData);  ?>
                    </div>

                        

                         
                         
                    </div>


 


                </div>
            </div>
    
	<h3 class="p-m background-color-light-grey text-l head_stdetails"  >Attendance Details</h3>
	<div style="padding:10px;">
	<? 
	
	
	
	 $history=$record;
    $asession=$history['asession'];
    $class=$history['class'];

    $query="select  * from attendance where  historyId='$historyId' and absent_present='P'";
    $query_rs=$os->mq($query);

    $data_grid=array();
    $subject_grid=array();
    $month_grid=array();
    while($data_att=$os->mfa($query_rs))
    {

        $month_year = date('Y-m',   strtotime($data_att['dated']) );
        $month = date('m',   strtotime($data_att['dated']) );
        $subjectId=$data_att['subjectId'];


        if(isset($data_grid[$month][$subjectId]))
        {
            $data_grid[$month][$subjectId]=$data_grid[$month][$subjectId]+1;
        }else
        {
            $data_grid[$month][$subjectId]=1;

        }

        $subject_grid[$subjectId]=$subjectId;
        $month_grid[$month_year]=$month;


    }




    $SubjectList= $os->getSubjectList($asession,$class);
     


    if(count($data_grid)>0){

        ?>

        <table class="noBorder " cellspacing="0" cellpadding="0" border="0" title="attendance table">

            <tr class="borderTitle">
                <td>Subject</td>

                <? foreach($month_grid as $month){ ?>

                    <td><b>     <? echo  $os->feesMonth[(int)$month] ?> </b></td>
                <? } ?>


            </tr>




            <? foreach($subject_grid as $subjectId){ ?>

                <tr class="trListing">

                    <td><? echo $os->val($SubjectList,$subjectId);   ?></td>

                    <? foreach($month_grid as $month){

                        $att_count='';
                        if(isset($data_grid[$month][$subjectId]))
                        {
                            $att_count=$data_grid[$month][$subjectId];
                        }


                        ?>

                        <td><? echo  $att_count ?></td>
                    <? } ?>


                </tr>
            <? } ?>






        </table>
        <?
    }else{

        echo 'Attendance not entered for this session.';
    }
	
	?>
	</div>
	<h3 class="p-m background-color-light-grey text-l head_stdetails"  >Result Details</h3>
	<div style="padding:10px;">
	<? 
	$resultsdetails_query="select * from  resultsdetails where  historyId='$historyId' ";

    $result_rs=$os->mq($resultsdetails_query);
 
    $exam_data=array();

    while($data=$os->mfa($result_rs))
    {
        $key=$data['examTitle'] .' ' .$data['asession'];
        $exam_data[$key][$data['resultsdetailsId']]=$data;

    }

    // _d( $exam_data);

    foreach($exam_data as $key=> $val)
    {
        ?>
        <div class="exam_result_class">
            <h2 style="color:#0053A6;"> <? echo $key ?></h2>
            <table class="noBorder" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr class="borderTitle">
                    <td><b>Subject </b></td>
                    <td><b>Written </b></td>
                    <td><b>Viva</b></td>

                    <td><b>Practical</b></td>
                    <td><b>Total</b></td>
                    <td><b>Percentage</b></td>
                    <td><b>Grade</b></td>
                </tr>


                <?

                foreach($val as $key2=> $subject)
                {
                    ?>

                    <tr class="trListing">
                        <td><? echo $subject['subjectName']; ?> </td>
                        <td><? echo $subject['writtenMarks']; ?></td>

                        <td><? echo $subject['viva']; ?> </td>
                        <td><? echo $subject['practical']; ?> </td>
                        <td><? echo $subject['totalMarks']; ?> </td>
                        <td><? echo $subject['percentage']; ?> </td>
                        <td><? echo $subject['grade']; ?> </td>


                    </tr>


                    <?
                } ?>

                </tbody></table>
        </div>
        <?
    }
	
	if(count($exam_data)==0)
	{
	  echo 'No result found';
	}
	
	?>
	</div>
	
	<? 
	
	
	
	
	 

    echo '##-student_data_form_DIV_ID_data-##';


    exit();
}
if($os->get('student_edit_form')=='OK' && $os->post('student_edit_form')=='OK')
{

    $historyId=$os->post('historyId');
    if(!$historyId)
    { echo 'Missing Student data ';exit();}

    $historyId=$os->post('historyId');

    if($historyId>0)
    {
        $wheres=" where historyId='$historyId'";
    }
    $dataQuery=" select * from history  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record_1=$os->mfa( $rsResults);


    $record_1['admission_date']=$os->showDate($record_1['admission_date']);
    $record_1['outGoingTcDate']=$os->showDate($record_1['outGoingTcDate']);
    $record_1['inactiveDate']=$os->showDate($record_1['inactiveDate']);

    $studentId=$record_1['studentId'];
    $wheres=" where studentId='$studentId'";
    $dataQuery=" select * from student  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record_stu=$os->mfa( $rsResults);
    $record_stu['dob']=$os->showDate($record_stu['dob']);
    $record_stu['registerDate']=$os->showDate($record_stu['registerDate']);
    $record_stu['adhar_dob']=$os->showDate($record_stu['adhar_dob']);
    $record_stu['tc_date']=$os->showDate($record_stu['tc_date']);
    if($record_stu['image']!='')
    {
        $record_stu['image']=$site['url'].$record_stu['image'];
    }

    $record=array_merge($record_1,$record_stu);
    $os->data=$record;



    echo '##--student_edit_form--##';
    ?>
    <div class="border-xxs border-color-light-grey m-left-m">
        <h3 class="text-l p-m background-color-light-grey">Edit Student Profile</h3>



        <div class="formDivButton uk-hidden">

            <span  class="ST_head"> Student Id: <input style="font-size:14px; color:#0099FF"   value="<? echo $os->getVal('uid'); ?>" type="text" name="uid" id="uid" class="textboxxx  fWidth ST_head_DATA " disabled /> </span>
            <span class="ST_head"> Name: <input value="<? echo $os->getVal('name'); ?>"  type="text" name="st_name_for_show" id="st_name_for_show" class="textboxxx  fWidth ST_head_DATA " style="width:280px;font-size:14px; color:#0099FF;"  /> </span>

            <input  type="hidden" id="historyId"value="<? echo $os->getVal('historyId'); ?>"/>
            <input  type="hidden" id="studentId"value="<? echo $os->getVal('studentId'); ?>"/>

        </div>

        <div class="uk-grid uk-grid-small uk-child-width-1-2" uk-grid="masonry: true">
            <div>

                <div class="p-s">
                    <img id="imagePreview" src="<?php echo $site['url-wtos'] ?>images/student_img.png" style="height: 80px" />
                    <input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
                    <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
                </div>
                <div class="p-s">
                    <table class="uk-margin-remove  uk-table  congested-table">
                        <tr >
                            <td>Name </td>
                            <td>
                                <input value="<? echo $os->getVal('name'); ?>"
                                       type="text" name="name" id="name"
                                       onkeyup="duplicateNameSearch();"
                                       class="uk-input uk-border-rounded congested-form "/>
                            </td>

                        </tr>
                        <tr >
                            <td>Admission Type </td>
                            <td >
                                <!--<input value="" type="text" name="admissionType" id="admissionType"  class="textboxxx  fWidth "/>-->
                                <select name="admissionType" id="admissionType"
                                        class="uk-select uk-border-rounded congested-form" ><?
                                    $os->onlyOption($os->admissionType ,$os->getVal('admissionType') );	?></select>
                            </td>
                        </tr>
                        <tr >
                            <td>Dob </td>
                            <td><input value="<? echo $os->getVal('dob'); ?>"
                                       type="text" name="dob" id="dob"
                                       class="wtDateClass uk-input uk-border-rounded uk-form-small congested-form"/></td>
                        </tr>
                        <tr >
                            <td>Gender </td>
                            <td>
                                <select name="gender" id="gender" class="uk-select uk-border-rounded congested-form " >
                                    <option value=""></option>
                                    <? $os->onlyOption($os->gender,$os->getVal('gender'));	?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <div class="p-s">
                <h5 class="p-s">Academic Details</h5>
                <table  class="uk-margin-remove  uk-table  congested-table">

                    <tr >
                        <td>Session </td>
                        <td>
                            <select name="asession" id="asession"
                                    class="uk-select uk-border-rounded uk-form-small congested-form " style="font-size: 14px; font-weight:bold;" >
                                <option value=""> </option>
                                <? $os->onlyOption($os->asession,$os->getVal('asession'));	?>
                            </select>

                            <select name="board" id="board" class="uk-select uk-border-rounded congested-form " style="display:none;" >
                                <option value=""> </option>	<?
                                $os->onlyOption($os->board,$os->getVal('board'));	?>
                            </select>
                        </td>
                        <td>Class</td>
                        <td>
                            <select name="class" id="class" class="uk-select uk-border-rounded uk-form-small congested-form" style="font-size:14px; font-weight:bold;" >
                                <option value=""> </option>
                                <? $os->onlyOption($os->classList,$os->getVal('class'));	?>
                            </select>
                        </td>
                    </tr>
                    <tr >
                        <td> Section</td>
                        <td>
                            <select name="section" id="section" class="uk-select uk-border-rounded uk-form-small congested-form" style="font-size:14px; font-weight:bold;" >
                                <option value=""> </option>
                                <? $os->onlyOption($os->section,$os->getVal('section'));	?>
                            </select>

                        </td>
                        <td>
                            Roll no
                        </td>
                        <td>
                            <input value="" type="text" name="roll_no" id="roll_no" class="uk-input uk-border-rounded uk-form-small congested-form"/>
                        </td>
                    </tr>


                    <tr>
                        <td> Stream </td>
                        <td colspan="3">
                            <select name="stream" id="stream" class="uk-select uk-border-rounded uk-form-small congested-form" style="font-size:14px; font-weight:bold;" >
                                <option value=""> </option>
                                <?  $os->onlyOption($os->stream);	?>
                            </select>
                        </td>


                    </tr>



                    <tr >
                        <td nowrap="">Admission Date </td>
                        <td colspan="3">
                            <input value="<? echo $os->getVal('admission_date'); ?>" type="text" name="admission_date" id="admission_date" class="wtDateClass uk-input uk-border-rounded uk-form-small congested-form"/>
                        </td>
                    </tr>


                    <tr >
                        <td>Aadhar No </td>
                        <td colspan="3"><input value="<? echo $os->getVal('adhar_no'); ?>" type="text" name="adhar_no" id="adhar_no" class="uk-input uk-border-rounded uk-form-small congested-form "/> </td>
                    </tr>

                    <tr>
                        <td> Note</td>
                        <td colspan="3"><input value="<? echo $os->getVal('remarks'); ?>" type="text"   name="remarks" id="remarks" class="uk-input uk-border-rounded uk-form-small congested-form" ></td>
                    </tr>


                </table>
                </div>
            </div>
            <div>
                <div class="p-s">
                    <h5 class="p-s">Address</h5>
                    <table  class=" uk-margin-remove  uk-table  congested-table">
                    <tr >
                        <td style="width:100px;">Father Name </td>
                        <td colspan="3"><input value="<? echo $os->getVal('father_name'); ?>" type="text" name="father_name" id="father_name" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr>
                    <tr >
                        <td>Mother Name </td>
                        <td colspan="3"><input value="<? echo $os->getVal('mother_name'); ?>" type="text" name="mother_name" id="mother_name" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr>
                    <tr >
                        <td>Guardian Name </td>
                        <td colspan="3"><input value="<? echo $os->getVal('guardian_name'); ?>" type="text" name="guardian_name" id="guardian_name" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr>				<tr >
                        <td>Father Ocu </td>
                        <td colspan="3"><input value="<? echo $os->getVal('father_ocu'); ?>" type="text" name="father_ocu" id="father_ocu" class="uk-input uk-border-rounded congested-form "/>
                        </td>
                    </tr>

                    <tr >
                        <td>Caste </td>
                        <td>
                            <select name="caste" id="caste" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                                $os->onlyOption($os->caste);	?></select>
                        <td>
                            APL/BPL
                        </td>
                        <td>
                            <select name="apl_bpl" id="apl_bpl" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                                $os->onlyOption($os->aplOrBpl);	?></select>
                        </td>
                    </tr>

                    <tr >
                        <td>Mobile Student </td>
                        <td colspan="3"><input value="<? echo $os->getVal('mobile_student'); ?>" type="text" name="mobile_student" id="mobile_student" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr>
                </table>
                </div>
            </div>
            <div>

                <div class="p-s">
                    <h5 class="p-s">Address</h5>
                    <table  class="uk-margin-remove  uk-table  congested-table">
                    <tr >
                        <td  style="width:100px;">Vill / Street </td>
                        <td><input value="<? echo $os->getVal('vill'); ?>" type="text" name="vill" id="vill" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr><tr >
                        <td>Po </td>
                        <td><input value="<? echo $os->getVal('po'); ?>" type="text" name="po" id="po" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr><tr >
                        <td>Ps </td>
                        <td><input value="<? echo $os->getVal('ps'); ?>" type="text" name="ps" id="ps" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr><tr >
                        <td>Dist </td>
                        <td><input value="<? echo $os->getVal('dist'); ?>" type="text" name="dist" id="dist" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr><tr >
                        <td>Block </td>
                        <td><input value="<? echo $os->getVal('block'); ?>" type="text" name="block" id="block" class="uk-input uk-border-rounded congested-form "/> </td>
                    </tr>
                    <tr >
                        <td>State </td>
                        <td><input value="<? echo $os->getVal('state'); ?>" type="text" name="state" id="state" class="uk-input uk-border-rounded congested-form " style="width:100px;"/> Pin <input value="<? echo $os->getVal('pin'); ?>" type="text" name="pin" id="pin" class="uk-input uk-border-rounded congested-form " style="width:60px;"/> </td>
                    </tr>
                    <tr>
                        <td colspan="2">

                        </td>
                    </tr>
                </table>
                </div>
            </div>
        </div>



        <div class="uk-width-expand">


            &nbsp;<? if($os->access('wtEdit')){ ?>
                <input class="uk-button uk-border-rounded   uk-button-small uk-theme-button" type="button" id="saveAndClose1" value="Save"  onclick="WT_historyEditAndSave('NO');" />
                <input class="uk-button uk-border-rounded   uk-button-small uk-theme-button" type="button" value="Save and Stay" id="saveAndStay1" onclick="WT_historyEditAndSave('OK');" />
            <? } ?>

            <span id="mobile_back_id">
                <button class="uk-modal-close uk-button uk-border-rounded   uk-button-small uk-theme-button" type="button">CANCEL</button>
            </span>
            <span id="spmorebutton" onclick="loadMoredata()" style="cursor:pointer; color:#FF3300; font-size:16px">More</span>
        </div>



        <div  style="display:none;"   id="MoreStudentData">

            <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"  >


                <tr >
                    <td>Subcast </td>
                    <td>

                        <select name="subcast" id="subcast" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->subcast);	?></select>	 </td>
                </tr>
                <tr >
                    <td>Adhar Name </td>
                    <td><input value="" type="text" name="adhar_name" id="adhar_name" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr>
                <tr >
                    <td>Adhar Dob </td>
                    <td><input value="" type="text" name="adhar_dob" id="adhar_dob" class="wtDateClass textbox
fWidth"/></td>
                </tr>






                <tr >
                    <td>PH </td>
                    <td>

                        <select name="ph" id="ph" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->yesno);	?></select>	 </td>
                </tr><tr >
                    <td>PH % </td>
                    <td><input value="" type="text" name="ph_percent" id="ph_percent" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>Disable </td>
                    <td>

                        <select name="disable" id="disable" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->yesno);	?></select>	 </td>
                </tr><tr >
                    <td>Disable % </td>
                    <td><input value="" type="text" name="disable_percent" id="disable_percent" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>


                <tr >
                    <td>Tc No </td>
                    <td><input value="" type="text" name="tc_no" id="tc_no" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>Tc Date </td>
                    <td><input value="" type="text" name="tc_date" id="tc_date" class="wtDateClass textbox fWidth"/></td>
                </tr>


                <tr >
                    <td>Full marks </td>
                    <td><input value="" type="text" name="full_marks" id="full_marks" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr><tr >
                    <td>Obtain marks </td>
                    <td><input value="" type="text" name="obtain_marks" id="obtain_marks" class="textboxxx  fWidth
"/> </td>
                </tr>

            </table>
            <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"   >

                <tr >
                    <td>Percentage </td>
                    <td><input value="" type="text" name="percentage" id="percentage" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr><tr >
                    <td>Pass </td>
                    <td>

                        <select name="pass_fail" id="pass_fail" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->pass_fail);	?></select>	 </td>
                </tr><tr >
                    <td>Grade </td>
                    <td><input value="" type="text" name="grade" id="grade" class="uk-input uk-border-rounded congested-form "/> </td>

                </tr>




                <tr >
                    <td>Note </td>
                    <td><textarea  name="studentRemarks" id="studentRemarks" ></textarea></td>

                </tr>








                <tr >
                    <td>age </td>
                    <td><input value="" type="text" name="age" id="age" class="uk-input uk-border-rounded congested-form "/>



                    </td>
                </tr>


                <tr >
                    <td>Email Student </td>
                    <td><input value="" type="text" name="email_student" id="email_student" class="textboxxx  fWidth
"/> </td>
                </tr>

                <tr >
                    <td>Fees Payment </td>
                    <td>
                        <select name="feesPayment" id="feesPayment" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->feesPayment);	?></select>	 </td>
                </tr>

                <tr >
                    <td>Religian </td>
                    <td><input value="" type="text" name="religian" id="religian" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>




                <tr style="display:none;">
                    <td>Students </td>
                    <td>
                        <input value="" type="" name="studentId" id="studentId" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr>







            </table>
            <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"   >

                <tr style="display:none" > <!-- session regiatration if any -->
                    <td>RegistrationNo </td>
                    <td><input value="" type="text" name="registrationNo" id="registrationNo" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>









                <tr >
                    <td>Admission Form No </td>
                    <td><input value="" type="text" name="admission_no" id="admission_no" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>






                <tr >
                    <td>Mobile Emergency </td>
                    <td><input value="" type="text" name="mobile_emergency" id="mobile_emergency" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>Email Guardian </td>
                    <td><input value="" type="text" name="email_guardian" id="email_guardian" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>Mother Tongue </td>
                    <td><input value="" type="text" name="mother_tongue" id="mother_tongue" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>
                <tr >
                    <td>Blood Group </td>
                    <td><input value="" type="text" name="blood_group" id="blood_group" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>


                <tr >
                    <td>Guardian Ocu </td>
                    <td><input value="" type="text" name="guardian_ocu" id="guardian_ocu" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>


                <tr >
                    <td>Father Adhar </td>
                    <td><input value="" type="text" name="father_adhar" id="father_adhar" class="textboxxx  fWidth"/> </td>
                </tr><tr >
                    <td>Mother Ocu </td>
                    <td><input value="" type="text" name="mother_ocu" id="mother_ocu" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr><tr >
                    <td>Mother Adhar </td>
                    <td><input value="" type="text" name="mother_adhar" id="mother_adhar" class="textboxxx  fWidth"/> </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable">
                <tr >
                    <td>Acc No</td>
                    <td><input value="" type="text" name="accNo" id="accNo" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>Acc Holder Name </td>
                    <td><input value="" type="text" name="accHolderName" id="accHolderName" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>IFSC Code </td>
                    <td><input value="" type="text" name="ifscCode" id="ifscCode" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>Branch </td>
                    <td><input value="" type="text" name="branch" id="branch" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>

                <tr >
                    <td>Outgoing TC No</td>
                    <td><input value="" type="text" name="outGoingTcNo" id="outGoingTcNo" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr>



                <tr >
                    <td>Outgoing TC Date</td>
                    <td><input value="" type="text" name="outGoingTcDate" id="outGoingTcDate" class="wtDateClass uk-input uk-border-rounded congested-form " style="width:81px;"/>Status

                        <select name="historyStatus" id="historyStatus" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->historyStatus,'Active');	?></select>

                    </td>
                </tr>





                <tr >
                    <td>In Active Date</td>
                    <td>
                        <input value="" type="text" name="inactiveDate" id="inactiveDate" class="wtDateClass uk-input uk-border-rounded congested-form " style="width:81px;"/>

                    </td>
                </tr>





            </table>
            <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"   >


                <tr >
                    <td>Guardian Relation </td>
                    <td><input value="" type="text" name="guardian_relation" id="guardian_relation" class="textboxxx fWidth "/> </td>
                </tr>


                <tr >
                    <td>Guardian Address </td>
                    <td><input value="" type="text" name="guardian_address" id="guardian_address" class="textboxxx
fWidth "/> </td>
                </tr>

                <tr >
                    <td>Anual Income </td>
                    <td><input value="" type="text" name="anual_income" id="anual_income" class="textboxxx  fWidth
"/> </td>
                </tr>
                <tr >
                    <td>Mobile Guardian </td>
                    <td><input value="" type="text" name="mobile_guardian" id="mobile_guardian" class="textboxxx
fWidth "/> </td>
                </tr>


                <tr >
                    <td>Other Religian </td>
                    <td><input value="" type="text" name="other_religian" id="other_religian" class="textboxxx fWidth
"/> </td>
                </tr>





                <tr >
                    <td>Register Date </td>
                    <td><input value="" type="text" name="registerDate" id="registerDate" class="wtDateClass textbox
fWidth"/></td>
                </tr><tr >
                    <td>Register No </td>
                    <td><input value="" type="text" name="registerNo" id="registerNo" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr>










                <tr >
                    <td>Minority </td>
                    <td>

                        <select name="minority" id="minority" class="uk-input uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->yesno);	?></select>	 </td>
                </tr>


                <tr >
                    <td>Kanyashree </td>
                    <td>
                        <select name="kanyashree" id="kanyashree" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->kanyashree);	?></select>	 </td>
                </tr>

                <tr >
                    <td>Yuvashree </td>
                    <td>
                        <select name="yuvashree" id="yuvashree" class="uk-select uk-border-rounded congested-form " ><option value=""> </option>	<?
                            $os->onlyOption($os->yuvashree);	?></select>	 </td>
                </tr>

                <tr >
                    <td>Last School </td>
                    <td><input value="" type="text" name="last_school" id="last_school" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr><tr >
                    <td>Last Class </td>
                    <td><input value="" type="text" name="last_class" id="last_class" class="uk-input uk-border-rounded congested-form "/>
                    </td>
                </tr>






                <tr>
                    <td colspan="2"><div class="formDivButton" style="margin-top:20px;display:none;">
                            <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_historyDeleteRowById('');" />	<? } ?>
                            &nbsp;&nbsp;
                            &nbsp; <input type="button" value="Home" onclick="javascript:window.location='';" />

                            &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save & Close"  onclick="WT_historyEditAndSave('NO');" /><? } ?>
                        </div></td>

                </tr>




            </table>
        </div>


    </div>
    <?
    echo '##--student_edit_form--##';

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
    $room_name=$roomdata['room_name'];

    echo '##--calculate_room-building_name--##'; echo $building_name;  echo '##--calculate_room-building_name--##';
    echo '##--calculate_room-floor_name--##'; echo $floor_name;  echo '##--calculate_room-floor_name--##';
    echo '##--calculate_room-room_name--##'; echo $room_name;  echo '##--calculate_room-room_name--##';
    echo '##--calculate_room-bed_no--##'; echo $bed_no;  echo '##--calculate_room-bed_no--##';
    echo '##--calculate_room-hostel_room_id--##'; echo $hostel_room_id;  echo '##--calculate_room-hostel_room_id--##';
    exit();

}
if($os->get('genarate_FEES_single_ajax')=='OK' && $os->post('genarate_FEES_single_ajax')=='OK')
{

    $historyId=$os->post('historyId');
    $history= $os->rowByField('','history',$fld='historyId',$historyId,$where="",$orderby='');

    $admission_date=$os->saveDate($os->post('admission_date'));
    $student_type=$os->post('student_type');
    $admissionType=$os->post('admissionType');

    $discountTypeAdmission=$os->post('discountTypeAdmission');
    $discountValueAdmission=$os->post('discountValueAdmission');
    $discountTypeMonthly=$os->post('discountTypeMonthly');
    $discountValueMonthly=$os->post('discountValueMonthly');

    $donation=$os->post('donation');
    $donation_installment=$os->post('donation_installment');
    $donation_amount_paid=$os->post('donation_amount_paid');


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


    $dataToSave['admissionType']=$admissionType;
    $dataToSave['student_type']=$student_type;
    $dataToSave['vehicle']=$vehicle;
    $dataToSave['vehicle_type_id']=$vehicle_type_id;
    $dataToSave['vehicle_distance_id']=$vehicle_distance_id;
    $dataToSave['vehicle_price']=$vehicle_price;
    $dataToSave['building_name']=$building_name;
    $dataToSave['floor_name']=$floor_name;
    $dataToSave['room_name']=$room_name;
    $dataToSave['bed_no']=$bed_no;
    $dataToSave['hostel_room_id']=$hostel_room_id;
    $dataToSave['discountTypeAdmission']=$discountTypeAdmission;
    $dataToSave['discountValueAdmission']=$discountValueAdmission;
    $dataToSave['discountTypeMonthly']=$discountTypeMonthly;
    $dataToSave['discountValueMonthly']=$discountValueMonthly;
    $dataToSave['donation']=$donation;
    $dataToSave['donation_installment']=$donation_installment;

    $qResult=$os->save('history',$dataToSave,'historyId',$historyId);




    $asession=$history['asession'];
    $class=$history['class'];
    $student_type=$history['student_type'];
    $config_array= getFeesConfig($asession,$class,$student_type);
    $global_setting=getGlobalConfig($asession,$class);
    $fees_student_id_array=  createFeesRecord($studentId,$historyId,$config_array,$global_setting,$feesType=$admissionType,$month_academic_list_selected);

    $genarate_FEES_done='';
    if($fees_student_id_array)
    {
        $genarate_FEES_done='OK';
    }


    echo '##--genarate_FEES_historyId--##';echo $historyId; echo '##--genarate_FEES_historyId--##';
    echo '##--genarate_FEES_done--##';echo $genarate_FEES_done; echo '##--genarate_FEES_done--##';


    exit();
}
if($os->get('student_icard_single')=='OK' && $os->post('student_icard_single')=='OK')
{
    include('templateClass.php');
    $template_class=new templateClass();
    $historyId=$os->post('historyId');
    if(!$historyId)
    { echo 'Missing Student data ';exit();
    }

    echo '##--student_icard_single_result--##';

    $history=$os->rowByField('','history','historyId',$historyId);
    $studentId=$history['studentId'];
    $student=$os->rowByField('','student','studentId',$studentId);

    $data['__barcode__']=$os->student_barcode_href($studentId);
    $data['__Image__']=$site['url'].$student['image'];
    $data['__Name__']=$student['name'];
    $data['__roll__']=$history['roll_no'];
    $data['__class__']=$history['class']." ".$history['section'] ." ".$history['asession'];
    $data['__DOB__']=$student['name'];
    $data['__Father__']=$student['father_name'];
    $data['__Mother__']=$student['mother_name'];
    $data['__PhoneNo__']=$student['mobile_student'];
    $data['__Address__']=$student['vill'].' '.$student['po'].' '.$student['ps'].' '.$student['dist'].' '.$student['block'];


    $data=$template_class->manage_default_value($data);
    echo  $template_class->render_icard($data,"");

    ?>
    <div class="student_docs_link_details"><a href="javascript:void();" onclick="openPrintId_single('<? echo $historyId;?>')"> PRINT</a></div>

    <?

    echo '##--student_icard_single_result--##';



    exit();
}
?>
