<?php



# these properties only for common purpose ( backend , front, and ,plugin)

class librarySettings extends wtosLibrary

{
	var $dateFormatDB='Y-m-d H:i:s';
	var $provider_type= array('Agency'=>'Agency','Inhouse'=>'Inhouse');
	var $travel_approved_status=array('Approved'=>'Approved','Rejected'=>'Rejected');
	var $travel_paid_status=array('Paid'=>'Paid','Pending'=>'Pending');
	var $isMetting= array ('Yes'=>'Yes','No' => 'No');
	var $approvedStatus=array ( 'Approved' => 'Approved','Pending' => 'Pending');
	var $unit=array ( 'pcs' => 'pcs','kg' => 'kg','meter' => 'meter','feet' => 'feet','gram' => 'gram','other' => 'other','Coil' => 'Coil');
	var $type=array('product-material' =>'product-material' ,'service'=>'service' );
	var $allow_user=array('student'=>'student','staff'=>'staff');
	var $questionType=array('Multiple Choice'=>'Multiple Choice','Descriptive'=>'Descriptive');
	var $othersPaymentType=array('Expense'=>'Expense','Budget'=>'Budget');
	var $form_status=array('new'=>'new','rejected'=>'rejected','waiting'=>'waiting','approved'=>'approved','admitted'=>'admitted');
	var $form_status_color=array ('new' => 'CACACA','rejected'=>'FF8080','waiting'=>'faa05a','approved' => '9FFFB8','admitted'=>'1e87f0');
	var $branch_name=array('Jangipur branch Girls Campus v-xii'=>'Jangipur branch Girls Campus v-xii','Jangipur branch Boys Campus V-X'=>'Jangipur branch Boys Campus V-X','Jangipur branch Boys Campus XI-XII'=>'Jangipur branch Boys Campus XI-XII','Lalgola Boys Campus- V-XII'=>'Lalgola Boys Campus- V-XII');

	var $rentMonth = array (



		1 => 'January',

		2 => 'February',

		3 => 'March',

		4 => 'April',

		5 => 'May',

		6 => 'June',

		7 => 'July',

		8 => 'August',

		9 => 'September',

		10 => 'October',

		11 => 'November',

		12 => 'December'

	);
	
	var $medium_list=array('Bengali'=>'Bengali','English'=>'English');
	var $nationality_list=array('Indian'=>'Indian','Other'=>'Other');
	var $caste_list=array('Gen'=>'Gen','OBC-A'=>'OBC-A','OBC-B'=>'OBC-B'); 
	var $body_parts_list=array('Leg'=>'Leg','Hand'=>'Hand','Eye'=>'Eye','Ear'=>'Ear'); 
	var $living_area_dists_list=array('Dist.'=>'Dist.','Sub-Division'=>'Sub-Division','Town'=>'Town','Semi-Town'=>'Semi-Town','Vill'=>'Vill');
	var $living_area_gram_panchayet_list=array('Gram Panchayet'=>'Gram Panchayet','Municipality'=>'Municipality');


	var $father_qualification_list=array('Primary'=>'Primary','Upper Primary'=>'Upper Primary','Secondary'=>'Secondary','Higher Secondary'=>'Higher Secondary','graduate'=>'graduate','Post Graduate'=>'Post Graduate','Illiterate'=>'Illiterate'); 
	var $mother_qualification_list=array('Primary'=>'Primary','Upper Primary'=>'Upper Primary','Secondary'=>'Secondary','Higher Secondary'=>'Higher Secondary','graduate'=>'graduate','Post Graduate'=>'Post Graduate','Illiterate'=>'Illiterate'); 


	var $boardname_list=array('CBSE'=>'CBSE','ICSE'=>'ICSE','WBBME'=>'WBBME','WBBSE'=>'WBBSE');   
	var $twelve_stream_list=array('Sc'=>'Sc','Arts'=>'Arts','Comers'=>'Comers');   



	var $graduate_passed_list=array('With Hons.'=>'With Hons.','Without Hons'=>'Without Hons' ); 
	//var $admissionType=array (''=>'','New Admission' => 'New Admission','Re Admission' => 'Re Admission'); // conflict with fees
	var $admissionType=array ('Admission' => 'Admission','Readmission' => 'Readmission');
	var $admissionVerificationStatus= array (''=>'','Done' => 'Done','Rejected' => 'Rejected','Waiting' => 'Waiting');
	var $cronSendSms= array ('Yes'=>'Yes','No' => 'No');
	var $admissionVerificationStatusColor=array (''=>'','Done' => '00BF00','Rejected' => 'FB8979','Waiting' => 'FFFFFF');
	var $careerDepartment=array (''=>'','Day scholar teacher' => 'Day scholar teacher','Residential teacher' => 'Residential teacher','Cleark' => 'Cleark','Group-D' => 'Group-D');
	var $activeStatus=array ( 'active' => 'Active','inactive' => 'Inactive');
	var $studentAppStatus=array ( 'active' => 'Active','inactive' => 'Inactive');

	var $printHeader=array ( 'Yes' => 'Yes','No' => 'No');
	var $sortBy=array (
		'ID ASC' => 'ID ASC',
		'ID DESC' => 'ID DESC',
		'Name ASC' => 'Name ASC',
		'Name DESC' => 'Name DESC',
		'Registration ASC' => 'Registration ASC',
		'Registration DESC' => 'Registration DESC',
	);
	var $teacherExcelA=array('name'=>'Name','joinDate'=>'Join Date','permanentAddress'=>'Permanent Address','recentAddress'=>'Recent Address','mobile'=>'Mobile','email'=>'Email','note'=>'Note','specialization'=>'Specialization');
	var $historyExcelA=array('studentId'=>'Id','name'=>'Name','admissionType'=>'Admission Type','dob'=>'Date Of Birth','age'=>'Age','gender'=>'Gender','asession'=>'Year','class'=>'Class','section'=>'Section','stream'=>'Stream','admission_date'=>'Admission Date','adhar_no'=>'Adhar No','father_name'=>'Father Name','mother_name'=>'Mother Name','guardian_name'=>'Guardian Name','caste'=>'Caste','section'=>'Section','apl_bpl'=>'Apl Bpl','mobile_student'=>'Mobile Student','email_student'=>'Email','vill'=>'Vill','po'=>'Post Office','ps'=>'Police Station','dist'=>'Dist','block'=>'Block','state'=>'State','pin'=>'Pin','accNo'=>'Account No','accHolderName'=>'Account Holder Name','ifscCode'=>'Ifsc Code','branch'=>'Branch','registerDate'=>'Register Date','registerNo'=>'Register No','otpPass'=>'Password');
	var $newsType=array ( 'News' => 'News','Events' => 'Events');
	var $blood_group=array ( 'A+' => 'A+','A-' => 'A-','B+' => 'B+','B-' => 'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
	var $emp_language=array ( 'Bengali' => 'Bengali','English' => 'English','Hindi' => 'Hindi');
	var $eventsType=array ( 'Upcoming' => 'Upcoming', 'latest' => 'latest');
	var $bannerImgActive=array ( 'Active' => 'Active','Inactive' => 'Inactive');
	var $marquee= array ('0'=>'','1'=>'Yes');
	var $statusNew= array ('0'=>'','1'=>'Yes');
	var $remindStatus=array ('' => '',  'UW' => 'UW', 'UC' => 'UC', 'NC' => 'NC','Close' => 'Close');
	var $remindStatusColor=array (  'UC' => '#00E639','NC' => '#C60000', 'Close' => '#8A15FF');
	var $remindStatusColorBG=array (  'UC' => '#F2FFF2','NC' => '#FFF4F4', 'Close' => '#DFBFFF');
	var $inOutStatus=array (  'IN' => 'IN','OUT' => 'OUT');
	var $paymentethod=array (  'Cash' => 'Cash','Cheque' => 'Cheque','Online' => 'Online');
	var $mobile=array (  '8017477871' => '8017477871','8420025552' => '842002552','8420062927' => '8420062927');
	var $dailystatus=array ( 'Open' => 'Open','Close' => 'Close');
	var $verifyStatus=array ( 'Open' => 'Open','Close' => 'Close');
	var $followStatus=array ( '' => '','Appointment' => 'Appointment','Followup' => 'Followup','Not Interested' => 'Not Interested','Closed' => 'Closed');
	var $priority=array ( '' => '','1' => '1','2' => '2','3' => '3','4' => '4');
	var $productType=array ( 'product' => 'product','spare' => 'spare');
	var $cmpmStatus=array ( 'Open' => 'Open','Visit Alert' => 'Visit Alert','Visited' => 'Visited','Cancel' => 'Cancel');
	var $templatestatus=array ( 'active' => 'active','inactive' => 'inactive');
	var $academicSessionStatus=array ( 'active' => 'active','inactive' => 'inactive');
	var $paymentStatus=array ( 'Paid' => 'Paid','Due' => 'Due');
	var $reminderStatus=array ( 'UC' => 'UC','NC' => 'NC','UW' => 'UW');
	var $noYes=array ( 'No' => 'No','Yes' => 'Yes');
	var $yes=array ( 'Yes' => 'Yes','No' => 'No');
	var $frequency=array ( 'Monthly' => 'Monthly','Yearly' => 'Yearly');
	var $gender=array ( 'Male' => 'Male','Female' => 'Female');
	var $caste=array ( 'General' => 'General','OBC-A' => 'OBC-A','OBC-B' => 'OBC-B','SC' => 'SC','ST' => 'ST','Others' => 'Others');
	var $subcast=array ( 'A' => 'A','B' => 'B','C' => 'C','D' => 'D');
	var $yesno=array ( 'No' => 'No','Yes' => 'Yes');
	var $aplOrBpl=array ( 'APL' => 'APL','BPL' => 'BPL');
	var $certificate_content_type=array ( 'School leaving' => 'School leaving','Transfer' => 'Transfer','Charecter' => 'Charecter','Other' => 'Other', 'Sports'=>'Sports','Culture'=>'Culture');
	var $certificate_type=array ( 'Header' => 'Header','Body' => 'Body','Footer' => 'Footer');
	// var $asession=array ( '2018'=>'2018','2019'=>'2019','2020'=>'2020','2021' => '2021','2022' => '2022','2023'=>'2023','2024'=>'2024','2025' => '2025','2026' => '2026','2027'=>'2027','2028'=>'2028');
    ##Use New session From Wtos ##
	var $asession=array ();
    ##Use New session From Wtos ##
	var $stream=array ( 'Science' => 'Science','Humanities' => 'Humanities','Commerce' => 'Commerce');
	/*var $classList=array (
		'101'  => 'Nursery',
		'102'  => 'LKG',
		'103'  => 'UKG',
		'1'  => 'I',
		'2'  => 'II',
		'3'  => 'III',
		'4'  => 'IV',
		'5'  => 'V',
		'6'  => 'VI',
		'7'  => 'VII',
		'8'  => 'VIII',
		'9'  => 'IX',
		'10' => 'X',
		'11' => 'XI- Humanities',
		'12' => 'XI- Science',
		'13' => 'XI- Commerce',
		
		'21' => 'XII- Humanities',		
		'22' => 'XII-Science',
		'23' => 'XII-Commerce',
 
	);
	*/
	var $classList=array (
		 
		'5'  => 'V',
		'6'  => 'VI',
		'7'  => 'VII',
		'8'  => 'VIII',
		'9'  => 'IX',
		'10' => 'X',
		'11' => 'XI- Humanities',
		'12' => 'XI- Science',
		'13' => 'XI- Commerce',
		
		'21' => 'XII- Humanities',		
		'22' => 'XII-Science',
		'23' => 'XII-Commerce',
 
	);
	
	 
	var $board= array (
		'WB' => 'WB',
		 
	);
	var $special_boards = ['CBSE'];

	/*var $board_class = array(
		'WB' => array(5,6,7,8,9,10,11,12) ,
		'NEET' => array(17)
	);*/
	
	var $board_class = array(
		'WB' => array( 5,6,7,8,9,10,11,12,13,21,22,23),
		 
	);

	var $group_subject = array(
		'17' => array('Chemistry'=>'Chemistry','Physics'=>'Physics','Biology'=>'Biology'),
	);
	var $employee_type= array ( 'Residential' => 'Residential', 'Non Residential' => 'Non Residential', 'Guest' => 'Guest');

	var $teacherStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $guardianStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $section=array (
		'A' => 'A',
		'B' => 'B',
		'C' => 'C',
		'D' => 'D',
		'E' => 'E',
		'F' => 'F',
		'G' => 'G',
		'H' => 'H',
	);
	var $pass_fail=array ( 'No' => 'No','Yes' => 'Yes');
	var $feesStatus=array ( 'Paid' => 'Paid','Unpaid' => 'Unpaid');
	var $registrationFeesStatus=array ( 'Paid' => 'Paid','Unpaid' => 'Unpaid');
	var $salaryStatus=array ( 'Paid' => 'Paid','Unpaid' => 'Unpaid');
	var $subjectStatus=array ( 'Active' => 'Active','Inactive' => 'Inactive');
	var $paymentMethod=array (  'Cash' => 'Cash','Cheque' => 'Cheque','Online' => 'Online');
	var $feesMonth = array (

		'1' => 'January',

		'2' => 'February',

		'3' => 'March',

		'4' => 'April',

		'5' => 'May',

		'6' => 'June',

		'7' => 'July',

		'8' => 'August',

		'9' => 'September',

		'10' => 'October',

		'11' => 'November',

		'12' => 'December'

	);
	var $examMonth = array (

		'1' => 'January',

		'2' => 'February',

		'3' => 'March',

		'4' => 'April',

		'5' => 'May',

		'6' => 'June',

		'7' => 'July',

		'8' => 'August',

		'9' => 'September',

		'10' => 'October',

		'11' => 'November',

		'12' => 'December'

	);
	var $examYear=array( '2018'=>'2018','2019'=>'2019','2020'=>'2020','2021' => '2021','2022' => '2022','2023'=>'2023','2024'=>'2024','2025' => '2025','2026' => '2026','2027'=>'2027','2028'=>'2028');
	var $feesYear=array( '2018'=>'2018','2019'=>'2019','2020'=>'2020','2021' => '2021','2022' => '2022','2023'=>'2023','2024'=>'2024','2025' => '2025','2026' => '2026','2027'=>'2027','2028'=>'2028');
	var $yearSearch=array( '2018'=>'2018','2019'=>'2019','2020'=>'2020','2021' => '2021','2022' => '2022','2023'=>'2023','2024'=>'2024','2025' => '2025','2026' => '2026','2027'=>'2027','2028'=>'2028');
	var $examType=array( 'Offline'=>'Offline','Online'=>'Online');
	var $examStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $examDetailsStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $questionStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $resultStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $questionAnswerStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $admitPublish= array ('Yes'=>'Yes','No' => 'No');
	var $admitActive= array (''=>'','Active' => 'Active','Inactive' => 'Inactive');
	var $templateType=array ('Exam'=>'Exam','Result' => 'Result');
	var $instructionBorder=array ('Yes'=>'Yes','No' => 'No');
	var $admitStatusColor=array ('Active' => '9FFFB8','Inactive' => 'FF8080');
	var $admitPublishColor=array ('Yes' => '9FFFB8','No' => 'FF8080');
	var $resultDetailsStatus= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $fees_type = array ( 'Admission' => 'Admission', 'Readmission' => 'Readmission','Monthly' => 'Monthly'  );
	var $student_type = array ( 'Day Scholars' => 'Day Scholars', 'Day Boarding' => 'Day Boarding','Hosteler' => 'Hosteler'  );
	var $global_template_status= array ( 'Active' => 'Active', 'Inactive' => 'Inactive'  );
	var $global_template_status_color= array ( 'Active' => '9FFFB8', 'Inactive' => 'FF8080'  );
	var $global_template_type= array ( 'IdentyCard' => 'IdentyCard', 'FeesReceipt' => 'FeesReceipt' ,'MarkSheet' => 'MarkSheet','Certificate' => 'Certificate' );
	var $global_template_folder= array ( 'IdentyCard' => 'IdentyCard', 'FeesReceipt' => 'FeesReceipt'  ,'MarkSheet' => 'MarkSheet' ,'Certificate' => 'Certificate');
	var $staff_type= array ( 'Principle' => 'Principle', 'Head Master' => 'Head Master','Asistant Teacher' => 'Asistant Teacher', 'Operator' => 'Operator', 'Driver' => 'Driver' );
	var $assesment_report_updated=array('Yes'=>'Yes','No'=>'No','Partly'=>'Partly');
	var $departmental_meeting=array('Beng'=>'Beng','Eng'=>'Eng','Math'=>'Math','Science'=>'Science','SST'=>'SST','Arabic'=>'Arabic');

	/*
     * Unit group functions
     */
	var $unit_group_logos = array(
		"EOA" => "eoa_logo.png",
		 

	);
	var $unit_group_watermarks = array(
		"EOA" => "waterlogo.png",
		 
	);
	var $group_unit_list= array(
		 
		'EOA'=>'English Oriental Academy',
		 
	);

	var $departments =array(
		'Canteen'=>"Canteen",
		"Construction"=>"Construction",
		"Library"=>"Library",
		"Electrical"=>"Electrical",
		"General"=>"General"
	);

	var $campus_type =array(
		1=>"Hostel",
		2=>"School"
	);
	var $recoverable =array(
		"No"=>"No",
		"Yes"=>"Yes"
	);
	var $show_in_daily_report =array(
		"No"=>"No",
		"Yes"=>"Yes"
	);

	var $item_type =array(
		"Product"=>"Product",
		"Service"=>"Service"
	);
	var $item_unit =array(
		"Pcs"=>"Pcs",
		"Kg"=>"Kg",
		"Gram"=>"Gram",
		"Liter"=>"Liter",
		"Ml"=>"Ml",
		'Coil' => 'Coil',
		'Feet' => 'Feet',
		'Meter' => 'Meter'


	);
	var $signatory_authority_keys = array(
		"grade_card" => "Grade Card"
	);
	var $payment_status=array('Paid'=>'Paid','Pending'=>'Pending');
	var $payment_mode=array (  'Cash' => 'Cash','Cheque' => 'Cheque','Online' => 'Online');

	var $status_active=array('N'=>'Inactive','Y'=>'Active');

	var $eclass_material_type = [
		""=>"",
		"1"=>"Study Materials",
		"2"=>"Homework"
	];

	//please sync with admi table  array
	// please sync with portal config
	function getSettings($key="")
	{


		$settings = [];
		$query = $this->mq("SELECT keyword, value FROM settings");
		while($setting = $this->mfa($query)){
			$settings[$setting["keyword"]] = $setting["value"];
		}

		if($key!==""){
			return isset($settings[$key])?$settings[$key]:false;
		}
		return  $settings;

	}
	function processLogin($userField,$passwordField,$tablename,$condition='')
	{
		if($this->post('SystemLogin')=='SystemLogin')

		{

			$rss='';

			if($userField!="" && $passwordField!="" && $tablename!=""  )

			{

				if($_POST[$userField]!="" && $_POST[$passwordField]!="")

				{

					$_POST[$userField]=str_replace(array("'",'"',';','-'),'',$_POST[$userField]);

					$rsu=$this->mq("select * from  $tablename where BINARY $passwordField='".$_POST[$passwordField]."'  and BINARY $userField='".$_POST[$userField]."'   $condition  ");

					$rss=$this->mfa($rsu);

				}



				if($rss[$userField]!='')

				{

					$this->Login($rss);



					return true;

				}

			}

		}
		return false;
	}
	function saveCronSms($smsText,$mobileNos , $status='send' ,$note='',$MobileNo='',$studentId='',$studentName='',$totalPendingAmt='',$totalPendingMonth='',$addedBy='')

	{

		$currentDate=$this->showDate($this->now());

		$currentDateA=explode('-',$currentDate);

		$monthV=$currentDateA[1];

		$yearV=$currentDateA[2];

		$dataToSave['studentId']=$studentId;

		$dataToSave['name']=$studentName;

		$dataToSave['totalPendingAmt']=$totalPendingAmt;

		$dataToSave['totalPendingMonth']=$totalPendingMonth;



		$dataToSave['sendingMonth']=$monthV;

		$dataToSave['sendingYear']=$yearV;

		$dataToSave['smsText']=$smsText;

		$dataToSave['dated']=$this->now();

		$dataToSave['status']=$status;

		$dataToSave['mobileNos']=$mobileNos;

		$dataToSave['note']=$note;

		$dataToSave['addedBy']=$addedBy;

		$dataToSave['addedDate']=$this->now();

		$qResult=$this->save('cronsms',$dataToSave,'cronsmsId','');



	}
	function calculateRegPaymentTotal($option,$linkidVal)
	{
		$condition='';
		extract($option);
		if($linkidVal!=''){
			$condition .="  $foreignId!='' and $foreignId>0 ";
			$condition .=" and $foreignId='$linkidVal'";
		}
		$tableQuery=str_replace('[condition]',$condition,$tableQuery);
	    //echo  $tableQuery;
		$rs=$this->mq($tableQuery);
		$result=0;
		while($rec=$this->mfa($rs))
		{
			$result +=(float)$rec['paidRegistrationFees'];
		}
		echo $result;
	}
	function calculatePaymentTotal($option,$linkidVal)



	{



		$condition='';



		extract($option);



		if($linkidVal!='')



			{ $condition .="  $foreignId!='' and $foreignId>0 ";



		$condition .=" and $foreignId='$linkidVal'";



	}



	$tableQuery=str_replace('[condition]',$condition,$tableQuery);



			//echo  $tableQuery;



	$rs=$this->mq($tableQuery);



	$result=0;



	while($rec=$this->mfa($rs))



	{







		$result +=(float)$rec['paidAmount'];







	}



	echo $result;











}
function calculateProductAmmount($option,$linkidVal)



{



	$condition='';



	extract($option);



	if($linkidVal!='')



		{ $condition .="  $foreignId!='' and $foreignId>0 ";



	$condition .=" and $foreignId='$linkidVal'";



}



$tableQuery=str_replace('[condition]',$condition,$tableQuery);



			//echo  $tableQuery;



$rs=$this->mq($tableQuery);



$result=0;



while($rec=$this->mfa($rs))



{







	$result +=(float)$rec['totalPrice'];







}



echo $result;











}
function updateFollowupdate($option,$linkidVal)



{







	$lastDate='';



	$data=array();



	$lastFdateQ=" select * from followuphistory where id='$linkidVal' order by dated desc limit 1";



	$rs=$this->mq($lastFdateQ);



	$rs=$this->mfa($rs);











	if(isset($rs['dated']))



	{



		if($rs['dated']!='' && $rs['dated']!='0000-00-00 00:00:00' ){







			$lastDate=  $this->showDate($rs['dated']);



			$data['date']=$lastDate;



			$this->save('followupcontact',$data,'id',$linkidVal);



		}



	}



	echo  $lastDate;







}
function showContact($data)



{



	?>



	<span style=" font-size:10px">



		<b style="font-size:12px;"><?  echo $data['person'];  ?> </b><br /> <?  echo $data['company'];  ?> <br />



		<span style="color:#00A429"><?  echo $data['phone'];  ?></span>&nbsp;<br /> <span style="color:#009EEA"><?  echo $data['email'];  ?></span>







		<?



	}
    function showProduct($products,&$prodNameList) // $formats=array()



    {



    	?>



    	<table class="showProductTable"  border="0" cellpadding="0" cellspacing="0">



    	<tr>



    	<td style="width:150px;">Name/Serial</td>



    	<td>Qty</td>



    	<td>Amt</td>



    	</tr>







    	<?  foreach($products as $product){  ?>



    		<tr>



    		<td> <?  echo $prodNameList[$product['rbproductId']];?>



    		<? if($product['serialNo']!=''){ ?><br />



    			<span style="color:#005EBB; font-size:10px;"> <?  echo $product['serialNo'];  ?> </span>



    		<? } ?>







    	</td>



    	<td><?  echo $product['quantity'];  ?></td>



    	<td><?  echo $product['totalPrice'];  ?></td>







    </tr>



<? } ?>



</table>















<?



}
var $productsArray=array();
function getProductsArray()



{



	return $this->options('rbproductId','name,model','rbproduct',$where='',$orderby='',$limit='');



}
function showMsgHistory($msgListData,$style='title')



{



	global $site;



	$str = '';



	if($style=='title')



	{



		ob_start();?>











		<table class="showProductTable msghover"  border="0" cellpadding="0" cellspacing="0" style="background-color:#DDFFDD;"><?



		foreach($msgListData as $msg )



		{



				//$str .= $this->showDate($msg['msgDate']).' '.$msg['mobileno'].' '.$msg['msg'].'<br>';



			$msgImg='msg.gif';







			if($msg['msgStatus']=='notsend')



			{



				$msgImg='msg_nd.gif';



			}











			?><tr title="<?  echo $msg['msg'];  ?>">



				<td> <?  echo  $this->showDate($msg['msgDate']);?>







			</td>



			<td><?  echo $msg['mobileno'];  ?></td>



			<td><img src="<?php echo $site['url-wtos']?>images/<? echo $msgImg ?>"  /></td>







			</tr>	<?











		}



		?></table><? $str .=ob_get_clean()	;



	}



	return $str;



}
function sendAmcSMS($option,$linkidVal)



{



	include('sendSms.php');



	$sms=new sms;



	global $site;



	$mobNo='';



	if($site['softwaremode']=='demo')



	{



		$userDetails=  $this->session($this->loginKey,'logedUser');



		$mobNo=$userDetails['mobileNo'];



	}







	$lastFdateQ=" select * from smshistory where rbsbillId='$linkidVal' and msgStatus='notsend'";



	$rs=$this->mq($lastFdateQ);



	while($msgdata=$this->mfa($rs))



	{











		$smshistoryId=$msgdata['smshistoryId'];



		$mobNo=$msgdata['mobileno'];



		$smsText=$msgdata['msg'];











		if($site['softwaremode']=='demo')



		{







			$mobNo=$userDetails['mobileNo'];



		}











		if(trim($smsText)!='' && trim($mobNo)!='' )



		{



			$mobNo ='8017477871';  $smsText='Hi testing';// testing data



			## $sms->sendSMS($smsText,$mobNo);







			$dataToupdate['msgStatus']='send';



			$this->save('smshistory',$dataToupdate,'smshistoryId',$smshistoryId);







		}







	}















	echo '-SMS-';



	echo $this->now('d-m-Y');



	echo '-SMS-';



	echo $mobNo;



	echo '-SMS-';



}
function getTemplateData($valuePair=array())



{



	$smsText=array();



	$smsRs=$this->get_smstemplate();



	while($sms=$this->mfa($smsRs))



	{



		$smsText[$sms['smstemplateId']]=$sms['text'];







	}



	return $smsText;



}
    function showFees($pay) // $formats=array()



    {





    	if(is_array($pay))

    	{

    		foreach($pay as $data)



    		{

    			$dueColor='style="color:#006600"';



    			if($data['status']=='Unpaid')



    			{



    				$dueColor='style="color:#FF3300"';



    			}



    			if($data['paid_amount']<1){$data['paid_amount']='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}



    			?>

    			<div class="feespayments">

    				<?  echo $data['paid_amount'];  ?> <span class="feesmonth"> <? echo $this->val($this->feesMonth,$data['month']);  ?> <?  echo $data['year'];  ?></span>

    			</div>

    			<?



    		}









    	}



    }
    function generateOTP() // new otp

    {

    	$otp=rand(10000,99999);

    	return $otp;

    }
    function showRegFeesDetails($regPay,$totalRegFeesAmt,$regfeesStatus) // $formats=array()



    {

    	$statusColor='';

    	if($regfeesStatus=='Unpaid')

    	{

    		$statusColor='style="color:red;"';

    	}

    	if($regfeesStatus=='Paid')

    	{

    		$statusColor='style="color:green;"';

    	}

    	?>





    	<style>

    		.t-height tr td{ height:auto; line-height:1;}



    	</style>







    	<table  border="0" cellpadding="0" cellspacing="0" style="font-size:10px;" class="t-height" >

    		<tr> <!--<td style="width:80px;">Total Fees</td>--> <td style="text-align:right; color:#000099"><?php echo $totalRegFeesAmt?> (<span <?echo $statusColor;?>><strong><?echo $regfeesStatus?></strong></span>) </td> </tr>

    	</table> <div style="height:3px;">  </div>

    	<span style="font-size:10px;color:#006600;">

    		<?

    		$pstr='';

    		$totalPaid=0;

    		$due=$totalRegFeesAmt;

    		if(is_array($regPay))

    		{



    			foreach($regPay as $pay)

    			{



    				$pDate=$this->showDate($pay['paymentDate']);

    				$pAmount=$pay['paidRegistrationFees'];

    				$pstr= " $pDate <b> $pAmount </b><br>";

    				echo $pstr;

    				$totalPaid=$totalPaid+$pAmount;

    			}

    			$due=	$totalRegFeesAmt-$totalPaid;



    			if(count($regPay)>1){

    				?>

    				<span title="Due Amount <? echo $due ?>" style="font-weight:bold; color:#006600; border-top:1px solid #999999;"> Total Paid <?php echo  $totalPaid ?> </span><br />

    				<?

    			}

    		}





    		if( $due>1)

    		{

    			?>

    			<span  style="font-weight:bold; color:#FF0000; border:1px dotted #FF0000; margin-top:2px;">Due <?php echo  $due ?> </span><br />

    			<?

    		}







    		?>

    	</span>















    	<?}
    	function showStudentImage($data)

    	{

//_d($data);

    		global $site;

    		$imageSrc=$site['url'].$data['image'];

    		$kanyashreeImg=$site['url']."wtos-images/kanyashreeImg.png";

    		$yuvashreeImg=$site['url']."wtos-images/yuvashreeImg.png";

    		?>

    		<img src="<?echo $imageSrc;?>" style="width:85px;  margin-right:5px;"/>



    		<div class="t_block">



    			<?if($data['kanyashree']=='Yes'){?>





    				<img src="<?echo $kanyashreeImg;?>" style="width:30px; height:30px;"/>

    				<?}if($data['yuvashree']=='Yes'){?>



    					<img src="<?echo $yuvashreeImg;?>"  style="width:30px; height:30px;" />

    					<?}if($data['apl_bpl']=='Yes'){?>

    						<h4>BPL</h4><br/>

    						<?}if($data['caste']!=''){?>

    							<h4><?echo $data['caste']?></h4>

    							<?}?>

    						</div>





    					<? }
    					function showStudentDetails($data)

    					{

    						?>



    						<? echo  $data['name'];	  ?></b><br />

    						<? echo  $data['gender'];	  ?><br />

    						<? echo  $data['father_name'];	  ?><br />

    						<? echo  $data['mother_name'];	  ?><br />

    						<? echo  $data['mobile_student'];	  ?><br />

    						<? echo  $data['age'];	  ?>



    					<?php }
    					function showStudentAddress($data)

    					{

    						?>



    						<span class="headList">Vill-</span><? echo  $data['vill'];	  ?><br />

    						<span class="headList">Bolck-</span><? echo  $data['block'];	  ?><br />

    						<span class="headList">P.O-</span><? echo  $data['po'];	  ?><br />

    						<span class="headList">P.S-</span><? echo  $data['ps'];	  ?><br />

    						<span class="headList">Dist-</span><? echo  $data['dist'];	  ?><br />

    						<span class="headList">State-</span><? echo  $data['state'];	  ?> <? echo  $data['pin'];	  ?>

    					<?php }
    					function saveSendingSms($smsText,$mobileNos , $status='send' ,$note='',$addedBy='')

    					{



    						$dataToSave['smsText']=$smsText;

    						$dataToSave['dated']=$this->now();

    						$dataToSave['mobileNos']=$mobileNos;

		//$dataToSave['applicantIds']=$applicantIds;

    						$dataToSave['status']=$status;

    						$dataToSave['note']=$note;

    						$dataToSave['addedBy']=$addedBy;

    						$qResult=$this->save('sms',$dataToSave,'smsId','');



    					}
    					function setLogRecord($tableName,$tableId,$logTitle,$addedBy,$description)

    					{



    						$dataToSave['tableName']=$tableName;

    						$dataToSave['dated']=$this->now();

    						$dataToSave['tableId']=$tableId;

    						$dataToSave['logTitle']=$logTitle;

    						$dataToSave['description']=$description;



    						$dataToSave['addedBy']=$addedBy;

    						$qResult=$this->save('logrecord',$dataToSave);



    					}
    					function getIdsByKanyashreeAndYuvashree($whereStr='')

    					{







    						$query="Select GROUP_CONCAT(DISTINCT studentId) ids from student  where studentId>0  $whereStr ";

    						$rs=$this->mq($query);

    						$rs=$this->mfa($rs);

    						$returnIds=$rs['ids'];



    						return $returnIds;

    					}
    					function monthesB2nDateRange($from,$to,$interval,$format)

    					{

	        //$from_Y date('', strtotime($from));

    						$dateRangeArray=array();

    						$begin = new DateTime( $from );

    						$end = new DateTime( $to );

    						$interval = new DateInterval($interval);

    						$end->add( $interval );

    						$daterange = new DatePeriod($begin, $interval ,$end);



    						foreach($daterange as $date)

    						{

    							$mm=$date->format($format);

    							$dateRangeArray[$mm] = $mm;

    						}

    						return $dateRangeArray;

    					}
    					function addNewFees($historyData,$historyId)

    					{

    						$totalFees=$historyData['totalFees'];

    						$monthlyFees=$historyData['monthlyFees'];



    						$TotalFeesMonth=1;

    						if($monthlyFees>0){

    							$TotalFeesMonth=$totalFees/$monthlyFees;

    						}

    						$TotalFeesMonth=ceil($TotalFeesMonth);



    						$admissionDate=$historyData['admission_date'];

    						if($admissionDate=='')

    						{



    							$admissionDate=date('Y-m-d h:s');

    						}

		 // $toDate = date('Y-m-d', strtotime("+".$TotalFeesMonth." months", strtotime($admissionDate)));

		 // $dateRange=  $this->monthesB2nDateRange($admissionDate,$toDate,'P1D','Y-m');

	     //_d($dateRange);

	   //$rentDueDateDay=date('d',strtotime($agreement['rentDueDate'])) ;

    						$admissionMonth =date( "m", strtotime( $admissionDate ) );

    						$admissionYear =date( "Y", strtotime( $admissionDate ) );

    						for($i=0;$i<$TotalFeesMonth;$i++)

    						{

	   $cM= date("Y-m", mktime(0, 0, 0, $admissionMonth+$i, 01,   $admissionYear )); //date("m")

	   $dateRange[$cM]=$cM;

	}

	   	  // _d($dateRange);











	if(count($dateRange)>0)

	{



		foreach($dateRange as $ym)

		{

			$ymA=explode('-',$ym);

			$year= $ymA[0];

			$month= $ymA[1];

			// $rentDueDate=$year.'-'.$month.'-'.$rentDueDateDay." 00:00:00";

			# Rentbills  adding

			$dataToSave=array();

			$dataToSave['historyId']=$historyId;

			$dataToSave['studentId']=$historyData['studentId'];

			$dataToSave['class']=$historyData['class'];

			$dataToSave['section']=$historyData['section'];

			$dataToSave['asession']=$historyData['asession'];

			$dataToSave['month']=$month;

			$dataToSave['year']=$year;

			$dataToSave['feesDueDate']=$year.'-'.$month.'-01 00:00:00';

			$dataToSave['fees_amount']=$monthlyFees;



			$dataToSave['payble']=$monthlyFees;

			$dataToSave['discount']=0;

			$dataToSave['paid_amount']=0;





			$dataToSave['status']='Unpaid';



			$dataToSave['addedDate']=$this->now();

			$dataToSave['addedBy']=$this->userDetails['adminId'];

			$this->save('fees',$dataToSave,'feesId',0);







		}



		/* $dataToSave2['historyId']=$historyId;

		$dataToSave2['studentId']=$historyData['studentId'];



		 $dataToSave2['registrationFees']=$registrationFees;

		  $dataToSave2['dueRegistrationFees']=$registrationFees;

		  //  $dataToSave2['dueRegistrationFees']=0;

		 	$dataToSave2['registrationFeesStatus']=$registrationFeesStatus;



		 	$this->save('payment',$dataToSave2,'paymentId',0);	*/





		 }



		}
		function getReceiptNo($tableName,$tableId,$historyId,$studentId)

		{



			$dataToSave['tableName']=$tableName;

			$dataToSave['tableId']=$tableId;

			$dataToSave['historyId']=$historyId;

			$dataToSave['studentId']=$studentId;

			$dataToSave['addedBy']=$this->userDetails['adminId'];

			$dataToSave['addedDate']=$this->now();

			$Query="select * from printreceiptno where printreceiptnoId>0 and historyId='$historyId' and studentId='$studentId' and tableId='$tableId' and tableName='$tableName'";

			$result=$this->mq($Query);

			while($data=$this->mfa($result))

			{

				$receiptNoRecord=$data;

			}

	//_d($receiptNoRecord);

			if(count($receiptNoRecord)>0)

			{

				return $receiptNoRecord['receiptNo'];

			}

			else

			{

				$qResult=$this->save('printreceiptno',$dataToSave);



	/*if($tableName=='payment')

	{

		$dataToSave['receiptNo']="R".$qResult;

	}

	else

	{

	$dataToSave['receiptNo']=$qResult;

}*/

$dataToSave['receiptNo']=$qResult;

$this->save('printreceiptno',$dataToSave,'printreceiptnoId',$qResult);

return $dataToSave['receiptNo'];

}



}
function image_photos_validation()

{



			// 170x200  // 25 kb -100 kb  // (61,440 bytes)  124586

	$img=$_FILES['photos'];

	$result=array();

	$result['ok']=true;

	$result['msg']='Allowed';







	if($img['name']==''){



		$result['ok']=false;

		$result['msg']='';

		return $result;

	}



	$size=$img['size'];

				$type_text=$img['type']; // image/jpeg

				$tmp_name=$img['tmp_name'];

				list($width, $height, $type, $attr) =getimagesize($tmp_name);







				if($width<100){$result['ok']=false; $result['msg']='Image width is not ok';}

				if($width>230){$result['ok']=false; $result['msg']='Image width is not ok';}



				if($height<130){$result['ok']=false; $result['msg']='Image height is not ok';}

				if($height>250){$result['ok']=false; $result['msg']='Image height is not ok';}



				if($size<10000){$result['ok']=false; $result['msg']='Image size is not ok';}

				if($size>70000){$result['ok']=false; $result['msg']='Image size is not ok';}



				if($type!=2){$result['ok']=false; $result['msg']='Image type is not ok ';}



				return $result;



			}
			function getExamDetailsA()

			{

				$subjectQ="select * from subject where subjectId>0 and subjectStatus='Active'";

				$subjectMq=$this->mq($subjectQ);

				while($subjectMfa=$this->mfa($subjectMq))

				{

					$subjectA[$subjectMfa['subjectId']]=$subjectMfa['subjectName'];

				}



				$examDetailsQ="select * from examdetails where examdetailsId>0 and status='Active'";

				$examDetailsMq=$this->mq($examDetailsQ);

				while($examDetailsMfa=$this->mfa($examDetailsMq))

				{

					$examDetailsA[$examDetailsMfa['examdetailsId']]=$examDetailsMfa['class'].','.$subjectA[$examDetailsMfa['subjectId']].','.$this->showDate($examDetailsMfa['startDate']);

				}

				$this->setSession($examDetailsA,'examDetailsA');

				return $examDetailsA;

			}
			function getResultA()

			{

				$studentQ="select * from  student where studentId>0";

				$studentMq=$this->mq($studentQ);

				while($studentMfa=$this->mfa($studentMq))

				{

					$studentA[$studentMfa['studentId']]=$studentMfa['name'];

				}



				$examQ="select * from  exam where examId>0 and status='Active'";

				$examMq=$this->mq($examQ);

				while($examMfa=$this->mfa($examMq))

				{

					$examA[$examMfa['examId']]=$examMfa['examTitle'];

				}



				$resultsQ="select * from results where resultsId>0 and status='Active'";

				$resultsMq=$this->mq($resultsQ);

				while($resultMfa=$this->mfa($resultsMq))

				{

					$resultA[$resultMfa['resultsId']]=$examA[$resultMfa['examId']].','.$studentA[$resultMfa['studentId']];

				}

				$this->setSession($resultA,'resultA');

				return $resultA;

			}
			function subjects_by_class($asession,$classId)
			{
				$retuen_array=array();
				$query="select * from subject where  classId='$classId' ";
				$query_rs=$this->mq($query);

				while($record=$this->mfa($query_rs))
				{
					$retuen_array[$record['subjectId']] = $record['subjectName']."[".$record['asession']."]";
				}

				return $retuen_array;

			}
			function get_teacher_by_subject($asession,$subject)
			{
				$retuen_array=array();
				$query="select * from  teacher  where specialization Like '%\"$subject\"%'   ";
				$query_rs=$this->mq($query);

				while($record=$this->mfa($query_rs))
				{

					$retuen_array[$record['teacherId']] =$record['name'];
				}

				$query="select * from  teacher  where specialization NOT Like '%\"$subject\"%'   ";
				$query_rs=$this->mq($query);

				while($record=$this->mfa($query_rs))
				{
					$retuen_array[$record['teacherId']] =$record['name'];
				}
				$retuen_array=array_filter($retuen_array);
				return $retuen_array;

			}

			function get_all_staff()
			{
				$retuen_array=array();
				$query="select * from  teacher   ";
				$query_rs=$this->mq($query);

				while($record=$this->mfa($query_rs))
				{
					$retuen_array[$record['teacherId']] =$record['name'];
				}

				return $retuen_array;
			}

			function get_teacher_acces($teacherId,$examTitle,$asession='',$classes='',$subject_id='')
			{
				$query="select * from  teacher  where teacherId='$teacherId'   ";
				$query_rs=$this->mq($query);
				$record_data=$this->mfa($query_rs);


		 // date_from_valid
		 // date_to_valid
				$examTitle_arr=array();
				$access_data_arr=array();

				$and_asession="";
				if( $asession!='') {$and_asession=" and asession='$asession' "; }

				$and_classes="";
				if( $classes!='') {$and_classes=" and class='$classes' ";



			}

			$and_classes="";
			if( $examTitle!='') {$and_classes=" and class='$classes' ";

			$examTitle_arr[$examTitle] =$examTitle;
			$query_arr['examTitle_query']=" IN ('".implode(',',$examTitle_arr)."') ";
		}

		$and_class_id="";
		if( $classes!='') {

			$class_id_arr[$classes]=$classes;
			$and_class_id=" and class_id='$classes' ";

			$query_arr['class_id_query']=" IN ('".implode(',',$class_id_arr)."') ";
		}

		$and_subject_id="";
		if( $subject_id!='') {
			$subjectId_arr[$subject_id]=$subject_id;
			$and_subject_id=" and  subjectId='$subject_id' ";
			$query_arr['subjectId_query']=" IN ('".implode(',',$subjectId_arr)."') ";


		}











		$query="select * from  resultentry_access  where teacherId='$teacherId'   $and_asession   $and_classes $and_subject_id ";
		$query_rs=$this->mq($query);
		$k=0;
		while($access_data=$this->mfa($query_rs))
		{
			$k++;


			$roll_from =$access_data['roll_from'];
			$roll_to =$access_data['roll_to'];

			$date_from_valid =$access_data['date_from_valid'];
			$date_to_valid =$access_data['date_to_valid'];

			$access_data_arr['row'][$k] =$access_data;




			$examTitle_arr[$access_data['examTitle']] =$access_data['examTitle'];

			$class_id_arr[$access_data['class_id']]=$access_data['class_id'];

			$subjectId_arr[$access_data['subjectId']]=$access_data['subjectId'];
			$section_arr[$access_data['section']]=$access_data['section'];



			$query_arr['examTitle_query']=" IN ('".implode(',',$examTitle_arr)."') ";
			$query_arr['class_id_query']=" IN ('".implode(',',$class_id_arr)."') ";
			$query_arr['subjectId_query']=" IN ('".implode(',',$subjectId_arr)."') ";
			$query_arr['section_query']=" IN ('".implode(',',$section_arr)."') ";


			if($roll_from>0){

				$query_arr['roll_from_query']=" roll_no >=   $roll_from ";
			}else
			{
				$query_arr['roll_from_query']='';
			}

			if($roll_to>0){
				$query_arr['roll_to_query']=" roll_no <=  $roll_to ";
			}else
			{
				$query_arr['roll_to_query']='';
			}



			$dateNow=$this->now();

			if($date_from_valid!='' && $date_from_valid!='0000-00-00 00:00:00'){
				$query_arr['date_from_valid_query']=" '$dateNow'  >=   '$date_from_valid' ";
			}else
			{
				$query_arr['date_from_valid_query']='';
			}

			if($date_to_valid!='' && $date_to_valid!='0000-00-00 00:00:00'){
				$query_arr['date_to_valid_query']=" '$dateNow'  <=  '$date_to_valid' ";
			}else
			{
				$query_arr['date_to_valid_query']='';
			}


			$access_data_arr['roll_from']=$roll_from;
			$access_data_arr['roll_to']=$roll_to;
			$access_data_arr['date_from_valid']=$date_from_valid;
			$access_data_arr['date_to_valid']=$date_to_valid;
			$access_data_arr['total_record']=$k;
			$access_data_arr['section_arr']=$section_arr;


		}
		$access_data_arr['examTitle_arr']=$examTitle_arr;
		$access_data_arr['class_id_arr']=$class_id_arr;
		$access_data_arr['subjectId_arr']=$subjectId_arr;

		$access_data_arr['query_arr']=$query_arr;




		$access_data_arr['and_asession'] =$and_asession;
		$access_data_arr['and_classes'] =$and_classes;
		$access_data_arr['and_subject_id'] =$and_subject_id;
		$access_data_arr['and_class_id'] =$and_class_id;

		return $access_data_arr;

	}

	function global_session_setting($asession,$class_id)
	{

		$query="select * from global_session_setting where asession='$asession' and class_id='$class_id' limit 1 ";
		$query_rs=$this->mq($query);
		$record=$this->mfa($query_rs);
		return $record;

	}

	function month_academic($asession,$class,$admission_date)
	{
		$global_config=	$this->global_session_setting($asession,$class);
		$session_start_date=$global_config['session_start_date'];
		$startMonth=0;
		if($session_start_date=='' || $session_start_date=='0000-00-00 00:00:00')
		{
			$session_start_date=$admission_date;
				$startMonth=1;// session start will be just next month after admission month
			}



			$month_academic=array();

			for($i=0;$i<=11;$i++)
			{
				$dateObj = new DateTime($session_start_date);
				$strinterval='P'.$startMonth.'M';
				$dateObj->add(new DateInterval($strinterval));
				$session_month_year= $dateObj->format('Ym');
				$month_academic[$session_month_year]['month_int']=$dateObj->format('m');
				$month_academic[$session_month_year]['month_str']=$dateObj->format('F');
				$month_academic[$session_month_year]['year']=$dateObj->format('Y');
				$startMonth++;

			}
			return $month_academic;

		}

		function get_fees_unpaid($studentId,$accademicsessionId,$historyId,$fees_student_id_array=array())
		{
			$result_data=array();

			$fees_months_arr=array();
			$paybleAmount=0;

			if( is_array($fees_student_id_array))
			{
				if(count($fees_student_id_array)>0)
				{
					$in_fees_student_id=implode(',',$fees_student_id_array);


					$query="select * from fees_student where paymentStatus ='unpaid' and  studentId='$studentId' and accademicsessionId='$accademicsessionId'  and historyId='$historyId'  and   fees_student_id IN($in_fees_student_id) ";
					$query_rs=$this->mq($query);
					while($data=$this->mfa($query_rs))
					{
						$key=$data['fees_student_id'];

						$result_data['row'][$key]=$data;
						$paybleAmount=$paybleAmount+$data['totalPayble'];

						$monthYear=$data['month'].'-'.$data['year'];
						$fees_months_arr[$monthYear]=$monthYear;

					}

					$result_data['fees_student_id_str']=$in_fees_student_id;
					$result_data['paybleAmount']=$paybleAmount;
					$result_data['fees_months']=implode(',',$fees_months_arr);

				}

			}

			return $result_data;

		}

		function get_fees_alll($historyId)
		{

			$query="select * from fees_student where   historyId='$historyId'  ";
			$query_rs=$this->mq($query);

			return $query_rs;

		}

		function get_fees_payment_record($historyId)
		{

			$query="select * from fees_payment where   historyId='$historyId'  ";
			$query_rs=$this->mq($query);

			return $query_rs;

		}

		function generateNewReceiptNo()
		{
			return rand(999,9999);
		}

		function central_login($login_username,$login_password,$user_type='')
		{


			global $site;
			$login_success=false;
			$redirect='';
			$return_array=array();

			$login_username=str_replace(array("'",'"',';','-'),'',$login_username);

			$query="select * from student where mobile_student='$login_username' and otpPass='$login_password'  ";
			$datars=$this->mq($query);
			$data=$this->mfa($datars);
			$studentId=$this->val($data,'studentId');
			if($studentId>0)
			{
				$login_success=true;
				$loginKey=$site['loginKey'];
				$_SESSION[$loginKey]['logedUser']=$data;
				$_SESSION[$loginKey]['logedType']='STUDENT';
				$redirect=$site['url'].'myprofile';

			}

			if($login_success==false)
			{
				$query="select * from admin where username='$login_username' and password='$login_password' and active='Active'  ";
				$datars=$this->mq($query);
				$data=$this->mfa($datars);
				$adminId=$this->val($data,'adminId');
				if($adminId>0)
				{
					$login_success=true;
					$loginKeywtos=$site['loginKey-wtos'];
					$_SESSION[$loginKeywtos]['logedUser']=$data;
					$_SESSION[$loginKeywtos]['logedType']='ADMIN';
					$redirect=$site['url-wtos'].'staff_profile.php';

					 // $data['adminType']=='Operator'
					 // $redirect=$site['url-wtos'];

				}


			}

			$return_array['data']=$data;
			$return_array['redirect']=$redirect;
			return $return_array;

		}

		function school_setting()
		{


			$schoolQ="select * from school_setting limit 1";
			$school_setting_rs =$this->mq($schoolQ);
			$school_setting =$this->mfa($school_setting_rs);
			return  $school_setting;

		}

		function getSubjectList($asession='',$classId='')
		{
			$and_asession='';
			if($asession!=''){
				$and_asession=" and  asession='$asession' ";

			}


			$and_classId='';
			if($classId!='')
			{
				$and_classId=" and  classId='$classId' ";

			}

			$dataQuery=" select * from subject where subjectId>0 $and_asession  $and_classId  ";
			$rsResults=$this->mq($dataQuery);

			$subjectArr=array();
			while($record=$this->mfa( $rsResults))
			{
				$subjectArr[$record['subjectId']]=$record['subjectName'];
			}
			return $subjectArr;
		}

		function total_fees($accademicsessionId)
		{
			$query="select sum(totalPayble) total_amount,month from fees_student  where 
			accademicsessionId='$accademicsessionId'  group by  accademicsessionId,month  ";
			$rsResults=$this->mq($query);

			$data_total=array();
			while($record=$this->mfa( $rsResults)){
				$data_total[$record['month']]=$record['total_amount'];
			}

			return $data_total;

		}

		function total_fees_paid($accademicsessionId)
		{
			$query="select sum(totalPayble) total_amount,month from fees_student  where 
			accademicsessionId='$accademicsessionId'  and paymentStatus='paid' group by  accademicsessionId,month  ";
			$rsResults=$this->mq($query);

			$data_total=array();
			while($record=$this->mfa( $rsResults)){
				$data_total[$record['month']]=$record['total_amount'];
			}

			return $data_total;

		}

		function total_discount($accademicsessionId)
		{
			$query="select sum(discountAmount) total_amount,month from fees_student  where 
			accademicsessionId='$accademicsessionId'   group by  accademicsessionId,month  ";
			$rsResults=$this->mq($query);

			$data_total=array();
			while($record=$this->mfa( $rsResults)){
				$data_total[$record['month']]=$record['total_amount'];
			}

			return $data_total;

		}

		function student_avarage_percentage($asession)
		{
			$query="select AVG(percentage) avg_rs,studentId ,class from resultsdetails  where 
			asession='$asession'   group by  class,studentId  ";
			$rsResults=$this->mq($query);

			$data_total=array();
			while($record=$this->mfa( $rsResults))
			{


				$avg_rs=$record['avg_rs'];
				$class_id=$record['class'];

				if($avg_rs<60) {  $key='0_59'; }
				if($avg_rs>=60 &&  $avg_rs<70) {  $key='60_69'; }
				if($avg_rs>=70 &&  $avg_rs<80) {  $key='70_79'; }
				if($avg_rs>=80 &&  $avg_rs<90) {  $key='80_89'; }
				if($avg_rs>=90 &&  $avg_rs<=100) {  $key='90_100'; }

				if(isset($data_total[$class_id][$key]))
				{
					$data_total[$class_id][$key]=$data_total[$class_id][$key]+1;
				}else
				{

					$data_total[$class_id][$key]=1;
				}


			}

			return $data_total;

		}

		function showAmount($amount)
		{

			$amount=round($amount);

			return $amount;
		}

		function score_fees_collect($accademicsessionId)
		{

			$month=date('m');

			$year=date('Y');
			$and_month="";
			if($accademicsessionId>=$year)
			{
				$and_month=" and  month <= '$month'";
			}

			$query="select sum(totalPayble) total_amount_collected from fees_student  where 
			accademicsessionId='$accademicsessionId'  and paymentStatus='paid'  $and_month ";
			$rsResults=$this->mq($query);
			$row=$this->mfa( $rsResults);
			$total_amount_collected=$row['total_amount_collected'];


			$query="select sum(totalPayble) total_amount_uptomonth from fees_student   where 
			accademicsessionId='$accademicsessionId'    $and_month ";
			$rsResults=$this->mq($query);
			$row=$this->mfa( $rsResults);
			$total_amount_uptomonth=$row['total_amount_uptomonth'];

			$percent=0;
			if($total_amount_uptomonth>0){
				$percent=($total_amount_collected/$total_amount_uptomonth)*100;
				$percent=ceil($percent);
			}

			// echo " $percent=($total_amount_collected/$total_amount_uptomonth)*100; ";



			return $percent;

		}
   /*********
    * Site Information
    * @param string $key
    * @return array|false|mixed
    */

   //Render grade card by exam
   function render_grade_card($exam, $ed_query, $rd_query,$grade_setting, $subjects){

   	$elective = str_replace(" ","",$exam['elective_subject_ids']);
   	$elective = explode(",",$elective);
   	$subjects_ex = $this->get_subjects_with_elective($subjects, $elective);

	    //
   	$absent_text = '<span style="color:red">AB</span>';
   	$incomplete_text = '<span style="color:red">I</span>';;
        //resultsdetails
   	$resultsdetails = [];

   	while ($rd_row = $this->mfa($rd_query)){

   		$resultsdetails[$rd_row['examdetailsId']] = $rd_row;
   		$resultsdetails[$rd_row['examdetailsId']]['viva_fields_marks'] = unserialize($rd_row['viva_fields_marks']);

   	}
        //examdetails
   	$examdetails = [];
   	while($ed_row = $this->mfa($ed_query)){
   		if(isset($subjects_ex[$ed_row['subjectId']])){
   			$examdetails[$ed_row['examdetailsId']] = $ed_row;
   			$examdetails[$ed_row['examdetailsId']]['viva_fields'] = unserialize($ed_row['viva_fields']);

                //
   			$count = 0;
   			if(is_array($examdetails[$ed_row['examdetailsId']]['viva_fields'])){
   				foreach ($examdetails[$ed_row['examdetailsId']]['viva_fields'] as $key_f => $ed_v_f){
   					$examdetails[$ed_row['examdetailsId']]['viva_fields'][$key_f]['obtain'] =
   					$resultsdetails[$ed_row['examdetailsId']]['viva_fields_marks'][$key_f]['marks'];
   					if(isset($ed_v_f['sub_head'])){

   						foreach ($ed_v_f['sub_head'] as $f2_key=>$ed_v_f_s_h){
   							$examdetails[$ed_row['examdetailsId']]['viva_fields'][$key_f]['sub_head'][$f2_key]['obtain'] =
   							$resultsdetails[$ed_row['examdetailsId']]['viva_fields_marks'][$key_f]['sub_head'][$f2_key]['marks'];

   							$count++;
   						}
   					} else{
   						$count++;
   					}
   				}
   			}
                //marks
   			$examdetails[$ed_row['examdetailsId']]['count'] = $count;
   		}
   	}
   	ob_start();
   	?>
   	<table class="main-table" style="margin-top: 10px">

   		<tr>
   			<th colspan="4" style="font-size: 18px">SUBJECT AREA</th>
   			<th class="text-center" style="width: 40px">Full marks</th>
   			<th class="text-center" style="width: 40px">Marks Obtained</th>
   			<th class="text-center" style="width: 40px">Total</th>
   			<th class="text-center" style="width: 40px">Subject Total</th>
   			<th class="text-center" style="width: 40px">Grade</th>
   		</tr>

   		<?
   		$c = 0;
   		$grand_total_max_marks = 0;
   		$grand_total_obtain = 0;
   		$grand_total_percentage  = 0;
   		$grand_total_grade = "";
   		$exam_incomplete = false;
   		foreach ($examdetails as $examdetail){

   			$attended = isset($resultsdetails[$examdetail['examdetailsId']]);
   			$incomplete = false;
   			$subject_fm = ($examdetail['written']+$examdetail['viva']+$examdetail['practical']);

   			$practical_obtain = 0;
   			if($attended){

   				if($resultsdetails[$examdetail['examdetailsId']]['writtenMarks']!==''){
   					$written_obtain = $resultsdetails[$examdetail['examdetailsId']]['writtenMarks'];

   				} else{
   					$incomplete = true;
   					$written_obtain = $incomplete_text;
   				}
   				if($resultsdetails[$examdetail['examdetailsId']]['viva']!==''){
   					$viva_obtain = $resultsdetails[$examdetail['examdetailsId']]['viva'];
   				} else {
   					$incomplete = true;
   					$viva_obtain = $incomplete_text;
   				}

   			} else {
   				$written_obtain = $absent_text;
   				$viva_obtain = $absent_text;
   				$practical_obtain = $absent_text;

   				$incomplete = true;
   			}
   			if(!$incomplete){
   				$subject_ms = (float)$written_obtain+(float)$viva_obtain+(float)$practical_obtain;
   				$subject_percentage = ($subject_ms/$subject_fm)*100;
   				$subject_grade = $this->calculate_grade($subject_percentage, $grade_setting);
   			} else {
   				$exam_incomplete = true;
   				$subject_ms = $incomplete_text;
   				$subject_percentage = $incomplete_text;
   				$subject_grade = $incomplete_text;
   			}


   			if (!$exam_incomplete){
   				$grand_total_max_marks += $subject_fm;
   				$grand_total_obtain += (float)$subject_ms;
   				$grand_total_percentage = (float)number_format((float)($grand_total_obtain/$grand_total_max_marks)*100,
   					2,'.','');
   				$grand_total_grade = $this->calculate_grade($grand_total_percentage, $grade_setting);
   			} else {
   				$grand_total_max_marks = $incomplete_text;
   				$grand_total_obtain = $incomplete_text;
   				$grand_total_percentage = $incomplete_text;
   				$grand_total_grade = $incomplete_text;
   			}

                //has viva fields and written marks
   			if(is_array($examdetail['viva_fields']) && $examdetail['written']>0){
   				?>
   				<!----Internal--->
   				<?
   				$f_c = 0;
   				foreach($examdetail['viva_fields'] as $f_key=>$field){
   					$f_c++;
   					$item = $field;
   					?>
   					<tr>

   						<? if($f_c==1){?>
   							<td rowspan="<?=$examdetail['written']>0?$examdetail['count']+1:$examdetail['count']?>" style="width: 20px;
   							white-space: nowrap"
   							nowrap="nowrap" >
   							<p style="writing-mode: vertical-lr; text-orientation: sideways; margin: 0; transform: rotateZ(180deg)">
   								<b><?=$examdetail['subjectName']?></b>
   							</p>
   						</td>

   						<?if($examdetail['written']>0){?>
   							<td rowspan="<?=$examdetail['count']?>" style="width: 20px; white-space: nowrap"
   								nowrap="nowrap" >
   								<p style="writing-mode: vertical-lr; margin: 0; text-orientation: sideways; transform:
   								rotateZ
   								(180deg)">
   								Internal Ass.
   							</p>
   						</td>
   					<? }?>
   				<? }?>

   				<!----split 1--->
   				<td rowspan="<?= sizeof($field['sub_head'])>0?sizeof($field['sub_head']):1?>"
   					colspan="<?= !isset($field['sub_head'])?2:1?>"><?=$item['title']?></td>
   					<!----split2-->

   					<? if(isset($field['sub_head'])){
   						$item = array_shift($field['sub_head']);
   						?>
   						<td><?= $item['title'];?></td>
   						<?
   					}?>

   					<!---fm-->
   					<td class="text-center"><?= $item['marks'] ?></td>
   					<!---obtain-->
   					<td class="text-center">
   						<?=$item['obtain']?>
   					</td>

   					<? if($f_c==1){?>
   						<td class="text-center" rowspan="<?=$examdetail['count']?>" >
   							<?=$viva_obtain?>
   						</td>

   						<!--SUBJECT TOTAL-->
   						<td class="text-center" rowspan="<?=$examdetail['count']+1?>">
   							<?=
   							$subject_ms;
   							?>
   						</td>
   						<td class="text-center" rowspan="<?=$examdetail['count']+1?>" >
   							<?=$subject_grade?>
   						</td>
   					<? }?>

   				</tr>
   				<?

   				foreach($field['sub_head'] as $sub_field){
   					?>
   					<tr>

   						<!----split2-->
   						<td><?=$sub_field['title']?></td>
   						<!---fm-->
   						<td class="text-center"><?=$sub_field['marks']?></td>
   						<!---obtain-->
   						<td class="text-center"><?=$sub_field['obtain']?></td>
   					</tr>
   					<?
   				}

   				?>
   				<?} ?>
   				<!--Written-->
   				<tr>
   					<th colspan="3" style="text-align: left">Written</th>
   					<td class="text-center" colspan="1"><?=$examdetail['written']?></td>
   					<td class="text-center" colspan="1"><?=$resultsdetails[$examdetail['examdetailsId']]['writtenMarks'] ?></td>
   					<td class="text-center" colspan="1"><?=$resultsdetails[$examdetail['examdetailsId']]['writtenMarks'] ?></td>
   				</tr>
   				<?
   			}
                //has viva fields and no written marks
   			if(is_array($examdetail['viva_fields']) && $examdetail['written']<=0){

   				$f_c = 0;
   				foreach($examdetail['viva_fields'] as $f_key=>$field){
   					$f_c++;
   					$item = $field;
   					?>
   					<tr>

   						<? if($f_c==1){?>
   							<td rowspan="<?=sizeof($examdetail['viva_fields'])>0?sizeof($examdetail['viva_fields']):1?>"
   								style="width:
   								20px;
   								white-space: nowrap"
   								nowrap="nowrap" colspan="3">
   								<b><?=$examdetail['subjectName']?></b>
   							</td>
   						<? }?>

   						<!----split 1--->
   						<td rowspan=""
   						colspan="1"><?=$item['title']?></td>
   						<!----split2-->
   						<!---fm-->
   						<td class="text-center"><?= $item['marks'] ?></td>
   						<!---obtain-->
   						<td class="text-center">
   							<?=$item['obtain']?>
   						</td>

   						<? if($f_c==1){?>
   							<td class="text-center" rowspan="3">
   								<?=$resultsdetails[$examdetail['examdetailsId']]['viva']?>
   							</td>
   							<td class="text-center" rowspan="3">
   								<?=$resultsdetails[$examdetail['examdetailsId']]['viva']+$resultsdetails[$examdetail['examdetailsId']]['practical']?>
   							</td>
   							<td class="text-center" rowspan="3">
   								<?=$subject_grade?>
   							</td>
   						<? }?>
   					</tr>

   					<?} ?>
   					<?
   				}
                //has no viva fields and hs viva value
   				if(!is_array($examdetail['viva_fields'])&& $examdetail['viva']>0){
   					?>
   					<tr>
   						<td colspan="3" rowspan="<?= $examdetail['written']>0?2:1; ?>" style="padding-left: 10px">
   							<b><?=$examdetail['subjectName']?></b>
   						</td>
   						<td>Internal Assessment</td>
   						<td class="text-center"><?=$examdetail['viva']?></td>
   						<td class="text-center"><?=$viva_obtain?></td>
   						<td class="text-center" rowspan="<?= $examdetail['written']>0?2:1; ?>"><?=$subject_ms?></td>
   						<td class="text-center" rowspan="<?= $examdetail['written']>0?2:1; ?>"><?=$subject_ms?></td>
   						<td class="text-center" rowspan="<?= $examdetail['written']>0?2:1; ?>"><?=$subject_grade?> </td>
   					</tr>
   					<tr>
   						<td>Written</td>
   						<td class="text-center"><?=$examdetail['written']?></td>
   						<td class="text-center"><?=$written_obtain?></td>
   					</tr>
   					<?
   				}
                //has only written values
   				if(!is_array($examdetail['viva_fields'])&& $examdetail['viva']<=0){
   					?>
   					<tr>
   						<td colspan="4" style="padding-left: 10px;">
   							<b><?=$examdetail['subjectName']?></b>
   						</td>

   						<td class="text-center"><?=$examdetail['written']?></td>
   						<td class="text-center"><?=$written_obtain?></td>
   						<td class="text-center"><?=$subject_ms?></td>
   						<td class="text-center"><?=$subject_ms?></td>
   						<td class="text-center"><?=$subject_grade?> </td>
   					</tr>
   					<?
   				}

   			}
   			?>

   			<tr>
   				<th colspan="4" rowspan="2" style="font-size: 18px">GRAND TOTAL</th>
   				<th class="text-center" style="width: 40px">Full Marks</th>
   				<th class="text-center" style="width: 40px">Marks Obtained</th>
   				<th class="text-center" colspan="2" style="width: 40px">Percentage</th>
   				<th class="text-center" style="width: 40px">Overall Grade</th>
   			</tr>
   			<tr>
   				<td class="text-center" style="width: 40px"><?=$grand_total_max_marks;?></td>
   				<td class="text-center" style="width: 40px"><?=$grand_total_obtain;?></td>
   				<td class="text-center" colspan="2" style="width: 40px"><?=$grand_total_percentage;?></td>
   				<td class="text-center" style="width: 40px"><?=$grand_total_grade?></td>
   			</tr>
   		</table>
   		<style>

   			table{
   				border-collapse: collapse;
   				width: 100%;
   				font-size: 13px;
   			}
   			.main-table > thead > tr > td{
   				border: 1px solid #000;
   				text-align: center;
   				font-size: 12px;

   			}
   			.main-table tr > th{
   				border: 1px solid #000;
   				text-align: center;
   				font-size: 12px;

   			}
   			.main-table > tbody > tr > td{
   				border: 1px solid #000;
   				padding: 4px 2px;
   			}
   			.text-center{
   				text-align: center;
   			}

   		</style>
   		<?
   		$res = ob_get_contents();
   		ob_end_clean();
   		return $res;
   	}
   /*****
    * grade calculation
    */
   function get_board_by_class($class){
   	foreach ($this->board_class as $board=> $classes){
   		if(in_array($class, $classes)){
   			return $board;
   		}
   	}
   	return "--";
   }
   function get_grade_settings_by_class($class, $asession=2020){
   	$board = $this->get_board_by_class($class);
   	$sql = "SELECT * FROM grade_setting 
   	WHERE grade_setting.asession='$asession' AND
   	grade_setting.board = '$board' ORDER BY from_percent ASC";
   	$q = $this->mq($sql);
   	$g = [];
   	while($r = $this->mfa($q)){
   		$g[] = array(
   			"min"=>$r['from_percent'],
   			"max"=>$r['to_percent'],
   			"grade" => $r['grade'],
   			"ob" => $r
   		);
   	}
   	return $g;
   }
   function get_grade_settings_by_board($board, $asession=2020){
   	$sql = "SELECT * FROM grade_setting 
   	WHERE grade_setting.asession='$asession' AND
   	grade_setting.board = $board ORDER BY from_percent ASC";

   	$q = $this->mq($sql);
   	$g = [];
   	while($r = $this->mfa($q)){
   		$g[] = array(
   			"min"=>$r['from_percent'],
   			"max"=>$r['to_percent'],
   			"grade" => $r['grade'],
   			"ob" => $r
   		);
   	}
   	return $g;
   }
   function calculate_grade($percentage, $grade_settings){
   	$percentage = (int) $percentage;
   	foreach ($grade_settings as $grade){
   		if($grade['max']>=$percentage && $grade['min']<=$percentage){
   			return $grade['grade'];
   		}
   	}
   	return "--";
   }

   /*****
    * Elective Subject
    */

   function get_subjects_by_class($class, $asession=2020){
   	$sql = "SELECT s.subjectId, s.subjectName, s.Elective as elective FROM subject s WHERE s.classId='$class'";
   	$query = $this->mq($sql);
   	$subjects = [];
   	while($subject = $this->mfa($query)){
   		$subjects[$subject['subjectId']] = $subject;
   	}
   	return $subjects;
   }
   function get_subjects_with_elective($subjects=[], $elective=[]){
   	$elective = !is_array($elective)?explode('',$elective):$elective;

   	if(!is_array($subjects)){
   		return false;
   	}
   	if(sizeof($subjects)<=0){
   		return false;
   	}

   	$res = [];
   	foreach ($subjects as $subject){
   		if($subject['elective']==1){
   			if(in_array($subject['subjectId'], $elective)){
   				$res[$subject['subjectId']] =  $subject['subjectId'];
   			}
   		} else {
   			$res[$subject['subjectId']] =  $subject['subjectId'];
   		}
   	}

   	return $res;
   }


   function get_logo_by_unit_group($group){
   	return $this->unit_group_logos[$group];
   }
   function get_watermark_by_unit_group($group){
   	return $this->unit_group_watermarks[$group];
   }

     /*
      * Access Settings
      */
     function get_branches_by_access_name($name, $access=[]){
     	$branches = [];
     	$q  = $this->mq("SELECT branch_code, branch_name FROM branch");
     	while($b = $this->mfa($q)){
     		$branches[$b["branch_code"]] = $b["branch_name"];
     	}
     	if($this->loggedUser()['adminType']!="Super Admin"){
     		$accesses = (array)@json_decode($this->userDetails['access']);

     		foreach ($branches as $branch_code=>$branch_name){
     			if(!in_array($name, $accesses[$branch_code])){
     				unset($branches[$branch_code]);
     			}
     		}
     	}
     	return $branches;
     }
     function get_classes_by_access_name($access_key,$branch_code){
     	$adminId = $this->loggedUser()["adminId"];
     	$adminType = $this->loggedUser()["adminType"];



     	$board_classes = [];
     	$q = $this->mq("SELECT * FROM admin_access_class WHERe adminId = '$adminId' AND branch_code='$branch_code' AND access_key='$access_key'");
     	while($class_access = $this->mfa($q)){
     		$board_classes[$this->get_board_by_class($class_access["class"])][$class_access["class"]] = $this->classList[$class_access['class']];
     	}
     	if($adminType!="Super Admin"){
     		$board_classes = [];
     		foreach ($this->classList as $class=>$className){
     			$board_classes[$this->get_board_by_class($class)][$class] = $this->classList[$class];
     		}
     	}
     	return $board_classes;
     }
     function get_secondary_access_by_branch_and_menu($branch_code, $access_name){
     	$adminId = $this->loggedUser()["adminId"];
     	$adminType = $this->loggedUser()["adminType"];
     	$second_level_access = $this->userDetails["second_level_access"];
     	$second_level_access = @json_decode($second_level_access)?@json_decode($second_level_access):new stdClass();
     	$second_level_access = @$second_level_access->$branch_code->$access_name?$second_level_access->$branch_code->$access_name:[];
     	return $second_level_access;
     }
     function get_global_access_by_name($access_name){
     	$adminId = $this->loggedUser()["adminId"];
     	$adminType = $this->loggedUser()["adminType"];
     	$global_accesses = $this->userDetails["global_accesses"];
     	$global_accesses = @json_decode($global_accesses)?@json_decode($global_accesses):new stdClass();
     	$global_accesses = @$global_accesses->$access_name?$global_accesses->$access_name:[];
     	return $global_accesses;
     }

      /****
    * Excel function
     */
      function get_leter_by_number($n):string{
      	$n=$n-1;
      	for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
      		$r = chr($n%26 + 0x41) . $r;
      	return $r;

      }
      function get_cell_name($x=1,$y=1):string{
      	return $this->get_leter_by_number($x).$y;
      }


      function get_image($mml){
      	$mml = urlencode($mml);
        //The url you wish to send the POST request to
      	$url = "https://www.al-ameen.in/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?mml=$mml&metrics=true&centerbaseline=false";
      	$res = @json_decode(file_get_contents($url))->result->content;


      	return $res;
      }
      public function render_all_mml($text){
      	$pattern = "/\<math(.*)\<\/math\>/";
      	preg_match_all($pattern, $text, $matches);
      	if(isset($matches[0])){
      		foreach ($matches[0] as $match){
      			$text = str_replace($match, $this->get_image($match), $text);
      		}
      	}

      	return $text;
      }


      public function get_branches():array{
      	$query = $this->mq("SELECT * FROM branch");
      	$branches = [];
      	while($branch = $this->mfa($query)){
      		$branches[$branch["branch_code"]] = $branch;
      	}

      	return $branches;
      }

      function validate_image_url($file):string{

      	return $file;




      }


      function get_admins($branch_code="", $type=""){
      	$and_branch_code = ($branch_code==""?"":"AND branch_code='$branch_code'");
      	$and_type = ($type==""?"":"AND adminType='$type'");

      	$query = $this->mq("SELECT * FROM admin WHERE 1=1 $and_branch_code $and_type");
        //print $this->query;
      	$admins = [];
      	while ($admin = $this->mfa($query)){
      		$admins[$admin["adminId"]] = $admin;
      	}

      	return $admins;
      }

    /////
      function render_answer_sheet($eg_id, $sId, $provisional=false){
      	global $site;
      	$html ="";



      	$egh = $this->mfa($this->mq("SELECT egh.* FROM exam_group_history egh 
      		WHERE egh.exam_group_id='$eg_id' 
      		AND historyId IN(SELECT h.historyId FROM history h WHERE h.studentId='$sId')"));

      	$answers = (object)@json_decode(@file_get_contents(ANSWERS_PATH."/".$sId.".json"));




      	if (!$egh){
      		$html = "Absent";
           //print $html;
           //return  $html;
      	}

      	$eds= [];
      	$ed_query = $this->mq("SELECT ed.*, sub.subjectName FROM examdetails ed 
      		INNER JOIN subject sub ON sub.subjectId=ed.subjectId
      		WHERE ed.exam_group_id='$eg_id'");
      	while ($ed = $this->mfa($ed_query)){
      		$eds[$ed["examdetailsId"]] = $ed;
      	}
      	$ed_ids = "'".implode("','", array_keys($eds))."'";



      	$sql = "SELECT  
      	q.questionId,
      	q.questionText,
      	q.answerText1,
      	q.answerText2,
      	q.answerText3,
      	q.answerText4,
      	q.questionImage,
      	q.answerImage1,
      	q.answerImage2,
      	q.answerImage3,
      	q.answerImage4,
      	q.answer_hints,
      	q.answer_hints_image,
      	q.marks,
      	q.negetive_marks,
      	q.correctAnswer,
      	q.correctAnswer_2,
      	q.correctAnswer_3,
      	q.correctAnswer_4,
      	q.wrong_question,
      	q.viewOrder,
      	q.examdetailsId


      	FROM question q
      	WHERE q.examdetailsId IN ($ed_ids)
      	ORDER BY q.examdetailsId,q.viewOrder ASC";
      	$query = $this->mq($sql);

      	$attempted = array(
      		'total'=>0,
      		'negative'=>0,
      		'positive'=>0,
      	);
      	$marks = array(
      		'obtain'=>0,
      		'negative'=>0,
      		'positive'=>0,
      	);
      	$exam_questions = [];
      	while($question = $this->mfa($query)){
      		$qId = $question["questionId"];

      		$question["ans_state"] = "unattempted";
      		$question["state"] = 0;
      		$question["answerSelected"] = '';
      		if(isset($answers->$qId)){
      			$answer = $answers->$qId;
      			$attempted['total']+=1;
      			$question["ans_state"] = "attempted";
      			$question["answerSelected"] = $answer;
      			if($question['correctAnswer']==$answer
      				||$question['correctAnswer_2']==$answer
      				||$question['correctAnswer_3']==$answer
      				||$question['correctAnswer_4']==$answer
      				||$question['wrong_question']==1
      			){
      				$attempted['positive']+=1;
      			$marks['positive']+=$question['marks'];
      			$marks['obtain']+=$question['marks'];
      			$question["state"] = 1;
      		} else {
      			$attempted['negative']+=1;
      			$marks['negative']+=$question['negetive_marks'];
      			$marks['obtain']-=$question['negetive_marks'];
      			$question["state"] = 0;
      		}
      	}

      	$exam_questions[$question['examdetailsId']][$question['questionId']] = $question;
      }

      /*  arrange by set if exist  */
      $exam_questions_set=$exam_questions;
      $question_set=$egh['question_set'];
      if($question_set)
      {
      	$exam_questions_set=array();
      	$query_q_set="select * from question_paper_set where examdetailsId IN ($ed_ids) and    set_no='$question_set' order by view_order asc   ";
      	$query_q_set_rs=$this->mq($query_q_set);
      	while($q_set=$this->mfa( $query_q_set_rs))
      	{


      		$exam_questions_set[$q_set['examdetailsId']][$q_set['question_id']]=$exam_questions[$q_set['examdetailsId']][$q_set['question_id']];
      		$exam_questions_set[$q_set['examdetailsId']][$q_set['question_id']]['viewOrder']=$q_set['view_order'];

      	}
      }



      ?>
      <button class="uk-modal-close-default" type="button" uk-close></button>

      <div class="uk-container-small uk-margin-auto uk-margin-large-top">
      	<?if(!$provisional){?>
      		<div class="uk-grid uk-child-width-1-2@s uk-grid-small text-m" uk-grid>
      			<div>
      				<table class="uk-table uk-table-small uk-table-divider">
      					<thead>
      						<tr>
      							<th colspan="2"><span class="uk-text-bold" style="color: #000">Attempt</span></th>
      						</tr>
      					</thead>
      					<tbody>
      						<tr>
      							<td>Positive</td>
      							<td class="uk-text-bold uk-text-success"><?=$attempted['positive']?></td>
      						</tr>
      						<tr>
      							<td>Negative</td>
      							<td class="uk-text-bold uk-text-danger"><?=$attempted['negative']?></td>
      						</tr>
      						<tr>
      							<td>Total</td>
      							<td class="uk-table-shrink"><?=$attempted['total']?></td>
      						</tr>
      					</tbody>
      				</table>
      			</div>
      			<div>
      				<table class="uk-table uk-table-small uk-table-divider">
      					<thead>
      						<tr>
      							<th colspan="2"><span class="uk-text-bold" style="color: #000">Marks</span></th>
      						</tr>
      					</thead>
      					<tbody>
      						<tr>
      							<td>Positive</td>
      							<td class="uk-text-bold uk-text-success">+<?=$marks['positive']?></td>
      						</tr>
      						<tr>
      							<td>Negative</td>
      							<td class="uk-table-shrink uk-text-bold uk-text-danger">-<?=$marks['negative']?></td>
      						</tr>
      						<tr>
      							<td>Obtain</td>
      							<td class="uk-text-bold"><?=$marks['obtain']?></td>
      						</tr>
      					</tbody>
      				</table>
      			</div>
      		</div>
      		<?}?>
      		<h3 class="uk-text-bold text-xl" style="color: #000"><?=$provisional?"Provisional":""?> Answer Sheet</h3>
      		<?
      		foreach ($exam_questions_set as $edId=>$questions){?>
      			<h4 class="primary-text uk-text-bolder"><?= $eds[$edId]["subjectName"]?></h4>
      			<table class="uk-width-1-1 uk-margin" style="border-collapse: collapse">
      				<?foreach ($questions as $question){?>
      					<tr style="<?=$question["wrong_question"]==1?"background-color:#ff000040; color:#000;":"color: #000;"?> border: 1px solid #e5e5e5">
      						<td valign="top"
      						class="p-l p-left-m uk-table-shrink uk-text-bold text-m"
      						style="color: #0A246A"><?=$question["viewOrder"]?>.</td>
      						<td valign="top" class="p-l p-left-m p-right-none uk-text-bold text-m" style=" ">
      							<?=$question['questionText']?>
      							<table class="m-top-l m-bottom-m text-s"
      							style="color: #333; font-weight: normal;  border-collapse: collapse; " >
      							<?
      							$wrong = $question["wrong_question"]==1;
      							for($xxx=1;$xxx<=4;$xxx++){
      								$correct_color = ($question['correctAnswer']==$xxx||$question['correctAnswer_2']==$xxx||$question['correctAnswer_3']==$xxx||$question['correctAnswer_3']==$xxx) && !$wrong?'background-color:blue; color:white;':'';
      								$answer_color = $question['state']==1 && $question['answerSelected']==$xxx && !$wrong?'background-color:green;color:white;':'';
      								$answer_color = $question['state']==0 &&
      								$question['answerSelected']==$xxx?'background-color:red;color:white;':$answer_color;


      								?>
      								<tr style="<?=$correct_color?> <?=$answer_color?>; border-radius: 3px">
      									<td class="p-right-m"><?=$xxx?>.</td>
      									<td >
      										<?=$question['answerText'.$xxx]?>
      										<? if($question['answerImage'.$xxx]){?>
      											<img src="<?=$site['url'].$question['answerImage'.$xxx]?>">
      										<? } ?>
      									</td>
      								</tr>
      								<?}?>

      							</table>
      							<?if($question["answer_hints"]!=""){?>
      								<div style="background-color: #f1f1f1;" class="border-radius-m">
      									<span class="uk-label uk-label-warning  text-s">ANSWER HINTS</span>
      									<div class="p-s">
      										<?=$question["answer_hints"]?>
      									</div>
      								</div>
      								<?}?>
      							</td>
      							<td valign="top"
      							class="p-l p-left-none p-right-m uk-table-shrink text-s">
      							<?if($question['ans_state']=='attempted'):?>
      							<div class="text-xs p-xxs p-left-xs p-right-xs border-radius-l uk-text-bold"
      							style="background-color: <?=$question['state']==1?'green':'red'?>; color: #fff">
      							<?=$question['state']==1?'+'.number_format((float)$question['marks'], 2, '.', ''):'-'.round($question['negetive_marks'], 2)?>
      						</div>
      					<? endif;?>
      				</td>
      			</tr>
      			<?}?>
      		</table>
      		<?}?>

      	</div>
      	<?

      	return $html;
      }
      function get_sigentory_authority($key = "grade_card",  $branch_code,  $class, $gender){
      	global $site;
      	$query = $this->mq("SELECT bsa.class, bsa.gender, a.signature, a.name, a.adminType FROM branch_signatory_authority bsa
      		INNER JOIN admin a on bsa.adminId = a.adminId
      		WHERE bsa.head_key='$key' AND bsa.branch_code='$branch_code'");
      	$signs = [];
      	while ($sign = $this->mfa($query)){
      		$signs[$sign["class"]][$sign["gender"]] = $sign;
      	}

      	$incharge = [];
      	$class_g = [];
      	if (sizeof($signs)>0){
      		if (isset($signs[$class])){
      			$class_g = $signs[$class];
      		} else if (isset($signs[0])){
      			$class_g = $signs[0];
      		}
      	}
      	if (sizeof($class_g)>0){
      		if (isset($class_g[$gender])){
      			$incharge = $class_g[$gender];
      		} else if (isset($class_g [""])){
      			$incharge = $class_g[""];
      		}
      	}


      	if (sizeof($incharge)<=0){
      		$incharge = $this->mfa($this->mq("SELECT DISTINCT * FROM admin WHERE branch_code='$branch_code' AND adminType LIKE '%Branch-In-Charge%'"));
      	}
      	return $incharge;
      }
    /////
      function render_barcode($code, $height="20px", $width="100px"){
      	$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
      	try {?><img style="width: <?=$width?>; height: <?=$height?>" src="data:image/png;base64, <?=base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128)) ?>"><?
      } catch (\Picqer\Barcode\Exceptions\BarcodeException $e) {
      	print($e->getMessage());
      }
  }

  function subscription_date($asession){
  	$sunbsciption_date_a=array();
  	for($i=1;$i<=12;$i++){
  		$month=$i/10<1?'0'.$i:$i;
  		$from_date='01-'.$month.'-'.$asession;
  		$sunbsciption_date_a['from_date'][$from_date]=$from_date;
  		$to_date=date('t-m-Y', strtotime('01-'.$month.'-'.$asession));
  		$sunbsciption_date_a['to_date'][$to_date]=$to_date;
  	}
  	return $sunbsciption_date_a;


  }

  function month_count($from_date,$to_date){
  	$d1=new DateTime($to_date);
  	$d2=new DateTime($from_date);
  	$Months = $d2->diff($d1);
  	return $howeverManyMonths = (($Months->y) * 12) + ($Months->m)+1;
  }
  function month_name_between_two_date($from_date,$to_date){
  	$date1  = $from_date;
  	$date2  = $to_date;
  	$output = [];
  	$time   = strtotime($date1);
  	$last   = date('F-Y', strtotime($date2));
  	do {
  		$month = date('F-Y', $time);
  		$total = date('t', $time);
  		$output[] = $month;
  		$time = strtotime('+1 month', $time);
  	} while ($month != $last);
  	return implode(",", $output);
  }



  function set_paytm_msg($subscription_id,$paytm_response_a,$payment_status=''){
  	$pyment_details=$this->rowByField('pyment_details','subscription','subscription_id',$subscription_id,$where="",$orderby='');
  	$dataToSave['pyment_details']=$pyment_details==''?serialize($paytm_response_a):serialize($paytm_response_a).'PAYTM_MESSAGE_SEPERATOR'.$pyment_details;
  	$dataToSave['payment_status']=$payment_status;
  	$qResult=$this->save('subscription',$dataToSave,'subscription_id',$subscription_id);




  	// if($paymentStatusbilldesk=='0300'){
  	// 	$dataToSave['paymentStatus']='paid';
  	// 	include('sendSms.php');
  	// 	$smsObj= new sms;
  	// 	$smsText="Thank you, we have received Rs. ".$apps['fees']." Your Registration No. is ".$apps['regNo']." Payment Reference No. is ".$refNo;

  	// 	$smsNumbersStr= $apps['mobile1'];
  	// 	$smsObj->sendSMS($smsText,$smsNumbersStr);
  	// 	$this->saveSendingSms($smsText,$mobileNos=$smsNumbersStr ,$applicantIds=$application['applicationId'], $status='send',$note='Paid Fees');
  	// 	$this->wtEmail($apps['email'],'Payment Success',$smsText);
  	// }
  	// if($paymentStatusbilldesk=='0399'){
  	// 	$dataToSave['paymentNote']=$dataToSave['paymentNote'].' Invalid Authentication at Bank';
  	// }
  	// if($paymentStatusbilldesk=='NA'){
  	// 	$dataToSave['paymentNote']=$dataToSave['paymentNote'].' Invalid Input';
  	// }
  	// if($paymentStatusbilldesk=='0002'){
  	// 	$dataToSave['paymentNote']=$dataToSave['paymentNote'].' BillDesk is waiting for Response';
  	// }
  	// if($paymentStatusbilldesk=='0001'){
  	// 	$dataToSave['paymentNote']=$dataToSave['paymentNote'].' Error at BillDesk  for Response';
  	// }



  }

  function change_form_status($change_status_a=array()){
  	if(is_array($change_status_a)&&count($change_status_a)>0){
  		$dataToSave['adminId']=$this->userDetails['adminId'];
  		$dataToSave['dated']=$this->now();
  		$dataToSave['formfillup_id']=$change_status_a['formfillup_id'];
  		$dataToSave['change_form']=$change_status_a['change_form'];
  		$dataToSave['change_to']=$change_status_a['change_to'];
            // $dataToSave['note']=$change_status_a['note'];
  		return $qResult=$this->save('form_status_history',$dataToSave,'form_status_history_id','');
  	}

  }

  function  state_list($cond='order by state asc')
			{
					
					$state_name=array();
					$dataQuery=" select distinct(state) state_name from post_code  $cond   ";
					$rsResults=$this->mq($dataQuery);
					 
					while($record=$this->mfa( $rsResults))
					{
					  $state_name[$record['state_name']]=$record['state_name'];
					}
			
			  return  $state_name;
			}
			function  district_list_bystate($state='',$cond='order by district asc')
			{
					
					$district_name=array();
					$dataQuery=" select distinct(district) district_name from post_code where state='$state'  $cond   ";
					$rsResults=$this->mq($dataQuery);
					 
					while($record=$this->mfa( $rsResults))
					{
					  $district_name[$record['district_name']]=$record['district_name'];
					}
			
			  return  $district_name;
			}



}





