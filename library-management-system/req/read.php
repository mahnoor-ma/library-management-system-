<?php
function read($conn) {
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $result = [];
        $stmt->bind_result($users_id, $first_name, $last_name, $email, $role_id); // Bind results
        while ($stmt->fetch()) {
            $result[] = [
                'users_id' => $users_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'role_id' => $role_id,
            ];
        }
        $users = $result;
    } else {
        $users = 0;
    }

    $stmt->close();
    return $users;
}

function readById($conn, $users_id) {
    $sql = "SELECT * FROM users WHERE users_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $users_id); // Bind the parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $user = 0;
    }
    $stmt->close();
    return $user;
}
?>