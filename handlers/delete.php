<?php

include "../database/db-connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $amount  = floatval($_POST["amount"]);
    $db = connectDb();

    if($amount > 100) {
        echo "Amount greater than 100, cannot delete.";
        exit();
    }

    $stmt = $db->prepare("DELETE FROM expenses WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();

    header("Location: ../index.php");
    exit();
} else {
    echo "Error";
}