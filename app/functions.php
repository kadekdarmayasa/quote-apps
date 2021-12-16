<?php
session_start();

define("DB_NAME", "epiz_30604284_project_php");
define("DB_HOST", "sql110.epizy.com");
define("DB_PASS", "bKSwrljdQrk");
define("DB_USER", "epiz_30604284");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

function query($query)
{
    global $conn;
    $strquery = $query;
    $query = mysqli_query($conn, $strquery);
    $users = [];
    while ($result = mysqli_fetch_assoc($query)) {
        $users[] = $result;
    }
    return $users;
}

function registration($data)
{
    global $conn;
    $email = $data['email'];
    $username = $data['username'];
    $password = htmlspecialchars($data['password']);
    $result = query("SELECT email FROM user WHERE email='$email'");
    $img_profile = "default.jpg";
    $time = time();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['invalid_email'] = true;
        $_SESSION['already_email'] = false;
        return false;
    } else if ($result) {
        $_SESSION['already_email'] = true;
        return false;
    } else {
        $_SESSION['invalid_email'] = false;
    }

    if (!ctype_alnum($username)) {
        $_SESSION['invalid_username'] = true;
        return false;
    } else {
        $_SESSION['invalid_username'] = false;
        $username = strtolower($username);
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $queryToUser = "INSERT INTO user VALUES (
                null,
                '$username',
                '$email',
                '$password',
                $time
                )";

    $queryToUserInfo = "INSERT INTO user_info VALUES (
                null,
                '$email',
                '$username',
                '$img_profile',
                '$username'
                )";

    mysqli_query($conn, $queryToUser);
    mysqli_query($conn, $queryToUserInfo);

    return mysqli_affected_rows($conn);
}

function login($data)
{
    global $conn;
    $email = $data['email'];
    $password = htmlspecialchars($data['password']);

    $strquery = "SELECT * FROM user WHERE email='$email'";
    $result = query($strquery);

    if ($result == []) {
        return mysqli_affected_rows($conn);
    } else {
        if ($email == $result[0]['email']) {
            if (password_verify($password, $result[0]['password'])) {
                $_SESSION['logged_in'] = [
                    'username' => $result[0]['username'],
                    'email' => $result[0]['email'],
                    'id' => $result[0]['user_id'],
                    'login' => true
                ];
                header('Location: index.php');
                exit;
            } else {
                return 0;
            }
        }
    }
}


function upload()
{
    // file name will contains file name picture that in upload with its extension 
    $file_name = $_FILES['profile']['name'];
    // file size will contains picture file size that in upload
    $file_size = $_FILES['profile']['size'];
    $error = $_FILES['profile']['error'];
    // Place storage while || Tempat Penyimpanan sementara
    $tmp_name = $_FILES['profile']['tmp_name'];

    // cek apakah gambar sudah di upload
    if ($error === 4) {
        echo "<script>
                alert('Upload Picture first!');
            </script>";
        return false;
    }

    // cek apakah yang di upload gambar 
    $file_extension = ['jpg', 'jpeg', 'png'];
    $image_extension = explode('.', $file_name);
    $image_extension = strtolower(end($image_extension));

    if (!in_array($image_extension, $file_extension)) {
        echo "<script>
                alert('That you upload not a picture');
            </script>";
        return false;
    }

    // cek jika ukuran gambar terlalu besar 
    // ukuran file dalam bit, jika dia megabite maka 2
    if ($file_size > 2000000) {
        echo "<script>
                alert('Size of file is too large');
            </script>";
        return false;
    }

    // lolos pengecekan gambar akan di upload
    // generate nama gambar baru 
    $name_file_new = uniqid(); // generate string random
    $name_file_new .= '.' . $image_extension;

    move_uploaded_file($tmp_name, "asset/img/$name_file_new");

    return $name_file_new;
}

function update($data)
{
    global $conn;

    $id = $data['id'];
    $email = $data['email'];
    $name = htmlspecialchars($data['name']);
    $username = htmlspecialchars($data['username']);
    $old_profile = $data['old_picture'];


    // check the user is he/she change picture or no
    if ($_FILES['profile']['error'] === 4) {
        $new_profile = $old_profile;
    } else {
        $new_profile = upload();
    }


    // Update row on table user_info
    $queryToUserInfo = "UPDATE user_info SET 
                user_email = '$email',
                name_user = '$name',
                img_profile = '$new_profile',
                username = '$username'
            WHERE id = $id
    ";


    // Update row on table user
    $queryToUser = "UPDATE user SET username = '$username' WHERE email='$email'";

    // Update row on table user
    $queryToUserQuote = "UPDATE user_quote SET username = '$username' WHERE email='$email'";

    // query to user_info
    mysqli_query($conn, $queryToUserInfo);
    // query to user 
    mysqli_query($conn, $queryToUser);
    // query to user 
    mysqli_query($conn, $queryToUserQuote);

    return mysqli_affected_rows($conn);
}


function wrapper_reset_password($data)
{
    global $conn;
    $email = $data['email'];

    $query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
    $result = mysqli_fetch_assoc($query);

    if (!is_null($result)) {
        header('Location: reset_password.php?id=' . $result['user_id']);
        exit;
    }

    return mysqli_num_rows($query);
}


function reset_password($data, $iduser)
{
    global $conn;
    $password = $data['password'];
    $confirm_password = $data['password2'];
    $id = $iduser;

    $query = mysqli_query($conn, "SELECT password FROM user WHERE user_id=$id");
    $user_id = mysqli_fetch_assoc($query);

    if ($password != $confirm_password) {
        return false;
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE user SET password='$password' WHERE user_id=$id");
        return mysqli_affected_rows($conn);
    }
}

function create_quote($data, $id)
{
    global $conn;
    $quote = htmlspecialchars($data['quote']);
    $user_id = $id;
    $time = time();

    $user = query("SELECT * FROM user WHERE user_id=$user_id");
    $user_email = $user[0]['email'];
    $username = $user[0]['username'];

    $insertToQuote = "INSERT INTO user_quote
                            VALUES (
                            null,
                            '$quote',
                            '$user_email',
                            $time,
                            '$username'
                        )";
    mysqli_query($conn, $insertToQuote);
    return mysqli_affected_rows($conn);
}

function search($keyword)
{
    $result = query("SELECT * FROM user_quote WHERE 
        username LIKE '%$keyword%' OR
        quote LIKE '%$keyword%'
    ");
    return $result;
}
