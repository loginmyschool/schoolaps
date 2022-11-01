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
$ajaxFilePath = 'admission-exam-ajax.php';
$loadingImage = $site['url-wtos'] . 'images/loadingwt.gif';
?>
<div class="uk-padding uk-padding-small">
    <div class="uk-flex uk-margin">
        <div class="uk-flex-1">
            <h3>Admission Exams</h3>
        </div>
        <div>
            <button class="uk-button uk-button-small uk-button-primary" onclick="openForm()">New Exam</button>
        </div>
    </div>

    <div id="exam-lists" class="uk-card uk-card-small uk-card-default uk-card-body">

    </div>
</div>

<div id="admission-exam-dorm-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title"></h2>
        <button class="uk-modal-close" type="button"></button>

        <div class="content">

        </div>

    </div>
</div>


<script>
    //fetch all the lists
    function getLists() {
        const fd = new FormData();
        fd.append('wt_admission_exams_list', "OK");

        const url = '<? echo $ajaxFilePath ?>?wt_admission_exams_list=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((result) => {
            document.querySelector("#exam-lists").innerHTML = result;
        }, url, fd);
    }
    getLists();

    //fetch form
    const admission_exam_form_modal_element = document.querySelector("#admission-exam-dorm-modal");
    const admission_exam_form_modal = UIkit.modal(admission_exam_form_modal_element);

    function openForm(admission_exam_id = 0) {
        const fd = new FormData();
        fd.append('wt_admission_exams_form', "OK");
        fd.append("admission_exam_id", admission_exam_id)

        const url = '<? echo $ajaxFilePath ?>?wt_admission_exams_form=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((result) => {
            document.querySelector("#admission-exam-dorm-modal .content").innerHTML = result;
            admission_exam_form_modal.show();
        }, url, fd);
    }

    function saveExam(event) {
        const fd = new FormData(event.target);
        fd.append('wt_admission_exams_save', "OK");
        const url = '<? echo $ajaxFilePath ?>?wt_admission_exams_save=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((result) => {
            getLists();
            admission_exam_form_modal.hide();
        }, url, fd);
    }

    function generateRank(admission_exam_id) {
        const fd = new FormData();
        fd.append('generate_rank', "OK");
        fd.append('admission_exam_id', admission_exam_id);
        const url = '<? echo $ajaxFilePath ?>?generate_rank=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((result) => {
            alert("Successful");
        }, url, fd);
    }
</script>
<? include($site['root-wtos'] . 'bottom.php'); ?>