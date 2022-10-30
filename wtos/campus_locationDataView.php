<?
/*
   # wtos version : 1.1
   # main ajax process page : campus_locationAjax.php
   #
*/
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Campus';
$ajaxFilePath= 'campus_locationAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$branches = $os->get_branches_by_access_name("Campus");

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
                                    <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_campus_locationDeleteRowById('');" /><? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_campus_locationEditAndSave();" /><? } ?>

                                </div>
                                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

                                    <tr >
                                        <td>Campus Name </td>
                                        <td><input value="" type="text" name="campus_name" id="campus_name" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Branch </td>
                                        <td> <select name="branch_code" id="branch_code" class="textbox fWidth" ><option value="">Select Branch</option>		  	<?

                                                $os->onlyOption($branches,'');?>
                                            </select> </td>
                                    </tr><tr >
                                        <td>Campus Type </td>
                                        <td>

                                            <select name="campus_type" id="campus_type" class="textbox fWidth" ><option value="">Select Campus Type</option>	<?
                                                $os->onlyOption($os->campus_type);	?></select>	 </td>
                                    </tr><tr >
                                        <td>note </td>
                                        <td><input value="" type="text" name="note" id="note" class="textboxxx  fWidth "/> </td>
                                    </tr>


                                </table>


                                <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                                <input type="hidden"  id="campus_location_id" value="0" />
                                <input type="hidden"  id="WT_campus_locationpagingPageno" value="1" />
                                <div class="formDivButton">
                                    <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_campus_locationDeleteRowById('');" />	<? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_campus_locationEditAndSave();" /><? } ?>
                                </div>
                            </div>



                        </td>
                        <td valign="top" class="ajaxViewMainTableTDList">

                            <div class="ajaxViewMainTableTDListSearch">
                                Search Key
                                <input type="text" id="searchKey" />   &nbsp;



                                <div style="display:none" id="advanceSearchDiv">

                                    campus_location_id: <input type="text" class="wtTextClass" name="campus_location_id_s" id="campus_location_id_s" value="" /> &nbsp;  Campus Name: <input type="text" class="wtTextClass" name="campus_name_s" id="campus_name_s" value="" /> &nbsp;  Branch:


                                    <select name="branch_code" id="branch_code_s" class="textbox fWidth" ><option value="">Select Branch</option>		  	<?

                                        $os->optionsHTML('','branch_code','branch_code','branch');?>
                                    </select>
                                    Campus Type:

                                    <select name="campus_type" id="campus_type_s" class="textbox fWidth" ><option value="">Select Campus Type</option>	<?
                                        $os->onlyOption($os->campus_type);	?></select>
                                    note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;
                                </div>


                                <input type="button" value="Search" onclick="WT_campus_locationListing();" style="cursor:pointer;"/>
                                <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

                            </div>
                            <div  class="ajaxViewMainTableTDListData" id="WT_campus_locationListDiv">&nbsp; </div>
                            &nbsp;</td>
                    </tr>
                </table>



                <!--   ggggggggggggggg  -->

            </td>
        </tr>
    </table>



    <script>

        function WT_campus_locationListing() // list table searched data get
        {
            var formdata = new FormData();


            var campus_location_id_sVal= os.getVal('campus_location_id_s');
            var campus_name_sVal= os.getVal('campus_name_s');
            var branch_code_sVal= os.getVal('branch_code_s');
            var campus_type_sVal= os.getVal('campus_type_s');
            var note_sVal= os.getVal('note_s');
            formdata.append('campus_location_id_s',campus_location_id_sVal );
            formdata.append('campus_name_s',campus_name_sVal );
            formdata.append('branch_code_s',branch_code_sVal );
            formdata.append('campus_type_s',campus_type_sVal );
            formdata.append('note_s',note_sVal );



            formdata.append('searchKey',os.getVal('searchKey') );
            formdata.append('showPerPage',os.getVal('showPerPage') );
            var WT_campus_locationpagingPageno=os.getVal('WT_campus_locationpagingPageno');
            var url='wtpage='+WT_campus_locationpagingPageno;
            url='<? echo $ajaxFilePath ?>?WT_campus_locationListing=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_campus_locationListDiv',url,formdata);

        }

        WT_campus_locationListing();
        function  searchReset() // reset Search Fields
        {
            os.setVal('campus_location_id_s','');
            os.setVal('campus_name_s','');
            os.setVal('branch_code_s','');
            os.setVal('campus_type_s','');
            os.setVal('note_s','');

            os.setVal('searchKey','');
            WT_campus_locationListing();

        }


        function WT_campus_locationEditAndSave()  // collect data and send to save
        {

            var formdata = new FormData();
            var campus_nameVal= os.getVal('campus_name');
            var branch_codeVal= os.getVal('branch_code');
            var campus_typeVal= os.getVal('campus_type');
            var noteVal= os.getVal('note');


            formdata.append('campus_name',campus_nameVal );
            formdata.append('branch_code',branch_codeVal );
            formdata.append('campus_type',campus_typeVal );
            formdata.append('note',noteVal );


            if(os.check.empty('campus_name','Please Add Campus Name')==false){ return false;}
            if(os.check.empty('branch_code','Please Add Branch')==false){ return false;}

            var   campus_location_id=os.getVal('campus_location_id');
            formdata.append('campus_location_id',campus_location_id );
            var url='<? echo $ajaxFilePath ?>?WT_campus_locationEditAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_campus_locationReLoadList',url,formdata);

        }

        function WT_campus_locationReLoadList(data) // after edit reload list
        {

            var d=data.split('#-#');
            var campus_location_id=parseInt(d[0]);
            if(d[0]!='Error' && campus_location_id>0)
            {
                os.setVal('campus_location_id',campus_location_id);
            }

            if(d[1]!=''){alert(d[1]);}
            WT_campus_locationListing();
        }

        function WT_campus_locationGetById(campus_location_id) // get record by table primery id
        {
            var formdata = new FormData();
            formdata.append('campus_location_id',campus_location_id );
            var url='<? echo $ajaxFilePath ?>?WT_campus_locationGetById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_campus_locationFillData',url,formdata);

        }

        function WT_campus_locationFillData(data)  // fill data form by JSON
        {

            var objJSON = JSON.parse(data);
            os.setVal('campus_location_id',parseInt(objJSON.campus_location_id));

            os.setVal('campus_name',objJSON.campus_name);
            os.setVal('branch_code',objJSON.branch_code);
            os.setVal('campus_type',objJSON.campus_type);
            os.setVal('note',objJSON.note);


        }

        function WT_campus_locationDeleteRowById(campus_location_id) // delete record by table id
        {
            var formdata = new FormData();
            if(parseInt(campus_location_id)<1 || campus_location_id==''){
                var  campus_location_id =os.getVal('campus_location_id');
            }

            if(parseInt(campus_location_id)<1){ alert('No record Selected'); return;}

            var p =confirm('Are you Sure? You want to delete this record forever.')
            if(p){

                formdata.append('campus_location_id',campus_location_id );

                var url='<? echo $ajaxFilePath ?>?WT_campus_locationDeleteRowById=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_campus_locationDeleteRowByIdResults',url,formdata);
            }


        }
        function WT_campus_locationDeleteRowByIdResults(data)
        {
            alert(data);
            WT_campus_locationListing();
        }

        function wtAjaxPagination(pageId,pageNo)// pagination function
        {
            os.setVal('WT_campus_locationpagingPageno',parseInt(pageNo));
            WT_campus_locationListing();
        }






    </script>




<? include($site['root-wtos'].'bottom.php'); ?>
