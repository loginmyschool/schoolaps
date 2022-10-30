<?
/*
   # wtos version : 1.1
   # main ajax process page : library_barcode_ajax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Library Barcode';
$ajaxFilePath= 'library_barcode_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$department = "Library";
$branches = $os->get_branches_by_access_name("Library Barcode Print");


?>
<div class="content without-header with-both-side-bar uk-overflow-hidden uk-height-1-1">
    <div class="item with-header medium-sidebar background-color-white uk-hidden"
         id="left_container" style="max-width: 400px">
        <div class="item-header p-m uk-box-shadow-small">
            <h4><?=$listHeader?></h4>
        </div>
        <div class="item-content uk-overflow-auto">

            <div class="formDiv p-m">
                <div class="formDivButton">
                    <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_item_uniqueDeleteRowById('');" /><? } ?>
                    <input type="button" value="New" onclick="javascript:window.location='';" />
                    <? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_item_uniqueEditAndSave();" /><? } ?>

                </div>
                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

                    <tr >
                        <td>is_ready </td>
                        <td><input value="" type="text" name="is_ready" id="is_ready" class="textboxxx  fWidth "/> </td>
                    </tr>


                </table>


                <input type="hidden"  id="showPerPage" value="500" />
                <input type="hidden"  id="item_unique_id" value="0" />
                <input type="hidden"  id="WT_item_uniquepagingPageno" value="1" />
                <div class="formDivButton">
                    <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_item_uniqueDeleteRowById('');" />	<? } ?>
                    &nbsp;&nbsp;
                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_item_uniqueEditAndSave();" /><? } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="item with-header  background-color-white"  id="left_container">

        <div class="item-header p-m uk-box-shadow-small">

            Barcode
            <input class="bp3-input bp3-small" type="text" id="item_unique_id_s" />

            Ref. No
            <input class="bp3-input bp3-small" type="text" id="reff_no_s" />

            Branch
            <div class="uk-inline">
                <select name="branch_code"
                        id="branch_code_s"
                        onchange="WT_item_uniqueListing()"
                        class="bp3-input bp3-small">
                    <?$os->onlyOption($branches, $os->val($purchase,"branch_code"))?>
                </select>
            </div>
            Is Used

            <div class="uk-inline">
                <select  name="branch_code"
                         id="is_ready_s" class="bp3-input bp3-small">
                    <option></option>
                    <?$os->onlyOption($os->yesno,"")?>
                </select>
            </div>


            <div style="display:none" id="advanceSearchDiv">

                    Search Key
                    <input type="text" id="searchKey" />
                </div>


            <button class="bp3-button bp3-small bp3-intent-primary" type="button" value="Search" onclick="WT_item_uniqueListing();">Search</button>
            <button class="bp3-button bp3-small bp3-intent-primary" type="button" value="Reset" onclick="searchReset();">Reset</button>
            <button class="bp3-button bp3-small bp3-intent-success" type="button" value="Print Selected" onclick="print_result(true)">Print Selected</button>
            <button class="bp3-button bp3-small bp3-intent-success" type="button" value="Print Result" onclick="print_result()">Print Search Result</button>


        </div>
        <div class="item-content uk-overflow-auto" id="WT_item_uniqueListDiv">

        </div>
    </div>

</div>



    <script>

        function WT_item_uniqueListing() // list table searched data get
        {
            var formdata = new FormData();





            formdata.append('searchKey',os.getVal('searchKey') );
            formdata.append('branch_code_s',os.getVal('branch_code_s') );
            formdata.append('item_unique_id_s',os.getVal('item_unique_id_s') );
            formdata.append('is_ready_s',os.getVal('is_ready_s') );
            formdata.append('reff_no_s',os.getVal('reff_no_s') );
            formdata.append('showPerPage',os.getVal('showPerPage') );
            var WT_item_uniquepagingPageno=os.getVal('WT_item_uniquepagingPageno');
            var url='wtpage='+WT_item_uniquepagingPageno;
            url='<? echo $ajaxFilePath ?>?WT_item_uniqueListing=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_item_uniqueListDiv',url,formdata);

        }

        WT_item_uniqueListing();
        function  searchReset() // reset Search Fields
        {

            os.setVal('searchKey','');
            WT_item_uniqueListing();

        }

        function WT_item_uniqueEditAndSave()  // collect data and send to save
        {

            var formdata = new FormData();
            var is_readyVal= os.getVal('is_ready');


            formdata.append('is_ready',is_readyVal );



            var   item_unique_id=os.getVal('item_unique_id');
            formdata.append('item_unique_id',item_unique_id );
            var url='<? echo $ajaxFilePath ?>?WT_item_uniqueEditAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_item_uniqueReLoadList',url,formdata);

        }

        function WT_item_uniqueReLoadList(data) // after edit reload list
        {

            var d=data.split('#-#');
            var item_unique_id=parseInt(d[0]);
            if(d[0]!='Error' && item_unique_id>0)
            {
                os.setVal('item_unique_id',item_unique_id);
            }

            if(d[1]!=''){alert(d[1]);}
            WT_item_uniqueListing();
        }

        function WT_item_uniqueGetById(item_unique_id) {
            var formdata = new FormData();
            formdata.append('item_unique_id',item_unique_id );
            var url='<? echo $ajaxFilePath ?>?WT_item_uniqueGetById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_item_uniqueFillData',url,formdata);

        }

        function WT_item_uniqueFillData(data){

            var objJSON = JSON.parse(data);
            os.setVal('item_unique_id',parseInt(objJSON.item_unique_id));

            os.setVal('is_ready',objJSON.is_ready);


        }

        function WT_item_uniqueDeleteRowById(item_unique_id) {
            var formdata = new FormData();
            if(parseInt(item_unique_id)<1 || item_unique_id==''){
                var  item_unique_id =os.getVal('item_unique_id');
            }

            if(parseInt(item_unique_id)<1){ alert('No record Selected'); return;}

            var p =confirm('Are you Sure? You want to delete this record forever.')
            if(p){

                formdata.append('item_unique_id',item_unique_id );

                var url='<? echo $ajaxFilePath ?>?WT_item_uniqueDeleteRowById=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_item_uniqueDeleteRowByIdResults',url,formdata);
            }


        }

        function WT_item_uniqueDeleteRowByIdResults(data) {
            alert(data);
            WT_item_uniqueListing();
        }

        function wtAjaxPagination(pageId,pageNo){
            os.setVal('WT_item_uniquepagingPageno',parseInt(pageNo));
            WT_item_uniqueListing();
        }

        function select_all(el){
            document.querySelectorAll(".item_unique_checkbox").forEach((checkbox)=>{
                checkbox.checked = el.checked;
            })
        }

        function print_result(selected=false){
            let params = document.querySelector("#req_params").value;
            let checked_item = [];
            document.querySelectorAll(".item_unique_checkbox").forEach((checkbox)=>{
                if(checkbox.checked){
                    checked_item.push(checkbox.value);
                }
            })
            checked_item = checked_item.join();
            let url = "<?=$ajaxFilePath?>?print_barcodes=OK&"+params;
            if(selected){
                url+="&selected="+checked_item;
            }

            var win = window.open(url, '_blank');
            win.focus();
        }

        function save_location(iu_id){
            let library_id = $('#library_id_'+iu_id).val();
            let rack_no = $('#rack_no_'+iu_id).val();
            let shelf_no = $('#shelf_no_'+iu_id).val();

            let fd = new FormData();
            fd.append("iu_id", iu_id);
            fd.append("library_id", library_id);
            fd.append("rack_no", rack_no);
            fd.append("shelf_no", shelf_no);
            fd.append("WT_save_location", "OK");


            let url='<? echo $ajaxFilePath ?>?WT_save_location=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /><div class="loadText">Please wait. Working...</div></div>';
            os.setAjaxFunc((data)=>{
                console.log(data);
            }, url, fd);
        }

    </script>




<? include($site['root-wtos'].'bottom.php'); ?>
