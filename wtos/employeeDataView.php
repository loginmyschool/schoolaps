<?
/*
   # wtos version : 1.1
   # main ajax process page : employeeAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List employee';
$ajaxFilePath= 'employeeAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

?>


<table class="container">
	<tr>

		<td  class="middle" style="padding-left:5px;">


			<div class="listHeader"> <?php  echo $listHeader; ?>  </div>

			<!--  ggggggggggggggg   -->


			<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

				<tr>
					<td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
						<div class="formDiv">
							<div class="formDivButton">
								<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_employeeDeleteRowById('');" /><? } ?>	 
								&nbsp;&nbsp;
								&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

								&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_employeeEditAndSave();" /><? } ?>	 

							</div>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
								<tr >
									<td>Branch </td>
									<td>  

										<select name="branch_name" id="branch_name" class="textbox fWidth" ><option value="">Select Branch</option>	<? 
										$os->onlyOption($os->branch_name);	?></select>	 </td>						
									</tr>	

									<tr >
										<td>Full name </td>
										<td><input value="" type="text" name="full_name" id="full_name" class="textboxxx  fWidth "/> </td>						
									</tr><tr >
										<td>Short name </td>
										<td><input value="" type="text" name="short_name" id="short_name" class="textboxxx  fWidth "/> </td>						
									</tr><tr >
										<td>Contact no </td>
										<td><input value="" type="text" name="contact_no" id="contact_no" class="textboxxx  fWidth "/> </td>						
									</tr><tr >
										<td>Dob </td>
										<td><input value="" type="text" name="dob" id="dob" class="wtDateClass textbox fWidth"/></td>						
									</tr><tr >
										<td>Designation </td>
										<td><input value="" type="text" name="designation" id="designation" class="textboxxx  fWidth "/> </td>						
									</tr><tr >
										<td>Type </td>
										<td>  

											<select name="type" id="type" class="textbox fWidth" ><option value="">Select Type</option>	<? 
											$os->onlyOption($os->employee_type);	?></select>	 </td>						
										</tr><tr >
											<td>Main subject </td>
											<td><input value="" type="text" name="main_subject" id="main_subject" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
											<td>Others subject </td>
											<td><input value="" type="text" name="others_subject" id="others_subject" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
											<td>Date of joining </td>
											<td><input value="" type="text" name="date_of_joining" id="date_of_joining" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
											<td>Previous institute </td>
											<td><input value="" type="text" name="previous_institute" id="previous_institute" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
											<td>educational_qualification </td>
											<td><input value="" type="text" name="educational_qualification" id="educational_qualification" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
											<td>Fathers mothers name </td>
											<td><input value="" type="text" name="fathers_mothers_name" id="fathers_mothers_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
											<td>Language </td>
											<td>  

												<select name="language" id="language" class="textbox fWidth" ><option value="">Select Language</option>	<? 
												$os->onlyOption($os->emp_language);	?></select>	 </td>						
											</tr><tr >
												<td>Nationality </td>
												<td><input value="" type="text" name="nationality" id="nationality" class="textboxxx  fWidth "/> </td>						
											</tr><tr >
												<td>Correspondent address </td>
												<td><input value="" type="text" name="correspondent_address" id="correspondent_address" class="textboxxx  fWidth "/> </td>						
											</tr><tr >
												<td>Permanent address </td>
												<td><input value="" type="text" name="permanent_address" id="permanent_address" class="textboxxx  fWidth "/> </td>						
											</tr><tr >
												<td>Blood group </td>
												<td>  

													<select name="blood_group" id="blood_group" class="textbox fWidth" ><option value="">Select Blood group</option>	<? 
													$os->onlyOption($os->blood_group);	?></select>	 </td>						
												</tr><tr >
													<td>Bank details </td>
													<td><input value="" type="text" name="bank_details" id="bank_details" class="textboxxx  fWidth "/> </td>						
												</tr><tr >
													<td>Image </td>
													<td>

														<img id="imagePreview" src="" height="100" style="display:none;"	 />		
														<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>

														<span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>



													</td>						
												</tr>	


											</table>


											<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
											<input type="hidden"  id="employee_id" value="0" />	
											<input type="hidden"  id="WT_employeepagingPageno" value="1" />	
											<div class="formDivButton">						
												<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_employeeDeleteRowById('');" />	<? } ?>	  
												&nbsp;&nbsp;
												&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

												&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_employeeEditAndSave();" /><? } ?>	
											</div> 
										</div>	



									</td>
									<td valign="top" class="ajaxViewMainTableTDList">

										<div class="ajaxViewMainTableTDListSearch">
											Search Key  
											<input type="text" id="searchKey" />   &nbsp;



											<div style="display:none" id="advanceSearchDiv">

												Full name: <input type="text" class="wtTextClass" name="full_name_s" id="full_name_s" value="" /> &nbsp;  Short name: <input type="text" class="wtTextClass" name="short_name_s" id="short_name_s" value="" /> &nbsp;  Contact no: <input type="text" class="wtTextClass" name="contact_no_s" id="contact_no_s" value="" /> &nbsp; From Dob: <input class="wtDateClass" type="text" name="f_dob_s" id="f_dob_s" value=""  /> &nbsp;   To Dob: <input class="wtDateClass" type="text" name="t_dob_s" id="t_dob_s" value=""  /> &nbsp;  
												Designation: <input type="text" class="wtTextClass" name="designation_s" id="designation_s" value="" /> &nbsp;  Type:

												<select name="type" id="type_s" class="textbox fWidth" ><option value="">Select Type</option>	<? 
												$os->onlyOption($os->employee_type);	?></select>	

											</div>


											<input type="button" value="Search" onclick="WT_employeeListing();" style="cursor:pointer;"/>
											<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

										</div>
										<div  class="ajaxViewMainTableTDListData" id="WT_employeeListDiv">&nbsp; </div>
									&nbsp;</td>
								</tr>
							</table>



							<!--   ggggggggggggggg  -->

						</td>
					</tr>
				</table>



				<script>

function WT_employeeListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
	var full_name_sVal= os.getVal('full_name_s'); 
	var short_name_sVal= os.getVal('short_name_s'); 
	var contact_no_sVal= os.getVal('contact_no_s'); 
	var f_dob_sVal= os.getVal('f_dob_s'); 
	var t_dob_sVal= os.getVal('t_dob_s'); 
	var designation_sVal= os.getVal('designation_s'); 
	var type_sVal= os.getVal('type_s'); 
	formdata.append('full_name_s',full_name_sVal );
	formdata.append('short_name_s',short_name_sVal );
	formdata.append('contact_no_s',contact_no_sVal );
	formdata.append('f_dob_s',f_dob_sVal );
	formdata.append('t_dob_s',t_dob_sVal );
	formdata.append('designation_s',designation_sVal );
	formdata.append('type_s',type_sVal );

	

	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_employeepagingPageno=os.getVal('WT_employeepagingPageno');
	var url='wtpage='+WT_employeepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_employeeListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_employeeListDiv',url,formdata);

}

WT_employeeListing();
function  searchReset() // reset Search Fields
{
	os.setVal('full_name_s',''); 
	os.setVal('short_name_s',''); 
	os.setVal('contact_no_s',''); 
	os.setVal('f_dob_s',''); 
	os.setVal('t_dob_s',''); 
	os.setVal('designation_s',''); 
	os.setVal('type_s',''); 
	
	os.setVal('searchKey','');
	WT_employeeListing();	
	
}


function WT_employeeEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var full_nameVal= os.getVal('full_name'); 
	var short_nameVal= os.getVal('short_name'); 
	var contact_noVal= os.getVal('contact_no'); 
	var dobVal= os.getVal('dob'); 
	var designationVal= os.getVal('designation'); 
	var typeVal= os.getVal('type'); 
	var main_subjectVal= os.getVal('main_subject'); 
	var others_subjectVal= os.getVal('others_subject'); 
	var date_of_joiningVal= os.getVal('date_of_joining'); 
	var previous_instituteVal= os.getVal('previous_institute'); 
	var educational_qualificationVal= os.getVal('educational_qualification'); 
	var fathers_mothers_nameVal= os.getVal('fathers_mothers_name'); 
	var languageVal= os.getVal('language'); 
	var nationalityVal= os.getVal('nationality'); 
	var correspondent_addressVal= os.getVal('correspondent_address'); 
	var permanent_addressVal= os.getVal('permanent_address'); 
	var blood_groupVal= os.getVal('blood_group'); 
	var bank_detailsVal= os.getVal('bank_details'); 
	var imageVal= os.getObj('image').files[0]; 
	var branch_name= os.getVal('branch_name'); 

	formdata.append('branch_name',branch_name);

	formdata.append('full_name',full_nameVal );
	formdata.append('short_name',short_nameVal );
	formdata.append('contact_no',contact_noVal );
	formdata.append('dob',dobVal );
	formdata.append('designation',designationVal );
	formdata.append('type',typeVal );
	formdata.append('main_subject',main_subjectVal );
	formdata.append('others_subject',others_subjectVal );
	formdata.append('date_of_joining',date_of_joiningVal );
	formdata.append('previous_institute',previous_instituteVal );
	formdata.append('educational_qualification',educational_qualificationVal );
	formdata.append('fathers_mothers_name',fathers_mothers_nameVal );
	formdata.append('language',languageVal );
	formdata.append('nationality',nationalityVal );
	formdata.append('correspondent_address',correspondent_addressVal );
	formdata.append('permanent_address',permanent_addressVal );
	formdata.append('blood_group',blood_groupVal );
	formdata.append('bank_details',bank_detailsVal );
	if(imageVal){  formdata.append('image',imageVal,imageVal.name );}

	
	if(os.check.empty('full_name','Please Add Full name')==false){ return false;} 

	var   employee_id=os.getVal('employee_id');
	formdata.append('employee_id',employee_id );
	var url='<? echo $ajaxFilePath ?>?WT_employeeEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_employeeReLoadList',url,formdata);

}	

function WT_employeeReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var employee_id=parseInt(d[0]);
	if(d[0]!='Error' && employee_id>0)
	{
		os.setVal('employee_id',employee_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_employeeListing();
}

function WT_employeeGetById(employee_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('employee_id',employee_id );
	var url='<? echo $ajaxFilePath ?>?WT_employeeGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_employeeFillData',url,formdata);

}

function WT_employeeFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('employee_id',parseInt(objJSON.employee_id));
	
	os.setVal('full_name',objJSON.full_name); 
	os.setVal('short_name',objJSON.short_name); 
	os.setVal('contact_no',objJSON.contact_no); 
	os.setVal('dob',objJSON.dob); 
	os.setVal('designation',objJSON.designation); 
	os.setVal('type',objJSON.type); 
	os.setVal('main_subject',objJSON.main_subject); 
	os.setVal('others_subject',objJSON.others_subject); 
	os.setVal('date_of_joining',objJSON.date_of_joining); 
	os.setVal('previous_institute',objJSON.previous_institute); 
	os.setVal('educational_qualification',objJSON.educational_qualification); 
	os.setVal('fathers_mothers_name',objJSON.fathers_mothers_name); 
	os.setVal('language',objJSON.language); 
	os.setVal('nationality',objJSON.nationality); 
	os.setVal('correspondent_address',objJSON.correspondent_address); 
	os.setVal('permanent_address',objJSON.permanent_address); 
	os.setVal('blood_group',objJSON.blood_group); 
	os.setVal('bank_details',objJSON.bank_details); 
	os.setImg('imagePreview',objJSON.image); 
	os.setVal('branch_name',objJSON.branch_name); 

	


}

function WT_employeeDeleteRowById(employee_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(employee_id)<1 || employee_id==''){  
		var  employee_id =os.getVal('employee_id');
	}
	
	if(parseInt(employee_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

		formdata.append('employee_id',employee_id );

		var url='<? echo $ajaxFilePath ?>?WT_employeeDeleteRowById=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_employeeDeleteRowByIdResults',url,formdata);
	}


}
function WT_employeeDeleteRowByIdResults(data)
{
	alert(data);
	WT_employeeListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_employeepagingPageno',parseInt(pageNo));
	WT_employeeListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>