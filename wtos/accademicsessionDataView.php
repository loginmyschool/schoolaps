<?
/*
   # wtos version : 1.1
   # main ajax process page : accademicsessionAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List accademicsession';
$ajaxFilePath= 'accademicsessionAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_accademicsessionEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Key </td>
										<td><input value="" type="text" name="idKey" id="idKey" class="textboxxx  fWidth "/><span style="color: #FF0000;"><b> (Please don't edit key value if already associated any data)</b> </span> </td>						
										</tr><tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/><b> (You can edit This)</b> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->academicSessionStatus,'active');	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="accademicsessionId" value="0" />	
	<input type="hidden"  id="WT_accademicsessionpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_accademicsessionEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Key: <input type="text" class="wtTextClass" name="idKey_s" id="idKey_s" value="" /> &nbsp;  Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->academicSessionStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_accademicsessionListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_accademicsessionListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>





 
function WT_accademicsessionListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var idKey_sVal= os.getVal('idKey_s'); 
 var title_sVal= os.getVal('title_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('idKey_s',idKey_sVal );
formdata.append('title_s',title_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_accademicsessionpagingPageno=os.getVal('WT_accademicsessionpagingPageno');
	var url='wtpage='+WT_accademicsessionpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_accademicsessionListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_accademicsessionListDiv',url,formdata);
		
}

WT_accademicsessionListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('idKey_s',''); 
 os.setVal('title_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_accademicsessionListing();	
	
	}
	
 
function WT_accademicsessionEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var idKeyVal= os.getVal('idKey'); 
var titleVal= os.getVal('title'); 
var statusVal= os.getVal('status'); 


 formdata.append('idKey',idKeyVal );
 formdata.append('title',titleVal );
 formdata.append('status',statusVal );

	
if(os.check.empty('idKey','Please Add Key')==false){ return false;} 
if(os.check.empty('title','Please Add Title')==false){ return false;} 

	 var   accademicsessionId=os.getVal('accademicsessionId');
	 formdata.append('accademicsessionId',accademicsessionId );
  	var url='<? echo $ajaxFilePath ?>?WT_accademicsessionEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_accademicsessionReLoadList',url,formdata);

}	

function WT_accademicsessionReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var accademicsessionId=parseInt(d[0]);
	if(d[0]!='Error' && accademicsessionId>0)
	{
	  os.setVal('accademicsessionId',accademicsessionId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_accademicsessionListing();
}






function checkEditDeletePassword(accademicsessionId)
{
			var formdata = new FormData();	
	
	if(parseInt(accademicsessionId)<1 || accademicsessionId==''){  
	
	var  accademicsessionId =os.getVal('accademicsessionId');
	formdata.append('operationType','deleteData');
	
	}
	
	
	
	var password= prompt("Please Enter Password");
	if(password)
	{
 
	formdata.append('accademicsessionId',accademicsessionId );
	formdata.append('password',password );
	
	var url='<? echo $ajaxFilePath ?>?checkEditDeletePassword=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('checkEditDeletePasswordResult',url,formdata);
	
	}
	
	
	
}

function checkEditDeletePasswordResult(data)
{
	if(data=='wrong password')
	{
		alert(data);
	}
	else
	{
		var d=data.split('#-#');
		var accademicsessionId=parseInt(d[1]);
		
		
		var operationType=d[2];
		if(operationType=='Edit Data')
		{
		WT_accademicsessionGetById(accademicsessionId);
		}
		if(operationType=='Delete Data')
		{
			WT_accademicsessionDeleteRowById(accademicsessionId);
		}
		
	}
	
}




function WT_accademicsessionGetById(accademicsessionId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('accademicsessionId',accademicsessionId );
	var url='<? echo $ajaxFilePath ?>?WT_accademicsessionGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_accademicsessionFillData',url,formdata);
				
}

function WT_accademicsessionFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('accademicsessionId',parseInt(objJSON.accademicsessionId));
	
 os.setVal('idKey',objJSON.idKey); 
 os.setVal('title',objJSON.title); 
 os.setVal('status',objJSON.status); 

  
}

function WT_accademicsessionDeleteRowById(accademicsessionId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(accademicsessionId)<1 || accademicsessionId==''){  
	var  accademicsessionId =os.getVal('accademicsessionId');
	}
	
	if(parseInt(accademicsessionId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('accademicsessionId',accademicsessionId );
	
	var url='<? echo $ajaxFilePath ?>?WT_accademicsessionDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_accademicsessionDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_accademicsessionDeleteRowByIdResults(data)
{
	alert(data);
	WT_accademicsessionListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_accademicsessionpagingPageno',parseInt(pageNo));
	WT_accademicsessionListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>