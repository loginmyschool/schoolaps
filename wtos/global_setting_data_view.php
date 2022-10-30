<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/



include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');

?><?

$pluginName='';

$listHeader='Global Session Setting';

$ajaxFilePath= 'global_setting_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';



?>





<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <div class="uk-inline uk-margin-small-right">
                 
            </div>
            <div class="uk-inline">
                
                
            </div>
        </div>
    </div>

</div>


<div class="content">

    <div class="item uk-width-medium">
        <div class="uk-grid uk-grid-small" uk-grid>
            <div class="uk-width-auto">
			
			<div class="ajaxViewMainTableTDListSearch" style="margin:5px;">
			
			Session <select name="asession"
                        id="asession"
                        style="padding-left: 85px"
                        class="  uk-border-rounded " >
                    <option value=""> </option>
                    <?
                   
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select> 
                <table width="100%" border="0" cellspacing="2" cellpadding="2" style="margin:5px;">
                    <tr>
                        <td>Class</td>

                        <td> </td>
                    </tr>
                    <tr>

                        <td valign="top"><? foreach($os->classList as $class_id=>$val){

                                ?>
                                <div class="checkbox_list"> <input type="checkbox" name="classList[]" value="<? echo $class_id ?>" /> <? echo $val ?>  </div>
                                <?


                            } ?>









                        </td>

                        <td valign="top">



                            <div class="global_setting_list">  Session start date <input type="text" class="wtDateClass textbox fWidth" name="session_start_date" id="session_start_date"  value="" />(2021-12-25)  </div>
							<div class="global_setting_list">  Session end date <input type="text" class="wtDateClass textbox fWidth" name="session_end_date" id="session_end_date"  value="" /> (2021-12-25) </div>
                            <div class="global_setting_list">  Payment due day <input type="text" name="payment_due_date" id="payment_due_date"  value="" /> (example:5)  </div>
                            <div class="global_setting_list"> per day fine  <input type="text" name="per_day_fine" id="per_day_fine"  value="" />  </div>



                            <input name="button" type="button" onclick="manage_global_setting('save')" value="SAVE"/>
                        </td>
                    </tr>
                </table>
				
				</div>
				
				
            </div>
            <div class="uk-width-expand">
                <!---------
               SEARCH VIEW
               ---------->
                <div class=" text-m p-top-m" style="">
                <div class="ajaxViewMainTableTDListSearch">
                <span class="hideForSelectedData">
				Session <select name="asession_s"
                        id="asession_s"
                        style="padding-left: 85px">
                        
                    <option value=""> </option>
                    <?
                   
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select> 
				
                    Class <select name="classList" id="classList_s" class="textbox fWidth">
                        <option value=""></option>
                        <? $os->onlyOption($os->classList,'');	?></select>
                </span>
                    <input type="button" value="Search" onclick="manage_global_setting('search');" style="cursor:pointer;"/>
                    <input type="button" value="Reset" onclick="searchReset()" style="cursor:pointer;"/>
                </div>
                </div>
                <!---------
                DATA VIEW
                ---------->
                <div  id="WT_feesListDiv" class="ajaxViewMainTableTDListSearch"> </div>
            </div>
        </div>

    </div>
</div>












<script>



    function manage_global_setting(button) // get record by table primery id
    {
        var formdata = new FormData();

        var classList= getValuesFromCheckedBox('classList[]');
        var session_start_date= os.getVal('session_start_date');
		 var session_end_date= os.getVal('session_end_date');
        var payment_due_date= os.getVal('payment_due_date');
        var per_day_fine= os.getVal('per_day_fine');


        formdata.append('classList',classList);
        formdata.append('session_start_date',session_start_date );
		 formdata.append('session_end_date',session_end_date );
        formdata.append('payment_due_date',payment_due_date );
        formdata.append('per_day_fine',per_day_fine );



        formdata.append('button',button );

        var asession_s=os.getVal('asession_s');
        formdata.append('asession_s',asession_s );
		
		 var asession=os.getVal('asession');
        formdata.append('asession',asession );

        var classList_s=os.getVal('classList_s');
        formdata.append('classList_s',classList_s );


        formdata.append('manage_global_setting','OK' );


        var url='<? echo $ajaxFilePath ?>?manage_global_setting=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('manage_global_setting_results',url,formdata);

    }

    function manage_global_setting_results(data)  // fill data form by JSON
    {

        var content_data=	getData(data,'##--GLOBAL-SETTING-DATA--##');
        os.setHtml('WT_feesListDiv',content_data);
    }

manage_global_setting('');
function global_settingDeleteRowById(global_session_setting_id) // delete record by table id
{
	var formdata = new FormData();	
	if(parseInt(global_session_setting_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){
	
	formdata.append('global_session_setting_id',global_session_setting_id );
	
	var url='<? echo $ajaxFilePath ?>?global_settingDeleteRowById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('global_settingDeleteRowById_result',url,formdata);
	}
 

}
function global_settingDeleteRowById_result(data)
{
    alert(data);
	manage_global_setting('');
} 
	
	
	function  searchReset() // reset Search Fields
        {
            
            os.setVal('asession_s','');
           
            os.setVal('classList_s','');
           
           manage_global_setting('');
        }
	
	
	
	
	

</script>

<style>
.global_setting_list{ margin:5px;}
</style>



<? include($site['root-wtos'].'bottom.php'); ?>
