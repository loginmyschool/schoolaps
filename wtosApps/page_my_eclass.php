<?
global $os,$pageVar, $site;
$ajaxFilePath= $site['url'].'wtosApps/page_my_eclass_Ajax.php';
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$studentId = $os->userDetails['studentId'];
$studentType = $os->userDetails["student_type"];
/*******
 * Details
 */

    $asession_classes = [];
    $query = $os->mq("SELECT e.* FROM eclass_access eca 
    INNER JOIN eclass e on eca.eclass_id = e.eclass_id
    INNER JOIN history h ON h.class=eca.class AND h.asession=eca.session AND h.studentId='$studentId'
  
    LEFT JOIN subscription_structure ss on ss.asession=eca.session AND ss.classId=eca.class
    LEFT JOIN subscription s on ss.subscription_structure_id=s.subscription_structure_id  AND h.historyId = s.historyId AND s.payment_status='Paid'
    WHERE s.subscription_id > 0 OR e.for_non_subscriber=1 OR '$studentType'!='nonresidential'");

    $eclassIdAccess = [];
    while ($row=$os->mfa($query)){
        $asession_classes[$row["class"]] = $os->classList[$row["class"]];
        $eclassIdAccess[] = $row["eclass_id"];
    }
    $eclassIdAccess = implode(",", $eclassIdAccess);

    $class = $os->get("class");
    $dated = $os->get("date");
    $moment_date = new \Moment\Moment($dated);
    ?>
    <section class="search-panel uk-margin">
        <form>

            <label class="uk-inline">
                <select name="class" id="class" class="uk-select uk-form-small p-right-xxxxl" required>
                    <option value="">Select Class</option>
                    <? $os->onlyOption($asession_classes, $class);	?></select>
            </label>

            <label class="uk-inline">
                <input name="date" id="date" class="uk-input datepicker uk-form-small" type="date" value="<?= $moment_date->cloning()->format("Y-m-d")?>"/>
            </label>


            <button type="submit" class="uk-button uk-button-secondary uk-button-small">Search</button>

        </form>
    </section>

    <section class="uk-margin">
        <?if($class!=""){
            $andClass = $os->getAndQuery("class","ec.class","=");

            $subjectDetails = $os->get_subjects_by_class($class);
            $andDated = "AND DATE(ec.dated) = DATE('".$moment_date->cloning()->format("Y-m-d")."')";

            $sql = "SELECT ec.*, s.subjectName, s.subjectId, 
                    CONCAT('[',GROUP_CONCAT(concat('{',
                        '\"eclass_doc_id\":\"',ed.eclass_doc_id, '\",'
                        '\"title\":\"',ed.title, '\",'
                        '\"file\":\"',ed.file, '\",'
                        '\"type\":\"',ed.type, '\"'
                        '}')),']') as docs
                    FROM eclass ec
                    INNER JOIN  subject s ON s.subjectId=ec.subject_id
                    LEFT JOIN eclass_doc ed on ed.eclass_id=ec.eclass_id
                    WHERE ec.eclass_id IN($eclassIdAccess) $andDated $andClass  GROUP BY ec.eclass_id";
            $eclasses_res = $os->mq($sql);

            $sub_eclasses= [];
            while($eclass = $os->mfa($eclasses_res)){
                $sub_eclasses[$eclass["subjectId"]][] = $eclass;
            }
            ?>
            <h4><?= $moment_date->getWeekdayNameLong()?></h4>
            <?
            foreach ($sub_eclasses as $subject => $eclasses){
                ?>
                <table class="uk-table uk-table-small  uk-table-striped uk-card-outline uk-card-default uk-text-small">
                    <thead>
                    <tr>

                        <td><?=$subjectDetails[$subject]["subjectName"]?></td>
                        <td class="uk-table-shrink"></td>
                        <td class="uk-table-shrink"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($eclasses as $eclass){?>
                        <tr class="pointable">

                            <td title="Title"><?= $eclass["title"]?></td>
                            <td class="uk-text-nowrap">
                                <a onclick="playVideo('<?= addslashes($eclass["video_link"])?>', '#modal-media-youtube-<?= $eclass["eclass_id"]?>')">Watch Video</a>
                                <div id="modal-media-youtube-<?= $eclass["eclass_id"]?>" class="uk-flex-top " uk-modal>
                                    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                                        <button class="uk-modal-close-outside" type="button" uk-close></button>
                                        <video src="<?= $eclass["video_link"]?>" width="1920" height="1080" controls controlsList="nodownload" playsinline uk-video uk-responsive allowfullscreen></video>
                                    </div>
                                </div>
                            </td>
                            <td class="uk-text-nowrap">
                                <a href="#modal-docs-<?= $eclass["eclass_id"]?>" uk-toggle>Docs</a>
                                <div id="modal-docs-<?= $eclass["eclass_id"]?>" class="uk-flex-top " uk-modal>
                                    <div class="uk-modal-dialog">
                                        <button class="uk-position-absolute uk-position-top-right uk-position-small" type="button" uk-close></button>
                                        <div class="uk-modal-header">
                                            <h5>Documents</h5>
                                        </div>
                                        <div class="uk-modal-body">
                                            <?
                                            $docs = json_decode($eclass["docs"], true);
                                            foreach ($docs as $doc){
                                                ?>
                                                <li>
                                                    <a target="_blank" href="<?=$site["url"]."wtos-images/".$doc["file"]?>"><?=$doc["title"]?></a>
                                                </li>
                                                <?
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
                <?
            }
            $moment_next =  $moment_date->cloning()->subtractDays(1);
            $moment_prev =  $moment_date->cloning()->addDays(1);
            ?>
            <a class="uk-button uk-button-small uk-button-default"
               href="?class=<?=$class?>&date=<?=$moment_next->format("Y-m-d")?>">
                <span uk-icon="chevron-left"></span>
                Previous Day(<?= $moment_prev->getWeekdayNameShort()?>)
            </a>
            <a class="uk-button uk-button-small uk-button-default"
               href="?class=<?=$class?>&date=<?= $moment_prev->format("Y-m-d")?>">
                Next Day(<?= $moment_next->getWeekdayNameShort()?>)
                <span uk-icon="chevron-right"></span>
            </a>
        <?}else{?>
            <h4>Please Select Class and Subject</h4>
        <?}?>
    </section>

    <script>
        function getData(string,seperator)
        {
            var D=string.split(seperator);
            return D[1];
        }
        function wt_ajax_chain(action_string,query_plus,call_back_php,call_back_script)
        {
            var  conditions_val_str='';
            var actionARR=action_string.split('*');

            var  output_type=actionARR[0];
            var field_id=actionARR[1];
            var tableField=actionARR[2];
            var conditions=actionARR[3];
            conditions_arr=conditions.split(',');

            for (i = 0; i < conditions_arr.length; i++)
            {
                var D=conditions_arr[i].split('=');


                if(D[1]!='')
                {
                    condition_field_id=D[1];

                    var   condition_field_val=os.getVal(condition_field_id);

                    conditions_val_str =conditions_val_str +	D[0]+'='+condition_field_val+', ';

                }
            }


            var formdata = new FormData();

            formdata.append('output_type',output_type );
            formdata.append('field_id',field_id );
            formdata.append('tableField',tableField );
            formdata.append('conditions_val_str',conditions_val_str );
            formdata.append('wt_ajax_chain','OK' );
            formdata.append('call_back_script',call_back_script );
            formdata.append('call_back_php',call_back_php );
            formdata.append('query_plus',query_plus );
            var url='<? echo $site['url'] ?>wtosApps/wtAjax.php?wt_ajax_chain=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('wt_ajax_chain_results',url,formdata);

        }
        function wt_ajax_chain_results(data)
        {
            var output_type=	getData(data,'##--output_type--##');
            var content_data=	getData(data,'##--ajax_chain_data--##');
            var ajax_chain_data_fild=	getData(data,'##--ajax_chain_data_fild--##');

            if(output_type=='html')
            {
                os.setHtml(ajax_chain_data_fild,content_data);
            }else
            {
                os.setVal(ajax_chain_data_fild,content_data);

            }

            var call_back_script=	getData(data,'##-call_back_script-##');

            if(call_back_script!='')
            {
                setTimeout(call_back_script, 1);
            }


        }

    </script>



