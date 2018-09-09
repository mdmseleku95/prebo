<?php
class Comment {
        public static function createComment($commentBody, $postId, $userId) {
            
             $id = 0;

                if (strlen($commentBody) > 160 || strlen($commentBody) < 1) {
                        die('Incorrect length!');
                }

                if (!DB::query('SELECT id FROM posts WHERE id=:postid', array(':postid'=>$postId))) {
                        echo 'Invalid post ID';
                } else {
                        DB::query('INSERT INTO comments VALUES (:id, :comment, :userid, NOW(), :postid)', array(':id'=>$id,':comment'=>$commentBody, ':userid'=>$userId, ':postid'=>$postId));
                }
            }

            
            public static function displayComments($postId){
                
                $comments = DB::query('SELECT comments.comment, accounts.username FROM comments, accounts WHERE post_id=:postid AND comments.user_id = accounts.id', array(':postid'=>$postId));
                
                foreach($comments as $comment){
                    echo $comment['comment']." ~ ".$comment['username']."<hr />";
                }
            }
            
        }
?>
