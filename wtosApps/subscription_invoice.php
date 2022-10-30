<?
$school_setting_data=$os->school_setting();
$subscription_id =$_SESSION['paytm']['subscription_id'];    
$subscription_data=$os->rowByField('','subscription','subscription_id',$subscription_id,$where=" ",$orderby='');
$sub_fees_details_a=json_decode($subscription_data['sub_fees_details'],true);
$studentId=$subscription_data['studentId'];
$historyId=$subscription_data['historyId'];
$student_data=$os->rowByField('','student','studentId',$studentId,$where=" ",$orderby='');
$history_data=$os->rowByField('','history','historyId',$historyId,$where=" ",$orderby='');?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?= $site["themePath"]?>css/uikit.css">
    <link rel="stylesheet" type="text/css" href="<?= $site["themePath"]?>css/common.css">
    <style>
        *{
            font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif;
        }
        body{
            color: #111111;
        }
        .uk-card-outline{
            border:1px solid #e5e5e5;
        }
        .header-table{
            border-collapse: collapse;
            width: 100%;
        }
        .header-table > tr > td:nth-last-child(1){
            text-align: right;
        }
    </style>
</head>
<body>
 <div>
    <div class="header uk-background-primary uk-padding-small uk-text-center" style="background-color: #054b66;padding: 15px;">
        <img src="<? echo $site['url']?><? echo $school_setting_data['logoimage']?>" style="max-width: 130px"/>
    </div>

    <div class="uk-background-default uk-padding-small" style="padding: 15px;">
        <table class="uk-table uk-table-justify">
            <tr>
                <td class="uk-text-small">
                    <h5 class="uk-text-bold">Subscription</h5>
                    <p class="uk-margin-remove">Ref No: #<?= $subscription_data['subscription_id']?></p>
                    <p class="uk-margin-remove">Invoice Date: <?=$os->showDate($subscription_data['dated'])?></p>
                    <p class="uk-margin-remove">Session: <?=$history_data['asession']?></p>
                    <p class="uk-margin-remove">Status: <?= $subscription_data['payment_status']?$subscription_data['payment_status']:'Unpaid'?></p>


                    <h5 class="uk-text-bold">Bill To:</h5>
                    <p class="uk-margin-remove">Name : <?= $student_data['name']?></p>
                    <p class="uk-margin-remove">Mobile No : <?= $student_data['mobile_student']?></p>
                    <p class="uk-margin-remove">Class : <?= @$os->classList[$history_data['class']]?></p>
                </td>
                <td class="uk-table-shrink uk-text-small">
                    <h5 class="uk-text-bold uk-text-nowrap"><?= $school_setting_data["school_name"]?></h5>
                    <p class="uk-margin-remove"><?= $school_setting_data["address"]?></p>
                    <p class="uk-margin-remove uk-text-nowrap">Tel: <?= $school_setting_data["contact"]?></p>
                    <p class="uk-margin-remove uk-text-nowrap">Email : <?= $school_setting_data["email"]?></p>
                </td>
            </tr>
        </table>





        <h5 class="uk-text-bold">Details</h5>


        <div class="uk-card-outline">
            <table class="uk-table uk-table-small uk-table-divider uk-text-small uk-margin-remove">
                <thead>
                    <tr class="uk-background-muted">
                        <td class="uk-text-nowrap uk-text-bold">Online Class</td>
                        <td class="uk-text-nowrap uk-text-bold">Online Exam</td>
                        <td class="uk-text-nowrap uk-text-bold uk-text-right uk-table-shrink">Amount</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="uk-text-nowrap"><?php echo $sub_fees_details_a['online_class']?$sub_fees_details_a['online_class']." INR":""; ?></td>
                        <td class="uk-text-nowrap"><?php echo $sub_fees_details_a['online_exam']?$sub_fees_details_a['online_exam']." INR":""; ?></td>
                        <?$sub_total=0;
                        $online_class=isset($sub_fees_details_a['online_class'])>0?$sub_fees_details_a['online_class']:0;
                        $online_exam= isset($sub_fees_details_a['online_exam'])>0?$sub_fees_details_a['online_exam']:0;
                        $sub_total= $online_class+ $online_exam;
                        ?>
                        <td class="uk-text-nowrap uk-text-right uk-text-bold">Sub Total: <?= $sub_total ?> INR</td>
                    </tr>
                    <?
                    $disconut_amt=0;
                    if(isset($sub_fees_details_a['online_exam'])>0&&isset($sub_fees_details_a['online_class'])>0){
                        $disconut_amt=$sub_fees_details_a['full_package_discount'];
                    }
                    else{
                        $disconut_amt=$sub_fees_details_a['online_exam_discount'];
                    }?>

                    <tr class="<?=$disconut_amt<1?'uk-hidden':''?>">
                        <td colspan="1"></td>
                        <td class="uk-text-nowrap uk-text-bold"> </td>
                        <td class="uk-text-nowrap uk-text-bold uk-text-right">Discount: <?
                        
                        echo $disconut_amt>0?$disconut_amt.' INR':'';
                        ?> </td>
                    </tr>
                    <tr>
                        <td  colspan="1"></td>
                        <td class="uk-text-nowrap uk-text-bold"></td>
                        <td class="uk-text-nowrap uk-text-bold uk-text-right"> Total Amount: <?= $sub_total-$disconut_amt?> INR</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?if(!is_array($subscription_data)){ ?> 
            <div class="uk-text-center">No data available at the moment.</div>
        <? } ?>

    </div>

</div>
</body>
</html>
