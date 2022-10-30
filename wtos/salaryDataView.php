<?
/*
   # wtos version : 1.1
   # main ajax process page : salaryAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Salary';
$ajaxFilePath= 'salaryAjax.php';
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
    <td width="350" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->checkAccess('Delete Salary')){ ?>
	
	
	
	<!--<input type="button" value="Delete" onclick="WT_salaryDeleteRowById('');" />-->
	
	<input type="button" value="Delete"  onclick="checkEditDeletePassword('');"  />
	
	
	
	
	<? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_salaryEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
	 
	 
	 
	 	 
<tr style="display:none">
	  									<td>Session </td>
										<td>  
	
	<select name="asession" id="asession" class="textbox fWidth" ><option value="">Select Session</option>	<? 
										  $os->onlyOption($os->asession);	?></select>	 </td>						
										</tr>
	 
	 
	 
<tr >
	  									<td>Year </td>
										<td>  
	
	<select name="year" id="year" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										  $os->onlyOption($os->feesYear);	?></select>	 </td>						
										</tr>
										
										
										
										
										
										<tr >
	  									<td>Month </td>
										<td>  
	
	<select name="month" id="month" class="textbox fWidth" ><option value="">Select Month</option>	<? 
										  $os->onlyOption($os->feesMonth);	?></select>	 </td>						
										</tr>
										
										
										<tr >
	  									<td>
										Paid To  <!-- <span id="SAA_t" class="SAA_Container"> </span>
				 <script>//code333
				saa.execute('t','SAA_t','teacherId','teacher','teacherId','name,designation,mobile,address','name,designation,mobile,address','teacherId','','');
				          
						 // (functionId,containerId,idForAssign,table,tableId,fields,fieldsTitle,returnField,scriptCallback,extraParams)
				</script> --></td>
										<td> <select style="width:150px;" name="teacherId" id="teacherId" class="textbox fWidth" ><option value=""></option>		  	<? 
								
										  $os->optionsHTML('','teacherId','name','teacher');?>
							</select> </td>						
										</tr>
										
										
										
										
										
											<tr >
	  									<td>Actual Gross</td>
										<td>
										<input value="" type="text" name="actualGross" id="actualGross"  class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
										
										
											<tr >
	  									<td>No Of</td>
										<td>
										<input value="" type="text" name="noOf" id="noOf" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
										
											<tr >
	  									<td>No Of Amt</td>
										<td>
										<input value="" type="text" name="noOfAmt" id="noOfAmt" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
										
										
										
										
										
										<tr >
	  									<td>Base </td>
										<td>
										
										<input value="" type="text" name="base" id="base" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth "/>


										</td>						
										</tr>
										
										
										
											<tr >
	  									<td>H.R.A</td>
										<td>
										<input value="" type="text" name="hra" id="hra" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
											<tr >
	  									<td>C.A</td>
										<td>
										<input value="" type="text" name="ca" id="ca" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
											<tr >
	  									<td>SPL</td>
										<td>
										<input value="" type="text" name="spl" id="spl" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										

<tr >
	  									<td>total </td>
										<td>
										<input value="" type="text" name="total" id="total" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										



<tr >
	  									<td>PF(%)</td>
										<td>
										<input value="" type="text" name="pfPercent" id="pfPercent" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										



<tr >
	  									<td>PF Amt.</td>
										<td>
										<input value="" type="text" name="pfAmt" id="pfAmt" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										

<tr >
	  									<td>ESIC(%)</td>
										<td>
										<input value="" type="text" name="esicPercent" id="esicPercent" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
										
										<tr >
	  									<td>ESIC Amt.</td>
										<td>
									<input value="" type="text" name="esicAmt" id="esicAmt" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
										
										<tr >
	  									<td>P TAX</td>
										<td>
										<input value="" type="text" name="pTax" id="pTax" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
										<tr >
	  									<td>NET</td>
										<td>
										<input value="" type="text" name="net" id="net" class="textboxxx  fWidth "/>
										</td>						
										</tr>
										
										
										<tr >
	  									<td>CTC</td>
										<td>
										<input value="" type="text" name="ctc" id="ctc" class="textboxxx  fWidth "/>
										</td>						
										</tr>
								
										<tr >
	  									<td>+ Other </td>
										<td><input value="" type="text" name="other" id="other" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Deduction </td>
										<td><input value="" type="text" name="deduction" id="deduction" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Payble </td>
										<td><input value="" type="text" name="payble" id="payble" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Paid Amount </td>
										<td><input value="" type="text" name="paidAmount" id="paidAmount" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Due Amount </td>
										<td><input value="" type="text" name="dueAmount" id="dueAmount" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Paid Date </td>
										<td><input value="" type="text" name="paidDate" id="paidDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Paid By </td>
										<td>
										
										<!--<input value="" type="text" name="paidBy" id="paidBy" class="textboxxx  fWidth "/>-->

                                        <select name="paidBy" id="paidBy" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->paymentMethod);	?></select>	




										</td>						
										</tr><tr >
	  									<td>Details </td>
										<td><input value="" type="text" name="details" id="details" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->salaryStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr><tr >
	  									<td>Remarks </td>
										<td><textarea  name="remarks" id="remarks" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="salaryId" value="0" />	
	<input type="hidden"  id="WT_salarypagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->checkAccess('Delete Salary')){ ?><input type="button" value="Delete"  onclick="checkEditDeletePassword('');"  />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_salaryEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
  
  
  From Paid Date: <input class="wtDateClass" type="text" name="f_paidDate_s" id="f_paidDate_s" value=""  /> &nbsp;   To Paid Date: <input class="wtDateClass" type="text" name="t_paidDate_s" id="t_paidDate_s" value=""  /> 
  
     
	    Year:
	
	<select name="year" id="year_s" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->feesYear);	?></select>
   Month:
	
	<select name="month" id="month_s" class="textbox fWidth" ><option value=""></option>	<? 
										  $os->onlyOption($os->feesMonth);	?></select>	
	Paid To:<select name="teacherId_s" id="teacherId_s" class="textbox fWidth" ><option value=""></option>		  	<? 
								
										  $os->optionsHTML('','teacherId','name','teacher');?>
							</select>
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Session:
	
	<select name="asession" id="asession_s" class="textbox fWidth" ><option value="">Select Session</option>	<? 
										  $os->onlyOption($os->asession);	?></select>	
										  
										  
										 
										  
										  
										  
   Base: <input type="text" class="wtTextClass" name="base_s" id="base_s" value="" /> &nbsp;  Other: <input type="text" class="wtTextClass" name="other_s" id="other_s" value="" /> &nbsp;  Deduction: <input type="text" class="wtTextClass" name="deduction_s" id="deduction_s" value="" /> &nbsp;  Payble: <input type="text" class="wtTextClass" name="payble_s" id="payble_s" value="" /> &nbsp;  Paid Amount: <input type="text" class="wtTextClass" name="paidAmount_s" id="paidAmount_s" value="" /> &nbsp;  Due Amount: <input type="text" class="wtTextClass" name="dueAmount_s" id="dueAmount_s" value="" /> &nbsp; &nbsp;  
   Paid By: <input type="text" class="wtTextClass" name="paidBy_s" id="paidBy_s" value="" /> &nbsp;  Details: <input type="text" class="wtTextClass" name="details_s" id="details_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->salaryStatus);	?></select>	
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_salaryListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_salaryListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>



function calculatePaybleAndDue()
{
	
	
var  base= parseFloat(os.getVal('base'));
var  other= parseFloat(os.getVal('other'));
var  deduction= parseFloat(os.getVal('deduction'));
var  paidAmount= parseFloat(os.getVal('paidAmount'));

if(isNaN(base))
{
	base=0;
}
if(isNaN(other))
{
	other=0;
}

if(isNaN(deduction))
{
	deduction=0;
}
if(isNaN(paidAmount))
{
	paidAmount=0;
}

var  paybleAmountV=base+other-deduction;
var  dueAmountV=paybleAmountV-paidAmount;

os.setVal('payble',paybleAmountV);
os.setVal('dueAmount',dueAmountV);

}




 
function WT_salaryListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var asession_sVal= os.getVal('asession_s'); 
 
  var year_sVal= os.getVal('year_s'); 
 
 var month_sVal= os.getVal('month_s'); 
 var base_sVal= os.getVal('base_s'); 
 var other_sVal= os.getVal('other_s'); 
 var deduction_sVal= os.getVal('deduction_s'); 
 var payble_sVal= os.getVal('payble_s'); 
 var paidAmount_sVal= os.getVal('paidAmount_s'); 
 var dueAmount_sVal= os.getVal('dueAmount_s'); 
 var f_paidDate_sVal= os.getVal('f_paidDate_s'); 
 var t_paidDate_sVal= os.getVal('t_paidDate_s'); 
 var paidBy_sVal= os.getVal('paidBy_s'); 
 var details_sVal= os.getVal('details_s'); 
 var status_sVal= os.getVal('status_s'); 
 var note_sVal= os.getVal('note_s'); 
 
  var teacherId_sVal= os.getVal('teacherId_s'); 
  
  
 var remarks_sVal= os.getVal('remarks_s'); 
formdata.append('asession_s',asession_sVal );
formdata.append('year_s',year_sVal );
formdata.append('month_s',month_sVal );

formdata.append('base_s',base_sVal );
formdata.append('other_s',other_sVal );
formdata.append('deduction_s',deduction_sVal );
formdata.append('payble_s',payble_sVal );
formdata.append('paidAmount_s',paidAmount_sVal );
formdata.append('dueAmount_s',dueAmount_sVal );
formdata.append('f_paidDate_s',f_paidDate_sVal );
formdata.append('t_paidDate_s',t_paidDate_sVal );
formdata.append('paidBy_s',paidBy_sVal );
formdata.append('details_s',details_sVal );
formdata.append('status_s',status_sVal );
formdata.append('note_s',note_sVal );
formdata.append('remarks_s',remarks_sVal );
formdata.append('teacherId_s',teacherId_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_salarypagingPageno=os.getVal('WT_salarypagingPageno');
	var url='wtpage='+WT_salarypagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_salaryListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_salaryListDiv',url,formdata);
		
}

WT_salaryListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('asession_s',''); 
		  os.setVal('year_s',''); 
		 
 os.setVal('month_s',''); 
 os.setVal('base_s',''); 
 os.setVal('other_s',''); 
 os.setVal('deduction_s',''); 
 os.setVal('payble_s',''); 
 os.setVal('paidAmount_s',''); 
 os.setVal('dueAmount_s',''); 
 os.setVal('f_paidDate_s',''); 
 os.setVal('t_paidDate_s',''); 
 os.setVal('paidBy_s',''); 
 os.setVal('details_s',''); 
 os.setVal('status_s',''); 
 os.setVal('note_s',''); 
 os.setVal('remarks_s',''); 
  os.setVal('teacherId_s',''); 
	
		os.setVal('searchKey','');
		WT_salaryListing();	
	
	}
	
 
function WT_salaryEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var asessionVal= os.getVal('asession'); 
	var yearVal= os.getVal('year'); 
var monthVal= os.getVal('month'); 
var baseVal= os.getVal('base'); 
var otherVal= os.getVal('other'); 
var deductionVal= os.getVal('deduction'); 
var paybleVal= os.getVal('payble'); 
var paidAmountVal= os.getVal('paidAmount'); 
var dueAmountVal= os.getVal('dueAmount'); 
var paidDateVal= os.getVal('paidDate'); 
var paidByVal= os.getVal('paidBy'); 
var detailsVal= os.getVal('details'); 
var statusVal= os.getVal('status'); 
var noteVal= os.getVal('note'); 
var remarksVal= os.getVal('remarks'); 
var teacherIdVal= os.getVal('teacherId');






var actualGrossVal= os.getVal('actualGross'); 
var noOfVal= os.getVal('noOf'); 
var noOfAmtVal= os.getVal('noOfAmt'); 
var hraVal= os.getVal('hra'); 
var caVal= os.getVal('ca'); 
var splVal= os.getVal('spl'); 
var totalVal= os.getVal('total'); 
var pfPercentVal= os.getVal('pfPercent'); 
var pfAmtVal= os.getVal('pfAmt'); 
var esicPercentVal= os.getVal('esicPercent'); 
var esicAmtVal= os.getVal('esicAmt'); 
var pTaxVal= os.getVal('pTax'); 
var netVal= os.getVal('net'); 
var ctcVal= os.getVal('ctc');
formdata.append('actualGross',actualGrossVal );
formdata.append('noOf',noOfVal );
formdata.append('noOfAmt',noOfAmtVal );
formdata.append('hra',hraVal );
formdata.append('ca',caVal );
formdata.append('spl',splVal );
formdata.append('total',totalVal );
formdata.append('pfPercent',pfPercentVal );
formdata.append('pfAmt',pfAmtVal );
formdata.append('esicPercent',esicPercentVal );
formdata.append('esicAmt',esicAmtVal );
formdata.append('pTax',pTaxVal );
formdata.append('net',netVal );
formdata.append('ctc',ctcVal );


formdata.append('asession',asessionVal );
formdata.append('year',yearVal );
formdata.append('month',monthVal );
formdata.append('base',baseVal );
formdata.append('other',otherVal );
formdata.append('deduction',deductionVal );
formdata.append('payble',paybleVal );
formdata.append('paidAmount',paidAmountVal );
formdata.append('dueAmount',dueAmountVal );
formdata.append('paidDate',paidDateVal );
formdata.append('paidBy',paidByVal );
formdata.append('details',detailsVal );
formdata.append('status',statusVal );
formdata.append('note',noteVal );
formdata.append('remarks',remarksVal );
formdata.append('teacherId',teacherIdVal );
var   salaryId=os.getVal('salaryId');
	 
if(salaryId==0)
{
var addSalaryAccess='<? echo $os->checkAccess('Add Salary') ?>';
if(addSalaryAccess=='')
{
alert('You dont have access for add');
return false;
}

}
	



// if(os.check.empty('year','Please Add Year')==false){ return false;} 
// if(os.check.empty('month','Please Add Month')==false){ return false;}

// if(os.check.empty('paidDate','Please Add Paid Date')==false){ return false;} 

	
	 
	 formdata.append('salaryId',salaryId );
	
  	var url='<? echo $ajaxFilePath ?>?WT_salaryEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_salaryReLoadList',url,formdata);

}	

function WT_salaryReLoadList(data) // after edit reload list
{
  	//console.log(data);
	var d=data.split('#-#');
	var salaryId=parseInt(d[0]);
	if(d[0]!='Error' && salaryId>0)
	{
	  os.setVal('salaryId',salaryId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_salaryListing();
}






function checkEditDeletePassword(salaryId)
{

	var formdata = new FormData();	
	
	if(parseInt(salaryId)<1 || salaryId==''){  
	
	var  salaryId =os.getVal('salaryId');
	formdata.append('operationType','deleteData');
	
	}
	
	
	var password= prompt("Please Enter Password");
	if(password)
	{
		 
	formdata.append('salaryId',salaryId );
	formdata.append('password',password );
	
	var url='<? echo $ajaxFilePath ?>?checkEditDeletePassword=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('checkEditDeletePasswordResult',url,formdata);
	
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
		var salaryId=parseInt(d[1]);
		var operationType=d[2];
		
		if(operationType=='Edit Data')
		{
		WT_salaryGetById(salaryId);
		}
		if(operationType=='Delete Data')
		{
			WT_salaryDeleteRowById(salaryId);
		}
	}
	
}





function WT_salaryGetById(salaryId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('salaryId',salaryId );
	var url='<? echo $ajaxFilePath ?>?WT_salaryGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_salaryFillData',url,formdata);
				
}

function WT_salaryFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('salaryId',parseInt(objJSON.salaryId));
	
 os.setVal('asession',objJSON.asession); 
  os.setVal('year',objJSON.year); 
 os.setVal('month',objJSON.month); 
 os.setVal('base',objJSON.base); 
 os.setVal('other',objJSON.other); 
 os.setVal('deduction',objJSON.deduction); 
 os.setVal('payble',objJSON.payble); 
 os.setVal('paidAmount',objJSON.paidAmount); 
 os.setVal('dueAmount',objJSON.dueAmount); 
 os.setVal('paidDate',objJSON.paidDate); 
 os.setVal('paidBy',objJSON.paidBy); 
 os.setVal('details',objJSON.details); 
 os.setVal('status',objJSON.status); 
 os.setVal('note',objJSON.note); 
 os.setVal('remarks',objJSON.remarks); 
 os.setVal('teacherId',objJSON.teacherId);
 
 
 
 
 
  os.setVal('actualGross',objJSON.actualGross); 
 os.setVal('noOf',objJSON.noOf); 
 os.setVal('noOfAmt',objJSON.noOfAmt); 
 os.setVal('hra',objJSON.hra); 
 os.setVal('ca',objJSON.ca); 
 os.setVal('spl',objJSON.spl); 
 os.setVal('total',objJSON.total); 
 os.setVal('pfPercent',objJSON.pfPercent); 
 os.setVal('pfAmt',objJSON.pfAmt); 
 os.setVal('esicPercent',objJSON.esicPercent); 
 os.setVal('esicAmt',objJSON.esicAmt); 
 os.setVal('pTax',objJSON.pTax); 
 os.setVal('net',objJSON.net); 
 os.setVal('ctc',objJSON.ctc); 
  
}

function WT_salaryDeleteRowById(salaryId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(salaryId)<1 || salaryId==''){  
	var  salaryId =os.getVal('salaryId');
	}
	
	if(parseInt(salaryId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('salaryId',salaryId );
	
	var url='<? echo $ajaxFilePath ?>?WT_salaryDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_salaryDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_salaryDeleteRowByIdResults(data)
{
	alert(data);
	WT_salaryListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_salarypagingPageno',parseInt(pageNo));
	WT_salaryListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>