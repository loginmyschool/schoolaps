<?
/*
   # wtos version : 1.1
   # main ajax process page : guardianAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='List guardian';
$ajaxFilePath= 'guardianAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_guardianDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_guardianEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Join Date </td>
										<td><input value="" type="text" name="joinDate" id="joinDate" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Permanent Address </td>
										<td><textarea  name="permanentAddress" id="permanentAddress" ></textarea></td>						
										</tr><tr >
	  									<td>Recent Address </td>
										<td><textarea  name="recentAddress" id="recentAddress" ></textarea></td>						
										</tr><tr >
	  									<td>Mobile </td>
										<td><input value="" type="text" name="mobile" id="mobile" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Note </td>
										<td><textarea  name="note" id="note" ></textarea></td>						
										</tr><tr >
	  									<td>Otp Pass </td>
										<td><input value="" type="text" name="otpPass" id="otpPass" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Relation </td>
										<td><input value="" type="text" name="relation" id="relation" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Student Name </td>
										<td><input value="" type="text" name="studentName" id="studentName" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Class </td>
										<td>  
	
	<select name="class" id="class" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr><tr >
	  									<td>Student Id </td>
										<td><input value="" type="text" name="studentId" id="studentId" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->guardianStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="guardianId" value="0" />	
	<input type="hidden"  id="WT_guardianpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_guardianDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_guardianEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp; From Join Date: <input class="wtDateClass" type="text" name="f_joinDate_s" id="f_joinDate_s" value=""  /> &nbsp;   To Join Date: <input class="wtDateClass" type="text" name="t_joinDate_s" id="t_joinDate_s" value=""  /> &nbsp;  
   Permanent Address: <input type="text" class="wtTextClass" name="permanentAddress_s" id="permanentAddress_s" value="" /> &nbsp;  Recent Address: <input type="text" class="wtTextClass" name="recentAddress_s" id="recentAddress_s" value="" /> &nbsp;  Mobile: <input type="text" class="wtTextClass" name="mobile_s" id="mobile_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  Otp Pass: <input type="text" class="wtTextClass" name="otpPass_s" id="otpPass_s" value="" /> &nbsp;  Relation: <input type="text" class="wtTextClass" name="relation_s" id="relation_s" value="" /> &nbsp;  Student Name: <input type="text" class="wtTextClass" name="studentName_s" id="studentName_s" value="" /> &nbsp;  Class:
	
	<select name="class" id="class_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	
   Student Id: <input type="text" class="wtTextClass" name="studentId_s" id="studentId_s" value="" /> &nbsp;  Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->guardianStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_guardianListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_guardianListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_guardianListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var f_joinDate_sVal= os.getVal('f_joinDate_s'); 
 var t_joinDate_sVal= os.getVal('t_joinDate_s'); 
 var permanentAddress_sVal= os.getVal('permanentAddress_s'); 
 var recentAddress_sVal= os.getVal('recentAddress_s'); 
 var mobile_sVal= os.getVal('mobile_s'); 
 var email_sVal= os.getVal('email_s'); 
 var note_sVal= os.getVal('note_s'); 
 var otpPass_sVal= os.getVal('otpPass_s'); 
 var relation_sVal= os.getVal('relation_s'); 
 var studentName_sVal= os.getVal('studentName_s'); 
 var class_sVal= os.getVal('class_s'); 
 var studentId_sVal= os.getVal('studentId_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('name_s',name_sVal );
formdata.append('f_joinDate_s',f_joinDate_sVal );
formdata.append('t_joinDate_s',t_joinDate_sVal );
formdata.append('permanentAddress_s',permanentAddress_sVal );
formdata.append('recentAddress_s',recentAddress_sVal );
formdata.append('mobile_s',mobile_sVal );
formdata.append('email_s',email_sVal );
formdata.append('note_s',note_sVal );
formdata.append('otpPass_s',otpPass_sVal );
formdata.append('relation_s',relation_sVal );
formdata.append('studentName_s',studentName_sVal );
formdata.append('class_s',class_sVal );
formdata.append('studentId_s',studentId_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_guardianpagingPageno=os.getVal('WT_guardianpagingPageno');
	var url='wtpage='+WT_guardianpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_guardianListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_guardianListDiv',url,formdata);
		
}

WT_guardianListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('f_joinDate_s',''); 
 os.setVal('t_joinDate_s',''); 
 os.setVal('permanentAddress_s',''); 
 os.setVal('recentAddress_s',''); 
 os.setVal('mobile_s',''); 
 os.setVal('email_s',''); 
 os.setVal('note_s',''); 
 os.setVal('otpPass_s',''); 
 os.setVal('relation_s',''); 
 os.setVal('studentName_s',''); 
 os.setVal('class_s',''); 
 os.setVal('studentId_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_guardianListing();	
	
	}
	
 
function WT_guardianEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var joinDateVal= os.getVal('joinDate'); 
var permanentAddressVal= os.getVal('permanentAddress'); 
var recentAddressVal= os.getVal('recentAddress'); 
var mobileVal= os.getVal('mobile'); 
var emailVal= os.getVal('email'); 
var noteVal= os.getVal('note'); 
var otpPassVal= os.getVal('otpPass'); 
var relationVal= os.getVal('relation'); 
var studentNameVal= os.getVal('studentName'); 
var classVal= os.getVal('class'); 
var studentIdVal= os.getVal('studentId'); 
var statusVal= os.getVal('status'); 


 formdata.append('name',nameVal );
 formdata.append('joinDate',joinDateVal );
 formdata.append('permanentAddress',permanentAddressVal );
 formdata.append('recentAddress',recentAddressVal );
 formdata.append('mobile',mobileVal );
 formdata.append('email',emailVal );
 formdata.append('note',noteVal );
 formdata.append('otpPass',otpPassVal );
 formdata.append('relation',relationVal );
 formdata.append('studentName',studentNameVal );
 formdata.append('class',classVal );
 formdata.append('studentId',studentIdVal );
 formdata.append('status',statusVal );

	

	 var   guardianId=os.getVal('guardianId');
	 formdata.append('guardianId',guardianId );
  	var url='<? echo $ajaxFilePath ?>?WT_guardianEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_guardianReLoadList',url,formdata);

}	

function WT_guardianReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var guardianId=parseInt(d[0]);
	if(d[0]!='Error' && guardianId>0)
	{
	  os.setVal('guardianId',guardianId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_guardianListing();
}

function WT_guardianGetById(guardianId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('guardianId',guardianId );
	var url='<? echo $ajaxFilePath ?>?WT_guardianGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_guardianFillData',url,formdata);
				
}

function WT_guardianFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('guardianId',parseInt(objJSON.guardianId));
	
 os.setVal('name',objJSON.name); 
 os.setVal('joinDate',objJSON.joinDate); 
 os.setVal('permanentAddress',objJSON.permanentAddress); 
 os.setVal('recentAddress',objJSON.recentAddress); 
 os.setVal('mobile',objJSON.mobile); 
 os.setVal('email',objJSON.email); 
 os.setVal('note',objJSON.note); 
 os.setVal('otpPass',objJSON.otpPass); 
 os.setVal('relation',objJSON.relation); 
 os.setVal('studentName',objJSON.studentName); 
 os.setVal('class',objJSON.class); 
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('status',objJSON.status); 

  
}

function WT_guardianDeleteRowById(guardianId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(guardianId)<1 || guardianId==''){  
	var  guardianId =os.getVal('guardianId');
	}
	
	if(parseInt(guardianId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('guardianId',guardianId );
	
	var url='<? echo $ajaxFilePath ?>?WT_guardianDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_guardianDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_guardianDeleteRowByIdResults(data)
{
	alert(data);
	WT_guardianListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_guardianpagingPageno',parseInt(pageNo));
	WT_guardianListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>