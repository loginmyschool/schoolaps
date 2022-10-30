<?
include('wtosConfigLocal.php');
global $site, $os, $selected_branch_code;
include($site['root-wtos'].'top.php');
?>
<?
$name=$os->userDetails['name'];
$address=$os->userDetails['address'];
//$os->userDetails['image']='wtosApps/images/learning/svg/007-elearning.svg';
$mobile=$os->userDetails['username'];
$teacher_rs= $os->get_teacher('',"  mobile='$mobile' ");
if($teacher_rs){
    $teacher= $os->mfa($teacher_rs);
}

global $enable_static_menu,$enable_new_menu, $selected_branch_code;
$menu = get_menu($selected_branch_code);

function populate_menu_grid($parent=0, $level=1){

    global $menu, $site, $os;
    $colors = ["#fffdd1", "#ececec"];
    $level = $level==0?1:0;
    foreach ($menu[$parent] as $item){
        if(isset($menu[$item['admin_menu_id']])){
            ?>
            <div class="uk-width-1-1 ">
                <div class="uk-padding-small uk-box-shadow-small" style="background-color: <?=$colors[$level]?>">
                    <ul class="uk-margin-remove-bottom" uk-accordion >
                        <li>
                            <a class="uk-accordion-title" href="#"><?=$item['title']?></a>
                            <div class="uk-accordion-content">
                                <div class="uk-grid uk-grid-small uk-grid-match uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>
                                    <? populate_menu_grid($item['admin_menu_id'], $level) ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <?
        } else {
            ?>
            <div>
                <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">
                    <a class="uk-text-center uk-link-reset " href="<?=$site['url-wtos'].$item['page_name']?>">
                        <div class="uk-border-circle circle-icon" >
                            <img  src="<? getIcon(str_replace(".php","", $item['page_name']));?>" style="width: 55px">
                        </div>
                        <span class="p-top-m" style="display: block"><?=$item['title']?></span>
                    </a>
                </div>
            </div>
            <?
        }
    }

}

?>


<div>


    <div class="uk-text-center uk-light"
         style="background-image: url('https://picsum.photos/3000/2000');
             background-size: cover; background-attachment: fixed">
        <div style="backdrop-filter: blur(10px); background-color: rgba(0,0,0,0.4)" class="uk-padding-large">
            <img class=" uk-border-circle"
                 alt="<?= $name ?>"
                 src="<?=$site['url'].$os->userDetails['image'];?>"
                 style="object-fit: cover; height: 170px; width: 170px"/>
            <h2 class="uk-margin-remove-bottom uk-margin-small-top"><? echo  $name; ?></h2>

            <p class="uk-margin-remove">
                <i class="secondory-text"><?= $address ?></i>,
            </p>
            <form name="chose_branch"
                  action=""
                  method="post"
                  class="uk-margin-small uk-margin-auto">
                <div class="uk-inline">
                    <select name="selected_branch_code_option"
                            id="selected_branch_code_option"
                            class="uk-select congested-form uk-border-rounded select2" >
                        <option value="">Select Branch</option>
                        <? $os->onlyOption(get_branches(true, true),$selected_branch_code);?>
                    </select>
                    <input type="hidden" name="branch_selection" value="OKK" />
                </div>
                <button type="submit"
                        value="Select"
                        class="uk-button congested-form uk-button-primary uk-border-rounded">
                    Select
                </button>
            </form>
        </div>
    </div>


    <section class="uk-section">
        <div class="uk-container">
            <div>
                <!--icons buttons-->
                <?
                $profile_icons = array(

                    "007-elearning.svg", //E-Class
                    "023-wenibar.svg", //Attendence
                    "038-journal.svg", //Fees
                    "009-exam.svg", //Online Exam
                    "005-best.svg", //Result
                    "016-books.svg", //Library
                    "020-help.svg", //Review
                    "039-pencil.svg", //Curriculum
                    "026-student.svg", //Health
                    "019-elearning.svg", //Applications
                    "048-idea.svg" //Scholarship
                );
                $pageIcons = Array(
                    "dashBoard"=>"home.png",
                    "report_statistics_data"=>"stats_pie_chart.png",
                    "historyDataView"=>"address_book.png",
                    "dbbackupDataView"=>"wizard.png",
                    "teacherDataView"=>"administrator.png",
                    "accademicsessionDataView"=>"calendar.png",
                    "subject_setting_data_view"=>"view_mode_list.png",
                    "vehicle_setting_data_view"=>"metrics3.png",
                    "fees_setting_data_view"=>"paste.png",
                    "global_setting_data_view"=>"world.png",
                    "certificate_templateDataView"=>"view_mode_list.png",
                    "hostel_room_bed_data_view"=>"apps.png",
                    "hostelroom_setting_data_view"=>"network.png",
                    "global_templateDataView"=>"windows.png",
                    "exam_setting_data_view"=>"clipboard.png",
                    "question_paper_entry_data_view"=>"document.png",
                    "result_entry_setting_data_view"=>"lock_open.png",
                    "result_entry_data_view"=>"fountain_pen.png",
                    "school_settingDataView"=>"thecnical_wrench.png",
                    "pageContent"=>"window.png",
                    "contactusList"=>"address_book.png",
                    "bannerimageList"=>"pyramid.png",
                    "gallerycatagoryDataView"=>"overlapping_squares.png",
                    "photogalleryDataView"=>"camera.png",
                    "newsDataView"=>"calendar_year.png",
                    "wtboxList"=>"checkbox_empty.png",
                    "careerDataView"=>"paper_plane.png",
                    "account_headDataView"=>"woman.png",
                    "expense-page"=>"book2.png",
                    "budget-page"=>"light_bulb_on.png",
                    "otherpaymentDataView"=>"currency_dollar_sign.png",
                    "review_subjectDataView"=>"document.png",
                    "review_detailsDataView"=>"document.png",
                    "salaryDataView"=>"document.png",
                    "online_formDataView"=>"document.png",
                    "admission_admin_data_view"=>"add.png",
                    "re_admission_admin_data_view"=>"reload.png",
                    "bookDataView"=>"book.png",
                    "book_purchase_data_view"=>"clip.png",
                    "book_shelf_data_view"=>"view_mode_details.png",
                    "book_issue_data_view"=>"book.png",
                    "attendenceDataView"=>"calendar_day.png",
                    "teacherAttendenceDataView"=>"calendar_day.png",
                    "report_admission_readmission"=>"view_mode_average_icons.png",
                    "report_student_result"=>"view_mode_average_icons.png"
                );
                $missing= [];
                function getIcon($page=""){
                    global $pageIcons;
                    global $site;
                    global $missing;
                    if(isset($pageIcons[$page])){
                        print $site["url-wtos"]."images/nav_icons/".$pageIcons[$page];
                    } else {
                        $missing[$page] = $page;
                        global $profile_icons;
                        $s = sizeof($profile_icons)-1;
                        print $site["url"]."wtosApps/images/learning/svg/".$profile_icons[rand(0, $s)];
                    }
                }
                ?>





                <? if($enable_new_menu){?>



                    <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>

                        <?
                        populate_menu_grid();

                        ?>
                    </div>
                <?  } ?>

                <? if($enable_static_menu){ ?>

                    <div class="uk-margin">
                        <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>
                            <? if($os->checkAccess('Home')){ ?>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                        <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>dashBoard.php">
                                            <div class="uk-border-circle circle-icon" >
                                                <img  src="<? getIcon("dashBoard");?>" style="width: 55px">
                                            </div>
                                            <span class="p-top-m" style="display: block">Home</span>
                                        </a>

                                    </div>
                                </div>
                            <?  } ?>
                            <? if($os->checkAccess('Statistics')){ ?>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">
                                        <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>report_statistics_data.php">
                                            <div class="uk-border-circle circle-icon" >
                                                <img  src="<? getIcon("report_statistics_data");?>" style="width: 55px">
                                            </div>
                                            <span class="p-top-m" style="display: block">Statistics</span>
                                        </a>

                                    </div>
                                </div>
                            <?  } ?>
                            <? if($os->checkAccess('Student Register')){ ?>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                        <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>historyDataView.php">
                                            <div class="uk-border-circle circle-icon" >
                                                <img  src="<? getIcon("historyDataView");?>" style="width: 55px">
                                            </div>
                                            <span class="p-top-m" style="display: block">Student Register</span>
                                        </a>

                                    </div>
                                </div>
                            <?  } ?>
                            <? if($os->checkAccess('Backup')){ ?>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                        <a class="uk-text-center uk-link-reset "ref="<? echo $site['url-wtos'] ?>dbbackupDataView.php">
                                            <div class="uk-border-circle circle-icon" >
                                                <img  src="<? getIcon("dbbackupDataView");?>" style="width: 55px">
                                            </div>
                                            <span class="p-top-m" style="display: block">Backup</span>
                                        </a>
                                    </div>

                                </div>
                            <?  } ?>
                        </div>

                    </div>
                    <? if($os->checkAccess('Users') ){ ?>
                        <div class="uk-margin">

                            <div class="uk-width-1-1">
                                <h3 >Users</h3>
                            </div>
                            <? if($os->checkAccess('Users')){ ?>
                                <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>


                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>adminDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("teacherDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Admins</span>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            <?  } ?>
                        </div>

                    <?  } ?>


                    <? if($os->checkAccess('Settings')){ ?>
                        <div class="uk-margin">
                            <div class="uk-width-1-1">
                                <h3 >Settings</h3>
                            </div>
                            <div class="uk-margin-small uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>

                                <? if($os->checkAccess('Session')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>accademicsessionDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("accademicsessionDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Session</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Subject settings')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>subject_setting_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("subject_setting_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Subject settings</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Vehicle setting')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>vehicle_setting_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("vehicle_setting_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Vehicle setting</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Fees settings')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>fees_setting_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("fees_setting_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Fees settings</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Global setting')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>global_setting_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("global_setting_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Global setting</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Certificate Format')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>certificate_templateDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("certificate_templateDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Certificate Format</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Hostel Room')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>hostel_room_bed_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("hostel_room_bed_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Hostel Room</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Hostel Setting')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>hostelroom_setting_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("hostelroom_setting_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Hostel Setting</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Global Templats')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>global_templateDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("global_templateDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Global Templats</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Exam Settings')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>exam_setting_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("exam_setting_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Exam Settings</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Quention Paper')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>question_paper_entry_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("question_paper_entry_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Quention Paper</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Result Entry Access')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>result_entry_setting_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("result_entry_setting_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Result Entry Access</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Result Entry')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>result_entry_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("result_entry_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Result Entry</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('School setting')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>school_settingDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("school_settingDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">School setting</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('E-Class')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>eclassDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("school_settingDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">E-Class</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>
                            </div>
                        </div>

                    <?  } ?>
                    <? if($os->checkAccess('Website')){ ?>

                        <div class="uk-margin">
                            <? if($os->checkAccess('Website')){ ?>
                                <div class="uk-width-1-1">
                                    <h3 >Website</h3>
                                </div>
                                <div class="uk-margin-small uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>

                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>pageContent.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("pageContent");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Pages</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>contactusList.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("contactusList");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Contact</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>bannerimageList.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("bannerimageList");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Banners</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>gallerycatagoryDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("gallerycatagoryDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Album</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>photogalleryDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("photogalleryDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Images</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>newsDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("newsDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">News</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>wtboxList.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("wtboxList");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">WT box </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>careerDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("careerDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Career</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?  } ?>
                        </div>
                    <?  } ?>
                    <? if($os->checkAccess('Misc')){ ?>

                        <div class="uk-margin">
                            <div class="uk-width-1-1">
                                <h3 >Misc</h3>
                            </div>
                            <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>

                                <? if($os->checkAccess('Account Head')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>account_headDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("account_headDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Account Head</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Expense')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>expense-page.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("expense-page");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Expense</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Budget')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>budget-page.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("budget-page");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Budget</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Expense Payment')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>otherpaymentDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("otherpaymentDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Expense Payment</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Review Subject')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>review_subjectDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("review_subjectDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Review Subject</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Review Details')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>review_detailsDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("review_detailsDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Review Details</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Salary')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>salaryDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("salaryDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Salary</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>


                                <? if($os->checkAccess('Manage Land')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>landDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("salaryDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Manage Land</span>
                                            </a>
                                        </div>
                                    </div>



                                <?  } ?>


                            </div>
                        </div>
                    <?  } ?>

                    <? if($os->checkAccess('Admission')){ ?>

                        <div class="uk-margin">
                            <div class="uk-width-1-1">
                                <h3 >Admission</h3>
                            </div>
                            <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>

                                <? if($os->checkAccess('Application Forms')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>online_formDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("online_formDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Application Forms</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Admission Process')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>admission_admin_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("admission_admin_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Admission Process</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Readmission Process')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>re_admission_admin_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("re_admission_admin_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Readmission Process</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>
                            </div>
                        </div>
                    <?  } ?>
                    <? if($os->checkAccess('Library')){ ?>
                        <div class="uk-margin">
                            <div class="uk-width-1-1">
                                <h3 >Library</h3>
                            </div>
                            <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>

                                <? if($os->checkAccess('Books List')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>bookDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("bookDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Books List</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Purchase Entry')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>book_purchase_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("book_purchase_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Purchase Entry</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Book Shelf')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>book_shelf_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("book_shelf_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Book Shelf</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>

                                <? if($os->checkAccess('Book Issue')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>book_issue_data_view.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("book_issue_data_view");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Book Issue</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>
                            </div>
                        </div>
                    <?  } ?>
                    <? if($os->checkAccess('Attendance')){ ?>

                        <div class="uk-margin">
                            <div class="uk-width-1-1">
                                <h3 >Attendence</h3>
                            </div>
                            <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>
                                <? if($os->checkAccess('Student Attendence')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>attendenceDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("attendenceDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Student Attendence</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>
                                <? if($os->checkAccess('Staff Attendence')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>teacherAttendenceDataView.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("teacherAttendenceDataView");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Staff Attendence</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>
                            </div>
                        </div>
                    <?  } ?>
                    <? if($os->checkAccess('Report')){ ?>
                        <div class="uk-margin">
                            <div class="uk-width-1-1">
                                <h3 >Report</h3>
                            </div>
                            <div class="uk-margin-small uk-grid uk-grid-small uk-grid-match  uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>
                                <? if($os->checkAccess('Admission report')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>report_admission_readmission.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("report_admission_readmission");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Admission report</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>
                                <? if($os->checkAccess('Student Result Reoprt')){ ?>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-hover uk-padding-small pointable">


                                            <a class="uk-text-center uk-link-reset " href="<? echo $site['url-wtos'] ?>report_student_result_details.php">
                                                <div class="uk-border-circle circle-icon" >
                                                    <img  src="<? getIcon("report_student_result");?>" style="width: 55px">
                                                </div>
                                                <span class="p-top-m" style="display: block">Student result details</span>
                                            </a>
                                        </div>
                                    </div>
                                <?  } ?>
                            </div>
                        </div>
                    <?  } ?>
                <?  } ?>

                <ul class="uk-margin-large-top uk-hidden" uk-accordion>
                    <li class="border-xxs uk-open" style="border-color: #e5e5e5" >
                        <a class="uk-accordion-title uk-padding-small  uk-background-muted uk-text-uppercase primary-text uk-text-bolder text-l" href="#">Profile Information</a>
                        <div class="uk-accordion-content uk-margin-remove">
                            <table class="uk-table uk-table-small uk-table-divider">
                                <tr>
                                    <td >Join Date</td>
                                    <td class="secondory-text-dark"><? echo $os->showDate($os->val($teacher,'joinDate')); ?></td>
                                </tr>
                                <tr>
                                    <td >Permanent Address</td>
                                    <td class="secondory-text-dark"><? echo $os->val($teacher,'permanentAddress') ?></td>
                                </tr>
                                <tr>
                                    <td >Recent Address</td>
                                    <td class="secondory-text-dark"><? echo $os->val($teacher,'recentAddress') ?></td>
                                </tr>
                                <tr>
                                    <td >Mobile</td>
                                    <td class="secondory-text-dark"><? echo $os->val($teacher,'mobile') ?></td>
                                </tr>
                            </table>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>


</div>

<? include($site['root-wtos'].'bottom.php'); ?>
