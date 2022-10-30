<?
/*
   # wtos version : 1.1
   # main ajax process page : review_subjectAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Review Subject';
$ajaxFilePath= 'review_subjectAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_review_subjectDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_review_subjectEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Parent</td>
										<td><select name="parent_id" id="parent_id" class="textbox fWidth" ><option value="">Select Parent</option><? $os->optionsHTML('','review_subject_id','title','review_subject','parent_id=0');?></select>
										</td>						
										</tr><tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Allow User </td>
										<td>  
	
	<select name="allow_user" id="allow_user" class="textbox fWidth" ><option value="">Select Allow User</option>	<? 
										  $os->onlyOption($os->allow_user);	?></select>	 </td>						
										</tr><tr >
	  									<td>View Order </td>
										<td><input value="" type="text" name="view_order" id="view_order" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="review_subject_id" value="0" />	
	<input type="hidden"  id="WT_review_subjectpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_review_subjectDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_review_subjectEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Parent Id: <input type="text" class="wtTextClass" name="parent_id_s" id="parent_id_s" value="" /> &nbsp;  Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Allow User:
	
	<select name="allow_user" id="allow_user_s" class="textbox fWidth" ><option value="">Select Allow User</option>	<? 
										  $os->onlyOption($os->allow_user);	?></select>	
   View Order: <input type="text" class="wtTextClass" name="view_order_s" id="view_order_s" value="" /> &nbsp;  Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_review_subjectListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_review_subjectListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_review_subjectListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var parent_id_sVal= os.getVal('parent_id_s'); 
 var title_sVal= os.getVal('title_s'); 
 var allow_user_sVal= os.getVal('allow_user_s'); 
 var view_order_sVal= os.getVal('view_order_s'); 
 var active_status_sVal= os.getVal('active_status_s'); 
formdata.append('parent_id_s',parent_id_sVal );
formdata.append('title_s',title_sVal );
formdata.append('allow_user_s',allow_user_sVal );
formdata.append('view_order_s',view_order_sVal );
formdata.append('active_status_s',active_status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_review_subjectpagingPageno=os.getVal('WT_review_subjectpagingPageno');
	var url='wtpage='+WT_review_subjectpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_review_subjectListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_review_subjectListDiv',url,formdata);
		
}

WT_review_subjectListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('parent_id_s',''); 
 os.setVal('title_s',''); 
 os.setVal('allow_user_s',''); 
 os.setVal('view_order_s',''); 
 os.setVal('active_status_s',''); 
	
		os.setVal('searchKey','');
		WT_review_subjectListing();	
	
	}
	
 
function WT_review_subjectEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var parent_idVal= os.getVal('parent_id'); 
var titleVal= os.getVal('title'); 
var allow_userVal= os.getVal('allow_user'); 
var view_orderVal= os.getVal('view_order'); 
var active_statusVal= os.getVal('active_status'); 


 formdata.append('parent_id',parent_idVal );
 formdata.append('title',titleVal );
 formdata.append('allow_user',allow_userVal );
 formdata.append('view_order',view_orderVal );
 formdata.append('active_status',active_statusVal );

	

	 var   review_subject_id=os.getVal('review_subject_id');
	 formdata.append('review_subject_id',review_subject_id );
  	var url='<? echo $ajaxFilePath ?>?WT_review_subjectEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_review_subjectReLoadList',url,formdata);

}	

function WT_review_subjectReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var review_subject_id=parseInt(d[0]);
	if(d[0]!='Error' && review_subject_id>0)
	{
	  os.setVal('review_subject_id',review_subject_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_review_subjectListing();
}

function WT_review_subjectGetById(review_subject_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('review_subject_id',review_subject_id );
	var url='<? echo $ajaxFilePath ?>?WT_review_subjectGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_review_subjectFillData',url,formdata);
				
}

function WT_review_subjectFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('review_subject_id',parseInt(objJSON.review_subject_id));
	
 os.setVal('parent_id',objJSON.parent_id); 
 os.setVal('title',objJSON.title); 
 os.setVal('allow_user',objJSON.allow_user); 
 os.setVal('view_order',objJSON.view_order); 
 os.setVal('active_status',objJSON.active_status); 

  
}

function WT_review_subjectDeleteRowById(review_subject_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(review_subject_id)<1 || review_subject_id==''){  
	var  review_subject_id =os.getVal('review_subject_id');
	}
	
	if(parseInt(review_subject_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('review_subject_id',review_subject_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_review_subjectDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_review_subjectDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_review_subjectDeleteRowByIdResults(data)
{
	alert(data);
	WT_review_subjectListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_review_subjectpagingPageno',parseInt(pageNo));
	WT_review_subjectListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>