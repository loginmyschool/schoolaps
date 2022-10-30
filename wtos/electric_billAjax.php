<? 
/*
   # wtos version : 1.1
   # page called by ajax script in electric_billDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 $return_acc=$os->branch_access();
$and_branch='';
 if($os->userDetails['adminType']!='Super Admin')
	{
	  $selected_branch_codes=$return_acc['branches_code_str_query'];
	  $and_branch=" and branch_code IN($selected_branch_codes)";

	 }

$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
     $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
}
?><?

if($os->get('WT_electric_billListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
$andconsumer_id=  $os->postAndQuery('consumer_id_s','consumer_id','%');

    $f_period_from_s= $os->post('f_period_from_s'); $t_period_from_s= $os->post('t_period_from_s');
   $andperiod_from=$os->DateQ('period_from',$f_period_from_s,$t_period_from_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_period_to_s= $os->post('f_period_to_s'); $t_period_to_s= $os->post('t_period_to_s');
   $andperiod_to=$os->DateQ('period_to',$f_period_to_s,$t_period_to_s,$sTime='00:00:00',$eTime='59:59:59');
$andbill_no=  $os->postAndQuery('bill_no_s','bill_no','%');

    $f_bill_date_s= $os->post('f_bill_date_s'); $t_bill_date_s= $os->post('t_bill_date_s');
   $andbill_date=$os->DateQ('bill_date',$f_bill_date_s,$t_bill_date_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_due_date_s= $os->post('f_due_date_s'); $t_due_date_s= $os->post('t_due_date_s');
   $anddue_date=$os->DateQ('due_date',$f_due_date_s,$t_due_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andpayment_status=  $os->postAndQuery('payment_status_s','payment_status','%');

    $f_payment_date_s= $os->post('f_payment_date_s'); $t_payment_date_s= $os->post('t_payment_date_s');
   $andpayment_date=$os->DateQ('payment_date',$f_payment_date_s,$t_payment_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andpayment_mode=  $os->postAndQuery('payment_mode_s','payment_mode','%');
$andpayment_details=  $os->postAndQuery('payment_details_s','payment_details','%');
$andinvoice_no=  $os->postAndQuery('invoice_no_s','invoice_no','%');
$andmeter_no=  $os->postAndQuery('meter_no_s','meter_no','%');
$andnote=  $os->postAndQuery('note_s','note','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( branch_code like '%$searchKey%' Or consumer_id like '%$searchKey%' Or bill_no like '%$searchKey%' Or payment_status like '%$searchKey%' Or payment_mode like '%$searchKey%' Or payment_details like '%$searchKey%' Or invoice_no like '%$searchKey%' Or meter_no like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from electric_bill where electric_bill_id>0   $where   $andbranch_code  $andconsumer_id  $andperiod_from  $andperiod_to  $andbill_no  $andbill_date  $anddue_date  $andpayment_status  $andpayment_date  $andpayment_mode  $andpayment_details  $andinvoice_no  $andmeter_no  $andnote     order by electric_bill_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >
			<td >#</td>
			<td >Action </td>									
			<td ><b>Consumer Id </b></td>  
			<td ><b>Due Date</b></td>  
			<td ><b>Payment</b></td> 
			<td ><b>Due by</b></td>  
			<td ><b>Consume </b></td>  
			<td ><b>Payble Rs </b></td> 
			<td ><b>Bill No</b></td>  
			   
			<td ><b>Branch</b></td>    
			 
		</tr>
		<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>   
							
							
							
							  </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_electric_billGetById('<? echo $record['electric_bill_id'];?>')" >Edit</a></span>  <? } ?>
			<div class="uk-inline">
    <button class="actionLink" type="button">View</button>
    <div uk-drop="mode: click">
        <div class="uk-card uk-card-body uk-card-default">
		
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> <span style="font-size:10px">
	Consumer_id :<?php echo $record['consumer_id']?> <br />
    From : <?php echo $os->showDate($record['period_from'] , 'Y-m-d');?>  <br />
    To  : <?php echo $os->showDate($record['period_to'] , 'Y-m-d');?> <br />
	Prev Unit :<?php echo $record['previous_unit']?><br />
	Present Unit :<?php echo $record['present_unit']?><br />
	Consumed:<?php echo $record['unit_consumed']?> <br /> 
	Rate:<?php echo $record['rate']?> <br /> 
	
	 
	Amount:<?php echo $record['amount']?> <br />
	 Bill Date : <?php echo $os->showDate($record['bill_date'] , 'Y-m-d');?>  <br />
   Due Date : <?php echo $os->showDate($record['due_date'] , 'Y-m-d');?>  <br />
   </span></td>
    <td> <span style="font-size:10px">
	
   payment_date :  <?php echo $os->showDate($record['payment_date']);?><br />
   payment_details <?php echo $record['payment_details']?><br />
	Bill No : <?php echo $record['bill_no']?><br />
	Invoice  No : <?php echo $record['invoice_no']?><br />
	Payment status : <? if(isset($os->payment_status[$record['payment_status']])){ echo  $os->payment_status[$record['payment_status']]; } ?><br />
	Payment Mode :<? if(isset($os->payment_mode[$record['payment_mode']])){ echo  $os->payment_mode[$record['payment_mode']]; } ?><br />
	
	Current_month_amount :<?php echo $record['current_month_amount']?><br />
	Payble Through RTGS : <?php echo $record['payble_through_rtgs']?><br />
	Note :<?php echo $record['note']?><br />
	Branch Code:<? echo  $branch_code_arr[$record['branch_code']];	 ?><br />
	
	 
	
   </span></td>
  </tr>
</table>
<a href="<?php  echo $site['url'].$record['image']; ?>" target="_blank"> <img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /> </a>
		
		</div>
    </div>
</div>				
							
							  </td>
<td><b> <?php echo $record['consumer_id']?> </b> </td>								
  <td><?php echo $os->showDate($record['due_date']);?> </td> 
  
  
   <td> <? if(isset($os->payment_status[$record['payment_status']])){ ?>
   
   <span style=" <? if($record['payment_status']=='Paid'){ ?>  color:#006600; <? }else{ ?> color:#FF0000; <? } ?>">
   
   <? echo  $os->payment_status[$record['payment_status']]; ?>
   
   </span>
   
   <? 
    } ?></td> 
 <td> <?  $origin = new DateTime($os->now());
$target = new DateTime($record['due_date']);
$interval = $origin->diff($target);
$dueby=  $interval->format('%R%a');
$dueby=$dueby*1;

  
 
 ?> 
  <? if($record['payment_status']!='Paid'){ ?>  
<span style=" font-weight:bold;color:<? if($dueby<5){ ?>#FF0000<? }?>" > <? echo $dueby ; ?>  Days</span>
 <? }  ?>
 </td> 
  <td><?php echo $record['unit_consumed']?>   <? if($record['unit_consumed']>0){ ?>  Units <? } ?></td>  
   <td><?php echo $record['amount']?> </td>
   <td><?php echo $record['bill_no']?> </td>  
   <td><? echo  $branch_code_arr[$record['branch_code']];	 ?></td>  
   						 
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_electric_billEditAndSave')=='OK')
{
 $electric_bill_id=$os->post('electric_bill_id');
 
 
		 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['consumer_id']=addslashes($os->post('consumer_id')); 
 $dataToSave['period_from']=$os->saveDate($os->post('period_from')); 
 $dataToSave['period_to']=$os->saveDate($os->post('period_to')); 
 $dataToSave['previous_unit']=addslashes($os->post('previous_unit')); 
 $dataToSave['present_unit']=addslashes($os->post('present_unit')); 
 $dataToSave['unit_consumed']=addslashes($os->post('unit_consumed')); 
 $dataToSave['rate']=addslashes($os->post('rate')); 
 $dataToSave['amount']=addslashes($os->post('amount')); 
 $dataToSave['bill_no']=addslashes($os->post('bill_no')); 
 $dataToSave['bill_date']=$os->saveDate($os->post('bill_date')); 
 $dataToSave['due_date']=$os->saveDate($os->post('due_date')); 
 $dataToSave['payment_status']=addslashes($os->post('payment_status')); 
 $dataToSave['payment_date']=$os->saveDate($os->post('payment_date')); 
 $dataToSave['payment_mode']=addslashes($os->post('payment_mode')); 
 $dataToSave['payment_details']=addslashes($os->post('payment_details')); 
 $dataToSave['invoice_no']=addslashes($os->post('invoice_no')); 
 $dataToSave['meter_no']=addslashes($os->post('meter_no')); 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}
 $dataToSave['current_month_amount']=addslashes($os->post('current_month_amount')); 
 $dataToSave['payble_through_rtgs']=addslashes($os->post('payble_through_rtgs')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		$electric_bill_id_exist=false;
		if($electric_bill_id < 1)
		{		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$electric_bill_id_exist=  $os->rowByField('electric_bill_id','electric_bill','bill_no',$dataToSave['bill_no'],$where='',$orderby=''); 
		}
		
		 
		 $exist_msg='';
		 $qResult=false;		  
		
		 if( !$electric_bill_id_exist )
		 {
          $qResult=$os->save('electric_bill',$dataToSave,'electric_bill_id',$electric_bill_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		  
		 }else{
		 
		 $exist_msg='Bill  already entered';
		 }
		
		
		if($qResult)  
				{
		if($electric_bill_id>0 ){ $mgs= " Data updated Successfully";}
		if($electric_bill_id<1 ){ $mgs= " Data Added Successfully"; $electric_bill_id=  $qResult;}
		
		  $mgs=$electric_bill_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.".$exist_msg;
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_electric_billGetById')=='OK')
{
		$electric_bill_id=$os->post('electric_bill_id');
		
		if($electric_bill_id>0)	
		{
		$wheres=" where electric_bill_id='$electric_bill_id'";
		}
	    $dataQuery=" select * from electric_bill  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['branch_code']=$record['branch_code'];
 $record['consumer_id']=$record['consumer_id'];
 $record['period_from']=$os->showDate($record['period_from']); 
 $record['period_to']=$os->showDate($record['period_to']); 
 $record['previous_unit']=$record['previous_unit'];
 $record['present_unit']=$record['present_unit'];
 $record['unit_consumed']=$record['unit_consumed'];
 $record['rate']=$record['rate'];
 $record['amount']=$record['amount'];
 $record['bill_no']=$record['bill_no'];
 $record['bill_date']=$os->showDate($record['bill_date']); 
 $record['due_date']=$os->showDate($record['due_date']); 
 $record['payment_status']=$record['payment_status'];
 $record['payment_date']=$os->showDate($record['payment_date']); 
 $record['payment_mode']=$record['payment_mode'];
 $record['payment_details']=$record['payment_details'];
 $record['invoice_no']=$record['invoice_no'];
 $record['meter_no']=$record['meter_no'];
 if($record['image']!=''){
						$record['image']=$site['url'].$record['image'];}
 $record['current_month_amount']=$record['current_month_amount'];
 $record['payble_through_rtgs']=$record['payble_through_rtgs'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_electric_billDeleteRowById')=='OK')
{ 

$electric_bill_id=$os->post('electric_bill_id');
 if($electric_bill_id>0){
 $updateQuery="delete from electric_bill where electric_bill_id='$electric_bill_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
if($os->get('WT_electric_billListing_report')=='OK')
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	$os->showPerPage=9000; 	
	
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andconsumer_id=  $os->postAndQuery('consumer_id_s','consumer_id','%');
		$f_period_from_s= $os->post('f_period_from_s'); $t_period_from_s= $os->post('t_period_from_s');
		$andperiod_from=$os->DateQ('period_from',$f_period_from_s,$t_period_from_s,$sTime='00:00:00',$eTime='59:59:59');
		
		$f_period_to_s= $os->post('f_period_to_s'); $t_period_to_s= $os->post('t_period_to_s');
		$andperiod_to=$os->DateQ('period_to',$f_period_to_s,$t_period_to_s,$sTime='00:00:00',$eTime='59:59:59');
		$andbill_no=  $os->postAndQuery('bill_no_s','bill_no','%');

        $f_bill_date_s= $os->post('f_bill_date_s'); $t_bill_date_s= $os->post('t_bill_date_s');
        $andbill_date=$os->DateQ('bill_date',$f_bill_date_s,$t_bill_date_s,$sTime='00:00:00',$eTime='59:59:59');

        $f_due_date_s= $os->post('f_due_date_s'); $t_due_date_s= $os->post('t_due_date_s');
        $anddue_date=$os->DateQ('due_date',$f_due_date_s,$t_due_date_s,$sTime='00:00:00',$eTime='59:59:59');
        $andpayment_status=  $os->postAndQuery('payment_status_s','payment_status','%');

		$f_payment_date_s= $os->post('f_payment_date_s'); $t_payment_date_s= $os->post('t_payment_date_s');
		$andpayment_date=$os->DateQ('payment_date',$f_payment_date_s,$t_payment_date_s,$sTime='00:00:00',$eTime='59:59:59');
		$andpayment_mode=  $os->postAndQuery('payment_mode_s','payment_mode','%');
		$andpayment_details=  $os->postAndQuery('payment_details_s','payment_details','%');
		$andinvoice_no=  $os->postAndQuery('invoice_no_s','invoice_no','%');
		$andmeter_no=  $os->postAndQuery('meter_no_s','meter_no','%');
		$andnote=  $os->postAndQuery('note_s','note','%');

	   
		$searchKey=$os->post('searchKey');
		if($searchKey!=''){
		$where ="and ( branch_code like '%$searchKey%' Or consumer_id like '%$searchKey%' Or bill_no like '%$searchKey%' Or payment_status like '%$searchKey%' Or payment_mode like '%$searchKey%' Or payment_details like '%$searchKey%' Or invoice_no like '%$searchKey%' Or meter_no like '%$searchKey%' Or note like '%$searchKey%' )";
		
		}
		
	$listingQuery="  select * from electric_bill where electric_bill_id>0   $where   $andbranch_code  $andconsumer_id  $andperiod_from  $andperiod_to  $andbill_no  $andbill_date  $anddue_date  $andpayment_status  $andpayment_date  $andpayment_mode  $andpayment_details  $andinvoice_no  $andmeter_no  $andnote     order by electric_bill_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	$list=array();
	$data=array();
	while($record=$os->mfa( $rsRecords)){ 
	   $list[$record['branch_code']][$record['electric_bill_id']]=$record;
	   $data[$record['branch_code']]['count'] = $data[$record['branch_code']]['count'] + 1;
	   $data[$record['branch_code']]['total_amount'] = $data[$record['branch_code']]['total_amount'] + $record['amount'];
	  
	   
	   if($record['payment_status']=='Paid'){
	   $data[$record['branch_code']]['Paid_count'] = $data[$record['branch_code']]['Paid_count'] + 1;
	   $data[$record['branch_code']]['Paid_amount'] = $data[$record['branch_code']]['Paid_amount'] + $record['amount'];
	   $data['Paid_count_total']=$data['Paid_count_total']+1;
	    $data['Paid_amount_total']=$data['Paid_amount_total']+ $record['amount'];
	   
	   }
	    if($record['payment_status']=='Pending'){
	   $data[$record['branch_code']]['Pending_count'] = $data[$record['branch_code']]['Pending_count'] + 1;
	    $data[$record['branch_code']]['Pending_amount'] = $data[$record['branch_code']]['Pending_amount'] + $record['amount'];
	   $data['Pending_count_total']=$data['Pending_count_total']+1;
	    $data['Pending_amount_total']=$data['Pending_amount_total']+ $record['amount'];
	    }
		
		
		$data['grand_total']=$data['grand_total']+$record['amount'];
		 
		
	}
	
	
	 
 
?>


<div class="listingRecords" style=" background-color:#FFFFFF;" id="printrows">
<style>
.noBorder td{ height:30px;border-right:dotted 1px #CACACA;border-bottom:solid 1px #CACACA; padding:1px 2px 1px 2px;}



 .noBorder{border:groove 2px #FFFFFF; border-radius:5px;}
</style>
<div class="pagingLinkCss">Total Record:<b> <? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; Total Amount :<b> <? echo $data['grand_total']?> </b><? echo $resource['links']; ?>   </div>

 <table class="noBorder" >
 <tr class="borderTitle" >
 <td>Branch  </td>    
 <td> Paid Bill Count </td>
 <td> Paid Bill Amount </td>
 <td> Pending Bill Count  </td>
 <td> Pending Bill Amount  </td>
 <td> Total Bill Count </td>     
 <td>Total Bill Amount </td>  
  <td> </td> 
 </tr> 
 
<? foreach($list as $branch_code => $records ){ ?>
<tr>
<td><? echo $branch_code_arr[$branch_code]; ?>  </td>    
<td align="right" style="padding-right:5px; color:#009900">  <? echo  $data[$branch_code]['Paid_count'];  ?>  </td>
<td align="right" style="padding-right:5px;color:#009900"> <? echo  $data[$branch_code]['Paid_amount'];  ?>    </td>
<td align="right" style="padding-right:5px; color:#FF0000"> <? echo  $data[$branch_code]['Pending_count'];  ?>    </td>
<td align="right" style="padding-right:5px;color:#FF0000"> <? echo  $data[$branch_code]['Pending_amount'];  ?>    </td>
<td align="right" style="padding-right:5px;"> <b><? echo  $data[$branch_code]['count'];  ?>  </b>  </td>     
<td align="right" style="padding-right:5px;"><? echo  $data[$branch_code]['total_amount'];  ?> </td> 
<td>
<span style="color:#000099; cursor:pointer" class="hideonprint" onclick="view_e_bills('content_<? echo $branch_code; ?>');">View</span>
<div id="content_<? echo $branch_code; ?>" style="display:none;">            

           <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >
			<td >#</td>
			<td >Action </td>									
			<td ><b>Consumer Id </b></td>  
			<td ><b>Due Date</b></td>  
			<td ><b>Payment</b></td> 
			<td ><b>Due by</b></td>  
			<td ><b>Consume </b></td>  
			<td ><b>Payble Rs </b></td> 
			<td ><b>Bill No</b></td>  
			<td ><b>Period</b></td>  
			   
			  
			 
		</tr>
		<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							foreach($records as $record ){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>   
							
							
							
							  </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<? } ?>
			<div class="uk-inline">
    <button class="actionLink" type="button">View</button>
    <div uk-drop="mode: click">
        <div class="uk-card uk-card-body uk-card-default">
		
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> <span style="font-size:10px">
	Consumer_id :<?php echo $record['consumer_id']?> <br />
    From : <?php echo $os->showDate($record['period_from'] , 'Y-m-d');?>  <br />
    To  : <?php echo $os->showDate($record['period_to'] , 'Y-m-d');?> <br />
	Prev Unit :<?php echo $record['previous_unit']?><br />
	Present Unit :<?php echo $record['present_unit']?><br />
	Consumed:<?php echo $record['unit_consumed']?> <br /> 
	Rate:<?php echo $record['rate']?> <br /> 
	
	 
	Amount:<?php echo $record['amount']?> <br />
	 Bill Date : <?php echo $os->showDate($record['bill_date'] , 'Y-m-d');?>  <br />
   Due Date : <?php echo $os->showDate($record['due_date'] , 'Y-m-d');?>  <br />
   </span></td>
    <td> <span style="font-size:10px">
	
   payment_date :  <?php echo $os->showDate($record['payment_date']);?><br />
   payment_details <?php echo $record['payment_details']?><br />
	Bill No : <?php echo $record['bill_no']?><br />
	Invoice  No : <?php echo $record['invoice_no']?><br />
	Payment status : <? if(isset($os->payment_status[$record['payment_status']])){ echo  $os->payment_status[$record['payment_status']]; } ?><br />
	Payment Mode :<? if(isset($os->payment_mode[$record['payment_mode']])){ echo  $os->payment_mode[$record['payment_mode']]; } ?><br />
	
	Current_month_amount :<?php echo $record['current_month_amount']?><br />
	Payble Through RTGS : <?php echo $record['payble_through_rtgs']?><br />
	Note :<?php echo $record['note']?><br />
	Branch Code:<? echo  $branch_code_arr[$record['branch_code']];	 ?><br />
	
	 
	
   </span></td>
  </tr>
</table>
<a href="<?php  echo $site['url'].$record['image']; ?>" target="_blank"> <img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /> </a>
		
		</div>
    </div>
</div>				
							
							  </td>
<td><b> <?php echo $record['consumer_id']?> </b> </td>								
  <td><?php echo $os->showDate($record['due_date']);?> </td> 
  
  
   <td> <? if(isset($os->payment_status[$record['payment_status']])){ ?>
   
   <span style=" <? if($record['payment_status']=='Paid'){ ?>  color:#006600; <? }else{ ?> color:#FF0000; <? } ?>">
   
   <? echo  $os->payment_status[$record['payment_status']]; ?>
   
   </span>
   
   <? 
    } ?></td> 
 <td> <?  $origin = new DateTime($os->now());
$target = new DateTime($record['due_date']);
$interval = $origin->diff($target);
$dueby=  $interval->format('%R%a');
$dueby=$dueby*1;

  
 
 ?> 
  <? if($record['payment_status']!='Paid'){ ?>  
<span style=" font-weight:bold;color:<? if($dueby<5){ ?>#FF0000<? }?>" > <? echo $dueby ; ?>  Days</span>
 <? }  ?>
 </td> 
  <td><?php echo $record['unit_consumed']?>   <? if($record['unit_consumed']>0){ ?>  Units <? } ?></td>  
   <td><?php echo $record['amount']?> </td>
   <td><?php echo $record['bill_no']?> </td>  
     <td>   <?php echo $os->showDate($record['period_from'] , 'Y-m-d');?>  
    To    <?php echo $os->showDate($record['period_to'] , 'Y-m-d');?>  </td>  
   						 
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
	 
        </div>
</td>
 </tr> 
  
	<? } ?>	
 <tr style="font-size:14px; font-weight:bold;"  >
 <td> TOTAL   </td>    
 <td align="right" style="padding-right:5px;color:#009900"><? echo $data['Paid_count_total']; ?> </td>
  <td align="right" style="padding-right:5px;color:#009900"><? echo $data['Paid_amount_total']; ?> </td>
 <td align="right" style="padding-right:5px;color:#FF0000"> <? echo $data['Pending_count_total']; ?>  </td>
 <td align="right" style="padding-right:5px;color:#FF0000"><? echo $data['Pending_amount_total']; ?> </td>
 <td align="right" style="padding-right:5px;"> <? echo $t= $data['Paid_count_total']+$data['Pending_count_total']; ?>  </td>     
 <td align="right" style="padding-right:5px;"><? echo $data['grand_total']; ?> </td>  
  <td> </td> 
 </tr> 
</table>



		
</div>

						
<?php 
exit();
	
}
 if($os->get('WT_electric_billListing_report_all')=='OK')
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	$os->showPerPage=99000; 	
	
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andconsumer_id=  $os->postAndQuery('consumer_id_s','consumer_id','%');
		$f_period_from_s= $os->post('f_period_from_s'); $t_period_from_s= $os->post('t_period_from_s');
		$andperiod_from=$os->DateQ('period_from',$f_period_from_s,$t_period_from_s,$sTime='00:00:00',$eTime='59:59:59');
		
		$f_period_to_s= $os->post('f_period_to_s'); $t_period_to_s= $os->post('t_period_to_s');
		$andperiod_to=$os->DateQ('period_to',$f_period_to_s,$t_period_to_s,$sTime='00:00:00',$eTime='59:59:59');
		$andbill_no=  $os->postAndQuery('bill_no_s','bill_no','%');

        $f_bill_date_s= $os->post('f_bill_date_s'); $t_bill_date_s= $os->post('t_bill_date_s');
        $andbill_date=$os->DateQ('bill_date',$f_bill_date_s,$t_bill_date_s,$sTime='00:00:00',$eTime='59:59:59');

        $f_due_date_s= $os->post('f_due_date_s'); $t_due_date_s= $os->post('t_due_date_s');
        $anddue_date=$os->DateQ('due_date',$f_due_date_s,$t_due_date_s,$sTime='00:00:00',$eTime='59:59:59');
        $andpayment_status=  $os->postAndQuery('payment_status_s','payment_status','%');

		$f_payment_date_s= $os->post('f_payment_date_s'); $t_payment_date_s= $os->post('t_payment_date_s');
		$andpayment_date=$os->DateQ('payment_date',$f_payment_date_s,$t_payment_date_s,$sTime='00:00:00',$eTime='59:59:59');
		$andpayment_mode=  $os->postAndQuery('payment_mode_s','payment_mode','%');
		$andpayment_details=  $os->postAndQuery('payment_details_s','payment_details','%');
		$andinvoice_no=  $os->postAndQuery('invoice_no_s','invoice_no','%');
		$andmeter_no=  $os->postAndQuery('meter_no_s','meter_no','%');
		$andnote=  $os->postAndQuery('note_s','note','%');

	   
		$searchKey=$os->post('searchKey');
		if($searchKey!=''){
		$where ="and ( branch_code like '%$searchKey%' Or consumer_id like '%$searchKey%' Or bill_no like '%$searchKey%' Or payment_status like '%$searchKey%' Or payment_mode like '%$searchKey%' Or payment_details like '%$searchKey%' Or invoice_no like '%$searchKey%' Or meter_no like '%$searchKey%' Or note like '%$searchKey%' )";
		
		}
		
	$listingQuery="  select * from electric_bill where electric_bill_id>0   $where   $andbranch_code  $andconsumer_id  $andperiod_from  $andperiod_to  $andbill_no  $andbill_date  $anddue_date  $andpayment_status  $andpayment_date  $andpayment_mode  $andpayment_details  $andinvoice_no  $andmeter_no  $andnote     order by electric_bill_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	 
	 
	
	
	 
 
?>


<div class="listingRecords" style=" background-color:#FFFFFF;" id="printrows">
<style>
.noBorder td{ height:30px;border-right:dotted 1px #CACACA;border-bottom:solid 1px #CACACA; padding:1px 2px 1px 2px;}



 .noBorder{border:groove 2px #FFFFFF; border-radius:5px;}
</style>
<div class="pagingLinkCss">Total Record:<b> <? echo $os->val($resource,'totalRec'); ?></b>     </div>

             

           <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
		<tr class="borderTitle" >
			<td >#</td>
			 							
			<td ><b>Consumer Id </b></td>  
			<td ><b>Due Date</b></td>  
			<td ><b>Payment</b></td> 
			<td ><b>Due by</b></td>  
			<td ><b>Consume </b></td>  
			<td ><b>Payble Rs </b></td> 
			<td ><b>Bill No</b></td>  
			<td ><b>Period</b></td>  
			   
			  
			 
		</tr>
		<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>   
							
							
							
							  </td>
							 
<td><b> <?php echo $record['consumer_id']?> </b> </td>								
  <td><?php echo $os->showDate($record['due_date']);?> </td> 
  
  
   <td> <? if(isset($os->payment_status[$record['payment_status']])){ ?>
   
   <span style=" <? if($record['payment_status']=='Paid'){ ?>  color:#006600; <? }else{ ?> color:#FF0000; <? } ?>">
   
   <? echo  $os->payment_status[$record['payment_status']]; ?>
   
   </span>
   
   <? 
    } ?></td> 
 <td> <?  $origin = new DateTime($os->now());
$target = new DateTime($record['due_date']);
$interval = $origin->diff($target);
$dueby=  $interval->format('%R%a');
$dueby=$dueby*1;

  
 
 ?> 
  <? if($record['payment_status']!='Paid'){ ?>  
<span style=" font-weight:bold;color:<? if($dueby<5){ ?>#FF0000<? }?>" > <? echo $dueby ; ?>  Days</span>
 <? }  ?>
 </td> 
  <td><?php echo $record['unit_consumed']?>   <? if($record['unit_consumed']>0){ ?>  Units <? } ?></td>  
   <td><?php echo $record['amount']?> </td>
   <td><?php echo $record['bill_no']?> </td>  
     <td>   <?php echo $os->showDate($record['period_from'] , 'Y-m-d');?>  
    To    <?php echo $os->showDate($record['period_to'] , 'Y-m-d');?>  </td>  
   						 
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
	 
        


		
</div>

						
<?php 
exit();
	
}