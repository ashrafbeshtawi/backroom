<?php
$host = 'postgresql';
$port = '5432';
$dbname = 'app';
$username = 'admin';
$password = 'example';
$connectionString = "host=$host port=$port dbname=$dbname user=$username password=$password";
$conn = pg_connect($connectionString);
if(!$conn) {
    echo "Error : Unable to open database\n";
} else {
    echo "Opened database successfully\n";
}
