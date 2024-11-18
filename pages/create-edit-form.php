<?php

include "../database/db-connection.php";
include  "../jwt-helper.php";

session_start();
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header('Location: ./auth/login-form.php');
    exit();
}

$db = connectDb();

$editing = isset($_GET['id']);
$expense = ['id' => '', 'name' => '', 'date' => '', 'amount' => '', 'type' => ''];

if($editing) {
    $id = $_GET['id'];
    $query = "SELECT * FROM expenses WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $expense = $result->fetchArray(SQLITE3_ASSOC);

    if(!$expense) {
        echo "Expense not found";
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $editing ? "Update expense" : "Create expense" ?></title>
</head>
<body>
    <form action="<?php echo $editing ? "../handlers/update.php" : "../handlers/create.php" ?>" method="post"
          style="display:flex; flex-direction: column; width: 20%; gap: 5px;">
        <input type="hidden" name="id" value="<?= $expense['id'] ?>">
        <label for="name">Name: </label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($expense['name']) ?>" required>
        <label for="date">Date: </label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($expense['date']) ?>" required>
        <label for="amount">Amount: </label>
        <input name="amount" value="<?php echo htmlspecialchars($expense['amount']) ?>">
        <label for="type">Type: </label>
        <select name="type" id="type" required>
            <option value="Cash" <?= isset($expense['type']) && $expense['type'] == "Cash" ? 'selected' : ''?>>Cash</option>
            <option value="Card" <?= isset($expense['type']) && $expense['type'] == "Card" ? 'selected' : ''?>>Card</option>
        </select>
        <button type="submit"><?php echo $editing ? "Update" : "Create" ?></button>
        <a href="../index.php">Cancel</a>
    </form>
</body>
</html>