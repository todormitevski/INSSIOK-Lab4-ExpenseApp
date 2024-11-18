<?php

function connectDb(): SQlite3 {
    return new SQLite3(__DIR__ . "/db.sqlite");
}