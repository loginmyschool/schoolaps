<?
/*
   # wtos version : 1.1
   # main ajax process page : itemsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='List items';
$ajaxFilePath= 'itemsAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_itemsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_itemsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="item_name" id="item_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Name(Beng) </td>
										<td><input value="" type="text" name="beng_name" id="beng_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Name(Hindi) </td>
										<td><input value="" type="text" name="hindi_name" id="hindi_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Keywords </td>
										<td><input value="" type="text" name="keywords" id="keywords" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Unit </td>
										<td>  
	
	<select name="item_unit" id="item_unit" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->item_unit);	?></select>	 </td>						
										</tr><tr >
	  									<td>Type </td>
										<td>  
	
	<select name="item_type" id="item_type" class="textbox fWidth" ><option value="">Select Type</option>	<? 
										  $os->onlyOption($os->item_type);	?></select>	 </td>						
										</tr><tr >
	  									<td>Stock Alert Quntity </td>
										<td><input value="" type="text" name="stock_alert_quntity" id="stock_alert_quntity" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Show In Daily Report </td>
										<td>  
	
	<select name="show_in_daily_report" id="show_in_daily_report" class="textbox fWidth" ><option value="">Select Show In Daily Report</option>	<? 
										  $os->onlyOption($os->show_in_daily_report);	?></select>	 </td>						
										</tr><tr >
	  									<td>Departments </td>
										<td>  
	
	<select name="departments" id="departments" class="textbox fWidth" ><option value="">Select Departments</option>	<? 
										  $os->onlyOption($os->departments);	?></select>	 </td>						
										</tr><tr >
	  									<td>Recoverable </td>
										<td>  
	
	<select name="recoverable" id="recoverable" class="textbox fWidth" ><option value="">Select Recoverable</option>	<? 
										  $os->onlyOption($os->recoverable);	?></select>	 </td>						
										</tr><tr >
	  									<td>Photo </td>
										<td>
										
										<img id="photoPreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="photo" value=""  id="photo" onchange="os.readURL(this,'photoPreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('photo');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Code </td>
										<td><input value="" type="text" name="item_code" id="item_code" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Category </td>
										<td>  
	
	<select name="category_id" id="category_id" class="textbox fWidth" ><option value="">Select Category</option>	<? 
										  $os->onlyOption($os->category_list);	?></select>	 </td>						
										</tr><tr >
	  									<td>Barcode Applicable </td>
										<td>  
	
	<select name="barcode_applicable" id="barcode_applicable" class="textbox fWidth" ><option value="">Select Barcode Applicable</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="item_id" value="0" />	
	<input type="hidden"  id="WT_itemspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_itemsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_itemsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Item id: <input type="text" class="wtTextClass" name="item_id_s" id="item_id_s" value="" /> &nbsp;  Name: <input type="text" class="wtTextClass" name="item_name_s" id="item_name_s" value="" /> &nbsp;  Name(Beng): <input type="text" class="wtTextClass" name="beng_name_s" id="beng_name_s" value="" /> &nbsp;  Name(Hindi): <input type="text" class="wtTextClass" name="hindi_name_s" id="hindi_name_s" value="" /> &nbsp;  Keywords: <input type="text" class="wtTextClass" name="keywords_s" id="keywords_s" value="" /> &nbsp;  Unit:
	
	<select name="item_unit" id="item_unit_s" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->item_unit);	?></select>	
   Type:
	
	<select name="item_type" id="item_type_s" class="textbox fWidth" ><option value="">Select Type</option>	<? 
										  $os->onlyOption($os->item_type);	?></select>	
   Show In Daily Report:
	
	<select name="show_in_daily_report" id="show_in_daily_report_s" class="textbox fWidth" ><option value="">Select Show In Daily Report</option>	<? 
										  $os->onlyOption($os->show_in_daily_report);	?></select>	
   Departments:
	
	<select name="departments" id="departments_s" class="textbox fWidth" ><option value="">Select Departments</option>	<? 
										  $os->onlyOption($os->departments);	?></select>	
   Recoverable:
	
	<select name="recoverable" id="recoverable_s" class="textbox fWidth" ><option value="">Select Recoverable</option>	<? 
										  $os->onlyOption($os->recoverable);	?></select>	
   Code: <input type="text" class="wtTextClass" name="item_code_s" id="item_code_s" value="" /> &nbsp;  Category:
	
	<select name="category_id" id="category_id_s" class="textbox fWidth" ><option value="">Select Category</option>	<? 
										  $os->onlyOption($os->category_list);	?></select>	
   Barcode Applicable:
	
	<select name="barcode_applicable" id="barcode_applicable_s" class="textbox fWidth" ><option value="">Select Barcode Applicable</option>	<? 
										  $os->onlyOption($os->yesno);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_itemsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_itemsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_itemsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var item_id_sVal= os.getVal('item_id_s'); 
 var item_name_sVal= os.getVal('item_name_s'); 
 var beng_name_sVal= os.getVal('beng_name_s'); 
 var hindi_name_sVal= os.getVal('hindi_name_s'); 
 var keywords_sVal= os.getVal('keywords_s'); 
 var item_unit_sVal= os.getVal('item_unit_s'); 
 var item_type_sVal= os.getVal('item_type_s'); 
 var show_in_daily_report_sVal= os.getVal('show_in_daily_report_s'); 
 var departments_sVal= os.getVal('departments_s'); 
 var recoverable_sVal= os.getVal('recoverable_s'); 
 var item_code_sVal= os.getVal('item_code_s'); 
 var category_id_sVal= os.getVal('category_id_s'); 
 var barcode_applicable_sVal= os.getVal('barcode_applicable_s'); 
formdata.append('item_id_s',item_id_sVal );
formdata.append('item_name_s',item_name_sVal );
formdata.append('beng_name_s',beng_name_sVal );
formdata.append('hindi_name_s',hindi_name_sVal );
formdata.append('keywords_s',keywords_sVal );
formdata.append('item_unit_s',item_unit_sVal );
formdata.append('item_type_s',item_type_sVal );
formdata.append('show_in_daily_report_s',show_in_daily_report_sVal );
formdata.append('departments_s',departments_sVal );
formdata.append('recoverable_s',recoverable_sVal );
formdata.append('item_code_s',item_code_sVal );
formdata.append('category_id_s',category_id_sVal );
formdata.append('barcode_applicable_s',barcode_applicable_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_itemspagingPageno=os.getVal('WT_itemspagingPageno');
	var url='wtpage='+WT_itemspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_itemsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_itemsListDiv',url,formdata);
		
}

WT_itemsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('item_id_s',''); 
 os.setVal('item_name_s',''); 
 os.setVal('beng_name_s',''); 
 os.setVal('hindi_name_s',''); 
 os.setVal('keywords_s',''); 
 os.setVal('item_unit_s',''); 
 os.setVal('item_type_s',''); 
 os.setVal('show_in_daily_report_s',''); 
 os.setVal('departments_s',''); 
 os.setVal('recoverable_s',''); 
 os.setVal('item_code_s',''); 
 os.setVal('category_id_s',''); 
 os.setVal('barcode_applicable_s',''); 
	
		os.setVal('searchKey','');
		WT_itemsListing();	
	
	}
	
 
function WT_itemsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var item_nameVal= os.getVal('item_name'); 
var beng_nameVal= os.getVal('beng_name'); 
var hindi_nameVal= os.getVal('hindi_name'); 
var keywordsVal= os.getVal('keywords'); 
var item_unitVal= os.getVal('item_unit'); 
var item_typeVal= os.getVal('item_type'); 
var stock_alert_quntityVal= os.getVal('stock_alert_quntity'); 
var show_in_daily_reportVal= os.getVal('show_in_daily_report'); 
var departmentsVal= os.getVal('departments'); 
var recoverableVal= os.getVal('recoverable'); 
var photoVal= os.getObj('photo').files[0]; 
var item_codeVal= os.getVal('item_code'); 
var category_idVal= os.getVal('category_id'); 
var barcode_applicableVal= os.getVal('barcode_applicable'); 


 formdata.append('item_name',item_nameVal );
 formdata.append('beng_name',beng_nameVal );
 formdata.append('hindi_name',hindi_nameVal );
 formdata.append('keywords',keywordsVal );
 formdata.append('item_unit',item_unitVal );
 formdata.append('item_type',item_typeVal );
 formdata.append('stock_alert_quntity',stock_alert_quntityVal );
 formdata.append('show_in_daily_report',show_in_daily_reportVal );
 formdata.append('departments',departmentsVal );
 formdata.append('recoverable',recoverableVal );
if(photoVal){  formdata.append('photo',photoVal,photoVal.name );}
 formdata.append('item_code',item_codeVal );
 formdata.append('category_id',category_idVal );
 formdata.append('barcode_applicable',barcode_applicableVal );

	
if(os.check.empty('item_name','Please Add Name')==false){ return false;} 

	 var   item_id=os.getVal('item_id');
	 formdata.append('item_id',item_id );
  	var url='<? echo $ajaxFilePath ?>?WT_itemsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_itemsReLoadList',url,formdata);

}	

function WT_itemsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var item_id=parseInt(d[0]);
	if(d[0]!='Error' && item_id>0)
	{
	  os.setVal('item_id',item_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_itemsListing();
}

function WT_itemsGetById(item_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('item_id',item_id );
	var url='<? echo $ajaxFilePath ?>?WT_itemsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_itemsFillData',url,formdata);
				
}

function WT_itemsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('item_id',parseInt(objJSON.item_id));
	
 os.setVal('item_name',objJSON.item_name); 
 os.setVal('beng_name',objJSON.beng_name); 
 os.setVal('hindi_name',objJSON.hindi_name); 
 os.setVal('keywords',objJSON.keywords); 
 os.setVal('item_unit',objJSON.item_unit); 
 os.setVal('item_type',objJSON.item_type); 
 os.setVal('stock_alert_quntity',objJSON.stock_alert_quntity); 
 os.setVal('show_in_daily_report',objJSON.show_in_daily_report); 
 os.setVal('departments',objJSON.departments); 
 os.setVal('recoverable',objJSON.recoverable); 
 os.setImg('photoPreview',objJSON.photo); 
 os.setVal('item_code',objJSON.item_code); 
 os.setVal('category_id',objJSON.category_id); 
 os.setVal('barcode_applicable',objJSON.barcode_applicable); 

  
}

function WT_itemsDeleteRowById(item_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(item_id)<1 || item_id==''){  
	var  item_id =os.getVal('item_id');
	}
	
	if(parseInt(item_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('item_id',item_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_itemsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_itemsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_itemsDeleteRowByIdResults(data)
{
	alert(data);
	WT_itemsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_itemspagingPageno',parseInt(pageNo));
	WT_itemsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>