<?
/*
   # wtos version : 1.1
   # main ajax process page : noteAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='rb';
$listHeader='List note';
$ajaxFilePath= 'noteAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_noteDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_noteEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Subject </td>
										<td><input value="" type="text" name="subject" id="subject" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Details </td>
										<td><textarea  name="details" id="details" ></textarea></td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="noteId" value="0" />	
	<input type="hidden"  id="WT_notepagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_noteDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_noteEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Subject: <input type="text" class="wtTextClass" name="subject_s" id="subject_s" value="" /> &nbsp;  Details: <input type="text" class="wtTextClass" name="details_s" id="details_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_noteListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_noteListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_noteListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var subject_sVal= os.getVal('subject_s'); 
 var details_sVal= os.getVal('details_s'); 
formdata.append('subject_s',subject_sVal );
formdata.append('details_s',details_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_notepagingPageno=os.getVal('WT_notepagingPageno');
	var url='wtpage='+WT_notepagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_noteListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_noteListDiv',url,formdata);
		
}

WT_noteListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('subject_s',''); 
 os.setVal('details_s',''); 
	
		os.setVal('searchKey','');
		WT_noteListing();	
	
	}
	
 
function WT_noteEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var subjectVal= os.getVal('subject'); 
var detailsVal= os.getVal('details'); 


 formdata.append('subject',subjectVal );
 formdata.append('details',detailsVal );

	

	 var   noteId=os.getVal('noteId');
	 formdata.append('noteId',noteId );
  	var url='<? echo $ajaxFilePath ?>?WT_noteEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_noteReLoadList',url,formdata);

}	

function WT_noteReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var noteId=parseInt(d[0]);
	if(d[0]!='Error' && noteId>0)
	{
	  os.setVal('noteId',noteId);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_noteListing();
}

function WT_noteGetById(noteId) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('noteId',noteId );
	var url='<? echo $ajaxFilePath ?>?WT_noteGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_noteFillData',url,formdata);
				
}

function WT_noteFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('noteId',parseInt(objJSON.noteId));
	
 os.setVal('subject',objJSON.subject); 
 os.setVal('details',objJSON.details); 

  
}

function WT_noteDeleteRowById(noteId) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(noteId)<1 || noteId==''){  
	var  noteId =os.getVal('noteId');
	}
	
	if(parseInt(noteId)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('noteId',noteId );
	
	var url='<? echo $ajaxFilePath ?>?WT_noteDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_noteDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_noteDeleteRowByIdResults(data)
{
	alert(data);
	WT_noteListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_notepagingPageno',parseInt(pageNo));
	WT_noteListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>