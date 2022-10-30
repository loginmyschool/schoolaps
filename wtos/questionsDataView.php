<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List questions';
$ajaxFilePath= 'questionsAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_questionsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_questionsEditAndSave();" /><? } ?>	 
	
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Exam  </td>
										<td> <select name="examId" id="examId" class="textbox fWidth" ><option value="">Select Exam </option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select> </td>						
										</tr><tr >
	  									<td>Exam Details </td>
										<td> <select name="examdetailsId" id="examdetailsId" class="textbox fWidth" ><option value="">Select Exam Details</option>		  	<? 
										// $os->optionsHTML('','examdetailsId','subjectCode','examdetails');
										$os->onlyOption($os->getExamDetailsA());

										?>
										  
										 
							</select> </td>						
										</tr><tr >
	  									<td>Question Text </td>
										<td><textarea  name="questionText" id="questionText" ></textarea></td>						
										</tr><tr >
	  									<td>Question Image </td>
										<td>
										
										<img id="questionImagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="questionImage" value=""  id="questionImage" onchange="os.readURL(this,'questionImagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('questionImage');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Answer Text </td>
										<td><textarea  name="answerText" id="answerText" ></textarea></td>						
										</tr><tr >
	  									<td>Answer Image </td>
										<td>
										
										<img id="answerImagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="answerImage" value=""  id="answerImage" onchange="os.readURL(this,'answerImagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Correct Answer </td>
										<td><textarea  name="correctAnswer" id="correctAnswer" ></textarea></td>						
										</tr><tr >
	  									<td>Marks </td>
										<td><input value="" type="text" name="marks" id="marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Negetive Marks </td>
										<td><input value="" type="text" name="negetiveMarks" id="negetiveMarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->questionStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="questionsId" value="0" />	
	<input type="hidden"  id="WT_questionspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_questionsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_questionsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Exam :
	
	
	<select name="examId" id="examId_s" class="textbox fWidth" ><option value="">Select Exam </option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select>
   Exam Details:
	
	
	<select name="examdetailsId" id="examdetailsId_s" class="textbox fWidth" ><option value="">Select Exam Details</option>		  	<? 
								
										  $os->optionsHTML('','examdetailsId','subjectCode','examdetails');?>
							</select>
   Question Text: <input type="text" class="wtTextClass" name="questionText_s" id="questionText_s" value="" /> &nbsp;   Answer Text: <input type="text" class="wtTextClass" name="answerText_s" id="answerText_s" value="" /> &nbsp;   Correct Answer: <input type="text" class="wtTextClass" name="correctAnswer_s" id="correctAnswer_s" value="" /> &nbsp;  Marks: <input type="text" class="wtTextClass" name="marks_s" id="marks_s" value="" /> &nbsp;  Negetive Marks: <input type="text" class="wtTextClass" name="negetiveMarks_s" id="negetiveMarks_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->questionStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_questionsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_questionsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_questionsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var examId_sVal= os.getVal('examId_s'); 
 var examdetailsId_sVal= os.getVal('examdetailsId_s'); 
 var questionText_sVal= os.getVal('questionText_s'); 
 var answerText_sVal= os.getVal('answerText_s'); 
 var correctAnswer_sVal= os.getVal('correctAnswer_s'); 
 var marks_sVal= os.getVal('marks_s'); 
 var negetiveMarks_sVal= os.getVal('negetiveMarks_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('examId_s',examId_sVal );
formdata.append('examdetailsId_s',examdetailsId_sVal );
formdata.append('questionText_s',questionText_sVal );
formdata.append('answerText_s',answerText_sVal );
formdata.append('correctAnswer_s',correctAnswer_sVal );
formdata.append('marks_s',marks_sVal );
formdata.append('negetiveMarks_s',negetiveMarks_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_questionspagingPageno=os.getVal('WT_questionspagingPageno');
	var url='wtpage='+WT_questionspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_questionsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_questionsListDiv',url,formdata);
		
}

WT_questionsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('examId_s',''); 
 os.setVal('examdetailsId_s',''); 
 os.setVal('questionText_s',''); 
 os.setVal('answerText_s',''); 
 os.setVal('correctAnswer_s',''); 
 os.setVal('marks_s',''); 
 os.setVal('negetiveMarks_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_questionsListing();	
	
	}
	
 
function WT_questionsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var examIdVal= os.getVal('examId'); 
var examdetailsIdVal= os.getVal('examdetailsId'); 
var questionTextVal= os.getVal('questionText'); 
var questionImageVal= os.getObj('questionImage').files[0]; 
var answerTextVal= os.getVal('answerText'); 
var answerImageVal= os.getObj('answerImage').files[0]; 
var correctAnswerVal= os.getVal('correctAnswer'); 
var marksVal= os.getVal('marks'); 
var negetiveMarksVal= os.getVal('negetiveMarks'); 
var statusVal= os.getVal('status'); 


 formdata.append('examId',examIdVal );
 formdata.append('examdetailsId',examdetailsIdVal );
 formdata.append('questionText',questionTextVal );
if(questionImageVal){  formdata.append('questionImage',questionImageVal,questionImageVal.name );}
 formdata.append('answerText',answerTextVal );
if(answerImageVal){  formdata.append('answerImage',answerImageVal,answerImageVal.name );}
 formdata.append('correctAnswer',correctAnswerVal );
 formdata.append('marks',marksVal );
 formdata.append('negetiveMarks',negetiveMarksVal );
 formdata.append('status',statusVal );

	

	 var   questionsId=os.getVal('questionsId');
	 formdata.append('questionsId',questionsId );
  	var url='<? echo $ajaxFilePath ?>?WT_questionsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionsReLoadList',url,formdata);

}	

function WT_questionsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var questionsId=parseInt(d[0]);
	if(d[0]!='Error' && questionsId>0)
	{
	  os.setVal('questionsId',questionsId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_questionsListing();
}

function WT_questionsGetById(questionsId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('questionsId',questionsId );
	var url='<? echo $ajaxFilePath ?>?WT_questionsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionsFillData',url,formdata);
				
}

function WT_questionsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('questionsId',parseInt(objJSON.questionsId));
	
 os.setVal('examId',objJSON.examId); 
 os.setVal('examdetailsId',objJSON.examdetailsId); 
 os.setVal('questionText',objJSON.questionText); 
 os.setImg('questionImagePreview',objJSON.questionImage); 
 os.setVal('answerText',objJSON.answerText); 
 os.setImg('answerImagePreview',objJSON.answerImage); 
 os.setVal('correctAnswer',objJSON.correctAnswer); 
 os.setVal('marks',objJSON.marks); 
 os.setVal('negetiveMarks',objJSON.negetiveMarks); 
 os.setVal('status',objJSON.status); 

  
}

function WT_questionsDeleteRowById(questionsId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(questionsId)<1 || questionsId==''){  
	var  questionsId =os.getVal('questionsId');
	}
	
	if(parseInt(questionsId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('questionsId',questionsId );
	
	var url='<? echo $ajaxFilePath ?>?WT_questionsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_questionsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_questionsDeleteRowByIdResults(data)
{
	alert(data);
	WT_questionsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_questionspagingPageno',parseInt(pageNo));
	WT_questionsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>