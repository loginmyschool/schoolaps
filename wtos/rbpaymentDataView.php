<?
/*
   # wtos version : 1.1
   # main ajax process page : rbpaymentAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List rbpayment';
$ajaxFilePath= 'rbpaymentAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
?>
  

 <table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbpaymentDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbpaymentEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>paidAmount </td>
										<td><input value="" type="text" name="paidAmount" id="paidAmount" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>paidDate </td>
										<td><input value="" type="text" name="paidDate" id="paidDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>method </td>
										<td><input value="" type="text" name="method" id="method" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>remarks </td>
										<td><input value="" type="text" name="remarks" id="remarks" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbpaymentId" value="0" />	
	<input type="hidden"  id="WT_rbpaymentpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbpaymentDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbpaymentEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 rbreminderId:
	
	
	<select name="rbreminderId" id="rbreminderId_s" class="textbox fWidth" ><option value="">Select rbreminderId</option>		  	<? 
								
										  $os->optionsHTML('','rbreminderId','reminderType','rbreminder');?>
							</select>
   paidAmount: <input type="text" class="wtTextClass" name="paidAmount_s" id="paidAmount_s" value="" /> &nbsp; From paidDate: <input class="wtDateClass" type="text" name="f_paidDate_s" id="f_paidDate_s" value=""  /> &nbsp;   To paidDate: <input class="wtDateClass" type="text" name="t_paidDate_s" id="t_paidDate_s" value=""  /> &nbsp;  
   method: <input type="text" class="wtTextClass" name="method_s" id="method_s" value="" /> &nbsp;  remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbpaymentListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbpaymentListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbpaymentListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var rbreminderId_sVal= os.getVal('rbreminderId_s'); 
 var paidAmount_sVal= os.getVal('paidAmount_s'); 
 var f_paidDate_sVal= os.getVal('f_paidDate_s'); 
 var t_paidDate_sVal= os.getVal('t_paidDate_s'); 
 var method_sVal= os.getVal('method_s'); 
 var remarks_sVal= os.getVal('remarks_s'); 
formdata.append('rbreminderId_s',rbreminderId_sVal );
formdata.append('paidAmount_s',paidAmount_sVal );
formdata.append('f_paidDate_s',f_paidDate_sVal );
formdata.append('t_paidDate_s',t_paidDate_sVal );
formdata.append('method_s',method_sVal );
formdata.append('remarks_s',remarks_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbpaymentpagingPageno=os.getVal('WT_rbpaymentpagingPageno');
	var url='wtpage='+WT_rbpaymentpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbpaymentListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbpaymentListDiv',url,formdata);
		
}

WT_rbpaymentListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('rbreminderId_s',''); 
 os.setVal('paidAmount_s',''); 
 os.setVal('f_paidDate_s',''); 
 os.setVal('t_paidDate_s',''); 
 os.setVal('method_s',''); 
 os.setVal('remarks_s',''); 
	
		os.setVal('searchKey','');
		WT_rbpaymentListing();	
	
	}
	
 
function WT_rbpaymentEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var paidAmountVal= os.getVal('paidAmount'); 
var paidDateVal= os.getVal('paidDate'); 
var methodVal= os.getVal('method'); 
var remarksVal= os.getVal('remarks'); 


 formdata.append('paidAmount',paidAmountVal );
 formdata.append('paidDate',paidDateVal );
 formdata.append('method',methodVal );
 formdata.append('remarks',remarksVal );

	

	 var   rbpaymentId=os.getVal('rbpaymentId');
	 formdata.append('rbpaymentId',rbpaymentId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbpaymentEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbpaymentReLoadList',url,formdata);

}	

function WT_rbpaymentReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbpaymentId=parseInt(d[0]);
	if(d[0]!='Error' && rbpaymentId>0)
	{
	  os.setVal('rbpaymentId',rbpaymentId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbpaymentListing();
}

function WT_rbpaymentGetById(rbpaymentId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbpaymentId',rbpaymentId );
	var url='<? echo $ajaxFilePath ?>?WT_rbpaymentGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbpaymentFillData',url,formdata);
				
}

function WT_rbpaymentFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbpaymentId',parseInt(objJSON.rbpaymentId));
	
 os.setVal('paidAmount',objJSON.paidAmount); 
 os.setVal('paidDate',objJSON.paidDate); 
 os.setVal('method',objJSON.method); 
 os.setVal('remarks',objJSON.remarks); 

  
}

function WT_rbpaymentDeleteRowById(rbpaymentId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbpaymentId)<1 || rbpaymentId==''){  
	var  rbpaymentId =os.getVal('rbpaymentId');
	}
	
	if(parseInt(rbpaymentId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbpaymentId',rbpaymentId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbpaymentDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbpaymentDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbpaymentDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbpaymentListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbpaymentpagingPageno',parseInt(pageNo));
	WT_rbpaymentListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>