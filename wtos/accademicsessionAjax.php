<? 
/*
   # wtos version : 1.1
   # page called by ajax script in accademicsessionDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_accademicsessionListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andidKey=  $os->postAndQuery('idKey_s','idKey','%');
$andtitle=  $os->postAndQuery('title_s','title','%');
$andstatus=  $os->postAndQuery('status_s','status','=');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( idKey like '%$searchKey%' Or title like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from accademicsession where accademicsessionId>0   $where   $andidKey  $andtitle  $andstatus     order by accademicsessionId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Key</b></td>  
  <td ><b>Title</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="checkEditDeletePassword('<? echo $record['accademicsessionId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['idKey']?> </td>  
  <td><?php echo $record['title']?> </td>  
  <td> <? if(isset($os->academicSessionStatus[$record['status']])){ echo  $os->academicSessionStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_accademicsessionEditAndSave')=='OK')
{
 $accademicsessionId=$os->post('accademicsessionId');
 
 
		 
 $dataToSave['idKey']=addslashes($os->post('idKey')); 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($accademicsessionId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('accademicsession',$dataToSave,'accademicsessionId',$accademicsessionId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($accademicsessionId>0 ){ $mgs= " Data updated Successfully";}
		if($accademicsessionId<1 ){ $mgs= " Data Added Successfully"; $accademicsessionId=  $qResult;}
		
		  $mgs=$accademicsessionId."#-#".$mgs;
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
	
	 $accademicsessionId=$os->post('accademicsessionId');
	 $password=$os->post('password');
	
    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
	if($password==$editDeletePassword)
	{
		echo "password matched#-#".$accademicsessionId;
	}
	else
	{
		echo "wrong password";
	}
	exit();
	
}




 
if($os->get('WT_accademicsessionGetById')=='OK')
{
		$accademicsessionId=$os->post('accademicsessionId');
		
		if($accademicsessionId>0)	
		{
		$wheres=" where accademicsessionId='$accademicsessionId'";
		}
	    $dataQuery=" select * from accademicsession  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['idKey']=$record['idKey'];
 $record['title']=$record['title'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_accademicsessionDeleteRowById')=='OK')
{ 

$accademicsessionId=$os->post('accademicsessionId');
 if($accademicsessionId>0){
 $updateQuery="delete from accademicsession where accademicsessionId='$accademicsessionId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
