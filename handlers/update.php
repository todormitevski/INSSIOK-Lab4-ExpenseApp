<?php

include "../database/db-connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $name = $_POST["name"];
    $date = $_POST["date"];
    $amount  = $_POST["amount"];
    $type = $_POST["type"];

    $db = connectDb();

    $query = "UPDATE expenses SET name = :name, date = :date, amount = :amount, type = :type WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(":name", $name, SQLITE3_TEXT);
    $stmt->bindValue(":date", $date, SQLITE3_TEXT);
    $stmt->bindValue(":amount", $amount, SQLITE3_FLOAT);
    $stmt->bindValue(":type", $type, SQLITE3_TEXT);
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->execute();

    $db->close();

    header("Location: ../index.php");
    exit();
} else {
    echo "Error";
}