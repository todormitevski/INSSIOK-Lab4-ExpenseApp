<?php

include "./database/db-connection.php";

$db = connectDb();

$query = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    password TEXT NOT NULL
);
SQL;

$db->exec($query);
$db->close();