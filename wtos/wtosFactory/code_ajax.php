<? 
error_reporting(0);
include('../../wtosConfig.php');
include($site['root-wtos'].'wtosCommon.php');
include('functions.php');










if($os->get('tos_results')=='OK' && $os->post('tos_results')=='OK')
{
 $table=$os->post('table');
	
	$field=$os->post('field');
	$primery=$os->post('primery');
	 
            $table=array_filter(explode(',',$table));
			$field=array_filter(explode(',',$field));  
			$primery=array_filter(explode(',',$primery));  
			
			 
			
			foreach($field as $val)
			{
?>
var <? echo $val ?>=os.getVal('<? echo $val ?>');
formdata.append('<? echo $val ?>',<? echo $val ?> );			
<?
			
			}
			
			
echo '
			
			
';
			 
			
			foreach($field as $val)
			{
			?>
$<? echo $val ?>=$os->post('<? echo $val ?>');
<?
			
			}
			            					      
						 
						
		  $dataToSave=array();				 
echo '
			
			
';
		
		foreach($field as $val)
			{
			?>
$dataToSave['<? echo $val ?>']=$<? echo $val ?>;
<?
			
			}
 
			if(isset($table[0]) && isset($primery[0])){
			?>
$qResult=$os->save('<? echo $table[0] ?>',$dataToSave,'<? echo $primery[0] ?>','');


$query="select * from <? echo $table[0] ?> where <? echo $primery[0] ?>='$<? echo $primery[0] ?>' ";
$query_rs=$os->mq($query);
while($record=$os->mfa($query_rs))
{
   echo $record['<? echo $primery[0] ?>'];
}

foreach($variable as $key=>$val)
{

}
foreach($variable as $val)
{

}
<?
			}
			
	 exit();
}








?>