<?
/*
   # wtos version : 1.1
   # main ajax process page : eclassAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List eclass';
$ajaxFilePath= 'eclassAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_eclassDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_eclassEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Teacher </td>
										<td>  
	
	<select name="adminId" id="adminId" class="textbox fWidth" ><option value="">Select Teacher</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr><tr >
	  									<td>Session </td>
										<td>  
	
	<select name="asession" id="asession" class="textbox fWidth" ><option value="">Select Session</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr><tr >
	  									<td>Class </td>
										<td>  
	
	<select name="class" id="class" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr><tr >
	  									<td>Subject </td>
										<td>  
	
	<select name="subject_id" id="subject_id" class="textbox fWidth" ><option value="">Select Subject</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr><tr >
	  									<td>chapter </td>
										<td>  
	
	<select name="chapter" id="chapter" class="textbox fWidth" ><option value="">Select chapter</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr><tr >
	  									<td>topic </td>
										<td>  
	
	<select name="topic" id="topic" class="textbox fWidth" ><option value="">Select topic</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr><tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Kewords </td>
										<td><textarea  name="search_keys" id="search_keys" ></textarea></td>						
										</tr><tr >
	  									<td>Description </td>
										<td><textarea  name="description" id="description" ></textarea></td>						
										</tr><tr >
	  									<td>Image </td>
										<td>
										
										<img id="description_imagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="description_image" value=""  id="description_image" onchange="os.readURL(this,'description_imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('description_image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Video </td>
										<td>
										
										<img id="video_filePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="video_file" value=""  id="video_file" onchange="os.readURL(this,'video_filePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('video_file');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Video Link </td>
										<td><input value="" type="text" name="video_link" id="video_link" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Is Meeting </td>
										<td><input value="" type="text" name="is_meeting" id="is_meeting" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Meeting ID </td>
										<td><input value="" type="text" name="meeting_id" id="meeting_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Meeting Password </td>
										<td><input value="" type="text" name="meeting_password" id="meeting_password" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Meeting Link </td>
										<td><input value="" type="text" name="meeting_link" id="meeting_link" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Meeting Title </td>
										<td><input value="" type="text" name="meeting_title" id="meeting_title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Meeting Time </td>
										<td><input value="" type="text" name="meeting_time" id="meeting_time" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Study Materials </td>
										<td>
										
										<img id="study_materialsPreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="study_materials" value=""  id="study_materials" onchange="os.readURL(this,'study_materialsPreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('study_materials');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Home Work </td>
										<td>
										
										<img id="homeworkPreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="homework" value=""  id="homework" onchange="os.readURL(this,'homeworkPreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('homework');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="eclass_id" value="0" />	
	<input type="hidden"  id="WT_eclasspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_eclassDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_eclassEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Session:
	
	<select name="asession" id="asession_s" class="textbox fWidth" ><option value="">Select Session</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	
   Class:
	
	<select name="class" id="class_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	
   Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Kewords: <input type="text" class="wtTextClass" name="search_keys_s" id="search_keys_s" value="" /> &nbsp;  Description: <input type="text" class="wtTextClass" name="description_s" id="description_s" value="" /> &nbsp;  Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_eclassListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_eclassListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_eclassListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var asession_sVal= os.getVal('asession_s'); 
 var class_sVal= os.getVal('class_s'); 
 var title_sVal= os.getVal('title_s'); 
 var search_keys_sVal= os.getVal('search_keys_s'); 
 var description_sVal= os.getVal('description_s'); 
 var active_status_sVal= os.getVal('active_status_s'); 
formdata.append('asession_s',asession_sVal );
formdata.append('class_s',class_sVal );
formdata.append('title_s',title_sVal );
formdata.append('search_keys_s',search_keys_sVal );
formdata.append('description_s',description_sVal );
formdata.append('active_status_s',active_status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_eclasspagingPageno=os.getVal('WT_eclasspagingPageno');
	var url='wtpage='+WT_eclasspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_eclassListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_eclassListDiv',url,formdata);
		
}

WT_eclassListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('asession_s',''); 
 os.setVal('class_s',''); 
 os.setVal('title_s',''); 
 os.setVal('search_keys_s',''); 
 os.setVal('description_s',''); 
 os.setVal('active_status_s',''); 
	
		os.setVal('searchKey','');
		WT_eclassListing();	
	
	}
	
 
function WT_eclassEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var adminIdVal= os.getVal('adminId'); 
var asessionVal= os.getVal('asession'); 
var classVal= os.getVal('class'); 
var subject_idVal= os.getVal('subject_id'); 
var chapterVal= os.getVal('chapter'); 
var topicVal= os.getVal('topic'); 
var titleVal= os.getVal('title'); 
var search_keysVal= os.getVal('search_keys'); 
var descriptionVal= os.getVal('description'); 
var description_imageVal= os.getObj('description_image').files[0]; 
var video_fileVal= os.getObj('video_file').files[0]; 
var video_linkVal= os.getVal('video_link'); 
var datedVal= os.getVal('dated'); 
var is_meetingVal= os.getVal('is_meeting'); 
var meeting_idVal= os.getVal('meeting_id'); 
var meeting_passwordVal= os.getVal('meeting_password'); 
var meeting_linkVal= os.getVal('meeting_link'); 
var meeting_titleVal= os.getVal('meeting_title'); 
var meeting_timeVal= os.getVal('meeting_time'); 
var study_materialsVal= os.getObj('study_materials').files[0]; 
var homeworkVal= os.getObj('homework').files[0]; 
var active_statusVal= os.getVal('active_status'); 


 formdata.append('adminId',adminIdVal );
 formdata.append('asession',asessionVal );
 formdata.append('class',classVal );
 formdata.append('subject_id',subject_idVal );
 formdata.append('chapter',chapterVal );
 formdata.append('topic',topicVal );
 formdata.append('title',titleVal );
 formdata.append('search_keys',search_keysVal );
 formdata.append('description',descriptionVal );
if(description_imageVal){  formdata.append('description_image',description_imageVal,description_imageVal.name );}
if(video_fileVal){  formdata.append('video_file',video_fileVal,video_fileVal.name );}
 formdata.append('video_link',video_linkVal );
 formdata.append('dated',datedVal );
 formdata.append('is_meeting',is_meetingVal );
 formdata.append('meeting_id',meeting_idVal );
 formdata.append('meeting_password',meeting_passwordVal );
 formdata.append('meeting_link',meeting_linkVal );
 formdata.append('meeting_title',meeting_titleVal );
 formdata.append('meeting_time',meeting_timeVal );
if(study_materialsVal){  formdata.append('study_materials',study_materialsVal,study_materialsVal.name );}
if(homeworkVal){  formdata.append('homework',homeworkVal,homeworkVal.name );}
 formdata.append('active_status',active_statusVal );

	
if(os.check.empty('asession','Please Add Session')==false){ return false;} 
if(os.check.empty('class','Please Add Class')==false){ return false;} 
if(os.check.empty('subject_id','Please Add Subject')==false){ return false;} 
if(os.check.empty('title','Please Add Title')==false){ return false;} 
if(os.check.empty('description','Please Add Description')==false){ return false;} 
if(os.check.empty('description_image','Please Add Image')==false){ return false;} 
if(os.check.empty('dated','Please Add Date')==false){ return false;} 
if(os.check.empty('active_status','Please Add Status')==false){ return false;} 

	 var   eclass_id=os.getVal('eclass_id');
	 formdata.append('eclass_id',eclass_id );
  	var url='<? echo $ajaxFilePath ?>?WT_eclassEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_eclassReLoadList',url,formdata);

}	

function WT_eclassReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var eclass_id=parseInt(d[0]);
	if(d[0]!='Error' && eclass_id>0)
	{
	  os.setVal('eclass_id',eclass_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_eclassListing();
}

function WT_eclassGetById(eclass_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('eclass_id',eclass_id );
	var url='<? echo $ajaxFilePath ?>?WT_eclassGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_eclassFillData',url,formdata);
				
}

function WT_eclassFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('eclass_id',parseInt(objJSON.eclass_id));
	
 os.setVal('adminId',objJSON.adminId); 
 os.setVal('asession',objJSON.asession); 
 os.setVal('class',objJSON.class); 
 os.setVal('subject_id',objJSON.subject_id); 
 os.setVal('chapter',objJSON.chapter); 
 os.setVal('topic',objJSON.topic); 
 os.setVal('title',objJSON.title); 
 os.setVal('search_keys',objJSON.search_keys); 
 os.setVal('description',objJSON.description); 
 os.setImg('description_imagePreview',objJSON.description_image); 
 os.setImg('video_filePreview',objJSON.video_file); 
 os.setVal('video_link',objJSON.video_link); 
 os.setVal('dated',objJSON.dated); 
 os.setVal('is_meeting',objJSON.is_meeting); 
 os.setVal('meeting_id',objJSON.meeting_id); 
 os.setVal('meeting_password',objJSON.meeting_password); 
 os.setVal('meeting_link',objJSON.meeting_link); 
 os.setVal('meeting_title',objJSON.meeting_title); 
 os.setVal('meeting_time',objJSON.meeting_time); 
 os.setImg('study_materialsPreview',objJSON.study_materials); 
 os.setImg('homeworkPreview',objJSON.homework); 
 os.setVal('active_status',objJSON.active_status); 

  
}

function WT_eclassDeleteRowById(eclass_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(eclass_id)<1 || eclass_id==''){  
	var  eclass_id =os.getVal('eclass_id');
	}
	
	if(parseInt(eclass_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('eclass_id',eclass_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_eclassDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_eclassDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_eclassDeleteRowByIdResults(data)
{
	alert(data);
	WT_eclassListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_eclasspagingPageno',parseInt(pageNo));
	WT_eclassListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>