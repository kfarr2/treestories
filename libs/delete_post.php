<?php
require_once('helpers.php');
require_once('connections.php');
session_start();

// Get the user and post id
$user_id = $_SESSION['treestories_user_id'];
$post_id = escape_html($_GET['post_id']);

// Check to make sure the user actually has permissions to
// delete the post.
$sql = "SELECT created_by FROM posts WHERE post_id=?";
$query = $conn->prepare($sql);
$query->bindParam(1, $post_id, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll();

// Result shows the user does have permissions,
// so proceed.
if($result[0]["created_by"] == $user_id){
    $sql = "DELETE FROM posts WHERE post_id=?";
    $query = $conn->prepare($sql);
    $query->bindParam(1, escape_html($_GET['post_id']), PDO::PARAM_STR);
    $query->execute();
    $message = "Post successfully deleted";
} else {
    $message = "ERROR: You do not have access to this post";
}

setcookie("message", $message, time() + 60, '/'); // Cookie lives for 1 minute

header("Location: ".$page.'../list.php');

?>
