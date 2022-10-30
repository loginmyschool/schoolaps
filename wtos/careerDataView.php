<?
/*
   # wtos version : 1.1
   # main ajax process page : careerAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List career';
$ajaxFilePath= 'careerAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_careerDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" style="display:none;"/>
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_careerEditAndSave();"  style="display:none;"/><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><textarea  name="address" id="address" ></textarea></td>						
										</tr><tr >
	  									<td>Postal Code </td>
										<td><input value="" type="text" name="postalCode" id="postalCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>City </td>
										<td><input value="" type="text" name="city" id="city" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>State </td>
										<td><input value="" type="text" name="state" id="state" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile No </td>
										<td><input value="" type="text" name="mobile" id="mobile" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Department </td>
										<td>  
	
	<select name="department" id="department" class="textbox fWidth" ><? 
										  $os->onlyOption($os->careerDepartment);	?></select>	 </td>						
										</tr><tr >
	  									<td>Reference </td>
										<td><input value="" type="text" name="reference" id="reference" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>CV </td>
										<td>
										
										<!--<img id="imagePreview" src="" height="100" style="display:none;"	 />	
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit CV</span>-->	
										 
										 <input type="file" name="image" value=""  id="image" /><br>
										
										 
										</td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="careerId" value="0" />	
	<input type="hidden"  id="WT_careerpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_careerDeleteRowById('');"  />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" style="display:none;"/>
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_careerEditAndSave();"  style="display:none;"/><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Postal Code: <input type="text" class="wtTextClass" name="postalCode_s" id="postalCode_s" value="" /> &nbsp;  City: <input type="text" class="wtTextClass" name="city_s" id="city_s" value="" /> &nbsp;  State: <input type="text" class="wtTextClass" name="state_s" id="state_s" value="" /> &nbsp;  Mobile No: <input type="text" class="wtTextClass" name="mobile_s" id="mobile_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Department:
	
	<select name="department" id="department_s" class="textbox fWidth" ><option value="">Select Department</option>	<? 
										  $os->onlyOption($os->careerDepartment);	?></select>	
   Reference: <input type="text" class="wtTextClass" name="reference_s" id="reference_s" value="" /> &nbsp;   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_careerListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_careerListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_careerListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var address_sVal= os.getVal('address_s'); 
 var postalCode_sVal= os.getVal('postalCode_s'); 
 var city_sVal= os.getVal('city_s'); 
 var state_sVal= os.getVal('state_s'); 
 var mobile_sVal= os.getVal('mobile_s'); 
 var email_sVal= os.getVal('email_s'); 
 var department_sVal= os.getVal('department_s'); 
 var reference_sVal= os.getVal('reference_s'); 
formdata.append('name_s',name_sVal );
formdata.append('address_s',address_sVal );
formdata.append('postalCode_s',postalCode_sVal );
formdata.append('city_s',city_sVal );
formdata.append('state_s',state_sVal );
formdata.append('mobile_s',mobile_sVal );
formdata.append('email_s',email_sVal );
formdata.append('department_s',department_sVal );
formdata.append('reference_s',reference_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_careerpagingPageno=os.getVal('WT_careerpagingPageno');
	var url='wtpage='+WT_careerpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_careerListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_careerListDiv',url,formdata);
		
}

WT_careerListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('address_s',''); 
 os.setVal('postalCode_s',''); 
 os.setVal('city_s',''); 
 os.setVal('state_s',''); 
 os.setVal('mobile_s',''); 
 os.setVal('email_s',''); 
 os.setVal('department_s',''); 
 os.setVal('reference_s',''); 
	
		os.setVal('searchKey','');
		WT_careerListing();	
	
	}
	
 
function WT_careerEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var addressVal= os.getVal('address'); 
var postalCodeVal= os.getVal('postalCode'); 
var cityVal= os.getVal('city'); 
var stateVal= os.getVal('state'); 
var mobileVal= os.getVal('mobile'); 
var emailVal= os.getVal('email'); 
var departmentVal= os.getVal('department'); 
var referenceVal= os.getVal('reference'); 
var imageVal= os.getObj('image').files[0]; 


 formdata.append('name',nameVal );
 formdata.append('address',addressVal );
 formdata.append('postalCode',postalCodeVal );
 formdata.append('city',cityVal );
 formdata.append('state',stateVal );
 formdata.append('mobile',mobileVal );
 formdata.append('email',emailVal );
 formdata.append('department',departmentVal );
 formdata.append('reference',referenceVal );
if(imageVal){  formdata.append('image',imageVal,imageVal.name );}

	

	 var   careerId=os.getVal('careerId');
	 formdata.append('careerId',careerId );
  	var url='<? echo $ajaxFilePath ?>?WT_careerEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_careerReLoadList',url,formdata);

}	

function WT_careerReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var careerId=parseInt(d[0]);
	if(d[0]!='Error' && careerId>0)
	{
	  os.setVal('careerId',careerId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_careerListing();
}

function WT_careerGetById(careerId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('careerId',careerId );
	var url='<? echo $ajaxFilePath ?>?WT_careerGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_careerFillData',url,formdata);
				
}

function WT_careerFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('careerId',parseInt(objJSON.careerId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('address',objJSON.address); 
 os.setVal('postalCode',objJSON.postalCode); 
 os.setVal('city',objJSON.city); 
 os.setVal('state',objJSON.state); 
 os.setVal('mobile',objJSON.mobile); 
 os.setVal('email',objJSON.email); 
 os.setVal('department',objJSON.department); 
 os.setVal('reference',objJSON.reference); 
// os.setImg('imagePreview',objJSON.image); 

  
}

function WT_careerDeleteRowById(careerId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(careerId)<1 || careerId==''){  
	var  careerId =os.getVal('careerId');
	}
	
	if(parseInt(careerId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('careerId',careerId );
	
	var url='<? echo $ajaxFilePath ?>?WT_careerDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_careerDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_careerDeleteRowByIdResults(data)
{
	alert(data);
	WT_careerListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_careerpagingPageno',parseInt(pageNo));
	WT_careerListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>