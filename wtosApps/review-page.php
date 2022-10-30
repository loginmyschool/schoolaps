<?php
global $os,$pageVar;
$userId=$os->userDetails['studentId'];



$user_review=array();

$f_startDate_s= $os->showDate($os->now()); $t_startDate_s= $os->showDate($os->now());
$anddated=$os->DateQ('dated',$f_startDate_s,$t_startDate_s,$sTime='00:00:00',$eTime='23:59:59');
$dataQuery="  select * from review_details where review_details_id>0  and user_table_id='$userId'  $anddated";
$rsResults=$os->mq($dataQuery);
while($row=$os->mfa( $rsResults))
{
    $user_review[$row['parent_id']][$row['review_subject_id']]=$row;

}


$ajaxFilePath= 'review-page_ajax.php';
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$review_query="select * from review_subject where active_status='active' and parent_id=0";
$review_mq=$os->mq($review_query);
while($row=$os->mfa($review_mq)){
    $data[$row['review_subject_id']]=$row['title'];
    $subId=$row["review_subject_id"];
    ?>

    <section>
        <h2><? echo $row['title'];?></h2>
        <?
        $review_sub_query="select * from review_subject where active_status='active' and parent_id='$subId'";
        $review_sub_mq=$os->mq($review_sub_query);
        while($row2=$os->mfa($review_sub_mq)){

            $review_marks=$os->val($user_review,$row2['parent_id'],$row2['review_subject_id'],'review_marks');
            $review_note=$os->val($user_review,$row2['parent_id'],$row2['review_subject_id'],'review_note');


            $id_key=$row2['parent_id'].'_'.$row2['review_subject_id'];


            ?>
            <div class="uk-margin">
                <h4 class="uk-margin-remove primary-text-dark"><? echo $row2['title'];?></h4>


                <input value="<? echo $review_marks ?>" type="number"
                       class="range_slider"
                       id="<? echo $id_key  ?>review_marks"
                       onchange="WT_review_listEditAndSave('<? echo $row2['parent_id'] ?>','<? echo $row2['review_subject_id']?>','review_marks',this.value);"/>

                <textarea placeholder="Remark"
                          id="<? echo $id_key  ?>review_note"
                          class="uk-textarea uk-border-rounded"
                          onchange="WT_review_listEditAndSave('<? echo $row2['parent_id'] ?>','<? echo $row2['review_subject_id']?>','review_note',this.value)"><? echo $review_note ?></textarea>


            </div>

        <? }?>
    </section>
<? }?>
<!------
Range Slider
---------------->
<!--Plugin CSS file with desired skin-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
<!--Plugin JavaScript file-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

<script>
    $(".range_slider").each(function () {
        $(this).ionRangeSlider({
            min: 0,
            max: 100,
            from: $(this).val()
        })
    });
</script>
<!------
End
---------------->
<!-- <input type="button" value="Save" onclick="WT_review_detailsEditAndSave();" />
 -->

<script type="text/javascript">
    function WT_review_listEditAndSave(parent_id,review_subject_id,update_field,fieldValue)
    {
        var formdata = new FormData();


        formdata.append('parent_id',parent_id);
        formdata.append('review_subject_id',review_subject_id);
        formdata.append('update_field',update_field);
        formdata.append('fieldValue',fieldValue);




        var url='<?echo $site['url']?>wtosApps/<? echo $ajaxFilePath ?>?WT_review_listEditAndSave=OK&';

        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_review_list_detailsReLoadList',url,formdata);
    }
    function WT_review_list_detailsReLoadList(data){

    }

    /*
    function WT_review_detailsListing(){
        var formdata = new FormData();
        var userId="<?php echo $userId;?>";
    formdata.append('user_table_id',userId);
    var url='<?echo $site['url']?>wtosApps/<? echo $ajaxFilePath ?>?WT_review_detailsListing=OK';
    os.animateMe.div='div_busy';
    os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
    os.setAjaxFunc('WT_review_list_detailsResult',url,formdata);
}
function WT_review_list_detailsResult(data){
        var objJSON = JSON.parse(data);
        var objJSON2;
        for (key in objJSON){
            objJSON2=objJSON[key];
            for (key2 in objJSON2) {
                  if (objJSON2.hasOwnProperty(key2)) {
                      os.setVal(key2,objJSON2[key2]);
                  }
            }
        }
}
WT_review_detailsListing();*/
</script>
