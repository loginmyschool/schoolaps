<?
	include('wtosConfigLocal.php');
	include($site['root-wtos'].'top.php');
?>
<?
$pluginName='';

$listHeader='Attendance Report';
$ajaxFilePath= 'report_attendance_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>
<table class="container"  cellpadding="0" cellspacing="0">
		<tr>			 
			<td  class="middle" style="padding-left:5px;">
				<div class="listHeader"> <?php  echo $listHeader; ?></div> 
				<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
					<tr>
						<td colspan="4">
							Session :<select name="asession_s" id="asession_s" class="textbox fWidth" ><?$os->onlyOption($os->asession);?></select>
							Class :<select name="class_s" id="class_s" class="textbox fWidth" ><?$os->onlyOption($os->classList);	?></select>
							<input type="button" value="Search" onclick="WT_attendanceListing();" style="cursor:pointer;"/>
							<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
						</td>
			  		</tr>
			  		<tr> 
					    <td width="470" height="570" valign="top" class="ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm" id="id_ajaxViewMainTableTDForm" style="height:100" > 
						</td>
					    <td valign="top" class="ajaxViewMainTableTDList" id="ajaxViewMainTableTDList_id" >
							<div  class="ajaxViewMainTableTDListData" id="WT_attendanceListDiv">&nbsp; </div>
							&nbsp;


							
							&nbsp;
						</td>
						 <td valign="top" class="ajaxViewMainTableTDList" id="ajaxViewMainTableTDList_id" >
							 
 <div  class="ajaxViewMainTableTDListData" id="WT_attendanceDetailsDiv"></div>
							
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

function WT_attendanceListing() // list table searched data get 
{
		var formdata = new FormData();
		var asession_sVal= os.getVal('asession_s');  
		var class_sVal= os.getVal('class_s');  
		formdata.append('asession_s',asession_sVal );
		formdata.append('class_s',class_sVal );
		var url='<? echo $ajaxFilePath ?>?WT_attendanceListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_attendanceListDiv',url,formdata);

}

WT_attendanceListing();
function  searchReset() // reset Search Fields
{
	location.reload();
}

function attendanceDetails(studentId,classVal,asession){

		var formdata = new FormData();
		formdata.append('studentId',studentId);
		formdata.append('class',classVal);
		formdata.append('asession',asession);
		var url='<? echo $ajaxFilePath ?>?WT_attendanceDetailsListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_attendanceDetailsDiv',url,formdata);
}
</script>
<script> 

 
</script>
<? include($site['root-wtos'].'bottom.php'); ?>