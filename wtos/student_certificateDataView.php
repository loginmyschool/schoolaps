<?
/*
   # wtos version : 1.1
   # main ajax process page : student_certificateAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List  of all certificate';
$ajaxFilePath= 'student_certificateAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
 
 /// extra data  template
          $content_type=$os->get('content_type'); 
           $historyId=$os->get('historyId'); 
		   
		   
		   
 
            $dataQuery=" select * from  certificate_template   WHERE  content_type='$content_type' and type='Body' limit 1   ";
			$rsResults=$os->mq($dataQuery); 
			$template=$os->mfa($rsResults);
           
			$text_content=$template['text_content'];

 
            $dataQuery=" select * from  history   WHERE  historyId='$historyId'   ";
			$rsResults=$os->mq($dataQuery); 
			$prod=$os->mfa($rsResults); 
					
			$certificate_template_id=$template['certificate_template_id'];
			 
			$studentId=$prod['studentId'];
			$asession=$prod['asession'];
			$class_id=$prod['class'];
			$roll_no=$prod['roll_no'];
              $student_certificate_id='';
 
			 if($content_type && $historyId)
			 {
			 
			 
			 
			 
				 ?>
				 <style>
				 .btnStyle{ display:none;}
				
				 .header_footer{ display:none;}
				 </style>
				 <?
			 if($certificate_template_id=='')
			 {
			   echo '<br><h3  style="color:#FF0000">Please Add template body to generate '.$content_type. ' certificate</h3>';
			   exit();
			 }
			   
			 }
			 
			 
 /// extra data  template
?>
  <style>
   .ajaxViewMainTableTDListSearch{display:none;}
				 .silent_input{ border:none; width:80px; color:#000066; font-weight:bold;}
				 .silent_input_big{ border:none; width:180px;  font-weight:bold; border:1px dotted #C0F0F5;}
				 .text_content_replaced{ padding:20px; background:#FDFDFD;}
  </style>

 <table class="container">
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
			  
  <tr>
    <td width="470"    valign="top" class="ajaxViewMainTableTDForm">
	<div class="formDiv">
	<div class="formDivButton" style="display:none;">
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_student_certificateDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_student_certificateEditAndSave();" /><? } ?>	 
	
	</div>
	<div id="certificate_form_div" style="line-height:30px; margin-bottom:30px;">
	
	</div>
	
	  
	<script>
	
function  certificate_form(student_certificate_id,certificate_template_id,studentId,historyId,asession,class_id,content_type) // get record by table primery id
{
	 
	
	var formdata = new FormData();	 
	formdata.append('student_certificate_id',student_certificate_id );
	formdata.append('certificate_template_id',certificate_template_id );
	formdata.append('studentId',studentId );
	formdata.append('historyId',historyId );
	formdata.append('asession',asession );
	formdata.append('class_id',class_id );
	formdata.append('content_type',content_type );
	
 
	formdata.append('certificate_form','OK' );
	var url='<? echo $ajaxFilePath ?>?certificate_form=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('certificate_form_results',url,formdata);
				
}

function certificate_form_results(data)  // fill data form by JSON
{
   
	var datacontent=getData(data,'##-GETTEMPLATE-FORM-##');
	os.setHtml('certificate_form_div',datacontent)
	var template_content=getData(data,'##-GETTEMPLATE-CONTENT-##');
	os.setVal('template_content',template_content);  
}

 

certificate_form('<? echo $student_certificate_id ?>','<? echo $certificate_template_id ?>','<? echo $studentId ?>','<? echo $historyId ?>','<? echo $asession ?>','<? echo $class_id ?>','<? echo $content_type ?>') ;


	</script>
	
	
	 
	
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm" style="display:none">	
	 
<tr >
	  									<td>Certificate Template Id </td>
										<td><input value="<? echo $certificate_template_id; ?>" type="text" name="certificate_template_id" id="certificate_template_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Student Id </td>
										<td><input value="<? echo $studentId; ?>" type="text" name="studentId" id="studentId" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>History Id </td>
										<td><input value="<? echo $historyId; ?>" type="text" name="historyId" id="historyId" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Session </td>
										<td><input value="<? echo $asession; ?>" type="text" name="asession" id="asession" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Class Id </td>
										<td><input value="<? echo $class_id; ?>" type="text" name="class_id" id="class_id" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Roll no </td>
										<td><input value="<? echo $roll_no; ?>" type="text" name="roll_no" id="roll_no" class="textboxxx  fWidth "/> </td>						
										</tr> <tr >
	  									<td> Print head</td>
										<td><input value="1" type="checkbox" name="print_head" id="print_head" class="textbox fWidth"/>  </td>						
										</tr> <tr>
	  									<td>Content </td>
										<td><textarea  name="content" id="content" > </textarea></td>						
										</tr><tr>
	  									<td>Template Content </td>
										<td><textarea  name="template_content" id="template_content" ></textarea></td>						
										</tr> <tr >
	  									<td>Status </td>
										<td>  
	
	<select name="status" id="status" class="textbox fWidth" > 	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	    
		
	  
	
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="student_certificate_id" value="0" />	
	<input type="hidden"  id="WT_student_certificatepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_student_certificateDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_student_certificateEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
	
	</tr><tr>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Certificate Template Id: <input type="text" class="wtTextClass" name="certificate_template_id_s" id="certificate_template_id_s" value="" /> &nbsp;  Student Id: <input type="text" class="wtTextClass" name="studentId_s" id="studentId_s" value="<? echo $studentId; ?>" /> &nbsp;  History Id: <input type="text" class="wtTextClass" name="historyId_s" id="historyId_s" value="" /> &nbsp;  Session: <input type="text" class="wtTextClass" name="asession_s" id="asession_s" value="" /> &nbsp;  Class Id: <input type="text" class="wtTextClass" name="class_id_s" id="class_id_s" value="" /> &nbsp;  Roll no: <input type="text" class="wtTextClass" name="roll_no_s" id="roll_no_s" value="" /> &nbsp;  Ref No: <input type="text" class="wtTextClass" name="ref_no_s" id="ref_no_s" value="" /> &nbsp;   Text Line 1: <input type="text" class="wtTextClass" name="text_line_1_s" id="text_line_1_s" value="" /> &nbsp;  Text Line 2: <input type="text" class="wtTextClass" name="text_line_2_s" id="text_line_2_s" value="" /> &nbsp;  Text Line 3: <input type="text" class="wtTextClass" name="text_line_3_s" id="text_line_3_s" value="" /> &nbsp;  Text Line 4: <input type="text" class="wtTextClass" name="text_line_4_s" id="text_line_4_s" value="" /> &nbsp;  Text Line 5: <input type="text" class="wtTextClass" name="text_line_5_s" id="text_line_5_s" value="" /> &nbsp;  Text Line 6: <input type="text" class="wtTextClass" name="text_line_6_s" id="text_line_6_s" value="" /> &nbsp;  Content: <input type="text" class="wtTextClass" name="content_s" id="content_s" value="" /> &nbsp;  Template Content: <input type="text" class="wtTextClass" name="template_content_s" id="template_content_s" value="" /> &nbsp; From Date: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   Print Header:
	
	<select name="print_header" id="print_header_s" class="textbox fWidth" ><option value="">Select Print Header</option>	<? 
										  $os->onlyOption($os->printHeader);	?></select>	
   Status:
	
	<select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_student_certificateListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_student_certificateListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_student_certificateListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var certificate_template_id_sVal= os.getVal('certificate_template_id_s'); 
 var studentId_sVal= os.getVal('studentId_s'); 
 var historyId_sVal= os.getVal('historyId_s'); 
 var asession_sVal= os.getVal('asession_s'); 
 var class_id_sVal= os.getVal('class_id_s'); 
 var roll_no_sVal= os.getVal('roll_no_s'); 
 var ref_no_sVal= os.getVal('ref_no_s'); 
 var text_line_1_sVal= os.getVal('text_line_1_s'); 
 var text_line_2_sVal= os.getVal('text_line_2_s'); 
 var text_line_3_sVal= os.getVal('text_line_3_s'); 
 var text_line_4_sVal= os.getVal('text_line_4_s'); 
 var text_line_5_sVal= os.getVal('text_line_5_s'); 
 var text_line_6_sVal= os.getVal('text_line_6_s'); 
 var content_sVal= os.getVal('content_s'); 
 var template_content_sVal= os.getVal('template_content_s'); 
 var f_dated_sVal= os.getVal('f_dated_s'); 
 var t_dated_sVal= os.getVal('t_dated_s'); 
 var print_header_sVal= os.getVal('print_header_s'); 
 var status_sVal= os.getVal('status_s'); 
formdata.append('certificate_template_id_s',certificate_template_id_sVal );
formdata.append('studentId_s',studentId_sVal );
formdata.append('historyId_s',historyId_sVal );
formdata.append('asession_s',asession_sVal );
formdata.append('class_id_s',class_id_sVal );
formdata.append('roll_no_s',roll_no_sVal );
formdata.append('ref_no_s',ref_no_sVal );
formdata.append('text_line_1_s',text_line_1_sVal );
formdata.append('text_line_2_s',text_line_2_sVal );
formdata.append('text_line_3_s',text_line_3_sVal );
formdata.append('text_line_4_s',text_line_4_sVal );
formdata.append('text_line_5_s',text_line_5_sVal );
formdata.append('text_line_6_s',text_line_6_sVal );
formdata.append('content_s',content_sVal );
formdata.append('template_content_s',template_content_sVal );
formdata.append('f_dated_s',f_dated_sVal );
formdata.append('t_dated_s',t_dated_sVal );
formdata.append('print_header_s',print_header_sVal );
formdata.append('status_s',status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_student_certificatepagingPageno=os.getVal('WT_student_certificatepagingPageno');
	var url='wtpage='+WT_student_certificatepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_student_certificateListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_student_certificateListDiv',url,formdata);
		
}

WT_student_certificateListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('certificate_template_id_s',''); 
 os.setVal('studentId_s',''); 
 os.setVal('historyId_s',''); 
 os.setVal('asession_s',''); 
 os.setVal('class_id_s',''); 
 os.setVal('roll_no_s',''); 
 os.setVal('ref_no_s',''); 
 os.setVal('text_line_1_s',''); 
 os.setVal('text_line_2_s',''); 
 os.setVal('text_line_3_s',''); 
 os.setVal('text_line_4_s',''); 
 os.setVal('text_line_5_s',''); 
 os.setVal('text_line_6_s',''); 
 os.setVal('content_s',''); 
 os.setVal('template_content_s',''); 
 os.setVal('f_dated_s',''); 
 os.setVal('t_dated_s',''); 
 os.setVal('print_header_s',''); 
 os.setVal('status_s',''); 
	
		os.setVal('searchKey','');
		WT_student_certificateListing();	
	
	}
	
 
function WT_student_certificateEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var certificate_template_idVal= os.getVal('certificate_template_id'); 
var studentIdVal= os.getVal('studentId'); 
var historyIdVal= os.getVal('historyId'); 
var asessionVal= os.getVal('asession'); 
var class_idVal= os.getVal('class_id'); 
var roll_noVal= os.getVal('roll_no'); 
var ref_noVal= os.getVal('ref_no'); 
var print_headVal= os.getVal('print_head'); 
  if(os.getObj('print_head').checked==false){print_headVal=0;}var text_line_1Val= os.getVal('text_line_1'); 
var text_line_2Val= os.getVal('text_line_2'); 
var text_line_3Val= os.getVal('text_line_3'); 
var text_line_4Val= os.getVal('text_line_4'); 
var text_line_5Val= os.getVal('text_line_5'); 
var text_line_6Val= os.getVal('text_line_6'); 
var contentVal= os.getVal('content'); 
var template_contentVal= os.getVal('template_content'); 
var datedVal= os.getVal('dated'); 
var print_headerVal= os.getVal('print_header'); 
var statusVal= os.getVal('status'); 


 formdata.append('certificate_template_id',certificate_template_idVal );
 formdata.append('studentId',studentIdVal );
 formdata.append('historyId',historyIdVal );
 formdata.append('asession',asessionVal );
 formdata.append('class_id',class_idVal );
 formdata.append('roll_no',roll_noVal );
 formdata.append('ref_no',ref_noVal );
 formdata.append('print_head',print_headVal );
 formdata.append('text_line_1',text_line_1Val );
 formdata.append('text_line_2',text_line_2Val );
 formdata.append('text_line_3',text_line_3Val );
 formdata.append('text_line_4',text_line_4Val );
 formdata.append('text_line_5',text_line_5Val );
 formdata.append('text_line_6',text_line_6Val );
 formdata.append('content',contentVal );
 formdata.append('template_content',template_contentVal );
 formdata.append('dated',datedVal );
 formdata.append('print_header',print_headerVal );
 formdata.append('status',statusVal );

	

	 var   student_certificate_id=os.getVal('student_certificate_id');
	 formdata.append('student_certificate_id',student_certificate_id );
  	var url='<? echo $ajaxFilePath ?>?WT_student_certificateEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_certificateReLoadList',url,formdata);

}	

function WT_student_certificateReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var student_certificate_id=parseInt(d[0]);
	if(d[0]!='Error' && student_certificate_id>0)
	{
	  os.setVal('student_certificate_id',student_certificate_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_student_certificateListing();
}

function WT_student_certificateGetById(student_certificate_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('student_certificate_id',student_certificate_id );
	var url='<? echo $ajaxFilePath ?>?WT_student_certificateGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_certificateFillData',url,formdata);
				
}

function WT_student_certificateFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('student_certificate_id',parseInt(objJSON.student_certificate_id));
	
 os.setVal('certificate_template_id',objJSON.certificate_template_id); 
 os.setVal('studentId',objJSON.studentId); 
 os.setVal('historyId',objJSON.historyId); 
 os.setVal('asession',objJSON.asession); 
 os.setVal('class_id',objJSON.class_id); 
 os.setVal('roll_no',objJSON.roll_no); 
 os.setVal('ref_no',objJSON.ref_no); 
 os.setCheckTick('print_head',objJSON.print_head); 
 os.setVal('text_line_1',objJSON.text_line_1); 
 os.setVal('text_line_2',objJSON.text_line_2); 
 os.setVal('text_line_3',objJSON.text_line_3); 
 os.setVal('text_line_4',objJSON.text_line_4); 
 os.setVal('text_line_5',objJSON.text_line_5); 
 os.setVal('text_line_6',objJSON.text_line_6); 
 os.setVal('content',objJSON.content); 
 os.setVal('template_content',objJSON.template_content); 
 os.setVal('dated',objJSON.dated); 
 os.setVal('print_header',objJSON.print_header); 
 os.setVal('status',objJSON.status); 

  
}

function WT_student_certificateDeleteRowById(student_certificate_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(student_certificate_id)<1 || student_certificate_id==''){  
	var  student_certificate_id =os.getVal('student_certificate_id');
	}
	
	if(parseInt(student_certificate_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('student_certificate_id',student_certificate_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_student_certificateDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_student_certificateDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_student_certificateDeleteRowByIdResults(data)
{
	alert(data);
	WT_student_certificateListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_student_certificatepagingPageno',parseInt(pageNo));
	WT_student_certificateListing();
}

	
function PrintCertificate(student_certificate_id)
{

    var URLStr='printIdCertificate.php?student_certificate_id='+student_certificate_id;
	popUpWindow2(URLStr, 10, 10, 900, 600);
	//window.open(URLStr);

}

 function setDataToFields(txt_input) // \'text_line_1\'
 {
   var txt_input_helper=txt_input+'_helper';
   var val=os.getVal(txt_input_helper);
   os.setVal(txt_input,val);
 }
	var popUpWin2=0;

function popUpWindow2(URLStr, left, top, width, height)

{

  if(popUpWin2)

  {

    if(!popUpWin2.closed) popUpWin.close();

  }

popUpWin2 = open(URLStr, 'popUpWin2', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');



}
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>