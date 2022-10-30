<?
/*
   # wtos version : 1.1
   # main ajax process page : budget_listAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Budget List';
$ajaxFilePath= 'budget_listAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_budget_listDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_budget_listEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Reference No </td>
										<td><input value="" type="text" name="reference_no" id="reference_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Title </td>
										<td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Parent Head Id </td>
										<td><input value="" type="text" name="parent_head_id" id="parent_head_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Account Head Id </td>
										<td><input value="" type="text" name="account_head_id" id="account_head_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr style="display: none;">
	  									<td>Approved By </td>
										<td><input value="" type="text" name="approved_by" id="approved_by" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Approved Status </td>
										<td>
	<select name="approved_status" id="approved_status" class="textbox fWidth" ><option value="">Select Approved Status</option><? $os->onlyOption($os->approvedStatus);	?></select></td>						
										</tr><tr >
	  									<td>User Id </td>
										<td><input value="" type="text" name="user_id" id="user_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Budget For Month </td>
										<td>  
	
	<select name="budget_for_month" id="budget_for_month" class="textbox fWidth" ><option value="">Select Budget For Month</option>	<? 
										  $os->onlyOption($os->rentMonth);	?></select>	 </td>						
										</tr><tr >
	  									<td>budget_for_year </td>
										<td>  
	
	<select name="budget_for_year" id="budget_for_year" class="textbox fWidth" ><option value="">Select budget_for_year</option>	<? 
										  $os->onlyOption($os->yearSearch);	?></select>	 </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="budget_list_id" value="0" />	
	<input type="hidden"  id="WT_budget_listpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_budget_listDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_budget_listEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Reference No: <input type="text" class="wtTextClass" name="reference_no_s" id="reference_no_s" value="" /> &nbsp;  Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Parent Head Id: <input type="text" class="wtTextClass" name="parent_head_id_s" id="parent_head_id_s" value="" /> &nbsp;  Account Head Id: <input type="text" class="wtTextClass" name="account_head_id_s" id="account_head_id_s" value="" /> &nbsp;  Approved By: <input type="text" class="wtTextClass" name="approved_by_s" id="approved_by_s" value="" /> &nbsp;  Approved Status: <input type="text" class="wtTextClass" name="approved_status_s" id="approved_status_s" value="" /> &nbsp;  User Id: <input type="text" class="wtTextClass" name="user_id_s" id="user_id_s" value="" /> &nbsp;  Budget For Month:
	
	<select name="budget_for_month" id="budget_for_month_s" class="textbox fWidth" ><option value="">Select Budget For Month</option>	<? 
										  $os->onlyOption($os->rentMonth);	?></select>	
   budget_for_year:
	
	<select name="budget_for_year" id="budget_for_year_s" class="textbox fWidth" ><option value="">Select budget_for_year</option>	<? 
										  $os->onlyOption($os->yearSearch);	?></select>	
   Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_budget_listListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_budget_listListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_budget_listListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var reference_no_sVal= os.getVal('reference_no_s'); 
 var title_sVal= os.getVal('title_s'); 
 var parent_head_id_sVal= os.getVal('parent_head_id_s'); 
 var account_head_id_sVal= os.getVal('account_head_id_s'); 
 var approved_by_sVal= os.getVal('approved_by_s'); 
 var approved_status_sVal= os.getVal('approved_status_s'); 
 var user_id_sVal= os.getVal('user_id_s'); 
 var budget_for_month_sVal= os.getVal('budget_for_month_s'); 
 var budget_for_year_sVal= os.getVal('budget_for_year_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('reference_no_s',reference_no_sVal );
formdata.append('title_s',title_sVal );
formdata.append('parent_head_id_s',parent_head_id_sVal );
formdata.append('account_head_id_s',account_head_id_sVal );
formdata.append('approved_by_s',approved_by_sVal );
formdata.append('approved_status_s',approved_status_sVal );
formdata.append('user_id_s',user_id_sVal );
formdata.append('budget_for_month_s',budget_for_month_sVal );
formdata.append('budget_for_year_s',budget_for_year_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_budget_listpagingPageno=os.getVal('WT_budget_listpagingPageno');
	var url='wtpage='+WT_budget_listpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_budget_listListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_budget_listListDiv',url,formdata);
		
}

WT_budget_listListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('reference_no_s',''); 
 os.setVal('title_s',''); 
 os.setVal('parent_head_id_s',''); 
 os.setVal('account_head_id_s',''); 
 os.setVal('approved_by_s',''); 
 os.setVal('approved_status_s',''); 
 os.setVal('user_id_s',''); 
 os.setVal('budget_for_month_s',''); 
 os.setVal('budget_for_year_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_budget_listListing();	
	
	}
	
 
function WT_budget_listEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var reference_noVal= os.getVal('reference_no'); 
var titleVal= os.getVal('title'); 
var parent_head_idVal= os.getVal('parent_head_id'); 
var account_head_idVal= os.getVal('account_head_id'); 
var approved_byVal= os.getVal('approved_by'); 
var approved_statusVal= os.getVal('approved_status'); 
var user_idVal= os.getVal('user_id'); 
var budget_for_monthVal= os.getVal('budget_for_month'); 
var budget_for_yearVal= os.getVal('budget_for_year'); 
var statusVal= os.getVal('status'); 


 formdata.append('reference_no',reference_noVal );
 formdata.append('title',titleVal );
 formdata.append('parent_head_id',parent_head_idVal );
 formdata.append('account_head_id',account_head_idVal );
 formdata.append('approved_by',approved_byVal );
 formdata.append('approved_status',approved_statusVal );
 formdata.append('user_id',user_idVal );
 formdata.append('budget_for_month',budget_for_monthVal );
 formdata.append('budget_for_year',budget_for_yearVal );
 formdata.append('status',statusVal );

	

	 var   budget_list_id=os.getVal('budget_list_id');
	 formdata.append('budget_list_id',budget_list_id );
  	var url='<? echo $ajaxFilePath ?>?WT_budget_listEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_budget_listReLoadList',url,formdata);

}	

function WT_budget_listReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var budget_list_id=parseInt(d[0]);
	if(d[0]!='Error' && budget_list_id>0)
	{
	  os.setVal('budget_list_id',budget_list_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_budget_listListing();
}

function WT_budget_listGetById(budget_list_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('budget_list_id',budget_list_id );
	var url='<? echo $ajaxFilePath ?>?WT_budget_listGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_budget_listFillData',url,formdata);
				
}

function WT_budget_listFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('budget_list_id',parseInt(objJSON.budget_list_id));
	
 os.setVal('reference_no',objJSON.reference_no); 
 os.setVal('title',objJSON.title); 
 os.setVal('parent_head_id',objJSON.parent_head_id); 
 os.setVal('account_head_id',objJSON.account_head_id); 
 os.setVal('approved_by',objJSON.approved_by); 
 os.setVal('approved_status',objJSON.approved_status); 
 os.setVal('user_id',objJSON.user_id); 
 os.setVal('budget_for_month',objJSON.budget_for_month); 
 os.setVal('budget_for_year',objJSON.budget_for_year); 
 os.setVal('status',objJSON.status); 

  
}

function WT_budget_listDeleteRowById(budget_list_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(budget_list_id)<1 || budget_list_id==''){  
	var  budget_list_id =os.getVal('budget_list_id');
	}
	
	if(parseInt(budget_list_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('budget_list_id',budget_list_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_budget_listDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_budget_listDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_budget_listDeleteRowByIdResults(data)
{
	alert(data);
	WT_budget_listListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_budget_listpagingPageno',parseInt(pageNo));
	WT_budget_listListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>