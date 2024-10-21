<?php
require_once('../concludes/db.php');


$adminUsername = 'jltadmin'; 
$adminPassword = password_hash('jltadmin123', PASSWORD_DEFAULT); 

$query = "INSERT INTO users (username, password, is_admin) VALUES ('$adminUsername', '$adminPassword', 1)";
mysqli_query($conn, $query);

echo 'Admin registered successfully!';
?>
