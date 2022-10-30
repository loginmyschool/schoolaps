<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbproductDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbproductListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');
$andname=  $os->postAndQuery('name_s','name','%');
$andproductCode=  $os->postAndQuery('productCode_s','productCode','%');
$andmodel=  $os->postAndQuery('model_s','model','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or name like '%$searchKey%' Or productCode like '%$searchKey%' Or model like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbproduct where rbproductId>0   $where   $andrefCode  $andname  $andproductCode  $andmodel     order by rbproductId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Reffer Code</b></td>  
  <td ><b>Name</b></td>  
  <td ><b>Product Code</b></td>  
  <td ><b>Model</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbproductGetById('<? echo $record['rbproductId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['refCode']?> </td>  
  <td><?php echo $record['name']?> </td>  
  <td><?php echo $record['productCode']?> </td>  
  <td><?php echo $record['model']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbproductEditAndSave')=='OK')
{
 $rbproductId=$os->post('rbproductId');
 
 
		 
 $dataToSave['refCode']=addslashes($os->post('refCode')); 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['productCode']=addslashes($os->post('productCode')); 
 $dataToSave['model']=addslashes($os->post('model')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbproductId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbproduct',$dataToSave,'rbproductId',$rbproductId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbproductId>0 ){ $mgs= " Data updated Successfully";}
		if($rbproductId<1 ){ $mgs= " Data Added Successfully"; $rbproductId=  $qResult;}
		
		  $mgs=$rbproductId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbproductGetById')=='OK')
{
		$rbproductId=$os->post('rbproductId');
		
		if($rbproductId>0)	
		{
		$wheres=" where rbproductId='$rbproductId'";
		}
	    $dataQuery=" select * from rbproduct  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['refCode']=$record['refCode'];
 $record['name']=$record['name'];
 $record['productCode']=$record['productCode'];
 $record['model']=$record['model'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbproductDeleteRowById')=='OK')
{ 

$rbproductId=$os->post('rbproductId');
 if($rbproductId>0){
 $updateQuery="delete from rbproduct where rbproductId='$rbproductId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
