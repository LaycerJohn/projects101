<?php
session_start();
require_once('../concludes/db.php');

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ../main/dashboard.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $action = $_POST['action'];
    $userId = $_POST['user_id'];
   
    $status = ($action === 'deactivate') ? 0 : 1;

    $query = "UPDATE users SET is_active = $status WHERE id = $userId";
    mysqli_query($conn, $query);
}

//  exclude the admin 
$query = "SELECT * FROM users WHERE is_admin = 0";
$result = mysqli_query($conn, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adminstyle.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.gif">
    <title>Admin Dashboard</title>
</head>
<body>

    <div class="admin-container">
        <h1>Welcome, Admin!</h1>
        <h2>User Accounts</h2>
    
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <?php if ($user['is_active'] == 1): ?>
                                    <button type="submit" name="action" value="deactivate">Deactivate</button>
                                <?php else: ?>
                                    <button type="submit" name="action" value="activate">Activate</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a class="logout" href="../main/logout.php">Logout</a>
</body>
</html>
