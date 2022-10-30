<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_stockAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Mess Stock';
$ajaxFilePath= 'mess_stockAjax.php';
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
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm" style="display:none">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_stockDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_stockEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Mess Item </td>
										<td> <select name="mess_item_id" id="mess_item_id" class="textbox fWidth" ><option value="">Select Mess Item</option>		  	<? 
								
										  $os->optionsHTML('','mess_item_id','item_name','mess_item');?>
							</select> </td>						
										</tr><tr >
	  									<td>Dated </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Quantity </td>
										<td><input value="" type="text" name="quantity" id="quantity" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Unit </td>
										<td>  
	
	<select name="unit" id="unit" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->unit);	?></select>	 </td>						
										</tr><tr >
	  									<td>Branch Code </td>
										<td> <select name="branch_code" id="branch_code" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="mess_stock_id" value="0" />	
	<input type="hidden"  id="WT_mess_stockpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_stockDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_stockEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	 
	 
  <div style="display:none" id="advanceSearchDiv">
  	 Added By:	
	<select name="addedBy_s" id="addedBy_s" class="textbox fWidth" ><option value=""></option><?$os->optionsHTML('','adminId','name','admin');?>
	</select>
         
 Mess Item:
	
	
	<select name="mess_item_id" id="mess_item_id_s" class="textbox fWidth" ><option value="">Select Mess Item</option>		  	<? 
								
										  $os->optionsHTML('','mess_item_id','item_name','mess_item');?>
							</select>
  From Dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   Quantity: <input type="text" class="wtTextClass" name="quantity_s" id="quantity_s" value="" /> &nbsp;  Unit:
	
	<select name="unit" id="unit_s" class="textbox fWidth" ><option value="">Select Unit</option>	<? 
										  $os->onlyOption($os->unit);	?></select>	
   Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_stockListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_stockListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_stockListing() // list table searched data get 
{
		var formdata = new FormData();


		var mess_item_id_sVal= os.getVal('mess_item_id_s'); 
		var f_dated_sVal= os.getVal('f_dated_s'); 
		var t_dated_sVal= os.getVal('t_dated_s'); 
		var quantity_sVal= os.getVal('quantity_s'); 
		var unit_sVal= os.getVal('unit_s'); 
		var branch_code_sVal= os.getVal('branch_code_s'); 
		var note_sVal= os.getVal('note_s'); 

		var addedBy_sVal=os.getVal('addedBy_s');
		formdata.append('addedBy_s',addedBy_sVal);
		formdata.append('mess_item_id_s',mess_item_id_sVal );
		formdata.append('f_dated_s',f_dated_sVal );
		formdata.append('t_dated_s',t_dated_sVal );
		formdata.append('quantity_s',quantity_sVal );
		formdata.append('unit_s',unit_sVal );
		formdata.append('branch_code_s',branch_code_sVal );
		formdata.append('note_s',note_sVal );



		formdata.append('searchKey',os.getVal('searchKey') );
		formdata.append('showPerPage',os.getVal('showPerPage') );
		var WT_mess_stockpagingPageno=os.getVal('WT_mess_stockpagingPageno');
		var url='wtpage='+WT_mess_stockpagingPageno;
		url='<? echo $ajaxFilePath ?>?WT_mess_stockListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_mess_stockListDiv',url,formdata);
		
}

WT_mess_stockListing();
function  searchReset(){

		os.setVal('addedBy_s','');
		os.setVal('mess_item_id_s',''); 
		os.setVal('f_dated_s',''); 
		os.setVal('t_dated_s',''); 
		os.setVal('quantity_s',''); 
		os.setVal('unit_s',''); 
		os.setVal('branch_code_s',''); 
		os.setVal('note_s',''); 

		os.setVal('searchKey','');
		WT_mess_stockListing();	
	}
	
 
function WT_mess_stockEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var mess_item_idVal= os.getVal('mess_item_id'); 
var datedVal= os.getVal('dated'); 
var quantityVal= os.getVal('quantity'); 
var unitVal= os.getVal('unit'); 
var branch_codeVal= os.getVal('branch_code'); 
var noteVal= os.getVal('note'); 


 formdata.append('mess_item_id',mess_item_idVal );
 formdata.append('dated',datedVal );
 formdata.append('quantity',quantityVal );
 formdata.append('unit',unitVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('note',noteVal );

	

	 var   mess_stock_id=os.getVal('mess_stock_id');
	 formdata.append('mess_stock_id',mess_stock_id );
  	var url='<? echo $ajaxFilePath ?>?WT_mess_stockEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_stockReLoadList',url,formdata);

}	

function WT_mess_stockReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_stock_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_stock_id>0)
	{
	  os.setVal('mess_stock_id',mess_stock_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_stockListing();
}

function WT_mess_stockGetById(mess_stock_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_stock_id',mess_stock_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_stockGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_stockFillData',url,formdata);
				
}

function WT_mess_stockFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('mess_stock_id',parseInt(objJSON.mess_stock_id));
	
 os.setVal('mess_item_id',objJSON.mess_item_id); 
 os.setVal('dated',objJSON.dated); 
 os.setVal('quantity',objJSON.quantity); 
 os.setVal('unit',objJSON.unit); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 

  
}

function WT_mess_stockDeleteRowById(mess_stock_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_stock_id)<1 || mess_stock_id==''){  
	var  mess_stock_id =os.getVal('mess_stock_id');
	}
	
	if(parseInt(mess_stock_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_stock_id',mess_stock_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_stockDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_stockDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_stockDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_stockListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_stockpagingPageno',parseInt(pageNo));
	WT_mess_stockListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>