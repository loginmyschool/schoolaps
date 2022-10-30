<?
/*
   # wtos version : 1.1
   # page called by ajax script in historyDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
include('barCode.php');
$bCode=new wtbarcode;
$_ACCESS_NAME = "Student Register";

include($site['root-wtos'].'admission_admin_function_helpers.php');


function sms_aam($smsText='',$smsNumber='')
{




    $smsText= urlencode(trim($smsText));
    if($smsNumber!='' && $smsText!=''){

        // $url= "http://136.243.8.109/http-api.php?username=aamkhp&password=AAMkhp&senderid=AAMKHP&route=1&number=$smsNumber&message=$smsText";
        $url= "http://websms.netsanchar.com/app/smsapi/index.php?username=ameen3&password=ameen@123&campaign=12649&routeid=100815&type=text&contacts=$smsNumber&senderid=BLKSMS&msg=$smsText&template_id=5";

        /* $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         // Set so curl_exec returns the result instead of outputting it.
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         // Get the response and close the channel.
         $response = curl_exec($ch);
         curl_close($ch);

         return $response;
 */
        ?>
        <img src="<? echo $url ?>" style="display:none;"  />

        <?
    }


}

?><?
if($os->get('WT_historyListing')=='OK')
{
    $return_acc=$os->branch_access();

    # sorting
    $orderBy=" h.historyId DESC ";
    $sortBy= $os->post('sortBy_s');

    if($sortBy=='Registration ASC')
    {
        $orderBy="h.registrationNo ASC  ";
    }

    if($sortBy=='Registration DESC')
    {
        $orderBy="h.registrationNo DESC  ";
    }
    if($sortBy=='Name ASC')
    {
        $orderBy="s.name ASC  ";
    }

    if($sortBy=='Name DESC')
    {
        $orderBy="h.name DESC, ";
    }
    # searching

    $and_branch_code_s=  $os->postAndQuery('branch_code_s','h.branch_code','=');
    $andasession=  $os->postAndQuery('asession_s','h.asession','=');
    $andclass=  $os->postAndQuery('class_s','h.class','=');
    $andBoard=  $os->postAndQuery('board_s','h.board','=');
    $andregistrationNo=  $os->postAndQuery('registrationNo_s','h.registrationNo','=');

    $f_admission_date_s= $os->post('f_admission_date_s'); $t_admission_date_s= $os->post('t_admission_date_s');
    $andadmission_date=$os->DateQ('h.admission_date',$f_admission_date_s,$t_admission_date_s,$sTime='00:00:00',$eTime='59:59:59');
    $androll_no=  $os->postAndQuery('roll_no_s','h.roll_no','%');
    $andsection=  $os->postAndQuery('section_s','h.section','=');


    $andgender=  $os->postAndQuery('gender_s','s.gender','=');
    $andname=  $os->postAndQuery('studentName_s','s.name','%');

 
    $and_historyStatus_s=  $os->postAndQuery('historyStatus_s','h.historyStatus','=');
	
	$and_historyStatus_s='';
	 $and_status_active_s=  $os->postAndQuery('status_active_s','s.status_active','=');


    $and_branch='';
    if($os->userDetails['adminType']!='Super Admin')
    {


        $selected_branch_codes=$return_acc['branches_code_str_query'];
        $and_branch=" and h.branch_code IN($selected_branch_codes)";

    }
    $searchKey= trim($os->post('searchKey'));
    $where_searchKey='';
    if($searchKey!='' && strlen($searchKey)>2 )
    {

        $where_searchKey ="and (  s.name like '%$searchKey%' 
    Or  s.registerNo like '%$searchKey%'    
    Or  s.adhar_no like '%$searchKey%' 
    Or  s.father_name like '%$searchKey%' 
    Or  s.mother_name like '%$searchKey%' 
    Or  s.guardian_name like '%$searchKey%' 
    Or  s.mobile_student like '%$searchKey%'
    Or  s.rfid like '%$searchKey%'
) ";

    }

  $listingQuery="  select h.*,s.*   
FROM history h 
INNER JOIN student s on(s.studentId = h.studentId)
WHERE h.historyId>0   $where_searchKey  $and_branch $and_branch_code_s $andasession  $andclass 
$andregistrationNo $andgender  $andname  $andBoard $andadmission_date  $androll_no  $andsection  $and_historyStatus_s $and_status_active_s 

ORDER BY $orderBy ";

    // --- new earch -------


    $os->setSession($listingQuery, 'downloadHistoryExcel');

    $os->showPerPage=100;

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];
	
	 
	

    $historyExcelA_selected=array('studentId' ,'name'  ,'dob','gender' ,'class','section','father_name','branch');

///////////////////
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
        $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'];
    }

    //_d($branch_code_arr);

    ?>
    <div class="p-right-m">
        <div class="pagingLinkCss m-top-m">
            Total:<b><? echo $os->val($resource,'totalRec'); ?></b>
            <? echo $resource['links']; ?>
        </div>


        <div id="more_download_modal" style="display: none">
            <div class="uk-grid uk-child-width-1-3 uk-grid-collapse" uk-grid>
                <?
                foreach($os->historyExcelA AS $dbFieldName=>$excelColName)
                {
                    $selected='';
                    if(in_array($dbFieldName,$historyExcelA_selected))
                    {
                        $selected='checked="checked"';
                    }
                    ?>
                    <div style="">
                        <div class="m-bottom-s">
                            <label for="<?echo $dbFieldName;?>_d">
                                <input class="uk-checkbox m-right-m" <? echo $selected; ?>
                                       type="checkbox" name="columnName[]" id="<?echo $dbFieldName;?>_d"  value="<? echo $dbFieldName; ?>" />
                                <? echo $excelColName; ?>
                            </label>
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
            <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button uk-margin"
                    type="button"
                    style="cursor:pointer"
                    onclick="excelDownload()">Download</button>
        </div>


        <form id="student_list_form">

            <table class="uk-table uk-table-small uk-table-hover uk-table-striped uk-border-rounded uk-overflow-hidden">
                <thead>
                <tr class="background-color-white">
                    <th class="p-s"><input class="uk-checkbox" type="checkbox" name="chk_all" id="chk_all" onclick="CheckAll('chk_all','historyIds[]');"></th>
                    <th class="p-s">#</th>

                    <th class="p-s">Reg.No.</th>
                    <th class="p-s">Name</th>
                    <th class="p-s">Gender</th>
                    <th class="p-s">Year</th>
                    <th class="p-s">Class</th>
                    <th class="p-s">Sec</th>
                    <th class="p-s">Roll</th>
                    <th class="p-s">Father</th>
                    <th class="p-s">Mobile No</th>
                    <th class="p-s">Pass.</th>
                    <th class="p-s" >Branch</th>
                    <th > Elective</th>
                    <th class="p-s uk-text-nowrap" style="display:none">Subscr.</th>
                    <th class="p-s ">Fees  Setting</th>
                    <th >  </th>
                </tr>
                </thead>
                <tbody>


                <?php



                $serial=$os->val($resource,'serial');

                while($record=$os->mfa( $rsRecords)){

                    $br_code=$record['branch_code'];
                    $serial++;
                    $historyId=$record['historyId'];
                    $studentId=$record['studentId'];
                    $br_access = $os->get_secondary_access_by_branch_and_menu($br_code,$_ACCESS_NAME);
                    $delete_access = in_array("Delete History", $br_access);
					
					 
					$Fees_Config_access = in_array("Fees Config", $br_access);
					$Collect_Fees_access = in_array("Collect Fees", $br_access);
					$Edit_Student_access = in_array("Edit Student", $br_access);
					$RFID_Register_access = in_array("RFID Register", $br_access);
					$edit_student_branch_access= in_array("Edit Branch", $br_access);
					

                    if($record['asession']==''){$record['asession']='-';}

                    if(isset($os->classList[$record['class']])){

                        $history_class=  $os->classList[$record['class']];

                    }else{  $history_class ='-';}



                    $status_active_color='color:#FF0000';
                    if($record['status_active']=='Y')
                    {
                        $status_active_color='color:#006600';

                    }


                    ?>
                    <tr class="trListing"   >
                        <td><input class="uk-checkbox" name="historyIds[]"  id="historyId_<?php echo $record['historyId']?>"    type="checkbox" value="<?php echo $record['historyId']?>"> </td>
                        <td><?php echo $serial; ?></td>
                        <td class="uk-text-nowrap">
                            <div class="btn btn-primary tooltip" > <b style="<? echo $status_active_color; ?>"> <?php echo $record['registrationNo']?></b>
                                <div class="top">
                                    <p>

                                        <?php echo $record['name']; ?> &nbsp;
                                        Mob:<?php echo $record['mobile_student'];   ?> &nbsp;
                                        <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?>	&nbsp;
                                        <?php  echo $branch_code_arr[$br_code]; ?> [<?php echo $br_code; ?>]    &nbsp;
                                        Reg:&nbsp;<?php echo $record['registrationNo']?>&nbsp;
                                        Pass:&nbsp;<?  echo  $record['otpPass'];   ?>&nbsp;
                                    </p>

                                </div>
                            </div>



                        </td>

                        <td title="S: <?php echo $record['studentId']; ?>  H: <?php echo $record['historyId']; ?> " style="font-weight:bold;" class="uk-text-nowrap">
                           
						    <a onclick="showStudent('<? echo $record['historyId'];?>');os.setAsCurrentRecords(this)"
                               class="">   <?php echo   $record['name']; ?>  </a> 
						    
                            <?  if( ($os->userDetails['adminType']=='Super Admin' || $RFID_Register_access) && false  )
                            { ?>

                                <input type="text" style="width:100px;color:#33CC00; font-weight:bold; " value="<?  echo  $record['rfid'];  ?>"
                                       id="edit_rfid<?  echo $studentId; ?>"
                                       onchange="wtosInlineEdit('edit_rfid<?  echo $studentId; ?>','student','rfid','studentId','<?  echo $record['studentId']; ?>','','','WT_historyListing()');" />
                            <? } ?>
                        </td>
                        <td valign="top">

                            <select style=" display:none" id="gender_<? echo $record['studentId'] ?>" onchange="wtosInlineEdit('gender_<? echo $record['studentId'] ?>','student','gender','studentId','<? echo $record['studentId'] ?>','','','')">
                                <option value="" > </option>
                                <?  $os->onlyOption($os->gender,  $record['gender'] );?>
                            </select>

                            <? echo $record['gender']; ?>
                            <!--<?php if( $record['image']!=''){ ?>
                            <img src="<? echo $site['url'].$record['image'];?> "
                                 class="uk-border-rounded border-xxs border-color-light-grey"
                                 style="height: 40px; width: 40px; object-fit: cover; object-position: center" />
                                 <? } ?>-->
                        </td>

                        <td>


                            <a> <?php echo $record['asession']; ?> </a>


                            <?  if($os->userDetails['adminType']=='Super Admin')
                            { ?>
                                <div class="uk-padding-small uk-border-rounded" uk-dropdown>
                                    <input type="text" style="width:80px;color:#33CC00; font-weight:bold; " value="<?  echo  $record['asession'];  ?>"
                                           id="edit_asession<?  echo $historyId; ?>"
                                           onchange="wtosInlineEdit('edit_asession<?  echo $historyId; ?>','history','asession','historyId','<?  echo $record['historyId']; ?>','','','WT_historyListing()');" />

                                </div>
                            <? } ?>



                        </td>
                        <td>



                            <a><?   echo  $history_class; ?></a>


                            <?  if($os->userDetails['adminType']=='Super Admin')
                            {
                                $temp_class_list=array();
                                foreach($os->board_class as $board=>$classes){
                                    foreach ($classes as $class)
                                    {
                                        $temp_class_list[$class]=$os->classList[$class];

                                    } }
                                ?>

                                <div class="uk-padding-small uk-border-rounded" uk-dropdown>

                                    <select class="uk-select congested-form" name="edit_class<?  echo $historyId; ?>" id="edit_class<?  echo $historyId; ?>" style="width:100px;"
                                            onchange="wtosInlineEdit('edit_class<?  echo $historyId; ?>','history','class','historyId','<?  echo $record['historyId']; ?>','','','WT_historyListing()');" />
                                    <option value=""> </option>
                                    <? $os->onlyOption($temp_class_list, $record['class']); ?>
                                    </select>  </div>

                            <? } ?>

                        </td>
                        <td><!--<? if(isset($os->section[$record['section']])){ echo  $os->section[$record['section']]; } ?> -->
                            <input type="text" class="edit_bloc_text" style="width:25px; " value="<?  echo  $record['section'];  ?>" id="edit_section<?  echo $historyId; ?>"
                                   onchange="wtosInlineEdit('edit_section<?  echo $historyId; ?>','history','section','historyId','<?  echo $historyId; ?>','','','');" />
                        </td>
                        <td><!--<?  echo  $record['roll_no'];  ?>-->
                            <input type="text" class="edit_bloc_text" style="width:30px;" value="<?  echo  $record['roll_no'];  ?>" id="edit_roll_no<?  echo $historyId; ?>"
                                   onchange="wtosInlineEdit('edit_roll_no<?  echo $historyId; ?>','history','roll_no','historyId','<?  echo $historyId; ?>','','','');" />

                        </td>
                        <td><?php echo $record['father_name'] ?> </td>
                        <td><?php echo $record['mobile_student'] ?> </td>
                        <td><?  echo $record['otpPass'];  ?>
                            <input type="text" style="width:45px; display:none;" value="<?  echo $record['otpPass'];  ?>" id="edit_otpPass<?  echo $studentId; ?>"
                                   onchange="wtosInlineEdit('edit_otpPass<?  echo $studentId; ?>','student','otpPass','studentId','<?  echo $studentId; ?>','','','');" />

                        </td>
                        <td  >




                            <div class="btn btn-primary tooltip"> 
							<span style="font-size:10px;"> <?php if($branch_code_arr[$br_code]==''){ echo 'No Branch';}else{ echo $branch_code_arr[$br_code];}  ; ?> </span>

                                <div class="top">
								
                                    <?  if($os->userDetails['adminType']=='Super Admin' || $edit_student_branch_access)
                                    { ?>
                                    Edit Branch
                                        <input type="text" style="width:80px;color:#33CC00; font-weight:bold; " value="<?  echo  $record['branch_code'];  ?>"
                                               id="edit_branch_code<?  echo $historyId; ?>"
                                               onchange="wtosInlineEdit('edit_branch_code<?  echo $historyId; ?>','history','branch_code','historyId','<?  echo $record['historyId']; ?>','','','WT_historyListing()');" />

                                    <? } else { ?>
                                        <? echo  $branch_code_arr[$br_code]; ?>
                                        <span style="color:#33CC00"><?php echo $br_code; ?></span>
                                    <? } ?>




                                </div>
                            </div>



                        </td>

                        <td>
                            <a onclick="elective_subject_assign('<?php echo $historyId;?>','')">Elective</a>
                        </td>

                        <?  if(0){ ?>
                            <td class="uk-text-nowrap"><span uk-tooltip="title:View Subscription; delay: 100"><a href="javascript:void(0)"  onclick="show_subscription('<? echo $record['studentId'];?>','<? echo $record['name'];?>','<? echo $record['mobile_student'];?>','<? echo $record['class'];?>','<? echo $record['asession'];?>')" uk-icon="icon:file-text"></a></span></td>
                        <? } ?>

                    
                        <td class="uk-text-nowrap">
                            <?  if($os->userDetails['adminType']=='Super Admin' || $Fees_Config_access ) { ?>
                                <span uk-tooltip="title:Fees Settings; delay: 100">
                               <a href="javascript:void(0)"  onclick="student_fees_setting('<? echo $historyId;?>','')" uk-icon="icon:file-text"></a></span>
							   
							    <? } ?>
								 <?  if($os->userDetails['adminType']=='Super Admin' || $Collect_Fees_access ) { ?>
							   
                                <span uk-tooltip="title:Collect Fees; delay: 100">
                                   <a href="javascript:void(0)"  onclick="student_fees_collect('<? echo $historyId;?>','show_form')" uk-icon="icon:file-text"></a></span>
                            <? } ?>
                        </td>
                        <td>  <?  if($os->userDetails['adminType']=='Super Admin' || $Edit_Student_access) { ?>
                            <a href="javascript:void(0)" onclick="stdent_edit_trace('<? echo $studentId;?>')" uk-icon="pencil"></a>
                         
						 <? } ?>
						  
						 
						    <?  if($os->userDetails['adminType']=='Super Admin' || $delete_access) { ?>
                                <a style="color:#FF0000" href="javascript:void(0)" onclick="removeRowAjaxFunction('history','historyId','<? echo $record['historyId'];?>','','','WT_historyListing()')" uk-icon="trash"></a>
                            <? } ?>
                        </td>




                    </tr>
                    <?
                } ?>
                </tbody>

            </table>

        </form>

    </div>
    <?php
    exit();

}
if($os->get('duplicateNameSearch')=='OK')
{
    $name=$os->post('name');
    $studentQuery="  select * from student where studentId>0   and  name like '$name%' order by studentId desc limit 3";
    $studentMq=$os->mq($studentQuery);
//$paymentList2= $os->getIdsDataFromQuery($studentQuery,'studentId','fees','studentId',$fields='',$returnArray=true,$relation='12M',$otherCondition='');
    $historyList= $os->getIdsDataFromQuery($studentQuery,'studentId','history','studentId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
    $historyListTemp=array_pop($historyList);
    if($name!=''&&$historyListTemp['historyId']!='')
    {
        ?>
        <div class="listingRecords">
            <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
                <tr class="borderTitle" >

                    <td >#</td>


                    <td ><b>Image</b></td>
                    <td style="width:150px;" ><b>Student Name</b></td>

                    <!-- <td ><b>Fees Details</b></td>   -->
                </tr>



                <?php

                $serial=0;

                while($studentData=$os->mfa( $studentMq)){

                    //	_d($studentData);
                    $serial++;


                    $historyData=$historyList[$studentData['studentId']];
                    // _d($historyData);

                    ?>
                    <tr class="trListing" >
                        <td><?php echo $serial; ?>     </td>
                        <td> <img src="<? echo $site['url'].$studentData['image'];;?>" height="70" /></td>

                        <td><?php echo $studentData['name']?> [<?php echo $studentData['studentId']; ?>] <br/>
                            Class:<? echo $historyData['class']?><br />


                            Father:<? echo  $studentData['father_name'];	  ?><br />
                            Mother:<? echo  $studentData['mother_name'];	  ?><br />
                            Mobile:<? echo  $studentData['mobile_student'];	  ?><br />
                        </td>

                        <!--<td> <? $os->showFees($paymentList2[$studentData['studentId']]); ?> </td> -->


                    </tr>
                    <?
                } ?>

            </table>
        </div>
    <?}?><?php
    exit();

}
if($os->get('setStudentFees')=='OK')
{
    $historyId=$os->post('historyId');
//$studentQuery="  select * from student where studentId>0   and  name like '$name%'      order by studentId desc";
    $listingQuery="  select * from history where historyId>0 and historyId='$historyId'";
    $paymentList= $os->getIdsDataFromQuery($listingQuery,'historyId','fees','historyId',$fields='',$returnArray=true,$relation='12M',$otherCondition='order by year desc');
    $paymentData=$paymentList[$historyId];
    $year='';
    foreach($paymentData as $key=>$val)
    {
        if($val['year']!=$year)
        {
            $paymentYear[]=$val['year'];
            $historyYear=$val['year'];
            $where ="and asession=".$val['year'];
            $studentClass[$val['year']] =$os->rowByField('class','history','historyId',$historyId,$where) ;


        }
        $year=$val['year'];
    }
    for($i=0;$i<count($paymentYear);$i++)
    {
        $c=0;
        for($j=0;$j<count($paymentData);$j++)
        {
            if ($paymentYear[$i]==$paymentData[$j]['year'])
            {
                $feesArray[$paymentYear[$i]][$c]=$paymentData[$j];
                $c++;
            }
            else
            {
                $c=0;
            }
        }




    }
    ?>
    <div class="listingRecords">
        <?
        foreach($feesArray as $key=>$val){

            $serial=0;

            ?>
            <br/><div style="background-color:#949090;width:50px;"><strong>Class:<? echo $studentClass[$key];?></strong></div>
            <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
                <tr class="borderTitle" >
                    <td >#</td>
                    <td ><b>Date</b></td>
                    <td ><b>Amount</b></td>
                    <td ><b>Purpose</b></td>
                    <td ><b>Remarks</b></td>
                </tr>



                <?php
                foreach($val as $key2=>$val2){
                    $serial++;
                    ?>
                    <tr class="trListing" >
                        <td><?php echo $serial; ?>     </td>
                        <td><?php echo $os->showDate($val2['paid_date'])?></td>
                        <td><?php echo $val2['paid_amount']?></td>
                        <td><?php echo $val2['subjects']?></td>
                        <td><?php echo $val2['remarks']?></td>
                    </tr>
                <?}?>
            </table>


        <?}?>






    </div>

    <br />



    <?php
    exit();

}
if($os->get('WT_historyEditAndSave')=='OK')
{




    $historyId=$os->post('historyId');

    //------------HISTORY DATA------

    $dataToSave['asession']=addslashes($os->post('asession'));
    $dataToSave['registrationNo']=addslashes($os->post('registerNo'));
    $dataToSave['class']=addslashes($os->post('class'));
    $dataToSave['section']=addslashes($os->post('section'));
    // $dataToSave['admission_no']=addslashes($os->post('admission_no'));  // coming from application form no
    $dataToSave['admission_date']=$os->saveDate($os->post('admission_date'));
    $dataToSave['roll_no']=addslashes($os->post('roll_no'));
    $dataToSave['studentId']=addslashes($os->post('studentId'));
    $dataToSave['full_marks']=addslashes($os->post('full_marks'));
    $dataToSave['obtain_marks']=addslashes($os->post('obtain_marks'));
    $dataToSave['percentage']=addslashes($os->post('percentage'));
    $dataToSave['pass_fail']=addslashes($os->post('pass_fail'));
    $dataToSave['grade']=addslashes($os->post('grade'));
    $dataToSave['remarks']=addslashes($os->post('remarks'));
    $dataToSave['historyStatus']=addslashes($os->post('historyStatus'));
    $dataToSave['board']=addslashes($os->post('board'));
    $dataToSave['formNo']=addslashes($os->post('formNo'));
    $dataToSave['monthlyFees']=addslashes($os->post('monthlyFees'));
    $dataToSave['totalFees']=addslashes($os->post('totalFees'));
    $dataToSave['registrationFees']=addslashes($os->post('registrationFees'));





    $dataToSave['admissionFees']=addslashes($os->post('admissionFees'));
    $dataToSave['donationFees']=addslashes($os->post('donationFees'));



    $dataToSave['registrationFeesStatus']=addslashes($os->post('registrationFeesStatus'));


    $dataToSave['outGoingTcNo']=addslashes($os->post('outGoingTcNo'));
    $dataToSave['outGoingTcDate']=$os->saveDate($os->post('outGoingTcDate'));

    $dataToSave['inactiveDate']=$os->saveDate($os->post('inactiveDate'));
    $dataToSave['stream']=addslashes($os->post('stream'));
    $dataToSave['admissionType']=addslashes($os->post('admissionType'));
    if($os->post('admissionType')=='')
    {
        $dataToSave['admissionType']='New Admission';
    }
//$registrationFees=$os->post('registrationFees');
//$registrationFeesStatus=$os->post('registrationFeesStatus');
    //------------END HISTORY DATA------


    //------------STUDENT DATA------
    $dataToSave_2['accNo']=addslashes($os->post('accNo'));
    $dataToSave_2['accHolderName']=addslashes($os->post('accHolderName'));
    $dataToSave_2['ifscCode']=addslashes($os->post('ifscCode'));
    $dataToSave_2['branch']=addslashes($os->post('branch'));










    $dataToSave_2['kanyashree']=addslashes($os->post('kanyashree'));
    $dataToSave_2['yuvashree']=addslashes($os->post('yuvashree'));


    $dataToSave_2['board']=addslashes($os->post('board'));
    $dataToSave_2['feesPayment']=addslashes($os->post('feesPayment'));



    $dataToSave_2['name']=addslashes($os->post('name'));
    $dataToSave_2['dob']=$os->saveDate($os->post('dob'));
    $dataToSave_2['age']=addslashes($os->post('age'));
    $dataToSave_2['gender']=addslashes($os->post('gender'));
    $dataToSave_2['registerDate']=$os->saveDate($os->post('registerDate'));
    $dataToSave_2['registerNo']=addslashes($os->post('registerNo'));
    $dataToSave_2['uid']=addslashes($os->post('uid'));
    $dataToSave_2['caste']=addslashes($os->post('caste'));
    $dataToSave_2['subcast']=addslashes($os->post('subcast'));
    $dataToSave_2['apl_bpl']=addslashes($os->post('apl_bpl'));
    $dataToSave_2['minority']=addslashes($os->post('minority'));
    $dataToSave_2['adhar_name']=addslashes($os->post('adhar_name'));
    $dataToSave_2['adhar_dob']=$os->saveDate($os->post('adhar_dob'));
    $dataToSave_2['adhar_no']=addslashes($os->post('adhar_no'));
    $dataToSave_2['ph']=addslashes($os->post('ph'));
    $dataToSave_2['ph_percent']=addslashes($os->post('ph_percent'));
    $dataToSave_2['disable']=addslashes($os->post('disable'));
    $dataToSave_2['disable_percent']=addslashes($os->post('disable_percent'));
    $dataToSave_2['father_name']=addslashes($os->post('father_name'));
    $dataToSave_2['father_ocu']=addslashes($os->post('father_ocu'));
    $dataToSave_2['father_adhar']=addslashes($os->post('father_adhar'));
    $dataToSave_2['mother_name']=addslashes($os->post('mother_name'));
    $dataToSave_2['mother_ocu']=addslashes($os->post('mother_ocu'));
    $dataToSave_2['mother_adhar']=addslashes($os->post('mother_adhar'));
    $dataToSave_2['vill']=addslashes($os->post('vill'));
    $dataToSave_2['po']=addslashes($os->post('po'));
    $dataToSave_2['ps']=addslashes($os->post('ps'));
    $dataToSave_2['dist']=addslashes($os->post('dist'));
    $dataToSave_2['block']=addslashes($os->post('block'));
    $dataToSave_2['pin']=addslashes($os->post('pin'));
    $dataToSave_2['state']=addslashes($os->post('state'));
    $dataToSave_2['guardian_name']=addslashes($os->post('guardian_name'));
    $dataToSave_2['guardian_relation']=addslashes($os->post('guardian_relation'));
    $dataToSave_2['guardian_address']=addslashes($os->post('guardian_address'));
    $dataToSave_2['guardian_ocu']=addslashes($os->post('guardian_ocu'));
    $dataToSave_2['anual_income']=addslashes($os->post('anual_income'));
    $dataToSave_2['mobile_student']=addslashes($os->post('mobile_student'));
    $dataToSave_2['mobile_guardian']=addslashes($os->post('mobile_guardian'));
    $dataToSave_2['mobile_emergency']=addslashes($os->post('mobile_emergency'));
    $dataToSave_2['email_student']=addslashes($os->post('email_student'));
    $dataToSave_2['email_guardian']=addslashes($os->post('email_guardian'));
    $dataToSave_2['mother_tongue']=addslashes($os->post('mother_tongue'));
    $dataToSave_2['blood_group']=addslashes($os->post('blood_group'));
    $dataToSave_2['religian']=addslashes($os->post('religian'));
    $dataToSave_2['other_religian']=addslashes($os->post('other_religian'));
    $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
    if($image!=''){
        $dataToSave_2['image']='wtos-images/'.$image;
        /*include('imge_resize_class.php');
        $target_file =$site['root'].$dataToSave_2['image'];
        $image_o = new SimpleImage();
        $image_o->load($target_file);
        $image_o->resizeToHeight(300);
        $image_o->save($target_file);*/
    }
    $dataToSave_2['last_school']=addslashes($os->post('last_school'));
    $dataToSave_2['last_class']=addslashes($os->post('last_class'));
    $dataToSave_2['tc_no']=addslashes($os->post('tc_no'));
    $dataToSave_2['tc_date']=$os->saveDate($os->post('tc_date'));
    $dataToSave_2['studentRemarks']=addslashes($os->post('studentRemarks'));
    //------------END STUDENT DATA------



    if($historyId < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }

    $studentId=$os->save('student',$dataToSave_2,'studentId',$dataToSave['studentId']);
    /// barcode 66677


    $filepath=$site['root'].'barCode/';
    $bCode->barcode($studentId,$filepath);


    //	$qResult=$os->save('rbproduct',$dataToSave2,'rbproductId',$rbproductId);
    /// barcode 66677

    $updateUidQuery="update student set uid='$studentId' where studentId='$studentId'";
    $os->mq($updateUidQuery);


    $dataToSave['studentId']=$studentId;

    $qResult=$os->save('history',$dataToSave,'historyId',$historyId);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if(($dataToSave['historyStatus']=='Inactive')&&($os->showDate($dataToSave['inactiveDate'])!=''))
    {
        $inactiveDate=$os->showDate($dataToSave['inactiveDate']);
        $os->deleteRemainMonthlyFeesForInactive($qResult,$dataToSave['studentId'],$inactiveDate);
    }

    if($qResult)
    {
        if($historyId>0 ){
            $mgs="Data updated Successfully";
            //$os->addNewFees($dataToSave,$historyId,$registrationFees,$registrationFeesStatus);
        }
        if($historyId<1 ){ $mgs= " Data Added Successfully";
            $historyId=  $qResult;

            $os->addNewFees($dataToSave,$historyId);
        }

        $mgs=$historyId."#-#".$mgs."#-#".$studentId;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}
if($os->get('WT_historyGetById')=='OK')
{
    $historyId=$os->post('historyId');

    if($historyId>0)
    {
        $wheres=" where historyId='$historyId'";
    }
    $dataQuery=" select * from history  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record_1=$os->mfa( $rsResults);

    //HISTORY SECTION DATA

    $record_1['admission_date']=$os->showDate($record_1['admission_date']);
    $record_1['outGoingTcDate']=$os->showDate($record_1['outGoingTcDate']);
    $record_1['inactiveDate']=$os->showDate($record_1['inactiveDate']);
    //END HISTORY SECTION DATA

    //STUDENT DATA


    $studentId=$record_1['studentId'];
    $wheres=" where studentId='$studentId'";
    $dataQuery=" select * from student  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record_stu=$os->mfa( $rsResults);
    $record_stu['dob']=$os->showDate($record_stu['dob']);
    $record_stu['registerDate']=$os->showDate($record_stu['registerDate']);
    $record_stu['adhar_dob']=$os->showDate($record_stu['adhar_dob']);
    $record_stu['tc_date']=$os->showDate($record_stu['tc_date']);
    if($record_stu['image']!='')
    {
        $record_stu['image']=$site['url'].$record_stu['image'];
    }
// $record['remarks']=$record_stu['remarks'];
    //END STUDENT DATA




    /*$paymentQuery=" select * from payment  where studentId='$studentId' and historyId='$historyId' order by paymentId limit 1 ";
    $paymentMq=$os->mq($paymentQuery);
    $paymentData=$os->mfa($paymentMq);
    $paymentRecord['registrationFees']= $paymentData['registrationFees'];

    $paymentRecord['registrationFeesStatus']= $paymentData['registrationFeesStatus'];*/

    $record=array_merge($record_1,$record_stu);
    echo '##-HISTORY-DATA-##';
    echo  json_encode($record);
    echo '##-HISTORY-DATA-##';






    $Query="select * from history where historyId>0 and historyStatus='Active' and studentId='$studentId'";

    $result=$os->mq($Query);




    echo '##-HISTORY-LIST-CLASS-DATA-##';?>
    <h3 align="right" style="margin-right:10px;">Class History</h3>
    <div class="class_year">

        <div class="year"></div>
    </div>



    <?php
    while($data=$os->mfa($result))
    {
        $class_year='class_year';
        if($historyId==$data['historyId'])
        {

            $class_year='class_year_selected';
        }
        if(isset( $os->classList[$data['class']])){
            ?>

            <div class="<?php echo $class_year;?>" onclick="showStudent('<? echo $data['historyId'];?>');">
                <div class="class"><?php    echo $os->classList[$data['class']]; ?> </div>
                <div class="year"><?php echo $data['asession'];?></div>
            </div>


        <?php  }
    }

    echo '<div style="clear:both;"> </div>';

    echo '##-HISTORY-LIST-CLASS-DATA-##';
    echo '##-STUDENT-DOCUMENTS-LINKS-##';

    ?>




    <div class="student_docs_link_Head"> CLASS <?php if(isset($os->classList[$record_1['class']])){ echo $os->classList[$record_1['class']];}?> DOCUMENTS [<?php echo $record_1['asession']; ?>]</div>
    <div class="student_docs_link"><a href="javascript:void();" onclick=""> Class   <?php if(isset($os->classList[$record_1['class']])){ echo $os->classList[$record_1['class']];}?>  Certificate </a></div>
    <div class="student_docs_link"><a href="javascript:void();" onclick=""> Final Marksheet </a></div>
    <div class="student_docs_link"><a href="javascript:void();" onclick="openPrintId_single('<? echo $historyId;?>')">

            Print</a></div>
    <div class="student_docs_link"><a href="javascript:void();" onclick="load_certificate('<? echo $historyId;?>','Charecter')"> Charecter Certificate </a></div>
    <div class="student_docs_link"><a href="javascript:void();" onclick="load_certificate('<? echo $historyId;?>','School leaving')"> School Leaving Certificate </a></div>
    <div class="student_docs_link"><a href="javascript:void();" onclick="load_certificate('<? echo $historyId;?>','Transfer')"> Transfer Certificate</a></div>

    <div class="student_docs_link"> <a href="javascript:void();" onclick="student_fees('<? echo $historyId;?>')" >fees </a>  </div>
    <div class="student_docs_link">  <a href="javascript:void();" onclick="student_results('<? echo $historyId;?>')" >result </a></div>
    <div class="student_docs_link"> <a href="javascript:void();" onclick="student_attendence('<? echo $historyId;?>')" > attendence </a></div>
    <div class="student_docs_link">  <a onclick="student_edit_form('<? echo $historyId;?>');" > Edit Student Info </a></div>
    <!--	<div class="student_docs_link">  <a > Re admission </a></div>-->




    <?

    echo '##-STUDENT-DOCUMENTS-LINKS-##';



    exit();
}
if($os->get('getformData')=='OK')
{
    $formNo=$os->post('formNo');
    $Query="select * from history where historyId>0 and formNo='$formNo'";
    $result=$os->mq($Query);
    while($data=$os->mfa($result))
    {
        $formNoRecord=$data;
    }
    if(count($formNoRecord)>0)
    {
        echo "Form No Already Added.";
    }

    else
    {
        if($formNo>0)
        {
            $wheres=" where admissionId='$formNo'";
            $dataQuery=" select * from admission  $wheres ";
            $rsResults=$os->mq($dataQuery);
            $record=$os->mfa( $rsResults);
            $record['dob']=$os->showDate($record['dob']);
            if($record['image']!='')
            {
                $record['image']=$site['url'].$record['image'];
            }
            echo  json_encode($record);
        }
    }

    exit();
}
if($os->get('WT_historyDeleteRowById')=='OK')
{
    $historyId=$os->post('historyId');
    if($historyId>0)
    {


        $historyData=$os->rowByField('studentId','history','historyId',$historyId);
        $studentId=$historyData['studentId'];
        $updateQuery1="delete from student where studentId='$studentId'";
        $os->mq($updateQuery1);
        $updateQuery2="delete from fees where studentId='$studentId' and historyId='$historyId'";
        $os->mq($updateQuery2);
        $updateQuery3="delete from payment where studentId='$studentId' and historyId='$historyId'";
        $os->mq($updateQuery3);
        $updateQuery4="delete from history where historyId='$historyId'";
        $os->mq($updateQuery4);
        echo 'Record Deleted Successfully';
    }
    exit();
}
if($os->get('addFees')=='OK')
{
    $feesId=0;
    $c=0;
    $historyId=$os->post('historyId');


    $asession=$os->post('asession');

    $historyIdVal = substr($historyId,0,-1);//for remove last comma(,)
    $addFeesHistoryId=(explode(",",$historyIdVal));
    foreach($addFeesHistoryId as $Id)
    {
        $studentData=$os->rowByField('studentId,class,section','history','historyId',$Id);
        $dataToSave['asession']=addslashes($asession);
        $dataToSave['historyId']=addslashes($Id);
        $dataToSave['studentId']=addslashes($studentData['studentId']);
        $dataToSave['class']=addslashes($studentData['class']);
        $dataToSave['section']=addslashes($studentData['section']);
//$dataToSave['year']=addslashes($os->post('asession'));
        $dataToSave['status']='Unpaid';
        $dataToSave['fees_amount']=addslashes($os->post('fees_amount'));
        $dataToSave['payble']=addslashes($os->post('fees_amount'));
        $dataToSave['paid_amount']='0.0';
        $dataToSave['discount']='0.0';
        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
        $dataToSave['addEditCounter']='0';
        $qResult=$os->save('fees',$dataToSave,'feesId',$feesId);
        $description=json_encode($dataToSave);
        $os->setLogRecord('fees',$qResult,'Add Fees',$dataToSave['addedBy'],$description);
        $c++;
    }
    if($c>0)
    {
        echo "Fees Addd Successfully";
    }




    //echo $historyIdVal;

    exit();

}
if($os->get('upgradeClass')=='OK')
{
    $c=0;
    $historyIds=array();
    $update_result=array();
    if($os->post('historyIds')){
        $historyIds=$os->post('historyIds');
    }
    $upgrade_to_class=$os->post('upgrade_to_class');
    $upgrade_to_asession=$os->post('upgrade_to_asession');
    // $upgrade_to_branch_code=$os->post('upgrade_to_branch_code'); // useless

    if(count($historyIds)<1)
    {

        echo 'Please select atlease one student.';

        exit();
    }

    if( $upgrade_to_class =='' )
    {

        echo 'Please select Class to readmission.';

        exit();
    }

    if( $upgrade_to_asession =='' )
    {

        echo 'Please select Session to readmission.';

        exit();
    }


    /*$check_query=" select count(*) cc from history where  historyId IN('".implode("','",$historyIds)."') group by branch_code,asession,class ";
    $check_query_rs= $os->mq( $check_query);
    $single_search=0;
    while($check_query_data=$os->mfa($check_query_rs))
    {
      $single_search++;
    }
    */
    $historyIds_IN_str="'".implode("','",$historyIds)."'";
    $check_query=" select group_concat(s.registerNo) registerNo_selected ,h.branch_code,h.class from history h
	INNER JOIN student s ON (s.studentId=h.studentId)
	where  h.historyId IN($historyIds_IN_str) 
	group by h.branch_code,h.asession,h.class ";
    $check_query_rs= $os->mq( $check_query);
    $single_search=0;
    $registerNo_selected='';
    $branch_code_selected='';
    $class_selected='';
    while($check_query_data=$os->mfa($check_query_rs))
    {


        $single_search++;
        $registerNo_selected=$check_query_data['registerNo_selected'];
        $branch_code_selected=$check_query_data['branch_code'];
        $class_selected=$check_query_data['class'];

    }










    if($single_search!=1)
    {

        echo 'Please select Student of  same branch , session and class';	 exit();
    }else
    {
        $registerNo_selected_array=explode(',',$registerNo_selected);
        $registerNo_selected_in_str="'".implode("','",$registerNo_selected_array)."'";

        $registerNo_already_updated_array=array();
        $check_already_upgraded=" select group_concat(s.registerNo) registerNo_already_upgraded from history h
     INNER JOIN student s ON (s.studentId=h.studentId)
     where  s.registerNo IN($registerNo_selected_in_str)   and h.asession='$upgrade_to_asession' and h.class='$upgrade_to_class'  ";
        $check_already_upgraded_rs= $os->mq( $check_already_upgraded);
        $already_upgraded_data=$os->mfa($check_already_upgraded_rs);
        if($already_upgraded_data['registerNo_already_upgraded']!='')
        {
            $registerNo_already_upgraded_array=explode(',',$already_upgraded_data['registerNo_already_upgraded']);
        }


        $update_count=0;
        $student_query=" select  *  from student  s where s.studentId>0 and s.registerNo IN($registerNo_selected_in_str)  ";
        $student_query_rs= $os->mq( $student_query);
        while($student_data=$os->mfa($student_query_rs))
        {
            $registrationNo=$student_data['registerNo'];
            $studentId=$student_data['studentId'];
            $update_count++;



            if(!in_array($registrationNo,$registerNo_already_upgraded_array))
            {

                $dataToSave=array();
                $dataToSave['asession']=$upgrade_to_asession;
                $dataToSave['registrationNo']=$registrationNo;
                $dataToSave['branch_code']=$branch_code_selected;
                $dataToSave['class']=$upgrade_to_class;
                $dataToSave['historyStatus']='Active';
                $dataToSave['remarks']='Added Manually';
                $dataToSave['section']='';
                $dataToSave['roll_no']='';
                $dataToSave['addedDate']=$os->now();
                $dataToSave['addedBy']=$os->userDetails['adminId'];
                $dataToSave['studentId']=$studentId;
                $qResult=$os->save('history',$dataToSave,'historyId','');

                if($qResult)
                {
                    $update_result[$update_count]=" Reg No  $registrationNo successfully updated to class   $upgrade_to_class  -   $upgrade_to_asession  " ;

                }

            }else{

                // already updated;
                $update_result[$update_count]=" Reg No  $registrationNo already there in    $upgrade_to_class  -   $upgrade_to_asession  " ;

            }

        }


        if(count($update_result)>0)
        {
            echo implode("\n", $update_result);

        }else{

            echo 'There is problem with Register no selected  ';

        }




    }










    exit();

}
if($os->get('checkEditDeletePassword')=='OK')
{

    $historyId=$os->post('historyId');
    $password=$os->post('password');

    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
    if($password==$editDeletePassword)
    {
        echo "password matched#-#".$historyId;
        //echo "password matched#-#";
    }
    else
    {
        echo "wrong password";
    }
    exit();

}
if($os->get('checkEditPasswordForEnableTextBox')=='OK')
{
    $password=$os->post('password');

    $enabledFieldId=$os->post('enabledFieldId');



    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
    if($password==$editDeletePassword)
    {
        $msg="password matched#-#".$enabledFieldId."#-#Edit Data";
    }
    else
    {
        $msg="wrong password";
    }
    echo $msg;
    exit();

}









if($os->post('registration_data_entry_direct')=='OK' && $os->get('confirm_excel_upload')=='OK')
{
    function trim_slashes($data)
    {

        return trim(addslashes($data));
    }


    $asession=$os->post('form_asession');
    $class_id=$os->post('form_class_id');
    $board=$os->post('form_board');



    $file_name='application_form_data_file';

    $file='';
    $message='';
    if(isset($_FILES[$file_name]['tmp_name']))
    {
        $file=$_FILES[$file_name]['tmp_name'];
    }

    if($file!=''  )	{
        $file_ext='.xlsx';

        if($file_ext=='.xls')
        {

            require_once 'Excel/reader.php';
            $dataX = new Spreadsheet_Excel_Reader();
            $dataX->setOutputEncoding('CP1251');
            $dataX->read($file); // uploaded excel file

            for ($RowsNu = 2; $RowsNu <= $dataX->sheets[0]['numRows']; $RowsNu++)
            {




                //if($dataX->sheets[0]['cells'][$RowsNu][1]!='' )



                $xFile=$dataX->sheets[0]['cells'][$RowsNu];

                if(isset($xFile[1])){	$serialNo=$xFile[1];}
                if(isset($xFile[2])){	$name=$xFile[2];}
                if(isset($xFile[3])){	$dob=$xFile[3];}
                if(isset($xFile[4])){	$gender=$xFile[4];}
                if(isset($xFile[5])){	$father_name=$xFile[5];}
                if(isset($xFile[6])){	$guardian_name=$xFile[6];}
                if(isset($xFile[7])){	$mobile_student=$xFile[7];}
                if(isset($xFile[9])){	$vill=$xFile[9];}
                if(isset($xFile[10])){	$po=$xFile[10];}
                if(isset($xFile[11])){	$ps=$xFile[11];}

                if(isset($xFile[12])){	$dist=$xFile[12];}
                if(isset($xFile[13])){	$block=$xFile[13];}
                if(isset($xFile[14])){	$state=$xFile[14];}
                if(isset($xFile[15])){	$pin=$xFile[15];}

                $dataToSave=array();
                $dataToSave['name']=$name;
                $dataToSave['dob']=$os->saveDate($dob);
                $dataToSave['gender']=$gender;
                $dataToSave['father_name']=$father_name;
                $dataToSave['mobile_student']=$mobile_student;
                $dataToSave['vill']=$vill;
                $dataToSave['po']=$po;
                $dataToSave['ps']=$ps;
                $dataToSave['dist']=$dist;
                $dataToSave['block']=$block;
                $dataToSave['pin']=$pin;
                $dataToSave['state']=$state;
                $dataToSave['guardian_name']= $guardian_name;
                $dataToSave['applicaton_date']= $os->now();
                $dataToSave['class_id']= $class_id;
                $dataToSave['asession']= $asession;



                if($name!='')
                {
                    // $qResult=$os->save('online_form',$dataToSave,'online_form_id','');
                    //echo  $os-> query;
                }



            }

        }

        if($file_ext=='.xlsx')
        {

            require_once 'Excel/plugin_3/SimpleXLSX.php';

            $data_added_count=0;

            if ( $xlsx = SimpleXLSX::parse($file) )
            {
                $xFile_arr=$xlsx->rows();



                foreach($xFile_arr as $key=>$xFile)
                {




                    if($key==0){continue;}
                    $registerNo= trim($xFile['1']);
                    if($registerNo<1000)
                    {
                        // $registerNo='NR'.$registerNo;
                    }

                    if($registerNo)
                    {


                        $dataToSave['registerNo']=trim($registerNo); // $xFile[1]
                        $dataToSave['name']=trim_slashes($xFile[0]);

                        $xFile[2]=str_replace(' ','',$xFile[2]);
                        $dataToSave['mobile_student']=trim_slashes($xFile[2]);
                        $dataToSave['father_name']=trim_slashes($xFile[3]);
                        $dataToSave['guardian_relation']='Father';
                        $dataToSave['guardian_name']=$dataToSave['father_name'];

                        if(trim_slashes($xFile[21])!='')
                        {
                            $dataToSave['guardian_name']=$xFile[21];
                        }
                        if(trim_slashes($xFile[22])!='')
                        {
                            $dataToSave['guardian_relation']=$xFile[22];
                        }


                        $dataToSave['mobile_guardian']=$dataToSave['mobile_student'];
                        $dataToSave['branch']=trim_slashes($xFile[4]);
                        $dataToSave['addedDate']=$os->now();
                        $dataToSave['otpPass']=rand(1000,9999);


                        $dataToSave['mother_name']=trim_slashes($xFile[5]);
                        $dataToSave['dob']=trim_slashes($xFile[6]);


                        $gender=trim_slashes($xFile[7]);
                        if($gender=='Male'||$gender=='male'||$gender=='MALE'||$gender=='M'||$gender=='m')
                        {
                            $gender='Male';
                        }else
                        {
                            $gender='Female';
                        }

                        $dataToSave['gender']=trim_slashes($xFile[7]);


                        $dataToSave['caste']=trim_slashes($xFile[8]);



                        $dataToSave['adhar_no']=trim_slashes($xFile[11]);
                        $dataToSave['vill']=trim_slashes($xFile[12]);
                        $dataToSave['po']=trim_slashes($xFile[13]);
                        $dataToSave['ps']=trim_slashes($xFile[14]);
                        $dataToSave['dist']=trim_slashes($xFile[15]);
                        $dataToSave['block']=trim_slashes($xFile[16]);
                        $dataToSave['state']=trim_slashes($xFile[17]);
                        $dataToSave['pin']=trim_slashes($xFile[18]);



                        if($dataToSave['name']=='Student Name' ||  $dataToSave['name']=='Name')
                        {
                            $dataToSave['name']='';

                        }




                        if($dataToSave['name']!='' && $dataToSave['registerNo']!='')
                        {
                            $studentId= $os->rowByField('studentId','student','registerNo',$fldVal=$registerNo,$where='',$orderby='');



                            if($studentId>0)  // ignore fields if exist
                            {
                                unset($dataToSave['otpPass']);
                                unset($dataToSave['addedDate']);

                            }


                            $studentId_updated=$os->save('student',$dataToSave,'studentId',$studentId);

                            // echo $os->query; echo "<br><br>";

                            if($studentId_updated )
                            {



                                $class_id_excel=trim_slashes($xFile[9]);
                                if($class_id_excel!='')
                                {

                                    if($board=='WB')
                                    {
                                        $c_a['One']=1;  $c_a['ONE']=1; $c_a['I']=1;
                                        $c_a['Two']=2;  $c_a['TWO']=2; $c_a['II']=2;
                                        $c_a['Three']=3;  $c_a['THREE']=3; $c_a['III']=3;
                                        $c_a['Four']=4;  $c_a['FOUR']=4; $c_a['IV']=4;
                                        $c_a['Five']=5;  $c_a['FIVE']=5; $c_a['V']=5;
                                        $c_a['Six']=6;  $c_a['SIX']=6; $c_a['VI']=6;
                                        $c_a['Seven']=7;  $c_a['SEVEN']=7; $c_a['VII']=7;
                                        $c_a['Eight']=8;  $c_a['EIGHT']=8; $c_a['VIII']=8;
                                        $c_a['Nine']=9;  $c_a['NINE']=9; $c_a['IX']=9;
                                        $c_a['Ten']=10;  $c_a['TEN']=10; $c_a['X']=10;
                                        $c_a['Eleven']=11;  $c_a['ELEVEN']=11; $c_a['XI Sc.']=11; $c_a['XI']=11;
                                        $c_a['Twelve']=12;  $c_a['TWELVE']=12; $c_a['XII Sc.']=12;$c_a['XII']=12;
                                    }
                                    if($board=='CBSE')
                                    {
                                        $c_a['One']=21;  $c_a['ONE']=21; $c_a['I']=21;
                                        $c_a['Two']=22;  $c_a['TWO']=22; $c_a['II']=22;
                                        $c_a['Three']=23;  $c_a['THREE']=23; $c_a['III']=23;
                                        $c_a['Four']=24;  $c_a['FOUR']=24; $c_a['IV']=24;
                                        $c_a['Five']=25;  $c_a['FIVE']=25; $c_a['V']=25;
                                        $c_a['Six']=26;  $c_a['SIX']=26; $c_a['VI']=26;
                                        $c_a['Seven']=27;  $c_a['SEVEN']=27; $c_a['VII']=27;
                                        $c_a['Eight']=28;  $c_a['EIGHT']=28; $c_a['VIII']=28;
                                        $c_a['Nine']=29;  $c_a['NINE']=29; $c_a['IX']=29;
                                        $c_a['Ten']=30;  $c_a['TEN']=30; $c_a['X']=30;
                                        $c_a['Eleven']=31;  $c_a['ELEVEN']=31; $c_a['XI Sc.']=31; $c_a['XI']=31;
                                        $c_a['Twelve']=32;  $c_a['TWELVE']=32; $c_a['XII Sc.']=32;$c_a['XII']=32;
                                    }
                                    if($board=='WBCS')
                                    {
                                        $c_a['WBCS']=18;

                                    }
                                    if($board=='NEET')
                                    {
                                        $c_a['NEET']=17;

                                    }
                                    if($board=='OTHERS')
                                    {
                                        $c_a['OTHERS']=80;

                                    }




                                    $class_id=$os->val($c_a,$class_id_excel);
                                    if($class_id==''){ $class_id=(int)$class_id_excel;}

                                }

                                $historyId= $os->rowByField('historyId','history','registrationNo',$fldVal=$registerNo,$where=" and class='$class_id' and asession='$asession'  ",$orderby='');

                                $dataToSave_history['registrationNo']=$registerNo;
                                $dataToSave_history['studentId']=$studentId_updated;
                                $dataToSave_history['class']=$class_id;
                                $dataToSave_history['asession']=$asession;
                                $dataToSave_history['historyStatus']='Active';
                                $dataToSave_history['board']=$board;
                                $dataToSave_history['branch_code']=trim_slashes($xFile[4]);
                                $dataToSave_history['admission_date']=trim_slashes($xFile[19]);
                                $dataToSave_history['roll_no']=trim_slashes($xFile[20]);
                                $dataToSave_history['section']=trim_slashes($xFile[10]);



                                $dataToSave_history['addedDate']=$os->now();

                                $historyId_updated=$os->save('history',$dataToSave_history,'historyId',$historyId);
                                // echo $os->query; echo "<br><br>";
                                $data_added_count=$data_added_count+1;
                            }
                        }

                    }




                }



            } else {
                echo SimpleXLSX::parseError();
            }

            $message=  " <h1>Total Data process =".$data_added_count ."<h1>";

        }
    }
    else{


        $message= 'Please upload proper formatted .xls File.';

    }





//$return_Data['asession']=$asession;
//$return_Data['class_id']=$class_id;
//$return_Data['message']=$message;


    echo $message;
    exit();
}

if($os->post('send_sms_function')=='OK' && $os->get('send_sms_function')=='OK')
{

    $send_sms_confirm=false;


    $historyIds=$os->post('checked_historyIds');
    $sms_body_template=$os->post('sms_body_template');
    $sms_body_template=trim($sms_body_template);
    $searchStudent=$os->getSession('downloadHistoryExcel');
    if(trim($historyIds)!='')
    {
        $historyIds=$historyIds.'999999999';
        $stq=" select s.mobile_student , s.otpPass , s.registerNo from  student s, history h 
        where h.registrationNo= s.registerNo and    h.studentId= s.studentId and   h.historyId IN($historyIds)    ";
        $i=0;
        $stq_rs= $os->mq( $stq);
        while($student=$os->mfa($stq_rs))
        {
            if($sms_body_template!='')
            {
                $mobile_student =$student['mobile_student'];
                $registration_no=$student['registerNo'];
                $otpPass=$student['otpPass'];


                $smsText=str_replace('{{pass_word}}',$otpPass,$sms_body_template);
                $smsText=str_replace('{{registration_no}}',$registration_no,$smsText);
                $smsResult='';

                //$mobile_student=8017477871;
                $smsResult= 	 sms_aam($smsText,$smsNumber=$mobile_student);

                ## save sms

                $dataToSave_sms['mobileno']=$mobile_student;
                $dataToSave_sms['msg']=$smsText;
                $dataToSave_sms['addedDate']= $os->now();
                $dataToSave_sms['msgDate']=$os->now();
                $dataToSave_sms['msgStatus']=$smsResult;
                $dataToSave_sms['addedBy']=$os->userDetails['adminId'];
                $qResult=$os->save('smshistory',$dataToSave_sms);
                $i++;
                echo  " $i ) R =$registration_no  M= $mobile_student  SMS =  $smsText  <br>  ";

            }





        }

    }else
    {



        $studentList= $os->getIdsDataFromQuery($searchStudent,'studentId','student','studentId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
        $i=0;
        $stq_rs= $os->mq( $searchStudent);
        while($record=$os->mfa($stq_rs))
        {





            if($sms_body_template!='')
            {
                $mobile_student =$studentList[$record['studentId']]['mobile_student'];
                $registration_no=$studentList[$record['studentId']]['registerNo'];
                $otpPass=$studentList[$record['studentId']]['otpPass'];


                $smsText=str_replace('{{pass_word}}',$otpPass,$sms_body_template);
                $smsText=str_replace('{{registration_no}}',$registration_no,$smsText);
                $smsResult='';


                //$mobile_student=8017477871;


                $smsResult= 	 sms_aam($smsText,$smsNumber=$mobile_student);

                ## save sms

                $dataToSave_sms['mobileno']=$mobile_student;
                $dataToSave_sms['msg']=$smsText;
                $dataToSave_sms['addedDate']= $os->now();
                $dataToSave_sms['msgDate']=$os->now();
                $dataToSave_sms['msgStatus']=$smsResult;
                $dataToSave_sms['addedBy']=$os->userDetails['adminId'];
                $qResult=$os->save('smshistory',$dataToSave_sms);
                $i++;
                echo  " $i ) R =$registration_no  M= $mobile_student  SMS =  $smsText  <br>  ";

            }





        }



    }



    //$smsResult= 	 sms_aam($smsText='Assalamo Olaikum',$smsNumber='');
    // $url= "http://136.243.8.109/http-api.php?username=aamkhp&password=AAMkhp&senderid=AAMKHP&route=1&number=$smsNumber&message=$smsText";
    exit();
}

if($os->get('elective_subject_assign')=='OK' && $os->post('elective_subject_assign')=='OK' )
{


    $history_id=$os->post('history_id');
    $studentData=$os->rowByField('studentId,class,section','history','historyId',$history_id);
    $classId=$studentData['class'];

    $wt_action=$os->post('wt_action');

    if($wt_action=='save' && $history_id!='')
    {
        $elective_subject_list=$os->post('elective_subject_list');
        //_d($elective_subject_list);
        $dataToSave=array();
        $dataToSave['elective_subject_ids']=$elective_subject_list;
        $qResult=$os->save('history',$dataToSave,'historyId',$history_id);///    allowed char '\*#@/"~$^.,()|+_-=:££
        //echo $os->query;

    }

    $query="select elective_subject_ids from history where  historyId='$history_id'";
    $record_rs=$os->mq($query);
    $record_br=$os->mfa($record_rs);
    $elective_subject_ids=$record_br['elective_subject_ids'];

    $elective_subject_ids_arr=array();
    if($elective_subject_ids!='')
    {
        $elective_subject_ids_arr=explode(',',$elective_subject_ids);
    }

    /////////////////////////
    $query="select * from subject where  Elective='1' and classId='$classId'";
    $query_e_subject_rs=$os->mq($query);





    echo '##--elective_subject_DIV_data--##';


    //echo $query;

    ?>

    <div style="padding:10px; background-color:#FFFFC4;">
        <?
        $i=0;
        while($elective_subject  =  $os->mfa($query_e_subject_rs)){
            $i++;
            $subjectId=$elective_subject['subjectId'];
            $subjectName=$elective_subject['subjectName'];

            ?>

            <input type="checkbox" name="elective_subject_list[]" value="<? echo  $subjectId; ?>"
                <? if( in_array($subjectId,$elective_subject_ids_arr)){?> checked="checked" <? } ?>
            /> <span title="<? echo  $subjectId; ?>"> <? echo  $subjectName; ?> </span> <br />
        <? }

        if($i==0)
        {
            echo 'No elective subject there for this class.';
        }

        ?>
    </div>


    <br /> <br />
    <input type="button" onclick="elective_subject_assign('<?php echo $history_id;?>','save')" style="cursor:pointer;"  value="SAVE" />

    <?


    echo '##--elective_subject_DIV_data--##';
    exit();
}

if($os->get('save_add_new_student_data')=='OK' && $os->post('save_add_new_student_data')=='OK')
{

    $k=$os->post();





    $registrationNo = $os->post('new_student_reg_no');
    $registerNo=trim($registrationNo);
    $registrationNo=trim($registrationNo);
    $name=trim($os->post('new_student_name'));
    $exist_reg_no=false;
    $check_regno=$os->rowByField('registerNo','student','registerNo',$registerNo);
    if($check_regno)
    {
        $exist_reg_no=true;
    }

    $added_success=false;

    $branch_code=$os->post('new_student_branch_code');

	$asession=$os->post('new_student_asession');
	$class=$os->post('new_student_class');
	$gender =  $os->post('new_student_gender');
    
	 
	$os->setSession($branch_code,'new_student_branch_code');
	$os->setSession($asession,'new_student_asession');
	$os->setSession($class,'new_student_class');
	$os->setSession($gender,'new_student_gender');
 
	
	
	
	
	
	
	if($name!='' && $registrationNo!='' &&  $exist_reg_no==false  && $asession!='' && $class!='')
    {
        
		
		$dataToSave_2['name']=$name;
        $dataToSave_2['branch']=$branch_code;
        $dataToSave_2['dob']=$os->post('new_student_dob');
        $dataToSave_2['gender']=addslashes($os->post('new_student_gender'));
		$dataToSave_2['student_type']=addslashes($os->post('new_student_student_type'));		
        $dataToSave_2['registerNo']=$registerNo;
        $dataToSave_2['father_name']=addslashes($os->post('new_student_father_name'));
        $dataToSave_2['vill']=addslashes($os->post('new_student_vill'));
        $dataToSave_2['po']=addslashes($os->post('new_student_po'));
        $dataToSave_2['ps']=addslashes($os->post('new_student_ps'));
        $dataToSave_2['dist']=addslashes($os->post('new_student_dist'));
        $dataToSave_2['block']=addslashes($os->post('new_student_block'));
        $dataToSave_2['pin']=addslashes($os->post('new_student_pin'));
        $dataToSave_2['state']=addslashes($os->post('new_student_state'));
        $dataToSave_2['mobile_student']=addslashes($os->post('new_student_mobile_student'));
        $dataToSave_2['email_student']=addslashes($os->post('new_student_email_student'));
        $dataToSave_2['otpPass']=rand(1000,9999);
        $dataToSave_2['adhar_no']=addslashes($os->post('new_student_adhar_no'));
        
        $dataToSave_2['religian']=addslashes($os->post('new_student_religian'));
        $dataToSave_2['caste']=addslashes($os->post('new_student_caste'));
         

        $dataToSave_2['mobile_student_alternet']=addslashes($os->post('new_student_mobile_student_alternet'));
        $dataToSave_2['mobile_student_whatsapp']=addslashes($os->post('new_student_mobile_student_whatsapp'));


        $dataToSave_2['mother_name']=addslashes($os->post('new_student_mother_name'));
         




        $dataToSave_2['addedDate']=$os->now();
        $dataToSave_2['addedBy']=$os->userDetails['adminId'];
        $studentId=$os->save('student',$dataToSave_2,'studentId','');
        if($studentId)
        {

            // history  adding

            $dataToSave['asession']=$asession;
            $dataToSave['registrationNo']=$registerNo;
            $dataToSave['branch_code']=$branch_code;
            $dataToSave['class']=$class;
            $dataToSave['historyStatus']='Active';
            $dataToSave['remarks']='Added Manually';
			$dataToSave['student_type']=addslashes($os->post('new_student_student_type'));


            $dataToSave['section']=addslashes($os->post('new_student_section'));
            $dataToSave['roll_no']=addslashes($os->post('new_student_roll_no'));
            //$dataToSave['board']=addslashes($os->post('new_student_board'));
            $dataToSave['addedDate']=$os->now();
            $dataToSave['addedBy']=$os->userDetails['adminId'];
            $dataToSave['studentId']=$studentId;
            $qResult=$os->save('history',$dataToSave,'historyId','');


            // history  adding  end


            /// student meta ------------------------------------------

            $dataToSave_meta['student_id'] = $studentId;
            $dataToSave_meta['medium'] = $os->post('new_medium');
            $dataToSave_meta['present_fees'] = $os->post('new_present_fees');
            $dataToSave_meta['referer_details'] = $os->post('new_referer_details');
            $dataToSave_meta['eye_power'] = $os->post('new_eye_power');
            $dataToSave_meta['psychiatric_report'] = $os->post('new_psychiatric_report');
            $dataToSave_meta['mother_tongue'] = $os->post('new_mother_tongue');
            $dataToSave_meta['apl_bpl'] = $os->post('new_apl_bpl');
            $dataToSave_meta['father_adhar'] = $os->post('new_father_adhar');
            $dataToSave_meta['mother_adhar'] = $os->post('new_mother_adhar');
            $dataToSave_meta['email_guardian'] = $os->post('new_email_guardian');
            $dataToSave_meta['nationality'] = $os->post('new_nationality');
            $dataToSave_meta['country_name'] = $os->post('new_country_name');
            $dataToSave_meta['passport_no'] = $os->post('new_passport_no');
            $dataToSave_meta['vissa_type'] = $os->post('new_vissa_type');
            $dataToSave_meta['passport_valid_up_to'] = $os->post('new_passport_valid_up_to');
            $dataToSave_meta['caste_cert_no'] = $os->post('new_caste_cert_no');
            $dataToSave_meta['cast_cert_issue_auth'] = $os->post('new_cast_cert_issue_auth');
            $dataToSave_meta['cast_cert_issue_date'] = $os->post('new_cast_cert_issue_date');
            $dataToSave_meta['disabled'] = $os->post('new_disabled');
            $dataToSave_meta['disable_body_parts'] = $os->post('new_disable_body_parts');
            $dataToSave_meta['disable_percet'] = $os->post('new_disable_percet');
            $dataToSave_meta['disable_cert_no'] = $os->post('new_disable_cert_no');
            $dataToSave_meta['disable_cert_issue_auth'] = $os->post('new_disable_cert_issue_auth');
            $dataToSave_meta['disable_cert_issue_date'] = $os->post('new_disable_cert_issue_date');
            $dataToSave_meta['living_area_dist'] = $os->post('new_living_area_dist');
            $dataToSave_meta['living_area_sub_division'] = $os->post('new_living_area_sub_division');
            $dataToSave_meta['living_area_town'] = $os->post('new_living_area_town');
            $dataToSave_meta['living_area_semi_town'] = $os->post('new_living_area_semi_town');
            $dataToSave_meta['living_area_vill'] = $os->post('new_living_area_vill');
            $dataToSave_meta['living_area_gram_panchayet'] = $os->post('new_living_area_gram_panchayet');
            $dataToSave_meta['any_bro_sis_presently'] = $os->post('new_any_bro_sis_presently');


            $dataToSave_meta['bro_sis_presently_details'] = serialize($os->post('new_bro_sis_presently_details'));

            $dataToSave_meta['any_bro_sis_passed'] = $os->post('new_any_bro_sis_passed');


            $dataToSave_meta['bro_sis_passed_details'] = serialize($os->post('new_bro_sis_passed_details'));

            $dataToSave_meta['any_family_is_mission_emp'] = $os->post('new_any_family_is_mission_emp');
            $dataToSave_meta['family_is_mission_emp_details'] = serialize($os->post('new_family_is_mission_emp_details'));

            $dataToSave_meta['is_father_alive'] = $os->post('new_is_father_alive');
            $dataToSave_meta['father_date_of_death'] = $os->post('new_father_date_of_death');
            $dataToSave_meta['father_qualification'] = $os->post('new_father_qualification');
            $dataToSave_meta['father_monthly_income'] = $os->post('new_father_monthly_income');
            $dataToSave_meta['is_mother_alive'] = $os->post('new_is_mother_alive');
            $dataToSave_meta['mother_date_of_death'] = $os->post('new_mother_date_of_death');
            $dataToSave_meta['mother_qualification'] = $os->post('new_mother_qualification');
            $dataToSave_meta['mother_monthly_income'] = $os->post('new_mother_monthly_income');
            $dataToSave_meta['gurdian_qualification'] = $os->post('new_gurdian_qualification');
            $dataToSave_meta['gurdian_monthly_income'] = $os->post('new_gurdian_monthly_income');
            $dataToSave_meta['corr_vill'] = $os->post('new_corr_vill');
            $dataToSave_meta['corr_po'] = $os->post('new_corr_po');
            $dataToSave_meta['corr_ps'] = $os->post('new_corr_ps');
            $dataToSave_meta['corr_block'] = $os->post('new_corr_block');
            $dataToSave_meta['corr_state'] = $os->post('new_corr_state');
            $dataToSave_meta['corr__dist'] = $os->post('new_corr__dist');
            $dataToSave_meta['corr_pin'] = $os->post('new_corr_pin');
            $dataToSave_meta['last_school'] = $os->post('new_last_school');
            $dataToSave_meta['last_class'] = $os->post('new_last_class');
            $dataToSave_meta['last_school_session'] = $os->post('new_last_school_session');
            $dataToSave_meta['tc_no'] = $os->post('new_tc_no');
            $dataToSave_meta['tc_date'] = $os->post('new_tc_date');
            $dataToSave_meta['student_id_in_TC'] = $os->post('new_student_id_in_TC');
            $dataToSave_meta['last_school_address'] = $os->post('new_last_school_address');
            $dataToSave_meta['present_school'] = $os->post('new_present_school');
            $dataToSave_meta['present_school_address'] = $os->post('new_present_school_address');
            $dataToSave_meta['present_school_contact'] = $os->post('new_present_school_contact');
            $dataToSave_meta['present_school_class'] = $os->post('new_present_school_class');
            $dataToSave_meta['present_school_session'] = $os->post('new_present_school_session');
            $dataToSave_meta['present_school_roll'] = $os->post('new_present_school_roll');
            $dataToSave_meta['present_school_section'] = $os->post('new_present_school_section');
            $dataToSave_meta['accNo'] = $os->post('new_accNo');
            $dataToSave_meta['accHolderName'] = $os->post('new_accHolderName');
            $dataToSave_meta['ifscCode'] = $os->post('new_ifscCode');
            $dataToSave_meta['bank_branch'] = $os->post('new_bank_branch');
            $dataToSave_meta['bank_name'] = $os->post('new_bank_name');
            $dataToSave_meta['kanyashree_type'] = $os->post('new_kanyashree_type');
            $dataToSave_meta['kanyashree_ID_NO'] = $os->post('new_kanyashree_ID_NO');
            $dataToSave_meta['ten_name_of_board'] = $os->post('new_ten_name_of_board');
            $dataToSave_meta['ten_passed_year'] = $os->post('new_ten_passed_year');
            $dataToSave_meta['ten_roll'] = $os->post('new_ten_roll');
            $dataToSave_meta['ten_no'] = $os->post('new_ten_no');
            $dataToSave_meta['ten_marks_beng_hindi'] = $os->post('new_ten_marks_beng_hindi');
            $dataToSave_meta['ten_marks_eng'] = $os->post('new_ten_marks_eng');
            $dataToSave_meta['ten_marks_math'] = $os->post('new_ten_marks_math');
            $dataToSave_meta['ten_marks_physc'] = $os->post('new_ten_marks_physc');
            $dataToSave_meta['ten_marks_lifesc'] = $os->post('new_ten_marks_lifesc');
            $dataToSave_meta['ten_marks_history'] = $os->post('new_ten_marks_history');
            $dataToSave_meta['ten_marks_geography'] = $os->post('new_ten_marks_geography');
            $dataToSave_meta['ten_marks_socialsc'] = $os->post('new_ten_marks_socialsc');
            $dataToSave_meta['ten_marks_total_obt'] = $os->post('new_ten_marks_total_obt');
            $dataToSave_meta['ten_marks_out_of'] = $os->post('new_ten_marks_out_of');
            $dataToSave_meta['ten_marks_percent'] = $os->post('new_ten_marks_percent');
            $dataToSave_meta['twelve_name_of_board'] = $os->post('new_twelve_name_of_board');
            $dataToSave_meta['twelve_passed_year'] = $os->post('new_twelve_passed_year');
            $dataToSave_meta['twelve_roll'] = $os->post('new_twelve_roll');
            $dataToSave_meta['twelve_no'] = $os->post('new_twelve_no');
            $dataToSave_meta['twelve_stream'] = $os->post('new_twelve_stream');
            $dataToSave_meta['twelve_marks_beng_hindi'] = $os->post('new_twelve_marks_beng_hindi');
            $dataToSave_meta['twelve_marks_eng'] = $os->post('new_twelve_marks_eng');
            $dataToSave_meta['twelve_marks_math'] = $os->post('new_twelve_marks_math');
            $dataToSave_meta['twelve_marks_physc'] = $os->post('new_twelve_marks_physc');
            $dataToSave_meta['twelve_marks_biology'] = $os->post('new_twelve_marks_biology');
            $dataToSave_meta['twelve_marks_chemistry'] = $os->post('new_twelve_marks_chemistry');
            $dataToSave_meta['twelve_marks_total_obt'] = $os->post('new_twelve_marks_total_obt');
            $dataToSave_meta['twelve_marks_out_of'] = $os->post('new_twelve_marks_out_of');
            $dataToSave_meta['twelve_marks_percent'] = $os->post('new_twelve_marks_percent');
            $dataToSave_meta['graduate_passed'] = $os->post('new_graduate_passed');
            $dataToSave_meta['graduate_passed_subject'] = $os->post('new_graduate_passed_subject');
            $dataToSave_meta['graduate_passed_year'] = $os->post('new_graduate_passed_year');
            $dataToSave_meta['graduate_passed_university'] = $os->post('new_graduate_passed_university');
            $dataToSave_meta['graduate_subjects'] = $os->post('new_graduate_subjects');
            $dataToSave_meta['graduate_subjects_marks'] = $os->post('new_graduate_subjects_marks');
            $dataToSave_meta['graduate_total_obt'] = $os->post('new_graduate_total_obt');
            $dataToSave_meta['graduate_out_of'] = $os->post('new_graduate_out_of');
            $dataToSave_meta['graduate_percent'] = $os->post('new_graduate_percent');
            $dataToSave_meta['student_other_info'] = $os->post('new_student_other_info');

            //$del_query="delete from  where  student_id='$studentId'";
            //$os->mq($del_query);

            $qResult=$os->save('student_meta',$dataToSave_meta,'student_meta_id','');

            /// student meta ------------------------------------------
            //echo $os->query;
            if($qResult){
                $added_success=true;
            }
        }

    }



    $sQuery="select h.* ,s.*  from history  h  LEFT JOIN student s on (s.studentId=h.studentId and h.registrationNo=s.registerNo )   where h.registrationNo!='' and h.registrationNo='$registrationNo' and  s.registerNo='$registerNo' group by historyId order by historyId desc ";
    $result=$os->mq($sQuery);


    ?>
    <? if($exist_reg_no==true){ ?>  <h3 style="color:#FF0000;"> Registration No. <?=$registrationNo; ?>  Already Entered </h3>   <? }else{  ?>
    <? if($added_success==true){ ?>  <h3 style="color:#006600"> Registration No. <?=$registrationNo; ?>  Added Successfully </h3>   <? }  ?>
    <? if($added_success==false){ ?>  <h3 style="color:#FF0000"> Problem saving Registration No. <?=$registrationNo; ?> </h3>   <? }  ?>
<? } ?>



    <table class="data_student" >
        <tr>
            <td>Name</td>
            <td>Reg No</td>
            <td> Class</td>
            <td>Roll </td>
            <td> Gender</td>
            <td> Father Name</td>
            <td> Mobile</td>
            <td>Branch</td>
        </tr>
        <?
        while($data=$os->mfa($result))
        {

            ?>
            <tr>

                <td title="H:<? echo $data['historyId'] ;?> - H:<? echo $data['studentId'] ;?>-R:<? echo $data['registrationNo'] ;?>">
                    <b><? echo $data['name'] ;?> </b></td>
                <td> <? echo $data['registerNo'] ;?></td>
                <td>
                    <? if(isset($os->classList[$data['class']])){ echo  $os->classList[$data['class']]; } ?>	:
                    <? echo $data['asession'] ;?>
                </td>

                <td><? echo $data['roll_no'] ;?> </td>
                <td> <? echo $data['gender'] ;?></td>
                <td> <? echo $data['father_name'] ;?></td>
                <td> <? echo $data['mobile_student'] ;?></td>
                <td><? echo $branch_code_arr[$data['branch_code']]; ?>  </td>


            </tr>

            <?
        }



        ?>
    </table>

    <br />	 <br />
    <span onclick="validate_reg_no()" title="Add Another student" style="cursor:pointer; color:#0000CC;"  > Add another student </span>
    <?

    exit();

}



if($os->get('open_add_new_student_form')=='OK' && $os->post('open_add_new_student_form')=='OK')
{

    $return_acc=$os->branch_access();
    $and_branch='';
    if($os->userDetails['adminType']!='Super Admin')
    {

        $selected_branch_codes=$return_acc['branches_code_str_query'];
        $and_branch=" and branch_code IN($selected_branch_codes)";

    }

    $branch_code_arr=array();
    $branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";

    $branch_row_rs= $os->mq($branch_row_q);
    while ($branch_row = $os->mfa($branch_row_rs))
    {
        $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
    }



    $registrationNo = $os->post('new_student_reg_no');
    $registerNo=trim($registrationNo);
    $registrationNo=trim($registrationNo);
    if($registrationNo==''){ exit();}



    $valid_reg_no=false;
    $sQuery="select h.* ,s.*  from history  h  LEFT JOIN student s on (s.studentId=h.studentId and h.registrationNo=s.registerNo )   where h.registrationNo!='' and h.registrationNo='$registrationNo' and  s.registerNo='$registerNo' group by historyId order by historyId desc ";
    $result=$os->mq($sQuery);


    ?>
    <table class="data_student" >


        <?
        $class_arr=array();
        $k=0;
        while($data=$os->mfa($result))
        {
            $class_arr[$data['class']]=$data['class'];
            $valid_reg_no=true;
            $k++;
            ?>
            <? if($k==1){ ?>
            <tr>

                <td>Name</td>

                <td>Reg No</td>
                <td> Class</td>
                <td>Roll </td>
                <td> Gender</td>

                <td> Father Name</td>
                <td> Mobile</td>

                <td>Branch</td>

            </tr>

        <? } ?>


            <tr>

                <td title="H:<? echo $data['historyId'] ;?> - H:<? echo $data['studentId'] ;?>-R:<? echo $data['registrationNo'] ;?>">
                    <b><? echo $data['name'] ;?> </b></td>
                <td> <? echo $data['registerNo'] ;?></td>
                <td>
                    <? if(isset($os->classList[$data['class']])){ echo  $os->classList[$data['class']]; } ?> : <? echo $data['asession'] ;?>
                </td>

                <td><? echo $data['roll_no'] ;?> </td>
                <td> <? echo $data['gender'] ;?></td>

                <td> <? echo $data['father_name'] ;?></td>

                <td> <? echo $data['mobile_student'] ;?></td>
                <td>
                    <? echo $branch_code_arr[$data['branch_code']]; ?>  </td>

            </tr>

            <?
        }



        ?>
    </table>

    <?
    $branch_access=true;
    if($valid_reg_no==true && $branch_access==true)
    {

        $readmission_student_class=$os->getSession('readmission_student_class');
        $year=date('Y');
        foreach($os->asession as $k=>$y)
        {
            if($y<$year) { unset($os->asession[$k]); }
        }



        $class_max=max( $class_arr);
        foreach($os->board_class as $board=>$classes)
        {



            foreach ($classes as $kc=>$class)
            {
                //  if($class<$class_max) { unset($os->board_class[$board][$kc]); }

            }





        }

        if($class_max==17 )
        {
            $os->board_class=array();
            $os->board_class['NEET'][17]=17;

        }





        ?>

        <table class="uk-table congested-table uk-table-justify">
            <tr> <td colspan="4"> Re-Aadmission to

                    <input type="hidden" name="readmission_student_reg_no" id="readmission_student_reg_no" value="<? echo $registrationNo ?>" />
                </td></tr>

            <tr><td>class <select class="uk-select congested-form" name="readmission_student_class" id="readmission_student_class"   >
                        <option value=""></option>




                        <? foreach($os->board_class as $board=>$classes){?>
                            <optgroup label="<?=$board?>">
                                <? foreach ($classes as $class){?>
                                    <option value="<? echo $class?>"  <? if($readmission_student_class==$class){ ?> selected="selected" <? } ?>   >  <? echo $os->classList[$class]?></option>
                                <? }?>
                            </optgroup>
                        <? } ?>



                    </select>
                </td><td>Year
                    <select class="uk-select congested-form"  name="readmission_student_asession" id="readmission_student_asession">
                        <?

                        $os->onlyOption($os->asession, $os->getSession($key1='readmission_student_asession'));
                        ?>
                    </select></td>


                <td> Branch
                    <select   name="readmission_student_branch_code" id="readmission_student_branch_code"
                              class="uk-select uk-border-rounded congested-form   "   >
                        <? $os->onlyOption($branch_code_arr,'');	?>
                    </select>

                </td>
            </tr>
            <tr>
                <td> Section</td>
                <td> <input class="uk-input congested-form" type="text" name="readmission_student_section" id="readmission_student_section"  /> </td>

                <td class="uk-text-right"> Roll NO</td>
                <td> <input class="uk-input congested-form" type="text" name="readmission_student_roll_no" id="readmission_student_roll_no"  /> </td>
            </tr>

            <tr> <td colspan="4"> <span onclick="readmission_entry();" style="cursor:pointer; margin-top:-5px" class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"   > Apply</span>
                </td></tr>

        </table>
        <?
    }

    if($valid_reg_no==false)
    {
        $old_Form=false;

        ?>



        <? if($old_Form) { ?>
        <hr>
        <h3 class="uk-margin-small"> Add new student for registration no <span style="color:#FF0000"> <?=$registrationNo ?> </span></h3>
        Star(<span class="star">*</span>) marks are mandatory.
        <table class="uk-table congested-table uk-table-justify">

            <tr>
                <td style="width:120px;"> Student Name <span class="star">*</span></td>
                <td>
                    <input class="uk-input congested-form" type="text" name="new_student_name" id="new_student_name"  />
                </td>
                <td class="uk-text-nowrap uk-text-right">

                    Gender <span class="star">*</span>
                </td>
                <td>
                    <select class="uk-select congested-form" name="new_student_gender" id="new_student_gender"   >
                        <option value="" > </option>
                        <?  $os->onlyOption($os->gender,'');?>
                    </select>
                </td>
            </tr>

            <tr>
                <td> Mobile <span class="star">*</span></td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_mobile_student" id="new_student_mobile_student"  /> </td>
                <td class="uk-text-right"> Dob</td>
                <td> <input class="uk-input congested-form datepicker" type="text" name="new_student_dob" id="new_student_dob"    /></td>

            </tr>
            <tr>
                <td> Session <span class="star">*</span></td>
                <td>
                    <select class="uk-select congested-form"  name="new_student_asession" id="new_student_asession">
                        <option value=""> </option>
                        <?

                        $os->onlyOption($os->asession, '');
                        ?>
                    </select>
                </td>
                <td class="uk-text-right">
                    Class <span class="star">*</span>
                </td>
                <td>
                    <select class="uk-select congested-form" name="new_student_class" id="new_student_class"   >
                        <option value="">Class</option>




                        <? foreach($os->board_class as $board=>$classes){?>
                            <optgroup label="<?=$board?>">
                                <? foreach ($classes as $class){?>
                                    <option value="<? echo $class?>"> <? echo $os->classList[$class]?></option>
                                <? }?>
                            </optgroup>
                        <? } ?>



                    </select>

                </td>
            </tr>




            <tr>
                <td> Branch <span class="star">*</span></td>
                <td colspan="3">
                    <select   name="new_student_branch_code" id="new_student_branch_code"
                              class="uk-select uk-border-rounded congested-form   "   >
                        <? $os->onlyOption($branch_code_arr,'');	?>
                    </select>


                </td>
            </tr>




            <tr>
                <td> Father Name <span class="star">*</span> </td>
                <td colspan="3"> <input class="uk-input congested-form" type="text" name="new_student_father_name" id="new_student_father_name"  /> </td>
            </tr>

            <tr>
                <td> Vill</td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_vill" id="new_student_vill"  /> </td>
                <td class="uk-text-right"> PO</td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_po" id="new_student_po"  /> </td>
            </tr>



            <tr>
                <td> PS</td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_ps" id="new_student_ps"  /> </td>
                <td class="uk-text-right">Dist.</td>
                <td> <input class="uk-input congested-form" type="text"  name="new_student_dist" id="new_student_dist"  /> </td>
            </tr>


            <tr>
                <td> Block</td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_block" id="new_student_block"  /> </td>

                <td class="uk-text-right"> PIN</td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_pin" id="new_student_pin"  /> </td>
            </tr>
            <tr>
                <td> State</td>
                <td colspan="3"> <input class="uk-input congested-form" type="text" name="new_student_state" id="new_student_state"  /> </td>
            </tr>


            <tr>
                <td> Email</td>
                <td colspan="3"> <input class="uk-input congested-form" type="text" name="new_student_email_student" id="new_student_email_student"  /> </td>
            </tr>
            <tr>
                <td> Section</td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_section" id="new_student_section"  /> </td>

                <td class="uk-text-right"> Roll NO</td>
                <td> <input class="uk-input congested-form" type="text" name="new_student_roll_no" id="new_student_roll_no"  /> </td>
            </tr>




        </table>
    <? }else{ ?>


        <? include('student_other_fields.php'); ?>
    <? } ?>


        <button class="bp3-button bp3-small bp3-intent-primary" type="button" value="ADD STUDENT" onclick="save_add_new_student_data()">Add Student</button>

        <?
    }

    exit();
}

if($os->get('readmission_entry')=='OK' && $os->post('readmission_entry')=='OK')
{

    $registrationNo = $os->post('readmission_student_reg_no');
    $registerNo=trim($registrationNo);
    $registrationNo=trim($registrationNo);
    if($registrationNo==''){ exit();}

    $readmission_student_class=  $os->post('readmission_student_class');
    $readmission_student_asession=  $os->post('readmission_student_asession');
    $readmission_student_branch_code=  $os->post('readmission_student_branch_code');

    $readmission_student_section=  $os->post('readmission_student_section');
    $readmission_student_roll_no=  $os->post('readmission_student_roll_no');





    $os->setSession($readmission_student_class, 'readmission_student_class');
    $os->setSession($readmission_student_asession, 'readmission_student_asession');


    //$selected_branch_code=$os->getSession($key1='selected_branch_code');







    if($registrationNo!='' &&  $readmission_student_class!=''  &&  $readmission_student_asession!='' )
    {
        $history_details="select  * from history where registrationNo='$registrationNo'  and  class='$readmission_student_class'  and  asession='$readmission_student_asession'  ";
        $history_details_rs= $os->mq($history_details);
        $history = $os->mfa($history_details_rs);

        $historyId=0;
        if(isset($history['historyId']))
        {
            $historyId=$history['historyId'];

        }

        if($historyId>0)
        {
            ?><span style="color:#FF0000;">Data already exist. Please check carefully. </span><?
        }else
        {
            $studentId=0;
            $st_details="select  * from student where registerNo='$registrationNo' limit 1   ";
            $st_details_rs= $os->mq($st_details);
            $student = $os->mfa($st_details_rs);
            if(isset($student['studentId']))
            {
                $studentId=$student['studentId'];
            }

            if($studentId)
            {


                $dataToSave['asession']=$readmission_student_asession;
                $dataToSave['registrationNo']=$registrationNo;
                $dataToSave['branch_code']=$readmission_student_branch_code;
                $dataToSave['class']=$readmission_student_class;
                $dataToSave['historyStatus']='Active';
                $dataToSave['remarks']='Added Manually';
                $dataToSave['section']=$readmission_student_section;
                $dataToSave['roll_no']=$readmission_student_roll_no;
                $dataToSave['addedDate']=$os->now();
                $dataToSave['addedBy']=$os->userDetails['adminId'];
                $dataToSave['studentId']=$studentId;
                $qResult=$os->save('history',$dataToSave,'historyId','');

                if($qResult){


                    ?><span style="color:#009900;">Readmission of <?=$registrationNo ?> to class <?=$os->classList[$readmission_student_class]?> Year <?=$readmission_student_asession?> Successfull.
                    </span><?



                }
            }




        }


    }else{
        ?><span style="color:#FF0000;">Wrong Info. It seems you need more training. </span><?

    }



    exit();


    $return_acc=$os->branch_access();
    $and_branch='';
    if($os->userDetails['adminType']!='Super Admin')
    {

        $selected_branch_codes=$return_acc['branches_code_str_query'];
        $and_branch=" and branch_code IN($selected_branch_codes)";

    }

    $branch_code_arr=array();
    $branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";

    $branch_row_rs= $os->mq($branch_row_q);
    while ($branch_row = $os->mfa($branch_row_rs))
    {
        $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
    }







    $valid_reg_no=false;
    $sQuery="select h.* ,s.*  from history  h  LEFT JOIN student s on (s.studentId=h.studentId and h.registrationNo=s.registerNo )   where h.registrationNo!='' and h.registrationNo='$registrationNo' and  s.registerNo='$registerNo' group by historyId order by historyId desc ";
    $result=$os->mq($sQuery);
}

if($os->get('stdent_edit_trace')=='OK' && $os->post('stdent_edit_trace')=='OK' )
{
    $student_id=$os->post('student_id');
    $st_details="select  s.* , a.name admin_name from student s 
    LEFT JOIN admin a on s.addedBy=a.adminId
    where s.studentId='$student_id' limit 1   ";
    $st_details_rs= $os->mq($st_details);
    $student = $os->mfa($st_details_rs);

// log details
    $edit_log_q="select  el.* , a.name admin_name from edit_log  el  
    LEFT JOIN admin a on el.addedBy=a.adminId   
    where 
    el.type='student_edit' and 

    el.table_id_value='$student_id' order by el.addedDate desc ";
    $edit_log_q_rs= $os->mq($edit_log_q);
    echo '##--stdent_edit_trace_DIV_data--##';
    ?>
    <h2> Reg No : <span style="color:#FF33CC">  <? echo $student['registerNo']  ?>  </span> -  <? echo $student['name']  ?> </h2>
    <div style="margin-top:20px;">
	
	  <div id="student_metadata_div" style="border:1px solid #CCCCCC; padding:5px;">
                        <form id="student_metadata_form" >
                            <input type="hidden" name="student_metadata_student_id" value="<? echo $student_id?>"    />

                            <? include('student_other_fields_for_edit.php'); ?>

                        </form>
                        <div style="clear:both"> </div>
                    </div>
	
	
	
         





    </div>
    <?


    echo '##--stdent_edit_trace_DIV_data--##';
}



if($os->get('stdent_save_trace')=='OK' && $os->post('stdent_save_trace')=='OK' )
{
    $update_msg='Update Failed. Please try later.';
    $student_id=$os->post('student_id');
    $table_field=$os->post('table_field');
    $table_field_new_val=$os->post('table_field_new_val');

    $st_details="select  * from student where studentId='$student_id' limit 1   ";
    $st_details_rs= $os->mq($st_details);
    $student = $os->mfa($st_details_rs);


    $old_fld_value = $student[$table_field];


    $dataToSave_trace[$table_field]=$table_field_new_val;
    //$studentId_updated=$student_id;
    $studentId_updated=$os->save('student',$dataToSave_trace,'studentId',$student_id);

    if($studentId_updated>0)
    {
        $edit_log_save=array();

        $edit_log_save['type']='student_edit';
        $edit_log_save['table_name']='student';
        $edit_log_save['table_id_value']=$student_id;
        $edit_log_save['remarks']='';
        $edit_log_save['table_field']=$table_field;
        $edit_log_save['old_val']=$old_fld_value;
        $edit_log_save['new_val']=$table_field_new_val;
        $edit_log_save['addedDate']=$os->now();
        $edit_log_save['addedBy']=$os->userDetails['adminId'];
        $output=$os->save('edit_log',$edit_log_save,'edit_log','');
        $update_msg="Update successfully . Old val: $old_fld_value  =>  New value : $table_field_new_val ";

    }

    echo '##--stdent_edit_trace_alert--##';
    echo $update_msg;
    echo '##--stdent_edit_trace_alert--##';
    echo '##--stdent_edit_trace_student_id--##'; echo $student_id ;  echo '##--stdent_edit_trace_student_id--##';
}

if($os->get('save_student_metadata_form')=='OK' && $os->post('save_student_metadata_form')=='OK')
{
    $k=$os->post();
    $success_msg=false;
    $student_id = $os->post('student_metadata_student_id');
    //$student_id =19488;
    $student_meta_id=0;
    $st_details="select  * from student_meta where student_id='$student_id' limit 1   ";
    $st_details_rs= $os->mq($st_details);
    $student_meta = $os->mfa($st_details_rs);
    if(isset($student_meta['student_meta_id']))
    {
        $student_meta_id= $student_meta['student_meta_id'];

    }
/// student meta ------------------------------------------
    $dataToSave_meta['student_id'] = $student_id;
    $dataToSave_meta['medium'] = $os->post('new_medium');
    $dataToSave_meta['present_fees'] = $os->post('new_present_fees');
    $dataToSave_meta['referer_details'] = $os->post('new_referer_details');
    $dataToSave_meta['eye_power'] = $os->post('new_eye_power');
    $dataToSave_meta['psychiatric_report'] = $os->post('new_psychiatric_report');
    $dataToSave_meta['mother_tongue'] = $os->post('new_mother_tongue');
    $dataToSave_meta['apl_bpl'] = $os->post('new_apl_bpl');
    $dataToSave_meta['father_adhar'] = $os->post('new_father_adhar');
    $dataToSave_meta['mother_adhar'] = $os->post('new_mother_adhar');
    $dataToSave_meta['email_guardian'] = $os->post('new_email_guardian');
    $dataToSave_meta['nationality'] = $os->post('new_nationality');
    $dataToSave_meta['country_name'] = $os->post('new_country_name');
    $dataToSave_meta['passport_no'] = $os->post('new_passport_no');
    $dataToSave_meta['vissa_type'] = $os->post('new_vissa_type');
    $dataToSave_meta['passport_valid_up_to'] = $os->post('new_passport_valid_up_to');
    $dataToSave_meta['caste_cert_no'] = $os->post('new_caste_cert_no');
    $dataToSave_meta['cast_cert_issue_auth'] = $os->post('new_cast_cert_issue_auth');
    $dataToSave_meta['cast_cert_issue_date'] = $os->post('new_cast_cert_issue_date');
    $dataToSave_meta['disabled'] = $os->post('new_disabled');
    $dataToSave_meta['disable_body_parts'] = $os->post('new_disable_body_parts');
    $dataToSave_meta['disable_percet'] = $os->post('new_disable_percet');
    $dataToSave_meta['disable_cert_no'] = $os->post('new_disable_cert_no');
    $dataToSave_meta['disable_cert_issue_auth'] = $os->post('new_disable_cert_issue_auth');
    $dataToSave_meta['disable_cert_issue_date'] = $os->post('new_disable_cert_issue_date');
    $dataToSave_meta['living_area_dist'] = $os->post('new_living_area_dist');
    $dataToSave_meta['living_area_sub_division'] = $os->post('new_living_area_sub_division');
    $dataToSave_meta['living_area_town'] = $os->post('new_living_area_town');
    $dataToSave_meta['living_area_semi_town'] = $os->post('new_living_area_semi_town');
    $dataToSave_meta['living_area_vill'] = $os->post('new_living_area_vill');
    $dataToSave_meta['living_area_gram_panchayet'] = $os->post('new_living_area_gram_panchayet');
    $dataToSave_meta['any_bro_sis_presently'] = $os->post('new_any_bro_sis_presently');


    $dataToSave_meta['bro_sis_presently_details'] = serialize($os->post('new_bro_sis_presently_details'));

    $dataToSave_meta['any_bro_sis_passed'] = $os->post('new_any_bro_sis_passed');


    $dataToSave_meta['bro_sis_passed_details'] = serialize($os->post('new_bro_sis_passed_details'));

    $dataToSave_meta['any_family_is_mission_emp'] = $os->post('new_any_family_is_mission_emp');
    $dataToSave_meta['family_is_mission_emp_details'] = serialize($os->post('new_family_is_mission_emp_details'));

    $dataToSave_meta['is_father_alive'] = $os->post('new_is_father_alive');
    $dataToSave_meta['father_date_of_death'] = $os->post('new_father_date_of_death');
    $dataToSave_meta['father_qualification'] = $os->post('new_father_qualification');
    $dataToSave_meta['father_monthly_income'] = $os->post('new_father_monthly_income');
    $dataToSave_meta['is_mother_alive'] = $os->post('new_is_mother_alive');
    $dataToSave_meta['mother_date_of_death'] = $os->post('new_mother_date_of_death');
    $dataToSave_meta['mother_qualification'] = $os->post('new_mother_qualification');
    $dataToSave_meta['mother_monthly_income'] = $os->post('new_mother_monthly_income');
    $dataToSave_meta['gurdian_qualification'] = $os->post('new_gurdian_qualification');
    $dataToSave_meta['gurdian_monthly_income'] = $os->post('new_gurdian_monthly_income');
    $dataToSave_meta['corr_vill'] = $os->post('new_corr_vill');
    $dataToSave_meta['corr_po'] = $os->post('new_corr_po');
    $dataToSave_meta['corr_ps'] = $os->post('new_corr_ps');
    $dataToSave_meta['corr_block'] = $os->post('new_corr_block');
    $dataToSave_meta['corr_state'] = $os->post('new_corr_state');
    $dataToSave_meta['corr__dist'] = $os->post('new_corr__dist');
    $dataToSave_meta['corr_pin'] = $os->post('new_corr_pin');
    $dataToSave_meta['last_school'] = $os->post('new_last_school');
    $dataToSave_meta['last_class'] = $os->post('new_last_class');
    $dataToSave_meta['last_school_session'] = $os->post('new_last_school_session');
    $dataToSave_meta['tc_no'] = $os->post('new_tc_no');
    $dataToSave_meta['tc_date'] = $os->post('new_tc_date');
    $dataToSave_meta['student_id_in_TC'] = $os->post('new_student_id_in_TC');
    $dataToSave_meta['last_school_address'] = $os->post('new_last_school_address');
    $dataToSave_meta['present_school'] = $os->post('new_present_school');
    $dataToSave_meta['present_school_address'] = $os->post('new_present_school_address');
    $dataToSave_meta['present_school_contact'] = $os->post('new_present_school_contact');
    $dataToSave_meta['present_school_class'] = $os->post('new_present_school_class');
    $dataToSave_meta['present_school_session'] = $os->post('new_present_school_session');
    $dataToSave_meta['present_school_roll'] = $os->post('new_present_school_roll');
    $dataToSave_meta['present_school_section'] = $os->post('new_present_school_section');
    $dataToSave_meta['accNo'] = $os->post('new_accNo');
    $dataToSave_meta['accHolderName'] = $os->post('new_accHolderName');
    $dataToSave_meta['ifscCode'] = $os->post('new_ifscCode');
    $dataToSave_meta['bank_branch'] = $os->post('new_bank_branch');
    $dataToSave_meta['bank_name'] = $os->post('new_bank_name');
    $dataToSave_meta['kanyashree_type'] = $os->post('new_kanyashree_type');
    $dataToSave_meta['kanyashree_ID_NO'] = $os->post('new_kanyashree_ID_NO');
    $dataToSave_meta['ten_name_of_board'] = $os->post('new_ten_name_of_board');
    $dataToSave_meta['ten_passed_year'] = $os->post('new_ten_passed_year');
    $dataToSave_meta['ten_roll'] = $os->post('new_ten_roll');
    $dataToSave_meta['ten_no'] = $os->post('new_ten_no');
    $dataToSave_meta['ten_marks_beng_hindi'] = $os->post('new_ten_marks_beng_hindi');
    $dataToSave_meta['ten_marks_eng'] = $os->post('new_ten_marks_eng');
    $dataToSave_meta['ten_marks_math'] = $os->post('new_ten_marks_math');
    $dataToSave_meta['ten_marks_physc'] = $os->post('new_ten_marks_physc');
    $dataToSave_meta['ten_marks_lifesc'] = $os->post('new_ten_marks_lifesc');
    $dataToSave_meta['ten_marks_history'] = $os->post('new_ten_marks_history');
    $dataToSave_meta['ten_marks_geography'] = $os->post('new_ten_marks_geography');
    $dataToSave_meta['ten_marks_socialsc'] = $os->post('new_ten_marks_socialsc');
    $dataToSave_meta['ten_marks_total_obt'] = $os->post('new_ten_marks_total_obt');
    $dataToSave_meta['ten_marks_out_of'] = $os->post('new_ten_marks_out_of');
    $dataToSave_meta['ten_marks_percent'] = $os->post('new_ten_marks_percent');
    $dataToSave_meta['twelve_name_of_board'] = $os->post('new_twelve_name_of_board');
    $dataToSave_meta['twelve_passed_year'] = $os->post('new_twelve_passed_year');
    $dataToSave_meta['twelve_roll'] = $os->post('new_twelve_roll');
    $dataToSave_meta['twelve_no'] = $os->post('new_twelve_no');
    $dataToSave_meta['twelve_stream'] = $os->post('new_twelve_stream');
    $dataToSave_meta['twelve_marks_beng_hindi'] = $os->post('new_twelve_marks_beng_hindi');
    $dataToSave_meta['twelve_marks_eng'] = $os->post('new_twelve_marks_eng');
    $dataToSave_meta['twelve_marks_math'] = $os->post('new_twelve_marks_math');
    $dataToSave_meta['twelve_marks_physc'] = $os->post('new_twelve_marks_physc');
    $dataToSave_meta['twelve_marks_biology'] = $os->post('new_twelve_marks_biology');
    $dataToSave_meta['twelve_marks_chemistry'] = $os->post('new_twelve_marks_chemistry');
    $dataToSave_meta['twelve_marks_total_obt'] = $os->post('new_twelve_marks_total_obt');
    $dataToSave_meta['twelve_marks_out_of'] = $os->post('new_twelve_marks_out_of');
    $dataToSave_meta['twelve_marks_percent'] = $os->post('new_twelve_marks_percent');
    $dataToSave_meta['graduate_passed'] = $os->post('new_graduate_passed');
    $dataToSave_meta['graduate_passed_subject'] = $os->post('new_graduate_passed_subject');
    $dataToSave_meta['graduate_passed_year'] = $os->post('new_graduate_passed_year');
    $dataToSave_meta['graduate_passed_university'] = $os->post('new_graduate_passed_university');
    $dataToSave_meta['graduate_subjects'] = $os->post('new_graduate_subjects');
    $dataToSave_meta['graduate_subjects_marks'] = $os->post('new_graduate_subjects_marks');
    $dataToSave_meta['graduate_total_obt'] = $os->post('new_graduate_total_obt');
    $dataToSave_meta['graduate_out_of'] = $os->post('new_graduate_out_of');
    $dataToSave_meta['graduate_percent'] = $os->post('new_graduate_percent');
    $dataToSave_meta['student_other_info'] = $os->post('new_student_other_info');

    //$del_query="delete from  where  student_id='$studentId'";
    //$os->mq($del_query);

    $qResult=$os->save('student_meta',$dataToSave_meta,'student_meta_id',$student_meta_id);

    /// student meta ------------------------------------------

    if($qResult)
    {
        $success_msg=true;
        $student_meta_id_new=$qResult;

        $profile_pic=$os->UploadPhoto('profile_picture',$site['root'].'wtos-images');
        if($profile_pic!=''){
            $dataToSave['profile_picture']=$profile_pic;
            $os->save('student',$dataToSave,'studentId',$student_id);
        }
        $student_img=$os->UploadPhoto('student_img',$site['root'].'wtos-images');
        if($student_img!=''){
            $dataToSave['image']=$student_img;
            $os->save('student',$dataToSave,'studentId',$student_id);
        }

        if($student_meta_id_new>0)
        {
            $edit_log_save=array();
            $edit_log_save['type']='student_edit';
            $edit_log_save['table_name']='student_meta';
            $edit_log_save['table_id_value']=$student_id;
            $edit_log_save['remarks']='';
            $edit_log_save['table_field']='All';
            $edit_log_save['old_val']='';
            $edit_log_save['new_val']='';
            $edit_log_save['addedDate']=$os->now();
            $edit_log_save['addedBy']=$os->userDetails['adminId'];
            $output=$os->save('edit_log',$edit_log_save,'edit_log','');
        }

    }



    if($success_msg)
    {
        echo 'Updated Successfully';
    }else
    {
        echo 'Update Failed';
    }


}



if($os->get('set_state_dist_by_pin')=='OK' && $os->post('set_state_dist_by_pin')=='OK' )
{




    $pin_val = $os->post('pin_val');
    $state_field = $os->post('state_field');
    $dist_field = $os->post('dist_field');

    $api_link="https://api.postalpincode.in/pincode/".$pin_val;
    $datafile=file_get_contents($api_link);

    $data=json_decode($datafile,true);

    $State=$data[0]['PostOffice'][0]['State'];
    $District=$data[0]['PostOffice'][0]['District'];

    echo '##--state_field_id--##'; echo $state_field; echo '##--state_field_id--##';
    echo '##--dist_field_id--##'; echo $dist_field; echo '##--dist_field_id--##';


    echo '##--state_field_val--##'; echo $State; echo '##--state_field_val--##';
    echo '##--dist_field_val--##'; echo $District; echo '##--dist_field_val--##';

}

if($os->get('show_subscription')=='OK'){
    $studentId=$os->post("studentId");
    $subscription_q="SELECT 
    subs.*  FROM subscription as subs   
    where subs.subscription_id>0 and subs.studentId='$studentId' ORDER BY subs.subscription_id desc";
    $subscription_mq=$os->mq($subscription_q);?>
    <h5 style="font-weight: bold;" class="uk-margin-top uk-margin-left uk-margin-bottom">Name : <span class="uk-text-success"><?=$os->post("name");?></span>&nbsp;&nbsp; Mobile No : <span class="uk-text-warning"><?=$os->post("mobile_student");?></span>&nbsp;&nbsp;Class :  <span class="uk-text-danger"><?=$os->post("classVal");?></span>&nbsp;&nbsp;Session : <span class="uk-text-primary"><?=$os->post("asession");?></span></h5>
    <table class="uk-table uk-table-striped uk-margin-remove uk-table-hover">
        <thead>
        <tr >
            <th ><b>#</td>
            <th ><b>Date</b></th>
            <th class="uk-text-nowrap"><b>Total Amount</b></th>
            <th class="uk-text-nowrap"><b>From Month</b></th>
            <th class="uk-text-nowrap"><b>To Month</b></th>
            <th class="uk-text-nowrap"><b>Total Month</b></th>
            <th class="uk-text-nowrap"><b>Payment Status</b></th>
        </tr>
        </thead>
        <tbody>
        <?
        $subscription_details_c=1;
        while($record=$os->mfa($subscription_mq)){
            ?>
            <tr>
                <td><?php echo $subscription_details_c;?></td>
                <td><?php echo $os->showDate($record['dated']); ?></td>
                <td><?php echo $record['total_amount']; ?></td>
                <td><?php echo $os->showDate($record['from_date']); ?></td>
                <td><?php echo $os->showDate($record['to_date']); ?></td>
                <td><?php echo $record['month_count']; ?></td>
                <td><?php echo $record['payment_status']; ?></td>
            </tr>

            <?$subscription_details_c++;}?>
        <?if($subscription_details_c==1){?>
            <tr><td colspan="6" style="color:red;font-weight: bold">No data available at the moment.</td></tr>
        <?}?>
        </tbody>
    </table>

    <? exit();}

if($os->get('student_fees_setting')=='OK')
{



    $history_id=$os->post("history_id");
    $historyData=$os->rowByField('','history','historyId',$history_id);
    $student_id=  $historyData['studentId'];
    $studentData=$os->rowByField('','student','studentId',$student_id);
    $asession=$historyData['asession'];
    $class_id=$historyData['class'];

    $student_type_for_student=$os->post("student_type_for_student");
	
	if($student_type_for_student==''){$student_type_for_student=$historyData['student_type'];}
    $fees_slab_for_student=$os->post("fees_slab_for_student");
 
      $branch_code=$historyData['branch_code'];
    $action=$os->post('action');
    if($action=='save')
    {
        $fees_config_data_post=$os->post();


        // filter checked data

        if(isset( $fees_config_data_post['fees_approved']))
        {
            foreach($fees_config_data_post['fees_approved'] as $ftype=>$head_val_arr )
            {
                foreach($head_val_arr as $head_name=>$amount_val)
                {

                    //  echo  " $ftype  $head_name $amount_val   ";

                    if( isset($fees_config_data_post['fees_approved_checked'][$ftype][$head_name]))
                    {
                        // allow  fees

                    }else{

                        unset($fees_config_data_post['fees_approved'][$ftype][$head_name]);
                    }


                }


            }

        }

        // filter checked data  end
        //  _d($fees_config_data_post);




        $save_to_database['fees_config_data']=serialize($fees_config_data_post);
        if($history_id>0){

            $os->save('history',$save_to_database,'historyId',$history_id);

            create_fees_student($history_id);
            // generate fess 777777777

            // _d($fees_config_data_post['fees_approved']); exit();

        }

    }

    

    $fees_slab_arr=array();
    $data_rs=$os->rowsByField('','fees_slab','classId',$class_id,$where=" and year='$asession' and branch_code='$branch_code'   ",$orderby='',$limit='');
	 
    while($rs=$os->mfa($data_rs))
    {
        $fees_slab_arr[$rs['fees_slab_id']]=$rs['title'].' - '.$rs['note'];
    }


    $feesconfig_selected=array();
    $data_rs=$os->rowsByField('','feesconfig','classId',$class_id,$where=" and accademicsessionId='$asession'  and fees_slab_id='$fees_slab_for_student'  and student_type='$student_type_for_student' and  fees_slab_id!=''       ",$orderby='',$limit='');
    while($rs=$os->mfa($data_rs))
    {


        $feesconfig_selected[$rs['feesType']][$rs['feesconfigId']]=$rs;


    }








    ?>

<!-- landmark-fees-config-list -->
    <h3 style="color:#000099;">  <? echo $studentData['name']; ?> - <? echo $studentData['registerNo']; ?>  - <? echo $os->classList[$class_id];?>   -  <? echo $asession; ?>       </h3>
  
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top" style="width:60%;padding-right:6px;">
			 
			
			
			
			<?  $fees_config_data_serialize=$os->rowByField('fees_config_data ','history','historyId',$history_id);
                $fees_config_data=unserialize($fees_config_data_serialize);



                if(isset($fees_config_data['student_type_for_student']))
                {
                    $type= $os->student_type[$fees_config_data['student_type_for_student']];
                }
                if(isset($fees_config_data['fees_slab_for_student']))
                {
                    $slab= $fees_slab_arr[$fees_config_data['fees_slab_for_student']];
                }

                if($type!=''){


                    ?>

                    <h4 style="border-bottom:2px solid #666666;"> <? echo $type; ?> - <? echo $slab; ?>  </h4>
					 

            <div class="uk-child-width-expand@s" uk-grid>
                    <?
                    if( isset($fees_config_data['fees_approved']))
                    {

                        foreach($fees_config_data['fees_approved'] as $feesType=>$rows){

                            if(count($rows)>0) {
                                ?>
                              <div>
                                <table class="uk-table uk-table-small uk-table-divider uk-table-hover" >
								  <tr>
                                       <td colspan="5"> <b><? echo $feesType ?>  </b> </td>  
                                    </tr>
                                   

                                    <?

                                    $total=0;
                                    foreach($rows as $head=>$amount){
                                        $total=$total+$amount;




                                        ?>


                                        <tr>
                                            <td><? echo $head; ?></td>
                                            <td><? echo $amount; ?></td>
                                            
                                        </tr>

                                        <?
                                    }?>
                                    <tr style="background-color:#FFFF99;">
                                        <td>Total</td>
                                        <td> <b><? echo $total; ?> </b></td>
                                        
                                    </tr>
                                </table>
                                
                             </div>
                                <?

                            }
                        }


                    }

                     ?>
                  </div>





                <? }else{ ?>

                    <h5 style="color:#FF9933"> Fees setting missing  </h5>

                <? } ?>
				
				
 
                <!--    fees created -->
                <?
                $fees_student_rs=$os->rowsByField('','fees_student','historyId',$history_id);
                ?>
				<div style="height:5px;" > &nbsp;</div>
                
               <table class="uk-table uk-table-small uk-table-divider uk-table-hover">
			   <tr>
                        <td colspan="15" style="background-color:#006BD7">
						<h4 style="color:#FFFFFF; font-weight:bold;"> FEES Details -
						<? echo $studentData['name']; ?> - <? echo $studentData['registerNo']; ?>  - <? echo $os->classList[$class_id];?>   -  <? echo $asession; ?>
						</h4> </td>
                        
                    </tr>
                    <tr style="background-color:#CCCCCC;">
                        <td style="width:20px;"> </td>
                        <td style="width:70px;"><b>Type</b></td>
                        <td style="width:70px;"><b>Month</b></td>
                        <td style="width:50px;"><b>Year</b></td>
                        <td style="width:80px;"><b>Fees</b></td>
                        <td style="width:50px;"><b>Status</b></td>
                        <td style="width:80px;"><b>Due Amt.</b></td>
                        <td style="width:90px;"><b>Receipt.</b></td>
                    </tr>




                    <?
                    while($row=$os->mfa( $fees_student_rs))
                    {

                        $due_amt=calculate_due($row['fees_student_id'],$row['totalPayble'],$row['paymentStatus']);
                        ?>


                        <tr>
                            <td>  </td>


                            <td><? echo $row['feesType']; ?></td>
                            <td><? echo $os->feesMonth[$row['month']]; ?></td>
                            <td><? echo $row['year']; ?></td>
                            <td><? echo $row['totalPayble']; ?></td>
                            <td style=" padding:2px;background-color: <? if($row['paymentStatus']=='paid'){ ?> #00CC33 <? }else{ ?> #FECBC2 <? } ?>" >
                                <? echo $row['paymentStatus']; ?>  </td>
                            <td><? echo $due_amt; ?></td>
                            <td>  <?  receipt_links($row['receipt_no']);   ?></td>

                        </tr>

                        <?
                    }?>

                </table>


                <!--    fees created end -->



            </td>
            <td valign="top" style="background-color:#F8F8F8; padding:5px;  border:1px solid #D3D3D3; ">

                <select   id="student_type_for_student" name="student_type_for_student" onchange="student_fees_setting('<? echo $history_id ?>','')">
                    <option value="" > </option>
                    <?  $os->onlyOption($os->student_type,  $student_type_for_student );?>
                </select>

                <select   id="fees_slab_for_student" name="fees_slab_for_student"  onchange="student_fees_setting('<? echo $history_id ?>','')"   >
                    <option value="" > </option>
                    <?  $os->onlyOption($fees_slab_arr,  $fees_slab_for_student );?>
                </select>
				<br />
                
                <? if(count($feesconfig_selected)>0){

                    foreach($feesconfig_selected as $feesType=>$rows){
                        ?>
                       
                        <table class="uk-table uk-table-small uk-table-divider uk-table-hover" style="margin-top:0px;">
                            <tr>
                                <td colspan="5"><? echo $feesType ?>  </td>
                            </tr>
							
							 



                            <?
                            $configtotal=0;
                            $saved_total=0;
                            foreach($rows as $feesconfigId=>$row){
                                $configtotal=$configtotal+$row['amount'];




                                ?>


                                <tr><td style="width:20px;">

                                        <input type="checkbox" name="fees_approved_checked[<? echo $feesType ?>][<? echo  $row['feesHead'] ?>]" value="1"  /></td>
                                    <td style="width:150px;">



                                        <? echo $row['feesHead']; ?></td>
                                    <td style="width:100px;">
                                        <input type="text" name="fees_approved[<? echo $feesType ?>][<? echo  $row['feesHead'] ?>]" value="<? echo $row['amount'] ?>" style="width:60px;" />
                                        <input type="hidden" name="fees_config[<? echo $feesType ?>][ <? echo  $row['feesHead'] ?>]" value="<? echo $row['amount'] ?>" style="width:60px;" />


                                    </td>
                                    <td style="width:50px;"><? echo $row['amount']; ?></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <?
                            }?>
                            <tr style=" background-color:#FFFF99;"><td> </td>
                                <td>Total</td>
                                <td> </td>
                                <td> <b><? echo $configtotal; ?> </b></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                         

                        <?
                    }
                    ?>   <input type="button" value="Save Fees Setting" onclick="student_fees_setting('<? echo $history_id ?>','save')" style="cursor:pointer;" /> <?
                } ?>

            </td>
            <td valign="top"  style="background-color:#FBFBFB; padding:5px;">

                <? if(count($feesconfig_selected)>0){ ?>
                    <!-- fees months selection -->
                   <div style="border-bottom:1px solid #333333; padding:10px; background-color:#F4F4F4"> Select months</div>
                    <?
                    $session_months=global_session_setting_months($asession,$class_id);
                    if(count($session_months)<1)
                    {
                        echo 'Please set session start and  end date in global session setting ';

                    }else
                    {
                        ?> <table> <?

                        foreach($session_months as $months_year)
                        {

                            $month_conf=substr($months_year,4,2);
                            $month_conf= (int)$month_conf;
                            $year_conf=substr($months_year,0,4);


                            ?>
                            <tr> <td> <input type="checkbox" checked="checked" name="session_months_selected[]" value="<? echo $months_year ?>"  /></td>
                                <td title="<? echo $month_conf ?>"><? echo $os->feesMonth[$month_conf]; ?> <? echo $year_conf ?> </td>

                            </tr>



                            <?

                        }

                        ?> </table> <?
                    }

                }
                ?>


            </td>
        </tr>
    </table>




    <?



    exit();
}


if($os->get('student_fees_collect')=='OK')
{
    
	$selected_fees_row=array();
    $historyId=$history_id=$os->post("history_id");
    $historyData=$os->rowByField('','history','historyId',$history_id);
    $studentId=$student_id=  $historyData['studentId'];
    $studentData=$os->rowByField('','student','studentId',$student_id);
    $asession=$historyData['asession'];
    $class_id=$historyData['class'];

    if($os->post('select_fees_row'))
    {
        $selected_fees_row=$os->post('select_fees_row');
    }
    $action=$os->post("action");
	
	$fees_payment_id='';
	
	 if($action=='show_form')
    {
	 $selected_fees_row=array();
	}
	
    if($action=='generate_receipt')
    {



        $amount_total=$os->post("amount_total"); ///
        $special_discount=$os->post("special_discount"); //
        $special_discount_note=$os->post("special_discount_note"); //
        $payble_total=$os->post("payble_total");
        $paid_fees_amount=(int)$os->post("paid_fees_amount");
        $due_fees_amount=$os->post("due_fees_amount");
        $due_on_fees_student_id=$os->post("due_on_fees_student_id"); //
        $student_fees_amounts=$os->post("student_fees_amounts"); //
		
		
		$receipt_no=$os->post("receipt_no");
		$payment_options=$os->post("payment_options");
		$paymentNote=$os->post("paymentNote");
		$remarks=$os->post("remarks");
		
		 $paidDate=$os->post("paidDate");
		
		      
		

        // _d($prev_due_fees_student_ids);
        //exit();

        $create_payment_row=false;

        if($paid_fees_amount>=0){$create_payment_row=true; }

        if($due_fees_amount >0 && $due_on_fees_student_id <1)
        {
            $create_payment_row=false;
        }





        if($create_payment_row)	{
           $fees_payment_id= create_fees_payment_row(
                $studentId,
                $historyId,
                $asession,
                $class_id,
                $selected_fees_row,
                $amount_total,
                $special_discount,
                $payble_total,
                $paid_fees_amount,
                $due_fees_amount,
                $due_on_fees_student_id,
                $special_discount_note,
                $student_fees_amounts,$receipt_no,$payment_options,$paymentNote,$remarks,$paidDate
            ) ;
        }




    }





echo '##-feeshtml-##';

 $os->fees_colour_type = array ( 'Admission' => '#f5f9ab', 'Readmission' => '#d3ffd5','Monthly' => '#ebc8fb'  );
    ?>


     <!-- landmark-fees-collect -->
    <div class="uk-card uk-card-default uk-card-small uk-border-rounded uk-overflow-hidden"    >
        <div class="uk-card-header">
            <h4 class="uk-margin-remove">
                Fees Collection  
                <? echo $studentData['name']; ?> - <? echo $studentData['registerNo']; ?>  - <? echo $os->classList[$class_id];?>   -  <? echo $asession; ?> </h4>
				
				
				
        </div>
        <div>
            <div class="uk-grid-small uk-child-width-1-2 uk-grid-divider" uk-grid>
                <div style="width:70%">
                    <ul class="uk-margin-remove-bottom" uk-tab>
                        <li><a href="#" class="uk-text-large">Fees details</a></li>
                        <li><a href="#" class="uk-text-large">Payment details</a></li>
                    </ul>
                    <ul class="uk-switcher uk-margin-remove">
                        <li >
                            <?
                            $fees_student_rs=$os->rowsByField('','fees_student','historyId',$history_id);
                            ?>
                            <table class="uk-table uk-table-small uk-table-divider uk-table-hover">
                                <thead>
                                <tr class="uk-background-muted">
                                    <th style="width:20px;"> </th>
                                    <th style="width:70px;">Type</th>
                                    <th style="width:60px;">Month</th>
                                    <th style="width:50px;">Year</th>
                                    <th style="width:70px;">Fees</th>
                                    <th style="width:50px;">Status</th>
                                    <th style="width:50px;">Due </th>
                                    <th style="width:100px;">Receipt</th>
									<th style="width:10px;">Action</th>
									<th style="width:70px;">Waived Off</th>
									<th style="width:10px;"> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $total_due=0;

                                while($row=$os->mfa( $fees_student_rs))
                                {
                                     
                                    $fees_student_id=$row['fees_student_id'];
                                    $due_amt=(int)calculate_due($fees_student_id,$row['totalPayble'],$row['paymentStatus']);
                                    $total_due=$total_due+$due_amt;
									
									$addedBy=$os->rowByField('','admin','adminId',$row['addedBy']);
                                    $addedBy_str="Created By: ".$addedBy['name'] .", Created Date:".$os->showDate($row['addedDate']) ;
                                  
								  
								     /// receipt process/
									   
									   
									    $colour_status='#fc2600';
									   if($row['paymentStatus']=='paid'){ $colour_status='#00bd2f'; }
									   if($row['paymentStatus']=='unpaid'){ $colour_status='#fc2600'; }
									   if($row['paymentStatus']=='installment'){ $colour_status='#FF33CC'; }
								     
									 $colour_type_fees='#CCFFFF';
									 if(isset($os->fees_colour_type[$row['feesType']]))
									 {
									   $colour_type_fees=$os->fees_colour_type[$row['feesType']];
									 }
									  
								  
								    ?>


                                    <tr>
                                        <td> <? if($row['paymentStatus']!='paid' ) { ?>
                                                <input type="checkbox"
                                                       class="uk-checkbox uk-border-rounded"
                                                       onclick="student_fees_collect('<? echo $history_id ?>','calculate')" name="select_fees_row[]" value="<? echo $row['fees_student_id']; ?>" <?  if(in_array($row['fees_student_id'],$selected_fees_row) &&     $action!='generate_receipt'){?> checked="checked" <? } ?>    />
                                            <? } ?>
                                        </td>


                                        <td title="<? echo  $addedBy_str; ?>" style="background-color:<? echo $colour_type_fees; ?>;"><? echo $row['feesType']; ?></td>
                                        <td><? echo $os->feesMonth[$row['month']]; ?></td>
                                        <td><? echo $row['year']; ?></td>
                                        <td><? echo (int)$row['totalPayble']; ?></td>
                                        <td style=" font-weight:bold;color:<? echo $colour_status ?>;">
                                            <? echo $row['paymentStatus']; ?>  </td>
                                        <td title="<? echo $row['currentDueAmount']; ?>"><b style="padding-left:5px;"><? echo $due_amt; ?></b></td>
                                        <td >   
										<?  receipt_links($row['receipt_no']);   ?>
										 
										</td>
										
										 
     
										
										 <td> <? if($row['paymentStatus']=='unpaid'){ ?>  <a href="javascript:void(0);" onclick="delete_unpaid_fees_rows('<? echo $history_id; ?>','<? echo $fees_student_id; ?>', '<? echo $row['feesType']; ?>','<? echo $row['totalPayble']; ?>')" 
						      style="font-size:14px; font-weight:bold; color:#FF0000;">X</a>  <? } ?> 
							  </td>
							  
                                       <td>  <?  view_waved_off($fees_student_id);   ?>
									
									
									</td>
									 <td>
									
									 <? if($row['paymentStatus']=='unpaid' ||$row['paymentStatus']=='installment'){ ?>   
									 <div style="color:#000099; cursor:pointer; background-color:#99FFFF; font-weight:bold; font-size:15px; margin:0px;padding:2px 4px" title="Create new Waived Off " 
									 onclick="create_fees_waiveoff('<? echo $history_id; ?>','<? echo $fees_student_id; ?>','<? echo $due_amt; ?>');">  +  </div>  <? } ?> 
									   
										 
										</td>
                               </tr>

                                    <?
                                }?>
                               
							   <tr style="background:#FFFFCE;">
                                    <td> </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total</td>

                                    <td  ><b style="padding-left:5px;  font-size:14px"><? echo $total_due; ?></b></td>
                                    <td></td>
                                     <td></td>
									   <td></td>
									    <td></td>
                                </tr>
							   
							   </tbody>
                                <tfoot>
                                <tr >
                                    <td colspan="15"><input type="button" id="create_fees_button_id" value="Create Miscellaneous Fees" onclick="show_single_fees_form();" style="margin-left:10px; cursor:pointer;" /> </td>
                                 </tr>    
                                </tfoot>
                            </table>
							
							
							
							
							<!-- landmark-fees-Miscellaneous_fees -->
							<div id="create_fees_div_id" style="padding:10px; padding-top:0px;  "> <!--display:none;-->
							 
								 
								
							<table> <tr>
							 <td>Fees Head </td>
                                    <td><input type="text" name="fees_for" id="fees_for" list="fees_for_data" value="Dress" />
									
									<datalist id="fees_for_data">
									<option value="Dress">
									<option value="Bag">
									<option value="Medicine">
									<option value="Vehicle">
									 
									<option value="Other">
									</datalist>
									</td>
                                    <td>Amount</td>
                                    <td> <input type="text" name="fees_for_amount" id="fees_for_amount" style="width:60px;" value="4000" /></td>
                                    <td>Date</td>
									  <td><input type="text" name="fees_for_date" id="fees_for_date" value="2022-05-10" style="width:90px;cursor:pointer;" />
									  
									  <!--value="<? echo $os->now('Y-m-d'); ?>"-->
									  </td>
									    <td><input type="button" value="Save" onclick="create_single_fees('<? echo $history_id;?>');" /></td>
										   
							
							</tr> </table>  
						
								
							
							</div>
							<div style="padding:10px;" id="ddddiiivvvv">  </div>
							
                        </li>
                        <li>
                            <?
                            $fees_payment_rs=$os->rowsByField('','fees_payment','historyId',$history_id);
                            ?>
                            <table class="uk-table uk-table-small uk-table-divider uk-table-hover">
                                <thead>
                                <tr class="uk-background-muted">
                                    <td style="width:100px;">Date</td>
                                    <td style="width:70px;">Amount</td>
                                    <td style="width:50px;">discount</td>
                                    <td style="width:80px;">Payble</td>
                                    <td style="width:50px;">Paid</td>
                                    <td style="width:100px;">Due</td>
                                    <td style="width:100px;">Receipt</td>
                                    <td  >By</td>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $total_paid=0;
                                while($row=$os->mfa( $fees_payment_rs))
                                {


                                    $fees_student_Ids=$row['fees_student_Ids'];

                                    $total_paid=$total_paid + $row['paidAmount'];

                                    $addedBy=$os->rowByField('','admin','adminId',$row['addedBy']);
                                    ?>


                                    <tr>



                                        <td><? echo $os->showDate($row['paidDate']); ?></td>
                                        <td><? echo (int)$row['amount_total']; ?></td>
                                        <td><? echo (int)$row['special_discount']; ?></td>
                                        <td><? echo (int)$row['paybleAmount']; ?></td>
                                        <td><? echo (int)$row['paidAmount']; ?></td>
                                        <td><? echo (int)$row['currentDueAmount']; ?></td>


                                        <td><div style="cursor:pointer; font-weight:bold"  onclick="print_receipt_fees(<? echo $row['fees_payment_id'] ?>)",''> <? echo $row['receipt_no']; ?> </div></td>
                                        <td style="font-size:10px;"><? echo $addedBy['name']; ?></td>
                                    </tr>

                                    <?
                                }?>
                                </tbody>
                                <tfoot>
                                <tr style="background:#DDFFBB;">
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> Total </td>
                                    <td><b><? echo (int)$total_paid; ?> </b> </td>
                                    <td> </td>


                                    <td> </td>
                                    <td> </td>
                                </tr>
                                </tfoot>

                            </table>
							
							<div style="padding:10px 0px 10px 2px;">
							<input type="button" value="Delete All Payment" onclick="delete_all_payment_by_history_id('<? echo $history_id ?>');" />
						    </div>
                        </li>
                    </ul>
                </div>

                <div style="width:30%">
                    <?
                    $due_total=0;
                    $student_fees_amounts=array();
                    if($selected_fees_row && $action!='generate_receipt')
                    {

                        $due_total=0;
                        $fees_details="select fees_student_id, totalPayble,paymentStatus from fees_student where fees_student_id  IN ( ".implode(',',$selected_fees_row)." )   ";
                        $fees_details_rs= $os->mq($fees_details);
                        while($fees_rec = $os->mfa($fees_details_rs))
                        {

                            $due_amt=calculate_due($fees_rec['fees_student_id'],$fees_rec['totalPayble'],$fees_rec['paymentStatus']);
                            $due_total=$due_total+$due_amt;
                            $student_fees_amounts[$fees_rec['fees_student_id']]=$due_amt.'-'.$fees_rec['paymentStatus'];

                        }




                        // _d($os->post());
                    }
					
					//_d($selected_fees_row);
					 
                    if($due_total>=0  && count($selected_fees_row)>0  && $action!='generate_receipt' )
                    {

                        $special_discount=$os->post('special_discount');
                        $special_discount_note=$os->post('special_discount_note');

                        $paid_fees_amount=(int)$os->post('paid_fees_amount');
                        $payble_total=(float)$due_total-(float)$special_discount;

                        $due_fees_amount= (float)$payble_total-(float)$paid_fees_amount;

                        $amount_total=$due_total;




                        ?>
                        <?
						
						 
                        foreach($student_fees_amounts as $prev_due_fees_student_id => $prev_due)
                        {
                            ?>

                            <input type="hidden" name="student_fees_amounts[<? echo $prev_due_fees_student_id; ?>]" value="<? echo $prev_due; ?>" />

                            <?
                        }

                        ?>


                        <table class="uk-table uk-table-small uk-table-divider uk-table-hover table_input_payment" style="font-size:12px;">
                            
							<? $wavedoff_data = unbilled_waved_off_data($selected_fees_row,$history_id);   ?>
							                                
							 <? if($wavedoff_data['total']>0 ){  ?>
							 
							  <tr>
                                <td >Billed Amount</td>
                                <td colspan="5"> 
								 
                                    <b > <?  echo $b= $wavedoff_data['total']+$amount_total; ?>    </b>
                                </td>
                            </tr>
							 <tr>
                                <td >Waived Off Amount</td>
                                <td colspan="5" > 
								 
                                    <b> <?  echo $wavedoff_data['total']; ?> </b>
									<? if(count($wavedoff_data['list_amount'])>1){ ?>
									 &nbsp;&nbsp;  ( <?  echo implode(' + ',$wavedoff_data['list_amount']); ?> )
									 <? } ?>
                                </td>
                            </tr>
							<? } ?>
							
							<tr style="display:none;">
                                <td >Total Amount</td>
                                <td colspan="5"> <b style="font-size:16px;"> <? echo $amount_total; ?> </b>
                                    <input style="border:0px;background:#FFFF88; font-size:18px;display:none; " type="text" name="amount_total"  value="<? echo $amount_total; ?>" />

                                </td>
                            </tr>
							
                           
						    <tr <? if(count($student_fees_amounts)!=1){ ?> <? } ?>  style="display:none;">
                                <td>Discount Amount</td>
                                <td  colspan="5">
                                    <input style=" width:60px;" <? if(count($student_fees_amounts)!=1){ ?>  <? } ?>readonly="readonly" type="text" name="special_discount" onchange="student_fees_collect('<? echo $history_id ?>','')" value="<? echo $special_discount; ?>" />
                                    Discount Note <input style="   " type="text" name="special_discount_note" onchange="student_fees_collect('<? echo $history_id ?>','')" value="<? echo $special_discount_note; ?>" />

                                </td>
                            </tr>
							
							
                            <tr>
                                <td style="width:120px;">Payble</td>
                                <td  colspan="5">
                                    <input readonly="" style=" display:none;" type="text" name="payble_total"  value="<? echo $payble_total; ?>" />
                                    <input readonly="" style="background:#FFFF88; color:#0000CC; font-size:16px;width:70px; font-weight:bold; " type="text"   value="<? echo $payble_total; ?>" />

                                </td>
                            </tr>
                            </tr>


                            <tr>
                                <td>Paid</td>
                                <td  colspan="5">  <input style="  background:#AAFFBF; font-size:16px;width:70px; " type="text" name="paid_fees_amount" id="paid_fees_amount" onchange="student_fees_collect('<? echo $history_id ?>','')" onkeypress="hideGenerateButton();" onfocus="hideGenerateButton();"  value="<? echo $paid_fees_amount; ?>" /> </td>
                            </tr>
                            <tr>
                                <td>Due</td>
                                <td  colspan="5"> <input readonly="readonly"   style="border:0px; font-size:18px;display:none; "  type="text" name="due_fees_amount" value="<? echo  $due_fees_amount ?>" />
                                    <input readonly="readonly"   style="border:0px; font-size:16px;width:65px; "  type="text" value="<? echo  $due_fees_amount ?>" />

                                    <? if($due_fees_amount>0)  // 0 if waved off amount
                                    {

                                        if(count($selected_fees_row)>0)
                                        {
                                            $fees_due_alloc="select  * from fees_student where fees_student_id  IN ( ".implode(',',$selected_fees_row)." ) order by year desc , month desc   ";
                                            $fees_due_alloc_rs= $os->mq($fees_due_alloc);


                                            ?> &nbsp;&nbsp; On &nbsp;
                                            <select name="due_on_fees_student_id"  style="background-color:#FFFFFF">

                                                <?

                                                while($fees_due_on = $os->mfa($fees_due_alloc_rs) ) {

                                                    $due_amt=calculate_due($fees_due_on['fees_student_id'],$fees_due_on['totalPayble'],$fees_due_on['paymentStatus']);
                                                    if($due_fees_amount <= $due_amt)

                                                    {
                                                        ?>
                                                        <option value="<? echo $fees_due_on['fees_student_id'] ?>">
                                                            <? echo $fees_due_on['feesType']; ?>-<? echo $os->feesMonth[$fees_due_on['month']]; ?>-<? echo $fees_due_on['year']; ?>-<? echo $due_amt; ?>
                                                        </option>
                                                        <?
                                                    }
                                                } ?>

                                            </select>
                                            <?
                                        }
                                    }
                                    ?>

                                </td>
                            </tr>
							<? 
							
							 $showform=false;
							
							if($payble_total == 0 && $paid_fees_amount == 0 ) // for web off 
							{
							  $showform=true;
							}
							
							if($payble_total > 0 && $paid_fees_amount > 0 )
							{
							  $showform=true;
							}
							
							
							
							if($showform==true && $due_fees_amount>=0){ ?>
                            
							<!-- landmark-fees-payment_fields -->
							
							<tr>
							 <td>Paid Date</td>
                               <td > 
							    <? if(trim($paidDate)==''){$paidDate=date('Y-m-d');} ?>
							   <input class="wtDateClass"   type="text" name="paidDate" id="paidDate"  value="<? echo $paidDate; ?>" placeholder="yyyy-mm-dd" /> 
							    </td>  <td > 
							   <span style="font-size:10px;" title="For back dated entry  change date."> <a uk-icon="info"> </a></span>
							   </td>
                            </tr>
							
							
							 
							 <tr>
							  <td>Payment Options </td>
                               <td >
							   <? if(trim($payment_options)==''){$payment_options='Cash';} ?>
							    <input   type="text" name="payment_options" id="payment_options" list="payment_options_data"  value="<? echo $payment_options; ?>" /> 
							   </td>  <td >  <span style="font-size:10px; line-height:6px;" title="Cash, Check, Online Transfer,Other . NB: Online Transfer included Paytm, PhonePe, GooglePay, Bank Transfer etc."><a uk-icon="info"> </a> </span>
							     
									
									<datalist id="payment_options_data">
									<option value="Cash">
									</option><option value="Check">
									</option><option value="Online Transfer">
									</option><option value="Other">
								 
									</option></datalist>
							   
							   
							   </td>
                            </tr>
							<tr>
							 <td>Payment Note </td>
                               <td > <input   type="text" name="paymentNote" id="paymentNote"  value="<? echo $paymentNote; ?>" />
							   
							   </td>  <td >  <span style="font-size:10px;" title="Here you can save payment reference no, transaction no cheque no etc. "><a uk-icon="info"> </a></span>
							    </td>
                            </tr>
							
							
							
							<tr>
							 <td>Remarks </td>
                               <td > <input   type="text" name="remarks" id="remarks"  value="<? echo $remarks; ?>" /> </td>
                            </tr>
							<tr>
							 <td>Receipt No</td>
                               <td > <input   type="text" name="receipt_no" id="receipt_no"  value="<? echo $receipt_no; ?>" />
							     </td>  <td > <span style="font-size:10px;" title="You can put receipt no manually , leave blank for auto generate."><a uk-icon="info"> </a> </span>
							    </td>
                            </tr>
							
							<tr>
                                <td> </td>
                                <td   >
								
								 
								
								 <input type="button" id="generateButton" style="cursor:pointer;  " value="Generate & Print Receipt" onclick="student_fees_collect('<? echo $history_id ?>','generate_receipt')" />    
								
								 
								  </td>  <td > <span style="font-size:10px;" title="Please check carefully before generate receipt."> <a uk-icon="info"> </a> </span>
							    </td>
								 </td>
                            </tr>
                            <? } ?>
                        </table>



                        <?



                    }else{
                        echo "<div class='Please_select_rows' ><a uk-icon='info'> </a>  Please select rows to generate bill and receipt </div>";

                    }
                    ?>
                </div>

            </div>
        </div>
    </div>


<style>
.Please_select_rows{ margin:20px; font-size:16px; color:#BB00BB; font-weight:bold;}
</style>



    <?  

echo '##-feeshtml-##'; 
echo '##-fees_payment_id-##'; echo $fees_payment_id; echo '##-fees_payment_id-##';

exit();
}


if($os->get('create_single_fees')=='OK')
{
    	 
    $historyId=$history_id=$os->post("historyId");
	$fees_for_amount=$os->post("fees_for_amount");
	$fees_for= $os->post("fees_for");
	$fees_for_date=$os->post("fees_for_date");
	$fees_for_date=trim($fees_for_date);
	
     if(trim($fees_for)!='' && $fees_for_amount>0 && $historyId>0)
     {
        create_single_fees_student($historyId,$fees_for,$fees_for_amount , $fees_for_date ); 
	 }
	
	 echo '##--historyId--##'; echo  $historyId; echo '##--historyId--##'; 
  exit();
}


if($os->get('delete_unpaid_fees_rows')=='OK')
{
    	 
    $historyId=$os->post("historyId");
	$fees_student_id=$os->post("fees_student_id");
	 
	$fees_student_data= $os->rowByField('','fees_student',$fld='fees_student_id',$fees_student_id,$where=" and historyId='$historyId' and paymentStatus='unpaid' ",$orderby='');
	
	if(isset($fees_student_data['fees_student_id']))
	{
		 
		 
		 
		 
		  $historyId=$fees_student_data['historyId'];
		  $fees_student_id = $fees_student_data['fees_student_id'];
		  
		  
		$edit_log_save=array();
        $edit_log_save['type']='delete_student_fess';
        $edit_log_save['table_name']='fees_student';
        $edit_log_save['table_id_value']=$fees_student_id;
        $edit_log_save['remarks']='DELETE';
        $edit_log_save['table_field']='row';
        $edit_log_save['old_val']=serialize($fees_student_data);
        $edit_log_save['new_val']='';
        $edit_log_save['addedDate']=$os->now();
        $edit_log_save['addedBy']=$os->userDetails['adminId'];
        $output=$os->save('edit_log',$edit_log_save,'edit_log','');
       
		  
		  // delete here waive off data
		  
			 $delete_fees_waiveoff_q="delete from fees_waiveoff    where    history_id='$historyId'   and   fees_student_id='$fees_student_id'  ";
			 $os->mq($delete_fees_waiveoff_q);
		  
		  
		  // if payment link  role back  fees data
		  
		  
		   $del_fees_student_delete_q=" delete from fees_student_details where fees_student_id='$fees_student_id' and historyId='$historyId' ";
		  $del_fees_student_q=" delete from fees_student where fees_student_id='$fees_student_id' and historyId='$historyId' ";
		 
	     $os->mq($del_fees_student_delete_q);
		 $os->mq($del_fees_student_q);
	  
	}
	 
	
	
	 echo '##--historyId--##'; echo  $historyId; echo '##--historyId--##'; 
  exit();
}

 if($os->get('create_fees_waiveoff')=='OK')
{
    	 
    $historyId=$os->post("historyId");
	$fees_student_id=$os->post("fees_student_id");
	$due_amt=$os->post("due_amt");
	$waive_amount=(int)$os->post("waive_amount");
	 
	 
	
	if($waive_amount>0 && $waive_amount <= $due_amt)
	{
		  
		  
		$data_to_save=array();
		$data_to_save['fees_student_id']=$fees_student_id;
		$data_to_save['waive_amount']=$waive_amount;             
		// $data_to_save['fees_payment_id______________']=$waive_amount; // updated while payment done
		$data_to_save['entry_date']=$os->now();
		$data_to_save['admin_id']=$os->userDetails['adminId'];
		$data_to_save['history_id']=$historyId; 
		
		$output=$os->save('fees_waiveoff',$data_to_save);
			  
	}
	 
	
	
	 echo '##--historyId--##'; echo  $historyId; echo '##--historyId--##'; 
  exit();
}


if($os->get('delete_all_payment_by_history_id')=='OK')
{
    	 
    $historyId=$os->post("historyId");   
	 
	$fees_payment_data= $os->rowsByField('','fees_payment',$fld='historyId',$historyId);
	$all_payment_data=array();
	$fees_payment_id_arr=array();
	while( $row = $os->mfa($fees_payment_data))
	{
	    $all_payment_data[$row['fees_payment_id']]= $row;
	   
	      $fees_payment_id_arr[$row['fees_payment_id']]=$row['fees_payment_id'];
	}
	 
	if( count($fees_payment_id_arr)>0 )
	{
	     
		$edit_log_save=array();
        $edit_log_save['type']='delete_fees_payment';
        $edit_log_save['table_name']='fees_payment';
        $edit_log_save['table_id_value']='';
        $edit_log_save['remarks']='DELETE all payment ';
        $edit_log_save['table_field']='all  related  historyid ='.$historyId;
        $edit_log_save['old_val']=serialize($all_payment_data);
        $edit_log_save['new_val']='';
        $edit_log_save['addedDate']=$os->now();
        $edit_log_save['addedBy']=$os->userDetails['adminId'];
        $output=$os->save('edit_log',$edit_log_save,'edit_log','');       
		  
		   $del_fees_payment_delete_q=" delete from fees_payment where  historyId='$historyId' ";
		   $update_fees_student_q=" update  fees_student set receipt_no='',currentDueAmount='', fees_payment_ids='' ,paymentStatus='unpaid'  where  historyId='$historyId' ";
		   $update_fees_waiveoff_q=" update  fees_waiveoff set fees_payment_id=''   where  history_id='$historyId' ";
		 
	       $os->mq($del_fees_payment_delete_q);
		   $os->mq($update_fees_student_q);
		  $os->mq($update_fees_waiveoff_q);
	  
	}
	 
	
	
	 echo '##--historyId--##'; echo  $historyId; echo '##--historyId--##'; 
  exit();
}

include($site['root-wtos'].'historyAjax_Helper.php');
