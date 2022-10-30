<?
/*
   # wtos version : 1.1
   # page called by ajax script in otherpaymentDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_otherpaymentListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $anduser_id=  $os->postAndQuery('user_id_s','user_id','%');
    $andpaid_to=  $os->postAndQuery('paid_to_s','paid_to','%');
    $andpaid_amt=  $os->postAndQuery('paid_amt_s','paid_amt','%');

    $f_paid_date_s= $os->post('f_paid_date_s'); $t_paid_date_s= $os->post('t_paid_date_s');
    $andpaid_date=$os->DateQ('paid_date',$f_paid_date_s,$t_paid_date_s,$sTime='00:00:00',$eTime='59:59:59');
    $andpayment_note=  $os->postAndQuery('payment_note_s','payment_note','%');
    $andpayment_mode=  $os->postAndQuery('payment_mode_s','payment_mode','%');
    $andpayment_details=  $os->postAndQuery('payment_details_s','payment_details','%');
    $andpayment_ref_no=  $os->postAndQuery('payment_ref_no_s','payment_ref_no','%');
    $andpayment_type=  $os->postAndQuery('payment_type_s','payment_type','%');
    $andactive_status=  $os->postAndQuery('active_status_s','active_status','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( user_id like '%$searchKey%' Or paid_to like '%$searchKey%' Or paid_amt like '%$searchKey%' Or payment_note like '%$searchKey%' Or payment_mode like '%$searchKey%' Or payment_details like '%$searchKey%' Or payment_ref_no like '%$searchKey%' Or payment_type like '%$searchKey%' Or active_status like '%$searchKey%' )";

    }

    $listingQuery="  select * from otherpayment where otherpaymentId>0   $where   $anduser_id  $andpaid_to  $andpaid_amt  $andpaid_date  $andpayment_note  $andpayment_mode  $andpayment_details  $andpayment_ref_no  $andpayment_type  $andactive_status     order by otherpaymentId desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>

        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table class="uk-table uk-table-small uk-table-striped background-color-white">
            <thead>
            <tr>

                <th >#</th>
                <th >Action </th>



                <th>User</th>
                <th>Paid to</th>
                <th>Paid amt</th>
                <th>Paid date</th>
                <th>Payment note</th>
                <th>Payment mode</th>
                <th>Payment details</th>
                <th>Payment ref no</th>
                <th>Payment type</th>
                <th>Status</th>



            </tr>
            </thead>
            <tbody>




            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;




                ?>
                <tr class="trListing">
                    <td><?php echo $serial; ?>     </td>
                    <td>
                        <? if($os->access('wtView')){ ?>
                            <a class="uk-button uk-border-rounded uk-theme-button congested-form" href="javascript:void(0)"  onclick="WT_otherpaymentGetById('<? echo $record['otherpaymentId'];?>')" >Edit</a>
                        <? } ?>
                    </td>

                    <td><?php echo $record['user_id']?> </td>
                    <td><?php echo $record['paid_to']?> </td>
                    <td><?php echo $record['paid_amt']?> </td>
                    <td><?php echo $os->showDate($record['paid_date']);?> </td>
                    <td><?php echo $record['payment_note']?> </td>
                    <td> <? if(isset($os->paymentethod[$record['payment_mode']])){ echo  $os->paymentethod[$record['payment_mode']]; } ?></td>
                    <td><?php echo $record['payment_details']?> </td>
                    <td><?php echo $record['payment_ref_no']?> </td>
                    <td> <? if(isset($os->othersPaymentType[$record['payment_type']])){ echo  $os->othersPaymentType[$record['payment_type']]; } ?></td>
                    <td> <? if(isset($os->activeStatus[$record['active_status']])){ echo  $os->activeStatus[$record['active_status']]; } ?></td>


                </tr>
                <?


            } ?>

            </tbody>



        </table>



    <?php
    exit();

}






if($os->get('WT_otherpaymentEditAndSave')=='OK')
{
    $otherpaymentId=$os->post('otherpaymentId');



    $dataToSave['user_id']=addslashes($os->post('user_id'));
    $dataToSave['paid_to']=addslashes($os->post('paid_to'));
    $dataToSave['paid_amt']=addslashes($os->post('paid_amt'));
    $dataToSave['paid_date']=$os->saveDate($os->post('paid_date'));
    $dataToSave['payment_note']=addslashes($os->post('payment_note'));
    $dataToSave['payment_mode']=addslashes($os->post('payment_mode'));
    $dataToSave['payment_details']=addslashes($os->post('payment_details'));
    $dataToSave['payment_ref_no']=addslashes($os->post('payment_ref_no'));
    $dataToSave['payment_type']=addslashes($os->post('payment_type'));
    $dataToSave['active_status']=addslashes($os->post('active_status'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($otherpaymentId < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('otherpayment',$dataToSave,'otherpaymentId',$otherpaymentId);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($otherpaymentId>0 ){ $mgs= " Data updated Successfully";}
        if($otherpaymentId<1 ){ $mgs= " Data Added Successfully"; $otherpaymentId=  $qResult;}

        $mgs=$otherpaymentId."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_otherpaymentGetById')=='OK')
{
    $otherpaymentId=$os->post('otherpaymentId');

    if($otherpaymentId>0)
    {
        $wheres=" where otherpaymentId='$otherpaymentId'";
    }
    $dataQuery=" select * from otherpayment  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['user_id']=$record['user_id'];
    $record['paid_to']=$record['paid_to'];
    $record['paid_amt']=$record['paid_amt'];
    $record['paid_date']=$os->showDate($record['paid_date']);
    $record['payment_note']=$record['payment_note'];
    $record['payment_mode']=$record['payment_mode'];
    $record['payment_details']=$record['payment_details'];
    $record['payment_ref_no']=$record['payment_ref_no'];
    $record['payment_type']=$record['payment_type'];
    $record['active_status']=$record['active_status'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_otherpaymentDeleteRowById')=='OK')
{

    $otherpaymentId=$os->post('otherpaymentId');
    if($otherpaymentId>0){
        $updateQuery="delete from otherpayment where otherpaymentId='$otherpaymentId'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

