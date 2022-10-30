<?php
   global $os,$pageVar;
   $ajaxFilePath= $site['url'].'wtosApps/'.'employee-page-ajax.php';
   $loadingImage=$site['url-wtos'].'images/loadingwt.gif';
   
   $userId=$os->userDetails['studentId'];
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Oriental English Academy</title>
      <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <script type="text/javascript" src="<? echo $site['url-library']?>wtos-1.1.js"></script>
      <!-- UIkit CSS -->
      <link rel="stylesheet" href="<?= $site['themePath']?>css/uikit.css" />
      <link rel="stylesheet" href="<?= $site['themePath']?>css/common.css" />
      <!-- UIkit JS -->
      <script src="<?= $site['themePath']?>js/uikit.min.js"></script>
      <script src="<?= $site['themePath']?>js/uikit-icons.min.js"></script>
      <style>
         *{
         box-sizing: border-box;
         font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif
         }
         html, body{
         height: 100%;
         width: 100%;
         /*background-color: var(--color-secondary);*/
         background-size: cover;
         background-position: center;
         }
      </style>
   </head>
   <body class="">
      <!DOCTYPE html>
      <html lang="en">
         <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Oriental English Academy</title>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script type="text/javascript" src="<? echo $site['url-library']?>wtos-1.1.js"></script>
            <!-- UIkit CSS -->
            <link rel="stylesheet" href="<?= $site['themePath']?>css/uikit.css" />
            <link rel="stylesheet" href="<?= $site['themePath']?>css/common.css" />
            <!-- UIkit JS -->
            <script src="<?= $site['themePath']?>js/uikit.min.js"></script>
            <script src="<?= $site['themePath']?>js/uikit-icons.min.js"></script>
         </head>
         <body class="">
            <div class="formDiv">
               <table width="100%" border="0" cellspacing="1" cellpadding="1" class="uk-table">
                  <tr >
                     <td>
                        <span>Branch</span>
                        <select name="branch_name" id="branch_name" class="textbox fWidth uk-select" >
                           <option value="">Select Branch</option>
                           <? 
                              $os->onlyOption($os->branch_name);  ?>
                        </select>
                     </td>
                     <td>
                        <span>Full name </span>
                        <input value="" type="text" name="full_name" id="full_name" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Short name </span>
                        <input value="" type="text" name="short_name" id="short_name" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Contact no </span>
                        <input value="" type="text" name="contact_no" id="contact_no" class="textboxxx  fWidth uk-input "/> 
                     </td>
                  </tr>
                  <tr >
                     <td>
                        <span>Dob </span>
                        <input value="" type="text" name="dob" id="dob" class="wtDateClass textbox fWidth uk-input"/>
                     </td>
                     <td>
                        <span>Designation </span>
                        <input value="" type="text" name="designation" id="designation" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Type </span>
                        <select name="type" id="type" class="textbox fWidth uk-select" >
                           <option value="">Select Type</option>
                           <? 
                              $os->onlyOption($os->employee_type);   ?>
                        </select>
                     </td>
                     <td>
                        <span>Main subject </span>
                        <input value="" type="text" name="main_subject" id="main_subject" class="textboxxx  fWidth uk-input "/> 
                     </td>
                  </tr>
                  <tr >
                     <td>
                        <span>Others subject </span>
                        <input value="" type="text" name="others_subject" id="others_subject" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Date of joining </span>
                        <input value="" type="text" name="date_of_joining" id="date_of_joining" class="wtDateClass textbox fWidth uk-input"/>
                     </td>
                     <td>
                        <span>Previous institute </span>
                        <input value="" type="text" name="previous_institute" id="previous_institute" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Educational qualification </span>
                        <input value="" type="text" name="educational_qualification" id="educational_qualification" class="textboxxx  fWidth uk-input "/> 
                     </td>
                  </tr>
                  <tr >
                     <td>
                        <span>Fathers mothers name </span>
                        <input value="" type="text" name="fathers_mothers_name" id="fathers_mothers_name" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Language </span>
                        <select name="language" id="language" class="textbox fWidth uk-select" >
                           <option value="">Select Language</option>
                           <? 
                              $os->onlyOption($os->emp_language); ?>
                        </select>
                     </td>
                     <td>
                        <span>Nationality </span>
                        <input value="" type="text" name="nationality" id="nationality" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Correspondent address </span>
                        <input value="" type="text" name="correspondent_address" id="correspondent_address" class="textboxxx  fWidth uk-input "/> 
                     </td>
                  </tr>
                  <tr >
                     <td>
                        <span>Permanent address </span>
                        <input value="" type="text" name="permanent_address" id="permanent_address" class="textboxxx  fWidth uk-input "/> 
                     </td>
                     <td>
                        <span>Blood group </span>
                        <select name="blood_group" id="blood_group" class="textbox fWidth uk-select" >
                           <option value="">Select Blood group</option>
                           <? 
                              $os->onlyOption($os->blood_group);  ?>
                        </select>
                     </td>
                     <td><span>Bank details </span><input value="" type="text" name="bank_details" id="bank_details" class="textboxxx  fWidth uk-input "/> </td>
                     <td>
                        <span>Image </span>
                        <img id="imagePreview" src="" height="100" style="display:none;"   />      
                        <input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
                        <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>
                     </td>
                  </tr>
               </table>
               <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />               
               <input type="hidden"  id="employee_id" value="0" />   
               <input type="hidden"  id="WT_employeepagingPageno" value="1" />   
               <div class="formDivButton"> 
                  &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" class="uk-button uk-button-primary uk-width-expand" onclick="WT_employeeEditAndSave();" /><? } ?>  
               </div>
            </div>
            <script>
               function WT_employeeEditAndSave(){               
               	var formdata = new FormData();
               	var full_nameVal= os.getVal('full_name'); 
               	var short_nameVal= os.getVal('short_name'); 
               	var contact_noVal= os.getVal('contact_no'); 
               	var dobVal= os.getVal('dob'); 
               	var designationVal= os.getVal('designation'); 
               	var typeVal= os.getVal('type'); 
               	var main_subjectVal= os.getVal('main_subject'); 
               	var others_subjectVal= os.getVal('others_subject'); 
               	var date_of_joiningVal= os.getVal('date_of_joining'); 
               	var previous_instituteVal= os.getVal('previous_institute'); 
               	var educational_qualificationVal= os.getVal('educational_qualification'); 
               	var fathers_mothers_nameVal= os.getVal('fathers_mothers_name'); 
               	var languageVal= os.getVal('language'); 
               	var nationalityVal= os.getVal('nationality'); 
               	var correspondent_addressVal= os.getVal('correspondent_address'); 
               	var permanent_addressVal= os.getVal('permanent_address'); 
               	var blood_groupVal= os.getVal('blood_group'); 
               	var bank_detailsVal= os.getVal('bank_details'); 
               	var imageVal= os.getObj('image').files[0]; 
               	var branch_name= os.getVal('branch_name'); 
               
               	formdata.append('branch_name',branch_name);
               
               	formdata.append('full_name',full_nameVal );
               	formdata.append('short_name',short_nameVal );
               	formdata.append('contact_no',contact_noVal );
               	formdata.append('dob',dobVal );
               	formdata.append('designation',designationVal );
               	formdata.append('type',typeVal );
               	formdata.append('main_subject',main_subjectVal );
               	formdata.append('others_subject',others_subjectVal );
               	formdata.append('date_of_joining',date_of_joiningVal );
               	formdata.append('previous_institute',previous_instituteVal );
               	formdata.append('educational_qualification',educational_qualificationVal );
               	formdata.append('fathers_mothers_name',fathers_mothers_nameVal );
               	formdata.append('language',languageVal );
               	formdata.append('nationality',nationalityVal );
               	formdata.append('correspondent_address',correspondent_addressVal );
               	formdata.append('permanent_address',permanent_addressVal );
               	formdata.append('blood_group',blood_groupVal );
               	formdata.append('bank_details',bank_detailsVal );
               	if(imageVal){  formdata.append('image',imageVal,imageVal.name );}	
               	if(os.check.empty('full_name','Please Add Full name')==false){ return false;} 
                  if(os.check.empty('contact_no','Please Add Contact no')==false){ return false;} 

               
               	var   employee_id=os.getVal('employee_id');
               	formdata.append('employee_id',employee_id );
               	var url='<? echo $ajaxFilePath ?>?WT_employeeEditAndSave=OK&';
               	// os.animateMe.div='div_busy';
               	os.animateMe.html='<div class="loadImage"><div class="loadText">&nbsp;Please wait. Working...</div></div>';	
               	os.setAjaxFunc('WT_employeeReLoadList',url,formdata);
               
               }	
               
               function WT_employeeReLoadList(data){
               	var d=data.split('#-#');
               	var employee_id=parseInt(d[0]);
               	if(d[0]!='Error' && employee_id>0){
               		os.setVal('employee_id',employee_id);
               	}	
               	if(d[1]!=''){alert(d[1]);}
                  location.reload();
               }
            </script>
         </body>
      </html>