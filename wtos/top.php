<?
global $site, $os;
include($site['root-wtos'].'wtosCommon.php');


// <!-- branch selection -->
if($os->post('branch_selection')=='OKK')
{

    $selected_branch_code_option=$os->post('selected_branch_code_option');
    $os->setSession($selected_branch_code_option,$key1='selected_branch_code');
    $linkself=$site['url-wtos']."staff_profile.php";
    header("Location:$linkself");
    exit();

}


$branches_for_current_user=get_branches(false, true);
$selected_branch_code=$os->getSession($key1='selected_branch_code');
if($selected_branch_code=='')
{
    $selected_branch_code = array_key_first($branches_for_current_user);
    $os->setSession($selected_branch_code,$key1='selected_branch_code');
}
?>
<!DOCTYPE HTML>
<html lang="en-gb">
<head>

    <script src="<?php echo $site['url-wtos']?>js/jquery-3.4.1.min.js"></script>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="<? echo $site['themePath']?>css/uikit.css" />

    <!-- UIkit JS -->
    <script src="<? echo $site['themePath']?>js/uikit.min.js"></script>
    <script src="<? echo $site['themePath']?>js/uikit-icons.min.js"></script>
    <? include('wtosHeader.php'); ?>


    <link rel="stylesheet" href="<?php echo $site['url']?>/node_modules/jquery-ui-dist/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= $site['url']?>node_modules/jquery-datetimepicker/build/jquery.datetimepicker.min.css" />

    <script src="<?php echo $site['url']?>/node_modules/jquery-ui-dist/jquery-ui.min.js"></script>
    <script src="<?= $site['url']?>node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.js"></script>

    <!---Ajax Form---->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <!--select2-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js" integrity="sha512-Zg2aQwILT6mEtfZukaZrrN7c6vmwp2jAW2ZzRK9T4u6p4/2HpgfMwDN2yR9P00AZTIqsrO9MjqntyNxPvoDWfg==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.css" integrity="sha512-2b4E2KZIy7Xz4082r/cBt3z6h9zgQaiYZyZNaNutklySkplw0aPxVl/PvEAnECy73/smtOQ9BQMdpJUFK4T6ag==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.min.css" integrity="sha512-EdUjiilLlcTVcFcB7TeUZ9BaA7XbmfcLewGcexnBuGwjnLVhv0TyVSMSZvn6Atzrlb4Ro8qgSi0cJO1KjD5Qgw==" crossorigin="anonymous" />


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $site['url-wtos']?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $site['url-wtos']?>css/style.css"/>
    <link rel="stylesheet" type="text/css"  href="<?php echo $site['url-wtos']?>css/responsive.css"/>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

    <!-- Blueprint stylesheets -->
     <link href="https://unpkg.com/@blueprintjs/icons@^3.4.0/lib/css/blueprint-icons.css" rel="stylesheet" />
    <link href="https://unpkg.com/@blueprintjs/core@^3.10.0/lib/css/blueprint.css" rel="stylesheet" />

    <!-- Blueprint dependencies -->
    <script src="https://unpkg.com/classnames@^2.2"></script>
    <script src="https://unpkg.com/dom4@^1.8"></script>
    <script src="https://unpkg.com/tslib@^1.9.0"></script>
    <script src="https://unpkg.com/react@^16.2.0/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@^16.2.0/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/react-transition-group@^2.2.1/dist/react-transition-group.min.js"></script>
    <script src="https://unpkg.com/popper.js@^1.14.1/dist/umd/popper.js"></script>
    <script src="https://unpkg.com/react-popper@^1.0.0/dist/index.umd.min.js"></script>
    <script src="https://unpkg.com/resize-observer-polyfill@^1.5.0"></script>
    <!-- Blueprint packages (note: icons script must come first) -->
    <script src="https://unpkg.com/@blueprintjs/icons@^3.4.0"></script>
    <script src="https://unpkg.com/@blueprintjs/core@^3.10.0"></script>

    <? if(0){ ?>
        <script src="<?php echo $site['url-wtos']?>js/jquery-3.4.1.min.js"></script>
    <? } ?>


    <script type="">
        window['after_ajax_functions'] = [];
    </script>


    <?  $selected_branch_code=$os->getSession($key1='selected_branch_code');  ?>
</head>
<body>




<div id="div_busy" style="position:fixed; top:0px; left:45%; z-index: 60"></div>
<div id="FlashMessageDiv" style="position:fixed; top:0px; left:45%; background-color:#FFCC00"></div>

<?php $os->validateWtos(); ?>
<?
/*****
* Maintenance
*/

if($os->val($os->site_settings, "Deactivate Backend")!=0 && $os->userDetails["adminType"]!=="Super Admin"){
?>
<html lang="en-gb">
<head>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.10/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.10/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.10/dist/js/uikit-icons.min.js"></script>
    <title>This site is temporarily under construction</title>
</head>
<body class="uk-flex-middle uk-flex-center uk-flex uk-height-1-1">
<div class="deactivateMessage">
    <?= $os->val($os->site_settings, "Deactivate Message")?>
</div>
</body>
</html>
<? exit();
}
?>


<style>
    .RbHints{ font-size:10px; font-style:italic; color:#000099;}
    .ui-icon-closethick{ background-color:#FF0000;  }
</style>

<!--//////////////////////	-->




<div id="wtos_edit_container" class="wtos_edit_container" style="display:none;" >
    <div id="wtos_edit_container_head_div" class="wtos_edit_container_head"><span id="wtos_edit_container_head">&nbsp;</span>
        <div id="wtos_edit_container_close" class="wtos_edit_container_close"   onclick="os.hide('wtos_edit_container');">CLOSE</div>
    </div>
    <div id="wtos_edit_container_data" class="wtos_edit_container_data">-
    </div>
</div>

<header class="uk-flex">
    <div class="nav-button">
        <i class="la la-bars text-xl p-left-m p-right-m"></i>
    </div>
    <div class="logo left p-left-m ">
        <p class="uk-margin-remove">Aurangabad Public School</p>
    </div>
    <div>

    </div>
    <div class="right-panel">
        <ul>
            <li>
                <a class="uk-link-reset">
                    <? if(is_file($site['root'].$os->loggedUser()['image'])){?>
                        <img src="<?=$site["url"].$os->userDetails['image'];?>" style="height: 25px;object-fit: cover; width: 25px; border-radius: 100%">
                    <?} else {?>
                        <img src="https://via.placeholder.com/150" style="height: 25px;object-fit: cover; width: 25px; border-radius: 100%">
                    <?}?>
                </a>
                <ul class="dropdown">
                    <li>
                        <a class="uk-link-reset" href="<? echo $site['url-wtos'] ?>staff_profile.php">
                            <i class="la la-user-check"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="uk-link-reset" href="<? echo $site['url-wtos'] ?>dashBoard.php?logout=logout">
                            <i class="las la-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
					
					 <li>
                        <a class="uk-link-reset" href="<? echo $site['url-wtos'] ?>adminChangeProfile.php">
                            <i class="las la-key"></i></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>


</header>
<? include('osLinks.php') ?>
<script type="javascript">
    function generate_random_id(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    function open_editor_tooltip(target_box, type="text") {
        let element = null;
        if(target_box instanceof Element){
            element = target_box;
        } else {
            element = document.querySelector(target_box);
        }

        let element_parent_position = element.parentNode.style.position

        element.parentNode.style.position = "relative";

        //container
        let container = document.createElement("tooltip");
        container.id = generate_random_id(10);
        container.classList.add("tooltip-input-container");
        container.style.width = element.offsetWidth+"px";
        container.style.top = parseInt((element.offsetTop)+(element.offsetHeight)+10)+"px";
        container.style.left = (element.offsetLeft)+"px";

        let close_func = function(){
            if(type==="date")
                setTimeout(function () {
                    container.remove();
                }, 200);
            else
                container.remove();
        };
        //create input
        let new_input = document.createElement("input");
        new_input.classList.add("tooltip-input");
        type==="date"?new_input.classList.add("wtDateClass"):null;
        new_input.placeholder = element.placeholder?element.placeholder: "Please enter value";
        new_input.value = (element.value!==""|| element.value!=="undefined"|| element.value!==null)?element.value:element.innerText;
        ////events
        new_input.onchange = function () {
            element.value = new_input.value;
            element.innerText = new_input.value;
            new_input.blur();
        };

        new_input.addEventListener("focusout", close_func);

        container.appendChild(new_input);
        element.parentNode.insertBefore(container, element.nextSibling);
        os.viewCalender('wtDateClass','<? echo $os->dateFormatJs; ?>');

        new_input.focus();
    }
    function image_set_background_from_input(input, element){
        if(!input instanceof Element){input = document.querySelector(input);
        }
        element = document.querySelector(element);
        console.log(input.value);

        let url = input.value;
        let ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "jpeg")) {
            let reader = new FileReader();

            reader.onload = function (e) {
                console.log(element);
                element.style.backgroundImage = `url(${e.target.result})`;
                let img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    if(this.width>this.height){
                        element.style.backgroundSize = "100% auto";
                    } else {
                        element.style.backgroundSize = "auto 100%";
                    }
                }
            };

            reader.readAsDataURL(input.files[0]);
        }else{
            element.style.backgroundImage ='url(<?php echo $site['url-wtos'] ?>images/student_img.png)';
        }
    }
    function focus_on_input(element) {;
        if(element instanceof Element){
            element = element;
        } else {
            element = document.querySelector(element);
        }
        element.select();
    }
</script>
<? include('admission_script_common.php'); ?>
<div class="container">

