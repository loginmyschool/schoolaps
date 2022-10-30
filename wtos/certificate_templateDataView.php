<?
/*
   # wtos version : 1.1
   # main ajax process page : certificate_templateAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Certificate Template';
$ajaxFilePath= 'certificate_templateAjax.php';
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
    <div class="item background-color-white p-m" style="min-width: 500px">

        <div class="uk-grid uk-grid-divider uk-grid-small" uk-grid>

            <div class="uk-width-expand">
                <div class="uk-form-custom uk-width-expand uk-margin-small">
                    <label class="uk-form-label">Text Content</label>
                    <textarea class="uk-textarea uk-border-rounded uk-form-small"  name="text_content" id="text_content" style="height:300px;" ></textarea>
                </div>
               <div class="uk-grid-small uk-grid uk-child-width-1-3 uk-margin-small" uk-grid>


                    <div class="uk-inline">
                        <label class="uk-form-label">Content Type</label>
                        <div class="uk-form-controls">
                            <select name="content_type" id="content_type" class="uk-select uk-border-rounded uk-form-small" >
                                <option value="">Content Type</option>
                                <? $os->onlyOption($os->certificate_content_type);	?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-inline">
                        <label class="uk-form-label">type</label>
                        <div class="uk-form-controls">
                            <select name="type" id="type" class="uk-select uk-border-rounded uk-form-small">
                                <option value="">Select Type</option>
                                <? $os->onlyOption($os->certificate_type);	?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-inline">
                        <label class="uk-form-label">Active status</label>
                        <div class="uk-form-controls">
                            <select name="status" id="status" class="uk-select uk-border-rounded uk-form-small" >
                                <option value="">Select Status</option>	<?
                                $os->onlyOption($os->activeStatus);	?>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                <input type="hidden"  id="certificate_template_id" value="0" />
                <input type="hidden"  id="WT_certificate_templatepagingPageno" value="1" />

                <hr>
                <div class="uk-width-auto uk-margin uk-grid-small uk-grid uk-child-width-1-3" uk-grid>
                    <? if($os->access('wtDelete')){ ?>
                        <div>
                            <input class="uk-button uk-border-rounded uk-button-small  uk-button-danger uk-width-expand" type="button" value="Delete" onclick="WT_certificate_templateDeleteRowById('');" />
                        </div>
                    <? } ?>
                    <div>
                        <input class="uk-button uk-border-rounded uk-button-small  uk-theme-button  uk-width-expand" type="button" value="New" onclick="javascript:window.location='';" />
                    </div>
                    <? if($os->access('wtEdit')){ ?>
                        <div>
                            <input class="uk-button uk-border-rounded uk-button-small  uk-secondary-button  uk-width-expand"  type="button" value="Save" onclick="WT_certificate_templateEditAndSave();" />
                        </div>
                    <? } ?>
                </div>

            </div>

            <div class="uk-width-auto">
                <h4 class="uk-text-primary uk-margin">Parameters</h4>
                <? $keys= $os->get_template_keys();

                foreach($keys as $key=>$val)
                {
                    ?>
                    <p class="uk-margin-remove">
                        <a uk-icon="icon:copy; ratio:0.7"
                           class="uk-margin-small-right color-primary"
                           onclick='document.querySelector("#text_content").value+=" <?=$key?> "; document.querySelector("#text_content").focus()'>
                        </a>
                        <?=$key?>
                    </p>
                    <?
                }

                ?>
            </div>
        </div>

    </div>
    <div class="item">
        <div class=" text-m p-top-m p-left-m p-right-m" style="">

            <div class="uk-inline" uk-tooltip="Search key">
                <span class="uk-form-icon" uk-icon="icon: search; ratio:0.7"></span>
                <input class="uk-input uk-border-rounded uk-form-small "   type="text" id="searchKey" placeholder="Search Keyword" />
            </div>
            <button class="uk-button uk-border-rounded uk-button-small  uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="WT_certificate_templateListing();">
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded uk-button-small  uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>

            <div style="display:none" id="advanceSearchDiv">

                Text Content: <input type="text" class="wtTextClass" name="text_content_s" id="text_content_s" value="" /> &nbsp;  Content Type:

                <select name="content_type" id="content_type_s" class="textbox fWidth" ><option value="">Select Content Type</option>	<?
                    $os->onlyOption($os->certificate_content_type);	?></select>
                Type:

                <select name="type" id="type_s" class="textbox fWidth" ><option value="">Select Type</option>	<?
                    $os->onlyOption($os->certificate_type);	?></select>
                Status:

                <select name="status" id="status_s" class="textbox fWidth" ><option value="">Select Status</option>	<?
                    $os->onlyOption($os->activeStatus);	?></select>

            </div>

        </div>

        <div   id="WT_certificate_templateListDiv"></div>
    </div>
</div>








<script>

    function WT_certificate_templateListing() // list table searched data get
    {
        var formdata = new FormData();


        var text_content_sVal= os.getVal('text_content_s');
        var content_type_sVal= os.getVal('content_type_s');
        var type_sVal= os.getVal('type_s');
        var status_sVal= os.getVal('status_s');
        formdata.append('text_content_s',text_content_sVal );
        formdata.append('content_type_s',content_type_sVal );
        formdata.append('type_s',type_sVal );
        formdata.append('status_s',status_sVal );



        formdata.append('searchKey',os.getVal('searchKey') );
        formdata.append('showPerPage',os.getVal('showPerPage') );
        var WT_certificate_templatepagingPageno=os.getVal('WT_certificate_templatepagingPageno');
        var url='wtpage='+WT_certificate_templatepagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_certificate_templateListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_certificate_templateListDiv',url,formdata);

    }

    WT_certificate_templateListing();
    function  searchReset() // reset Search Fields
    {
        os.setVal('text_content_s','');
        os.setVal('content_type_s','');
        os.setVal('type_s','');
        os.setVal('status_s','');

        os.setVal('searchKey','');
        WT_certificate_templateListing();

    }


    function WT_certificate_templateEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var text_contentVal= os.getVal('text_content');
        var content_typeVal= os.getVal('content_type');
        var typeVal= os.getVal('type');
        var statusVal= os.getVal('status');


        formdata.append('text_content',text_contentVal );
        formdata.append('content_type',content_typeVal );
        formdata.append('type',typeVal );
        formdata.append('status',statusVal );



        var   certificate_template_id=os.getVal('certificate_template_id');
        formdata.append('certificate_template_id',certificate_template_id );
        var url='<? echo $ajaxFilePath ?>?WT_certificate_templateEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_certificate_templateReLoadList',url,formdata);

    }

    function WT_certificate_templateReLoadList(data) // after edit reload list
    {

        var d=data.split('#-#');
        var certificate_template_id=parseInt(d[0]);
        if(d[0]!='Error' && certificate_template_id>0)
        {
            os.setVal('certificate_template_id',certificate_template_id);
        }

        if(d[1]!=''){alert(d[1]);}
        WT_certificate_templateListing();
    }

    function WT_certificate_templateGetById(certificate_template_id) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('certificate_template_id',certificate_template_id );
        var url='<? echo $ajaxFilePath ?>?WT_certificate_templateGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_certificate_templateFillData',url,formdata);

    }

    function WT_certificate_templateFillData(data)  // fill data form by JSON
    {
        var objJSON = JSON.parse(data);
        os.setVal('certificate_template_id',parseInt(objJSON.certificate_template_id));

        os.setVal('text_content',objJSON.text_content);
        os.setVal('content_type',objJSON.content_type);
        os.setVal('type',objJSON.type);
        os.setVal('status',objJSON.status);


    }

    function WT_certificate_templateDeleteRowById(certificate_template_id) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(certificate_template_id)<1 || certificate_template_id==''){
            var  certificate_template_id =os.getVal('certificate_template_id');
        }

        if(parseInt(certificate_template_id)<1){ alert('No record Selected'); return;}

        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){

            formdata.append('certificate_template_id',certificate_template_id );

            var url='<? echo $ajaxFilePath ?>?WT_certificate_templateDeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_certificate_templateDeleteRowByIdResults',url,formdata);
        }


    }
    function WT_certificate_templateDeleteRowByIdResults(data)
    {
        alert(data);
        WT_certificate_templateListing();
    }

    function wtAjaxPagination(pageId,pageNo)// pagination function
    {
        os.setVal('WT_certificate_templatepagingPageno',parseInt(pageNo));
        WT_certificate_templateListing();
    }






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
