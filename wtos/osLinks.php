<?
global $site, $os, $selected_branch_code;
function selectedPage($page)
{
    global $os;
    $className='';
    if($os->currentPageName()==$page)
    {
        $className='active';
    }
    return $className;
}
$superAdmin=false;
if($os->userDetails['adminType']=='Super Admin'){ $superAdmin=true;}


$enable_static_menu=false;

if($enable_static_menu==false)
{
    $enable_new_menu=true;
}else{
    $enable_new_menu=false;
}




$wtos_url = $site['url-wtos'];



function populate_menu($menu = [], $parent=0){
    global $site;
    echo "<ul>";
    foreach ($menu[$parent] as $item){
        $admin_menu_id = $item['admin_menu_id'];
        $page_name = $item['page_name'];
        $href = "";
        if(!isset($menu[$admin_menu_id])){
            $href = "href='".$site['url-wtos'].$page_name."'";
        }
        ?>
        <li>
            <a class="uk-text-nowrap uk-flex-nowrap uk-flex" <?=$href?>>
                <span class="uk-flex-1"><?= $item['title']?></span>
            </a>

            <?
            if(isset($menu[$admin_menu_id])){
                populate_menu($menu, $admin_menu_id);
            }
            ?>
        </li>

        <?
    }
    echo "</ul>";
}
?>

<? if($enable_new_menu){


    ?>
    <div class="responsive-nav">
        <? populate_menu(get_menu($selected_branch_code)); ?>
    </div>

<?  } ?>
<? if($enable_static_menu){ ?>
    <div class="responsive-nav">
        <ul class="">
            <?	if($os->userDetails['adminType']=='Super Admin'){ ?>
                <li class="<? echo selectedPage('admin_menuDataView.php') ?>" >
                    <a href="<? echo $site['url-wtos'] ?>admin_menuDataView.php" >
                        <i class="mi"></i>
                        <span>Menu</span>
                    </a>
                </li>
            <?  } ?>
            <? if($os->checkAccess('Home')){ ?>
                <li class="<? echo selectedPage('dashBoard.php') ?>" >
                    <a href="<? echo $site['url-wtos'] ?>dashBoard.php" >
                        <i class="mi">home</i>
                        <span>Home</span>
                    </a>
                </li>
            <?  } ?>
            <? if($os->checkAccess('Statistics')){ ?>
                <li class="<? echo selectedPage('report_statistics_data.php') ?>">
                    <a href="<? echo $site['url-wtos'] ?>report_statistics_data.php" >
                        <i class="mi">pie_chart</i>
                        <span>Statistics</span>
                    </a>
                </li>
            <?  } ?>

            <? if($os->checkAccess('Users')  ){ ?>

                <li class="parent">
                    <a   >
                        <i class="mi">person_add</i>
                        <span>Users</span>
                    </a>

                    <ul class="uk-margin-remove uk-padding-remove">


                        <? // if($superAdmin)

                        { ?>
                            <!--  <li class="<? echo selectedPage('adminList.php') ?>"  >
                            <a    href="<? echo $site['url-wtos'] ?>adminList.php">

                                <span>Admin</span>
                            </a>
                        </li>-->

                            <li class="<? echo selectedPage('adminDataView.php') ?>"  >
                                <a    href="<? echo $site['url-wtos'] ?>adminDataView.php">

                                    <span>Admin </span>
                                </a>
                            </li>


                            <li class="<? echo selectedPage('branchDataView.php') ?>"  >
                                <a    href="<? echo $site['url-wtos'] ?>branchDataView.php">

                                    <span>Branch</span>
                                </a>
                            </li>

                        <? } ?>


                    </ul>
                </li>

            <?  } ?>
            <? if($os->checkAccess('Settings')){ ?>

                <li class="parent">
                    <a>
                        <i class="mi">settings</i>
                        <span>Settings</span>
                    </a>
                    <ul class="uk-margin-remove uk-padding-remove">
                        <? if($os->checkAccess('School setting')){ ?>
                            <li class="<? echo selectedPage('school_settingDataView.php') ?>" >  <a    href="<? echo $site['url-wtos'] ?>school_settingDataView.php" >School setting</a></li>   <?  } ?>
                        <? if($os->checkAccess('Fees settings')){ ?>
                            <li class="<? echo selectedPage('fees_setting_data_view.php') ?>" >  <a    href="<? echo $site['url-wtos'] ?>fees_setting_data_view.php" >Fees settings</a></li>
                        <?  } ?>

                        <li>
                            <a>Exam</a>
                            <ul>
                                <? if($os->checkAccess('Exam Settings')){ ?>
                                    <li class="<? echo selectedPage('exam_setting_data_view.php') ?>" >  <a    href="<? echo $site['url-wtos'] ?>exam_setting_data_view.php" >Exam Settings</a></li>
                                <?  } ?>
                                <? if($os->checkAccess('Quention Paper')){ ?>

                                    <li><a href="<? echo $site['url-wtos'] ?>question_chapterDataView.php" >Chapter</a></li>
                                    <li><a href="<? echo $site['url-wtos'] ?>question_topicDataView.php" >Topic</a></li>
                                    <li class="<? echo selectedPage('question_bank_entry_data_view.php') ?>" >
                                        <a href="<? echo $site['url-wtos'] ?>question_bank_entry_data_view.php" >
                                            <!-- <i class="mi">home</i>-->
                                            <span>Question Bank</span>
                                        </a>
                                    </li>
                                    <li><a href="<? echo $site['url-wtos'] ?>question_bankDataView.php" >Question Bank 2</a></li>



                                    <li class="<? echo selectedPage('question_paper_entry_data_view.php') ?>" >
                                        <a href="<? echo $site['url-wtos'] ?>question_paper_entry_data_view.php" >
                                            <!-- <i class="mi">home</i>-->
                                            <span>Quention Paper</span>
                                        </a>
                                    </li>

                                <?  } ?>

                            </ul>
                        </li>
                        <li>
                            <a>Result</a>
                            <ul>

                                <?	if($os->userDetails['adminType']=='Super Admin'){ ?>
                                    <li class="<? echo selectedPage('grade_settingDataView.php') ?>" >
                                        <a   href="<? echo $site['url-wtos'] ?>grade_settingDataView.php" >
                                            Grade Setting
                                        </a>
                                    </li>
                                <?  } ?>

                                <? if($os->checkAccess('Result Entry Access')){ ?>


                                    <li class="<? echo selectedPage('result_entry_setting_data_view.php') ?>" >
                                        <a href="<? echo $site['url-wtos'] ?>result_entry_setting_data_view.php" >
                                            <span>Result Entry Access</span>
                                        </a>
                                    </li>
                                <?  } ?>
                                <? if($os->checkAccess('Result Entry')){ ?>

                                    <li class="<? echo selectedPage('result_entry_data_view.php') ?>" >
                                        <a    href="<? echo $site['url-wtos'] ?>result_entry_data_view.php" >
                                            <!-- <i class="mi">featured_play_list</i>-->
                                            <span>Result Entry</span>
                                        </a></li>

                                <?  } ?>
                            </ul>
                        </li>


                        <?	if($os->userDetails['adminType']=='Super Admin'){ ?>
                            <li>
                                <a>Template</a>
                                <ul>
                                    <? if($os->checkAccess('Global Templats')){ ?>
                                        <li class="<? echo selectedPage('global_templateDataView.php') ?>" >  <a    href="<? echo $site['url-wtos'] ?>global_templateDataView.php" >Global Templates</a></li>
                                    <?  } ?>
                                    <? if($os->checkAccess('Certificate Format')){ ?>
                                        <li class="<? echo selectedPage('certificate_templateDataView.php') ?>" >  <a   href="<? echo $site['url-wtos'] ?>certificate_templateDataView.php" >Certificate Format</a></li>
                                    <?  } ?>
                                </ul>
                            </li>
                            <li>
                                <a>Hostel</a>
                                <ul>
                                    <? if($os->checkAccess('Hostel Room')){ ?>
                                        <li class="<? echo selectedPage('hostel_room_bed_data_view.php') ?>" >  <a    href="<? echo $site['url-wtos'] ?>hostel_room_bed_data_view.php" >Hostel Room</a></li>
                                    <?  } ?>
                                    <? if($os->checkAccess('Hostel Setting')){ ?>
                                        <li class="<? echo selectedPage('hostelroom_setting_data_view.php') ?>" >  <a    href="<? echo $site['url-wtos'] ?>hostelroom_setting_data_view.php" >Hostel Setting</a></li>
                                    <?  } ?>
                                </ul>
                            </li>

                        <?  } ?>

                        <? if($os->checkAccess('Session')){ ?>

                            <li class="<? echo selectedPage('accademicsessionDataView.php') ?>" >
                                <a   href="<? echo $site['url-wtos'] ?>accademicsessionDataView.php" >
                                    Session
                                </a>
                            </li>
                        <?  } ?>
                        <? if($os->checkAccess('Subject settings')){ ?>
                            <li class="<? echo selectedPage('subject_setting_data_view.php') ?>" >
                                <a    href="<? echo $site['url-wtos'] ?>subject_setting_data_view.php" >Subject settings</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Vehicle setting')){ ?>
                            <li class="<? echo selectedPage('vehicle_setting_data_view.php') ?>" >  <a   href="<? echo $site['url-wtos'] ?>vehicle_setting_data_view.php" >Vehicle setting</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Global setting')){ ?>
                            <li class="<? echo selectedPage('global_setting_data_view.php') ?>" >  <a    href="<? echo $site['url-wtos'] ?>global_setting_data_view.php" >Global setting</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('E-Class')){ ?>

                            <li class="<? echo selectedPage('eclassDataView.php') ?>" >  <a class=" "  href="<? echo $site['url-wtos'] ?>eclassDataView.php" >E-Class</a></li>
                        <?  } ?>
                    </ul>
                </li>

            <?  } ?>
            <? if($os->checkAccess('Website')){ ?>
                <li class="parent">
                    <a  >
                        <i class="mi">insert_chart</i>
                        <span>Website</span>
                    </a>
                    <ul class="uk-margin-remove uk-padding-remove">



                        <li  class="   <? echo selectedPage('pageContent.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>pageContent.php" >Pages</a></li>
                        <li class="   <? echo selectedPage('bannerimageList.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>bannerimageList.php">Banner Image</a></li>
                        <li class=" <? echo selectedPage('gallerycatagoryDataView.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>gallerycatagoryDataView.php" >Album</a></li>
                        <li class="   <? echo selectedPage('photogalleryDataView.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>photogalleryDataView.php" >Album Image</a></li>
                        <li class="   <? echo selectedPage('newsDataView.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>newsDataView.php" >News/Event</a></li>
                        <!-- <li class="   <? echo selectedPage('wtboxList.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>wtboxList.php">Wtbox</a></li>-->

                        <li class="   <? echo selectedPage('noticeboardList.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>noticeboardList.php">Notice</a></li>

                        <li class="   <? echo selectedPage('contactusList.php') ?>" >  <a     href="<? echo $site['url-wtos'] ?>contactusList.php">Enquery</a></li>
                        <li class="  <? echo selectedPage('careerDataView.php') ?>" >  <a class=""    href="<? echo $site['url-wtos'] ?>careerDataView.php">Career</a></li>

                    </ul>
                </li>

            <?  } ?>
            <? if($os->checkAccess('Misc')){ ?>
                <li class="parent">
                    <a  >
                        <i class="mi">insert_chart</i>
                        <span>Misc.</span>
                    </a>
                    <ul class="uk-margin-remove uk-padding-remove">
                        <? if($os->checkAccess('Account Head')){ ?>
                            <li class=" <? echo selectedPage('account_headDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>account_headDataView.php" >Account Head</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Expense')){ ?>
                            <li class="<? echo selectedPage('expense-page.php') ?>" >  <a class=" "  href="<? echo $site['url-wtos'] ?>expense-page.php" >Expense</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Budget')){ ?>
                            <li class="<? echo selectedPage('budget-page.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>budget-page.php" >Budget</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Expense Payment')){ ?>
                            <li class="<? echo selectedPage('otherpaymentDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>otherpaymentDataView.php" >Expense Payment</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Review Subject')){ ?>
                            <li class=" <? echo selectedPage('review_subjectDataView.php') ?>" >  <a href="<? echo $site['url-wtos'] ?>review_subjectDataView.php" >Review Subject</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Review Details')){ ?>
                            <li class=" <? echo selectedPage('review_detailsDataView.php') ?>" >  <a href="<? echo $site['url-wtos'] ?>review_detailsDataView.php" >Review Details</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Salary')){ ?>
                            <li class=" <? echo selectedPage('salaryDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>salaryDataView.php" >Salary</a></li>
                        <?  } ?>


                        <!-- <li class=" <? echo selectedPage('resultsdetailsDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>resultsdetailsDataView.php" >Result Details</a></li>
                    <li class="<? echo selectedPage('travel_detailsDataView.php') ?>" >  <a class=" "  href="<? echo $site['url-wtos'] ?>travel_detailsDataView.php" >Car Log</a></li>-->


                        <? if($os->checkAccess('Manage Land')){ ?>

                            <li class="<? echo selectedPage('landDataView.php') ?>" >  <a class=" "  href="<? echo $site['url-wtos'] ?>landDataView.php" >Manage Land</a></li>

                        <?  } ?>



                        <!--<li class=" <? echo selectedPage('resultsDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>resultsDataView.php" >Result</a></li>

<li class=" <? echo selectedPage('smstemplateDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>smstemplateDataView.php" >SMS Template</a></li>-->

                        <!-- <li class=" <? echo selectedPage('questionanswaredDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>questionanswaredDataView.php" >Question Answer</a></li>-->

                        <!--<li class="  <? echo selectedPage('admissionDataView.php') ?>" >  <a class=""    href="<? echo $site['url-wtos'] ?>admissionDataView.php">All Admission</a></li>
<li class="  <? echo selectedPage('admissionDataView1.php') ?>" >  <a class=""    href="<? echo $site['url-wtos'] ?>admissionDataView.php?admissionType=New">New Admission</a></li>
<li class="  <? echo selectedPage('admissionDataView2.php') ?>" >  <a class=""    href="<? echo $site['url-wtos'] ?>admissionDataView.php?admissionType=Re">Re Admission</a></li>-->
                        <!--<li class=" <? echo selectedPage('expense_listDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>expense_listDataView.php" >Expense List</a></li>
<li class="<? echo selectedPage('expense_list_detailsDataView.php') ?>" >  <a href="<? echo $site['url-wtos'] ?>expense_list_detailsDataView.php" >Expense List Details</a></li>
<li class=" <? echo selectedPage('budget_listDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>budget_listDataView.php" >Budget List</a></li>
<li class=" <? echo selectedPage('budget_list_detailsDataView.php') ?>" >  <a href="<? echo $site['url-wtos'] ?>budget_list_detailsDataView.php" >Budget List Details</a></li>-->
                        <!--<li class="<? echo selectedPage('questionDataView.php') ?>" >  <a class=" "    href="<? echo $site['url-wtos'] ?>questionDataView.php" >Question</a></li>-->


                    </ul>
                </li>


            <?  } ?>

            <? if($os->checkAccess('Admission_______not_ok')){ ?>
                <li class="parent">
                    <a   >
                        <i class="mi">post_add</i>
                        <span>Admission</span>
                    </a>

                    <ul class="uk-margin-remove uk-padding-remove">
                        <? if($os->checkAccess('Application Forms')){ ?>
                            <li class="<? echo selectedPage('online_formDataView.php') ?>" >
                                <a    href="<? echo $site['url-wtos'] ?>online_formDataView.php" >
                                    <span>Application Forms</span>
                                </a>
                            </li>
                        <?  } ?>
                        <? if($os->checkAccess('Admission Process')){ ?>

                            <li class="<? echo selectedPage('admission_admin_data_view.php') ?>" >
                                <a href="<? echo $site['url-wtos'] ?>admission_admin_data_view.php" >
                                    <span>Admission Process</span>
                                </a>
                            </li>
                        <?  } ?>
                        <? if($os->checkAccess('Readmission Process')){ ?>
                            <li class="<? echo selectedPage('re_admission_admin_data_view.php') ?>" >
                                <a    href="<? echo $site['url-wtos'] ?>re_admission_admin_data_view.php" >
                                    <span>Readmission Process</span>
                                </a>
                            </li>
                        <?  } ?>




                    </ul>
                </li>
            <?  } ?>
            <? if($os->checkAccess('Student Register')){ ?>

                <li class="<? echo selectedPage('historyDataView.php') ?>" >
                    <a href="<? echo $site['url-wtos'] ?>historyDataView.php" >
                        <i class="mi" style="color:#FF8000">person_add</i>
                        <span>Student Register</span>
                    </a>
                </li>
            <?  } ?>
            <? if($os->checkAccess('Library')){ ?>
                <li class="parent" >
                    <a  >
                        <i class="mi">library_books</i>
                        <span>Library</span>
                    </a>
                    <ul class="uk-margin-remove uk-padding-remove">
                        <? if($os->checkAccess('Books List')){ ?>
                            <li class="<? echo selectedPage('bookDataView.php') ?>" ><a href="<? echo $site['url-wtos'] ?>bookDataView.php" >Books List</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Purchase Entry')){ ?>
                            <li class="<? echo selectedPage('book_purchase_data_view.php') ?>" ><a href="<? echo $site['url-wtos'] ?>book_purchase_data_view.php" >Purchase Entry</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Book Shelf')){ ?>
                            <li class="<? echo selectedPage('book_shelf_data_view.php') ?>" ><a href="<? echo $site['url-wtos'] ?>book_shelf_data_view.php" >Book Shelf</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Book Issue')){ ?>
                            <li class="<? echo selectedPage('book_issue_data_view.php') ?>" ><a href="<? echo $site['url-wtos'] ?>book_issue_data_view.php" >Book Issue</a></li>
                        <?  } ?>



                    </ul>
                </li>

            <?  } ?>
            <? if($os->checkAccess('Attendance')){ ?>
                <li class="parent">
                    <a>
                        <i class="mi">sports_handball</i>
                        <span>Attendance</span>
                    </a>

                    <ul class="uk-margin-remove uk-padding-remove">
                        <? if($os->checkAccess('Student Attendence')){ ?>
                            <li class="<? echo selectedPage('attendenceDataView.php') ?>"  ><a href="<? echo $site['url-wtos'] ?>attendenceDataView.php">Student Attendence</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Staff Attendence')){ ?>
                            <li class="<? echo selectedPage('teacherAttendenceDataView.php') ?>" ><a href="<? echo $site['url-wtos'] ?>teacherAttendenceDataView.php"  >Staff Attendence</a></li>
                        <?  } ?>

                    </ul>
                </li>
            <?  } ?>
            <? if($os->checkAccess('Backup')){ ?>
                <li class="<? echo selectedPage('dbbackupDataView.php') ?>" >
                    <a href="<? echo $site['url-wtos'] ?>dbbackupDataView.php" >
                        <i class="mi">how_to_reg</i>
                        <span>Backup</span>
                    </a>
                </li>

            <?  } ?>
            <? if($os->checkAccess('Report')){ ?>

                <li class="parent">
                    <a  >
                        <i class="mi">insert_chart</i>
                        <span>Report</span>
                    </a>
                    <ul class="uk-margin-remove uk-padding-remove">
                        <? if($os->checkAccess('Admission report')){ ?>
                            <li><a href="<? echo $site['url-wtos'] ?>report_admission_readmission.php" >Admission report</a></li>
                        <?  } ?>
                        <? if($os->checkAccess('Student Result Reoprt')){ ?>

                            <li><a href="<? echo $site['url-wtos'] ?>report_student_result_details.php" >  Student result details
                                </a></li>

                        <?  } ?>
                        <?	if($os->userDetails['adminType']=='Super Admin'){ ?>

                            <li><a href="<? echo $site['url-wtos'] ?>answer_details_duplicate.php" >Answer Details</a></li>
                            <li><a href="<? echo $site['url-wtos'] ?>report_student_result.php" >Student Result Reoprt</a></li>
                            <li><a href="<? echo $site['url-wtos'] ?>report_student_result_details.php" >Student Result
                                    Reoprt Details</a></li>

                            <li><a href="<? echo $site['url-wtos'] ?>report_attendance.php" >Attendance Report</a></li>


                            <li><a href="<? echo $site['url-wtos'] ?>report_teacher_attendance.php" >Teacher Attendance Report</a></li>
                            <li><a href="<? echo $site['url-wtos'] ?>report_student_result_overall.php" >Overall Result
                                    Report</a></li>
                        <?  } ?>
                    </ul>
                </li>

            <?  } ?>


            <?	if($os->userDetails['adminType']=='Super Admin'){ ?>
                <li class="parent">
                    <a>
                        <i class="mi">insert_chart</i>
                        <span>M</span>
                    </a>
                    <ul class="uk-margin-remove uk-padding-remove">
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_brandDataView.php">Mess Brand</a></li>
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_vendorDataView.php">Mess Vendor</a></li>
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_itemDataView.php">Mess Item</a></li>
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_purchaseDataView.php">Mess Purchase</a></li>
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_meal_memberDataView.php">Meal Member</a></li>

                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_meal_itemDataView.php">Mess Meal Item</a></li>
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_baburchiDataView.php">Mess Baburchi</a></li>
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>mess_stockDataView.php">Mess Stock</a></li>
                        <li>  <a class="linkClass"    href="<? echo $site['url-wtos'] ?>campus_buildingDataView.php">Campus Building</a></li>

                    </ul>
                </li>




            <?  } ?>



        </ul>
    </div>
<?  } ?>


<script>
    $(document).ready(function (){
        let width = $(window).width();
        if(width>=1000){
            $('.responsive-nav > ul > li > ul').each(function (){
                let f_parent = this;
                $(f_parent).prev().append('<i class="las la-angle-down m-left-s"></i>');
                $(f_parent).closest("li").mouseover(function (){
                    $(f_parent).show();
                });
                $(f_parent).closest("li").mouseleave(function (){
                    $(f_parent).hide();
                });


                $('ul', f_parent).each(function (){
                    let sec_parent = this;
                    $(sec_parent).prev().append('<i class="las la-angle-right m-left-m uk-float-right"></i>');


                    $(sec_parent).closest("li").mouseover(function (){
                        $(sec_parent).show();
                    });
                    $(sec_parent).closest("li").mouseleave(function (){
                        $(sec_parent).hide();
                    });
                });
            });



        }
        else
        {
            $('.nav-button').click(function (){
                if($('.responsive-nav').css("left")=="0") {
                    $('.responsive-nav').css("left", "-300px");
                } else {
                    $('.responsive-nav').css("left", "0");
                }
            });
            $(".container").click(function (){
                $('.responsive-nav').css("left", "-300px");
            });


            $('.responsive-nav > ul > li  ul').each(function () {
                let f_parent = this;

                $(f_parent).prev().append('<i class="las la-angle-down m-left-m uk-float-right"></i>');
                $(f_parent).prev().click(function () {
                    $(f_parent).slideToggle();
                });


                $(f_parent).css("display","none");
            });
        }
    })
</script>
