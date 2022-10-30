<?php
session_start();
include('wtosConfigLocal.php');// load configuration
include('wtos.php'); // load wtos Library
global $os,$site;
if($os->get('SetHomPage')=='OK')
{
	$homeId=$os->get('homeId');
	$upQuery="update pagecontent set isHome='No' where (isHome='Yes' or isHome='')";
	$os->mq($upQuery);
	if($homeId>0)
	{
		$upQuery="update pagecontent set isHome='Yes' where pagecontentId='$homeId' ";
		$os->mq($upQuery);
	}
	echo 'Success;';
	exit();


}
if($os->get('wtosEditField')=='OKS')
{


	$newStatus=$os->get('newStatus');
	$table=$os->get('table');
	$satusfld=$os->get('satusfld');
	$idFld=$os->get('idFld');
	$idVal=$os->get('idVal');
	$data[$satusfld]=$newStatus;
	$os->save($table,$data,$idFld,$idVal);
	echo 'Update Successfully';

}
//image upload
if($os->get("upload_photo")=="OK"){
	$path = $site['root-image'];
	$filename = $os->UploadPhoto("file",$path);
	$url = $site["url-image"].$filename;
	print $url;
}
if($os->get("photo_list")=="OK"){
	$path = $site['root-image'];

	$files = array_filter(glob($path.'*'), 'is_file');

	$response = [];

	foreach ($files as $file) {
		$response[] = basename($file);
	}

	header('Content-Type: application/json');
	echo json_encode($response);
	die();
}



if($os->get("insert_brand")=="OK"){
	$brand = $os->get("brand");
	$datatosave=array(
		"brand_name"=>$brand
	);
	$b_arr = $os->mfa($os->mq("SELECT global_brand_id FROM global_brand WHERE brand_name ='$brand'"));
	if($b_arr){
		$global_brand_id = $b_arr["global_brand_id"];
	} else {
		$global_brand_id = $os->save("global_brand", $datatosave);
	}
	$res = [];
	$res["id"] = $global_brand_id;
	$res["input"] = $brand;
	print json_encode($res);
	exit();
}
if($os->get("insert_vendor")=="OK"){
	$vendor = $os->get("vendor");
	$branch_code = $os->get("branch_code");
	$datatosave=array(
		"vendor_name"=>$vendor,
		"branch_code"=>$branch_code
	);
	$b_arr = $os->mfa($os->mq("SELECT global_vendor_id FROM global_vendor WHERE vendor_name ='$vendor' AND branch_code='$branch_code'"));
	if($b_arr){
		$global_vendor_id = $b_arr["global_vendor_id"];
	} else {
		$global_vendor_id = $os->save("global_vendor", $datatosave);
	}
	$res = [];
	$res["id"] = $global_vendor_id;
	$res["input"] = $vendor;
	print json_encode($res);
}

/////////
if ($os->post("upload_file")=="OK"&& $os->get("upload_file")=="OK"){
	$file = $os->UploadPhoto("file", $site["root-image"]);
	print $file;
	exit();
}
//
?>

