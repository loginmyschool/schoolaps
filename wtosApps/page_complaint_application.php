<?php
   global $os,$site,$pageVar;
   $ajaxFilePath= $site['url'].'wtosApps/'.'complaint_application_ajax.php';
   $loadingImage=$site['url-wtos'].'images/loading_new.gif';
   if(!$os->isLogin() )
   {
    header("Location: ".$site['url']."login");
   }
   else{
    $studentId=$os->userDetails['studentId'];
    $student_data=$os->getSession('student_data',$studentId);
    if(!isset($student_data['studentId']))
    {
        $student_data=$os->rowByField('','history','studentId',$studentId,$where="  ",$orderby='  asession desc ');
        $os->setSession($student_data,$key1='student_data',$studentId);
    }
    $_SESSION['my_subscription_student_id']=$studentId;
    $name=$os->userDetails['name'];
    $historyId=$student_data['historyId'];
    $class=$student_data['class'];
    $asession =$student_data['asession'];
    $student_app_q=
    "select 
    stu_app.student_enquiry_id,stu_app.studentId,stu_app.subject,stu_app.description,stu_app.status,stu.name,stu_en.title
    from student_application as stu_app
    inner join student as stu on stu_app.studentId=stu.studentId
    inner join student_enquiry as stu_en on stu_en.student_enquiry_id=stu_app.student_enquiry_id    
    where stu_app.studentId='$studentId' 
    order by stu_app.student_application_id desc
    ";
    $student_app_mq=$os->mq($student_app_q);
    ?>
<table class="uk-table">
   <tr>
      <td>
         <div class="uk-card-body1">
            <div id="div_busy"></div>
            <div class="uk-margin-small">
               <label>Student enquiry </label>
               <select name="student_enquiry_id" id="student_enquiry_id" class="uk-select" >
                  <option value="">Select Enquiry</option>
                  <? $os->optionsHTML('','student_enquiry_id','title','student_enquiry');?>
               </select>
            </div>
            <div class="uk-margin-small uk-hidden">
               <label>Student</label>
               <input type="text" name="studentId" id="studentId" value="<?echo $studentId;?>" class="uk-input" required>
            </div>
            <div class="uk-margin-small">
               <label>Subject</label>
               <input value="" type="text" name="subject" id="subject" class="uk-input"/>
            </div>
            <div class="uk-margin-small">
               <label>Description</label>
               <textarea  name="description" id="description" class="uk-textarea"></textarea>
            </div>
            <div class="uk-margin">
               <input type="hidden"  id="student_application_id" value="0" />
               <button class="uk-button uk-button-primary" onclick="WT_student_applicationEditAndSave();" type="button">Save</button>
            </div>
         </div>
      </td>
      <td>
         <table   class="uk-table uk-table-divider"  >
            <thead>
               <tr >
                  <th ><b>#</td>
                  <th ><b>Enquiry On</b></th>
                  <th ><b>Subject</b></th>
                  <th ><b>Description</b></th>
                  <th ><b>Status</b></th>
               </tr>
            </thead>
            <?php $serial=0;?>
            <tbody>
               <?php while($record=$os->mfa($student_app_mq)){
                  $serial++;
                  ?>
               <tr >
                  <td ><?php echo $serial;?></td>
                  <td><?php echo $record['title']; ?></td>
                  <td><?php echo $record['subject']; ?></td>
                  <td><?php echo $record['description']; ?></td>
                  <td><?php echo $record['status']; ?></td>
               </tr>
               <? } 
                  echo $serial==0? "<tr ><td colspan='10' class='uk-text-bold uk-text-danger'>Sorry! No data found.</td></tr>":'';
                  ?> 
            </tbody>
         </table>
      </td>
   </tr>
</table>
<?}?>
<script type="text/javascript">
   function WT_student_applicationEditAndSave() {
       var formdata = new FormData();
       var student_enquiry_idVal= os.getVal('student_enquiry_id'); 
       var studentIdVal= os.getVal('studentId'); 
       var subjectVal= os.getVal('subject'); 
       var descriptionVal= os.getVal('description'); 
       formdata.append('student_enquiry_id',student_enquiry_idVal );
       formdata.append('studentId',studentIdVal );
       formdata.append('subject',subjectVal );
       formdata.append('description',descriptionVal );
       if(os.check.empty('student_enquiry_id','Please Add Enquiry')==false){ return false;} 
       var   student_application_id=os.getVal('student_application_id');
       formdata.append('student_application_id',student_application_id );
       var url='<? echo $ajaxFilePath ?>?WT_student_applicationEditAndSave=OK&';
       os.animateMe.div='div_busy';
       os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
       os.setAjaxFunc('WT_student_applicationReLoadList',url,formdata);
   
   }   
   
   function WT_student_applicationReLoadList(data) // after edit reload list
   {
   var d=data.split('#-#');
   var student_application_id=parseInt(d[0]);
   if(d[0]!='Error' && student_application_id>0){
     os.setVal('student_application_id',student_application_id);
   }
   if(d[1]!=''){alert(d[1]);}
   location.reload();
   }
   
</script>