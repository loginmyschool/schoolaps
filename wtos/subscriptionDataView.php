<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Subscription';
$ajaxFilePath= 'subscriptionAjax.php';
// $os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>
<!-- This is Subscription Details modal -->
<div id="subscription_details_modal" class="uk-flex-top" uk-modal>
	<div class="uk-modal-dialog uk-width-1-1">
		<button class="uk-modal-close-default" type="button" uk-close></button>
		<div class="uk-card uk-card-default uk-card-small">
			<div class="uk-card-header">
				<h5>Subscription Details</h5>
			</div>
			<div  id="sub_details_div">
			</div>
		</div>
	</div>
</div>
<!-- End Sub Details Modal -->
<div id="form_modal" class="uk-modal-container" uk-modal>
	<div class="uk-modal-dialog uk-width-medium">
		<button class="uk-modal-close-default uk-text-danger" type="button" uk-close></button>
		<div class="uk-card uk-card-default uk-card-small">	
			<div class="uk-card-header">
				<h4 id="subscription_title" class="uk-text-large uk-text-italic uk-text-emphasis">New Subscription</h4>
			</div>
			<form   onsubmit="event.preventDefault(); WT_subscriptionEditAndSave(this);" id="subs_form">
				<div class="uk-card-body">
					<div class="uk-child-width-1-2@m" uk-grid>
						<div>
							<div class="uk-margin-small ">
								Student Id:<input value="" type="text" name="studentId" id="studentId" class="uk-input form-field"/> 
							</div>

							<div class="uk-margin-small">
								History Id:<input value="" type="text" name="historyId" id="historyId" class="uk-input form-field"/>
							</div>

							<div class="uk-margin-small">
								Date:<input value="" type="text" name="dated" id="dated" class="wtDateClass form-field uk-input"/>
							</div>

							<div class="uk-margin-small ">
								Total amount:<input value="" type="text" name="total_amount" id="total_amount" class="uk-input form-field"/>
							</div>
							<div class="uk-margin-small">
								Payment status:<select name="payment_status" id="payment_status" class="uk-select form-field" ><option value="">Select Payment status</option>	<? 
								$os->onlyOption($os->paymentStatus);	?></select>
							</div>
							<div class="uk-card-footer  uk-text-center">
								<? if($os->access('wtEdit')){ ?><input type="submit" value="Save" class="uk-button-primary uk-width-expand" style="cursor: pointer;" /><? } ?>	                   
							</div>
						</div>
						<div>
							<div class="uk-margin-small">
								From date:<input value="" type="text" name="from_date" id="from_date" class="wtDateClass form-field uk-input"/> 
							</div>


							<div class="uk-margin-small ">
								To date:<input value="" type="text" name="to_date" id="to_date" class="wtDateClass form-field uk-input"/>
							</div>
							<div class="uk-margin-small uk-hidden">
								Month count:<input value="" type="text" name="month_count" id="month_count" class="uk-input form-field"/>
							</div>
							<div class="uk-margin-small uk-hidden">
								Months:<input value="" type="text" name="months" id="months" class="uk-input form-field"/>
							</div>
							<div class="uk-margin-small ">
								Pyment details:<textarea  name="pyment_details" id="pyment_details" class="uk-textarea form-field"></textarea>
							</div>
							<div class="uk-margin-small uk-hidden">
								Year:<input value="" type="text" name="year" id="year" class="uk-input form-field"/>
							</div>
							<div class="uk-margin-small uk-hidden">
								<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
								<input type="hidden"  id="WT_subscriptionpagingPageno" value="1" />	
								<input type="text"  id="subscription_id" value="0" />
							</div>
						</div>

						
					</div>
				</div>
			</form> 

		</div>
	</div>
</div>		


<table style="width:100%;" class="ajaxViewMainTable">
	<tr>
		<td valign="top" class="ajaxViewMainTableTDList">
			<div class="ajaxViewMainTableTDListSearch">
				<input type="text" id="searchKey" class="textbox fWidth uk-input" style="width: 190px;" placeholder="Search Key" />&nbsp;
				<input type="text" id="mobile_student" class="textbox fWidth uk-input" style="width: 190px;" placeholder="Mobile No" />&nbsp;
				<input type="text" id="name" class="textbox fWidth uk-input" style="width: 190px;" placeholder="Name" />&nbsp;
				

				<select name="payment_status" id="payment_status_s" class="uk-select textbox fWidth" style="width: 190px;"><option value="">Select Payment status</option>	<? 
				$os->onlyOption($os->paymentStatus);	?></select>&nbsp;&nbsp;
				<input type="button" class="uk-button uk-button-primary uk-button-small" value="Search" onclick="WT_subscriptionListing();" style="cursor:pointer;"/>&nbsp;
				<input type="button" class="uk-button uk-button-secondary uk-button-small" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>&nbsp;
				<input type="button" value="Add Subscription" onclick="formReset();" style="cursor:pointer;background-color: #0da50b" class="uk-button uk-button-secondary uk-button-small"  />
			</div>
			<div  class="ajaxViewMainTableTDListData" id="WT_subscriptionListDiv">&nbsp; </div>
		&nbsp;</td>
	</tr>
</table>

<script>
	function formReset(){   
		$('#subs_form')[0].reset();
		$('#subscription_title').html('New Subscription');
		UIkit.modal('#form_modal').show();
	}

	function show_subscription_details(subscription_id){
		var formdata = new FormData();
		formdata.append('subscription_id',subscription_id);
		var url='<? echo $ajaxFilePath ?>?show_subscription_details=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
		os.setAjaxHtml('sub_details_div',url,formdata);
		UIkit.modal('#subscription_details_modal').show();
	}

	function WT_subscriptionListing(){
		var formdata = new FormData();
		formdata.append('searchKey',os.getVal('searchKey') );
		formdata.append('mobile_student',os.getVal('mobile_student'));
		formdata.append('name',os.getVal('name'));
		formdata.append('payment_status_s',os.getVal('payment_status_s'));

		formdata.append('showPerPage',os.getVal('showPerPage') );
		var WT_subscriptionpagingPageno=os.getVal('WT_subscriptionpagingPageno');
		var url='wtpage='+WT_subscriptionpagingPageno;
		url='<? echo $ajaxFilePath ?>?WT_subscriptionListing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_subscriptionListDiv',url,formdata);

	}

	WT_subscriptionListing();
	function  searchReset(){
		os.setVal('payment_status_s',''); 
		os.setVal('searchKey','');

		os.setVal('mobile_student',''); 
		os.setVal('name','');
		WT_subscriptionListing();	

	}


function WT_subscriptionEditAndSave()  // collect data and send to save
{

	var formdata = new FormData();
	var studentIdVal= os.getVal('studentId'); 
	var historyIdVal= os.getVal('historyId'); 
	var datedVal= os.getVal('dated'); 
	var total_amountVal= os.getVal('total_amount'); 
	var payment_statusVal= os.getVal('payment_status'); 
	var from_dateVal= os.getVal('from_date'); 
	var to_dateVal= os.getVal('to_date'); 
	var month_countVal= os.getVal('month_count'); 
	var monthsVal= os.getVal('months'); 
	var pyment_detailsVal= os.getVal('pyment_details'); 
	var yearVal= os.getVal('year'); 


	formdata.append('studentId',studentIdVal );
	formdata.append('historyId',historyIdVal );
	formdata.append('dated',datedVal );
	formdata.append('total_amount',total_amountVal );
	formdata.append('payment_status',payment_statusVal );
	formdata.append('from_date',from_dateVal );
	formdata.append('to_date',to_dateVal );
	formdata.append('month_count',month_countVal );
	formdata.append('months',monthsVal );
	formdata.append('pyment_details',pyment_detailsVal );
	formdata.append('year',yearVal );

	
	if(os.check.empty('studentId','Please Add Student Id')==false){ return false;} 
	if(os.check.empty('historyId','Please Add History Id')==false){ return false;} 
	if(os.check.empty('dated','Please Add Date')==false){ return false;} 

	var   subscription_id=os.getVal('subscription_id');
	formdata.append('subscription_id',subscription_id );
	var url='<? echo $ajaxFilePath ?>?WT_subscriptionEditAndSave=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_subscriptionReLoadList',url,formdata);

}	

function WT_subscriptionReLoadList(data){	
	var d=data.split('#-#');
	var subscription_id=parseInt(d[0]);
	if(d[0]!='Error' && subscription_id>0)
	{
		os.setVal('subscription_id',subscription_id);
	}
	
	if(d[1]!=''){alert(d[1]);}
	WT_subscriptionListing();
}

function WT_subscriptionGetById(subscription_id) // get record by table primery id
{
	var formdata = new FormData();	 
	formdata.append('subscription_id',subscription_id );
	var url='<? echo $ajaxFilePath ?>?WT_subscriptionGetById=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
	os.setAjaxFunc('WT_subscriptionFillData',url,formdata);

}

function WT_subscriptionFillData(data){
	var objJSON = JSON.parse(data);
	os.setVal('subscription_id',parseInt(objJSON.subscription_id));	
	os.setVal('studentId',objJSON.studentId); 
	os.setVal('historyId',objJSON.historyId); 
	os.setVal('dated',objJSON.dated); 
	os.setVal('total_amount',objJSON.total_amount); 
	os.setVal('payment_status',objJSON.payment_status); 
	os.setVal('from_date',objJSON.from_date); 
	os.setVal('to_date',objJSON.to_date); 
	os.setVal('month_count',objJSON.month_count); 
	os.setVal('months',objJSON.months); 
	os.setVal('pyment_details',objJSON.pyment_details); 
	os.setVal('year',objJSON.year); 

	$('#subscription_title').html("Edit Subscription")   
	UIkit.modal('#form_modal').show();


}

function WT_subscriptionDeleteRowById(subscription_id) // delete record by table id
{
	var formdata = new FormData();	 
	if(parseInt(subscription_id)<1 || subscription_id==''){  
		var  subscription_id =os.getVal('subscription_id');
	}
	
	if(parseInt(subscription_id)<1){ alert('No record Selected'); return;}
	
	var p =confirm('Are you Sure? You want to delete this record forever.')
	if(p){

		formdata.append('subscription_id',subscription_id );

		var url='<? echo $ajaxFilePath ?>?WT_subscriptionDeleteRowById=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_subscriptionDeleteRowByIdResults',url,formdata);
	}


}
function WT_subscriptionDeleteRowByIdResults(data)
{
	alert(data);
	WT_subscriptionListing();
} 

function wtAjaxPagination(pageId,pageNo)// pagination function
{
	os.setVal('WT_subscriptionpagingPageno',parseInt(pageNo));
	WT_subscriptionListing();
}






</script>




<? include($site['root-wtos'].'bottom.php'); ?>