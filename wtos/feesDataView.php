<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php 

   #  

*/



include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');

?><?

$pluginName='';

$listHeader='Monthly Payment';

$ajaxFilePath= 'feesAjax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';



$historyId_get=$os->get('historyId');

$studentId_get=$os->get('studentId');



$studentNameQuery="  select * from student where studentId>0 and studentId='$studentId_get'";

$studentNameMq=$os->mq($studentNameQuery);

$studentData=$os->mfa($studentNameMq);

$studentName=$studentData['name'];



 

$keyVal=$os->get('key');



$setFeesSession='';

$setFeesClass='';

$setFeesSection='';

$sessionDisable='';

if($keyVal=='allData')

{

$arrayKeys = array_keys($os->asession);

$setFeesSession=$os->asession[$arrayKeys[0]];

$setFeesClass='1';

$setFeesSection='A';



$sessionDisable='disabled';



$studentIdDisabled='';

$hideSaveButton='style=display:none;';



}



?>



<?if($keyVal=='selectedData')

{

	 $studentIdDisabled="disabled";

?>

<style>

.hideForSelectedData{ display:none;}

.btnStyle{ display:none;}

</style>



<?}?>





<?if($keyVal=='selectedDataByFeesButton')

{

	 $studentIdDisabled="disabled";

?>

<style>

.hideForSelectedData{ display:none;}



</style>



<?php } ?>



<?php 

$monthly_total_Fees_str='';

if($historyId_get>0)	



		{



		$wheres=" where historyId='$historyId_get' and studentId='$studentId_get'  ";



		

		 $dataQuery=" select * from history  $wheres ";



		$rsResultsh=$os->mq($dataQuery);



		$historyD=$os->mfa( $rsResultsh);

		

		$monthly_total_Fees_str='<span style=" font-size:14px" >  Monthly Fees : <span style="color:#0000CC" >  '.$historyD ['monthlyFees'].' </span> &nbsp;&nbsp;&nbsp; Total Fees : <span style="color:#0000CC" >'.$historyD ['totalFees'].'</span></span>';

		

		}

 

	   

?>





  



 <table class="container"  cellpadding="0" cellspacing="0">

				<tr>

					 

			  <td  class="middle" style="padding-left:5px;">

			  

			  

			  <div class="listHeader" style="font-size:12px;" > 

			  <?php  echo $listHeader; ?>  &nbsp;&nbsp;  <span style="color:#0000CC">  <? echo $studentName;?>[<? echo $studentData['studentId'];?>]  </span>

			  

			  <?php echo $monthly_total_Fees_str  ?>

			  </div>

			  

			  <!--  ggggggggggggggg   -->

			  

			  

			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

			  

  <tr>

    <td width="380" height="470" valign="top" class="ajaxViewMainTableTDForm">

	<div class="formDiv">

	<div class="formDivButton">

	<? if($os->checkAccess('Delete Fees')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('<? echo $record['feesId'];?>');" /><? } ?>	 

	&nbsp;&nbsp;

	&nbsp; <input  type="button" value="New"  onclick="javascript:window.location='';" />

	 

	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" <? echo $hideSaveButton ?> value="Save" onclick="WT_feesEditAndSave();" /><? } ?>	 

	

	<?if($keyVal=='allData'||$keyVal=='selectedDataByFeesButton'){?>

	<input type="button" value="Registration Payment" onclick="registrationFees();" />

	<?}?>

	

	

	</div>

	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	



										

										

										

										<tr >

	  									<td>Session </td>

										<td  >  

	

	<select name="asession" id="asession" class="textbox fWidth"  <?echo $sessionDisable;?>  ><option value=""></option>	<? 

										  $os->onlyOption($os->asession);	?></select>	 </td>	

										  <td>Paid Date </td>

										<td><input value="<?//echo $os->showDate($os->now())?>"  type="text" name="paid_date" id="paid_date" class="wtDateClass textbox fWidth" style="width:70px;"/></td>	

										  

										 </tr> 	<tr >

										  <td> Payment forMonth </td>  

	<td  >  

	<select name="month" id="month" class="textbox fWidth" ><option value=""> </option>	<? 

										  $os->onlyOption($os->feesMonth);	?></select>	

										  

										  </td>

										  <td>Year </td> <td>  <select name="year" id="year" class="textbox fWidth" ><option value=""> </option>	<? 

										  $os->onlyOption($os->feesYear);	?></select> </td>		

										  

										  

										  

										  					

										</tr>

										 

										

										<tr >

	  									<td>Fees Amount </td>

										<td><input value="" type="text" name="fees_amount" id="fees_amount" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth " style="width:70px;" disabled/> </td>			

										<td>Discount</td>

										<td><input value="" type="text" name="discount" id="discount" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth "style="width:70px;"/> </td>							

										</tr> 

										

										

										

										

										

										<tr >

	  									<td>Fine</td>

										<td><input value="" type="text" name="fineAmount" id="fineAmount" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth " style="width:70px;"/> </td>			

										

										<td>Medicine</td>

										<td><input value="" type="text" name="medicineAmount" id="medicineAmount" onkeyup="calculatePaybleAndDue()" onblur="calculatePaybleAndDue()" class="textboxxx  fWidth " style="width:70px;"/> </td>						

										</tr> 

										

										

										

										

										

										<tr >

	  									<td>Payble Amt. </td>

										<td><input value="" type="text" name="payble" id="payble" class="textboxxx  fWidth " style="width:70px;"/> </td>						

										

										

										<td>Paid By </td>

										<td>

					                      <select name="paid_by" id="paid_by" class="textbox fWidth" ><option value=""></option>	<? 

										  $os->onlyOption($os->paymentMethod);	?></select>	

										</td>

											

										</tr> 

										

										<tr>

										<td>Received Amt. </td>

										<td><input value="" type="text" name="receivedAmt" id="receivedAmt" class="textboxxx  fWidth " onkeyup="getRefundAmt();" onblur="getRefundAmt();" style="width:70px;"/> </td>	<td>Details </td>

										<td   ><input value="" type="text" name="paid_details" id="paid_details" class="textboxxx  fWidth " style="width:70px;"/> </td>					

											

										</tr>

										

										

										<tr >

	  									<td>Paid Amt. </td>

										<td><input value="" type="text" name="paid_amount" id="paid_amount" class="textboxxx  fWidth " onkeyup="getRefundAmt();" onblur="getRefundAmt();" style="width:70px;"/> </td>						

													

											<td>Paid Time </td>

										<td><input value="<?echo date('h:i a', time())?>" type="text" name="paymentTime" id="paymentTime" class="textboxxx  fWidth " style="width:70px;"/> <br/><b>12 hours format like 05:00 pm</b></td>	

										 

										</tr>

										

										<tr>

										<td>Refund Amt. </td>

										<td><input value="" type="text" name="refundAmt" id="refundAmt" class="textboxxx  fWidth " style="width:70px;"/> </td>						

											

										</tr>

										

										

										

										

										<tr >

	  									

											<td>Remarks </td>

										<td colspan="4"  ><input value="" type="text" name="remarks" id="remarks" class="textboxxx  fWidth " style="width:200px;"/> </td>					

										</tr>

										

										

										

										

										

										

										

										<tr >

	  														

										</tr>

										

										 

										

										

										

									

		 								

	</table>

	

	

	<div style="display:none">

	<table>

		<tr style="display:none">

								<td>Paid Status </td>

										<td>  

	

	<select name="status" id="status" class="textbox fWidth" disabled><option value="">Select Status</option>	<? 

										  $os->onlyOption($os->feesStatus);	?></select>	 </td>	</tr>

								

								<tr style="display:none">

	  									<td>Subjects </td>

										<td><input value="" type="text" name="subjects" id="subjects" class="textboxxx  fWidth "/> </td>						

										</tr>

	

	

	                              <tr style="display:none">

										

										<td>Counter </td>

										<td><input value="0" type="text" name="addEditCounter" id="addEditCounter" class="textboxxx  fWidth "  /> </td>						

										</tr>

										

											 

<tr style="display:none">

	  									<td>historyId </td>

										<td><input value="<? echo $historyId_get ?>" type="text" name="historyId" id="historyId" class="textboxxx  fWidth "/> </td>						

										</tr><tr style="display:none">

	  									<td>studentId </td>

										<td><input value="<? echo $studentId_get ?>" type="text" name="studentId" id="studentId" class="textboxxx  fWidth "/> </td>						

										</tr>

										

										

										

										

										

										<tr style="display:none">

	  									<td>From Date </td>

										<td><input value="" type="text" name="from_date" id="from_date" class="wtDateClass textbox fWidth"/></td>						

										</tr><tr style="display:none">

	  									<td>To Date </td>

										<td><input value="" type="text" name="to_date" id="to_date" class="wtDateClass textbox fWidth"/></td>						

										</tr>

										

										

										

										

								<tr style="display:none">

	  									<td>Fees Title </td>

										<td><input value="" type="text" name="fees_title" id="fees_title" class="textboxxx  fWidth "/> </td>						

										</tr>		

										

										

										

	</table>

	</div>

	

	

	

	

	

	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					

	<input type="hidden"  id="feesId" value="0" />	

	<input type="hidden"  id="WT_feespagingPageno" value="1" />	

	<div class="formDivButton">						

	<? if($os->checkAccess('Delete Fees')){ ?><input type="button" value="Delete" onclick="checkEditDeletePassword('<? echo $record['feesId'];?>');" />	<? } ?>	  

	&nbsp;&nbsp;

	&nbsp; <input  type="button" value="New" onclick="javascript:window.location='';" />

	 

	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save"  <?echo $hideSaveButton?> onclick="WT_feesEditAndSave();" /><? } ?>	

	</div> 

	</div>	

	

	 

	

	</td>

    <td valign="top" class="ajaxViewMainTableTDList">

	

	<div class="ajaxViewMainTableTDListSearch">

	Search Key  

  <input type="text" id="searchKey" />   &nbsp;

     

	   Student Id: <input type="text" <?php echo $studentIdDisabled;?> class="wtTextClass" name="studentId_s" id="studentId_s" style="width:50px;"  value="<? echo $studentId_get ?>" onchange="setHistoryId_sNull();"/> 

	    Month:

	

	<select name="month" id="month_s" class="textbox fWidth" ><option value=""> </option>	<? 

										  $os->onlyOption($os->feesMonth);	?></select>	

										  

										  

			

   Year:

	

	<select name="year_s" id="year_s" class="textbox fWidth" ><option value=""> </option>	<? 

										  $os->onlyOption($os->feesYear);	?></select>								  

										  

			

	 <span class="hideForSelectedData">

	  Session:

	

	<select name="asession" id="asession_s" class="textbox fWidth" ><option value=""></option><? 

										  $os->onlyOption($os->asession,$setFeesSession);?></select>	



Class <select name="classList" id="classList_s" class="textbox fWidth"><option value=""></option>	<? 

$os->onlyOption($os->classList,$setFeesClass);	?></select>	



Section <select name="section" id="section_s" class="textbox fWidth"><option value=""></option>	<? 

$os->onlyOption($os->section,$setFeesSection);	?></select>	





							  

										  

										  

  

Status <select name="status" id="status_s" class="textbox fWidth" ><option value=""></option>	<? 

										  $os->onlyOption($os->feesStatus);	?></select>	

	From Paid Date: <input class="wtDateClass" type="text" name="f_paid_date_s" id="f_paid_date_s" value=""  /> &nbsp;   To Paid Date: <input class="wtDateClass" type="text" name="t_paid_date_s" id="t_paid_date_s" value=""  /> &nbsp; 

	 

	  

</span>



	

  <div style="display:none" id="advanceSearchDiv">

         

 historyId: <input type="text" class="wtTextClass" name="historyId_s" id="historyId_s" value="<? echo $historyId_get ?>" /> &nbsp; &nbsp; From From Date: <input class="wtDateClass" type="text" name="f_from_date_s" id="f_from_date_s" value=""  /> &nbsp;   To From Date: <input class="wtDateClass" type="text" name="t_from_date_s" id="t_from_date_s" value=""  /> &nbsp;  

  From To Date: <input class="wtDateClass" type="text" name="f_to_date_s" id="f_to_date_s" value=""  /> &nbsp;   To To Date: <input class="wtDateClass" type="text" name="t_to_date_s" id="t_to_date_s" value=""  /> &nbsp;  

   

   

   

   

   

   Fees Title: <input type="text" class="wtTextClass" name="fees_title_s" id="fees_title_s" value="" /> &nbsp;  Fees Amount: <input type="text" class="wtTextClass" name="fees_amount_s" id="fees_amount_s" value="" /> &nbsp;  Discount Amount: <input type="text" class="wtTextClass" name="discount_s" id="discount_s" value="" /> &nbsp;  Payble Amount: <input type="text" class="wtTextClass" name="payble_s" id="payble_s" value="" /> &nbsp;  Paid Amount: <input type="text" class="wtTextClass" name="paid_amount_s" id="paid_amount_s" value="" /> &nbsp;  Paid By: <input type="text" class="wtTextClass" name="paid_by_s" id="paid_by_s" value="" /> &nbsp;  Paid Details: <input type="text" class="wtTextClass" name="paid_details_s" id="paid_details_s" value="" /> &nbsp;   

   Subjects: <input type="text" class="wtTextClass" name="subjects_s" id="subjects_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp; 

	

   

  </div>

 

   

  <input type="button" value="Search" onclick="WT_feesListing();" style="cursor:pointer;"/>

  

  <?if($keyVal=='allData')

{?>

  

  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

<?}?>

  

   </div>

	<div  class="ajaxViewMainTableTDListData" id="WT_feesListDiv">&nbsp; </div>

	&nbsp;</td>

  </tr>

</table>



		

			  			  

			  <!--   ggggggggggggggg  -->

			  

			  </td>

			  </tr>

			</table>

			

	<?php if($keyVal!='allData') {?>

<style>

.ajaxViewMainTableTDForm .formDiv{ padding:0px;}

.ajaxEditForm{ margin:0px;}

.ajaxViewMainTableTDForm{ padding:1px;}

.ajaxViewMainTableTDListData{ padding:1px;}

.ajaxViewMainTableTDList{padding:1px;}

.borderTitle b { font-weight:normal;}

.ajaxViewMainTable{ border:0px;}

.ajaxViewMainTableTDListData{ border:0px;}

.ajaxViewMainTableTDListSearch{ display:none;}

.hidemeondemand{ display:none;}

</style>



<?php } else {?>

<script>

setCurrentMonth('month_s');

 setCurrentYesr('year_s');

 </script>

<?php } ?>

  		 



<script>







function getRefundAmt()

{

var  receivedAmt= parseFloat(os.getVal('receivedAmt'));

var  paid_amount= parseFloat(os.getVal('paid_amount'));

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

 



function setCurrentMonth(monthFieldIds)

{

   var today = new Date();	

  var mm=today.getMonth()+1;

   

   os.setVal(monthFieldIds,mm);

}

function setCurrentYesr(yearFieldIds)

{

      var today = new Date();	

	  var yyyy=today.getFullYear();	

       os.setVal(yearFieldIds,yyyy);

}





function calculatePaybleAndDue()

{

	

	

var  fees_amount= parseFloat(os.getVal('fees_amount'));

var  discount= parseFloat(os.getVal('discount'));

var  fineAmount= parseFloat(os.getVal('fineAmount'));

var  medicineAmount= parseFloat(os.getVal('medicineAmount'));





if(isNaN(discount))

{

	discount=0;

}



if(isNaN(fineAmount))

{

	fineAmount=0;

}

if(isNaN(medicineAmount))

{

	medicineAmount=0;

}



var  paybleAmountV=fees_amount-discount+fineAmount+medicineAmount;



os.setVal('payble',paybleAmountV);





}











 function setHistoryId_sNull()

 {

	 os.setVal('historyId_s',''); 

 }

function WT_feesListing() // list table searched data get 

{

	

	var formdata = new FormData();

	

	

 var historyId_sVal= os.getVal('historyId_s'); 

 var studentId_sVal= os.getVal('studentId_s'); 

 var f_from_date_sVal= os.getVal('f_from_date_s'); 

 var t_from_date_sVal= os.getVal('t_from_date_s'); 

 var f_to_date_sVal= os.getVal('f_to_date_s'); 

 var t_to_date_sVal= os.getVal('t_to_date_s'); 

 var month_sVal= os.getVal('month_s'); 

 var year_sVal= os.getVal('year_s'); 

 

 var asession_sVal= os.getVal('asession_s'); 

 

 

 

 var fees_title_sVal= os.getVal('fees_title_s'); 

 var fees_amount_sVal= os.getVal('fees_amount_s'); 

 var discount_sVal= os.getVal('discount_s'); 

 var payble_sVal= os.getVal('payble_s'); 

 var paid_amount_sVal= os.getVal('paid_amount_s'); 

 var paid_by_sVal= os.getVal('paid_by_s'); 

 var paid_details_sVal= os.getVal('paid_details_s'); 

 var f_paid_date_sVal= os.getVal('f_paid_date_s'); 

 var t_paid_date_sVal= os.getVal('t_paid_date_s'); 

 var subjects_sVal= os.getVal('subjects_s'); 

 var remarks_sVal= os.getVal('remarks_s'); 

 var status_sVal= os.getVal('status_s'); 

 

 

 

  var section_sVal= os.getVal('section_s'); 

 var classList_sVal= os.getVal('classList_s');

 

 

 formdata.append('section_s',section_sVal );

formdata.append('classList_s',classList_sVal );

 

 

 

formdata.append('historyId_s',historyId_sVal );

formdata.append('studentId_s',studentId_sVal );

formdata.append('f_from_date_s',f_from_date_sVal );

formdata.append('t_from_date_s',t_from_date_sVal );

formdata.append('f_to_date_s',f_to_date_sVal );

formdata.append('t_to_date_s',t_to_date_sVal );

formdata.append('month_s',month_sVal );

formdata.append('year_s',year_sVal );



formdata.append('asession_s',asession_sVal );



formdata.append('fees_title_s',fees_title_sVal );

formdata.append('fees_amount_s',fees_amount_sVal );

formdata.append('discount_s',discount_sVal );

formdata.append('payble_s',payble_sVal );

formdata.append('paid_amount_s',paid_amount_sVal );

formdata.append('paid_by_s',paid_by_sVal );

formdata.append('paid_details_s',paid_details_sVal );

formdata.append('f_paid_date_s',f_paid_date_sVal );

formdata.append('t_paid_date_s',t_paid_date_sVal );

formdata.append('subjects_s',subjects_sVal );

formdata.append('remarks_s',remarks_sVal );

formdata.append('status_s',status_sVal );



	

	 

	formdata.append('searchKey',os.getVal('searchKey') );

	formdata.append('showPerPage',os.getVal('showPerPage') );

	var WT_feespagingPageno=os.getVal('WT_feespagingPageno');

	var url='wtpage='+WT_feespagingPageno;

	url='<? echo $ajaxFilePath ?>?WT_feesListing=OK&'+url;

	os.animateMe.div='div_busy';

	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	

	os.setAjaxHtml('WT_feesListDiv',url,formdata);

		

}



WT_feesListing();

function  searchReset() // reset Search Fields

	{

		 os.setVal('historyId_s',''); 

 os.setVal('studentId_s',''); 

 os.setVal('f_from_date_s',''); 

 os.setVal('t_from_date_s',''); 

 os.setVal('f_to_date_s',''); 

 os.setVal('t_to_date_s',''); 

 os.setVal('month_s',''); 

 os.setVal('asession_s',''); 

 os.setVal('fees_title_s',''); 

 os.setVal('fees_amount_s',''); 

 os.setVal('discount_s',''); 

 os.setVal('payble_s',''); 

 os.setVal('paid_amount_s',''); 

 os.setVal('paid_by_s',''); 

 os.setVal('paid_details_s',''); 

 os.setVal('f_paid_date_s',''); 

 os.setVal('t_paid_date_s',''); 

 os.setVal('subjects_s',''); 

 os.setVal('remarks_s',''); 

 os.setVal('status_s',''); 

 

 

  os.setVal('classList_s',''); 

 os.setVal('section_s',''); 

 

 

	

		os.setVal('searchKey','');

		WT_feesListing();	

	

	}

	

 

function WT_feesEditAndSave()  // collect data and send to save

{

        

var formdata = new FormData();

var historyIdVal= os.getVal('historyId'); 

var studentIdVal= os.getVal('studentId'); 

var from_dateVal= os.getVal('from_date'); 

var to_dateVal= os.getVal('to_date'); 

var monthVal= os.getVal('month'); 

var yearVal= os.getVal('year'); 

var fees_titleVal= os.getVal('fees_title'); 

var fees_amountVal= os.getVal('fees_amount'); 

var discountVal= os.getVal('discount'); 

var paybleVal= os.getVal('payble'); 

var paid_amountVal= os.getVal('paid_amount'); 

var paid_byVal= os.getVal('paid_by'); 

var paid_detailsVal= os.getVal('paid_details'); 

var paid_dateVal= os.getVal('paid_date'); 

var subjectsVal= os.getVal('subjects'); 

var remarksVal= os.getVal('remarks'); 

var statusVal= os.getVal('status'); 

var asessionVal= os.getVal('asession'); 

var receivedAmtVal= os.getVal('receivedAmt'); 

var refundAmtVal= os.getVal('refundAmt'); 

var paymentTimeVal= os.getVal('paymentTime'); 







formdata.append('receivedAmt',receivedAmtVal );

formdata.append('refundAmt',refundAmtVal );

formdata.append('paymentTime',paymentTimeVal );

var fineAmountVal= os.getVal('fineAmount'); 

var medicineAmountVal= os.getVal('medicineAmount');

var addEditCounterVal= os.getVal('addEditCounter');

formdata.append('addEditCounter',addEditCounterVal );

formdata.append('fineAmount',fineAmountVal );

formdata.append('medicineAmount',medicineAmountVal );





 formdata.append('historyId',historyIdVal );

 formdata.append('studentId',studentIdVal );

 formdata.append('from_date',from_dateVal );

 formdata.append('to_date',to_dateVal );

 formdata.append('month',monthVal );

 formdata.append('year',yearVal );

 formdata.append('fees_title',fees_titleVal );

 formdata.append('fees_amount',fees_amountVal );

 formdata.append('discount',discountVal );

 formdata.append('payble',paybleVal );

 formdata.append('paid_amount',paid_amountVal );

 formdata.append('paid_by',paid_byVal );

 formdata.append('paid_details',paid_detailsVal );

 formdata.append('paid_date',paid_dateVal );

 formdata.append('subjects',subjectsVal );

 formdata.append('remarks',remarksVal );

 formdata.append('status',statusVal );



	 formdata.append('asession',asessionVal );



	 var   feesId=os.getVal('feesId');

	 

	 

	if(feesId==0)

{

var addFeesAccess='<? echo $os->checkAccess('Add Fees') ?>';

if(addFeesAccess=='')

{

alert('You dont have access for add');

return false;

}



} 

	 

	

if(os.check.empty('asession','Please Add session')==false){ return false;} 

	 

if(os.check.empty('month','Please Add Month')==false){ return false;}

	 

	 if(os.check.empty('year','Please Add Year')==false){ return false;} 



if(os.check.empty('paid_date','Please Add Paid Date')==false){ return false;} 



	 

	 

	 

	 

	 formdata.append('feesId',feesId );

  	var url='<? echo $ajaxFilePath ?>?WT_feesEditAndSave=OK&';

	os.animateMe.div='div_busy';

	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	

	os.setAjaxFunc('WT_feesReLoadList',url,formdata);



}	



function WT_feesReLoadList(data) // after edit reload list

{

    window.location='';

	var d=data.split('#-#');

	var feesId=parseInt(d[0]);

	if(d[0]!='Error' && feesId>0)

	{

	  os.setVal('feesId',feesId);

	}

	

	if(d[1]!=''){alert(d[1]);}

	WT_feesListing();

}







function checkEditDeletePassword(feesId,addEditCounter)

{

	var formdata = new FormData();	 

	

	if(parseInt(feesId)<1 || feesId==''){  

	

	var  feesId =os.getVal('feesId');

	formdata.append('operationType','deleteData');

	

	}

	

	if(parseInt(addEditCounter)==0)

	{

		WT_feesGetById(feesId);

	}

	

	else{

	var password= prompt("Please Enter  Password");

	if(password)

	{

		

	formdata.append('feesId',feesId );

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

		var feesId=parseInt(d[1]);

		

		var operationType=d[2];

		

		if(operationType=='Edit Data')

		{

		WT_feesGetById(feesId);

		}

		if(operationType=='Delete Data')

		{

			WT_feesDeleteRowById(feesId);

		}

		

	}

	

}





function WT_feesGetById(feesId) // get record by table primery id

{

	

	

		var formdata = new FormData();	 

	formdata.append('feesId',feesId );

	

	var url='<? echo $ajaxFilePath ?>?WT_feesGetById=OK&';

	os.animateMe.div='div_busy';

	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	

	os.setAjaxFunc('WT_feesFillData',url,formdata);







	

}



function WT_feesFillData(data)  // fill data form by JSON

{

	

	var objJSON = JSON.parse(data);

	os.setVal('feesId',parseInt(objJSON.feesId));

	

 os.setVal('historyId',objJSON.historyId); 

 os.setVal('studentId',objJSON.studentId); 

 os.setVal('from_date',objJSON.from_date); 

 os.setVal('to_date',objJSON.to_date); 

 os.setVal('month',objJSON.month); 

 os.setVal('year',objJSON.year); 

 os.setVal('fees_title',objJSON.fees_title); 

 os.setVal('fees_amount',objJSON.fees_amount); 

 os.setVal('discount',objJSON.discount); 

 os.setVal('payble',objJSON.payble); 

 os.setVal('paid_amount',objJSON.paid_amount); 

 os.setVal('paid_by',objJSON.paid_by); 

 os.setVal('paid_details',objJSON.paid_details); 

 os.setVal('paid_date',objJSON.paid_date); 

 

 

 

  os.setVal('receivedAmt',objJSON.receivedAmt); 

 os.setVal('refundAmt',objJSON.refundAmt); 

 if(objJSON.paymentTime!='')

 {

 os.setVal('paymentTime',objJSON.paymentTime); 

 }

 else

 {

	 os.setVal('paymentTime',"<?echo date('h:i a', time())?>"); 

 }

 

 

 

 

 document.getElementById("paid_date").disabled = true;

 

  if(objJSON.paid_date=='')

  {

	  var todayDate="<?echo $os->showDate($os->now())?>";

	 // alert(todayDate);

	   os.setVal('paid_date',todayDate); 

  }

 

 

 os.setVal('subjects',objJSON.subjects); 

 os.setVal('remarks',objJSON.remarks); 

 os.setVal('status',objJSON.status); 

  os.setVal('addEditCounter',objJSON.addEditCounter); 



 

  os.setVal('asession',objJSON.asession);

 

 

 

  os.setVal('fineAmount',objJSON.fineAmount); 

 os.setVal('medicineAmount',objJSON.medicineAmount); 



  

}



function WT_feesDeleteRowById(feesId) // delete record by table id

{

	var formdata = new FormData();	 

	if(parseInt(feesId)<1 || feesId==''){  

	var  feesId =os.getVal('feesId');

	}

	

	if(parseInt(feesId)<1){ alert('No record Selected'); return;}

	

	var p =confirm('Are you Sure? You want to delete this record forever.')

	if(p){

	

	formdata.append('feesId',feesId );

	

	var url='<? echo $ajaxFilePath ?>?WT_feesDeleteRowById=OK&';

	os.animateMe.div='div_busy';

	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	

	os.setAjaxFunc('WT_feesDeleteRowByIdResults',url,formdata);

	}

 



}

function WT_feesDeleteRowByIdResults(data)

{

	alert(data);

	WT_feesListing();

} 



function wtAjaxPagination(pageId,pageNo)// pagination function

{

	os.setVal('WT_feespagingPageno',parseInt(pageNo));

	WT_feesListing();

}



	

	

	

	

	

function	registrationFees(historyId,studentId)



{





var historyIdVal= os.getVal('historyId'); 

var studentIdVal= os.getVal('studentId'); 

if(historyIdVal==''||studentIdVal==''){ alert('No record Selected'); return;}

var URLStr='paymentDataView.php?historyId='+historyIdVal+'&studentId='+studentIdVal+'&';

popUpWindow(URLStr, 10, 80, 1200, 300);



}		 

</script>





<script>

function	openMonthlyFeesPrint(feesId,receiptNo)

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

		var URLStr='feesPrint.php?feesId='+feesId;

	    popUpWindow(URLStr, 50, 50, 1050, 620);

		

	}

	

	

}

</script>





  

 

<? include($site['root-wtos'].'bottom.php'); ?>