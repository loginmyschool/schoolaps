<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/


include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');



$pluginName='';
$listHeader='Answer Entry ';
$ajaxFilePath= 'answer_entry_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

///
/// ACCESS SETTINGS
$access_name = "Answer Entry";
$branch_codes = $os->get_branches_by_access_name($access_name);

?>
<script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>

    </div>

</div>
<div class="content">
    <div class="item p-m">

        <div>
            <div class="uk-grid uk-grid-small" uk-grid>
                <div uk-tooltip="Select Branch">
                    <select name="branch_code_s" id="branch_code_s"
                            onchange="get_asession_by_branch_code()"
                            class="select2">
                        <option value="">--BRANCH--</option>
                        <? $os->onlyOption($branch_codes,'');	?>
                    </select>
                </div>
                <div uk-tooltip="Session">
                    <div class="uk-inline">
                        <select name="asession" id="asession_s"
                                class="uk-select uk-border-rounded congested-form"
                                onchange="get_class_by_session()">
                            <option
                                    value=""> </option>	<?
                            $os->onlyOption($os->asession,$os->selectedSession());
                            ?>
                        </select>
                    </div>
                </div>
                <div uk-tooltip="Class">
                    <div class="uk-inline">
                        <select name="class_s" id="class_s"
                                class="uk-select uk-border-rounded congested-form"
                                onchange="get_exam_by_class();">
                            <option value=""> </option>
                        </select>
                    </div>
                </div>
                <div uk-tooltip="Exam">
                    <div class="uk-inline">
                        <select name="exam_s" id="exam_s"
                                class="uk-select uk-border-rounded congested-form"
                                onchange="get_exam_group_by_exam();"  >
                        </select>
                    </div>
                </div>
                <div uk-tooltip="Sheet">
                    <div class="uk-inline">
                        <select name="exam_group_s" id="exam_group_s" class="uk-select uk-border-rounded congested-form" >
                        </select>
                    </div>
                </div>

                <div>

                    Registration No:
                    <div class="uk-inline">
                        <input name="registerNo_s" id="registerNo_s" class="uk-input uk-border-rounded congested-form" />
                    </div>
                </div>
                <div>


                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Search" onclick="WT_result_entry_listing();">Search</button>
                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Reset" onclick="searchReset();">Reset</button>

                </div>


            </div>
        </div>


        <div id="WT_result_entry_div" class="uk-margin-small"></div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML" id=""> </script>
<script type="text/x-mathjax-config;executed=true">
   MathJax.Hub.Config({
      tex2jax: { inlineMath: [["$","$"],["\\(","\\)"]] },
      "HTML-CSS": {
        linebreaks: { automatic: true, width: "container" }
      }
   });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script>
    let socket = io("<?=$site["socket_io_url"]?>",{
        path: "/io",
    });
</script>
<script>
    window['after_ajax_functions'].push(
        function (){
            MathJax.Hub.Typeset()
        }
    )

    function WT_result_entry_listing() // list table searched data get
    {
        var formdata = new FormData();
        var branch_code_s= os.getVal('branch_code_s');
        var asession_s= os.getVal('asession_s');
        var class_s= os.getVal('class_s');
        var exam_s= os.getVal('exam_s');
        var exam_group_s= os.getVal('exam_group_s');
        var registerNo_s= os.getVal('registerNo_s');
        //var order_by_s= os.getVal('order_by_s');



        if(branch_code_s===''){ alert('Please Select branch code '); return false;}
        if(class_s===''){ alert('Please Select Class '); return false;}
        if(exam_s===''){ alert('Please Select Exam '); return false;}
        if(exam_group_s===''){ alert('Please Select Sheet'); return false;}


        formdata.append('branch_code_s',branch_code_s);
        formdata.append('asession_s',asession_s);
        formdata.append('class_s',class_s);
        formdata.append('exam_s',exam_s);
        formdata.append('exam_group_s',exam_group_s);
        formdata.append('registerNo_s',registerNo_s);
        //formdata.append('order_by_s',order_by_s);
        formdata.append('WT_result_entry_listing','OK');

        let url='<? echo $ajaxFilePath ?>?WT_result_entry_listing=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_result_entry_div',url,formdata);
    }
    //resultDetailsListing();
    function  search_reset() // reset Search Fields
    {
        location.reload();
        resultDetailsListing();
        setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');
    }
    //option fetch functions
    //Auto completes
    function get_asession_by_branch_code()
    {
        let formdata = new FormData();

        var branch_code_s= os.getVal('branch_code_s');
        if(branch_code_s===""){alert("Please select branch code");return;}

        formdata.append("branch_code_s", branch_code_s);
        formdata.append('get_asession_by_branch_code','OK' );

        let url='<? echo $ajaxFilePath ?>?get_asession_by_branch_code=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            os.setHtml('asession_s',data);
        },url,formdata);

    }
    function get_class_by_session()
    {
        let formdata = new FormData();

        formdata.append("branch_code_s", os.getVal("branch_code_s"));
        formdata.append("asession_s", os.getVal("asession_s"));
        formdata.append('get_class_by_session','OK' );

        let url='<? echo $ajaxFilePath ?>?get_class_by_session=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            os.setHtml('class_s',data);
        },url,formdata);

    }
    function get_exam_by_class()
    {
        let formdata = new FormData();

        formdata.append("branch_code_s", os.getVal("branch_code_s"));
        formdata.append("asession_s", os.getVal("asession_s"));
        formdata.append("class_s", os.getVal("class_s"));
        formdata.append('get_exam_by_class','OK' );

        let url='<? echo $ajaxFilePath ?>?get_exam_by_class=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            os.setHtml('exam_s',data);
        },url,formdata);

    }
    function get_exam_group_by_exam()
    {
        let formdata = new FormData();

        formdata.append("exam_s", os.getVal("exam_s"));
        formdata.append('get_exam_group_by_exam','OK' );

        let url='<? echo $ajaxFilePath ?>?get_exam_group_by_exam=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            os.setHtml('exam_group_s',data);
        },url,formdata);

    }
    //
    function open_omr_sheet(hId, sId, egId, set='1'){
        if(set==""){
            alert("Please select set first");
            return;
        }
        let url='<? echo $ajaxFilePath ?>?open_omr_sheet=OK&';
        let formdata = new FormData();
        formdata.append('hId',hId);
        formdata.append('sId',sId);
        formdata.append('egId',egId);
        formdata.append('set', set);
        formdata.append('open_omr_sheet','OK' );


        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            UIkit.modal.dialog(data);
        },url,formdata);
    }

    function attempt(qId, ans_el){
        let answer_container = document.querySelector(".answer-container-"+qId);

        answer_container.querySelectorAll("input[type=checkbox]").forEach(inpt=>{
            if(inpt!==ans_el){
                inpt.checked = false;
            }
        })

        let status = ans_el.checked;
    }
    function answer_by_student(studentId, historyId,radio_id, questionId, examdetailsId, exam_group_id, exammId, count){


        let answer='';
        let oo=os.getObj(radio_id);
        if(oo.checked===true) {
            answer=oo.value;
        } else {
            oo.checked = false;
        }

        if(answer!==""){
            $("#matrix_content_"+count+" input").prop('checked', true);
        } else {
            $("#matrix_content_"+count+" input").prop('checked', false);
        }


        socket.emit("answer_by_student", {
            examId: exammId,
            exam_group_id: exam_group_id,
            studentId: studentId,
            questionId: questionId,
            examdetailsId: examdetailsId,
            answer: answer,
            historyId: historyId,

        });
    }


    function save_question_set(value, hId, eg_id){
        let formdata = new FormData();
        formdata.append("sheet", value);
        formdata.append("hId", hId);
        formdata.append("eg_id", eg_id);
        formdata.append("save_question_sheet", 'OK');

        let url='<? echo $ajaxFilePath ?>?save_question_sheet=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            alert(data);
        },url,formdata);
    }

</script>


<? include($site['root-wtos'].'bottom.php'); ?>


