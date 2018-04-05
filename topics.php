<?php
include('./classes/DB.php');
include('./classes/Login1.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
       $username= DB::query('SELECT username FROM users WHERE id=:userid', array(':userid'=>$userid));
       $username=$username[0]['username'];
} else {
        die('Not logged in');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
   
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <p><a class="navbar-brand" href="home.php">Idea Universe</a></p>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="home.php">Home</a></li>
      <li><a href="my-messages.php">Messages</a></li>
      <li><a href="profile.php?username=<?php echo $username;?>">Profile</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">User
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="postApost.php?username=<?php echo $username;?>">Post</a></li>
          <li><a href="charts.php">Stats</a></li>
          <li><a href="notify.php">Notifications </a></li>
          <li><a href="search.php">Search</a></li>
          <li><a href="my-account.php">Edit Profile</a></li>

          <li><a href="logout.php">Logout </a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav> 
 <div class="container">
        <h1>Timeline </h1>
        <div class="timelineposts text-center">

        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" style="padding-top:100px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria
                    -hidden="true">×</span></button>
                    <h4 class="modal-title">Comments</h4></div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto">
                    <p>The content of your modal.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
     <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>

<?php

include('./classes/Post.php');
include('./classes/Image.php');


if (isset($_GET['topic'])) {
	echo "<h2 class='text-center'>Posts about \"".$_GET['topic']."\"</h2>";

	

        if (DB::query("SELECT topics FROM posts WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic']))) {
    

         $posts = DB::query("SELECT * FROM posts WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic']));
                
                //$idToName=DB::query('SELECT * FROM users WHERE username=:id', array(':id'=>$posts['id']));
                //echo $idToName['username'];
               // echo $posts[0]['body'];
                	 

                
               foreach($posts as $post) {
                        // echo "<pre>";
                        // print_r($post);
                        // echo "</pre>";
               	$idToName = DB::query("SELECT username FROM users WHERE FIND_IN_SET(:id, id)", array(':id'=>$post['user_id']))[0]['username'];

                        echo "<div class='well text-center'><b>".$post['body']."</b><br /> by <a href=profile.php?username=".$idToName.">".$idToName."</a></div>";
                }

        }}


?>
</div>