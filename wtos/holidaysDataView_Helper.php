<? global $os;


?>
<div id='prepareDataFor_div' title="" style="display:none; width:900px; height:500px;">
			<div id="prepareDataFor_div_content">
			234
			</div>

			</div>
<script>



function bulkADmit()
{


		 var formdata = new FormData();
  //   var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );


	formdata.append('bulkADmit','OK' );
	var url='<? echo $ajaxFilePath ?>?bulkADmit=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('bulkADmit_results',url,formdata);
	popDialog('prepareDataFor_div','Admit');

}
function bulkADmit_results(data)
{
	os.setHtml('prepareDataFor_div_content',data);


}

function bulkClassCertificate()
{


		 var formdata = new FormData();
  //   var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );


	formdata.append('bulkClassCertificate','OK' );
	var url='<? echo $ajaxFilePath ?>?bulkClassCertificate=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('bulkClassCertificate_results',url,formdata);
	popDialog('prepareDataFor_div','Admit');

}
function bulkClassCertificate_results(data)
{
	os.setHtml('prepareDataFor_div_content',data);


}


function get_class_exam()
{
	var formdata = new FormData();

	var asession_sVal= os.getVal('asession_s');
	formdata.append('asession_s',asession_sVal );


	var class_sVal= os.getVal('class_s');
	formdata.append('class_s',class_sVal );
	if(class_sVal==''){ alert('please select class', 'warning'); return false;}

	formdata.append('get_class_exam','OK' );
	var url='<? echo $ajaxFilePath ?>?get_class_exam=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('get_class_exam_results',url,formdata);
	popDialog('prepareDataFor_div','Exam');

}
function get_class_exam_results(data)
{
	os.setHtml('prepareDataFor_div_content',data);


}

function PrintMarksheet(historyId,ids,exam_id_fld)
{
	var formdata = new FormData();
     var historyIds='';
	if(historyId==''){
     historyIds=	getValuesFromCheckedBox(ids);
	}else
	{
	historyIds=	historyId;
	}

	var exam_id=os.getVal(exam_id_fld);
	if(historyIds==''){ alert('Please select atleast one record', 'warning'); return false;}



	var URLStr='printMarkSheetData.php?exam_id='+exam_id+'&historyId='+historyIds;


	popUpWindow(URLStr, 10, 10, 1200, 600);






}



function bulkCertificate(certificate_type,ids,historyId)
{


	var formdata = new FormData();
    var historyIds='';
	if(historyId==''){
     historyIds=	getValuesFromCheckedBox(ids);
	}else
	{
	historyIds=	historyId;
	}

	 if(historyIds==''){ alert('Please select atleast one record', 'warning'); return false;}



	var URLStr='printCertificateData.php?certificate_type='+certificate_type+'&historyId='+historyIds;


	popUpWindow(URLStr, 10, 10, 1200, 600);


}







function bulkTransferCertificate()
{


		 var formdata = new FormData();
  //   var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );


	formdata.append('bulkTransferCertificate','OK' );
	var url='<? echo $ajaxFilePath ?>?bulkTransferCertificate=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('bulkTransferCertificate_results',url,formdata);
	popDialog('prepareDataFor_div','Admit');

}
function bulkTransferCertificate_results(data)
{
	os.setHtml('prepareDataFor_div_content',data);


}




function bulkAdmission()
{


		 var formdata = new FormData();
  //   var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );


	formdata.append('bulkAdmission','OK' );
	var url='<? echo $ajaxFilePath ?>?bulkAdmission=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('bulkAdmission_results',url,formdata);
	popDialog('prepareDataFor_div','Admit');

}
function bulkAdmission_results(data)
{
	os.setHtml('prepareDataFor_div_content',data);


}




function bulkReAdmission()
{


		 var formdata = new FormData();
  //   var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );


	formdata.append('bulkReAdmission','OK' );
	var url='<? echo $ajaxFilePath ?>?bulkReAdmission=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('bulkReAdmission_results',url,formdata);
	popDialog('prepareDataFor_div','Admit');

}
function bulkReAdmission_results(data)
{
	os.setHtml('prepareDataFor_div_content',data);


}

function bulkSchoolLeavingCertificate()
{


		 var formdata = new FormData();
  //   var  historyId =os.getVal('historyId');
//	formdata.append('historyId',historyId );


	formdata.append('bulkSchoolLeavingCertificate','OK' );
	var url='<? echo $ajaxFilePath ?>?bulkSchoolLeavingCertificate=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('bulkSchoolLeavingCertificate_results',url,formdata);
	popDialog('prepareDataFor_div','Admit');

}
function bulkSchoolLeavingCertificate_results(data)
{
	os.setHtml('prepareDataFor_div_content',data);


}





 function  student_fees(historyId)
 {

	if(historyId<1)
	{
		var historyId=os.getVal('historyId');
		if(historyId=='0')
		{
			alert('Please Select Student', 'warning');
			return false;
		}
	}

	var formdata = new FormData();
	formdata.append('historyId',historyId);

	formdata.append('student_fees','OK');
	var url='<? echo $ajaxFilePath ?>?student_fees=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('student_fees_result',url,formdata);




 }

 function student_fees_result(data)
 {


  var output= getData(data,'##--student_fees_result--##');
  os.setHtml('student_data_form_DIV_ID',output);



 }



 function  student_results(historyId)
 {

 if(historyId<1)
	{
		var historyId=os.getVal('historyId');
		if(historyId=='0')
		{
			alert('Please Select Student', 'warning');
			return false;
		}
	}

	var formdata = new FormData();
	formdata.append('historyId',historyId);

	formdata.append('student_results','OK');
	var url='<? echo $ajaxFilePath ?>?student_results=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('student_results_result',url,formdata);



 }

 function student_results_result(data)
 {
  var output= getData(data,'##--student_results_result--##');
  os.setHtml('student_data_form_DIV_ID',output);

 }

 function  student_attendence(historyId)
 {

 if(historyId<1)
	{
		var historyId=os.getVal('historyId');
		if(historyId=='0')
		{
			alert('Please Select Student', 'warning');
			return false;
		}
	}

	var formdata = new FormData();
	formdata.append('historyId',historyId);

	formdata.append('student_attendence','OK');
	var url='<? echo $ajaxFilePath ?>?student_attendence=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('student_attendence_result',url,formdata);



 }


  function student_attendence_result(data)
 {
  var output= getData(data,'##--student_attendence_result--##');
  os.setHtml('student_data_form_DIV_ID',output);

 }

function get_student_profile(historyId) // get record by table primery id
{
	var formdata = new FormData();
	formdata.append('historyId',historyId );

	formdata.append('get_student_profile','OK' );
	var url='<? echo $ajaxFilePath ?>?get_student_profile=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('get_student_profile_results',url,formdata);

   //default call fees
     //  student_fees(historyId);

}
function get_student_profile_results(data)  // fill data form by JSON
{

     var output= getData(data,'##--get_student_profile_data--##');
     os.setHtml('student_profile_DIV',output);

	 var output= getData(data,'##-HISTORY-LIST-CLASS-DATA-##');
     os.setHtml('all_session_history_data_DIV',output);
	  var output= getData(data,'##-STUDENT-DOCUMENTS-LINKS-##');
     os.setHtml('student_doc_link_DIV',output);
	 
	  var output= getData(data,'##-student_data_form_DIV_ID_data-##');
     os.setHtml('student_data_form_DIV_ID',output);



}
 function  student_edit_form(historyId)
 {

 if(historyId<1)
	{
		var historyId=os.getVal('historyId');
		if(historyId=='0')
		{
			alert('Please Select Student', 'warning');
			return false;
		}
	}



	var formdata = new FormData();
	formdata.append('historyId',historyId);

	formdata.append('student_edit_form','OK');
	var url='<? echo $ajaxFilePath ?>?student_edit_form=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('student_edit_form_result',url,formdata);



 }


  function student_edit_form_result(data)
 {
  var output= getData(data,'##--student_edit_form--##');
  os.setHtml('student_data_form_DIV_ID',output);

 }
 function select_fees_student_ids_for_bill()
{
	var total_month_fees=0;
	var total_month_discount=0;
	var total_month_count=0;

    os.hide('total_monthly_discount_row');
    os.hide('total_monthly_row');


	var x = document.getElementsByName('fees_student_ids[]');
	var i;

	x = document.querySelectorAll("input[name='fees_student_ids[]']");

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


function generate_receipt_for_fees()
{

		var formdata = new FormData();
		var  historyId =os.getVal('historyId');
		formdata.append('historyId',historyId );

		var studentIdVal= os.getVal('studentId');
		formdata.append('studentId',studentIdVal );


		var fees_student_ids= getValuesFromCheckedBox('fees_student_ids[]');
		var fees_student_ids_other= getValuesFromCheckedBox('fees_student_ids_other[]');
		fees_student_ids=fees_student_ids_other+fees_student_ids;




		formdata.append('fees_student_ids',fees_student_ids );

		 var fees_student_ids_donation= getValuesFromCheckedBox('fees_student_ids_donation[]');
		formdata.append('fees_student_ids_donation',fees_student_ids_donation );

		var paid_amount_val= os.getVal('paid_amount');

		formdata.append('paid_amount',paid_amount_val );

		var payment_note_val= os.getVal('payment_note');
		formdata.append('payment_note',payment_note_val );

		var donation_amount_paid_val= os.getVal('donation_amount_paid');
		formdata.append('donation_amount_paid',donation_amount_paid_val );


		if(paid_amount_val<1){ alert('Please add payment amount', 'warning'); return false;}



		formdata.append('generate_receipt_for_fees_results','OK' );
		var url='<? echo $ajaxFilePath ?>?generate_receipt_for_fees_results=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('generate_receipt_for_fees_results',url,formdata);


}
function generate_receipt_for_fees_results(data)
{



		 var content_data=	getData(data,'##--payment_data--##');
		 os.setHtml('payment_data_DIV',content_data);

		 var student_fees_list_table_data=	getData(data,'##--student_fees_list_table_div--##');
		 os.setHtml('student_fees_list_table_div',student_fees_list_table_data);

		 var fees_payment_list_table_data=	getData(data,'##--fees_payment_list_table_div--##');
		 os.setHtml('fees_payment_list_table_div',fees_payment_list_table_data);

		 os.hide('admission_process_button');


}
function genarate_FEES_single()
{

genarate_FEES_single_ajax('');

}

function genarate_FEES_single_ajax(wt_action)
{
	var formdata = new FormData();


	    var  historyId =os.getVal('historyId');
		formdata.append('historyId',historyId );


		var student_type=os.getVal('student_type');
		formdata.append('student_type',student_type );

		var admissionType=os.getVal('admissionType');
		formdata.append('admissionType',admissionType );



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



		var remarks= os.getVal('remarks');
		formdata.append('remarks',remarks );



		var discountTypeAdmission_val= os.getVal('discountTypeAdmission');
		var discountValueAdmission_val= os.getVal('discountValueAdmission');
		var discountTypeMonthly_val= os.getVal('discountTypeMonthly');
		var discountValueMonthly_val = os.getVal('discountValueMonthly');


		formdata.append('discountTypeAdmission',discountTypeAdmission_val );
		formdata.append('discountValueAdmission',discountValueAdmission_val );
		formdata.append('discountTypeMonthly',discountTypeMonthly_val );
		formdata.append('discountValueMonthly',discountValueMonthly_val );




		var donation_installment_val= os.getVal('donation_installment');
		formdata.append('donation_installment',donation_installment_val );

		var donation_val= os.getVal('donation');
		formdata.append('donation',donation_val );




	formdata.append('genarate_FEES_single_ajax','OK' );
	formdata.append('wt_action',wt_action);
	var url='<? echo $ajaxFilePath ?>?genarate_FEES_single_ajax=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('genarate_FEES_single_result',url,formdata);

}

function genarate_FEES_single_result(data)
{

   var historyId=	getData(data,'##--genarate_FEES_historyId--##');
    var genarate_FEES_done=	getData(data,'##--genarate_FEES_done--##');

	if(genarate_FEES_done)
	{
	  student_fees(historyId);
	}




}
function  student_icard_single(historyId)
 {

 if(historyId<1)
	{
		var historyId=os.getVal('historyId');
		if(historyId=='0')
		{
			alert('Please Select Student', 'warning');
			return false;
		}
	}

	var formdata = new FormData();
	formdata.append('historyId',historyId);

	formdata.append('student_icard_single','OK');
	var url='<? echo $ajaxFilePath ?>?student_icard_single=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
	os.setAjaxFunc('student_icard_single_result',url,formdata);



 }

 function student_icard_single_result(data)
 {
  var output= getData(data,'##--student_icard_single_result--##');
  os.setHtml('student_data_form_DIV_ID',output);

 }


function create_single_fees(historyId)
{
   
   var formdata = new FormData();
	formdata.append('historyId',historyId);
	
	var fees_for=os.getVal('fees_for');
	formdata.append('fees_for',fees_for);
	
	var fees_for_amount=os.getVal('fees_for_amount');
	formdata.append('fees_for_amount',fees_for_amount);
	   
	var fees_for_date=os.getVal('fees_for_date');
	formdata.append('fees_for_date',fees_for_date);
	
	if(os.check.empty('fees_for','Please add fees head')==false){ return false;}
	if(os.check.empty('fees_for_amount','Please enter fees amount')==false){ return false;}
	
   
   var p=confirm('You are going to create new fees called :'+fees_for +', Amount:'+fees_for_amount+'.   Are you sure?');
   if(p)
   {
   
			if(historyId<1)
			{
				//var historyId=os.getVal('historyId');
				if(historyId=='0')
				{
					alert('Please Select Student', 'warning');
					return false;
				}
			}
		
			
		
			formdata.append('create_single_fees','OK');
			var url='<? echo $ajaxFilePath ?>?create_single_fees=OK&';
			os.animateMe.div='div_busy';
			os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
			os.setAjaxFunc('create_single_fees_result',url,formdata);
   }
}

 function create_single_fees_result(data)
 {
    
   
		var historyId= getData(data,'##--historyId--##');
		student_fees_collect(historyId,'');
		os.setVal('fees_for','');
		os.setVal('fees_for_amount','');
		os.hide('create_fees_div_id');
		os.show('create_fees_button_id');
	 
	 
	   

 }
 
 function show_single_fees_form(data)
 {
 
   os.hide('create_fees_button_id');
		os.show('create_fees_div_id');
    
							
 }
 
 function  delete_unpaid_fees_rows(historyId,fees_student_id,feesType,totalPayble)
 {
      
 var p=confirm('You are going to delete fees record  :'+feesType +', Amount:'+totalPayble+'.   Are you sure?');
  if(p)
  	 {
   

			var formdata = new FormData();
			formdata.append('historyId',historyId);
			formdata.append('fees_student_id',fees_student_id);
		
			formdata.append('delete_unpaid_fees_rows','OK');
			var url='<? echo $ajaxFilePath ?>?delete_unpaid_fees_rows=OK&';
			os.animateMe.div='div_busy';
			os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
			os.setAjaxFunc('delete_unpaid_fees_rows_result',url,formdata);

   } 

 }

 function delete_unpaid_fees_rows_result(data)
 {
        var historyId= getData(data,'##--historyId--##');
		student_fees_collect(historyId,'');

 }
 
function create_fees_waiveoff(history_id,fees_student_id,due_amt)
{
 
 
  var waive_amount=prompt('Put waived off amount.');
  if(waive_amount)
  	 {
		var p=confirm('You are going to waived off fees amount  :'+ waive_amount + '.  Are you sure?');
		if(p)
		 {
	
				var formdata = new FormData();
				formdata.append('historyId',history_id);
				formdata.append('fees_student_id',fees_student_id);
				formdata.append('due_amt',due_amt);
				formdata.append('waive_amount',waive_amount);
				
			
				formdata.append('create_fees_waiveoff','OK');
				var url='<? echo $ajaxFilePath ?>?create_fees_waiveoff=OK&';
				os.animateMe.div='div_busy';
				os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
				os.setAjaxFunc('create_fees_waiveoff_result',url,formdata);
	
	   }
   } 



}  


 function create_fees_waiveoff_result(data)
 {
        var historyId= getData(data,'##--historyId--##');
		    student_fees_collect(historyId,'');

 }
 
 function create_fees_waiveoff_result(data)
 {
        var historyId= getData(data,'##--historyId--##');
		    student_fees_collect(historyId,'');

 }
 
 function hideGenerateButton()
 {
       if(document.getElementById('generateButton')){
             os.hide('generateButton');
		 }
 }
 
 function  delete_all_payment_by_history_id(historyId)
 {
      
 var p=confirm('You are going to delete all payment ');
  if(p)
  	 {
   

			var formdata = new FormData();
			formdata.append('historyId',historyId);
			 
		
			formdata.append('delete_all_payment_by_history_id','OK');
			var url='<? echo $ajaxFilePath ?>?delete_all_payment_by_history_id=OK&';
			os.animateMe.div='div_busy';
			os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
			os.setAjaxFunc('delete_all_payment_by_history_id_result',url,formdata);

   } 

 }

 function delete_all_payment_by_history_id_result(data)
 {
        var historyId= getData(data,'##--historyId--##');
		student_fees_collect(historyId,'');

 }
 
  

</script>
