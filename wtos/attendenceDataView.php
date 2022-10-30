<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$ajaxFilePath= 'attendenceAjax.php';



$pluginName='';

$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';


$os->asession=array_filter($os->asession);
$listHeader = "Student Attendance";
?>

    <div class="title-bar border-color-grey">
        <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
            <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
                <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
            </div>
        </div>

    </div>
<div class="ontent">

    <div class="item p-m">
        <input type="hidden"  id="WT_studentpagingPageno" value="1" />
        <div>
            <div class="uk-inline">
                
                <select name="asession"
                        id="asession_s"
                        style="padding-left: 85px"
                        onchange="wt_ajax_chain('html*subjectId_s*subject,subjectId,subjectName*asession=asession_s,classId=classList_s','','','');"
                         >
                    <option value=""> </option>
                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession,date('Y'));
                    ?>
                </select>
            </div>
            <div class="uk-inline">
                <select name="classList" id="classList_s" class=""
                        onchange="wt_ajax_chain('html*subjectId_s*subject,subjectId,subjectName*classId=classList_s','','','');">
                    <option value="">Class</option>
                    <? $os->onlyOption($os->classList);	?>
                </select>
            </div>
            <div class="uk-inline">
                <select name="section" id="section_s" class="">
                    <option value="">Section</option>
                    <? $os->onlyOption($os->section);	?>
                </select>
            </div>
            <div class="uk-inline">
            <select style="width:150px;" name="subjectId_s" id="subjectId_s" class="uk-border-rounded uk-form-small" >
                <option value="">Subject</option>
                <?// $os->optionsHTML('','subjectId','subjectName','subject');?>
            </select>
            </div>
            <div class="uk-inline">
                <input value="<?echo $os->showDate($os->now());?>" type="text" name="attendenceDate" id="attendenceDate" onChange="studentListing();" class="wtDateClass uk-input uk-border-rounded uk-form-small" placeholder="dste"/>
            </div>
            <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button" type="button" value="Search" onClick="studentListing();">Search</button>
        </div>



        <div id="studentDiv">&nbsp; </div>
    </div>
</div>





<script type="text/javascript">

function studentListing() // list table searched data get
{

var formdata = new FormData();
var asession_sVal= os.getVal('asession_s');
var classList_sVal= os.getVal('classList_s');
var section_sVal= os.getVal('section_s');
var subjectId_sVal= os.getVal('subjectId_s');

var attendenceDateVal= os.getVal('attendenceDate');


if(asession_sVal==''){ alert('select session'); return false;}
if(classList_sVal==''){ alert('select class'); return false;}
if(section_sVal==''){ alert('select section'); return false;}
if(subjectId_sVal==''){ alert('select subject'); return false;}
if(attendenceDateVal==''){ alert('select date'); return false;}




formdata.append('attendenceDate',attendenceDateVal );
formdata.append('asession_s',asession_sVal );
formdata.append('classList_s',classList_sVal );
formdata.append('section_s',section_sVal );
formdata.append('subjectId_s',subjectId_sVal );
formdata.append('searchStudent','OK' );
var WT_studentpagingPageno=os.getVal('WT_studentpagingPageno');
var url='wtpage='+WT_studentpagingPageno;
url='<? echo $ajaxFilePath ?>?studentListing=OK&'+url;
os.animateMe.div='div_busy';
os.animateMe.html='<div class="loadImage">Loading..</div>';
os.setAjaxHtml('studentDiv',url,formdata);

}

//studentListing();

function attendenceSet(historyId,studentId)
{
var checkboxid='checkbox_attendance_'+historyId;

var attendenceVal='A';
if(os.getObj(checkboxid).checked==true)
{
   attendenceVal='P';
}


var formdata = new FormData();

var asession_sVal= os.getVal('asession_s');
var classList_sVal= os.getVal('classList_s');
var section_sVal= os.getVal('section_s');
var subjectId_sVal= os.getVal('subjectId_s');
var attendenceDateVal= os.getVal('attendenceDate');


if(asession_sVal==''){ alert('select session'); return false;}
if(classList_sVal==''){ alert('select class'); return false;}
if(section_sVal==''){ alert('select section'); return false;}
if(subjectId_sVal==''){ alert('select subject'); return false;}
if(attendenceDateVal==''){ alert('select date'); return false;}




formdata.append('attendenceDate',attendenceDateVal );
formdata.append('asession',asession_sVal );
formdata.append('classList',classList_sVal );
formdata.append('section',section_sVal );
formdata.append('subjectId',subjectId_sVal );


formdata.append('studentId',studentId );
formdata.append('historyId',historyId );
formdata.append('attendenceVal',attendenceVal );
formdata.append('updateAttendence','OK' );
var url='<? echo $ajaxFilePath ?>?attendence=OK';
os.setAjaxFunc('attendenceSet_result',url,formdata);

}
function attendenceSet_result(data) // after attendence reload list
{
	 var objJSON = JSON.parse(data);

	 var checkboxid='checkbox_attendance_'+objJSON.historyId;

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
