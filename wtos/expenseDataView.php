<?
/*
   # wtos version : 1.1
   # main ajax process page : expenseAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List expense';
$ajaxFilePath= 'expenseAjax.php';
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
	<? if($os->checkAccess('Delete Expense')){ ?><input type="button" value="Delete"  onclick="checkEditDeletePassword('');"  /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_expenseEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Expense Head </td>
										<td> <select name="expenseHead" id="expenseHead" class="textbox fWidth" onchange="setExpenseTextBoxVal();"><option value="">Select Expense Head</option>		  	<? 
								
										  $os->optionsHTML('','expenseHead','expenseHead','expense');?>
							            </select> </td>	
                                        <td><input value="" type="text" name="expenseHeadTextBox" id="expenseHeadTextBox" class="textboxxx  fWidth "/> </td>						
                            							
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Expense Details </td>
										<td><textarea  name="expenseDetails" id="expenseDetails" ></textarea></td>						
										</tr><tr >
	  									<td>Amount </td>
										<td><input value="" type="text" name="amount" id="amount" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Expence To </td>
										<td><input value="" type="text" name="expenceTo" id="expenceTo" class="textboxxx  fWidth "/> </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="expenseId" value="0" />	
	<input type="hidden"  id="WT_expensepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->checkAccess('Delete Expense')){ ?><input type="button" value="Delete"  onclick="checkEditDeletePassword('');"  />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_expenseEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
  From Date: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Expense Head:
	
	
	<select name="expenseHead" id="expenseHead_s" class="textbox fWidth" ><option value="">Select Expense Head</option>		  	<? 
								
										  $os->optionsHTML('','expenseHead','expenseHead','expense');?>
							</select>
   Expense Details: <input type="text" class="wtTextClass" name="expenseDetails_s" id="expenseDetails_s" value="" /> &nbsp;  Amount: <input type="text" class="wtTextClass" name="amount_s" id="amount_s" value="" /> &nbsp;  Expence To: <input type="text" class="wtTextClass" name="expenceTo_s" id="expenceTo_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_expenseListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   &nbsp;  <input type="button" value="Download Excel" style="cursor:pointer" onclick="window.location='expenseExcel.php'"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_expenseListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 function setExpenseTextBoxVal() 
{
 var expenseHeadVal= os.getVal('expenseHead'); 
 
 os.setVal('expenseHeadTextBox',expenseHeadVal); 
	
}
 
 
function WT_expenseListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var expenseHead_sVal= os.getVal('expenseHead_s'); 
 var f_dated_sVal= os.getVal('f_dated_s'); 
 var t_dated_sVal= os.getVal('t_dated_s'); 
 var expenseDetails_sVal= os.getVal('expenseDetails_s'); 
 var amount_sVal= os.getVal('amount_s'); 
 var expenceTo_sVal= os.getVal('expenceTo_s'); 
formdata.append('expenseHead_s',expenseHead_sVal );
formdata.append('f_dated_s',f_dated_sVal );
formdata.append('t_dated_s',t_dated_sVal );
formdata.append('expenseDetails_s',expenseDetails_sVal );
formdata.append('amount_s',amount_sVal );
formdata.append('expenceTo_s',expenceTo_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_expensepagingPageno=os.getVal('WT_expensepagingPageno');
	var url='wtpage='+WT_expensepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_expenseListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_expenseListDiv',url,formdata);
		
}

WT_expenseListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('expenseHead_s',''); 
 os.setVal('f_dated_s',''); 
 os.setVal('t_dated_s',''); 
 os.setVal('expenseDetails_s',''); 
 os.setVal('amount_s',''); 
 os.setVal('expenceTo_s',''); 
	
		os.setVal('searchKey','');
		WT_expenseListing();	
	
	}
	
 
function WT_expenseEditAndSave()  // collect data and send to save
{
        
var formdata = new FormData();
//var expenseHeadVal= os.getVal('expenseHead');
var expenseHeadTextBoxVal= os.getVal('expenseHeadTextBox'); 
var datedVal= os.getVal('dated'); 
var expenseDetailsVal= os.getVal('expenseDetails'); 
var amountVal= os.getVal('amount'); 
var expenceToVal= os.getVal('expenceTo'); 
//formdata.append('expenseHead',expenseHeadVal );
formdata.append('expenseHeadTextBox',expenseHeadTextBoxVal );
formdata.append('dated',datedVal );
formdata.append('expenseDetails',expenseDetailsVal );
formdata.append('amount',amountVal );
formdata.append('expenceTo',expenceToVal );
var   expenseId=os.getVal('expenseId');





if(expenseId==0)
{
var addExpenseAccess='<? echo $os->checkAccess('Add Expense') ?>';
if(addExpenseAccess=='')
{
alert('You dont have access for add');
return false;
}

}




if(os.check.empty('expenseHeadTextBox','Please Add Expense Head')==false){ return false;} 
if(os.check.empty('dated','Please Add Date')==false){ return false;} 



formdata.append('expenseId',expenseId );
var url='<? echo $ajaxFilePath ?>?WT_expenseEditAndSave=OK&';
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
os.setAjaxFunc('WT_expenseReLoadList',url,formdata);

}	

function WT_expenseReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var expenseId=parseInt(d[0]);
	if(d[0]!='Error' && expenseId>0)
	{
	  os.setVal('expenseId',expenseId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_expenseListing();
}





function checkEditDeletePassword(expenseId)
{
	
	
	var formdata = new FormData();	
	
	if(parseInt(expenseId)<1 || expenseId==''){  
	
	var  expenseId =os.getVal('expenseId');
	formdata.append('operationType','deleteData');
	
	}
	
	
	
	
	var password= prompt("Please Enter Password");
	if(password)
	{

	formdata.append('expenseId',expenseId );
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
		var expenseId=parseInt(d[1]);
		
		
		
		
		var operationType=d[2];
		
		if(operationType=='Edit Data')
		{
		WT_expenseGetById(expenseId);
		}
		if(operationType=='Delete Data')
		{
			WT_expenseDeleteRowById(expenseId);
		}
		
		
		
		
	}
	
}




function WT_expenseGetById(expenseId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('expenseId',expenseId );
	var url='<? echo $ajaxFilePath ?>?WT_expenseGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_expenseFillData',url,formdata);
				
}

function WT_expenseFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('expenseId',parseInt(objJSON.expenseId));
	
 os.setVal('expenseHead',objJSON.expenseHead); 
  os.setVal('expenseHeadTextBox',objJSON.expenseHead);
 os.setVal('dated',objJSON.dated); 
 os.setVal('expenseDetails',objJSON.expenseDetails); 
 os.setVal('amount',objJSON.amount); 
 os.setVal('expenceTo',objJSON.expenceTo); 

  
}

function WT_expenseDeleteRowById(expenseId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(expenseId)<1 || expenseId==''){  
	var  expenseId =os.getVal('expenseId');
	}
	
	if(parseInt(expenseId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('expenseId',expenseId );
	
	var url='<? echo $ajaxFilePath ?>?WT_expenseDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_expenseDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_expenseDeleteRowByIdResults(data)
{
	alert(data);
	WT_expenseListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_expensepagingPageno',parseInt(pageNo));
	WT_expenseListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>