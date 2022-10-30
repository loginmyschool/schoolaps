<? 
/*
   # wtos version : 1.1
   # page called by ajax script in subjectDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_subjectListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andsubjectName=  $os->postAndQuery('subjectName_s','subjectName','%');
$andsubjectStatus=  $os->postAndQuery('subjectStatus_s','subjectStatus','%');
$andpriority=  $os->postAndQuery('priority_s','priority','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( subjectName like '%$searchKey%' Or subjectStatus like '%$searchKey%' Or priority like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from subject where subjectId>0   $where   $andsubjectName  $andsubjectStatus  $andpriority     order by subjectId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Subject Name</b></td>  
  <td ><b>Subject Status</b></td>  
  <td ><b>Priority</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_subjectGetById('<? echo $record['subjectId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['subjectName']?> </td>  
  <td> <? if(isset($os->subjectStatus[$record['subjectStatus']])){ echo  $os->subjectStatus[$record['subjectStatus']]; } ?></td> 
  <td><?php echo $record['priority']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_subjectEditAndSave')=='OK')
{
 $subjectId=$os->post('subjectId');
 
 
		 
 $dataToSave['subjectName']=addslashes($os->post('subjectName')); 
 $dataToSave['subjectStatus']=addslashes($os->post('subjectStatus')); 
 $dataToSave['priority']=addslashes($os->post('priority')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($subjectId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('subject',$dataToSave,'subjectId',$subjectId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($subjectId>0 ){ $mgs= " Data updated Successfully";}
		if($subjectId<1 ){ $mgs= " Data Added Successfully"; $subjectId=  $qResult;}
		
		  $mgs=$subjectId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_subjectGetById')=='OK')
{
		$subjectId=$os->post('subjectId');
		
		if($subjectId>0)	
		{
		$wheres=" where subjectId='$subjectId'";
		}
	    $dataQuery=" select * from subject  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['subjectName']=$record['subjectName'];
 $record['subjectStatus']=$record['subjectStatus'];
 $record['priority']=$record['priority'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_subjectDeleteRowById')=='OK')
{ 

$subjectId=$os->post('subjectId');
 if($subjectId>0){
 $updateQuery="delete from subject where subjectId='$subjectId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
