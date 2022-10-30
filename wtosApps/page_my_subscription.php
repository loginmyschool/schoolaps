<?php
global $os,$site,$pageVar;
$ajaxFilePath= $site['url'].'wtosApps/'.'my_subscription_ajax.php';
$loadingImage=$site['url-wtos'].'images/loading_new.gif';
if(!$os->isLogin() )
{
    header("Location: ".$site['url']."login");
}
else{
    $studentId=$os->userDetails['studentId'];
    $student_data=$os->getSession('student_data',$studentId);
    if(!isset($student_data['studentId']))
    {
        $student_data=$os->rowByField('','history','studentId',$studentId,$where="  ",$orderby='  asession desc ');
        $os->setSession($student_data,$key1='student_data',$studentId);
    }
    //_d();
    $_SESSION['my_subscription_student_id']=$studentId;
    $name=$os->userDetails['name'];
    $historyId=$student_data['historyId'];
    $class=$student_data['class'];
    $asession =$student_data['asession'];
    $subs_a=array();
    $subscription_q=
    "select 
    sub.subscription_id,sub.studentId,sub.historyId,sub.total_amount,sub.payment_status,sub.from_date,sub.to_date,sub.month_count,sub.sub_fees_details,sub.online_class,sub.online_exam,stu.name,hist.class,hist.asession
    from subscription as sub
    inner join student as stu on sub.studentId=stu.studentId
    inner join history as hist on sub.historyId=hist.historyId    
    where sub.studentId='$studentId' 
    order by sub.subscription_id desc
    ";
    $subscription_mq=$os->mq($subscription_q);
    while($record=$os->mfa($subscription_mq)){

        $subs_a[$record['subscription_id']]['class']=$record['class'];
        $subs_a[$record['subscription_id']]['asession']=$record['asession'];        
        $subs_a[$record['subscription_id']]['from_date']=$os->showDate($record['from_date']);        
        $subs_a[$record['subscription_id']]['to_date']=$os->showDate($record['to_date']);
        $subs_a[$record['subscription_id']]['month_count']=$record['month_count'];
        $subs_a[$record['subscription_id']]['total_amount']=$record['total_amount'];
        $subs_a[$record['subscription_id']]['payment_status']=$record['payment_status'];
        $subs_a[$record['subscription_id']]['sub_fees_details']=$record['sub_fees_details'];

        $subs_a[$record['subscription_id']]['online_class']=$record['online_class'];
        $subs_a[$record['subscription_id']]['online_exam']=$record['online_exam'];
    }
    // _d($subs_a);
    //     die;
    

    ?>

    <p class="uk-text-bold"> Welcome <span class="uk-text-warning"><? echo $name ?></span></p>
    <button class="uk-button uk-button-primary" id="new_subscription">New Subscription</button>
    <table   class="uk-table uk-table-divider"  >
        <thead>
            <tr >
                <!-- <th><b>Details</b></th> -->
                <th ><b>#</td>

                    <th ><b>Class </b></th>
                    <th ><b>Session</b></th>
                    <th ><b>Full Package</b></th>
                    <th ><b>Only Exam</b></th>                    
                    <!-- <th ><b>Discount</b></th>  -->
                    <th ><b>Total Amt.</b></th>
                    <th ><b>Payment Status</b></th>
                    <th ><b>Add Payment</b></th>
                    <th ><b>Download</b></th>
                </tr>
            </thead>

            <?php 
            $serial=0;               
            foreach($subs_a as $subscription_id => $record){ 
                $serial++;
                $sub_fees_details_a = json_decode($record['sub_fees_details'], TRUE);
                ?>
                <tbody>
                    <tr >
                        <!-- <td onclick='$("#details_<?=$serial?>").toggle(2000,"linear");' style="cursor: pointer;"  class="uk-text-bold uk-text-warning">View Details</td> -->
                        <td ><?php echo $serial;?></td>
                        <td><?php echo $os->classList[$record['class']]; ?></td>
                        <td><?php echo $record['asession']; ?></td> 
                        <!-- <td><?=isset($sub_fees_details_a['online_class'])?$sub_fees_details_a['online_class']:''?></td>
                            <td><?=$sub_fees_details_a['online_exam']?></td> --> 

                            <td><input type="checkbox"   <?php echo $record['online_class']==1&&$record['online_exam']==1?'checked':'';?>></td>

                            <td><input type="checkbox"   <?php echo $record['online_exam']==1&&$record['online_class']==0?'checked':'';?>></td>
                            <!-- <td><?

                            $discount_amount=isset($sub_fees_details_a['full_package_discount'])?$sub_fees_details_a['full_package_discount']:$sub_fees_details_a['online_exam_discount'];
                            echo $discount_amount>0?$discount_amount:'';
                            ?></td>   -->                    
                            <td class="uk-text-bold"><?php echo $record['total_amount']; ?></td>    
                            <td style="font-weight:bold;color:<?php echo $record['payment_status']=='Paid'?'green':'red'; ?>"><?php echo $record['payment_status']?$record['payment_status']:'Unpaid'; ?></td> 
                            <td class="uk-text-bold"><?if($record['payment_status']!='Paid'){?><a style="text-decoration: none;color:blue" href="javascript:void(0)" onclick="set_subscription_id('<?echo $subscription_id?>')">Pay Now</a><?}?></td>
                            <td class="uk-text-bold"><a style="text-decoration: none;color:blue" href="javascript:void(0)" onclick="download_pdf('<?echo $subscription_id?>')">Download Invoice</a></td>
                        </tr>
                        <tr id="details_<?=$serial?>" style="display: none;">
                            <!-- <td><?=count($record['sub_details']);?></td> -->
                            <td colspan="10">
                             <table class="uk-table">
                                <thead>
                                    <tr >

                                        <th style="color: green"><b>Subject Name</b></th>
                                        <th style="color: green"><b>Online Class</b></th> 
                                        <th style="color: green"><b>Online Exam</b></th>
                                    </tr>
                                </thead>
                                <?foreach($record['sub_details'] as $sub_det_a){?>
                                    <tbody>
                                        <tr>

                                            <td style="color: #054b66"><b><?php echo $sub_det_a['subjectName']; ?><b></td>
                                                <td style="color: #054b66"><b><?php echo $sub_det_a['online_class']; ?><b></td>
                                                    <td style="color: #054b66"><b><?php echo $sub_det_a['online_exam']; ?><b></td>
                                                    </tr>
                                                </tbody>
                                                <?}?>
                                            </table>
                                        </td>

                                    </tr>
                                </tbody>
                            <? } 
                            echo $serial==0? "<tbody><tr ><td colspan='10' class='uk-text-bold uk-text-danger'>Sorry! No data found.</td></tr></tbody>":'';
                            ?>                      
                        </table>
                        <?}?>
                        <script type="text/javascript">
                            document.getElementById("new_subscription").addEventListener("click", function() {
                                window.location.href='<?echo $site['url']?>subscription';
                            });
                            const set_subscription_id=(subscription_id)=>{
                             if(confirm("Are you sure?")==false)
                                return false; 
                            var formdata = new FormData();
                            formdata.append('subscription_id',subscription_id); 
                            var url='<? echo $ajaxFilePath ?>?set_subscription_id=OK&';
                            os.animateMe.div='div_busy';
                            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
                            os.setAjaxFunc('add_payment',url,formdata);
                        }
                        const add_payment=(data)=>{
                            if(data=="OK"){                                
                              window.location.href='<?echo $site['url']?>payment';
                          }
                          else{
                            alert(data);
                        }
                    }
                    const download_pdf=(subscription_id)=>{                           
                        var formdata = new FormData();
                        formdata.append('subscription_id',subscription_id); 
                        var url='<? echo $ajaxFilePath ?>?download_pdf=OK&';
                        os.animateMe.div='div_busy';
                        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
                        os.setAjaxFunc('download_pdf_url',url,formdata);
                    }
                    const download_pdf_url=(data)=>{
                        if(data=="OK"){                                
                          window.location.href='<?echo $site['url']?>download-pdf';
                      }
                      else{
                        alert(data);
                    }
                }
            </script>