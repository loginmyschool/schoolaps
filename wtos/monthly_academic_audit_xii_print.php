<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$monthly_academic_audit_xii_id = $os->get('id');
$monthly_academic_audit_xii_mq = $os->mq("SELECT * FROM monthly_academic_audit_xii where  monthly_academic_audit_xii_id='$monthly_academic_audit_xii_id'");
$data=$os->mfa($monthly_academic_audit_xii_mq);
$number_of_classes=json_decode($data['number_of_classes'], TRUE);
$number_of_supervission_classes=json_decode($data['number_of_supervission_classes'], TRUE);
$number_of_practical_classes=json_decode($data['number_of_practical_classes'], TRUE);
$number_of_special_classes=json_decode($data['number_of_special_classes'], TRUE);
$number_of_neet_classes=json_decode($data['number_of_neet_classes'], TRUE);
$number_of_mock_test=json_decode($data['number_of_mock_test'], TRUE);
$motivational_programme=json_decode($data['motivational_programme'], TRUE);
$number_of_test_classtest=json_decode($data['number_of_test_classtest'], TRUE);
$number_of_test_dpt=json_decode($data['number_of_test_dpt'], TRUE);
$number_of_test_ft1=json_decode($data['number_of_test_ft1'], TRUE);
$number_of_test_ft2=json_decode($data['number_of_test_ft2'], TRUE);
$number_of_test_ft3=json_decode($data['number_of_test_ft3'], TRUE);
$number_of_test_ft4=json_decode($data['number_of_test_ft4'], TRUE);   
$number_of_test_fmt=json_decode($data['number_of_test_fmt'], TRUE);
$mocktest_type=json_decode($data['mocktest_type'], TRUE);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include('wtosHeader.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Icard </title>
   <!-- <link rel="stylesheet" href="<? echo $site['themePath']?>css/uikit.css" />
    <script src="<? echo $site['themePath']?>js/uikit.js"></script>
    <script src="<? echo $site['themePath']?>js/uikit-icons.js"></script>-->
    <style type="text/css">
        .uk-table{width: 80%; }

    </style>
</head>

<body>
    <div style="width:100%; padding:15px;text-align:center;" id="printBtn">
        <input type="button" onclick="printPage()" value="Print" />
    </div>

    <div>



        <? 
        $listingQuery="  select * from school_setting where school_setting_id>0   $where      order by school_setting_id desc";

        $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
        $rsRecords=$resource['resource'];
        $record=$os->mfa( $rsRecords);
        ?>

        <? ob_start();?> 
        <div class="head">
            <div style=" height:100px; width:100px; margin:auto">   <img src="<?php  echo $site['url'].$record['logoimage']; ?>"  style="height: 100px; width: 100px" /> </div>

            <div style="font-size:20px; font-weight:bold; text-align:center;">
                Monthly Academic Audit (MAA)
            </div>

            <div style="font-size:14px; font-weight:200; text-align:center;">
               <? echo $os->rowByField('branch_name','branch','branch_code',$data['branch_code']); ?> (XI & XII)
           </div>

           <div style="font-size:17px; font-weight:200; text-align:center; margin:auto; width:120px; border:1px solid #333333; border-radius:5px; margin-top:10px;">
               <?php echo $os->rentMonth[$data['month']] ;?>  <?php echo $data['year'] ;?>
           </div>


           <div style=" border-bottom:1px solid #000000; margin:10px 0px;">

           </div>
       </div>

       <? $head=ob_get_clean();?>
       <? function footer_text($page=1){ 
        global $data,$os;
        ?>
        <div style=" border-bottom:1px solid #000000; margin:10px 0px;">

        </div>
        <div style="font-size:10px"> Entry By : <? echo $os->rowByField('name','admin','adminId',$data['entry_by_admin_id']); ?>  
        <?php  echo $os->showDate( $data['entry_date']);?> &nbsp; Page No : <? echo $page ?> &nbsp; Print Date <? echo date('Y-m-d'); ?>
    </div> <div style="break-after:page"></div>
<?  } ?>



<div style="background-color:#FFFFFF; font-size:12px; text-align:center;">






  <?  echo $head;?>

  <div class="head_style" > Number of classes held: </div>

  <table class="uk-table uk-table-small listTable">
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_classes['xi_mathematics'])?$number_of_classes['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_classes['xi_physics'])?$number_of_classes['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_classes['xi_chemistry'])?$number_of_classes['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_classes['xi_biology'])?$number_of_classes['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_classes['xii_mathematics'])?$number_of_classes['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_classes['xii_physics'])?$number_of_classes['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_classes['xii_chemistry'])?$number_of_classes['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_classes['xii_biology'])?$number_of_classes['xii_biology']:'' ?></td>
    </tr>
</table>

<div class="head_style" >Number of Supervision Classes Held: </div>
<table class="uk-table uk-table-small listTable">
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_supervission_classes['xi_mathematics'])?$number_of_supervission_classes['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_supervission_classes['xi_physics'])?$number_of_supervission_classes['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_supervission_classes['xi_chemistry'])?$number_of_supervission_classes['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_supervission_classes['xi_biology'])?$number_of_supervission_classes['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_supervission_classes['xii_mathematics'])?$number_of_supervission_classes['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_supervission_classes['xii_physics'])?$number_of_supervission_classes['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_supervission_classes['xii_chemistry'])?$number_of_supervission_classes['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_supervission_classes['xii_biology'])?$number_of_supervission_classes['xii_biology']:'' ?></td>
    </tr>
</table>

<div class="head_style" >Number of Practical Classes Held:</div>
<table class="uk-table uk-table-small listTable">
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>

        <td><?php echo isset($number_of_practical_classes['xi_physics'])?$number_of_practical_classes['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_practical_classes['xi_chemistry'])?$number_of_practical_classes['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_practical_classes['xi_biology'])?$number_of_practical_classes['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>

        <td><?php echo isset($number_of_practical_classes['xii_physics'])?$number_of_practical_classes['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_practical_classes['xii_chemistry'])?$number_of_practical_classes['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_practical_classes['xii_biology'])?$number_of_practical_classes['xii_biology']:'' ?></td>
    </tr>
</table>


<div style="height:70px; width:100%"> </div>

<? echo footer_text($page=1); ?>




<?  echo $head;?>




<div class="head_style" >Number of Special Classes Held:</div>

<table class="uk-table uk-table-small listTable">
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>

        <td><?php echo isset($number_of_special_classes['xi_physics'])?$number_of_special_classes['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_special_classes['xi_chemistry'])?$number_of_special_classes['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_special_classes['xi_biology'])?$number_of_special_classes['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_special_classes['xii_physics'])?$number_of_special_classes['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_special_classes['xii_chemistry'])?$number_of_special_classes['xii_chemistry']:'' ?>
    </td>
    <td><?php echo isset($number_of_special_classes['xii_biology'])?$number_of_special_classes['xii_biology']:'' ?></td>
</tr>
</table>


<div class="head_style" >Number of NEET Classes Held: </div>

<table class="uk-table uk-table-small listTable">
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_neet_classes['xi_physics'])?$number_of_neet_classes['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_neet_classes['xi_chemistry'])?$number_of_neet_classes['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_neet_classes['xi_biology'])?$number_of_neet_classes['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>

        <td><?php echo isset($number_of_neet_classes['xii_physics'])?$number_of_neet_classes['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_neet_classes['xii_chemistry'])?$number_of_neet_classes['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_neet_classes['xii_biology'])?$number_of_neet_classes['xii_biology']:'' ?></td>
    </tr>
</table>
<div class="head_style" style="display: none;">Number of Test / Mock Test Taken: </div>					
<table class="uk-table uk-table-small listTable" style="display: none;">
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_mock_test['xi_mathematics'])?$number_of_mock_test['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_mock_test['xi_physics'])?$number_of_mock_test['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_mock_test['xi_chemistry'])?$number_of_mock_test['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_mock_test['xi_biology'])?$number_of_mock_test['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_mock_test['xii_mathematics'])?$number_of_mock_test['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_mock_test['xii_physics'])?$number_of_mock_test['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_mock_test['xii_chemistry'])?$number_of_mock_test['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_mock_test['xii_biology'])?$number_of_mock_test['xii_biology']:'' ?></td>
    </tr>
</table>

<!-- aa -->
<div class="head_style" <?php echo isset($mocktest_type['number_of_test_classtest_chk'])?"":"style='display:none;'"?>>Number of class test: </div>                   
<table class="uk-table uk-table-small listTable" <?php echo isset($mocktest_type['number_of_test_classtest_chk'])?"":"style='display:none;'"?>>
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_test_classtest['xi_mathematics'])?$number_of_test_classtest['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_classtest['xi_physics'])?$number_of_test_classtest['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_classtest['xi_chemistry'])?$number_of_test_classtest['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_classtest['xi_biology'])?$number_of_test_classtest['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_test_classtest['xii_mathematics'])?$number_of_test_classtest['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_classtest['xii_physics'])?$number_of_test_classtest['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_classtest['xii_chemistry'])?$number_of_test_classtest['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_classtest['xii_biology'])?$number_of_test_classtest['xii_biology']:'' ?></td>
    </tr>
</table>
<div class="head_style" <?php echo isset($mocktest_type['number_of_test_dpt_chk'])?"":"style='display:none;'"?>>Number of DPT test: </div>                 
<table class="uk-table uk-table-small listTable" <?php echo isset($mocktest_type['number_of_test_dpt_chk'])?"":"style='display:none;'"?>>
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_test_dpt['xi_mathematics'])?$number_of_test_dpt['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_dpt['xi_physics'])?$number_of_test_dpt['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_dpt['xi_chemistry'])?$number_of_test_dpt['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_dpt['xi_biology'])?$number_of_test_dpt['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_test_dpt['xii_mathematics'])?$number_of_test_dpt['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_dpt['xii_physics'])?$number_of_test_dpt['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_dpt['xii_chemistry'])?$number_of_test_dpt['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_dpt['xii_biology'])?$number_of_test_dpt['xii_biology']:'' ?></td>
    </tr>
</table>
<div class="head_style" <?php echo isset($mocktest_type['number_of_test_ft1_chk'])?"":"style='display:none;'"?>>Number of FT1 test: </div>                 
<table class="uk-table uk-table-small listTable" <?php echo isset($mocktest_type['number_of_test_ft1_chk'])?"":"style='display:none;'"?>>
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_test_ft1['xi_mathematics'])?$number_of_test_ft1['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft1['xi_physics'])?$number_of_test_ft1['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft1['xi_chemistry'])?$number_of_test_ft1['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft1['xi_biology'])?$number_of_test_ft1['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_test_ft1['xii_mathematics'])?$number_of_test_ft1['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft1['xii_physics'])?$number_of_test_ft1['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft1['xii_chemistry'])?$number_of_test_ft1['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft1['xii_biology'])?$number_of_test_ft1['xii_biology']:'' ?></td>
    </tr>
</table>
<div class="head_style" <?php echo isset($mocktest_type['number_of_test_ft2_chk'])?"":"style='display:none;'"?>>Number of FT2 test: </div>                 
<table class="uk-table uk-table-small listTable" <?php echo isset($mocktest_type['number_of_test_ft2_chk'])?"":"style='display:none;'"?>>
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_test_ft2['xi_mathematics'])?$number_of_test_ft2['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft2['xi_physics'])?$number_of_test_ft2['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft2['xi_chemistry'])?$number_of_test_ft2['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft2['xi_biology'])?$number_of_test_ft2['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_test_ft2['xii_mathematics'])?$number_of_test_ft2['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft2['xii_physics'])?$number_of_test_ft2['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft2['xii_chemistry'])?$number_of_test_ft2['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft2['xii_biology'])?$number_of_test_ft2['xii_biology']:'' ?></td>
    </tr>
</table>
<div class="head_style" <?php echo isset($mocktest_type['number_of_test_ft3_chk'])?"":"style='display:none;'"?>>Number of FT3 test: </div>                 
<table class="uk-table uk-table-small listTable" <?php echo isset($mocktest_type['number_of_test_ft3_chk'])?"":"style='display:none;'"?>>
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_test_ft3['xi_mathematics'])?$number_of_test_ft3['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft3['xi_physics'])?$number_of_test_ft3['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft3['xi_chemistry'])?$number_of_test_ft3['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft3['xi_biology'])?$number_of_test_ft3['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_test_ft3['xii_mathematics'])?$number_of_test_ft3['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft3['xii_physics'])?$number_of_test_ft3['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft3['xii_chemistry'])?$number_of_test_ft3['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft3['xii_biology'])?$number_of_test_ft3['xii_biology']:'' ?></td>
    </tr>
</table>
<div class="head_style" <?php echo isset($mocktest_type['number_of_test_ft4_chk'])?"":"style='display:none;'"?>>Number of FT4 test: </div>                 
<table class="uk-table uk-table-small listTable" <?php echo isset($mocktest_type['number_of_test_ft4_chk'])?"":"style='display:none;'"?>>
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_test_ft4['xi_mathematics'])?$number_of_test_ft4['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft4['xi_physics'])?$number_of_test_ft4['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft4['xi_chemistry'])?$number_of_test_ft4['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft4['xi_biology'])?$number_of_test_ft4['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_test_ft4['xii_mathematics'])?$number_of_test_ft4['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft4['xii_physics'])?$number_of_test_ft4['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_ft4['xii_chemistry'])?$number_of_test_ft4['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_ft4['xii_biology'])?$number_of_test_ft4['xii_biology']:'' ?></td>
    </tr>
</table>
<div class="head_style" <?php echo isset($mocktest_type['number_of_test_fmt_chk'])?"":"style='display:none;'"?>>Number of FMT test: </div>                 
<table class="uk-table uk-table-small listTable" <?php echo isset($mocktest_type['number_of_test_fmt_chk'])?"":"style='display:none;'"?>>
    <tr class="borderTitle">
        <td rowspan="2">Class</td>
        <td colspan="4">Subject</td>
    </tr>
    <tr class="borderTitle">
        <td>Mathematics</td>
        <td>Physics</td>
        <td>Chemistry</td>
        <td>Biology</td>
    </tr>
    <tr>
        <td>XI</td>
        <td><?php echo isset($number_of_test_fmt['xi_mathematics'])?$number_of_test_fmt['xi_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_fmt['xi_physics'])?$number_of_test_fmt['xi_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_fmt['xi_chemistry'])?$number_of_test_fmt['xi_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_fmt['xi_biology'])?$number_of_test_fmt['xi_biology']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>
        <td><?php echo isset($number_of_test_fmt['xii_mathematics'])?$number_of_test_fmt['xii_mathematics']:'' ?></td>
        <td><?php echo isset($number_of_test_fmt['xii_physics'])?$number_of_test_fmt['xii_physics']:'' ?></td>
        <td><?php echo isset($number_of_test_fmt['xii_chemistry'])?$number_of_test_fmt['xii_chemistry']:'' ?></td>
        <td><?php echo isset($number_of_test_fmt['xii_biology'])?$number_of_test_fmt['xii_biology']:'' ?></td>
    </tr>
</table>
<!-- aa -->


<div style="height:70px; width:100%"> </div>
<? echo footer_text($page=2); ?>

<?  echo $head;?>

<div class="head_style" >Name of the  Co-curricular Activities Observed in This Month:
</div>

<div style="border:1px solid #666666; height:60px; width:600px; margin:auto; padding:10px;" ><?php echo isset($data['co_curricular_activity'])?$data['co_curricular_activity']:'' ?> </div>

<div class="head_style" >Name of the  Cultural Programs Observed in this Month:</div>
<div style="border:1px solid #666666; height:60px; width:600px; margin:auto;padding:10px;" ><?php echo isset($data['cultural_programme'])?$data['cultural_programme']:'' ?></div>

<div class="head_style" >Number of Motivational Programs and Counselling Done: </div>
<table class="uk-table uk-table-small listTable">
    <tr class="borderTitle">
        <td>Class</td>
        <td>Motivational programs</td>
        <td>Counselling</td>
    </tr>
    <tr>
        <td>XI</td>             
        <td><?php echo isset($motivational_programme['xi_motivational_programs'])?$motivational_programme['xi_motivational_programs']:'' ?></td>
        <td><?php echo isset($motivational_programme['xi_counsilling'])?$motivational_programme['xi_counsilling']:'' ?></td>
    </tr>
    <tr>
        <td>XII</td>

        <td><?php echo isset($motivational_programme['xii_motivational_programs'])?$motivational_programme['xii_motivational_programs']:'' ?></td>
        <td><?php echo isset($motivational_programme['xii_counsilling'])?$motivational_programme['xii_counsilling']:'' ?></td>
    </tr>
</table>
<div style="height:200px; width:100%"> </div>
<? echo footer_text($page=3); ?>

</div>	

<style>
    .head_style{ text-align:center; font-size:16px; font-weight:bold; border:1px solid #999999; padding:5px 5px; width:300px; margin:auto; margin-top:20px; border-bottom:none;}
    .listTable{ margin:auto;}
    .listTable td{ text-align:center;}
</style>
<script>
    function printPage(){
        document.getElementById("printBtn").style.display="none";
        window.print();
        document.getElementById("printBtn").style.display="block";
    }

</script>

</body>
</html>
