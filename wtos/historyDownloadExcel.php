<?phpset_time_limit (0);ini_set('memory_limit', '-1');//ini_set('memory_limit', 0);use PhpOffice\PhpSpreadsheet\Spreadsheet;use PhpOffice\PhpSpreadsheet\Style\Border;use PhpOffice\PhpSpreadsheet\Writer\Xlsx;global $os, $site;include('wtosConfigLocal.php');include($site['root-wtos'].'wtosCommon.php');$fields=trim($_GET['field'], ',');$fields=explode(',',$fields);foreach($fields AS $key){	$excelColumnNameA[]=$os->historyExcelA[$key];}array_unshift($excelColumnNameA,"SL");$rows = [$excelColumnNameA];$spreadsheet = new Spreadsheet();$sheet = $spreadsheet->getActiveSheet();$listingQuery = $os->getSession('downloadHistoryExcel');if($listingQuery==''){exit();}$data = $os->mq($listingQuery);$srl =0;$branches = $os->get_branches_by_access_name("Student Register");while($record = $os->mfa($data)) {	$srl++;	$row = [$srl];	$record["class"] = @$os->classList[@$record["class"]];	$record["branch"] = @$branches[@$record["branch"]];	foreach ($fields as $key){		$row[] = $record[$key];	}	$rows[] = $row;}$count = 0;foreach ($rows as $row){	$count++;	$sheet->fromArray($row, NULL, $os->get_cell_name(1,$count));}$sheet->getStyle('A1:'.$os->get_leter_by_number(sizeof($fields)+1).'1')	->getFill()	->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)	->getStartColor()	->setARGB('FFE5E5E5');$sheet->getStyle('A1:A'.sizeof($rows))	->getFill()	->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)	->getStartColor()	->setARGB('FFE5E5E5');try {	$sheet->getStyle('A1:A' . sizeof($rows))		->getBorders()		->getAllBorders()		->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {}try {	$sheet->getStyle('A1:' . $os->get_leter_by_number(sizeof($fields) + 1) . '1')		->getBorders()		->getAllBorders()		->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {}// redirect output to client browserheader('Content-Disposition: attachment;filename="student_database'.rand(11111,99999).'.xlsx"');header('Cache-Control: max-age=0');$writer = new Xlsx($spreadsheet);try {	$writer->save('php://output');} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {}?>