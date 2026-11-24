<?php

if (isset($_POST['first_name']) &&
    isset($_POST['last_name']) &&
    isset($_POST['users_id']) &&
    isset($_POST['email']) &&
    isset($_POST['role_id'])) {

    require_once('../db_connect.php');

    var_dump($_POST); // Debug: Check POST data

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $users_id = $_POST['users_id'];
    $role_id = $_POST['role_id'];

    if (empty($first_name) ||
        empty($last_name) ||
        empty($users_id) ||
        empty($email) ||
        empty($role_id)) {
        $em = "Please fill out all fields";
        header("Location: ../update.php?error=$em&users_id=$users_id");
        exit();
    } else {
		
        $sql = "UPDATE users SET first_name=?, last_name=?, email=?, role_id=? WHERE users_id=?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssii", $first_name, $last_name, $email, $role_id, $users_id); //check data types

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $sm = "Successfully updated";
                    header("Location: ../inserte-records.php?success=$sm");
                    exit();
                } else {
                    $em = "No rows affected. User ID might not exist or data is the same.";
                    header("Location: ../update.php?error=$em&users_id=$users_id");
                    exit();
                }
            } else {
                $em = "Error executing statement: " . $stmt->error . " Error number: " . $stmt->errno;
                header("Location: ../update.php?error=$em&users_id=$users_id");
                exit();
            }

            $stmt->close();
        } else {
            $em = "Error preparing statement: " . $conn->error;
            header("Location: ../update.php?error=$em&users_id=$users_id");
            exit();
        }
    }
} else {
    echo "POST data was not set correctly"; //debug
}
?>