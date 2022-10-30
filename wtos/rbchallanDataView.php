<?
/*
   # wtos version : 1.1
   # main ajax process page : rbchallanAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Manage Challan';
$ajaxFilePath= 'rbchallanAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbchallanDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbchallanEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Reffer Code </td>
										<td><input value="" type="text" name="refCode" id="refCode" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Challan No </td>
										<td><input value="" type="text" name="challanNo" id="challanNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Bill No </td>
										<td><input value="" type="text" name="billNo" id="billNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Challan Date </td>
										<td><input value="" type="text" name="challanDate" id="challanDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Agent Name </td>
										<td><input value="" type="text" name="agentName" id="agentName" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Agent Details </td>
										<td><input value="" type="text" name="agentDetails" id="agentDetails" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Payment Status </td>
										<td>  
	
	<select name="paymentStatus" id="paymentStatus" class="textbox fWidth" ><option value="">Select Payment Status</option>	<? 
										  $os->onlyOption($os->paymentStatusChallan);	?></select>	 </td>						
										</tr><tr >
	  									<td>note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbchallanId" value="0" />	
	<input type="hidden"  id="WT_rbchallanpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbchallanDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbchallanEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Reffer Code: <input type="text" class="wtTextClass" name="refCode_s" id="refCode_s" value="" /> &nbsp;  Challan No: <input type="text" class="wtTextClass" name="challanNo_s" id="challanNo_s" value="" /> &nbsp;  Bill No: <input type="text" class="wtTextClass" name="billNo_s" id="billNo_s" value="" /> &nbsp; From Challan Date: <input class="wtDateClass" type="text" name="f_challanDate_s" id="f_challanDate_s" value=""  /> &nbsp;   To Challan Date: <input class="wtDateClass" type="text" name="t_challanDate_s" id="t_challanDate_s" value=""  /> &nbsp;  
   Agent Name: <input type="text" class="wtTextClass" name="agentName_s" id="agentName_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbchallanListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbchallanListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbchallanListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var refCode_sVal= os.getVal('refCode_s'); 
 var challanNo_sVal= os.getVal('challanNo_s'); 
 var billNo_sVal= os.getVal('billNo_s'); 
 var f_challanDate_sVal= os.getVal('f_challanDate_s'); 
 var t_challanDate_sVal= os.getVal('t_challanDate_s'); 
 var agentName_sVal= os.getVal('agentName_s'); 
formdata.append('refCode_s',refCode_sVal );
formdata.append('challanNo_s',challanNo_sVal );
formdata.append('billNo_s',billNo_sVal );
formdata.append('f_challanDate_s',f_challanDate_sVal );
formdata.append('t_challanDate_s',t_challanDate_sVal );
formdata.append('agentName_s',agentName_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbchallanpagingPageno=os.getVal('WT_rbchallanpagingPageno');
	var url='wtpage='+WT_rbchallanpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbchallanListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbchallanListDiv',url,formdata);
		
}

WT_rbchallanListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('refCode_s',''); 
 os.setVal('challanNo_s',''); 
 os.setVal('billNo_s',''); 
 os.setVal('f_challanDate_s',''); 
 os.setVal('t_challanDate_s',''); 
 os.setVal('agentName_s',''); 
	
		os.setVal('searchKey','');
		WT_rbchallanListing();	
	
	}
	
 
function WT_rbchallanEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var refCodeVal= os.getVal('refCode'); 
var challanNoVal= os.getVal('challanNo'); 
var billNoVal= os.getVal('billNo'); 
var challanDateVal= os.getVal('challanDate'); 
var agentNameVal= os.getVal('agentName'); 
var agentDetailsVal= os.getVal('agentDetails'); 
var paymentStatusVal= os.getVal('paymentStatus'); 
var noteVal= os.getVal('note'); 


 formdata.append('refCode',refCodeVal );
 formdata.append('challanNo',challanNoVal );
 formdata.append('billNo',billNoVal );
 formdata.append('challanDate',challanDateVal );
 formdata.append('agentName',agentNameVal );
 formdata.append('agentDetails',agentDetailsVal );
 formdata.append('paymentStatus',paymentStatusVal );
 formdata.append('note',noteVal );

	
if(os.check.empty('refCode','Please Add Reffer Code')==false){ return false;} 
if(os.check.empty('challanNo','Please Add Challan No')==false){ return false;} 
if(os.check.empty('billNo','Please Add Bill No')==false){ return false;} 
if(os.check.empty('challanDate','Please Add Challan Date')==false){ return false;} 

	 var   rbchallanId=os.getVal('rbchallanId');
	 formdata.append('rbchallanId',rbchallanId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbchallanEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbchallanReLoadList',url,formdata);

}	

function WT_rbchallanReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbchallanId=parseInt(d[0]);
	if(d[0]!='Error' && rbchallanId>0)
	{
	  os.setVal('rbchallanId',rbchallanId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbchallanListing();
}

function WT_rbchallanGetById(rbchallanId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbchallanId',rbchallanId );
	var url='<? echo $ajaxFilePath ?>?WT_rbchallanGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbchallanFillData',url,formdata);
				
}

function WT_rbchallanFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbchallanId',parseInt(objJSON.rbchallanId));
	
 os.setVal('refCode',objJSON.refCode); 
 os.setVal('challanNo',objJSON.challanNo); 
 os.setVal('billNo',objJSON.billNo); 
 os.setVal('challanDate',objJSON.challanDate); 
 os.setVal('agentName',objJSON.agentName); 
 os.setVal('agentDetails',objJSON.agentDetails); 
 os.setVal('paymentStatus',objJSON.paymentStatus); 
 os.setVal('note',objJSON.note); 

  
}

function WT_rbchallanDeleteRowById(rbchallanId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbchallanId)<1 || rbchallanId==''){  
	var  rbchallanId =os.getVal('rbchallanId');
	}
	
	if(parseInt(rbchallanId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbchallanId',rbchallanId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbchallanDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbchallanDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbchallanDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbchallanListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbchallanpagingPageno',parseInt(pageNo));
	WT_rbchallanListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>