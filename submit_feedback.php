<?php
include("connection.php");
include("functions.php");

# checking if the HTTP request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    # sanitizing the input data received from the form
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $message = sanitize_input($_POST["message"]);
    
    # validating the email format using a filter
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }
    # checking if there is a connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    # SQL query to insert feedback into the database
    $sql = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
    # preparing the SQL statement
    $stmt = $conn->prepare($sql);
    # binding the sanitized input data to the prepared statement
    $stmt->bind_param("sss", $name, $email, $message);
    # executing the prepared statement
    if ($stmt->execute()) {
        # redirecting to a thank you page if feedback is successfully submitted
        header("Location: thankyou.html");
    } else {
        # displaying an error message if there's an issue with executing the statement
        echo "Error submitting feedback: " . $stmt->error;
    }
    # closing the prepared statement
    $stmt->close();
    $conn->close();
}
?>

