<?php 
include('./classes/DB.php');
include('./classes/Login1.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
        $username= DB::query('SELECT username FROM users WHERE id=:userid', array(':userid'=>$userid));
       $username=$username[0]['username'];
} else {
        die('Not logged in');
} ?>
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
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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
    
</body>
</html>



<?php

if (isset($_POST['send'])) {
	$id=$_GET['receiver'];
       /* if(empty($id=DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$id)))){
        echo "<div class='alert alert-danger text-center' role='alert'>Wrong Username</div>";
}
else {*/
        //$nameToId= $nameToId[0]['id'];

        if (DB::query('SELECT id FROM users WHERE id=:receiver', array(':receiver'=>$id))) {
                DB::query("INSERT INTO messages VALUES (:id, :body, :sender, :receiver, :read)", array(':id'=>0,':body'=>$_POST['body'], ':sender'=>$userid, ':receiver'=>$id, ':read'=>0));
               // echo "<div class='alert alert-success text-center' role='alert'>Message Sent!</div>";
                echo "  <h3 style='font-family: 'Roboto', sans-serif;' class='text-center well'>Your reply has been sent successfuly! Return to your <a href='my-messages.php'>messages.</a></h3>";
        } 
}
        

?>

