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
$listHeader='List admin';
$ajaxFilePath= 'adminAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';



$return_acc_details=$os->branch_access();

$and_branches_code_IN=$os->val($return_acc_details,'branches_code_IN');




//_d($return_acc_details);
//exit();
unset($os->adminType['Super Admin']);
unset($os->adminType['Global Admin']);
unset($os->adminType['Branch Admin']);

if($os->userDetails['adminType']=='Super Admin')
{
    $os->adminType['Super Admin']='Super Admin';
    $os->adminType['Global Admin']='Global Admin';
    $os->adminType['Branch Admin']='Branch Admin';
}
if($os->userDetails['adminType']=='Global Admin')
{

    $os->adminType['Global Admin']='Global Admin';
    $os->adminType['Branch Admin']='Branch Admin';
}

if($os->userDetails['adminType']=='Branch Admin')
{

    $os->adminType['Branch Admin']='Branch Admin';
}


if ($os->loggedUser()['adminType'] == 'Super Admin') {
    $and_branches_code_IN = '';
} else {
    $and_branches_code_IN = "branch_code $and_branches_code_IN";
}


///////////////////////////////////////////////////

$return_acc=$os->branch_access();
$and_branch='';
 if($os->userDetails['adminType']!='Super Admin')
	{

	  $selected_branch_codes=$return_acc['branches_code_str_query'];
	  $and_branch=" and branch_code IN($selected_branch_codes)";

	 }
$branch_code_arr=array();
$branch_row_q="select   branch_code , branch_name from branch where branch_code!='' $and_branch order by branch_name asc ";
$branch_row_rs= $os->mq($branch_row_q);
while ($branch_row = $os->mfa($branch_row_rs))
{
     $branch_code_arr[$branch_row['branch_code']]=$branch_row['branch_name'].'['.$branch_row['branch_code'].']';
}

/////////////////////////////////////////////////



include('wtosSearchAddAssign.php');

?>


    <table class="container">
        <tr>

            <td  class="middle" style="padding-left:5px;">


                <div class="listHeader"> <?php  echo $listHeader; ?>  </div>

                <!--  ggggggggggggggg   -->


                <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

                    <tr>
                        <td width="320" height="470" valign="top" class="ajaxViewMainTableTDForm">
                            <div class="formDiv">
                                <div class="formDivButton">
                                    <? if($os->access('wtDelete')){ ?><input style="display:none" type="button" value="Delete" onclick="WT_adminDeleteRowById('');" /><? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_adminEditAndSave();" /><? } ?>

                                </div>
                                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
                                   <tr >
                                        <td>Branch   </td>
                                        <td>

                                            <select name="branch_code" id="branch_code" class="select2" ><option value=""> </option>
											  	   <option value=""> </option>
                            						<? $os->onlyOption($branch_code_arr,'');	?>
                                            </select>


							<? if($os->userDetails['adminType']=='Super Admin' && false){ ?>
									 <span id="SAA_D" class="SAA_Container"> </span>

              				 <script>//code333

              				saa.execute('d','SAA_D','branch_code','branch','branch_code','branch_name,branch_code','Branch,Code','branch_code','','');

              				</script>
							<? } ?>

                                        </td>
                                    </tr>
                                    <tr >
                                        <td>Name </td>
                                        <td><input value="" type="text" name="name" id="name" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Image </td>
                                        <td>

                                            <img id="imagePreview" src="" height="100" style="display:none;"	 />
                                            <input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>

                                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>



                                        </td>
                                    </tr><tr >
                                        <td>Type </td>
                                        <td>

                                            <select name="adminType" id="adminType" class="textbox fWidth" ><option value="">Select Type</option>	<?
                                                $os->onlyOption($os->adminType);	?></select>	 </td>
                                    </tr><tr >
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
                                    </tr><tr >
                                        <td>Active Status </td>
                                        <td>

                                            <select name="active" id="active" class="textbox fWidth" ><option value="">Select Active Status</option>	<?
                                                $os->onlyOption($os->adminActive);	?></select>	 </td>
                                    </tr><tr style="display:none;" >
                                        <td>Access </td>
                                        <td><input value="" type="text" name="access" id="access" class="textboxxx  fWidth "/> </td>
                                    </tr><tr style="display:none;" >
                                        <td>Edit Delete Password </td>
                                        <td><input value="" type="text" name="editDeletePassword" id="editDeletePassword" class="textboxxx  fWidth "/> </td>
                                    </tr><tr style="display:none;" >
                                        <td>OTP </td>
                                        <td><input value="" type="text" name="otp" id="otp" class="textboxxx  fWidth "/> </td>
                                    </tr><tr style="display:none" >
                                        <td>Join Date </td>
                                        <td><input value="" type="text" name="joinDate" id="joinDate" class="wtDateClass textbox fWidth"/></td>
                                    </tr><tr style="display:none;" >
                                        <td>Driving License </td>
                                        <td><input value="" type="text" name="driving_license" id="driving_license" class="textboxxx  fWidth "/> </td>
                                    </tr><tr style="display:none;" >
                                        <td>Idcard Details </td>
                                        <td><input value="" type="text" name="idcard_details" id="idcard_details" class="textboxxx  fWidth "/> </td>
                                    </tr><tr style="display:none" >
                                        <td >Provider Type </td>
                                        <td>

                                            <select name="provider_type" id="provider_type" class="textbox fWidth" ><option value="">Select Provider Type</option>	<?
                                                $os->onlyOption($os->provider_type);	?></select>	 </td>
                                    </tr><tr style="display:none" >
                                        <td>Provider Name </td>
                                        <td><input value="" type="text" name="provider_name" id="provider_name" class="textboxxx  fWidth "/> </td>
                                    </tr><tr style="display:none" >
                                        <td>Provider Details </td>
                                        <td><input value="" type="text" name="provider_details" id="provider_details" class="textboxxx  fWidth "/> </td>
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


                                <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                                <input type="hidden"  id="adminId" value="0" />
                                <input type="hidden"  id="WT_adminpagingPageno" value="1" />
                                <div class="formDivButton">
                                    <? if($os->access('wtDelete')){ ?><input style="display:none" type="button" value="Delete" onclick="WT_adminDeleteRowById('');" />	<? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_adminEditAndSave();" /><? } ?>
                                </div>
                            </div>



                        </td>
                        <td valign="top" class="ajaxViewMainTableTDList">

                            <div class="ajaxViewMainTableTDListSearch">
                                Search Key
                                <input type="text" id="searchKey" />   &nbsp;
                                <span  style=" <? if($os->userDetails['adminType']=='Super Admin'){ ?> <? } else{?> display:none <? } ?>" >


								    <select name="branch_code" id="branch_code_s" class="textbox fWidth select2" style="width:200px;"   >

                                        <option value=""> </option>
                            						<? $os->onlyOption($branch_code_arr,'');	?>
                                    </select>




                                </span>

								<? if($os->userDetails['adminType']=='Super Admin' && false){ ?>
									 <span id="SAA_C" class="SAA_Container uk-hidden"> </span>

              				 <script>//code333

              				saa.execute('c','SAA_C','branch_code_s','branch','branch_code','branch_name,branch_code','Branch,Code','branch_code','','');

              				</script>
							<? } ?>

 Type:

                                    <select name="adminType" id="adminType_s" class="textbox fWidth select2" ><option value="">Select Type</option>	<?
                                        $os->onlyOption($os->adminType);	?></select>

                                <div style="display:none" id="advanceSearchDiv">


                                    Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;
                                    Username: <input type="text" class="wtTextClass" name="username_s" id="username_s" value="" /> &nbsp;  Password: <input type="text" class="wtTextClass" name="password_s" id="password_s" value="" /> &nbsp;  Address: <input type="text" class="wtTextClass" name="address_s" id="address_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  MobileNo: <input type="text" class="wtTextClass" name="mobileNo_s" id="mobileNo_s" value="" /> &nbsp;  Active Status:

                                    <select name="active" id="active_s" class="textbox fWidth" ><option value="">Select Active Status</option>	<?
                                        $os->onlyOption($os->adminActive);	?></select>
                                    Access: <input type="text" class="wtTextClass" name="access_s" id="access_s" value="" /> &nbsp;  EditDeletePassword: <input type="text" class="wtTextClass" name="editDeletePassword_s" id="editDeletePassword_s" value="" /> &nbsp;  OTP: <input type="text" class="wtTextClass" name="otp_s" id="otp_s" value="" /> &nbsp;  Driving License: <input type="text" class="wtTextClass" name="driving_license_s" id="driving_license_s" value="" /> &nbsp;  Idcard Details: <input type="text" class="wtTextClass" name="idcard_details_s" id="idcard_details_s" value="" /> &nbsp;  Provider Type:

                                    <select name="provider_type" id="provider_type_s" class="textbox fWidth" ><option value="">Select Provider Type</option>	<?
                                        $os->onlyOption($os->provider_type);	?></select>
                                    Provider Name: <input type="text" class="wtTextClass" name="provider_name_s" id="provider_name_s" value="" /> &nbsp;  Provider Details: <input type="text" class="wtTextClass" name="provider_details_s" id="provider_details_s" value="" /> &nbsp;  Branch:




                                </div>


                                <input type="button" value="Search" onclick="WT_adminListing();" style="cursor:pointer;"/>
                                <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>




                                <!-- upload form  -->
<? if($os->userDetails['adminType']=='Super Admin'  ){ ?>
                                <input class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle "  type="button" value="UPLOAD EXCEL" onclick=" popDialogWH('exel_upload_form','UPLOAD STAFF DATA',700,300);" />
								<? } ?>
                                <div id="exel_upload_form" style="display:none;">

                                    <input type="file" name="application_form_data_file"  id="application_form_data_file" /><br />
                                    <span style="font-size:11px; font-style:italic; color:#EA7500; font-weight:bold">  Only supported extension is .xlsx  . format should be   <a href="<? echo $site['url-wtos'] ?>xcelFormats/student_data_format.xlsx">  <b>Download Format</b> </a> </span><br /><br />


                                    <input type="button" name="button" value="Upload Xcel"  style="cursor:pointer; color:#009900" onclick="form_staff_excel_submit()" />

                                    <div id="file_upload_message" style="color:#FF0000;"> </div>

                                </div>
                                <script>
                                    function popDialogWH(elementId,titles,W,H)
                                    {
                                        os.getObj('application_form_data_file').files[0]='';
                                        os.getObj(elementId).title=titles;
                                        $( function() {
                                            $( "#"+elementId ).dialog({
                                                width: W,
                                                height: H,
                                                modal: true});
                                        } );

                                    }

                                    function form_staff_excel_submit()
                                    {
                                        var formdata = new FormData();
                                        var application_form_data_fileVal='';

                                        if(os.getObj('application_form_data_file').files[0]){
                                            var application_form_data_fileVal= os.getObj('application_form_data_file').files[0];
                                        }



                                        if(application_form_data_fileVal == "")
                                        {
                                            alert('Please select excel file  '); return false;
                                        }
                                        else
                                        {
                                            var p=confirm('Excel File to upload : '+application_form_data_fileVal.name)
                                            if(!p)
                                            {
                                                return false;
                                            }


                                        }


                                        formdata.append('staff_data_entry_direct','OK' );

                                        if(application_form_data_fileVal){
                                            formdata.append('application_form_data_file',application_form_data_fileVal,application_form_data_fileVal.name );
                                        }

                                        var url='<? echo $ajaxFilePath ?>?confirm_staff_excel_upload=OK&';
                                        os.animateMe.div='div_busy';
                                        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                                        os.setAjaxFunc('staff_data_entry_direct_result',url,formdata);


                                    }

                                    function staff_data_entry_direct_result(data)
                                    {
                                        if(!data)
                                        {
                                            $('#exel_upload_form').dialog('close');
                                            WT_historyListing();
                                        }else
                                        {

                                            os.setHtml('file_upload_message',data);
                                        }


                                    }
                                </script>

                                <!-- upload form   end -->

                                <?  if($os->userDetails['adminType']=='Super Admin'){ ?>
                                    <!-- sms sending Block 555556 -->

                                    <div class="uk-float-right uk-margin-small-right">
                                        <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button " uk-toggle="target:#send_sms_modal">
                                            <span uk-icon="icon:  mail; ratio:0.7" class="m-right-s"></span>
                                            SMS
                                        </button>
                                    </div>


                                    <div id="send_sms_modal" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">
                                            <button class="uk-modal-close-default" type="button" uk-close></button>
                                            <h2 class="uk-modal-title">Send SMS</h2>
                                            <div class="uk-margin">
                                                <div class="uk-grid uk-child-width-1-3 uk-grid-collapse" uk-grid>
                     <textarea id="sms_body_template" style="width:500px;">
					 Your User Id is {{username}} and password is {{password}} . Login to http://al-ameen.in/ </textarea>

                                                    Your User Id is {{username}} and password is {{password}}  <br />
                                                    <br /><br />
                                                    ---------keys--------- <br />
                                                    {{registration_no}} <br />
                                                    {{pass_word}} <br />

                                                </div>
                                                <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button uk-margin"
                                                        type="button"
                                                        style="cursor:pointer"
                                                        onclick="send_sms_function_admin();">SEND</button>

                                                <div id="output_send_SMS">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function send_sms_function_admin()
                                        {

                                            var checked_adminIds=   getValuesFromCheckedBox('adminIds[]');
                                            if(checked_adminIds==''){
                                                var p=confirm('Send SMS To All');

                                            }
                                            if(checked_adminIds!=''){
                                                var p=confirm('Send SMS To Selected User');

                                            }

                                            if(p)
                                            {

                                                var formdata = new FormData();

                                                formdata.append('checked_adminIds',checked_adminIds );
                                                var sms_body_template=os.getVal('sms_body_template');

                                                formdata.append('sms_body_template',sms_body_template );
                                                formdata.append('send_sms_function_admin','OK' );
                                                var url='<? echo $ajaxFilePath ?>?send_sms_function_admin=OK&'+url;
                                                os.animateMe.div='div_busy';
                                                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

                                                os.setAjaxFunc('send_sms_function_results',url,formdata);


                                            }


                                        }



                                        function  send_sms_function_results(data)
                                        {
                                            os.setHtml('output_send_SMS',data);
                                        }


                                    </script>

                                    <!-- sms sending Block end 555556 -->

                                <? } ?>

                            </div>
                            <div  class="ajaxViewMainTableTDListData" id="WT_adminListDiv">&nbsp; </div>
                            &nbsp;</td>
                    </tr>
                </table>



                <!--   ggggggggggggggg  -->

            </td>
        </tr>
    </table>

    <div id="manageAccessData_data_form_modal" class="uk-modal-full " uk-modal>
        <div id="manageAccessData_data_form_div" class="uk-modal-dialog  ">
            Data form
        </div>
    </div>

    <div id="manageAccessData_data_list_div">Data list
    </div>

    <script>

        function WT_adminListing() // list table searched data get
        {
            var formdata = new FormData();


            var name_sVal= os.getVal('name_s');
            var adminType_sVal= os.getVal('adminType_s');
            var username_sVal= os.getVal('username_s');
            var password_sVal= os.getVal('password_s');
            var address_sVal= os.getVal('address_s');
            var email_sVal= os.getVal('email_s');
            var mobileNo_sVal= os.getVal('mobileNo_s');
            var active_sVal= os.getVal('active_s');
            var access_sVal= os.getVal('access_s');
            var editDeletePassword_sVal= os.getVal('editDeletePassword_s');
            var otp_sVal= os.getVal('otp_s');
            var driving_license_sVal= os.getVal('driving_license_s');
            var idcard_details_sVal= os.getVal('idcard_details_s');
            var provider_type_sVal= os.getVal('provider_type_s');
            var provider_name_sVal= os.getVal('provider_name_s');
            var provider_details_sVal= os.getVal('provider_details_s');
            var branch_code_sVal= os.getVal('branch_code_s');
            formdata.append('name_s',name_sVal );
            formdata.append('adminType_s',adminType_sVal );
            formdata.append('username_s',username_sVal );
            formdata.append('password_s',password_sVal );
            formdata.append('address_s',address_sVal );
            formdata.append('email_s',email_sVal );
            formdata.append('mobileNo_s',mobileNo_sVal );
            formdata.append('active_s',active_sVal );
            formdata.append('access_s',access_sVal );
            formdata.append('editDeletePassword_s',editDeletePassword_sVal );
            formdata.append('otp_s',otp_sVal );
            formdata.append('driving_license_s',driving_license_sVal );
            formdata.append('idcard_details_s',idcard_details_sVal );
            formdata.append('provider_type_s',provider_type_sVal );
            formdata.append('provider_name_s',provider_name_sVal );
            formdata.append('provider_details_s',provider_details_sVal );
            formdata.append('branch_code_s',branch_code_sVal );



            formdata.append('searchKey',os.getVal('searchKey') );
            formdata.append('showPerPage',os.getVal('showPerPage') );
            var WT_adminpagingPageno=os.getVal('WT_adminpagingPageno');
            var url='wtpage='+WT_adminpagingPageno;
            url='<? echo $ajaxFilePath ?>?WT_adminListing=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_adminListDiv',url,formdata);

        }

        WT_adminListing();
        function  searchReset() // reset Search Fields
        {
            os.setVal('name_s','');
            os.setVal('adminType_s','');
            os.setVal('username_s','');
            os.setVal('password_s','');
            os.setVal('address_s','');
            os.setVal('email_s','');
            os.setVal('mobileNo_s','');
            os.setVal('active_s','');
            os.setVal('access_s','');
            os.setVal('editDeletePassword_s','');
            os.setVal('otp_s','');
            os.setVal('driving_license_s','');
            os.setVal('idcard_details_s','');
            os.setVal('provider_type_s','');
            os.setVal('provider_name_s','');
            os.setVal('provider_details_s','');
            os.setVal('branch_code_s','');

            os.setVal('searchKey','');
            WT_adminListing();

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

            var d=data.split('#-#');
            var adminId=parseInt(d[0]);
            if(d[0]!='Error' && adminId>0)
            {
                os.setVal('adminId',adminId);
            }

            if(d[1]!=''){alert(d[1]);}
            WT_adminListing();
        }

        function WT_adminGetById(adminId) // get record by table primery id
        {
            var formdata = new FormData();
            formdata.append('adminId',adminId );
            var url='<? echo $ajaxFilePath ?>?WT_adminGetById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_adminFillData',url,formdata);

        }

        function WT_adminFillData(data)  // fill data form by JSON
        {

            var objJSON = JSON.parse(data);
            os.setVal('adminId',parseInt(objJSON.adminId));

            os.setVal('name',objJSON.name);
            os.setImg('imagePreview',objJSON.image);
            os.setVal('adminType',objJSON.adminType);
            os.setVal('username',objJSON.username);
            os.setVal('password',objJSON.password);
            os.setVal('address',objJSON.address);
            os.setVal('email',objJSON.email);
            os.setVal('mobileNo',objJSON.mobileNo);
            os.setVal('active',objJSON.active);
            os.setVal('access',objJSON.access);
            os.setVal('editDeletePassword',objJSON.editDeletePassword);
            os.setVal('otp',objJSON.otp);
            os.setVal('joinDate',objJSON.joinDate);
            os.setVal('driving_license',objJSON.driving_license);
            os.setVal('idcard_details',objJSON.idcard_details);
            os.setVal('provider_type',objJSON.provider_type);
            os.setVal('provider_name',objJSON.provider_name);
            os.setVal('provider_details',objJSON.provider_details);
            os.setVal('branch_code',objJSON.branch_code);


            os.setImg('imagePreview_s',objJSON.signature);



        }

        function WT_adminDeleteRowById(adminId) // delete record by table id
        {
            var formdata = new FormData();
            if(parseInt(adminId)<1 || adminId==''){
                var  adminId =os.getVal('adminId');
            }

            if(parseInt(adminId)<1){ alert('No record Selected'); return;}

            var p =confirm('Are you Sure? You want to delete this record forever.')
            if(p){

                formdata.append('adminId',adminId );

                var url='<? echo $ajaxFilePath ?>?WT_adminDeleteRowById=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_adminDeleteRowByIdResults',url,formdata);
            }


        }
        function WT_adminDeleteRowByIdResults(data)
        {
            alert(data);
            WT_adminListing();
        }

        function wtAjaxPagination(pageId,pageNo)// pagination function
        {
            os.setVal('WT_adminpagingPageno',parseInt(pageNo));
            WT_adminListing();
        }

        function manageAccessData_ajax(adminId,wt_action)
        {


            var formdata = new FormData();
            var data_access='';
            if(wt_action!='')
            {
                //var data_access= getValuesFromCheckedBox('branchaccess[]');

                document.querySelectorAll(".access_checkbox, .second_level_access_checkbox").forEach(function (box){
                    if(box.checked){
                        formdata.append(box.name, box.value);
                    }
                });

                document.querySelectorAll(".verification_access_checkbox").forEach(function (box){
                    if(box.checked){
                        formdata.append(box.name, box.value);
                    }
                })

            }


            formdata.append('data_access',data_access );
            formdata.append('adminId',adminId );
            formdata.append('manageAccessData_ajax','OK' );
            formdata.append('wt_action',wt_action);
            var url='<? echo $ajaxFilePath ?>?manageAccessData_ajax=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">�Please wait. Working...</div></div>';
            os.setAjaxFunc('manageAccessData_result',url,formdata);

        }

        function manageAccessData_result(data)
        {

            var content_data =	getData(data,'##--manageAccessData_data_form--##');
            os.setHtml('manageAccessData_data_form_div',content_data);
            UIkit.modal("#manageAccessData_data_form_modal").show();

            var content_data = getData(data,'##--manageAccessData_data_list--##');
            os.setHtml('manageAccessData_data_list_div',content_data);
            //popDialog('manageAccessData_data_form_div','Access',{'width':'1000','height':'580'});
        }

        function manageGlobalAccessData_ajax(adminId,wt_action)
        {


            var formdata = new FormData();
            var data_access='';
            if(wt_action!='')
            {
                document.querySelectorAll(".global_access_checkbox").forEach(function (box){
                    if(box.checked){
                        formdata.append(box.name, box.value);
                    }
                });
            }


            formdata.append('data_access',data_access );
            formdata.append('adminId',adminId );
            formdata.append('manageGlobalAccessData_ajax','OK' );
            formdata.append('wt_action',wt_action);
            var url='<? echo $ajaxFilePath ?>?manageGlobalAccessData_ajax=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">�Please wait. Working...</div></div>';
            os.setAjaxFunc('manageGlobalAccessData_result',url,formdata);

        }

        function manageGlobalAccessData_result(data)
        {

            var content_data =	getData(data,'##--manageAccessData_data_form--##');
            os.setHtml('manageAccessData_data_form_div',content_data);
            UIkit.modal("#manageAccessData_data_form_modal").show();

            var content_data = getData(data,'##--manageAccessData_data_list--##');
            os.setHtml('manageAccessData_data_list_div',content_data);
            //popDialog('manageAccessData_data_form_div','Access',{'width':'1000','height':'580'});
        }

        function select_deselect_all(groupclass,obj)
        {
            $("."+groupclass).prop("checked", obj.checked);
        }



    </script>
    <style>
        .uk-tab>*>a{ padding-top:2px; padding-bottom:2px;}
		#saaTabLink2c{ display:none;}
    </style>
<? include($site['root-wtos'].'bottom.php'); ?>
