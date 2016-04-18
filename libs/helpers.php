<?php
require_once('connections.php');

// Nice function to escape to html safe characters.
function escape_html($val){
    return htmlspecialchars($val, ENT_QUOTES);
}

function check_login($conn, $url){
    if(!isset($_SESSION['fb_access_token']) && !isset($_SESSION['google_access_token'])){
        return false;
    } else {
        if(isset($_SESSION['fb_access_token'])){
            $userNode = get_fb_info();
        } else if(isset($_SESSION['google_access_token'])){
            $userNode = get_google_info();
        }
        $sql = "SELECT user_id FROM users WHERE name=? AND email=?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$userNode['name'], PDO::PARAM_STR);
        $query->bindParam(2,$userNode['email'], PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll()[0];

        $_SESSION['treestories_user_id'] = $result['user_id'];
        return true;
    }
}

function check_admin($conn, $url){
    if(check_login($conn, $url)){
        $sql = "SELECT user_id, name, is_admin FROM users WHERE is_admin=1";
        $result = $conn->prepare($sql);
        $result->execute();
        $users = $result->fetchAll();
        if(isset($_SESSION['fb_access_token'])){
            $userNode = get_fb_info();
        } else if(isset($_SESSION['google_access_token'])){
            $userNode = get_google_info();
        }
        $is_admin = false;
        foreach($users as $user){
            if($userNode["name"] == $user['name'] && $user['is_admin'] == true){
                $is_admin = true;
            }
        }
        if($is_admin == false){
            setcookie('message', 'ERROR: You do not have permission to go there. This attempt has been recorded', time() + 10, '/');
            header("Location: ".$page."cs/list.php");
        } else {
            return true;
        }
    }
}

function get_google_info(){
    $client = new Google_Client();
    $client->setApplicationName("Tree Stories Client");
    $client->setDeveloperKey($google_api_key);
    $client->setClientId($google_app_id);
    $client->setClientSecret($google_app_secret);
    $client->setAccessToken($_SESSION['google_access_token']);
    $oAuth2 = new \Google_Service_Oauth2($client);
    try {
        $oAttr = $oAuth2->userinfo->get();
    } catch(Exception $e){
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
        $_SESSION['fb_access_token'] = NULL;
        $_SESSION['google_access_token'] = NULL;
        setcookie('message', 'ERROR: User Authentication Error', time() + 10, '/');
        header("Location: ".$page."cs/");
    }

    $userNode = array();
    $userNode['id'] = $oAttr['id'];
    $userNode['name'] = $oAttr['name'];
    $userNode['email'] = $oAttr['email'];
    return $userNode;
}

function get_fb_info(){
        include('connections.php');
	$fb = new Facebook\Facebook([
	    'app_id' => $fb_app_id,
	    'app_secret' => $fb_app_secret,
	    'default_graph_version' => 'v2.5',
        ]);

        try {
	    $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
        } catch(Facebook\Exceptions\FacebookSDKException $e){
	    // Handle this
	    var_dump($e);
	    die();
        }

        // Get user info from facebook
        $userNode = $response->getGraphUser();
        return $userNode;
}

function messages(){
    // Handle any old cookie data
    if(isset($_COOKIE['message'])){
        $message = escape_html($_COOKIE['message']);
        unset($_COOKIE['message']);
        setcookie('message', null, -1, '/');
    }
    if(isset($message)){
        $alert = '<div id="message-banner" class="alert ';
        $index = strpos($message, "ERROR");
        if($index === 0){
            $alert .= 'alert-danger';
        } else {
            $alert .= 'alert-success';
        }
        $alert .= ' alert-dismissible" role="alert"><div class="container">';
        $alert .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $alert .= '<span aria-hidden="true">&times;</span></button>';
        $alert .= '<div class="text-center">'.$message.'</div></div>';
        $alert .= '</div>';
        echo $alert;
    }

}

?>
