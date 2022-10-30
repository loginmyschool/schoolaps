<?
include('wtosConfigLocal.php');
global $site, $os;
include($site['root-wtos'].'top.php');
?>
<?
$pluginName='';
$listHeader='Student Result Report';
$ajaxFilePath= 'report_student_result_overall_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$classAndSectionA= array();
$classQ='SELECT DISTINCT class FROM resultsdetails   order by class';
$classMq = $os->mq($classQ);
while ($classRow = $os->mfa($classMq))
{
    $classA[]=$classRow['class'];
}
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
                <div>
                    Session:
                    <div class="uk-inline">
                        <select name="asession" id="asession_s" class="uk-select uk-border-rounded congested-form" ><option value=""> </option>
                            <? $os->onlyOption($os->asession,$os->selectedSession()); ?>
                        </select>
                    </div>
                </div>
                <div>
                    Class:
                    <div class="uk-inline">
                    <select name="class_s" id="class_s"
                            class="uk-select uk-border-rounded congested-form"
                            onchange="wt_ajax_chain('html*examId*exam,examId,examTitle*class=class_s','AND asession=\''+os.getVal('asession_s')+'\'','','');">
                        <option value=""> </option>
                        <?foreach ($os->board as $board):?>
                            <optgroup label="<?= $board?>">
                                <?foreach ($os->board_class[$board] as $class):?>
                                    <option value="<?=$class?>"><?=$os->classList[$class]?></option>
                                <? endforeach;?>
                            </optgroup>
                        <? endforeach;?>
                    </select>
                    </div>
                </div>
                <div>
                    Exam Head:
                    <div class="uk-inline">
                        <select name="examId" id="examId" class="uk-select uk-border-rounded congested-form"
                                onchange="wt_ajax_chain('html*exam_group_id*exam_group,exam_group_id,exam_group_name*examId=examId','AND exam_mode=\'Online\'','','');">
                        </select>
                    </div>
                </div>
                <div>
                    Exam:
                    <div class="uk-inline">
                        <select name="exam_group_id" id="exam_group_id" class="uk-select uk-border-rounded congested-form" >
                        </select>
                    </div>
                </div>
                <div>
                    <button type="button"
                            value="Search"
                            class="uk-button congested-form uk-secondary-button uk-border-rounded"
                            onclick="WT_fetch_list()">Search</button>
                </div>


            </div>
        </div>
        <div class="uk-grid uk-grid-small">
            <div id="WT_list_div"  class="uk-width-1-1">&nbsp; </div>
        </div>
    </div>
</div>

<script>
    function WT_fetch_exams(){

    }
    function WT_fetch_list(){
        let exam_group_id = os.getVal("exam_group_id");
        let formdata = new FormData();

        formdata.append('exam_group_id', exam_group_id);
        formdata.append('WT_fetch_list','OK');

        let url='<? echo $ajaxFilePath ?>?WT_fetch_list=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please wait while working...';
        os.setAjaxHtml('WT_list_div',url,formdata);

    }
</script>

<? include($site['root-wtos'].'bottom.php'); ?>
