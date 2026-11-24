<?php

if (
    isset($_POST['first_name']) &&
    isset($_POST['last_name']) &&
    isset($_POST['email']) &&
    isset($_POST['role_id']) &&
	isset($_POST['users_id'])
) {
    require_once('../db_connect.php');

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];
	$users_id = $_POST['users_id'];     
    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($role_id)||
		empty($users_id)
    ) {
        $em = "Please fill out all fields";
        header("Location: ../create.php?error=$em");
    } else {
        $sql = "INSERT INTO users(users_id,first_name, last_name, email, role_id) VALUES (? , ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameters
            $stmt->bind_param("isssi",$users_id, $first_name, $last_name, $email, $role_id); // "sssi" indicates string, string, string, integer

            if ($stmt->execute()) {
                if($stmt->affected_rows > 0){
                    $sm = "Successfully created";
                    header("Location: ../create.php?success=$sm");
                } else {
                    $em = "No rows affected, possible data issue";
                    header("Location: ../create.php?error=$em");
                }

            } else {
                $em = "Error executing statement: " . $stmt->error . " Error code: ". $stmt->errno;
                header("Location: ../create.php?error=$em");
            }

            $stmt->close();
        } else {
            $em = "Error preparing statement: " . $conn->error;
            header("Location: ../create.php?error=$em");
        }
    }
}
?>