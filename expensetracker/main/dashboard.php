<?php
session_start();
require_once('../concludes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../main/main.html');
    exit();
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteExpense'])) {
        $expense_id = $_POST['deleteExpense'];
        $query = "DELETE FROM expenses WHERE id = $expense_id AND user_id = $user_id";
        mysqli_query($conn, $query);
    }
}

$query = "SELECT username FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);


$username = ($user) ? $user['username'] : 'Guest';

// user expenses
$query = "SELECT * FROM expenses WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$expenses = mysqli_fetch_all($result, MYSQLI_ASSOC);

// total expenses
$totalExpenses = array_sum(array_column($expenses, 'amount'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Dashboard</title>
    <link rel="stylesheet" href="../css/dboardstyle.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.gif">
   

</head>
<body>
<div class="page-container">
<div class="expense-table-container"> 

    <div class="header-container">
        <?php
        
        $username = isset($user['username']) ? $user['username'] : 'Guest';
        ?>

        <img src="../images/profile.png" alt="Profile Picture" class="profile-picture">
        <span class="username"><?php echo $username; ?></span>
    </div>

        <h1>Expense Tracker Dashboard</h1>
        <form id="expenseForm" action="../concludes/add_expense.php" method="post">
            
            <label for="amount">Amount:</label>
            <input type="number" step="0.01" id="amount" name="amount" required>
            
            <label for="description">Description:</label>
            <select id="description" name="description" class="description" onchange="toggleOtherDescription()" required>
                <option value="Food">Food</option>
                <option value="Rent">Rent</option>
                <option value="Clothes">Clothes</option>
                <option value="Utilities">Utilities</option>
                <option value="Others">Others</option>
            </select>

            <input type="text" id="othersDescription" name="othersDescription" class="description visible">
            <script src="script.js"></script>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            <button type="submit">Add Expense</button>
        </form>
       

        <h2>Your Expenses</h2>
        <p>Total Expenses: &#8369;<?php echo number_format($totalExpenses, 2); ?></p>
        <a href="set_budget.php" class="button">Set Budget</a>
        <a href="expense_history.php" class="button">Expense History</a>
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
                        <td>
                        <form method="post">
                            <input type="hidden" name="deleteExpense" value="<?php echo $expense['id']; ?>">
                            <button class="delete-btn" type="submit">&#10006;</button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="logout.php">Logout</a>
        
    </div>    
</div>    
</body>
</html>
