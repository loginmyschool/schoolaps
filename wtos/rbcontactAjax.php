<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbcontactDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbcontactListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');
$andperson=  $os->postAndQuery('person_s','person','%');
$andcompany=  $os->postAndQuery('company_s','company','%');
$andphone=  $os->postAndQuery('phone_s','phone','%');
$andemail=  $os->postAndQuery('email_s','email','%');
$andrbcategoryId=  $os->postAndQuery('rbcategoryId_s','rbcategoryId','%');
$andrblocationId=  $os->postAndQuery('rblocationId_s','rblocationId','%');
$andcontactStatus=  $os->postAndQuery('contactStatus_s','contactStatus','%');
$andwebsiteUrl=  $os->postAndQuery('websiteUrl_s','websiteUrl','%');
$andrefferBy=  $os->postAndQuery('refferBy_s','refferBy','%');
$andaddress=  $os->postAndQuery('address_s','address','%');
$andpostcode=  $os->postAndQuery('postcode_s','postcode','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');
$andpriority=  $os->postAndQuery('priority_s','priority','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or person like '%$searchKey%' Or company like '%$searchKey%' Or phone like '%$searchKey%' Or email like '%$searchKey%' Or rbcategoryId like '%$searchKey%' Or rblocationId like '%$searchKey%' Or contactStatus like '%$searchKey%' Or websiteUrl like '%$searchKey%' Or refferBy like '%$searchKey%' Or address like '%$searchKey%' Or postcode like '%$searchKey%' Or remarks like '%$searchKey%' Or priority like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbcontact where rbcontactId>0   $where   $andrefCode  $andperson  $andcompany  $andphone  $andemail  $andrbcategoryId  $andrblocationId  $andcontactStatus  $andwebsiteUrl  $andrefferBy  $andaddress  $andpostcode  $andremarks  $andpriority     order by rbcontactId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
 
  <td ><b>Name</b></td>  
  
  <td ><b>Contact</b></td>  
   
  
 
  <td ><b>Address</b></td>  
  
  <td ><b>Priority</b></td> 
  <td ><b> Status</b></td>   
  <td ><b>Note</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbcontactGetById('<? echo $record['rbcontactId'];?>')" >Edit</a></span>  <? } ?>  </td>
  <td><b><?php echo $record['person']?></b><br /> 
   <? if($record['refCode']!=''){?><span style="color:#666666; font-size:10px"><?php echo $record['refCode']?> </span> <br />  <? } ?>
    <?php echo $record['company']?>
   </td>  
  
  <td> <span style="color:#009900; font-size:11px"><b><?php echo $record['phone']?></b></span> <br />
  
  <span style="color:#0080C0; font-size:10px"><?php echo $record['email']?> </span>
  
  <br /> <?php echo $record['websiteUrl']?></td>  
  
 
  
   
  <td><?php echo $record['address']?> </td>  
 
  <td> <? if(isset($os->priorities[$record['priority']])){ echo  $os->priorities[$record['priority']]; } ?></td> 
   <td> <? if(isset($os->activeInactive[$record['contactStatus']])){ echo  $os->activeInactive[$record['contactStatus']]; } ?></td> 
  
		 <td>
   Reff By : <?php echo $record['refferBy']?> 
   <? if($record['remarks']!=''){?><span style="color:#FF8204; font-size:10px">Remarks:<?php echo $record['remarks']?>  </span> <br />  <? } ?>
  </td>  						
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbcontactEditAndSave')=='OK')
{
 $rbcontactId=$os->post('rbcontactId');
 
 
		 
 $dataToSave['refCode']=addslashes($os->post('refCode')); 
 $dataToSave['person']=addslashes($os->post('person')); 
 $dataToSave['company']=addslashes($os->post('company')); 
 $dataToSave['phone']=addslashes($os->post('phone')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['rbcategoryId']=addslashes($os->post('rbcategoryId')); 
 $dataToSave['rblocationId']=addslashes($os->post('rblocationId')); 
 $dataToSave['contactStatus']=addslashes($os->post('contactStatus')); 
 $dataToSave['websiteUrl']=addslashes($os->post('websiteUrl')); 
 $dataToSave['refferBy']=addslashes($os->post('refferBy')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['postcode']=addslashes($os->post('postcode')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 
 $dataToSave['priority']=addslashes($os->post('priority')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbcontactId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbcontact',$dataToSave,'rbcontactId',$rbcontactId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbcontactId>0 ){ $mgs= " Data updated Successfully";}
		if($rbcontactId<1 ){ $mgs= " Data Added Successfully"; $rbcontactId=  $qResult;}
		
		  $mgs=$rbcontactId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbcontactGetById')=='OK')
{
		$rbcontactId=$os->post('rbcontactId');
		
		if($rbcontactId>0)	
		{
		$wheres=" where rbcontactId='$rbcontactId'";
		}
	    $dataQuery=" select * from rbcontact  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['refCode']=$record['refCode'];
 $record['person']=$record['person'];
 $record['company']=$record['company'];
 $record['phone']=$record['phone'];
 $record['email']=$record['email'];
 $record['rbcategoryId']=$record['rbcategoryId'];
 $record['rblocationId']=$record['rblocationId'];
 $record['contactStatus']=$record['contactStatus'];
 $record['websiteUrl']=$record['websiteUrl'];
 $record['refferBy']=$record['refferBy'];
 $record['address']=$record['address'];
 $record['postcode']=$record['postcode'];
 $record['remarks']=$record['remarks'];
 $record['priority']=$record['priority'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbcontactDeleteRowById')=='OK')
{ 

$rbcontactId=$os->post('rbcontactId');
 if($rbcontactId>0){
 $updateQuery="delete from rbcontact where rbcontactId='$rbcontactId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
