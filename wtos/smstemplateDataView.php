<?
/*
   # wtos version : 1.1
   # main ajax process page : smstemplateAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage SMS Template';
$ajaxFilePath= 'smstemplateAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_smstemplateDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_smstemplateEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Key </td>
										<td><input value="" type="text" name="templatekey" id="templatekey" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Text </td>
										<td> 
										<textarea value=""  name="text" id="text" class="textboxxx  fWidth " style="height:150px; width:250px;"></textarea>
										
										</td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="templatestatus" id="templatestatus" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->templatestatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>Order </td>
										<td><input value="" type="text" name="templateorder" id="templateorder" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="smstemplateId" value="0" />	
	<input type="hidden"  id="WT_smstemplatepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_smstemplateDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_smstemplateEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Key: <input type="text" class="wtTextClass" name="templatekey_s" id="templatekey_s" value="" /> &nbsp;  Text: <input type="text" class="wtTextClass" name="text_s" id="text_s" value="" /> &nbsp;  Status:
	
	<select name="templatestatus" id="templatestatus_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->templatestatus);	?></select>	
   Order: <input type="text" class="wtTextClass" name="templateorder_s" id="templateorder_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_smstemplateListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_smstemplateListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_smstemplateListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var templatekey_sVal= os.getVal('templatekey_s'); 
 var text_sVal= os.getVal('text_s'); 
 var templatestatus_sVal= os.getVal('templatestatus_s'); 
 var templateorder_sVal= os.getVal('templateorder_s'); 
formdata.append('templatekey_s',templatekey_sVal );
formdata.append('text_s',text_sVal );
formdata.append('templatestatus_s',templatestatus_sVal );
formdata.append('templateorder_s',templateorder_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_smstemplatepagingPageno=os.getVal('WT_smstemplatepagingPageno');
	var url='wtpage='+WT_smstemplatepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_smstemplateListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_smstemplateListDiv',url,formdata);
		
}

WT_smstemplateListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('templatekey_s',''); 
 os.setVal('text_s',''); 
 os.setVal('templatestatus_s',''); 
 os.setVal('templateorder_s',''); 
	
		os.setVal('searchKey','');
		WT_smstemplateListing();	
	
	}
	
 
function WT_smstemplateEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var templatekeyVal= os.getVal('templatekey'); 
var textVal= os.getVal('text'); 
var templatestatusVal= os.getVal('templatestatus'); 
var templateorderVal= os.getVal('templateorder'); 


 formdata.append('templatekey',templatekeyVal );
 formdata.append('text',textVal );
 formdata.append('templatestatus',templatestatusVal );
 formdata.append('templateorder',templateorderVal );

	
if(os.check.empty('templatekey','Please Add Key')==false){ return false;} 
if(os.check.empty('text','Please Add Text')==false){ return false;} 
// if(os.check.empty('templatestatus','Please Add Status')==false){ return false;} 

	 var   smstemplateId=os.getVal('smstemplateId');
	 formdata.append('smstemplateId',smstemplateId );
  	var url='<? echo $ajaxFilePath ?>?WT_smstemplateEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_smstemplateReLoadList',url,formdata);

}	

function WT_smstemplateReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var smstemplateId=parseInt(d[0]);
	if(d[0]!='Error' && smstemplateId>0)
	{
	  os.setVal('smstemplateId',smstemplateId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_smstemplateListing();
}

function WT_smstemplateGetById(smstemplateId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('smstemplateId',smstemplateId );
	var url='<? echo $ajaxFilePath ?>?WT_smstemplateGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_smstemplateFillData',url,formdata);
				
}

function WT_smstemplateFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('smstemplateId',parseInt(objJSON.smstemplateId));
	
 os.setVal('templatekey',objJSON.templatekey); 
 os.setVal('text',objJSON.text); 
 os.setVal('templatestatus',objJSON.templatestatus); 
 os.setVal('templateorder',objJSON.templateorder); 

  
}

function WT_smstemplateDeleteRowById(smstemplateId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(smstemplateId)<1 || smstemplateId==''){  
	var  smstemplateId =os.getVal('smstemplateId');
	}
	
	if(parseInt(smstemplateId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('smstemplateId',smstemplateId );
	
	var url='<? echo $ajaxFilePath ?>?WT_smstemplateDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_smstemplateDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_smstemplateDeleteRowByIdResults(data)
{
	alert(data);
	WT_smstemplateListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_smstemplatepagingPageno',parseInt(pageNo));
	WT_smstemplateListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>