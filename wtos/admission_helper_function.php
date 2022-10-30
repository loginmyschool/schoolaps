<?
function application_excel_entry($asession,$class_id,$file_name)
{

//_d($_FILES);

global $os,$site;
    $file='';
	$message='';
	 if(isset($_FILES[$file_name]['tmp_name']))
	 {
	      $file=$_FILES[$file_name]['tmp_name'];
	 }	  
	
	if($file!=''  )
	{
	require_once 'Excel/reader.php';
	$dataX = new Spreadsheet_Excel_Reader();
	$dataX->setOutputEncoding('CP1251');
	$dataX->read($file); // uploaded excel file
	
		 
	for ($RowsNu = 2; $RowsNu <= $dataX->sheets[0]['numRows']; $RowsNu++)
		{ 
			
			
			
			
			//if($dataX->sheets[0]['cells'][$RowsNu][1]!='' )
			 
	        $xFile=$dataX->sheets[0]['cells'][$RowsNu];	
			
		 
			 
				if(isset($xFile[1])){	$serialNo=$xFile[1];}
				if(isset($xFile[2])){	$name=$xFile[2];}
				if(isset($xFile[3])){	$dob=$xFile[3];}
				if(isset($xFile[4])){	$gender=$xFile[4];}
				if(isset($xFile[5])){	$father_name=$xFile[5];}
				if(isset($xFile[6])){	$guardian_name=$xFile[6];}
				if(isset($xFile[7])){	$mobile_student=$xFile[7];}
				if(isset($xFile[9])){	$vill=$xFile[9];}
				if(isset($xFile[10])){	$po=$xFile[10];}
				if(isset($xFile[11])){	$ps=$xFile[11];}
				
				if(isset($xFile[12])){	$dist=$xFile[12];}
				if(isset($xFile[13])){	$block=$xFile[13];}
				if(isset($xFile[14])){	$state=$xFile[14];}
				if(isset($xFile[15])){	$pin=$xFile[15];}
			  
			    $dataToSave=array();
				$dataToSave['name']=$name; 
				$dataToSave['dob']=$os->saveDate($dob); 
				$dataToSave['gender']=$gender; 
				$dataToSave['father_name']=$father_name;
				$dataToSave['mobile_student']=$mobile_student;
				$dataToSave['vill']=$vill;
				$dataToSave['po']=$po;
				$dataToSave['ps']=$ps;
				$dataToSave['dist']=$dist;
				$dataToSave['block']=$block;
				$dataToSave['pin']=$pin;
				$dataToSave['state']=$state;
				$dataToSave['guardian_name']= $guardian_name;  
				$dataToSave['applicaton_date']= $os->now();
				$dataToSave['class_id']= $class_id;  
				$dataToSave['asession']= $asession;  
				
				 
				
				if($name!='')
				{
                    $qResult=$os->save('online_form',$dataToSave,'online_form_id','');
					//echo  $os-> query;
				}
			 
		
	
		}
		
		
 
	
	}
	else{
	
	
		$message= 'Please upload proper formatted .xls File.';
	
	}
	 


 
 
$return_Data['asession']=$asession;
$return_Data['class_id']=$class_id;
$return_Data['message']=$message;
 return  $return_Data;
}