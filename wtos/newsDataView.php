<?
/*
   # wtos version : 1.1
   # main ajax process page : newsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='mn';
$listHeader='List news';
$ajaxFilePath= 'newsAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
?>
  

 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_newsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_newsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Short Description </td>
										<td><input value="" type="text" name="briefDescription" id="briefDescription" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Full Description </td>
										<td><input value="" type="text" name="fullDescription" id="fullDescription" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										
										
										<tr >
	  									<td>News Image </td>
										<td>
										
										<img id="newsImagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="newsImage" value=""  id="newsImage" onchange="os.readURL(this,'newsImagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('newsImage');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr>
										
										<tr >
	  									<td>Publication Date </td>
										<td><input value="" type="text" name="publicationDate" id="publicationDate" class="wtDateClass textbox fWidth"/></td>
											
</tr>

<tr >
	  									<td>Start Time </td>
										<td><input value="" type="text" name="fromTime" id="fromTime" class="textbox fWidth"/></td>						
										</tr>
										<tr >
	  									<td>End Time </td>
										<td><input value="" type="text" name="toTime" id="toTime" class="textbox fWidth"/></td>						
										</tr>
																					
										<tr >
	  									<td>venue </td>
										<td><input value="" type="text" name="venue" id="venue" class="textboxxx  fWidth "/> </td>
                                        </tr>
										
										<tr style="display:none;">
	  									<td>Expiry Date</td>
										<td><input value="" type="text" name="expiryDate" id="expiryDate" class="wtDateClass textbox fWidth"/></td>						
										</tr>
										
										
										
										
										
										
										<!-- <tr >
	  									<td>seoUrl </td>
										<td><input value="" type="text" name="seoUrl" id="seoUrl" class="textboxxx  fWidth "/> </td>						
										</tr> -->
										
										<tr >
	  									<td>Catagory </td>
										<td>  
	
	                                  <select name="newsType" id="newsType"  class="textbox fWidth" ><option value="">Select News Type</option>	<? 
										  $os->onlyOption($os->newsType);	?></select>	 </td>						
										</tr>
										
										<tr >
	  									<td> <p id="eventsTypeLabel">Type</p></td>
										<td>  
	
	                                  <select name="eventsType" id="eventsType"  class="textbox fWidth" ><option value="">Select Event Type</option>	<? 
										  $os->onlyOption($os->eventsType);	?></select>	 </td>						
										</tr>
										
										<tr style="display:none;">
	  									<td>Date </td>
										<td><input value="" type="text" name="newsDate" id="newsDate" class="wtDateClass textbox fWidth"/></td>						
										</tr>
										
										
										
										<tr style="display:none;">
	  									<td>Published </td>
										<td>  
	
	                                     <select name="isPublished" id="isPublished" class="textbox fWidth" ><option value="">Select Published</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	 </td>						
										</tr>
										<tr >
	  									<td>Status </td>
										<td>  
	
	                              <select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>
										
										<tr style="display:none;">
	  									<td>location </td>
										<td><input value="" type="text" name="location" id="location" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										
										
										<tr>
	  									<td>Priority </td>
										<td><input value="" type="text" name="priority" id="priority" class="textboxxx  fWidth "/> </td>										
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="newsId" value="0" />	
	<input type="hidden"  id="WT_newspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_newsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_newsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  News Type:
	
	<select name="newsType" id="newsType_s" class="textbox fWidth" ><option value="">Select News Type</option>	<? 
										  $os->onlyOption($os->newsType);	?></select>	 
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Brief Description: <input type="text" class="wtTextClass" name="briefDescription_s" id="briefDescription_s" value="" /> &nbsp;  Full Description: <input type="text" class="wtTextClass" name="fullDescription_s" id="fullDescription_s" value="" /> &nbsp; From Publication Date: <input class="wtDateClass" type="text" name="f_publicationDate_s" id="f_publicationDate_s" value=""  /> &nbsp;   To Publication Date: <input class="wtDateClass" type="text" name="t_publicationDate_s" id="t_publicationDate_s" value=""  /> &nbsp;  
  From Expiry: <input class="wtDateClass" type="text" name="f_expiryDate_s" id="f_expiryDate_s" value=""  /> &nbsp;   To Expiry: <input class="wtDateClass" type="text" name="t_expiryDate_s" id="t_expiryDate_s" value=""  /> &nbsp;  
    Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
  
  From News Date: <input class="wtDateClass" type="text" name="f_newsDate_s" id="f_newsDate_s" value=""  /> &nbsp;   To News Date: <input class="wtDateClass" type="text" name="t_newsDate_s" id="t_newsDate_s" value=""  /> &nbsp;  
   Published:
	
	<select name="isPublished" id="isPublished_s" class="textbox fWidth" ><option value="">Select Published</option>	<? 
										  $os->onlyOption($os->yesNo);	?></select>	
   location: <input type="text" class="wtTextClass" name="location_s" id="location_s" value="" /> &nbsp;  venue: <input type="text" class="wtTextClass" name="venue_s" id="venue_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_newsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_newsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>


	

 
function WT_newsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var title_sVal= os.getVal('title_s'); 
 var briefDescription_sVal= os.getVal('briefDescription_s'); 
 var fullDescription_sVal= os.getVal('fullDescription_s'); 
 var f_publicationDate_sVal= os.getVal('f_publicationDate_s'); 
 var t_publicationDate_sVal= os.getVal('t_publicationDate_s'); 
 var f_expiryDate_sVal= os.getVal('f_expiryDate_s'); 
 var t_expiryDate_sVal= os.getVal('t_expiryDate_s'); 
 var status_sVal= os.getVal('status_s'); 
 var newsType_sVal= os.getVal('newsType_s'); 
 var f_newsDate_sVal= os.getVal('f_newsDate_s'); 
 var t_newsDate_sVal= os.getVal('t_newsDate_s'); 
 var isPublished_sVal= os.getVal('isPublished_s'); 
 var location_sVal= os.getVal('location_s'); 
 var venue_sVal= os.getVal('venue_s'); 
formdata.append('title_s',title_sVal );
formdata.append('briefDescription_s',briefDescription_sVal );
formdata.append('fullDescription_s',fullDescription_sVal );
formdata.append('f_publicationDate_s',f_publicationDate_sVal );
formdata.append('t_publicationDate_s',t_publicationDate_sVal );
formdata.append('f_expiryDate_s',f_expiryDate_sVal );
formdata.append('t_expiryDate_s',t_expiryDate_sVal );
formdata.append('status_s',status_sVal );
formdata.append('newsType_s',newsType_sVal );
formdata.append('f_newsDate_s',f_newsDate_sVal );
formdata.append('t_newsDate_s',t_newsDate_sVal );
formdata.append('isPublished_s',isPublished_sVal );
formdata.append('location_s',location_sVal );
formdata.append('venue_s',venue_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_newspagingPageno=os.getVal('WT_newspagingPageno');
	var url='wtpage='+WT_newspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_newsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_newsListDiv',url,formdata);
		
}

WT_newsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('title_s',''); 
 os.setVal('briefDescription_s',''); 
 os.setVal('fullDescription_s',''); 
 os.setVal('f_publicationDate_s',''); 
 os.setVal('t_publicationDate_s',''); 
 os.setVal('f_expiryDate_s',''); 
 os.setVal('t_expiryDate_s',''); 
 os.setVal('status_s',''); 
 os.setVal('newsType_s',''); 
 os.setVal('f_newsDate_s',''); 
 os.setVal('t_newsDate_s',''); 
 os.setVal('isPublished_s',''); 
 os.setVal('location_s',''); 
 os.setVal('venue_s',''); 
	
		os.setVal('searchKey','');
		WT_newsListing();	
	
	}
	
 
function WT_newsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var titleVal= os.getVal('title'); 
var briefDescriptionVal=tinyMCE.get("briefDescription").getContent();
var fullDescriptionVal=tinyMCE.get("fullDescription").getContent(); 
var publicationDateVal= os.getVal('publicationDate'); 
var expiryDateVal= os.getVal('expiryDate'); 
var newsImageVal= os.getObj('newsImage').files[0]; 
var statusVal= os.getVal('status'); 
// var seoUrlVal= os.getVal('seoUrl'); 
var newsTypeVal= os.getVal('newsType'); 
var newsDateVal= os.getVal('newsDate'); 

var toTimeVal= os.getVal('toTime'); 
var fromTimeVal= os.getVal('fromTime');


var isPublishedVal= os.getVal('isPublished'); 
var locationVal= os.getVal('location'); 
var venueVal= os.getVal('venue'); 
var priorityVal= os.getVal('priority');

var eventsTypeVal= os.getVal('eventsType'); 


 formdata.append('toTime',toTimeVal );
  formdata.append('fromTime',fromTimeVal );

 formdata.append('title',titleVal );
 formdata.append('briefDescription',briefDescriptionVal );
 formdata.append('fullDescription',fullDescriptionVal );
 formdata.append('publicationDate',publicationDateVal );
 formdata.append('expiryDate',expiryDateVal );
if(newsImageVal){  formdata.append('newsImage',newsImageVal,newsImageVal.name );}
 formdata.append('status',statusVal );
 // formdata.append('seoUrl',seoUrlVal );
 formdata.append('newsType',newsTypeVal );
 formdata.append('newsDate',newsDateVal );
 formdata.append('isPublished',isPublishedVal );
 formdata.append('location',locationVal );
 formdata.append('venue',venueVal );
 formdata.append('priority',priorityVal );
 
 formdata.append('eventsType',eventsTypeVal );

	
//if(os.check.empty('title','Please Add Title')==false){ return false;} 
//if(os.check.empty('status','Please Add Status')==false){ return false;} 
// if(os.check.empty('seoUrl','Please Add seoUrl')==false){ return false;} 
//if(os.check.empty('newsType','Please Add News Type')==false){ return false;} 
//if(os.check.empty('newsDate','Please Add News Date')==false){ return false;} 
//if(os.check.empty('isPublished','Please Add Published')==false){ return false;} 

	 var   newsId=os.getVal('newsId');
	 formdata.append('newsId',newsId );
  	var url='<? echo $ajaxFilePath ?>?WT_newsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_newsReLoadList',url,formdata);

}	

function WT_newsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var newsId=parseInt(d[0]);
	if(d[0]!='Error' && newsId>0)
	{
	  os.setVal('newsId',newsId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_newsListing();
}

function WT_newsGetById(newsId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('newsId',newsId );
	var url='<? echo $ajaxFilePath ?>?WT_newsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_newsFillData',url,formdata);
				
}

function WT_newsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('newsId',parseInt(objJSON.newsId));
	
 os.setVal('title',objJSON.title); 
 tinyMCE.get('briefDescription').setContent(objJSON.briefDescription);
 tinyMCE.get('fullDescription').setContent(objJSON.fullDescription); 
 os.setVal('publicationDate',objJSON.publicationDate); 
 os.setVal('expiryDate',objJSON.expiryDate); 
 os.setImg('newsImagePreview',objJSON.newsImage); 
 os.setVal('status',objJSON.status); 
 // os.setVal('seoUrl',objJSON.seoUrl); 
 os.setVal('newsType',objJSON.newsType); 
 os.setVal('newsDate',objJSON.newsDate); 
 os.setVal('isPublished',objJSON.isPublished); 
 os.setVal('location',objJSON.location); 
 os.setVal('venue',objJSON.venue); 
os.setVal('priority',objJSON.priority);

 os.setVal('toTime',objJSON.toTime); 
os.setVal('fromTime',objJSON.fromTime);

  
}

function WT_newsDeleteRowById(newsId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(newsId)<1 || newsId==''){  
	var  newsId =os.getVal('newsId');
	}
	
	if(parseInt(newsId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('newsId',newsId );
	
	var url='<? echo $ajaxFilePath ?>?WT_newsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_newsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_newsDeleteRowByIdResults(data)
{
	alert(data);
	WT_newsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_newspagingPageno',parseInt(pageNo));
	WT_newsListing();
}

	
	
	
	 
	 
</script>

<? include('tinyMCE.php'); ?>
<script>
 tmce('briefDescription');
 tmce('fullDescription');
 </script>

  
 
<? include($site['root-wtos'].'bottom.php'); ?>