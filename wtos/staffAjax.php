<? 
/*
   # wtos version : 1.1
   # page called by ajax script in staffDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_staffListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$anddesignation=  $os->postAndQuery('designation_s','designation','%');
$andmobile=  $os->postAndQuery('mobile_s','mobile','%');
$andaddress=  $os->postAndQuery('address_s','address','%');
$andpriority=  $os->postAndQuery('priority_s','priority','%');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andnote=  $os->postAndQuery('note_s','note','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or designation like '%$searchKey%' Or mobile like '%$searchKey%' Or address like '%$searchKey%' Or priority like '%$searchKey%' Or status like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from staff where staffId>0   $where   $andname  $anddesignation  $andmobile  $andaddress  $andpriority  $andstatus  $andnote     order by staffId desc";
	  
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
  <td ><b>Mobile No</b></td>  
  <td ><b>Address</b></td>  
  <td ><b>Priority</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Note</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="checkEditDeletePassword('<? echo $record['staffId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $record['designation']?> </td>  
  <td><?php echo $record['mobile']?> </td>  
  <td><?php echo $record['address']?> </td>  
  <td><?php echo $record['priority']?> </td>  
  <td> <? if(isset($os->staffStatus[$record['status']])){ echo  $os->staffStatus[$record['status']]; } ?></td> 
  <td><?php echo $record['note']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_staffEditAndSave')=='OK')
{
 $staffId=$os->post('staffId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['designation']=addslashes($os->post('designation')); 
 $dataToSave['mobile']=addslashes($os->post('mobile')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['priority']=addslashes($os->post('priority')); 
 $dataToSave['status']=addslashes($os->post('status')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($staffId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('staff',$dataToSave,'staffId',$staffId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($staffId>0 ){ $mgs= " Data updated Successfully";}
		if($staffId<1 ){ $mgs= " Data Added Successfully"; $staffId=  $qResult;}
		
		  $mgs=$staffId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
 
 
 
 
 
 if($os->get('checkEditDeletePassword')=='OK')
{
	
	 $staffId=$os->post('staffId');
	 $password=$os->post('password');
	$operationType=$os->post('operationType');
    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
	if($password==$editDeletePassword)
	{
		//echo "password matched#-#".$staffId;
		$msg="password matched#-#".$staffId."#-#Edit Data";
		if($operationType=='deleteData')
		{
			$msg="password matched#-#".$staffId."#-#Delete Data";
		}
	}
	else
	{
		$msg="wrong password";
	}
	echo $msg;
	exit();
	
}


 
 
 
if($os->get('WT_staffGetById')=='OK')
{
		$staffId=$os->post('staffId');
		
		if($staffId>0)	
		{
		$wheres=" where staffId='$staffId'";
		}
	    $dataQuery=" select * from staff  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['designation']=$record['designation'];
 $record['mobile']=$record['mobile'];
 $record['address']=$record['address'];
 $record['priority']=$record['priority'];
 $record['status']=$record['status'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_staffDeleteRowById')=='OK')
{ 

$staffId=$os->post('staffId');
 if($staffId>0){
 $updateQuery="delete from staff where staffId='$staffId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
