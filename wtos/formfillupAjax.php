<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
   // $os->loadPluginConstant($pluginName);
include($site['root-wtos'].'admission_admin_function_helpers.php');
?><?
if($os->get('view_form_fillup')=='OK'){
   $formfillup_id = $os->post('formfillup_id');
   $Query="select * from formfillup where formfillup_id>0 and formfillup_id='$formfillup_id' "; 
   $result=$os->mq($Query);
   $record=$os->mfa($result);
   $school_setting_q="select * from school_setting where school_setting_id>0 limit 1";
   $school_setting_mq=$os->mq($school_setting_q);
   $school_setting_data=$os->mfa($school_setting_mq);?>
   <div class="application_form" >
      <button type="button"  class="uk-button uk-button-primary" id="print_form" onclick="printById('forPrint');">Print</button>
      <button type="button" class="uk-button uk-button-danger" id="download_pdf"  href="javascript:void(0)">Download PDF</button>
      <div id="forPrint">
         <style>
            .confirmForm{ border:1px dotted #999999; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
            .confirmForm td{ border:1px dotted #999999; border-left:0px; border-top:0px; padding-left:4px; padding-top:2px; padding-bottom:2px;}
         </style>
         <table width="100%" border="0" cellspacing="0" cellpadding="1" class="confirmForm">
            <tr>
               <td valign="top" colspan="2"  >
                  <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:1px dotted #CCCCCC;;">
                     <tr>
                        <td valign="top">To <br />
                           <? echo $school_setting_data['school_name'];?><br />
                           <small><? echo $school_setting_data['address'];?></small><br />
                        </td>
                        <td width="200"> <img src="<? echo $site['url'].$school_setting_data['logoimage']?>" width="100" height="130" /> </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td>Application No : <? echo $record['formfillup_id']?></td>
               <td >Contact No : <b><? echo $record['mobile_student']?></b>   &nbsp; &nbsp; Email : <b><? echo $record['email_id']?></b></td>
            </tr>
            <tr>
               <td>Full Name</td>
               <td><b><? echo $record['name']?></b></td>
            </tr>
            <tr>
               <td>Date of Birth</td>
               <td><b><? echo $os->showDate($record['dob'])?></b> </td>
            </tr>
            <tr>
               <td>Gender</td>
               <td> <b><? echo $record['gender']?></b></td>
            </tr>
            <tr>
               <td>Caste</td>
               <td> <b><? echo $record['caste']?></b></td>
            </tr>
            <tr>
               <td>Student Type</td>
               <td><b><? echo $record['student_type']?></b></td>
            </tr>
            <tr>
               <td colspan="2">
                  <b>Father's Details</b><br />
                  <table width="99%" border="0" cellspacing="0" class="confirmForm">
                     <tr>
                        <td>Father's Name : <b><? echo $record['father_name']?></b></td>
                        <td>Father's Mobile No : <b><? echo $record['father_mobile']?></b></td>
                        <td colspan="2">Father's Occupation : <b><? echo $record['father_ocu']?></b></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="2">
                  <b>Mother's Details</b><br />
                  <table width="99%" border="0" cellspacing="0" class="confirmForm">
                     <tr>
                        <td>Mother's Name : <b><? echo $record['mother_name']?></b></td>
                        <td>Mother's Mobile No : <b><? echo $record['mother_mobile']?></b></td>
                        <td colspan="2">Mother's Occupation : <b><? echo $record['mother_occupation']?></b></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="2">
                  <b>Guardian's Details</b><br />
                  <table width="99%" border="0" cellspacing="0" class="confirmForm">
                     <tr>
                        <td>Guardian's Name : <b><? echo $record['guardian_name']?></b></td>
                        <td>Guardian's Mobile No : <b><? echo $record['guardian_mobile']?></b></td>
                        <td colspan="2">Guardian's Occupation : <b><? echo $record['guardian_occupation']?></b></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="2">
                  <b>Permanent Address</b><br />
                  <table width="99%" border="0" cellspacing="0" class="confirmForm">
                     <tr>
                        <td width="200">Village</td>
                        <td width="210"><b><? echo $record['permanent_village']?></b></td>
                        <td width="100">Post Office</td>
                        <td><b><? echo $record['permanent_post_office']?></b></td>
                     </tr>
                     <tr>
                        <td>Block/ Municipality</td>
                        <td><b><? echo $record['permanent_block']?></b></td>
                        <td>Police Station</td>
                        <td><b><? echo $record['permanent_police_station']?></b></td>
                     </tr>
                     <tr>
                        <td>District</td>
                        <td><b><? echo $record['permanent_district']?></b></td>
                        <td>State</td>
                        <td><b><? echo $record['permanent_state']?></b> &nbsp;      Pin:<b><? echo $record['permanent_pincode']?></b></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="2">
                  <b>Present Address</b><br />
                  <table width="99%" border="0" cellspacing="0" class="confirmForm">
                     <tr>
                        <td width="200">Village</td>
                        <td width="210"><b><? echo $record['vill']?></b></td>
                        <td width="100">Post Office</td>
                        <td><b><? echo $record['po']?></b></td>
                     </tr>
                     <tr>
                        <td>Block/ Municipality</td>
                        <td><b><? echo $record['block']?></b></td>
                        <td>Police Station</td>
                        <td><b><? echo $record['ps']?></b></td>
                     </tr>
                     <tr>
                        <td>District</td>
                        <td><b><? echo $record['dist']?></b></td>
                        <td>State</td>
                        <td><b><? echo $record['state']?></b>  &nbsp;   Pin:<b><? echo $record['pin']?></b> </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td valign="top"><b>10th Std. </b> <br />
                  Name of Board: <b><? echo $record['ten_name_of_board']?></b>   <br /> Year of Passing: <b><? echo $record['ten_passed_year']?></b>
               </td>
               <td>  <br />
                  Total Marks obt: <b><? echo $record['ten_marks_total_obt']?></b>  <br /> Percentage(%): <b><? echo $record['ten_marks_percent']?></b> 
                  <br />
               </td>
            </tr>
            <tr>
               <td valign="top" ><b>12th Std. </b> <br />
                  Name of Board: <b><? echo $record['twelve_name_of_board']?></b>  <br/> Year of Passing: <b><? echo $record['twelve_passed_year']?></b>
               </td>
               <td> <br />
                  Total Marks obt: <b><? echo $record['twelve_marks_total_obt']?></b><br/>  Percentage(%): <b><? echo $record['twelve_marks_percent']?></b> 
               </td>
            </tr>
            <tr style="display: none;">
               <td valign="top"><b>Graduate level. </b> <br />
                  Name of Board: <b><? echo $record['graduate_passed_university']?></b>   <br /> Year of Passing: <b><? echo $record['graduate_passed_year']?></b>  
               </td>
               <td><br />
                  Total Marks obt: <b><? echo $record['graduate_total_obt']?></b>  <br /> Percentage(%): <b><? echo $record['graduate_percent']?></b> 
                  <br />
               </td>
            </tr>
            <tr>
               <td colspan="3">
                  <b>Uploaded Documents :</b>
                  <?
                  $form_doc_q="select * FROM `formfillup_document` where formfillup_id='".$record['formfillup_id']."'";
                  $form_doc_mq=$os->mq($form_doc_q);
                  ?>
                  <ul>
                     <?while($form_doc_mfa=$os->mfa($form_doc_mq)){?>
                        <li><? echo $form_doc_mfa['title']?></li>
                        <?}?> 
                     </ul>
                  </td>
               </tr>
               <tr>
                  <td colspan="3">
                     I do hereby declare that : <br />
                     i) all the statements made in this application are true and correct. 
                  </td>
               </tr>
            </table>
         </div>
      </div>
      <?}
      if($os->get('WT_formfillupListing')=='OK'){
         $where='';
         $showPerPage= $os->post('showPerPage');
         $andform_for=  $os->postAndQuery('form_for_s','form_for','=');
         $andform_no=  $os->postAndQuery('form_no_s','form_no','=');
         $andyear=  $os->postAndQuery('year_s','year','=');
         $andclass_id=  $os->postAndQuery('class_id_s','class_id','=');
         $andname=  $os->postAndQuery('name_s','name','%');
         $andmobile_student=  $os->postAndQuery('mobile_student_s','mobile_student','%');
         $andform_status=  $os->postAndQuery('form_status_s','form_status','%');
         $andpayment_status=  $os->postAndQuery('payment_status_s','payment_status','=');
         $searchKey=$os->post('searchKey');
         if($searchKey!=''){
            $where ="and ( branch_id like '%$searchKey%' Or form_for like '%$searchKey%' Or form_no like '%$searchKey%' Or year like '%$searchKey%' Or class_id like '%$searchKey%' Or name like '%$searchKey%' Or mobile_student like '%$searchKey%' Or gender like '%$searchKey%' Or caste like '%$searchKey%' Or father_name like '%$searchKey%' Or father_ocu like '%$searchKey%' Or father_monthly_income like '%$searchKey%' Or vill like '%$searchKey%' Or po like '%$searchKey%' Or ps like '%$searchKey%' Or dist like '%$searchKey%' Or block like '%$searchKey%' Or pin like '%$searchKey%' Or state like '%$searchKey%' Or last_school like '%$searchKey%' Or last_class like '%$searchKey%' Or last_school_session like '%$searchKey%' Or last_school_address like '%$searchKey%' Or subject_marks_data like '%$searchKey%' Or fees_structure like '%$searchKey%' Or form_status like '%$searchKey%' Or form_status_by like '%$searchKey%' Or amount like '%$searchKey%' Or payment_status like '%$searchKey%' Or payment_details like '%$searchKey%' )";

         }

         $listingQuery="  select * from formfillup where formfillup_id>0   $where $andform_for  $andform_no  $andyear  $andclass_id  $andname  $andmobile_student    $andform_status  $andpayment_status   order by formfillup_id desc";

         $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
         $rsRecords=$resource['resource'];
         $admin_q="SELECT * FROM admin where adminId>0 ORDER BY adminId desc";
         $admin_mq=$os->mq($admin_q);
         $admin_a=array();
         while($admin_res=$os->mfa($admin_mq)){
            $admin_a[$admin_res['adminId']]=$admin_res['name'];
         }


         ?>
         <div class="listingRecords">
            <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
            <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
               <tr class="borderTitle" >
                  <td >#</td>
                  <td ><b>Action</b></td>
                  <td ><b>Application No</b></td>
                  <td ><b>Name</b></td>
                  <td ><b>Mobile No</b></td>
                  <td ><b>Year</b></td>
                  <td ><b>Class</b></td>
                  <td ><b>Father name</b></td>
                  <td ><b>Student Type</b></td>
                  <td ><b>Form status</b></td>
                  <td><b>Fees Setting</b></td>
               </tr>
               <?php
               $serial=$os->val($resource,'serial');  

               while($record=$os->mfa( $rsRecords)){ 
                  $serial++;
                  ?>
                  <tr class="trListing">
                     <td><?php echo $serial; ?>     </td>
                     <td class="uk-text-nowrap"> 
                        <? if($os->access('wtView')){ ?>                   
                           <span uk-tooltip="title:Edit; delay: 100" class="uk-hidden">
                              <a class="uk-text-primary" href="javascript:void(0)"  onclick="WT_formfillupGetById('<? echo $record['formfillup_id'];?>')"  uk-icon="icon: file-edit"></a>
                           </span>
                           <? } ?>&nbsp;&nbsp;
                           <span uk-tooltip="title:View; delay: 100">
                              <a class="uk-text-success" href="javascript:void(0)"  onclick="view_form_fillup('<? echo $record['formfillup_id'];?>' );os.setAsCurrentRecords(this);" uk-icon="icon:file-text"></a>
                           </span>&nbsp;&nbsp;
                           <span uk-tooltip="title:Status History; delay: 100">
                              <a class="uk-text-warning" href="javascript:void(0)" onclick="view_history('<?echo $record['formfillup_id']?>')" uk-icon="icon: history"></a>
                           </span>
                        </td>
                        <td><?php echo $record['formfillup_id']?> </td>
                        <td class=" uk-text-normal uk-text-nowrap" style="font-size: 13px;color:black;font-weight: bold"><?php echo $record['name']?></td>
                        <td><?php echo $record['mobile_student']?> </td>
                        <td><?php echo $record['year']?> </td>
                        <td><?php echo $record['class_id']?> </td>
                        <td><?php echo $record['father_name']?> </td>
                        <td><?php echo $record['student_type']?> </td>
                        <td >
                           <select  name="form_status" id="form_status"  class="editSelect uk-select uk-text-emphasis" onchange="change_form_status('<?echo $record['formfillup_id']?>','<? echo $record['form_status']?>',this.value)"  style="width:100px;background-color:#<? echo $os->val($record['form_status'], $os->form_status_color);?>">
                              <? $os->onlyOption($os->form_status,$record['form_status']);   ?>
                           </td>
                           <td> 
                              <? if($record['form_status']=='new' || $record['form_status']=='waiting' || $record['form_status']=='approved'  ){ ?>
                                 <a  title="Fees seeting"  href="javascript:void(0)"  onclick="student_fees_setting('<? echo $record['formfillup_id'];?>','')" uk-icon="icon:file-text"></a>     <?  } ?> 
                                 <? if($record['form_status']=='approved'){ ?>
                                    <a  title="Admission"  href="javascript:void(0)"  onclick="student_admission_from_formfillup('<? echo $record['formfillup_id'];?>','')" uk-icon="icon:file-text"></a> 
                                 <?  } ?>  
                              </td>
                           </tr>
                        <? } ?>  
                     </table>
                  </div>
                  <br />
                  <?php 
                  exit();

               }






               if($os->get('WT_formfillupEditAndSave')=='OK')
               {
                  $formfillup_id=$os->post('formfillup_id');



                  $dataToSave['branch_id']=addslashes($os->post('branch_id')); 
                  $dataToSave['form_for']=addslashes($os->post('form_for')); 
                  $dataToSave['form_no']=addslashes($os->post('form_no')); 
                  $dataToSave['year']=addslashes($os->post('year')); 
                  $dataToSave['class_id']=addslashes($os->post('class_id')); 
                  $dataToSave['name']=addslashes($os->post('name')); 
                  $dataToSave['mobile_student']=addslashes($os->post('mobile_student')); 
                  $profile_picture=$os->UploadPhoto('profile_picture',$site['root'].'wtos-images');
                  if($profile_picture!=''){
                     $dataToSave['profile_picture']='wtos-images/'.$profile_picture;}
                     $dataToSave['dob']=$os->saveDate($os->post('dob')); 
                     $dataToSave['gender']=addslashes($os->post('gender')); 
                     $dataToSave['caste']=addslashes($os->post('caste')); 
                     $dataToSave['father_name']=addslashes($os->post('father_name')); 
                     $dataToSave['father_ocu']=addslashes($os->post('father_ocu')); 
                     $dataToSave['father_monthly_income']=addslashes($os->post('father_monthly_income')); 
                     $dataToSave['vill']=addslashes($os->post('vill')); 
                     $dataToSave['po']=addslashes($os->post('po')); 
                     $dataToSave['ps']=addslashes($os->post('ps')); 
                     $dataToSave['dist']=addslashes($os->post('dist')); 
                     $dataToSave['block']=addslashes($os->post('block')); 
                     $dataToSave['pin']=addslashes($os->post('pin')); 
                     $dataToSave['state']=addslashes($os->post('state')); 
                     $dataToSave['last_school']=addslashes($os->post('last_school')); 
                     $dataToSave['last_class']=addslashes($os->post('last_class')); 
                     $dataToSave['last_school_session']=addslashes($os->post('last_school_session')); 
                     $dataToSave['last_school_address']=addslashes($os->post('last_school_address')); 
                     $dataToSave['subject_marks_data']=addslashes($os->post('subject_marks_data')); 
                     $dataToSave['form_fill_date']=$os->saveDate($os->post('form_fill_date')); 
                     $dataToSave['fees_structure']=addslashes($os->post('fees_structure')); 
                     $dataToSave['form_status']=addslashes($os->post('form_status')); 
                     $dataToSave['form_status_dated']=$os->saveDate($os->post('form_status_dated')); 
                     $dataToSave['form_status_by']=addslashes($os->post('form_status_by')); 
                     $dataToSave['amount']=addslashes($os->post('amount')); 
                     $dataToSave['payment_status']=addslashes($os->post('payment_status')); 
                     $dataToSave['payment_details']=addslashes($os->post('payment_details')); 
                     $dataToSave['modifyDate']=$os->now();
                     $dataToSave['modifyBy']=$os->userDetails['adminId'];
                     if($formfillup_id < 1){
                        $dataToSave['addedDate']=$os->now();
                        $dataToSave['addedBy']=$os->userDetails['adminId'];
                     }


         $qResult=$os->save('formfillup',$dataToSave,'formfillup_id',$formfillup_id);///    allowed char '\*#@/"~$^.,()|+_-=:££  
         if($qResult)  
         {
            if($formfillup_id>0 ){ $mgs= " Data updated Successfully";}
            if($formfillup_id<1 ){ $mgs= " Data Added Successfully"; $formfillup_id=  $qResult;}
            $mgs=$formfillup_id."#-#".$mgs;
            $document_a=$os->post('doc');
            if(is_array($document_a)&&count($document_a)>0){
               $dataToSave3['dated']=$os->now();
               $dataToSave3['formfillup_id']=$formfillup_id;            
               $dataToSave3['doc_type']='Form Fillup Document';
               foreach ($document_a as  $value) {
                  $dataToSave3['doc_link']=$value['doc_url'];
                  $dataToSave3['title']=$value['doc_title'];
                  $os->save("formfillup_document", $dataToSave3);

               }
            }
         }
         else
         {
            $mgs="Error#-#Problem Saving Data.";

         }
   //_d($dataToSave);
         echo $mgs;     

         exit();

      } 

      if($os->get('WT_formfillupGetById')=='OK')
      {
         $formfillup_id=$os->post('formfillup_id');

         if($formfillup_id>0) 
         {
            $wheres=" where formfillup_id='$formfillup_id'";
         }
         $dataQuery=" select * from formfillup  $wheres ";
         $rsResults=$os->mq($dataQuery);
         $record=$os->mfa( $rsResults);


         $record['branch_id']=$record['branch_id'];
         $record['form_for']=$record['form_for'];
         $record['form_no']=$record['form_no'];
         $record['year']=$record['year'];
         $record['class_id']=$record['class_id'];
         $record['name']=$record['name'];
         $record['mobile_student']=$record['mobile_student'];
         if($record['profile_picture']!=''){
            $record['profile_picture']=$site['url'].$record['profile_picture'];}
            $record['dob']=$os->showDate($record['dob']); 
            $record['gender']=$record['gender'];
            $record['caste']=$record['caste'];
            $record['father_name']=$record['father_name'];
            $record['father_ocu']=$record['father_ocu'];
            $record['father_monthly_income']=$record['father_monthly_income'];
            $record['vill']=$record['vill'];
            $record['po']=$record['po'];
            $record['ps']=$record['ps'];
            $record['dist']=$record['dist'];
            $record['block']=$record['block'];
            $record['pin']=$record['pin'];
            $record['state']=$record['state'];
            $record['last_school']=$record['last_school'];
            $record['last_class']=$record['last_class'];
            $record['last_school_session']=$record['last_school_session'];
            $record['last_school_address']=$record['last_school_address'];
            $record['subject_marks_data']=$record['subject_marks_data'];
            $record['form_fill_date']=$os->showDate($record['form_fill_date']); 
            $record['fees_structure']=$record['fees_structure'];
            $record['form_status']=$record['form_status'];
            $record['form_status_dated']=$os->showDate($record['form_status_dated']); 
            $record['form_status_by']=$record['form_status_by'];
            $record['amount']=$record['amount'];
            $record['payment_status']=$record['payment_status'];
            $record['payment_details']=$record['payment_details'];



            echo  json_encode($record);    

            exit();

         }


         if($os->get('WT_formfillupDeleteRowById')=='OK')
         { 

            $formfillup_id=$os->post('formfillup_id');
            if($formfillup_id>0){
               $updateQuery="delete from formfillup where formfillup_id='$formfillup_id'";
               $os->mq($updateQuery);
               echo 'Record Deleted Successfully';
            }
            exit();
         }
         if($os->get('change_form_status')=='OK'&&$os->post('change_form_status')=='OKS'){
            $formfillup_id=$os->post('formfillup_id');
            $dataToSave['form_status']=$os->post('change_to'); 
            $dataToSave['form_status_by']=$os->userDetails['adminId']; 
            $dataToSave['form_status_dated']=$os->now();
            $result=0;
         // _d($os->post());
            if($formfillup_id>0){      
               $qResult=$os->save('formfillup',$dataToSave,'formfillup_id',$formfillup_id);  
               $result=$os->change_form_status($os->post());
            }
            echo $result;
            exit;
         }




         if($os->get('view_history')=='OK'){
            $formfillup_id=$os->post('formfillup_id');
            $status_history_q="SELECT * FROM form_status_history where formfillup_id='$formfillup_id' ORDER BY form_status_history_id desc";
            $status_history_mq=$os->mq($status_history_q);

            $admin_q="SELECT * FROM admin where adminId>0 ORDER BY adminId desc";
            $admin_mq=$os->mq($admin_q);
            $admin_a=array();
            while($admin_res=$os->mfa($admin_mq)){
               $admin_a[$admin_res['adminId']]=$admin_res['name'];
            }
            ?>
            <table class="uk-table uk-table-striped uk-table-small uk-margin-remove uk-table-hover uk-table-responsive uk-table-middle">
               <tbody>
                  <tr>
                     <td>#</td>
                     <td>Date</td>                            
                     <td>Changed By</td>
                     <td>Form</td>
                     <td>To</td>
                  </tr>
                  <?
                  $count=1;
                  while($record=$os->mfa($status_history_mq)){?>
                     <tr>
                        <td class="uk-table-shrink" style="color: #0A246A"><?echo $count;?></td>
                        <td class="uk-text-nowrap"><?echo $os->showDate($record['dated']);?><br/>
                           <?echo $os->showDate($record['dated'],'h:i:A');?>
                        </td>
                        <td>
                           <?if($record['adminId']):?>
                           <? echo $admin_a[$record['adminId']]; ?> [<? echo $record['adminId'] ?>] 
                           <?endif;?></td>
                           <td><?echo $record['change_form']?></td>
                           <td><?echo $record['change_to']?></td>
                        </tr>
                        <?$count++;}?>
                        <?if($count==1){?>
                           <tr><td colspan="6" style="color:red;font-weight: bold">No data found at the moment.</td></tr>
                           <?}?>
                        </tbody>
                     </table>
                     <?exit();}
                     if($os->get('set_fees')=='OK'){
                        $fees_amount=$os->rowByField('amount','form_fees','form_fees_for',$os->post('form_for'),$where="and year='".$os->post("year")."' and class_id='".$os->post("class_id")."'",$orderby='');
                        echo $fees_amount>0?$fees_amount:'0';
                        exit;
                     }

                     if($os->get('upload_doc')=='OK'){
                        $image=$os->UploadPhoto('image',$site['root'].'upload_document');
                        $doc_title=$os->post('doc_title');
                        $file_size = $_FILES['image']['size'];
                        $file_type = $_FILES['image']['type'];
                        if($image!=''){
                           $img_link='upload_document/'.$image;}
                           $rand_no=rand(1,10000);
                           ?>
                           <tr id="con_<?echo $rand_no;?>">
                              <td style="width:50px; padding: 3px 0">
                                 <?if(explode("/",$file_type)[0]=="image"){?>
                                    <img src="<?echo $site['url'].$img_link?>" style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #e5e5e5">
                                    <?} else { ?>
                                       <div class="uk-flex uk-flex-middle uk-flex-center" style="height: 35px; width: 35px; font-size: 11px; color: var(--color-primary-dark); background-color: #fafafa; border: 1px solid #e5e5e5">
                                          <?= strtoupper(explode("/",$file_type)[1]);?>
                                       </div>
                                       <?}?>
                                    </td>
                                    <td style="line-height: 1" valign="middle">
                                       <?echo $doc_title?><br>
                                       <div >
                                          <small class="color-acent" style="font-size: 11px"><?= round($file_size/1024)."KB"?></small>
                                          &bull;
                                          <small class="color-acent" style="font-size: 11px"><?= strtoupper(explode("/",$file_type)[1])?></small>
                                       </div>
                                       <input type="hidden"  name="doc[<?echo $rand_no?>][doc_title]" class="uk-input uk-form-small" value="<?echo $doc_title?>" />
                                       <input type="hidden" name="doc[<?echo $rand_no?>][doc_url]" value="<?echo $img_link?>" />
                                    </td>
                                    <td style="width: 30px; text-align: right">
                                       <a style="color: red" href="javascript:void(0)"
                                       onclick="if(confirm('Are you sure?')){$('#con_<?echo $rand_no;?>').remove();}" uk-icon="close"></a>
                                    </td>
                                 </tr>
                                 <? exit;
                              }



                              if($os->get('student_fees_setting')=='OK')
                              {



                                 $formfillup_id=$os->post("formfillup_id");
                                 $formfillup_data=$os->rowByField('','formfillup','formfillup_id',$formfillup_id);


                                 $asession=$formfillup_data['year'];  
                                 $class_id=$formfillup_data['class_id']; 

                                 $student_type_for_student=$os->post("student_type_for_student");
                                 $fees_slab_for_student=$os->post("fees_slab_for_student");


                                 $action=$os->post('action');
                                 if($action=='save')
                                 {
                                    $fees_config_data_post=$os->post();


   // filter checked data 

                                    if(isset( $fees_config_data_post['fees_approved']))
                                    {
                                       foreach($fees_config_data_post['fees_approved'] as $ftype=>$head_val_arr )
                                       {
                                          foreach($head_val_arr as $head_name=>$amount_val)
                                          {

   //  echo  " $ftype  $head_name $amount_val   ";

                                             if( isset($fees_config_data_post['fees_approved_checked'][$ftype][$head_name]))
                                             {
   // allow  fees  

                                             }else{

                                                unset($fees_config_data_post['fees_approved'][$ftype][$head_name]);
                                             }


                                          }


                                       }

                                    }

   // filter checked data  end 
   //  _d($fees_config_data_post);




                                    $save_to_database['fees_config_data']=serialize($fees_config_data_post);       
                                    if($formfillup_id>0){ 

                                       $os->save('formfillup',$save_to_database,'formfillup_id',$formfillup_id);

     // create_fees_student($history_id); create will be at the time of payment 
   // generate fess 777777777

   // _d($fees_config_data_post['fees_approved']); exit();

                                    }

                                 }



                                 $fees_slab_arr=array();
                                 $data_rs=$os->rowsByField('','fees_slab','classId',$class_id,$where=" and year='$asession'   ",$orderby='',$limit='');

                                 while($rs=$os->mfa($data_rs))
                                 {
                                    $fees_slab_arr[$rs['fees_slab_id']]=$rs['title'].' - '.$rs['note'];
                                 }


                                 $feesconfig_selected=array();
                                 $data_rs=$os->rowsByField('','feesconfig','classId',$class_id,$where=" and accademicsessionId='$asession'  and fees_slab_id='$fees_slab_for_student'  and student_type='$student_type_for_student' and  fees_slab_id!=''       ",$orderby='',$limit='');
                                 while($rs=$os->mfa($data_rs))
                                 {


                                    $feesconfig_selected[$rs['feesType']][$rs['feesconfigId']]=$rs;


                                 }








                                 ?>
                                 <h3>  <? echo $formfillup_data['name']; ?>  - <? echo $os->classList[$class_id];?>   -  <? echo $asession; ?>       </h3>
                                 <br /><br />
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                       <td valign="top"><?  $fees_config_data_serialize=$os->rowByField('fees_config_data ','formfillup','formfillup_id',$formfillup_id);
                                       $fees_config_data=unserialize($fees_config_data_serialize); 

                                       $type='';

                                       if(isset($fees_config_data['student_type_for_student']))
                                       {
                                          $type= $os->student_type[$fees_config_data['student_type_for_student']];
                                       }
                                       if(isset($fees_config_data['fees_slab_for_student']))
                                       {
                                          $slab= $fees_slab_arr[$fees_config_data['fees_slab_for_student']];
                                       }

                                       if($type!=''){


                                          ?> 
                                          <h3> <? echo $type; ?> - <? echo $slab; ?>  </h3>
                                          <?  
                                          if( isset($fees_config_data['fees_approved']))
                                          {

                                             foreach($fees_config_data['fees_approved'] as $feesType=>$rows){

                                                if(count($rows)>0) {
                                                   ?>
                                                   <b> <? echo $feesType ?>  </b>
                                                   <table   border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                         <td style="width:200px;">&nbsp;</td>
                                                         <td style="width:100px;">&nbsp;</td>
                                                         <td style="width:100px;">&nbsp;</td>
                                                         <td style="width:100px;">&nbsp;</td>
                                                      </tr>
                                                      <? 
                                                      $total=0;
                                                      foreach($rows as $head=>$amount){
                                                         $total=$total+$amount;




                                                         ?>
                                                         <tr>
                                                            <td><? echo $head; ?></td>
                                                            <td><? echo $amount; ?></td>
                                                            <td>                       
                                                            </td>
                                                            <td>&nbsp;</td>
                                                         </tr>
                                                         <? 
                                                      }?>
                                                      <tr style="background-color:#FFFF99;">
                                                         <td>Total</td>
                                                         <td> <b><? echo $total; ?> </b></td>
                                                         <td>&nbsp;</td>
                                                         <td>&nbsp;</td>
                                                      </tr>
                                                   </table>
                                                   <br /><br />
                                                   <? 
                                                }
                                             }


                                          }


                                          ?>
                                       <? }else{ ?>
                                          <h4> Fees setting missing  </h4>
                                       <? } ?>
                                    </td>
                                    <td valign="top">
                                       <select   id="student_type_for_student" name="student_type_for_student" onchange="student_fees_setting('<? echo $formfillup_id ?>','')">
                                          <option value="" > </option>
                                          <?  $os->onlyOption($os->student_type,  $student_type_for_student );?>
                                       </select> 
                                       <select   id="fees_slab_for_student" name="fees_slab_for_student"  onchange="student_fees_setting('<? echo $formfillup_id ?>','')"   >
                                          <option value="" > </option>
                                          <?  $os->onlyOption($fees_slab_arr,  $fees_slab_for_student );?>
                                       </select> 
                                       <br />  <br />          
                                       <? if(count($feesconfig_selected)>0){
                                          foreach($feesconfig_selected as $feesType=>$rows){
                                             ?>
                                             <b> <? echo $feesType ?>  </b>
                                             <table   border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                   <td style="width:20px;">&nbsp;</td>
                                                   <td style="width:150px;">&nbsp;</td>
                                                   <td style="width:100px;">&nbsp;</td>
                                                   <td style="width:50px;">&nbsp;</td>
                                                   <td style="width:50px;">&nbsp;</td>
                                                </tr>
                                                <? 
                                                $configtotal=0;
                                                $saved_total=0;
                                                foreach($rows as $feesconfigId=>$row){
                                                   $configtotal=$configtotal+$row['amount'];




                                                   ?>
                                                   <tr><td>
                                                      <input type="checkbox" name="fees_approved_checked[<? echo $feesType ?>][<? echo  $row['feesHead'] ?>]" value="1"  /></td>
                                                      <td>
                                                         <? echo $row['feesHead']; ?></td>
                                                         <td> 
                                                            <input type="text" name="fees_approved[<? echo $feesType ?>][<? echo  $row['feesHead'] ?>]" value="<? echo $row['amount'] ?>" style="width:60px;" />
                                                            <input type="hidden" name="fees_config[<? echo $feesType ?>][ <? echo  $row['feesHead'] ?>]" value="<? echo $row['amount'] ?>" style="width:60px;" />
                                                         </td>
                                                         <td><? echo $row['amount']; ?></td>
                                                         <td>&nbsp;</td>
                                                      </tr>
                                                      <? 
                                                   }?>
                                                   <tr style=" background-color:#FFFF99;"><td> </td>
                                                      <td>Total</td>
                                                      <td> </td>
                                                      <td><? echo $configtotal; ?></td>
                                                      <td>&nbsp;</td>
                                                   </tr>
                                                </table>
                                                <br /><br />
                                                <? 
                                             }
                                             ?> <br />  <input type="button" value="Save Fees Setting" onclick="student_fees_setting('<? echo $formfillup_id ?>','save')" style="cursor:pointer;" /> <?
                                          } ?>           
                                       </td>
                                       <td valign="top"> 
                                          <? if(count($feesconfig_selected)>0){ 
                                             ?>
                                             <!-- fees months selection -->
                                             Select months to create monthly fees 
                                             <?   
                                             $session_months=global_session_setting_months($asession,$class_id);


                                             if(count($session_months)<1)
                                             {
                                                echo 'Please set session start and  end date in global session setting ';

                                             }else
                                             {
                                                ?> <table> <? 
                                                foreach($session_months as $months_year)
                                                {

                                                   $month_conf=substr($months_year,4,2);
                                                   $month_conf= (int)$month_conf;
                                                   $year_conf=substr($months_year,0,4);


                                                   ?>
                                                   <tr> <td> <input type="checkbox" checked="checked" name="session_months_selected[]" value="<? echo $months_year ?>"  /></td>
                                                      <td title="<? echo $month_conf ?>"><? echo $os->feesMonth[$month_conf]; ?> <? echo $year_conf ?> </td>
                                                   </tr>
                                                   <? 
                                                }

                                                ?> </table> <? 
                                             }

                                          }
                                          ?>
                                       </td>
                                    </tr>
                                 </table>
                                 <?php   
                                 exit();         
                              }
                              if($os->get('student_admission_from_formfillup')=='OK')
                              {
                                 $formfillup_id=$os->post("formfillup_id");
                                 $formfillup_data=$os->rowByField('','formfillup','formfillup_id',$formfillup_id);
                                 $formfillup_data['00000']='';
                                 $asession=$formfillup_data['year'];  
                                 $class_id=$formfillup_data['class_id']; 
                                 $form_no=$formfillup_data['form_no'];  
                                 $dataToSave_2=array();       
                                 $dataToSave_2['name']=$formfillup_data['name'];  
                                 $dataToSave_2['branch']=$formfillup_data['branch_id'];  
                                 $dataToSave_2['dob']=$formfillup_data['dob'];  
                                 $dataToSave_2['gender']=addslashes($formfillup_data['gender']);
                                 $dataToSave_2['father_name']=addslashes($formfillup_data['father_name']);
                                 $dataToSave_2['vill']=addslashes($formfillup_data['vill']);
                                 $dataToSave_2['po']=addslashes($formfillup_data['po']);
                                 $dataToSave_2['ps']=addslashes($formfillup_data['ps']);
                                 $dataToSave_2['dist']=addslashes($formfillup_data['dist']);
                                 $dataToSave_2['block']=addslashes($formfillup_data['block']);
                                 $dataToSave_2['pin']=addslashes($formfillup_data['pin']);
                                 $dataToSave_2['state']=addslashes($formfillup_data['state']);
                                 $dataToSave_2['mobile_student']=addslashes($formfillup_data['mobile_student']);
                                 $dataToSave_2['email_student']=addslashes($formfillup_data['email_id']);
                                 $dataToSave_2['otpPass']=rand(1000,9999);
                                 $dataToSave_2['adhar_no']=addslashes($formfillup_data['aadhaar_number']);
                                 $dataToSave_2['registerDate']=$os->now();
                                 $dataToSave_2['religian']=addslashes($formfillup_data['00000']);
                                 $dataToSave_2['caste']=addslashes($formfillup_data['caste']);
                                 $dataToSave_2['father_ocu']=addslashes($formfillup_data['father_ocu']);
                                 $dataToSave_2['mobile_student_alternet']=addslashes($formfillup_data['mobile_student']);
                                 $dataToSave_2['mobile_student_whatsapp']=addslashes($formfillup_data['whats_app_no']);
                                 $dataToSave_2['mother_name']=addslashes($formfillup_data['mother_name']);
                                 $dataToSave_2['mother_ocu']=addslashes($formfillup_data['mother_occupation']);
                                 $registrationNo='';
                                 $msg='Insert Fail';
                                 $insert_student_data=true;
// check for already added
                                 $alredy_form_added=$os->rowByField('','history','formNo',$formfillup_id);
                                 if($os->val($alredy_form_added,'formNo'))
                                 {
                                    $msg='Already Admitted';
                                    $insert_student_data=false;
                                 }
//  _d($alredy_form_added); exit();
                                 if($insert_student_data==true)
                                 {
                                    $dataToSave_2['addedDate']=$os->now();
                                    $dataToSave_2['addedBy']=$os->userDetails['adminId'];
                                    $studentId=$os->save('student',$dataToSave_2,'studentId','');
//echo $os->query;
                                    $registrationNo=$studentId;
                                    $dataToSave_2=array();  
                                    $dataToSave_2['registerNo']=$registrationNo;
                                    $studentId=$os->save('student',$dataToSave_2,'studentId',$studentId);
                                    if($studentId)
                                    {
                                       $dataToSave_form=array();  
                                       $dataToSave_form['form_status_dated']=$os->now();
                                       $dataToSave_form['form_status_by']=$os->userDetails['adminId'];
                                       $dataToSave_form['form_status']='admitted';
                                       $os->save('formfillup',$dataToSave_form,'formfillup_id',$formfillup_id);
// history  adding
//   admission_no admission_date  formNo
                                       $dataToSave['asession']=addslashes($formfillup_data['year']);
                                       $dataToSave['registrationNo']=$registrationNo;
                                       $dataToSave['branch_code']=addslashes($formfillup_data['branch_id']);
                                       $dataToSave['class']=addslashes($formfillup_data['class_id']);
                                       $dataToSave['historyStatus']='Active';
                                       $dataToSave['remarks']='Added from fromfillup';
                                       $dataToSave['admission_no']=$formfillup_id;
                                       $dataToSave['admission_date']=$os->now();
                                       $dataToSave['formNo']=$formfillup_id;  
                                       $dataToSave['section']='';
                                       $dataToSave['roll_no']='';
                                       $dataToSave['board']='WB';
                                       $dataToSave['addedDate']=$os->now();
                                       $dataToSave['addedBy']=$os->userDetails['adminId'];
                                       $dataToSave['studentId']=$studentId;
                                       $dataToSave['fees_config_data']=$formfillup_data['fees_config_data'];
                                       $historyId=$os->save('history',$dataToSave,'historyId','');
// history  adding  end
/// student meta ------------------------------------------
                                       $dataToSave_meta['student_id'] = $studentId;
                                       $dataToSave_meta['medium'] = '';
                                       $dataToSave_meta['present_fees'] = '';
                                       $dataToSave_meta['referer_details'] = '';
                                       $dataToSave_meta['eye_power'] = '';
                                       $dataToSave_meta['psychiatric_report'] = '';
                                       $dataToSave_meta['mother_tongue'] = '';
                                       $dataToSave_meta['apl_bpl'] = '';
                                       $dataToSave_meta['father_adhar'] = addslashes($formfillup_data['father_id_no']);
                                       $dataToSave_meta['mother_adhar'] = addslashes($formfillup_data['mother_id_no']);
                                       $dataToSave_meta['email_guardian'] = '';
                                       $dataToSave_meta['nationality'] = addslashes($formfillup_data['nationality']);
                                       $dataToSave_meta['country_name'] = '';
                                       $dataToSave_meta['passport_no'] = '';
                                       $dataToSave_meta['vissa_type'] = '';
                                       $dataToSave_meta['passport_valid_up_to'] = '';
                                       $dataToSave_meta['caste_cert_no'] = '';
                                       $dataToSave_meta['cast_cert_issue_auth'] = '';
                                       $dataToSave_meta['cast_cert_issue_date'] = '';
                                       $dataToSave_meta['disabled'] = '';
                                       $dataToSave_meta['disable_body_parts'] = '';
                                       $dataToSave_meta['disable_percet'] = '';
                                       $dataToSave_meta['disable_cert_no'] = '';
                                       $dataToSave_meta['disable_cert_issue_auth'] = '';
                                       $dataToSave_meta['disable_cert_issue_date'] = '';
                                       $dataToSave_meta['living_area_dist'] = '';
                                       $dataToSave_meta['living_area_sub_division'] =''; 
                                       $dataToSave_meta['living_area_semi_town'] = '';
                                       $dataToSave_meta['living_area_vill'] = '';
                                       $dataToSave_meta['living_area_gram_panchayet'] = '';
                                       $dataToSave_meta['any_bro_sis_presently'] = '';
                                       $dataToSave_meta['bro_sis_presently_details'] = '';
                                       $dataToSave_meta['any_bro_sis_passed'] = '';
                                       $dataToSave_meta['bro_sis_passed_details'] = '';
                                       $dataToSave_meta['any_family_is_mission_emp'] = '';
                                       $dataToSave_meta['family_is_mission_emp_details'] = '';
                                       $dataToSave_meta['is_father_alive'] = '';
                                       $dataToSave_meta['father_date_of_death'] = '';
                                       $dataToSave_meta['father_qualification'] = '';
                                       $dataToSave_meta['father_monthly_income'] = addslashes($formfillup_data['father_monthly_income']);
                                       $dataToSave_meta['is_mother_alive'] = '';
                                       $dataToSave_meta['mother_date_of_death'] = '';
                                       $dataToSave_meta['mother_qualification'] = '';
                                       $dataToSave_meta['mother_monthly_income'] = '';
                                       $dataToSave_meta['gurdian_qualification'] ='';
                                       $dataToSave_meta['gurdian_monthly_income'] = '';
                                       $dataToSave_meta['corr_vill'] = addslashes($formfillup_data['permanent_village']);
                                       $dataToSave_meta['corr_po'] = addslashes($formfillup_data['permanent_post_office']);
                                       $dataToSave_meta['corr_ps'] =addslashes($formfillup_data['permanent_police_station']);
                                       $dataToSave_meta['corr_block'] = addslashes($formfillup_data['permanent_block']);
                                       $dataToSave_meta['corr_state'] = addslashes($formfillup_data['permanent_state']);
                                       $dataToSave_meta['corr__dist'] =addslashes($formfillup_data['permanent_district']);
                                       $dataToSave_meta['corr_pin'] = addslashes($formfillup_data['permanent_pincode']);
                                       $dataToSave_meta['last_school'] = addslashes($formfillup_data['last_school']);
                                       $dataToSave_meta['last_class'] =addslashes($formfillup_data['last_class']);
                                       $dataToSave_meta['last_school_session'] = $formfillup_data['last_school_session'];
                                       $dataToSave_meta['tc_no'] = '';
                                       $dataToSave_meta['tc_date'] = '';
                                       $dataToSave_meta['student_id_in_TC'] = '';
                                       $dataToSave_meta['last_school_address'] = addslashes($formfillup_data['last_school_address']);
                                       $dataToSave_meta['present_school'] = '';
                                       $dataToSave_meta['present_school_address'] = '';
                                       $dataToSave_meta['present_school_contact'] = '';
                                       $dataToSave_meta['present_school_class'] = '';
                                       $dataToSave_meta['present_school_session'] = '';
                                       $dataToSave_meta['present_school_roll'] = '';
                                       $dataToSave_meta['present_school_section'] = '';
                                       $dataToSave_meta['accNo'] = '';
                                       $dataToSave_meta['accHolderName'] = '';
                                       $dataToSave_meta['ifscCode'] = '';
                                       $dataToSave_meta['bank_branch'] = '';
                                       $dataToSave_meta['bank_name'] = '';
                                       $dataToSave_meta['kanyashree_type'] = '';
                                       $dataToSave_meta['kanyashree_ID_NO'] = '';
                                       $dataToSave_meta['ten_name_of_board'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_passed_year'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_roll'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_no'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_beng_hindi'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_eng'] =addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_math'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_physc'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_lifesc'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_history'] =addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_geography'] =addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_socialsc'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_total_obt'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_out_of'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['ten_marks_percent'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_name_of_board'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_passed_year'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_roll'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_no'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_stream'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_beng_hindi'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_eng'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_math'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_physc'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_biology'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_chemistry'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_total_obt'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_out_of'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['twelve_marks_percent'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_passed'] =addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_passed_subject'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_passed_year'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_passed_university'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_subjects'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_subjects_marks'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_total_obt'] =addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_out_of'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['graduate_percent'] = addslashes($formfillup_data['00000']);
                                       $dataToSave_meta['student_other_info'] = addslashes($formfillup_data['00000']);
                                       $qResult=$os->save('student_meta',$dataToSave_meta,'student_meta_id','');
                                       create_fees_student($historyId);  
                                       $msg='Insert Success';
                                    }else{
                                       $msg='Insert Problem';
                                    }
                                 }  
// $registrationNo='260';
                                 echo '##-FORMFILLUP_DATA_RESULT-##';echo $msg; echo '##-FORMFILLUP_DATA_RESULT-##';
                                 echo '##-FORMFILLUP_DATA_REGNO-##';echo $registrationNo;echo '##-FORMFILLUP_DATA_REGNO-##';
                                 exit;
                              }