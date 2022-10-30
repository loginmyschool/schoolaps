<?
	include('wtosConfigLocal.php');
	include($site['root-wtos'].'top.php');
?>
<?
$pluginName='';

$listHeader='Expense Report';
$ajaxFilePath= 'report_expense_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>
<table class="container"  cellpadding="0" cellspacing="0">
		<tr>			 
			<td  class="middle" style="padding-left:5px;">
				<div class="listHeader"> <?php  echo $listHeader; ?><span style="display:none;"> Session:
				<select name="asession" id="asession_s" class="textbox fWidth" ><option value=""> </option>	<? 	
				$os->onlyOption($os->asession,$os->selectedSession());	
				?></select></span>	</div> 
				<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
					<tr>
						<td colspan="4">
							<select name="year_s" id="year_s" class="textbox fWidth" ><option value="">Select Year</option>	<? 
							$os->onlyOption($os->asession);	?></select>
							<input type="button" value="Search" onclick="WT_donationListing();" style="cursor:pointer;"/>
							<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
						</td>
			  		</tr>
			  		<tr> 
					    <td width="470" height="570" valign="top" class="ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm" id="id_ajaxViewMainTableTDForm" style="height:100" >
						</td>
					    <td valign="top" class="ajaxViewMainTableTDList" id="ajaxViewMainTableTDList_id" >
							<div  class="ajaxViewMainTableTDListData" id="WT_donationListDiv">&nbsp; </div>
							&nbsp;
						</td>
						 <td width="470" height="570" valign="top" class="ajaxViewMainTableTDForm" style="display:none;" id="TD_ID_for_other_function"   >
						 	<div id="TD_ID_for_other_function_DIV"></div>
						</td>
			  		</tr>
				</table>
			</td>
		</tr>
</table> 
<script>

function WT_donationListing() // list table searched data get 
{
		var formdata = new FormData();
		var year_sVal= os.getVal('year_s');  
		formdata.append('year_s',year_sVal );
		var url='<? echo $ajaxFilePath ?>?WT_donationListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_donationListDiv',url,formdata);

}

WT_donationListing();
function  searchReset() // reset Search Fields
{
	location.reload();
}

function expenseDetails(monthVal,yearVal){
	var URLStr='report_expense_detailsDataView.php?month='+monthVal+'&year='+yearVal;
	popUpWindow(URLStr, 10, 10, 1200, 600);
}
</script>
<script> 

 
</script>
<? include($site['root-wtos'].'bottom.php'); ?>