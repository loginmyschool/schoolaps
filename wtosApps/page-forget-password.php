<?php
//include  __DIR__."/_partials/wt_header.php";
global $site, $os;
$ajaxFilePath= $site['url'].'wtosApps/'.'forget-password_ajax.php';
$loadingImage=$site['url-wtos'].'images/loading_new.gif';
$listingQuery="  select * from school_setting where school_setting_id>0   $where      order by school_setting_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];
	$record=$os->mfa( $rsRecords)
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
                         <a href="<? echo $site['url'] ?>"><img src="<?php  echo $site['url'].$record['logoimage']; ?>" class="uk-width-medium--" style="height:auto; width:auto;"></a>
                        </div>
                    </div>
                    <div class="uk-width-expand@s">
                        <div id="div_busy"></div>
                        <div class=" uk-card-body">
                            <form onSubmit="event.preventDefault(); set_password(this);">
                                <h3 class="uk-text-center">Forget Password</h3>
                                <div class="uk-margin-small">
                                    <div>
                                        <label>Full Name</label>
                                        <input type="text" name="name" id="name" class="uk-input" required>
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <div>
                                        <label>Mobile No</label>
                                        <input type="text" name="mobile_student" id="mobile_student" class="uk-input" required>
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <div>
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" id="dob" class="uk-input" required>
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <div>
                                        <label>Choose a password</label>
                                        <input type="text" name="otpPass" id="otpPass" class="uk-input" required>
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <div>
                                        <label>Re enter password</label>
                                        <input type="text" name="re_otpPass" id="re_otpPass" class="uk-input" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <button class="uk-button uk-button-primary uk-width-expand" type="submit">Save</button>
                                </div>
                                <hr class="uk-margin-remove">
                                <small>
                                     Go To <a href="<?= $site["url"]?>login"> Log In</a>  &nbsp;  <a href="<?= $site["url"]?>"><span class="">Home</span></a> 
                                </small>
                                <hr class="uk-margin-remove"> 
                                <span style="font-size: 9px"><?php echo $record['school_name']?> | All Rights Reserved</span>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script>
        function set_password(form){
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
        var re_otpPass= formdata.get('re_otpPass').trim();
        if (re_otpPass==''){
            alert("please enter re enter password.");
            return;
        }
        if(otpPass!==re_otpPass){
            alert('please use same password.');
            return;
        }


        formdata.append('mobile_student',mobile_student);
        formdata.append('otpPass',otpPass );
        formdata.append('name',name );
        var url='<? echo $ajaxFilePath ?>?set_password=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('student_reload_list',url,formdata);

    }

    function student_reload_list(data){
       alert(data);
   }


</script>
</body>
</html>


<?php
//include  __DIR__."/_partials/wt_footer.php";
?>
