<?php
session_start();
include "./partials/conn.php"; // Include the refactored Database class

$database = new Database(); // Create an instance of the Database class

$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Get the task ID from the URL

// Call the deleteData method to remove the task
if ($id > 0 && $database->deleteData($id)) {
    // If successful, redirect back to the todoitems.php with a success message
    header("Location: todoitems.php?message=Task deleted successfully");
    exit;
} else {
    // If there was an error, display an error message
    header("Location: todoitems.php?message=Error deleting task or invalid task ID");
    exit;
}
