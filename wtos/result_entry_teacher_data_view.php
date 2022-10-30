<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php 

   #  

*/

exit();

include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');
	$logged_teacherId=1; /// todolist
?><?

$pluginName='';

$listHeader='Result Entry ';

$ajaxFilePath= 'result_entry_teacher_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

  $query_exam_list=" select distinct(examTitle) from exam";
   $query_exam_listrs=$os->mq($query_exam_list);
	while($elistdata=$os->mfa($query_exam_listrs))
	{
	  $exam_list[$elistdata['examTitle']]=$elistdata['examTitle'];
      
	}
	
	

	
$teacher_acces=	$os->get_teacher_acces($logged_teacherId);
  
 
  ?> 





  



 <table class="container"  cellpadding="0" cellspacing="0">

				<tr>

					 

			  <td  class="middle" style="padding-left:5px;">

			  

			  

			  <div class="listHeader"  > 

			  <?php  echo $listHeader; ?>  &nbsp;&nbsp;  <span style="color:#0000CC">  for Session:

	

	<select name="asession" id="asession_s" class="textbox fWidth" onchange="">
	<option value=""></option>
	<? $os->onlyOption($os->asession,$os->selectedSession());?>
	</select>	
  </span>

			  

			 

			  </div>

			  

			  <!--  ggggggggggggggg   -->

			  
     
			  

			  <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

			  

  <tr>

    <td width="380" height="470" valign="top" class="ajaxViewMainTableTDForm">
	Welcome back   <span style="font-style:italic; color:#004080; font-size:18px;">  Mizanur Rahaman </span> <br />
	<span style="font-style:italic; color:#0074E8;"> <? echo date('d-m-Y l h:m a ');  ?></span>
	
	<table width="100%" border="0" cellspacing="3" cellpadding="3" style="margin-top:20px;">
  <tr>
    <td colspan="4">Exam Title <br /> 
		
		 
		 
		<select name="examTitle" id="examTitle" class="textbox fWidth"  > 	<? 

$os->onlyOption($exam_list,'');	?>
</select> </td>
</tr>
  <tr>

    <td style="width:50px;"> Class</td><td style="width:100px;"> <select name="classes" id="classes" class="textbox fWidth" onchange="get_subjects_by_class(); initsearch()"><option value=""></option>	<? 

$os->onlyOption($os->classList,'');	?></select>	 </td>
    <td style="width:50px;">Section </td><td style="width:100px;">
		<select name="section_list" id="section_list" onchange="get_students()"> 
		<option value=""> </option>
		<? 
	foreach($os->section as $key=> $val)
	{
	?>
	   <option     value="<? echo $key; ?>" /> <? echo $val; ?>   </option> 
	
	<?   
	
	}
	
	?>
	</select></td>
  </tr>
  <tr>
    <td>
	Subject </td><td>
	<div id="subject_by_class_div">
	  <select name="select" id="subject_id" onchange="manage_exam_setting('search');" > <!-- onchange="get_teacher_by_subject();"-->
      </select>
	</div></td>
    <td>
	  </td><td>
	<div id="teacher_by_subject_results_div"  >
	<select id="teacherId" >
	<option value="0"></option>
	 </select>
	</div>
	<span id="totalStudentstr" style="display:none;"> </span>
	</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2" style="margin-top:20px;">
  <tr>
    <td>Roll</td>
    <td>Written</td>
    <td>Oral</td>
    <td>Practical</td>
    <td>Total</td>
    <td>Grade</td>
  </tr>
  <tr>
    <td>  
	<input type="text" name="roll_no" id="roll_no" value="" class="avglengthtext" onchange="student_by_roll('')" />
	 </td>
    <td><input type="text" name="writtenMarks" id="writtenMarks" value=""  class="avglengthtext"/></td>
    <td><input type="text" name="viva" id="viva" value="" class="avglengthtext" /></td>
    <td><input type="text" name="practical" id="practical" value="" class="avglengthtext" /></td>
    <td><input type="text" name="totalMarks" id="totalMarks" value="" class="avglengthtext" /></td>
    <td><input type="text" name="grade" id="grade" value="" class="avglengthtext" /> </td>
  </tr>
  
  
  <tr><td><input type="button" onclick="prevStudent();" value="<<"   ></td>
    <td colspan="4">
	 <input type="text" name="studentId" id="studentId" value="" style="border:0px; background:none; font-size:16px; color:#0000CC;"/>
	 <input type="text" value="" name="studentName" id="studentName" style="border:0px; background:none; font-size:16px; color:#0000CC;"/>
	<br />
	
	
	 
	
	 </td>
	 <td><input type="button" onclick="nextStudent();" value=">>"  > </td>
  </tr>
  
  <tr>
    <td colspan="6" align="center"><input name="button" type="button" onclick="manage_exam_setting('save')" value="SAVE"/> </td>
  </tr>
</table>









	   


	

	</td>

    <td valign="top" class="ajaxViewMainTableTDList">

	

	<div class="ajaxViewMainTableTDListSearch" style="display:none;">

						  

	
			

	 <span class="hideForSelectedData">

 



Class <select name="classList" id="classList_s" class="textbox fWidth"><option value=""></option>	<? 

$os->onlyOption($os->classList,'');	?></select>	

</span>



  <input type="button" value="Search" onclick="manage_exam_setting('search');" style="cursor:pointer;"/>

  

   
  

  <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

 

  

   </div>

	<div  class="ajaxViewMainTableTDListData" id="WT_feesListDiv">&nbsp; </div>

	&nbsp;</td>

  </tr>

</table>



		

			  			  

			  <!--   ggggggggggggggg  -->

			  

			  </td>

			  </tr>

			</table>

			

	 <script>
	 
	function get_subjects_by_class() // get record by table primery id
{
	   var formdata = new FormData();
	    
	 
	     

    var asession=os.getVal('asession_s');
	formdata.append('asession',asession );
	
	 var classes=os.getVal('classes');
	formdata.append('classes',classes );


	
	formdata.append('get_subjects_by_class','OK' );
	 
	
	var url='<? echo $ajaxFilePath ?>?get_subjects_by_class=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('get_subjects_by_class_results',url,formdata);
	 			
}

function get_subjects_by_class_results(data)  // fill data form by JSON
{
    
   var content_data=	getData(data,'##--SUBJECT-BY-CLASS--##');
   os.setHtml('subject_by_class_div',content_data);
   os.setVal('teacherId','');
	//var objJSON = JSON.parse(data);
	// os.setVal('product_id',parseInt(objJSON.product_id));
	 

  
} 
	
	function get_teacher_by_subject() // get record by table primery id
{
	   var formdata = new FormData();
	    
	 
	     

    var asession=os.getVal('asession_s');
	formdata.append('asession',asession );
	
	 var subject=os.getVal('subject_id');
	formdata.append('subject',subject_id );


	
	formdata.append('get_teacher_by_subject','OK' );
	 
	
	var url='<? echo $ajaxFilePath ?>?get_teacher_by_subject=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('get_teacher_by_subject_results',url,formdata);
	 			
}

function get_teacher_by_subject_results(data)  // fill data form by JSON
{
    
   var content_data=	getData(data,'##--teacher-BY-SUBJECT--##');
   os.setHtml('teacher_by_subject_results_div',content_data);
   
	//var objJSON = JSON.parse(data);
	// os.setVal('product_id',parseInt(objJSON.product_id));
	 

  
}    
function manage_exam_setting(button) // get record by table primery id
{
	var formdata = new FormData();
	 
	 
	 
	
	 var section_list=os.getVal('section_list');
	formdata.append('section_list',section_list );
	
	
	 var teacherId=os.getVal('teacherId');
	formdata.append('teacherId',teacherId );
	
	var subject_id=os.getVal('subject_id');
	formdata.append('subject_id',subject_id );
	
	var asession=os.getVal('asession_s');
	formdata.append('asession',asession );
	
	var classes=os.getVal('classes');
	formdata.append('classes',classes );
   var examTitle=os.getVal('examTitle');
formdata.append('examTitle',examTitle );	

var classList_s=os.getVal('classList_s');
formdata.append('classList_s',classList_s );	

		
 		 
				
					
var writtenMarks=os.getVal('writtenMarks');
formdata.append('writtenMarks',writtenMarks );			
var viva=os.getVal('viva');
formdata.append('viva',viva );			
var practical=os.getVal('practical');
formdata.append('practical',practical );			
var totalMarks=os.getVal('totalMarks');
formdata.append('totalMarks',totalMarks );




var grade=os.getVal('grade');
formdata.append('grade',grade );
	
	var studentId=os.getVal('studentId');
formdata.append('studentId',studentId );
var roll_no=os.getVal('roll_no');
formdata.append('roll_no',roll_no );


formdata.append('button',button );
	
	formdata.append('exam_config','OK' );
	 
	
	var url='<? echo $ajaxFilePath ?>?manage_exam_setting=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('manage_exam_setting_results',url,formdata);
	 			
}

function manage_exam_setting_results(data)  // fill data form by JSON
{
    
   var content_data=	getData(data,'##--EXAM-SETTING-DATA--##');
   os.setHtml('WT_feesListDiv',content_data);
   
	//var objJSON = JSON.parse(data);
	// os.setVal('product_id',parseInt(objJSON.product_id));
	 

  
}
// getting student data
var currentStudent=0;
var global_min_serial=0;
var global_max_serial=0;
var currentStudent=0;
function get_students() // get record by table primery id
{
	   var formdata = new FormData();
	 
	    var asession=os.getVal('asession_s');
	formdata.append('asession',asession );
	
	 var subject=os.getVal('subject_id');
	formdata.append('subject',subject_id );

    var classes=os.getVal('classes');
	formdata.append('classes',classes );
	
	formdata.append('get_students','OK' );
	 
	
	var url='<? echo $ajaxFilePath ?>?get_students=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('get_students_results',url,formdata);
	 			
}

function get_students_results(data)  // fill data form by JSON
{
    
   var content_data=	getData(data,'##--STUDENTSJSON--##');
   os.setVal('studentList',content_data);
   
   
     global_min_serial=	getData(data,'##--MINROLL--##');
     global_max_serial=	getData(data,'##--MAXROLL--##');
    // alert (global_minroll);
	//  alert (global_maxroll);
   var totalStudentstr_data='Total student '+global_max_serial;
   os.setHtml('totalStudentstr',totalStudentstr_data);
    
   currentStudent=parseInt(global_min_serial);
   
    var data =os.getVal('studentList');
  var objJSON = JSON.parse(data);
  
   resetStudentBlank();
   if(objJSON[currentStudent])
  {
   var student_obj = objJSON[currentStudent];
   setStudent(student_obj);
   }
   
  // alert(content_data);
	//var objJSON = JSON.parse(data);
	// os.setVal('product_id',parseInt(objJSON.product_id));
  
  manage_exam_setting('search');
  
}    



function nextStudent()
{
   currentStudent=parseInt(currentStudent)+1;
   
   if(currentStudent>global_max_serial)
   {
   currentStudent=global_min_serial;
   }
   

  var data =os.getVal('studentList');
  var objJSON = JSON.parse(data);
  
   resetStudentBlank();
   if(objJSON[currentStudent])
  {
   var student_obj = objJSON[currentStudent];
   setStudent(student_obj);
   }
    
}
function prevStudent()
{
  currentStudent=parseInt(currentStudent)-1;
  
  if(currentStudent<global_min_serial)
   {
   
   currentStudent=global_max_serial;
   }
  
  
  var data =os.getVal('studentList');
 
  var objJSON = JSON.parse(data);
    
 
			 
   
   resetStudentBlank();
  if(objJSON[currentStudent])
  {
  var student_obj = objJSON[currentStudent];
   setStudent(student_obj); 
   }
   
}

function resetStudentBlank()
{
os.setVal('studentId','');
 os.setVal('roll_no','');
 os.setVal('writtenMarks','');

 os.setVal('viva','');
 os.setVal('practical','');
 os.setVal('totalMarks','');
 os.setVal('studentName','');
  
}
function setStudent(student_obj)
{
   
   
   var studentId=student_obj.studentId
   var roll_no=student_obj.roll_no;
   
   
   var writtenMarks=student_obj.writtenMarks
 
    var viva=student_obj.viva;
	 var practical=student_obj.practical;
	  var totalMarks=student_obj.totalMarks;
	     
		 
 os.setVal('studentId',studentId);
 os.setVal('roll_no',roll_no);
 os.setVal('writtenMarks',writtenMarks);

 os.setVal('viva',viva);
 os.setVal('practical',practical);
 os.setVal('totalMarks',totalMarks);
   
}

function initsearch()
{
  os.setHtml('WT_feesListDiv','');
  os.setVal('section_list','');
  os.setVal('totalStudentstr','');

}

function editResultByclick(data)
{
 resetStudentBlank();
   var d=data.split('--'); 
   os.setVal('studentId',d[0]);
 os.setVal('roll_no',d[1]);
 os.setVal('writtenMarks',d[2]);

 os.setVal('viva',d[3]);
 os.setVal('practical',d[4]);
 os.setVal('totalMarks',d[5]);
 os.setVal('grade',d[6]);
  os.setVal('studentName',d[7]);
   
 

}
function student_by_roll(roll)
{
 
	   var formdata = new FormData();
	    
	    var roll_no=os.getVal('roll_no');
	     if(roll!='')
		 {
             var roll_no=roll;
	     }
	
	formdata.append('roll_no',roll_no );
	
	 var subject=os.getVal('subject_id');
	formdata.append('subject',subject_id );
     
	  var asession=os.getVal('asession_s');
	formdata.append('asession',asession );
	
	var classes=os.getVal('classes');
	formdata.append('classes',classes );

	
	formdata.append('student_by_roll','OK' );
	 
	
	var url='<? echo $ajaxFilePath ?>?student_by_roll=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('student_by_roll_results',url,formdata);
	 			
}

function student_by_roll_results(data)  // fill data form by JSON
{
    
   var content_data=	getData(data,'##--student-BY-roll--##');
   editResultByclick(content_data);
	 

  
}    
 


 
	
	</script>
  
<input   value='' id="studentList" type="hidden"/>
<style>
.avglengthtext{ width:30px; height:20px; border:1px dotted #999999}
.result td{ border:none; border-bottom:dotted #ffffff 1px; border-left:dotted #ffffff 1px; }
.editText{ width:50px; border: 1px dotted #BFDFFF;}
</style>
 <!--// getting student data-->

<? include($site['root-wtos'].'bottom.php'); ?>