<?php
include('../wtosConfig.php');
include('os.php'); 
if($os->get('WT_expense_list_detailsListing')=='OK'){
    $listingQuery="select exL.expense_list_id,exL.dated,exL.reference_no,exL.approved_status,exDetL.tax_amount,exDetL.description,exDetL.quantity,exDetL.unit from expense_list exL inner join expense_list_details exDetL on exL.expense_list_id=exDetL.expense_list_id where  exL.expense_list_id>0 order by exL.expense_list_id desc";     
    $resource=$os->pagingQuery($listingQuery,10000000,false,true);
    $rsRecords=$resource['resource'];
     
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b></div>

<table  border="1" cellspacing="0" cellpadding="0" class="noBorder"  >
                            <tr class="borderTitle" >
                                <td ><b>Date</b></td>  
                                <td ><b>Refference No</b></td>  
                                <td ><b>Description</b></td>  
                                <td ><b>Quantity</b></td>  
                                <td ><b>Unit</b></td>
                                <td ><b>Amount</b></td>  
                                <td ><b>Status</b></td>
                                <td ><b>Action</b></td> 
                            </tr>
                            <?php 
                                $serial=$os->val($resource,'serial');  
                                while($record=$os->mfa( $rsRecords)){ 
                                $serial++;?>
                            <tr>
                                    <td><?php echo $os->showDate($record['dated']);?></td> 
                                    <td><?php echo $record['reference_no']?> </td>   
                                     <td><?php echo $record['description']?> </td>   
                                    <td><?php echo $record['quantity']?> </td>
                                    <td><?php echo $record['unit']?> </td>  

                                    <td><?php echo $record['tax_amount']?> </td>  
                                    <td> <? if(isset($os->approvedStatus[$record['approved_status']])){ echo  $os->approvedStatus[$record['approved_status']]; } ?></td>
                                    <td><? if($os->access('wtView')){ ?>
                                        <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_expense_listGetById('<? echo $record['expense_list_id'];?>')" >Edit</a></span>  <? } ?><span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_expense_listDeleteRowById('<? echo $record['expense_list_id'];?>')" >Delete</a></span>  </td>
                            </tr>
                          <?}?>  
        </table>     
        </div>
        <br />          
<?php exit();}

if($os->get('WT_expense_listEditAndSave')=='OK'){
        //Expense List//
        $expense_list_id=$os->post('expense_list_id');
        $dataToSave['reference_no']=addslashes($os->post('reference_no'));  
        $dataToSave['parent_head_id']=addslashes($os->post('parent_head_id')); 
        $dataToSave['account_head_id']=addslashes($os->post('account_head_id')); 
        $dataToSave['dated']=$os->saveDate($os->post('dated')); 

        $dataToSave['user_id']=addslashes($os->post('user_id'));
        $qResult=$os->save('expense_list',$dataToSave,'expense_list_id',$expense_list_id);

        if($os->post('reference_no')==''){
            $dataToSave3['reference_no']=$qResult;
            $os->save('expense_list',$dataToSave3,'expense_list_id',$qResult);  
        }
        //Expense List//

        //Expense Details//

        $expense_list_details_id=$os->post('expense_list_details_id');
        $dataToSave2['expense_list_id']=addslashes($qResult); 
        $dataToSave2['parent_head_id']=addslashes($os->post('parent_head_id')); 
        $dataToSave2['account_head_id']=addslashes($os->post('account_head_id')); 
        $dataToSave2['description']=addslashes($os->post('description')); 
        $dataToSave2['quantity']=addslashes($os->post('quantity')); 
        $dataToSave2['unit']=addslashes($os->post('unit')); 
        $dataToSave2['tax_percent']=addslashes($os->post('tax_percent')); 
        $dataToSave2['total_incl_tax']=addslashes($os->post('total_incl_tax')); 
        $dataToSave2['tax_amount']=addslashes($os->post('tax_amount')); 
        $dataToSave2['type']=addslashes($os->post('type')); 

        $dataToSave2['user_id']=addslashes($os->post('user_id'));
        $qResult2= $os->save('expense_list_details',$dataToSave2,'expense_list_details_id',$expense_list_details_id);
        //Expense Details//
        if($qResult){
            if($expense_list_id>0 ){ $mgs= " Data updated Successfully";}
            if($expense_list_id<1 ){ $mgs= " Data Added Successfully"; $expense_list_id=  $qResult;}
            $mgs=$expense_list_id."#-#".$mgs."#-#".$qResult2;
        }
        else{
            $mgs="Error#-#Problem Saving Data.";
        }
        echo $mgs;      
        exit(); 
} 


if($os->get('WT_expense_listGetById')=='OK'){
        $expense_list_id=$os->post('expense_list_id');
        if($expense_list_id>0)  
        {
            $wheres=" where expense_list_id='$expense_list_id'";
        }
        $dataQuery=" select * from expense_list  $wheres ";
        $rsResults=$os->mq($dataQuery);
        $record=$os->mfa( $rsResults);
        $record['reference_no']=$record['reference_no'];
        $record['parent_head_id']=$record['parent_head_id'];
        $record['account_head_id']=$record['account_head_id'];
        $record['dated']=$os->showDate($record['dated']); 

        $dataQuery2=" select * from expense_list_details  $wheres ";
        $rsResults2=$os->mq($dataQuery2);
        $record2=$os->mfa( $rsResults2);

        $record['expense_list_details_id']=$record2['expense_list_details_id'];

        
        $record['description']=$record2['description'];
        $record['quantity']=$record2['quantity'];
        $record['unit']=$record2['unit'];
        $record['tax_percent']=$record2['tax_percent'];
        $record['total_incl_tax']=$record2['total_incl_tax'];
        $record['tax_amount']=$record2['tax_amount'];
        $record['type']=$record2['type'];
        echo  json_encode($record);  
        exit();
}



if($os->get('WT_expense_listDeleteRowById')=='OK'){ 

    $expense_list_id=$os->post('expense_list_id');
    if($expense_list_id>0){
    $updateQuery="delete from expense_list where expense_list_id='$expense_list_id'";
    $os->mq($updateQuery);
    $updateQuery2="delete from expense_list_details where expense_list_id='$expense_list_id'";
    $os->mq($updateQuery2);
    echo 'Record Deleted Successfully';
    }
    exit();
}


?>

