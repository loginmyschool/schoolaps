<?

session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?><?

if($os->get('get_form_status')=='OK'){	
	$dob_a=explode('-',$os->post('dob'));
	$from_date=$dob_a[2].'-'.$dob_a[1].'-'.$dob_a[0];
	$and_dob=$os->DateQ('dob',$from_date,$from_date,$sTime='00:00:00',$eTime='23:59:59');
	$listingQuery="select * from formfillup where formfillup_id>0 and class_id='".$os->post("class_id")."' and year='".$os->post("year")."' and mobile_student='".str_replace(' ', '', $os->post("mobile_student"))."' $and_dob";
	$listingMq=$os->mq($listingQuery);
	?>
	<div class="listingRecords">
		<table   class="uk-table uk-table-divider"  >
			<thead>
				<tr >
					<th ><b>#</td>
						<th class="uk-text-nowrap"><b>Name</b></th> 
						<th class="uk-text-nowrap"><b>Mobile No</b></th>
						<th class="uk-text-nowrap"><b>Form Type </b></th>
						<th class="uk-text-nowrap"><b>Class</b></th>							
						<th class="uk-text-nowrap"><b>Year</b></th>
						<th class="uk-text-nowrap"><b>Father Name</b></th>
						<th class="uk-text-nowrap"><b>Payment Status</b></th>
						<th class="uk-text-nowrap"><b>Form Status</b></th>						  
					</tr>
				</thead>
				<?php 
				$serial=0;  			 
				while($record=$os->mfa($listingMq)){ 
					$serial++;
					?>
					<tbody>
						<tr>
							<td class="uk-text-nowrap"><?php echo $serial;?></td>
							<td class="uk-text-nowrap"><?php echo $record['name']; ?></td>
							<td class="uk-text-nowrap"><?php echo $record['mobile_student']; ?></td>
							<td class="uk-text-nowrap"><?php echo $record['form_for']; ?></td>
							<td class="uk-text-nowrap"><?php echo $os->classList[$record['class_id']]; ?></td>
							<td class="uk-text-nowrap"><?php echo $record['year']; ?></td>	
							<td class="uk-text-nowrap"><?php echo $record['father_name']; ?></td>
							<td class="uk-text-nowrap"><?php echo $record['payment_status']; ?></td>	
							<td class="uk-text-nowrap"><?php echo $record['form_status']; ?></td>
						</tr>
					</tbody>
					<? }if($serial=='0'){echo '<tbody>
					<tr><td class="uk-text-nowrap" colspan="8" style="color:red;font-weight:bold">Sorry ! No data found.</td></tr></tbody>';} ?>  					 
				</table>
			</div>
			<br />					
			<?php exit();}

