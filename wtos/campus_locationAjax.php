<?
/*
   # wtos version : 1.1
   # page called by ajax script in campus_locationDataView.php
   #
*/
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
$branches = $os->get_branches_by_access_name("Campus");

?><?

if($os->get('WT_campus_locationListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andcampus_location_id=  $os->postAndQuery('campus_location_id_s','campus_location_id','%');
    $andcampus_name=  $os->postAndQuery('campus_name_s','campus_name','%');
    $andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
    $andcampus_type=  $os->postAndQuery('campus_type_s','campus_type','%');
    $andnote=  $os->postAndQuery('note_s','note','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( campus_location_id like '%$searchKey%' Or campus_name like '%$searchKey%' Or branch_code like '%$searchKey%' Or campus_type like '%$searchKey%' Or note like '%$searchKey%' )";

    }

     $listingQuery="  select campus_location.*, branch.branch_name from campus_location 
    INNER JOIN branch  ON campus_location.branch_code=branch.branch_code
    where campus_location_id>0   $where   $andcampus_location_id  $andcampus_name  $andbranch_code  $andcampus_type  $andnote     order by campus_location_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>
    <div class="listingRecords">
        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
            <tr class="borderTitle" >

                <td >#</td>
                <td >Action </td>



                <td class="uk-hidden"><b>campus_location_id</b></td>
                <td ><b>Campus Name</b></td>
                <td ><b>Branch</b></td>
                <td ><b>Campus Type</b></td>
                <td ><b>note</b></td>



            </tr>



            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;




                ?>
                <tr class="trListing">
                    <td><?php echo $serial; ?>     </td>
                    <td>
                        <? if($os->access('wtView')){ ?>
                            <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_campus_locationGetById('<? echo $record['campus_location_id'];?>')" >Edit</a></span>  <? } ?>  </td>

                    <td class="uk-hidden"><?php echo $record['campus_location_id']?> </td>
                    <td><?php echo $record['campus_name']?> </td>
                    <td>  <?=$record['branch_name'] ?></td>
                    <td> <? if(isset($os->campus_type[$record['campus_type']])){ echo  $os->campus_type[$record['campus_type']]; } ?></td>
                    <td><?php echo $record['note']?> </td>


                </tr>
                <?


            } ?>





        </table>



    </div>

    <br />



    <?php
    exit();

}






if($os->get('WT_campus_locationEditAndSave')=='OK')
{
    $campus_location_id=$os->post('campus_location_id');



    $dataToSave['campus_name']=addslashes($os->post('campus_name'));
    $dataToSave['branch_code']=addslashes($os->post('branch_code'));
    $dataToSave['campus_type']=addslashes($os->post('campus_type'));
    $dataToSave['note']=addslashes($os->post('note'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($campus_location_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('campus_location',$dataToSave,'campus_location_id',$campus_location_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($campus_location_id>0 ){ $mgs= " Data updated Successfully";}
        if($campus_location_id<1 ){ $mgs= " Data Added Successfully"; $campus_location_id=  $qResult;}

        $mgs=$campus_location_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_campus_locationGetById')=='OK')
{
    $campus_location_id=$os->post('campus_location_id');

    if($campus_location_id>0)
    {
        $wheres=" where campus_location_id='$campus_location_id'";
    }
    $dataQuery=" select * from campus_location  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['campus_name']=$record['campus_name'];
    $record['branch_code']=$record['branch_code'];
    $record['campus_type']=$record['campus_type'];
    $record['note']=$record['note'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_campus_locationDeleteRowById')=='OK')
{

    $campus_location_id=$os->post('campus_location_id');
    if($campus_location_id>0){
        $updateQuery="delete from campus_location where campus_location_id='$campus_location_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

