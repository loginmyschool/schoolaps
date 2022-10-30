<?
/*
   # wtos version : 1.1
   # main ajax process page : dailyactAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List dailyact';
$ajaxFilePath= 'dailyactAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_dailyactDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_dailyactEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>description </td>
										<td><textarea  name="description" id="description" style="width:300px; height:250px;" ></textarea></td>						
										</tr><tr >
	  									<td>status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->dailystatus);	?></select>	 </td>						
										</tr>
										 <? $displayUser='style="display:none;"'; if($os->isSuperAdmin()){ $displayUser=''; }?>
										<tr <? echo $displayUser ?>  >
	  									<td>User </td>
										<td> 
										
										<select name="adminId" id="adminId" class="textbox fWidth" ><option value=""></option>		  	<? 
								
										  $os->optionsHTML('','adminId','name','admin');?>
							</select> </td>						
										</tr>
										<tr <? echo $displayUser ?>  >
	  									<td>Verify Status </td>
										<td>  
	
	<select name="verifyStatus" id="verifyStatus" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->verifyStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="dailyactId" value="0" />	
	<input type="hidden"  id="WT_dailyactpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_dailyactDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_dailyactEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  &nbsp;  status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->dailystatus);	?></select>	
   User:
	
	
	<select name="adminId" id="adminId_s" class="textbox fWidth" ><option value=""></option>		  	<? 
								
										  $os->optionsHTML('','adminId','name','admin');?>
							</select>
   Verify Status:
	
	<select name="verifyStatus" id="verifyStatus_s" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->verifyStatus);	?></select>	
	 
  <div style="display:none" id="advanceSearchDiv">
         
From Date: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   description: <input type="text" class="wtTextClass" name="description_s" id="description_s" value="" /> &nbsp;  status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select status</option>	<? 
										  $os->onlyOption($os->dailystatus);	?></select>	
   User:
	
	
	<select name="adminId" id="adminId_s" class="textbox fWidth" ><option value="">Select User</option>		  	<? 
								
										  $os->optionsHTML('','adminId','name','admin');?>
							</select>
   Verify Status:
	
	<select name="verifyStatus" id="verifyStatus_s" class="textbox fWidth" ><option value="">Select Verify Status</option>	<? 
										  $os->onlyOption($os->verifyStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_dailyactListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_dailyactListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_dailyactListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var f_dated_sVal= os.getVal('f_dated_s'); 
 var t_dated_sVal= os.getVal('t_dated_s'); 
 var description_sVal= os.getVal('description_s'); 
 var status_sVal= os.getVal('status_s'); 
 var adminId_sVal= os.getVal('adminId_s'); 
 var verifyStatus_sVal= os.getVal('verifyStatus_s'); 
formdata.append('f_dated_s',f_dated_sVal );
formdata.append('t_dated_s',t_dated_sVal );
formdata.append('description_s',description_sVal );
formdata.append('status_s',status_sVal );
formdata.append('adminId_s',adminId_sVal );
formdata.append('verifyStatus_s',verifyStatus_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_dailyactpagingPageno=os.getVal('WT_dailyactpagingPageno');
	var url='wtpage='+WT_dailyactpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_dailyactListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_dailyactListDiv',url,formdata);
		
}

WT_dailyactListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('f_dated_s',''); 
 os.setVal('t_dated_s',''); 
 os.setVal('description_s',''); 
 os.setVal('status_s',''); 
 os.setVal('adminId_s',''); 
 os.setVal('verifyStatus_s',''); 
	
		os.setVal('searchKey','');
		WT_dailyactListing();	
	
	}
	
 
function WT_dailyactEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var datedVal= os.getVal('dated'); 
var descriptionVal= os.getVal('description'); 
var statusVal= os.getVal('status'); 
var adminIdVal= os.getVal('adminId'); 
var verifyStatusVal= os.getVal('verifyStatus'); 


 formdata.append('dated',datedVal );
 formdata.append('description',descriptionVal );
 formdata.append('status',statusVal );
 formdata.append('adminId',adminIdVal );
 formdata.append('verifyStatus',verifyStatusVal );

	
if(os.check.empty('dated','Please Add Date')==false){ return false;} 

	 var   dailyactId=os.getVal('dailyactId');
	 formdata.append('dailyactId',dailyactId );
  	var url='<? echo $ajaxFilePath ?>?WT_dailyactEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_dailyactReLoadList',url,formdata);

}	

function WT_dailyactReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var dailyactId=parseInt(d[0]);
	if(d[0]!='Error' && dailyactId>0)
	{
	  os.setVal('dailyactId',dailyactId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_dailyactListing();
}

function WT_dailyactGetById(dailyactId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('dailyactId',dailyactId );
	var url='<? echo $ajaxFilePath ?>?WT_dailyactGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_dailyactFillData',url,formdata);
				
}

function WT_dailyactFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('dailyactId',parseInt(objJSON.dailyactId));
	
 os.setVal('dated',objJSON.dated); 
 os.setVal('description',objJSON.description); 
 os.setVal('status',objJSON.status); 
 os.setVal('adminId',objJSON.adminId); 
 os.setVal('verifyStatus',objJSON.verifyStatus); 

  
}

function WT_dailyactDeleteRowById(dailyactId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(dailyactId)<1 || dailyactId==''){  
	var  dailyactId =os.getVal('dailyactId');
	}
	
	if(parseInt(dailyactId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('dailyactId',dailyactId );
	
	var url='<? echo $ajaxFilePath ?>?WT_dailyactDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_dailyactDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_dailyactDeleteRowByIdResults(data)
{
	alert(data);
	WT_dailyactListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_dailyactpagingPageno',parseInt(pageNo));
	WT_dailyactListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>