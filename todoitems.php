<?php
require "./partials/conn.php"; 

$database = new Database();
$tasks = $database->getData();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
        body {
            background: linear-gradient(135deg, #FFDEE9, #B5FFFC); 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
            max-width: 85%;
            margin-top: 30px;
            border: 2px solid #E3E6F3;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 15px;
        }

        .table thead th {
            background-color: #6C5CE7; /* Updated color for a modern look */
            color: #fff;
            text-align: center;
            border: none;
            font-weight: 600;
        }

        .table td, .table th {
            padding: 15px;
            vertical-align: middle;
            border-top: none;
        }

        .table-hover tbody tr:hover {
            background-color: #F1F2F6;
        }

        .status-overdue {
            background-color: red;
            color: #fff;
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 0.75em;
            margin-left: 5px;
            font-weight: bold;
        }

        .status-inprogress {
            background-color: pink;
            color: blueviolet;
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 0.75em;
            margin-left: 5px;
            font-weight: bold;
        }

        .status-completed {
            background-color: green;
            color: #fff;
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 0.75em;
            margin-left: 5px;
            font-weight: bold;
        }

        .status-started {
            background-color: orange;
            color: #fff;
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 0.75em;
            margin-left: 5px;
            font-weight: bold;
        }

        .btn {
            margin-right: 5px;
            border-radius: 20px;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #74B9FF;
            border-color: #74B9FF;
        }

        .btn-danger {
            background-color: #FF7675;
            border-color: #FF7675;
        }

        .btn-primary:hover {
            background-color: #0984E3;
            border-color: #0984E3;
        }

        .btn-danger:hover {
            background-color: #D63031;
            border-color: #D63031;
        }

        .btn-add {
            background-color: #55EFC4;
            border-color: #55EFC4;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        .btn-add:hover {
            background-color: #00B894;
            border-color: #00B894;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #6C5CE7;
        }

        .alert {
            border-radius: 15px;
            font-size: 1rem;
            padding: 10px 20px;
        }

        .btn-close {
            padding: 0.5rem;
            font-size: 1rem;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Alert message -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="header-section">
        <span class="title">Todo List</span>
        <a href="index.php" class="btn btn-add">Add New Task</a>
    </div>

    <div class="table-container">
        <table class="table table-hover text-center align-middle">
            <thead>
                <tr>
                    <th scope="col">Task</th>
                    <th scope="col">Starts At</th>
                    <th scope="col">Ends At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($tasks) > 0): ?>
                    <?php foreach ($tasks as $task): ?>
                        <?php
                            // Determine the status class based on task status
                            $statusClass = '';
                            if ($task['status'] === 'overdue') {
                                $statusClass = 'status-overdue';
                            } elseif ($task['status'] === 'inprogress') {
                                $statusClass = 'status-inprogress';
                            } elseif ($task['status'] === 'completed') {
                                $statusClass = 'status-completed';
                            } elseif ($task['status'] === 'started') {
                                $statusClass = 'status-started';
                            }
                        ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($task['taskname']) ?>
                                <sup class="<?= $statusClass ?>"><?= htmlspecialchars($task['status']) ?></sup>
                            </td>
                            <td><?= htmlspecialchars($task['startdate']) ?></td>
                            <td><?= htmlspecialchars($task['enddate']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $task['id'] ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?id=<?= $task['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No tasks found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
































