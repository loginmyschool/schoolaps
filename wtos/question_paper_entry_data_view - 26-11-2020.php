<?

include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');

$asession=date('Y');
$pluginName='';
$listHeader='Question Entry ';
$ajaxFilePath= 'question_paper_entry_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

include('tinyMCE.php');

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
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <div class="uk-inline uk-margin-small-right">
                <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button uk-hidden" uk-toggle="target: #add-form-modal">
                    <span uk-icon="icon:  plus; ratio:0.7" class="m-right-s"></span>
                    Add New
                </button>
            </div>
            <div class="uk-inline" style="display:none;">
                <span class="uk-form-icon  uk-background-muted p-left-m p-right-m" style="width: auto; top: 1px; left: 1px; height: calc(100% - 2px)">SESSION</span>
                <select name="asession"
                        id="asession_sdddddddddddddddddddddddddddddddddddddddddddd"
                        style="padding-left: 85px"
                        class="uk-select uk-border-rounded uk-form-small  p-right-xl text-m" onchange="list_exam_subject('');">
                    <option value=""> </option>
                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select>
            </div>
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
                        <select name="asession" id="asession_s" class="uk-select uk-border-rounded congested-form" ><option
                                    value=""> </option>	<?
                            $os->onlyOption($os->asession,$os->selectedSession());
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    Class:
                    <div class="uk-inline">
                    <select name="class_s" id="class_s" class="uk-select uk-border-rounded congested-form" onchange="wt_ajax_chain('html*examId*exam,examId,examTitle*class=class_s','','','');">
                         <? foreach ($os->board as $board):?>
                        <optgroup label="<?= $board?>">
                            <? foreach ($os->board_class[$board] as $class):?>
                        <option value="<?=$class?>"><?=$os->classList[$class]?></option>
                            <? endforeach;?>
                        </optgroup>
                    <? endforeach;?>
                    </select>
                    </div>
                </div>
                <div>
                    Exam:
                    <div class="uk-inline">
                    <select name="examId" id="examId" class="uk-select uk-border-rounded congested-form" onchange="wt_ajax_chain('html*examdetailsId_s*examdetails,examdetailsId,subjectId*examId=examId','','callback_subject_list','');"  > <!--callback_subject_list-->
                    </select>
                    </div>
                </div>
                <div>

                    Subject:
                    <div class="uk-inline">
                    <select name="examdetailsId_s" id="examdetailsId_s" class="uk-select uk-border-rounded congested-form" onchange="list_question()" >
                    </select>
                    </div>
                </div>

                
                <div>


                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Search" onclick="list_question();">Search</button>
                   <!-- <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Reset" onclick="searchReset();">Reset</button>-->

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
                <div id="TD_ID_for_other_function_DIV"  class="uk-width-1-1">
                </div>
            </div>
        </div>


        <div id="showStudent_details_DIV" style="background:#F0F0FF;"  >
            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
            <input type="hidden"  id="WT_admissionReadmissionPageno" value="1" />
        </div>
		
		<div id="question_list_form" style="margin-left:10px;" >

       </div>
		
    </div>
</div>
 

<script>


     function list_question()
	 {
	      
		 var  examdetailsId_s=os.getVal('examdetailsId_s');
		 
		  if(examdetailsId_s==''){ alert('Select Exam subject'); return false;}
		   list_save_question_data('',examdetailsId_s);
	 }

    function list_save_question_data(op,examdetailsId) // get record by table primery id
    {
	  
        var formdata = new FormData();
		
		    

            //var classId=os.getVal('class_s');
            //formdata.append('classId',classId );

        if(op=='save'){

            var marks=os.getVal('marks');
            formdata.append('marks',marks );

            var negetive_marks=os.getVal('negetive_marks');
            formdata.append('negetive_marks',negetive_marks );


            var viewOrder=os.getVal('viewOrder');
            formdata.append('viewOrder',viewOrder );


            var type=os.getVal('type');
            formdata.append('type',type );



            var questionText=tinyMCE.get("questionText").getContent();//os.getVal('questionText');
            formdata.append('questionText',questionText );


            var answerText1=tinyMCE.get("answerText1").getContent();//os.getVal('answerText1');
            formdata.append('answerText1',answerText1 );


            var answerText2=tinyMCE.get("answerText2").getContent();//os.getVal('answerText2');
            formdata.append('answerText2',answerText2 );

            var answerText3=tinyMCE.get("answerText3").getContent();//os.getVal('answerText3');
            formdata.append('answerText3',answerText3 );

            var answerText4=tinyMCE.get("answerText4").getContent();//os.getVal('answerText4');
            formdata.append('answerText4',answerText4 );

            var correctAnswer=os.getVal('correctAnswer');
            formdata.append('correctAnswer',correctAnswer );

            if(os.check.empty('marks','Please Add marks')==false){ return false;}
            if(os.check.empty('correctAnswer','Please enter Correct option')==false){ return false;}



            if(os.getObj('questionImage').files[0]){  formdata.append('questionImage',os.getObj('questionImage').files[0],os.getObj('questionImage').files[0].name );}

            if(os.getObj('answerImage1').files[0]){  formdata.append('answerImage1',os.getObj('answerImage1').files[0],os.getObj('answerImage1').files[0].name );}
            if(os.getObj('answerImage2').files[0]){  formdata.append('answerImage2',os.getObj('answerImage2').files[0],os.getObj('answerImage2').files[0].name );}
            if(os.getObj('answerImage3').files[0]){  formdata.append('answerImage3',os.getObj('answerImage3').files[0],os.getObj('answerImage3').files[0].name );}
            if(os.getObj('answerImage4').files[0]){  formdata.append('answerImage4',os.getObj('answerImage4').files[0],os.getObj('answerImage4').files[0].name );}





            var subjectId=os.getVal('subjectId');
            formdata.append('subjectId',subjectId );

            var classId=os.getVal('classId');
            formdata.append('classId',classId );

        }
        formdata.append('op',op );
        formdata.append('examdetailsId',examdetailsId );
        formdata.append('list_save_question_data','OK' );

        var url='<? echo $ajaxFilePath ?>?list_save_question_data=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('list_save_question_data_results',url,formdata);

        tinymce.execCommand('mceRemoveEditor',true,'questionText');
        tinymce.execCommand('mceRemoveEditor',true, 'answerText1');
        tinymce.execCommand('mceRemoveEditor',true, 'answerText2');
        tinymce.execCommand('mceRemoveEditor',true, 'answerText3');
        tinymce.execCommand('mceRemoveEditor',true, 'answerText4');

        tinymce.remove('questionText');
        tinymce.remove('answerText1');
        tinymce.remove('answerText2');
        tinymce.remove('answerText3');
        tinymce.remove('answerText4');
    }

    function list_save_question_data_results(data)  // fill data form by JSON
    {
        var content_data =	getData(data,'##--EXAM-QUESTion-DATA--##');
        os.setHtml('question_list_form',content_data);

        setTimeout(function (){
            tmce('questionText');
            tmce('answerText1');
            tmce('answerText2');
            tmce('answerText3');
            tmce('answerText4');


            tinymce.execCommand('mceAddEditor',true,'questionText');
            tinymce.execCommand('mceAddEditor',true, 'answerText1');
            tinymce.execCommand('mceAddEditor',true, 'answerText2');
            tinymce.execCommand('mceAddEditor',true, 'answerText3');
            tinymce.execCommand('mceAddEditor',true, 'answerText4');
        }, 400);




    }
  
</script>


<? include($site['root-wtos'].'bottom.php'); ?>
