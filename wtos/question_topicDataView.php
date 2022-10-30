<?
/*
   # wtos version : 1.1
   # main ajax process page : question_topicAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List question_topic';
$ajaxFilePath= 'question_topicAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
  $os->active_status=array('Yes'=>'Yes','No'=>'No');
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_topicDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_question_topicEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Chapter </td>
										<td> <select name="question_chapter_id" id="question_chapter_id" class="textbox fWidth" ><option value="">Select Chapter</option>		  	<? 
								
										  $os->optionsHTML('','question_chapter_id','title','question_chapter');?>
							</select> </td>						
										</tr><tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->active_status);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="question_topic_id" value="0" />	
	<input type="hidden"  id="WT_question_topicpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_topicDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_question_topicEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 ID: <input type="text" class="wtTextClass" name="question_topic_id_s" id="question_topic_id_s" value="" /> &nbsp;  Chapter:
	
	
	<select name="question_chapter_id" id="question_chapter_id_s" class="textbox fWidth" ><option value="">Select Chapter</option>		  	<? 
								
										  $os->optionsHTML('','question_chapter_id','title','question_chapter');?>
							</select>
   Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->active_status);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_question_topicListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_question_topicListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_question_topicListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var question_topic_id_sVal= os.getVal('question_topic_id_s'); 
 var question_chapter_id_sVal= os.getVal('question_chapter_id_s'); 
 var title_sVal= os.getVal('title_s'); 
 var active_status_sVal= os.getVal('active_status_s'); 
formdata.append('question_topic_id_s',question_topic_id_sVal );
formdata.append('question_chapter_id_s',question_chapter_id_sVal );
formdata.append('title_s',title_sVal );
formdata.append('active_status_s',active_status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_question_topicpagingPageno=os.getVal('WT_question_topicpagingPageno');
	var url='wtpage='+WT_question_topicpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_question_topicListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_question_topicListDiv',url,formdata);
		
}

WT_question_topicListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('question_topic_id_s',''); 
 os.setVal('question_chapter_id_s',''); 
 os.setVal('title_s',''); 
 os.setVal('active_status_s',''); 
	
		os.setVal('searchKey','');
		WT_question_topicListing();	
	
	}
	
 
function WT_question_topicEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var question_chapter_idVal= os.getVal('question_chapter_id'); 
var titleVal= os.getVal('title'); 
var active_statusVal= os.getVal('active_status'); 


 formdata.append('question_chapter_id',question_chapter_idVal );
 formdata.append('title',titleVal );
 formdata.append('active_status',active_statusVal );

	
if(os.check.empty('question_chapter_id','Please Add Chapter')==false){ return false;} 
if(os.check.empty('title','Please Add Title')==false){ return false;} 
if(os.check.empty('active_status','Please Add Status')==false){ return false;} 

	 var   question_topic_id=os.getVal('question_topic_id');
	 formdata.append('question_topic_id',question_topic_id );
  	var url='<? echo $ajaxFilePath ?>?WT_question_topicEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_topicReLoadList',url,formdata);

}	

function WT_question_topicReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var question_topic_id=parseInt(d[0]);
	if(d[0]!='Error' && question_topic_id>0)
	{
	  os.setVal('question_topic_id',question_topic_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_question_topicListing();
}

function WT_question_topicGetById(question_topic_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('question_topic_id',question_topic_id );
	var url='<? echo $ajaxFilePath ?>?WT_question_topicGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_topicFillData',url,formdata);
				
}

function WT_question_topicFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('question_topic_id',parseInt(objJSON.question_topic_id));
	
 os.setVal('question_chapter_id',objJSON.question_chapter_id); 
 os.setVal('title',objJSON.title); 
 os.setVal('active_status',objJSON.active_status); 

  
}

function WT_question_topicDeleteRowById(question_topic_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(question_topic_id)<1 || question_topic_id==''){  
	var  question_topic_id =os.getVal('question_topic_id');
	}
	
	if(parseInt(question_topic_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('question_topic_id',question_topic_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_question_topicDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_topicDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_question_topicDeleteRowByIdResults(data)
{
	alert(data);
	WT_question_topicListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_question_topicpagingPageno',parseInt(pageNo));
	WT_question_topicListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>