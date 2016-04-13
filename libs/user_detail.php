<?php
require_once('helpers.php');
require_once('connections.php');

require_once('facebook-php-sdk-v4/src/Facebook/autoload.php');
require_once('google-api-php-client/src/Google/autoload.php');

session_start();

check_admin($conn, 'list.php');

$title = "Edit User";

include('light_header.php');

$sql = "SELECT * FROM users WHERE user_id=?";
$query = $conn->prepare($sql);
$query->bindParam(1, $_GET['id'], PDO::PARAM_INT);
$query->execute();
$result = $query->fetchAll()[0];

if(!isset($result)){
    setcookie('message', 'ERROR: That user does not exist.');
    header("Location: ".$page."admin.php");
}

?>

<div id="list-background"></div>
<div id="list-container" class="container">
    <div class="text-center"><h1>Edit User: <?php echo $result['name']; ?></h1></div>
    <hr />
    <div id="user_info">
        <div class="well">
            <p>ID: <?php echo $result['user_id']; ?></p>
            <p>Name: <?php echo $result['name']; ?></p>
            <p>Email: <?php echo $result['email']; ?></p>
            <p>Google ID: <?php echo $result['google_id']; ?></p>
            <p>Facebook ID: <?php echo $result['facebook_id']; ?></p>
        </div>
        <p><label class="block">Is Admin? <input name="is_admin" type="checkbox" <?php if($result['is_admin'] != 0){ echo "checked"; } ?> /></label></p>
        <div class="wrapper">
        <div class="btn-group" id="btn-group" role="group">
            <form class="btn-group" method="POST" action="/libs/userupdate.php">
                <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
            </form>
            <a href="/admin.php" class="btn btn-warning">Back</a>
            <?php
            if($result['user_id'] != $_SESSION['treestories_user_id']) {
                echo '<form class="btn-group" method="POST" action="/libs/user_delete.php">';
                echo '<input type="hidden" name="user_id" value="'.$result["user_id"].'" />';
                echo '<input type="submit" name="delete" value="Delete" class="btn btn-danger" onclick="confirm(\'Are you sure you want to delete this user? This cannot be undone.\')" />';
                echo '</form>';
            }
            ?>
        </div>
        </div>
    </div>
</div>
</body>
</html>
