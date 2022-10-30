<? 
/*
   # wtos version : 1.1
   # page called by ajax script in mess_meal_memberDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

  $selected_branch_code=$os->getSession($key1='selected_branch_code');
?><?

if($os->get('WT_mess_meal_memberListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='23:59:59');
$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
$andnote=  $os->postAndQuery('note_s','note','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( branch_code like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
	
	  //  branch filter 
	
	  
	  $and_branch=" and branch_code IN('$selected_branch_code')";
	
	 // user filter 
	
	 $adminId=$os->userDetails['adminId'];
	 $and_adminId=" and addedBy='$adminId' ";
	 if($os->userDetails['primery_verification_access']=='Yes')
	 {
	    $and_adminId="  ";
	 }
    if($os->userDetails['final_verification_access']=='Yes')
	{
	   $and_adminId="  ";
	} 
	   
	 if($os->userDetails['adminType']=='Super Admin')
	{
	$and_adminId="  ";
	 $and_branch='';
	 $os->userDetails['primery_verification_access']='Yes';
	} 
	 
		
	     $listingQuery="  select * from mess_meal_member where mess_meal_member_id>0   $where   $anddated  $andbranch_code  $andnote  $and_branch  $and_adminId   order by dated desc, mess_meal_member_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	
	
	// all admin list
	$all_admin=$os->get_admin();
	$all_admin_list=array();
	while($all_admin_data = $os->mfa($all_admin) )
	{
	  $all_admin_list[$all_admin_data['adminId']]=$all_admin_data['name'];
	}
	
	
	// all admin list
	/*$all_branch=$os->get_branch();
	$all_branch_list=array();
	while($all_branch_data = $os->mfa($all_branch) )
	{
	  $all_branch_list[$all_branch_data['branch_code']]=$all_branch_data['branch_code'];
	}*/
	
	
	$result_array=array();
	while($record=$os->mfa( $rsRecords))
	{
	 $dated=$os->showDate($record['dated']);
	 $result_array[$dated][$record['mess_meal_member_id']]=$record;
	
	}  
	
	
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
<? 
foreach($result_array as $dated_value=>$records)
{ ?>
<br /><b style="color:#0033CC; font-weight:bold"><? echo $dated_value  ?> </b>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                             
									 
								
<td ><b>Present</b></td>  
  											
 <td ><b>Added By</b></td>  
 
 
  
   
    
   
  
  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 //$serial=$os->val($resource,'serial');  
						 
							//while($record=$os->mfa( $rsRecords)){ 
							$today_total_present_Verified=0;
							$today_total_present=0;
							foreach($records as $record){ 
							 $serial++;
							    
							$color=	'#000000';
							if($os->primery_verification_status[$record['final_verification_status']]=='Pending')
							{
							   $color=	'#FF0000';
							}
							if($os->primery_verification_status[$record['final_verification_status']]=='Verified')
							{
							   $color=	'#00CC00';
							   $today_total_present_Verified= $record['total_present'] + $today_total_present_Verified;
							}
							
							 $today_total_present= $record['total_present'] + $today_total_present;
							  $today_total_present_Verified=$today_total_present;
						
							 ?>
							<tr class="trListing">
							 
				<td >
  <div class="btn btn-primary tooltip"> <b style="color:<? echo $color ?>;cursor:pointer;" ><?php echo $record['total_present']?></b>
   
   
   <div class="top">
   <b style="color:#0000CC;">Present = <?php echo $record['total_present']?> </b>
    
	<? if($record['submitted']!=1  && $adminId==$record['addedBy']) { ?>
	<span id="submit_element_id">
	<span id="" style="cursor:pointer; color:#CC33FF;" onclick="wtos_update_submitted_status('submit_element_id','Submitted','1','mess_meal_member','submitted','mess_meal_member_id','<? echo $record['mess_meal_member_id'];?>','','','');" > Submit </span> 
	</span>
	<? }elseif($record['submitted']==1 ){ ?> 
	Submitted
	<? }else{ ?>
	Not-Submitted
	<? } ?> 
	
	
	<br />
    Total = <?php echo $record['total']?> <br />
	Absent = <?php echo $ab=$record['total']-$record['total_present'];?> <br />
	
	 <? 
	 $edit_button=true;
	 if($record['submitted']==1  && $adminId==$record['addedBy'])
	 {
	    $edit_button=false;
	 } 
	 
	 if($os->access('wtView') && $edit_button==true){ ?>
							
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_mess_meal_memberGetById('<? echo $record['mess_meal_member_id'];?>')" >Edit</a></span>  <? } ?> 
	
   <br />
   <div id="verification_data"  >
    <b style="color:#0000CC;"> Primery Verification </b> <br />
  Status : <? echo $os->primery_verification_status[$record['primery_verification_status']]; ?> <br />
   <? if($os->val($all_admin_list,$record['primery_verification_user'])!=''){ ?>
    By  <? echo $os->val($all_admin_list,$record['primery_verification_user']); ?> <br />
	Dated <?php echo $os->showDate($record['primery_verification_date']);?><br />
	
	<?  } ?> 
  <?  if($os->userDetails['primery_verification_access']=='Yes') { ?>
    
  <select  id="primery_verification_status_<?php echo $record['mess_meal_member_id']?>" class="textbox fWidth"
  onchange="wtos_update_verification_status('primery_verification_status_<?php echo $record['mess_meal_member_id']?>', 'mess_meal_member','primery_verification_status','mess_meal_member_id','<?php echo $record['mess_meal_member_id']?>','','','','primery')" >
  <option value=""></option>	<? $os->onlyOption($os->primery_verification_status,$record['primery_verification_status']);	?>
	</select>	<br /> 
	 <?  } ?> 
	 
	 
	 
	<b style="color:#0000CC"> Final Verification </b> <br /> 
	Status : <? echo $os->final_verification_status[$record['final_verification_status']]; ?> <br />
	  <? if($os->val($all_admin_list,$record['final_verification_user'])!=''){ ?>
    By  <? echo $os->val($all_admin_list,$record['final_verification_user']); ?> <br />
	Dated <?php echo $os->showDate($record['final_verification_date']);?><br />
	
	<?  } ?>  
	 
	 
	<?  if($os->userDetails['final_verification_access']=='Yes') { ?>
	
	
   <select  id="final_verification_status_<?php echo $record['mess_meal_member_id']?>" class="textbox fWidth"
  onchange="wtos_update_verification_status('final_verification_status_<?php echo $record['mess_meal_member_id']?>', 'mess_meal_member','final_verification_status','mess_meal_member_id','<?php echo $record['mess_meal_member_id']?>','','','','final')" >
  <option value=""></option>	<? $os->onlyOption($os->final_verification_status,$record['final_verification_status']);	?>
	</select>	<br /> 
	
	 <?  } ?>
	 
	 </div>
	 
	  
	  </div>
   </div>
  
  </td>			 
	   							
  
 <td style="font-size:11px;"> <? echo $os->val($all_admin_list,$record['addedBy']); ?> </td> 
  
 
    
  
  							
				 </tr>
                          <? 
						  
						 
						  } ?>  
		<tr> <td ><? echo $today_total_present; ?> </td> <td colspan="4" > Total  </td></tr>					
		<tr> <td colspan="5"> Total Present = <b style="color:#009900; font-weight:bold; font-size:16px;"><? echo $today_total_present_Verified; ?> </b> Final Verified </td></tr>
			
			 
							 
							 
		</table> 
		
	<? } ?>	
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_mess_meal_memberEditAndSave')=='OK')
{
 $mess_meal_member_id=$os->post('mess_meal_member_id');
 
 
		 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['total_student_m']=addslashes($os->post('total_student_m')); 
 $dataToSave['present_student_m']=addslashes($os->post('present_student_m')); 
 $dataToSave['total_student_f']=addslashes($os->post('total_student_f')); 
 $dataToSave['present_student_f']=addslashes($os->post('present_student_f')); 
 $dataToSave['total_teacher_m']=addslashes($os->post('total_teacher_m')); 
 $dataToSave['present_teacher_m']=addslashes($os->post('present_teacher_m')); 
 $dataToSave['total_teacher_f']=addslashes($os->post('total_teacher_f')); 
 $dataToSave['present_teacher_f']=addslashes($os->post('present_teacher_f')); 
 $dataToSave['total_office_staff']=addslashes($os->post('total_office_staff')); 
 $dataToSave['present_office_staff']=addslashes($os->post('present_office_staff')); 
 $dataToSave['total_kichen_staff']=addslashes($os->post('total_kichen_staff')); 
 $dataToSave['present_kichen_staff']=addslashes($os->post('present_kichen_staff')); 
 $dataToSave['total_gurdian_m']=addslashes($os->post('total_gurdian_m')); 
 $dataToSave['present_gurdian_m']=addslashes($os->post('present_gurdian_m')); 
 $dataToSave['total_gurdian_f']=addslashes($os->post('total_gurdian_f')); 
 $dataToSave['present_gurdian_f']=addslashes($os->post('present_gurdian_f')); 
 $dataToSave['total']=addslashes($os->post('total')); 
 $dataToSave['total_present']=addslashes($os->post('total_present')); 
 $dataToSave['primery_verification_user']=addslashes($os->post('primery_verification_user')); 
 $dataToSave['final_verification_user']=addslashes($os->post('final_verification_user')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 
 if($dataToSave['branch_code']==''){
 $dataToSave['branch_code']=$selected_branch_code;
 
 }
 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($mess_meal_member_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('mess_meal_member',$dataToSave,'mess_meal_member_id',$mess_meal_member_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($mess_meal_member_id>0 ){ $mgs= " Data updated Successfully";}
		if($mess_meal_member_id<1 ){ $mgs= " Data Added Successfully"; $mess_meal_member_id=  $qResult;}
		
		  $mgs=$mess_meal_member_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_mess_meal_memberGetById')=='OK')
{
		$mess_meal_member_id=$os->post('mess_meal_member_id');
		
		if($mess_meal_member_id>0)	
		{
		$wheres=" where mess_meal_member_id='$mess_meal_member_id'";
		}
	    $dataQuery=" select * from mess_meal_member  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['dated']=$os->showDate($record['dated']); 
 $record['total_student_m']=$record['total_student_m'];
 $record['present_student_m']=$record['present_student_m'];
 $record['total_student_f']=$record['total_student_f'];
 $record['present_student_f']=$record['present_student_f'];
 $record['total_teacher_m']=$record['total_teacher_m'];
 $record['present_teacher_m']=$record['present_teacher_m'];
 $record['total_teacher_f']=$record['total_teacher_f'];
 $record['present_teacher_f']=$record['present_teacher_f'];
 $record['total_office_staff']=$record['total_office_staff'];
 $record['present_office_staff']=$record['present_office_staff'];
 $record['total_kichen_staff']=$record['total_kichen_staff'];
 $record['present_kichen_staff']=$record['present_kichen_staff'];
 $record['total_gurdian_m']=$record['total_gurdian_m'];
 $record['present_gurdian_m']=$record['present_gurdian_m'];
 $record['total_gurdian_f']=$record['total_gurdian_f'];
 $record['present_gurdian_f']=$record['present_gurdian_f'];
 $record['total']=$record['total'];
 $record['total_present']=$record['total_present'];
 $record['primery_verification_user']=$record['primery_verification_user'];
 $record['final_verification_user']=$record['final_verification_user'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_mess_meal_memberDeleteRowById')=='OK')
{ 

$mess_meal_member_id=$os->post('mess_meal_member_id');
 if($mess_meal_member_id>0){
 $updateQuery="delete from mess_meal_member where mess_meal_member_id='$mess_meal_member_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
