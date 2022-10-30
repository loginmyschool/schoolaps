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

if($os->get('manage_vehivle_setting')=='OK' && $os->post('manage_vehivle_setting')=='OK')
{



    $asession=$os->post('asession');

    $vehicle_type=$os->post('vehicle_type');
    $vehicle_distance=$os->post('vehicle_distance');
    $vehicle_price=$os->post('vehicle_price');

    $classList=$os->post('classList');


    $button=$os->post('button');



    if( $classList!='' && $vehicle_price!='' && $asession!='' && $button=='save' )
    {


        $subject_listA=array_filter(explode(',',$subject_list));
        $classListA=array_filter(explode(',',$classList));



        foreach($classListA as $class_val)
        {


            $dataToSave=array();
            $dataToSave['class_id']=$class_val;
            $dataToSave['vehicle_type']=$vehicle_type;
            $dataToSave['vehicle_distance']=$vehicle_distance;
            $dataToSave['vehicle_price']=$vehicle_price;

            $dataToSave['asession']=$asession;
            $dataToSave['addedDate']=$os->now();
            $dataToSave['addedBy']=$os->userDetails['adminId'];



            $duplicate_query="select * from vehicle_config where class_id!='' and class_id='$class_val'  
					and  asession='$asession'     and  vehicle_type='$vehicle_type' and  vehicle_distance='$vehicle_distance' ";
            $vehicle_config_id=$os->isRecordExist($duplicate_query,'vehicle_config_id');
            $qResult=$os->save('vehicle_config',$dataToSave,'vehicle_config_id',$vehicle_config_id);///    allowed char '\*#@/"~$^.,()|+_-=:��




        }


    }


    $classList_s=$os->post('classList_s');

    $andClass='';
    if($classList_s!='')
    {
        $andClass=" and class_id='$classList_s'";

    }

    $config_array=array();
    $sel="select * from vehicle_config where class_id!=''   $andClass  and  asession='$asession'";
    $resset=$os->mq($sel);
    $cc=0;
    while($record=$os->mfa($resset))
    {
        $cc++;
        $config_array[$record['class_id']][$record['vehicle_type']][$cc]=$record;
    }



    echo '##--vehivle-SETTING-DATA--##';
    //_d($config_array);
    //_d($config_array);?>
    <h2>List of Vehicle selected for the classes </h2>
    <div class="uk-margin uk-grd uk-child-width-1-5 uk-grid-small" uk-grid>
        <?
        foreach( $config_array as $classId_val=>$vehicle_type  )

        {
            ?>
            <div>
                <div class="uk-card uk-card-default uk-card-small">
                    <div class="uk-card-header"> Class <?php echo $os->classList[$classId_val] ?> </div>

                    <div>


                        <?
                        foreach( $vehicle_type as  $row )
                        {
                            $cc=1;

                            ?>

                            <div>
                            <table class="uk-table uk-table-small uk-table-striped">
                                <?
                                foreach( $row as  $rec )
                                {
                                    ?>

                                    <tr>
                                        <td class="p-left-xl"><?php echo $cc  ?> . <?php echo $rec['vehicle_type']?></td>
                                        <td>
                                            <span style=" color:#CA00CA" >
                                                <?php echo $rec['vehicle_distance'] ?>
                                            </span>
                                        </td>
                                        <td class="p-right-xl">
                                            <?php echo $rec['vehicle_price']  ?>
                                        </td>
                                    </tr>

                                    <?
                                    $cc++;
                                }
                                ?>
                            </table>
                            </div>
                        <?} ?>

                    </div>
                </div>
            </div>
        <?}?>
    </div>
    <?

    echo '##--vehivle-SETTING-DATA--##';

    exit();
}



