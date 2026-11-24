<?php
if (isset($_GET['users_id'])) {
    require_once('../db_connect.php');

    if ($conn) {
        $users_id = $_GET['users_id'];
        $sql = "DELETE FROM users WHERE users_id=?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameter
            $stmt->bind_param("i", $users_id); // "i" indicates an integer

            if ($stmt->execute()) {
                $sm = "Successfully Deleted";
                header("Location: ../inserte-records.php?success=$sm");
            } else {
                echo "Error deleting record: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
        $conn->close();
    } else {
        echo "Database connection failed.";
    }
} else {
    header("Location: ../inserte-records.php");
}
?>