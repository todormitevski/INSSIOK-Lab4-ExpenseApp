<?php

include "../../jwt-helper.php";

session_start();
if (isset($_SESSION['jwt']) && decodeJWT($_SESSION['jwt'])) {
    header('Location: ../../index.php');
    exit();
}

?>

<form action="../../handlers/auth/login.php" method="post">
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </div>
    <button type="submit">Login</button>
    <div><a href="register-form.php">Register</a></div>
</form>