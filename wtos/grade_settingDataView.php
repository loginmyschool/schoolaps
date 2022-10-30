<?
/*
   # wtos version : 1.1
   # main ajax process page : grade_settingAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Grade Setting';
$ajaxFilePath= 'grade_settingAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

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
                                    <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_grade_settingDeleteRowById('');" /><? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp;<? if($os->access('wtEdit')){ ?> <input type="button" value="Save" onclick="WT_grade_settingEditAndSave();" /><? } ?>

                                </div>
                                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
                                    <tr >
                                        <td>Session </td>
                                        <td>
                                            <select name="board" id="board" class="textbox fWidth" >
                                                <option value="">Select Board</option>
                                                <? $os->onlyOption($os->board,'');	?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td>Session </td>
                                        <td> <select name="asession" id="asession" class="textbox fWidth" ><option value="">Select Session</option>		  	<?

                                                $os->optionsHTML('','idKey','title','accademicsession');?>
                                            </select> </td>
                                    </tr><tr >
                                        <td>From Percent </td>
                                        <td><input value="" type="text" name="from_percent" id="from_percent" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>To Percent </td>
                                        <td><input value="" type="text" name="to_percent" id="to_percent" class="textboxxx  fWidth "/> </td>
                                    </tr><tr >
                                        <td>Grade </td>
                                        <td><input value="" type="text" name="grade" id="grade" class="textboxxx  fWidth "/> </td>
                                    </tr>


                                </table>


                                <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                                <input type="hidden"  id="grade_setting_id" value="0" />
                                <input type="hidden"  id="WT_grade_settingpagingPageno" value="1" />
                                <div class="formDivButton">
                                    <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_grade_settingDeleteRowById('');" />	<? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="New" onclick="javascript:window.location='';" />

                                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save" onclick="WT_grade_settingEditAndSave();" /><? } ?>
                                </div>
                            </div>



                        </td>
                        <td valign="top" class="ajaxViewMainTableTDList">

                            <div class="ajaxViewMainTableTDListSearch">
                                Search Key
                                <input type="text" id="searchKey" />   &nbsp;



                                <div style="display:none" id="advanceSearchDiv">

                                    grade_setting_id: <input type="text" class="wtTextClass" name="grade_setting_id_s" id="grade_setting_id_s" value="" /> &nbsp;  Session:


                                    <select name="asession" id="asession_s" class="textbox fWidth" ><option value="">Select Session</option>		  	<?

                                        $os->optionsHTML('','idKey','title','accademicsession');?>
                                    </select>
                                    From Percent: <input type="text" class="wtTextClass" name="from_percent_s" id="from_percent_s" value="" /> &nbsp;  To Percent: <input type="text" class="wtTextClass" name="to_percent_s" id="to_percent_s" value="" /> &nbsp;  Grade: <input type="text" class="wtTextClass" name="grade_s" id="grade_s" value="" /> &nbsp;
                                </div>


                                <input type="button" value="Search" onclick="WT_grade_settingListing();" style="cursor:pointer;"/>
                                <input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

                            </div>
                            <div  class="ajaxViewMainTableTDListData" id="WT_grade_settingListDiv">&nbsp; </div>
                            &nbsp;</td>
                    </tr>
                </table>



                <!--   ggggggggggggggg  -->

            </td>
        </tr>
    </table>



    <script>

        function WT_grade_settingListing() // list table searched data get
        {
            var formdata = new FormData();


            var grade_setting_id_sVal= os.getVal('grade_setting_id_s');
            var asession_sVal= os.getVal('asession_s');
            var from_percent_sVal= os.getVal('from_percent_s');
            var to_percent_sVal= os.getVal('to_percent_s');
            var grade_sVal= os.getVal('grade_s');
            formdata.append('grade_setting_id_s',grade_setting_id_sVal );
            formdata.append('asession_s',asession_sVal );
            formdata.append('from_percent_s',from_percent_sVal );
            formdata.append('to_percent_s',to_percent_sVal );
            formdata.append('grade_s',grade_sVal );



            formdata.append('searchKey',os.getVal('searchKey') );
            formdata.append('showPerPage',os.getVal('showPerPage') );
            var WT_grade_settingpagingPageno=os.getVal('WT_grade_settingpagingPageno');
            var url='wtpage='+WT_grade_settingpagingPageno;
            url='<? echo $ajaxFilePath ?>?WT_grade_settingListing=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_grade_settingListDiv',url,formdata);

        }

        WT_grade_settingListing();
        function  searchReset() // reset Search Fields
        {
            os.setVal('grade_setting_id_s','');
            os.setVal('asession_s','');
            os.setVal('from_percent_s','');
            os.setVal('to_percent_s','');
            os.setVal('grade_s','');

            os.setVal('searchKey','');
            WT_grade_settingListing();

        }


        function WT_grade_settingEditAndSave()  // collect data and send to save
        {

            var formdata = new FormData();
            var asessionVal= os.getVal('asession');
            var boardVal= os.getVal('board');
            var from_percentVal= os.getVal('from_percent');
            var to_percentVal= os.getVal('to_percent');
            var gradeVal= os.getVal('grade');


            formdata.append('asession',asessionVal );
            formdata.append('board',boardVal );
            formdata.append('from_percent',from_percentVal );
            formdata.append('to_percent',to_percentVal );
            formdata.append('grade',gradeVal );


            if(os.check.empty('asession','Please Add Session')==false){ return false;}
            if(os.check.empty('board','Please Add Board')==false){ return false;}
            if(os.check.empty('from_percent','Please Add From Percent')==false){ return false;}
            if(os.check.empty('to_percent','Please Add To Percent')==false){ return false;}
            if(os.check.empty('grade','Please Add Grade')==false){ return false;}

            var   grade_setting_id=os.getVal('grade_setting_id');
            formdata.append('grade_setting_id',grade_setting_id );
            var url='<? echo $ajaxFilePath ?>?WT_grade_settingEditAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_grade_settingReLoadList',url,formdata);

        }

        function WT_grade_settingReLoadList(data) // after edit reload list
        {

            var d=data.split('#-#');
            var grade_setting_id=parseInt(d[0]);
            if(d[0]!='Error' && grade_setting_id>0)
            {
                os.setVal('grade_setting_id',grade_setting_id);
            }

            if(d[1]!=''){alert(d[1]);}
            WT_grade_settingListing();
        }

        function WT_grade_settingGetById(grade_setting_id) // get record by table primery id
        {
            var formdata = new FormData();
            formdata.append('grade_setting_id',grade_setting_id );
            var url='<? echo $ajaxFilePath ?>?WT_grade_settingGetById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_grade_settingFillData',url,formdata);

        }

        function WT_grade_settingFillData(data)  // fill data form by JSON
        {

            var objJSON = JSON.parse(data);
            os.setVal('grade_setting_id',parseInt(objJSON.grade_setting_id));

            os.setVal('asession',objJSON.asession);
            os.setVal('board',objJSON.board);
            os.setVal('from_percent',objJSON.from_percent);
            os.setVal('to_percent',objJSON.to_percent);
            os.setVal('grade',objJSON.grade);


        }

        function WT_grade_settingDeleteRowById(grade_setting_id) // delete record by table id
        {
            var formdata = new FormData();
            if(parseInt(grade_setting_id)<1 || grade_setting_id==''){
                var  grade_setting_id =os.getVal('grade_setting_id');
            }

            if(parseInt(grade_setting_id)<1){ alert('No record Selected'); return;}

            var p =confirm('Are you Sure? You want to delete this record forever.')
            if(p){

                formdata.append('grade_setting_id',grade_setting_id );

                var url='<? echo $ajaxFilePath ?>?WT_grade_settingDeleteRowById=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_grade_settingDeleteRowByIdResults',url,formdata);
            }


        }
        function WT_grade_settingDeleteRowByIdResults(data)
        {
            alert(data);
            WT_grade_settingListing();
        }

        function wtAjaxPagination(pageId,pageNo)// pagination function
        {
            os.setVal('WT_grade_settingpagingPageno',parseInt(pageNo));
            WT_grade_settingListing();
        }






    </script>




<? include($site['root-wtos'].'bottom.php'); ?>
