<? 
session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?><?


if($os->get('WT_attendanceDetailsListing')=='OK'){
	error_reporting(0);
	$andasession=  $os->postAndQuery('asession','att.asession','=');
	$andclass=  $os->postAndQuery('class','att.class','=');
	$andstudentId=  $os->postAndQuery('studentId','att.studentId','=');


	$f_Date_s= '01-'.$os->post('month').'-'.$os->post('year'); $t_Date_s= '31-'.$os->post('month').'-'.$os->post('year');;
	$and_dated=$os->DateQ('att.dated',$f_Date_s,$t_Date_s,$sTime='00:00:00',$eTime='23:59:59');

	$all_school_days_q="SELECT DISTINCT dated
	FROM attendance as att
	where att.attendanceId >0  $andclass $andasession $and_dated and absent_present='P'
	";
	$all_school_days_mq=$os->mq($all_school_days_q);
	while($all_school_days_data=$os->mfa($all_school_days_mq)){
		$all_school_days_a[]=$os->showDate($all_school_days_data['dated']);
	}
	$listingQuery="
	SELECT DISTINCT att.dated,att.class,att.asession,att.roll_no,att.studentId,att.absent_present,stu.name as stName 
	FROM attendance as att
	INNER JOIN student as stu
	ON att.studentId=stu.studentId
	where att.attendanceId >0 $andasession $andclass $andstudentId $and_dated
	order by att.dated";
	$listing_mq=$os->mq($listingQuery);
	while($listing_data=$os->mfa($listing_mq)){
		$listing_data_a[$os->showDate($listing_data['dated'])]=$listing_data;
	}

	?>
	<div class="listingRecords">
		<table  border="0" cellspacing="0" cellpadding="0" class="uk-table uk-table-divider"  >
			<tr class="trListing">
				<td colspan="10" style="background-color:#006595; color:#FFFFFF;"> <b> Attendance  For <? echo  $os->feesMonth[(int)$os->post('month')] ?> <? echo $os->post('year') ?>  </b> </td>
			</tr>
			<tr class="borderTitle" >
				<td >#</td>
				<td ><b>Session</b></td>  
				<td ><b>Class</b></td> 
				<td ><b>Date</b></td> 
									<!-- <td ><b>Name</b></td>
										<td ><b>Roll No</b></td> -->
										<td ><b>Absent Present</b></td>
									</tr>
									<?php
									$serial=$os->val($resource,'serial');  
									foreach ($all_school_days_a as  $value) {
										$serial++;
										if($listing_data_a[$value]['absent_present']=='P'){
											$style="style='color:green'";
											$absent_present='P';
										}
										else{
											$style="style='color:red'";	
											$absent_present='A';
										}
										?>
										<tr class="trListing">
											<td><?php echo $serial; ?>     </td>
											<td> <?  echo  $os->post('asession');?></td> 
											<td><?php echo $os->post('class')?> </td>
											<td><?php echo $value;?> </td>
									<!-- <td><?php //echo $record['stName']?></td>
										<td><?php //echo $record['roll_no']; ?></td>  -->
										<td <?echo $style;?> ><?php echo $absent_present?> </td>
									</tr>
									<?}?>  
								</table> 
							</div>
							<br />			
							<?php exit();}?>

