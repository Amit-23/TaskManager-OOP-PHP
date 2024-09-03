<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Todo -Application</title>
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

    .form-control, .form-select, .btn {
      height: calc(2.5rem + 2px);
    }

    .btn-primary {
      width: 100%;
    }

    .error-message {
      color: red;
      font-size: 0.875em;
      margin-top: 0.25rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-container">
      <form id="taskForm" method="post" action="validation.php">
        <div class="mb-3">
          <label for="taskname" class="form-label">Task *</label>
          <input type="text" class="form-control" id="taskname" name="taskname" placeholder="Enter Task">
          <div id="tasknameError" class="error-message"></div>
        </div>
        <div class="mb-3">
          <label for="startdate" class="form-label">Starts At *</label>
          <input type="date" class="form-control" id="startdate" name="startdate">
          <div id="startdateError" class="error-message"></div>
        </div>
        <div class="mb-3">
          <label for="enddate" class="form-label">Ends At *</label>
          <input type="date" class="form-control" id="enddate" name="enddate">
          <div id="enddateError" class="error-message"></div>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Task Status *</label>
          <select class="form-select" id="status" name="status">
            <option value="">Select Status</option>
            <option value="started">Started</option>
            <option value="inprogress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="overdue">Overdue</option>
          </select>
          <div id="statusError" class="error-message"></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
</body>

</html>
