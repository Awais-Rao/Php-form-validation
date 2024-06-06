<?php
require '../connection.php'; // Include your database connection file

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $id = $_POST['user-id'];

    $date = date("Y-m-d");

    $deleteSqlQuery = "UPDATE users SET deleted_at='$date' WHERE id='$id'";

    if ($conn->query($deleteSqlQuery)) {

    }
}


?>