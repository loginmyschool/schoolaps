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






 <h3> Curriculam</h3>
         

        <ul class="uk-margin-large-top" uk-accordion>
            <li class="border-xxs uk-open" style="border-color: #e5e5e5" >
                <a class="uk-accordion-title uk-padding-small  uk-background-muted uk-text-uppercase primary-text uk-text-bolder text-l" href="#">Sports Activity</a>
                <div class="uk-accordion-content uk-margin-remove">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <tr>
                            <td >Run 100 meter annual sport 2015 :</td>
                            <td class="secondory-text-dark">2 nd position, 12 seconds. </td>
							
                        </tr> 
                        <tr>
                            <td>High Jump  annual sport 2015:</td>
                            <td class="secondory-text-dark">3rd position, 5 foot  </td>
                        </tr>

                        <tr>
                            <td>Long Jump annual sport 2015: </td>
                            <td class="secondory-text-dark"> 2nd position, 12 foot</td>
                        </tr>
                        <tr>
                            <td>Inter class Cricket 2015</td></td
                            <td class="secondory-text-dark"> Man of the match</td
                        </tr>
                         
                    </table>
                </div>
            </li>
            <li class="border-xxs" style="border-color: #e5e5e5">
                <a class="uk-accordion-title uk-padding-small uk-background-muted uk-text-uppercase primary-text uk-text-bolder text-l" href="#">Cultural Activity</a>
                <div class="uk-accordion-content uk-margin-remove">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <tr>
                            <td  nowrap="">Quiz 2015 </td>
                            <td class="secondory-text-dark"> 1st position</td>
                        </tr>

                        <tr>
                            <td  nowrap="">Drawing </td>
                            <td class="secondory-text-dark">Good</td>
                        </tr>
                        <tr>
                            <td  nowrap="">Recitation</td>
                            <td class="secondory-text-dark">OK</td>
                        </tr>
                        <tr>
                            <td  nowrap="">Helping other</td>
                            <td class="secondory-text-dark">Good</td>
                        </tr>
                    </table>
                </div>
            </li>
             
        </ul>

    </div>
   
   
 
 
 
 
 
  
  
  
  
  
  
  
  
  <? } ?>