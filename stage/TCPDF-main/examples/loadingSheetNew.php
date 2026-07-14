<?php
$input_data = json_decode(file_get_contents("php://input"));
//$data='{
//   "date_value":"2022-06-04",
//   "employee_token":"23111632"
//}';
//
//$input_data = json_decode($data);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
// create new PDF document

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setCreator(PDF_CREATOR);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$pdf->setFontSubsetting(true);
$pdf->setFont('dejavusans', '', 14, '', true);
$pdf->AddPage('P', 'A4');
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
 //Set some content to print
include_once "../../distributor_dashboard/config.php";
include_once "../$api_path/config/database.php";
include_once "../$api_path/config/core_distributor.php";
include_once "../$api_path/objects/employee_distributor.php";
include_once "../$api_path/distributor/LoadingSheetContentNew.php";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//$global_tcpdf_path = "/home/powersoap/public_html".$invoicepath."invoice_pdf/";
$global_tcpdf_path = $tcpf_file;
//echo $global_tcpdf_path.$fileName;
$target_path = ($global_tcpdf_path.$fileName); 
$pdf->Output($target_path, 'F');
?>