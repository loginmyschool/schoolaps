<?
/*
   # wtos version : 1.1
   # main ajax process page : adminAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Update profile';
$ajaxFilePath= 'adminAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
 
  
?>


    <table class="container" style="background-color:#FFF;">
        <tr>

            <td  class="middle" style="padding-left:5px;">


                 

                <!--  ggggggggggggggg   -->


                <table width="350"  cellspacing="0" cellpadding="1" class=" " style="background-color:#FFF;">

                    <tr>
                        <td width="320" height="470" valign="top" class="ajaxViewMainTableTDForm">
						<h1> Change Password </h1>
                            <div class="formDiv">
                                 
                                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
                                    
                                     
									
									  <tr >
                                        <td>Recent Password </td>
                                        <td><input value="" type="text" name="recent_password" id="recent_password" class="textboxxx  fWidth "/> </td>
                                    </tr>
									
									<tr >
                                        <td>New Password </td>
                                        <td><input value="" type="text" name="new_password" id="new_password" class="textboxxx  fWidth "/> </td>
                                    </tr>   
 
                                </table>


                                 

                                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_adminupdatepassAndSave();" style="cursor:pointer;"/><? } ?>
                                </div>
                            </div>

                          <div id="WT_adminupdatepassAndSave_result_div" > </div>

                        </td>
                         <td width="320" height="470" valign="top" class="ajaxViewMainTableTDForm" style="display:none;">
                            <div class="formDiv">
                                 
                                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
                                    
                                     
									
									<tr >
                                        <td>Image </td>
                                        <td>

                                            <img id="imagePreview" src="" height="100" style="display:none;"	 />
                                            <input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>

                                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>



                                        </td>
                                    </tr> <tr >
                                        <td>Username </td>
                                        <td><input value="" type="text" name="username" id="username" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Password </td>
                                        <td><input value="" type="text" name="password" id="password" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Address </td>
                                        <td><input value="" type="text" name="address" id="address" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Email </td>
                                        <td><input value="" type="text" name="email" id="email" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>MobileNo </td>
                                        <td><input value="" type="text" name="mobileNo" id="mobileNo" class="textboxxx  fWidth "/> </td>
                                    </tr>  <tr style="display:none;" >
                                        <td>Edit Delete Password </td>
                                        <td><input value="" type="text" name="editDeletePassword" id="editDeletePassword" class="textboxxx  fWidth "/> </td>
                                    </tr>  <tr style="display:none;" >
                                        <td>Driving License </td>
                                        <td><input value="" type="text" name="driving_license" id="driving_license" class="textboxxx  fWidth "/> </td>
                                    </tr><tr style="display:none;" >
                                        <td>Idcard Details </td>
                                        <td><input value="" type="text" name="idcard_details" id="idcard_details" class="textboxxx  fWidth "/> </td>
                                    </tr>   

                                    <tr >
                                        <td>Signature  </td>
                                        <td>

                                            <img id="imagePreview_s" src="" height="100" style="display:none;"	 />
                                            <input type="file" name="signature" value=""  id="signature" onchange="os.readURL(this,'imagePreview_s') " style="display:none;"/><br>

                                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('signature');">Edit Signature</span>

                                        </td>
                                    </tr>
                                </table>


                                 

                                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_adminEditAndSave();" /><? } ?>
                                </div>
                            </div>



                        </td>
                    </tr>
                </table>



                <!--   ggggggggggggggg  -->

            </td>
        </tr>
    </table>

    

     
 
    <script>

        
		
		 function WT_adminupdatepassAndSave()  // collect data and send to save
        {
                 
            var formdata = new FormData();
             
            var recent_password= os.getVal('recent_password');
            formdata.append('recent_password',recent_password );
		   
		    var new_password= os.getVal('new_password');
            formdata.append('new_password',new_password );
 
            var url='<? echo $ajaxFilePath ?>?WT_adminupdatepassAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_adminupdatepassAndSave_result_div',url,formdata);

        }

        


        function WT_adminEditAndSave()  // collect data and send to save
        {

            var formdata = new FormData();
            var nameVal= os.getVal('name');
            var imageVal= os.getObj('image').files[0];
            var adminTypeVal= os.getVal('adminType');
            var usernameVal= os.getVal('username');
            var passwordVal= os.getVal('password');
            var addressVal= os.getVal('address');
            var emailVal= os.getVal('email');
            var mobileNoVal= os.getVal('mobileNo');
            var activeVal= os.getVal('active');
            var accessVal= os.getVal('access');
            var editDeletePasswordVal= os.getVal('editDeletePassword');
            var otpVal= os.getVal('otp');
            var joinDateVal= os.getVal('joinDate');
            var driving_licenseVal= os.getVal('driving_license');
            var idcard_detailsVal= os.getVal('idcard_details');
            var provider_typeVal= os.getVal('provider_type');
            var provider_nameVal= os.getVal('provider_name');
            var provider_detailsVal= os.getVal('provider_details');
            var branch_codeVal= os.getVal('branch_code');


            formdata.append('name',nameVal );
            if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
            formdata.append('adminType',adminTypeVal );
            formdata.append('username',usernameVal );
            formdata.append('password',passwordVal );
            formdata.append('address',addressVal );
            formdata.append('email',emailVal );
            formdata.append('mobileNo',mobileNoVal );
            formdata.append('active',activeVal );
            formdata.append('access',accessVal );
            formdata.append('editDeletePassword',editDeletePasswordVal );
            formdata.append('otp',otpVal );
            formdata.append('joinDate',joinDateVal );
            formdata.append('driving_license',driving_licenseVal );
            formdata.append('idcard_details',idcard_detailsVal );
            formdata.append('provider_type',provider_typeVal );
            formdata.append('provider_name',provider_nameVal );
            formdata.append('provider_details',provider_detailsVal );
            formdata.append('branch_code',branch_codeVal );


            var signatureVal= os.getObj('signature').files[0];
            if(signatureVal){  formdata.append('signature',signatureVal,signatureVal.name );}


            var   adminId=os.getVal('adminId');
            formdata.append('adminId',adminId );
            var url='<? echo $ajaxFilePath ?>?WT_adminEditAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_adminReLoadList',url,formdata);

        }

        function WT_adminReLoadList(data) // after edit reload list
        {

           
        }

        
        
       

    </script>
    <style>
        .uk-tab>*>a{ padding-top:2px; padding-bottom:2px;}
		#saaTabLink2c{ display:none;}
    </style>
<? include($site['root-wtos'].'bottom.php'); ?>
