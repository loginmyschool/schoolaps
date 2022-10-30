<?

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');



$logged_teacherId=$os->userDetails['adminId']; /// todolist
$pluginName='';

$os->loadPluginConstant($pluginName);
if($os->get('list_exam_subject')=='OK' && $os->post('list_exam_subject')=='OK')
{
   
   // question count
   
			$question_per_class=array();
			$question_per_class['total']=0;
			$query_q_c=" select   count(*) cc, classId from question_bank  group by classId   ";
			$query_q_c_rs=$os->mq($query_q_c);
			while($row=$os->mfa($query_q_c_rs))
			{
			$question_per_class[$row['classId']]=$row['cc'];
			$question_per_class['total']=$question_per_class['total'] +$row['cc'];
			
			
			} 
   
    // question count
    $selected_subjectId=addslashes($os->post('subjectId_clicked'));

    ////
    $queation_count=array();
    $query_q_count=" select   count(*) cc, subjectId from question_bank where subjectId>0 group by subjectId ";
    $query_q_countrs=$os->mq($query_q_count);
    while($row=$os->mfa($query_q_countrs))
    {

        $queation_count[$row['subjectId']]=$row['cc'];
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

      //  $row_array[$row['class']][$row['examId']][$row['subjectId']]=$row;
		 $row_array[$row['class']][$row['class']][$row['subjectId']]=$row;
        
    }

  
  
    $subject_listquery=" Select * from  subject ";
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
        <? foreach ($os->classList as $class_id=>$val ){?>
            <li>
                <a href="#">
                    <span class="text-l" style="color:#FFFFFF; font-weight:bold"><? echo  $os->val($os->classList,$class_id); ?> </span>
					 <span class="text-m" style="color:#0066FF; font-weight:bold"><? echo  $os->val($question_per_class,$class_id); ?>   
					</span>
                </a>
            </li>
        <? } ?>
		
		   <li>
                <a   >
                    <span class="text-l" style="color:#000000; font-weight:bold"> Total: <? echo   $os->val($question_per_class,'total'); ?> </span>
					  
                 </a>
            </li>
    </ul>

    <ul id="component-class-switcher" class="uk-switcher uk-margin-remove">

        <? foreach($os->classList as $class_id=>$val ) {?>
            <li>

                <ul class="uk-tab background-color-white uk-margin-remove" uk-tab="connect:#component-exam-switcher; animation: uk-animation-fade">
                    
                        <li>
                            <a href="#" title="C:<? echo $class_id; ?>" >
                                <span class="text-l">
                                    <? echo $os->val($os->classList,$class_id);  ?> (<? echo  $os->val($question_per_class,$class_id); ?> )
                                </span>
                            </a>
                        </li>
                    
                </ul>
                <ul id="component-exam-switcher" class="uk-switcher">
                    <? 
					   $subjects=$os->rowsByField('','subject',$fld='classId',$fldVal=$class_id,$where=" and asession='$asession'",$orderby='',$limit='');
					?>
					 
                        <li class="uk-padding-small">
                            <ul uk-accordion="collapsible: true">


                                <? foreach($subjects as $subject ) {
                                     
 
                                    $subjectId=$subject['subjectId'];
                                    $subject_name=$os->val($subject_array,$subjectId);
                                    if($subject_name==''){$subject_name=$subjectId;}

                                    ?>
                                    <li class=" uk-card uk-card-default uk-card-small ">
                                        <a title="S:<? echo $subjectId; ?>" class="uk-accordion-title uk-card-header" href="#" onclick="list_exam_subject('<? echo $subjectId; ?>')">
                                            <?  echo $subject_name; ?>
                                            <span style="color:#FF0000" id="queation_count_<? echo $subjectId; ?>"> <? echo  $os->val( $queation_count,$subjectId); ?> </span>
                                        </a>
                                        <div class="uk-accordion-content subject_details_container uk-card-body" id="question_list_form_<? echo $subjectId; ?>">
                                            <div> 
                                                <div >

                                                </div>
                                                <? if($selected_subjectId==$subjectId){ ?>
                                                    <div id="question_list_form" >

                                                    </div>
                                                <? }  ?>
                                            </div>
                                        </div>
                                    </li>
                                <?} ?>
                            </ul>
                        </li>
                     
                </ul>
            </li>
        <? } ?>
    </ul>

    <?
    echo '##--EXAM-LIST-SUBJECT-DATA--##';
    echo '##--EXAM-selected_subjectId--##'; echo $selected_subjectId;echo '##--EXAM-selected_subjectId--##';


    exit();
}

if($os->get('list_save_question_data')=='OK' && $os->post('list_save_question_data')=='OK')
{
   // $subjectId=$os->post('subjectId');
    $classId=$os->post('classId');
	
	
   
    $subjectId=addslashes($os->post('subjectId'));
    $op=$os->post('op');
    if($op=='save' && $subjectId!='')
    {
	
	
	     $subject_row=$os->rowByField('','subject',$fld='subjectId',$fldVal=$subjectId,$where="",$orderby='',$limit='');
		 $classId=$subject_row['classId'];
	 
	   
	
		$question_chapter_id=$os->post('question_chapter_id');
		$question_topic_id=$os->post('question_topic_id');
		$level=$os->post('level');
		$question_base=$os->post('question_base');
	
	

        $dataToSave['subjectId']=addslashes($os->post('subjectId'));
        $dataToSave['classId']=$classId;
        

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
		
		$question_chapter_id=$os->post('question_chapter_id');
		$question_topic_id=$os->post('question_topic_id');
		$level=$os->post('level');
		$question_base=$os->post('question_base');
		
		$dataToSave['question_chapter_id']=$question_chapter_id;
		$dataToSave['question_topic_id']=$question_topic_id;
		$dataToSave['level']=$level;
		$dataToSave['question_base']=$question_base;
		
		

      //  $dataToSave['examdetailsId']=addslashes($os->post('examdetailsId'));



        //$dataToSave['modifyDate']=$os->now();
        //$dataToSave['modifyBy']=$os->userDetails['adminId'];

        if($questionsId < 1){

            $dataToSave['addedDate']=$os->now();
            $dataToSave['addedBy']=$os->userDetails['adminId'];
        }




        $qResult=$os->save('question_bank',$dataToSave,'questionId',$questionId);///    allowed char '\*#@/"~$^.,()|+_-=:��

    }

  
  
  // default value selection 
  
   
  
    $default_selected['marks']='1';
	$default_selected['negetive_marks']='0.5';
	$default_selected['type']='';
	$default_selected['question_chapter_id']='';
	$default_selected['question_topic_id']='';
	$default_selected['level']='';
	$default_selected['question_base']='';
	if(isset($dataToSave))
	{
		$default_selected['question_chapter_id']=$dataToSave['question_chapter_id'];
		$default_selected['negetive_marks']=$dataToSave['negetive_marks'];
		$default_selected['marks']=$dataToSave['marks'];
		$default_selected['type']=$dataToSave['type'];
		$default_selected['level']=$dataToSave['level'];
		$default_selected['question_base']=$dataToSave['question_base'];
	}  
	  
	
	
	// 
	    
	
	
   
    echo '##--EXAM-QUESTion-DATA--##';
    if($subjectId)
    {
   
    $question_chapter_arr=array();    
	//$question_chapter_rs=	$os->rowsByField($getfld='',$tables='question_chapter',$fld='subject_id',$fldVal=$subjectId,$where=' and class_id="$classId" ',$orderby='',$limit='');
	
	$question_chapter_rs=	$os->rowsByField($getfld='',$tables='question_chapter',$fld='subject_id',$fldVal=101,$where=' and class_id="11" ',$orderby='',$limit='');	
	while($question_chapter_row=  $os->mfa($question_chapter_rs) )
	{
	   $question_chapter_arr[$question_chapter_row['question_chapter_id']]=$question_chapter_row['title'];
	}
	
	
	$question_topic_arr=array();  
	//$question_chapter_id=1;  
	/*$question_topic_rs=	$os->rowsByField($getfld='',$tables='question_topic',$fld='question_chapter_id',$fldVal=$question_chapter_id,$where='  ',$orderby='',$limit='');	
	while($question_topic_row=  $os->mfa($question_topic_rs) )
	{	
		$question_topic_arr[$question_topic_row['question_topic_id']]=$question_topic_row['title'];
	}*/
	 
		
		 
		
		?>
        <div id="question_list_form">
            <div>
			
			<div class="uk-margin-small uk-grid uk-grid-small" uk-grid>
                    <div>
                      Marks  <input class="uk-input uk-border-rounded congested-form" type="text" id="marks"    style="width:30px;" value="<? echo $default_selected['marks']  ?>" />
                    </div>
                    <div>
                       Negative <input class="uk-input uk-border-rounded congested-form" type="text" id="negetive_marks"   value="<? echo $default_selected['negetive_marks']  ?>" style="width:30px;"/>&nbsp;
                    </div>
                    <div>
                    Serial   <input class="uk-input uk-border-rounded congested-form" type="text" id="viewOrder"   style="width:30px;"/> &nbsp;
                    </div>
                   
                    <div>
                    Correct Answer    <select id="correctAnswer"  class="  uk-border-rounded congested-form">
                            <option value=""> </option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
					
					
					<div>
                     Chapter   <select id="question_chapter_id"  class="  uk-border-rounded congested-form" onchange="wt_ajax_chain('html*question_topic_id*question_topic,question_topic_id,title*question_chapter_id=question_chapter_id');">
					 
                            <option value=""> </option>
                            <? echo $os->onlyOption($question_chapter_arr,$default_selected['question_chapter_id']); ?> 
                        </select>
						
						
              				 
						
                    </div>
					<div>
                      Topic  <select id="question_topic_id"  class="  uk-border-rounded congested-form">
                            <option value=""> </option>
							<? echo $os->onlyOption($question_topic_arr,$default_selected['question_topic_id']); ?> 
                           
                        </select>
                    </div>
					<div>
                     Level   <select id="level"  class="  uk-border-rounded congested-form">
                            
                            <? 
							 $question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
							 echo $os->onlyOption($question_level_arr,$default_selected['level']); ?> 
                            
                        </select>
                    </div>
					 <div>
                       
						
						Type <select id="type"  class="  uk-border-rounded congested-form">
                           
							 <? 
							 $question_type_arr=array('MCQ'=>'MCQ','DESC'=>'DESC');
							 echo $os->onlyOption($question_type_arr, $default_selected['type']); ?> 
                            
                             
                        </select> 
						
                    </div>
					<div>
                      Base  <select id="question_base"  class="  uk-border-rounded congested-form">
                            						
							<? 
							 $question_base_arr=array('Informative'=>'Informative','Math'=>'Math');
							 echo $os->onlyOption($question_base_arr,$default_selected['question_base']); ?> 
                            
                            
                        </select>
                    </div>
					
					
                </div>
                <div>
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
                </table>
            </div>



            <input type="hidden" id="examdetailsId" value="" />
            <input type="hidden" id="subjectId" value="<?  echo $subjectId; ?>" /> <!-- data shows blank and saved blank -->
            <input type="hidden" id="classId" value="<?  echo $classId; ?>" /><!-- data shows blank and saved blank -->

            <input class="uk-button uk-border-rounded uk-button-small  uk-secondary-button" type="button" value="Save" onclick="list_save_question_data('save','<? echo $subjectId; ?>')" />

            <hr>

            <?
            $q_set_q=" Select * from  question_bank where subjectId='$subjectId' ORDER BY viewOrder ASC";
            $q_set_q_rs=$os->mq($q_set_q);
            $serial=0;
            while($question_row=$os->mfa( $q_set_q_rs))
            {
			
			   
                $serial++;
                //questionId
                ?>
                <div class="uk-margin-small uk-padding-small" style="background-color:#F2F2FF;">
                    <h3 title="S: <? echo $subjectId ?>  Q:<? echo  $question_row['questionId']; ?>"><? echo $serial ?>  <? echo  $question_row['questionText']; ?> <span style="color:#FF0000; font-weight:bold; cursor:pointer;" onclick="removeRowAjaxFunction('question_bank','questionId','<? echo  $question_row['questionId']; ?>','','','list_exam_subject(\'\')');">X</span></h3>
                    <? if($question_row['questionImage']!=''){ ?>
                        <img src="<? echo $site['url'].$question_row['questionImage'] ?>"  style="height:100px" />
                    <? } ?>
                    <p class="uk-margin-small-bottom uk-text-small">
                        Marks: <span class="color-primary uk-margin-right"><? echo  $question_row['marks']; ?></span>
                        Negative marks: <span class="color-primary uk-margin-right"><? echo  $question_row['negetive_marks']; ?></span>
                        ViewOrder:
                        <input value="<? echo  $question_row['viewOrder']; ?>" type="text"
                               class="uk-input uk-border-rounded congested-form"
                               id="viewOrder_<? echo  $question_row['questionId']; ?>"
                               style="width: 50px"
                               onchange="wtosInlineEdit('viewOrder_<? echo  $question_row['questionId']; ?>','question_bank','viewOrder','questionId','<? echo  $question_row['questionId']; ?>','','','');"/>


                        <span style="display: none" class="color-primary uk-margin-right"><? echo  $question_row['viewOrder']; ?></span>
                        Type: <span class="color-primary uk-margin-right"><? echo  $question_row['type']; ?></span>
                    </p>

                    <table class="uk-table uk-table-justify congested-table uk-table-divider">
                        <tr style="<?= $question_row['correctAnswer']==1?"background-color:rgba(0,255,0,0.3)":""?>">
                            <td class="uk-table-shrink">1</td>
                            <td><? echo  $question_row['answerText1']; ?>
                                <? if($question_row['answerImage1']!=''){ ?>
                                    <img src="<? echo $site['url'].$question_row['answerImage1'] ?>"  style="height:100px" />
                                <? } ?>
                            </td>
                        </tr>

                        <tr  style="<?= $question_row['correctAnswer']==2?"background-color:rgba(0,255,0,0.3)":""?>">
                            <td class="uk-table-shrink">2</td>
                            <td>
                                <? echo  $question_row['answerText2']; ?><br />
                                <? if($question_row['answerImage2']!=''){ ?>
                                    <img src="<? echo $site['url'].$question_row['answerImage2'] ?>"  style="height:100px" />
                                <? } ?>
                            </td>
                        </tr>
                        <tr style="<?= $question_row['correctAnswer']==3?"background-color:rgba(0,255,0,0.3)":""?>">
                            <td class="uk-table-shrink">3</td>
                            <td>
                                <? echo  $question_row['answerText3']; ?><br />
                                <? if($question_row['answerImage3']!=''){ ?>
                                    <img src="<? echo $site['url'].$question_row['answerImage3'] ?>"  style="height:100px" />
                                <? } ?>
                            </td>
                        </tr>
                        <tr style="<?= $question_row['correctAnswer']==4?"background-color:rgba(0,255,0,0.3)":""?>">
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
            <? } ?>
        </div>

        <?
    }
	
	$queation_count=$serial;
	
    
	 echo '##--EXAM-QUESTion-DATA--##';	
	 echo '##--queation_count_value--##';echo $queation_count;echo '##--queation_count_value--##';
	 echo '##--subjectId_value--##'; echo $subjectId; echo '##--subjectId_value--##';
	
	
	

    

    exit();

}
