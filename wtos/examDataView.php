<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Exam';
$ajaxFilePath= 'examAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_examDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_examEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Exam Title </td>
										<td><input value="" type="text" name="examTitle" id="examTitle" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Description </td>
										<td><textarea  name="description" id="description" ></textarea></td>						
										</tr><tr >
	  									<td>Start date </td>
										<td><input value="" type="text" name="startdate" id="startdate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Exam Code </td>
										<td><input value="" type="text" name="examCode" id="examCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Class </td>
										<td>  
	
	<select name="class" id="class" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>Year </td>
										<td>  
	
	<select name="year" id="year" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										  $os->onlyOption($os->examYear);	?></select>	 </td>						
										</tr><tr >
	  									<td>Month </td>
										<td>  
	
	<select name="month" id="month" class="textbox fWidth" ><option value="">Select Month</option>	<? 
										  $os->onlyOption($os->examMonth);	?></select>	 </td>						
										</tr><tr >
	  									<td>Exam Type </td>
										<td>  
	
	<select name="examType" id="examType" class="textbox fWidth" ><option value="">Select Exam Type</option>	<? 
										  $os->onlyOption($os->examType);	?></select>	 </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->examStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr><tr >
	  									<td>Document 1 </td>
										<td>
										
										<img id="docs_file1Preview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="docs_file1" value=""  id="docs_file1" onchange="os.readURL(this,'docs_file1Preview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('docs_file1');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Document 2 </td>
										<td>
										
										<img id="docs_file2Preview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="docs_file2" value=""  id="docs_file2" onchange="os.readURL(this,'docs_file2Preview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('docs_file2');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Instractions </td>
										<td><textarea  name="instractions" id="instractions" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="examId" value="0" />	
	<input type="hidden"  id="WT_exampagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_examDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_examEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Exam Title: <input type="text" class="wtTextClass" name="examTitle_s" id="examTitle_s" value="" /> &nbsp;  Description: <input type="text" class="wtTextClass" name="description_s" id="description_s" value="" /> &nbsp; From Start date: <input class="wtDateClass" type="text" name="f_startdate_s" id="f_startdate_s" value=""  /> &nbsp;   To Start date: <input class="wtDateClass" type="text" name="t_startdate_s" id="t_startdate_s" value=""  /> &nbsp;  
   Exam Code: <input type="text" class="wtTextClass" name="examCode_s" id="examCode_s" value="" /> &nbsp;  Class:
	
	<select name="class" id="class_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	
   Year:
	
	<select name="year" id="year_s" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										  $os->onlyOption($os->examYear);	?></select>	
   Month:
	
	<select name="month" id="month_s" class="textbox fWidth" ><option value="">Select Month</option>	<? 
										  $os->onlyOption($os->examMonth);	?></select>	
   Exam Type:
	
	<select name="examType" id="examType_s" class="textbox fWidth" ><option value="">Select Exam Type</option>	<? 
										  $os->onlyOption($os->examType);	?></select>	
   Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->examStatus);	?></select>	
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;    Instractions: <input type="text" class="wtTextClass" name="instractions_s" id="instractions_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_examListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_examListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_examListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var examTitle_sVal= os.getVal('examTitle_s'); 
 var description_sVal= os.getVal('description_s'); 
 var f_startdate_sVal= os.getVal('f_startdate_s'); 
 var t_startdate_sVal= os.getVal('t_startdate_s'); 
 var examCode_sVal= os.getVal('examCode_s'); 
 var class_sVal= os.getVal('class_s'); 
 var year_sVal= os.getVal('year_s'); 
 var month_sVal= os.getVal('month_s'); 
 var examType_sVal= os.getVal('examType_s'); 
 var status_sVal= os.getVal('status_s'); 
 var note_sVal= os.getVal('note_s'); 
 var instractions_sVal= os.getVal('instractions_s'); 
formdata.append('examTitle_s',examTitle_sVal );
formdata.append('description_s',description_sVal );
formdata.append('f_startdate_s',f_startdate_sVal );
formdata.append('t_startdate_s',t_startdate_sVal );
formdata.append('examCode_s',examCode_sVal );
formdata.append('class_s',class_sVal );
formdata.append('year_s',year_sVal );
formdata.append('month_s',month_sVal );
formdata.append('examType_s',examType_sVal );
formdata.append('status_s',status_sVal );
formdata.append('note_s',note_sVal );
formdata.append('instractions_s',instractions_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_exampagingPageno=os.getVal('WT_exampagingPageno');
	var url='wtpage='+WT_exampagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_examListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_examListDiv',url,formdata);
		
}

WT_examListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('examTitle_s',''); 
 os.setVal('description_s',''); 
 os.setVal('f_startdate_s',''); 
 os.setVal('t_startdate_s',''); 
 os.setVal('examCode_s',''); 
 os.setVal('class_s',''); 
 os.setVal('year_s',''); 
 os.setVal('month_s',''); 
 os.setVal('examType_s',''); 
 os.setVal('status_s',''); 
 os.setVal('note_s',''); 
 os.setVal('instractions_s',''); 
	
		os.setVal('searchKey','');
		WT_examListing();	
	
	}
	
 
function WT_examEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var examTitleVal= os.getVal('examTitle'); 
var descriptionVal= os.getVal('description'); 
var startdateVal= os.getVal('startdate'); 
var examCodeVal= os.getVal('examCode'); 
var classVal= os.getVal('class'); 
var yearVal= os.getVal('year'); 
var monthVal= os.getVal('month'); 
var examTypeVal= os.getVal('examType'); 
var statusVal= os.getVal('status'); 
var noteVal= os.getVal('note'); 
var docs_file1Val= os.getObj('docs_file1').files[0]; 
var docs_file2Val= os.getObj('docs_file2').files[0]; 
//var instractionsVal= os.getVal('instractions');


var instractionsVal=tinyMCE.get("instractions").getContent();   


 formdata.append('examTitle',examTitleVal );
 formdata.append('description',descriptionVal );
 formdata.append('startdate',startdateVal );
 formdata.append('examCode',examCodeVal );
 formdata.append('class',classVal );
 formdata.append('year',yearVal );
 formdata.append('month',monthVal );
 formdata.append('examType',examTypeVal );
 formdata.append('status',statusVal );
 formdata.append('note',noteVal );
if(docs_file1Val){  formdata.append('docs_file1',docs_file1Val,docs_file1Val.name );}
if(docs_file2Val){  formdata.append('docs_file2',docs_file2Val,docs_file2Val.name );}
 formdata.append('instractions',instractionsVal );

	

	 var   examId=os.getVal('examId');
	 formdata.append('examId',examId );
  	var url='<? echo $ajaxFilePath ?>?WT_examEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_examReLoadList',url,formdata);

}	

function WT_examReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var examId=parseInt(d[0]);
	if(d[0]!='Error' && examId>0)
	{
	  os.setVal('examId',examId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_examListing();
}

function WT_examGetById(examId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('examId',examId );
	var url='<? echo $ajaxFilePath ?>?WT_examGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_examFillData',url,formdata);
				
}

function WT_examFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('examId',parseInt(objJSON.examId));
	
 os.setVal('examTitle',objJSON.examTitle); 
 os.setVal('description',objJSON.description); 
 os.setVal('startdate',objJSON.startdate); 
 os.setVal('examCode',objJSON.examCode); 
 os.setVal('class',objJSON.class); 
 os.setVal('year',objJSON.year); 
 os.setVal('month',objJSON.month); 
 os.setVal('examType',objJSON.examType); 
 os.setVal('status',objJSON.status); 
 os.setVal('note',objJSON.note); 
 os.setImg('docs_file1Preview',objJSON.docs_file1); 
 os.setImg('docs_file2Preview',objJSON.docs_file2); 
 //os.setVal('instractions',objJSON.instractions); 
 tinyMCE.get('instractions').setContent(objJSON.instractions); 

  
}

function WT_examDeleteRowById(examId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(examId)<1 || examId==''){  
	var  examId =os.getVal('examId');
	}
	
	if(parseInt(examId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('examId',examId );
	
	var url='<? echo $ajaxFilePath ?>?WT_examDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_examDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_examDeleteRowByIdResults(data)
{
	alert(data);
	WT_examListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_exampagingPageno',parseInt(pageNo));
	WT_examListing();
}

	
	
	
	 
	 
</script>

 <? include('tinyMCE.php'); ?>
<script>
tmce('instractions');
</script>
  
 
<? include($site['root-wtos'].'bottom.php'); ?>