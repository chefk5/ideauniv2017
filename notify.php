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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
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



<?php

echo "<h1 class='text-center'>Notifcations</h1>";
if (DB::query('SELECT * FROM notifications WHERE receiver=:userid', array(':userid'=>$userid))) {

        $notifications = DB::query('SELECT * FROM notifications WHERE receiver=:userid ORDER BY id DESC', array(':userid'=>$userid));

        foreach($notifications as $n) {

                if ($n['type'] == 1) {
                        $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$n['sender']))[0]['username'];

                        if ($n['extra'] == "") {
                                echo "You got a notification!<hr />";
                        } else {
                                $extra = json_decode($n['extra']);

                                echo "<div class='well text-center col-lg-4 col-lg-offset-4' >".$senderName." mentioned you in a post! - ".$extra->postbody."<hr /></div>";
                        }

                } else if ($n['type'] == 2) {
                        $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$n['sender']))[0]['username'];
                        echo "<div class='well text-center col-lg-4 col-lg-offset-4' >".$senderName." liked your post!<hr /></div>";
                }

        }

}


?>
</body>
</html>