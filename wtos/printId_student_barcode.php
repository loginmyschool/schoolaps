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
// echo $historyIds;
$students_res = $os->mq(
    "SELECT DISTINCT *   ,student.name FROM history
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
	<style>
                html, body {
                    margin:     0;
                    padding:    0;
                }

                /* Printable area */
                #print-area {
                    position:   relative;
                    top:        0cm;
                    left:       0cm;
                }
                table td{
                    background-color: white;

                }
            </style>

</head>

<body>
<div style="width:100%; padding:15px;text-align:center;" id="printBtn">
    <input type="button" onclick="printPage()" value="Print" />
</div>
<div class="admin_print_block" style=" font-size:12px; ">


</div>


<div id="print-area">
            <div id="content">
                <table style="width: 100%">
                    <tr>
                        <?
                        $col_count = 0;
                        //foreach ($items as $record){
                         while($student = $os->mfa($students_res)){

                            if($col_count%4==0){
                                print "</tr><tr>";
                                $col_count=0;
                            }



                            ?>
                            <td style=" border: 1px dashed #ccc; text-align: center; padding: 25px 15px 15px; width:25%;">
                                <div class="" style="width: 100%;">

                                    <?
                                    $code = generate_code($student["registrationNo"]);
                                    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                    try {?>
                                        <? echo $student["name"]; ?>
                                        <img style="width: 80%; height: 45px" src="data:image/png;base64, <?=base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128)) ?>">

                                        <?
                                    } catch (\Picqer\Barcode\Exceptions\BarcodeException $e) {
                                        print($e->getMessage());
                                    }
                                    ?>
                                    <div style="text-align: center; margin-top: 3px; font-size: 15px; letter-spacing: 0.40rem">
                                        <?= $code?>
                                    </div>

                                </div>
                            </td>
                            <?
                            $col_count++;
                        }

						if($col_count<4)
						{
						         $k= 4 - $col_count;

									  for($j= 0; $j<$k ; $j++)
									  {
									  ?>

									   <td style=" border: 1px dashed #ccc; text-align: center; padding: 25px 15px 15px;width:25%;"> </td>

									  <?

									  }


						}





                        ?>
                    </tr>
                </table>

            </div>
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
