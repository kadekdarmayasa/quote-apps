<?php
require_once '../app/functions.php';

$id = $_SESSION['logged_in']['id'];
$result = query("SELECT * FROM user WHERE user_id=$id");
$username = $result[0]['username'];
$keyword = $_GET['keyword'];
$quotes = search($keyword);
$users = query("SELECT * FROM user_info");

?>

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