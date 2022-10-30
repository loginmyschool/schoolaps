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
	$from_month_s=$os->post('from_month_s');
	$from_year_s=$os->post('from_year_s');
	$to_month_s=$os->post('to_month_s');
	$to_year_s=$os->post('to_year_s');
	$fees_type_s=$os->post('fees_type_s');
	
	
	if($os->userDetails['adminType']!='Super Admin' &&  $branch_code_s =='')
    {

   echo "Please select Branch";
        exit();

    }
	
	
	
	$class_id_s=$os->post('classList_s');
	if(trim($to_month_s)==''){$to_month_s =(int)date('m');}
	if($to_year_s==''){$to_year_s = date('Y');}
	
	if(trim($from_month_s)==''){$from_month_s =(int)date('m');}
	if($from_year_s==''){$from_year_s = date('Y');}
	
	$from_month_s=str_pad($from_month_s, 2, "0", STR_PAD_LEFT);
	$to_month_s=str_pad($to_month_s, 2, "0", STR_PAD_LEFT);
	
	
	 
	//$and_branch_code_s=" and  h.branch_code='$branch_code_s'";
	
	
	
	 
	 if($branch_code_s!=''){ $and_branch_code_s=" and  h.branch_code='$branch_code_s'"; }
	 
	$and_class_id_s='';
	if($class_id_s!=''){ $and_class_id_s=" and  fs.classId='$class_id_s'"; }
	
	$and_fees_type_s='';
	if($fees_type_s!=''){ $and_fees_type_s=" and  fs.feesType='$fees_type_s'"; }
	
	   $Search_months=array();
	   if( $from_month_s!='' && $from_year_s!='' && $to_month_s!='' && $to_year_s!='')
		{		 
		    
			$start_monthyear=$from_year_s.'-'.$from_month_s.'-'.'1 00:00:00';
			$end_monthyear=$to_year_s.'-'.$to_month_s.'-'.'1 23:59:59';
			$Search_months=$os->dateIntervalList($start_monthyear,$end_monthyear,$intervals='P1M',$format='Ym' ,$modify='+0 Month');
		
		}
		
		 
	
	
		
		#------------------- date preparation--------------------#
		$start_date=$from_year_s.'-'.$from_month_s.'-'.'01 00:00:00';
			$end_date=$to_year_s.'-'.$to_month_s.'-'.'31 23:59:59';
			
		
	
		
		 #----------------------- total Fees  calculation ---------------------------------------#
	  
		 	$listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fs.totalPayble) fees_amount  	 		  
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType 
			
			";	 
		 
			$fees_amount_array=array();
			 
			$fees_type_array=array();		
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month;			
				$fees_type_array[$feesType]=$feesType;
				$fees_amount_array[$ym][$feesType]=$record['fees_amount'];
				$fees_amount_array[$ym]['total_fees_amount']=$fees_amount_array[$ym]['total_fees_amount']+$record['fees_amount'];
				 
				
			}
	  
		#--------------------------------------------------------------# 
		
		
		#----------------------- waived off Fees  calculation ---------------------------------------#
	  
		 	 $listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fw.waive_amount) waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'   
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType 
			";
				 
		 
			$waived_off_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 				
				
				$waived_off_amount_array[$ym][$feesType]=$record['waived_amount'];				 			
				$waived_off_amount_array[$ym]['total_waived_off']=$waived_off_amount_array[$ym]['total_waived_off']+$record['waived_amount'];
				
			}
			
			 
		#--------------------------------------------------------------# 
		 #-----------------------unbilled waived off Fees  calculation ---------------------------------------#
	  
		 	 $listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fw.waive_amount) unbilled_waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where fs.dated >= '$start_date' and  fs.dated <= '$end_date'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s  and fees_payment_id<1
			group by fs.month,fs.year,fs.feesType 
			";
				 
		 
			$unbilled_waived_off_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 				
				
				$unbilled_waived_off_amount_array[$ym][$feesType]=$record['unbilled_waived_amount'];				 			
				$unbilled_waived_off_amount_array[$ym]['total_unbilled_waived_amount']=$unbilled_waived_off_amount_array[$ym]['total_unbilled_waived_amount']+$record['unbilled_waived_amount'];
				
			}
			
			  
		#--------------------------------------------------------------# 
		
		 #----------------------- unpaid due Fees  calculation ---------------------------------------#
	  
		 	$listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fs.totalPayble) unpaid_due  				  
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'     and  fs.paymentStatus='unpaid'
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType 
			";
				 
		 
			$unpaid_due_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				 $feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 	
				
				$unpaid_due=		$record['unpaid_due'] -	$unbilled_waived_off_amount_array[$ym][$feesType];
				
				$unpaid_due_amount_array[$ym][$feesType]=$unpaid_due;		
				
						 			
				$unpaid_due_amount_array[$ym]['total_unpaid_due']=$unpaid_due_amount_array[$ym]['total_unpaid_due']+$unpaid_due; 
				
			}
			 //$unpaid_due_amount_array=array();
		#--------------------------------------------------------------# 
		
		
		
		
		#----------------------- installment due Fees  calculation ---------------------------------------#	  
	 		$listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fp.currentDueAmount) installment_due  				  
			from  fees_payment fp 
			
			left join  fees_student  fs on fp.due_on_fees_student_id=fs.fees_student_id	
			left join history h on fs.historyId=h.historyId		   
			where fs.dated >= '$start_date' and  fs.dated <= '$end_date'   and  fs.paymentStatus='installment'
			$and_branch_code_s   $and_class_id_s $and_fees_type_s and fp.historyId=fs.historyId	
			AND fp.fees_payment_id = (
                Select Max(fp2.fees_payment_id)
                From fees_payment As fp2
                Where fp.due_on_fees_student_id = fp2.due_on_fees_student_id
                )	  	
			group by fs.month,fs.year,fs.feesType 
			";
				  
		 
			$installment_due_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 				
				
						
				
				$installment_due=		$record['installment_due'] -	$unbilled_waived_off_amount_array[$ym][$feesType];
				
				$installment_due_amount_array[$ym][$feesType]=$installment_due;
						 			
				$installment_due_amount_array[$ym]['total_installment_due']=$installment_due_amount_array[$ym]['total_installment_due']+$installment_due;
				
			}
			 
			  
		#--------------------------------------------------------------# 
		 
		
		
		
		
?>
	

 
   
<div class="listingRecords"> 
 
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >

<tr   >
									<td colspan="30" align="center" ><h3>FEES REPORT </h3>
<? if($branch_code_s){?>	<h4> <? echo $branch_code_arr[$branch_code_s]; ?> </h4> <?  } ?>
<? if($class_id_s){?> Class :  <? echo $os->classList[$class_id_s]; ?> <br /> <?  } else { ?>  <? } ?>
  From  
<? if($from_month_s){?> <? echo $os->feesMonth[(int)$from_month_s]; ?> <?  } ?> 
<? if($from_year_s){?> <? echo $os->feesYear[$from_year_s]; ?> <?  } ?>
&nbsp; To
<? if($to_month_s){?> <? echo $os->feesMonth[(int)$to_month_s]; ?> <?  } ?> 
<? if($to_year_s){?> <? echo $os->feesYear[$to_year_s]; ?> <?  } ?> </td>
									 
						    </tr>


							<tr class="borderTitle" >
							
							        <td colspan="3" style="font-size:16px; font-weight:bold; text-align:center; background-color:#FFFFFF;" > </td>
									  
									
									<? foreach($fees_type_array as $fees_type ){ ?> 
									<td colspan="5" style="font-size:16px; font-weight:bold; text-align:center; background-color:#FFFFFF;"><? echo $fees_type; ?> </td> 
									 
									<? } ?>
									
									<?  if($fees_type_s==''){?>
									
									<td colspan="5" style="font-size:16px; font-weight:bold;text-align:center;background-color:#FFFFFF;">Total </td> 
								  
									 
									<? } ?>
									</tr>	
									
									<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Month </b></td>  
									<td ><b>Year </b></td>  
									
									 <? foreach($fees_type_array as $fees_type ){ ?> 
									<td ><b> Fees </b> </td> 
									<td ><b> Waived </b> </td> 
									<td ><b> Payble </b> </td> 
									<td ><b>Paid </b> </td> 
									<td ><b>Due </b> </td> 
									<? } ?>
									
									<?  if($fees_type_s==''){?>
									
									<td ><b>Total Fees </b></td> 
									<td ><b>Total waived </b></td>
									<td ><b>Total Payble</b></td>
									<td ><b>Total Paid</b> </td>
									<td ><b>Total Due</b> </td>
									 <? } ?>
						    </tr>
							<?php
						 $serial=0;
						 $all_month_total=array();
							 foreach( $Search_months  as $ym){ 
								 $serial++; 
								 $year=substr($ym,0,4);
								 $month=substr($ym,4,2);
							 
							?> 
							<tr class="trListing" >
							<td><?php echo $serial;?>  </td>
							<td> <?php echo $os->feesMonth[(int)$month];?>    </td>
							<td>   <?php echo $year;?>  </td>
							
									<? 
									$i=0;
									
									
									
									foreach($fees_type_array as $fees_type )
									    { 
									     $i++;
										   $color_column="background-color:#FFFFCC;";
										   if($i%2==0){ $color_column="background-color:#F2F2F2;";  }
										   $color_column='';
										 
											$fees_amount=$fees_amount_array[$ym][$fees_type];	
											$waived_off_amount=$waived_off_amount_array[$ym][$fees_type];
																					
											$unpaid_due_amount=$unpaid_due_amount_array[$ym][$fees_type];											
											$installment_due_amount=$installment_due_amount_array[$ym][$fees_type];
											
											$unbilled_waived_amount=$unbilled_waived_off_amount_array[$ym][$feesType]; // not need in this location adede in query loop
											
											
											$payble=  $fees_amount -$waived_off_amount;
																						
											$due_amount=  $unpaid_due_amount  + $installment_due_amount  ; 
											
											
											
											 	 			
				 
											
											
											$paid_amount=  $payble -$due_amount;											
											
			 
											
											if($fees_amount==0){$fees_amount='';}
											if($waived_off_amount==0){$waived_off_amount='';}
											if($paid_amount==0){$paid_amount='';}
											if($due_amount==0){$due_amount='';}
											if($payble==0){$payble='';}
											 
											
											 	 	 	 	 
											
											
											
											?> 
											<td  style=" <? echo $color_column; ?> "><? echo $fees_amount; ?>   </td> 
											<td  style=" <? echo $color_column; ?> ">  <? echo $waived_off_amount; ?>  </td> 
											<td style=" <? echo $color_column; ?> ">  <? echo $payble; ?>   </td> 
											<td style=" <? echo $color_column; ?> ">  <? echo $paid_amount; ?>   </td> 
											<td style=" border-right: 2px solid #000000; <? echo $color_column; ?> ">  <? echo $due_amount; ?>   </td> 
									<? 
									        $all_month_total[$fees_type]['Fees']=$all_month_total[$fees_type]['Fees']+$fees_amount;
											$all_month_total[$fees_type]['Waived']=$all_month_total[$fees_type]['Waived']+$waived_off_amount;
											$all_month_total[$fees_type]['Payble']=$all_month_total[$fees_type]['Payble']+$payble;
											$all_month_total[$fees_type]['Paid']=$all_month_total[$fees_type]['Paid']+$paid_amount;
											$all_month_total[$fees_type]['Due']=$all_month_total[$fees_type]['Due']+$due_amount;
									
									
									
									} 
									
									#-------- total calculation ------------ #
									$total_fees_amount=$fees_amount_array[$ym]['total_fees_amount'];
									$total_unpaid_due=$unpaid_due_amount_array[$ym]['total_unpaid_due'];
									$total_waived_off=$waived_off_amount_array[$ym]['total_waived_off'];
									$total_installment_due=$installment_due_amount_array[$ym]['total_installment_due'];
									$total_unbilled_waived_amount=$unbilled_waived_off_amount_array[$ym]['total_unbilled_waived_amount'];
									
									
									     
											 	
									
									$total_payble_amount =  $total_fees_amount -$total_waived_off;									
									$total_due_amount=$total_unpaid_due  +  $total_installment_due  ;									
									$total_paid_amount=  $total_payble_amount -$total_due_amount;
									
									
									
									
									
									
									        if($total_fees_amount==0){$total_fees_amount='';}
											if($total_waived_off==0){$total_waived_off='';}
											if($total_payble_amount==0){$total_payble_amount='';}
											if($total_paid_amount==0){$total_paid_amount='';}
											if($total_due_amount==0){$total_due_amount='';}
									 
									?>
						<?  if($fees_type_s==''){?>
						<td ><? echo $total_fees_amount; ?>   </td> 
						<td ><? echo $total_waived_off; ?>   </td>
						<td > <b> <? echo $total_payble_amount; ?> </b> </td> 
						<td ><? echo $total_paid_amount; ?> </td> 
						<td > <? echo $total_due_amount; ?> </td>
							
							 <? } ?>
						 
				 </tr>
                          <?
						   $columntotal_total_fees_amount +=$total_fees_amount;
						   $columntotal_total_waived_off +=$total_waived_off;
						   $columntotal_total_payble_amount +=$total_payble_amount;
						   $columntotal_total_paid_amount +=$total_paid_amount;
						   $columntotal_total_due_amount +=$total_due_amount;
						  
						   } ?>  
						   
						   
						   <tr class="borderTitle" >
									<td > </td>
									<td > </td>  
									<td > </td>  
									
									 <? foreach($fees_type_array as $fees_type ){ ?> 
									 
									  
									<td ><? echo  $all_month_total[$fees_type]['Fees']; ?> </td> 
									<td ><? echo  $all_month_total[$fees_type]['Waived']; ?> </td> 
									<td > <? echo  $all_month_total[$fees_type]['Payble']; ?> </td> 
									<td >  <? echo  $all_month_total[$fees_type]['Paid']; ?></td> 
									<td > <? echo  $all_month_total[$fees_type]['Due']; ?> </td> 
									<? } ?>
									<?  if($fees_type_s==''){?>
									<td > <b><? echo $columntotal_total_fees_amount; ?>  </b> </td> 
									<td > <b><? echo $columntotal_total_waived_off; ?>  </b>  </td>
									<td > <b> <? echo $columntotal_total_payble_amount; ?> </b> </td> 
									<td > <b><? echo $columntotal_total_paid_amount; ?> </b> </td> 
									<td > <b> <? echo $columntotal_total_due_amount; ?> </b> </td>
									 <? } ?>
						    </tr>
						  
						  
		</table> 
		
		 
	 
		
		
		
		
		</div>

<style>
.noBorder td{ padding:0px 2px 0px 5px; border-right:1px solid #999999;}
</style>

<?  
$tally=$os->post('tally');
if($tally=='ok'){  ?>
	 
	<div id="tally programme">
<?  


	#++++++++++++++++++++++++++++++++++++ TALLY PROGRAMME +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	#	



#----------- calculation on status paid  fees ----------------#	
			
			 
			
			$feesQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fs.totalPayble) fees_amount 	
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'  and  fs.paymentStatus = 'paid' 
			$and_branch_code_s   $and_class_id_s $and_fees_type_s  
			group by fs.month,fs.year,fs.feesType
			";
					 
			$status_paid_array=array();
			 
			// $fees_type_array=array();		
			$resource=$os->mq($feesQuery);
			while($record=$os->mfa( $resource))
			{ 	
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month;			
				$fees_type_array[$feesType]=$feesType;
				$status_paid_array[$ym][$feesType]['fees']=$record['fees_amount'];
				$status_paid_array[$ym][$feesType]['waived']=0;
				$status_paid_array[$ym][$feesType]['payble']=$record['fees_amount'];
				$status_paid_array[$ym][$feesType]['paid']=$record['fees_amount'];
				$status_paid_array[$ym][$feesType]['due']=0;
				 
				 
				 
				
			}
			
			#----------- calculation on status paid  wavedoff ----------------#	
			$listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fw.waive_amount) waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'   and  fs.paymentStatus = 'paid'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType 
			";
				 
		 
			 
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 				
				
				$status_paid_array[$ym][$feesType]['waived']=$record['waived_amount'];
				$status_paid_array[$ym][$feesType]['payble']=  $status_paid_array[$ym][$feesType]['fees'] - $record['waived_amount'];
				$status_paid_array[$ym][$feesType]['paid']=  $status_paid_array[$ym][$feesType]['payble'] - 0;	
				
				
				
								 			
				//$status_paid_array[$ym]['total_waived_off']=$status_paid_amount_array[$ym]['total_waived_off']+$record['waived_amount'];
				
			}
			
			 
			#----------- calculation on status unpaid  fees ----------------#	
			
			 
			
			$feesQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fs.totalPayble) fees_amount 	
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'  and  fs.paymentStatus = 'unpaid' 
			$and_branch_code_s   $and_class_id_s $and_fees_type_s  
			group by fs.month,fs.year,fs.feesType
			";
					 
			$status_unpaid_array=array();
			 
			 	
			$resource=$os->mq($feesQuery);
			while($record=$os->mfa( $resource))
			{ 	
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month;			
				$fees_type_array[$feesType]=$feesType;
				$status_unpaid_array[$ym][$feesType]['fees']=$record['fees_amount'];
				$status_unpaid_array[$ym][$feesType]['waived']=0;
				$status_unpaid_array[$ym][$feesType]['payble']=$record['fees_amount'];
				$status_unpaid_array[$ym][$feesType]['paid']=0;
				$status_unpaid_array[$ym][$feesType]['due']=$record['fees_amount'];
				
				
			//	$status_unpaid_array[$ym]['total_fees_amount']=$status_unpaid_array[$ym]['total_fees_amount']+$record['fees_amount'];
				 
				
			}
			
			
			#----------- calculation on status unpaid  wavedoff ----------------#	
			$listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fw.waive_amount) waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'   and  fs.paymentStatus = 'unpaid'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType 
			";
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 				
				
				$status_unpaid_array[$ym][$feesType]['waived']= $record['waived_amount'];				
				$status_unpaid_array[$ym][$feesType]['payble']= $status_unpaid_array[$ym][$feesType]['fees'] - $record['waived_amount'];
				$status_unpaid_array[$ym][$feesType]['due']=    $status_unpaid_array[$ym][$feesType]['payble'] - 0;		 			
				
				
				//$status_unpaid_array[$ym]['total_waived_off']=$status_unpaid_array[$ym]['total_waived_off']+$record['waived_amount'];
				
			}
			
			
			
			#----------- calculation on status installment  fees ----------------#	
			
			 
			
			$feesQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fs.totalPayble) fees_amount 	
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'  and  fs.paymentStatus = 'installment' 
			$and_branch_code_s   $and_class_id_s $and_fees_type_s  
			group by fs.month,fs.year,fs.feesType
			";
					 
			$status_installment_array=array();
			 
			 	
			$resource=$os->mq($feesQuery);
			while($record=$os->mfa( $resource))
			{ 	
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month;			
				$fees_type_array[$feesType]=$feesType;
				$status_installment_array[$ym][$feesType]['fees']=$record['fees_amount'];
				$status_installment_array[$ym][$feesType]['waived']=0;
				$status_installment_array[$ym][$feesType]['payble']=$record['fees_amount'];
				$status_installment_array[$ym][$feesType]['paid']=0;
				$status_installment_array[$ym][$feesType]['due']=$record['fees_amount'];
				
				
			//	$status_installment_array[$ym]['total_fees_amount']=$status_installment_array[$ym]['total_fees_amount']+$record['fees_amount'];
				 
				
			}
			
			 
			
			#----------- calculation on status installment  wavedoff ----------------#	
			$listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fw.waive_amount) waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'   and  fs.paymentStatus = 'installment'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType 
			";
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 				
				
				$status_installment_array[$ym][$feesType]['waived']= $record['waived_amount'];				
				$status_installment_array[$ym][$feesType]['payble']= $status_installment_array[$ym][$feesType]['fees'] - $record['waived_amount'];				
				$status_installment_array[$ym][$feesType]['due']=    $status_installment_array[$ym][$feesType]['payble'] - 0;								
				
				//$status_installment_array[$ym]['total_waived_off']=$status_installment_array[$ym]['total_waived_off']+$record['waived_amount'];
				
			}
			
			#----------- calculation on status installment  unbilled wavedoff ----------------#	
			 $listingQuery=" SELECT  fs.month,fs.year,fs.feesType, sum(fw.waive_amount) unbilled_waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where fs.dated >= '$start_date' and  fs.dated <= '$end_date'  and  fs.paymentStatus = 'installment'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s  and fees_payment_id<1
			group by fs.month,fs.year,fs.feesType 
			";
				 
		 
			$unbilled_waived_off_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 				
				
				$unbilled_waived_off_amount_array[$ym][$feesType]=$record['unbilled_waived_amount'];				 			
				$unbilled_waived_off_amount_array[$ym]['total_unbilled_waived_amount']=$unbilled_waived_off_amount_array[$ym]['total_unbilled_waived_amount']+$record['unbilled_waived_amount'];
				
			}
			
			
			
			#----------- calculation on status installment  due ----------------#	
			
			$listingQuery=" SELECT  fs.month,fs.year,fs.feesType,fs.fees_student_id	, sum(fp.currentDueAmount) installment_due  				  
			from  fees_student  fs 
			
			inner join fees_payment fp   on fp.due_on_fees_student_id=fs.fees_student_id	
			left join history h on fs.historyId=h.historyId		   
			where fs.dated >= '$start_date' and  fs.dated <= '$end_date'   and  fs.paymentStatus='installment'
			
			
			$and_branch_code_s   $and_class_id_s $and_fees_type_s and fp.historyId=fs.historyId 
			AND fp.fees_payment_id = (
                Select Max(fp2.fees_payment_id)
                From fees_payment As fp2
                Where fp.due_on_fees_student_id = fp2.due_on_fees_student_id
                )	  	
			group by fs.month,fs.year,fs.feesType 
			";
				  
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				 
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 
								$unpaid_due=		$record['installment_due']  -	$unbilled_waived_off_amount_array[$ym][$feesType];
		$status_installment_array[$ym][$feesType]['due']=    $unpaid_due;
		$status_installment_array[$ym][$feesType]['paid']=    $status_installment_array[$ym][$feesType]['payble']-$unpaid_due;						 			
		
		//$status_installment_array[$ym]['total_installment_due']=$status_installment_array[$ym]['installment_due']+$unpaid_due;
				
			}
			
			  
				 						  
		 
			
			
			?>
			<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="display:block;"  >

<tr   >
									<td colspan="30" align="center" ><h3>FEES REPORT </h3>
<? if($branch_code_s){?>	<h4> <? echo $branch_code_arr[$branch_code_s]; ?> </h4> <?  } ?>
<? if($class_id_s){?> Class :  <? echo $os->classList[$class_id_s]; ?> <br /> <?  } else { ?>  <? } ?>
  From  
<? if($from_month_s){?> <? echo $os->feesMonth[(int)$from_month_s]; ?> <?  } ?> 
<? if($from_year_s){?> <? echo $os->feesYear[$from_year_s]; ?> <?  } ?>
&nbsp; To
<? if($to_month_s){?> <? echo $os->feesMonth[(int)$to_month_s]; ?> <?  } ?> 
<? if($to_year_s){?> <? echo $os->feesYear[$to_year_s]; ?> <?  } ?> </td>
									 
						    </tr>


							<tr class="borderTitle" >
							
							        <td colspan="3" style="font-size:16px; font-weight:bold; text-align:center; background-color:#FFFFFF;" > </td>
									  
									
									<? foreach($fees_type_array as $fees_type ){ ?> 
									<td colspan="5" style="font-size:16px; font-weight:bold; text-align:center; background-color:#FFFFFF;"><? echo $fees_type; ?> </td> 
									 
									<? } ?>
									
									<?  if($fees_type_s==''){?>
									
									<td colspan="5" style="font-size:16px; font-weight:bold;text-align:center;background-color:#FFFFFF;">Total </td> 
								  
									 
									<? } ?>
									</tr>	
									
									<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Month </b></td>  
									<td ><b>Year </b></td>  
									
									 <? foreach($fees_type_array as $fees_type ){ ?> 
									<td ><b> Fees </b> </td> 
									<td ><b> Waived </b> </td> 
									<td ><b> Payble </b> </td> 
									<td ><b>Paid </b> </td> 
									<td ><b>Due </b> </td> 
									<? } ?>
									
									<?  if($fees_type_s==''){?>
									
									<td ><b>Total Fees </b></td> 
									<td ><b>Total waived </b></td>
									<td ><b>Total Payble</b></td>
									<td ><b>Total Paid</b> </td>
									<td ><b>Total Due</b> </td>
									 <? } ?>
						    </tr>
							<?php
							
							 $columntotal_total_fees_amount  =0;	
							 $columntotal_total_waived_off =0;
						   $columntotal_total_payble_amount =0;
						   $columntotal_total_paid_amount =0;
						   $columntotal_total_due_amount =0;
							
							
						 $serial=0;
						 $all_month_total=array();
							 foreach( $Search_months  as $ym){ 
								 $serial++; 
								 $year=substr($ym,0,4);
								 $month=substr($ym,4,2);
								 
								 
								 $total_fees_amount =0;									 
									$total_waived_off =0;									 
									$total_payble_amount =0;																
									$total_paid_amount =0;	
									$total_due_amount  =0;		
							 
							?> 
							<tr class="trListing" >
							<td><?php echo $serial;?>  </td>
							<td> <?php echo $os->feesMonth[(int)$month];?>    </td>
							<td>   <?php echo $year;?>  </td>
							
									<? 
									$i=0;
									
									
									
									foreach($fees_type_array as $fees_type )
									    { 
									     $i++;
										   $color_column="background-color:#FFFFCC;";
										   if($i%2==0){ $color_column="background-color:#F2F2F2;";  }
										   $color_column='';
										 
											 
 										
									$fees_amount=$status_paid_array[$ym][$fees_type]['fees'] + 
													  $status_unpaid_array[$ym][$fees_type]['fees']+
													  $status_installment_array[$ym][$fees_type]['fees'] ;
													  
									$waived_off_amount=$status_paid_array[$ym][$fees_type]['waived'] + 
													  $status_unpaid_array[$ym][$fees_type]['waived']+
													  $status_installment_array[$ym][$fees_type]['waived'] ;
													  
													  
									$payble=$status_paid_array[$ym][$fees_type]['payble'] + 
													  $status_unpaid_array[$ym][$fees_type]['payble']+
													  $status_installment_array[$ym][$fees_type]['payble'] ;				  
									
									 $paid_amount=$status_paid_array[$ym][$fees_type]['paid'] + 
													  $status_unpaid_array[$ym][$fees_type]['paid']+
													  $status_installment_array[$ym][$fees_type]['paid'] ;
									
														  
									 $due_amount=$status_paid_array[$ym][$fees_type]['due'] + 
													  $status_unpaid_array[$ym][$fees_type]['due']+
													  $status_installment_array[$ym][$fees_type]['due'] ;
													  
													
											if($fees_amount==0){$fees_amount='';}
											if($waived_off_amount==0){$waived_off_amount='';}
											if($paid_amount==0){$paid_amount='';}
											if($due_amount==0){$due_amount='';}
											if($payble==0){$payble='';}
											 
											
											 	 	 	 	 
											
											
											
											?> 
											<td  style=" <? echo $color_column; ?> "><? echo $fees_amount; ?>   </td> 
											<td  style=" <? echo $color_column; ?> ">  <? echo $waived_off_amount; ?>  </td> 
											<td style=" <? echo $color_column; ?> ">  <? echo $payble; ?>   </td> 
											<td style=" <? echo $color_column; ?> ">  <? echo $paid_amount; ?>   </td> 
											<td style=" border-right: 2px solid #000000; <? echo $color_column; ?> ">  <? echo $due_amount; ?>   </td> 
									<? 
									        $all_month_total[$fees_type]['Fees']=$all_month_total[$fees_type]['Fees']+$fees_amount;
											$all_month_total[$fees_type]['Waived']=$all_month_total[$fees_type]['Waived']+$waived_off_amount;
											$all_month_total[$fees_type]['Payble']=$all_month_total[$fees_type]['Payble']+$payble;
											$all_month_total[$fees_type]['Paid']=$all_month_total[$fees_type]['Paid']+$paid_amount;
											$all_month_total[$fees_type]['Due']=$all_month_total[$fees_type]['Due']+$due_amount;
									
									
									
									
									
									
									#-------- total calculation - horizontal----------- #
									$total_fees_amount +=$fees_amount;									 
									$total_waived_off +=$waived_off_amount;									 
									$total_payble_amount +=$payble;																
									$total_paid_amount +=$paid_amount;	
									$total_due_amount +=$due_amount;	
									
									} 
									
									
									
									
									     
											 	
									
									
									
									
									
									
									
									
									        if($total_fees_amount==0){$total_fees_amount='';}
											if($total_waived_off==0){$total_waived_off='';}
											if($total_payble_amount==0){$total_payble_amount='';}
											if($total_paid_amount==0){$total_paid_amount='';}
											if($total_due_amount==0){$total_due_amount='';}
									 
									?>
						<?  if($fees_type_s==''){?>
						<td ><? echo $total_fees_amount; ?>   </td> 
						<td ><? echo $total_waived_off; ?>   </td>
						<td > <b> <? echo $total_payble_amount; ?> </b> </td> 
						<td ><? echo $total_paid_amount; ?> </td> 
						<td > <? echo $total_due_amount; ?> </td>
							
							 <? } ?>
						 
				 </tr>
                          <?
						   $columntotal_total_fees_amount +=$total_fees_amount;
						   $columntotal_total_waived_off +=$total_waived_off;
						   $columntotal_total_payble_amount +=$total_payble_amount;
						   $columntotal_total_paid_amount +=$total_paid_amount;
						   $columntotal_total_due_amount +=$total_due_amount;
						  
						   } ?>  
						   
						   
						   <tr class="borderTitle" >
									<td > </td>
									<td > </td>  
									<td > </td>  
									
									 <? foreach($fees_type_array as $fees_type ){ ?> 
									 
									  
									<td ><? echo  $all_month_total[$fees_type]['Fees']; ?> </td> 
									<td ><? echo  $all_month_total[$fees_type]['Waived']; ?> </td> 
									<td > <? echo  $all_month_total[$fees_type]['Payble']; ?> </td> 
									<td >  <? echo  $all_month_total[$fees_type]['Paid']; ?></td> 
									<td > <? echo  $all_month_total[$fees_type]['Due']; ?> </td> 
									<? } ?>
									<?  if($fees_type_s==''){?>
									<td > <b><? echo $columntotal_total_fees_amount; ?>  </b> </td> 
									<td > <b><? echo $columntotal_total_waived_off; ?>  </b>  </td>
									<td > <b> <? echo $columntotal_total_payble_amount; ?> </b> </td> 
									<td > <b><? echo $columntotal_total_paid_amount; ?> </b> </td> 
									<td > <b> <? echo $columntotal_total_due_amount; ?> </b> </td>
									 <? } ?>
						    </tr>
						  
						  
		</table>
		</div>	
			<? 
			
	}		  
			
			 
			
	#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	#	






 	
	exit(); 
}
 