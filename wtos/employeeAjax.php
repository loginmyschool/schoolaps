<? 
/*
   # wtos version : 1.1
   # page called by ajax script in employeeDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_employeeListing')=='OK')

{
	$where='';
	$showPerPage= $os->post('showPerPage');

	
	$andfull_name=  $os->postAndQuery('full_name_s','full_name','%');
	$andshort_name=  $os->postAndQuery('short_name_s','short_name','%');
	$andcontact_no=  $os->postAndQuery('contact_no_s','contact_no','%');

	$f_dob_s= $os->post('f_dob_s'); $t_dob_s= $os->post('t_dob_s');
	$anddob=$os->DateQ('dob',$f_dob_s,$t_dob_s,$sTime='00:00:00',$eTime='59:59:59');
	$anddesignation=  $os->postAndQuery('designation_s','designation','%');
	$andtype=  $os->postAndQuery('type_s','type','%');


	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
		$where ="and ( full_name like '%$searchKey%' Or short_name like '%$searchKey%' Or contact_no like '%$searchKey%' Or designation like '%$searchKey%' Or type like '%$searchKey%' )";

	}

	$listingQuery="  select * from employee where employee_id>0   $where   $andfull_name  $andshort_name  $andcontact_no  $anddob  $anddesignation  $andtype     order by employee_id desc";

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];


	?>
	<div class="listingRecords">
		<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

		<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
			<tr class="borderTitle" >

				<td >#</td>
				<td >Action </td>


				<td ><b>Branch</b></td>  

				<td ><b>Full name</b></td>  
				<td ><b>Short name</b></td>  
				<td ><b>Contact no</b></td>  
				<td ><b>Dob</b></td>  
				<td ><b>Designation</b></td>  
				<td ><b>Type</b></td>  
				<td ><b>Main subject</b></td>  
				<td ><b>Others subject</b></td>  
				<td ><b>Date of joining</b></td>  
				<td ><b>Previous institute</b></td>  
				<td ><b>educational_qualification</b></td>  
				<td ><b>Fathers mothers name</b></td>  
				<td ><b>Language</b></td>  
				<td ><b>Nationality</b></td>  
				<td ><b>Correspondent address</b></td>  
				<td ><b>Permanent address</b></td>  
				<td ><b>Blood group</b></td>  
				<td ><b>Bank details</b></td>  
				<td ><b>Image</b></td>  



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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_employeeGetById('<? echo $record['employee_id'];?>')" >Edit</a></span>  <? } ?>  </td>
							<td> <? if(isset($os->branch_name[$record['branch_name']])){ echo  $os->branch_name[$record['branch_name']]; } ?></td> 
							<td><?php echo $record['full_name']?> </td>  
							<td><?php echo $record['short_name']?> </td>  
							<td><?php echo $record['contact_no']?> </td>  
							<td><?php echo $os->showDate($record['dob']);?> </td>  
							<td><?php echo $record['designation']?> </td>  
							<td> <? if(isset($os->employee_type[$record['type']])){ echo  $os->employee_type[$record['type']]; } ?></td> 
							<td><?php echo $record['main_subject']?> </td>  
							<td><?php echo $record['others_subject']?> </td>  
							<td><?php echo $os->showDate($record['date_of_joining']);?> </td>  
							<td><?php echo $record['previous_institute']?> </td>  
							<td><?php echo $record['educational_qualification']?> </td>  
							<td><?php echo $record['fathers_mothers_name']?> </td>  
							<td> <? if(isset($os->emp_language[$record['language']])){ echo  $os->emp_language[$record['language']]; } ?></td> 
							<td><?php echo $record['nationality']?> </td>  
							<td><?php echo $record['correspondent_address']?> </td>  
							<td><?php echo $record['permanent_address']?> </td>  
							<td> <? if(isset($os->blood_group[$record['blood_group']])){ echo  $os->blood_group[$record['blood_group']]; } ?></td> 
							<td><?php echo $record['bank_details']?> </td>  
							<td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td>  


						</tr>
						<? 


					} ?>  





				</table> 



			</div>

			<br />



			<?php 
			exit();

		}






		if($os->get('WT_employeeEditAndSave')=='OK')
		{
			$employee_id=$os->post('employee_id');



			$dataToSave['full_name']=addslashes($os->post('full_name')); 
			$dataToSave['short_name']=addslashes($os->post('short_name')); 
			$dataToSave['contact_no']=addslashes($os->post('contact_no')); 
			$dataToSave['dob']=$os->saveDate($os->post('dob')); 
			$dataToSave['designation']=addslashes($os->post('designation')); 
			$dataToSave['type']=addslashes($os->post('type')); 
			$dataToSave['main_subject']=addslashes($os->post('main_subject')); 
			$dataToSave['others_subject']=addslashes($os->post('others_subject')); 
			$dataToSave['date_of_joining']=$os->saveDate($os->post('date_of_joining')); 
			$dataToSave['previous_institute']=addslashes($os->post('previous_institute')); 
			$dataToSave['educational_qualification']=addslashes($os->post('educational_qualification')); 
			$dataToSave['fathers_mothers_name']=addslashes($os->post('fathers_mothers_name')); 
			$dataToSave['language']=addslashes($os->post('language')); 
			$dataToSave['nationality']=addslashes($os->post('nationality')); 
			$dataToSave['correspondent_address']=addslashes($os->post('correspondent_address')); 
			$dataToSave['permanent_address']=addslashes($os->post('permanent_address')); 
			$dataToSave['blood_group']=addslashes($os->post('blood_group')); 
			$dataToSave['bank_details']=addslashes($os->post('bank_details')); 
			$dataToSave['branch_name']=addslashes($os->post('branch_name')); 
			
			
			$image=$os->UploadPhoto('image',$site['root'].'wtos-images');
			if($image!=''){
				$dataToSave['image']='wtos-images/'.$image;}




				$dataToSave['modifyDate']=$os->now();
				$dataToSave['modifyBy']=$os->userDetails['adminId']; 

				if($employee_id < 1){

					$dataToSave['addedDate']=$os->now();
					$dataToSave['addedBy']=$os->userDetails['adminId'];
				}


          $qResult=$os->save('employee',$dataToSave,'employee_id',$employee_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
          if($qResult)  
          {
          	if($employee_id>0 ){ $mgs= " Data updated Successfully";}
          	if($employee_id<1 ){ $mgs= " Data Added Successfully"; $employee_id=  $qResult;}

          	$mgs=$employee_id."#-#".$mgs;
          }
          else
          {
          	$mgs="Error#-#Problem Saving Data.";

          }
		//_d($dataToSave);
          echo $mgs;		

          exit();

      } 

      if($os->get('WT_employeeGetById')=='OK')
      {
      	$employee_id=$os->post('employee_id');

      	if($employee_id>0)	
      	{
      		$wheres=" where employee_id='$employee_id'";
      	}
      	$dataQuery=" select * from employee  $wheres ";
      	$rsResults=$os->mq($dataQuery);
      	$record=$os->mfa( $rsResults);


      	$record['full_name']=$record['full_name'];
      	$record['short_name']=$record['short_name'];
      	$record['contact_no']=$record['contact_no'];
      	$record['dob']=$os->showDate($record['dob']); 
      	$record['designation']=$record['designation'];
      	$record['type']=$record['type'];
      	$record['main_subject']=$record['main_subject'];
      	$record['others_subject']=$record['others_subject'];
      	$record['date_of_joining']=$os->showDate($record['date_of_joining']); 
      	$record['previous_institute']=$record['previous_institute'];
      	$record['educational_qualification']=$record['educational_qualification'];
      	$record['fathers_mothers_name']=$record['fathers_mothers_name'];
      	$record['language']=$record['language'];
      	$record['nationality']=$record['nationality'];
      	$record['correspondent_address']=$record['correspondent_address'];
      	$record['permanent_address']=$record['permanent_address'];
      	$record['blood_group']=$record['blood_group'];
      	$record['bank_details']=$record['bank_details'];
      	if($record['image']!=''){
      		$record['image']=$site['url'].$record['image'];}



      		echo  json_encode($record);	 

      		exit();

      	}


      	if($os->get('WT_employeeDeleteRowById')=='OK')
      	{ 

      		$employee_id=$os->post('employee_id');
      		if($employee_id>0){
      			$updateQuery="delete from employee where employee_id='$employee_id'";
      			$os->mq($updateQuery);
      			echo 'Record Deleted Successfully';
      		}
      		exit();
      	}

