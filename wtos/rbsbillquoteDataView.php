<?
/*
   # wtos version : 1.1
   # main ajax process page : rbsbillquoteAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Manage Quotation';
$ajaxFilePath= 'rbsbillquoteAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

  include('wtosSearchAddAssign.php');
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbsbillquoteDeleteRowById('');" /><? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbsbillquoteEditAndSave();" /><? } ?>

	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

<tr >
	  									<td>Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Quotation Date </td>
										<td><input value="" type="text" name="rbsbillquoteDate" id="rbsbillquoteDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>Contacts <span id="SAA_C" class="SAA_Container"> </span>
              				 <script>//code333
              				saa.execute('c','SAA_C','rbcontactId','rbcontact','rbcontactId','person,company,phone,email,websiteUrl','Per,Company,Phone,Email,Website','rbcontactId','','');
              				</script></td>
										<td> <select name="rbcontactId" id="rbcontactId" class="textbox fWidth" ><option value="">Select Contacts</option>		  	<?

										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select> </td>
										</tr><tr >
	  									<td>Order No </td>
										<td><input value="" type="text" name="orderNo" id="orderNo" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Bill No </td>
										<td><input value="" type="text" name="billNo" id="billNo" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Bill Subject </td>
										<td><input value="" type="text" name="billSubject" id="billSubject" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Details </td>
										<td><textarea  name="quoteDetails" id="quoteDetails" ></textarea></td>
										</tr><tr >
	  									<td>Employee
                        <span id="SAA_Emp" class="SAA_Container"> </span>
                				 <script>//code333
                				saa.execute('e','SAA_Emp','rbemployeeId','rbemployee','rbemployeeId','name,designation,moble,status','Name,Deg,Mob,Status','rbemployeeId','','');
                        </script>
                      </td>
										<td> <select name="rbemployeeId" id="rbemployeeId" class="textbox fWidth" ><option value="">Select Employee</option>		  	<?

										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select> </td>
										</tr><tr >
	  									<td>Product Amount </td>
										<td><input value="" type="text" name="productAmount" id="productAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Discount Amount </td>
										<td><input value="" type="text" name="discountAmount" id="discountAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Discounted Price </td>
										<td><input value="" type="text" name="discountedPrice" id="discountedPrice" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Tax Rate </td>
										<td><input value="" type="text" name="taxRate" id="taxRate" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Tax Amount </td>
										<td><input value="" type="text" name="taxAmount" id="taxAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Delivery Charge </td>
										<td><input value="" type="text" name="deliveryCharge" id="deliveryCharge" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Install Charge </td>
										<td><input value="" type="text" name="installCharge" id="installCharge" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Payble Amount </td>
										<td><input value="" type="text" name="paybleAmount" id="paybleAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Paid Amount </td>
										<td><input value="" type="text" name="paidAmount" id="paidAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Due Amount </td>
										<td><input value="" type="text" name="dueAmount" id="dueAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Remarks </td>
										<td><textarea  name="remarks" id="remarks" ></textarea></td>
										</tr><tr >
	  									<td>Frequency </td>
										<td>

	<select name="frequency" id="frequency" class="textbox fWidth" ><option value="">Select Frequency</option>	<?
										  $os->onlyOption($os->frequency);	?></select>	 </td>
										</tr><tr >
	  									<td>Register Date </td>
										<td><input value="" type="text" name="registerDate" id="registerDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>From Date </td>
										<td><input value="" type="text" name="fromDate" id="fromDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>Expiry Date </td>
										<td><input value="" type="text" name="expiryDate" id="expiryDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>Prior Days </td>
										<td><input value="" type="text" name="priorDays" id="priorDays" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Reminder Start </td>
										<td><input value="" type="text" name="reminderStart" id="reminderStart" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>Reminder Status </td>
										<td>

	<select name="reminderStatus" id="reminderStatus" class="textbox fWidth" ><option value="">Select Reminder Status</option>	<?
										  $os->onlyOption($os->reminderStatusQuote);	?></select>	 </td>
										</tr>


	</table>


	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
	<input type="hidden"  id="rbsbillquoteId" value="0" />
	<input type="hidden"  id="WT_rbsbillquotepagingPageno" value="1" />
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbsbillquoteDeleteRowById('');" />	<? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbsbillquoteEditAndSave();" /><? } ?>
	</div>
	</div>



	</td>
    <td valign="top" class="ajaxViewMainTableTDList">

	<div class="ajaxViewMainTableTDListSearch">
	Search Key
  <input type="text" id="searchKey" />   &nbsp;



  <div style="display:none" id="advanceSearchDiv">

 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp; From Quotation Date: <input class="wtDateClass" type="text" name="f_rbsbillquoteDate_s" id="f_rbsbillquoteDate_s" value=""  /> &nbsp;   To Quotation Date: <input class="wtDateClass" type="text" name="t_rbsbillquoteDate_s" id="t_rbsbillquoteDate_s" value=""  /> &nbsp;
   Contacts:


	<select name="rbcontactId" id="rbcontactId_s" class="textbox fWidth" ><option value="">Select Contacts</option>		  	<?

										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select>
   Order No: <input type="text" class="wtTextClass" name="orderNo_s" id="orderNo_s" value="" /> &nbsp;  Bill No: <input type="text" class="wtTextClass" name="billNo_s" id="billNo_s" value="" /> &nbsp;  Bill Subject: <input type="text" class="wtTextClass" name="billSubject_s" id="billSubject_s" value="" /> &nbsp;  Employee:


	<select name="rbemployeeId" id="rbemployeeId_s" class="textbox fWidth" ><option value="">Select Employee</option>		  	<?

										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select>
  From Expiry Date: <input class="wtDateClass" type="text" name="f_expiryDate_s" id="f_expiryDate_s" value=""  /> &nbsp;   To Expiry Date: <input class="wtDateClass" type="text" name="t_expiryDate_s" id="t_expiryDate_s" value=""  /> &nbsp;
   Reminder Status:

	<select name="reminderStatus" id="reminderStatus_s" class="textbox fWidth" ><option value="">Select Reminder Status</option>	<?
										  $os->onlyOption($os->reminderStatusQuote);	?></select>

  </div>


  <input type="button" value="Search" onclick="WT_rbsbillquoteListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbsbillquoteListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>



			  <!--   ggggggggggggggg  -->

			  </td>
			  </tr>
			</table>



<script>

function WT_rbsbillquoteListing() // list table searched data get
{
	var formdata = new FormData();


 var refCode_sVal= os.getVal('refCode_s');
 var f_rbsbillquoteDate_sVal= os.getVal('f_rbsbillquoteDate_s');
 var t_rbsbillquoteDate_sVal= os.getVal('t_rbsbillquoteDate_s');
 var rbcontactId_sVal= os.getVal('rbcontactId_s');
 var orderNo_sVal= os.getVal('orderNo_s');
 var billNo_sVal= os.getVal('billNo_s');
 var billSubject_sVal= os.getVal('billSubject_s');
 var rbemployeeId_sVal= os.getVal('rbemployeeId_s');
 var f_expiryDate_sVal= os.getVal('f_expiryDate_s');
 var t_expiryDate_sVal= os.getVal('t_expiryDate_s');
 var reminderStatus_sVal= os.getVal('reminderStatus_s');
formdata.append('refCode_s',refCode_sVal );
formdata.append('f_rbsbillquoteDate_s',f_rbsbillquoteDate_sVal );
formdata.append('t_rbsbillquoteDate_s',t_rbsbillquoteDate_sVal );
formdata.append('rbcontactId_s',rbcontactId_sVal );
formdata.append('orderNo_s',orderNo_sVal );
formdata.append('billNo_s',billNo_sVal );
formdata.append('billSubject_s',billSubject_sVal );
formdata.append('rbemployeeId_s',rbemployeeId_sVal );
formdata.append('f_expiryDate_s',f_expiryDate_sVal );
formdata.append('t_expiryDate_s',t_expiryDate_sVal );
formdata.append('reminderStatus_s',reminderStatus_sVal );



	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbsbillquotepagingPageno=os.getVal('WT_rbsbillquotepagingPageno');
	var url='wtpage='+WT_rbsbillquotepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbsbillquoteListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxHtml('WT_rbsbillquoteListDiv',url,formdata);

}

WT_rbsbillquoteListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s','');
 os.setVal('f_rbsbillquoteDate_s','');
 os.setVal('t_rbsbillquoteDate_s','');
 os.setVal('rbcontactId_s','');
 os.setVal('orderNo_s','');
 os.setVal('billNo_s','');
 os.setVal('billSubject_s','');
 os.setVal('rbemployeeId_s','');
 os.setVal('f_expiryDate_s','');
 os.setVal('t_expiryDate_s','');
 os.setVal('reminderStatus_s','');

		os.setVal('searchKey','');
		WT_rbsbillquoteListing();

	}


function WT_rbsbillquoteEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode');
var rbsbillquoteDateVal= os.getVal('rbsbillquoteDate');
var rbcontactIdVal= os.getVal('rbcontactId');
var orderNoVal= os.getVal('orderNo');
var billNoVal= os.getVal('billNo');
var billSubjectVal= os.getVal('billSubject');
var quoteDetailsVal= os.getVal('quoteDetails');
var rbemployeeIdVal= os.getVal('rbemployeeId');
var productAmountVal= os.getVal('productAmount');
var discountAmountVal= os.getVal('discountAmount');
var discountedPriceVal= os.getVal('discountedPrice');
var taxRateVal= os.getVal('taxRate');
var taxAmountVal= os.getVal('taxAmount');
var deliveryChargeVal= os.getVal('deliveryCharge');
var installChargeVal= os.getVal('installCharge');
var paybleAmountVal= os.getVal('paybleAmount');
var paidAmountVal= os.getVal('paidAmount');
var dueAmountVal= os.getVal('dueAmount');
var remarksVal= os.getVal('remarks');
var frequencyVal= os.getVal('frequency');
var registerDateVal= os.getVal('registerDate');
var fromDateVal= os.getVal('fromDate');
var expiryDateVal= os.getVal('expiryDate');
var priorDaysVal= os.getVal('priorDays');
var reminderStartVal= os.getVal('reminderStart');
var reminderStatusVal= os.getVal('reminderStatus');


 formdata.append('refCode',refCodeVal );
 formdata.append('rbsbillquoteDate',rbsbillquoteDateVal );
 formdata.append('rbcontactId',rbcontactIdVal );
 formdata.append('orderNo',orderNoVal );
 formdata.append('billNo',billNoVal );
 formdata.append('billSubject',billSubjectVal );
 formdata.append('quoteDetails',quoteDetailsVal );
 formdata.append('rbemployeeId',rbemployeeIdVal );
 formdata.append('productAmount',productAmountVal );
 formdata.append('discountAmount',discountAmountVal );
 formdata.append('discountedPrice',discountedPriceVal );
 formdata.append('taxRate',taxRateVal );
 formdata.append('taxAmount',taxAmountVal );
 formdata.append('deliveryCharge',deliveryChargeVal );
 formdata.append('installCharge',installChargeVal );
 formdata.append('paybleAmount',paybleAmountVal );
 formdata.append('paidAmount',paidAmountVal );
 formdata.append('dueAmount',dueAmountVal );
 formdata.append('remarks',remarksVal );
 formdata.append('frequency',frequencyVal );
 formdata.append('registerDate',registerDateVal );
 formdata.append('fromDate',fromDateVal );
 formdata.append('expiryDate',expiryDateVal );
 formdata.append('priorDays',priorDaysVal );
 formdata.append('reminderStart',reminderStartVal );
 formdata.append('reminderStatus',reminderStatusVal );


if(os.check.empty('refCode','Please Add Reffer Code')==false){ return false;}
if(os.check.empty('rbsbillquoteDate','Please Add Quotation Date')==false){ return false;}
if(os.check.empty('rbcontactId','Please Add Contacts')==false){ return false;}
if(os.check.empty('orderNo','Please Add Order No')==false){ return false;}
if(os.check.empty('billNo','Please Add Bill No')==false){ return false;}
if(os.check.empty('rbemployeeId','Please Add Employee')==false){ return false;}

	 var   rbsbillquoteId=os.getVal('rbsbillquoteId');
	 formdata.append('rbsbillquoteId',rbsbillquoteId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbsbillquoteEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbsbillquoteReLoadList',url,formdata);

}

function WT_rbsbillquoteReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var rbsbillquoteId=parseInt(d[0]);
	if(d[0]!='Error' && rbsbillquoteId>0)
	{
	  os.setVal('rbsbillquoteId',rbsbillquoteId);
	}

	if(d[1]!=''){alert(d[1]);}
	WT_rbsbillquoteListing();
}

function WT_rbsbillquoteGetById(rbsbillquoteId) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('rbsbillquoteId',rbsbillquoteId );
	var url='<? echo $ajaxFilePath ?>?WT_rbsbillquoteGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbsbillquoteFillData',url,formdata);

}

function WT_rbsbillquoteFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('rbsbillquoteId',parseInt(objJSON.rbsbillquoteId));

 os.setVal('refCode',objJSON.refCode);
 os.setVal('rbsbillquoteDate',objJSON.rbsbillquoteDate);
 os.setVal('rbcontactId',objJSON.rbcontactId);
 os.setVal('orderNo',objJSON.orderNo);
 os.setVal('billNo',objJSON.billNo);
 os.setVal('billSubject',objJSON.billSubject);
 os.setVal('quoteDetails',objJSON.quoteDetails);
 os.setVal('rbemployeeId',objJSON.rbemployeeId);
 os.setVal('productAmount',objJSON.productAmount);
 os.setVal('discountAmount',objJSON.discountAmount);
 os.setVal('discountedPrice',objJSON.discountedPrice);
 os.setVal('taxRate',objJSON.taxRate);
 os.setVal('taxAmount',objJSON.taxAmount);
 os.setVal('deliveryCharge',objJSON.deliveryCharge);
 os.setVal('installCharge',objJSON.installCharge);
 os.setVal('paybleAmount',objJSON.paybleAmount);
 os.setVal('paidAmount',objJSON.paidAmount);
 os.setVal('dueAmount',objJSON.dueAmount);
 os.setVal('remarks',objJSON.remarks);
 os.setVal('frequency',objJSON.frequency);
 os.setVal('registerDate',objJSON.registerDate);
 os.setVal('fromDate',objJSON.fromDate);
 os.setVal('expiryDate',objJSON.expiryDate);
 os.setVal('priorDays',objJSON.priorDays);
 os.setVal('reminderStart',objJSON.reminderStart);
 os.setVal('reminderStatus',objJSON.reminderStatus);


}

function WT_rbsbillquoteDeleteRowById(rbsbillquoteId) // delete record by table id
{
	var formdata = new FormData();
	if(parseInt(rbsbillquoteId)<1 || rbsbillquoteId==''){
	var  rbsbillquoteId =os.getVal('rbsbillquoteId');
	}

	if(parseInt(rbsbillquoteId)<1){ alert('No record Selected'); return;}

	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

	formdata.append('rbsbillquoteId',rbsbillquoteId );

	var url='<? echo $ajaxFilePath ?>?WT_rbsbillquoteDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbsbillquoteDeleteRowByIdResults',url,formdata);
	}


}
function WT_rbsbillquoteDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbsbillquoteListing();
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbsbillquotepagingPageno',parseInt(pageNo));
	WT_rbsbillquoteListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
