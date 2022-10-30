<?
/*
   # wtos version : 1.1
   # main ajax process page : campus_buildingAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Campus Building';
$ajaxFilePath= 'campus_buildingAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_campus_buildingDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_campus_buildingEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Building Name </td>
										<td><input value="" type="text" name="building_name" id="building_name" class="textboxxx  fWidth "/> </td>						
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
	<input type="hidden"  id="campus_building_id" value="0" />	
	<input type="hidden"  id="WT_campus_buildingpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_campus_buildingDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_campus_buildingEditAndSave();" /><? } ?>	
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
         
 Building Name: <input type="text" class="wtTextClass" name="building_name_s" id="building_name_s" value="" /> &nbsp;  Branch Code:
	
	
	<select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch Code</option>		  	<? 
								
										  $os->optionsHTML('','branch_code','branch_name','branch');?>
							</select>
   Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  
  </div>
 
   
  <input type="button" value="Search" onclick="WT_campus_buildingListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_campus_buildingListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_campus_buildingListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var building_name_sVal= os.getVal('building_name_s'); 
 var branch_code_sVal= os.getVal('branch_code_s'); 
 var note_sVal= os.getVal('note_s'); 
formdata.append('building_name_s',building_name_sVal );
formdata.append('branch_code_s',branch_code_sVal );
formdata.append('note_s',note_sVal );


		var addedBy_sVal=os.getVal('addedBy_s');
		formdata.append('addedBy_s',addedBy_sVal);

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_campus_buildingpagingPageno=os.getVal('WT_campus_buildingpagingPageno');
	var url='wtpage='+WT_campus_buildingpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_campus_buildingListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_campus_buildingListDiv',url,formdata);
		
}

WT_campus_buildingListing();
function  searchReset() // reset Search Fields
	{
		
		os.setVal('addedBy_s','');
		 os.setVal('building_name_s',''); 
 os.setVal('branch_code_s',''); 
 os.setVal('note_s',''); 
	
		os.setVal('searchKey','');
		WT_campus_buildingListing();	
	
	}
	
 
function WT_campus_buildingEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var building_nameVal= os.getVal('building_name'); 
var branch_codeVal= os.getVal('branch_code'); 
var noteVal= os.getVal('note'); 


 formdata.append('building_name',building_nameVal );
 formdata.append('branch_code',branch_codeVal );
 formdata.append('note',noteVal );

	

	 var   campus_building_id=os.getVal('campus_building_id');
	 formdata.append('campus_building_id',campus_building_id );
  	var url='<? echo $ajaxFilePath ?>?WT_campus_buildingEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_campus_buildingReLoadList',url,formdata);

}	

function WT_campus_buildingReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var campus_building_id=parseInt(d[0]);
	if(d[0]!='Error' && campus_building_id>0)
	{
	  os.setVal('campus_building_id',campus_building_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_campus_buildingListing();
}

function WT_campus_buildingGetById(campus_building_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('campus_building_id',campus_building_id );
	var url='<? echo $ajaxFilePath ?>?WT_campus_buildingGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_campus_buildingFillData',url,formdata);
				
}

function WT_campus_buildingFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('campus_building_id',parseInt(objJSON.campus_building_id));
	
 os.setVal('building_name',objJSON.building_name); 
 os.setVal('branch_code',objJSON.branch_code); 
 os.setVal('note',objJSON.note); 

  
}

function WT_campus_buildingDeleteRowById(campus_building_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(campus_building_id)<1 || campus_building_id==''){  
	var  campus_building_id =os.getVal('campus_building_id');
	}
	
	if(parseInt(campus_building_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('campus_building_id',campus_building_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_campus_buildingDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_campus_buildingDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_campus_buildingDeleteRowByIdResults(data)
{
	alert(data);
	WT_campus_buildingListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_campus_buildingpagingPageno',parseInt(pageNo));
	WT_campus_buildingListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>