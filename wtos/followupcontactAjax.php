<? 
/*
   # wtos version : 1.1
   # page called by ajax script in followupcontactDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_followupcontactListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andaddress=  $os->postAndQuery('address_s','address','%');
$andemail=  $os->postAndQuery('email_s','email','%');
$andphone=  $os->postAndQuery('phone_s','phone','%');
$andshortNote=  $os->postAndQuery('shortNote_s','shortNote','%');
$andfollowStatus=  $os->postAndQuery('followStatus_s','followStatus','%');
$andcatId=  $os->postAndQuery('catId_s','catId','%');
$andlocation=  $os->postAndQuery('location_s','location','%');
$anddate=  $os->postAndQuery('date_s','date','%');
$andpriority=  $os->postAndQuery('priority_s','priority','%');
$andcompany=  $os->postAndQuery('company_s','company','%');
$andappDate=  $os->postAndQuery('appDate_s','appDate','%');
$andproductName=  $os->postAndQuery('productName_s','productName','%');
$andassignTo=  $os->postAndQuery('assignTo_s','assignTo','%');
$andsource=  $os->postAndQuery('source_s','source','%');

    $f_nextFollowDate_s= $os->post('f_nextFollowDate_s'); $t_nextFollowDate_s= $os->post('t_nextFollowDate_s');
   $andnextFollowDate=$os->DateQ('nextFollowDate',$f_nextFollowDate_s,$t_nextFollowDate_s,$sTime='00:00:00',$eTime='59:59:59');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or address like '%$searchKey%' Or email like '%$searchKey%' Or phone like '%$searchKey%' Or shortNote like '%$searchKey%' Or followStatus like '%$searchKey%' Or catId like '%$searchKey%' Or location like '%$searchKey%' Or date like '%$searchKey%' Or priority like '%$searchKey%' Or company like '%$searchKey%' Or appDate like '%$searchKey%' Or productName like '%$searchKey%' Or assignTo like '%$searchKey%' Or source like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from followupcontact where id>0   $where   $andname  $andaddress  $andemail  $andphone  $andshortNote  $andfollowStatus  $andcatId  $andlocation  $anddate  $andpriority  $andcompany  $andappDate  $andproductName  $andassignTo  $andsource  $andnextFollowDate     order by id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	$followHistory= $os->getIdsDataFromQuery($rsRecords->queryString,'id','followuphistory','id',$fields='',$returnArray=true,$relation='12M',$otherCondition='');
	
	
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
			<td style="width:150px;" ><b>Contact</b></td>  					

		<td ><b>Followup History</b></td>  									

   
  
  <td ><b>Follow Status</b></td>  
  <td ><b>Ctegory</b></td>  
  
  <td ><b>F Date/ App Date</b> /</td>  
 

  
 						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								$followHistoryRec=$followHistory[$record['id']];
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>  </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_followupcontactGetById('<? echo $record['id'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
							
							
							
<td>  <?php echo $record['name']?> <? if($record['name']!=''){ echo '<br>';} ?><?php echo $record['company']?><br />
<span style="color:#009900; font-size:11px;"><?php echo $record['email']?></span><br />
<span style="color:#0000FF;font-size:12px;"><?php echo $record['phone']?></span><br />
<span style="color:#636B5A;font-size:10px;"><?php echo $record['address']?> - <?php echo $record['location']?></span><br />
</td>  
    <td><span style="color:#999999">Next F Date:</span><b> <?php echo $os->showDate($record['nextFollowDate']);?> </b>
	<br />
	<span class="followHistory">
	<?   
	
	 							if(is_array($followHistoryRec))
									{
										foreach($followHistoryRec as $fhr)
										{
															  
											$fDate=$os->showDate($fhr['dated']);
											$fremarks=$fhr['remarks'];
											$pstr= " $fDate <b> $fremarks </b><br>";
											echo $pstr;
											
										}
										
										
										 
											
									}
									?>
									</span>
									<?
									if($record['shortNote']!='')
									{
									    echo '<br><span class="noteClass" >'.$record['shortNote'].' </span>';
									
									}
	?>
	
	
	 
	</td>  	
  
   
  <td> <? if(isset($os->followStatus[$record['followStatus']])){ echo  $os->followStatus[$record['followStatus']]; } ?></td> 
  <td>  <? echo 
	$os->rowByField('title','followupcategory','catId',$record['catId']); ?></td> 
   
  <td style="font-size:10px; color:#00004A;">LastF: <?php echo $record['date']?>  
  
  <? if($record['appDate']!=''){ ?><br /> AppD : <?php echo $record['appDate']?> <? } ?> </td>  
  
 

  
 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_followupcontactEditAndSave')=='OK')
{
 $id=$os->post('id');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['phone']=addslashes($os->post('phone')); 
 $dataToSave['shortNote']=addslashes($os->post('shortNote')); 
 $dataToSave['followStatus']=addslashes($os->post('followStatus')); 
 $dataToSave['catId']=addslashes($os->post('catId')); 
 $dataToSave['location']=addslashes($os->post('location')); 
 $dataToSave['date']=addslashes($os->post('date')); 
 $dataToSave['priority']=addslashes($os->post('priority')); 
 $dataToSave['company']=addslashes($os->post('company')); 
 $dataToSave['appDate']=addslashes($os->post('appDate')); 
 $dataToSave['productName']=addslashes($os->post('productName')); 
 $dataToSave['assignTo']=addslashes($os->post('assignTo')); 
 $dataToSave['source']=addslashes($os->post('source')); 
 $dataToSave['nextFollowDate']=$os->saveDate($os->post('nextFollowDate')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('followupcontact',$dataToSave,'id',$id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($id>0 ){ $mgs= " Data updated Successfully";}
		if($id<1 ){ $mgs= " Data Added Successfully"; $id=  $qResult;}
		
		  $mgs=$id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_followupcontactGetById')=='OK')
{
		$id=$os->post('id');
		
		if($id>0)	
		{
		$wheres=" where id='$id'";
		}
	    $dataQuery=" select * from followupcontact  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['address']=$record['address'];
 $record['email']=$record['email'];
 $record['phone']=$record['phone'];
 $record['shortNote']=$record['shortNote'];
 $record['followStatus']=$record['followStatus'];
 $record['catId']=$record['catId'];
 $record['location']=$record['location'];
 $record['date']=$record['date'];
 $record['priority']=$record['priority'];
 $record['company']=$record['company'];
 $record['appDate']=$record['appDate'];
 $record['productName']=$record['productName'];
 $record['assignTo']=$record['assignTo'];
 $record['source']=$record['source'];
 $record['nextFollowDate']=$os->showDate($record['nextFollowDate']); 

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_followupcontactDeleteRowById')=='OK')
{ 

$id=$os->post('id');
 if($id>0){
 $updateQuery="delete from followupcontact where id='$id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
