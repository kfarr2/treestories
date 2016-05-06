<?php
    session_start();
    $title = "Login";
    include_once("libs/connections.php");
    include_once("libs/helpers.php");

    include("libs/light_header.php");
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 1800) {
        // session started more than 30 minutes ago
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }
?>
<div id="list-background"></div>
<div id="wrapper"></div>
<div id="main">
    <div class='text-center' id="center">
        <h1>Sign in to Tree Stories</h1>
    </div>
</div>
</body>
<script>
    $.ajax({
        url: "libs/login.php",
        type: 'get',
        async: true,
        success: function(html){
            $("#center").append(html);
            $("#center").append("<hr /><a id='back' href='<?php echo BASE_DIR;?>list.php'><button class='btn btn-danger'>I Don\'t Want To Sign In.</button></a>");
        }
    });
</script>
</html>
