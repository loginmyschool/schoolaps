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
	$follow_up_date_s=trim($os->post('follow_up_date_s'));
	$action=trim($os->post('action'));
	//_d($action);
	
	
	
	
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
	  
		  	$listingQuery=" SELECT  fs.month,fs.year,fs.feesType,fs.historyId, sum(fs.totalPayble) fees_amount  	 		  
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType,fs.historyId  
			
			";	 
		 
			$fees_amount_array=array();			 
			$fees_type_array=array();		
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month;	
				$historyId=$record['historyId'];
				
				$fees_type_array[$feesType][$ym]=$ym;
				
				$fees_amount_array[$historyId][$feesType][$ym]=$record['fees_amount'];
				
			}
			 
	    //  _d($fees_amount_array);
		#--------------------------------------------------------------# 
		
		//  student -- list  ---
		   $student_list=array();
			$historyId_in=" SELECT   fs.historyId    		  
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType,fs.historyId  
			
			";	 
			
			$listingQuery_st="  select hh.historyId ,ss.name ,  ss.name , ss.registerNo   ,  ss.mobile_student  ,  hh.class
					FROM history hh 
					INNER JOIN student ss on(ss.studentId = hh.studentId)					
					where  hh.historyId in ($historyId_in)
					";
		    $student_list_rs=$os->mq($listingQuery_st);	
			while($row = $os->mfa($student_list_rs))
			{
			
			   $student_list[$row['historyId']]=$row;
			}	
					
		 
		
		/// student -- list  ---
		
		
		
		#----------------------- waived off Fees  calculation ---------------------------------------#
	  
		 	 $listingQuery=" SELECT  fs.month,fs.year,fs.feesType,fs.historyId  , sum(fw.waive_amount) waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'   
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType ,fs.historyId  
			";
				 
		 
			$waived_off_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month;
				$historyId=$record['historyId']; 				
				
				$waived_off_amount_array[$historyId][$feesType][$ym]=$record['waived_amount'];				 			
				 
				
			}
			
			  
		#--------------------------------------------------------------# 
		 #-----------------------unbilled waived off Fees  calculation ---------------------------------------#
	  
		 	 $listingQuery=" SELECT  fs.month,fs.year,fs.feesType,fs.historyId, sum(fw.waive_amount) unbilled_waived_amount  				  
			from   fees_waiveoff  fw			
			left join history h on fw.history_id=h.historyId		
			left join fees_student  fs on fw.fees_student_id=fs.fees_student_id		   
			where fs.dated >= '$start_date' and  fs.dated <= '$end_date'  
			$and_branch_code_s   $and_class_id_s $and_fees_type_s  and fees_payment_id<1
			group by fs.month,fs.year,fs.feesType,fs.historyId
			";
				 
		 
			$unbilled_waived_off_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 
				$historyId=$record['historyId'];				
				
				$unbilled_waived_off_amount_array[$historyId][$feesType][$ym]=$record['unbilled_waived_amount'];				 			
				 
			}
			
		#--------------------------------------------------------------# 
		
		 #----------------------- unpaid due Fees  calculation ---------------------------------------#
	  
		 	$listingQuery=" SELECT  fs.month,fs.year,fs.feesType,fs.historyId, sum(fs.totalPayble) unpaid_due  				  
			from   fees_student  fs
			left join history h on fs.historyId=h.historyId		   
			where  fs.dated >= '$start_date' and  fs.dated <= '$end_date'     and  fs.paymentStatus='unpaid'
			$and_branch_code_s   $and_class_id_s $and_fees_type_s
			group by fs.month,fs.year,fs.feesType,fs.historyId
			";
				 
		 
			$unpaid_due_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				 $feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 	
				$historyId=$record['historyId'];
				
				$unpaid_due=		$record['unpaid_due'] -	$unbilled_waived_off_amount_array[$historyId][$feesType][$ym];
				
				$unpaid_due_amount_array[$historyId][$feesType][$ym]=$unpaid_due;		
				
						 			
				 
				
			}
			
			
			  
		#--------------------------------------------------------------# 
		
		
		
		
		#----------------------- installment due Fees  calculation ---------------------------------------#	  
	 		$listingQuery=" SELECT  fs.month,fs.year,fs.feesType,fs.historyId, sum(fp.currentDueAmount) installment_due  				  
			from  fees_payment fp 
			
			left join  fees_student  fs on fp.due_on_fees_student_id=fs.fees_student_id	
			left join history h on fs.historyId=h.historyId		   
			where fs.dated >= '$start_date' and  fs.dated <= '$end_date'   and  fs.paymentStatus='installment'
			$and_branch_code_s   $and_class_id_s $and_fees_type_s and fp.historyId=fs.historyId	AND fp.fees_payment_id = (
                Select Max(fp2.fees_payment_id)
                From fees_payment As fp2
                Where fp.due_on_fees_student_id = fp2.due_on_fees_student_id
                )	 
			group by fs.month,fs.year,fs.feesType,fs.historyId order by fs.classId desc 
			";
				  
		 
			$installment_due_amount_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
				
				$feesType=$record['feesType'];
				$month=str_pad($record['month'], 2, "0", STR_PAD_LEFT);
				$ym=$record['year']. $month; 
				$historyId=$record['historyId'];					
				
				$installment_due=		$record['installment_due'] -	$unbilled_waived_off_amount_array[$historyId][$feesType][$ym];
				
				$installment_due_amount_array[$historyId][$feesType][$ym]=$installment_due;
						 			
				 
				
			}
			 
			  
		#--------------------------------------------------------------# 
		
		#----------------------- Latest follow up ---------------------------------------#	  
		
			$and_follow_up_date_s=" ";
			 
			if($follow_up_date_s!='')
			{ 
				$follow_up_date_s_e =$follow_up_date_s.' 23:59:59';
				$follow_up_date_s_s =$follow_up_date_s.' 00:00:00';
				$and_follow_up_date_s=" and sf.follow_date >=  '$follow_up_date_s_s'  and  sf.follow_date <=  '$follow_up_date_s_e'   "; 
				
				 if($action=='Todays and Past Followup')
				 {
				 
				    $and_follow_up_date_s="   and  sf.follow_date <=  '$follow_up_date_s_e'   "; 
				 }
				
			}
	
	
	
	 		$listingQuery=" SELECT  sf.*			  
			from  student_followup sf 		
			left join student s on s.mobile_student=sf.mobile_no		   
			where 
			sf.student_followup_id = (
                Select Max(sf2.student_followup_id)
                From student_followup As sf2
                Where sf2.mobile_no = sf.mobile_no
                )	 
				
				and sf.history_id in ($historyId_in)
				$and_follow_up_date_s
				 
			group by  sf.mobile_no 
			";
				  // hh.historyId in ($historyId_in)
		 
			$latest_followup_array=array();
			 
			$resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 	
			
			 
			
			 /* if($record['close_by_admin_id']>0){
			  
			  }*/
				
				 $latest_followup_array[$record['mobile_no']]=$os->showDate($record['follow_date']).'<br>'.$record['view_note'];
				 
				 //_d($record);
						 			
				 
				
			}
			 
			 // _d( $latest_followup_array);
			 
	
	 
			 
			 
		#--------------------calculate due------------------------------------------# 
		
		$result_data=array(); 
	   	foreach($fees_amount_array  as $historyId=>$fees_amount_list){ 
	
			    $waived_off_amount_list =	$waived_off_amount_array[$historyId];
				$unbilled_waived_off_amount_list =	$unbilled_waived_off_amount_array[$historyId];
				$unpaid_due_amount_list =	$unpaid_due_amount_array[$historyId];
				$installment_due_amount_list =	$installment_due_amount_array[$historyId];
	   
			
			$row_due_total=0;
			foreach($fees_type_array  as $feesType =>$feesMonths_array){
			asort($feesMonths_array);
			
									foreach($feesMonths_array as $yearMonth)									
									{
									
									#---------- fees calculation------#
									        $fees_amount=$fees_amount_list[$feesType][$yearMonth];
											$waived_off_amount=$waived_off_amount_list[$feesType][$yearMonth];																					
											$unpaid_due_amount=$unpaid_due_amount_list[$feesType][$yearMonth];										
											$installment_due_amount=$installment_due_amount_list[$feesType][$yearMonth];										
											$unbilled_waived_amount=$unbilled_waived_off_amount_list[$feesType][$yearMonth]	;	 // not need in this location adede in query loop								
											
											$payble=  $fees_amount -$waived_off_amount;																						
											$due_amount=  $unpaid_due_amount  + $installment_due_amount  ; 	
											$paid_amount=  $payble -$due_amount;	
									#---------- fees calculation------#		
									$row_due_total=$row_due_total+$due_amount;
									 
									 
					                }
						
						       if($row_due_total>0)
							   {
							      $result_data[$historyId]=$row_due_total;
							   }
						   
						 
						 
			              }			  
					
				
		} 
		
		
		 
		
?>


	
<div class="listingRecords" > 


 
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="background-color:#FFFFFF;" >

						<tr>
								<td colspan="50" align="center" >
								
								<h3>DUE FEES REPORT </h3> 
								<? if($branch_code_s){?>	<h4> <? echo $branch_code_arr[$branch_code_s]; ?> </h4> <?  } ?> 
								<? if($class_id_s){?>  Class :  <? echo $os->classList[$class_id_s]; ?>  <br /> <?  } else { ?>  <? } ?>
								From  
								<? if($from_month_s){?> <? echo $os->feesMonth[(int)$from_month_s]; ?> <?  } ?> 
								<? if($from_year_s){?> <? echo $os->feesYear[$from_year_s]; ?> <?  } ?>
								&nbsp; To
								<? if($to_month_s){?> <? echo $os->feesMonth[(int)$to_month_s]; ?> <?  } ?> 
								<? if($to_year_s){?> <? echo $os->feesYear[$to_year_s]; ?> <?  } ?> 
								<?  if($follow_up_date_s!=''){?><br />  Followup Date  <? if($action=='Todays and Past Followup'){ ?>  Up To  <? }  ?> : <? echo $follow_up_date_s; ?>  
								
								            
								 <? } ?>
								
								
								</td>
						</tr>
						
						 
							<?   ob_start(); ?>		 
								
								<tr style="background-color:#939393;">
								 <td >	 #	</td>								
								 <td >	 <b>Student</b></td>				
								 <td >	<b>Class</b></td>	
								  <td >	<b>Follow Up</b></td>					  
								
								         								
											
											  
											   						
											
											  
										<? foreach($fees_type_array  as $feesType =>$feesMonths_array){ 
										 
										?>
										 <td style="text-align:center;"   <?  if($feesType=='Monthly') {?>  colspan="<? echo count($feesMonths_array); ?>" <? } ?>  >										
										  <b>  <? echo $feesType ?></b>
										</td>
										<? } ?>
							
							            <td >	 <b> Total Due	</b>	</td>							
											
											  
							
							</tr>		
						
								
								
								
							
								
								
								<tr style="background-color:#939393;" >	
								
								             <td >	 </td>	
											 <td >	 </td>	
											 <td >	 </td>	
											  <td >	 </td>									
											
											 
								
								
								<? foreach($fees_type_array  as $feesType =>$feesMonths_array){ 
								asort($feesMonths_array);
								
								?>
										   <?  if($feesType=='Monthly') 
										     { foreach($feesMonths_array as $yearMonth){
											  $year=substr($yearMonth,0,4);
								               $month=substr($yearMonth,4,2);
											 
											 ?> 
										       <td >										
										  <b>   <?php echo substr($os->feesMonth[(int)$month],0,3);?>  <br /> <? echo $year ?> </b>
										      </td>
											<? } }else{ ?>
											<td >										
										    
										      </td>
											<? } ?>
										
										<? } ?>
										
										 <td >	  	</td>	
										
								</tr>	
								
							<? $heading_row= ob_get_contents(); ?>	
								
	<? 
	$kk=0;
	$col_total_of_row_due_total=0;
	foreach($fees_amount_array  as $historyId=>$fees_amount_list){ 
	
	$mobile_no_student= $student_list[$historyId]['mobile_student'];
	 
	   if(!isset($result_data[$historyId])){ continue;} /// filer zero due
	  
	   if($follow_up_date_s!=''){
	   if(!isset($latest_followup_array[$mobile_no_student])){ continue;} // show only selected date
	   }
	   
	   
	   
	   
	   
	   
	   
	
	
			    $waived_off_amount_list =	$waived_off_amount_array[$historyId];
				$unbilled_waived_off_amount_list =	$unbilled_waived_off_amount_array[$historyId];
				$unpaid_due_amount_list =	$unpaid_due_amount_array[$historyId];
				$installment_due_amount_list =	$installment_due_amount_array[$historyId];
	 $kk++;
	 
	 
	 if($kk%12==0)
	 {
	  echo $heading_row;
	 
	 }
	 
	 
	 //---- ----------- calculation  ------- ------- ----
	 
	 
	 
	 
	
	 
	?>
	
	
	
	
	<tr  >
	<td title="" ><? echo  $kk; ?></td>
	<td title="Hid<? echo  $historyId; ?>" >			
	<b><? echo  $student_list[$historyId]['name']; ?>  </b>
	<br />
	 <? echo  $student_list[$historyId]['registerNo']; ?> 
	<br />
	 <? echo  $student_list[$historyId]['mobile_student']; ?> 
	 	 
	</td>	
	<td>
	<? echo  $os->classList[$student_list[$historyId]['class']]; ?>
	</td>
	<td>
	<div id="followup_div_id_<? echo $historyId; ?>" onclick="manage_followup('<? echo $historyId; ?>','')" style="cursor:pointer; color:#0000CC;">
	<? if( $latest_followup_array[$mobile_no_student]){ ?> 
	
	<?  echo $latest_followup_array[$mobile_no_student];?>
	
	<? } else {?>
	 Follow-up
	<? } ?>
	</div>
	
	  
	</td>
					
			<? 
			
			$row_due_total=0;
			foreach($fees_type_array  as $feesType =>$feesMonths_array){
			asort($feesMonths_array);
			
			 ?>
					   <?  if($feesType=='Monthly') 
						 { 
									foreach($feesMonths_array as $yearMonth){
									
									#---------- fees calculation------#
									        $fees_amount=$fees_amount_list[$feesType][$yearMonth];
											$waived_off_amount=$waived_off_amount_list[$feesType][$yearMonth];																					
											$unpaid_due_amount=$unpaid_due_amount_list[$feesType][$yearMonth];										
											$installment_due_amount=$installment_due_amount_list[$feesType][$yearMonth];										
											$unbilled_waived_amount=$unbilled_waived_off_amount_list[$feesType][$yearMonth]	;	 // not need in this location adede in query loop								
											
											$payble=  $fees_amount -$waived_off_amount;																						
											$due_amount=  $unpaid_due_amount  + $installment_due_amount  ; 	
											$paid_amount=  $payble -$due_amount;	
									#---------- fees calculation------#		
									$row_due_total=$row_due_total+$due_amount;
									
									if($due_amount==0){$due_amount='';}
									
								
									
									?> 
									<td  <? if($waived_off_amount>0){ ?>  title="waived: <? echo $waived_off_amount; ?>" <?  } ?>>										
									
									<b style="font-size:14px;"> <? echo $due_amount ?> </b><br />
									<i class="italic"    >	  <? echo   $fees_amount_list[$feesType][$yearMonth]; ?> </i>
									</td>
						<? }
						
						 }else{ 
						 
						  
						 $amount_array['due']=array();
						 foreach($feesMonths_array as $yearMonth)
						 {
									
									#---------- fees calculation------#
									        $fees_amount=$fees_amount_list[$feesType][$yearMonth];
											$waived_off_amount=$waived_off_amount_list[$feesType][$yearMonth];																					
											$unpaid_due_amount=$unpaid_due_amount_list[$feesType][$yearMonth];										
											$installment_due_amount=$installment_due_amount_list[$feesType][$yearMonth];										
											$unbilled_waived_amount=$unbilled_waived_off_amount_list[$feesType][$yearMonth]	;	 // not need in this location adede in query loop								
											
											$payble=  $fees_amount -$waived_off_amount;																						
											$due_amount=  $unpaid_due_amount  + $installment_due_amount  ; 	
											$paid_amount=  $payble -$due_amount;	
									#---------- fees calculation------#		
									$row_due_total=$row_due_total+$due_amount;
						 
						     $amount_array['due'][$feesType][$yearMonth]=$due_amount;
						  }
						 
						  ?>
								<td <? if(is_array($waived_off_amount_list[$feesType])){ ?> title="Waived :<? echo  implode(',',$waived_off_amount_list[$feesType]); ?>"   <? } ?> >
								
						<b style="font-size:14px;"><? if(is_array($amount_array['due'][$feesType])){ 
						  $amount_array['due'][$feesType]=   array_filter($amount_array['due'][$feesType]);
						
						?>  <? echo  implode(',',$amount_array['due'][$feesType]); ?> <? } ?></b>
						
						<br />						
						<? if(is_array($fees_amount_list[$feesType])){ ?> <i  class="italic"><? echo  implode(',',$fees_amount_list[$feesType]); ?></i><? } ?> 
								</td>
						<? } ?>
					
					<? } ?>
	
	<td align="right" ><b style="font-size:16px; text-align:right;"> <? echo $row_due_total; ?>	 </b></td>
	
	<tr>	
	<?
	$col_total_of_row_due_total= $col_total_of_row_due_total + $row_due_total;
	
	 } ?>					 
		<tr>
		<td colspan="30" align="right"><b style="font-size:16px; text-align:right;"><? echo $col_total_of_row_due_total; ?></b>	  </td>
		</tr>							
								 
						  
		</table> 
		
		 
	 
		
		
		
		
		</div>

  
   
 

<style>
.noBorder td{ padding:0px 2px 0px 5px; border-right:1px solid #999999;}
</style>
	 
	
<?   	
	exit(); 
}
 
 
if($os->get('manage_followup')=='OK')
{
    
	$list_admin=$os->get_admins($branch_code = "", $type = "");
		 
    $history_id=$os->post("history_id");
	$follow_date=$os->post("follow_date");
	$remarks=$os->post("remarks");
	$view_note=$os->post("view_note");
	 
	$action=$os->post("action");
	
	
	//_d($os->post());
	 
	//$student_data= $os->rowByField('','student_followup',$fld='fees_student_id',$fees_student_id,$where=" and historyId='$historyId' and paymentStatus='unpaid' ",$orderby='');
	$history_data=$os->rowByField('','history','historyId',$history_id);
	$student_id=$history_data['studentId'];	
	$student_data=$os->rowByField('','student','studentId',$student_id);	 
	$mobile_student=$student_data['mobile_student'];
	
	 
			
			
	
	if($action=='save' && $mobile_student!='')
	{
		 
		 		 	 	 	 	 	 		  
		 
		$data_to_save=array();
        $data_to_save['history_id']=$history_id;
        $data_to_save['follow_date']=$follow_date;
        $data_to_save['remarks']=$remarks;
        $data_to_save['entry_date']=$os->now();
        $data_to_save['by_admin_id']=$os->userDetails['adminId'];
        $data_to_save['view_note']=$view_note;
        $data_to_save['mobile_no']=$mobile_student;
        $student_followup_id=$os->save('student_followup',$data_to_save);
	 
         if($remarks!='' || $view_note!=''){
		  update_edit_history($student_followup_id,$remarks,$view_note);
		  }
	}
	
	 echo '##--followup_history_modal_html--##';
	 ?>
	 <div style=" padding:5px 2px 10px 0px">  
	 <? if(trim($mobile_student)!=''){ ?>
	 <h3> <? echo $mobile_student; ?> </h3>
	 <table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="background-color:#FFFFFF;" >
	 
	 <tr>
				<td>Reg No</td>
				<td>Name</td>
				<td>Class</td>
				<td>Session</td>
				<td>Father</td>
				<td>Other NO</td>
				<td>Branch</td>
				</tr>	 
	 <? 
	 
	 
	 
	 
			$listingQuery="  select h.asession,h.registrationNo,h.class,h.section,h.branch_code,h.section,s.name ,s.father_name ,s.mobile_student_alternet  
			FROM history h 
			INNER JOIN student s on(s.studentId = h.studentId)
			WHERE h.historyId>0 and  s.mobile_student='$mobile_student' 
			
			 and h.asession = (
			
			 Select Max(h2.asession)
                From history h2 
                Where h2.historyId = h.historyId
                )	
			group by s.studentId
			 ";
	  
	  
	  
	
	       $resource=$os->mq($listingQuery);
			while($record=$os->mfa( $resource))
			{ 
			
			    
			?>	 
				<tr>
				<td><?php  echo $record['registrationNo'];?></td>
				<td><?php  echo $record['name'];?></td>
				<td><?php  echo $os->classList[$record['class']];?></td>
				<td><?php  echo $record['asession'];?></td>
				<td><?php  echo $record['father_name'];?></td>
				<td><?php  echo $record['mobile_student_alternet'];?></td>
				<td><?php  echo $branch_code_arr[$record['branch_code']];?></td>
				</tr>	 
			<? 
			
			}
	 
	 ?>
	  </table>
	 
	 <? } else { ?>
	 <div style="color:#FF0000"> Missing Mobile NO . Please Update mobile NO.</div>
	 <? } ?>
	 </div>
	 
	  <div style="height:10px;"> </div>
	  <form  id="student_followup_history_form"> 
	 <table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="background-color:#FFFFFF;" >


      
		 <tr> 
		 <td><input type="text" name="follow_date" value="<? echo  date('Y-m-d'); ?>"  placeholder="yyyy-mm-dd" class="wtDateClass--" /> <!--class="wtDateClass"--> </td>
		 <td><input type="text" name="remarks" list="remarks_list"  />
				<datalist id="remarks_list">
						<option value="Call not received">
						<option value="Busy">
						<option value="Out of reach">
						<option value="Call after some time">
						<option value="Call next week">
						<option value="Will pay soon">
						 
				</datalist>
		 
		 
		  </td>
		 <td><input type="text" name="view_note" list="view_list"  /> 
		 
		   <datalist id="view_list">
						<option value="Not connected">
						<option value="Busy">
					    <option value="Call at 5 pm ">
						<option value="Call Received">
						 
				</datalist>
		 
		  </td>
		  <td colspan="10"><input style="cursor:pointer;" type="button" value="Create New Followup" onclick="manage_followup(<? echo $history_id ?>,'save') " />  
		  
		  &nbsp; <input style="cursor:pointer;" type="button" value="Reset" onclick="manage_followup(<? echo $history_id ?>,'') " />  
		 </td>
		  
		 </tr>

        <tr> 
		 <td><b>Followup Date</b>  </td>
		 <td><b>Remarks</b>  </td>
		 <td><b>view Note</b> </td>
		 <td><b>Mobile No </b></td>
		 <td><b>Action </b></td>
		 <td><b>Entry Date </td>
		 <td><b>Entry By</b> </td>
		 <td><b>Close Date </td>
		 <td><b>Close By</b> </td>
		 <td><b>Edit History</b> </td>
		 
		 </tr>
		 
		
		 
		  <? 
	 
	 
	 
	 
		 	$listingQuery="  select sf.* 
			FROM student_followup sf 
			 
			WHERE   sf.mobile_no='$mobile_student'  
			order by  student_followup_id desc
			 ";
	  
	  
	  
	
	       $resource=$os->mq($listingQuery);
		   $k=0;
		   $view_msg='Follow-up';
			while($record=$os->mfa( $resource))
			{ 
			 $k++;
			 $student_followup_id=$record['student_followup_id'];
			
			    if($k==1)
				{
				  $date=$os->showDate($record['follow_date'],'Y-m-d');
				   $view_msg=$date.'<br>'.$record['view_note'];
				}
			?>	 
				<tr>
				<td><?php  echo $os->showDate($record['follow_date'],'Y-m-d');?></td>
				<td> <? if($record['close_by_admin_id']<1){ ?> 
				
				 <input type="text" list="remarks_list"  onkeypress="hide_show_follow_buttons('<?php  echo $student_followup_id;?>')"  onchange="hide_show_follow_buttons('<?php  echo $student_followup_id;?>')" 
				 value="<?php  echo $record['remarks'];?>" name="update_followup_fld[<?php  echo $student_followup_id;?>][remarks]" />
				
				 <? } else{ ?> 
				<?php  echo $record['remarks'];?> 
				<? } ?> </td>
				<td> 
				
				<? if($record['close_by_admin_id']<1){ ?>
				    <input type="text"  list="view_list" onkeypress="hide_show_follow_buttons('<?php  echo $student_followup_id;?>')" onchange="hide_show_follow_buttons('<?php  echo $student_followup_id;?>')" 
					value="<?php  echo $record['view_note'];?>" name="update_followup_fld[<?php  echo $student_followup_id;?>][view_note]" />
				 
				 
				 <? } else{ ?> <?php  echo $record['view_note'];?> <? } ?>  </td>
				
				<td><?php  echo $record['mobile_no'];?></td>
				<td> 
				<? if($record['close_by_admin_id']<1){ ?>
		<input style="cursor:pointer; display:none; background-color:#0000FF; color:#FFFFFF;" id="followup_update_button_id_<?php  echo $student_followup_id;?>" 
		type="button" value="Save" onclick="update_close_followup('<? echo $history_id ?>','<? echo $student_followup_id ?>','update_followup');" /> 
		<input style="cursor:pointer; background-color:#FF3300;color:#FFFFFF;" type="button" id="followup_close_button_id_<?php  echo $student_followup_id;?>" 
		value="Close" onclick="update_close_followup('<? echo $history_id ?>','<? echo $student_followup_id ?>','close_followup');" /> 
				<? }else{ ?>
				   Close
				<? } ?>
				</td>
				
				<td><?php  echo $os->showDate($record['entry_date'],'Y-m-d');?></td>
				<td><?php  echo $list_admin[$record['by_admin_id']]['name'];?></td>
				
				<td><?php  echo $os->showDate($record['close_date'],'Y-m-d');?></td>
				<td><?php  echo $list_admin[$record['close_by_admin_id']]['name'];?></td>
				 
				<td><?php // echo $record['edit_history'];?>
				
				<?  
				  $edit_history_array=array();
				 if( $record['edit_history']!='')
				 {
				     $edit_history_array=unserialize($record['edit_history']);
				 }
				 
				  if(is_array($edit_history_array))
				  {
				   krsort(  $edit_history_array);
				   foreach($edit_history_array as $timestamp=>$data)
				   {
				     ?>
					 <div style="padding:2px; background-color:#EAFBFB; border:1px solid #BBDDFF; margin:2px; font-size:10px;">
					         <?php  echo $list_admin[$data['edit_by']]['name'];?> [ <?php  echo $os->showDate($data['dated']);?>] <br />
							  <?php  echo $data['remarks'];?><br />
							  <?php  echo $data['view_note'];?>
					 </div>
					 <? 
				   
				   }
				  
				  }
				 
				 
				 ?>
				
				</td>
				 
				</tr>	 
			<? 
			}
	 
	 ?>
		 
		 
		 
	</table>
	
	 </form>	
	  
	 
	 <?    
	 
	 echo '##--followup_history_modal_html--##'; 
	echo '##--followup_history_html--##'; echo   $view_msg; echo '##--followup_history_html--##'; 
	
	 echo '##--historyId--##'; echo  $history_id; echo '##--historyId--##'; 
  exit();
}

 
if($os->get('update_close_followup')=='OK')
{
    	 
    $history_id=$os->post("history_id");
	$student_followup_id=$os->post("student_followup_id");
	$action=$os->post("action");
	$update_followup_fld=$os->post("update_followup_fld");
	 
			
	
	if($action=='update_followup' && $student_followup_id>0 )
	{
		 
		 	$remarks=trim(addslashes( 	$update_followup_fld[$student_followup_id]['remarks'] ));	 	
			$view_note=trim(addslashes( 	$update_followup_fld[$student_followup_id]['view_note'] ));	 	
			
			  	 	 		  
		 
		$data_to_save=array();        
        $data_to_save['remarks']=$remarks;       
        $data_to_save['view_note']=$view_note;       
        $output=$os->save('student_followup',$data_to_save,'student_followup_id',$student_followup_id);
		 
	    update_edit_history($student_followup_id,$remarks,$view_note);
		 
	 
						 
				       
		 
	     
	
	
	}
	
	if($action=='close_followup' && $student_followup_id>0 )
	{
		 
		 	 
		 
		$data_to_save=array();        
        $data_to_save['close_by_admin_id']=$os->userDetails['adminId'];
        $data_to_save['close_date']=$os->now();   
        $output=$os->save('student_followup',$data_to_save,'student_followup_id',$student_followup_id);
		 
	}
	
	
	
		
	
	 echo '##--historyId--##'; echo  $history_id; echo '##--historyId--##'; 
  exit();
}


 function  update_edit_history($student_followup_id,$remarks,$view_note)
		 {
		   global $os;
		 
					$s_followup_history=$os->rowByField('','student_followup','student_followup_id',$student_followup_id);
					
					$edit_history=$s_followup_history['edit_history'];
					$edit_history_array=array();
					if( $edit_history!='')
					{
					$edit_history_array=unserialize($edit_history);
					}
					
					$time_key=date('YmdHis');
					$edit_history_array[$time_key]['remarks']=$remarks;
					$edit_history_array[$time_key]['view_note']=$view_note;
					$edit_history_array[$time_key]['edit_by']=$os->userDetails['adminId'];
					$edit_history_array[$time_key]['dated']=date('Y-m-d H:i:s');
					$data_to_save=array();           
					$data_to_save['edit_history']=serialize($edit_history_array);
					$output=$os->save('student_followup',$data_to_save,'student_followup_id',$student_followup_id);
					 
					
			}		
					