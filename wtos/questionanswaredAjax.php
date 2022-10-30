<? 
/*
   # wtos version : 1.1
   # page called by ajax script in questionanswaredDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$examDetailsA=$os->getSession('examDetailsA');
 $resultA=$os->getSession('resultA'); 
?><?

if($os->get('WT_questionanswaredListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andquestionsId=  $os->postAndQuery('questionsId_s','questionsId','%');
$andexamId=  $os->postAndQuery('examId_s','examId','%');
$andexamdetailsId=  $os->postAndQuery('examdetailsId_s','examdetailsId','%');
$andresultsId=  $os->postAndQuery('resultsId_s','resultsId','%');
$andstudentId=  $os->postAndQuery('studentId_s','studentId','%');
$andanswerSelected=  $os->postAndQuery('answerSelected_s','answerSelected','%');
$andmarks=  $os->postAndQuery('marks_s','marks','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( questionsId like '%$searchKey%' Or examId like '%$searchKey%' Or examdetailsId like '%$searchKey%' Or resultsId like '%$searchKey%' Or studentId like '%$searchKey%' Or answerSelected like '%$searchKey%' Or marks like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from questionanswared where questionanswaredId>0   $where   $andquestionsId  $andexamId  $andexamdetailsId  $andresultsId  $andstudentId  $andanswerSelected  $andmarks  $andstatus     order by questionanswaredId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Questions</b></td>  
  <td ><b>Exam</b></td>  
  <td ><b>Exam details</b></td>  
  <td ><b>Results</b></td>  
  <td ><b>Student</b></td>  
  <td ><b>Answer Selected</b></td>  
  <td ><b>Marks</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_questionanswaredGetById('<? echo $record['questionanswaredId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('questionText','questions','questionsId',$record['questionsId']); ?></td> 
  <td>  <? echo 
	$os->rowByField('examTitle','exam','examId',$record['examId']); ?></td> 
  <td><? echo $examDetailsA[$record['examdetailsId']]  ?> </td>  
  <td><?php echo $resultA[$record['resultsId']]?> </td>  
  <td>  <? echo 
	$os->rowByField('name','student','studentId',$record['studentId']); ?></td> 
  <td><?php echo $record['answerSelected']?> </td>  
  <td><?php echo $record['marks']?> </td>  
  <td> <? if(isset($os->questionAnswerStatus[$record['status']])){ echo  $os->questionAnswerStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_questionanswaredEditAndSave')=='OK')
{
 $questionanswaredId=$os->post('questionanswaredId');
 
 
		 
 $dataToSave['questionsId']=addslashes($os->post('questionsId')); 
 $dataToSave['examId']=addslashes($os->post('examId')); 
 $dataToSave['examdetailsId']=addslashes($os->post('examdetailsId')); 
 $dataToSave['resultsId']=addslashes($os->post('resultsId')); 
 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['answerSelected']=addslashes($os->post('answerSelected')); 
 $dataToSave['marks']=addslashes($os->post('marks')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($questionanswaredId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('questionanswared',$dataToSave,'questionanswaredId',$questionanswaredId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($questionanswaredId>0 ){ $mgs= " Data updated Successfully";}
		if($questionanswaredId<1 ){ $mgs= " Data Added Successfully"; $questionanswaredId=  $qResult;}
		
		  $mgs=$questionanswaredId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_questionanswaredGetById')=='OK')
{
		$questionanswaredId=$os->post('questionanswaredId');
		
		if($questionanswaredId>0)	
		{
		$wheres=" where questionanswaredId='$questionanswaredId'";
		}
	    $dataQuery=" select * from questionanswared  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['questionsId']=$record['questionsId'];
 $record['examId']=$record['examId'];
 $record['examdetailsId']=$record['examdetailsId'];
 $record['resultsId']=$record['resultsId'];
 $record['studentId']=$record['studentId'];
 $record['answerSelected']=$record['answerSelected'];
 $record['marks']=$record['marks'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_questionanswaredDeleteRowById')=='OK')
{ 

$questionanswaredId=$os->post('questionanswaredId');
 if($questionanswaredId>0){
 $updateQuery="delete from questionanswared where questionanswaredId='$questionanswaredId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
