<?php
require_once 'app/functions.php';

$url_user_id = $_GET['id'];
$user_login_id = $_SESSION['logged_in']['id'];
$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $result = update($_POST);
    if ($result > 0) {
        echo "<script>
            alert('Your profile has been updated');
            document.location.href = 'profile.php?id_user=$user_login_id';
        </script>";
    } else if ($result == 0) {
        header('Location: profile.php?id_user=' . $user_login_id);
        exit;
    }
}

// check session
if (isset($_SESSION['logged_in']['login'])) {
    // if not true, redirect to login.php
    if ($_SESSION['logged_in']['login'] !== true) {
        header('Location: login.php');
        exit;
    }
}

// Check from url and sessiosn with key login, if is not same redirect to index.php
if ($url_user_id != $user_login_id) {
    header('Location: profile.php?id_user=' . $user_login_id);
    exit;
}

$user = query("SELECT * FROM user WHERE user_id=$id");
$user_email = $user[0]['email'];

$query = mysqli_query($conn, "SELECT user_info.* FROM user_info 
    INNER JOIN user ON user_info.user_email=user.email and user_info.user_email='$user_email'
");

$user = mysqli_fetch_assoc($query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/css/style2.css">

</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title my-4 text-center">Edit Profile</h4>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?= $user['id'] ?>">
                            <input type="hidden" name="old_picture" id="old_picture" value="<?= $user['img_profile'] ?>">
                            <input type="hidden" name="email" id="email" value="<?= $user['user_email'] ?>">
                            <div class="mb-4">
                                <label for="name" class="form-label text-muted">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $user['name_user'] ?>">
                            </div>
                            <div class="mb-4">
                                <label for="username" class="form-label text-muted">username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>">
                            </div>
                            <div class="mb-4">
                                <img src="asset/img/<?= $user['img_profile'] ?>" class="img-thumbnail" alt="profile" height="100" width="100">
                                <div id="emailHelp" class="form-text mb-2">Don't upload a picture that has the size more than 2mb*</div>
                                <input type="file" id="profile" name="profile">
                            </div>
                            <a href="profile.php?id_user=<?= $user_login_id; ?>" class="btn me-2 text-white ms-2 back-profile">Back</a>
                            <button type="submit" name="submit" class="btn text-white update">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>