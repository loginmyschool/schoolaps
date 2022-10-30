<? 
/*
   # wtos version : 1.1
   # page called by ajax script in mess_meal_itemDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_mess_meal_itemListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
		$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 
$andmorning=  $os->postAndQuery('morning_s','morning','%');
$andat_ten=  $os->postAndQuery('at_ten_s','at_ten','%');
$andnoon=  $os->postAndQuery('noon_s','noon','%');
$andevening=  $os->postAndQuery('evening_s','evening','%');
$andnight=  $os->postAndQuery('night_s','night','%');

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
$andnote=  $os->postAndQuery('note_s','note','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( morning like '%$searchKey%' Or at_ten like '%$searchKey%' Or noon like '%$searchKey%' Or evening like '%$searchKey%' Or night like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from mess_meal_item where mess_meal_item_id>0   $where   $andmorning  $andat_ten  $andnoon  $andevening  $andnight  $anddated  $andbranch_code  $andnote  $andaddedBy   order by mess_meal_item_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Morning</b></td>  
  <td ><b>At Ten</b></td>  
  <td ><b>Noon</b></td>  
  <td ><b>Evening</b></td>  
  <td ><b>Night</b></td>  
  <td ><b>Date</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_mess_meal_itemGetById('<? echo $record['mess_meal_item_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['morning']?> </td>  
  <td><?php echo $record['at_ten']?> </td>  
  <td><?php echo $record['noon']?> </td>  
  <td><?php echo $record['evening']?> </td>  
  <td><?php echo $record['night']?> </td>  
  <td><?php echo $os->showDate($record['dated']);?> </td>  
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
 





if($os->get('WT_mess_meal_itemEditAndSave')=='OK')
{
 $mess_meal_item_id=$os->post('mess_meal_item_id');
 
 
		 
 $dataToSave['morning']=addslashes($os->post('morning')); 
 $dataToSave['at_ten']=addslashes($os->post('at_ten')); 
 $dataToSave['noon']=addslashes($os->post('noon')); 
 $dataToSave['evening']=addslashes($os->post('evening')); 
 $dataToSave['night']=addslashes($os->post('night')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($mess_meal_item_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('mess_meal_item',$dataToSave,'mess_meal_item_id',$mess_meal_item_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($mess_meal_item_id>0 ){ $mgs= " Data updated Successfully";}
		if($mess_meal_item_id<1 ){ $mgs= " Data Added Successfully"; $mess_meal_item_id=  $qResult;}
		
		  $mgs=$mess_meal_item_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_mess_meal_itemGetById')=='OK')
{
		$mess_meal_item_id=$os->post('mess_meal_item_id');
		
		if($mess_meal_item_id>0)	
		{
		$wheres=" where mess_meal_item_id='$mess_meal_item_id'";
		}
	    $dataQuery=" select * from mess_meal_item  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['morning']=$record['morning'];
 $record['at_ten']=$record['at_ten'];
 $record['noon']=$record['noon'];
 $record['evening']=$record['evening'];
 $record['night']=$record['night'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_mess_meal_itemDeleteRowById')=='OK')
{ 

$mess_meal_item_id=$os->post('mess_meal_item_id');
 if($mess_meal_item_id>0){
 $updateQuery="delete from mess_meal_item where mess_meal_item_id='$mess_meal_item_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
