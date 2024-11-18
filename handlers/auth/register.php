<?php

include "../../database/db-connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (strlen($username) < 3 || strlen($password) < 6) {
        die("Invalid values.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $db = connectDb();
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":password", $hashedPassword);

    $stmt->execute();
    echo "Registration successful! <a href='../../pages/auth/login-form.php'>Login</a>";

}