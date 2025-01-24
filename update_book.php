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
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];

    if (isset($_POST['update'])) {
        // Update book details
        if (!empty($book_title) && !empty($author) && !empty($genre)) {
            $sql = "UPDATE books SET author='$author', genre='$genre' WHERE book_title='$book_title'";

            if ($conn->query($sql) === TRUE) {
                // Redirect back to lab2.php after update
                header("Location: lab2.php");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "All fields are required for update!";
        }
    } elseif (isset($_POST['insert'])) {
        // Insert new book
        if (!empty($book_title) && !empty($author) && !empty($genre)) {
            $sql = "INSERT INTO books (book_title, author, genre) VALUES ('$book_title', '$author', '$genre')";

            if ($conn->query($sql) === TRUE) {
                // Redirect back to lab2.php after insertion
                                // Redirect back to lab2.php after insertion
                                header("Location: lab2.php");
                                exit();
                            } else {
                                echo "Error inserting record: " . $conn->error;
                            }
                        } else {
                            echo "All fields are required for insertion!";
                        }
                    }
                }
                
                $conn->close();
                ?>
                