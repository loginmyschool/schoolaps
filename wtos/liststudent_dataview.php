<?
/*
   # wtos version : 1.1
   # main ajax process page : liststudent_ajax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List student';
$ajaxFilePath= 'liststudent_ajax.php';
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
    <td width="770" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton" style="display:none;">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_studentDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_studentEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>DOB </td>
										<td><input value="" type="text" name="dob" id="dob" class="wtDateClass textbox fWidth"/></td>						
										</tr>
										
										
										<tr >
	  									<td>Age </td>
										<td><input value="" type="text" name="age" id="age" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Gender </td>
										<td><input value="" type="text" name="gender" id="gender" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Registration Date </td>
										<td><input value="" type="text" name="registerDate" id="registerDate" class="wtDateClass textbox fWidth"/></td>						
										 
	  									<td>Registration No </td>
										<td><input value="" type="text" name="registerNo" id="registerNo" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Caste </td>
										<td><input value="" type="text" name="caste" id="caste" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>BPL/APL (Y/N) </td>
										<td><input value="" type="text" name="apl_bpl" id="apl_bpl" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>BPL/APL card No </td>
										<td><input value="" type="text" name="card_no" id="card_no" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Minority (Y/N)</td>
										<td><input value="" type="text" name="minority" id="minority" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Kanyashree (Y/N) </td>
										<td><input value="" type="text" name="kanyashree" id="kanyashree" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Yuvashree (Y/N)</td>
										<td><input value="" type="text" name="yuvashree" id="yuvashree" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Adhar Name </td>
										<td><input value="" type="text" name="adhar_name" id="adhar_name" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Adhar Dob </td>
										<td><input value="" type="text" name="adhar_dob" id="adhar_dob" class="wtDateClass textbox fWidth"/></td>						
										</tr>
										
										<tr >
	  									<td>Adhar_No </td>
										<td><input value="" type="text" name="adhar_no" id="adhar_no" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>PH (Y/N)</td>
										<td><input value="" type="text" name="ph" id="ph" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>PH Percent </td>
										<td><input value="" type="text" name="ph_percent" id="ph_percent" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Father Name </td>
										<td><input value="" type="text" name="father_name" id="father_name" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Father Ocu </td>
										<td><input value="" type="text" name="father_ocu" id="father_ocu" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Father Adhar </td>
										<td><input value="" type="text" name="father_adhar" id="father_adhar" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Mother Name </td>
										<td><input value="" type="text" name="mother_name" id="mother_name" class="textboxxx  fWidth "/> </td>						
									 
	  									<td>Mother Ocu </td>
										<td><input value="" type="text" name="mother_ocu" id="mother_ocu" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Mother Adhar </td>
										<td><input value="" type="text" name="mother_adhar" id="mother_adhar" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Vill </td>
										<td><input value="" type="text" name="vill" id="vill" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>PO </td>
										<td><input value="" type="text" name="po" id="po" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>PS </td>
										<td><input value="" type="text" name="ps" id="ps" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>DIST </td>
										<td><input value="" type="text" name="dist" id="dist" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>BLOCK </td>
										<td><input value="" type="text" name="block" id="block" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										<tr >
	  									<td>PIN </td>
										<td><input value="" type="text" name="pin" id="pin" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>STATE </td>
										<td><input value="" type="text" name="state" id="state" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Guardian_name </td>
										<td><input value="" type="text" name="guardian_name" id="guardian_name" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Guardian_relation </td>
										<td><input value="" type="text" name="guardian_relation" id="guardian_relation" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										<tr >
	  									<td>Guardian_address </td>
										<td><input value="" type="text" name="guardian_address" id="guardian_address" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Guardian_ocu </td>
										<td><input value="" type="text" name="guardian_ocu" id="guardian_ocu" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Anual_income </td>
										<td><input value="" type="text" name="anual_income" id="anual_income" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Student Mobile </td>
										<td><input value="" type="text" name="mobile_student" id="mobile_student" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Guardian Mobile </td>
										<td><input value="" type="text" name="mobile_guardian" id="mobile_guardian" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Mobile Emergency </td>
										<td><input value="" type="text" name="mobile_emergency" id="mobile_emergency" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Email Student </td>
										<td><input value="" type="text" name="email_student" id="email_student" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Email Guardian </td>
										<td><input value="" type="text" name="email_guardian" id="email_guardian" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Mother Tongue </td>
										<td><input value="" type="text" name="mother_tongue" id="mother_tongue" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>BLOOD GROUP </td>
										<td><input value="" type="text" name="blood_group" id="blood_group" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>EYE Power </td>
										<td><input value="" type="text" name="eye_power" id="eye_power" class="textboxxx  fWidth "/> </td>						
										
										
	  									<td>Psychiatric Report </td>
										<td><input value="" type="text" name="psychiatric_report" id="psychiatric_report" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										<tr >
	  									<td>Religian </td>
										<td><input value="" type="text" name="religian" id="religian" class="textboxxx  fWidth "/> </td>						
										
										
	  									<td>Other Religian </td>
										<td><input value="" type="text" name="other_religian" id="other_religian" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>PHOTO </td>
										<td><input value="" type="text" name="image" id="image" class="textboxxx  fWidth "/> </td>						
										
										
	  									<td>Last School </td>
										<td><input value="" type="text" name="last_school" id="last_school" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Last Class </td>
										<td><input value="" type="text" name="last_class" id="last_class" class="textboxxx  fWidth "/> </td>						
										
										
	  									<td>TC No </td>
										<td><input value="" type="text" name="tc_no" id="tc_no" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>TC Date </td>
										<td><input value="" type="text" name="tc_date" id="tc_date" class="wtDateClass textbox fWidth"/></td>						
										 
	  									<td>Remarks </td>
										<td><input value="" type="text" name="studentRemarks" id="studentRemarks" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>FEES Type </td>
										<td><input value="" type="text" name="feesPayment" id="feesPayment" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Board </td>
										<td><input value="" type="text" name="board" id="board" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										<tr >
	  									<td>Bank ACC No </td>
										<td><input value="" type="text" name="accNo" id="accNo" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Acc Holder Name </td>
										<td><input value="" type="text" name="accHolderName" id="accHolderName" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										<tr >
	  									<td>IFSC Code </td>
										<td><input value="" type="text" name="ifscCode" id="ifscCode" class="textboxxx  fWidth "/> </td>						
										 
	  									<td>Branch </td>
										<td><input value="" type="text" name="branch" id="branch" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Password </td>
										<td colspan="10"><input value="" type="text" name="otpPass" id="otpPass" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="studentId" value="0" />	
	<input type="hidden"  id="WT_studentpagingPageno" value="1" />	
	<div class="formDivButton" style="display:none;">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_studentDeleteRowById('');" />	<? } ?>	  
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
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Registration No: <input type="text" class="wtTextClass" name="registerNo_s" id="registerNo_s" value="" /> &nbsp;  
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
 var registerNo_sVal= os.getVal('registerNo_s'); 
formdata.append('name_s',name_sVal );
formdata.append('registerNo_s',registerNo_sVal );

	
	 
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
 os.setVal('registerNo_s',''); 
	
		os.setVal('searchKey','');
		WT_studentListing();	
	
	}
	
 
function WT_studentEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var dobVal= os.getVal('dob'); 
var ageVal= os.getVal('age'); 
var genderVal= os.getVal('gender'); 
var registerDateVal= os.getVal('registerDate'); 
var registerNoVal= os.getVal('registerNo'); 
var casteVal= os.getVal('caste'); 
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
var eye_powerVal= os.getVal('eye_power'); 
var psychiatric_reportVal= os.getVal('psychiatric_report'); 
var religianVal= os.getVal('religian'); 
var other_religianVal= os.getVal('other_religian'); 
var imageVal= os.getVal('image'); 
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


 formdata.append('name',nameVal );
 formdata.append('dob',dobVal );
 formdata.append('age',ageVal );
 formdata.append('gender',genderVal );
 formdata.append('registerDate',registerDateVal );
 formdata.append('registerNo',registerNoVal );
 formdata.append('caste',casteVal );
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
 formdata.append('eye_power',eye_powerVal );
 formdata.append('psychiatric_report',psychiatric_reportVal );
 formdata.append('religian',religianVal );
 formdata.append('other_religian',other_religianVal );
 formdata.append('image',imageVal );
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

	

	 var   studentId=os.getVal('studentId');
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
	
 os.setVal('name',objJSON.name); 
 os.setVal('dob',objJSON.dob); 
 os.setVal('age',objJSON.age); 
 os.setVal('gender',objJSON.gender); 
 os.setVal('registerDate',objJSON.registerDate); 
 os.setVal('registerNo',objJSON.registerNo); 
 os.setVal('caste',objJSON.caste); 
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
 os.setVal('eye_power',objJSON.eye_power); 
 os.setVal('psychiatric_report',objJSON.psychiatric_report); 
 os.setVal('religian',objJSON.religian); 
 os.setVal('other_religian',objJSON.other_religian); 
 os.setVal('image',objJSON.image); 
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

  
}

function WT_studentDeleteRowById(studentId) // delete record by table id
{
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