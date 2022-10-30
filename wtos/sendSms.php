<?php

set_time_limit (0 );
ini_set('max_input_vars', 100000);
class sms{
var $username='ermc';
var $password='ermcapi@2018';
var $senderid='REBOOK';
var $route='Enterprise';
 

function sendSMS($smsText,$smsNumbersStr)
{
$sendComfirm=true;
 
 $post='';
$sendTme=date('Y-m-d h:i:s');
$smsNumbersStrArr=explode(',',$smsNumbersStr);  
$smsFinalStrArr=array();
foreach($smsNumbersStrArr as $val)
{
  if(trim($val)!='')
  {
  
  $smsFinalStrArr[]=$val;
  
  }
}
 

 /*<img src="https://malert.in/api/api_http.php?username=ermc&password=ermcapi@2018&senderid=GSERMC&to=<?php echo $mobileNo ?>&text=<?php echo $smsText ?>&route=Enterprise&type=text" style="display:none;" />*/
 
    
if($sendComfirm && count($smsFinalStrArr)>0){
    // GSERMC
  $url = "http://malert.in/new/api/api_http.php";
   // $recipients = array('8017477871');
    $param = array(
        'username' => $this->username,
        'password' => $this->password,
        'senderid' => $this->senderid,
        'text' => $smsText,
        'route' =>  $this->route,
        'type' => 'text',
        'to' => implode(';', $smsFinalStrArr),
    );
   // $post = http_build_query($param, '', '&amp;');
	 foreach ($param as $key => $val) {
        $post .= '&' . $key . '=' . rawurlencode($val);
    }
	//echo $post;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
    $result = curl_exec($ch);
    if(curl_errno($ch)) {
        $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
    } else {
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        switch($returnCode) {
            case 200 :
                break;
            default :
                $result = "HTTP ERROR: " . $returnCode;
        }
    }
    curl_close($ch);

 }

}



function balance()
{
## Not Working 	file_get_contents function

//echo 'http://malert.in/new/api/api_http_balance.php?username='.$this->username.'&password='.$this->password.'&route='.$this->route;
//$fc=file_get_contents ('http://malert.in/new/api/api_http_balance.php?username='.$this->username.'&password='.$this->password.'&route='.$this->route);
//$fc=json_decode($fc);

//$fc=$fc[0];
//return $fc->balance;
	
	
$url='http://malert.in/new/api/api_http_balance.php?username='.$this->username.'&password='.$this->password.'&route='.$this->route;
$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL,$url);
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
$fc= json_decode(curl_exec($curlSession));
curl_close($curlSession);
$fc=$fc[0];
return $fc->balance;	
	
	
}


function template($id='',$arrData=array())
{
  $template='';

  if($id=='New_OTP')
  {
   
	$template='Dear USER your OTP is #OTP# Please enter OTP to continue';
  }
  if($id=='MSG_SEND')
  {
    $template='Dear applicant your OTP is 71534 Please enter OTP to continue.';
	//$template=$text;
  }
  
  
 foreach($arrData as $key=>$val)
	{
		 $template= str_ireplace( $key, $val,$template);
	}  
  
  
  return $template;

}

}