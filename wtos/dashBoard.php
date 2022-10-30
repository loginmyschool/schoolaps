<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?>
<? 

function getResults($q,$keyFld='',$valFld='')
{
	global $os;
	
	$data=array();
	$totalQ=$os->mq($q);
	while($rec=$os->mfa($totalQ))
	{
	   
	   if($keyFld!='' && $valFld!='' )
	   {
	        $data[$rec[$keyFld]]=$rec[$valFld];
	   }
	   elseif($keyFld!='' && $valFld=='')
	   {
	     $data[$rec[$keyFld]]=$rec;
	   
	   }else
	   {
	      $data[]=$rec;
	   
	   }
	   
	    
	}
	return $data;
	
}
$month=$os->dateIntervalList(date('Y-m-d', strtotime('-11 Month')),date('Y-m-d'),$intervals='P1M',$format='F Y' ,$modify='+1 Month');// $begin $end  format 2012-08-01
$month=array_reverse ( $month);

$monthLimit=12;
 
  $totalQ="SELECT sum(totalPayble) payble_amt , sum(totalPayble) paid_amount , year as dm FROM fees_student   group by (year) order by year asc limit 5  ";
 
 
 
 
 $fees_all_afterFiveYears=getResults($totalQ,'dm','');
//_d($fees_all_afterFiveYears);

  $totalQ="SELECT sum(eld.total_incl_tax) exp_amt ,  date_format(el.dated, '%Y') dm FROM expense_list_details eld , expense_list el where eld.expense_list_id=el.expense_list_id  group by  dm order by el.dated asc  limit 5 ";
$expense_all_afterFiveYears=getResults($totalQ,'dm','');

$totalQ="SELECT sum(paidAmount) paid_amount ,  date_format(paidDate, '%Y') dm FROM salary group by  dm order by paidDate asc limit 5  ";
$salary_all_afterFiveYears=getResults($totalQ,'dm','');
 


$totalQ="SELECT count(*) student_count FROM  student";
$student_count=getResults($totalQ);



$blankArray=array('paybleAmount_amt'=>0,'paidAmount_amt'=>0,'dueAmount_amt'=>0,'sgstAmount_amt'=>0,'cgstAmount_amt'=>0,'dm'=>'');
// take only last 12 month
$fees_all_temp=array();

$expense_all_temp=array();
$salary_all_temp=array();
foreach($month as $mVal)
{ 
}
 


 
$month_last=date('F Y');
$feesAll=$fees_all[$month_last];
$expense_all=$expense_all[$month_last];
 
$salary_all=$salary_all[$month_last];

$dashboard['payble_amt']=$feesAll['payble_amt']; 
$dashboard['paid_amount']=$feesAll['paid_amount']; 
$dashboard['due_amount']=$feesAll['payble_amt']-$feesAll['paid_amount']; 
$dashboard['fees_month']=$month_last;



$dashboard['exp_amt']=$expense_all['exp_amt']; 
$dashboard['exp_month']=$month_last;


$dashboard['salary_amt']=$salary_all['paid_amount']; 
$dashboard['salary_month']=$month_last;

$dashboard['student_count']=$student_count[0]['student_count'];

foreach($dashboard as $k=>$v)
{
  if($v=='')
  {
  $dashboard[$k]='0'; // atleast show 0
  }

}
$currentMonth=date('m');
$currentYear=date('Y');
 
$feesQueryFor1mnth="SELECT sum(totalPayble) payble_amt  FROM fees_student  where    month<='$currentMonth' and year<='$currentYear' ";
$totalAndPaidFees=getResults($feesQueryFor1mnth);
$totalAndPaidFees=$totalAndPaidFees[0];
$currentMonthTotalFees=(int)$totalAndPaidFees['payble_amt'];
 
 
  $feesQueryFor1mnth="SELECT sum(totalPayble) payble_amt  FROM fees_student  where    month<='$currentMonth' and year<='$currentYear' and  paymentStatus='paid'";
$totalAndPaidFees=getResults($feesQueryFor1mnth);
$totalAndPaidFees=$totalAndPaidFees[0];
$currentMonthPaidFees=(int)$totalAndPaidFees['payble_amt'];
 
 
 
 $currentMonthDueFees=$currentMonthTotalFees-$currentMonthPaidFees;
 
 
  $feesQueryFor1mnth="SELECT sum(total_incl_tax) expamt  FROM expense_list_details  ";
$totalAndPaidFees=getResults($feesQueryFor1mnth);
$totalAndPaidFees=$totalAndPaidFees[0];
$expense_amt=(int)$totalAndPaidFees['expamt'];
 
  $querydata="SELECT sum(payble) salary_amt  FROM salary  ";
$querydatars=getResults($querydata);
$querydatars=$querydatars[0];
$salary_amt=(int)$querydatars['salary_amt'];
 
?>
<style type="text/css">
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
img{ max-width:100%;}
.clear{ clear:both;}
body{  }
.main{width:1170px; margin:0 auto; }
.box{background:#ffffff; color:#6a6a6b; border:1px solid #e2e2e2; border-radius:3px; margin-top:2px; }
.titel_bar{ margin:10px 0 10px 0; padding:10px 20px;}
.titel_bar h2{ font-size:22px; line-height:1; color:#5A5A5A; margin:0; padding:0; font-weight:100;}
.row_a{margin-right: -5px;margin-left: -5px;}
.row_a:before{display: table;content: " ";}
.row_a:after{clear: both;}
.col_2{ position: relative;
		min-height: 1px;
		padding-right: 5px;
		padding-left: 5px;
		float: left;
		width: 14.27%;}
.col_4{ position: relative;
		min-height: 1px;
		padding-right: 5px;
		padding-left: 5px;
		float: left;
		width: 33.33333333%;
        }	
		
	.col_6{ position: relative;
		min-height: 1px;
		padding-right: 5px;
		padding-left: 5px;
		float: left;
		width: 50%;
        }			
.box .titel_top{ margin:0; padding:10px 10px 10px 10px; border-bottom:1px solid #e5e5e5;} 
.box .titel_top h2{ margin:0px; padding:0px; font-size:15px; font-weight:normal; line-height:1; color:#5c5c5c; font-weight:bold; }
.box .left_image{ float:left; width:40px;}
.box .right_containt{ padding-left:50px;}
.box .right_containt h3{ margin:0; padding:0; font-size:11px; color:#c5c5c5; font-weight:normal;}
.box .right_containt h1{ margin:0; padding:0; font-size:24px; color:#2c2c2c; font-weight:normal;}
.box .mid_con{ padding:10px;}

.big_box{ margin-top:10px;}
.big_box .titel_top h3{ float:right; color:#bababa; margin:0; padding:0; font-size:14px; font-weight:normal; margin-top:2px;}
.big_box .titel_top h2{ float:left;}
.data_table{ margin:0; padding:0; width:100%; font-size:12px; color:#4c4c4c; border-collapse:collapse;}
.data_table tr{ border-bottom:1px solid #ececec;}
.data_table tr:last-child{ border-bottom:none;}
.data_table tr td{ padding:6px 4px;}
.data_table tr td.name{ font-weight:600;}	
.btnStyle{ height:33px;}	
</style>

<div style="margin:20px;">
 <div class="mainss">
	<div class="box titel_bar">
    	<h2>REPORT OVERVIEW</h2>
    </div>
    <div class="row_a">
    	<div class="col_2 small_box">
        	<div class="box">
            	<div class="titel_top">
                	<h2>Student Count</h2>
                </div>
                <div class="mid_con">
                	<div class="left_image"><img src="images/member_icon.jpg"/></div>
                    <div class="right_containt">
                    <h3>Total </h3>
                	<h1><? echo $dashboard['student_count'] ?></h1>
                </div>
                </div>
            </div>
        </div>
		<div class="col_2 small_box">
        	<div class="box">
            	<div class="titel_top" >
                	<h2>Total Fees</h2>
                </div>
                <div class="mid_con">
                	<div class="left_image"><img src="images/product.png"/></div>
                    <div class="right_containt">
                    <h3> Upto <? echo $dashboard['fees_month'] ?> </h3>
                	<h1><? //echo $dashboard['payble_amt'] 
					if($currentMonthTotalFees)
					{
					echo $currentMonthTotalFees;
					}
					else
					{
						echo "0";
					}
					?></h1>
                </div>
                </div>
            </div>
        </div>
        <div class="col_2 small_box">
        	<div class="box">
            	<div class="titel_top">
                	<h2> Paid Fees</h2>
                </div>
                <div class="mid_con">
                	<div class="left_image"><img src="images/paid.png"/></div>
                    <div class="right_containt">
                    <h3>Upto <? echo $dashboard['fees_month'] ?></h3>
                	<h1><? //echo $tbet=$dashboard['paid_amount']
					if($currentMonthPaidFees)
						{
                       echo $currentMonthPaidFees;
						}
					   
					   else
					{
						echo "0";
					}
					   ?></h1>
                </div>
                </div>
            </div>
        </div>
		
		<div class="col_2 small_box">
        	<div class="box">
            	<div class="titel_top">
                	<h2> Due Fees</h2>
                </div>
                <div class="mid_con">
                	<div class="left_image"><img src="images/due.png"/></div>
                    <div class="right_containt">
                    <h3>Upto <? echo $dashboard['fees_month'] ?></h3>
                	<h1><?// echo $dashboard['due_amount'] 
					echo $currentMonthDueFees;
					
					?></h1>
                </div>
                </div>
            </div>
        </div>
		
		
		<div class="col_2 small_box">
        	<div class="box">
            	<div class="titel_top">
                	<h2>Expense</h2>
                </div>
                <div class="mid_con">
                	<div class="left_image"><img src="images/exp.jpg"/></div>
                    <div class="right_containt">
                    <h3> Upto <? echo $dashboard['exp_month']?></h3>
                	<h1><? echo $expense_amt ?></h1>
                </div>
                </div>
            </div>
        </div>
		<div class="col_2 small_box">
        	<div class="box">
            	<div class="titel_top">
                	<h2>Salary</h2>
                </div>
                <div class="mid_con">
                	<div class="left_image"><img src="images/paid.png"/></div>
                    <div class="right_containt">
                    <h3>Up to <? echo $dashboard['salary_month'] ?></h3>
                	<h1><? echo $salary_amt ?></h1>
                </div>
                </div>
            </div>
        </div>
		
		<div class="col_2 small_box">
        	<div class="box">
            	<div class="titel_top">
                	<h2>SMS Balance</h2>
                </div>
                <div class="mid_con">
                	<div class="left_image"><img src="images/message.png"/></div>
                    <div class="right_containt">
               <h3>Total</h3>
                	<h1><? 
	include('sendSms.php');
	$smsObj= new sms;
	echo $msgBalance=$smsObj->balance();?></h1>
                </div>
                </div>
            </div>
        </div>
		
		
		
        <div class="clear"></div>
    </div>
    
    <div class="row_a">
    	<div class="col_4">
        	<div class="box big_box">
            	<div class="titel_top">
                	<h2>Fees </h2>
                    <h3>  </h3>
                    <div class="clear"></div>
                </div>
                <div class="mid_con">
                	<table class="data_table">
					
					<tr style="color:#D74600;">
                        	<td class="count">Year</td>
							 <td class="amount">Total</td>
                            <td class="name">Collected</td>
                            <td class="amount">Due</td>
                        </tr>
					<? 
					$count=1;
					foreach($fees_all_afterFiveYears as $rec) {	 ?>
					
				
                    	<tr>
                        	<td class="count" ><? echo $rec['dm'] ?></td>
							 <td class="amount"><? echo (int) $rec['payble_amt'] ?></td>
                            <td class="name" ><? echo (int)  $rec['paid_amount'] ?></td>
                            <td class="amount" ><? echo (int) $rec['payble_amt'] - $rec['paid_amount']?></td>
                        </tr>
                      <? $count++;}
					 
					 for($i=$count; $i<=5; $i++)
					 {
					 ?>
					  
					    <tr><td class="count" colspan="10">&nbsp; </td>                          
                        </tr>
					 
					 
					 <? } ?>

					                        
                    </table>
                </div>
            </div>
            
        </div>
      
	    <div class="col_4">
        	<div class="box big_box">
            	<div class="titel_top">
                	<h2>Expense </h2>
                    <h3>  </h3>
                    <div class="clear"></div>
                </div>
                <div class="mid_con">
                	<table class="data_table">
					
					<tr style="color:#D74600;">
                        	<td class="count">Year</td>
							 <td class="amount">Total Expense</td>
                         
                        </tr>
					<? 
					$count=1;
					foreach($expense_all_afterFiveYears as $rec) {	 ?>
					
				
                    	<tr>
                        	<td class="count" ><? echo $rec['dm'] ?></td>
							 <td class="amount" ><? echo (int) $rec['exp_amt'] ?></td>
                          
						
						
						</tr>
                     <? $count++;}
					 
					 for($i=$count; $i<=5; $i++)
					 {
					 ?>
					  
					    <tr><td class="count" colspan="10">&nbsp; </td>                          
                        </tr>
					 
					 
					 <? } ?>                        
                    </table>
                </div>
            </div>
            
        </div>
       
	    <div class="col_4">
        	<div class="box big_box">
            	<div class="titel_top">
                	<h2>Salary</h2>
                    <h3>  </h3>
                    <div class="clear"></div>
                </div>
                <div class="mid_con">
                	<table class="data_table">
					
					<tr style="color:#D74600;">
                        	<td class="count">Year</td>
							 <td class="amount">Amount</td>
                             
                        </tr>
					<? 
					$count=1;
					foreach($salary_all_afterFiveYears as $rec) {	 ?>
					
				
                    	<tr>
                        	<td class="count" ><? echo $rec['dm'] ?></td>
							 <td class="amount" ><? echo (int) $rec['paid_amount'] ?></td>
                            
                        </tr>
                     <? $count++;}
					 
					 for($i=$count; $i<=5; $i++)
					 {
					 ?>
					  
					    <tr><td class="count" colspan="10">&nbsp; </td>                          
                        </tr>
					 
					 
					 <? } ?>                        
                    </table>
                </div>
            </div>
            
        </div>
        <div class="clear"></div>
    </div>
	
	
	<div class="row_a">
    	<div class="col_4">
        	<div class="box big_box">
            	<div class="titel_top">
                	<h2>Fees</h2>
                    <h3> </h3>
                    <div class="clear"></div>
                </div>
                <div class="mid_con">
                	<div id="chart_div_transactionVol"></div> 
                </div>
            </div>
            
        </div>
        
        <div class="col_4">
        	<div class="box big_box">
            	<div class="titel_top">
                	<h2>Expense</h2>
                    <h3> </h3>
                    <div class="clear"></div>
                </div>
                <div class="mid_con">
                	<div id="chart_div_memberVol"></div> 
                </div>
            </div>
            
        </div>
		
		 <div class="col_4">
        	<div class="box big_box">
            	<div class="titel_top">
                	<h2>Salary</h2>
                    <h3> </h3>
                    <div class="clear"></div>
                </div>
                <div class="mid_con">
                	<div id="chart_div_salaryVol"></div> 
                </div>
            </div>
            
        </div>
		
		
        <div class="clear"></div>
    </div>
</div>

 



<div style="height:20px; padding:50px 0px 0px 5px;">For any help contact admin@webtrackers.co.im </div>
</div>
 

<? 
 $fees_all_afterFiveYears=array_reverse ( $fees_all_afterFiveYears);
 $expense_all_afterFiveYears=array_reverse ( $expense_all_afterFiveYears);
 
 
 $salary_all_afterFiveYears=array_reverse ( $salary_all_afterFiveYears);
 
//_d($salary_all_afterFiveYears);
 
// _d($expense_all_afterFiveYears);
 ?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      
      google.load('visualization', '1', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
	   google.setOnLoadCallback(drawChart2);
	    google.setOnLoadCallback(drawChart3);
	  
	  
	  
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
        data.addColumn('number', 'Transaction');
        data.addRows([
		<? foreach($fees_all_afterFiveYears as $rec) {	?>
 ['<? echo $rec['dm']  ?>', <? echo $rec['payble_amt']  ?>],
  
<?  } ?>
          
        ]);

      
        var options = {'title':'Transaction',
                       'width':'100%',
                       'height':300
					   

					   
					   };

        
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_transactionVol'));
        chart.draw(data, options);
      }
	  
	  
	  
	  
	 
	  
	  
	   function drawChart2() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
        data.addColumn('number', 'Transactions');
        data.addRows([
	<? 
	  
	foreach($expense_all_afterFiveYears as $rec) {	?>
 ['<? echo $rec['dm']  ?>', <? echo $rec['exp_amt']  ?>],
  
<?  } ?>
          
        ]);

      
        var options = {'title':'Transactions',
                       'width':'100%',
                       'height':300
					   

					   
					   };

        
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_memberVol'));
        chart.draw(data, options);
      }
	  
	  
	  
	
	  
	   function drawChart3() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
        data.addColumn('number', 'Transactions');
        data.addRows([
	<? 
	  
	foreach($salary_all_afterFiveYears as $rec) {	?>
 ['<? echo $rec['dm']  ?>', <? echo $rec['paid_amount']  ?>],
  
<?  } ?>
          
        ]);

      
        var options = {'title':'Transactions',
                       'width':'100%',
                       'height':300
					   

					   
					   };

        
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_salaryVol'));
        chart.draw(data, options);
      }
	
	
	
	
	
	  
	  
	   
    </script>
	 <? include($site['root-wtos'].'bottom.php'); ?>