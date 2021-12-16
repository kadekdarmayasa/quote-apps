<?php
require_once "app/functions.php";

if (isset($_POST['submit'])) {
    $result = reset_password($_POST, $_GET['id']);
    if ($result > 0) {
        echo "<script>
            alert('Your password has been updated!');
            document.location.href = 'login.php';
        </script>";
    } else if ($result == 0) {
        $password_not_match = true;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- BOOSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="asset/css/auth2.css">
</head>

<body>


    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <div class="card px-4 pt-4 pb-3">
                    <div class="card-body">
                        <?php if (isset($password_not_match)) : ?>
                            <div class="alert alert-danger text-center" role="alert">
                                Password doesn't match!
                            </div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="mb-4">
                                <label for="password" class="form-label">New password</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                            </div>
                            <div class="mb-4">
                                <label for="password2" class="form-label">Confirm password</label>
                                <input type="password" class="form-control" id="password2" name="password2" autocomplete="off" required>
                            </div>
                            <button type="submit" name="submit" class="btn">Enter</button>
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