<?
/*
   # wtos version : 1.1
   # main ajax process page : rbcmpmAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List rbcmpm';
$ajaxFilePath= 'rbcmpmAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcmpmDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbcmpmEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="cmpmDate" id="cmpmDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Alert Date </td>
										<td><input value="" type="text" name="alertDate" id="alertDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Employee </td>
										<td> <select name="rbemployeeId" id="rbemployeeId" class="textbox fWidth" ><option value="">Select Employee</option>		  	<? 
								
										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select> </td>						
										</tr><tr >
	  									<td>Visit Date </td>
										<td><input value="" type="text" name="visitDate" id="visitDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>PM Status </td>
										<td>  
	
	<select name="cmpmStatus" id="cmpmStatus" class="textbox fWidth" ><option value="">Select PM Status</option>	<? 
										  $os->onlyOption($os->cmpmStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>Remarks </td>
										<td><input value="" type="text" name="remarks" id="remarks" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbcmpmId" value="0" />	
	<input type="hidden"  id="WT_rbcmpmpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcmpmDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbcmpmEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
From Date: <input class="wtDateClass" type="text" name="f_cmpmDate_s" id="f_cmpmDate_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_cmpmDate_s" id="t_cmpmDate_s" value=""  /> &nbsp;  
   Employee:
	
	
	<select name="rbemployeeId" id="rbemployeeId_s" class="textbox fWidth" ><option value="">Select Employee</option>		  	<? 
								
										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select>
  From Visit Date: <input class="wtDateClass" type="text" name="f_visitDate_s" id="f_visitDate_s" value=""  /> &nbsp;   To Visit Date: <input class="wtDateClass" type="text" name="t_visitDate_s" id="t_visitDate_s" value=""  /> &nbsp;  
   PM Status:
	
	<select name="cmpmStatus" id="cmpmStatus_s" class="textbox fWidth" ><option value="">Select PM Status</option>	<? 
										  $os->onlyOption($os->cmpmStatus);	?></select>	
   Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbcmpmListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbcmpmListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbcmpmListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var f_cmpmDate_sVal= os.getVal('f_cmpmDate_s'); 
 var t_cmpmDate_sVal= os.getVal('t_cmpmDate_s'); 
 var rbemployeeId_sVal= os.getVal('rbemployeeId_s'); 
 var f_visitDate_sVal= os.getVal('f_visitDate_s'); 
 var t_visitDate_sVal= os.getVal('t_visitDate_s'); 
 var cmpmStatus_sVal= os.getVal('cmpmStatus_s'); 
 var remarks_sVal= os.getVal('remarks_s'); 
formdata.append('f_cmpmDate_s',f_cmpmDate_sVal );
formdata.append('t_cmpmDate_s',t_cmpmDate_sVal );
formdata.append('rbemployeeId_s',rbemployeeId_sVal );
formdata.append('f_visitDate_s',f_visitDate_sVal );
formdata.append('t_visitDate_s',t_visitDate_sVal );
formdata.append('cmpmStatus_s',cmpmStatus_sVal );
formdata.append('remarks_s',remarks_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbcmpmpagingPageno=os.getVal('WT_rbcmpmpagingPageno');
	var url='wtpage='+WT_rbcmpmpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbcmpmListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbcmpmListDiv',url,formdata);
		
}

WT_rbcmpmListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('f_cmpmDate_s',''); 
 os.setVal('t_cmpmDate_s',''); 
 os.setVal('rbemployeeId_s',''); 
 os.setVal('f_visitDate_s',''); 
 os.setVal('t_visitDate_s',''); 
 os.setVal('cmpmStatus_s',''); 
 os.setVal('remarks_s',''); 
	
		os.setVal('searchKey','');
		WT_rbcmpmListing();	
	
	}
	
 
function WT_rbcmpmEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var cmpmDateVal= os.getVal('cmpmDate'); 
var alertDateVal= os.getVal('alertDate'); 
var rbemployeeIdVal= os.getVal('rbemployeeId'); 
var visitDateVal= os.getVal('visitDate'); 
var cmpmStatusVal= os.getVal('cmpmStatus'); 
var remarksVal= os.getVal('remarks'); 


 formdata.append('cmpmDate',cmpmDateVal );
 formdata.append('alertDate',alertDateVal );
 formdata.append('rbemployeeId',rbemployeeIdVal );
 formdata.append('visitDate',visitDateVal );
 formdata.append('cmpmStatus',cmpmStatusVal );
 formdata.append('remarks',remarksVal );

	
if(os.check.empty('cmpmDate','Please Add Date')==false){ return false;} 
if(os.check.empty('cmpmStatus','Please Add PM Status')==false){ return false;} 

	 var   rbcmpmId=os.getVal('rbcmpmId');
	 formdata.append('rbcmpmId',rbcmpmId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbcmpmEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcmpmReLoadList',url,formdata);

}	

function WT_rbcmpmReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbcmpmId=parseInt(d[0]);
	if(d[0]!='Error' && rbcmpmId>0)
	{
	  os.setVal('rbcmpmId',rbcmpmId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbcmpmListing();
}

function WT_rbcmpmGetById(rbcmpmId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbcmpmId',rbcmpmId );
	var url='<? echo $ajaxFilePath ?>?WT_rbcmpmGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcmpmFillData',url,formdata);
				
}

function WT_rbcmpmFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbcmpmId',parseInt(objJSON.rbcmpmId));
	
 os.setVal('cmpmDate',objJSON.cmpmDate); 
 os.setVal('alertDate',objJSON.alertDate); 
 os.setVal('rbemployeeId',objJSON.rbemployeeId); 
 os.setVal('visitDate',objJSON.visitDate); 
 os.setVal('cmpmStatus',objJSON.cmpmStatus); 
 os.setVal('remarks',objJSON.remarks); 

  
}

function WT_rbcmpmDeleteRowById(rbcmpmId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbcmpmId)<1 || rbcmpmId==''){  
	var  rbcmpmId =os.getVal('rbcmpmId');
	}
	
	if(parseInt(rbcmpmId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbcmpmId',rbcmpmId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbcmpmDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcmpmDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbcmpmDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbcmpmListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbcmpmpagingPageno',parseInt(pageNo));
	WT_rbcmpmListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>