<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$ajaxFilePath= 'teacherAttendenceAjax.php';



$pluginName='';

$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

?>

<html>
<body>
<input type="hidden"  id="WT_studentpagingPageno" value="1" />	
<table  border="0" cellspacing="1" cellpadding="1">
<tr>
 
 
 


<td>Date <input value="<?echo $os->showDate($os->now());?>" type="text" name="attendenceDate" id="attendenceDate" onChange="studentListing();" class="wtDateClass textbox fWidth"/></td>	
<td>

 <input type="button" value="Search" onClick="studentListing();" style="cursor:pointer;"/>
  
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
 

var attendenceDateVal= os.getVal('attendenceDate');


 
if(attendenceDateVal==''){ alert('select date'); return false;}




formdata.append('attendenceDate',attendenceDateVal );
 
formdata.append('searchStudent','OK' );
var WT_studentpagingPageno=os.getVal('WT_studentpagingPageno');
var url='wtpage='+WT_studentpagingPageno;
url='<? echo $ajaxFilePath ?>?studentListing=OK&'+url;
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage">Loading..</div>';	
os.setAjaxHtml('studentDiv',url,formdata);
		
}

//studentListing();

function attendenceSet(teacherId)
{
var checkboxid='checkbox_attendance_'+teacherId;

var attendenceVal='A';
if(os.getObj(checkboxid).checked==true)
{
   attendenceVal='P';
}

 
var formdata = new FormData();	
 
var attendenceDateVal= os.getVal('attendenceDate');

 
if(attendenceDateVal==''){ alert('select date'); return false;}
 



formdata.append('attendenceDate',attendenceDateVal );
 
formdata.append('teacherId',teacherId );
 
formdata.append('attendenceVal',attendenceVal );
formdata.append('updateAttendence','OK' );
var url='<? echo $ajaxFilePath ?>?attendence=OK';
os.setAjaxFunc('attendenceSet_result',url,formdata);

}
function attendenceSet_result(data) // after attendence reload list
{
	 var objJSON = JSON.parse(data);
	  
	 var checkboxid='checkbox_attendance_'+objJSON.teacherId;
	 
	 //alert(objJSON.presentState);
	 
	 if(objJSON.presentState=='P')
	 {
	  
	   os.getObj(checkboxid).checked=true;
	 }else
	 {
	 os.getObj(checkboxid).checked=false;
	 }
	 
	 
}
function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_studentpagingPageno',parseInt(pageNo));
	studentListing();
}

$( document ).ready(function() {  
  //wt_ajax_chain('html*subjectId_s*subject,subjectId,subjectName*asession=asession_s,classId=classList_s','','','');
});
 

</script>
<? include($site['root-wtos'].'bottom.php'); ?>