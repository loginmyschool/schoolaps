<?
/*
   # wtos version : 1.1
   # main ajax process page : branchAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List branch';
$ajaxFilePath= 'branchAjax.php';
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
    <td width="310"   valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv" style="height:480px; overflow:scroll; position:fixed; top:120px;">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_branchDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_branchEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Code </td>
										<td><input value="" type="text" name="branch_code" id="branch_code" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Full Name </td>
										<td><input value="" type="text" name="branch_name" id="branch_name" class="textboxxx  fWidth "/> </td>						
										</tr>
										<tr >
	  									<td>Short Name </td>
										<td><input value="" type="text" name="unit_name" id="unit_name" class="textboxxx  fWidth "/> </td>						
										</tr>
										<tr >
	  									<td>Address </td>
										<td><input value="" type="text" name="address" id="address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Contact </td>
										<td><input value="" type="text" name="contact" id="contact" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>PIN </td>
										<td><input value="" type="text" name="pin_code" id="pin_code" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Tag Line </td>
										<td><input value="" type="text" name="tagline" id="tagline" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Logo </td>
										<td>
										
										<img id="logoimagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="logoimage" value=""  id="logoimage" onchange="os.readURL(this,'logoimagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('logoimage');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Theme </td>
										<td><input value="" type="text" name="theme_data" id="theme_data" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>LAT </td>
										<td><input value="" type="text" name="latitude" id="latitude" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>LONG </td>
										<td><input value="" type="text" name="lognitude" id="lognitude" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>In-Charge </td>
										<td><input value="" type="text" name="incharge_name" id="incharge_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Unit Group </td>
										<td>  
	
	<select name="group_unit" id="group_unit" class="textbox fWidth" style="width:150px;" ><option value="">Select Unit Group</option>	<? 
										  $os->onlyOption($os->group_unit_list);	?></select>	 </td>						
										</tr><tr >
	  									<td>ESTD Date </td>
										<td><input value="" type="text" name="estd_date" id="estd_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Classes </td>
										<td><input value="" type="text" name="class_list" id="class_list" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>R/N </td>
										<td>  
	
	<select name="r_n" id="r_n" class="textbox fWidth" ><option value="">Select R/N</option>	<? 
										  $os->onlyOption($os->r_n_list);	?></select>	 </td>						
										</tr><tr >
	  									<td>Campus Type </td>
										<td>  
	
	<select name="campus_type" id="campus_type" class="textbox fWidth" ><option value="">Select Campus Type</option>	<? 
										  $os->onlyOption($os->campus_type);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="branch_id" value="0" />	
	<input type="hidden"  id="WT_branchpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_branchDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_branchEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Code: <input type="text" class="wtTextClass" name="branch_code_s" id="branch_code_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Contact: <input type="text" class="wtTextClass" name="contact_s" id="contact_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  PIN: <input type="text" class="wtTextClass" name="pin_code_s" id="pin_code_s" value="" /> &nbsp;  Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   In-Charge: <input type="text" class="wtTextClass" name="incharge_name_s" id="incharge_name_s" value="" /> &nbsp;  Unit Name: <input type="text" class="wtTextClass" name="unit_name_s" id="unit_name_s" value="" /> &nbsp;  Unit Group:
	
	<select name="group_unit" id="group_unit_s" class="textbox fWidth" ><option value="">Select Unit Group</option>	<? 
										  $os->onlyOption($os->group_unit_list);	?></select>	
  From ESTD Date: <input class="wtDateClass" type="text" name="f_estd_date_s" id="f_estd_date_s" value=""  /> &nbsp;   To ESTD Date: <input class="wtDateClass" type="text" name="t_estd_date_s" id="t_estd_date_s" value=""  /> &nbsp;  
   Classes: <input type="text" class="wtTextClass" name="class_list_s" id="class_list_s" value="" /> &nbsp;  R/N:
	
	<select name="r_n" id="r_n_s" class="textbox fWidth" ><option value="">Select R/N</option>	<? 
										  $os->onlyOption($os->r_n_list);	?></select>	
   Campus Type:
	
	<select name="campus_type" id="campus_type_s" class="textbox fWidth" ><option value="">Select Campus Type</option>	<? 
										  $os->onlyOption($os->campus_type);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_branchListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_branchListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_branchListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var branch_code_sVal= os.getVal('branch_code_s'); 
 var address_sVal= os.getVal('address_s'); 
 var contact_sVal= os.getVal('contact_s'); 
 var email_sVal= os.getVal('email_s'); 
 var pin_code_sVal= os.getVal('pin_code_s'); 
 var active_status_sVal= os.getVal('active_status_s'); 
 var incharge_name_sVal= os.getVal('incharge_name_s'); 
 var unit_name_sVal= os.getVal('unit_name_s'); 
 var group_unit_sVal= os.getVal('group_unit_s'); 
 var f_estd_date_sVal= os.getVal('f_estd_date_s'); 
 var t_estd_date_sVal= os.getVal('t_estd_date_s'); 
 var class_list_sVal= os.getVal('class_list_s'); 
 var r_n_sVal= os.getVal('r_n_s'); 
 var campus_type_sVal= os.getVal('campus_type_s'); 
formdata.append('branch_code_s',branch_code_sVal );
formdata.append('address_s',address_sVal );
formdata.append('contact_s',contact_sVal );
formdata.append('email_s',email_sVal );
formdata.append('pin_code_s',pin_code_sVal );
formdata.append('active_status_s',active_status_sVal );
formdata.append('incharge_name_s',incharge_name_sVal );
formdata.append('unit_name_s',unit_name_sVal );
formdata.append('group_unit_s',group_unit_sVal );
formdata.append('f_estd_date_s',f_estd_date_sVal );
formdata.append('t_estd_date_s',t_estd_date_sVal );
formdata.append('class_list_s',class_list_sVal );
formdata.append('r_n_s',r_n_sVal );
formdata.append('campus_type_s',campus_type_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_branchpagingPageno=os.getVal('WT_branchpagingPageno');
	var url='wtpage='+WT_branchpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_branchListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_branchListDiv',url,formdata);
		
}

WT_branchListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('branch_code_s',''); 
 os.setVal('address_s',''); 
 os.setVal('contact_s',''); 
 os.setVal('email_s',''); 
 os.setVal('pin_code_s',''); 
 os.setVal('active_status_s',''); 
 os.setVal('incharge_name_s',''); 
 os.setVal('unit_name_s',''); 
 os.setVal('group_unit_s',''); 
 os.setVal('f_estd_date_s',''); 
 os.setVal('t_estd_date_s',''); 
 os.setVal('class_list_s',''); 
 os.setVal('r_n_s',''); 
 os.setVal('campus_type_s',''); 
	
		os.setVal('searchKey','');
		WT_branchListing();	
	
	}
	
 
function WT_branchEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var branch_codeVal= os.getVal('branch_code'); 
var branch_nameVal= os.getVal('branch_name'); 
var addressVal= os.getVal('address'); 
var contactVal= os.getVal('contact'); 
var emailVal= os.getVal('email'); 
var pin_codeVal= os.getVal('pin_code'); 
var taglineVal= os.getVal('tagline'); 
var logoimageVal= os.getObj('logoimage').files[0]; 
var theme_dataVal= os.getVal('theme_data'); 
var latitudeVal= os.getVal('latitude'); 
var lognitudeVal= os.getVal('lognitude'); 
var active_statusVal= os.getVal('active_status'); 
var incharge_nameVal= os.getVal('incharge_name'); 
var unit_nameVal= os.getVal('unit_name'); 
var group_unitVal= os.getVal('group_unit'); 
var estd_dateVal= os.getVal('estd_date'); 
var class_listVal= os.getVal('class_list'); 
var r_nVal= os.getVal('r_n'); 
var campus_typeVal= os.getVal('campus_type'); 


 formdata.append('branch_code',branch_codeVal );
 formdata.append('branch_name',branch_nameVal );
 formdata.append('address',addressVal );
 formdata.append('contact',contactVal );
 formdata.append('email',emailVal );
 formdata.append('pin_code',pin_codeVal );
 formdata.append('tagline',taglineVal );
if(logoimageVal){  formdata.append('logoimage',logoimageVal,logoimageVal.name );}
 formdata.append('theme_data',theme_dataVal );
 formdata.append('latitude',latitudeVal );
 formdata.append('lognitude',lognitudeVal );
 formdata.append('active_status',active_statusVal );
 formdata.append('incharge_name',incharge_nameVal );
 formdata.append('unit_name',unit_nameVal );
 formdata.append('group_unit',group_unitVal );
 formdata.append('estd_date',estd_dateVal );
 formdata.append('class_list',class_listVal );
 formdata.append('r_n',r_nVal );
 formdata.append('campus_type',campus_typeVal );

	
if(os.check.empty('branch_code','Please Add Code')==false){ return false;} 
if(os.check.empty('branch_name','Please Add Name')==false){ return false;} 

	 var   branch_id=os.getVal('branch_id');
	 formdata.append('branch_id',branch_id );
  	var url='<? echo $ajaxFilePath ?>?WT_branchEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_branchReLoadList',url,formdata);

}	

function WT_branchReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var branch_id=parseInt(d[0]);
	if(d[0]!='Error' && branch_id>0)
	{
	  os.setVal('branch_id',branch_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_branchListing();
}

function WT_branchGetById(branch_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('branch_id',branch_id );
	var url='<? echo $ajaxFilePath ?>?WT_branchGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_branchFillData',url,formdata);
				
}

function WT_branchFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('branch_id',parseInt(objJSON.branch_id));
	
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('branch_name',objJSON.branch_name); 
 os.setVal('address',objJSON.address); 
 os.setVal('contact',objJSON.contact); 
 os.setVal('email',objJSON.email); 
 os.setVal('pin_code',objJSON.pin_code); 
 os.setVal('tagline',objJSON.tagline); 
 os.setImg('logoimagePreview',objJSON.logoimage); 
 os.setVal('theme_data',objJSON.theme_data); 
 os.setVal('latitude',objJSON.latitude); 
 os.setVal('lognitude',objJSON.lognitude); 
 os.setVal('active_status',objJSON.active_status); 
 os.setVal('incharge_name',objJSON.incharge_name); 
 os.setVal('unit_name',objJSON.unit_name); 
 os.setVal('group_unit',objJSON.group_unit); 
 os.setVal('estd_date',objJSON.estd_date); 
 os.setVal('class_list',objJSON.class_list); 
 os.setVal('r_n',objJSON.r_n); 
 os.setVal('campus_type',objJSON.campus_type); 

  
}

function WT_branchDeleteRowById(branch_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(branch_id)<1 || branch_id==''){  
	var  branch_id =os.getVal('branch_id');
	}
	
	if(parseInt(branch_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('branch_id',branch_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_branchDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_branchDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_branchDeleteRowByIdResults(data)
{
	alert(data);
	WT_branchListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_branchpagingPageno',parseInt(pageNo));
	WT_branchListing();
}
	 
</script>

<!-- board and class -->
<div id="board_and_class_DIV">
</div>
<script>
function board_and_class_link(branch_code,wt_action) 
{

   

	var formdata = new FormData();
	var data_class_list='';
	if(wt_action!='')
	{
	   var data_class_list= getValuesFromCheckedBox('data_class_list[]');
  
	}
	 
	formdata.append('data_class_list',data_class_list ); 		 	
	formdata.append('branch_code',branch_code ); 	
	formdata.append('board_and_class_link','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?board_and_class_link=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText"> Please wait. Working...</div></div>';	
	os.setAjaxFunc('board_and_class_link_result',url,formdata);
	 			
}

function board_and_class_link_result(data)
{
    
   var content_data=	getData(data,'##--board_and_class_DIV_data--##');
   os.setHtml('board_and_class_DIV',content_data);
   
    popDialog('board_and_class_DIV','Class List',{'width':'1000','height':'580'});
   
}
 
</script>

<!-- board and class -->

<style>
.no_border{ border:  0px ; width:100px;}
.head_g{ font-size:10px; color:#333333;}
.transparent_bg{ background:none;}
.transparent_bg:hover{ background:#FFFFFF;}
</style>
  
 
<? include($site['root-wtos'].'bottom.php'); ?>