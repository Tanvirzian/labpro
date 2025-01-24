<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search Results</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "book_library";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $search_query = $_GET['search_query'];
            $sql = "SELECT * FROM books WHERE book_title LIKE '%$search_query%' OR author LIKE '%$search_query%' OR genre LIKE '%$search_query%'";
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
    </div>
</body>
</html>
