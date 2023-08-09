<?php
# checking if a 'pdf' parameter is set in the URL
if (isset($_GET['pdf'])) {
    # retrieving the PDF filename from the URL parameter
    $pdf_file = $_GET['pdf'];
    # constructing the full path to the PDF file
    $pdf_path = 'pdfs/' . $pdf_file;

    # checking if the PDF file exists
    if (file_exists($pdf_path)) {
        # if the file exists, delete it using the unlink() function
        unlink($pdf_path);
        # redirecting back to the admin PDFs page after deleting the file
        header('Location: adminpdfs.php');
        exit; # terminate script execution
    } else {
        # if the file does not exist, display an error message
        echo "File not found.";
    }
} else {
    # if the 'pdf' parameter is not set in the URL, display an invalid request message
    echo "Invalid request.";
}
?>
