<?php
include('classes/DB.php');
include('classes/Login1.php');
if (!Login::isLoggedIn()) {
        die("Not logged in.");
}
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
       $username= DB::query('SELECT username FROM users WHERE id=:userid', array(':userid'=>$userid));
       $username=$username[0]['username'];
}
if (isset($_POST['confirm'])) {
        if (isset($_POST['alldevices'])) {
                DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
        } else {
                if (isset($_COOKIE['SNID'])) {
                        DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
                }
                setcookie('SNID', '1', time()-3600);
                setcookie('SNID_', '1', time()-3600);
        }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
   
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
<div class="text-center">
<h1>Logout of your Account?</h1>
<p>Are you sure you'd like to logout?</p>
<form action="logout.php" method="post">
        <input type="checkbox" name="alldevices" value="alldevices"> Logout of all devices?<br />
        <br>
        <input type="submit" name="confirm" value="Confirm">
</form>
</div>
</body>
</html>