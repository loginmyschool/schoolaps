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

if($os->get('manage_hostel_room_bed')=='OK' && $os->post('manage_hostel_room_bed')=='OK')
{





    $room_name=$os->post('room_name');

    $bed_list=$os->post('bed_list');
    $floor_name=$os->post('floor_name');
    $building_name=$os->post('building_name');




    $button=$os->post('button');



    if( $room_name!='' && $floor_name!='' && $building_name!='' && $button=='save' )
    {


        $bed_listA=array_filter(explode(',',$bed_list));
        $room_nameA=array_filter(explode(',',$room_name));



        foreach($room_nameA as $key=> $room)
        {
            $bed=$bed_listA[$key];

            $dataToSave=array();
            $dataToSave['room_name']=$room;
            $dataToSave['bed_list']=$bed;
            $dataToSave['floor_name']=$floor_name;
            $dataToSave['building_name']=$building_name;


            $dataToSave['addedDate']=$os->now();
            $dataToSave['addedBy']=$os->userDetails['adminId'];



            $duplicate_query="select * from hostel_room where room_name!='' and room_name='$room'  
					and  floor_name='$floor_name'     and  building_name='$building_name' ";
            $hostel_room_id=$os->isRecordExist($duplicate_query,'hostel_room_id');
            $qResult=$os->save('hostel_room',$dataToSave,'hostel_room_id',$hostel_room_id);///    allowed char '\*#@/"~$^.,()|+_-=:��

        }


    }



    $config_array=array();
    $sel="select * from hostel_room where room_name!='' ";
    $resset=$os->mq($sel);
    $cc=0;
    while($record=$os->mfa($resset))
    {
        $cc++;
        $config_array[$record['building_name']][$record['floor_name']][$cc]=$record;
    }

    /*$y=date('Y');
    $bed_occ_by_stu="select hostel_room_id , bed_no from history  where asession= '$y' and bed_no>0 ";
    $beddetailsrs=$os->mq($bed_occ_by_stu);
    while($beddetails=$os->mfa($beddetailsrs))
    {
       $key=$beddetails['hostel_room_id']."-".$beddetails['bed_no'];
       $beddetails_array[$key]=$key;
    }
    */







    echo '##--HOSTEL-ROOM--##';
    $y=date('Y');
    $bed_occ_by_stu="select h.hostel_room_id , h.bed_no , s.name , s.image , s.studentId , s.studentId,h.class  from  history h, student s  where s.studentId=h.studentId and h.asession= '$y' and h.bed_no>0 ";
    $beddetailsrs=$os->mq($bed_occ_by_stu);
    while($beddetails=$os->mfa($beddetailsrs))
    {
        $key=$beddetails['hostel_room_id']."-".$beddetails['bed_no'];
        $beddetails_array[$key]=$beddetails;
    }


    ?>
    <?
    foreach( $config_array as $building_name=>$floors  )
    {
        ?>

        <div class="class_subject">
            <div class="uk-padding-small background-color-secondary  uk-flex uk-flex-middle">
                <img src="<?= $site["url-wtos"]."images/building.svg"?>" style="height: 25px"/>
                <span class="uk-margin-small-left text-l"><? echo   $building_name ?></span>
            </div>

            <ul class="background-color-white uk-margin-remove" uk-tab>
                <? foreach( $floors as  $floor_name=>$rooms ) {?>
                    <li><a href="#" style="text-transform: inherit"><? echo $floor_name ?></a></li>
                <? }?>
            </ul>
            <ul class="uk-switcher uk-margin-bottom border-xxs border-top-none border-color-white" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
                <? foreach( $floors as  $floor_name=>$rooms ) {?>
                    <li class="uk-padding-small text-none uk-child-width-1-4 uk-grid-small uk-grid-match" uk-grid="" style="font-size: 0px">

                            <?
                            $cc=1;
                            foreach( $rooms as  $rec )
                            {
                                $bed_list=explode('-',$rec['bed_list']);
                                $bedcount=	count($bed_list);
                                $width	= 32 * $bedcount/2;

                                if( $width<130){ $width=130;}
                                ?>

                                <div class="">
                                    <div class=" background-color-white text-m ">
                                        <div class="p-s border-none border-bottom-xxs" style="border-color: #e5e5e5"> <? echo $cc  ?>.  Room:    <? echo $rec['room_name']   ?>   </div>
                                        <div class="p-s">
                                            <div class="uk-grid uk-grid-collapse uk-child-width-1-5" uk-grid>
                                            <?
                                            foreach($bed_list as $bed_no)
                                            {
                                                $key_bed=$rec['hostel_room_id']."-".$bed_no;
                                                $bed_image='bed_empty.png';
                                                $beddetails_array_key=array_keys($beddetails_array);
                                                if(in_array($key_bed,$beddetails_array_key))
                                                {
                                                    $bed_image='bed_ocupied.png';
                                                }
                                                $student_data= $os->val($beddetails_array,$key_bed);
                                                ?>
                                                <div>
                                                    <div class="p-s uk-position-relative">


                                                        <div class="uk-text-center uk-link-reset uk-flex-center uk-background-muted hover-background-color-secondary pointable border-radius-xs p-xs">
                                                            <img src="<? echo $site['url-wtos'] ?>images/<? echo $bed_image ?>" class="uk-width-expand"/>
                                                            <div class="uk-text-center p-top-xs text-s"><? echo $bed_no ?></div>
                                                        </div>
                                                        <? if(in_array($key_bed,$beddetails_array_key)) {?>
                                                            <div style="z-index: 999999" class="bed_no_student uk-position-absolute" uk-drop>
                                                                <? if($student_data){ ?>
                                                                    <? if($student_data['image']){ ?>
                                                                        <img src="<? echo $site['url'] ?>/<? echo $student_data['image'] ?>" style="height:100px;" /><br />
                                                                    <? } ?>
                                                                    <b><? echo $student_data['name'] ?> </b><br />  Class: <? echo $student_data['class'] ?>   <br />
                                                                    Bed: <? echo $student_data['bed_no'] ?> <br />
                                                                    Student Id:<? echo $student_data['studentId'] ?>
                                                                <? }else {?>Vacant
                                                                <? } ?>
                                                            </div>
                                                        <?  } ?>
                                                    </div>
                                                </div>
                                            <? } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?
                                $cc++;
                            }
                            ?>

                    </li>
                <? } ?>
            </ul>
        </div>
        <?
    }







    echo '<div style="clear:both"> &nbsp;</div>';
    echo '##--HOSTEL-ROOM--##';

    exit();
}



