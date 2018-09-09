<?php

class Login {
    public static function isLoggedIn(){
    
    if(isset($_COOKIE['onPointID'])){
        if(DB::query('SELECT user_id FROM login_tokens WHERE token = :token', array(':token'=>sha1($_COOKIE['onPointID'])))){
            
            $userID = DB::query('SELECT user_id FROM login_tokens WHERE token = :token', array(':token'=>sha1($_COOKIE['onPointID'])))[0]['user_id'];
            
            if(isset($_COOKIE['onPointID_'])){
                return $userID;
            }
            
            else {
                $cstrong = true;
                $id = 0;
                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                DB::query('INSERT INTO login_tokens VALUES (:id, :token, :user_id)', array(':id'=> $id, ':token' => sha1($token), ':user_id' => $userID));
                DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['onPointID'])));
                
                setcookie("onPointID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, true);
                setcookie("onPointID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, true);
                
                return $userID;
            }
            
        }
    }
    
    return false;
}
}

?>