<?php
global $os;
$msgEnquery='';
if($os->post('querySubmit')=='queryValues')
{
$image='';
$image=$os->UploadPhoto('image',$site['root'].'pdffiles');
if($image!='')
{
$dataToSave['image']='pdffiles/'.$image;
$attachments=$site['url'].$dataToSave['image'];
} 
# save to data base  888

$dataToSave['name']=$os->post('name'); 
$dataToSave['address']=$os->post('address');
$dataToSave['postalCode']=$os->post('postalCode'); 
$dataToSave['city']=$os->post('city'); 
$dataToSave['state']=$os->post('state');
$dataToSave['mobile']=$os->post('mobile'); 
$dataToSave['addedDate']=$os->now(); 
$dataToSave['email']=$os->post('email'); 
$dataToSave['department']=$os->post('department'); 
$dataToSave['reference']=$os->post('reference'); 
$qResult=$os->save('career',$dataToSave);
$msgEnquery='	<div class="alert alert-success" role="alert" id="success_message"> Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>';
$os->startOB();

?>  


<table width="400" border="0" cellpadding="5" cellspacing="2" >
  <tr>
    <td style="font-size:15px; font-weight:bold;">Message From  <? echo $site['url']; ?> Career </td>
  </tr>
  <tr>
    <td>  
			 Name: <strong><? echo $os->post('name');?></strong> <br /><br />
			  Address: <strong><? echo $os->post('address');?></strong> <br /><br />
 
			Email : <? echo $os->post('email')?> <br /><br />
			
			Telephone number: <? echo $os->post('mobile')?> <br /><br />
			
			Department : <? echo $os->post('department')?> <br /><br />
			Reference : <? echo $os->post('reference')?> <br /><br />
			Attachment : <? echo $attachments?> <br />
      &nbsp;</td>
  </tr>
  
</table>
<?
			
		 
		   $body=$os->getOB();
		   $subject=$os->post('name')." Contacting You";
		   $message=$os->post('details');
           $os->wtEmail('tarak@webtrackers.co.in',$subject,$message);
			$os->sendMail('tarak@webtrackers.co.in',$os->post('email'),$os->post('firstName')." ".$os->post('lastName'),$os->post('firstName')." ".$os->post('lastName').'  Contacting You ',$body);
			
			$os->sendMail('tarakpaul109@gmail.com',$os->post('email'),$os->post('firstName'),$os->post('firstName').'  Contacting You ',$body);
		
			//function sendMail($to,$from,$fromName,$subj,$body,$attachments='' )
}
else
{
//$msgEnquery='<div class="alert alert-success" role="alert" id="success_message"> <span style="color:#FF0000">  Sorry your message failed  please try again.</span></div>';
}
?>  





<style>
.form_block{  font-size:14px; color:#333;}
.form_block .row_b{ margin-bottom:15px;}
.form_block .label{ width:34%; display:inline-block;color:#333; font-size:14px; text-align:left; }
.form_block label{font-weight:500;}
.form_block .input-field{padding: 6px 10px;border: 1px solid #ced4da;border-radius: 4px;line-height: 1.5; color: #495057; width:62%;}
form_block .photo{ float:left;} 
.form_block .left{ width:65%; float:left; max-width:100%;}
.form_block .right{ width:30%; float:left;}
.form_block .right .image_chus{}
.form_block .image_box{ width:100px; height:100px; display:block; border:1px solid #ccc; background:#ccc; text-align:center;}
.form_block .admi_class{ width:48%; display:inline-block}
.form_block .board{width:50%; display:inline-block}
.form_block .admi_class .label{ width:75%}
.form_block .input-field.admi_class{ width: 301px;}
.form_block .input-field.bord{ width: 120px}
.form_block .board-label{ width:92px;}
.form_block .button_block{ margin-top:10px;}
.clear{ clear:left;}

@media only screen and (max-width : 400px) {
	.form_block .label{ width:90%; display:inline-block; margin-bottom:5px;}
	.form_block .input-field{width:90%;}
	}
@media only screen and (max-width : 1199px) {
.form_block .input-field.admi_class{ width:62%; margin-bottom:20px;}
.form_block .input-field.bord{ width:62%; }
.form_block .board-label{ width:34%;}
	}
@media only screen and (max-width : 991px) {
	.form_block .left{ width:95%;}
	.form_block .right{ width:22%;}
	
	}	
@media only screen and (max-width : 680px) {
	.form_block .left{ width:100%;}
	.form_block .right{width:100%; }
	
}
@media only screen and (max-width : 480px) {
	.form_block .label{ width:100%; margin-bottom:4px; padding-left:0px;}
	.form_block .input-field{ width:100%;}
	}

</style>





<div class="form_block clearfix">

	 <form action="" method="post" enctype="multipart/form-data" id="formId">


    	<div class="left">
        	<div class="row_b">
        	<span class="label control-label">Name</span>
            <input type="text" name="name" id="name" value="" class="input-field">
        </div>

          

            <div class="row_b">
                <span class="label">Address</span>
                <input type="text" name="address" id="address" value="" class="input-field">
            </div>

            <div class="row_b">
                <span class="label">Postal Code</span>
                <input type="text" name="postalCode" id="postalCode" value="" class="input-field">
            </div>

            <div class="row_b">
                <span class="label">City</span>
                <input type="text" name="city" id="city" value="" class="input-field">
            </div>

            <div class="row_b">
                <span class="label">State</span>
                <input type="text" name="state" id="state" value="" class="input-field">
            </div>
			
			
			 <div class="row_b">
                <span class="label">Phone No</span>
                <input type="text" name="mobile" id="mobile" value="" class="input-field">
            </div>
			

			<div class="row_b">
                <span class="label">Email Id</span>
                <input type="text" name="email"  id="email"  value="" class="input-field">
            </div>
			
			
			
			   <div class="row_b">
                <span class="label">Department</span>
       				<select name="department" id="department" class="input-field admi_class" style="font-size:14px; font-weight:bold;" >
				<?$os->onlyOption($os->careerDepartment);?>
				</select>
				</div>
			
			
			

			<div class="row_b">
                <span class="label">Reference</span>
                <input type="text" name="reference" id="reference" value="" class="input-field">
            </div>

			<div class="row_b">
                <span class="label">Upload Cv</span>
       				<input type="file" name="image" class="input-field"  style="display: inline-block;" />
				</div>
				
				
        </div>
       
                <div class="clear"></div>
				<?echo $msgEnquery;?>
                <div class="button_block">
                <span class="label"></span>
                 <button type="button" class="button btn-cart" onclick="formSubmit()" >Submit </button>
			    </div>

		 <input type="hidden" value="queryValues" name="querySubmit"  />

    </form>



</div>
<script>
function formSubmit()
{
	//formId
	//alert();
	
if(os.check.empty('name','Please Add Name')==false){ return false;} 
if(os.check.empty('address','Please Add Address')==false){ return false;} 
if(os.check.empty('mobile','Please Add Phone No')==false){ return false;} 
if(os.check.empty('email','Please Add Email Id')==false){ return false;} 
if(os.check.empty('department','Please Add Department')==false){ return false;} 
document.getElementById("formId").submit();
	
}


</script>



