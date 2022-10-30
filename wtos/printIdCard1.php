
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$historyId = $_GET['historyId'];
$historyIdVal = substr($historyId,0,-1);//for remove last comma(,)
?>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,300i,400,400i,500,500i,700,900" rel="stylesheet"/>
  <style>
  body{ margin:0; padding:0;}
    .cler{ clear:both;}
    img{ max-width:100%;}
  	.admin_print_block{ margin:0 auto; padding:5px; width:780px;
	color: #666666;
	font-family: 'Roboto', sans-serif;
	font-size: 14px;
	line-height: 1.4;
	font-weight: 300}
	.admin_print_block table{ width:48%; float:left; border-collapse: collapse; border-spacing: 0; margin:15px 0 15px 0; vertical-align:top; }
	.admin_print_block .table:nth-child(2n+2){ float:right; clear:right;}
	.admin_print_block .table:nth-child(2n+1){ clear:left;}
	.admin_print_block table h3{ margin:0 0 10px 0; font-size:16px; font-weight:400;}
	.admin_print_block table p{ margin:5px 0;}
	.admin_print_block .table{ background:#f5f5f5; height:360px;}
	.admin_print_block .table tr td{ padding:8px; vertical-align:top;}
	.admin_print_block .table .nes_table{ width:100%; margin:0;}
	.admin_print_block .table .nes_table tr td{ padding:2px 2px;}
	.admin_print_block .table strong{ font-weight:400;}
	
  </style>
</head>

<body>
<div style="width:780px; margin-top:10px; text-align:center;" id="printBtn"><input type="button" onclick="printPage()" value="Print" />
</div>
<div class="admin_print_block">

<? 



         $historyQuery="select * from history where historyId IN($historyIdVal)";
		 $historyMq=$os->mq($historyQuery);
		 while($historyData=$os->mfa($historyMq))
		
		 { 
	 		$studentIdArray[]= $historyData['studentId'];
		 }
	     $studentIdStr=implode(",",$studentIdArray);
		 
		 
		$studentQuery="select * from student where studentId IN($studentIdStr)";
		 $studentMq=$os->mq($studentQuery);
		 while($studentData=$os->mfa($studentMq))
		
		 { 
	 		
		 
	 
	 
	 ?>

	<table class="table">
    	<tr>
        	<td colspan="2">
            	<h3>University Institute Of Technology</h3>
                <p>                	np211, salt Lake sector5, Kolkata, West Bengal 700102
                </p>
                <p>Phone: +91 96354 03722</p>
            </td>
        </tr>
        <tr>
        	<td style="width:100px"><img src="<?echo $site['url'].$studentData['image']?>" alt="image"/></td>
            <td>
            	<p><strong>Name:</strong> <?echo $studentData['name']?></p>
                <p><strong>D.O.B:</strong> <?echo $os->showdate($studentData['dob'])?></p>
                <p><strong>Reg No:</strong> <?echo $studentData['registerNo']?></p>
                <p><strong>Blood Group:</strong> <?echo $studentData['blood_group']?> </p>
                <p><strong>Emergancy No:</strong> <?echo $studentData['mobile_emergency']?></p>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<p>Signature Of The Authority ............................</p>
            </td>
        </tr>
    </table>
		 <?}?>
	
  <!--  <table class="table">
    	<tr>
        	<td colspan="2">
            	<h3>University Institute Of Technology</h3>
                <p>
                	np211, salt Lake sector5, Kolkata, West Bengal 700102
                </p>
                <p>Phone: +91 96354 03722</p>
            </td>
        </tr>
        <tr>
        	<td style="width:150px"><img src="http://webhouse4u.co.uk/wtos-images/alphasecurityjobs_com.png" alt="image"/></td>
            <td>
            	<p><strong>Name:</strong> Tarak Paul</p>
                <p><strong>Class:</strong> V</p>
                <p><strong>D.O.B:</strong> 17/10/1992</p>
                <p><strong>Reg No:</strong> 12345</p>
                <p><strong>Blood Group:</strong> O+ </p>
                <p><strong>Phone No:</strong> 9007636254</p>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<p>Signature Of The Authority ..................</p>
            </td>
        </tr>
    </table>
    <table class="table">
    	<tr>
        	<td colspan="2">
            	<h3>University Institute Of Technology</h3>
                <p>
                	np211, salt Lake sector5, Kolkata, West Bengal 700102
                </p>
                <p>Phone: +91 96354 03722</p>
            </td>
        </tr>
        <tr>
        	<td style="width:150px"><img src="http://webhouse4u.co.uk/wtos-images/alphasecurityjobs_com.png" alt="image"/></td>
            <td>
            	<p><strong>Name:</strong> Tarak Paul</p>
                <p><strong>Class:</strong> V</p>
                <p><strong>D.O.B:</strong> 17/10/1992</p>
                <p><strong>Reg No:</strong> 12345</p>
                <p><strong>Blood Group:</strong> O+ </p>
                <p><strong>Phone No:</strong> 9007636254</p>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<p>Signature Of The Authority ..................</p>
            </td>
        </tr>
    </table>
    <table class="table">
    	<tr>
        	<td colspan="2">
            	<h3>University Institute Of Technology</h3>
                <p>
                	np211, salt Lake sector5, Kolkata, West Bengal 700102
                </p>
                <p>Phone: +91 96354 03722</p>
            </td>
        </tr>
        <tr>
        	<td style="width:150px"><img src="http://webhouse4u.co.uk/wtos-images/alphasecurityjobs_com.png" alt="image"/></td>
            <td>
            	<p><strong>Name:</strong> Tarak Paul</p>
                <p><strong>Class:</strong> V</p>
                <p><strong>D.O.B:</strong> 17/10/1992</p>
                <p><strong>Reg No:</strong> 12345</p>
                <p><strong>Blood Group:</strong> O+ </p>
                <p><strong>Phone No:</strong> 9007636254</p>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<p>Signature Of The Authority ..................</p>
            </td>
        </tr>
    </table>
    <table class="table">
    	<tr>
        	<td colspan="2">
            	<h3>University Institute Of Technology</h3>
                <p>
                	np211, salt Lake sector5, Kolkata, West Bengal 700102
                </p>
                <p>Phone: +91 96354 03722</p>
            </td>
        </tr>
        <tr>
        	<td style="width:150px"><img src="http://webhouse4u.co.uk/wtos-images/alphasecurityjobs_com.png" alt="image"/></td>
            <td>
            	<p><strong>Name:</strong> Tarak Paul</p>
                <p><strong>Class:</strong> V</p>
                <p><strong>D.O.B:</strong> 17/10/1992</p>
                <p><strong>Reg No:</strong> 12345</p>
                <p><strong>Blood Group:</strong> O+ </p>
                <p><strong>Phone No:</strong> 9007636254</p>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<p>Signature Of The Authority ..................</p>
            </td>
        </tr>
    </table>
    <table class="table">
    	<tr>
        	<td colspan="2">
            	<h3>University Institute Of Technology</h3>
                <p>
                	np211, salt Lake sector5, Kolkata, West Bengal 700102
                </p>
                <p>Phone: +91 96354 03722</p>
            </td>
        </tr>
        <tr>
        	<td style="width:150px"><img src="http://webhouse4u.co.uk/wtos-images/alphasecurityjobs_com.png" alt="image"/></td>
            <td>
            	<p><strong>Name:</strong> Tarak Paul</p>
                <p><strong>Class:</strong> V</p>
                <p><strong>D.O.B:</strong> 17/10/1992</p>
                <p><strong>Reg No:</strong> 12345</p>
                <p><strong>Blood Group:</strong> O+ </p>
                <p><strong>Phone No:</strong> 9007636254</p>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<p>Signature Of The Authority ..................</p>
            </td>
        </tr>
    </table>-->
    <div class="cler"></div>



</div>
  <script>
	function printPage(){
		document.getElementById("printBtn").style.display="none";
		window.print();
		document.getElementById("printBtn").style.display="block";
	}
	
</script>

</body>
</html>
