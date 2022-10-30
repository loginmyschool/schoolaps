<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

if($os->get('manage_fees_setting')=='OK' && $os->post('fees_config')=='OK')
{

    $asession=$os->post('asession');

    $fees_type=$os->post('fees_type');
    $classList=$os->post('classList');
    $student_type=$os->post('student_type');

    $fees_head=$os->post('fees_head');
    $amount=$os->post('amount');
    $button=$os->post('button');
    // echo "   $fees_type \        $classList /         $student_type /  $fees_head / $amount  /$asession";

    if($fees_type!='' && $classList!='' && $student_type!='' && $fees_head!='' && $amount!='' && $asession!='' && $button=='save' )
    {


        $fees_typeA=array_filter(explode(',',$fees_type));
        $classListA=array_filter(explode(',',$classList));
        $student_typeA=array_filter(explode(',',$student_type));



        foreach($classListA as $class_val)
        {
            foreach($fees_typeA as $fees_type_val)
            {
                foreach($student_typeA as $student_type_val)
                {

                    $dataToSave=array();
                    $dataToSave['classId']=$class_val;
                    $dataToSave['accademicsessionId']=$asession;
                    $dataToSave['student_type']=$student_type_val;
                    $dataToSave['feesType']=$fees_type_val;

                    $dataToSave['feesHead']=$fees_head;
                    $dataToSave['amount']=$amount;


                    $dataToSave['addedDate']=$os->now();
                    $dataToSave['addedBy']=$os->userDetails['adminId'];


                    $qResult=$os->save('feesconfig',$dataToSave,'feesconfigId','');///    allowed char '\*#@/"~$^.,()|+_-=:��

                }
            }
        }
    }




    $classList_s=$os->post('classList_s');


    $config_array=array();
    $sel="select * from feesconfig where  classId='$classList_s' and  accademicsessionId='$asession'";
    $resset=$os->mq($sel);

    while($record=$os->mfa($resset))
    {
        $config_array[$record['classId']][$record['student_type']][$record['feesType']][$record['feesHead']]=$record['amount'];
    }

    echo '##--FEES-SETTING-DATA--##';
    foreach( $config_array as $classId_val=>$student_type_arr  )

    {

        foreach( $student_type_arr as $student_type_val=>$feesType_arr  )

        {
            ?>
            <div class="uk-margin uk-margin-small-right uk-margin-small-left">
                <h2 class="uk-margin-small"> <?=$student_type_val?></h2>
                <div class="uk-margin-small uk-grid uk-grid-small uk-child-width-1-3" uk-grid>
                    <? foreach( $feesType_arr as $feesType_val=>$feesHead_arr  ) {?>
                        <div>
                            <div  class="uk-card uk-card-small uk-card-default">

                                <div class="uk-card-header">
                                    <h3 class="text-l"><? echo $feesType_val ?></h3>
                                </div>
                                <div>
                                    <table class="uk-table uk-table-small uk-table-divider ">
                                        <?
                                        $total=0;
                                        $k=0;
                                        foreach($feesHead_arr as $head=>$amount){ $k++;?>

                                            <tr>
                                                <td class="p-left-xl" width="10" ><? echo $k;?>  </td>
                                                <td align="left" style="width:70px;"> <? echo $head ?> </td>
                                                <td class="p-right-xl " align="right">  <? echo $amount ?>  </td>
                                            </tr>

                                            <?
                                            $total=$total+$amount;
                                        }
                                        ?>

                                        <tr>
                                            <td >  </td>
                                            <td   align="left"> Total</td>
                                            <td class="p-right-xl uk-text-success"  align="right"> <? echo $total; ?> </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
            <?

        }
    }

    echo '<div style="clear:both"> &nbsp;</div>';
    echo '##--FEES-SETTING-DATA--##';

    exit();
}
