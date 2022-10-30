<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
if($os->get('WT_attendanceListing')=='OK'){
		
		$andasession=  $os->postAndQuery('asession_s','att.asession','=');
		$andclass=  $os->postAndQuery('class_s','att.class','=');
		$totalDaysQ="SELECT COUNT(DISTINCT dated) as totalDays 
					FROM attendance as att
					where att.attendanceId >0 $andasession $andclass
					";
		$totalDaysMq=$os->mq($totalDaysQ);
		$totalDaysA=$os->mfa($totalDaysMq);
		$totalDays=$totalDaysA['totalDays'];		

		$listingQuery="SELECT COUNT(DISTINCT dated) as totalPresentDays
					  ,att.studentId,att.asession,att.class,stu.name as stName 
					  FROM attendance as att 
		              INNER JOIN student as stu
		              ON att.studentId=stu.studentId
		              where att.attendanceId >0 $andasession $andclass and att.absent_present='P' GROUP BY att.studentId";

		$resource=$os->pagingQuery($listingQuery,10000000,false,true);
		$rsRecords=$resource['resource'];
?>
<div class="listingRecords">
				<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Session</b></td>  
									<td ><b>Class</b></td> 
									<td ><b>Name</b></td>
									<td ><b>Total Class</b></td>  
									<td ><b>Present</b></td> 
									<td ><b>%</b></td> 
									<td></td>
						    </tr>
							<?php
						  	 $serial=$os->val($resource,'serial');  
							 while($record=$os->mfa( $rsRecords)){ 
							    	$serial++;
							    	$percentage=0;	
							    	$percentage=(($record['totalPresentDays']*100)/$totalDays);
							?>
							<tr class="trListing">
									<td><?php echo $serial; ?>     </td>
									<td> <?  echo  $record['asession'];?></td> 
									<td><?php echo $record['class']?> </td>
									<td><?php echo $record['stName']?></td>
									<td><?php echo $totalDays; ?></td> 
									<td><?php echo $record['totalPresentDays']?> </td>
									<td><?echo round($percentage, 2);?></td> 
									<td> 
									<span  class="actionLink" ><a href="javascript:void(0)"  onclick="attendanceDetails('<? echo $record['studentId'];?>','<? echo $record['class'];?>','<? echo $record['asession'];?>')" >View Details</a></span></td>
				 			</tr>
                          <?}?>  
		</table> 
		</div>
		<br />			
<?php exit();}
 
if($os->get('WT_attendanceDetailsListing')=='OK'){
		$andasession=  $os->postAndQuery('asession','att.asession','=');
		$andclass=  $os->postAndQuery('class','att.class','=');
		$andstudentId=  $os->postAndQuery('studentId','att.studentId','=');
		$listingQuery="
						SELECT DISTINCT att.dated,att.class,att.asession,att.roll_no,att.studentId,att.absent_present,stu.name as stName 
						FROM attendance as att
						INNER JOIN student as stu
						ON att.studentId=stu.studentId
						where att.attendanceId >0 $andasession $andclass $andstudentId
						order by att.dated";
		$resource=$os->pagingQuery($listingQuery,10000000,false,true);
		$rsRecords=$resource['resource'];
?>
<div class="listingRecords">
				<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Session</b></td>  
									<td ><b>Class</b></td> 
									<td ><b>Date</b></td> 
									<td ><b>Name</b></td>
									<td ><b>Roll No</b></td>
									<td ><b>Absent Present</b></td>
						    </tr>
							<?php
						  	 $serial=$os->val($resource,'serial');  
							 while($record=$os->mfa( $rsRecords)){ 
							    	$serial++;
							    	if($record['absent_present']=='P'){
							    		$style="style='color:green'";
							    	}
							    	else{
							    		$style="style='color:red'";	
							    	}
							?>
							<tr class="trListing">
									<td><?php echo $serial; ?>     </td>
									<td> <?  echo  $record['asession'];?></td> 
									<td><?php echo $record['class']?> </td>
									<td><?php echo $os->showDate($record['dated']);?> </td>
									<td><?php echo $record['stName']?></td>
									<td><?php echo $record['roll_no']; ?></td> 
									<td <?echo $style;?>><?php echo $record['absent_present']?> </td>
				 			</tr>
                          <?}?>  
		</table> 
		</div>
		<br />			
<?php exit();}?>

