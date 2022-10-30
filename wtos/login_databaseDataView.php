<?
/*
   # wtos version : 1.1
   # main ajax process page : login_databaseAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Logins';
$ajaxFilePath= 'login_databaseAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_login_databaseDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_login_databaseEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile </td>
										<td><input value="" type="text" name="mobile" id="mobile" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>School Name </td>
										<td><input value="" type="text" name="school_name" id="school_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Schoool Address </td>
										<td><input value="" type="text" name="school_address" id="school_address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>User </td>
										<td><input value="" type="text" name="login_username" id="login_username" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Pass </td>
										<td><input value="" type="text" name="login_password" id="login_password" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Database </td>
										<td><input value="" type="text" name="database_name" id="database_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="activeStatus" id="activeStatus" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>School Code </td>
										<td><input value="" type="text" name="schoolCode" id="schoolCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Member Type </td>
										<td>  
	
	<select name="memberType" id="memberType" class="textbox fWidth" ><option value="">Select Member Type</option>	<? 
										  $os->onlyOption($os->memberType);	?></select>	 </td>						
										</tr><tr >
	  									<td>Remarks </td>
										<td><input value="" type="text" name="remarks" id="remarks" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="login_database_id" value="0" />	
	<input type="hidden"  id="WT_login_databasepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_login_databaseDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_login_databaseEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Mobile: <input type="text" class="wtTextClass" name="mobile_s" id="mobile_s" value="" /> &nbsp;  School Name: <input type="text" class="wtTextClass" name="school_name_s" id="school_name_s" value="" /> &nbsp;  Schoool Address: <input type="text" class="wtTextClass" name="school_address_s" id="school_address_s" value="" /> &nbsp;  User: <input type="text" class="wtTextClass" name="login_username_s" id="login_username_s" value="" /> &nbsp;  Database: <input type="text" class="wtTextClass" name="database_name_s" id="database_name_s" value="" /> &nbsp;  Status:
	
	<select name="activeStatus" id="activeStatus_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
  From Last Login: <input class="wtDateClass" type="text" name="f_lastLoginDate_s" id="f_lastLoginDate_s" value=""  /> &nbsp;   To Last Login: <input class="wtDateClass" type="text" name="t_lastLoginDate_s" id="t_lastLoginDate_s" value=""  /> &nbsp;  
   School Code: <input type="text" class="wtTextClass" name="schoolCode_s" id="schoolCode_s" value="" /> &nbsp;  Member Type:
	
	<select name="memberType" id="memberType_s" class="textbox fWidth" ><option value="">Select Member Type</option>	<? 
										  $os->onlyOption($os->memberType);	?></select>	
   Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;  loginIP: <input type="text" class="wtTextClass" name="loginIP_s" id="loginIP_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_login_databaseListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_login_databaseListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_login_databaseListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var mobile_sVal= os.getVal('mobile_s'); 
 var school_name_sVal= os.getVal('school_name_s'); 
 var school_address_sVal= os.getVal('school_address_s'); 
 var login_username_sVal= os.getVal('login_username_s'); 
 var database_name_sVal= os.getVal('database_name_s'); 
 var activeStatus_sVal= os.getVal('activeStatus_s'); 
 var f_lastLoginDate_sVal= os.getVal('f_lastLoginDate_s'); 
 var t_lastLoginDate_sVal= os.getVal('t_lastLoginDate_s'); 
 var schoolCode_sVal= os.getVal('schoolCode_s'); 
 var memberType_sVal= os.getVal('memberType_s'); 
 var remarks_sVal= os.getVal('remarks_s'); 
 var loginIP_sVal= os.getVal('loginIP_s'); 
formdata.append('name_s',name_sVal );
formdata.append('mobile_s',mobile_sVal );
formdata.append('school_name_s',school_name_sVal );
formdata.append('school_address_s',school_address_sVal );
formdata.append('login_username_s',login_username_sVal );
formdata.append('database_name_s',database_name_sVal );
formdata.append('activeStatus_s',activeStatus_sVal );
formdata.append('f_lastLoginDate_s',f_lastLoginDate_sVal );
formdata.append('t_lastLoginDate_s',t_lastLoginDate_sVal );
formdata.append('schoolCode_s',schoolCode_sVal );
formdata.append('memberType_s',memberType_sVal );
formdata.append('remarks_s',remarks_sVal );
formdata.append('loginIP_s',loginIP_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_login_databasepagingPageno=os.getVal('WT_login_databasepagingPageno');
	var url='wtpage='+WT_login_databasepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_login_databaseListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_login_databaseListDiv',url,formdata);
		
}

WT_login_databaseListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('mobile_s',''); 
 os.setVal('school_name_s',''); 
 os.setVal('school_address_s',''); 
 os.setVal('login_username_s',''); 
 os.setVal('database_name_s',''); 
 os.setVal('activeStatus_s',''); 
 os.setVal('f_lastLoginDate_s',''); 
 os.setVal('t_lastLoginDate_s',''); 
 os.setVal('schoolCode_s',''); 
 os.setVal('memberType_s',''); 
 os.setVal('remarks_s',''); 
 os.setVal('loginIP_s',''); 
	
		os.setVal('searchKey','');
		WT_login_databaseListing();	
	
	}
	
 
function WT_login_databaseEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var mobileVal= os.getVal('mobile'); 
var school_nameVal= os.getVal('school_name'); 
var school_addressVal= os.getVal('school_address'); 
var login_usernameVal= os.getVal('login_username'); 
var login_passwordVal= os.getVal('login_password'); 
var database_nameVal= os.getVal('database_name'); 
var activeStatusVal= os.getVal('activeStatus'); 
var schoolCodeVal= os.getVal('schoolCode'); 
var memberTypeVal= os.getVal('memberType'); 
var remarksVal= os.getVal('remarks'); 


 formdata.append('name',nameVal );
 formdata.append('mobile',mobileVal );
 formdata.append('school_name',school_nameVal );
 formdata.append('school_address',school_addressVal );
 formdata.append('login_username',login_usernameVal );
 formdata.append('login_password',login_passwordVal );
 formdata.append('database_name',database_nameVal );
 formdata.append('activeStatus',activeStatusVal );
 formdata.append('schoolCode',schoolCodeVal );
 formdata.append('memberType',memberTypeVal );
 formdata.append('remarks',remarksVal );

	
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('mobile','Please Add Mobile')==false){ return false;} 
if(os.check.empty('school_name','Please Add School Name')==false){ return false;} 
if(os.check.empty('login_username','Please Add User')==false){ return false;} 
if(os.check.empty('login_password','Please Add Pass')==false){ return false;} 
if(os.check.empty('database_name','Please Add Database')==false){ return false;} 

	 var   login_database_id=os.getVal('login_database_id');
	 formdata.append('login_database_id',login_database_id );
  	var url='<? echo $ajaxFilePath ?>?WT_login_databaseEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_login_databaseReLoadList',url,formdata);

}	

function WT_login_databaseReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var login_database_id=parseInt(d[0]);
	if(d[0]!='Error' && login_database_id>0)
	{
	  os.setVal('login_database_id',login_database_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_login_databaseListing();
}

function WT_login_databaseGetById(login_database_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('login_database_id',login_database_id );
	var url='<? echo $ajaxFilePath ?>?WT_login_databaseGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_login_databaseFillData',url,formdata);
				
}

function WT_login_databaseFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('login_database_id',parseInt(objJSON.login_database_id));
	
 os.setVal('name',objJSON.name); 
 os.setVal('mobile',objJSON.mobile); 
 os.setVal('school_name',objJSON.school_name); 
 os.setVal('school_address',objJSON.school_address); 
 os.setVal('login_username',objJSON.login_username); 
 os.setVal('login_password',objJSON.login_password); 
 os.setVal('database_name',objJSON.database_name); 
 os.setVal('activeStatus',objJSON.activeStatus); 
 os.setVal('schoolCode',objJSON.schoolCode); 
 os.setVal('memberType',objJSON.memberType); 
 os.setVal('remarks',objJSON.remarks); 

  
}

function WT_login_databaseDeleteRowById(login_database_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(login_database_id)<1 || login_database_id==''){  
	var  login_database_id =os.getVal('login_database_id');
	}
	
	if(parseInt(login_database_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('login_database_id',login_database_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_login_databaseDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_login_databaseDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_login_databaseDeleteRowByIdResults(data)
{
	alert(data);
	WT_login_databaseListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_login_databasepagingPageno',parseInt(pageNo));
	WT_login_databaseListing();
}

function setup_school(data)
{

os.setVal('setup_school_data',data);
os.submitForm('setup_school');

}	
	
	
	 
	 
</script>
<form id="setup_school" action="<? echo $site['url'];?>wtos/school_setup_ajax.php?school_setup=ok" method="POST">
	<input type="hidden" id="setup_school_data" name="setup_school_data" value="">
</form>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>