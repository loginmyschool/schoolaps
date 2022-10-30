<?php
global $site, $os;
$ajaxFilePath= $site['url'].'wtosApps/'.'form_status_ajax.php';
$loadingImage=$site['url-wtos'].'images/loading_new.gif';
include "_partials/wt_header.php";

?>
<div id="wt-page-header" class="uk-background-muted p-top-m p-bottom-m border-none border-bottom-xxs uk-visible@s" style="border-color: #eeeeee">
    <div class="uk-container">
        <span class="text-xl uk-text-secondary">About Us</span>
    </div>
</div>
<?php
include "_partials/wt_precontent.php";
?>

<form onsubmit="event.preventDefault();get_form_status(this);" class="uk-margin">
    <div class="uk-child-width-1-1 uk-grid-small" uk-grid>
        <div class="uk-width-1-5@m">
            <div>
                <label>Class</label>
                <select name="class_id" id="class_id" class="textbox fWidth uk-select" required>
                    <option value=""> </option>
                    <?$os->onlyOption($os->classList);?>
                </select>

            </div>
        </div>
        <div class="uk-width-1-5@m">
            <div>
                <label>Year</label>
                <select name="year" id="year" class="textbox fWidth uk-select" required>
                    <option value=""> </option>
                    <? $os->optionsHTML('','idKey','title','accademicsession','status="active"'); ?>
                </select>
            </div>
        </div>
        <div class="uk-width-1-5@m">
            <div>
                <label>Mobile No</label>
                <input value="" type="text" name="mobile_student" id="mobile_student" class="uk-input form-field" required/>
            </div>
        </div>
        <div class="uk-width-1-5@m">
            <div>
                <label>DOB</label>
                <input value="" type="date" name="dob" id="dob" class="wtDateClass uk-input form-field" required/>
            </div>
        </div>
        <div class="uk-width-1-5@m">
            <div>
                <label>&nbsp;</label>
                <button class="uk-button uk-button-primary uk-width-expand" type="submit">Search</button>
            </div>
        </div>

        <div class="uk-margin">
            <div  class="ajaxViewMainTableTDListData" id="sub_str_list"><p class="uk-text-danger uk-text-capitalize uk-text-bold">Please select all the fields.</p></div>
        </div>
    </div>
</form>


<script>
    function get_form_status(form){
        var formdata = new FormData(form);
        if(os.check.empty('class_id','Please select class.')==false){ return false;}
        if(os.check.empty('year','Please select year.')==false){ return false;}

        var mobile_student= formdata.get('mobile_student').trim();
        if (mobile_student.length<10||mobile_student.length>10){
            alert("please enter correct mobile number");
            return;
        }
        if(os.check.empty('dob','Please enter your dob.')==false){ return false;}

        var url='<? echo $ajaxFilePath ?>?get_form_status=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('sub_str_list',url,formdata);
    }

</script>
<? include "_partials/wt_postcontent.php";?>
<? include "_partials/wt_footer.php"; ?>

