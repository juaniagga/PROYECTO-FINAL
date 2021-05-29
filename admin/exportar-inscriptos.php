<?php
include_once 'funciones/sesion-admin.php';
try {
    include_once 'funciones/funciones.php';
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
require_once 'phpexcel/Classes/PHPExcel.php';
setlocale(LC_TIME, 'es_RA');
setlocale(LC_TIME,'spanish');
$permiso = $_SESSION['permiso'];
if ($permiso){
  $id_evento= $_GET['id'];
}else{
  $id_evento= $_SESSION['id_evento'];
}

$table = $_POST['tabla'];


$filename= "listado.xlsx";
// save $table inside temporary file that will be deleted later
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $table);

// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
$objPHPExcel = new PHPExcel();
$excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
$objPHPExcel->getActiveSheet()->setTitle('Inscriptos'); // Change sheet's title if you want

unlink($tmpfile); // delete temporary file because it isn't needed anymore
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
header('Cache-Control: max-age=0');

// Creates a writer to output the $objPHPExcel's content
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$writer->save('php://output');
exit;