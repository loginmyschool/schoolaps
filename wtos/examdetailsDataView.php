<?
/*
   # wtos version : 1.1
   # main ajax process page : examdetailsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='List examdetails';
$ajaxFilePath= 'examdetailsAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_examdetailsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_examdetailsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Exam </td>
										<td> <select name="examId" id="examId" class="textbox fWidth" ><option value="">Select Exam</option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select> </td>						
										</tr><tr >
	  									<td>class </td>
										<td>  
	
	<select name="class" id="class" class="textbox fWidth" ><option value="">Select class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>Subject </td>
										<td> <select name="subjectId" id="subjectId" class="textbox fWidth" ><option value="">Select Subject</option>		  	<? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select> </td>						
										</tr><tr >
	  									<td>Subject Code </td>
										<td><input value="" type="text" name="subjectCode" id="subjectCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Start Date </td>
										<td><input value="" type="text" name="startDate" id="startDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>End Date </td>
										<td><input value="" type="text" name="endDate" id="endDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Written </td>
										<td><input value="" type="text" name="written" id="written" class="textboxxx  fWidth "/> </td>						
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
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->examDetailsStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="examdetailsId" value="0" />	
	<input type="hidden"  id="WT_examdetailspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_examdetailsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_examdetailsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Exam:
	
	
	<select name="examId" id="examId_s" class="textbox fWidth" ><option value="">Select Exam</option>		  	<? 
								
										  $os->optionsHTML('','examId','examTitle','exam');?>
							</select>
   class:
	
	<select name="class" id="class_s" class="textbox fWidth" ><option value="">Select class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	
   Subject:
	
	
	<select name="subjectId" id="subjectId_s" class="textbox fWidth" ><option value="">Select Subject</option>		  	<? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select>
   Subject Code: <input type="text" class="wtTextClass" name="subjectCode_s" id="subjectCode_s" value="" /> &nbsp; From Start Date: <input class="wtDateClass" type="text" name="f_startDate_s" id="f_startDate_s" value=""  /> &nbsp;   To Start Date: <input class="wtDateClass" type="text" name="t_startDate_s" id="t_startDate_s" value=""  /> &nbsp;  
  From End Date: <input class="wtDateClass" type="text" name="f_endDate_s" id="f_endDate_s" value=""  /> &nbsp;   To End Date: <input class="wtDateClass" type="text" name="t_endDate_s" id="t_endDate_s" value=""  /> &nbsp;  
   Written: <input type="text" class="wtTextClass" name="written_s" id="written_s" value="" /> &nbsp;  Viva: <input type="text" class="wtTextClass" name="viva_s" id="viva_s" value="" /> &nbsp;  Practical: <input type="text" class="wtTextClass" name="practical_s" id="practical_s" value="" /> &nbsp;  Total Marks: <input type="text" class="wtTextClass" name="totalMarks_s" id="totalMarks_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->examDetailsStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_examdetailsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_examdetailsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_examdetailsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var examId_sVal= os.getVal('examId_s'); 
 var class_sVal= os.getVal('class_s'); 
 var subjectId_sVal= os.getVal('subjectId_s'); 
 var subjectCode_sVal= os.getVal('subjectCode_s'); 
 var f_startDate_sVal= os.getVal('f_startDate_s'); 
 var t_startDate_sVal= os.getVal('t_startDate_s'); 
 var f_endDate_sVal= os.getVal('f_endDate_s'); 
 var t_endDate_sVal= os.getVal('t_endDate_s'); 
 var written_sVal= os.getVal('written_s'); 
 var viva_sVal= os.getVal('viva_s'); 
 var practical_sVal= os.getVal('practical_s'); 
 var totalMarks_sVal= os.getVal('totalMarks_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('examId_s',examId_sVal );
formdata.append('class_s',class_sVal );
formdata.append('subjectId_s',subjectId_sVal );
formdata.append('subjectCode_s',subjectCode_sVal );
formdata.append('f_startDate_s',f_startDate_sVal );
formdata.append('t_startDate_s',t_startDate_sVal );
formdata.append('f_endDate_s',f_endDate_sVal );
formdata.append('t_endDate_s',t_endDate_sVal );
formdata.append('written_s',written_sVal );
formdata.append('viva_s',viva_sVal );
formdata.append('practical_s',practical_sVal );
formdata.append('totalMarks_s',totalMarks_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_examdetailspagingPageno=os.getVal('WT_examdetailspagingPageno');
	var url='wtpage='+WT_examdetailspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_examdetailsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_examdetailsListDiv',url,formdata);
		
}

WT_examdetailsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('examId_s',''); 
 os.setVal('class_s',''); 
 os.setVal('subjectId_s',''); 
 os.setVal('subjectCode_s',''); 
 os.setVal('f_startDate_s',''); 
 os.setVal('t_startDate_s',''); 
 os.setVal('f_endDate_s',''); 
 os.setVal('t_endDate_s',''); 
 os.setVal('written_s',''); 
 os.setVal('viva_s',''); 
 os.setVal('practical_s',''); 
 os.setVal('totalMarks_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_examdetailsListing();	
	
	}
	
 
function WT_examdetailsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var examIdVal= os.getVal('examId'); 
var classVal= os.getVal('class'); 
var subjectIdVal= os.getVal('subjectId'); 
var subjectCodeVal= os.getVal('subjectCode'); 
var startDateVal= os.getVal('startDate'); 
var endDateVal= os.getVal('endDate'); 
var writtenVal= os.getVal('written'); 
var vivaVal= os.getVal('viva'); 
var practicalVal= os.getVal('practical'); 
var totalMarksVal= os.getVal('totalMarks'); 
var statusVal= os.getVal('status'); 


 formdata.append('examId',examIdVal );
 formdata.append('class',classVal );
 formdata.append('subjectId',subjectIdVal );
 formdata.append('subjectCode',subjectCodeVal );
 formdata.append('startDate',startDateVal );
 formdata.append('endDate',endDateVal );
 formdata.append('written',writtenVal );
 formdata.append('viva',vivaVal );
 formdata.append('practical',practicalVal );
 formdata.append('totalMarks',totalMarksVal );
 formdata.append('status',statusVal );

	

	 var   examdetailsId=os.getVal('examdetailsId');
	 formdata.append('examdetailsId',examdetailsId );
  	var url='<? echo $ajaxFilePath ?>?WT_examdetailsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_examdetailsReLoadList',url,formdata);

}	

function WT_examdetailsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var examdetailsId=parseInt(d[0]);
	if(d[0]!='Error' && examdetailsId>0)
	{
	  os.setVal('examdetailsId',examdetailsId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_examdetailsListing();
}

function WT_examdetailsGetById(examdetailsId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('examdetailsId',examdetailsId );
	var url='<? echo $ajaxFilePath ?>?WT_examdetailsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_examdetailsFillData',url,formdata);
				
}

function WT_examdetailsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('examdetailsId',parseInt(objJSON.examdetailsId));
	
 os.setVal('examId',objJSON.examId); 
 os.setVal('class',objJSON.class); 
 os.setVal('subjectId',objJSON.subjectId); 
 os.setVal('subjectCode',objJSON.subjectCode); 
 os.setVal('startDate',objJSON.startDate); 
 os.setVal('endDate',objJSON.endDate); 
 os.setVal('written',objJSON.written); 
 os.setVal('viva',objJSON.viva); 
 os.setVal('practical',objJSON.practical); 
 os.setVal('totalMarks',objJSON.totalMarks); 
 os.setVal('status',objJSON.status); 

  
}

function WT_examdetailsDeleteRowById(examdetailsId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(examdetailsId)<1 || examdetailsId==''){  
	var  examdetailsId =os.getVal('examdetailsId');
	}
	
	if(parseInt(examdetailsId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('examdetailsId',examdetailsId );
	
	var url='<? echo $ajaxFilePath ?>?WT_examdetailsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_examdetailsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_examdetailsDeleteRowByIdResults(data)
{
	alert(data);
	WT_examdetailsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_examdetailspagingPageno',parseInt(pageNo));
	WT_examdetailsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>