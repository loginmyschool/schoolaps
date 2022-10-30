<?
/*
   # wtos version : 1.1
   # main ajax process page : travel_detailsAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List travel_details';
$ajaxFilePath= 'travel_detailsAjax.php';
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
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_travel_detailsDeleteRowById('');" /><? } ?>	 
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_travel_detailsEditAndSave();" /><? } ?>	 
	
	</div>
	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">	
	 
<tr >
	  									<td>Driver </td>
										<td> <select name="teacherId" id="teacherId" class="textbox fWidth" ><option value="">Select Driver</option>		  	<? 
								
										  $os->optionsHTML('','teacherId','name','teacher');?>
							</select> </td>						
										</tr><tr >
	  									<td>Purpose </td>
										<td><input value="" type="text" name="purpose" id="purpose" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Traveller Names </td>
										<td><input value="" type="text" name="traveller_names" id="traveller_names" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Source </td>
										<td><input value="" type="text" name="source" id="source" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Destination </td>
										<td><input value="" type="text" name="destination" id="destination" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Start Date </td>
										<td><input value="" type="text" name="start_date" id="start_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>End Date </td>
										<td><input value="" type="text" name="end_date" id="end_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Start Meter Reading </td>
										<td><input value="" type="text" name="start_meter_reading" id="start_meter_reading" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>End Meter Reading </td>
										<td><input value="" type="text" name="end_meter_reading" id="end_meter_reading" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Distance Traveled </td>
										<td><input value="" type="text" name="distance_traveled" id="distance_traveled" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Vehicl Reg No </td>
										<td><input value="" type="text" name="vehicle_regno" id="vehicle_regno" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Vehicle Model </td>
										<td><input value="" type="text" name="vehicle_model" id="vehicle_model" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Vehicle Make </td>
										<td><input value="" type="text" name="vehicle_make" id="vehicle_make" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Rate Per (km) </td>
										<td><input value="" type="text" name="rate_per_km" id="rate_per_km" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total (km) </td>
										<td><input value="" type="text" name="total_km" id="total_km" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Price On (km) </td>
										<td><input value="" type="text" name="price_on_km" id="price_on_km" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Rate/hour </td>
										<td><input value="" type="text" name="rate_per_hour" id="rate_per_hour" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total Hour </td>
										<td><input value="" type="text" name="total_hour" id="total_hour" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Price On Hour </td>
										<td><input value="" type="text" name="price_on_hour" id="price_on_hour" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Cotract Price </td>
										<td><input value="" type="text" name="cotract_price" id="cotract_price" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Fuel Price </td>
										<td><input value="" type="text" name="fuel_price" id="fuel_price" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Other Price Details </td>
										<td><input value="" type="text" name="other_price_details" id="other_price_details" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Other Price </td>
										<td><input value="" type="text" name="other_price" id="other_price" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Total Price </td>
										<td><input value="" type="text" name="total_price" id="total_price" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Approved Status </td>
										<td>  
	
	<select name="status_approved" id="status_approved" class="textbox fWidth" ><option value="">Select Approved Status</option>	<? 
										  $os->onlyOption($os->travel_approved_status);	?></select>	 </td>						
										</tr><tr >
	  									<td>Paid Status </td>
										<td>  
	
	<select name="status_paid" id="status_paid" class="textbox fWidth" ><option value="">Select Paid Status</option>	<? 
										  $os->onlyOption($os->travel_paid_status);	?></select>	 </td>						
										</tr><tr >
	  									<td>Payment Reference </td>
										<td><input value="" type="text" name="payment_reference" id="payment_reference" class="textboxxx  fWidth "/> </td>						
										</tr><tr >
	  									<td>Paid Date </td>
										<td><input value="" type="text" name="paid_date" id="paid_date" class="wtDateClass textbox fWidth"/></td>						
										</tr><tr >
	  									<td>Status </td>
										<td>  
	
	<select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	 </td>						
										</tr>	
									
		 								
	</table>
	
	
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />					
	<input type="hidden"  id="travel_details_id" value="0" />	
	<input type="hidden"  id="WT_travel_detailspagingPageno" value="1" />	
	<div class="formDivButton">						
	<? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_travel_detailsDeleteRowById('');" />	<? } ?>	  
	&nbsp;&nbsp;
	&nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />
	 
	&nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_travel_detailsEditAndSave();" /><? } ?>	
	</div> 
	</div>	
	
	 
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList">
	
	<div class="ajaxViewMainTableTDListSearch">
	Search Key  
  <input type="text" id="searchKey" />   &nbsp;
     
	  
	 
  <div style="display:none" id="advanceSearchDiv">
         
 Driver:
	
	
	<select name="teacherId" id="teacherId_s" class="textbox fWidth" ><option value="">Select Driver</option>		  	<? 
								
										  $os->optionsHTML('','teacherId','name','teacher');?>
							</select>
   Purpose: <input type="text" class="wtTextClass" name="purpose_s" id="purpose_s" value="" /> &nbsp;  Traveller Names: <input type="text" class="wtTextClass" name="traveller_names_s" id="traveller_names_s" value="" /> &nbsp;  Source: <input type="text" class="wtTextClass" name="source_s" id="source_s" value="" /> &nbsp;  Destination: <input type="text" class="wtTextClass" name="destination_s" id="destination_s" value="" /> &nbsp; From Start Date: <input class="wtDateClass" type="text" name="f_start_date_s" id="f_start_date_s" value=""  /> &nbsp;   To Start Date: <input class="wtDateClass" type="text" name="t_start_date_s" id="t_start_date_s" value=""  /> &nbsp;  
  From End Date: <input class="wtDateClass" type="text" name="f_end_date_s" id="f_end_date_s" value=""  /> &nbsp;   To End Date: <input class="wtDateClass" type="text" name="t_end_date_s" id="t_end_date_s" value=""  /> &nbsp;  
   Start Meter Reading: <input type="text" class="wtTextClass" name="start_meter_reading_s" id="start_meter_reading_s" value="" /> &nbsp;  End Meter Reading: <input type="text" class="wtTextClass" name="end_meter_reading_s" id="end_meter_reading_s" value="" /> &nbsp;  Distance Traveled: <input type="text" class="wtTextClass" name="distance_traveled_s" id="distance_traveled_s" value="" /> &nbsp;  Vehicl Reg No: <input type="text" class="wtTextClass" name="vehicle_regno_s" id="vehicle_regno_s" value="" /> &nbsp;  Vehicle Model: <input type="text" class="wtTextClass" name="vehicle_model_s" id="vehicle_model_s" value="" /> &nbsp;  Vehicle Make: <input type="text" class="wtTextClass" name="vehicle_make_s" id="vehicle_make_s" value="" /> &nbsp;  Rate Per (km): <input type="text" class="wtTextClass" name="rate_per_km_s" id="rate_per_km_s" value="" /> &nbsp;  Total (km): <input type="text" class="wtTextClass" name="total_km_s" id="total_km_s" value="" /> &nbsp;  Price On (km): <input type="text" class="wtTextClass" name="price_on_km_s" id="price_on_km_s" value="" /> &nbsp;  Rate/hour: <input type="text" class="wtTextClass" name="rate_per_hour_s" id="rate_per_hour_s" value="" /> &nbsp;  Total Hour: <input type="text" class="wtTextClass" name="total_hour_s" id="total_hour_s" value="" /> &nbsp;  Price On Hour: <input type="text" class="wtTextClass" name="price_on_hour_s" id="price_on_hour_s" value="" /> &nbsp;  Cotract Price: <input type="text" class="wtTextClass" name="cotract_price_s" id="cotract_price_s" value="" /> &nbsp;  Fuel Price: <input type="text" class="wtTextClass" name="fuel_price_s" id="fuel_price_s" value="" /> &nbsp;  Other Price Details: <input type="text" class="wtTextClass" name="other_price_details_s" id="other_price_details_s" value="" /> &nbsp;  Other Price: <input type="text" class="wtTextClass" name="other_price_s" id="other_price_s" value="" /> &nbsp;  Total Price: <input type="text" class="wtTextClass" name="total_price_s" id="total_price_s" value="" /> &nbsp;  Approved Status:
	
	<select name="status_approved" id="status_approved_s" class="textbox fWidth" ><option value="">Select Approved Status</option>	<? 
										  $os->onlyOption($os->travel_approved_status);	?></select>	
   Paid Status:
	
	<select name="status_paid" id="status_paid_s" class="textbox fWidth" ><option value="">Select Paid Status</option>	<? 
										  $os->onlyOption($os->travel_paid_status);	?></select>	
   Payment Reference: <input type="text" class="wtTextClass" name="payment_reference_s" id="payment_reference_s" value="" /> &nbsp; From Paid Date: <input class="wtDateClass" type="text" name="f_paid_date_s" id="f_paid_date_s" value=""  /> &nbsp;   To Paid Date: <input class="wtDateClass" type="text" name="t_paid_date_s" id="t_paid_date_s" value=""  /> &nbsp;  
   Status:
	
	<select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Status</option>	<? 
										  $os->onlyOption($os->activeStatus);	?></select>	
   
  </div>
 
   
  <input type="button" value="Search" onclick="WT_travel_detailsListing();" style="cursor:pointer;"/>
  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
  
   </div>
	<div  class="ajaxViewMainTableTDListData" id="WT_travel_detailsListDiv">&nbsp; </div>
	&nbsp;</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
			  </td>
			  </tr>
			</table>
			
			 

<script>
 
function WT_travel_detailsListing() // list table searched data get 
{
	var formdata = new FormData();
	
	
 var teacherId_sVal= os.getVal('teacherId_s'); 
 var purpose_sVal= os.getVal('purpose_s'); 
 var traveller_names_sVal= os.getVal('traveller_names_s'); 
 var source_sVal= os.getVal('source_s'); 
 var destination_sVal= os.getVal('destination_s'); 
 var f_start_date_sVal= os.getVal('f_start_date_s'); 
 var t_start_date_sVal= os.getVal('t_start_date_s'); 
 var f_end_date_sVal= os.getVal('f_end_date_s'); 
 var t_end_date_sVal= os.getVal('t_end_date_s'); 
 var start_meter_reading_sVal= os.getVal('start_meter_reading_s'); 
 var end_meter_reading_sVal= os.getVal('end_meter_reading_s'); 
 var distance_traveled_sVal= os.getVal('distance_traveled_s'); 
 var vehicle_regno_sVal= os.getVal('vehicle_regno_s'); 
 var vehicle_model_sVal= os.getVal('vehicle_model_s'); 
 var vehicle_make_sVal= os.getVal('vehicle_make_s'); 
 var rate_per_km_sVal= os.getVal('rate_per_km_s'); 
 var total_km_sVal= os.getVal('total_km_s'); 
 var price_on_km_sVal= os.getVal('price_on_km_s'); 
 var rate_per_hour_sVal= os.getVal('rate_per_hour_s'); 
 var total_hour_sVal= os.getVal('total_hour_s'); 
 var price_on_hour_sVal= os.getVal('price_on_hour_s'); 
 var cotract_price_sVal= os.getVal('cotract_price_s'); 
 var fuel_price_sVal= os.getVal('fuel_price_s'); 
 var other_price_details_sVal= os.getVal('other_price_details_s'); 
 var other_price_sVal= os.getVal('other_price_s'); 
 var total_price_sVal= os.getVal('total_price_s'); 
 var status_approved_sVal= os.getVal('status_approved_s'); 
 var status_paid_sVal= os.getVal('status_paid_s'); 
 var payment_reference_sVal= os.getVal('payment_reference_s'); 
 var f_paid_date_sVal= os.getVal('f_paid_date_s'); 
 var t_paid_date_sVal= os.getVal('t_paid_date_s'); 
 var active_status_sVal= os.getVal('active_status_s'); 
formdata.append('teacherId_s',teacherId_sVal );
formdata.append('purpose_s',purpose_sVal );
formdata.append('traveller_names_s',traveller_names_sVal );
formdata.append('source_s',source_sVal );
formdata.append('destination_s',destination_sVal );
formdata.append('f_start_date_s',f_start_date_sVal );
formdata.append('t_start_date_s',t_start_date_sVal );
formdata.append('f_end_date_s',f_end_date_sVal );
formdata.append('t_end_date_s',t_end_date_sVal );
formdata.append('start_meter_reading_s',start_meter_reading_sVal );
formdata.append('end_meter_reading_s',end_meter_reading_sVal );
formdata.append('distance_traveled_s',distance_traveled_sVal );
formdata.append('vehicle_regno_s',vehicle_regno_sVal );
formdata.append('vehicle_model_s',vehicle_model_sVal );
formdata.append('vehicle_make_s',vehicle_make_sVal );
formdata.append('rate_per_km_s',rate_per_km_sVal );
formdata.append('total_km_s',total_km_sVal );
formdata.append('price_on_km_s',price_on_km_sVal );
formdata.append('rate_per_hour_s',rate_per_hour_sVal );
formdata.append('total_hour_s',total_hour_sVal );
formdata.append('price_on_hour_s',price_on_hour_sVal );
formdata.append('cotract_price_s',cotract_price_sVal );
formdata.append('fuel_price_s',fuel_price_sVal );
formdata.append('other_price_details_s',other_price_details_sVal );
formdata.append('other_price_s',other_price_sVal );
formdata.append('total_price_s',total_price_sVal );
formdata.append('status_approved_s',status_approved_sVal );
formdata.append('status_paid_s',status_paid_sVal );
formdata.append('payment_reference_s',payment_reference_sVal );
formdata.append('f_paid_date_s',f_paid_date_sVal );
formdata.append('t_paid_date_s',t_paid_date_sVal );
formdata.append('active_status_s',active_status_sVal );

	
	 
	formdata.append('searchKey',os.getVal('searchKey') );
	formdata.append('showPerPage',os.getVal('showPerPage') );
	var WT_travel_detailspagingPageno=os.getVal('WT_travel_detailspagingPageno');
	var url='wtpage='+WT_travel_detailspagingPageno;
	url='<? echo $ajaxFilePath ?>?WT_travel_detailsListing=OK&'+url;
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxHtml('WT_travel_detailsListDiv',url,formdata);
		
}

WT_travel_detailsListing();
function  searchReset() // reset Search Fields
	{
		 os.setVal('teacherId_s',''); 
 os.setVal('purpose_s',''); 
 os.setVal('traveller_names_s',''); 
 os.setVal('source_s',''); 
 os.setVal('destination_s',''); 
 os.setVal('f_start_date_s',''); 
 os.setVal('t_start_date_s',''); 
 os.setVal('f_end_date_s',''); 
 os.setVal('t_end_date_s',''); 
 os.setVal('start_meter_reading_s',''); 
 os.setVal('end_meter_reading_s',''); 
 os.setVal('distance_traveled_s',''); 
 os.setVal('vehicle_regno_s',''); 
 os.setVal('vehicle_model_s',''); 
 os.setVal('vehicle_make_s',''); 
 os.setVal('rate_per_km_s',''); 
 os.setVal('total_km_s',''); 
 os.setVal('price_on_km_s',''); 
 os.setVal('rate_per_hour_s',''); 
 os.setVal('total_hour_s',''); 
 os.setVal('price_on_hour_s',''); 
 os.setVal('cotract_price_s',''); 
 os.setVal('fuel_price_s',''); 
 os.setVal('other_price_details_s',''); 
 os.setVal('other_price_s',''); 
 os.setVal('total_price_s',''); 
 os.setVal('status_approved_s',''); 
 os.setVal('status_paid_s',''); 
 os.setVal('payment_reference_s',''); 
 os.setVal('f_paid_date_s',''); 
 os.setVal('t_paid_date_s',''); 
 os.setVal('active_status_s',''); 
	
		os.setVal('searchKey','');
		WT_travel_detailsListing();	
	
	}
	
 
function WT_travel_detailsEditAndSave()  // collect data and send to save
{
        
	var formdata = new FormData();
	var teacherIdVal= os.getVal('teacherId'); 
var purposeVal= os.getVal('purpose'); 
var traveller_namesVal= os.getVal('traveller_names'); 
var sourceVal= os.getVal('source'); 
var destinationVal= os.getVal('destination'); 
var start_dateVal= os.getVal('start_date'); 
var end_dateVal= os.getVal('end_date'); 
var start_meter_readingVal= os.getVal('start_meter_reading'); 
var end_meter_readingVal= os.getVal('end_meter_reading'); 
var distance_traveledVal= os.getVal('distance_traveled'); 
var vehicle_regnoVal= os.getVal('vehicle_regno'); 
var vehicle_modelVal= os.getVal('vehicle_model'); 
var vehicle_makeVal= os.getVal('vehicle_make'); 
var rate_per_kmVal= os.getVal('rate_per_km'); 
var total_kmVal= os.getVal('total_km'); 
var price_on_kmVal= os.getVal('price_on_km'); 
var rate_per_hourVal= os.getVal('rate_per_hour'); 
var total_hourVal= os.getVal('total_hour'); 
var price_on_hourVal= os.getVal('price_on_hour'); 
var cotract_priceVal= os.getVal('cotract_price'); 
var fuel_priceVal= os.getVal('fuel_price'); 
var other_price_detailsVal= os.getVal('other_price_details'); 
var other_priceVal= os.getVal('other_price'); 
var total_priceVal= os.getVal('total_price'); 
var status_approvedVal= os.getVal('status_approved'); 
var status_paidVal= os.getVal('status_paid'); 
var payment_referenceVal= os.getVal('payment_reference'); 
var paid_dateVal= os.getVal('paid_date'); 
var active_statusVal= os.getVal('active_status'); 


 formdata.append('teacherId',teacherIdVal );
 formdata.append('purpose',purposeVal );
 formdata.append('traveller_names',traveller_namesVal );
 formdata.append('source',sourceVal );
 formdata.append('destination',destinationVal );
 formdata.append('start_date',start_dateVal );
 formdata.append('end_date',end_dateVal );
 formdata.append('start_meter_reading',start_meter_readingVal );
 formdata.append('end_meter_reading',end_meter_readingVal );
 formdata.append('distance_traveled',distance_traveledVal );
 formdata.append('vehicle_regno',vehicle_regnoVal );
 formdata.append('vehicle_model',vehicle_modelVal );
 formdata.append('vehicle_make',vehicle_makeVal );
 formdata.append('rate_per_km',rate_per_kmVal );
 formdata.append('total_km',total_kmVal );
 formdata.append('price_on_km',price_on_kmVal );
 formdata.append('rate_per_hour',rate_per_hourVal );
 formdata.append('total_hour',total_hourVal );
 formdata.append('price_on_hour',price_on_hourVal );
 formdata.append('cotract_price',cotract_priceVal );
 formdata.append('fuel_price',fuel_priceVal );
 formdata.append('other_price_details',other_price_detailsVal );
 formdata.append('other_price',other_priceVal );
 formdata.append('total_price',total_priceVal );
 formdata.append('status_approved',status_approvedVal );
 formdata.append('status_paid',status_paidVal );
 formdata.append('payment_reference',payment_referenceVal );
 formdata.append('paid_date',paid_dateVal );
 formdata.append('active_status',active_statusVal );

	

	 var   travel_details_id=os.getVal('travel_details_id');
	 formdata.append('travel_details_id',travel_details_id );
  	var url='<? echo $ajaxFilePath ?>?WT_travel_detailsEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_travel_detailsReLoadList',url,formdata);

}	

function WT_travel_detailsReLoadList(data) // after edit reload list
{
  
	var d=data.split('#-#');
	var travel_details_id=parseInt(d[0]);
	if(d[0]!='Error' && travel_details_id>0)
	{
	  os.setVal('travel_details_id',travel_details_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_travel_detailsListing();
}

function WT_travel_detailsGetById(travel_details_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('travel_details_id',travel_details_id );
	var url='<? echo $ajaxFilePath ?>?WT_travel_detailsGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_travel_detailsFillData',url,formdata);
				
}

function WT_travel_detailsFillData(data)  // fill data form by JSON
{
   
	var objJSON = JSON.parse(data);
	os.setVal('travel_details_id',parseInt(objJSON.travel_details_id));
	
 os.setVal('teacherId',objJSON.teacherId); 
 os.setVal('purpose',objJSON.purpose); 
 os.setVal('traveller_names',objJSON.traveller_names); 
 os.setVal('source',objJSON.source); 
 os.setVal('destination',objJSON.destination); 
 os.setVal('start_date',objJSON.start_date); 
 os.setVal('end_date',objJSON.end_date); 
 os.setVal('start_meter_reading',objJSON.start_meter_reading); 
 os.setVal('end_meter_reading',objJSON.end_meter_reading); 
 os.setVal('distance_traveled',objJSON.distance_traveled); 
 os.setVal('vehicle_regno',objJSON.vehicle_regno); 
 os.setVal('vehicle_model',objJSON.vehicle_model); 
 os.setVal('vehicle_make',objJSON.vehicle_make); 
 os.setVal('rate_per_km',objJSON.rate_per_km); 
 os.setVal('total_km',objJSON.total_km); 
 os.setVal('price_on_km',objJSON.price_on_km); 
 os.setVal('rate_per_hour',objJSON.rate_per_hour); 
 os.setVal('total_hour',objJSON.total_hour); 
 os.setVal('price_on_hour',objJSON.price_on_hour); 
 os.setVal('cotract_price',objJSON.cotract_price); 
 os.setVal('fuel_price',objJSON.fuel_price); 
 os.setVal('other_price_details',objJSON.other_price_details); 
 os.setVal('other_price',objJSON.other_price); 
 os.setVal('total_price',objJSON.total_price); 
 os.setVal('status_approved',objJSON.status_approved); 
 os.setVal('status_paid',objJSON.status_paid); 
 os.setVal('payment_reference',objJSON.payment_reference); 
 os.setVal('paid_date',objJSON.paid_date); 
 os.setVal('active_status',objJSON.active_status); 

  
}

function WT_travel_detailsDeleteRowById(travel_details_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(travel_details_id)<1 || travel_details_id==''){  
	var  travel_details_id =os.getVal('travel_details_id');
	}
	
	if(parseInt(travel_details_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('travel_details_id',travel_details_id );
	
	var url='<? echo $ajaxFilePath ?>?WT_travel_detailsDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_travel_detailsDeleteRowByIdResults',url,formdata);
	}
 

}
function WT_travel_detailsDeleteRowByIdResults(data)
{
	alert(data);
	WT_travel_detailsListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_travel_detailspagingPageno',parseInt(pageNo));
	WT_travel_detailsListing();
}

	
	
	
	 
	 
</script>


  
 
<? include($site['root-wtos'].'bottom.php'); ?>