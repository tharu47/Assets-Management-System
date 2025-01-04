<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];

    // Get the highest existing category_id
    $sql = "SELECT MAX(CAST(SUBSTRING(category_id, 4) AS UNSIGNED)) AS max_id FROM categories";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $max_id = $row['max_id'];

    // Increment the max_id to generate the new category_id
    $new_id = 'CAT' . str_pad($max_id + 1, 4, '0', STR_PAD_LEFT);

    // Insert the new category with the auto-generated category_id
    $sql = "INSERT INTO categories (category_id, category_name) VALUES ('$new_id', '$category_name')";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_categories.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin-top: 30px;
            margin-bottom: 30px;
            margin-left: 20%;
            margin-right: 20%;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            width: 100%;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form label {
            margin-bottom: 5px;
            color: #333;
        }
        .container form input, .container form button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .container form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .container form button:hover {
            background-color: #0056b3;
        }
        .container .go-back {
            background-color: #6c757d;
            color: #fff;
            text-align: center;
            border: none;
            cursor: pointer;
            padding: 10px;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            width: 95%;
        }
        .container .go-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Category</h1>
        <form method="POST" action="">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" required>
            <button type="submit">Add Category</button>
        </form>
        <a href="manage_categories.php" class="go-back">Go Back</a>
    </div>
</body>
</html>
