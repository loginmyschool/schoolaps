<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

if($os->get('manage_subject_setting')=='OK' && $os->post('subject_config')=='OK')
{
    $subject_list=$os->post('subject_list');
    $classList=$os->post('classList');
    $button=$os->post('button');


    if( $classList!='' && $subject_list!=''  && $button=='save'  )
    {


        $subject_listA=array_filter(explode(',',$subject_list));
        $classListA=array_filter(explode(',',$classList));



        foreach($classListA as $class_val)
        {
            foreach($subject_listA as $subject_list_val)
            {
                $subject_list_val= trim(strtoupper($subject_list_val));
                $dataToSave=array();
                $dataToSave['classId']=$class_val;
                $dataToSave['subjectStatus']='Active';
                $dataToSave['subjectName']=$subject_list_val;
				$dataToSave['board']='';


                $dataToSave['asession']='2020';
                $dataToSave['addedDate']=$os->now();
                $dataToSave['addedBy']=$os->userDetails['adminId'];

               $duplicate_query="select * from subject where classId!=''  and classId='$class_val'   and  subjectName='$subject_list_val'";
                $subjectId=$os->isRecordExist($duplicate_query,'subjectId');

                $qResult=$os->save('subject',$dataToSave,'subjectId',$subjectId);




            }


        }


    }


    $classList_s=$os->post('classList_s');

    $andClass='';
    if($classList_s!='')
    {
        $andClass=" and classId='$classList_s'";

    }

    $config_array=array();
	$sel="select * from subject where classId!=''   $andClass  ";
    $resset=$os->mq($sel);
    $elective=array();
    while($record=$os->mfa($resset))
    {
        $config_array[$record['board']][$record['classId']][$record['subjectId']]["subjectName"]=$record['subjectName'];
        $config_array[$record['board']][$record['classId']][$record['subjectId']]["subject_code"]=$record['subject_code'];
        $config_array[$record['board']][$record['classId']][$record['subjectId']]["asession"]=$record['asession'];

        $elective[$record['subjectId']]=$record['Elective'];
    }



    echo '##--SUBJECT-SETTING-DATA--##';?>

    <h2 class="uk-margin-small"> List of Subjects </h2>

	 <? foreach( $config_array as $board=>$boardData  ){ ?>
	  <h3 class="uk-margin-small"> Board <? echo $board ; ?> </h3>

	<div div class="uk-grid uk-grid-small uk-child-width-1-1" uk-grid="masonry:true">
        <? foreach( $boardData as $classId_val=>$subjectName_arr  ){


            $className=$os->classList[$classId_val];
            ?>
            <div>
                <div class="uk-card uk-card-small uk-card-default">
                    <div class="uk-card-header">Class:  <? echo $className  ?></div>
                    <div>
                        <table class="uk-table uk-table-small uk-table-striped congested-table">

                            <?
                            $cc=1;
                            foreach( $subjectName_arr as   $subjectId=>$subject )
                            {
                                $Elective=$elective[$subjectId];
                                $subjectName = $subject["subjectName"];
                                $subject_code = $subject["subject_code"];
                                $asession = $subject["asession"];



                                $exams = [];
                                $exams_q = $os->mq("SELECT  e.asession, e.class,e.examTitle, e.branch_codes  FROM examdetails ed INNER  JOIN  exam e ON e.examId=ed.examId WHERE ed.subjectId='$subjectId'");
                                while($e = $os->mfa($exams_q)){
                                    $exams[] = $e;
                                }

                                ?>

                                <tr>
                                    <td style="padding-left: 20px!important;"><? echo  $cc ?></td>
                                    <td>

                                        <input title="<? echo  $subjectName  ?>"
                                               class="uk-input congested-form"
                                               type="text"
                                               id="subjectId_edit_<? echo  $subjectId  ?>"
                                               value="<? echo  $subjectName  ?>"
                                               onchange="wtosInlineEdit('subjectId_edit_<? echo  $subjectId  ?>','subject','subjectName','subjectId','<? echo  $subjectId  ?>','','','');"
                                        />



                                    </td>
                                    <td>

                                        <input title="<? echo  $subject_code  ?>"
                                               placeholder="Subject Code"
                                               type="text"
                                               id="subject_code_edit_<? echo  $subjectId  ?>"
                                               value="<? echo  $subject_code  ?>"
                                               onchange="wtosInlineEdit('subject_code_edit_<? echo  $subjectId  ?>','subject','subject_code','subjectId','<? echo  $subjectId  ?>','','','');"
                                        />
                                    </td>
                                    <td>
                                        <?=$asession?>
                                    </td>
                                    <td>
                                        <input class="uk-checkbox"
                                               type="checkbox" <? if($Elective==1){?>checked="checked"  <? } ?> value="1" id="change<? echo  $subjectId  ?>" onchange="wtosInlineEdit('change<? echo  $subjectId  ?>','subject','Elective','subjectId','<? echo  $subjectId  ?>','','','manage_subject_setting(\'\')')"  /> Elective
                                    </td>
                                    <td>
                                        <a><?=sizeof($exams)?></a>

                                        <div  uk-dropdown>

                                            <table>
                                                <?foreach ($exams as $exam):?>
                                                    <tr>
                                                        <?foreach ($exam as $col):?>
                                                            <td><?=$col?></td>
                                                        <?endforeach;?>
                                                    </tr>
                                                <?endforeach;?>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="uk-text-right" style="padding-right: 20px!important;">
                                        <a class="uk-text-danger" uk-icon="icon: trash; ratio:0.7" title="Delete" onclick="if(confirm('Are you sure?')){removeRowAjaxFunction('subject','subjectId','<? echo  $subjectId  ?>','','','manage_subject_setting(\'\')')}"></a></td>
                                </tr>

                                <?
                                $cc++;

                            }?>

                        </table>
                    </div>
                </div>
            </div>
        <?


		} ?>
    </div>

  <? } ?>





    <div style="clear:both"> &nbsp;</div>
    <?
    echo '##--SUBJECT-SETTING-DATA--##';

    exit();
}



