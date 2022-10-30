<?
include('wtosConfigLocal.php');
global $site, $os;
include($site['root-wtos'].'top.php');
ini_set("memory_limit", "-1");
set_time_limit(0);
$asession=date('Y');
$pluginName='';
$listHeader='Question Entry';
$ajaxFilePath= 'question_paper_entry_ajax.php';
//$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

include('tinyMCE.php');

$os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
$os->question_type_arr=array('MCQ'=>'MCQ','DESC'=>'DESC');
$os->question_base_arr=array('Informative'=>'Informative','Math'=>'Math');

$access_name = "Quention Paper";
$global_access =  $os->get_global_access_by_name($access_name);

$has_global_entry_access = in_array("Modify",$global_access) || $os->loggedUser()["adminType"] == "Super Admin";

////Written by nafish ahmed for branch wise question
$access_query  = $os->mq("SELECT 
       e.asession,
       e.class,
       e.branch_codes,
       e.examTitle,
       e.examId, 
       ed.examdetailsId,
       sub.subjectName
      
    FROM examdetails ed
    INNER JOIN exam_group eg on ed.exam_group_id = eg.exam_group_id
    INNER JOIN exam e ON ed.examId = ed.examId
    INNER JOIN subject sub ON ed.subjectId=sub.subjectId");

$filter_branches = [];
$filter_asessions = [];
$filter_classes = [];
$filter_exams = [];
$filter_examdetailses = [];
while($exam = $os->mfa($access_query)){

    $branch_codes = (array)@json_decode($exam["branch_codes"]);
    if(sizeof($branch_codes)>0) {

        foreach ($branch_codes as $branch_code) {
            $filter_branches[$branch_code] = $branch_code;
            $filter_asessions[$branch_code][$exam["asession"]] = $exam["asession"];
            if(isset($os->classList[$exam["class"]])) {
                $filter_classes[$branch_code][$exam["asession"]][$exam["class"]] = $os->classList[$exam["class"]];
            }
            $filter_exams[$branch_code][$exam["asession"]][$exam["class"]][$exam["examId"]] = $exam["examTitle"];
            $filter_examdetailses[$branch_code][$exam["asession"]][$exam["class"]][$exam["examId"]][$exam["examdetailsId"]] = $exam["subjectName"];
        }
    } else {
        $branch_code = '';
        $filter_branches[$branch_code] = $branch_code;
        $filter_asessions[$branch_code][$exam["asession"]] = $exam["asession"];
        if(isset($os->classList[$exam["class"]])){
            $filter_classes[$branch_code][$exam["asession"]][$exam["class"]] = $os->classList[$exam["class"]];
        }
        $filter_exams[$branch_code][$exam["asession"]][$exam["class"]][$exam["examId"]] = $exam["examTitle"];
        $filter_examdetailses[$branch_code][$exam["asession"]][$exam["class"]][$exam["examId"]][$exam["examdetailsId"]] = $exam["subjectName"];

    }



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
            <?
            //_d($global_access);
            ?>
            <div class="uk-grid uk-grid-small" uk-grid>
                <div>
                    Branches:
                    <div class="uk-inline">
                        <select name="branch_code_s" id="branch_code_s"
                                class="uk-select uk-border-rounded congested-form select2"
                                onchange="get_asesson_by_branch_code()" >
                            <? if($has_global_entry_access):?><option value=""> </option><?endif;?>
                            <? $os->onlyOption($os->get_branches_by_access_name($access_name),''); ?>
                        </select>
                    </div>
                </div>
                <div>
                    Session:
                    <div class="uk-inline">
                        <select name="asession_s" id="asession_s"
                                onchange="get_class_by_asession()"
                                class="uk-select uk-border-rounded congested-form" >
                        </select>
                    </div>
                </div>
                <div>
                    Class:
                    <div class="uk-inline">
                    <select name="class_s" id="class_s" class="uk-select uk-border-rounded congested-form"
                            onchange="get_exam_by_class()">
                    </select>
                    </div>
                </div>
                <div>
                    Exam:
                    <div class="uk-inline">
                    <select name="examId" id="examId" class="uk-select uk-border-rounded congested-form" onchange="wt_ajax_chain('html*examdetailsId_s*examdetails,examdetailsId,subjectId*examId=examId','','callback_subject_list_with_examdetails_id','');"  > <!--callback_subject_list-->
                    </select>
                    </div>
                </div>
                <div>

                    Subject:
                    <div class="uk-inline">
                    <select name="examdetailsId_s" id="examdetailsId_s" class="uk-select uk-border-rounded congested-form" onchange="list_question();"   >
                    </select>
                    </div>
                </div>


                <div>


                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Search" onclick="list_question();">Search</button>

                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Search" onclick="window.open('<?= $ajaxFilePath?>?question_paper_set=OK&edId='+document.getElementById('examdetailsId_s').value)">Question Paper Set</button>


                </div>


            </div>

            <script>

                let branches =  <?=json_encode($filter_branches)?>;
                let asessions =  <?=json_encode($filter_asessions)?>;
                let classes =  <?= json_encode($filter_classes)?>;
                let exams =  <?= json_encode($filter_exams)?>;
                let examdetailses =  <?=json_encode($filter_examdetailses)?>;


                function get_asesson_by_branch_code(){
                    let branch_code = $("#branch_code_s").val();
                    let values = asessions[branch_code]?asessions[branch_code]:{};
                    let html = "<option></option>";
                    for (const [key, value] of Object.entries(values)) {
                        html +='<option value="'+key+'">'+value+'</option>';
                    }
                    document.querySelector("#asession_s").innerHTML=html;
                }

                get_asesson_by_branch_code();
                function get_class_by_asession(){
                    let branch_code = $("#branch_code_s").val();
                    let asession = $("#asession_s").val();
                    let values = classes[branch_code][asession]?classes[branch_code][asession]:{};
                    let html = "<option></option>";
                    for (const [key, value] of Object.entries(values)) {
                        html +='<option value="'+key+'">'+value+'</option>';
                    }
                    document.querySelector("#class_s").innerHTML=html;
                }

                function get_exam_by_class(){
                    let branch_code = $("#branch_code_s").val();
                    let asession = $("#asession_s").val();
                    let classs = $("#class_s").val();
                    let values = exams[branch_code][asession][classs]?exams[branch_code][asession][classs]:{};
                    let html = "<option></option>";
                    for (const [key, value] of Object.entries(values)) {
                        html +='<option value="'+key+'">'+value+'</option>';
                    }
                    document.querySelector("#examId").innerHTML=html;
                }


            </script>


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

<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML" id=""> </script>
<script type="text/x-mathjax-config;executed=true">
               MathJax.Hub.Config({
                  tex2jax: { inlineMath: [["$","$"],["\\(","\\)"]] },
                  "HTML-CSS": {
                    linebreaks: { automatic: true, width: "container" }
                  }
               });
            </script>
<script>


     function list_question()
	 {

		var asession_s=os.getVal('asession_s');
		if(asession_s==''){ alert('Select Session '); os.setHtml('question_list_form',''); return false;}

		var class_s=os.getVal('class_s');
		if(class_s==''){ alert('Select Exam Class'); os.setHtml('question_list_form','');  return false;}

		var examId=os.getVal('examId');
		if(examId==''){ alert('Select Exam '); os.setHtml('question_list_form',''); return false;}

		var  examdetailsId_s=os.getVal('examdetailsId_s');
		if(examdetailsId_s==''){ alert('Select Exam subject'); os.setHtml('question_list_form',''); return false;}



		   list_save_question_data('',examdetailsId_s);
	 }

    function list_save_question_data(op,examdetailsId) // get record by table primery id
    {

         var formdata = new FormData();

		 if(document.getElementById('Question_form'))
		 {
		  var formdata = new FormData(os.getObj('Question_form'));
		 }



             var classId=os.getVal('class_s');
            formdata.append('classId',classId );

			var asession_s=os.getVal('asession_s');
            formdata.append('asession_s',asession_s );



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


			//  added 26-11-2020

			var question_chapter_idVal= os.getVal('question_chapter_id');
			var question_topic_idVal= os.getVal('question_topic_id');
			var levelVal= os.getVal('level');
			var question_baseVal= os.getVal('question_base');
			formdata.append('question_chapter_id',question_chapter_idVal );
			formdata.append('question_topic_id',question_topic_idVal );
			formdata.append('level',levelVal );
			formdata.append('question_base',question_baseVal );

			var answer_hints=tinyMCE.get("answer_hints").getContent();//os.getVal('answerText1');
            formdata.append('answer_hints',answer_hints );
			if(os.getObj('answer_hints_image').files[0]){  formdata.append('answer_hints_image',os.getObj('answer_hints_image').files[0],os.getObj('answer_hints_image').files[0].name );}

			var examdetails_section_id = os.getVal('examdetails_section_id');
			formdata.append("examdetails_section_id", examdetails_section_id);

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
            tmce_minimal('questionText');
            tmce_minimal('answerText1');
            tmce_minimal('answerText2');
            tmce_minimal('answerText3');
            tmce_minimal('answerText4');
            tmce_minimal('answer_hints');

            tinymce.execCommand('mceAddEditor',true,'questionText');
            tinymce.execCommand('mceAddEditor',true, 'answerText1');
            tinymce.execCommand('mceAddEditor',true, 'answerText2');
            tinymce.execCommand('mceAddEditor',true, 'answerText3');
            tinymce.execCommand('mceAddEditor',true, 'answerText4');
			tinymce.execCommand('mceAddEditor',true, 'answer_hints');

        }, 400);




    }

function edit_question(questionId)
{
 var location="question_paper_edit.php?questionId="+questionId;
        popUpWindow(location, 11, 11, 900, 500);

}
function question_paper_pdf_review()
{

 var examdetailsId=os.getVal('examdetailsId_s');
 var location="question_paper_pdf_review.php?examdetailsId="+examdetailsId;
        popUpWindow(location, 11, 11, 900, 500);

}




	////   aded for edit ----




     window['after_ajax_functions'].push(
         function (){
             MathJax.Hub.Typeset()
         }
     )

	function reset_search()
	{

		os.setVal('class_s','');
		os.setVal('examId','');
		os.setVal('examdetailsId_s','');
		os.setHtml('question_list_form','');



	}

var total_selected=0;
 function import_question_form_function(classId,examdetailsId,subjectId)
 {

	 total_selected=0;
	 var formdata = new FormData();

	formdata.append('classId',classId );
	formdata.append('examdetailsId',examdetailsId );
	formdata.append('subjectId',subjectId );
	formdata.append('import_question_form_function','OK' );

	url='<? echo $ajaxFilePath ?>?import_question_form_function=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

	os.setAjaxHtml('import_question_form_div',url,formdata);



 }


 function setColor(a,q_id)
 {
  var div_id='div_q_'+q_id;

  if(a.checked){
   os.getObj(div_id).style.background=" #FFBFBF";
    total_selected=total_selected+1;
  }else
  {
    total_selected=total_selected-1;
     os.getObj(div_id).style.background="none";

	 if(total_selected<1) {total_selected=0}
  }
  os.setHtml('total_selected_div',total_selected);

 }

 function add_to_question_paper()
 {

    var formdata = new FormData(os.getObj('question_selection_form'));
	 formdata.append('add_to_question_paper','OK' );


	url='<? echo $ajaxFilePath ?>?add_to_question_paper=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

	//os.setAjaxHtml('add_to_question_paper_output_div',url,formdata);
	os.setAjaxFunc('list_question_result',url,formdata);

 }
	function list_question_result(data)
	{

	os.setHtml('add_to_question_paper_output_div',data);
	//$('#import_question_form_div').dialog('close');
	list_question();
	}

</script>

<? include($site['root-wtos'].'bottom.php'); ?>
