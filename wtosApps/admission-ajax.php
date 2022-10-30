<? 
session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?><?
if($os->get('get_district_by_state_by_pin')=='OK' && $os->post('get_district_by_state_by_pin')=='OK'){
    $pin_id=$os->post('pin_id');
    $district_id=$os->post('district_id');
    $state_id=$os->post('state_id');

    $pin=$os->post('pin');
    $pin=trim($pin);
    $record=array();
    if($pin!=''){
        $dataQuery=" select * from post_code   where post_code='$pin' limit 1 ";
        $rsResults=$os->mq($dataQuery);
        $record=$os->mfa( $rsResults);
    }

    $district=$os->val($record,'district');
    $state=$os->val($record,'state');

    echo $district;echo '##';echo $district_id;
    echo '##'.$state;echo '##';echo $state_id;
    exit();
}
if($os->get('upload_doc')=='OK'&&$os->post('upload_doc')=='OKS'){
	$image=$os->UploadPhoto('image',$site['root'].'upload_document');
	$doc_title=$os->post('doc_title');
	$file_size = $_FILES['image']['size'];
	$file_type = $_FILES['image']['type'];
	if($image!=''){
		$img_link='upload_document/'.$image;}
		$rand_no=rand(1,10000);
		?>
		<tr id="con_<?echo $rand_no;?>">
			<td style="width:50px; padding: 3px 0">
				<?if(explode("/",$file_type)[0]=="image"){?>
					<img src="<?echo $site['url'].$img_link?>" style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #e5e5e5">
					<?} else { ?>
						<div class="uk-flex uk-flex-middle uk-flex-center" style="height: 35px; width: 35px; font-size: 11px; color: var(--color-primary-dark); background-color: #fafafa; border: 1px solid #e5e5e5">
							<?= strtoupper(explode("/",$file_type)[1]);?>
						</div>
						<?}?>

					</td>
					<td style="line-height: 1" valign="middle">
						<?echo $doc_title?><br>
						<div >
							<small class="color-acent" style="font-size: 11px"><?= round($file_size/1024)."KB"?></small>
							&bull;
							<small class="color-acent" style="font-size: 11px"><?= strtoupper(explode("/",$file_type)[1])?></small>
						</div>
						<input type="hidden"  name="doc[<?echo $rand_no?>][doc_title]" class="uk-input uk-form-small" value="<?echo $doc_title?>" />
						<input type="hidden" name="doc[<?echo $rand_no?>][doc_url]" value="<?echo $img_link?>" />
					</td>
					<td style="width: 30px; text-align: right">
						<a style="color: red" href="javascript:void(0)"
						onclick="if(confirm('Are you sure?')){$('#con_<?echo $rand_no;?>').remove();}" uk-icon="close"></a>
					</td>
				</tr>
				<? exit;
			}
			if($os->get('WT_formfillupEditAndSave')=='OK'){
				error_reporting(0);
				if($os->post('formfillup_id')=='0'){
					$dob_a=explode('-',$os->post('dob'));
					$from_date=$dob_a[2].'-'.$dob_a[1].'-'.$dob_a[0];
					$and_dob=$os->DateQ('dob',$from_date,$from_date,$sTime='00:00:00',$eTime='23:59:59');
					$formfillup_id=$os->rowByField('formfillup_id','formfillup','mobile_student',$os->post('mobile_student'),$where=" and class_id='".$os->post("class_id")."' and year='".$os->post("year")."' $and_dob",$orderby='');
					if($formfillup_id>0){
						echo $mgs="Error#-#You have already Applied.";
						return;
					}
				}
				$formfillup_id=$os->post('formfillup_id');
				$dataToSave['branch_id']=addslashes($os->post('branch_id')); 
				$dataToSave['class_id']=$os->post('class_id')?$os->post('class_id'):0; 
				$dataToSave['name']=addslashes($os->post('name')); 
				$dataToSave['mobile_student']=addslashes($os->post('mobile_student')); 
				$profile_picture=$os->UploadPhoto('profile_picture',$site['root'].'wtos-images');  
				if($profile_picture!=''){
					$dataToSave['profile_picture']='wtos-images/'.$profile_picture;}
					
					
					//_d($_FILES);
					if($os->post('dob')){
						$dob_a=explode('-',$os->post('dob'));
						$dataToSave['dob']=$os->saveDate($dob_a[2].'-'.$dob_a[1].'-'.$dob_a[0]); 
					}

					$dataToSave['age']=addslashes($os->post('age')); 
					$dataToSave['orphan']=addslashes($os->post('orphan')); 
					$dataToSave['aadhaar_number']=addslashes($os->post('aadhaar_number')); 
					$aadhaar_image=$os->UploadPhoto('aadhaar_image',$site['root'].'wtos-images');
					if($aadhaar_image!=''){
						$dataToSave['aadhaar_image']='wtos-images/'.$aadhaar_image;}
						$dataToSave['identification_mark']=addslashes($os->post('identification_mark')); 
						$dataToSave['blood_group']=addslashes($os->post('blood_group')); 
						$dataToSave['rights_on_child']=addslashes($os->post('rights_on_child')); 
						$dataToSave['first_language']=addslashes($os->post('first_language')); 
						$dataToSave['what_wants_to_be']=addslashes($os->post('what_wants_to_be')); 
						$dataToSave['hobbies_of_child']=addslashes($os->post('hobbies_of_child')); 
						$dataToSave['academic_year']=$os->post('academic_year')?$os->post('academic_year'):0; 
						$dataToSave['year']=$os->post('academic_year')?$os->post('academic_year'):0; 
						$dataToSave['student_type']=addslashes($os->post('student_type')); 			
			// $admission_date_a=explode('-',$os->post('admission_date'));
			// $dataToSave['admission_date']=$os->saveDate($admission_date_a[2].'-'.$admission_date_a[1].'-'.$admission_date_a[0]); 
						$dataToSave['admission_date']=$os->now();
						$dataToSave['admission_category']=addslashes($os->post('admission_category')); 
						$dataToSave['need_a_hostel']=addslashes($os->post('need_a_hostel')); 
						$dataToSave['nationality']=addslashes($os->post('nationality')); 
						$dataToSave['whats_app_no']=addslashes($os->post('whats_app_no')); 
						$dataToSave['email_id']=addslashes($os->post('email_id')); 
						$dataToSave['gender']=addslashes($os->post('gender')); 
						$dataToSave['caste']=addslashes($os->post('caste')); 
						$dataToSave['father_name']=addslashes($os->post('father_name')); 
						$dataToSave['father_mobile']=addslashes($os->post('father_mobile')); 
						$dataToSave['father_aisj_member']=addslashes($os->post('father_aisj_member')); 
						$dataToSave['father_id_no']=addslashes($os->post('father_id_no')); 
						$dataToSave['mother_name']=addslashes($os->post('mother_name')); 
						$dataToSave['mother_mobile']=addslashes($os->post('mother_mobile')); 
						$dataToSave['mother_occupation']=addslashes($os->post('mother_occupation')); 
						$dataToSave['mother_aisj_member']=addslashes($os->post('mother_aisj_member')); 
						$dataToSave['mother_id_no']=addslashes($os->post('mother_id_no')); 
						$dataToSave['guardian_name']=addslashes($os->post('guardian_name')); 
						$dataToSave['guardian_mobile']=addslashes($os->post('guardian_mobile')); 
						$dataToSave['guardian_occupation']=addslashes($os->post('guardian_occupation')); 
						$dataToSave['guardian_aisj_member']=addslashes($os->post('guardian_aisj_member')); 
						$dataToSave['guardian_id_no']=addslashes($os->post('guardian_id_no')); 
						$dataToSave['permanent_state']=addslashes($os->post('permanent_state')); 
						$dataToSave['permanent_district']=addslashes($os->post('permanent_district')); 
						$dataToSave['permanent_block']=addslashes($os->post('permanent_block')); 
						$dataToSave['permanent_police_station']=addslashes($os->post('permanent_police_station')); 
						$dataToSave['permanent_village']=addslashes($os->post('permanent_village')); 
						$dataToSave['permanent_pincode']=addslashes($os->post('permanent_pincode')); 
						$dataToSave['permanent_post_office']=addslashes($os->post('permanent_post_office')); 
						$dataToSave['permanent_nationality']=addslashes($os->post('permanent_nationality')); 
						$dataToSave['relationship']=addslashes($os->post('relationship')); 
						$dataToSave['annual_family_income']=$os->post('annual_family_income')?$os->post('annual_family_income'):0.00; 
						$dataToSave['bank_account_number']=addslashes($os->post('bank_account_number')); 
						$dataToSave['ifsc_code']=addslashes($os->post('ifsc_code')); 
						$dataToSave['bank_name']=addslashes($os->post('bank_name')); 
						$dataToSave['bank_branch']=addslashes($os->post('bank_branch')); 
						$dataToSave['father_ocu']=addslashes($os->post('father_ocu')); 
						$dataToSave['father_monthly_income']=$os->post('father_monthly_income')?$os->post('father_monthly_income'):0.00; 
						$dataToSave['vill']=addslashes($os->post('vill')); 
						$dataToSave['po']=addslashes($os->post('po')); 
						$dataToSave['ps']=addslashes($os->post('ps')); 
						$dataToSave['dist']=addslashes($os->post('dist')); 
						$dataToSave['block']=addslashes($os->post('block')); 
						$dataToSave['pin']=addslashes($os->post('pin')); 
						$dataToSave['state']=addslashes($os->post('state')); 
						$dataToSave['last_school']=addslashes($os->post('last_school')); 
						$dataToSave['last_class']=addslashes($os->post('last_class')); 
						$dataToSave['last_school_session']=addslashes($os->post('last_school_session')); 
						$dataToSave['last_school_address']=addslashes($os->post('last_school_address'));
						$dataToSave['last_class_total_marks']=addslashes($os->post('last_class_total_marks'));
						$dataToSave['last_class_obtain_marks']=addslashes($os->post('last_class_obtain_marks'));
						$dataToSave['last_class_grade']=addslashes($os->post('last_class_grade'));
						
						
			//Academic details
						$dataToSave['ten_name_of_board'] = $os->post('new_ten_name_of_board');
						$dataToSave['ten_passed_year'] = $os->post('new_ten_passed_year');
						$dataToSave['ten_roll'] = $os->post('new_ten_roll');
						$dataToSave['ten_no'] = $os->post('new_ten_no');
						$dataToSave['ten_marks_beng_hindi'] = $os->post('new_ten_marks_beng_hindi');
						$dataToSave['ten_marks_eng'] = $os->post('new_ten_marks_eng');
						$dataToSave['ten_marks_math'] = $os->post('new_ten_marks_math');
						$dataToSave['ten_marks_physc'] = $os->post('new_ten_marks_physc');
						$dataToSave['ten_marks_lifesc'] = $os->post('new_ten_marks_lifesc');
						$dataToSave['ten_marks_history'] = $os->post('new_ten_marks_history');
						$dataToSave['ten_marks_geography'] = $os->post('new_ten_marks_geography');
						$dataToSave['ten_marks_socialsc'] = $os->post('new_ten_marks_socialsc');
						$dataToSave['ten_marks_total_obt'] = $os->post('new_ten_marks_total_obt');
						$dataToSave['ten_marks_out_of'] = $os->post('new_ten_marks_out_of');
						$dataToSave['ten_marks_percent'] = $os->post('new_ten_marks_percent');
						$dataToSave['twelve_name_of_board'] = $os->post('new_twelve_name_of_board');
						$dataToSave['twelve_passed_year'] = $os->post('new_twelve_passed_year');
						$dataToSave['twelve_roll'] = $os->post('new_twelve_roll');
						$dataToSave['twelve_no'] = $os->post('new_twelve_no');
						$dataToSave['twelve_stream'] = $os->post('new_twelve_stream');
						$dataToSave['twelve_marks_beng_hindi'] = $os->post('new_twelve_marks_beng_hindi');
						$dataToSave['twelve_marks_eng'] = $os->post('new_twelve_marks_eng');
						$dataToSave['twelve_marks_math'] = $os->post('new_twelve_marks_math');
						$dataToSave['twelve_marks_physc'] = $os->post('new_twelve_marks_physc');
						$dataToSave['twelve_marks_biology'] = $os->post('new_twelve_marks_biology');
						$dataToSave['twelve_marks_chemistry'] = $os->post('new_twelve_marks_chemistry');
						$dataToSave['twelve_marks_total_obt'] = $os->post('new_twelve_marks_total_obt');
						$dataToSave['twelve_marks_out_of'] = $os->post('new_twelve_marks_out_of');
						$dataToSave['twelve_marks_percent'] = $os->post('new_twelve_marks_percent');
						$dataToSave['graduate_passed'] = $os->post('new_graduate_passed');
						$dataToSave['graduate_passed_subject'] = $os->post('new_graduate_passed_subject');
						$dataToSave['graduate_passed_year'] = $os->post('new_graduate_passed_year');
						$dataToSave['graduate_passed_university'] = $os->post('new_graduate_passed_university');
						$dataToSave['graduate_subjects'] = $os->post('new_graduate_subjects');
						$dataToSave['graduate_subjects_marks'] = $os->post('new_graduate_subjects_marks');
						$dataToSave['graduate_total_obt'] = $os->post('new_graduate_total_obt');
						$dataToSave['graduate_out_of'] = $os->post('new_graduate_out_of');
						$dataToSave['graduate_percent'] = $os->post('new_graduate_percent');
						
						
						$dataToSave['father_qualification'] = $os->post('father_qualification');
						$dataToSave['mother_qualification'] = $os->post('mother_qualification');
						$dataToSave['place_of_birth'] = $os->post('place_of_birth');
						$dataToSave['religion'] = $os->post('religion');
						
						


 
						
						
						
			//End Academic details

						$qResult=$os->save('formfillup',$dataToSave,'formfillup_id',$formfillup_id);
						if($qResult)  
						{
							$dataToSave2['form_no']=$qResult;
							$qResult=$os->save('formfillup',$dataToSave2,'formfillup_id',$qResult);
							if($formfillup_id>0 ){ 
								$mgs= " Data updated Successfully";
								$os->mq("delete from formfillup_document where formfillup_id='".$formfillup_id."'");
							}
							if($formfillup_id<1 ){ $mgs= " Data Added Successfully"; $formfillup_id=  $qResult;}
							$mgs=$formfillup_id."#-#".$mgs;
							$document_a=$os->post('doc');
							if(is_array($document_a)&&count($document_a)>0){
								$dataToSave3['dated']=$os->now();
								$dataToSave3['formfillup_id']=$qResult;
								foreach ($document_a as  $value) {
									$dataToSave3['doc_link']=$value['doc_url'];
									$dataToSave3['title']=$value['doc_title'];
									$os->save("formfillup_document", $dataToSave3);
								}
							}
						}
						else{
							$mgs="Error#-#Problem Saving Data.";
						}
						echo $mgs;
						exit();
					} 
