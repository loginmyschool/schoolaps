<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Question Answer';
$ajaxFilePath= 'questionanswaredAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_questionanswaredDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_questionanswaredEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Questions </td>
										<td> <select name="questionsId" id="questionsId" class="textbox fWidth" ><option value="">Select Questions</option>		  	<? 
								
										  $os->optionsHTML('','questionsId','questionText','questions');?>
							</select> </td>						
										</tr><tr >
	  									<td>Exam </td>
										<td> <select name="examId" id="examId" class="textbox fWidth" ><option value="">Select Exam</option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select> </td>						
										</tr><tr >
	  									<td>Exam details </td>
										<td><select name="examdetailsId" id="examdetailsId" class="textbox fWidth" ><option value="">Select Exam Details</option>		  	<?$os->onlyOption($os->getExamDetailsA());?>
										  	</select> </td>						
										</tr><tr >
	  									<td>Results </td>
										<td> <select name="resultsId" id="resultsId" class="textbox fWidth" ><option value="">Select resultsId</option>
										<?$os->onlyOption($os->getResultA());?>
							               </select> </td>						
										</tr><tr >
	  									<td>Student </td>
										<td> <select name="studentId" id="studentId" class="textbox fWidth" ><option value="">Select Student</option>		  	<? 
								
										  $os->optionsHTML('','studentId','name','student');?>
							</select> </td>						
										</tr><tr >
	  									<td>Answer Selected </td>
										<td><input value="" type="text" name="answerSelected" id="answerSelected" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Marks </td>
										<td><input value="" type="text" name="marks" id="marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->questionAnswerStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="questionanswaredId" value="0" />	
	<input type="hidden"  id="WT_questionanswaredpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_questionanswaredDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_questionanswaredEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Questions:
	
	
	<select name="questionsId" id="questionsId_s" class="textbox fWidth" ><option value="">Select Questions</option>		  	<? 
								
										  $os->optionsHTML('','questionsId','questionText','questions');?>
							</select>
   Exam:
	
	
	<select name="examId" id="examId_s" class="textbox fWidth" ><option value="">Select Exam</option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select>
   Exam details: <input type="text" class="wtTextClass" name="examdetailsId_s" id="examdetailsId_s" value="" /> &nbsp;  Results: <input type="text" class="wtTextClass" name="resultsId_s" id="resultsId_s" value="" /> &nbsp;  Student:
	
	
	<select name="studentId" id="studentId_s" class="textbox fWidth" ><option value="">Select Student</option>		  	<? 
								
										  $os->optionsHTML('','studentId','name','student');?>
							</select>
   Answer Selected: <input type="text" class="wtTextClass" name="answerSelected_s" id="answerSelected_s" value="" /> &nbsp;  Marks: <input type="text" class="wtTextClass" name="marks_s" id="marks_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->questionAnswerStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_questionanswaredListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_questionanswaredListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_questionanswaredListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var questionsId_sVal= os.getVal('questionsId_s'); 
 var examId_sVal= os.getVal('examId_s'); 
 var examdetailsId_sVal= os.getVal('examdetailsId_s'); 
 var resultsId_sVal= os.getVal('resultsId_s'); 
 var studentId_sVal= os.getVal('studentId_s'); 
 var answerSelected_sVal= os.getVal('answerSelected_s'); 
 var marks_sVal= os.getVal('marks_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('questionsId_s',questionsId_sVal );
formdata.append('examId_s',examId_sVal );
formdata.append('examdetailsId_s',examdetailsId_sVal );
formdata.append('resultsId_s',resultsId_sVal );
formdata.append('studentId_s',studentId_sVal );
formdata.append('answerSelected_s',answerSelected_sVal );
formdata.append('marks_s',marks_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_questionanswaredpagingPageno=os.getVal('WT_questionanswaredpagingPageno');
	var url='wtpage='+WT_questionanswaredpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_questionanswaredListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_questionanswaredListDiv',url,formdata);
		
}

WT_questionanswaredListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('questionsId_s',''); 
 os.setVal('examId_s',''); 
 os.setVal('examdetailsId_s',''); 
 os.setVal('resultsId_s',''); 
 os.setVal('studentId_s',''); 
 os.setVal('answerSelected_s',''); 
 os.setVal('marks_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_questionanswaredListing();	
	
	}
	
 
function WT_questionanswaredEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var questionsIdVal= os.getVal('questionsId'); 
var examIdVal= os.getVal('examId'); 
var examdetailsIdVal= os.getVal('examdetailsId'); 
var resultsIdVal= os.getVal('resultsId'); 
var studentIdVal= os.getVal('studentId'); 
var answerSelectedVal= os.getVal('answerSelected'); 
var marksVal= os.getVal('marks'); 
var statusVal= os.getVal('status'); 


 formdata.append('questionsId',questionsIdVal );
 formdata.append('examId',examIdVal );
 formdata.append('examdetailsId',examdetailsIdVal );
 formdata.append('resultsId',resultsIdVal );
 formdata.append('studentId',studentIdVal );
 formdata.append('answerSelected',answerSelectedVal );
 formdata.append('marks',marksVal );
 formdata.append('status',statusVal );

	

	 var   questionanswaredId=os.getVal('questionanswaredId');
	 formdata.append('questionanswaredId',questionanswaredId );
  	var url='<? echo $ajaxFilePath ?>?WT_questionanswaredEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionanswaredReLoadList',url,formdata);

}	

function WT_questionanswaredReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var questionanswaredId=parseInt(d[0]);
	if(d[0]!='Error' && questionanswaredId>0)
	{
	  os.setVal('questionanswaredId',questionanswaredId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_questionanswaredListing();
}

function WT_questionanswaredGetById(questionanswaredId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('questionanswaredId',questionanswaredId );
	var url='<? echo $ajaxFilePath ?>?WT_questionanswaredGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionanswaredFillData',url,formdata);
				
}

function WT_questionanswaredFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('questionanswaredId',parseInt(objJSON.questionanswaredId));
	
 os.setVal('questionsId',objJSON.questionsId); 
 os.setVal('examId',objJSON.examId); 
 os.setVal('examdetailsId',objJSON.examdetailsId); 
 os.setVal('resultsId',objJSON.resultsId); 
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('answerSelected',objJSON.answerSelected); 
 os.setVal('marks',objJSON.marks); 
 os.setVal('status',objJSON.status); 

  
}

function WT_questionanswaredDeleteRowById(questionanswaredId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(questionanswaredId)<1 || questionanswaredId==''){  
	var  questionanswaredId =os.getVal('questionanswaredId');
	}
	
	if(parseInt(questionanswaredId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('questionanswaredId',questionanswaredId );
	
	var url='<? echo $ajaxFilePath ?>?WT_questionanswaredDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionanswaredDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_questionanswaredDeleteRowByIdResults(data)
{
	alert(data);
	WT_questionanswaredListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_questionanswaredpagingPageno',parseInt(pageNo));
	WT_questionanswaredListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>