<?
/*
   # wtos version : 1.1
   # main ajax process page : expense_list_detailsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Expense List Details';
$ajaxFilePath= 'expense_list_detailsAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_expense_list_detailsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_expense_list_detailsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Expense Purpose </td>
										<td> <select name="expense_list_id" id="expense_list_id" class="textbox fWidth" ><option value="">Select Expense Purpose</option>		  	<? 
								
										  $os->optionsHTML('','expense_list_id','title','expense_list');?>
							</select> </td>						
										</tr><tr >
	  									<td>Parent Head Id </td>
										<td><input value="" type="text" name="parent_head_id" id="parent_head_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Account Head Id </td>
										<td><input value="" type="text" name="account_head_id" id="account_head_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Description </td>
										<td><input value="" type="text" name="description" id="description" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Quantity </td>
										<td><input value="" type="text" name="quantity" id="quantity" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Unit </td>
										<td>  
	
	<select name="unit" id="unit" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->unit);	?></select>	 </td>						
										</tr><tr >
	  									<td>Tax Percent </td>
										<td><input value="" type="text" name="tax_percent" id="tax_percent" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Rate Excl Tax </td>
										<td><input value="" type="text" name="rate_excl_tax" id="rate_excl_tax" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Rate Incl Tax </td>
										<td><input value="" type="text" name="rate_incl_tax" id="rate_incl_tax" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total Excl Tax </td>
										<td><input value="" type="text" name="total_excl_tax" id="total_excl_tax" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total Incl Tax </td>
										<td><input value="" type="text" name="total_incl_tax" id="total_incl_tax" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Tax Amount </td>
										<td><input value="" type="text" name="tax_amount" id="tax_amount" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>User Id </td>
										<td><input value="" type="text" name="user_id" id="user_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Type </td>
										<td>  
	
	<select name="type" id="type" class="textbox fWidth" ><option value="">Select Type</option>	<? 
										  $os->onlyOption($os->type);	?></select>	 </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="expense_list_details_id" value="0" />	
	<input type="hidden"  id="WT_expense_list_detailspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_expense_list_detailsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_expense_list_detailsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Expense Purpose:
	
	
	<select name="expense_list_id" id="expense_list_id_s" class="textbox fWidth" ><option value="">Select Expense Purpose</option>		  	<? 
								
										  $os->optionsHTML('','expense_list_id','title','expense_list');?>
							</select>
   Parent Head Id: <input type="text" class="wtTextClass" name="parent_head_id_s" id="parent_head_id_s" value="" /> &nbsp;  Account Head Id: <input type="text" class="wtTextClass" name="account_head_id_s" id="account_head_id_s" value="" /> &nbsp;  Description: <input type="text" class="wtTextClass" name="description_s" id="description_s" value="" /> &nbsp;  Quantity: <input type="text" class="wtTextClass" name="quantity_s" id="quantity_s" value="" /> &nbsp;  Unit:
	
	<select name="unit" id="unit_s" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->unit);	?></select>	
   Tax Percent: <input type="text" class="wtTextClass" name="tax_percent_s" id="tax_percent_s" value="" /> &nbsp;  Rate Excl Tax: <input type="text" class="wtTextClass" name="rate_excl_tax_s" id="rate_excl_tax_s" value="" /> &nbsp;  Rate Incl Tax: <input type="text" class="wtTextClass" name="rate_incl_tax_s" id="rate_incl_tax_s" value="" /> &nbsp;  Total Excl Tax: <input type="text" class="wtTextClass" name="total_excl_tax_s" id="total_excl_tax_s" value="" /> &nbsp;  Total Incl Tax: <input type="text" class="wtTextClass" name="total_incl_tax_s" id="total_incl_tax_s" value="" /> &nbsp;  Tax Amount: <input type="text" class="wtTextClass" name="tax_amount_s" id="tax_amount_s" value="" /> &nbsp;  User Id: <input type="text" class="wtTextClass" name="user_id_s" id="user_id_s" value="" /> &nbsp;  Type:
	
	<select name="type" id="type_s" class="textbox fWidth" ><option value="">Select Type</option>	<? 
										  $os->onlyOption($os->type);	?></select>	
   Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_expense_list_detailsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_expense_list_detailsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_expense_list_detailsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var expense_list_id_sVal= os.getVal('expense_list_id_s'); 
 var parent_head_id_sVal= os.getVal('parent_head_id_s'); 
 var account_head_id_sVal= os.getVal('account_head_id_s'); 
 var description_sVal= os.getVal('description_s'); 
 var quantity_sVal= os.getVal('quantity_s'); 
 var unit_sVal= os.getVal('unit_s'); 
 var tax_percent_sVal= os.getVal('tax_percent_s'); 
 var rate_excl_tax_sVal= os.getVal('rate_excl_tax_s'); 
 var rate_incl_tax_sVal= os.getVal('rate_incl_tax_s'); 
 var total_excl_tax_sVal= os.getVal('total_excl_tax_s'); 
 var total_incl_tax_sVal= os.getVal('total_incl_tax_s'); 
 var tax_amount_sVal= os.getVal('tax_amount_s'); 
 var user_id_sVal= os.getVal('user_id_s'); 
 var type_sVal= os.getVal('type_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('expense_list_id_s',expense_list_id_sVal );
formdata.append('parent_head_id_s',parent_head_id_sVal );
formdata.append('account_head_id_s',account_head_id_sVal );
formdata.append('description_s',description_sVal );
formdata.append('quantity_s',quantity_sVal );
formdata.append('unit_s',unit_sVal );
formdata.append('tax_percent_s',tax_percent_sVal );
formdata.append('rate_excl_tax_s',rate_excl_tax_sVal );
formdata.append('rate_incl_tax_s',rate_incl_tax_sVal );
formdata.append('total_excl_tax_s',total_excl_tax_sVal );
formdata.append('total_incl_tax_s',total_incl_tax_sVal );
formdata.append('tax_amount_s',tax_amount_sVal );
formdata.append('user_id_s',user_id_sVal );
formdata.append('type_s',type_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_expense_list_detailspagingPageno=os.getVal('WT_expense_list_detailspagingPageno');
	var url='wtpage='+WT_expense_list_detailspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_expense_list_detailsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_expense_list_detailsListDiv',url,formdata);
		
}

WT_expense_list_detailsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('expense_list_id_s',''); 
 os.setVal('parent_head_id_s',''); 
 os.setVal('account_head_id_s',''); 
 os.setVal('description_s',''); 
 os.setVal('quantity_s',''); 
 os.setVal('unit_s',''); 
 os.setVal('tax_percent_s',''); 
 os.setVal('rate_excl_tax_s',''); 
 os.setVal('rate_incl_tax_s',''); 
 os.setVal('total_excl_tax_s',''); 
 os.setVal('total_incl_tax_s',''); 
 os.setVal('tax_amount_s',''); 
 os.setVal('user_id_s',''); 
 os.setVal('type_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_expense_list_detailsListing();	
	
	}
	
 
function WT_expense_list_detailsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var expense_list_idVal= os.getVal('expense_list_id'); 
var parent_head_idVal= os.getVal('parent_head_id'); 
var account_head_idVal= os.getVal('account_head_id'); 
var descriptionVal= os.getVal('description'); 
var quantityVal= os.getVal('quantity'); 
var unitVal= os.getVal('unit'); 
var tax_percentVal= os.getVal('tax_percent'); 
var rate_excl_taxVal= os.getVal('rate_excl_tax'); 
var rate_incl_taxVal= os.getVal('rate_incl_tax'); 
var total_excl_taxVal= os.getVal('total_excl_tax'); 
var total_incl_taxVal= os.getVal('total_incl_tax'); 
var tax_amountVal= os.getVal('tax_amount'); 
var user_idVal= os.getVal('user_id'); 
var typeVal= os.getVal('type'); 
var statusVal= os.getVal('status'); 


 formdata.append('expense_list_id',expense_list_idVal );
 formdata.append('parent_head_id',parent_head_idVal );
 formdata.append('account_head_id',account_head_idVal );
 formdata.append('description',descriptionVal );
 formdata.append('quantity',quantityVal );
 formdata.append('unit',unitVal );
 formdata.append('tax_percent',tax_percentVal );
 formdata.append('rate_excl_tax',rate_excl_taxVal );
 formdata.append('rate_incl_tax',rate_incl_taxVal );
 formdata.append('total_excl_tax',total_excl_taxVal );
 formdata.append('total_incl_tax',total_incl_taxVal );
 formdata.append('tax_amount',tax_amountVal );
 formdata.append('user_id',user_idVal );
 formdata.append('type',typeVal );
 formdata.append('status',statusVal );

	

	 var   expense_list_details_id=os.getVal('expense_list_details_id');
	 formdata.append('expense_list_details_id',expense_list_details_id );
  	var url='<? echo $ajaxFilePath ?>?WT_expense_list_detailsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_expense_list_detailsReLoadList',url,formdata);

}	

function WT_expense_list_detailsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var expense_list_details_id=parseInt(d[0]);
	if(d[0]!='Error' && expense_list_details_id>0)
	{
	  os.setVal('expense_list_details_id',expense_list_details_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_expense_list_detailsListing();
}

function WT_expense_list_detailsGetById(expense_list_details_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('expense_list_details_id',expense_list_details_id );
	var url='<? echo $ajaxFilePath ?>?WT_expense_list_detailsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_expense_list_detailsFillData',url,formdata);
				
}

function WT_expense_list_detailsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('expense_list_details_id',parseInt(objJSON.expense_list_details_id));
	
 os.setVal('expense_list_id',objJSON.expense_list_id); 
 os.setVal('parent_head_id',objJSON.parent_head_id); 
 os.setVal('account_head_id',objJSON.account_head_id); 
 os.setVal('description',objJSON.description); 
 os.setVal('quantity',objJSON.quantity); 
 os.setVal('unit',objJSON.unit); 
 os.setVal('tax_percent',objJSON.tax_percent); 
 os.setVal('rate_excl_tax',objJSON.rate_excl_tax); 
 os.setVal('rate_incl_tax',objJSON.rate_incl_tax); 
 os.setVal('total_excl_tax',objJSON.total_excl_tax); 
 os.setVal('total_incl_tax',objJSON.total_incl_tax); 
 os.setVal('tax_amount',objJSON.tax_amount); 
 os.setVal('user_id',objJSON.user_id); 
 os.setVal('type',objJSON.type); 
 os.setVal('status',objJSON.status); 

  
}

function WT_expense_list_detailsDeleteRowById(expense_list_details_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(expense_list_details_id)<1 || expense_list_details_id==''){  
	var  expense_list_details_id =os.getVal('expense_list_details_id');
	}
	
	if(parseInt(expense_list_details_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('expense_list_details_id',expense_list_details_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_expense_list_detailsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_expense_list_detailsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_expense_list_detailsDeleteRowByIdResults(data)
{
	alert(data);
	WT_expense_list_detailsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_expense_list_detailspagingPageno',parseInt(pageNo));
	WT_expense_list_detailsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>