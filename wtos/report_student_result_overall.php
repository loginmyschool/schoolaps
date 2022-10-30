<?
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'top.php');

?>
<?
$pluginName='';
$listHeader='Overall Result Report';
$ajaxFilePath= 'report_student_result_overall_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$access_name = "Overall Result Report";
$branch_codes = $os->get_branches_by_access_name($access_name);

?>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <div class="uk-padding-small ">
            <div class="uk-grid uk-grid-small" uk-grid>
                <div uk-tooltip="Select Branch">
                    <select name="branch_code_s" id="branch_code_s"
                            onblur="get_asession_by_branch_code()"
                            class="uk-select uk-border-rounded congested-form select2">
                        <option value="">--BRANCH--</option>
                        <? $os->onlyOption($branch_codes,'');	?>
                    </select>
                </div>
                <div uk-tooltip="Session">
                    <div class="uk-inline">
                        <select name="asession" id="asession_s"
                                class="uk-select uk-border-rounded congested-form"
                                onblur="get_class_by_session()">
                            <option value=""> </option>	<?
                            $os->onlyOption($os->asession);
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
                                class="uk-select uk-border-rounded congested-form">
                        </select>
                    </div>
                </div>

                <div uk-tooltip="Gender">
                    <div class="uk-inline">
                        <select name="gender_s" id="gender_s"
                                class="uk-select uk-border-rounded congested-form">
                            <option value="">---SELECT GENDER---</option>
                            <? $os->onlyOption($os->gender)?>
                        </select>
                    </div>
                </div>

                <div uk-tooltip="Register No">
                    <div class="uk-inline">
                        <input name="registerNo_s" id="registerNo_s"/>
                    </div>
                </div>
                <div>
                    <input type="button" value="Search" onclick="resultDetailsListing();" style="cursor:pointer;"/>
                    <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>
                </div>


            </div>
        </div>
        <div class="uk-grid uk-grid-small">
            <div id="id_ajaxViewMainTableTDForm">
            </div>
            <div id="ajaxViewMainTableTDList_id" class="uk-width-1-1">
                <div id="reoprtAdmissionReadmissionListDiv"  class="uk-width-1-1">&nbsp; </div>
            </div>
            <div id="TD_ID_for_other_function"  class="uk-width-1-1" >
                <div id="TD_ID_for_other_function_DIV"  class="uk-width-1-1"></div>
            </div>
        </div>


        <div id="showStudent_details_DIV" style="background:#F0F0FF;"  >
            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
            <input type="hidden"  id="WT_admissionReadmissionPageno" value="1" />
        </div>
    </div>
</div>
<div id="resultdetailsmodal" uk-modal>
    <div class="uk-modal-body uk-modal-dialog" id="resultdetailsDIV">

    </div>
</div>
<script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"> </script>
<script type="text/x-mathjax-config">
    MathJax.Hub.Config({
        tex2jax: { inlineMath: [["$","$"],["\\(","\\)"]] },
        "HTML-CSS": {
            linebreaks: { automatic: true, width: "container" }
        }
    });
</script>
<script>
    //Auto completes
    function get_asession_by_branch_code()
    {
        let formdata = new FormData();

        formdata.append("branch_code_s", os.getVal("branch_code_s"));
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
</script>
<script>
    function resultDetailsListing() // list table searched data get
    {
        var formdata = new FormData();
        var asessionVal= os.getVal('asession_s');
        var classVal= os.getVal('class_s');
        var examIdVal= os.getVal('exam_s');
        var registerNoVal= os.getVal('registerNo_s');
        var genderVal= os.getVal('gender_s');
        if(classVal==''){ alert('Please Select Class '); return false;}
        if(examIdVal==''){ alert('Please Select Exam '); return false;}



        formdata.append('asession',asessionVal);
        formdata.append('class_s',classVal);
        formdata.append('examId_s',examIdVal);
        formdata.append('registerNo_s',registerNoVal);
        formdata.append('gender_s',genderVal);
        formdata.append('resultDetailsListingVal','OKS');


        formdata.append('branch_s','');


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
    function switchBranch(index)
    {
        let branches_list = document.querySelectorAll("#branches_list tr");
        branches_list.forEach((branch_item)=>{
            branch_item.classList.remove("branch_active");
        })
        branches_list[index].classList.add("branch_active");


        let branch_datas = document.querySelectorAll("#branch_datas table");
        branch_datas.forEach((branch_item)=>{
            branch_item.style.display = 'none';
        })
        branch_datas[index].style.display='table';
    }
    function resultDetailsView(resultsDetailsId) // list table searched data get
    {
        var formdata = new FormData();

        formdata.append('resultsdetailsId',resultsDetailsId);
        formdata.append('WT_resultdetailsView','OK');


        var WT_admissionReadmissionPageno=os.getVal('WT_admissionReadmissionPageno');
        var url='wtpage='+WT_admissionReadmissionPageno;
        url='<? echo $ajaxFilePath ?>?WT_resultdetailsView=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('resultDetailsViewResult',url,formdata);
    }
    function resultDetailsViewResult(data)
    {

        let dataContainer = document.querySelector("#resultdetailsDIV");
        dataContainer.innerHTML = data;
        UIkit.modal("#resultdetailsmodal").show();

    }
</script>
<style>
    .branch_active{
        background-color: #008cff !important;
        color: #ffffff !important;
    }
</style>

<? include($site['root-wtos'].'bottom.php'); ?>
