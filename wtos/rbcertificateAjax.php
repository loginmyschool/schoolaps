<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbcertificateDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbcertificateListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrbcontactId=  $os->postAndQuery('rbcontactId_s','rbcontactId','=');

    $f_instalationDate_s= $os->post('f_instalationDate_s'); $t_instalationDate_s= $os->post('t_instalationDate_s');
   $andinstalationDate=$os->DateQ('instalationDate',$f_instalationDate_s,$t_instalationDate_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_warrentyUpTo_s= $os->post('f_warrentyUpTo_s'); $t_warrentyUpTo_s= $os->post('t_warrentyUpTo_s');
   $andwarrentyUpTo=$os->DateQ('warrentyUpTo',$f_warrentyUpTo_s,$t_warrentyUpTo_s,$sTime='00:00:00',$eTime='59:59:59');

	   
	$searchKey=$os->post('searchKey');
	
	
	$rbcontactIds= $os->searchKeyGetIds($searchKey,'rbcontact','rbcontactId',$whereCondition='',$searchFields='');
	$orrbcontactId='';
	if($rbcontactIds!='')
	{
	   $orrbcontactId= " or  rbcontactId IN ( $rbcontactIds) ";
	}

	
	
	if($searchKey!=''){
	$where ="and ( rbcontactId like '%$searchKey%' ) $orrbcontactId";
 
	}
		
	$listingQuery="  select * from rbcertificate where rbcertificateId>0   $where   $andrbcontactId  $andinstalationDate  $andwarrentyUpTo     order by rbcertificateId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	$contactList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Contacts</b></td>  
  <td ><b>Date</b></td>  
  <td ><b>Months</b></td>  
  <td ><b>Installed Date</b></td>  
  <td ><b>Warenty Up To </b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbcertificateGetById('<? echo $record['rbcertificateId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td> 
	<? $os->showContact($contactList[$record['rbcontactId']]); ?>
  </td> 
  <td><?php echo $os->showDate($record['certificateDate']);?> </td>  
  <td><?php echo $record['certificateMonths']?> </td>  
  <td><?php echo $os->showDate($record['instalationDate']);?> </td>  
  <td><?php echo $os->showDate($record['warrentyUpTo']);?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbcertificateEditAndSave')=='OK')
{
 $rbcertificateId=$os->post('rbcertificateId');
 
 
		 
 $dataToSave['rbcontactId']=addslashes($os->post('rbcontactId')); 
 $dataToSave['certificateDate']=$os->saveDate($os->post('certificateDate')); 
 $dataToSave['certificateMonths']=addslashes($os->post('certificateMonths')); 
 $dataToSave['instalationDate']=$os->saveDate($os->post('instalationDate')); 
 $dataToSave['warrentyUpTo']=$os->saveDate($os->post('warrentyUpTo')); 
 $dataToSave['certificateNo']=addslashes($os->post('certificateNo')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbcertificateId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbcertificate',$dataToSave,'rbcertificateId',$rbcertificateId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbcertificateId>0 ){ $mgs= " Data updated Successfully";}
		if($rbcertificateId<1 ){ $mgs= " Data Added Successfully"; $rbcertificateId=  $qResult;}
		
		  $mgs=$rbcertificateId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbcertificateGetById')=='OK')
{
		$rbcertificateId=$os->post('rbcertificateId');
		
		if($rbcertificateId>0)	
		{
		$wheres=" where rbcertificateId='$rbcertificateId'";
		}
	    $dataQuery=" select * from rbcertificate  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['rbcontactId']=$record['rbcontactId'];
 $record['certificateDate']=$os->showDate($record['certificateDate']); 
 $record['certificateMonths']=$record['certificateMonths'];
 $record['instalationDate']=$os->showDate($record['instalationDate']); 
 $record['warrentyUpTo']=$os->showDate($record['warrentyUpTo']); 
 $record['certificateNo']=$record['certificateNo'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbcertificateDeleteRowById')=='OK')
{ 

$rbcertificateId=$os->post('rbcertificateId');
 if($rbcertificateId>0){
 $updateQuery="delete from rbcertificate where rbcertificateId='$rbcertificateId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
