<?
session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?><?

if($os->get('subscription_structure_Listing')=='OK'){
	$where='';
	$andasession=  $os->postAndQuery('asession_s','ss.asession','=');
	$andclass=  $os->postAndQuery('class_s','ss.classId','=');
	$listingQuery="select  ss.*, s.subscription_id ,s.online_class as is_online_class, s.online_exam as is_online_exam from subscription_structure ss
	LEFT JOIN subscription s ON s.studentId='{$os->post('studentId')}' AND  s.subscription_structure_id=ss.subscription_structure_id
	where ss.subscription_structure_id>0 and ss.active_status='active' $andasession $andclass  order by ss.classId ASC";
	$listingMq=$os->mq($listingQuery);	
	$asession_val=$os->post('asession_s');
	$subscription_date_a=$os->subscription_date($asession_val);
	$subscription_from_date_a=$subscription_date_a['from_date'];
	$subscription_to_date_a=$subscription_date_a['to_date'];
	$subscription_data_a= array();
	while($record=$os->mfa($listingMq)){ 
		$subscription_data_a[]=$record;
	}
	// _d($subscription_data_a);
	if(count($subscription_data_a)>0){
		?>
		<div class="listingRecords">
			<form onsubmit="event.preventDefault(); add_subscription(this);" id="add_subscription_form">	<div class="uk-margin-large">
				<div>
					<div class="uk-child-width-1-2@m uk-child-width-1-2@s uk-grid-match" uk-grid>
						<?
						foreach ($subscription_data_a as $sub_str_data) {
							$is_subscribed = $sub_str_data["subscription_id"]>0;
							$price = 0;
							$price=$sub_str_data['online_class']+$sub_str_data['online_exam'];
							?>
							<div>
								<div class="uk-card uk-card-default border-radius-m uk-position-relative">

									<div class="uk-card-body uk-text-center uk-background-muted">
										<h4 class="uk-text-primary"><?= $sub_str_data['title']?></h4>
										<?
										if($is_subscribed){
											?>
											<div class="uk-position-absolute uk-position-top-right  uk-label-success uk-text-small p-xs p-left-m p-right-m" style="top: 10px; border-radius: 20px 0 0 20px">Subscribed <i uk-icon="check"></i></div>
											<div class="uk-grid-small uk-child-width-expand" uk-grid>
												<? if($sub_str_data["is_online_class"]==1){?>
													<div>
														<a class="uk-button uk-button-secondary uk-border-pill uk-width-expand" href="<?= $site["url"]?>e-class?class=<?= $sub_str_data["classId"]?>">Online Class</a>
													</div>
													<?}?>
													<? if($sub_str_data["is_online_exam"]==1){?>
														<div>
															<a class="uk-button uk-button-secondary uk-border-pill uk-width-expand" href="<?= $site["url"]?>OnlineExam">Online Exam</a>
														</div>
														<?}?>
													</div>
													<?} else {?>

														<?if($sub_str_data['is_full_package']==1){?> 

															<button class="uk-button uk-button-primary uk-margin-small-bottom uk-border-pill uk-width-expand " onclick="
															$('#total_amount').val('<?= $price?>')
															$('#type').val('full_package')"
															type="submit"

															>Full Package ( ₹<?= $price?> )  Subscribe Now</button>
															<?}?>
															<?if($sub_str_data['is_exam_only']==1){?>
																<button class="uk-button uk-button-primary uk-border-pill uk-width-expand uk-margin-small-bottom " onclick="$('#total_amount').val('<?= $sub_str_data['online_exam']?>')
																$('#type').val('only_exam')" type="submit">Only Exam ( ₹<?= $sub_str_data['online_exam']?> ) Subscribe Now</button>
																<?}?>

																<div class="uk-margin">
																	<?$loginKey=$site['loginKey'];?>
																	<input type="hidden"  id="studentId" value="<?echo isset($_SESSION['registration_studentId'])?$_SESSION['registration_studentId']:$_SESSION[$loginKey]['logedUser']['studentId'];?>" />
																	<input type="hidden"  id="total_amount" value="" />
																	<input type="hidden"  id="type" value="" />								
																	<input type="hidden"  id="subscription_structure_id" value="<?=$sub_str_data['subscription_structure_id']?>" />
																</div>
																<?}?>

															</div>
														</div>
													</div>
													<?}?>
												</div>
											</div>
										</div>
									</form>
								</div>
								<br />					
							<?php }
							else{?>								
								<h4 class="uk-text-danger uk-text-capitalize uk-text-bold uk-text-center">Sorry ! no data available at the moments.</h4>
								<?}?>
								<div class="uk-card-body uk-text-center">								
									<a class="uk-button uk-button-<?=count($subscription_data_a)>0?'danger':'primary'?> uk-border-pill uk-width-medium" href="<?=$site['url']?>myprofile" >Back To My Profile</a>
								</div>	
								<?

								exit();}

								if($os->get('add_subscription')=='OK'){
									$studentId=$os->post("studentId");
									$get_historyId=$os->rowByField('historyId','history','studentId',$studentId,$where="and asession='".$os->post('asession')."'",$orderby='');
									$and_history_id=$get_historyId>0?"and historyId='$get_historyId'":'';
									$subscription_id=$get_historyId>0?$os->rowByField('subscription_id','subscription','studentId',$studentId,$where=" $and_history_id  ",$orderby=''):0;
									if($subscription_id>0){
										echo $mgs="Error#-#You have already added ".$os->post('asession')." subscription.Please visit my subscription.";
										return;
									}
			// //History Add Section//
									$dataToSave["studentId"] = addslashes($os->post("studentId"));
									$dataToSave['asession']=addslashes($os->post('asession'));
									$classId=$dataToSave['class']=addslashes($os->post('classId'));
									$dataToSave['branch_code']=addslashes($os->post('branch_code'));			
									$dataToSave['addedDate']=$os->now();
									$historyId=$get_historyId>0?$get_historyId:$os->save("history", $dataToSave);
			// //End History Add Section//

			// //Subscription Add Section//

									$sub_str_a=$os->rowByField('','subscription_structure','subscription_structure_id',$os->post('subscription_structure_id'));
									$dataToSave2["sub_str_details"] = addslashes(json_encode($sub_str_a));
									$dataToSave2["studentId"] = addslashes($os->post("studentId"));
									$dataToSave2["subscription_structure_id"] = addslashes($os->post('subscription_structure_id'));
									$type=$os->post('type');
									$dataToSave2["online_class"] = addslashes($type=='full_package'?1:0);
									$dataToSave2["online_exam"] = addslashes(($type=='full_package'||$type=='only_exam')?1:0);

									$dataToSave2['historyId']=addslashes($historyId);
									$dataToSave2['dated']=$os->now();			
									$dataToSave2['total_amount']=addslashes($os->post('total_amount'));
									$dataToSave2['addedDate']=$os->now();
									$subscription_id=$os->save("subscription", $dataToSave2);			
									if($historyId>0&&$subscription_id>0){
										$mgs= "Record added successfully."; 
										$mgs=$subscription_id."#-#".$mgs;
										$_SESSION['paytm']['subscription_id']=$subscription_id;
										$_SESSION['paytm']['studentId']=$studentId;
										$_SESSION['paytm']['historyId']=$historyId;
									}
									else{
										$mgs="Error#-#Problem Saving Data.";
									}
									echo $mgs;
									exit();
								}
