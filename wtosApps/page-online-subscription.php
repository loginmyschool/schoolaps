<?php
include "_partials/wt_header.php";
global $os,$site,$pageVar;
$ajaxFilePath= $site['url'].'wtosApps/'.'online_subscription_ajax.php';
$loadingImage=$site['url-wtos'].'images/loading_new.gif';
?>
<style type="text/css">

    .item{
        float: left;
        margin: 15px;
    }
</style>
<div id="wt-page-header" class="uk-background-muted p-top-m p-bottom-m border-none border-bottom-xxs uk-visible@s" style="border-color: #eeeeee">
    <div class="uk-container">
        <span class="text-xl uk-text-secondary"><?=$os->wtospage['title']?></span>
    </div>
</div>
<section class="uk-section">
    <div class="uk-container">
        <div class="uk-child-width-1-3@m uk-child-width-1-2@s uk-grid-match" uk-grid>
            <?
            $subscriptions_query = $os->mq("select  *from subscription_structure where subscription_structure_id>0 and active_status='active' order by classId ASC");
            while ($sub_str_data = $os->mfa($subscriptions_query)){
                $price = 0;
                $price=$sub_str_data['online_class']+$sub_str_data['online_exam'];
                ?>
                <div>
                    <div class="uk-card uk-card-default border-radius-m" style="display: flex; flex-direction: column">
                        <div class="uk-card-header uk-text-center">
                            <h4 class="uk-text-primary"><?= $sub_str_data['title']?></h4>
                            <!-- <p><?= $sub_str_data['title']?></p> -->
                            <h2 class="uk-text-bold">₹<?= $price?><span class="uk-text-small">/yr</span></h2>

                        </div>

                        <div class="uk-card-body uk-margin-remove" style="flex: 1">
                            <h5 class="uk-margin-remove" style="text-transform: capitalize"> <!-- <?= ucfirst(strtolower($subject["subjectName"]))?> -->Subscription Details</h5>
                            <table class="uk-width-expand uk-text-small uk-margin-bottom uk-margin-small-top" style="border-collapse: collapse">

                                <?if($sub_str_data["online_class"]>0){?>
                                    <tr>
                                        <td style="width: 20px" class="uk-text-success">
                                            <span uk-icon="check"></span>
                                        </td>
                                        <td class="p-left-m">Online Class</td>
                                        <td class="uk-text-right uk-text-primary"><?= $sub_str_data["online_class"]?"₹".$sub_str_data["online_class"]."/yr":""?></td>
                                    </tr>
                                <?}?>
                                <?if($sub_str_data["online_exam"]>0){?>
                                    <tr>
                                        <td style="width: 20px" class="uk-text-success">
                                            <span uk-icon="check"></span>
                                        </td>
                                        <td class="p-left-m">Online Exam</td>
                                        <td class="uk-text-right uk-text-primary"><?= $sub_str_data["online_exam"]?"₹".$sub_str_data["online_exam"]."/yr":""?></td>
                                    </tr>
                                <?}?>
                                <tr>
                                    <td style="width: 20px" class="uk-text-success">
                                        <span uk-icon="check"></span>
                                    </td>
                                    <td class="p-left-m">Full Package Amount</td>
                                    <td class="uk-text-right uk-text-primary">
                                        <?= $sub_str_data["full_package_amt"]?"₹".$sub_str_data["full_package_amt"]."/yr":""?></td>
                                </tr>
                                <?if($sub_str_data["full_package_discount"]>0){?>
                                <tr>
                                    <td style="width: 20px" class="uk-text-success">
                                        <span uk-icon="check"></span>
                                    </td>
                                    <td class="p-left-m">Full Package Discount</td>
                                    <td class="uk-text-right uk-text-primary">
                                        <?= $sub_str_data["full_package_discount"]?"₹".$sub_str_data["full_package_discount"]."/yr":""?></td>
                                </tr>
                                <?}?>
                                <?if($sub_str_data["online_exam_discount"]>0){?>
                                <tr>
                                    <td style="width: 20px" class="uk-text-success">
                                        <span uk-icon="check"></span>
                                    </td>
                                    <td class="p-left-m">Online Exam Discount</td>
                                    <td class="uk-text-right uk-text-primary">
                                        <?= $sub_str_data["online_exam_discount"]?"₹".$sub_str_data["online_exam_discount"]."/yr":""?></td>
                                </tr>
                                <?}?>
                                <!-- <tr>
                                            <td style="width: 20px" class="uk-text-success">
                                                <span uk-icon="check"></span>
                                            </td>
                                            <td class="p-left-m">Discount Form</td>
                                            <td class="uk-text-right uk-text-primary">
                                             <?= $sub_str_data["discount_form_date"]?$os->showDate($sub_str_data["discount_form_date"]):""?></td>
                                         </tr>
                                         <tr>
                                            <td style="width: 20px" class="uk-text-success">
                                                <span uk-icon="check"></span>
                                            </td>
                                            <td class="p-left-m">Discount To</td>
                                            <td class="uk-text-right uk-text-primary">
                                                <?= $sub_str_data["discount_to_date"]?$os->showDate($sub_str_data["discount_to_date"]):""?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20px" class="uk-text-success">
                                                <span uk-icon="check"></span>
                                            </td>
                                            <td class="p-left-m">Discount Text</td>
                                            <td class="uk-text-right uk-text-primary">
                                                <?= $sub_str_data["discount_text"]?$sub_str_data["discount_text"]:""?>
                                            </td>
                                        </tr> -->
                            </table>
                        </div>
                        <div class="uk-card-footer">
                            <a class="uk-button uk-button-primary uk-border-pill uk-width-expand" href="<?= $site["url"]?>subscription">Subscribe Now</a>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>


    </div>
</section>
<div class="uk-container uk-margin-auto inner-content uk-margin uk-hidden">

    <div class="container">
        <div class="item">
            <label></label>
            <select name="class" id="class_s" class="textbox fWidth uk-select" >
                <option value="">Select Class </option>
                <?$os->onlyOption($os->classList);?>
            </select>

        </div>
        <div class="item">
            <label></label>
            <select name="asession" id="asession_s" class="textbox fWidth uk-select">
                <option value="">Select Session </option>
                <?
                $os->optionsHTML('','idKey','title','accademicsession','status="active"'); ?>
            </select>
        </div>
        <div class="item">
            <button class="sub_button uk-button uk-button-primary" onclick="show_subscription_structure()">Search</button>
        </div>
    </div>

    <div id="sub_str_list"></div>
</div>
<script type="text/javascript">
    show_subscription_structure();
    function show_subscription_structure(){
        var   asession_s=os.getVal('asession_s');
        var   class_s=os.getVal('class_s');
        var formdata = new FormData();
        formdata.append('class_s',class_s);
        formdata.append('asession_s',asession_s);
        var url='<? echo $ajaxFilePath ?>?subscription_structure_Listing=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('sub_str_list',url,formdata);
    }

</script>
<? include "_partials/wt_footer.php"; ?>
