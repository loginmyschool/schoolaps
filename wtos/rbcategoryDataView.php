<?
/*
   # wtos version : 1.1
   # main ajax process page : rbcategoryAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List rbcategory';
$ajaxFilePath= 'rbcategoryAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcategoryDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbcategoryEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Category Status </td>
										<td>  
	
	<select name="cateStatus" id="cateStatus" class="textbox fWidth" ><option value="">Select Category Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbcategoryId" value="0" />	
	<input type="hidden"  id="WT_rbcategorypagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcategoryDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbcategoryEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Category Status:
	
	<select name="cateStatus" id="cateStatus_s" class="textbox fWidth" ><option value="">Select Category Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbcategoryListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbcategoryListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbcategoryListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var cateStatus_sVal= os.getVal('cateStatus_s'); 
formdata.append('name_s',name_sVal );
formdata.append('cateStatus_s',cateStatus_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbcategorypagingPageno=os.getVal('WT_rbcategorypagingPageno');
	var url='wtpage='+WT_rbcategorypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbcategoryListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbcategoryListDiv',url,formdata);
		
}

WT_rbcategoryListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('cateStatus_s',''); 
	
		os.setVal('searchKey','');
		WT_rbcategoryListing();	
	
	}
	
 
function WT_rbcategoryEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var cateStatusVal= os.getVal('cateStatus'); 


 formdata.append('name',nameVal );
 formdata.append('cateStatus',cateStatusVal );

	

	 var   rbcategoryId=os.getVal('rbcategoryId');
	 formdata.append('rbcategoryId',rbcategoryId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbcategoryEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcategoryReLoadList',url,formdata);

}	

function WT_rbcategoryReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbcategoryId=parseInt(d[0]);
	if(d[0]!='Error' && rbcategoryId>0)
	{
	  os.setVal('rbcategoryId',rbcategoryId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbcategoryListing();
}

function WT_rbcategoryGetById(rbcategoryId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbcategoryId',rbcategoryId );
	var url='<? echo $ajaxFilePath ?>?WT_rbcategoryGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcategoryFillData',url,formdata);
				
}

function WT_rbcategoryFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbcategoryId',parseInt(objJSON.rbcategoryId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('cateStatus',objJSON.cateStatus); 

  
}

function WT_rbcategoryDeleteRowById(rbcategoryId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbcategoryId)<1 || rbcategoryId==''){  
	var  rbcategoryId =os.getVal('rbcategoryId');
	}
	
	if(parseInt(rbcategoryId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbcategoryId',rbcategoryId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbcategoryDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcategoryDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbcategoryDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbcategoryListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbcategorypagingPageno',parseInt(pageNo));
	WT_rbcategoryListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>