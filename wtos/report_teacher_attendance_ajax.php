<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
if($os->get('WT_teacherAttendanceListing')=='OK'){
		
		$andasession=  $os->postAndQuery('asession_s','teaAtt.asession','=');
		$totalDaysQ="SELECT COUNT(DISTINCT dated) as totalDays 
					FROM teacherattendance as teaAtt
					where teaAtt.teacherattendanceId >0 $andasession
					";
		$totalDaysMq=$os->mq($totalDaysQ);
		$totalDaysA=$os->mfa($totalDaysMq);
		$totalDays=$totalDaysA['totalDays'];		

		$listingQuery="SELECT COUNT(DISTINCT dated) as totalPresentDays
					  ,teaAtt.teacherId,teaAtt.asession,tea.name as tName 
					  FROM teacherattendance as teaAtt
		              INNER JOIN teacher as tea
		              ON teaAtt.teacherId=tea.teacherId
		              where teaAtt.teacherattendanceId >0 $andasession and teaAtt.absent_present='P' GROUP BY teaAtt.teacherId";

		$resource=$os->pagingQuery($listingQuery,10000000,false,true);
		$rsRecords=$resource['resource'];
?>
<div class="listingRecords">
				<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Session</b></td> 
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
									<td><?php echo $record['tName']?></td>
									<td><?php echo $totalDays; ?></td> 
									<td><?php echo $record['totalPresentDays']?> </td>
									<td><?echo round($percentage, 2);?></td> 
									<td> 
									<span  class="actionLink" ><a href="javascript:void(0)"  onclick="teacherAttendanceDetails('<? echo $record['teacherId'];?>','<? echo $record['asession'];?>')" >View Details</a></span></td>
				 			</tr>
                          <?}?>  
		</table> 
		</div>
		<br />			
<?php exit();}
 
if($os->get('WT_teacherAttendanceDetailsListing')=='OK'){
		$andasession=  $os->postAndQuery('asession','teaAtt.asession','=');
		$andteacherId=  $os->postAndQuery('teacherId','teaAtt.teacherId','=');
		$listingQuery="
						SELECT DISTINCT teaAtt.dated,teaAtt.asession,teaAtt.teacherId,teaAtt.absent_present,tea.name as tName 
						FROM teacherattendance as teaAtt
						INNER JOIN teacher as tea
						ON teaAtt.teacherId=tea.teacherId
						where teaAtt.teacherattendanceId >0 $andasession  $andteacherId
						order by teaAtt.dated";
		$resource=$os->pagingQuery($listingQuery,10000000,false,true);
		$rsRecords=$resource['resource'];
?>
<div class="listingRecords">
				<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
									<td >#</td>
									<td ><b>Session</b></td>  
									<td ><b>Date</b></td> 
									<td ><b>Name</b></td>
									<td ><b>Present or Absent</b></td>
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
									<td><?php echo $os->showDate($record['dated']);?> </td>
									<td><?php echo $record['tName']?></td> 
									<td <?echo $style;?>><?php echo $record['absent_present']?> </td>
				 			</tr>
                          <?}?>  
		</table> 
		</div>
		<br />			
<?php exit();}?>

