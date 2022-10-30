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
$listHeader='New Admission';
$ajaxFilePath= 'admission_admin_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

  ?>
  <script>
  function calculate_room_no()
{
	var asessionVal= os.getVal('asession');

	var classVal= os.getVal('class');
	var sectionVal= os.getVal('section');
	var formdata = new FormData();
	formdata.append('asession',asessionVal );
	formdata.append('class_id',classVal );
	formdata.append('section',sectionVal );

	formdata.append('calculate_room_no','OK' );
	var url='<? echo $ajaxFilePath ?>?calculate_room_no=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('calculate_room_no_results',url,formdata);

}

function calculate_room_no_results(data)
{

	var building_name_value=	getData(data,'##--calculate_room-building_name--##');
	var floor_name_value=	getData(data,'##--calculate_room-floor_name--##');
	var room_name_value=getData(data,'##--calculate_room-room_name--##');
	var bed_no_value=getData(data,'##--calculate_room-bed_no--##');
	var hostel_room_id=getData(data,'##--calculate_room-hostel_room_id--##');
	os.setVal('building_name',building_name_value);
	os.setVal('floor_name',floor_name_value);
	os.setVal('room_name',room_name_value);
	os.setVal('bed_no',bed_no_value);
	os.setVal('hostel_room_id',hostel_room_id);

}

function ajax_chain(action_string)
	{
		var  conditions_val_str='';
		var actionARR=action_string.split('*');

		var  output_type=actionARR[0];
		var field_id=actionARR[1];
		var tableField=actionARR[2];
		var conditions=actionARR[3];
		conditions_arr=conditions.split(',');

	   for (i = 0; i < conditions_arr.length; i++)
			{
			var D=conditions_arr[i].split('=');


			if(D[1]!='')
			{
			 condition_field_id=D[1];

			var   condition_field_val=os.getVal(condition_field_id);

				conditions_val_str =conditions_val_str +	D[0]+'='+condition_field_val+', ';

				}
			}







		var formdata = new FormData();

		formdata.append('output_type',output_type );
		formdata.append('field_id',field_id );
		formdata.append('tableField',tableField );
		formdata.append('conditions_val_str',conditions_val_str );
		formdata.append('ajax_chain','OK' );
		var url='<? echo $ajaxFilePath ?>?ajax_chain=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('ajax_chain_results',url,formdata);

	}

function ajax_chain_results(data)
{
	var output_type=	getData(data,'##--output_type--##');
	var content_data=	getData(data,'##--ajax_chain_data--##');
	var ajax_chain_data_fild=	getData(data,'##--ajax_chain_data_fild--##');

	if(output_type=='html')
	{
		os.setHtml(ajax_chain_data_fild,content_data);
	}else
	{
		os.setVal(ajax_chain_data_fild,content_data);

	}

}
  </script>
  
<div class="title-bar">

    <h3 class="background-color-white" style="flex: 1; align-self: flex-end">
        <?php  echo $listHeader; ?> for session :
        <select name="asession" id="asession_s" class="text-l font-weight-xxl color-primary border-xxs border-color-primary border-radius-l"  onchange="admission_admin(''); " >
            <option value=""></option>
            <? $os->onlyOption($os->asession,$os->selectedSession());?>
        </select>
        class :
        <select name="classList" id="classList_s"  onchange="admission_admin('');" class="text-l font-weight-xxl color-primary border-xxs border-color-primary border-radius-l">
            <? $os->onlyOption($os->classList,'');	?>
        </select>
    </h3>

</div>
<div class="content with-both-side-bar">
    <div class="item with-header medium-sidebar">
        <div class="item-header">
            <div class="search-widget">
                <input type="search" placeholder="Search keyword" class="p-m" onkeyup="manage_fess_setting('search');"/>
            </div>
        </div>
        <div id="list_student_applicationmeritlist_or_previousclassmeritlist" class="item-content" ></div>

    </div>
    <!--content-->
    <div class="item background-color-white">
        <div class="item-content">
            <div id="form_student_registration"><!-- registration form  -->  please wait working...</div>
            <div id="form_student_registration_page2" style="display: none;" ><!-- registration data 2  -->please wait working...</div>
        </div>

	</div>

    <div class="item with-header medium-sidebar">
        <div class="item-header">
            <div class="search-widget">
                <input type="search" placeholder="Search keyword" class="p-m" onkeyup="manage_fess_setting('search');"/>
            </div>
        </div>

        <div  class="item-content" id="WT_studentListDiv">list student</div>
    </div>
</div>


<script>


function admission_admin(online_form_id)
{
	 var formdata = new FormData();
  // var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );
	var asession=os.getVal('asession_s');
	formdata.append('asession',asession );

	 var classList_s=os.getVal('classList_s');
	formdata.append('classList_s',classList_s );
	
	formdata.append('online_form_id',online_form_id );


	formdata.append('admission_admin','OK' );
	var url='<? echo $ajaxFilePath ?>?admission_admin=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('admission_admin_results',url,formdata);


}
function admission_admin_results(data)
{

	  var content_data=	getData(data,'##--ADMISSION-FORM-page1--##');
      os.setHtml('form_student_registration',content_data);


	  var content_data=	getData(data,'##--ADMISSION-STUDENT-list--##');
      os.setHtml('WT_studentListDiv',content_data);

	  var content_data=	getData(data,'##--meritlist-list-for-admission--##');
      os.setHtml('list_student_applicationmeritlist_or_previousclassmeritlist',content_data);



}

function step1()
{
	os.show('form_student_registration');
	os.hide('form_student_registration_page2');

}
function step2()
{
	payment_details();
	os.hide('form_student_registration');
	os.show('form_student_registration_page2');

}



function payment_details()
{


	 var formdata = new FormData();
  // var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );

	var asession=os.getVal('asession_s');
	formdata.append('asession',asession );
	var classList_s=os.getVal('classList_s');
	formdata.append('classList_s',classList_s );

	 var student_type=os.getVal('student_type');
	formdata.append('student_type',student_type );

    var vehicle=os.getVal('vehicle');
    formdata.append('vehicle',vehicle );

    var name=os.getVal('name');
    formdata.append('name',name );


	var vehicle_type_id=os.getVal('vehicle_type_id');
	formdata.append('vehicle_type_id',vehicle_type_id );

	var vehicle_distance_id=os.getVal('vehicle_distance_id');
	formdata.append('vehicle_distance_id',vehicle_distance_id );

	var vehicle_price=os.getVal('vehicle_price');
	formdata.append('vehicle_price',vehicle_price );

	var admission_date=os.getVal('admission_date');
	formdata.append('admission_date',admission_date );
	//-------------------------------------------//



	var discountTypeAdmission_val=os.getVal('discountTypeAdmission');
	formdata.append('discountTypeAdmission',discountTypeAdmission_val );

	var discountValueAdmission_val=os.getVal('discountValueAdmission');
	formdata.append('discountValueAdmission',discountValueAdmission_val );

	var discountTypeMonthly_val=os.getVal('discountTypeMonthly');
	formdata.append('discountTypeMonthly',discountTypeMonthly_val );

	var discountValueMonthly_val=os.getVal('discountValueMonthly');
	formdata.append('discountValueMonthly',discountValueMonthly_val );
	
	 
	
	
	
	var donation_val=os.getVal('donation');
	formdata.append('donation',donation_val );
	
	var donation_installment_val=os.getVal('donation_installment');
	formdata.append('donation_installment',donation_installment_val );






		/* student_type
		vehicle
		vehicle_type_id
		vehicle_distance_id
		vehicle_price
			*/

	//asession
	//name
	//dob


	formdata.append('payment_details','OK' );
	var url='<? echo $ajaxFilePath ?>?payment_details=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('payment_details_results',url,formdata);


}
function payment_details_results(data)
{

	  var content_data=	getData(data,'##--PAYMENT-FORM--##');
      os.setHtml('form_student_registration_page2',content_data);


}

function admission_process()
{

		var formdata = new FormData();
		// var  historyId =os.getVal('historyId');
		//	formdata.append('historyId',historyId );
		var asession=os.getVal('asession_s');
		formdata.append('asession',asession );

		var classList_s=os.getVal('classList_s');
		formdata.append('classList_s',classList_s );

		var student_type=os.getVal('student_type');
		formdata.append('student_type',student_type );

		var vehicle=os.getVal('vehicle');
		formdata.append('vehicle',vehicle );


		var vehicle_type_id=os.getVal('vehicle_type_id');
		formdata.append('vehicle_type_id',vehicle_type_id );

		var vehicle_distance_id=os.getVal('vehicle_distance_id');
		formdata.append('vehicle_distance_id',vehicle_distance_id );

		var vehicle_price=os.getVal('vehicle_price');
		formdata.append('vehicle_price',vehicle_price );

		var admission_date=os.getVal('admission_date');
		formdata.append('admission_date',admission_date );

		////////////////////////////////////////////   student data ////////////////

		//------------HISTORY DATA------
		var historyStatusVal= os.getVal('historyStatus');
		var asessionVal= os.getVal('asession');
		var registrationNoVal= os.getVal('registrationNo');
		var classVal= os.getVal('class');
		var sectionVal= os.getVal('section');
		var admission_noVal= os.getVal('admission_no');
		var admission_dateVal= os.getVal('admission_date');
		var roll_noVal= os.getVal('roll_no');
		var studentIdVal= os.getVal('studentId');
		var full_marksVal= os.getVal('full_marks');
		var obtain_marksVal= os.getVal('obtain_marks');
		var percentageVal= os.getVal('percentage');
		var pass_failVal= os.getVal('pass_fail');
		var gradeVal= os.getVal('grade');
		var remarksVal= os.getVal('remarks');
 

		// var formNoVal= os.getVal('formNo');
		var outGoingTcNoVal= os.getVal('outGoingTcNo');
		var outGoingTcDateVal= os.getVal('outGoingTcDate');
		var inactiveDateVal= os.getVal('inactiveDate');
		var streamVal= os.getVal('stream');


		formdata.append('stream',streamVal);
		formdata.append('outGoingTcNo',outGoingTcNoVal);
		formdata.append('outGoingTcDate',outGoingTcDateVal);
		formdata.append('inactiveDate',inactiveDateVal);
		// formdata.append('formNo',formNoVal );

		formdata.append('historyStatus',historyStatusVal );
		formdata.append('asession',asessionVal );
		formdata.append('registrationNo',registrationNoVal );
		formdata.append('class',classVal );
		formdata.append('section',sectionVal );
		formdata.append('admission_no',admission_noVal );
		formdata.append('admission_date',admission_dateVal );
		formdata.append('roll_no',roll_noVal );
		formdata.append('studentId',studentIdVal );
		formdata.append('full_marks',full_marksVal );
		formdata.append('obtain_marks',obtain_marksVal );
		formdata.append('percentage',percentageVal );
		formdata.append('pass_fail',pass_failVal );
		formdata.append('grade',gradeVal );
		formdata.append('remarks',remarksVal );

		var building_name_value= os.getVal('building_name');
		var floor_name_value= os.getVal('floor_name');
		var room_name_value= os.getVal('room_name');
		var bed_no_value= os.getVal('bed_no');
		var hostel_room_id= os.getVal('hostel_room_id');

		formdata.append('building_name',building_name_value );
		formdata.append('floor_name',floor_name_value );
		formdata.append('room_name',room_name_value );
		formdata.append('bed_no',bed_no_value );
		formdata.append('hostel_room_id',hostel_room_id );

		// -----payment parameters //

		var month_academic_list= getValuesFromCheckedBox('month_academic[]');
		var paid_amount_val= os.getVal('paid_amount');
		var payment_note_val= os.getVal('payment_note');
		var discountTypeAdmission_val= os.getVal('discountTypeAdmission');
		var discountValueAdmission_val= os.getVal('discountValueAdmission');
		var discountTypeMonthly_val= os.getVal('discountTypeMonthly');
		var discountValueMonthly_val = os.getVal('discountValueMonthly');

		formdata.append('month_academic_list',month_academic_list );
		formdata.append('discountTypeAdmission',discountTypeAdmission_val );
		formdata.append('discountValueAdmission',discountValueAdmission_val );
		formdata.append('discountTypeMonthly',discountTypeMonthly_val );
		formdata.append('discountValueMonthly',discountValueMonthly_val );

		formdata.append('paid_amount',paid_amount_val );
		formdata.append('payment_note',payment_note_val );
		
		
		var donation_installment_val= os.getVal('donation_installment');
		formdata.append('donation_installment',donation_installment_val );
		
		var donation_val= os.getVal('donation');
		formdata.append('donation',donation_val );
		
		var donation_val= os.getVal('donation');
		formdata.append('donation',donation_val );
		
		
		var donation_amount_paid_val= os.getVal('donation_amount_paid');
		formdata.append('donation_amount_paid',donation_amount_paid_val );
		
		var image_data= os.getVal('image_data');
		formdata.append('image_data',image_data );
		
		


		if(paid_amount_val<1){ alert('Please add payment amount'); return false;}

		//------------END HISTORY DATA------
		//------------STUDENT DATA------
		var kanyashreeVal= os.getVal('kanyashree');
		var yuvashreeVal= os.getVal('yuvashree');
		var boardVal= os.getVal('board');
		var feesPaymentVal= os.getVal('feesPayment');
		var nameVal= os.getVal('name');
		var dobVal= os.getVal('dob');
		var ageVal= os.getVal('age');
		var genderVal= os.getVal('gender');
		var registerDateVal= os.getVal('registerDate');
		var registerNoVal= os.getVal('registerNo');

		var casteVal= os.getVal('caste');
		var subcastVal= os.getVal('subcast');
		var apl_bplVal= os.getVal('apl_bpl');
		var minorityVal= os.getVal('minority');
		var adhar_nameVal= os.getVal('adhar_name');
		var adhar_dobVal= os.getVal('adhar_dob');
		var adhar_noVal= os.getVal('adhar_no');
		var phVal= os.getVal('ph');
		var ph_percentVal= os.getVal('ph_percent');
		var disableVal= os.getVal('disable');
		var disable_percentVal= os.getVal('disable_percent');
		var father_nameVal= os.getVal('father_name');
		var father_ocuVal= os.getVal('father_ocu');
		var father_adharVal= os.getVal('father_adhar');
		var mother_nameVal= os.getVal('mother_name');
		var mother_ocuVal= os.getVal('mother_ocu');
		var mother_adharVal= os.getVal('mother_adhar');
		var villVal= os.getVal('vill');
		var poVal= os.getVal('po');
		var psVal= os.getVal('ps');
		var distVal= os.getVal('dist');
		var blockVal= os.getVal('block');
		var pinVal= os.getVal('pin');
		var stateVal= os.getVal('state');
		var guardian_nameVal= os.getVal('guardian_name');
		var guardian_relationVal= os.getVal('guardian_relation');
		var guardian_addressVal= os.getVal('guardian_address');
		var guardian_ocuVal= os.getVal('guardian_ocu');
		var anual_incomeVal= os.getVal('anual_income');
		var mobile_studentVal= os.getVal('mobile_student');
		var mobile_guardianVal= os.getVal('mobile_guardian');
		var mobile_emergencyVal= os.getVal('mobile_emergency');
		var email_studentVal= os.getVal('email_student');
		var email_guardianVal= os.getVal('email_guardian');
		var mother_tongueVal= os.getVal('mother_tongue');
		var blood_groupVal= os.getVal('blood_group');
		var religianVal= os.getVal('religian');
		var other_religianVal= os.getVal('other_religian');
		var imageVal= os.getObj('image').files[0];
		//alert(imageVal);
		var last_schoolVal= os.getVal('last_school');
		var last_classVal= os.getVal('last_class');
		var tc_noVal= os.getVal('tc_no');
		var tc_dateVal= os.getVal('tc_date');
		var studentRemarksVal= os.getVal('studentRemarks');
		var accNoVal= os.getVal('accNo');
		var accHolderNameVal= os.getVal('accHolderName');
		var ifscCodeVal= os.getVal('ifscCode');
		var branchVal= os.getVal('branch');
		formdata.append('accNo',accNoVal );
		formdata.append('accHolderName',accHolderNameVal );
		formdata.append('ifscCode',ifscCodeVal );
		formdata.append('branch',branchVal );

		formdata.append('kanyashree',kanyashreeVal );
		formdata.append('yuvashree',yuvashreeVal );
		formdata.append('board',boardVal );
		formdata.append('feesPayment',feesPaymentVal );
		formdata.append('name',nameVal );
		formdata.append('dob',dobVal );
		formdata.append('age',ageVal );
		formdata.append('gender',genderVal );
		formdata.append('registerDate',registerDateVal );
		formdata.append('registerNo',registerNoVal );

		formdata.append('caste',casteVal );
		formdata.append('subcast',subcastVal );
		formdata.append('apl_bpl',apl_bplVal );
		formdata.append('minority',minorityVal );
		formdata.append('adhar_name',adhar_nameVal );
		formdata.append('adhar_dob',adhar_dobVal );
		formdata.append('adhar_no',adhar_noVal );
		formdata.append('ph',phVal );
		formdata.append('ph_percent',ph_percentVal );
		formdata.append('disable',disableVal );
		formdata.append('disable_percent',disable_percentVal );
		formdata.append('father_name',father_nameVal );
		formdata.append('father_ocu',father_ocuVal );
		formdata.append('father_adhar',father_adharVal );
		formdata.append('mother_name',mother_nameVal );
		formdata.append('mother_ocu',mother_ocuVal );
		formdata.append('mother_adhar',mother_adharVal );
		formdata.append('vill',villVal );
		formdata.append('po',poVal );
		formdata.append('ps',psVal );
		formdata.append('dist',distVal );
		formdata.append('block',blockVal );
		formdata.append('pin',pinVal );
		formdata.append('state',stateVal );
		formdata.append('guardian_name',guardian_nameVal );
		formdata.append('guardian_relation',guardian_relationVal );
		formdata.append('guardian_address',guardian_addressVal );
		formdata.append('guardian_ocu',guardian_ocuVal );
		formdata.append('anual_income',anual_incomeVal );
		formdata.append('mobile_student',mobile_studentVal );
		formdata.append('mobile_guardian',mobile_guardianVal );
		formdata.append('mobile_emergency',mobile_emergencyVal );
		formdata.append('email_student',email_studentVal );
		formdata.append('email_guardian',email_guardianVal );
		formdata.append('mother_tongue',mother_tongueVal );
		formdata.append('blood_group',blood_groupVal );
		formdata.append('religian',religianVal );
		formdata.append('other_religian',other_religianVal );
		if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
		formdata.append('last_school',last_schoolVal );
		formdata.append('last_class',last_classVal );
		formdata.append('tc_no',tc_noVal );
		formdata.append('tc_date',tc_dateVal );
		formdata.append('studentRemarks',studentRemarksVal );

		//------------END STUDENT DATA------


		if(os.check.empty('name','Please Add Name')==false){ return false;}
		//if(os.check.empty('dob','Please Add D.O.B')==false){ return false;}
		//if(os.check.empty('board','Please Add board')==false){ return false;}
		//if(os.check.empty('asession','Please Add session')==false){ return false;}
		//if(os.check.empty('class','Please Add class')==false){ return false;}
		if(os.check.empty('admission_date','Please Add admission date')==false){ return false;}


		formdata.append('admission_process','OK' );
		var url='<? echo $ajaxFilePath ?>?admission_process=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('admission_process_results',url,formdata);


}
function admission_process_results(data)
{

		var content_data=	getData(data,'##--admission_process--##');
		os.setHtml('admission_process_DIV',content_data);

		var content_data=	getData(data,'##--ADMISSION-STUDENT-list--##');
		os.setHtml('WT_studentListDiv',content_data);
		 var content_data=	getData(data,'##--meritlist-list-for-admission--##');
		 
		 os.setHtml('list_student_applicationmeritlist_or_previousclassmeritlist',content_data);


		os.hide('admission_process_button');
		//os.hide('registration_process_back');

       

}

	 


admission_admin('');
	</script>
 <script>
 
function select_months_for_bill()
{
	var total_month_fees=0;
	var total_month_discount=0;
	var total_month_count=0;

    os.hide('total_monthly_discount_row');
    os.hide('total_monthly_row');


	var x = document.getElementsByName('month_academic[]');
	var i;

	x = document.querySelectorAll("input[name='month_academic[]']");

	x.forEach(function(el){
	    if(el.checked) {
            total_month_count = total_month_count + 1;
            os.show('total_monthly_discount_row');
            os.show('total_monthly_row');
        }
    });

    /*
	for (i = 0; i < x.length; i++)
	{   $(x[i]).closest('tr').removeClass('active');
		if (x[i].checked)
		{
		   $(x[i]).closest('tr').addClass('active');
			total_month_count=total_month_count+1;
            os.show('total_monthly_discount_row');
            os.show('total_monthly_row');
		}
	}

     */

	var single_month_fees=os.getVal('monthly_single_fees_amount');
	var single_month_discount=os.getVal('monthly_single_discount_amount');
	
	 
	total_month_fees=int(single_month_fees)*total_month_count;
	
	total_month_discount=int(single_month_discount)*total_month_count;
  
  
	var admission_fees=os.getVal('admission_fees_amount');
	var admission_discount=os.getVal('admission_discount_amount');
	var totalfees_amount=int(total_month_fees)+int(admission_fees)-int(total_month_discount)-int(admission_discount);
	var paid_amount_val=os.getVal('paid_amount');
	var due_amount_val= totalfees_amount - int(paid_amount_val);
	os.setVal('monthly_total_fees_amount',total_month_fees);
	os.setVal('monthly_total_discount_amount',total_month_discount);
	os.setVal('totalfees',totalfees_amount);
	os.setVal('due_amount',due_amount_val);
	
	os.setHtml('total_month_count',total_month_count);
	os.setHtml('total_month_count_discount',total_month_count);

}


 



</script>
<div id="donation_form_div" style="display:none;">


</div>

<style>
    .list-view-dp{
        height: 45px;
        width: 35px;
        background-size: cover;
        background-position: center;
        background-color: #0b559b;
        border-radius:3px;

    }
    .list-view-dp p{
        padding:3px 5px;
        background-color: rgba(0,0,0,0.5);
        font-size: 11px;
        height: 18px;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
        border-radius:3px 3px 0 0;
    }
</style>
<? include($site['root-wtos'].'bottom.php'); ?>
