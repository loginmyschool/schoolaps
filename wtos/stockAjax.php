<? 
/*
   # wtos version : 1.1
   # page called by ajax script in stockDataView.php 
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
	 	
	
$andrbproductId=  $os->postAndQuery('rbproductId_s','rbproductId','%');
$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');
$andname=  $os->postAndQuery('name_s','name','%');
$andproductCode=  $os->postAndQuery('productCode_s','productCode','%');
$andmodel=  $os->postAndQuery('model_s','model','%');
$andtype=  $os->postAndQuery('type_s','type','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( rbproductId like '%$searchKey%' Or refCode like '%$searchKey%' Or name like '%$searchKey%' Or productCode like '%$searchKey%' Or model like '%$searchKey%' Or type like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbproduct where rbproductId>0   $where   $andrbproductId  $andrefCode  $andname  $andproductCode  $andmodel  $andtype     order by rbproductId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	## stock calculation start
	
	function executeStock($query)
	{
	   global $os;
	   $resa=array();
	   $StockRs = $os->mq($query);
		while($row = $os->mfa($StockRs))
		{
			 
			$resa[$row['rbproductId']] = $row['totalQty'];
			
		}
		return $resa;
	}

 

if($sDate != ""){
	$andPurchaseStartDate = ' and rbpurchaseDate < ' . ' " ' .$sDatesDb. ' " ';
	$andBilledStartDate = ' and billDate < ' . ' " ' . $sDatesDb. ' " ';
}
if($eDate != ""){
	$andPurchaseEndDate = ' and rbpurchaseDate <= ' . ' " ' . $eDateDb. ' " ';
	$andBilledendDate = ' and billDate  <= ' . ' " ' . $eDateDb. ' " ';
}


$year=date('Y');
$sdate=$year."-01-01 00:00:00";
$edate=$year."-12-30 00:00:00";
$andDate1p="  and rbpurchaseDate < '$sdate' ";
$andDate1b="  and billDate < '$sdate' ";

$andDate2p="  and rbpurchaseDate <= '$edate' ";
$andDate2b=" and billDate <= ' $edate' ";

$purchase_date1 ="select P.rbproductId , sum(P.quantity) totalQty from rbpurchasedetails P where P.rbpurchaseId IN(select Pu.rbpurchaseId from rbpurchase Pu where rbpurchaseId >0 $andDate1p) group by P.rbproductId ";
$purchase_date2 ="select P.rbproductId , sum(P.quantity) totalQty from rbpurchasedetails P where P.rbpurchaseId IN(select Pu.rbpurchaseId from rbpurchase Pu where rbpurchaseId >0 $andDate2p) group by P.rbproductId ";
$bill_date1 ="select P.rbproductId , sum(P.quantity) totalQty from rbpbilldetails P where P.rbpbillId IN(select Pu.rbpbillId from rbpbill Pu where rbpbillId >0 $andDate1b) group by P.rbproductId ";
$bill_date2 ="select P.rbproductId , sum(P.quantity) totalQty from rbpbilldetails P where P.rbpbillId IN(select Pu.rbpbillId from rbpbill Pu where rbpbillId >0 $andDate2b) group by P.rbproductId ";


$purchaseD1 =executeStock($purchase_date1);
$purchaseD2 =executeStock($purchase_date2);
$billD1 =executeStock($bill_date1);
$billD2 =executeStock($bill_date2);
 


?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>    </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Id</b></td>  
  <td ><b>Ref Code</b></td>  
  <td ><b>Name</b></td>  
  <td ><b>Product Code</b></td>  
  <td ><b>Model</b></td>  
  <td ><b>Type</b></td>  
 
<td ><b>Opening</b></td>  
<td ><b>Purchase</b></td>  
<td ><b>Total</b></td>  
<td ><b>Billed</b></td>  
<td ><b>Closing</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								$rbproductId= $record['rbproductId'];
								
								 
								$OpenStock=$purchaseD1[$rbproductId]-$billD1[$rbproductId];
								$Purchase=$purchaseD2[$rbproductId]-$purchaseD1[$rbproductId];
								$TotalStock=$OpenStock+$Purchase;
								$Billed=$billD2[$rbproductId]-$billD1[$rbproductId];
								$ClosingStock=$TotalStock-$Billed;
								
							 $OpenStock=$OpenStock==0?'-':$OpenStock;
							 $Purchase=$Purchase==0?'-':$Purchase;
							 $TotalStock=$TotalStock==0?'-':$TotalStock;
							 $Billed=$Billed==0?'-':$Billed;
							 $ClosingStock=$ClosingStock==0?'-':$ClosingStock;
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbproductGetById('<? echo $record['rbproductId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['rbproductId']?> </td>  
  <td><?php echo $record['refCode']?> </td>  
  <td><?php echo $record['name']?> </td>  
  <td><?php echo $record['productCode']?> </td>  
  <td><?php echo $record['model']?> </td>  
  <td> <? if(isset($os->productType[$record['type']])){ echo  $os->productType[$record['type']]; } ?></td> 
   <td align="center"><?php echo $OpenStock?> </td> 
   <td align="center"><?php echo $Purchase?> </td>   
   <td align="center"><?php echo $TotalStock?> </td>
    <td align="center"><?php echo $Billed?> </td>   
	<td align="center"><?php echo $ClosingStock?> </td>   
								
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
 $dataToSave['type']=addslashes($os->post('type')); 

 
		
		
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
 $record['type']=$record['type'];

		
		
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
 
