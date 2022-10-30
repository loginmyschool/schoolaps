<?

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');



$logged_teacherId=$os->userDetails['adminId']; /// todolist
$pluginName='';

$os->loadPluginConstant($pluginName);
if($os->get('list_exam_subject')=='OK' && $os->post('list_exam_subject')=='OK')
{
    $selected_examdetails_id=addslashes($os->post('examdetailsId_clicked'));

    ////
    $queation_count=array();
    $query_q_count=" select   count(*) cc, examdetailsId from question where examdetailsId>0 group by examdetailsId ";
    $query_q_countrs=$os->mq($query_q_count);
    while($row=$os->mfa($query_q_countrs))
    {

        $queation_count[$row['examdetailsId']]=$row['cc'];
    }





    $asession=date('Y');
    $subject_array=array();
    $exam_array=array();
    $row_array=array();
    // $where=" and teacherId='$logged_teacherId' ";
    $query_exam_details=" select   * from examdetails where examdetailsId>0 $where ";
    $query_exam_detailsrs=$os->mq($query_exam_details);
    while($row=$os->mfa($query_exam_detailsrs))
    {

        $row_array[$row['class']][$row['examId']][$row['subjectId']]=$row;
        ///$exam_array[$row['examId']]=$row['examId'];
        ///$subject_array[$row['subjectId']]=$row['subjectId'];
    }

    $subject_listquery=" Select * from  subject where subjectId IN(select   subjectId from examdetails  where examdetailsId>0  $where) ";
    $rsResults=$os->mq($subject_listquery);
    while($record=$os->mfa( $rsResults))
    {
        $subject_array[$record['subjectId']]=$record['subjectName'];
    }

    $exam_listquery=" Select * from  exam where examId IN(select   examId from examdetails where examdetailsId>0 $where) ";
    $rsResults=$os->mq($exam_listquery);
    while($record=$os->mfa( $rsResults))
    {
        $exam_array[$record['examId']]=$record['examTitle'];
    }


    echo '##--EXAM-LIST-SUBJECT-DATA--##';
    ?>

    <ul class="uk-tab background-color-secondary uk-margin-remove" uk-tab="connect:#component-class-switcher; animation: uk-animation-fade">
        <? foreach ($row_array as $class_id=>$exam ){?>
            <li>
                <a href="#">
                    <span class="text-m"><? echo  $os->val($os->classList,$class_id); ?></span>
                </a>
            </li>
        <? } ?>
    </ul>

    <ul id="component-class-switcher" class="uk-switcher uk-margin-remove">

        <? foreach($row_array as $class_id=>$exam ) {?>
            <li>

                <ul class="uk-tab background-color-white uk-margin-remove" uk-tab="connect:#component-exam-switcher; animation: uk-animation-fade">
                    <? foreach($exam as $exam_id=>$subjects ){?>
                        <li>
                            <a href="#" >
                                <span class="text-l">
                                    <? echo $os->val($exam_array,$exam_id);  ?>
                                </span>
                            </a>
                        </li>
                    <?}?>
                </ul>
                <ul id="component-exam-switcher" class="uk-switcher">
                    <? foreach($exam as $exam_id=>$subjects ) {?>
                        <li class="uk-padding-small">
                            <ul uk-accordion="collapsible: true">


                                <? foreach($subjects as $subject ) {
                                    $examdetailsId=$subject['examdetailsId'];

                                    $subjectId=$subject['subjectId'];
                                    $subject_name=$os->val($subject_array,$subjectId);
                                    if($subject_name==''){$subject_name=$subjectId;}

                                    ?>
                                    <li class=" uk-card uk-card-default uk-card-small ">
                                        <a class="uk-accordion-title uk-card-header" href="#" onclick="list_exam_subject('<? echo $examdetailsId; ?>')">
                                            <?  echo $subject_name; ?>
                                            <span style="color:#FF0000"> <? echo  $os->val( $queation_count,$examdetailsId); ?> </span>
                                        </a>
                                        <div class="uk-accordion-content subject_details_container uk-card-body" id="question_list_form_<? echo $examdetailsId; ?>">
                                            <div>a
                                                <div >

                                                </div>
                                                <? if($selected_examdetails_id==$examdetailsId){ ?>
                                                    <div id="question_list_form" >

                                                    </div>
                                                <? }  ?>
                                            </div>
                                        </div>
                                    </li>
                                <?} ?>
                            </ul>
                        </li>
                    <?}

                    ?>
                </ul>
            </li>
        <?} ?>
    </ul>

    <?
    echo '##--EXAM-LIST-SUBJECT-DATA--##';
    echo '##--EXAM-selected_examdetails_id--##'; echo $selected_examdetails_id;echo '##--EXAM-selected_examdetails_id--##';


    exit();
}

if($os->get('list_save_question_data')=='OK' && $os->post('list_save_question_data')=='OK')
{

    $examdetailsId=addslashes($os->post('examdetailsId'));
    $op=$os->post('op');
    if($op=='save' && $examdetailsId!='')
    {

        $dataToSave['subjectId']=addslashes($os->post('subjectId'));
        $dataToSave['classId']=addslashes($os->post('subjectId'));
        $dataToSave['examdetailsId']=$examdetailsId;

        $dataToSave['questionText']=addslashes($os->post('questionText'));
        $questionImage=$os->UploadPhoto('questionImage',$site['root'].'wtos-images');
        if($questionImage!=''){
            $dataToSave['questionImage']='wtos-images/'.$questionImage;}

        $dataToSave['answerText1']=addslashes($os->post('answerText1'));
        $answerImage=$os->UploadPhoto('answerImage1',$site['root'].'wtos-images');
        if($answerImage!=''){
            $dataToSave['answerImage1']='wtos-images/'.$answerImage;}

        $dataToSave['answerText2']=addslashes($os->post('answerText2'));
        $answerImage=$os->UploadPhoto('answerImage2',$site['root'].'wtos-images');
        if($answerImage!=''){
            $dataToSave['answerImage2']='wtos-images/'.$answerImage;}

        $dataToSave['answerText3']=addslashes($os->post('answerText3'));
        $answerImage=$os->UploadPhoto('answerImage3',$site['root'].'wtos-images');
        if($answerImage!=''){
            $dataToSave['answerImage3']='wtos-images/'.$answerImage;}

        $dataToSave['answerText4']=addslashes($os->post('answerText4'));
        $answerImage=$os->UploadPhoto('answerImage4',$site['root'].'wtos-images');
        if($answerImage!=''){
            $dataToSave['answerImage4']='wtos-images/'.$answerImage;}



        $dataToSave['correctAnswer']=addslashes($os->post('correctAnswer'));
        $dataToSave['marks']=addslashes($os->post('marks'));
        $dataToSave['negetive_marks']=addslashes($os->post('negetive_marks'));
        $dataToSave['viewOrder']=addslashes($os->post('viewOrder'));

        $dataToSave['type']=addslashes($os->post('type'));

        $dataToSave['examdetailsId']=addslashes($os->post('examdetailsId'));



        //$dataToSave['modifyDate']=$os->now();
        //$dataToSave['modifyBy']=$os->userDetails['adminId'];

        if($questionsId < 1){

            $dataToSave['addedDate']=$os->now();
            $dataToSave['addedBy']=$os->userDetails['adminId'];
        }




        $qResult=$os->save('question',$dataToSave,'questionId',$questionId);///    allowed char '\*#@/"~$^.,()|+_-=:��

    }



    echo '##--EXAM-QUESTion-DATA--##';
    if($examdetailsId)
    {
        ?>
        <div id="question_list_form">
            <div>
                <div>
                    <textarea id="questionText"  placeholder="Question" class="uk-textarea uk-border-rounded"></textarea>
                    <span class="text-m" style="cursor:pointer; color:#FF0000;" onclick="os.clicks('questionImage');">Upload Question</span>
                    <img id="namePreview_questionImage" src=""  style="display:none; height: 100px"	 />
                    <input type="file" id="questionImage" name="questionImage" onchange="os.readURL(this,'namePreview_questionImage') "  style="display:none;"/>
                </div>


                <input type="text" id="code" placeholder="Reference" class="uk-hidden" />
                <div class="uk-margin-small uk-grid uk-grid-small" uk-grid>
                    <div>
                        <input class="uk-input uk-border-rounded congested-form" type="text" id="marks"  placeholder="Marks" style="width:50px;" value="1" />
                    </div>
                    <div>
                        <input class="uk-input uk-border-rounded congested-form" type="text" id="negetive_marks" placeholder="Negative" value="0.5"/>&nbsp;
                    </div>
                    <div>
                        <input class="uk-input uk-border-rounded congested-form" type="text" id="viewOrder"  placeholder="View Order"/> &nbsp;
                    </div>
                    <div>
                        <input class="uk-input uk-border-rounded congested-form" type="text" id="type" placeholder="Type" style="width:50px;" />
                    </div>
                    <div>
                        <select id="correctAnswer"  class="uk-select uk-border-rounded congested-form">
                            <option value="">Correct Option</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                </div>

                <h4>Answers</h4>
                <table class="uk-table uk-table-justify congested-table">
                    <tr>
                        <td class="uk-table-shrink">1</td>
                        <td>
                            <textarea class="uk-textarea uk-border-rounded" type="text" id="answerText1" placeholder="Answer 1"></textarea>
                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage1');">Upload Answer</span> <br />
                            <img id="namePreview_answerImage1" src="" style="display:none; height:100px"	 />
                            <input type="file" id="answerImage1" name="answerImage1" onchange="os.readURL(this,'namePreview_answerImage1') "  style="display:none;"/>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <textarea class="uk-textarea uk-border-rounded"  type="text" id="answerText2" placeholder="Answer 2"></textarea>
                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage2');">Upload Answer</span> <br />
                            <img id="namePreview_answerImage2" src="" style="display:none; height:100px"	 />
                            <input type="file" id="answerImage2" name="answerImage2" onchange="os.readURL(this,'namePreview_answerImage2') "  style="display:none;"/>

                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <textarea class="uk-textarea uk-border-rounded"  type="text" id="answerText3" placeholder="Answer 3"></textarea>
                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage3');">Upload Answer</span> <br />
                            <img id="namePreview_answerImage3" src="" style="display:none; height:100px"	 />
                            <input type="file" id="answerImage3" name="answerImage3" onchange="os.readURL(this,'namePreview_answerImage3') "  style="display:none;"/>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <textarea  class="uk-textarea uk-border-rounded" type="text" id="answerText4" placeholder="Answer 4"></textarea>
                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answerImage4');">Upload Answer</span> <br />
                            <img id="namePreview_answerImage4" src="" style="display:none; height:100px"	 />
                            <input type="file" id="answerImage4" name="answerImage4" onchange="os.readURL(this,'namePreview_answerImage4') "  style="display:none;"/>
                        </td>
                    </tr>
                </table>
            </div>



            <input type="hidden" id="examdetailsId" value="<?  echo $examdetailsId; ?>" />
            <input type="hidden" id="subjectId" value="<?  echo $subjectId; ?>" />
            <input type="hidden" id="classId" value="<?  echo $class_id; ?>" />

            <input class="uk-button uk-border-rounded uk-button-small  uk-secondary-button" type="button" value="Save" onclick="list_save_question_data('save','<? echo $examdetailsId; ?>')" />

            <hr>

            <?
            $q_set_q=" Select * from  question where examdetailsId='$examdetailsId' ";
            $q_set_q_rs=$os->mq($q_set_q);
            $serial=0;
            while($question_row=$os->mfa( $q_set_q_rs))

            {
                $serial++;
                //questionId
                ?>
                <div class="uk-margin-small uk-padding-small" style="background-color:#F2F2FF;">
                    <h3><? echo $serial ?>   <? echo  $question_row['questionText']; ?>  
					
					<input type="text" id="questionText_<? echo  $question_row['questionId']; ?>" value="<? echo  $question_row['questionText']; ?>" style=" width:1000px; display:none;"  class="edit_q_box" 
							onchange="wtosInlineEdit('questionText_<? echo  $question_row['questionId']; ?>','question','questionText','questionId','<? echo  $question_row['questionId']; ?>','','','') "
							 /> ID=<? echo  $question_row['questionId']; ?> 
					
					 <span style="color:#FF0000; font-weight:bold; cursor:pointer;" onclick="removeRowAjaxFunction('question','questionId','<? echo  $question_row['questionId']; ?>','','','list_exam_subject(\'\')');">X</span></h3>
                    <? if($question_row['questionImage']!=''){ ?>
                        <img src="<? echo $site['url'].$question_row['questionImage'] ?>"  style="height:100px" />
                    <? } ?>
                    <p class="uk-margin-small-bottom uk-text-small">
                        Marks: <span class="color-primary uk-margin-right"><? echo  $question_row['marks']; ?></span>
                        Negative marks: <span class="color-primary uk-margin-right"><? echo  $question_row['negetive_marks']; ?></span>
                        ViewOrder: <span class="color-primary uk-margin-right"><? echo  $question_row['viewOrder']; ?></span>
                        Type: <span class="color-primary uk-margin-right"><? echo  $question_row['type']; ?></span>
                    </p>

                    <table class="uk-table uk-table-justify congested-table uk-table-divider">
                        <tr style="<?= $question_row['correctAnswer']==1?"background-color:rgba(0,255,0,0.3)":""?>">
                            <td class="uk-table-shrink">1</td>
                            <td>  <? echo  $question_row['answerText1']; ?> 
							
							<input type="text" id="answerText1_<? echo  $question_row['questionId']; ?>" value="<? echo  $question_row['answerText1']; ?>"  style=" width:600px;display:none;"  class="edit_q_box" 
							onchange="wtosInlineEdit('answerText1_<? echo  $question_row['questionId']; ?>','question','answerText1','questionId','<? echo  $question_row['questionId']; ?>','','','') "
							 /><br />
                                <? if($question_row['answerImage1']!=''){ ?>
                                    <img src="<? echo $site['url'].$question_row['answerImage1'] ?>"  style="height:100px" />
                                <? } ?>
                            </td>
                        </tr>

                        <tr  style="<?= $question_row['correctAnswer']==2?"background-color:rgba(0,255,0,0.3)":""?>">
                            <td class="uk-table-shrink">2</td>
                            <td>
                                 <? echo  $question_row['answerText2']; ?> 
								
								<input type="text" id="answerText2_<? echo  $question_row['questionId']; ?>" value="<? echo  $question_row['answerText2']; ?>"   style=" width:600px;display:none;" class="edit_q_box" 
							onchange="wtosInlineEdit('answerText2_<? echo  $question_row['questionId']; ?>','question','answerText2','questionId','<? echo  $question_row['questionId']; ?>','','','') "
							 />
								
								<br />
                                <? if($question_row['answerImage2']!=''){ ?>
                                    <img src="<? echo $site['url'].$question_row['answerImage2'] ?>"  style="height:100px" />
                                <? } ?>
                            </td>
                        </tr>
                        <tr style="<?= $question_row['correctAnswer']==3?"background-color:rgba(0,255,0,0.3)":""?>">
                            <td class="uk-table-shrink">3</td>
                            <td>
                                <? echo  $question_row['answerText3']; ?> 
								
								<input type="text" id="answerText3_<? echo  $question_row['questionId']; ?>" value="<? echo  $question_row['answerText3']; ?>"   style=" width:600px;display:none;" class="edit_q_box" 
							onchange="wtosInlineEdit('answerText3_<? echo  $question_row['questionId']; ?>','question','answerText3','questionId','<? echo  $question_row['questionId']; ?>','','','') "
							 />
								
								<br />
                                <? if($question_row['answerImage3']!=''){ ?>
                                    <img src="<? echo $site['url'].$question_row['answerImage3'] ?>"  style="height:100px" />
                                <? } ?>
                            </td>
                        </tr>
                        <tr style="<?= $question_row['correctAnswer']==4?"background-color:rgba(0,255,0,0.3)":""?>">
                            <td class="uk-table-shrink">4</td>
                            <td>
                                <? echo  $question_row['answerText4']; ?> 
								
								<input type="text" id="answerText4_<? echo  $question_row['questionId']; ?>" value="<? echo  $question_row['answerText4']; ?>"   style=" width:600px;display:none;"  class="edit_q_box" 
							onchange="wtosInlineEdit('answerText4_<? echo  $question_row['questionId']; ?>','question','answerText4','questionId','<? echo  $question_row['questionId']; ?>','','','') "
							 />
								
								
								<br />
                                <? if($question_row['answerImage4']!=''){ ?>
                                    <img src="<? echo $site['url'].$question_row['answerImage4'] ?>"  style="height:100px" />
                                <? } ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <? } ?>
        </div>

        <?
    } 
    echo '##--EXAM-QUESTion-DATA--##';



    exit();

}
