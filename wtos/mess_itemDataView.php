<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_itemAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List mess_item';
$ajaxFilePath= 'mess_itemAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_itemDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_itemEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Item Name </td>
										<td><input value="" type="text" name="item_name" id="item_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Name beng </td>
										<td><input value="" type="text" name="name_beng" id="name_beng" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Code </td>
										<td><input value="" type="text" name="code" id="code" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Search Keys </td>
										<td><input value="" type="text" name="search_keys" id="search_keys" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Image </td>
										<td>
										
										<img id="imagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Unit </td>
										<td>  
	
	<select name="unit" id="unit" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->unit);	?></select>	 </td>						
										</tr><tr >
	  									<td>Active Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Active Status</option>	<? 
										  $os->onlyOption($os->mess_item_active_status);	?></select>	 </td>						
										</tr><tr >
	  									<td>Stock Alert Qty </td>
										<td><input value="" type="text" name="stock_alert_qty" id="stock_alert_qty" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Branch Code </td>
										<td> <select name="branch_code" id="branch_code" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr><tr >
	  									<td>Show In Daily Report </td>
										<td>  
	
	<select name="show_in_daily_report" id="show_in_daily_report" class="textbox fWidth" ><option value="">Select Show In Daily Report</option>	<? 
										  $os->onlyOption($os->show_in_daily_report);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="mess_item_id" value="0" />	
	<input type="hidden"  id="WT_mess_itempagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_itemDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_itemEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;

  
	Added By:	
	<select name="addedBy_s" id="addedBy_s" class="textbox fWidth" ><option value=""></option><?$os->optionsHTML('','adminId','name','admin');?>
	</select>
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Item Name: <input type="text" class="wtTextClass" name="item_name_s" id="item_name_s" value="" /> &nbsp;  Name beng: <input type="text" class="wtTextClass" name="name_beng_s" id="name_beng_s" value="" /> &nbsp;  Code: <input type="text" class="wtTextClass" name="code_s" id="code_s" value="" /> &nbsp;  Search Keys: <input type="text" class="wtTextClass" name="search_keys_s" id="search_keys_s" value="" /> &nbsp;   Unit:
	
	<select name="unit" id="unit_s" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->unit);	?></select>	
   Active Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Active Status</option>	<? 
										  $os->onlyOption($os->mess_item_active_status);	?></select>	
   Stock Alert Qty: <input type="text" class="wtTextClass" name="stock_alert_qty_s" id="stock_alert_qty_s" value="" /> &nbsp;  Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  Show In Daily Report:
	
	<select name="show_in_daily_report" id="show_in_daily_report_s" class="textbox fWidth" ><option value="">Select Show In Daily Report</option>	<? 
										  $os->onlyOption($os->show_in_daily_report);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_itemListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_itemListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_itemListing() {
		var formdata = new FormData();


		var item_name_sVal= os.getVal('item_name_s'); 
		var name_beng_sVal= os.getVal('name_beng_s'); 
		var code_sVal= os.getVal('code_s'); 
		var search_keys_sVal= os.getVal('search_keys_s'); 
		var unit_sVal= os.getVal('unit_s'); 
		var active_status_sVal= os.getVal('active_status_s'); 
		var stock_alert_qty_sVal= os.getVal('stock_alert_qty_s'); 
		var branch_code_sVal= os.getVal('branch_code_s'); 
		var note_sVal= os.getVal('note_s'); 
		var show_in_daily_report_sVal= os.getVal('show_in_daily_report_s'); 

		var addedBy_sVal=os.getVal('addedBy_s');
		formdata.append('addedBy_s',addedBy_sVal);

		formdata.append('item_name_s',item_name_sVal );
		formdata.append('name_beng_s',name_beng_sVal );
		formdata.append('code_s',code_sVal );
		formdata.append('search_keys_s',search_keys_sVal );
		formdata.append('unit_s',unit_sVal );
		formdata.append('active_status_s',active_status_sVal );
		formdata.append('stock_alert_qty_s',stock_alert_qty_sVal );
		formdata.append('branch_code_s',branch_code_sVal );
		formdata.append('note_s',note_sVal );
		formdata.append('show_in_daily_report_s',show_in_daily_report_sVal );
		formdata.append('searchKey',os.getVal('searchKey') );
		formdata.append('showPerPage',os.getVal('showPerPage') );
		var WT_mess_itempagingPageno=os.getVal('WT_mess_itempagingPageno');
		var url='wtpage='+WT_mess_itempagingPageno;
		url='<? echo $ajaxFilePath ?>?WT_mess_itemListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_mess_itemListDiv',url,formdata);
		
}

WT_mess_itemListing();
function  searchReset(){
		os.setVal('addedBy_s','');
		os.setVal('item_name_s',''); 
		os.setVal('name_beng_s',''); 
		os.setVal('code_s',''); 
		os.setVal('search_keys_s',''); 
		os.setVal('unit_s',''); 
		os.setVal('active_status_s',''); 
		os.setVal('stock_alert_qty_s',''); 
		os.setVal('branch_code_s',''); 
		os.setVal('note_s',''); 
		os.setVal('show_in_daily_report_s',''); 
		os.setVal('searchKey','');
		WT_mess_itemListing();	
}
	
 
function WT_mess_itemEditAndSave(){

		var formdata = new FormData();
		var item_nameVal= os.getVal('item_name'); 
		var name_bengVal= os.getVal('name_beng'); 
		var codeVal= os.getVal('code'); 
		var search_keysVal= os.getVal('search_keys'); 
		var imageVal= os.getObj('image').files[0]; 
		var unitVal= os.getVal('unit'); 
		var active_statusVal= os.getVal('active_status'); 
		var stock_alert_qtyVal= os.getVal('stock_alert_qty'); 
		var branch_codeVal= os.getVal('branch_code'); 
		var noteVal= os.getVal('note'); 
		var show_in_daily_reportVal= os.getVal('show_in_daily_report'); 


		formdata.append('item_name',item_nameVal );
		formdata.append('name_beng',name_bengVal );
		formdata.append('code',codeVal );
		formdata.append('search_keys',search_keysVal );
		if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
		formdata.append('unit',unitVal );
		formdata.append('active_status',active_statusVal );
		formdata.append('stock_alert_qty',stock_alert_qtyVal );
		formdata.append('branch_code',branch_codeVal );
		formdata.append('note',noteVal );
		formdata.append('show_in_daily_report',show_in_daily_reportVal );
		var   mess_item_id=os.getVal('mess_item_id');
		formdata.append('mess_item_id',mess_item_id );
		var url='<? echo $ajaxFilePath ?>?WT_mess_itemEditAndSave=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_mess_itemReLoadList',url,formdata);

}	

function WT_mess_itemReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_item_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_item_id>0)
	{
	  os.setVal('mess_item_id',mess_item_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_itemListing();
}

function WT_mess_itemGetById(mess_item_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_item_id',mess_item_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_itemGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_itemFillData',url,formdata);
				
}

function WT_mess_itemFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('mess_item_id',parseInt(objJSON.mess_item_id));
	
 os.setVal('item_name',objJSON.item_name); 
 os.setVal('name_beng',objJSON.name_beng); 
 os.setVal('code',objJSON.code); 
 os.setVal('search_keys',objJSON.search_keys); 
 os.setImg('imagePreview',objJSON.image); 
 os.setVal('unit',objJSON.unit); 
 os.setVal('active_status',objJSON.active_status); 
 os.setVal('stock_alert_qty',objJSON.stock_alert_qty); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 
 os.setVal('show_in_daily_report',objJSON.show_in_daily_report); 

  
}

function WT_mess_itemDeleteRowById(mess_item_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_item_id)<1 || mess_item_id==''){  
	var  mess_item_id =os.getVal('mess_item_id');
	}
	
	if(parseInt(mess_item_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_item_id',mess_item_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_itemDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_itemDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_itemDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_itemListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_itempagingPageno',parseInt(pageNo));
	WT_mess_itemListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>