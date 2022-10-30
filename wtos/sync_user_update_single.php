<? session_start();
include('wtosConfigLocal.php');
global $site;
$database_selected='';
if(isset($_POST['database_single']))
{
  $database_single=$_POST['database_single'];
}
if($database_single==''){ die('database missing ');}


$site['db']=$database_single;
error_reporting($site['environment']);
include($site['root-wtos'].'wtos.php');
if($os->post('SYNC-DATA')!='OK'){ die('sync not ok ');} 
 
 //$p=$os->post();
//_d($p);