<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation and Styling</title>
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
        h2 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        .messages {
            margin-bottom: 20px;
        }
        .messages p {
            margin: 0;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Validation</h2>
        <?php
        if (isset($_POST['submit'])) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
    
            $name = $_POST['name'];
            $id = $_POST['id'];
            $email = $_POST['email'];
            $title = $_POST['title'];
            $fees = $_POST['fees'];
            $token = $_POST['token'];
            $borrowDate = $_POST['borrow_date'];
            $returnDate = $_POST['return_date'];
            $valid = true;
            $messages = [];
    
            // Validate name
            if (empty($name)) {
                $messages[] = "<p class='error'>Name is required</p>";
                $valid = false;
            } else {
                $name = trim($name);
                if (!preg_match("/^[A-Za-z\s]*$/", $name)) {
                    $messages[] = '<p class="error">Name should contain only characters and spaces!</p>';
                    $valid = false;
                } else {
                    $messages[] = "<p class='success'>Name is Correct</p>";
                }
            }
    
            // Validate ID
            if (empty($id)) {
                $messages[] = "<p class='error'>ID is required</p>";
                $valid = false;
            } else {
                $id = trim($id);
                $pattern = "/^\d{2}-\d{5}-[1-3]$/";
                if (!preg_match($pattern, $id)) {
                    $messages[] = '<p class="error">ID does not match the required pattern!</p>';
                    $valid = false;
                } else {
                    $messages[] = "<p class='success'>ID submitted</p>";
                }
            }
    
            // Validate email
            if (empty($email)) {
                $messages[] = "<p class='error'>Email is required</p>";
                $valid = false;
            } else {
                $email = trim($email);
                if (!preg_match("/\d{2}-\d{5}-[1-3]+@+(student)+\.(aiub)+\.(edu)/", $email)) {
                    $messages[] = '<p class="error">Email should be a valid student email!</p>';
                    $valid = false;
                } else {
                    $messages[] = "<p class='success'>Email is Correct</p>";
                }
            }
    
            // Validate title
            if (empty($title)) {
                $messages[] = "<p class='error'>Title is required</p>";
                $valid = false;
            } else {
                $title = trim($title);
                if (!preg_match("/^[A-Za-z\s]*$/", $title)) {
                    $messages[] = '<p class="error">Title should contain only characters and spaces!</p>';
                    $valid = false;
                } else {
                    $messages[] = "<p class='success'>Title is Correct</p>";
                }
            }
    
            // Validate fees
            if (empty($fees)) {
                $messages[] = "<p class='error'>Fees is required</p>";
                $valid = false;
            } else {
                $fees = trim($fees);
                if (!preg_match("/^[0-9]*$/", $fees)) {
                    $messages[] = '<p class="error">Fees should contain only numbers!</p>';
                    $valid = false;
                } else {
                    $messages[] = "<p class='success'>Fees is Correct</p>";
                }
            }
    
            // Validate borrow date
            if (empty($borrowDate)) {
                $messages[] = "<p class='error'>Borrow date is required</p>";
                $valid = false;
            } else {
                $borrowDate = new DateTime($borrowDate);
            }
    
            // Validate return date
            if (empty($returnDate)) {
                $messages[] = "<p class='error'>Return date is required</p>";
                $valid = false;
            } else {
                $returnDate = new DateTime($returnDate);
                if ($returnDate <= $borrowDate) {
                    $messages[] = "<p class='error'>Return date must be after the borrow date</p>";
                    $valid = false;
                } else {
                    $interval = $borrowDate->diff($returnDate);
                    if (isset($token) && !empty($token)) {
                        $tokens = json_decode(file_get_contents('tokens.json'), true);
                        $validToken = in_array($token, $tokens['tokens']);
    
                        if ($validToken) {
                            $messages[] = "<p class='success'>Token is valid</p>";
                            $maxDays = 30;
                            $tokens['tokens'] = array_diff($tokens['tokens'], [$token]);
                            if (!isset($tokens['used'])) {
                                $tokens['used'] = [];
                            }
                            $tokens['used'][] = $token;
                            file_put_contents('tokens.json', json_encode($tokens));
                        } else {
                            $messages[] = "<p class='error'>Token is invalid or expired</p>";
                            $valid = false;
                            $maxDays = 10;
                        }
                    } else {
                        $maxDays = 10;
                    }
    
                    if ($interval->days > $maxDays) {
                        $messages[] = "<p class='error'>Return date cannot be more than $maxDays days from the borrow date</p>";
                        $valid = false;
                    }
                }
            }
    
            echo '<div class="messages">';
            foreach ($messages as $message) {
                echo $message . "<br>";
            }
            echo '</div>';
    
            if ($valid) {
                $cookie_name = "user_cookie";
                $cookie_value = $title;
                if (!isset($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name] !== $cookie_value) {
                    setcookie($cookie_name, $cookie_value, time() + (86400), "/");
                    echo "<p class='success'>Cookie has been set!</p>";
                } else {
                    echo "<p class='error'>Cookie already exists with the same value.</p>";
                }
            } else {
                echo "<p class='error'>Cookie has not been set due to validation errors.</p>";
            }
    
            if (isset($_COOKIE[$cookie_name])) {
                echo "<p>Cookie Value: " . $_COOKIE[$cookie_name] . "</p>";
            } else {
                echo "<p>No Cookie found!</p>";
            }
    
            if ($valid && (!isset($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name] !== $cookie_value)) {
                echo '<div class="container">';
                echo "<h2>Receipt</h2>";
                echo "<p>Name: $name</p>";
                echo "<p>ID: $id</p>";
                echo "<p>Email: $email</p>";
                echo "<p>Title: $title</p>";
                echo "<p>Fees: $fees</p>";
                echo "<p>Borrow Date: " . $borrowDate->format('Y-m-d') . "</p>";
                echo "<p>Return Date: " . $returnDate->format('Y-m-d') . "</p>";
                echo '</div>';
            }
    
            session_start();
            if (isset($_POST['username'])) {
                $_SESSION['user'] = $_POST['username'];
            }
            if (isset($_SESSION['user'])) {
                echo "<br><h1 style=\"color:red\">HI " . $_SESSION['user'] . "</h1>";
            }
    
            $url = $_SERVER['PHP_SELF'];
            header("refresh:20; url=$url");
        }
        ?>
        </div>
    </body>
    </html>
    