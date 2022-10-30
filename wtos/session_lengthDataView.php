<?
/*
   # wtos version : 1.1
   # main ajax process page : session_lengthAjax.php 
   #  
*/
exit(); // not need this page

include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Session Length';
$ajaxFilePath= 'session_lengthAjax.php';
// $os->loadPluginConstant($pluginName);
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_session_lengthDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_session_lengthEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>From Date </td>
										<td><input value="" type="text" name="from_date" id="from_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>To Date </td>
										<td><input value="" type="text" name="to_date" id="to_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Year </td>
										<td>  
	
	<select name="year" id="year" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										  $os->onlyOption($os->feesYear);	?></select>	 </td>						
										</tr><tr >
	  									<td>Class </td>
										<td>  
	
	<select name="classId" id="classId" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="session_length_id" value="0" />	
	<input type="hidden"  id="WT_session_lengthpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_session_lengthDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_session_lengthEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
From From Date: <input class="wtDateClass" type="text" name="f_from_date_s" id="f_from_date_s" value=""  /> &nbsp;   To From Date: <input class="wtDateClass" type="text" name="t_from_date_s" id="t_from_date_s" value=""  /> &nbsp;  
  From To Date: <input class="wtDateClass" type="text" name="f_to_date_s" id="f_to_date_s" value=""  /> &nbsp;   To To Date: <input class="wtDateClass" type="text" name="t_to_date_s" id="t_to_date_s" value=""  /> &nbsp;  
   Year:
	
	<select name="year" id="year_s" class="textbox fWidth" ><option value="">Select Year</option>	<? 
										  $os->onlyOption($os->feesYear);	?></select>	
   Class:
	
	<select name="classId" id="classId_s" class="textbox fWidth" ><option value="">Select Class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_session_lengthListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_session_lengthListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_session_lengthListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var f_from_date_sVal= os.getVal('f_from_date_s'); 
 var t_from_date_sVal= os.getVal('t_from_date_s'); 
 var f_to_date_sVal= os.getVal('f_to_date_s'); 
 var t_to_date_sVal= os.getVal('t_to_date_s'); 
 var year_sVal= os.getVal('year_s'); 
 var classId_sVal= os.getVal('classId_s'); 
formdata.append('f_from_date_s',f_from_date_sVal );
formdata.append('t_from_date_s',t_from_date_sVal );
formdata.append('f_to_date_s',f_to_date_sVal );
formdata.append('t_to_date_s',t_to_date_sVal );
formdata.append('year_s',year_sVal );
formdata.append('classId_s',classId_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_session_lengthpagingPageno=os.getVal('WT_session_lengthpagingPageno');
	var url='wtpage='+WT_session_lengthpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_session_lengthListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_session_lengthListDiv',url,formdata);
		
}

WT_session_lengthListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('f_from_date_s',''); 
 os.setVal('t_from_date_s',''); 
 os.setVal('f_to_date_s',''); 
 os.setVal('t_to_date_s',''); 
 os.setVal('year_s',''); 
 os.setVal('classId_s',''); 
	
		os.setVal('searchKey','');
		WT_session_lengthListing();	
	
	}
	
 
function WT_session_lengthEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var from_dateVal= os.getVal('from_date'); 
var to_dateVal= os.getVal('to_date'); 
var yearVal= os.getVal('year'); 
var classIdVal= os.getVal('classId'); 


 formdata.append('from_date',from_dateVal );
 formdata.append('to_date',to_dateVal );
 formdata.append('year',yearVal );
 formdata.append('classId',classIdVal );

	

	 var   session_length_id=os.getVal('session_length_id');
	 formdata.append('session_length_id',session_length_id );
  	var url='<? echo $ajaxFilePath ?>?WT_session_lengthEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_session_lengthReLoadList',url,formdata);

}	

function WT_session_lengthReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var session_length_id=parseInt(d[0]);
	if(d[0]!='Error' && session_length_id>0)
	{
	  os.setVal('session_length_id',session_length_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_session_lengthListing();
}

function WT_session_lengthGetById(session_length_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('session_length_id',session_length_id );
	var url='<? echo $ajaxFilePath ?>?WT_session_lengthGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_session_lengthFillData',url,formdata);
				
}

function WT_session_lengthFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('session_length_id',parseInt(objJSON.session_length_id));
	
 os.setVal('from_date',objJSON.from_date); 
 os.setVal('to_date',objJSON.to_date); 
 os.setVal('year',objJSON.year); 
 os.setVal('classId',objJSON.classId); 

  
}

function WT_session_lengthDeleteRowById(session_length_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(session_length_id)<1 || session_length_id==''){  
	var  session_length_id =os.getVal('session_length_id');
	}
	
	if(parseInt(session_length_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('session_length_id',session_length_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_session_lengthDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_session_lengthDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_session_lengthDeleteRowByIdResults(data)
{
	alert(data);
	WT_session_lengthListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_session_lengthpagingPageno',parseInt(pageNo));
	WT_session_lengthListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>