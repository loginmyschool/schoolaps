<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');


$certificate_type= $os->get('certificate_type');
$historyIds = $os->get('historyId');

if($historyIds!='')
{
$historyIds_arr=explode(',',$historyIds);
$historyIds_arr=array_filter($historyIds_arr);
}
$history_id_str=implode(',',$historyIds_arr);

$certificate_template_body= $os->rowByField('text_content','certificate_template','content_type',$certificate_type," and type='Body' and status='active'  ");
 ////  data
 //$query_in_studentId="SELECT h.studentId FROM `history` h where  h.historyId IN ($history_id_str)";
 $query="SELECT h.* , s.* FROM `history` h 
        LEFT JOIN student s on h.studentId=s.studentId		
		where    h.historyId IN ($history_id_str) ";
 $rsResults=$os->mq($query);



 ////  data

function student_info_block_design($data)
{
global $os, $site;



  $os->startOB();?>
<!-- -->

<table style="width:100%"   >
 <tr>
 <td style="width:70%">
 <table style="width:100%"  >
 <tr>
    <td style="width:100px;"  > Name:  </td>
    <td><? echo $data['name'];  ?>  </td>
  </tr>




  <tr>
    <td  > Class:  </td>
    <td><? echo $os->classList[$data['class']];  ?> <? echo $data['asession'];  ?></td>
  </tr>
  <tr>
    <td>Sec Roll</td>
    <td><? echo $data['section'];  ?>  <? echo $data['roll_no'];  ?></td>
  </tr>
</table>

</td>

    <td  style="text-align:center" > <img src="<? echo $site['url'];  ?><? echo $data['image'];  ?>" style="height:70px;" >  <br>
	<img src="<? echo $os->student_barcode_href($data['studentId']);  ?>" style="height:20px;" > </td>
  </tr>
</table >


 <?
  $student_info_block= $os->getOB();
 return  $student_info_block;
}

function getStudentDataval($data)
{
//_d($data);

global $os;
$template_keys=array();
        $template_keys['...NAME...']=$os->val($data,'name');

		    $template_keys['...SON-DOT...']='son';
			$template_keys['...HIS-HER...'] ='his';
			$template_keys['...HE-SHE...']='He';

		if($data['gender']=='Female')
		{
			$template_keys['...SON-DOT...']='daughter';
			$template_keys['...HIS-HER...'] ='her';
			$template_keys['...HE-SHE...']='She';
		}
		$template_keys['...FATHERNAME...'] =$os->val($data,'father_name');

		 $template_keys['...YEAR...'] =$os->val($data,'asession');

		 $class=$os->val($data,'class');
		 $template_keys['...CLASS...']=$os->classList[$class];
		 $template_keys['...DOB...'] =$os->showDate($os->val($data,'dob'));

		 $template_keys['...ADMISSION_NO...'] ='';
		 $template_keys['...STUDENT_ID...'] =$os->val($data,'studentId');
		 $template_keys['...ADDRESS...'] =$os->val($data,'vill').' ' .$os->val($data,'po').' ' .$os->val($data,'ps').' ' .$os->val($data,'dist').' ' .$os->val($data,'state').' '  ;


         $cy=date('Y');
		  $template_keys['...IS-WAS...'] ='is';
		 if($data['asession']<$cy)
		 {
		    $template_keys['...IS-WAS...'] ='was';
		 }
		/*$template_keys['...INPUT_1...']=$certificate_data['text_line_1'];
		$template_keys['...INPUT_2...']=$certificate_data['text_line_2'];
		$template_keys['...INPUT_3...']=$certificate_data['text_line_3'];
		$template_keys['...INPUT_4...']=$certificate_data['text_line_4'];
		$template_keys['...INPUT_5...']=$certificate_data['text_line_5'];
		$template_keys['...INPUT_6...']=$certificate_data['text_line_6'];*/

  return $template_keys;

}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Icard </title>


</head>

<body>

<div style="width:780px; margin-top:10px; text-align:center;" id="printBtn">
<input type="checkbox" value="1" name="print_head" checked="checked" > Header & Footer &nbsp;  &nbsp;
<input type="button" onClick="printPage()" value="Print" />
</div>
<div class="admin_print_block">

<?
         include('templateClass.php');
		 $template_class=new templateClass();

		while($record=$os->mfa( $rsResults))
         {

		  $studentvalues=array();
		  $key_data = getStudentDataval($record);
		  $certificate_template_body_replaced=$os->replace_template_value($key_data,$certificate_template_body);

		  $certificate_data=array();

		   $certificate_data['__certificate_head__']=strtoupper($certificate_type)." CERTIFICATE";
		  $certificate_data['__headerdisplay_']='';
		  $certificate_data['__footerdisplay_']='';

		   $certificate_data['__student_info_block__']=student_info_block_design($record);
		   $certificate_data['__certificatebody__']=$certificate_template_body_replaced;

		 ?>   <div style="padding:5px;  width:100%; height:100%;">
		  <? echo  $template_class->render_certificate($certificate_data);  ?>
		  </div>
		<? }
?>
<div class="cler"></div>

</div>
  <script>
	function printPage(){
		document.getElementById("printBtn").style.display="none";
		window.print();
		document.getElementById("printBtn").style.display="block";
	}

</script>

</body>
</html>
