<?
global $os,$registrationNo;
// $os->medium_list=array('Bengali'=>'Bengali','English'=>'English');
// $os->nationality_list=array('Indian'=>'Indian','Other'=>'Other');
// $os->nationality_list=array('Indian'=>'Indian','Other'=>'Other');
// $os->caste_list=array('Gen'=>'Gen','OBC-A'=>'OBC-A','OBC-B'=>'OBC-B'); 
// $os->body_parts_list=array('Leg'=>'Leg','Hand'=>'Hand','Eye'=>'Eye','Ear'=>'Ear'); 
// $os->living_area_dists_list=array('Dist.'=>'Dist.','Sub-Division'=>'Sub-Division','Town'=>'Town','Semi-Town'=>'Semi-Town','Vill'=>'Vill');
// $os->living_area_gram_panchayet_list=array('Gram Panchayet'=>'Gram Panchayet','Municipality'=>'Municipality');

 
// $os->father_qualification_list=array('Primary'=>'Primary','Upper Primary'=>'Upper Primary','Secondary'=>'Secondary','Higher Secondary'=>'Higher Secondary','graduate'=>'graduate','Post Graduate'=>'Post Graduate','Illiterate'=>'Illiterate'); 
// $os->mother_qualification_list=array('Primary'=>'Primary','Upper Primary'=>'Upper Primary','Secondary'=>'Secondary','Higher Secondary'=>'Higher Secondary','graduate'=>'graduate','Post Graduate'=>'Post Graduate','Illiterate'=>'Illiterate'); 
 
   
// 	$os->boardname_list=array('CBSE'=>'CBSE','ICSE'=>'ICSE','WBBME'=>'WBBME','WBBSE'=>'WBBSE');   
// 	$os->twelve_stream_list=array('Sc'=>'Sc','Arts'=>'Arts','Comers'=>'Comers');   
	
	 
	
// 	  $os->graduate_passed_list=array('With Hons.'=>'With Hons.','Without Hons'=>'Without Hons' ); 

 
?>

<table class="uk-table congested-table uk-table-justify">
      <tr><td colspan="5"> <h2> 1.	STUDENT BASIC INFORMATION  </h2></td> </tr>
	  <tr><td style="width:280px;">Student Regn. No. </td><td style="color:#0033FF; font-size:16px; font-weight:bold;"> <?=$registrationNo; ?> </td> </tr>
	  
	   <tr><td>Name of the student <span class="star">*</span></td><td> <input class="uk-input congested-form" type="text" name="new_student_name" id="new_student_name"  /> </td> </tr>
	  
	  <tr><td>Branch <span class="star">*</span></td><td>  <select   name="new_student_branch_code" id="new_student_branch_code"
                            class="uk-select uk-border-rounded congested-form   "   >
                        <? $os->onlyOption($branch_code_arr,$os->getSession('new_student_branch_code'));	?>
                    </select> </td> </tr>
					
					 <tr><td>Session<span class="star">*</span></td><td> <select class="uk-select congested-form"  name="new_student_asession" id="new_student_asession">
                        <option value=""> </option>
                        <?

                        $os->onlyOption($os->asession,$os->getSession('new_student_asession'));
                        ?>
                    </select> </td> </tr>
	  <tr><td>Class<span class="star">*</span></td><td> <select class="uk-select congested-form" name="new_student_class" id="new_student_class"   >
                        <option value=""></option>




                        <? 
					    $new_student_class_session=	$os->getSession('new_student_class');
						
						foreach($os->board_class as $board=>$classes){?>
                            <optgroup label="<?=$board?>">
                                <? foreach ($classes as $class){?>
                                    <option  <? if($new_student_class_session==$class){ ?> selected="selected" <? } ?>      value="<? echo $class?>"> <? echo $os->classList[$class]?></option>
                                <? }?>
                            </optgroup>
                        <? } ?>



                    </select> </td> </tr>
		 <tr><td>Gender <span class="star">*</span> </td><td> <select class="uk-select congested-form" name="new_student_gender" id="new_student_gender"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->gender,$os->getSession('new_student_gender'));?>
                    </select> </td> </tr>
					
					 
					
				 <tr><td>Student Type <span class="star">*</span> </td><td> <select   id="new_student_student_type" name="new_student_student_type"  >
                    <option value="" > </option>
                    <?  $os->onlyOption($os->student_type,  'Hosteler' );?>
                </select> </td> </tr>	
				
				
					 <tr> <td></td><td colspan="2"><button class="bp3-button bp3-small bp3-intent-primary" type="button" value="ADD STUDENT" onclick="save_add_new_student_data()">Add Student</button> </td> </tr>	
				
				
				
					
		<tr style="display:none;"><td>Section </td><td> <input class="uk-input congested-form" type="text" name="new_student_section" id="new_student_section"  />	 </td> </tr>
		<tr  style="display:none;"><td>Roll No </td><td> <input class="uk-input congested-form" type="text" name="new_student_roll_no" id="new_student_roll_no"  /> 	 </td> </tr>					
				
		
					
	  <tr><td>Medium</td><td>   
	  
	  <select   name="new_medium" id="new_medium"
                            class="uk-select uk-border-rounded congested-form   "   >
                        <? $os->onlyOption($os->medium_list,'');	?>
                    </select>
	  
	   </td> </tr> 
	  <tr><td>Date of Admission / Registration</td><td> <input class="uk-input congested-form datepicker" type="text" name="new_student_registerDate" id="new_student_registerDate"  />	 </td> </tr>
	  
	  
	 
	  <tr style="display:none;"><td>Present Fees</td><td> <input class="uk-input congested-form" type="text" name="new_present_fees" id="new_present_fees"> </td> </tr>
	 
	 
	  
	  <tr><td>Date of Birth</td><td> <input class="uk-input congested-form datepicker" type="text" name="new_student_dob" id="new_student_dob" /> </td> </tr>
	  <tr><td>Aadhaar No</td><td> <input class="uk-input congested-form" type="text" name="new_student_adhar_no" id="new_student_adhar_no"  />	 </td> </tr>
	  <tr><td>Nationality</td><td><select class="uk-select congested-form" name="new_nationality" id="new_nationality" onchange="nantionality_data();"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->nationality_list,'');?>
                    </select>
					
					
					   </td> </tr>
	  <tr id="nantionality_data_container" style="display:none;"><td>
	  
	
	  
	  
	  </td><td>
	  
	  <table   border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Country name(if other) </td>
    <td><input class="uk-input congested-form" type="text" name="new_country_name" id="new_country_name"></td>
  </tr>
  <tr>
    <td>Passport No.</td>
    <td> <input class="uk-input congested-form" type="text" name="new_passport_no" id="new_passport_no">   </td>
  </tr>
  <tr>
    <td>Vissa Type</td>
    <td><input class="uk-input congested-form" type="text" name="new_vissa_type" id="new_vissa_type"> </td>
  </tr>
  <tr>
    <td>Valid up to</td>
    <td> <input class="uk-input congested-form" type="text" name="new_passport_valid_up_to" id="new_passport_valid_up_to"></td>
  </tr>
</table>
	 
	 
	  </td> </tr>
	 
	 
	 
	 
	 
	 
	  <tr><td>Religion</td><td>  <input class="uk-input congested-form" type="text" name="new_student_religian" id="new_student_religian"  value="Islam" />	 </td> </tr>
	  <tr><td>Category</td><td>   
	  
	  
	  <select class="uk-select congested-form" name="new_student_caste" id="new_student_caste" onchange="caste_data();"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->caste_list,'');?>
                    </select>
	  </td> </tr>
	  <tr id="caste_data_container" style="display:none;"><td>
	  
	  
	  </td><td> 
	  
	  <table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Certificate No.</td>
    <td>  <input class="uk-input congested-form" type="text" name="new_caste_cert_no" id="new_caste_cert_no"></td>
  </tr>
  <tr>
    <td> Issuing authority</td>
    <td><input class="uk-input congested-form" type="text" name="new_cast_cert_issue_auth" id="new_cast_cert_issue_auth"></td>
  </tr>
  <tr>
    <td> Date of issue</td>
    <td><input class="uk-input congested-form datepicker" type="text" name="new_cast_cert_issue_date" id="new_cast_cert_issue_date"></td>
  </tr>
</table>

	  
	  
	  
			    </td> </tr>
	  
	  
	  
	  <tr><td>Whether Physically Challenged</td><td>   
	  <select class="uk-select congested-form" name="new_disabled" id="new_disabled"  onchange="disabled_data();"  >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->yesno,'');?>
                    </select>
	  
	    </td> </tr>
	  <tr id="disabled_data_container" style="display:none;"><td>
	 
	  
	  </td><td> 
	  
	  
	  
	   <table> 
	   <tr> <td> Body Part of Disability   </td><td><select class="uk-select congested-form" name="new_disable_body_parts" id="new_disable_body_parts"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->body_parts_list,'');?>
                    </select></td></tr>
	<tr> <td> Percentage </td><td><input class="uk-input congested-form" type="text" name="new_disable_percet" id="new_disable_percet"></td></tr>
	<tr> <td>Certificate No.</td><td> <input class="uk-input congested-form" type="text" name="new_disable_cert_no" id="new_disable_cert_no"></td></tr>
	<tr> <td> Issuing Authority </td><td> <input class="uk-input congested-form" type="text" name="new_disable_cert_issue_auth" id="new_disable_cert_issue_auth"> </td></tr>
	<tr><td> Date of issue </td><td><input class="uk-input congested-form datepicker" type="text" name="new_disable_cert_issue_date" id="new_disable_cert_issue_date"></td></tr>
	
	 </table>
	
	</td> </tr>
	  
	 
	  <tr><td>Living area
	  </td><td>  
	  
	   <select class="uk-select congested-form" name="new_living_area_dist" id="new_living_area_dist"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->living_area_dists_list,'');?>
                    </select>
	  
	 
	  
	 <!--   <input class="uk-input congested-form" type="text" name="new_living_area_sub_division" id="new_living_area_sub_division">  <input class="uk-input congested-form" type="text" name="new_living_area_town" id="new_living_area_town">
	  <input class="uk-input congested-form" type="text" name="new_living_area_semi_town" id="new_living_area_semi_town"> 
	  <input class="uk-input congested-form" type="text" name="new_living_area_vill" id="new_living_area_vill">  -->
	  </td> </tr>
		<tr><td>Local Administration</td><td>  
		 <select class="uk-select congested-form" name="new_living_area_gram_panchayet" id="new_living_area_gram_panchayet"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->living_area_gram_panchayet_list,'');?>
                    </select>
		
		 </td> </tr>
		
		<tr><td>Any brother or sister presently read in Oriental English Academy </td><td>  
		<select class="uk-select congested-form" name="new_any_bro_sis_presently" id="new_any_bro_sis_presently" onchange="toggle_block('new_any_bro_sis_presently','new_bro_sis_presently_details_container')"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->yesno,'');?>
                    </select>
		
		   </td> </tr>
		<tr id="new_bro_sis_presently_details_container" style="display:none;">
		
		<td>  </td><td colspan="5">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_present">
  <tr>
    <td>Reg. No</td>
    <td>Name</td>
    <td>Branch </td>
    <td>Class</td>
    <td>Fees</td>
  </tr>
  <tr id="row_present">
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[regno][]" id="new_bro_sis_presently_details[regno][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[name][]" id="new_bro_sis_presently_details[name][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[branch][]" id="new_bro_sis_presently_details[branch][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[class][]" id="new_bro_sis_presently_details[class][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_presently_details[fees][]" id="new_bro_sis_presently_details[fees][]"></td>
  </tr>
  
  
</table>
<br />
<div style="text-align:right; color:#000099;cursor:pointer;" onclick="copy_input_row('row_present','table_present');"> Add More </div>

 </td> </tr>
	
		<tr><td>Any brother or sister passed from Oriental English Academy   </td><td>  
		
		<select class="uk-select congested-form" name="new_any_bro_sis_passed" id="new_any_bro_sis_passed" onchange="toggle_block('new_any_bro_sis_passed','new_bro_sis_passed_details_container')"     >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->yesno,'');?>
                    </select>
		
		  </td> </tr>
		<tr id="new_bro_sis_passed_details_container" style="display:none;">
		<td>  </td>
		<td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_passed">
  <tr>
    <td>Reg. No</td>
    <td>Name</td>
    <td>Branch </td>
    <td>Class</td>
    <td>Now what dose he/she do</td>
  </tr>
  <tr id="row_passed">
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[regno][]" id="new_bro_sis_passed_details[regno][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[name][]" id="new_bro_sis_passed_details[name][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[branch][]" id="new_bro_sis_passed_details[branch][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[class][]" id="new_bro_sis_passed_details[class][]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_bro_sis_passed_details[nowdoing][]" id="new_bro_sis_passed_details[nowdoing][]"></td>
  </tr>
</table> 

<div style="text-align:right; color:#000099;cursor:pointer;" onclick="copy_input_row('row_passed','table_passed');"> Add More </div>
</td> </tr>
		<tr><td>Any of family member is employee of Oriental English Academy   </td><td>   
		
		<select class="uk-select congested-form" name="new_any_family_is_mission_emp" id="new_any_family_is_mission_emp" onchange="toggle_block('new_any_family_is_mission_emp','new_family_is_mission_emp_details_container')"     >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->yesno,'');?>
                    </select>
		   </td> </tr>
		<tr id="new_family_is_mission_emp_details_container" style="display:none;">
		
		<td>  </td>
		<td colspan="5"> <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_emp">
  <tr>
    <td>Employee ID</td>
    <td>Name</td>
    <td>Relationship </td>
    <td>Branch</td>
    <td>Department</td>
  </tr>
  <tr id="row_emp">
    <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[empid][]" id="new_family_is_mission_emp_details[empid]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[name][]" id="new_family_is_mission_emp_details[name]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[relation][]" id="new_family_is_mission_emp_details[relation]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[branch][]" id="new_family_is_mission_emp_details[branch]"></td>
    <td><input class="uk-input congested-form" type="text" name="new_family_is_mission_emp_details[department][]" id="new_family_is_mission_emp_details[department]"></td>
  </tr>
</table> 
<div style="text-align:right; color:#000099; cursor:pointer;" onclick="copy_input_row('row_emp','table_emp');"> Add More </div>
</td> </tr>
</table>
<table class="uk-table congested-table uk-table-justify">
<td>  </td>
 <tr><td colspan="5"> <h2>2.	PARENTS INFORMATION  </h2></td> </tr>

		<tr><td style="width:280px;">  Father’s name    </td><td>  <input class="uk-input congested-form" type="text" name="new_student_father_name" id="new_student_father_name"  /> </td> </tr>
		<tr> <td>Is he alive </td><td>  
		
		<select class="uk-select congested-form" name="new_is_father_alive" id="new_is_father_alive"    onchange="toggle_block_no('new_is_father_alive','father_dateofdeath_container');toggle_block_no('new_is_father_alive','Gurdian_data_container'); "    >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->yesno,'');?>
                    </select>
					<div id="father_dateofdeath_container" style="display:none; padding-top:10px;">
		  
		  if No Put Date of Death  <input class="uk-input congested-form datepicker" type="text" name="new_father_date_of_death" id="new_father_date_of_death"> 
		  
		  </div>
		  </td> </tr>
		  
		<tr><td>Father’s qualification </td><td>   
		
		<select class="uk-select congested-form" name="new_father_qualification" id="new_father_qualification"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->father_qualification_list,'');?>
                    </select>
		</td> </tr>
		<tr><td> Father’s occupation     </td><td> <input class="uk-input congested-form" type="text" name="new_student_father_ocu" id="new_student_father_ocu"> </td> </tr>
		<tr><td>Father’s Monthly income  </td><td>  <input class="uk-input congested-form" type="text" name="new_father_monthly_income" id="new_father_monthly_income"> </td> </tr>
		<tr><td>Father’s  Aadhaar No       </td><td>  <input class="uk-input congested-form" type="text" name="new_father_adhar" id="new_father_adhar">  </td> </tr>
		
		<tr><td>Mother’s name    </td><td> <input class="uk-input congested-form" type="text" name="new_student_mother_name" id="new_student_mother_name"> </td> </tr>
		<tr><td>Is she alive </td><td>  
		<select class="uk-select congested-form" name="new_is_mother_alive" id="new_is_mother_alive"
		
		onchange="toggle_block_no('new_is_mother_alive','mother_dateofdeath_container'); "    >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->yesno,'');?>
                    </select>
					
					
					
					
					<div id="mother_dateofdeath_container" style="display:none; padding-top:10px;">
		  
		  if No Put Date of Death  <input class="uk-input congested-form datepicker" type="text" name="new_mother_date_of_death" id="new_mother_date_of_death"> 
		  
		  </div>
					
					
					
		
		  </td> </tr>
		 
		<tr><td>Mother’s qualification </td><td>  
		<select class="uk-select congested-form" name="new_mother_qualification" id="new_mother_qualification"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->mother_qualification_list,'');?>
                    </select>
		
		</td> </tr>
		<tr><td>Mother’s occupation     </td><td> <input class="uk-input congested-form" type="text" name="new_student_mother_ocu" id="new_student_mother_ocu"> </td> </tr>
		<tr><td>Mother’s Monthly income  </td><td>  <input class="uk-input congested-form" type="text" name="new_mother_monthly_income" id="new_mother_monthly_income"> </td> </tr>
		<tr><td>Mother’s  Aadhaar No       </td><td> <input class="uk-input congested-form" type="text" name="new_mother_adhar" id="new_mother_adhar">  </td> </tr>
		
		 <tr><td colspan="9">
		<div id="Gurdian_data_container" style="display:none;">
		<table width="100%">
		<tr><td style="font-weight:bold;">Name of Guardian </td><td> <!--( You can skip Gurdian Details If father is  alive)--> </td> </tr>
		<tr><td style="width:280px;">Guardian’s Name       </td><td> <input class="uk-input congested-form" type="text" name="new_student_guardian_name" id="new_student_guardian_name"> </td> </tr>
		<tr><td>Guardian’s Qualification </td><td> <input class="uk-input congested-form" type="text" name="new_gurdian_qualification" id="new_gurdian_qualification"> </td> </tr>
		<tr><td>Guardian’s Occupation</td><td> <input class="uk-input congested-form" type="text" name="new_student_guardian_ocu" id="new_student_guardian_ocu"> </td> </tr>
		<tr><td>Guardian’s Monthly income</td><td> <input class="uk-input congested-form" type="text" name="new_gurdian_monthly_income" id="new_gurdian_monthly_income"> </td> </tr>
		<tr style="display:none"><td>Aadhaar No</td><td> <input class="uk-input congested-form" type="text" name="new_email_guardian" id="new_email_guardian"> </td> </tr>
		<tr><td>Relationship with student </td><td> <input class="uk-input congested-form" type="text" name="new_student_guardian_relation" id="new_student_guardian_relation"> </td> </tr>
		
		
		</table>
		</div>
		</td> </tr>
		
		
		 
</table>


      <table class="uk-table congested-table uk-table-justify">
 <tr><td colspan="5"> <h2> 3.	CORRESPONDENCE INFORMATION  </h2></td> </tr>

		 
		<tr><td colspan="5" style="font-weight:bold;">a>	Permanent Address : </td> </tr>
		<tr><td>Village </td><td> <input class="uk-input congested-form" type="text" name="new_student_vill" id="new_student_vill"  /> </td><td>P.O.</td><td> <input class="uk-input congested-form" type="text" name="new_student_po" id="new_student_po"  /> </td>  </tr>
		<tr><td>Police station</td><td> <input class="uk-input congested-form" type="text" name="new_student_ps" id="new_student_ps"  /> </td><td>Block/Municipality</td><td>  <input class="uk-input congested-form" type="text" name="new_student_block" id="new_student_block"  />  </td> </tr>
		 <tr><td>PIN</td><td> <input class="uk-input congested-form" type="text" name="new_student_pin" id="new_student_pin" 
		 onchange="set_state_dist_by_pin('new_student_pin','new_student_state','new_student_dist')"  /> </td> <td>_</td><td> _ </td> </tr>
		<tr><td>State</td><td> <input class="uk-input congested-form" type="text" name="new_student_state" id="new_student_state"  /> </td> <td>District</td><td> <input class="uk-input congested-form" type="text"  name="new_student_dist" id="new_student_dist"  /> </td> </tr>
		
		
		 

      <tr><td colspan="5" style="font-weight:bold;">b>	Correspondence Address : If permanent & Correspondence are same-  <input  type="checkbox" onchange="autofill_Correspondence()" id="autofill_corr_check_id"/> tick here		then following field will auto filled up from permanent address </td> </tr>
		<tr><td>Village </td><td> <input class="uk-input congested-form" type="text" name="new_corr_vill" id="new_corr_vill"> </td><td>P.O.</td><td> <input class="uk-input congested-form" type="text" name="new_corr_po" id="new_corr_po"> </td>  </tr>
		<tr><td>Police station</td><td> <input class="uk-input congested-form" type="text" name="new_corr_ps" id="new_corr_ps"> </td><td>Block/Municipality</td><td>  <input class="uk-input congested-form" type="text" name="new_corr_block" id="new_corr_block"> </td> </tr>
		<tr><td>PIN</td><td>  <input class="uk-input congested-form" type="text" name="new_corr_pin" id="new_corr_pin"
		
		onchange="set_state_dist_by_pin('new_corr_pin','new_corr_state','new_corr__dist')" 
		> </td> <td>--</td><td> -- </td> </tr> 
		<tr><td>State</td><td> <input class="uk-input congested-form" type="text" name="new_corr_state" id="new_corr_state"> </td> <td>District</td><td>  <input class="uk-input congested-form" type="text" name="new_corr__dist" id="new_corr__dist">  </td> </tr>
		
		 
 <tr><td colspan="5" style="font-weight:bold;">c>	Contact Information </td> </tr>
		<tr><td>Mobile Number  </td><td> <input class="uk-input congested-form" type="text" name="new_student_mobile_student" id="new_student_mobile_student"  /> </td><td>Alternative Mob No</td><td> <input class="uk-input congested-form" type="text" name="new_student_mobile_student_alternet" id="new_student_mobile_student_alternet"  />  </td>  </tr>
		<tr><td>Whatsapp No</td><td> <input class="uk-input congested-form" type="text" name="new_student_mobile_student_whatsapp" id="new_student_mobile_student_whatsapp"  />  </td><td>E-mail Id</td><td> <input class="uk-input congested-form" type="text" name="new_student_email_student" id="new_student_email_student"  /> </td> </tr>
</table>
    
    <table class="uk-table congested-table uk-table-justify">
 <tr><td colspan="5"> <h2> 4.	SCHOOL / ACADEMIC INFORMATION  </h2></td> </tr>

		 
		<tr><td colspan="5" style="font-weight:bold;">Previous / Last attend School Info </td> </tr>
		<tr><td>School Name  </td><td>  <input class="uk-input congested-form" type="text" name="new_last_school" id="new_last_school"> </td><td>Address </td><td> <input class="uk-input congested-form" type="text" name="new_last_school_address" id="new_last_school_address"> </td>  </tr>  
		<tr><td>Last attendant Class  </td><td>  <input class="uk-input congested-form" type="text" name="new_last_class" id="new_last_class"> </td><td>Session</td><td>  <input class="uk-input congested-form" type="text" name="new_last_school_session" id="new_last_school_session">  </td>  </tr>  
		<tr><td>T.C No  </td><td> <input class="uk-input congested-form" type="text" name="new_tc_no" id="new_tc_no"> </td><td>Issue date of T.C </td><td>  <input class="uk-input congested-form datepicker" type="text" name="new_tc_date" id="new_tc_date"> </td>  </tr>  
		<tr><td>Student ID No in T.C  </td><td>  <input class="uk-input congested-form" type="text" name="new_student_id_in_TC" id="new_student_id_in_TC"> </td><td>-</td><td> - </td>  </tr> 
		 
		 
		 
		 
		 
		<tr><td colspan="5" style="font-weight:bold;">Present School </td> </tr>
		<tr><td>Name of admitted School  </td><td> <input class="uk-input congested-form" type="text" name="new_present_school" id="new_present_school"> </td><td>  </td><td>   </td>  </tr>  
		<tr><td>School Address </td><td> <input class="uk-input congested-form" type="text" name="new_present_school_address" id="new_present_school_address">  </td><td>School Phone No </td><td>  <input class="uk-input congested-form" type="text" name="new_present_school_contact" id="new_present_school_contact">  </td>  </tr>  
		<tr><td>Admitted in class  </td><td>  <input class="uk-input congested-form" type="text" name="new_present_school_class" id="new_present_school_class"> </td><td>Admitted in session </td><td> <input class="uk-input congested-form" type="text" name="new_present_school_session" id="new_present_school_session"> </td>  </tr>  
		<tr><td>School Roll No   </td><td>  <input class="uk-input congested-form" type="text" name="new_present_school_roll" id="new_present_school_roll"> </td><td>School Section </td><td> <input class="uk-input congested-form" type="text" name="new_present_school_section" id="new_present_school_section"> </td>  </tr>  
		 
		
		        
   </table>
   
    <table class="uk-table congested-table uk-table-justify">
 <tr><td colspan="5"> <h2> Student Bank info  </h2></td> </tr>

		 
		 
		<tr><td>Name of the Bank  </td><td>  <input class="uk-input congested-form" type="text" name="new_bank_name" id="new_bank_name">  </td><td>Bank Branch </td><td> <input class="uk-input congested-form" type="text" name="new_bank_branch" id="new_bank_branch">  </td>  </tr>      
		<tr><td>IFSC code   </td><td> <input class="uk-input congested-form" type="text" name="new_ifscCode" id="new_ifscCode">  </td><td>Account No  </td><td> <input class="uk-input congested-form" type="text" name="new_accNo" id="new_accNo"> </td>  </tr>  
		
		
		<tr><td colspan="5"> <h2> Kanyashree information (for female) </h2></td> </tr>

		 
		 
		<tr><td>Type  </td><td> <input class="uk-input congested-form" type="text" name="new_kanyashree_type" id="new_kanyashree_type"> </td><td>ID No.  </td><td>  <input class="uk-input congested-form" type="text" name="new_kanyashree_ID_NO" id="new_kanyashree_ID_NO"> </td>  </tr>      
		     
		       
   </table> 
   
    <table class="uk-table congested-table uk-table-justify">
 <tr><td colspan="5"> <h2> BOARD EXAM INFORMATION  </h2></td> </tr>

		 
		<tr><td colspan="5" style="font-weight:bold;">10th Std. </td> </tr>
		<tr><td>Name of Board </td><td>  
		<select class="uk-select congested-form" name="new_ten_name_of_board" id="new_ten_name_of_board"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->boardname_list,'');?>
                    </select>
		
		 </td><td>Year of Passing</td><td> <input class="uk-input congested-form" type="text" name="new_ten_passed_year" id="new_ten_passed_year"> </td>  </tr>     
		<tr><td>Roll </td><td> <input class="uk-input congested-form" type="text" name="new_ten_roll" id="new_ten_roll"> </td><td>No</td><td> <input class="uk-input congested-form" type="text" name="new_ten_no" id="new_ten_no"> </td>  </tr>     
		<tr><td colspan="5">Mark Obtained </td> </tr>  
		<tr><td>Beng/Hindi </td><td> <input class="uk-input congested-form" type="text" name="new_ten_marks_beng_hindi" id="new_ten_marks_beng_hindi"> </td><td>English</td><td> <input class="uk-input congested-form" type="text" name="new_ten_marks_eng" id="new_ten_marks_eng">  </td>  </tr>       
		<tr><td>Mathematics </td><td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_math" id="new_ten_marks_math"> </td><td>Physical Science</td><td> <input class="uk-input congested-form" type="text" name="new_ten_marks_physc" id="new_ten_marks_physc"> </td>  </tr>       
		<tr><td>Life Science </td><td> <input class="uk-input congested-form" type="text" name="new_ten_marks_lifesc" id="new_ten_marks_lifesc"> </td><td>History</td><td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_history" id="new_ten_marks_history"> </td>  </tr>       
		<tr><td>Geography </td><td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_geography" id="new_ten_marks_geography"> </td><td>Social Science</td><td> <input class="uk-input congested-form" type="text" name="new_ten_marks_socialsc" id="new_ten_marks_socialsc"> </td>  </tr>       
		<tr><td>Total Marks obt. </td><td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_total_obt" id="new_ten_marks_total_obt"> </td><td>out of</td><td> <input class="uk-input congested-form" type="text" name="new_ten_marks_out_of" id="new_ten_marks_out_of"> </td>  </tr>  
		<tr><td>Percentage </td><td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_percent" id="new_ten_marks_percent"> </td><td> -</td><td> - </td>  </tr>            
    
		 
		<tr><td colspan="5" style="font-weight:bold;">12th Std </td> </tr>
		<tr><td>Name of Board </td><td>  
		
		<select class="uk-select congested-form" name="new_twelve_name_of_board" id="new_twelve_name_of_board"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->boardname_list,'');?>
                    </select>
		
		 </td><td>Year of Passing</td><td>  <input class="uk-input congested-form" type="text" name="new_twelve_passed_year" id="new_twelve_passed_year"> </td>  </tr>     
		<tr><td>Roll </td><td> <input class="uk-input congested-form" type="text" name="new_twelve_roll" id="new_twelve_roll"> </td><td>No</td><td>  <input class="uk-input congested-form" type="text" name="new_twelve_no" id="new_twelve_no">  </td>  </tr>       
		<tr><td>Stream </td><td> 
		<select class="uk-select congested-form" name="new_twelve_stream" id="new_twelve_stream"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->twelve_stream_list,'');?>
                    </select>
		
		
		</td><td>-</td><td> - </td>  </tr>  
		
		 <tr><td colspan="5">Mark Obtained (For Sc. But other than sc Subjects should be blank for self written)  </td> </tr>    
		<tr><td>Beng/Hindi </td><td>  <input class="uk-input congested-form" type="text" name="new_twelve_marks_beng_hindi" id="new_twelve_marks_beng_hindi"> </td><td>English</td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_eng" id="new_twelve_marks_eng">  </td>  </tr>       
		<tr><td>Mathematics </td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_math" id="new_twelve_marks_math">  </td><td>Physics</td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_physc" id="new_twelve_marks_physc"> </td>  </tr>       
		<tr><td>Chemistry </td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_chemistry" id="new_twelve_marks_chemistry"> </td><td>Biology</td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_biology" id="new_twelve_marks_biology"> </td>  </tr>       
		<tr><td>Total Marks obt. </td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_total_obt" id="new_twelve_marks_total_obt"> </td><td>out of</td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_out_of" id="new_twelve_marks_out_of"> </td>  </tr>            
   <tr><td>Percentage </td><td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_percent" id="new_twelve_marks_percent">  </td><td>-</td><td> - </td>  </tr> 
   
      
  	 
   
   
   <tr><td colspan="5" style="font-weight:bold;">Graduate level (For Completive Exam) </td> </tr>
   
   <tr><td>Passed </td><td>  
   <select class="uk-select congested-form" name="new_graduate_passed" id="new_graduate_passed"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->graduate_passed_list,'');?>
                    </select>
   
  
   
    </td><td>If Passed with Hons. Subject</td><td> <input class="uk-input congested-form" type="text" name="new_graduate_passed_subject" id="new_graduate_passed_subject">  </td>  </tr>  
   <tr><td>Year of Passing </td><td>  <input class="uk-input congested-form" type="text" name="new_graduate_passed_year" id="new_graduate_passed_year"> </td><td>University</td><td>  <input class="uk-input congested-form" type="text" name="new_graduate_passed_university" id="new_graduate_passed_university"> </td>  </tr>  
   <tr><td>Subjects Taken </td><td> <input class="uk-input congested-form" type="text" name="new_graduate_subjects" id="new_graduate_subjects"> </td><td>-</td><td> - </td>  </tr>  
   <tr><td>Marks obt. In final year </td><td>  <input class="uk-input congested-form" type="text" name="new_graduate_subjects_marks" id="new_graduate_subjects_marks"> </td><td>-</td><td> - </td>  </tr>  
   <tr><td>Total </td><td> <input class="uk-input congested-form" type="text" name="new_graduate_total_obt" id="new_graduate_total_obt">  </td><td>Out of</td><td>  <input class="uk-input congested-form" type="text" name="new_graduate_out_of" id="new_graduate_out_of"> </td>  </tr>  
   <tr><td>Percentage </td><td> <input class="uk-input congested-form" type="text" name="new_graduate_percent" id="new_graduate_percent"> </td><td>-</td><td> - </td>  </tr>  
   
   </table> 
   
      
	 
<? 
if(0)
{
 
 $query="SHOW COLUMNS FROM student_meta";
$rsResults=$os->mq($query);
$iii=0;
while($record=$os->mfa( $rsResults))
{
  
	  
}
}
 

?>	 