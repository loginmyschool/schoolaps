<?php
global $site, $os;
$ajaxFilePath= $site['url'].'wtosApps/'.'subscription_ajax.php';
$loadingImage=$site['url-wtos'].'images/loading_new.gif';
if(!$os->isLogin()&&(!isset($_SESSION['registration_studentId'])))
{
    header("Location: ".$site['url']."login");
}

// _d($_SESSION['subscription_package_data']);

$loginKey=$site['loginKey'];
$studentId=isset($_SESSION['registration_studentId'])?$_SESSION['registration_studentId']:$_SESSION[$loginKey]['logedUser']['studentId'];
 $max_hist_id=$os->mfa($os->mq("select max(historyId) as max_hist_id from history where historyId>0 and studentId='$studentId'"))['max_hist_id'];
 $hist_data=$os->mfa($os->mq("select * from history where historyId>0 and studentId='$studentId' and  historyId='$max_hist_id'"));
 
 $student_class=$hist_data['class'];
 $student_asession=$hist_data['asession'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oriental English Academy</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
                    <div class="uk-width-expand@s">
                        <div id="div_busy"></div>
                        <div class=" uk-card-body">
                            <h3 class="uk-text-center uk-text-primary uk-text-bold">Subscription List For Class - <?=$os->classList[$student_class]?>  And Session - <?=$student_asession?></h3>
                            <div class="uk-child-width-1-1 uk-grid-small" uk-grid>
                                <div class="uk-hidden">
                                    <label>Branch</label>
                                    <select name="branch_code" id="branch_code" class="textbox fWidth uk-select">
                                        <option value=""> </option>    
                                                <? $os->optionsHTML('1','branch_code','branch_name','branch'); ?>
                                            </select>
                                        </div>

                                        <div class="uk-width-1-2@m uk-hidden">
                                            <div>
                                                <label>Class</label>
                                                <select name="class" id="class_s" class="textbox fWidth uk-select" onchange="show_subscription_structure()">
                                                    <option value=""> </option>    
                                                    <?$os->onlyOption($os->classList,$student_class);?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="uk-width-1-2@m uk-hidden">
                                            <div>
                                                <label>Session</label>
                                                <select name="asession" id="asession_s" class="textbox fWidth uk-select" onchange="show_subscription_structure()">
                                                    <option value=""> </option>    
                                                <? $os->optionsHTML($student_asession,'idKey','title','accademicsession','status="active"'); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div  class="ajaxViewMainTableTDListData" id="sub_str_list"><p class="uk-text-danger uk-text-capitalize uk-text-bold">Please select class and session</p></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <script>
                const show_subscription_structure=()=>{
                    var   asession_s=os.getVal('asession_s');
                    var   class_s=os.getVal('class_s');
                    if(asession_s==''||class_s==''){
                        os.setHtml('sub_str_list','<p class="uk-text-danger uk-text-capitalize uk-text-bold">Please select class and session</p>')
                        return false;
                    }

                    var formdata = new FormData();
                    formdata.append('class_s',class_s);
                    formdata.append('asession_s',asession_s);
                    var url='<? echo $ajaxFilePath ?>?subscription_structure_Listing=OK&';
                    os.animateMe.div='div_busy';
                    os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
                    os.setAjaxHtml('sub_str_list',url,formdata);
                }
                show_subscription_structure();
             

            function add_subscription(form){ 
                if(confirm("Are you sure? please check your subscription carefully.")==false)
                    return false; 
                var formdata = new FormData(form);
                    if(os.getVal('total_amount')<1){
                        alert('please select at least one course.');
                        return false;
                    }
                    formdata.append('branch_code',os.getVal('branch_code')); 
                    formdata.append('studentId',os.getVal('studentId'));
                    formdata.append('classId',os.getVal('class_s'));
                    formdata.append('asession',os.getVal('asession_s'));
                    formdata.append('total_amount',os.getVal('total_amount')); 
                     formdata.append('type',os.getVal('type')); 
                      formdata.append('subscription_structure_id',os.getVal('subscription_structure_id')); 
                     
                    var url='<? echo $ajaxFilePath ?>?add_subscription=OK&';
                    os.animateMe.div='div_busy';
                    os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
                    os.setAjaxFunc('subscription_reload_list',url,formdata);

                }
                function subscription_reload_list(data){
                   var d=data.split('#-#');
                   var subscription_id=parseInt(d[0]);
                   if(d[0]!='Error' && subscription_id>0)
                   {

                    window.location.href='<?echo $site['url']?>payment';
                }
                if(d[0]=='Error'){alert(d[1]);}
            }


        </script>
    </body>
    </html>

