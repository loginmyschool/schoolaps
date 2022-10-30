<? 
/*
   # wtos version : 1.1
   # page called by ajax script in newsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='mn';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_newsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andtitle=  $os->postAndQuery('title_s','title','%');
$andbriefDescription=  $os->postAndQuery('briefDescription_s','briefDescription','%');
$andfullDescription=  $os->postAndQuery('fullDescription_s','fullDescription','%');

    $f_publicationDate_s= $os->post('f_publicationDate_s'); $t_publicationDate_s= $os->post('t_publicationDate_s');
   $andpublicationDate=$os->DateQ('publicationDate',$f_publicationDate_s,$t_publicationDate_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_expiryDate_s= $os->post('f_expiryDate_s'); $t_expiryDate_s= $os->post('t_expiryDate_s');
   $andexpiryDate=$os->DateQ('expiryDate',$f_expiryDate_s,$t_expiryDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andnewsType=  $os->postAndQuery('newsType_s','newsType','%');

    $f_newsDate_s= $os->post('f_newsDate_s'); $t_newsDate_s= $os->post('t_newsDate_s');
   $andnewsDate=$os->DateQ('newsDate',$f_newsDate_s,$t_newsDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andisPublished=  $os->postAndQuery('isPublished_s','isPublished','%');
$andlocation=  $os->postAndQuery('location_s','location','%');
$andvenue=  $os->postAndQuery('venue_s','venue','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( title like '%$searchKey%' Or briefDescription like '%$searchKey%' Or fullDescription like '%$searchKey%' Or status like '%$searchKey%' Or newsType like '%$searchKey%' Or isPublished like '%$searchKey%' Or location like '%$searchKey%' Or venue like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from news where newsId>0   $where   $andtitle  $andbriefDescription  $andfullDescription  $andpublicationDate  $andexpiryDate  $andstatus  $andnewsType  $andnewsDate  $andisPublished  $andlocation  $andvenue     order by priority ";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Title</b></td>  
  <!-- <td ><b>Full Description</b></td>   -->
  <td ><b>Publication Date</b></td>  
   <td ><b>Start Time</b></td> 
    <td ><b>End Time</b></td> 
  <td style="display:none;"><b>Expiry</b></td>  
  <td ><b>News Image</b></td>  
  <td ><b>Status</b></td>  
  <!-- <td ><b>seoUrl</b></td>   -->
  <td style="display:none;"><b>News Date</b></td>  
  <td style="display:none;"><b>Published</b></td> 
 <td ><b>News Type</b></td>
  <td ><b>Priority</b></td>   
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_newsGetById('<? echo $record['newsId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['title']?> </td>  
  <!-- <td><?php // echo $record['fullDescription']?> </td>   -->
  <td><?php echo $os->showDate($record['publicationDate']);?> </td>
  <td><?php echo $record['fromTime']; ?></td> 
  <td><?php echo $record['toTime']; ?></td>   
  <td style="display:none;"><?php echo $os->showDate($record['expiryDate']);?> </td>  
  <td><img src="<?php  echo $site['url'].$record['newsImage']; ?>"  height="70" width="70" /></td>  
  <td> <? if(isset($os->activeStatus[$record['status']])){ echo  $os->activeStatus[$record['status']]; } ?></td> 
  <!-- <td><?php // echo $record['seoUrl']?> </td>   -->
  <td style="display:none;"><?php echo $os->showDate($record['newsDate']);?> </td>  
  <td style="display:none;"> <? if(isset($os->yesNo[$record['isPublished']])){ echo  $os->yesNo[$record['isPublished']]; } ?></td> 
  <td><?php echo $record['newsType']; ?></td> 
  <td><?php echo $record['priority']; ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_newsEditAndSave')=='OK')
{
 $newsId=$os->post('newsId');
 
 
		 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['briefDescription']=addslashes($os->post('briefDescription')); 
 $dataToSave['fullDescription']=addslashes($os->post('fullDescription')); 
 $dataToSave['publicationDate']=$os->saveDate($os->post('publicationDate')); 
 $dataToSave['expiryDate']=$os->saveDate($os->post('expiryDate')); 
 $newsImage=$os->UploadPhoto('newsImage',$site['root'].'wtos-images');
				   	if($newsImage!=''){
					$dataToSave['newsImage']='wtos-images/'.$newsImage;}
 $dataToSave['status']=addslashes($os->post('status')); 
 // $dataToSave['seoUrl']=addslashes($os->post('seoUrl')); 
 $dataToSave['newsType']=addslashes($os->post('newsType')); 
 $dataToSave['newsDate']=$os->saveDate($os->post('newsDate')); 
 $dataToSave['isPublished']=addslashes($os->post('isPublished')); 
 $dataToSave['location']=addslashes($os->post('location')); 
 $dataToSave['venue']=addslashes($os->post('venue')); 

 $dataToSave['priority']=addslashes($os->post('priority'));
 
 $dataToSave['eventsType']=addslashes($os->post('eventsType'));
		
		
		 $dataToSave['fromTime']=addslashes($os->post('fromTime'));
		  $dataToSave['toTime']=addslashes($os->post('toTime'));
		
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($newsId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 $os->mq("SET sql_mode = ''");
          $qResult=$os->save('news',$dataToSave,'newsId',$newsId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		  
		  echo $os->query;
		if($qResult)  
				{
		if($newsId>0 ){ $mgs= " Data updated Successfully";}
		if($newsId<1 ){ $mgs= " Data Added Successfully"; $newsId=  $qResult;}
		
		  $mgs=$newsId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_newsGetById')=='OK')
{
		$newsId=$os->post('newsId');
		
		if($newsId>0)	
		{
		$wheres=" where newsId='$newsId'";
		}
	    $dataQuery=" select * from news  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['title']=$record['title'];
 $record['briefDescription']=$record['briefDescription'];
 $record['fullDescription']=$record['fullDescription'];
 $record['publicationDate']=$os->showDate($record['publicationDate']); 
 $record['expiryDate']=$os->showDate($record['expiryDate']); 
 if($record['newsImage']!=''){
						$record['newsImage']=$site['url'].$record['newsImage'];}
 $record['status']=$record['status'];
 // $record['seoUrl']=$record['seoUrl'];
 $record['newsType']=$record['newsType'];
 $record['newsDate']=$os->showDate($record['newsDate']); 
 $record['isPublished']=$record['isPublished'];
 $record['location']=$record['location'];
 $record['venue']=$record['venue'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_newsDeleteRowById')=='OK')
{ 

$newsId=$os->post('newsId');
 if($newsId>0){
 $updateQuery="delete from news where newsId='$newsId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
