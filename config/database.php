<?php

$host = "localhost";
$dbname = "eco_commerce";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed");
}