<? 
/*
   # wtos version : 1.1
   # page called by ajax script in question_topicDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 $os->active_status=array('Yes'=>'Yes','No'=>'No');
?><?

if($os->get('WT_question_topicListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andquestion_topic_id=  $os->postAndQuery('question_topic_id_s','question_topic_id','%');
$andquestion_chapter_id=  $os->postAndQuery('question_chapter_id_s','question_chapter_id','%');
$andtitle=  $os->postAndQuery('title_s','title','%');
$andactive_status=  $os->postAndQuery('active_status_s','active_status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( question_topic_id like '%$searchKey%' Or question_chapter_id like '%$searchKey%' Or title like '%$searchKey%' Or active_status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from question_topic where question_topic_id>0   $where   $andquestion_topic_id  $andquestion_chapter_id  $andtitle  $andactive_status     order by question_topic_id desc";
	  
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
  <td ><b>Chapter</b></td>  
  <td ><b>Title</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_question_topicGetById('<? echo $record['question_topic_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['question_topic_id']?> </td>  
  <td>  <? echo 
	$os->rowByField('title','question_chapter','question_chapter_id',$record['question_chapter_id']); ?></td> 
  <td><?php echo $record['title']?> </td>  
  <td> <? if(isset($os->active_status[$record['active_status']])){ echo  $os->active_status[$record['active_status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_question_topicEditAndSave')=='OK')
{
 $question_topic_id=$os->post('question_topic_id');
 
 
		 
 $dataToSave['question_chapter_id']=addslashes($os->post('question_chapter_id')); 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['active_status']=addslashes($os->post('active_status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($question_topic_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('question_topic',$dataToSave,'question_topic_id',$question_topic_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($question_topic_id>0 ){ $mgs= " Data updated Successfully";}
		if($question_topic_id<1 ){ $mgs= " Data Added Successfully"; $question_topic_id=  $qResult;}
		
		  $mgs=$question_topic_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_question_topicGetById')=='OK')
{
		$question_topic_id=$os->post('question_topic_id');
		
		if($question_topic_id>0)	
		{
		$wheres=" where question_topic_id='$question_topic_id'";
		}
	    $dataQuery=" select * from question_topic  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['question_chapter_id']=$record['question_chapter_id'];
 $record['title']=$record['title'];
 $record['active_status']=$record['active_status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_question_topicDeleteRowById')=='OK')
{ 

$question_topic_id=$os->post('question_topic_id');
 if($question_topic_id>0){
 $updateQuery="delete from question_topic where question_topic_id='$question_topic_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
