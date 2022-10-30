<?
/*
   # wtos version : 1.1
   # main ajax process page : studentAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List student';
$ajaxFilePath= 'studentAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
?>
  

 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="350" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?>
	
	
	<!--<input type="button" value="Delete" onclick="WT_studentDeleteRowById('');" />-->
	
	<input type="button" value="Delete" onclick="checkEditDeletePassword('');" />
	
	
	
	<? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_studentEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">


<tr >
	  									<td>Image </td>
										<td>
										
										<img id="imagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr>
										

	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Dob </td>
										<td><input value="" type="text" name="dob" id="dob" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>age </td>
										<td><input value="" type="text" name="age" id="age" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Gender </td>
										<td>  
	
	<select name="gender" id="gender" class="textbox fWidth" ><option value="">Select Gender</option>	<? 
										  $os->onlyOption($os->gender);	?></select>	 </td>						
										</tr><tr >
	  									<td>Register Date </td>
										<td><input value="" type="text" name="registerDate" id="registerDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Register No </td>
										<td><input value="" type="text" name="registerNo" id="registerNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>UID </td>
										<td><input value="" type="text" name="uid" id="uid" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Caste </td>
										<td>  
	
	<select name="caste" id="caste" class="textbox fWidth" ><option value="">Select Caste</option>	<? 
										  $os->onlyOption($os->caste);	?></select>	 </td>						
										</tr><tr >
	  									<td>Subcast </td>
										<td>  
	
	<select name="subcast" id="subcast" class="textbox fWidth" ><option value="">Select Subcast</option>	<? 
										  $os->onlyOption($os->subcast);	?></select>	 </td>						
										</tr><tr >
	  									<td>BPL </td>
										<td>  
	
	<select name="apl_bpl" id="apl_bpl" class="textbox fWidth" ><option value="">Select BPL</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	 </td>						
										</tr><tr >
	  									<td>Minority </td>
										<td>  
	
	<select name="minority" id="minority" class="textbox fWidth" ><option value="">Select Minority</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	 </td>						
										</tr>
										
										
										<tr >
	  									<td>Kanyashree </td>
										<td>  
	<select name="kanyashree" id="kanyashree" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->kanyashree);	?></select>	 </td>						
										</tr>
										
										<tr >
	  									<td>Yuvashree </td>
										<td>  
	<select name="yuvashree" id="yuvashree" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->yuvashree);	?></select>	 </td>						
										</tr>
										
										
										<tr >
	  									<td>Board </td>
										<td>  
	<select name="board" id="board" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->board);	?></select>	 </td>						
										</tr>
										
										
										
										<tr >
	  									<td>Fees Payment </td>
										<td>  
	<select name="feesPayment" id="feesPayment" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->feesPayment);	?></select>	 </td>						
										</tr>
										
										
										
										
										
										
										<tr >
	  									<td>Adhar Name </td>
										<td><input value="" type="text" name="adhar_name" id="adhar_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Adhar Dob </td>
										<td><input value="" type="text" name="adhar_dob" id="adhar_dob" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Adhar No </td>
										<td><input value="" type="text" name="adhar_no" id="adhar_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>PH </td>
										<td>  
	
	<select name="ph" id="ph" class="textbox fWidth" ><option value="">Select PH</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	 </td>						
										</tr><tr >
	  									<td>PH % </td>
										<td><input value="" type="text" name="ph_percent" id="ph_percent" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Disable </td>
										<td>  
	
	<select name="disable" id="disable" class="textbox fWidth" ><option value="">Select Disable</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	 </td>						
										</tr><tr >
	  									<td>Disable % </td>
										<td><input value="" type="text" name="disable_percent" id="disable_percent" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Father Name </td>
										<td><input value="" type="text" name="father_name" id="father_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Father Ocu </td>
										<td><input value="" type="text" name="father_ocu" id="father_ocu" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Father Adhar </td>
										<td><input value="" type="text" name="father_adhar" id="father_adhar" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother Name </td>
										<td><input value="" type="text" name="mother_name" id="mother_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother Ocu </td>
										<td><input value="" type="text" name="mother_ocu" id="mother_ocu" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother Adhar </td>
										<td><input value="" type="text" name="mother_adhar" id="mother_adhar" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Vill </td>
										<td><input value="" type="text" name="vill" id="vill" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Po </td>
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
	  									<td>Guardian Name </td>
										<td><input value="" type="text" name="guardian_name" id="guardian_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Guardian Relation </td>
										<td><input value="" type="text" name="guardian_relation" id="guardian_relation" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Guardian Address </td>
										<td><input value="" type="text" name="guardian_address" id="guardian_address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Guardian Ocu </td>
										<td><input value="" type="text" name="guardian_ocu" id="guardian_ocu" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Anual Income </td>
										<td><input value="" type="text" name="anual_income" id="anual_income" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile Student </td>
										<td><input value="" type="text" name="mobile_student" id="mobile_student" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile Guardian </td>
										<td><input value="" type="text" name="mobile_guardian" id="mobile_guardian" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile Emergency </td>
										<td><input value="" type="text" name="mobile_emergency" id="mobile_emergency" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email Student </td>
										<td><input value="" type="text" name="email_student" id="email_student" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email Guardian </td>
										<td><input value="" type="text" name="email_guardian" id="email_guardian" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother Tongue </td>
										<td><input value="" type="text" name="mother_tongue" id="mother_tongue" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Blood Group </td>
										<td><input value="" type="text" name="blood_group" id="blood_group" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Religian </td>
										<td><input value="" type="text" name="religian" id="religian" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Other Religian </td>
										<td><input value="" type="text" name="other_religian" id="other_religian" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										
										
										
										<tr >
	  									<td>Last School </td>
										<td><input value="" type="text" name="last_school" id="last_school" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Last Class </td>
										<td><input value="" type="text" name="last_class" id="last_class" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Tc No </td>
										<td><input value="" type="text" name="tc_no" id="tc_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Tc Date </td>
										<td><input value="" type="text" name="tc_date" id="tc_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Remarks </td>
										<td><textarea  name="studentRemarks" id="studentRemarks" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="studentId" value="0" />	
	<input type="hidden"  id="WT_studentpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?>
	
	
	<!--<input type="button" value="Delete" onclick="WT_studentDeleteRowById('');" />-->
	<input type="button" value="Delete" onclick="checkEditDeletePassword('');" />



	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_studentEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp; From Dob: <input class="wtDateClass" type="text" name="f_dob_s" id="f_dob_s" value=""  /> &nbsp;   To Dob: <input class="wtDateClass" type="text" name="t_dob_s" id="t_dob_s" value=""  /> &nbsp;  
   age: <input type="text" class="wtTextClass" name="age_s" id="age_s" value="" /> &nbsp;  Gender:
	
	<select name="gender" id="gender_s" class="textbox fWidth" ><option value="">Select Gender</option>	<? 
										  $os->onlyOption($os->gender);	?></select>	
  From Register Date: <input class="wtDateClass" type="text" name="f_registerDate_s" id="f_registerDate_s" value=""  /> &nbsp;   To Register Date: <input class="wtDateClass" type="text" name="t_registerDate_s" id="t_registerDate_s" value=""  /> &nbsp;  
   Register No: <input type="text" class="wtTextClass" name="registerNo_s" id="registerNo_s" value="" /> &nbsp;  UID: <input type="text" class="wtTextClass" name="uid_s" id="uid_s" value="" /> &nbsp;  Caste:
	
	<select name="caste" id="caste_s" class="textbox fWidth" ><option value="">Select Caste</option>	<? 
										  $os->onlyOption($os->caste);	?></select>	
   Subcast:
	
	<select name="subcast" id="subcast_s" class="textbox fWidth" ><option value="">Select Subcast</option>	<? 
										  $os->onlyOption($os->subcast);	?></select>	
   BPL:
	
	<select name="apl_bpl" id="apl_bpl_s" class="textbox fWidth" ><option value="">Select BPL</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	
   Minority:
	
	<select name="minority" id="minority_s" class="textbox fWidth" ><option value="">Select Minority</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	
   Adhar Name: <input type="text" class="wtTextClass" name="adhar_name_s" id="adhar_name_s" value="" /> &nbsp; From Adhar Dob: <input class="wtDateClass" type="text" name="f_adhar_dob_s" id="f_adhar_dob_s" value=""  /> &nbsp;   To Adhar Dob: <input class="wtDateClass" type="text" name="t_adhar_dob_s" id="t_adhar_dob_s" value=""  /> &nbsp;  
   Adhar No: <input type="text" class="wtTextClass" name="adhar_no_s" id="adhar_no_s" value="" /> &nbsp;  PH:
	
	<select name="ph" id="ph_s" class="textbox fWidth" ><option value="">Select PH</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	
   PH %: <input type="text" class="wtTextClass" name="ph_percent_s" id="ph_percent_s" value="" /> &nbsp;  Disable:
	
	<select name="disable" id="disable_s" class="textbox fWidth" ><option value="">Select Disable</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	
   Disable %: <input type="text" class="wtTextClass" name="disable_percent_s" id="disable_percent_s" value="" /> &nbsp;  Father Name: <input type="text" class="wtTextClass" name="father_name_s" id="father_name_s" value="" /> &nbsp;  Father Ocu: <input type="text" class="wtTextClass" name="father_ocu_s" id="father_ocu_s" value="" /> &nbsp;  Father Adhar: <input type="text" class="wtTextClass" name="father_adhar_s" id="father_adhar_s" value="" /> &nbsp;  Mother Name: <input type="text" class="wtTextClass" name="mother_name_s" id="mother_name_s" value="" /> &nbsp;  Mother Ocu: <input type="text" class="wtTextClass" name="mother_ocu_s" id="mother_ocu_s" value="" /> &nbsp;  Mother Adhar: <input type="text" class="wtTextClass" name="mother_adhar_s" id="mother_adhar_s" value="" /> &nbsp;  Vill: <input type="text" class="wtTextClass" name="vill_s" id="vill_s" value="" /> &nbsp;  Po: <input type="text" class="wtTextClass" name="po_s" id="po_s" value="" /> &nbsp;  Ps: <input type="text" class="wtTextClass" name="ps_s" id="ps_s" value="" /> &nbsp;  Dist: <input type="text" class="wtTextClass" name="dist_s" id="dist_s" value="" /> &nbsp;  Block: <input type="text" class="wtTextClass" name="block_s" id="block_s" value="" /> &nbsp;  Pin: <input type="text" class="wtTextClass" name="pin_s" id="pin_s" value="" /> &nbsp;  State: <input type="text" class="wtTextClass" name="state_s" id="state_s" value="" /> &nbsp;  Guardian Name: <input type="text" class="wtTextClass" name="guardian_name_s" id="guardian_name_s" value="" /> &nbsp;  Guardian Relation: <input type="text" class="wtTextClass" name="guardian_relation_s" id="guardian_relation_s" value="" /> &nbsp;  Guardian Address: <input type="text" class="wtTextClass" name="guardian_address_s" id="guardian_address_s" value="" /> &nbsp;  Guardian Ocu: <input type="text" class="wtTextClass" name="guardian_ocu_s" id="guardian_ocu_s" value="" /> &nbsp;  Anual Income: <input type="text" class="wtTextClass" name="anual_income_s" id="anual_income_s" value="" /> &nbsp;  Mobile Student: <input type="text" class="wtTextClass" name="mobile_student_s" id="mobile_student_s" value="" /> &nbsp;  Mobile Guardian: <input type="text" class="wtTextClass" name="mobile_guardian_s" id="mobile_guardian_s" value="" /> &nbsp;  Mobile Emergency: <input type="text" class="wtTextClass" name="mobile_emergency_s" id="mobile_emergency_s" value="" /> &nbsp;  Email Student: <input type="text" class="wtTextClass" name="email_student_s" id="email_student_s" value="" /> &nbsp;  Email Guardian: <input type="text" class="wtTextClass" name="email_guardian_s" id="email_guardian_s" value="" /> &nbsp;  Mother Tongue: <input type="text" class="wtTextClass" name="mother_tongue_s" id="mother_tongue_s" value="" /> &nbsp;  Blood Group: <input type="text" class="wtTextClass" name="blood_group_s" id="blood_group_s" value="" /> &nbsp;  Religian: <input type="text" class="wtTextClass" name="religian_s" id="religian_s" value="" /> &nbsp;  Other Religian: <input type="text" class="wtTextClass" name="other_religian_s" id="other_religian_s" value="" /> &nbsp;   Last School: <input type="text" class="wtTextClass" name="last_school_s" id="last_school_s" value="" /> &nbsp;  Last Class: <input type="text" class="wtTextClass" name="last_class_s" id="last_class_s" value="" /> &nbsp;  Tc No: <input type="text" class="wtTextClass" name="tc_no_s" id="tc_no_s" value="" /> &nbsp; From Tc Date: <input class="wtDateClass" type="text" name="f_tc_date_s" id="f_tc_date_s" value=""  /> &nbsp;   To Tc Date: <input class="wtDateClass" type="text" name="t_tc_date_s" id="t_tc_date_s" value=""  /> &nbsp;  
   Remarks: <input type="text" class="wtTextClass" name="studentRemarks_s" id="studentRemarks_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_studentListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_studentListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_studentListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var f_dob_sVal= os.getVal('f_dob_s'); 
 var t_dob_sVal= os.getVal('t_dob_s'); 
 var age_sVal= os.getVal('age_s'); 
 var gender_sVal= os.getVal('gender_s'); 
 var f_registerDate_sVal= os.getVal('f_registerDate_s'); 
 var t_registerDate_sVal= os.getVal('t_registerDate_s'); 
 var registerNo_sVal= os.getVal('registerNo_s'); 
 var uid_sVal= os.getVal('uid_s'); 
 var caste_sVal= os.getVal('caste_s'); 
 var subcast_sVal= os.getVal('subcast_s'); 
 var apl_bpl_sVal= os.getVal('apl_bpl_s'); 
 var minority_sVal= os.getVal('minority_s'); 
 var adhar_name_sVal= os.getVal('adhar_name_s'); 
 var f_adhar_dob_sVal= os.getVal('f_adhar_dob_s'); 
 var t_adhar_dob_sVal= os.getVal('t_adhar_dob_s'); 
 var adhar_no_sVal= os.getVal('adhar_no_s'); 
 var ph_sVal= os.getVal('ph_s'); 
 var ph_percent_sVal= os.getVal('ph_percent_s'); 
 var disable_sVal= os.getVal('disable_s'); 
 var disable_percent_sVal= os.getVal('disable_percent_s'); 
 var father_name_sVal= os.getVal('father_name_s'); 
 var father_ocu_sVal= os.getVal('father_ocu_s'); 
 var father_adhar_sVal= os.getVal('father_adhar_s'); 
 var mother_name_sVal= os.getVal('mother_name_s'); 
 var mother_ocu_sVal= os.getVal('mother_ocu_s'); 
 var mother_adhar_sVal= os.getVal('mother_adhar_s'); 
 var vill_sVal= os.getVal('vill_s'); 
 var po_sVal= os.getVal('po_s'); 
 var ps_sVal= os.getVal('ps_s'); 
 var dist_sVal= os.getVal('dist_s'); 
 var block_sVal= os.getVal('block_s'); 
 var pin_sVal= os.getVal('pin_s'); 
 var state_sVal= os.getVal('state_s'); 
 var guardian_name_sVal= os.getVal('guardian_name_s'); 
 var guardian_relation_sVal= os.getVal('guardian_relation_s'); 
 var guardian_address_sVal= os.getVal('guardian_address_s'); 
 var guardian_ocu_sVal= os.getVal('guardian_ocu_s'); 
 var anual_income_sVal= os.getVal('anual_income_s'); 
 var mobile_student_sVal= os.getVal('mobile_student_s'); 
 var mobile_guardian_sVal= os.getVal('mobile_guardian_s'); 
 var mobile_emergency_sVal= os.getVal('mobile_emergency_s'); 
 var email_student_sVal= os.getVal('email_student_s'); 
 var email_guardian_sVal= os.getVal('email_guardian_s'); 
 var mother_tongue_sVal= os.getVal('mother_tongue_s'); 
 var blood_group_sVal= os.getVal('blood_group_s'); 
 var religian_sVal= os.getVal('religian_s'); 
 var other_religian_sVal= os.getVal('other_religian_s'); 
 var last_school_sVal= os.getVal('last_school_s'); 
 var last_class_sVal= os.getVal('last_class_s'); 
 var tc_no_sVal= os.getVal('tc_no_s'); 
 var f_tc_date_sVal= os.getVal('f_tc_date_s'); 
 var t_tc_date_sVal= os.getVal('t_tc_date_s'); 
 var studentRemarks_sVal= os.getVal('studentRemarks_s'); 
formdata.append('name_s',name_sVal );
formdata.append('f_dob_s',f_dob_sVal );
formdata.append('t_dob_s',t_dob_sVal );
formdata.append('age_s',age_sVal );
formdata.append('gender_s',gender_sVal );
formdata.append('f_registerDate_s',f_registerDate_sVal );
formdata.append('t_registerDate_s',t_registerDate_sVal );
formdata.append('registerNo_s',registerNo_sVal );
formdata.append('uid_s',uid_sVal );
formdata.append('caste_s',caste_sVal );
formdata.append('subcast_s',subcast_sVal );
formdata.append('apl_bpl_s',apl_bpl_sVal );
formdata.append('minority_s',minority_sVal );
formdata.append('adhar_name_s',adhar_name_sVal );
formdata.append('f_adhar_dob_s',f_adhar_dob_sVal );
formdata.append('t_adhar_dob_s',t_adhar_dob_sVal );
formdata.append('adhar_no_s',adhar_no_sVal );
formdata.append('ph_s',ph_sVal );
formdata.append('ph_percent_s',ph_percent_sVal );
formdata.append('disable_s',disable_sVal );
formdata.append('disable_percent_s',disable_percent_sVal );
formdata.append('father_name_s',father_name_sVal );
formdata.append('father_ocu_s',father_ocu_sVal );
formdata.append('father_adhar_s',father_adhar_sVal );
formdata.append('mother_name_s',mother_name_sVal );
formdata.append('mother_ocu_s',mother_ocu_sVal );
formdata.append('mother_adhar_s',mother_adhar_sVal );
formdata.append('vill_s',vill_sVal );
formdata.append('po_s',po_sVal );
formdata.append('ps_s',ps_sVal );
formdata.append('dist_s',dist_sVal );
formdata.append('block_s',block_sVal );
formdata.append('pin_s',pin_sVal );
formdata.append('state_s',state_sVal );
formdata.append('guardian_name_s',guardian_name_sVal );
formdata.append('guardian_relation_s',guardian_relation_sVal );
formdata.append('guardian_address_s',guardian_address_sVal );
formdata.append('guardian_ocu_s',guardian_ocu_sVal );
formdata.append('anual_income_s',anual_income_sVal );
formdata.append('mobile_student_s',mobile_student_sVal );
formdata.append('mobile_guardian_s',mobile_guardian_sVal );
formdata.append('mobile_emergency_s',mobile_emergency_sVal );
formdata.append('email_student_s',email_student_sVal );
formdata.append('email_guardian_s',email_guardian_sVal );
formdata.append('mother_tongue_s',mother_tongue_sVal );
formdata.append('blood_group_s',blood_group_sVal );
formdata.append('religian_s',religian_sVal );
formdata.append('other_religian_s',other_religian_sVal );
formdata.append('last_school_s',last_school_sVal );
formdata.append('last_class_s',last_class_sVal );
formdata.append('tc_no_s',tc_no_sVal );
formdata.append('f_tc_date_s',f_tc_date_sVal );
formdata.append('t_tc_date_s',t_tc_date_sVal );
formdata.append('studentRemarks_s',studentRemarks_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_studentpagingPageno=os.getVal('WT_studentpagingPageno');
	var url='wtpage='+WT_studentpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_studentListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_studentListDiv',url,formdata);
		
}

WT_studentListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('f_dob_s',''); 
 os.setVal('t_dob_s',''); 
 os.setVal('age_s',''); 
 os.setVal('gender_s',''); 
 os.setVal('f_registerDate_s',''); 
 os.setVal('t_registerDate_s',''); 
 os.setVal('registerNo_s',''); 
 os.setVal('uid_s',''); 
 os.setVal('caste_s',''); 
 os.setVal('subcast_s',''); 
 os.setVal('apl_bpl_s',''); 
 os.setVal('minority_s',''); 
 os.setVal('adhar_name_s',''); 
 os.setVal('f_adhar_dob_s',''); 
 os.setVal('t_adhar_dob_s',''); 
 os.setVal('adhar_no_s',''); 
 os.setVal('ph_s',''); 
 os.setVal('ph_percent_s',''); 
 os.setVal('disable_s',''); 
 os.setVal('disable_percent_s',''); 
 os.setVal('father_name_s',''); 
 os.setVal('father_ocu_s',''); 
 os.setVal('father_adhar_s',''); 
 os.setVal('mother_name_s',''); 
 os.setVal('mother_ocu_s',''); 
 os.setVal('mother_adhar_s',''); 
 os.setVal('vill_s',''); 
 os.setVal('po_s',''); 
 os.setVal('ps_s',''); 
 os.setVal('dist_s',''); 
 os.setVal('block_s',''); 
 os.setVal('pin_s',''); 
 os.setVal('state_s',''); 
 os.setVal('guardian_name_s',''); 
 os.setVal('guardian_relation_s',''); 
 os.setVal('guardian_address_s',''); 
 os.setVal('guardian_ocu_s',''); 
 os.setVal('anual_income_s',''); 
 os.setVal('mobile_student_s',''); 
 os.setVal('mobile_guardian_s',''); 
 os.setVal('mobile_emergency_s',''); 
 os.setVal('email_student_s',''); 
 os.setVal('email_guardian_s',''); 
 os.setVal('mother_tongue_s',''); 
 os.setVal('blood_group_s',''); 
 os.setVal('religian_s',''); 
 os.setVal('other_religian_s',''); 
 os.setVal('last_school_s',''); 
 os.setVal('last_class_s',''); 
 os.setVal('tc_no_s',''); 
 os.setVal('f_tc_date_s',''); 
 os.setVal('t_tc_date_s',''); 
 os.setVal('studentRemarks_s',''); 
	
		os.setVal('searchKey','');
		WT_studentListing();	
	
	}
	
 
function WT_studentEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	
	
	

	 var   studentId=os.getVal('studentId');
	 
	 if(studentId==0)
	 {
		 alert('You cant add data from this page');
		 return false;
	 }
	 
	
	
	
	var kanyashreeVal= os.getVal('kanyashree'); 
	var yuvashreeVal= os.getVal('yuvashree'); 
	var nameVal= os.getVal('name'); 
var dobVal= os.getVal('dob'); 
var ageVal= os.getVal('age'); 
var genderVal= os.getVal('gender'); 
var registerDateVal= os.getVal('registerDate'); 
var registerNoVal= os.getVal('registerNo'); 
var uidVal= os.getVal('uid'); 
var casteVal= os.getVal('caste'); 
var subcastVal= os.getVal('subcast'); 
var apl_bplVal= os.getVal('apl_bpl'); 
var minorityVal= os.getVal('minority'); 
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


var boardVal= os.getVal('board'); 
	var feesPaymentVal= os.getVal('feesPayment'); 

formdata.append('kanyashree',kanyashreeVal );
  formdata.append('yuvashree',yuvashreeVal );
   formdata.append('board',boardVal );
  formdata.append('feesPayment',feesPaymentVal );
  
  
 formdata.append('name',nameVal );
 formdata.append('dob',dobVal );
 formdata.append('age',ageVal );
 formdata.append('gender',genderVal );
 formdata.append('registerDate',registerDateVal );
 formdata.append('registerNo',registerNoVal );
 formdata.append('uid',uidVal );
 formdata.append('caste',casteVal );
 formdata.append('subcast',subcastVal );
 formdata.append('apl_bpl',apl_bplVal );
 formdata.append('minority',minorityVal );
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

	
	
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('dob','Please Add D.O.B')==false){ return false;} 
	
	
	
	 
	 
	 
	 
	 
	 formdata.append('studentId',studentId );
  	var url='<? echo $ajaxFilePath ?>?WT_studentEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_studentReLoadList',url,formdata);

}	

function WT_studentReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var studentId=parseInt(d[0]);
	if(d[0]!='Error' && studentId>0)
	{
	  os.setVal('studentId',studentId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_studentListing();
}

function WT_studentGetById(studentId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('studentId',studentId );
	var url='<? echo $ajaxFilePath ?>?WT_studentGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_studentFillData',url,formdata);
				
}

function WT_studentFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('studentId',parseInt(objJSON.studentId));
	 os.setVal('kanyashree',objJSON.kanyashree);
	  os.setVal('yuvashree',objJSON.yuvashree);
 os.setVal('name',objJSON.name);
 os.setVal('dob',objJSON.dob); 
   os.setVal('board',objJSON.board);
	  os.setVal('feesPayment',objJSON.feesPayment);
 os.setVal('age',objJSON.age); 
 os.setVal('gender',objJSON.gender); 
 os.setVal('registerDate',objJSON.registerDate); 
 os.setVal('registerNo',objJSON.registerNo); 
 os.setVal('uid',objJSON.uid); 
 os.setVal('caste',objJSON.caste); 
 os.setVal('subcast',objJSON.subcast); 
 os.setVal('apl_bpl',objJSON.apl_bpl); 
 os.setVal('minority',objJSON.minority); 
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

  
}







function checkEditDeletePassword()
{
	
	var password= prompt("Please Enter Delete Password");
	if(password)
	{
		var formdata = new FormData();	
     var  studentId =os.getVal('studentId');		
	formdata.append('studentId',studentId );
	formdata.append('password',password );
	
	var url='<? echo $ajaxFilePath ?>?checkEditDeletePassword=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('checkEditDeletePasswordResult',url,formdata);
	
	}

}


function checkEditDeletePasswordResult(data)
{
	if(data=='wrong password')
	{
		alert(data);
	}
	else
	{
		var d=data.split('#-#');
		var studentId=parseInt(d[1]);
		WT_studentDeleteRowById(studentId);
		
	}
	
}



function WT_studentDeleteRowById(studentId) // delete record by table id
{
	
	//alert(studentId);
	var formdata = new FormData();	 
	if(parseInt(studentId)<1 || studentId==''){  
	var  studentId =os.getVal('studentId');
	}
	
	if(parseInt(studentId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('studentId',studentId );
	
	var url='<? echo $ajaxFilePath ?>?WT_studentDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_studentDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_studentDeleteRowByIdResults(data)
{
	alert(data);
	WT_studentListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_studentpagingPageno',parseInt(pageNo));
	WT_studentListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>