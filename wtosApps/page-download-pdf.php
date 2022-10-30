<?php
global $os,$site,$pageVar;
use mikehaertl\wkhtmlto\Pdf;
ob_start();
include('subscription_invoice.php');
$content = ob_get_contents();
ob_end_clean();
// echo $content;

$op = $options = array(
    'no-outline',     
    'margin-top'    => 0,
    'margin-right'  => 0,
    'margin-bottom' => 0,
    'margin-left'   => 0,
);
$pdf = new Pdf($op);
$pdf->addPage($content);
if (!$pdf->send("subscription-invoice.pdf")) {
    $error = $pdf->getError();
}
?>



