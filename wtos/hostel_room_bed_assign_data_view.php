<?php
/*
   # wtos version : 1.1
   # main ajax process page : feesAjax.php
   #
*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');

$pluginName='';
$listHeader='Hostel Room Bed';
$ajaxFilePath= 'hostel_room_bed_assign_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>


<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>

        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <select name="branch_code_s" id="branch_code_s" class="select2" onchange="fetchStudents(); wt_ajax_chain('html*building_id_s*hostel_building,building_id,building_name*building_id=branch_code_s','','','');">
                <option value="">All Branch</option>
                <?php $os->onlyOption(array_reduce($os->get_branches(), function($all, $current){
                    $all[$current["branch_code"]] = $current["branch_name"];
                    return $all;
                },[]),'');	?>
            </select>

            <div class="uk-inline uk-margin-small-left">
                <select name="asession"
                        id="asession_s"
                        style="padding-left: 85px"
                        class="uk-select uk-border-rounded congested-form" onchange="fetchStudents(); fetchBeds();">
                    <option value=""> </option>
                    <?php
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession, '');
                    ?>
                </select>
            </div>

        </div>
    </div>

</div>
<div class="content">
    <div class="item p-m">
        <div class="uk-grid-small" uk-grid>
            <div class="uk-width-medium">
                <div class="uk-inline" uk-tooltip="Class">
                    <select name="class" id="class_s" class="uk-select uk-border-rounded congested-form " onchange="fetchStudents()">
                        <option value=""> </option>
                        <?php foreach($os->board_class as $board=> $classes){?>
                            <optgroup label="<?=$board?>">
                                <?php foreach ($classes as $class){?>
                                    <option value="<?php echo $class?>"> <?php echo $os->classList[$class]?></option>
                                <?php }?>
                            </optgroup>
                        <?php } ?>
                    </select>
                    <select id="bed_allocated_s" onchange="fetchStudents()">
                        <option value=""></option>
                        <option value="yes">Allocated</option>
                        <option value="no">Not Allocated</option>
                    </select>

                    <input type="text" id="student_name_s_s" onchange="fetchStudents()" placeholder="Name"/>
                    <input type="text" id="registration_no_s_s" onchange="fetchStudents()" placeholder="Registration Number"/>
                </div>
                <div id="students" class="uk-margin">

                </div>
            </div>
            <div class="uk-width-expand">
                <select onchange="fetchBeds()" id="building_id_s">
                    <option>Select Building</option>
                </select>
                <select id="bed_status_s" onchange="fetchBeds()">
                    <option value="">All</option>
                    <option value="vacant">Vacant</option>
                    <option value="occupied">Occupied</option>
                </select>
                <input type="text" id="student_name_b_s" onchange="fetchBeds()" placeholder="Name"/>
                <input type="text" id="registration_no_b_s" onchange="fetchBeds()" placeholder="Registration Number"/>
                <div id="beds" class="uk-margin">

                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function onStudentDragStart(ev) {
        ev.target.classList.add("dragging");
        ev.dataTransfer.setData("hId", ev.target.getAttribute("hId"));
        ev.dataTransfer.setData("name", ev.target.getAttribute("name"));
        ev.dataTransfer.setData("standard", ev.target.getAttribute("standard"));
        ev.dataTransfer.setData("asession", ev.target.getAttribute("asession"));
        ev.dataTransfer.setData("image", ev.target.getAttribute("image"));
    }

    function onStudentDragOver(ev) {
        ev.target.classList.remove("dragging");
    }

    function drop(ev) {
        ev.preventDefault();
        if(ev.target.classList.contains("bed-occupied") || !ev.target.classList.contains("bed")){
            return false;
        }
        const bedId = ev.target.getAttribute("bed-id");
        const hId = ev.dataTransfer.getData("hId");
        const name = ev.dataTransfer.getData("name");
        const standard = ev.dataTransfer.getData("standard");
        const asession = ev.dataTransfer.getData("asession");
        const image = ev.dataTransfer.getData("image");


        var formData = new FormData();
        formData.append('hId', hId);
        formData.append('bedId', bedId);
        formData.append("assign_student", "OK");

        const url = "<?= $ajaxFilePath?>?assign_student=OK";
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<?php echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            ev.target.innerHTML = `<div class="bed-user" ondrop="event.preventDefault()" style="background-image: url('${image!==""?image:''}')"><div class='popover'>
${name}  (${standard}-${asession})
<a onclick="unAllocateStudent(${hId},${bedId})">Un Assign</a>
    </div></div>`;
            ev.target.classList.add("bed-occupied");
            ev.target.classList.remove("bed-vacant");
            fetchStudents();
        },url,formData);
    }

    function unAllocateStudent(historyId, bedId){
        const bed = document.querySelector(`#bed-${bedId}`);
        bed.innerHTML = "";
        bed.classList.remove("bed-occupied");
        bed.classList.add("bed-vacant");
        var formData = new FormData();
        formData.append('hId', historyId);
        formData.append("un_assign_student", "OK");

        const url = "<?= $ajaxFilePath?>?un_assign_student=OK";
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<?php echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            fetchStudents();
        },url,formData);
    }
</script>

<script>
    function fetchStudents(){
        let asession_s = document.querySelector("#asession_s").value;
        let branch_code_s = document.querySelector("#branch_code_s").value;
        let class_s = document.querySelector("#class_s").value;
        let bed_allocated_s = document.querySelector("#bed_allocated_s").value;
        let student_name_s_s = document.querySelector("#student_name_s_s").value;
        let registration_no_s_s = document.querySelector("#registration_no_s_s").value;


        var formData = new FormData();
        formData.append('asession_s', asession_s);
        formData.append('branch_code_s', branch_code_s);
        formData.append('bed_allocated_s', bed_allocated_s);
        formData.append('class_s', class_s);
        formData.append('student_name_s', student_name_s_s);
        formData.append('registration_no_s', registration_no_s_s);

        formData.append('fetch_students', "OK");

        var url='<?= $ajaxFilePath?>?fetch_students=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<?php echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((text)=>{
            document.querySelector("#students").innerHTML = text;
        },url,formData);
    }
    function fetchBeds(){
        let asession_s = document.querySelector("#asession_s").value;
        let branch_code_s = document.querySelector("#branch_code_s").value;
        let bed_status_s = document.querySelector("#bed_status_s").value;
        let building_id_s = document.querySelector("#building_id_s").value;
        let class_s = document.querySelector("#class_s").value;
        let student_name_b_s = document.querySelector("#student_name_b_s").value;
        let registration_no_b_s = document.querySelector("#registration_no_b_s").value;

        var formData = new FormData();
        formData.append('asession_s', asession_s);
        formData.append('branch_code_s', branch_code_s);
        formData.append('bed_status_s', bed_status_s);
        formData.append('building_id_s', building_id_s);
        formData.append('class_s', class_s);
        formData.append('student_name_s', student_name_b_s);
        formData.append('registration_no_s', registration_no_b_s);

        formData.append('fetch_beds', "OK");
        var url='<?= $ajaxFilePath?>?fetch_beds=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<?php echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((text)=>{
            document.querySelector("#beds").innerHTML = text;
        },url,formData);
    }
</script>

<style>
    .student-card{
        border-bottom :1px solid #e5e5e5;
        border-left-width: 0;
        border-right-width: 0;
        cursor: pointer;
    }
    .student-card.allocated{
        background-color: #ffff4d;
        cursor: inherit;
    }
    .student-card.dragging{
        border-color: blue;
        cursor: all-scroll;
    }

    .bed{
        background-size: 100% 100%;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 70px;
        width: 70px;
    }
    .bed > .bed-user{
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        height: 15px; width: 15px;
        background-color: #0A246A;
        border-radius: 100%;
        background-image: url(images/demo_user.png);
        background-size: cover;
        z-index: 99;
    }
    .bed > .bed-user > .popover{
        position: absolute;
        left: 50%;
        transform: translateX(-50%) translateY(-100%);
        top: 0;
        background-color: white;
        width: auto;
        border: 1px solid #E5E5E5;
        border-radius: 8px;
        padding: 5px 15px;
        display: none;
        white-space: nowrap;
    }
    .bed > .bed-user > .popover > a{
        font-size: 12px;
        display: block;
    }
    .bed:hover > .bed-user > .popover{
        display: block;
    }
    .bed:after{
        content: attr(bed-number);
        position: absolute;
        bottom: 14px;
        left: 50%;
        transform: translateX(-50%);
        padding: 0px 4px;
        background-color:  #fff;
        border-radius: 10px;
        border: 1px solid #e5e5e5;
        font-size: 11px;
    }
    .bed.bed-vacant{
        background-image: url("images/bed_vacant.png");
    }

    .bed.bed-occupied{
        background-image: url("images/bed_occupied.png");
        cursor: pointer;
    }
</style>

<?php include($site['root-wtos'].'bottom.php'); ?>
