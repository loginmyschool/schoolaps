<?
/*
   # wtos version : 1.1
   # main ajax process page : generateadmitAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Result And Admit';
$ajaxFilePath= 'templateAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_generateadmitDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_generateadmitEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">


	
										<tr >
										<td>Publish</td>
										<td>  

										<select name="admitPublish" id="admitPublish" class="textbox fWidth" ><? 
										$os->onlyOption($os->admitPublish,'No');	?></select>	 </td>						
										</tr>	
	
	
	
<tr >
	  									<td>Active </td>
										<td>  
	
	<select name="active" id="active" class="textbox fWidth" ><? 
										  $os->onlyOption($os->admitActive);	?></select>	 </td>						
										</tr>	


										<tr >
										<td> Select Class</td>
										<td valign="top"><? foreach($os->classList As $record){ 
										$allClassForUncheck[]=$record;
										?> <input type="checkbox" name="classList[]" id="classList_<?echo $record;?>"  value="<? echo $record; ?>"  />  <? echo $record; ?>    <?   }  
										 $allClassForUncheck=json_encode($allClassForUncheck);	
										
										?></td>										
										</tr>
										
										
										
										<tr >
										<td>Type</td>
										<td>  

										<select name="templateType" id="templateType" class="textbox fWidth" ><? 
										$os->onlyOption($os->templateType,'Exam');	?></select>	 </td>						
										</tr>
										
										
										<tr style="display:none;">
	  									<td>Candidate Sign</td>
										<td>  
	
	<select name="candidateSign" id="candidateSign" class="textbox fWidth" ><? 
										  $os->onlyOption($os->candidateSign,'Show');	?></select>	 </td>						
										</tr>
										
										
										<tr style="display:none;">
	  									<td>Invigilator Sign</td>
										<td>  
	
	<select name="invigilatorSign" id="invigilatorSign" class="textbox fWidth" ><? 
										  $os->onlyOption($os->invigilatorSign,'Exam');	?></select>	 </td>						
										</tr>
										
										
										
										
											 
<tr >
	  									
										<td colspan="2"><b>Title</b><br>
										&nbsp;<textarea  name="admitTitle" id="admitTitle" style="margin: 0px; width: 709px; height: 57px;"></textarea>[#CLASS#]</td>						
										</tr>
										<tr>
										<td>
										<b>Instruction</b>
										</td>
										</tr>
									<!--	------------>
										<tr>
										<td colspan="2">
										<table>
										
										<tr >
										<td>1</td>
	  									<td>
										<textarea  name="instruction1" id="instruction1" style="width: 685px; height: 30px;"></textarea>
										
										Border <select name="instructionBorder1" id="instructionBorder1" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										<tr >
	  									<td>2</td>
										<td>
										<textarea  name="instruction2" id="instruction2" style="margin: 0px; width: 685px; height: 30px;"></textarea> 
										
										Border <select name="instructionBorder2" id="instructionBorder2" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										
										</td>						
										</tr>
										<tr >
	  									<td>3</td>
										<td><textarea  name="instruction3" id="instruction3" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										
										Border <select name="instructionBorder3" id="instructionBorder3" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
											
										<tr >
	  									<td>4</td>
										<td>
										
										
										<textarea  name="instruction4" id="instruction4" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										
										Border <select name="instructionBorder4" id="instructionBorder4" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										
										</td>						
										</tr>
										
										<tr >
	  									<td>5</td>
										<td>
										<textarea  name="instruction5" id="instruction5" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										
										Border <select name="instructionBorder5" id="instructionBorder5" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>	
										
										</td>						
										</tr>
										
										
										<tr >
	  									<td>6</td>
										<td>
										<textarea  name="instruction6" id="instruction6" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										
										Border <select name="instructionBorder6" id="instructionBorder6" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>	

										</td>						
										</tr>
										<tr >
	  									<td>7</td>
										<td><textarea  name="instruction7" id="instruction7" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										Border <select name="instructionBorder7" id="instructionBorder7" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										
										<tr >
	  									<td>8</td>
										<td><textarea  name="instruction8" id="instruction8" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										Border <select name="instructionBorder8" id="instructionBorder8" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										
										<tr >
	  									<td>9</td>
										<td><textarea  name="instruction9" id="instruction9" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										Border <select name="instructionBorder9" id="instructionBorder9" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										
										<tr >
	  									<td>10</td>
										<td><textarea  name="instruction10" id="instruction10" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										
										Border <select name="instructionBorder10" id="instructionBorder10" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										
										<tr >
	  									<td>11</td>
										<td><textarea  name="instruction11" id="instruction11" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										Border <select name="instructionBorder11" id="instructionBorder11" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										
										<tr >
	  									<td>12</td>
										<td><textarea  name="instruction12" id="instruction12" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										Border <select name="instructionBorder12" id="instructionBorder12" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										<tr >
	  									<td>13</td>
										<td><textarea  name="instruction13" id="instruction13" style="margin: 0px; width: 685px; height: 30px;"></textarea>
										Border <select name="instructionBorder13" id="instructionBorder13" class="textbox fWidth" >	<? 
										  $os->onlyOption($os->instructionBorder,'No');	?></select>	
										</td>						
										</tr>
										
									
										
										</table>
										</td>
										</tr>
										<!----------------->
										
										
									
										
										<tr style="display:none;">
	  									<td>Instruction Html </td>
										<td><input value="" type="text" name="instructionHtml" id="instructionHtml" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Stamp Image </td>
										<td>
										
										<img id="stampImagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="stampImage" value=""  id="stampImage" onchange="os.readURL(this,'stampImagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('stampImage');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Signature Image </td>
										<td>
										
										<img id="signatureImagePreview" src="" height="100" style="display:none;"	 />		
										<input type="file" name="signatureImage" value=""  id="signatureImage" onchange="os.readURL(this,'signatureImagePreview') " style="display:none;"/><br>
										
										 <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('signatureImage');">Edit Image</span>
										 
										 
										 
										</td>						
										</tr><tr >
	  									<td>Signatory Designation </td>
										<td><input value="" type="text" name="signatoryDesignation" id="signatoryDesignation" class="textboxxx  fWidth "/> </td>						
										</tr>
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="templateId" value="0" />	
	<input type="hidden"  id="WT_generateadmitpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_generateadmitDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_generateadmitEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Admit Title: <input type="text" class="wtTextClass" name="admitTitle_s" id="admitTitle_s" value="" /> &nbsp;   Phase:
	
	<select name="phase" id="phase_s" class="textbox fWidth" ><option value="">Select Phase</option>	<? 
										  $os->onlyOption($os->phases);	?></select>	
   Instruction Html: <input type="text" class="wtTextClass" name="instructionHtml_s" id="instructionHtml_s" value="" /> &nbsp;    Signatory Designation: <input type="text" class="wtTextClass" name="signatoryDesignation_s" id="signatoryDesignation_s" value="" /> &nbsp;  Active:
	
	<select name="active" id="active_s" class="textbox fWidth" ><option value="">Select Active</option>	<? 
										  $os->onlyOption($os->admitActive);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_generateadmitListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_generateadmitListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_generateadmitListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var admitTitle_sVal= os.getVal('admitTitle_s'); 
 var phase_sVal= os.getVal('phase_s'); 
 var instructionHtml_sVal= os.getVal('instructionHtml_s'); 
 var signatoryDesignation_sVal= os.getVal('signatoryDesignation_s'); 
 var active_sVal= os.getVal('active_s'); 
formdata.append('admitTitle_s',admitTitle_sVal );
formdata.append('phase_s',phase_sVal );
formdata.append('instructionHtml_s',instructionHtml_sVal );
formdata.append('signatoryDesignation_s',signatoryDesignation_sVal );
formdata.append('active_s',active_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_generateadmitpagingPageno=os.getVal('WT_generateadmitpagingPageno');
	var url='wtpage='+WT_generateadmitpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_generateadmitListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_generateadmitListDiv',url,formdata);
		
}

WT_generateadmitListing();
function  searchReset() // reset Search Fields
{
os.setVal('admitTitle_s',''); 
os.setVal('phase_s',''); 
os.setVal('instructionHtml_s',''); 
os.setVal('signatoryDesignation_s',''); 
os.setVal('active_s',''); 
os.setVal('searchKey','');
WT_generateadmitListing();	

}
	
 
function WT_generateadmitEditAndSave()  // collect data and send to save
{
if(os.check.empty('active','Please Select Active')==false){ return false;}  
var c=0;
var idvalStr='';
var test = document.getElementsByName('classList[]');
for (i = 0; i < test.length; i++)
{
if(test[i].checked ==true )
{
var idVal=test[i].value;
idvalStr=idvalStr+','+idVal;
c++
}
}
if(c==0)
{
alert('Please Select Class');
return false;
}






var formdata = new FormData();
var admitTitleVal= os.getVal('admitTitle'); 
var instruction1Val= os.getVal('instruction1');
var instruction2Val= os.getVal('instruction2');
var instruction3Val= os.getVal('instruction3');
var instruction4Val= os.getVal('instruction4');
var instruction5Val= os.getVal('instruction5');
var instruction6Val= os.getVal('instruction6');
var instruction7Val= os.getVal('instruction7');
var instruction8Val= os.getVal('instruction8');
var instruction9Val=os.getVal('instruction9');
var instruction10Val= os.getVal('instruction10');
var instruction11Val= os.getVal('instruction11');
var instruction12Val= os.getVal('instruction12');
var instruction13Val= os.getVal('instruction13');
var instructionHtmlVal=tinyMCE.get("instructionHtml").getContent();
var stampImageVal= os.getObj('stampImage').files[0]; 
var signatureImageVal= os.getObj('signatureImage').files[0]; 
var signatoryDesignationVal= os.getVal('signatoryDesignation'); 
var activeVal= os.getVal('active'); 
var admitPublishVal= os.getVal('admitPublish'); 





var instructionBorder1Val= os.getVal('instructionBorder1');
var instructionBorder2Val= os.getVal('instructionBorder2');
var instructionBorder3Val= os.getVal('instructionBorder3');
var instructionBorder4Val= os.getVal('instructionBorder4');
var instructionBorder5Val= os.getVal('instructionBorder5');
var instructionBorder6Val= os.getVal('instructionBorder6');
var instructionBorder7Val= os.getVal('instructionBorder7');
var instructionBorder8Val= os.getVal('instructionBorder8');
var instructionBorder9Val=os.getVal('instructionBorder9');
var instructionBorder10Val= os.getVal('instructionBorder10');
var instructionBorder11Val= os.getVal('instructionBorder11');
var instructionBorder12Val= os.getVal('instructionBorder12');
var instructionBorder13Val= os.getVal('instructionBorder13');
var templateTypeVal= os.getVal('templateType');
formdata.append('admitPublish',admitPublishVal);
formdata.append('templateType',templateTypeVal);
formdata.append('instructionBorder1',instructionBorder1Val );
formdata.append('instructionBorder2',instructionBorder2Val);
formdata.append('instructionBorder3',instructionBorder3Val );
formdata.append('instructionBorder4',instructionBorder4Val );
formdata.append('instructionBorder5',instructionBorder5Val );
formdata.append('instructionBorder6',instructionBorder6Val);
formdata.append('instructionBorder7',instructionBorder7Val );
formdata.append('instructionBorder8',instructionBorder8Val);
formdata.append('instructionBorder9',instructionBorder9Val );
formdata.append('instructionBorder10',instructionBorder10Val );
formdata.append('instructionBorder11',instructionBorder11Val);
formdata.append('instructionBorder12',instructionBorder12Val );
formdata.append('instructionBorder13',instructionBorder13Val);

formdata.append('admitTitle',admitTitleVal );
formdata.append('instruction1',instruction1Val );
formdata.append('instruction2',instruction2Val);
formdata.append('instruction3',instruction3Val );
formdata.append('instruction4',instruction4Val );
formdata.append('instruction5',instruction5Val );
formdata.append('instruction6',instruction6Val);
formdata.append('instruction7',instruction7Val );
formdata.append('instruction8',instruction8Val);
formdata.append('instruction9',instruction9Val );
formdata.append('instruction10',instruction10Val );
formdata.append('instruction11',instruction11Val);
formdata.append('instruction12',instruction12Val );
formdata.append('instruction13',instruction13Val);
formdata.append('class',idvalStr+',');
formdata.append('instructionHtml',instructionHtmlVal );
if(stampImageVal){  formdata.append('stampImage',stampImageVal,stampImageVal.name );}
if(signatureImageVal){  formdata.append('signatureImage',signatureImageVal,signatureImageVal.name );}
formdata.append('signatoryDesignation',signatoryDesignationVal );
formdata.append('active',activeVal );
var   templateId=os.getVal('templateId');
formdata.append('templateId',templateId );
var url='<? echo $ajaxFilePath ?>?WT_generateadmitEditAndSave=OK&';
//alert(url);
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
os.setAjaxFunc('WT_generateadmitReLoadList',url,formdata);

}	

function WT_generateadmitReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var templateId=parseInt(d[0]);
	if(d[0]!='Error' && templateId>0)
	{
	  os.setVal('templateId',templateId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_generateadmitListing();
}

function WT_generateadmitGetById(templateId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('templateId',templateId );
	var url='<? echo $ajaxFilePath ?>?WT_generateadmitGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_generateadmitFillData',url,formdata);
				
}

function WT_generateadmitFillData(data)  // fill data form by JSON
{
   
var allClassForUncheckVal='<?echo $allClassForUncheck?>';
var allClassVal = JSON.parse(allClassForUncheckVal);
for (i = 0; i < allClassVal.length; i++)
{
var idVal=allClassVal[i];
if(idVal!='')
{
os.getObj('classList_'+idVal).checked=false;
}
}
   
   
   
var objJSON = JSON.parse(data);
os.setVal('templateId',parseInt(objJSON.templateId));
os.setVal('admitTitle',objJSON.admitTitle); 
var classStrVal=objJSON.class;
var classVal=classStrVal.split(',');
for (i = 0; i < classVal.length; i++)
{
var idVal=classVal[i];
if(idVal!='')
{
os.setCheckTick('classList_'+idVal,idVal); 
}
} 
os.setVal('instructionHtml',objJSON.instructionHtml); 
tinyMCE.get('instructionHtml').setContent(objJSON.instructionHtml);
os.setImg('stampImagePreview',objJSON.stampImage); 
os.setImg('signatureImagePreview',objJSON.signatureImage); 
os.setVal('signatoryDesignation',objJSON.signatoryDesignation); 
os.setVal('active',objJSON.active);
os.setVal('instruction1',objJSON.instruction1); 
os.setVal('instruction2',objJSON.instruction2); 
os.setVal('instruction3',objJSON.instruction3); 
os.setVal('instruction4',objJSON.instruction4); 
os.setVal('instruction5',objJSON.instruction5); 
os.setVal('instruction6',objJSON.instruction6); 
os.setVal('instruction7',objJSON.instruction7); 
os.setVal('instruction8',objJSON.instruction8); 
os.setVal('instruction9',objJSON.instruction9); 
os.setVal('instruction10',objJSON.instruction10); 
os.setVal('instruction11',objJSON.instruction11); 
os.setVal('instruction12',objJSON.instruction12); 
os.setVal('instruction13',objJSON.instruction13);  
os.setVal('templateType',objJSON.templateType);
os.setVal('admitPublish',objJSON.admitPublish);
os.setVal('instructionBorder1',objJSON.instructionBorder1); 
os.setVal('instructionBorder2',objJSON.instructionBorder2); 
os.setVal('instructionBorder3',objJSON.instructionBorder3); 
os.setVal('instructionBorder4',objJSON.instructionBorder4); 
os.setVal('instructionBorder5',objJSON.instructionBorder5); 
os.setVal('instructionBorder6',objJSON.instructionBorder6); 
os.setVal('instructionBorder7',objJSON.instructionBorder7); 
os.setVal('instructionBorder8',objJSON.instructionBorder8); 
os.setVal('instructionBorder9',objJSON.instructionBorder9); 
os.setVal('instructionBorder10',objJSON.instructionBorder10); 
os.setVal('instructionBorder11',objJSON.instructionBorder11); 
os.setVal('instructionBorder12',objJSON.instructionBorder12); 
os.setVal('instructionBorder13',objJSON.instructionBorder13); 
os.setVal('invigilatorSign',objJSON.invigilatorSign); 
os.setVal('candidateSign',objJSON.candidateSign);   
 
}

function WT_generateadmitDeleteRowById(generateadmitId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(generateadmitId)<1 || generateadmitId==''){  
	var  generateadmitId =os.getVal('generateadmitId');
	}
	
	if(parseInt(generateadmitId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('generateadmitId',generateadmitId );
	
	var url='<? echo $ajaxFilePath ?>?WT_generateadmitDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_generateadmitDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_generateadmitDeleteRowByIdResults(data)
{
	alert(data);
	WT_generateadmitListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_generateadmitpagingPageno',parseInt(pageNo));
	WT_generateadmitListing();
}

	
	
	
	 
	 
</script>

</script>

<? include('tinyMCE.php'); ?>
<script>
 tmce('instructionHtml');
 </script>

  
 
<? include($site['root-wtos'].'bottom.php'); ?>