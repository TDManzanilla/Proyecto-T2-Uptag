<?php
include('../../app/config.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados de las columnas
$headers = [
    'Número', 'Nombres', 'Apellidos', 'CI', 'Fecha de Nacimiento', 'Celular', 'Email', 'Dirección',
    'Nombres Representante', 'CI Representante', 'Celular Representante',
    'Dirección Representante', 'Parentesco Representante', 'Referencia Nombres', 'Referencia Celular', 'Referencia Parentesco'
];

// Escribir encabezados en la primera fila
$columns = range('A', chr(65 + count($headers) - 1)); // Genera las columnas dinámicamente
foreach ($headers as $index => $header) {
    $sheet->setCellValue($columns[$index] . '1', $header);
}

// Descargar el archivo
$writer = new Xlsx($spreadsheet);
$filename = 'plantilla_inscripcion_lotes.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save('php://output');
exit;