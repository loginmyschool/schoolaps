<?
/*
   # wtos version : 1.1
   # main ajax process page : travel_driverAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Travel Driver';
$ajaxFilePath= 'travel_driverAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_travel_driverDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_travel_driverEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><textarea  name="address" id="address" ></textarea></td>						
										</tr><tr >
	  									<td>Contact </td>
										<td><input value="" type="text" name="contact" id="contact" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Driving License </td>
										<td>
										
										<img id="driving_licensePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="driving_license" value=""  id="driving_license" onchange="os.readURL(this,'driving_licensePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('driving_license');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Idcard Details </td>
										<td><input value="" type="text" name="idcard_details" id="idcard_details" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Provider Type </td>
										<td>  
	
	<select name="provider_type" id="provider_type" class="textbox fWidth" ><option value="">Select Provider Type</option>	<? 
										  $os->onlyOption($os->provider_type);	?></select>	 </td>						
										</tr><tr >
	  									<td>Provider Name </td>
										<td><input value="" type="text" name="provider_name" id="provider_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Provider Details </td>
										<td><input value="" type="text" name="provider_details" id="provider_details" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="travel_driver_id" value="0" />	
	<input type="hidden"  id="WT_travel_driverpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_travel_driverDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_travel_driverEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Contact: <input type="text" class="wtTextClass" name="contact_s" id="contact_s" value="" /> &nbsp;   Idcard Details: <input type="text" class="wtTextClass" name="idcard_details_s" id="idcard_details_s" value="" /> &nbsp;  Provider Type:
	
	<select name="provider_type" id="provider_type_s" class="textbox fWidth" ><option value="">Select Provider Type</option>	<? 
										  $os->onlyOption($os->provider_type);	?></select>	
   Provider Name: <input type="text" class="wtTextClass" name="provider_name_s" id="provider_name_s" value="" /> &nbsp;  Provider Details: <input type="text" class="wtTextClass" name="provider_details_s" id="provider_details_s" value="" /> &nbsp;  Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_travel_driverListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_travel_driverListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_travel_driverListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var address_sVal= os.getVal('address_s'); 
 var contact_sVal= os.getVal('contact_s'); 
 var idcard_details_sVal= os.getVal('idcard_details_s'); 
 var provider_type_sVal= os.getVal('provider_type_s'); 
 var provider_name_sVal= os.getVal('provider_name_s'); 
 var provider_details_sVal= os.getVal('provider_details_s'); 
 var active_status_sVal= os.getVal('active_status_s'); 
formdata.append('name_s',name_sVal );
formdata.append('address_s',address_sVal );
formdata.append('contact_s',contact_sVal );
formdata.append('idcard_details_s',idcard_details_sVal );
formdata.append('provider_type_s',provider_type_sVal );
formdata.append('provider_name_s',provider_name_sVal );
formdata.append('provider_details_s',provider_details_sVal );
formdata.append('active_status_s',active_status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_travel_driverpagingPageno=os.getVal('WT_travel_driverpagingPageno');
	var url='wtpage='+WT_travel_driverpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_travel_driverListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_travel_driverListDiv',url,formdata);
		
}

WT_travel_driverListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('address_s',''); 
 os.setVal('contact_s',''); 
 os.setVal('idcard_details_s',''); 
 os.setVal('provider_type_s',''); 
 os.setVal('provider_name_s',''); 
 os.setVal('provider_details_s',''); 
 os.setVal('active_status_s',''); 
	
		os.setVal('searchKey','');
		WT_travel_driverListing();	
	
	}
	
 
function WT_travel_driverEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var addressVal= os.getVal('address'); 
var contactVal= os.getVal('contact'); 
var driving_licenseVal= os.getObj('driving_license').files[0]; 
var idcard_detailsVal= os.getVal('idcard_details'); 
var provider_typeVal= os.getVal('provider_type'); 
var provider_nameVal= os.getVal('provider_name'); 
var provider_detailsVal= os.getVal('provider_details'); 
var active_statusVal= os.getVal('active_status'); 


 formdata.append('name',nameVal );
 formdata.append('address',addressVal );
 formdata.append('contact',contactVal );
if(driving_licenseVal){  formdata.append('driving_license',driving_licenseVal,driving_licenseVal.name );}
 formdata.append('idcard_details',idcard_detailsVal );
 formdata.append('provider_type',provider_typeVal );
 formdata.append('provider_name',provider_nameVal );
 formdata.append('provider_details',provider_detailsVal );
 formdata.append('active_status',active_statusVal );

	

	 var   travel_driver_id=os.getVal('travel_driver_id');
	 formdata.append('travel_driver_id',travel_driver_id );
  	var url='<? echo $ajaxFilePath ?>?WT_travel_driverEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_travel_driverReLoadList',url,formdata);

}	

function WT_travel_driverReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var travel_driver_id=parseInt(d[0]);
	if(d[0]!='Error' && travel_driver_id>0)
	{
	  os.setVal('travel_driver_id',travel_driver_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_travel_driverListing();
}

function WT_travel_driverGetById(travel_driver_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('travel_driver_id',travel_driver_id );
	var url='<? echo $ajaxFilePath ?>?WT_travel_driverGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_travel_driverFillData',url,formdata);
				
}

function WT_travel_driverFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('travel_driver_id',parseInt(objJSON.travel_driver_id));
	
 os.setVal('name',objJSON.name); 
 os.setVal('address',objJSON.address); 
 os.setVal('contact',objJSON.contact); 
 os.setImg('driving_licensePreview',objJSON.driving_license); 
 os.setVal('idcard_details',objJSON.idcard_details); 
 os.setVal('provider_type',objJSON.provider_type); 
 os.setVal('provider_name',objJSON.provider_name); 
 os.setVal('provider_details',objJSON.provider_details); 
 os.setVal('active_status',objJSON.active_status); 

  
}

function WT_travel_driverDeleteRowById(travel_driver_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(travel_driver_id)<1 || travel_driver_id==''){  
	var  travel_driver_id =os.getVal('travel_driver_id');
	}
	
	if(parseInt(travel_driver_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('travel_driver_id',travel_driver_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_travel_driverDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_travel_driverDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_travel_driverDeleteRowByIdResults(data)
{
	alert(data);
	WT_travel_driverListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_travel_driverpagingPageno',parseInt(pageNo));
	WT_travel_driverListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>