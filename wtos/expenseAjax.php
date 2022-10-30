<? 
/*
   # wtos version : 1.1
   # page called by ajax script in expenseDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_expenseListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andexpenseHead=  $os->postAndQuery('expenseHead_s','expenseHead','%');

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='23:59:59');
$andexpenseDetails=  $os->postAndQuery('expenseDetails_s','expenseDetails','%');
$andamount=  $os->postAndQuery('amount_s','amount','%');
$andexpenceTo=  $os->postAndQuery('expenceTo_s','expenceTo','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( expenseHead like '%$searchKey%' Or expenseDetails like '%$searchKey%' Or amount like '%$searchKey%' Or expenceTo like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from expense where expenseId>0   $where   $andexpenseHead  $anddated  $andexpenseDetails  $andamount  $andexpenceTo     order by expenseId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	$reportheader='Expense Report On '.$os->showDate($os->now());
	$os->setSession($reportheader, 'downloadCollectedByHeader');
	$os->setSession($listingQuery, 'downloadExpenseDataQuery');

 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Expense Head</b></td>  
  <td ><b>Date</b></td>  
  <td ><b>Expense Details</b></td>  
  <td ><b>Amount</b></td>  
  <td ><b>Expence To</b></td>  
  						
 <td ><b>Expence By</b></td> 							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->checkAccess('Edit Expense')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="checkEditDeletePassword('<? echo $record['expenseId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
 <td>  <?php echo $record['expenseHead']?></td>	
  <td><?php echo $os->showDate($record['dated']);?> </td>  
  <td><?php echo $record['expenseDetails']?> </td>  
  <td><?php echo $record['amount']?> </td>  
  <td><?php echo $record['expenceTo']?> </td>  
   <td >  <? echo $os->rowByField('name','admin','adminId',$record['modifyBy']); ?></td> 
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_expenseEditAndSave')=='OK')
{
 $expenseId=$os->post('expenseId');
 
 
		 
 $dataToSave['expenseHead']=addslashes($os->post('expenseHeadTextBox')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['expenseDetails']=addslashes($os->post('expenseDetails')); 
 $dataToSave['amount']=addslashes($os->post('amount')); 
 $dataToSave['expenceTo']=addslashes($os->post('expenceTo')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($expenseId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('expense',$dataToSave,'expenseId',$expenseId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($expenseId>0 ){ $mgs= " Data updated Successfully";
		$operation='Edit expense';
		
		}
		if($expenseId<1 ){ $mgs= " Data Added Successfully"; $expenseId=  $qResult;
		
		
		$operation='Add expense';}
		
		  $mgs=$expenseId."#-#".$mgs;
		  
		  
		  
		  
		  
		   $addedBy=$os->userDetails['adminId'];
		  $description=json_encode($dataToSave);
		  
       $os->setLogRecord('expense',$qResult,$operation,$addedBy,$description);
		  
		  
		  
		  
		  
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 


if($os->get('checkEditDeletePassword')=='OK')
{
	
	 $expenseId=$os->post('expenseId');
	 $password=$os->post('password');
	$operationType=$os->post('operationType');
    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
	if($password==$editDeletePassword)
	{
		$msg="password matched#-#".$expenseId."#-#Edit Data";
		if($operationType=='deleteData')
		{
			$msg="password matched#-#".$expenseId."#-#Delete Data";
		}
	}
	else
	{
		$msg="wrong password";
	}
	echo $msg;
	exit();
	
}



 
if($os->get('WT_expenseGetById')=='OK')
{
		$expenseId=$os->post('expenseId');
		
		if($expenseId>0)	
		{
		$wheres=" where expenseId='$expenseId'";
		}
	    $dataQuery=" select * from expense  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['expenseHead']=$record['expenseHead'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['expenseDetails']=$record['expenseDetails'];
 $record['amount']=$record['amount'];
 $record['expenceTo']=$record['expenceTo'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_expenseDeleteRowById')=='OK')
{ 

$expenseId=$os->post('expenseId');
 if($expenseId>0){
 $updateQuery="delete from expense where expenseId='$expenseId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
