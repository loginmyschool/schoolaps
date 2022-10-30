<?
/*
   # wtos version : 1.1
   # main ajax process page : mess_meal_itemAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Mess Meal Item';
$ajaxFilePath= 'mess_meal_itemAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_meal_itemDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_mess_meal_itemEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Morning </td>
										<td><input value="" type="text" name="morning" id="morning" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>At Ten </td>
										<td><input value="" type="text" name="at_ten" id="at_ten" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Noon </td>
										<td><input value="" type="text" name="noon" id="noon" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Evening </td>
										<td><input value="" type="text" name="evening" id="evening" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Night </td>
										<td><input value="" type="text" name="night" id="night" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Date </td>
										<td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>						
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
	<input type="hidden"  id="mess_meal_item_id" value="0" />	
	<input type="hidden"  id="WT_mess_meal_itempagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_mess_meal_itemDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_mess_meal_itemEditAndSave();" /><? } ?>	
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
         
 Morning: <input type="text" class="wtTextClass" name="morning_s" id="morning_s" value="" /> &nbsp;  At Ten: <input type="text" class="wtTextClass" name="at_ten_s" id="at_ten_s" value="" /> &nbsp;  Noon: <input type="text" class="wtTextClass" name="noon_s" id="noon_s" value="" /> &nbsp;  Evening: <input type="text" class="wtTextClass" name="evening_s" id="evening_s" value="" /> &nbsp;  Night: <input type="text" class="wtTextClass" name="night_s" id="night_s" value="" /> &nbsp; From Dated: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Dated: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;  
   Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_mess_meal_itemListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_mess_meal_itemListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_mess_meal_itemListing() // list table searched data get 
{
		var formdata = new FormData();


		var morning_sVal= os.getVal('morning_s'); 
		var at_ten_sVal= os.getVal('at_ten_s'); 
		var noon_sVal= os.getVal('noon_s'); 
		var evening_sVal= os.getVal('evening_s'); 
		var night_sVal= os.getVal('night_s'); 
		var f_dated_sVal= os.getVal('f_dated_s'); 
		var t_dated_sVal= os.getVal('t_dated_s'); 
		var branch_code_sVal= os.getVal('branch_code_s'); 
		var note_sVal= os.getVal('note_s'); 

		var addedBy_sVal=os.getVal('addedBy_s');
		formdata.append('addedBy_s',addedBy_sVal);
		formdata.append('morning_s',morning_sVal );
		formdata.append('at_ten_s',at_ten_sVal );
		formdata.append('noon_s',noon_sVal );
		formdata.append('evening_s',evening_sVal );
		formdata.append('night_s',night_sVal );
		formdata.append('f_dated_s',f_dated_sVal );
		formdata.append('t_dated_s',t_dated_sVal );
		formdata.append('branch_code_s',branch_code_sVal );
		formdata.append('note_s',note_sVal );



		formdata.append('searchKey',os.getVal('searchKey') );
		formdata.append('showPerPage',os.getVal('showPerPage') );
		var WT_mess_meal_itempagingPageno=os.getVal('WT_mess_meal_itempagingPageno');
		var url='wtpage='+WT_mess_meal_itempagingPageno;
		url='<? echo $ajaxFilePath ?>?WT_mess_meal_itemListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_mess_meal_itemListDiv',url,formdata);
		
}

WT_mess_meal_itemListing();
function  searchReset(){

		os.setVal('addedBy_s','');
		os.setVal('morning_s',''); 
		os.setVal('at_ten_s',''); 
		os.setVal('noon_s',''); 
		os.setVal('evening_s',''); 
		os.setVal('night_s',''); 
		os.setVal('f_dated_s',''); 
		os.setVal('t_dated_s',''); 
		os.setVal('branch_code_s',''); 
		os.setVal('note_s',''); 

		os.setVal('searchKey','');
		WT_mess_meal_itemListing();	
	
	}
	
 
function WT_mess_meal_itemEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var morningVal= os.getVal('morning'); 
var at_tenVal= os.getVal('at_ten'); 
var noonVal= os.getVal('noon'); 
var eveningVal= os.getVal('evening'); 
var nightVal= os.getVal('night'); 
var datedVal= os.getVal('dated'); 
var branch_codeVal= os.getVal('branch_code'); 
var noteVal= os.getVal('note'); 


 formdata.append('morning',morningVal );
 formdata.append('at_ten',at_tenVal );
 formdata.append('noon',noonVal );
 formdata.append('evening',eveningVal );
 formdata.append('night',nightVal );
 formdata.append('dated',datedVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('note',noteVal );

	

	 var   mess_meal_item_id=os.getVal('mess_meal_item_id');
	 formdata.append('mess_meal_item_id',mess_meal_item_id );
  	var url='<? echo $ajaxFilePath ?>?WT_mess_meal_itemEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_meal_itemReLoadList',url,formdata);

}	

function WT_mess_meal_itemReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var mess_meal_item_id=parseInt(d[0]);
	if(d[0]!='Error' && mess_meal_item_id>0)
	{
	  os.setVal('mess_meal_item_id',mess_meal_item_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_mess_meal_itemListing();
}

function WT_mess_meal_itemGetById(mess_meal_item_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('mess_meal_item_id',mess_meal_item_id );
	var url='<? echo $ajaxFilePath ?>?WT_mess_meal_itemGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_meal_itemFillData',url,formdata);
				
}

function WT_mess_meal_itemFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('mess_meal_item_id',parseInt(objJSON.mess_meal_item_id));
	
 os.setVal('morning',objJSON.morning); 
 os.setVal('at_ten',objJSON.at_ten); 
 os.setVal('noon',objJSON.noon); 
 os.setVal('evening',objJSON.evening); 
 os.setVal('night',objJSON.night); 
 os.setVal('dated',objJSON.dated); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 

  
}

function WT_mess_meal_itemDeleteRowById(mess_meal_item_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(mess_meal_item_id)<1 || mess_meal_item_id==''){  
	var  mess_meal_item_id =os.getVal('mess_meal_item_id');
	}
	
	if(parseInt(mess_meal_item_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('mess_meal_item_id',mess_meal_item_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_mess_meal_itemDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_mess_meal_itemDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_mess_meal_itemDeleteRowByIdResults(data)
{
	alert(data);
	WT_mess_meal_itemListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_mess_meal_itempagingPageno',parseInt(pageNo));
	WT_mess_meal_itemListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>