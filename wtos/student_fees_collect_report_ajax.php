<?

/*

   # wtos version : 1.1

   # page called by ajax script in 

   #

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

// branch access--
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


if($os->get('monthly_fees_report')=='OK' && $os->post('monthly_fees_report')=='OK')
{
   
		$class_id_s=$os->post('classList_s');
		$branch_code_s=$os->post('branch_code_s');
		$from_date=$os->post('from_date');
		$to_date=$os->post('to_date');
		
		 
		
		$and_class_id_s='';
		if($class_id_s!=''){ $and_class_id_s=" and  fp.classId='$class_id_s'"; }
		
		$and_branch_code_s='';
		if($branch_code_s!=''){ $and_branch_code_s=" and  h.branch_code='$branch_code_s'"; }
		
		$and_from_date='';
		if(trim($from_date)!=''){ 
		$from_dates=$from_date.' 00:00:00';
		$and_from_date=" and  fp.paidDate >= '$from_dates'"; }
		
		$and_to_date='';
		if(trim($to_date)!=''){ 
		$to_dates=$to_date.' 23:59:59';
		$and_to_date=" and  fp.paidDate <= '$to_dates'"; 
		}
		
		
	
	 
	// date_format(dated, '%Y')='$year'
	 
 
	 
	
	   	$listingQuery=" SELECT  fp.*,s.name,s.registerNo,a.name admin_name from  fees_payment  fp
		left join student s on fp.studentId=s.studentId
		left join history h on fp.historyId=h.historyId
		left join admin a on fp.addedBy=a.adminId
		where  fp.studentId=s.studentId  $and_branch_code_s   $and_class_id_s  $and_from_date  $and_to_date
		 ";
		$resource=$os->mq($listingQuery);
		 
?>
<div class="listingRecords"> 
 
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >

<tr   >
									<td colspan="20" align="center" ><h3>Fees collection report </h3>
 <? if($branch_code_s){?>	<h5> <? echo $branch_code_arr[$branch_code_s]; ?> </h5> <?  } else { ?>    <? } ?>
 <div>  
 <? if($class_id_s){?> Class :  <? echo $os->classList[$class_id_s]; ?> <br /> <?  } else { ?>  <? } ?>
 <div style=" font-size:11px;">   <? if($from_date){?> From  <? echo $from_date; ?> <?  } else { ?>  <? } ?>
  <? if($to_date){?> Up to  <? echo $to_date; ?> <?  } else { ?>  <? } ?></div>
 </div> </td>
									 
						    </tr>


							<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Reg No</b></td>  
									<td ><b>Student</b></td>  
									<td ><b>Class</b></td> 
									<td >Paid Date </td> 
									<td align="right" >Paid Amount </td> 
									<td >Mode </td>
									<td >Remarks </td>
									<td >Entry Date </td>
									<td> Entry By </td>
						    </tr>
							<?php
							$payment_options_total=array();
						  	 $serial=0;  
							 while($record=$os->mfa( $resource)){ 
								$serial++;	
							 $col_total=	$col_total + $record['paidAmount'];	 
							
							$payment_options = $record['payment_options'];
							$payment_options_total[$payment_options] =  $payment_options_total[$payment_options]+ $record['paidAmount'];	 
							
							
							?> 
							<tr class="trListing">
							<td><?php echo $serial;?>  </td>
							<td> <b> <?php echo $record['registerNo']?> </b></td>
							<td><?php echo $record['name']?>  </td>
							<td><?php echo $os->classList[$record['classId']]?>  </td>
							<td><?php echo $os->showDate($record['paidDate']);?>  </td>
							<td align="right"><b> <?php echo $record['paidAmount']?></b>  </td>
							<td><?php echo $record['payment_options']?>  </td>
							<td><?php echo $record['remarks']?>  </td>
							<td><?php echo $os->showDate($record['addedDate']);?>  </td>
							<td><?php echo $record['admin_name'];?>  </td>
						 
				 </tr>
                          <? } ?>  
						  
						  <tr class="trListing">
						  <td>   </td>
							<td>   </td>
							<td>  </td>
							<td>   </td>
							<td> Total  </td>
							<td align="right"><b><?php echo $col_total;?> </b>  </td>
							<td>  </td>
							<td>   </td>
							<td>  </td>
							 
							 <td>  </td>
		
				 </tr>
							
		</table> 
		
		<div style="height:5px;"> </div>
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
									 
									<td ><b>Payment Option</b></td>  
									<td ><b>Amount</b></td>  
									 
						    </tr>
							
							<? foreach($payment_options_total as $payment_options=>$amount){ ?>
							<tr class="trListing">
							<td><?php echo $payment_options;?>  </td>
							<td> <b> <?php echo $amount;?> </b></td>	
							</tr>
							<? } ?>
							<tr class="trListing">
							<td>Total  </td>
							<td> <b> <?php echo array_sum($payment_options_total);?> </b></td>	
							</tr>
							</table>
		
		
		
		
		</div> 
	
	<? 
	
	exit(); 
}


if($os->get('add_fees_config')=='OK' && $os->post('add_fees_config')=='OK')
{
     
	
$classList_s=$os->post('classList_s');
$student_type=$os->post('student_type');
$feesType_val=$os->post('feesType_val');
$asession=$os->post('asession');
$fees_slab_amount=$os->post('fees_slab_amount');
$feesHead=$os->post('feesHead');

$branch_code_s=$os->post('branch_code_s');
    

    if($feesType_val!='' && $classList_s!='' && $student_type!='' && $feesHead!=''   && $asession!=''  )
    {


            foreach($fees_slab_amount as $fees_slab_id=>$amount)
			  {

                    $dataToSave=array();
                    $dataToSave['classId']=$classList_s;
					 $dataToSave['branch_code']=$branch_code_s;
                    $dataToSave['accademicsessionId']=$asession;
                    $dataToSave['student_type']=$student_type;
                    $dataToSave['feesType']=$feesType_val;
                    $dataToSave['feesHead']=$feesHead;					
                    $dataToSave['amount']=$amount;
					$dataToSave['fees_slab_id']=$fees_slab_id;
                    $dataToSave['addedDate']=$os->now();
                    $dataToSave['addedBy']=$os->userDetails['adminId'];
                    $qResult=$os->save('feesconfig',$dataToSave,'feesconfigId','');///    allowed char '\*#@/"~$^.,()|+_-=:��

                }
            
    }

  

    exit();
}

 
