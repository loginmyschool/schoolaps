<?
/*
   # wtos version : 1.1
   # main ajax process page : rbreminderAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Reminder';
$ajaxFilePath= 'rbreminderAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

 include('rbListAndAssign.php');
 include('wtosSearchAddAssign.php')
?>
  
 <style>
 .RbHints{ font-size:10px; font-style:italic; color:#000099;}
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
</style>
 <table class="container" cellspacing="0" cellpadding="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="350" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbreminderDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbreminderEditAndSave();" /><? } ?>	 
	
	
	<input type="button" class="" id="PrintButton" value="Print"  style="cursor:pointer;display:none;" onclick="printRBReceiptButton()" />
	<input type="button" class="" id="getreminderButton" value="View All"  style="cursor:pointer;display:none;" onclick="rb.popUpOpenAndGetData('rbAllByCustomerContainer')" />
	<span id="rbAllByCustomerContainer" class="SAA_Container" style="display:none;">
	
	</span>
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 									
		<tr >
				<td>ID <br /><span class="RbHints">user id or nick name or mobile</span></td>
			<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>						
		</tr>

								
		





 <tr  >
			<td>Date<span class="RbHints"> Date Of Bill</span> </td>
		<td><input value="" type="text" name="bvDate" id="bvDate" class="wtDateClass textbox fWidth"  style="width: 80px;"/> </td>						
		</tr>
		
	 <tr   >
			<td>Document No <br /> <span class="RbHints"> Invoice/Bill/VouchureOf Bill</span></span> </td>
		<td><input value="" type="text" name="bvNo" id="bvNo" class="textboxxx  fWidth "/> </td>						
		</tr>

		<tr >
				<td>Contacts <span id="SAA_m" class="SAA_Container"> </span>
				 <script>//code333
				saa.execute('m','SAA_m','rbcontactId','rbcontact','rbcontactId','person,refCode,phone,email','P,Ref,Phone,Email','rbcontactId','','');
				</script> 
				
				
				</td>
			<td> <select name="rbcontactId" id="rbcontactId" class="textbox fWidth" ><option value=""> </option>		  	<? $os->optionsHTML('','rbcontactId','person','rbcontact');?>
				</select>
				
			</td>						
		</tr>
		<!-- importent reminder fields end -->

		
		<tr >
			<td>Amount </td>
		<td><input value="" type="text" name="amount" id="amount" class="textboxxx  fWidth " onkeyup="calcPercentageValue()" style="width: 70px"/> <select    name="inOutStatus" id="inOutStatus" class="textbox fWidth"  ><option></option>	<? 
		  $os->onlyOption($os->inOutStatus);	?></select>	 </td>						
		</tr>
		<tr style="display:none;" >
			<td>Service Tax </td>
		<td><input value="" type="text" name="taxAmount" id="taxAmount" class="textboxxx  fWidth " style="width:50px;"/> @<input value="0" type="text" name="taxPercent" id="taxPercent" class="textboxxx  fWidth " style="width:30px;" onkeyup="calcPercentageValue()"/>% </td>						
		</tr>
		
		<tr style="display:none;" >
			<td>Arrear Amount </td>
		<td><input value="" type="text" name="arrearAmount" id="arrearAmount" class="textboxxx  fWidth "  style="width: 70px"/> </td>						
		</tr><tr >
			<td>Total Payable Amount </td>
		<td><input value="" type="text" name="totalPayableAmount" id="totalPayableAmount" class="textboxxx  fWidth "  style="width: 70px"/> </td>						
		</tr><tr >
			<td>Total Paid </td>
		<td><input value="" type="text" name="totalPaid" id="totalPaid" class="textboxxx  fWidth "  style="width: 70px"/><span  class="actionLink" ><a href="javascript:void(0)"  onclick="openPayment()"	>Payment</a></span>
		
		
		 
		<div id="quickPaymentPOPUP" class="RB_popupBOX" style="display:none;"  >	 
            <div class="RBpopoupClose" onclick="rb.popUpClose('quickPaymentPOPUP')">X</div>
			 <div class="popoupHead" >Payment Details  </div>
		<div id="quickPayment" style="margin:10px;">
		
 
	<? 

 include('quickEditPage.php');
$options=array();
$options['PageHeading']='Payments';  
$options['foreignId']='rbreminderId'; 
$options['foreignTable']='rbreminder';
$options['table']='rbpayment';
$options['tableId']='rbpaymentId';
$options['tableQuery']="select * from rbpayment where [condition] order by rbpaymentId "; 
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
		os.setVal('totalPaid',totalVal);
		os.viewCalender('wtDateClass','<? echo $os->dateFormatJs; ?>');	 
		setDueAmount();
 }
 
 
 </script>


  </div>
		
		</div>
		
		 </td>						
		</tr><tr > 
			<td>Due Amount </td>
		<td><input value="" type="text" name="dueAmount" id="dueAmount" class="textboxxx  fWidth "  style="width: 70px"/> </td>						
		</tr><tr >
			<td>Payment Status </td>
		<td>  

		  <select name="paymentStatus" id="paymentStatus" class="textbox fWidth" style="width: 80px" >	<? 
		  $os->onlyOption($os->payStatus);	?></select>	 </td>						
		</tr>
		
		<tr >
			<td>Products 
			<span id="SAA_prod" class="SAA_Container"> </span>
			<!--  code111 -->
				<script> // code111
				 saa.execute('p','SAA_prod','rbproductId','rbproduct','rbproductId','name,refCode,productCode','n,Ref,Phone','rbproductId','','');
				</script> 	
				
				
			</td>
		<td> 
			<select name="rbproductId" id="rbproductId" class="textbox fWidth" >
				<option value=""> </option>		  	
				<?  $os->optionsHTML('','rbproductId','name','rbproduct');?>
			</select> 
		</td>						
		</tr>

		<tr >
				<td>Services </td>
			<td> 
				<select name="rbserviceId" id="rbserviceId" class="textbox fWidth" >
					<option value=""> </option>		  	
					<? $os->optionsHTML('','rbserviceId','name','rbservice');?>
				</select>
			</td>						
		</tr>

    <tr  >
			<td>Subject <br /><span class="RbHints"> Sub. Of Bill,voucher</span></td>
		<td><input value="" type="text" name="bvSubject" id="bvSubject" class="textboxxx  fWidth "/> </td>						
		</tr>


	
		
		
		
		
		
		
		<tr >
				<td>Remarks </td>
			<td> <!--<input value="" type="text" class="textboxxx  fWidth "/> -->
			
			
			 <textarea  name="remarks" id="remarks" style="width:150px; height:50px" > </textarea>
			
			
			
			
			
			
			</td>						
		</tr>

		<!-- not needed for this client -->
	
		<tr style="display: none;">
			<td>Url </td>
		<td><input value="" type="text" name="url" id="url" class="textboxxx  fWidth "/> </td>						
		</tr>

		<tr style="display: none;">
			<td>Docket No </td>
		<td><input value="" type="text" name="docketNo" id="docketNo" class="textboxxx  fWidth "/> </td>						
		</tr>

		<tr style="display: none;">
			<td>Doucument1 </td>
			<td>
				<img id="doucument1Preview" src="" height="100" style="display:none;"	 />		
				<input type="file" name="doucument1" value=""  id="doucument1" onchange="os.readURL(this,'doucument1Preview') " style="display:none;"/><br>
				<span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('doucument1');">Upload Doucument1</span>
			</td>						
		</tr>

		<tr style="display: none;">
				<td>Document2 </td>
			<td>
			
			<img id="document2Preview" src="" height="100" style="display:none;"	 />		
			<input type="file" name="document2" value=""  id="document2" onchange="os.readURL(this,'document2Preview') " style="display:none;"/><br>
			 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('document2');">Upload Doucument1</span>
			</td>						
		</tr>

	
<tr >
				<td>Frequency <br /><span class="RbHints">Next Reminder Interval</span> </td>
			<td>  
			  <select name="frequency" id="frequency" class="textbox fWidth" style="width: 87px" >
			  <? $os->onlyOption($os->frequency);	?></select> 	 
			</td>						
		</tr>

    <tr >
				<td>Register Date <br /></td>
			<td><input value="" type="text" name="registerDate" id="registerDate" class="wtDateClass textbox fWidth"  style="width: 80px;"  onchange="setDatesAutomatic()"/> </td>						
		</tr>
<tr >
<td>From Date </td>
			<td><input value="" type="text" name="fromDate" id="fromDate" class="wtDateClass textbox fWidth" onkeyup="setDatesAutomatic()"  style="width: 80px;"/><span class="RbHints">DD-MM-YYYY</span></td>
		</tr>

		 
		
		<tr >
				<td>Expiry Date <br /></td>
			<td><input value="" type="text" name="expiryDate" id="expiryDate" class="wtDateClass textbox fWidth" onchange="calReminderStartDate()" style="width: 80px;"/><span class="RbHints">DD-MM-YYYY</span></td>
		</tr>

		<tr >
				<td>Prior Days <br /><span class="RbHints">Alert start date Interval</span></td>
			<td><input value="5" type="text" name="priorDays" id="priorDays" class="textboxxx  fWidth " onkeyup="calReminderStartDate()" style="width: 30px;" /> Days </td>						
		</tr>

		<tr >
				<td>Reminder Start Date </td>
			<td><input value="" type="text" name="reminderStartDate" id="reminderStartDate" class="wtDateClass textbox fWidth" style="width: 80px;"/><span class="RbHints">DD-MM-YYYY</span></td>						
		</tr>

		

  <tr >
				<td>Reminder Status </td>
			<td>  
			<select name="reminderStatus" id="reminderStatus" class="textbox fWidth" style="width: 80px" >
				<? $os->onlyOption($os->remindStatus);	?>
			 </select>	 
			</td>						
		</tr>



		<tr style="display:none;" >

			<td>Reminder Type </td>
			<td>  
				<select name="reminderType" id="reminderType" class="textbox fWidth" onchange="shoManualinputButton()" >	
				<? $os->onlyOption($os->remindType);	?>
				</select>
				 
			</td>						
		</tr>
 
		

		

		<tr style="display:none;" >
				<td>Ip Address </td>
			<td><input value="" type="text" name="ipAddress" id="ipAddress" class="textboxxx  fWidth "/> </td>						
		</tr>

		 								
	</table>
	
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbreminderId" value="0" />	
	<input type="hidden"  id="WT_rbreminderpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbreminderDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbreminderEditAndSave();" /><? } ?>	
	</div> 
	</div>	

	<!-- Manual Reminder set ggggggggg   -->

	
	
	 
	
	</td>



    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
       &nbsp;  Payment:
	
	<select name="paymentStatus" id="paymentStatus_s" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->payStatus);	?></select>	
	  
	  Reminder:
	
	<select name="reminderStatus" id="reminderStatus_s" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->remindStatus);	?></select>	
										  &nbsp;  &nbsp;
										   Contacts: 
	
	
	<select name="rbcontactId" id="rbcontactId_s" class="textbox fWidth" ><option value=""> </option>		  	<? 
								
										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select><span id="SAA_n" class="SAA_Container"> </span>
							
							<!-- code222-->
				<script> // code222
				saa.execute('n','SAA_n','rbcontactId_s','rbcontact','rbcontactId','person,refCode,phone,email','P,Ref,Phone,Email','rbcontactId','','');
				</script> 
							
  <div style="display:none" id="advanceSearchDiv">
       Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp;&nbsp;  
 Contacts:
	
	
	<select name="rbcontactId" id="rbcontactId_s" class="textbox fWidth" ><option value="">Select Contacts</option>		  	<? 
								
										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select>
   Reminder Type:
	
	<select name="reminderType" id="reminderType_s" class="textbox fWidth" ><option value="">Select Reminder Type</option>	<? 
										  $os->onlyOption($os->remindType);	?></select>	
   Frequency:
	
	<select name="frequency" id="frequency_s" class="textbox fWidth" ><option value="">Select Frequency</option>	<? 
										  $os->onlyOption($os->frequency);	?></select>	
   Prior Days: <input type="text" class="wtTextClass" name="priorDays_s" id="priorDays_s" value="" /> &nbsp; From Exp Date: <input class="wtDateClass" type="text" name="f_expiryDate_s" id="f_expiryDate_s" value=""  /> &nbsp;   To Exp Date: <input class="wtDateClass" type="text" name="t_expiryDate_s" id="t_expiryDate_s" value=""  /> &nbsp;  
  From Reminder Start Date: <input class="wtDateClass" type="text" name="f_reminderStartDate_s" id="f_reminderStartDate_s" value=""  /> &nbsp;   To Reminder Start Date: <input class="wtDateClass" type="text" name="t_reminderStartDate_s" id="t_reminderStartDate_s" value=""  /> &nbsp;  
   Amount: <input type="text" class="wtTextClass" name="amount_s" id="amount_s" value="" /> &nbsp;  Arrear Amount: <input type="text" class="wtTextClass" name="arrearAmount_s" id="arrearAmount_s" value="" /> &nbsp;  Total Payable Amount: <input type="text" class="wtTextClass" name="totalPayableAmount_s" id="totalPayableAmount_s" value="" /> &nbsp;  Total Paid: <input type="text" class="wtTextClass" name="totalPaid_s" id="totalPaid_s" value="" /> &nbsp;  Due Amount: <input type="text" class="wtTextClass" name="dueAmount_s" id="dueAmount_s" value="" /> 
  
   Docket No: <input type="text" class="wtTextClass" name="docketNo_s" id="docketNo_s" value="" /> &nbsp;  Url: <input type="text" class="wtTextClass" name="url_s" id="url_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;   Products:
	
	
	<select name="rbproductId" id="rbproductId_s" class="textbox fWidth" ><option value="">Select Products</option>		  	<? 
								
										  $os->optionsHTML('','rbproductId','name','rbproduct');?>
							</select>
   Services:
	
	
	<select name="rbserviceId" id="rbserviceId_s" class="textbox fWidth" ><option value="">Select Services</option>		  	<? 
								
										  $os->optionsHTML('','rbserviceId','name','rbservice');?>
							</select>
   Ip Address: <input type="text" class="wtTextClass" name="ipAddress_s" id="ipAddress_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbreminderListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbreminderListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbreminderListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var rbcontactId_sVal= os.getVal('rbcontactId_s'); 
 var refCode_sVal= os.getVal('refCode_s'); 
 var reminderType_sVal= os.getVal('reminderType_s'); 
 var frequency_sVal= os.getVal('frequency_s'); 
 var priorDays_sVal= os.getVal('priorDays_s'); 
 var f_expiryDate_sVal= os.getVal('f_expiryDate_s'); 
 var t_expiryDate_sVal= os.getVal('t_expiryDate_s'); 
 var f_reminderStartDate_sVal= os.getVal('f_reminderStartDate_s'); 
 var t_reminderStartDate_sVal= os.getVal('t_reminderStartDate_s'); 
 var amount_sVal= os.getVal('amount_s'); 
 var arrearAmount_sVal= os.getVal('arrearAmount_s'); 
 var totalPayableAmount_sVal= os.getVal('totalPayableAmount_s'); 
 var totalPaid_sVal= os.getVal('totalPaid_s'); 
 var dueAmount_sVal= os.getVal('dueAmount_s'); 
 var paymentStatus_sVal= os.getVal('paymentStatus_s'); 
 var reminderStatus_sVal= os.getVal('reminderStatus_s'); 
 var docketNo_sVal= os.getVal('docketNo_s'); 
 var url_sVal= os.getVal('url_s'); 
 var remarks_sVal= os.getVal('remarks_s'); 
 var rbproductId_sVal= os.getVal('rbproductId_s'); 
 var rbserviceId_sVal= os.getVal('rbserviceId_s'); 
 var ipAddress_sVal= os.getVal('ipAddress_s'); 
formdata.append('rbcontactId_s',rbcontactId_sVal );
formdata.append('refCode_s',refCode_sVal );
formdata.append('reminderType_s',reminderType_sVal );
formdata.append('frequency_s',frequency_sVal );
formdata.append('priorDays_s',priorDays_sVal );
formdata.append('f_expiryDate_s',f_expiryDate_sVal );
formdata.append('t_expiryDate_s',t_expiryDate_sVal );
formdata.append('f_reminderStartDate_s',f_reminderStartDate_sVal );
formdata.append('t_reminderStartDate_s',t_reminderStartDate_sVal );
formdata.append('amount_s',amount_sVal );
formdata.append('arrearAmount_s',arrearAmount_sVal );
formdata.append('totalPayableAmount_s',totalPayableAmount_sVal );
formdata.append('totalPaid_s',totalPaid_sVal );
formdata.append('dueAmount_s',dueAmount_sVal );
formdata.append('paymentStatus_s',paymentStatus_sVal );
formdata.append('reminderStatus_s',reminderStatus_sVal );
formdata.append('docketNo_s',docketNo_sVal );
formdata.append('url_s',url_sVal );
formdata.append('remarks_s',remarks_sVal );
formdata.append('rbproductId_s',rbproductId_sVal );
formdata.append('rbserviceId_s',rbserviceId_sVal );
formdata.append('ipAddress_s',ipAddress_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbreminderpagingPageno=os.getVal('WT_rbreminderpagingPageno');
	var url='wtpage='+WT_rbreminderpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbreminderListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbreminderListDiv',url,formdata);
	

 	
}




WT_rbreminderListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('rbcontactId_s',''); 
 os.setVal('refCode_s',''); 
 os.setVal('reminderType_s',''); 
 os.setVal('frequency_s',''); 
 os.setVal('priorDays_s',''); 
 os.setVal('f_expiryDate_s',''); 
 os.setVal('t_expiryDate_s',''); 
 os.setVal('f_reminderStartDate_s',''); 
 os.setVal('t_reminderStartDate_s',''); 
 os.setVal('amount_s',''); 
 os.setVal('arrearAmount_s',''); 
 os.setVal('totalPayableAmount_s',''); 
 os.setVal('totalPaid_s',''); 
 os.setVal('dueAmount_s',''); 
 os.setVal('paymentStatus_s',''); 
 os.setVal('reminderStatus_s',''); 
 os.setVal('docketNo_s',''); 
 os.setVal('url_s',''); 
 os.setVal('remarks_s',''); 
 os.setVal('rbproductId_s',''); 
 os.setVal('rbserviceId_s',''); 
 os.setVal('ipAddress_s',''); 
	
		os.setVal('searchKey','');
		WT_rbreminderListing();	
	
	}
	
 
function WT_rbreminderEditAndSave()  // collect data and send to save
{
        
var formdata = new FormData();

var rbcontactIdVal= os.getVal('rbcontactId'); 
var refCodeVal= os.getVal('refCode'); 
var reminderTypeVal= os.getVal('reminderType'); 
var frequencyVal= os.getVal('frequency'); 
var priorDaysVal= os.getVal('priorDays'); 
var expiryDateVal= os.getVal('expiryDate'); 
var reminderStartDateVal= os.getVal('reminderStartDate'); 
var amountVal= os.getVal('amount'); 
var arrearAmountVal= os.getVal('arrearAmount'); 
var totalPayableAmountVal= os.getVal('totalPayableAmount'); 
var totalPaidVal= os.getVal('totalPaid'); 
var dueAmountVal= os.getVal('dueAmount'); 
var paymentStatusVal= os.getVal('paymentStatus'); 
var reminderStatusVal= os.getVal('reminderStatus'); 
var docketNoVal= os.getVal('docketNo'); 
var urlVal= os.getVal('url'); 
var remarksVal= os.getVal('remarks'); 
var doucument1Val= os.getObj('doucument1').files[0]; 
// var doucument2Val= os.getObj('doucument2').files[0]; 
var rbproductIdVal= os.getVal('rbproductId'); 
var rbserviceIdVal= os.getVal('rbserviceId'); 
var ipAddressVal= os.getVal('ipAddress'); 

//added later 
var taxAmountVal= os.getVal('taxAmount'); 
var taxPercentVal= os.getVal('taxPercent'); 
 
var registerDateVal= os.getVal('registerDate');	
var fromDateVal= os.getVal('fromDate');	
var inOutStatusVal= os.getVal('inOutStatus');	
var bvSubjectVal= os.getVal('bvSubject');	
var bvDateVal= os.getVal('bvDate');	
var bvNoVal= os.getVal('bvNo');		
  	
 formdata.append('rbcontactId',rbcontactIdVal );
 formdata.append('refCode',refCodeVal );
 formdata.append('reminderType',reminderTypeVal );
 formdata.append('frequency',frequencyVal );
 formdata.append('priorDays',priorDaysVal );
 formdata.append('expiryDate',expiryDateVal );
 formdata.append('reminderStartDate',reminderStartDateVal );
 formdata.append('amount',amountVal );
 formdata.append('arrearAmount',arrearAmountVal );
 formdata.append('totalPayableAmount',totalPayableAmountVal );
 formdata.append('totalPaid',totalPaidVal );
 formdata.append('dueAmount',dueAmountVal );
 formdata.append('paymentStatus',paymentStatusVal );
 formdata.append('reminderStatus',reminderStatusVal );
 formdata.append('docketNo',docketNoVal );
 formdata.append('url',urlVal );
 formdata.append('remarks',remarksVal );
if(doucument1Val){  formdata.append('doucument1',doucument1Val,doucument1Val.name );}
// if(doucument2Val){  formdata.append('doucument2',doucument2Val,doucument2Val.name );}
 formdata.append('rbproductId',rbproductIdVal );
 formdata.append('rbserviceId',rbserviceIdVal );
 formdata.append('ipAddress',ipAddressVal );
 
 formdata.append('taxAmount',taxAmountVal );
 formdata.append('taxPercent',taxPercentVal );

	formdata.append('registerDate',registerDateVal );
	formdata.append('fromDate',fromDateVal );
	formdata.append('inOutStatus',inOutStatusVal );
	formdata.append('bvSubject',bvSubjectVal );
	formdata.append('bvDate',bvDateVal );
	formdata.append('bvNo',bvNoVal );	
	

	
	 var   rbreminderId=os.getVal('rbreminderId');
	 formdata.append('rbreminderId',rbreminderId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbreminderEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbreminderReLoadList',url,formdata);

}	

function WT_rbreminderReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbreminderId=parseInt(d[0]);
	if(d[0]!='Error' && rbreminderId>0)
	{
	  os.setVal('rbreminderId',rbreminderId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbreminderListing();
}

function WT_rbreminderGetById(rbreminderId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbreminderId',rbreminderId );
	var url='<? echo $ajaxFilePath ?>?WT_rbreminderGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbreminderFillData',url,formdata);
				
}

function WT_rbreminderFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbreminderId',parseInt(objJSON.rbreminderId));
	
 os.setVal('rbcontactId',objJSON.rbcontactId); 
 os.setVal('refCode',objJSON.refCode); 
 os.setVal('reminderType',objJSON.reminderType); 
 os.setVal('frequency',objJSON.frequency); 
 os.setVal('priorDays',objJSON.priorDays); 
 os.setVal('expiryDate',objJSON.expiryDate); 
 os.setVal('reminderStartDate',objJSON.reminderStartDate); 
 os.setVal('amount',objJSON.amount); 
 os.setVal('arrearAmount',objJSON.arrearAmount); 
 os.setVal('totalPayableAmount',objJSON.totalPayableAmount); 
 os.setVal('totalPaid',objJSON.totalPaid); 
 os.setVal('dueAmount',objJSON.dueAmount); 
 os.setVal('paymentStatus',objJSON.paymentStatus); 
 os.setVal('reminderStatus',objJSON.reminderStatus); 
 os.setVal('docketNo',objJSON.docketNo); 
 os.setVal('url',objJSON.url); 
 os.setVal('remarks',objJSON.remarks); 
 os.setImg('doucument1Preview',objJSON.doucument1);
 os.setImg('document2Preview',objJSON.document2); 
 os.setVal('rbproductId',objJSON.rbproductId); 
 os.setVal('rbserviceId',objJSON.rbserviceId); 
 os.setVal('ipAddress',objJSON.ipAddress);
 os.setVal('taxAmount',objJSON.taxAmount);
 os.setVal('taxPercent',objJSON.taxPercent);
 
 os.setVal('registerDate',objJSON.registerDate);
 os.setVal('fromDate',objJSON.fromDate);
 os.setVal('inOutStatus',objJSON.inOutStatus);
 os.setVal('bvSubject',objJSON.bvSubject);
 os.setVal('bvDate',objJSON.bvDate);
 os.setVal('bvNo',objJSON.bvNo);
 

ajaxViewpayments(objJSON.rbreminderId);	
 
 
 os.show('getreminderButton');

 os.show('PrintButton');
 
 
 
 
 
}

function WT_rbreminderDeleteRowById(rbreminderId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbreminderId)<1 || rbreminderId==''){  
	var  rbreminderId =os.getVal('rbreminderId');
	}
	
	if(parseInt(rbreminderId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbreminderId',rbreminderId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbreminderDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbreminderDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbreminderDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbreminderListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbreminderpagingPageno',parseInt(pageNo));
	WT_rbreminderListing();
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
	    os.setVal('reminderStartDate',reminderStartDateVal);
}
  function calcPercentageValue()
  {
  
	//var taxAmountVal= parseFloat(os.getVal('taxAmount')); 
	var taxPercentVal= parseFloat(os.getVal('taxPercent')); 
	var amountVal= parseFloat(os.getVal('amount'));
		
	 var tax=(amountVal*taxPercentVal)/100;
	var	totalPayableAmountVal=amountVal+tax
	os.setVal('taxAmount',tax);		
	os.setVal('totalPayableAmount',totalPayableAmountVal);		
			
  }
   
   function printRBReceipt(rbreminderId)
   {
     var URLStr='printRBReceiptPHP.php?rbreminderId='+rbreminderId;
      popUpWindow(URLStr, 10, 10, 1100, 600);
   }	
   
   function printRBReceiptButton()
   {
		var rbreminderId=os.getVal('rbreminderId');
		  printRBReceipt(rbreminderId);
  }
	function setDueAmount()
	{
	
		var paybleAmount=os.getVal('totalPayableAmount');
		var receivedAmount=os.getVal('totalPaid');
		var dueAmount=parseFloat(paybleAmount)-parseFloat(receivedAmount);
		dueAmount=dueAmount.toFixed(2);
		os.setVal('dueAmount',dueAmount);
	   
	 
	}
	
	function openPayment()
	{
	
	  	var rbreminderId=os.getVal('rbreminderId');
		if(parseInt(rbreminderId)<1)
		{
		 alert('Please save record');
		   return false;
		}
		
		 rb.popUpOpen('quickPaymentPOPUP');
	
	}	
	
	function setDatesAutomatic()
	{}
	
	function setDatesAutomatic_backup()
	{
	
	var rbreminderId=os.getVal('rbreminderId');
	if(parseInt(rbreminderId)>0)
	{
		 alert('Auttomatic calculation applicable for new entry only, Otherwise go to view all and add next reminder.');
		 return false;
	}
	
     var frequency=os.getVal('frequency');
	 var registerDate=os.getVal('registerDate');
	 os.setVal('fromDate',registerDate);
	
	 var fromDate=os.getVal('fromDate');
	
	 var expiryDateVal=fromDate;
	 
		var dd=os.dd(fromDate);
		var mm=os.mm(fromDate);
		var yyyy=os.yy(fromDate);
		 
		var td = new Date(yyyy+'-'+mm+'-'+dd);
		
		if(frequency==30)
		{			
		     td.setDate(td.getDate()-1);
			 td.setMonth(td.getMonth()+1);
		}
		if(frequency==360)
		{			
		     td.setDate(td.getDate()-1);
			 td.setFullYear(td.getFullYear()+1);
		}
		
		dd=td.getDate();
		mm=td.getMonth()+1; 
		yyyy=td.getFullYear();	
	  
	    var expiryDateVal =os.formattedDate(dd,mm,yyyy);
	  
	
	 
	 
	 os.setVal('expiryDate',expiryDateVal);
	
	
	 
	 
	     
	 calReminderStartDate();
	}
	
	 
</script>
				
						
						
			
<style>

.trListingSelected{ background-color:#FF6600;}
.reminderStatusClose{ background-color:#BDBDDF;}
.reminderStatusNC{ background-color:#FFDFDF; }
</style>
  
 
<? include($site['root-wtos'].'bottom.php'); ?>