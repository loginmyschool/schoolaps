<?php
global $site, $os;

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
<body class="uk-background-muted uk-flex uk-flex-middle uk-flex-center uk-padding">
<div class="uk-container-small uk-card uk-card-default" style="flex: 1;">
    <div class="uk-grid-match uk-grid-collapse" uk-grid>
        <div class="uk-width-expand@s uk-visible@s">
            <div class="uk-card uk-card-body uk-light uk-flex uk-flex-middle uk-flex-center uk-background-muted" >
                <a href="<? echo $site['url'] ?>"> <img src="<?php  echo $site['url'].$record['logoimage']; ?>" class="uk-width-medium---" style="height:auto; width:auto;"/> </a>
            </div>

        </div>
        <div class="uk-width-expand@s">
            <div class=" uk-card-body">
                <form onSubmit="event.preventDefault(); simple_login_ajax();">
                    <h3 class="uk-text-center">Login</h3>
                    <div class="uk-margin-small">
                        <label>Username</label>
                        <input onFocus="this.style.borderColor=null" class="uk-input" id="login_username" type="text" required>
                    </div>
                    <div class="uk-margin-small">
                        <label>Password</label>
                        <input onFocus="this.style.borderColor=null" class="uk-input" id="login_passcode" type="password" required>
                    </div>

                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary uk-width-expand" type="submit" id="div_busy">Login</button>
                    </div>
                    <hr class="uk-margin-remove">
                   <!-- <small>
                        Don't have an account? <a href="<?= $site["url"]?>signup">Create one</a>
                    </small>&nbsp;&nbsp;-->
                     <small >
                        <a href="<?= $site["url"]?>forget-password"><span class="uk-text-danger">Forget Password?</span></a> 
						&nbsp;  <a href="<?= $site["url"]?>"><span class="">Home</span></a> 
                    </small>
                    <hr class="uk-margin-remove">
                    <span style="font-size: 9px"><?php echo $record['school_name']?></span>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function simple_login_ajax()
    {
        var login_username= os.getVal('login_username');
        var login_passcode= os.getVal('login_passcode');

        var formdata = new FormData();
        formdata.append('login_username',login_username );
        formdata.append('login_passcode',login_passcode );
        formdata.append('simple_login_ajax','OK' );
        var url='<? echo $site['url']?>wtosApps/wtAjax.php?simple_login_ajax=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please wait...';
        os.setAjaxFunc('simple_login_result',url,formdata);

        document.querySelector("#div_busy").disabled=true;
    }
    function simple_login_result(data){
        var error_data=   getData(data,'##--Error--##');
        if(error_data)
            alert(error_data);
        var Login_process_result=	getData(data,'##--Login_process_result--##');
        var Login_process_redirect=	getData(data,'##--Login_process_redirect--##');
        if(Login_process_result=='Success') {
            window.location =Login_process_redirect;
        } else {
            alert('Please enter correct login details.');
            document.querySelector("body > div").classList.add("animate");
            document.querySelectorAll("body > div input").forEach(function (e){
                e.style.borderColor = "red";
            })
            setTimeout(function (){
                document.querySelector("body > div").classList.remove("animate");
            }, 820)

        }

        document.querySelector("#div_busy").innerHTML = "Login";
        document.querySelector("#div_busy").disabled=false;
    }


</script>
</body>
</html>
