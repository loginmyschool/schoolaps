<?
/*
   # wtos version : 1.1
   # main ajax process page : questionAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List question';
$ajaxFilePath= 'questionAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_questionDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_questionEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Exam details  </td>
										<td> <select name="examdetailsId" id="examdetailsId" class="textbox fWidth" ><option value="">Select Exam details </option>		  	<? 
								
										  $os->optionsHTML('','examdetailsId','subjectCode','examdetails');?>
							</select> </td>						
										</tr><tr >
	  									<td>Code </td>
										<td><input value="" type="text" name="code" id="code" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Subject </td>
										<td> <select name="subjectId" id="subjectId" class="textbox fWidth" ><option value="">Select Subject</option>		  	<? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select> </td>						
										</tr><tr >
	  									<td>Class </td>
										<td><input value="" type="text" name="classId" id="classId" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Board </td>
										<td><input value="" type="text" name="boardId" id="boardId" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Teacher </td>
										<td> <select name="teacherId" id="teacherId" class="textbox fWidth" ><option value="">Select Teacher</option>		  	<? 
								
										  $os->optionsHTML('','teacherId','name','teacher');?>
							</select> </td>						
										</tr><tr >
	  									<td>Marks </td>
										<td><input value="" type="text" name="marks" id="marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Negetive marks </td>
										<td><input value="" type="text" name="negetive_marks" id="negetive_marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>View order </td>
										<td><input value="" type="text" name="viewOrder" id="viewOrder" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Over All Star </td>
										<td><input value="" type="text" name="overAllStar" id="overAllStar" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Type </td>
										<td>  
	
	<select name="type" id="type" class="textbox fWidth" ><option value="">Select Type</option>	<? 
										  $os->onlyOption($os->questionType);	?></select>	 </td>						
										</tr><tr >
	  									<td>Question Text </td>
										<td><input value="" type="text" name="questionText" id="questionText" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Question Image </td>
										<td><input value="" type="text" name="questionImage" id="questionImage" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Text </td>
										<td><input value="" type="text" name="answerText1" id="answerText1" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Image </td>
										<td><input value="" type="text" name="answerImage1" id="answerImage1" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Text </td>
										<td><input value="" type="text" name="answerText2" id="answerText2" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Image </td>
										<td><input value="" type="text" name="answerImage2" id="answerImage2" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Text </td>
										<td><input value="" type="text" name="answerText3" id="answerText3" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Image </td>
										<td><input value="" type="text" name="answerImage3" id="answerImage3" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Text </td>
										<td><input value="" type="text" name="answerText4" id="answerText4" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Answer Image </td>
										<td><input value="" type="text" name="answerImage4" id="answerImage4" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Correct Answer </td>
										<td><input value="" type="text" name="correctAnswer" id="correctAnswer" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="questionId" value="0" />	
	<input type="hidden"  id="WT_questionpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_questionDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_questionEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Exam details :
	
	
	<select name="examdetailsId" id="examdetailsId_s" class="textbox fWidth" ><option value="">Select Exam details </option>		  	<? 
								
										  $os->optionsHTML('','examdetailsId','subjectCode','examdetails');?>
							</select>
   Code: <input type="text" class="wtTextClass" name="code_s" id="code_s" value="" /> &nbsp;  Subject:
	
	
	<select name="subjectId" id="subjectId_s" class="textbox fWidth" ><option value="">Select Subject</option>		  	<? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select>
   Class: <input type="text" class="wtTextClass" name="classId_s" id="classId_s" value="" /> &nbsp;  Board: <input type="text" class="wtTextClass" name="boardId_s" id="boardId_s" value="" /> &nbsp;  Teacher:
	
	
	<select name="teacherId" id="teacherId_s" class="textbox fWidth" ><option value="">Select Teacher</option>		  	<? 
								
										  $os->optionsHTML('','teacherId','name','teacher');?>
							</select>
   Marks: <input type="text" class="wtTextClass" name="marks_s" id="marks_s" value="" /> &nbsp;  Negetive marks: <input type="text" class="wtTextClass" name="negetive_marks_s" id="negetive_marks_s" value="" /> &nbsp;  View order: <input type="text" class="wtTextClass" name="viewOrder_s" id="viewOrder_s" value="" /> &nbsp;  Over All Star: <input type="text" class="wtTextClass" name="overAllStar_s" id="overAllStar_s" value="" /> &nbsp;  Type:
	
	<select name="type" id="type_s" class="textbox fWidth" ><option value="">Select Type</option>	<? 
										  $os->onlyOption($os->questionType);	?></select>	
   Question Text: <input type="text" class="wtTextClass" name="questionText_s" id="questionText_s" value="" /> &nbsp;  Question Image: <input type="text" class="wtTextClass" name="questionImage_s" id="questionImage_s" value="" /> &nbsp;  Answer Text: <input type="text" class="wtTextClass" name="answerText1_s" id="answerText1_s" value="" /> &nbsp;  Answer Image: <input type="text" class="wtTextClass" name="answerImage1_s" id="answerImage1_s" value="" /> &nbsp;  Answer Text: <input type="text" class="wtTextClass" name="answerText2_s" id="answerText2_s" value="" /> &nbsp;  Answer Image: <input type="text" class="wtTextClass" name="answerImage2_s" id="answerImage2_s" value="" /> &nbsp;  Answer Text: <input type="text" class="wtTextClass" name="answerText3_s" id="answerText3_s" value="" /> &nbsp;  Answer Image: <input type="text" class="wtTextClass" name="answerImage3_s" id="answerImage3_s" value="" /> &nbsp;  Answer Text: <input type="text" class="wtTextClass" name="answerText4_s" id="answerText4_s" value="" /> &nbsp;  Answer Image: <input type="text" class="wtTextClass" name="answerImage4_s" id="answerImage4_s" value="" /> &nbsp;  Correct Answer: <input type="text" class="wtTextClass" name="correctAnswer_s" id="correctAnswer_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_questionListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_questionListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_questionListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var examdetailsId_sVal= os.getVal('examdetailsId_s'); 
 var code_sVal= os.getVal('code_s'); 
 var subjectId_sVal= os.getVal('subjectId_s'); 
 var classId_sVal= os.getVal('classId_s'); 
 var boardId_sVal= os.getVal('boardId_s'); 
 var teacherId_sVal= os.getVal('teacherId_s'); 
 var marks_sVal= os.getVal('marks_s'); 
 var negetive_marks_sVal= os.getVal('negetive_marks_s'); 
 var viewOrder_sVal= os.getVal('viewOrder_s'); 
 var overAllStar_sVal= os.getVal('overAllStar_s'); 
 var type_sVal= os.getVal('type_s'); 
 var questionText_sVal= os.getVal('questionText_s'); 
 var questionImage_sVal= os.getVal('questionImage_s'); 
 var answerText1_sVal= os.getVal('answerText1_s'); 
 var answerImage1_sVal= os.getVal('answerImage1_s'); 
 var answerText2_sVal= os.getVal('answerText2_s'); 
 var answerImage2_sVal= os.getVal('answerImage2_s'); 
 var answerText3_sVal= os.getVal('answerText3_s'); 
 var answerImage3_sVal= os.getVal('answerImage3_s'); 
 var answerText4_sVal= os.getVal('answerText4_s'); 
 var answerImage4_sVal= os.getVal('answerImage4_s'); 
 var correctAnswer_sVal= os.getVal('correctAnswer_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('examdetailsId_s',examdetailsId_sVal );
formdata.append('code_s',code_sVal );
formdata.append('subjectId_s',subjectId_sVal );
formdata.append('classId_s',classId_sVal );
formdata.append('boardId_s',boardId_sVal );
formdata.append('teacherId_s',teacherId_sVal );
formdata.append('marks_s',marks_sVal );
formdata.append('negetive_marks_s',negetive_marks_sVal );
formdata.append('viewOrder_s',viewOrder_sVal );
formdata.append('overAllStar_s',overAllStar_sVal );
formdata.append('type_s',type_sVal );
formdata.append('questionText_s',questionText_sVal );
formdata.append('questionImage_s',questionImage_sVal );
formdata.append('answerText1_s',answerText1_sVal );
formdata.append('answerImage1_s',answerImage1_sVal );
formdata.append('answerText2_s',answerText2_sVal );
formdata.append('answerImage2_s',answerImage2_sVal );
formdata.append('answerText3_s',answerText3_sVal );
formdata.append('answerImage3_s',answerImage3_sVal );
formdata.append('answerText4_s',answerText4_sVal );
formdata.append('answerImage4_s',answerImage4_sVal );
formdata.append('correctAnswer_s',correctAnswer_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_questionpagingPageno=os.getVal('WT_questionpagingPageno');
	var url='wtpage='+WT_questionpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_questionListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_questionListDiv',url,formdata);
		
}

WT_questionListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('examdetailsId_s',''); 
 os.setVal('code_s',''); 
 os.setVal('subjectId_s',''); 
 os.setVal('classId_s',''); 
 os.setVal('boardId_s',''); 
 os.setVal('teacherId_s',''); 
 os.setVal('marks_s',''); 
 os.setVal('negetive_marks_s',''); 
 os.setVal('viewOrder_s',''); 
 os.setVal('overAllStar_s',''); 
 os.setVal('type_s',''); 
 os.setVal('questionText_s',''); 
 os.setVal('questionImage_s',''); 
 os.setVal('answerText1_s',''); 
 os.setVal('answerImage1_s',''); 
 os.setVal('answerText2_s',''); 
 os.setVal('answerImage2_s',''); 
 os.setVal('answerText3_s',''); 
 os.setVal('answerImage3_s',''); 
 os.setVal('answerText4_s',''); 
 os.setVal('answerImage4_s',''); 
 os.setVal('correctAnswer_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_questionListing();	
	
	}
	
 
function WT_questionEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var examdetailsIdVal= os.getVal('examdetailsId'); 
var codeVal= os.getVal('code'); 
var subjectIdVal= os.getVal('subjectId'); 
var classIdVal= os.getVal('classId'); 
var boardIdVal= os.getVal('boardId'); 
var teacherIdVal= os.getVal('teacherId'); 
var marksVal= os.getVal('marks'); 
var negetive_marksVal= os.getVal('negetive_marks'); 
var viewOrderVal= os.getVal('viewOrder'); 
var overAllStarVal= os.getVal('overAllStar'); 
var typeVal= os.getVal('type'); 
var questionTextVal= os.getVal('questionText'); 
var questionImageVal= os.getVal('questionImage'); 
var answerText1Val= os.getVal('answerText1'); 
var answerImage1Val= os.getVal('answerImage1'); 
var answerText2Val= os.getVal('answerText2'); 
var answerImage2Val= os.getVal('answerImage2'); 
var answerText3Val= os.getVal('answerText3'); 
var answerImage3Val= os.getVal('answerImage3'); 
var answerText4Val= os.getVal('answerText4'); 
var answerImage4Val= os.getVal('answerImage4'); 
var correctAnswerVal= os.getVal('correctAnswer'); 
var statusVal= os.getVal('status'); 


 formdata.append('examdetailsId',examdetailsIdVal );
 formdata.append('code',codeVal );
 formdata.append('subjectId',subjectIdVal );
 formdata.append('classId',classIdVal );
 formdata.append('boardId',boardIdVal );
 formdata.append('teacherId',teacherIdVal );
 formdata.append('marks',marksVal );
 formdata.append('negetive_marks',negetive_marksVal );
 formdata.append('viewOrder',viewOrderVal );
 formdata.append('overAllStar',overAllStarVal );
 formdata.append('type',typeVal );
 formdata.append('questionText',questionTextVal );
 formdata.append('questionImage',questionImageVal );
 formdata.append('answerText1',answerText1Val );
 formdata.append('answerImage1',answerImage1Val );
 formdata.append('answerText2',answerText2Val );
 formdata.append('answerImage2',answerImage2Val );
 formdata.append('answerText3',answerText3Val );
 formdata.append('answerImage3',answerImage3Val );
 formdata.append('answerText4',answerText4Val );
 formdata.append('answerImage4',answerImage4Val );
 formdata.append('correctAnswer',correctAnswerVal );
 formdata.append('status',statusVal );

	

	 var   questionId=os.getVal('questionId');
	 formdata.append('questionId',questionId );
  	var url='<? echo $ajaxFilePath ?>?WT_questionEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionReLoadList',url,formdata);

}	

function WT_questionReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var questionId=parseInt(d[0]);
	if(d[0]!='Error' && questionId>0)
	{
	  os.setVal('questionId',questionId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_questionListing();
}

function WT_questionGetById(questionId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('questionId',questionId );
	var url='<? echo $ajaxFilePath ?>?WT_questionGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionFillData',url,formdata);
				
}

function WT_questionFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('questionId',parseInt(objJSON.questionId));
	
 os.setVal('examdetailsId',objJSON.examdetailsId); 
 os.setVal('code',objJSON.code); 
 os.setVal('subjectId',objJSON.subjectId); 
 os.setVal('classId',objJSON.classId); 
 os.setVal('boardId',objJSON.boardId); 
 os.setVal('teacherId',objJSON.teacherId); 
 os.setVal('marks',objJSON.marks); 
 os.setVal('negetive_marks',objJSON.negetive_marks); 
 os.setVal('viewOrder',objJSON.viewOrder); 
 os.setVal('overAllStar',objJSON.overAllStar); 
 os.setVal('type',objJSON.type); 
 os.setVal('questionText',objJSON.questionText); 
 os.setVal('questionImage',objJSON.questionImage); 
 os.setVal('answerText1',objJSON.answerText1); 
 os.setVal('answerImage1',objJSON.answerImage1); 
 os.setVal('answerText2',objJSON.answerText2); 
 os.setVal('answerImage2',objJSON.answerImage2); 
 os.setVal('answerText3',objJSON.answerText3); 
 os.setVal('answerImage3',objJSON.answerImage3); 
 os.setVal('answerText4',objJSON.answerText4); 
 os.setVal('answerImage4',objJSON.answerImage4); 
 os.setVal('correctAnswer',objJSON.correctAnswer); 
 os.setVal('status',objJSON.status); 

  
}

function WT_questionDeleteRowById(questionId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(questionId)<1 || questionId==''){  
	var  questionId =os.getVal('questionId');
	}
	
	if(parseInt(questionId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('questionId',questionId );
	
	var url='<? echo $ajaxFilePath ?>?WT_questionDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_questionDeleteRowByIdResults(data)
{
	alert(data);
	WT_questionListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_questionpagingPageno',parseInt(pageNo));
	WT_questionListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>