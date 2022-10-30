<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?>
<?
$pluginName='';
$listHeader='Admission Report';
$ajaxFilePath= 'report_admission_readmission_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$classAndSectionA= array();
$classAndSectionQ='SELECT DISTINCT class,section,asession FROM history where asession=2019 order by class';
$classAndSectionMq = $os->mq($classAndSectionQ);
while ($classAndSectionRow = $os->mfa($classAndSectionMq)) 
{		
	$classAndSectionA[$classAndSectionRow['class']][]=$classAndSectionRow['section'];
}
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

							From DOB<input type="text" id="fromDob" class="wtDateClass textbox fWidth" style="width:150px;" />   &nbsp;
							To DOB<input type="text" id="toDob" class="wtDateClass textbox fWidth" style="width:150px;" />   &nbsp;

							From Age<input type="text" id="fromAge" class="textbox fWidth" style="width:50px;" />   &nbsp;
							To Age<input type="text" id="toAge" class="textbox fWidth" style="width:50px;" />   &nbsp;
							<input type="checkbox" id="male" name="male" value="male">Boys
							<input type="checkbox" id="female" name="female" value="female">Girls
							<input type="checkbox" id="admission" name="admission" value="admission">Admission
							<input type="checkbox" id="reAdmission" name="reAdmission" value="reAdmission">Re admission
							<input type="checkbox" id="adharFilled" name="adharFilled" value="adharFilled">Adhar Filled
							<input type="checkbox" id="adharNotFilled" name="adharNotFilled" value="adharNotFilled">Adhar Not Filled
							<input type="checkbox" id="bankAccFilled" name="bankAccFilled" value="bankAccFilled">Bank Account Filled
							<input type="checkbox" id="bankAccNotFilled" name="bankAccNotFilled" value="bankAccNotFilled">Bank Account Not Filled
							<?foreach($classAndSectionA as $class=>$secA){?>
							<input type="checkbox" id="class_<?echo $class?>" name="class_<?echo $class?>" value="class_<?echo $class?>" class="studentClass">Class <? echo $os->classList[$class]?>
									<?if(is_array($secA)&&count($secA)>0){?>
											<?foreach($secA as $secVal){?>								
												<input type="checkbox" id="sec_<?echo $class?>_<?echo $secVal?>" name="sec_<?echo $secVal?>" value="sec_<?echo $secVal?>"  class="studentSection">Section (<? echo $os->classList[$class]?>) <? echo $secVal?>
											<?}?>	
									<?}?>
									</br>
							<?}?>
							<input type="button" value="Search" onclick="admissionReadmissionListing();" style="cursor:pointer;"/>
							<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
						</td>
			  		</tr>
			  		<tr> 
					    <td width="470" height="570" valign="top" class="ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm" id="id_ajaxViewMainTableTDForm" style="height:100" >
						</td>
					    <td valign="top" class="ajaxViewMainTableTDList" id="ajaxViewMainTableTDList_id" >
							<div  class="ajaxViewMainTableTDListData" id="reoprtAdmissionReadmissionListDiv">&nbsp; </div>
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
<div id="showStudent_details_DIV" style="background:#F0F0FF;"  >
	<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />		
	<input type="hidden"  id="WT_admissionReadmissionPageno" value="1" />	
</div>		 
<script>

function admissionReadmissionListing() // list table searched data get 
{
setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm'); 
var formdata = new FormData();
var fromDobVal= os.getVal('fromDob');
var toDobVal= os.getVal('toDob');
formdata.append('fromDob',fromDobVal);
formdata.append('toDob',toDobVal);
$(".studentClass").each(function(){
		var classId = $(this).attr('id');
    	if(document.getElementById(classId).checked == true){
			formdata.append(classId,'Yes');
		}
 });
$(".studentSection").each(function(){
		var secId = $(this).attr('id');
    	if(document.getElementById(secId).checked == true){
			formdata.append(secId,'Yes');
		}
 });

if(document.getElementById("male").checked == true){
	formdata.append('male','Yes');
}
if(document.getElementById("female").checked == true){
	formdata.append('female','Yes');
}
if(document.getElementById("admission").checked == true){
	formdata.append('admission','Yes');
}
if(document.getElementById("reAdmission").checked == true){
	formdata.append('reAdmission','Yes');
}
 if(document.getElementById("adharFilled").checked == true){
	formdata.append('adharFilled','Yes');
}
if(document.getElementById("adharNotFilled").checked == true){
	formdata.append('adharNotFilled','Yes');
}
if(document.getElementById("bankAccFilled").checked == true){
	formdata.append('bankAccFilled','Yes');
}
if(document.getElementById("bankAccNotFilled").checked == true){
	formdata.append('bankAccNotFilled','Yes');
}
var fromAgeVal= os.getVal('fromAge');
var toAgeVal= os.getVal('toAge');
formdata.append('fromAge',fromAgeVal);
formdata.append('toAge',toAgeVal);
formdata.append('showPerPage',os.getVal('showPerPage') );
var WT_admissionReadmissionPageno=os.getVal('WT_admissionReadmissionPageno');
var url='wtpage='+WT_admissionReadmissionPageno;
url='<? echo $ajaxFilePath ?>?admissionReadmissionListing=OK&'+url;
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
os.setAjaxHtml('reoprtAdmissionReadmissionListDiv',url,formdata);
}
admissionReadmissionListing();
function  searchReset() // reset Search Fields
{
	location.reload();
	admissionReadmissionListing();	
	setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_admissionReadmissionPageno',parseInt(pageNo));
	admissionReadmissionListing();
}
</script>
<script> 
function excelDownload()
{
	var c=0;
	var idvalStr='';
	var test = document.getElementsByName('columnName[]');
	for (i = 0; i < test.length; i++)
	{
		if(test[i].checked ==true )
		{
			var idVal=test[i].value;
			idvalStr=idvalStr+','+idVal;
			c++
		}
	}
	if(c==0)
	{
	alert('Please Select Atleast One Checkbox');
	return false;
	}
	window.location='report_admission_readmission_download.php?field='+idvalStr;
}
function admissionReadimssionPrint()
{
	var c=0;
	var idvalStr='';
	var test = document.getElementsByName('columnName[]');
	for (i = 0; i < test.length; i++)
	{
		if(test[i].checked ==true )
		{
			var idVal=test[i].value;
			idvalStr=idvalStr+','+idVal;
			c++
		}
	}
	if(c==0)
	{
	alert('Please Select Atleast One Checkbox');
	return false;
	}
	var URLStr='report_admission_readmission_print.php?field='+idvalStr;
	popUpWindow(URLStr, 10, 10, 800, 700);
}	

 
</script>
<? include($site['root-wtos'].'bottom.php'); ?>