<?php
    require_once('connections.php');
    require_once('helpers.php');

    require_once('facebook-php-sdk-v4/src/Facebook/autoload.php');
    require_once('google-api-php-client/src/Google/autoload.php');

    session_start();

    check_admin($conn, 'list.php');

    $id = $_POST['user_id'];

    // Delete all files posted by the user.
    $sql = "SELECT image_url FROM posts WHERE created_by=?";
    $query = $conn->prepare($sql);
    $query->bindParam(1, $id, PDO::PARAM_INT);
    $query->execute();

    $results = $query->fetchAll()[0];
    foreach($results as $result){
        $result = substr($result, 1, strlen($result));
        $deleted = unlink($_SERVER['DOCUMENT_ROOT'].'/'.$result);
        if(!$deleted){
            setcookie('message', 'ERROR: Unable to delete files.', time() + 10, '/');
            header("Location: ".$page."admin.php");
        }
    }

    // Delete all posts by the user.
    $sql = "DELETE FROM posts WHERE created_by=?";
    $query = $conn->prepare($sql);
    $query->bindParam(1, $id, PDO::PARAM_INT);
    $query->execute();

    // Delete the user.
    $sql = "DELETE FROM users WHERE user_id=?";
    $query = $conn->prepare($sql);
    $query->bindParam(1, $id, PDO::PARAM_INT);
    $query->execute();

    setcookie('message', 'User Deleted', time() + 10, '/');
    header("Location: ".$page."admin.php");
?>
