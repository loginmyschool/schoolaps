<?
session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?><?

if($os->get('subscription_structure_Listing')=='OK'){
	$where='';
	$andasession=  $os->postAndQuery('asession_s','sub_str.asession','=');
	$andclass=  $os->postAndQuery('class_s','sub_str.classId','=');
	echo $listingQuery="select sub_str.classId,sub_str.asession,sub_str.online_class,sub_str.offline_class,sub_str.online_exam,sub_str.offline_exam,sub.subjectName,sub.subjectId as sub_id from subscription_structure sub_str
	inner join subject sub on sub_str.subjectId=sub.subjectId
	where subscription_structure_id>0 and active_status='active'  $andasession $andclass order by classId asc";
	$subscription_mq=$os->mq($listingQuery);	
	$asession_val=$os->post('asession_s');
	$subscription_date_a=$os->subscription_date($asession_val);
	$subscription_from_date_a=$subscription_date_a['from_date'];
	$subscription_to_date_a=$subscription_date_a['to_date'];
	?>
	<div class="listingRecords">
		<table   class="uk-table uk-table-divider"  >
			<thead>
				<tr >
					<th ><b>#</td>
						<th ><b>Class </b></th>
						<th ><b>Session</b></th> 
						<th ><b>Subject</b></th>
						<th ><b>Online class</b></th>
						<th ><b>Online Exam</b></th>
						<th><b>Add Subscription</b></th>
					</tr>
				</thead>

				<?php 
				$serial=0;               
				while($record=$os->mfa($subscription_mq)){
					$serial++;
					?>
					<tbody>
						<tr>
							<td><?php echo $serial;?></td>
							<td><?php echo $os->classList[$record['classId']]; ?></td>
							<td><?php echo $record['asession']; ?></td>
							<td><?php echo $record['subjectName']; ?></td>
							<td><?php echo $record['online_class']?>
							<td><?php echo $record['online_exam']?></td>
							<td class="uk-text-bold"><a href="javascript:void(0)" style="text-decoration: none; color:blue" onclick="window.location.href='<?echo $site['url']?>subscription';">Subscribe Now</a></td>

						</tr>
					</tbody>
				<? } 
				echo $serial==0? "<tbody><tr ><td colspan='10' class='uk-text-bold uk-text-danger'>Sorry! No data found.</td></tr></tbody>":'';
				?>                      
			</table>

		</div>
		<br />					
		<?php exit();}
