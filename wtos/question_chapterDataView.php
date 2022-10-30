<?
/*
   # wtos version : 1.1
   # main ajax process page : question_chapterAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Chapter';
$ajaxFilePath= 'question_chapterAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_chapterDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_question_chapterEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Class </td>
										<td> <select name="class_id" id="class_id" class="textbox fWidth"
										 onchange="wt_ajax_chain('html*subject_id*subject,subjectId,subjectName*classId=class_id','','','');"			
										 ><option value="">Select Class</option>		  	<? 
								
										  $os->onlyOption($os->classList);?>
							</select> </td>						
										</tr>
										
										<tr >
	  									<td>Subject </td>
										<td> <select name="subject_id" id="subject_id" class="textbox fWidth" ><option value="">Select Subject</option>		  	<? 
								
										 // $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select> </td>						
										</tr>
										
										
										<tr>
	  									<td>Chapter Name </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr>	
										
										<tr id="more_chapter">
	  									<td><span class="" uk-toggle="target: #toggle-usage">Add More Chapter</span> </td>
										<td>  
    <p id="toggle-usage"><input value="" type="text" name="title_chapter[]" id="title" class="textboxxx  fWidth "/></p> </td>						
										</tr>
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="question_chapter_id" value="0" />	
	<input type="hidden"  id="WT_question_chapterpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_chapterDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_question_chapterEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 ID: <input type="text" class="wtTextClass" name="question_chapter_id_s" id="question_chapter_id_s" value="" /> &nbsp;  Class:
	
	
	<select name="class_id" id="class_id_s" class="textbox fWidth" ><option value="">Select Class</option>		  	<? 
								
										  $os->optionsHTML('','classList','1','2');?>
							</select>
   Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Subject:
	
	
	<select name="subject_id" id="subject_id_s" class="textbox fWidth" ><option value="">Select Subject</option>		  	<? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select>
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_question_chapterListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_question_chapterListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_question_chapterListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var question_chapter_id_sVal= os.getVal('question_chapter_id_s'); 
 var class_id_sVal= os.getVal('class_id_s'); 
 var title_sVal= os.getVal('title_s'); 
 var subject_id_sVal= os.getVal('subject_id_s'); 
formdata.append('question_chapter_id_s',question_chapter_id_sVal );
formdata.append('class_id_s',class_id_sVal );
formdata.append('title_s',title_sVal );
formdata.append('subject_id_s',subject_id_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_question_chapterpagingPageno=os.getVal('WT_question_chapterpagingPageno');
	var url='wtpage='+WT_question_chapterpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_question_chapterListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_question_chapterListDiv',url,formdata);
		
}

WT_question_chapterListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('question_chapter_id_s',''); 
 os.setVal('class_id_s',''); 
 os.setVal('title_s',''); 
 os.setVal('subject_id_s',''); 
	
		os.setVal('searchKey','');
		WT_question_chapterListing();	
	
	}
	
 
function WT_question_chapterEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var class_idVal= os.getVal('class_id'); 
var titleVal= os.getVal('title'); 
var subject_idVal= os.getVal('subject_id'); 


 formdata.append('class_id',class_idVal );
 formdata.append('title',titleVal );
 formdata.append('subject_id',subject_idVal );

	
if(os.check.empty('class_id','Please Add Class')==false){ return false;} 
if(os.check.empty('title','Please Add Title')==false){ return false;} 
if(os.check.empty('subject_id','Please Add Subject')==false){ return false;} 

	 var   question_chapter_id=os.getVal('question_chapter_id');
	 formdata.append('question_chapter_id',question_chapter_id );
  	var url='<? echo $ajaxFilePath ?>?WT_question_chapterEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_chapterReLoadList',url,formdata);

}	

function WT_question_chapterReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var question_chapter_id=parseInt(d[0]);
	if(d[0]!='Error' && question_chapter_id>0)
	{
	  os.setVal('question_chapter_id',question_chapter_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_question_chapterListing();
}

function WT_question_chapterGetById(question_chapter_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('question_chapter_id',question_chapter_id );
	var url='<? echo $ajaxFilePath ?>?WT_question_chapterGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_chapterFillData',url,formdata);
				
}

function WT_question_chapterFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('question_chapter_id',parseInt(objJSON.question_chapter_id));
	
 os.setVal('class_id',objJSON.class_id); 
 os.setVal('title',objJSON.title); 
 os.setVal('subject_id',objJSON.subject_id); 

  
}

function WT_question_chapterDeleteRowById(question_chapter_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(question_chapter_id)<1 || question_chapter_id==''){  
	var  question_chapter_id =os.getVal('question_chapter_id');
	}
	
	if(parseInt(question_chapter_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('question_chapter_id',question_chapter_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_question_chapterDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_chapterDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_question_chapterDeleteRowByIdResults(data)
{
	alert(data);
	WT_question_chapterListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_question_chapterpagingPageno',parseInt(pageNo));
	WT_question_chapterListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>