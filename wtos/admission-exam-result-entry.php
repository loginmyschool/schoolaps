<?
/*
   # wtos version : 1.1
   # main ajax process page : eclassAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'] . 'top.php');

$pluginName = '';
$listHeader = 'List eclass';
$ajaxFilePath = 'admission-exam-result-entry-ajax.php';
$loadingImage = $site['url-wtos'] . 'images/loadingwt.gif';
$sessions = $os->mq("SELECT * FROM accademicsession")->fetchAll(\PDO::FETCH_ASSOC);
?>
<div class="uk-padding uk-padding-small">

    <h3>Admission Exams</h3>

    <form onsubmit="event.preventDefault(); fetchStudents(event)" class="uk-margin-small">
        <select id="session_s" required onchange="wt_ajax_chain('html*exam_s*admission_exam,admission_exam_id,description*session=session_s','','','');">
            <option value="">SESSION</option>
            <?php $os->optionsHTML("", "idKey", "idKey", "accademicsession"); ?>
        </select>

        <select id="exam_s" required name="admission_exam_id" onchange="wt_ajax_chain('html*subject_s*admission_exam_detail,admission_exam_detail_id,subject_name*admission_exam_id=exam_s','','','');">
            <option value="">EXAM</option>
        </select>

        <select id="subject_s" required name="admission_exam_detail_id">
            <option value="">SUBJECT</option>
        </select>
        <button class="uk-button uk-button-small uk-button-primary uk-border-rounded">Get Students</button>
    </form>


    <div id="student-lists" class="uk-card uk-card-small uk-card-default">

    </div>
</div>
<script>
    //fetch all the lists
    function fetchStudents(event) {
        const fd = new FormData(event.target);
        fd.append('fetch_students', "OK");

        const url = '<? echo $ajaxFilePath ?>?fetch_students=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((result) => {
            document.querySelector("#student-lists").innerHTML = result;
        }, url, fd);
    }

    function saveMarks(event, formfillup_id, marks_obtain) {
        const marks = parseFloat(event.target.getAttribute("max"));
        marks_obtain = parseFloat(marks_obtain);
        if(marks_obtain > marks){
            event.target.value = "";
            return alert("Maximum  number is "+marks);
        }
      
        const fd = new FormData();
        fd.append('save_marks', "OK");
        fd.append('formfillup_id', formfillup_id);
        fd.append('marks_obtain', marks_obtain);
        fd.append('admission_exam_id', document.querySelector("select[name=admission_exam_id]").value);
        fd.append('admission_exam_detail_id',  document.querySelector("select[name=admission_exam_detail_id]").value);

        const url = '<? echo $ajaxFilePath ?>?save_marks=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((result) => {

        }, url, fd);
    }
</script>
<? include($site['root-wtos'] . 'bottom.php'); ?>