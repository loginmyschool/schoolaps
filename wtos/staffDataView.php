<?
/*
   # wtos version : 1.1
   # main ajax process page : staffAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Staff';
$ajaxFilePath= 'staffAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_staffEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Designation </td>
										<td><input value="" type="text" name="designation" id="designation" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile No </td>
										<td><input value="" type="text" name="mobile" id="mobile" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><textarea  name="address" id="address" ></textarea></td>						
										</tr><tr >
	  									<td>Priority </td>
										<td><input value="" type="text" name="priority" id="priority" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->staffStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="staffId" value="0" />	
	<input type="hidden"  id="WT_staffpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_staffEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Designation: <input type="text" class="wtTextClass" name="designation_s" id="designation_s" value="" /> &nbsp;  Mobile No: <input type="text" class="wtTextClass" name="mobile_s" id="mobile_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Priority: <input type="text" class="wtTextClass" name="priority_s" id="priority_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->staffStatus);	?></select>	
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_staffListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_staffListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_staffListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var designation_sVal= os.getVal('designation_s'); 
 var mobile_sVal= os.getVal('mobile_s'); 
 var address_sVal= os.getVal('address_s'); 
 var priority_sVal= os.getVal('priority_s'); 
 var status_sVal= os.getVal('status_s'); 
 var note_sVal= os.getVal('note_s'); 
formdata.append('name_s',name_sVal );
formdata.append('designation_s',designation_sVal );
formdata.append('mobile_s',mobile_sVal );
formdata.append('address_s',address_sVal );
formdata.append('priority_s',priority_sVal );
formdata.append('status_s',status_sVal );
formdata.append('note_s',note_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_staffpagingPageno=os.getVal('WT_staffpagingPageno');
	var url='wtpage='+WT_staffpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_staffListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_staffListDiv',url,formdata);
		
}

WT_staffListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('designation_s',''); 
 os.setVal('mobile_s',''); 
 os.setVal('address_s',''); 
 os.setVal('priority_s',''); 
 os.setVal('status_s',''); 
 os.setVal('note_s',''); 
	
		os.setVal('searchKey','');
		WT_staffListing();	
	
	}
	
 
function WT_staffEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var designationVal= os.getVal('designation'); 
var mobileVal= os.getVal('mobile'); 
var addressVal= os.getVal('address'); 
var priorityVal= os.getVal('priority'); 
var statusVal= os.getVal('status'); 
var noteVal= os.getVal('note'); 


 formdata.append('name',nameVal );
 formdata.append('designation',designationVal );
 formdata.append('mobile',mobileVal );
 formdata.append('address',addressVal );
 formdata.append('priority',priorityVal );
 formdata.append('status',statusVal );
 formdata.append('note',noteVal );

	
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('designation','Please Add Designation')==false){ return false;} 

	 var   staffId=os.getVal('staffId');
	 formdata.append('staffId',staffId );
  	var url='<? echo $ajaxFilePath ?>?WT_staffEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_staffReLoadList',url,formdata);

}	

function WT_staffReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var staffId=parseInt(d[0]);
	if(d[0]!='Error' && staffId>0)
	{
	  os.setVal('staffId',staffId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_staffListing();
}







function checkEditDeletePassword(staffId)
{
var formdata = new FormData();	
	
	if(parseInt(staffId)<1 || staffId==''){  
	
	var  staffId =os.getVal('staffId');
	formdata.append('operationType','deleteData');
	}
	
	var password= prompt("Please Enter Password");
	if(password)
	{
 
	formdata.append('staffId',staffId );
	formdata.append('password',password );
	
	var url='<? echo $ajaxFilePath ?>?checkEditDeletePassword=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('checkEditDeletePasswordResult',url,formdata);
	
	}
	
	
}

function checkEditDeletePasswordResult(data)
{
	if(data=='wrong password')
	{
		alert(data);
	}
	else
	{
		var d=data.split('#-#');
		var staffId=parseInt(d[1]);
		
		var operationType=d[2];
		
		if(operationType=='Edit Data')
		{
		WT_staffGetById(staffId);
		}
		if(operationType=='Delete Data')
		{
			WT_staffDeleteRowById(staffId);
		}
		
	}
	
}





function WT_staffGetById(staffId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('staffId',staffId );
	var url='<? echo $ajaxFilePath ?>?WT_staffGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_staffFillData',url,formdata);
				
}

function WT_staffFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('staffId',parseInt(objJSON.staffId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('designation',objJSON.designation); 
 os.setVal('mobile',objJSON.mobile); 
 os.setVal('address',objJSON.address); 
 os.setVal('priority',objJSON.priority); 
 os.setVal('status',objJSON.status); 
 os.setVal('note',objJSON.note); 

  
}

function WT_staffDeleteRowById(staffId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(staffId)<1 || staffId==''){  
	var  staffId =os.getVal('staffId');
	}
	
	if(parseInt(staffId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('staffId',staffId );
	
	var url='<? echo $ajaxFilePath ?>?WT_staffDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_staffDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_staffDeleteRowByIdResults(data)
{
	alert(data);
	WT_staffListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_staffpagingPageno',parseInt(pageNo));
	WT_staffListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>