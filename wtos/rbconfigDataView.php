<?
/*
   # wtos version : 1.1
   # main ajax process page : rbconfigAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='List rbconfig';
$ajaxFilePath= 'rbconfigAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbconfigDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbconfigEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Logo </td>
										<td>
										
										<img id="logoPreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="logo" value=""  id="logo" onchange="os.readURL(this,'logoPreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('logo');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Water Mark </td>
										<td>
										
										<img id="waterMarkPreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="waterMark" value=""  id="waterMark" onchange="os.readURL(this,'waterMarkPreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('waterMark');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Company Name </td>
										<td><input value="" type="text" name="companyName" id="companyName" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address Line1 </td>
										<td><textarea  name="addressLine1" id="addressLine1" ></textarea></td>						
										</tr><tr >
	  									<td>Address Line2 </td>
										<td><textarea  name="addressLine2" id="addressLine2" ></textarea></td>						
										</tr><tr >
	  									<td>Address Line3 </td>
										<td><textarea  name="addressLine3" id="addressLine3" ></textarea></td>						
										</tr><tr >
	  									<td>Phone </td>
										<td><input value="" type="text" name="phone" id="phone" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile </td>
										<td><input value="" type="text" name="mobile" id="mobile" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Fax </td>
										<td><input value="" type="text" name="fax" id="fax" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Website </td>
										<td><input value="" type="text" name="website" id="website" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Account No </td>
										<td><input value="" type="text" name="accountNo" id="accountNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Account Details </td>
										<td><textarea  name="accountDetails" id="accountDetails" ></textarea></td>						
										</tr><tr >
	  									<td>Vendor Id </td>
										<td><input value="" type="text" name="vendorId" id="vendorId" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Tems </td>
										<td><textarea  name="tems" id="tems" ></textarea></td>						
										</tr><tr >
	  									<td>Extra Note1 </td>
										<td><textarea  name="extraNote1" id="extraNote1" ></textarea></td>						
										</tr><tr >
	  									<td>Extra Note2 </td>
										<td><textarea  name="extraNote2" id="extraNote2" ></textarea></td>						
										</tr><tr >
	  									<td>Service Tax No </td>
										<td><input value="" type="text" name="serviceTaxNo" id="serviceTaxNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Vat No </td>
										<td><input value="" type="text" name="vatNo" id="vatNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>CST No </td>
										<td><input value="" type="text" name="cstNo" id="cstNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>W.E.F. </td>
										<td><input value="" type="text" name="wef" id="wef" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Auto Expire Msg </td>
										<td>  
	
	<select name="autoExpMsg" id="autoExpMsg" class="textbox fWidth" ><option value="">Select Auto Expire Msg</option>	<? 
										  $os->onlyOption($os->noYes);	?></select>	 </td>						
										</tr><tr >
	  									<td>Manual Msg </td>
										<td>  
	
	<select name="manualMsg" id="manualMsg" class="textbox fWidth" ><option value="">Select Manual Msg</option>	<? 
										  $os->onlyOption($os->noYes);	?></select>	 </td>						
										</tr><tr >
	  									<td>Auto Expire Email </td>
										<td>  
	
	<select name="autoExpEmail" id="autoExpEmail" class="textbox fWidth" ><option value="">Select Auto Expire Email</option>	<? 
										  $os->onlyOption($os->yes);	?></select>	 </td>						
										</tr><tr >
	  									<td>Manual Email </td>
										<td>  
	
	<select name="manualEmail" id="manualEmail" class="textbox fWidth" ><option value="">Select Manual Email</option>	<? 
										  $os->onlyOption($os->yes);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbconfigId" value="0" />	
	<input type="hidden"  id="WT_rbconfigpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbconfigDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbconfigEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbconfigListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbconfigListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbconfigListing() // list table searched data get 
{
	var formdata = new FormData();
	
	

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbconfigpagingPageno=os.getVal('WT_rbconfigpagingPageno');
	var url='wtpage='+WT_rbconfigpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbconfigListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbconfigListDiv',url,formdata);
		
}

WT_rbconfigListing();
function  searchReset() // reset Search Fields
	{
			
		os.setVal('searchKey','');
		WT_rbconfigListing();	
	
	}
	
 
function WT_rbconfigEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var logoVal= os.getObj('logo').files[0]; 
var waterMarkVal= os.getObj('waterMark').files[0]; 
var companyNameVal= os.getVal('companyName'); 
var addressLine1Val= os.getVal('addressLine1'); 
var addressLine2Val= os.getVal('addressLine2'); 
var addressLine3Val= os.getVal('addressLine3'); 
var phoneVal= os.getVal('phone'); 
var mobileVal= os.getVal('mobile'); 
var emailVal= os.getVal('email'); 
var faxVal= os.getVal('fax'); 
var websiteVal= os.getVal('website'); 
var accountNoVal= os.getVal('accountNo'); 
var accountDetailsVal= os.getVal('accountDetails'); 
var vendorIdVal= os.getVal('vendorId'); 
var temsVal= os.getVal('tems'); 
var extraNote1Val= os.getVal('extraNote1'); 
var extraNote2Val= os.getVal('extraNote2'); 
var serviceTaxNoVal= os.getVal('serviceTaxNo'); 
var vatNoVal= os.getVal('vatNo'); 
var cstNoVal= os.getVal('cstNo'); 
var wefVal= os.getVal('wef'); 
var autoExpMsgVal= os.getVal('autoExpMsg'); 
var manualMsgVal= os.getVal('manualMsg'); 
var autoExpEmailVal= os.getVal('autoExpEmail'); 
var manualEmailVal= os.getVal('manualEmail'); 


if(logoVal){  formdata.append('logo',logoVal,logoVal.name );}
if(waterMarkVal){  formdata.append('waterMark',waterMarkVal,waterMarkVal.name );}
 formdata.append('companyName',companyNameVal );
 formdata.append('addressLine1',addressLine1Val );
 formdata.append('addressLine2',addressLine2Val );
 formdata.append('addressLine3',addressLine3Val );
 formdata.append('phone',phoneVal );
 formdata.append('mobile',mobileVal );
 formdata.append('email',emailVal );
 formdata.append('fax',faxVal );
 formdata.append('website',websiteVal );
 formdata.append('accountNo',accountNoVal );
 formdata.append('accountDetails',accountDetailsVal );
 formdata.append('vendorId',vendorIdVal );
 formdata.append('tems',temsVal );
 formdata.append('extraNote1',extraNote1Val );
 formdata.append('extraNote2',extraNote2Val );
 formdata.append('serviceTaxNo',serviceTaxNoVal );
 formdata.append('vatNo',vatNoVal );
 formdata.append('cstNo',cstNoVal );
 formdata.append('wef',wefVal );
 formdata.append('autoExpMsg',autoExpMsgVal );
 formdata.append('manualMsg',manualMsgVal );
 formdata.append('autoExpEmail',autoExpEmailVal );
 formdata.append('manualEmail',manualEmailVal );

	
if(os.check.empty('companyName','Please Add Company Name')==false){ return false;} 

	 var   rbconfigId=os.getVal('rbconfigId');
	 formdata.append('rbconfigId',rbconfigId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbconfigEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbconfigReLoadList',url,formdata);

}	

function WT_rbconfigReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbconfigId=parseInt(d[0]);
	if(d[0]!='Error' && rbconfigId>0)
	{
	  os.setVal('rbconfigId',rbconfigId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbconfigListing();
}

function WT_rbconfigGetById(rbconfigId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbconfigId',rbconfigId );
	var url='<? echo $ajaxFilePath ?>?WT_rbconfigGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbconfigFillData',url,formdata);
				
}

function WT_rbconfigFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbconfigId',parseInt(objJSON.rbconfigId));
	
 os.setImg('logoPreview',objJSON.logo); 
 os.setImg('waterMarkPreview',objJSON.waterMark); 
 os.setVal('companyName',objJSON.companyName); 
 os.setVal('addressLine1',objJSON.addressLine1); 
 os.setVal('addressLine2',objJSON.addressLine2); 
 os.setVal('addressLine3',objJSON.addressLine3); 
 os.setVal('phone',objJSON.phone); 
 os.setVal('mobile',objJSON.mobile); 
 os.setVal('email',objJSON.email); 
 os.setVal('fax',objJSON.fax); 
 os.setVal('website',objJSON.website); 
 os.setVal('accountNo',objJSON.accountNo); 
 os.setVal('accountDetails',objJSON.accountDetails); 
 os.setVal('vendorId',objJSON.vendorId); 
 os.setVal('tems',objJSON.tems); 
 os.setVal('extraNote1',objJSON.extraNote1); 
 os.setVal('extraNote2',objJSON.extraNote2); 
 os.setVal('serviceTaxNo',objJSON.serviceTaxNo); 
 os.setVal('vatNo',objJSON.vatNo); 
 os.setVal('cstNo',objJSON.cstNo); 
 os.setVal('wef',objJSON.wef); 
 os.setVal('autoExpMsg',objJSON.autoExpMsg); 
 os.setVal('manualMsg',objJSON.manualMsg); 
 os.setVal('autoExpEmail',objJSON.autoExpEmail); 
 os.setVal('manualEmail',objJSON.manualEmail); 

  
}

function WT_rbconfigDeleteRowById(rbconfigId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbconfigId)<1 || rbconfigId==''){  
	var  rbconfigId =os.getVal('rbconfigId');
	}
	
	if(parseInt(rbconfigId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbconfigId',rbconfigId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbconfigDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbconfigDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbconfigDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbconfigListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbconfigpagingPageno',parseInt(pageNo));
	WT_rbconfigListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>