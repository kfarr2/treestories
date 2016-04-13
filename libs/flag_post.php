<?php
    require_once('connections.php');
    require_once('helpers.php');

    require_once('facebook-php-sdk-v4/src/Facebook/autoload.php');
    require_once('google-api-php-client/src/Google/autoload.php');

    session_start();

    check_admin($conn, '/list.php');

    $id = $_POST['post_id'];

    $sql = "UPDATE posts SET flagged=1 WHERE post_id=?";
    $query = $conn->prepare($sql);
    $query->bindParam(1, $id, PDO::PARAM_INT);
    $query->execute();

    $sql = "SELECT DISTINCT email FROM users WHERE is_admin=1";
    $query = $conn->prepare($sql);
    $query->execute();

    $emails = $query->fetchAll();

    $link = $page."list.php?id=".$id;

    foreach($emails as $email){
        $subject = "ALERT: Potentially Inappropriate Post Flagged";
        $title = "A Post has been Flagged as Inappropriate.";

        $message = "
            <html>
            <head>
                <title>".$title."</title>
            </head>
            <body>
            <p>Hello</p>
            <p>You are recieving this email because you are listed as an administrator for the Tree Stories web application.</p>
            <p>A recent post has been flagged by a user as inappropriate. The post in question can be found at the following link:</p>
            <p>".$link."</p>
            ";
        $headers = "MIME-Version: 1.0"."\r\n"."Content-type:text-html;charset=UTF-8"."\r\n";
        $headers .= "From: reminder@treestories.com"."\r\n";
        mail($email['email'], $subject, $message, $headers);
    }

    // Set the cookie
    setcookie('message', "Post has been flagged as inappropriate. An administrator has been notified.", time()+10, '/');
    header("Location: ".$page."../list.php");
?>
