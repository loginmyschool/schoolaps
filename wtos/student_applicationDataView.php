<?
/*
   # wtos version : 1.1
   # main ajax process page : student_applicationAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List student_application';
$ajaxFilePath= 'student_applicationAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_student_applicationDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_student_applicationEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Student enquiry </td>
										<td> <select name="student_enquiry_id" id="student_enquiry_id" class="textbox fWidth" ><option value="">Select Student enquiry</option>		  	<? 
								
										  $os->optionsHTML('','student_enquiry_id','title','student_enquiry');?>
							</select> </td>						
										</tr><tr >
	  									<td>Student </td>
										<td> <select name="studentId" id="studentId" class="textbox fWidth" ><option value="">Select Student</option>		  	<? 
								
										  $os->optionsHTML('','studentId','name','student');?>
							</select> </td>						
										</tr><tr >
	  									<td>Subject </td>
										<td><input value="" type="text" name="subject" id="subject" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Description </td>
										<td><textarea  name="description" id="description" ></textarea></td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->studentAppStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="student_application_id" value="0" />	
	<input type="hidden"  id="WT_student_applicationpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_student_applicationDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_student_applicationEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Student enquiry:
	
	
	<select name="student_enquiry_id" id="student_enquiry_id_s" class="textbox fWidth" ><option value="">Select Student enquiry</option>		  	<? 
								
										  $os->optionsHTML('','student_enquiry_id','title','student_enquiry');?>
							</select>
   Student:
	
	
	<select name="studentId" id="studentId_s" class="textbox fWidth" ><option value="">Select Student</option>		  	<? 
								
										  $os->optionsHTML('','studentId','name','student');?>
							</select>
   Subject: <input type="text" class="wtTextClass" name="subject_s" id="subject_s" value="" /> &nbsp;  Description: <input type="text" class="wtTextClass" name="description_s" id="description_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->studentAppStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_student_applicationListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_student_applicationListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_student_applicationListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var student_enquiry_id_sVal= os.getVal('student_enquiry_id_s'); 
 var studentId_sVal= os.getVal('studentId_s'); 
 var subject_sVal= os.getVal('subject_s'); 
 var description_sVal= os.getVal('description_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('student_enquiry_id_s',student_enquiry_id_sVal );
formdata.append('studentId_s',studentId_sVal );
formdata.append('subject_s',subject_sVal );
formdata.append('description_s',description_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_student_applicationpagingPageno=os.getVal('WT_student_applicationpagingPageno');
	var url='wtpage='+WT_student_applicationpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_student_applicationListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_student_applicationListDiv',url,formdata);
		
}

WT_student_applicationListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('student_enquiry_id_s',''); 
 os.setVal('studentId_s',''); 
 os.setVal('subject_s',''); 
 os.setVal('description_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_student_applicationListing();	
	
	}
	
 
function WT_student_applicationEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var student_enquiry_idVal= os.getVal('student_enquiry_id'); 
var studentIdVal= os.getVal('studentId'); 
var subjectVal= os.getVal('subject'); 
var descriptionVal= os.getVal('description'); 
var statusVal= os.getVal('status'); 


 formdata.append('student_enquiry_id',student_enquiry_idVal );
 formdata.append('studentId',studentIdVal );
 formdata.append('subject',subjectVal );
 formdata.append('description',descriptionVal );
 formdata.append('status',statusVal );

	
if(os.check.empty('student_enquiry_id','Please Add Student enquiry')==false){ return false;} 

	 var   student_application_id=os.getVal('student_application_id');
	 formdata.append('student_application_id',student_application_id );
  	var url='<? echo $ajaxFilePath ?>?WT_student_applicationEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_applicationReLoadList',url,formdata);

}	

function WT_student_applicationReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var student_application_id=parseInt(d[0]);
	if(d[0]!='Error' && student_application_id>0)
	{
	  os.setVal('student_application_id',student_application_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_student_applicationListing();
}

function WT_student_applicationGetById(student_application_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('student_application_id',student_application_id );
	var url='<? echo $ajaxFilePath ?>?WT_student_applicationGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_applicationFillData',url,formdata);
				
}

function WT_student_applicationFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('student_application_id',parseInt(objJSON.student_application_id));
	
 os.setVal('student_enquiry_id',objJSON.student_enquiry_id); 
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('subject',objJSON.subject); 
 os.setVal('description',objJSON.description); 
 os.setVal('status',objJSON.status); 

  
}

function WT_student_applicationDeleteRowById(student_application_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(student_application_id)<1 || student_application_id==''){  
	var  student_application_id =os.getVal('student_application_id');
	}
	
	if(parseInt(student_application_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('student_application_id',student_application_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_student_applicationDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_applicationDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_student_applicationDeleteRowByIdResults(data)
{
	alert(data);
	WT_student_applicationListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_student_applicationpagingPageno',parseInt(pageNo));
	WT_student_applicationListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>