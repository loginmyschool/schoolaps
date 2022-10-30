<?
/*
   # wtos version : 1.1
   # main ajax process page : rbcertificateAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='Manage Certificate';
$ajaxFilePath= 'rbcertificateAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcertificateDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_rbcertificateEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Contacts </td>
										<td> <select name="rbcontactId" id="rbcontactId" class="textbox fWidth" ><option value="">Select Contacts</option>		  	<? 
								
										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select> </td>						
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="certificateDate" id="certificateDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Months </td>
										<td><input value="" type="text" name="certificateMonths" id="certificateMonths" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Installed Date </td>
										<td><input value="" type="text" name="instalationDate" id="instalationDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Warenty Up To  </td>
										<td><input value="" type="text" name="warrentyUpTo" id="warrentyUpTo" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Certificate No </td>
										<td><input value="" type="text" name="certificateNo" id="certificateNo" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="rbcertificateId" value="0" />	
	<input type="hidden"  id="WT_rbcertificatepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_rbcertificateDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_rbcertificateEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Contacts:
	
	
	<select name="rbcontactId" id="rbcontactId_s" class="textbox fWidth" ><option value="">Select Contacts</option>		  	<? 
								
										  $os->optionsHTML('','rbcontactId','person','rbcontact');?>
							</select>
  From Installed Date: <input class="wtDateClass" type="text" name="f_instalationDate_s" id="f_instalationDate_s" value=""  /> &nbsp;   To Installed Date: <input class="wtDateClass" type="text" name="t_instalationDate_s" id="t_instalationDate_s" value=""  /> &nbsp;  
  From Warenty Up To : <input class="wtDateClass" type="text" name="f_warrentyUpTo_s" id="f_warrentyUpTo_s" value=""  /> &nbsp;   To Warenty Up To : <input class="wtDateClass" type="text" name="t_warrentyUpTo_s" id="t_warrentyUpTo_s" value=""  /> &nbsp;  
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_rbcertificateListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_rbcertificateListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_rbcertificateListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var rbcontactId_sVal= os.getVal('rbcontactId_s'); 
 var f_instalationDate_sVal= os.getVal('f_instalationDate_s'); 
 var t_instalationDate_sVal= os.getVal('t_instalationDate_s'); 
 var f_warrentyUpTo_sVal= os.getVal('f_warrentyUpTo_s'); 
 var t_warrentyUpTo_sVal= os.getVal('t_warrentyUpTo_s'); 
formdata.append('rbcontactId_s',rbcontactId_sVal );
formdata.append('f_instalationDate_s',f_instalationDate_sVal );
formdata.append('t_instalationDate_s',t_instalationDate_sVal );
formdata.append('f_warrentyUpTo_s',f_warrentyUpTo_sVal );
formdata.append('t_warrentyUpTo_s',t_warrentyUpTo_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_rbcertificatepagingPageno=os.getVal('WT_rbcertificatepagingPageno');
	var url='wtpage='+WT_rbcertificatepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_rbcertificateListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_rbcertificateListDiv',url,formdata);
		
}

WT_rbcertificateListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('rbcontactId_s',''); 
 os.setVal('f_instalationDate_s',''); 
 os.setVal('t_instalationDate_s',''); 
 os.setVal('f_warrentyUpTo_s',''); 
 os.setVal('t_warrentyUpTo_s',''); 
	
		os.setVal('searchKey','');
		WT_rbcertificateListing();	
	
	}
	
 
function WT_rbcertificateEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var rbcontactIdVal= os.getVal('rbcontactId'); 
var certificateDateVal= os.getVal('certificateDate'); 
var certificateMonthsVal= os.getVal('certificateMonths'); 
var instalationDateVal= os.getVal('instalationDate'); 
var warrentyUpToVal= os.getVal('warrentyUpTo'); 
var certificateNoVal= os.getVal('certificateNo'); 
var noteVal= os.getVal('note'); 


 formdata.append('rbcontactId',rbcontactIdVal );
 formdata.append('certificateDate',certificateDateVal );
 formdata.append('certificateMonths',certificateMonthsVal );
 formdata.append('instalationDate',instalationDateVal );
 formdata.append('warrentyUpTo',warrentyUpToVal );
 formdata.append('certificateNo',certificateNoVal );
 formdata.append('note',noteVal );

	
if(os.check.empty('certificateDate','Please Add Date')==false){ return false;} 
if(os.check.empty('certificateMonths','Please Add Months')==false){ return false;} 
if(os.check.empty('instalationDate','Please Add Installed Date')==false){ return false;} 
if(os.check.empty('warrentyUpTo','Please Add Warenty Up To ')==false){ return false;} 

	 var   rbcertificateId=os.getVal('rbcertificateId');
	 formdata.append('rbcertificateId',rbcertificateId );
  	var url='<? echo $ajaxFilePath ?>?WT_rbcertificateEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcertificateReLoadList',url,formdata);

}	

function WT_rbcertificateReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var rbcertificateId=parseInt(d[0]);
	if(d[0]!='Error' && rbcertificateId>0)
	{
	  os.setVal('rbcertificateId',rbcertificateId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_rbcertificateListing();
}

function WT_rbcertificateGetById(rbcertificateId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('rbcertificateId',rbcertificateId );
	var url='<? echo $ajaxFilePath ?>?WT_rbcertificateGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcertificateFillData',url,formdata);
				
}

function WT_rbcertificateFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('rbcertificateId',parseInt(objJSON.rbcertificateId));
	
 os.setVal('rbcontactId',objJSON.rbcontactId); 
 os.setVal('certificateDate',objJSON.certificateDate); 
 os.setVal('certificateMonths',objJSON.certificateMonths); 
 os.setVal('instalationDate',objJSON.instalationDate); 
 os.setVal('warrentyUpTo',objJSON.warrentyUpTo); 
 os.setVal('certificateNo',objJSON.certificateNo); 
 os.setVal('note',objJSON.note); 

  
}

function WT_rbcertificateDeleteRowById(rbcertificateId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(rbcertificateId)<1 || rbcertificateId==''){  
	var  rbcertificateId =os.getVal('rbcertificateId');
	}
	
	if(parseInt(rbcertificateId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('rbcertificateId',rbcertificateId );
	
	var url='<? echo $ajaxFilePath ?>?WT_rbcertificateDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_rbcertificateDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_rbcertificateDeleteRowByIdResults(data)
{
	alert(data);
	WT_rbcertificateListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_rbcertificatepagingPageno',parseInt(pageNo));
	WT_rbcertificateListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>