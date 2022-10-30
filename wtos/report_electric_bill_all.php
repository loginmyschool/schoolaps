<?
/*
   # wtos version : 1.1
   # main ajax process page : electric_billAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
include('wtosSearchAddAssign.php');
?><?
$pluginName='';
$listHeader='Report electric bill details';
$ajaxFilePath= 'electric_billAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';



$return_acc=$os->branch_access();
$and_branch='';
    if($os->userDetails['adminType']!='Super Admin')
	{
	  $selected_branch_codes=$return_acc['branches_code_str_query'];
	  $and_branch=" and branch_code IN($selected_branch_codes)";

	}

$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
     $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
}
 
 
?>
<table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="380" height="470" valign="top" class="ajaxViewMainTableTDForm" style="display:none;">
	<div class="formDiv">
	
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td colspan="2">Branch
										<br />
										<select name="branch_code" id="branch_code" class="textbox fWidth select2" style="width:350px;" ><option value=""> </option>		
										<? $os->onlyOption($branch_code_arr,'')?>
							</select>
							 
							
										 </td>
										 					
										</tr><tr >
	  									<td>Consumer Id </td>
										<td><input value="" type="text" name="consumer_id" id="consumer_id" class="textboxxx  fWidth "/> </td>						
										</tr>
										<tr >
										
										
	  									<td>Consume period from </td>
										<td><input value="" type="text" name="period_from" id="period_from" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Consume  period to </td>
										<td><input value="" type="text" name="period_to" id="period_to" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Previous unit </td>
										<td><input value="" type="text" name="previous_unit" id="previous_unit" class="textboxxx  fWidth " onkeyup="calc_unit();"  /> </td>						
										</tr><tr >
	  									<td>Present unit </td>
										<td><input value="" type="text" name="present_unit" id="present_unit" class="textboxxx  fWidth " onkeyup="calc_unit();"/> </td>						
										</tr><tr >
	  									<td>Consume Unit </td>
										<td><input value="" type="text" name="unit_consumed" id="unit_consumed" class="textboxxx  fWidth "/> </td>	 		
										</tr><tr >
	  									<td>Rate </td>
										<td><input value="" type="text" name="rate" id="rate" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total Payble by Duedate </td>
										<td><input value="" type="text" name="amount" id="amount" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Bill No </td>
										<td><input value="" type="text" name="bill_no" id="bill_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Bill Date </td>
										<td><input value="" type="text" name="bill_date" id="bill_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Due Date </td>
										<td><input value="" type="text" name="due_date" id="due_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Payment Status </td>
										<td>  
	
	<select name="payment_status" id="payment_status" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->payment_status);	?></select>	 </td>						
										</tr><tr >
	  									<td>Payment Date </td>
										<td><input value="" type="text" name="payment_date" id="payment_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Payment Mode </td>
										<td>  
	
	<select name="payment_mode" id="payment_mode" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->payment_mode);	?></select>	 </td>						
										</tr><tr >
	  									<td>Payment Details </td>
										<td><input value="" type="text" name="payment_details" id="payment_details" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Invoice No </td>
										<td><input value="" type="text" name="invoice_no" id="invoice_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Meter No </td>
										<td><input value="" type="text" name="meter_no" id="meter_no" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Document </td>
										<td>
										
										<img id="imagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Amt For Curremt Month </td>
										<td><input value="" type="text" name="current_month_amount" id="current_month_amount" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Payble through RTGS </td>
										<td><input value="" type="text" name="payble_through_rtgs" id="payble_through_rtgs" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><input value="" type="text" name="note" id="note" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="electric_bill_id" value="0" />	
	<input type="hidden"  id="WT_electric_billpagingPageno" value="1" />	
	 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	 
  <input type="text" id="searchKey" style="display:none;" />   &nbsp;
     
	   
	
	<select name="payment_status" id="payment_status_s" class="textbox fWidth"   ><option value=""> </option>	<? 
										  $os->onlyOption($os->payment_status,'');	?></select>	
										  
	<span>									  
	Branch:	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth select2" style="width:370px;" ><option value=""> </option>		  	
	<? $os->onlyOption($branch_code_arr,'')?>
							</select>
							
				 
							
							
	 </span>
  <div style="display:none" id="advanceSearchDiv">
         
 
   Consumer Id: <input type="text" class="wtTextClass" name="consumer_id_s" id="consumer_id_s" value="" /> &nbsp; From Consume  period from: <input class="wtDateClass" type="text" name="f_period_from_s" id="f_period_from_s" value=""  /> &nbsp;   To Consume  period from: <input class="wtDateClass" type="text" name="t_period_from_s" id="t_period_from_s" value=""  /> &nbsp;  
  From Consume  period to: <input class="wtDateClass" type="text" name="f_period_to_s" id="f_period_to_s" value=""  /> &nbsp;   To Consume  period to: <input class="wtDateClass" type="text" name="t_period_to_s" id="t_period_to_s" value=""  /> &nbsp;  
   Bill No: <input type="text" class="wtTextClass" name="bill_no_s" id="bill_no_s" value="" /> &nbsp; From Bill Date: <input class="wtDateClass" type="text" name="f_bill_date_s" id="f_bill_date_s" value=""  /> &nbsp;   To Bill Date: <input class="wtDateClass" type="text" name="t_bill_date_s" id="t_bill_date_s" value=""  /> &nbsp;  
  From Due Date: <input class="wtDateClass" type="text" name="f_due_date_s" id="f_due_date_s" value=""  /> &nbsp;   To Due Date: <input class="wtDateClass" type="text" name="t_due_date_s" id="t_due_date_s" value=""  /> &nbsp;  
   
  From Payment Date: <input class="wtDateClass" type="text" name="f_payment_date_s" id="f_payment_date_s" value=""  /> &nbsp;   To Payment Date: <input class="wtDateClass" type="text" name="t_payment_date_s" id="t_payment_date_s" value=""  /> &nbsp;  
   Payment Mode:
	
	<select name="payment_mode" id="payment_mode_s" class="textbox fWidth" ><option value="">Select Payment Mode</option>	<? 
										  $os->onlyOption($os->payment_mode);	?></select>	
   Payment Details: <input type="text" class="wtTextClass" name="payment_details_s" id="payment_details_s" value="" /> &nbsp;  Invoice No: <input type="text" class="wtTextClass" name="invoice_no_s" id="invoice_no_s" value="" /> &nbsp;  Meter No: <input type="text" class="wtTextClass" name="meter_no_s" id="meter_no_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_electric_billListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
   <input type="button" value="Print" onclick="printData();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_electric_billListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_electric_billListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var branch_code_sVal= os.getVal('branch_code_s'); 
 var consumer_id_sVal= os.getVal('consumer_id_s'); 
 var f_period_from_sVal= os.getVal('f_period_from_s'); 
 var t_period_from_sVal= os.getVal('t_period_from_s'); 
 var f_period_to_sVal= os.getVal('f_period_to_s'); 
 var t_period_to_sVal= os.getVal('t_period_to_s'); 
 var bill_no_sVal= os.getVal('bill_no_s'); 
 var f_bill_date_sVal= os.getVal('f_bill_date_s'); 
 var t_bill_date_sVal= os.getVal('t_bill_date_s'); 
 var f_due_date_sVal= os.getVal('f_due_date_s'); 
 var t_due_date_sVal= os.getVal('t_due_date_s'); 
 var payment_status_sVal= os.getVal('payment_status_s'); 
 var f_payment_date_sVal= os.getVal('f_payment_date_s'); 
 var t_payment_date_sVal= os.getVal('t_payment_date_s'); 
 var payment_mode_sVal= os.getVal('payment_mode_s'); 
 var payment_details_sVal= os.getVal('payment_details_s'); 
 var invoice_no_sVal= os.getVal('invoice_no_s'); 
 var meter_no_sVal= os.getVal('meter_no_s'); 
 var note_sVal= os.getVal('note_s'); 
 

 
 
 
formdata.append('branch_code_s',branch_code_sVal );
formdata.append('consumer_id_s',consumer_id_sVal );
formdata.append('f_period_from_s',f_period_from_sVal );
formdata.append('t_period_from_s',t_period_from_sVal );
formdata.append('f_period_to_s',f_period_to_sVal );
formdata.append('t_period_to_s',t_period_to_sVal );
formdata.append('bill_no_s',bill_no_sVal );
formdata.append('f_bill_date_s',f_bill_date_sVal );
formdata.append('t_bill_date_s',t_bill_date_sVal );
formdata.append('f_due_date_s',f_due_date_sVal );
formdata.append('t_due_date_s',t_due_date_sVal );
formdata.append('payment_status_s',payment_status_sVal );
formdata.append('f_payment_date_s',f_payment_date_sVal );
formdata.append('t_payment_date_s',t_payment_date_sVal );
formdata.append('payment_mode_s',payment_mode_sVal );
formdata.append('payment_details_s',payment_details_sVal );
formdata.append('invoice_no_s',invoice_no_sVal );
formdata.append('meter_no_s',meter_no_sVal );
formdata.append('note_s',note_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_electric_billpagingPageno=os.getVal('WT_electric_billpagingPageno');
	var url='wtpage='+WT_electric_billpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_electric_billListing_report_all=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_electric_billListDiv',url,formdata);
		
}

WT_electric_billListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('branch_code_s',''); 
 os.setVal('consumer_id_s',''); 
 os.setVal('f_period_from_s',''); 
 os.setVal('t_period_from_s',''); 
 os.setVal('f_period_to_s',''); 
 os.setVal('t_period_to_s',''); 
 os.setVal('bill_no_s',''); 
 os.setVal('f_bill_date_s',''); 
 os.setVal('t_bill_date_s',''); 
 os.setVal('f_due_date_s',''); 
 os.setVal('t_due_date_s',''); 
 os.setVal('payment_status_s',''); 
 os.setVal('f_payment_date_s',''); 
 os.setVal('t_payment_date_s',''); 
 os.setVal('payment_mode_s',''); 
 os.setVal('payment_details_s',''); 
 os.setVal('invoice_no_s',''); 
 os.setVal('meter_no_s',''); 
 os.setVal('note_s',''); 
	
		os.setVal('searchKey','');
		WT_electric_billListing();	
	
	}
	
 
function WT_electric_billEditAndSave()  // collect data and send to save
{
        
var formdata = new FormData();
var branch_codeVal= os.getVal('branch_code'); 
var consumer_idVal= os.getVal('consumer_id'); 
var period_fromVal= os.getVal('period_from'); 
var period_toVal= os.getVal('period_to'); 
var previous_unitVal= os.getVal('previous_unit'); 
var present_unitVal= os.getVal('present_unit'); 
var unit_consumedVal= os.getVal('unit_consumed'); 
var rateVal= os.getVal('rate'); 
var amountVal= os.getVal('amount'); 
var bill_noVal= os.getVal('bill_no'); 
var bill_dateVal= os.getVal('bill_date'); 
var due_dateVal= os.getVal('due_date'); 
var payment_statusVal= os.getVal('payment_status'); 
var payment_dateVal= os.getVal('payment_date'); 
var payment_modeVal= os.getVal('payment_mode'); 
var payment_detailsVal= os.getVal('payment_details'); 
var invoice_noVal= os.getVal('invoice_no'); 
var meter_noVal= os.getVal('meter_no'); 
var imageVal= os.getObj('image').files[0]; 
var current_month_amountVal= os.getVal('current_month_amount'); 
var payble_through_rtgsVal= os.getVal('payble_through_rtgs'); 
var noteVal= os.getVal('note'); 


if(branch_codeVal==''){alert('Select branch code'); return false;}
if(consumer_idVal==''){alert('Enter Consumer ID'); return false;}
if(period_fromVal==''){alert('Enter Period from date'); return false;}
if(period_toVal==''){alert('Enter Period To date'); return false;}
if(unit_consumedVal==''){alert('Enter unit consumed'); return false;}
if(amountVal==''){alert('Total Payble by Duedate'); return false;}
if(bill_noVal==''){alert('Enter Bill no'); return false;}
if(payment_statusVal==''){alert('Enter Payment Status'); return false;}



 formdata.append('branch_code',branch_codeVal );
 formdata.append('consumer_id',consumer_idVal );
 formdata.append('period_from',period_fromVal );
 formdata.append('period_to',period_toVal );
 formdata.append('previous_unit',previous_unitVal );
 formdata.append('present_unit',present_unitVal );
 formdata.append('unit_consumed',unit_consumedVal );
 formdata.append('rate',rateVal );
 formdata.append('amount',amountVal );
 formdata.append('bill_no',bill_noVal );
 formdata.append('bill_date',bill_dateVal );
 formdata.append('due_date',due_dateVal );
 formdata.append('payment_status',payment_statusVal );
 formdata.append('payment_date',payment_dateVal );
 formdata.append('payment_mode',payment_modeVal );
 formdata.append('payment_details',payment_detailsVal );
 formdata.append('invoice_no',invoice_noVal );
 formdata.append('meter_no',meter_noVal );
if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
 formdata.append('current_month_amount',current_month_amountVal );
 formdata.append('payble_through_rtgs',payble_through_rtgsVal );
 formdata.append('note',noteVal );

	
if(os.check.empty('consumer_id','Please Add Consumer Id')==false){ return false;} 
if(os.check.empty('previous_unit','Please Add Previous unit')==false){ return false;} 
if(os.check.empty('present_unit','Please Add Present unit')==false){ return false;} 
if(os.check.empty('due_date','Please Add Due Date')==false){ return false;} 

	 var   electric_bill_id=os.getVal('electric_bill_id');
	 formdata.append('electric_bill_id',electric_bill_id );
  	var url='<? echo $ajaxFilePath ?>?WT_electric_billEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_electric_billReLoadList',url,formdata);

}	

function WT_electric_billReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var electric_bill_id=parseInt(d[0]);
	if(d[0]!='Error' && electric_bill_id>0)
	{
	  os.setVal('electric_bill_id',electric_bill_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_electric_billListing();
}

function WT_electric_billGetById(electric_bill_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('electric_bill_id',electric_bill_id );
	var url='<? echo $ajaxFilePath ?>?WT_electric_billGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_electric_billFillData',url,formdata);
				
}

function WT_electric_billFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('electric_bill_id',parseInt(objJSON.electric_bill_id));
	
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('consumer_id',objJSON.consumer_id); 
 os.setVal('period_from',objJSON.period_from); 
 os.setVal('period_to',objJSON.period_to); 
 os.setVal('previous_unit',objJSON.previous_unit); 
 os.setVal('present_unit',objJSON.present_unit); 
 os.setVal('unit_consumed',objJSON.unit_consumed); 
 os.setVal('rate',objJSON.rate); 
 os.setVal('amount',objJSON.amount); 
 os.setVal('bill_no',objJSON.bill_no); 
 os.setVal('bill_date',objJSON.bill_date); 
 os.setVal('due_date',objJSON.due_date); 
 os.setVal('payment_status',objJSON.payment_status); 
 os.setVal('payment_date',objJSON.payment_date); 
 os.setVal('payment_mode',objJSON.payment_mode); 
 os.setVal('payment_details',objJSON.payment_details); 
 os.setVal('invoice_no',objJSON.invoice_no); 
 os.setVal('meter_no',objJSON.meter_no); 
 os.setImg('imagePreview',objJSON.image); 
 os.setVal('current_month_amount',objJSON.current_month_amount); 
 os.setVal('payble_through_rtgs',objJSON.payble_through_rtgs); 
 os.setVal('note',objJSON.note); 

  
}

function WT_electric_billDeleteRowById(electric_bill_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(electric_bill_id)<1 || electric_bill_id==''){  
	var  electric_bill_id =os.getVal('electric_bill_id');
	}
	
	if(parseInt(electric_bill_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('electric_bill_id',electric_bill_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_electric_billDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_electric_billDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_electric_billDeleteRowByIdResults(data)
{
	alert(data);
	WT_electric_billListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_electric_billpagingPageno',parseInt(pageNo));
	WT_electric_billListing();
}

	
	function calc_unit()
	{
	  var previous_unit=parseInt(os.getVal('previous_unit'));
	  var present_unit=parseInt(os.getVal('present_unit'));
	  var unit_consumed=present_unit-previous_unit;
	  
	  os.setVal('unit_consumed',unit_consumed);
	
	} 
	
	function view_e_bills(container)
	{
	 popDialog(container,'Details Bill',{'width':900,'height':500});
	
	} 	 	 	
	
	
	function printData()
	{
	          printById('printrows');
	}
	 
	 
</script>

<script>
      $(document).ready(function () {
					// $('#branch_code_s').select2();
					   
					  
					  
				  }); 
</script>
  
 
<? include($site['root-wtos'].'bottom.php'); ?>