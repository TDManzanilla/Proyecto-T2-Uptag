<?php
include ('../../app/config.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];

    try {
        // Leer el archivo de Excel
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Validar encabezados
        $expectedHeaders = [
            'Número', 'Nombres', 'Apellidos', 'CI', 'Fecha de Nacimiento', 'Celular', 'Email', 'Dirección',
            'Nombres Representante', 'CI Representante', 'Celular Representante',
            'Dirección Representante', 'Parentesco Representante', 'Referencia Nombres', 'Referencia Celular', 'Referencia Parentesco'
        ];

        if ($rows[0] !== $expectedHeaders) {
            throw new Exception('El formato del archivo no es válido. Por favor, use la plantilla proporcionada.');
        }

        // Obtener nivel y grado del formulario
        $nivel_id = $_POST['nivel_id'] ?? null;
        $grado_id = $_POST['grado_id'] ?? null;

        if (!$nivel_id || !$grado_id) {
            throw new Exception('Debe seleccionar un nivel y un grado.');
        }

        // Generar las filas en el formulario
        session_start();
        $_SESSION['imported_data'] = array_slice($rows, 1); // Omitir la primera fila (encabezados)
        $_SESSION['nivel_id'] = $nivel_id;
        $_SESSION['grado_id'] = $grado_id;

        header('Location: ' . APP_URL . '/admin/inscripciones/multicreate.php');
        exit;
    } catch (Exception $e) {
        session_start();
        $_SESSION['mensaje'] = "Error al importar el archivo: " . $e->getMessage();
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
    }
}