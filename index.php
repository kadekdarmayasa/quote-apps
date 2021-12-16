<?php

require 'app/functions.php';

if (!isset($_SESSION['logged_in']['login'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['logged_in']['username'];
$id = $_SESSION['logged_in']['id'];

$join = "SELECT name_user FROM user_info INNER JOIN user ON user_info.username=user.username WHERE user_info.username='$username'";

$result = query("SELECT * FROM user WHERE user_id=$id");
$name = query($join);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/css/style2.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="">IKDAP QUOTE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active me-3" aria-current="page" href="#">Home</a>
                    <a class="nav-link me-3" href="quote.php">Quotes</a>
                    <a href="profile.php?id_user=<?= $result[0]['user_id'] ?>" class="nav-link me-3">
                        Profile
                    </a>
                    <a class="text-decoration-none text-white" href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <h1 class="text-center mt-5">Welcome <?= $name[0]['name_user'] ?></h1>
    <p class="text-center lead">Have a nice day😊</p>

    <!-- Bootstrap JS -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>