<? 
/*
   # wtos version : 1.1
   # page called by ajax script in mess_stockDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_mess_stockListing')=='OK'){
		$where='';
		$showPerPage= $os->post('showPerPage');


		$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 
		$andmess_item_id=  $os->postAndQuery('mess_item_id_s','mess_item_id','%');

		$f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
		$anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
		$andquantity=  $os->postAndQuery('quantity_s','quantity','%');
		$andunit=  $os->postAndQuery('unit_s','unit','%');
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andnote=  $os->postAndQuery('note_s','note','%');


		$searchKey=$os->post('searchKey');
		if($searchKey!=''){
		$where ="and ( mess_item_id like '%$searchKey%' Or quantity like '%$searchKey%' Or unit like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' )";

		}

		$listingQuery="  select * from mess_stock where mess_stock_id>0   $where   $andmess_item_id  $anddated  $andquantity  $andunit  $andbranch_code  $andnote  $andaddedBy   order by mess_stock_id desc";

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Mess Item</b></td>  
  <td ><b>Dated</b></td>  
  <td ><b>Quantity</b></td>  
  <td ><b>Unit</b></td>  
  <td ><b>Branch Code</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_mess_stockGetById('<? echo $record['mess_stock_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('item_name','mess_item','mess_item_id',$record['mess_item_id']); ?></td> 
  <td><?php echo $os->showDate($record['dated']);?> </td>  
  <td><?php echo $record['quantity']?> </td>  
  <td> <? if(isset($os->unit[$record['unit']])){ echo  $os->unit[$record['unit']]; } ?></td> 
  <td>  <? echo 
	$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
  <td><?php echo $record['note']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_mess_stockEditAndSave')=='OK')
{
 $mess_stock_id=$os->post('mess_stock_id');
 
 
		 
 $dataToSave['mess_item_id']=addslashes($os->post('mess_item_id')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['quantity']=addslashes($os->post('quantity')); 
 $dataToSave['unit']=addslashes($os->post('unit')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($mess_stock_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('mess_stock',$dataToSave,'mess_stock_id',$mess_stock_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($mess_stock_id>0 ){ $mgs= " Data updated Successfully";}
		if($mess_stock_id<1 ){ $mgs= " Data Added Successfully"; $mess_stock_id=  $qResult;}
		
		  $mgs=$mess_stock_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_mess_stockGetById')=='OK')
{
		$mess_stock_id=$os->post('mess_stock_id');
		
		if($mess_stock_id>0)	
		{
		$wheres=" where mess_stock_id='$mess_stock_id'";
		}
	    $dataQuery=" select * from mess_stock  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['mess_item_id']=$record['mess_item_id'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['quantity']=$record['quantity'];
 $record['unit']=$record['unit'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_mess_stockDeleteRowById')=='OK')
{ 

$mess_stock_id=$os->post('mess_stock_id');
 if($mess_stock_id>0){
 $updateQuery="delete from mess_stock where mess_stock_id='$mess_stock_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
