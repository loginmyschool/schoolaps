<? 
/*
   # wtos version : 1.1
   # page called by ajax script in mess_baburchiDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_mess_baburchiListing')=='OK'){
		$where='';
		$showPerPage= $os->post('showPerPage');
		$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 
		$f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
		$anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
		$andbuilding=  $os->postAndQuery('building_s','building','%');
		$andname=  $os->postAndQuery('name_s','name','%');
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andnote=  $os->postAndQuery('note_s','note','%');
		$searchKey=$os->post('searchKey');
		if($searchKey!=''){
		$where ="and ( building like '%$searchKey%' Or name like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' )";

		}

		$listingQuery="  select * from mess_baburchi where mess_baburchi_id>0   $where   $anddated  $andbuilding  $andname  $andbranch_code  $andnote $andaddedBy    order by mess_baburchi_id desc";
		$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
		$rsRecords=$resource['resource'];

 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
								<td >#</td>
								<td >Action </td>
								<td ><b>Date</b></td>  
								<td ><b>Building</b></td>  
								<td ><b>Name</b></td>  
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
								<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_mess_baburchiGetById('<? echo $record['mess_baburchi_id'];?>')" >Edit</a></span>  <? } ?>  </td>

								<td><?php echo $os->showDate($record['dated']);?> </td>  
								<td><?php echo $record['building']?> </td>  
								<td><?php echo $record['name']?> </td>  
								<td>  <? echo 
								$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
								<td><?php echo $record['note']?> </td> 								
				 </tr>
                          <? } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_mess_baburchiEditAndSave')=='OK')
{
 $mess_baburchi_id=$os->post('mess_baburchi_id');
 
 
		 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['building']=addslashes($os->post('building')); 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($mess_baburchi_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('mess_baburchi',$dataToSave,'mess_baburchi_id',$mess_baburchi_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($mess_baburchi_id>0 ){ $mgs= " Data updated Successfully";}
		if($mess_baburchi_id<1 ){ $mgs= " Data Added Successfully"; $mess_baburchi_id=  $qResult;}
		
		  $mgs=$mess_baburchi_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_mess_baburchiGetById')=='OK')
{
		$mess_baburchi_id=$os->post('mess_baburchi_id');
		
		if($mess_baburchi_id>0)	
		{
		$wheres=" where mess_baburchi_id='$mess_baburchi_id'";
		}
	    $dataQuery=" select * from mess_baburchi  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['dated']=$os->showDate($record['dated']); 
 $record['building']=$record['building'];
 $record['name']=$record['name'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_mess_baburchiDeleteRowById')=='OK')
{ 

$mess_baburchi_id=$os->post('mess_baburchi_id');
 if($mess_baburchi_id>0){
 $updateQuery="delete from mess_baburchi where mess_baburchi_id='$mess_baburchi_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
