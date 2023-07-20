<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if (isset($_GET['pdf'])) {
        $pdf_file = $_GET['pdf'];
        $pdf_path = 'pdfs/' . $pdf_file;

        if (file_exists($pdf_path)) {

            $already_earned_points = isset($_SESSION['earned_points'][$pdf_file]);

            if (!$already_earned_points) {
        
                $update_points_sql = "UPDATE user_points SET points = points + 2 WHERE user_id = $user_id";
                if ($conn->query($update_points_sql) === TRUE) {
    
                    $_SESSION['earned_points'][$pdf_file] = true;

                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . $pdf_file . '"');
                    readfile($pdf_path);
                    exit;
                } else {
                    echo "Error updating points: " . $conn->error;
                }
            } else {
    
                echo header('Location: resources.php');
            }
        } else {
            echo "File not found.";
        }
    } else {
        echo "Invalid request.";
    }
} else {

    header('Location: signin.html');
    exit;
}

$conn->close();
?>
