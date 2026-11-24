
<?php
session_start();
if (isset($_SESSION['id'])) {
    // redirect to dashboard if logged in
    header("location: dashboard.php");
}
require_once('db_connect.php');

$err_message = "ffdsf";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    $users_id = $_POST['users_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role_id = $_POST['role_id'];
    $email = $_POST['email'];

    $errors = [];
    if (empty($users_id) || empty($first_name) || empty($last_name) || empty($role_id) || empty($email)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO users (users_id, first_name, last_name, role_id, email) VALUES ($users_id, '$first_name', '$last_name', $role_id, '$email')";

        if ($conn->query($sql) === TRUE) {
            // Set session variables upon successful registration
            $_SESSION['users_id'] = $users_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $users_id; // Add this line to set id session also
            $_SESSION['role_id'] = $role_id;
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
    }
    exit;
}

include_once('template/header.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body {
        font-family: sans-serif;
    }

    h2 {
        text-align: center;
    }

    form {
        width: 300px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    #error-message {
        margin-top: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    #user-data {
        overflow-x: auto;
    }

    /* ... your CSS styles ... */
</style>

<h2>User Registration</h2>
 <form id="registration-form" method="POST">
    <label for="users_id">Users ID:</label>
    <input type="text" name="users_id" id="users_id" required><br><br>

    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" required><br><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" required><br><br>

    <label for="role_id">Role ID:</label>
    <input type="text" name="role_id" id="role_id" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <button type="submit">Submit</button>
    <div id="error-message"></div>
</form>

<script>
    $(document).ready(function() {
        function loadUserData() {
            $.ajax({
                url: 'get_users.php',
                type: 'GET',
                success: function(data) {
                    $('#user-data').html(data);
                },
                error: function() {
                    alert('Error loading user data.');
                }
            });
        }

        loadUserData();

        $('#registration-form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'login.php', // Corrected URL: send to the same file.
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#registration-form')[0].reset();
                        loadUserData();
                        $('#error-message').html("<span style='color:green;'>Registration successful!</span>");
                        // Redirect to dashboard or another page if needed
                       
                        if (userIsLoggedIn) {
  window.location.href = "dashboard.php";
} else {
  window.location.href = "login.php";
}
                    } else {
                        let errorMessage = "";
                        if (response.errors) {
                            response.errors.forEach(error => {
                                errorMessage += "<p style='color:red;'>" + error + "</p>";
                            });
                        } else if (response.message) {
                            errorMessage = "<p style='color:red;'>" + response.message + "</p>";
                        } else {
                            errorMessage = "<p style='color:red;'>An error occurred during registration.</p>";
                        }
                        $('#error-message').html(errorMessage);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    $('#error-message').html("<p style='color:red;'>A network error occurred.</p>");
                }
            });
        });
    });
</script>
<?php include_once('template/footer.php') ?>
