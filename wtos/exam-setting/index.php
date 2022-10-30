<?

/*

# wtos version : 1.1

# main ajax process page : feesAjax.php

#

 */

include './../wtosConfigLocal.php';
include $site['root-wtos'] . 'top.php';

$pluginName = '';
$os->loadPluginConstant($pluginName);

$_title = 'Exam Setting';
$_ajax_file = 'ajax.php';
$_ajax_url = $site["url-wtos"] . "exam-setting/" . $_ajax_file;

//access
$_access_name = "Exam Settings";
$_selected_branch_code = $os->getSession('selected_branch_code');

$_branch_access = $os->get_branches_by_access_name($_access_name);
$_global_access = $os->get_global_access_by_name($_access_name);
?>

<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php echo $_title; ?></h4>
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
        <form class="uk-padding-small uk-padding-remove-bottom" onsubmit="get_exams(event)" id="exam-search-form">
            <div class="uk-inline" uk-tooltip="Select Branch">
                <select id="branch_code_s" name="branch_code_s" class="uk-select uk-border-rounded congested-form p-left-xxxl select2">

                    <? if (in_array("View", $_global_access) || $os->userDetails["adminType"] == "Super Admin") { ?>
                        <option value="">Branch</option>
                    <? } ?>
                    <? $os->onlyOption($_branch_access, ''); ?>
                </select>
            </div>


            <div class="uk-inline" uk-tooltip="Select Board">
                <select name="asession_s" id="asession_s" class="uk-select uk-border-rounded congested-form p-left-xxxl">
                    <option value=""> </option>
                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession, $os->selectedSession());
                    ?>
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Select Board">
                <select name="board_s" id="board_s" class="uk-select uk-border-rounded congested-form p-left-xxxl" onchange="populate_class_by_board(this.value, '#class_s')">
                    <option value="">Board</option>
                    <? $os->onlyOption($os->board, ''); ?>
                </select>
            </div>

            <div class="uk-inline" uk-tooltip="Select Class">
                <select name="class_s" id="class_s" class="uk-select uk-border-rounded congested-form p-left-xxxl">
                    <option value="">Class</option>
                </select>
            </div>

            <button class="uk-button uk-border-rounded congested-form uk-secondary-button  uk-flex-inline uk-flex-middle" type="submit" id="exam_search_button">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded congested-form uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>

        </form>

        <div id="exam-list-container" class="uk-padding-small">
            Please search to view exams
        </div>


    </div>
</div>
<script>
    function get_exams(e) {
        e.preventDefault();
        const fd = new FormData(e.target);
        fd.append("get_exams", "OK");
        const url = "<?= $_ajax_url ?>?get_exams=OK";
        const container = document.querySelector("#exam-list-container");
        container.classList.add("is-loading");
        $.ajax({
            type: 'POST',
            url: url,
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: (response) => {
                container.innerHTML = response;
            },
            complete: () => {
                container.classList.remove("is-loading");
            }
        });
    }
</script>
<script>
    function delete_exam(examId) {
        if (confirm("Are you sure?")) {
            let fd = new FormData();
            fd.append("examId", examId);
            fd.append("delete_exam", "OK")
            let url = '<? echo $_ajax_url ?>?delete_exam=OK&';
            $.ajax({
                type: 'POST',
                url: url,
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                success: (res) => {
                    document.getElementById("exam_search_button").click();
                }
            });
        }
    }

    function delete_exam_group(exam_group_id) {
        if (confirm("Are you sure?")) {
            let fd = new FormData();
            fd.append("exam_group_id", exam_group_id);
            fd.append("delete_exam_group", "OK")
            let url = '<?= $_ajax_url ?>?delete_exam_group=OK&';
            $.ajax({
                type: 'POST',
                url: url,
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                success: (res) => {
                    document.getElementById("exam_search_button").click();
                }
            });
        }
    }

    function delete_examdetails(examdetailsId) {
        if (confirm("Are you sure?")) {
            let fd = new FormData();

            fd.append("examdetailsId", examdetailsId);
            fd.append("delete_examdetails", "OK")
            let url = '<?= $_ajax_url ?>?delete_examdetails=OK&';

            $.ajax({
                type: 'POST',
                url: url,
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                success: (res) => {
                    document.getElementById("exam_search_button").click();
                }
            });
        }
    }
</script>
<script>
    /*
     * Exam group starts here
     */
    //open exam group form dialog
    function open_exam_group_form(examId, exam_group_id = "") {
        const fd = new FormData();
        fd.append("examId", examId);
        fd.append("exam_group_id", exam_group_id);
        fd.append("open_exam_group_form", "OK");

        const url = "<?= $_ajax_url ?>?open_exam_group_form=OK";
        $.ajax({
            type: 'POST',
            url: url,
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: (response) => {
                window.exam_group_form_dialog = UIkit.modal.dialog(response);
            }
        });
    }
    //save exam group
    function save_exam_group(e) {
        console.log(e);
        e.preventDefault();
        const fd = new FormData(e.target);
        fd.append("save_exam_group", "OK")
        const url = '<?= $_ajax_url ?>?save_exam_group=OK&';
        $.ajax({
            type: 'POST',
            url: url,
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: (response) => {
                window.exam_group_form_dialog?.hide();
                alert("Successful");
                document.getElementById("exam_search_button").click();
            }
        });
    }

    function open_exam_form(examId = 0) {
        let fd = new FormData();

        fd.append('examId', examId);
        fd.append('open_exam_form', 'OK');

        let url = '<? echo $_ajax_url ?>?open_exam_form=OK&';

        $.ajax({
            type: 'POST',
            url: url,
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: (res) => {
                window.simple_exam_form_modal = UIkit.modal.dialog(res);
                setTimeout(() => {
                    $("#exam_form").ajaxForm((e) => {
                        alert("Successful");
                        window.simple_exam_form_modal?.hide();
                        document.getElementById("exam_search_button").click();
                    });
                }, 50);
            }
        });
    }

    //save exam details
    function open_simple_examdetails_form(examId, examDetailsId = "") {
        var fd = new FormData();
        fd.append("examId", examId);
        fd.append("examdetailsId", examDetailsId);
        fd.append("simple_examdetails_form", "OK")

        let url = '<?= $_ajax_url ?>?simple_examdetails_form=OK&';
        $.ajax({
            type: 'POST',
            url: url,
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: (res) => {
                window.simple_examdetails_form_modal = UIkit.modal.dialog(res);
            }
        });
    }

    function save_simple_examdetails_form(event) {
        event && event.preventDefault();
        const form = event ? event.target : document.getElementById("simple_examdetails_form");
        var fd = new FormData(form);
        fd.append("save_simple_examdetails_form", "OK")

        let url = '<?= $_ajax_url ?>?save_simple_examdetails_form=OK&';
        $.ajax({
            type: 'POST',
            url: url,
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: (res) => {
                window.simple_examdetails_form_modal?.hide();
                alert("Successful");
                document.getElementById("exam_search_button").click();
            }
        });
    }
</script>

<script>
$( document ).ajaxStart(function() {
    $("#div_busy").text("Please wait while loading");
});

$( document ).ajaxComplete(function() {
    $("#div_busy").text( "");
});
</script>





<? include $site['root-wtos'] . 'bottom.php'; ?>