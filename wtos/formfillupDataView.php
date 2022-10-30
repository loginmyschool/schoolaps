<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List formfillup';
$ajaxFilePath= 'formfillupAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
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
                <h5 class="uk-text-large uk-text-italic uk-text-emphasis" id="view_booking_heading">View Form Fillup</h5>
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
				<h4 id="subscription_title" class="uk-text-large uk-text-italic uk-text-emphasis uk-hidden">New Form Fillup</h4>
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
									Form Type:
									<select name="form_for" id="form_for" class="uk-select form-field" onchange="set_fees();">

										<?$os->onlyOption($os->admissionType);	?></select>	 </td>

									</div>

									<div class="uk-margin-small">
										Form no:
										<input value="" type="text" name="form_no" id="form_no" class="uk-input form-field"/>
									</div>
									<div class="uk-margin-small">
										Year:
										<select name="year" id="year" class="uk-select form-field " onchange="set_fees();">
											<option value="">Select Year</option>
											<? $os->onlyOption($os->asession);	?>
										</select>	
									</div>
									<div class="uk-margin-small">
										Class:<select name="class_id" id="class_id" class="uk-select form-field" onchange="set_fees();"><option value="">Select Class</option>	<? 
										$os->onlyOption($os->classList);	?></select>
									</div>

									<div class="uk-margin-small">
										Name:<input value="" type="text" name="name" id="name" class="uk-input form-field"/>
									</div>

									<div class="uk-margin-small">
										Mobile No:<input value="" type="text" name="mobile_student" id="mobile_student" class="uk-input form-field"/>
									</div>
									<div class="uk-margin-small">
										Profile picture:<img id="profile_picturePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="profile_picture" value=""  id="profile_picture" onchange="os.readURL(this,'profile_picturePreview') " style="display:none;"/><br>

										<span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('profile_picture');">Edit Image</span>
									</div>

									<div class="uk-margin-small">
										D.O.B:<input value="" type="text" name="dob" id="dob" class="wtDateClass uk-input form-field"/>
									</div>
									<div class="uk-card-footer  uk-text-center">
										<? if($os->access('wtEdit')){ ?><input type="submit" value="Save" class="uk-button-primary uk-width-expand" style="cursor: pointer;" /><? } ?>	                   
									</div>
								</div>


								<div>

									<div class="uk-margin-small">
										Gender:<select name="gender" id="gender" class="uk-select form-field" >
											<option value=""></option>
											<? $os->onlyOption($os->gender);?>
										</select>
									</div>

									<div class="uk-margin-small">Caste:<select name="caste" id="caste" class="uk-select form-field" ><option value=""></option>	<? 
									$os->onlyOption($os->caste);	?></select>	</div>									
									<div class="uk-margin-small">Father name :<input value="" type="text" name="father_name" id="father_name" class="uk-input form-field "/> </div>	


									<div class="uk-margin-small">Father ocuupation <input value="" type="text" name="father_ocu" id="father_ocu" class="uk-input form-field "/> </div>


									<div class="uk-margin-small">Father monthly income <input value="" type="text" name="father_monthly_income" id="father_monthly_income" class="uk-input form-field "/> </div>									

									<div class="uk-margin-small">Vill <input value="" type="text" name="vill" id="vill" class="uk-input form-field "/> </div>	



									<div class="uk-margin-small">P.O <input value="" type="text" name="po" id="po" class="uk-input form-field "/> </div>

									<div class="uk-margin-small">P.S <input value="" type="text" name="ps" id="ps" class="uk-input form-field "/> </div>
									
								</div>
								<div>
									<div class="uk-margin-small">Dist <input value="" type="text" name="dist" id="dist" class="uk-input form-field "/> </div>

									<div class="uk-margin-small">Block <input value="" type="text" name="block" id="block" class="uk-input form-field "/> </div>						

									<div class="uk-margin-small">Pin <input value="" type="text" name="pin" id="pin" class="uk-input form-field "/> </div>						

									<div class="uk-margin-small">State <input value="" type="text" name="state" id="state" class="uk-input form-field "/> </div>
									<div class="uk-margin-small">Last school <input value="" type="text" name="last_school" id="last_school" class="uk-input form-field "/> </div>						

									<div class="uk-margin-small">Last class <input value="" type="text" name="last_class" id="last_class" class="uk-input form-field "/> </div>						

									<div class="uk-margin-small">Last school session <input value="" type="text" name="last_school_session" id="last_school_session" class="uk-input form-field "/> </div>	
									<div class="uk-margin-small">Last school address <input value="" type="text" name="last_school_address" id="last_school_address" class="uk-input form-field "/> </div>											
								</div>


								<div>
									<div class="uk-margin-small">Subject marks data <input value="" type="text" name="subject_marks_data" id="subject_marks_data" class="uk-input form-field "/> </div>						

									<div class="uk-margin-small">Form fillup date <input value="" type="text" name="form_fill_date" id="form_fill_date" class="wtDateClass uk-input form-field"/></div>						

									<div class="uk-margin-small">Fees structure <input value="" type="text" name="fees_structure" id="fees_structure" class="uk-input form-field "/> </div>



									<div class="uk-margin-small">Form status   

										<select name="form_status" id="form_status" class="uk-select form-field" ><option value="">Select Form status</option>	<? 
										$os->onlyOption($os->form_status);	?></select>	 </div>						

										<div class="uk-margin-small">Form status date <input value="" type="text" name="form_status_dated" id="form_status_dated" class="wtDateClass uk-input form-field"/></div>						

										<div class="uk-margin-small">Form status by<input value="" type="text" name="form_status_by" id="form_status_by" class="uk-input form-field "/> </div>						

										<div class="uk-margin-small">Amount<input value="" type="text" name="amount" id="amount" class="uk-input form-field "/> </div>						

										<div class="uk-margin-small">Payment status 

											<select name="payment_status" id="payment_status" class="uk-select form-field" ><option value="">Select Payment status</option>	<? 
											$os->onlyOption($os->paymentStatus);	?></select>	 </div>						

											<div class="uk-margin-small">Payment details <textarea  name="payment_details" id="payment_details" class="uk-textarea form-field"></textarea></div>

										</div>
										<div>
											<div class="input-group">
												<span>Documents</span>
												<table class="uk-table-justify  uk-margin-small-bottom uk-margin-small-top uk-width-1-1 uk-table-divider" style="border-collapse: collapse">
													<tbody id="uploaded_doc_div">

													</tbody>
												</table>
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
														</tr>
														<tr>
															<td>
																<input value="" type="text" name="doc_title" id="doc_title" class="uk-input uk-form-small" placeholder="Document title"/>
															</td>

															<td class="uk-table-shrink " style="padding-left: 10px">
																<button onclick="if($('#image').val()===''){alert('please select file');return false;};
																if($('#doc_title').val()===''){alert('please put documnt title');return false;};
																if(confirm('Are you sure?')){upload_doc();} " class="uk-button uk-button-small  uk-button-primary uk-text-nowrap" type="button">Upload</button>
															</td>
														</tr>
													</tfoot>
												</table>

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
								<input type="text" class="wtTextClass" name="mobile_student_s" id="mobile_student_s" value="" placeholder="Mobile No" style="width: 100px;" /> &nbsp;
								<select name="form_status" id="form_status_s" class="textbox fWidth" ><option value="">Form status</option>	<? 
								$os->onlyOption($os->form_status);	?></select> &nbsp;
								<select name="form_for" id="form_for_s" class="textbox fWidth uk-hidden" >
									<option value="">Type</option><? 
									$os->onlyOption($os->admissionType);	?></select>	

									<input type="text" class="wtTextClass" name="form_no_s" id="form_no_s" value="" placeholder="Application No" style="width: 120px;"/> &nbsp;  
									
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
									<input type="button" value="Add Form Fillup" onclick="formReset();" style="cursor:pointer;background-color: #0da50b" class="uk-button uk-button-secondary uk-button-small uk-hidden"  />
									<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
									<input type="hidden"  id="WT_formfilluppagingPageno" value="1" />	

								</div>
								<div  class="ajaxViewMainTableTDListData" id="WT_formfillupListDiv">&nbsp; </div>
							&nbsp;</td>
						</tr>
					</table>




					<script>
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
						$('#b_id_span').html('NEW FORM FILLUP');
						$('#image_name').html('Select Document');
						$('#uploaded_doc_div').html('');
						$('#subscription_title').html('New Form Fillup');
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
						if(os.check.empty('form_for','Please Add Form for')==false){ return false;} 
						var   formfillup_id=os.getVal('formfillup_id');
						formdata.append('formfillup_id',formfillup_id );
						var url='<? echo $ajaxFilePath ?>?WT_formfillupEditAndSave=OK&';
						os.animateMe.div='div_busy';
						os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
						os.setAjaxFunc('WT_formfillupReLoadList',url,formdata);

					}	

function WT_formfillupReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var formfillup_id=parseInt(d[0]);
	if(d[0]!='Error' && formfillup_id>0)
	{
		os.setVal('formfillup_id',formfillup_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_formfillupListing();
}

function WT_formfillupGetById(formfillup_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('formfillup_id',formfillup_id );
	var url='<? echo $ajaxFilePath ?>?WT_formfillupGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_formfillupFillData',url,formdata);

}

function WT_formfillupFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	$("#uploaded_doc_div").html('');
	$('#image').val('');
	$("#image_name").html('Select Document');
	$('#doc_title').val('')
	os.setVal('formfillup_id',parseInt(objJSON.formfillup_id));
	$('#b_id_span').html(parseInt(objJSON.formfillup_id));	
	os.setVal('branch_id',objJSON.branch_id); 
	os.setVal('form_for',objJSON.form_for); 
	os.setVal('form_no',objJSON.form_no); 
	os.setVal('year',objJSON.year); 
	os.setVal('class_id',objJSON.class_id); 
	os.setVal('name',objJSON.name); 
	os.setVal('mobile_student',objJSON.mobile_student); 
	os.setImg('profile_picturePreview',objJSON.profile_picture); 
	os.setVal('dob',objJSON.dob); 
	os.setVal('gender',objJSON.gender); 
	os.setVal('caste',objJSON.caste); 
	os.setVal('father_name',objJSON.father_name); 
	os.setVal('father_ocu',objJSON.father_ocu); 
	os.setVal('father_monthly_income',objJSON.father_monthly_income); 
	os.setVal('vill',objJSON.vill); 
	os.setVal('po',objJSON.po); 
	os.setVal('ps',objJSON.ps); 
	os.setVal('dist',objJSON.dist); 
	os.setVal('block',objJSON.block); 
	os.setVal('pin',objJSON.pin); 
	os.setVal('state',objJSON.state); 
	os.setVal('last_school',objJSON.last_school); 
	os.setVal('last_class',objJSON.last_class); 
	os.setVal('last_school_session',objJSON.last_school_session); 
	os.setVal('last_school_address',objJSON.last_school_address); 
	os.setVal('subject_marks_data',objJSON.subject_marks_data); 
	os.setVal('form_fill_date',objJSON.form_fill_date); 
	os.setVal('fees_structure',objJSON.fees_structure); 
	os.setVal('form_status',objJSON.form_status); 
	os.setVal('form_status_dated',objJSON.form_status_dated); 
	os.setVal('form_status_by',objJSON.form_status_by); 
	os.setVal('amount',objJSON.amount); 
	os.setVal('payment_status',objJSON.payment_status); 
	os.setVal('payment_details',objJSON.payment_details); 
	$('#subscription_title').html("Edit Form Fillup")   
	UIkit.modal('#form_modal').show();


}

function WT_formfillupDeleteRowById(formfillup_id) // delete record by table id
{
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

function wtAjaxPagination(pageId,pageNo)// pagination function
{
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