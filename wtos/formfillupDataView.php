<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List formfillup';
$ajaxFilePath= 'formfillupAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
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
<script type="text/javascript">
	function view_history(formfillup_id){
		var formdata = new FormData();
		formdata.append('formfillup_id',formfillup_id);
		var url='<? echo $ajaxFilePath ?>?view_history=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxHtml('status_history_div',url,formdata);
		UIkit.modal('#view_history_modal').show();
	}
</script>
<!--View Form data modal-->

<div id="view_form_data_modal" class="uk-modal-container" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-default uk-text-danger" type="button" uk-close></button>
		<div class="uk-card uk-card-default uk-card-small">

			<div class="uk-card-header">
				<h5 class="uk-text-large uk-text-italic uk-text-emphasis" id="view_booking_heading">View Applicant Form</h5>
			</div>
			<div  id="view_form_record_div">
			</div>

		</div>
	</div>
</div>
<!--View history modal-->

<div id="view_history_modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-default uk-text-danger" type="button" uk-close></button>
		<div class="uk-card uk-card-default uk-card-small">

			<div class="uk-card-header">
				<h5>Form Status History</h5>
			</div>
			<div  id="status_history_div">
			</div>
		</div>
	</div>
</div>

<!--End view history modal-->

<div id="form_modal" class="uk-modal-container" uk-modal >
	<div class="uk-modal-dialog uk-width-auto">
		<button class="uk-modal-close-default uk-text-danger" type="button" uk-close></button>
		<div class="uk-card uk-card-default uk-card-small">	
			<div class="uk-card-header">
				<h4 id="subscription_title" class="uk-text-large uk-text-italic uk-text-emphasis uk-hidden">Applicant Form Entry</h4>
				<label style="font-size: 20px;margin-bottom: 5px; display: inline-block;font-weight: bold;">ID : <span id="b_id_span" style="font-size: 20px;color:green;font-weight: bold;"></span>
				</div> 

				<form   onsubmit="event.preventDefault(); WT_formfillupEditAndSave(this);" id="form_fillup_form">
					<div class="uk-card-body">
						<div class="uk-child-width-1-5@m" uk-grid>

							<div>
								<div class="uk-margin-small">								
									<input readonly class="uk-hidden"  id="formfillup_id" value="0" style="background-color:transparent;font-size: 20px;color:green; display: inline; width: 90px; border:none" /></label>
								</div>

								<div class="uk-margin-small uk-hidden">
									Branch:
									<select name="branch_id" id="branch_id" class="uk-select form-field" ><option value="">Select Branch</option>
										<?  $os->optionsHTML('1','branch_id','branch_name','branch');?>
									</select>
								</div>
								<div class="uk-margin-small">
									Form no: <span style="color:#FF0000">*</span>
									<input value="" type="text" name="form_no" id="form_no" class="uk-input form-field"/>
								</div>
								
								<div class="uk-margin-small">
									Name:<span style="color:#FF0000">*</span><input value="" type="text" name="name" id="name" class="uk-input form-field"/>
								</div>
								
								<div class="uk-margin-small">
									Date of Birth<span style="color:#FF0000">*</span>
									<input value="" type="date" name="dob" id="dob" class="wtDateClass uk-input form-field"/>
								</div>
								<div class="uk-margin-small">
									Admission sought for class:<span style="color:#FF0000">*</span><select name="class_id" id="class_id" class="uk-select form-field"><option value="">Select Class</option>	<? 
									$os->onlyOption($os->classList);	?></select>
								</div>
								
								
								
								

								<div class="uk-margin-small">Father name :<span style="color:#FF0000">*</span><input value="" type="text" name="father_name" id="father_name" class="uk-input form-field "/> </div>
								<div class="uk-margin-small">Father Mobile : <span style="color:#FF0000">*</span><input value="" type="text" name="father_mobile" id="father_mobile" class="uk-input form-field "/> </div>
								
								<div class="uk-card-footer  uk-text-center">
									<input type="submit" value="Save" class="uk-button-primary uk-width-expand" style="cursor: pointer;" />	                   
								</div>
								
								<div class="uk-margin-small">
									Application No:<input value="" type="text" name="application_no" id="application_no" class="uk-input form-field"/>
								</div>
								<div class="uk-margin-small">
									Application Date:<input value="" type="date" name="application_date" id="application_date" class="wtDateClass uk-input form-field"/>
								</div>
								
								<div class="uk-margin-small">
									Academic Year:
									<select name="academic_year" id="academic_year" class="uk-select form-field ">
										<option value="">Select Year</option>
										<? $os->onlyOption($os->asession,'2023');	?>
									</select>	
								</div>
								
								
							</div>


							<div>
							<div class="uk-margin-small">
									Exam Date:<input value="" type="date" name="exam_date" id="exam_date" class="wtDateClass uk-input form-field"/>
								</div>
								<div class="uk-margin-small">
									Exam Time:<input value="" type="text" name="exam_time" id="exam_time" class="uk-input form-field"/>
								</div>
								<div class="uk-margin-small" style="display:none;">
									Exam Center:<input value="" type="text" name="exam_center" id="exam_center" class="uk-input form-field"/>
								</div>
								<div class="uk-margin-small">
									Center code:<input value="" type="text" name="center_code" id="center_code" class="uk-input form-field"/>
								</div>
								
								<div class="uk-margin-small">Father ocuupation <input value="" type="text" name="father_ocu" id="father_ocu" class="uk-input form-field "/> </div>								
								<div class="uk-margin-small">Father qualification <input value="" type="text" name="father_qualification" id="father_qualification" class="uk-input form-field "/> </div> 
								<div class="uk-margin-small">Father monthly income <input value="" type="text" name="father_monthly_income" id="father_monthly_income" class="uk-input form-field "/> </div>
								

								<div class="uk-margin-small">Mother name :<input value="" type="text" name="mother_name" id="mother_name" class="uk-input form-field "/> </div>
								<div class="uk-margin-small">Mother ocuupation <input value="" type="text" name="mother_occupation" id="mother_occupation" class="uk-input form-field "/> </div>								
								<div class="uk-margin-small">Mother qualification <input value="" type="text" name="mother_qualification" id="mother_qualification" class="uk-input form-field "/> </div> 
								<div class="uk-margin-small">Mother monthly income <input value="" type="text" name="mother_monthly_income" id="mother_monthly_income" class="uk-input form-field "/> </div>
								<div class="uk-margin-small">Mother Contact <input value="" type="text" name="mother_mobile" id="mother_mobile" class="uk-input form-field "/> </div>								
								<div class="uk-margin-small"></div>
								<div class="uk-margin-small">
									Guardian’s name
									<input value="" type="text" name="guardian_name" id="guardian_name" class="uk-input form-field "/>
								</div>

								<div class="uk-margin-small">
									Relationship with student
									<input value="" type="text" name="relationship" id="relationship" class="uk-input form-field "/>
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

							</div>
							<div>
								<div class="uk-margin-small"></div>

								<div class="uk-margin-small">
									Physically Challenged:
									<select name="physically_challanged" id="physically_challanged" class="uk-select form-field" >
										<option value=""></option>
										<? $os->onlyOption(array('Yes'=>'Yes','No'=>'No'));?>
									</select>
								</div>

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
									<select  name="dist" id="dist" placeholder="" class="uk-select select2" style="width:200px;" >
										<option value=""></option>
										<? $os->onlyOption($dlist); ?>
									</select>
								</div>
								<div class="uk-margin-small">
									State
									<select  name="state" id="state" placeholder="" class="uk-select select2"  style="width:200px;"  >
										<option value=""></option>
										<? $os->onlyOption($slist); ?>
									</select>

								</div>

								
							</div>
							<div>
								<div class="uk-margin-small"></div>

								<div class="uk-margin-small">
									<span style="font-size:16px; font-style:italic; color:#000099;"> Permanent Address </span>
								</div>
								<div class="uk-margin-small uk-hidden">  
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
									<select  name="permanent_district" id="permanent_district" placeholder="" class="uk-select select2"  style="width:200px;" >
										<option value=""></option>
										<? $os->onlyOption($dlist); ?>
									</select>
								</div>
								<div class="uk-margin-small permanent_address_group">
									State
									<select  name="permanent_state" id="permanent_state" placeholder="" class="uk-select select2"  style="width:200px;" >
										<option value=""></option>
										<? $os->onlyOption($slist); ?>
									</select>
								</div>
							</div>
							<div>
								<div class="uk-margin-small"></div>
								
								<div class="uk-margin-small">
									Profile picture:<br><img id="profile_picturePreview" src="<?= $site["themePath"]?>images/profile.png" height="100"/>	
									<input type="file" name="profile_picture" value=""  id="profile_picture" onchange="os.readURL(this,'profile_picturePreview') " style="display:none;"/><br>
									<span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('profile_picture');">Edit Image</span>
								</div>
								
								<div class="uk-card-footer  uk-text-center">
									<input type="submit" value="Save" class="uk-button-primary uk-width-expand" style="cursor: pointer;" />	                   
								</div>

							</div>
						</div>
					</div>   
				</form> 


			</div>
		</div>
	</div>	



	<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

		<tr>
			<td valign="top" class="ajaxViewMainTableTDList">

				<div class="ajaxViewMainTableTDListSearch">

					<input type="text" id="searchKey" placeholder="Search Key" style="width: 250px;"/>   &nbsp;
					<input type="text" class="wtTextClass" name="name_s" id="name_s" value="" placeholder="Name" /> &nbsp;   
					<input type="hidden" class="wtTextClass" name="mobile_student_s" id="mobile_student_s" value="" placeholder="Mobile No" style="width: 100px;" /> &nbsp;
					<select name="form_status" id="form_status_s" class="textbox fWidth" ><option value="">Form status</option>	<? 
					$os->onlyOption($os->form_status);	?></select> &nbsp;
					<select name="form_for" id="form_for_s" class="textbox fWidth uk-hidden" >
						<option value="">Type</option><? 
						$os->onlyOption($os->admissionType);	?></select>	

						<input type="text" class="wtTextClass" name="form_no_s" id="form_no_s" value="" placeholder="Form No" style="width: 120px;"/> &nbsp;  

						<select name="year_s" id="year_s" class="uk-select form-field" style="width: 80px;">
							<option value="">Year</option>
							<? $os->onlyOption($os->asession);	?>
						</select>


						&nbsp; 
						<select name="class_id_s" id="class_id_s" class="textbox fWidth" ><option value="">Class</option><? $os->onlyOption($os->classList);	?></select>
						&nbsp;
						<select name="payment_status" id="payment_status_s" class="textbox fWidth uk-hidden" ><option value="">Select Payment status</option>	<? 
						$os->onlyOption($os->paymentStatus);	?></select>	<br/><br/>

						<input type="button" value="Search" class="uk-button uk-button-primary uk-button-small" onclick="WT_formfillupListing();" style="cursor:pointer;"/>&nbsp;&nbsp;
						<input type="button" value="Reset" onclick="searchReset();" class="uk-button uk-button-secondary uk-button-small" style="cursor:pointer;"/>&nbsp;&nbsp;
						<input type="button" value="Applicant Form Entry" onclick="formReset();" style="cursor:pointer;background-color: #0da50b" class="uk-button uk-button-secondary uk-button-small"  />
						<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
						<input type="hidden"  id="WT_formfilluppagingPageno" value="1" />	

					</div>
					<div  class="ajaxViewMainTableTDListData" id="WT_formfillupListDiv">&nbsp; </div>
				&nbsp;</td>
			</tr>
		</table>




		<script>
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


    function view_form_fillup(formfillup_id){
    	var formdata = new FormData();	 
    	formdata.append('formfillup_id',formfillup_id );
    	var url='<? echo $ajaxFilePath ?>?view_form_fillup=OK&';
    	os.animateMe.div='div_busy';
    	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
    	os.setAjaxHtml('view_form_record_div',url,formdata);
							// $("#view_booking_heading").html(`View Booking ID : <span style="color:green">${formfillup_id}</span>`)
							UIkit.modal('#view_form_data_modal').show();

						}
						function upload_doc(){
							var formdata = new FormData();
							var imageVal= os.getObj('image').files[0];
							if(!imageVal){
								return false;
							}
							if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
							formdata.append('doc_title',os.getVal('doc_title'));
							var url='<? echo $ajaxFilePath ?>?upload_doc=OK&';
							os.animateMe.div='div_busy';
							os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
							os.setAjaxFunc('img_reload_list',url,formdata);
						}
						function img_reload_list(data){
							$("#uploaded_doc_div").append(data);
							$('#image').val('');
							$("#image_name").html('Select Document');
							$('#doc_title').val('')
						}
						function set_fees(){
							var formdata = new FormData();
							formdata.append('year',os.getVal("year"));
							formdata.append('class_id',os.getVal("class_id"));
							formdata.append('form_for',os.getVal("form_for"));
							var url='<? echo $ajaxFilePath ?>?set_fees=OK&';
							os.animateMe.div='div_busy';
							os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
							os.setAjaxFunc('set_fees_val',url,formdata);

						}
						function set_fees_val(data){
							
							os.setVal('fees_structure',data);
						}
						function change_form_status(formfillup_id,change_form,change_to){
							var formdata = new FormData();
							formdata.append('formfillup_id',formfillup_id);
							formdata.append('change_form',change_form);
							formdata.append('change_to',change_to);
							formdata.append('change_form_status','OKS');
							var url='<? echo $ajaxFilePath ?>?change_form_status=OK&';
							os.animateMe.div='div_busy';
							os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
							os.setAjaxFunc('WT_patientListing',url,formdata);

						}
					// formReset();
					function formReset(){   
						$('#form_fillup_form')[0].reset();
						$('#b_id_span').html('Applicant Form Entry');
						os.setImg('profile_picturePreview',"<?= $site["themePath"]?>images/profile.png"); 
						$('#uploaded_doc_div').html('');
						$('#subscription_title').html('Applicant Form Entry');
						UIkit.modal('#form_modal').show();
					}

					function WT_formfillupListing(){
						var formdata = new FormData();
						formdata.append('form_for_s',os.getVal('form_for_s') );
						formdata.append('form_no_s',os.getVal('form_no_s') );
						formdata.append('year_s',os.getVal('year_s') );
						formdata.append('class_id_s',os.getVal('class_id_s') );
						formdata.append('name_s',os.getVal('name_s') );
						formdata.append('mobile_student_s',os.getVal('mobile_student_s'));
						formdata.append('form_status_s',os.getVal('form_status_s') );
						formdata.append('payment_status_s',os.getVal('payment_status_s') );
						formdata.append('searchKey',os.getVal('searchKey') );
						formdata.append('showPerPage',os.getVal('showPerPage') );
						var WT_formfilluppagingPageno=os.getVal('WT_formfilluppagingPageno');
						var url='wtpage='+WT_formfilluppagingPageno;
						url='<? echo $ajaxFilePath ?>?WT_formfillupListing=OK&'+url;
						os.animateMe.div='div_busy';
						os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
						os.setAjaxHtml('WT_formfillupListDiv',url,formdata);

					}

					WT_formfillupListing();
					function  searchReset(){
						os.setVal('form_for_s',''); 
						os.setVal('form_no_s',''); 
						os.setVal('year_s',''); 
						os.setVal('class_id_s',''); 
						os.setVal('name_s',''); 
						os.setVal('mobile_student_s',''); 
						os.setVal('form_status_s',''); 
						os.setVal('payment_status_s',''); 
						os.setVal('searchKey','');
						WT_formfillupListing();	

					}


					function WT_formfillupEditAndSave(form){
						var formdata = new FormData(form);
						var profile_pictureVal= os.getObj('profile_picture').files[0]; 
						if(profile_pictureVal){  formdata.append('profile_picture',profile_pictureVal,profile_pictureVal.name );}
						
						
						if(os.check.empty('form_no','Please Add Form no')==false){ return false;} 
						
						    
						
						if(os.check.empty('name','Please Enter Name')==false){ return false;} 
						if(os.check.empty('dob','Please Enter DOB')==false){ return false;} 
						if(os.check.empty('class_id','Please enter Class')==false){ return false;} 
						if(os.check.empty('father_name','Please enter Father Name')==false){ return false;} 
						if(os.check.empty('father_mobile','Please enter Father Contact')==false){ return false;} 
						
						
						
						
						var   formfillup_id=os.getVal('formfillup_id');
						formdata.append('formfillup_id',formfillup_id );
						var url='<? echo $ajaxFilePath ?>?WT_formfillupEditAndSave=OK&';
						os.animateMe.div='div_busy';
						os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
						os.setAjaxFunc('WT_formfillupReLoadList',url,formdata);
						
						
						

					}	

					function WT_formfillupReLoadList(data){
					UIkit.modal('#form_modal').hide();
						var d=data.split('#-#');
						var formfillup_id=parseInt(d[0]);
						if(d[0]!='Error' && formfillup_id>0)
						{
							os.setVal('formfillup_id',formfillup_id);
						}

						if(d[1]!=''){alert(d[1]);}
						WT_formfillupListing();
					}

					function WT_formfillupGetById(formfillup_id){
						var formdata = new FormData();	 
						formdata.append('formfillup_id',formfillup_id );
						var url='<? echo $ajaxFilePath ?>?WT_formfillupGetById=OK&';
						os.animateMe.div='div_busy';
						os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
						os.setAjaxFunc('WT_formfillupFillData',url,formdata);

					}

					function WT_formfillupFillData(data){
						var objJSON = JSON.parse(data);
						$("#uploaded_doc_div").html('');
						$('#image').val('');
						$("#image_name").html('Select Document');
						$('#doc_title').val('')
						os.setVal('formfillup_id',objJSON.formfillup_id);
						$('#b_id_span').html(parseInt(objJSON.formfillup_id));	
						

						os.setVal('name',objJSON.name); 
						os.setVal('father_name',objJSON.father_name);
						os.setVal('father_ocu',objJSON.father_ocu);						
						os.setVal('father_qualification',objJSON.father_qualification); 
						os.setVal('father_monthly_income',objJSON.father_monthly_income); 
						os.setVal('father_mobile',objJSON.father_mobile); 

						os.setVal('mother_name',objJSON.mother_name); 
						os.setVal('mother_occupation',objJSON.mother_occupation); 

						os.setVal('mother_qualification',objJSON.mother_qualification); 

						os.setVal('mother_monthly_income',objJSON.mother_monthly_income); 
						os.setVal('mother_mobile',objJSON.mother_mobile); 
						os.setVal('guardian_name',objJSON.guardian_name); 

						os.setVal('relationship',objJSON.relationship); 
						os.setVal('class_id',objJSON.class_id); 
						os.setVal('academic_year',objJSON.academic_year); 
						os.setVal('dob',objJSON.dob); 
						os.setVal('aadhaar_number',objJSON.aadhaar_number); 
						os.setVal('place_of_birth',objJSON.place_of_birth);
						os.setVal('blood_group',objJSON.blood_group); 
						os.setVal('gender',objJSON.gender); 
						os.setVal('caste',objJSON.caste);
						os.setVal('religion',objJSON.religion); 
						os.setVal('physically_challanged',objJSON.physically_challanged); 
						
						os.setVal('vill',objJSON.vill); 
						os.setVal('po',objJSON.po); 
						os.setVal('ps',objJSON.ps); 
						os.setVal('dist',objJSON.dist); 
						os.setVal('block',objJSON.block); 
						os.setVal('pin',objJSON.pin); 
						os.setVal('state',objJSON.state);

						os.setVal('permanent_village',objJSON.permanent_village); 
						os.setVal('permanent_post_office',objJSON.permanent_post_office); 
						os.setVal('permanent_police_station',objJSON.permanent_police_station); 
						os.setVal('permanent_block',objJSON.permanent_block); 
						os.setVal('permanent_pincode',objJSON.permanent_pincode); 
						os.setVal('permanent_district',objJSON.permanent_district); 
						os.setVal('permanent_state',objJSON.permanent_state);

						os.setVal('form_no',objJSON.form_no); 
						os.setVal('application_no',objJSON.application_no); 
						os.setVal('application_date',objJSON.application_date); 
						os.setVal('exam_date',objJSON.exam_date); 
						os.setVal('exam_time',objJSON.exam_time); 
						os.setVal('exam_center',objJSON.exam_center); 
						os.setVal('center_code',objJSON.center_code);


						os.setImg('profile_picturePreview',objJSON.profile_picture); 

						$('#subscription_title').html("Edit Applicant Form ")   
						UIkit.modal('#form_modal').show();


					}

					function WT_formfillupDeleteRowById(formfillup_id){
						var formdata = new FormData();	 
						if(parseInt(formfillup_id)<1 || formfillup_id==''){  
							var  formfillup_id =os.getVal('formfillup_id');
						}

						if(parseInt(formfillup_id)<1){ alert('No record Selected'); return;}

						var p =confirm('Are you Sure? You want to delete this record forever.')
						if(p){

							formdata.append('formfillup_id',formfillup_id );

							var url='<? echo $ajaxFilePath ?>?WT_formfillupDeleteRowById=OK&';
							os.animateMe.div='div_busy';
							os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
							os.setAjaxFunc('WT_formfillupDeleteRowByIdResults',url,formdata);
						}


					}
					function WT_formfillupDeleteRowByIdResults(data)
					{
						alert(data);
						WT_formfillupListing();
					} 

					function wtAjaxPagination(pageId,pageNo){
						os.setVal('WT_formfilluppagingPageno',parseInt(pageNo));
						WT_formfillupListing();
					}






				</script>

				<!-- This is feees setting   modal -->
				<div id="student_fees_setting_modal" class="uk-flex-top" uk-modal>
					<div class="uk-modal-dialog uk-width-1-1">
						<button class="uk-modal-close-default" type="button" uk-close></button>
						<div class="uk-card uk-card-default uk-card-small">
							<form  id="student_fees_setting_form">
								<div class="uk-card-header">
									<h5 >Fees settings </h5>
								</div>

								<div  id="student_fees_setting_div" style="padding:10px;">
								</div>

							</form>		
						</div>
					</div>
				</div>
				<script type="text/javascript">

					function student_fees_setting(formfillup_id ,action)
					{      

						var formdata = new FormData(os.getObj('student_fees_setting_form'));
						formdata.append('formfillup_id',formfillup_id );
						formdata.append('action',action);




						var url='<? echo $ajaxFilePath ?>?student_fees_setting=OK&'+url;
						os.animateMe.div='div_busy';
						os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
						os.setAjaxHtml('student_fees_setting_div',url,formdata);
						UIkit.modal('#student_fees_setting_modal').show();

					}



				</script>
				<!-- This is feees setting   modal -->
				<script type="text/javascript">

					function student_admission_from_formfillup(formfillup_id)
					{      
						var p=confirm('Admission process will start.Are you sure?'); 

						if(p)
						{
							var formdata = new FormData();
							formdata.append('formfillup_id',formfillup_id );





							var url='<? echo $ajaxFilePath ?>?student_admission_from_formfillup=OK&';
							os.animateMe.div='div_busy';
							os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
							os.setAjaxFunc('student_admission_from_formfillup_result',url,formdata);


						}	

					}
					function student_admission_from_formfillup_result(data)
					{

						var  result=	getData(data,'##-FORMFILLUP_DATA_RESULT-##');
						var  regno=	getData(data,'##-FORMFILLUP_DATA_REGNO-##');

	if(result=='Insert Success' && regno!='' ) // Insert Fail //Insert Success
	{
		window.location ='<? $site['url-wtos']?>historyDataView.php?formfillup_regno='+regno;

	}
	else{

		alert(result);

	}
	

}



</script>

<? include($site['root-wtos'].'bottom.php'); ?>