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
    $book_title = $_POST['modify_book_title'];
    $author = $_POST['modify_author'];
    $genre = $_POST['modify_genre'];

    if (!empty($book_title) && !empty($author) && !empty($genre)) {
        $sql = "UPDATE books SET author='$author', genre='$genre' WHERE book_title='$book_title'";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to lab2.php after modification
            header("Location: lab2.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "All fields are required!";
    }
}

$conn->close();
?>
