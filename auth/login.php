<?php 
require '../connection.php';
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){

     // Retrieve form inputs and process file upload
     $email = $_POST['email'];
     $password = $_POST['password'];

     $search_user = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($search_user);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Success: User authenticated
            echo json_encode(['success' => 'Login successful!']);
            $_SESSION['user-id'] = $user['id'];

        } else {
            // Error: Invalid password
            echo json_encode(['error' => "Email or Password don't match."]);
        }
    } else {
        // Error: No user found with the provided email
        echo json_encode(['error' => 'User does not exist with provided email. Register to proceed']);
    }


}

?>