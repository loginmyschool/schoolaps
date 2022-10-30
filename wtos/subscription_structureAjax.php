<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName); 
?><?

if($os->get('WT_subscription_structureGetById')=='OK'){
	$subscription_structure_id=$os->post('subscription_structure_id');
	if($subscription_structure_id>0)	{
		$wheres=" where subscription_structure_id='$subscription_structure_id'";
	}
	$dataQuery=" select * from subscription_structure  $wheres ";
	$rsResults=$os->mq($dataQuery);
	$record=$os->mfa( $rsResults);
	$record['discount_form_date']=$os->showDate($record['discount_form_date']); 
	$record['discount_to_date']=$os->showDate($record['discount_to_date']); 
	echo  json_encode($record);	 
	exit();
}

if($os->get('WT_subscription_structure_EditAndSave')=='OK'){
	$subscription_structure_id=$os->post('subscription_structure_id');
	$dataToSave['classId']=addslashes($os->post('classId')); 
	$dataToSave['asession']=addslashes($os->post('asession')); 
	$dataToSave['title']=addslashes($os->post('title')); 
	
	$dataToSave['has_online_class']=($os->post('has_online_class')==1)?1:0;
	$dataToSave['has_online_exam']=($os->post('has_online_exam')==1)?1:0;
	$dataToSave['is_full_package']=($os->post('is_full_package')==1)?1:0;
	$dataToSave['is_exam_only']=($os->post('is_exam_only')==1)?1:0;


	$dataToSave['online_class']=addslashes($os->post('online_class')>0?$os->post('online_class'):0); 
	$dataToSave['online_exam']=addslashes($os->post('online_exam')>0?$os->post('online_exam'):0);
	$dataToSave['full_package_amt']=addslashes($dataToSave['online_class']+$dataToSave['online_exam']); 
	$dataToSave['full_package_discount']=addslashes($os->post('full_package_discount')); 
	$dataToSave['online_exam_discount']=addslashes($os->post('online_exam_discount')); 
	$discount_form_date_a=explode('-',$os->post('discount_form_date'));
	$dataToSave['discount_form_date']=$os->saveDate($discount_form_date_a[2].'-'.$discount_form_date_a[1].'-'.$discount_form_date_a[0]);
	$discount_to_date_a=explode('-',$os->post('discount_to_date'));
	$dataToSave['discount_to_date']=$os->saveDate($discount_to_date_a[2].'-'.$discount_to_date_a[1].'-'.$discount_to_date_a[0]);
	$dataToSave['discount_text']=addslashes($os->post('discount_text'));	
	$dataToSave['modifyDate']=$os->now();
	$dataToSave['modifyBy']=$os->userDetails['adminId']; 
	if($subscription_structure_id < 1){
		$dataToSave['active_status']='active'; 
		$dataToSave['is_featured']='No'; 
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
	}
	$qResult=$os->save('subscription_structure',$dataToSave,'subscription_structure_id',$subscription_structure_id);
	if($qResult)  {
		if($subscription_structure_id>0 ){ $mgs= " Data updated Successfully";}
		if($subscription_structure_id<1 ){ $mgs= " Data Added Successfully"; $subscription_structure_id=  $qResult;}
		$mgs=$subscription_structure_id."#-#".$mgs;
	}
	else{
		$mgs="Error#-#Problem Saving Data.";
	}
	echo $mgs;		
	exit();
} 

if($os->get('subscription_structure_Listing')=='OK'){
	$where='';
	$andasession=  $os->postAndQuery('asession_s','asession','=');
	$andclass=  $os->postAndQuery('class_s','classId','=');

	$andactive_status=  $os->postAndQuery('active_status','active_status','=');
	$andis_featured=  $os->postAndQuery('is_featured','is_featured','=');

	$listingQuery="select * from  subscription_structure 	
	where subscription_structure_id>0 $andasession $andclass $andactive_status $andis_featured order by classId";
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];

	?>
	<div class="listingRecords">
		<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
		<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
			<tr class="borderTitle" >
				<td >#</td>
				<td>Action</td>
				<td >Title</td>

				<td >Class</td>
				<td >Session</td> 
				<td >Online class</td>
				<td >Online Exam</td>
				<td>Full Package Amt</td>	
				<td >Full Package Discount</td>	
				<td >Online Exam Discount</td>	
				<td class="uk-hidden"><b>Discount Form Date</b></td>	
				<td class="uk-hidden"><b>Discount To Date</b></td>	
				<td class="uk-hidden"><b>Discount Text</td>		
					<td>Status</td>						  
					<td>Is Featured</td>						  


				</tr>						
				<?php 
				$serial=0;  			 
				while($record=$os->mfa($rsRecords)){ 
					$serial++;
					?>
					<tr class="trListing">

						<td><?php echo $serial;?></td>
						<td class="uk-text-nowrap">
							<? if($os->access('wtView')){ ?>							
								<span uk-tooltip="title:Edit; delay: 100">
									<a class="uk-text-primary" href="javascript:void(0)"  onclick="WT_subscription_structureGetById('<? echo $record['subscription_structure_id'];?>');os.setAsCurrentRecords(this);"  uk-icon="icon: file-edit"></a>
								</span>

								<? } ?>&nbsp;&nbsp;
								<span uk-tooltip="title:Delete; delay: 100">
									<a class="uk-text-danger" href="javascript:void(0)" onclick="WT_bookingDeleteRowById('<? echo $record['subscription_structure_id'];?>');" uk-icon="icon: trash"></a>
								</span>&nbsp;&nbsp;
							</td>
							<td><b><?php echo $record['title']; ?></b> </td>

							<td><b><?php echo $os->classList[$record['classId']]; ?></b> </td>
							<td><b><?php echo $record['asession']; ?></b> </td>

							<td><?php echo $record['online_class']>0?$record['online_class']:'0';?></td>
							

							<td><input type="checkbox"  name="is_exam_only" <?php echo $record['is_exam_only']==1?'checked':'';?>>&nbsp;&nbsp;<?php echo $record['online_exam']>0?$record['online_exam']:'0';?></td>


							<td><input type="checkbox"  name="is_full_package"  <?php echo $record['is_full_package']==1?'checked':'';?>>&nbsp;&nbsp;<?=$record['full_package_amt']>0?$record['full_package_amt']:0?></td>
							<td ><?=$record['full_package_discount']?></td>
							<td ><?=$record['online_exam_discount']?></td>
							<td class="uk-hidden"><?=$os->showDate($record['discount_form_date'])?></td>
							<td class="uk-hidden"><?=$os->showDate($record['discount_to_date'])?></td>
							<td class="uk-hidden"><?=$record['discount_text']?></td>
							<td><?if($record['online_class']>0||$record['online_exam']>0){?><? $os->editSelect($os->activeStatus,$record['active_status']?$record['active_status']:'inactive','subscription_structure','active_status','subscription_structure_id',$record['subscription_structure_id'], $inputNameID='editSelect',$extraParams='class="editSelect" ',$os->activeStatuseColor) ?><?}?></td>


							<td ><?if($record['online_class']>0||$record['online_exam']>0){?><? $os->editSelect($os->yesno,$record['is_featured']?$record['is_featured']:'No','subscription_structure','is_featured','subscription_structure_id',$record['subscription_structure_id'], $inputNameID='editSelect',$extraParams='class="editSelect" ',$os->yesnoColor) ?><?}?></td>


						</tr>
					<? } ?>  					 
				</table>
			</div>
			<br />					
			<?php exit();}
			if($os->get('WT_bookingDeleteRowById')=='OK'){ 
				$subscription_structure_id=$os->post('subscription_structure_id');
				if($subscription_structure_id>0){
					$updateQuery="delete from subscription_structure where subscription_structure_id='$subscription_structure_id'";
					$os->mq($updateQuery);
					echo 'Record Deleted Successfully';
				}
				exit();
			}