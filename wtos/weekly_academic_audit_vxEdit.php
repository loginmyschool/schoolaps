<?
/*
   # wtos version : 1.1
   # List Page : weekly_academic_audit_vxList.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
$editPage='weekly_academic_audit_vxEdit.php';
$listPage='weekly_academic_audit_vxList.php';
$primeryTable='weekly_academic_audit_vx';
$primeryField='weekly_academic_audit_vx_id';
$pageHeader='Add Weekly academic audit V To X';
$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());
$tmpVar='';
$editRowId=$os->get('editRowId');
if($editRowId){
	$pageHeader='Edit  Weekly academic audit V To X';
}


##  update row
if($os->post('operation')){
	if($os->post('operation')=='updateField'){
		$rowId=$os->post('rowId');
	  #---- edit section ----#
		$dataToSave['year']=addslashes($os->post('year')); 
		$dataToSave['month']=addslashes($os->post('month')); 
		$month=str_pad($dataToSave['month'], 2, "0", STR_PAD_LEFT); 
		$dated= $dataToSave['year'].'-'.$month.'-'.'01 00:00:00';
		
		$dataToSave['dated']=$dated; 
		
		//$dataToSave['dated']=$os->saveDate($os->post('dated')); 
		$dataToSave['branch_code']=addslashes($os->post('branch_code')); 		
		$dataToSave['week_no']=addslashes($os->post('week_no')); 
		
		// $dataToSave['number_of_lesson_plan']=addslashes($os->post('number_of_lesson_plan')); 
		$dataToSave['number_of_lesson_plan']=addslashes(json_encode($os->post('number_of_lesson_plan'))); 
		$dataToSave['number_of_class_test']=addslashes(json_encode($os->post('number_of_class_test'))); 		
		$dataToSave['assesment_report_updated']=addslashes($os->post('assesment_report_updated')); 
		$dataToSave['daily_talim']=addslashes($os->post('daily_talim')); 
		$dataToSave['daily_quran_larning']=addslashes($os->post('daily_quran_larning')); 
		$dataToSave['departmental_meeting']=addslashes(json_encode($os->post('departmental_meeting'))); 
		$dataToSave['no_of_foundation_class_for_viii']=addslashes(json_encode($os->post('no_of_foundation_class_for_viii'))); 
		$dataToSave['no_of_foundation_class_for_ix']=addslashes(json_encode($os->post('no_of_foundation_class_for_ix'))); 
		$dataToSave['all_teacher_meeting']=addslashes($os->post('all_teacher_meeting')); 
		$dataToSave['daily_abascus_class']=addslashes($os->post('daily_abascus_class')); 
		$dataToSave['no_of_classes_observed']=addslashes(json_encode($os->post('no_of_classes_observed'))); 
		$dataToSave['manipulatives']=addslashes(json_encode($os->post('manipulatives')));
		if($rowId < 1){			
			$dataToSave['entry_date']=$os->now(); 
			$dataToSave['entry_by_admin_id']=$os->userDetails['adminId']; 
			$dataToSave['addedDate']=$os->now();
			$dataToSave['addedBy']=$os->userDetails['adminId'];
		}		
		$os->saveTable($primeryTable,$dataToSave,$primeryField,$rowId);
		$flashMsg=($rowId)?'Record Updated Successfully':'Record Added Successfully';
		$os->flashMessage($primeryTable,$flashMsg);
		$os->redirect($os->post('redirectLink'));
	  #---- edit section end ----#

	}
	
	
}


$pageData='';
if($editRowId){
	$os->data=$os->rowByField('',$primeryTable,$primeryField,$editRowId);
	$number_of_lesson_plan=json_decode($os->getVal('number_of_lesson_plan'), TRUE);
	$number_of_class_test=json_decode($os->getVal('number_of_class_test'), TRUE);
	$no_of_classes_observed=json_decode($os->getVal('no_of_classes_observed'), TRUE);
	$manipulatives=json_decode($os->getVal('manipulatives'), TRUE);
	$departmental_meeting=json_decode($os->getVal('departmental_meeting'), TRUE);
	$no_of_foundation_class_for_viii=json_decode($os->getVal('no_of_foundation_class_for_viii'), TRUE);
	$no_of_foundation_class_for_ix=json_decode($os->getVal('no_of_foundation_class_for_ix'), TRUE);



}


$os->showFlash($os->flashMessage($primeryTable));





// branch access
$return_acc=$os->branch_access();
$and_branch='';
if($os->userDetails['adminType']!='Super Admin')
	{ $selected_branch_codes=$return_acc['branches_code_str_query'];
$and_branch=" and branch_code IN($selected_branch_codes)";
}
$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))    {
	$branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'];
}
    // branch access end

?>

<div class="title-bar border-color-grey">
	<div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
		<div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
			<h4 class="uk-margin-remove "><?php  echo $pageHeader; ?></h4>
		</div>


	</div>
</div>
<table class="container">
	<tr>

		<td  class="middle" style="padding-left:5px;">


			<div class="formsection">


				<form  action="<? echo $editPageLink ?>" method="post"   enctype="multipart/form-data" id="submitFormDataId">

					<fieldset class="cFielSets"  >
						<legend  class="cLegend">Details</legend>
						
						<div  style="width:1300px; margin:auto;">

							<table   border="0" class="formClass"   >


								<tr >
									<td>Year </td>
									<td>  

										<select name="year" id="year" class="textbox fWidth" ><option value="">Select year</option>	<? 
										$os->onlyOption($os->examYear,$os->getVal('year'));?></select>	 </td>						

										<td>Month </td>
										<td>  

											<select name="month" id="month" class="textbox fWidth" ><option value="">Select month</option>	<? 
											$os->onlyOption($os->rentMonth,$os->getVal('month'));?></select>	 </td>						
										</tr>

										<tr >
											<td>Week no </td>
											<td><input value="<?php echo $os->getVal('week_no') ?>" type="text" name="week_no" id="week_no" class="textbox  fWidth "/> </td>						

											<td>Any Date Of the week </td>
											<td><input value="<?php  echo $os->showDate( $os->getVal('dated'));?>" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr>

										<tr >
											<td>Branch </td>
											<td colspan="10"> <select name="branch_code" id="branch_code select2" class="textbox fWidth"  >
												<option value="">All Branch</option>
												<? $os->onlyOption($branch_code_arr,$os->getVal('branch_code'));	?>
											</select> </td>						
										</tr>



									</table>

									<div class="head_style" >Number of Lesson Plan Checked </div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Language</td>
											<td rowspan="2">EVS</td>
											<td colspan="3">SSC/SC</td>
											<td rowspan="2">Math</td>
											<td colspan="4">SST</td>
											<td rowspan="2">Total</td>
										</tr>
										<tr>
											<td>1st</td>
											<td>2nd</td>
											<td>3rd</td>
											<td>Arabic</td>
											<td>Phy</td>
											<td>Chem</td>
											<td>Bio</td>
											<td>Hist</td>
											<td>Geo</td>
											<td>Civics</td>
											<td>ECO</td>
										</tr>
										<tr>
											<td>V</td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_1st]" value="<?php echo $number_of_lesson_plan['v_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_2nd]" value="<?php echo $number_of_lesson_plan['v_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_3rd]" value="<?php echo $number_of_lesson_plan['v_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_arabic]" value="<?php echo $number_of_lesson_plan['v_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_evs]" value="<?php echo $number_of_lesson_plan['v_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_phy]" value="<?php echo $number_of_lesson_plan['v_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_chem]" value="<?php echo $number_of_lesson_plan['v_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_bio]" value="<?php echo $number_of_lesson_plan['v_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_math]" value="<?php echo $number_of_lesson_plan['v_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_hist]" value="<?php echo $number_of_lesson_plan['v_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_geo]" value="<?php echo $number_of_lesson_plan['v_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_civics]" value="<?php echo $number_of_lesson_plan['v_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_v" name="number_of_lesson_plan[v_eco]" value="<?php echo $number_of_lesson_plan['v_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan_v_total" name="number_of_lesson_plan[v_total]" value="<?php echo $number_of_lesson_plan['v_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VI</td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_1st]" value="<?php echo $number_of_lesson_plan['vi_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_2nd]" value="<?php echo $number_of_lesson_plan['vi_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_3rd]" value="<?php echo $number_of_lesson_plan['vi_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_arabic]" value="<?php echo $number_of_lesson_plan['vi_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_evs]" value="<?php echo $number_of_lesson_plan['vi_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_phy]" value="<?php echo $number_of_lesson_plan['vi_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_chem]" value="<?php echo $number_of_lesson_plan['vi_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_bio]" value="<?php echo $number_of_lesson_plan['vi_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_math]" value="<?php echo $number_of_lesson_plan['vi_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_hist]" value="<?php echo $number_of_lesson_plan['vi_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_geo]" value="<?php echo $number_of_lesson_plan['vi_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_civics]" value="<?php echo $number_of_lesson_plan['vi_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vi" name="number_of_lesson_plan[vi_eco]" value="<?php echo $number_of_lesson_plan['vi_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan_vi_total" name="number_of_lesson_plan[vi_total]" value="<?php echo $number_of_lesson_plan['vi_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VII</td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_1st]" value="<?php echo $number_of_lesson_plan['vii_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_2nd]" value="<?php echo $number_of_lesson_plan['vii_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_3rd]" value="<?php echo $number_of_lesson_plan['vii_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_arabic]" value="<?php echo $number_of_lesson_plan['vii_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_evs]" value="<?php echo $number_of_lesson_plan['vii_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_phy]" value="<?php echo $number_of_lesson_plan['vii_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_chem]" value="<?php echo $number_of_lesson_plan['vii_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_bio]" value="<?php echo $number_of_lesson_plan['vii_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_math]" value="<?php echo $number_of_lesson_plan['vii_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_hist]" value="<?php echo $number_of_lesson_plan['vii_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_geo]" value="<?php echo $number_of_lesson_plan['vii_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_civics]" value="<?php echo $number_of_lesson_plan['vii_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_vii" name="number_of_lesson_plan[vii_eco]" value="<?php echo $number_of_lesson_plan['vii_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan_vii_total" name="number_of_lesson_plan[vii_total]" value="<?php echo $number_of_lesson_plan['vii_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VIII</td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_1st]" value="<?php echo $number_of_lesson_plan['viii_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_2nd]" value="<?php echo $number_of_lesson_plan['viii_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_3rd]" value="<?php echo $number_of_lesson_plan['viii_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_arabic]" value="<?php echo $number_of_lesson_plan['viii_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_evs]" value="<?php echo $number_of_lesson_plan['viii_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_phy]" value="<?php echo $number_of_lesson_plan['viii_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_chem]" value="<?php echo $number_of_lesson_plan['viii_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_bio]" value="<?php echo $number_of_lesson_plan['viii_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_math]" value="<?php echo $number_of_lesson_plan['viii_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_hist]" value="<?php echo $number_of_lesson_plan['viii_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_geo]" value="<?php echo $number_of_lesson_plan['viii_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_civics]" value="<?php echo $number_of_lesson_plan['viii_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_viii" name="number_of_lesson_plan[viii_eco]" value="<?php echo $number_of_lesson_plan['viii_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan_viii_total" name="number_of_lesson_plan[viii_total]" value="<?php echo $number_of_lesson_plan['viii_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>IX</td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_1st]" value="<?php echo $number_of_lesson_plan['ix_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_2nd]" value="<?php echo $number_of_lesson_plan['ix_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_3rd]" value="<?php echo $number_of_lesson_plan['ix_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_arabic]" value="<?php echo $number_of_lesson_plan['ix_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_evs]" value="<?php echo $number_of_lesson_plan['ix_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_phy]" value="<?php echo $number_of_lesson_plan['ix_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_chem]" value="<?php echo $number_of_lesson_plan['ix_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_bio]" value="<?php echo $number_of_lesson_plan['ix_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_math]" value="<?php echo $number_of_lesson_plan['ix_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_hist]" value="<?php echo $number_of_lesson_plan['ix_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_geo]" value="<?php echo $number_of_lesson_plan['ix_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_civics]" value="<?php echo $number_of_lesson_plan['ix_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_ix" name="number_of_lesson_plan[ix_eco]" value="<?php echo $number_of_lesson_plan['ix_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan_ix_total" name="number_of_lesson_plan[ix_total]" value="<?php echo $number_of_lesson_plan['ix_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>X</td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_1st]" value="<?php echo $number_of_lesson_plan['x_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_2nd]" value="<?php echo $number_of_lesson_plan['x_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_3rd]" value="<?php echo $number_of_lesson_plan['x_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_arabic]" value="<?php echo $number_of_lesson_plan['x_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_evs]" value="<?php echo $number_of_lesson_plan['x_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_phy]" value="<?php echo $number_of_lesson_plan['x_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_chem]" value="<?php echo $number_of_lesson_plan['x_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_bio]" value="<?php echo $number_of_lesson_plan['x_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_math]" value="<?php echo $number_of_lesson_plan['x_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_hist]" value="<?php echo $number_of_lesson_plan['x_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_geo]" value="<?php echo $number_of_lesson_plan['x_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_civics]" value="<?php echo $number_of_lesson_plan['x_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan number_of_lesson_plan_x" name="number_of_lesson_plan[x_eco]" value="<?php echo $number_of_lesson_plan['x_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_lesson_plan_x_total" name="number_of_lesson_plan[x_total]" value="<?php echo $number_of_lesson_plan['x_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td colspan="14"  style="text-align: right;">Grand total</td>
											<td>
												<input type="text"  class="number_of_lesson_plan_grand_total" name="number_of_lesson_plan[grand_total]" value="<?php echo $number_of_lesson_plan['grand_total'] ?>" style="width:70px;">	

											</td>
										</tr>
									</table>

									<div class="head_style" >Number of Class Tests  </div>	
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Language</td>
											<td rowspan="2">EVS</td>
											<td colspan="3">SSC/SC</td>
											<td rowspan="2">Math</td>
											<td colspan="4">SST</td>
											<td rowspan="2">Total</td>
										</tr>
										<tr>
											<td>1st</td>
											<td>2nd</td>
											<td>3rd</td>
											<td>Arabic</td>
											<td>Phy</td>
											<td>Chem</td>
											<td>Bio</td>
											<td>Hist</td>
											<td>Geo</td>
											<td>Civics</td>
											<td>ECO</td>
										</tr>
										<tr>
											<td>V</td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_1st]" value="<?php echo $number_of_class_test['v_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_2nd]" value="<?php echo $number_of_class_test['v_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_3rd]" value="<?php echo $number_of_class_test['v_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_arabic]" value="<?php echo $number_of_class_test['v_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_evs]" value="<?php echo $number_of_class_test['v_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_phy]" value="<?php echo $number_of_class_test['v_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_chem]" value="<?php echo $number_of_class_test['v_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_bio]" value="<?php echo $number_of_class_test['v_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_math]" value="<?php echo $number_of_class_test['v_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_hist]" value="<?php echo $number_of_class_test['v_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_geo]" value="<?php echo $number_of_class_test['v_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_civics]" value="<?php echo $number_of_class_test['v_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_v" name="number_of_class_test[v_eco]" value="<?php echo $number_of_class_test['v_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test_v_total" name="number_of_class_test[v_total]" value="<?php echo $number_of_class_test['v_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VI</td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_1st]" value="<?php echo $number_of_class_test['vi_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_2nd]" value="<?php echo $number_of_class_test['vi_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_3rd]" value="<?php echo $number_of_class_test['vi_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_arabic]" value="<?php echo $number_of_class_test['vi_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_evs]" value="<?php echo $number_of_class_test['vi_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_phy]" value="<?php echo $number_of_class_test['vi_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_chem]" value="<?php echo $number_of_class_test['vi_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_bio]" value="<?php echo $number_of_class_test['vi_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_math]" value="<?php echo $number_of_class_test['vi_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_hist]" value="<?php echo $number_of_class_test['vi_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_geo]" value="<?php echo $number_of_class_test['vi_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" name="number_of_class_test[vi_civics]" value="<?php echo $number_of_class_test['vi_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vi" name="number_of_class_test[vi_eco]" value="<?php echo $number_of_class_test['vi_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test_vi_total" name="number_of_class_test[vi_total]" value="<?php echo $number_of_class_test['vi_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VII</td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii" name="number_of_class_test[vii_1st]" value="<?php echo $number_of_class_test['vii_1st'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_2nd]" value="<?php echo $number_of_class_test['vii_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_3rd]" value="<?php echo $number_of_class_test['vii_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_arabic]" value="<?php echo $number_of_class_test['vii_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_evs]" value="<?php echo $number_of_class_test['vii_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_phy]" value="<?php echo $number_of_class_test['vii_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii" name="number_of_class_test[vii_chem]" value="<?php echo $number_of_class_test['vii_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_bio]" value="<?php echo $number_of_class_test['vii_bio'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_math]" value="<?php echo $number_of_class_test['vii_math'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_hist]" value="<?php echo $number_of_class_test['vii_hist'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_geo]" value="<?php echo $number_of_class_test['vii_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_civics]" value="<?php echo $number_of_class_test['vii_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_vii"  name="number_of_class_test[vii_eco]" value="<?php echo $number_of_class_test['vii_eco'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test_vii_total"  name="number_of_class_test[vii_total]" value="<?php echo $number_of_class_test['vii_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VIII</td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii"  name="number_of_class_test[viii_1st]" value="<?php echo $number_of_class_test['viii_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_2nd]" value="<?php echo $number_of_class_test['viii_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_3rd]" value="<?php echo $number_of_class_test['viii_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_arabic]" value="<?php echo $number_of_class_test['viii_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_evs]" value="<?php echo $number_of_class_test['viii_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_phy]" value="<?php echo $number_of_class_test['viii_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_chem]" value="<?php echo $number_of_class_test['viii_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_bio]" value="<?php echo $number_of_class_test['viii_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_math]" value="<?php echo $number_of_class_test['viii_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_hist]" value="<?php echo $number_of_class_test['viii_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_geo]" value="<?php echo $number_of_class_test['viii_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_civics]" value="<?php echo $number_of_class_test['viii_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_viii" name="number_of_class_test[viii_eco]" value="<?php echo $number_of_class_test['viii_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test_viii_total" name="number_of_class_test[viii_total]" value="<?php echo $number_of_class_test['viii_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>IX</td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_1st]" value="<?php echo $number_of_class_test['ix_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_2nd]" value="<?php echo $number_of_class_test['ix_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_3rd]" value="<?php echo $number_of_class_test['ix_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_arabic]" value="<?php echo $number_of_class_test['ix_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_evs]" value="<?php echo $number_of_class_test['ix_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_phy]" value="<?php echo $number_of_class_test['ix_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_chem]" value="<?php echo $number_of_class_test['ix_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_bio]" value="<?php echo $number_of_class_test['ix_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_math]" value="<?php echo $number_of_class_test['ix_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_hist]" value="<?php echo $number_of_class_test['ix_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_geo]" value="<?php echo $number_of_class_test['ix_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_civics]" value="<?php echo $number_of_class_test['ix_civics'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_ix" name="number_of_class_test[ix_eco]" value="<?php echo $number_of_class_test['ix_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test_ix_total" name="number_of_class_test[ix_total]" value="<?php echo $number_of_class_test['ix_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>X</td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_x" name="number_of_class_test[x_1st]" value="<?php echo $number_of_class_test['x_1st'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="number_of_class_test number_of_class_test_x" name="number_of_class_test[x_2nd]" value="<?php echo $number_of_class_test['x_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_3rd]" value="<?php echo $number_of_class_test['x_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_arabic]" value="<?php echo $number_of_class_test['x_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_evs]" value="<?php echo $number_of_class_test['x_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_phy]" value="<?php echo $number_of_class_test['x_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_chem]" value="<?php echo $number_of_class_test['x_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_bio]" value="<?php echo $number_of_class_test['x_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_math]" value="<?php echo $number_of_class_test['x_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_hist]" value="<?php echo $number_of_class_test['x_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_geo]" value="<?php echo $number_of_class_test['x_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_civics]" value="<?php echo $number_of_class_test['x_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test number_of_class_test_x"  name="number_of_class_test[x_eco]" value="<?php echo $number_of_class_test['x_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="number_of_class_test_x_total"  name="number_of_class_test[x_total]" value="<?php echo $number_of_class_test['x_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td colspan="14" style="text-align: right;">Grand Total</td>
											<td><input type="text"  class="number_of_class_test_grand_total" name="number_of_class_test[grand_total]" value="<?php echo $number_of_class_test['grand_total'] ?>" style="width:70px;"></td>
										</tr>
									</table>	
									<div class="head_style" >Number of Classes Observed by the Head of the Institution </div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Language</td>
											<td rowspan="2">EVS</td>
											<td colspan="3">SSC/SC</td>
											<td rowspan="2">Math</td>
											<td colspan="4">SST</td>
											<td rowspan="2">Total</td>
										</tr>
										<tr>
											<td>1st</td>
											<td>2nd</td>
											<td>3rd</td>
											<td>Arabic</td>
											<td>Phy</td>
											<td>Chem</td>
											<td>Bio</td>
											<td>Hist</td>
											<td>Geo</td>
											<td>Civics</td>
											<td>ECO</td>
										</tr>
										<tr>
											<td>V</td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v" name="no_of_classes_observed[v_1st]" value="<?php echo $no_of_classes_observed['v_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_2nd]" value="<?php echo $no_of_classes_observed['v_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_3rd]" value="<?php echo $no_of_classes_observed['v_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_arabic]" value="<?php echo $no_of_classes_observed['v_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_evs]" value="<?php echo $no_of_classes_observed['v_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_phy]" value="<?php echo $no_of_classes_observed['v_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_chem]" value="<?php echo $no_of_classes_observed['v_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_bio]" value="<?php echo $no_of_classes_observed['v_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_math]" value="<?php echo $no_of_classes_observed['v_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_hist]" value="<?php echo $no_of_classes_observed['v_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_geo]" value="<?php echo $no_of_classes_observed['v_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_civics]" value="<?php echo $no_of_classes_observed['v_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_v"  name="no_of_classes_observed[v_eco]" value="<?php echo $no_of_classes_observed['v_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed_v_total"  name="no_of_classes_observed[v_total]" value="<?php echo $no_of_classes_observed['v_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VI</td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi"  name="no_of_classes_observed[vi_1st]" value="<?php echo $no_of_classes_observed['vi_1st'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi"   name="no_of_classes_observed[vi_2nd]" value="<?php echo $no_of_classes_observed['vi_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi"   name="no_of_classes_observed[vi_3rd]" value="<?php echo $no_of_classes_observed['vi_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi"   name="no_of_classes_observed[vi_arabic]" value="<?php echo $no_of_classes_observed['vi_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi" name="no_of_classes_observed[vi_evs]" value="<?php echo $no_of_classes_observed['vi_evs'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi" name="no_of_classes_observed[vi_phy]" value="<?php echo $no_of_classes_observed['vi_phy'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi" name="no_of_classes_observed[vi_chem]" value="<?php echo $no_of_classes_observed['vi_chem'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi" name="no_of_classes_observed[vi_bio]" value="<?php echo $no_of_classes_observed['vi_bio'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi" name="no_of_classes_observed[vi_math]" value="<?php echo $no_of_classes_observed['vi_math'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi"  name="no_of_classes_observed[vi_hist]" value="<?php echo $no_of_classes_observed['vi_hist'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi"   name="no_of_classes_observed[vi_geo]" value="<?php echo $no_of_classes_observed['vi_geo'] ?>" style="width:70px;"></td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_vi"   name="no_of_classes_observed[vi_civics]" value="<?php echo $no_of_classes_observed['vi_civics'] ?>" style="width:70px;"></td>
											<td><input type="text"   class="no_of_classes_observed no_of_classes_observed_vi" name="no_of_classes_observed[vi_eco]" value="<?php echo $no_of_classes_observed['vi_eco'] ?>" style="width:70px;"></td>
											<td><input type="text"   class="no_of_classes_observed_vi_total"   name="no_of_classes_observed[vi_total]" value="<?php echo $no_of_classes_observed['vi_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VII</td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii" name="no_of_classes_observed[vii_1st]" value="<?php echo $no_of_classes_observed['vii_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_2nd]" value="<?php echo $no_of_classes_observed['vii_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_3rd]" value="<?php echo $no_of_classes_observed['vii_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_arabic]" value="<?php echo $no_of_classes_observed['vii_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_evs]" value="<?php echo $no_of_classes_observed['vii_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_phy]" value="<?php echo $no_of_classes_observed['vii_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_chem]" value="<?php echo $no_of_classes_observed['vii_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_bio]" value="<?php echo $no_of_classes_observed['vii_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_math]" value="<?php echo $no_of_classes_observed['vii_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_hist]" value="<?php echo $no_of_classes_observed['vii_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_geo]" value="<?php echo $no_of_classes_observed['vii_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_civics]" value="<?php echo $no_of_classes_observed['vii_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_vii"  name="no_of_classes_observed[vii_eco]" value="<?php echo $no_of_classes_observed['vii_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed_vii_total"  name="no_of_classes_observed[vii_total]" value="<?php echo $no_of_classes_observed['vii_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>VIII</td>
											<td><input type="text"  class="no_of_classes_observed no_of_classes_observed_viii"  name="no_of_classes_observed[viii_1st]" value="<?php echo $no_of_classes_observed['viii_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_2nd]" value="<?php echo $no_of_classes_observed['viii_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_3rd]" value="<?php echo $no_of_classes_observed['viii_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_arabic]" value="<?php echo $no_of_classes_observed['viii_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_evs]" value="<?php echo $no_of_classes_observed['viii_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_phy]" value="<?php echo $no_of_classes_observed['viii_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_chem]" value="<?php echo $no_of_classes_observed['viii_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_bio]" value="<?php echo $no_of_classes_observed['viii_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_math]" value="<?php echo $no_of_classes_observed['viii_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_hist]" value="<?php echo $no_of_classes_observed['viii_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_geo]" value="<?php echo $no_of_classes_observed['viii_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_civics]" value="<?php echo $no_of_classes_observed['viii_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_viii" name="no_of_classes_observed[viii_eco]" value="<?php echo $no_of_classes_observed['viii_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed_viii_total" name="no_of_classes_observed[viii_total]" value="<?php echo $no_of_classes_observed['viii_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>IX</td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_1st]" value="<?php echo $no_of_classes_observed['ix_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_2nd]" value="<?php echo $no_of_classes_observed['ix_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_3rd]" value="<?php echo $no_of_classes_observed['ix_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_arabic]" value="<?php echo $no_of_classes_observed['ix_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_evs]" value="<?php echo $no_of_classes_observed['ix_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_phy]" value="<?php echo $no_of_classes_observed['ix_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_chem]" value="<?php echo $no_of_classes_observed['ix_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_bio]" value="<?php echo $no_of_classes_observed['ix_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_math]" value="<?php echo $no_of_classes_observed['ix_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_hist]" value="<?php echo $no_of_classes_observed['ix_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_geo]" value="<?php echo $no_of_classes_observed['ix_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_civics]" value="<?php echo $no_of_classes_observed['ix_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_ix" name="no_of_classes_observed[ix_eco]" value="<?php echo $no_of_classes_observed['ix_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed_ix_total" name="no_of_classes_observed[ix_total]" value="<?php echo $no_of_classes_observed['ix_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td>X</td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_1st]" value="<?php echo $no_of_classes_observed['x_1st'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_2nd]" value="<?php echo $no_of_classes_observed['x_2nd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_3rd]" value="<?php echo $no_of_classes_observed['x_3rd'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_arabic]" value="<?php echo $no_of_classes_observed['x_arabic'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_evs]" value="<?php echo $no_of_classes_observed['x_evs'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_phy]" value="<?php echo $no_of_classes_observed['x_phy'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_chem]" value="<?php echo $no_of_classes_observed['x_chem'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_bio]" value="<?php echo $no_of_classes_observed['x_bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_math]" value="<?php echo $no_of_classes_observed['x_math'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_hist]" value="<?php echo $no_of_classes_observed['x_hist'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_geo]" value="<?php echo $no_of_classes_observed['x_geo'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_civics]" value="<?php echo $no_of_classes_observed['x_civics'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed no_of_classes_observed_x" name="no_of_classes_observed[x_eco]" value="<?php echo $no_of_classes_observed['x_eco'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_classes_observed_x_total" name="no_of_classes_observed[x_total]" value="<?php echo $no_of_classes_observed['x_total'] ?>" style="width:70px;"></td>	
										</tr>
										<tr>
											<td colspan="14" style="text-align: right;">Grand total</td>
											<td><input type="text"  class="no_of_classes_observed_grand_total" name="no_of_classes_observed[grand_total]" value="<?php echo $no_of_classes_observed['grand_total'] ?>" style="width:70px;"></td>
										</tr>
									</table>
									

									<div class="head_style" >Number of Foundation Classes for VIII</div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td>Phy</td>
											<td>Chem</td>
											<td>Math</td>
											<td>Bio</td>
											<td>Total</td>
										</tr>
										<tr>
											<td><input type="text" class="no_of_foundation_class_for_viii" name="no_of_foundation_class_for_viii[phy]" value="<?php echo $no_of_foundation_class_for_viii['phy'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_viii"  name="no_of_foundation_class_for_viii[chem]" value="<?php echo $no_of_foundation_class_for_viii['chem'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_viii"  name="no_of_foundation_class_for_viii[math]" value="<?php echo $no_of_foundation_class_for_viii['math'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_viii"  name="no_of_foundation_class_for_viii[bio]" value="<?php echo $no_of_foundation_class_for_viii['bio'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_viii_total"  name="no_of_foundation_class_for_viii[total]" value="<?php echo $no_of_foundation_class_for_viii['total'] ?>" style="width:70px;"></td>	
										</tr>
									</table>

									<div class="head_style" >Number of Foundation Classes for IX</div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td>Phy</td>
											<td>Chem</td>
											<td>Math</td>
											<td>Bio</td>
											<td>SST</td>		
											<td>Total</td>
										</tr>
										<tr>
											<td><input type="text" class="no_of_foundation_class_for_ix" name="no_of_foundation_class_for_ix[phy]" value="<?php echo $no_of_foundation_class_for_ix['phy'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_ix"  name="no_of_foundation_class_for_ix[chem]" value="<?php echo $no_of_foundation_class_for_ix['chem'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_ix"  name="no_of_foundation_class_for_ix[math]" value="<?php echo $no_of_foundation_class_for_ix['math'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_ix"  name="no_of_foundation_class_for_ix[bio]" value="<?php echo $no_of_foundation_class_for_ix['bio'] ?>" style="width:70px;"></td>
											<td><input type="text" class="no_of_foundation_class_for_ix"  name="no_of_foundation_class_for_ix[sst]" value="<?php echo $no_of_foundation_class_for_ix['sst'] ?>" style="width:70px;"></td>

											<td><input type="text" class="no_of_foundation_class_for_ix_total"  name="no_of_foundation_class_for_ix[total]" value="<?php echo $no_of_foundation_class_for_ix['total'] ?>" style="width:70px;"></td>	
										</tr>
									</table>



									<div class="head_style" >Which Manipulative Were Seen to be Used in the Class? </div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td class=""><div class="rotate" >Class</div></td>
											<td class=""><div class="rotate" >Rhymes</div></td>
											<td class=""><div class="rotate" >Spoken English</div></td>
											<td class=""><div class="rotate" >Model</div></td>
											<td class=""><div class="rotate" >Extra study matrial</div></td>
											<td class=""><div class="rotate" >Debate and extempore </div></td>
											<td class=""><div class="rotate" >Story telling</div></td>
											<td class=""><div class="rotate" >Theater as pedagogy</div></td>
											<td class=""><div class="rotate" >Sc. Exp</div></td>
											<td class=""><div class="rotate" >Chart</div></td>
											<td class=""><div class="rotate" >Work sheet</div></td>
											<td class=""><div class="rotate" >Puzzle and tangrams</div></td>
											<td class=""><div class="rotate" >Mental math</div></td>
											<td class=""><div class="rotate" >Map/Globe</div></td>
											<td class=""><div class="rotate" >Field work</div></td>
											<td class=""><div class="rotate" >Smart class</div></td>
											<td class=""><div class="rotate" >Group work</div></td>
											<td class=""><div class="rotate" >Project</div></td>
										</tr>

										<tr>
											<td>V</td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_rhymes]" <?php echo isset($manipulatives['v_rhymes'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_chart]" <?php echo isset($manipulatives['v_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_model]" <?php echo isset($manipulatives['v_model'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_extra_study_matrial]" <?php echo isset($manipulatives['v_extra_study_matrial'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_debate_and_extempore]" <?php echo isset($manipulatives['v_debate_and_extempore'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_story_telling]" <?php echo isset($manipulatives['v_story_telling'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_theater_as_pedagogy]" <?php echo isset($manipulatives['v_theater_as_pedagogy'])?"checked":""?>></td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_sc_exp]" <?php echo isset($manipulatives['v_sc_exp'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_sc_chart]" <?php echo isset($manipulatives['v_sc_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_work_sheet]" <?php echo isset($manipulatives['v_work_sheet'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_puzzle_and_tan_grams]" <?php echo isset($manipulatives['v_puzzle_and_tan_grams'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_mental_math]" <?php echo isset($manipulatives['v_mental_math'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_map_globe]" <?php echo isset($manipulatives['v_map_globe'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_field_work]" <?php echo isset($manipulatives['v_field_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_smart_class]" <?php echo isset($manipulatives['v_smart_class'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_group_work]" <?php echo isset($manipulatives['v_group_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[v_project]" <?php echo isset($manipulatives['v_project'])?"checked":""?>></td>
										</tr>
										<tr>
											<td>VI</td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_rhymes]" <?php echo isset($manipulatives['vi_rhymes'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_chart]" <?php echo isset($manipulatives['vi_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_model]" <?php echo isset($manipulatives['vi_model'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_extra_study_matrial]" <?php echo isset($manipulatives['vi_extra_study_matrial'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_debate_and_extempore]" <?php echo isset($manipulatives['vi_debate_and_extempore'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_story_telling]" <?php echo isset($manipulatives['vi_story_telling'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_theater_as_pedagogy]" <?php echo isset($manipulatives['vi_theater_as_pedagogy'])?"checked":""?>></td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_sc_exp]" <?php echo isset($manipulatives['vi_sc_exp'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_sc_chart]" <?php echo isset($manipulatives['vi_sc_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_work_sheet]" <?php echo isset($manipulatives['vi_work_sheet'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_puzzle_and_tan_grams]" <?php echo isset($manipulatives['vi_puzzle_and_tan_grams'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_mental_math]" <?php echo isset($manipulatives['vi_mental_math'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_map_globe]" <?php echo isset($manipulatives['vi_map_globe'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_field_work]" <?php echo isset($manipulatives['vi_field_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_smart_class]" <?php echo isset($manipulatives['vi_smart_class'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_group_work]" <?php echo isset($manipulatives['vi_group_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vi_project]" <?php echo isset($manipulatives['vi_project'])?"checked":""?>></td>
										</tr>
										<tr>
											<td>VII</td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_rhymes]" <?php echo isset($manipulatives['vii_rhymes'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_chart]" <?php echo isset($manipulatives['vii_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_model]" <?php echo isset($manipulatives['vii_model'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_extra_study_matrial]" <?php echo isset($manipulatives['vii_extra_study_matrial'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_debate_and_extempore]" <?php echo isset($manipulatives['vii_debate_and_extempore'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_story_telling]" <?php echo isset($manipulatives['vii_story_telling'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_theater_as_pedagogy]" <?php echo isset($manipulatives['vii_theater_as_pedagogy'])?"checked":""?>></td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_sc_exp]" <?php echo isset($manipulatives['vii_sc_exp'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_sc_chart]" <?php echo isset($manipulatives['vii_sc_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_work_sheet]" <?php echo isset($manipulatives['vii_work_sheet'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_puzzle_and_tan_grams]" <?php echo isset($manipulatives['vii_puzzle_and_tan_grams'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_mental_math]" <?php echo isset($manipulatives['vii_mental_math'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_map_globe]" <?php echo isset($manipulatives['vii_map_globe'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_field_work]" <?php echo isset($manipulatives['vii_field_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_smart_class]" <?php echo isset($manipulatives['vii_smart_class'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_group_work]" <?php echo isset($manipulatives['vii_group_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[vii_project]" <?php echo isset($manipulatives['vii_project'])?"checked":""?>></td>
										</tr>
										<tr>
											<td>VIII</td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_rhymes]" <?php echo isset($manipulatives['viii_rhymes'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_chart]" <?php echo isset($manipulatives['viii_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_model]" <?php echo isset($manipulatives['viii_model'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_extra_study_matrial]" <?php echo isset($manipulatives['viii_extra_study_matrial'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_debate_and_extempore]" <?php echo isset($manipulatives['viii_debate_and_extempore'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_story_telling]" <?php echo isset($manipulatives['viii_story_telling'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_theater_as_pedagogy]" <?php echo isset($manipulatives['viii_theater_as_pedagogy'])?"checked":""?>></td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_sc_exp]" <?php echo isset($manipulatives['viii_sc_exp'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_sc_chart]" <?php echo isset($manipulatives['viii_sc_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_work_sheet]" <?php echo isset($manipulatives['viii_work_sheet'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_puzzle_and_tan_grams]" <?php echo isset($manipulatives['viii_puzzle_and_tan_grams'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_mental_math]" <?php echo isset($manipulatives['viii_mental_math'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_map_globe]" <?php echo isset($manipulatives['viii_map_globe'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_field_work]" <?php echo isset($manipulatives['viii_field_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_smart_class]" <?php echo isset($manipulatives['viii_smart_class'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_group_work]" <?php echo isset($manipulatives['viii_group_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[viii_project]" <?php echo isset($manipulatives['viii_project'])?"checked":""?>></td>
										</tr>

										<tr>
											<td>IX</td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_rhymes]" <?php echo isset($manipulatives['ix_rhymes'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_chart]" <?php echo isset($manipulatives['ix_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_model]" <?php echo isset($manipulatives['ix_model'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_extra_study_matrial]" <?php echo isset($manipulatives['ix_extra_study_matrial'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_debate_and_extempore]" <?php echo isset($manipulatives['ix_debate_and_extempore'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_story_telling]" <?php echo isset($manipulatives['ix_story_telling'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_theater_as_pedagogy]" <?php echo isset($manipulatives['ix_theater_as_pedagogy'])?"checked":""?>></td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_sc_exp]" <?php echo isset($manipulatives['ix_sc_exp'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_sc_chart]" <?php echo isset($manipulatives['ix_sc_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_work_sheet]" <?php echo isset($manipulatives['ix_work_sheet'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_puzzle_and_tan_grams]" <?php echo isset($manipulatives['ix_puzzle_and_tan_grams'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_mental_math]" <?php echo isset($manipulatives['ix_mental_math'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_map_globe]" <?php echo isset($manipulatives['ix_map_globe'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_field_work]" <?php echo isset($manipulatives['ix_field_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_smart_class]" <?php echo isset($manipulatives['ix_smart_class'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_group_work]" <?php echo isset($manipulatives['ix_group_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[ix_project]" <?php echo isset($manipulatives['ix_project'])?"checked":""?>></td>
										</tr>
										<tr>
											<td>X</td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_rhymes]" <?php echo isset($manipulatives['x_rhymes'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_chart]" <?php echo isset($manipulatives['x_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_model]" <?php echo isset($manipulatives['x_model'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_extra_study_matrial]" <?php echo isset($manipulatives['x_extra_study_matrial'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_debate_and_extempore]" <?php echo isset($manipulatives['x_debate_and_extempore'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_story_telling]" <?php echo isset($manipulatives['x_story_telling'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_theater_as_pedagogy]" <?php echo isset($manipulatives['x_theater_as_pedagogy'])?"checked":""?>></td>
											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_sc_exp]" <?php echo isset($manipulatives['x_sc_exp'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_sc_chart]" <?php echo isset($manipulatives['x_sc_chart'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_work_sheet]" <?php echo isset($manipulatives['x_work_sheet'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_puzzle_and_tan_grams]" <?php echo isset($manipulatives['x_puzzle_and_tan_grams'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_mental_math]" <?php echo isset($manipulatives['x_mental_math'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_map_globe]" <?php echo isset($manipulatives['x_map_globe'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_field_work]" <?php echo isset($manipulatives['x_field_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_smart_class]" <?php echo isset($manipulatives['x_smart_class'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_group_work]" <?php echo isset($manipulatives['x_group_work'])?"checked":""?>></td>

											<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="manipulatives[x_project]" <?php echo isset($manipulatives['x_project'])?"checked":""?>></td>
										</tr>


									</table>
									<table width="70%" border="0" class="formClass"   >	 
										<tr >
											<td>Assessment report updated on portal:     </td>
											<td>  

												<select name="assesment_report_updated" id="assesment_report_updated" class="textbox fWidth" ><option value="">Select assesment_report_updated</option>	<? 
												$os->onlyOption($os->assesment_report_updated,$os->getVal('assesment_report_updated'));?></select>	 </td>						
											</tr><tr >
												<td>Daily Taleem  </td>
												<td>  

													<select name="daily_talim" id="daily_talim" class="textbox fWidth" ><option value="">Select daily_talim</option>	<? 
													$os->onlyOption($os->yesno,$os->getVal('daily_talim'));?></select>	 </td>						
												</tr><tr >
													<td>Learning of Quran daily:</td>
													<td>  

														<select name="daily_quran_larning" id="daily_quran_larning" class="textbox fWidth" ><option value="">Select daily_quran_larning</option>	<? 
														$os->onlyOption($os->yesno,$os->getVal('daily_quran_larning'));?></select>	 </td>						
													</tr><tr >
														<td>Departmental Meeting: </td>
														<td>  

														<!-- <select name="departmental_meeting" id="departmental_meeting" class="textbox fWidth" ><option value="">Select departmental_meeting</option>	<? 
														$os->onlyOption($os->departmental_meeting,$os->getVal('departmental_meeting'));?></select> -->
														<table class="uk-table uk-table-small  ">
															<tr class="borderTitle">
																<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="departmental_meeting[beng]" <?php echo isset($departmental_meeting['beng'])?"checked":""?>> Beng</td>

																<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="departmental_meeting[eng]" <?php echo isset($departmental_meeting['eng'])?"checked":""?>> Eng</td>

																<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="departmental_meeting[math]" <?php echo isset($departmental_meeting['math'])?"checked":""?>> Math</td>

																<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="departmental_meeting[science]" <?php echo isset($departmental_meeting['science'])?"checked":""?>> Science</td>
																
																<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="departmental_meeting[sst]" <?php echo isset($departmental_meeting['sst'])?"checked":""?>> SST</td>

																<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="departmental_meeting[arabic]" <?php echo isset($departmental_meeting['arabic'])?"checked":""?>> Arabic</td>																
															</tr>
														</table>


													</td>						
												</tr><tr >
													<td>All Teachers Meeting: </td>
													<td>  

														<select name="all_teacher_meeting" id="all_teacher_meeting" class="textbox fWidth" ><option value="">Select all_teacher_meeting</option>	<? 
														$os->onlyOption($os->yesno,$os->getVal('all_teacher_meeting'));?></select>	 </td>						
													</tr><tr >
														<td>Daily basis ABACUS Class (V & VI) </td>
														<td>  

															<select name="daily_abascus_class" id="daily_abascus_class" class="textbox fWidth" ><option value="">Select daily_abascus_class</option>	<? 
															$os->onlyOption($os->yesno,$os->getVal('daily_abascus_class'));?></select>	 </td>						
														</tr>


														<tr style="display:none;">
															<td>Entry_date </td>
															<td><input value="<?php  echo $os->showDate( $os->getVal('entry_date'));?>" type="text" name="entry_date" id="entry_date" class="wtDateClass textbox fWidth"/></td>						
														</tr><tr style="display:none;">
															<td>Entry by admin_id </td>
															<td><input value="<?php echo $os->getVal('entry_by_admin_id') ?>" type="text" name="entry_by_admin_id" id="entry_by_admin_id" class="textbox  fWidth "/> </td>						
														</tr>
													</table>
													
												</div>
											</fieldset>






											<? if($os->access('wtEdit')){ ?> 	<input type="button" class="submit"  value="Save" onclick="submitFormData()" />	 <? } ?>	 
											<input type="button" class="submit"  value="Back to List" onclick="javascript:window.location='<? echo $listPageLink ?>';" />	
											<input type="hidden" name="redirectLink"  value="<? echo $os->server('HTTP_REFERER'); ?>" />
											<input type="hidden" name="rowId" value="<?php   echo  $os->getVal($primeryField) ;?>" />
											<input type="hidden" name="operation" value="updateField" />
										</form>
									</div>			  </td>
								</tr>
							</table>

							<style>
								.head_style{ text-align:center; font-size:16px; font-weight:bold; border:1px solid #999999; padding:5px 5px; width:300px; margin:auto; margin-top:20px; border-bottom:none;
									background-color:#FFFFFF;
								}
								.listTable{ margin:auto; max-width:600px; background-color:#FFFFFF;}
								.listTable td{ text-align:center; border-right:1px solid #CCCCCC;}
								.cFielSets{ background-color:#A6D2FF;}


							</style>
							<style>
								.rotate { 
									writing-mode: vertical-rl;
									transform: rotate(180deg);

								}

								.formClass { margin:auto; margin-top:20px;}
								.tickmark td{ font-weight:bold; }
							</style>
							<script>
								function submitFormData(){
									os.submitForm('submitFormDataId');
								}
								$('.number_of_lesson_plan').blur(function() {
									var number_of_lesson_plan_v_total=0;
									var number_of_lesson_plan_vi_total=0;
									var number_of_lesson_plan_vii_total=0;
									var number_of_lesson_plan_viii_total=0;
									var number_of_lesson_plan_ix_total=0;
									var number_of_lesson_plan_x_total=0;
									var number_of_lesson_plan_grand_total=0;
									$('.number_of_lesson_plan_v').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_lesson_plan_v_total=number_of_lesson_plan_v_total+parseFloat(value);
									});
									$('.number_of_lesson_plan_vi').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_lesson_plan_vi_total=number_of_lesson_plan_vi_total+parseFloat(value);
									});
									$('.number_of_lesson_plan_vii').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_lesson_plan_vii_total=number_of_lesson_plan_vii_total+parseFloat(value);
									});
									$('.number_of_lesson_plan_viii').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_lesson_plan_viii_total=number_of_lesson_plan_viii_total+parseFloat(value);
									});
									$('.number_of_lesson_plan_ix').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_lesson_plan_ix_total=number_of_lesson_plan_ix_total+parseFloat(value);
									});
									$('.number_of_lesson_plan_x').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_lesson_plan_x_total=number_of_lesson_plan_x_total+parseFloat(value);
									});
									$('.number_of_lesson_plan_v_total').val(number_of_lesson_plan_v_total);
									$('.number_of_lesson_plan_vi_total').val(number_of_lesson_plan_vi_total);
									$('.number_of_lesson_plan_vii_total').val(number_of_lesson_plan_vii_total);
									$('.number_of_lesson_plan_viii_total').val(number_of_lesson_plan_viii_total);
									$('.number_of_lesson_plan_ix_total').val(number_of_lesson_plan_ix_total);
									$('.number_of_lesson_plan_x_total').val(number_of_lesson_plan_x_total);
									number_of_lesson_plan_grand_total=parseFloat(number_of_lesson_plan_v_total)+parseFloat(number_of_lesson_plan_vi_total)+parseFloat(number_of_lesson_plan_vii_total)+parseFloat(number_of_lesson_plan_viii_total)+parseFloat(number_of_lesson_plan_ix_total)+parseFloat(number_of_lesson_plan_x_total);
									$('.number_of_lesson_plan_grand_total').val(number_of_lesson_plan_grand_total);

								});

								$('.number_of_class_test').blur(function() {
									var number_of_class_test_v_total=0;
									var number_of_class_test_vi_total=0;
									var number_of_class_test_vii_total=0;
									var number_of_class_test_viii_total=0;
									var number_of_class_test_ix_total=0;
									var number_of_class_test_x_total=0;
									var number_of_class_test_grand_total=0;
									$('.number_of_class_test_v').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_class_test_v_total=number_of_class_test_v_total+parseFloat(value);
									});
									$('.number_of_class_test_vi').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_class_test_vi_total=number_of_class_test_vi_total+parseFloat(value);
									});
									$('.number_of_class_test_vii').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_class_test_vii_total=number_of_class_test_vii_total+parseFloat(value);
									});
									$('.number_of_class_test_viii').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_class_test_viii_total=number_of_class_test_viii_total+parseFloat(value);
									});
									$('.number_of_class_test_ix').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_class_test_ix_total=number_of_class_test_ix_total+parseFloat(value);
									});
									$('.number_of_class_test_x').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										number_of_class_test_x_total=number_of_class_test_x_total+parseFloat(value);
									});
									$('.number_of_class_test_v_total').val(number_of_class_test_v_total);
									$('.number_of_class_test_vi_total').val(number_of_class_test_vi_total);
									$('.number_of_class_test_vii_total').val(number_of_class_test_vii_total);
									$('.number_of_class_test_viii_total').val(number_of_class_test_viii_total);
									$('.number_of_class_test_ix_total').val(number_of_class_test_ix_total);
									$('.number_of_class_test_x_total').val(number_of_class_test_x_total);
									number_of_class_test_grand_total=parseFloat(number_of_class_test_v_total)+parseFloat(number_of_class_test_vi_total)+parseFloat(number_of_class_test_vii_total)+parseFloat(number_of_class_test_viii_total)+parseFloat(number_of_class_test_ix_total)+parseFloat(number_of_class_test_x_total);
									$('.number_of_class_test_grand_total').val(number_of_class_test_grand_total);

								});
								$('.no_of_classes_observed').blur(function() {
									var no_of_classes_observed_v_total=0;
									var no_of_classes_observed_vi_total=0;
									var no_of_classes_observed_vii_total=0;
									var no_of_classes_observed_viii_total=0;
									var no_of_classes_observed_ix_total=0;
									var no_of_classes_observed_x_total=0;
									var no_of_classes_observed_grand_total=0;
									$('.no_of_classes_observed_v').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_classes_observed_v_total=no_of_classes_observed_v_total+parseFloat(value);
									});
									$('.no_of_classes_observed_vi').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_classes_observed_vi_total=no_of_classes_observed_vi_total+parseFloat(value);
									});
									$('.no_of_classes_observed_vii').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_classes_observed_vii_total=no_of_classes_observed_vii_total+parseFloat(value);
									});
									$('.no_of_classes_observed_viii').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_classes_observed_viii_total=no_of_classes_observed_viii_total+parseFloat(value);
									});
									$('.no_of_classes_observed_ix').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_classes_observed_ix_total=no_of_classes_observed_ix_total+parseFloat(value);
									});
									$('.no_of_classes_observed_x').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_classes_observed_x_total=no_of_classes_observed_x_total+parseFloat(value);
									});
									$('.no_of_classes_observed_v_total').val(no_of_classes_observed_v_total);
									$('.no_of_classes_observed_vi_total').val(no_of_classes_observed_vi_total);
									$('.no_of_classes_observed_vii_total').val(no_of_classes_observed_vii_total);
									$('.no_of_classes_observed_viii_total').val(no_of_classes_observed_viii_total);
									$('.no_of_classes_observed_ix_total').val(no_of_classes_observed_ix_total);
									$('.no_of_classes_observed_x_total').val(no_of_classes_observed_x_total);
									no_of_classes_observed_grand_total=parseFloat(no_of_classes_observed_v_total)+parseFloat(no_of_classes_observed_vi_total)+parseFloat(no_of_classes_observed_vii_total)+parseFloat(no_of_classes_observed_viii_total)+parseFloat(no_of_classes_observed_ix_total)+parseFloat(no_of_classes_observed_x_total);
									$('.no_of_classes_observed_grand_total').val(no_of_classes_observed_grand_total);

								});
								$('.no_of_foundation_class_for_viii').blur(function() {
									var no_of_foundation_class_for_viii_total=0;
									$('.no_of_foundation_class_for_viii').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_foundation_class_for_viii_total=no_of_foundation_class_for_viii_total+parseFloat(value);
									});
									$('.no_of_foundation_class_for_viii_total').val(no_of_foundation_class_for_viii_total);							

								});
								$('.no_of_foundation_class_for_ix').blur(function() {
									var no_of_foundation_class_for_ix_total=0;
									$('.no_of_foundation_class_for_ix').each(function() {
										var value = parseFloat( $( this ).val() ) || 0;
										no_of_foundation_class_for_ix_total=no_of_foundation_class_for_ix_total+parseFloat(value);
									});
									$('.no_of_foundation_class_for_ix_total').val(no_of_foundation_class_for_ix_total);							

								});
							</script>
							<? include($site['root-wtos'].'bottom.php'); ?>
