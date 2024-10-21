<?php
require_once('../concludes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];



    $query = "INSERT INTO users (username, password) VALUES ('$newUsername', '$newPassword')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: ../main/login.html');
    } else {
        echo 'Error registering user';
    }
}
?>
