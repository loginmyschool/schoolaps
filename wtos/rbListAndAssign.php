<?php
// _d($site);
?>
<style>
.RB_popupBOX{ height:300px; width:700px; border:20px solid #e4e1d1; background:#F0F0F0; position:absolute; top:100; right:100; margin-left:10px; overflow-y:scroll; padding:2px;  border-radius: 5px;    box-shadow: 0px 0px 5px #000000;}
.RB_popupBOX_data{}
.RBpopoupClose{ height:12px; width:10px; font-weight:bold; color:#e4e1d0; float:right; cursor:pointer; border:3px solid #e4e1d1; background-color:#F0F0F0; padding:0px 5px 4px 5px;}
.RBpopoupClose:hover{ color:#FF0000;  border:3px solid #e4e1d1; background-color:#FFFFFF;   }
.popoupHead{float:left; width:200px; margin:5px 0px 0px 10px; font-weight:bold; }
.sasclear{ clear:both; height:0px;}
.RBListTable{ border:2px inset #E6F2FF; margin-left:10px; background-color:#FCFCFC;  border-radius: 4px; }
.RBListTable td{ border-bottom:2px groove #FCFCFC;border-right:2px groove #FCFCFC; padding:3px;}
.RBListTable tr:hover{ background-color:#CCE6FF; cursor:pointer;}
</style>

<script>
var rb = new Object();
rb.programmer = "Mizanur82@gmail.com";
rb.ajaxPath='<? echo $site['url-wtos'] ; ?>rbListAndAssignAjax.php?';
rb.listByCustomerAlerts=function(refCode,rbcontactId,containerId)
{

	rb.refCode=refCode;
	rb.rbcontactId=rbcontactId;
	rb.containerId=containerId;

	var formdata = new FormData();
	formdata.append('refCode',refCode );
	formdata.append('rbcontactId',rbcontactId );
	formdata.append('containerId',containerId );

	formdata.append('RETURN','rbListHTML' );

	var url=rb.ajaxPath+'RB_GetAllREminder=OK';
	os.animateMe.div=containerId;
	os.animateMe.html='Wait..';
	os.setAjaxFunc('rb.listByCustomerOutput',url,formdata);

 }

 rb.listByCustomerOutput=function(data)
 {
  var D=data.split('[RB:SEPERATOR]');
  var containerId=rb.containerId;
  os.setHtml(containerId,D[1]);

 }

rb.popUpOpen=function(popupBoxId)
{
   os.getObj(popupBoxId).style.display='';


}
rb.popUpClose=function(popupBoxId)
{
   os.getObj(popupBoxId).style.display='none';
}

rb.addReminder=function(addStr)
{

	var refCode=rb.refCode;
	var rbcontactId=rb.rbcontactId;
	var containerId=rb.containerId;


	var formdata = new FormData();
	formdata.append('refCode',refCode );
	formdata.append('rbcontactId',rbcontactId );
	formdata.append('containerId',containerId );
	formdata.append('addStr',addStr );

	formdata.append('RETURN','rbListHTML' );

	var url=rb.ajaxPath+'RB_addNextREminder=OK';
	os.animateMe.div='rbListByCustomerPOPUP';
	os.animateMe.html='Wait..';
	os.setAjaxFunc('rb.addReminderOutput',url,formdata);

 }

 rb.addReminderOutput=function(data)
 {
  var D=data.split('[RB:SEPERATOR]');
  var containerId=rb.containerId;
  os.setHtml('rbListByCustomerPOPUP',D[1]);

 }

rb.popUpOpenAndGetData=function()
{
    rb.popUpOpen('rbAllByCustomerContainer');
	var rbcontactIdVal= os.getVal('rbcontactId');
    var refCodeVal= os.getVal('refCode');
	rb.listByCustomerAlerts(refCodeVal,rbcontactIdVal,'rbAllByCustomerContainer');
}

/*rb.calReminderStartDate=function()
{

	var expDate = os.getVal('expiryDate');
	var priorDays = os.getVal('priorDays');
	var preDate = previousDate(expDate,priorDays);
	os.setVal('reminderStartDate',preDate);
}

function previousDate(expDate,priorDays){

 		if (isNaN(priorDays) || priorDays < 1 ) {
        	alert("Input not valid Number");
    	}
		var expDate = expDate.split('-').reverse().join('-');
		var today = new Date(expDate);
		today.setDate(today.getDate()-priorDays);

		var dd=today.getDate(); dd=dd.toString(); if(dd.length==1){dd='0'+dd;}
		var mm=today.getMonth()+1; mm=mm.toString(); if(mm.length==1){mm='0'+mm;}
		var yyyy=today.getFullYear();

		if(globalDateFormat=='dd-mm-yy'){ var todayStr= dd+'-'+mm+'-'+yyyy; }
		if(globalDateFormat=='mm-dd-yy'){ var todayStr= mm+'-'+dd+'-'+yyyy; }

		return todayStr;
}*/
</script>
