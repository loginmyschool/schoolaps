<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
global $os,$bridge,$site;
?>
<?
$pluginName='';
$listHeader='School Health';

$ajaxFilePath=$site['server'].$bridge->site['portal-school-folder']. 'wtos/page_school_report_ajax.php';
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$q="select * from school where  active_status='Active'";
$k=$os->mq($q);



?>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <div class="uk-inline">
                <span class="uk-form-icon  uk-background-muted p-left-m p-right-m" style="width: auto; top: 1px; left: 1px; height: calc(100% - 2px)">SESSION</span>
                <select name="asession"
                        id="asession_s"
                        style="padding-left: 85px"
                        onchange="view_report('student_count')"
                        class="uk-select uk-border-rounded uk-form-small  p-right-xl text-m" >
                    <option value=""> </option>
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
    <div class="item with-header-footer">
        <div class="item-content p-l">
            <div class="uk-grid uk-grid-small" uk-grid>
                <div class="uk-width-expand" >

                    <?
                    $schooldatabase=$site['db'];
                    $schooldatabase_enc=$bridge->nCode($schooldatabase);
                    ?>

                    <input type="hidden"   id="school_database"  value=""  />

                </div>

                <div class="uk-width-1-1">


                    <div id="score_plot_Div" >
                    </div>
                    <div id="setreportresultDiv" >
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    var data_array=[];
    var  options_json={};
    var graph_div_id='';
    function drawChart()
    {
        var data = google.visualization.arrayToDataTable(data_array);
        var options = options_json;

        var chart = new google.visualization.PieChart(document.getElementById(graph_div_id));
        chart.draw(data, options);
    }



    /*var data_array=[
      ['', ''],
      ['Result',70],
      ['',30],
    ];

    var  options_json={
    pieHole: 0.7,
      pieSliceTextStyle:{
        color: '',
      },
       slices: {0: {color: 'green'}, 1: {color: '#cccccc'}},
      legend: 'none'
    };

    var graph_div_id='donut_single';
     google.charts.setOnLoadCallback(drawChart);*/
</script>
<!--<div >
      <div id="donut_single" style="width: 200px; height: 200px; background:#CCFF00;"></div>
     <div class="center" style=" position: absolute;  top:46%;  left:93px"> 70</div>
     <div class="center" style=" font-size:18px; font-weight:bold;">Result</div>
</div>-->


<style>
    .totalschool{ min-width:300px; border:1px solid #CCCCCC}
    .totalschool td{ padding:5px; border-bottom:1px solid #CCCCCC; border-right:1px solid #F2F2F2}
    .res_60{ color:#FF0000; font-weight:bold;}
    .res_70{ color:#FF8000;font-weight:bold;}
    .res_80{ color:#009900;}
    .overallscrore{ height:200px; width:170; float:left;  }
    .map_canvas{ position:relative ; padding:0px;width:160px;}

    .score_divclass{ height:160px; width:160px; }
    .center_text{ font-size:25px; font-weight:bold;position: absolute;  top:40%;  left:42%; overflow:hidden; }
    .center_title{color:#006600; font-size:30px; font-weight:bold;font-size:18px; font-weight:bold; z-index:200; text-align:center;}
</style>

<script>

    function view_report(report_name)
    {

        var formdata = new FormData();
      //  var school_databases= os.getVal('school_database');
       // formdata.append('school_database',school_databases );

        var asession_s= os.getVal('asession_s');
        formdata.append('asession_s',asession_s );



        formdata.append('view_report','OK');
        formdata.append('report_name',report_name);
        var url='<? echo $ajaxFilePath ?>?view_report=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('view_report_result',url,formdata);
    }

    function  view_report_result(data)
    {


        var setreportresultDiv_data= getData(data,'##--report-data--##');
        os.setHtml('setreportresultDiv',setreportresultDiv_data);


        var score_keys= getData(data,'##--score-keys--##');



        var scorekey_arr=score_keys.split('==');


        for(var i=0;i<scorekey_arr.length;i++)
        {
            var key=scorekey_arr[i];
            key=key.replace(' ','');
            var sep='##--'+key+'-data_array--##';

            data_array_str= getData(data,'##--'+key+'-data_array--##');

            options_json_str= getData(data,'##--'+key+'-options_json--##');
            graph_div_id_str= getData(data,'##--'+key+'-graph_div_id--##');
            data_array = JSON.parse(data_array_str);
            options_json = JSON.parse(options_json_str);
            graph_div_id =graph_div_id_str;
            drawChart();




        }
        /*

       data_array_str= getData(data,'##--overall-data_array--##');
       options_json_str= getData(data,'##--overall-options_json--##');
       graph_div_id_str= getData(data,'##--overall-graph_div_id--##');
       data_array = JSON.parse(data_array_str);
       options_json = JSON.parse(options_json_str);
       graph_div_id =graph_div_id_str;
       drawChart();*/
    //google.charts.setOnLoadCallback(drawChart);
    }
    //view_report('student_count');
    window.onload = function () {
        view_report('student_count')
    }
</script>



<? include($site['root-wtos'].'bottom.php'); ?>
