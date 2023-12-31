<?php

// Adds a Flashcard attempt to the database

// Database authorization
require "database/config.php";

// Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
}

// Assign table input from POST request
// real_escape_string sanitizes input to prevent SQL injection
$sid = $conn->real_escape_string($_POST['SID']);
$cid = intval($conn->real_escape_string($_POST['CID']));
$grade = intval($conn->real_escape_string($_POST['Grade']));
// Can use string for time object. Need to make sure format is correct
$timespent = $conn->real_escape_string($_POST['TimeSpent']);
$answer = $conn->real_escape_string($_POST['Answer']);
$login = intval($conn->real_escape_string($_POST['Login']));

// Prepared statement ensures matching data types
$stmt = $conn->prepare("INSERT INTO Cardiac_case_attempts (SID, CID, Grade, TimeSpent, Answer, Login) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siissi", $sid, $cid, $grade, $timespent, $answer,$login );

// return statements
if ($stmt->execute())
{
    echo "New record created successfully";
}
else
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
mysqli_close($conn);

?>
