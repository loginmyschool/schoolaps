<?
/*
   # wtos version : 1.1
   # main ajax process page : rbpurchaseAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Manage Purchase';
$ajaxFilePath= 'rbpurchaseAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';


include('rbListAndAssign.php');
include('wtosSearchAddAssign.php');
include('quickEditPage.php');

?>


 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>

			  <td  class="middle" style="padding-left:5px;">


			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>

			  <!--  ggggggggggggggg   -->


			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

  <tr>
    <td width="370" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbpurchaseDeleteRowById('');" /><? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbpurchaseEditAndSave();" /><? } ?>

	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

<tr >
	  									<td>Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="rbpurchaseDate" id="rbpurchaseDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>Vender <span id="SAA_m" class="SAA_Container"> </span>
              				 <script>//code333
              				saa.execute('m','SAA_m','rbvenderId','rbvender','rbvenderId','name,phone,email,contatPerson','Per,Ph,Emal,ContactPer','rbvenderId','','');
              				</script>

                      </td>
										<td> <select name="rbvenderId" id="rbvenderId" class="textbox fWidth" ><option value="">Select Vender</option>		  	<?

										  $os->optionsHTML('','rbvenderId','name','rbvender');?>
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
	  									<td>Payment Status </td>
										<td>

	<select name="paymentStatus" id="paymentStatus" class="textbox fWidth" ><option value="">Select Payment Status</option>	<?
										  $os->onlyOption($os->paymentStatusPur);	?></select>	 </td>
										</tr><tr >
	  									<td>Employee <span id="SAA_Emp" class="SAA_Container"> </span>
              				 <script>//code333
              				saa.execute('e','SAA_Emp','rbemployeeId','rbemployee','rbemployeeId','name,designation,moble,status','Name,Deg,Mob,Status','rbemployeeId','','');
                      </script>

                      </td>
										<td> <select name="rbemployeeId" id="rbemployeeId" class="textbox fWidth" ><option value="">Select Employee</option>		  	<?

										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select> </td>
										</tr>
										
										<tr>
										<td> 
									View or add products</td> <td >  <span  class="actionLink" ><a href="javascript:void(0)"  onclick="openProducts()"	>Products</a></span>
                                             <!-- gggggg this is for payment calculation  -->
					<div id="quickProductPOPUP" class="RB_popupBOX" style="display:none; width:auto;"  >
					<div class="RBpopoupClose" onclick="rb.popUpClose('quickProductPOPUP')">X</div>
					<div class="popoupHead" >Product Details  </div>
                    <div id="quickProduct" style="margin:10px;" >


                    <? 			
			      //    $os->productsArray= $os->getProductsArray();  	
					  
                     $options=array();
                     $options['PageHeading']='Product Bill Payments';
                     $options['foreignId']='rbpurchaseId';
                     $options['foreignTable']='rbpurchase';
                     $options['table']='rbpurchasedetails';
                     $options['tableId']='rbpurchasedetailsId';
                     $options['tableQuery']="select * from rbpurchasedetails where [condition] order by rbpurchasedetailsId ";
                   
				     $options['fields']=array('rbproductId'=>'Product','serialNo'=>'SerialNo','model'=>'Model','quantity'=>'Qty','unitPrice'=>'UnitPrice','totalPrice'=>'Total');
                     $options['type']=array('rbproductId'=>'DD','serialNo'=>'T','model'=>'T','quantity'=>'T','unitPrice'=>'T','totalPrice'=>'T');
                     $options['relation']=array('rbproductId'=>'select * from rbproduct order by name -fld-rbproductId-fld-rbproductId,name,model','serialNo'=>'','model'=>'','quantity'=>'','unitPrice'=>'','totalPrice'=>'');
                     $options['class']=array('rbproductId'=>' ','serialNo'=>'serialNo','model'=>'model','quantity'=>'quantity','unitPrice'=>'unitPrice','totalPrice'=>'totalPrice');  ## add jquery date class
                     $options['extra']=array('rbproductId'=>'','quantity'=>' onkeyup="calculateProductTotal()" ','unitPrice'=>' onkeyup="calculateProductTotal()" '); // add extra onclick="testme()"
                  //   $options['inlineEdit']=array('details'=>'yes');
					 $options['inlineEdit']=array();
                     $options['add']='1'; // 0/1
                     $options['delete']='1'; // 0/1
                     $options['defaultValues']=array();
                     $options['afterSaveCallback']=array('php'=>'calculateProductAmmount','javaScript'=>'setProductAmountTotal');
					   
                     $functionId='product';
                     quickEdit_v_four($options ,0,$functionId);
                     ?>
                     <style>
                       .qaddButton{ font-size:10px; font-weight:bold; background-color:#009900;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                       .qdeleteButton{ font-size:10px; font-weight:bold; background-color:#FF0000;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; line-height:10px;-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                        .wtclass<? echo $functionId?>{margin:0px 5px 0px 0px; padding:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:2px groove #FFFFFF;}
                       .wtclass<? echo $functionId?> tr{ height:10px;}
                       .wtclass<? echo $functionId?> td{ height:10px; padding:0px; border-bottom:2px groove #FFFFFF; border-right:2px groove #FFFFFF; }
                       .wtclass<? echo $functionId?> tr:hover{ background-color:#F0F0F0;}
                        .wtclass<? echo $functionId?> .PageHeading{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; background:#007CB9; color:#FFFFFF; padding:2px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; font-style:italic;}
                        .wtalise<? echo $functionId?>{ display:none;}
                       .paymentText{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:120px; }
                       .details{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:220px;}
                       .otheramount{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:70px; }
                       .formTR{ opacity:0.8;}
                       .formTR:hover{ opacity:1;}
                       .paymentdown{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:0px;-webkit-appearance: none; -moz-appearance: none;  text-indent: 1px; text-overflow: '';}
                       .prod{width:170px;}
					   .serialNo{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:130px;}
					   .model{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:100px;}
					   .quantity{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:30px;}
					   .unitPrice{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:60px;}
					   .totalPrice{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:60px;}
					   .payDate{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:110px;}
					   
					   
					   .showProductTable{ border:1px solid #ECECFF;}
					   .showProductTable td{ border-left:1px solid #ECECFF; border-top:1px solid #ECECFF; padding:1px; line-height:11px; height:11px; font-size:11px;}				   
                     </style>
					 
					  <script>
                      function setProductAmountTotal(data)
                      {
   
                         var callBackOutput=data.split('-CALLBACKOUTPUT-');
                         callBackOutput=callBackOutput[1];
                         if(!callBackOutput){   callBackOutput='';      }


                         var totalVal= parseFloat(eval(callBackOutput)) ;
                         totalVal=totalVal.toFixed(2);
                         os.setVal('productAmount',totalVal);
                         os.viewCalender('wtDateClass','<? echo $os->dateFormatJs; ?>');
                         //setDueAmount();
						 //calculatePaybleAndDue();
                      }
					function openProducts()
					{
						
						var rbpurchaseId=os.getVal('rbpurchaseId');
						if(parseInt(rbpurchaseId)<1)
						{
						alert('Please save record');
						return false;
						}
						
						rb.popUpOpen('quickProductPOPUP');
						
					}
                     
					 function calculateProductTotal() // for quick edit fields
					 {
						var productquantity=parseFloat( os.getVal('productquantity'));
						var productunitPrice= parseFloat(os.getVal('productunitPrice'));
						var producttotalPrice= productquantity*productunitPrice;
					    os.setVal('producttotalPrice',producttotalPrice);
					 }  


                      </script>
					 
                       </div>
					</div>
                   
										</td>
										</tr>
										<tr >
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
	  									<td>Payble Amount </td>
										<td><input value="" type="text" name="paybleAmount" id="paybleAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Paid Amount </td>
										<td><input value="" type="text" name="paidAmount" id="paidAmount" class="textboxxx  fWidth " style="width:70px"/> <span  class="actionLink" ><a href="javascript:void(0)"  onclick="openPayment()"	>Payment</a></span></td>

                    <!-- gggggg this is for payment calculation  -->
                    <div id="quickPaymentPOPUP" class="RB_popupBOX" style="display:none;"  >
                            <div class="RBpopoupClose" onclick="rb.popUpClose('quickPaymentPOPUP')">X</div>
                       <div class="popoupHead" >Payment Details  </div>
                    <div id="quickPayment" style="margin:10px;">


                    <?  
                     $options=array();
                     $options['PageHeading']='Purchase Payments';
                     $options['foreignId']='rbpurchaseId';
                     $options['foreignTable']='rbpurchase';
                     $options['table']='rbpurchasepayment';
                     $options['tableId']='rbpurchasepaymentId';
                     $options['tableQuery']="select * from rbpurchasepayment where [condition] order by rbpurchasepaymentId ";
                     $options['fields']=array('paidDate'=>'Date','paidAmount'=>'Amount','method'=>'Mode','details'=>'details');
                     $options['type']=array('paidDate'=>'D','paidAmount'=>'T','method'=>'DD','details'=>'T');
                     $options['relation']=array('paidDate'=>'','paidAmount'=>'','method'=>'paymentethod','details'=>'');
                     $options['class']=array('paidDate'=>'wtDateClass payDate','paidAmount'=>'paymentText','method'=>'paymentdown','details'=>'details');  ## add jquery date class
                     $options['extra']=array('paidDate'=>'','paidAmount'=>'','method'=>'','details'=>''); // add extra onclick="testme()"
                     $options['inlineEdit']=array('details'=>'yes');
                     $options['add']='1'; // 0/1
                     $options['delete']='1'; // 0/1
                     $options['defaultValues']=array();
                     $options['afterSaveCallback']=array('php'=>'calculatePaymentTotal','javaScript'=>'setPaymentTotal');
                     $functionId='payments';
                     quickEdit_v_four($options ,0,$functionId);
                     ?>
                     <style>
                       .qaddButton{ font-size:10px; font-weight:bold; background-color:#009900;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                       .qdeleteButton{ font-size:10px; font-weight:bold; background-color:#FF0000;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; line-height:10px;-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                        .wtclass<? echo $functionId?>{margin:0px 5px 0px 0px; padding:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                       .wtclass<? echo $functionId?> tr{ height:10px;}
                       .wtclass<? echo $functionId?> td{ height:10px; padding:0px;}
                       .wtclass<? echo $functionId?> tr:hover{ background-color:#F0F0F0;}
                        .wtclass<? echo $functionId?> .PageHeading{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; background:#007CB9; color:#FFFFFF; padding:2px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; font-style:italic;}
                        .wtalise<? echo $functionId?>{ display:none;}
                       .paymentText{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:120px; }
                       .details{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:220px;}
                       .otheramount{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:70px; }
                       .formTR{ opacity:0.8;}
                       .formTR:hover{ opacity:1;}
                       .paymentdown{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:0px;-webkit-appearance: none; -moz-appearance: none;  text-indent: 1px; text-overflow: '';}
                       .payDate{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:110px;}
                     </style>
                       <script>
                      function setPaymentTotal(data)
                      {

                         var callBackOutput=data.split('-CALLBACKOUTPUT-');
                         callBackOutput=callBackOutput[1];
                         if(!callBackOutput){   callBackOutput='';      }


                         var totalVal= parseFloat(eval(callBackOutput)) ;
                         totalVal=totalVal.toFixed(2);
                         os.setVal('paidAmount',totalVal);
                         os.viewCalender('wtDateClass','<? echo $os->dateFormatJs; ?>');
                         //setDueAmount();
                      }


                      </script>

										</tr><tr >
	  									<td>Due Amount </td>
										<td><input value="" type="text" name="dueAmount" id="dueAmount" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Remarks </td>
										<td><textarea  name="remarks" id="remarks" ></textarea></td>
										</tr>


	</table>


	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
	<input type="hidden"  id="rbpurchaseId" value="0" />
	<input type="hidden"  id="WT_rbpurchasepagingPageno" value="1" />
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbpurchaseDeleteRowById('');" />	<? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbpurchaseEditAndSave();" /><? } ?>
	</div>
	</div>



	</td>
    <td valign="top" class="ajaxViewMainTableTDList">

	<div class="ajaxViewMainTableTDListSearch">
	Search Key
  <input type="text" id="searchKey" />   &nbsp;



  <div style="display:none" id="advanceSearchDiv">

 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp; From Date: <input class="wtDateClass" type="text" name="f_rbpurchaseDate_s" id="f_rbpurchaseDate_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_rbpurchaseDate_s" id="t_rbpurchaseDate_s" value=""  /> &nbsp;
   Vender:


	<select name="rbvenderId" id="rbvenderId_s" class="textbox fWidth" ><option value="">Select Vender</option>		  	<?

										  $os->optionsHTML('','rbvenderId','name','rbvender');?>
							</select>
   Order No: <input type="text" class="wtTextClass" name="orderNo_s" id="orderNo_s" value="" /> &nbsp;  Bill No: <input type="text" class="wtTextClass" name="billNo_s" id="billNo_s" value="" /> &nbsp;  Bill Subject: <input type="text" class="wtTextClass" name="billSubject_s" id="billSubject_s" value="" /> &nbsp;  Payment Status:

	<select name="paymentStatus" id="paymentStatus_s" class="textbox fWidth" ><option value="">Select Payment Status</option>	<?
										  $os->onlyOption($os->paymentStatusPur);	?></select>
   Employee:


	<select name="rbemployeeId" id="rbemployeeId_s" class="textbox fWidth" ><option value="">Select Employee</option>		  	<?

										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select>
   Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;
  </div>


  <input type="button" value="Search" onclick="WT_rbpurchaseListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbpurchaseListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>



			  <!--   ggggggggggggggg  -->

			  </td>
			  </tr>
			</table>



<script>

function WT_rbpurchaseListing() // list table searched data get
{
	var formdata = new FormData();


 var refCode_sVal= os.getVal('refCode_s');
 var f_rbpurchaseDate_sVal= os.getVal('f_rbpurchaseDate_s');
 var t_rbpurchaseDate_sVal= os.getVal('t_rbpurchaseDate_s');
 var rbvenderId_sVal= os.getVal('rbvenderId_s');
 var orderNo_sVal= os.getVal('orderNo_s');
 var billNo_sVal= os.getVal('billNo_s');
 var billSubject_sVal= os.getVal('billSubject_s');
 var paymentStatus_sVal= os.getVal('paymentStatus_s');
 var rbemployeeId_sVal= os.getVal('rbemployeeId_s');
 var remarks_sVal= os.getVal('remarks_s');
formdata.append('refCode_s',refCode_sVal );
formdata.append('f_rbpurchaseDate_s',f_rbpurchaseDate_sVal );
formdata.append('t_rbpurchaseDate_s',t_rbpurchaseDate_sVal );
formdata.append('rbvenderId_s',rbvenderId_sVal );
formdata.append('orderNo_s',orderNo_sVal );
formdata.append('billNo_s',billNo_sVal );
formdata.append('billSubject_s',billSubject_sVal );
formdata.append('paymentStatus_s',paymentStatus_sVal );
formdata.append('rbemployeeId_s',rbemployeeId_sVal );
formdata.append('remarks_s',remarks_sVal );



	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbpurchasepagingPageno=os.getVal('WT_rbpurchasepagingPageno');
	var url='wtpage='+WT_rbpurchasepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbpurchaseListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxHtml('WT_rbpurchaseListDiv',url,formdata);

}

WT_rbpurchaseListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s','');
 os.setVal('f_rbpurchaseDate_s','');
 os.setVal('t_rbpurchaseDate_s','');
 os.setVal('rbvenderId_s','');
 os.setVal('orderNo_s','');
 os.setVal('billNo_s','');
 os.setVal('billSubject_s','');
 os.setVal('paymentStatus_s','');
 os.setVal('rbemployeeId_s','');
 os.setVal('remarks_s','');

		os.setVal('searchKey','');
		WT_rbpurchaseListing();

	}


function WT_rbpurchaseEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode');
var rbpurchaseDateVal= os.getVal('rbpurchaseDate');
var rbvenderIdVal= os.getVal('rbvenderId');
var orderNoVal= os.getVal('orderNo');
var billNoVal= os.getVal('billNo');
var billSubjectVal= os.getVal('billSubject');
var paymentStatusVal= os.getVal('paymentStatus');
var rbemployeeIdVal= os.getVal('rbemployeeId');
var productAmountVal= os.getVal('productAmount');
var discountAmountVal= os.getVal('discountAmount');
var discountedPriceVal= os.getVal('discountedPrice');
var taxRateVal= os.getVal('taxRate');
var taxAmountVal= os.getVal('taxAmount');
var paybleAmountVal= os.getVal('paybleAmount');
var paidAmountVal= os.getVal('paidAmount');
var dueAmountVal= os.getVal('dueAmount');
var remarksVal= os.getVal('remarks');


 formdata.append('refCode',refCodeVal );
 formdata.append('rbpurchaseDate',rbpurchaseDateVal );
 formdata.append('rbvenderId',rbvenderIdVal );
 formdata.append('orderNo',orderNoVal );
 formdata.append('billNo',billNoVal );
 formdata.append('billSubject',billSubjectVal );
 formdata.append('paymentStatus',paymentStatusVal );
 formdata.append('rbemployeeId',rbemployeeIdVal );
 formdata.append('productAmount',productAmountVal );
 formdata.append('discountAmount',discountAmountVal );
 formdata.append('discountedPrice',discountedPriceVal );
 formdata.append('taxRate',taxRateVal );
 formdata.append('taxAmount',taxAmountVal );
 formdata.append('paybleAmount',paybleAmountVal );
 formdata.append('paidAmount',paidAmountVal );
 formdata.append('dueAmount',dueAmountVal );
 formdata.append('remarks',remarksVal );


//if(os.check.empty('refCode','Please Add Reffer Code')==false){ return false;}
if(os.check.empty('rbpurchaseDate','Please Add Date')==false){ return false;}
if(os.check.empty('rbvenderId','Please Add Vender')==false){ return false;}
//if(os.check.empty('orderNo','Please Add Order No')==false){ return false;}
if(os.check.empty('billNo','Please Add Bill No')==false){ return false;}
if(os.check.empty('billSubject','Please Add Bill Subject')==false){ return false;}
if(os.check.empty('paymentStatus','Please Add Payment Status')==false){ return false;}
if(os.check.empty('rbemployeeId','Please Add Employee')==false){ return false;}
//if(os.check.empty('remarks','Please Add Remarks')==false){ return false;}

	 var   rbpurchaseId=os.getVal('rbpurchaseId');
	 formdata.append('rbpurchaseId',rbpurchaseId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbpurchaseEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbpurchaseReLoadList',url,formdata);

}

function WT_rbpurchaseReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var rbpurchaseId=parseInt(d[0]);
	if(d[0]!='Error' && rbpurchaseId>0)
	{
	  os.setVal('rbpurchaseId',rbpurchaseId);
	}

	if(d[1]!=''){alert(d[1]);}
	WT_rbpurchaseListing();
}

function WT_rbpurchaseGetById(rbpurchaseId) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('rbpurchaseId',rbpurchaseId );
	var url='<? echo $ajaxFilePath ?>?WT_rbpurchaseGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbpurchaseFillData',url,formdata);

}

function WT_rbpurchaseFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('rbpurchaseId',parseInt(objJSON.rbpurchaseId));

 os.setVal('refCode',objJSON.refCode);
 os.setVal('rbpurchaseDate',objJSON.rbpurchaseDate);
 os.setVal('rbvenderId',objJSON.rbvenderId);
 os.setVal('orderNo',objJSON.orderNo);
 os.setVal('billNo',objJSON.billNo);
 os.setVal('billSubject',objJSON.billSubject);
 os.setVal('paymentStatus',objJSON.paymentStatus);
 os.setVal('rbemployeeId',objJSON.rbemployeeId);
 os.setVal('productAmount',objJSON.productAmount);
 os.setVal('discountAmount',objJSON.discountAmount);
 os.setVal('discountedPrice',objJSON.discountedPrice);
 os.setVal('taxRate',objJSON.taxRate);
 os.setVal('taxAmount',objJSON.taxAmount);
 os.setVal('paybleAmount',objJSON.paybleAmount);
 os.setVal('paidAmount',objJSON.paidAmount);
 os.setVal('dueAmount',objJSON.dueAmount);
 os.setVal('remarks',objJSON.remarks);

ajaxViewpayments(objJSON.rbpurchaseId);
ajaxViewproduct(objJSON.rbpurchaseId);

}

function WT_rbpurchaseDeleteRowById(rbpurchaseId) // delete record by table id
{
	var formdata = new FormData();
	if(parseInt(rbpurchaseId)<1 || rbpurchaseId==''){
	var  rbpurchaseId =os.getVal('rbpurchaseId');
	}

	if(parseInt(rbpurchaseId)<1){ alert('No record Selected'); return;}

	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

	formdata.append('rbpurchaseId',rbpurchaseId );

	var url='<? echo $ajaxFilePath ?>?WT_rbpurchaseDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbpurchaseDeleteRowByIdResults',url,formdata);
	}


}
function WT_rbpurchaseDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbpurchaseListing();
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbpurchasepagingPageno',parseInt(pageNo));
	WT_rbpurchaseListing();
}

function openPayment()
{

    var rbpurchaseId=os.getVal('rbpurchaseId');
  if(parseInt(rbpurchaseId)<1)
  {
   alert('Please save record');
     return false;
  }

   rb.popUpOpen('quickPaymentPOPUP');

}





function calculatePaybleAndDue()
{

var  productAmount= parseFloat(os.getVal('productAmount'));
var  discountAmount= parseFloat(os.getVal('discountAmount'));
//var  discountedPrice= parseFloat(os.getVal('discountedPrice'));
var  taxRate= parseFloat(os.getVal('taxRate'));
var  taxAmount= parseFloat(os.getVal('taxAmount'));
var  deliveryCharge= parseFloat(os.getVal('deliveryCharge'));
var  installCharge= parseFloat(os.getVal('installCharge'));
//var  paybleAmount= parseFloat(os.getVal('paybleAmount'));
var  paidAmount= parseFloat(os.getVal('paidAmount'));
//var  dueAmount= parseFloat(os.getVal('dueAmount'));



var discountedPriceV=productAmount-discountAmount;
if(taxRate>0){
var taxAmountV=(discountedPriceV*taxRate)/100;
}else{
      taxAmountV=taxAmount;
}

  var  paybleAmountV=discountedPriceV+taxAmount+deliveryCharge+installCharge;
  
  var  dueAmountV=paybleAmountV-paidAmount;

os.setVal('discountedPrice',discountedPriceV);
os.setVal('taxAmount',taxAmountV);
os.setVal('paybleAmount',paybleAmountV);
os.setVal('dueAmount',dueAmountV);


}





function printData(rowId)
   {
     var URLStr='print_rbpbill.php?rowId='+rowId;
      popUpWindow(URLStr, 10, 10, 1100, 600);
   }







</script>
<style>
.readonlyStyle{background-color:#F8F8F8; color:#006595; font-size:14px; font-weight:bold};
</style>





<? include($site['root-wtos'].'bottom.php'); ?>
