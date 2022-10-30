<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
if($os->get('WT_donationListing')=='OK'){
		
		$year= $os->post('year_s');
		$andYear='';
		if($year!=''){
			$andYear="where date_format(dated, '%Y')='$year'";
		}
		

		$listingQuery=" SELECT  date_format(dated, '%M-%Y') as monthAndYear,SUM(total_incl_tax) as totalAmt, date_format(dated, '%m') as expenseMonth, date_format(dated, '%Y') as expenseYear FROM expense_list_details  $andYear	
		group by monthAndYear order by expenseYear,expenseMonth";
		$resource=$os->pagingQuery($listingQuery,10000000,false,true);
		$rsRecords=$resource['resource']; 
?>
<div class="listingRecords">
<!-- 
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div> -->
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Donation Type</b></td>  
									<td ><b>amount</b></td> 
									<td >Action </td> 
						    </tr>
							<?php
						  	 $serial=$os->val($resource,'serial');  
							 while($record=$os->mfa( $rsRecords)){ 
							    	$serial++;	
							?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							<td> <?  echo  $record['monthAndYear'];  ?></td> 
							<td><?php echo $record['totalAmt']?> </td> 
							<td> 
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="expenseDetails('<? echo $record['expenseMonth'];?>','<? echo $record['expenseYear'];?>')" >View Details</a></span></td>
		
				 </tr>
                          <?}?>  
							
		</table> 
		</div>
		<br />			
<?php exit();}?>
 

