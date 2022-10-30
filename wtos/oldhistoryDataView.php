<?
/*
   # wtos version : 1.1
   # main ajax process page : historyAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List history';
$ajaxFilePath= 'oldhistoryAjax.php';
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
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_historyDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_historyEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
	 
	 	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Dob </td>
										<td><input value="" type="text" name="dob" id="dob" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>age </td>
										<td><input value="" type="text" name="age" id="age" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Gender </td>
										<td>  
	
	<select name="gender" id="gender" class="textbox fWidth" ><option value="">Select Gender</option>	<? 
										  $os->onlyOption($os->gender);	?></select>	 </td>						
										</tr>
	 
	 
<tr >



	  									<td>Session </td>
										<td>  
	
	<select name="asession" id="asession" class="textbox fWidth" ><option value="">Select Session</option>	<? 
										  $os->onlyOption($os->asession);	?></select>	 </td>						
										</tr><tr >
	  									<td>RegistrationNo </td>
										<td><input value="" type="text" name="registrationNo" id="registrationNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Class </td>
										<td>  
	
	<select name="class" id="class" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>Section </td>
										<td>  
	
	<select name="section" id="section" class="textbox fWidth" ><option value="">Select Section</option>	<? 
										  $os->onlyOption($os->section);	?></select>	 </td>						
										</tr><tr >
	  									<td>Admission no </td>
										<td><input value="" type="text" name="admission_no" id="admission_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Admission date </td>
										<td><input value="" type="text" name="admission_date" id="admission_date" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Roll no </td>
										<td><input value="" type="text" name="roll_no" id="roll_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>StudentId </td>
										<td> <select name="studentId" id="studentId" class="textbox fWidth" ><option value="">Select StudentId</option>		  	<? 
								
										  $os->optionsHTML('','StudentId','name','Student');?>
							</select> </td>						
										</tr><tr >
	  									<td>Full marks </td>
										<td><input value="" type="text" name="full_marks" id="full_marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Obtain marks </td>
										<td><input value="" type="text" name="obtain_marks" id="obtain_marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Percentage </td>
										<td><input value="" type="text" name="percentage" id="percentage" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Pass_fail </td>
										<td>  
	
	<select name="pass_fail" id="pass_fail" class="textbox fWidth" ><option value="">Select Pass_fail</option>	<? 
										  $os->onlyOption($os->pass_fail);	?></select>	 </td>						
										</tr><tr >
	  									<td>Grade </td>
										<td><input value="" type="text" name="grade" id="grade" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Remarks </td>
										<td><input value="" type="text" name="remarks" id="remarks" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="historyId" value="0" />	
	<input type="hidden"  id="WT_historypagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_historyDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_historyEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Session:
	
	<select name="asession" id="asession_s" class="textbox fWidth" ><option value="">Select Session</option>	<? 
										  $os->onlyOption($os->asession);	?></select>	
   RegistrationNo: <input type="text" class="wtTextClass" name="registrationNo_s" id="registrationNo_s" value="" /> &nbsp;  Class:
	
	<select name="class" id="class_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	
   Section:
	
	<select name="section" id="section_s" class="textbox fWidth" ><option value="">Select Section</option>	<? 
										  $os->onlyOption($os->section);	?></select>	
   Admission no: <input type="text" class="wtTextClass" name="admission_no_s" id="admission_no_s" value="" /> &nbsp;  Admission date: <input type="text" class="wtTextClass" name="admission_date_s" id="admission_date_s" value="" /> &nbsp;  Roll no: <input type="text" class="wtTextClass" name="roll_no_s" id="roll_no_s" value="" /> &nbsp;  StudentId:
	
	
	<select name="studentId" id="studentId_s" class="textbox fWidth" ><option value="">Select StudentId</option>		  	<? 
								
										  $os->optionsHTML('','StudentId','name','Student');?>
							</select>
   Full marks: <input type="text" class="wtTextClass" name="full_marks_s" id="full_marks_s" value="" /> &nbsp;  Obtain marks: <input type="text" class="wtTextClass" name="obtain_marks_s" id="obtain_marks_s" value="" /> &nbsp;  Percentage: <input type="text" class="wtTextClass" name="percentage_s" id="percentage_s" value="" /> &nbsp;  Pass_fail:
	
	<select name="pass_fail" id="pass_fail_s" class="textbox fWidth" ><option value="">Select Pass_fail</option>	<? 
										  $os->onlyOption($os->pass_fail);	?></select>	
   Grade: <input type="text" class="wtTextClass" name="grade_s" id="grade_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_historyListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_historyListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_historyListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var asession_sVal= os.getVal('asession_s'); 
 var registrationNo_sVal= os.getVal('registrationNo_s'); 
 var class_sVal= os.getVal('class_s'); 
 var section_sVal= os.getVal('section_s'); 
 var admission_no_sVal= os.getVal('admission_no_s'); 
 var admission_date_sVal= os.getVal('admission_date_s'); 
 var roll_no_sVal= os.getVal('roll_no_s'); 
 var studentId_sVal= os.getVal('studentId_s'); 
 var full_marks_sVal= os.getVal('full_marks_s'); 
 var obtain_marks_sVal= os.getVal('obtain_marks_s'); 
 var percentage_sVal= os.getVal('percentage_s'); 
 var pass_fail_sVal= os.getVal('pass_fail_s'); 
 var grade_sVal= os.getVal('grade_s'); 
 var remarks_sVal= os.getVal('remarks_s'); 
formdata.append('asession_s',asession_sVal );
formdata.append('registrationNo_s',registrationNo_sVal );
formdata.append('class_s',class_sVal );
formdata.append('section_s',section_sVal );
formdata.append('admission_no_s',admission_no_sVal );
formdata.append('admission_date_s',admission_date_sVal );
formdata.append('roll_no_s',roll_no_sVal );
formdata.append('studentId_s',studentId_sVal );
formdata.append('full_marks_s',full_marks_sVal );
formdata.append('obtain_marks_s',obtain_marks_sVal );
formdata.append('percentage_s',percentage_sVal );
formdata.append('pass_fail_s',pass_fail_sVal );
formdata.append('grade_s',grade_sVal );
formdata.append('remarks_s',remarks_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_historypagingPageno=os.getVal('WT_historypagingPageno');
	var url='wtpage='+WT_historypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_historyListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_historyListDiv',url,formdata);
		
}

WT_historyListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('asession_s',''); 
 os.setVal('registrationNo_s',''); 
 os.setVal('class_s',''); 
 os.setVal('section_s',''); 
 os.setVal('admission_no_s',''); 
 os.setVal('admission_date_s',''); 
 os.setVal('roll_no_s',''); 
 os.setVal('studentId_s',''); 
 os.setVal('full_marks_s',''); 
 os.setVal('obtain_marks_s',''); 
 os.setVal('percentage_s',''); 
 os.setVal('pass_fail_s',''); 
 os.setVal('grade_s',''); 
 os.setVal('remarks_s',''); 
	
		os.setVal('searchKey','');
		WT_historyListing();	
	
	}
	
 
function WT_historyEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var asessionVal= os.getVal('asession'); 
var registrationNoVal= os.getVal('registrationNo'); 
var classVal= os.getVal('class'); 
var sectionVal= os.getVal('section'); 
var admission_noVal= os.getVal('admission_no'); 
var admission_dateVal= os.getVal('admission_date'); 
var roll_noVal= os.getVal('roll_no'); 
var studentIdVal= os.getVal('studentId'); 
var full_marksVal= os.getVal('full_marks'); 
var obtain_marksVal= os.getVal('obtain_marks'); 
var percentageVal= os.getVal('percentage'); 
var pass_failVal= os.getVal('pass_fail'); 
var gradeVal= os.getVal('grade'); 
var remarksVal= os.getVal('remarks'); 


 formdata.append('asession',asessionVal );
 formdata.append('registrationNo',registrationNoVal );
 formdata.append('class',classVal );
 formdata.append('section',sectionVal );
 formdata.append('admission_no',admission_noVal );
 formdata.append('admission_date',admission_dateVal );
 formdata.append('roll_no',roll_noVal );
 formdata.append('studentId',studentIdVal );
 formdata.append('full_marks',full_marksVal );
 formdata.append('obtain_marks',obtain_marksVal );
 formdata.append('percentage',percentageVal );
 formdata.append('pass_fail',pass_failVal );
 formdata.append('grade',gradeVal );
 formdata.append('remarks',remarksVal );
 
 
 //------------student------
var nameVal= os.getVal('name'); 
var dobVal= os.getVal('dob'); 
var ageVal= os.getVal('age'); 
var genderVal= os.getVal('gender'); 


 formdata.append('name',nameVal );
 formdata.append('dob',dobVal );
 formdata.append('age',ageVal );
 formdata.append('gender',genderVal );

 //------------student------	

	 var   historyId=os.getVal('historyId');
	 formdata.append('historyId',historyId );
  	var url='<? echo $ajaxFilePath ?>?WT_historyEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_historyReLoadList',url,formdata);

}	

function WT_historyReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var historyId=parseInt(d[0]);
	if(d[0]!='Error' && historyId>0)
	{
	  os.setVal('historyId',historyId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_historyListing();
}

function WT_historyGetById(historyId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('historyId',historyId );
	var url='<? echo $ajaxFilePath ?>?WT_historyGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_historyFillData',url,formdata);
				
}

function WT_historyFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('historyId',parseInt(objJSON.historyId));
	
 os.setVal('asession',objJSON.asession); 
 os.setVal('registrationNo',objJSON.registrationNo); 
 os.setVal('class',objJSON.class); 
 os.setVal('section',objJSON.section); 
 os.setVal('admission_no',objJSON.admission_no); 
 os.setVal('admission_date',objJSON.admission_date); 
 os.setVal('roll_no',objJSON.roll_no); 
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('full_marks',objJSON.full_marks); 
 os.setVal('obtain_marks',objJSON.obtain_marks); 
 os.setVal('percentage',objJSON.percentage); 
 os.setVal('pass_fail',objJSON.pass_fail); 
 os.setVal('grade',objJSON.grade); 
 os.setVal('remarks',objJSON.remarks); 



// -----------------


 os.setVal('name',objJSON.name); 
 os.setVal('dob',objJSON.dob); 
 os.setVal('age',objJSON.age); 
 os.setVal('gender',objJSON.gender); 
  
}

function WT_historyDeleteRowById(historyId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(historyId)<1 || historyId==''){  
	var  historyId =os.getVal('historyId');
	}
	
	if(parseInt(historyId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('historyId',historyId );
	
	var url='<? echo $ajaxFilePath ?>?WT_historyDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_historyDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_historyDeleteRowByIdResults(data)
{
	alert(data);
	WT_historyListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_historypagingPageno',parseInt(pageNo));
	WT_historyListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>