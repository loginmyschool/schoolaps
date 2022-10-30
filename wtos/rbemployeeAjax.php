<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbemployeeDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbemployeeListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$anddesignation=  $os->postAndQuery('designation_s','designation','%');

    $f_doj_s= $os->post('f_doj_s'); $t_doj_s= $os->post('t_doj_s');
   $anddoj=$os->DateQ('doj',$f_doj_s,$t_doj_s,$sTime='00:00:00',$eTime='59:59:59');
$andmoble=  $os->postAndQuery('moble_s','moble','%');
$andphone=  $os->postAndQuery('phone_s','phone','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or designation like '%$searchKey%' Or moble like '%$searchKey%' Or phone like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbemployee where rbemployeeId>0   $where   $andname  $anddesignation  $anddoj  $andmoble  $andphone  $andstatus     order by rbemployeeId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Name</b></td>  
  <td ><b>Designation</b></td>  
  <td ><b>DOJ</b></td>  
  <td ><b>Moble</b></td>  
  <td ><b>Status</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbemployeeGetById('<? echo $record['rbemployeeId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $record['designation']?> </td>  
  <td><?php echo $os->showDate($record['doj']);?> </td>  
  <td><?php echo $record['moble']?> </td>  
  <td> <? if(isset($os->activeInactive[$record['status']])){ echo  $os->activeInactive[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbemployeeEditAndSave')=='OK')
{
 $rbemployeeId=$os->post('rbemployeeId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['designation']=addslashes($os->post('designation')); 
 $dataToSave['dob']=$os->saveDate($os->post('dob')); 
 $dataToSave['doj']=$os->saveDate($os->post('doj')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['moble']=addslashes($os->post('moble')); 
 $dataToSave['phone']=addslashes($os->post('phone')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['reffBy']=addslashes($os->post('reffBy')); 
 $dataToSave['startSalary']=addslashes($os->post('startSalary')); 
 $dataToSave['permaAddress']=addslashes($os->post('permaAddress')); 
 $dataToSave['leavDate']=$os->saveDate($os->post('leavDate')); 
 $dataToSave['leaveReason']=addslashes($os->post('leaveReason')); 
 $dataToSave['status']=addslashes($os->post('status')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbemployeeId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbemployee',$dataToSave,'rbemployeeId',$rbemployeeId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbemployeeId>0 ){ $mgs= " Data updated Successfully";}
		if($rbemployeeId<1 ){ $mgs= " Data Added Successfully"; $rbemployeeId=  $qResult;}
		
		  $mgs=$rbemployeeId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbemployeeGetById')=='OK')
{
		$rbemployeeId=$os->post('rbemployeeId');
		
		if($rbemployeeId>0)	
		{
		$wheres=" where rbemployeeId='$rbemployeeId'";
		}
	    $dataQuery=" select * from rbemployee  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['designation']=$record['designation'];
 $record['dob']=$os->showDate($record['dob']); 
 $record['doj']=$os->showDate($record['doj']); 
 $record['address']=$record['address'];
 $record['moble']=$record['moble'];
 $record['phone']=$record['phone'];
 $record['email']=$record['email'];
 $record['reffBy']=$record['reffBy'];
 $record['startSalary']=$record['startSalary'];
 $record['permaAddress']=$record['permaAddress'];
 $record['leavDate']=$os->showDate($record['leavDate']); 
 $record['leaveReason']=$record['leaveReason'];
 $record['status']=$record['status'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbemployeeDeleteRowById')=='OK')
{ 

$rbemployeeId=$os->post('rbemployeeId');
 if($rbemployeeId>0){
 $updateQuery="delete from rbemployee where rbemployeeId='$rbemployeeId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
