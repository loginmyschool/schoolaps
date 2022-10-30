<?
/*
   # wtos version : 1.1
   # main ajax process page : question_raw_dataAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Question Data';
$ajaxFilePath= 'question_raw_dataAjax.php';
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
    <td width="570" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_raw_dataDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_question_raw_dataEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Subject </td>
										<td><input value="" type="text" name="subject" id="subject" class="textboxxx  fWidth " style="width:500px;"/> </td>						
										</tr><tr >
	  									<td>Chapter </td>
										<td><input value="" type="text" name="chapter" id="chapter" class="textboxxx  fWidth " style="width:500px;"/> </td>						
										</tr><tr >
	  									<td>Topic </td>
										<td><input value="" type="text" name="topic" id="topic" class="textboxxx  fWidth " style="width:500px;"/> </td>						
										</tr><tr >
	  									<td>Question Data </td>
										<td>
										
										<textarea name="question_data" id="question_data" class="textboxxx  fWidth "    style="width:500px; height:300px;" ></textarea>
										
										</td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="question_raw_data_id" value="0" />	
	<input type="hidden"  id="WT_question_raw_datapagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_question_raw_dataDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_question_raw_dataEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Subject: <input type="text" class="wtTextClass" name="subject_s" id="subject_s" value="" /> &nbsp;  Chapter: <input type="text" class="wtTextClass" name="chapter_s" id="chapter_s" value="" /> &nbsp;  Topic: <input type="text" class="wtTextClass" name="topic_s" id="topic_s" value="" /> &nbsp;  Question Data: <input type="text" class="wtTextClass" name="question_data_s" id="question_data_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_question_raw_dataListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
 
  
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_question_raw_dataListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_question_raw_dataListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var subject_sVal= os.getVal('subject_s'); 
 var chapter_sVal= os.getVal('chapter_s'); 
 var topic_sVal= os.getVal('topic_s'); 
 var question_data_sVal= os.getVal('question_data_s'); 
formdata.append('subject_s',subject_sVal );
formdata.append('chapter_s',chapter_sVal );
formdata.append('topic_s',topic_sVal );
formdata.append('question_data_s',question_data_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_question_raw_datapagingPageno=os.getVal('WT_question_raw_datapagingPageno');
	var url='wtpage='+WT_question_raw_datapagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_question_raw_dataListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_question_raw_dataListDiv',url,formdata);
		
}

WT_question_raw_dataListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('subject_s',''); 
 os.setVal('chapter_s',''); 
 os.setVal('topic_s',''); 
 os.setVal('question_data_s',''); 
	
		os.setVal('searchKey','');
		WT_question_raw_dataListing();	
	
	}
	
 
function WT_question_raw_dataEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var subjectVal= os.getVal('subject'); 
var chapterVal= os.getVal('chapter'); 
var topicVal= os.getVal('topic'); 
var question_dataVal= os.getVal('question_data'); 


 formdata.append('subject',subjectVal );
 formdata.append('chapter',chapterVal );
 formdata.append('topic',topicVal );
 formdata.append('question_data',question_dataVal );

	

	 var   question_raw_data_id=os.getVal('question_raw_data_id');
	 formdata.append('question_raw_data_id',question_raw_data_id );
  	var url='<? echo $ajaxFilePath ?>?WT_question_raw_dataEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_raw_dataReLoadList',url,formdata);

}	

function WT_question_raw_dataReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var question_raw_data_id=parseInt(d[0]);
	if(d[0]!='Error' && question_raw_data_id>0)
	{
	  os.setVal('question_raw_data_id',question_raw_data_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_question_raw_dataListing();
}

function WT_question_raw_dataGetById(question_raw_data_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('question_raw_data_id',question_raw_data_id );
	var url='<? echo $ajaxFilePath ?>?WT_question_raw_dataGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_raw_dataFillData',url,formdata);
				
}

function WT_question_raw_dataFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('question_raw_data_id',parseInt(objJSON.question_raw_data_id));
	
 os.setVal('subject',objJSON.subject); 
 os.setVal('chapter',objJSON.chapter); 
 os.setVal('topic',objJSON.topic); 
 os.setVal('question_data',objJSON.question_data); 

  
}

function WT_question_raw_dataDeleteRowById(question_raw_data_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(question_raw_data_id)<1 || question_raw_data_id==''){  
	var  question_raw_data_id =os.getVal('question_raw_data_id');
	}
	
	if(parseInt(question_raw_data_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('question_raw_data_id',question_raw_data_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_question_raw_dataDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_question_raw_dataDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_question_raw_dataDeleteRowByIdResults(data)
{
	alert(data);
	WT_question_raw_dataListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_question_raw_datapagingPageno',parseInt(pageNo));
	WT_question_raw_dataListing();
}

function import_question(question_raw_data_id) // delete record by table id
{
	var formdata = new FormData();	
		formdata.append('import_question','OK' );
		formdata.append('question_raw_data_id',question_raw_data_id );
	var url='<? echo $ajaxFilePath ?>?import_question=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('import_question_rsult_div_'+question_raw_data_id,url,formdata);
	 
 

}	
	
	//import_question(2) ;
	 
	 
</script>
<div id="import_question_rsult_div_2"> </div>

  
 
<? include($site['root-wtos'].'bottom.php'); ?>