<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_book = $_POST['book'];
    $sql = "SELECT * FROM books WHERE book_title='$selected_book'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Title: " . $row["book_title"]. " - Author: " . $row["author"]. " - Genre: " . $row["genre"]. "<br>";
        }
    } else {
        echo "No results found";
    }
}

$conn->close();
?>
