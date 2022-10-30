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
$listHeader='RE ADMISSION';
$ajaxFilePath='re_admission_admin_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
  ?>
    <div class="title-bar">

        <h3 class="background-color-white" style="flex: 1; align-self: flex-end">
            <?php  echo $listHeader; ?> for session :
            <select name="asession" id="asession_s" class="text-l font-weight-xxl color-primary border-xxs border-color-primary border-radius-l" onchange="re_admission_admin('',''); " ><option value=""></option><?
                $os->onlyOption($os->asession,$os->selectedSession());?></select>
            class :
            <select name="classList" id="classList_s"  onchange="re_admission_admin();" class="text-l font-weight-xxl color-primary border-xxs border-color-primary border-radius-l">
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
        <div id="list_student_applicationmeritlist_or_previousclassmeritlist" class="item-content">

        </div>
    </div>
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


function re_admission_admin(studentId,historyId)
{


	 var formdata = new FormData();

	 if(studentId==''){
      // var  studentId =os.getVal('studentId');
    }
	if(historyId==''){
     //  var  historyId =os.getVal('historyId');
    }


    formdata.append('historyId',historyId );
	formdata.append('studentId',studentId );



	var asession=os.getVal('asession_s');
	formdata.append('asession',asession );

	 var classList_s=os.getVal('classList_s');
	formdata.append('classList_s',classList_s );


	formdata.append('re_admission_admin','OK' );
	var url='<? echo $ajaxFilePath ?>?re_admission_admin=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('re_admission_admin_results',url,formdata);


}
function re_admission_admin_results(data)
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
  //  var  historyId =os.getVal('historyId');
 //	formdata.append('historyId',historyId );

	var asession=os.getVal('asession_s');
	formdata.append('asession',asession );
	var classList_s=os.getVal('classList_s');
	formdata.append('classList_s',classList_s );

	 var student_type=os.getVal('student_type');
	formdata.append('student_type',student_type );

	var name = os.getVal("name");
	formdata.append('name', name);

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
		var  historyId =os.getVal('historyId');
		formdata.append('historyId',historyId );


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
		var asessionVal= os.getVal('asession');
		formdata.append('asession',asessionVal );

		var classVal= os.getVal('class');
		formdata.append('class',classVal );

		var sectionVal= os.getVal('section');
		formdata.append('section',sectionVal );

		var admission_dateVal= os.getVal('admission_date');
		formdata.append('admission_date',admission_dateVal );




		var roll_noVal= os.getVal('roll_no');
		formdata.append('roll_no',roll_noVal );

		var studentIdVal= os.getVal('studentId');
		formdata.append('studentId',studentIdVal );


		var remarksVal= os.getVal('remarks');
		formdata.append('remarks',remarksVal );

		var streamVal= os.getVal('stream');
		formdata.append('stream',streamVal);


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
		
		
		if(paid_amount_val<1){ alert('Please add payment amount'); return false;}

		//------------END HISTORY DATA------

		//if(os.check.empty('name','Please Add Name')==false){ return false;}
		//if(os.check.empty('dob','Please Add D.O.B')==false){ return false;}
		//if(os.check.empty('board','Please Add board')==false){ return false;}
		//if(os.check.empty('asession','Please Add session')==false){ return false;}
		//if(os.check.empty('class','Please Add class')==false){ return false;}
		if(os.check.empty('admission_date','Please Add admission date')==false){ return false;}


		formdata.append('re_admission_process','OK' );
		var url='<? echo $ajaxFilePath ?>?re_admission_process=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('re_admission_process_results',url,formdata);


}
function re_admission_process_results(data)
{

		var content_data=	getData(data,'##--admission_process--##');
		os.setHtml('admission_process_DIV',content_data);

		var content_data=	getData(data,'##--ADMISSION-STUDENT-list--##');
		os.setHtml('WT_studentListDiv',content_data);
		
		
		 var content_data=	getData(data,'##--meritlist-list-for-readmission--##');
		 
		 os.setHtml('list_student_applicationmeritlist_or_previousclassmeritlist',content_data);

		os.hide('admission_process_button');
		//os.hide('registration_process_back');




}

	 


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
	for (i = 0; i < x.length; i++)
	{   $(x[i]).closest('tr').css('backgroundColor','');
		if (x[i].checked)
		{
		   $(x[i]).closest('tr').css('backgroundColor','yellow');
			total_month_count=total_month_count+1;
            os.show('total_monthly_discount_row');
            os.show('total_monthly_row');
		}
	}

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

}

 
 re_admission_admin('','');
</script>
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
