<?php
require 'connection.php';


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     $first_name = $_POST['first-name'];
//     $last_name = $_POST['last-name'];
//     $contact_no = $_POST['contact-no'];
//     $cnic = $_POST['cnic'];
//     $gender = $_POST['gender'];
//     $dob = $_POST['dob'];
//     $address = $_POST['address'];
//     $qualification = $_POST['qualification'];
//     $interests = implode(", ", $_POST['interests']);

//     // Handle file upload
//     $result_card = $_FILES['result-card'];
//     $upload_dir = 'uploads/';
//     $upload_file = $upload_dir . basename($result_card['name']);

//     if (move_uploaded_file($result_card['tmp_name'], $upload_file)) {
//         $result_card_path = $upload_file;
//     } else {
//         echo json_encode(['error' => 'Failed to upload file.']);
//         exit;
//     }



//     $sql = "INSERT INTO users (first_name, last_name, contact_no, cnic, gender, dob, address, qualification, interests, result_card_path)
//             VALUES ('$first_name', '$last_name', '$contact_no', '$cnic', '$gender', '$dob', '$address', '$qualification', '$interests', '$result_card_path')";

//     if ($conn->query($sql) === TRUE) {
//         echo json_encode(['success' => 'New record created successfully']);
//     } else {
//         echo json_encode(['error' => 'Error: ' . $sql . "<br>" . $conn->error]);
//     }

//     $conn->close();
// } else {
//     echo json_encode(['error' => 'Invalid request method']);
// }



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $contact_no = $_POST['contact-no'];
    $cnic = $_POST['cnic'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $qualification = $_POST['qualification'];
    $interests = isset($_POST['interests']) ? implode(", ", $_POST['interests']) : '';
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Encrypt the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $result_card = $_FILES['result-card'];
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($result_card['name']);

    if (move_uploaded_file($result_card['tmp_name'], $upload_file)) {
        $result_card_path = $upload_file; // File path for database
    } else {
        echo json_encode(['error' => 'Failed to upload file.']);
        exit;
    }


    // Escape inputs to prevent SQL injection
    $first_name = $conn->real_escape_string($first_name);
    $last_name = $conn->real_escape_string($last_name);
    $contact_no = $conn->real_escape_string($contact_no);
    $cnic = $conn->real_escape_string($cnic);
    $gender = $conn->real_escape_string($gender);
    $dob = $conn->real_escape_string($dob);
    $address = $conn->real_escape_string($address);
    $qualification = $conn->real_escape_string($qualification);
    $interests = $conn->real_escape_string($interests);
    $email = $conn->real_escape_string($email);
    $hashed_password = $conn->real_escape_string($hashed_password);
    $result_card_path = $conn->real_escape_string($result_card_path);

    // Simple SQL statement
    $sql = "INSERT INTO users (first_name, last_name, contact_no, cnic, gender, dob, address, qualification, interests, result_card_path, email, password)
            VALUES ('$first_name', '$last_name', '$contact_no', '$cnic', '$gender', '$dob', '$address', '$qualification', '$interests', '$result_card_path', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => 'You have been Registered Successfuly!']);
    } else {
        echo json_encode(['error' => 'Something Went Wrong!']);
    }

    // Close connections
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}




?>