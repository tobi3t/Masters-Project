<?php
function get_user_by_id($conn, $user_id) {
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}