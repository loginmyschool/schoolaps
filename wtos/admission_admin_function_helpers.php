<?

/*

   # wtos version : 1.1

   #
   #

*/global $os,$site;
 function createFeesRecord_donation($studentId,$historyId) //
  {


		global $os,$site;
		$history= $os->rowByField('','history',$fld='studentId',$studentId,$where=" and historyId='$historyId' ",$orderby='');
		$donation=$history['donation'];
		if(!$donation){ return false;}

		$classId=$history['class'];
		$accademicsessionId=$history['asession'];
		$month=date('m');
		$year=date('Y');
		$dueDate='';

		$donation_installment=$history['donation_installment'];
		$totalPayble=$donation;
		$dataToSave=array();
		$dataToSave['studentId']=$studentId;
		$dataToSave['feesType']='Donation';
		$dataToSave['accademicsessionId']=$accademicsessionId;
		$dataToSave['classId']=$classId;
		$dataToSave['month']=$month;
		$dataToSave['year']=$year;
		$dataToSave['historyId']=$historyId;
		$dataToSave['feesdata']='installment '.$donation_installment;
		$dataToSave['dueDate']=$dueDate;
		$dataToSave['amount']=$donation;
		$dataToSave['vehicle']=0; // it is for only monthly record
		$dataToSave['fine']=0; // fine will be calculated
		$dataToSave['discountType']=''; // percent,flat
		$dataToSave['discountValue']='';
		$dataToSave['discountAmount']='';
		$dataToSave['totalPayble']=$totalPayble;
		$dataToSave['paymentStatus']='unpaid';
		$dataToSave['note']='installment count:'.$donation_installment;
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$fees_student_id=$os->save('fees_student',$dataToSave,'fees_student_id','');
		$fees_student_id_array[$fees_student_id]=$fees_student_id;
		return $fees_student_id_array;

  }

 function createPayment_donation($fees_student_id_array,$historyId,$studentId,$paid_amount,$payment_note='') ///
   {
   		global $os;
		if(!$paid_amount)
		{
		  return false;
		}

		$history= $os->rowByField('','history',$fld='studentId',$studentId,$where=" and historyId='$historyId' ",$orderby='');
		$classId=$history['class'];
		$accademicsessionId=$history['asession'];
		$admission_date=$history['asession'];
		$fees_months=$os->now();
		$fees_student_Ids=implode(',',$fees_student_id_array);

		$dataToSave['studentId']=$studentId;
		$dataToSave['historyId']=$historyId;
		$dataToSave['accademicsessionId']=$accademicsessionId;
		$dataToSave['classId']=$classId;
		$dataToSave['paidDate']=$os->now();
		$dataToSave['paidAmount']=$paid_amount;
		$dataToSave['paybleAmount']=$paybleAmount;
		$dataToSave['paidBy']=$os->userDetails['adminId'];
		$dataToSave['paymentNote']=$payment_note;
		$dataToSave['payment_options']='';
		$dataToSave['fees_student_Ids']=$fees_student_Ids;
		$dataToSave['fees_months']=$fees_months;
		$dataToSave['prevDueAmount']='';
		$dataToSave['currentDueAmount']='';
		$dataToSave['remarks']='';
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$dataToSave['addedDate']=$os->now();

		$receipt_no=$os->generateNewReceiptNo();
		$dataToSave['receipt_no']=$receipt_no;


		$fees_payment_id=$os->save('fees_payment',$dataToSave,'fees_payment_id','');

	   if($fees_payment_id)
	   {

		   $update_fees_student=" update fees_student set fees_payment_id='$fees_payment_id' , receipt_no='$receipt_no' ,paymentStatus='paid' where  fees_student_id IN($fees_student_Ids) " ;
		   $os->mq($update_fees_student);

	   }


	   $return['fees_payment_id']=$fees_payment_id;
	   $return['receipt_no']=$receipt_no;
	   $return['paidDate']=$dataToSave['paidDate'];
	   $return['paidAmount']=$paid_amount;
	   $return['fees_student_id_array_str']=implode(',',$fees_student_id_array);


	   return $return;


   }
function form_admission($asession,$classList_s)
{
  global $os,$site;
 // type of student //
 $vehicle_type_arr=array();
$student_type_arr=array();
$classId=$classList_s;
$accademicsessionId=$asession;
$student_type_q= "SELECT distinct(student_type) FROM `feesconfig` where classId='$classId' and  accademicsessionId='$accademicsessionId' ";
$student_type_rs=$os->mq($student_type_q);
while($recordtype=$os->mfa( $student_type_rs))
{
  $student_type_arr[$recordtype['student_type']]=$recordtype['student_type'];
}


$vehicle_type_q= "SELECT distinct(vehicle_type) FROM `vehicle_config` where class_id='$classId' and  asession='$accademicsessionId' ";
$vehicle_type_rs=$os->mq($vehicle_type_q);
while($recordtype=$os->mfa( $vehicle_type_rs))
{
  $vehicle_type_arr[$recordtype['vehicle_type']]=$recordtype['vehicle_type'];
}
// vehicle_type //  vehicle_distance / vehicle_price
?>
    <div style="position: sticky; top: 0; z-index: 2" class="p-s background-color-white border-none border-bottom-xxs border-color-light-grey">
        <div class="grid">
            <div class="grid-item p-s">
                <h1 >
                    <input readonly onclick="open_editor_tooltip(this)" style="font-size:24px" value="Nafish Ahmedss" type="text" name="name" id="name" class="border-none font-weight-xxl color-primary full-width" />
                </h1>
                <p >
                    Session : <? echo $asession;?>
                </p>
            </div>

            <div class="p-s grid-item" style="max-width: 170px;display:flex; align-items: center; justify-content: flex-end">
            <button type="button" class="material-button" onclick="step2();">
                <span>PAYMENT DETAILS</span>
                <i class="la la-arrow-right"></i>
            </button>
            </div>
        </div>
    </div>

    <div class=" ">
        <div class="grid p-s">
            <div class="grid-item p-m" style="max-width: 205px">
                <div class="dp-selecter">
                    <div style="position:relative; border-radius:100%; width: 185px; height: 185px; background-color: rgba(0,0,255,0.3); background-position: center; background-repeat: no-repeat; background-image: url('<?php echo $site['url-wtos'] ?>images/student_img.png')" id="imageView">
                        <input type="file" name="image" value=""  id="image" onchange="image_set_background_from_input(this, '#imageView')//os.readURL(this,'imagePreview') " style="display:none;"/>

                        <div class="p-m border-radius-xxxl" style="position:absolute; bottom: 10px; right: 10px; background-color: rgba(0,0,0,0.5)">
                            <i style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');" class="mi text-xl">camera_alt</i>
                        </div>

                    </div>

                </div>
            </div>
            <div class="grid-item p-s">
                <div class="p-s">
                    <h3 class="p-m">Academic Information e</h3>
                    <table style="border-collapse: collapse;" class="border-less-input-table">
                        <tr>
                            <td class="p-s p-left-m">Session</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="asession" id="asession" class="border-none font-weight-xxl" >
                                    <option value=""></option>
                                    <? $os->onlyOption($os->asession,$asession);	?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="p-s p-left-m">Class</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="class" id="class" class="font-weight-xxl">
                                    <option value="">Select Class</option>
                                    <? $os->onlyOption($os->classList,$classList_s);	?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="p-s p-left-m color-deep-grey">Section</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="section" id="section" class="font-weight-xxl">
                                    <option value=""></option>
                                    <? $os->onlyOption($os->section);	?>
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td class="p-s p-left-m">Stream</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="stream" id="stream" class="border-none font-weight-xxl">
                                    <option value=""> </option>
                                    <?  $os->onlyOption($os->stream);	?>
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td class="p-s p-left-m">Roll</td>
                            <td class="p-s ">
                                <input value="" type="text" name="roll_no" id="roll_no" class="border-none font-weight-xxl full-width"/>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#roll_no')">edit</i>
                            </td>
                        </tr>


                        <tr>
                            <td class="p-s p-left-m">Date</td>
                            <td class="p-s">
                                <span style="width: 60px">
                                    <input value="<? echo date("d-m-Y",strtotime($os->now()))?>" type="text" name="admission_date" id="admission_date" class="wtDateClass border-none font-weight-xxl full-width"/>
                                </span>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m  color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#admission_date','date')">edit</i>
                            </td>
                        </tr>
                    </table>
                    <div class="p-m grid-item display-none">
                        <div class="material-input-box ">
                            <select name="board" id="board" style="display:">
                                <option value=""> </option>	<?
                                $os->onlyOption($os->board);	?></select>
                            <div></div>
                            <label>BOARD</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid-item p-s">
                <div class="p-m">
                    <h3 class="p-m">Student Information</h3>
                    <table style="border-collapse: collapse; width: 100%" class="border-less-input-table">
                        <tr>
                            <td class="p-s p-left-m">Gender</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="gender" id="gender" class="border-none font-weight-xxl full-width">
                                    <option value=""> </option>
                                    <? $os->onlyOption($os->gender);	?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Caste</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="caste" id="caste" class="border-none font-weight-xxl full-width">
                                    <option value=""> </option>
                                    <? $os->onlyOption($os->caste);	?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">APL/BPL</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="apl_bpl" id="apl_bpl" class="border-none font-weight-xxl full-width">
                                    <option value=""> </option>
                                    <? $os->onlyOption($os->aplOrBpl);	?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Date of Birth</td>
                            <td class="p-s p-right-m">
                                <input value="" type="text" name="dob" id="dob" class="border-none font-weight-xxl full-width"/>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#dob', 'date')">edit</i>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Aadhaar No.</td>
                            <td class="p-s p-right-m" >
                                <input value="" type="text" name="adhar_no" id="adhar_no" class="border-none font-weight-xxl full-width"/>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#adhar_no')">edit</i>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Contact No.</td>
                            <td class="p-s p-right-m" >
                                <input value="" type="text" name="mobile_student" id="mobile_student" class="border-none font-weight-xxl full-width"/>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#mobile_student')">edit</i>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

            <textarea value="" type="text"   name="remarks" id="remarks" class="display-none" ></textarea>
        </div>

        <div class="grid">
            <div class="p-m grid-item display-none" style="max-width: 130px">
                <div class="material-input-box ">
                    <select name="admissionType" id="admissionType" class="textbox fWidth" >
                        <? $os->onlyOption($os->admissionType);	?>
                    </select>
                    <div></div>
                    <label>Admission Type</label>
                </div>
            </div>

        </div>

        <div class="grid p-s">
            <!--address-->
            <div class="p-m grid-item">
                <h3 class="p-m">Address</h3>
                <table style="border-collapse: collapse; width: 100%" class="border-less-input-table">
                    <tr>
                        <td class="p-s p-left-m">Vill/Street</td>
                        <td class="p-s">
                            <input value="" type="text" name="vill" id="vill"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#vill')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Post</td>
                        <td class="p-s">
                            <input value="" type="text" name="po" id="po"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#po')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Police Station</td>
                        <td class="p-s">
                            <input value="" type="text" name="ps" id="ps"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#ps')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Block</td>
                        <td class="p-s">
                            <input value="" type="text" name="block" id="block"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#block')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">PIN</td>
                        <td class="p-s">
                            <input value="" type="text" name="pin" id="pin"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#pin')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Dist</td>
                        <td class="p-s">
                            <input value="" type="text" name="dist" id="dist"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#dist')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">State</td>
                        <td class="p-s">
                            <input value="WEST BENGAL" type="text" name="state" id="state"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#state')">edit</i>
                        </td>
                    </tr>
                </table>
            </div>
            <!--guardian info-->
            <div class="p-m grid-item">
                <h3 class="p-m">Guardian Information</h3>
                <table style="border-collapse: collapse; width: 100%" class="border-less-input-table">
                    <tr>
                        <td class="p-s p-left-m">Father's Name</td>
                        <td class="p-s">
                            <input value="" type="text" name="father_name" id="father_name"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#father_name')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Mother's Name</td>
                        <td class="p-s">
                            <input value="" type="text" name="mother_name" id="mother_name"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#mother_name')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Guardian Name</td>
                        <td class="p-s">
                            <input value="" type="text" name="guardian_name" id="guardian_name" />
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#guardian_name')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Guardian Occupation</td>
                        <td class="p-s">
                            <input value="" type="text" name="father_ocu" id="father_ocu"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#father_ocu')">edit</i>
                        </td>
                    </tr>
                </table>



            </div>
        </div>


        <div class="grid p-s">
            <div class="grid-item p-m">
                <h3 class="p-m">Vehicle or Hostel Information</h3>
                <div id="hostel_vehicle_details_container">
                    <div class="grid">
                        <div class="p-m grid-item">
                            <div class="material-input-box fill">
                                <select name="student_type" id="student_type" onchange="manage_vehicle_option()" >
                                    <? $os->onlyOption($student_type_arr);	?></select>
                                <div></div>
                                <label>STUDENT TYPE</label>
                            </div>
                        </div>



                    </div>

                    <!--vehicle details-->
                    <div id="vehiclediv">

                        <div class="p-m">
                            <div class="material-checkbox dense">
                                <input value="" type="checkbox" name="vehicle" id="vehicle" onclick="set_vehicle();"/>
                                <label for="vehicle">Please tick to avail vehicle service.</label>
                            </div>
                        </div>




                        <div id="vehicle_data" style="display: none">
                            <div class="">
                                <h3 class="p-m">Vehicle Details</h3>
                            </div>
                            <div class="grid">
                                <div class="grid-item p-m">
                                    <div class="material-input-box fill">
                                        <select name="vehicle_type" id="vehicle_type_id" onchange="ajax_chain('html*vehicle_distance_id*vehicle_config,vehicle_distance,vehicle_distance*asession=asession_s,vehicle_type=vehicle_type_id'); os.setVal('vehicle_price','')"   >
                                            <option value="">
                                            </option>

                                            <?
                                            $os->onlyOption($vehicle_type_arr);	?>
                                        </select>
                                        <div></div>
                                        <label>Vehicle</label>
                                    </div>
                                </div>

                                <div class="grid-item p-m">
                                    <div class="material-input-box fill">
                                        <select name="vehicle_distance" id="vehicle_distance_id" onchange="ajax_chain('text*vehicle_price*vehicle_config,vehicle_price,vehicle_price*asession=asession_s,vehicle_type=vehicle_type_id,vehicle_distance=vehicle_distance_id')"   >

                                            <option value=""></option>
                                        </select>
                                        <div></div>
                                        <label>Distance</label>
                                    </div>
                                </div>
                            </div>
                            <div class="p-m p-top-none text-l">
                                <span class="text-l">Price</span> :
                                <span class="color-flat-green font-weight-xxl">Rs.</span>
                                <input type="text" readonly  name="vehicle_price" id="vehicle_price" style="outline: none;" class="color-flat-green border-none text-l font-weight-xxl"/>
                            </div>
                        </div>
                    </div>

                    <!--hostel details-->
                    <div id="hotel_room_div" style="display:none;">
                        <h3 class="p-m">Hostel Details</h3>
                        <div class="grid">
                            <div class="grid-item p-m">
                                <div class="material-input-box fill">
                                    <input type="text" id="building_name"  />
                                    <div></div>
                                    <label>Building name </label>
                                </div>
                            </div>

                            <div class="grid-item p-m">
                                <div class="material-input-box fill">
                                    <input type="text" id="floor_name"  />
                                    <div></div>
                                    <label>Floor name</label>
                                </div>
                            </div>
                        </div>
                        <div class="grid">
                            <div class="grid-item p-m">
                                <div class="material-input-box fill">
                                    <input type="text" id="room_name"  />
                                    <div></div>
                                    <label>Room Name</label>
                                </div>
                            </div>

                            <div class="grid-item p-m">
                                <div class="material-input-box fill">
                                    <input type="text" id="bed_no"  />
                                    <div></div>
                                    <label>Bed no</label>
                                </div>
                            </div>

                            <div class="grid-item p-m">
                                <div class="material-input-box fill">
                                    <input type="text" id="hostel_room_id"  />
                                    <div></div>
                                    <label>hostel_room_id</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-none">
                        <h3 class="p-m p-bottom-none">Discount</h3>

                        <div class="p-m">
                            <table style="border-collapse: collapse">
                                <tr>
                                    <td>Admission</td>
                                    <td class="p-left-m"><input  type="text" id="discountTypeAdmission" value="RS"  readonly="readonly" class="border-none" style="width: 20px"/></td>
                                    <td class="p-left-m ">
                                        <input type="text" id="discountValueAdmission" value="100"  readonly="readonly" class="border-none color-flat-green"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="p-top-s">Monthly</td>
                                    <td class="p-top-s p-left-m"><input type="text" id="discountTypeMonthly" value="Rs"  readonly="readonly" class="border-none" style="width: 20px"/></td>
                                    <td class="p-top-s p-left-m ">
                                        <input type="text" id="discountValueMonthly" value="120"  readonly="readonly" class="border-none color-flat-green"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
					<div  >
                        <h3 class="p-m p-bottom-none">Donation</h3>

                        <div class="p-m">
                            <table style="border-collapse: collapse">
                                <tr>
                                    <td>Amount</td>
                                    <td class="p-left-m"><input  type="text" id="donation" value="<? echo $os->getVal('donation'); ?>"  readonly="readonly" class="border-none"  /></td>

									</tr>
									 <tr>
                                    <td>Installment count</td>
                                    <td class="p-left-m ">
                                        <input type="text" id="donation_installment" value="<? echo $os->getVal('donation_installment'); ?>"  readonly="readonly" class="border-none color-flat-green"/>
                                    </td>

                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PAYMENT INFO -->

        </div>
        <!--More student-->
        <div class="p-s">
            <div class="background-color-white material-card-layout">

                <div class="material-card-layout-header p-m">
                    <h3 class="p-m" >Additional Details</h3>
                    <ul class="actions">
                        <li class="p-m" onclick="collapse_expand(this, '#more_details_container')">
                            <a><i class="mi">keyboard_arrow_down</i></a>
                        </li>

                    </ul>
                </div>

                <div id="more_details_container" class="material-card-layout-content display-none">


                    <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"  >


                        <tr >
                            <td>Subcast </td>
                            <td>

                                <select name="subcast" id="subcast" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->subcast);	?></select>	 </td>
                        </tr>
                        <tr >
                            <td>Adhar Name </td>
                            <td><input value="" type="text" name="adhar_name" id="adhar_name" class="textboxxx  fWidth "/>
                            </td>
                        </tr>
                        <tr >
                            <td>Adhar Dob </td>
                            <td><input value="" type="text" name="adhar_dob" id="adhar_dob" class="wtDateClass textbox
fWidth"/></td>
                        </tr>






                        <tr >
                            <td>PH </td>
                            <td>

                                <select name="ph" id="ph" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->yesno);	?></select>	 </td>
                        </tr><tr >
                            <td>PH % </td>
                            <td><input value="" type="text" name="ph_percent" id="ph_percent" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Disable </td>
                            <td>

                                <select name="disable" id="disable" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->yesno);	?></select>	 </td>
                        </tr><tr >
                            <td>Disable % </td>
                            <td><input value="" type="text" name="disable_percent" id="disable_percent" class="textboxxx  fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Tc No </td>
                            <td><input value="" type="text" name="tc_no" id="tc_no" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Tc Date </td>
                            <td><input value="" type="text" name="tc_date" id="tc_date" class="wtDateClass textbox fWidth"/></td>
                        </tr>


                        <tr >
                            <td>Full marks </td>
                            <td><input value="" type="text" name="full_marks" id="full_marks" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Obtain marks </td>
                            <td><input value="" type="text" name="obtain_marks" id="obtain_marks" class="textboxxx  fWidth
"/> </td>
                        </tr>

                    </table>
                    <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"   >

                        <tr >
                            <td>Percentage </td>
                            <td><input value="" type="text" name="percentage" id="percentage" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Pass </td>
                            <td>

                                <select name="pass_fail" id="pass_fail" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->pass_fail);	?></select>	 </td>
                        </tr><tr >
                            <td>Grade </td>
                            <td><input value="" type="text" name="grade" id="grade" class="textboxxx  fWidth "/> </td>

                        </tr>




                        <tr >
                            <td>Note </td>
                            <td><textarea  name="studentRemarks" id="studentRemarks" ></textarea></td>

                        </tr>








                        <tr >
                            <td>age </td>
                            <td><input value="" type="text" name="age" id="age" class="textboxxx  fWidth "/>



                            </td>
                        </tr>


                        <tr >
                            <td>Email Student </td>
                            <td><input value="" type="text" name="email_student" id="email_student" class="textboxxx  fWidth
"/> </td>
                        </tr>

                        <tr >
                            <td>Fees Payment </td>
                            <td>
                                <select name="feesPayment" id="feesPayment" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->feesPayment);	?></select>	 </td>
                        </tr>

                        <tr >
                            <td>Religian </td>
                            <td><input value="" type="text" name="religian" id="religian" class="textboxxx  fWidth "/> </td>
                        </tr>




                        <tr style="display:none;">
                            <td>Students </td>
                            <td>
                                <input value="" type="" name="studentId" id="studentId" class="textboxxx  fWidth "/>
                            </td>
                        </tr>







                    </table>
                    <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"   >

                        <tr style="display:none" > <!-- session regiatration if any -->
                            <td>RegistrationNo </td>
                            <td><input value="" type="text" name="registrationNo" id="registrationNo" class="textboxxx  fWidth "/> </td>
                        </tr>









                        <tr >
                            <td>Admission Form No </td>
                            <td><input value="" type="text" name="admission_no" id="admission_no" class="textboxxx  fWidth "/> </td>
                        </tr>






                        <tr >
                            <td>Mobile Emergency </td>
                            <td><input value="" type="text" name="mobile_emergency" id="mobile_emergency" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Email Guardian </td>
                            <td><input value="" type="text" name="email_guardian" id="email_guardian" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Mother Tongue </td>
                            <td><input value="" type="text" name="mother_tongue" id="mother_tongue" class="textboxxx  fWidth "/> </td>
                        </tr>
                        <tr >
                            <td>Blood Group </td>
                            <td><input value="" type="text" name="blood_group" id="blood_group" class="textboxxx  fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Guardian Ocu </td>
                            <td><input value="" type="text" name="guardian_ocu" id="guardian_ocu" class="textboxxx  fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Father Adhar </td>
                            <td><input value="" type="text" name="father_adhar" id="father_adhar" class="textboxxx  fWidth"/> </td>
                        </tr><tr >
                            <td>Mother Ocu </td>
                            <td><input value="" type="text" name="mother_ocu" id="mother_ocu" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Mother Adhar </td>
                            <td><input value="" type="text" name="mother_adhar" id="mother_adhar" class="textboxxx  fWidth"/> </td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable">
                        <tr >
                            <td>Acc No</td>
                            <td><input value="" type="text" name="accNo" id="accNo" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Acc Holder Name </td>
                            <td><input value="" type="text" name="accHolderName" id="accHolderName" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>IFSC Code </td>
                            <td><input value="" type="text" name="ifscCode" id="ifscCode" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Branch </td>
                            <td><input value="" type="text" name="branch" id="branch" class="textboxxx  fWidth "/> </td>
                        </tr>

                        <tr >
                            <td>Outgoing TC No</td>
                            <td><input value="" type="text" name="outGoingTcNo" id="outGoingTcNo" class="textboxxx  fWidth "/> </td>
                        </tr>



                        <tr >
                            <td>Outgoing TC Date</td>
                            <td><input value="" type="text" name="outGoingTcDate" id="outGoingTcDate" class="wtDateClass textbox fWidth" style="width:81px;"/>Status

                                <select name="historyStatus" id="historyStatus" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->historyStatus,'Active');	?></select>

                            </td>
                        </tr>





                        <tr >
                            <td>In Active Date</td>
                            <td>
                                <input value="" type="text" name="inactiveDate" id="inactiveDate" class="wtDateClass textbox fWidth" style="width:81px;"/>

                            </td>
                        </tr>





                    </table>
                    <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"   >


                        <tr >
                            <td>Guardian Relation </td>
                            <td><input value="" type="text" name="guardian_relation" id="guardian_relation" class="textboxxx fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Guardian Address </td>
                            <td><input value="" type="text" name="guardian_address" id="guardian_address" class="textboxxx
fWidth "/> </td>
                        </tr>

                        <tr >
                            <td>Anual Income </td>
                            <td><input value="" type="text" name="anual_income" id="anual_income" class="textboxxx  fWidth
"/> </td>
                        </tr>
                        <tr >
                            <td>Mobile Guardian </td>
                            <td><input value="" type="text" name="mobile_guardian" id="mobile_guardian" class="textboxxx
fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Other Religian </td>
                            <td><input value="" type="text" name="other_religian" id="other_religian" class="textboxxx fWidth
"/> </td>
                        </tr>





                        <tr >
                            <td>Register Date </td>
                            <td><input value="" type="text" name="registerDate" id="registerDate" class="wtDateClass textbox
fWidth"/></td>
                        </tr><tr >
                            <td>Register No </td>
                            <td><input value="" type="text" name="registerNo" id="registerNo" class="textboxxx  fWidth "/>
                            </td>
                        </tr>










                        <tr >
                            <td>Minority </td>
                            <td>

                                <select name="minority" id="minority" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->yesno);	?></select>	 </td>
                        </tr>


                        <tr >
                            <td>Kanyashree </td>
                            <td>
                                <select name="kanyashree" id="kanyashree" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->kanyashree);	?></select>	 </td>
                        </tr>

                        <tr >
                            <td>Yuvashree </td>
                            <td>
                                <select name="yuvashree" id="yuvashree" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->yuvashree);	?></select>	 </td>
                        </tr>

                        <tr >
                            <td>Last School </td>
                            <td><input value="" type="text" name="last_school" id="last_school" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Last Class </td>
                            <td><input value="" type="text" name="last_class" id="last_class" class="textboxxx  fWidth "/>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><div class="formDivButton" style="margin-top:20px;display:none;">
                                    <? if($os->access('wtDelete')){ ?><input type="button" value="Delete" onclick="WT_historyDeleteRowById('');" />	<? } ?>
                                    &nbsp;&nbsp;
                                    &nbsp; <input type="button" value="Home" onclick="javascript:window.location='';" />

                                    &nbsp; <? if($os->access('wtEdit')){ ?><input type="button" value="Save & Close"  onclick="WT_historyEditAndSave('NO');" /><? } ?>
                                </div></td>

                        </tr>

                    </table>

                </div>
            </div>
        </div>
    </div>


<?
}

function list_admission($asession,$classList_s)
{
global $os,$site;


      $listingQuery="  select * from history where historyId>0 and   asession='$asession' and  class='$classList_s'     order by  historyId desc";


	 $os->showPerPage=200;

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];


	$studentList= $os->getIdsDataFromQuery($rsRecords->queryString,'studentId','student','studentId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
	?>
    <div class="background-color-white">
        <div class="text-m p-m" style="position: sticky; top: 0; background-color: rgb(168, 255, 196)">
            Session:<? echo $asession; ?> Class:<? echo $os->val($os->classList,$classList_s); ?>
        </div>


        <table class="background-color-white" style="border-collapse: collapse; width: 100%">
            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){



                $serial++;
                ?>
                <tr style="border-bottom:1px solid #eeeeee; cursor: pointer" class="hover-background-color-light-grey">


				   <td>
				    <p><?php echo $serial; ?></p>
				   </td>
				    <td class="p-m" style="vertical-align: top" width="60px">
					<?php if( $studentList[$record['studentId']]['image']!=''){ ?>  <img src="<? echo $site['url'].$studentList[$record['studentId']]['image'];?> " height="60" />  <? } ?>
                        <!--<div class="list-view-dp color-white" style="">
                            <p><?php echo $serial; ?></p>
                        </div>-->
                    </td>


                    <td class="p-top-m p-bottom-m p-right-m v-align-top">
                        <h4 class="p-bottom-s"><?php echo $studentList[$record['studentId']]['name'] ?></h4>
                        <table style="border-collapse: collapse;" class="text-xs">
                            <tr>
                                <td>ID</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['studentId']; ?></b></td>

                                <td class="p-left-m">Roll</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?  echo  $record['roll_no'];  ?></b> </td>

                            </tr>
                            <tr>
                                <td>Session</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['asession']; ?></b></td>

                                <td class="p-left-m">Class</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td >
                                    <b class="color-flat-blue">
                                        <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?>
                                    </b>
                                </td>

                                <td class="p-left-m">Section</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td class="p-right-m">
                                    <b class="color-flat-blue">
                                        <? if(isset($os->section[$record['section']])){ echo  $os->section[$record['section']]; } ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?
            }
            ?>
		</table>
		</div>

	<?
}


function list_admission_todo($asession,$classList_s)
{
global $os,$site;
$asession=$asession-1;
$classList_s=$classList_s-1;
    $listingQuery="  select * from history where historyId>0 and   asession='$asession' and  class='$classList_s'     order by  historyId desc";

    $os->showPerPage=200;
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];

	$studentList= $os->getIdsDataFromQuery($rsRecords->queryString,'studentId','student','studentId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
	?>

	<div class="background-color-white">
        <div class="text-m p-m" style="position: sticky; top: 0; background-color: rgb(168, 255, 196)">
            Session:<? echo $asession; ?> Class:<? echo $os->val($os->classList,$classList_s); ?>
        </div>
        <table class="background-color-white" style="border-collapse: collapse">
            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;
                ?>
                <tr style="border-bottom:1px solid #eeeeee; cursor: pointer" class="hover-background-color-light-grey">

                    <td class="p-m" style="vertical-align: top" width="60px">
                        <div class="list-view-dp color-white" style="">
                            <p class="text-m"><?php echo $serial; ?></p>
                        </div>
                    </td>


                    <td class="p-top-m p-bottom-m p-right-m v-align-top">
                        <h4 class="p-bottom-s"><?php echo $studentList[$record['studentId']]['name'] ?></h4>
                        <table style="border-collapse: collapse;" class="text-xs">
                            <tr>
                                <td>ID</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['studentId']; ?></b></td>

                                <td class="p-left-m">Roll</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?  echo  $record['roll_no'];  ?></b> </td>

                            </tr>
                            <tr>
                                <td>Session</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['asession']; ?></b></td>

                                <td class="p-left-m">Class</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td >
                                    <b class="color-flat-blue">
                                        <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?>
                                    </b>
                                </td>

                                <td class="p-left-m">Section</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td class="p-right-m">
                                    <b class="color-flat-blue">
                                        <? if(isset($os->section[$record['section']])){ echo  $os->section[$record['section']]; } ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?
            } ?>
        </table>
    </div>

	<?
}



 function getFeesConfig($asession,$class,$student_type)
  {

   global $os;
   $config_array=array();
   $dataQuery="SELECT * FROM `feesconfig` where classId='$class' and accademicsessionId='$asession' and student_type like '$student_type%' ";
	$rsResults=$os->mq($dataQuery);
	while($record=$os->mfa($rsResults))
	{
	 $record['feesType']=trim($record['feesType']);
	 $config_array [$record['feesType']][$record['feesHead']]=$record['amount'];
	}
	return $config_array;

  }
  function getGlobalConfig($asession,$class)
  {

   global $os;
   return $os->global_session_setting($asession,$class);
   /*$config_array=array();
  $dataQuery="SELECT * FROM `global_session_setting` where class_id='$class' and asession='$asession' limit 1   ";
	$rsResults=$os->mq($dataQuery);
	$config_array=$os->mfa($rsResults);
	return $config_array;*/

  }



function list_re_admission_todo($asession,$classList_s)
{
global $os,$site;

$asession_done=$asession;
$classList_s_done=$classList_s;

$asession=$asession-1;
$classList_s=$classList_s-1;



    $alreadyadmitted="select h_done.studentId from history h_done where   h_done.asession='$asession_done' and h_done.class='$classList_s_done' ";





      $listingQuery="  select * from history where historyId>0 and   asession='$asession' and  class='$classList_s'  and studentId NOT  IN($alreadyadmitted)    order by  historyId desc";


	 $os->showPerPage=200;

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];


	$studentList= $os->getIdsDataFromQuery($rsRecords->queryString,'studentId','student','studentId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
	?>

    <div class="background-color-white">
        <div class="text-m p-m" style="position: sticky; top: 0; background-color: rgb(168, 255, 196)">
            Session:<? echo $asession; ?> Class:<? echo $os->val($os->classList,$classList_s); ?>
        </div>
        <table class="background-color-white" style="border-collapse: collapse">
            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;
                ?>
                <tr style="border-bottom:1px solid #eeeeee; cursor: pointer" class="hover-background-light-grey" onclick="step1();re_admission_admin('<?php echo $record['studentId']; ?>','<?php echo $record['historyId']; ?>')">

                    <td class="p-m" style="vertical-align: top" width="60px">
                        <div class="list-view-dp color-white " style="">
                            <p class="text-m"><?php echo $serial; ?></p>
                        </div>
                    </td>


                    <td class="p-top-m p-bottom-m p-right-m v-align-top">
                        <h4 class="p-bottom-s"><?php echo $studentList[$record['studentId']]['name'] ?></h4>
                        <table style="border-collapse: collapse;" class="text-xs">
                            <tr>
                                <td>ID</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['studentId']; ?></b></td>

                                <td class="p-left-m">Roll</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?  echo  $record['roll_no'];  ?></b> </td>

                            </tr>
                            <tr>
                                <td>Session</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['asession']; ?></b></td>

                                <td class="p-left-m">Class</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td >
                                    <b class="color-flat-blue">
                                        <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?>
                                    </b>
                                </td>

                                <td class="p-left-m">Section</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td class="p-right-m">
                                    <b class="color-flat-blue">
                                        <? if(isset($os->section[$record['section']])){ echo  $os->section[$record['section']]; } ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?
            } ?>
        </table>
    </div>


	<?



}

 function form_RE_admission($asession,$classList_s,$studentId,$historyId)
{
  global $os,$site;

  $history= $os->rowByField('','history',$fld='studentId',$studentId,$where=" and historyId='$historyId' ",$orderby='');
  $student= $os->rowByField('','student',$fld='studentId',$studentId,$where=" ",$orderby='');


 // type of student //
  $vehicle_type_arr=array();
$student_type_arr=array();
$classId=$classList_s;
$accademicsessionId=$asession;
$student_type_q= "SELECT distinct(student_type) FROM `feesconfig` where classId='$classId' and  accademicsessionId='$accademicsessionId' ";
$student_type_rs=$os->mq($student_type_q);
while($recordtype=$os->mfa( $student_type_rs))
{
  $student_type_arr[$recordtype['student_type']]=$recordtype['student_type'];
}


$vehicle_type_q= "SELECT distinct(vehicle_type) FROM `vehicle_config` where class_id='$classId' and  asession='$accademicsessionId' ";
$vehicle_type_rs=$os->mq($vehicle_type_q);
while($recordtype=$os->mfa( $vehicle_type_rs))
{
  $vehicle_type_arr[$recordtype['vehicle_type']]=$recordtype['vehicle_type'];
}

// vehicle_type //  vehicle_distance / vehicle_price
$formdata=array();
if($studentId >0 && $historyId>0)
{
$formdata=array_merge($history,$student);
}

$os->data=$formdata;



?>
     <div style="position: sticky; top: 0; z-index: 2" class="p-s background-color-white border-none border-bottom-xxs border-color-light-grey">
         <div class="grid">
             <div class="grid-item p-s">
                 <h1 >
                     <input readonly onclick="open_editor_tooltip(this)" style="font-size:24px" value="<? echo $student['name']; ?>" type="text" name="name" id="name" class="border-none font-weight-xxl color-primary full-width" />
                 </h1>
                 <p >
                     Session : <? echo $asession;?>
                 </p>
             </div>

             <div class="p-s grid-item" style="max-width: 170px;display:flex; align-items: center; justify-content: flex-end">
                 <button type="button" class="material-button" onclick="step2();">
                     <span>PAYMENT DETAILS</span>
                     <i class="la la-arrow-right"></i>
                 </button>
             </div>
         </div>
     </div>

     <div class="grid">
	 <? if($studentId>0){

	 $student_img='student_img.png';
	 $student_img_link=$site['url-wtos']."images/".$student_img;
	 if($student['image'])
	 {


	 }



	 ?>
         <input type="hidden" name="studentId" id="studentId" value="<? echo $studentId; ?>" />
         <input type="hidden" name="historyId" id="historyId" value="<? echo $historyId; ?>" />

         <div class="grid-item p-m" style="max-width: 205px">
             <div class="dp-selecter">
                 <div style="position:relative; border-radius:100%; width: 185px; height: 185px; background-color: rgba(0,0,255,0.3); background-position: center; background-repeat: no-repeat; background-image: url('<?php echo $student_img_link; ?>')" id="imageView">
                     <input type="file" name="image" value="" id="image" onchange="image_set_background_from_input(this, '#imageView')//os.readURL(this,'imagePreview') " style="display:none;">

                     <div class="p-m border-radius-xxxl" style="position:absolute; bottom: 10px; right: 10px; background-color: rgba(0,0,0,0.5)">
                         <i style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');" class="mi text-xl">camera_alt</i>
                     </div>

                 </div>

             </div>
         </div>

         <div class="grid-item p-m">
             <h3 class="p-m">Personal Information</h3>
             <table class="border-less-input-table">
                 <tr>
                     <th class="p-s p-left-m">Name</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['name']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">DOB</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['dob']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">Gender</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['gender']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">Caste</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['caste']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">Father's Name</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['father_name']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">Vill/City</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['vill']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">PO</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['po']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">PS</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['ps']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">Dist</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['dist']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">Block</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['block']; ?></td>
                 </tr>
                 <tr>
                     <th class="p-s p-left-m">Mobile</th>
                     <td class="p-s p-left-m p-right-m"><? echo $student['mobile_student']; ?></td>
                 </tr>
             </table>
             <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">





                 <tr >
                     <td>Session </td>
                     <td colspan="4">
                         <select name="asession" id="asession" class="textbox fWidth" style="font-size:14px; font-weight:bold;" ><option value=""> </option>	<?
                             $os->onlyOption($os->asession,$asession);	?></select>

                         <select name="board" id="board" class="textbox fWidth" style="display:none;" ><option value=""> </option>	<?
                             $os->onlyOption($os->board);	?></select> Class <select name="class" id="class" class="textbox fWidth" style="font-size:14px; font-weight:bold;" ><option value=""> </option>	<?
                             $os->onlyOption($os->classList,$classList_s);	?></select>
                     </td>
                 </tr>



                 <tr >
                     <td>  Section
                     </td>
                     <td>
                         <select name="section" id="section" class="textbox fWidth" style="font-size:14px; font-weight:bold;" ><option value=""> </option>	<?
                             $os->onlyOption($os->section);	?></select>

                         Roll no <input value="" type="text" name="roll_no" id="roll_no" class="textboxxx  fWidth " style="width:50px;"/>


                     </td>
                 </tr>


                 <tr>
                     <td>   Stream </td> <td>   <select name="stream" id="stream" class="textbox fWidth" style="font-size:14px; font-weight:bold;" ><option value=""> </option>	<?  $os->onlyOption($os->stream);	?></select>	</td>


                 </tr>


                 <tr >
                     <td> </td>
                     <td> </td>
                 </tr>



                 <tr >
                     <td>Admission Date </td>
                     <td><input value="<? echo date("d-m-Y",strtotime($os->now()))?>" type="text" name="admission_date" id="admission_date" class="wtDateClass textbox fWidth"/></td>
                 </tr>




                 <tr>
                     <td colspan="2"> Note <input value="" type="text"   name="remarks" id="remarks" style=" width:250px;" class="textbox fWidth" ></td>
                 </tr>


             </table>
             <span id="spmorebutton" onclick="loadMoredata()" style="cursor:pointer; color:#FF3300; font-size:16px">More</span>
         </div>
         <div class="grid-item p-m" >


             <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
                 <tr >
                     <td style="width:100px;">Student Type </td>
                     <td><select name="student_type" id="student_type" class="textbox fWidth" onchange="manage_vehicle_option()" > 	<?
                             $os->onlyOption($student_type_arr);	?></select>  </td>
                 </tr>

                 <tr >
                     <td colspan="4"> </td>

                 </tr>
                 <tr >
                     <td colspan="4">




                     </td>
                 </tr>


                 <tr    >
                     <td colspan="2" >
                         <div style="width:170px;" >

                             <div id="hotel_room_div" style="display:none;">
                                 Building name <input type="text" id="building_name"  /> <br /><br />
                                 Floor name <input type="text" id="floor_name"  /> <br /><br />
                                 Room name <input type="text" id="room_name"  /> <br /><br />
                                 Bed no <input type="text" id="bed_no"  /> <br /><br />
                                 hostel_room_id <input type="text" id="hostel_room_id"  />

                             </div>



                             <div id="vehiclediv">

                                 <input value="" type="checkbox" name="vehicle" id="vehicle" class="textboxxx  fWidth " onclick="set_vehicle();"/>

                                 Please tick to avail vehicle service.

                                 <div id="vehicle_data" style="display:none">
                                     Vehicle <select name="vehicle_type" id="vehicle_type_id" class="textbox fWidth"


                                                     onchange="ajax_chain('html*vehicle_distance_id*vehicle_config,vehicle_distance,vehicle_distance*asession=asession_s,vehicle_type=vehicle_type_id'); os.setVal('vehicle_price','')"   ><option value=""> </option>

                                         <?
                                         $os->onlyOption($vehicle_type_arr);	?></select>
                                     <br /><br />  Distance
                                     <select name="vehicle_distance" id="vehicle_distance_id" class="textbox fWidth"
                                             onchange="ajax_chain('text*vehicle_price*vehicle_config,vehicle_price,vehicle_price*asession=asession_s,vehicle_type=vehicle_type_id,vehicle_distance=vehicle_distance_id')"   >

                                         <option value=""></option> </select>

                                     <br /><br />
                                     Price
                                     <input type="text"  name="vehicle_price" id="vehicle_price" style="width:200px;"    />

                                 </div>
                             </div>
                         </div>

                     </td>
                     <td>



                     </td>
                 </tr>



             </table>

             Discount: <br />
             admission  <input  type="text" id="discountTypeAdmission" value="<? echo $os->getVal('discountTypeAdmission'); ?>"   readonly="readonly" class="disabled_input"/>


             <br />
             <input type="text" id="discountValueAdmission" value="<? echo $os->getVal('discountValueAdmission'); ?>"  readonly="readonly" class="disabled_input"/><br />
             monthly   <input type="text" id="discountTypeMonthly" value="<? echo $os->getVal('discountTypeMonthly'); ?>" readonly="readonly" class="disabled_input"/><br />
             <input type="text" id="discountValueMonthly" value="<? echo $os->getVal('discountValueMonthly'); ?>"   readonly="readonly" class="disabled_input"/><br />

			 <div  >
                        <h3 class="p-m p-bottom-none">Donation</h3>

                        <div class="p-m">
                            <table style="border-collapse: collapse">
                                <tr>
                                    <td>Amount</td>
                                    <td class="p-left-m"><input  type="text" id="donation" value="<? echo $os->getVal('donation'); ?>"  readonly="readonly" class="border-none"  /></td>

									</tr>
									 <tr>
                                    <td>Installment count</td>
                                    <td class="p-left-m ">
                                        <input type="text" id="donation_installment" value="<? echo $os->getVal('donation_installment'); ?>"  readonly="readonly" class="border-none color-flat-green"/>
                                    </td>

                                </tr>


                            </table>
                        </div>
                    </div>





             <input type="button" class="bbbutton" value="PAYMENT DETAILS" onclick="step2();" />




         </div>



         <div  style="display:none;"   id="MoreStudentData">

			 LOAD MORE DATA HERE
	</div>


	<div style="clear:both; height:1px;"> </div>

  <? }else{ ?>
  <div > Please select student from student list </div>
  <? }?>

	</div>


<?
}
 function form_genarate_FEES($asession,$classList_s,$studentId,$historyId)
{
  global $os,$site;

  $history= $os->rowByField('','history',$fld='studentId',$studentId,$where=" and historyId='$historyId' ",$orderby='');
  $student= $os->rowByField('','student',$fld='studentId',$studentId,$where=" ",$orderby='');


 // type of student //
  $vehicle_type_arr=array();
$student_type_arr=array();
$classId=$classList_s;
$accademicsessionId=$asession;
$student_type_q= "SELECT distinct(student_type) FROM `feesconfig` where classId='$classId' and  accademicsessionId='$accademicsessionId' ";
$student_type_rs=$os->mq($student_type_q);
while($recordtype=$os->mfa( $student_type_rs))
{
  $student_type_arr[$recordtype['student_type']]=$recordtype['student_type'];
}


$vehicle_type_q= "SELECT distinct(vehicle_type) FROM `vehicle_config` where class_id='$classId' and  asession='$accademicsessionId' ";
$vehicle_type_rs=$os->mq($vehicle_type_q);
while($recordtype=$os->mfa( $vehicle_type_rs))
{
  $vehicle_type_arr[$recordtype['vehicle_type']]=$recordtype['vehicle_type'];
}

// vehicle_type //  vehicle_distance / vehicle_price
$formdata=array();
if($studentId >0 && $historyId>0)
{
$formdata=array_merge($history,$student);
}

$os->data=$formdata;



?>
     <div style="position: sticky; top: 0; z-index: 2" class="p-s background-color-white border-none border-bottom-xxs border-color-light-grey">
         <div class="grid">
             <div class="grid-item p-s">
                 <h1 >
                    Genarate Fees.
                 </h1>
                   <p style="color:#009900" title="H:<? echo $historyId ?>" >
                     For : <? echo $student['name'];?>
                 </p>
             </div>

             <div class="p-s grid-item" style="max-width: 170px;display:flex; align-items: center; justify-content: flex-end">
                 <button type="button" class="material-button" onclick="genarate_FEES_single();">
                     <span>GENERATE FEES</span>
                     <i class="la la-arrow-right"></i>
                 </button>
             </div>
         </div>
     </div>

     <div class="grid">
	 <? if($studentId>0){





	 ?>
         <input type="hidden" name="studentId" id="studentId" value="<? echo $studentId; ?>" />
         <input type="hidden" name="historyId" id="historyId" value="<? echo $historyId; ?>" />


         <div class="grid-item p-m">
             <div  >

              <? $os->admissionType=array_filter($os->admissionType); ?>
 <select name="admissionType" id="admissionType" class="fWidth" onchange="setDiscountType()" style="font-size:16px; color:#0000CC;" >
                        <? $os->onlyOption($os->admissionType);	?>
                    </select>



             <br />

           <h3 class="p-m p-bottom-none">Discount</h3>
			      <div class="p-m">




                            <table style="border-collapse: collapse">
                                <tr>
                                    <td><span id="setDiscountType_DIV" style="width:150px;"><? echo reset($os->admissionType); ?></span></td>
                                    <td class="p-left-m">
									<select name="discountTypeAdmission" id="discountTypeAdmission" class="  fWidth" >
                        <? $os->onlyOption($os->discountType,$os->getVal('discountTypeAdmission'));	?>
                    </select>

									<input type="text" id="discountValueAdmission" value="<? echo $os->getVal('discountValueAdmission'); ?>"  class="textboxxx  fWidth "  />

									</td>

									</tr>
									 <tr>
                                    <td>Monthly</td>
                                    <td class="p-left-m ">
									<select name="discountTypeMonthly" id="discountTypeMonthly" class="fWidth" >
                        <? $os->onlyOption($os->discountType,$os->getVal('discountTypeMonthly'));	?>
                    </select>

										<input type="text" id="discountValueMonthly" value="<? echo $os->getVal('discountValueMonthly'); ?>" class="textboxxx  fWidth "    />
                                    </td>

                                </tr>


                            </table>
                        </div>

                        <h3 class="p-m p-bottom-none">Donation</h3>

                        <div class="p-m">




                            <table style="border-collapse: collapse">
                                <tr>
                                    <td>Amount</td>
                                    <td class="p-left-m"><input  type="text" id="donation" value="<? echo $os->getVal('donation'); ?>"  class="textboxxx  fWidth "   /></td>

									</tr>
									 <tr>
                                    <td>Installment count</td>
                                    <td class="p-left-m ">
                                        <input type="text" id="donation_installment" value="<? echo $os->getVal('donation_installment'); ?>"    class="textboxxx  fWidth "   />
                                    </td>

                                </tr>


                            </table>
                        </div>
                    </div>

             <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm" style="display:none;">

                 <tr >
                     <td>Session </td>
                     <td colspan="4">
                         <select name="asession" id="asession" class="textbox fWidth" style="font-size:14px; font-weight:bold;" ><option value=""> </option>	<?
                             $os->onlyOption($os->asession,$asession);	?></select>

                           Class <select name="class" id="class" class="textbox fWidth" style="font-size:14px; font-weight:bold;" ><option value=""> </option>	<?
                             $os->onlyOption($os->classList,$classList_s);	?></select>
                     </td>
                 </tr>



                 <tr >
                     <td>  Section
                     </td>
                     <td>
                         <select name="section" id="section" class="textbox fWidth" style="font-size:14px; font-weight:bold;" ><option value=""> </option>	<?
                             $os->onlyOption($os->section,$os->getVal('section'));	?></select>

                         Roll no <input value="<? echo $os->getVal('roll_no'); ?>" type="text" name="roll_no" id="roll_no" class="textboxxx  fWidth " style="width:50px;"/>


                     </td>
                 </tr>




                 <tr >
                     <td>Admission Date </td>
                     <td><input value="<? echo date("d-m-Y",strtotime($os->now()))?>" type="text" name="admission_date" id="admission_date" class="wtDateClass textbox fWidth"/></td>
                 </tr>




                 <tr>
                     <td colspan="2"> Note <input value="<? echo $os->getVal('remarks'); ?>" type="text"   name="remarks" id="remarks" style=" width:250px;" class="textbox fWidth" ></td>
                 </tr>


             </table>

         </div>
         <div class="grid-item p-m" >


             <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">
                 <tr >
                     <td style="width:100px;">Student Type </td>
                     <td><select name="student_type" id="student_type" class="textbox fWidth" onchange="manage_vehicle_option()" > 	<?
                             $os->onlyOption($student_type_arr,$os->getVal('student_type'));	?></select>  </td>
                 </tr>




                 <tr    >
                     <td colspan="2" >
                         <div style="width:170px;" >

                             <div id="hotel_room_div" style="display:none;">

							     <table style="border-collapse: collapse">
                                <tr>
                                    <td> Building name</td>
                                    <td class="p-left-m"><input type="text" id="building_name" class="textboxxx  fWidth "  /></td>

									</tr>
									 <tr>
                                    <td>Floor name</td>
                                    <td class="p-left-m ">
                                        <input type="text" id="floor_name" class="textboxxx  fWidth "  />
                                    </td>

                                </tr>

                                 <tr>
                                    <td> Room name</td>
                                    <td class="p-left-m ">
                                       <input type="text" id="room_name" class="textboxxx  fWidth " />
                                    </td>

                                </tr>

								 <tr>
                                    <td>Bed no</td>
                                    <td class="p-left-m ">
                                      <input type="text" id="bed_no" class="textboxxx  fWidth "  />
                                    </td>

                                </tr>

								 <tr style="display:none;">
                                    <td> Room Id</td>
                                    <td class="p-left-m ">
                                       <input type="text" id="hostel_room_id" class="textboxxx  fWidth "  />
                                    </td>

                                </tr>
                            </table>



                             </div>



                             <div id="vehiclediv">

                                 <input value="" type="checkbox" name="vehicle" id="vehicle" class="textboxxx  fWidth " onclick="set_vehicle();"/>

                                 Please tick to avail vehicle service.

                                 <div id="vehicle_data" style="display:none">
                                     Vehicle <select name="vehicle_type" id="vehicle_type_id" class="textbox fWidth"


                                                     onchange="ajax_chain('html*vehicle_distance_id*vehicle_config,vehicle_distance,vehicle_distance*asession=asession_s,vehicle_type=vehicle_type_id'); os.setVal('vehicle_price','')"   ><option value=""> </option>

                                         <?
                                         $os->onlyOption($vehicle_type_arr);	?></select>
                                     <br /><br />  Distance
                                     <select name="vehicle_distance" id="vehicle_distance_id" class="textbox fWidth"
                                             onchange="ajax_chain('text*vehicle_price*vehicle_config,vehicle_price,vehicle_price*asession=asession_s,vehicle_type=vehicle_type_id,vehicle_distance=vehicle_distance_id')"   >

                                         <option value=""></option> </select>

                                     <br /><br />
                                     Price
                                     <input type="text"  name="vehicle_price" id="vehicle_price" style="width:200px;" class="textboxxx  fWidth "   />

                                 </div>
                             </div>
                         </div>

                     </td>
                     <td>



                     </td>
                 </tr>



             </table>



         </div>






	<div style="clear:both; height:1px;"> </div>

  <? }else{ ?>
  <div > Please select student from student list </div>
  <? }?>

	</div>


<?
}


if($os->get('ajax_chain')=='OK' && $os->post('ajax_chain')=='OK')
{

 $output_type=$os->post('output_type');
 $field_id=$os->post('field_id');
 $tableField=$os->post('tableField');
 $conditions_val_str=$os->post('conditions_val_str');

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










  $arr=array();
   $query2="select * from $table where  $table_id_fleld!=''   $conditions_str ";
   $rsResults=$os->mq($query2);

		$val=0;
		while($record=$os->mfa( $rsResults))
		{
		  $arr[$record[$table_id_fleld]]=$record[$table_val_fleld];
		  $val=$record[$table_val_fleld];
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




exit();
}




  function createFeesRecord_____________($studentId,$historyId,$config_array,$global_setting,$feesType='Admission',$month_fees_selected='') // seems not used 
  {
       global $os,$site;

	   //   month_fees_selected  to create payment for monthly
	   $fees_student_id_array=array();
	   $monthYear_selected=array();
	   if($month_fees_selected!='')
		{
			$month_fees_arr=explode(',',$month_fees_selected);
			$month_fees_arr = array_filter($month_fees_arr);
			foreach($month_fees_arr as $val)
			{
				$monthYear_selected[$val]=$val;


			}

		}

	  //  create record for all fees

       $history= $os->rowByField('','history',$fld='studentId',$studentId,$where=" and historyId='$historyId' ",$orderby='');


		$session_start_date=$global_setting['session_start_date'];
		$payment_due_date=$global_setting['payment_due_date'];
		$per_day_fine=$global_setting['per_day_fine'];


		 $fees_onetime_list=$config_array[$feesType];
		 $fees_onetime_total=array_sum($fees_onetime_list);

		 $classId=$history['class'];
		 $accademicsessionId=$history['asession'];
		 $admission_date=$history['admission_date'];
		 $month_academic=$os->month_academic($accademicsessionId,$classId,$admission_date);



		// admission readmission data entry  454

		$month=date('m');
		$year=date('Y');

		 $dueDate=$payment_due_date; // nnnnnnnnnnnnnnnnnnnnnnnnnn
		 $discountTypeAdmission=$history['discountTypeAdmission'];
		 $discountValueAdmission=$history['discountValueAdmission'];
		 $discountAmount=0;
		 if($discountTypeAdmission=='RS')
		 {
		   $discountAmount=$discountValueAdmission;
		 }
		 if($discountTypeAdmission=='%')
		 {
		   $discountAmount=round(($fees_onetime_total*$discountValueAdmission)/100);
		 }
		$totalPayble=$fees_onetime_total-$discountAmount;
		$dataToSave=array();
		$dataToSave['studentId']=$studentId;
		$dataToSave['feesType']=$feesType;
		$dataToSave['accademicsessionId']=$accademicsessionId;
		$dataToSave['classId']=$classId;
		$dataToSave['month']=$month;
		$dataToSave['year']=$year;
		$dataToSave['historyId']=$historyId;
		$dataToSave['feesdata']='';
		$dataToSave['dueDate']=$dueDate;
		$dataToSave['amount']=$fees_onetime_total;
		$dataToSave['vehicle']=0; // it is for only monthly record
		$dataToSave['fine']=0; // fine will be calculated
		$dataToSave['discountType']=$discountTypeAdmission; // percent,flat
		$dataToSave['discountValue']=$discountValueAdmission;
		$dataToSave['discountAmount']=$discountAmount;
		$dataToSave['totalPayble']=$totalPayble;
		$dataToSave['paymentStatus']='unpaid';
		$dataToSave['note']='';
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$fees_student_id=$os->save('fees_student',$dataToSave,'fees_student_id','');

		 // capture admission/readmissn fees to create paymnent
	    $fees_student_id_array[$fees_student_id]=$fees_student_id;


	    if($fees_student_id>0)
		{


			   foreach($fees_onetime_list as $fees_head=>$amount)
			   {
					$dataToSave2=array();
					$dataToSave2['fees_student_id']=$fees_student_id;
					$dataToSave2['studentId']=$studentId;
					$dataToSave2['feesType']=$feesType;
					$dataToSave2['accademicsessionId']=$accademicsessionId;
					$dataToSave2['classId']=$classId;
					$dataToSave2['month']=$month;
					$dataToSave2['year']=$year;
					$dataToSave2['historyId']=$historyId;

					$dataToSave2['fees_head']=$fees_head;
					$dataToSave2['amount']=$amount;
					$dataToSave2['note']='';
					$dataToSave2['addedDate']=$os->now();
					$dataToSave2['addedBy']=$os->userDetails['adminId'];
					$fees_student_details_id=$os->save('fees_student_details',$dataToSave2,'fees_student_details_id','');
				}


	   }
	   // admission readmission data entry  454 end




	   foreach($month_academic as $key=>$val){

		$month=$val['month_int'];
		$year=$val['year'];
		// monthly data entry 444555

		$feesType='Monthly';
		$monthly_fees_list=$config_array['Monthly'];
		$total_monthly_fees=array_sum($monthly_fees_list);

		$vehicle=$history['vehicle'];
		$vehicle_price=$history['vehicle_price'];
		if($vehicle!=1)
		{
			$vehicle_price=0;
		}

		$discountTypeMonthly=$history['discountTypeMonthly'];
		$discountValueMonthly=$history['discountValueMonthly'];
		$discountAmount=0;
		 if($discountTypeMonthly=='Rs')
		 {
		   $discountAmount=$discountValueMonthly;
		 }
		 if($discountTypeMonthly=='%')
		 {
		   $discountAmount=round(($total_monthly_fees*$discountValueMonthly)/100);
		 }
		$totalPayble=$total_monthly_fees+$vehicle_price-$discountAmount;
		$dataToSave=array();
		$dataToSave['studentId']=$studentId;
		$dataToSave['feesType']=$feesType;
		$dataToSave['accademicsessionId']=$accademicsessionId;
		$dataToSave['classId']=$classId;
		$dataToSave['month']=$month;
		$dataToSave['year']=$year;
		$dataToSave['historyId']=$historyId;
		$dataToSave['feesdata']='';
		$dataToSave['dueDate']=$dueDate;
		$dataToSave['amount']=$total_monthly_fees;
		$dataToSave['vehicle']=$vehicle_price;
		$dataToSave['fine']=0; // will be calculated later
		$dataToSave['discountType']=$discountTypeMonthly; // percent,flat
		$dataToSave['discountValue']=$discountValueMonthly;
		$dataToSave['discountAmount']=$discountAmount;
		$dataToSave['totalPayble']=$totalPayble;
		$dataToSave['paymentStatus']='unpaid';
		$dataToSave['note']='';
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$fees_student_id=$os->save('fees_student',$dataToSave,'fees_student_id','');


		 // capture selected fees to create paymnent
		 $monthYear_key=$month.'-'.$year;
		 if(in_array($monthYear_key,$monthYear_selected))
		 {
				 $fees_student_id_array[$fees_student_id]=$fees_student_id;
		 }
		// capture selected fees to create paymnent end


	    if($fees_student_id>0)
		{


			   foreach($monthly_fees_list as $fees_head=>$amount)
			   {
					$dataToSave2=array();
					$dataToSave2['fees_student_id']=$fees_student_id;
					$dataToSave2['studentId']=$studentId;
					$dataToSave2['feesType']=$feesType;
					$dataToSave2['accademicsessionId']=$accademicsessionId;
					$dataToSave2['classId']=$classId;
					$dataToSave2['month']=$month;
					$dataToSave2['year']=$year;
					$dataToSave2['historyId']=$historyId;

					$dataToSave2['fees_head']=$fees_head;
					$dataToSave2['amount']=$amount;
					$dataToSave2['note']='';
					$dataToSave2['addedDate']=$os->now();
					$dataToSave2['addedBy']=$os->userDetails['adminId'];
					$fees_student_details_id=$os->save('fees_student_details',$dataToSave2,'fees_student_details_id','');
				}


	       }
	   // monthly data entry 444555 end
      }

   return $fees_student_id_array;

  }

  function calculate_discount($discountType,$discountValue,$discount_on_price)
  {
         $discount=0;
        if($discountType=='RS')
		 {
		   $discount=$discountValue;
		 }
		 if($discountType=='%')
		 {
		   $discount=round(($discount_on_price*$discountValue)/100);
		 }


    return $discount;

  }

   function createPayment____($fees_student_id_array,$historyId,$studentId,$paid_amount,$payment_note) /// not in use
   {
   		global $os;
		$history= $os->rowByField('','history',$fld='studentId',$studentId,$where=" and historyId='$historyId' ",$orderby='');
		$classId=$history['class'];
		$accademicsessionId=$history['asession'];
		$admission_date=$history['asession'];
		$paybleAmount=0;


		$fees_unpaid_data=$os->get_fees_unpaid($studentId,$accademicsessionId,$historyId,$fees_student_id_array);
		$paybleAmount=$os->val($fees_unpaid_data,'paybleAmount');
		$fees_student_Ids=$os->val($fees_unpaid_data,'fees_student_id_str');
		$fees_months=$os->val($fees_unpaid_data,'fees_months');

		$currentDueAmount=$paybleAmount-$paid_amount;

		$dataToSave['studentId']=$studentId;
		$dataToSave['historyId']=$historyId;
		$dataToSave['accademicsessionId']=$accademicsessionId;
		$dataToSave['classId']=$classId;
		$dataToSave['paidDate']=$os->now();
		$dataToSave['paidAmount']=$paid_amount;
		$dataToSave['paybleAmount']=$paybleAmount;
		$dataToSave['paidBy']=$os->userDetails['adminId'];
		$dataToSave['paymentNote']=$payment_note;
		$dataToSave['payment_options']='';
		$dataToSave['fees_student_Ids']=$fees_student_Ids;
		$dataToSave['fees_months']=$fees_months;
		$dataToSave['prevDueAmount']='';
		$dataToSave['currentDueAmount']=$currentDueAmount;
		$dataToSave['remarks']='';
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$dataToSave['addedDate']=$os->now();

		$receipt_no=$os->generateNewReceiptNo();
		$dataToSave['receipt_no']=$receipt_no;
		$fees_payment_id=$os->save('fees_payment',$dataToSave,'fees_payment_id','');

	   if($fees_payment_id){

	    $update_fees_student=" update fees_student set fees_payment_id='$fees_payment_id' , receipt_no='$receipt_no' ,paymentStatus='paid' where  fees_student_id IN($fees_student_Ids) " ;
	   $os->mq($update_fees_student);

	   }


	   $return['fees_payment_id']=$fees_payment_id;
	   $return['receipt_no']=$receipt_no;
	   $return['paidDate']=$dataToSave['paidDate'];
	   $return['paidAmount']=$paid_amount;
	   $return['fees_student_id_array_str']=implode(',',$fees_student_id_array);


	   return $return;


   }

   function student_fees_list_table($feesData_rs)
   {
   global $os;
   ?>
       <table class="congested-table uk-table-hover uk-table uk-table-small uk-table-divider border-xxs border-color-light-grey">
           <thead>
           <tr class="background-color-light-grey">
               <th></th>
               <th>Fees </th>
               <th>Month</th>
               <th>Year</th>
               <th>Amount</th>
               <th>Receipt</th>
           </tr>
           </thead>
           <tbody>
           <? while($records=$os->mfa($feesData_rs)){


               $trColor='';
               //if($records['paymentStatus']=='paid'  ){ $trColor='background-color:#DFFFE8;';}
               //if($records['paymentStatus']!='paid'  ){ $trColor='background-color:#FFECEC;';}

               ?>



               <tr  style="<? echo $trColor ?>"    >
                   <td valign="middle" class="v-align-middle">
				   
				    <?  if(false){ ?>

                           <? if($records['paymentStatus']!='paid'  ){?>

                               <? if($records['feesType']=='Monthly'  ) {?>
                                   <input class="uk-checkbox" value="<? echo $records['fees_student_id'] ?>" name="fees_student_ids[]" onchange="select_fees_student_ids_for_bill()" type="checkbox" >

                               <? }elseif($records['feesType']=='Monthly'  ) {?>
                                   <input class="uk-checkbox" checked="checked"    value="<? echo $records['fees_student_id'] ?>" name="fees_student_ids_donation[]"  type="checkbox" style="display:none;" >
                               <? }else{?>

                                   <input class="uk-checkbox" checked="checked"    value="<? echo $records['fees_student_id'] ?>" name="fees_student_ids_other[]"  type="checkbox" style="display:none;" >
                                   <span style="font-size:14px;"> &radic; </span>
                               <? }	?>

                           <? }
						   
						   }?>

                   </td>  <td title="<? echo $records['fees_student_id'] ?>"><? echo $records['feesType'] ?> </td>
                   <td><? echo $os->val($os->feesMonth,$records['month']); ?></td>

                   <td><? echo $records['year'] ?> </td>
                   <td> <? echo $records['totalPayble'] ?> </td>
                   <td>
                       <? if($records['paymentStatus']!='paid'){?>

                           <span style="color:#FF0000">Pending</span>

                       <? }?>
                       <? if($records['paymentStatus']=='paid'){?>
                           <span style="color:#009900">Paid</span>
                       <? }?></td>
               </tr>

           <? } ?>


           </tbody></table>
   <?

   }


   function fees_payment_list_table($paymentData_rs)
   {
   global $os;
   ?>
       <table class="congested-table uk-table uk-table-small uk-table-divider border-xxs border-color-light-grey">

           <thead>
           <tr class="background-color-light-grey">
               <th>Receipt</th>
               <th>Date</th>
               <th>Payable</th>
               <th>Paid</th>
               <th>Due</th>

           </tr>
           </thead>
           <tbody>




           <? while($records=$os->mfa($paymentData_rs)){

               //_d($records);
               $fees_payment_id=$records['fees_payment_id'];
               ?>


               <tr class="trListing">
                   <td> <span style="color:#009900; cursor:pointer;" onclick="print_receipt_fees(<? echo $fees_payment_id ?>,'')" title="<? echo $records['fees_months'] ?>"> <? echo $records['receipt_no'] ?> </span></td>
                   <td><? echo $os->showDate($records['paidDate']); ?> </td>
                   <td><? echo $records['paybleAmount'] ?> </td>
                   <td><? echo $records['paidAmount'] ?> </td>
                   <td><? echo $records['currentDueAmount'] ?> </td>




               </tr>


           <? } ?>




           </tbody></table>

       <? 
   }

   function calculate_room_no_function($asession,$class_id,$section)
   {
    global $os,$site;

   $return=array();


	$building_name='';
	$floor_name='';
	$room_name='';
	$bed_no='';
	$hostel_room_id='';

	$total_bed_list_id=array();
	$used_bed_list_id=array();
	$remains_bed_list_id=array();
/////////////////////


    $dataQuery="SELECT bed_no,hostel_room_id FROM `history` where class='$class_id' ";
	$rsResults=$os->mq($dataQuery);


		while($record=$os->mfa( $rsResults))
		{
				$room_id=$record['hostel_room_id'];
				$bed=$record['bed_no'];
				$bed_key=$room_id.'-'.$bed;
				$used_bed_list_id[$bed_key]=$bed_key;


		}

	$dataQuery="SELECT * FROM `room_setting` where class_id='$class_id' ";
	$rsResults=$os->mq($dataQuery);
	while($record=$os->mfa( $rsResults))
	{
			$room_id=$record['hostel_room_id'];
			$bed=$record['bed_no'];
			$bed_key=$room_id.'-'.$bed;
			if(!in_array($bed_key,$used_bed_list_id))
			{
				$remains_bed_list_id[$bed_key]=$bed_key;
			}




	}


$key = key($remains_bed_list_id);
 ///////


   if($key!='' )
   {
		$roomdata= explode('-',$key);
		$hostel_room_id=$roomdata['0'];
		$bed_no=$roomdata['1'];


		$dataQuery="SELECT * FROM `hostel_room` WHERE `hostel_room_id` ='$hostel_room_id'";
		$rsResults=$os->mq($dataQuery);
		$roomDetails=$os->mfa($rsResults);

		$building_name=$roomDetails['building_name'];
		$floor_name=$roomDetails['floor_name'];
		$room_name=$roomDetails['room_name'];

		$hostel_room_id=$roomDetails['hostel_room_id'];

   }


 $return['building_name']=$building_name;
 $return['floor_name']=$floor_name;
 $return['room_name']=$room_name;
 $return['bed_no']=$bed_no;
 $return['hostel_room_id']=$hostel_room_id;

 return  $return;


}

 function create_fees_student($historyId)  // only one function to create fees payments other funvtion are not used
  {
       global $os,$site;
	   
	    $history_id=$historyId;
		$historyData=$os->rowByField('','history','historyId',$history_id);
		$studentId=$student_id=  $historyData['studentId'];
		$studentData=$os->rowByField('','student','studentId',$student_id);
		$asession=$historyData['asession'];  
		$class_id=$historyData['class']; 
		 
		
		$session_months=array();
		
		 
		
	 
		 
		
		
		$fees_config_data=$historyData['fees_config_data']; 
		// _d($fees_config_data);
		$fees_approved=array();
		if($fees_config_data!='')
		{
				$fees_config_data_array=unserialize($fees_config_data);
				$fees_approved=$fees_config_data_array['fees_approved'];
				
				$session_months=$fees_config_data_array['session_months_selected'];
				 
		}
		
		 
		//  delete_unpaid_fees_student($history_id,$student_id,$asession,$class_id);  not allow to delete here delte single line  from fees list
		
		foreach($fees_approved as $fees_type=>$fees_data_arr)
		{    
		  if(count($fees_data_arr)>0)
		  {     
		     
			  // delete unpaid fees while  fees update done
			 
			  
			   
			   
			    $session_months_for_fees=$session_months;				
				if($fees_type=='Admission' || $fees_type=='Readmission')
				{
				    $first_month = reset($session_months_for_fees);
					$session_months_for_fees=array();
					$session_months_for_fees[$first_month]=$first_month;
				    
				}
			  
		  
		    foreach($session_months_for_fees as $session_month)
			{  
		         			
							    $month=substr($session_month,4,2);
								$year=substr($session_month,0,4);
								$dated	= $year.'-'.str_pad($month, 2, "0", STR_PAD_LEFT).'-01 00:00:00';	
								  	
							
													
								$totalPayble=0; 
								$dataToSave=array();
								$dataToSave['studentId']=$studentId;
								$dataToSave['feesType']=$fees_type;
								$dataToSave['accademicsessionId']=$asession;
								$dataToSave['classId']=$class_id;
								$dataToSave['month']=$month;
								$dataToSave['year']=$year;
								$dataToSave['historyId']=$historyId;
								$dataToSave['feesdata']='';
								$dataToSave['dueDate']=$dueDate;
								$dataToSave['amount']=$fees_onetime_total;
								$dataToSave['vehicle']=0; 
								$dataToSave['fine']=0;  
								$dataToSave['discountType']=''; // percent,flat
								$dataToSave['discountValue']='';
								$dataToSave['discountAmount']='';
								$dataToSave['dated']=$dated;
								
								//$dataToSave['totalPayble']=$totalPayble;
								$dataToSave['paymentStatus']='unpaid';
								$dataToSave['note']='';
								$dataToSave['addedDate']=$os->now();
								$dataToSave['addedBy']=$os->userDetails['adminId'];
								
								$fees_student_id=0;
								
								
								// if created no modification/adition done 
								
								//$exist_paid_fees=check_for_paid_fees($asession,$class_id,$studentId,$historyId,$month,$year,$fees_type);
								$exist_paid_unpaid_fees=check_paid_unpaid_fees($asession,$class_id,$studentId,$historyId,$month,$year,$fees_type);
								
							 
								if(!$exist_paid_unpaid_fees)
								{
								
							 	    $fees_student_id=$os->save('fees_student',$dataToSave,'fees_student_id','');
								
								}
					
					      
						  
						  
						   if($fees_student_id>0)
						   {
									foreach($fees_data_arr as $fees_head=>$fees_amount)
									{
									
										$dataToSave2=array();
										$dataToSave2['fees_student_id']=$fees_student_id;
										$dataToSave2['studentId']=$studentId;
										$dataToSave2['feesType']=$fees_type;
										$dataToSave2['accademicsessionId']=$asession;
										$dataToSave2['classId']=$class_id;
										$dataToSave2['month']=$month;
										$dataToSave2['year']=$year;
										$dataToSave2['historyId']=$historyId;
					
										$dataToSave2['fees_head']=$fees_head;
										$dataToSave2['amount']=$fees_amount;
										$dataToSave2['note']='';
										$dataToSave2['addedDate']=$os->now();
										$dataToSave2['addedBy']=$os->userDetails['adminId'];
										$fees_student_details_id=$os->save('fees_student_details',$dataToSave2,'fees_student_details_id','');
									   
										$totalPayble=$totalPayble+$fees_amount;
									
									}
							
							     $dataToSave=array();
								 $dataToSave['totalPayble']=$totalPayble;
								 $fees_student_id=$os->save('fees_student',$dataToSave,'fees_student_id',$fees_student_id);
							
							}
							
							
								
							
							
				}
			
			
			}		
		
		}
		  

  
  }
  
  function delete_unpaid_fees_student($history_id,$student_id,$asession,$class_id) // function not used // single line delete hasbeen done
  {
        
     global $os;         
					
			  
			  
			   $query=" select group_concat(fs.fees_student_id)  fees_student_ids from fees_student fs where     
							   fs.paymentStatus='unpaid' and  
							   fs.accademicsessionId ='$asession' and 
							   fs.classId='$class_id'   and 
							   fs.studentId='$student_id'   and  
							   fs.historyId='$history_id' group by  fs.accademicsessionId , fs.classId , fs.historyId
							    
							    ";
			 
					$rsResults=$os->mq($query);
					$record=$os->mfa( $rsResults);
					 
					 
					 $fees_student_ids=$record['fees_student_ids'];
					 if($fees_student_ids!='')
					 {
					     $del_fees_student_details=" DELETE from fees_student_details  where fees_student_id in( $fees_student_ids )";
						 $os->mq($del_fees_student_details);
						 
						 $del_fees_student=" DELETE from fees_student   where   fees_student_id in( $fees_student_ids )   ";	
					     $os->mq($del_fees_student); 
					 
					 }
			
		 
			   
  
  }
  
  function global_session_setting_months($asession,$class_id)
  {
      global $os;
	  
	   $global_session_setting=$os->rowByField('','global_session_setting','asession',$asession," and class_id ='$class_id' ");
	   
	  
		 
		$session_start_date=$global_session_setting['session_start_date'];
		$session_end_date=$global_session_setting['session_end_date'];
		
		$session_months=array();
		
		if($session_start_date!='' && $session_start_date!='0000-00-00 00:00:00' && $session_end_date!='' && $session_end_date!='0000-00-00 00:00:00')
		{		 
		    $session_months=$os->dateIntervalList($session_start_date,$session_end_date,$intervals='P1M',$format='Ym' ,$modify='+0 Month');
		
		}
	  
	  return $session_months;
	  
  
  }
  
 function check_for_paid_fees($asession,$class_id,$studentId,$historyId,$month,$year,$fees_type) // function not in use
 {
  global $os;  
                 $exist=false;
				 
				 
				    $month_year="   
							fs.month='$month'   and 
							fs.year='$year'  and    ";
					
					if($fees_type=='Admission' || $fees_type=='Readmission'  ) 
					{
					  $month_year="";
					}
 
						 	$query=" select  * from fees_student fs where     
							fs.accademicsessionId ='$asession' and 
							(fs.paymentStatus='paid' or fs.paymentStatus='installment' )  and  
							
							fs.classId='$class_id'   and 
							fs.studentId='$studentId'   and  
							fs.historyId='$historyId'    and 
							$month_year
							fs.feesType  = '$fees_type' 
							
							";
						//	echo	$query."<br>";
			 
					$rsResults=$os->mq($query);
					$record=$os->mfa( $rsResults);
					
					if(isset($record['fees_student_id']))
					{
							  if($record['fees_student_id']>0)
							{
							   $exist=true;
							
							}
					
					
					}
					
					
					
		 return $exist;			 
 
 }
 function check_paid_unpaid_fees($asession,$class_id,$studentId,$historyId,$month,$year,$fees_type)
 {
  global $os;  
                 $exist=false;
				 
				 
				    $month_year="   
							fs.month='$month'   and 
							fs.year='$year'  and    ";
					
					if($fees_type=='Admission' || $fees_type=='Readmission'  ) 
					{
					  $month_year="";
					}
 
						 	$query=" select  * from fees_student fs where     
							fs.accademicsessionId ='$asession' and 
							(fs.paymentStatus='paid' or fs.paymentStatus='installment' or fs.paymentStatus='unpaid' )  and  
							
							fs.classId='$class_id'   and 
							fs.studentId='$studentId'   and  
							fs.historyId='$historyId'    and 
							$month_year
							fs.feesType  = '$fees_type' 
							
							";
						//	echo	$query."<br>";
			 
					$rsResults=$os->mq($query);
					$record=$os->mfa( $rsResults);
					
					if(isset($record['fees_student_id']))
					{
							  if($record['fees_student_id']>0)
							{
							   $exist=true;
							
							}
					
					
					}
					
					
					
		 return $exist;			 
 
 }
 
 function create_fees_payment_row( 
         $studentId,
		 $historyId,
		 $asession,
		 $class_id,
		 $selected_fees_row,
		 $amount_total,
		 $special_discount,
		 $payble_total,
		 $paid_fees_amount,
		 $due_fees_amount,
		 $due_on_fees_student_id,
		 $special_discount_note,
		 $student_fees_amounts,$receipt_no,$payment_options,$paymentNote,$remarks,$paidDate
		 
 
 )  // only one function to create fees payments other funvtion are not used
   {
   		
		
		 
		
		
		global $os;
		if(!is_array($selected_fees_row)){$selected_fees_row=array();}
		$fees_payment_id='';
		$student_fees_amounts_str='';
		if(is_array($student_fees_amounts))
		{ if(count($student_fees_amounts)>0)
				{
				   $student_fees_amounts_str=json_encode($student_fees_amounts);
				
				}
		
		}
		 
		
		 if(trim($paidDate)=='')
		 {
		     $paidDate=$os->now();
		 }
		 
		$fees_student_Ids=implode(',',$selected_fees_row);
        
		$dataToSave=array();
		$dataToSave['studentId']=$studentId;
		$dataToSave['historyId']=$historyId;
		$dataToSave['accademicsessionId']=$asession;
		$dataToSave['classId']=$class_id;
		$dataToSave['paidDate']=$paidDate;
		$dataToSave['paidAmount']=$paid_fees_amount;
		$dataToSave['paybleAmount']=$payble_total;
		$dataToSave['paidBy']= $os->userDetails['adminId'];
		$dataToSave['paymentNote']=$paymentNote;
		$dataToSave['payment_options']=$payment_options;
		$dataToSave['fees_student_Ids']=$fees_student_Ids;
		$dataToSave['fees_months']='';
		$dataToSave['prevDueAmount']='';
		$dataToSave['currentDueAmount']=$due_fees_amount;
		$dataToSave['remarks']=$remarks;
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		$dataToSave['addedDate']=$os->now();
		
		 
		
		$dataToSave['special_discount']=$special_discount;
		$dataToSave['special_discount_note']=$special_discount_note;
		$dataToSave['due_on_fees_student_id']=$due_on_fees_student_id;
		$dataToSave['amount_total']=$amount_total;
		$dataToSave['student_fees_amounts_str']=$student_fees_amounts_str;
		
		
		
		//_d($dataToSave); exit();
				
	 	$fees_payment_id=$os->save('fees_payment',$dataToSave,'fees_payment_id','');
		
		
		if(trim($receipt_no)=='')
		{
			$dataToSave=array();
			$receipt_no= date('Ym').'-'.$fees_payment_id;
		}
		
		
		$dataToSave['receipt_no']=$receipt_no;
		$fees_payment_id=$os->save('fees_payment',$dataToSave,'fees_payment_id',$fees_payment_id);

	   if($fees_payment_id)
	   {
	   
					   foreach($selected_fees_row as $fees_student_id_val)
					   {
					    // here fees_payment_id not need and inserted wrong value it should be multiple value by comma separated like receipt no
						// added new table fees_student_fees_payment to track this record 
						 
						 
						 /// update wave off rows
						 
						   $update_fees_waiveoff=" update fees_waiveoff set 						    
						  fees_payment_id='$fees_payment_id' 						  
					      where  fees_payment_id <1 and fees_student_id='$fees_student_id_val' " ;
					      $os->mq($update_fees_waiveoff);
						  
					     if($fees_student_id_val== $due_on_fees_student_id && $due_fees_amount>0 )
						 {
						  $update_fees_student=" update fees_student set 
						   fees_payment_ids= CONCAT( fees_student.fees_payment_ids ,',', '$fees_payment_id' )  ,  
						  receipt_no= CONCAT( fees_student.receipt_no ,',', '$receipt_no' ) ,
						  paymentStatus='installment' ,
						  currentDueAmount='$due_fees_amount'
					      where  fees_student_id IN($due_on_fees_student_id) " ;
						 }else
						 {
						 $update_fees_student=" update fees_student set 
						 fees_payment_ids= CONCAT( fees_student.fees_payment_ids ,',', '$fees_payment_id' )  ,  
						 receipt_no= CONCAT( fees_student.receipt_no ,',', '$receipt_no' )  ,
						 paymentStatus='paid' ,currentDueAmount='0'
						 where  fees_student_id IN($fees_student_id_val) " ;
						 
						 }
					   
				
						
					   $os->mq($update_fees_student);
					   }
					  
					   

	   }

       return $fees_payment_id;
   }
   
   function  calculate_due($fees_student_id,$totalPayble,$paymentStatus)
   {
    global $os;
	 
	
	 $waved_amount=0;
     $due_amt=0;
	 //  $due_amt=$totalPayble;
	  if($paymentStatus=='installment'   )
	  { 
	     /* $and_fees_payment_id='';
	       if($prev_fees_payment_id)
		   {
		   $and_fees_payment_id=" and fees_payment_id < '$prev_fees_payment_id' ";
		   }*/
	 
	        $fees_details="select  currentDueAmount from fees_payment where due_on_fees_student_id  ='$fees_student_id'  order by fees_payment_id desc limit 1  ";
            $fees_details_rs= $os->mq($fees_details);
            $fees = $os->mfa($fees_details_rs); 
			
			if(isset( $fees['currentDueAmount']))
			{
			  $due_amt=$fees['currentDueAmount'];
			
			}
		} 
	  
		if($paymentStatus=='unpaid')
		{
		   $due_amt=$totalPayble;
		}	 
   
   // waved off amount 
   
   $waved_off_q='';
   if( $paymentStatus=='unpaid' ) // all waived amount
	{ 
			$waved_off_q=" select sum(waive_amount) waved_amount from fees_waiveoff  wo  where wo.fees_student_id='$fees_student_id'    ";
	 
	}
	
	if($paymentStatus=='installment'  ) /// unbilled waved amount
	{	  
			$waved_off_q=" select sum(waive_amount) waved_amount from fees_waiveoff  wo  where wo.fees_student_id='$fees_student_id'  and fees_payment_id<1 ";
	
	}
	
	if($waved_off_q!='')
	{
	   $waved_off_rs=$os->mq($waved_off_q);
		$record=$os->mfa( $waved_off_rs);
		if(isset( $record['waved_amount']))
		{
		$waved_amount=$record['waved_amount'];
		
		}
	
	}
		 
	 
	 $due_amt=$due_amt-$waved_amount;
   
   
   return $due_amt;
   
   }
   
   
  function create_single_fees_student($historyId,$fees_head,$fees_head_amount, $fees_date='')   // medicine  bag etc
  {
       global $os,$site;
	    $history_id=$historyId;
		$historyData=$os->rowByField('','history','historyId',$history_id);
		$studentId=$student_id=  $historyData['studentId'];
		$studentData=$os->rowByField('','student','studentId',$student_id);
		$asession=$historyData['asession'];  
		$class_id=$historyData['class']; 
		if(trim($fees_date)=='')
		{
		
		 $fees_date=$os->now('Y-m-d');
		}
		 
		  
							       			
							    $month=substr($fees_date,5,2);
								$year=substr($fees_date,0,4);
								
				 											
								$totalPayble=0; 
								$dataToSave=array();
								$dataToSave['studentId']=$studentId;
								$dataToSave['feesType']=$fees_head;
								$dataToSave['accademicsessionId']=$asession;
								$dataToSave['classId']=$class_id;
								$dataToSave['month']=$month;
								$dataToSave['year']=$year;
								$dataToSave['historyId']=$historyId;
								$dataToSave['feesdata']='';
								$dataToSave['dueDate']='';
								$dataToSave['amount']=$fees_head_amount;
								$dataToSave['vehicle']=0; 
								$dataToSave['fine']=0;  
								$dataToSave['discountType']=''; // percent,flat
								$dataToSave['discountValue']='';
								$dataToSave['discountAmount']='';
								$dataToSave['totalPayble']=$fees_head_amount;
								$dataToSave['paymentStatus']='unpaid';
								$dataToSave['note']='';
								$dataToSave['dated']=$fees_date.' 00:00:00';
								$dataToSave['addedDate']=$os->now();
								$dataToSave['addedBy']=$os->userDetails['adminId'];
								$fees_student_id=$os->save('fees_student',$dataToSave,'fees_student_id','');
								 	 
						  
						   if($fees_student_id>0)
						   {
									 
									
										$dataToSave2=array();
										$dataToSave2['fees_student_id']=$fees_student_id;
										$dataToSave2['studentId']=$studentId;
										$dataToSave2['feesType']=$fees_head;
										$dataToSave2['accademicsessionId']=$asession;
										$dataToSave2['classId']=$class_id;
										$dataToSave2['month']=$month;
										$dataToSave2['year']=$year;
										$dataToSave2['historyId']=$historyId;
					
										$dataToSave2['fees_head']=$fees_head;
										$dataToSave2['amount']=$fees_head_amount;
										 
										
										$dataToSave2['note']='';
										$dataToSave2['addedDate']=$os->now();
										$dataToSave2['addedBy']=$os->userDetails['adminId'];
										$fees_student_details_id=$os->save('fees_student_details',$dataToSave2,'fees_student_details_id','');
									    
							
							}
							
							
						
  
  }
  
  function receipt_links($receipt_nos)
  {
     global $os,$site;
   
   if(trim($receipt_nos)!='')
	{
	  
	    $receipt_nos_array=explode(',',$receipt_nos);
	    $receipt_nos_array=array_filter($receipt_nos_array);
		$receipt_nos_str="'".implode("','",$receipt_nos_array)."'";
	      $fees_payment_q=" select * from fees_payment where receipt_no IN ($receipt_nos_str)";
	   
				$rsResults=$os->mq($fees_payment_q);
				while($record=$os->mfa( $rsResults))
				{
					?>	 
			<span style="cursor:pointer; margin:0px; border:1px solid #CCCCCC; padding:2px; color:#000066; cursor:pointer; font-size:11px;" onclick="print_receipt_fees(<? echo $record['fees_payment_id'] ?>,'')"> <? echo $record['receipt_no']; ?> </span>  
		         	 
			<? 
				}
	   
	
	}
   
   
  }
  
  function view_waved_off($fees_student_id)
  {  // it can be done without loop function
     global $os,$site;
   
   if($fees_student_id>0)
	{
	  
	  $waved_off_q=" select wo.*, a.name from fees_waiveoff wo, admin a  where wo.fees_student_id='$fees_student_id'  and  wo.admin_id=a.adminId    ";
	  $waved_off_rs=$os->mq($waved_off_q);
	  
	  while($record=$os->mfa( $waved_off_rs))
		{
			 $waive_amount=$record['waive_amount'];
			 $entry_date=$os->showDate($record['entry_date']);
			 $admin_name=$record['name'];
			 
			 $style_wave_amount='background-color:#FFFFCC;';
			 
			 if($record['fees_payment_id']>0)
			 {
			  $style_wave_amount=' background-color:#000066; color:#FFFFFF ;';
			 }
			 
			  
		  $str_details =  " Amount : $waive_amount  , Date :  $entry_date   , By :    $admin_name       ";
		  ?>
		  <span style="font-size:12px;  cursor:pointer;     font-weight:bold; <? echo $style_wave_amount ?>   margin:3px; padding:2px" title="<? echo $str_details ?>"><? echo $waive_amount ?> </span>
		  <?  
		
		}   
	
	
	}
	 
   
   
  }
  
  
  function unbilled_waved_off_data($fees_student_id_array,$history_id)
  {   
   global $os,$site;   
   $res=array();
   
   
   if(count($fees_student_id_array)>0)
	{
	   
	     $waved_off_q=" select wo.*  from fees_waiveoff wo   
	  where wo.fees_student_id IN ( ".implode(',',$fees_student_id_array).") 
	  and history_id='$history_id' and fees_payment_id < 1     ";
	 
	  $waved_off_rs=$os->mq($waved_off_q);
	  
	  $total=0;
	  $str='';
	  while($record=$os->mfa( $waved_off_rs))
		{
			 $waive_amount=$record['waive_amount'];
			 
			 $total=$total+$waive_amount;
		 
		      $res['list_amount'][$record['fees_waiveoff_id']]=$waive_amount;
			  $res['list_data'][$record['fees_waiveoff_id']]=$record;
		    
		
		}   
	
	
	}
	
	 $res['total']=$total;
	 
	 return $res;
   
  }
 
 






