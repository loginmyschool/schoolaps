<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
  
$pluginName='';

$os->loadPluginConstant($pluginName);
$os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
$os->question_type_arr=array('MCQ'=>'MCQ','DESC'=>'DESC');
$os->question_base_arr=array('Informative'=>'Informative','Math'=>'Math');
$os->correctAnswer_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4' );
$os->wrong_question  = array('1'=>'yes','0'=>'no');
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 

 <? include('tinyMCE.php');  ?>
</head>
<body>
<? 
if($os->get('questionId'))
{
  
    $questionId=$os->get('questionId');  
   
   $savedata=$os->post('savedata');
   
   
   
    if($savedata=='OK' && $questionId!='' )
    {
 
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

 
			
			$dataToSave['answer_hints']=addslashes($os->post('answer_hints'));
			$answer_hints_image=$os->UploadPhoto('answer_hints_image',$site['root'].'wtos-images');
			if($answer_hints_image!=''){
			$dataToSave['answer_hints_image']='wtos-images/'.$answer_hints_image;}
			
			
			 
			
		 
          // $dataToSave['correctAnswer']=addslashes($os->post('correctAnswer'));
		   
		$correctAnswer_list=$os->post('correctAnswer_list');
		$dataToSave['correctAnswer']=$os->val($correctAnswer_list,0);
		$dataToSave['correctAnswer_2']=$os->val($correctAnswer_list,1);
		$dataToSave['correctAnswer_3']=$os->val($correctAnswer_list,2);
		$dataToSave['correctAnswer_4']=$os->val($correctAnswer_list,3);
		 $dataToSave['wrong_question']=addslashes($os->post('wrong_question'));
		   
		   
		   
        $dataToSave['marks']=addslashes($os->post('marks'));
        $dataToSave['negetive_marks']=addslashes($os->post('negetive_marks'));


        $qResult=$os->save('question',$dataToSave,'questionId',$questionId);///    allowed char '\*#@/"~$^.,()|+_-=:��

    }
    
    if($questionId)
    {
			
		 
			
		 
		$query_q_count=" select   *   from question where questionId='$questionId' ";
		$query_q_countrs=$os->mq($query_q_count);
		$row=$os->mfa($query_q_countrs);
		 
		$correctAnswer_list_saved=array($row['correctAnswer'],$row['correctAnswer_2'],$row['correctAnswer_3'],$row['correctAnswer_4']);
		$correctAnswer_list_saved=array_filter($correctAnswer_list_saved);
		//_d($row);
		
		?><h2> SL NO <?=$row['viewOrder']?>  </h2>
		<form action="" method="post" enctype="multipart/form-data">
		 
        <div id="question_list_form" class="uk-grid uk-child-width-1-2" uk-grid>
		<div class="uk-margin-small uk-grid uk-grid-small" uk-grid style="padding:10px; background-color:#FFFF00; border:1px solid #FFCC00;">
                     
                     Marks    <input title="Marks" class="uk-input uk-border-rounded congested-form" type="text" id="marks" name="marks"  placeholder="Marks" style="width:50px;" value="<?=$row['marks']?>" /> &nbsp;&nbsp;&nbsp;&nbsp;
                     
                       Negetive <input title="Negative" class="uk-input uk-border-rounded congested-form" type="text" id="negetive_marks" name="negetive_marks" placeholder="Negative" value="<?=$row['negetive_marks']?>" style="width:45px;"/>&nbsp;&nbsp;&nbsp;&nbsp;
                    
                         
						
					Type	<select title="Type"  name="type" id="type" ><option value=""> </option>	<? 
										  $os->onlyOption($os->question_type_arr,$row['type']);	?></select>	 &nbsp;&nbsp;&nbsp;&nbsp;
						
                     
                     Correct option   <select id="correctAnswer"   name="correctAnswer_list[]"  multiple="multiple"    style="width:60px; height:70px;">
                             <? 
							 
							 foreach($os->correctAnswer_arr as $key => $text)
							 { 
							    ?>
								<option value="<?=$key; ?>"  <? if(in_array($key,$correctAnswer_list_saved)){ ?> selected="selected" <? } ?> ><?=$text ?></option>
								<?
							  
							 }
										  ?>
                        </select>
						
						
						Wrong question	<select title="wrong_question"  name="wrong_question" id="wrong_question" ><option value=""> </option>	<? 
										  $os->onlyOption($os->wrong_question,$row['wrong_question']);	?></select>	 &nbsp;&nbsp;&nbsp;&nbsp;
						
						
                     
                </div>
		
            <div>
                <div>
                    <textarea id="questionText"  name="questionText"  placeholder="Question" class="uk-textarea uk-border-rounded"><?=$row['questionText']?></textarea>
                    
					<? if($row['questionImage']){ ?>
                    <img id="namePreview_questionImage" src="<?=$site['url'].$row['questionImage'] ?>"  style="  height: 100px"	 />
					<?  }?>
					
                    <input type="file" id="questionImage" name="questionImage"  />
                </div> 
                <h4>Answers</h4>
                <table class="uk-table uk-table-justify congested-table">
                    <tr>
                        <td class="uk-table-shrink">1</td>
                        <td>
                            <textarea class="uk-textarea uk-border-rounded" type="text" id="answerText1" name="answerText1"  placeholder="Answer 1"><?=$row['answerText1']?></textarea>
                             <? if($row['answerImage1']){ ?>
                            <img id="namePreview_answerImage1" src="<?=$site['url'].$row['answerImage1'] ?>" style=" height:100px"	 />
							<?  }?>
                            <input type="file" id="answerImage1" name="answerImage1"  />
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <textarea class="uk-textarea uk-border-rounded"  type="text" id="answerText2"  name="answerText2"  placeholder="Answer 2"><?=$row['answerText2']?></textarea>
                            <? if($row['answerImage2']){ ?>
                            <img id="namePreview_answerImage2" src="<?=$site['url'].$row['answerImage2'] ?>" style="  height:100px"	 />
							<?  }?>
                            <input type="file" id="answerImage2" name="answerImage2"  />

                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <textarea class="uk-textarea uk-border-rounded"  type="text" id="answerText3"  name="answerText3"   placeholder="Answer 3"><?=$row['answerText3']?></textarea>
                            <? if($row['answerImage3']){ ?> 
                            <img id="namePreview_answerImage3" src="<?=$site['url'].$row['answerImage3'] ?>" style="  height:100px"	 />
							<?  }?>
                            <input type="file" id="answerImage3" name="answerImage3"    />
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <textarea  class="uk-textarea uk-border-rounded" type="text" id="answerText4"  name="answerText4"  placeholder="Answer 4"><?=$row['answerText4']?></textarea>
                            <? if($row['answerImage4']){ ?>
                            <img id="namePreview_answerImage4" src="<?=$site['url'].$row['answerImage4'] ?>" style="  height:100px"	 />
							<?  }?>
                            <input type="file" id="answerImage4" name="answerImage4"    />
                        </td>
                    </tr>
					
				 
					<tr>
                        <td></td>
                        <td> <h3 style="color:#330099">Answer Hints</h3>
                            <textarea  class="uk-textarea uk-border-rounded" type="text" id="answer_hints"  name="answer_hints"  placeholder="Answer Hints"><?=$row['answer_hints']?></textarea>
                            <? if($row['answer_hints_image']){ ?> 
                            <img id="namePreview_answer_hints" src="<?=$site['url'].$row['answer_hints_image'] ?>" style="  height:100px"	 />
							<?  }?>
                            <input type="file" id="answer_hints_image" name="answer_hints_image"  />
                        </td>
                    </tr>
					
                </table>
				
				
				 
            <input type="hidden" id="questionId"  name="questionId"  value="<?  echo $questionId; ?>" /><!-- data shows blank and saved blank -->
           <input type="hidden" name="savedata" id="savedata" value="OK" />
            <input class="uk-button uk-border-rounded uk-button-small  uk-secondary-button" type="submit" value="Save"   />
				
            </div>

             
        </div>
   </form>
        <?php
    }
      
} ?>


<script>
tmce('questionText');
            tmce('answerText1');
            tmce('answerText2');
            tmce('answerText3');
            tmce('answerText4');
            tmce('answer_hints');

           // tinymce.execCommand('mceAddEditor',true,'questionText');
          //  tinymce.execCommand('mceAddEditor',true, 'answerText1');
           // tinymce.execCommand('mceAddEditor',true, 'answerText2');
           // tinymce.execCommand('mceAddEditor',true, 'answerText3');
           // tinymce.execCommand('mceAddEditor',true, 'answerText4');
			//tinymce.execCommand('mceAddEditor',true, 'answer_hints');
			</script>
</body>
</html>
