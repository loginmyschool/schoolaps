<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_brandAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='Manage Mess Brand';
$ajaxFilePath= 'mess_brandAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_brandDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_brandEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Brand Name </td>
										<td><input value="" type="text" name="brand_name" id="brand_name" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Search Keys </td>
										<td><input value="" type="text" name="search_keys" id="search_keys" class="textboxxx  fWidth "/> </td>						
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
	<input type="hidden"  id="mess_brand_id" value="0" />	
	<input type="hidden"  id="WT_mess_brandpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_brandDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_brandEditAndSave();" /><? } ?>	
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
         
 Brand Name: <input type="text" class="wtTextClass" name="brand_name_s" id="brand_name_s" value="" /> &nbsp;  Search Keys: <input type="text" class="wtTextClass" name="search_keys_s" id="search_keys_s" value="" /> &nbsp;  Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_brandListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_brandListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_brandListing() // list table searched data get 
{
		var formdata = new FormData();


		var brand_name_sVal= os.getVal('brand_name_s'); 
		var search_keys_sVal= os.getVal('search_keys_s'); 
		var branch_code_sVal= os.getVal('branch_code_s'); 
		var note_sVal= os.getVal('note_s'); 

		var addedBy_sVal=os.getVal('addedBy_s');
		formdata.append('addedBy_s',addedBy_sVal);

		formdata.append('brand_name_s',brand_name_sVal );
		formdata.append('search_keys_s',search_keys_sVal );
		formdata.append('branch_code_s',branch_code_sVal );
		formdata.append('note_s',note_sVal );
		formdata.append('searchKey',os.getVal('searchKey') );
		formdata.append('showPerPage',os.getVal('showPerPage') );
		var WT_mess_brandpagingPageno=os.getVal('WT_mess_brandpagingPageno');
		var url='wtpage='+WT_mess_brandpagingPageno;
		url='<? echo $ajaxFilePath ?>?WT_mess_brandListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_mess_brandListDiv',url,formdata);
		
}

WT_mess_brandListing();
function  searchReset(){
		
		os.setVal('addedBy_s','');


		os.setVal('brand_name_s',''); 
		os.setVal('search_keys_s',''); 
		os.setVal('branch_code_s',''); 
		os.setVal('note_s',''); 
		os.setVal('searchKey','');
		WT_mess_brandListing();	
}
	
 
function WT_mess_brandEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var brand_nameVal= os.getVal('brand_name'); 
var search_keysVal= os.getVal('search_keys'); 
var branch_codeVal= os.getVal('branch_code'); 
var noteVal= os.getVal('note'); 


 formdata.append('brand_name',brand_nameVal );
 formdata.append('search_keys',search_keysVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('note',noteVal );

	

	 var   mess_brand_id=os.getVal('mess_brand_id');
	 formdata.append('mess_brand_id',mess_brand_id );
  	var url='<? echo $ajaxFilePath ?>?WT_mess_brandEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_brandReLoadList',url,formdata);

}	

function WT_mess_brandReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_brand_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_brand_id>0)
	{
	  os.setVal('mess_brand_id',mess_brand_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_brandListing();
}

function WT_mess_brandGetById(mess_brand_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_brand_id',mess_brand_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_brandGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_brandFillData',url,formdata);
				
}

function WT_mess_brandFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('mess_brand_id',parseInt(objJSON.mess_brand_id));
	
 os.setVal('brand_name',objJSON.brand_name); 
 os.setVal('search_keys',objJSON.search_keys); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 

  
}

function WT_mess_brandDeleteRowById(mess_brand_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_brand_id)<1 || mess_brand_id==''){  
	var  mess_brand_id =os.getVal('mess_brand_id');
	}
	
	if(parseInt(mess_brand_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_brand_id',mess_brand_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_brandDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_brandDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_brandDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_brandListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_brandpagingPageno',parseInt(pageNo));
	WT_mess_brandListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>