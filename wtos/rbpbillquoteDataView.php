<?
/*
   # wtos version : 1.1
   # main ajax process page : rbpbillquoteAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Proforma Invoice';
$ajaxFilePath= 'rbpbillquoteAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbpbillquoteDeleteRowById('');" /><? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbpbillquoteEditAndSave();" /><? } ?>

	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

<tr >
	  									<td>Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="rbpbillquoteDate" id="rbpbillquoteDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>Contacts <span id="SAA_C" class="SAA_Container"> </span>
              				 <script>//code333
              				saa.execute('c','SAA_C','rbcontactId','rbcontact','rbcontactId','person,company,phone,email,websiteUrl','Per,Company,Phone,Email,Website','rbcontactId','','');
              				</script>

                      </td>
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
	  									<td>Employee <span id="SAA_Emp" class="SAA_Container"> </span>
              				 <script>//code333
              				saa.execute('e','SAA_Emp','rbemployeeId','rbemployee','rbemployeeId','name,designation,moble,status','Name,Deg,Mob,Status','rbemployeeId','','');
                      </script></td>
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
										<td><input value="" type="text" name="paidAmount" id="paidAmount" class="textboxxx  fWidth " style="width:50px"/> </td>
										</tr><tr >
	  									<td>Due Amount </td>
										<td><input value="" type="text" name="dueAmount" id="dueAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Remarks </td>
										<td><textarea  name="remarks" id="remarks" ></textarea></td>
										</tr>


	</table>


	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
	<input type="hidden"  id="rbpbillquoteId" value="0" />
	<input type="hidden"  id="WT_rbpbillquotepagingPageno" value="1" />
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbpbillquoteDeleteRowById('');" />	<? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbpbillquoteEditAndSave();" /><? } ?>
	</div>
	</div>



	</td>
    <td valign="top" class="ajaxViewMainTableTDList">

	<div class="ajaxViewMainTableTDListSearch">
	Search Key
  <input type="text" id="searchKey" />   &nbsp;



  <div style="display:none" id="advanceSearchDiv">

 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp; From Date: <input class="wtDateClass" type="text" name="f_rbpbillquoteDate_s" id="f_rbpbillquoteDate_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_rbpbillquoteDate_s" id="t_rbpbillquoteDate_s" value=""  /> &nbsp;
   Contacts:


	<select name="rbcontactId" id="rbcontactId_s" class="textbox fWidth" ><option value="">Select Contacts</option>		  	<?

										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select>
   Order No: <input type="text" class="wtTextClass" name="orderNo_s" id="orderNo_s" value="" /> &nbsp;  Bill No: <input type="text" class="wtTextClass" name="billNo_s" id="billNo_s" value="" /> &nbsp;  Bill Subject: <input type="text" class="wtTextClass" name="billSubject_s" id="billSubject_s" value="" /> &nbsp;
  </div>


  <input type="button" value="Search" onclick="WT_rbpbillquoteListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbpbillquoteListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>



			  <!--   ggggggggggggggg  -->

			  </td>
			  </tr>
			</table>



<script>

function WT_rbpbillquoteListing() // list table searched data get
{
	var formdata = new FormData();


 var refCode_sVal= os.getVal('refCode_s');
 var f_rbpbillquoteDate_sVal= os.getVal('f_rbpbillquoteDate_s');
 var t_rbpbillquoteDate_sVal= os.getVal('t_rbpbillquoteDate_s');
 var rbcontactId_sVal= os.getVal('rbcontactId_s');
 var orderNo_sVal= os.getVal('orderNo_s');
 var billNo_sVal= os.getVal('billNo_s');
 var billSubject_sVal= os.getVal('billSubject_s');
formdata.append('refCode_s',refCode_sVal );
formdata.append('f_rbpbillquoteDate_s',f_rbpbillquoteDate_sVal );
formdata.append('t_rbpbillquoteDate_s',t_rbpbillquoteDate_sVal );
formdata.append('rbcontactId_s',rbcontactId_sVal );
formdata.append('orderNo_s',orderNo_sVal );
formdata.append('billNo_s',billNo_sVal );
formdata.append('billSubject_s',billSubject_sVal );



	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbpbillquotepagingPageno=os.getVal('WT_rbpbillquotepagingPageno');
	var url='wtpage='+WT_rbpbillquotepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbpbillquoteListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxHtml('WT_rbpbillquoteListDiv',url,formdata);

}

WT_rbpbillquoteListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s','');
 os.setVal('f_rbpbillquoteDate_s','');
 os.setVal('t_rbpbillquoteDate_s','');
 os.setVal('rbcontactId_s','');
 os.setVal('orderNo_s','');
 os.setVal('billNo_s','');
 os.setVal('billSubject_s','');

		os.setVal('searchKey','');
		WT_rbpbillquoteListing();

	}


function WT_rbpbillquoteEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode');
var rbpbillquoteDateVal= os.getVal('rbpbillquoteDate');
var rbcontactIdVal= os.getVal('rbcontactId');
var orderNoVal= os.getVal('orderNo');
var billNoVal= os.getVal('billNo');
var billSubjectVal= os.getVal('billSubject');
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


 formdata.append('refCode',refCodeVal );
 formdata.append('rbpbillquoteDate',rbpbillquoteDateVal );
 formdata.append('rbcontactId',rbcontactIdVal );
 formdata.append('orderNo',orderNoVal );
 formdata.append('billNo',billNoVal );
 formdata.append('billSubject',billSubjectVal );
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


if(os.check.empty('refCode','Please Add Reffer Code')==false){ return false;}
if(os.check.empty('rbpbillquoteDate','Please Add Date')==false){ return false;}
if(os.check.empty('rbcontactId','Please Add Contacts')==false){ return false;}
if(os.check.empty('orderNo','Please Add Order No')==false){ return false;}
if(os.check.empty('billNo','Please Add Bill No')==false){ return false;}

	 var   rbpbillquoteId=os.getVal('rbpbillquoteId');
	 formdata.append('rbpbillquoteId',rbpbillquoteId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbpbillquoteEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbpbillquoteReLoadList',url,formdata);

}

function WT_rbpbillquoteReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var rbpbillquoteId=parseInt(d[0]);
	if(d[0]!='Error' && rbpbillquoteId>0)
	{
	  os.setVal('rbpbillquoteId',rbpbillquoteId);
	}

	if(d[1]!=''){alert(d[1]);}
	WT_rbpbillquoteListing();
}

function WT_rbpbillquoteGetById(rbpbillquoteId) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('rbpbillquoteId',rbpbillquoteId );
	var url='<? echo $ajaxFilePath ?>?WT_rbpbillquoteGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbpbillquoteFillData',url,formdata);

}

function WT_rbpbillquoteFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('rbpbillquoteId',parseInt(objJSON.rbpbillquoteId));

 os.setVal('refCode',objJSON.refCode);
 os.setVal('rbpbillquoteDate',objJSON.rbpbillquoteDate);
 os.setVal('rbcontactId',objJSON.rbcontactId);
 os.setVal('orderNo',objJSON.orderNo);
 os.setVal('billNo',objJSON.billNo);
 os.setVal('billSubject',objJSON.billSubject);
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


}

function WT_rbpbillquoteDeleteRowById(rbpbillquoteId) // delete record by table id
{
	var formdata = new FormData();
	if(parseInt(rbpbillquoteId)<1 || rbpbillquoteId==''){
	var  rbpbillquoteId =os.getVal('rbpbillquoteId');
	}

	if(parseInt(rbpbillquoteId)<1){ alert('No record Selected'); return;}

	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

	formdata.append('rbpbillquoteId',rbpbillquoteId );

	var url='<? echo $ajaxFilePath ?>?WT_rbpbillquoteDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbpbillquoteDeleteRowByIdResults',url,formdata);
	}


}
function WT_rbpbillquoteDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbpbillquoteListing();
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbpbillquotepagingPageno',parseInt(pageNo));
	WT_rbpbillquoteListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
