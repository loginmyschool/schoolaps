<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$ajaxFilePath= 'feesDetailsAjax.php';



$pluginName='';

$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

?>

<html>
<body>

<table  border="0" cellspacing="1" cellpadding="1">
<tr>
<td>  

Session <select name="asession" id="asession_s" class="textbox fWidth">	<? 
$os->onlyOption($os->asession);	?></select>		 </td>	

<td>  

Class <select name="classList" id="classList_s" class="textbox fWidth">	<? 
$os->onlyOption($os->classList);	?></select>		 </td>	
<td>  

Section <select name="section" id="section_s" class="textbox fWidth">	<? 
$os->onlyOption($os->section);	?></select>		 </td>

<td>  

Status <select name="feesStatus" id="feesStatus_s" class="textbox fWidth"><option value=""></option>	<? 
$os->onlyOption($os->feesStatus);	?></select>		 </td>




<td style="display:none;">  

Subject <select style="width:150px;" name="subjectId_s" id="subjectId_s" class="textbox fWidth" ><option value="">Select Subject</option><? 
								
										  $os->optionsHTML('','subjectId','subjectName','subject');?>
							</select> 	 </td>


<td  style="display:none;">Date <input value="<?echo $os->showDate($os->now());?>" type="text" name="attendenceDate" id="attendenceDate" onchange="studentListing();" class="wtDateClass textbox fWidth"/></td>	
<td>

 <input type="button" value="Search" onclick="studentListing();" style="cursor:pointer;"/>
    <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
<li  id='div_busy' style='display:none'  > </li>
	
</td>
</tr>

</table>

<div id="studentDiv">&nbsp; </div>

   
</body>
</html>


<script type="text/javascript">
 
function studentListing() // list table searched data get 
{
	
var formdata = new FormData();
var asession_sVal= os.getVal('asession_s'); 
var classList_sVal= os.getVal('classList_s');
 
var feesStatus_sVal= os.getVal('feesStatus_s');
var section_sVal= os.getVal('section_s');
var subjectId_sVal= os.getVal('subjectId_s');

var attendenceDateVal= os.getVal('attendenceDate');

formdata.append('attendenceDate',attendenceDateVal );
formdata.append('asession_s',asession_sVal );
formdata.append('classList_s',classList_sVal );
formdata.append('feesStatus_s',feesStatus_sVal );
formdata.append('section_s',section_sVal );
formdata.append('subjectId_s',subjectId_sVal );
formdata.append('searchStudent','OK' );
var url='<? echo $ajaxFilePath ?>?studentListing=OK';
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage">Loading..</div>';	
os.setAjaxFunc('studentDivHtml',url,formdata);
	
}
function studentDivHtml(data)
{
os.setHtml('studentDiv',data);	
os.viewCalender('wtDateClass','dd-mm-yy');	
}
studentListing();
function  searchReset() // reset Search Fields
	{
os.setVal('asession_s',''); 
os.setVal('classList_s',''); 
os.setVal('section_s',''); 
os.setVal('feesStatus_s',''); 
studentListing();	
	
	}

</script>
<? include($site['root-wtos'].'bottom.php'); ?>