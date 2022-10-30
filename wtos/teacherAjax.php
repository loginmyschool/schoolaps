<?
/*
   # wtos version : 1.1
   # page called by ajax script in teacherDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_teacherListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andname=  $os->postAndQuery('name_s','name','%');

    $f_joinDate_s= $os->post('f_joinDate_s'); $t_joinDate_s= $os->post('t_joinDate_s');
    $andjoinDate=$os->DateQ('joinDate',$f_joinDate_s,$t_joinDate_s,$sTime='00:00:00',$eTime='59:59:59');
    $andpermanentAddress=  $os->postAndQuery('permanentAddress_s','permanentAddress','%');
    $andrecentAddress=  $os->postAndQuery('recentAddress_s','recentAddress','%');
    $andmobile=  $os->postAndQuery('mobile_s','mobile','%');
    $andemail=  $os->postAndQuery('email_s','email','%');
    $andnote=  $os->postAndQuery('note_s','note','%');
    $andotpPass=  $os->postAndQuery('otpPass_s','otpPass','%');
    $andspecialization=  $os->postAndQuery('specialization_s','specialization','%');
    $andstatus=  $os->postAndQuery('status_s','status','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( name like '%$searchKey%' Or permanentAddress like '%$searchKey%' Or recentAddress like '%$searchKey%' Or mobile like '%$searchKey%' Or email like '%$searchKey%' Or note like '%$searchKey%' Or otpPass like '%$searchKey%' Or specialization like '%$searchKey%' Or status like '%$searchKey%' )";

    }

    $listingQuery="  select * from teacher where teacherId>0   $where   $andname  $andjoinDate  $andpermanentAddress  $andrecentAddress  $andmobile  $andemail  $andnote  $andotpPass  $andspecialization  $andstatus     order by teacherId desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];
    $os->setSession($listingQuery, 'downloadTeacherExcel');


    ?>

    <div class="material-card-layout">
            <div class="material-card-layout-header p-m">
                <h3 class="p-m">
                    Total:<? echo $os->val($resource,'totalRec'); ?>
                </h3>  &nbsp;&nbsp;
                <? echo $resource['links']; ?>

                <ul class="actions">
                    <li class="p-m">
                        <a>
                            <span>EXPORT</span>
                        </a>
                        <ul>
                            <?
                            foreach($os->teacherExcelA AS $dbFieldName=>$excelColName) {?>
                                <li>
                                    <a>
                                        <div class="material-checkbox dense">
                                            <input type="checkbox" name="columnName[]" id="<?echo $dbFieldName;?>_ex"  value="<? echo $dbFieldName; ?>"   />
                                            <label for="<?echo $dbFieldName;?>_ex"><? echo $excelColName; ?></label>
                                        </div>

                                    </a>
                                </li>
                            <?} ?>
                            <li onclick="excelDownload()">
                                <button class="material-button dense">Export</button>

                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="material-card-layout-content for-table">
                <table>
                    <thead>
                    <tr>
                        <th >#</th>
                        <th >Name</th>
                        <th >Image</th>
                        <th >Join Date</th>
                        <th >Permanent Address</th>
                        <th >Recent Address</th>
                        <th >Mobile</th>
                        <th >Email</th>
                        <th >Note</th>
                        <th >OTP Pass</th>
                        <th >type</th>

                        <th >Driving License</th>  
                        <th >Idcard Details</th>  
                        <th >Provider Type</th>  
                        <th >Provider Name</th>  
                        <th >Provider Details</th>
                        <th >Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $serial=$os->val($resource,'serial');

                    while($record=$os->mfa( $rsRecords)){
                        $serial++;
                        ?>
                        <tr>
                            <td><?php echo $serial; ?>     </td>

                            <td nowrap="true"><a class="color-flat-green" onclick="<? if($os->access('wtView')){ ?>WT_teacherGetById('<? echo $record['teacherId'];?>')<? } ?> "><?php echo $record['name']?> </a></td>
                            <td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td> 
                            <td nowrap="true"><?php echo $os->showDate($record['joinDate']);?> </td>
                            <td><?php echo $record['permanentAddress']?> </td>
                            <td><?php echo $record['recentAddress']?> </td>
                            <td><?php echo $record['mobile']?> </td>
                            <td><?php echo $record['email']?> </td>
                            <td><?php echo $record['note']?> </td>
                            <td><?php echo $record['otpPass']?> </td>
                            <td><?php echo $record['type']?> </td>
                            <td><img src="<?php  echo $site['url'].$record['driving_license']; ?>"  height="70" width="70" /></td>  
                            <td><?php echo $record['idcard_details']?> </td>  
                            <td> <? if(isset($os->provider_type[$record['provider_type']])){ echo  $os->provider_type[$record['provider_type']]; } ?></td> 
                            <td><?php echo $record['provider_name']?> </td>  
                            <td><?php echo $record['provider_details']?> </td>
                            <td> <? if(isset($os->teacherStatus[$record['status']])){ echo  $os->teacherStatus[$record['status']]; } ?></td>


                        </tr>
                        <?


                    } ?>
                    </tbody>




                </table>

            </div>




        </div>
    <?php
    exit();

}






if($os->get('WT_teacherEditAndSave')=='OK')
{
    $teacherId=$os->post('teacherId');



    $dataToSave['name']=addslashes($os->post('name'));
    $dataToSave['joinDate']=$os->saveDate($os->post('joinDate'));
    $dataToSave['permanentAddress']=addslashes($os->post('permanentAddress'));
    $dataToSave['recentAddress']=addslashes($os->post('recentAddress'));
    $dataToSave['mobile']=addslashes($os->post('mobile'));
    $dataToSave['email']=addslashes($os->post('email'));
    $dataToSave['note']=addslashes($os->post('note'));
    $dataToSave['otpPass']=addslashes($os->post('otpPass'));
    $dataToSave['specialization']=addslashes($os->post('specialization'));
    $dataToSave['status']=addslashes($os->post('status'));
    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];
	$dataToSave['type']=addslashes($os->post('type'));

    $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
                    if($image!=''){
                    $dataToSave['image']='wtos-images/'.$image;}



    $driving_license=$os->UploadPhoto('driving_license',$site['root'].'wtos-images');
    if($driving_license!=''){
    $dataToSave['driving_license']='wtos-images/'.$driving_license;}
    $dataToSave['idcard_details']=addslashes($os->post('idcard_details')); 
    $dataToSave['provider_type']=addslashes($os->post('provider_type')); 
    $dataToSave['provider_name']=addslashes($os->post('provider_name')); 
    $dataToSave['provider_details']=addslashes($os->post('provider_details')); 
     

    if($teacherId < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('teacher',$dataToSave,'teacherId',$teacherId);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($teacherId>0 ){ $mgs= " Data updated Successfully";}
        if($teacherId<1 ){ $mgs= " Data Added Successfully"; $teacherId=  $qResult;
		
		if($teacherId)
		{  // sync data // + create admin //
		
				
			global $site,$bridge;	
			//added to admin 
			
			$dataToSave_t['name']=$dataToSave['name']; 
			$dataToSave_t['adminType']=$dataToSave['type']; 
			$dataToSave_t['username']=$dataToSave['mobile']; 
			$dataToSave_t['password']=$dataToSave['otpPass']; 
			$dataToSave_t['address']=$dataToSave['recentAddress']; 
			$dataToSave_t['email']=$dataToSave['email']; 
			$dataToSave_t['mobileNo']=$dataToSave['mobile'];  
			$dataToSave_t['editDeletePassword']='123'; 																																			
			$dataToSave_t['active']='Active';
			$dataToSave_t['access'] = 'Settings,Quention Paper,Result Entry,E-Class,Attendance,Student Attendence';
			$dataToSave_t['addedDate']=$os->now();
			$dataToSave_t['addedBy']=$os->userDetails['adminId'];
			$os->saveTable('admin',$dataToSave_t,'adminId',''); 
			
			//sync			
			$school_setting_data= $os->school_setting();
			
			 
			$data_sync['school_name']=addslashes($school_setting_data['school_name']); 
			$data_sync['school_address']=addslashes($school_setting_data['address']); 
			$data_sync['schoolCode']=$school_setting_data['schoolCode'];
			$data_sync['school_id']=$school_setting_data['school_id'];
			$data_sync['name']=$dataToSave['name']; 
			$data_sync['mobile']=$dataToSave['mobile']; 
			$data_sync['login_username']=$dataToSave['mobile']; 
			$data_sync['login_password']=$dataToSave['otpPass'];
			$data_sync['action']='addNewTeacher_sync';
			$data_sync['teacherId']=$teacherId;
			$data_sync['table']='teacher';
			$data_sync['memberType']=$dataToSave['type'];
			$data_sync['addedBy']=$dataToSave['addedBy'];
			$data_sync['database_single']=$site['db'];
			$outputsync=$bridge->sync_portal_and_single('portal',$data_sync);
         }
		
		
		}

        $mgs=$teacherId."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_teacherGetById')=='OK')
{
    $teacherId=$os->post('teacherId');

    if($teacherId>0)
    {
        $wheres=" where teacherId='$teacherId'";
    }
    $dataQuery=" select * from teacher  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['name']=$record['name'];
    $record['joinDate']=$os->showDate($record['joinDate']);
    $record['permanentAddress']=$record['permanentAddress'];
    $record['recentAddress']=$record['recentAddress'];
    $record['mobile']=$record['mobile'];
    $record['email']=$record['email'];
    $record['note']=$record['note'];
    $record['otpPass']=$record['otpPass'];
    $record['specialization']=$record['specialization'];
    $record['status']=$record['status'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_teacherDeleteRowById')=='OK')
{

    $teacherId=$os->post('teacherId');
    if($teacherId>0){
        $updateQuery="delete from teacher where teacherId='$teacherId'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

