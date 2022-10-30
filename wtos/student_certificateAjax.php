<? 
/*
   # wtos version : 1.1
   # page called by ajax script in student_certificateDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_student_certificateListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andcertificate_template_id=  $os->postAndQuery('certificate_template_id_s','certificate_template_id','%');
$andstudentId=  $os->postAndQuery('studentId_s','studentId','%');
$andhistoryId=  $os->postAndQuery('historyId_s','historyId','%');
$andasession=  $os->postAndQuery('asession_s','asession','%');
$andclass_id=  $os->postAndQuery('class_id_s','class_id','%');
$androll_no=  $os->postAndQuery('roll_no_s','roll_no','%');
$andref_no=  $os->postAndQuery('ref_no_s','ref_no','%');
$andtext_line_1=  $os->postAndQuery('text_line_1_s','text_line_1','%');
$andtext_line_2=  $os->postAndQuery('text_line_2_s','text_line_2','%');
$andtext_line_3=  $os->postAndQuery('text_line_3_s','text_line_3','%');
$andtext_line_4=  $os->postAndQuery('text_line_4_s','text_line_4','%');
$andtext_line_5=  $os->postAndQuery('text_line_5_s','text_line_5','%');
$andtext_line_6=  $os->postAndQuery('text_line_6_s','text_line_6','%');
$andcontent=  $os->postAndQuery('content_s','content','%');
$andtemplate_content=  $os->postAndQuery('template_content_s','template_content','%');

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
$andprint_header=  $os->postAndQuery('print_header_s','print_header','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( certificate_template_id like '%$searchKey%' Or studentId like '%$searchKey%' Or historyId like '%$searchKey%' Or asession like '%$searchKey%' Or class_id like '%$searchKey%' Or roll_no like '%$searchKey%' Or ref_no like '%$searchKey%' Or text_line_1 like '%$searchKey%' Or text_line_2 like '%$searchKey%' Or text_line_3 like '%$searchKey%' Or text_line_4 like '%$searchKey%' Or text_line_5 like '%$searchKey%' Or text_line_6 like '%$searchKey%' Or content like '%$searchKey%' Or template_content like '%$searchKey%' Or print_header like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from student_certificate where student_certificate_id>0   $where   $andcertificate_template_id  $andstudentId  $andhistoryId  $andasession  $andclass_id  $androll_no  $andref_no  $andtext_line_1  $andtext_line_2  $andtext_line_3  $andtext_line_4  $andtext_line_5  $andtext_line_6  $andcontent  $andtemplate_content  $anddated  $andprint_header  $andstatus     order by student_certificate_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	
	
	
 
$template_rs= $os->get_certificate_template();
$template_Arr=array();
while($template = $os->mfa($template_rs))
{
	$template_data[$template['certificate_template_id']]=	$template['content_type'];
}
	
	 
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Certificate Template Id</b></td>  
  <td ><b>Student</b></td>  
  
  <td ><b>Session</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Roll no</b></td>  
  <td ><b>Ref No</b></td>  
  <!--<td ><b>Print head</b></td>  
  <td ><b>Text Line 1</b></td>  
  <td ><b>Text Line 2</b></td>  
  <td ><b>Text Line 3</b></td>  
  <td ><b>Text Line 4</b></td>  
  <td ><b>Text Line 5</b></td>  
  <td ><b>Text Line 6</b></td> --> 
 <!-- <td ><b>Content</b></td>  
  <td ><b>Template Content</b></td>  -->
  <td ><b>Date</b></td>  
  <td ><b>Print Header</b></td>  
  <td ><b>Status</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							<td> 
							 <? if($os->access('wtView')){ ?>
							<!--<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_student_certificateGetById('<? echo $record['student_certificate_id'];?>')" >Edit</a></span>  <? } ?>  
							-->
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="PrintCertificate('<? echo $record['student_certificate_id'];?>')" >Print</a></span>
							
							 </td>
								
<td><?php  echo   $template_data[$record['certificate_template_id']]; ?> </td>  
  <td><?php echo $record['studentId']?> </td>  
   
  <td><?php echo $record['asession']?> </td>  
  <td><?php echo $record['class_id']?> </td>  
  <td><?php echo $record['roll_no']?> </td>  
  <td><?php echo $record['ref_no']?> </td>  
  <!--<td><?php echo $record['print_head']?> </td>  
  <td><?php echo $record['text_line_1']?> </td>  
  <td><?php echo $record['text_line_2']?> </td>  
  <td><?php echo $record['text_line_3']?> </td>  
  <td><?php echo $record['text_line_4']?> </td>  
  <td><?php echo $record['text_line_5']?> </td>  
  <td><?php echo $record['text_line_6']?> </td> --> 
  <!--<td><?php echo $record['content']?> </td>  
  <td><?php echo $record['template_content']?> </td>  -->
  <td><?php echo $os->showDate($record['dated']);?> </td>  
  <td> <? if(isset($os->printHeader[$record['print_header']])){ echo  $os->printHeader[$record['print_header']]; } ?></td> 
  <td> <? if(isset($os->activeStatus[$record['status']])){ echo  $os->activeStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_student_certificateEditAndSave')=='OK')
{
 $student_certificate_id=$os->post('student_certificate_id');


		 
 $dataToSave['certificate_template_id']=($os->post('certificate_template_id')); 
 $dataToSave['studentId']=($os->post('studentId')); 
 $dataToSave['historyId']=($os->post('historyId')); 
 $dataToSave['asession']=($os->post('asession')); 
 $dataToSave['class_id']=($os->post('class_id')); 
 $dataToSave['roll_no']=($os->post('roll_no')); 
 $dataToSave['ref_no']=($os->post('ref_no')); 
 $dataToSave['print_head']=$os->post('print_head'); 
 $dataToSave['text_line_1']=($os->post('text_line_1')); 
 $dataToSave['text_line_2']=($os->post('text_line_2')); 
 $dataToSave['text_line_3']=($os->post('text_line_3')); 
 $dataToSave['text_line_4']=($os->post('text_line_4')); 
 $dataToSave['text_line_5']=($os->post('text_line_5')); 
 $dataToSave['text_line_6']=($os->post('text_line_6')); 
 $dataToSave['content']=($os->post('content')); 
 $dataToSave['template_content']=($os->post('template_content')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['print_header']=($os->post('print_header')); 
 $dataToSave['status']=($os->post('status')); 
 
 
  // create template text
   // $certificate_template_id=$dataToSave['certificate_template_id'];
   //$template_content=$certificate_data['template_content'];
  // $template_data_keys=json_decode($template_content,true);
  
   
   
   
   
  // create end 
 
 
 
 
 
 
 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($student_certificate_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('student_certificate',$dataToSave,'student_certificate_id',$student_certificate_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		 
		if($qResult)  
				{
		if($student_certificate_id>0 ){ $mgs= " Data updated Successfully";}
		if($student_certificate_id<1 ){ $mgs= " Data Added Successfully"; $student_certificate_id=  $qResult;}
		
		  $mgs=$student_certificate_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_student_certificateGetById')=='OK')
{
		$student_certificate_id=$os->post('student_certificate_id');
		
		if($student_certificate_id>0)	
		{
		$wheres=" where student_certificate_id='$student_certificate_id'";
		}
	    $dataQuery=" select * from student_certificate  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['certificate_template_id']=$record['certificate_template_id'];
 $record['studentId']=$record['studentId'];
 $record['historyId']=$record['historyId'];
 $record['asession']=$record['asession'];
 $record['class_id']=$record['class_id'];
 $record['roll_no']=$record['roll_no'];
 $record['ref_no']=$record['ref_no'];
 $record['print_head']=$record['print_head'];
 $record['text_line_1']=$record['text_line_1'];
 $record['text_line_2']=$record['text_line_2'];
 $record['text_line_3']=$record['text_line_3'];
 $record['text_line_4']=$record['text_line_4'];
 $record['text_line_5']=$record['text_line_5'];
 $record['text_line_6']=$record['text_line_6'];
 $record['content']=$record['content'];
 $record['template_content']=$record['template_content'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['print_header']=$record['print_header'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_student_certificateDeleteRowById')=='OK')
{ 

$student_certificate_id=$os->post('student_certificate_id');
 if($student_certificate_id>0){
 $updateQuery="delete from student_certificate where student_certificate_id='$student_certificate_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
 
 
if($os->get('certificate_form')=='OK' && $os->post('certificate_form')=='OK'   )
{
		
		
		
	 
		$template_keys=$os->get_template_keys();
		
		
    
		
		
		
		$student_certificate_id=$os->post('student_certificate_id');
		$certificate_template_id=$os->post('certificate_template_id');
		$studentId=$os->post('studentId');
		$historyId=$os->post('historyId');
		$asession=$os->post('asession');
		$class_id=$os->post('class_id');
		$ref_no=$studentId.'-'.$class_id;
		
		// get template data
		
		$student= $os->rowByField('','student','studentId',$studentId);
		$history= $os->rowByField('','history','historyId',$historyId);
		  
		$template_keys['...NAME...']=$student['name'];
		if($student['gender']=='Female')
		{
			$template_keys['...SON-DOT...']='daughter';
			$template_keys['...HIS-HER...'] ='her';
			$template_keys['...HE-SHE...']='She';
		}
		$template_keys['...FATHERNAME...'] =$student['father_name'];
         
		 $template_keys['...YEAR...'] =$history['asession'];
		 $template_keys['...CLASS...']=$history['class'];
		 $template_keys['...DOB...'] =$os->showDate($student['dob']);
		
		 $template_keys['...ADMISSION_NO...'] ='';
		 $template_keys['...STUDENT_ID...'] =$student['studentId'];
      
         $cy=date('Y');
		 if($history['asession']<$cy)
		 {
		    $template_keys['...IS-WAS...'] ='was';
		 }
		 
		
		if($certificate_template_id>0)	
		{
		 	$wheres=" where certificate_template_id='$certificate_template_id'";
		}
	    $dataQuery=" select * from certificate_template  $wheres  limit 1";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		$text_content=$record['text_content'];
		
		
		$input_1_default=$record['input_1_default'];
		$input_2_default=$record['input_2_default'];
		$input_3_default=$record['input_3_default'];
		$input_4_default=$record['input_4_default'];
		$input_5_default=$record['input_5_default'];
		$input_6_default=$record['input_6_default'];
		$input_7_default=$record['input_7_default'];
		$input_8_default=$record['input_8_default'];
		
		//   $input_1_default='...NAME...';	
		
		$input_1_default_text=$os->replace_template_value($template_keys,$input_1_default);
		$input_2_default_text=$os->replace_template_value($template_keys,$input_2_default);
		$input_3_default_text=$os->replace_template_value($template_keys,$input_3_default);
		$input_4_default_text=$os->replace_template_value($template_keys,$input_4_default);
		$input_5_default_text=$os->replace_template_value($template_keys,$input_5_default);
		$input_6_default_text=$os->replace_template_value($template_keys,$input_6_default);
		
				
		if($input_1_default_text!=''){ $template_keys['...INPUT_1...']='<input type="text" class="silent_input_big" onchange="setDataToFields(\'text_line_1\')" id="text_line_1_helper" value="'.$input_1_default_text.'" />';	}
		if($input_2_default_text!=''){ $template_keys['...INPUT_2...']='<input type="text" class="silent_input_big"  onchange="setDataToFields(\'text_line_2\')"  id="text_line_2_helper" value="'.$input_2_default_text.'" />';	}
		if($input_3_default_text!=''){ $template_keys['...INPUT_3...']='<input type="text" class="silent_input_big" onchange="setDataToFields(\'text_line_3\')"  id="text_line_3_helper" value="'.$input_3_default_text.'" />';	}
		if($input_4_default_text!=''){ $template_keys['...INPUT_4...']='<input type="text" class="silent_input_big" onchange="setDataToFields(\'text_line_4\')"  id="text_line_4_helper" value="'.$input_4_default_text.'" />';	}
		if($input_5_default_text!=''){ $template_keys['...INPUT_5...']='<input type="text" class="silent_input_big" onchange="setDataToFields(\'text_line_5\')"  id="text_line_5_helper" value="'.$input_5_default_text.'" />';	}
		if($input_6_default_text!=''){ $template_keys['...INPUT_6...']='<input type="text" class="silent_input_big" onchange="setDataToFields(\'text_line_6\')"  id="text_line_6_helper" value="'.$input_6_default_text.'" />';	}
			
		
		$text_content_replaced=$os->replace_template_value($template_keys,$text_content);
		$dated=$os->now();
		echo '##-GETTEMPLATE-FORM-##';
		   
		 ?>
		 <div style="display:none;">
		 <input type="hidden" id="text_line_1"  value="<? echo $input_1_default_text ?>" /> 
	  	 <input type="hidden" id="text_line_2" value="<? echo $input_2_default_text ?>" /> 
		 <input type="hidden" id="text_line_3" value="<? echo $input_3_default_text ?>" /> 
		<input type="hidden" id="text_line_4" value="<? echo $input_4_default_text ?>" /> 
		<input type="hidden" id="text_line_5" value="<? echo $input_5_default_text ?>" /> 
		<input type="hidden" id="text_line_6" value="<? echo $input_6_default_text ?>" /> 
		<input type="hidden" id="ref_no" value="<? echo $ref_no; ?>" />   
		<input type="hidden" id="dated" value="<? echo $os->showDate($dated); ?>" />
		<input type="hidden" id="print_header" value="Yes" />
		</div>
		<h3 style="margin-bottom:0px;">  <? echo $record['content_type'] ?> Cettificate for student  <font style="color:#0080FF"> <? echo  $student['name']  ?> </font> </h3>
		 <div style="font-style:italic; padding-bottom:20px;"> Id <font style="color:#0080FF"> <? echo $studentId; ?>  </font> year <font style="color:#0080FF"> <? echo $history['asession'] ?> </font>class <font style="color:#0080FF"><? echo $history['class'] ?></font> 
		 &nbsp;&nbsp; Ref No <input type="text" class="silent_input" id="ref_no_helper" value="<? echo $ref_no; ?>" />   &nbsp;&nbsp; Dated <input class="silent_input" type="text" id="dated_helper" value="<? echo $os->showDate($dated); ?>" />  &nbsp;&nbsp;print Header <select class="silent_input"  name="print_header" id="print_header_helper" class="textbox fWidth" ><? 
		 $os->onlyOption($os->printHeader);	?>
		 </select>
		 
		 </div> 
		  
		   <div class="text_content_replaced" >
		 
		 <? echo $text_content_replaced; ?>
		   
		  </div>
		 <?		
		 echo '##-GETTEMPLATE-FORM-##';
		  
		  
		 echo '##-GETTEMPLATE-CONTENT-##';  
		 		 
				$template_keys['...INPUT_1...']='';
				$template_keys['...INPUT_2...']='';
				$template_keys['...INPUT_3...']='';
				$template_keys['...INPUT_4...']='';
				$template_keys['...INPUT_5...']='';
				$template_keys['...INPUT_6...']='';	 
				
				//$template_keys['text_content']=($text_content);	    
		 echo json_encode($template_keys);		 
		 echo '##-GETTEMPLATE-CONTENT-##'; 
		 
		 
		 
exit();
	
}
 
 
 