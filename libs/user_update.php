<?php
    require_once('connections.php');
    require_once('helpers.php');

    require_once('facebook-php-sdk-v4/src/Facebook/autoload.php');
    require_once('google-api-php-client/src/Google/autoload.php');

    session_start();

    check_admin($conn, 'list.php');

    $id = $_POST['user_id'];
    $admin = $_POST['is_admin'];

    // Delete the user.
    $sql = "UPDATE users SET is_admin=? WHERE user_id=?";
    $query = $conn->prepare($sql);
    $query->bindParam(1, $admin, PDO::PARAM_INT);
    $query->bindParam(2, $id, PDO::PARAM_INT);
    $query->execute();

    setcookie('message', 'User Updated', time() + 10, '/');
    header("Location: ".$page."cs/admin.php");
?>
