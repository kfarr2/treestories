<script>
function confirmFlag(){
    return confirm("You are about to flag this post as inappropriate. Are you sure?");
}

</script>
<?php
function addCard($row, $conn){
    $sql = "SELECT is_admin FROM users WHERE user_id=?";
    $result = $conn->prepare($sql);
    $result->bindParam(1, $_SESSION['treestories_user_id'], PDO::PARAM_STR);
    $result->execute();
    $outcome = $result->fetchAll()[0];

    // Keep track of where the user is coming from
    $medium = "";
    if($row['facebook'] == 1 && $row['google'] == 1){
        $medium = "both";
    } elseif($row['facebook'] == 1){
        $medium = "Facebook";
    } elseif($row['google'] == 1){
        $medium = "Google";
    } else {
        $medium = "None";
    }
    // If the user is an admin or the OP,
    // show the delete button.
    if(isset($_SESSION['treestories_user_id'])){
	if((escape_html($row['user_id']) === $_SESSION['treestories_user_id']) || ($outcome['is_admin'] === '1')){
        $button = "<div class='col-md-12'><a class='pull-right delete-post' href='".$page."libs/delete_post.php?post_id=".escape_html($row['post_id'])."'><span title='Delete this Post?' class='glyphicon glyphicon-trash'></span></a></div>";
    	}
    } else {
        $button = "";
    }

    $flag = "<div class='col-md-3'><form method='POST' onsubmit='return confirmFlag();' action=\"/cs/libs/flag_post.php\">";
    $flag .= "<input type='hidden' value='".$row['post_id']."' name='post_id' />";
    $flag .= "<button class='style-as-link pull-right' type='submit' title='Flag as Inappropriate?'>";
    $flag .= "<span class='glyphicon glyphicon-flag'></span></button></form></div>";

    if($row['image_url'] !== NULL){
        $image = '<div class="row">'.
                    '<div class="col-md-12"><div class="card-image-container"><div class="card-image" style="background-image:url(\'/cs'.$row['image_url'].'\');"></div></div></div>'.
                 '</div>';
    } else {
        $image = "";
    }


    // Construct the card
    $card = '<div class="card"><div class="container container-fluid">'.
        $image.
        '<div class="row">'.
            '<div class="col-md-9">'.
                '<strong>By: </strong>'.$row['name'].
            '</div>'.
            $flag.
        '</div>'.
        '<div class="row">'.
            '<div class="col-md-12">'.
            '<strong>Location: </strong><a class="location-link" href="/cs/list.php?location='.escape_html($row['tree_location']).'">'.$row['tree_location'].'</a></div>'.
        '</div>'.
        '<div class="row">'.
            '<div class="col-md-12"><div class="well"><p>'.$row['content'].'</p>'.
            "</div></div>".
        '</div>'.
        '<div class="row">'.
            '<div class="col-md-12"><strong>Posted: </strong>'.date('m/d/Y', strtotime($row['created_on'])).'</div>'.
        '</div>'.
        '<div class="row">'.
        $button.
        '</div>'.
        '</div>'.
        '</div>';
    echo $card;
}
?>
