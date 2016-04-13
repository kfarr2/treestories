<?php
require_once('libs/helpers.php');

require_once('libs/facebook-php-sdk-v4/src/Facebook/autoload.php');
require_once('libs/google-api-php-client/src/Google/autoload.php');

session_start();

// This page requires admin privileges
check_admin($conn, 'list.php');

$title = "User Management";

$sql = "SELECT * FROM users ORDER BY name";
$result = $conn->prepare($sql);
$result->execute();
$users = $result->fetchAll();

messages();

include('libs/light_header.php');
?>
<div id="list-background"></div>
<div id="list-container" class="container">
    <div class="row">
        <div class="col-md-11">
            <h1>Users</h1>
        </div>
        <div class="col-md-1">
            <a href="<?php echo $page . "list.php"; ?>" class="btn btn-default pull-right">Back</a>
        </div>
    </div>
<table class="table table-striped">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Facebook</th>
    <th>Google</th>
    <th>Admin?</th>
    <th>Edit</th>
</tr>
<?php
foreach($users as $row){
    $admin = "";
    $is_admin = "";
    if($row["is_admin"] == 1){
        $admin = "checked";
        $is_admin = "<span class='glyphicon glyphicon-ok'></span>";
    }

    $html = "<tr><td>".$row['user_id']."</td>";
    $html .= "<td>".$row['name']."</td>";
    $html .= "<td>".$row['email']."</td>";
    $html .= "<td>".$row['facebook_id']."</td>";
    $html .= "<td>".$row['google_id']."</td>";
    $html .= "<td>".$is_admin."</td>";
    $html .= "<td><a class='btn btn-warning' href='libs/user_detail.php?id=".$row['user_id']."'><span class='glyphicon glyphicon-pencil'></span></td>";
    $html .= "</tr>";

    echo $html;
}
?>
</table>
</div>
</body>
</html>
