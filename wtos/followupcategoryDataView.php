<?
/*
   # wtos version : 1.1
   # main ajax process page : followupcategoryAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Followupcategory';
$ajaxFilePath= 'followupcategoryAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_followupcategoryDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_followupcategoryEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="catId" value="0" />	
	<input type="hidden"  id="WT_followupcategorypagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_followupcategoryDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_followupcategoryEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_followupcategoryListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_followupcategoryListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_followupcategoryListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var title_sVal= os.getVal('title_s'); 
formdata.append('title_s',title_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_followupcategorypagingPageno=os.getVal('WT_followupcategorypagingPageno');
	var url='wtpage='+WT_followupcategorypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_followupcategoryListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_followupcategoryListDiv',url,formdata);
		
}

WT_followupcategoryListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('title_s',''); 
	
		os.setVal('searchKey','');
		WT_followupcategoryListing();	
	
	}
	
 
function WT_followupcategoryEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var titleVal= os.getVal('title'); 


 formdata.append('title',titleVal );

	
if(os.check.empty('title','Please Add Title')==false){ return false;} 

	 var   catId=os.getVal('catId');
	 formdata.append('catId',catId );
  	var url='<? echo $ajaxFilePath ?>?WT_followupcategoryEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_followupcategoryReLoadList',url,formdata);

}	

function WT_followupcategoryReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var catId=parseInt(d[0]);
	if(d[0]!='Error' && catId>0)
	{
	  os.setVal('catId',catId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_followupcategoryListing();
}

function WT_followupcategoryGetById(catId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('catId',catId );
	var url='<? echo $ajaxFilePath ?>?WT_followupcategoryGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_followupcategoryFillData',url,formdata);
				
}

function WT_followupcategoryFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('catId',parseInt(objJSON.catId));
	
 os.setVal('title',objJSON.title); 

  
}

function WT_followupcategoryDeleteRowById(catId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(catId)<1 || catId==''){  
	var  catId =os.getVal('catId');
	}
	
	if(parseInt(catId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('catId',catId );
	
	var url='<? echo $ajaxFilePath ?>?WT_followupcategoryDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_followupcategoryDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_followupcategoryDeleteRowByIdResults(data)
{
	alert(data);
	WT_followupcategoryListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_followupcategorypagingPageno',parseInt(pageNo));
	WT_followupcategoryListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>