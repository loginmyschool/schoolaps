<?
/*
   # wtos version : 1.1
   # main ajax process page : ticketAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List ticket';
$ajaxFilePath= 'ticketAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 //$os->ticket_status=array(''=>'','Pending'=>'Pending','Close'=>'Close','Reply'=>'Reply');
 $os->ticket_status=array(''=>'','Open'=>'Open','Close'=>'Close','Reopen'=>'Reopen');
 
 
?>
  

 <table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    
    <td width="650" valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 TICKET ID: <input type="text" class="wtTextClass" name="ticket_id_s" id="ticket_id_s" value="" /> &nbsp;  Branch: <input type="text" class="wtTextClass" name="branch_id_s" id="branch_id_s" value="" /> &nbsp;  Ticket By: <input type="text" class="wtTextClass" name="ticketby_admin_id_s" id="ticketby_admin_id_s" value="" /> &nbsp; From Dated: <input class="wtDateClass" type="text" name="f_ticket_date_s" id="f_ticket_date_s" value=""  /> &nbsp;   To Dated: <input class="wtDateClass" type="text" name="t_ticket_date_s" id="t_ticket_date_s" value=""  /> &nbsp;  
   Subject: <input type="text" class="wtTextClass" name="subject_s" id="subject_s" value="" /> &nbsp;  Message: <input type="text" class="wtTextClass" name="message_s" id="message_s" value="" /> &nbsp;  Status:
	
	<select name="ticket_status" id="ticket_status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->ticket_status);	?></select>	
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_ticketListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
   <input type="button" value="Create New" onclick="create_new_ticket()" style="cursor:pointer;"/>
   
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_ticketListDiv">&nbsp; </div>
	&nbsp;</td>
	<td width="" height="470" valign="top" class="ajaxViewMainTableTDForm ajaxViewMainTableTDList">
	<div class="formDiv" id="ticket_form" style="display:none;">
	<div class="formDivButton" style="display:none;">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_ticketDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_ticketEditAndSave();" /><? } ?>	 
	
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr style="display:none;" >
	  									<td>Branch </td>
										<td><input value="" type="text" name="branch_id" id="branch_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr style="display:none;" >
	  									<td>Ticket By </td>
										<td><input value="" type="text" name="ticketby_admin_id" id="ticketby_admin_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr style="display:none;" >
	  									<td>Dated </td>
										<td><input value="" type="text" name="ticket_date" id="ticket_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Subject </td>
										<td><input value="" type="text" name="subject" id="subject" class="textboxxx  fWidth " style="width:600px;"/> </td>						
										</tr><tr >
	  									<td>Message </td>
										<td>
										<textarea name="message" id="message" style="width:600px; height:200px;" ></textarea>
										 </td>						
										</tr><tr  style="display:none;">
	  									<td >Status </td>
										<td>  
	
	<select name="ticket_status" id="ticket_status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->ticket_status);	?></select>	 </td>						
										</tr><tr style="display:none;" >
	  									<td>Status Date </td>
										<td><input value="" type="text" name="ticket_status_date" id="ticket_status_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr style="display:none;" >
	  									<td>Statusby </td>
										<td><input value="" type="text" name="statusby_admin_id" id="statusby_admin_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr style="display:none;" >
	  									<td>Note </td>
										<td><input value="" type="text" name="note" id="note" class="textboxxx  fWidth "/> </td>						
										</tr>	
										
										</tr>
										
										<tr   >
	  									<td>Documents  1 </td>
										<td><input   type="file" name="file_1" id="file_1"  /> </td>						
										</tr>	
										
										<tr   >
	  									<td>Documents  2 </td>
										<td><input   type="file" name="file_2" id="file_2"  /> </td>						
										</tr>	
										
										
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="ticket_id" value="0" />	
	<input type="hidden"  id="WT_ticketpagingPageno" value="1" />	
	<div class="formDivButton">						
	 
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_ticketEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	<div id="view_ticket_details">
	
	</div>
	
	 
	
	</td>
	
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_ticketListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var ticket_id_sVal= os.getVal('ticket_id_s'); 
 var branch_id_sVal= os.getVal('branch_id_s'); 
 var ticketby_admin_id_sVal= os.getVal('ticketby_admin_id_s'); 
 var f_ticket_date_sVal= os.getVal('f_ticket_date_s'); 
 var t_ticket_date_sVal= os.getVal('t_ticket_date_s'); 
 var subject_sVal= os.getVal('subject_s'); 
 var message_sVal= os.getVal('message_s'); 
 var ticket_status_sVal= os.getVal('ticket_status_s'); 
 var note_sVal= os.getVal('note_s'); 
formdata.append('ticket_id_s',ticket_id_sVal );
formdata.append('branch_id_s',branch_id_sVal );
formdata.append('ticketby_admin_id_s',ticketby_admin_id_sVal );
formdata.append('f_ticket_date_s',f_ticket_date_sVal );
formdata.append('t_ticket_date_s',t_ticket_date_sVal );
formdata.append('subject_s',subject_sVal );
formdata.append('message_s',message_sVal );
formdata.append('ticket_status_s',ticket_status_sVal );
formdata.append('note_s',note_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_ticketpagingPageno=os.getVal('WT_ticketpagingPageno');
	var url='wtpage='+WT_ticketpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_ticketListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_ticketListDiv',url,formdata);
		
}

WT_ticketListing();
function  searchReset() // reset Search Fields
	{
 os.setVal('ticket_id_s',''); 
 os.setVal('branch_id_s',''); 
 os.setVal('ticketby_admin_id_s',''); 
 os.setVal('f_ticket_date_s',''); 
 os.setVal('t_ticket_date_s',''); 
 os.setVal('subject_s',''); 
 os.setVal('message_s',''); 
 os.setVal('ticket_status_s',''); 
 os.setVal('note_s',''); 
	
		os.setVal('searchKey','');
		WT_ticketListing();	
	
	}
	
 
function WT_ticketEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var branch_idVal= os.getVal('branch_id'); 
var ticketby_admin_idVal= os.getVal('ticketby_admin_id'); 
var ticket_dateVal= os.getVal('ticket_date'); 
var subjectVal= os.getVal('subject'); 
var messageVal= os.getVal('message'); 
var ticket_statusVal= os.getVal('ticket_status'); 
var ticket_status_dateVal= os.getVal('ticket_status_date'); 
var statusby_admin_idVal= os.getVal('statusby_admin_id'); 
var noteVal= os.getVal('note'); 


 formdata.append('branch_id',branch_idVal );
 formdata.append('ticketby_admin_id',ticketby_admin_idVal );
 formdata.append('ticket_date',ticket_dateVal );
 formdata.append('subject',subjectVal );
 formdata.append('message',messageVal );
 formdata.append('ticket_status',ticket_statusVal );
 formdata.append('ticket_status_date',ticket_status_dateVal );
 formdata.append('statusby_admin_id',statusby_admin_idVal );
 formdata.append('note',noteVal );
 
 
  var file_1_o= os.getObj('file_1').files[0];
  if(file_1_o){  formdata.append('file_1',file_1_o,file_1_o.name );}
  
  var file_2_o= os.getObj('file_2').files[0];
  if(file_2_o){  formdata.append('file_2',file_2_o,file_2_o.name );}
  
  
 

	
if(os.check.empty('subject','Please Add Subject')==false){ return false;} 
if(os.check.empty('message','Please Add Message')==false){ return false;} 

	 var   ticket_id=os.getVal('ticket_id');
	 formdata.append('ticket_id',ticket_id );
  	var url='<? echo $ajaxFilePath ?>?WT_ticketEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_ticketReLoadList',url,formdata);

}	

function WT_ticketReLoadList(data) // after edit reload list
{
   //$('view_ticket_details').dialog('close');
   $( "#ticket_form" ).dialog( "close" );
	var d=data.split('#-#');
	var ticket_id=parseInt(d[0]);
	if(d[0]!='Error' && ticket_id>0)
	{
	  os.setVal('ticket_id',ticket_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_ticketListing();
}

function WT_ticketGetById(ticket_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('ticket_id',ticket_id );
	var url='<? echo $ajaxFilePath ?>?WT_ticketGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_ticketFillData',url,formdata);
				
}

function WT_ticketFillData(data)  // fill data form by JSON
{
   
	 os.setHtml('view_ticket_details',data);

  
}

function WT_ticketDeleteRowById(ticket_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(ticket_id)<1 || ticket_id==''){  
	var  ticket_id =os.getVal('ticket_id');
	}
	
	if(parseInt(ticket_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('ticket_id',ticket_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_ticketDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_ticketDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_ticketDeleteRowByIdResults(data)
{
	alert(data);
	WT_ticketListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_ticketpagingPageno',parseInt(pageNo));
	WT_ticketListing();
}
var global_ticket_id=ticket_id;
function save_reply(ticket_id) // get record by table primery id
{
	var formdata = new FormData();	 
	global_ticket_id=ticket_id;
	var msg=os.getVal('reply_msg');
	var ticket_status_reply=os.getVal('ticket_status_reply');
	formdata.append('ticket_status_reply',ticket_status_reply );
	formdata.append('ticket_id',ticket_id );
	formdata.append('reply_msg',msg );
	formdata.append('WT_save_reply','OK' );
	var url='<? echo $ajaxFilePath ?>?WT_save_reply=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('save_reply_result',url,formdata);
				
}

function save_reply_result(data)  // fill data form by JSON
{
   
	  alert(data);
      WT_ticketGetById(global_ticket_id);
  
}

	  function create_new_ticket()
   {
            os.setVal('subject','');
			os.setVal('message','');  
          
  			 popDialog('ticket_form','Create New Ticket',{'width':'750','height':'450'});
   }
	
	
	 
	 
</script>

 

  
 
<? include($site['root-wtos'].'bottom.php'); ?>