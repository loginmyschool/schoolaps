<?php
global $os;
$msgEnquery='';
if($os->post('querySubmit')=='queryValues'){
    if($os->post('email')!='' && $os->post('name')!=''){
        $image='';
        $image=$os->UploadPhoto('image',$site['root'].'pdffiles');
        if($image!='')
        {
            $dataToSave['image']='pdffiles/'.$image;
            $attachments=$site['url'].$dataToSave['image'];
        }

        # save to data base  888
        $dataToSave['firstName']=$os->post('name');
        $dataToSave['email']=$os->post('email');        
        $dataToSave['mobile']=$os->post('mobile');
        $dataToSave['details']=$os->post('message');
        $dataToSave['addedDate']=$os->now();
        $dataToSave['status']='New';
        $os->save('contactus',$dataToSave);
        # save to data base  888 end
        // $os->startOB();
        ?>

        <table width="400" border="0" cellpadding="5" cellspacing="2" >
            <tr>
                <td style="font-size:15px; font-weight:bold;">Message From  <? echo $site['url']; ?> Contact </td>
            </tr>
            <tr>
                <td>
                    Name: <strong><? echo $os->post('name')?></strong> <br /><br />
                    Email : <? echo $os->post('email')?> <br /><br />
                    Subject : <? echo $os->post('subject')?> <br /><br />
                    Message : <? echo $os->post('message')?> <br /><br />
                   &nbsp;</td>
               </tr>

           </table>
           <?


           $body=$os->getOB();
           $subject=$os->post('name')."Contacting You";
           $message=$os->post('message');
           $os->wtEmail('tarak@webtrackers.co.in',$subject,$message);
           $os->sendMail('tarakpaul109@gmail.com',$os->post('email'),$os->post('name'),$os->post('name').'  Contacting You ',$body);
           $msgEnquery='Thanks for contacting us, we will get back to you shortly.';
       }
       else
       {
        $msgEnquery='Sorry your message failed  please try again.';
    }
}
?>

<form action="" method="post" enctype="multipart/form-data" class="php-email-form">
  <div class="row">
    <div class="col-md-6 form-group">
      <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
  </div>
  <div class="col-md-6 form-group mt-3 mt-md-0">
      <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
  </div>
</div>
<div class="form-group mt-3">
    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" required>
</div>
<div class="form-group mt-3">
    <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
</div>
<?echo $msgEnquery;?>
<div></div>
<div class="my-3">
    <div class="loading">Loading</div>
    <div class="error-message"></div>
    <div class="sent-message">Your message has been sent. Thank you!</div>
</div>
<div class="text-center"><button type="submit">Send Message</button></div>
<input type="hidden" value="queryValues" name="querySubmit"  />

</form>