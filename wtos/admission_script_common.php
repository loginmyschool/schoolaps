<?
  global $os,$ajaxFilePath,$loadingImage;
 ?>

<script>
    function getValuesFromCheckedBox(name)
    {
        var  selected_item ='';
        var x = document.getElementsByName(name);

        var i;
        for (i = 0; i < x.length; i++) {


            if (x[i].checked) {

                selected_item = selected_item +x[i].value +',';

            }
        }

        return selected_item;
    }
    function getValuesFromTextBoxArray(name)
    {
        var  selected_item ='';
        var x = document.getElementsByName(name);

        var i;
        for (i = 0; i < x.length; i++) {


            if (x[i].value!='') {

                selected_item = selected_item +x[i].value +',';

            }
        }

        return selected_item;
    }
    function getData(string,seperator)
    {
        var D=string.split(seperator);
        return D[1];
    }
    function showhide(id)
    {

        if(os.getObj(id).style.display=='none')
        {
            os.getObj(id).style.display='block'
        }else
        {

            os.getObj(id).style.display='none'
        }

    }
    function set_edit_container(title,content)
    {
        os.setHtml('wtos_edit_container_head',title);
        os.setHtml('wtos_edit_container_data',content);
        os.show('wtos_edit_container');
    }
    function setClass(id,classStyleName)
    {
        os.getObj(id).className=classStyleName;
    }


    function showEditForm()
    {
        setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_show_ajaxViewMainTableTDForm');
    }
    function hideEditForm()
    {
        setClass('id_ajaxViewMainTableTDForm','ajaxViewMainTableTDForm mobile_hide_ajaxViewMainTableTDForm');

    }

    function popDialog(elementId,titles,obj)
    {    
	
	     if(titles!='')
		 { 
         	os.getObj(elementId).title=titles;
		 }
        
		$( function() 
		{
            $( "#"+elementId ).dialog(obj);
        } );

    }



    function collapse_expand(button, container) {
        $(container).toggle("fast",function () {
            if($(container).css("display")==="none"){
                $("i", button).html("keyboard_arrow_down");
            } else {
                $("i", button).html("keyboard_arrow_up");
            }
        });
    }

///------------------------admission readmission function-------------------

 

function set_vehicle()
{
	var vv=os.getObj('vehicle').checked;
	os.hide('vehicle_data');
	os.setVal('vehicle','');
	if(vv==true)
	{
		os.setVal('vehicle','1');
		os.show('vehicle_data');
	}


}

function manage_vehicle_option()
{
	var vv=os.getVal('student_type');

	vv=  vv.replace(' ','');
	os.show('vehiclediv');
	os.hide('hotel_room_div');

	os.setVal('building_name','');
	os.setVal('floor_name','');
	os.setVal('room_name','');
	os.setVal('bed_no','');
	os.setVal('hostel_room_id','');

	if(vv=='Hosteler')
	{
		calculate_room_no();

		os.hide('vehiclediv');

		os.setVal('vehicle_price','');
		os.setVal('vehicle_type_id','');
		os.setVal('vehicle_distance_id','');
		os.getObj('vehicle').checked=false;

		os.show('hotel_room_div');
	}


}


function int(val)
{
	var vals=0;
	if(parseInt(val))
	{
		vals=parseInt(val);
	}
	return vals;
}
function print_receipt_fees(fees_payment_id,directprint)
{

	 
	//alert(fees_payment_id);// 99999999
	 
	if(fees_payment_id=='0')
	{
		alert('Please Select Payment');
		return false;
	}
	
	//var URLStr='printFeesReceipt.php?copy_type=student&directprint='+directprint+'&fees_payment_id='+fees_payment_id;
	 
	var URLStr='printFeesReceipt.php?copy_type=both&directprint='+directprint+'&fees_payment_id='+fees_payment_id;
	popUpWindow(URLStr, 10, 10, 1200, 600);
	 
 
}



function process_donation_payment()
{




	popDialog('donation_form_div','Donation Details. ');
}
function loadMoredata()
	{
		var MoreStudentData_status= os.getObj('MoreStudentData').style.display;

		if(MoreStudentData_status=='none')
		{
			os.showj('MoreStudentData');
			os.setHtml('spmorebutton','Hide More');
		}

		if(MoreStudentData_status=='block' || MoreStudentData_status=='' )
		{
			os.hidej('MoreStudentData');
			os.setHtml('spmorebutton','More');

		}

	}
///------------------------------------

</script>