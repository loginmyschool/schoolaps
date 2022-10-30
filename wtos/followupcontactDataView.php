<?
/*
   # wtos version : 1.1
   # main ajax process page : followupcontactAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List followupcontact';
$ajaxFilePath= 'followupcontactAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
?>
 <style>
 .noteClass{color:#CC0099; font-style:italic; font-size:11px;}
 .followHistory{color:#002B55; font-style:italic; font-size:11px;}
 </style>

 <table class="container"  cellpadding="0" cellspacing="0">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="370" height="370" valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_followupcontactDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_followupcontactEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										
										<tr >
	  									<td>Company </td>
										<td><input value="" type="text" name="company" id="company" class="textboxxx  fWidth "/> </td>						
										</tr>
										
										<tr >
	  									<td>Phone </td>
										<td><input value="" type="text" name="phone" id="phone" class="textboxxx  fWidth "/> </td>						
										</tr>
										<tr >
	  									<td>Email </td>
										<td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>						
										</tr>
										<tr >			
										
										
	  									<td>Address </td>
										<td><textarea  name="address" id="address"style="width:200px; height:70px;" ></textarea></td>						
										</tr>
										<tr >
	  									<td>Follow Status </td>
										<td>  
	
	<select name="followStatus" id="followStatus" class="textbox fWidth" ><option value=""> </option>	<? 
										  $os->onlyOption($os->followStatus);	?></select>	 </td>						
										</tr><tr >
	  									<td>Ctegory </td>
										<td> <select name="catId" id="catId" class="textbox fWidth" ><option value=""> </option>		  	<? 
								
										  $os->optionsHTML('','catId','title','followupcategory');?>
							</select> </td>						
										</tr>
										
										<tr >
	  									<td>Source </td>
										<td><input value="" type="text" name="source" id="source" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Next FollowUp </td>
										<td><input value="" type="text" name="nextFollowDate" id="nextFollowDate" class="wtDateClass textbox fWidth"/></td>						
										</tr>	
										<tr><td colspan="2">
										Followup History
										<div id="quickPayment" style="margin:10px;">
		
 
	<? 

 include('quickEditPage.php');
$options=array();
$options['PageHeading']='Followup';  
$options['foreignId']='id'; 
$options['foreignTable']='followupcontact';
$options['table']='followuphistory';
$options['tableId']='followuphistoryId';
$options['tableQuery']="select * from followuphistory where [condition] order by dated "; 
$options['fields']=array('dated'=>'Dated','remarks'=>'Remarks');
$options['type']=array('dated'=>'D','remarks'=>'T'); 
$options['relation']=array('dated'=>'','remarks'=>''); 
$options['class']=array('dated'=>'wtDateClass payDate dtpk','remarks'=>'remarksText');  ## add jquery date class
$options['extra']=array('dated'=>'','remarks'=>''); // add extra onclick="testme()"
$options['inlineEdit']=array();
$options['add']='1'; // 0/1
$options['delete']='1'; // 0/1
$options['defaultValues']=array();   
$options['afterSaveCallback']=array('php'=>'updateFollowupdate','javaScript'=>'setDateToLastFollow');  
$functionId='Followup';
quickEdit_v_four($options ,0,$functionId);
?>
<style>
  .qaddButton{ font-size:10px; font-weight:bold; background-color:#009900;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
  .qdeleteButton{ font-size:10px; font-weight:bold; background-color:#FF0000;color:#FFFFFF; cursor:pointer; height:20px;  padding:0px; margin:0px; line-height:10px;-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
   .wtclass<? echo $functionId?>{margin:0px 5px 0px 0px; padding:0px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px;}
  .wtclass<? echo $functionId?> tr{ height:10px;}
  .wtclass<? echo $functionId?> td{ height:10px; padding:0px;}
  .wtclass<? echo $functionId?> tr:hover{ background-color:#F0F0F0;}
   .wtclass<? echo $functionId?> .PageHeading{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; background:#007CB9; color:#FFFFFF; padding:2px; -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; font-style:italic;}
   .wtalise<? echo $functionId?>{ display:none;}
  .remarksText{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:160px; }
  .details{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:220px;}
  .otheramount{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:70px; }
  .formTR{ opacity:0.8;}
  .formTR:hover{ opacity:1;}
  .paymentdown{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:0px;-webkit-appearance: none; -moz-appearance: none;  text-indent: 1px; text-overflow: '';}
  .payDate{-moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; border:1px dotted #F2F2F2; width:110px;}
</style>
  <script>
 function setDateToLastFollow(data)
 {
   
		 var callBackOutput=data.split('-CALLBACKOUTPUT-');
		callBackOutput=callBackOutput[1];
		if(!callBackOutput){   callBackOutput='';      } 
	    os.setVal('date',callBackOutput);	 
 }
 
 </script>
 </div>
										</td>
										</tr>
										
										<tr >
	  									<td>Location </td>
										<td><input value="" type="text" name="location" id="location" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Last F Date </td>
										<td><input value="" type="text" name="date" id="date" class="textboxxx  fWidth " readonly="" style="background-color:#EFEFEF;"/> </td>						
										</tr><tr >
	  									<td>Priority </td>
										<td> <select name="priority" id="priority" class="textbox fWidth" ><option value="">Select Priority</option>		  	<? 
								
										   $os->onlyOption($os->priority); ?>
							</select> </td>						
										</tr><tr >
	  									<td>Appo Date </td>
										<td><input value="" type="text" name="appDate" id="appDate" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Product </td>
										<td><input value="" type="text" name="productName" id="productName" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Assign To </td>
										<td><input value="" type="text" name="assignTo" id="assignTo" class="textboxxx  fWidth "/> </td>						
										</tr>
										<tr >
	  									<td>Note </td>
										<td>
										<textarea  name="shortNote" id="shortNote" style="width:200px; height:70px;" ></textarea>
										 </td>						
										</tr>
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="id" value="0" />	
	<input type="hidden"  id="WT_followupcontactpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_followupcontactDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_followupcontactEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	   Ctegory:
	
	
	<select name="catId" id="catId_s" class="textbox fWidth" ><option value="">Select Ctegory</option>		  	<? 
								
										  $os->optionsHTML('','catId','title','followupcategory');?>
							</select>
	 <select name="followStatus" id="followStatus_s" class="textbox fWidth" ><option value="">Select Follow Status</option>	<? 
										  $os->onlyOption($os->followStatus);	?></select>	
										  
										  &nbsp; From Next FollowUp: <input class="wtDateClass" type="text" name="f_nextFollowDate_s" id="f_nextFollowDate_s" value=""  /> &nbsp;   To Next FollowUp: <input class="wtDateClass" type="text" name="t_nextFollowDate_s" id="t_nextFollowDate_s" value=""  /> &nbsp;  
  <div style="display:none" id="advanceSearchDiv">
         
 Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Phone: <input type="text" class="wtTextClass" name="phone_s" id="phone_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="shortNote_s" id="shortNote_s" value="" /> &nbsp;  Follow Status:
	
	
  
   Location: <input type="text" class="wtTextClass" name="location_s" id="location_s" value="" /> &nbsp;  Date: <input type="text" class="wtTextClass" name="date_s" id="date_s" value="" /> &nbsp;  Priority:
	
	
	<select name="priority" id="priority_s" class="textbox fWidth" ><option value="">Select Priority</option>		  	<? 
								
										  $os->optionsHTML('','priority','','');?>
							</select>
   Company: <input type="text" class="wtTextClass" name="company_s" id="company_s" value="" /> &nbsp;  App Date: <input type="text" class="wtTextClass" name="appDate_s" id="appDate_s" value="" /> &nbsp;  Product: <input type="text" class="wtTextClass" name="productName_s" id="productName_s" value="" /> &nbsp;  Assign To: <input type="text" class="wtTextClass" name="assignTo_s" id="assignTo_s" value="" /> &nbsp;  Source: <input type="text" class="wtTextClass" name="source_s" id="source_s" value="" /> 
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_followupcontactListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_followupcontactListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_followupcontactListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var name_sVal= os.getVal('name_s'); 
 var address_sVal= os.getVal('address_s'); 
 var email_sVal= os.getVal('email_s'); 
 var phone_sVal= os.getVal('phone_s'); 
 var shortNote_sVal= os.getVal('shortNote_s'); 
 var followStatus_sVal= os.getVal('followStatus_s'); 
 var catId_sVal= os.getVal('catId_s'); 
 var location_sVal= os.getVal('location_s'); 
 var date_sVal= os.getVal('date_s'); 
 var priority_sVal= os.getVal('priority_s'); 
 var company_sVal= os.getVal('company_s'); 
 var appDate_sVal= os.getVal('appDate_s'); 
 var productName_sVal= os.getVal('productName_s'); 
 var assignTo_sVal= os.getVal('assignTo_s'); 
 var source_sVal= os.getVal('source_s'); 
 var f_nextFollowDate_sVal= os.getVal('f_nextFollowDate_s'); 
 var t_nextFollowDate_sVal= os.getVal('t_nextFollowDate_s'); 
formdata.append('name_s',name_sVal );
formdata.append('address_s',address_sVal );
formdata.append('email_s',email_sVal );
formdata.append('phone_s',phone_sVal );
formdata.append('shortNote_s',shortNote_sVal );
formdata.append('followStatus_s',followStatus_sVal );
formdata.append('catId_s',catId_sVal );
formdata.append('location_s',location_sVal );
formdata.append('date_s',date_sVal );
formdata.append('priority_s',priority_sVal );
formdata.append('company_s',company_sVal );
formdata.append('appDate_s',appDate_sVal );
formdata.append('productName_s',productName_sVal );
formdata.append('assignTo_s',assignTo_sVal );
formdata.append('source_s',source_sVal );
formdata.append('f_nextFollowDate_s',f_nextFollowDate_sVal );
formdata.append('t_nextFollowDate_s',t_nextFollowDate_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_followupcontactpagingPageno=os.getVal('WT_followupcontactpagingPageno');
	var url='wtpage='+WT_followupcontactpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_followupcontactListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_followupcontactListDiv',url,formdata);
		
}

WT_followupcontactListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('name_s',''); 
 os.setVal('address_s',''); 
 os.setVal('email_s',''); 
 os.setVal('phone_s',''); 
 os.setVal('shortNote_s',''); 
 os.setVal('followStatus_s',''); 
 os.setVal('catId_s',''); 
 os.setVal('location_s',''); 
 os.setVal('date_s',''); 
 os.setVal('priority_s',''); 
 os.setVal('company_s',''); 
 os.setVal('appDate_s',''); 
 os.setVal('productName_s',''); 
 os.setVal('assignTo_s',''); 
 os.setVal('source_s',''); 
 os.setVal('f_nextFollowDate_s',''); 
 os.setVal('t_nextFollowDate_s',''); 
	
		os.setVal('searchKey','');
		WT_followupcontactListing();	
	
	}
	
 
function WT_followupcontactEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var nameVal= os.getVal('name'); 
var addressVal= os.getVal('address'); 
var emailVal= os.getVal('email'); 
var phoneVal= os.getVal('phone'); 
var shortNoteVal= os.getVal('shortNote'); 
var followStatusVal= os.getVal('followStatus'); 
var catIdVal= os.getVal('catId'); 
var locationVal= os.getVal('location'); 
var dateVal= os.getVal('date'); 
var priorityVal= os.getVal('priority'); 
var companyVal= os.getVal('company'); 
var appDateVal= os.getVal('appDate'); 
var productNameVal= os.getVal('productName'); 
var assignToVal= os.getVal('assignTo'); 
var sourceVal= os.getVal('source'); 
var nextFollowDateVal= os.getVal('nextFollowDate'); 


 formdata.append('name',nameVal );
 formdata.append('address',addressVal );
 formdata.append('email',emailVal );
 formdata.append('phone',phoneVal );
 formdata.append('shortNote',shortNoteVal );
 formdata.append('followStatus',followStatusVal );
 formdata.append('catId',catIdVal );
 formdata.append('location',locationVal );
 formdata.append('date',dateVal );
 formdata.append('priority',priorityVal );
 formdata.append('company',companyVal );
 formdata.append('appDate',appDateVal );
 formdata.append('productName',productNameVal );
 formdata.append('assignTo',assignToVal );
 formdata.append('source',sourceVal );
 formdata.append('nextFollowDate',nextFollowDateVal );

	

	 var   id=os.getVal('id');
	 formdata.append('id',id );
  	var url='<? echo $ajaxFilePath ?>?WT_followupcontactEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_followupcontactReLoadList',url,formdata);

}	

function WT_followupcontactReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var id=parseInt(d[0]);
	if(d[0]!='Error' && id>0)
	{
	  os.setVal('id',id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_followupcontactListing();
}

function WT_followupcontactGetById(id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('id',id );
	var url='<? echo $ajaxFilePath ?>?WT_followupcontactGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_followupcontactFillData',url,formdata);
				
}

function WT_followupcontactFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('id',parseInt(objJSON.id));
	
 os.setVal('name',objJSON.name); 
 os.setVal('address',objJSON.address); 
 os.setVal('email',objJSON.email); 
 os.setVal('phone',objJSON.phone); 
 os.setVal('shortNote',objJSON.shortNote); 
 os.setVal('followStatus',objJSON.followStatus); 
 os.setVal('catId',objJSON.catId); 
 os.setVal('location',objJSON.location); 
 os.setVal('date',objJSON.date); 
 os.setVal('priority',objJSON.priority); 
 os.setVal('company',objJSON.company); 
 os.setVal('appDate',objJSON.appDate); 
 os.setVal('productName',objJSON.productName); 
 os.setVal('assignTo',objJSON.assignTo); 
 os.setVal('source',objJSON.source); 
 os.setVal('nextFollowDate',objJSON.nextFollowDate); 

  ajaxViewFollowup(objJSON.id);
}

function WT_followupcontactDeleteRowById(id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(id)<1 || id==''){  
	var  id =os.getVal('id');
	}
	
	if(parseInt(id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('id',id );
	
	var url='<? echo $ajaxFilePath ?>?WT_followupcontactDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_followupcontactDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_followupcontactDeleteRowByIdResults(data)
{
	alert(data);
	WT_followupcontactListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_followupcontactpagingPageno',parseInt(pageNo));
	WT_followupcontactListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>