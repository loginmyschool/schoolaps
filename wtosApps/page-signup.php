<?php
//include  __DIR__."/_partials/wt_header.php";
global $site, $os;
$ajaxFilePath= $site['url'].'wtosApps/'.'signup_ajax.php';
$loadingImage=$site['url-wtos'].'images/loading_new.gif';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oriental English Academy</title>
    <script type="text/javascript" src="<? echo $site['url-library']?>wtos-1.1.js"></script>
    <script>
        function getData(string,seperator)
        {
            var D=string.split(seperator);
            return D[1];
        }

    </script>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="<?= $site["themePath"]?>css/uikit.css" />
    <link rel="stylesheet" href="<?= $site["themePath"]?>css/common.css" />

    <!-- UIkit JS -->
    <script src="<?= $site["themePath"]?>js/uikit.min.js"></script>
    <script src="<?= $site["themePath"]?>js/uikit-icons.min.js"></script>




    <style>
        *{
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif
        }
        html, body{
            height: 100%;
            width: 100%;
            background-color: var(--color-secondary);
            background-size: cover;
            background-position: center;
        }
    </style>

</head>
<body class="">
    <div class="uk-background-muted  uk-padding">

        <div class=" uk-container-small uk-container">
            <div class=" uk-card uk-card-default">
                <div class="uk-grid-match uk-grid-collapse uk-grid" uk-grid="">
                    <div class="uk-width-expand@s uk-visible@s uk-first-column">
                        <div class="uk-card uk-card-body uk-light uk-flex uk-flex-middle uk-flex-center uk-background-muted">
                            <img src="<?echo $site['themePath']?>images/login.svg" class="uk-width-medium">
                        </div>

                    </div>
                    <div class="uk-width-expand@s">
                        <div id="div_busy"></div>
                        <div class=" uk-card-body">
                            <form onsubmit="event.preventDefault(); register_student(this);">
                                <h3 class="uk-text-center">Sign Up</h3>

                                <div class="uk-child-width-1-1 uk-grid-small" uk-grid>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Full Name</label>
                                            <input type="text" name="name" id="name" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Father Name</label>
                                            <input type="text" name="father_name" id="father_name" class="uk-input" required>
                                        </div>
                                    </div>



                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Class</label>
                                            <select name="class_s" id="class_s" class="textbox fWidth uk-select" required >
                                                <option value=""> </option>    
                                                <?$os->onlyOption($os->classList);?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Session</label>
                                            <select name="asession_s" id="asession_s" class="textbox fWidth uk-select" required>
                                                <option value=""> </option>    
                                                <? $os->optionsHTML('','idKey','title','accademicsession','status="active"'); ?>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="uk-hidden">
                                        <label>Branch</label>
                                        <select name="branch_code" id="branch_code" class="textbox fWidth uk-select">
                                            <option value=""> </option>    
                                            <? $os->optionsHTML('1','branch_code','branch_name','branch'); ?>
                                        </select>
                                    </div>

                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Mobile No</label>
                                            <input type="text" name="mobile_student" id="mobile_student" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Date of Birth</label>
                                            <input type="date" name="dob" id="dob" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Choose a password</label>
                                            <input type="text" name="otpPass" id="otpPass" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Vill</label>
                                            <input type="text" name="vill" id="vill" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Post Office</label>
                                            <input type="text" name="po" id="po" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Police Station</label>
                                            <input type="text" name="ps" id="ps" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Dist</label>
                                            <input type="text" name="dist" id="dist" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Block</label>
                                            <input type="text" name="block" id="block" class="uk-input">
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>Pin</label>
                                            <input type="text" name="pin" id="pin" class="uk-input" required>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2@m">
                                        <div>
                                            <label>State</label>
                                            <input type="text" name="state" id="state" class="uk-input" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="uk-margin">
                                    <input type="hidden"  id="studentId" value="0" />
                                    <button class="uk-button uk-button-primary uk-width-expand" type="submit">Sign Up</button>
                                </div>
                                <hr class="uk-margin-remove">
                                <small>
                                    Already have an account? <a href="<?= $site["url"]?>login">Login</a> now
                                </small>
                                <hr class="uk-margin-remove">
                                <span style="font-size: 9px">© English Oriental Academy 2022 | All Rights Reserved</span>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
 <?  if($_SESSION['subscription_package_data']){
        ?>
        <script type="text/javascript">
            os.setVal('class_s','<?=$_SESSION["subscription_package_data"]["classId"]?>')
            os.setVal('asession_s','<?=$_SESSION["subscription_package_data"]["asession"]?>')
            
        </script>
        <?
    }?>


    <script>
        function register_student(form){
         var formdata = new FormData(form);
         var name= formdata.get('name').trim();
         if (name==''){
            alert("please enter name.");
            return;
        }
        var mobile_student= formdata.get('mobile_student').trim();
        if (mobile_student.length<10||mobile_student.length>10){
            alert("please enter correct mobile number");
            return;
        }
        
        var otpPass= formdata.get('otpPass').trim();
        if (otpPass==''){
            alert("please enter password.");
            return;
        }
        formdata.append('mobile_student',mobile_student);
        formdata.append('otpPass',otpPass );
        formdata.append('name',name );
        var   studentId=os.getVal('studentId');
        formdata.append('studentId',studentId );
        var url='<? echo $ajaxFilePath ?>?register_student=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('student_reload_list',url,formdata);

    }

    function student_reload_list(data){
           //console.log(data);
           var d=data.split('#-#');
           var studentId=parseInt(d[0]);
           if(d[0]!='Error' && studentId>0)
           {
            os.setVal('studentId',studentId);
            window.location.href=d[2]=="NEW_ADDED"?'<?echo $site['url']?>login':'<?echo $site['url']?>login';
            // window.location.href=d[2]=="NEW_ADDED"?'<?echo $site['url']?>subscription':'<?echo $site['url']?>login';



        }
        if(d[1]!=''){alert(d[1]);}
    }


</script>
</body>
</html>


<?php
//include  __DIR__."/_partials/wt_footer.php";
?>
