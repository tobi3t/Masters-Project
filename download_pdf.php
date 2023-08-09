<?php
session_start();
include("connection.php");
# checking if the user is logged in
if (isset($_SESSION['user_id'])) {
    # retrieving the user ID from the session
    $user_id = $_SESSION['user_id'];

    # checking if the 'pdf' parameter is set in the URL
    if (isset($_GET['pdf'])) {
        $pdf_file = $_GET['pdf'];
        $pdf_path = 'pdfs/' . $pdf_file;

        # checking if the PDF file exists
        if (file_exists($pdf_path)) {
            # checking if the user has already earned points for this PDF
            $already_earned_points = isset($_SESSION['earned_points'][$pdf_file]);

            # if points haven't been earned yet for this PDF
            if (!$already_earned_points) {
                # SQL query to update user points by 2 points
                $update_points_sql = "UPDATE user_points SET points = points + 2 WHERE user_id = $user_id";

                # executing the SQL query to update user points
                if ($conn->query($update_points_sql) === TRUE) {
                    # marking that the user has earned points for this PDF
                    $_SESSION['earned_points'][$pdf_file] = true;

                    # setting headers to trigger PDF download
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . $pdf_file . '"');
                    readfile($pdf_path);
                    exit;
                } else {
                    echo "Error updating points: " . $conn->error;
                }
            } else {
                # if points were already earned for this PDF, redirect back to resources page
                echo header('Location: resources.php');
            }
        } else {
            echo "File not found.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    # if user is not logged in, redirect to sign-in page
    header('Location: signin.html');
    exit;
}

$conn->close();
?>
