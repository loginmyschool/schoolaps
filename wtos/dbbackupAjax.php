<?
/*
   # wtos version : 1.1
   # page called by ajax script in dbbackupDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
global $os, $site;
include "../dbBackupHelper.php";
$backup_path = $_SERVER["DOCUMENT_ROOT"]."/backup_db_wtos/";
$backup_path_virtual = $site["server"].str_replace("studentfees/","", $site["folder"])."backup_db_wtos/";
$helperTwo = new dbbackupHelper(
    array(
        "host" => $site["host"],
        "port" => $site["port"],
        "user" => $site["user"],
        "pass" => $site["pass"],
        "db" => $site["db"],
        //"path" => $backup_path ,
    )
);
?><?

if($os->get('WT_dbbackupFileListing')=='OK')
{
    $manual_list = $helperTwo->listing("manual");
    $auto_list = $helperTwo->listing("auto");
    ?>
    <div>
        <div class="uk-card uk-card-small uk-card-default">
            <div class="uk-card-header">
                <div class="title uk-inline">
                    <h3>Manual Backups</h3>
                </div>
                <a class="uk-float-right" onclick="WT_dbbackup_do_backup()">
                    <span>Take Backup</span>
                </a>

            </div>
            <div class="uk-overflow-auto" style="height: 300px">
                <table class="uk-table uk-table-small uk-table-divider uk-table-striped uk-margin-remove">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>File Name</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?

                    $count =0;
                    foreach ($manual_list as $backup){
                        $count++;
                        ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><?= $backup['file'] ?></td>
                                <td><?= $backup['type']; ?></td>
                                <td><?= $backup['date'] ?></td>
                                <td nowrap><?=$backup['time']?></td>
                                <td class="right" nowrap>
                                    <button class="material-button"
                                            onclick="location.href  = '<?= $backup['href']?>'">
                                        <i class="la la-cloud-download-alt"></i>
                                    </button>
                                    <button class="material-button"
                                            onclick="if(confirm('Are you sure?')){WT_dbbackup_do_restore('<?= $backup['file']; ?>')}">
                                        <i class="la la-cloud-upload-alt"></i>
                                    </button>
                                </td>
                            </tr>


                            <?

                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        <div class="uk-card uk-card-small uk-card-default">
            <div class="uk-card-header">
                <div class="title">
                    <h3>Auto Backups</h3>
                </div>

            </div>
            <div class="uk-overflow-auto" style="height: 300px">
                <table class="uk-table uk-table-small uk-table-divider uk-table-striped uk-margin-remove">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>File Name</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?
                    if(file_exists($backup_path.$site["db"])){
                        $backups = array_diff(scandir($backup_path.$site["db"], SCANDIR_SORT_DESCENDING ), array('.', '..'));
                    } else {
                        $backups = array();
                    }

                    $count =0;
                    foreach ($backups as $backup){
                        list($db, $type, $stamp) = explode("-", $backup);
                        if($type == "auto" || $type =="Auto") {
                            $count++;
                            $file_info = pathinfo($backup_path . $site["db"] . "/" . $backup);
                            ?>
                            <tr>
                                <td><? echo $count; ?></td>
                                <td><? echo $backup ?></td>
                                <td class="color-primary"><? echo ucfirst($type); ?></td>
                                <td><? echo gmdate("d/m/Y", $stamp); ?></td>
                                <td nowrap><? echo gmdate("g:i:s A", $stamp); ?></td>
                                <td class="right" nowrap>
                                    <button class="material-button"
                                            onclick="location.href  = '<? echo $backup_path_virtual . $site["db"] . "/" . $backup; ?>'">
                                        <i class="la la-cloud-download-alt"></i>
                                    </button>
                                    <button class="material-button"
                                            onclick="if(confirm('Are you sure?')){WT_dbbackup_do_restore('<? echo $backup; ?>')}">
                                        <i class="la la-cloud-upload-alt"></i>
                                    </button>
                                </td>
                            </tr>


                            <?
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    exit();
}

if($os->get('WT_dbbackupGetById')=='OK')
{
    $dbbackup_id=$os->post('dbbackup_id');

    if($dbbackup_id>0)
    {
        $wheres=" where dbbackup_id='$dbbackup_id'";
    }
    $dataQuery=" select * from dbbackup  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['file_name']=$record['file_name'];
    $record['type']=$record['type'];
    $record['import_date']=$os->showDate($record['import_date']);
    $record['import_by']=$record['import_by'];
    $record['export_date']=$os->showDate($record['export_date']);
    $record['export_by']=$record['export_by'];



    echo  json_encode($record);

    exit();

}

if($os->get('WT_dbbackup_do_backup')=='OK'&&$os->post('WT_dbbackup_do_backup')=='OK')
{

    $time_instance = new DateTime();
    $time = $time_instance->getTimestamp();
    $file_name = $site["db"]."-manual-".$time;

    $record_sql = "INSERT INTO dbbackup 
                        (type, 
                        export_date, 
                        export_by, 
                        file_name)

                        VALUES(
                            'Manual',
                            '".$os->now()."',
                            '".$os->userDetails['adminId']."',
                            '$file_name'
                        )";
    $os->mq($record_sql);
    $dump_file =  $helperTwo->backup('manual');
    /***************
     * delete record
     */
    if($dump_file) {
        print "Successfully take backup";
    } else {
        print "Ops! something went wrong";
    }
}

if($os->get('WT_dbbackup_do_restore')=='OK'&&$os->post('WT_dbbackup_do_restore')=='OK')
{
    $file_name = $os->post("file_name");
    $isBackup = $helperTwo->restore($file_name);
}

