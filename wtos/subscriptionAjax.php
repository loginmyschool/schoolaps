<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);
?><?

if($os->get('WT_subscriptionListing')=='OK'){
  $and_name=$os->post('name')?'and stu.name like "%'.$os->post('name').'%"':'';
  $and_mobile_student=$os->post('mobile_student')?'and stu.mobile_student like "%'.$os->post('mobile_student').'%"':'';
  $andpayment_status=  $os->postAndQuery('payment_status_s','sub.payment_status','=');
  $searchKey=$os->post('searchKey');
  $where='';
  if($searchKey!=''){
    $where ="and ( sub.studentId like '%$searchKey%' Or sub.historyId like '%$searchKey%' Or sub.total_amount like '%$searchKey%' Or sub.payment_status like '%$searchKey%' Or sub.month_count like '%$searchKey%' Or sub.months like '%$searchKey%' Or sub.pyment_details like '%$searchKey%' Or sub.year like '%$searchKey%' )";

  }

  $listingQuery="select 
  sub.*,stu.name,stu.mobile_student,hist.class,hist.asession
  from subscription as sub 
  inner join student as stu
  on sub.studentId=stu.studentId
  inner join history as hist
  on sub.historyId=hist.historyId
  where sub.subscription_id>0   $where   $and_name  $and_mobile_student $andpayment_status order by sub.subscription_id desc";
  $showPerPage= $os->post('showPerPage');
  $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
  $rsRecords=$resource['resource'];


  ?>
  <div class="listingRecords">
    <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

    <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
     <tr class="borderTitle" >

      <td >#</td>
      <td >Action </td>
      <td ><b>Student</b></td>  
      <td ><b>Mobile</b></td>  
      <td ><b>Date</b></td>
      <td ><b>Class</b></td>  
      <td ><b>Session</b></td>
      <td ><b>Full Package</b></td>  
      <td ><b>Exam Only</b></td>  
     <!--  <td ><b>Full Package Discount</b></td>  
      <td ><b>Online Exam Discount</b></td> -->    
      <td ><b>Total amount</b></td>  
      <td ><b>Payment status</b></td>  
    </tr>
    <?php
    $serial=$os->val($resource,'serial');  
    while($record=$os->mfa( $rsRecords)){ 
      $serial++;
      $sub_fees_details_a=json_decode($record['sub_fees_details'],true);
// _d($sub_fees_details_a);

      ?>
      <tr class="trListing">
       <td><?php echo $serial; ?>     </td>
       <td class="uk-text-nowrap"> 
        <? if($os->access('wtView')){ ?>
         <span  ><a href="javascript:void(0)"  onclick="WT_subscriptionGetById('<? echo $record['subscription_id'];?>')" >Edit</a></span>  <? } ?> <!-- &nbsp;&nbsp;
         <span  ><a href="javascript:void(0)"  onclick="show_subscription_details('<? echo $record['subscription_id'];?>')" >Details</a></span> -->

       </td>
       <td><span uk-tooltip="title:History ID : <?=$record['historyId']?>; delay: 100" title="" aria-expanded="false" tabindex="0" style="cursor: pointer;">
        <?php echo $record['name']?>
      </span> </td>  
      <td><?php echo $record['mobile_student']?> </td>  
      <td><?php echo $os->showDate($record['dated']);?> </td>
      <td><?=$os->classList[$record['class']]?></td>
      <td><?=$record['asession']?></td>
     

      <!-- <td><?=isset($sub_fees_details_a['online_class'])?$sub_fees_details_a['online_class']:''?></td>
      <td><?=isset($sub_fees_details_a['online_exam'])?$sub_fees_details_a['online_exam']:''?></td>   -->


      <td><input type="checkbox"  name="is_full_package"  <?php echo $record['online_class']==1&&$record['online_exam']==1?'checked':'';?>></td>

      <td><input type="checkbox"  name="exam_only"  <?php echo $record['online_exam']==1&&$record['online_class']==0?'checked':'';?>></td>
      

     <!--  <td><?=isset($sub_fees_details_a['full_package_discount'])?$sub_fees_details_a['full_package_discount']:''?></td>  
      <td><?=isset($sub_fees_details_a['online_exam_discount'])?$sub_fees_details_a['online_exam_discount']:''?></td>  --> 

      <td><?php echo $record['total_amount']?> </td>  
      <td style="font-weight:bold;color:<?php echo $record['payment_status']=='Paid'?'green':'red'; ?>"> <?php echo $record['payment_status']?$record['payment_status']:'Unpaid'; ?></td> 
   </tr>
 <? } ?>  
</table> 
</div>
<br />
<?php 
exit();

}






if($os->get('WT_subscriptionEditAndSave')=='OK')
{
 $subscription_id=$os->post('subscription_id');



 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['historyId']=addslashes($os->post('historyId')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['total_amount']=addslashes($os->post('total_amount')); 
 $dataToSave['payment_status']=addslashes($os->post('payment_status')); 
 $dataToSave['from_date']=$os->saveDate($os->post('from_date')); 
 $dataToSave['to_date']=$os->saveDate($os->post('to_date')); 
 $dataToSave['month_count']=addslashes($os->post('month_count')); 
 $dataToSave['months']=addslashes($os->post('months')); 
 $dataToSave['pyment_details']=addslashes($os->post('pyment_details')); 
 $dataToSave['year']=addslashes($os->post('year')); 




 $dataToSave['modifyDate']=$os->now();
 $dataToSave['modifyBy']=$os->userDetails['adminId']; 

 if($subscription_id < 1){

  $dataToSave['addedDate']=$os->now();
  $dataToSave['addedBy']=$os->userDetails['adminId'];
}


          $qResult=$os->save('subscription',$dataToSave,'subscription_id',$subscription_id);///    allowed char '\*#@/"~$^.,()|+_-=:££

          if($qResult)  
          {
          	if($subscription_id>0 ){ $mgs= " Data updated Successfully";}
          	if($subscription_id<1 ){ $mgs= " Data Added Successfully"; $subscription_id=  $qResult;}

          	$mgs=$subscription_id."#-#".$mgs;
          }
          else
          {
          	$mgs="Error#-#Problem Saving Data.";

          }
		//_d($dataToSave);
          echo $mgs;		

          exit();

        } 

        if($os->get('WT_subscriptionGetById')=='OK')
        {
         $subscription_id=$os->post('subscription_id');

         if($subscription_id>0)	
         {
          $wheres=" where subscription_id='$subscription_id'";
        }
        $dataQuery=" select * from subscription  $wheres ";
        $rsResults=$os->mq($dataQuery);
        $record=$os->mfa( $rsResults);


        $record['studentId']=$record['studentId'];
        $record['historyId']=$record['historyId'];
        $record['dated']=$os->showDate($record['dated']); 
        $record['total_amount']=$record['total_amount'];
        $record['payment_status']=$record['payment_status'];
        $record['from_date']=$os->showDate($record['from_date']); 
        $record['to_date']=$os->showDate($record['to_date']); 
        $record['month_count']=$record['month_count'];
        $record['months']=$record['months'];
        $record['pyment_details']=$record['pyment_details'];
        $record['year']=$record['year'];



        echo  json_encode($record);	 

        exit();

      }


      if($os->get('WT_subscriptionDeleteRowById')=='OK')
      { 

      	$subscription_id=$os->post('subscription_id');
      	if($subscription_id>0){
      		$updateQuery="delete from subscription where subscription_id='$subscription_id'";
      		$os->mq($updateQuery);
      		echo 'Record Deleted Successfully';
      	}
      	exit();
      }

      if($os->get('show_subscription_details')=='OK'){
      	$subscription_id=$os->post("subscription_id");
      	$subscription_details_q="SELECT 
      	sub_det.*,sub.subjectName,subcr.month_count
      	FROM subscription_details as sub_det
      	inner join subject as sub
      	on sub_det.subjectId=sub.subjectId
      	inner join subscription as subcr
      	on sub_det.subscription_id=subcr.subscription_id
      	where sub_det.subscription_details_id>0 and sub_det.subscription_id='$subscription_id' ORDER BY sub_det.subscription_details_id desc";
      	$subscription_details_mq=$os->mq($subscription_details_q);?>
      	<table class="uk-table uk-table-striped uk-margin-remove uk-table-hover">
      		<thead>
      			<tr >
      				<th ><b>#</td>
      					<th ><b>Subject </b></th>
      					<th class="uk-text-nowrap"><b>Online Class</b></th> 
      					<th class="uk-text-nowrap uk-hidden"><b>Offline Class</b></th>
      					<th class="uk-text-nowrap"><b>Online Exam</b></th>
      					<th class="uk-text-nowrap uk-hidden"><b>Offline Exam</b></th>
      					<th class="uk-text-nowrap"><b>Total</b></th>
      				</tr>
      			</thead>
      			<tbody>
      				<?
      				$subscription_details_c=1;
      				$sub_total_a=[];
      				$total_month=0;
      				while($record=$os->mfa($subscription_details_mq)){
      					$sub_total=$record['online_class']+$record['offline_class']+$record['online_exam']+$record['offline_exam'];
      					$sub_total_a[]=$sub_total;
      					$total_month=$record['month_count'];
      					?>
      					<tr>
      						<td><?php echo $subscription_details_c;?></td>
      						<td><?php echo $record['subjectName']; ?></td>
      						<td><?php echo $record['online_class']; ?></td>
      						<td class="uk-hidden"><?php echo $record['offline_class']; ?></td>
      						<td><?php echo $record['online_exam']; ?></td>
      						<td class="uk-hidden"><?php echo $record['offline_exam']; ?></td>  
      						<td><?= $sub_total; ?></td> 
      					</tr>
      					
      					<?$subscription_details_c++;}?>
      					<?if($subscription_details_c>1){?>
      						<tr>      	
      							<!-- <td colspan="2"></td>						 -->
      							<td class="uk-text-nowrap"><span style="color:blue;font-weight: bold">SubTotal: </span><b><?=array_sum($sub_total_a)?></b></td>
      							<td class="uk-text-nowrap"><span style="color:green;font-weight: bold">Total Month: </span><b><?=$total_month?></b></td>
      							<td class="uk-text-nowrap"><span style="color:red;font-weight: bold">Total Amount: </span><b><?=(array_sum($sub_total_a)*$total_month)?></b></td>
      							
      						</tr>      						
      						<?}else{?>
      							<tr><td colspan="6" style="color:red;font-weight: bold">No data available at the moment.</td></tr>
      							<?}?>
      						</tbody>
      					</table>

      					<?exit();}


