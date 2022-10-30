<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/



include('wtosConfigLocal.php');

include($site['root-wtos'] . 'top.php');


$pluginName = '';

$listHeader = 'Exam Setting';

$ajaxFilePath = 'exam_setting_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage = $site['url-wtos'] . 'images/loadingwt.gif';

$branchCode = $os->getSession($key1 = 'selected_branch_code');
$all_branch_list = $os->get_branches_by_access_name("Exam Settings");
$access_name = "Exam Settings";
//access
$global_access = $os->get_global_access_by_name($access_name);
?>




<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <div class="uk-inline uk-margin-small-right">
                <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button " onclick="open_exam_form(0)">
                    <span uk-icon="icon:  plus; ratio:0.7" class="m-right-s"></span>
                    Add New
                </button>
            </div>
        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <div class="uk-padding-small uk-padding-remove-bottom">
            <div class="uk-inline" uk-tooltip="Select Branch">
                <select id="branch_code_s" class="uk-select uk-border-rounded congested-form p-left-xxxl select2">

                    <? if (in_array("View", $global_access) || $os->userDetails["adminType"] == "Super Admin") { ?>
                        <option value="">Branch</option>
                    <? } ?>
                    <? $os->onlyOption($all_branch_list, '');    ?>
                </select>
            </div>


            <div class="uk-inline" uk-tooltip="Select Board">
                <select name="asession" id="asession_s" class="uk-select uk-border-rounded congested-form p-left-xxxl">
                    <option value=""> </option>
                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession, $os->selectedSession());
                    ?>
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Select Board">
                <select name="board_s" id="board_s" class="uk-select uk-border-rounded congested-form p-left-xxxl" onchange="populate_class_by_board(this.value)">
                    <option value="">Board</option>
                    <? $os->onlyOption($os->board, '');    ?>
                </select>
            </div>

            <div class="uk-inline" uk-tooltip="Select Class">
                <select name="classList" id="classList_s" class="uk-select uk-border-rounded congested-form p-left-xxxl">
                    <option value="">Class</option>
                </select>
            </div>

            <button onclick="manage_exam_setting('search');" class="uk-button uk-border-rounded congested-form
            uk-secondary-button  uk-flex-inline uk-flex-middle" type="button">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded congested-form uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>

        </div>

        <div id="WT_feesListDiv" class="uk-padding-small">&nbsp; </div>

    </div>
</div>


<div id="add-form-modal" uk-modal>
    <div class="uk-modal-dialog uk-width-large uk-modal-body ">
        <button class="uk-modal-close-default" uk-close></button>
        <div id="exam_form_container">
            <form id="exam_form" action="<?= $ajaxFilePath ?>?save_exam=OK" method="post" enctype="multipart/form-data">
                <div>
                    <h4>Create/Edit Exam Head</h4>
                    <input class="uk-hidden" name="save_exam" value="OK">

                    <input class="uk-hidden" type="number" name="examId" id="examId" value="0">

                    <div class="uk-margin-small">
                        <input required class="uk-input uk-border-rounded congested-form uk-text-bold" type="text" name="examTitle" id="examTitle" value="" />
                    </div>


                    <select name="asession">
                        <? $os->onlyOption($os->asession, $os->selectedSession()); ?>
                    </select>
                    <div class="uk-margin-small">
                        Class
                        <select name="class" id="class" class="uk-select uk-border-rounded congested-form">
                            <? foreach ($os->board as $board) : ?>
                                <optgroup label="<?= $board ?>">
                                    <? foreach ($os->board_class[$board] as $class) : ?>
                                        <option value="<?= $class ?>"><?= $os->classList[$class] ?></option>
                                    <? endforeach; ?>
                                </optgroup>
                            <? endforeach; ?>

                        </select>
                    </div>

                    <?
                    $branches = $os->get_branches_by_access_name("Exam Settings");
                    ?>
                    <div class="border-xxs uk-border-rounded uk-overflow-hidden uk-margin" style="border-color: #ddd">
                        <p class="uk-background-muted p-m p-top-s p-bottom-s" style="border-bottom: 1px solid #ddd">BRANCH ACCESS</p>

                        <div class="uk-height-small uk-overflow-auto p-m">

                            <?

                            foreach ($branches as $branch_code => $branch_name) {
                            ?>
                                <div>
                                    <label>
                                        <input type="checkbox" class="uk-checkbox branch_codes" name="branch_codes[]" value="<?= $branch_code ?>" <?= sizeof($branches) == 1 ? "checked onclick='return false;'" : "" ?>>
                                        <?= $branch_name ?>
                                    </label>
                                </div>
                            <? } ?>
                            <style>
                                input[type="checkbox"][readonly] {
                                    pointer-events: none;
                                }
                            </style>
                        </div>
                    </div>

                    <button class="uk-button uk-border-rounded congested-form uk-secondary-button" name="button" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="WT_result_entry_access_listing_DIV">

</div>
<script>
    /////
    function get_subjects_by_class() // get record by table primery id
    {
        var formdata = new FormData();

        var asession = os.getVal('asession_s');
        formdata.append('asession', asession);

        var classes = os.getVal('classes');
        formdata.append('classes', classes);

        formdata.append('get_subjects_by_class', 'OK');


        var url = '<? echo $ajaxFilePath ?>?get_subjects_by_class=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('get_subjects_by_class_results', url, formdata);

    }

    function get_subjects_by_class_results(data) // fill data form by JSON
    {

        var content_data = getData(data, '##--SUBJECT-BY-CLASS--##');
        os.setHtml('subject_by_class_div', content_data);

        //var objJSON = JSON.parse(data);
        // os.setVal('product_id',parseInt(objJSON.product_id));



    }

    function calculate_total() {
        var written = os.getVal('written');

        var viva = os.getVal('viva');

        var practical = os.getVal('practical');

        var totalMarks = int(written) + int(viva) + int(practical);

        os.setVal('totalMarks', totalMarks);

    }

    function manage_exam_setting(button) // get record by table primery id
    {

        var formdata = new FormData();

        var classList_s = os.getVal('classList_s');
        formdata.append('classList_s', classList_s);

        var asession = os.getVal('asession_s');
        formdata.append('asession', asession);

        var asession = os.getVal('branch_code_s');
        formdata.append('branch_code_s', asession);

        if (classList_s === "") {
            alert('please select class');
            return false;
        }
        formdata.append('manage_exam_setting', 'OK');
        var url = '<? echo $ajaxFilePath ?>?manage_exam_setting=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage ?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('manage_exam_setting_results', url, formdata);

    }

    function manage_exam_setting_results(data) // fill data form by JSON
    {
        var content_data = getData(data, '##--EXAM-SETTING-DATA--##');
        os.setHtml('WT_feesListDiv', content_data);
        UIkit.modal("#add-form-modal").hide();
    }

    function searchReset() {
        os.setVal('classList_s', '');
        manage_exam_setting('search');
    }
    //manage_exam_setting('search');
    ////Viva details
    function view_viva_details(examdetailsId) {
        var formdata = new FormData();

        formdata.append('examdetailsId', examdetailsId);

        formdata.append('view_viva_details', 'OK');


        var url = '<? echo $ajaxFilePath ?>?view_viva_details=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc('view_viva_details_result', url, formdata);

    }

    function view_viva_details_result(data) {
        UIkit.modal.dialog(data);
    }

    function insert_new_exam_viva_details(el, parent_index) {
        let last_index = Math.floor(Math.random() * 999999) + 11111;
        let content = '';
        let classes = 'uk-input uk-border-rounded congested-form';
        if (parent_index == null) {
            content =
                `<li>
                    <div class="uk-grid uk-child-width-expand uk-grid-small" uk-grid>
                        <div>
                            <input placeholder="Title" class="${classes}" name="exam_viva_details[${last_index}][title]">
                        </div>
                        <div class="uk-width-auto">
                            <input placeholder="Marks"
                                id="viva_parent_mark_${last_index}"
                                onchange="calculate_marks('.viva_parent_marks', '#viva_marks')"
                                style="width: 50px" class="${classes} viva_parent_marks"
                                name="exam_viva_details[${last_index}][marks]">
                        </div>
                        <div class="uk-width-auto">
                            <a class="uk-text-danger" uk-icon="icon:trash; ratio:0.9"
                               onclick="remove_exam_viva_details(this);calculate_marks('.viva_parent_marks', '#viva_marks')"></a>
                        </div>
                    </div>
                    <ul class="uk-list p-left-xl">
                        <li>
                            <a onclick="insert_new_exam_viva_details(this, ${last_index})">Insert</a>
                        </li>
                    </ul>
                </li>`;
        } else {
            content = `<li>
                            <div class="uk-grid uk-child-width-expand uk-grid-small" uk-grid>
                                <div class="uk-width-auto"></div>
                                <div>
                                    <input placeholder="Title" class="${classes}" name="exam_viva_details[${parent_index}][sub_head][${last_index}][title]">
                                </div>
                                <div class="uk-width-auto">
                                    <input placeholder="Marks"
                                        class="${classes} viva_child_mark_${parent_index}" style="width: 50px"
                                        onchange="calculate_marks('.viva_child_mark_${parent_index}',
                                        '#viva_parent_mark_${parent_index}')"
                                        name="exam_viva_details[${parent_index}][sub_head][${last_index}][marks]">
                                </div>
                                <div class="uk-width-auto">
                                    <a class="uk-text-danger" uk-icon="icon:trash; ratio:0.9"
                                        onclick="remove_exam_viva_details(this); calculate_marks('.viva_child_mark_${parent_index}',
                                        '#viva_parent_mark_${parent_index}')"></a>
                                </div>
                            </div>
                       </li>`;
        }

        $(el).parent('li').before(content);
    }

    function remove_exam_viva_details(el) {
        $(el).closest('li').remove();
    }

    function save_exam_viva_details(examdetailsId) {
        let url = '<? echo $ajaxFilePath ?>?save_exam_viva_details=OK&';
        $.ajax({
            type: 'POST',
            url: url,
            data: $('#sub_exam_viva_details_form').serialize() + "&save_exam_viva_details=OK"
        });
    }
    ///Extra function
    function calculate_marks(child, parent, trigger_parent = true) {

        let parent_input = document.querySelector(parent);
        let child_inputs = document.querySelectorAll(child);
        let total_marks = 0;
        child_inputs.forEach(child => {
            let v = parseInt(child.value) ? parseInt(child.value) : 0;
            //child.value = parseInt(child.value)?parseInt(child.value):0;
            total_marks += parseInt(v);
        });

        parent_input.value = total_marks;
        ////////////////////////////////
        if (trigger_parent) {
            $(parent_input).trigger("change");
        }
    }
    //
    function open_exam_form(examId = 0) {
        UIkit.modal('#add-form-modal').show();
        $("#exam_form").resetForm();
        if (examId === 0) {
            //return ;
        }

        let fd = new FormData();

        fd.append('examId', examId);
        fd.append('open_exam_form', 'OK');

        let url = '<? echo $ajaxFilePath ?>?open_exam_form=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc(function(res) {
            $("#exam_form_container").html(res);
            setTimeout(() => {
                $("#exam_form").ajaxForm((e) => {
                    alert("Successfull");
                    UIkit.modal('#add-form-modal').hide();
                });
            }, 50);
        }, url, fd);
    }


    //Exam group
    let exam_group_form = '';

    function open_exam_group_form(examId, exam_group_id = 0) {
        let fd = new FormData();

        fd.append('examId', examId);
        fd.append('exam_group_id', exam_group_id);
        fd.append('open_exam_group_form', 'OK');

        let url = '<? echo $ajaxFilePath ?>?open_exam_group_form=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc(function(res) {
            exam_group_form = UIkit.modal.dialog(res);
        }, url, fd);
    }
    //Save exam group
    function save_exam_group(form_id) {

        let serialized_array = $(form_id).serializeArray();
        let formdata = new FormData();
        serialized_array.forEach(function(pair) {
            formdata.append(pair.name, pair.value);
        })

        formdata.append("save_exam_group", "OK")
        let url = '<? echo $ajaxFilePath ?>?save_exam_group=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc(function(res) {
            //UIkit.modal.dialog(res);
            exam_group_form.hide();
            manage_exam_setting();
        }, url, formdata);
    }
    ///
    function save_examdetails(formId) {
        let form = document.querySelector(formId);
        let items = form.querySelectorAll('input, select, textarea');
        let formdata = new FormData();
        items.forEach(function(item) {
            formdata.append(item.name, item.value);
        });

        formdata.append("save_examdetails", "OK")
        let url = '<? echo $ajaxFilePath ?>?save_examdetails=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc(function(res) {
            res = JSON.parse(res);
            alert(res.message);
            if (!res.error) {
                manage_exam_setting();
            }

            //manage_exam_setting();
        }, url, formdata);

    }

    function delete_exam(examId) {
        if (confirm("Are you sure?")) {


            let formdata = new FormData();

            formdata.append("examId", examId);

            formdata.append("delete_exam", "OK")
            let url = '<? echo $ajaxFilePath ?>?delete_exam=OK&';
            os.animateMe.div = 'div_busy';
            os.animateMe.html = 'Please wait while loading...';
            os.setAjaxFunc(function(res) {
                alert(res);
                manage_exam_setting();
            }, url, formdata);
        }
    }

    function delete_exam_group(exam_group_id) {
        if (confirm("Are you sure?")) {
            let formdata = new FormData();
            formdata.append("exam_group_id", exam_group_id);
            formdata.append("delete_exam_group", "OK")
            let url = '<? echo $ajaxFilePath ?>?delete_exam_group=OK&';
            os.animateMe.div = 'div_busy';
            os.animateMe.html = 'Please wait while loading...';
            os.setAjaxFunc(function(res) {
                alert(res);
                manage_exam_setting();
            }, url, formdata);
        }
    }

    function delete_examdetails(examdetailsId) {
        if (confirm("Are you sure?")) {
            let formdata = new FormData();

            formdata.append("examdetailsId", examdetailsId);

            formdata.append("delete_examdetails", "OK")
            let url = '<? echo $ajaxFilePath ?>?delete_examdetails=OK&';
            os.animateMe.div = 'div_busy';
            os.animateMe.html = 'Please wait while loading...';
            os.setAjaxFunc(function(res) {
                alert(res);
                manage_exam_setting();
            }, url, formdata);
        }
    }
    ////////
    function WT_result_entry_access_listing(edId) {

        var fd = new FormData();
        fd.append("WT_result_entry_access_listing", "OK");
        fd.append("edId", edId);
        $.ajax({
            method: 'post',
            contentType: false,
            processData: false,
            url: "<?= $ajaxFilePath ?>?WT_result_entry_access_listing=OK",
            data: fd,
            success: (data) => {
                $("#WT_result_entry_access_listing_DIV").html(data);
                $("#WT_result_entry_access_listing_DIV").dialog({
                    title: 'Result Entry Access',
                    height: 500,
                    width: 900
                });
            }
        });
    }

    function toggle_branches(order, container) {
        document.querySelector(container).style.display = (order ? "none" : "block");
        if (!order) {

            document.querySelectorAll(`${container} input`).forEach((el) => {

                el.checked = order;

            })
        }

    }


    //=========WRITTEN GROUPS=======//
    function view_written_section(examdetailsId) {
        var formdata = new FormData();

        formdata.append('examdetailsId', examdetailsId);
        formdata.append('view_viva_details', 'OK');


        var url = '<? echo $ajaxFilePath ?>?view_written_section=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc((data) => {
            UIkit.modal.dialog(data);
            //alert(data.toString());
        }, url, formdata);

    }
    //
    function add_edit_written_section(examdetailsId, name, max_attempt, examdetails_section_id = 0) {
        var formdata = new FormData();

        formdata.append('examdetailsId', examdetailsId);
        formdata.append('name', name);
        formdata.append('max_attempt', max_attempt);
        formdata.append('examdetails_section_id', examdetails_section_id);
        formdata.append('add_edit_written_section', 'OK');

        var url = '<? echo $ajaxFilePath ?>?add_edit_written_section=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc((data) => {
            $("#written_sections").append($(data));
        }, url, formdata);
    }

    function delete_examdetails_section(examdetails_section_id) {
        var fd = new FormData();
        fd.append("delete_examdetails_section", "OK");
        fd.append("examdetails_section_id", examdetails_section_id);

        var url = '<? echo $ajaxFilePath ?>?delete_examdetails_section=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc((data) => {
            if (data === "OK") $("#written_section-" + examdetails_section_id).remove();
        }, url, fd);
    }
</script>


<script>
    function open_simple_examdetails_form(examId, examDetailsId = "") {
        var fd = new FormData();
        fd.append("examId", examId);
        fd.append("examdetailsId", examDetailsId);
        fd.append("simple_examdetails_form", "OK")

        let url = '<? echo $ajaxFilePath ?>?simple_examdetails_form=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc(function(res) {
            window.simple_examdetails_form_modal = UIkit.modal.dialog(res);
        }, url, fd);
    }

    function save_simple_examdetails_form(event) {
        event && event.preventDefault();
        const form = event ? event.target : document.getElementById("simple_examdetails_form");
        var fd = new FormData(form);
        fd.append("save_simple_examdetails_form", "OK")

        let url = '<? echo $ajaxFilePath ?>?save_simple_examdetails_form=OK&';
        os.animateMe.div = 'div_busy';
        os.animateMe.html = 'Please wait while loading...';
        os.setAjaxFunc(function(res) {
            manage_exam_setting(null);
            window.simple_examdetails_form_modal?.$el.remove();
        }, url, fd);
    }

    function print_div(id) {
        w = window.open();
        w.document.write($(`#${id}`).html());
        w.print();
        //w.close();

    }
</script>


<style>
    .exam_subject {
        width: 700px;
        height: 250px;
        border: 1px dotted #409FFF;
        background-color: #FFFFFF;
        margin: 10px;
        float: left;
        letter-spacing: 1px;
        border-radius: 8px;
    }

    .exam_subject_head {
        padding: 7px;
        border-radius: 8px 8px 0px 0px;
        font-size: 16px;
        font-weight: bold;
        color: #000066;
        margin-bottom: 10px;
        border-bottom: 1px dotted #75BAFF;
        background-color: #CCE6FF;
    }

    .subject_table_class {
        width: 100%;
    }

    .subject_table_class td {
        padding: 3px;
        line-height: 14px;
        overflow: auto;
        border-bottom: #CAE4FF 1px dotted;
    }

    /* .subject_table_class tr:nth-child(odd) {background:#E8FFFF;}*/
    .subject_table_class_tr {
        font-weight: bold;
    }

    .teacherArr {
        border: 0px solid #CCCCCC;
    }
</style>


<? include($site['root-wtos'] . 'bottom.php'); ?>