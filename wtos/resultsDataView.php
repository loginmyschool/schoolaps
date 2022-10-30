<?
/*
   # wtos version : 1.1
   # main ajax process page : resultsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List results';
$ajaxFilePath= 'resultsAjax.php';
$os->loadPluginConstant($pluginName);
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_resultsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_resultsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Student </td>
										<td> <select name="studentId" id="studentId" class="textbox fWidth" ><option value="">Select Student</option>		  	<? 
								
										  $os->optionsHTML('','studentId','name','student');?>
							</select> </td>						
										</tr><tr >
	  									<td>Exam </td>
										<td> <select name="examId" id="examId" class="textbox fWidth" ><option value="">Select Exam</option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select> </td>						
										</tr><tr >
	  									<td>Total Exam Marks </td>
										<td><input value="" type="text" name="totalExamMarks" id="totalExamMarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Obtain Marks </td>
										<td><input value="" type="text" name="obtainMarks" id="obtainMarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Percentage </td>
										<td><input value="" type="text" name="percentage" id="percentage" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Grade </td>
										<td><input value="" type="text" name="grade" id="grade" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><input value="" type="text" name="note" id="note" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->resultStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="resultsId" value="0" />	
	<input type="hidden"  id="WT_resultspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_resultsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_resultsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Student:
	
	
	<select name="studentId" id="studentId_s" class="textbox fWidth" ><option value="">Select Student</option>		  	<? 
								
										  $os->optionsHTML('','studentId','name','student');?>
							</select>
   Exam:
	
	
	<select name="examId" id="examId_s" class="textbox fWidth" ><option value="">Select Exam</option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select>
   Total Exam Marks: <input type="text" class="wtTextClass" name="totalExamMarks_s" id="totalExamMarks_s" value="" /> &nbsp;  Obtain Marks: <input type="text" class="wtTextClass" name="obtainMarks_s" id="obtainMarks_s" value="" /> &nbsp;  Percentage: <input type="text" class="wtTextClass" name="percentage_s" id="percentage_s" value="" /> &nbsp;  ZGrade: <input type="text" class="wtTextClass" name="grade_s" id="grade_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->resultStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_resultsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_resultsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_resultsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var studentId_sVal= os.getVal('studentId_s'); 
 var examId_sVal= os.getVal('examId_s'); 
 var totalExamMarks_sVal= os.getVal('totalExamMarks_s'); 
 var obtainMarks_sVal= os.getVal('obtainMarks_s'); 
 var percentage_sVal= os.getVal('percentage_s'); 
 var grade_sVal= os.getVal('grade_s'); 
 var note_sVal= os.getVal('note_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('studentId_s',studentId_sVal );
formdata.append('examId_s',examId_sVal );
formdata.append('totalExamMarks_s',totalExamMarks_sVal );
formdata.append('obtainMarks_s',obtainMarks_sVal );
formdata.append('percentage_s',percentage_sVal );
formdata.append('grade_s',grade_sVal );
formdata.append('note_s',note_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_resultspagingPageno=os.getVal('WT_resultspagingPageno');
	var url='wtpage='+WT_resultspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_resultsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_resultsListDiv',url,formdata);
		
}

WT_resultsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('studentId_s',''); 
 os.setVal('examId_s',''); 
 os.setVal('totalExamMarks_s',''); 
 os.setVal('obtainMarks_s',''); 
 os.setVal('percentage_s',''); 
 os.setVal('grade_s',''); 
 os.setVal('note_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_resultsListing();	
	
	}
	
 
function WT_resultsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var studentIdVal= os.getVal('studentId'); 
var examIdVal= os.getVal('examId'); 
var totalExamMarksVal= os.getVal('totalExamMarks'); 
var obtainMarksVal= os.getVal('obtainMarks'); 
var percentageVal= os.getVal('percentage'); 
var gradeVal= os.getVal('grade'); 
var noteVal= os.getVal('note'); 
var statusVal= os.getVal('status'); 


 formdata.append('studentId',studentIdVal );
 formdata.append('examId',examIdVal );
 formdata.append('totalExamMarks',totalExamMarksVal );
 formdata.append('obtainMarks',obtainMarksVal );
 formdata.append('percentage',percentageVal );
 formdata.append('grade',gradeVal );
 formdata.append('note',noteVal );
 formdata.append('status',statusVal );

	

	 var   resultsId=os.getVal('resultsId');
	 formdata.append('resultsId',resultsId );
  	var url='<? echo $ajaxFilePath ?>?WT_resultsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_resultsReLoadList',url,formdata);

}	

function WT_resultsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var resultsId=parseInt(d[0]);
	if(d[0]!='Error' && resultsId>0)
	{
	  os.setVal('resultsId',resultsId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_resultsListing();
}

function WT_resultsGetById(resultsId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('resultsId',resultsId );
	var url='<? echo $ajaxFilePath ?>?WT_resultsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_resultsFillData',url,formdata);
				
}

function WT_resultsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('resultsId',parseInt(objJSON.resultsId));
	
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('examId',objJSON.examId); 
 os.setVal('totalExamMarks',objJSON.totalExamMarks); 
 os.setVal('obtainMarks',objJSON.obtainMarks); 
 os.setVal('percentage',objJSON.percentage); 
 os.setVal('grade',objJSON.grade); 
 os.setVal('note',objJSON.note); 
 os.setVal('status',objJSON.status); 

  
}

function WT_resultsDeleteRowById(resultsId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(resultsId)<1 || resultsId==''){  
	var  resultsId =os.getVal('resultsId');
	}
	
	if(parseInt(resultsId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('resultsId',resultsId );
	
	var url='<? echo $ajaxFilePath ?>?WT_resultsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_resultsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_resultsDeleteRowByIdResults(data)
{
	alert(data);
	WT_resultsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_resultspagingPageno',parseInt(pageNo));
	WT_resultsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>