<?
/*
   # wtos version : 1.1
   # main ajax process page : school_settingAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Setting';
$ajaxFilePath= 'school_settingAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

?>

<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove ">
                <?php  echo $listHeader; ?>
            </h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button uk-hidden">ADD NEW</button>
            <div class="uk-inline uk-hidden">
                <span class="uk-form-icon  uk-background-muted p-left-m p-right-m" style="width: auto; top: 1px; left: 1px; height: calc(100% - 2px)">SESSION</span>
                <select name="asession"
                        id="asession_s"
                        style="padding-left: 85px"
                        class="uk-select uk-border-rounded congested-form  p-right-xl text-m" >
                    <option value="">
                    </option>
                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select>
            </div>
        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <div class="ajaxViewMainTableTDListSearch uk-hidden">
            Search Key
            <input type="text" id="searchKey" />   &nbsp;



            <div style="display:none" id="advanceSearchDiv">


            </div>


            <input type="button" value="Search" onclick="WT_school_settingListing();" style="cursor:pointer;"/>
            <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

        </div>
        <div id="WT_school_settingListDiv">&nbsp; </div>
    </div>
</div>
<div id="formDiv" uk-modal>
    <div class="uk-modal-dialog uk-width-medium uk-modal-body">
        <button class="uk-modal-close-default" uk-close></button>
        <table class="uk-table uk-table-justify congested-table">

            <tr >
                <td colspan="2">
                    <div class="uk-text-center">
                        <img id="logoimagePreview" src="" height="100" style="display:none;"	 />
                        <input type="file" name="logoimage" value=""  id="logoimage" onchange="os.readURL(this,'logoimagePreview') " style="display:none;"/><br>
                        <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('logoimage');">Edit Image</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    School name
                    <input value="" type="text" name="school_name" id="school_name" class="uk-input uk-border-rounded congested-form"/>
                </td>
            </tr>
            <tr >
                <td colspan="2">
                    <label>Tagline </label>
                    <input value="" type="text" name="tagline" id="tagline" class="uk-input uk-border-rounded congested-form"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>schoolCode </label>
                    <input value="" type="text" name="schoolCode" id="schoolCode" class="uk-input uk-border-rounded congested-form"/>
                </td>
            </tr>

            <tr >
                <td colspan="2">
                    <label>Address </label>
                    <textarea type="text" name="address" id="address" class="uk-textarea uk-border-rounded congested-form" style="height: 45px!important; max-height: inherit"></textarea>
                </td>
            </tr>
            <tr >
                <td style="width: 90px">
                    <label>Contact </label>
                    <input value="" type="text" name="contact" id="contact" class="uk-input uk-border-rounded congested-form"/>
                </td>

                <td>
                    <label>Email </label>
                    <input value="" type="text" name="email" id="email" class="uk-input uk-border-rounded congested-form"/>
                </td>
            </tr>
        </table>
        <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
        <input type="hidden"  id="school_setting_id" value="0" />
        <input type="hidden"  id="WT_school_settingpagingPageno" value="1" />
        <div class="uk-text-right">
            <? if($os->access('wtDelete')){ ?><input class="uk-hidden" type="button" value="Delete" onclick="WT_school_settingDeleteRowById('');" />	<? } ?>
            <? if($os->access('wtEdit')){ ?>
                <button class="uk-button uk-button-small uk-secondary-button uk-border-rounded" type="button" value="Save" onclick="WT_school_settingEditAndSave();" >Save</button>
            <? } ?>
        </div>
    </div>
</div>



<script>

    function WT_school_settingListing() // list table searched data get
    {
        var formdata = new FormData();





        formdata.append('searchKey',os.getVal('searchKey') );
        formdata.append('showPerPage',os.getVal('showPerPage') );
        var WT_school_settingpagingPageno=os.getVal('WT_school_settingpagingPageno');
        var url='wtpage='+WT_school_settingpagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_school_settingListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_school_settingListDiv',url,formdata);

    }

    WT_school_settingListing();
    function  searchReset() // reset Search Fields
    {

        os.setVal('searchKey','');
        WT_school_settingListing();

    }


    function WT_school_settingEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var school_nameVal= os.getVal('school_name');
        var addressVal= os.getVal('address');
        var contactVal= os.getVal('contact');
        var emailVal= os.getVal('email');
        var schoolCodeVal= os.getVal('schoolCode');
        var taglineVal= os.getVal('tagline');
        var logoimageVal= os.getObj('logoimage').files[0];


        formdata.append('school_name',school_nameVal );
        formdata.append('address',addressVal );
        formdata.append('contact',contactVal );
        formdata.append('email',emailVal );
        formdata.append('schoolCode',schoolCodeVal );
        formdata.append('tagline',taglineVal );
        if(logoimageVal){  formdata.append('logoimage',logoimageVal,logoimageVal.name );}


        if(os.check.empty('school_name','Please Add School name')==false){ return false;}
        if(os.check.empty('address','Please Add Address')==false){ return false;}
        if(os.check.empty('contact','Please Add Contact')==false){ return false;}
        if(os.check.empty('email','Please Add Email')==false){ return false;}
        if(os.check.empty('schoolCode','Please Add schoolCode')==false){ return false;}
        if(os.check.empty('tagline','Please Add Tagline')==false){ return false;}

        var   school_setting_id=os.getVal('school_setting_id');
        formdata.append('school_setting_id',school_setting_id );
        var url='<? echo $ajaxFilePath ?>?WT_school_settingEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_school_settingReLoadList',url,formdata);

    }

    function WT_school_settingReLoadList(data) // after edit reload list
    {

        var d=data.split('#-#');
        var school_setting_id=parseInt(d[0]);
        if(d[0]!='Error' && school_setting_id>0)
        {
            os.setVal('school_setting_id',school_setting_id);
        }

        if(d[1]!=''){alert(d[1]);}
        WT_school_settingListing();
        UIkit.modal('#formDiv').hide();
    }

    function WT_school_settingGetById(school_setting_id) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('school_setting_id',school_setting_id );
        var url='<? echo $ajaxFilePath ?>?WT_school_settingGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_school_settingFillData',url,formdata);

    }

    function WT_school_settingFillData(data)  // fill data form by JSON
    {

        var objJSON = JSON.parse(data);
        os.setVal('school_setting_id',parseInt(objJSON.school_setting_id));

        os.setVal('school_name',objJSON.school_name);
        os.setVal('address',objJSON.address);
        os.setVal('contact',objJSON.contact);
        os.setVal('email',objJSON.email);
        os.setVal('schoolCode',objJSON.schoolCode);
        os.setVal('tagline',objJSON.tagline);
        os.setImg('logoimagePreview',objJSON.logoimage);


        UIkit.modal('#formDiv').show();
    }

    function WT_school_settingDeleteRowById(school_setting_id) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(school_setting_id)<1 || school_setting_id==''){
            var  school_setting_id =os.getVal('school_setting_id');
        }

        if(parseInt(school_setting_id)<1){ alert('No record Selected'); return;}

        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){

            formdata.append('school_setting_id',school_setting_id );

            var url='<? echo $ajaxFilePath ?>?WT_school_settingDeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_school_settingDeleteRowByIdResults',url,formdata);
        }


    }
    function WT_school_settingDeleteRowByIdResults(data)
    {
        alert(data);
        WT_school_settingListing();
    }

    function wtAjaxPagination(pageId,pageNo)// pagination function
    {
        os.setVal('WT_school_settingpagingPageno',parseInt(pageNo));
        WT_school_settingListing();
    }


</script>




<? include($site['root-wtos'].'bottom.php'); ?>
