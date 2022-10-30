<?
/*
   # wtos version : 1.1
   # main ajax process page : rbproductAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List rbproduct';
$ajaxFilePath= 'rbproductAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbproductDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbproductEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Product Code </td>
										<td><input value="" type="text" name="productCode" id="productCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Model </td>
										<td><input value="" type="text" name="model" id="model" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbproductId" value="0" />	
	<input type="hidden"  id="WT_rbproductpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbproductDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbproductEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp;  Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Product Code: <input type="text" class="wtTextClass" name="productCode_s" id="productCode_s" value="" /> &nbsp;  Model: <input type="text" class="wtTextClass" name="model_s" id="model_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbproductListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbproductListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbproductListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var refCode_sVal= os.getVal('refCode_s'); 
 var name_sVal= os.getVal('name_s'); 
 var productCode_sVal= os.getVal('productCode_s'); 
 var model_sVal= os.getVal('model_s'); 
formdata.append('refCode_s',refCode_sVal );
formdata.append('name_s',name_sVal );
formdata.append('productCode_s',productCode_sVal );
formdata.append('model_s',model_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbproductpagingPageno=os.getVal('WT_rbproductpagingPageno');
	var url='wtpage='+WT_rbproductpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbproductListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbproductListDiv',url,formdata);
		
}

WT_rbproductListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s',''); 
 os.setVal('name_s',''); 
 os.setVal('productCode_s',''); 
 os.setVal('model_s',''); 
	
		os.setVal('searchKey','');
		WT_rbproductListing();	
	
	}
	
 
function WT_rbproductEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode'); 
var nameVal= os.getVal('name'); 
var productCodeVal= os.getVal('productCode'); 
var modelVal= os.getVal('model'); 


 formdata.append('refCode',refCodeVal );
 formdata.append('name',nameVal );
 formdata.append('productCode',productCodeVal );
 formdata.append('model',modelVal );

	

	 var   rbproductId=os.getVal('rbproductId');
	 formdata.append('rbproductId',rbproductId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbproductEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbproductReLoadList',url,formdata);

}	

function WT_rbproductReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbproductId=parseInt(d[0]);
	if(d[0]!='Error' && rbproductId>0)
	{
	  os.setVal('rbproductId',rbproductId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbproductListing();
}

function WT_rbproductGetById(rbproductId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbproductId',rbproductId );
	var url='<? echo $ajaxFilePath ?>?WT_rbproductGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbproductFillData',url,formdata);
				
}

function WT_rbproductFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbproductId',parseInt(objJSON.rbproductId));
	
 os.setVal('refCode',objJSON.refCode); 
 os.setVal('name',objJSON.name); 
 os.setVal('productCode',objJSON.productCode); 
 os.setVal('model',objJSON.model); 

  
}

function WT_rbproductDeleteRowById(rbproductId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbproductId)<1 || rbproductId==''){  
	var  rbproductId =os.getVal('rbproductId');
	}
	
	if(parseInt(rbproductId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbproductId',rbproductId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbproductDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbproductDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbproductDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbproductListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbproductpagingPageno',parseInt(pageNo));
	WT_rbproductListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>