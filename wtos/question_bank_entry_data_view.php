<?

include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');

$asession=date('Y');
$pluginName='';
$listHeader='Question Bank Entry ';
$ajaxFilePath= 'question_bank_entry_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

include('tinyMCE.php');

  
  // BELLOW QUERY SET TO UPDATE DATA FROM QUESTION TABLE
  
 /* $query_exam_details=" select   * from question    ";
     $query_exam_detailsrs=$os->mq($query_exam_details);
    while($row=$os->mfa($query_exam_detailsrs))
    {
     
	    $examdetailsId=$row['examdetailsId']; 	
		$questionId=$row['questionId']; 	 
         $examdetailsaa=$os->rowByField('','examdetails',$fld='examdetailsId',$fldVal=$examdetailsId,$where="",$orderby='',$limit='');
		 $subjectId=$examdetailsaa['subjectId'];
		
		  
         $query_upp=" update  question_bank set  subjectId='$subjectId',examdetailsId='' where    questionId='$questionId' ";
	      $os->mq($query_upp);
		
    }
        //   $query_upp=" delete from  question_bank  where    subjectId<1 ";
		//  $os->mq($query_upp);
 
	$query_exam_details=" select   distinct(subjectId) from question_bank    ";
	$query_exam_detailsrs=$os->mq($query_exam_details);
	while($row=$os->mfa($query_exam_detailsrs))
    {
        $subjectId=$row['subjectId'];
	     $subject_row=$os->rowByField('','subject',$fld='subjectId',$fldVal=$subjectId,$where="",$orderby='',$limit='');
		 $classId=$subject_row['classId'];
            $query_upp=" update  question_bank set  classId='$classId'  where    subjectId='$subjectId' ";
		 
		   $os->mq($query_upp);
		   
   }*/
 
   
  
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
            <div class="uk-inline">
                <span class="uk-form-icon  uk-background-muted p-left-m p-right-m" style="width: auto; top: 1px; left: 1px; height: calc(100% - 2px)">SESSION</span>
                <select name="asession"
                        id="asession_s"
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
<div id="list_exam_subject_DIV"></div>
</div>
</div>

<script>


    window["selected_subject_id"] = 0;
    function list_exam_subject(subjectId_clicked) // get record by table primery id
    {
        if(subjectId_clicked) {
            //clear all divs
            document.querySelectorAll(".subject_details_container").forEach(container=>{
               container.innerHTML = "";
            });

            window["selected_subject_id"]=subjectId_clicked;
            list_save_question_data('',subjectId_clicked);
        } else {
            var formdata = new FormData();

            formdata.append('subjectId_clicked', subjectId_clicked);
            formdata.append('list_exam_subject', 'OK');

            var url = '<? echo $ajaxFilePath ?>?list_exam_subject=OK&';
            os.animateMe.div = 'div_busy';
            os.animateMe.html = '<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('list_exam_subject_results', url, formdata);
        }
    }

    function list_exam_subject_results(data)  // fill data form by JSON
    {
        var content_data=	getData(data,'##--EXAM-LIST-SUBJECT-DATA--##');
        os.setHtml('list_exam_subject_DIV',content_data);
		 var selected_subjectId=	getData(data,'##--EXAM-selected_subjectId--##');
		 if(selected_subjectId)
		 {
		 list_save_question_data('',selected_subjectId);
		 }
    }



    function list_save_question_data(op,selected_subjectId) // get record by table primery id
    {
        var formdata = new FormData();

        if(op=='save'){

            var marks=os.getVal('marks');
            formdata.append('marks',marks );

            var negetive_marks=os.getVal('negetive_marks');
            formdata.append('negetive_marks',negetive_marks );


            var viewOrder=os.getVal('viewOrder');
            formdata.append('viewOrder',viewOrder );


            var type=os.getVal('type');
            formdata.append('type',type );
			
			
			
			var question_chapter_id=os.getVal('question_chapter_id');
            formdata.append('question_chapter_id',question_chapter_id );
			
			var question_topic_id=os.getVal('question_topic_id');
            formdata.append('question_topic_id',question_topic_id );
			
			var level=os.getVal('level');
            formdata.append('level',level );
			
			var question_base=os.getVal('question_base');
            formdata.append('question_base',question_base );
			
		


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
            if(os.check.empty('correctAnswer','Please enter Correct answer')==false){ return false;}



            if(os.getObj('questionImage').files[0]){  formdata.append('questionImage',os.getObj('questionImage').files[0],os.getObj('questionImage').files[0].name );}

            if(os.getObj('answerImage1').files[0]){  formdata.append('answerImage1',os.getObj('answerImage1').files[0],os.getObj('answerImage1').files[0].name );}
            if(os.getObj('answerImage2').files[0]){  formdata.append('answerImage2',os.getObj('answerImage2').files[0],os.getObj('answerImage2').files[0].name );}
            if(os.getObj('answerImage3').files[0]){  formdata.append('answerImage3',os.getObj('answerImage3').files[0],os.getObj('answerImage3').files[0].name );}
            if(os.getObj('answerImage4').files[0]){  formdata.append('answerImage4',os.getObj('answerImage4').files[0],os.getObj('answerImage4').files[0].name );}





         //   var subjectId=os.getVal('subjectId');
          //  formdata.append('subjectId',subjectId );

            var classId=os.getVal('classId');
            formdata.append('classId',classId );

        }
        formdata.append('op',op );
        formdata.append('subjectId',selected_subjectId );
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
        os.setHtml('question_list_form_'+window["selected_subject_id"],content_data);

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


   
		var subjectId_value =	getData(data,'##--subjectId_value--##');
		var queation_count_value =	getData(data,'##--queation_count_value--##');
		var count_span_id='queation_count_'+subjectId_value;
		os.setHtml(count_span_id,queation_count_value);
 	  
    }




	 list_exam_subject('');

</script>


<? include($site['root-wtos'].'bottom.php'); ?>
