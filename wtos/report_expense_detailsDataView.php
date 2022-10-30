<?

	include('wtosConfigLocal.php');
	include($site['root-wtos'].'wtos.php');
?>
<?
$listHeader='Expense Details Report';
$month=$os->get('month');
$year=$os->get('year');
$andYear='';
if($year!=''){
		$andYear="and date_format(dated, '%Y')='$year'";
}
$andMonth='';
if($month!=''){
		$andMonth="and date_format(dated, '%m')='$month'";
}
$listingQuery="select * from expense_list_details where expense_list_details_id>0   $andYear  $andMonth";
$resource=$os->pagingQuery($listingQuery,1000000,false,true);
$rsRecords=$resource['resource']; 
?>
<h1><?echo $listHeader;?></h1>
<table  border="1" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
								<td >#</td>
								<td ><b>Expense Purpose</b></td>  
								<td ><b>Parent Head Id</b></td>  
								<td ><b>Account Head Id</b></td>  
								<td ><b>Description</b></td>  
								<td ><b>Quantity</b></td>  
								<td ><b>Unit</b></td>  
								<td ><b>Tax Percent</b></td>  
								<td ><b>Rate Excl Tax</b></td>  
								<td ><b>Rate Incl Tax</b></td>  
								<td ><b>Total Excl Tax</b></td>  
								<td ><b>Total Incl Tax</b></td>  
								<td ><b>Tax Amount</b></td>  
								<td ><b>User Id</b></td>  
								<td ><b>Type</b></td>  
						    </tr>
							
							
							
							<?php
								  
							$serial=$os->val($resource,'serial'); 
							$totalAmt=0;  
							while($record=$os->mfa( $rsRecords)){ 
									$serial++;

							 $totalAmt=$totalAmt+$record['total_incl_tax'];

							 ?>
							<tr class="trListing">
								<td><?php echo $serial; ?></td>
								<td>  <? echo 
								$os->rowByField('title','expense_list','expense_list_id',$record['expense_list_id']); ?></td> 
								<td><?php echo $record['parent_head_id']?> </td>  
								<td><?php echo $record['account_head_id']?> </td>  
								<td><?php echo $record['description']?> </td>  
								<td><?php echo $record['quantity']?> </td>  
								<td> <? if(isset($os->unit[$record['unit']])){ echo  $os->unit[$record['unit']]; } ?></td> 
								<td><?php echo $record['tax_percent']?> </td>  
								<td><?php echo $record['rate_excl_tax']?> </td>  
								<td><?php echo $record['rate_incl_tax']?> </td>  
								<td><?php echo $record['total_excl_tax']?> </td>  
								<td><?php echo $record['total_incl_tax']?> </td>  
								<td><?php echo $record['tax_amount']?> </td>  
								<td><?php echo $record['user_id']?> </td>  
								<td> <? if(isset($os->type[$record['type']])){ echo  $os->type[$record['type']]; } ?></td>  	
				 </tr>
                          <?} ?>  
                          <tr>
                          		<td colspan="11" style="color:red">Total Amt.</td>
                          		<td colspan="4"><?echo $totalAmt;?></td>
                          </tr>							 
		</table> 
		

		
<? //include($site['root-wtos'].'bottom.php'); ?>