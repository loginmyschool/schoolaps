<?
/*
   # wtos version : 1.1
   # main ajax process page : rblocationAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage rblocation';
$ajaxFilePath= 'rblocationAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rblocationDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rblocationEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>location Status </td>
										<td>  
	
	<select name="locationStatus" id="locationStatus" class="textbox fWidth" ><option value="">Select location Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rblocationId" value="0" />	
	<input type="hidden"  id="WT_rblocationpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rblocationDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rblocationEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  location Status:
	
	<select name="locationStatus" id="locationStatus_s" class="textbox fWidth" ><option value="">Select location Status</option>	<? 
										  $os->onlyOption($os->activeInactive);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rblocationListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rblocationListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rblocationListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var locationStatus_sVal= os.getVal('locationStatus_s'); 
formdata.append('name_s',name_sVal );
formdata.append('locationStatus_s',locationStatus_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rblocationpagingPageno=os.getVal('WT_rblocationpagingPageno');
	var url='wtpage='+WT_rblocationpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rblocationListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rblocationListDiv',url,formdata);
		
}

WT_rblocationListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('locationStatus_s',''); 
	
		os.setVal('searchKey','');
		WT_rblocationListing();	
	
	}
	
 
function WT_rblocationEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var locationStatusVal= os.getVal('locationStatus'); 


 formdata.append('name',nameVal );
 formdata.append('locationStatus',locationStatusVal );

	

	 var   rblocationId=os.getVal('rblocationId');
	 formdata.append('rblocationId',rblocationId );
  	var url='<? echo $ajaxFilePath ?>?WT_rblocationEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rblocationReLoadList',url,formdata);

}	

function WT_rblocationReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rblocationId=parseInt(d[0]);
	if(d[0]!='Error' && rblocationId>0)
	{
	  os.setVal('rblocationId',rblocationId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rblocationListing();
}

function WT_rblocationGetById(rblocationId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rblocationId',rblocationId );
	var url='<? echo $ajaxFilePath ?>?WT_rblocationGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rblocationFillData',url,formdata);
				
}

function WT_rblocationFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rblocationId',parseInt(objJSON.rblocationId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('locationStatus',objJSON.locationStatus); 

  
}

function WT_rblocationDeleteRowById(rblocationId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rblocationId)<1 || rblocationId==''){  
	var  rblocationId =os.getVal('rblocationId');
	}
	
	if(parseInt(rblocationId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rblocationId',rblocationId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rblocationDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rblocationDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rblocationDeleteRowByIdResults(data)
{
	alert(data);
	WT_rblocationListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rblocationpagingPageno',parseInt(pageNo));
	WT_rblocationListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>