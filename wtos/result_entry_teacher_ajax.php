<? 

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php 

   #  

*/
exit();////////////////////////////////
include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

 function showStudentResults($parsms)
 {
 
 
 }  


if($os->get('get_subjects_by_class')=='OK' && $os->post('get_subjects_by_class')=='OK')
{ 

   $asession=$os->post('asession');
   $classes=$os->post('classes');
	$subjects=$os->subjects_by_class($asession,$classes);
	
	
 echo '##--SUBJECT-BY-CLASS--##';
	if(is_array($subjects)){
	?>
	<select id="subject_id" onchange="manage_exam_setting('search');" >
	<option> </option>
	<? 
	foreach($subjects as $key=> $subject)
	{
	?>
	   <option type="checkbox" name="" value="<? echo $key; ?>" /> <? echo $subject; ?>  </option>
	
	<?   
	
	}
	
	?>
	
	</select>
	<?
	}
	
	echo '##--SUBJECT-BY-CLASS--##';

exit();

}

if($os->get('get_teacher_by_subject')=='OK' && $os->post('get_teacher_by_subject')=='OK')
{ 

   $asession=$os->post('asession');
   $subject=$os->post('subject');
	$teachers=$os->get_teacher_by_subject($asession,$subject);//
	
 echo '##--teacher-BY-SUBJECT--##';
	if(is_array($teachers)){
	?>
	<select id="teacherId" >
	<option> </option>
	<? 
	foreach($teachers as $teachersId=> $teachersname)
	{
	?>
	   <option   name="" value="<? echo $teachersId; ?>" /> <? echo $teachersname; ?>  </option>
	
	<?   
	
	}
	
	?>
	
	</select>
	<?
	}
	
	echo '##--teacher-BY-SUBJECT--##';

exit();

}
 
if($os->get('manage_exam_setting')=='OK' && $os->post('exam_config')=='OK')
{
 
     
 
       $asession=$os->post('asession');
	
	$subject_id=$os->post('subject_id');
	$classes=$os->post('classes');
	 $button=$os->post('button');
	 
	// echo " $classList   $subject_id  $asession   $button  ";
	
	                                $examTitle=$os->post('examTitle');
									$examdetailsId=$os->post('examdetailsId');
									$writtenMarks=$os->post('writtenMarks');
									$viva=$os->post('viva');
									$practical=$os->post('practical');
									$totalMarks=$os->post('totalMarks');
									$teacherId=$os->post('teacherId');
				$section_list=$os->post('section_list');
				$roll_no=$os->post('roll_no');
				$studentId=$os->post('studentId');
				
				$grade=$os->post('grade');

	
	 $subjectArr=$os->getSubjectList($asession=$asession,$classId=$classes);
	 
	 
	 $subjectName='';
	 if(isset($subjectArr[$subject_id])){
	 $subjectName=$subjectArr[$subject_id];
	 }
	
	//if($teacherId!='' && $asession!='' && $subject_id!='' && $classes!='' && $button=='save' )
	
	  
	
	$validate_student_id =$os->isValidStudent($studentId,$asession,$classes ,$roll_no );
	
	if( $asession!='' && $classes!='' && $button=='save'  && $section_list!='' && $subject_id!=''&& $roll_no!='' && $studentId!='' && $validate_student_id >0)
	{ 
				
				 
				
				$dataToSave=array();
				$dataToSave['examTitle']=$examTitle;
				$dataToSave['asession']=$asession;
				$dataToSave['class']=$classes;
				 
				
				$dataToSave['teacherId']=$teacherId;
				$dataToSave['subjectId']=$subject_id;
				$dataToSave['subjectName']=$subjectName; // name please
				$dataToSave['asession']=$asession;
				$dataToSave['section']=$section_list;	
				$dataToSave['roll_no']=$roll_no;	
				$dataToSave['studentId']=$studentId;	
				
				
				$dataToSave['resultsId']='';
				$dataToSave['examdetailsId']='';
				$dataToSave['examId']='';	
				
			 			 
					$dataToSave['writtenMarks']=$writtenMarks;
				$dataToSave['viva']=$viva;
				$dataToSave['practical']=$practical;
				$dataToSave['totalMarks']=$totalMarks;
				$dataToSave['grade']=$grade;
				
				
			
			 
				
				
				$dataToSave['addedDate']=$os->now();
				$dataToSave['addedBy']='';
				$dataToSave['modifyBy']='';
				$dataToSave['modifyDate']=$os->now();
				
				
				
				$resultsdetailsId=0;
				
				// checking for duplicate update 
				   $alreadyEntryquery="select * from resultsdetails where class!=''  and  asession='$asession' and examTitle='$examTitle' and class='$classes'
				     and subjectId='$subject_id'   and  roll_no='$roll_no' and   studentId='$studentId'  limit 1";
	            	$alreadyEntryquery_rs=$os->mq($alreadyEntryquery);
					$alreadyEntryquery=$os->mfa($alreadyEntryquery_rs);
					
					if(isset($alreadyEntryquery['resultsdetailsId']))
					{
					   
					   $resultsdetailsId=$alreadyEntryquery['resultsdetailsId'];
					}
					 
				// checking for update  
				
				
				
				$qResult=$os->save('resultsdetails',$dataToSave,'resultsdetailsId',$resultsdetailsId);								
					    	 	 	 	  
			 
			   	  
			   
	
	}
	
	  $os->create_record_for_all_student($examTitle,$asession,$classes,$subject_id,$subjectName); 
	$classList_s=$os->post('classList_s');	
	$classList_s=$classes;
	$andClass='';
	//if($classList_s!='')
	{
	  $andClass=" and class='$classList_s'";
	
	}
	
	$config_array=array();
	
	
	   $sel="select * from resultsdetails where class!=''   $andClass  
	   and  asession='$asession' and examTitle='$examTitle' and section='$section_list'  and subjectId='$subject_id'
	   order by resultsdetailsId desc ";
	   
	 
	$resset=$os->mq($sel);
	
 
	 $examMarks['writtenMarks']='50';
    $examMarks['viva']='50';
	$examMarks['practical']='0'; 
	echo '##--EXAM-SETTING-DATA--##';
	
	
	 echo '
		
		<div class="exam_subject"><div class="exam_subject_head">Class: '.$classList_s." ( $section_list ) ".'  <span  class="exam_subject_head_span"> '   .$examTitle  .' </span>  '   .$asession. ' Subject: '. $subjectName.                ' </div>  ';
		      
	    echo ' <div style="clear:both"> </div></div> 
		
		
		
		';
		?><table cellspacing="2" cellpadding="2" width="100%" class="result">
		<tr> <td> SL</td>   
		 <td> Roll </td>  
		  <td> Student</td>   
	      
	  
	  
	   <td>Writt. </td> 
	    <td>Viva </td>  
		 <td>Prac. </td> 
	    <td>Total </td>  
		 <td>Grd  </td>  
		</tr>
		<? 
	  $sl=0;
	 while($record=$os->mfa($resset))
	 
	 {
	 
	 
	  
	
	$subjectName='';
	 if($record['subjectId']>0)
	 {
	  $subjectName=$os->val($subjectArr,$record['subjectId']);
	  }
	  $studentId=$record['studentId'];
	 $studentName =$os->rowByField('name','student','studentId',$studentId,$where='',$orderby='') ;
	  
	     $record['percent']=1;
		$sl++;
		$edit_str=$record['studentId'].'--'.$record['roll_no'].'--'.$record['writtenMarks'].'--'.$record['viva'].'--'.$record['practical'].'--'.$record['totalMarks'].'--'.$record['grade'];
		
		?><tr> <td> <? echo $sl; ?></td>   
		       <td style="color:#004488"> <? echo $record['section']; ?>-<?   echo $record['roll_no']; ?>  
		       <td> <span onclick="student_by_roll('<? echo $record['roll_no'] ?>')"
			         
			   
			    style="color:#0000CC; cursor:pointer; font-size:11px;">  <? echo $studentName; ?>   </span>  
				<span style="color:#A3A3A3; font-size:10px; "><? echo $record['studentId']; ?> </span></td>   
	   
	  
	   
	   
	    </td>  
	   
	   <td>
	   
	   <? 
	   if($examMarks['writtenMarks']>0){
	    $os->editText($record['writtenMarks'],'resultsdetails','writtenMarks','resultsdetailsId',$record['resultsdetailsId'], $inputNameID='editText_writtenMarks',$extraParams='class="editText" ');
	   }else
	   {
	   
	   echo $record['writtenMarks']; 
	   }
	   
	    ?>
	   
	   
	   </td> 
	    <td style="background-color:#FFFFCC">
		
		<? 
	   if($examMarks['viva']>0){
	    $os->editText($record['viva'],'resultsdetails','viva','resultsdetailsId',$record['resultsdetailsId'], $inputNameID='editText_viva',$extraParams='class="editText" ');
	   }else
	   {
	   
	   echo $record['writtenMarks']; 
	   }
	   
	    ?>

		 
		</td>  
		 <td>
		 
		 <? 
	   if($examMarks['practical']>0){
	    $os->editText($record['practical'],'resultsdetails','practical','resultsdetailsId',$record['resultsdetailsId'], $inputNameID='editText_practical',$extraParams='class="editText" ');
	   }else
	   {
	   
	   echo $record['writtenMarks']; 
	   }
	   
	    ?>
		 
		  
		 </td> 
	    <td style="background-color:#FFFFCC"><? echo $record['totalMarks']; ?></td>  
		<td style="background-color:#FFFFCC"><? echo $record['percent']; ?></td>  
		 <td>
		  
		 <? $os->editText($record['grade'],'resultsdetails','grade','resultsdetailsId',$record['resultsdetailsId'], $inputNameID='editText_grade',$extraParams='class="editText" ');?>
		 
		 </td>  
		</tr>
		<?
	     
	 }
	 
	 ?></table>
	 <? 
	 
	 
	
	
	
echo '<div style="clear:both"> &nbsp;</div>';
echo '##--EXAM-SETTING-DATA--##';

exit();
}
 
if($os->get('get_students')=='OK' && $os->post('get_students')=='OK')
{ 

   $asession=$os->post('asession');
   $classes=$os->post('classes');
	 
	  $students_query=" select * from history where class='$classes'  and asession='$asession' order by roll_no desc  ";
	
 echo '##--STUDENTSJSON--##';
	 $sr=$os->mq($students_query);
	
 $stdunet_arr=array();
	 
	 $key=0; 
	 $roll_no_arr=array();
	 while($record=$os->mfa($sr))
	 
	 {  
	 
	 
	  
			  if($record['roll_no']>0)
			  {
			      $key++;
				 $roll_no_arr[$key]=$record['roll_no'];
				 
				 $record['writtenMarks']=rand(1,100);
				 $record['viva']=rand(1,100);
				 $record['practical']=rand(1,100);
				 $record['totalMarks']=rand(1,100);
				 
				 
				 
				 $stdunet_arr[$key]=$record;
				 
				 $stdunet_id_arr[$record['studentId']]=$record['studentId'];
				
				} 
	 }
	if(count($roll_no_arr)<1)
	{
	$roll_no_arr=array(0);
	}
	 $json_arr_str=json_encode($stdunet_arr);
	 echo $json_arr_str;
	echo '##--STUDENTSJSON--##';
	
	echo '##--MINROLL--##';   if($key>0){ echo '1';} else{ echo '0';} echo '##--MINROLL--##';
	echo '##--MAXROLL--##';  echo $key; echo '##--MAXROLL--##';
	 
	

exit();

}


if($os->get('student_by_roll')=='OK' && $os->post('student_by_roll')=='OK')
{ 

                   

   $asession=$os->post('asession');
   $classes=$os->post('classes');
   $roll_no=$os->post('roll_no');
   $class=$classes;
   
   
   
   					$record['studentId']='';
					$record['roll_no']='';
					
	
	 
               $alreadyEntryquery="select studentId,roll_no from history where class!=''  and  asession='$asession'   and class='$class'
				      and  roll_no='$roll_no'    limit 1";
					  
					   
					    
					 
	            	$alreadyEntryquery_rs=$os->mq($alreadyEntryquery);
					$alreadyEntryquery=$os->mfa($alreadyEntryquery_rs);
					if(isset($alreadyEntryquery['studentId']))
					{
					$record=$alreadyEntryquery;
					  
					}
					
					  $studentName =$os->rowByField('name','student','studentId',$record['studentId'],$where='',$orderby='') ;
					$record['writtenMarks']='';
					$record['viva']='';
					$record['practical']='';
					$record['totalMarks']='';
					$record['grade']='';
	 
	$edit_str=$record['studentId'].'--'.$record['roll_no'].'--'.$record['writtenMarks'].'--'.$record['viva'].'--'.$record['practical'].'--'.$record['totalMarks'].'--'.$record['grade'].'--'.$studentName;
 echo '##--student-BY-roll--##'; 
	
  echo $edit_str;
	echo '##--student-BY-roll--##';

exit();

}


 

