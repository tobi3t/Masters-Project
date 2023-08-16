<?php
# database connection details
$servername = "localhost";  # server where the database is hosted
$username = "root";         # username to access the database
$password = "";             # password to access the database
$dbname = "gamify";         # name of the database to connect to

# creating a new MySQLi instance to establish a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

# checking if the connection was successful
if ($conn->connect_error) {
  # if connection fails, display an error message and terminate the script
  die("Connection failed: " . $conn->connect_error);
}
?>