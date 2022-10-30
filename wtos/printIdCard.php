<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
function generate_code( $str,$length=12){
    $itr = $length-strlen($str);
    for($c=0; $c<$itr;$c++){
        //$str = '0'.$str;
    }
    return $str;
}

$historyIds = $os->get('historyId');

if($historyIds!='')
{
    $historyIds_arr=explode(',',$historyIds);
    $historyIds_arr=array_filter($historyIds_arr);
}
$historyIds = implode(",", $historyIds_arr);
include('templateClass.php');
$template_class=new templateClass();
$students_res = $os->mq(
    "SELECT DISTINCT * FROM history
                LEFT JOIN student ON(student.studentId= history.studentId)
                WHERE history.historyId IN($historyIds)");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Icard </title>
    <style type="text/css">

        body{
            font-size: 0px;
        }
        .icard-wrapper{
            display: inline-block;
            padding: 2px;
        }

    </style>

</head>

<body>
<div style="width:100%; padding:15px;text-align:center;" id="printBtn">
    <input type="button" onclick="printPage()" value="Print" />
</div>
<div class="admin_print_block">

    <?
	
	
                                    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
									
    $counter = 1;
    while($student = $os->mfa($students_res))
    {
       // $data['__barcode__']=$os->student_barcode_href($student['studentId']);
	   $code = generate_code($student["registrationNo"]);
									
								 	$data['__barcode__']="data:image/png;base64, ".base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128));
	   
        $data['__Image__']=$site['url-image'].$student['profile_picture'];
		// $data['__Image__']=$site['url-image'].$student['image'];
        $data['__Name__']=$student['name'];
        $data['__roll__']=$student['roll_no'];
        $data['__class__']=$os->classList[$student['class']]." ".$student['section'] ." ".$student['asession'];
        $data['__DOB__']=$os->showDate($student['dob']);
        $data['__Father__']=$student['father_name'];
        $data['__Mother__']=$student['mother_name'];
        $data['__PhoneNo__']=$student['mobile_student'];
        $data['__Address__']=$student['vill'].' '.$student['po'].' '.$student['ps'].' '.$student['dist'].' '.$student['block'];
        $data=$template_class->manage_default_value($data);
        ?>
        <div class="icard-wrapper"><?=$template_class->render_icard($data,"");?></div>

       <?
    }
    ?>

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
