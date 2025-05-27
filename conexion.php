<?php
$servername = "localhost";
$username = "root";
$password="";
$dbname = "crud_php_bd";// nombre d ela base de datos



$conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión Fallida". connect_error);
    }
?>