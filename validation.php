<?php

include "./partials/conn.php"; // Include the database connection file

$database = new Database();
$errors = []; // Array to hold validation errors
$taskname = $startdate = $enddate = $status = ""; // Variables to hold form data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Server-side validation

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

  // If no errors, process the form
  if (empty($errors)) {
    // Insert data into the database
    if ($database->insertData($taskname, $startdate, $enddate, $status)) {
      // Redirect to todoitems.php with success message
      header("Location: todoitems.php?message=Task added successfully");
      exit;
    } else {
      $errors['general'] = "Failed to add task to the database.";
    }
  }
}

// Display the form with any error messages
displayForm($taskname, $startdate, $enddate, $status, $errors);

function displayForm($taskname, $startdate, $enddate, $status, $errors = [])
{
?>
  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body {
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      }

      .form-control,
      .form-select,
      .btn {
        height: calc(2.5rem + 2px);
      }

      .btn-primary {
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

  <body>
    <div class="container">
      <div class="form-container">
        <!-- General Error Message -->
        <?php if (!empty($errors['general'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>
        <form method="post" action="validation.php">
          <div class="mb-3">
            <label for="taskname" class="form-label">Task *</label>
            <input type="text" class="form-control" id="taskname" name="taskname" value="<?= htmlspecialchars($taskname) ?>">
            <div class="error-message"><?= $errors['taskname'] ?? '' ?></div>
          </div>
          <div class="mb-3">
            <label for="startdate" class="form-label">Starts At *</label>
            <input type="date" class="form-control" id="startdate" name="startdate" value="<?= htmlspecialchars($startdate) ?>">
            <div class="error-message"><?= $errors['startdate'] ?? '' ?></div>
          </div>
          <div class="mb-3">
            <label for="enddate" class="form-label">Ends At *</label>
            <input type="date" class="form-control" id="enddate" name="enddate" value="<?= htmlspecialchars($enddate) ?>">
            <div class="error-message"><?= $errors['enddate'] ?? '' ?></div>
            <div class="error-message"><?= $errors['date'] ?? '' ?></div>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Task Status *</label>
            <select class="form-select" id="status" name="status">
              <option value="">Select Status</option>
              <option value="started" <?= $status == "started" ? 'selected' : '' ?>>Started</option>
              <option value="inprogress" <?= $status == "inprogress" ? 'selected' : '' ?>>In Progress</option>
              <option value="completed" <?= $status == "completed" ? 'selected' : '' ?>>Completed</option>
              <option value="overdue" <?= $status == "overdue" ? 'selected' : '' ?>>Overdue</option>
            </select>
            <div class="error-message"><?= $errors['status'] ?? '' ?></div>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </body>

  </html>
<?php
}
?>
