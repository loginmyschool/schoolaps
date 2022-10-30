<?php 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$student_certificate_id = $_GET['student_certificate_id'];
 if($student_certificate_id<1){ exit;}
$certificate_data= $os->rowByField('','student_certificate','student_certificate_id',$student_certificate_id);
   
$print_header=$certificate_data['print_header'];
 
 
 
$certificate_template_id=$certificate_data['certificate_template_id'];
$template_str= $os->rowByField('text_content','certificate_template','certificate_template_id',$certificate_template_id);

$template_content=$certificate_data['template_content'];
$template_data_keys=json_decode($template_content,true);
$template_keys=json_decode($template_content,true);


// get template data
		$studentId=$certificate_data['studentId'];
		$historyId=$certificate_data['historyId'];
		$student= $os->rowByField('','student','studentId',$studentId);
		$history= $os->rowByField('','history','historyId',$historyId);
		  
		$template_keys['[#-NAME-#]']=$student['name'];
		if($student['gender']=='Female')
		{
			$template_keys['[#-SON-DOT-#]']='daughter';
			$template_keys['[#-HIS-HER-#]'] ='her';
			$template_keys['[#-HE-SHE-#]']='She';
		}
		$template_keys['[#-FATHERNAME-#]'] =$student['father_name'];
         
		 $template_keys['[#-YEAR-#]'] =$history['asession'];
		 $template_keys['[#-CLASS-#]']=$history['class'];
		 $template_keys['[#-DOB-#]'] =$os->showDate($student['dob']);
		
		 $template_keys['[#-ADMISSION_NO-#]'] ='';
		 $template_keys['[#-STUDENT_ID-#]'] =$student['studentId'];
      
         $cy=date('Y');
		 if($history['asession']<$cy)
		 {
		    $template_keys['[#-IS-WAS-#]'] ='was';
		 }
		 
		 
		 $template_keys['[#-INPUT_1-#]']=$certificate_data['text_line_1'];
$template_keys['[#-INPUT_2-#]']=$certificate_data['text_line_2'];
$template_keys['[#-INPUT_3-#]']=$certificate_data['text_line_3'];
$template_keys['[#-INPUT_4-#]']=$certificate_data['text_line_4'];
$template_keys['[#-INPUT_5-#]']=$certificate_data['text_line_5'];
$template_keys['[#-INPUT_6-#]']=$certificate_data['text_line_6'];
 
 
		 
$template_data_keys['[#-INPUT_1-#]']=$certificate_data['text_line_1'];
$template_data_keys['[#-INPUT_2-#]']=$certificate_data['text_line_2'];
$template_data_keys['[#-INPUT_3-#]']=$certificate_data['text_line_3'];
$template_data_keys['[#-INPUT_4-#]']=$certificate_data['text_line_4'];
$template_data_keys['[#-INPUT_5-#]']=$certificate_data['text_line_5'];
$template_data_keys['[#-INPUT_6-#]']=$certificate_data['text_line_6'];
 


//_d($certificate_data);

$content_replaced=$os->replace_template_value($template_keys,$template_str);
 

//_d($template_data_keys);
$template_header_str= $os->rowByField('text_content','certificate_template','type','Header');
$template_footer_str= $os->rowByField('text_content','certificate_template','type','Footer');

 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Certificate</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,300i,400,400i,500,500i,700,900" rel="stylesheet"/>
   
</head>

<body>
<div style="width:780px; margin-top:10px; text-align:center;" id="printBtn"><input type="button" onclick="printPage()" value="Print" />
</div>
<div class="admin_print_block">
<? if($print_header){ ?>

 <div class="header_template">
 <? echo $template_header_str; ?>
 </div>
<?  } ?>
 <div class="body_template">
  <? echo nl2br($content_replaced); ?>
  
  </div>
  <div class="footer_template">
 <? echo $template_footer_str; ?>
 </div>

</div>
  <script>
	function printPage(){
		document.getElementById("printBtn").style.display="none";
		window.print();
		document.getElementById("printBtn").style.display="block";
	}
	
</script>
<style>
.header_template{ padding:10px; text-align:center; margin-bottom:10px; border:1px solid #0033CC;}
.footer_template{ padding:10px; text-align:center; margin-bottom:10px; border:1px solid #0033CC;}
.body_template{ padding:10px; text-align:center; margin-bottom:10px; border:1px solid #0033CC;}
</style>

</body>
</html>
