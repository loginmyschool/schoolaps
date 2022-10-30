<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Result Details';
$ajaxFilePath= 'resultsdetailsAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$class_get=$os->get('studentClass');
$keyVal=$os->get('key');
$studentId_get=$os->get('studentId');
 ?>
<?if($keyVal=='selectedData')
{
?>
	<style>
	.hideForSelectedData{ display:none;}
	.btnStyle{ display:none;}
	</style>
<?}?>
  

 <table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm hideForSelectedData">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_resultsdetailsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_resultsdetailsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Results </td>
										<td><!--<input value="" type="text" name="resultsId" id="resultsId" class="textboxxx  fWidth "/> 
										-->
										
										<select name="resultsId" id="resultsId" class="textbox fWidth" ><option value=""></option>		  	<? 

										//$os->optionsHTML('','resultsId','studentId','results');
										$os->onlyOption($os->getResultA());?>
										</select>
										
										</td>						
										</tr><tr >
	  									<td>Exam</td>
										<td>
										<select name="examId" id="examId" class="textbox fWidth" ><option value=""></option>		  	<? 

										$os->optionsHTML('','examId','examTitle','exam');?>
										</select>
										</td>						
										</tr><tr >
	  									<td>Student</td>
										<td> <select name="studentId" id="studentId" class="textbox fWidth" ><option value=""></option>		  	<? 
								
										  $os->optionsHTML('','studentId','name','student');?>
							</select> </td>						
										</tr><tr >
	  									<td>Class </td>
										<td>  
	
	<select name="class" id="class" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>Exam Details </td>
										<td> <select name="examdetailsId" id="examdetailsId" class="textbox fWidth" ><option value=""></option>		  	<? 
								
										  //$os->optionsHTML('','examdetailsId','subjectCode','examdetails');
										  $os->onlyOption($os->getExamDetailsA());?>
							</select> </td>						
										</tr><tr >
	  									<td>Subject Name </td>
										<td> <select name="subjectName" id="subjectName" class="textbox fWidth" ><option value=""></option>		  	<? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select> </td>						
										</tr><tr >
	  									<td>Written Marks </td>
										<td><input value="" type="text" name="writtenMarks" id="writtenMarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Viva </td>
										<td><input value="" type="text" name="viva" id="viva" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Practical </td>
										<td><input value="" type="text" name="practical" id="practical" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total Marks </td>
										<td><input value="" type="text" name="totalMarks" id="totalMarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Percentage </td>
										<td><input value="" type="text" name="percentage" id="percentage" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Grade </td>
										<td><input value="" type="text" name="grade" id="grade" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->resultDetailsStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="resultsdetailsId" value="0" />	
	<input type="hidden"  id="WT_resultsdetailspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_resultsdetailsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_resultsdetailsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch hideForSelectedData">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 resultsId: <input type="text" class="wtTextClass" name="resultsId_s" id="resultsId_s" value="" /> &nbsp;  examId:
	
	
	<select name="examId" id="examId_s" class="textbox fWidth" ><option value="">Select examId</option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select>
   studentId: <input type="text" class="wtTextClass" name="studentId_s" id="studentId_s" value="<?echo $studentId_get?>" /> &nbsp;  Class:
	
	<select name="class" id="class_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList,$class_get);	?></select>	
   examdetailsId:
	
	
	<select name="examdetailsId" id="examdetailsId_s" class="textbox fWidth" ><option value="">Select examdetailsId</option>		  	<? 
								
										  $os->optionsHTML('','examdetailsId','subjectCode','examdetails');?>
							</select>
   Subject Name:
	
	
	<select name="subjectName" id="subjectName_s" class="textbox fWidth" ><option value="">Select Subject Name</option>		  	<? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select>
   Written Marks: <input type="text" class="wtTextClass" name="writtenMarks_s" id="writtenMarks_s" value="" /> &nbsp;  Viva: <input type="text" class="wtTextClass" name="viva_s" id="viva_s" value="" /> &nbsp;  Practical: <input type="text" class="wtTextClass" name="practical_s" id="practical_s" value="" /> &nbsp;  Total Marks: <input type="text" class="wtTextClass" name="totalMarks_s" id="totalMarks_s" value="" /> &nbsp;  Percentage: <input type="text" class="wtTextClass" name="percentage_s" id="percentage_s" value="" /> &nbsp;  Grade: <input type="text" class="wtTextClass" name="grade_s" id="grade_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->resultDetailsStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_resultsdetailsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_resultsdetailsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_resultsdetailsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var resultsId_sVal= os.getVal('resultsId_s'); 
 var examId_sVal= os.getVal('examId_s'); 
 var studentId_sVal= os.getVal('studentId_s'); 
 var class_sVal= os.getVal('class_s'); 
 var examdetailsId_sVal= os.getVal('examdetailsId_s'); 
 var subjectName_sVal= os.getVal('subjectName_s'); 
 var writtenMarks_sVal= os.getVal('writtenMarks_s'); 
 var viva_sVal= os.getVal('viva_s'); 
 var practical_sVal= os.getVal('practical_s'); 
 var totalMarks_sVal= os.getVal('totalMarks_s'); 
 var percentage_sVal= os.getVal('percentage_s'); 
 var grade_sVal= os.getVal('grade_s'); 
 var note_sVal= os.getVal('note_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('resultsId_s',resultsId_sVal );
formdata.append('examId_s',examId_sVal );
formdata.append('studentId_s',studentId_sVal );
formdata.append('class_s',class_sVal );
formdata.append('examdetailsId_s',examdetailsId_sVal );
formdata.append('subjectName_s',subjectName_sVal );
formdata.append('writtenMarks_s',writtenMarks_sVal );
formdata.append('viva_s',viva_sVal );
formdata.append('practical_s',practical_sVal );
formdata.append('totalMarks_s',totalMarks_sVal );
formdata.append('percentage_s',percentage_sVal );
formdata.append('grade_s',grade_sVal );
formdata.append('note_s',note_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_resultsdetailspagingPageno=os.getVal('WT_resultsdetailspagingPageno');
	var url='wtpage='+WT_resultsdetailspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_resultsdetailsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_resultsdetailsListDiv',url,formdata);
		
}

WT_resultsdetailsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('resultsId_s',''); 
 os.setVal('examId_s',''); 
 os.setVal('studentId_s',''); 
 os.setVal('class_s',''); 
 os.setVal('examdetailsId_s',''); 
 os.setVal('subjectName_s',''); 
 os.setVal('writtenMarks_s',''); 
 os.setVal('viva_s',''); 
 os.setVal('practical_s',''); 
 os.setVal('totalMarks_s',''); 
 os.setVal('percentage_s',''); 
 os.setVal('grade_s',''); 
 os.setVal('note_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_resultsdetailsListing();	
	
	}
	
 
function WT_resultsdetailsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var resultsIdVal= os.getVal('resultsId'); 
var examIdVal= os.getVal('examId'); 
var studentIdVal= os.getVal('studentId'); 
var classVal= os.getVal('class'); 
var examdetailsIdVal= os.getVal('examdetailsId'); 
var subjectNameVal= os.getVal('subjectName'); 
var writtenMarksVal= os.getVal('writtenMarks'); 
var vivaVal= os.getVal('viva'); 
var practicalVal= os.getVal('practical'); 
var totalMarksVal= os.getVal('totalMarks'); 
var percentageVal= os.getVal('percentage'); 
var gradeVal= os.getVal('grade'); 
var noteVal= os.getVal('note'); 
var statusVal= os.getVal('status'); 


 formdata.append('resultsId',resultsIdVal );
 formdata.append('examId',examIdVal );
 formdata.append('studentId',studentIdVal );
 formdata.append('class',classVal );
 formdata.append('examdetailsId',examdetailsIdVal );
 formdata.append('subjectName',subjectNameVal );
 formdata.append('writtenMarks',writtenMarksVal );
 formdata.append('viva',vivaVal );
 formdata.append('practical',practicalVal );
 formdata.append('totalMarks',totalMarksVal );
 formdata.append('percentage',percentageVal );
 formdata.append('grade',gradeVal );
 formdata.append('note',noteVal );
 formdata.append('status',statusVal );

	

	 var   resultsdetailsId=os.getVal('resultsdetailsId');
	 formdata.append('resultsdetailsId',resultsdetailsId );
  	var url='<? echo $ajaxFilePath ?>?WT_resultsdetailsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_resultsdetailsReLoadList',url,formdata);

}	

function WT_resultsdetailsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var resultsdetailsId=parseInt(d[0]);
	if(d[0]!='Error' && resultsdetailsId>0)
	{
	  os.setVal('resultsdetailsId',resultsdetailsId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_resultsdetailsListing();
}

function WT_resultsdetailsGetById(resultsdetailsId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('resultsdetailsId',resultsdetailsId );
	var url='<? echo $ajaxFilePath ?>?WT_resultsdetailsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_resultsdetailsFillData',url,formdata);
				
}

function WT_resultsdetailsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('resultsdetailsId',parseInt(objJSON.resultsdetailsId));
	
 os.setVal('resultsId',objJSON.resultsId); 
 os.setVal('examId',objJSON.examId); 
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('class',objJSON.class); 
 os.setVal('examdetailsId',objJSON.examdetailsId); 
 os.setVal('subjectName',objJSON.subjectName); 
 os.setVal('writtenMarks',objJSON.writtenMarks); 
 os.setVal('viva',objJSON.viva); 
 os.setVal('practical',objJSON.practical); 
 os.setVal('totalMarks',objJSON.totalMarks); 
 os.setVal('percentage',objJSON.percentage); 
 os.setVal('grade',objJSON.grade); 
 os.setVal('note',objJSON.note); 
 os.setVal('status',objJSON.status); 

  
}

function WT_resultsdetailsDeleteRowById(resultsdetailsId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(resultsdetailsId)<1 || resultsdetailsId==''){  
	var  resultsdetailsId =os.getVal('resultsdetailsId');
	}
	
	if(parseInt(resultsdetailsId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('resultsdetailsId',resultsdetailsId );
	
	var url='<? echo $ajaxFilePath ?>?WT_resultsdetailsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_resultsdetailsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_resultsdetailsDeleteRowByIdResults(data)
{
	alert(data);
	WT_resultsdetailsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_resultsdetailspagingPageno',parseInt(pageNo));
	WT_resultsdetailsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>