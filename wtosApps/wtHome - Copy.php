<?
global $os, $site, $pageBody;
$ajaxFilePath =$site['url'].'wtosApps/wtAjax.php';
 

?>

<? echo stripslashes($os->wtospage['pageCss']); ?>
<div>


    <div uk-slideshow="animation: scale;autoplay:true;autoplay-interval: 6000; pause-on-hover: true; min-height: 300; max-height: 400">


        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" >
            <ul class="uk-slideshow-items">
                <?
                $bannerImageQuery="select * from bannerimage where bannerImageId>0  and active='Active'  order by priority  ";
                $bannerImageMq=$os->mq($bannerImageQuery);
                while($bannerImageData=$os->mfa($bannerImageMq))
                {
                    ?>
                    <li>
                        <img style="height:350px;" src="<? echo $site['url']?><? echo $bannerImageData['image'];  ?>" alt="<? echo $bannerImageData['imageTitle'];  ?>" uk-cover>
                    </li>

                    <?}?>

                </ul>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
            </div>
            <ul class="uk-slideshow-nav uk-dotnav uk-flex-center " style="margin:5px 0px 10px 0px;"></ul> <!--uk-margin-->
        </div>
    </div>
    <section class="uk-section" style="padding-top:0px;">
        <div class="uk-container" >
            <div uk-grid>

                <div class="uk-width-expand">
				

                    <div class="uk-margin-large">
					<? echo $pageBody;?>
                       
                    </div>
                    

                    <div class="uk-margin-large">


                        <div>
                            <h3 class="uk-text-bold">Subscriptions</h3>
                            <div class="uk-child-width-1-2@m uk-child-width-1-2@s uk-grid-match" uk-grid>
                              <?
                              $subscriptions_query = $os->mq("select  ss.*, s.subscription_id ,s.online_class as is_online_class, s.online_exam as is_online_exam from subscription_structure ss
                                LEFT JOIN subscription s ON s.studentId='{$os->userDetails['studentId']}' AND  s.subscription_structure_id=ss.subscription_structure_id
                                where ss.subscription_structure_id>0 and ss.active_status='active' and ss.is_featured='Yes' order by ss.classId ASC");
                              while ($sub_str_data = $os->mfa($subscriptions_query)){
                                  $is_subscribed = $sub_str_data["subscription_id"]>0;
                                  $price = 0;
                                  $price=$sub_str_data['online_class']+$sub_str_data['online_exam'];
                                  // _d($sub_str_data);

                                  ?>
                                  <div>
                                    <div class="uk-card uk-card-default border-radius-m uk-position-relative">

                                        <div class="uk-card-body uk-text-center">
                                            <h4 class="uk-text-primary"><?= $sub_str_data['title']?></h4>


                                           <!--  <h3 class="uk-text-bold">₹<?= $price?><span class="uk-text-small">/yr</span></h3>
                                            <p class="<?=$sub_str_data['full_package_discount']>0?'':'uk-hidden'?>">Full Package ₹<?= $sub_str_data['full_package_discount']?><span class="uk-text-small"> Off</span></p>
                                            <p class="<?=$sub_str_data['online_exam_discount']>0?'':'uk-hidden'?>">Online Exam ₹<?= $sub_str_data['online_exam_discount']?><span class="uk-text-small"> Off</span></p> -->

                                            <?
                                            if($is_subscribed){
                                                ?>
                                                <div class="uk-position-absolute uk-position-top-right  uk-label-success uk-text-small p-xs p-left-m p-right-m" style="top: 10px; border-radius: 20px 0 0 20px">Subscribed <i uk-icon="check"></i></div>

                                                <div class="uk-grid-small uk-child-width-expand" uk-grid>


                                                    <? if($sub_str_data["is_online_class"]==1){?>
                                                        <div>
                                                            <a class="uk-button uk-button-secondary uk-border-pill uk-width-expand" href="<?= $site["url"]?>e-class?class=<?= $sub_str_data["classId"]?>">Online Class</a>
                                                        </div>
                                                        <?}?>
                                                        <? if($sub_str_data["is_online_exam"]==1){?>
                                                            <div>
                                                                <a class="uk-button uk-button-secondary uk-border-pill uk-width-expand" href="<?= $site["url"]?>OnlineExam">Online Exam</a>
                                                            </div>
                                                            <?}?>
                                                        </div>

                                                        <?} else {?>

                                                           <?if($sub_str_data['is_full_package']==1){?> <a class="uk-button uk-button-primary uk-margin-small-bottom uk-border-pill uk-width-expand "  href="javascript:void(0)" onclick="set_subs_str('<?=$sub_str_data["subscription_structure_id"]?>','<?=$sub_str_data["classId"]?>','<?=$sub_str_data["asession"]?>','full_package','<?= $price?>')">Full Package ( ₹<?= $price?> )  Subscribe Now</a>
                                                           <?}?>
                                                           <?if($sub_str_data['is_exam_only']==1){?> <a class="uk-button uk-button-primary uk-border-pill uk-width-expand uk-margin-small-bottom "  href="javascript:void(0)" onclick="set_subs_str('<?=$sub_str_data["subscription_structure_id"]?>','<?=$sub_str_data["classId"]?>','<?=$sub_str_data["asession"]?>','only_exam',<?= $sub_str_data['online_exam']?>)">Only Exam ( ₹<?= $sub_str_data['online_exam']?> ) Subscribe Now</a>
                                                           <?}?>

                                                           <a class="uk-button uk-button-danger uk-border-pill uk-width-expand " href="javascript:void(0)" onclick="set_subs_str(0,'<?=$sub_str_data["classId"]?>','<?=$sub_str_data["asession"]?>','free_trial',0)">Get A Free Trial</a>
                                                           <?}?>

                                                       </div>
                                                   </div>
                                               </div>
                                               <?}?>
                                           </div>
                                       </div>

                                   </div>
                                   <div class="uk-margin-large">
                                    
                                </div>



                            </div>
                            <div class="uk-visible@m " style="width: 300px">
                                <?php include('wtRightPanelNotice.php'); ?>
                                <?php include('wtRightPanelPhotoGalary.php'); ?>
                                <?php include('wtRightPanelNewsEvents.php'); ?>
                            </div>
                        </div>
                    </div>


                </section>
                <script type="text/javascript">
                    const set_subs_str=(subscription_structure_id,classId,asession,type,amount)=>{
                        // if(confirm("Are you sure?")==false)
                        //     return false; 
                        var formdata = new FormData();
                        formdata.append('subscription_structure_id',subscription_structure_id); 
                        formdata.append('classId',classId);
                        formdata.append('asession',asession);
                        formdata.append('type',type);
                        formdata.append('amount',amount);  
                        var url='<? echo $ajaxFilePath ?>?set_subs_str=OK&';
                        os.animateMe.div='div_busy';
                        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
                        os.setAjaxFunc('reload_list',url,formdata);

                    }
                    const reload_list=(data)=>{
                    window.location.href='<?echo $site['url']?>login';
                        // console.log(data)
                    }
                </script>
