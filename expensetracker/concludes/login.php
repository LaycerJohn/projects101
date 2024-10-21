<?php
session_start();
require_once('../concludes/db.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $user = mysqli_fetch_assoc($result)) {
        if ($user['is_active'] == 1) {
            $_SESSION['user_id'] = $user['id'];

            if ($user['is_admin'] == 1) {
                $_SESSION['is_admin'] = true;
                header('Location: ../admin/admin_dashboard.php');
                exit();
            } else {
                header('Location: ../main/dashboard.php');
                exit();
            }
        } else {
            $errors[] = "Your account is not active. Please contact the admin.";
        }
    } else {
        $errors[] = "Invalid username or password.";
    }
}


if (!empty($errors)) {
    echo '<script>alert("' . implode('\n', $errors) . '");</script>';
    
    echo '<script>window.history.back();</script>';
}
?>
