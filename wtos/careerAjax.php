<? 
/*
   # wtos version : 1.1
   # page called by ajax script in careerDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_careerListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andaddress=  $os->postAndQuery('address_s','address','%');
$andpostalCode=  $os->postAndQuery('postalCode_s','postalCode','%');
$andcity=  $os->postAndQuery('city_s','city','%');
$andstate=  $os->postAndQuery('state_s','state','%');
$andmobile=  $os->postAndQuery('mobile_s','mobile','%');
$andemail=  $os->postAndQuery('email_s','email','%');
$anddepartment=  $os->postAndQuery('department_s','department','%');
$andreference=  $os->postAndQuery('reference_s','reference','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or address like '%$searchKey%' Or postalCode like '%$searchKey%' Or city like '%$searchKey%' Or state like '%$searchKey%' Or mobile like '%$searchKey%' Or email like '%$searchKey%' Or department like '%$searchKey%' Or reference like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from career where careerId>0   $where   $andname  $andaddress  $andpostalCode  $andcity  $andstate  $andmobile  $andemail  $anddepartment  $andreference     order by careerId desc";
	  
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
  <td ><b>Address</b></td>  
  <td ><b>Postal Code</b></td>  
  <td style="display:none;"><b>City</b></td>  
  <td style="display:none;"><b>State</b></td>  
  <td ><b>Mobile No</b></td>  
  <td ><b>Email</b></td>  
  <td ><b>Department</b></td>  
  <td ><b>Reference</b></td>  
   <td ><b>Apply Date</b></td>  
  <td ><b>CV</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_careerGetById('<? echo $record['careerId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $record['address']?> </td>  
  <td><?php echo $record['postalCode']?> </td>  
  <td style="display:none;"><?php echo $record['city']?> </td>  
  <td style="display:none;"><?php echo $record['state']?> </td>  
  <td><?php echo $record['mobile']?> </td>  
  <td><?php echo $record['email']?> </td>  
  <td> <? if(isset($os->careerDepartment[$record['department']])){ echo  $os->careerDepartment[$record['department']]; } ?></td> 
  <td><?php echo $record['reference']?> </td>  
  
   <td><?php echo $os->showDate($record['addedDate'])?> </td>  
  <td>
   <a target="_blank"  href="<?php echo $site['url'].$record['image']?>"><?php echo $record['image']?></a>
  
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
 





if($os->get('WT_careerEditAndSave')=='OK')
{
 $careerId=$os->post('careerId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['postalCode']=addslashes($os->post('postalCode')); 
 $dataToSave['city']=addslashes($os->post('city')); 
 $dataToSave['state']=addslashes($os->post('state')); 
 $dataToSave['mobile']=addslashes($os->post('mobile')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['department']=addslashes($os->post('department')); 
 $dataToSave['reference']=addslashes($os->post('reference')); 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($careerId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('career',$dataToSave,'careerId',$careerId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($careerId>0 ){ $mgs= " Data updated Successfully";}
		if($careerId<1 ){ $mgs= " Data Added Successfully"; $careerId=  $qResult;}
		
		  $mgs=$careerId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_careerGetById')=='OK')
{
		$careerId=$os->post('careerId');
		
		if($careerId>0)	
		{
		$wheres=" where careerId='$careerId'";
		}
	    $dataQuery=" select * from career  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['address']=$record['address'];
 $record['postalCode']=$record['postalCode'];
 $record['city']=$record['city'];
 $record['state']=$record['state'];
 $record['mobile']=$record['mobile'];
 $record['email']=$record['email'];
 $record['department']=$record['department'];
 $record['reference']=$record['reference'];
 if($record['image']!=''){
						$record['image']=$site['url'].$record['image'];}

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_careerDeleteRowById')=='OK')
{ 

$careerId=$os->post('careerId');
 if($careerId>0){
 $updateQuery="delete from career where careerId='$careerId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
