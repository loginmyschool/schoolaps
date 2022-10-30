<? 
/*
   # wtos version : 1.1
   # page called by ajax script in examsettingDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
include('routin_settings/routin_config.php');

$pluginName='';
$os->loadPluginConstant($pluginName); 
?><?


if($os->get('show_class_room')=='OK')
{ 

			$post=$os->post();
			$day=$post['day'];
			$periods=$post['periods'];
			$no_of_class=$post['no_of_class'];
			?>
			
			<h3> Day: <? echo $day; ?>    Period: <? echo $periods; ?>  </h3>
			   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:1050px;">
						<tr><td>
						 
						<? for($i=1;$i<= $no_of_class; $i++ )
						 { ?>
						           <div id="class_<? echo $i; ?>" class="classroom_daily"> <? echo $i; ?> </div> 
						 <? } ?>
						  </td>
						</tr>
				</table>
			
	<? 		 
         
}

if($os->get('manage_number_of_class')=='OK')
{ 

			$post=$os->post();
			$day=$post['day'];
			$perod=$post['perod'];
			$fld_val=$post['fld_val'];
			
			 
			
			
			 
			 $file_path='routin_settings/routin_setting.txt';
			
			$routin_setting_array=array();
			$routin_setting =  file_get_contents($file_path);
			if($routin_setting ){
			
			      $routin_setting_array=json_decode($routin_setting,true);
			
			}
			$routin_setting_array[$day][$perod]=$fld_val;
			$routin_setting=json_encode($routin_setting_array);
			
			file_put_contents($file_path, $routin_setting);
			
			
			
			 
			echo 'Setting Updated';
         
}
 