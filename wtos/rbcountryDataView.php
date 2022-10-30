<?
/*
   # wtos version : 1.1
   # main ajax process page : rbcountryAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List rbcountry';
$ajaxFilePath= 'rbcountryAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcountryDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbcountryEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Country Status </td>
										<td>  
	
	<select name="countryStatus" id="countryStatus" class="textbox fWidth" ><option value="">Select Country Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbcountryId" value="0" />	
	<input type="hidden"  id="WT_rbcountrypagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcountryDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbcountryEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Country Status:
	
	<select name="countryStatus" id="countryStatus_s" class="textbox fWidth" ><option value="">Select Country Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbcountryListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbcountryListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbcountryListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var countryStatus_sVal= os.getVal('countryStatus_s'); 
formdata.append('name_s',name_sVal );
formdata.append('countryStatus_s',countryStatus_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbcountrypagingPageno=os.getVal('WT_rbcountrypagingPageno');
	var url='wtpage='+WT_rbcountrypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbcountryListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbcountryListDiv',url,formdata);
		
}

WT_rbcountryListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('countryStatus_s',''); 
	
		os.setVal('searchKey','');
		WT_rbcountryListing();	
	
	}
	
 
function WT_rbcountryEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var countryStatusVal= os.getVal('countryStatus'); 


 formdata.append('name',nameVal );
 formdata.append('countryStatus',countryStatusVal );

	

	 var   rbcountryId=os.getVal('rbcountryId');
	 formdata.append('rbcountryId',rbcountryId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbcountryEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcountryReLoadList',url,formdata);

}	

function WT_rbcountryReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbcountryId=parseInt(d[0]);
	if(d[0]!='Error' && rbcountryId>0)
	{
	  os.setVal('rbcountryId',rbcountryId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbcountryListing();
}

function WT_rbcountryGetById(rbcountryId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbcountryId',rbcountryId );
	var url='<? echo $ajaxFilePath ?>?WT_rbcountryGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcountryFillData',url,formdata);
				
}

function WT_rbcountryFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbcountryId',parseInt(objJSON.rbcountryId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('countryStatus',objJSON.countryStatus); 

  
}

function WT_rbcountryDeleteRowById(rbcountryId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbcountryId)<1 || rbcountryId==''){  
	var  rbcountryId =os.getVal('rbcountryId');
	}
	
	if(parseInt(rbcountryId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbcountryId',rbcountryId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbcountryDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcountryDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbcountryDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbcountryListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbcountrypagingPageno',parseInt(pageNo));
	WT_rbcountryListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>