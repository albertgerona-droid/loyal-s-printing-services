<?php


 if (!isset($_SESSION['active_login']) && isset($_COOKIE['remember_token'])) {
    $remember_token = $_COOKIE['remember_token'];

    $find_data = $conn->prepare("SELECT * FROM accounts WHERE token = ?");
    $find_data->bind_param("s", $remember_token);
    $find_data->execute();
    $result = $find_data->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

   
        $token = bin2hex(random_bytes(32));

 
        $new_remember_token = bin2hex(random_bytes(32));


        $update = $conn->prepare("UPDATE accounts SET token = ? WHERE user_id = ?");
        $update->bind_param("ss", $token, $row['user_id']);
        $update->execute();

        setcookie("remember_token", $new_remember_token, time() + (7*24*60*60), "/", "", false, true);

        $_SESSION['active_login'] = $row['user_id'];
        $_SESSION['token'] = $token;
        $_SESSION['user_type'] = $row['user_type'];

        // Redirect
        if ($row['user_type'] === "Admin") {
            header("Location: admin");
        } elseif ($row['user_type'] === "Staff") {
            header("Location: staff");
        } else {
            header("Location: index.php");
        }
        exit;
    }
}

?>
