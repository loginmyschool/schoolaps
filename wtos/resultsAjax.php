<? 
/*
   # wtos version : 1.1
   # page called by ajax script in resultsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_resultsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andstudentId=  $os->postAndQuery('studentId_s','studentId','%');
$andexamId=  $os->postAndQuery('examId_s','examId','%');
$andtotalExamMarks=  $os->postAndQuery('totalExamMarks_s','totalExamMarks','%');
$andobtainMarks=  $os->postAndQuery('obtainMarks_s','obtainMarks','%');
$andpercentage=  $os->postAndQuery('percentage_s','percentage','%');
$andgrade=  $os->postAndQuery('grade_s','grade','%');
$andnote=  $os->postAndQuery('note_s','note','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( studentId like '%$searchKey%' Or examId like '%$searchKey%' Or totalExamMarks like '%$searchKey%' Or obtainMarks like '%$searchKey%' Or percentage like '%$searchKey%' Or grade like '%$searchKey%' Or note like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from results where resultsId>0   $where   $andstudentId  $andexamId  $andtotalExamMarks  $andobtainMarks  $andpercentage  $andgrade  $andnote  $andstatus     order by resultsId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Student</b></td>  
  <td ><b>Exam</b></td>  
  <td ><b>Total Exam Marks</b></td>  
  <td ><b>Obtain Marks</b></td>  
  <td ><b>Percentage</b></td>  
  <td ><b>Grade</b></td>  
  <td ><b>Note</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_resultsGetById('<? echo $record['resultsId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('name','student','studentId',$record['studentId']); ?></td> 
  <td>  <? echo 
	$os->rowByField('examTitle','exam','examId',$record['examId']); ?></td> 
  <td><?php echo $record['totalExamMarks']?> </td>  
  <td><?php echo $record['obtainMarks']?> </td>  
  <td><?php echo $record['percentage']?> </td>  
  <td><?php echo $record['grade']?> </td>  
  <td><?php echo $record['note']?> </td>  
  <td> <? if(isset($os->resultStatus[$record['status']])){ echo  $os->resultStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_resultsEditAndSave')=='OK')
{
 $resultsId=$os->post('resultsId');
 
 
		 
 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['examId']=addslashes($os->post('examId')); 
 $dataToSave['totalExamMarks']=addslashes($os->post('totalExamMarks')); 
 $dataToSave['obtainMarks']=addslashes($os->post('obtainMarks')); 
 $dataToSave['percentage']=addslashes($os->post('percentage')); 
 $dataToSave['grade']=addslashes($os->post('grade')); 
 $dataToSave['note']=addslashes($os->post('note')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($resultsId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('results',$dataToSave,'resultsId',$resultsId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($resultsId>0 ){ $mgs= " Data updated Successfully";}
		if($resultsId<1 ){ $mgs= " Data Added Successfully"; $resultsId=  $qResult;}
		
		  $mgs=$resultsId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_resultsGetById')=='OK')
{
		$resultsId=$os->post('resultsId');
		
		if($resultsId>0)	
		{
		$wheres=" where resultsId='$resultsId'";
		}
	    $dataQuery=" select * from results  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['studentId']=$record['studentId'];
 $record['examId']=$record['examId'];
 $record['totalExamMarks']=$record['totalExamMarks'];
 $record['obtainMarks']=$record['obtainMarks'];
 $record['percentage']=$record['percentage'];
 $record['grade']=$record['grade'];
 $record['note']=$record['note'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_resultsDeleteRowById')=='OK')
{ 

$resultsId=$os->post('resultsId');
 if($resultsId>0){
 $updateQuery="delete from results where resultsId='$resultsId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
