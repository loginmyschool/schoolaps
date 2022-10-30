<?
/*
   # wtos version : 1.1
   # main ajax process page : global_templateAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List global_template';
$ajaxFilePath= 'global_templateAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

?>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>

        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <button
                    class="uk-button uk-border-rounded uk-button-small  uk-secondary-button uk-hidden"
                    uk-toggle="target: #add-form-modal">
                ADD NEW
            </button>
        </div>
    </div>

</div>
<div class="content">
    <div class="item with-header-footer" style="max-width: 300px; min-width: 300px">
        <div class="item-header p-m">
            <? if($os->access('wtDelete')){ ?>
                <input class="uk-button uk-border-rounded uk-button-small uk-button-danger" type="button" value="Delete" onclick="WT_global_templateDeleteRowById('');" />
            <? } ?>
            <input class="uk-button uk-border-rounded uk-button-small uk-secondary-button" type="button" value="New" onclick="javascript:window.location='';" />
            <? if($os->access('wtEdit')){ ?>
                <input class="uk-button uk-border-rounded uk-button-small uk-theme-button" type="button" value="Save" onclick="WT_global_templateEditAndSave();" />
            <? } ?>
        </div>
        <div class="item-content p-m">

            <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

                <tr >
                    <td>Name </td>
                    <td><input value="" type="text" name="name" id="name" class="uk-input uk-border-rounded congested-form "/> </td>
                </tr><tr >
                    <td>Active Status </td>
                    <td>

                        <select name="active_status" id="active_status" class="uk-select uk-border-rounded congested-form " >
                            <option value="">Select Active Status</option>
                            <? $os->onlyOption($os->global_template_status);	?>
                        </select>
                    </td>
                </tr>
                <tr >
                    <td>Type </td>
                    <td>

                        <select name="type" id="type" class="uk-select uk-border-rounded congested-form " ><option value="">Select Type</option>	<?
                            $os->onlyOption($os->global_template_type);	?></select>	 </td>
                </tr><tr >
                    <td>Template Page </td>
                    <td><input value="" type="text" name="template_page" id="template_page" class="uk-input uk-border-rounded congested-form "/>
                        <a href="javascript:void(0);" onclick="selectTemplateFromStore()" >Select from store</a>
                    </td>
                </tr><tr >
                    <td>Background Image </td>
                    <td>

                        <img id="backgroundImagePreview" src=""  style="display:none; height: 100px"	 />
                        <input type="file" name="backgroundImage" value=""  id="backgroundImage" onchange="os.readURL(this,'backgroundImagePreview') " style="display:none;"/><br>
                        <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('backgroundImage');">Edit Image</span>
                    </td>
                </tr>


            </table>


            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
            <input type="hidden"  id="global_template_id" value="0" />
            <input type="hidden"  id="WT_global_templatepagingPageno" value="1" />

        </div>
        <div class="item-footer p-m">
            <? if($os->access('wtDelete')){ ?>
                <input class="uk-button uk-border-rounded uk-button-small uk-button-danger" type="button" value="Delete" onclick="WT_global_templateDeleteRowById('');" />
            <? } ?>
            <input class="uk-button uk-border-rounded uk-button-small uk-secondary-button" type="button" value="New" onclick="javascript:window.location='';" />
            <? if($os->access('wtEdit')){ ?>
                <input class="uk-button uk-border-rounded uk-button-small uk-theme-button" type="button" value="Save" onclick="WT_global_templateEditAndSave();" />
            <? } ?>
        </div>
    </div>
    <div class="item p-m">

        <div class="uk-margin-small" style="">

            <div class="uk-inline" uk-tooltip="Search key">
                <span class="uk-form-icon" uk-icon="icon: search; ratio:0.7"></span>
                <input class="uk-input uk-border-rounded uk-form-small "   type="text" id="searchKey" placeholder="Search Keyword" />
            </div>

            <button class="uk-button uk-border-rounded uk-button-small  uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="WT_global_templateListing();">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded uk-button-small  uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>

            <div>
                <!--Hidden filters-->
                <div class="uk-hidden" id="advanceSearchDiv">

                    Name: <input type="text" class="wtTextClass" name="name_s" id="name_s" value="" /> &nbsp;  Active Status:

                    <select name="active_status" id="active_status_s" class="textbox fWidth" ><option value="">Select Active Status</option>	<?
                        $os->onlyOption($os->global_template_status);	?></select>
                    Type:

                    <select name="type" id="type_s" class="textbox fWidth" ><option value="">Select Type</option>	<?
                        $os->onlyOption($os->global_template_type);	?></select>
                    Template Page: <input type="text" class="wtTextClass" name="template_page_s" id="template_page_s" value="" /> &nbsp;
                </div>

            </div>

        </div>
        <div id="WT_global_templateListDiv"></div>
    </div>
</div>


<div id="templateSetting_DIV"> </div>



<script>

    function WT_global_templateListing() // list table searched data get
    {
        var formdata = new FormData();


        var name_sVal= os.getVal('name_s');
        var active_status_sVal= os.getVal('active_status_s');
        var type_sVal= os.getVal('type_s');
        var template_page_sVal= os.getVal('template_page_s');
        formdata.append('name_s',name_sVal );
        formdata.append('active_status_s',active_status_sVal );
        formdata.append('type_s',type_sVal );
        formdata.append('template_page_s',template_page_sVal );



        formdata.append('searchKey',os.getVal('searchKey') );
        formdata.append('showPerPage',os.getVal('showPerPage') );
        var WT_global_templatepagingPageno=os.getVal('WT_global_templatepagingPageno');
        var url='wtpage='+WT_global_templatepagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_global_templateListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_global_templateListDiv',url,formdata);

    }

    WT_global_templateListing();
    function  searchReset() // reset Search Fields
    {
        os.setVal('name_s','');
        os.setVal('active_status_s','');
        os.setVal('type_s','');
        os.setVal('template_page_s','');

        os.setVal('searchKey','');
        WT_global_templateListing();

    }


    function WT_global_templateEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var nameVal= os.getVal('name');
        var active_statusVal= os.getVal('active_status');
        var typeVal= os.getVal('type');
        var template_pageVal= os.getVal('template_page');
        var backgroundImageVal= os.getObj('backgroundImage').files[0];


        formdata.append('name',nameVal );
        formdata.append('active_status',active_statusVal );
        formdata.append('type',typeVal );
        formdata.append('template_page',template_pageVal );
        if(backgroundImageVal){  formdata.append('backgroundImage',backgroundImageVal,backgroundImageVal.name );}



        var   global_template_id=os.getVal('global_template_id');
        formdata.append('global_template_id',global_template_id );
        var url='<? echo $ajaxFilePath ?>?WT_global_templateEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_global_templateReLoadList',url,formdata);

    }

    function WT_global_templateReLoadList(data) // after edit reload list
    {

        var d=data.split('#-#');
        var global_template_id=parseInt(d[0]);
        if(d[0]!='Error' && global_template_id>0)
        {
            os.setVal('global_template_id',global_template_id);
        }

        if(d[1]!=''){alert(d[1]);}
        WT_global_templateListing();
    }

    function WT_global_templateGetById(global_template_id) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('global_template_id',global_template_id );
        var url='<? echo $ajaxFilePath ?>?WT_global_templateGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_global_templateFillData',url,formdata);

    }

    function WT_global_templateFillData(data)  // fill data form by JSON
    {

        var objJSON = JSON.parse(data);
        os.setVal('global_template_id',parseInt(objJSON.global_template_id));

        os.setVal('name',objJSON.name);
        os.setVal('active_status',objJSON.active_status);
        os.setVal('type',objJSON.type);
        os.setVal('template_page',objJSON.template_page);
        os.setImg('backgroundImagePreview',objJSON.backgroundImage);


    }

    function WT_global_templateDeleteRowById(global_template_id) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(global_template_id)<1 || global_template_id==''){
            var  global_template_id =os.getVal('global_template_id');
        }

        if(parseInt(global_template_id)<1){ alert('No record Selected'); return;}

        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){

            formdata.append('global_template_id',global_template_id );

            var url='<? echo $ajaxFilePath ?>?WT_global_templateDeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_global_templateDeleteRowByIdResults',url,formdata);
        }


    }
    function WT_global_templateDeleteRowByIdResults(data)
    {
        alert(data);
        WT_global_templateListing();
    }

    function wtAjaxPagination(pageId,pageNo)// pagination function
    {
        os.setVal('WT_global_templatepagingPageno',parseInt(pageNo));
        WT_global_templateListing();
    }






</script>
<script>
    /////----------------------------------- 5556 ---------------------------------///
    function WT_modify_global_template_preview(global_template_id_val,action)
    {
        popDialog('templateSetting_DIV','Template Setting: ',{height:630,width:1200,modal:true});
        var formdata = new FormData();

        formdata.append('global_template_id',global_template_id_val );
        formdata.append('action',action );
        formdata.append('WT_modify_global_template_preview','OK' );

        var url='<? echo $ajaxFilePath ?>?WT_modify_global_template_preview=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_modify_global_template_preview_Results',url,formdata);



    }
    function WT_modify_global_template_preview_Results(data)
    {
        var content_data=	getData(data,'##--templateSetting_DIV--##');
        os.setHtml('templateSetting_DIV',content_data);
    }

    function  serializeGlobalTemplateSetting()
    {
        let container = document.querySelector("#global_template_settings_forms");
        let forms = container.querySelectorAll("form");

        let style_overrides_json = {};
        forms.forEach(function (form) {
            let inputs = form.querySelectorAll("input, select");
            let style = {};

            inputs.forEach(function (input) {
                if(input.value!==""){
                    style[input.getAttribute("name")] = input.value;
                }

            });

            style_overrides_json[form.getAttribute("name")] = style;
        });
        return style_overrides_json;
    }

    function saveGlobalTemplateSettings(global_template_id ,style_override_json){
        var formdata = new FormData();

        formdata.append('global_template_id',global_template_id );
        formdata.append('style_overrides',JSON.stringify(style_override_json) );
        formdata.append('saveGlobalTemplateSettings','OK' );

        var url='<? echo $ajaxFilePath ?>?saveGlobalTemplateSettings=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('saveGlobalTemplateSettingsResults',url,formdata);

    }
    function saveGlobalTemplateSettingsResults(data) {
        WT_modify_global_template_preview(data, '');
    }

</script>

<?
include('templateClass.php');
$template_class=new templateClass();
$template_class->template_ajax_script_html();
?>



<? include($site['root-wtos'].'bottom.php'); ?>
