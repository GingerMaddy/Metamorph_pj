<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Link to the external CSS file -->
    <title>Lepidoptera Monitor</title>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Lepidoptera Monitor</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">View Lepidoptera</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">View Cells</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <div>
        <h1>Welcome to Lepidoptera Monitor</h1>
        <a href="login.php" class="btn btn-primary btn-access">ACCEDI</a>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Lepidoptera Monitor. All rights reserved.</p>
    </footer>

</body>
</html>