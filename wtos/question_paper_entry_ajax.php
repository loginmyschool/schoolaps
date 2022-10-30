<?
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');
ini_set("memory_limit", "-1");
set_time_limit(0);
$logged_teacherId=$os->userDetails['adminId']; /// todolist
$pluginName='';

$os->loadPluginConstant($pluginName);
 $os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
$os->question_type_arr=array('MCQ'=>'MCQ','DESC'=>'DESC');
$os->question_base_arr=array('Informative'=>'Informative','Math'=>'Math');
if($os->get('list_save_question_data')=='OK' && $os->post('list_save_question_data')=='OK')
{
 // _d($os->post());
 // exit();

   $subjectId=$os->post('subjectId'); // not used
   $classId=$os->post('classId'); // not used

    $examdetailsId=addslashes($os->post('examdetailsId'));
	 $asession_s=$os->post('asession_s');



    $op=$os->post('op');
    if($op=='save' && $examdetailsId!='')
    {

       // $dataToSave['subjectId']=addslashes($os->post('subjectId'));
       // $dataToSave['classId']=addslashes($os->post('subjectId'));
        $dataToSave['examdetailsId']=$examdetailsId;

        //============ SECTION ADDED =============//
        $examdetails_section_id = $os->post("examdetails_section_id");
        $dataToSave["examdetails_section_id"] = $examdetails_section_id;
        $os->setSession($examdetails_section_id,"selected_examdetails_section_id");
        //============= SECTION END ==============//

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





        // $dataToSave['correctAnswer']=addslashes($os->post('correctAnswer'));

		$correctAnswer_list=$os->post('correctAnswer_list');
		$dataToSave['correctAnswer']=$os->val($correctAnswer_list,0);
		$dataToSave['correctAnswer_2']=$os->val($correctAnswer_list,1);
		$dataToSave['correctAnswer_3']=$os->val($correctAnswer_list,2);
		$dataToSave['correctAnswer_4']=$os->val($correctAnswer_list,3);



        $dataToSave['marks']=addslashes($os->post('marks'));
        $dataToSave['negetive_marks']=addslashes($os->post('negetive_marks'));
        $dataToSave['viewOrder']=addslashes($os->post('viewOrder'));

        $dataToSave['type']=addslashes($os->post('type'));

		$os->setSession($dataToSave['marks'], 'marks_'.$examdetailsId);
		$os->setSession($dataToSave['negetive_marks'], 'negetive_marks_'.$examdetailsId);
		$os->setSession($dataToSave['type'], 'type_'.$examdetailsId);


			$dataToSave['question_chapter_id']=$os->post('question_chapter_id');
			$dataToSave['question_topic_id']=$os->post('question_topic_id');
			$dataToSave['level']=$os->post('level');
			$dataToSave['question_base']=$os->post('question_base');

			$dataToSave['answer_hints']=addslashes($os->post('answer_hints'));
			$answer_hints_image=$os->UploadPhoto('answer_hints_image',$site['root'].'wtos-images');
			if($answer_hints_image!=''){
			$dataToSave['answer_hints_image']='wtos-images/'.$answer_hints_image;}

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



		$queation_count=array();
		$query_q_count=" select   count(*) cc, examdetailsId from question where examdetailsId='$examdetailsId' ";
		$query_q_countrs=$os->mq($query_q_count);
		$row=$os->mfa($query_q_countrs);
		$queation_count=$row['cc'];


		$query_q_count="select    ed.written,ed.viva,  s.subjectName,s.subjectId,  e.examTitle ,  e.asession ,  e.class , eg.exam_start_datetime, eg.exam_end_datetime
		from examdetails ed 
		INNER JOIN subject  s ON  ed.subjectId=s.subjectId	
		INNER JOIN exam  e ON  e.examId=ed.examId	
		INNER JOIN exam_group eg ON eg.exam_group_id=ed.exam_group_id
		
		where ed.examdetailsId='$examdetailsId' ";

		/*$query_q_count="select    ed.written,ed.viva,  s.subjectName,  e.examTitle ,  e.asession ,  e.class from examdetails ed
		INNER JOIN subject  s ON  ed.subjectId=s.subjectId
		INNER JOIN exam  e ON  e.examId=ed.examId
		where ed.examdetailsId='$examdetailsId' ";*/


		$query_q_countrs=$os->mq($query_q_count);
		$row_exam=$os->mfa($query_q_countrs);

		$starttimestamp = strtotime(date_format(date_create($row_exam["exam_start_datetime"]), "Y-m-d H:i:s"))  ;
		$endtimestamp = strtotime(date_format(date_create($row_exam["exam_end_datetime"]), "Y-m-d H:i:s"));
		$dur=$endtimestamp-$starttimestamp;
		$dur_min=$dur/(60);
		$dur_hour=$dur_min/60;
		$subjectId = $row_exam['subjectId'];
		$classId = $row_exam['class'];

		$marks_session=$os->getSession( 'marks_'.$examdetailsId);
		$negetive_marks_session=$os->getSession( 'negetive_marks_'.$examdetailsId);
		$type_session=$os->getSession( 'type_'.$examdetailsId);


		?>
		<h3 style="color:#9F9F9F"  >
					Exam: <span style="color:#0000FF">  <? echo $row_exam['examTitle']; ?>  </span>
					Year : <span style="color:#0000FF">  <? echo $row_exam['asession']; ?>  </span>
					Subject :  <span style="color:#0000FF"> <? echo $row_exam['subjectName']; ?>  </span>
					Written : <span style="color:#0000FF">  <? echo $row_exam['written']; ?> </span>
					Viva : <span style="color:#0000FF">  <? echo $row_exam['viva']; ?> </span>




		</h3>
		<div>

		Start : <? echo $row_exam["exam_start_datetime"]; ?> &nbsp;&nbsp;&nbsp;
		End : <? echo $row_exam["exam_end_datetime"]; ?>&nbsp;&nbsp;&nbsp;
		Duration In Minuite : <span style="color:#FF0000">  <? echo $dur_min; ?> </span> M&nbsp;&nbsp;&nbsp;
					Duration In Hour : <span style="color:#FF0000">  <? echo $dur_hour; ?> </span> H</div>




		<h3  style="text-align:right; color:#999999; margin-right:10px;">
		 <span onclick="popDialog('import_question_form_div','Question selection to import. ',{width:1200, height:600});  import_question_form_function('<? echo $classId; ?>','<? echo $examdetailsId?>','<? echo $subjectId ?>');" style="color:#FF9900; cursor:pointer;"> Import </span>
		 <a href="javascript:void(0)"  onclick="question_paper_pdf_review()" >Download</a>   &nbsp;



		No Of Question <b style="color:#FF0066;"> <? echo $queation_count; ?> </b></h3>

		<div id="import_question_form_div" >  <!--  IMPORT FORM -->
		</div>
        <form id="Question_form" method="post" >
        <div id="question_list_form" class="uk-grid uk-child-width-1-2" uk-grid>
            <div>
			  <div class="uk-margin-small uk-grid uk-grid-small" uk-grid style="padding:10px; background-color:#FDF486; border:1px solid #FFCC00;">

                  Marks &nbsp; <input title="Marks" class="uk-input uk-border-rounded congested-form" type="text" id="marks"  placeholder="Marks" style="width:50px;" value="<? echo $marks_session;?>" />
                      &nbsp;&nbsp;&nbsp;&nbsp;
                  Negetive &nbsp;<input title="Negative" class="uk-input uk-border-rounded congested-form" type="text" id="negetive_marks" placeholder="Negative" value="<? echo $negetive_marks_session;?>" style="width:45px;"/> &nbsp;&nbsp;&nbsp;&nbsp;

                  Serial No  &nbsp; <input title="Serial No"  class="uk-input uk-border-rounded congested-form" type="text" id="viewOrder"  placeholder="Serial No" style="width:45px;"/>  &nbsp;&nbsp;&nbsp;&nbsp;

                  Type	&nbsp;<select title="Type"  name="type" id="type" style="width:60px; height:20px;" >
                      <option value=""> </option>
                      <? $os->onlyOption($os->question_type_arr,  $type_session);	?>
                  </select>	  &nbsp;&nbsp;&nbsp;&nbsp;
                  Correct option  <select   name="correctAnswer_list[]" id="correctAnswer" multiple="multiple"    style="width:60px; height:70px;">

                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>

                </div>
                <?

                //=============== SECTION ===============//
                $selected_examdetails_section_id = $os->getSession("selected_examdetails_section_id");
                ?>
                <div class="uk-margin-small">
                    <select id="examdetails_section_id">
                        <option></option>
                        <? $os->optionsHTML($selected_examdetails_section_id,"examdetails_section_id", "name","examdetails_section","examdetailsId='$examdetailsId'")?>
                    </select>
                </div>
                <div class="uk-margin-small">
                    <textarea id="questionText"  placeholder="Question" class="uk-textarea uk-border-rounded"></textarea>
                    <span class="text-m" style="cursor:pointer; color:#FF0000;" onclick="os.clicks('questionImage');">Upload Question</span>
                    <img id="namePreview_questionImage" src=""  style="display:none; height: 100px"	 />
                    <input type="file" id="questionImage" name="questionImage" onchange="os.readURL(this,'namePreview_questionImage') "  style="display:none;"/>
                </div>


                <input type="text" id="code" placeholder="Reference" class="uk-hidden" />


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





					<tr ><td colspan="5"> <input class="uk-button uk-border-rounded uk-button-small  uk-secondary-button" type="button" value="Save" onclick="list_save_question_data('save','<? echo $examdetailsId; ?>')" /></td> </tr>

					<tr >
	  									<td>Chapter </td>
										<td>
										<select name="question_chapter_id" id="question_chapter_id" class="textbox fWidth" onchange="wt_ajax_chain('html*question_topic_id*question_topic,question_topic_id,title*question_chapter_id=question_chapter_id');">

										<option value=""> </option>		  	<?

										  $os->optionsHTML('','question_chapter_id','title','question_chapter');?>
							</select> </td>
										</tr><tr >
	  									<td>Topic </td>
										<td> <select name="question_topic_id" id="question_topic_id" class="textbox fWidth" ><option value=""> </option>		  	<?

										  $os->optionsHTML('','question_topic_id','title','question_topic');?>
							</select> </td>
										</tr><tr >
	  									<td>Level </td>
										<td>

	<select name="level" id="level" class="textbox fWidth" ><option value=""> </option>	<?
										  $os->onlyOption($os->question_level_arr);	?></select>	 </td>
										</tr><tr >
	  									<td>Base </td>
										<td>

	<select name="question_base" id="question_base" class="textbox fWidth" ><option value=""> </option>	<?
										  $os->onlyOption($os->question_base_arr);	?></select>	 </td>
										</tr>


					<tr>
                        <td></td>
                        <td> <h3 style="color:#330099">Answer Hints</h3>
                            <textarea  class="uk-textarea uk-border-rounded" type="text" id="answer_hints" placeholder="Answer Hints"></textarea>
                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('answer_hints_image');">Upload Answer Hints</span> <br />
                            <img id="namePreview_answer_hints" src="" style="display:none; height:100px"	 />
                            <input type="file" id="answer_hints_image" name="answer_hints_image" onchange="os.readURL(this,'namePreview_answer_hints') "  style="display:none;"/>
                        </td>
                    </tr>

                </table>


				  <input type="hidden" id="examdetailsId" value="<?  echo $examdetailsId; ?>" />
            <input type="hidden" id="subjectId" value="<?  echo $subjectId; ?>" /> <!-- data shows blank and saved blank -->
            <input type="hidden" id="classId" value="<?  echo $classId; ?>" /><!-- data shows blank and saved blank -->

            <input class="uk-button uk-border-rounded uk-button-small  uk-secondary-button" type="button" value="Save" onclick="list_save_question_data('save','<? echo $examdetailsId; ?>')" />

            </div>

            <div>

                <div>
                    <?


			        $q_set_q="select   * from question where examdetailsId='$examdetailsId'  ORDER BY viewOrder ASC";
                    $q_set_q_rs=$os->mq($q_set_q);
                    $serial=0;



                    //==========SECTION START ==========//
                    $sections = [];
                    $sections_query = $os->mq("SELECT examdetails_section_id,name, max_attempt FROM examdetails_section WHERE examdetailsId='$examdetailsId'");
                    while($section = $os->mfa($sections_query)){
                        $sections[$section["examdetails_section_id"]] = $section;
                    }
                    $sections=
                        array(
                            0=>[
                                "examdetails_section_id"=>0,
                                "name"=>"UNCATEGORIZED",
                                "max_attempt"=>null
                            ]
                        )+ $sections;

                    //=========== SECTION END ==========//
                    $questions = [];
                    while($question=$os->mfa( $q_set_q_rs)) {
                        if (isset($sections[$question["examdetails_section_id"]])) {
                            $questions[$question["examdetails_section_id"]][$question["questionId"]] = $question;
                        } else {
                            $question["examdetails_section_id"] = 0;
                            $questions[0][$question["questionId"]] = $question;

                        }
                    }




                    foreach ($sections as $section_id=>$section){
                        ?>
                            <h3><?= $section["name"]?> [MAX : <?= $section["max_attempt"]?>]</h3>
                            <?
                        foreach($questions[$section_id] as $question_row)
                        {
                            $serial++;
                            //questionId

                            $question_class_id=$question_row['question_class_id'];

                            $correctAnswer_saved=array($question_row['correctAnswer'],$question_row['correctAnswer_2'],$question_row['correctAnswer_3'],$question_row['correctAnswer_4']);
                            $correctAnswer_saved=array_filter($correctAnswer_saved);


                            $section_name = $sections[$question_row["examdetails_section_id"]]["name"];

                            ?>
                            <div class="uk-card uk-card-default uk-border-rounded uk-padding-small uk-margin"
                                <? if($question_row['wrong_question']){ ?> style="background-color:#FF9797" <? } ?> >

                                <div style=" background-color:#FFFFBB; border: 1px solid #FFFF33; padding:10px; margin:-10px 0px 2px -10px;" >
                                    <h5 title="ED: <? echo $examdetailsId ?>  Q:<? echo  $question_row['questionId']; ?>"
                                        class="text-m">
                                        <span style="color:#CC00CC; font-weight:bold; font-size:24px;"><? echo  $question_row['viewOrder']; ?>.  </span>
                                        <? echo  $question_row['questionText']; ?>
                                        <span title="Delete Question" style="color:#FF0000; font-size:12px; cursor:pointer;" onclick="removeRowAjaxFunction('question','questionId','<? echo  $question_row['questionId']; ?>','','','list_exam_subject(\'\')');">Delete</span>
                                    </h5>
                                    <? if($question_row['questionImage']!=''){ ?>
                                        <img src="<? echo $site['url'].$question_row['questionImage'] ?>"  style="height:100px" />
                                    <? } ?>

                                </div>


                                <p class="uk-margin-small-bottom uk-text-small uk-text-bold">
                                    Marks: <span class="color-primary uk-margin-right"><? echo  $question_row['marks']; ?></span>
                                    Negative marks: <span class="color-primary uk-margin-right"><? echo  $question_row['negetive_marks']; ?></span>
                                    Serial No:
                                    <input value="<? echo  $question_row['viewOrder']; ?>" type="text"
                                           class="uk-input uk-border-rounded congested-form"
                                           id="viewOrder_<? echo  $question_row['questionId']; ?>"
                                           style="width: 50px"
                                           onchange="wtosInlineEdit('viewOrder_<? echo  $question_row['questionId']; ?>','question','viewOrder','questionId','<? echo  $question_row['questionId']; ?>','','','');"/>


                                    <span style="display: none" class="color-primary uk-margin-right"><? echo  $question_row['viewOrder']; ?></span>
                                    Type: <span class="color-primary uk-margin-right"><? echo  $question_row['type']; ?></span>

                                    <!----SECTION START------>
                                    Section:
                                    <select id="examdetails_section_id_<? echo  $question_row['questionId']; ?>"
                                            onchange="wtosInlineEdit('examdetails_section_id_<? echo  $question_row['questionId']; ?>','question','examdetails_section_id','questionId','<? echo  $question_row['questionId']; ?>','','','');">
                                        <option></option>
                                        <? $os->optionsHTML($question_row["examdetails_section_id"],"examdetails_section_id", "name","examdetails_section","examdetailsId='$examdetailsId'")?>
                                    </select>
                                    <!----SECTION START------>

                                    <?

                                    $group_subject=$os->val($os->group_subject,$question_class_id);


                                    if($group_subject && $question_class_id  ){ ?>

                                        Subject Group <select name="group_subject_qedit_"  onchange="wtosInlineEdit('group_subject_qedit_<? echo  $question_row['questionId']; ?>','question','group_subject','questionId','<? echo  $question_row['questionId']; ?>','','','');"
                                                              id="group_subject_qedit_<? echo  $question_row['questionId']; ?>"
                                                              style="width: 100px"
                                                              class=" uk-border-rounded " >
                                            <option value=""> </option>
                                            <?

                                            $os->onlyOption($group_subject,$question_row['group_subject']);
                                            ?>
                                        </select>

                                    <? } ?>
                                </p>

                                <div class="uk-border-rounded" style="<?=in_array(1,$correctAnswer_saved)?"background-color:rgba(0,255,0,0.3)":""?>">
                                    <table class="uk-table congested-table">
                                        <tr>
                                            <td class="uk-table-shrink">1</td>
                                            <td><? echo  $question_row['answerText1']; ?>
                                                <? if($question_row['answerImage1']!=''){ ?>
                                                    <img src="<? echo $site['url'].$question_row['answerImage1'] ?>"  style="height:100px" />
                                                <? } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="uk-border-rounded" style="<?=in_array(2,$correctAnswer_saved)?"background-color:rgba(0,255,0,0.3)":""?>">
                                    <table class="uk-table congested-table">
                                        <tr>
                                            <td class="uk-table-shrink">2</td>
                                            <td>
                                                <? echo  $question_row['answerText2']; ?><br />
                                                <? if($question_row['answerImage2']!=''){ ?>
                                                    <img src="<? echo $site['url'].$question_row['answerImage2'] ?>"  style="height:100px" />
                                                <? } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="uk-border-rounded" style="<?=in_array(3,$correctAnswer_saved)?"background-color:rgba(0,255,0,0.3)":""?>">
                                    <table class="uk-table congested-table">
                                        <tr>
                                            <td class="uk-table-shrink">3</td>
                                            <td>
                                                <? echo  $question_row['answerText3']; ?><br />
                                                <? if($question_row['answerImage3']!=''){ ?>
                                                    <img src="<? echo $site['url'].$question_row['answerImage3'] ?>"  style="height:100px" />
                                                <? } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="uk-border-rounded" style="<?=in_array(4,$correctAnswer_saved)?"background-color:rgba(0,255,0,0.3)":""?>">
                                    <table class="uk-table congested-table">
                                        <tr>
                                            <td class="uk-table-shrink">4</td>
                                            <td>
                                                <? echo  $question_row['answerText4']; ?><br />
                                                <? if($question_row['answerImage4']!=''){ ?>
                                                    <img src="<? echo $site['url'].$question_row['answerImage4'] ?>"  style="height:100px" />
                                                <? } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>


                                <?if($question_row['answer_hints']!=="" || $question_row['answer_hints_image']!==""){?>
                                    <div class="uk-border-rounded"  >
                                        <h3 style="color:#009900;" > ANSWER HINTS </h3>
                                        <table class="uk-table congested-table">
                                            <tr>
                                                <td class="uk-table-shrink"> </td>
                                                <td>
                                                    <? echo  $question_row['answer_hints']; ?><br />
                                                    <? if($question_row['answer_hints_image']!=''){ ?>
                                                        <img src="<? echo $site['url'].$question_row['answer_hints_image'] ?>"  style="height:100px" />
                                                    <? } ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                <?}?>


                                <span  class="actionLink" ><a href="javascript:void(0)"  onclick="edit_question('<? echo $question_row['questionId'];?>')" >Edit</a></span>


                            </div>
                        <? }
                    }
                    ?>

                </div>
            </div>
        </div>
        </form>
        <?php
    }
    echo '##--EXAM-QUESTion-DATA--##';



    exit();

}

if($os->get('import_question_form_function')=='OK' && $os->post('import_question_form_function')=='OK')
{

   $subjectId=$os->post('subjectId');
   $classId=$os->post('classId');
   $examdetailsId=$os->post('examdetailsId');


	//$subjectId=128;
	//$classId=11;

    $queation_count=0;
    $query_q_count=" select  *  from question_bank where subjectId>0  and subjectId='$subjectId'  and  classId='$classId' limit 200 ";
    $query_q_countrs=$os->mq($query_q_count);
	?>  <form name="question_selection_form" id="question_selection_form">
	   <input type="hidden" name="subjectId_import" value="<? echo   $subjectId; ?>" />
	   <input type="hidden" name="classId_import" value="<? echo   $classId; ?>" />
	   <input type="hidden" name="examdetailsId_import" value="<? echo   $examdetailsId; ?>" />
	<?
    while($question_row=$os->mfa($query_q_countrs))
    {  $queation_count++;
	  // _d($question_row)
          ?>

		  <div class="uk-card uk-card-default uk-border-rounded uk-padding-small uk-margin" style="margin-top:50px;    " id="div_q_<? echo  $question_row['questionId']; ?>">

							 <div style=" background-color:#FFFFBB; border: 1px solid #FFFF33; padding:10px; margin:-10px 0px 2px -10px;" >
							 <h5 title="  Q:<? echo  $question_row['questionId']; ?>" class="text-m">
							 <input type="checkbox" name="selected_question[]" value="<? echo  $question_row['questionId']; ?>" onclick="setColor(this,'<? echo  $question_row['questionId']; ?>')" />
                             <span style="color:#CC00CC; font-weight:bold; font-size:24px;"><? echo   $queation_count; ?>.  </span>
                             <? echo  $question_row['questionText']; ?>

                            </h5>
                            <? if($question_row['questionImage']!=''){ ?>
                                <img src="<? echo $site['url'].$question_row['questionImage'] ?>"  style="height:100px" />
                            <? } ?>

							</div>


                            <p class="uk-margin-small-bottom uk-text-small uk-text-bold">
                                Marks: <span class="color-primary uk-margin-right"><? echo  $question_row['marks']; ?></span>
                                Negative marks: <span class="color-primary uk-margin-right"><? echo  $question_row['negetive_marks']; ?></span>

                                Type: <span class="color-primary uk-margin-right"><? echo  $question_row['type']; ?></span>

                            </p>

                            <div class="uk-border-rounded"  >
                                <table class="  congested-table">
                                    <tr>
                                        <td class="uk-table-shrink">1</td>
                                        <td><? echo  $question_row['answerText1']; ?>
                                            <? if($question_row['answerImage1']!=''){ ?>
                                                <img src="<? echo $site['url'].$question_row['answerImage1'] ?>"  style="height:100px" />
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="uk-border-rounded"  >
                                <table class="  congested-table">
                                    <tr>
                                        <td class="uk-table-shrink">2</td>
                                        <td>
                                            <? echo  $question_row['answerText2']; ?><br />
                                            <? if($question_row['answerImage2']!=''){ ?>
                                                <img src="<? echo $site['url'].$question_row['answerImage2'] ?>"  style="height:100px" />
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="uk-border-rounded"  >
                                <table class="  congested-table">
                                    <tr>
                                        <td class="uk-table-shrink">3</td>
                                        <td>
                                            <? echo  $question_row['answerText3']; ?><br />
                                            <? if($question_row['answerImage3']!=''){ ?>
                                                <img src="<? echo $site['url'].$question_row['answerImage3'] ?>"  style="height:100px" />
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="uk-border-rounded"  >
                                <table class=" congested-table">
                                    <tr>
                                        <td class="uk-table-shrink">4</td>
                                        <td>
                                            <? echo  $question_row['answerText4']; ?><br />
                                            <? if($question_row['answerImage4']!=''){ ?>
                                                <img src="<? echo $site['url'].$question_row['answerImage4'] ?>"  style="height:100px" />
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

							<!--<div class="uk-border-rounded"  >
							 <h3 style="color:#009900;" > ANSWER HINTS </h3>
                                <table class="uk-table congested-table">
                                    <tr>
                                        <td class="uk-table-shrink"> </td>
                                        <td>
                                            <? echo  $question_row['answer_hints']; ?><br />
                                            <? if($question_row['answer_hints_image']!=''){ ?>
                                                <img src="<? echo $site['url'].$question_row['answer_hints_image'] ?>"  style="height:100px" />
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>-->

                        </div>

		  <?

    }
    ?> <div style="position:fixed; top:40px; ;  background-color:#FFFF33; border:1px solid #CCCC00;   padding:5px;">
	 NO Of Question: <span style="color:#FF0000;font-weight:bold;"> <? echo $queation_count; ?> </span>
	 Total selected <span id="total_selected_div" style="color:#FF0000;font-weight:bold;">0</span>
	 &nbsp; <input type="button" value="Add to question paper" onclick="add_to_question_paper()" style="cursor:pointer; background-color:#E8E800; border:1px solid #FFCC00;"  />  <span id="add_to_question_paper_output_div" style="color:#FF0000;font-weight:bold;"> </span>
	 </div>
	</form>
	<?



   exit();
}
if($os->get('add_to_question_paper')=='OK' && $os->post('add_to_question_paper')=='OK')
{
    $added_question=0;
	$subjectId=$os->post('subjectId_import');
	$classId=$os->post('classId_import');
	$examdetailsId=$os->post('examdetailsId_import');
	$selected_question=$os->post('selected_question');

	if(is_array($selected_question))
	{

				$selected_question_str=	 " and  questionId IN (".implode(',',$selected_question).")";
				$query_q_count=" select  *  from question_bank where subjectId>0  and subjectId='$subjectId'  and  classId='$classId'  $selected_question_str ";
				$query_q_countrs=$os->mq($query_q_count);
				while($question_row=$os->mfa($query_q_countrs))
				{
				            $question_bank_id=$question_row['questionId'];
					 if($question_bank_id>0  && $examdetailsId>0 ){
							$delete_old_data="delete from question where  question_bank_id='$question_bank_id' and  examdetailsId='$examdetailsId'";
							$os->mq($delete_old_data);

							$dataToSave['examdetailsId']=$examdetailsId;
							$dataToSave['questionText']=$question_row['questionText'];
							$dataToSave['questionImage']=$question_row['questionImage'];

							$dataToSave['answerText1']=$question_row['answerText1'];
							$dataToSave['answerImage1']=$question_row['answerImage1'];

							$dataToSave['answerText2']=$question_row['answerText2'];
							$dataToSave['answerImage2']=$question_row['answerImage2'];

							$dataToSave['answerText3']=$question_row['answerText3'];
							$dataToSave['answerImage3']=$question_row['answerImage3'];

							$dataToSave['answerText4']=$question_row['answerText4'];
							$dataToSave['answerImage4']=$question_row['answerImage4'];


							$dataToSave['correctAnswer']=$question_row['correctAnswer'];
							$dataToSave['marks']=$question_row['marks'];
							$dataToSave['negetive_marks']=$question_row['negetive_marks'];
							$dataToSave['viewOrder']=$question_row['viewOrder'];

							$dataToSave['type']=$question_row['type'];
							$dataToSave['question_chapter_id']=$question_row['question_chapter_id'];
							$dataToSave['question_topic_id']=$question_row['question_topic_id'];
							$dataToSave['level']=$question_row['level'];
							$dataToSave['question_base']=$question_row['question_base'];
							$dataToSave['answer_hints']=$question_row['answer_hints'];
							$dataToSave['answer_hints_image']=$question_row['answer_hints_image'];
							$dataToSave['question_bank_id']= $question_bank_id;
							$dataToSave['addedDate']=$os->now();
							$dataToSave['addedBy']=$os->userDetails['adminId'];

							$qResult=$os->save('question',$dataToSave,'questionId',$questionId);///    allowed char '\*#@/"~$^.,()|+_-=:��


							if($qResult)
							{
							   $added_question++;
							}

				     }

				}



	}

   echo 'Addded question: '.$added_question;

 // _d($os->post());
  exit();

}
//////
if($os->post("save_sets")=="OK"){
    $edId = $os->get("edId");
    $os->mq("DELETE FROM question_paper_set WHERE examdetailsId='$edId'");
    $sets = $os->post("set");

    foreach ($sets as $set=>$questions){
        foreach ($questions as $questionId=>$view_order){
            $dataToSave=[];
            $dataToSave["set_no"] = $set;
            $dataToSave["question_id"] = $questionId;
            $dataToSave["view_order"] = $view_order;
            $dataToSave["examdetailsId"] = $edId;
            if ($view_order!="") {
                $os->save("question_paper_set", $dataToSave);
            }
        }
    }

    print "Successfully saved";
}
if($os->get("question_paper_set")=="OK"){
    $edId = $os->get("edId");
    $questions_query = $os->mq("SELECT * FROM question WHERE examdetailsId='$edId' ORDER BY viewOrder ASC");
    $questions = [];
    while($question = $os->mfa($questions_query)){
        $questions[$question["questionId"]] = $question;
    }


    $question_sets = [
        1=>[],
        2=>[],
        3=>[],
        4=>[]
    ];
    $set_query = $os->mq("SELECT * FROM question_paper_set WHERE examdetailsId='$edId'");
    while ($question_set = $os->mfa($set_query)){
        $question_sets[$question_set["set_no"]][$question_set["question_id"]]=$question_set["view_order"];
    }

    ?>
    <form method="post" enctype="multipart/form-data">
        <table style="border-collapse: collapse; border: 1px solid #999;">
            <thead>
            <tr style="border-bottom: 1px solid #999; background-color: #e5e5e5">
                <th  colspan="4">SETS</th>
                <th style="border-left: 1px solid #999; padding: 4px 6px;"><?=$question["questionText"]?></th>
            </tr>
            <tr style="border-bottom: 1px solid #999; background-color: #e5e5e5">
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th style="border-left: 1px solid #999; padding: 4px 6px">
                    Question
                    <input type="hidden" name="save_sets" value="OK">
                    <button type="submit">SAVE</button>
                </th>
            </tr>
            </thead>
            <?
            foreach ($questions as $questionId=>$question){
                ?>
                <tr style="border-bottom: 1px solid #999">
                    <td style="border: 1px solid #999;">
                        <input type="number" name="set[1][<?= $question["questionId"]?>]" readonly value="<?=$question["viewOrder"]?>" style="width: 60px; font-weight: bold"></td>
                    <td style="border: 1px solid #999;">
                        <input type="number" name="set[2][<?= $question["questionId"]?>]" value="<?=$os->val($question_sets[2], $question['questionId'])?>" style="width: 60px"></td>
                    <td style="border: 1px solid #999;">
                        <input type="number" name="set[3][<?= $question["questionId"]?>]" value="<?=$os->val($question_sets[3], $question['questionId'])?>" style="width: 60px"></td>
                    <td style="border: 1px solid #999;">
                        <input type="number" name="set[4][<?= $question["questionId"]?>]" value="<?=$os->val($question_sets[4], $question['questionId'])?>" style="width: 60px"></td>
                    <td style="border-left: 1px solid #999; padding: 4px 6px"><?=$question["questionText"]?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </form>
    <style>
        thead  { position: sticky; top: 0; }
    </style>
    <?

}




