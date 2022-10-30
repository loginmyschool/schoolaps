<?
/*
   # wtos version : 1.1
   # main ajax process page : dbbackupAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Data Backup';
$ajaxFilePath= 'dbbackupAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">

        </div>
    </div>

</div>
<div class="content">
    <!-----------
    Main contents
    --------------->
    <div class="item">
        <div class="p-m">
            <div id="backup-list" class="uk-grid uk-grid-small uk-child-width-1-2@m" uk-grid></div>
        </div>
        <div id="log_list" style="display: none">

            <div class="p-m">
                <input type="text" id="searchKey" />
                <input type="text" class="wtTextClass" name="file_name_s" id="file_name_s" value="" />
                <select name="type" id="type_s" class="textbox fWidth" ><option value="">Select Backup Type</option>	<?
                    $os->onlyOption($os->backup_type);	?>
                </select>
                <input class="wtDateClass" type="text" name="f_import_date_s" id="f_import_date_s" value=""  />
                <input class="wtDateClass" type="text" name="t_import_date_s" id="t_import_date_s" value=""  />
                <input type="text" class="wtTextClass" name="import_by_s" id="import_by_s" value="" />
                <input class="wtDateClass" type="text" name="f_export_date_s" id="f_export_date_s" value=""  />
                <input class="wtDateClass" type="text" name="t_export_date_s" id="t_export_date_s" value=""  />
                <input type="text" class="wtTextClass" name="export_by_s" id="export_by_s" value="" />
                <button class="material-button" onclick="WT_dbbackupListing();"><span>Search</span></button>
                <button class="material-button" onclick="searchReset();"><span>Reset</span></button>

                <div class="display-none">

                    <div class="formDivButton">
                        <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_dbbackupDeleteRowById('');" /><? } ?>
                        &nbsp;&nbsp;
                        &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                        &nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_dbbackupEditAndSave();" /><? } ?>

                    </div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

                        <tr >
                            <td>File Name </td>
                            <td><input value="" type="text" name="file_name" id="file_name" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Backup Type </td>
                            <td>

                                <select name="type" id="type" class="textbox fWidth" ><option value="">Select Backup Type</option>	<?
                                    $os->onlyOption($os->backup_type);	?></select>	 </td>
                        </tr><tr >
                            <td>Import Date </td>
                            <td><input value="" type="text" name="import_date" id="import_date" class="wtDateClass textbox fWidth"/></td>
                        </tr><tr >
                            <td>Import By </td>
                            <td><input value="" type="text" name="import_by" id="import_by" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>EXport Date </td>
                            <td><input value="" type="text" name="export_date" id="export_date" class="wtDateClass textbox fWidth"/></td>
                        </tr><tr >
                            <td>Export By </td>
                            <td><input value="" type="text" name="export_by" id="export_by" class="textboxxx  fWidth "/> </td>
                        </tr>


                    </table>


                    <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                    <input type="hidden"  id="dbbackup_id" value="0" />
                    <input type="hidden"  id="WT_dbbackuppagingPageno" value="1" />
                    <div class="formDivButton">
                        <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_dbbackupDeleteRowById('');" />	<? } ?>
                        &nbsp;&nbsp;
                        &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                        &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_dbbackupEditAndSave();" /><? } ?>
                    </div>
                </div>
            </div>

            <div  id="WT_dbbackupListDiv"> </div>

        </div>
    </div>
</div>

<script>


    function WT_dbbackupFileListing() // list table searched data get
    {
        var formdata = new FormData();
        var url='wtpage='+WT_dbbackuppagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_dbbackupFileListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('backup-list',url,formdata);

    }

    WT_dbbackupFileListing();

    ///extended version
    function WT_dbbackup_do_backup()  // collect data and send to save
    {

        let formdata = new FormData();

        formdata.append('WT_dbbackup_do_backup','OK' );

        var   dbbackup_id=os.getVal('dbbackup_id');
        formdata.append('dbbackup_id',dbbackup_id );
        var url='<? echo $ajaxFilePath ?>?WT_dbbackup_do_backup=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_dbbackup_do_manual_callback',url,formdata);

    }

    function WT_dbbackup_do_manual_callback(res){
        alert(res);
        WT_dbbackupFileListing();
        WT_dbbackupListing();
    }

    function WT_dbbackup_do_restore(file_name) {
        let formdata = new FormData();

        formdata.append('WT_dbbackup_do_restore','OK' );
        formdata.append('file_name', file_name);

        var url='<? echo $ajaxFilePath ?>?WT_dbbackup_do_restore=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_dbbackup_do_restore_callback',url,formdata);
    }

    function WT_dbbackup_do_restore_callback(res){
        alert(res);
        WT_dbbackupFileListing();
        WT_dbbackupListing();
    }






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
