<?php
session_start();
require_once 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
        $pdf_file = $_FILES['pdfFile']['name'];
        $pdf_path = 'pdfs/' . $pdf_file;

        $file_extension = strtolower(pathinfo($pdf_path, PATHINFO_EXTENSION));
        if ($file_extension !== 'pdf') {
            echo "Invalid file format. Please upload a PDF file.";
            exit;
        }

        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdf_path)) {
            header ("Location: adminpdfs.php");
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error uploading the file.";
    }
}
?>
