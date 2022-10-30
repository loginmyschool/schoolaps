<? 
/*
   # wtos version : 1.1
   # page called by ajax script in questionDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_questionListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andexamdetailsId=  $os->postAndQuery('examdetailsId_s','examdetailsId','%');
$andcode=  $os->postAndQuery('code_s','code','%');
$andsubjectId=  $os->postAndQuery('subjectId_s','subjectId','%');
$andclassId=  $os->postAndQuery('classId_s','classId','%');
$andboardId=  $os->postAndQuery('boardId_s','boardId','%');
$andteacherId=  $os->postAndQuery('teacherId_s','teacherId','%');
$andmarks=  $os->postAndQuery('marks_s','marks','%');
$andnegetive_marks=  $os->postAndQuery('negetive_marks_s','negetive_marks','%');
$andviewOrder=  $os->postAndQuery('viewOrder_s','viewOrder','%');
$andoverAllStar=  $os->postAndQuery('overAllStar_s','overAllStar','%');
$andtype=  $os->postAndQuery('type_s','type','%');
$andquestionText=  $os->postAndQuery('questionText_s','questionText','%');
$andquestionImage=  $os->postAndQuery('questionImage_s','questionImage','%');
$andanswerText1=  $os->postAndQuery('answerText1_s','answerText1','%');
$andanswerImage1=  $os->postAndQuery('answerImage1_s','answerImage1','%');
$andanswerText2=  $os->postAndQuery('answerText2_s','answerText2','%');
$andanswerImage2=  $os->postAndQuery('answerImage2_s','answerImage2','%');
$andanswerText3=  $os->postAndQuery('answerText3_s','answerText3','%');
$andanswerImage3=  $os->postAndQuery('answerImage3_s','answerImage3','%');
$andanswerText4=  $os->postAndQuery('answerText4_s','answerText4','%');
$andanswerImage4=  $os->postAndQuery('answerImage4_s','answerImage4','%');
$andcorrectAnswer=  $os->postAndQuery('correctAnswer_s','correctAnswer','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( examdetailsId like '%$searchKey%' Or code like '%$searchKey%' Or subjectId like '%$searchKey%' Or classId like '%$searchKey%' Or boardId like '%$searchKey%' Or teacherId like '%$searchKey%' Or marks like '%$searchKey%' Or negetive_marks like '%$searchKey%' Or viewOrder like '%$searchKey%' Or overAllStar like '%$searchKey%' Or type like '%$searchKey%' Or questionText like '%$searchKey%' Or questionImage like '%$searchKey%' Or answerText1 like '%$searchKey%' Or answerImage1 like '%$searchKey%' Or answerText2 like '%$searchKey%' Or answerImage2 like '%$searchKey%' Or answerText3 like '%$searchKey%' Or answerImage3 like '%$searchKey%' Or answerText4 like '%$searchKey%' Or answerImage4 like '%$searchKey%' Or correctAnswer like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from question where questionId>0   $where   $andexamdetailsId  $andcode  $andsubjectId  $andclassId  $andboardId  $andteacherId  $andmarks  $andnegetive_marks  $andviewOrder  $andoverAllStar  $andtype  $andquestionText  $andquestionImage  $andanswerText1  $andanswerImage1  $andanswerText2  $andanswerImage2  $andanswerText3  $andanswerImage3  $andanswerText4  $andanswerImage4  $andcorrectAnswer  $andstatus     order by questionId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Exam details </b></td>  
  <td ><b>Code</b></td>  
  <td ><b>Subject</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Board</b></td>  
  <td ><b>Teacher</b></td>  
  <td ><b>Marks</b></td>  
  <td ><b>Negetive marks</b></td>  
  <td ><b>View order</b></td>  
  <td ><b>Over All Star</b></td>  
  <td ><b>Type</b></td>  
  <td ><b>Question Text</b></td>  
  <td ><b>Question Image</b></td>  
  <td ><b>Answer Text</b></td>  
  <td ><b>Answer Image</b></td>  
  <td ><b>Answer Text</b></td>  
  <td ><b>Answer Image</b></td>  
  <td ><b>Answer Text</b></td>  
  <td ><b>Answer Image</b></td>  
  <td ><b>Answer Text</b></td>  
  <td ><b>Answer Image</b></td>  
  <td ><b>Correct Answer</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_questionGetById('<? echo $record['questionId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('subjectCode','examdetails','examdetailsId',$record['examdetailsId']); ?></td> 
  <td><?php echo $record['code']?> </td>  
  <td>  <? echo 
	$os->rowByField('subjectName','subject','subjectId',$record['subjectId']); ?></td> 
  <td><?php echo $record['classId']?> </td>  
  <td><?php echo $record['boardId']?> </td>  
  <td>  <? echo 
	$os->rowByField('name','teacher','teacherId',$record['teacherId']); ?></td> 
  <td><?php echo $record['marks']?> </td>  
  <td><?php echo $record['negetive_marks']?> </td>  
  <td><?php echo $record['viewOrder']?> </td>  
  <td><?php echo $record['overAllStar']?> </td>  
  <td> <? if(isset($os->questionType[$record['type']])){ echo  $os->questionType[$record['type']]; } ?></td> 
  <td><?php echo $record['questionText']?> </td>  
  <td><?php echo $record['questionImage']?> </td>  
  <td><?php echo $record['answerText1']?> </td>  
  <td><?php echo $record['answerImage1']?> </td>  
  <td><?php echo $record['answerText2']?> </td>  
  <td><?php echo $record['answerImage2']?> </td>  
  <td><?php echo $record['answerText3']?> </td>  
  <td><?php echo $record['answerImage3']?> </td>  
  <td><?php echo $record['answerText4']?> </td>  
  <td><?php echo $record['answerImage4']?> </td>  
  <td><?php echo $record['correctAnswer']?> </td>  
  <td> <? if(isset($os->activeStatus[$record['status']])){ echo  $os->activeStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_questionEditAndSave')=='OK')
{
 $questionId=$os->post('questionId');
 
 
		 
 $dataToSave['examdetailsId']=addslashes($os->post('examdetailsId')); 
 $dataToSave['code']=addslashes($os->post('code')); 
 $dataToSave['subjectId']=addslashes($os->post('subjectId')); 
 $dataToSave['classId']=addslashes($os->post('classId')); 
 $dataToSave['boardId']=addslashes($os->post('boardId')); 
 $dataToSave['teacherId']=addslashes($os->post('teacherId')); 
 $dataToSave['marks']=addslashes($os->post('marks')); 
 $dataToSave['negetive_marks']=addslashes($os->post('negetive_marks')); 
 $dataToSave['viewOrder']=addslashes($os->post('viewOrder')); 
 $dataToSave['overAllStar']=addslashes($os->post('overAllStar')); 
 $dataToSave['type']=addslashes($os->post('type')); 
 $dataToSave['questionText']=addslashes($os->post('questionText')); 
 $dataToSave['questionImage']=addslashes($os->post('questionImage')); 
 $dataToSave['answerText1']=addslashes($os->post('answerText1')); 
 $dataToSave['answerImage1']=addslashes($os->post('answerImage1')); 
 $dataToSave['answerText2']=addslashes($os->post('answerText2')); 
 $dataToSave['answerImage2']=addslashes($os->post('answerImage2')); 
 $dataToSave['answerText3']=addslashes($os->post('answerText3')); 
 $dataToSave['answerImage3']=addslashes($os->post('answerImage3')); 
 $dataToSave['answerText4']=addslashes($os->post('answerText4')); 
 $dataToSave['answerImage4']=addslashes($os->post('answerImage4')); 
 $dataToSave['correctAnswer']=addslashes($os->post('correctAnswer')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($questionId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('question',$dataToSave,'questionId',$questionId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($questionId>0 ){ $mgs= " Data updated Successfully";}
		if($questionId<1 ){ $mgs= " Data Added Successfully"; $questionId=  $qResult;}
		
		  $mgs=$questionId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_questionGetById')=='OK')
{
		$questionId=$os->post('questionId');
		
		if($questionId>0)	
		{
		$wheres=" where questionId='$questionId'";
		}
	    $dataQuery=" select * from question  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['examdetailsId']=$record['examdetailsId'];
 $record['code']=$record['code'];
 $record['subjectId']=$record['subjectId'];
 $record['classId']=$record['classId'];
 $record['boardId']=$record['boardId'];
 $record['teacherId']=$record['teacherId'];
 $record['marks']=$record['marks'];
 $record['negetive_marks']=$record['negetive_marks'];
 $record['viewOrder']=$record['viewOrder'];
 $record['overAllStar']=$record['overAllStar'];
 $record['type']=$record['type'];
 $record['questionText']=$record['questionText'];
 $record['questionImage']=$record['questionImage'];
 $record['answerText1']=$record['answerText1'];
 $record['answerImage1']=$record['answerImage1'];
 $record['answerText2']=$record['answerText2'];
 $record['answerImage2']=$record['answerImage2'];
 $record['answerText3']=$record['answerText3'];
 $record['answerImage3']=$record['answerImage3'];
 $record['answerText4']=$record['answerText4'];
 $record['answerImage4']=$record['answerImage4'];
 $record['correctAnswer']=$record['correctAnswer'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_questionDeleteRowById')=='OK')
{ 

$questionId=$os->post('questionId');
 if($questionId>0){
 $updateQuery="delete from question where questionId='$questionId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
