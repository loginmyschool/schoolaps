<?php
global $os,$pageVar,$site;
$ajaxFilePath= $site['url'].'wtosApps/'.'admission-ajax.php';
$loadingImage=$site['url-wtos'].'images/loading_new.gif';
$admissionTypeval=trim($pageVar['segment'][1])=='NewAdmission'?'Admission':'Readmission';
$dlist=array();
$slist=array();

$dataQuery=" select distinct(district) district_name from post_code where state='WEST Bengal' order by district asc";
$rsResults=$os->mq($dataQuery);
while($record=$os->mfa( $rsResults)){
    $dlist[$record['district_name']]=$record['district_name'];
}
$dataQuery2=" select distinct(state) state_name from post_code where post_code_id>0 order by state asc";
$rsResults2=$os->mq($dataQuery2);
while($record2=$os->mfa( $rsResults2)){
    $slist[$record2['state_name']]=$record2['state_name'];
}

?>
 
    
 
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="<? echo $site['url-library']?>wtos-1.1.js"></script>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="<?= $site["themePath"]?>css/uikit.css" />
    <link rel="stylesheet" href="<?= $site["themePath"]?>css/common.css" />
    <!-- UIkit JS -->
    <script src="<?= $site["themePath"]?>js/uikit.min.js"></script>
    <script src="<?= $site["themePath"]?>js/uikit-icons.min.js"></script>
    <style>
        *{
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif;
			font-size:13px; color:#2E2E2E;
        }
        html, body{
            height: 100%;
            width: 100%;
            /*background-color: var(--color-secondary);*/
            background-size: cover;
            background-position: center;
        }
    </style>
 
<div class="form_block clearfix">
    <form enctype="multipart/form-data"   onsubmit="event.preventDefault(); WT_formfillupEditAndSave(this);" id="form_fillup_form">
        <div class="uk-card-body">
            <div class="uk-child-width-1-5@m" uk-grid>
                <div>
                   
                    <div class="uk-margin-small">
                        Name  
                        <input value="" type="text" name="name" id="name" class="uk-input form-field "/>
                    </div>
					<div class="uk-margin-small">
                        Mobile No
                        <input value="" type="text" name="mobile_student" id="mobile_student" class="uk-input form-field "/>
                    </div>
					 <div class="uk-margin-small">
                        Father's Name
                        <input value="" type="text" name="father_name" id="father_name" class="uk-input form-field "/>
                    </div>
					
					  <div class="uk-margin-small">
                        Father's Occupation
                        <input value="" type="text" name="father_ocu" id="father_ocu" class="uk-input form-field "/>
                    </div>
					
					<div class="uk-margin-small">
                        Father's Qualification  
                        <input value="" type="text" name="father_qualification" id="father_qualification" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Father's Mobile No
                        <input value="" type="text" name="father_mobile" id="father_mobile" class="uk-input form-field "/>
                    </div>
					
					 <div class="uk-margin-small">
                        Mother's Name
                        <input value="" type="text" name="mother_name" id="mother_name" class="uk-input form-field "/>
                    </div>
					<div class="uk-margin-small">
                        Mother's occupation
                        <input value="" type="text" name="mother_occupation" id="mother_occupation" class="uk-input form-field "/>
                    </div>
					<div class="uk-margin-small">
                        Mother's Qualification 
                        <input value="" type="text" name="mother_qualification" id="mother_qualification" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Mother's mobile
                        <input value="" type="text" name="mother_mobile" id="mother_mobile" class="uk-input form-field "/>
                    </div>
					
					<div class="uk-margin-small">
                        <input type="checkbox" id="father_not_guardian" onclick='$(this).prop("checked")?($(".guardian_class").show()):($(".guardian_class").hide())'>
                        <label for="vehicle3">Father is not guardian</label>
                    </div>
                    <div class="uk-margin-small guardian_class">
                        Guardian’s name
                        <input value="" type="text" name="guardian_name" id="guardian_name" class="uk-input form-field "/>
                    </div>
					
					 <div class="uk-margin-small guardian_class">
                        Relationship
                        <input value="" type="text" name="relationship" id="relationship" class="uk-input form-field "/>
                    </div>
					
                    <div class="uk-margin-small guardian_class">
                        Guardian’s  mobile
                        <input value="" type="text" name="guardian_mobile" id="guardian_mobile" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small guardian_class">
                        Guardian’s  occupation
                        <input value="" type="text" name="guardian_occupation" id="guardian_occupation" class="uk-input form-field "/>
                    </div>
					
					
				 </div>
					 
					 <div>
					
                     <div class="uk-margin-small">
                        Admission sought for class
                        <select name="class_id" id="class_id" class="uk-select form-field" onChange="show_ten_twelve_div();">
                            <option value=""></option>
                            <?
                            $os->onlyOption($os->classList);    ?>
                        </select>
                    </div>
                    <div class="uk-margin-small">
                        Academic year
                        <select name="academic_year" id="academic_year" class="uk-select form-field" >
                            <option value=""></option>
                            <?
							 $date=date('Y');
                            $os->onlyOption($os->feesYear,date('Y')+1); ?>
                        </select>
                    </div>
					
					
                    <div class="uk-margin-small">
                        Date of Birth
                        <input value="" type="date" name="dob" id="dob" class="wtDateClass uk-input form-field"/>
                    </div>
					
					  <div class="uk-margin-small">
                        Aadhaar number
                        <input value="" type="text" name="aadhaar_number" id="aadhaar_number" class="uk-input form-field "/>
                    </div>
					
					 <div class="uk-margin-small">
                        Place Of Birth  
                        <input value="" type="text" name="place_of_birth" id="place_of_birth" class="uk-input form-field "/>
                    </div>
					
					 <div class="uk-margin-small">
                        Blood group
                        <select name="blood_group" id="blood_group" class="uk-select form-field" >
                            <option value=""></option>
                            <?
                            $os->onlyOption($os->blood_group);  ?>
                        </select>
                    </div>
					
					<div class="uk-margin-small">
                        Gender:
                        <select name="gender" id="gender" class="uk-select form-field" >
                            <option value=""></option>
                            <? $os->onlyOption($os->gender);?>
                        </select>
                    </div>
					
					 <div class="uk-margin-small">
                       Religion  
                        <input value="" type="text" name="religion" id="religion" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Caste:
                        <select name="caste" id="caste" class="uk-select form-field" >
                            <option value=""></option>
                            <? $os->onlyOption($os->caste);?>
                        </select>
                    </div>
					
					<div class="uk-margin-small">
                        Physically Challenged:
                        <select name="physically_challanged" id="physically_challanged" class="uk-select form-field" >
                            <option value=""></option>
                            <? $os->onlyOption(array('Yes'=>'Yes','No'=>'No'));?>
                        </select>
                    </div>
					 </div>
					 
					 <div>
					 
					 <div class="uk-margin-small">
                        <span style="font-size:16px; font-style:italic; color:#000099;"> Present Address </span>
                        
                    </div>
					 <div class="uk-margin-small">
                        Village
                        <input value="" type="text" name="vill" id="vill" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Post Office
                        <input value="" type="text" name="po" id="po" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Police Station
                        <input value="" type="text" name="ps" id="ps" class="uk-input form-field "/>
                    </div>

                    <div class="uk-margin-small">
                        Block
                        <input value="" type="text" name="block" id="block" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Pincode
                        <input value="" type="text" name="pin" id="pin" class="uk-input form-field " onBlur="get_district_by_state_by_pin('pin','dist','state')"/>
                    </div>
                    <div class="uk-margin-small">
                        District
                        <select  name="dist" id="dist" placeholder="" class="uk-select select2" >
                            <option value=""></option>
                            <? $os->onlyOption($dlist); ?>
                        </select>
                    </div>
                    <div class="uk-margin-small">
                        State
                        <select  name="state" id="state" placeholder="" class="uk-select select2" >
                            <option value=""></option>
                            <? $os->onlyOption($slist); ?>
                        </select>

                    </div>
					
					 <div class="uk-margin-small">
                       <span style="font-size:16px; font-style:italic; color:#000099;"> Permanent Address </span>
                        
                    </div>
                    
                     <div class="uk-margin-small">  
                        <input type="checkbox" name="same_as_present_address" value="1" checked="checked"  id="pres_add_same_per_chk" onclick='pres_add_same_per()'>
                        <label for="vehicle3">Same as present address</label>
                    </div>
                    
                    
                    
					
					
					
                    <div class="uk-margin-small permanent_address_group">
                         Village
                        <input value="" type="text" name="permanent_village" id="permanent_village" class="uk-input form-field "/>
                    </div>

                    <div class="uk-margin-small permanent_address_group">
                         Post office
                        <input value="" type="text" name="permanent_post_office" id="permanent_post_office" class="uk-input form-field "/>
                    </div>
					<div class="uk-margin-small permanent_address_group">
                         Block
                        <input value="" type="text" name="permanent_block" id="permanent_block" class="uk-input form-field "/>
                    </div>
					 <div class="uk-margin-small permanent_address_group">
                         Police station
                        <input value="" type="text" name="permanent_police_station" id="permanent_police_station" class="uk-input form-field "/>
                    </div>
					
					<div class="uk-margin-small permanent_address_group">
                         Pincode
                        <input value="" type="text" name="permanent_pincode" id="permanent_pincode" class="uk-input form-field " onBlur="get_district_by_state_by_pin('permanent_pincode','permanent_district','permanent_state')"/>
                    </div>
					
					<div class="uk-margin-small permanent_address_group">
                         District
                        <select  name="permanent_district" id="permanent_district" placeholder="" class="uk-select select2">
                            <option value=""></option>
                            <? $os->onlyOption($dlist); ?>
                        </select>
                    </div>
                    <div class="uk-margin-small permanent_address_group">
                         State
                        <select  name="permanent_state" id="permanent_state" placeholder="" class="uk-select select2" >
                            <option value=""></option>
                            <? $os->onlyOption($slist); ?>
                        </select>
                    </div>
					
                </div>
				
				
				    <div class="uk-margin-small">
                        Profile picture:<img id="profile_picturePreview" src="<?= $site["themePath"]?>images/profile.png" height="100" onClick="os.clicks('profile_picture');"    />
                        <input type="file" name="profile_picture" value=""  id="profile_picture" onChange="os.readURL(this,'profile_picturePreview') " style="display:none;"/><br>
                        <span style="cursor:pointer; color:#FF0000;" onClick="os.clicks('profile_picture');">Upload Image</span>
                    </div>
               
                   
				  <div uk-grid  style="display:none;"> <!-- ----------------------------display none------------------------------  --> 
			    <div>
					
					
					<div class="uk-margin-small">
                        Nationality
                        <input value="" type="text" name="nationality" id="nationality" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Age
                        <input value="" type="text" name="age" id="age" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Orphan
                        <input value="" type="text" name="orphan" id="orphan" class="uk-input form-field "/>
                    </div>
                  
                    <div class="uk-margin-small">
                        Aadhaar image
                        <img id="aadhaar_imagePreview" src="" height="100" style="display:none;"     />
                        <input type="file" name="aadhaar_image" value=""  id="aadhaar_image" onChange="os.readURL(this,'aadhaar_imagePreview') " style="display:none;"/><br>
                        <span style="cursor:pointer; color:#FF0000;" onClick="os.clicks('aadhaar_image');">Edit Aadhar Image</span>
                    </div>
                     
                    <div class="uk-margin-small">
                        Identification mark
                        <input value="" type="text" name="identification_mark" id="identification_mark" class="uk-input form-field "/>
                    </div>
                   
                    <div class="uk-margin-small uk-hidden">
                        Rights on child
                        <input value="" type="text" name="rights_on_child" id="rights_on_child" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        First language
                        <input value="" type="text" name="first_language" id="first_language" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        What wants to be
                        <input value="" type="text" name="what_wants_to_be" id="what_wants_to_be" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Hobbies
                        <input value="" type="text" name="hobbies_of_child" id="hobbies_of_child" class="uk-input form-field "/>
                    </div>
                </div>
                <div>
				
				
                    <div class="uk-margin-small uk-hidden">
                        Admission date
                        <input value="" type="date" name="admission_date" id="admission_date" class="wtDateClass uk-input form-field"/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Admission category
                        <input value="" type="text" name="admission_category" id="admission_category" class="uk-input form-field "/>
                    </div>
                    
                    <div class="uk-margin-small  uk-hidden">
                        Need a hostel
                        <select name="need_a_hostel" id="need_a_hostel" class="uk-select form-field" >
                            <option value=""></option>
                            <?
                            $os->onlyOption($os->noYes);    ?>
                        </select>
                    </div>
                    <div class="uk-margin-small">
                        Student type
                        <select name="student_type" id="student_type" class="uk-select form-field" >
                            <option value=""></option>
                            <?
                            $os->onlyOption($os->student_type);    ?>
                        </select>
                    </div>
                    
                    <div class="uk-margin-small">
                        Previous class
                        <select name="last_class" id="last_class" class="uk-select form-field" >
                            <option value=""></option>
                            <option value="4">IV</option>

                            <?
                            $os->onlyOption($os->classList); ?>
                        </select>
                    </div>
                    <div class="uk-margin-small">
                        Previous school
                        <input value="" type="text" name="last_school" id="last_school" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Previous class total marks
                        <input value="" type="text" name="last_class_total_marks" id="last_class_total_marks" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Previous class obtain marks
                        <input value="" type="text" name="last_class_obtain_marks" id="last_class_obtain_marks" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Previous class grade
                        <input value="" type="text" name="last_class_grade" id="last_class_grade" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small  uk-hidden">
                        Previous school address
                        <input value="" type="text" name="last_school_address" id="last_school_address" class="uk-input form-field "/>
                    </div>
                    
                    <div class="uk-margin-small">
                        WhatsApp No
                        <input value="" type="text" name="whats_app_no" id="whats_app_no" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small">
                        Email ID
                        <input value="" type="text" name="email_id" id="email_id" class="uk-input form-field "/>
                    </div>
                </div>
                <div>
                   
                  
                    <div class="uk-margin-small  uk-hidden">
                        Father's Aisj Member
                        <select name="father_aisj_member" id="father_aisj_member" class="uk-select form-field" >
                            <option value=""></option>
                            <?
                            $os->onlyOption($os->noYes);    ?>
                        </select>
                    </div>
                    <div class="uk-margin-small  uk-hidden">
                        Father id no
                        <input value="" type="text" name="father_id_no" id="father_id_no" class="uk-input form-field "/>
                    </div>
                   
                    <div class="uk-margin-small  uk-hidden">
                        Mother's aisj member
                        <select name="mother_aisj_member" id="mother_aisj_member" class="uk-select form-field" >
                            <option value=""></option>
                            <?
                            $os->onlyOption($os->noYes);    ?>
                        </select>
                    </div>
                    <div class="uk-margin-small  uk-hidden">
                        Mother's id no
                        <input value="" type="text" name="mother_id_no" id="mother_id_no" class="uk-input form-field "/>
                    </div>
                    
                   
                </div>
                <div>
                    <div class="uk-margin-small guardian_class uk-hidden">
                        Guardian’s  aisj member
                        <select name="guardian_aisj_member" id="guardian_aisj_member" class="uk-select form-field" >
                            <option value=""></option>
                            <?
                            $os->onlyOption($os->noYes);    ?>
                        </select>
                    </div>
                    <div class="uk-margin-small guardian_class uk-hidden">
                        Guardian’s id no
                        <input value="" type="text" name="guardian_id_no" id="guardian_id_no" class="uk-input form-field "/>
                    </div>
                   
                   
                    <div class="uk-margin-small uk-hidden">
                        Permanent nationality
                        <input value="" type="text" name="permanent_nationality" id="permanent_nationality" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Annual family income
                        <input value="" type="text" name="annual_family_income" id="annual_family_income" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Bank account number
                        <input value="" type="text" name="bank_account_number" id="bank_account_number" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Ifsc code
                        <input value="" type="text" name="ifsc_code" id="ifsc_code" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Bank name
                        <input value="" type="text" name="bank_name" id="bank_name" class="uk-input form-field "/>
                    </div>
                    <div class="uk-margin-small uk-hidden">
                        Bank branch
                        <input value="" type="text" name="bank_branch" id="bank_branch" class="uk-input form-field "/>
                    </div>
                </div>
				
				</div>
            </div>
        </div>
       
	   
	   
	   
	    <div uk-grid  style="display:none;"> <!-- ----------------------------------------------------------  -->
            <div class="ten_standard">
                <table>
                    <tr>
                        <td colspan="5" style="font-weight:bold;">10th Std. </td>
                    </tr>
                    <tr>
                        <td>Name of Board </td>
                        <td>
                            <select class="uk-select congested-form" name="new_ten_name_of_board" id="new_ten_name_of_board"   >
                                <option value="" > </option>
                                <?  $os->onlyOption($os->boardname_list,'');?>
                            </select>
                        </td>
                        <td>Year of Passing</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_passed_year" id="new_ten_passed_year"> </td>
                    </tr>
                    <tr>
                        <td>Roll </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_roll" id="new_ten_roll"> </td>
                        <td>No</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_no" id="new_ten_no"> </td>
                    </tr>
                    <tr>
                        <td colspan="5">Mark Obtained </td>
                    </tr>
                    <tr>
                        <td>Beng/Hindi </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_marks_beng_hindi" id="new_ten_marks_beng_hindi"> </td>
                        <td>English</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_marks_eng" id="new_ten_marks_eng">  </td>
                    </tr>
                    <tr>
                        <td>Mathematics </td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_math" id="new_ten_marks_math"> </td>
                        <td>Physical Science</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_marks_physc" id="new_ten_marks_physc"> </td>
                    </tr>
                    <tr>
                        <td>Life Science </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_marks_lifesc" id="new_ten_marks_lifesc"> </td>
                        <td>History</td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_history" id="new_ten_marks_history"> </td>
                    </tr>
                    <tr>
                        <td>Geography </td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_geography" id="new_ten_marks_geography"> </td>
                        <td>Social Science</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_marks_socialsc" id="new_ten_marks_socialsc"> </td>
                    </tr>
                    <tr>
                        <td>Total Marks obt. </td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_total_obt" id="new_ten_marks_total_obt"> </td>
                        <td>out of</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_ten_marks_out_of" id="new_ten_marks_out_of"> </td>
                    </tr>
                    <tr>
                        <td>Percentage </td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_ten_marks_percent" id="new_ten_marks_percent"> </td>
                        <td> -</td>
                        <td> - </td>
                    </tr>
                </table>
            </div>
            <div class="twelve_standard">
                <table>
                    <tr>
                        <td colspan="5" style="font-weight:bold;">12th Std </td>
                    </tr>
                    <tr>
                        <td>Name of Board </td>
                        <td>
                            <select class="uk-select congested-form" name="new_twelve_name_of_board" id="new_twelve_name_of_board"   >
                                <option value="" > </option>
                                <?  $os->onlyOption($os->boardname_list,'');?>
                            </select>
                        </td>
                        <td>Year of Passing</td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_twelve_passed_year" id="new_twelve_passed_year"> </td>
                    </tr>
                    <tr>
                        <td>Roll </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_roll" id="new_twelve_roll"> </td>
                        <td>No</td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_twelve_no" id="new_twelve_no">  </td>
                    </tr>
                    <tr>
                        <td>Stream </td>
                        <td>
                            <select class="uk-select congested-form" name="new_twelve_stream" id="new_twelve_stream"   >
                                <option value="" > </option>
                                <?  $os->onlyOption($os->twelve_stream_list,'');?>
                            </select>
                        </td>
                        <td>-</td>
                        <td> - </td>
                    </tr>
                    <tr>
                        <td colspan="5">Mark Obtained (For Sc. But other than sc Subjects should be blank for self written)  </td>
                    </tr>
                    <tr>
                        <td>Beng/Hindi </td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_twelve_marks_beng_hindi" id="new_twelve_marks_beng_hindi"> </td>
                        <td>English</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_eng" id="new_twelve_marks_eng">  </td>
                    </tr>
                    <tr>
                        <td>Mathematics </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_math" id="new_twelve_marks_math">  </td>
                        <td>Physics</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_physc" id="new_twelve_marks_physc"> </td>
                    </tr>
                    <tr>
                        <td>Chemistry </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_chemistry" id="new_twelve_marks_chemistry"> </td>
                        <td>Biology</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_biology" id="new_twelve_marks_biology"> </td>
                    </tr>
                    <tr>
                        <td>Total Marks obt. </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_total_obt" id="new_twelve_marks_total_obt"> </td>
                        <td>out of</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_out_of" id="new_twelve_marks_out_of"> </td>
                    </tr>
                    <tr>
                        <td>Percentage </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_twelve_marks_percent" id="new_twelve_marks_percent">  </td>
                        <td>-</td>
                        <td> - </td>
                    </tr>
                </table>
            </div>
            <div>
                <table  class="uk-hidden">
                    <tr>
                        <td colspan="5" style="font-weight:bold;">Graduate level (For Completive Exam) </td>
                    </tr>
                    <tr>
                        <td>Passed </td>
                        <td>
                            <select class="uk-select congested-form" name="new_graduate_passed" id="new_graduate_passed"   >
                                <option value="" > </option>
                                <?  $os->onlyOption($os->graduate_passed_list,'');?>
                            </select>
                        </td>
                        <td>If Passed with Hons. Subject</td>
                        <td> <input class="uk-input congested-form" type="text" name="new_graduate_passed_subject" id="new_graduate_passed_subject">  </td>
                    </tr>
                    <tr>
                        <td>Year of Passing </td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_graduate_passed_year" id="new_graduate_passed_year"> </td>
                        <td>University</td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_graduate_passed_university" id="new_graduate_passed_university"> </td>
                    </tr>
                    <tr>
                        <td>Subjects Taken </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_graduate_subjects" id="new_graduate_subjects"> </td>
                        <td>-</td>
                        <td> - </td>
                    </tr>
                    <tr>
                        <td>Marks obt. In final year </td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_graduate_subjects_marks" id="new_graduate_subjects_marks"> </td>
                        <td>-</td>
                        <td> - </td>
                    </tr>
                    <tr>
                        <td>Total </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_graduate_total_obt" id="new_graduate_total_obt">  </td>
                        <td>Out of</td>
                        <td>  <input class="uk-input congested-form" type="text" name="new_graduate_out_of" id="new_graduate_out_of"> </td>
                    </tr>
                    <tr>
                        <td>Percentage </td>
                        <td> <input class="uk-input congested-form" type="text" name="new_graduate_percent" id="new_graduate_percent"> </td>
                        <td>-</td>
                        <td> - </td>
                    </tr>
                </table>
            </div>
            <div>
                <table>

                    <tr><td colspan="5" style="font-weight:bold;">Upload Documents</td></tr>
                    <tr>
                        <td class="uk-table-shrink">
                            <input type="file" name="file_doc_img" id="file_doc_img"
                                   onchange="$('#file_doc').html(this.value!==``?this.value.replace('C:\\fakepath\\', ''):'Select Document')" style="display:none;"/>
                            <button onClick="$('#file_doc_img').trigger('click')"
                                    style="width: 130px; overflow-x: hidden"
                                    class="uk-button uk-button-small  uk-button-default uk-text-nowrap" id="file_doc" type="button">Select Document</button>
                        </td>
                        <td>
                            <input value="" type="text" name="doc_title" id="doc_title" class="uk-input congested-form" placeholder="Document title"/>
                        </td>
                        <td class="uk-table-shrink " style="padding-left: 10px">
                            <button onClick="if($('#file_doc_img').val()===''){alert('please select file');return false;};
                        if($('#doc_title').val()===''){alert('please put documnt title');return false;};
                        if(confirm('Are you sure?')){upload_doc();} " class="uk-button uk-button-small  uk-button-primary uk-text-nowrap" type="button">Upload</button>
                        </td>
                        <td>
                            <table class="uk-table-justify  uk-margin-small-bottom uk-margin-small-top uk-width-1-1 uk-table-divider" style="border-collapse: collapse">
                                <tbody id="uploaded_doc_div">
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
		
		 <div class="uk-margin-small uk-hidden">
                        <input id="formfillup_id" class="uk-input" value="0"/>
                        <input id="print_formfillup_id" class="uk-input" value="0"/>

                        <select name="branch_id" id="branch_id" class="uk-select form-field" >
                            <option value=""></option>
                            <?  $os->optionsHTML('1','branch_id','branch_name','branch');?>
                        </select>
                    </div>
		
        <input type="submit" value="Save" class="uk-button uk-button-primary uk-width-expand" id="form_save" style="cursor: pointer;" />
        <button type="button" class="uk-button uk-button-danger uk-width-expand" id="open_print_btn" onClick="open_print()">Print Preview</button>
        <button type="button" class="uk-button uk-button-danger uk-width-expand" id="final_submit_btn" onClick="final_submit()">Final Submit</button>
    </form>
</div>
<script type="text/javascript">
    $(".guardian_class").hide();
    $("#open_print_btn").hide();
    $("#final_submit_btn").hide();
    $("#download_pdf").hide();
    $('.ten_standard').hide();
    $('.twelve_standard').hide();
	$('.permanent_address_group').hide();
    function show_ten_twelve_div(){
        let class_id=$('#class_id').val();
        if(class_id>12){
            $('.twelve_standard').show();
        }
        if(class_id>10){
            $('.ten_standard').show();
        }
        if(class_id<11){
            $('.ten_standard').hide();
            $('.twelve_standard').hide();
        }
    }
    function pres_add_same_per(){
	   $('.permanent_address_group').hide();
	  
        if($("#pres_add_same_per_chk").prop('checked') == false)
		{
		        $('.permanent_address_group').show();
				/*$('#permanent_pincode').val();
				$('#permanent_state').val();
				$('#permanent_district').val();
				$('#permanent_block').val();
				$('#permanent_police_station').val();
				$('#permanent_village').val();
				$('#permanent_post_office').val();*/
        }
        /*$('#permanent_pincode').val($('#pin').val());
        $('#permanent_state').val($('#state').val());
        $('#permanent_district').val($('#dist').val());
        $('#permanent_block').val($('#block').val());
        $('#permanent_police_station').val($('#ps').val());
        $('#permanent_village').val($('#vill').val());
        $('#permanent_post_office').val($('#po').val());*/

    }
    function final_submit(){
        var p =confirm('Are you Sure? After final submission you wont be able to update your data.')
        if(!p){return false;}
        var formfillup_id=os.getVal('formfillup_id');
        $('input').val('') ;
        $('select').val('') ;
        $('#aadhaar_imagePreview').attr('src','');
        $('#profile_picturePreview').attr('src','');
        $('#form_save').val('Save');
        $("#open_print_btn").html('Print');
        os.setVal('print_formfillup_id', formfillup_id);
        os.setVal('formfillup_id',0);
        os.setVal('branch_id',1);
        $("#download_pdf").show();
        $("#final_submit_btn").hide();
        img_reload_list();
        var url='admission-print?formfillup_id='+formfillup_id;
        window.location = url
    }
    function get_district_by_state_by_pin(pin_id,district_id,state_id){
        var formdata = new FormData();
        var present_pinVal= os.getVal(pin_id);
        formdata.append('pin',present_pinVal );
        formdata.append('pin_id',pin_id );
        formdata.append('district_id',district_id );
        formdata.append('state_id',state_id );
        formdata.append('get_district_by_state_by_pin','OK' );
        var url='<? echo $ajaxFilePath ?>?get_district_by_state_by_pin=OK&';
        // os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage">  <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('get_district_by_state_by_pin_result',url,formdata);

    }

    function get_district_by_state_by_pin_result(data){
        var d=data.split('##');
        var district_val =d[0];
        var district_id =d[1];
        var state_val =d[2];
        var state_id =d[3];
        os.setVal(district_id,district_val);
        try {
            $("#"+district_id).val(district_val).trigger('change');
            $("#"+state_id).val(state_val).trigger('change');

        } catch (e){
            console.log(e);
        }

    }

    function upload_doc(){
        var formdata = new FormData();
        var imageVal= os.getObj('file_doc_img').files[0];
        if(!imageVal){
            return false;
        }
        if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
        formdata.append('doc_title',os.getVal('doc_title'));
        formdata.append('upload_doc','OKS');
        var url='<? echo $ajaxFilePath ?>?upload_doc=OK&';
        // os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('img_reload_list',url,formdata);
    }
    function img_reload_list(data=''){
        if(data==''){
            $("#uploaded_doc_div").html('');
        }
        else{
            $("#uploaded_doc_div").append(data);
        }

        $('#imagePreview').attr('src','');
        $('#file_doc_img').val('');
        $('#imagePreview').attr('style','display:none');
        $('#doc_title').val('')
        $('#file_doc').html('Select Document');

    }
    function open_print(){
        let formfillup_id=os.getVal('print_formfillup_id');
        let print_html=$('#open_print_btn').html()?'preview':'';
        if(formfillup_id<1){
            alert('Please add data.');
            return false;
        }
        popUpWindow('admission-print?formfillup_id='+formfillup_id+'&print_type='+print_html, 50, 50, 750, 620);
    }
    function WT_formfillupEditAndSave(form){
        var formdata = new FormData(form);
        if(os.check.empty('name','Please Add Name.')==false){ return false;}
        if(os.check.empty('academic_year','Please Add Academic Year.')==false){ return false;}
        if(os.check.empty('class_id','Please Add Class.')==false){ return false;}
        var mobile_student= formdata.get('mobile_student').trim();
        if (mobile_student.length<10||mobile_student.length>10){
            alert("please enter correct mobile number");
            return;
        }
        if(os.check.empty('dob','Please Add DOB.')==false){ return false;}
        var p =confirm('Are you Sure? Please Check Again.')
        if(p){
            var   formfillup_id=os.getVal('formfillup_id');
            formdata.append('formfillup_id',formfillup_id );
            var url='<? echo $ajaxFilePath ?>?WT_formfillupEditAndSave=OK&';
            // os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('reLoadList',url,formdata);
        }
    }

    function reLoadList(data){
        var d=data.split('#-#');
        var formfillup_id=parseInt(d[0]);
        if(d[0]!='Error' && formfillup_id>0){
            os.setVal('formfillup_id',formfillup_id);
            os.setVal('print_formfillup_id',formfillup_id);
            $("#open_print_btn").show();
            $("#final_submit_btn").show();
        }
        if(d[1]!=''){alert(d[1]);}
    }
</script>
<style>
.form-field{ border:1px solid #CCCCCC; border-radius:5px; padding:3px; height:30px; color:#000000; font-weight:bold; font-size:15px; letter-spacing:1px;}
</style>
 