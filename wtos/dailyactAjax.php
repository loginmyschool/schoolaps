<? 
/*
   # wtos version : 1.1
   # page called by ajax script in dailyactDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_dailyactListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
$anddescription=  $os->postAndQuery('description_s','description','%');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andadminId=  $os->postAndQuery('adminId_s','adminId','%');
$andverifyStatus=  $os->postAndQuery('verifyStatus_s','verifyStatus','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( description like '%$searchKey%' Or status like '%$searchKey%' Or adminId like '%$searchKey%' Or verifyStatus like '%$searchKey%' )";
 
	}
	

$useradminId=$os->userDetails['adminId'];
$andOnlyUser=" and adminId ='$useradminId'";
if($os->isSuperAdmin()){ 
   $andOnlyUser='';
}
	
		
	$listingQuery="  select * from dailyact where dailyactId>0   $where   $anddated  $anddescription  $andstatus  $andadminId  $andverifyStatus $andOnlyUser     order by dailyactId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Date</b></td>  
  <td ><b>description</b></td>  
  <td ><b>status</b></td>  
  <td ><b>User</b></td>  
  <td ><b>Verify Status</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_dailyactGetById('<? echo $record['dailyactId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $os->showDate($record['dated']);?> </td>  
  <td><?php echo $record['description']?> </td>  
  <td> <? if(isset($os->dailystatus[$record['status']])){ echo  $os->dailystatus[$record['status']]; } ?></td> 
  <td>  <? echo 
	$os->rowByField('name','admin','adminId',$record['adminId']); ?></td> 
  <td> <? if(isset($os->verifyStatus[$record['verifyStatus']])){ echo  $os->verifyStatus[$record['verifyStatus']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_dailyactEditAndSave')=='OK')
{
 $dailyactId=$os->post('dailyactId');
 
 
		 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['description']=addslashes($os->post('description')); 
 $dataToSave['status']=addslashes($os->post('status')); 
  $dataToSave['adminId']=addslashes($os->post('adminId')); 

 $dataToSave['verifyStatus']=addslashes($os->post('verifyStatus')); 

		$useradminId=$os->userDetails['adminId'];
		if(!$os->isSuperAdmin()){ 
		 $dataToSave['adminId']=$useradminId; 
		}
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($dailyactId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('dailyact',$dataToSave,'dailyactId',$dailyactId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($dailyactId>0 ){ $mgs= " Data updated Successfully";}
		if($dailyactId<1 ){ $mgs= " Data Added Successfully"; $dailyactId=  $qResult;}
		
		  $mgs=$dailyactId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_dailyactGetById')=='OK')
{
		$dailyactId=$os->post('dailyactId');
		
		if($dailyactId>0)	
		{
		$wheres=" where dailyactId='$dailyactId'";
		}
	    $dataQuery=" select * from dailyact  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['dated']=$os->showDate($record['dated']); 
 $record['description']=$record['description'];
 $record['status']=$record['status'];
 $record['adminId']=$record['adminId'];
 $record['verifyStatus']=$record['verifyStatus'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_dailyactDeleteRowById')=='OK')
{ 

$dailyactId=$os->post('dailyactId');
 if($dailyactId>0){
 $updateQuery="delete from dailyact where dailyactId='$dailyactId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
