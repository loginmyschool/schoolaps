<?
/*
   # wtos version : 1.1
   # page called by ajax script in branch_signatory_authority.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_branch_signatory_authorityListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andadminId=  $os->postAndQuery('adminId_s','bsa.adminId','%');
    $andbranch_code=  $os->postAndQuery('branch_code_s','bsa.branch_code','%');
    $andclass=  $os->postAndQuery('class_s','bsa.class','%');
    $andgender=  $os->postAndQuery('gender_s','bsa.gender','%');
    $andhead_key=  $os->postAndQuery('head_key_s','bsa.head_key','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( bsa.adminId like '%$searchKey%' Or bsa.branch_code like '%$searchKey%' Or bsa.class like '%$searchKey%' Or bsa.gender like '%$searchKey%' Or bsa.head_key like '%$searchKey%' )";

    }

    $listingQuery="  select bsa.*, a.name admin_name, b.branch_name from branch_signatory_authority bsa 
        INNER  JOIN admin a on bsa.adminId = a.adminId
        INNER JOIN branch b on a.branch_code = b.branch_code
  
    where bsa.branch_signatory_authority_id>0   $where   $andadminId  $andbranch_code  $andclass  $andgender  $andhead_key     order by bsa.branch_signatory_authority_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>
    <div class="listingRecords">
        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
            <tr class="borderTitle" >

                <td >#</td>
                <td >Action </td>



                <td ><b>Admin</b></td>
                <td ><b>Branch</b></td>
                <td ><b>Class</b></td>
                <td ><b>Gender</b></td>
                <td ><b>Key</b></td>



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
                            <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_branch_signatory_authorityGetById('<? echo $record['branch_signatory_authority_id'];?>')" >Edit</a></span>  <? } ?>  </td>

                    <td><?php echo $record['admin_name']?> </td>
                    <td> <?echo $record['branch_name'];  ?></td>
                    <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td>
                    <td> <? if(isset($os->gender[$record['gender']])){ echo  $os->gender[$record['gender']]; } ?></td>
                    <td> <? if(isset($os->signatory_authority_keys[$record['head_key']])){ echo  $os->signatory_authority_keys[$record['head_key']]; } ?></td>


                </tr>
                <?


            } ?>





        </table>



    </div>

    <br />



    <?php
    exit();

}






if($os->get('WT_branch_signatory_authorityEditAndSave')=='OK')
{
    $branch_signatory_authority_id=$os->post('branch_signatory_authority_id');



    $dataToSave['adminId']=addslashes($os->post('adminId'));
    $dataToSave['branch_code']=addslashes($os->post('branch_code'));
    $dataToSave['class']=addslashes($os->post('class'));
    $dataToSave['gender']=addslashes($os->post('gender'));
    $dataToSave['head_key']=addslashes($os->post('head_key'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($branch_signatory_authority_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('branch_signatory_authority',$dataToSave,'branch_signatory_authority_id',$branch_signatory_authority_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($branch_signatory_authority_id>0 ){ $mgs= " Data updated Successfully";}
        if($branch_signatory_authority_id<1 ){ $mgs= " Data Added Successfully"; $branch_signatory_authority_id=  $qResult;}

        $mgs=$branch_signatory_authority_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_branch_signatory_authorityGetById')=='OK')
{
    $branch_signatory_authority_id=$os->post('branch_signatory_authority_id');

    if($branch_signatory_authority_id>0)
    {
        $wheres=" where branch_signatory_authority_id='$branch_signatory_authority_id'";
    }
    $dataQuery=" select * from branch_signatory_authority  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['adminId']=$record['adminId'];
    $record['branch_code']=$record['branch_code'];
    $record['class']=$record['class'];
    $record['gender']=$record['gender'];
    $record['head_key']=$record['head_key'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_branch_signatory_authorityDeleteRowById')=='OK')
{

    $branch_signatory_authority_id=$os->post('branch_signatory_authority_id');
    if($branch_signatory_authority_id>0){
        $updateQuery="delete from branch_signatory_authority where branch_signatory_authority_id='$branch_signatory_authority_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

