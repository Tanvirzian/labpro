<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation and Token Handling</title>
    <style>
        /* Your existing styles */
        .grid-container4 {
            text-align: center;
            border: 5px solid rgb(44, 52, 52);
            padding: 5px;
            margin: 20px;
            display: flex;
            width: fit-content;
            height: fit-content;
        }
        .grid-container3 {
            text-align: center;
            border: 5px solid rgb(44, 54, 58);
            padding: 5px;
            margin: 20px;
            display: grid;
            width: fit-content;
            height: fit-content;
        }
        .grid-container {
            position: relative;
            text-align: center;
            border: 5px solid rgb(57, 15, 15);
            padding: 5px;
            margin: 20px;
            display: grid;
            width: 850px;
            height: 150px;
            border-radius: 10px;
            grid-template-columns: 33% 33% 33%;
        }
        .grid-container2 {
            text-align: center;
            border: 5px solid rgb(57, 15, 15);
            padding: 5px;
            margin: 20px;
            display: grid;
            grid-template-columns: 70% 30%;
        }
        .grid-container20 {
            text-align: center;
            border: 5px solid rgb(57, 15, 15);
            padding: 5px;
            margin: 20px;
            display: grid;
            width: 200px;
            height: 600px;
        }
        .grid-container1 {
            text-align: center;
            border: 5px solid rgb(57, 15, 15);
            padding: 5px;
            margin: 20px;
            display: grid;
            width: 850px;
            height: 500px;
            border-radius: 5px;
            grid-template-rows: 33% 33% 33%;
        }
        .form-container {
            background-color: #eaecee;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="date"],
        .form-container input[type="submit"],
        .form-container input[type="button"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"],
        .form-container input[type="button"] {
            background-color: #85929e;
            color: white;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover,
        .form-container input[type="button"]:hover {
            background-color: rgb(137, 202, 206);
        }

        .token-valid {
            background-color: #d5f5e3;
            color: #239b56;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .token-invalid {
            background-color: #f5b7b1;
            color: #c0392b;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="grid-container4">
        <div class="grid-container20">
            <h3>Invalid Tokens</h3>
            <?php
            $tokens = json_decode(file_get_contents('tokens.json'), true);
            $usedTokens = isset($tokens['used']) ? $tokens['used'] : [];
            foreach ($usedTokens as $usedToken) {
                echo "<div class='token-invalid'>{$usedToken}</div>";
            }
            ?>
        </div>
        <div class="grid-container3">
            <div class="grid-container1">
                <div style="background-color:#c6eef1">
                    <h3>Book List</h3>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "book_library");
                    $result = $conn->query("SELECT * FROM books");
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>{$row['book_title']} by {$row['author']} ({$row['genre']})</div>";
                    }
                    $conn->close();
                    ?>
                </div>
                <div style="background-color:">
                    <h3>Book Update</h3>
                    <form action="update_book.php" method="post">
                        <input type="text" name="book_title" placeholder="Book Title"><br>
                        <input type="text" name="author" placeholder="Author"><br>
                        <input type="text" name="genre" placeholder="Genre"><br>
                        <input type="submit" name="update" value="Update Book">
                        <input type="submit" name="insert" value="Insert Book">
                    </form>
                </div>
                <div style="background-color:#c6eef1">
                    <h3>Book Search</h3>
                    <form action="search.php" method="get">
                        <input type="text" name="search_query" placeholder="Search Books"><br>
                        <input type="submit" value="Search">
                    </form>
                </div>
            </div>
            <div class="grid-container">
                <div style="background-color:#c6eef1;"></div>
                <div style="background-color:"></div>
                <div style="background-color:#c6eef1;"></div>
            </div>
            <div class="grid-container2">
                <div class="form-container">
                    <form action="process.php" method="post">
                        <input type="text" name="name" placeholder="Full Name" required><br>
                        <input type="text" name="id" placeholder="Student ID"><br>
                        <input type="text" name="email" placeholder="Email"><br>
                        <input type="text" name="title" placeholder="Book Title"><br>
                        <input type="number" name="fees" placeholder="Fees"><br>
                        <input type="text" name="token" placeholder="Token"><br>
                        <input type="date" name="borrow_date"><br>
                        <input type="date" name="return_date"><br>
                        <input type="submit" name="submit" value="Submit">
                    </form>
                </div>
                <div id="tokens" style="background-color:#e4fbfc ">
                    <h3>Valid Tokens</h3>
                    <?php
                    foreach ($tokens['tokens'] as $token) {
                        echo "<div class='token-valid'>{$token}</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="grid-container20"></div>
    </div>
</body>
</html>
