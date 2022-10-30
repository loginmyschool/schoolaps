<?
global $site, $os;
//$site['themePath-apps']=$site['themePath'].'mrchow-app/';
$ajaxFilePath =$site['url'].'wtosApps/wtAjax.php';


if($os->isLogin() )
{
    header("Location: ".$site['url']."myprofile");
    exit();
}
?>

<div class="uk-width-medium uk-margin-auto">
    <h3>Please Login to continue</h3>
    <div class="uk-margin">
        <input onFocus="this.style.borderColor='#666666'" class="uk-input uk-border-rounded" id="login_username" type="text" placeholder="Registration Number">
    </div>
    <div class="uk-margin">
    <input onFocus="this.style.borderColor='#666666'" class="uk-input uk-border-rounded" id="login_passcode" type="password" placeholder="Password">
    </div>

    <div style="text-align: right">
        <button type="submit" id="div_busy" onClick="simple_login_ajax()">Login</button>
    </div>
    <hr>
    <small>
        Facing trouble? contact to branch
    </small>
    <hr>
    <span style="font-size: 9px">&copy; English Oriental Academy 2022 | All Rights Reserved</span>

</div>
<script>
    function getData(string,seperator)
    {
        var D=string.split(seperator);
        return D[1];
    }
</script>
<script>
    function simple_login_ajax()
    {
        var login_username= os.getVal('login_username');
        var login_passcode= os.getVal('login_passcode');

        var formdata = new FormData();
        formdata.append('login_username',login_username );
        formdata.append('login_passcode',login_passcode );
        formdata.append('simple_login_ajax','OK' );
        var url='<?= $ajaxFilePath;?>?simple_login_ajax=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please wait...';
        os.setAjaxFunc('simple_login_result',url,formdata);

        document.querySelector("#div_busy").disabled=true;
    }
    function simple_login_result(data)
    {
        var Login_process_result=	getData(data,'##--Login_process_result--##');
        var Login_process_redirect=	getData(data,'##--Login_process_redirect--##');
        if(Login_process_result==='Success')
        {
            //console.log(data);
            window.location =Login_process_redirect;
        }
        else
        {
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





