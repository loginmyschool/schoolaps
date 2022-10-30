<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');
include($site['root-wtos'].'barCode.php');
$bCode=new wtbarcode;
$pluginName='';

$os->loadPluginConstant($pluginName);

include($site['root-wtos'].'admission_admin_function_helpers.php');


function form_admission_2($asession,$classList_s,$online_form_id=0)
{
  global $os,$site;
 // type of student //
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

//$online_form_id=2;
if($online_form_id>0)
{
  $formdata= $os->rowByField('','online_form',$fld='online_form_id',$online_form_id,$where='',$orderby='');
  $os->data=$formdata;
 }


// _d( $formdata);




?>
    <div style="position: sticky; top: 0; z-index: 2" class="p-s background-color-white border-none border-bottom-xxs border-color-light-grey">
        <div class="grid">
            <div class="grid-item p-s">
                <h1 >
                    <input readonly onclick="open_editor_tooltip(this)" style="font-size:24px" value="<? echo $os->getVal('name');  ?>" type="text" name="name" id="name" class="border-none font-weight-xxl color-primary full-width" />
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


				<? $image_link= $site['url'].$os->getVal('image');

				 if($os->getVal('image')==''){$image_link= $site['url-wtos'] ."images/student_img.png";}
				 ?>

                    <div style="position:relative; border-radius:10px; width: 185px; height: 185px; background-color: rgba(0,0,255,0); background-position: center; background-repeat: no-repeat; background-image: url('<?php echo $image_link; ?>')" id="imageView">
                        <input type="file" name="image" value=""  id="image" onchange="image_set_background_from_input(this, '#imageView')//os.readURL(this,'imagePreview') " style="display:none;"/>
 <input type="hidden" name="image_data" value="<? echo $os->getVal('image') ?>"  id="image_data"  />
                        <div class="p-m border-radius-xxxl" style="position:absolute; bottom: 10px; right: 10px; background-color: rgba(0,0,0,0.5)">
                            <i style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');" class="mi text-xl">camera_alt</i>
                        </div>

                    </div>

                </div>
            </div>
            <div class="grid-item p-s">
                <div class="p-s">
                    <h3 class="p-m">Academic Information</h3>
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
                                $os->onlyOption($os->board,$os->getVal('board'));	?></select>
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
                                    <? $os->onlyOption($os->gender,$os->getVal('gender'));	?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Caste</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="caste" id="caste" class="border-none font-weight-xxl full-width">
                                    <option value=""> </option>
                                    <? $os->onlyOption($os->caste,$os->getVal('caste'));	?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">APL/BPL</td>
                            <td class="p-s p-right-m" colspan="2">
                                <select name="apl_bpl" id="apl_bpl" class="border-none font-weight-xxl full-width">
                                    <option value=""> </option>
                                    <? $os->onlyOption($os->aplOrBpl,$os->getVal('aplOrBpl'));	?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Date of Birth</td>
                            <td class="p-s p-right-m">
                                <input value="<? echo $os->showDate($os->getVal('dob'));?>" type="text" name="dob" id="dob" class="border-none font-weight-xxl full-width"/>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#dob', 'date')">edit</i>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Aadhaar No.</td>
                            <td class="p-s p-right-m" >
                                <input value="<? echo $os->getVal('adhar_no');   ?>" type="text" name="adhar_no" id="adhar_no" class="border-none font-weight-xxl full-width"/>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#adhar_no')">edit</i>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-s p-left-m">Contact No.</td>
                            <td class="p-s p-right-m" >
                                <input value="<? echo $os->getVal('mobile_student');   ?>" type="text" name="mobile_student" id="mobile_student" class="border-none font-weight-xxl full-width"/>
                            </td>
                            <td class="p-s p-right-m">
                                <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#mobile_student')">edit</i>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

            <textarea value="<? echo $os->getVal('remarks');   ?>" type="text"   name="remarks" id="remarks" class="display-none" ></textarea>
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
                            <input value="<? echo $os->getVal('vill');   ?>" type="text" name="vill" id="vill"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#vill')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Post</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('po');   ?>" type="text" name="po" id="po"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#po')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Police Station</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('ps'); ?>" type="text" name="ps" id="ps"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#ps')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Block</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('block'); ?>" type="text" name="block" id="block"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#block')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">PIN</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('pin'); ?>" type="text" name="pin" id="pin"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#pin')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Dist</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('dist'); ?>" type="text" name="dist" id="dist"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#dist')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">State</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('state'); ?>" type="text" name="state" id="state"/>
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
                            <input value="<? echo $os->getVal('father_name'); ?>" type="text" name="father_name" id="father_name"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#father_name')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Mother's Name</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('mother_name'); ?>" type="text" name="mother_name" id="mother_name"/>
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#mother_name')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Guardian Name</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('guardian_name'); ?>" type="text" name="guardian_name" id="guardian_name" />
                        </td>
                        <td class="p-s p-right-m">
                            <i class="mi text-m color-primary hover-color-secondary pointable" onclick="open_editor_tooltip('#guardian_name')">edit</i>
                        </td>
                    </tr>

                    <tr>
                        <td class="p-s p-left-m">Guardian Occupation</td>
                        <td class="p-s">
                            <input value="<? echo $os->getVal('father_ocu'); ?>" type="text" name="father_ocu" id="father_ocu"/>
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
                    <div  >
                        <h3 class="p-m p-bottom-none">Discount</h3>

                        <div class="p-m">
                            <table style="border-collapse: collapse">
                                <tr>
                                    <td>Admission</td>
                                    <td class="p-left-m"><input  type="text" id="discountTypeAdmission" value="<? echo $os->getVal('discountTypeAdmission'); ?>"  readonly="readonly" class="border-none" style="width: 20px"/></td>
                                    <td class="p-left-m ">
                                        <input type="text" id="discountValueAdmission" value="<? echo $os->getVal('discountValueAdmission'); ?>"  readonly="readonly" class="border-none color-flat-green"/>
                                    </td>

                                </tr>

                                <tr>
                                    <td class="p-top-s">Monthly</td>
                                    <td class="p-top-s p-left-m"><input type="text" id="discountTypeMonthly" value="<? echo $os->getVal('discountTypeMonthly'); ?>"  readonly="readonly" class="border-none" style="width: 20px"/></td>
                                    <td class="p-top-s p-left-m ">
                                        <input type="text" id="discountValueMonthly" value="<? echo $os->getVal('discountValueMonthly'); ?>"  readonly="readonly" class="border-none color-flat-green"/>
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
                                    $os->onlyOption($os->subcast,$os->getVal('subcast'));	?></select>	 </td>
                        </tr>
                        <tr >
                            <td>Adhar Name </td>
                            <td><input value="<? echo $os->getVal('adhar_name'); ?>" type="text" name="adhar_name" id="adhar_name" class="textboxxx  fWidth "/>
                            </td>
                        </tr>
                        <tr >
                            <td>Adhar Dob </td>
                            <td><input value="<? echo $os->getVal('adhar_dob'); ?>" type="text" name="adhar_dob" id="adhar_dob" class="wtDateClass textbox
fWidth"/></td>
                        </tr>






                        <tr >
                            <td>PH </td>
                            <td>

                                <select name="ph" id="ph" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->yesno,$os->getVal('ph'));	?></select>	 </td>
                        </tr><tr >
                            <td>PH % </td>
                            <td><input value="<? echo $os->getVal('ph_percent'); ?>" type="text" name="ph_percent" id="ph_percent" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Disable </td>
                            <td>

                                <select name="disable" id="disable" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->yesno,$os->getVal('disable'));	?></select>	 </td>
                        </tr><tr >
                            <td>Disable % </td>
                            <td><input value="<? echo $os->getVal('disable_percent'); ?>" type="text" name="disable_percent" id="disable_percent" class="textboxxx  fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Tc No </td>
                            <td><input value="<? echo $os->getVal('tc_no'); ?>" type="text" name="tc_no" id="tc_no" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Tc Date </td>
                            <td><input value="<? echo $os->getVal('tc_date'); ?>" type="text" name="tc_date" id="tc_date" class="wtDateClass textbox fWidth"/></td>
                        </tr>


                        <tr >
                            <td>Full marks </td>
                            <td><input value="<? echo $os->getVal('full_marks'); ?>" type="text" name="full_marks" id="full_marks" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Obtain marks </td>
                            <td><input value="<? echo $os->getVal('obtain_marks'); ?>" type="text" name="obtain_marks" id="obtain_marks" class="textboxxx  fWidth
"/> </td>
                        </tr>

                    </table>
                    <table   border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable"   >

                        <tr >
                            <td>Percentage </td>
                            <td><input value="<? echo $os->getVal('percentage'); ?>" type="text" name="percentage" id="percentage" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Pass </td>
                            <td>

                                <select name="pass_fail" id="pass_fail" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->pass_fail,$os->getVal('pass_fail'));	?></select>	 </td>
                        </tr><tr >
                            <td>Grade </td>
                            <td><input value="<? echo $os->getVal('grade'); ?>" type="text" name="grade" id="grade" class="textboxxx  fWidth "/> </td>

                        </tr>




                        <tr >
                            <td>Note </td>
                            <td><textarea  name="studentRemarks" id="studentRemarks" ><? echo $os->getVal('studentRemarks'); ?></textarea></td>

                        </tr>








                        <tr >
                            <td>age </td>
                            <td><input value="<? echo $os->getVal('age'); ?>" type="text" name="age" id="age" class="textboxxx  fWidth "/>



                            </td>
                        </tr>


                        <tr >
                            <td>Email Student </td>
                            <td><input value="<? echo $os->getVal('email_student'); ?>" type="text" name="email_student" id="email_student" class="textboxxx  fWidth
"/> </td>
                        </tr>

                        <tr >
                            <td>Fees Payment </td>
                            <td>
                                <select name="feesPayment" id="feesPayment" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->feesPayment,$os->getVal('feesPayment'));	?></select>	 </td>
                        </tr>

                        <tr >
                            <td>Religian </td>
                            <td><input value="<? echo $os->getVal('religian'); ?>" type="text" name="religian" id="religian" class="textboxxx  fWidth "/> </td>
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
                            <td><input value="<? echo $os->getVal('online_form_id'); ?>" type="text" name="admission_no" id="admission_no" class="textboxxx  fWidth "/> </td>
                        </tr>






                        <tr >
                            <td>Mobile Emergency </td>
                            <td><input value="<? echo $os->getVal('mobile_emergency'); ?>" type="text" name="mobile_emergency" id="mobile_emergency" class="textboxxx  fWidth "/> </td>

                        </tr><tr >
                            <td>Email Guardian </td>
                            <td><input value="<? echo $os->getVal('email_guardian'); ?>" type="text" name="email_guardian" id="email_guardian" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Mother Tongue </td>
                            <td><input value="<? echo $os->getVal('mother_tongue'); ?>" type="text" name="mother_tongue" id="mother_tongue" class="textboxxx  fWidth "/> </td>
                        </tr>
                        <tr >
                            <td>Blood Group </td>
                            <td><input value="<? echo $os->getVal('blood_group'); ?>" type="text" name="blood_group" id="blood_group" class="textboxxx  fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Guardian Ocu </td>
                            <td><input value="<? echo $os->getVal('guardian_ocu'); ?>" type="text" name="guardian_ocu" id="guardian_ocu" class="textboxxx  fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Father Adhar </td>
                            <td><input value="<? echo $os->getVal('father_adhar'); ?>" type="text" name="father_adhar" id="father_adhar" class="textboxxx  fWidth"/> </td>
                        </tr><tr >
                            <td>Mother Ocu </td>
                            <td><input value="<? echo $os->getVal('mother_ocu'); ?>" type="text" name="mother_ocu" id="mother_ocu" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Mother Adhar </td>
                            <td><input value="<? echo $os->getVal('mother_adhar'); ?>" type="text" name="mother_adhar" id="mother_adhar" class="textboxxx  fWidth"/> </td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm MoreStudentDatatable">
                        <tr >
                            <td>Acc No</td>
                            <td><input value="<? echo $os->getVal('accNo'); ?>" type="text" name="accNo" id="accNo" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Acc Holder Name </td>
                            <td><input value="<? echo $os->getVal('accHolderName'); ?>" type="text" name="accHolderName" id="accHolderName" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>IFSC Code </td>
                            <td><input value="<? echo $os->getVal('ifscCode'); ?>" type="text" name="ifscCode" id="ifscCode" class="textboxxx  fWidth "/> </td>
                        </tr><tr >
                            <td>Branch </td>
                            <td><input value="<? echo $os->getVal('branch'); ?>" type="text" name="branch" id="branch" class="textboxxx  fWidth "/> </td>
                        </tr>

                        <tr >
                            <td>Outgoing TC No</td>
                            <td><input value="<? echo $os->getVal('outGoingTcNo'); ?>" type="text" name="outGoingTcNo" id="outGoingTcNo" class="textboxxx  fWidth "/> </td>
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
                            <td><input value="<? echo $os->getVal('guardian_relation'); ?>" type="text" name="guardian_relation" id="guardian_relation" class="textboxxx fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Guardian Address </td>
                            <td><input value="<? echo $os->getVal('guardian_address'); ?>" type="text" name="guardian_address" id="guardian_address" class="textboxxx
fWidth "/> </td>
                        </tr>

                        <tr >
                            <td>Anual Income </td>
                            <td><input value="<? echo $os->getVal('anual_income'); ?>" type="text" name="anual_income" id="anual_income" class="textboxxx  fWidth
"/> </td>
                        </tr>
                        <tr >
                            <td>Mobile Guardian </td>
                            <td><input value="<? echo $os->getVal('mobile_guardian'); ?>" type="text" name="mobile_guardian" id="mobile_guardian" class="textboxxx
fWidth "/> </td>
                        </tr>


                        <tr >
                            <td>Other Religian </td>
                            <td><input value="<? echo $os->getVal('other_religian'); ?>" type="text" name="other_religian" id="other_religian" class="textboxxx fWidth
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
                                    $os->onlyOption($os->yesno,$os->getVal('minority'));	?></select>	 </td>
                        </tr>


                        <tr >
                            <td>Kanyashree </td>
                            <td>
                                <select name="kanyashree" id="kanyashree" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->kanyashree,$os->getVal('kanyashree'));	?></select>	 </td>
                        </tr>

                        <tr >
                            <td>Yuvashree </td>
                            <td>
                                <select name="yuvashree" id="yuvashree" class="textbox fWidth" ><option value=""> </option>	<?
                                    $os->onlyOption($os->yuvashree,$os->getVal('yuvashree'));	?></select>	 </td>
                        </tr>

                        <tr >
                            <td>Last School </td>
                            <td><input value="<? echo $os->getVal('last_school'); ?>" type="text" name="last_school" id="last_school" class="textboxxx  fWidth "/>
                            </td>
                        </tr><tr >
                            <td>Last Class </td>
                            <td><input value="<? echo $os->getVal('last_class'); ?>" type="text" name="last_class" id="last_class" class="textboxxx  fWidth "/>
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

function list_admission_todo_2($asession,$classList_s)
{
global $os,$site;
$asession=$asession;
$classList_s=$classList_s;
     //$listingQuery="  select * from online_form where status='Approved' and   asession='$asession' and  class_id='$classList_s' ";



	//history`.`admission_no`

	 $alreadyadmitted="select h.admission_no from history h where    h.asession='$asession' and  h.class='$classList_s' and  h.admission_no>0 ";

      $listingQuery="select * from online_form of where    of.asession='$asession' and  of.class_id='$classList_s' and of.status='Approved' and of.online_form_id NOT IN($alreadyadmitted) ";


	//$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$os->mq($listingQuery);


	?>

	<div class="background-color-white">
        <div class="text-m p-m" style="position: sticky; top: 0; background-color: rgb(168, 255, 196)">
            Session:<? echo $asession; ?> Class:<? echo $os->val($os->classList,$classList_s); ?>
        </div>
        <table class="background-color-white" style="border-collapse: collapse">
            <?php

            $serial=0;

            while($record=$os->mfa( $rsRecords)){
                $serial++;
                ?>
                <tr style="border-bottom:1px solid #eeeeee; cursor: pointer" class="hover-background-color-light-grey" onclick="step1();admission_admin('<?php echo $record['online_form_id']; ?>');">

				  <td class="text-xm">
				  <?php echo $serial; ?>
				  </td>


                    <td class="p-m" style="vertical-align: top" width="60px">
					<?php if( $record['image']!=''){ ?>  <img src="<? echo $site['url'].$record['image'];?> " height="60" />  <? } ?>

                       <!-- <div class="list-view-dp color-white" style="">
                             <p class="text-m"><?php echo $serial; ?></p>

                        </div> -->
                    </td>


                    <td class="p-top-m p-bottom-m p-right-m v-align-top">
                        <h4 class="p-bottom-s"><?php echo $record['name'] ?></h4>
                        <table style="border-collapse: collapse;" class="text-xs">
                            <tr>
                                <td>ID</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['online_form_id']; ?></b></td>

                                <td class="p-left-m">Last class</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><? if(isset($os->section[$record['last_class_id']])){ echo  $os->section[$record['last_class_id']]; } ?></b> </td>

                            </tr>
                            <tr>
                                <td>Session</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td><b class="color-flat-blue"><?php echo $record['asession']; ?></b></td>

                                <td class="p-left-m">Admission</td>
                                <td class="p-left-xs p-right-xs"> : </td>
                                <td >
                                    <b class="color-flat-blue">
                                        <? if(isset($os->classList[$record['class_id']])){ echo  $os->classList[$record['class_id']]; } ?>
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





if($os->get('admission_admin')=='OK' && $os->post('admission_admin')=='OK')
{

 $asession=$os->post('asession');
 $classList_s=$os->post('classList_s');
 $online_form_id=$os->post('online_form_id');

echo '##--ADMISSION-FORM-page1--##';
form_admission_2($asession, $classList_s ,$online_form_id);
echo '##--ADMISSION-FORM-page1--##';

echo '##--ADMISSION-FORM-page2--##';
//  echo 'not in use this section';
echo '##--ADMISSION-FORM-page2--##';


echo '##--ADMISSION-STUDENT-list--##';
  list_admission($asession, $classList_s);
echo '##--ADMISSION-STUDENT-list--##';

echo '##--meritlist-list-for-admission--##';
  list_admission_todo_2($asession, $classList_s);
echo '##--meritlist-list-for-admission--##';


exit();
}




if($os->get('payment_details')=='OK' && $os->post('payment_details')=='OK')
{


		$asession=$os->post('asession');
		$class=$classList_s=$os->post('classList_s');
		$student_type=$os->post('student_type');
		$admission_date=$os->post('admission_date');
		$vehicle_price=$os->post('vehicle_price');
		$vehicle_distance_id=$os->post('vehicle_distance_id');
		$vehicle_type_id=$os->post('vehicle_type_id');
		$vehicle=$os->post('vehicle');
		$name=$os->post('name');

		$discountTypeAdmission=$os->post('discountTypeAdmission');
		$discountValueAdmission=$os->post('discountValueAdmission');
		$discountTypeMonthly=$os->post('discountTypeMonthly');
		$discountValueMonthly=$os->post('discountValueMonthly');

		$donation=$os->post('donation');
		$donation_installment=$os->post('donation_installment');
		$donation_amount_paid=$os->post('donation_amount_paid');
		$pending_donation=$donation - $donation_amount_paid;


		$feesType='Admission';
		$config_array=array();
		//  and student_type='$student_type'

		$config_array= getFeesConfig($asession,$class,$student_type);
		//$os->feesBoxDesign('Admission',$config_array['Admission']);


		$admissionFees=array_sum($config_array['Admission']);
		$only_monthly_fees=array_sum($config_array['Monthly']);
		if($vehicle=='1'){ $config_array['Monthly']['Vehicle']=$vehicle_price;}
		$total_monthly_fees=array_sum($config_array['Monthly']); // no discount on vehicle

		$month_academic=$os->month_academic($asession,$class,$admission_date);


		 $discountAmount_admission=calculate_discount($discountTypeAdmission,$discountValueAdmission,$admissionFees);


		 $discountAmount_monthly=calculate_discount($discountTypeMonthly,$discountValueMonthly,$only_monthly_fees);







		//fees month calculation----
		$totalfees=$admissionFees-$discountAmount_admission;

		echo '##--PAYMENT-FORM--##';

		//_d($discountTypeMonthly);
		//_d($discountValueMonthly);
		///_d($only_monthly_fees);



		?>

    <div style="position: sticky; top: 0; z-index: 2" class="p-s background-color-white border-none border-bottom-xxs border-color-light-grey">
        <div class="grid">
            <div class="grid-item p-s">
                <h1 style="font-size: 24px" class="text-xxl color-primary"><? echo $name;?></h1>
                <p >
                    Session : <? echo $asession;?>
                </p>
            </div>

            <div class="p-s grid-item" style="max-width: 170px;display:flex; align-items: center; justify-content: flex-end">
                <button type="button" class="material-button" onclick="step1();">
                    <i class="la la-arrow-left"></i>
                    <span>BACK</span>
                </button>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="grid-item p-m" style="max-width: 200px">

                <h3 class="p-s font-weight-m">Fees Structure</h3>
                <div style="max-height: 350px; overflow-y: auto">
                    <h4 class="p-s">Admission</h4>
                    <div class="p-s">
                        <? $os->feesBoxDesignForAdmission('Admission',$config_array['Admission']);?>
                    </div>
                    <h4 class="p-s">Monthly</h4>
                    <div class="p-s">
                        <? $os->feesBoxDesignForAdmission('Monthly',$config_array['Monthly']); ?>
                    </div>
                </div>

        </div>
        <div class="grid-item p-m" style="max-width: 280px">
            <h3 class="p-s font-weight-m">Monthly Fees</h3>
            <div   style="height: calc(100% - 40px); display: grid; grid-template-columns: repeat(2, auto); grid-template-rows: repeat(6, auto)" >

                <? foreach($month_academic as $key=>$val) {
                    $month=$val['month_str'];
                    $year=$val['year'];

                    ?>
                    <div class="p-s month-selector">
                        <label for="month<? echo $key ?>">
                            <input  type="checkbox" id="month<? echo $key ?>" value="<? echo $val['month_int'] ?>-<? echo $val['year'] ?>" name="month_academic[]" onchange="select_months_for_bill()"/>

                            <div class=" p-m">
                                <? echo  $month ?>, <? echo $year ?>
                                <span class="display-block color-primary m-top-s text-m">Rs. <? echo $total_monthly_fees; ?></span>
                            </div>

                        </label>
                    </div>

                <? } ?>
                <style>
                    .month-selector{

                        position: relative;
                    }
                    .month-selector input{
                        position: absolute;
                        bottom: 10px;
                        right: 10px;
                    }
                    .month-selector input::after{
                        content: '\f00c';
                        font-family: "Line Awesome Free";
                        font-weight: 900;
                        position: absolute;
                        top: 0;
                        right: 0;
                        height: calc(100% - 4px);
                        width: calc(100% - 4px);
                        background-color: white;
                        border:2px solid #666666;
                        font-size: var(--text-m);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: transparent;
                        border-radius: 3px;
                    }
                    .month-selector input:checked::after{
                        border:0px;
                        height: 100%;
                        width: 100%;
                        background-color: var(--color-primary);
                        color: white;
                    }
                    .month-selector input + div{
                        border: 1px solid #eeeeee;
                        background-color: #fafafa;
                        cursor: pointer;
                        font-weight: 600;
                        text-transform: uppercase;
                        font-size: var(--text-s)
                    }
                    .month-selector input + div:hover{
                        border: 1px solid #eeeeee;
                        background-color: #eeeeee;
                        cursor: pointer;
                    }
                    .month-selector input:checked + div{
                        border: 1px solid rgba(0,0,255,0.2);
                        background-color: rgba(0,0,255,0.2);
                    }
                </style>
            </div>
        </div>
        <div class="grid-item p-m" >
            <h3 class="p-s font-weight-m">Academic Information</h3>


            <div class="p-s">
                <table style="border-collapse: collapse; width: 100%" class="border-less-input-table">
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s color-deep-grey">Admission Fees</td>
                        <td class="p-top-s p-bottom-s  color-primary" colspan="2">
                            <input type="text" id="admission_fees_amount" value="<? echo $admissionFees; ?>"  readonly="readonly" class="color-primary full-width right" />
                        </td>
                    </tr>






                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">- Discount Asmission <? echo $discountValueAdmission  ?> <? echo $discountTypeAdmission  ?> </td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="admission_discount_amount" value="<? echo $discountAmount_admission; ?>"  readonly="readonly"  class="color-primary full-width right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey" style="display: none" id="total_monthly_row">
                        <td class="p-top-s p-bottom-s ">+ Monthly  <b> <? echo $only_monthly_fees; ?> x <span id="total_month_count"> </span> </b></td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="monthly_total_fees_amount" readonly="readonly"  class="color-primary full-width right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey"  style="display: none"  id="total_monthly_discount_row">
                        <td class="p-top-s p-bottom-s ">- Monthly Discount <b><? echo $discountValueMonthly  ?> <? echo $discountTypeMonthly  ?> x <span id="total_month_count_discount"> </span> </b></td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="monthly_total_discount_amount" readonly="readonly"  class="color-primary right" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">Total Payble</td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="totalfees" value="<? echo $totalfees; ?>" readonly="readonly"  class="color-red full-width right text-l" style="color:#FF0000;" />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">Paid</td>
                        <td class="p-top-s p-bottom-s right" colspan="2">
                            <input type="text" id="paid_amount" style="width: 80px; border: 1px dashed #666666" class="font-weight-xxl text-l color-primary right border-xxs" placeholder="Paid" onkeyup="select_months_for_bill()"  />
                        </td>
                    </tr>
                    <tr class="border-none border-bottom-xxs border-color-light-grey">
                        <td class="p-top-s p-bottom-s ">Due</td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="due_amount"  readonly="readonly"  value="<? echo $totalfees; ?>"   class="color-primary full-width right"  />
                        </td>
                    </tr>


                    <tr>
                        <td class="p-top-s p-bottom-s ">Payment Notes</td>
                        <td class="p-top-s p-bottom-s " colspan="2">
                            <input type="text" id="payment_note"  class="border-none font-weight-xxl full-width right" />
                        </td>
                    </tr>

					  <tr class="border-none border-bottom-xxs border-color-light-grey"  style="<?php if ($donation>0){}else{ echo 'display:none;';  }?> " >
                        <td class="p-top-s p-bottom-s ">Donation payment if any<br /> Amount: <? echo $donation ?></td>
                        <td class="p-top-s p-bottom-s right" colspan="2">
                            <input type="text" id="donation_amount_paid" style="width: 80px; border: 1px dashed #666666" class="font-weight-xxl text-l color-primary right border-xxs" placeholder=""  />
                        </td>
                    </tr>


                </table>
            </div>
            <div class="" >
                <div id="monthly_data" >
                    <input type="text" id="monthly_single_fees_amount" value="<? echo $total_monthly_fees; ?>" readonly="readonly" class="disabled_input" style="display:none;" />
                    <input type="text" id="monthly_single_discount_amount" value="<? echo $discountAmount_monthly; ?>"  readonly="readonly" class="disabled_input"  style="display:none;"  />
                </div>

                <span class="p-s" style="color:green">Monthly fees can be added with this payment.</span>

                <span class="p-s display-inline-block">
                    <button id="admission_process_button" type="button" onclick="admission_process()" class="material-button big">Generate Receipt</button>
                </span>






                <div id="admission_process_DIV">
                    <!-- button link -->
                </div>
            </div>
        </div>
    </div>

<?

  echo '##--PAYMENT-FORM--##';




exit();
}



if($os->get('admission_process')=='OK' && $os->post('admission_process')=='OK')
{
    $paid_amount=$os->post('paid_amount');

    // payment-parameters---------------------------

	$discountTypeAdmission=$os->post('discountTypeAdmission');
	$discountValueAdmission=$os->post('discountValueAdmission');
	$discountTypeMonthly=$os->post('discountTypeMonthly');
	$discountValueMonthly=$os->post('discountValueMonthly');

	$donation=$os->post('donation');
	$donation_installment=$os->post('donation_installment');
	$donation_amount_paid=$os->post('donation_amount_paid');


	$month_academic_list_selected=$os->post('month_academic_list');
	$payment_note=$os->post('payment_note');
	$asession=$os->post('asession');
	$classList_s=$os->post('classList_s');

	$student_type=$os->post('student_type');
	$admission_date=$os->post('admission_date');
	$vehicle_price=$os->post('vehicle_price');
	$vehicle_distance_id=$os->post('vehicle_distance_id');
	$vehicle_type_id=$os->post('vehicle_type_id');
	$vehicle=$os->post('vehicle');
	if(!$vehicle)
	{
		$vehicle_price=0;
		$vehicle_distance_id=0;
		$vehicle_type_id='';

	}



	$building_name=$os->post('building_name');
	$floor_name=$os->post('floor_name');
	$room_name=$os->post('room_name');
	$bed_no=$os->post('bed_no');
	$hostel_room_id=$os->post('hostel_room_id');

	$class=$os->post('class');
	$admission_date=$os->saveDate($os->post('admission_date'));


 //------------HISTORY DATA------
	$dataToSave['discountTypeAdmission']=$discountTypeAdmission;
	$dataToSave['discountValueAdmission']=$discountValueAdmission;
	$dataToSave['discountTypeMonthly']=$discountTypeMonthly;
	$dataToSave['discountValueMonthly']=$discountValueMonthly;

	$dataToSave['donation']=$donation;
	$dataToSave['donation_installment']=$donation_installment;

	$dataToSave['asession']=addslashes($os->post('asession'));
	$dataToSave['registrationNo']=addslashes($os->post('registerNo'));
	$dataToSave['class']=addslashes($os->post('class'));
	$dataToSave['section']=addslashes($os->post('section'));
	$dataToSave['admission_date']=$os->saveDate($os->post('admission_date'));
	$dataToSave['roll_no']=addslashes($os->post('roll_no'));
	$dataToSave['board']=addslashes($os->post('board'));
	$dataToSave['formNo']=addslashes($os->post('formNo'));
	$dataToSave['inactiveDate']=$os->saveDate($os->post('inactiveDate'));
	$dataToSave['stream']=addslashes($os->post('stream'));
	$dataToSave['admissionType']='Admission';//'';
	$dataToSave['student_type']=$student_type;
	$dataToSave['vehicle']=$vehicle;
	$dataToSave['vehicle_type_id']=$vehicle_type_id;
	$dataToSave['vehicle_distance_id']=$vehicle_distance_id;
	$dataToSave['vehicle_price']=$vehicle_price;
	$dataToSave['historyStatus']='Active';
	$dataToSave['building_name']=$building_name;
	$dataToSave['floor_name']=$floor_name;
	$dataToSave['room_name']=$room_name;
	$dataToSave['bed_no']=$bed_no;
	$dataToSave['hostel_room_id']=$hostel_room_id;


    $dataToSave['admission_no']=$os->post('admission_no'); // form_no form no
 //------------END HISTORY DATA------

  //------------STUDENT DATA------
	$dataToSave_2['accNo']=addslashes($os->post('accNo'));
	$dataToSave_2['accHolderName']=addslashes($os->post('accHolderName'));
	$dataToSave_2['ifscCode']=addslashes($os->post('ifscCode'));
	$dataToSave_2['branch']=addslashes($os->post('branch'));
	$dataToSave_2['kanyashree']=addslashes($os->post('kanyashree'));
	$dataToSave_2['yuvashree']=addslashes($os->post('yuvashree'));
	$dataToSave_2['board']=addslashes($os->post('board'));
	$dataToSave_2['feesPayment']=addslashes($os->post('feesPayment'));
	$dataToSave_2['name']=addslashes($os->post('name'));
	$dataToSave_2['dob']=$os->saveDate($os->post('dob'));
	$dataToSave_2['age']=addslashes($os->post('age'));
	$dataToSave_2['gender']=addslashes($os->post('gender'));
	$dataToSave_2['registerDate']=$os->saveDate($os->post('registerDate'));
	$dataToSave_2['registerNo']=addslashes($os->post('registerNo'));
	$dataToSave_2['uid']=addslashes($os->post('uid'));
	$dataToSave_2['caste']=addslashes($os->post('caste'));
	$dataToSave_2['subcast']=addslashes($os->post('subcast'));
	$dataToSave_2['apl_bpl']=addslashes($os->post('apl_bpl'));
	$dataToSave_2['minority']=addslashes($os->post('minority'));
	$dataToSave_2['adhar_name']=addslashes($os->post('adhar_name'));
	$dataToSave_2['adhar_dob']=$os->saveDate($os->post('adhar_dob'));
	$dataToSave_2['adhar_no']=addslashes($os->post('adhar_no'));
	$dataToSave_2['ph']=addslashes($os->post('ph'));
	$dataToSave_2['ph_percent']=addslashes($os->post('ph_percent'));
	$dataToSave_2['disable']=addslashes($os->post('disable'));
	$dataToSave_2['disable_percent']=addslashes($os->post('disable_percent'));
	$dataToSave_2['father_name']=addslashes($os->post('father_name'));
	$dataToSave_2['father_ocu']=addslashes($os->post('father_ocu'));
	$dataToSave_2['father_adhar']=addslashes($os->post('father_adhar'));
	$dataToSave_2['mother_name']=addslashes($os->post('mother_name'));
	$dataToSave_2['mother_ocu']=addslashes($os->post('mother_ocu'));
	$dataToSave_2['mother_adhar']=addslashes($os->post('mother_adhar'));
	$dataToSave_2['vill']=addslashes($os->post('vill'));
	$dataToSave_2['po']=addslashes($os->post('po'));
	$dataToSave_2['ps']=addslashes($os->post('ps'));
	$dataToSave_2['dist']=addslashes($os->post('dist'));
	$dataToSave_2['block']=addslashes($os->post('block'));
	$dataToSave_2['pin']=addslashes($os->post('pin'));
	$dataToSave_2['state']=addslashes($os->post('state'));
	$dataToSave_2['guardian_name']=addslashes($os->post('guardian_name'));
	$dataToSave_2['guardian_relation']=addslashes($os->post('guardian_relation'));
	$dataToSave_2['guardian_address']=addslashes($os->post('guardian_address'));
	$dataToSave_2['guardian_ocu']=addslashes($os->post('guardian_ocu'));
	$dataToSave_2['anual_income']=addslashes($os->post('anual_income'));
	$dataToSave_2['mobile_student']=addslashes($os->post('mobile_student'));
	$dataToSave_2['mobile_guardian']=addslashes($os->post('mobile_guardian'));
	$dataToSave_2['mobile_emergency']=addslashes($os->post('mobile_emergency'));
	$dataToSave_2['email_student']=addslashes($os->post('email_student'));
	$dataToSave_2['email_guardian']=addslashes($os->post('email_guardian'));
	$dataToSave_2['mother_tongue']=addslashes($os->post('mother_tongue'));
	$dataToSave_2['blood_group']=addslashes($os->post('blood_group'));
	$dataToSave_2['religian']=addslashes($os->post('religian'));
	$dataToSave_2['other_religian']=addslashes($os->post('other_religian'));
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave_2['image']='wtos-images/'.$image;



							/*include('imge_resize_class.php');
							$target_file =$site['root'].$dataToSave_2['image'];
					        $image_o = new SimpleImage();
							$image_o->load($target_file);
							$image_o->resizeToHeight(100);
							$image_o->save($target_file);*/



					}else
					{
					$dataToSave_2['image']=$os->post('image_data');


					}



	$dataToSave_2['last_school']=addslashes($os->post('last_school'));
	$dataToSave_2['last_class']=addslashes($os->post('last_class'));
	$dataToSave_2['tc_no']=addslashes($os->post('tc_no'));
	$dataToSave_2['tc_date']=$os->saveDate($os->post('tc_date'));
	$dataToSave_2['studentRemarks']=addslashes($os->post('studentRemarks'));
	$dataToSave_2['otpPass']=rand(1000, 9999);


 //------------END STUDENT DATA------

	$dataToSave['addedDate']=$os->now();
	$dataToSave['addedBy']=$os->userDetails['adminId'];
	$hide_button='';
if( $paid_amount>0)
 {
	$studentId=$os->save('student',$dataToSave_2,'studentId','');


		// sync data

		if($studentId)
		{
				global $site,$bridge;

				$school_setting_data= $os->school_setting();
				$data_sync['school_name']=addslashes($school_setting_data['school_name']);
				$data_sync['school_address']=addslashes($school_setting_data['address']);
				$data_sync['schoolCode']=$school_setting_data['schoolCode'];
				$data_sync['school_id']=$school_setting_data['school_id'];
				$data_sync['name']=$dataToSave_2['name'];
				$data_sync['mobile']=$dataToSave_2['mobile_student'];
				$data_sync['login_username']=$dataToSave_2['mobile_student'];
				$data_sync['login_password']=$dataToSave_2['otpPass'];
				$data_sync['action']='addNewStudent_sync';
				$data_sync['studentId']=$studentId;
				$data_sync['table']='student';
				$data_sync['addedBy']=$dataToSave['addedBy'];
				$data_sync['database_single']=$site['db'];
				$outputsync=$bridge->sync_portal_and_single('portal',$data_sync);
         }



	/// barcode 66677
	$filepath=$site['root'].'barCode/';
	 $bCode->barcode($studentId,$filepath);
	/// barcode 66677
	$updateUidQuery="update student set uid='$studentId' where studentId='$studentId'";
	$os->mq($updateUidQuery);
	$dataToSave['studentId']=$studentId;
	$qResult=$os->save('history',$dataToSave,'historyId','');///    allowed char '\*#@/"~$^.,()|+_-=:��

	$historyId=$qResult;

 // get fees details
	$config_array= getFeesConfig($asession,$class,$student_type);
	$global_setting=getGlobalConfig($asession,$class);
	$hide_button='OK';
	$fees_student_id_array=  createFeesRecord($studentId,$historyId,$config_array,$global_setting,$feesType='Admission',$month_academic_list_selected);
	$paymentData= createPayment($fees_student_id_array,$historyId,$studentId,$paid_amount,$payment_note);

	$fees_student_id_array_donation= createFeesRecord_donation($studentId,$historyId) ;
	if($donation_amount_paid>0)
	{
    	$paymentData_donation= createPayment_donation($fees_student_id_array_donation,$historyId,$studentId,$donation_amount_paid,$payment_note='Donation-installment');
	}



	}
	echo '##--admission_process--##';

	if( $paid_amount>0){

		?>  <div onclick="print_receipt_fees(<? echo $paymentData['fees_payment_id'] ?>,'')" style="padding:10px; background-color:#009900; color:#FFFFFF; cursor:pointer;"> <? echo $paymentData['receipt_no'] ?> |<? echo $os->showDate($paymentData['paidDate']) ?> |<? echo $paymentData['paidAmount'] ?></div>


		<?
	}else
	{
	?>
		echo 'No payment enter. Please close and retry again.'; <div style="color:#000066;" class="close_registration_process" onclick="step1();admission_admin();"> Close </div>
	 <?
	}

	if( $donation_amount_paid>0){

		?>  <div onclick="print_receipt_fees(<? echo $paymentData_donation['fees_payment_id'] ?>,'')" style="padding:10px; background-color:#009900; color:#FFFFFF; cursor:pointer;"> <? echo $paymentData_donation['receipt_no'] ?> |<? echo $os->showDate($paymentData_donation['paidDate']) ?> |<? echo $paymentData_donation['paidAmount'] ?></div>


		<?
	}
?>
  <div style="color:#000066;" class="close_registration_process" onclick="step1();admission_admin('');"> Close </div>
  <?
	echo '##--admission_process--##';

	echo '##--admission_process_button--##';
	echo  $hide_button;
	echo '##--admission_process_button--##';


	echo '##--ADMISSION-STUDENT-list--##';
	list_admission($asession, $classList_s);
	echo '##--ADMISSION-STUDENT-list--##';

	echo '##--meritlist-list-for-admission--##';
	list_admission_todo_2($asession, $classList_s);
	echo '##--meritlist-list-for-admission--##';
	exit();
}



if($os->get('calculate_room_no')=='OK' && $os->post('calculate_room_no')=='OK')
{
	$asession=$os->post('asession');
	$class_id=$os->post('class_id');
	$section=$os->post('section');
	$roomdata=calculate_room_no_function($asession,$class_id,$section);

	$building_name=$roomdata['building_name'];
	$floor_name=$roomdata['floor_name'];
	$bed_no=$roomdata['bed_no'];
	$hostel_room_id=$roomdata['hostel_room_id'];
	$room_name=$roomdata['room_name'];

	echo '##--calculate_room-building_name--##'; echo $building_name;  echo '##--calculate_room-building_name--##';
	echo '##--calculate_room-floor_name--##'; echo $floor_name;  echo '##--calculate_room-floor_name--##';
	echo '##--calculate_room-room_name--##'; echo $room_name;  echo '##--calculate_room-room_name--##';
	echo '##--calculate_room-bed_no--##'; echo $bed_no;  echo '##--calculate_room-bed_no--##';
	echo '##--calculate_room-hostel_room_id--##'; echo $hostel_room_id;  echo '##--calculate_room-hostel_room_id--##';
exit();

}
if($os->get('calculate_room_no---------------notused---------------------')=='OK' && $os->post('calculate_room_no')=='OK')
{




	/*
	$building_name='';
	$floor_name='';
	$room_name='';
	$bed_no='';
	$hostel_room_id='';

	$total_bed_list_id=array();
	$used_bed_list_id=array();
	$remains_bed_list_id=array();



	 // get used bed list-- hostel_room_id

    $dataQuery="SELECT bed_no,hostel_room_id FROM `history` where class='$class_id' and  section LIKE '%$section%' and  asession ='$asession' ";
	$rsResults=$os->mq($dataQuery);


		while($record=$os->mfa( $rsResults))
		{
				$room_id=$record['hostel_room_id'];
				$bed=$record['bed_no'];
				$bed_key=$room_id.'-'.$bed;
				$used_bed_list_id[$bed_key]=$bed_key;


		}


	// get total bed list--
	$dataQuery="SELECT * FROM `room_setting` where class_id='$class_id' and  section LIKE '%$section%' ";
	$rsResults=$os->mq($dataQuery);


		while($record=$os->mfa( $rsResults))
		{

		$room_ids=explode(',',$record['room_name']);
		$bed_list=explode(',',$record['bed_list']);
		$room_ids=array_filter($room_ids);
			foreach($room_ids as $k=>$room_id)
			{
			 $beds=$bed_list[$k];
			 $bedA=explode('-',$beds);

					 foreach($bedA as $bed)
					 {
							$bed_key=$room_id.'-'.$bed;
							$total_bed_list_id[$bed_key]=$bed;
							if(!in_array($bed_key,$used_bed_list_id))
							{
							  $remains_bed_list_id[$bed_key]=$bed;
							}


					 }



			}


		}

  // take a value

  $key = key($remains_bed_list_id);



   if($key!='')
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


echo '##--calculate_room-building_name--##'; echo $building_name;  echo '##--calculate_room-building_name--##';
echo '##--calculate_room-floor_name--##'; echo $floor_name;  echo '##--calculate_room-floor_name--##';
echo '##--calculate_room-room_name--##'; echo $room_name;  echo '##--calculate_room-room_name--##';
echo '##--calculate_room-bed_no--##'; echo $bed_no;  echo '##--calculate_room-bed_no--##';
echo '##--calculate_room-hostel_room_id--##'; echo $hostel_room_id;  echo '##--calculate_room-hostel_room_id--##';

exit();*/
}




