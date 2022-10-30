<?   

  $os->processLogin('username','password','admin'); 

 

 ?>

<?php if($os->isLogin()){
?>

 

<script type="text/javascript" language="javascript">

window.location="<?php echo $site['url-wtos'].'welcomePage.php'?>";

</script>

 



<?php exit(); } ?>

<?php if(!$os->isLogin()){ ?>

<style>
/*  added by mizanur  login   */
.left{float:left}
.right{float:right}
.clear{clear:both}
.lg_bg {
background-color:#E5E5E5;
width:500px;
border:#858585 1px solid;
border-left:none;
border-top:none;
-moz-border-radius:5px; 
-webkit-border-radius:5px;
border-radius:5px;
color:#FFFFFF;
}
.lg_bg table
{
/* border:2px solid #6B6B6B; */
width:100%;
-moz-border-radius:5px; 
-webkit-border-radius:5px;
border-radius:5px;
}
.textbox{
border:#999999 1px solid;
border-left:none;
border-top:none;
-moz-border-radius:3px; 
-webkit-border-radius:3px;
border-radius:3px;
background-color:#F8F8F8;
}
.textbox:hover{
background-color:#FFFFFF;
border:#999999 1px solid;
border-right:none;
border-bottom:none;
-moz-border-radius:3px; 
-webkit-border-radius:3px;
border-radius:3px;
}

.lg_bg table table
{
 border:none;
}
.adm
{
font-size:24px; font-weight:900;
color:#4B4B4B;
}

.ok{

border:2px solid #2D2D2D;

background:#4D4D4D;

width:40px;

-moz-border-radius:3px; 

-webkit-border-radius:3px;

border-radius:3px;

padding-left:7px;

border-left:none;

border-top:none;

}

.ok:hover{

border:2px solid #2D2D2D;

border-bottom:none;

border-right:none;

}



</style>



 <div id="hideForOtpLogin">

<table height="500" width="100%" >

<tr><td align="center" valign="middle">



<form action="" id="loginForm" method="post">

<div class="lg_bg">





<table width="400" border="0" cellspacing="0" cellpadding="3">

     <tr>

	 <td style="padding-left:5px;"><img src="<?php echo $site['url-wtos'] ?>images/loginlogo.png" alt="" width="65" height="40"  style="margin:0 0 0 0px; border:none;"/></td>

    <td height="50" colspan="3"  valign="middle" >

	

	<span class="adm"><? echo $os->adminTitle ?></span> </td>

    </tr> 

   

   <tr>

    <td colspan="3" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#6c6a6a;"><!--INTEGRATE ELECTRONIC HEALTH RECORD AND PRACTICE MANAGEMENT SOFTWARE--></td>

    </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" style="color:#0099FF; font-size:14px; padding:0 0 0 35px;"></td>

  </tr>

     

  

  

  <tr>

    <td width="55">&nbsp;</td>

    <td width="80" align="center" style="font-family:'Times New Roman', Times, serif; font-size:13px; color:#000;">User Name</td>

    <td width="256"><input type="text" class="textbox" name="username" value="" /></td>

    <td width="1">&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td align="center" style="font-family:'Times New Roman', Times, serif; font-size:13px; color:#000;">Password</td>

    <td><input type="password" class="textbox" name="password" value="" /></td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><table width="60%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="28%" height="30"><div class="ok" style="cursor:pointer;" onclick="document.getElementById('loginForm').submit()">login</div></td>

    <td width="30%" height="30"><div class="cancel"></div><span style="padding-top:0px;font-family:Arial, Helvetica, sans-serif; font-size:15px;"><a href="javascript:void(0)" onclick="showOptLoginDiv();"  >OTP Login</a></span><br>
	</td>

    <td width="42%" height="30"><div class="selet"></div></td>

  </tr>

</table></td>

    <td height="35">&nbsp;</td>

  </tr>

  

  <tr >

  

  <td style="padding-top:15px;">

  

  <a href="http://webtrackers.co.in/" title="Powered By Webtrackers4u" target="_blank">

	<img src="<?php echo $site['url-wtos'] ?>images/poweredBywebtrackers4u.png" alt="" width="30"   style="margin:0 0 0 5px; border:none;"/></a>

  </td>



    <td colspan="2" align="center" style="padding-top:15px;font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#666666;">
	
	
	Copyright &copy; 2011 <? echo $os->adminTitle ?> All rights reserved</td>

    </tr>

</table>



	  <div></div>

	

	</div>



<input type="hidden" name="SystemLogin" value="SystemLogin"/>

			<!--<input type="submit" class="loginbtn" value="" />-->



</form>	



</td>








</tr></table>

</div>





<script>
function showOptLoginDiv()
{

	os.hide('hideForOtpLogin');
	os.show('showOtpLogin');
	
}
</script>

<div id="showOtpLogin" style="display:none;" >
<?include('login_mobile_otp.php');?>
</div>

<?php exit(); } ?>



