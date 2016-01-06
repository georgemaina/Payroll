<?php

require ('roots.php');
require ($root_path . 'include/inc_environment_global.php');

// include auto-loader class
require_once 'Zend/Pdf.php';
$pdf = new Zend_Pdf ();
$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_LETTER_LANDSCAPE);
// register auto-loader

$stmt =  $db->Execute('SELECT  p.`Pid`, p.`catID`, p.`pay_type`, p.`amount`, p.`payMonth` FROM proll_payments p');

// create PDF
//$pdf = new My_Pdf_Document('example.pdf', '.');

// create page
//$page = $pdf->createPage();

// define font resource
//$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);

// set font
$page->setFont($font, 24);

// create table
$table = new My_Pdf_Table(3);

// iterate over record set
// set up table content
while ($record = $stmt->fetch()) {
$row = new My_Pdf_Table_Row();
$cols = array();
foreach ($record as $k => $v) {
$col = new My_Pdf_Table_Column();
$col->setText($v);
$cols[] = $col;
}
$row->setColumns($cols);
$row->setFont($font, 14);
$row->setBorder(My_Pdf::TOP, new Zend_Pdf_Style());
$row->setBorder(My_Pdf::BOTTOM, new Zend_Pdf_Style());
$row->setBorder(My_Pdf::LEFT, new Zend_Pdf_Style());
$row->setCellPaddings(array(10, 10, 10, 10));
$table->addRow($row);
}

// add table to page
$page->addTable($table, 0, 0);

// add page to document
$pdf->addPage($page);

// save as file
$topPos = $topPos - 10;
array_push($pdf->pages, $page);
header('Content-type: application/pdf');
echo $pdf->render();
?>
