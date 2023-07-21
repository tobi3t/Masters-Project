<?php
if (isset($_GET['pdf'])) {
    $pdf_file = $_GET['pdf'];
    $pdf_path = 'pdfs/' . $pdf_file;

    if (file_exists($pdf_path)) {
        unlink($pdf_path);
        header('Location: adminpdfs.php');
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
