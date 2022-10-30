<?


 
/*
   # wtos version : 1.1
   # main ajax process page : historyAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');

$pluginName='';
$listHeader='Student Register';
$ajaxFilePath= 'historyAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
include('rbListAndAssign.php');
include('wtosSearchAddAssign.php');
include('quickEditPage.php');
$arrayKeys = array_keys($os->asession);
$setFeesSession=$os->asession[$arrayKeys[0]];
$setFeesClass='';
$setFeesSection='A'; $setFeesSection=' ';

$studentString = '';
/*$studentNameQ='select * from student order by name';
$studentNameMq = $os->mq($studentNameQ);
while ($studentRow = $os->mfa($studentNameMq))
{
    $studentString.= $studentRow['name'].'-'.$os->showDate($studentRow['dob']).'##';
}*/

$return_acc=$os->branch_access();
$and_branch='';
if($os->userDetails['adminType']!='Super Admin')
{
    //$selected_branch_code=$os->getSession($key1='selected_branch_code');

    $selected_branch_codes=$return_acc['branches_code_str_query'];
    $and_branch=" and branch_code IN($selected_branch_codes)";

}

$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
// $branch_row_q="select   branch_code   from history where branch_code!='' $and_branch order by branch_code asc ";

$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
    $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
}

$global_access = $os->get_global_access_by_name("Student Register");
$has_sms_send_access = in_array("Bulk SMS",$global_access)||$os->loggedUser()["adminType"]=="Super Admin";
?>


<style>
    .scroll_div{height:345px;overflow-x:hidden;overflow:auto; width:227px;}
    .MoreStudentDatatable{ width:24%; float:left;}
    .hideiFrame{ display:none;}
    .ajaxEditForm{ margin:5px 0px 0px 0px}
</style>


<!-- This is Subscription Details modal -->
<div id="subscription_modal" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-width-1-1">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-card uk-card-default uk-card-small">

            <div class="uk-card-header">
                <h5 >Subscription Details</h5>
            </div>
            <div  id="sub_details_div">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function show_subscription(studentId,name,mobile_student,classVal,asession){
        var formdata = new FormData();
        formdata.append('studentId',studentId);
        formdata.append('name',name);
        formdata.append('mobile_student',mobile_student);
        formdata.append('classVal',classVal);
        formdata.append('asession',asession);
        var url='<? echo $ajaxFilePath ?>?show_subscription=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('sub_details_div',url,formdata);
        UIkit.modal('#subscription_modal').show();
    }
		
</script>



<!-- This is feees setting   modal -->
<div id="student_fees_setting_modal" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-width-1-1">  <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
       <div class="">
 <form  id="student_fees_setting_form">
			
            <div  id="student_fees_setting_div" style="padding:10px;">
            </div>
			
	</form>		
        </div>
    </div>
</div>
<script type="text/javascript">
    
 function student_fees_setting(history_id,action)
 {      
		
		var formdata = new FormData(os.getObj('student_fees_setting_form'));
	    formdata.append('history_id',history_id);
        formdata.append('action',action);
        
		if(action=='save')
		{
		  var p=confirm('Are you sure ? save configuration?  ');
		  if(p)
		  {
		    
		  }else
		  {
		    return false;
		  }
		
		}
		
        
        var url='<? echo $ajaxFilePath ?>?student_fees_setting=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('student_fees_setting_div',url,formdata);
        UIkit.modal('#student_fees_setting_modal').show();
 
 }
	
	
	
</script>

<!-- This is feees collect   modal -->
<div id="student_fees_collect_modal" class="uk-flex-top " uk-modal>
    <div class="uk-modal-dialog uk-width-1-1 uk-border-rounded"> <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        <div>
            <form  id="student_fees_collect_form">
                <div  id="student_fees_collect_div">
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    
 function student_fees_collect(history_id,action)
 {      
		 
		var formdata = new FormData(os.getObj('student_fees_collect_form'));
	    formdata.append('history_id',history_id);
		
		 if(action=='generate_receipt')
		{
		 
		  if(os.check.empty('paid_fees_amount','Please enter paid amount')==false){ return false;}
		 
		 
		  var p=confirm('Confirm generate receipt and bill ?');
		  if(!p)
		  {
		    return false;
		  }else{
		  
		   /* var g=confirm('You will not be able to edit bill.');
				if(!g)
				{
				return false;
				}*/
		  
		  }
		  
		} 
		
        formdata.append('action',action);
        
		
		
        
        var url='<? echo $ajaxFilePath ?>?student_fees_collect=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
     //   os.setAjaxHtml('student_fees_collect_div',url,formdata);
		os.setAjaxFunc('student_fees_collect_result',url,formdata);
        UIkit.modal('#student_fees_collect_modal').show();
 
 }
 function student_fees_collect_result(data)
 {
 
  var feeshtml=getData(data,'##-feeshtml-##');
  os.setHtml('student_fees_collect_div',feeshtml);
  
  var fees_payment_id=getData(data,'##-fees_payment_id-##');
   
 if(fees_payment_id!='')
   {
        print_receipt_fees(fees_payment_id,'ok')
   }
   
   
   
 }
	
	
	
</script>

<!----------- -->


<!-----------
Header
--------------->
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4> &nbsp;
            <button class="bp3-button bp3-small bp3-intent-primary" onclick="validate_reg_no()" title="Add new student"  > Add new student </button>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">

            <div class="uk-inline">
               
					
				
 <?  if($os->userDetails['adminType']=='Super Admin'){ ?>


                        <div class="uk-float-right uk-margin-small-right" >
                            <button class="uk-button uk-border-rounded    congested-form uk-secondary-button " onclick="open_upgrade_form()">
                                <span uk-icon="icon:  mail; ratio:0.7" class="m-right-s"></span>
                                Promotion
                            </button>
                        </div> 
                       
                    <? } ?>
					
              
              
                    
                <? if($has_sms_send_access ){?>
                    <div class="uk-float-right uk-margin-small-right">
                        <button class="uk-button uk-border-rounded    congested-form uk-secondary-button " uk-toggle="target:#send_sms_modal">
                            <span uk-icon="icon:  mail; ratio:0.7" class="m-right-s"></span>
                            SMS
                        </button>
                    </div>
                    <div id="send_sms_modal" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Send SMS</h2>
                            <div class="uk-margin">
                                <div class="uk-grid uk-child-width-1-3 uk-grid-collapse" uk-grid>
                                    <textarea id="sms_body_template" style="width:500px;">Website link https://www.al-ameen.in Your User Id is  {{registration_no}} and password is {{pass_word}}</textarea>
                                    <br />
                                    {{registration_no}} <br />
                                    {{pass_word}} <br />

                                </div>
                                <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button uk-margin"
                                type="button"
                                style="cursor:pointer"
                                onclick="send_sms_function();">SEND</button>

                                <div id="output_send_SMS">
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function send_sms_function()
                        {

                            var checked_historyIds=   getValuesFromCheckedBox('historyIds[]');
                            if(checked_historyIds==''){
                                var p=confirm('Send SMS To All');

                            }
                            if(checked_historyIds!=''){
                                var p=confirm('Send SMS To Selected student');

                            }

                            if(p)
                            {

                                var formdata = new FormData();

                                formdata.append('checked_historyIds',checked_historyIds );
                                var sms_body_template=os.getVal('sms_body_template');

                                formdata.append('sms_body_template',sms_body_template );
                                formdata.append('send_sms_function','OK-----------' );
                                var url='<? echo $ajaxFilePath ?>?send_sms_function=OK&'+url;
                                os.animateMe.div='div_busy';
                                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

                                os.setAjaxFunc('send_sms_function_results',url,formdata);


                            }


                        }



                        function  send_sms_function_results(data)
                        {
                            os.setHtml('output_send_SMS',data);
                        }


                    </script>
                    <? }?>
                   
					
					<div class="uk-float-right uk-margin-small-right">
                        <button class="uk-button uk-border-rounded    congested-form uk-secondary-button "
                        onclick="popDialogWH('more_download_modal','EXPORT STUDENT DATA',700,300);">
                        <span uk-icon="icon:  cloud-download; ratio:0.7" class="m-right-s"></span>
                        Export
                    </button>
                </div>
					
					  <div class="uk-float-right uk-margin-small-right">

                    <button class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"  type="button"
                    onclick=" openPrintId('historyIds[]');">I-Card Print</button>
                   

                </div>
					
					<div class="uk-float-right uk-margin-small-right">
                   
                    <button class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"  type="button"
                    onclick="open_barcode_PrintId('historyIds[]');">Student Barcode</button>

                </div>
              
					
					  <?  if($os->userDetails['adminType']=='Super Admin'){ ?>

                    <div class="uk-float-right uk-margin-small-right">

                        <button class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"  type="button"
                        onclick=" popDialogWH('exel_upload_form','UPLOAD STUDENT DATA',700,300);">Import Excel</button>

                    </div>

 
                    <? } ?>
					
					
                </div>
            </div>
        </div>

    </div>
    <div class="content">
    <!-----------
    Main contents
    --------------->
    <div class="item" >
        <div class="uk-grid uk-grid-small" uk-grid>
            <div class="uk-width-auto">
                <div  id="bulk_link" class="p-xl m-m m-top-m background-color-white uk-border-rounded" >

                    <ul class="uk-nav uk-nav-default text-m">
                        <li class="uk-nav-header">QUICK ACTIONS</li>
                        <!--
                        <span   onclick="addStudent();os.hide('Admission_link')"    id="mobile_addstudent_id" class="mobile_addstudent_class" style="cursor:pointer;font-weight:normal; color:#009900; font-size:14px; cursor:pointer;"> New Admission</span>
                        <div>Re Admission</div>
                    -->
                    <!--onclick="showhide('Admission_link');os.hide('id_ajaxViewMainTableTDForm');"-->

                    <li>
                        <a class="uk-flex uk-flex-middle text-none" href="javascript:void(0);" onclick="openPrintId('historyIds[]')" >
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">style</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">I-Card Print</span>
                        </a>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li>
                        <a href="javascript:void(0);" onclick="get_class_exam()">
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">assessment</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">Mark sheet</span>
                        </a>
                    </li>

                    <li class="uk-nav-header">CERTIFICATES</li>
                        <!--
                        <div class="student_docs_link"><a href="javascript:void();" onclick="bulkADmit()" style="color:#CCCCCC"> Admit</a></div>
                        <div class="student_docs_link"><a href="javascript:void();" onclick="bulkClassCertificate()"  style="color:#CCCCCC">  Certificate </a></div>
                    -->
                    <li>
                        <a href="javascript:void(0);" onclick="bulkCertificate('Charecter','historyIds[]','')"    >
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">verified_user</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">Character Certificate</span>
                        </a>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li>
                        <a href="javascript:void(0);" onclick="bulkCertificate('School leaving','historyIds[]','')">
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">directions_walk</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">School Leaving Certificate</span>
                        </a>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li>
                        <a href="javascript:void(0);" onclick="bulkCertificate('Transfer','historyIds[]','')">
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">transfer_within_a_station</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">Transfer Certificate</span>
                        </a>
                    </li>
                    <li class="uk-nav-header">CURRICULUM</li>
                    <li>
                        <a href="javascript:void(0);" onclick="bulkCertificate('Sports','historyIds[]','')"    >
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">verified_user</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">Sports Certificate</span>
                        </a>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li>
                        <a href="javascript:void(0);" onclick="bulkCertificate('Culture','historyIds[]','')"    >
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">verified_user</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">Culture Certificate</span>
                        </a>
                    </li>
                    <li class="uk-nav-divider"></li>
                    <li>
                        <a href="javascript:void(0);" onclick="bulkCertificate('Other','historyIds[]','')"    >
                            <i class="mi uk-margin-small-right text-xl color-primary" style="vertical-align: middle">verified_user</i>
                            <span class="text-m color-black hover-color-deep-grey" style="vertical-align: middle; color:#000000;">Other Certificate</span>
                        </a>
                    </li>
                    <!--<div class="student_docs_link"><a href="javascript:void();" onclick="bulkAdmission()"> Admission</a></div>-->
                    <!--<div class="student_docs_link"><a href="javascript:void();" onclick="addStudent()"> New Admission</a></div>-->
                    <!--<div class="student_docs_link"><a href="javascript:void();" onclick="bulkReAdmission()"> Re Admission</a></div>-->
                </ul>

            </div>
        </div>

        <div class="uk-width-expand">

                <!---------
                SEARCH VIEW
                ---------->
                <div class=" text-m p-top-m" style="">
                    <div class="uk-inline" uk-tooltip=" Session ">Session<br />
                        <select name="asession"
                        id="asession_s"
                        style="padding-left: 85px"
                        class="uk-select uk-border-rounded congested-form" >
                        <option value=""> </option>
                        <?
                            // $os->onlyOption($os->asession,$setFeesSession);
                        $os->onlyOption($os->asession, '');
                        ?>
                    </select>
                </div>
                <div class="uk-inline" uk-tooltip="registration No">Reg. No<br />

                    <input class="uk-input uk-border-rounded congested-form " type="text" id="registrationNo_s"    style="width:80px;font-weight:bold; font-size:14px;" value="<? echo $os->get('formfillup_regno') ?>" onkeyup=" "/>
                </div>
                <div class="uk-inline" uk-tooltip="Student Name ( 4 letter minimum)">Name<br />
                    <!-- <span class="uk-form-icon" uk-icon="icon: user; ratio:0.7"></span>-->
                    <input class="uk-input uk-border-rounded congested-form " type="text" id="studentName_s"    style="width:100px;" onkeyup=" "/>   &nbsp;
                </div>


              

                <div class="uk-inline" uk-tooltip="Board" style="display:none;">
                    <select name="board" id="board_s" class="uk-select uk-border-rounded congested-form "   >
                        <option value=""> </option>
                        <? $os->onlyOption($os->board,'');	?>
                    </select>
                </div>

                <div class="uk-inline" uk-tooltip="Class">Class
                    <select name="class" id="class_s" class="uk-select uk-border-rounded congested-form "  placeholder="Class"   >
                        <option value="">  </option>




                        <? foreach($os->board_class as $board=>$classes){?>
                            <optgroup label="<?=$board?>">
                                <? foreach ($classes as $class){?>
                                    <option value="<? echo $class?>"> <? echo $os->classList[$class]?></option>
                                <? }?>
                            </optgroup>
                        <? } ?>



                    </select>
                </div>
                <div class="uk-inline" uk-tooltip=" Gender ">Gender<br />
                    <select name="gender"
                    id="gender_s" placeholder="Gender"
                    style="padding-left: 85px"
                    class="uk-select uk-border-rounded congested-form" >
                    <option value="">  </option>
                    <?

                    $os->onlyOption($os->gender, '');
                    ?>
                </select>
            </div>

            <div class="uk-inline" uk-tooltip=" Section ">Section<br />
                <select
                name="section"
                id="section_s" placeholder="Section"
                class="uk-select uk-border-rounded congested-form"
                onchange="WT_historyListing();" >
                <option value=""> </option>	<?
                $os->onlyOption($os->section,'');	?>
            </select>

        </div>

        <div class="uk-inline" uk-tooltip="Branch"   >Branch<br />
            <select name="branch_code_s" id="branch_code_s"
            class="select2">
            <option value="">All Branch</option>
            <? $os->onlyOption($branch_code_arr,'');	?>
        </select>
        <? if($os->userDetails['adminType']=='Super Admin' && false){ ?>
            <span id="SAA_C" class="SAA_Container"> </span>

            <script>
                saa.execute('c','SAA_C','branch_code_s','branch','branch_code','branch_name,branch_code','Branch,Code','branch_code','','');
            </script>
        <? } ?>

    </div>

    <div class="uk-inline" uk-tooltip="Student ID"   style="display:none;"   >
        <!-- <span class="uk-form-icon" uk-icon="icon: hashtag; ratio:0.7"></span>-->
        <input class="uk-input uk-border-rounded congested-form " placeholder="ID" type="text"  style="width:40px;" name="studentId_s" id="studentId_s" value="" onkeyup=" "  />
    </div>


    <div class="uk-inline" uk-tooltip="Short By" style="display:none;"     >
        <select name="sortBy" id="sortBy_s" class="uk-select uk-border-rounded congested-form" onchange="WT_historyListing();" >
            <option value="">Short by</option>
            <? $os->onlyOption($os->sortBy);	?>
        </select>
		  
    </div>
	
	<div class="uk-inline" uk-tooltip="Status"      >
         
		 Status:<br />
        <select name="historyStatus" id="historyStatus_s" style="display:none;" class="textbox fWidth" ><option value="">All </option>	<?
        $os->onlyOption($os->historyStatus,'Active');	?></select>
		<select name="status_active_s" id="status_active_s"  class="textbox fWidth" ><option value="">All </option>	<?
        $os->onlyOption($os->student_status_active,'Y');	?></select>
    </div> 
	<br />

                 <div class="uk-inline" uk-tooltip="Search key (4 letter minimum)">Search Keyword<br />
                    <!--<span class="uk-form-icon" uk-icon="icon: search; ratio:0.7"></span>-->
                    <input class="uk-input uk-border-rounded congested-form "   type="text" id="searchKey"   style="width:100px;" onkeyup=" "/>
                </div>

  <div class="uk-inline"    >&nbsp;<br />

    <button class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="WT_historyListing();"> 
        <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
        Search
    </button>

    <button class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();"> 
        <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
        Reset
    </button>
</div>
    <div style="display:none" id="advanceSearchDiv">


        <div class="uk-inline" uk-tooltip="Section" >
            <select name="section-----" id="section_s------" placeholder="Section" class="uk-select uk-border-rounded uk-form-small p-right-xl" onchange="WT_historyListing();" >
                <option value="">Section</option>	<?
                $os->onlyOption($os->section,$setFeesSection);	?>
            </select>

        </div>




        Stream:
        <select name="stream_s" id="stream_s" class="textbox fWidth" ><option value=""> </option>	<?
        $os->onlyOption($os->stream);	?></select>


        Registration Fees Status :

        <select name="regFeesstatus_s" id="regFeesstatus_s" class="textbox fWidth" ><option value=""> </option>	<?
        $os->onlyOption($os->registrationFeesStatus);	?></select>
       

        Admission Type:
        <select name="admissionType_s" id="admissionType_s" class="textbox fWidth" ><?
        $os->onlyOption($os->admissionType);	?></select>




        Kanyashree:
        <select name="kanyashree_s" id="kanyashree_s" class="textbox fWidth" ><option value=""> </option>	<?
        $os->onlyOption($os->kanyashree);	?></select>
        Yuvashree:
        <select name="yuvashree_s" id="yuvashree_s" class="textbox fWidth" ><option value=""> </option>	<?
        $os->onlyOption($os->yuvashree);	?></select>

        Admission No: <input type="text" class="wtTextClass" name="admission_no_s" id="admission_no_s" value="" /> &nbsp; From Admission Date: <input class="wtDateClass" type="text" name="f_admission_date_s" id="f_admission_date_s" value=""  /> &nbsp;   To Admission Date: <input class="wtDateClass" type="text" name="t_admission_date_s" id="t_admission_date_s" value=""  /> &nbsp;
        Roll no: <input type="text" class="wtTextClass" name="roll_no_s" id="roll_no_s" value="" /> &nbsp;
        Full marks: <input type="text" class="wtTextClass" name="full_marks_s" id="full_marks_s" value="" /> &nbsp;  Obtain marks: <input type="text" class="wtTextClass" name="obtain_marks_s" id="obtain_marks_s" value="" /> &nbsp;  Percentage: <input type="text" class="wtTextClass" name="percentage_s" id="percentage_s" value="" /> &nbsp;  Pass:

        <select name="pass_fail" id="pass_fail_s" class="textbox fWidth" ><option value="">Select Pass</option>	<?
        $os->onlyOption($os->pass_fail);	?></select>
        Grade: <input type="text" class="wtTextClass" name="grade_s" id="grade_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;
    </div>
    <!--<input type="button" value="Search" onclick="WT_historyListing();" style="cursor:pointer;"/>-->
    <!--<input type="button" value="Add Fees" onclick="addFees()"  style="cursor:pointer;"/>-->

</div>
                <!---------
                DATA VIEW
                ---------->
                <div id="ajaxViewMainTableTDList_id">
                    <div id="WT_historyListDiv"></div>
                </div>

            </div>
        </div>
    </div>
    <!--------
     Form
     --------->
     <div id="id_ajaxViewMainTableTDForm"></div>
    <!---------
    other function div
    ---------->
    <div id="TD_ID_for_other_function" style="display: none">
        <div id="TD_ID_for_other_function_DIV"></div>
    </div>
    <!---------
    student details
    ---------->
    <div id="showStudent_details_DIV" class="uk-modal-container" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div>
                <div class="uk-grid uk-grid-collapse uk-grid">
                    <div style="width: 400px">
                        <!-- class student_profile_DIV  list-->
                        <div id="student_profile_DIV" class=" uk-margin-small border-xxs border-color-light-grey ">

                        </div>
                        <div class="border-xxs  border-color-light-grey ">
                            <!-- class history  list-->
                            <div id="all_session_history_data_DIV" class="text-none background-color-light-grey ">

                            </div>
                            <!-- doc link -->
                            <div id="student_doc_link_DIV">

                            </div>
                        </div>
                    </div>
                    <div class="uk-width-expand">
					<div class="m-left-m border-xxs border-color-light-grey">
                        <div id="student_data_form_DIV_ID"> Please wait .......
                        </div>
						</div>
                    </div>
                </div>

                <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                <input type="hidden"  id="WT_historypagingPageno" value="1" />

            </div>
        </div>
    </div>


    <!-- upload form  -->

    <div id="exel_upload_form" style="display:none;">

        <input type="file" name="application_form_data_file"  id="application_form_data_file" /><br />
        <span style="font-size:11px; font-style:italic; color:#EA7500; font-weight:bold">  Only supported extension is .xlsx  . format should be   <a href="<? echo $site['url-wtos'] ?>xcelFormats/student_data_format.xlsx">  <b>Download Format</b> </a> </span><br /><br />

        <select name="form_class_id" id="form_class_id" class="textbox fWidth" ><option value="">Select  </option>	<?
        $os->onlyOption($os->classList,'');	?></select>
        <select name="form_asession" id="form_asession" class="textbox fWidth" ><option value="">Select asession</option>	<?
        $os->onlyOption($os->asession,'');	?></select>

        <select name="form_board" id="form_board" class="textbox fWidth" ><option value="">Select Board</option>	<?
        $os->onlyOption($os->board,'');	?></select>




        <input type="button" name="button" value="Upload Xcel"  style="cursor:pointer; color:#009900" onclick="form_application_excel_submit()" />

        <div id="file_upload_message" style="color:#FF0000;"> </div>

    </div>
    <script>
        function popDialogWH(elementId,titles,W,H)
        {
            os.getObj('application_form_data_file').files[0]='';
            os.getObj(elementId).title=titles;
            $( function() {
                $( "#"+elementId ).dialog({
                    width: W,
                    height: H,
                    modal: true});
            } );

        }

        function form_application_excel_submit()
        {
            var formdata = new FormData();
            var application_form_data_fileVal='';

            if(os.getObj('application_form_data_file').files[0]){
                var application_form_data_fileVal= os.getObj('application_form_data_file').files[0];
            }
            var session_val=os.getVal('form_asession');
            var class_id_val=os.getVal('form_class_id');
            var board_val=os.getVal('form_board');



            if(session_val==''  )
            {

                alert ('Please select Session'); return false;

            }

            if(class_id_val==''  )
            {

                // alert ('Please select   Class'); return false;

            }

            if(board_val==''  )
            {

                alert ('Please select   Board'); return false;

            }





            if(application_form_data_fileVal == "")
            {
                alert('Please select excel file  '); return false;
            }
            else
            {
                var p=confirm('Excel File to upload : '+application_form_data_fileVal.name)
                if(!p)
                {
                    return false;
                }


            }






            formdata.append('form_asession',session_val );
            formdata.append('form_class_id',class_id_val );
            formdata.append('form_board',board_val );


            formdata.append('registration_data_entry_direct','OK' );

            if(application_form_data_fileVal){
                formdata.append('application_form_data_file',application_form_data_fileVal,application_form_data_fileVal.name );
            }

            var url='<? echo $ajaxFilePath ?>?confirm_excel_upload=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('registration_data_entry_result',url,formdata);


        }

        function registration_data_entry_result(data)
        {
            if(!data)
            {
                $('#exel_upload_form').dialog('close');
                WT_historyListing();
            }else
            {

                os.setHtml('file_upload_message',data);
            }


        }
    </script>

    <!-- upload form   end -->

    <script>
        function setClass(id,classStyleName)
        {
            os.getObj(id).className=classStyleName;
        }
        function getTotalFees()
        {

        }
        function duplicateNameSearch()
        {
            var historyIdVal= os.getVal('historyId');

            if(historyIdVal=='0')
            {
                var formdata = new FormData();
                var nameVal= os.getVal('name');
                formdata.append('name',nameVal );
                var WT_historypagingPageno=os.getVal('WT_historypagingPageno');
                var url='wtpage='+WT_historypagingPageno;
                url='<? echo $ajaxFilePath ?>?duplicateNameSearch=OK&'+url;
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

                os.setAjaxFunc('duplicateHistoryDivresults',url,formdata);
                //os.setAjaxHtml('WT_duplicateHistoryDiv',url,formdata);
            }
        }
        function  duplicateHistoryDivresults(data)
        {
            os.hide('WT_duplicateHistoryDivMain');

            if(data!='')
            {
                os.setHtml('WT_duplicateHistoryDiv',data);
                os.show('WT_duplicateHistoryDivMain');
            }
        }
        function WT_historyListing() // list table searched data get
        {

            setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');



            var formdata = new FormData();



            var sortBy_sVal= os.getVal('sortBy_s');
            var regFeesstatus_sVal= os.getVal('regFeesstatus_s');
            var kanyashree_sVal= os.getVal('kanyashree_s');
            var yuvashree_sVal= os.getVal('yuvashree_s');
            var historyStatus_sVal= os.getVal('historyStatus_s');
            var asession_sVal= os.getVal('asession_s');
            var registrationNo_sVal= os.getVal('registrationNo_s');
            var class_sVal= os.getVal('class_s');
            var section_sVal= os.getVal('section_s');
            var board_sVal= os.getVal('board_s');
            var admission_no_sVal= os.getVal('admission_no_s');
            var f_admission_date_sVal= os.getVal('f_admission_date_s');
            var t_admission_date_sVal= os.getVal('t_admission_date_s');
            var roll_no_sVal= os.getVal('roll_no_s');
            var studentId_sVal= os.getVal('studentId_s');
            var full_marks_sVal= os.getVal('full_marks_s');
            var obtain_marks_sVal= os.getVal('obtain_marks_s');
            var percentage_sVal= os.getVal('percentage_s');
            var pass_fail_sVal= os.getVal('pass_fail_s');
            var grade_sVal= os.getVal('grade_s');
            var remarks_sVal= os.getVal('remarks_s');
            var studentName_sVal= os.getVal('studentName_s');
            var stream_sVal= os.getVal('stream_s');
            var admissionType_sVal= os.getVal('admissionType_s');


            formdata.append('sortBy_s',sortBy_sVal);
            formdata.append('admissionType_s',admissionType_sVal);
            formdata.append('stream_s',stream_sVal );
            formdata.append('studentName_s',studentName_sVal );
            formdata.append('historyStatus_s',historyStatus_sVal );
            formdata.append('asession_s',asession_sVal );
            formdata.append('registrationNo_s',registrationNo_sVal );
            formdata.append('class_s',class_sVal );
            formdata.append('board_s',board_sVal );
            formdata.append('section_s',section_sVal );
            formdata.append('admission_no_s',admission_no_sVal );
            formdata.append('f_admission_date_s',f_admission_date_sVal );
            formdata.append('t_admission_date_s',t_admission_date_sVal );
            formdata.append('roll_no_s',roll_no_sVal );
            formdata.append('studentId_s',studentId_sVal );
            formdata.append('full_marks_s',full_marks_sVal );
            formdata.append('obtain_marks_s',obtain_marks_sVal );
            formdata.append('percentage_s',percentage_sVal );
            formdata.append('pass_fail_s',pass_fail_sVal );
            formdata.append('grade_s',grade_sVal );
            formdata.append('remarks_s',remarks_sVal );
            formdata.append('kanyashree_s',kanyashree_sVal );
            formdata.append('yuvashree_s',yuvashree_sVal );
            formdata.append('regFeesstatus_s',regFeesstatus_sVal );
            formdata.append('searchKey',os.getVal('searchKey') );

            var board_sVal= os.getVal('board_s');
            formdata.append('board_s',board_sVal);

            var gender_sVal= os.getVal('gender_s');
            formdata.append('gender_s',gender_sVal);


            var board_sVal= os.getVal('branch_code_s');
            formdata.append('branch_code_s',board_sVal);
			
			 var status_active_sVal= os.getVal('status_active_s');
            formdata.append('status_active_s',status_active_sVal);
			
			
			
			

            formdata.append('showPerPage',os.getVal('showPerPage') );
            var WT_historypagingPageno=os.getVal('WT_historypagingPageno');
            var url='wtpage='+WT_historypagingPageno;
            url='<? echo $ajaxFilePath ?>?WT_historyListing=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_historyListDiv',url,formdata);



        }
        WT_historyListing();
        function  searchReset() // reset Search Fields
        {
            os.setVal('studentName_s','');
            os.setVal('regFeesstatus_s','');
            os.setVal('asession_s','');
            os.setVal('registrationNo_s','');
            os.setVal('class_s','');
            os.setVal('section_s','');
            os.setVal('admission_no_s','');
            os.setVal('f_admission_date_s','');
            os.setVal('t_admission_date_s','');
            os.setVal('roll_no_s','');
            os.setVal('studentId_s','');
            os.setVal('full_marks_s','');
            os.setVal('obtain_marks_s','');
            os.setVal('percentage_s','');
            os.setVal('pass_fail_s','');
            os.setVal('grade_s','');
            os.setVal('remarks_s','');

            os.setVal('stream_s','');
            os.setVal('admissionType_s','');
            os.setVal('sortBy_s','');
            os.setVal('historyStatus_s','Active');
			os.setVal('status_active_s','Y');
			
			
            os.setVal('searchKey','');
            os.setVal('branch_code_s','');
            os.setVal('gender_s','');

            WT_historyListing();
            setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');
        }

        var global_saveandstay='NO';
        function WT_historyEditAndSave(saveandstay)  // collect data and send to save
        {
            alert('aa');
            var formdata = new FormData();
            //------------HISTORY DATA------
            var historyStatusVal= os.getVal('historyStatus');
            var asessionVal= os.getVal('asession');
            var registrationNoVal= os.getVal('registrationNo');
            var classVal= os.getVal('class');
            var sectionVal= os.getVal('section');
            var admission_noVal= os.getVal('admission_no');
            var admission_dateVal= os.getVal('admission_date');
            var roll_noVal= os.getVal('roll_no');
            var studentIdVal= os.getVal('studentId');
            var full_marksVal= os.getVal('full_marks');
            var obtain_marksVal= os.getVal('obtain_marks');
            var percentageVal= os.getVal('percentage');
            var pass_failVal= os.getVal('pass_fail');
            var gradeVal= os.getVal('grade');
            var remarksVal= os.getVal('remarks');


            var outGoingTcNoVal= os.getVal('outGoingTcNo');
            var outGoingTcDateVal= os.getVal('outGoingTcDate');
            var inactiveDateVal= os.getVal('inactiveDate');
            var streamVal= os.getVal('stream');
            var admissionTypeVal= os.getVal('admissionType');


            formdata.append('admissionType',admissionTypeVal);
            formdata.append('stream',streamVal);
            formdata.append('outGoingTcNo',outGoingTcNoVal);
            formdata.append('outGoingTcDate',outGoingTcDateVal);
            formdata.append('inactiveDate',inactiveDateVal);

            formdata.append('historyStatus',historyStatusVal );
            formdata.append('asession',asessionVal );
            formdata.append('registrationNo',registrationNoVal );
            formdata.append('class',classVal );
            formdata.append('section',sectionVal );
            formdata.append('admission_no',admission_noVal );
            formdata.append('admission_date',admission_dateVal );
            formdata.append('roll_no',roll_noVal );
            formdata.append('studentId',studentIdVal );
            formdata.append('full_marks',full_marksVal );
            formdata.append('obtain_marks',obtain_marksVal );
            formdata.append('percentage',percentageVal );
            formdata.append('pass_fail',pass_failVal );
            formdata.append('grade',gradeVal );
            formdata.append('remarks',remarksVal );

            //------------END HISTORY DATA------
            //------------STUDENT DATA------
            var kanyashreeVal= os.getVal('kanyashree');
            var yuvashreeVal= os.getVal('yuvashree');
            var boardVal= os.getVal('board');
            var feesPaymentVal= os.getVal('feesPayment');
            var nameVal= os.getVal('name');
            var dobVal= os.getVal('dob');
            var ageVal= os.getVal('age');
            var genderVal= os.getVal('gender');
            var registerDateVal= os.getVal('registerDate');
            var registerNoVal= os.getVal('registerNo');
            var uidVal= os.getVal('uid');
            var casteVal= os.getVal('caste');
            var subcastVal= os.getVal('subcast');
            var apl_bplVal= os.getVal('apl_bpl');
            var minorityVal= os.getVal('minority');
            var adhar_nameVal= os.getVal('adhar_name');
            var adhar_dobVal= os.getVal('adhar_dob');
            var adhar_noVal= os.getVal('adhar_no');
            var phVal= os.getVal('ph');
            var ph_percentVal= os.getVal('ph_percent');
            var disableVal= os.getVal('disable');
            var disable_percentVal= os.getVal('disable_percent');
            var father_nameVal= os.getVal('father_name');

            var father_ocuVal= os.getVal('father_ocu');
            var father_adharVal= os.getVal('father_adhar');
            var mother_nameVal= os.getVal('mother_name');
            var mother_ocuVal= os.getVal('mother_ocu');
            var mother_adharVal= os.getVal('mother_adhar');
            var villVal= os.getVal('vill');
            var poVal= os.getVal('po');
            var psVal= os.getVal('ps');
            var distVal= os.getVal('dist');
            var blockVal= os.getVal('block');
            var pinVal= os.getVal('pin');
            var stateVal= os.getVal('state');
            var guardian_nameVal= os.getVal('guardian_name');
            var guardian_relationVal= os.getVal('guardian_relation');
            var guardian_addressVal= os.getVal('guardian_address');
            var guardian_ocuVal= os.getVal('guardian_ocu');
            var anual_incomeVal= os.getVal('anual_income');
            var mobile_studentVal= os.getVal('mobile_student');
            var mobile_guardianVal= os.getVal('mobile_guardian');
            var mobile_emergencyVal= os.getVal('mobile_emergency');
            var email_studentVal= os.getVal('email_student');
            var email_guardianVal= os.getVal('email_guardian');
            var mother_tongueVal= os.getVal('mother_tongue');
            var blood_groupVal= os.getVal('blood_group');
            var religianVal= os.getVal('religian');
            var other_religianVal= os.getVal('other_religian');
            var imageVal= os.getObj('image').files[0];
            //alert(imageVal);
            var last_schoolVal= os.getVal('last_school');
            var last_classVal= os.getVal('last_class');
            var tc_noVal= os.getVal('tc_no');
            var tc_dateVal= os.getVal('tc_date');
            var studentRemarksVal= os.getVal('studentRemarks');
            var accNoVal= os.getVal('accNo');
            var accHolderNameVal= os.getVal('accHolderName');
            var ifscCodeVal= os.getVal('ifscCode');
            var branchVal= os.getVal('branch');
            formdata.append('accNo',accNoVal );
            formdata.append('accHolderName',accHolderNameVal );
            formdata.append('ifscCode',ifscCodeVal );
            formdata.append('branch',branchVal );

            formdata.append('kanyashree',kanyashreeVal );
            formdata.append('yuvashree',yuvashreeVal );
            formdata.append('board',boardVal );
            formdata.append('feesPayment',feesPaymentVal );
            formdata.append('name',nameVal );
            formdata.append('dob',dobVal );
            formdata.append('age',ageVal );
            formdata.append('gender',genderVal );
            formdata.append('registerDate',registerDateVal );
            formdata.append('registerNo',registerNoVal );
            formdata.append('uid',uidVal );
            formdata.append('caste',casteVal );
            formdata.append('subcast',subcastVal );
            formdata.append('apl_bpl',apl_bplVal );
            formdata.append('minority',minorityVal );
            formdata.append('adhar_name',adhar_nameVal );
            formdata.append('adhar_dob',adhar_dobVal );
            formdata.append('adhar_no',adhar_noVal );
            formdata.append('ph',phVal );
            formdata.append('ph_percent',ph_percentVal );
            formdata.append('disable',disableVal );
            formdata.append('disable_percent',disable_percentVal );
            formdata.append('father_name',father_nameVal );
            formdata.append('father_ocu',father_ocuVal );
            formdata.append('father_adhar',father_adharVal );
            formdata.append('mother_name',mother_nameVal );
            formdata.append('mother_ocu',mother_ocuVal );
            formdata.append('mother_adhar',mother_adharVal );
            formdata.append('vill',villVal );
            formdata.append('po',poVal );
            formdata.append('ps',psVal );
            formdata.append('dist',distVal );
            formdata.append('block',blockVal );
            formdata.append('pin',pinVal );
            formdata.append('state',stateVal );
            formdata.append('guardian_name',guardian_nameVal );
            formdata.append('guardian_relation',guardian_relationVal );
            formdata.append('guardian_address',guardian_addressVal );
            formdata.append('guardian_ocu',guardian_ocuVal );
            formdata.append('anual_income',anual_incomeVal );
            formdata.append('mobile_student',mobile_studentVal );
            formdata.append('mobile_guardian',mobile_guardianVal );
            formdata.append('mobile_emergency',mobile_emergencyVal );
            formdata.append('email_student',email_studentVal );
            formdata.append('email_guardian',email_guardianVal );
            formdata.append('mother_tongue',mother_tongueVal );
            formdata.append('blood_group',blood_groupVal );
            formdata.append('religian',religianVal );
            formdata.append('other_religian',other_religianVal );
            if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
            formdata.append('last_school',last_schoolVal );
            formdata.append('last_class',last_classVal );
            formdata.append('tc_no',tc_noVal );
            formdata.append('tc_date',tc_dateVal );
            formdata.append('studentRemarks',studentRemarksVal );

            //------------END STUDENT DATA------


            if(os.check.empty('name','Please Add Name')==false){ return false;}
            if(os.check.empty('dob','Please Add D.O.B')==false){ return false;}
            //if(os.check.empty('board','Please Add board')==false){ return false;}
            if(os.check.empty('asession','Please Add session')==false){ return false;}
            if(os.check.empty('class','Please Add class')==false){ return false;}
            //if(os.check.empty('admission_date','Please Add admission date')==false){ return false;}

            if(historyStatusVal=='Inactive')
            {
                if(os.check.empty('inactiveDate','Please Add Inactive Date')==false){ return false;}
            }
            var   historyId=os.getVal('historyId');
            if(historyId<1){ return false;}



            formdata.append('historyId',historyId );
            //add 21/11/2018 to prevent duplicate entry


            //End add 21/11/2018 to prevent duplicate entry
            var url='<? echo $ajaxFilePath ?>?WT_historyEditAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_historyReLoadList',url,formdata);
        }
        function WT_historyReLoadList(data) // after edit reload list
        {
            //alert(data);
            var d=data.split('#-#');
            var historyId=parseInt(d[0]);

            if(d[0]!='Error' && historyId>0)
            {
                os.setVal('historyId',historyId);
                if(global_saveandstay == 'NO'){
                    setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');
                }
                if(global_saveandstay == 'OK'){
                    var studentId=parseInt(d[2]);
                    os.setVal('studentId',studentId);
                    os.setVal('uid',studentId);
                    setFeesIframes(historyId,studentId);

                }

            }
            if(d[1]!='')
            {

                alert(d[1]);

            }


            var asessionVal=os.getVal('asession');
            var boardVal=os.getVal('board');
            var classVal=os.getVal('class');
            var streamVal=os.getVal('stream');

            os.setVal('asession_s',asessionVal);
            os.setVal('board_s',boardVal);
            os.setVal('class_s',classVal);
            os.setVal('stream_s',streamVal);


            showStudent(historyId)


            //WT_historyListing();
        }
        function WT_historyGetById(historyId) // get record by table primery id
        {
            var formdata = new FormData();
            formdata.append('historyId',historyId );
            var url='<? echo $ajaxFilePath ?>?WT_historyGetById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_historyFillData',url,formdata);



        }
        function WT_historyFillData(data)  // fill data form by JSON
        {
            // alert(data);



            var history_class_data=	getData(data,'##-HISTORY-LIST-CLASS-DATA-##');
            os.setHtml('all_session_history_data_DIV',history_class_data);

            var history_DOC_data=	getData(data,'##-STUDENT-DOCUMENTS-LINKS-##');
            os.setHtml('student_doc_link_DIV',history_DOC_data);




            var  content_data=	getData(data,'##-HISTORY-DATA-##');


            var objJSON = JSON.parse(content_data);
            os.setVal('historyId',parseInt(objJSON.historyId));
            os.setVal('registrationFeesStatus',objJSON.registrationFeesStatus);
            os.setVal('registrationFees',objJSON.registrationFees);
            os.setVal('historyStatus',objJSON.historyStatus);
            os.setVal('asession',objJSON.asession);
            os.setVal('registrationNo',objJSON.registrationNo);
            os.setVal('class',objJSON.class);
            os.setVal('section',objJSON.section);
            os.setVal('admission_no',objJSON.admission_no);
            os.setVal('admission_date',objJSON.admission_date);
            os.setVal('roll_no',objJSON.roll_no);
            os.setVal('studentId',objJSON.studentId);
            os.setVal('full_marks',objJSON.full_marks);
            os.setVal('obtain_marks',objJSON.obtain_marks);
            os.setVal('percentage',objJSON.percentage);
            os.setVal('pass_fail',objJSON.pass_fail);
            os.setVal('grade',objJSON.grade);
            os.setVal('remarks',objJSON.remarks);

            os.setVal('totalFees',objJSON.totalFees);
            os.setVal('monthlyFees',objJSON.monthlyFees);

            os.setVal('outGoingTcNo',objJSON.outGoingTcNo);
            os.setVal('outGoingTcDate',objJSON.outGoingTcDate);

            os.setVal('inactiveDate',objJSON.inactiveDate);
            os.setVal('stream',objJSON.stream);


            os.setVal('admissionType',objJSON.admissionType);

            if(objJSON.admissionType=='Re Admission')
            {
                os.setHtml('admissionTypeVal','Re ');
            }
            else
            {
                os.setHtml('admissionTypeVal','');
            }










            if(objJSON.formNo!='0')
            {
                os.setVal('formNo',objJSON.formNo);
            }
            else
            {
                os.setVal('formNo','');
            }
///STUDENT FILL DATA Section
os.setVal('accNo',objJSON.accNo);
os.setVal('accHolderName',objJSON.accHolderName);
os.setVal('ifscCode',objJSON.ifscCode);
os.setVal('branch',objJSON.branch);
os.setVal('kanyashree',objJSON.kanyashree);
os.setVal('yuvashree',objJSON.yuvashree);
os.setVal('board',objJSON.board);
os.setVal('feesPayment',objJSON.feesPayment);

os.setVal('name',objJSON.name);
os.setVal('dob',objJSON.dob);
os.setVal('age',objJSON.age);
os.setVal('gender',objJSON.gender);
os.setVal('registerDate',objJSON.registerDate);
os.setVal('registerNo',objJSON.registerNo);
// os.setVal('uid',objJSON.uid);
os.setVal('uid',objJSON.studentId);
os.setVal('caste',objJSON.caste);
os.setVal('subcast',objJSON.subcast);
os.setVal('apl_bpl',objJSON.apl_bpl);
os.setVal('minority',objJSON.minority);
os.setVal('adhar_name',objJSON.adhar_name);
os.setVal('adhar_dob',objJSON.adhar_dob);
os.setVal('adhar_no',objJSON.adhar_no);
os.setVal('ph',objJSON.ph);
os.setVal('ph_percent',objJSON.ph_percent);
os.setVal('disable',objJSON.disable);
os.setVal('disable_percent',objJSON.disable_percent);
os.setVal('father_name',objJSON.father_name);
os.setVal('father_ocu',objJSON.father_ocu);
os.setVal('father_adhar',objJSON.father_adhar);
os.setVal('mother_name',objJSON.mother_name);
os.setVal('mother_ocu',objJSON.mother_ocu);
os.setVal('mother_adhar',objJSON.mother_adhar);
os.setVal('vill',objJSON.vill);
os.setVal('po',objJSON.po);
os.setVal('ps',objJSON.ps);
os.setVal('dist',objJSON.dist);
os.setVal('block',objJSON.block);
os.setVal('pin',objJSON.pin);
os.setVal('state',objJSON.state);
os.setVal('guardian_name',objJSON.guardian_name);
os.setVal('guardian_relation',objJSON.guardian_relation);
os.setVal('guardian_address',objJSON.guardian_address);
os.setVal('guardian_ocu',objJSON.guardian_ocu);
os.setVal('anual_income',objJSON.anual_income);
os.setVal('mobile_student',objJSON.mobile_student);
os.setVal('mobile_guardian',objJSON.mobile_guardian);
os.setVal('mobile_emergency',objJSON.mobile_emergency);
os.setVal('email_student',objJSON.email_student);
os.setVal('email_guardian',objJSON.email_guardian);
os.setVal('mother_tongue',objJSON.mother_tongue);
os.setVal('blood_group',objJSON.blood_group);
os.setVal('religian',objJSON.religian);
os.setVal('other_religian',objJSON.other_religian);
os.setImg('imagePreview',objJSON.image);
os.setVal('last_school',objJSON.last_school);
os.setVal('last_class',objJSON.last_class);
os.setVal('tc_no',objJSON.tc_no);
os.setVal('tc_date',objJSON.tc_date);
os.setVal('studentRemarks',objJSON.studentRemarks);

if(objJSON.studentId>0)
{
    os.setVal('st_name_for_show',objJSON.name);
}else
{

    os.setVal('st_name_for_show','');
}



            ///END STUDENT FILL DATA SECTION
            //ajaxViewFees(objJSON.historyId);
            //ajaxViewRegPayment(objJSON.historyId);
            // setStudentFees();
            //setFeesIframes(objJSON.historyId,objJSON.studentId);
            //setExamIframes(objJSON.studentId,objJSON.class);
        }
        function importFormNo()
        {
            os.setVal('historyId','0');
            os.setVal('studentId','0');
            formNo=os.getVal('formNo');
            if(formNo=='0'||formNo=='')
            {
                alert('Please Enter form No.', 'warning');
                return false;
            }
            var formdata = new FormData();
            formdata.append('formNo',formNo );
            var url='<? echo $ajaxFilePath ?>?getformData=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('fillDataByFormNo',url,formdata);
        }

        function fillDataByFormNo(data)
        {
            //alert(data);

            if(data=='Form No Already Added.'){
                alert(data);
                return false;


            }


            var objJSON = JSON.parse(data);
            os.setVal('name',objJSON.name);
            os.setVal('dob',objJSON.dob);
            os.setVal('apl_bpl',objJSON.apl_bpl);
            os.setVal('father_name',objJSON.father_name);
            os.setVal('mother_name',objJSON.mother_name);
            os.setVal('guardian_name',objJSON.guardian_name);
            //os.setImg('imagePreview','wtos/images/student_img.png');
            os.setImg('imagePreview','<?echo $site['url']?>wtos/images/student_img.png');


            os.setVal('vill',objJSON.vill);
            os.setVal('pin',objJSON.pin);
            os.setVal('po',objJSON.po);
            os.setVal('ps',objJSON.ps);
            os.setVal('dist',objJSON.dist);
            os.setVal('block',objJSON.block);
            os.setVal('state',objJSON.state);
            os.setVal('gender',objJSON.gender);
            os.setVal('caste',objJSON.caste);
            os.setVal('class',objJSON.class);
            os.setVal('board',objJSON.board);
            os.setVal('mobile_student',objJSON.mobile_student);
            os.setVal('adhar_no',objJSON.adhar_no);
            os.setVal('historyStatus','Active');
            os.setVal('admissionType',objJSON.admissionType);
            if(objJSON.admissionType=='Re Admission')
            {
                os.setHtml('admissionTypeVal','Re ');
            }
            else
            {
                os.setHtml('admissionTypeVal','');
            }
            os.setVal('accNo',objJSON.accNo);
            os.setVal('accHolderName',objJSON.accHolderName);
            os.setVal('ifscCode',objJSON.ifscCode);
            os.setVal('branch',objJSON.branch);
            os.setVal('uid','');
            os.setVal('admissionFees','');
            os.setVal('donationFees','');
            os.setVal('registrationFees','');
            os.setVal('registrationFeesStatus','Unpaid');
            os.setVal('monthlyFees','');
            os.setVal('totalFees','');

            os.hide('monthlyFeesPayment');
            os.hide('registrationFeesPayment');
        }

        function refreshRegFeesIframe()
        {
            var historyId=os.getVal('historyId');
            var studentId=os.getVal('studentId');
            var registrationFeesFL='paymentDataView.php?historyId='+historyId+'&studentId='+studentId+'&key=selectedData';
            os.getObj('registrationFeesPayment').src=registrationFeesFL;
        }
        function refreshMonthlyFeesIframe()
        {
            var historyId=os.getVal('historyId');
            var studentId=os.getVal('studentId');
            var monthlyFeesFL='feesDataView.php?historyId='+historyId+'&studentId='+studentId+'&key=selectedData';
            os.getObj('monthlyFeesPayment').src=monthlyFeesFL;
        }
        function setFeesIframes(historyId,studentId)
        {
            // alert();
            var registrationFeesFL='paymentDataView.php?historyId='+historyId+'&studentId='+studentId+'&key=selectedData';
            os.getObj('registrationFeesPayment').src=registrationFeesFL;
            os.show('registrationFeesDivForIframe');
            os.show('registrationFeesPayment');
            var monthlyFeesFL='feesDataView.php?historyId='+historyId+'&studentId='+studentId+'&key=selectedData';
            os.getObj('monthlyFeesPayment').src=monthlyFeesFL;
            os.show('monthlyFeesDivForIframe');
            os.show('monthlyFeesPayment');
        }
        function setExamIframes(studentId,studentClass)
        {

            var examdetailsFL='examdetailsDataView.php?studentClass='+studentClass+'&key=selectedData';
            os.getObj('examdetails').src=examdetailsFL;
            os.show('examDivForIframe');
            os.show('examdetails');
            var resultDetailsFL='resultsdetailsDataView.php?studentId='+studentId+'&studentClass='+studentClass+'&key=selectedData';
            os.getObj('resultDetails').src=resultDetailsFL;
            os.show('resultDetailsDivForIframe');
            os.show('resultDetails');
        }
        function hideFeesIframes(historyId,studentId)
        {
            var registrationFeesFL='paymentDataView.php?historyId='+historyId+'&studentId='+studentId;
            os.getObj('registrationFeesPayment').src=registrationFeesFL;

            os.hide('registrationFeesPayment');

            var monthlyFeesFL='feesDataView.php?historyId='+historyId+'&studentId='+studentId+'&key=selectedData';
            os.getObj('monthlyFeesPayment').src=monthlyFeesFL;

            os.hide('monthlyFeesPayment');
        }
        function setStudentFees() // not in use
        {

            var formdata = new FormData();
            var historyIdVal= os.getVal('historyId');

            formdata.append('historyId',historyIdVal );
            //var WT_historypagingPageno=os.getVal('WT_historypagingPageno');

            var WT_historypagingPageno='';
            var url='wtpage='+WT_historypagingPageno;
            url='<? echo $ajaxFilePath ?>?setStudentFees=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_duplicateHistoryDiv',url,formdata); // not in use
        }
        function checkEditDeletePassword()
        {

            var password= prompt("Please Enter Delete Password");
            if(password)
            {
                var formdata = new FormData();
                var  historyId =os.getVal('historyId');
                formdata.append('historyId',historyId );
                formdata.append('password',password );

                var url='<? echo $ajaxFilePath ?>?checkEditDeletePassword=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('checkEditDeletePasswordResult',url,formdata);

            }
        }
        function checkEditDeletePasswordResult(data)
        {
            if(data=='wrong password')
            {
                alert(data, 'danger');
            }
            else
            {
                var d=data.split('#-#');
                var historyId=parseInt(d[1]);
                WT_historyDeleteRowById(historyId);

            }

        }
        function WT_historyDeleteRowById(historyId) // delete record by table id
        {
//alert('abcd');
var formdata = new FormData();
if(parseInt(historyId)<1 || historyId==''){
    var  historyId =os.getVal('historyId');
}
if(parseInt(historyId)<1){ alert('No record Selected', 'warning'); return;}
            //alert(historyId);
            var p =confirm('Are you Sure? You want to delete this record forever.')
            if(p){
                formdata.append('historyId',historyId );
                var url='<? echo $ajaxFilePath ?>?WT_historyDeleteRowById=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_historyDeleteRowByIdResults',url,formdata);
            }

        }
        function WT_historyDeleteRowByIdResults(data)
        {
            //alert(data);

            WT_historyListing();
        }
        function wtAjaxPagination(pageId,pageNo)// pagination function
        {
            os.setVal('WT_historypagingPageno',parseInt(pageNo));

            WT_historyListing();
        }

        function	openFees(historyId,studentId)
        {
//alert(studentId);
var URLStr='feesDataView.php?historyId='+historyId+'&studentId='+studentId+'&key=selectedDataByFeesButton';
//popUpWindow(URLStr, 10, 10, 1200, 700);
window.location=URLStr;
}
function	openRegPrint(formNo)
{
    var URLStr='<?echo $site['url']?>wtosApps/admissionPrint.php?admissionId='+formNo;
    popUpWindow(URLStr, 10, 10, 800, 700);
}
function	openResult(studentId)
{
    var URLStr='<?echo $site['url-wtos']?>resultPrint.php?studentId='+studentId;
    popUpWindow(URLStr, 10, 10, 800, 700);
}
</script>
<script>
    function addStudent()
    {
////added on 8.10.2018	////////

os.setVal('st_name_for_show','NEW REGISTRATION');

var defaultImg="<?php echo $site['url-wtos'] ?>"+'images/student_img.png';
os.setImg('imagePreview',defaultImg);
os.setHtml('admissionTypeVal','');
var asessionVal=os.getVal('asession_s');
var boardVal=os.getVal('board_s');
var classVal=os.getVal('class_s');
var streamVal=os.getVal('stream_s');
os.setVal('stream',streamVal);
os.setVal('asession',asessionVal);
os.setVal('board',boardVal);
os.setVal('class',classVal);
////end added on 8.10.2018	////////
os.setVal('historyId','0');
os.setVal('registrationNo','');
os.setVal('formNo','');
os.setVal('section','');
os.setVal('admission_no','');
//os.setVal('admission_date','');
os.setVal('roll_no','');
os.setVal('studentId','');
os.setVal('full_marks','');
os.setVal('obtain_marks','');
os.setVal('percentage','');
os.setVal('pass_fail','');
os.setVal('grade','');
os.setVal('remarks','');
os.setVal('admissionType','');

///STUDENT FILL DATA Section

os.setVal('name','');
os.setVal('dob','');
os.setVal('age','');
os.setVal('gender','');
os.setVal('registerDate','');
os.setVal('registerNo','');
os.setVal('uid','');
os.setVal('caste','');
os.setVal('subcast','');
os.setVal('apl_bpl','');
os.setVal('minority','');
os.setVal('adhar_name','');
os.setVal('adhar_dob','');
os.setVal('adhar_no','');
os.setVal('ph','');
os.setVal('ph_percent','');
os.setVal('disable','');
os.setVal('disable_percent','');
os.setVal('father_name','');
os.setVal('father_ocu','');
os.setVal('father_adhar','');
os.setVal('mother_name','');
os.setVal('mother_ocu','');
os.setVal('mother_adhar','');
os.setVal('vill','');
os.setVal('po','');
os.setVal('ps','');
os.setVal('dist','');
os.setVal('block','');
os.setVal('pin','');
os.setVal('state','');
os.setVal('guardian_name','');
os.setVal('guardian_relation','');
os.setVal('guardian_address','');
os.setVal('guardian_ocu','');
os.setVal('anual_income','');
os.setVal('mobile_student','');
os.setVal('mobile_guardian','');
os.setVal('mobile_emergency','');
os.setVal('email_student','');
os.setVal('email_guardian','');
os.setVal('mother_tongue','');
os.setVal('blood_group','');
os.setVal('religian','');
os.setVal('other_religian','');

os.setVal('last_school','');
os.setVal('last_class','');
os.setVal('tc_no','');
os.setVal('tc_date','');
os.setVal('studentRemarks','');
os.setVal('registrationFees','');
os.setVal('monthlyFees','');
os.setVal('totalFees','');
os.setVal('admissionFees','');
os.setVal('donationFees','');
document.getElementById("registrationFees").readOnly = false;
document.getElementById("monthlyFees").readOnly = false;
document.getElementById("totalFees").readOnly = false;
document.getElementById("admissionFees").readOnly = false;
document.getElementById("donationFees").readOnly = false;



//hideFeesIframes(0,0);

}


function loadMoredata()
{
    var MoreStudentData_status= os.getObj('MoreStudentData').style.display;

    if(MoreStudentData_status=='none')
    {
        os.showj('MoreStudentData');
        os.setHtml('spmorebutton','Hide More');
    }

    if(MoreStudentData_status=='block' || MoreStudentData_status=='' )
    {
        os.hidej('MoreStudentData');
        os.setHtml('spmorebutton','More');

    }




}


</script>
<script>
    function CheckAll(legendId,data_arr_name)
    {


        var todo=os.getObj(legendId).checked;
        var x = document.getElementsByName(data_arr_name);

        var i;
        for (i = 0; i < x.length; i++) {

            x[i].checked=todo;

        }

    }


    function getHistoryId(checkBoxName)
    {

        var historyIds='';
        var multiCheck= document.getElementsByName(checkBoxName);
        for (i = 0; i < multiCheck.length; i++)
        {
            atObj = multiCheck[i] ;
            if(atObj.checked==true)
            {
                historyIds=historyIds+atObj.value+',';
            }
        }
        os.setVal('historyId',historyIds);
    }

    function	openPrintId(ids)
    {
        var historyIds=	getValuesFromCheckedBox(ids);
            //historyId=os.getVal('historyId');
            //if(historyId=='0')
            //{
            //	alert('Please Select Student');
            //	return false;
            //}
            if(historyIds==''){ alert('Please select atleast one record', 'warning'); return false;}


            var URLStr='printIdCard.php?historyId='+historyIds;
            popUpWindow(URLStr, 10, 10, 1200, 600);

        }

        function	open_barcode_PrintId(ids)
        {
            var historyIds=	getValuesFromCheckedBox(ids);
            //historyId=os.getVal('historyId');
            //if(historyId=='0')
            //{
            //	alert('Please Select Student');
            //	return false;
            //}
            if(historyIds==''){ alert('Please select atleast one record', 'warning'); return false;}


            var URLStr='printId_student_barcode.php?historyId='+historyIds;
            popUpWindow(URLStr, 10, 10, 1200, 600);

        }



        function openPrintId_single(historyId)
        {


            if(historyId=='0')
            {
                alert('Please Select Student', 'warning');
                return false;
            }

            var URLStr='printIdCard.php?historyId='+historyId;
            popUpWindow(URLStr, 10, 10, 1200, 600);

        }



        function	addFees()
        {


            var addFeesAccess='<? echo $os->checkAccess('Add Fees') ?>';
            if(addFeesAccess=='')
            {
                alert('You dont have access for add', 'danger');
                return false;
            }




            var formdata = new FormData();
            var historyIdVal=os.getVal('historyId');
            var asessionVal=os.getVal('asession_s');
            if(historyIdVal=='0')
            {
                alert('Please Select Student', 'warning');
                return false;
            }
            if(os.check.empty('asession_s','Please Select Session')==false){ return false;}
            formdata.append('historyId',historyIdVal );
            formdata.append('asession',asessionVal );
            var feesAmount = prompt("Are you Sure? You want to add fees.\n\nAdd fees amount for all students",'0');
            if(feesAmount){
                var feesAmount=feesAmount.trim();
                if(feesAmount!='')
                {

                    formdata.append('fees_amount',feesAmount );



                    var url='<? echo $ajaxFilePath ?>?addFees=OK&';
                    os.animateMe.div='div_busy';
                    os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                    os.setAjaxFunc('alertAddFees',url,formdata);
                }


            }
        }
        function alertAddFees(data) // after edit reload list
        {

            alert(data);
        }

        function closeDuplicateDIV()
        {
            os.hide('WT_duplicateHistoryDivMain');
        }



        function checkEditPasswordForEnableTextBox(id)
        {
            var formdata = new FormData();
            var password= prompt("Please Enter Password");
            if(password)
            {
                formdata.append('enabledFieldId',id);
                formdata.append('password',password );
                var url='<? echo $ajaxFilePath ?>?checkEditPasswordForEnableTextBox=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('checkEditPasswordForEnableTextBoxResult',url,formdata);

            }



        }
        function checkEditPasswordForEnableTextBoxResult(data)
        {
            if(data=='wrong password')
            {
                alert(data);
            }
            else
            {
                var d=data.split('#-#');
                var enabledFieldId=d[1];
                if(enabledFieldId=='registrationFees')
                {

                    document.getElementById('registrationFees').readOnly = false;
                }
                else
                {
                    document.getElementById('monthlyFees').readOnly = false;
                    document.getElementById('totalFees').readOnly = false;
                }

            }

        }

        function excelDownload()
        {
            var c=0;
            var idvalStr='';
            var test = document.getElementsByName('columnName[]');
            for (i = 0; i < test.length; i++)
            {
                if(test[i].checked ==true )
                {
                    var idVal=test[i].value;
                    idvalStr=idvalStr+','+idVal;
                    c++
                }
            }
            //alert(idvalStr);return false;
            if(c==0)
            {
                alert('Please Select Atleast One Checkbox', 'warning');
                return false;
            }
            window.location='historyDownloadExcel.php?field='+idvalStr;
//alert(idvalStr);
}


function load_certificate(historyId,type)
{
    var URLStr='<? echo $site['url-wtos'] ;?>student_certificateDataView.php?historyId='+historyId+'&content_type='+type;
            //alert( URLStr);
            popUpWindow(URLStr, 10, 10, 1200, 600);
        }


        function hidelist()
        {

            os.hide('bulk_link');
            os.hide('ajaxViewMainTableTDList_id');

        }

        function showlist()
        {
            os.show('bulk_link');
            os.show('ajaxViewMainTableTDList_id');


        }





        function showStudent(historyId)
        {
            if(historyId==''){ return false;}

            get_student_profile(historyId);
            //popDialog('showStudent_details_DIV','Student Details : ',{height:600,width:1200,modal:true})

            UIkit.modal('#showStudent_details_DIV').show();

        }




    </script>
    <script>
        var sval = "<?php echo $studentString;?>".split("##");
        $(document).ready(function(){
            $(".studentNameAuto").autocomplete(sval);
            $(".studentNameInnerAuto").autocomplete(sval);
        });

        function setDiscountType()
        {
            os.setHtml('setDiscountType_DIV',os.getVal('admissionType'));

        }
    </script>
    <style>
        .feespayments{ float:left; width:150px; color:#00AE00; font-weight:bold;}
        .feesmonth{ color:#666666;   font-style:italic;font-weight:normal;}
        .headList{ color:#999999;}
        .WT_duplicateHistoryDivclass{ position:fixed; top:10px; left:35%; height:auto;}
        .closeDuplicate{ cursor:pointer; color:#FF0000; font-size:16px; font-weight:bold;}
        .WT_duplicateHistoryDivclass{ background-color:#00CCFF; padding:10px;  border-radius: 4px; border:1px solid #006699; border-bottom:2px solid #0066CC;; border-right:2px solid #0066CC;box-shadow: 0px 0px 2px #000000;}
        .student_docs_link_Head{  cursor:pointer; font-weight:bold; margin:10px;  color:#009100; font-size:16px}
        .more_download{ padding:3px; border: 1px dotted #999999;}
        .mobile_show_ajaxViewMainTableTDForm{ }
        .backtoreg{  cursor:pointer; font-weight:bold; margin:10px;  color:#1A1AFF; font-size:14px}
        /*.student_docs_link a{ color:#0053A6; font-size:14px; font-weight:500; line-height:25px; text-decoration:none;}*/
        .student_docs_link a{  line-height:20px; }

        .profile_student  { width:400px; line-height:18px; letter-spacing:1px; color:#006CD9 }
        .profile_student .name_student{   padding-bottom:10px; color:#0065CA;}
        .profile_student .name_student h2{ color:#008C46; padding:5px; letter-spacing:2px; font-weight:500;}
        .profile_student .img_student{width:50%; float:left;}
        .profile_student .data_student{width:50%; float:left;}
        .box_profile{ background:#FFFFFF; border:1px dotted #9FCFFF; padding:5px; margin:10px; border-radius:5px;}
        .box_profile_main{ width:450px;}
        . box_profile_main_td{ width:450px;}
        .stdata_class{ font-style:italic; font-size:14px; font-weight:normal; color:#FF6600}
        .stdata_asession{ font-style:italic; font-size:14px; font-weight:normal; margin-top:-10px;}
        .stdata_class_head { color:#BFBFBF; font-size:12px;}
        .stdata_id { font-style:italic; font-size:14px; font-weight:normal;}
        .barcode_pic{ width: 150px; margin:2px; margin-top:10px; border:1px #88C4FF thin;}
        .prof_pic{ border-radius:10px; width: 150px; height: 150px; margin:2px; border:7px solid #91C8FF;  }
        .address_stu{ font-size:10px;}
        .img_border{border:6px #333333 thick; height:auto; width:auto;}
        .student_docs_link_details{ float:left; width:40%; border-bottom:1px solid #CCCCCC; padding:3px; margin:3px;}
        .student_docs_link_details a{ text-decoration:none; font-style:italic; color:#000099;}
        .student_docs_link_details a:hover{   color:#FF6600;}
        .class_year{float:left; color:#006BD7;}
        .class_year_selected{ float:left;color:#FF6600}
        .class_year:hover{float:left;color:#0054A8; }
        .class_year_selected:hover{  }
        .name_student h2{ border-bottom: 1px solid #A6D2FF}


        .student_docs_link a{ text-decoration:none; font-style:italic; color:#000099;}
        .ui-dialog-titlebar{ background-color:#0080C0; color:#FFFFFF;}
        .textboxxx{ padding:2px;}
    </style>
    <style>
        .tooltip {
            display:inline-block;
            position:relative;

            text-align:left;
        }

        .tooltip .top {
            min-width:200px;
            top:2px;
            left:50%;
            transform:translate(-50%, -100%);
            padding:10px 20px;
            color:#444444;
            background-color:#EEEEEE;
            font-weight:normal;
            font-size:13px;
            border-radius:8px;
            position:absolute;
            z-index:99999999;
            box-sizing:border-box;
            box-shadow:0 1px 8px rgba(0,0,0,0.5);
            display:none;
        }

        .tooltip:hover .top {
            display:block;
        }

        .tooltip .top i {
            position:absolute;
            top:100%;
            left:50%;
            margin-left:-12px;
            width:24px;
            height:12px;
            overflow:hidden;
        }

        .tooltip .top i::after {
            content:'';
            position:absolute;
            width:12px;
            height:12px;
            left:50%;
            transform:translate(-50%,-50%) rotate(45deg);
            background-color:#EEEEEE;
            box-shadow:0 1px 8px rgba(0,0,0,0.5);
        }
        #saaTabLink2c{ display:none;}
    </style>



    <!-- board and class -->
    <div id="elective_subject_DIV">
    </div>
    <script>
        function elective_subject_assign(history_id,wt_action)
        {



            var formdata = new FormData();
            var elective_subject_list='';
            if(wt_action!='')
            {
                var elective_subject_list= getValuesFromCheckedBox('elective_subject_list[]');

            }

            formdata.append('elective_subject_list',elective_subject_list );
            formdata.append('history_id',history_id );
            formdata.append('elective_subject_assign','OK' );
            formdata.append('wt_action',wt_action);
            var url='<? echo $ajaxFilePath ?>?elective_subject_assign=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">�Please wait. Working...</div></div>';
            os.setAjaxFunc('elective_subject_assign_result',url,formdata);

        }

        function elective_subject_assign_result(data)
        {

            var content_data=	getData(data,'##--elective_subject_DIV_data--##');
            os.setHtml('elective_subject_DIV',content_data);

            popDialog('elective_subject_DIV','Elective Subject',{'width':'300','height':'300'});

        }

    </script>



    <!-- board and class -->

    <!-- new student add -->
    <div>
        <div id="add_new_student_div" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog  uk-modal-body ">
                <button class="uk-modal-close-default" uk-close></button>

                <form id="add_new_student_form" method="post" onsubmit="event.preventDefault()">
                    Reg No <input type="text" name="new_student_reg_no" id="new_student_reg_no" style="font-size:18px; color:#0000CC; font-weight:bold;" onchange="open_add_new_student_form();" value=""   />

                    <span onclick="open_add_new_student_form();" style="cursor:pointer; margin-top:-5px" class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"   > Search</span>

                    <div id="new_form_div" class="uk-margin-small">
                        Enter Registration no. and search.
                    </div>
                    <div id="readmission_entry_result_div">  </div>
                </form>
            </div>
        </div>

        <script>
            let add_new_student_data ='';
            function validate_reg_no()
            {
                os.setVal('new_student_reg_no','');
                os.setHtml('new_form_div','Enter Registration no and search.');
                add_new_student_data = UIkit.modal('#add_new_student_div').show();
            }

            function open_add_new_student_form()
            {


                let form = os.getObj('add_new_student_form');
                let formdata = new FormData(form);
                formdata.append("open_add_new_student_form", "OK")
                let url='<? echo $ajaxFilePath ?>?open_add_new_student_form=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='Please wait while loading...';
                os.setAjaxFunc(function (res){

                    os.setHtml('new_form_div',res);

                    //alert(res);
                }, url, formdata);



            }



            function save_add_new_student_data(){

               if(os.check.empty('new_student_name','Please enter name')==false){ return false;}
                if(os.check.empty('new_student_branch_code','Please select Branch')==false){ return false;}		
                if(os.check.empty('new_student_class','Please select class')==false){ return false;}
                if(os.check.empty('new_student_asession','Please select session')==false){ return false;}
               
                if(os.check.empty('new_student_gender','Please select gender')==false){ return false;}

 if(os.check.empty('new_student_student_type','Please select type')==false){ return false;}







                let form = os.getObj('add_new_student_form');
                let formdata = new FormData(form);
                formdata.append("save_add_new_student_data", "OK")
                let url='<? echo $ajaxFilePath ?>?save_add_new_student_data=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='Please wait while loading...';
                os.setAjaxFunc(function (res){

                    os.setHtml('new_form_div',res);
                    WT_historyListing();
                    //alert(res);
                }, url, formdata);

            }

            function readmission_entry()
            {


                var readmission_student_class=os.getVal('readmission_student_class');
                if(readmission_student_class==''){ alert('Please select class'); return false;}
                var readmission_student_asession=os.getVal('readmission_student_asession');
                if(readmission_student_asession==''){ alert('Please select session'); return false;}

                var p=confirm('I have checked and confirm to proceed');
                if(!p){ return false;}


                let form = os.getObj('add_new_student_form');
                let formdata = new FormData(form);
                formdata.append("readmission_entry", "OK")
                let url='<? echo $ajaxFilePath ?>?readmission_entry=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='Please wait while loading...';
                os.setAjaxFunc(function (res){

                    os.setHtml('readmission_entry_result_div',res);
                    open_add_new_student_form();
                    WT_historyListing();

                }, url, formdata);

            }

        </script>
        <!-- new student add end -->
        <style>
            .data_student {  border: 1px dotted #999999;}
            .data_student td{ padding:3px; border-left: 1px dotted #999999;border-bottom: 1px dotted #999999;}
            .star{ color:#FF0000;}
        </style>
    </div>

    <div title="bulk readmission">
        <div id="Admission_link" style="background:#FFFFCE; width:500px;   margin-top:-5px; border:#B9B900 dotted 1px; display:none;"> &nbsp;
            <span style=" font-size:12px;">
              Upgrade Class to :
              <select name="upgrade_to_class" id="upgrade_to_class" class="textbox fWidth" ><option value=""> </option>	<?
              $os->onlyOption($os->classList);	?></select>
              Session:
              <select name="upgrade_to_asession" id="upgrade_to_asession" class="textbox fWidth" ><option value=""> </option>	<?
              $os->onlyOption($os->asession,'');	?></select>


              <select name="upgrade_to_branch_code" id="upgrade_to_branch_code" class="textbox fWidth" style="display:none" ><option value=""> </option>	 </select>

              <input type="button" value="Apply Upgrade" onclick="upgradeClass()"  style="cursor:pointer;"/>



          </span>

          <div id="bulk_readmission"> </div>

      </div>

      <script>
        function open_upgrade_form()
        {
            popDialog('Admission_link','Readmission',{'width':'900','height':'500'});
        }

        function	upgradeClass()
        {
            var formdata = new FormData(os.getObj('student_list_form'));

            var upgrade_to_class=os.getVal('upgrade_to_class');
            formdata.append('upgrade_to_class',upgrade_to_class );

            var upgrade_to_asession=os.getVal('upgrade_to_asession');
            formdata.append('upgrade_to_asession',upgrade_to_asession );

            var upgrade_to_branch_code=os.getVal('upgrade_to_branch_code');
            formdata.append('upgrade_to_branch_code',upgrade_to_branch_code );
            if(os.check.empty('upgrade_to_class','Please Select Upgrade Class')==false){ return false;}
            if(os.check.empty('upgrade_to_asession','Please Select Upgrade Session')==false){ return false;}
            var p =confirm('Are you Sure? You want to upgrade this record.')
            if(p){

                var url='<? echo $ajaxFilePath ?>?upgradeClass=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxHtml('bulk_readmission',url,formdata);
            }
        }
    </script>

</div>


<!-- save and trace -->

<div id="stdent_edit_trace_DIV">
</div>

<script>
    function stdent_edit_trace(student_id)
    {

       var formdata = new FormData();

       formdata.append('student_id',student_id );
       formdata.append('stdent_edit_trace','OK' );

       var url='<? echo $ajaxFilePath ?>?stdent_edit_trace=OK&';
       os.animateMe.div='div_busy';
       os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">Please wait. Working...</div></div>';
       os.setAjaxFunc('stdent_edit_trace_result',url,formdata);

   }

   function stdent_edit_trace_result(data)
   {

    var content_data=	getData(data,'##--stdent_edit_trace_DIV_data--##');
    os.setHtml('stdent_edit_trace_DIV',content_data);

    popDialog('stdent_edit_trace_DIV','Edit Student Data',{'width':'100%','height':'610'});

}

		//// edit and save and trace 
		
		function stdent_save_trace(field_id,table_field,student_id)
        {

            var formdata = new FormData();
            
            var table_field_new_val=os.getVal(field_id);
            formdata.append('table_field_new_val',table_field_new_val );
            formdata.append('table_field',table_field );
            formdata.append('student_id',student_id );
            formdata.append('stdent_save_trace','OK' );

            var url='<? echo $ajaxFilePath ?>?stdent_save_trace=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">Please wait. Working...</div></div>';
            os.setAjaxFunc('stdent_save_trace_result',url,formdata);

        }

        function stdent_save_trace_result(data)
        {
         var alert_data=	getData(data,'##--stdent_edit_trace_alert--##');
         var st_id=	getData(data,'##--stdent_edit_trace_student_id--##');



         stdent_edit_trace(st_id);
         alert(alert_data);

     }

 </script>

 <style>
    .edit_trace td{ padding:3px; }
    .edit_bloc_text{ background:none; border:none !important;}
    .edit_bloc_text:hover{ background:#FFFFFF; border:1px solid #0080FF  !important; }
</style>

<!-- save and trace -->


<script>
  function nantionality_data()
  {
   var nantionality_val=os.getVal('new_nationality');

   if(nantionality_val!='Indian')
   {
    os.show('nantionality_data_container');
}else{
  os.hide('nantionality_data_container');
}

}


function caste_data()
{
   var caste_val=os.getVal('new_student_caste');

   if(caste_val!='Gen')
   {
    os.show('caste_data_container');
}else{
  os.hide('caste_data_container');
}

}


function disabled_data()
{
   var disabled_val=os.getVal('new_disabled');

   if(disabled_val!='No')
   {
    os.show('disabled_data_container');
}else{
  os.hide('disabled_data_container');
}

}

function toggle_block(id_field,id_container)
{
  var fld_val=os.getVal(id_field);

  if(fld_val=='Yes')
  {
    os.show(id_container);
}else{
  os.hide(id_container);
}

}

function toggle_block_no(id_field,id_container)
{
  var fld_val=os.getVal(id_field);

  if(fld_val=='No')
  {
    os.show(id_container);
}else{
  os.hide(id_container);
}

}

function copy_input_row(row_id,table_id)
{
					  //alert(table_id);
                      var tableRef = document.getElementById(table_id);
                      var elm = document.createElement('tr');
                      elm.innerHTML=document.getElementById(row_id).innerHTML


                      tableRef.appendChild(elm);

                  }


                  function update_student_data()
                  {
                     let form = os.getObj('student_metadata_form');
                     let formdata = new FormData(form);
                     formdata.append("save_student_metadata_form", "OK")
                     let url='<? echo $ajaxFilePath ?>?save_student_metadata_form=OK&';
                     os.animateMe.div='div_busy';
                     os.animateMe.html='Please wait while loading...';
                     os.setAjaxFunc(function (res){
								//os.setHtml('new_form_div',res);
								//WT_historyListing();  
								alert(res);
                            }, url, formdata);


                 }

                 function autofill_Correspondence()
                 {
                    let ccheck_obj = os.getObj('autofill_corr_check_id');

                    os.setVal('new_corr_vill','');
                    os.setVal('new_corr_po','');
                    os.setVal('new_corr_ps','');
                    os.setVal('new_corr_state','');
                    os.setVal('new_corr__dist','');
                    os.setVal('new_corr_pin','');
                    os.setVal('new_corr_block','');

                    if(ccheck_obj.checked==true)
                    {
                      os.setVal('new_corr_vill',os.getVal('new_student_vill'));
                      os.setVal('new_corr_po',os.getVal('new_student_po'));
                      os.setVal('new_corr_ps',os.getVal('new_student_ps'));
                      os.setVal('new_corr_state',os.getVal('new_student_state'));
                      os.setVal('new_corr__dist',os.getVal('new_student_dist'));
                      os.setVal('new_corr_pin',os.getVal('new_student_pin'));
                      os.setVal('new_corr_block',os.getVal('new_student_block'));



                  }



              }



              function set_state_dist_by_pin(pin_field_id,state_field,dist_field)
              {

                 var pin_val= os.getVal(pin_field_id);

                 if(pin_val==''){ return false;}

                 var formdata = new FormData();							
                 formdata.append('pin_val',pin_val );
                 formdata.append('state_field',state_field );
                 formdata.append('dist_field',dist_field );
                 formdata.append('set_state_dist_by_pin','OK' );

                 var url='<? echo $ajaxFilePath ?>?set_state_dist_by_pin=OK&';
                 os.animateMe.div='div_busy';
                 os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">Please wait. Working...</div></div>';
                 os.setAjaxFunc('set_state_dist_by_pin_result',url,formdata);

             }

             function set_state_dist_by_pin_result(data)
             {



               var state_field_id=	getData(data,'##--state_field_id--##');
               var dist_field_id=	getData(data,'##--dist_field_id--##');

               var state_field_val=	getData(data,'##--state_field_val--##');
               var dist_field_val=	getData(data,'##--dist_field_val--##');

               os.setVal(state_field_id,state_field_val);
               os.setVal(dist_field_id,dist_field_val);

           }
function pres_add_same_per(){
    if($("#pres_add_same_per_chk").prop('checked') == false){
        return false;
    }
    $('#new_corr_pin').val($('#new_student_pin').val());   
    $('#new_corr_state').val($('#new_student_state').val());   
    $('#new_corr__dist').val($('#new_student_dist').val());   
    $('#new_corr_block').val($('#new_student_block').val());   
    $('#new_corr_ps').val($('#new_student_ps').val());   
    $('#new_corr_vill').val($('#new_student_vill').val());   
    $('#new_corr_po').val($('#new_student_po').val());   
}


       </script>
	    <style>
 .uk-table-small{ color:#494949; font-size:14px; }
  .uk-table-small td{ padding:5px 5px;}
  .table_input_payment  td{ padding:4px 4px;}
  .head_stdetails{ background-color:#0080C0; color:#FFFFFF; font-weight:bold;}
  .vspace{ height:50px;}
  .main_table { font-size:12px; color:#252525; }
  .main_table input,select{ font-size:14px; font-weight:bold; color:#000066;}
  .main_table td {
   
    border-bottom: solid 1px #EFEFEF;
    
}
  
 </style>


       <?php  include($site['root-wtos'].'holidaysDataView_Helper.php'); ?>
       <? include($site['root-wtos'].'bottom.php'); ?>


