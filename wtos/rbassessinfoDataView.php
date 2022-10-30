<?
/*
   # wtos version : 1.1
   # main ajax process page : rbassessinfoAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Access';
$ajaxFilePath= 'rbassessinfoAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbassessinfoDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbassessinfoEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Url </td>
										<td><input value="" type="text" name="url" id="url" style="width: 345px" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	 </td>						
										</tr><tr >
	  									<td>Country </td>
										<td> <select name="rbcountryId" id="rbcountryId" class="textbox fWidth" ><option value="">Select Country</option>		  	<? 
								
										  $os->optionsHTML('','rbcountryId','name','rbcountry');?>
							</select> </td>						
										</tr><tr >
	  									<td>Phone </td>
										<td><input value="" type="text" name="phone" id="phone" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" style="width: 345px" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Person </td>
										<td><input value="" type="text" name="person" id="person" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Details </td>
										<td><textarea style=" height: 254px; width: 346px " name="details" id="details" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbassessinfo" value="0" />	
	<input type="hidden"  id="WT_rbassessinfopagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbassessinfoDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbassessinfoEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp;  Url: <input type="text" class="wtTextClass" name="url_s" id="url_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	
   Country:
	
	
	<select name="rbcountryId" id="rbcountryId_s" class="textbox fWidth" ><option value="">Select Country</option>		  	<? 
								
										  $os->optionsHTML('','rbcountryId','name','rbcountry');?>
							</select>
   Phone: <input type="text" class="wtTextClass" name="phone_s" id="phone_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Person: <input type="text" class="wtTextClass" name="person_s" id="person_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbassessinfoListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbassessinfoListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbassessinfoListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var refCode_sVal= os.getVal('refCode_s'); 
 var url_sVal= os.getVal('url_s'); 
 var status_sVal= os.getVal('status_s'); 
 var rbcountryId_sVal= os.getVal('rbcountryId_s'); 
 var phone_sVal= os.getVal('phone_s'); 
 var email_sVal= os.getVal('email_s'); 
 var person_sVal= os.getVal('person_s'); 
formdata.append('refCode_s',refCode_sVal );
formdata.append('url_s',url_sVal );
formdata.append('status_s',status_sVal );
formdata.append('rbcountryId_s',rbcountryId_sVal );
formdata.append('phone_s',phone_sVal );
formdata.append('email_s',email_sVal );
formdata.append('person_s',person_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbassessinfopagingPageno=os.getVal('WT_rbassessinfopagingPageno');
	var url='wtpage='+WT_rbassessinfopagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbassessinfoListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbassessinfoListDiv',url,formdata);
		
}

WT_rbassessinfoListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s',''); 
 os.setVal('url_s',''); 
 os.setVal('status_s',''); 
 os.setVal('rbcountryId_s',''); 
 os.setVal('phone_s',''); 
 os.setVal('email_s',''); 
 os.setVal('person_s',''); 
	
		os.setVal('searchKey','');
		WT_rbassessinfoListing();	
	
	}
	
 
function WT_rbassessinfoEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode'); 
var urlVal= os.getVal('url'); 
var statusVal= os.getVal('status'); 
var rbcountryIdVal= os.getVal('rbcountryId'); 
var phoneVal= os.getVal('phone'); 
var emailVal= os.getVal('email'); 
var personVal= os.getVal('person'); 
var detailsVal= os.getVal('details'); 


 formdata.append('refCode',refCodeVal );
 formdata.append('url',urlVal );
 formdata.append('status',statusVal );
 formdata.append('rbcountryId',rbcountryIdVal );
 formdata.append('phone',phoneVal );
 formdata.append('email',emailVal );
 formdata.append('person',personVal );
 formdata.append('details',detailsVal );

	

	 var   rbassessinfo=os.getVal('rbassessinfo');
	 formdata.append('rbassessinfo',rbassessinfo );
  	var url='<? echo $ajaxFilePath ?>?WT_rbassessinfoEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbassessinfoReLoadList',url,formdata);

}	

function WT_rbassessinfoReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbassessinfo=parseInt(d[0]);
	if(d[0]!='Error' && rbassessinfo>0)
	{
	  os.setVal('rbassessinfo',rbassessinfo);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbassessinfoListing();
}

function WT_rbassessinfoGetById(rbassessinfo) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbassessinfo',rbassessinfo );
	var url='<? echo $ajaxFilePath ?>?WT_rbassessinfoGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbassessinfoFillData',url,formdata);
				
}

function WT_rbassessinfoFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbassessinfo',parseInt(objJSON.rbassessinfo));
	
 os.setVal('refCode',objJSON.refCode); 
 os.setVal('url',objJSON.url); 
 os.setVal('status',objJSON.status); 
 os.setVal('rbcountryId',objJSON.rbcountryId); 
 os.setVal('phone',objJSON.phone); 
 os.setVal('email',objJSON.email); 
 os.setVal('person',objJSON.person); 
 os.setVal('details',objJSON.details); 

  
}

function WT_rbassessinfoDeleteRowById(rbassessinfo) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbassessinfo)<1 || rbassessinfo==''){  
	var  rbassessinfo =os.getVal('rbassessinfo');
	}
	
	if(parseInt(rbassessinfo)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbassessinfo',rbassessinfo );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbassessinfoDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbassessinfoDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbassessinfoDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbassessinfoListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbassessinfopagingPageno',parseInt(pageNo));
	WT_rbassessinfoListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>