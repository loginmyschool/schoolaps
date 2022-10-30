<?php
global $os,$site, $pageVar;
include __DIR__."/_partials/wt_header.php";

// if(! $os->isLogin() )
if(!$os->isLogin()&&(!isset($_SESSION['registration_studentId']))){
    header("Location: ".$site['url']."login");
    ?>
    <script>
        window.location.href="/login";
    </script>
    <?
    exit();
}else{



    

    $studentId=$os->userDetails['studentId'];
    $name=$os->userDetails['name'];
    $image = $os->userDetails['profile_picture'];
    $asession=date('Y');
    $student_query=" select s.*, h.* from  history h ,student s  where s.studentId='$studentId'  and s.studentId= h.studentId  order by  h.asession desc limit 1 ";
    $rsResults=$os->mq($student_query);
    $student_rec=$os->mfa( $rsResults) ;
	
	//_d( $student_rec);

    $profile_image = $site['url-image'].$student_rec['profile_picture'];
	//_d( $profile_image);
    //_d($student_rec);
    $pagecontentLinks_login=$os->get_pagecontent('seoId ,	externalLink, title  , pagecontentId , openNewTab ',"active=1 and parentPage>0 and  login_access='1' and seoId!='myprofile'  "," priority asc ",'','');
    //echo $os->query;
    ?>


    <div class="uk-background-muted  uk-margin-large-top">
        <section class="uk-text-center uk-light uk-overflow-hidden">
        <div class="uk-padding"
        style="backdrop-filter: blur(10px); background-color: rgba(0,0,0,0.4)">
        <div class="uk-position-relative uk-margin-auto uk-border-circle  uk-overflow-hidden" style="height: 190px; width: 190px">
            <img class="uk-width-1-1 uk-height-1-1"
            alt="<?= $name ?>"
            src="<?=$profile_image?>" id="profile_picture_image" style="object-fit: cover; object-position: center"/>
            <input type="file" class="uk-hidden" id="profile_picture" onchange="change_profile_picture(this.files[0])">
            <script>
                function change_profile_picture(file){
                    if (confirm("Are you sure?")){
                        var fd = new FormData();
                        fd.append("profile_picture", file);
                        fd.append("change_profile_picture", "OK");

                        var url='<? echo $site["themePath"]?>wtAjax.php?change_profile_picture=OK&';
                        // os.animateMe.div='div_busy';
                        os.animateMe.html='Please Wait..';
                        os.setAjaxFunc((res)=>{
                            if (res!="0"){
                                document.querySelector("#profile_picture_image").src = res;
                            }
                        }, url, fd);
                    }
                }
            </script>
            <label for="profile_picture"
            class="uk-position-absolute uk-position-bottom-left p-m uk-display-block uk-width-1-1 uk-text-center text-m uk-text-primary uk-light pointable"
            style="background-color: rgba(0,0,0,0.5)">

            Change Picture

        </label>
    </div>
    <h2 class="uk-margin-remove-bottom uk-margin-small-top uk-h2 uk-text-bolder"><? echo  $name; ?></h2>
    <img src="<?= $site["url"]."barCode/".$student_rec["uid"]?>-ean13.jpg" alt="" class="uk-hidden">
    <p class="uk-margin-remove">
        Class : <i class="secondory-text"><?= $os->classList[$student_rec["class"]] ?>-<?= $student_rec["asession"]?></i>,
        Roll No: <i class="secondory-text"><?= $student_rec["roll_no"] ?></i>
    </p>
            <a href="<? echo $site['url']?>?logout=logout"><span class="uk-text-danger uk-text-bold">Log Out</span></a>

</div>
</section>

<section class="uk-section-muted uk-section">
    <!--icons buttons-->
    <?
    $profile_icons =
    [
                    95 =>"Open Book.svg", //E-Class
                    86 =>"Teacher Desk.svg", //Attendence
                    87 =>"Online LEarning.svg", //Fees
                    93 =>"Test.svg", //Online Exam
                    85 =>"Certificate.svg", //Result
                    88 =>"Library.svg", //Library
                    91 =>"PDF.svg", //Review
                    96 =>"Theatre.svg", //Curriculum
                    97 =>"Boy Student.svg", //Health
                    98 =>"Open Book.svg", //Applications
                    99 =>"Boy Graduation.svg", //Scholarship
                    106 =>"Online LEarning.svg", //Fees
                    120 =>"Open Book.svg", //Fees

                 ];
                 ?>
                 <div class="uk-container uk-container-small">
                    <h4 class="uk-text-bold">QUICK ACTIONS</h4>
                    <div class="uk-grid uk-grid-match  uk-child-width-1-3 uk-child-width-1-4@s uk-child-width-1-5@m uk-grid-small" uk-grid>

                        <?  while($page=$os->mfa($pagecontentLinks_login))

                        {

                            if($page['title']=="Logout"){
                                continue;
                            }
                            $pageSeoLink=($page['externalLink']=='')?$os->sefu->l($page['seoId']):$pageSeoLink=$page['externalLink'];
                            ?>
                            <div>
                                <a class="uk-card uk-card-outline uk-card-default uk-card-hover uk-link-reset uk-card-small"
                                onclick="window.location.href='<? echo $pageSeoLink ?>'">
                                <div class="uk-card-body uk-text-center ">

                                    <img  src="<?=$site["url"]?>wtosApps/images/education/Education Color/SVG/<?=$profile_icons[$page['pagecontentId']]?>" style="width: 60px; margin:auto">

                                    <p class="uk-margin-small uk-margin-remove-bottom uk-text-small">
                                        <? echo $page['title'] ?>
                                    </p>

                                </div>
                            </a>
                        </div>
                    <? } ?>

                </div>


                <h4 class="uk-text-bold">Profile Details</h4>
                <div class="uk-grid uk-child-width-1-2@m" uk-grid>
                    <div>
                        <div class="uk-card uk-card-outline uk-card-default">
                            <div class="uk-card-body">
                                <h2 class="text-xl uk-text-bolder" href="#">Academic Information</h2>
                                <table class="uk-table uk-table-tiny uk-table-justify">
                                    <tr>
                                        <td >DOB</td>
                                        <td class=" uk-table-shrink">
                                            <?= $os->showDate($student_rec['dob'])?></td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td class=""><?= $student_rec['gender']?></td>
                                        </tr>

                                        <tr>
                                            <td>Section</td>
                                            <td class=""><?= $student_rec['section']?></td>
                                        </tr>
                                        <tr>
                                            <td>Session</td>
                                            <td class=""><?= $student_rec['asession']?></td>
                                        </tr>
                                        <tr>
                                            <td>Class</td>
                                            <td class=""><?= $os->classList[$student_rec['class']]?></td>
                                        </tr>
                                        <tr style="display:none;">
                                            <td>Stream</td>
                                            <td class=""><?= $student_rec['stream']?></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-outline uk-card-default">
                                <div class="uk-card-body">
                                    <h2 class="text-xl uk-text-bolder" href="#">Personal Information</h2>
                                    <table class="uk-table uk-table-tiny uk-table-justify">
                                        <tr>
                                            <td  nowrap="">Father's Name</td>
                                            <td class="uk-table-shrink"><?= $student_rec['father_name']?></td>
                                        </tr>

                                        <tr>
                                            <td  nowrap="">Mother's Name</td>
                                            <td class=""><?= $student_rec['mother_name']?></td>
                                        </tr>
                                        <tr>
                                            <td  nowrap="">Guardian Name</td>
                                            <td class=""><?= $student_rec['guardian_name']?></td>
                                        </tr>
                                        <tr>
                                            <td  nowrap="">Father Occupation</td>
                                            <td class=""><?= $student_rec['father_ocu']?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-outline uk-card-default">
                                <div class="uk-card-body">
                                    <h2 class="text-xl uk-text-bolder" href="#">Contact Information</h2>
                                    <table class="uk-table uk-table-tiny uk-table-justify">
                                        <tr>
                                            <td nowrap="">Email</td>
                                            <td class="uk-table-shrink"><?= $student_rec['email_student']?></td>
                                        </tr>

                                        <tr>
                                            <td  nowrap="">Mobile</td>
                                            <td class=""><?= $student_rec['mobile_student']?></td>
                                        </tr>

                                        <tr>
                                            <td  nowrap="">Village</td>
                                            <td class=""><?= $student_rec['vill']?></td>
                                        </tr>
                                        <tr>
                                            <td  nowrap="">Post Office</td>
                                            <td class=""><?= $student_rec['po']?></td>
                                        </tr>
                                        <tr>
                                            <td  nowrap="">Police Station</td>
                                            <td class=""><?= $student_rec['ps']?></td>
                                        </tr>

                                        <tr>
                                            <td  nowrap="">District</td>
                                            <td class=""><?= $student_rec['dist']?></td>
                                        </tr>
                                        <tr>
                                            <td  nowrap="">Block</td>
                                            <td class=""><?= $student_rec['block']?></td>
                                        </tr>
                                        <tr>
                                            <td  nowrap="">State</td>
                                            <td class=""><?= $student_rec['state']?></td>
                                        </tr>
                                        <tr>
                                            <td  nowrap="">Pin</td>
                                            <td class=""><?= $student_rec['pin']?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <? }

    include __DIR__."/_partials/wt_footer.php";

    ?>
