<?
/*
   # wtos version : 1.1
   # main ajax process page : rbsbillAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Manage Service Bill';
$ajaxFilePath= 'rbsbillAjax.php';
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
    <td width="303" height="303" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbsbillDeleteRowById('');"  /><? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbsbillEditAndSave();" /><? } ?>
	
	 
	<!--  -->
		<span  class="actionLink" ><a href="javascript:void(0)" style="background-color:#00AE00;"  onclick="openSms()"	>SMS</a></span>

             
                    <div id="quickSMSPOPUP" class="RB_popupBOX" style="display:none; position:fixed; top:100px; left:200px;" >
                            <div class="RBpopoupClose" onclick="rb.popUpClose('quickSMSPOPUP')">X</div>
                       <div class="popoupHead" >SMS Details  </div>
                    <div id="quickPayment" style="margin:10px;" >


                    <? //  include('quickEditPage.php');
                     $options=array();
                     $options['PageHeading']='Service Bill Payments';
                     $options['foreignId']='rbsbillId';
                     $options['foreignTable']='rbsbill';
                     $options['table']='smshistory';
                     $options['tableId']='smshistoryId';
                     $options['tableQuery']="select * from smshistory where [condition] order by smshistoryId ";
                     $options['fields']=array('msgDate'=>'Date','mobileno'=>'mobile no','msg'=>'msg','msgStatus'=>'Status');
                     $options['type']=array('msgDate'=>'D','mobileno'=>'T','msg'=>'T','msgStatus'=>'T');
                     $options['relation']=array('msgDate'=>'','mobileno'=>'','msg'=>'','msgStatus'=>'');
                     $options['class']=array('msgDate'=>'wtDateClass payDate','mobileno'=>'width90','msg'=>'details','msgStatus'=>'width90');  ## add jquery date class
                     $options['extra']=array('msgDate'=>'','mobileno'=>'','msg'=>'','msgStatus'=>'readonly="readonly"'); // add extra onclick="testme()"
                     $options['inlineEdit']=array(); 
                     $options['add']='1'; // 0/1
                     $options['delete']='1'; // 0/1
                     $options['defaultValues']=array('msgStatus'=>'notsend');  //( template id )
                     $options['afterSaveCallback']=array('php'=>'sendAmcSMS','javaScript'=>'setMobNo');
                     $functionId='sms';
                     quickEdit_v_four($options ,0,$functionId);
                     ?>
					 
                     <style>
                       .qaddButton{ font-size:10px; font-weight:bold; background-color:#009900;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                       .qdeleteButton{ font-size:10px; font-weight:bold; background-color:#FF0000;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; line-height:10px;-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                        .wtclass<? echo $functionId?>{margin:0px 5px 0px 0px; padding:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;border:2px groove #FFFFFF;}
                       .wtclass<? echo $functionId?> tr{ height:10px;}
                       .wtclass<? echo $functionId?> td{ height:10px; padding:0px;border-bottom:2px groove #FFFFFF; border-right:2px groove #FFFFFF;}
                       .wtclass<? echo $functionId?> tr:hover{ background-color:#F0F0F0;}
                        .wtclass<? echo $functionId?> .PageHeading{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; background:#007CB9; color:#FFFFFF; padding:2px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; font-style:italic;}
                        .wtalise<? echo $functionId?>{ display:none;}
                       .paymentText{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:120px; }
                       .details{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:220px;}
                       .width90{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:90px; }
                       .formTR{ opacity:0.8;}
                       .formTR:hover{ opacity:1;}
                       .paymentdown{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:0px;-webkit-appearance: none; -moz-appearance: none;  text-indent: 1px; text-overflow: '';}
                       .payDate{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:110px;}
                     </style>
                       <script>
						function openSms()
						{
						
							var rbsbillId=os.getVal('rbsbillId');
						  if(parseInt(rbsbillId)<1)
						  {
						   alert('Please save record');
							 return false;
						  }
						
						   rb.popUpOpen('quickSMSPOPUP');
						
						}
						 function setMobNo(data)
						{
						var callBackOutput=data.split('-CALLBACKOUTPUT-');
                         callBackOutput=callBackOutput[1];
                         if(!callBackOutput){   callBackOutput='';						 }
						 
						 if(callBackOutput!='')
						 {
						 // alert(callBackOutput);
						 var smsdata=callBackOutput.split('-SMS-');
                         smsdata_date=smsdata[1];
						 smsdata_mobNo=smsdata[2];
						 os.setVal('smsmsgDate',smsdata_date);
						  os.setVal('smsmobileno',smsdata_mobNo);
						 
						 
						 
						 }
						 
						 
						datereset();}
                     function datereset()
					 {
					 
					    os.viewCalender('wtDateClass','<? echo $os->dateFormatJs; ?>');
					 }

              function settemplate(o)
					 {
					 
					 //  os.setVal('smsmsg',o.value);
					    os.setVal('smsmsg',o.innerHTML);
					 }
                      </script>
					  <style>
					  .smsTemplate{ border:1px dotted #0066FF; background-color:#E1F0FF; padding:2px; margin:5px 5px 5px 0px; cursor:pointer}
					  </style>
					  <div><br /> <b>Available Templates</b> </div>
					  <? 
					$listTemplate= $os->getTemplateData();
					// $listTemplateArr=array_merge($listTemplate,$listTemplate);
					 foreach($listTemplate as $valssms)
					 {
					  ?>
					  <div onclick="settemplate(this)" class="smsTemplate" ><? echo $valssms ?></div>
					  <? 
					 
					 }
					 
					 ?>
					  
					      
					  
					  
					  
					  </div>

		</div>

	<!--  -->
	
	

	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm" style="background-color:#F9F9F9;">


										
										<tr >
	  									<td>Bill Date </td>
										<td><input value="<? echo $os->now('d-m-Y'); ?>" type="text" name="billDate" id="billDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>Contacts <span id="SAA_C" class="SAA_Container"> </span>
              				 <script>//code333
              				saa.execute('c','SAA_C','rbcontactId','rbcontact','rbcontactId','person,company,phone,email,websiteUrl','Per,Company,Phone,Email,Website','rbcontactId','','');
              				</script></td>
										<td> <select name="rbcontactId" id="rbcontactId" class="textbox fWidth" ><option value="">  </option>		  	<?

										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select> </td>
										</tr><tr >
	  									<td>Bill No </td>
										<td><input value="" type="text" name="billNo" id="billNo" class="textboxxx  fWidth "/> </td>
										</tr><tr >
	  									<td>Bill Subject </td>
										<td><input value="" type="text" name="billSubject" id="billSubject" class="textboxxx  fWidth "/> </td>
										</tr>
										
										<tr>
										<td colspan="2"> 
									View or add products   <span  class="actionLink" ><a href="javascript:void(0)"  onclick="openProducts()"	>Products</a></span>
                                             <!-- gggggg this is for payment calculation  -->
					<div id="quickProductPOPUP" class="RB_popupBOX" style="display:none; width:auto;"  >
					<div class="RBpopoupClose" onclick="rb.popUpClose('quickProductPOPUP')">X</div>
					<div class="popoupHead" >Product Details  </div>
                    <div id="quickProduct" style="margin:10px;" >


                    <? 			
			      //    $os->productsArray= $os->getProductsArray();  	
					  
                     $options=array();
                     $options['PageHeading']='Product Bill Payments';
                     $options['foreignId']='rbsbillId';
                     $options['foreignTable']='rbsbill';
                     $options['table']='rbsbilldetails';
                     $options['tableId']='rbsbilldetailsId';
                     $options['tableQuery']="select * from rbsbilldetails where [condition] order by rbsbilldetailsId ";
                   
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
						 calculatePaybleAndDue();
                      }
					function openProducts()
					{
						
						var rbpurchaseId=os.getVal('rbsbillId');
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
	  									<td>AMC Amount </td>
										<td><input value="" type="text" name="productAmount" id="productAmount" class="textboxxx  fWidth readonlyStyle"  readonly="readonly" /> </td>
										</tr><tr >
	  									<td>Discount Amount </td>
										<td><input value="" type="text" name="discountAmount" id="discountAmount" class="textboxxx  fWidth "  onkeyup="calculatePaybleAndDue()"/> </td>
										</tr><tr >
	  									<td>Discounted Price </td>
										<td><input value="" type="text" name="discountedPrice" id="discountedPrice" class="textboxxx  fWidth   readonlyStyle"  readonly="readonly"/> </td>
										</tr><tr >
	  									<td>Tax @ <input value="14.5" type="text" name="taxRate" id="taxRate" class="textboxxx  fWidth " onkeyup="calculatePaybleAndDue()" style="width:30px" /> % </td>
										<td><input value="" type="text" name="taxAmount" id="taxAmount" class="textboxxx  fWidth readonlyStyle"  readonly="readonly"/> </td>
										</tr><tr style="display:none;" >
	  									<td>Delivery Charge </td>
										<td><input value="" type="text" name="deliveryCharge" id="deliveryCharge" class="textboxxx  fWidth "/> </td>
										</tr><tr style="display:none;" >
	  									<td>Install Charge </td>
										<td><input value="" type="text" name="installCharge" id="installCharge" class="textboxxx  fWidth "/> </td>
										</tr><tr  >
	  									<td><b>Payble Amount</b> </td>
										<td><input value="" type="text" name="paybleAmount" id="paybleAmount" class="textboxxx  fWidth   readonlyStyle" style="width:70px"  readonly="readonly"/> 
										<select name="paymentStatus" id="paymentStatus" class="textbox fWidth" ><?
										  $os->onlyOption($os->paymentStatus);	?></select>	
										</td>
										</tr><tr   >
	  									<td><b>Paid Amount</b></td>
										<td><input value="" type="text" name="paidAmount" id="paidAmount" class="textboxxx  fWidth   readonlyStyle"  readonly="readonly" style="width:70px"/> 
										
										<span  class="actionLink" ><a href="javascript:void(0)"  onclick="openPayment()"	>Payment</a></span>

                    <!-- gggggg this is for payment calculation  -->
                    <div id="quickPaymentPOPUP" class="RB_popupBOX" style="display:none;" >
                            <div class="RBpopoupClose" onclick="rb.popUpClose('quickPaymentPOPUP')">X</div>
                       <div class="popoupHead" >Payment Details  </div>
                    <div id="quickPayment" style="margin:10px;" >


                    <? //  include('quickEditPage.php');
                     $options=array();
                     $options['PageHeading']='Service Bill Payments';
                     $options['foreignId']='rbsbillId';
                     $options['foreignTable']='rbsbill';
                     $options['table']='rbsbillpayment';
                     $options['tableId']='rbsbillpaymentId';
                     $options['tableQuery']="select * from rbsbillpayment where [condition] order by rbsbillpaymentId ";
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
                        .wtclass<? echo $functionId?>{margin:0px 5px 0px 0px; padding:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;border:2px groove #FFFFFF;}
                       .wtclass<? echo $functionId?> tr{ height:10px;}
                       .wtclass<? echo $functionId?> td{ height:10px; padding:0px;border-bottom:2px groove #FFFFFF; border-right:2px groove #FFFFFF;}
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
											   
						function openPayment()
						{
						
							var rbpurchaseId=os.getVal('rbsbillId');
						  if(parseInt(rbpurchaseId)<1)
						  {
						   alert('Please save record');
							 return false;
						  }
						
						   rb.popUpOpen('quickPaymentPOPUP');
						
						}

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
						 calculatePaybleAndDue();
                      }


                      </script></div>

		</div>

										
										</td>
										
 
										</tr><tr   >
	  									<td><b>Due Amount</b> </td>
										<td><input value="" type="text" name="dueAmount" id="dueAmount" class="textboxxx  fWidth  readonlyStyle"  readonly="readonly"/> </td>
										</tr>
										
										
										<tr >
	  									<td>Install Date </td>
										<td><input value="" type="text" name="registerDate" id="registerDate" class="wtDateClass textbox fWidth"/></td>
										</tr><tr >
	  									<td>From Date </td>
										<td><input value="" type="text" name="fromDate" id="fromDate" class="wtDateClass textbox fWidth" /></td>
										</tr><tr >
	  									<td>Expiry Date </td>
										<td><input value="" type="text" name="expiryDate" id="expiryDate" class="wtDateClass textbox fWidth" onchange="calReminderStartDate()"/></td>
										</tr><tr >
	  									<td>Reminder Start </td>
										<td><input value="" type="text" name="reminderStart" id="reminderStart" class="wtDateClass textbox fWidth"/></td>
										</tr>
                                              <tr >
	  									<td>CM PM  </td>
										<td>
										<span  class="actionLink" ><a href="javascript:void(0)"  onclick="openCMPM()"	>CMPM</a></span>

                    <!-- gggggg this is for payment calculation  -->
                    <div id="quickCMPMPOPUP" class="RB_popupBOX" style="display:none;" >
                            <div class="RBpopoupClose" onclick="rb.popUpClose('quickCMPMPOPUP')">X</div>
                       <div class="popoupHead" >CMPM Details  </div>
                    <div id="quickPayment" style="margin:10px;" >


                    <? //  include('quickEditPage.php');
                     $options=array();
                     $options['PageHeading']='CMPM DATA';
                     $options['foreignId']='rbsbillId';
                     $options['foreignTable']='rbsbill';
                     $options['table']='rbcmpm';
                     $options['tableId']='rbcmpmId';
                     $options['tableQuery']="select * from rbcmpm where [condition] order by visitDate desc ";
                     $options['fields']=array('rbemployeeId'=>'Employee','cmpmDate'=>'Date','cmpmStatus'=>'Status','remarks'=>'Remarks');
                     $options['type']=array('rbemployeeId'=>'DD','cmpmDate'=>'D','cmpmStatus'=>'DD','remarks'=>'T');
                     $options['relation']=array('rbemployeeId'=>'select * from rbemployee order by name -fld-rbemployeeId-fld-name,designation','cmpmDate'=>'','cmpmStatus'=>'cmpmStatus','remarks'=>'');
                     $options['class']=array('rbemployeeId'=>'','cmpmDate'=>'wtDateClass payDate','cmpmStatus'=>'','remarks'=>'');  ## add jquery date class
                     $options['extra']=array('rbemployeeId'=>'','cmpmDate'=>'','cmpmStatus'=>'','remarks'=>''); // add extra onclick="testme()"
                     $options['inlineEdit']=array(''=>'');
                     $options['add']='1'; // 0/1
                     $options['delete']='1'; // 0/1
                     $options['defaultValues']=array();
                    // $options['afterSaveCallback']=array('php'=>'calculate reminder date','javaScript'=>'setPaymentTotal');
					  $options['afterSaveCallback']=array('php'=>'','javaScript'=>'setDateCmpm');
                     $functionId='cmpm';
                     quickEdit_v_four($options ,0,$functionId);
                     ?>
                     <style>
                       .qaddButton{ font-size:10px; font-weight:bold; background-color:#009900;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                       .qdeleteButton{ font-size:10px; font-weight:bold; background-color:#FF0000;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; line-height:10px;-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
                        .wtclass<? echo $functionId?>{margin:0px 5px 0px 0px; padding:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;border:2px groove #FFFFFF;}
                       .wtclass<? echo $functionId?> tr{ height:10px;}
                       .wtclass<? echo $functionId?> td{ height:10px; padding:0px;border-bottom:2px groove #FFFFFF; border-right:2px groove #FFFFFF;}
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
											   
						function openCMPM()
						{
						
							var rbpurchaseId=os.getVal('rbsbillId');
						  if(parseInt(rbpurchaseId)<1)
						  {
						   alert('Please save record');
							 return false;
						  }
						
						   rb.popUpOpen('quickCMPMPOPUP');
						
						}

                         function setDateCmpm()
						 {
						    os.viewCalender('wtDateClass','<? echo $os->dateFormatJs; ?>');
						 }


                      </script></div>

		</div>

										
										</td>
										
 
										</tr>
										<tr  >
	  									<td>Order No </td>
										<td><input value="" type="text" name="orderNo" id="orderNo" class="textboxxx  fWidth "/> </td>
										</tr>
										<tr >
	  									<td colspan="2">Remarks <br /><textarea  name="remarks" id="remarks" class="textboxxx fWidth" style="width:256px; height:37px;" ></textarea></td>
										</tr>
										
										
										<tr >
	  									<td>Reminder Status </td>
										<td>

	<select name="reminderStatus" id="reminderStatus" class="textbox fWidth" ><option value=""> </option>	<?
										  $os->onlyOption($os->reminderStatus);	?></select>	 </td>
										</tr>
										<tr >
	  									<td>Employee
                        <span id="SAA_Emp" class="SAA_Container"> </span>
                				 <script>//code333
                				saa.execute('e','SAA_Emp','rbemployeeId','rbemployee','rbemployeeId','name,designation,moble,status','Name,Deg,Mob,Status','rbemployeeId','','');
                        </script>
                      </td>
										<td> <select name="rbemployeeId" id="rbemployeeId" class="textbox fWidth" ><option value=""> </option>		  	<?

										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select> </td>
										</tr>
										
										<tr style="display:none;" >
	  									<td style="width:107px;">Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>
										</tr>
										
										<tr style="display:none" >
	  									<td>Prior Days </td>
										<td><input value="30" type="text" name="priorDays" id="priorDays" class="textboxxx  fWidth " onchange="calReminderStartDate()"/> </td>
										</tr>
										
										<tr style="display:none" >
	  									<td>Frequency </td>
										<td>

	<select name="frequency" id="frequency" class="textbox fWidth" ><option value="Yearly">Yearly </option>	<?
										  $os->onlyOption($os->frequency);	?></select>	 </td>
										</tr>

	</table>


	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
	<input type="hidden"  id="rbsbillId" value="0" />
	<input type="hidden"  id="WT_rbsbillpagingPageno" value="1" />
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbsbillDeleteRowById('');" />	<? } ?>
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbsbillEditAndSave();" /><? } ?>
	</div>
	</div>



	</td>
    <td valign="top" class="ajaxViewMainTableTDList">

	<div class="ajaxViewMainTableTDListSearch">
	Search Key
  <input type="text" id="searchKey" />   &nbsp;
Reminder Status:

	<select name="reminderStatus" id="reminderStatus_s" class="textbox fWidth" ><option value=""> </option>	<?
										  $os->onlyOption($os->reminderStatus);	?></select>



  <div style="display:none" id="advanceSearchDiv">

 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp; From Bill Date: <input class="wtDateClass" type="text" name="f_billDate_s" id="f_billDate_s" value=""  /> &nbsp;   To Bill Date: <input class="wtDateClass" type="text" name="t_billDate_s" id="t_billDate_s" value=""  /> &nbsp;
   Contacts:


	<select name="rbcontactId" id="rbcontactId_s" class="textbox fWidth" ><option value="">Select Contacts</option>		  	<?

										  // $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select>
   Order No: <input type="text" class="wtTextClass" name="orderNo_s" id="orderNo_s" value="" /> &nbsp;  Bill No: <input type="text" class="wtTextClass" name="billNo_s" id="billNo_s" value="" /> &nbsp;  Bill Subject: <input type="text" class="wtTextClass" name="billSubject_s" id="billSubject_s" value="" /> &nbsp;  Payment Status:

	<select name="paymentStatus" id="paymentStatus_s" class="textbox fWidth" ><option value="">Select Payment Status</option>	<?
										  $os->onlyOption($os->paymentStatus);	?></select>
   Employee:


	<select name="rbemployeeId" id="rbemployeeId_s" class="textbox fWidth" ><option value="">Select Employee</option>		  	<?

										  $os->optionsHTML('','rbemployeeId','name','rbemployee');?>
							</select>
   Payble Amount: <input type="text" class="wtTextClass" name="paybleAmount_s" id="paybleAmount_s" value="" /> &nbsp; From Register Date: <input class="wtDateClass" type="text" name="f_registerDate_s" id="f_registerDate_s" value=""  /> &nbsp;   To Register Date: <input class="wtDateClass" type="text" name="t_registerDate_s" id="t_registerDate_s" value=""  /> &nbsp;
  From Expiry Date: <input class="wtDateClass" type="text" name="f_expiryDate_s" id="f_expiryDate_s" value=""  /> &nbsp;   To Expiry Date: <input class="wtDateClass" type="text" name="t_expiryDate_s" id="t_expiryDate_s" value=""  /> &nbsp;
   Reminder Status:

	<select name="reminderStatus" id="reminderStatus_s" class="textbox fWidth" ><option value="">Select Reminder Status</option>	<?
										  $os->onlyOption($os->reminderStatus);	?></select>

  </div>


  <input type="button" value="Search" onclick="WT_rbsbillListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
  <input type="button" value="Refresh" onclick="WT_rbsbillListing();" style="cursor:pointer;"/>

   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbsbillListDiv">
	<? include('quickListing.php'); 
	$listingQuery="  select * from rbsbill order by rbsbillId desc";
	sbill($listingQuery);
	?> 	
	
	 </div>
	&nbsp;</td>
  </tr>
</table>



			  <!--   ggggggggggggggg  -->

			  </td>
			  </tr>
			</table>



<script>

function WT_rbsbillListing() // list table searched data get
{
	var formdata = new FormData();


 var refCode_sVal= os.getVal('refCode_s');
 var f_billDate_sVal= os.getVal('f_billDate_s');
 var t_billDate_sVal= os.getVal('t_billDate_s');
 var rbcontactId_sVal= os.getVal('rbcontactId_s');
 var orderNo_sVal= os.getVal('orderNo_s');
 var billNo_sVal= os.getVal('billNo_s');
 var billSubject_sVal= os.getVal('billSubject_s');
 var paymentStatus_sVal= os.getVal('paymentStatus_s');
 var rbemployeeId_sVal= os.getVal('rbemployeeId_s');
 var paybleAmount_sVal= os.getVal('paybleAmount_s');
 var f_registerDate_sVal= os.getVal('f_registerDate_s');
 var t_registerDate_sVal= os.getVal('t_registerDate_s');
 var f_expiryDate_sVal= os.getVal('f_expiryDate_s');
 var t_expiryDate_sVal= os.getVal('t_expiryDate_s');
 var reminderStatus_sVal= os.getVal('reminderStatus_s');
formdata.append('refCode_s',refCode_sVal );
formdata.append('f_billDate_s',f_billDate_sVal );
formdata.append('t_billDate_s',t_billDate_sVal );
formdata.append('rbcontactId_s',rbcontactId_sVal );
formdata.append('orderNo_s',orderNo_sVal );
formdata.append('billNo_s',billNo_sVal );
formdata.append('billSubject_s',billSubject_sVal );
formdata.append('paymentStatus_s',paymentStatus_sVal );
formdata.append('rbemployeeId_s',rbemployeeId_sVal );
formdata.append('paybleAmount_s',paybleAmount_sVal );
formdata.append('f_registerDate_s',f_registerDate_sVal );
formdata.append('t_registerDate_s',t_registerDate_sVal );
formdata.append('f_expiryDate_s',f_expiryDate_sVal );
formdata.append('t_expiryDate_s',t_expiryDate_sVal );
formdata.append('reminderStatus_s',reminderStatus_sVal );



	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbsbillpagingPageno=os.getVal('WT_rbsbillpagingPageno');
	var url='wtpage='+WT_rbsbillpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbsbillListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxHtml('WT_rbsbillListDiv',url,formdata);

}

WT_rbsbillListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s','');
 os.setVal('f_billDate_s','');
 os.setVal('t_billDate_s','');
 os.setVal('rbcontactId_s','');
 os.setVal('orderNo_s','');
 os.setVal('billNo_s','');
 os.setVal('billSubject_s','');
 os.setVal('paymentStatus_s','');
 os.setVal('rbemployeeId_s','');
 os.setVal('paybleAmount_s','');
 os.setVal('f_registerDate_s','');
 os.setVal('t_registerDate_s','');
 os.setVal('f_expiryDate_s','');
 os.setVal('t_expiryDate_s','');
 os.setVal('reminderStatus_s','');

		os.setVal('searchKey','');
		WT_rbsbillListing();

	}


function WT_rbsbillEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode');
var billDateVal= os.getVal('billDate');
var rbcontactIdVal= os.getVal('rbcontactId');
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
 formdata.append('billDate',billDateVal );
 formdata.append('rbcontactId',rbcontactIdVal );
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


//if(os.check.empty('refCode','Please Add Reffer Code')==false){ return false;}
if(os.check.empty('billDate','Please Add Bill Date')==false){ return false;}
if(os.check.empty('rbcontactId','Please Add Contacts')==false){ return false;}
//if(os.check.empty('orderNo','Please Add Order No')==false){ return false;}
if(os.check.empty('billNo','Please Add Bill No')==false){ return false;}
//if(os.check.empty('billSubject','Please Add Bill Subject')==false){ return false;}
if(os.check.empty('paymentStatus','Please Add Payment Status')==false){ return false;}
//if(os.check.empty('rbemployeeId','Please Add Employee')==false){ return false;}
if(os.check.empty('paybleAmount','Please Add Payble Amount')==false){ return false;}
if(os.check.empty('fromDate','Please Add From Date')==false){ return false;}
if(os.check.empty('expiryDate','Please Add Expiry Date')==false){ return false;}
if(os.check.empty('priorDays','Please Add Prior Days')==false){ return false;}
//if(os.check.empty('reminderStart','Please Add Reminder Start')==false){ return false;}
//if(os.check.empty('reminderStatus','Please Add Reminder Status')==false){ return false;}

	 var   rbsbillId=os.getVal('rbsbillId');
	 formdata.append('rbsbillId',rbsbillId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbsbillEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbsbillReLoadList',url,formdata);

}

function WT_rbsbillReLoadList(data) // after edit reload list
{

	var d=data.split('#-#');
	var rbsbillId=parseInt(d[0]);
	if(d[0]!='Error' && rbsbillId>0)
	{
	  os.setVal('rbsbillId',rbsbillId);
	}

	if(d[1]!=''){alert(d[1]);}
	WT_rbsbillListing();
}

function WT_rbsbillGetById(rbsbillId) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('rbsbillId',rbsbillId );
	var url='<? echo $ajaxFilePath ?>?WT_rbsbillGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbsbillFillData',url,formdata);

}

function WT_rbsbillFillData(data)  // fill data form by JSON
{

	var objJSON = JSON.parse(data);
	os.setVal('rbsbillId',parseInt(objJSON.rbsbillId));

 os.setVal('refCode',objJSON.refCode);
 os.setVal('billDate',objJSON.billDate);
 os.setVal('rbcontactId',objJSON.rbcontactId);
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


ajaxViewpayments(objJSON.rbsbillId);
ajaxViewproduct(objJSON.rbsbillId);
ajaxViewcmpm(objJSON.rbsbillId);
ajaxViewsms(objJSON.rbsbillId);

}

function WT_rbsbillDeleteRowById(rbsbillId) // delete record by table id
{
	var formdata = new FormData();
	if(parseInt(rbsbillId)<1 || rbsbillId==''){
	var  rbsbillId =os.getVal('rbsbillId');
	}

	if(parseInt(rbsbillId)<1){ alert('No record Selected'); return;}

	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

	formdata.append('rbsbillId',rbsbillId );

	var url='<? echo $ajaxFilePath ?>?WT_rbsbillDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('WT_rbsbillDeleteRowByIdResults',url,formdata);
	}


}
function WT_rbsbillDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbsbillListing();
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbsbillpagingPageno',parseInt(pageNo));
	WT_rbsbillListing();
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
     var URLStr='print_rbsbill.php?rowId='+rowId;
      popUpWindow(URLStr, 10, 10, 1100, 600);
   }




 
function calReminderStartDate()
{
    var reminderStartDateVal='';
	var expDate = os.getVal('expiryDate');
	var priorDays = os.getVal('priorDays');
	
	if(expDate==''){ alert("Please put Eexpiry Date"); return false;}
	if (isNaN(priorDays) || priorDays < 1 ) {
        	alert("Input not valid Number");
			return false;
    	}
		
		var todayStr=expDate;
		
		expDate = expDate.split('-').reverse().join('-');
		var today = new Date(expDate);
		today.setDate(today.getDate()-priorDays);

		var dd=today.getDate();
		var mm=today.getMonth()+1; 
		var yyyy=today.getFullYear();	
		
		var todayStr =os.formattedDate(dd,mm,yyyy);
        reminderStartDateVal=todayStr;
	    os.setVal('reminderStart',reminderStartDateVal);
}


</script>
<style>
.readonlyStyle{background-color:#F8F8F8; color:#006595; font-size:14px; font-weight:bold; width:100px;};
			
.reminderStatusClose{ background-color:#BDBDDF;}
.reminderStatusNC{ background-color:#FFDFDF; }
</style>
 
 <style>

@-webkit-keyframes blinker {
  from {opacity: 1.0;}
  to {opacity: 0.0;}
}
.blink{
	text-decoration: blink;
	-webkit-animation-name: blinker;
	-webkit-animation-duration: 0.6s;
	-webkit-animation-iteration-count:infinite;
	-webkit-animation-timing-function:ease-in-out;
	-webkit-animation-direction: alternate;
}
.msghover tr:hover{ background-color:#00F200;}
</style>



<? include($site['root-wtos'].'bottom.php'); ?>
