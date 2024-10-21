<?php
session_start();
require_once('../concludes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../main/main.html');
    exit();
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateBudget'])) {
    $newBudget = $_POST['newBudget'];
    $budgetEndDate = $_POST['budgetEndDate'];

    // Update user's budget and budget end date
    $updateQuery = "UPDATE users SET budget = $newBudget, budget_end_date = '$budgetEndDate' WHERE id = $user_id";
    mysqli_query($conn, $updateQuery);
}

// get user's budget and budget end date
$budgetQuery = "SELECT budget, budget_end_date FROM users WHERE id = $user_id";
$budgetResult = mysqli_query($conn, $budgetQuery);
$userData = mysqli_fetch_assoc($budgetResult);
$userBudget = $userData['budget'];
$budgetEndDate = $userData['budget_end_date'];

// user's expenses
$query = "SELECT * FROM expenses WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$expenses = mysqli_fetch_all($result, MYSQLI_ASSOC);

// total expenses
$totalExpenses = array_sum(array_column($expenses, 'amount'));

// budget
$remainingBudget = $userBudget - $totalExpenses;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Expense History</title>
    <link rel="stylesheet" href="../css/historystyle.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.gif">
</head>
<body>
        <div class="budget-info">
            <p class="budget-label">Budget:</p>
            <p class="budget-value">&#8369;<?php echo number_format($userBudget, 2); ?></p>

            <p class="budget-label">Remaining Budget:</p>
            <p class="budget-value">&#8369;<?php echo number_format($remainingBudget, 2); ?></p>

            <p class="budget-label">Budget End Date:</p>
            <p class="budget-value"><?php echo $budgetEndDate; ?></p>

            <a href="set_budget.php" class="button">Edit Budget</a>
        </div>

    <div class="container">
        <h1>Expense History</h1>
        <table>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?php echo $expense['amount']; ?></td>
                        <td><?php echo $expense['description']; ?></td>
                        <td><?php echo $expense['date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><b>Total Expenses: &#8369;<?php echo number_format($totalExpenses, 2); ?> </b> </p>

        <a href="../main/dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
