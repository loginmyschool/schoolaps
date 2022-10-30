<? 
/*
   # wtos version : 1.1
   # page called by ajax script in resultsdetailsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$examDetailsA=$os->getSession('examDetailsA');
$resultA=$os->getSession('resultA'); 
?><?

if($os->get('WT_resultsdetailsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andresultsId=  $os->postAndQuery('resultsId_s','resultsId','=');
$andexamId=  $os->postAndQuery('examId_s','examId','=');
$andstudentId=  $os->postAndQuery('studentId_s','studentId','=');
$andclass=  $os->postAndQuery('class_s','class','=');
$andexamdetailsId=  $os->postAndQuery('examdetailsId_s','examdetailsId','=');
$andsubjectName=  $os->postAndQuery('subjectName_s','subjectName','%');
$andwrittenMarks=  $os->postAndQuery('writtenMarks_s','writtenMarks','%');
$andviva=  $os->postAndQuery('viva_s','viva','%');
$andpractical=  $os->postAndQuery('practical_s','practical','%');
$andtotalMarks=  $os->postAndQuery('totalMarks_s','totalMarks','%');
$andpercentage=  $os->postAndQuery('percentage_s','percentage','%');
$andgrade=  $os->postAndQuery('grade_s','grade','%');
$andnote=  $os->postAndQuery('note_s','note','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( resultsId like '%$searchKey%' Or examId like '%$searchKey%' Or studentId like '%$searchKey%' Or class like '%$searchKey%' Or examdetailsId like '%$searchKey%' Or subjectName like '%$searchKey%' Or writtenMarks like '%$searchKey%' Or viva like '%$searchKey%' Or practical like '%$searchKey%' Or totalMarks like '%$searchKey%' Or percentage like '%$searchKey%' Or grade like '%$searchKey%' Or note like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from resultsdetails where resultsdetailsId>0   $where   $andresultsId  $andexamId  $andstudentId  $andclass  $andexamdetailsId  $andsubjectName  $andwrittenMarks  $andviva  $andpractical  $andtotalMarks  $andpercentage  $andgrade  $andnote  $andstatus     order by resultsdetailsId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Results</b></td>  
  <td ><b>Exam</b></td>  
  <td ><b>Student</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Exam Details</b></td>  
  <td ><b>Subject Name</b></td>  
  <td ><b>Written Marks</b></td>  
  <td ><b>Viva</b></td>  
  <td ><b>Practical</b></td>  
  <td ><b>Total Marks</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_resultsdetailsGetById('<? echo $record['resultsdetailsId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php //echo $record['resultsId']
echo $resultA[$record['resultsId']]?> </td>  
  <td>  <? echo 
	$os->rowByField('examTitle','exam','examId',$record['examId']); ?></td> 
  <td><? echo 
	$os->rowByField('name','student','studentId',$record['studentId']); ?> </td>  
  <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td> 
  <td>  <? //echo 	$os->rowByField('subjectCode','examdetails','examdetailsId',$record['examdetailsId']); 
   echo $examDetailsA[$record['examdetailsId']]?></td> 
  <td>  <? echo 
	$os->rowByField('subjectName','subject','subjectId',$record['subjectId']); ?></td> 
  <td><?php echo $record['writtenMarks']?> </td>  
  <td><?php echo $record['viva']?> </td>  
  <td><?php echo $record['practical']?> </td>  
  <td><?php echo $record['totalMarks']?> </td>  
  <td><?php echo $record['percentage']?> </td>  
  <td><?php echo $record['grade']?> </td>  
  <td><?php echo $record['note']?> </td>  
  <td> <? if(isset($os->resultDetailsStatus[$record['status']])){ echo  $os->resultDetailsStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_resultsdetailsEditAndSave')=='OK')
{
 $resultsdetailsId=$os->post('resultsdetailsId');
 
 
		 
 $dataToSave['resultsId']=addslashes($os->post('resultsId')); 
 $dataToSave['examId']=addslashes($os->post('examId')); 
 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['class']=addslashes($os->post('class')); 
 $dataToSave['examdetailsId']=addslashes($os->post('examdetailsId')); 
 $dataToSave['subjectName']=addslashes($os->post('subjectName')); 
 $dataToSave['writtenMarks']=addslashes($os->post('writtenMarks')); 
 $dataToSave['viva']=addslashes($os->post('viva')); 
 $dataToSave['practical']=addslashes($os->post('practical')); 
 $dataToSave['totalMarks']=addslashes($os->post('totalMarks')); 
 $dataToSave['percentage']=addslashes($os->post('percentage')); 
 $dataToSave['grade']=addslashes($os->post('grade')); 
 $dataToSave['note']=addslashes($os->post('note')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($resultsdetailsId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('resultsdetails',$dataToSave,'resultsdetailsId',$resultsdetailsId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($resultsdetailsId>0 ){ $mgs= " Data updated Successfully";}
		if($resultsdetailsId<1 ){ $mgs= " Data Added Successfully"; $resultsdetailsId=  $qResult;}
		
		  $mgs=$resultsdetailsId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_resultsdetailsGetById')=='OK')
{
		$resultsdetailsId=$os->post('resultsdetailsId');
		
		if($resultsdetailsId>0)	
		{
		$wheres=" where resultsdetailsId='$resultsdetailsId'";
		}
	    $dataQuery=" select * from resultsdetails  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['resultsId']=$record['resultsId'];
 $record['examId']=$record['examId'];
 $record['studentId']=$record['studentId'];
 $record['class']=$record['class'];
 $record['examdetailsId']=$record['examdetailsId'];
 $record['subjectName']=$record['subjectName'];
 $record['writtenMarks']=$record['writtenMarks'];
 $record['viva']=$record['viva'];
 $record['practical']=$record['practical'];
 $record['totalMarks']=$record['totalMarks'];
 $record['percentage']=$record['percentage'];
 $record['grade']=$record['grade'];
 $record['note']=$record['note'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_resultsdetailsDeleteRowById')=='OK')
{ 

$resultsdetailsId=$os->post('resultsdetailsId');
 if($resultsdetailsId>0){
 $updateQuery="delete from resultsdetails where resultsdetailsId='$resultsdetailsId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
