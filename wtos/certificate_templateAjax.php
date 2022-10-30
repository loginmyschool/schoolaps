<?
/*
   # wtos version : 1.1
   # page called by ajax script in certificate_templateDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);



?><?

if($os->get('WT_certificate_templateListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andtext_content=  $os->postAndQuery('text_content_s','text_content','%');
    $andcontent_type=  $os->postAndQuery('content_type_s','content_type','%');
    $andtype=  $os->postAndQuery('type_s','type','%');
    $andstatus=  $os->postAndQuery('status_s','status','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( text_content like '%$searchKey%' Or content_type like '%$searchKey%' Or type like '%$searchKey%' Or status like '%$searchKey%' )";

    }

    $listingQuery="  select * from certificate_template where certificate_template_id>0   $where   $andtext_content  $andcontent_type  $andtype  $andstatus     order by certificate_template_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>

    <div class="p-m">
        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
        <table class="uk-table uk-table-striped uk-table-hover congested-table background-color-white">
            <thead>
            <tr >

                <th >#</th>
                <th >Action </th>



               <!-- <th nowrap="">Text Content</th>-->
                <th nowrap="">Content Type</th>
                <th>Type</th>
                <th>Status</th>



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
                    <td>
                        <? if($os->access('wtView')){ ?>
                            <span  class="actionLink" >
                                <a href="javascript:void(0)"  onclick="WT_certificate_templateGetById('<? echo $record['certificate_template_id'];?>')" >Edit</a>
                            </span>
                        <? } ?>
                    </td>

                   <!-- <td><?php echo $record['text_content']?> </td>-->
                    <td class="nowrap"> <? if(isset($os->certificate_content_type[$record['content_type']])){ echo  $os->certificate_content_type[$record['content_type']]; } ?></td>
                    <td class="nowrap"> <? if(isset($os->certificate_type[$record['type']])){ echo  $os->certificate_type[$record['type']]; } ?></td>
                    <td class="nowrap"> <? if(isset($os->activeStatus[$record['status']])){ echo  $os->activeStatus[$record['status']]; } ?></td>


                </tr>
                <?


            } ?>
            </tbody>
        </table>
    </div>

    <?php
    exit();

}






if($os->get('WT_certificate_templateEditAndSave')=='OK')
{
    $certificate_template_id=$os->post('certificate_template_id');



    $dataToSave['text_content']=addslashes($os->post('text_content'));
    $dataToSave['content_type']=addslashes($os->post('content_type'));
    $dataToSave['type']=addslashes($os->post('type'));
    $dataToSave['status']=addslashes($os->post('status'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($certificate_template_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('certificate_template',$dataToSave,'certificate_template_id',$certificate_template_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($certificate_template_id>0 ){ $mgs= " Data updated Successfully";}
        if($certificate_template_id<1 ){ $mgs= " Data Added Successfully"; $certificate_template_id=  $qResult;}

        $mgs=$certificate_template_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_certificate_templateGetById')=='OK')
{
    $certificate_template_id=$os->post('certificate_template_id');

    if($certificate_template_id>0)
    {
        $wheres=" where certificate_template_id='$certificate_template_id'";
    }
    $dataQuery=" select * from certificate_template  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['text_content']=$record['text_content'];
    $record['content_type']=$record['content_type'];
    $record['type']=$record['type'];
    $record['status']=$record['status'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_certificate_templateDeleteRowById')=='OK')
{

    $certificate_template_id=$os->post('certificate_template_id');
    if($certificate_template_id>0){
        $updateQuery="delete from certificate_template where certificate_template_id='$certificate_template_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

