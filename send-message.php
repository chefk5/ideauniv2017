<?php
include('./classes/DB.php');
include('./classes/Login1.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
        $username= DB::query('SELECT username FROM users WHERE id=:userid', array(':userid'=>$userid));
       $username=$username[0]['username'];
       // DB::query('SELECT username FROM users WHERE id=:userid', array(':userid'=>$userid));
} else {
        die('Not logged in');
}
if (isset($_POST['send'])) {
        if(empty($nameToId=DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_POST['receiver'])))){
        echo "<div class='alert alert-danger text-center' role='alert'>Wrong Username</div>";
}
else {
        $nameToId= $nameToId[0]['id'];

        if (DB::query('SELECT id FROM users WHERE id=:receiver', array(':receiver'=>$nameToId))) {
                DB::query("INSERT INTO messages VALUES (:id, :body, :sender, :receiver, :read)", array(':id'=>0,':body'=>$_POST['body'], ':sender'=>$userid, ':receiver'=>$nameToId, ':read'=>0));
                echo "<div class='alert alert-success text-center' role='alert'>Message Sent!</div>";
        } 
}
        
}
?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
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
    <div style="margin-top: 100px;" >
    <h1 style="font-family: 'Roboto', sans-serif;" class="text-center">Send a Message</h1>
        <form action="send-message.php" method="post" class="input-group-lg text-center col-lg-4 col-lg-offset-4"><br />
        <input required="required" type="text" class="form-control" name="receiver" placeholder="receiver"><br />
        <textarea required="required" name="body" rows="15" class="form-control" cols="80" placeholder="Your message..."></textarea><br />
        <input type="submit" name="send" class="btn btn-default" style="width:100%;background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;" value="Send Message">
        </form>
        </div>
</body>
</html>

    