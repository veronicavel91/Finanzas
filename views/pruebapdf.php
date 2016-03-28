<?php
require_once('./librerias/tcpdf/tcpdf.php.');
// Crear el documento
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
// Información referente al PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Jordi Girones');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
// Contenido de la cabecera
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
 
// Fuente de la cabecera y el pie de página
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// Márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// Saltos de página automáticos.
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
// Establecer el ratio para las imagenes que se puedan utilizar
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
// Establecer la fuente
$pdf->SetFont('times', 'BI', 16);
 
// Añadir página
$pdf->AddPage();
 
// Escribir una línea con el método CELL
$pdf->Cell(0, 12, 'Example 001', 1, 1, 'C');
 
// ---------------------------------------------------------
 
//Cerramos y damos salida al fichero PDF
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>