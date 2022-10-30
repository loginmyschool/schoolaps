<? 
/*
   # wtos version : 1.1
   # page called by ajax script in questionsDataView.php 
   #  
*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$examDetailsA=$os->getSession('examDetailsA');
?><?

if($os->get('WT_questionsListing')=='OK')
 
{
	
	
    $where='';
	$showPerPage= $os->post('showPerPage');

	
$andexamId=  $os->postAndQuery('examId_s','examId','%');
$andexamdetailsId=  $os->postAndQuery('examdetailsId_s','examdetailsId','%');
$andquestionText=  $os->postAndQuery('questionText_s','questionText','%');
$andanswerText=  $os->postAndQuery('answerText_s','answerText','%');
$andcorrectAnswer=  $os->postAndQuery('correctAnswer_s','correctAnswer','%');
$andmarks=  $os->postAndQuery('marks_s','marks','%');
$andnegetiveMarks=  $os->postAndQuery('negetiveMarks_s','negetiveMarks','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( examId like '%$searchKey%' Or examdetailsId like '%$searchKey%' Or questionText like '%$searchKey%' Or answerText like '%$searchKey%' Or correctAnswer like '%$searchKey%' Or marks like '%$searchKey%' Or negetiveMarks like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from questions where questionsId>0   $where   $andexamId  $andexamdetailsId  $andquestionText  $andanswerText  $andcorrectAnswer  $andmarks  $andnegetiveMarks  $andstatus     order by questionsId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Exam </b></td>  
  <td ><b>Exam Details</b></td>  
  <td ><b>Question Text</b></td>  
  <td ><b>Question Image</b></td>  
  <td ><b>Answer Text</b></td>  
  <td ><b>Answer Image</b></td>  
  <td ><b>Correct Answer</b></td>  
  <td ><b>Marks</b></td>  
  <td ><b>Negetive Marks</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_questionsGetById('<? echo $record['questionsId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('examTitle','exam','examId',$record['examId']); ?></td> 
  <td>  <? //echo $os->rowByField('subjectCode','examdetails','examdetailsId',$record['examdetailsId']);
echo $examDetailsA[$record['examdetailsId']]  ?></td> 
  <td><?php echo $record['questionText']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['questionImage']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['answerText']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['answerImage']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['correctAnswer']?> </td>  
  <td><?php echo $record['marks']?> </td>  
  <td><?php echo $record['negetiveMarks']?> </td>  
  <td> <? if(isset($os->questionStatus[$record['status']])){ echo  $os->questionStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_questionsEditAndSave')=='OK')
{
 $questionsId=$os->post('questionsId');
 
 
		 
 $dataToSave['examId']=addslashes($os->post('examId')); 
 $dataToSave['examdetailsId']=addslashes($os->post('examdetailsId')); 
 $dataToSave['questionText']=addslashes($os->post('questionText')); 
 $questionImage=$os->UploadPhoto('questionImage',$site['root'].'wtos-images');
				   	if($questionImage!=''){
					$dataToSave['questionImage']='wtos-images/'.$questionImage;}
 $dataToSave['answerText']=addslashes($os->post('answerText')); 
 $answerImage=$os->UploadPhoto('answerImage',$site['root'].'wtos-images');
				   	if($answerImage!=''){
					$dataToSave['answerImage']='wtos-images/'.$answerImage;}
 $dataToSave['correctAnswer']=addslashes($os->post('correctAnswer')); 
 $dataToSave['marks']=addslashes($os->post('marks')); 
 $dataToSave['negetiveMarks']=addslashes($os->post('negetiveMarks')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($questionsId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('questions',$dataToSave,'questionsId',$questionsId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($questionsId>0 ){ $mgs= " Data updated Successfully";}
		if($questionsId<1 ){ $mgs= " Data Added Successfully"; $questionsId=  $qResult;}
		
		  $mgs=$questionsId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_questionsGetById')=='OK')
{
		$questionsId=$os->post('questionsId');
		
		if($questionsId>0)	
		{
		$wheres=" where questionsId='$questionsId'";
		}
	    $dataQuery=" select * from questions  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['examId']=$record['examId'];
 $record['examdetailsId']=$record['examdetailsId'];
 $record['questionText']=$record['questionText'];
 if($record['questionImage']!=''){
						$record['questionImage']=$site['url'].$record['questionImage'];}
 $record['answerText']=$record['answerText'];
 if($record['answerImage']!=''){
						$record['answerImage']=$site['url'].$record['answerImage'];}
 $record['correctAnswer']=$record['correctAnswer'];
 $record['marks']=$record['marks'];
 $record['negetiveMarks']=$record['negetiveMarks'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_questionsDeleteRowById')=='OK')
{ 

$questionsId=$os->post('questionsId');
 if($questionsId>0){
 $updateQuery="delete from questions where questionsId='$questionsId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
