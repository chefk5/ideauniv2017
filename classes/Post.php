<?php

class Post {

        public static function createPost($postbody, $loggedInUserId, $profileUserId) {

                if (strlen($postbody) > 160 || strlen($postbody) < 1) {
                        die('Incorrect length!');
                }

                $topics = self::getTopics($postbody);

                if ($loggedInUserId == $profileUserId) {

                        if (count(Notify::createNotify($postbody)) != 0) {
                                foreach (Notify::createNotify($postbody) as $key => $n) {
                                                $s = $loggedInUserId;
                                                $r = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$key))[0]['id'];
                                                if ($r != 0) {
                                                        DB::query('INSERT INTO notifications VALUES (:id, :type, :receiver, :sender, :extra)', array(':id'=>0,':type'=>$n["type"], ':receiver'=>$r, ':sender'=>$s, ':extra'=>$n["extra"]));
                                                }
                                        }
                                }

                        DB::query('INSERT INTO posts VALUES (:id, :postbody, NOW(), :userid, :likes, :postimg, :topics)', array(':id'=>0,':postbody'=>$postbody, ':userid'=>$profileUserId,':likes'=>0,':postimg'=>0, ':topics'=>$topics));

                } else {
                        die('Incorrect user!');
                }
        }

        public static function createImgPost($postbody, $loggedInUserId, $profileUserId) {

                if (strlen($postbody) > 160) {
                        die('Incorrect length!');
                }

                $topics = self::getTopics($postbody);

                if ($loggedInUserId == $profileUserId) {

                        if (count(Notify::createNotify($postbody)) != 0) {
                                foreach (Notify::createNotify($postbody) as $key => $n) {
                                                $s = $loggedInUserId;
                                                $r = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$key))[0]['id'];
                                                if ($r != 0) {
                                                        DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, :extra)', array(':type'=>$n["type"], ':receiver'=>$r, ':sender'=>$s, ':extra'=>$n["extra"]));
                                                }
                                        }
                                }

                        DB::query('INSERT INTO posts VALUES (:id, :postbody, NOW(), :userid, :likes, :postimg, :topics)', array(':id'=>0,':postbody'=>$postbody, ':userid'=>$profileUserId,':likes'=>0,':postimg'=>0, ':topics'=>$topics));
                        $postid = DB::query('SELECT id FROM posts WHERE user_id=:userid ORDER BY ID DESC LIMIT 1;', array(':userid'=>$loggedInUserId))[0]['id'];
                        return $postid;
                } else {
                        die('Incorrect user!');
                }
        }

        public static function likePost($postId, $likerId) {

                if (!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId))) {
                        DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postId));
                        DB::query('INSERT INTO post_likes VALUES (:id, :postid, :userid)', array(':id'=>0,':postid'=>$postId, ':userid'=>$likerId));
                        Notify::createNotify("", $postId);
                } else {
                        DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postId));
                        DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId));
                }

        }

        public static function getTopics($text) {

                $text = explode(" ", $text);

                $topics = "";

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "#") {
                                $topics .= substr($word, 1).",";
                        }
                }

                return $topics;
        }

        public static function link_add($text) {

                $text = explode(" ", $text);
                $newstring = "";

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "@") {
                                $newstring .= "<a href='profile.php?username=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else if (substr($word, 0, 1) == "#") {
                                $newstring .= "<a href='topics.php?topic=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else {
                                $newstring .= htmlspecialchars($word)." ";
                        }
                }

                return $newstring;
        }

        public static function displayPosts($userid, $username, $loggedInUserId) {
                $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $posts = "";

                foreach($dbposts as $p) {

                        if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$p['id'], ':userid'=>$loggedInUserId))) {

                                $posts .= "
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                <tr>
                                  <td scope='row'>".self::link_add($p['body'])."</td>
                                         <td>".$p['likes']."</td>
                                         <td>".$p['posted_at']."</td>
                                         <td> <button type='submit' class='btn btn-success' name='like' value='Like'>Like </button></td>
                                         ";
                                 
                             
                                if ($userid == $loggedInUserId) {
                                        $posts .= "<td><button class='btn btn-danger' type='submit' name='deletepost' value='Delete Post' />Delete</button></td>";
                                }
                                $posts .= "
                                </tr></form>
                                ";
                        }else{
                                $posts .= "
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                <tr>
                                  <td scope='row'>".self::link_add($p['body'])."</td>
                                         <td>".$p['likes']."</td>
                                         <td>".$p['posted_at']."</td>
                                          <td> <button type='submit' class='btn btn-info' name='unlike' value='unlike'>Unlike </button></td>
                                         ";
                                 
                             
                                if ($userid == $loggedInUserId) {
                                        $posts .= "<td><button class='btn btn-danger' type='submit' name='deletepost' value='Delete Post' />Delete</button></td>";
                                }
                                $posts .= "
                                </tr></form>
                                ";
                        }

                        

                                if (isset($_POST['comment'])) {
                                        Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}
                              
                                
                        }
                

                return $posts;
        }

}
?>
