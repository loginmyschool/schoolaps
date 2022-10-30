<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

if($os->get('manage_fees_setting')=='OK' && $os->post('fees_config')=='OK')
{
    
	
	$class_ssearch=$os->post('classList_s');
    $asession=$os->post('asession');
	
	
    $fees_type=$os->post('fees_type');
    $classList=$os->post('classList');
    $student_type=$os->post('student_type');

    $fees_head=$os->post('fees_head');
    $amount=$os->post('amount');
    $button=$os->post('button');
	
	

	
    // echo "   $fees_type \        $classList /         $student_type /  $fees_head / $amount  /$asession";

   /* if($fees_type!='' && $classList!='' && $student_type!='' && $fees_head!='' && $amount!='' && $asession!='' && $button=='save' )
    {


        $fees_typeA=array_filter(explode(',',$fees_type));
        $classListA=array_filter(explode(',',$classList));
        $student_typeA=array_filter(explode(',',$student_type));



        foreach($classListA as $class_val)
        {
            foreach($fees_typeA as $fees_type_val)
            {
                foreach($student_typeA as $student_type_val)
                {

                    $dataToSave=array();
                    $dataToSave['classId']=$class_val;
                    $dataToSave['accademicsessionId']=$asession;
                    $dataToSave['student_type']=$student_type_val;
                    $dataToSave['feesType']=$fees_type_val;

                    $dataToSave['feesHead']=$fees_head;
                    $dataToSave['amount']=$amount;


                    $dataToSave['addedDate']=$os->now();
                    $dataToSave['addedBy']=$os->userDetails['adminId'];


                    $qResult=$os->save('feesconfig',$dataToSave,'feesconfigId','');///    allowed char '\*#@/"~$^.,()|+_-=:��

                }
            }
        }
    }*/




    $classList_s=$os->post('classList_s');
	$branch_code_s=$os->post('branch_code_s');
	 


    $config_array=array();
      $sel="select * from feesconfig where  classId='$classList_s' and  accademicsessionId='$asession' and branch_code='$branch_code_s' ";
    $resset=$os->mq($sel);
    $fees_slab_array =array();
    while($record=$os->mfa($resset))
    {
        $config_array[$record['classId']][$record['student_type']][$record['feesType']][$record['feesHead']]=$record['amount'];
		 $fees_slab_array[$record['fees_slab_id']][$record['student_type']][$record['feesType']][$record['feesHead']]=$record;
		 $fees_title_array[$record['student_type']][$record['feesType']][$record['feesHead']]=$record['feesHead'];
		
    }
 
    echo '##--FEES-SETTING-DATA--##';
	
	if($branch_code_s=='')
	{
	  echo 'Please Select Branch';
	  exit();
	}
	
	if($asession<1)
	{
	 echo 'Please Select Year';
	 exit();
	}
	if($class_ssearch<1)
	{
	 echo 'Please Select Class';
	 exit();
	}
	
	
	
	
	
	
	$slab_array=array();
	
	   $where_slab="    classId='$classList_s' and  year='$asession' and  branch_code='$branch_code_s' ";
    $slab_array_ra=$os->get_fees_slab('', $where_slab );
    
    while($record=$os->mfa($slab_array_ra))
    {
        $slab_array[$record['classId']][$record['fees_slab_id']] =$record;
    }
	
	$slabs=$slab_array[$class_ssearch];
	if(count($slabs)<1)
	{
	   echo 'Please Configure Fees Slab';
	    exit();
	
	}
	 
	//var $fees_type = array ( 'Admission' => 'Admission', 'Readmission' => 'Readmission','Monthly' => 'Monthly'  );
	//var $student_type = array ( 'Day Scholars' => 'Day Scholars', 'Day Boarding' => 'Day Boarding','Hosteler' => 'Hosteler'  );
	
	 
	 
	
	foreach($os->student_type as  $student_type)
	{
			 
			    
			?>
            <div class="uk-margin uk-margin-small-right uk-margin-small-left" style="background-color:#CCCCCC; margin:10px; padding:5px;">
                <h2 class="uk-margin-small"> <?=$student_type?></h2>
                <div class="uk-margin-small uk-grid uk-grid-small " uk-grid>
                    <? foreach( $os->fees_type as  $feesType_val  ) {?>
                        <div>
                            <div  class="uk-card uk-card-small uk-card-default">

                                <div class="uk-card-header">
                                    <h3 class="text-l"><? echo $feesType_val ?></h3>
                                </div>
                                <div>
								<? $form_id=str_replace(array('',' '),'',$feesType_val.$student_type.$classList_s); ?>
                                    <table class="uk-table uk-table-small uk-table-divider ">
									
									 <tr>
									   <td class="p-left-xl" width="10" >  </td>
                                                <td align="left" style="width:70px; font-weight:bold;"> Head </td>
                                     <?
										
										  
										//  _d( $slabs);
									  
                                        foreach($slabs as $fees_slab_id=>$fees_slab){ ?>

                                           
                                                <td class="p-left-xl" style="width:100px; font-weight:bold;" ><? echo $fees_slab['title']; ?> 
												<div style="font-size:10px; color:#339900; font-style:italic;" ><? echo $fees_slab['note']; ?> </div>
												
												 </td>
                                                                                            <?
                                             
                                        }
                                        ?>
											<td align="left"  >   </td>
									    </tr>
									    <?
										
										  
                                        $total=0;
                                        $k=0;
										$title_array=$fees_title_array[$student_type][$feesType_val];
										
										
                                        foreach($title_array as $head){ 
										
										
										$k++;?>

                                            <tr>
                                                <td class="p-left-xl"   ><? echo $k;?>  </td>
                                                <td align="left" style="width:170px;"> <? echo $head ?> </td>
												
												 <?
										
										  $slabs=$slab_array[$class_ssearch];
									    $feesconfigId_arr=array();
                                        foreach($slabs as $fees_slab_id=>$fees_slab){ 
										
										$fees_amount=0;
										if(isset($fees_slab_array[$fees_slab_id][$student_type][$feesType_val][$head]))
										{
											$fees_config_row=$fees_slab_array[$fees_slab_id][$student_type][$feesType_val][$head];
											
											 
											
											$feesconfigId=$fees_config_row['feesconfigId'];
											$fees_amount=$fees_config_row['amount'];
										}
										
										$feesconfigId_arr[$feesconfigId]=$feesconfigId;
										
										?><td class="p-right-xl " align="right">  <? echo $fees_amount ?>  </td>
                                                                              
                                        <?  
										
										  $totlal_key=$fees_slab_id.$student_type.$feesType_val;
										   $total_slab[$totlal_key]=$total_slab[$totlal_key]+$fees_amount;
                                        }
										$feesconfigId_str=implode(',',$feesconfigId_arr);
                                        ?>
                      <td align="left"  > 
					      <a href="javascript:void(0);" onclick="delete_fees_conf_data('<? echo $feesconfigId_str; ?>')" 
						      style="font-size:14px; font-weight:bold; color:#FF0000;">X</a>   
					   </td>  
                                            </tr>

                                            <?
                                            
                                        }
                                        ?>

                                        <tr>
                                            <td >  </td>
                                            <td   align="left"> Total</td><? 
											foreach($slabs as $fees_slab_id=>$fees_slab){
											
											 $totlal_key=$fees_slab_id.$student_type.$feesType_val;
										   $total=$total_slab[$totlal_key] ;
											
											?>

                                           
                                               <td class="p-right-xl uk-text-success"  align="right"> <b> <? echo $total; ?>  </b></td>
                                                                                            <?
                                             
                                        }
                                        ?>
                                            <td align="left"  > 
											 <span  <?php echo $form_id; ?>  onclick="showhide('<?php echo $form_id; ?>');"   style=" cursor:pointer;">ADD </span>  </td>
                                        </tr>
										</table>
										 
										 
										 <!-- entry form  -->
										 
										 <form id="<?php echo $form_id; ?>" action="#" style="display:none;"  >
										 
										 <table class="uk-table uk-table-small uk-table-divider ">
										
										
										
										 <tr>
                                            <td >  </td>
                                            <td   align="left">  
											
											 <span style="font-size:10px">Fees Head</span><br />
											<input type="text"   name="feesHead" value="" style="width:150px;"  />    </td> 
										 
 
                                              </td>
                                           
                                               
											  <?  foreach($slabs as $fees_slab_id=>$fees_slab){ ?>
											  <td   class="p-right-xl "  align="right"> 
											 <span style="font-size:10px"> <? echo $fees_slab['title']; ?></span><br />
											   <input type="text"   value="" style="width:60px;" name="fees_slab_amount[<? echo $fees_slab_id ?>]" />    
											   </td>
											    <? } ?> 
												
												<td align="left"  > <input type="button" value="Save" style="cursor:pointer;" 
												
												
												onclick="add_fees_config('<? echo $form_id ?>','<? echo $classList_s ?>','<? echo $student_type ?>','<? echo $feesType_val ?>');" />  </td>
                                        </tr>
										
										
										 
										
                                    </table>
									</form>
									 <!-- entry form  end -->
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
            <?
			 
	
	}
	
	 
	
	
	 
 
    echo '<div style="clear:both"> &nbsp;</div>';
    echo '##--FEES-SETTING-DATA--##';

    exit();
}


if($os->get('add_fees_config')=='OK' && $os->post('add_fees_config')=='OK')
{
     
	
$classList_s=$os->post('classList_s');
$student_type=$os->post('student_type');
$feesType_val=$os->post('feesType_val');
$asession=$os->post('asession');
$fees_slab_amount=$os->post('fees_slab_amount');
$feesHead=$os->post('feesHead');

$branch_code_s=$os->post('branch_code_s');
    

    if($feesType_val!='' && $classList_s!='' && $student_type!='' && $feesHead!=''   && $asession!=''  )
    {


            foreach($fees_slab_amount as $fees_slab_id=>$amount)
			  {

                    $dataToSave=array();
                    $dataToSave['classId']=$classList_s;
					 $dataToSave['branch_code']=$branch_code_s;
                    $dataToSave['accademicsessionId']=$asession;
                    $dataToSave['student_type']=$student_type;
                    $dataToSave['feesType']=$feesType_val;
                    $dataToSave['feesHead']=$feesHead;					
                    $dataToSave['amount']=$amount;
					$dataToSave['fees_slab_id']=$fees_slab_id;
                    $dataToSave['addedDate']=$os->now();
                    $dataToSave['addedBy']=$os->userDetails['adminId'];
                    $qResult=$os->save('feesconfig',$dataToSave,'feesconfigId','');///    allowed char '\*#@/"~$^.,()|+_-=:��

                }
            
    }

  

    exit();
}


if($os->get('delete_fees_conf_data')=='OK' && $os->post('delete_fees_conf_data')=='OK')
{
     
	
$feesconfigId_str=$os->post('feesconfigId_str');
 $q_del="delete from feesconfig where feesconfigID IN($feesconfigId_str) ";
 
 $os->mq($q_del);

  

    exit();
}

