<?php
require_once "app/functions.php";

$url_user_id = $_GET['id_user'];
$user_login_id = $_SESSION['logged_in']['id'];

if (!isset($_SESSION['logged_in']['login'])) {
    header('Location: login.php');
    exit;
}

if ($url_user_id != $user_login_id) {
    header('Location: index.php');
    exit;
}

if (!isset($url_user_id)) {
    header('Location: index.php');
    exit;
}

$result = query("SELECT * FROM user WHERE user_id=$url_user_id");
$email = $result['0']['email'];

$joinClause = "SELECT name_user, img_profile FROM user_info 
                INNER JOIN user 
                ON user_info.user_email=user.email 
                and user_info.user_email='$email'
            ";

$userInfo = query($joinClause);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
                    <a class="nav-link me-3" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link me-3" href="quote.php">Quotes</a>
                    <a href="profile.php?id=<?= $url_user_id ?>" class="nav-link active me-3">
                        Profile
                    </a>
                    <a class="text-decoration-none text-white" href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navbar -->
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-8 col-lg-6">
                <?php foreach ($result as $user) : ?>
                    <div class="card">
                        <img src="asset/img/<?= $userInfo[0]['img_profile'] ?>" class="mx-auto mt-3 mb-2 rounded-circle" alt="profile" width="150" height="150">
                        <p class="text-muted text-center">@<?= $user['username'] ?></p>
                        <div class="card-body profile">
                            <p class="card-title">Member ID : <?= $user['user_id'] ?></p>
                            <p class="card-text">Name : <?= $userInfo[0]['name_user'] ?></p>
                            <p class="card-text">Email : <?= $user['email'] ?></p>
                            <p class="card-text">Member Since : <?= date('d F Y', $user['member_since']); ?></p>
                            <a class="btn back text-decoration-none text-white mt-4 me-2" href="index.php">Back</a>
                            <a class="btn edit text-decoration-none text-white mt-4 me-2" href="edit_profile.php?id=<?= $url_user_id; ?>">Edit Profile</a>
                            <a class="btn create text-decoration-none text-white mt-4 me-2" href="create.php?id=<?= $user_login_id ?>">Create Quote</a>
                        </div>
                    </div>
                <?php endforeach;  ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>