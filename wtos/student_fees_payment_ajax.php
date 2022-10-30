<?
/*
   # wtos version : 1.1
   # page called by ajax script in account_headDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);


?><?

if($os->get('student_fees_collect_byregno')=='OK')

{

    $registerNo=trim($os->post('registerNo'));
    //  $studentQuery="  select * from history where studentId>0   and  name like '$name%' order by studentId desc limit 3";

    $listingQuery="  select h.*,s.*   
FROM history h 
INNER JOIN student s on(s.studentId = h.studentId)
WHERE h.historyId>0 and (s.registerNo like'%$registerNo%' or rfid like'%$registerNo%')   ORDER BY asession desc limit 1 ";
    $studentMq=$os->mq($listingQuery);
    $student_rs=$os->mfa($studentMq);


    $historyId=$student_rs['historyId'];
    echo "##-##info##-##";
    ?>
    <h1 class="uk-hidden"><? echo $student_rs['name']; ?> </h1>

    <?
    echo "##-##info##-##";

    echo "##-##historyId##-##";

    echo $historyId;echo "##-##historyId##-##";

    exit();


}
?>


