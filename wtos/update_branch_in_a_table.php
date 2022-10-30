<?
/*
   # wtos version : 1.1
   # main ajax process page : branchAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Update  branch code';
$ajaxFilePath= 'branchAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
 $update_msg='';
 
?>
  

 <table class="container" >
				<tr>
					 
			  <td  class="middle" style="padding-left:5px;">
			  
			  
			  <div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			  
			  <!--  ggggggggggggggg   -->
			  
			  
<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable" style="background:#FFFFFF;">
<tr>
   <td width="350"   valign="top" class="ajaxViewMainTableTDForm"  >
	 <? $brs=$os->mq('select * from branch order by  branch_name asc'); 
	  $branch_list=array();
	 ?>
	 <? 
	 $k=1;
	 while($branches=$os->mfa($brs)){ 
	 
	 $branch_list[$branches['branch_code']]=$branches['branch_code'].'-'.$branches['branch_name'];
	  $branch_list_onlyname[$branches['branch_code']]=$branches['branch_name'];
	 ?>
	 <? echo $k ?>) <? echo  $branches['branch_code']  ?> - <? echo  $branches['branch_name']  ?>  <br />
	 
	 
	 <? $k++; } 
	 
	
	 
	 $branch_list_only_code=array_keys($branch_list);
	 // _d( $branch_list_only_code);
	 ?>
	 
	  
	
	</td>
    <td valign="top" class="ajaxViewMainTableTDList" width="520" >
	<? 
	 $fields=$table='';
	   $table_field_list['history-branch_code']='Student Session Table';
	   $table_field_list['student-branch']='Student Register Table';
	   $table_field_list['admin-branch_code']='Admin Table';
	  
	  
	  $table_fields=$_POST['table_fields'];
	  
	   if($table_fields)
	  {
	   $table_fields_a=explode('-',$table_fields);
	  // _d($table_fields_a);
	  $fields=$table_fields_a['1'];
	  $table=$table_fields_a['0'];
	  }
	  
	  /// update //
	  if(isset($_POST['update']))
	  {
	    if($_POST['update']=='Update' )
		{
		 $update_count=0;
		   $corrected_branch=$_POST['branch'];
		   foreach($corrected_branch as $wrong=>$correct)
		   {
		     if(trim($correct)!=''){
			   
			  
			   if( $table=='history' || $table=='student' )
			   {
				   $updateDataq="update  history set branch_code='$correct' where  branch_code='$wrong'  ";
				   $os->mq($updateDataq);
				   
				   $updateDataq="update  student set branch='$correct' where  branch='$wrong'  ";
				   $os->mq($updateDataq);
			   
			   } 
			    $updateDataq="update  $table set $fields='$correct' where  $fields='$wrong'  ";
		        $os->mq($updateDataq);
			 
			 $update_count++;
			 $branch_name_long=$branch_list_onlyname[$correct];
			   $update_msg .=  $update_count.") Updated from  <span style='color:#FF0000'>$wrong</span> => <span style='color:#009900'>$correct</span> [$branch_name_long]  <br>";
			 }
		   
		   }
		   
		
		}
	  
	  }
	  
 
	  
	  
	  /// update end  //
	  
	  
	  
	  
	  
	  
	 
	  
	  
	?>
	
	<form action=""  method="post">
	 <select name="table_fields" style="width:300px; color:#009900; font-weight:bold;">
	  <option value=""> </option>
	  <? $os->onlyOption($table_field_list,$table_fields); ?>
	  </select> 
	 
	   <!--Table=<input type="text" name="table" value="<? echo $table ?>" /> Fields <input type="text" name="fields" value="<? echo $fields ?>" /> -->
	   <input type="submit" name="list" value="List"   />
	   
	   
	   <div>
	    
	<? 
	 
	if($fields!='' && $table!='') { ?>	
		<? 
		    $kk="select distinct $fields from $table";
		$brs=$os->mq($kk); ?>
		 
		<table><tr> <td style="color:#0000CC; font-size:14px; font-weight:bold;">Wrong code </td> <td style="color:#0000CC; font-size:14px; font-weight:bold;"> Choose Correct Branch  </select> <input type="submit" name="update" value="Update" /></td> </tr>
	 <? 
	  $ikj=0;
	 while($branches_code=$os->mfa($brs)){
	 
	  $wrong_br_code=trim($branches_code[$fields]);
	  if($wrong_br_code==''){continue;}
	 
	 if(in_array($wrong_br_code,$branch_list_only_code)){ continue;}
	 $ikj++;
	  ?>
	 <tr <? if($ikj%2){ ?> style=" border:1px solid #3333FF;" <? }?> class="hovertr">
	 <td> <? echo $ikj; ?>) <b style="color:#FF0000"> <? echo $wrong_br_code; ?></b>   </td> 
	 <td> 
	 <input type="number" name="branch[<? echo $wrong_br_code; ?>]"  />
	 
	   </td> </tr>
	  
	  
	 <? } ?>
	 
	 <? } ?>
	 
	  </table>
	 
	   
	 </form>
	
	</td>
	<td valign="top">
	<? echo $update_msg; ?>
	</td>
  </tr>
</table>

		
			  			  
			  <!--   ggggggggggggggg  -->
			  
</td>
</tr>
</table>
<style>
.brlist{ width:340px; float:left;}
.hovertr:hover{ background-color:#FFFF22;}
</style>
			
 
 
<? include($site['root-wtos'].'bottom.php'); ?>