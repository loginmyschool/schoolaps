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






 <h3> Health</h3>
         

        <ul class="uk-margin-large-top" uk-accordion>
            <li class="border-xxs uk-open" style="border-color: #e5e5e5" >
                <a class="uk-accordion-title uk-padding-small  uk-background-muted uk-text-uppercase primary-text uk-text-bolder text-l" href="#">Present Status</a>
                <div class="uk-accordion-content uk-margin-remove">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <tr>
                            <td>Blood group :</td>
                            <td class="secondory-text-dark">A Positive. </td>
							
                        </tr> 
                        <tr>
                            <td>Age :</td>
                            <td class="secondory-text-dark">18 years 9 month  </td>
                        </tr>

                        <tr>
                            <td>Present Condition  : </td>
                            <td class="secondory-text-dark">Normal </td>
                        </tr>
                        <tr>
                            <td>Eye sight :</td>
                            <td class="secondory-text-dark">6/6 6/6</td>
                        </tr>
						<tr>
                            <td>Psychiatric counciling report :</td>
                            <td class="secondory-text-dark"> Normal , Little bit  Short tempared. </td>
                        </tr>
                         
                    </table>
                </div>
            </li>
            <li class="border-xxs" style="border-color: #e5e5e5">
                <a class="uk-accordion-title uk-padding-small uk-background-muted uk-text-uppercase primary-text uk-text-bolder text-l" href="#">Case History</a>
                <div class="uk-accordion-content uk-margin-remove">
                    <table class="uk-table uk-table-small uk-table-divider">
                        <tr>
                            <td  nowrap="">20-07-2020 : </td>
                            <td class="secondory-text-dark"> Fever</td>
                        </tr>

                        <tr>
                            <td  nowrap="">28-07-2020 : </td>
                            <td class="secondory-text-dark"> Fever</td>
                        </tr>
                         <tr>
                            <td  nowrap="">29-07-2020 : </td>
                            <td class="secondory-text-dark"> Bleeding from nose , cold</td>
                        </tr>
                    </table>
                </div>
            </li>
             
        </ul>

    </div>
   
   
 
 
 
 
 
  
  
  
  
  
  
  
  
  <? } ?>