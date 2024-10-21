<?php
session_start();
require_once('../concludes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $description = ($_POST['description'] === 'Others') ? $_POST['othersDescription'] : $_POST['description'];
    $date = $_POST['date'];

    $query = "INSERT INTO expenses (user_id, amount, description, date) VALUES ($user_id, $amount, '$description', '$date')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: ../mains/dashboard.php');
    } else {
        echo 'Error adding expense';
    }
}
?>
