<? 
/*
   # wtos version : 1.1
   # page called by ajax script in question_bankDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

$os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
$os->question_type_arr=array('MCQ'=>'MCQ','DESC'=>'DESC');
$os->question_base_arr=array('Informative'=>'Informative','Math'=>'Math');
$os->active_status = array('1'=>'1','2'=>'2','3'=>'3' );
$os->correctAnswer_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4' );
 
?><?

if($os->get('WT_question_bankListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andcode=  $os->postAndQuery('code_s','code','%');
$andsubjectId=  $os->postAndQuery('subjectId_s','subjectId','%');
$andclassId=  $os->postAndQuery('classId_s','classId','%');
$andboardId=  $os->postAndQuery('boardId_s','boardId','%');
$andtype=  $os->postAndQuery('type_s','type','%');
$andquestionText=  $os->postAndQuery('questionText_s','questionText','%');
$andanswerText1=  $os->postAndQuery('answerText1_s','answerText1','%');
$andanswerText2=  $os->postAndQuery('answerText2_s','answerText2','%');
$andanswerText3=  $os->postAndQuery('answerText3_s','answerText3','%');
$andanswerText4=  $os->postAndQuery('answerText4_s','answerText4','%');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andquestion_chapter_id=  $os->postAndQuery('question_chapter_id_s','question_chapter_id','%');
$andquestion_topic_id=  $os->postAndQuery('question_topic_id_s','question_topic_id','%');
$andlevel=  $os->postAndQuery('level_s','level','%');
$andquestion_base=  $os->postAndQuery('question_base_s','question_base','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( code like '%$searchKey%' Or subjectId like '%$searchKey%' Or classId like '%$searchKey%' Or boardId like '%$searchKey%' Or type like '%$searchKey%' Or questionText like '%$searchKey%' Or answerText1 like '%$searchKey%' Or answerText2 like '%$searchKey%' Or answerText3 like '%$searchKey%' Or answerText4 like '%$searchKey%' Or status like '%$searchKey%' Or question_chapter_id like '%$searchKey%' Or question_topic_id like '%$searchKey%' Or level like '%$searchKey%' Or question_base like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from question_bank where questionId>0   $where   $andcode  $andsubjectId  $andclassId  $andboardId  $andtype  $andquestionText  $andanswerText1  $andanswerText2  $andanswerText3  $andanswerText4  $andstatus  $andquestion_chapter_id  $andquestion_topic_id  $andlevel  $andquestion_base     order by questionId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Code</b></td>  
  <td ><b>Subject</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Board</b></td>  
  <td ><b>Marks</b></td>  
  <td ><b>Negetive Marks</b></td>  
  <td ><b>View Order</b></td>  
  <td ><b>Type</b></td>  
  <td ><b>Question </b></td>  
  <td ><b>Question  Image</b></td>  
  <td ><b>Answer 1</b></td>  
  <td ><b>Answer 1 Image</b></td>  
  <td ><b>Answer 2</b></td>  
  <td ><b>Answer 2 Image</b></td>  
  <td ><b>Answer 3</b></td>  
  <td ><b>Answer 3 Image</b></td>  
  <td ><b>Answer 4</b></td>  
  <td ><b>Answer 4 Image</b></td>  
  <td ><b>Correct Option</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Chapter</b></td>  
  <td ><b>Topic</b></td>  
  <td ><b>Level</b></td>  
  <td ><b>Base</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_question_bankGetById('<? echo $record['questionId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['code']?> </td>  
  <td>  <? echo 
	$os->rowByField('subjectName','subject','subjectId',$record['subjectId']); ?></td> 
  <td> <? if(isset($os->classList[$record['classId']])){ echo  $os->classList[$record['classId']]; } ?></td> 
  <td> <? if(isset($os->board[$record['boardId']])){ echo  $os->board[$record['boardId']]; } ?></td> 
  <td><?php echo $record['marks']?> </td>  
  <td><?php echo $record['negetive_marks']?> </td>  
  <td><?php echo $record['viewOrder']?> </td>  
  <td> <? if(isset($os->question_type_arr[$record['type']])){ echo  $os->question_type_arr[$record['type']]; } ?></td> 
  <td><?php echo $record['questionText']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['questionImage']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['answerText1']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['answerImage1']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['answerText2']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['answerImage2']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['answerText3']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['answerImage3']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['answerText4']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['answerImage4']; ?>"  height="70" width="70" /></td>  
  <td> <? if(isset($os->correctAnswer_arr[$record['correctAnswer']])){ echo  $os->correctAnswer_arr[$record['correctAnswer']]; } ?></td> 
  <td> <? if(isset($os->active_status[$record['status']])){ echo  $os->active_status[$record['status']]; } ?></td> 
  <td>  <? echo 
	$os->rowByField('title','question_chapter','question_chapter_id',$record['question_chapter_id']); ?></td> 
  <td>  <? echo 
	$os->rowByField('title','question_topic','question_topic_id',$record['question_topic_id']); ?></td> 
  <td> <? if(isset($os->question_level_arr[$record['level']])){ echo  $os->question_level_arr[$record['level']]; } ?></td> 
  <td> <? if(isset($os->question_base_arr[$record['question_base']])){ echo  $os->question_base_arr[$record['question_base']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_question_bankEditAndSave')=='OK')
{
 $questionId=$os->post('questionId');
 
 
		 
 $dataToSave['code']=addslashes($os->post('code')); 
 $dataToSave['subjectId']=addslashes($os->post('subjectId')); 
 $dataToSave['classId']=addslashes($os->post('classId')); 
 $dataToSave['boardId']=addslashes($os->post('boardId')); 
 $dataToSave['marks']=addslashes($os->post('marks')); 
 $dataToSave['negetive_marks']=addslashes($os->post('negetive_marks')); 
 $dataToSave['viewOrder']=addslashes($os->post('viewOrder')); 
 $dataToSave['type']=addslashes($os->post('type')); 
 $dataToSave['questionText']=addslashes($os->post('questionText')); 
 $questionImage=$os->UploadPhoto('questionImage',$site['root'].'wtos-images');
				   	if($questionImage!=''){
					$dataToSave['questionImage']='wtos-images/'.$questionImage;}
 $dataToSave['answerText1']=addslashes($os->post('answerText1')); 
 $answerImage1=$os->UploadPhoto('answerImage1',$site['root'].'wtos-images');
				   	if($answerImage1!=''){
					$dataToSave['answerImage1']='wtos-images/'.$answerImage1;}
 $dataToSave['answerText2']=addslashes($os->post('answerText2')); 
 $answerImage2=$os->UploadPhoto('answerImage2',$site['root'].'wtos-images');
				   	if($answerImage2!=''){
					$dataToSave['answerImage2']='wtos-images/'.$answerImage2;}
 $dataToSave['answerText3']=addslashes($os->post('answerText3')); 
 $answerImage3=$os->UploadPhoto('answerImage3',$site['root'].'wtos-images');
				   	if($answerImage3!=''){
					$dataToSave['answerImage3']='wtos-images/'.$answerImage3;}
 $dataToSave['answerText4']=addslashes($os->post('answerText4')); 
 $answerImage4=$os->UploadPhoto('answerImage4',$site['root'].'wtos-images');
				   	if($answerImage4!=''){
					$dataToSave['answerImage4']='wtos-images/'.$answerImage4;}
 $dataToSave['correctAnswer']=addslashes($os->post('correctAnswer')); 
 $dataToSave['status']=addslashes($os->post('status')); 
 $dataToSave['question_chapter_id']=addslashes($os->post('question_chapter_id')); 
 $dataToSave['question_topic_id']=addslashes($os->post('question_topic_id')); 
 $dataToSave['level']=addslashes($os->post('level')); 
 $dataToSave['question_base']=addslashes($os->post('question_base')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($questionId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('question_bank',$dataToSave,'questionId',$questionId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
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
 
if($os->get('WT_question_bankGetById')=='OK')
{
		$questionId=$os->post('questionId');
		
		if($questionId>0)	
		{
		$wheres=" where questionId='$questionId'";
		}
	    $dataQuery=" select * from question_bank  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['code']=$record['code'];
 $record['subjectId']=$record['subjectId'];
 $record['classId']=$record['classId'];
 $record['boardId']=$record['boardId'];
 $record['marks']=$record['marks'];
 $record['negetive_marks']=$record['negetive_marks'];
 $record['viewOrder']=$record['viewOrder'];
 $record['type']=$record['type'];
 $record['questionText']=$record['questionText'];
 if($record['questionImage']!=''){
						$record['questionImage']=$site['url'].$record['questionImage'];}
 $record['answerText1']=$record['answerText1'];
 if($record['answerImage1']!=''){
						$record['answerImage1']=$site['url'].$record['answerImage1'];}
 $record['answerText2']=$record['answerText2'];
 if($record['answerImage2']!=''){
						$record['answerImage2']=$site['url'].$record['answerImage2'];}
 $record['answerText3']=$record['answerText3'];
 if($record['answerImage3']!=''){
						$record['answerImage3']=$site['url'].$record['answerImage3'];}
 $record['answerText4']=$record['answerText4'];
 if($record['answerImage4']!=''){
						$record['answerImage4']=$site['url'].$record['answerImage4'];}
 $record['correctAnswer']=$record['correctAnswer'];
 $record['status']=$record['status'];
 $record['question_chapter_id']=$record['question_chapter_id'];
 $record['question_topic_id']=$record['question_topic_id'];
 $record['level']=$record['level'];
 $record['question_base']=$record['question_base'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_question_bankDeleteRowById')=='OK')
{ 

$questionId=$os->post('questionId');
 if($questionId>0){
 $updateQuery="delete from question_bank where questionId='$questionId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
