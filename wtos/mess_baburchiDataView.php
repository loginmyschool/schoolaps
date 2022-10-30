<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_baburchiAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Mess Baburchi';
$ajaxFilePath= 'mess_baburchiAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_baburchiDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_baburchiEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Building </td>
										<td><input value="" type="text" name="building" id="building" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Name </td>
										<td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>						
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
	<input type="hidden"  id="mess_baburchi_id" value="0" />	
	<input type="hidden"  id="WT_mess_baburchipagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_baburchiDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_baburchiEditAndSave();" /><? } ?>	
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
         
From Date: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   Building: <input type="text" class="wtTextClass" name="building_s" id="building_s" value="" /> &nbsp;  Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_baburchiListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_baburchiListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_baburchiListing() // list table searched data get 
{
		var formdata = new FormData();


		var f_dated_sVal= os.getVal('f_dated_s'); 
		var t_dated_sVal= os.getVal('t_dated_s'); 
		var building_sVal= os.getVal('building_s'); 
		var name_sVal= os.getVal('name_s'); 
		var branch_code_sVal= os.getVal('branch_code_s'); 
		var note_sVal= os.getVal('note_s'); 

		var addedBy_sVal=os.getVal('addedBy_s');
		formdata.append('addedBy_s',addedBy_sVal);
		formdata.append('f_dated_s',f_dated_sVal );
		formdata.append('t_dated_s',t_dated_sVal );
		formdata.append('building_s',building_sVal );
		formdata.append('name_s',name_sVal );
		formdata.append('branch_code_s',branch_code_sVal );
		formdata.append('note_s',note_sVal );



		formdata.append('searchKey',os.getVal('searchKey') );
		formdata.append('showPerPage',os.getVal('showPerPage') );
		var WT_mess_baburchipagingPageno=os.getVal('WT_mess_baburchipagingPageno');
		var url='wtpage='+WT_mess_baburchipagingPageno;
		url='<? echo $ajaxFilePath ?>?WT_mess_baburchiListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_mess_baburchiListDiv',url,formdata);
		
}

WT_mess_baburchiListing();
function  searchReset(){

		os.setVal('addedBy_s','');
		os.setVal('f_dated_s',''); 
		os.setVal('t_dated_s',''); 
		os.setVal('building_s',''); 
		os.setVal('name_s',''); 
		os.setVal('branch_code_s',''); 
		os.setVal('note_s',''); 

		os.setVal('searchKey','');
		WT_mess_baburchiListing();	
	
	}
	
 
function WT_mess_baburchiEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var datedVal= os.getVal('dated'); 
var buildingVal= os.getVal('building'); 
var nameVal= os.getVal('name'); 
var branch_codeVal= os.getVal('branch_code'); 
var noteVal= os.getVal('note'); 


 formdata.append('dated',datedVal );
 formdata.append('building',buildingVal );
 formdata.append('name',nameVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('note',noteVal );

	

	 var   mess_baburchi_id=os.getVal('mess_baburchi_id');
	 formdata.append('mess_baburchi_id',mess_baburchi_id );
  	var url='<? echo $ajaxFilePath ?>?WT_mess_baburchiEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_baburchiReLoadList',url,formdata);

}	

function WT_mess_baburchiReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_baburchi_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_baburchi_id>0)
	{
	  os.setVal('mess_baburchi_id',mess_baburchi_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_baburchiListing();
}

function WT_mess_baburchiGetById(mess_baburchi_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_baburchi_id',mess_baburchi_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_baburchiGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_baburchiFillData',url,formdata);
				
}

function WT_mess_baburchiFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('mess_baburchi_id',parseInt(objJSON.mess_baburchi_id));
	
 os.setVal('dated',objJSON.dated); 
 os.setVal('building',objJSON.building); 
 os.setVal('name',objJSON.name); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 

  
}

function WT_mess_baburchiDeleteRowById(mess_baburchi_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_baburchi_id)<1 || mess_baburchi_id==''){  
	var  mess_baburchi_id =os.getVal('mess_baburchi_id');
	}
	
	if(parseInt(mess_baburchi_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_baburchi_id',mess_baburchi_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_baburchiDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_baburchiDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_baburchiDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_baburchiListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_baburchipagingPageno',parseInt(pageNo));
	WT_mess_baburchiListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>