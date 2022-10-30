<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');

?>
<style>
.body_block{ width:100%; height:100vh; background-color:#A8D3FF;}
.body_block table{ width:100%; height:100%}
.body_block table tr td{ text-align:center; vertical-align:middle; height:100%}

</style>

<div class="body_block">
<table>
<tr>
<td>
<p style="color:red;font-weight: bold;font-size:60px;text-align:center; margin:0 0 15px 0;"  >Hello <?echo $os->userDetails['name']?></p>

<p style="color:#000099;font-weight: bold;font-size:50px;text-align:center; margin:0 0 0 0;">
Have a nice day !
</p>



</td>

</tr>

</table>




</div>




<? include($site['root-wtos'].'bottom.php'); ?>