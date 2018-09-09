<?php

class Post{
    
    public static function createPost($postBody, $loggedInuserID, $profileUserID){
         
        $id = 0;
            
            if(strlen($postBody) > 240 || strlen($postBody) < 1){
                die('Incorrect post length');
            }
            
            
            if($loggedInuserID == $profileUserID){
            
            DB::query('INSERT INTO posts VALUES (:id, :postBody, NOW(), :userID, 0)', array(':id'=>$id, ':postBody'=>$postBody, ':userID'=> $profileUserID));
            }
            
            else {
                die('Incorrect user');   
            }
    }
    
    public static function likePost($postid, $followerID){
        
        $id = 0;
        
        if(!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id =:userid', array(':postid'=>$postid, ':userid'=>$followerID))){
            
            DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postid));
            
            DB::query('INSERT INTO post_likes VALUES(:id, :post_id, :user_id)', array(':id'=>$id, ':post_id'=>$postid, ':user_id'=>$followerID));
            }
            
            else {
                
                DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postid));
            
                DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postid, ':userid'=>$followerID));
                
                //echo "Already liked this post";
            }
    }
    
    public static function displayPosts($userid, $username, $loggedInuserID){
        $dbposts = DB::query('SELECT * FROM posts WHERE user_id = :userID ORDER BY id DESC', array(':userID'=>$userid));
        $posts = "";
        
        foreach($dbposts as $p){
            
            if(!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$p['id'], ':userid'=>$loggedInuserID))){
            
            //print_r($p);
            $posts .= htmlspecialchars($p['body'])."<form action='profile.php?username=$username&postid=".$p['id']."' method='post'> 
            
            <input type='submit' name='like' value='Like'>
            <span>".$p['likes']." likes</span>
            
            </form><hr /></br />";
            }
            
            else{
                 $posts .= htmlspecialchars($p['body'])."<form action='profile.php?username=$username&postid=".$p['id']."' method='post'> 
            
                <input type='submit' name='unlike' value='UnLike'>
                <span>".$p['likes']." likes</span>

                </form><hr /></br />";
            }
        }
        
        return $posts;
    }
}

?>