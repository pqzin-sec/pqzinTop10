<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/icon.gif">
    <title>pqzin Form 😀👍</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pqzin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Add Vulnerabilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./debug_json.php">json</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-5">Pqzin Top 10 Add Vuln</h1>
        <form action="" method="POST">
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Select a category</option>
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                    <option value="A5">A5</option>
                    <option value="A6">A6</option>
                    <option value="A7">A7</option>
                    <option value="A8">A8</option>
                    <option value="A9">A9</option>
                    <option value="A10">A10</option>
                    <!-- Add other categories as needed -->
                </select>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="amount">Quantity</label>
                <input type="number" class="form-control" id="amount" name="amount" min="1" required>
            </div>

            <!-- Severity -->
            <div class="form-group">
                <label for="severity">Severity</label>
                <select class="form-control" id="severity" name="severity" required>
                    <option value="">Select severity</option>
                    <option value="informational">Informational</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
            </div>

            <div class="form-group">
                <label for="severity">Month</label>
                <select id="month" class="form-control" name="month">
                    <option value="" selected>None</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <br>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>

<?php
if (!isset($_POST['name'], $_POST['category'], $_POST['amount'], $_POST['severity'])) {
    die();
}

require_once '../includes/insert.php';
$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
$category = htmlspecialchars(trim($_POST['category']), ENT_QUOTES, 'UTF-8');
$severity = htmlspecialchars(trim($_POST['severity']), ENT_QUOTES, 'UTF-8');
$amount = (int)$_POST['amount'];
$month = !empty($_POST['month']) ? $_POST['month'] : null;



if ((empty($name) || empty($category) || empty($severity) || $amount <= 0)) {
    die();
}

insert_vulnerability($name, $category, $amount, $severity, $pdo, $month);
echo "<script>alert('OK!')</script>";
?>