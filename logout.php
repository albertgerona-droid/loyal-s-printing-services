<?php
include 'index.php';


    // Invalidate token in DB if session is active
    if (isset($_SESSION['active_login'])) {
        $stmt = $conn->prepare("UPDATE accounts SET token = NULL WHERE user_id = ?");
        $stmt->bind_param("i", $user_idko);
        $stmt->execute();
    }

    
    // Clear session
    $_SESSION = array();

    // Clear session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Clear remember_token cookie
    setcookie("remember_token", "", time() - 3600, "/", "", false, true); // HttpOnly

    // Destroy session
    session_destroy();

    // Redirect
    echo "<script>location.href='../index.php';</script>";
    exit;

?>
