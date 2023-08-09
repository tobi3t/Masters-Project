<?php
include("admintop.php");
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Manage PDF files</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h4>List of PDFs</h4>
                <ul class="list-group">
                    <?php
                    # define the folder where PDF files are stored
                    $pdf_folder = 'pdfs/';
                    # getting a list of files in the PDF folder
                    $pdf_files = scandir($pdf_folder); # https://www.php.net/manual/en/function.scandir.php

                    # looping through the files in the PDF folder
                    foreach ($pdf_files as $pdf_file) {
                        if ($pdf_file === '.' || $pdf_file === '..') {
                            continue;
                        }
                        # checking if the file has a .pdf extension
                        $file_extension = strtolower(pathinfo($pdf_folder . $pdf_file, PATHINFO_EXTENSION));
                        if ($file_extension === 'pdf') {
                            echo '<li class="list-group-item">';
                            echo '<div class="d-flex align-items-center">';
                            # embeding the PDF for preview
                            echo '<embed src="' . $pdf_folder . $pdf_file . '" width="500" height="500" type="application/pdf">';
                            echo '<span class="ms-3">' . $pdf_file . '</span>';
                            echo '</div>';
                            # providing a link to delete the PDF
                            echo '<a href="delete_pdf.php?pdf=' . urlencode($pdf_file) . '" class="btn btn-danger ms-3">Delete</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Upload PDF</h2>
            <!-- Form to upload a new PDF file -->
            <form action="upload_pdf.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="pdfFile" class="form-label">Select PDF file to upload:</label>
                    <input type="file" class="form-control" name="pdfFile" id="pdfFile" accept=".pdf" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload PDF</button>
            </form>
        </div>
    </div>
</div>

<br>

<?php
include("attachbottom.php");
?>
