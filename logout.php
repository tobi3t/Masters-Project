<?php
session_start(); # resume the existing session

session_destroy(); # destroying the session, effectively logging the user out

header('Location: index.html'); # redirecting the user to the "index.html" page

exit; # terminating the script
?>