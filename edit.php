<?php
session_start();
include "./partials/conn.php"; // Include the refactore

$database = new Database(); 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Get the task

// Fetch the task details based on the ID
if ($id > 0) {
    $tasks = $database->getData(); // Fetch all tasks
    $task = array_filter($tasks, fn($t) => $t['id'] == $id); // F
    $task = reset($task); 

    if (empty($task)) {
        // If no task is found with that ID, redirect to the todoitems.php with 
        header("Location: todoitems.php?message=Task not found");
        exit;
    }
} else {
    header("Location: todoitems.php?message=Invalid task ID");
    exit;
}

$errors = []; // Array to hold validation errors
$taskname = $task['taskname'];
$startdate = $task['startdate'];
$enddate = $task['enddate'];
$status = $task['status'];

// Handle the form submission to
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Task Name validation
    if (empty($_POST['taskname'])) {
        $errors['taskname'] = "*Task field cannot be empty!";
    } else {
        $taskname = htmlspecialchars($_POST['taskname']);
    }

    // Start Date validation
    if (empty($_POST['startdate'])) {
        $errors['startdate'] = "*Start date cannot be empty!";
    } else {
        $startdate = htmlspecialchars($_POST['startdate']);
    }

    // End Date validation
    if (empty($_POST['enddate'])) {
        $errors['enddate'] = "*End date cannot be empty!";
    } else {
        $enddate = htmlspecialchars($_POST['enddate']);
    }

    // Additional check: Start Date should not be later than End Date
    if (!empty($startdate) && !empty($enddate) && strtotime($startdate) > strtotime($enddate)) {
        $errors['date'] = "*Start date cannot be later than end date!";
    }

    // Status validation
    if (empty($_POST['status'])) {
        $errors['status'] = "*Task status cannot be empty!";
    } else {
        $status = htmlspecialchars($_POST['status']);
    }

    // If no errors, update the task details in the database
    if (empty($errors)) {
        if ($database->updateData($id, $taskname, $startdate, $enddate, $status)) {
            header("Location: todoitems.php?message=Task updated successfully");
            exit;
        } else {
            $error_message = "Failed to update task.";
        }
    }
}
?>

<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control, .form-select, .btn {
            height: calc(2.5rem + 2px);
        }

        .btn-success {
            width: 100%;
        }

        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25rem;
            font-weight: bold;
        }
    </style>
</head>

<div class="container">
    <div class="form-container">
        <h2>Edit Task</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="edit.php?id=<?= $id ?>">
            <div class="mb-3">
                <label for="taskname" class="form-label">Task Name *</label>
                <input type="text" class="form-control" id="taskname" name="taskname" value="<?= htmlspecialchars($taskname) ?>">
                <div class="error-message"><?= $errors['taskname'] ?? '' ?></div>
            </div>
            <div class="mb-3">
                <label for="startdate" class="form-label">Start Date *</label>
                <input type="date" class="form-control" id="startdate" name="startdate" value="<?= htmlspecialchars($startdate) ?>">
                <div class="error-message"><?= $errors['startdate'] ?? '' ?></div>
            </div>
            <div class="mb-3">
                <label for="enddate" class="form-label">End Date *</label>
                <input type="date" class="form-control" id="enddate" name="enddate" value="<?= htmlspecialchars($enddate) ?>">
                <div class="error-message"><?= $errors['enddate'] ?? '' ?></div>
                <div class="error-message"><?= $errors['date'] ?? '' ?></div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Task Status *</label>
                <select class="form-select" id="status" name="status">
                    <option value="started" <?= $status == "started" ? 'selected' : '' ?>>Started</option>
                    <option value="inprogress" <?= $status == "inprogress" ? 'selected' : '' ?>>In Progress</option>
                    <option value="completed" <?= $status == "completed" ? 'selected' : '' ?>>Completed</option>
                    <option value="overdue" <?= $status == "overdue" ? 'selected' : '' ?>>Overdue</option>
                </select>
                <div class="error-message"><?= $errors['status'] ?? '' ?></div>
            </div>
            <button type="submit" class="btn btn-success">Update Task</button>
            <a href="todoitems.php" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
