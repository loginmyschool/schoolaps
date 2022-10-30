<?
/*
   # wtos version : 1.1
   # main ajax process page : admissionAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List admission';
$ajaxFilePath= 'admissionAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
?>
 <? 

$admissionType= $_GET['admissionType'];
if($admissionType=='')
{
$settype_sVal='';
$headerVal='All Admission List';
}

if($admissionType=='Re')
{
$settype_sVal='Re Admission';
$headerVal='Re Admission List';
}

if($admissionType=='New')
{
$settype_sVal='New Admission';
$headerVal='New Admission List';
}

?>
   

 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $headerVal; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_admissionDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_admissionEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Student Image </td>
										<td>
										
										<img id="imagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>D.o.b </td>
										<td><input value="" type="text" name="dob" id="dob" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Father Name </td>
										<td><input value="" type="text" name="father_name" id="father_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mother Name </td>
										<td><input value="" type="text" name="mother_name" id="mother_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Guardian Name </td>
										<td><input value="" type="text" name="guardian_name" id="guardian_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Vill </td>
										<td><input value="" type="text" name="vill" id="vill" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Pin </td>
										<td><input value="" type="text" name="pin" id="pin" class="textboxxx  fWidth "/> </td>						
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
	  									<td>State </td>
										<td><input value="" type="text" name="state" id="state" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Gender </td>
										<td>  
	
	<select name="gender" id="gender" class="textbox fWidth" ><option value="">Select Gender</option>	<? 
										  $os->onlyOption($os->gender);	?></select>	 </td>						
										</tr><tr >
	  									<td>Caste </td>
										<td>  
	
	<select name="caste" id="caste" class="textbox fWidth" ><option value="">Select Caste</option>	<? 
										  $os->onlyOption($os->caste);	?></select>	 </td>						
										</tr><tr >
	  									<td>Adhar No </td>
										<td><input value="" type="text" name="adhar_no" id="adhar_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Class </td>
										<td>  
	
	<select name="class" id="class" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>Board </td>
										<td>  
	
	<select name="board" id="board" class="textbox fWidth" ><option value="">Select Board</option>	<? 
										  $os->onlyOption($os->board);	?></select>	 </td>						
										</tr><tr >
	  									<td>Acc No </td>
										<td><input value="" type="text" name="accNo" id="accNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Acc Holder Name </td>
										<td><input value="" type="text" name="accHolderName" id="accHolderName" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Ifsc Code </td>
										<td><input value="" type="text" name="ifscCode" id="ifscCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Branch </td>
										<td><input value="" type="text" name="branch" id="branch" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile </td>
										<td><input value="" type="text" name="mobile_student" id="mobile_student" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Student Remarks </td>
										<td><input value="" type="text" name="studentRemarks" id="studentRemarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>apl/bpl </td>
										<td>  
	
	<select name="apl_bpl" id="apl_bpl" class="textbox fWidth" ><option value="">Select</option>	<? 
										  $os->onlyOption($os->aplOrBpl);	?></select>	 </td>						
										</tr><tr >
	  									<td>Admission Type </td>
										<td>  
	
	<select name="admissionType" id="admissionType" class="textbox fWidth" ><option value="">Select Admission Type</option>	<? 
										  $os->onlyOption($os->admissionType,$settype_sVal);	?></select>	 </td>						
										</tr><tr >
	  									<td>Varification Status </td>
										<td>  
	
	<select name="varificationStatus" id="varificationStatus" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->admissionVerificationStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="admissionId" value="0" />	
	<input type="hidden"  id="WT_admissionpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_admissionDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_admissionEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
   Varification Status:
	
	<select name="varificationStatus" id="varificationStatus_s" class="textbox fWidth" ><? 
										  $os->onlyOption($os->admissionVerificationStatus);	?></select>	
	  
	 
  <div style="display:none" id="advanceSearchDiv">
  
    Admission Type:
	
	<select name="admissionType" id="admissionType_s" class="textbox fWidth" ><option value="">Select Admission Type</option>	<? 
										  $os->onlyOption($os->admissionType,$settype_sVal);	?></select>	
         
  Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp; From D.o.b: <input class="wtDateClass" type="text" name="f_dob_s" id="f_dob_s" value=""  /> &nbsp;   To D.o.b: <input class="wtDateClass" type="text" name="t_dob_s" id="t_dob_s" value=""  /> &nbsp;  
   Father Name: <input type="text" class="wtTextClass" name="father_name_s" id="father_name_s" value="" /> &nbsp;  Mother Name: <input type="text" class="wtTextClass" name="mother_name_s" id="mother_name_s" value="" /> &nbsp;  Guardian Name: <input type="text" class="wtTextClass" name="guardian_name_s" id="guardian_name_s" value="" /> &nbsp;  Vill: <input type="text" class="wtTextClass" name="vill_s" id="vill_s" value="" /> &nbsp;  Pin: <input type="text" class="wtTextClass" name="pin_s" id="pin_s" value="" /> &nbsp;  Po: <input type="text" class="wtTextClass" name="po_s" id="po_s" value="" /> &nbsp;  Ps: <input type="text" class="wtTextClass" name="ps_s" id="ps_s" value="" /> &nbsp;  Dist: <input type="text" class="wtTextClass" name="dist_s" id="dist_s" value="" /> &nbsp;  Block: <input type="text" class="wtTextClass" name="block_s" id="block_s" value="" /> &nbsp;  State: <input type="text" class="wtTextClass" name="state_s" id="state_s" value="" /> &nbsp;  Gender:
	
	<select name="gender" id="gender_s" class="textbox fWidth" ><option value="">Select Gender</option>	<? 
										  $os->onlyOption($os->gender);	?></select>	
   Caste:
	
	<select name="caste" id="caste_s" class="textbox fWidth" ><option value="">Select Caste</option>	<? 
										  $os->onlyOption($os->caste);	?></select>	
   Adhar No: <input type="text" class="wtTextClass" name="adhar_no_s" id="adhar_no_s" value="" /> &nbsp;  Class:
	
	<select name="class" id="class_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	
   Board:
	
	<select name="board" id="board_s" class="textbox fWidth" ><option value="">Select Board</option>	<? 
										  $os->onlyOption($os->board);	?></select>	
   Acc No: <input type="text" class="wtTextClass" name="accNo_s" id="accNo_s" value="" /> &nbsp;  Acc Holder Name: <input type="text" class="wtTextClass" name="accHolderName_s" id="accHolderName_s" value="" /> &nbsp;  Ifsc Code: <input type="text" class="wtTextClass" name="ifscCode_s" id="ifscCode_s" value="" /> &nbsp;  Branch: <input type="text" class="wtTextClass" name="branch_s" id="branch_s" value="" /> &nbsp;  Mobile: <input type="text" class="wtTextClass" name="mobile_student_s" id="mobile_student_s" value="" /> &nbsp;  Student Remarks: <input type="text" class="wtTextClass" name="studentRemarks_s" id="studentRemarks_s" value="" /> &nbsp;  apl/bpl:
	
	<select name="apl_bpl" id="apl_bpl_s" class="textbox fWidth" ><option value="">Select apl/bpl</option>	<? 
										  $os->onlyOption($os->aplOrBpl);	?></select>	
 
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_admissionListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_admissionListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_admissionListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var f_dob_sVal= os.getVal('f_dob_s'); 
 var t_dob_sVal= os.getVal('t_dob_s'); 
 var father_name_sVal= os.getVal('father_name_s'); 
 var mother_name_sVal= os.getVal('mother_name_s'); 
 var guardian_name_sVal= os.getVal('guardian_name_s'); 
 var vill_sVal= os.getVal('vill_s'); 
 var pin_sVal= os.getVal('pin_s'); 
 var po_sVal= os.getVal('po_s'); 
 var ps_sVal= os.getVal('ps_s'); 
 var dist_sVal= os.getVal('dist_s'); 
 var block_sVal= os.getVal('block_s'); 
 var state_sVal= os.getVal('state_s'); 
 var gender_sVal= os.getVal('gender_s'); 
 var caste_sVal= os.getVal('caste_s'); 
 var adhar_no_sVal= os.getVal('adhar_no_s'); 
 var class_sVal= os.getVal('class_s'); 
 var board_sVal= os.getVal('board_s'); 
 var accNo_sVal= os.getVal('accNo_s'); 
 var accHolderName_sVal= os.getVal('accHolderName_s'); 
 var ifscCode_sVal= os.getVal('ifscCode_s'); 
 var branch_sVal= os.getVal('branch_s'); 
 var mobile_student_sVal= os.getVal('mobile_student_s'); 
 var studentRemarks_sVal= os.getVal('studentRemarks_s'); 
 var apl_bpl_sVal= os.getVal('apl_bpl_s'); 
 var admissionType_sVal= os.getVal('admissionType_s'); 
 var varificationStatus_sVal= os.getVal('varificationStatus_s'); 
formdata.append('name_s',name_sVal );
formdata.append('f_dob_s',f_dob_sVal );
formdata.append('t_dob_s',t_dob_sVal );
formdata.append('father_name_s',father_name_sVal );
formdata.append('mother_name_s',mother_name_sVal );
formdata.append('guardian_name_s',guardian_name_sVal );
formdata.append('vill_s',vill_sVal );
formdata.append('pin_s',pin_sVal );
formdata.append('po_s',po_sVal );
formdata.append('ps_s',ps_sVal );
formdata.append('dist_s',dist_sVal );
formdata.append('block_s',block_sVal );
formdata.append('state_s',state_sVal );
formdata.append('gender_s',gender_sVal );
formdata.append('caste_s',caste_sVal );
formdata.append('adhar_no_s',adhar_no_sVal );
formdata.append('class_s',class_sVal );
formdata.append('board_s',board_sVal );
formdata.append('accNo_s',accNo_sVal );
formdata.append('accHolderName_s',accHolderName_sVal );
formdata.append('ifscCode_s',ifscCode_sVal );
formdata.append('branch_s',branch_sVal );
formdata.append('mobile_student_s',mobile_student_sVal );
formdata.append('studentRemarks_s',studentRemarks_sVal );
formdata.append('apl_bpl_s',apl_bpl_sVal );
formdata.append('admissionType_s',admissionType_sVal );
formdata.append('varificationStatus_s',varificationStatus_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_admissionpagingPageno=os.getVal('WT_admissionpagingPageno');
	var url='wtpage='+WT_admissionpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_admissionListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_admissionListDiv',url,formdata);
		
}

WT_admissionListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('f_dob_s',''); 
 os.setVal('t_dob_s',''); 
 os.setVal('father_name_s',''); 
 os.setVal('mother_name_s',''); 
 os.setVal('guardian_name_s',''); 
 os.setVal('vill_s',''); 
 os.setVal('pin_s',''); 
 os.setVal('po_s',''); 
 os.setVal('ps_s',''); 
 os.setVal('dist_s',''); 
 os.setVal('block_s',''); 
 os.setVal('state_s',''); 
 os.setVal('gender_s',''); 
 os.setVal('caste_s',''); 
 os.setVal('adhar_no_s',''); 
 os.setVal('class_s',''); 
 os.setVal('board_s',''); 
 os.setVal('accNo_s',''); 
 os.setVal('accHolderName_s',''); 
 os.setVal('ifscCode_s',''); 
 os.setVal('branch_s',''); 
 os.setVal('mobile_student_s',''); 
 os.setVal('studentRemarks_s',''); 
 os.setVal('apl_bpl_s',''); 
 //os.setVal('admissionType_s',''); 
 os.setVal('varificationStatus_s',''); 
	
		os.setVal('searchKey','');
		WT_admissionListing();	
	
	}
	
 
function WT_admissionEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var imageVal= os.getObj('image').files[0]; 
var nameVal= os.getVal('name'); 
var dobVal= os.getVal('dob'); 
var father_nameVal= os.getVal('father_name'); 
var mother_nameVal= os.getVal('mother_name'); 
var guardian_nameVal= os.getVal('guardian_name'); 
var villVal= os.getVal('vill'); 
var pinVal= os.getVal('pin'); 
var poVal= os.getVal('po'); 
var psVal= os.getVal('ps'); 
var distVal= os.getVal('dist'); 
var blockVal= os.getVal('block'); 
var stateVal= os.getVal('state'); 
var genderVal= os.getVal('gender'); 
var casteVal= os.getVal('caste'); 
var adhar_noVal= os.getVal('adhar_no'); 
var classVal= os.getVal('class'); 
var boardVal= os.getVal('board'); 
var accNoVal= os.getVal('accNo'); 
var accHolderNameVal= os.getVal('accHolderName'); 
var ifscCodeVal= os.getVal('ifscCode'); 
var branchVal= os.getVal('branch'); 
var mobile_studentVal= os.getVal('mobile_student'); 
var studentRemarksVal= os.getVal('studentRemarks'); 
var apl_bplVal= os.getVal('apl_bpl'); 
var admissionTypeVal= os.getVal('admissionType'); 
var varificationStatusVal= os.getVal('varificationStatus'); 


if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
 formdata.append('name',nameVal );
 formdata.append('dob',dobVal );
 formdata.append('father_name',father_nameVal );
 formdata.append('mother_name',mother_nameVal );
 formdata.append('guardian_name',guardian_nameVal );
 formdata.append('vill',villVal );
 formdata.append('pin',pinVal );
 formdata.append('po',poVal );
 formdata.append('ps',psVal );
 formdata.append('dist',distVal );
 formdata.append('block',blockVal );
 formdata.append('state',stateVal );
 formdata.append('gender',genderVal );
 formdata.append('caste',casteVal );
 formdata.append('adhar_no',adhar_noVal );
 formdata.append('class',classVal );
 formdata.append('board',boardVal );
 formdata.append('accNo',accNoVal );
 formdata.append('accHolderName',accHolderNameVal );
 formdata.append('ifscCode',ifscCodeVal );
 formdata.append('branch',branchVal );
 formdata.append('mobile_student',mobile_studentVal );
 formdata.append('studentRemarks',studentRemarksVal );
 formdata.append('apl_bpl',apl_bplVal );
 formdata.append('admissionType',admissionTypeVal );
 formdata.append('varificationStatus',varificationStatusVal );

	

	 var   admissionId=os.getVal('admissionId');
	 formdata.append('admissionId',admissionId );
  	var url='<? echo $ajaxFilePath ?>?WT_admissionEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_admissionReLoadList',url,formdata);

}	

function WT_admissionReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var admissionId=parseInt(d[0]);
	if(d[0]!='Error' && admissionId>0)
	{
	  os.setVal('admissionId',admissionId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_admissionListing();
}

function WT_admissionGetById(admissionId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('admissionId',admissionId );
	var url='<? echo $ajaxFilePath ?>?WT_admissionGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_admissionFillData',url,formdata);
				
}

function WT_admissionFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('admissionId',parseInt(objJSON.admissionId));
	
 os.setImg('imagePreview',objJSON.image); 
 os.setVal('name',objJSON.name); 
 os.setVal('dob',objJSON.dob); 
 os.setVal('father_name',objJSON.father_name); 
 os.setVal('mother_name',objJSON.mother_name); 
 os.setVal('guardian_name',objJSON.guardian_name); 
 os.setVal('vill',objJSON.vill); 
 os.setVal('pin',objJSON.pin); 
 os.setVal('po',objJSON.po); 
 os.setVal('ps',objJSON.ps); 
 os.setVal('dist',objJSON.dist); 
 os.setVal('block',objJSON.block); 
 os.setVal('state',objJSON.state); 
 os.setVal('gender',objJSON.gender); 
 os.setVal('caste',objJSON.caste); 
 os.setVal('adhar_no',objJSON.adhar_no); 
 os.setVal('class',objJSON.class); 
 os.setVal('board',objJSON.board); 
 os.setVal('accNo',objJSON.accNo); 
 os.setVal('accHolderName',objJSON.accHolderName); 
 os.setVal('ifscCode',objJSON.ifscCode); 
 os.setVal('branch',objJSON.branch); 
 os.setVal('mobile_student',objJSON.mobile_student); 
 os.setVal('studentRemarks',objJSON.studentRemarks); 
 os.setVal('apl_bpl',objJSON.apl_bpl); 
 os.setVal('admissionType',objJSON.admissionType); 
 os.setVal('varificationStatus',objJSON.varificationStatus); 

  
}

function WT_admissionDeleteRowById(admissionId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(admissionId)<1 || admissionId==''){  
	var  admissionId =os.getVal('admissionId');
	}
	
	if(parseInt(admissionId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('admissionId',admissionId );
	
	var url='<? echo $ajaxFilePath ?>?WT_admissionDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_admissionDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_admissionDeleteRowByIdResults(data)
{
	alert(data);
	WT_admissionListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_admissionpagingPageno',parseInt(pageNo));
	WT_admissionListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>