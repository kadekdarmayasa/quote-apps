<?php
require_once 'app/functions.php';

$id = $_SESSION['logged_in']['id'];
$result = query("SELECT * FROM user WHERE user_id=$id");
$users = query("SELECT * FROM user_info");
$username = $result[0]['username'];
$quotes = query("SELECT * FROM user_quote");

if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $quotes = search($keyword);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/css/style2.css">
    <style>
        .card-text {
            margin-top: -10px;
        }

        form {
            display: flex;
        }
    </style>
</head>

<body class="pb-5">
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="">IKDAP QUOTE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link me-3" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link active me-3" href="quote.php">Quotes</a>
                    <a href="profile.php?id_user=<?= $result[0]['user_id'] ?>" class="nav-link me-3">
                        Profile
                    </a>
                    <a class="text-decoration-none text-white" href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navbar -->


    <!-- search -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <!-- heading -->
                <h3 class="text-center mt-4">Search Quote</h1>
                    <!-- search bar -->
                    <form action="" method="post">
                        <input type="text" class="form-control me-3" id="keyword" name="keyword" autocomplete="off" autofocus>
                        <button type="submit" class="btn btn-primary" id="search" name="search">search</button>
                    </form>
            </div>
        </div>
    </div>

    <!-- search -->

    <!-- quotes -->
    <div class="container" id="quotes">
        <div class="row justify-content-center">
            <?php if ($quotes == []) : ?>
                <div class="col-lg-4 mt-4">
                    <div class="alert alert-danger" role="alert">
                        Quote doesn't exist
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($quotes as $quote) : ?>
                <?php
                $email = $quote['email'];
                $join = "SELECT img_profile FROM user_info INNER JOIN user_quote ON user_info.user_email=user_quote.email and 
                        user_info.user_email='$email';
                ";
                $user = mysqli_fetch_assoc(mysqli_query($conn, $join));
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card mt-4">
                        <div class="card-body">
                            <img src="asset/img/<?= $user["img_profile"] ?>" width="80" height="80" alt="profile" class="rounded-circle mb-3 mx-auto d-block">
                            <p class="card-title text-center"><q><?= $quote["quote"]; ?></q></p>
                            <?php if ($quote["username"] == $username) :  ?>
                                <p class="card-text  text-center text-primary">~ <?= $quote["username"]; ?> ~</p>
                            <?php else : ?>
                                <p class="card-text  text-center text-black-50">~ <?= $quote["username"]; ?> ~</p>
                            <?php endif; ?>
                            <p class="card-text  text-center text-muted"><?= date("d F Y", $quote["created_at"]); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end quotes -->
    <!-- Bootstrap JS -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>