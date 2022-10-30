<?
/*
   # wtos version : 1.1
   # page called by ajax script in adminDataView.php
   #
*/
include('wtosConfigLocal.php');
global $site,$os;
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

$return_acc_details=$os->branch_access();
$and_branch_in="";
if($os->userDetails['adminType']!='Super Admin')
{
    $selected_branch_code=$os->getSession($key1='selected_branch_code');
    $and_branch_in=" and branch_code ".$return_acc_details['branches_code_IN']." and adminType!='Super Admin'";
}
$_BRANCHES = $os->get_branches();



function sanitize_key($key){
    $key = strtolower($key);
    $key = str_replace(" ","_", $key);
    $key = str_replace("-","_", $key);
    $key = str_replace("/","_", $key);
    $key = str_replace("\\","_", $key);

    return $key;
}
function generateMenuLevels($parent_id=0,$current_node='',$query_plus='')
{
    global $os;

    $query="select * from admin_menu where active_status ='Active' and parent_admin_menu_id='$parent_id'  $query_plus  order by view_order asc ";
    $rsResults=$os->mq( $query);
    while($record=$os->mfa( $rsResults))
    {
        $admin_menu_id=$record['admin_menu_id'];
        $parent_admin_menu_id=$record['parent_admin_menu_id'];

        $current_node[$parent_admin_menu_id]['nodes'][$admin_menu_id]=$record;
        generateMenuLevels($admin_menu_id,$current_node[$parent_admin_menu_id]['nodes'] , $query_plus);

    }

}
function populate_access_tree($menu, $branch,  $accesses=[], $user_second_level_access=[],  $parent=0, $level=-1){
    global $os, $site, $module_files;
    $level++;
    $prefix='';
    for($c=1; $c<=$level; $c++){
        $prefix .= "<span style='color:transparent'>_</span>|<span style='color:transparent'>-----</span>";
    }
    foreach ($menu[$parent] as $record){
        $admin_menu_id = $record['admin_menu_id'];
        ?>
        <tr>
            <td class="uk-table-shrink uk-text-nowrap" style="padding-left: 20px !important;">
                <?=$prefix?>
                <label class="bp3-control bp3-checkbox uk-display-inline">
                    <input value="<?= $record['access_key']?>"
                           type="checkbox"
                           name="branch_access[<?=$branch?>][]"
                           class="group_<?= sanitize_key($branch); ?> uk-checkbox access_checkbox"
                        <? if(in_array($record['access_key'] , $accesses)) { ?>
                            checked="checked"
                        <? } ?>/>
                    <span class="bp3-control-indicator"></span>
                    <?= $record['title']?>
                </label>

            </td>
            <td class="uk-table-shrink">
                <?
                $user_second_level_access_by_key = $os->val($user_second_level_access, $record['access_key'])?
                    $os->val($user_second_level_access, $record['access_key']):[];
                $second_level_access = $record["second_level_access"]?explode(",", $record["second_level_access"]):[];
                foreach ($second_level_access as $second_access){
                    ?>
                    <label class="bp3-control bp3-checkbox">
                        <input type="checkbox"
                               value="<?=$second_access?>"
                               class="second_level_access_checkbox"
                               name="second_level_branch_access[<?=$branch?>][<?= $record['access_key']?>][]"
                            <?=in_array($second_access, $user_second_level_access_by_key)?"checked":""?>/>
                        <span class="bp3-control-indicator"></span>
                        <?=$second_access?>
                    </label>
                <?}?>
            </td>

        </tr>
        <?
        if(isset($menu[$admin_menu_id])){
            populate_access_tree($menu, $branch, $accesses, $user_second_level_access, $admin_menu_id, $level);
        }
        ?>
        <?

    }
}
function populate_global_access_tree($menu, $user_global_accesses, $parent, $level){
    global $os, $site, $module_files;
    $level++;
    $prefix='';
    for($c=1; $c<=$level; $c++){
        $prefix .= "<span style='color:transparent'>_</span>|<span style='color:transparent'>-----</span>";
    }
    foreach ($menu[$parent] as $record){
        $admin_menu_id = $record['admin_menu_id'];
        ?>
        <tr>
            <td class="uk-table-shrink uk-text-nowrap" style="padding-left: 20px !important;">
                <?=$prefix?>
                <?= $record['title']?>
            </td>
            <td class="uk-table-shrink">
                <?
                $user_global_accesses_by_key = $os->val($user_global_accesses,$record['access_key'])?
                    $os->val($user_global_accesses,$record['access_key']):[];
                $global_accesses = @explode(",",$record["global_accesses"]);
                $global_accesses = $global_accesses?$global_accesses:[];
                foreach ($global_accesses as $global_access){
                    if(!$global_access){
                        continue;
                    }
                    ?>
                    <label class="bp3-control bp3-checkbox">
                        <input type="checkbox"
                               value="<?=$global_access?>"
                               class="global_access_checkbox"
                               name="global_accesses[<?= $record['access_key']?>][]"
                            <?=in_array($global_access, $user_global_accesses_by_key)?"checked":""?>/>
                        <span class="bp3-control-indicator"></span>
                        <?=$global_access?>
                    </label>
                <?} ?>
            </td>
        </tr>
        <?

        if(isset($menu[$admin_menu_id])){
            populate_global_access_tree($menu,  $user_global_accesses, $admin_menu_id, $level);
        }
    }
}
?><?
function sms_aam($smsText='',$smsNumber='')
{




    $smsText= urlencode(trim($smsText));
    if($smsNumber!='' && $smsText!=''){

        $url= "http://136.243.8.109/http-api.php?username=aamkhp&password=AAMkhp&senderid=AAMKHP&route=1&number=$smsNumber&message=$smsText";
        ?>
        <img src="<? echo $url ?>" style="display:none;"  />

        <?
    }


}
if($os->get('WT_adminListing')=='OK')
{
    $where='';
    $showPerPage= $os->post('showPerPage');
    $os->showPerPage=100;

    $andname=  $os->postAndQuery('name_s','name','%');
    $andadminType=  $os->postAndQuery('adminType_s','adminType','%');
    $andusername=  $os->postAndQuery('username_s','username','%');
    $andpassword=  $os->postAndQuery('password_s','password','%');
    $andaddress=  $os->postAndQuery('address_s','address','%');
    $andemail=  $os->postAndQuery('email_s','email','%');
    $andmobileNo=  $os->postAndQuery('mobileNo_s','mobileNo','%');
    $andactive=  $os->postAndQuery('active_s','active','%');
    $andaccess=  $os->postAndQuery('access_s','access','%');
    $andeditDeletePassword=  $os->postAndQuery('editDeletePassword_s','editDeletePassword','%');
    $andotp=  $os->postAndQuery('otp_s','otp','%');
    $anddriving_license=  $os->postAndQuery('driving_license_s','driving_license','%');
    $andidcard_details=  $os->postAndQuery('idcard_details_s','idcard_details','%');
    $andprovider_type=  $os->postAndQuery('provider_type_s','provider_type','%');
    $andprovider_name=  $os->postAndQuery('provider_name_s','provider_name','%');
    $andprovider_details=  $os->postAndQuery('provider_details_s','provider_details','%');
    $andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','=');

  // hide superadmin for other //

    $and_hide_superAdmin="  ";
    if($os->userDetails['adminType']!='Super Admin')
    {
	  $and_hide_superAdmin=" and  adminType!='Super Admin' ";
	}
  ///



  ///////////////////
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
     $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'];
}
/////////////////






    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( name like '%$searchKey%' Or adminType like '%$searchKey%' Or username like '%$searchKey%' Or password like '%$searchKey%' Or address like '%$searchKey%' Or email like '%$searchKey%' Or mobileNo like '%$searchKey%' Or active like '%$searchKey%' Or access like '%$searchKey%' Or editDeletePassword like '%$searchKey%' Or otp like '%$searchKey%' Or driving_license like '%$searchKey%' Or idcard_details like '%$searchKey%' Or provider_type like '%$searchKey%' Or provider_name like '%$searchKey%' Or provider_details like '%$searchKey%' Or branch_code like '%$searchKey%' )";

    }

    $listingQuery="  select * from admin where adminId>0  $and_hide_superAdmin   $where   $andname  $andadminType  $andusername  $andpassword  $andaddress  $andemail  $andmobileNo  $andactive  $andaccess  $andeditDeletePassword  $andotp  $anddriving_license  $andidcard_details  $andprovider_type  $andprovider_name  $andprovider_details  $andbranch_code $and_branch_in order by adminId desc";
    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];
    $os->setSession($listingQuery, 'listingQuery');

    ?>
    <div class="listingRecords">
        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
            <tr class="borderTitle" >
                <td> </td>
                <td >#</td>
                <td >Action</td>
                <td >Access</td>



                <td ><b>Name</b></td>
                <td ><b>Image</b></td>
                <td ><b>Type</b></td>
                <td ><b>Username</b></td>
                <td ><b>Password</b></td>


                <td ><b>MobileNo</b></td>
                <td ><b>Active Status</b></td>

                <td ><b>Branch</b></td>



            </tr>



            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;




                ?>
                <tr class="trListing">

                    <td><input type="checkbox" id="adminIdss" name="adminIds[]" value="<? echo $record['adminId'];?>" /> </td>
                    <td><?php echo $serial; ?>     </td>
                    <td class="uk-text-small uk-text-nowrap">
                        <? if($os->access('wtView')){ ?>
                            <a href="javascript:void(0)" onclick="WT_adminGetById('<? echo $record['adminId'];?>')" >Edit</a>
                        <? } ?>
                    </td>
                    <td class="uk-text-nowrap">
                        <a href="javascript:void(0);" onclick="manageAccessData_ajax('<? echo $record['adminId'];?>','','')" >Branch</a>
                        /
                        <a href="javascript:void(0);" onclick="manageGlobalAccessData_ajax('<? echo $record['adminId'];?>','','')" >Global</a>
                    </td>

                    <td><b><?php echo $record['name']?> </b></td>
                    <td>
                        <? if ($record['image']!='') { ?>
                            <img src="<?php  echo $site['url'].$record['image']; ?>"  height="75" width="100" />
                        <? } ?>
                        <? if ($record['signature']!='') { ?>
                            <img src="<?php  echo $site['url'].$record['signature']; ?>"  width="100"  />
                        <? } ?>
                    </td>
                    <td> <b><? if(isset($os->adminType[$record['adminType']])){ echo  $os->adminType[$record['adminType']]; } ?> </b><br />
					<span style="color:#999999">(<?php echo $record['designation']?> ) </span>

					</td>
                    <td><?php echo $record['username']?> </td>
                    <td><?php echo $record['password']?> </td>


                    <td><?php echo $record['mobileNo']?> </td>
                    <td> <? if(isset($os->adminActive[$record['active']])){ echo  $os->adminActive[$record['active']]; } ?></td>

                      <td>



					      <?php  echo $branch_code_arr[$record['branch_code']]; ?>

						 <br />
						 <input type="text" style="border:none; width:80px;color:#33CC00; font-weight:bold; " value="<?  echo  $record['branch_code'];  ?>" id="edit_branch_code<?  echo $record['adminId']; ?>"
                               onchange="wtosInlineEdit('edit_branch_code<?  echo $record['adminId']; ?>','admin','branch_code','adminId','<?  echo $record['adminId']; ?>','','','WT_adminListing()');" />




						</td>



                </tr>
                <?


            } ?>





        </table>



    </div>

    <br />



    <?php
    exit();

}

if($os->get('WT_adminEditAndSave')=='OK')
{
    $adminId=$os->post('adminId');



    $dataToSave['name']=addslashes($os->post('name'));

    $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
    if($image!=''){
        $dataToSave['image']='wtos-images/'.$image;}



    $dataToSave['adminType']=addslashes($os->post('adminType'));
    $dataToSave['username']=addslashes($os->post('username'));
    $dataToSave['password']=addslashes($os->post('password'));
    $dataToSave['address']=addslashes($os->post('address'));
    $dataToSave['email']=addslashes($os->post('email'));
    $dataToSave['mobileNo']=addslashes($os->post('mobileNo'));
    $dataToSave['active']=addslashes($os->post('active'));
    $dataToSave['access']=addslashes($os->post('access'));
    $dataToSave['editDeletePassword']=addslashes($os->post('editDeletePassword'));
    $dataToSave['otp']=addslashes($os->post('otp'));
    $dataToSave['joinDate']=$os->saveDate($os->post('joinDate'));
    $dataToSave['driving_license']=addslashes($os->post('driving_license'));
    $dataToSave['idcard_details']=addslashes($os->post('idcard_details'));
    $dataToSave['provider_type']=addslashes($os->post('provider_type'));
    $dataToSave['provider_name']=addslashes($os->post('provider_name'));
    $dataToSave['provider_details']=addslashes($os->post('provider_details'));
    $dataToSave['branch_code']=addslashes($os->post('branch_code'));



    $signature=$os->UploadPhoto('signature',$site['root'].'wtos-images');
    if($signature!=''){
        $dataToSave['signature']='wtos-images/'.$signature;}




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($adminId < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('admin',$dataToSave,'adminId',$adminId);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($adminId>0 ){ $mgs= " Data updated Successfully";}
        if($adminId<1 ){ $mgs= " Data Added Successfully"; $adminId=  $qResult;}

        $mgs=$adminId."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_adminGetById')=='OK')
{
    $adminId=$os->post('adminId');

    if($adminId>0)
    {
        $wheres=" where adminId='$adminId'";
    }
    $dataQuery=" select * from admin  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['name']=$record['name'];
    if($record['image']!=''){
        $record['image']=$site['url'].$record['image'];
    }



    $record['adminType']=$record['adminType'];
    $record['username']=$record['username'];
    $record['password']=$record['password'];
    $record['address']=$record['address'];
    $record['email']=$record['email'];
    $record['mobileNo']=$record['mobileNo'];
    $record['active']=$record['active'];
    $record['access']=$record['access'];
    $record['editDeletePassword']=$record['editDeletePassword'];
    $record['otp']=$record['otp'];
    $record['joinDate']=$os->showDate($record['joinDate']);
    $record['driving_license']=$record['driving_license'];
    $record['idcard_details']=$record['idcard_details'];
    $record['provider_type']=$record['provider_type'];
    $record['provider_name']=$record['provider_name'];
    $record['provider_details']=$record['provider_details'];
    $record['branch_code']=$record['branch_code'];
    if($record['signature']!=''){
        $record['signature']=$site['url'].$record['signature'];
    }


    echo  json_encode($record);

    exit();

}

if($os->get('WT_adminDeleteRowById')=='OK')
{

    $adminId=$os->post('adminId');
    if($adminId>0){
        $updateQuery="delete from admin where adminId='$adminId'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

if($os->get('manageAccessData_ajax')=='OK' && $os->post('manageAccessData_ajax')=='OK')
{

    $wt_action=$os->post('wt_action');
    $adminId=$os->post('adminId');

    $admin=$os->rowByField($getfld='',$tables='admin',$fld='adminId',$fldVal=$adminId,$where='',$orderby='');

    $data_access= @json_encode($os->post('branch_access'));
    $second_level_branch_access= @json_encode($os->post('second_level_branch_access'));
    $dataToSave=array();
    $dataToSave['access']=$data_access;
    $dataToSave['second_level_access']=$second_level_branch_access;
    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];
    if($wt_action=='save')
    {
        $qResult=$os->save('admin',$dataToSave,'adminId',$adminId);///    allowed char '\*#@/"~$^.,()|+_-=:��
        print $os->query;
        $admin=$os->rowByField($getfld='',$tables='admin',$fld='adminId',$fldVal=$adminId,$where='',$orderby='');

    }

    echo '##--manageAccessData_data_form--##';


    $menu = get_menu();
    $user_access = (array)@json_decode($admin['access']);
    $user_second_level_access = (array)@json_decode(stripslashes($admin['second_level_access']));

    ?>
    <button class="uk-modal-close-default" type="button" uk-close></button>

    <div class="uk-grid-collapse" uk-grid style="height: 100vh">
        <div class="uk-width-medium uk-overflow-auto" style="height: 100vh">
            <ul class="uk-subnav uk-subnav-pill access-nav" uk-tab="connect: #my-id">
                <?
                $bc=0;
                foreach ($menu as $branch=>$menus){
                    $bc++;
                    ?>
                    <li class="uk-display-block uk-width-1-1">
                        <a class="<?= isset($user_access[$branch])?'uk-text-secondary ':''?>
                        uk-text-left" style="text-transform: unset">
                            <?=$bc.". ".$_BRANCHES[$branch]['branch_name']?>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </div>
        <div class="uk-width-expand">
            <div class="uk-card uk-card-default uk-card-small" style="height: 100vh">
                <ul id="my-id" class="uk-switcher">
                    <? foreach ($menu as $branch=>$menus){?>
                        <li>


                            <div class="uk-card-header">
                                <h3 class="uk-modal-title " style="font-size: 14px">
                                    <b style="color: blue"><?= $_BRANCHES[$branch]["branch_name"] ?></b> access for <b> <? echo $admin['name']; ?> </b></h3>
                            </div>
                            <div class="uk-overflow-auto" style="height: calc(100vh - 100px)">
                                <table class="uk-table congested-table uk-table-striped">
                                    <thead>
                                    <tr>
                                        <th style="padding-left: 20px !important;">
                                            <input type="checkbox" class="uk-checkbox"
                                                   onclick="select_deselect_all('group_<?= sanitize_key($branch); ?>',this)" />
                                            Access Name
                                        </th>
                                        <th>Second Level Access</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    $uaccess = isset($user_access[$branch])?$user_access[$branch]:[];
                                    $user_second_level = isset($user_second_level_access[$branch])?(array)$user_second_level_access[$branch]:[];
                                    populate_access_tree($menus, $branch,  $uaccess,  $user_second_level,0, -1); ?>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                    <? } ?>
                </ul>

                <div class="uk-card-footer">
                    <button type="button"
                            class="uk-button congested-form uk-button-primary uk-border-rounded uk-modal-close"
                            onclick="manageAccessData_ajax('<? echo $adminId ?>','save') "
                            value=" Save Access " style="cursor:pointer" >Save Access</button>
                </div>

            </div>
        </div>
        <style>
            .access-nav > li.uk-active a{
                color: white !important;
            }
        </style>
    </div>
    <?

    echo '##--manageAccessData_data_form--##';
    echo '##--manageAccessData_data_list--##';
    echo '##--manageAccessData_data_list--##';

    exit();
}

if($os->get('manageGlobalAccessData_ajax')=='OK' && $os->post('manageGlobalAccessData_ajax')=='OK')
{

    $wt_action=$os->post('wt_action');
    $adminId=$os->post('adminId');

    $admin=$os->rowByField($getfld='',$tables='admin',$fld='adminId',$fldVal=$adminId,$where='',$orderby='');

    $global_accesses= @json_encode($os->post('global_accesses'));
    $dataToSave=array();
    $dataToSave['global_accesses']=$global_accesses;
    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];
    if($wt_action=='save')
    {
        $qResult=$os->save('admin',$dataToSave,'adminId',$adminId);///    allowed char '\*#@/"~$^.,()|+_-=:��
        print $os->query;
        $admin=$os->rowByField($getfld='',$tables='admin',$fld='adminId',$fldVal=$adminId,$where='',$orderby='');

    }

    echo '##--manageAccessData_data_form--##';


    $menus = get_menu("all");
    $user_global_accesses = (array)@json_decode($admin['global_accesses']);
    ?>
    <button class="uk-modal-close-default" type="button" uk-close></button>

    <div class="uk-grid-collapse" uk-grid style="height: 100vh">
        <div class="uk-width-expand">
            <div class="uk-card uk-card-default uk-card-small" style="height: 100vh">


                <div class="uk-card-header">
                    <h3 class="uk-modal-title " style="font-size: 14px">
                        Global access for <b> <? echo $admin['name']; ?> </b></h3>
                </div>
                <div class="uk-overflow-auto" style="height: calc(100vh - 100px)">
                    <table class="uk-table congested-table uk-table-striped">
                        <thead>
                        <tr>
                            <th style="padding-left: 20px !important;">
                               Access Name
                            </th>
                            <th>Global Access</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $user_global_accesses = $user_global_accesses?(array)$user_global_accesses:[];
                        populate_global_access_tree($menus,  $user_global_accesses,0, -1); ?>
                        </tbody>
                    </table>
                </div>
                <div class="uk-card-footer">
                    <button type="button"
                            class="uk-button congested-form uk-button-primary uk-border-rounded uk-modal-close"
                            onclick="manageGlobalAccessData_ajax('<? echo $adminId ?>','save') "
                            value=" Save Access " style="cursor:pointer" >Save Access</button>
                </div>

            </div>
        </div>
    </div>
    <?

    echo '##--manageAccessData_data_form--##';
    echo '##--manageAccessData_data_list--##';
    echo '##--manageAccessData_data_list--##';

    exit();
}

if($os->post('staff_data_entry_direct')=='OK' && $os->get('confirm_staff_excel_upload')=='OK')
{
    function trim_slashes($data)
    {

        return trim(addslashes($data));
    }



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
                    //_d($xFile);

                    //	exit();

                    if($key==0){continue;}
                    $mobileNo=str_replace(' ','',$xFile[2]);
                    if($mobileNo!='' && $xFile[0]!='')
                    {

                        $xFile[2]=str_replace(' ','',$xFile[2]); // mobile no

                        $dataToSave['name']=trim_slashes($xFile[0]);

                        $dataToSave['username']=trim_slashes($xFile[2]);
                        $dataToSave['password']=rand(1000,9999);
                        $dataToSave['address']=trim_slashes($xFile[12]).trim_slashes($xFile[13]).trim_slashes($xFile[14]).trim_slashes($xFile[15]);
                        $dataToSave['email']=trim_slashes($xFile[7]);
                        $dataToSave['mobileNo']=trim_slashes($xFile[2]);
                        $dataToSave['adminType']='Asistant Teacher';


                        $dataToSave['addedDate']=$os->now();
                        $dataToSave['active']='Active';
                        $dataToSave['addedBy']=$os->userDetails['adminId'];;
                        $dataToSave['modifyBy']=$os->userDetails['adminId'];
                        $dataToSave['modifyDate']=$os->now();

                        $dataToSave['joinDate']=trim_slashes($xFile[19]);
                        $dataToSave['driving_license']=trim_slashes($xFile[20]);
                        $dataToSave['idcard_details']=trim_slashes($xFile[9]);

                        $dataToSave['branch_code']=trim_slashes($xFile[3]);
                        $dataToSave['residential']=trim_slashes($xFile[1]);
                        $dataToSave['department']=trim_slashes($xFile[4]);
                        $dataToSave['designation']=trim_slashes($xFile[5]);
                        $dataToSave['employee_code']=trim_slashes($xFile[6]);
                        $dataToSave['id_card']=trim_slashes($xFile[8]);
                        $dataToSave['id_card_no']=trim_slashes($xFile[9]);
                        $dataToSave['gender']=trim_slashes($xFile[10]);
                        $dataToSave['caste']=trim_slashes($xFile[11]);




                        $dataToSave['vill_street']=trim_slashes($xFile[12]);
                        $dataToSave['po']=trim_slashes($xFile[13]);
                        $dataToSave['ps']=trim_slashes($xFile[14]);
                        $dataToSave['district']=trim_slashes($xFile[15]);
                        $dataToSave['block']=trim_slashes($xFile[16]);
                        $dataToSave['state']=trim_slashes($xFile[17]);
                        $dataToSave['pin']=trim_slashes($xFile[18]);
                        $dataToSave['blood_group']=trim_slashes($xFile[21]);
                        $dataToSave['under_payroll']=trim_slashes($xFile[22]);

                        $name=$dataToSave['name'];
                        $branch_code=$dataToSave['branch_code'];
                        $mobileNo=$dataToSave['mobileNo'];


                        if($name!='' && $name!='Name of the Teacher' && $branch_code!='' &&  $mobileNo!='' )
                        {
                            $adminId= $os->rowByField('adminId','admin','mobileNo',$fldVal=$mobileNo,$where=" and name='$name' and  branch_code='$branch_code' ",$orderby='');



                            if($adminId>0)  // ignore fields if exist
                            {
                                unset($dataToSave['password']);
                                unset($dataToSave['addedDate']);

                            }


                            $Id_updated=$os->save('admin',$dataToSave,'adminId',$adminId);
                            // echo $os->query; echo '<br>';
                            if($Id_updated){
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

if($os->post('send_sms_function_admin')=='OK' && $os->get('send_sms_function_admin')=='OK')
{

    $send_sms_confirm=false;


    $adminIds=$os->post('checked_adminIds');
    $sms_body_template=$os->post('sms_body_template');
    $sms_body_template=trim($sms_body_template);
    $listingQuery=$os->getSession('listingQuery');


    if(trim($adminIds)!='')
    {
        $adminIds=$adminIds.'999999999';
        $stq=" select * from admin  where adminId IN($adminIds)    ";
        $i=0;
        $stq_rs= $os->mq( $stq);
        while($admind=$os->mfa($stq_rs))
        {
            if($sms_body_template!='')
            {
                $mobileNo =$admind['mobileNo'];
                $username=$admind['username'];
                $password=$admind['password'];


                $smsText=str_replace('{{password}}',$password,$sms_body_template);
                $smsText=str_replace('{{username}}',$username,$smsText);
                $smsResult='';

                //$mobileNo=8017477871;
                $smsResult= 	 sms_aam($smsText,$smsNumber=$mobileNo);

                ## save sms

                $dataToSave_sms['mobileno']=$mobileNo;
                $dataToSave_sms['msg']=$smsText;
                $dataToSave_sms['addedDate']= $os->now();
                $dataToSave_sms['msgDate']=$os->now();
                $dataToSave_sms['msgStatus']=$smsResult;
                $dataToSave_sms['addedBy']=$os->userDetails['adminId'];
                $qResult=$os->save('smshistory',$dataToSave_sms);
                $i++;
                echo  " $i ) U =$username  M= $mobileNo  SMS =  $smsText  <br>  ";

            }





        }

    }else
    {




        $i=0;
        $stq_rs= $os->mq( $listingQuery);
        while($record=$os->mfa($stq_rs))
        {

            if($sms_body_template!='')
            {
                $mobileNo =$record['mobileNo'];
                $username=$record['username'];
                $password=$record['password'];


                $smsText=str_replace('{{password}}',$password,$sms_body_template);
                $smsText=str_replace('{{username}}',$username,$smsText);
                $smsResult='';


                //$smsNumber=8017477871;


                $smsResult= 	 sms_aam($smsText,$smsNumber=$mobileNo);

                ## save sms

                $dataToSave_sms['mobileno']=$mobileNo;
                $dataToSave_sms['msg']=$smsText;
                $dataToSave_sms['addedDate']= $os->now();
                $dataToSave_sms['msgDate']=$os->now();
                $dataToSave_sms['msgStatus']=$smsResult;
                $dataToSave_sms['addedBy']=$os->userDetails['adminId'];
                $qResult=$os->save('smshistory',$dataToSave_sms);
                $i++;
                echo  " $i ) U =$username  M= $mobileNo  SMS =  $smsText  <br>  ";

            }


        }


    }




    exit();




}

if($os->get('WT_adminupdatepassAndSave')=='OK')
{
  $recent_password  = $os->post('recent_password');
  $new_password  = $os->post('new_password');
   $adminId = $os->userDetails['adminId'];
 
  $dataQuery=" select * from admin  where adminId='$adminId' and  password='$recent_password' ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);
    $adminId=$record['adminId'];
   
	if($recent_password=='')
	{
	?> <div style="color:#FF0000;"> Please enter  recent  password </div><? 
	 exit();
	}
	
	
	if($new_password=='')
	{
	
	?> <div style="color:#FF0000; "> Please enter   new  password </div><? 
	 exit();
	}
	
	
	
	
	if($adminId>0 )
	{
     
					$dataToSave=array();
					$dataToSave['password']=$new_password;    
					$adminId=$os->save('admin',$dataToSave,'adminId',$adminId);///    allowed char '\*#@/"~$^.,()|+_-=:��
					if($adminId)
					{
						  $mgs= '<div style="color:#00CC00;">' . "  Data updated Successfully. New password set to ".$new_password.' </div>';
						   
							$edit_log_save=array();
							$edit_log_save['type']='change_admin_password';
							$edit_log_save['table_name']='admin';
							$edit_log_save['table_id_value']=$adminId;
							$edit_log_save['remarks']='set new password';
							$edit_log_save['table_field']='password';
							$edit_log_save['old_val']=$recent_password;
							$edit_log_save['new_val']=$new_password;
							$edit_log_save['addedDate']=$os->now();
							$edit_log_save['addedBy']=$os->userDetails['adminId'];
							$output=$os->save('edit_log',$edit_log_save,'edit_log','');
						
						
						
					}
					else
					{
						$mgs='<div style="color:#FF0000;">'." Problem Saving Data.".'</div>';
				
					}
					
	}else{
	
	 
	        $mgs= ' <div style="color:#FF0000;"> Please enter correct recent  password </div>';
	 
	 }
	
	
   
    echo $mgs;

    exit();

}


