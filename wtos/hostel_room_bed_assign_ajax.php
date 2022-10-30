<?php


include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

if($os->get('fetch_students')=='OK' && $os->post('fetch_students')=='OK')
{
    $asession_s = $os->post("asession_s");
    $branch_code_s = $os->post("branch_code_s");
    $class_s = $os->post("class_s");
    $bed_allocated_s = $os->post("bed_allocated_s");
    $student_name_s = $os->post("student_name_s");
    $registration_no_s = $os->post("registration_no_s");

    $andWhere = "h.asession='$asession_s' AND s.name LIKE '%$student_name_s%' ";
    $andWhere.= "AND h.branch_code='$branch_code_s' ";
    if($class_s !="") {
        $andWhere .= "AND h.class='$class_s'";
    }

    if($registration_no_s !="") {
        $andWhere .= "AND s.registerNo='$registration_no_s'";
    }


    if($bed_allocated_s !==""){
        $andWhere .=" AND h.bed_id IS ".($bed_allocated_s==="yes"?"NOT":"")." NULL ";
    }

    $histories_query = $os->mq("SELECT h.*, s.*,hb.bed_id, hb.bed_number, hr.room_number, hf.floor_name, b.building_name FROM history h 
    INNER JOIN student s on h.studentId = s.studentId 
    LEFT JOIN hostel_bed hb on h.bed_id = hb.bed_id 
    LEFT JOIN hostel_room hr on hb.building_id = hr.building_id
    LEFT JOIN hostel_floor hf on hr.building_id = hf.building_id
    LEFT JOIN hostel_building b on hf.building_id = b.building_id
         WHERE  $andWhere GROUP BY h.historyId");
    $classHistories =[];
    while ($history = $os->mfa($histories_query)){
        $classHistories[$history["class"]][] =  $history;
    }
    foreach ($classHistories as $class=>$histories){
        ?>
        <h4>Class : <?= $os->classList[$class];?></h4>
        <div class="uk-margin-small">
            <?php foreach ($histories as $history){?>
                <div id="history-<?=$history["historyId"]?>"
                     hId="<?=$history["historyId"]?>"
                     name="<?=$history["name"]?>"
                     standard="<?=$history["class"]?>"
                     asession="<?=$history["asession"]?>"
                     image="<?=$history["image"]?>"
                     class="uk-card uk-card-default p-m uk-card-small  student-card <?= $history["bed_id"]>0?"allocated":""?>"
                    <?php if(!$history["bed_id"]>0){?>
                        draggable="true"
                        ondragstart="onStudentDragStart(event)"
                        ondragend="onStudentDragOver(event)"
                    <?php
                    }?>
                >
                    <h5><?= $history["name"]?></h5>
                    <div>
                        Class: <i><?=$os->classList[$history["class"]]?> - <?= $history["asession"]?></i>
                    </div>

                    <?php if($history["bed_id"]){?>
                        <span class="uk-text-small">
                            Bed No: <i><?= $history["bed_number"]?></i>,
                            Room No: <i><?= $history["room_number"]?></i>,
                            Floor: <i><?= $history["floor_name"]?></i>,
                            Building: <i><?= $history["building_name"]?></i>
                        </span>
                    <?php
                    }?>

                </div>
            <?php
            }?>
        </div>

        <?php

    }


    exit();
}

if($os->get('fetch_beds')=='OK' && $os->post('fetch_beds')=='OK')
{
    $asession_s = $os->post("asession_s");
    $branch_code_s = $os->post("branch_code_s");
    $bed_status_s = $os->post("bed_status_s");
    $building_id_s = $os->post("building_id_s");
    $class_s = $os->post("class_s");
    $student_name_s = $os->post("student_name_s");
    $registration_no_s = $os->post("registration_no_s");

    if($asession_s =="" || $branch_code_s ==""){
       exit();
    }


    $bed_where="1=1 ";
    if($building_id_s!="") $bed_where .= "AND hb.building_id='$building_id_s'";
    $bed_status_join = "LEFT JOIN history h ON h.bed_id=hb.bed_id ";

    switch ($bed_status_s){
        case "occupied":
        {
            $bed_status_join = "INNER JOIN history h ON h.bed_id=hb.bed_id ";
            if ($class_s != "") $bed_status_join .= "AND h.class='$class_s' ";
            if ($asession_s != "") $bed_status_join .= "AND h.asession='$asession_s' ";

            if ($registration_no_s != "") $bed_where .= " AND s.registerNo='$registration_no_s' ";
            if ($student_name_s != "") $bed_where .= "  AND s.name LIKE '%$student_name_s%' ";
            break;
        }
        case "vacant":
        {
            $bed_where .= " AND h.historyId IS NULL";
            break;
        }
        default:
        {
            if ($class_s != "") $bed_status_join .= "AND h.class='$class_s' ";
            if ($asession_s != "") $bed_status_join .= "AND h.asession='$asession_s' ";

            if ($registration_no_s != "") $bed_where .= " AND s.registerNo='$registration_no_s' ";
            if ($student_name_s != "") $bed_where .= "  AND s.name LIKE '%$student_name_s%' ";
        }

    }
    $bed_status_join .= "LEFT JOIN student s ON s.studentId=h.studentId";


    $beds_query = $os->mq("SELECT hb.*, 
       s.name, h.historyId, h.class, h.asession, s.image,
       IF(s.studentId, true,false) as is_occupied
       FROM hostel_bed hb $bed_status_join WHERE $bed_where");
    if(!$beds_query){
        echo "No beds are occupied";
        exit();
    }
    $beds = $beds_query->fetchAll();

    if(!sizeof($beds) > 0){
        echo "No beds are occupied";
        exit();
    }

    $room_ids = array_reduce($beds, function($all, $c){$all[$c["room_id"]] = $c["room_id"]; return $all;}, []);
    $rooms_query = $os->mq("SELECT * FROM hostel_room hr WHERE hr.room_id IN (".implode(",", $room_ids).")");
    $rooms = $rooms_query->fetchAll();

    $floor_ids = array_reduce($rooms, function($all, $c){$all[$c["floor_id"]] = $c["floor_id"];return $all;}, []);
    $floors_query = $os->mq("SELECT * FROM hostel_floor hf WHERE hf.floor_id IN (".implode(",", $floor_ids).")");
    $floors = $floors_query->fetchAll();

    $building_ids = array_reduce($floors, function($all, $c){$all[$c["building_id"]] = $c["building_id"];return $all;}, []);
    $buildings_query = $os->mq("SELECT * FROM hostel_building b WHERE b.building_id IN (".implode(",", $building_ids).")");
    $buildings = $buildings_query->fetchAll();

    foreach ($buildings as $hostel_building){
        ?>
        <div>
            <div class="p-s p-left-m uk-light" style="background-color: #0da50b">
                <h3>Building : <?= $hostel_building["building_name"]?></h3>
            </div>
            <div class="uk-margin-small">
                <?php
                $hostel_floors = array_filter($floors, function ($current) use ($hostel_building) {return $current["building_id"]===$hostel_building["building_id"];});
                foreach ($hostel_floors as $hostel_floor){?>
                    <div>
                        <h4>Floor <?= $hostel_floor["floor_name"]?></h4>
                        <?php
                        //room start
                        $hostel_rooms = array_filter($rooms, function ($current) use ($hostel_floor) {return $current["floor_id"]===$hostel_floor["floor_id"];});
                        foreach($hostel_rooms as $hostel_room){
                            ?>
                            <div class="uk-card uk-card-small uk-card-default uk-margin-small">
                                <div class="p-m" style="background-color: #999999">
                                    <h4>Room :  <?= $hostel_floor["floor_name"]?>-<?= $hostel_room["room_number"]?></h4>
                                </div>
                                <div class="p-m">
                                    <div class="uk-grid-collapse" uk-grid>
                                        <?php
                                        $hostel_beds = array_filter($beds, function ($current) use ($hostel_room) {return $current["room_id"]===$hostel_room["room_id"];});
                                        foreach ($hostel_beds as $hostel_bed){
                                            ?>
                                            <div>
                                                <div class="bed bed-<?= $hostel_bed["is_occupied"]?"occupied":"vacant"?>"
                                                     ondrop="drop(event)"
                                                     id="bed-<?= $hostel_bed["bed_id"]?>"
                                                     bed-id = "<?= $hostel_bed["bed_id"]?>"
                                                     bed-number="<?= $hostel_bed["bed_number"]?>"
                                                     ondragover="allowDrop(event)">
                                                    <?php if($hostel_bed["is_occupied"]){?>
                                                        <div class="bed-user" ondrop="event.preventDefault()" style="background-image: url('<?= $hostel_bed["image"]!=""?$hostel_bed["image"]:""?>')">
                                                            <div class='popover'>
                                                                <?= $hostel_bed["name"]?>  (<?= $hostel_bed["class"]?>-<?= $hostel_bed["asession"]?>)
                                                                <a onclick="unAllocateStudent(<?= $hostel_bed["historyId"]?>,<?= $hostel_bed["bed_id"]?>)">Un Assign</a>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}

if($os->get("assign_student")=="OK" && $os->post("assign_student")=="OK"){

    $hId = $os->post("hId");
    $bedId = $os->post("bedId");

    $dataToSave = [
        "bed_id"=>$bedId
    ];
    $history = $os->mfa($os->mq("SELECT * FROM history WHERE historyId='$hId'"));
    $res = $os->mq("UPDATE history h SET h.bed_id=NULL WHERE h.bed_id='$bedId' AND asession='".$history['asession']."'");
    $res = $os->mq("UPDATE history SET bed_id='$bedId' WHERE historyId='$hId'");

    if($res){
        print "Assigned Successful";
    } else {
        print "Assigned Unsuccessful";
    }
    exit();
}

if($os->get("un_assign_student")=="OK" && $os->post("un_assign_student")=="OK"){

    $hId = $os->post("hId");
    $res = $os->mq("UPDATE history SET bed_id=NULL WHERE historyId='$hId'");
    if($res){
        print "Assigned Successful";
    } else {
        print "Assigned Unsuccessful";
    }
    exit();
}





