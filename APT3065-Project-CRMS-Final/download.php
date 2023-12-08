<?php
if (!isset($_GET['file']) || !isset($_GET['type'])) {
    exit('Invalid request');
}

$filename = basename($_GET['file']);
$type = $_GET['type'];

switch ($type) {
    case 'nationalid':
        $filepath = 'userupload/nationalid/' . $filename;
        break;
    case 'driverslicense':
        $filepath = 'userupload/driverslicense/' . $filename;
        break;
    default:
        exit('Invalid file type');
}

if (file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    flush();
    readfile($filepath);
    exit;
} else {
    exit('File not found');
}
