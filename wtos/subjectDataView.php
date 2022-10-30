<?
/*
   # wtos version : 1.1
   # main ajax process page : subjectAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List subject';
$ajaxFilePath= 'subjectAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_subjectDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_subjectEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Subject Name </td>
										<td><input value="" type="text" name="subjectName" id="subjectName" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Subject Status </td>
										<td>  
	
	<select name="subjectStatus" id="subjectStatus" class="textbox fWidth" ><option value="">Select Subject Status</option>	<? 
										  $os->onlyOption($os->subjectStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>Priority </td>
										<td><input value="" type="text" name="priority" id="priority" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="subjectId" value="0" />	
	<input type="hidden"  id="WT_subjectpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_subjectDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_subjectEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Subject Name: <input type="text" class="wtTextClass" name="subjectName_s" id="subjectName_s" value="" /> &nbsp;  Subject Status:
	
	<select name="subjectStatus" id="subjectStatus_s" class="textbox fWidth" ><option value="">Select Subject Status</option>	<? 
										  $os->onlyOption($os->subjectStatus);	?></select>	
   Priority: <input type="text" class="wtTextClass" name="priority_s" id="priority_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_subjectListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_subjectListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_subjectListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var subjectName_sVal= os.getVal('subjectName_s'); 
 var subjectStatus_sVal= os.getVal('subjectStatus_s'); 
 var priority_sVal= os.getVal('priority_s'); 
formdata.append('subjectName_s',subjectName_sVal );
formdata.append('subjectStatus_s',subjectStatus_sVal );
formdata.append('priority_s',priority_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_subjectpagingPageno=os.getVal('WT_subjectpagingPageno');
	var url='wtpage='+WT_subjectpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_subjectListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_subjectListDiv',url,formdata);
		
}

WT_subjectListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('subjectName_s',''); 
 os.setVal('subjectStatus_s',''); 
 os.setVal('priority_s',''); 
	
		os.setVal('searchKey','');
		WT_subjectListing();	
	
	}
	
 
function WT_subjectEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var subjectNameVal= os.getVal('subjectName'); 
var subjectStatusVal= os.getVal('subjectStatus'); 
var priorityVal= os.getVal('priority'); 


 formdata.append('subjectName',subjectNameVal );
 formdata.append('subjectStatus',subjectStatusVal );
 formdata.append('priority',priorityVal );

	

	 var   subjectId=os.getVal('subjectId');
	 formdata.append('subjectId',subjectId );
  	var url='<? echo $ajaxFilePath ?>?WT_subjectEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_subjectReLoadList',url,formdata);

}	

function WT_subjectReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var subjectId=parseInt(d[0]);
	if(d[0]!='Error' && subjectId>0)
	{
	  os.setVal('subjectId',subjectId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_subjectListing();
}

function WT_subjectGetById(subjectId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('subjectId',subjectId );
	var url='<? echo $ajaxFilePath ?>?WT_subjectGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_subjectFillData',url,formdata);
				
}

function WT_subjectFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('subjectId',parseInt(objJSON.subjectId));
	
 os.setVal('subjectName',objJSON.subjectName); 
 os.setVal('subjectStatus',objJSON.subjectStatus); 
 os.setVal('priority',objJSON.priority); 

  
}

function WT_subjectDeleteRowById(subjectId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(subjectId)<1 || subjectId==''){  
	var  subjectId =os.getVal('subjectId');
	}
	
	if(parseInt(subjectId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('subjectId',subjectId );
	
	var url='<? echo $ajaxFilePath ?>?WT_subjectDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_subjectDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_subjectDeleteRowByIdResults(data)
{
	alert(data);
	WT_subjectListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_subjectpagingPageno',parseInt(pageNo));
	WT_subjectListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>