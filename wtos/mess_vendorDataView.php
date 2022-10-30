<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_vendorAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Mess Vendor';
$ajaxFilePath= 'mess_vendorAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_vendorDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_vendorEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Vendor Name </td>
										<td><input value="" type="text" name="vendor_name" id="vendor_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Mobile </td>
										<td><input value="" type="text" name="mobile" id="mobile" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><input value="" type="text" name="address" id="address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Active Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Active Status</option>	<? 
										  $os->onlyOption($os->mess_vendor_active_status);	?></select>	 </td>						
										</tr><tr >
	  									<td>Branch Code </td>
										<td> <select name="branch_code" id="branch_code" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="mess_vendor_id" value="0" />	
	<input type="hidden"  id="WT_mess_vendorpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_vendorDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_vendorEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	
	Added By:	
	<select name="addedBy_s" id="addedBy_s" class="textbox fWidth" ><option value=""></option><?$os->optionsHTML('','adminId','name','admin');?>
	</select>  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Vendor Name: <input type="text" class="wtTextClass" name="vendor_name_s" id="vendor_name_s" value="" /> &nbsp;  Mobile: <input type="text" class="wtTextClass" name="mobile_s" id="mobile_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Active Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Active Status</option>	<? 
										  $os->onlyOption($os->mess_vendor_active_status);	?></select>	
   Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_vendorListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_vendorListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_vendorListing() // list table searched data get 
{
		var formdata = new FormData();
		var vendor_name_sVal= os.getVal('vendor_name_s'); 
		var mobile_sVal= os.getVal('mobile_s'); 
		var email_sVal= os.getVal('email_s'); 
		var address_sVal= os.getVal('address_s'); 
		var active_status_sVal= os.getVal('active_status_s'); 
		var branch_code_sVal= os.getVal('branch_code_s'); 
		var note_sVal= os.getVal('note_s'); 


		var addedBy_sVal=os.getVal('addedBy_s');
		formdata.append('addedBy_s',addedBy_sVal);


		formdata.append('vendor_name_s',vendor_name_sVal );
		formdata.append('mobile_s',mobile_sVal );
		formdata.append('email_s',email_sVal );
		formdata.append('address_s',address_sVal );
		formdata.append('active_status_s',active_status_sVal );
		formdata.append('branch_code_s',branch_code_sVal );
		formdata.append('note_s',note_sVal );
		formdata.append('searchKey',os.getVal('searchKey') );
		formdata.append('showPerPage',os.getVal('showPerPage') );
		var WT_mess_vendorpagingPageno=os.getVal('WT_mess_vendorpagingPageno');
		var url='wtpage='+WT_mess_vendorpagingPageno;
		url='<? echo $ajaxFilePath ?>?WT_mess_vendorListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_mess_vendorListDiv',url,formdata);
		
}

WT_mess_vendorListing();
function  searchReset(){
		os.setVal('addedBy_s','');
		os.setVal('vendor_name_s',''); 
		os.setVal('mobile_s',''); 
		os.setVal('email_s',''); 
		os.setVal('address_s',''); 
		os.setVal('active_status_s',''); 
		os.setVal('branch_code_s',''); 
		os.setVal('note_s',''); 
		os.setVal('searchKey','');
		WT_mess_vendorListing();	
}
	
 
function WT_mess_vendorEditAndSave(){

		var formdata = new FormData();
		var vendor_nameVal= os.getVal('vendor_name'); 
		var mobileVal= os.getVal('mobile'); 
		var emailVal= os.getVal('email'); 
		var addressVal= os.getVal('address'); 
		var active_statusVal= os.getVal('active_status'); 
		var branch_codeVal= os.getVal('branch_code'); 
		var noteVal= os.getVal('note'); 
		formdata.append('vendor_name',vendor_nameVal );
		formdata.append('mobile',mobileVal );
		formdata.append('email',emailVal );
		formdata.append('address',addressVal );
		formdata.append('active_status',active_statusVal );
		formdata.append('branch_code',branch_codeVal );
		formdata.append('note',noteVal );
		var   mess_vendor_id=os.getVal('mess_vendor_id');
		formdata.append('mess_vendor_id',mess_vendor_id );
		var url='<? echo $ajaxFilePath ?>?WT_mess_vendorEditAndSave=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_mess_vendorReLoadList',url,formdata);

}	

function WT_mess_vendorReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_vendor_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_vendor_id>0)
	{
	  os.setVal('mess_vendor_id',mess_vendor_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_vendorListing();
}

function WT_mess_vendorGetById(mess_vendor_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_vendor_id',mess_vendor_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_vendorGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_vendorFillData',url,formdata);
				
}

function WT_mess_vendorFillData(data){
		var objJSON = JSON.parse(data);
		os.setVal('mess_vendor_id',parseInt(objJSON.mess_vendor_id));
		os.setVal('vendor_name',objJSON.vendor_name); 
		os.setVal('mobile',objJSON.mobile); 
		os.setVal('email',objJSON.email); 
		os.setVal('address',objJSON.address); 
		os.setVal('active_status',objJSON.active_status); 
		os.setVal('branch_code',objJSON.branch_code); 
		os.setVal('note',objJSON.note);  
}

function WT_mess_vendorDeleteRowById(mess_vendor_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_vendor_id)<1 || mess_vendor_id==''){  
	var  mess_vendor_id =os.getVal('mess_vendor_id');
	}
	
	if(parseInt(mess_vendor_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_vendor_id',mess_vendor_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_vendorDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_vendorDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_vendorDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_vendorListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_vendorpagingPageno',parseInt(pageNo));
	WT_mess_vendorListing();
}
</script>
<? include($site['root-wtos'].'bottom.php'); ?>