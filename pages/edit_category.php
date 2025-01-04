<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    $sql = "UPDATE categories SET category_name = '$category_name' WHERE category_id = '$category_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_categories.php");
        exit;
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
}

// Fetch category details for editing
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM categories WHERE category_id = '$category_id'");

    if ($result->num_rows == 1) {
        $category = $result->fetch_assoc();
    } else {
        echo "<p class='error'>Category not found.</p>";
        exit;
    }
} else {
    echo "<p class='error'>No category ID provided.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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
        <h1>Edit Category</h1>
        <form method="POST" action="">
            <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">

            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" value="<?php echo $category['category_name']; ?>" required>
            
            <button type="submit">Update Category</button>
        </form>
        <a href="manage_categories.php" class="go-back">Go Back</a>
    </div>
</body>
</html>
