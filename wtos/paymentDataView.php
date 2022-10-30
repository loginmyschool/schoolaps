<?
/*
   # wtos version : 1.1
   # main ajax process page : paymentAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Registration Payment';
$ajaxFilePath= 'paymentAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$historyId_get=$os->get('historyId');
$studentId_get=$os->get('studentId');
 
 
$studentNameQuery="  select * from student where studentId>0 and studentId='$studentId_get'";
$studentNameMq=$os->mq($studentNameQuery);
$studentData=$os->mfa($studentNameMq);
$studentName=$studentData['name'];



/*$regFeesData['registrationFees']=0; 
if($historyId_get>0){
 $regFeesQuery="  select * from history where historyId>0 and   historyId='$historyId_get' and studentId='$studentId_get'  order by historyId desc";
$regFeesMq=$os->mq($regFeesQuery);
$regFeesData=$os->mfa($regFeesMq);
}*/
 
 
?>
  
<style>
.btnStyle{ display:none;}
</style>
 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader" style="font-size:12px; display:none;"> <?php  echo $listHeader; ?>  
			  
			  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470"   valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton" style="display:none;"> 
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('');"  /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_paymentEditAndSave();" /><? } ?>	 
	
	</div>
	
	
	
	
	
	 <div class="listHeader" style="font-size:12px; "> <?php  echo $listHeader; ?> &nbsp;&nbsp; <span style="color:#0000CC"> <?echo $studentName;?> [<?echo $studentData['studentId'];?>] </span>
			  
		
			  
			  </div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Date </td>
										<td><input value="<?echo $os->showDate($os->now())?>" disabled type="text" name="paymentDate" id="paymentDate" class="wtDateClass textbox fWidth" style="width:70px;"/></td>			
											<td>Payment Mode </td>
										<td>  
	
	<select name="paymentMode" id="paymentMode" class="textbox fWidth" style="width:70px;" ><option value=""> </option>	<? 
										  $os->onlyOption($os->paymentethod);	?></select>	 </td>	
	  											
															
										</tr>
										
										
										
										
										
										 
										
										
										
									<tr>
										<td>Received Amt. </td>
										<td><input value="" type="text" name="receivedAmt" id="receivedAmt" class="textboxxx  fWidth " onkeyup="getRefundAmt();" onblur="getRefundAmt();" style="width:70px;"/> </td>	
										
										<td>Payment Details </td>
										<td><input value="" type="text"  name="paid_details" id="paid_details" style="width:70px;" class=" textbox fWidth" > </td>		
											
										</tr>	
										
									<tr>
<td>Paid Amount </td>
										<td><input value="" type="text" name="paidRegistrationFees" id="paidRegistrationFees" class="textboxxx  fWidth " onkeyup="getRefundAmt();" onblur="getRefundAmt();" style="width:70px;"/> </td>	

<td>Paid Time </td>
										<td><input value="<?echo date('h:i a', time())?>" type="text" name="paymentTime" id="paymentTime" class="textboxxx  fWidth " style="width:70px;"/> <br/><b>12 hours format like 05:00 pm</b></td>	
										 										
										
									 
					</tr>		
<tr>
										<td>Refund Amt. </td>
										<td><input value="" type="text" name="refundAmt" id="refundAmt" class="textboxxx  fWidth " style="width:70px;"/> </td>						
											
										</tr>					
										
										
										
										<tr >
	  									<td>Remarks </td>
										<td colspan="4"><input value="" type="text"  name="remarks" id="remarks" class=" textbox fWidth" style="width:200px;" > </td>						
										</tr>
										
							
		 								
	</table>
	
	<div style="display:none">
	<table  >
	<tr style="display:none">
	  									<td>historyId </td>
										<td><input value="<? echo $historyId_get ?>" type="text" name="historyId" id="historyId" class="textboxxx  fWidth "/> </td>						
										</tr><tr style="display:none">
	  									<td>studentId </td>
										<td><input value="<? echo $studentId_get ?>" type="text" name="studentId" id="studentId" class="textboxxx  fWidth "/> </td>						
										</tr><tr style="display:none">
	  									<td>Due Registration Fees </td>
										<td><input value="" type="text" name="dueRegistrationFees" id="dueRegistrationFees" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
										
										<td>Counter </td>
										<td><input value="0" type="text" name="addEditCounter" id="addEditCounter" class="textboxxx  fWidth "  /> </td>						
										</tr>		
										
										
										
	</table>
	</div>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="paymentId" value="0" />	
	<input type="hidden"  id="WT_paymentpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_paymentEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch" style="display:none">
	
	
	

	 
  <div  id="advanceSearchDiv">
         	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
 historyId: <input type="text" class="wtTextClass" name="historyId_s" id="historyId_s" value="<? echo $historyId_get ?>" /> &nbsp; From Date: <input class="wtDateClass" type="text" name="f_paymentDate_s" id="f_paymentDate_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_paymentDate_s" id="t_paymentDate_s" value=""  /> &nbsp;  
   studentId: <input type="text" class="wtTextClass" name="studentId_s" id="studentId_s" value="<? echo $studentId_get ?>" /> &nbsp;  Paid Registration Fees: <input type="text" class="wtTextClass" name="paidRegistrationFees_s" id="paidRegistrationFees_s" value="" /> &nbsp;  Due Registration Fees: <input type="text" class="wtTextClass" name="dueRegistrationFees_s" id="dueRegistrationFees_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;  Paid Details: <input type="text" class="wtTextClass" name="paid_details_s" id="paid_details_s" value="" /> &nbsp;  Payment Mode:
	
	<select name="paymentMode" id="paymentMode_s" class="textbox fWidth" ><option value="">Select Payment Mode</option>	<? 
										  $os->onlyOption($os->paymentethod);	?></select>	
   
   
  <input type="button" value="Search" onclick="WT_paymentListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  </div>
 
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_paymentListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>


function getRefundAmt()
{
var  receivedAmt= parseFloat(os.getVal('receivedAmt'));
var  paid_amount= parseFloat(os.getVal('paidRegistrationFees'));
if(isNaN(receivedAmt))
{
	receivedAmt=0;
}
if(isNaN(paid_amount))
{
	paid_amount=0;
}
var refundAmtV=receivedAmt-paid_amount;
os.setVal('refundAmt',refundAmtV);
}

function checkEditDeletePassword(paymentId,addEditCounter)
{
	
		var formdata = new FormData();	 
	
	if(parseInt(paymentId)<1 || paymentId==''){  
	
	var  paymentId =os.getVal('paymentId');
	formdata.append('operationType','deleteData');
	
	}
	
	
	if(addEditCounter==0)
	{
		WT_paymentGetById(paymentId);
	}
	else{
	var password= prompt("Please Enter Password");
	if(password)
	{
	 
	formdata.append('paymentId',paymentId );
	formdata.append('password',password );
	
	var url='<? echo $ajaxFilePath ?>?checkEditDeletePassword=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('checkEditDeletePasswordResult',url,formdata);
	
	}
	
	}
	
}




function checkEditDeletePasswordResult(data)
{
	
	if(data=='wrong password')
	{
		alert(data);
	}
	else
	{
		var d=data.split('#-#');
		var paymentId=parseInt(d[1]);
		
		
		
		
		var operationType=d[2];
		
		if(operationType=='Edit Data')
		{
		WT_paymentGetById(paymentId);
		}
		if(operationType=='Delete Data')
		{
			WT_paymentDeleteRowById(paymentId);
		}
		
		
		
		
		
	}
	
}




 
function WT_paymentListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var historyId_sVal= os.getVal('historyId_s'); 
 var f_paymentDate_sVal= os.getVal('f_paymentDate_s'); 
 var t_paymentDate_sVal= os.getVal('t_paymentDate_s'); 
 var studentId_sVal= os.getVal('studentId_s'); 
 var paidRegistrationFees_sVal= os.getVal('paidRegistrationFees_s'); 
 var dueRegistrationFees_sVal= os.getVal('dueRegistrationFees_s'); 
 var remarks_sVal= os.getVal('remarks_s'); 
 var paid_details_sVal= os.getVal('paid_details_s'); 
 var paymentMode_sVal= os.getVal('paymentMode_s'); 
formdata.append('historyId_s',historyId_sVal );
formdata.append('f_paymentDate_s',f_paymentDate_sVal );
formdata.append('t_paymentDate_s',t_paymentDate_sVal );
formdata.append('studentId_s',studentId_sVal );
formdata.append('paidRegistrationFees_s',paidRegistrationFees_sVal );
formdata.append('dueRegistrationFees_s',dueRegistrationFees_sVal );
formdata.append('remarks_s',remarks_sVal );
formdata.append('paid_details_s',paid_details_sVal );
formdata.append('paymentMode_s',paymentMode_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_paymentpagingPageno=os.getVal('WT_paymentpagingPageno');
	var url='wtpage='+WT_paymentpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_paymentListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_paymentListDiv',url,formdata);
		
}

WT_paymentListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('historyId_s',''); 
 os.setVal('f_paymentDate_s',''); 
 os.setVal('t_paymentDate_s',''); 
 os.setVal('studentId_s',''); 
 os.setVal('paidRegistrationFees_s',''); 
 os.setVal('dueRegistrationFees_s',''); 
 os.setVal('remarks_s',''); 
 os.setVal('paid_details_s',''); 
 os.setVal('paymentMode_s',''); 
	
		os.setVal('searchKey','');
		WT_paymentListing();	
	
	}
	
 
function WT_paymentEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var historyIdVal= os.getVal('historyId'); 
var paymentDateVal= os.getVal('paymentDate'); 

var studentIdVal= os.getVal('studentId'); 
var paidRegistrationFeesVal= os.getVal('paidRegistrationFees'); 
var dueRegistrationFeesVal= os.getVal('dueRegistrationFees'); 
var remarksVal= os.getVal('remarks'); 
var paid_detailsVal= os.getVal('paid_details'); 
var paymentModeVal= os.getVal('paymentMode'); 
var addEditCounterVal= os.getVal('addEditCounter');
var receivedAmtVal= os.getVal('receivedAmt'); 
var refundAmtVal= os.getVal('refundAmt'); 
var paymentTimeVal= os.getVal('paymentTime'); 



formdata.append('receivedAmt',receivedAmtVal );
formdata.append('refundAmt',refundAmtVal );
formdata.append('paymentTime',paymentTimeVal );



formdata.append('addEditCounter',addEditCounterVal );

 formdata.append('historyId',historyIdVal );
 formdata.append('paymentDate',paymentDateVal );
 formdata.append('studentId',studentIdVal );
 formdata.append('paidRegistrationFees',paidRegistrationFeesVal );
 formdata.append('dueRegistrationFees',dueRegistrationFeesVal );
 formdata.append('remarks',remarksVal );
 formdata.append('paid_details',paid_detailsVal );
 formdata.append('paymentMode',paymentModeVal );

	if(os.check.empty('paymentDate','Please Add Payment Date')==false){ return false;} 

	 var   paymentId=os.getVal('paymentId');
	 formdata.append('paymentId',paymentId );
  	var url='<? echo $ajaxFilePath ?>?WT_paymentEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_paymentReLoadList',url,formdata);

}	

function WT_paymentReLoadList(data) // after edit reload list
{
  window.location='';
	var d=data.split('#-#');
	var paymentId=parseInt(d[0]);
	if(d[0]!='Error' && paymentId>0)
	{
	  os.setVal('paymentId',paymentId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_paymentListing();
}

function WT_paymentGetById(paymentId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('paymentId',paymentId );
	var url='<? echo $ajaxFilePath ?>?WT_paymentGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_paymentFillData',url,formdata);
				
}

function WT_paymentFillData(data)  // fill data form by JSON
{
   
var objJSON = JSON.parse(data);
os.setVal('paymentId',parseInt(objJSON.paymentId));
os.setVal('historyId',objJSON.historyId); 
os.setVal('paymentDate',objJSON.paymentDate); 
os.setVal('studentId',objJSON.studentId); 
os.setVal('paidRegistrationFees',objJSON.paidRegistrationFees); 
os.setVal('dueRegistrationFees',objJSON.dueRegistrationFees); 
os.setVal('remarks',objJSON.remarks); 
os.setVal('paid_details',objJSON.paid_details); 
os.setVal('paymentMode',objJSON.paymentMode); 
os.setVal('addEditCounter',objJSON.addEditCounter);
os.setVal('receivedAmt',objJSON.receivedAmt); 
os.setVal('refundAmt',objJSON.refundAmt); 
//os.setVal('paymentTime',objJSON.paymentTime);  

 if(objJSON.paymentTime!='')
 {
 os.setVal('paymentTime',objJSON.paymentTime); 
 }
 else
 {
	 os.setVal('paymentTime',"<?echo date('h:i a', time())?>"); 
 }
  
}

function WT_paymentDeleteRowById(paymentId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(paymentId)<1 || paymentId==''){  
	var  paymentId =os.getVal('paymentId');
	}
	
	if(parseInt(paymentId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('paymentId',paymentId );
	
	var url='<? echo $ajaxFilePath ?>?WT_paymentDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_paymentDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_paymentDeleteRowByIdResults(data)
{
	alert(data);
	WT_paymentListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_paymentpagingPageno',parseInt(pageNo));
	WT_paymentListing();
}
	 
</script>


<script>
function	openRegFeesPrint(historyId,studentId,paymentId,receiptNo)
{
	var p;
	if(receiptNo=='')
	{
		p =confirm('It will generate new Receipt no. Is it ok?')
		
	}
	else
	{
		p=true;
	}
	if(p)
	{
		var URLStr='regFeesPrint.php?historyId='+historyId+'&studentId='+studentId+'&paymentId='+paymentId;
	    popUpWindow(URLStr, 50, 50, 1050, 620);
		
	}
	
	
}
</script>


<?php if(isset($_GET['key'])) {?>
<style>
.ajaxViewMainTableTDForm .formDiv{ padding:0px;}
.ajaxEditForm{ margin:0px;}
.ajaxViewMainTableTDForm{ padding:1px;}
.ajaxViewMainTableTDListData{ padding:1px;}
.ajaxViewMainTableTDList{padding:1px;}
.borderTitle b { font-weight:normal;}
.ajaxViewMainTable{ border:0px;}
.ajaxViewMainTableTDListData{ border:0px;}
</style>

<?php } ?>
  
 
<? include($site['root-wtos'].'bottom.php'); ?>