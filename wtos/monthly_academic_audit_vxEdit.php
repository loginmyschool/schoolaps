<?
/*
   # wtos version : 1.1
   # List Page : monthly_academic_audit_vxList.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$ajaxFilePath= 'upload_academic_audit_vx_ajax.php';
?><?

$editPage='monthly_academic_audit_vxEdit.php';
$listPage='monthly_academic_audit_vxList.php';
$primeryTable='monthly_academic_audit_vx';
$primeryField='monthly_academic_audit_vx_id';
$pageHeader='Add Monthly academic audit V To X';
$editPageLink=$os->pluginLink($pluginName).$editPage.'?'.$os->addParams(array(),array()).'editRowId=';
$listPageLink=$os->pluginLink($pluginName).$listPage.'?'.$os->addParams(array(),array());
$tmpVar='';
$editRowId=$os->get('editRowId');
if($editRowId){
	$pageHeader='Edit  Monthly academic audit V To X';
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
		// _d($os->post('non_scolastic_data'));
		// echo json_encode($os->post('non_scolastic_data'));
		// die;
		$dataToSave['non_scolastic_data']=addslashes(json_encode($os->post('non_scolastic_data'))); 
		$dataToSave['reading_skill_test']=addslashes(json_encode($os->post('reading_skill_test')));
		$dataToSave['co_curricular_activity']=addslashes($os->post('co_curricular_activity')); 
		$dataToSave['cultural_programme']=addslashes($os->post('cultural_programme'));
		$dataToSave['motivational_programme']=addslashes(json_encode($os->post('motivational_programme')));
		$dataToSave['parent_teacher_meeting']=addslashes(json_encode($os->post('parent_teacher_meeting')));
		$dataToSave['meeting_with_student']=addslashes(json_encode($os->post('meeting_with_student')));
		$dataToSave['no_of_foundation_class_for_viii']=addslashes(json_encode($os->post('no_of_foundation_class_for_viii'))); 
		$dataToSave['no_of_foundation_class_for_ix']=addslashes(json_encode($os->post('no_of_foundation_class_for_ix')));
		$dataToSave['magazine_was_published']=addslashes($os->post('magazine_was_published'));
		$dataToSave['branch_code']=addslashes($os->post('branch_code')); 
		
		if($rowId < 1){
			$dataToSave['entry_date']=$os->saveDate($os->now()); 
			$dataToSave['entry_by_admin_id']=addslashes($os->userDetails['adminId']); 
			$dataToSave['addedDate']=$os->now();
			$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		$qResult=$os->saveTable($primeryTable,$dataToSave,$primeryField,$rowId);
		if($qResult){
			$document_a=$os->post('doc');
			if(is_array($document_a)&&count($document_a)>0){				
				$dataToSave3['monthly_academic_audit_vx_id']=$qResult;				
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
	$non_scolastic_data=json_decode($os->getVal('non_scolastic_data'), TRUE);
	$reading_skill_test=json_decode($os->getVal('reading_skill_test'), TRUE);
	$motivational_programme=json_decode($os->getVal('motivational_programme'), TRUE);
	$parent_teacher_meeting=json_decode($os->getVal('parent_teacher_meeting'), TRUE);
	$meeting_with_student=json_decode($os->getVal('meeting_with_student'), TRUE);
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
						
						<div style=" width:900px; margin:auto;">

							<table width="100%" border="0" class="formClass"    >							
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
											</select> </td>						
										</tr>


										<tr style="display:none;" >
											<td>Date </td>
											<td colspan="20"><input value="<?php  echo $os->showDate( $os->getVal('dated'));?>" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr>



									</table>
									
									
								</div>			
								<div style=" width:900px; margin:auto;">
									<div class="head_style" > Non-Scholastic Data (class wise):</div>
									<table class="uk-table uk-table-small listTable">
										<tr class="borderTitle">
											<td>Class</td>
											<td>Once</td>
											<td>Twice</td>
											<td>Not done</td>
											<td style="width: 200px;">Date</td>
										</tr>
										<tr>
											<td>V</td>
											<td>
												<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[v_once]" <?php echo isset($non_scolastic_data['v_once'])?"checked":""?>>
											</td>
											<td>
												<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[v_twice]" <?php echo isset($non_scolastic_data['v_twice'])?"checked":""?>>
											</td>
											<td>
												<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[v_not_done]" <?php echo isset($non_scolastic_data['v_not_done'])?"checked":""?>></td>
												<td>
													<input value="<?php  echo $os->showDate( $non_scolastic_data['v_dated']);?>" type="text" name="non_scolastic_data[v_dated]"  class="wtDateClass textbox fWidth"/>
												</td>
											</tr>
											<tr>
												<td>VI</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[vi_once]" <?php echo isset($non_scolastic_data['vi_once'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[vi_twice]" <?php echo isset($non_scolastic_data['vi_twice'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[vi_not_done]" <?php echo isset($non_scolastic_data['vi_not_done'])?"checked":""?>>
												</td>
												<td><input value="<?php  echo $os->showDate( $non_scolastic_data['vi_dated']);?>" type="text" name="non_scolastic_data[vi_dated]"  class="wtDateClass textbox fWidth"/>
												</td>
											</tr>
											<tr>
												<td>VII</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[vii_once]" <?php echo isset($non_scolastic_data['vii_once'])?"checked":""?>>
												</td>
												<td>														
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[vii_twice]" <?php echo isset($non_scolastic_data['vii_twice'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[vii_not_done]" <?php echo isset($non_scolastic_data['vii_not_done'])?"checked":""?>>
												</td>
												<td>
													<input value="<?php  echo $os->showDate( $non_scolastic_data['vii_dated']);?>" type="text" name="non_scolastic_data[vii_dated]"  class="wtDateClass textbox fWidth"/>
												</td>
											</tr>
											<tr>
												<td>VIII</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[viii_once]" <?php echo isset($non_scolastic_data['viii_once'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[viii_twice]" <?php echo isset($non_scolastic_data['viii_twice'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[viii_not_done]" <?php echo isset($non_scolastic_data['viii_not_done'])?"checked":""?>>
												</td>
												<td><input value="<?php  echo $os->showDate( $non_scolastic_data['viii_dated']);?>" type="text" name="non_scolastic_data[viii_dated]"  class="wtDateClass textbox fWidth"/></td>
											</tr>
											<tr>
												<td>IX</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[ix_once]" <?php echo isset($non_scolastic_data['ix_once'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[ix_twice]" <?php echo isset($non_scolastic_data['ix_twice'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[ix_not_done]" <?php echo isset($non_scolastic_data['ix_not_done'])?"checked":""?>>
												</td>
												<td>
													<input value="<?php  echo $os->showDate( $non_scolastic_data['ix_dated']);?>" type="text" name="non_scolastic_data[ix_dated]"  class="wtDateClass textbox fWidth"/>

												</td>
											</tr>
											<tr>
												<td>X</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[x_once]" <?php echo isset($non_scolastic_data['x_once'])?"checked":""?>>
												</td>
												<td>
													<input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[x_twice]" <?php echo isset($non_scolastic_data['x_twice'])?"checked":""?>>
												</td>
												<td><input type="checkbox" onclick='$(this).val(this.checked ? "TRUE" : "FALSE");'  name="non_scolastic_data[x_not_done]" <?php echo isset($non_scolastic_data['x_not_done'])?"checked":""?>></td>
												<td>
													<input value="<?php  echo $os->showDate( $non_scolastic_data['x_dated']);?>" type="text" name="non_scolastic_data[x_dated]"  class="wtDateClass textbox fWidth"/></td>
												</tr>
											</table>
											
											<div class="head_style" > How Many Times Reading Skill Testing was Done? </div>
											<table class="uk-table uk-table-small listTable">
												<tr class="borderTitle">
													<td>Class</td>
													<td>1st Lang</td>
													<td>2nd Lang</td>
													<td>3rd Lang</td>
													<td>Arabic</td>
												</tr>
												<tr>
													<td>V</td>
													<td><input type="text" name="reading_skill_test[v_1st_lang]" value="<?php echo $reading_skill_test['v_1st_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[v_2nd_lang]" value="<?php echo $reading_skill_test['v_2nd_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[v_3rd_lang]" value="<?php echo $reading_skill_test['v_3rd_lang'] ?>"></td>
													<td>
														<input value="<?php  echo $reading_skill_test['v_arabic'];?>" type="text" name="reading_skill_test[v_arabic]"  class="textbox fWidth"/>
													</td>
												</tr>
												<tr>
													<td>VI</td>
													<td><input type="text" name="reading_skill_test[vi_1st_lang]" value="<?php echo $reading_skill_test['vi_1st_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[vi_2nd_lang]" value="<?php echo $reading_skill_test['vi_2nd_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[vi_3rd_lang]" value="<?php echo $reading_skill_test['vi_3rd_lang'] ?>"></td>
													<td><input value="<?php  echo $reading_skill_test['vi_arabic'];?>" type="text" name="reading_skill_test[vi_arabic]"  class="textbox fWidth"/>
													</td>
												</tr>
												<tr>
													<td>VII</td>
													<td><input type="text" name="reading_skill_test[vii_1st_lang]" value="<?php echo $reading_skill_test['vii_1st_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[vii_2nd_lang]" value="<?php echo $reading_skill_test['vii_2nd_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[vii_3rd_lang]" value="<?php echo $reading_skill_test['vii_3rd_lang'] ?>"></td>
													<td>
														<input value="<?php  echo $reading_skill_test['vii_arabic'];?>" type="text" name="reading_skill_test[vii_arabic]"  class="textbox fWidth"/>
													</td>
												</tr>
												<tr>
													<td>VIII</td>
													<td><input type="text" name="reading_skill_test[viii_1st_lang]" value="<?php echo $reading_skill_test['viii_1st_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[viii_2nd_lang]" value="<?php echo $reading_skill_test['viii_2nd_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[viii_3rd_lang]" value="<?php echo $reading_skill_test['viii_3rd_lang'] ?>"></td>
													<td><input value="<?php  echo $reading_skill_test['viii_arabic'];?>" type="text" name="reading_skill_test[viii_arabic]"  class="textbox fWidth"/></td>
												</tr>
												<tr>
													<td>IX</td>
													<td><input type="text" name="reading_skill_test[ix_1st_lang]" value="<?php echo $reading_skill_test['ix_1st_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[ix_2nd_lang]" value="<?php echo $reading_skill_test['ix_2nd_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[ix_3rd_lang]" value="<?php echo $reading_skill_test['ix_3rd_lang'] ?>"></td>
													<td>
														<input value="<?php  echo $reading_skill_test['ix_arabic'];?>" type="text" name="reading_skill_test[ix_arabic]"  class="textbox fWidth"/>

													</td>
												</tr>
												<tr>
													<td>X</td>
													<td><input type="text" name="reading_skill_test[x_1st_lang]" value="<?php echo $reading_skill_test['x_1st_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[x_2nd_lang]" value="<?php echo $reading_skill_test['x_2nd_lang'] ?>"></td>
													<td><input type="text" name="reading_skill_test[x_3rd_lang]" value="<?php echo $reading_skill_test['x_3rd_lang'] ?>"></td>
													<td>
														<input value="<?php  echo $reading_skill_test['x_arabic'];?>" type="text" name="reading_skill_test[x_arabic]"  class="textbox fWidth"/></td>
													</tr>
												</table>
												<div class="head_style" >Number of Foundation classes for VIII</div>
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

												<div class="head_style" > Name of the  Co-curricular Activities Observed in this Month :   </div>
												<textarea  name="co_curricular_activity" id="co_curricular_activity" class="uk-textarea"><?php echo $os->getVal('co_curricular_activity') ?></textarea>

												<!-- doc upload area -->
												<div class="head_style" >Co-curricular Activities Upload Documents </div>
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
												$academic_audit_doc_q="SELECT * FROM academic_audit_doc where monthly_academic_audit_vx_id='$editRowId' and location='Co-curricular activities'";
												$academic_audit_doc_mq=$os->mq($academic_audit_doc_q);
												while($data=$os->mfa($academic_audit_doc_mq)){
													$academic_audit_doc_data[]=$data;
												}
												if(count($academic_audit_doc_data)){
													?>
													<div class="head_style" >Co-curricular Activities Uploaded Documents </div>
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

														<!--end doc upload area -->



														<div class="head_style" > ame of the  Cultural Programs Observed in this Month :  </div>
														<textarea  name="cultural_programme" id="cultural_programme" class="uk-textarea"><?php echo $os->getVal('cultural_programme') ?></textarea>
														<!-- Doc Upload Area -->
														<div class="head_style" >Cultural Programs Upload Documents </div>
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
														$academic_audit_doc_q="SELECT * FROM academic_audit_doc where monthly_academic_audit_vx_id='$editRowId' and location='Cultural programs'";
														$academic_audit_doc_mq=$os->mq($academic_audit_doc_q);
														while($data=$os->mfa($academic_audit_doc_mq)){
															$academic_audit_doc_data[]=$data;
														}
														if(count($academic_audit_doc_data)){
															?>
															<div class="head_style" >Cultural Programs Uploaded Documents </div>
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
																<div class="head_style" > NNumber of Motivational Programs and Counseling Done :   </div>
																<table class="uk-table uk-table-small listTable">
																	<tr class="borderTitle">
																		<td>Class</td>
																		<td>Motivational program</td>
																		<td>Counceling</td>
																	</tr>
																	<tr>
																		<td>V</td>
																		<td><input type="text" name="motivational_programme[v_motivational_programme]" value="<?php echo $motivational_programme['v_motivational_programme'] ?>"></td>
																		<td><input type="text" name="motivational_programme[v_counceling]" value="<?php echo $motivational_programme['v_counceling'] ?>"></td>

																	</tr>
																	<tr>
																		<td>VI</td>
																		<td><input type="text" name="motivational_programme[vi_motivational_programme]" value="<?php echo $motivational_programme['vi_motivational_programme'] ?>"></td>
																		<td><input type="text" name="motivational_programme[vi_counceling]" value="<?php echo $motivational_programme['vi_counceling'] ?>"></td>				
																	</tr>
																	<tr>
																		<td>VII</td>
																		<td><input type="text" name="motivational_programme[vii_motivational_programme]" value="<?php echo $motivational_programme['vii_motivational_programme'] ?>"></td>
																		<td><input type="text" name="motivational_programme[vii_counceling]" value="<?php echo $motivational_programme['vii_counceling'] ?>"></td>				
																	</tr>
																	<tr>
																		<td>VIII</td>
																		<td><input type="text" name="motivational_programme[viii_motivational_programme]" value="<?php echo $motivational_programme['viii_motivational_programme'] ?>"></td>
																		<td><input type="text" name="motivational_programme[viii_counceling]" value="<?php echo $motivational_programme['viii_counceling'] ?>"></td>

																	</tr>
																	<tr>
																		<td>IX</td>
																		<td><input type="text" name="motivational_programme[ix_motivational_programme]" value="<?php echo $motivational_programme['ix_motivational_programme'] ?>"></td>
																		<td><input type="text" name="motivational_programme[ix_counceling]" value="<?php echo $motivational_programme['ix_counceling'] ?>"></td>
																	</tr>
																	<tr>
																		<td>X</td>
																		<td><input type="text" name="motivational_programme[x_motivational_programme]" value="<?php echo $motivational_programme['x_motivational_programme'] ?>"></td>
																		<td><input type="text" name="motivational_programme[x_counceling]" value="<?php echo $motivational_programme['x_counceling'] ?>"></td>				
																	</tr>
																</table>

																<div class="head_style" > Parent- Teacher Meetings (class wise) ; </div>
																<table class="uk-table uk-table-small listTable">
																	<tr class="borderTitle">
																		<td>Class</td>
																		<td>Online</td>
																		<td>Offline</td>
																	</tr>
																	<tr>
																		<td>V</td>
																		<td><input type="text" name="parent_teacher_meeting[v_online]" value="<?php echo $parent_teacher_meeting['v_online'] ?>"></td>
																		<td><input type="text" name="parent_teacher_meeting[v_offline]" value="<?php echo $parent_teacher_meeting['v_offline'] ?>"></td>

																	</tr>
																	<tr>
																		<td>VI</td>
																		<td><input type="text" name="parent_teacher_meeting[vi_online]" value="<?php echo $parent_teacher_meeting['vi_online'] ?>"></td>
																		<td><input type="text" name="parent_teacher_meeting[vi_offline]" value="<?php echo $parent_teacher_meeting['vi_offline'] ?>"></td>				
																	</tr>
																	<tr>
																		<td>VII</td>
																		<td><input type="text" name="parent_teacher_meeting[vii_online]" value="<?php echo $parent_teacher_meeting['vii_online'] ?>"></td>
																		<td><input type="text" name="parent_teacher_meeting[vii_offline]" value="<?php echo $parent_teacher_meeting['vii_offline'] ?>"></td>				
																	</tr>
																	<tr>
																		<td>VIII</td>
																		<td><input type="text" name="parent_teacher_meeting[viii_online]" value="<?php echo $parent_teacher_meeting['viii_online'] ?>"></td>
																		<td><input type="text" name="parent_teacher_meeting[viii_offline]" value="<?php echo $parent_teacher_meeting['viii_offline'] ?>"></td>

																	</tr>
																	<tr>
																		<td>IX</td>
																		<td><input type="text" name="parent_teacher_meeting[ix_online]" value="<?php echo $parent_teacher_meeting['ix_online'] ?>"></td>
																		<td><input type="text" name="parent_teacher_meeting[ix_offline]" value="<?php echo $parent_teacher_meeting['ix_offline'] ?>"></td>
																	</tr>
																	<tr>
																		<td>X</td>
																		<td><input type="text" name="parent_teacher_meeting[x_online]" value="<?php echo $parent_teacher_meeting['x_online'] ?>"></td>
																		<td><input type="text" name="parent_teacher_meeting[x_offline]" value="<?php echo $parent_teacher_meeting['x_offline'] ?>"></td>				
																	</tr>
																</table>

																<div class="head_style" > Meeting With Students (class wise) </div>
																<table class="uk-table uk-table-small listTable">
																	<tr class="borderTitle">
																		<td>Class</td>
																		<td>Online</td>
																		<td>Offline</td>
																	</tr>
																	<tr>
																		<td>V</td>
																		<td><input type="text" name="meeting_with_student[v_online]" value="<?php echo $meeting_with_student['v_online'] ?>"></td>
																		<td><input type="text" name="meeting_with_student[v_offline]" value="<?php echo $meeting_with_student['v_offline'] ?>"></td>

																	</tr>
																	<tr>
																		<td>VI</td>
																		<td><input type="text" name="meeting_with_student[vi_online]" value="<?php echo $meeting_with_student['vi_online'] ?>"></td>
																		<td><input type="text" name="meeting_with_student[vi_offline]" value="<?php echo $meeting_with_student['vi_offline'] ?>"></td>				
																	</tr>
																	<tr>
																		<td>VII</td>
																		<td><input type="text" name="meeting_with_student[vii_online]" value="<?php echo $meeting_with_student['vii_online'] ?>"></td>
																		<td><input type="text" name="meeting_with_student[vii_offline]" value="<?php echo $meeting_with_student['vii_offline'] ?>"></td>				
																	</tr>
																	<tr>
																		<td>VIII</td>
																		<td><input type="text" name="meeting_with_student[viii_online]" value="<?php echo $meeting_with_student['viii_online'] ?>"></td>
																		<td><input type="text" name="meeting_with_student[viii_offline]" value="<?php echo $meeting_with_student['viii_offline'] ?>"></td>

																	</tr>
																	<tr>
																		<td>IX</td>
																		<td><input type="text" name="meeting_with_student[ix_online]" value="<?php echo $meeting_with_student['ix_online'] ?>"></td>
																		<td><input type="text" name="meeting_with_student[ix_offline]" value="<?php echo $meeting_with_student['ix_offline'] ?>"></td>
																	</tr>
																	<tr>
																		<td>X</td>
																		<td><input type="text" name="meeting_with_student[x_online]" value="<?php echo $meeting_with_student['x_online'] ?>"></td>
																		<td><input type="text" name="meeting_with_student[x_offline]" value="<?php echo $meeting_with_student['x_offline'] ?>"></td>				
																	</tr>
																</table>

																<div class="head_style" >Wall Magazine/ Magazine was Published :    </div>
																<div style="border:1px solid #666666; height:60px; width:600px; margin:auto; padding:10px;" >
																	<select name="magazine_was_published" id="magazine_was_published" class="textbox fWidth" ><option value=""></option>	<? 
																	$os->onlyOption($os->yesno,$os->getVal('magazine_was_published'));?></select>
																</div>
																<div class="head_style" >Wall Magazine Upload Documents </div>
																<table class="uk-table uk-table-small listTable">
																	<tr>
																		<td>
																			<table class="uk-width-1-1" style="border-collapse: collapse">
																				<tfoot>
																					<tr>
																						<td class="uk-table-shrink">
																							<input type="file" name="image" id="image"
																							onchange="$('#image_name').html(this.value!==``?this.value.replace('C:\\fakepath\\', ''):'Select Document')" style="display:none;"/>

																							<button onclick="$('#image').trigger('click')"
																							style="width: 130px; overflow-x: hidden"
																							class="uk-button uk-button-small  uk-button-default uk-text-nowrap" id="image_name" type="button">Select Document</button>
																						</td>
																						<td>
																							<input value="" type="text" name="image_doc_title" id="image_doc_title" class="uk-input uk-form-small form-field" placeholder="Document title"/>
																						</td>

																						<td class="uk-table-shrink " style="padding-left: 10px">
																							<button onclick="if($('#image').val()===''){alert('please select file');return false;};
																							if($('#image_doc_title').val()===''){alert('please put documnt title');return false;};
																							if(confirm('Are you sure?')){upload_doc('image','image_doc_title','image_name','Wall magazine','uploaded_doc_div');} " class="uk-button uk-button-small  uk-button-primary uk-text-nowrap" type="button">Upload</button>
																						</td>
																					</tr>
																				</tfoot>
																			</table>
																		</td>
																		<td>
																			<span>Documents</span>
																			<table class="uk-table-justify  uk-margin-small-bottom uk-margin-small-top uk-width-1-1 uk-table-divider" style="border-collapse: collapse">
																				<tbody id="uploaded_doc_div">

																				</tbody>
																			</table>
																		</td>
																	</tr>
																</table>
																<?php 
																$academic_audit_doc_data=array();
																$academic_audit_doc_q="SELECT * FROM academic_audit_doc where monthly_academic_audit_vx_id='$editRowId' and location='Wall magazine'";
																$academic_audit_doc_mq=$os->mq($academic_audit_doc_q);
																while($data=$os->mfa($academic_audit_doc_mq)){
																	$academic_audit_doc_data[]=$data;
																}
																if(count($academic_audit_doc_data)){
																	?>
																	<div class="head_style" >Wall magazine Uploaded Documents </div>
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
																	</div>

																	<table>
																		<tr style="display:none;">
																			<td>Entry date </td>
																			<td><input value="<?php  echo $os->showDate( $os->getVal('entry_date'));?>" type="text" name="entry_date" id="entry_date" class="wtDateClass textbox fWidth"/></td>						
																		</tr><tr style="display:none;">
																			<td>Entry by admin id </td>
																			<td><input value="<?php echo $os->getVal('entry_by_admin_id') ?>" type="text" name="entry_by_admin_id" id="entry_by_admin_id" class="textbox  fWidth "/> </td>						
																		</tr>
																	</table>
																</fieldset>




																<div style=" width:900px; margin:auto;">

																	<? if($os->access('wtEdit')){ ?> 	<input type="button" class="submit"  value="Save" onclick="submitFormData()" />	 <? } ?>	 
																	<input type="button" class="submit"  value="Back to List" onclick="javascript:window.location='<? echo $listPageLink ?>';" />	
																	<input type="hidden" name="redirectLink"  value="<? echo $os->server('HTTP_REFERER'); ?>" />
																	<input type="hidden" name="rowId" value="<?php   echo  $os->getVal($primeryField) ;?>" />
																	<input type="hidden" name="operation" value="updateField" />

																</div>	
															</form>
														</div>			  </td>
													</tr>
												</table>



												<script>
													function submitFormData(){
														os.submitForm('submitFormDataId');
													}
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
													function upload_doc(img_fld_name,image_title_fld_name,upload_btn_name,img_location,img_upload_div_name){
														var formdata = new FormData();
												// var imageVal= os.getObj('image').files[0];
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
										<style>
											.head_style{ text-align:center; font-size:16px; font-weight:bold; border:1px solid #999999; padding:5px 5px; width:300px; margin:auto; margin-top:20px; border-bottom:none;
												background-color:#FFFFFF;
											}
											.listTable{ margin:auto; max-width:600px; background-color:#FFFFFF;}
											.listTable td{ text-align:center; border-right:1px solid #CCCCCC;}
											.cFielSets{ background-color:#A6D2FF;}
										</style>

										<? include($site['root-wtos'].'bottom.php'); ?>
