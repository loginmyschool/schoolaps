<? 
/*
   # wtos version : 1.1
   # page called by ajax script in mess_itemDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_mess_itemListing')=='OK'){
			$where='';
			$showPerPage= $os->post('showPerPage');


			$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 
			$anditem_name=  $os->postAndQuery('item_name_s','item_name','%');
			$andname_beng=  $os->postAndQuery('name_beng_s','name_beng','%');
			$andcode=  $os->postAndQuery('code_s','code','%');
			$andsearch_keys=  $os->postAndQuery('search_keys_s','search_keys','%');
			$andunit=  $os->postAndQuery('unit_s','unit','%');
			$andactive_status=  $os->postAndQuery('active_status_s','active_status','%');
			$andstock_alert_qty=  $os->postAndQuery('stock_alert_qty_s','stock_alert_qty','%');
			$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
			$andnote=  $os->postAndQuery('note_s','note','%');
			$andshow_in_daily_report=  $os->postAndQuery('show_in_daily_report_s','show_in_daily_report','%');


			$searchKey=$os->post('searchKey');
			if($searchKey!=''){
			$where ="and ( item_name like '%$searchKey%' Or name_beng like '%$searchKey%' Or code like '%$searchKey%' Or search_keys like '%$searchKey%' Or unit like '%$searchKey%' Or active_status like '%$searchKey%' Or stock_alert_qty like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' Or show_in_daily_report like '%$searchKey%' )";

			}

			$listingQuery="  select * from mess_item where mess_item_id>0   $where   $anditem_name  $andname_beng  $andcode  $andsearch_keys  $andunit  $andactive_status  $andstock_alert_qty  $andbranch_code  $andnote  $andshow_in_daily_report $andaddedBy    order by mess_item_id desc";

			$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
			$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
								<td >#</td>
								<td >Action </td>
								<td ><b>Item Name</b></td>  
								<td ><b>Name beng</b></td>  
								<td ><b>Code</b></td>  
								<td ><b>Search Keys</b></td>  
								<td ><b>Image</b></td>  
								<td ><b>Unit</b></td>  
								<td ><b>Active Status</b></td>  
								<td ><b>Stock Alert Qty</b></td>  
								<td ><b>Branch Code</b></td>  
								<td ><b>Note</b></td>  
								<td ><b>Show In Daily Report</b></td>   
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
									<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_mess_itemGetById('<? echo $record['mess_item_id'];?>')" >Edit</a></span>  <? } ?>  </td>

									<td><?php echo $record['item_name']?> </td>  
									<td><?php echo $record['name_beng']?> </td>  
									<td><?php echo $record['code']?> </td>  
									<td><?php echo $record['search_keys']?> </td>  
									<td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td>  
									<td> <? if(isset($os->unit[$record['unit']])){ echo  $os->unit[$record['unit']]; } ?></td> 
									<td> <? if(isset($os->mess_item_active_status[$record['active_status']])){ echo  $os->mess_item_active_status[$record['active_status']]; } ?></td> 
									<td><?php echo $record['stock_alert_qty']?> </td>  
									<td>  <? echo 
									$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
									<td><?php echo $record['note']?> </td>  
									<td> <? if(isset($os->show_in_daily_report[$record['show_in_daily_report']])){ echo  $os->show_in_daily_report[$record['show_in_daily_report']]; } ?></td> 	
				 </tr>
                          <?} ?>  			 
		</table> 
		</div>
		<br />				
<?php 
exit();	
}
 





if($os->get('WT_mess_itemEditAndSave')=='OK')
{
 $mess_item_id=$os->post('mess_item_id');
 
 
		 
 $dataToSave['item_name']=addslashes($os->post('item_name')); 
 $dataToSave['name_beng']=addslashes($os->post('name_beng')); 
 $dataToSave['code']=addslashes($os->post('code')); 
 $dataToSave['search_keys']=addslashes($os->post('search_keys')); 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}
 $dataToSave['unit']=addslashes($os->post('unit')); 
 $dataToSave['active_status']=addslashes($os->post('active_status')); 
 $dataToSave['stock_alert_qty']=addslashes($os->post('stock_alert_qty')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 
 $dataToSave['show_in_daily_report']=addslashes($os->post('show_in_daily_report')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($mess_item_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('mess_item',$dataToSave,'mess_item_id',$mess_item_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($mess_item_id>0 ){ $mgs= " Data updated Successfully";}
		if($mess_item_id<1 ){ $mgs= " Data Added Successfully"; $mess_item_id=  $qResult;}
		
		  $mgs=$mess_item_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_mess_itemGetById')=='OK')
{
		$mess_item_id=$os->post('mess_item_id');
		
		if($mess_item_id>0)	
		{
		$wheres=" where mess_item_id='$mess_item_id'";
		}
	    $dataQuery=" select * from mess_item  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['item_name']=$record['item_name'];
 $record['name_beng']=$record['name_beng'];
 $record['code']=$record['code'];
 $record['search_keys']=$record['search_keys'];
 if($record['image']!=''){
						$record['image']=$site['url'].$record['image'];}
 $record['unit']=$record['unit'];
 $record['active_status']=$record['active_status'];
 $record['stock_alert_qty']=$record['stock_alert_qty'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];
 $record['show_in_daily_report']=$record['show_in_daily_report'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_mess_itemDeleteRowById')=='OK')
{ 

$mess_item_id=$os->post('mess_item_id');
 if($mess_item_id>0){
 $updateQuery="delete from mess_item where mess_item_id='$mess_item_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
