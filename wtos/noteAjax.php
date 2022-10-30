<? 
/*
   # wtos version : 1.1
   # page called by ajax script in noteDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_noteListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andsubject=  $os->postAndQuery('subject_s','subject','%');
$anddetails=  $os->postAndQuery('details_s','details','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( subject like '%$searchKey%' Or details like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from note where noteId>0   $where   $andsubject  $anddetails     order by noteId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Subject</b></td>  
  <td ><b>Details</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_noteGetById('<? echo $record['noteId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['subject']?> </td>  
  <td><?php echo $record['details']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_noteEditAndSave')=='OK')
{
 $noteId=$os->post('noteId');
 
 
		 
 $dataToSave['subject']=addslashes($os->post('subject')); 
 $dataToSave['details']=addslashes($os->post('details')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($noteId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('note',$dataToSave,'noteId',$noteId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($noteId>0 ){ $mgs= " Data updated Successfully";}
		if($noteId<1 ){ $mgs= " Data Added Successfully"; $noteId=  $qResult;}
		
		  $mgs=$noteId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_noteGetById')=='OK')
{
		$noteId=$os->post('noteId');
		
		if($noteId>0)	
		{
		$wheres=" where noteId='$noteId'";
		}
	    $dataQuery=" select * from note  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['subject']=$record['subject'];
 $record['details']=$record['details'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_noteDeleteRowById')=='OK')
{ 

$noteId=$os->post('noteId');
 if($noteId>0){
 $updateQuery="delete from note where noteId='$noteId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
