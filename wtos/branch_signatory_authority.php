<?
/*
   # wtos version : 1.1
   # main ajax process page : branch_signatory_authority_ajax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
global $site,$os;
$pluginName='';
$listHeader='Branch Signatory Authority';
$ajaxFilePath= 'branch_signatory_authority_ajax.php';
$access_key = "Branch Signatory Authority";
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$selected_branch_code = $os->get("branch_code_s");
?>

<div class="title-bar uk-flex uk-flex-middle p-m">
    <h4 style="flex: 1"><?= $listHeader?></h4>
    <form onchange="this.submit()" style="justify-self: end">

        <select name="branch_code_s" id="branch_code_s" class="select2">
            <option value="">Select Branch</option>
            <? $os->onlyOption($os->get_branches_by_access_name($access_key), $selected_branch_code)?>
        </select>

    </form>
    <div style="clear: both"></div>
</div>

<table class="content">
    <tr>

        <td  class="middle" style="padding-left:5px;">

            <!--  ggggggggggggggg   -->


            <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

                <tr>
                    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
                        <div class="formDiv">
                            <div class="formDivButton">
                                <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_branch_signatory_authorityDeleteRowById('');" /><? } ?>
                                &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                &nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_branch_signatory_authorityEditAndSave();" /><? } ?>

                            </div>
                            <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
                                <tr>
                                    <td>Key </td>
                                    <td><select type="text" name="head_key" id="head_key" class="textboxxx  fWidth ">
                                            <? $os->onlyOption($os->signatory_authority_keys)?>
                                        </select> </td>
                                </tr>
                                <tr class="uk-hidden">
                                    <td>Branch </td>
                                    <td>

                                        <input name="branch_code" id="branch_code" value="<?=$selected_branch_code?>" class="textbox fWidth">
                                    </td>
                                </tr>
                                <tr >
                                    <td>Admin </td>
                                    <td>
                                        <select type="text" name="adminId" id="adminId" class="select2">
                                            <option></option>
                                            <?foreach ($os->get_admins($selected_branch_code) as $adminId=>$admin){?>
                                                <option value="<?=$adminId?>" ><?=$admin["name"]?></option>
                                            <?}?>

                                        </select>
                                    </td>
                                </tr>
                                <tr >
                                    <td>Class </td>
                                    <td>

                                        <select name="class" id="class" class="textbox fWidth" ><option value="">Select Class</option>
                                            <? foreach ($os->board as $key=>$value){
                                                ?>
                                                <optgroup label="<?=$value?>">
                                                    <?foreach ($os->board_class[$key] as $class){?>
                                                        <option value="<?=$class?>"><?=$os->classList[$class]?></option>
                                                    <?}?>
                                                </optgroup>
                                                <?
                                            }	?>
                                        </select>	 </td>
                                </tr>
                                <tr >
                                    <td>Gender </td>
                                    <td>

                                        <select name="gender" id="gender" class="textbox fWidth" ><option value="">Select Gender</option>	<?
                                            $os->onlyOption($os->gender);	?></select>	 </td>
                                </tr>


                            </table>

                            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                            <input type="hidden"  id="branch_signatory_authority_id" value="0" />
                            <input type="hidden"  id="WT_branch_signatory_authoritypagingPageno" value="1" />
                            <div class="formDivButton">
                                <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_branch_signatory_authorityDeleteRowById('');" />	<? } ?>
                                &nbsp;&nbsp;
                                &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_branch_signatory_authorityEditAndSave();" /><? } ?>
                            </div>
                        </div>



                    </td>
                    <td valign="top" class="ajaxViewMainTableTDList">

                        <div class="ajaxViewMainTableTDListSearch">
                            <input type="text" id="searchKey" class="uk-hidden" />

                            <select  class="uk-hidden" name="adminId_s" id="adminId_s">
                                <option></option>
                                <?foreach ($os->get_admins($selected_branch_code) as $adminId=>$admin){?>
                                    <option value="<?=$adminId?>" ><?=$admin["name"]?></option>
                                <?}?>
                            </select>


                            <select name="class" id="class_s" class="textbox fWidth" >
                                <option value="">Select Class</option>
                                <? foreach ($os->board as $key=>$value){
                                    ?>
                                    <optgroup label="<?=$value?>">
                                        <?foreach ($os->board_class[$key] as $class){?>
                                            <option value="<?=$class?>"><?=$os->classList[$class]?></option>
                                        <?}?>
                                    </optgroup>
                                <?}	?>
                            </select>


                            <select name="gender" id="gender_s" class="textbox fWidth" >
                                <option value="">Select Gender</option>
                                <? $os->onlyOption($os->gender);	?>
                            </select>
                            <select class="wtTextClass" name="head_key_s" id="head_key_s">
                                <option value="">Select Key head</option>
                                <? $os->onlyOption($os->signatory_authority_keys)?>
                            </select>




                            <button type="button" value="search" onclick="WT_branch_signatory_authorityListing();"
                                    class="uk-button congested-form uk-secondary-button"> Search</button>
                            <button type="button" value="Reset" onclick="searchReset();"
                                    class="uk-button congested-form uk-secondary-button">Reset</button>

                        </div>
                        <div  class="ajaxViewMainTableTDListData" id="WT_branch_signatory_authorityListDiv">&nbsp; </div>
                        &nbsp;</td>
                </tr>
            </table>



            <!--   ggggggggggggggg  -->

        </td>
    </tr>
</table>
<script>

    function WT_branch_signatory_authorityListing() // list table searched data get
    {
        var formdata = new FormData();


        var adminId_sVal= os.getVal('adminId_s');
        var branch_code_sVal= "<?=$selected_branch_code?>";
        var class_sVal= os.getVal('class_s');
        var gender_sVal= os.getVal('gender_s');
        var head_key_sVal= os.getVal('head_key_s');
        formdata.append('adminId_s',adminId_sVal );
        formdata.append('branch_code_s',branch_code_sVal );
        formdata.append('class_s',class_sVal );
        formdata.append('gender_s',gender_sVal );
        formdata.append('head_key_s',head_key_sVal );



        formdata.append('searchKey',os.getVal('searchKey') );
        formdata.append('showPerPage',os.getVal('showPerPage') );
        var WT_branch_signatory_authoritypagingPageno=os.getVal('WT_branch_signatory_authoritypagingPageno');
        var url='wtpage='+WT_branch_signatory_authoritypagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_branch_signatory_authorityListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_branch_signatory_authorityListDiv',url,formdata);

    }

    WT_branch_signatory_authorityListing();
    function  searchReset() // reset Search Fields
    {
        os.setVal('adminId_s','');
        //os.setVal('branch_code_s','');
        os.setVal('class_s','');
        os.setVal('gender_s','');
        os.setVal('head_key_s','');

        os.setVal('searchKey','');
        WT_branch_signatory_authorityListing();

    }


    function WT_branch_signatory_authorityEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var adminIdVal= os.getVal('adminId');
        var branch_codeVal= "<?=$selected_branch_code?>";
        var classVal= os.getVal('class');
        var genderVal= os.getVal('gender');
        var head_keyVal= os.getVal('head_key');


        formdata.append('adminId',adminIdVal );
        formdata.append('branch_code',branch_codeVal );
        formdata.append('class',classVal );
        formdata.append('gender',genderVal );
        formdata.append('head_key',head_keyVal );


        if(os.check.empty('adminId','Please Add Admin')==false){ return false;}
        //if("<?=$selected_branch_code?>" == ""){ return false;}
        //if(os.check.empty('class','Please Add Class')==false){ return false;}
        //if(os.check.empty('gender','Please Add Gender')==false){ return false;}
        if(os.check.empty('head_key','Please Add Key')==false){ return false;}

        var   branch_signatory_authority_id=os.getVal('branch_signatory_authority_id');
        formdata.append('branch_signatory_authority_id',branch_signatory_authority_id );
        var url='<? echo $ajaxFilePath ?>?WT_branch_signatory_authorityEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_branch_signatory_authorityReLoadList',url,formdata);

    }

    function WT_branch_signatory_authorityReLoadList(data) // after edit reload list
    {

        var d=data.split('#-#');
        var branch_signatory_authority_id=parseInt(d[0]);
        if(d[0]!='Error' && branch_signatory_authority_id>0)
        {
            os.setVal('branch_signatory_authority_id',branch_signatory_authority_id);
        }

        if(d[1]!=''){alert(d[1]);}
        WT_branch_signatory_authorityListing();
    }

    function WT_branch_signatory_authorityGetById(branch_signatory_authority_id) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('branch_signatory_authority_id',branch_signatory_authority_id );
        var url='<? echo $ajaxFilePath ?>?WT_branch_signatory_authorityGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_branch_signatory_authorityFillData',url,formdata);

    }

    function WT_branch_signatory_authorityFillData(data)  // fill data form by JSON
    {

        var objJSON = JSON.parse(data);
        os.setVal('branch_signatory_authority_id',parseInt(objJSON.branch_signatory_authority_id));

        os.setVal('adminId',objJSON.adminId);
        os.setVal('branch_code',objJSON.branch_code);
        os.setVal('class',objJSON.class);
        os.setVal('gender',objJSON.gender);
        os.setVal('head_key',objJSON.head_key);


    }

    function WT_branch_signatory_authorityDeleteRowById(branch_signatory_authority_id) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(branch_signatory_authority_id)<1 || branch_signatory_authority_id==''){
            var  branch_signatory_authority_id =os.getVal('branch_signatory_authority_id');
        }

        if(parseInt(branch_signatory_authority_id)<1){ alert('No record Selected'); return;}

        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){

            formdata.append('branch_signatory_authority_id',branch_signatory_authority_id );

            var url='<? echo $ajaxFilePath ?>?WT_branch_signatory_authorityDeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_branch_signatory_authorityDeleteRowByIdResults',url,formdata);
        }


    }
    function WT_branch_signatory_authorityDeleteRowByIdResults(data)
    {
        alert(data);
        WT_branch_signatory_authorityListing();
    }

    function wtAjaxPagination(pageId,pageNo)// pagination function
    {
        os.setVal('WT_branch_signatory_authoritypagingPageno',parseInt(pageNo));
        WT_branch_signatory_authorityListing();
    }






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
