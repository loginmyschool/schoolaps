<?
/*
   # wtos version : 1.1
   # main ajax process page : holidaysAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Holiday';
$ajaxFilePath= 'holidaysAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

?>


<table class="container"  cellpadding="0" cellspacing="0">
    <tr>

        <td  class="middle" style="padding-left:5px;">


            <div class="listHeader"> <?php  echo $listHeader; ?>  </div>

            <!--  ggggggggggggggg   -->


            <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">

                <tr>
                    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
                        <div class="formDiv">
                            <div class="formDivButton">
                                <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_holidaysDeleteRowById('');" /><? } ?>
                                &nbsp;&nbsp;
                                &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                &nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_holidaysEditAndSave();" /><? } ?>

                            </div>
                            <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">

                                <tr style="display:none;">
                                    <td>Session </td>
                                    <td><input value="" type="text" name="asession" id="asession" class="textboxxx  fWidth "/> </td>
                                </tr><tr >
                                    <td>Date </td>
                                    <td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>
                                </tr><tr >
                                    <td>Event </td>
                                    <td><input value="" type="text" name="event" id="event" class="textboxxx  fWidth "/> </td>
                                </tr><tr >
                                    <td>Remarks </td>
                                    <td><textarea  name="remarks" id="remarks" ></textarea></td>
                                </tr>


                            </table>


                            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                            <input type="hidden"  id="holidaysId" value="0" />
                            <input type="hidden"  id="WT_holidayspagingPageno" value="1" />
                            <div class="formDivButton">
                                <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_holidaysDeleteRowById('');" />	<? } ?>
                                &nbsp;&nbsp;
                                &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_holidaysEditAndSave();" /><? } ?>
                            </div>
                        </div>



                    </td>
                    <td valign="top" class="ajaxViewMainTableTDList">

                        <div class="ajaxViewMainTableTDListSearch">
                            Search Key
                            <input type="text" id="searchKey" />   &nbsp;
                            From Date: <input class="wtDateClass" type="text" name="f_dated_s" id="f_dated_s" value=""  /> &nbsp;   To Date: <input class="wtDateClass" type="text" name="t_dated_s" id="t_dated_s" value=""  /> &nbsp;




                            <div style="display:none" id="advanceSearchDiv">

                                Session: <input type="text" class="wtTextClass" name="asession_s" id="asession_s" value="" /> &nbsp;


                                Event: <input type="text" class="wtTextClass" name="event_s" id="event_s" value="" /> &nbsp;  Remarks: <input type="text" class="wtTextClass" name="remarks_s" id="remarks_s" value="" /> &nbsp;
                            </div>


                            <input type="button" value="Search" onclick="WT_holidaysListing();" style="cursor:pointer;"/>
                            <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

                        </div>
                        <div  class="ajaxViewMainTableTDListData" id="WT_holidaysListDiv">&nbsp; </div>
                        &nbsp;</td>
                </tr>
            </table>



            <!--   ggggggggggggggg  -->

        </td>
    </tr>
</table>



<script>

    function WT_holidaysListing() // list table searched data get
    {
        var formdata = new FormData();


        var asession_sVal= os.getVal('asession_s');
        var f_dated_sVal= os.getVal('f_dated_s');
        var t_dated_sVal= os.getVal('t_dated_s');
        var event_sVal= os.getVal('event_s');
        var remarks_sVal= os.getVal('remarks_s');
        formdata.append('asession_s',asession_sVal );
        formdata.append('f_dated_s',f_dated_sVal );
        formdata.append('t_dated_s',t_dated_sVal );
        formdata.append('event_s',event_sVal );
        formdata.append('remarks_s',remarks_sVal );



        formdata.append('searchKey',os.getVal('searchKey') );
        formdata.append('showPerPage',os.getVal('showPerPage') );
        var WT_holidayspagingPageno=os.getVal('WT_holidayspagingPageno');
        var url='wtpage='+WT_holidayspagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_holidaysListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_holidaysListDiv',url,formdata);

    }

    WT_holidaysListing();
    function  searchReset() // reset Search Fields
    {
        os.setVal('asession_s','');
        os.setVal('f_dated_s','');
        os.setVal('t_dated_s','');
        os.setVal('event_s','');
        os.setVal('remarks_s','');

        os.setVal('searchKey','');
        WT_holidaysListing();

    }


    function WT_holidaysEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var asessionVal= os.getVal('asession');
        var datedVal= os.getVal('dated');
        var eventVal= os.getVal('event');
        var remarksVal= os.getVal('remarks');


        formdata.append('asession',asessionVal );
        formdata.append('dated',datedVal );
        formdata.append('event',eventVal );
        formdata.append('remarks',remarksVal );



        var   holidaysId=os.getVal('holidaysId');
        formdata.append('holidaysId',holidaysId );
        var url='<? echo $ajaxFilePath ?>?WT_holidaysEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_holidaysReLoadList',url,formdata);

    }

    function WT_holidaysReLoadList(data) // after edit reload list
    {

        var d=data.split('#-#');
        var holidaysId=parseInt(d[0]);
        if(d[0]!='Error' && holidaysId>0)
        {
            os.setVal('holidaysId',holidaysId);
        }

        if(d[1]!=''){alert(d[1]);}
        WT_holidaysListing();
    }

    function WT_holidaysGetById(holidaysId) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('holidaysId',holidaysId );
        var url='<? echo $ajaxFilePath ?>?WT_holidaysGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_holidaysFillData',url,formdata);

    }

    function WT_holidaysFillData(data)  // fill data form by JSON
    {

        var objJSON = JSON.parse(data);
        os.setVal('holidaysId',parseInt(objJSON.holidaysId));

        os.setVal('asession',objJSON.asession);
        os.setVal('dated',objJSON.dated);
        os.setVal('event',objJSON.event);
        os.setVal('remarks',objJSON.remarks);


    }

    function WT_holidaysDeleteRowById(holidaysId) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(holidaysId)<1 || holidaysId==''){
            var  holidaysId =os.getVal('holidaysId');
        }

        if(parseInt(holidaysId)<1){ alert('No record Selected', "warning"); return;}

        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){

            formdata.append('holidaysId',holidaysId );

            var url='<? echo $ajaxFilePath ?>?WT_holidaysDeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_holidaysDeleteRowByIdResults',url,formdata);
        }


    }
    function WT_holidaysDeleteRowByIdResults(data)
    {
        alert(data);
        WT_holidaysListing();
    }

    function wtAjaxPagination(pageId,pageNo)// pagination function
    {
        os.setVal('WT_holidayspagingPageno',parseInt(pageNo));
        WT_holidaysListing();
    }






</script>




<? include($site['root-wtos'].'bottom.php'); ?>
