<? 
/*
   # wtos version : 1.1
   # page called by ajax script in examdetailsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_examdetailsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andexamId=  $os->postAndQuery('examId_s','examId','%');
$andclass=  $os->postAndQuery('class_s','class','%');
$andsubjectId=  $os->postAndQuery('subjectId_s','subjectId','%');
$andsubjectCode=  $os->postAndQuery('subjectCode_s','subjectCode','%');

    $f_startDate_s= $os->post('f_startDate_s'); $t_startDate_s= $os->post('t_startDate_s');
   $andstartDate=$os->DateQ('startDate',$f_startDate_s,$t_startDate_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_endDate_s= $os->post('f_endDate_s'); $t_endDate_s= $os->post('t_endDate_s');
   $andendDate=$os->DateQ('endDate',$f_endDate_s,$t_endDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andwritten=  $os->postAndQuery('written_s','written','%');
$andviva=  $os->postAndQuery('viva_s','viva','%');
$andpractical=  $os->postAndQuery('practical_s','practical','%');
$andtotalMarks=  $os->postAndQuery('totalMarks_s','totalMarks','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( examId like '%$searchKey%' Or class like '%$searchKey%' Or subjectId like '%$searchKey%' Or subjectCode like '%$searchKey%' Or written like '%$searchKey%' Or viva like '%$searchKey%' Or practical like '%$searchKey%' Or totalMarks like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from examdetails where examdetailsId>0   $where   $andexamId  $andclass  $andsubjectId  $andsubjectCode  $andstartDate  $andendDate  $andwritten  $andviva  $andpractical  $andtotalMarks  $andstatus     order by examdetailsId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Exam</b></td>  
  <td ><b>class</b></td>  
  <td ><b>Subject</b></td>  
  <td ><b>Subject Code</b></td>  
  <td ><b>Start Date</b></td>  
  <td ><b>End Date</b></td>  
  <td ><b>Written</b></td>  
  <td ><b>Viva</b></td>  
  <td ><b>Practical</b></td>  
  <td ><b>Total Marks</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_examdetailsGetById('<? echo $record['examdetailsId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('examTitle','exam','examId',$record['examId']); ?></td> 
  <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td> 
  <td>  <? echo 
	$os->rowByField('subjectName','subject','subjectId',$record['subjectId']); ?></td> 
  <td><?php echo $record['subjectCode']?> </td>  
  <td><?php echo $os->showDate($record['startDate']);?> </td>  
  <td><?php echo $os->showDate($record['endDate']);?> </td>  
  <td><?php echo $record['written']?> </td>  
  <td><?php echo $record['viva']?> </td>  
  <td><?php echo $record['practical']?> </td>  
  <td><?php echo $record['totalMarks']?> </td>  
  <td> <? if(isset($os->examDetailsStatus[$record['status']])){ echo  $os->examDetailsStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_examdetailsEditAndSave')=='OK')
{
 $examdetailsId=$os->post('examdetailsId');
 
 
		 
 $dataToSave['examId']=addslashes($os->post('examId')); 
 $dataToSave['class']=addslashes($os->post('class')); 
 $dataToSave['subjectId']=addslashes($os->post('subjectId')); 
 $dataToSave['subjectCode']=addslashes($os->post('subjectCode')); 
 $dataToSave['startDate']=$os->saveDate($os->post('startDate')); 
 $dataToSave['endDate']=$os->saveDate($os->post('endDate')); 
 $dataToSave['written']=addslashes($os->post('written')); 
 $dataToSave['viva']=addslashes($os->post('viva')); 
 $dataToSave['practical']=addslashes($os->post('practical')); 
 $dataToSave['totalMarks']=addslashes($os->post('totalMarks')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($examdetailsId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('examdetails',$dataToSave,'examdetailsId',$examdetailsId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($examdetailsId>0 ){ $mgs= " Data updated Successfully";}
		if($examdetailsId<1 ){ $mgs= " Data Added Successfully"; $examdetailsId=  $qResult;}
		
		  $mgs=$examdetailsId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_examdetailsGetById')=='OK')
{
		$examdetailsId=$os->post('examdetailsId');
		
		if($examdetailsId>0)	
		{
		$wheres=" where examdetailsId='$examdetailsId'";
		}
	    $dataQuery=" select * from examdetails  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['examId']=$record['examId'];
 $record['class']=$record['class'];
 $record['subjectId']=$record['subjectId'];
 $record['subjectCode']=$record['subjectCode'];
 $record['startDate']=$os->showDate($record['startDate']); 
 $record['endDate']=$os->showDate($record['endDate']); 
 $record['written']=$record['written'];
 $record['viva']=$record['viva'];
 $record['practical']=$record['practical'];
 $record['totalMarks']=$record['totalMarks'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_examdetailsDeleteRowById')=='OK')
{ 

$examdetailsId=$os->post('examdetailsId');
 if($examdetailsId>0){
 $updateQuery="delete from examdetails where examdetailsId='$examdetailsId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
