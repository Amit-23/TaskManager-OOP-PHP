<?php
session_start(); 

include "./partials/conn.php"; 

$database = new Database();
$errors = []; 
$taskname = $startdate = $enddate = $status = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation
    if (empty($_POST['taskname'])) {
        $errors['taskname'] = "*Task field cannot be empty!"; 
    } else {
        $taskname = htmlspecialchars($_POST['taskname']);
    }

    if (empty($_POST['startdate'])) {
        $errors['startdate'] = "*Start date cannot be empty!";
    } else {
        $startdate = htmlspecialchars($_POST['startdate']);
    }

    if (empty($_POST['enddate'])) {
        $errors['enddate'] = "*End date cannot be empty!";
    } else {
        $enddate = htmlspecialchars($_POST['enddate']);
    }

    if (!empty($startdate) && !empty($enddate) && strtotime($startdate) > strtotime($enddate)) {
        $errors['date'] = "*Start date cannot be later than end date!";
    }

    if (empty($_POST['status'])) {
        $errors['status'] = "*Task status cannot be empty!";
    } else {
        $status = htmlspecialchars($_POST['status']);
    }

    if (empty($errors)) {
        if ($database->insertData($taskname, $startdate, $enddate, $status)) {
            header("Location: todoitems.php?message=Task added successfully");
            exit;
        } else {
            $errors['general'] = "Failed to add task to the database.";
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: index.php");
    exit;
}

$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];
$taskname = $form_data['taskname'] ?? '';
$startdate = $form_data['startdate'] ?? '';
$enddate = $form_data['enddate'] ?? '';
$status = $form_data['status'] ?? '';

unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo - Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="card mx-auto" style="max-width: 400px; margin-top: 50px;">
        <div class="card-body">
            <h5 class="card-title">Add New Task</h5>

            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="mb-3">
                    <label for="taskname" class="form-label">Task Name</label>
                    <input type="text" class="form-control" id="taskname" name="taskname" value="<?= htmlspecialchars($taskname) ?>">
                    <?php if (isset($errors['taskname'])): ?>
                        <div class="text-danger"><?= htmlspecialchars($errors['taskname']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="startdate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startdate" name="startdate" value="<?= htmlspecialchars($startdate) ?>">
                    <?php if (isset($errors['startdate'])): ?>
                        <div class="text-danger"><?= htmlspecialchars($errors['startdate']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="enddate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="enddate" name="enddate" value="<?= htmlspecialchars($enddate) ?>">
                    <?php if (isset($errors['enddate'])): ?>
                        <div class="text-danger"><?= htmlspecialchars($errors['enddate']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="inprogress" <?= $status === 'inprogress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="overdue" <?= $status === 'overdue' ? 'selected' : '' ?>>Overdue</option>
                        <option value="started" <?= $status === 'started' ? 'selected' : '' ?>>Started</option>
                        <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <?php if (isset($errors['status'])): ?>
                        <div class="text-danger"><?= htmlspecialchars($errors['status']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <?php if (isset($errors['general'])): ?>
                    <div class="text-danger"><?= htmlspecialchars($errors['general']) ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>























