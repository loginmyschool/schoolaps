<?
/*
   # wtos version : 1.1
   # main ajax process page : cronsmsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Sms Tracking';
$ajaxFilePath= 'smsTrackingAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 $cronSendSmsV = $os->rowByField('value','settings','keyword','cronSendSms') ;

?>
  

 <table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm" style="display:none">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_cronsmsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_cronsmsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Student Id </td>
										<td><input value="" type="text" name="studentId" id="studentId" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Sending Month </td>
										<td><input value="" type="text" name="sendingMonth" id="sendingMonth" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Sms Text </td>
										<td><input value="" type="text" name="smsText" id="smsText" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Status </td>
										<td><input value="" type="text" name="status" id="status" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile No </td>
										<td><input value="" type="text" name="mobileNos" id="mobileNos" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><input value="" type="text" name="note" id="note" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="cronsmsId" value="0" />	
	<input type="hidden"  id="WT_cronsmspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_cronsmsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_cronsmsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	
  From Date: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  />
  
    <input type="button" value="Search" onclick="WT_cronsmsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
    Cron Set Sms:


	<select name="cronSendSms" id="cronSendSms_s" class="textbox fWidth" onchange="cronSetSms();"><? 

										  $os->onlyOption($os->cronSendSms,$cronSendSmsV);	?></select>	
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         Search Key  
  <input type="text" id="searchKey" />   &nbsp;
 Student Id: <input type="text" class="wtTextClass" name="studentId_s" id="studentId_s" value="" /> &nbsp;  Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Sending Month: <input type="text" class="wtTextClass" name="sendingMonth_s" id="sendingMonth_s" value="" /> &nbsp;  Sms Text: <input type="text" class="wtTextClass" name="smsText_s" id="smsText_s" value="" /> &nbsp;  &nbsp;  
   Status: <input type="text" class="wtTextClass" name="status_s" id="status_s" value="" /> &nbsp;  Mobile No: <input type="text" class="wtTextClass" name="mobileNos_s" id="mobileNos_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   

  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_cronsmsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_cronsmsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var studentId_sVal= os.getVal('studentId_s'); 
 var name_sVal= os.getVal('name_s'); 
 var sendingMonth_sVal= os.getVal('sendingMonth_s'); 
 var smsText_sVal= os.getVal('smsText_s'); 
 var f_dated_sVal= os.getVal('f_dated_s'); 
 var t_dated_sVal= os.getVal('t_dated_s'); 
 var status_sVal= os.getVal('status_s'); 
 var mobileNos_sVal= os.getVal('mobileNos_s'); 
 var note_sVal= os.getVal('note_s'); 
formdata.append('studentId_s',studentId_sVal );
formdata.append('name_s',name_sVal );
formdata.append('sendingMonth_s',sendingMonth_sVal );
formdata.append('smsText_s',smsText_sVal );
formdata.append('f_dated_s',f_dated_sVal );
formdata.append('t_dated_s',t_dated_sVal );
formdata.append('status_s',status_sVal );
formdata.append('mobileNos_s',mobileNos_sVal );
formdata.append('note_s',note_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_cronsmspagingPageno=os.getVal('WT_cronsmspagingPageno');
	var url='wtpage='+WT_cronsmspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_cronsmsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_cronsmsListDiv',url,formdata);
		
}

WT_cronsmsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('studentId_s',''); 
 os.setVal('name_s',''); 
 os.setVal('sendingMonth_s',''); 
 os.setVal('smsText_s',''); 
 os.setVal('f_dated_s',''); 
 os.setVal('t_dated_s',''); 
 os.setVal('status_s',''); 
 os.setVal('mobileNos_s',''); 
 os.setVal('note_s',''); 
	
		os.setVal('searchKey','');
		WT_cronsmsListing();	
	
	}
	
 
function WT_cronsmsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var studentIdVal= os.getVal('studentId'); 
var nameVal= os.getVal('name'); 
var sendingMonthVal= os.getVal('sendingMonth'); 
var smsTextVal= os.getVal('smsText'); 
var datedVal= os.getVal('dated'); 
var statusVal= os.getVal('status'); 
var mobileNosVal= os.getVal('mobileNos'); 
var noteVal= os.getVal('note'); 


 formdata.append('studentId',studentIdVal );
 formdata.append('name',nameVal );
 formdata.append('sendingMonth',sendingMonthVal );
 formdata.append('smsText',smsTextVal );
 formdata.append('dated',datedVal );
 formdata.append('status',statusVal );
 formdata.append('mobileNos',mobileNosVal );
 formdata.append('note',noteVal );

	

	 var   cronsmsId=os.getVal('cronsmsId');
	 formdata.append('cronsmsId',cronsmsId );
  	var url='<? echo $ajaxFilePath ?>?WT_cronsmsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_cronsmsReLoadList',url,formdata);

}	

function WT_cronsmsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var cronsmsId=parseInt(d[0]);
	if(d[0]!='Error' && cronsmsId>0)
	{
	  os.setVal('cronsmsId',cronsmsId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_cronsmsListing();
}

function WT_cronsmsGetById(cronsmsId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('cronsmsId',cronsmsId );
	var url='<? echo $ajaxFilePath ?>?WT_cronsmsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_cronsmsFillData',url,formdata);
				
}

function WT_cronsmsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('cronsmsId',parseInt(objJSON.cronsmsId));
	
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('name',objJSON.name); 
 os.setVal('sendingMonth',objJSON.sendingMonth); 
 os.setVal('smsText',objJSON.smsText); 
 os.setVal('dated',objJSON.dated); 
 os.setVal('status',objJSON.status); 
 os.setVal('mobileNos',objJSON.mobileNos); 
 os.setVal('note',objJSON.note); 

  
}

function WT_cronsmsDeleteRowById(cronsmsId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(cronsmsId)<1 || cronsmsId==''){  
	var  cronsmsId =os.getVal('cronsmsId');
	}
	
	if(parseInt(cronsmsId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('cronsmsId',cronsmsId );
	
	var url='<? echo $ajaxFilePath ?>?WT_cronsmsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_cronsmsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_cronsmsDeleteRowByIdResults(data)
{
	alert(data);
	WT_cronsmsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_cronsmspagingPageno',parseInt(pageNo));
	WT_cronsmsListing();
}

	
	
	
	
	
	
	
	
	
	
	
	
function cronSetSms() 
{
	var formdata = new FormData();	
	var  cronSendSms_sVal =os.getVal('cronSendSms_s');
	formdata.append('cronSendSms_s',cronSendSms_sVal);
	var url='<? echo $ajaxFilePath ?>?cronSetSms=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_cronSetSmsResults',url,formdata);



}
function WT_cronSetSmsResults(data)
{
	alert(data);
} 
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>