<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbcategoryDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbcategoryListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andcateStatus=  $os->postAndQuery('cateStatus_s','cateStatus','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or cateStatus like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbcategory where rbcategoryId>0   $where   $andname  $andcateStatus     order by rbcategoryId desc";
	  
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
  <td ><b>Category Status</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbcategoryGetById('<? echo $record['rbcategoryId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td> <? if(isset($os->activeInactive[$record['cateStatus']])){ echo  $os->activeInactive[$record['cateStatus']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbcategoryEditAndSave')=='OK')
{
 $rbcategoryId=$os->post('rbcategoryId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['cateStatus']=addslashes($os->post('cateStatus')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbcategoryId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbcategory',$dataToSave,'rbcategoryId',$rbcategoryId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbcategoryId>0 ){ $mgs= " Data updated Successfully";}
		if($rbcategoryId<1 ){ $mgs= " Data Added Successfully"; $rbcategoryId=  $qResult;}
		
		  $mgs=$rbcategoryId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbcategoryGetById')=='OK')
{
		$rbcategoryId=$os->post('rbcategoryId');
		
		if($rbcategoryId>0)	
		{
		$wheres=" where rbcategoryId='$rbcategoryId'";
		}
	    $dataQuery=" select * from rbcategory  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['cateStatus']=$record['cateStatus'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbcategoryDeleteRowById')=='OK')
{ 

$rbcategoryId=$os->post('rbcategoryId');
 if($rbcategoryId>0){
 $updateQuery="delete from rbcategory where rbcategoryId='$rbcategoryId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
