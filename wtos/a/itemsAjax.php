<? 
/*
   # wtos version : 1.1
   # page called by ajax script in itemsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_itemsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$anditem_id=  $os->postAndQuery('item_id_s','item_id','%');
$anditem_name=  $os->postAndQuery('item_name_s','item_name','%');
$andbeng_name=  $os->postAndQuery('beng_name_s','beng_name','%');
$andhindi_name=  $os->postAndQuery('hindi_name_s','hindi_name','%');
$andkeywords=  $os->postAndQuery('keywords_s','keywords','%');
$anditem_unit=  $os->postAndQuery('item_unit_s','item_unit','%');
$anditem_type=  $os->postAndQuery('item_type_s','item_type','%');
$andshow_in_daily_report=  $os->postAndQuery('show_in_daily_report_s','show_in_daily_report','%');
$anddepartments=  $os->postAndQuery('departments_s','departments','%');
$andrecoverable=  $os->postAndQuery('recoverable_s','recoverable','%');
$anditem_code=  $os->postAndQuery('item_code_s','item_code','%');
$andcategory_id=  $os->postAndQuery('category_id_s','category_id','%');
$andbarcode_applicable=  $os->postAndQuery('barcode_applicable_s','barcode_applicable','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( item_id like '%$searchKey%' Or item_name like '%$searchKey%' Or beng_name like '%$searchKey%' Or hindi_name like '%$searchKey%' Or keywords like '%$searchKey%' Or item_unit like '%$searchKey%' Or item_type like '%$searchKey%' Or show_in_daily_report like '%$searchKey%' Or departments like '%$searchKey%' Or recoverable like '%$searchKey%' Or item_code like '%$searchKey%' Or category_id like '%$searchKey%' Or barcode_applicable like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from items where item_id>0   $where   $anditem_id  $anditem_name  $andbeng_name  $andhindi_name  $andkeywords  $anditem_unit  $anditem_type  $andshow_in_daily_report  $anddepartments  $andrecoverable  $anditem_code  $andcategory_id  $andbarcode_applicable     order by item_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Item id</b></td>  
  <td ><b>Name</b></td>  
  <td ><b>Name(Beng)</b></td>  
  <td ><b>Name(Hindi)</b></td>  
  <td ><b>Keywords</b></td>  
  <td ><b>Unit</b></td>  
  <td ><b>Type</b></td>  
  <td ><b>Stock Alert Quntity</b></td>  
  <td ><b>Show In Daily Report</b></td>  
  <td ><b>Departments</b></td>  
  <td ><b>Recoverable</b></td>  
  <td ><b>Photo</b></td>  
  <td ><b>Code</b></td>  
  <td ><b>Category</b></td>  
  <td ><b>Barcode Applicable</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_itemsGetById('<? echo $record['item_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['item_id']?> </td>  
  <td><?php echo $record['item_name']?> </td>  
  <td><?php echo $record['beng_name']?> </td>  
  <td><?php echo $record['hindi_name']?> </td>  
  <td><?php echo $record['keywords']?> </td>  
  <td> <? if(isset($os->item_unit[$record['item_unit']])){ echo  $os->item_unit[$record['item_unit']]; } ?></td> 
  <td> <? if(isset($os->item_type[$record['item_type']])){ echo  $os->item_type[$record['item_type']]; } ?></td> 
  <td><?php echo $record['stock_alert_quntity']?> </td>  
  <td> <? if(isset($os->show_in_daily_report[$record['show_in_daily_report']])){ echo  $os->show_in_daily_report[$record['show_in_daily_report']]; } ?></td> 
  <td> <? if(isset($os->departments[$record['departments']])){ echo  $os->departments[$record['departments']]; } ?></td> 
  <td> <? if(isset($os->recoverable[$record['recoverable']])){ echo  $os->recoverable[$record['recoverable']]; } ?></td> 
  <td><img src="<?php  echo $site['url'].$record['photo']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['item_code']?> </td>  
  <td> <? if(isset($os->category_list[$record['category_id']])){ echo  $os->category_list[$record['category_id']]; } ?></td> 
  <td> <? if(isset($os->yesno[$record['barcode_applicable']])){ echo  $os->yesno[$record['barcode_applicable']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_itemsEditAndSave')=='OK')
{
 $item_id=$os->post('item_id');
 
 
		 
 $dataToSave['item_name']=addslashes($os->post('item_name')); 
 $dataToSave['beng_name']=addslashes($os->post('beng_name')); 
 $dataToSave['hindi_name']=addslashes($os->post('hindi_name')); 
 $dataToSave['keywords']=addslashes($os->post('keywords')); 
 $dataToSave['item_unit']=addslashes($os->post('item_unit')); 
 $dataToSave['item_type']=addslashes($os->post('item_type')); 
 $dataToSave['stock_alert_quntity']=addslashes($os->post('stock_alert_quntity')); 
 $dataToSave['show_in_daily_report']=addslashes($os->post('show_in_daily_report')); 
 $dataToSave['departments']=addslashes($os->post('departments')); 
 $dataToSave['recoverable']=addslashes($os->post('recoverable')); 
 $photo=$os->UploadPhoto('photo',$site['root'].'wtos-images');
				   	if($photo!=''){
					$dataToSave['photo']='wtos-images/'.$photo;}
 $dataToSave['item_code']=addslashes($os->post('item_code')); 
 $dataToSave['category_id']=addslashes($os->post('category_id')); 
 $dataToSave['barcode_applicable']=addslashes($os->post('barcode_applicable')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($item_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('items',$dataToSave,'item_id',$item_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($item_id>0 ){ $mgs= " Data updated Successfully";}
		if($item_id<1 ){ $mgs= " Data Added Successfully"; $item_id=  $qResult;}
		
		  $mgs=$item_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_itemsGetById')=='OK')
{
		$item_id=$os->post('item_id');
		
		if($item_id>0)	
		{
		$wheres=" where item_id='$item_id'";
		}
	    $dataQuery=" select * from items  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['item_name']=$record['item_name'];
 $record['beng_name']=$record['beng_name'];
 $record['hindi_name']=$record['hindi_name'];
 $record['keywords']=$record['keywords'];
 $record['item_unit']=$record['item_unit'];
 $record['item_type']=$record['item_type'];
 $record['stock_alert_quntity']=$record['stock_alert_quntity'];
 $record['show_in_daily_report']=$record['show_in_daily_report'];
 $record['departments']=$record['departments'];
 $record['recoverable']=$record['recoverable'];
 if($record['photo']!=''){
						$record['photo']=$site['url'].$record['photo'];}
 $record['item_code']=$record['item_code'];
 $record['category_id']=$record['category_id'];
 $record['barcode_applicable']=$record['barcode_applicable'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_itemsDeleteRowById')=='OK')
{ 

$item_id=$os->post('item_id');
 if($item_id>0){
 $updateQuery="delete from items where item_id='$item_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
