<?
/*
   # wtos version : 1.1
   # page called by ajax script in admin_menuDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$os->admin_menu_active_status=array ('Active' => 'Active','Inactive' => 'Inactive');
$os->only_super_admin= array ('Yes' => 'Yes', 'No' => 'No' );


$modules = array_filter(scandir(__DIR__), function($item) {

    if(is_dir(__DIR__ . $item)){
        return false;
    }
    if(!pathinfo(__DIR__.$item, PATHINFO_EXTENSION)=="php"){
        return false;
    }

    return true;
});
$module_files=[];
foreach ($modules as $module){
    $module_files[$module] = $module;
}

///populate_files
function populate_table($menu, $parent=0, $serial=0, $level=-1){
    global $os, $site, $module_files;
    $level++;
    foreach ($menu[$parent] as $record){
        $admin_menu_id = $record['admin_menu_id'];
        $serial++;
        ?>
        <tr class="trListing" >
            <td ><?php echo $serial; $serial++; ?></td>
            <td>
                <? if($os->access('wtView')){ ?>
                    <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_admin_menuGetById('<? echo $record['admin_menu_id'];?>')" >Edit</a></span>  <? } ?>
            </td>

            <td nowrap="" title="<?php echo $record['title']?>">
                <span>
                    <?
                    for($x=0; $x<$level; $x++){
                        echo "---";
                    }
                    ?>
                </span>
                <?php echo $record['access_key']?>
            </td>

            <td>
                <input id="page_name_<? echo $record['admin_menu_id'];?>"
                       list="datalist_name_<? echo $record['admin_menu_id'];?>"
                       value="<?=$record['page_name']?>"
                       class="uk-input congested-form uk-border-rounded"
                       onchange="wtosInlineEdit('page_name_<? echo $record['admin_menu_id'];?>','admin_menu','page_name','admin_menu_id','<? echo $record['admin_menu_id'];?>','','','');">
                <datalist id="datalist_name_<? echo $record['admin_menu_id'];?>">
                    <? $os->onlyOption($module_files, $record['page_name'])?>
                </datalist>
            </td>
            <td> <? if(isset($os->admin_menu_active_status[$record['active_status']])){ echo  $os->admin_menu_active_status[$record['active_status']]; } ?></td>


            <td>
                <?
                if ($record['parent_admin_menu_id']) {
                    echo $os->rowByField('title', 'admin_menu', 'admin_menu_id', $record['parent_admin_menu_id']);
                }
                ?>
            </td>
            <td class="uk-table-shrink">
                <input  type="text"
                        class="uk-input congested-form uk-border-rounded"
                        value="<?php echo $record['view_order']?>"
                        id="view_order_<? echo $record['admin_menu_id'];?>" onchange="wtosInlineEdit('view_order_<? echo $record['admin_menu_id'];?>','admin_menu','view_order','admin_menu_id','<? echo $record['admin_menu_id'];?>','','','');"
            </td>

            </td>
            <td>
                <select id="only_super_admin_<? echo $record['admin_menu_id'];?>"
                        class="uk-select congested-form uk-border-rounded"
                        onchange="wtosInlineEdit('only_super_admin_<? echo $record['admin_menu_id'];?>','admin_menu','only_super_admin','admin_menu_id','<? echo $record['admin_menu_id'];?>','','','');">
                    <? $os->onlyOption($os->yesno, $record['only_super_admin'])?>
                </select>

            </td>
            <td>
                <select id="class_required_<? echo $record['admin_menu_id'];?>"
                        class="uk-select congested-form uk-border-rounded"
                        onchange="wtosInlineEdit('class_required_<? echo $record['admin_menu_id'];?>','admin_menu','class_required','admin_menu_id','<? echo $record['admin_menu_id'];?>','','','');">
                    <? $os->onlyOption($os->yesno, $record['class_required'])?>
                </select>
            </td>
            <td>
                <select id="gender_required_<? echo $record['admin_menu_id'];?>"
                        class="uk-select congested-form uk-border-rounded"
                        onchange="wtosInlineEdit('gender_required_<? echo $record['admin_menu_id'];?>','admin_menu','gender_required','admin_menu_id','<? echo $record['admin_menu_id'];?>','','','');">
                    <? $os->onlyOption($os->yesno, $record['gender_required'])?>
                </select>
            </td>
            <td>
                <textarea class=" uk-text-small"
                          id="second_level_access_<? echo $record['admin_menu_id'];?>"
                          onchange="wtosInlineEdit('second_level_access_<? echo $record['admin_menu_id'];?>','admin_menu','second_level_access','admin_menu_id','<? echo $record['admin_menu_id'];?>','','','');"
                          type=""><? echo $record['second_level_access'];?></textarea>

                <textarea class=" uk-text-small"
                          id="global_accesses_<? echo $record['admin_menu_id'];?>"
                          onchange="wtosInlineEdit('global_accesses_<? echo $record['admin_menu_id'];?>','admin_menu','global_accesses','admin_menu_id','<? echo $record['admin_menu_id'];?>','','','');"
                          type=""><? echo $record['global_accesses'];?></textarea>
            </td>
        </tr>
        <?
        if(isset($menu[$admin_menu_id])){
            populate_table($menu, $admin_menu_id, $serial, $level);
        }
    }
}


?><?

if($os->get('WT_admin_menuListing')=='OK')

{



    $where='';
    $showPerPage= $os->post('showPerPage');


    $andaccess_key=  $os->postAndQuery('access_key_s','access_key','%');
    $andtitle=  $os->postAndQuery('title_s','title','%');
    $andpage_name=  $os->postAndQuery('page_name_s','page_name','%');
    $andactive_status=  $os->postAndQuery('active_status_s','active_status','%');
    $andicon_small_class=  $os->postAndQuery('icon_small_class_s','icon_small_class','%');
    $andicon_big_class=  $os->postAndQuery('icon_big_class_s','icon_big_class','%');
    $andparent_admin_menu_id=  $os->postAndQuery('parent_admin_menu_id_s','parent_admin_menu_id','=');
    $andview_order=  $os->postAndQuery('view_order_s','view_order','%');
    $andonly_super_admin=  $os->postAndQuery('only_super_admin_s','only_super_admin','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( access_key like '%$searchKey%' Or title like '%$searchKey%' Or page_name like '%$searchKey%' Or active_status like '%$searchKey%' Or icon_small_class like '%$searchKey%' Or icon_big_class like '%$searchKey%' Or parent_admin_menu_id like '%$searchKey%' Or view_order like '%$searchKey%' Or only_super_admin like '%$searchKey%' )";

    }

    $listingQuery="  select * from admin_menu where admin_menu_id>0   $where   $andaccess_key  $andtitle  $andpage_name  $andactive_status  $andicon_small_class  $andicon_big_class  $andparent_admin_menu_id  $andview_order  $andonly_super_admin     order by admin_menu_id desc";
    $os->showPerPage=1000;
    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];

    $menu = [];

    while($record=$os->mfa( $rsRecords)){
        $menu[$record['parent_admin_menu_id']][$record['admin_menu_id']] = $record;
    }





    ?>
    <div class="listingRecords">
        <!--<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>-->

        <table class="uk-table congested-table uk-table-striped"  style="background-color:#fff8017477871 ">
            <thead>
            <tr>

                <th>#</th>
                <th>Action </th>
                <th>Access Key</th>
                <th>Page Name</th>
                <th>Status</th>
                <th>Parent</th>
                <th>Order</th>
                <th>Super Admin</th>
                <th>Class</th>
                <th>Gender</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?
            populate_table($menu,0,0,-1);
            ?>
        </table>
    </div>

    <br />



    <?php
    exit();

}

if($os->get('WT_admin_menuEditAndSave')=='OK')
{
    $admin_menu_id=$os->post('admin_menu_id');



    $dataToSave['access_key']=addslashes($os->post('access_key'));
    $dataToSave['title']=addslashes($os->post('title'));
    $dataToSave['page_name']=addslashes($os->post('page_name'));
    $dataToSave['active_status']=addslashes($os->post('active_status'));
    $dataToSave['icon_small_class']=addslashes($os->post('icon_small_class'));
    $icon_small_image=$os->UploadPhoto('icon_small_image',$site['root'].'wtos-images');
    if($icon_small_image!=''){
        $dataToSave['icon_small_image']='wtos-images/'.$icon_small_image;}
    $dataToSave['icon_big_class']=addslashes($os->post('icon_big_class'));
    $icon_big_image=$os->UploadPhoto('icon_big_image',$site['root'].'wtos-images');
    if($icon_big_image!=''){
        $dataToSave['icon_big_image']='wtos-images/'.$icon_big_image;}
    $dataToSave['parent_admin_menu_id']=addslashes($os->post('parent_admin_menu_id'));
    $dataToSave['view_order']=addslashes($os->post('view_order'));
    $dataToSave['only_super_admin']=addslashes($os->post('only_super_admin'));




    //$dataToSave['modifyDate']=$os->now();
    //$dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($admin_menu_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('admin_menu',$dataToSave,'admin_menu_id',$admin_menu_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($admin_menu_id>0 ){ $mgs= " Data updated Successfully";}
        if($admin_menu_id<1 ){ $mgs= " Data Added Successfully"; $admin_menu_id=  $qResult;}

        $mgs=$admin_menu_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_admin_menuGetById')=='OK')
{
    $admin_menu_id=$os->post('admin_menu_id');

    if($admin_menu_id>0)
    {
        $wheres=" where admin_menu_id='$admin_menu_id'";
    }
    $dataQuery=" select * from admin_menu  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['access_key']=$record['access_key'];
    $record['title']=$record['title'];
    $record['page_name']=$record['page_name'];
    $record['active_status']=$record['active_status'];
    $record['icon_small_class']=$record['icon_small_class'];
    if($record['icon_small_image']!=''){
        $record['icon_small_image']=$site['url'].$record['icon_small_image'];}
    $record['icon_big_class']=$record['icon_big_class'];
    if($record['icon_big_image']!=''){
        $record['icon_big_image']=$site['url'].$record['icon_big_image'];}
    $record['parent_admin_menu_id']=$record['parent_admin_menu_id'];
    $record['view_order']=$record['view_order'];
    $record['only_super_admin']=$record['only_super_admin'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_admin_menuDeleteRowById')=='OK')
{

    $admin_menu_id=$os->post('admin_menu_id');
    if($admin_menu_id>0){
        $updateQuery="delete from admin_menu where admin_menu_id='$admin_menu_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

