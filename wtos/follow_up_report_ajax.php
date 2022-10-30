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


if($os->get('follow_up_report')=='OK' && $os->post('follow_up_report')=='OK')
{
   
   echo '##--followup_report_div_id_data--##';	
   
   
   
	$class_id_s=$os->post('classList_s');
    $branch_code_s=$os->post('branch_code_s');
	 
	$follow_up_date_from_s=trim($os->post('follow_up_date_from_s'));
	$follow_up_date_to_s=trim($os->post('follow_up_date_to_s'));
	
	if($follow_up_date_from_s==''){ $follow_up_date_from_s = date('Y-m-d');}
	if($follow_up_date_to_s==''){ $follow_up_date_to_s = date('Y-m-d');}
	
	
	$action=trim($os->post('action'));
	
	 
	
	
	if($os->userDetails['adminType']!='Super Admin' &&  $branch_code_s =='')
    {

        echo "Please select Branch";
        exit();

    }
	
	
	
	 
	 
	 if($branch_code_s!=''){ $and_branch_code_s=" and  h.branch_code='$branch_code_s'"; }
	 
	$and_class_id_s='';
	if($class_id_s!=''){ $and_class_id_s=" and  h.class='$class_id_s'"; }
	
	 
	   
	
		
		#------------------- date preparation--------------------#
		    $start_date=$from_year_s.'-'.$from_month_s.'-'.'01 00:00:00';
			$end_date=$to_year_s.'-'.$to_month_s.'-'.'31 23:59:59';
		
		  
			 
		
		#----------------------- Latest follow up ---------------------------------------#	  
		
			 
				$follow_up_date_from_s_f = $follow_up_date_from_s.' 00:00:00';
				$follow_up_date_to_s_f =$follow_up_date_to_s.' 23:59:59';
				
				$and_follow_up_date_s=" and sf.follow_date >=  '$follow_up_date_from_s_f'  and  sf.follow_date <=  '$follow_up_date_to_s_f'   "; 
				
			 
	
	
	
	     	  $listingQuery=" SELECT  sf.* , s.name student_name ,	s.registerNo , h.asession, h.class ,a.name admin_name		  
			from  student_followup sf 		
			left join student s on s.mobile_student=sf.mobile_no	
			left join history h on sf.history_id=h.historyId	
			left join admin a on sf.close_by_admin_id=a.adminId
					   
			where sf.mobile_no!='' 
			and sf.student_followup_id = (
                Select Max(sf2.student_followup_id)
                From student_followup As sf2
                Where sf2.mobile_no = sf.mobile_no
                )	 
			
				$and_follow_up_date_s
				 $and_class_id_s
			 
			";
				   
		 
			  
		
	 
		
		
		 
	
   
 
 
			$latest_followup_array=array();
			 
			$resource=$os->mq($listingQuery);
			
			 
 
 
  ?>

	
<div class="listingRecords" > 


 
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="background-color:#FFFFFF;" >

						<tr>
								<td colspan="50" align="center" >
								
								<h3>FOLLOW-UP REPORT  </h3> 
								<? if($branch_code_s){?>	<h4> <? echo $branch_code_arr[$branch_code_s]; ?> </h4> <?  } ?> 
								<? if($class_id_s){?>  Class :  <? echo $os->classList[$class_id_s]; ?>  <br /> <?  } else { ?>  <? } ?>
								<? if($follow_up_date_from_s){?>  From :  <? echo $follow_up_date_from_s; ?>   <?  } else { ?>  <? } ?>
								<? if($follow_up_date_to_s){?>  To :  <? echo $follow_up_date_to_s; ?>   <?  } else { ?>  <? } ?>
								
								 
								
								
								</td>
						</tr>
						
						 
						 
								
								<tr style="background-color:#FFFFCC;">
								 <td >	 #	</td>								
								 <td >	 <b>REG NO</b></td>				
								 <td >	<b>Student</b></td>	
								  <td >	<b>Mobile</b></td>	
								   <td >	<b>Session</b></td>	
								    <td >	<b>Class</b></td>	
									 <td >	<b>follow date</b></td>	
									  <td >	<b>Remarks</b></td>	
									   <td >	<b>Note</b></td>	
									  <td >	<b>User</b></td>					  
								
							
							</tr>		
						
								
								<? $kk=0;
								while($record=$os->mfa( $resource))
			{ 	$kk++;
			 
			 
			 ?>
							<tr style="background-color:#FFFFFF;">
							<td >	 <? echo $kk; ?>	</td>	
							<td >	  <? echo $record['registerNo']; ?></td>	
							<td >	  <? echo $record['student_name']; ?></td>	
							<td >	  <? echo $record['mobile_no']; ?></td>								
							
							<td >	  <? echo $record['asession']; ?></td>	
							<td >	  <? echo $os->classList[$record['class']]; ?></td>
							<td >	  <? echo $os->showDate($record['follow_date']); ?></td>
							<td >	  <? echo $record['remarks']; ?></td>	
							<td >	  <? echo $record['view_note']; ?></td>		
							<td >	  <? echo $record['admin_name']; ?></td>		
							
					 
							
							</tr>		
			 
			 <? 
			 
				 
				
			}
								
								
								 ?>
								
			   
	
	 				 
		 	 
						  
		</table> 
		
		 
	 
		
		
		
		
		</div>

  
  
 

<style>
.noBorder td{ padding:0px 2px 0px 5px; border-right:1px solid #999999;}
</style>
 <?   
 echo '##--followup_report_div_id_data--##';	 ?>	 
	
<?   

echo '##--follow_up_search_form_data--##';		
?>


 

         <div class="uk-inline uk-margin-small-left" uk-tooltip="">
		<select name="branch_code_s" id="branch_code_s"
            class="select2--" style="z-index:1;background-color:#FFFFFF;">
            <option value="">All Branch</option>
            <? $os->onlyOption($branch_code_arr,$branch_code_s);	?>
        </select>
		
		 </div>
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="Class">
                <span class="uk-form-icon" uk-icon="icon: user; ratio:0.7"></span>
                <select name="classList_s" id="classList_s" class="uk-select uk-border-rounded uk-form-small p-left-xxxl">
                    <option value="">Class</option>
                    <? $os->onlyOption($os->classList,$class_id_s);	?>
                </select>
            </div>
		 <div class="uk-inline uk-margin-small-left" uk-tooltip="">
		  From Follow Up Date:
		  <input type="text" placeholder="yyyy-mm-dd"  style="width:85px;background-color:#FFFFFF;" name="follow_up_date_from_s" id="follow_up_date_from_s" value="<? echo $follow_up_date_from_s ?>" />
		   To Follow Up Date:
		  <input type="text" placeholder="yyyy-mm-dd"  style="width:85px;background-color:#FFFFFF;" name="follow_up_date_to_s" id="follow_up_date_to_s" value="<? echo $follow_up_date_to_s ?>" />
		 
		
		 </div>
		 
		  
            <div class="uk-float-right uk-margin-small-right">
 
            </div>

<?  echo '##--follow_up_search_form_data--##'; ?>

<? 	
	exit(); 
}
 
  