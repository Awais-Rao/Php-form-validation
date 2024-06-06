<?php
require '../connection.php';
session_start();

if (!isset($_SESSION['user-id'])) {
    header('location: ../auth');
    exit;
}

// Edit / Update User
$modelData;
$modal = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit'])) {
    $id = $_POST['user-id'];
    $editSqlQuery = "SELECT * FROM users WHERE id='$id'";
    $editResult = $conn->query($editSqlQuery);

    if ($editResult->num_rows == 1) {
        $modelData = $editResult->fetch_assoc();
        $modal = true;
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    // Collect form data
    $id = $_POST['user-id'];
    $first_name = $_POST['first-name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact-no'];
    $qualification = $_POST['qualification'];
    $cnic = $_POST['cnic'];

    // SQL Update query without using prepared statements
    $sql = "UPDATE users SET 
            first_name = '$first_name', 
            email = '$email', 
            contact_no = '$contact_no', 
            qualification = '$qualification', 
            cnic = '$cnic' 
            WHERE id = $id";

    // Execute SQL Update query
    if ($conn->query($sql)) {

    }

}


?>

<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />


    <!-- Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css"
        integrity="sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary px-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form action="#" class="ms-auto">
                        <button class="btn btn-dark px-3" name="logout">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="table_wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Education</th>
                        <th scope="col">CNIC</th>
                        <th scope="col" class="align-middle" style="width: 17%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $search_user = "SELECT * FROM users";
                    $result = $conn->query($search_user);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['deleted_at'] === NULL) {
                                echo '<tr>';
                                echo '<td>' . $row['first_name'] . '</td>';
                                echo '<td>' . $row['email'] . '</td>';
                                echo '<td>' . $row['contact_no'] . '</td>';
                                echo '<td>' . $row['qualification'] . '</td>';
                                echo '<td>' . $row['cnic'] . '</td>';
                                echo '<td class="actions_colum">
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="user-id" value="' . $row['id'] . '">
                                        <button class="btn btn-warning px-4 edit-button" type="submit" name="edit"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit <i class="ri-pencil-line"></i></button>
                                    </form>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="user-id" value="' . $row['id'] . '">
                                        <button class="btn btn-danger px-4" type="submit" name="delete">Delete <i class="ri-delete-bin-line"></i></button>
                                    </form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <!--Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="index.php" method="post">
    <input type="hidden" name="user-id" value="<?php echo $modelData['id']; ?>" />
    <div class="mb-3">
        <label for="firstName" class="form-label">First Name</label>
        <input type="text" class="form-control" name="first-name"
            value="<?php echo $modelData['first_name']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email"
            value="<?php echo $modelData['email']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="contactNo" class="form-label">Contact No</label>
        <input type="text" class="form-control" name="contact-no"
            value="<?php echo $modelData['contact_no']; ?>" required>
    </div>
    <div class="mb-3">
        <select class="form-select" name="qualification" id="qualification">
            <option value="matric" <?php echo ($modelData['qualification'] == 'matric') ? 'selected' : ''; ?>>Matriculation</option>
            <option value="intermediate" <?php echo ($modelData['qualification'] == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
            <option value="bachelor" <?php echo ($modelData['qualification'] == 'bachelor') ? 'selected' : ''; ?>>Bacholer</option>
            <option value="master" <?php echo ($modelData['qualification'] == 'master') ? 'selected' : ''; ?>>Masters</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="cnic" class="form-label">CNIC</label>
        <input type="text" class="form-control" name="cnic"
            value="<?php echo $modelData['cnic']; ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="update" class="btn btn-primary">Save changes</button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    var myModal = new bootstrap.Modal(document.getElementById('editModal'));
                    myModal.show();
                });
            });
        });


    </script>

    <?php
    if ($modal == true) {

        echo '<script type="text/javascript">
            
                $(document).ready(function(){
                    $("#editModal").modal("show");
                });
                
            </script>   ';
    }
    ?>


</body>

</html>