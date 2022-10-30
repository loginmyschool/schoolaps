<?

include('wtosConfigLocal.php');
global $site,$os;
include($site['root-wtos'].'wtosCommon.php');
include "./helpers/admin_access.php";
$os->loadPluginConstant('');

$aaHelper = new \WTOS\Helpers\AdminAccess($os,$site);



$return_acc_details=$os->branch_access();
$and_branch_in="";
if($os->userDetails['adminType']!='Super Admin')
{
    $and_branch_in=" and branch_code ".$return_acc_details['branches_code_IN']." and adminType!='Super Admin'";
}

$working_admin_id = $os->get("working_admin_id");
$branch_code_s = $os->get("branch_code_s");
$access_key_s = $os->get("access_key_s");
////////




//Common functions
function populate_access_tree($menu, $accesses=[],  $parent=0, $level=-1){
    global  $working_admin_id, $branch_code_s, $access_key_s;
    $level++;
    $prefix='';
    for($c=1; $c<=$level; $c++){
        $prefix .= "<span style='color:transparent'>_</span>|<span style='color:transparent'>-----</span>";
    }
    $x = 0;
    ?>
    <ul style="<?=$level>0?"display:none;":""?>border-left:  1px solid #e5e5e5; border-bottom:  1px solid #e5e5e5; list-style: none; margin-top: 0; margin-bottom: 0; margin-left: 3px; padding: 3px 0px 3px 0; <?=$level>0?"padding-left:18px;":"0"?>">
    <?
    foreach ($menu[$parent] as $record){
        $admin_menu_id = $record['admin_menu_id'];
        $x++;

        ?>
        <li style="background-color:  <?= $access_key_s==$record['access_key']?"#00ff0050":""?>;">
            <div style="display: inline-block; width: 12px;">
                <? if(isset($menu[$admin_menu_id])){?>
                    <a style="display: block; height: 14px; width: 18px; font-size: 18px" onclick="collapse_expand(this)">+</a>
                <? } ?>
            </div>
            <input value="<?= $record['access_key']?>"
                   type="checkbox"
                   name="access[]"
                   class="access_checkbox uk-margin-small-right"
                   onchange="check_uncheck(this)"
                <? if(in_array($record['access_key'] , $accesses)) { ?>
                    checked="checked"
                <? } ?>/>
            <?= $record['title']?>

            <? if(!isset($menu[$admin_menu_id])){?>
                <a class="uk-text-danger uk-float-right"
                   href="?working_admin_id=<?=$working_admin_id?>&access_key_s=<?= $record['access_key'] ?>">Branches &rarr;</a>
            <?}?>

            <?
            if(isset($menu[$admin_menu_id])){
                populate_access_tree($menu, $accesses, $admin_menu_id, $level);
            }
            ?>
        </li>
        <?
    }
    ?>
    </ul>
    <?
}
////
if($working_admin_id==""){
    print  "Something went wrong!";
    exit();
}

$working_admin = $os->mfa($os->mq("SELECT * FROM admin a WHERE a.adminId='$working_admin_id'"));
$working_admin_access = $aaHelper->get_accesses($working_admin);



if ($os->post("save_menu_access")=="OK"){
    $accesses = $os->post("access");
    $adminId = $os->post("adminId");

    $os->mq("DELETE FROM admin_access WHERE adminId=$adminId");
    foreach ($accesses as $access){
        $datatosave = [];
        $datatosave["access_key"] = $access;
        $datatosave["adminId"] = $adminId;

        $os->save("admin_access",$datatosave);
    }

    print "Successfully saved data";
    exit();
}
if ($os->post("save_branch_access")=="OK"){
    $access_key = $os->post("access_key");
    $branch_codes = $os->post("branch_codes");
    $adminId = $os->post("adminId");

    $os->mq("DELETE FROM admin_access_branch WHERE adminId='$adminId' AND access_key='$access_key'");

    _d($branch_codes);

    foreach ($branch_codes as $branch_code){
        $datatosave = array(
            "access_key" => $access_key,
            "branch_code"=> $branch_code,
            "adminId"=> $adminId,
        );
        $os->save("admin_access_branch", $datatosave)."<br>";

    }

    print "Successfully Saved";
    exit();
}
if ($os->post("save_class_access")=="OK"){
    $access_key = $os->post("access_key");
    $branch_code = $os->post("branch_code");
    $adminId = $os->post("adminId");
    $classes_gender = $os->post("classes_gender");



    $os->mq("DELETE FROM admin_access_class WHERE adminId='$adminId' AND access_key='$access_key' AND branch_code='$branch_code'");

    foreach ($classes_gender as $class=>$gender){
        if ($gender==""){continue;}
        if ($gender=="Both"){$gender='';};
        $datatosave = array(
            "access_key" => $access_key,
            "branch_code"=> $branch_code,
            "adminId"=> $adminId,
            "class" => $class,
            "gender"=>$gender
        );
        $os->save("admin_access_class", $datatosave);
    }

    print "Successfully Saved";
    exit();
}
if ($os->post("save_secondary_access")=="OK"){
    $access_key = $os->post("access_key");
    $branch_code = $os->post("branch_code");
    $adminId = $os->post("adminId");
    $secondary_access = addslashes(@json_encode($os->post("secondary_accesses")));



    $admin_access_branch_id = $os->mfa($os->mq("SELECT admin_access_branch_id FROM admin_access_branch WHERE access_key='$access_key_s' AND branch_code='$branch_code_s' AND adminId='$adminId'"))["admin_access_branch_id"];

    print $admin_access_branch_id;


    if ($admin_access_branch_id>0){
        $datatosave = array(
                "secondary_accesses"=>$secondary_access
        );
        $os->save("admin_access_branch", $datatosave, "admin_access_branch_id", $admin_access_branch_id);
    }
    print "done";
    exit();
}


?>
<html lang="en-gb">
<head>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>
    <? include('wtosHeader.php'); ?>



    <script src="<?php echo $site['url-wtos']?>js/jquery-3.4.1.min.js"></script>


    <!---Ajax Form---->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>


    <link href="https://unpkg.com/@blueprintjs/icons@^3.4.0/lib/css/blueprint-icons.css" rel="stylesheet" />
    <link href="https://unpkg.com/@blueprintjs/core@^3.10.0/lib/css/blueprint.css" rel="stylesheet" />



    <link rel="stylesheet" type="text/less" href="<?php echo $site['url-wtos']?>css/common.less"/>
    <link rel="stylesheet" type="text/less" href="<?php echo $site['url-wtos']?>css/style.less"/>
    <link rel="stylesheet" type="text/css"  href="<?php echo $site['url-wtos']?>css/responshive.css"/>


    <link rel="stylesheet" type="text/css" title="graphics"  href="<?php echo $site['url-wtos']?>css/responshive.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

    <script src="<?php echo $site['url-wtos']?>js/less.min.js"></script>


    <style>
        *{
            border-collapse: collapse;
            box-sizing: border-box;
        }
        html, body{
            margin:0;
            padding:0;

        }
    </style>
</head>
<body class="uk-height-1-1">

    <div class="uk-height-1-1 uk-grid uk-grid-collapse" uk-grid>
        <div class="uk-height-1-1 uk-width-expand">
            <div class="uk-card uk-card-default uk-card-small" style="height: 100vh ;overflow-y: auto">
                <form id="menu_form" method="post" enctype="multipart/form-data" onchange="$('#save_menu_access_button').trigger('click')">
                    <input type="hidden" value="<?=$working_admin_id?>" name="adminId" class="uk-margin-small-right">
                    <? $menus  = $aaHelper->get_menu($os->userDetails) ?>
                    <div class="uk-card-header">
                        <h3 class="uk-modal-title " style="font-size: 14px">
                            <input type="checkbox"
                                   onchange="selectAll('.access_checkbox', this.checked)" class="uk-margin-small-right">
                            Access for <b> <? echo $working_admin['name']; ?> </b>
                            <button class="uk-float-right uk-button uk-button-primary congested-form"
                                    name="save_menu_access"
                                    id="save_menu_access_button"
                                    value="OK" type="submit">Save Menu</button>
                        </h3>
                    </div>
                    <div class="uk-overflow-auto" style="height: calc(100vh - 50px)">

                            <?
                            populate_access_tree($menus, $working_admin_access,0, -1); ?>

                    </div>
                </form>
            </div>
        </div>

        <div class="uk-height-1-1 uk-width-expand">
            <? if($access_key_s!=""){?>
                <div class="uk-card uk-card-default uk-card-small" style="height: 100vh ;overflow-y: auto">
                    <form id="branch_form" method="post"
                          enctype="multipart/form-data" onchange="$('#save_branch_access_button').trigger('click')">
                        <input type="hidden" value="<?=$working_admin_id?>" name="adminId">
                        <input type="hidden" value="<?=$access_key_s?>" name="access_key">
                        <div class="uk-card-header">
                            <h3 class="uk-modal-title " style="font-size: 14px">
                                <input type="checkbox" onchange="selectAll('.branch_checkbox', this.checked)">
                                Branch Access for
                                <b> <? echo $access_key_s?> </b>
                                <button id="save_branch_access_button" class="uk-float-right uk-button uk-button-primary congested-form" type="submit" value="OK" name="save_branch_access">SAVE BRANCH</button>

                            </h3>

                        </div>
                        <div style="height: calc(100vh - 50px); overflow-y: auto;">
                            <table class="uk-table congested-table uk-table-striped uk-table-hover uk-text-small">
                                <?
                                $_BRANCHES = $aaHelper->get_branches($access_key_s, $os->userDetails);

                                $working_admin_branches = $aaHelper->get_branches($access_key_s, $working_admin);
                                $count=0;
                                foreach ($_BRANCHES as $branch_code=>$BRANCH):$count++?>
                                    <tr style="background-color: <?=$branch_code==$branch_code_s?"#00ff0050":""?>">
                                        <td><input type="checkbox"
                                                   name="branch_codes[]"
                                                   class="branch_checkbox"
                                                   value="<?=$branch_code?>"
                                                <?= key_exists($branch_code, $working_admin_branches)?"checked":""?>>
                                        </td>
                                        <td style="color: darkblue; font-weight: bold">[<?=$branch_code;?>]</td>
                                        <td class="uk-text-nowrap">
                                            <a class="uk-link-reset" ><?=$BRANCH;?></a>
                                        </td>
                                        <td>
                                            <a class="uk-text-danger"
                                               href="?working_admin_id=<?=$working_admin_id?>&branch_code_s=<?=$branch_code?>&access_key_s=<?= $access_key_s ?>">Others &rarr;</a>

                                        </td>
                                    </tr>
                                <?endforeach;?>
                            </table>
                        </div>
                    </form>
                </div>
            <?} else {
                ?>
                <h3 class="p-l">Please select menu item to get Branches</h3>
            <?
            }?>
        </div>

        <div class="uk-height-1-1 uk-width-expand">
            <? if($branch_code_s!="" && $access_key_s!=""){?>

                <div class="uk-card uk-card-default uk-card-small" style="height: 30vh ;overflow-y: auto">
                    <form id="secondary_form" method="post"
                          onchange="$('#secondary_save_button').trigger('click')"
                          enctype="multipart/form-data">
                        <input type="hidden" value="<?=$working_admin_id?>" name="adminId">
                        <input type="hidden" value="<?=$access_key_s?>" name="access_key">
                        <input type="hidden" value="<?=$branch_code_s?>" name="branch_code">
                    <div class="uk-card-header">
                        <h3 class="uk-modal-title " style="font-size: 14px">
                            <b><?=$_BRANCHES[$branch_code_s]?>-<?=$access_key_s?></b>
                            <button class="uk-button-primary uk-button congested-form uk-float-right"
                                    type="button"
                                    name="save_secondary_access"
                                    value="OK">SAVE</button>
                        </h3>

                    </div>
                    <div class="uk-overflow-auto" style="height: calc(100% - 50px)">
                        <table class="uk-table congested-table uk-table-striped">
                            <tbody>
                            <?
                            $second_level_access = $aaHelper->get_secondary_access($access_key_s,$branch_code_s, $os->userDetails);
                            $s_accesses = $aaHelper->get_secondary_access($access_key_s,$branch_code_s, $working_admin);
                            foreach ($second_level_access as $s_access){
                                ?>
                                <tr style="font-size: 14px">
                                    <td class="uk-table-shrink">
                                        <input type="checkbox"
                                               <?=in_array($s_access, $s_accesses)?"checked":""?>
                                               name="secondary_accesses[]"
                                               value="<?=$s_access?>">
                                    </td>
                                    <td><?=$s_access?></td>
                                </tr>
                            <? }?>
                            </tbody>
                        </table>
                    </div>
                        <button type="submit" id="secondary_save_button"
                                name="save_secondary_access"
                                value="OK"></button>
                    </form>
                </div>
                <div class="uk-card uk-card-default uk-card-small" style="height: 70vh ;overflow-y: auto">
                    <div class="uk-card-header">
                        <h3 class="uk-modal-title " style="font-size: 14px">Class Access</h3>
                    </div>
                    <div class="uk-overflow-auto" style="height: calc(100% - 50px)">


                        <?
                        $menu =  $os->mfa($os->mq("SELECT * FROM admin_menu WHERE access_key='$access_key_s'"));
                        if($menu["class_required"]=="Yes"){
                            $classes = $aaHelper->get_classess($access_key_s,$branch_code_s, $os->userDetails);
                            $working_user_classes = $aaHelper->get_classess($access_key_s,$branch_code_s, $working_admin);
                            ?>
                            <form id="class_form" method="post"
                                  onchange="$('#class_save_button').trigger('click')"
                                  enctype="multipart/form-data">
                                <input type="hidden" value="<?=$working_admin_id?>" name="adminId">
                                <input type="hidden" value="<?=$access_key_s?>" name="access_key">
                                <input type="hidden" value="<?=$branch_code_s?>" name="branch_code">
                                <ul class="uk-margin-remove" uk-tab>
                                    <? foreach ($os->board as $key => $board){?>
                                        <li><a href="#"><?=$board?></a></li>
                                    <?}?>
                                </ul>
                                <ul class="uk-switcher uk-margin-remove">
                                    <? foreach ($os->board as $key => $board){?>
                                        <li>
                                            <table class="uk-table congested-table uk-table-striped uk-margin-remove">
                                                <tbody>
                                                <?
                                                foreach ($os->board_class[$board] as $class){
                                                    if (!key_exists($class, $classes)){continue;}
                                                    ?>
                                                    <tr style="font-size: 13px">
                                                        <td><?= $os->classList[$class]?></td>
                                                        <? if($menu["gender_required"]=="Yes"){
                                                            $isboth = false;
                                                           if(isset($working_user_classes[$class])){
                                                               $isboth = $working_user_classes[$class]==""?"Both":"";
                                                           }
                                                            ?>
                                                            <td class="uk-text-small uk-table-shrink uk-text-nowrap">
                                                                <select
                                                                        name="classes_gender[<?=$class?>]">
                                                                    <option value=""></option>
                                                                    <option value="Both" <?=$isboth?"selected":""?>>Both</option>
                                                                    <? $os->onlyOption($os->gender,  @$working_user_classes[$class])?>
                                                                </select>
                                                            </td>
                                                        <?}?>
                                                    </tr>
                                                <? }?>
                                                </tbody>
                                            </table>
                                        </li>
                                    <?}?>
                                </ul>

                                <button class="uk-hidden" type="submit" id="class_save_button" name="save_class_access" value="OK">SAVE</button>
                            </form>
                        <?}?>

                    </div>


                </div>
            <?} else {
                ?>
                <h3 class="p-l">Please select branch for other access Branches</h3>
                <?
            }?>
        </div>
    </div>




<script>
    $("#menu_form").ajaxForm();
    $("#branch_form").ajaxForm();
    $("#class_form").ajaxForm();
    $("#secondary_form").ajaxForm();

    function selectAll(el, order){
        document.querySelectorAll(el).forEach(el=>{
            $(el).attr("checked", order)

        })
    }

    function collapse_expand(el){
        switch(el.innerText){
            case "+":
                el.innerHTML = "-";
                $(el).parent().next().next().slideDown();
                break;
            case "-":
                el.innerHTML=`+`;
                $(el).parent().next().next().slideUp();
                break;
        }
    }
    function check_uncheck(el){
        return;
        el.parentElement.querySelectorAll("input").forEach(function (x){
            x.checked = el.checked;
        })
    }
</script>
</body>
</html>
