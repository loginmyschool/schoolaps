<? include_once('wtosConfigLocal.php');
include_once($site['root-wtos'].'wtosCommon.php');
global $os,$site;

global  $loadingImage;

$ajaxFilePath= $site["url-wtos"].'new_php_script.php';

if($os->get('removeRowAjaxFunction')=='OK' && $os->post('removeRowAjaxFunction')=='OK')
{
   $result_message='';
    $table=$os->post('table');
	 $table_fld=$os->post('table_fld');
	  $table_fld_val=$os->post('table_fld_val');
	   $query_plus=$os->post('query_plus');
	    $call_back_php=$os->post('call_back_php');
		$call_back_script=$os->post('call_back_script');

      $del_query="delete from  $table where $table_fld='$table_fld_val'   $query_plus ";
	  $os->mq($del_query);

	  if($call_back_php!='')
	  {
	   $call_back_php=$call_back_php.'()';
	   $os->$call_back_php;

	  }
	  $result_message='Deleted Successfully;';
	  echo "##-call_back_script-##"; echo $call_back_script;echo "##-call_back_script-##";
	  echo "##-result_message-##"; echo $result_message;echo "##-result_message-##";


 exit();
}

if($os->get('wtosInlineEdit')=='OK' && $os->post('wtosInlineEdit')=='OK')
{
			$result_message='';
			$table=$os->post('table');
			$edit_fld=$os->post('edit_fld');
			$where_fld=$os->post('where_fld');
			$where_fld_val=$os->post('where_fld_val');
			$input_value=$os->post('input_value');

			$input_value=trim($input_value);

			$query_plus=$os->post('query_plus');
			$call_back_php=$os->post('call_back_php');
			$call_back_script=$os->post('call_back_script');



        $del_query="update   $table set $edit_fld='$input_value' where $where_fld='$where_fld_val'   $query_plus ";
	  $os->mq($del_query);

	  if($call_back_php!='')
	  {
	    $os->$call_back_php();


	  }
	  $result_message='Updated Successfully;';
	  echo "##-call_back_script-##"; echo $call_back_script;echo "##-call_back_script-##";
	  echo "##-result_message-##"; echo $result_message;echo "##-result_message-##";


 exit();
}

if($os->get('wtos_update_verification_status')=='OK' && $os->post('wtos_update_verification_status')=='OK')
{
			$result_message='';
			$table=$os->post('table');
			$edit_fld=$os->post('edit_fld');
			$where_fld=$os->post('where_fld');
			$where_fld_val=$os->post('where_fld_val');
			$input_value=$os->post('input_value');

			$input_value=trim($input_value);

			$query_plus=$os->post('query_plus');
			$call_back_php=$os->post('call_back_php');
			$call_back_script=$os->post('call_back_script');
			$type=$os->post('type');

		//primery_verification_date
		//primery_verification_user
		//primery_verification_status

		   $verification_date=$os->now();
		   $verification_user=$os->userDetails['adminId'];

		   if($type=='primery')
		   {
		       echo  $update_query="update   $table set $edit_fld='$input_value' ,   
				primery_verification_date='$verification_date' ,  
				primery_verification_user='$verification_user'        
				where $where_fld='$where_fld_val'   $query_plus ";

		   }

		   if($type=='final')
		   {
		     echo    $update_query="update   $table set $edit_fld='$input_value' ,   
				final_verification_date='$verification_date' ,  
				final_verification_user='$verification_user'        
				where $where_fld='$where_fld_val'   $query_plus ";

		   }





			$os->mq($update_query);

			if($call_back_php!='')
			{
				$os->$call_back_php();
			}
			$result_message='Updated Successfully;';
			echo "##-call_back_script-##"; echo $call_back_script;echo "##-call_back_script-##";
			echo "##-result_message-##"; echo $result_message;echo "##-result_message-##";


 exit();
}




if($os->get('wt_ajax_chain')=='OK' && $os->post('wt_ajax_chain')=='OK')
{



 $output_type=$os->post('output_type');
 $field_id=$os->post('field_id');
 $tableField=$os->post('tableField');
 $conditions_val_str=$os->post('conditions_val_str');

 $query_plus=$os->post('query_plus');
			$call_back_php=$os->post('call_back_php');
			$call_back_script=$os->post('call_back_script');



  $tableField_arr=explode(',',$tableField);

  $table=$tableField_arr['0'];
  $table_id_fleld=$tableField_arr[1];
  $table_val_fleld=$tableField_arr[2];
    $conditions_str='';
    if($conditions_val_str!='')// asession=asession_s,vehicle_type=vehicle_type_id
	{

	$conditions_val_arr=explode(',',$conditions_val_str);
	$conditions_val_arr=array_filter($conditions_val_arr);
	foreach($conditions_val_arr as $condStr)
	{
	  $condArr=explode('=', $condStr);

	  //_d($condArr);
	  if(trim($condArr[0])){
	   $conditions_str= $conditions_str .  " and  ".$condArr[0]." = '".$condArr[1]."'";
	   }
	}


}




		$arr=array(); $val='';
		    $query2="select * from $table where  $table_id_fleld!=''   $conditions_str $query_plus ";
		$rsResults=$os->mq($query2);

		$val=0;
		while($record=$os->mfa( $rsResults))
		{
		  $arr[$record[$table_id_fleld]]=$record[$table_val_fleld];
		  $val=$record[$table_val_fleld];
		}

		if($call_back_php!='')
		{
			// $call_back_php=$call_back_php."(&$arr)";
			$os->$call_back_php($arr,$val); // example subject_by_exam(&$arr,&$val)

		}

	echo '##--ajax_chain_data_fild--##';
	echo $field_id;
	echo '##--ajax_chain_data_fild--##';
	echo '##--ajax_chain_data--##';
if($output_type=='html') {

   echo '<option value=""> </option>';
     	  $os->onlyOption($arr,'');
		  }else
		  {
		   echo  $val;

		  }
echo '##--ajax_chain_data--##';

 echo '##--output_type--##';
 echo $output_type;
  echo '##--output_type--##';
 echo "##-call_back_script-##"; echo $call_back_script;echo "##-call_back_script-##";



exit();
}


if($os->get('wtos_update_submitted_status')=='OK' && $os->post('wtos_update_submitted_status')=='OK')
{
			$result_message='';
			$table=$os->post('table');
			$edit_fld=$os->post('edit_fld');
			$where_fld=$os->post('where_fld');
			$where_fld_val=$os->post('where_fld_val');
			$input_value=$os->post('input_value');

			$query_plus=$os->post('query_plus');
			$call_back_php=$os->post('call_back_php');
			$call_back_script=$os->post('call_back_script');

			$element_id=$os->post('element_id');
			$element_text=$os->post('element_text');
		 	$update_query="update   $table set $edit_fld='$input_value'   where $where_fld='$where_fld_val'   $query_plus ";
		 	$os->mq($update_query);
			if($call_back_php!='')
			{
				$os->$call_back_php();
			}
			$result_message='Submitted Successfully;';
			echo "##-call_back_script-##"; echo $call_back_script;echo "##-call_back_script-##";
			echo "##-result_message-##"; echo $result_message;echo "##-result_message-##";
			echo "##-element_id-##"; echo $element_id;echo "##-element_id-##";
			echo "##-element_text-##"; echo $element_text;echo "##-element_text-##";


 exit();
}


?>

<script>
function removeRowAjaxFunction(table,table_fld,table_fld_val,query_plus,call_back_php,call_back_script)
{

	   var k=confirm('Are you sure. You want to delete this record?')
	    if(k)
		{}else{
		  return false;
		}


	    var formdata = new FormData();

		formdata.append('table',table );
		formdata.append('table_fld',table_fld );
		formdata.append('table_fld_val',table_fld_val );
		formdata.append('query_plus',query_plus );
		formdata.append('call_back_script',call_back_script );
		formdata.append('call_back_php',call_back_php );


	   formdata.append('removeRowAjaxFunction','OK' );
	   var url='<? echo $ajaxFilePath ?>?removeRowAjaxFunction=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('removeRowAjaxFunction_results',url,formdata);

}

function removeRowAjaxFunction_results(data)  // fill data form by JSON
{

    var call_back_script=	getData(data,'##-call_back_script-##');
	var result_message=	getData(data,'##-result_message-##');

	  if(call_back_script!=''){
	  setTimeout(call_back_script, 1);
	  }
	  alert(result_message);



}


function wtosInlineEdit(input_id,table,edit_fld,where_fld,where_fld_val,query_plus,call_back_php,call_back_script)
{
	    var formdata = new FormData();


		var input_value='';

		var input_obj=os.getObj(input_id);
		input_value=input_obj.value;
		//alert(input_obj.type);
		 if(input_obj.type=='checkbox')
		 {
		     input_value='';
		     if(input_obj.checked)
		     {
		        input_value=input_obj.value;
			}
		 }

	     formdata.append('input_value',input_value );
		formdata.append('table',table );
		formdata.append('edit_fld',edit_fld );
		formdata.append('where_fld',where_fld );
		formdata.append('where_fld_val',where_fld_val );
		formdata.append('query_plus',query_plus );
		formdata.append('call_back_script',call_back_script );
		formdata.append('call_back_php',call_back_php );


	   formdata.append('wtosInlineEdit','OK' );
	   var url='<? echo $ajaxFilePath ?>?wtosInlineEdit=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('wtosInlineEdit_results',url,formdata);

}

function wtosInlineEdit_results(data)  // fill data form by JSON
{

    var call_back_script=	getData(data,'##-call_back_script-##');
	var result_message=	getData(data,'##-result_message-##');

	  if(call_back_script!=''){
	  setTimeout(call_back_script, 1);
	  }
	  alert(result_message);



}
function wt_ajax_chain(action_string,query_plus,call_back_php,call_back_script)
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
		formdata.append('wt_ajax_chain','OK' );
		formdata.append('call_back_script',call_back_script );
		formdata.append('call_back_php',call_back_php );
		formdata.append('query_plus',query_plus );
		var url='<? echo $ajaxFilePath ?>?wt_ajax_chain=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('wt_ajax_chain_results',url,formdata);

	}

function wt_ajax_chain_results(data)
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

	 var call_back_script=	getData(data,'##-call_back_script-##');

      if(call_back_script!='')
	  {
	    setTimeout(call_back_script, 1);
	  }


}





////Added by nafish Ahmed
function populate_class_by_board(board, child_el='#classList_s')
{
    let htm =`<option value="">--CLASS--</option>`;
    if(board!='') {
        let boardClass = (JSON.parse(`<?= json_encode($os->board_class)?>`))[board];
        let classes = (JSON.parse(`<?= json_encode($os->classList)?>`));

        boardClass.forEach(classs => {
            htm += `<option value="${classs}">${classes[classs]}</option>`;
        })
    }

    document.querySelector(child_el).innerHTML= htm;
}

</script>

<style>
.removeRow{ color:#FF0000; display:none;}
.class_subject_subject:hover .removeRow{ display:inline; cursor:pointer;}
.Elective_check{   display:none; font-style:italic;}
.class_subject_subject:hover .Elective_check{ display:inline; cursor:pointer;}
.Elective_value{ color:#9E9E9E;  }


</style>
<!--  <span class="removeRow" onclick="removeRowAjaxFunction('subject','subjectId','<? //echo  $subjectId  ?>','','','')">X</span>  -->

 <!--onchange="ajax_chain('html*vehicle_distance_id*vehicle_config,vehicle_distance,vehicle_distance*asession=asession_s,vehicle_type=vehicle_type_id'); os.setVal('vehicle_price','')" -->


<script>
function wtos_update_verification_status(input_id,table,edit_fld,where_fld,where_fld_val,query_plus,call_back_php,call_back_script,type) // type=primery,final
{
	    var formdata = new FormData();
		var input_value='';
		var input_obj=os.getObj(input_id);
		input_value=input_obj.value;
		 if(input_obj.type=='checkbox')
		 {
		     input_value='';
		     if(input_obj.checked)
		     {
		        input_value=input_obj.value;
			}
		 }

         if(type==''){type='primery';}
	    formdata.append('input_value',input_value );
		formdata.append('table',table );
		formdata.append('edit_fld',edit_fld );
		formdata.append('where_fld',where_fld );
		formdata.append('where_fld_val',where_fld_val );
		formdata.append('query_plus',query_plus );
		formdata.append('call_back_script',call_back_script );
		formdata.append('call_back_php',call_back_php );
		formdata.append('type',type );



	   formdata.append('wtos_update_verification_status','OK' );
	   var url='<? echo $ajaxFilePath ?>?wtos_update_verification_status=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('wtos_update_verification_status_results',url,formdata);

}

function wtos_update_verification_status_results(data)  // fill data form by JSON
{

    var call_back_script=	getData(data,'##-call_back_script-##');
	var result_message=	getData(data,'##-result_message-##');

	  if(call_back_script!=''){
	  setTimeout(call_back_script, 1);
	  }
	  alert(result_message);

}



function wtos_update_submitted_status(element_id,element_text,input_value,table,edit_fld,where_fld,where_fld_val,query_plus,call_back_php,call_back_script)
{

		 var k=confirm('Once you submit you will not be able to edit this record. Please verify and submit.')
	    if(k)
		{}else{
		  return false;
		}



		var formdata = new FormData();

		//input_value  // value will save to field  edit_fld;
		formdata.append('input_value',input_value );
		formdata.append('table',table );
		formdata.append('edit_fld',edit_fld );
		formdata.append('where_fld',where_fld );
		formdata.append('where_fld_val',where_fld_val );
		formdata.append('query_plus',query_plus );
		formdata.append('call_back_script',call_back_script );
		formdata.append('call_back_php',call_back_php );
		formdata.append('element_id',element_id );
		formdata.append('element_text',element_text );




		formdata.append('wtos_update_submitted_status','OK' );
		var url='<? echo $ajaxFilePath ?>?wtos_update_submitted_status=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxFunc('wtos_update_submitted_status_results',url,formdata);

}

function wtos_update_submitted_status_results(data)  // fill data form by JSON
{

		var call_back_script=	getData(data,'##-call_back_script-##');
		var result_message=	getData(data,'##-result_message-##');
		var element_id=	getData(data,'##-element_id-##');
		var element_text=	getData(data,'##-element_text-##');
		os.setHtml(element_id,element_text);

		if(call_back_script!=''){
		setTimeout(call_back_script, 1);
		}
		alert(result_message);

}

</script>

