<?
/*
   # wtos version : 1.1
   # main ajax process page : rbcontactAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List rbcontact';
$ajaxFilePath= 'rbcontactAjax.php';
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
    <td width="300" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcontactDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbcontactEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Person </td>
										<td><input value="" type="text" name="person" id="person" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Company </td>
										<td><input value="" type="text" name="company" id="company" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Phone </td>
										<td><input value="" type="text" name="phone" id="phone" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Category </td>
										<td> <select name="rbcategoryId" id="rbcategoryId" class="textbox fWidth" ><option value="">Select Category</option>		  	<? 
								
										  $os->optionsHTML('','rbcategoryId','name','rbcategory');?>
							</select> </td>						
										</tr><tr >
	  									<td>Location </td>
										<td> <select name="rblocationId" id="rblocationId" class="textbox fWidth" ><option value="">Select Location</option>		  	<? 
								
										  $os->optionsHTML('','rblocationId','name','rblocation');?>
							</select> </td>						
										</tr><tr >
	  									<td>Contact Status </td>
										<td>  
	
	<select name="contactStatus" id="contactStatus" class="textbox fWidth" ><option value="">Select Contact Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	 </td>						
										</tr><tr >
	  									<td>Website Url </td>
										<td><input value="" type="text" name="websiteUrl" id="websiteUrl" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Reffer By </td>
										<td><input value="" type="text" name="refferBy" id="refferBy" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><input value="" type="text" name="address" id="address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Postcode </td>
										<td><input value="" type="text" name="postcode" id="postcode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Remarks </td>
										<td><input value="" type="text" name="remarks" id="remarks" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Priority </td>
										<td>  
	
	<select name="priority" id="priority" class="textbox fWidth" ><option value="">Select Priority</option>	<? 
										  $os->onlyOption($os->priorities);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbcontactId" value="0" />	
	<input type="hidden"  id="WT_rbcontactpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcontactDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbcontactEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp;  Person: <input type="text" class="wtTextClass" name="person_s" id="person_s" value="" /> &nbsp;  Company: <input type="text" class="wtTextClass" name="company_s" id="company_s" value="" /> &nbsp;  Phone: <input type="text" class="wtTextClass" name="phone_s" id="phone_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Category:
	
	
	<select name="rbcategoryId" id="rbcategoryId_s" class="textbox fWidth" ><option value="">Select Category</option>		  	<? 
								
										  $os->optionsHTML('','rbcategoryId','name','rbcategory');?>
							</select>
   Location:
	
	
	<select name="rblocationId" id="rblocationId_s" class="textbox fWidth" ><option value="">Select Location</option>		  	<? 
								
										  $os->optionsHTML('','rblocationId','name','rblocation');?>
							</select>
   Contact Status:
	
	<select name="contactStatus" id="contactStatus_s" class="textbox fWidth" ><option value="">Select Contact Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	
   Website Url: <input type="text" class="wtTextClass" name="websiteUrl_s" id="websiteUrl_s" value="" /> &nbsp;  Reffer By: <input type="text" class="wtTextClass" name="refferBy_s" id="refferBy_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Postcode: <input type="text" class="wtTextClass" name="postcode_s" id="postcode_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;  Priority:
	
	<select name="priority" id="priority_s" class="textbox fWidth" ><option value="">Select Priority</option>	<? 
										  $os->onlyOption($os->priorities);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbcontactListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbcontactListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbcontactListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var refCode_sVal= os.getVal('refCode_s'); 
 var person_sVal= os.getVal('person_s'); 
 var company_sVal= os.getVal('company_s'); 
 var phone_sVal= os.getVal('phone_s'); 
 var email_sVal= os.getVal('email_s'); 
 var rbcategoryId_sVal= os.getVal('rbcategoryId_s'); 
 var rblocationId_sVal= os.getVal('rblocationId_s'); 
 var contactStatus_sVal= os.getVal('contactStatus_s'); 
 var websiteUrl_sVal= os.getVal('websiteUrl_s'); 
 var refferBy_sVal= os.getVal('refferBy_s'); 
 var address_sVal= os.getVal('address_s'); 
 var postcode_sVal= os.getVal('postcode_s'); 
 var remarks_sVal= os.getVal('remarks_s'); 
 var priority_sVal= os.getVal('priority_s'); 
formdata.append('refCode_s',refCode_sVal );
formdata.append('person_s',person_sVal );
formdata.append('company_s',company_sVal );
formdata.append('phone_s',phone_sVal );
formdata.append('email_s',email_sVal );
formdata.append('rbcategoryId_s',rbcategoryId_sVal );
formdata.append('rblocationId_s',rblocationId_sVal );
formdata.append('contactStatus_s',contactStatus_sVal );
formdata.append('websiteUrl_s',websiteUrl_sVal );
formdata.append('refferBy_s',refferBy_sVal );
formdata.append('address_s',address_sVal );
formdata.append('postcode_s',postcode_sVal );
formdata.append('remarks_s',remarks_sVal );
formdata.append('priority_s',priority_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbcontactpagingPageno=os.getVal('WT_rbcontactpagingPageno');
	var url='wtpage='+WT_rbcontactpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbcontactListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbcontactListDiv',url,formdata);
		
}

WT_rbcontactListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s',''); 
 os.setVal('person_s',''); 
 os.setVal('company_s',''); 
 os.setVal('phone_s',''); 
 os.setVal('email_s',''); 
 os.setVal('rbcategoryId_s',''); 
 os.setVal('rblocationId_s',''); 
 os.setVal('contactStatus_s',''); 
 os.setVal('websiteUrl_s',''); 
 os.setVal('refferBy_s',''); 
 os.setVal('address_s',''); 
 os.setVal('postcode_s',''); 
 os.setVal('remarks_s',''); 
 os.setVal('priority_s',''); 
	
		os.setVal('searchKey','');
		WT_rbcontactListing();	
	
	}
	
 
function WT_rbcontactEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode'); 
var personVal= os.getVal('person'); 
var companyVal= os.getVal('company'); 
var phoneVal= os.getVal('phone'); 
var emailVal= os.getVal('email'); 
var rbcategoryIdVal= os.getVal('rbcategoryId'); 
var rblocationIdVal= os.getVal('rblocationId'); 
var contactStatusVal= os.getVal('contactStatus'); 
var websiteUrlVal= os.getVal('websiteUrl'); 
var refferByVal= os.getVal('refferBy'); 
var addressVal= os.getVal('address'); 
var postcodeVal= os.getVal('postcode'); 
var remarksVal= os.getVal('remarks'); 
var priorityVal= os.getVal('priority'); 


 formdata.append('refCode',refCodeVal );
 formdata.append('person',personVal );
 formdata.append('company',companyVal );
 formdata.append('phone',phoneVal );
 formdata.append('email',emailVal );
 formdata.append('rbcategoryId',rbcategoryIdVal );
 formdata.append('rblocationId',rblocationIdVal );
 formdata.append('contactStatus',contactStatusVal );
 formdata.append('websiteUrl',websiteUrlVal );
 formdata.append('refferBy',refferByVal );
 formdata.append('address',addressVal );
 formdata.append('postcode',postcodeVal );
 formdata.append('remarks',remarksVal );
 formdata.append('priority',priorityVal );

	

	 var   rbcontactId=os.getVal('rbcontactId');
	 formdata.append('rbcontactId',rbcontactId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbcontactEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcontactReLoadList',url,formdata);

}	

function WT_rbcontactReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbcontactId=parseInt(d[0]);
	if(d[0]!='Error' && rbcontactId>0)
	{
	  os.setVal('rbcontactId',rbcontactId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbcontactListing();
}

function WT_rbcontactGetById(rbcontactId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbcontactId',rbcontactId );
	var url='<? echo $ajaxFilePath ?>?WT_rbcontactGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcontactFillData',url,formdata);
				
}

function WT_rbcontactFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbcontactId',parseInt(objJSON.rbcontactId));
	
 os.setVal('refCode',objJSON.refCode); 
 os.setVal('person',objJSON.person); 
 os.setVal('company',objJSON.company); 
 os.setVal('phone',objJSON.phone); 
 os.setVal('email',objJSON.email); 
 os.setVal('rbcategoryId',objJSON.rbcategoryId); 
 os.setVal('rblocationId',objJSON.rblocationId); 
 os.setVal('contactStatus',objJSON.contactStatus); 
 os.setVal('websiteUrl',objJSON.websiteUrl); 
 os.setVal('refferBy',objJSON.refferBy); 
 os.setVal('address',objJSON.address); 
 os.setVal('postcode',objJSON.postcode); 
 os.setVal('remarks',objJSON.remarks); 
 os.setVal('priority',objJSON.priority); 

  
}

function WT_rbcontactDeleteRowById(rbcontactId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbcontactId)<1 || rbcontactId==''){  
	var  rbcontactId =os.getVal('rbcontactId');
	}
	
	if(parseInt(rbcontactId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbcontactId',rbcontactId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbcontactDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcontactDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbcontactDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbcontactListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbcontactpagingPageno',parseInt(pageNo));
	WT_rbcontactListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>