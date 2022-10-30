<?
/*
   # wtos version : 1.1
   # main ajax process page : rbvenderAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Manage Vendor';
$ajaxFilePath= 'rbvenderAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbvenderDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbvenderEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Phone </td>
										<td><input value="" type="text" name="phone" id="phone" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Address </td>
										<td><input value="" type="text" name="address" id="address" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Contat Person </td>
										<td><input value="" type="text" name="contatPerson" id="contatPerson" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbvenderId" value="0" />	
	<input type="hidden"  id="WT_rbvenderpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbvenderDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbvenderEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Phone: <input type="text" class="wtTextClass" name="phone_s" id="phone_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Contat Person: <input type="text" class="wtTextClass" name="contatPerson_s" id="contatPerson_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbvenderListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbvenderListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbvenderListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var phone_sVal= os.getVal('phone_s'); 
 var email_sVal= os.getVal('email_s'); 
 var contatPerson_sVal= os.getVal('contatPerson_s'); 
 var note_sVal= os.getVal('note_s'); 
formdata.append('name_s',name_sVal );
formdata.append('phone_s',phone_sVal );
formdata.append('email_s',email_sVal );
formdata.append('contatPerson_s',contatPerson_sVal );
formdata.append('note_s',note_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbvenderpagingPageno=os.getVal('WT_rbvenderpagingPageno');
	var url='wtpage='+WT_rbvenderpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbvenderListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbvenderListDiv',url,formdata);
		
}

WT_rbvenderListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('phone_s',''); 
 os.setVal('email_s',''); 
 os.setVal('contatPerson_s',''); 
 os.setVal('note_s',''); 
	
		os.setVal('searchKey','');
		WT_rbvenderListing();	
	
	}
	
 
function WT_rbvenderEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var phoneVal= os.getVal('phone'); 
var emailVal= os.getVal('email'); 
var addressVal= os.getVal('address'); 
var contatPersonVal= os.getVal('contatPerson'); 
var noteVal= os.getVal('note'); 


 formdata.append('name',nameVal );
 formdata.append('phone',phoneVal );
 formdata.append('email',emailVal );
 formdata.append('address',addressVal );
 formdata.append('contatPerson',contatPersonVal );
 formdata.append('note',noteVal );

	
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('phone','Please Add Phone')==false){ return false;} 
if(os.check.empty('email','Please Add Email')==false){ return false;} 
if(os.check.empty('address','Please Add Address')==false){ return false;} 
if(os.check.empty('contatPerson','Please Add Contat Person')==false){ return false;} 

	 var   rbvenderId=os.getVal('rbvenderId');
	 formdata.append('rbvenderId',rbvenderId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbvenderEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbvenderReLoadList',url,formdata);

}	

function WT_rbvenderReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbvenderId=parseInt(d[0]);
	if(d[0]!='Error' && rbvenderId>0)
	{
	  os.setVal('rbvenderId',rbvenderId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbvenderListing();
}

function WT_rbvenderGetById(rbvenderId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbvenderId',rbvenderId );
	var url='<? echo $ajaxFilePath ?>?WT_rbvenderGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbvenderFillData',url,formdata);
				
}

function WT_rbvenderFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbvenderId',parseInt(objJSON.rbvenderId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('phone',objJSON.phone); 
 os.setVal('email',objJSON.email); 
 os.setVal('address',objJSON.address); 
 os.setVal('contatPerson',objJSON.contatPerson); 
 os.setVal('note',objJSON.note); 

  
}

function WT_rbvenderDeleteRowById(rbvenderId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbvenderId)<1 || rbvenderId==''){  
	var  rbvenderId =os.getVal('rbvenderId');
	}
	
	if(parseInt(rbvenderId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbvenderId',rbvenderId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbvenderDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbvenderDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbvenderDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbvenderListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbvenderpagingPageno',parseInt(pageNo));
	WT_rbvenderListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>