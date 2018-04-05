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
      <li><a href="send-message.php">send messages</a></li>
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


if (isset($_GET['mid'])) {
        $message = DB::query('SELECT * FROM messages WHERE id=:mid AND (receiver=:receiver )', array(':mid'=>$_GET['mid'], ':receiver'=>$userid))[0];
        echo "<h1 class='text-center'>View Message</h1>";
        echo "<div class='well text-center col-lg-4 col-lg-offset-4'>".htmlspecialchars($message['body'])."</div>";
        echo '<hr />';

        if ($message['sender'] == $userid) {
                $id = $message['receiver'];
        } else {
                $id = $message['sender'];
        }
        DB::query('UPDATE messages SET `read`=1 WHERE id=:mid', array (':mid'=>$_GET['mid']));
        ?>
        <form action="send-message-reply.php?receiver=<?php echo $id; ?>"  method="post" class="input-group-lg text-center col-lg-4 col-lg-offset-4"><br />
                <textarea name="body" required="required" class="form-control"  placeholder="Your message..." rows="8" placeholder="receiver" cols=""></textarea><br />
                <input type="submit" name="send" value="Send Message" class="btn btn-default" style="width:100%;background-image:url(&quot;none&quot;);background-color:#da052b;color:#fff;padding:16px 32px;margin:0px 0px 6px;border:none;box-shadow:none;text-shadow:none;opacity:0.9;text-transform:uppercase;font-weight:bold;font-size:13px;letter-spacing:0.4px;line-height:1;outline:none;">
                <a href="my-messages.php">Back to messages</a>
        </form>
        
        <?php
} else {

?>
<h1 class="text-center">My Messages</h1>
<p class="text-center"><button class="text-center" type="button" class="btn "><a href="send-message.php">New Message</a></button></p>
<?php
$messages = DB::query('SELECT messages.*, users.username FROM messages, users WHERE receiver=:receiver  AND users.id = messages.sender ORDER BY messages.id DESC', array(':receiver'=>$userid));
foreach ($messages as $message) {

        if (strlen($message['body']) > 10) {
                $m = substr($message['body'], 0, 10)." ...";
        } else {
                $m = $message['body'];
        }

        if ($message['read'] == 0) {
                echo "<div  class='well text-center col-lg-4 col-lg-offset-4'><a href='my-messages.php?mid=".$message['id']."'><span style='color:red;' class='glyphicon glyphicon-envelope aria-hidden='true'></span><p style='color:red;'
                ><strong>".$m."</strong></p></a> <br>sent by ".$message['username'].'<hr /></div>';
        } else {
                echo "<div  class='well text-center col-lg-4 col-lg-offset-4'><a href='my-messages.php?mid=".$message['id']."'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span><br>".$m."</a><br>sent by ".$message['username'].'<hr /></div>';
        }

}

}
?>
