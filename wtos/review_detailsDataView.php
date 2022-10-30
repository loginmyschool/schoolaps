<?
/*
   # wtos version : 1.1
   # main ajax process page : review_detailsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Review Details';
$ajaxFilePath= 'review_detailsAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_review_detailsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_review_detailsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Review Subject </td>
										<td> <select name="review_subject_id" id="review_subject_id" class="textbox fWidth" ><option value="">Select Review Subject</option>		  	<? 
								
										  $os->optionsHTML('','review_subject_id','title','review_subject');?>
							</select> </td>						
										</tr><tr >
	  									<td>Parent Id </td>
										<td><input value="" type="text" name="parent_id" id="parent_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>User Table </td>
										<td><input value="" type="text" name="user_table" id="user_table" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>User Table Id </td>
										<td><input value="" type="text" name="user_table_id" id="user_table_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Contact No </td>
										<td><input value="" type="text" name="contact_no" id="contact_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Review Marks </td>
										<td><input value="" type="text" name="review_marks" id="review_marks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Review Note </td>
										<td><input value="" type="text" name="review_note" id="review_note" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Dated </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="review_details_id" value="0" />	
	<input type="hidden"  id="WT_review_detailspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_review_detailsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_review_detailsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Review Subject:
	
	
	<select name="review_subject_id" id="review_subject_id_s" class="textbox fWidth" ><option value="">Select Review Subject</option>		  	<? 
								
										  $os->optionsHTML('','review_subject_id','title','review_subject');?>
							</select>
   Parent Id: <input type="text" class="wtTextClass" name="parent_id_s" id="parent_id_s" value="" /> &nbsp;  User Table: <input type="text" class="wtTextClass" name="user_table_s" id="user_table_s" value="" /> &nbsp;  User Table Id: <input type="text" class="wtTextClass" name="user_table_id_s" id="user_table_id_s" value="" /> &nbsp;  Contact No: <input type="text" class="wtTextClass" name="contact_no_s" id="contact_no_s" value="" /> &nbsp;  Review Marks: <input type="text" class="wtTextClass" name="review_marks_s" id="review_marks_s" value="" /> &nbsp;  Review Note: <input type="text" class="wtTextClass" name="review_note_s" id="review_note_s" value="" /> &nbsp; From Dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_review_detailsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_review_detailsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_review_detailsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var review_subject_id_sVal= os.getVal('review_subject_id_s'); 
 var parent_id_sVal= os.getVal('parent_id_s'); 
 var user_table_sVal= os.getVal('user_table_s'); 
 var user_table_id_sVal= os.getVal('user_table_id_s'); 
 var contact_no_sVal= os.getVal('contact_no_s'); 
 var review_marks_sVal= os.getVal('review_marks_s'); 
 var review_note_sVal= os.getVal('review_note_s'); 
 var f_dated_sVal= os.getVal('f_dated_s'); 
 var t_dated_sVal= os.getVal('t_dated_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('review_subject_id_s',review_subject_id_sVal );
formdata.append('parent_id_s',parent_id_sVal );
formdata.append('user_table_s',user_table_sVal );
formdata.append('user_table_id_s',user_table_id_sVal );
formdata.append('contact_no_s',contact_no_sVal );
formdata.append('review_marks_s',review_marks_sVal );
formdata.append('review_note_s',review_note_sVal );
formdata.append('f_dated_s',f_dated_sVal );
formdata.append('t_dated_s',t_dated_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_review_detailspagingPageno=os.getVal('WT_review_detailspagingPageno');
	var url='wtpage='+WT_review_detailspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_review_detailsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_review_detailsListDiv',url,formdata);
		
}

WT_review_detailsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('review_subject_id_s',''); 
 os.setVal('parent_id_s',''); 
 os.setVal('user_table_s',''); 
 os.setVal('user_table_id_s',''); 
 os.setVal('contact_no_s',''); 
 os.setVal('review_marks_s',''); 
 os.setVal('review_note_s',''); 
 os.setVal('f_dated_s',''); 
 os.setVal('t_dated_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_review_detailsListing();	
	
	}
	
 
function WT_review_detailsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var review_subject_idVal= os.getVal('review_subject_id'); 
var parent_idVal= os.getVal('parent_id'); 
var user_tableVal= os.getVal('user_table'); 
var user_table_idVal= os.getVal('user_table_id'); 
var contact_noVal= os.getVal('contact_no'); 
var review_marksVal= os.getVal('review_marks'); 
var review_noteVal= os.getVal('review_note'); 
var datedVal= os.getVal('dated'); 
var statusVal= os.getVal('status'); 


 formdata.append('review_subject_id',review_subject_idVal );
 formdata.append('parent_id',parent_idVal );
 formdata.append('user_table',user_tableVal );
 formdata.append('user_table_id',user_table_idVal );
 formdata.append('contact_no',contact_noVal );
 formdata.append('review_marks',review_marksVal );
 formdata.append('review_note',review_noteVal );
 formdata.append('dated',datedVal );
 formdata.append('status',statusVal );

	

	 var   review_details_id=os.getVal('review_details_id');
	 formdata.append('review_details_id',review_details_id );
  	var url='<? echo $ajaxFilePath ?>?WT_review_detailsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_review_detailsReLoadList',url,formdata);

}	

function WT_review_detailsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var review_details_id=parseInt(d[0]);
	if(d[0]!='Error' && review_details_id>0)
	{
	  os.setVal('review_details_id',review_details_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_review_detailsListing();
}

function WT_review_detailsGetById(review_details_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('review_details_id',review_details_id );
	var url='<? echo $ajaxFilePath ?>?WT_review_detailsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_review_detailsFillData',url,formdata);
				
}

function WT_review_detailsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('review_details_id',parseInt(objJSON.review_details_id));
	
 os.setVal('review_subject_id',objJSON.review_subject_id); 
 os.setVal('parent_id',objJSON.parent_id); 
 os.setVal('user_table',objJSON.user_table); 
 os.setVal('user_table_id',objJSON.user_table_id); 
 os.setVal('contact_no',objJSON.contact_no); 
 os.setVal('review_marks',objJSON.review_marks); 
 os.setVal('review_note',objJSON.review_note); 
 os.setVal('dated',objJSON.dated); 
 os.setVal('status',objJSON.status); 

  
}

function WT_review_detailsDeleteRowById(review_details_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(review_details_id)<1 || review_details_id==''){  
	var  review_details_id =os.getVal('review_details_id');
	}
	
	if(parseInt(review_details_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('review_details_id',review_details_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_review_detailsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_review_detailsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_review_detailsDeleteRowByIdResults(data)
{
	alert(data);
	WT_review_detailsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_review_detailspagingPageno',parseInt(pageNo));
	WT_review_detailsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>