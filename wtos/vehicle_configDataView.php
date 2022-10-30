<?
/*
   # wtos version : 1.1
   # main ajax process page : vehicle_configAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='a';
$listHeader='Manage Vehicle';
$ajaxFilePath= 'vehicle_configAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_vehicle_configDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_vehicle_configEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>vehicle type </td>
										<td><input value="" type="text" name="vehicle_type" id="vehicle_type" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>vehicle distance </td>
										<td><input value="" type="text" name="vehicle_distance" id="vehicle_distance" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>vehicle price </td>
										<td><input value="" type="text" name="vehicle_price" id="vehicle_price" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>asession </td>
										<td><input value="" type="text" name="asession" id="asession" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>class </td>
										<td>  
	
	<select name="class_id" id="class_id" class="textbox fWidth" ><option value="">Select class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="vehicle_config_id" value="0" />	
	<input type="hidden"  id="WT_vehicle_configpagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_vehicle_configDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_vehicle_configEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 vehicle type: <input type="text" class="wtTextClass" name="vehicle_type_s" id="vehicle_type_s" value="" /> &nbsp;  vehicle distance: <input type="text" class="wtTextClass" name="vehicle_distance_s" id="vehicle_distance_s" value="" /> &nbsp;  vehicle price: <input type="text" class="wtTextClass" name="vehicle_price_s" id="vehicle_price_s" value="" /> &nbsp;  asession: <input type="text" class="wtTextClass" name="asession_s" id="asession_s" value="" /> &nbsp;  class:
	
	<select name="class_id" id="class_id_s" class="textbox fWidth" ><option value="">Select class</option>	<? 
										  $os->onlyOption($os->classList);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_vehicle_configListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_vehicle_configListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_vehicle_configListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var vehicle_type_sVal= os.getVal('vehicle_type_s'); 
 var vehicle_distance_sVal= os.getVal('vehicle_distance_s'); 
 var vehicle_price_sVal= os.getVal('vehicle_price_s'); 
 var asession_sVal= os.getVal('asession_s'); 
 var class_id_sVal= os.getVal('class_id_s'); 
formdata.append('vehicle_type_s',vehicle_type_sVal );
formdata.append('vehicle_distance_s',vehicle_distance_sVal );
formdata.append('vehicle_price_s',vehicle_price_sVal );
formdata.append('asession_s',asession_sVal );
formdata.append('class_id_s',class_id_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_vehicle_configpagingPageno=os.getVal('WT_vehicle_configpagingPageno');
	var url='wtpage='+WT_vehicle_configpagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_vehicle_configListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_vehicle_configListDiv',url,formdata);
		
}

WT_vehicle_configListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('vehicle_type_s',''); 
 os.setVal('vehicle_distance_s',''); 
 os.setVal('vehicle_price_s',''); 
 os.setVal('asession_s',''); 
 os.setVal('class_id_s',''); 
	
		os.setVal('searchKey','');
		WT_vehicle_configListing();	
	
	}
	
 
function WT_vehicle_configEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var vehicle_typeVal= os.getVal('vehicle_type'); 
var vehicle_distanceVal= os.getVal('vehicle_distance'); 
var vehicle_priceVal= os.getVal('vehicle_price'); 
var asessionVal= os.getVal('asession'); 
var class_idVal= os.getVal('class_id'); 


 formdata.append('vehicle_type',vehicle_typeVal );
 formdata.append('vehicle_distance',vehicle_distanceVal );
 formdata.append('vehicle_price',vehicle_priceVal );
 formdata.append('asession',asessionVal );
 formdata.append('class_id',class_idVal );

	

	 var   vehicle_config_id=os.getVal('vehicle_config_id');
	 formdata.append('vehicle_config_id',vehicle_config_id );
  	var url='<? echo $ajaxFilePath ?>?WT_vehicle_configEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_vehicle_configReLoadList',url,formdata);

}	

function WT_vehicle_configReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var vehicle_config_id=parseInt(d[0]);
	if(d[0]!='Error' && vehicle_config_id>0)
	{
	  os.setVal('vehicle_config_id',vehicle_config_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_vehicle_configListing();
}

function WT_vehicle_configGetById(vehicle_config_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('vehicle_config_id',vehicle_config_id );
	var url='<? echo $ajaxFilePath ?>?WT_vehicle_configGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_vehicle_configFillData',url,formdata);
				
}

function WT_vehicle_configFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('vehicle_config_id',parseInt(objJSON.vehicle_config_id));
	
 os.setVal('vehicle_type',objJSON.vehicle_type); 
 os.setVal('vehicle_distance',objJSON.vehicle_distance); 
 os.setVal('vehicle_price',objJSON.vehicle_price); 
 os.setVal('asession',objJSON.asession); 
 os.setVal('class_id',objJSON.class_id); 

  
}

function WT_vehicle_configDeleteRowById(vehicle_config_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(vehicle_config_id)<1 || vehicle_config_id==''){  
	var  vehicle_config_id =os.getVal('vehicle_config_id');
	}
	
	if(parseInt(vehicle_config_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('vehicle_config_id',vehicle_config_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_vehicle_configDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_vehicle_configDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_vehicle_configDeleteRowByIdResults(data)
{
	alert(data);
	WT_vehicle_configListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_vehicle_configpagingPageno',parseInt(pageNo));
	WT_vehicle_configListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>