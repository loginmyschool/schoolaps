<?
/*
   # wtos version : 1.1
   # List Page : monthly_academic_audit_xiiList.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$ajaxFilePath= 'upload_academic_audit_vx_ajax.php';
?><?

$editPage='monthly_academic_audit_xiiEdit.php';
$listPage='monthly_academic_audit_xiiList.php';
$primeryTable='monthly_academic_audit_xii';
$primeryField='monthly_academic_audit_xii_id';
$pageHeader='Add Monthly academic audit XI and XII';


$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());
$tmpVar='';
$editRowId=$os->get('editRowId');
if($editRowId)
{
	$pageHeader='Edit  Monthly academic audit XI and XII';
}


##  update row
if($os->post('operation'))
{

	if($os->post('operation')=='updateField')
	{
		$rowId=$os->post('rowId');

	  #---- edit section ----#

		$dataToSave['year']=addslashes($os->post('year')); 
		$dataToSave['month']=addslashes($os->post('month')); 
		

		$month=str_pad($dataToSave['month'], 2, "0", STR_PAD_LEFT); 
		$dated= $dataToSave['year'].'-'.$month.'-'.'01 00:00:00';
		
		$dataToSave['dated']=$dated; 
		
		$dataToSave['number_of_classes']=addslashes(json_encode($os->post('number_of_classes'))); 
		$dataToSave['number_of_supervission_classes']=addslashes(json_encode($os->post('number_of_supervission_classes'))); 
		$dataToSave['number_of_practical_classes']=addslashes(json_encode($os->post('number_of_practical_classes'))); 
		$dataToSave['number_of_special_classes']=addslashes(json_encode($os->post('number_of_special_classes'))); 
		$dataToSave['number_of_neet_classes']=addslashes(json_encode($os->post('number_of_neet_classes'))); 
		$dataToSave['number_of_mock_test']=addslashes(json_encode($os->post('number_of_mock_test'))); 
		$dataToSave['co_curricular_activity']=addslashes($os->post('co_curricular_activity')); 
		$dataToSave['cultural_programme']=addslashes($os->post('cultural_programme')); 
		$dataToSave['motivational_programme']=addslashes(json_encode($os->post('motivational_programme'))); 
		$dataToSave['branch_code']=addslashes($os->post('branch_code')); 		
		$dataToSave['number_of_test_classtest']=addslashes(json_encode($os->post('number_of_test_classtest'))); 
		$dataToSave['number_of_test_dpt']=addslashes(json_encode($os->post('number_of_test_dpt'))); 
		$dataToSave['number_of_test_ft1']=addslashes(json_encode($os->post('number_of_test_ft1'))); 
		$dataToSave['number_of_test_ft2']=addslashes(json_encode($os->post('number_of_test_ft2'))); 
		$dataToSave['number_of_test_ft3']=addslashes(json_encode($os->post('number_of_test_ft3'))); 
		$dataToSave['number_of_test_ft4']=addslashes(json_encode($os->post('number_of_test_ft4'))); 
		$dataToSave['number_of_test_fmt']=addslashes(json_encode($os->post('number_of_test_fmt')));
		$dataToSave['mocktest_type']=addslashes(json_encode($os->post('mocktest_type'))); 

		if($rowId < 1){
			$dataToSave['entry_date']=$os->now(); 
			$dataToSave['entry_by_admin_id']=$os->userDetails['adminId'];
			$dataToSave['addedDate']=$os->now();
			$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		$qResult=$os->saveTable($primeryTable,$dataToSave,$primeryField,$rowId);
		if($qResult){
			$document_a=$os->post('doc');
			if(is_array($document_a)&&count($document_a)>0){				
				$dataToSave3['monthly_academic_audit_xii_id']=$qResult;				
				$dataToSave3['addedBy']=$os->userDetails['adminId'];
				$dataToSave3['addedDate']=$os->now();				
				foreach ($document_a as  $value) {
					$dataToSave3['location']=$value['location'];					
					$dataToSave3['file_link']=$value['file_link'];
					$dataToSave3['doc_name']=$value['doc_name'];
					$os->saveTable("academic_audit_doc", $dataToSave3);
				}
			}
		}
		$flashMsg=($rowId)?'Record Updated Successfully':'Record Added Successfully';
		$os->flashMessage($primeryTable,$flashMsg);
		$os->redirect($os->post('redirectLink'));
	  #---- edit section end ----#
	}	
}


$pageData='';
if($editRowId){
	$os->data=$os->rowByField('',$primeryTable,$primeryField,$editRowId);
	$number_of_classes=json_decode($os->getVal('number_of_classes'), TRUE);
	$number_of_supervission_classes=json_decode($os->getVal('number_of_supervission_classes'), TRUE);
	$number_of_practical_classes=json_decode($os->getVal('number_of_practical_classes'), TRUE);
	$number_of_special_classes=json_decode($os->getVal('number_of_special_classes'), TRUE);
	$number_of_neet_classes=json_decode($os->getVal('number_of_neet_classes'), TRUE);
	$number_of_mock_test=json_decode($os->getVal('number_of_mock_test'), TRUE);
	$motivational_programme=json_decode($os->getVal('motivational_programme'), TRUE);
	
	$number_of_test_classtest=json_decode($os->getVal('number_of_test_classtest'), TRUE);
	$number_of_test_dpt=json_decode($os->getVal('number_of_test_dpt'), TRUE);
	$number_of_test_ft1=json_decode($os->getVal('number_of_test_ft1'), TRUE);
	$number_of_test_ft2=json_decode($os->getVal('number_of_test_ft2'), TRUE);
	$number_of_test_ft3=json_decode($os->getVal('number_of_test_ft3'), TRUE);
	$number_of_test_ft4=json_decode($os->getVal('number_of_test_ft4'), TRUE);	
	$number_of_test_fmt=json_decode($os->getVal('number_of_test_fmt'), TRUE);
	$mocktest_type=json_decode($os->getVal('mocktest_type'), TRUE);
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
						
						<div style=" width:900px; margin:auto">

							<table width="60%" border="0" class="formClass"   >


								<tr >
									<td>Year </td>
									<td>  

										<select name="year" id="year" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										$os->onlyOption($os->examYear,$os->getVal('year'));?></select>	 </td>						

										<td>Month </td>
										<td>  

											<select name="month" id="month" class="textbox fWidth" ><option value="">Select Month</option>	<? 
											$os->onlyOption($os->rentMonth,$os->getVal('month'));?></select>	 </td>						

											<td>Branch </td>
											<td> <select name="branch_code" id="branch_code" class="textbox fWidth select2"  >
												<option value="">All Branch</option>
												<? $os->onlyOption($branch_code_arr,$os->getVal('branch_code'));	?>
											</select></td>						
										</tr>

										<tr style="display:none;" >
											<td>Date </td>
											<td colspan="10"><input value="<?php  echo $os->showDate( $os->getVal('dated'));?>" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr>




									</table>	

									<div class="head_style" > Number of classes held: </div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_classes[xi_mathematics]" value="<?php echo $number_of_classes['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_classes[xi_physics]" value="<?php echo $number_of_classes['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_classes[xi_chemistry]" value="<?php echo $number_of_classes['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_classes[xi_biology]" value="<?php echo $number_of_classes['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_classes[xii_mathematics]" value="<?php echo $number_of_classes['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_classes[xii_physics]" value="<?php echo $number_of_classes['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_classes[xii_chemistry]" value="<?php echo $number_of_classes['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_classes[xii_biology]" value="<?php echo $number_of_classes['xii_biology'] ?>">
											</td>
										</tr>
									</table>

									<div class="head_style" >Number of Supervision Classes Held: </div>			
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xi_mathematics]" value="<?php echo $number_of_supervission_classes['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xi_physics]" value="<?php echo $number_of_supervission_classes['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xi_chemistry]" value="<?php echo $number_of_supervission_classes['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xi_biology]" value="<?php echo $number_of_supervission_classes['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xii_mathematics]" value="<?php echo $number_of_supervission_classes['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xii_physics]" value="<?php echo $number_of_supervission_classes['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xii_chemistry]" value="<?php echo $number_of_supervission_classes['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_supervission_classes[xii_biology]" value="<?php echo $number_of_supervission_classes['xii_biology'] ?>">
											</td>
										</tr>
									</table>		


									<div class="head_style" >Number of Practical Classes Held:</div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>

											<td>
												<input type="text" name="number_of_practical_classes[xi_physics]" value="<?php echo $number_of_practical_classes['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_practical_classes[xi_chemistry]" value="<?php echo $number_of_practical_classes['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_practical_classes[xi_biology]" value="<?php echo $number_of_practical_classes['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>

											<td>
												<input type="text" name="number_of_practical_classes[xii_physics]" value="<?php echo $number_of_practical_classes['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_practical_classes[xii_chemistry]" value="<?php echo $number_of_practical_classes['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_practical_classes[xii_biology]" value="<?php echo $number_of_practical_classes['xii_biology'] ?>">
											</td>
										</tr>
									</table>

									<div class="head_style" >Number of Special Classes Held:</div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>

											<td>
												<input type="text" name="number_of_special_classes[xi_physics]" value="<?php echo $number_of_special_classes['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_special_classes[xi_chemistry]" value="<?php echo $number_of_special_classes['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_special_classes[xi_biology]" value="<?php echo $number_of_special_classes['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>

											<td>
												<input type="text" name="number_of_special_classes[xii_physics]" value="<?php echo $number_of_special_classes['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_special_classes[xii_chemistry]" value="<?php echo $number_of_special_classes['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_special_classes[xii_biology]" value="<?php echo $number_of_special_classes['xii_biology'] ?>">
											</td>
										</tr>
									</table>

									<div class="head_style" >Number of NEET Classes Held: </div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>

											<td>
												<input type="text" name="number_of_neet_classes[xi_physics]" value="<?php echo $number_of_neet_classes['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_neet_classes[xi_chemistry]" value="<?php echo $number_of_neet_classes['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_neet_classes[xi_biology]" value="<?php echo $number_of_neet_classes['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>

											<td>
												<input type="text" name="number_of_neet_classes[xii_physics]" value="<?php echo $number_of_neet_classes['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_neet_classes[xii_chemistry]" value="<?php echo $number_of_neet_classes['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_neet_classes[xii_biology]" value="<?php echo $number_of_neet_classes['xii_biology'] ?>">
											</td>
										</tr>
									</table>

									<div class="head_style" style="display: none;">Number of Test / Mock Test Taken: </div>

									<table class="uk-table uk-table-small listTable" style="display: none;">
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_mock_test[xi_mathematics]" value="<?php echo $number_of_mock_test['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_mock_test[xi_physics]" value="<?php echo $number_of_mock_test['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_mock_test[xi_chemistry]" value="<?php echo $number_of_mock_test['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_mock_test[xi_biology]" value="<?php echo $number_of_mock_test['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_mock_test[xii_mathematics]" value="<?php echo $number_of_mock_test['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_mock_test[xii_physics]" value="<?php echo $number_of_mock_test['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_mock_test[xii_chemistry]" value="<?php echo $number_of_mock_test['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_mock_test[xii_biology]" value="<?php echo $number_of_mock_test['xii_biology'] ?>">
											</td>
										</tr>
									</table>
									<div class="head_style" >Mocktest Type</div>
									<table class="uk-table uk-table-small listTable">
										<tr>
											<td>
												<strong>Class Test</strong><br><input type="checkbox" 
												onclick='$(this).val(this.checked ? "TRUE" : "FALSE");(this.checked)?$(".number_of_test_classtest_chk").show():$(".number_of_test_classtest_chk").hide()'  name="mocktest_type[number_of_test_classtest_chk]" <?php echo isset($mocktest_type['number_of_test_classtest_chk'])?"checked":""?>>
											</td>
											<td>
												<strong>DPT Test</strong><br><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");(this.checked)?$(".number_of_test_dpt_chk").show():$(".number_of_test_dpt_chk").hide()'  name="mocktest_type[number_of_test_dpt_chk]" <?php echo isset($mocktest_type['number_of_test_dpt_chk'])?"checked":""?>>
											</td>
											<td>
												<strong>FT1 Test</strong><br><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");(this.checked)?$(".number_of_test_ft1_chk").show():$(".number_of_test_ft1_chk").hide()'  name="mocktest_type[number_of_test_ft1_chk]" <?php echo isset($mocktest_type['number_of_test_ft1_chk'])?"checked":""?>>
											</td>
											<td>
												<strong>FT2 Test</strong> <br><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");(this.checked)?$(".number_of_test_ft2_chk").show():$(".number_of_test_ft2_chk").hide()'  name="mocktest_type[number_of_test_ft2_chk]" <?php echo isset($mocktest_type['number_of_test_ft2_chk'])?"checked":""?>>
											</td>
											<td>
												<strong>FT3 Test</strong><br><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");(this.checked)?$(".number_of_test_ft3_chk").show():$(".number_of_test_ft3_chk").hide()'  name="mocktest_type[number_of_test_ft3_chk]" <?php echo isset($mocktest_type['number_of_test_ft3_chk'])?"checked":""?>>
											</td>
											<td>
												<strong>FT4 Test</strong><br><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");(this.checked)?$(".number_of_test_ft4_chk").show():$(".number_of_test_ft4_chk").hide()'  name="mocktest_type[number_of_test_ft4_chk]" <?php echo isset($mocktest_type['number_of_test_ft4_chk'])?"checked":""?>>
											</td>
											<td>
												<strong>FMT Test</strong><br><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");(this.checked)?$(".number_of_test_fmt_chk").show():$(".number_of_test_fmt_chk").hide()'  name="mocktest_type[number_of_test_fmt_chk]" <?php echo isset($mocktest_type['number_of_test_fmt_chk'])?"checked":""?>>
											</td>
										</tr>
									</table>

									<div class="head_style number_of_test_classtest_chk" <?php echo isset($mocktest_type['number_of_test_classtest_chk'])?"":"style='display:none;'"?> >Number of class test: </div>
									<table class="uk-table uk-table-small listTable number_of_test_classtest_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_classtest_chk'])?"":"style='display:none;'"?>>
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_test_classtest[xi_mathematics]" value="<?php echo $number_of_test_classtest['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_classtest[xi_physics]" value="<?php echo $number_of_test_classtest['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_classtest[xi_chemistry]" value="<?php echo $number_of_test_classtest['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_classtest[xi_biology]" value="<?php echo $number_of_test_classtest['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_test_classtest[xii_mathematics]" value="<?php echo $number_of_test_classtest['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_classtest[xii_physics]" value="<?php echo $number_of_test_classtest['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_classtest[xii_chemistry]" value="<?php echo $number_of_test_classtest['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_classtest[xii_biology]" value="<?php echo $number_of_test_classtest['xii_biology'] ?>">
											</td>
										</tr>
									</table>

									<div class="head_style number_of_test_dpt_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_dpt_chk'])?"":"style='display:none;'"?>>Number of DPT test: </div>
									<table class="uk-table uk-table-small listTable number_of_test_dpt_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_dpt_chk'])?"":"style='display:none;'"?>>
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_test_dpt[xi_mathematics]" value="<?php echo $number_of_test_dpt['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_dpt[xi_physics]" value="<?php echo $number_of_test_dpt['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_dpt[xi_chemistry]" value="<?php echo $number_of_test_dpt['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_dpt[xi_biology]" value="<?php echo $number_of_test_dpt['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_test_dpt[xii_mathematics]" value="<?php echo $number_of_test_dpt['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_dpt[xii_physics]" value="<?php echo $number_of_test_dpt['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_dpt[xii_chemistry]" value="<?php echo $number_of_test_dpt['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_dpt[xii_biology]" value="<?php echo $number_of_test_dpt['xii_biology'] ?>">
											</td>
										</tr>
									</table>
									<div class="head_style number_of_test_ft1_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft1_chk'])?"":"style='display:none;'"?>>Number of FT1 test: </div>
									<table class="uk-table uk-table-small listTable number_of_test_ft1_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft1_chk'])?"":"style='display:none;'"?>>
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_test_ft1[xi_mathematics]" value="<?php echo $number_of_test_ft1['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft1[xi_physics]" value="<?php echo $number_of_test_ft1['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft1[xi_chemistry]" value="<?php echo $number_of_test_ft1['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft1[xi_biology]" value="<?php echo $number_of_test_ft1['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_test_ft1[xii_mathematics]" value="<?php echo $number_of_test_ft1['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft1[xii_physics]" value="<?php echo $number_of_test_ft1['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft1[xii_chemistry]" value="<?php echo $number_of_test_ft1['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft1[xii_biology]" value="<?php echo $number_of_test_ft1['xii_biology'] ?>">
											</td>
										</tr>
									</table>
									<div class="head_style number_of_test_ft2_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft2_chk'])?"":"style='display:none;'"?>>Number of FT2 test: </div>
									<table class="uk-table uk-table-small listTable number_of_test_ft2_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft2_chk'])?"":"style='display:none;'"?>>
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_test_ft2[xi_mathematics]" value="<?php echo $number_of_test_ft2['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft2[xi_physics]" value="<?php echo $number_of_test_ft2['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft2[xi_chemistry]" value="<?php echo $number_of_test_ft2['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft2[xi_biology]" value="<?php echo $number_of_test_ft2['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_test_ft2[xii_mathematics]" value="<?php echo $number_of_test_ft2['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft2[xii_physics]" value="<?php echo $number_of_test_ft2['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft2[xii_chemistry]" value="<?php echo $number_of_test_ft2['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft2[xii_biology]" value="<?php echo $number_of_test_ft2['xii_biology'] ?>">
											</td>
										</tr>
									</table>
									<div class="head_style number_of_test_ft3_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft3_chk'])?"":"style='display:none;'"?>>Number of FT3 test: </div>
									<table class="uk-table uk-table-small listTable number_of_test_ft3_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft3_chk'])?"":"style='display:none;'"?>>
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_test_ft3[xi_mathematics]" value="<?php echo $number_of_test_ft3['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft3[xi_physics]" value="<?php echo $number_of_test_ft3['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft3[xi_chemistry]" value="<?php echo $number_of_test_ft3['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft3[xi_biology]" value="<?php echo $number_of_test_ft3['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_test_ft3[xii_mathematics]" value="<?php echo $number_of_test_ft3['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft3[xii_physics]" value="<?php echo $number_of_test_ft3['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft3[xii_chemistry]" value="<?php echo $number_of_test_ft3['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft3[xii_biology]" value="<?php echo $number_of_test_ft3['xii_biology'] ?>">
											</td>
										</tr>
									</table>
									<div class="head_style number_of_test_ft4_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft4_chk'])?"":"style='display:none;'"?>>Number of FT4 test: </div>
									<table class="uk-table uk-table-small listTable number_of_test_ft4_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_ft4_chk'])?"":"style='display:none;'"?>>
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_test_ft4[xi_mathematics]" value="<?php echo $number_of_test_ft4['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft4[xi_physics]" value="<?php echo $number_of_test_ft4['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft4[xi_chemistry]" value="<?php echo $number_of_test_ft4['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft4[xi_biology]" value="<?php echo $number_of_test_ft4['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_test_ft4[xii_mathematics]" value="<?php echo $number_of_test_ft4['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft4[xii_physics]" value="<?php echo $number_of_test_ft4['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft4[xii_chemistry]" value="<?php echo $number_of_test_ft4['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_ft4[xii_biology]" value="<?php echo $number_of_test_ft4['xii_biology'] ?>">
											</td>
										</tr>
									</table>
									<div class="head_style number_of_test_fmt_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_fmt_chk'])?"":"style='display:none;'"?>>Number of FMT test: </div>
									<table class="uk-table uk-table-small listTable number_of_test_fmt_chk number_of_test_cls" <?php echo isset($mocktest_type['number_of_test_fmt_chk'])?"":"style='display:none;'"?>>
										<tr class="borderTitle">
											<td rowspan="2">Class</td>
											<td colspan="4">Subject</td>
										</tr>
										<tr class="borderTitle">
											<td>Mathematics</td>
											<td>Physics</td>
											<td>Chemistry</td>
											<td>Biology</td>
										</tr>
										<tr>
											<td>XI</td>
											<td>
												<input type="text" name="number_of_test_fmt[xi_mathematics]" value="<?php echo $number_of_test_fmt['xi_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_fmt[xi_physics]" value="<?php echo $number_of_test_fmt['xi_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_fmt[xi_chemistry]" value="<?php echo $number_of_test_fmt['xi_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_fmt[xi_biology]" value="<?php echo $number_of_test_fmt['xi_biology'] ?>">
											</td>
										</tr>
										<tr>
											<td>XII</td>
											<td>
												<input type="text" name="number_of_test_fmt[xii_mathematics]" value="<?php echo $number_of_test_fmt['xii_mathematics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_fmt[xii_physics]" value="<?php echo $number_of_test_fmt['xii_physics'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_fmt[xii_chemistry]" value="<?php echo $number_of_test_fmt['xii_chemistry'] ?>">
											</td>
											<td>
												<input type="text" name="number_of_test_fmt[xii_biology]" value="<?php echo $number_of_test_fmt['xii_biology'] ?>">
											</td>
										</tr>
									</table>

									<div class="head_style" >Name of the  Co-curricular Activities Observed in This Month: 
									</div>

									<div style="border:1px solid #666666;   width:600px; margin:auto; padding:10px;" >
										<textarea  name="co_curricular_activity" id="co_curricular_activity" class="uk-textarea"><?php echo $os->getVal('co_curricular_activity') ?></textarea>
									</div>
									<!-- Co-curricular Activities Upload doc -->
									<div class="head_style" >Upload Co-curricular Activities  Photos/Documents </div>
									<table class="uk-table uk-table-small listTable">
										<tr>
											<td>
												<table class="uk-width-1-1" style="border-collapse: collapse">
													<tfoot>
														<tr>
															<td class="uk-table-shrink">
																<input type="file" name="image_1" id="image_1"
																onchange="$('#image_name_1').html(this.value!==``?this.value.replace('C:\\fakepath\\', ''):'Select Document')" style="display:none;"/>

																<button onclick="$('#image_1').trigger('click')"
																style="width: 130px; overflow-x: hidden"
																class="uk-button uk-button-small  uk-button-default uk-text-nowrap" id="image_name_1" type="button">Select Document</button>
															</td>
															<td>
																<input value="" type="text" name="image_doc_title_1" id="image_doc_title_1" class="uk-input uk-form-small form-field" placeholder="Document title"/>
															</td>

															<td class="uk-table-shrink " style="padding-left: 10px">
																<button onclick="if($('#image_1').val()===''){alert('please select file');return false;};
																if($('#image_doc_title_1').val()===''){alert('please put documnt title');return false;};
																if(confirm('Are you sure?')){upload_doc('image_1','image_doc_title_1','image_name_1','Co-curricular activities','uploaded_doc_div_1');} " class="uk-button uk-button-small  uk-button-primary uk-text-nowrap" type="button">Upload</button>
															</td>
														</tr>
													</tfoot>
												</table>
											</td>
											<td>
												<span>Documents</span>
												<table class="uk-table-justify  uk-margin-small-bottom uk-margin-small-top uk-width-1-1 uk-table-divider" style="border-collapse: collapse">
													<tbody id="uploaded_doc_div_1">

													</tbody>
												</table>
											</td>
										</tr>
									</table>
									<?php 
									$academic_audit_doc_data=array();
									$academic_audit_doc_q="SELECT * FROM academic_audit_doc where monthly_academic_audit_xii_id='$editRowId' and location='Co-curricular activities'";
									$academic_audit_doc_mq=$os->mq($academic_audit_doc_q);
									while($data=$os->mfa($academic_audit_doc_mq)){
										$academic_audit_doc_data[]=$data;
									}
									if(count($academic_audit_doc_data)){
										?>
										<div class="head_style" >Co-curricular Activities Photos/Documents </div>
										<table class="uk-table uk-table-small listTable">
											<?php foreach($academic_audit_doc_data as $academic_audit_doc_val){?>
												<tr >
													<td >
														<a href="<?php echo $site['url'].$academic_audit_doc_val['file_link']?>" target="_blank"><?php echo $academic_audit_doc_val['doc_name']?></a>
														<span style="margin-left:25px;"><a style="color: red" href="javascript:void(0)" uk-icon="close" onclick="delete_doc('<?php echo $academic_audit_doc_val["academic_audit_doc_id"]?>')"></a></span>
													</td>
												</tr>
												<?}?>
											</table>
											<?}?>

											<!-- Co-curricular Activities Upload doc -->


											<div class="head_style" >Name of the  Cultural Programs Observed in this Month:</div>
											<div style="border:1px solid #666666;   width:600px; margin:auto;padding:10px;" >
												<textarea  name="cultural_programme" id="cultural_programme" class="uk-textarea"><?php echo $os->getVal('cultural_programme') ?></textarea>
											</div>
											<!-- Doc Upload Area -->
											<div class="head_style" >Upload Cultural Programs Photos/Documents </div>
											<table class="uk-table uk-table-small listTable">
												<tr>
													<td>
														<table class="uk-width-1-1" style="border-collapse: collapse">
															<tfoot>
																<tr>
																	<td class="uk-table-shrink">
																		<input type="file" name="image_2" id="image_2"
																		onchange="$('#image_name_2').html(this.value!==``?this.value.replace('C:\\fakepath\\', ''):'Select Document')" style="display:none;"/>

																		<button onclick="$('#image_2').trigger('click')"
																		style="width: 130px; overflow-x: hidden"
																		class="uk-button uk-button-small  uk-button-default uk-text-nowrap" id="image_name_2" type="button">Select Document</button>
																	</td>
																	<td>
																		<input value="" type="text" name="image_doc_title_2" id="image_doc_title_2" class="uk-input uk-form-small form-field" placeholder="Document title"/>
																	</td>

																	<td class="uk-table-shrink " style="padding-left: 10px">
																		<button onclick="if($('#image_2').val()===''){alert('please select file');return false;};
																		if($('#image_doc_title_2').val()===''){alert('please put documnt title');return false;};
																		if(confirm('Are you sure?')){upload_doc('image_2','image_doc_title_2','image_name_2','Cultural programs','uploaded_doc_div_2');} " class="uk-button uk-button-small  uk-button-primary uk-text-nowrap" type="button">Upload</button>
																	</td>
																</tr>
															</tfoot>
														</table>
													</td>
													<td>
														<span>Documents</span>
														<table class="uk-table-justify  uk-margin-small-bottom uk-margin-small-top uk-width-1-1 uk-table-divider" style="border-collapse: collapse">
															<tbody id="uploaded_doc_div_2">

															</tbody>
														</table>
													</td>
												</tr>
											</table>
											<?php 
											$academic_audit_doc_data=array();
											$academic_audit_doc_q="SELECT * FROM academic_audit_doc where monthly_academic_audit_xii_id='$editRowId' and location='Cultural programs'";
											$academic_audit_doc_mq=$os->mq($academic_audit_doc_q);
											while($data=$os->mfa($academic_audit_doc_mq)){
												$academic_audit_doc_data[]=$data;
											}
											if(count($academic_audit_doc_data)){
												?>
												<div class="head_style" >Cultural Programs  Photos/Documents </div>
												<table class="uk-table uk-table-small listTable">
													<?php foreach($academic_audit_doc_data as $academic_audit_doc_val){?>
														<tr >
															<td >
																<a href="<?php echo $site['url'].$academic_audit_doc_val['file_link']?>" target="_blank"><?php echo $academic_audit_doc_val['doc_name']?></a>
																<span style="margin-left:25px;"><a style="color: red" href="javascript:void(0)" uk-icon="close" onclick="delete_doc('<?php echo $academic_audit_doc_val["academic_audit_doc_id"]?>')"></a></span>
															</td>
														</tr>
														<?}?>
													</table>
													<?}?>
													<!-- End Upload Doc area -->	
													<div class="head_style" >Number of Motivational Programs and Counselling Done: </div>	
													<table class="uk-table uk-table-small listTable">
														<tr class="borderTitle">
															<td>Class</td>
															<td>Motivational programs</td>
															<td>Counselling</td>
														</tr>
														<tr>
															<td>XI</td>				
															<td>
																<input type="text" name="motivational_programme[xi_motivational_programs]" value="<?php echo $motivational_programme['xi_motivational_programs'] ?>">
															</td>
															<td>
																<input type="text" name="motivational_programme[xi_counsilling]" value="<?php echo $motivational_programme['xi_counsilling'] ?>">
															</td>
														</tr>
														<tr>
															<td>XII</td>

															<td>
																<input type="text" name="motivational_programme[xii_motivational_programs]" value="<?php echo $motivational_programme['xii_motivational_programs'] ?>">
															</td>
															<td>
																<input type="text" name="motivational_programme[xii_counsilling]" value="<?php echo $motivational_programme['xii_counsilling'] ?>">
															</td>
														</tr>
													</table>

													<table width="60%" border="0" class="formClass"   >


														<tr style="display:none;">
															<td>Entry date </td>
															<td><input value="<?php  echo $os->showDate( $os->getVal('entry_date'));?>" type="text" name="entry_date" id="entry_date" class="wtDateClass textbox fWidth"/></td>						
														</tr><tr style="display:none;">
															<td>Entry by admin id </td>
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

							<script>
								function submitFormData(){
									os.submitForm('submitFormDataId');
								}
								function upload_doc(img_fld_name,image_title_fld_name,upload_btn_name,img_location,img_upload_div_name){
									var formdata = new FormData();
												var imageVal= os.getObj(img_fld_name).files[0];												
												if(!imageVal){
													return false;
												}
												if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
												formdata.append('doc_title',os.getVal(image_title_fld_name));
												formdata.append('location',img_location);	

												formdata.append('img_fld_name',img_fld_name);
												formdata.append('image_title_fld_name',image_title_fld_name);
												formdata.append('img_upload_div_name',img_upload_div_name);
												formdata.append('upload_btn_name',upload_btn_name);

												formdata.append('upload_doc','OKS');
												var url='<? echo $ajaxFilePath ?>?upload_doc=OK&';
												os.animateMe.div='div_busy';
												os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
												os.setAjaxFunc('img_reload_list',url,formdata);
											}
											function img_reload_list(data){
												var d=data.split('##');
												$('#'+d[0]).val(''); 
												$('#'+d[1]).val('');
												$('#'+d[2]).html('Select Document');
												$("#"+d[3]).append(d[4].trim());
											}
											function delete_doc(academic_audit_doc_id){
												var formdata = new FormData();
												if(parseInt(academic_audit_doc_id)<1){ alert('No record Selected'); return;}
												var p =confirm('Are you Sure? You want to delete this record forever.')
												if(p){
													formdata.append('academic_audit_doc_id',academic_audit_doc_id );
													var url='<? echo $ajaxFilePath ?>?delete_doc=OK&';
													os.animateMe.div='div_busy';
													os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
													os.setAjaxFunc('delete_doc_result',url,formdata);
												}
											}
											function delete_doc_result(data) {
												alert(data);
												location.reload();
											}
										</script>

										<? include($site['root-wtos'].'bottom.php'); ?>
