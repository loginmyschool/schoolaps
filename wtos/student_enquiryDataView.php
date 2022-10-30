<?
/*
   # wtos version : 1.1
   # main ajax process page : student_enquiryAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Student Enquiry';
$ajaxFilePath= 'student_enquiryAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_student_enquiryDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_student_enquiryEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="student_enquiry_id" value="0" />	
	<input type="hidden"  id="WT_student_enquirypagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_student_enquiryDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_student_enquiryEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_student_enquiryListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_student_enquiryListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_student_enquiryListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var title_sVal= os.getVal('title_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('title_s',title_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_student_enquirypagingPageno=os.getVal('WT_student_enquirypagingPageno');
	var url='wtpage='+WT_student_enquirypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_student_enquiryListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_student_enquiryListDiv',url,formdata);
		
}

WT_student_enquiryListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('title_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_student_enquiryListing();	
	
	}
	
 
function WT_student_enquiryEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var titleVal= os.getVal('title'); 
var statusVal= os.getVal('status'); 


 formdata.append('title',titleVal );
 formdata.append('status',statusVal );

	
if(os.check.empty('title','Please Add Title')==false){ return false;} 

	 var   student_enquiry_id=os.getVal('student_enquiry_id');
	 formdata.append('student_enquiry_id',student_enquiry_id );
  	var url='<? echo $ajaxFilePath ?>?WT_student_enquiryEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_enquiryReLoadList',url,formdata);

}	

function WT_student_enquiryReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var student_enquiry_id=parseInt(d[0]);
	if(d[0]!='Error' && student_enquiry_id>0)
	{
	  os.setVal('student_enquiry_id',student_enquiry_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_student_enquiryListing();
}

function WT_student_enquiryGetById(student_enquiry_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('student_enquiry_id',student_enquiry_id );
	var url='<? echo $ajaxFilePath ?>?WT_student_enquiryGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_enquiryFillData',url,formdata);
				
}

function WT_student_enquiryFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('student_enquiry_id',parseInt(objJSON.student_enquiry_id));
	
 os.setVal('title',objJSON.title); 
 os.setVal('status',objJSON.status); 

  
}

function WT_student_enquiryDeleteRowById(student_enquiry_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(student_enquiry_id)<1 || student_enquiry_id==''){  
	var  student_enquiry_id =os.getVal('student_enquiry_id');
	}
	
	if(parseInt(student_enquiry_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('student_enquiry_id',student_enquiry_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_student_enquiryDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_enquiryDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_student_enquiryDeleteRowByIdResults(data)
{
	alert(data);
	WT_student_enquiryListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_student_enquirypagingPageno',parseInt(pageNo));
	WT_student_enquiryListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>