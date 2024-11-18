<?php

include "../database/db-connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $date = $_POST["date"];
    $amount  = $_POST["amount"];
    $type = $_POST["type"];

    $db = connectDb();

    $stmt = $db->prepare("INSERT INTO expenses (name, date, amount, type) VALUES(:name, :date, :amount, :type)");
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":date", $date);
    $stmt->bindValue(":amount", $amount);
    $stmt->bindValue(":type", $type);

    if($stmt->execute()){
        header("Location: ../index.php");
    } else {
        echo "Error creating expense: " . $db->lastErrorMsg();
    }

    $db->close();
} else {
    echo "Error";
}

