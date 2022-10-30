<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$studentId = $_GET['studentId'];
 $resultsdetailsQ="select * from resultsdetails where resultsdetailsId>0 and studentId='$studentId' and status='Active' "; 
$resultsdetailsMq=$os->mq($resultsdetailsQ);
$resultsdetailsRecord=$os->mfa($resultsdetailsMq);
$resultD=$os->rowByField('','results','resultsId',$resultsdetailsRecord['resultsId']);
$examD=$os->rowByField('','exam','examId',$resultsdetailsRecord['examId']);

$examDetailsD=$os->rowByField('','examdetails','examdetailsId',$resultsdetailsRecord['examdetailsId']);
_d($examDetailsD);
?>


