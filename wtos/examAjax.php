<? 
/*
   # wtos version : 1.1
   # page called by ajax script in examDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_examListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andexamTitle=  $os->postAndQuery('examTitle_s','examTitle','%');
$anddescription=  $os->postAndQuery('description_s','description','%');

    $f_startdate_s= $os->post('f_startdate_s'); $t_startdate_s= $os->post('t_startdate_s');
   $andstartdate=$os->DateQ('startdate',$f_startdate_s,$t_startdate_s,$sTime='00:00:00',$eTime='59:59:59');
$andexamCode=  $os->postAndQuery('examCode_s','examCode','%');
$andclass=  $os->postAndQuery('class_s','class','%');
$andyear=  $os->postAndQuery('year_s','year','%');
$andmonth=  $os->postAndQuery('month_s','month','%');
$andexamType=  $os->postAndQuery('examType_s','examType','%');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andnote=  $os->postAndQuery('note_s','note','%');
$andinstractions=  $os->postAndQuery('instractions_s','instractions','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( examTitle like '%$searchKey%' Or description like '%$searchKey%' Or examCode like '%$searchKey%' Or class like '%$searchKey%' Or year like '%$searchKey%' Or month like '%$searchKey%' Or examType like '%$searchKey%' Or status like '%$searchKey%' Or note like '%$searchKey%' Or instractions like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from exam where examId>0   $where   $andexamTitle  $anddescription  $andstartdate  $andexamCode  $andclass  $andyear  $andmonth  $andexamType  $andstatus  $andnote  $andinstractions     order by examId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Exam Title</b></td>  
  <td ><b>Description</b></td>  
  <td ><b>Start date</b></td>  
  <td ><b>Exam Code</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Year</b></td>  
  <td ><b>Month</b></td>  
  <td ><b>Exam Type</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Note</b></td>  
  <td ><b>Document 1</b></td>  
  <td ><b>Document 2</b></td>  
  <td ><b>Instractions</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_examGetById('<? echo $record['examId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['examTitle']?> </td>  
  <td><?php echo $record['description']?> </td>  
  <td><?php echo $os->showDate($record['startdate']);?> </td>  
  <td><?php echo $record['examCode']?> </td>  
  <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td> 
  <td> <? if(isset($os->examYear[$record['year']])){ echo  $os->examYear[$record['year']]; } ?></td> 
  <td> <? if(isset($os->examMonth[$record['month']])){ echo  $os->examMonth[$record['month']]; } ?></td> 
  <td> <? if(isset($os->examType[$record['examType']])){ echo  $os->examType[$record['examType']]; } ?></td> 
  <td> <? if(isset($os->examStatus[$record['status']])){ echo  $os->examStatus[$record['status']]; } ?></td> 
  <td><?php echo $record['note']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['docs_file1']; ?>"  height="70" width="70" /></td>  
  <td><img src="<?php  echo $site['url'].$record['docs_file2']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['instractions']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_examEditAndSave')=='OK')
{
 $examId=$os->post('examId');
 
 
		 
 $dataToSave['examTitle']=addslashes($os->post('examTitle')); 
 $dataToSave['description']=addslashes($os->post('description')); 
 $dataToSave['startdate']=$os->saveDate($os->post('startdate')); 
 $dataToSave['examCode']=addslashes($os->post('examCode')); 
 $dataToSave['class']=addslashes($os->post('class')); 
 $dataToSave['year']=addslashes($os->post('year')); 
 $dataToSave['month']=addslashes($os->post('month')); 
 $dataToSave['examType']=addslashes($os->post('examType')); 
 $dataToSave['status']=addslashes($os->post('status')); 
 $dataToSave['note']=addslashes($os->post('note')); 
 $docs_file1=$os->UploadPhoto('docs_file1',$site['root'].'wtos-images');
				   	if($docs_file1!=''){
					$dataToSave['docs_file1']='wtos-images/'.$docs_file1;}
 $docs_file2=$os->UploadPhoto('docs_file2',$site['root'].'wtos-images');
				   	if($docs_file2!=''){
					$dataToSave['docs_file2']='wtos-images/'.$docs_file2;}
 $dataToSave['instractions']=addslashes($os->post('instractions')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($examId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('exam',$dataToSave,'examId',$examId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($examId>0 ){ $mgs= " Data updated Successfully";}
		if($examId<1 ){ $mgs= " Data Added Successfully"; $examId=  $qResult;}
		
		  $mgs=$examId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_examGetById')=='OK')
{
		$examId=$os->post('examId');
		
		if($examId>0)	
		{
		$wheres=" where examId='$examId'";
		}
	    $dataQuery=" select * from exam  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['examTitle']=$record['examTitle'];
 $record['description']=$record['description'];
 $record['startdate']=$os->showDate($record['startdate']); 
 $record['examCode']=$record['examCode'];
 $record['class']=$record['class'];
 $record['year']=$record['year'];
 $record['month']=$record['month'];
 $record['examType']=$record['examType'];
 $record['status']=$record['status'];
 $record['note']=$record['note'];
 if($record['docs_file1']!=''){
						$record['docs_file1']=$site['url'].$record['docs_file1'];}
 if($record['docs_file2']!=''){
						$record['docs_file2']=$site['url'].$record['docs_file2'];}
 $record['instractions']=$record['instractions'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_examDeleteRowById')=='OK')
{ 

$examId=$os->post('examId');
 if($examId>0){
 $updateQuery="delete from exam where examId='$examId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
