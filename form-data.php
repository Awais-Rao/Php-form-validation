<?php
require 'connection.php'; // Include your database connection file

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs and process file upload
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $contact_no = $_POST['contact-no'];
    $cnic = $_POST['cnic'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $qualification = $_POST['qualification'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Encrypt password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $result_card = $_FILES['result-card'];
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($result_card['name']);

    if (move_uploaded_file($result_card['tmp_name'], $upload_file)) {
        $result_card_path = $upload_file; // File path for database
    } else {
        // echo json_encode(['error' => 'Failed to upload file.']);
        echo 'Failed to upload file.';
        exit;
    }

    // SQL Query Preparation
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, contact_no, cnic, gender, dob, address, qualification, result_card_path, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $first_name, $last_name, $contact_no, $cnic, $gender, $dob, $address, $qualification, $result_card_path, $email, $hashed_password);


    if ($stmt->execute()) {
        // echo json_encode(['success' => 'You have been Registered Successfully!']);
        echo 'You have been Registered Successfully!';
    } else {
        // echo json_encode(['error' => 'Failed to insert data into the database.']);
        echo 'Failed to insert data into the database.';
    }


    $stmt->close();

    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>