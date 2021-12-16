<?php
require_once "app/functions.php";

if (isset($_SESSION['logged_in']['login'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    $registration = registration($_POST);
    if ($registration > 0) {
        $success = true;
    } else {
        if (isset($_SESSION['already_email'])) {
            if ($_SESSION['already_email'] == true) {
                $already_email = true;
            }
        }

        if (isset($_SESSION['invalid_email'])) {
            if ($_SESSION['invalid_email'] == true) {
                $invalid_email = true;
            }
        }

        if (isset($_SESSION['invalid_username'])) {
            if ($_SESSION['invalid_username'] == true) {
                $invalid_username = true;
            }
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
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
                    <h3 class="text-center">New Account</h3>

                    <?php if (isset($already_email)) : ?>
                        <div class="alert alert-danger text-center" role="alert">
                            Email already registered!
                        </div>
                    <?php elseif (isset($invalid_email)) : ?>
                        <div class="alert alert-danger text-center" role="alert">
                            Invalid email!
                        </div>
                    <?php endif; ?>

                    <?php if (isset($invalid_username)) : ?>
                        <div class="alert alert-danger text-center" role="alert">
                            Invalid username!
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success)) : ?>
                        <div class="alert alert-success text-center" role="alert">
                            Congratulations! Your account has been success created. <br> <a href="login.php" class="link-success">Please Login</a>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" autocomplete="off" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" autocomplete="off" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="submit" class="btn px-2">Registration</button>
                            <div class="mt-4 text-center">
                                Have an account? <a href="login.php" class="link-primary">sign in here!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>