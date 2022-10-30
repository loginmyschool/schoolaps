<?
/*
   # wtos version : 1.1
   # main ajax process page : teacherAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List Staffs';
$ajaxFilePath= 'teacherAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

?>
<div class="title-bar">
    <h3 class="background-color-white"><?php  echo $listHeader; ?></h3>
</div>
<div class="content">
    <div class="item medium-sidebar with-footer">
        <div class="item-content p-m">

            <div class="p-m">
                <div class="material-input-box">
                    <input value="" type="text" name="name" id="name" placeholder="Please Enter teacher name"/>
                    <div></div>
                    <label for="name">Name</label>
                </div>
            </div>



            <div class="p-m">
                <div class="material-input-box">
                    <img id="imagePreview" src="" height="100" style="display:none;"   /> 
                    <input type="file" name="image" value=""  id="image" onchange="os.readURL(this,'imagePreview') " style="display:none;"/><br>
                    <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('image');">Edit Image</span>


                    <div></div>
                    <label for="name">Image</label>
                </div>
            </div>

            <div class="p-m">
                <div class="material-input-box">
                    <input value="" type="text" name="joinDate" id="joinDate" class="wtDateClass" placeholder="Please Enter join date"/>
                    <div></div>
                    <label for="name">Join Date</label>
                </div>
            </div>
            <div class="p-m">
                <div class="material-input-box">
                    <textarea  name="permanentAddress" id="permanentAddress" placeholder="Please Enter permanent address"></textarea>
                    <div></div>
                    <label>Permanent Address</label>
                </div>
            </div>
            <div class="p-m">

                <div class="material-input-box">
                    <textarea  name="recentAddress" id="recentAddress" placeholder="Please Enter recent address"></textarea>
                    <div></div>
                    <label>Recent Address</label>
                </div>
            </div>
            <div class="p-m">
                <div class="material-input-box">
                    <input value="" type="text" name="mobile" id="mobile" placeholder="Please Enter mobile number"/>
                    <div></div>
                    <label>Mobile</label>
                </div>
            </div>
            <div class="p-m">
                <div class="material-input-box">
                    <input value="" type="text" name="email" id="email" placeholder="Please Enter email id"/>
                    <div></div>
                    <label for="name"> Email </label>
                </div>
            </div>
            <div class="p-m">
                <div class="material-input-box">
                    <textarea  name="note" id="note" placeholder="Please Enter extra notes"></textarea>
                    <div></div>
                    <label for="name">Note</label>
                </div>
            </div>
            <div class="p-m">
                <div class="material-input-box">
                    <input value="" type="text" name="otpPass" id="otpPass" placeholder="Please Enter OTP password"/>
                    <div></div>
                    <label for="name">OTP Pass</label>
                </div>
            </div>
            <div class="p-m notDriver">
                <div class="material-input-box">
                    <input value="" type="text" name="specialization" id="specialization" placeholder="Please Enter Specialization" readonly="readonly"/>
					
					
					&nbsp;
					<a href="javascript:void(0);" onclick="set_specialization()" >Specialization </a>
					&nbsp;
					
                    <div ></div>
                    <label for="name">Specialization</label>
                </div>
            </div>
			
			 <div class="p-m">
			<div id="showlist_DIV" class="showlist_DIV_class"> &nbsp; </div>
			</div>
            <div class="p-m">
                <div class="material-input-box">

                    <select name="status" id="status" >
                        <option value="">Select Status</option>
                        <? $os->onlyOption($os->teacherStatus);	?>
                    </select>
                    <div></div>
                    <label for="name">Status</label>
                </div>
            </div>
			
			<div class="p-m">
                <div class="material-input-box">
                    <select name="type" id="type" >
                        <option value="">Select Type</option>
                        <? $os->onlyOption($os->staff_type);	?>
                    </select>
                    <div></div>
                    <label for="name">Type</label>
                </div>
            </div>



                <div class="p-m driver">
                <div class="material-input-box">
                    <img id="driving_licensePreview" src="" height="100" style="display:none;"   />     
                    <input type="file" name="driving_license" value=""  id="driving_license" onchange="os.readURL(this,'driving_licensePreview') " style="display:none;"/><br>

                    <span style="cursor:pointer; color:#FF0000;" onclick="os.clicks('driving_license');">Edit Image</span>
                    <div></div>
                    <label for="name">Driving License</label>
                </div>
            </div>


            <div class="p-m driver">
                <div class="material-input-box">
                    <input value="" type="text" name="idcard_details" id="idcard_details" class="textboxxx  fWidth "/>
                    <div></div>
                    <label for="name">Idcard Details</label>
                </div>
            </div>

            <div class="p-m driver">
                <div class="material-input-box">
                        <select name="provider_type" id="provider_type" class="textbox fWidth" ><option value="">Select Provider Type</option>  <? $os->onlyOption($os->provider_type);  ?></select>
                    <div></div>
                    <label for="name">Provider Type</label>
                </div>
            </div>

            <div class="p-m driver">
                <div class="material-input-box">
                        <input value="" type="text" name="provider_name" id="provider_name" class="textboxxx  fWidth "/>
                    <div></div>
                    <label for="name">Provider Name</label>
                </div>
            </div>

            <div class="p-m driver">
                <div class="material-input-box">
                        <input value="" type="text" name="provider_details" id="provider_details" class="textboxxx  fWidth "/>
                    <div></div>
                    <label for="name">Provider Details</label>
                </div>
            </div>
            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
            <input type="hidden"  id="teacherId" value="0" />
            <input type="hidden"  id="WT_teacherpagingPageno" value="1" />
        </div>
        <div class="item-footer">
            <div style="display: flex; justify-content: center; align-items: center; height: 100%">
                <? if($os->access('wtDelete')){ ?>
                    <button class="material-button dense error" type="button" value="Delete" onclick="WT_teacherDeleteRowById('');">Delete</button>
                <? } ?>
                &nbsp; <button class="material-button dense warn"  type="button" value="New" onclick="javascript:window.location='';">New</button>
                &nbsp;<? if($os->access('wtEdit')){ ?>
                    <button class="material-button dense success" type="button" value="Save" onclick="WT_teacherEditAndSave();" >Save</button>
                <? } ?>
            </div>
        </div>
    </div>

    <div  class="item">
        <div class="p-m full-width">
            <div>
                <div class="grid">
                    <div class=" grid-item p-m">
                        <div class="material-input-box select">
                            <input type="text" id="searchKey" placeholder="Please enter search keyword" />
                            <div></div>
                            <label for="examTitle">Search Key</label>
                        </div>
                    </div>
                    <div class="grid-item p-m" style="max-width: 100px" >
                        <div class="material-input-box">
                            <button type="button" value="Search" onclick="WT_teacherListing();" >Search</button>
                        </div>
                    </div>
                    <div class="grid-item p-m" style="max-width: 100px">
                        <div class="material-input-box">
                            <button type="button" value="Reset" onclick="searchReset();">Reset</button>
                        </div>
                    </div>
                </div>

                <div style="display:none" id="advanceSearchDiv">

                    Name: <input type="text"name="name_s" id="name_s" value="" /> &nbsp; From Join Date: <input class="wtDateClass" type="text" name="f_joinDate_s" id="f_joinDate_s" value=""  /> &nbsp;   To Join Date: <input class="wtDateClass" type="text" name="t_joinDate_s" id="t_joinDate_s" value=""  /> &nbsp;
                    Permanent Address: <input type="text" class="wtTextClass" name="permanentAddress_s" id="permanentAddress_s" value="" /> &nbsp;  Recent Address: <input type="text" class="wtTextClass" name="recentAddress_s" id="recentAddress_s" value="" /> &nbsp;  Mobile: <input type="text" class="wtTextClass" name="mobile_s" id="mobile_s" value="" /> &nbsp;  Email: <input type="text" class="wtTextClass" name="email_s" id="email_s" value="" /> &nbsp;  Note: <input type="text" class="wtTextClass" name="note_s" id="note_s" value="" /> &nbsp;  Otp Pass: <input type="text" class="wtTextClass" name="otpPass_s" id="otpPass_s" value="" /> &nbsp;  Specialization: <input type="text" class="wtTextClass" name="specialization_s" id="specialization_s" value="" /> &nbsp;  Status:

                    <select name="status" id="status_s"  ><option value="">Select Status</option>	<?
                        $os->onlyOption($os->teacherStatus);	?>
                    </select>

                </div>
            </div>


            <div  id="WT_teacherListDiv" class="p-m"></div>
        </div>
    </div>

</div>


<script>

    $(".driver").hide();
    $(".notDriver").show();
    $("#type").change(function(){
        var typeVal= os.getVal('type');
        if(typeVal=='Driver'){
            $(".driver").show();
            $(".notDriver").hide();   
        }
        else{
            $(".driver").hide();
            $(".notDriver").show();
        }
    });



    function WT_teacherListing() // list table searched data get
    {
        var formdata = new FormData();


        var name_sVal= os.getVal('name_s');
        var f_joinDate_sVal= os.getVal('f_joinDate_s');
        var t_joinDate_sVal= os.getVal('t_joinDate_s');
        var permanentAddress_sVal= os.getVal('permanentAddress_s');
        var recentAddress_sVal= os.getVal('recentAddress_s');
        var mobile_sVal= os.getVal('mobile_s');
        var email_sVal= os.getVal('email_s');
        var note_sVal= os.getVal('note_s');
        var otpPass_sVal= os.getVal('otpPass_s');
        var specialization_sVal= os.getVal('specialization_s');
        var status_sVal= os.getVal('status_s');
        formdata.append('name_s',name_sVal );
        formdata.append('f_joinDate_s',f_joinDate_sVal );
        formdata.append('t_joinDate_s',t_joinDate_sVal );
        formdata.append('permanentAddress_s',permanentAddress_sVal );
        formdata.append('recentAddress_s',recentAddress_sVal );
        formdata.append('mobile_s',mobile_sVal );
        formdata.append('email_s',email_sVal );
        formdata.append('note_s',note_sVal );
        formdata.append('otpPass_s',otpPass_sVal );
        formdata.append('specialization_s',specialization_sVal );
        formdata.append('status_s',status_sVal );
		
		  
		



        formdata.append('searchKey',os.getVal('searchKey') );
        formdata.append('showPerPage',os.getVal('showPerPage') );
        var WT_teacherpagingPageno=os.getVal('WT_teacherpagingPageno');
        var url='wtpage='+WT_teacherpagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_teacherListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_teacherListDiv',url,formdata);

    }

    WT_teacherListing();
    function  searchReset() // reset Search Fields
    {
        os.setVal('name_s','');
        os.setVal('f_joinDate_s','');
        os.setVal('t_joinDate_s','');
        os.setVal('permanentAddress_s','');
        os.setVal('recentAddress_s','');
        os.setVal('mobile_s','');
        os.setVal('email_s','');
        os.setVal('note_s','');
        os.setVal('otpPass_s','');
        os.setVal('specialization_s','');
        os.setVal('status_s','');

        os.setVal('searchKey','');
        WT_teacherListing();

    }


    function WT_teacherEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var nameVal= os.getVal('name');
        var joinDateVal= os.getVal('joinDate');
        var permanentAddressVal= os.getVal('permanentAddress');
        var recentAddressVal= os.getVal('recentAddress');
        var mobileVal= os.getVal('mobile');
        var emailVal= os.getVal('email');
        var noteVal= os.getVal('note');
        var otpPassVal= os.getVal('otpPass');
        var specializationVal= os.getVal('specialization');
        var statusVal= os.getVal('status');
        var imageVal= os.getObj('image').files[0]; 



        var driving_licenseVal= os.getObj('driving_license').files[0]; 
        var idcard_detailsVal= os.getVal('idcard_details'); 
        var provider_typeVal= os.getVal('provider_type'); 
        var provider_nameVal= os.getVal('provider_name'); 
        var provider_detailsVal= os.getVal('provider_details');

        if(driving_licenseVal){  formdata.append('driving_license',driving_licenseVal,driving_licenseVal.name );}
        formdata.append('idcard_details',idcard_detailsVal );
        formdata.append('provider_type',provider_typeVal );
        formdata.append('provider_name',provider_nameVal );
        formdata.append('provider_details',provider_detailsVal );




        if(imageVal){  formdata.append('image',imageVal,imageVal.name );}
        formdata.append('name',nameVal );
        formdata.append('joinDate',joinDateVal );
        formdata.append('permanentAddress',permanentAddressVal );
        formdata.append('recentAddress',recentAddressVal );
        formdata.append('mobile',mobileVal );
        formdata.append('email',emailVal );
        formdata.append('note',noteVal );
        formdata.append('otpPass',otpPassVal );
        formdata.append('specialization',specializationVal );
        formdata.append('status',statusVal );

  var typeVal= os.getVal('type');
  formdata.append('type',typeVal );
  
  
   if(nameVal==''){ alert('Missing Name'); return false;}
  
  

        var   teacherId=os.getVal('teacherId');
        formdata.append('teacherId',teacherId );
        var url='<? echo $ajaxFilePath ?>?WT_teacherEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_teacherReLoadList',url,formdata);

    }

    function WT_teacherReLoadList(data) // after edit reload list
    {

        var d=data.split('#-#');
        var teacherId=parseInt(d[0]);
        if(d[0]!='Error' && teacherId>0)
        {
            os.setVal('teacherId',teacherId);
        }

        if(d[1]!=''){alert(d[1]);}
        WT_teacherListing();
    }

    function WT_teacherGetById(teacherId) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('teacherId',teacherId );
        var url='<? echo $ajaxFilePath ?>?WT_teacherGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_teacherFillData',url,formdata);

    }

    function WT_teacherFillData(data)  // fill data form by JSON
    {

        var objJSON = JSON.parse(data);
        os.setVal('teacherId',parseInt(objJSON.teacherId));
        os.setVal('name',objJSON.name);
        os.setVal('joinDate',objJSON.joinDate);
        os.setVal('permanentAddress',objJSON.permanentAddress);
        os.setVal('recentAddress',objJSON.recentAddress);
        os.setVal('mobile',objJSON.mobile);
        os.setVal('email',objJSON.email);
        os.setVal('note',objJSON.note);
        os.setVal('otpPass',objJSON.otpPass);
        os.setVal('specialization',objJSON.specialization);
        os.setVal('status',objJSON.status);
		os.setVal('type',objJSON.type);
        os.setImg('imagePreview',objJSON.image);

        os.setImg('driving_licensePreview',objJSON.driving_license); 
        os.setVal('idcard_details',objJSON.idcard_details); 
        os.setVal('provider_type',objJSON.provider_type); 
        os.setVal('provider_name',objJSON.provider_name); 
        os.setVal('provider_details',objJSON.provider_details);
    }

    function WT_teacherDeleteRowById(teacherId) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(teacherId)<1 || teacherId==''){
            var  teacherId =os.getVal('teacherId');
        }

        if(parseInt(teacherId)<1){ alert('No record Selected'); return;}

        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){

            formdata.append('teacherId',teacherId );

            var url='<? echo $ajaxFilePath ?>?WT_teacherDeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_teacherDeleteRowByIdResults',url,formdata);
        }


    }
    function WT_teacherDeleteRowByIdResults(data)
    {
        alert(data);
        WT_teacherListing();
    }

    function wtAjaxPagination(pageId,pageNo)// pagination function
    {
        os.setVal('WT_teacherpagingPageno',parseInt(pageNo));
        WT_teacherListing();
    }

    function excelDownload()
    {
        var c=0;
        var idvalStr='';
        var test = document.getElementsByName('columnName[]');
        for (i = 0; i < test.length; i++)
        {
            if(test[i].checked ==true )
            {
                var idVal=test[i].value;
                idvalStr=idvalStr+','+idVal;
                c++
            }
        }
        if(c==0)
        {
            alert('Please Select Atleast One Checkbox');
            return false;
        }
        window.location='teacherExcel.php?field='+idvalStr;



        //alert(idvalStr);
    }




</script>
 <style>
	 .class_subject{ width:200px; height:auto;  border:1px dotted #409FFF; background-color:#FFFFFF; margin:10px; 
	  float:left; letter-spacing:1px; border-radius:8px; }
	 .class_subject_class{ padding:7px; border-radius:8px 8px 0px 0px; font-size:16px; font-weight:bold; color:#000066; margin-bottom:10px; border-bottom: 1px dotted #75BAFF;background-color:#CCE6FF;}
	 .class_subject_list{padding:7px; line-height:18px; overflow:auto; height:240px;}
	 .class_subject_subject{font-size:12px; color:#0055AA;}
	 .subject_input{ border: 1px  dotted #007DFB; padding:2px 3px 2px 3px; margin:2px; width:130px;text-transform: capitalize;}
	 .showlist_DIV_class{ height:auto; font-size:10px;}
	 </style>
	 <div  id="Specialization_details_DIV" style="display:none;">  
	  <input type="checkbox" name="subject_list[]" value="" style="display:none;" />
	<?  
	$asession=date('Y');
	$config_array=array();
	$sel="select * from subject where classId!=''  and   asession='$asession'";
	$resset=$os->mq($sel);
	
	while($record=$os->mfa($resset))
	{
	   $config_array[$record['classId']][$record['subjectId']]=$record['subjectName'];
	}
	?>
	 <h2> List of Subjects </h2> 
	  
	<? foreach( $config_array as $classId_val=>$subjectName_arr  )
	  {
	  $className=$os->classList[$classId_val];		
	    
		?>
		<div class="class_subject">
		<div class="class_subject_class">Class:  <? echo $className  ?></div>   
		<div class="class_subject_list">
		
		<? 
		    $cc=1;
				  foreach( $subjectName_arr as  $subjectId=>$subjectName )
				 {
				
					?>
							 
				 <div class="class_subject_subject"> <input type="checkbox" name="subject_list[]" onclick="subject_storage()"  value="<? echo  $subjectId  ?>-<? echo  $subjectName  ?>-<? echo $className  ?>" />  . <? echo  $subjectName  ?>  </div>  		 
							 
					<? 		  
				$cc++;
				 
				 }?>
	 
	   <div style="clear:both"> </div>
	   </div>
	   </div> 
	<?  } ?> </div>
<script>
function  set_specialization()
{
  popDialog('Specialization_details_DIV','Specialization : ',{height:600,width:1200,modal:true})
}


function subject_storage()
{
var subject_lists=new Object();
var showlist='';
 var x = document.getElementsByName('subject_list[]');
 
        var i;
        for (i = 0; i < x.length; i++) 
		{
            if (x[i].checked) 
			{
                 var D=x[i].value.split('-');
			     var subjectId=D[0];
				 var subjectName=D[1];
				 var className=D[2];
				  subject_lists[subjectId]=subjectName;
				  showlist= showlist + '<div class="clsasubject">'+className+':'+subjectName+"</div>";

            }
        }
		 var g= JSON.stringify(subject_lists);		 
		 os.setVal('specialization',g);
		 os.setHtml('showlist_DIV',showlist);	
		 
				 

}
</script>

<? include($site['root-wtos'].'bottom.php'); ?>
