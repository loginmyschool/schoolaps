<? 
/*
   # wtos version : 1.1
   # page called by ajax script in session_lengthDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_session_lengthListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	

    $f_from_date_s= $os->post('f_from_date_s'); $t_from_date_s= $os->post('t_from_date_s');
   $andfrom_date=$os->DateQ('from_date',$f_from_date_s,$t_from_date_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_to_date_s= $os->post('f_to_date_s'); $t_to_date_s= $os->post('t_to_date_s');
   $andto_date=$os->DateQ('to_date',$f_to_date_s,$t_to_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andyear=  $os->postAndQuery('year_s','year','%');
$andclassId=  $os->postAndQuery('classId_s','classId','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( year like '%$searchKey%' Or classId like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from session_length where session_length_id>0   $where   $andfrom_date  $andto_date  $andyear  $andclassId     order by session_length_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>From Date</b></td>  
  <td ><b>To Date</b></td>  
  <td ><b>Year</b></td>  
  <td ><b>Class</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_session_lengthGetById('<? echo $record['session_length_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $os->showDate($record['from_date']);?> </td>  
  <td><?php echo $os->showDate($record['to_date']);?> </td>  
  <td> <? if(isset($os->feesYear[$record['year']])){ echo  $os->feesYear[$record['year']]; } ?></td> 
  <td> <? if(isset($os->classList[$record['classId']])){ echo  $os->classList[$record['classId']]; } ?></td> <br />
 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_session_lengthEditAndSave')=='OK')
{
 $session_length_id=$os->post('session_length_id');
 
 
		 
 $dataToSave['from_date']=$os->saveDate($os->post('from_date')); 
 $dataToSave['to_date']=$os->saveDate($os->post('to_date')); 
 $dataToSave['year']=addslashes($os->post('year')); 
 $dataToSave['classId']=addslashes($os->post('classId')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($session_length_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('session_length',$dataToSave,'session_length_id',$session_length_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($session_length_id>0 ){ $mgs= " Data updated Successfully";}
		if($session_length_id<1 ){ $mgs= " Data Added Successfully"; $session_length_id=  $qResult;}
		
		  $mgs=$session_length_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_session_lengthGetById')=='OK')
{
		$session_length_id=$os->post('session_length_id');
		
		if($session_length_id>0)	
		{
		$wheres=" where session_length_id='$session_length_id'";
		}
	    $dataQuery=" select * from session_length  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['from_date']=$os->showDate($record['from_date']); 
 $record['to_date']=$os->showDate($record['to_date']); 
 $record['year']=$record['year'];
 $record['classId']=$record['classId'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 if($os->get('WT_session_lengthDeleteRowById')=='OK')
{ 

		$session_length_id=$os->post('session_length_id');
		 if($session_length_id>0){
		 $updateQuery="delete from session_length where session_length_id='$session_length_id'";
		 $os->mq($updateQuery);
			echo 'Record Deleted Successfully';
		 }
		 exit();
}

