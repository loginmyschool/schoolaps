<?php
global $os,$site,$session_selected;
  
 
 if(! $os->isLogin() )
 {
     header("Location: ".$site['url']."login");
     exit();
 }else{
 
  $studentId=$os->userDetails['studentId'];
    $name=$os->userDetails['name'];
    $image = $os->userDetails['image'];


    $asession=date('Y');
    $student_query=" select s.*, h.* from  history h ,student s  where s.studentId='$studentId'  and s.studentId= h.studentId  and h.asession='$asession'  ";
    $rsResults=$os->mq($student_query);
    $student_rec=$os->mfa( $rsResults) ;
 ?>
  <div>
        <div class="uk-text-center uk-margin">
           <a href="<? echo $site['url'] ?>myprofile">
		    <img class="uk-width-small uk-width-medium@m uk-border-rounded" alt="<?= $name ?>" src="<?=$site['url'].$student_rec['image'];?>"/>
			</a>
            <h2 class="uk-margin-remove-bottom uk-margin-small-top"><? echo  $name; ?></h2>
            <img src="<?= $site["url"]."barCode/".$student_rec["uid"]?>-ean13.jpg">
            <p class="uk-margin-remove">
                Class : <i class="secondory-text"><?= $os->classList[$student_rec["class"]] ?></i>,
                Roll No: <i class="secondory-text"><?= $student_rec["roll_no"] ?></i>
            </p>
        </div>






 <h3> Applications</h3>
         

        <ul class="uk-margin-large-top" uk-accordion>
            <li class="border-xxs uk-open" style="border-color: #e5e5e5" >
                <a class="uk-accordion-title uk-padding-small  uk-background-muted uk-text-uppercase primary-text uk-text-bolder text-l" href="#">Application for leave </a>
                <div class="uk-accordion-content uk-margin-remove">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <tr>
                            <td >Date :</td>
                            <td class="secondory-text-dark">25-07-2020 </td>
							
                        </tr> 
                        <tr>
                            <td>Reason</td>
                            <td class="secondory-text-dark">Relative wedding  </td>
                        </tr>

                        <tr>
                            <td>Granted  by Admin</td>
                            <td class="secondory-text-dark">Yes</td>
                        </tr>
						<tr>
                            <td> Dated </td>
                            <td class="secondory-text-dark">25-07-2020  to 28-07-2020   3 days </td>
                        </tr>
                        <tr>
                            <td>Application</td>
                            <td class="secondory-text-dark">Dear sir , I am father of naimur , requesting you to grant leave for  3 days 25-07-2020  to 28-07-2020  . Your faithfully </td>
                        </tr>
                         
                    </table>
                </div>
            </li>
             <li class="border-xxs uk-open" style="border-color: #e5e5e5" >
                <a class="uk-accordion-title uk-padding-small  uk-background-muted uk-text-uppercase primary-text uk-text-bolder text-l" href="#">Application for leave due to sickness</a>
                <div class="uk-accordion-content uk-margin-remove">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <tr>
                            <td >Date :</td>
                            <td class="secondory-text-dark">25-07-2020 </td>
							
                        </tr> 
                        <tr>
                            <td>Reason</td>
                            <td class="secondory-text-dark">Relative wedding  </td>
                        </tr>

                        <tr>
                            <td>Granted  by Admin</td>
                            <td class="secondory-text-dark">Yes</td>
                        </tr>
						<tr>
                            <td> Dated </td>
                            <td class="secondory-text-dark">25-07-2020  to 28-07-2020   3 days </td>
                        </tr>
                        <tr>
                            <td>Application</td>
                            <td class="secondory-text-dark">Dear sir , I am father of naimur , requesting you to grant leave for  3 days 25-07-2020  to 28-07-2020  . Your faithfully </td>
                        </tr>
                         
                    </table>
                </div>
            </li>
             
        </ul>

    </div>
   
   
 
 
 
 
 
  
  
  
  
  
  
  
  
  <? } ?>