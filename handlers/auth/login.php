<?php

session_start();

include "../../database/db-connection.php";
include "../../jwt-helper.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db = connectDb();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(":username", $username);
    $result = $stmt->execute();

    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $token = createJWT($user["id"], $username);
        session_regenerate_id(true);
        $_SESSION['jwt'] = $token;
        header("Location: ../../index.php");
        exit();
    } else {
        echo "Incorrect values for username or password";
        echo "<a href='../../pages/auth/login-form.php'>Try again</a>";
    }
}