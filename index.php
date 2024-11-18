<?php

include "./database/db-connection.php";
include  "jwt-helper.php";

session_start();
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header('Location: ./pages/auth/login-form.php');
    exit();
}

$db = connectDb();
$query = "SELECT * FROM expenses";
$result = $db->query($query);

if (!$result) {
    die("Error: result is empty, " . $db->lastErrorMsg());
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expenses table</title>
</head>
<body>
    <div style="display: flex; flex-direction: row; justify-content: space-between; width: 20%;">
        <a href="pages/create-edit-form.php">Create expense</a>
        <a href="handlers/auth/logout.php">Logout</a>
    </div>
    <table style="width: 20%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result): ?>
                <?php while($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']) ?></td>
                        <td><?php echo htmlspecialchars($row['name']) ?></td>
                        <td><?php echo htmlspecialchars($row['date']) ?></td>
                        <td><?php echo htmlspecialchars($row['amount']) ?></td>
                        <td><?php echo htmlspecialchars($row['type']) ?></td>
                        <td>
                            <form action="pages/create-edit-form.php" method="get" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <button type="submit">Edit</button>
                            </form>
                            <form action="handlers/delete.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <input type="hidden" name="amount" value="<?php echo $row['amount'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Error.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>