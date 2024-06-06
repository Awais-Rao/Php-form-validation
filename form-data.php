<?php
require 'connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $contact_no = $_POST['contact-no'];
    $cnic = $_POST['cnic'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $qualification = $_POST['qualification'];
    // $interests = isset($_POST['interests']) ? implode(", ", $_POST['interests']) : '';
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //handle file upload

    $result_card = $_FILES['result-card'];
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($result_card['name']);

    if (move_uploaded_file($result_card['tmp_name'], $upload_file)) {
        $result_card_path = $upload_file; // File path for database
    } else {
        // echo 'Failed to upload file.';
        echo json_encode(['error' => 'Failed to upload file.']);
        exit;
    }

    // Prepare statement to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, contact_no, cnic, gender, dob, address, qualification, result_card_path, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssssssss', $first_name, $last_name, $contact_no, $cnic, $gender, $dob, $address, $qualification, $result_card_path, $email, $hashed_password);

    if ($stmt->execute()) {
        // echo 'You have been Registered Successfuly!';
        echo json_encode(['success' => 'You have been registered successfully!']);
    } else {
        // echo 'Something Went Wrong!';
        echo json_encode(['error' => 'Something went wrong!']);
    }

    // Close Statment
    $stmt->close();

} else {
    echo 'Invalid request method';
}


?>