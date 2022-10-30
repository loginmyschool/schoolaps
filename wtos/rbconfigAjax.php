<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbconfigDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbconfigListing')=='OK')
 {
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="
";
 
	}
		
	$listingQuery="  select * from rbconfig where rbconfigId>0   $where      order by rbconfigId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Logo</b></td>  
  <td ><b>Water Mark</b></td>  
  <td ><b>Company Name</b></td>  
  <td ><b>Address Line1</b></td>  
  <td ><b>Address Line2</b></td>  
  <td ><b>Address Line3</b></td>  
  <td ><b>Phone</b></td>  
  <td ><b>Mobile</b></td>  
  <td ><b>Email</b></td>  
  <td ><b>Fax</b></td>  
  <td ><b>Website</b></td>  
  <td ><b>Account No</b></td>  
  <td ><b>Account Details</b></td>  
  <td ><b>Vendor Id</b></td>  
  <td ><b>Tems</b></td>  
  <td ><b>Extra Note1</b></td>  
  <td ><b>Extra Note2</b></td>  
  <td ><b>Service Tax No</b></td>  
  <td ><b>Vat No</b></td>  
  <td ><b>CST No</b></td>  
  <td ><b>W.E.F.</b></td>  
  <td ><b>Auto Expire Msg</b></td>  
  <td ><b>Manual Msg</b></td>  
  <td ><b>Auto Expire Email</b></td>  
  <td ><b>Manual Email</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbconfigGetById('<? echo $record['rbconfigId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><img src="<?php  echo $site['url'].$record['logo']; ?>"  height="70" width="70" /></td>  
  <td><img src="<?php  echo $site['url'].$record['waterMark']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['companyName']?> </td>  
  <td><?php echo $record['addressLine1']?> </td>  
  <td><?php echo $record['addressLine2']?> </td>  
  <td><?php echo $record['addressLine3']?> </td>  
  <td><?php echo $record['phone']?> </td>  
  <td><?php echo $record['mobile']?> </td>  
  <td><?php echo $record['email']?> </td>  
  <td><?php echo $record['fax']?> </td>  
  <td><?php echo $record['website']?> </td>  
  <td><?php echo $record['accountNo']?> </td>  
  <td><?php echo $record['accountDetails']?> </td>  
  <td><?php echo $record['vendorId']?> </td>  
  <td><?php echo $record['tems']?> </td>  
  <td><?php echo $record['extraNote1']?> </td>  
  <td><?php echo $record['extraNote2']?> </td>  
  <td><?php echo $record['serviceTaxNo']?> </td>  
  <td><?php echo $record['vatNo']?> </td>  
  <td><?php echo $record['cstNo']?> </td>  
  <td><?php echo $record['wef']?> </td>  
  <td> <? if(isset($os->noYes[$record['autoExpMsg']])){ echo  $os->noYes[$record['autoExpMsg']]; } ?></td> 
  <td> <? if(isset($os->noYes[$record['manualMsg']])){ echo  $os->noYes[$record['manualMsg']]; } ?></td> 
  <td> <? if(isset($os->yes[$record['autoExpEmail']])){ echo  $os->yes[$record['autoExpEmail']]; } ?></td> 
  <td> <? if(isset($os->yes[$record['manualEmail']])){ echo  $os->yes[$record['manualEmail']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbconfigEditAndSave')=='OK')
{
 $rbconfigId=$os->post('rbconfigId');
 
 
		 
 $logo=$os->UploadPhoto('logo',$site['root'].'wtos-images');
				   	if($logo!=''){
					$dataToSave['logo']='wtos-images/'.$logo;}
 $waterMark=$os->UploadPhoto('waterMark',$site['root'].'wtos-images');
				   	if($waterMark!=''){
					$dataToSave['waterMark']='wtos-images/'.$waterMark;}
 $dataToSave['companyName']=addslashes($os->post('companyName')); 
 $dataToSave['addressLine1']=addslashes($os->post('addressLine1')); 
 $dataToSave['addressLine2']=addslashes($os->post('addressLine2')); 
 $dataToSave['addressLine3']=addslashes($os->post('addressLine3')); 
 $dataToSave['phone']=addslashes($os->post('phone')); 
 $dataToSave['mobile']=addslashes($os->post('mobile')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['fax']=addslashes($os->post('fax')); 
 $dataToSave['website']=addslashes($os->post('website')); 
 $dataToSave['accountNo']=addslashes($os->post('accountNo')); 
 $dataToSave['accountDetails']=addslashes($os->post('accountDetails')); 
 $dataToSave['vendorId']=addslashes($os->post('vendorId')); 
 $dataToSave['tems']=addslashes($os->post('tems')); 
 $dataToSave['extraNote1']=addslashes($os->post('extraNote1')); 
 $dataToSave['extraNote2']=addslashes($os->post('extraNote2')); 
 $dataToSave['serviceTaxNo']=addslashes($os->post('serviceTaxNo')); 
 $dataToSave['vatNo']=addslashes($os->post('vatNo')); 
 $dataToSave['cstNo']=addslashes($os->post('cstNo')); 
 $dataToSave['wef']=addslashes($os->post('wef')); 
 $dataToSave['autoExpMsg']=addslashes($os->post('autoExpMsg')); 
 $dataToSave['manualMsg']=addslashes($os->post('manualMsg')); 
 $dataToSave['autoExpEmail']=addslashes($os->post('autoExpEmail')); 
 $dataToSave['manualEmail']=addslashes($os->post('manualEmail')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbconfigId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbconfig',$dataToSave,'rbconfigId',$rbconfigId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbconfigId>0 ){ $mgs= " Data updated Successfully";}
		if($rbconfigId<1 ){ $mgs= " Data Added Successfully"; $rbconfigId=  $qResult;}
		
		  $mgs=$rbconfigId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbconfigGetById')=='OK')
{
		$rbconfigId=$os->post('rbconfigId');
		
		if($rbconfigId>0)	
		{
		$wheres=" where rbconfigId='$rbconfigId'";
		}
	    $dataQuery=" select * from rbconfig  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 if($record['logo']!=''){
						$record['logo']=$site['url'].$record['logo'];}
 if($record['waterMark']!=''){
						$record['waterMark']=$site['url'].$record['waterMark'];}
 $record['companyName']=$record['companyName'];
 $record['addressLine1']=$record['addressLine1'];
 $record['addressLine2']=$record['addressLine2'];
 $record['addressLine3']=$record['addressLine3'];
 $record['phone']=$record['phone'];
 $record['mobile']=$record['mobile'];
 $record['email']=$record['email'];
 $record['fax']=$record['fax'];
 $record['website']=$record['website'];
 $record['accountNo']=$record['accountNo'];
 $record['accountDetails']=$record['accountDetails'];
 $record['vendorId']=$record['vendorId'];
 $record['tems']=$record['tems'];
 $record['extraNote1']=$record['extraNote1'];
 $record['extraNote2']=$record['extraNote2'];
 $record['serviceTaxNo']=$record['serviceTaxNo'];
 $record['vatNo']=$record['vatNo'];
 $record['cstNo']=$record['cstNo'];
 $record['wef']=$record['wef'];
 $record['autoExpMsg']=$record['autoExpMsg'];
 $record['manualMsg']=$record['manualMsg'];
 $record['autoExpEmail']=$record['autoExpEmail'];
 $record['manualEmail']=$record['manualEmail'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbconfigDeleteRowById')=='OK')
{ 

$rbconfigId=$os->post('rbconfigId');
 if($rbconfigId>0){
 $updateQuery="delete from rbconfig where rbconfigId='$rbconfigId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
