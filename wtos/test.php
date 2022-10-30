<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
 $a="SELECT tableId FROM logrecord WHERE tableName='fees' AND addedBy = '26'";
 $mq=$os->mq($a);
while($record=$os->mfa($mq))
{
	$data[]=$record['tableId'];
}
_d($data);
echo $str=implode($data,',');
echo '<br>';
echo '<br>';
?>