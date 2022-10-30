<?
/*
   # wtos version : 1.1
   # main ajax process page : online_formAjax.php 
   #  
*/
 
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Online form';
$ajaxFilePath= 'online_formAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';


$class_id=$os->get('class_id');
$asession=$os->get('asession');

if($asession=='')
{
 $asession=date('Y');
}


 
?>
  <div class="title-bar">
    <h3 class="background-color-white"><?php  echo $listHeader; ?>  <span style="color:#FF0000; cursor:pointer;" onclick="popDialogWH('application_form','Application form','90%','550')"> New Application</span>  
	
	<span><? if(isset($result_Data['message']))
{

echo $result_Data['message'];
} ?> </span>
	</h3>
</div>
<div class="content">
 
  <div id="application_form" style=" display:none;">
    <div class="item with-footer" >
        <div class="item-content p-m">
		 <div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_online_formDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_online_formEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>DOB </td>
										<td><input value="" type="text" name="dob" id="dob" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Age </td>
										<td><input value="" type="text" name="age" id="age" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Gender </td>
										<td>  
	
	<select name="gender" id="gender" class="textbox fWidth" ><option value="">Select Gender</option>	<? 
										  $os->onlyOption($os->gender);	?></select>	 </td>						
										</tr><tr >
	  									<td>UID </td>
										<td><input value="" type="text" name="uid" id="uid" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Caste </td>
										<td>  
	
	<select name="caste" id="caste" class="textbox fWidth" ><option value="">Select Caste</option>	<? 
										  $os->onlyOption($os->caste);	?></select>	 </td>						
										</tr><tr >
	  									<td>SubCaste </td>
										<td><input value="" type="text" name="subcast" id="subcast" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>APL/BPL </td>
										<td>  
	
	<select name="apl_bpl" id="apl_bpl" class="textbox fWidth" ><option value="">Select APL/BPL</option>	<? 
										  $os->onlyOption($os->aplOrBpl);	?></select>	 </td>						
										</tr><tr >
	  									<td>A/BPL No </td>
										<td><input value="" type="text" name="card_no" id="card_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Minority </td>
										<td><input value="" type="text" name="minority" id="minority" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Kanyashree </td>
										<td>  
	
	<select name="kanyashree" id="kanyashree" class="textbox fWidth" ><option value="">Select Kanyashree</option>	<? 
										  $os->onlyOption($os->kanyashree);	?></select>	 </td>						
										</tr><tr >
	  									<td>Yuvashree </td>
										<td>  
	
	<select name="yuvashree" id="yuvashree" class="textbox fWidth" ><option value="">Select Yuvashree</option>	<? 
										  $os->onlyOption($os->yuvashree);	?></select>	 </td>						
										</tr><tr >
	  									<td>adhar_name </td>
										<td><input value="" type="text" name="adhar_name" id="adhar_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>adhar_dob </td>
										<td><input value="" type="text" name="adhar_dob" id="adhar_dob" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>adhar_no </td>
										<td><input value="" type="text" name="adhar_no" id="adhar_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>ph </td>
										<td><input value="" type="text" name="ph" id="ph" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>ph_percent </td>
										<td><input value="" type="text" name="ph_percent" id="ph_percent" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>disable </td>
										<td><input value="" type="text" name="disable" id="disable" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>disable_percent </td>
										<td><input value="" type="text" name="disable_percent" id="disable_percent" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Father_name </td>
										<td><input value="" type="text" name="father_name" id="father_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Father_ocu </td>
										<td><input value="" type="text" name="father_ocu" id="father_ocu" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Father_adhar </td>
										<td><input value="" type="text" name="father_adhar" id="father_adhar" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother_name </td>
										<td><input value="" type="text" name="mother_name" id="mother_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother_ocu </td>
										<td><input value="" type="text" name="mother_ocu" id="mother_ocu" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother_adhar </td>
										<td><input value="" type="text" name="mother_adhar" id="mother_adhar" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Street/Vill/Location </td>
										<td><input value="" type="text" name="vill" id="vill" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>PO </td>
										<td><input value="" type="text" name="po" id="po" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Ps </td>
										<td><input value="" type="text" name="ps" id="ps" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Dist </td>
										<td><input value="" type="text" name="dist" id="dist" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Block </td>
										<td><input value="" type="text" name="block" id="block" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Pin </td>
										<td><input value="" type="text" name="pin" id="pin" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>State </td>
										<td><input value="" type="text" name="state" id="state" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Guardian_name </td>
										<td><input value="" type="text" name="guardian_name" id="guardian_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Guardian_relation </td>
										<td><input value="" type="text" name="guardian_relation" id="guardian_relation" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Guardian_address </td>
										<td><input value="" type="text" name="guardian_address" id="guardian_address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>guardian_ocu </td>
										<td><input value="" type="text" name="guardian_ocu" id="guardian_ocu" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Anual_income </td>
										<td><input value="" type="text" name="anual_income" id="anual_income" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>mobile_student </td>
										<td><input value="" type="text" name="mobile_student" id="mobile_student" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>mobile_guardian </td>
										<td><input value="" type="text" name="mobile_guardian" id="mobile_guardian" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>mobile_emergency </td>
										<td><input value="" type="text" name="mobile_emergency" id="mobile_emergency" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email_student </td>
										<td><input value="" type="text" name="email_student" id="email_student" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email_guardian </td>
										<td><input value="" type="text" name="email_guardian" id="email_guardian" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother_tongue </td>
										<td><input value="" type="text" name="mother_tongue" id="mother_tongue" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Blood_group </td>
										<td><input value="" type="text" name="blood_group" id="blood_group" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>religian </td>
										<td><input value="" type="text" name="religian" id="religian" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>other_religian </td>
										<td><input value="" type="text" name="other_religian" id="other_religian" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>image </td>
										<td>
										
										<img id="imagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>last_school </td>
										<td><input value="" type="text" name="last_school" id="last_school" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>last_class </td>
										<td><input value="" type="text" name="last_class" id="last_class" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>tc_no </td>
										<td><input value="" type="text" name="tc_no" id="tc_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>tc_date </td>
										<td><input value="" type="text" name="tc_date" id="tc_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>studentRemarks </td>
										<td><input value="" type="text" name="studentRemarks" id="studentRemarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>feesPayment </td>
										<td><input value="" type="text" name="feesPayment" id="feesPayment" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>board </td>
										<td>  
	
	<select name="board" id="board" class="textbox fWidth" ><option value="">Select board</option>	<? 
										  $os->onlyOption($os->board);	?></select>	 </td>						
										</tr><tr >
	  									<td>accNo </td>
										<td><input value="" type="text" name="accNo" id="accNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>accHolderName </td>
										<td><input value="" type="text" name="accHolderName" id="accHolderName" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>ifscCode </td>
										<td><input value="" type="text" name="ifscCode" id="ifscCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>branch </td>
										<td><input value="" type="text" name="branch" id="branch" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>otpPass </td>
										<td><input value="" type="text" name="otpPass" id="otpPass" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>applicaton_date </td>
										<td><input value="" type="text" name="applicaton_date" id="applicaton_date" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>class_id </td>
										<td>  
	
	<select name="class_id" id="class_id" class="textbox fWidth" ><option value="">Select class_id</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>asession </td>
										<td>  
	
	<select name="asession" id="asession" class="textbox fWidth" ><option value="">Select asession</option>	<? 
										  $os->onlyOption($os->asession);	?></select>	 </td>						
										</tr><tr >
	  									<td>Last_class_id </td>
										<td>  
	
	<select name="last_class_id" id="last_class_id" class="textbox fWidth" ><option value="">Select Last_class_id</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>Last_class_session </td>
										<td>  
	
	<select name="last_class_session" id="last_class_session" class="textbox fWidth" ><option value="">Select Last_class_session</option>	<? 
										  $os->onlyOption($os->asession);	?></select>	 </td>						
										</tr><tr >
	  									<td>Marks_percent </td>
										<td><input value="" type="text" name="marks_percent" id="marks_percent" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Last_institute_name </td>
										<td><input value="" type="text" name="last_institute_name" id="last_institute_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Last_institute_address </td>
										<td><input value="" type="text" name="last_institute_address" id="last_institute_address" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="online_form_id" value="0" />	
	<input type="hidden"  id="WT_online_formpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_online_formDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_online_formEditAndSave();" /><? } ?>	
	</div> 
	</div>
	
	
	  

            <!-----------123-->
        </div>
        <div class="item-footer">
            <div style="display: flex; justify-content: center; align-items: center; height: 100%">
                <? if($os->access('wtDelete')){ ?>
                    <button class="material-button dense error" type="button" value="Delete" onclick="WT_online_formDeleteRowById('');">Delete</button>
                <? } ?>
                &nbsp; <button class="material-button dense warn"  type="button" value="New" onclick="javascript:window.location='';">New</button>
                &nbsp;<? if($os->access('wtEdit')){ ?>
                    <button class="material-button dense success" type="button" value="Save" onclick="WT_online_formEditAndSave();" >Save</button>
                <? } ?>
            </div>
        </div>
    </div>
	</div>
	
	 
    <div  class="item">
        <div class="p-m">
          <!-----------123-->


	<div class="ajaxViewMainTableTDListSearch"> 
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;<input type="button" value="Search" onclick="WT_online_formListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/> &nbsp;&nbsp;
     
	  <select name="class_id" id="class_id_s" class="textbox fWidth" onchange="WT_online_formListing();setExelFormValues()" ><option value="">Select  </option>	<? 
										  $os->onlyOption($os->classList,$class_id);	?></select>	
										  <select name="asession" id="asession_s" onchange="WT_online_formListing();setExelFormValues()" class="textbox fWidth" ><option value="">Select asession</option>	<? 
										  $os->onlyOption($os->asession,$asession);	?></select>	
										  
										  
										  
										  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp; From DOB: <input class="wtDateClass" type="text" name="f_dob_s" id="f_dob_s" value=""  /> &nbsp;   To DOB: <input class="wtDateClass" type="text" name="t_dob_s" id="t_dob_s" value=""  /> &nbsp;  
   Gender:
	
	<select name="gender" id="gender_s" class="textbox fWidth" ><option value="">Select Gender</option>	<? 
										  $os->onlyOption($os->gender);	?></select>	
   UID: <input type="text" class="wtTextClass" name="uid_s" id="uid_s" value="" /> &nbsp;  Caste:
	
	<select name="caste" id="caste_s" class="textbox fWidth" ><option value="">Select Caste</option>	<? 
										  $os->onlyOption($os->caste);	?></select>	
   SubCaste: <input type="text" class="wtTextClass" name="subcast_s" id="subcast_s" value="" /> &nbsp;  APL/BPL:
	
	<select name="apl_bpl" id="apl_bpl_s" class="textbox fWidth" ><option value="">Select APL/BPL</option>	<? 
										  $os->onlyOption($os->aplOrBpl);	?></select>	
   PO: <input type="text" class="wtTextClass" name="po_s" id="po_s" value="" /> &nbsp;  Ps: <input type="text" class="wtTextClass" name="ps_s" id="ps_s" value="" /> &nbsp;  class_id:
	
	 
   
  </div>
 
   
  
  
  <input type="button" value="Bulk Registration with selected" style="display:none" /> 
  
  <input type="button" value="UPLOAD EXCEL" onclick=" popDialogWH('exel_upload_form','UPLOAD STUDENT DATA',700,300);" />
  <input type="button" value="Apply Approve to selected" onclick="apply_bulk_action_to_selected('set_Approved');" style="background-color:#006F00; color:#FFFFFF; padding:5px; cursor:pointer;" /> 
  <input type="button" value="Apply Rejected to selected" style="background-color:#FF925E;color:#ffffff; padding:5px; cursor:pointer;" onclick="apply_bulk_action_to_selected('set_Rejeceted');" /> 
  
  
  <input type="button" value="Delete selected" style="background-color:#FF4A4A;color:#FFFFFF; padding:5px; cursor:pointer;" onclick="apply_bulk_action_to_selected('set_Deleted');" /> 
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_online_formListDiv">&nbsp; </div>
             
        </div>
    </div>

</div>

  
			
	
	<div id="exel_upload_form" style="display:none;">
		 
		<input type="file" name="application_form_data_file"  id="application_form_data_file" /><br />
		  <span style="font-size:11px; font-style:italic; color:#EA7500; font-weight:bold">  Only supported extension is .xls  . format should be   <a href="<? echo $site['url-wtos'] ?>xcelFormats/application_data.xls">  <b>Download Format</b> </a> </span><br /><br />
	 
		<select name="form_class_id" id="form_class_id" class="textbox fWidth" ><option value="">Select  </option>	<? 
										  $os->onlyOption($os->classList,$class_id);	?></select>	
		<select name="form_asession" id="form_asession" class="textbox fWidth" ><option value="">Select asession</option>	<? 
										  $os->onlyOption($os->asession,$asession);	?></select>
		<input type="button" name="button" value="Upload Xcel"  style="cursor:pointer; color:#009900" onclick="form_application_excel_submit()" />
		
	  <div id="file_upload_message" style="color:#FF0000;"> </div>
	
	</div>
	 
<script>
function form_application_excel_submit()
{
		var formdata = new FormData();
		var application_form_data_fileVal='';
		
		if(os.getObj('application_form_data_file').files[0]){
		  var application_form_data_fileVal= os.getObj('application_form_data_file').files[0]; 
		}
		var session_val=os.getVal('form_asession');
		var class_id_val=os.getVal('form_class_id');
		 
		if(session_val==''  )
		{
		
		  alert ('Please select Session'); return false;
		
		}
		
		if(class_id_val==''  )
		{
		
		  alert ('Please select   Class'); return false;
		
		}
		
		if(application_form_data_fileVal == "")
		 {
		   alert('Please select excel file  '); return false;
		 }
		 else
		 {
			 var p=confirm('Excel File to upload : '+application_form_data_fileVal.name) 
			 if(!p)
			 {
			  return false;
			 }
		 
		 
		 }
		 
		
		 
		
		
		
		formdata.append('form_asession',session_val );
		formdata.append('form_class_id',class_id_val );
		formdata.append('registration_data_entry','OK' );

   if(application_form_data_fileVal){  
  		 formdata.append('application_form_data_file',application_form_data_fileVal,application_form_data_fileVal.name );
   }
		
	var url='<? echo $ajaxFilePath ?>?confirm_excel_upload=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('registration_data_entry_result',url,formdata);	
	 

}

function registration_data_entry_result(data)
{
		 if(!data)
		 {
			 $('#exel_upload_form').dialog('close');
			 WT_online_formListing();
		 }else
		 {
		 
		   	os.setHtml('file_upload_message',data);
		 }
		   
  
}

 

function apply_bulk_action_to_selected(action) //set_Approved
{
		var formdata = new FormData();
		 
		var online_form_ids_str=getValuesFromCheckedBox('online_form_ids[]');
		if(online_form_ids_str=='')
		{
		alert('Please select application.');
		return false;
		}
		 
		 
		 formdata.append('online_form_ids_str',online_form_ids_str );
		 formdata.append('action',action );
		
	formdata.append('apply_bulk_action_to_selected_result','OK' );	
	var url='<? echo $ajaxFilePath ?>?apply_bulk_action_to_selected_result=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('apply_bulk_action_to_selected_result',url,formdata);	

 
 
  
  
}

function apply_bulk_action_to_selected_result(data)
{ 
   WT_online_formListing();
}






function setExelFormValues()
{
        var session_val=os.getVal('asession_s');
		var class_id_val=os.getVal('class_id_s');
		os.setVal('form_asession', session_val);
		os.setVal('form_class_id', class_id_val);

}

function popDialogWH(elementId,titles,W,H)
    {
       os.getObj('application_form_data_file').files[0]='';
	   os.getObj(elementId).title=titles;
       $( function() {
            $( "#"+elementId ).dialog({
               width: W,
        height: H,
        modal: true});
        } );

    }
 
function WT_online_formListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var f_dob_sVal= os.getVal('f_dob_s'); 
 var t_dob_sVal= os.getVal('t_dob_s'); 
 var gender_sVal= os.getVal('gender_s'); 
 var uid_sVal= os.getVal('uid_s'); 
 var caste_sVal= os.getVal('caste_s'); 
 var subcast_sVal= os.getVal('subcast_s'); 
 var apl_bpl_sVal= os.getVal('apl_bpl_s'); 
 var po_sVal= os.getVal('po_s'); 
 var ps_sVal= os.getVal('ps_s'); 
 var class_id_sVal= os.getVal('class_id_s'); 
 var asession_sVal= os.getVal('asession_s'); 
formdata.append('name_s',name_sVal );
formdata.append('f_dob_s',f_dob_sVal );
formdata.append('t_dob_s',t_dob_sVal );
formdata.append('gender_s',gender_sVal );
formdata.append('uid_s',uid_sVal );
formdata.append('caste_s',caste_sVal );
formdata.append('subcast_s',subcast_sVal );
formdata.append('apl_bpl_s',apl_bpl_sVal );
formdata.append('po_s',po_sVal );
formdata.append('ps_s',ps_sVal );
formdata.append('class_id_s',class_id_sVal );
formdata.append('asession_s',asession_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_online_formpagingPageno=os.getVal('WT_online_formpagingPageno');
	var url='wtpage='+WT_online_formpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_online_formListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_online_formListDiv',url,formdata);
		
}

WT_online_formListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('f_dob_s',''); 
 os.setVal('t_dob_s',''); 
 os.setVal('gender_s',''); 
 os.setVal('uid_s',''); 
 os.setVal('caste_s',''); 
 os.setVal('subcast_s',''); 
 os.setVal('apl_bpl_s',''); 
 os.setVal('po_s',''); 
 os.setVal('ps_s',''); 
 os.setVal('class_id_s',''); 
 os.setVal('asession_s',''); 
	
		os.setVal('searchKey','');
		WT_online_formListing();	
	
	}
	
 
function WT_online_formEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var dobVal= os.getVal('dob'); 
var ageVal= os.getVal('age'); 
var genderVal= os.getVal('gender'); 
var uidVal= os.getVal('uid'); 
var casteVal= os.getVal('caste'); 
var subcastVal= os.getVal('subcast'); 
var apl_bplVal= os.getVal('apl_bpl'); 
var card_noVal= os.getVal('card_no'); 
var minorityVal= os.getVal('minority'); 
var kanyashreeVal= os.getVal('kanyashree'); 
var yuvashreeVal= os.getVal('yuvashree'); 
var adhar_nameVal= os.getVal('adhar_name'); 
var adhar_dobVal= os.getVal('adhar_dob'); 
var adhar_noVal= os.getVal('adhar_no'); 
var phVal= os.getVal('ph'); 
var ph_percentVal= os.getVal('ph_percent'); 
var disableVal= os.getVal('disable'); 
var disable_percentVal= os.getVal('disable_percent'); 
var father_nameVal= os.getVal('father_name'); 
var father_ocuVal= os.getVal('father_ocu'); 
var father_adharVal= os.getVal('father_adhar'); 
var mother_nameVal= os.getVal('mother_name'); 
var mother_ocuVal= os.getVal('mother_ocu'); 
var mother_adharVal= os.getVal('mother_adhar'); 
var villVal= os.getVal('vill'); 
var poVal= os.getVal('po'); 
var psVal= os.getVal('ps'); 
var distVal= os.getVal('dist'); 
var blockVal= os.getVal('block'); 
var pinVal= os.getVal('pin'); 
var stateVal= os.getVal('state'); 
var guardian_nameVal= os.getVal('guardian_name'); 
var guardian_relationVal= os.getVal('guardian_relation'); 
var guardian_addressVal= os.getVal('guardian_address'); 
var guardian_ocuVal= os.getVal('guardian_ocu'); 
var anual_incomeVal= os.getVal('anual_income'); 
var mobile_studentVal= os.getVal('mobile_student'); 
var mobile_guardianVal= os.getVal('mobile_guardian'); 
var mobile_emergencyVal= os.getVal('mobile_emergency'); 
var email_studentVal= os.getVal('email_student'); 
var email_guardianVal= os.getVal('email_guardian'); 
var mother_tongueVal= os.getVal('mother_tongue'); 
var blood_groupVal= os.getVal('blood_group'); 
var religianVal= os.getVal('religian'); 
var other_religianVal= os.getVal('other_religian'); 
var imageVal= os.getObj('image').files[0]; 
var last_schoolVal= os.getVal('last_school'); 
var last_classVal= os.getVal('last_class'); 
var tc_noVal= os.getVal('tc_no'); 
var tc_dateVal= os.getVal('tc_date'); 
var studentRemarksVal= os.getVal('studentRemarks'); 
var feesPaymentVal= os.getVal('feesPayment'); 
var boardVal= os.getVal('board'); 
var accNoVal= os.getVal('accNo'); 
var accHolderNameVal= os.getVal('accHolderName'); 
var ifscCodeVal= os.getVal('ifscCode'); 
var branchVal= os.getVal('branch'); 
var otpPassVal= os.getVal('otpPass'); 
var applicaton_dateVal= os.getVal('applicaton_date'); 
var class_idVal= os.getVal('class_id'); 
var asessionVal= os.getVal('asession'); 
var last_class_idVal= os.getVal('last_class_id'); 
var last_class_sessionVal= os.getVal('last_class_session'); 
var marks_percentVal= os.getVal('marks_percent'); 
var last_institute_nameVal= os.getVal('last_institute_name'); 
var last_institute_addressVal= os.getVal('last_institute_address'); 


 formdata.append('name',nameVal );
 formdata.append('dob',dobVal );
 formdata.append('age',ageVal );
 formdata.append('gender',genderVal );
 formdata.append('uid',uidVal );
 formdata.append('caste',casteVal );
 formdata.append('subcast',subcastVal );
 formdata.append('apl_bpl',apl_bplVal );
 formdata.append('card_no',card_noVal );
 formdata.append('minority',minorityVal );
 formdata.append('kanyashree',kanyashreeVal );
 formdata.append('yuvashree',yuvashreeVal );
 formdata.append('adhar_name',adhar_nameVal );
 formdata.append('adhar_dob',adhar_dobVal );
 formdata.append('adhar_no',adhar_noVal );
 formdata.append('ph',phVal );
 formdata.append('ph_percent',ph_percentVal );
 formdata.append('disable',disableVal );
 formdata.append('disable_percent',disable_percentVal );
 formdata.append('father_name',father_nameVal );
 formdata.append('father_ocu',father_ocuVal );
 formdata.append('father_adhar',father_adharVal );
 formdata.append('mother_name',mother_nameVal );
 formdata.append('mother_ocu',mother_ocuVal );
 formdata.append('mother_adhar',mother_adharVal );
 formdata.append('vill',villVal );
 formdata.append('po',poVal );
 formdata.append('ps',psVal );
 formdata.append('dist',distVal );
 formdata.append('block',blockVal );
 formdata.append('pin',pinVal );
 formdata.append('state',stateVal );
 formdata.append('guardian_name',guardian_nameVal );
 formdata.append('guardian_relation',guardian_relationVal );
 formdata.append('guardian_address',guardian_addressVal );
 formdata.append('guardian_ocu',guardian_ocuVal );
 formdata.append('anual_income',anual_incomeVal );
 formdata.append('mobile_student',mobile_studentVal );
 formdata.append('mobile_guardian',mobile_guardianVal );
 formdata.append('mobile_emergency',mobile_emergencyVal );
 formdata.append('email_student',email_studentVal );
 formdata.append('email_guardian',email_guardianVal );
 formdata.append('mother_tongue',mother_tongueVal );
 formdata.append('blood_group',blood_groupVal );
 formdata.append('religian',religianVal );
 formdata.append('other_religian',other_religianVal );
if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
 formdata.append('last_school',last_schoolVal );
 formdata.append('last_class',last_classVal );
 formdata.append('tc_no',tc_noVal );
 formdata.append('tc_date',tc_dateVal );
 formdata.append('studentRemarks',studentRemarksVal );
 formdata.append('feesPayment',feesPaymentVal );
 formdata.append('board',boardVal );
 formdata.append('accNo',accNoVal );
 formdata.append('accHolderName',accHolderNameVal );
 formdata.append('ifscCode',ifscCodeVal );
 formdata.append('branch',branchVal );
 formdata.append('otpPass',otpPassVal );
 formdata.append('applicaton_date',applicaton_dateVal );
 formdata.append('class_id',class_idVal );
 formdata.append('asession',asessionVal );
 formdata.append('last_class_id',last_class_idVal );
 formdata.append('last_class_session',last_class_sessionVal );
 formdata.append('marks_percent',marks_percentVal );
 formdata.append('last_institute_name',last_institute_nameVal );
 formdata.append('last_institute_address',last_institute_addressVal );

	
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('dob','Please Add DOB')==false){ return false;} 
//if(os.check.empty('age','Please Add Age')==false){ return false;} 
if(os.check.empty('gender','Please Add Gender')==false){ return false;} 
if(os.check.empty('father_name','Please Add Father_name')==false){ return false;} 
if(os.check.empty('vill','Please Add Street/Vill/Location')==false){ return false;} 
if(os.check.empty('po','Please Add PO')==false){ return false;} 
if(os.check.empty('ps','Please Add Ps')==false){ return false;} 
if(os.check.empty('dist','Please Add Dist')==false){ return false;} 
if(os.check.empty('block','Please Add Block')==false){ return false;} 
if(os.check.empty('pin','Please Add Pin')==false){ return false;} 
if(os.check.empty('state','Please Add State')==false){ return false;} 
if(os.check.empty('class_id','Please Add class_id')==false){ return false;} 
if(os.check.empty('asession','Please Add asession')==false){ return false;} 

	 var   online_form_id=os.getVal('online_form_id');
	 formdata.append('online_form_id',online_form_id );
  	var url='<? echo $ajaxFilePath ?>?WT_online_formEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_online_formReLoadList',url,formdata);

}	

function WT_online_formReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var online_form_id=parseInt(d[0]);
	if(d[0]!='Error' && online_form_id>0)
	{
	  os.setVal('online_form_id',online_form_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_online_formListing();
}

function WT_online_formGetById(online_form_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('online_form_id',online_form_id );
	var url='<? echo $ajaxFilePath ?>?WT_online_formGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_online_formFillData',url,formdata);
	popDialogWH('application_form','Application form','90%','550');			
}

function WT_online_formFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('online_form_id',parseInt(objJSON.online_form_id));
	
 os.setVal('name',objJSON.name); 
 os.setVal('dob',objJSON.dob); 
 os.setVal('age',objJSON.age); 
 os.setVal('gender',objJSON.gender); 
 os.setVal('uid',objJSON.uid); 
 os.setVal('caste',objJSON.caste); 
 os.setVal('subcast',objJSON.subcast); 
 os.setVal('apl_bpl',objJSON.apl_bpl); 
 os.setVal('card_no',objJSON.card_no); 
 os.setVal('minority',objJSON.minority); 
 os.setVal('kanyashree',objJSON.kanyashree); 
 os.setVal('yuvashree',objJSON.yuvashree); 
 os.setVal('adhar_name',objJSON.adhar_name); 
 os.setVal('adhar_dob',objJSON.adhar_dob); 
 os.setVal('adhar_no',objJSON.adhar_no); 
 os.setVal('ph',objJSON.ph); 
 os.setVal('ph_percent',objJSON.ph_percent); 
 os.setVal('disable',objJSON.disable); 
 os.setVal('disable_percent',objJSON.disable_percent); 
 os.setVal('father_name',objJSON.father_name); 
 os.setVal('father_ocu',objJSON.father_ocu); 
 os.setVal('father_adhar',objJSON.father_adhar); 
 os.setVal('mother_name',objJSON.mother_name); 
 os.setVal('mother_ocu',objJSON.mother_ocu); 
 os.setVal('mother_adhar',objJSON.mother_adhar); 
 os.setVal('vill',objJSON.vill); 
 os.setVal('po',objJSON.po); 
 os.setVal('ps',objJSON.ps); 
 os.setVal('dist',objJSON.dist); 
 os.setVal('block',objJSON.block); 
 os.setVal('pin',objJSON.pin); 
 os.setVal('state',objJSON.state); 
 os.setVal('guardian_name',objJSON.guardian_name); 
 os.setVal('guardian_relation',objJSON.guardian_relation); 
 os.setVal('guardian_address',objJSON.guardian_address); 
 os.setVal('guardian_ocu',objJSON.guardian_ocu); 
 os.setVal('anual_income',objJSON.anual_income); 
 os.setVal('mobile_student',objJSON.mobile_student); 
 os.setVal('mobile_guardian',objJSON.mobile_guardian); 
 os.setVal('mobile_emergency',objJSON.mobile_emergency); 
 os.setVal('email_student',objJSON.email_student); 
 os.setVal('email_guardian',objJSON.email_guardian); 
 os.setVal('mother_tongue',objJSON.mother_tongue); 
 os.setVal('blood_group',objJSON.blood_group); 
 os.setVal('religian',objJSON.religian); 
 os.setVal('other_religian',objJSON.other_religian); 
 os.setImg('imagePreview',objJSON.image); 
 os.setVal('last_school',objJSON.last_school); 
 os.setVal('last_class',objJSON.last_class); 
 os.setVal('tc_no',objJSON.tc_no); 
 os.setVal('tc_date',objJSON.tc_date); 
 os.setVal('studentRemarks',objJSON.studentRemarks); 
 os.setVal('feesPayment',objJSON.feesPayment); 
 os.setVal('board',objJSON.board); 
 os.setVal('accNo',objJSON.accNo); 
 os.setVal('accHolderName',objJSON.accHolderName); 
 os.setVal('ifscCode',objJSON.ifscCode); 
 os.setVal('branch',objJSON.branch); 
 os.setVal('otpPass',objJSON.otpPass); 
 os.setVal('applicaton_date',objJSON.applicaton_date); 
 os.setVal('class_id',objJSON.class_id); 
 os.setVal('asession',objJSON.asession); 
 os.setVal('last_class_id',objJSON.last_class_id); 
 os.setVal('last_class_session',objJSON.last_class_session); 
 os.setVal('marks_percent',objJSON.marks_percent); 
 os.setVal('last_institute_name',objJSON.last_institute_name); 
 os.setVal('last_institute_address',objJSON.last_institute_address); 

  
}

function WT_online_formDeleteRowById(online_form_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(online_form_id)<1 || online_form_id==''){  
	var  online_form_id =os.getVal('online_form_id');
	}
	
	if(parseInt(online_form_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('online_form_id',online_form_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_online_formDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_online_formDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_online_formDeleteRowByIdResults(data)
{
	alert(data);
	WT_online_formListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_online_formpagingPageno',parseInt(pageNo));
	WT_online_formListing();
}

	
	
	
	 
	 
</script>
<style>
 
.application_Rejected{ background-color:#FFCACA;}
.application_Approved{ background-color:#B3FFD9;}
.editText{ width:56px; border:1px dotted #CCCCCC; text-align:right;}
.editText_sp{ width:41px; border:1px dotted #CCCCCC; text-align:right;}		
.editText_donation_installment{  width:30px; border:1px dotted #CCCCCC; text-align:right;}						  
</style>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>