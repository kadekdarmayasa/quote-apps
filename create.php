<?php
require_once "app/functions.php";

$url_user_id = $_GET['id'];
$user_login_id = $_SESSION['logged_in']['id'];

if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $result = create_quote($_POST, $id);
    if ($result > 0) {
        echo "<script>alert('Congratulations! Your quote has been success created!');
            document.location.href = 'profile.php?id_user=$id'; 
        </script>";
    } else {
        $invalid_quote = true;
    }
}

if ($url_user_id != $user_login_id) {
    header('Location: profile.php?id_user=' . $user_login_id);
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quote</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/css/style2.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mt-3 mb-4">Create Quote</h5>
                        <form action="" method="post">
                            <div class="mb-4">
                                <textarea name="quote" id="quote" class="form-control" rows="5" placeholder="Type your quote" style="resize: none;" required></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary px-4">Create</button>
                            <a href="profile.php?id_user=<?= $user_login_id ?>" class="btn btn-danger">Cancel</a>
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