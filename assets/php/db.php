<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "b3nauto";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("<h2> Erreur de connexion a la base de donnee " . $conn->connect_error."<h2>");
}
?>
