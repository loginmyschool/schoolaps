<?
global $os,$registrationNo,$student_id;
$os->medium_list=array('Bengali'=>'Bengali','English'=>'English');
$os->nationality_list=array('Indian'=>'Indian','Other'=>'Other');
$os->nationality_list=array('Indian'=>'Indian','Other'=>'Other');
$os->caste_list=array('Gen'=>'Gen','OBC-A'=>'OBC-A','OBC-B'=>'OBC-B'); 
$os->body_parts_list=array('Leg'=>'Leg','Hand'=>'Hand','Eye'=>'Eye','Ear'=>'Ear'); 
$os->living_area_dists_list=array('Dist.'=>'Dist.','Sub-Division'=>'Sub-Division','Town'=>'Town','Semi-Town'=>'Semi-Town','Vill'=>'Vill');
$os->living_area_gram_panchayet_list=array('Gram Panchayet'=>'Gram Panchayet','Municipality'=>'Municipality');
$os->family_member_emp_dept =array('Teacher'=>'Teacher','Office Staff'=>'Office Staff','Administrator'=>'Administrator','Medical'=>'Medical','Dining & Kitchen'=>'Dining & Kitchen','Other'=>'Other');
$os->family_member_relation=array('Father'=>'Father','Mother'=>'Mother','Brother'=>'Brother','Sister'=>'Sister');
 
 
$os->father_qualification_list=array('Primary'=>'Primary','Upper Primary'=>'Upper Primary','Secondary'=>'Secondary','Higher Secondary'=>'Higher Secondary','graduate'=>'graduate','Post Graduate'=>'Post Graduate','Illiterate'=>'Illiterate'); 
$os->mother_qualification_list=array('Primary'=>'Primary','Upper Primary'=>'Upper Primary','Secondary'=>'Secondary','Higher Secondary'=>'Higher Secondary','graduate'=>'graduate','Post Graduate'=>'Post Graduate','Illiterate'=>'Illiterate'); 
 
   
	$os->boardname_list=array('CBSE'=>'CBSE','ICSE'=>'ICSE','WBBME'=>'WBBME','WBBSE'=>'WBBSE');   
	$os->twelve_stream_list=array('Sc'=>'Sc','Arts'=>'Arts','Comers'=>'Comers');   
	
	 
	
	  $os->graduate_passed_list=array('With Hons.'=>'With Hons.','Without Hons'=>'Without Hons' ); 
	  
	   $os->year_of_passing=range(2015,date('Y'));	
	//  _d($os->year_of_passing);
	  
	  
	 $st_details="select  * from student where studentId='$student_id' limit 1   ";
	 $st_details_rs= $os->mq($st_details);
	 $student_data = $os->mfa($st_details_rs);	
	// _d($student_data);
	 
    $st_details="select  * from student_meta where student_id='$student_id' limit 1   ";
	$st_details_rs= $os->mq($st_details);
	$student_meta = $os->mfa($st_details_rs);	
	$os->data=$student_meta;
	
	if(is_array($student_data))
	{
	    $os->data = array_merge($student_data, $os->data);
	
	}
	
	
	//$os->data['000000']='---------';
	
//_d($os->data);	 
?>

<table style=" width:100%" class="noBorder main_table">
  <tr>
    <td valign="top" style="padding:10px;">
    <table style=" width:320px" >
      <tr>
        <td> Profile Picture <br />
          <img id="imagePreview" src="<?php echo ($student['profile_picture'])?$site['url-image'].$student['profile_picture']:$site['url-wtos'].'images/student_img.png' ?>"   style="width:150px; height:140px; border:10px solid #666666; border-radius:6px;"  	 />
          <input type="file" name="profile_picture" value=""  id="profile_picture" onchange="os.readURL(this,'imagePreview') " style="display:none;"/>
          <br>
          <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('profile_picture');">Edit Image</span> </td>
        <td> I Card Image <br />
          <img id="student_img_preview" src="<?php echo ($student['image'])?$site['url-image'].$student['image']:$site['url-wtos'].'images/student_img.png' ?>" style="width:150px; height:140px; border:10px solid #666666; border-radius:6px;" 	 />
          <input type="file" name="student_img" value=""  id="student_img" onchange="os.readURL(this,'student_img_preview') " style="display:none;"/>
          <br>
          <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('student_img');">Edit Image</span></td>
      </tr>
    </table>
    <table width="100%" border="0" class="edit_trace">
      <tr>
        <td>Name</td>
        <td><input type="text" value="<? echo $student['name']  ?>" id="name_trace" style="width:250px;" />
          <input type="button" value="Save" onclick="stdent_save_trace('name_trace','name','<? echo $student_id?>');" style="cursor:pointer" /></td>
      </tr>
      <tr>
        <td>Father Name</td>
        <td><input type="text" value="<? echo $student['father_name']  ?>" id="father_name_trace" style="width:250px;" />
          <input type="button" value="Save" onclick="stdent_save_trace('father_name_trace','father_name','<? echo $student_id?>');" style="cursor:pointer" />
        </td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><select   id="gender_trace">
            <option value="" > </option>
            <?  $os->onlyOption($os->gender,  $student['gender'] );?>
          </select>
          <input type="button" value="Save" onclick="stdent_save_trace('gender_trace','gender','<? echo $student_id?>');" style="cursor:pointer" /></td>
      </tr>
      <tr>
        <td>Mobile</td>
        <td><input type="text" value="<? echo $student['mobile_student']  ?>" id="mobile_student_trace" />
          <input type="button" value="Save" onclick="stdent_save_trace('mobile_student_trace','mobile_student','<? echo $student_id?>');" style="cursor:pointer" /></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input type="text" value="<? echo $student['otpPass']  ?>" id="otpPass_trace" />
          <input type="button" value="Save" onclick="stdent_save_trace('otpPass_trace','otpPass','<? echo $student_id?>');" style="cursor:pointer" />
        </td>
      </tr>
      <tr>
        <td>Active</td>
        <td><select   id="status_active_trace">
            <option value="" > </option>
            <?  $os->onlyOption($os->status_active,  $student['status_active'] );?>
          </select>
          <input type="button" value="Save" onclick="stdent_save_trace('status_active_trace','status_active','<? echo $student_id?>');" style="cursor:pointer" />
        </td>
      </tr>
    </table>
    <table >
      <tr>
        <td>Medium</td>
        <td><select   name="new_medium" id="new_medium"
                            class="uk-select uk-border-rounded congested-form   "   >
            <option> </option>
            <? $os->onlyOption($os->medium_list,$os->getVal('medium'));	?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Date  Registration</td>
        <td><input class="uk-input congested-form datepicker" type="text" name="new_student_registerDate" id="new_student_registerDate"value="<? echo $os->getVal('registerDate'); ?>"  />
        </td>
      </tr>
      <tr>
        <td>Present Fees</td>
        <td><input class="uk-input congested-form" type="text" name="new_present_fees" id="new_present_fees" value="<? echo $os->getVal('present_fees'); ?>">
        </td>
      </tr>
      <tr>
        <td>Date of Birth</td>
        <td><input class="uk-input congested-form datepicker" type="text" name="new_student_dob" id="new_student_dob" value="<? echo $os->getVal('dob'); ?>"/>
        </td>
      </tr>
      <tr>
        <td>Aadhaar No</td>
        <td><input class="uk-input congested-form" type="text" name="new_student_adhar_no" id="new_student_adhar_no"  value="<? echo $os->getVal('adhar_no'); ?>" />
        </td>
      </tr>
      <tr>
        <td>Nationality</td>
        <td><select class="uk-select congested-form" name="new_nationality" id="new_nationality" onchange="nantionality_data();"    >
            <option value="" > </option>
            <?  $os->onlyOption($os->nationality_list,  $os->getVal('nationality'));?>
          </select>
        </td>
      </tr>
      <? $nationality=$os->getVal('nationality'); ?>
      <tr id="nantionality_data_container" style=" <? if($nationality=='Indian'){ ?> display:none;<? }else{ ?>  <?  } ?> "    >
        <td colspan="2"><table   border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>Country name(if other) </td>
              <td><input class="uk-input congested-form" type="text" name="new_country_name" id="new_country_name" value="<? echo $os->getVal('country_name'); ?>"></td>
            </tr>
            <tr>
              <td>Passport No.</td>
              <td><input class="uk-input congested-form" type="text" name="new_passport_no" id="new_passport_no" value="<? echo $os->getVal('passport_no'); ?>">
              </td>
            </tr>
            <tr>
              <td>Vissa Type</td>
              <td><input class="uk-input congested-form" type="text" name="new_vissa_type" id="new_vissa_type" value="<? echo $os->getVal('vissa_type'); ?>">
              </td>
            </tr>
            <tr>
              <td>Valid up to</td>
              <td><input class="uk-input congested-form" type="text" name="new_passport_valid_up_to" id="new_passport_valid_up_to" value="<? echo $os->getVal('passport_valid_up_to'); ?>"></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>Religion</td>
        <td><? $rel= $os->getVal('religian'); 
	    if($rel==''){$rel='Islam';}
	   ?>
          <input class="uk-input congested-form" type="text" name="new_student_religian" id="new_student_religian"  value="<? echo $rel ?>" />
        </td>
      </tr>
      <tr>
        <td>Category</td>
        <td><select class="uk-select congested-form" name="new_student_caste" id="new_student_caste" onchange="caste_data();"   >
            <option value="" > </option>
            <?  $os->onlyOption($os->caste_list, $os->getVal('caste'));?>
          </select>
        </td>
      </tr>
      <? $caste=$os->getVal('caste'); ?>
      <tr id="caste_data_container" style=" <? if($caste=='Gen'){ ?> display:none;<? }else{ ?>  <?  } ?> ">
        <td colspan="6"><table  border="0" cellspacing="0" cellpadding="0"  style="background-color:#DFEFFF; width:100%;">
            <tr>
              <td>Certificate No.</td>
              <td><input class="uk-input congested-form" type="text" name="new_caste_cert_no" id="new_caste_cert_no" value="<? echo $os->getVal('caste_cert_no'); ?>"></td>
            </tr>
            <tr>
              <td> Issuing authority</td>
              <td><input class="uk-input congested-form" type="text" name="new_cast_cert_issue_auth" id="new_cast_cert_issue_auth" value="<? echo $os->getVal('cast_cert_issue_auth'); ?>"></td>
            </tr>
            <tr>
              <td> Date of issue</td>
              <td><input class="uk-input congested-form datepicker" type="text" name="new_cast_cert_issue_date" id="new_cast_cert_issue_date" value="<? echo $os->getVal('cast_cert_issue_date'); ?>"></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>Whether Physically Challenged</td>
        <td><select class="uk-select congested-form" name="new_disabled" id="new_disabled"  onchange="disabled_data();"  >
            <option value="" > </option>
            <?  $os->onlyOption($os->yesno,$os->getVal('disabled'));?>
          </select>
        </td>
      </tr>
      <? $disabled=$os->getVal('disabled'); ?>
      <tr id="disabled_data_container" style=" <? if($disabled!='Yes'){ ?> display:none;<? }else{ ?>  <?  } ?> ">
        <td colspan="6"><table style="background-color:#DFEFFF; width:100%;">
            <tr>
              <td> Body Part of Disability </td>
              <td><select class="uk-select congested-form" name="new_disable_body_parts" id="new_disable_body_parts"   >
                  <option value="" > </option>
                  <?  $os->onlyOption($os->body_parts_list,$os->getVal('disable_body_parts'));?>
                </select></td>
            </tr>
            <tr>
              <td> Percentage </td>
              <td><input class="uk-input congested-form" type="text" name="new_disable_percet" id="new_disable_percet" value="<? echo $os->getVal('disable_percet'); ?>"></td>
            </tr>
            <tr>
              <td>Certificate No.</td>
              <td><input class="uk-input congested-form" type="text" name="new_disable_cert_no" id="new_disable_cert_no" value="<? echo $os->getVal('disable_cert_no'); ?>"></td>
            </tr>
            <tr>
              <td> Issuing Authority </td>
              <td><input class="uk-input congested-form" type="text" name="new_disable_cert_issue_auth" id="new_disable_cert_issue_auth" value="<? echo $os->getVal('disable_cert_issue_auth'); ?>">
              </td>
            </tr>
            <tr>
              <td> Date of issue </td>
              <td><input class="uk-input congested-form datepicker" type="text" name="new_disable_cert_issue_date" id="new_disable_cert_issue_date" value="<? echo $os->getVal('disable_cert_issue_date'); ?>"></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>Living area </td>
        <td><select class="uk-select congested-form" name="new_living_area_dist" id="new_living_area_dist"   >
            <option value="" > </option>
            <?  $os->onlyOption($os->living_area_dists_list,$os->getVal('living_area_dist'));?>
          </select>
          <!--   <input class="uk-input congested-form" type="text" name="new_living_area_sub_division" id="new_living_area_sub_division">  <input class="uk-input congested-form" type="text" name="new_living_area_town" id="new_living_area_town">
	  <input class="uk-input congested-form" type="text" name="new_living_area_semi_town" id="new_living_area_semi_town"> 
	  <input class="uk-input congested-form" type="text" name="new_living_area_vill" id="new_living_area_vill">  -->
        </td>
      </tr>
      <tr>
        <td>Local Administration</td>
        <td><select class="uk-select congested-form" name="new_living_area_gram_panchayet" id="new_living_area_gram_panchayet"   >
            <option value="" > </option>
            <?  $os->onlyOption($os->living_area_gram_panchayet_list,$os->getVal('living_area_gram_panchayet'));?>
          </select>
        </td>
      </tr>
    </table>
    <div class="vspace"> </div>
    <table class=" ">
      <tr>
        <td colspan="5"><h2> Student Bank info </h2></td>
      </tr>
      <tr>
        <td>Name of the Bank </td>
        <td><input class="uk-input congested-form" type="text" name="new_bank_name" id="new_bank_name" value="<? echo $os->getVal('bank_name'); ?>">
        </td>
      </tr>
      <tr>
        <td>Bank Branch </td>
        <td><input class="uk-input congested-form" type="text" name="new_bank_branch" id="new_bank_branch" value="<? echo $os->getVal('bank_branch'); ?>">
        </td>
      </tr>
      <tr>
        <td>IFSC code </td>
        <td><input class="uk-input congested-form" type="text" name="new_ifscCode" id="new_ifscCode" value="<? echo $os->getVal('ifscCode'); ?>">
        </td>
      </tr>
      <tr>
        <td>Account No </td>
        <td><input class="uk-input congested-form" type="text" name="new_accNo" id="new_accNo" value="<? echo $os->getVal('accNo'); ?>">
        </td>
      </tr>
      <td colspan="10"><div class="vspace"> </div></td>
      <tr>
        <td colspan="5"><h2> Kanyashree Info. (For Girls) </h2></td>
      </tr>
      <tr>
        <td>Type </td>
        <td><input class="uk-input congested-form" type="text" name="new_kanyashree_type" id="new_kanyashree_type" value="<? echo $os->getVal('kanyashree_type'); ?>">
      </tr>
      <tr>
      </td>
      <td>ID No. </td>
        <td><input class="uk-input congested-form" type="text" name="new_kanyashree_ID_NO" id="new_kanyashree_ID_NO" value="<? echo $os->getVal('kanyashree_ID_NO'); ?>">
        </td>
      </tr>
    </table>
    </td>
    <td valign="top" style="padding:10px;"><table style="width:360px;"  >
        <tr>
          <td colspan="5"><h2> PARENTS INFORMATION </h2></td>
        </tr>
        <tr>
          <td style="width:180px;"> Father’s name </td>
          <td><input class="uk-input congested-form" type="text" name="new_student_father_name" id="new_student_father_name" value="<? echo $os->getVal('father_name'); ?>"  />
          </td>
        </tr>
        <tr>
          <td>Is he alive </td>
          <td><select class="uk-select congested-form" name="new_is_father_alive" id="new_is_father_alive"   onchange="toggle_block_no('new_is_father_alive','father_dateofdeath_container');toggle_block_no('new_is_father_alive','Gurdian_data_container'); "  >
              <option value="" > </option>
              <?  $os->onlyOption($os->yesno,$os->getVal('is_father_alive'));?>
            </select>
            <div id="father_dateofdeath_container" style="display:none; padding-top:10px;"> if No Put Date of Death
              <input class="uk-input congested-form datepicker" type="text" name="new_father_date_of_death" id="new_father_date_of_death" value="<? echo $os->getVal('father_date_of_death'); ?>">
            </div></td>
        </tr>
        <tr>
          <td>Father’s qualification </td>
          <td><select class="uk-select congested-form" name="new_father_qualification" id="new_father_qualification"   >
              <option value="" > </option>
              <?  $os->onlyOption($os->father_qualification_list,$os->getVal('father_qualification'));?>
            </select>
          </td>
        </tr>
        <tr>
          <td> Father’s occupation </td>
          <td><input class="uk-input congested-form" type="text" name="new_student_father_ocu" id="new_student_father_ocu" value="<? echo $os->getVal('father_ocu'); ?>">
          </td>
        </tr>
        <tr>
          <td>Father’s Monthly income </td>
          <td><input class="uk-input congested-form" type="text" name="new_father_monthly_income" id="new_father_monthly_income" value="<? echo $os->getVal('father_monthly_income'); ?>">
          </td>
        </tr>
        <tr>
          <td>Father’s  Aadhaar No </td>
          <td><input class="uk-input congested-form" type="text" name="new_father_adhar" id="new_father_adhar" value="<? echo $os->getVal('father_adhar'); ?>">
          </td>
        </tr>
        <tr>
          <td>Mother’s name </td>
          <td><input class="uk-input congested-form" type="text" name="new_student_mother_name" id="new_student_mother_name" value="<? echo $os->getVal('mother_name'); ?>">
          </td>
        </tr>
        <tr>
          <td>Is she alive </td>
          <td><select class="uk-select congested-form" name="new_is_mother_alive" id="new_is_mother_alive" 
		onchange="toggle_block_no('new_is_mother_alive','mother_dateofdeath_container'); "    >
              <option value="" > </option>
              <?  $os->onlyOption($os->yesno,$os->getVal('is_mother_alive'));?>
            </select>
            <div id="mother_dateofdeath_container" style="display:none; padding-top:10px;"> if No Put Date of Death
              <input class="uk-input congested-form datepicker" type="text" name="new_mother_date_of_death" id="new_mother_date_of_death" value="<? echo $os->getVal('mother_date_of_death'); ?>">
            </div></td>
        </tr>
        <tr>
          <td>Mother’s qualification </td>
          <td><select class="uk-select congested-form" name="new_mother_qualification" id="new_mother_qualification"   >
              <option value="" > </option>
              <?  $os->onlyOption($os->mother_qualification_list,$os->getVal('mother_qualification'));?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Mother’s occupation </td>
          <td><input class="uk-input congested-form" type="text" name="new_student_mother_ocu" id="new_student_mother_ocu" value="<? echo $os->getVal('mother_ocu'); ?>">
          </td>
        </tr>
        <tr>
          <td>Mother’s Monthly income </td>
          <td><input class="uk-input congested-form" type="text" name="new_mother_monthly_income" id="new_mother_monthly_income" value="<? echo $os->getVal('mother_monthly_income'); ?>">
          </td>
        </tr>
        <tr>
          <td>Mother’s  Aadhaar No </td>
          <td><input class="uk-input congested-form" type="text" name="new_mother_adhar" id="new_mother_adhar" value="<? echo $os->getVal('mother_adhar'); ?>">
          </td>
        </tr>
        <tr>
          <td colspan="9"><div id="Gurdian_data_container"  >
              <table width="100%">
                <tr>
                  <td style="font-weight:bold;">Name of Guardian </td>
                  <td style="font-size:10px;"> You can skip Gurdian Details If father is  alive </td>
                </tr>
                <tr>
                  <td>Guardian’s Name </td>
                  <td><input class="uk-input congested-form" type="text" name="new_student_guardian_name" id="new_student_guardian_name" value="<? echo $os->getVal('guardian_name'); ?>">
                  </td>
                </tr>
                <tr>
                  <td>Guardian’s Qualification </td>
                  <td><input class="uk-input congested-form" type="text" name="new_gurdian_qualification" id="new_gurdian_qualification" value="<? echo $os->getVal('gurdian_qualification'); ?>">
                  </td>
                </tr>
                <tr>
                  <td>Guardian’s Occupation</td>
                  <td><input class="uk-input congested-form" type="text" name="new_student_guardian_ocu" id="new_student_guardian_ocu" value="<? echo $os->getVal('guardian_ocu'); ?>">
                  </td>
                </tr>
                <tr>
                  <td>Guardian’s Monthly income</td>
                  <td><input class="uk-input congested-form" type="text" name="new_gurdian_monthly_income" id="new_gurdian_monthly_income" value="<? echo $os->getVal('gurdian_monthly_income'); ?>">
                  </td>
                </tr>
                <tr style="display:none">
                  <td>Aadhaar No</td>
                  <td><input class="uk-input congested-form" type="text" name="new_email_guardian" id="new_email_guardian" value="<? echo $os->getVal('email_guardian'); ?>">
                  </td>
                </tr>
                <tr>
                  <td>Relationship with student </td>
                  <td><input class="uk-input congested-form" type="text" name="new_student_guardian_relation" id="new_student_guardian_relation" value="<? echo $os->getVal('guardian_relation'); ?>">
                  </td>
                </tr>
              </table>
            </div></td>
        </tr>
      </table>
      <div class="vspace"> </div>
      <table  >
        <tr>
          <td colspan="5"><h2> SCHOOL / ACADEMIC INFO. </h2></td>
        </tr>
        <tr>
          <td colspan="5" style="font-weight:bold;">Previous / Last attend School Info </td>
        </tr>
        <tr>
          <td>School Name </td>
          <td><input class="uk-input congested-form" type="text" name="new_last_school" id="new_last_school" value="<? echo $os->getVal('last_school'); ?>">
          </td>
        </tr>
        <tr>
          <td>Address </td>
          <td><input class="uk-input congested-form" type="text" name="new_last_school_address" id="new_last_school_address" value="<? echo $os->getVal('last_school_address'); ?>">
          </td>
        </tr>
        <tr>
          <td>Last attendant Class </td>
          <td><input class="uk-input congested-form" type="text" name="new_last_class" id="new_last_class" value="<? echo $os->getVal('last_class'); ?>">
          </td>
        </tr>
        <tr>
          <td>Session</td>
          <td><input class="uk-input congested-form" type="text" name="new_last_school_session" id="new_last_school_session" value="<? echo $os->getVal('last_school_session'); ?>">
          </td>
        </tr>
        <tr>
          <td>T.C No </td>
          <td><input class="uk-input congested-form" type="text" name="new_tc_no" id="new_tc_no" value="<? echo $os->getVal('tc_no'); ?>">
          </td>
        </tr>
        <tr>
          <td>Issue date of T.C </td>
          <td><input class="uk-input congested-form datepicker" type="text" name="new_tc_date" id="new_tc_date" value="<? echo $os->getVal('tc_date'); ?>">
          </td>
        </tr>
        <tr>
          <td>Student ID No in T.C </td>
          <td><input class="uk-input congested-form" type="text" name="new_student_id_in_TC" id="new_student_id_in_TC" value="<? echo $os->getVal('student_id_in_TC'); ?>">
          </td>
        </tr>
        <tr>
          <td colspan="5" style="font-weight:bold;">Present School </td>
        </tr>
        <tr>
          <td>Name of admitted School </td>
          <td><input class="uk-input congested-form" type="text" name="new_present_school" id="new_present_school" value="<? echo $os->getVal('present_school'); ?>">
          </td>
        </tr>
        <tr>
          <td>School Address </td>
          <td><input class="uk-input congested-form" type="text" name="new_present_school_address" id="new_present_school_address" value="<? echo $os->getVal('present_school_address'); ?>">
          </td>
        </tr>
        <tr>
          <td>School Phone No </td>
          <td><input class="uk-input congested-form" type="text" name="new_present_school_contact" id="new_present_school_contact" value="<? echo $os->getVal('present_school_contact'); ?>">
          </td>
        </tr>
        <tr>
          <td>Admitted in class </td>
          <td><input class="uk-input congested-form" type="text" name="new_present_school_class" id="new_present_school_class" value="<? echo $os->getVal('present_school_class'); ?>">
          </td>
        </tr>
        <tr>
          <td>Admitted in session </td>
          <td><input class="uk-input congested-form" type="text" name="new_present_school_session" id="new_present_school_session" value="<? echo $os->getVal('present_school_session'); ?>">
          </td>
        </tr>
        <tr>
          <td>School Roll No </td>
          <td><input class="uk-input congested-form" type="text" name="new_present_school_roll" id="new_present_school_roll" value="<? echo $os->getVal('present_school_roll'); ?>">
          </td>
        </tr>
        <tr>
          <td>School Section </td>
          <td><input class="uk-input congested-form" type="text" name="new_present_school_section" id="new_present_school_section" value="<? echo $os->getVal('present_school_section'); ?>">
          </td>
        </tr>
      </table></td>
    <td valign="top"><table  >
        <tr>
          <td colspan="5"><h2> CORRESPONDENCE INFORMATION </h2></td>
        </tr>
        <tr>
          <td colspan="5" style="font-weight:bold;">Permanent Address : </td>
        </tr>
        <tr>
          <td style="width:100px;">Village </td>
          <td><input class="uk-input congested-form" type="text" name="new_student_vill" id="new_student_vill" value="<? echo $os->getVal('vill'); ?>" />
          </td>
          <td style="width:120px;">P.O.</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_po" id="new_student_po" value="<? echo $os->getVal('po'); ?>" />
          </td>
        </tr>
        <tr>
          <td>Police station</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_ps" id="new_student_ps" value="<? echo $os->getVal('ps'); ?>" />
          </td>
          <td>Block/Municipality</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_block" id="new_student_block" value="<? echo $os->getVal('block'); ?>" />
          </td>
        </tr>
        <tr>
          <td>PIN</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_pin" id="new_student_pin" value="<? echo $os->getVal('pin'); ?>" />
          </td>
          <td>District</td>
          <td><input class="uk-input congested-form" type="text"  name="new_student_dist" id="new_student_dist"  value="<? echo $os->getVal('dist'); ?>" />
          </td>
        </tr>
        <tr>
          <td>State</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_state" id="new_student_state" value="<? echo $os->getVal('state'); ?>"  />
          </td>
          <td>_</td>
          <td> _ </td>
        </tr>
        <tr>
          <td colspan="5" ><b>Correspondence Address : </b>
            <div style="font-size:10px;"> If permanent & Correspondence are same-
              <input  type="checkbox" onchange="autofill_Correspondence()" id="autofill_corr_check_id"/>
              tick here		then following field will auto filled up from permanent address </div></td>
        </tr>
        <tr>
          <td>Village </td>
          <td><input class="uk-input congested-form" type="text" name="new_corr_vill" id="new_corr_vill" value="<? echo $os->getVal('corr_vill'); ?>">
          </td>
          <td>P.O.</td>
          <td><input class="uk-input congested-form" type="text" name="new_corr_po" id="new_corr_po" value="<? echo $os->getVal('corr_po'); ?>">
          </td>
        </tr>
        <tr>
          <td>Police station</td>
          <td><input class="uk-input congested-form" type="text" name="new_corr_ps" id="new_corr_ps" value="<? echo $os->getVal('corr_ps'); ?>">
          </td>
          <td>Block/Municipality</td>
          <td><input class="uk-input congested-form" type="text" name="new_corr_block" id="new_corr_block" value="<? echo $os->getVal('corr_block'); ?>">
          </td>
        </tr>
        <tr>
          <td> PIN</td>
          <td><input class="uk-input congested-form" type="text" name="new_corr_pin" id="new_corr_pin" value="<? echo $os->getVal('corr_pin'); ?>">
          </td>
          <td>District</td>
          <td><input class="uk-input congested-form" type="text" name="new_corr__dist" id="new_corr__dist" value="<? echo $os->getVal('corr__dist'); ?>">
          </td>
        </tr>
        <tr>
          <td>State</td>
          <td><input class="uk-input congested-form" type="text" name="new_corr_state" id="new_corr_state" value="<? echo $os->getVal('corr_state'); ?>">
          </td>
          <td>--</td>
          <td> -- </td>
        </tr>
        <tr>
          <td colspan="5" style="font-weight:bold;">Contact Information </td>
        </tr>
        <tr>
          <td>Mobile Number </td>
          <td><input class="uk-input congested-form" type="text" name="new_student_mobile_student" id="new_student_mobile_student"  value="<? echo $os->getVal('mobile_student'); ?>"/>
          </td>
          <td>Alternative Mob No</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_mobile_student_alternet" id="new_student_mobile_student_alternet" value="<? echo $os->getVal('mobile_student_alternet'); ?>" />
          </td>
        </tr>
        <tr>
          <td>Whatsapp No</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_mobile_student_whatsapp" id="new_student_mobile_student_whatsapp" value="<? echo $os->getVal('mobile_student_whatsapp'); ?>" />
          </td>
          <td>E-mail Id</td>
          <td><input class="uk-input congested-form" type="text" name="new_student_email_student" id="new_student_email_student" value="<? echo $os->getVal('email_student'); ?>" />
          </td>
        </tr>
      </table>
      <div class="vspace"> </div>
      <table style="width:100%"  >
        <tr>
          <td colspan="5"><h2> BOARD EXAM INFORMATION </h2></td>
        </tr>
        <tr>
          <td colspan="5" style="font-weight:bold;">10th Std. </td>
        </tr>
        <tr>
          <td style="width:100px;">Name of Board </td>
          <td  style="width:100px;"><select class="uk-select congested-form" name="new_ten_name_of_board" id="new_ten_name_of_board"   >
              <option value="" > </option>
              <?  $os->onlyOption($os->boardname_list,$os->getVal('ten_name_of_board'));?>
            </select>
          </td>
          <td  style="width:100px;">Year of Passing</td>
          <td  style="width:100px;"><!--<input class="uk-input congested-form" type="text" name="new_ten_passed_year" id="new_ten_passed_year" value="<? echo $os->
            getVal('ten_passed_year'); ?>"> -->
            <select class="uk-select congested-form" name="new_ten_passed_year" id="new_ten_passed_year"  >
              <option value="" > </option>
              <?  $os->onlyOption($os->year_of_passing,$os->getVal('ten_passed_year'));?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Roll </td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_roll" id="new_ten_roll" value="<? echo $os->getVal('ten_roll'); ?>">
          </td>
          <td>No</td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_no" id="new_ten_no" value="<? echo $os->getVal('ten_no'); ?>">
          </td>
        </tr>
        <tr>
          <td colspan="5">Mark Obtained </td>
        </tr>
        <tr>
          <td>Beng/Hindi </td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_beng_hindi" id="new_ten_marks_beng_hindi" value="<? echo $os->getVal('ten_marks_beng_hindi'); ?>">
          </td>
          <td>English</td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_eng" id="new_ten_marks_eng" value="<? echo $os->getVal('ten_marks_eng'); ?>">
          </td>
        </tr>
        <tr>
          <td>Mathematics </td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_math" id="new_ten_marks_math" value="<? echo $os->getVal('ten_marks_math'); ?>">
          </td>
          <td>Physical Science</td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_physc" id="new_ten_marks_physc" value="<? echo $os->getVal('ten_marks_physc'); ?>">
          </td>
        </tr>
        <tr>
          <td>Life Science </td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_lifesc" id="new_ten_marks_lifesc" value="<? echo $os->getVal('ten_marks_lifesc'); ?>">
          </td>
          <td>History</td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_history" id="new_ten_marks_history" value="<? echo $os->getVal('ten_marks_history'); ?>">
          </td>
        </tr>
        <tr>
          <td>Geography </td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_geography" id="new_ten_marks_geography" value="<? echo $os->getVal('ten_marks_geography'); ?>">
          </td>
          <td>Social Science</td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_socialsc" id="new_ten_marks_socialsc" value="<? echo $os->getVal('ten_marks_socialsc'); ?>">
          </td>
        </tr>
        <tr>
          <td>Total Marks obt. </td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_total_obt" id="new_ten_marks_total_obt" value="<? echo $os->getVal('ten_marks_total_obt'); ?>">
          </td>
          <td>out of</td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_out_of" id="new_ten_marks_out_of" value="<? echo $os->getVal('ten_marks_out_of'); ?>">
          </td>
        </tr>
        <tr>
          <td>Percentage </td>
          <td><input class="uk-input congested-form" type="text" name="new_ten_marks_percent" id="new_ten_marks_percent" value="<? echo $os->getVal('ten_marks_percent'); ?>">
          </td>
          <td> -</td>
          <td> - </td>
        </tr>
        <tr>
          <td colspan="5" style="font-weight:bold;">12th Std </td>
        </tr>
        <tr>
          <td>Name of Board </td>
          <td><select class="uk-select congested-form" name="new_twelve_name_of_board" id="new_twelve_name_of_board"   >
              <option value="" > </option>
              <?  $os->onlyOption($os->boardname_list,$os->getVal('twelve_name_of_board'));?>
            </select>
          </td>
          <td>Year of Passing</td>
          <td><!-- <input class="uk-input congested-form" type="text" name="new_twelve_passed_year" id="new_twelve_passed_year" value="<? echo $os->
            getVal('twelve_passed_year'); ?>">-->
            <select class="uk-select congested-form" name="new_twelve_passed_year" id="new_twelve_passed_year"  >
              <option value="" > </option>
              <?  $os->onlyOption($os->year_of_passing,$os->getVal('twelve_passed_year'));?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Roll </td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_roll" id="new_twelve_roll" value="<? echo $os->getVal('twelve_roll'); ?>">
          </td>
          <td>No</td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_no" id="new_twelve_no" value="<? echo $os->getVal('twelve_no'); ?>">
          </td>
        </tr>
        <tr>
          <td>Stream </td>
          <td><select class="uk-select congested-form" name="new_twelve_stream" id="new_twelve_stream"   >
              <option value="" > </option>
              <?  $os->onlyOption($os->twelve_stream_list,$os->getVal('twelve_stream'));?>
            </select>
          </td>
          <td>-</td>
          <td> - </td>
        </tr>
        <tr>
          <td colspan="5">Mark Obtained (For Sc. But other than sc Subjects should be blank for self written) </td>
        </tr>
        <tr>
          <td>Beng/Hindi </td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_beng_hindi" id="new_twelve_marks_beng_hindi" value="<? echo $os->getVal('twelve_marks_beng_hindi'); ?>">
          </td>
          <td>English</td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_eng" id="new_twelve_marks_eng" value="<? echo $os->getVal('twelve_marks_eng'); ?>">
          </td>
        </tr>
        <tr>
          <td>Mathematics </td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_math" id="new_twelve_marks_math" value="<? echo $os->getVal('twelve_marks_math'); ?>">
          </td>
          <td>Physics</td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_physc" id="new_twelve_marks_physc" value="<? echo $os->getVal('twelve_marks_physc'); ?>">
          </td>
        </tr>
        <tr>
          <td>Chemistry </td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_chemistry" id="new_twelve_marks_chemistry" value="<? echo $os->getVal('twelve_marks_chemistry'); ?>">
          </td>
          <td>Biology</td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_biology" id="new_twelve_marks_biology" value="<? echo $os->getVal('twelve_marks_biology'); ?>">
          </td>
        </tr>
        <tr>
          <td>Total Marks obt. </td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_total_obt" id="new_twelve_marks_total_obt" value="<? echo $os->getVal('twelve_marks_total_obt'); ?>">
          </td>
          <td>out of</td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_out_of" id="new_twelve_marks_out_of" value="<? echo $os->getVal('twelve_marks_out_of'); ?>">
          </td>
        </tr>
        <tr>
          <td>Percentage </td>
          <td><input class="uk-input congested-form" type="text" name="new_twelve_marks_percent" id="new_twelve_marks_percent" value="<? echo $os->getVal('twelve_marks_percent'); ?>">
          </td>
          <td>-</td>
          <td> - </td>
        </tr>
        <tr>
          <td colspan="5" style="font-weight:bold;">Graduate level (For Completive Exam) </td>
        </tr>
        <tr>
          <td>Passed </td>
          <td><select class="uk-select congested-form" name="new_graduate_passed" id="new_graduate_passed"   >
              <option value="" > </option>
              <?  $os->onlyOption($os->graduate_passed_list,$os->getVal('graduate_passed'));?>
            </select>
          </td>
          <td>If Passed with Hons. Subject</td>
          <td><input class="uk-input congested-form" type="text" name="new_graduate_passed_subject" id="new_graduate_passed_subject" value="<? echo $os->getVal('graduate_passed_subject'); ?>">
          </td>
        </tr>
        <tr>
          <td>Year of Passing </td>
          <td><input class="uk-input congested-form" type="text" name="new_graduate_passed_year" id="new_graduate_passed_year" value="<? echo $os->getVal('graduate_passed_year'); ?>">
          </td>
          <td>University</td>
          <td><input class="uk-input congested-form" type="text" name="new_graduate_passed_university" id="new_graduate_passed_university" value="<? echo $os->getVal('graduate_passed_university'); ?>">
          </td>
        </tr>
        <tr>
          <td>Subjects Taken </td>
          <td colspan="10"><input class="uk-input congested-form" type="text" name="new_graduate_subjects" id="new_graduate_subjects" value="<? echo $os->getVal('graduate_subjects'); ?>" placeholder="1          2          3         4         5       " style="width:100%;">
          </td>
        </tr>
        <tr>
          <td>Marks obt. In final year </td>
          <td colspan="10"><input class="uk-input congested-form" type="text" name="new_graduate_subjects_marks" id="new_graduate_subjects_marks" value="<? echo $os->getVal('graduate_subjects_marks'); ?>" placeholder="1          2          3         4         5       " style="width:100%;">
          </td>
        </tr>
        <tr>
          <td>Total </td>
          <td><input class="uk-input congested-form" type="text" name="new_graduate_total_obt" id="new_graduate_total_obt" value="<? echo $os->getVal('graduate_total_obt'); ?>">
          </td>
          <td>Out of</td>
          <td><input class="uk-input congested-form" type="text" name="new_graduate_out_of" id="new_graduate_out_of" value="<? echo $os->getVal('graduate_out_of'); ?>">
          </td>
        </tr>
        <tr>
          <td>Percentage </td>
          <td><input class="uk-input congested-form" type="text" name="new_graduate_percent" id="new_graduate_percent" value="<? echo $os->getVal('graduate_percent'); ?>">
          </td>
          <td>-</td>
          <td> - </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top" colspan="2"><table >
        <tr>
          <td>Any brother or sister presently read in Mission </td>
          <td><select class="uk-select congested-form" name="new_any_bro_sis_presently" id="new_any_bro_sis_presently" onchange="toggle_block('new_any_bro_sis_presently','new_bro_sis_presently_details_container')"   >
              <option value="" > </option>
              <?  $os->onlyOption($os->yesno,$os->getVal('any_bro_sis_presently'));?>
            </select>
          </td>
        </tr>
        <? $any_bro_sis_presently=$os->getVal('any_bro_sis_presently'); ?>
        <tr id="new_bro_sis_presently_details_container" style="  <? if($any_bro_sis_presently!='Yes'){ ?> display:none;<? }else{ ?> <?  } ?>  ">
          <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_present"  style="background-color:#DFEFFF;">
              <tr>
                <td>Reg. No</td>
                <td>Name</td>
                <td>Branch </td>
                <td>Class</td>
                <td>Fees</td>
              </tr>
              <?
  $bro_sis_p_d=	unserialize($os->data['bro_sis_presently_details']);
   foreach($bro_sis_p_d['regno'] as $key=>$val){ 
   
 //  _d($bro_sis_p_d['regno']);
   if(trim($bro_sis_p_d['name'])!=''){
  ?>
              <tr >
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[regno][]" id="new_bro_sis_presently_details[regno][]" 	
	 value="<? echo $bro_sis_p_d['regno'][$key]; ?>"  ></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[name][]" id="new_bro_sis_presently_details[name][]"	
	 value="<? echo $bro_sis_p_d['name'][$key]; ?>"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[branch][]" id="new_bro_sis_presently_details[branch][]"	
	 value="<? echo $bro_sis_p_d['branch'][$key]; ?>"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[class][]" id="new_bro_sis_presently_details[class][]"	
	 value="<? echo $bro_sis_p_d['class'][$key]; ?>"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[fees][]" id="new_bro_sis_presently_details[fees][]"	
	 value="<? echo $bro_sis_p_d['fees'][$key]; ?>"></td>
              </tr>
              <? } } ?>
              <tr id="row_present">
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[regno][]" id="new_bro_sis_presently_details[regno][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[name][]" id="new_bro_sis_presently_details[name][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[branch][]" id="new_bro_sis_presently_details[branch][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[class][]" id="new_bro_sis_presently_details[class][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[fees][]" id="new_bro_sis_presently_details[fees][]"></td>
              </tr>
            </table>
            <br />
            <div style="text-align:right; color:#000099;cursor:pointer;" onclick="copy_input_row('row_present','table_present');"> Add More </div></td>
        </tr>
        <tr>
          <td>Any brother or sister passed from Mission </td>
          <td><select class="uk-select congested-form" name="new_any_bro_sis_passed" id="new_any_bro_sis_passed" onchange="toggle_block('new_any_bro_sis_passed','new_bro_sis_passed_details_container')"     >
              <option value="" > </option>
              <?  $os->onlyOption($os->yesno,$os->getVal('any_bro_sis_passed'));?>
            </select>
          </td>
        </tr>
        <? $any_bro_sis_passed=$os->getVal('any_bro_sis_passed'); ?>
        <tr id="new_bro_sis_passed_details_container" style=" <? if($any_bro_sis_passed!='Yes'){ ?> display:none;<? }else{ ?>  ;<?  } ?>">
          <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_passed"  style="background-color:#DFEFFF;">
              <tr>
                <td>Reg. No</td>
                <td>Name</td>
                <td>Branch </td>
                <td>Class</td>
                <td>Now what dose he/she do</td>
              </tr>
              <?
  
   
  $bro_sis_pa_d=	unserialize($os->data['bro_sis_passed_details']);
   foreach($bro_sis_pa_d['regno'] as $key=>$val){ 
    if(trim($bro_sis_pa_d['name'])!=''){
  ?>
              <tr style="background-color:#FF0000" >
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[regno][]" id="new_bro_sis_passed_details[regno][]" 	
	 value="<? echo $bro_sis_pa_d['regno'][$key]; ?>"  ></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[name][]" id="new_bro_sis_passed_details[name][]"	
	 value="<? echo $bro_sis_pa_d['name'][$key]; ?>"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[branch][]" id="new_bro_sis_passed_details[branch][]"	
	 value="<? echo $bro_sis_pa_d['branch'][$key]; ?>"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[class][]" id="new_bro_sis_passed_details[class][]"	
	 value="<? echo $bro_sis_pa_d['class'][$key]; ?>"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[nowdoing][]" id="new_bro_sis_passed_details[nowdoing][]"	
	 value="<? echo $bro_sis_pa_d['nowdoing'][$key]; ?>"></td>
              </tr>
              <? }  } ?>
              <tr id="row_passed">
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[regno][]" id="new_bro_sis_passed_details[regno][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[name][]" id="new_bro_sis_passed_details[name][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[branch][]" id="new_bro_sis_passed_details[branch][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[class][]" id="new_bro_sis_passed_details[class][]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[nowdoing][]" id="new_bro_sis_passed_details[nowdoing][]"></td>
              </tr>
            </table>
            <div style="text-align:right; color:#000099;cursor:pointer;" onclick="copy_input_row('row_passed','table_passed');"> Add More </div></td>
        </tr>
        <tr>
          <td>Any of family member is employee of Mission </td>
          <td><select class="uk-select congested-form" name="new_any_family_is_mission_emp" id="new_any_family_is_mission_emp" onchange="toggle_block('new_any_family_is_mission_emp','new_family_is_mission_emp_details_container')"     >
              <option value="" > </option>
              <?  $os->onlyOption($os->yesno,$os->getVal('any_family_is_mission_emp'));?>
            </select>
          </td>
        </tr>
        <? $any_family_is_mission_emp=$os->getVal('any_family_is_mission_emp'); ?>
        <tr id="new_family_is_mission_emp_details_container" style=" <? if($any_family_is_mission_emp!='Yes'){ ?> display:none;<? }else{ ?>  <?  } ?>">
          <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_emp"  style="background-color:#DFEFFF;">
              <tr>
                <td>Employee ID</td>
                <td>Name</td>
                <td>Relationship </td>
                <td>Branch</td>
                <td>Department</td>
              </tr>
              <?
  $family_is_m_e_d=	unserialize($os->data['family_is_mission_emp_details']);
   foreach($family_is_m_e_d['empid'] as $key=>$val){ 
   if(trim($family_is_m_e_d['name'])!=''){
  ?>
              <tr >
                <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[empid][]" id="new_family_is_mission_emp_details[empid][]" 	
	 value="<? echo $family_is_m_e_d['empid'][$key]; ?>"  ></td>
                <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[name][]" id="new_family_is_mission_emp_details[name][]"	
	 value="<? echo $family_is_m_e_d['name'][$key]; ?>"></td>
                <td><!--<input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[relation][]" id="new_family_is_mission_emp_details[relation][]"	
	 value="<? echo $family_is_m_e_d['relation'][$key]; ?>">-->
                  <select class="uk-select congested-form" name="new_family_is_mission_emp_details[relation][]" id="new_family_is_mission_emp_details[relation][]"    >
                    <option value="" > </option>
                    <?  $os->onlyOption($os->family_member_relation,$family_is_m_e_d['relation'][$key]);?>
                  </select>
                </td>
                <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[branch][]" id="new_family_is_mission_emp_details[branch][]"	
	 value="<? echo $family_is_m_e_d['branch'][$key]; ?>"></td>
                <td><!--<input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[department][]" id="new_family_is_mission_emp_details[department][]"	
	 value="<? echo $family_is_m_e_d['department'][$key]; ?>">-->
                  <select class="uk-select congested-form" name="new_family_is_mission_emp_details[department][]" id="new_family_is_mission_emp_details[department][]"   >
                    <option value="" > </option>
                    <?  $os->onlyOption($os->family_member_emp_dept,$family_is_m_e_d['department'][$key]);?>
                  </select>
                </td>
              </tr>
              <? } } ?>
              <tr id="row_emp">
                <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[empid][]" id="new_family_is_mission_emp_details[empid]"></td>
                <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[name][]" id="new_family_is_mission_emp_details[name]"></td>
                <td><!--<input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[relation][]" id="new_family_is_mission_emp_details[relation]">-->
                  <select class="uk-select congested-form" name="new_family_is_mission_emp_details[relation][]" id="new_family_is_mission_emp_details[relation][]"    >
                    <option value="" > </option>
                    <?  $os->onlyOption($os->family_member_relation,'');?>
                  </select>
                </td>
                <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[branch][]" id="new_family_is_mission_emp_details[branch]"></td>
                <td><!--<input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[department][]" id="new_family_is_mission_emp_details[department]">-->
                  <select class="uk-select congested-form" name="new_family_is_mission_emp_details[department][]" id="new_family_is_mission_emp_details[department][]"   >
                    <option value="" > </option>
                    <?  $os->onlyOption($os->family_member_emp_dept,'');?>
                  </select>
                </td>
              </tr>
            </table>
            <div style="text-align:right; color:#000099; cursor:pointer;" onclick="copy_input_row('row_emp','table_emp');"> Add More </div></td>
        </tr>
      </table>
    <td valign="top"><h1> EDIT LOG HISTORY </h1>
      <div style="width:100%; font-size:10px; background-color:#FFB7DB;    " >
        <table class="log" >
          <?

                            while($edit_log=$os->mfa( $edit_log_q_rs))
                            {

                                $table_field=$edit_log['table_field'];
                                $alise_student['father_name']='Father Name';
                                $alise_student['gender']='Gender';
                                $alise_student['name']='Name';
                                $alise_student['otpPass']='Password';

                                $alise_student['status_active']='Active Status';


                                $alise_student['vill']='Vill';
                                $alise_student['po']='PO';
                                $alise_student['ps']='PS';
                                $alise_student['dist']='DIST';
                                $alise_student['pin']='PIN';



                                $alise_val=$table_field;
                                if(isset($alise_student[$table_field]))
                                {
                                    $alise_val=$alise_student[$table_field];
                                }

                                ?>
          <tr>
            <td   style="padding:1px;border-bottom:1px solid #CCCCCC; color:#999999"><span style="color:#009900; "> <? echo $alise_student[$table_field] ?> Edited </span><br />
              <span title="Old value:  <? echo  $edit_log['old_val']; ?>" > <? echo  $edit_log['new_val']; ?> </span> </td>
            <td   style="padding:1px;border-bottom:1px solid #CCCCCC; color:#CC6600"><span style="color:#005EBB" title="<? echo  $os->showDate($edit_log['addedDate'],'H:i:s'); ?>"> <? echo  $os->showDate($edit_log['addedDate']); ?> </span> By <? echo  $edit_log['admin_name']; ?> [ <? echo  $edit_log['addedBy']; ?>] </td>
          </tr>
          <? }?>
          <tr>
            <td  > Added New Record </td>
            <td   style="padding:1px;border-bottom:1px solid #CCCCCC; color:#CC6600"><span style="color:#005EBB" title="<? echo  $os->showDate($student['addedDate'],'H:i:s'); ?>"> Date: <? echo  $os->showDate($student['addedDate']); ?> </span> By: <? echo  $student['admin_name']; ?> [ <? echo  $student['addedBy']; ?>] </td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
<button class="bp3-button bp3-small bp3-intent-primary" type="button" value="ADD STUDENT" onclick="update_student_data()">Save</button>
<span style="font-size:14px; font-weight:bold" id="update_student_data_msg"></span> 