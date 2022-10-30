<?php
global $os,$site;
include($site['root'].'vendor/picqer/php-barcode-generator/src/BarcodeGenerator.php');
include($site['root'].'vendor/picqer/php-barcode-generator/src/BarcodeGeneratorPNG.php');
include($site['root'].'vendor/picqer/php-barcode-generator/src/BarcodeGeneratorSVG.php');
include($site['root'].'vendor/picqer/php-barcode-generator/src/BarcodeGeneratorJPG.php');
include($site['root'].'vendor/picqer/php-barcode-generator/src/BarcodeGeneratorHTML.php');

 class wtbarcode{

function barcode($code,$filepath='',$type='')
{

	$generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();
	file_put_contents($filepath.$code.'-ean13.jpg', $generatorJPG->getBarcode($code, $generatorJPG::TYPE_EAN_13));
	return $filepath.'/'.$code.'-ean13.jpg';

}
function barcodeIMG($code,$filepath='',$type='')
{

     return $filepath.$code.'-ean13.jpg';

}


}
