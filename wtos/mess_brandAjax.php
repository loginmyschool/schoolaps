<? 
/*
   # wtos version : 1.1
   # page called by ajax script in mess_brandDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_mess_brandListing')=='OK'){
		$where='';
		$showPerPage= $os->post('showPerPage');

		$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 	

		$andbrand_name=  $os->postAndQuery('brand_name_s','brand_name','%');
		$andsearch_keys=  $os->postAndQuery('search_keys_s','search_keys','%');
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andnote=  $os->postAndQuery('note_s','note','%');
		$searchKey=$os->post('searchKey');
		if($searchKey!=''){
		$where ="and ( brand_name like '%$searchKey%' Or search_keys like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' )";

		}

		$listingQuery="  select * from mess_brand where mess_brand_id>0   $where   $andbrand_name  $andsearch_keys  $andbranch_code  $andnote  $andaddedBy   order by mess_brand_id desc";
		$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
		$rsRecords=$resource['resource'];
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
								<td >#</td>
								<td >Action </td>
								<td ><b>Brand Name</b></td>  
								<td ><b>Search Keys</b></td>  
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
								<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_mess_brandGetById('<? echo $record['mess_brand_id'];?>')" >Edit</a></span>  <? } ?>  </td>

								<td><?php echo $record['brand_name']?> </td>  
								<td><?php echo $record['search_keys']?> </td>  
								<td>  <? echo 
								$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
								<td><?php echo $record['note']?> </td>
				 			</tr>
                          <?}?>  
					</table> 
		</div>
		<br />				
<?php 
exit();}
 





if($os->get('WT_mess_brandEditAndSave')=='OK')
{
 $mess_brand_id=$os->post('mess_brand_id');
 
 
		 
 $dataToSave['brand_name']=addslashes($os->post('brand_name')); 
 $dataToSave['search_keys']=addslashes($os->post('search_keys')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($mess_brand_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('mess_brand',$dataToSave,'mess_brand_id',$mess_brand_id);///    allowed char '\*#@/"~$^.,()|+_-=:�� 	
		if($qResult)  
				{
		if($mess_brand_id>0 ){ $mgs= " Data updated Successfully";}
		if($mess_brand_id<1 ){ $mgs= " Data Added Successfully"; $mess_brand_id=  $qResult;}
		
		  $mgs=$mess_brand_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_mess_brandGetById')=='OK')
{
		$mess_brand_id=$os->post('mess_brand_id');
		
		if($mess_brand_id>0)	
		{
		$wheres=" where mess_brand_id='$mess_brand_id'";
		}
	    $dataQuery=" select * from mess_brand  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['brand_name']=$record['brand_name'];
 $record['search_keys']=$record['search_keys'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_mess_brandDeleteRowById')=='OK')
{ 

$mess_brand_id=$os->post('mess_brand_id');
 if($mess_brand_id>0){
 $updateQuery="delete from mess_brand where mess_brand_id='$mess_brand_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
