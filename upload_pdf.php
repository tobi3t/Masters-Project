<?php
session_start();
require_once 'connection.php'; 

# checking if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # checking if the uploaded file has no errors
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
        # getting the name and path of the uploaded PDF file
        $pdf_file = $_FILES['pdfFile']['name'];
        $pdf_path = 'pdfs/' . $pdf_file;

        # getting the file extension and check if it's a PDF
        $file_extension = strtolower(pathinfo($pdf_path, PATHINFO_EXTENSION));
        if ($file_extension !== 'pdf') {
            echo "Invalid file format. Please upload a PDF file.";
            exit;
        }

        # moving the uploaded PDF file to the desired directory
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdf_path)) {
            # redirecting to the adminpdfs.php page after successful upload
            header ("Location: adminpdfs.php");
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error uploading the file.";
    }
}
?>
