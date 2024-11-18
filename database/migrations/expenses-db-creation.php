<?php

include "./database/db-connection.php";

$db = connectDb();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS expenses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    date DATE NOT NULL,
    amount FLOAT NOT NULL,
    type TEXT NOT NULL
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Successfully created table.";
} else echo "Failed to create table.";

$db->close();