<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?>
<?
$pluginName='';
$listHeader='Student Result Report';
$ajaxFilePath= 'report_student_result_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$classAndSectionA= array();
$classQ='SELECT DISTINCT class FROM resultsdetails   order by class';
$classMq = $os->mq($classQ);
while ($classRow = $os->mfa($classMq)) 
{		
	$classA[]=$classRow['class'];
}

 $branchQ='SELECT DISTINCT (branch) FROM student   order by branch asc ';
$brancMq = $os->mq($branchQ);
while ($brancMqRow = $os->mfa($brancMq)) 
{		
	$branch_s[]=$brancMqRow['branch'];
}
 
?>
<table class="container"  cellpadding="0" cellspacing="0">
		<tr>			 
			<td  class="middle" style="padding-left:5px;">
				<div class="listHeader"> <?php  echo $listHeader; ?><span style="display:block;"> </span>	</div> 
				<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
					<tr>
						<td>
							Session:
							<select name="asession" id="asession_s" class="textbox fWidth" ><option value=""> </option>	<? 	
							$os->onlyOption($os->asession,$os->selectedSession());	
							?></select>

							Class:
							<select name="class_s" id="class_s" class="textbox fWidth" onchange="wt_ajax_chain('html*examId*exam,examId,examTitle*class=class_s','asession=asession_s','','');">
								<option value=""> </option>	
							<? foreach($classA as $classVal){?>
								<option value="<?echo $classVal?>"> <? echo $os->classList[$classVal]?></option>
							<? } ?>
							</select>
							Exam:
							<select name="examId" id="examId" class="textbox fWidth" onchange="wt_ajax_chain('html*subject_s*examdetails,subjectId,subjectId*examId=examId','','callback_subject_list','');"  >
							</select>
							
							Subject:  
							<select name="subject_s" id="subject_s" class="textbox fWidth" >
							</select>							
							Branch:
							<select name="branch_s" id="branch_s" class="textbox fWidth" >
							<option value=""> </option>
							<? foreach($branch_s as $branch_sVal){?>
								<option value="<? echo $branch_sVal?>"> <? echo $branch_sVal?></option>
							<? } ?>
							</select>
							
						
							<input type="button" value="Search" onclick="resultDetailsListing();" style="cursor:pointer;"/>
							<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
							&nbsp;  <input type="button" value="Search Result Excel Download" style="cursor:pointer" onclick="window.location='report_student_result_download.php'"/>&nbsp;  <input type="button" value="Search Result PDF Download" style="cursor:pointer" onclick="window.location='report_student_result_download_pdf.php'"/>
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

function resultDetailsListing() // list table searched data get 
{
var formdata = new FormData();
var asessionVal= os.getVal('asession_s');
var classVal= os.getVal('class_s');
var examIdVal= os.getVal('examId');
if(classVal==''){ alert('Please Select Class '); return false;}
if(examIdVal==''){ alert('Please Select Exam '); return false;}	  

formdata.append('asession',asessionVal);
formdata.append('class_s',classVal);
formdata.append('examId_s',examIdVal);
formdata.append('resultDetailsListingVal','OKS');

var subject_s= os.getVal('subject_s');
formdata.append('subject_s',subject_s);

var branch_s= os.getVal('branch_s');
formdata.append('branch_s',branch_s);

if(subject_s==''){ alert('Please Select Subject '); return false;}	 

formdata.append('showPerPage',os.getVal('showPerPage') );
var WT_admissionReadmissionPageno=os.getVal('WT_admissionReadmissionPageno');
var url='wtpage='+WT_admissionReadmissionPageno;
url='<? echo $ajaxFilePath ?>?WT_resultsdetailsListing=OK&'+url;
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
os.setAjaxHtml('reoprtAdmissionReadmissionListDiv',url,formdata);
}
//resultDetailsListing();
function  searchReset() // reset Search Fields
{
	location.reload();
	resultDetailsListing();	
	setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');
}

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_admissionReadmissionPageno',parseInt(pageNo));
	resultDetailsListing();
}
</script>

<? include($site['root-wtos'].'bottom.php'); ?>