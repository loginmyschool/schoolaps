<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Subscription Structure Entry';
$ajaxFilePath= 'subscription_structureAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>


<table class="container">
	<tr>
		
		<td  class="middle" style="padding-left:5px;">
			
			
			<div class="listHeader"> <?php  echo $listHeader; ?>  </div>
			
			<!--  ggggggggggggggg   -->
			
			
			<table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
				
				<tr>
					
					<td valign="top" class="ajaxViewMainTableTDList">						
						<div class="ajaxViewMainTableTDListSearch" style="display:flex;justify-content: center;">
							<!-- Session: -->
							<select name="asession" id="asession_s" class=" uk-select textbox fWidth" >
								<option value="">Select Session</option>
								<? $os->onlyOption($os->asession);	?>
							</select>	
							<!-- Class: -->
							<select name="class" id="class_s" class="uk-select textbox fWidth" >
								<option value="">Select Class</option>								
								<?$os->onlyOption($os->classList);?>
							</select>
							<!-- Status: -->
							<select name="active_status" id="active_status" class="uk-select textbox fWidth" >
								<option value="">Select Status</option>
								<?$os->onlyOption($os->activeStatus);?>
							</select>
							<!-- Is Featured: -->
							<select name="is_featured" id="is_featured" class="uk-select textbox fWidth" >
								<option value="">Select Is Featured</option>
								<?$os->onlyOption($os->yesno);?>
							</select>	
							<input type="button" class="search_btn" value="Search" onclick="subscription_structure_Listing();" style="background-color:green;"/>
							<input type="button" class="search_btn" value="Reset" onclick="searchReset();" style="background-color:red;"/>
							<input type="button" class="search_btn" value="Add Subscription Structure" onclick="formReset();" style="background-color:blue;"/>							
						</div>
						<div  class="ajaxViewMainTableTDListData" id="WT_subscription_structure_list_div">&nbsp; </div>
					&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<style type="text/css">
	.search_btn{
		cursor:pointer;color:white;color:white;font-weight: bold;border:none;
		margin: 0px 6px;
	}
</style>

<!-- Form modal -->
<style type="text/css">
	.uk-modal-container .uk-modal-dialog {
		width: 800px;
	}
</style>
<div id="form_modal" class="uk-modal-container" uk-modal>
	<div class="uk-modal-dialog uk-width-body">
		<button class="uk-modal-close-default uk-text-danger" type="button" uk-close></button>
		<div class="uk-card uk-card-default uk-card-small">
			<!--gg-->
			<div class="uk-card-header">
				<h4 id="booking_title" class="uk-text-large uk-text-italic" style="color:green;font-weight: bold;text-align: center;">New Subscription Structure</h4>
			</div>
			<form   onsubmit="event.preventDefault(); WT_subscription_structure_EditAndSave(this);" id="admin_reg_form">
				<div class="uk-card-body">
					<div class="uk-child-width-1-3@m" uk-grid>
						<div>	
							<div class="uk-margin-small">
								Title:<label class="uk-text-danger  uk-text-bold">*</label>
								<input value="" type="text" name="title" id="title" class="uk-input form-field" required/>
							</div>
							

							<div class="uk-margin-small">
								<input type="checkbox" id="has_online_class" name="has_online_class" value="">&nbsp;&nbsp;Online Class:<label class="uk-text-danger  uk-text-bold">*</label>
								<input value="" type="text" name="online_class" id="online_class" class="uk-input form-field" required onblur="set_full_package_amt();" onkeyup="set_full_package_amt();"/>
							</div>
							<script type="text/javascript">
								const set_full_package_amt=()=>{
									var online_class_val = !isNaN(parseInt($("#online_class").val()))?parseInt($("#online_class").val()):0;
									var online_exam_val = !isNaN(parseInt($("#online_exam").val()))?parseInt($("#online_exam").val()):0;
									var full_package_amt_val=online_class_val+online_exam_val;
									$('#online_exam_amt').val(online_exam_val);
									$('#full_package_amt').val(full_package_amt_val);
									
									var full_package_discount_val = !isNaN(parseInt($("#full_package_discount").val()))?parseInt($("#full_package_discount").val()):0;
									var online_exam_discount_val = !isNaN(parseInt($("#online_exam_discount").val()))?parseInt($("#online_exam_discount").val()):0;
									$('#full_package_after_discount').html(full_package_amt_val-full_package_discount_val);
									$('#online_exam_after_discount').html(online_exam_val-online_exam_discount_val);

								}
							</script>
							<div class="uk-margin-small ">
								<input type="checkbox" id="is_full_package" name="is_full_package" value="">&nbsp;&nbsp;<span class="uk-text-small uk-text-bold uk-text-danger">FULL PACKAGE (ONLINE CLASS + ONLINE EXAM)</span>
								<table class="uk-width-1-1" style="border-collapse: collapse">
									<tfoot>
										<tr>
											<td>Amount	<input value="" type="text" name="full_package_amt" id="full_package_amt" class="uk-input  form-field" readonly/>
											</td>
										</tr>
										<tr>
											<td>Discount:<input value="" type="text" name="full_package_discount" id="full_package_discount" class="uk-input form-field" onblur="set_full_package_amt();" onkeyup="set_full_package_amt();"/>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="uk-margin-small">Total :<span id="full_package_after_discount" class="uk-text uk-text-primary uk-text-bold"></span></div>
							
							<div class="uk-card-footer  uk-text-center">
								<? if($os->access('wtEdit')){ ?><input type="submit" value="Save" class=" uk-button-primary" style="width: 150px; cursor: pointer;" /><? } ?>		                   
							</div>
							<div class="uk-margin-small uk-hidden">
								<input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
								<input type="hidden"  id="WT_subscription_structure_Pageno" value="1" />
								<input  type="text" name="subscription_structure_id" id="subscription_structure_id" value="0"/>
							</div>
						</div>
						<div>
							<div class="uk-margin-small">
								Class:<label class="uk-text-danger  uk-text-bold">*</label>
								<select name="classId" id="classId" class="uk-select form-field" required >
									<option value=""></option>
									<?$os->onlyOption($os->classList);?>
								</select>
							</div>
							<div class="uk-margin-small">
								<input type="checkbox" id="has_online_exam" name="has_online_exam" value="">&nbsp;&nbsp;Online Exam:<label class="uk-text-danger  uk-text-bold">*</label>
								<input value="" type="text" name="online_exam" id="online_exam" class="uk-input form-field" required onblur="set_full_package_amt();" onkeyup="set_full_package_amt();"/>
							</div>
							<div class="uk-margin-small">
								<input type="checkbox" id="is_exam_only" name="is_exam_only" value="">&nbsp;&nbsp;<span class="uk-text-small uk-text-bold uk-text-danger">EXAM ONLY</span>
								<div class="uk-margin"></div>									
								<table class="uk-width-1-1" style="border-collapse: collapse">
									<tfoot>
										<tr>
											<td>
												Amount	<input value="" type="text" name="online_exam_amt" id="online_exam_amt" class="uk-input  form-field" readonly/>
											</td>
										</tr>
										<tr>
											<td>
												Discount	<input value="" type="text" name="online_exam_discount" id="online_exam_discount" class="uk-input form-field" onblur="set_full_package_amt();" onkeyup="set_full_package_amt();"/> 
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="uk-margin-small">Total :<span id="online_exam_after_discount" class="uk-text uk-text-primary uk-text-bold"></span></div>
							
						</div>
						<div>
							<div class="uk-margin-small">
								Session:<label class="uk-text-danger  uk-text-bold">*</label>
								<select name="asession" id="asession" class="uk-select form-field" required>
									<option value=""></option>
									<? $os->onlyOption($os->asession);	?>
								</select>
							</div>

						</div>

						<div class="uk-hidden"> 							
							<div class="uk-margin-small uk-hidden">
								Discount Form Date:<input value="" type="date" name="discount_form_date" id="discount_form_date" class="wtDateClass form-field uk-input"/> 
							</div>
							<div class="uk-margin-small uk-hidden">
								Discount To Date:<input value="" type="date" name="discount_to_date" id="discount_to_date" class="wtDateClass form-field uk-input"/> 
							</div>
							<div class="uk-margin-small uk-hidden">
								Discount Text:
								<textarea name="discount_text" id="discount_text" class="uk-textarea form-field" rows="5"></textarea>
							</div>
						</div>



					</div>
				</div>   

			</form>   

		</div>
	</div>
</div>




<script>
	// UIkit.modal('#form_modal').show();
	function WT_subscription_structureGetById(subscription_structure_id){
		var formdata = new FormData();	 
		formdata.append('subscription_structure_id',subscription_structure_id );
		var url='<? echo $ajaxFilePath ?>?WT_subscription_structureGetById=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('WT_FillData',url,formdata);				
	}

	function WT_FillData(data){
		var objJSON = JSON.parse(data);
		os.setVal('subscription_structure_id',parseInt(objJSON.subscription_structure_id));
		os.setVal('classId',objJSON.classId); 
		os.setVal('title',objJSON.title); 
		os.setVal('asession',objJSON.asession); 
		os.setVal('online_class',objJSON.online_class); 
		os.setVal('online_exam',objJSON.online_exam);
		os.setVal('full_package_discount',objJSON.full_package_discount); 
		os.setVal('online_exam_discount',objJSON.online_exam_discount); 
		os.setVal('discount_form_date',objJSON.discount_form_date); 
		os.setVal('discount_to_date',objJSON.discount_to_date);
		os.setVal('discount_text',objJSON.discount_text);
		(objJSON.has_online_class>0)?$('#has_online_class').prop('checked', true):$('#has_online_class').prop('checked', false);
		(objJSON.has_online_exam>0)?$("#has_online_exam").prop('checked', true):$("#has_online_exam").prop('checked', false);

		(objJSON.is_full_package>0)?$('#is_full_package').prop('checked', true):$('#is_full_package').prop('checked', false);
		(objJSON.is_exam_only>0)?$("#is_exam_only").prop('checked', true):$("#is_exam_only").prop('checked', false);

		$('#full_package_amt').val(parseInt(objJSON.online_exam)+parseInt(objJSON.online_class));		
		$('#online_exam_amt').val(objJSON.online_exam);
		$('#full_package_after_discount').html(parseInt(objJSON.online_exam)+parseInt(objJSON.online_class)-parseInt(objJSON.full_package_discount));
		$('#online_exam_after_discount').html(parseInt(objJSON.online_exam)-parseInt(objJSON.online_exam_discount));


		$('#booking_title').html("Edit Subscription Structure")   
		UIkit.modal('#form_modal').show();
	}

	function formReset(){  
		$('#booking_title').html("New Subscription Structure")  
		$("form")[0].reset();
		$('#full_package_after_discount').html('');
		$('#online_exam_after_discount').html('');
		UIkit.modal('#form_modal').show();
	}
	function WT_bookingDeleteRowById(subscription_structure_id){
		var formdata = new FormData();	 
		if(parseInt(subscription_structure_id)<1 || subscription_structure_id==''){  
			var  subscription_structure_id =os.getVal('subscription_structure_id');
		}		
		if(parseInt(subscription_structure_id)<1){ alert('No record Selected'); return;}
		var p =confirm('Are you Sure? You want to delete this record forever.')
		if(p){
			formdata.append('subscription_structure_id',subscription_structure_id );
			var url='<? echo $ajaxFilePath ?>?WT_bookingDeleteRowById=OK&';
			os.animateMe.div='div_busy';
			os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
			os.setAjaxFunc('WT_bookingDeleteRowByIdResults',url,formdata);
		}


	}
	function WT_bookingDeleteRowByIdResults(data){
		alert(data);
		subscription_structure_Listing();
	} 



	function WT_subscription_structure_EditAndSave(form){       
		var formdata = new FormData(form);
		$("#has_online_class").prop('checked')?formdata.append('has_online_class',1):formdata.append('has_online_class',0);
		$("#has_online_exam").prop('checked')?formdata.append('has_online_exam',1):formdata.append('has_online_exam',0);

		$("#is_full_package").prop('checked')?formdata.append('is_full_package',1):formdata.append('is_full_package',0);
		$("#is_exam_only").prop('checked')?formdata.append('is_exam_only',1):formdata.append('is_exam_only',0);

		

		var   subscription_structure_id=os.getVal('subscription_structure_id');
		formdata.append('subscription_structure_id',subscription_structure_id );
		var url='<? echo $ajaxFilePath ?>?WT_subscription_structure_EditAndSave=OK&';
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxFunc('subscription_structure_reload_list',url,formdata);
	}	

	function subscription_structure_reload_list(data){
		// console.log(data);return false;
		var d=data.split('#-#');
		var subscription_structure_id=parseInt(d[0]);
		if(d[0]!='Error' && subscription_structure_id>0)
		{
			os.setVal('subscription_structure_id',subscription_structure_id);
		}

		if(d[1]!=''){alert(d[1]);}
		subscription_structure_Listing();
		formReset();
	}


	function subscription_structure_Listing(){
		var formdata = new FormData();
		formdata.append('asession_s',os.getVal('asession_s'));
		formdata.append('class_s',os.getVal('class_s'));
		formdata.append('active_status',os.getVal('active_status'));
		formdata.append('is_featured',os.getVal('is_featured'));
		var WT_subscription_structure_Pageno=os.getVal('WT_subscription_structure_Pageno');
		console.log(WT_subscription_structure_Pageno);
		var url='wtpage='+WT_subscription_structure_Pageno;
		url='<? echo $ajaxFilePath ?>?subscription_structure_Listing=OK&'+url;
		os.animateMe.div='div_busy';
		os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';	
		os.setAjaxHtml('WT_subscription_structure_list_div',url,formdata);
	}
	subscription_structure_Listing();
	function  searchReset(){
		os.setVal('asession_s',''); 
		os.setVal('class_s','');
		os.setVal('active_status',''); 
		os.setVal('is_featured','');
		subscription_structure_Listing(); 
	}
	function wtAjaxPagination(pageId,pageNo){
		os.setVal('WT_subscription_structure_Pageno',parseInt(pageNo));
		subscription_structure_Listing();
	}
</script>
<? include($site['root-wtos'].'bottom.php'); ?>