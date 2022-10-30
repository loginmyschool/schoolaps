<?  
$os->processLogin('mobileNo','otp','admin'); 
 ?>
<?php if($os->isLogin()){
?>
 <script type="text/javascript" language="javascript">
//login
window.location="<?php echo $site['url-wtos'].'myProfileDataView.php'?>";
</script>
 

<?php exit(); 
} ?>
<?php if(!$os->isLogin()){ ?>
<?php 

$errorMsg='';
$adminId='';
               include('sendSms.php');
				$mobileNo=$os->get('mobileNo');
				if($mobileNo!='' )
				{
					$searchMobileNoQuery="select * from admin where mobileNo='$mobileNo' and active='Active'";
					$dataMq=$os->mq($searchMobileNoQuery);
					$data=$os->mfa($dataMq);
					$adminId=$data['adminId'];
					if($adminId!='')
					{
					$otp=rand(10000,99999);
					$dataToSave['otp']=$otp;
					$smsObj= new sms;
					$smsText=$smsObj->template('New_OTP',array('#OTP#'=>$dataToSave['otp']));
					$smsNumbersStr= $mobileNo;
					$smsObj->sendSMS($smsText,$smsNumbersStr);
					
					$os->save('admin',$dataToSave,'adminId',$adminId);
		            $os->saveSendingSms($smsText,$mobileNos=$smsNumbersStr , $status='send',$note='Otp Login');
					
					}	
					else
				    {
					  $errorMsg="(Mobile no does not exist)";
				    }
			         				
?>

 
 
 <style>

/*  added by mizanur  login   */



.left{float:left}
.right{float:right}
.clear{clear:both}


.lg_bg {
background-color:#E5E5E5;
width:270px;
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
width:70px;
-moz-border-radius:3px; 
-webkit-border-radius:3px;
border-radius:3px;
padding-left:7px;
border-left:none;
border-top:none;
color:#FFFFFF;
font-size:14px;
}
.ok:hover{
border:2px solid #2D2D2D;
border-bottom:none;
border-right:none;
}

</style>

<?





}?>
 
 
 
 
 
 
 
 
 
 
<table   width="100%" style="margin:10px 0px 0px 10px;" >
<tr><td align="center" valign="middle">

<form action="" id="otploginForm" method="post">
<div class="lg_bg" style="width:270px;">


<table   border="0" cellspacing="0" cellpadding="3" style="color:#333333;">
     <tr>
	 <td style="padding-left:5px;"><img src="<?php echo $site['url-wtos'] ?>images/loginlogo.png" alt="" width="65" height="40"  style="margin:0 0 0 0px; border:none;"/></td>
    <td height="50"   valign="middle" >
	
	<span class="adm">OTP LOGIN </span> <br>
	
	<span style="color:red;font-weight: bold;font-size:10px;"><?echo $errorMsg; ?></span>
	
	</td>
    </tr> 
   
  <? if( $adminId==''){ ?>
  <tr>
    <td   style="width:99px;" align="right">
     MOBILE NO</td>
    <td ><input type="text" value="" name="mobileNoOTP" id="mobileNoOTP" style="font-size:15px; font-weight:bold; color:#005EBB; width:150px;" /><!--<a href="javascript:void(0)" onclick="mobileNoOTPf()" style="text-decoration:none;">GET OTP</a>-->
<script>
function mobileNoOTPf()
{
window.location='<?php echo $site['url-wtos'] ?>?mobileNo='+os.getVal('mobileNoOTP');

}
</script>
	</td>
     
  </tr>
  
  <tr>
    
    <td>&nbsp;</td>
    <td><table width="60%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><div class="ok"  style="cursor:pointer;width:70px;color:#FFFFFF;" onclick="mobileNoOTPf()">GET OTP</div></td>
     
  </tr>
</table></td>
    
  </tr>
  <? }else{ ?>
  
  <tr>
    <td   style="width:100px;" align="right">
     MOBILE NO</td>
    <td ><input type="hidden" class="textbox" name="mobileNo" value="<? echo $mobileNo ?>" readonly="1" /> 
	
	<b style="font-size:16px; color:#0052A4"><?php echo $mobileNo; ?></b>
	</td>
     
  </tr>
  <tr>
     <td  align="right">
     OTP</td>
    <td><input type="text" class="textbox" name="otp" value=""  style="font-size:15px; font-weight:bold; color:#005EBB; width:150px;" />
	<? if(0 && $mobileNo!=''){ ?>
	<img src="https://malert.in/api/api_http.php?username=ermc&password=ermcapi@2018&senderid=GSERMC&to=<?php echo $mobileNo ?>&text=<?php echo $smsText ?>&route=Enterprise&type=text" style="display:none;" />
	<? } ?>
	</td>
     
  </tr>
  
  
  <tr>
    
    <td>&nbsp; </td>
    <td><table width="60%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><div class="ok" style="cursor:pointer;" onclick="document.getElementById('otploginForm').submit()">login</div></td>
     
  </tr>
</table></td>
    
  </tr>
  
  <? } ?>
  
  
  <tr >
  
  <td style="padding-top:15px;">
  
  <a href="http://webtrackers.co.in/" title="Powered By Webtrackers4u" target="_blank">
	<img src="<?php echo $site['url-wtos'] ?>images/poweredBywebtrackers4u.png" alt="" width="30"   style="margin:0 0 0 5px; border:none;"/></a>
  </td>
  
    <td  align="center" style="padding-top:15px;font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#666666;">Copyright &copy; 2011 <? echo $os->adminTitle ?> All rights reserved</td>
    </tr>
	
	
	
	
</table>

	  <div></div>
	
	</div>

<input type="hidden" name="SystemLogin" value="SystemLogin"/>
			 

</form>	

</td></tr></table>





<?php exit(); } ?>

