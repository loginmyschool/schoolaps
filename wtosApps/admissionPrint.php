<? global $os;
$formfillup_id = $_GET['formfillup_id'];
$print_type = $_GET['print_type']?$_GET['print_type']:'';
$Query="select * from formfillup where formfillup_id>0 and formfillup_id='$formfillup_id' "; 
$result=$os->mq($Query);
$record=$os->mfa($result);
$school_setting_q="select * from school_setting where school_setting_id>0 limit 1";
$school_setting_mq=$os->mq($school_setting_q);
$school_setting_data=$os->mfa($school_setting_mq);

 //_d($record);
?>
<?if($print_type){?>
   <script type="text/javascript">
      setTimeout( function(){ 
      $("header").hide();
      $("footer").hide();
      $("#print_form").hide();
      $("#download_pdf").hide();
   }  , 30);
   </script>
<?}?>
<div class="application_form" >
   <button type="button"  class="uk-button uk-button-primary" id="print_form" onclick="printById('forPrint');">Print</button>
   <button type="button" class="uk-button uk-button-danger" id="download_pdf"  href="javascript:void(0)">Download PDF</button>
   <div id="forPrint">
    <style>
         .confirmForm{ border:1px dotted #999999; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
         .confirmForm td{ border:1px dotted #999999; border-left:0px; border-top:0px; padding-left:4px; padding-top:2px; padding-bottom:2px;}
      </style>
	  <table   border="0" cellspacing="0" cellpadding="0" style="width:100%">
	  <tr> <td colspan="5">  <div style="text-align:center; font-style:italic; font-size:11px; padding:5px;">In the name of Allah, The Most Gracious and The Most Merciful.</div></td> </tr>
  <tr>
    <td style="width:120px"> <div style=" height:100px; width:100px; margin:auto">   <img src="<?php  echo $site['url'].$school_setting_data['logoimage']; ?>"  style="height: 100px; width: 100px" /> </div> </td>
    <td><div class="head">
	  
       

        <div style="font-size:25px; font-weight:bold; text-align:center; margin:0px">
            <div> <? echo $school_setting_data['school_name'];?>  </div>
                 <div style=" font-weight:normal; font-size:16px; margin:-6px 0px 0px 0px"><? echo $school_setting_data['address'];?></div>      
        </div>
		<div style="font-size:20px; font-weight:bold; text-align:center;">
           
                        <small>Admission Application  for Class :  <? echo $os->classList[$record['class_id']]?> - <? echo $record['academic_year']?></small> 
        </div>
        
         

     <div style="font-size:17px; font-weight:200; text-align:center; margin:auto; width:132px; border:1px solid #333333; border-radius:5px; margin-top:10px;">
      Form No. <b style="font-weight:bold"><? echo $record['formfillup_id']?>  </b>
     </div>
     

   
 </div></td>
    <td  style="width:120px"> <img src="<? echo $site['url'].$record['profile_picture']?>" width="100" height="130" style="border:7px #666666 solid;" /></td>
  </tr>
</table>

        <div style=" border-bottom:1px solid #000000; margin:10px 0px;">
 
        </div>
	   
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="confirmForm">
	  <tr> 
			   <td> Full Name</td>  <td> <b><? echo $record['name']?></b></td> 
			   <td>Application Date </td>  <td>  <b><? echo $os->showDate($record['form_fill_date'])?></b>  </td>  
	   </tr>
	   
	   
	    <tr> 
		       <td> Date of Birth</td>   <td> <b><? echo $os->showDate($record['dob'])?></b></td> 
			   <td> Contact No</td>  <td><b><? echo $record['mobile_student']?></b>  </td> 
			   
	   </tr>
	   
	   <tr> 
			   <td>Place of Birth </td>  <td><b><? echo $record['place_of_birth']?></b>  </td>  
			   <td>Academic Year </td>  <td><b><? echo $record['academic_year']?></b>  </td>   
	   </tr>
	    <tr> 
			   <td>Gender </td>  <td><b><? echo $record['gender']?></b> </td> 
			    <td>Class Id </td>  <td><b><? echo $record['class_id']?></b>  </td>   
			   
	   </tr>
	   
	    <tr> 
			    <td>Caste </td>  <td><b><? echo $record['caste']?></b> </td> 
				 <td>Aadhaar Number </td>  <td><b><? echo $record['aadhaar_number']?></b>  </td>   
			   
	   </tr>
	   
	   <tr> 
			    <td>Religion </td>  <td><b><? echo $record['Religion']?></b> </td> 
				 <td>Physically Challanged </td>  <td><b><? echo $record['physically_challanged']?></b>  </td>   
			   
	   </tr>
	   
	   <tr> 
			    <td>Caste </td>  <td><b><? echo $record['caste']?></b> </td> 
				 <td>Blood Group </td>  <td><b><? echo $record['blood_group']?></b>  </td>   
			   
	   </tr>
	   
	   <tr> 
			    <td> -- </td>  <td>-- </td> 
				 <td>Branch Id </td>  <td><b><? echo $record['branch_id']?></b>  </td>   
			   
	   </tr>
	   
	   
	   
	   
	   <tr>      
				 
				
				
     
    
			   <td> </td>  <td> </td>  
			   <td> </td>  <td> </td>  
	   </tr> 
	   <table width="99%" border="0" cellspacing="0" class="confirmForm">                  
                  <tr>
                     <td>Father's Name : <b><? echo $record['father_name']?></b></td>
                     <td>Father's Mobile No : <b><? echo $record['father_mobile']?></b></td>
                     <td colspan="2">Father's Occupation : <b><? echo $record['father_ocu']?></b></td>
                  </tr>
               </table>
	  
	  
	  </table>
	 
	 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="confirmForm">
          
             
            <td > :   &nbsp; &nbsp;  : </td>
         </tr>
         <tr>
            <td>Full Name</td>
            <td></td>
         </tr>
         <tr>
            <td></td>
            <td> </td>
         </tr>
         <tr>
            <td></td>
            <td> </td>
         </tr>
         <tr>
            <td></td>
            <td> <b><? echo $record['caste']?></b></td>
         </tr>
         <tr>
            <td>Student Type</td>
            <td><b><? echo $record['student_type']?></b></td>
         </tr>
         <tr>
            <td colspan="2">
               <b>Father's Details</b><br />
               
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <b>Mother's Details</b><br />
               <table width="99%" border="0" cellspacing="0" class="confirmForm">                  
                  <tr>
                     <td>Mother's Name : <b><? echo $record['mother_name']?></b></td>
                     <td>Mother's Mobile No : <b><? echo $record['mother_mobile']?></b></td>
                     <td colspan="2">Mother's Occupation : <b><? echo $record['mother_occupation']?></b></td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <b>Guardian's Details</b><br />
               <table width="99%" border="0" cellspacing="0" class="confirmForm">                  
                  <tr>
                     <td>Guardian's Name : <b><? echo $record['guardian_name']?></b></td>
                     <td>Guardian's Mobile No : <b><? echo $record['guardian_mobile']?></b></td>
                     <td colspan="2">Guardian's Occupation : <b><? echo $record['guardian_occupation']?></b></td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <b>Permanent Address</b><br />
               <table width="99%" border="0" cellspacing="0" class="confirmForm">
                  <tr>
                     <td width="200">Village</td>
                     <td width="210"><b><? echo $record['permanent_village']?></b></td>
                     <td width="100">Post Office</td>
                     <td><b><? echo $record['permanent_post_office']?></b></td>
                  </tr>
                  <tr>
                     <td>Block/ Municipality</td>
                     <td><b><? echo $record['permanent_block']?></b></td>
                     <td>Police Station</td>
                     <td><b><? echo $record['permanent_police_station']?></b></td>
                  </tr>
                  <tr>
                     <td>District</td>
                     <td><b><? echo $record['permanent_district']?></b></td>
                     <td>State</td>
                     <td><b><? echo $record['permanent_state']?></b> &nbsp;      Pin:<b><? echo $record['permanent_pincode']?></b></td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <b>Present Address</b><br />
               <table width="99%" border="0" cellspacing="0" class="confirmForm">
                  <tr>
                     <td width="200">Village</td>
                     <td width="210"><b><? echo $record['vill']?></b></td>
                     <td width="100">Post Office</td>
                     <td><b><? echo $record['po']?></b></td>
                  </tr>
                  <tr>
                     <td>Block/ Municipality</td>
                     <td><b><? echo $record['block']?></b></td>
                     <td>Police Station</td>
                     <td><b><? echo $record['ps']?></b></td>
                  </tr>
                  <tr>
                     <td>District</td>
                     <td><b><? echo $record['dist']?></b></td>
                     <td>State</td>
                     <td><b><? echo $record['state']?></b>  &nbsp;   Pin:<b><? echo $record['pin']?></b> </td>
                  </tr>
               </table>
            </td>
         </tr>         
         <tr>
            <td valign="top"><b>10th Std. </b> <br />
               Name of Board: <b><? echo $record['ten_name_of_board']?></b>   <br /> Year of Passing: <b><? echo $record['ten_passed_year']?></b>
            </td><td>  <br />
               Total Marks obt: <b><? echo $record['ten_marks_total_obt']?></b>  <br /> Percentage(%): <b><? echo $record['ten_marks_percent']?></b> 
               <br />
            </td>
         </tr>
         <tr>
            <td valign="top" ><b>12th Std. </b> <br />
               Name of Board: <b><? echo $record['twelve_name_of_board']?></b>  <br/> Year of Passing: <b><? echo $record['twelve_passed_year']?></b></td>
               <td> <br />
                  Total Marks obt: <b><? echo $record['twelve_marks_total_obt']?></b><br/>  Percentage(%): <b><? echo $record['twelve_marks_percent']?></b> 
               </td>
            </tr>
            <tr style="display: none;">
               <td valign="top"><b>Graduate level. </b> <br />
                  Name of Board: <b><? echo $record['graduate_passed_university']?></b>   <br /> Year of Passing: <b><? echo $record['graduate_passed_year']?></b>  </td><td><br />
                     Total Marks obt: <b><? echo $record['graduate_total_obt']?></b>  <br /> Percentage(%): <b><? echo $record['graduate_percent']?></b> 
                     <br />
                  </td>
               </tr>
               <tr>
                  <td colspan="3">
                     <b>Uploaded Documents :</b>
                     <?
                     $form_doc_q="select * FROM `formfillup_document` where formfillup_id='".$record['formfillup_id']."'";
                     $form_doc_mq=$os->mq($form_doc_q);
                     ?>
                     <ul>
                        <?while($form_doc_mfa=$os->mfa($form_doc_mq)){?>
                           <li><? echo $form_doc_mfa['title']?></li>
                        <?}?> 
                     </ul>
                  </td>
               </tr>
               <tr>
                  <td colspan="3">
                     I do hereby declare that : <br />
                     i) all the statements made in this application are true and correct. 
                  </td>
               </tr>
            </table>
         </div>
      </div>