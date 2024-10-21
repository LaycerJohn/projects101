<?php
session_start();
require_once('../concludes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../main/main.html');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form for updating the budget is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateBudget'])) {
    $newBudget = $_POST['newBudget'];
    $budgetEndDate = $_POST['budgetEndDate'];

    // Update the user's budget and budget end date
    $updateQuery = "UPDATE users SET budget = $newBudget, budget_end_date = '$budgetEndDate' WHERE id = $user_id";
    mysqli_query($conn, $updateQuery);
}

// Retrieve user's budget and budget end date
$budgetQuery = "SELECT budget, budget_end_date FROM users WHERE id = $user_id";
$budgetResult = mysqli_query($conn, $budgetQuery);
$userData = mysqli_fetch_assoc($budgetResult);
$userBudget = $userData['budget'];
$budgetEndDate = $userData['budget_end_date'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Set Budget</title>
    <link rel="stylesheet" href="../css/setbudgetstyle.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.gif">
</head>
<body>
    <div class="page-container">
        <div class="budget-form-container">
            <h1>Set Your Budget</h1>
            <form method="post" action="">
                <label for="newBudget">Budget:</label>
                <input type="number" step="0.01" id="newBudget" name="newBudget" value="<?php echo $userBudget; ?>" required>

                <label for="budgetEndDate">Budget End Date:</label>
                <input type="date" id="budgetEndDate" name="budgetEndDate" value="<?php echo $budgetEndDate; ?>" required>

                <button type="submit" name="updateBudget">Update Budget</button>
            </form>
            <a href="../main/expense_history.php" class="button">Expense History</a>
            <a href="../main/dashboard.php">Expense Dashboard</a>
        </div>
    </div>
</body>
</html>
