<?
/*
   # wtos version : 1.1
   # main ajax process page : rbemployeeAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Manage Employee';
$ajaxFilePath= 'rbemployeeAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbemployeeDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbemployeeEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Designation </td>
										<td><input value="" type="text" name="designation" id="designation" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>DOB </td>
										<td><input value="" type="text" name="dob" id="dob" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>DOJ </td>
										<td><input value="" type="text" name="doj" id="doj" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Address </td>
										<td><textarea  name="address" id="address" ></textarea></td>						
										</tr><tr >
	  									<td>Moble </td>
										<td><input value="" type="text" name="moble" id="moble" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Phone </td>
										<td><input value="" type="text" name="phone" id="phone" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Reffer By </td>
										<td><input value="" type="text" name="reffBy" id="reffBy" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Start Salary </td>
										<td><input value="" type="text" name="startSalary" id="startSalary" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Perma Address </td>
										<td><textarea  name="permaAddress" id="permaAddress" ></textarea></td>						
										</tr><tr >
	  									<td>Leaving Date </td>
										<td><input value="" type="text" name="leavDate" id="leavDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Leaving Reason </td>
										<td><textarea  name="leaveReason" id="leaveReason" ></textarea></td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	 </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbemployeeId" value="0" />	
	<input type="hidden"  id="WT_rbemployeepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbemployeeDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbemployeeEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Designation: <input type="text" class="wtTextClass" name="designation_s" id="designation_s" value="" /> &nbsp; From DOJ: <input class="wtDateClass" type="text" name="f_doj_s" id="f_doj_s" value=""  /> &nbsp;   To DOJ: <input class="wtDateClass" type="text" name="t_doj_s" id="t_doj_s" value=""  /> &nbsp;  
   Moble: <input type="text" class="wtTextClass" name="moble_s" id="moble_s" value="" /> &nbsp;  Phone: <input type="text" class="wtTextClass" name="phone_s" id="phone_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbemployeeListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbemployeeListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbemployeeListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var designation_sVal= os.getVal('designation_s'); 
 var f_doj_sVal= os.getVal('f_doj_s'); 
 var t_doj_sVal= os.getVal('t_doj_s'); 
 var moble_sVal= os.getVal('moble_s'); 
 var phone_sVal= os.getVal('phone_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('name_s',name_sVal );
formdata.append('designation_s',designation_sVal );
formdata.append('f_doj_s',f_doj_sVal );
formdata.append('t_doj_s',t_doj_sVal );
formdata.append('moble_s',moble_sVal );
formdata.append('phone_s',phone_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbemployeepagingPageno=os.getVal('WT_rbemployeepagingPageno');
	var url='wtpage='+WT_rbemployeepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbemployeeListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbemployeeListDiv',url,formdata);
		
}

WT_rbemployeeListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('designation_s',''); 
 os.setVal('f_doj_s',''); 
 os.setVal('t_doj_s',''); 
 os.setVal('moble_s',''); 
 os.setVal('phone_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_rbemployeeListing();	
	
	}
	
 
function WT_rbemployeeEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var designationVal= os.getVal('designation'); 
var dobVal= os.getVal('dob'); 
var dojVal= os.getVal('doj'); 
var addressVal= os.getVal('address'); 
var mobleVal= os.getVal('moble'); 
var phoneVal= os.getVal('phone'); 
var emailVal= os.getVal('email'); 
var reffByVal= os.getVal('reffBy'); 
var startSalaryVal= os.getVal('startSalary'); 
var permaAddressVal= os.getVal('permaAddress'); 
var leavDateVal= os.getVal('leavDate'); 
var leaveReasonVal= os.getVal('leaveReason'); 
var statusVal= os.getVal('status'); 
var noteVal= os.getVal('note'); 


 formdata.append('name',nameVal );
 formdata.append('designation',designationVal );
 formdata.append('dob',dobVal );
 formdata.append('doj',dojVal );
 formdata.append('address',addressVal );
 formdata.append('moble',mobleVal );
 formdata.append('phone',phoneVal );
 formdata.append('email',emailVal );
 formdata.append('reffBy',reffByVal );
 formdata.append('startSalary',startSalaryVal );
 formdata.append('permaAddress',permaAddressVal );
 formdata.append('leavDate',leavDateVal );
 formdata.append('leaveReason',leaveReasonVal );
 formdata.append('status',statusVal );
 formdata.append('note',noteVal );

	
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('designation','Please Add Designation')==false){ return false;} 
if(os.check.empty('dob','Please Add DOB')==false){ return false;} 
if(os.check.empty('doj','Please Add DOJ')==false){ return false;} 
if(os.check.empty('moble','Please Add Moble')==false){ return false;} 
if(os.check.empty('phone','Please Add Phone')==false){ return false;} 
if(os.check.empty('email','Please Add Email')==false){ return false;} 
if(os.check.empty('status','Please Add Status')==false){ return false;} 

	 var   rbemployeeId=os.getVal('rbemployeeId');
	 formdata.append('rbemployeeId',rbemployeeId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbemployeeEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbemployeeReLoadList',url,formdata);

}	

function WT_rbemployeeReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbemployeeId=parseInt(d[0]);
	if(d[0]!='Error' && rbemployeeId>0)
	{
	  os.setVal('rbemployeeId',rbemployeeId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbemployeeListing();
}

function WT_rbemployeeGetById(rbemployeeId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbemployeeId',rbemployeeId );
	var url='<? echo $ajaxFilePath ?>?WT_rbemployeeGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbemployeeFillData',url,formdata);
				
}

function WT_rbemployeeFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbemployeeId',parseInt(objJSON.rbemployeeId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('designation',objJSON.designation); 
 os.setVal('dob',objJSON.dob); 
 os.setVal('doj',objJSON.doj); 
 os.setVal('address',objJSON.address); 
 os.setVal('moble',objJSON.moble); 
 os.setVal('phone',objJSON.phone); 
 os.setVal('email',objJSON.email); 
 os.setVal('reffBy',objJSON.reffBy); 
 os.setVal('startSalary',objJSON.startSalary); 
 os.setVal('permaAddress',objJSON.permaAddress); 
 os.setVal('leavDate',objJSON.leavDate); 
 os.setVal('leaveReason',objJSON.leaveReason); 
 os.setVal('status',objJSON.status); 
 os.setVal('note',objJSON.note); 

  
}

function WT_rbemployeeDeleteRowById(rbemployeeId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbemployeeId)<1 || rbemployeeId==''){  
	var  rbemployeeId =os.getVal('rbemployeeId');
	}
	
	if(parseInt(rbemployeeId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbemployeeId',rbemployeeId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbemployeeDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbemployeeDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbemployeeDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbemployeeListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbemployeepagingPageno',parseInt(pageNo));
	WT_rbemployeeListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>