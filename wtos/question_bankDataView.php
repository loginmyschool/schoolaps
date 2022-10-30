<?
/*
   # wtos version : 1.1
   # main ajax process page : question_bankAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List question_bank';
$ajaxFilePath= 'question_bankAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
$os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
$os->question_type_arr=array('MCQ'=>'MCQ','DESC'=>'DESC');
$os->question_base_arr=array('Informative'=>'Informative','Math'=>'Math');
$os->active_status = array('1'=>'1','2'=>'2','3'=>'3' );
$os->correctAnswer_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4' );

 include('tinyMCE.php');
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_bankDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_question_bankEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Code </td>
										<td><input value="" type="text" name="code" id="code" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr>
	  									<td>Class </td>
										<td><select name="classId" id="classId" class="textbox fWidth"  onchange="wt_ajax_chain('html*subjectId*subject,subjectId,subjectName*classId=classId','','','');">
										
										
										<option value=""> </option>	
										 <? $os->onlyOption($os->classList);	?></select>	 
										</td>						
										</tr>
										
										<tr >
	  									<td>Subject </td>
										<td> <select name="subjectId" id="subjectId" class="textbox fWidth" ><option value=""> </option>		  	<? 
								
										 // $os->optionsHTML('','subjectId','subjectName','subject');
										 
										 ?>
							</select> </td>						
										</tr>
										
										
										
										
										<tr style="display:none;" >
	  									<td>Board </td>
										<td>  
	
	<select name="boardId" id="boardId" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->board);	?></select>	 </td>						
										</tr><tr >
	  									<td>Marks </td>
										<td><input value="" type="text" name="marks" id="marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Negetive Marks </td>
										<td><input value="" type="text" name="negetive_marks" id="negetive_marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>View Order </td>
										<td><input value="" type="text" name="viewOrder" id="viewOrder" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Type </td>
										<td>  
	
	<select name="type" id="type" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->question_type_arr);	?></select>	 </td>						
										</tr><tr >
	  									<td>Question  </td>
										<td><textarea  name="questionText" id="questionText" ></textarea></td>						
										</tr><tr >
	  									<td>Question  Image </td>
										<td>
										
										<img id="questionImagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="questionImage" value=""  id="questionImage" onchange="os.readURL(this,'questionImagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('questionImage');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Answer 1 </td>
										<td><textarea  name="answerText1" id="answerText1" ></textarea></td>						
										</tr><tr >
	  									<td>Answer 1 Image </td>
										<td>
										
										<img id="answerImage1Preview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="answerImage1" value=""  id="answerImage1" onchange="os.readURL(this,'answerImage1Preview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage1');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Answer 2 </td>
										<td><textarea  name="answerText2" id="answerText2" ></textarea></td>						
										</tr><tr >
	  									<td>Answer 2 Image </td>
										<td>
										
										<img id="answerImage2Preview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="answerImage2" value=""  id="answerImage2" onchange="os.readURL(this,'answerImage2Preview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage2');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Answer 3 </td>
										<td><textarea  name="answerText3" id="answerText3" ></textarea></td>						
										</tr><tr >
	  									<td>Answer 3 Image </td>
										<td>
										
										<img id="answerImage3Preview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="answerImage3" value=""  id="answerImage3" onchange="os.readURL(this,'answerImage3Preview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage3');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Answer 4 </td>
										<td><textarea  name="answerText4" id="answerText4" ></textarea></td>						
										</tr><tr >
	  									<td>Answer 4 Image </td>
										<td>
										
										<img id="answerImage4Preview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="answerImage4" value=""  id="answerImage4" onchange="os.readURL(this,'answerImage4Preview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage4');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Correct Option </td>
										<td>  
	
	<select name="correctAnswer" id="correctAnswer" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->correctAnswer_arr);	?></select>	 </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->active_status);	?></select>	 </td>						
										</tr><tr >
	  									<td>Chapter </td>
										<td> 
										<select name="question_chapter_id" id="question_chapter_id" class="textbox fWidth" onchange="wt_ajax_chain('html*question_topic_id*question_topic,question_topic_id,title*question_chapter_id=question_chapter_id');">
										
										<option value=""> </option>		  	<? 
								
										  $os->optionsHTML('','question_chapter_id','title','question_chapter');?>
							</select> </td>						
										</tr><tr >
	  									<td>Topic </td>
										<td> <select name="question_topic_id" id="question_topic_id" class="textbox fWidth" ><option value=""> </option>		  	<? 
								
										  $os->optionsHTML('','question_topic_id','title','question_topic');?>
							</select> </td>						
										</tr><tr >
	  									<td>Level </td>
										<td>  
	
	<select name="level" id="level" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->question_level_arr);	?></select>	 </td>						
										</tr><tr >
	  									<td>Base </td>
										<td>  
	
	<select name="question_base" id="question_base" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->question_base_arr);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="questionId" value="0" />	
	<input type="hidden"  id="WT_question_bankpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_bankDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_question_bankEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
    Class:
	
	<select name="classId" id="classId_s" class="textbox fWidth"  onchange="wt_ajax_chain('html*subjectId_s*subject,subjectId,subjectName*classId=classId_s');">
	
	<option value=""> </option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 &nbsp;
     
	   Subject:
	
	
	<select name="subjectId" id="subjectId_s" class="textbox fWidth" ><option value=""> </option>		  	<? 
								
										//  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select> &nbsp;
 
										   Type:
	
	<select name="type" id="type_s" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->question_type_arr);	?></select>	 &nbsp;
										   Chapter:
	
	
	<select name="question_chapter_id" id="question_chapter_id_s" class="textbox fWidth" onchange="wt_ajax_chain('html*question_topic_id_s*question_topic,question_topic_id,title*question_chapter_id=question_chapter_id_s');">
	
	
	<option value=""> </option>		  	<? 
								
										  $os->optionsHTML('','question_chapter_id','title','question_chapter');?>
							</select> &nbsp;
   Topic:
	
	
	<select name="question_topic_id" id="question_topic_id_s" class="textbox fWidth" ><option value=""> </option>		  	<? 
								
										  $os->optionsHTML('','question_topic_id','title','question_topic');?>
							</select> &nbsp;
   Level:
	
	<select name="level" id="level_s" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->question_level_arr);	?></select>	 &nbsp;
   Base:
	
	<select name="question_base" id="question_base_s" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->question_base_arr);	?></select>	
   
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Code: <input type="text" class="wtTextClass" name="code_s" id="code_s" value="" /> &nbsp; 
   Board:
	
	<select name="boardId" id="boardId_s" class="textbox fWidth" ><option value="">Select Board</option>	<? 
										  $os->onlyOption($os->board);	?></select>	
  
   Question : <input type="text" class="wtTextClass" name="questionText_s" id="questionText_s" value="" /> &nbsp;  Answer 1: <input type="text" class="wtTextClass" name="answerText1_s" id="answerText1_s" value="" /> &nbsp;  Answer 2: <input type="text" class="wtTextClass" name="answerText2_s" id="answerText2_s" value="" /> &nbsp;  Answer 3: <input type="text" class="wtTextClass" name="answerText3_s" id="answerText3_s" value="" /> &nbsp;  Answer 4: <input type="text" class="wtTextClass" name="answerText4_s" id="answerText4_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->active_status);	?></select>	
  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_question_bankListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_question_bankListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_question_bankListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var code_sVal= os.getVal('code_s'); 
 var subjectId_sVal= os.getVal('subjectId_s'); 
 var classId_sVal= os.getVal('classId_s'); 
 var boardId_sVal= os.getVal('boardId_s'); 
 var type_sVal= os.getVal('type_s'); 
 var questionText_sVal= os.getVal('questionText_s'); 
 var answerText1_sVal= os.getVal('answerText1_s'); 
 var answerText2_sVal= os.getVal('answerText2_s'); 
 var answerText3_sVal= os.getVal('answerText3_s'); 
 var answerText4_sVal= os.getVal('answerText4_s'); 
 var status_sVal= os.getVal('status_s'); 
 var question_chapter_id_sVal= os.getVal('question_chapter_id_s'); 
 var question_topic_id_sVal= os.getVal('question_topic_id_s'); 
 var level_sVal= os.getVal('level_s'); 
 var question_base_sVal= os.getVal('question_base_s'); 
formdata.append('code_s',code_sVal );
formdata.append('subjectId_s',subjectId_sVal );
formdata.append('classId_s',classId_sVal );
formdata.append('boardId_s',boardId_sVal );
formdata.append('type_s',type_sVal );
formdata.append('questionText_s',questionText_sVal );
formdata.append('answerText1_s',answerText1_sVal );
formdata.append('answerText2_s',answerText2_sVal );
formdata.append('answerText3_s',answerText3_sVal );
formdata.append('answerText4_s',answerText4_sVal );
formdata.append('status_s',status_sVal );
formdata.append('question_chapter_id_s',question_chapter_id_sVal );
formdata.append('question_topic_id_s',question_topic_id_sVal );
formdata.append('level_s',level_sVal );
formdata.append('question_base_s',question_base_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_question_bankpagingPageno=os.getVal('WT_question_bankpagingPageno');
	var url='wtpage='+WT_question_bankpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_question_bankListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_question_bankListDiv',url,formdata);
		
}

WT_question_bankListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('code_s',''); 
 os.setVal('subjectId_s',''); 
 os.setVal('classId_s',''); 
 os.setVal('boardId_s',''); 
 os.setVal('type_s',''); 
 os.setVal('questionText_s',''); 
 os.setVal('answerText1_s',''); 
 os.setVal('answerText2_s',''); 
 os.setVal('answerText3_s',''); 
 os.setVal('answerText4_s',''); 
 os.setVal('status_s',''); 
 os.setVal('question_chapter_id_s',''); 
 os.setVal('question_topic_id_s',''); 
 os.setVal('level_s',''); 
 os.setVal('question_base_s',''); 
	
		os.setVal('searchKey','');
		WT_question_bankListing();	
	
	}
	
 
function WT_question_bankEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var codeVal= os.getVal('code'); 
var subjectIdVal= os.getVal('subjectId'); 
var classIdVal= os.getVal('classId'); 
var boardIdVal= os.getVal('boardId'); 
var marksVal= os.getVal('marks'); 
var negetive_marksVal= os.getVal('negetive_marks'); 
var viewOrderVal= os.getVal('viewOrder'); 
var typeVal= os.getVal('type'); 
var questionTextVal= tinyMCE.get("questionText").getContent(); // os.getVal('questionText'); 
var questionImageVal= os.getObj('questionImage').files[0]; 
var answerText1Val= tinyMCE.get("answerText1").getContent();//os.getVal('answerText1'); 
var answerImage1Val= os.getObj('answerImage1').files[0]; 
var answerText2Val= tinyMCE.get("answerText2").getContent();//os.getVal('answerText2'); 
var answerImage2Val= os.getObj('answerImage2').files[0]; 
var answerText3Val= tinyMCE.get("answerText3").getContent();//os.getVal('answerText3'); 
var answerImage3Val= os.getObj('answerImage3').files[0]; 
var answerText4Val= tinyMCE.get("answerText4").getContent();//os.getVal('answerText4'); 
var answerImage4Val= os.getObj('answerImage4').files[0]; 
var correctAnswerVal= os.getVal('correctAnswer'); 
var statusVal= os.getVal('status'); 
var question_chapter_idVal= os.getVal('question_chapter_id'); 
var question_topic_idVal= os.getVal('question_topic_id'); 
var levelVal= os.getVal('level'); 
var question_baseVal= os.getVal('question_base'); 


 formdata.append('code',codeVal );
 formdata.append('subjectId',subjectIdVal );
 formdata.append('classId',classIdVal );
 formdata.append('boardId',boardIdVal );
 formdata.append('marks',marksVal );
 formdata.append('negetive_marks',negetive_marksVal );
 formdata.append('viewOrder',viewOrderVal );
 formdata.append('type',typeVal );
 
 
 formdata.append('questionText',questionTextVal );
if(questionImageVal){  formdata.append('questionImage',questionImageVal,questionImageVal.name );}
 formdata.append('answerText1',answerText1Val );
if(answerImage1Val){  formdata.append('answerImage1',answerImage1Val,answerImage1Val.name );}
 formdata.append('answerText2',answerText2Val );
if(answerImage2Val){  formdata.append('answerImage2',answerImage2Val,answerImage2Val.name );}
 formdata.append('answerText3',answerText3Val );
if(answerImage3Val){  formdata.append('answerImage3',answerImage3Val,answerImage3Val.name );}
 formdata.append('answerText4',answerText4Val );
if(answerImage4Val){  formdata.append('answerImage4',answerImage4Val,answerImage4Val.name );}
 formdata.append('correctAnswer',correctAnswerVal );
 formdata.append('status',statusVal );
 formdata.append('question_chapter_id',question_chapter_idVal );
 formdata.append('question_topic_id',question_topic_idVal );
 formdata.append('level',levelVal );
 formdata.append('question_base',question_baseVal );
 
 
 
            
 

	
if(os.check.empty('subjectId','Please Add Subject')==false){ return false;} 
if(os.check.empty('classId','Please Add Class')==false){ return false;} 

	 var   questionId=os.getVal('questionId');
	 formdata.append('questionId',questionId );
  	var url='<? echo $ajaxFilePath ?>?WT_question_bankEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_bankReLoadList',url,formdata);

}	

function WT_question_bankReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var questionId=parseInt(d[0]);
	if(d[0]!='Error' && questionId>0)
	{
	  os.setVal('questionId',questionId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_question_bankListing();
}

function WT_question_bankGetById(questionId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('questionId',questionId );
	var url='<? echo $ajaxFilePath ?>?WT_question_bankGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_bankFillData',url,formdata);
				
}

function WT_question_bankFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('questionId',parseInt(objJSON.questionId));
	
 os.setVal('code',objJSON.code); 
 os.setVal('subjectId',objJSON.subjectId); 
 os.setVal('classId',objJSON.classId); 
 os.setVal('boardId',objJSON.boardId); 
 os.setVal('marks',objJSON.marks); 
 os.setVal('negetive_marks',objJSON.negetive_marks); 
 os.setVal('viewOrder',objJSON.viewOrder); 
 os.setVal('type',objJSON.type); 
 
 //os.setVal('questionText',objJSON.questionText); 
 tinyMCE.get("questionText").setContent(objJSON.questionText);

  
 os.setImg('questionImagePreview',objJSON.questionImage); 
// os.setVal('answerText1',objJSON.answerText1); 
 tinyMCE.get("answerText1").setContent(objJSON.answerText1);
 os.setImg('answerImage1Preview',objJSON.answerImage1); 
 //os.setVal('answerText2',objJSON.answerText2); 
 tinyMCE.get("answerText2").setContent(objJSON.answerText2);
 os.setImg('answerImage2Preview',objJSON.answerImage2); 
// os.setVal('answerText3',objJSON.answerText3); 
 tinyMCE.get("answerText3").setContent(objJSON.answerText3);
 os.setImg('answerImage3Preview',objJSON.answerImage3); 
// os.setVal('answerText4',objJSON.answerText4); 
 tinyMCE.get("answerText4").setContent(objJSON.answerText4);
 os.setImg('answerImage4Preview',objJSON.answerImage4); 
 os.setVal('correctAnswer',objJSON.correctAnswer); 
 os.setVal('status',objJSON.status); 
 os.setVal('question_chapter_id',objJSON.question_chapter_id); 
 os.setVal('question_topic_id',objJSON.question_topic_id); 
 os.setVal('level',objJSON.level); 
 os.setVal('question_base',objJSON.question_base); 


 global_question_topic_id=objJSON.question_topic_id;
 wt_ajax_chain('html*question_topic_id*question_topic,question_topic_id,title*question_chapter_id=question_chapter_id','','','setquestion_topic_id()');
 
 global_subjectId=objJSON.subjectId;
 wt_ajax_chain('html*subjectId*subject,subjectId,subjectName*classId=classId','','','setSubjectId()');
}

var global_subjectId='';
function setSubjectId(){os.setVal('subjectId',global_subjectId); }

var global_question_topic_id='';
function setquestion_topic_id(){os.setVal('question_topic_id',global_question_topic_id); }






function WT_question_bankDeleteRowById(questionId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(questionId)<1 || questionId==''){  
	var  questionId =os.getVal('questionId');
	}
	
	if(parseInt(questionId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('questionId',questionId );
	
	var url='<? echo $ajaxFilePath ?>?WT_question_bankDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_bankDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_question_bankDeleteRowByIdResults(data)
{
	alert(data);
	WT_question_bankListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_question_bankpagingPageno',parseInt(pageNo));
	WT_question_bankListing();
}

	
	
	        tmce('questionText');
            tmce('answerText1');
            tmce('answerText2');
            tmce('answerText3');
            tmce('answerText4');


        //    tinymce.execCommand('mceAddEditor',true,'questionText');
         //   tinymce.execCommand('mceAddEditor',true, 'answerText1');
         //   tinymce.execCommand('mceAddEditor',true, 'answerText2');
         //   tinymce.execCommand('mceAddEditor',true, 'answerText3');
          //  tinymce.execCommand('mceAddEditor',true, 'answerText4');
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>