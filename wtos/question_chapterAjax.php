<? 
/*
   # wtos version : 1.1
   # page called by ajax script in question_chapterDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_question_chapterListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andquestion_chapter_id=  $os->postAndQuery('question_chapter_id_s','question_chapter_id','%');
$andclass_id=  $os->postAndQuery('class_id_s','class_id','%');
$andtitle=  $os->postAndQuery('title_s','title','%');
$andsubject_id=  $os->postAndQuery('subject_id_s','subject_id','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( question_chapter_id like '%$searchKey%' Or class_id like '%$searchKey%' Or title like '%$searchKey%' Or subject_id like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from question_chapter where question_chapter_id>0   $where   $andquestion_chapter_id  $andclass_id  $andtitle  $andsubject_id     order by question_chapter_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>ID</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Title</b></td>  
  <td ><b>Subject</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_question_chapterGetById('<? echo $record['question_chapter_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['question_chapter_id']?> </td>  
  <td>  <? echo 
	$os->classList[$record['class_id']] ; ?></td> 
  <td><?php echo $record['title']?> </td>  
  <td>  <? echo 
	$os->rowByField('subjectName','subject','subjectId',$record['subject_id']); ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_question_chapterEditAndSave')=='OK')
{
 $question_chapter_id=$os->post('question_chapter_id');
 
 
		 
 $dataToSave['class_id']=addslashes($os->post('class_id')); 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['subject_id']=addslashes($os->post('subject_id')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($question_chapter_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('question_chapter',$dataToSave,'question_chapter_id',$question_chapter_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($question_chapter_id>0 ){ $mgs= " Data updated Successfully";}
		if($question_chapter_id<1 ){ $mgs= " Data Added Successfully"; $question_chapter_id=  $qResult;}
		
		  $mgs=$question_chapter_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_question_chapterGetById')=='OK')
{
		$question_chapter_id=$os->post('question_chapter_id');
		
		if($question_chapter_id>0)	
		{
		$wheres=" where question_chapter_id='$question_chapter_id'";
		}
	    $dataQuery=" select * from question_chapter  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['class_id']=$record['class_id'];
 $record['title']=$record['title'];
 $record['subject_id']=$record['subject_id'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_question_chapterDeleteRowById')=='OK')
{ 

$question_chapter_id=$os->post('question_chapter_id');
 if($question_chapter_id>0){
 $updateQuery="delete from question_chapter where question_chapter_id='$question_chapter_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
