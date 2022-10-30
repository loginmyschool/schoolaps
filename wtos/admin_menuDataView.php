<?
/*
   # wtos version : 1.1
   # main ajax process page : admin_menuAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Admin Menu';
$ajaxFilePath= 'admin_menuAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$os->admin_menu_active_status=array ('Active' => 'Active','Inactive' => 'Inactive');
$os->only_super_admin= array ('Yes' => 'Yes', 'No' => 'No' );

?>


    <table class="container">
        <tr>

            <td  class="middle" style="padding-left:5px;">


                <div class="listHeader"> <?php  echo $listHeader; ?>  </div>

                <!--  ggggggggggggggg   -->


                <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

                    <tr>
                        <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
                            <div class="formDiv">
                                <div class="formDivButton">
                                    <? if($os->access('wtDelete')){ ?>  <? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_admin_menuEditAndSave();" /><? } ?>

                                </div>
                                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

                                    <tr >
                                        <td>Access Key </td>
                                        <td><input value="" type="text" name="access_key" id="access_key" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Title </td>
                                        <td><input value="" type="text" name="title" id="title" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Page Name </td>
                                        <td><input value="" type="text" name="page_name" id="page_name" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Active Status </td>
                                        <td>

                                            <select name="active_status" id="active_status" class="textbox fWidth" ><option value="">Select Active Status</option>	<?
                                                $os->onlyOption($os->admin_menu_active_status);	?></select>	 </td>
                                    </tr><tr >
                                        <td>Icon Small Class </td>
                                        <td><input value="" type="text" name="icon_small_class" id="icon_small_class" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Icon Small Image </td>
                                        <td>

                                            <img id="icon_small_imagePreview" src="" height="100" style="display:none;"	 />
                                            <input type="file" name="icon_small_image" value=""  id="icon_small_image" onchange="os.readURL(this,'icon_small_imagePreview') " style="display:none;"/><br>

                                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('icon_small_image');">Edit Image</span>



                                        </td>
                                    </tr><tr >
                                        <td>Icon Big Class </td>
                                        <td><input value="" type="text" name="icon_big_class" id="icon_big_class" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Icon Big Image </td>
                                        <td>

                                            <img id="icon_big_imagePreview" src="" height="100" style="display:none;"	 />
                                            <input type="file" name="icon_big_image" value=""  id="icon_big_image" onchange="os.readURL(this,'icon_big_imagePreview') " style="display:none;"/><br>

                                            <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('icon_big_image');">Edit Image</span>



                                        </td>
                                    </tr><tr >
                                        <td>Parent Menu </td>
                                        <td> <select name="parent_admin_menu_id" id="parent_admin_menu_id" class="textbox fWidth" ><option value="">Select Parent Menu</option>		  	<?

                                                $os->optionsHTML('','admin_menu_id','title','admin_menu');?>
                                            </select> </td>
                                    </tr><tr >
                                        <td>View Order </td>
                                        <td><input value="" type="text" name="view_order" id="view_order" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Only Super Admin </td>
                                        <td>

                                            <select name="only_super_admin" id="only_super_admin" class="textbox fWidth" ><option value="">Select Only Super Admin</option>	<?
                                                $os->onlyOption($os->only_super_admin);	?></select>	 </td>
                                    </tr>


                                </table>


                                <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                                <input type="hidden"  id="admin_menu_id" value="0" />
                                <input type="hidden"  id="WT_admin_menupagingPageno" value="1" />
                                <div class="formDivButton">
                                    <? if($os->access('wtDelete')){ ?> <input type="button" value="Delete" onclick="WT_admin_menuDeleteRowById('');" />	<? } ?>
                                    &nbsp;

                                    &nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_admin_menuEditAndSave();" /><? } ?>
                                </div>
                            </div>



                        </td>
                        <td valign="top" class="ajaxViewMainTableTDList">

                            <div class="ajaxViewMainTableTDListSearch">
                                Search Key
                                <input type="text" id="searchKey" />   &nbsp;
                                Parent Menu:
                                <select name="parent_admin_menu_id" id="parent_admin_menu_id_s" class="textbox fWidth" ><option value="">Select Parent Menu</option><?$os->optionsHTML('','admin_menu_id','title','admin_menu');?>
                                </select>



                                <div style="display:none" id="advanceSearchDiv">

                                    Access Key: <input type="text" class="wtTextClass" name="access_key_s" id="access_key_s" value="" /> &nbsp;  Title: <input type="text" class="wtTextClass" name="title_s" id="title_s" value="" /> &nbsp;  Page Name: <input type="text" class="wtTextClass" name="page_name_s" id="page_name_s" value="" /> &nbsp;  Active Status:

                                    <select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Active Status</option>	<?
                                        $os->onlyOption($os->admin_menu_active_status);	?></select>
                                    Icon Small Class: <input type="text" class="wtTextClass" name="icon_small_class_s" id="icon_small_class_s" value="" /> &nbsp;   Icon Big Class: <input type="text" class="wtTextClass" name="icon_big_class_s" id="icon_big_class_s" value="" /> &nbsp;
                                    View Order: <input type="text" class="wtTextClass" name="view_order_s" id="view_order_s" value="" /> &nbsp;  Only Super Admin:

                                    <select name="only_super_admin" id="only_super_admin_s" class="textbox fWidth" ><option value="">Select Only Super Admin</option>	<?
                                        $os->onlyOption($os->only_super_admin);	?></select>

                                </div>


                                <input type="button" value="Search" onclick="WT_admin_menuListing();" style="cursor:pointer;"/>
                                <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

                            </div>
                            <div  class="ajaxViewMainTableTDListData" id="WT_admin_menuListDiv">&nbsp; </div>
                            &nbsp;</td>
                    </tr>
                </table>



                <!--   ggggggggggggggg  -->

            </td>
        </tr>
    </table>



    <script>

        function WT_admin_menuListing() // list table searched data get
        {
            var formdata = new FormData();


            var access_key_sVal= os.getVal('access_key_s');
            var title_sVal= os.getVal('title_s');
            var page_name_sVal= os.getVal('page_name_s');
            var active_status_sVal= os.getVal('active_status_s');
            var icon_small_class_sVal= os.getVal('icon_small_class_s');
            var icon_big_class_sVal= os.getVal('icon_big_class_s');
            var parent_admin_menu_id_sVal= os.getVal('parent_admin_menu_id_s');
            var view_order_sVal= os.getVal('view_order_s');
            var only_super_admin_sVal= os.getVal('only_super_admin_s');
            formdata.append('access_key_s',access_key_sVal );
            formdata.append('title_s',title_sVal );
            formdata.append('page_name_s',page_name_sVal );
            formdata.append('active_status_s',active_status_sVal );
            formdata.append('icon_small_class_s',icon_small_class_sVal );
            formdata.append('icon_big_class_s',icon_big_class_sVal );
            formdata.append('parent_admin_menu_id_s',parent_admin_menu_id_sVal );
            formdata.append('view_order_s',view_order_sVal );
            formdata.append('only_super_admin_s',only_super_admin_sVal );



            formdata.append('searchKey',os.getVal('searchKey') );
            formdata.append('showPerPage',os.getVal('showPerPage') );
            var WT_admin_menupagingPageno=os.getVal('WT_admin_menupagingPageno');
            var url='wtpage='+WT_admin_menupagingPageno;
            url='<? echo $ajaxFilePath ?>?WT_admin_menuListing=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_admin_menuListDiv',url,formdata);

        }

        WT_admin_menuListing();
        function  searchReset() // reset Search Fields
        {
            os.setVal('access_key_s','');
            os.setVal('title_s','');
            os.setVal('page_name_s','');
            os.setVal('active_status_s','');
            os.setVal('icon_small_class_s','');
            os.setVal('icon_big_class_s','');
            os.setVal('parent_admin_menu_id_s','');
            os.setVal('view_order_s','');
            os.setVal('only_super_admin_s','');

            os.setVal('searchKey','');
            WT_admin_menuListing();

        }


        function WT_admin_menuEditAndSave()  // collect data and send to save
        {

            var formdata = new FormData();
            var access_keyVal= os.getVal('access_key');
            var titleVal= os.getVal('title');
            var page_nameVal= os.getVal('page_name');
            var active_statusVal= os.getVal('active_status');
            var icon_small_classVal= os.getVal('icon_small_class');
            var icon_small_imageVal= os.getObj('icon_small_image').files[0];
            var icon_big_classVal= os.getVal('icon_big_class');
            var icon_big_imageVal= os.getObj('icon_big_image').files[0];
            var parent_admin_menu_idVal= os.getVal('parent_admin_menu_id');
            var view_orderVal= os.getVal('view_order');
            var only_super_adminVal= os.getVal('only_super_admin');


            formdata.append('access_key',access_keyVal );
            formdata.append('title',titleVal );
            formdata.append('page_name',page_nameVal );
            formdata.append('active_status',active_statusVal );
            formdata.append('icon_small_class',icon_small_classVal );
            if(icon_small_imageVal){  formdata.append('icon_small_image',icon_small_imageVal,icon_small_imageVal.name );}
            formdata.append('icon_big_class',icon_big_classVal );
            if(icon_big_imageVal){  formdata.append('icon_big_image',icon_big_imageVal,icon_big_imageVal.name );}
            formdata.append('parent_admin_menu_id',parent_admin_menu_idVal );
            formdata.append('view_order',view_orderVal );
            formdata.append('only_super_admin',only_super_adminVal );



            var   admin_menu_id=os.getVal('admin_menu_id');
            formdata.append('admin_menu_id',admin_menu_id );
            var url='<? echo $ajaxFilePath ?>?WT_admin_menuEditAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_admin_menuReLoadList',url,formdata);

        }

        function WT_admin_menuReLoadList(data) // after edit reload list
        {

            var d=data.split('#-#');
            var admin_menu_id=parseInt(d[0]);
            if(d[0]!='Error' && admin_menu_id>0)
            {
                os.setVal('admin_menu_id',admin_menu_id);
            }

            if(d[1]!=''){alert(d[1]);}
            WT_admin_menuListing();
        }

        function WT_admin_menuGetById(admin_menu_id) // get record by table primery id
        {
            var formdata = new FormData();
            formdata.append('admin_menu_id',admin_menu_id );
            var url='<? echo $ajaxFilePath ?>?WT_admin_menuGetById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_admin_menuFillData',url,formdata);

        }

        function WT_admin_menuFillData(data)  // fill data form by JSON
        {

         //   os.getObj('access_key').readOnly=true;
        //    os.getObj('title').readOnly=true;
           // os.getObj('access_key').style="background:#dddddd";
          //  os.getObj('title').style="background:#dddddd";

            var objJSON = JSON.parse(data);
            os.setVal('admin_menu_id',parseInt(objJSON.admin_menu_id));

            os.setVal('access_key',objJSON.access_key);
            os.setVal('title',objJSON.title);
            os.setVal('page_name',objJSON.page_name);
            os.setVal('active_status',objJSON.active_status);
            os.setVal('icon_small_class',objJSON.icon_small_class);
            os.setImg('icon_small_imagePreview',objJSON.icon_small_image);
            os.setVal('icon_big_class',objJSON.icon_big_class);
            os.setImg('icon_big_imagePreview',objJSON.icon_big_image);
            os.setVal('parent_admin_menu_id',objJSON.parent_admin_menu_id);
            os.setVal('view_order',objJSON.view_order);
            os.setVal('only_super_admin',objJSON.only_super_admin);


        }

        function WT_admin_menuDeleteRowById(admin_menu_id) // delete record by table id
        {
            var formdata = new FormData();
            if(parseInt(admin_menu_id)<1 || admin_menu_id==''){
                var  admin_menu_id =os.getVal('admin_menu_id');
            }

            if(parseInt(admin_menu_id)<1){ alert('No record Selected'); return;}

            var p =confirm('Are you Sure? You want to delete this record forever.')
            if(p){

                formdata.append('admin_menu_id',admin_menu_id );

                var url='<? echo $ajaxFilePath ?>?WT_admin_menuDeleteRowById=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_admin_menuDeleteRowByIdResults',url,formdata);
            }


        }
        function WT_admin_menuDeleteRowByIdResults(data)
        {
            alert(data);
            WT_admin_menuListing();
        }

        function wtAjaxPagination(pageId,pageNo)// pagination function
        {
            os.setVal('WT_admin_menupagingPageno',parseInt(pageNo));
            WT_admin_menuListing();
        }

    </script>




<? include($site['root-wtos'].'bottom.php'); ?>
