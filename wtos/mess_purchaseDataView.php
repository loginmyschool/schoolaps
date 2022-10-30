<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_purchaseAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Mess Purchase';
$ajaxFilePath= 'mess_purchaseAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_purchaseDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_purchaseEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Mess Vendor </td>
										<td> <select name="mess_vendor_id" id="mess_vendor_id" class="textbox fWidth" ><option value="">Select Mess Vendor</option>		  	<? 
								
										  $os->optionsHTML('','mess_vendor_id','vendor_name','mess_vendor');?>
							</select> </td>						
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Bill No </td>
										<td><input value="" type="text" name="bill_no" id="bill_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total Bill Amount </td>
										<td><input value="" type="text" name="total_bill_amount" id="total_bill_amount" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Payment Status </td>
										<td>  
	
	<select name="payment_status" id="payment_status" class="textbox fWidth" ><option value="">Select Payment Status</option>	<? 
										  $os->onlyOption($os->mess_purchase_payment_status);	?></select>	 </td>						
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
	<input type="hidden"  id="mess_purchase_id" value="0" />	
	<input type="hidden"  id="WT_mess_purchasepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_purchaseDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_purchaseEditAndSave();" /><? } ?>	
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
         
 Mess Vendor:
	
	
	<select name="mess_vendor_id" id="mess_vendor_id_s" class="textbox fWidth" ><option value="">Select Mess Vendor</option>		  	<? 
								
										  $os->optionsHTML('','mess_vendor_id','vendor_name','mess_vendor');?>
							</select>
  From Dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   Bill No: <input type="text" class="wtTextClass" name="bill_no_s" id="bill_no_s" value="" /> &nbsp;  Total Bill Amount: <input type="text" class="wtTextClass" name="total_bill_amount_s" id="total_bill_amount_s" value="" /> &nbsp;  Payment Status:
	
	<select name="payment_status" id="payment_status_s" class="textbox fWidth" ><option value="">Select Payment Status</option>	<? 
										  $os->onlyOption($os->mess_purchase_payment_status);	?></select>	
   Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_purchaseListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_purchaseListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_purchaseListing() // list table searched data get 
{
	var formdata = new FormData();


	var mess_vendor_id_sVal= os.getVal('mess_vendor_id_s'); 
	var f_dated_sVal= os.getVal('f_dated_s'); 
	var t_dated_sVal= os.getVal('t_dated_s'); 
	var bill_no_sVal= os.getVal('bill_no_s'); 
	var total_bill_amount_sVal= os.getVal('total_bill_amount_s'); 
	var payment_status_sVal= os.getVal('payment_status_s'); 
	var branch_code_sVal= os.getVal('branch_code_s'); 
	var note_sVal= os.getVal('note_s'); 

	var addedBy_sVal=os.getVal('addedBy_s');
	formdata.append('addedBy_s',addedBy_sVal);
	formdata.append('mess_vendor_id_s',mess_vendor_id_sVal );
	formdata.append('f_dated_s',f_dated_sVal );
	formdata.append('t_dated_s',t_dated_sVal );
	formdata.append('bill_no_s',bill_no_sVal );
	formdata.append('total_bill_amount_s',total_bill_amount_sVal );
	formdata.append('payment_status_s',payment_status_sVal );
	formdata.append('branch_code_s',branch_code_sVal );
	formdata.append('note_s',note_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_mess_purchasepagingPageno=os.getVal('WT_mess_purchasepagingPageno');
	var url='wtpage='+WT_mess_purchasepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_mess_purchaseListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_mess_purchaseListDiv',url,formdata);
		
}

WT_mess_purchaseListing();
function  searchReset(){
		os.setVal('addedBy_s','');
		os.setVal('mess_vendor_id_s',''); 
		os.setVal('f_dated_s',''); 
		os.setVal('t_dated_s',''); 
		os.setVal('bill_no_s',''); 
		os.setVal('total_bill_amount_s',''); 
		os.setVal('payment_status_s',''); 
		os.setVal('branch_code_s',''); 
		os.setVal('note_s',''); 
		os.setVal('searchKey','');
		WT_mess_purchaseListing();	
}
	
 
function WT_mess_purchaseEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var mess_vendor_idVal= os.getVal('mess_vendor_id'); 
var datedVal= os.getVal('dated'); 
var bill_noVal= os.getVal('bill_no'); 
var total_bill_amountVal= os.getVal('total_bill_amount'); 
var payment_statusVal= os.getVal('payment_status'); 
var branch_codeVal= os.getVal('branch_code'); 
var noteVal= os.getVal('note'); 


 formdata.append('mess_vendor_id',mess_vendor_idVal );
 formdata.append('dated',datedVal );
 formdata.append('bill_no',bill_noVal );
 formdata.append('total_bill_amount',total_bill_amountVal );
 formdata.append('payment_status',payment_statusVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('note',noteVal );

	

	 var   mess_purchase_id=os.getVal('mess_purchase_id');
	 formdata.append('mess_purchase_id',mess_purchase_id );
  	var url='<? echo $ajaxFilePath ?>?WT_mess_purchaseEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_purchaseReLoadList',url,formdata);

}	

function WT_mess_purchaseReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_purchase_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_purchase_id>0)
	{
	  os.setVal('mess_purchase_id',mess_purchase_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_purchaseListing();
}

function WT_mess_purchaseGetById(mess_purchase_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_purchase_id',mess_purchase_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_purchaseGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_purchaseFillData',url,formdata);
				
}

function WT_mess_purchaseFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('mess_purchase_id',parseInt(objJSON.mess_purchase_id));
	
 os.setVal('mess_vendor_id',objJSON.mess_vendor_id); 
 os.setVal('dated',objJSON.dated); 
 os.setVal('bill_no',objJSON.bill_no); 
 os.setVal('total_bill_amount',objJSON.total_bill_amount); 
 os.setVal('payment_status',objJSON.payment_status); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 

  
}

function WT_mess_purchaseDeleteRowById(mess_purchase_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_purchase_id)<1 || mess_purchase_id==''){  
	var  mess_purchase_id =os.getVal('mess_purchase_id');
	}
	
	if(parseInt(mess_purchase_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_purchase_id',mess_purchase_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_purchaseDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_purchaseDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_purchaseDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_purchaseListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_purchasepagingPageno',parseInt(pageNo));
	WT_mess_purchaseListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>