<?php
require "./partials/conn.php"; // Include the database connection file

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the task ID from the URL and convert it to an integer

    $database = new Database();
    $database->connect();

    // Call the deleteData method to remove the task
    if ($database->deleteData($id)) {
        // If successful, redirect back to the todoitems.php with a success message
        header("Location: todoitems.php?message=Task deleted successfully");
        exit;
    } else {
        // If there was an error, display an error message
        echo "Error deleting task.";
    }
} else {
    // Redirect back if no ID is provided
    header("Location: todoitems.php");
    exit;
}
