<?php 

namespace Core\Authentication\Token;

use App\Applecation;

/**
 * Class loginToken
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core\Authentication\Token
 */
class loginToken
{

      private function hasToken()
      {
        if(isset($_COOKIE['SSID'])){
            return $_COOKIE['SSID'];
        }
        return false;
      }

      private function getUserId()
      {
        $userId = Applecation::$app->dbQuery('SELECT user_id FROM logintokens WHERE token=:token',[':token'=>sha1($_COOKIE['SSID'])]);
        if($userId)
        {
          if(isset($_COOKIE['SSID_'])){
            return $userId[0]['user_id'];
          }
          $cstrong = True;
          $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
          Applecation::$app->dbQuery('INSERT INTO logintokens VALUES(NULL,:token,:user_id,:ipadress,:agent,NOW(),NOW())', array(':token'=>sha1($token), ':user_id'=>$userId[0]['user_id'],':ipadress'=>$_SERVER['REMOTE_ADDR'],':agent'=>$_SERVER['HTTP_USER_AGENT']));
          Applecation::$app->dbQuery('DELETE FROM logintokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SSID'])));
          setcookie("SSID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
          setcookie("SSID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
          return $userId[0]['user_id'];  
        }
        return NULL;
      }
      
      public function checkToken()
      {
        if($this->hasToken())
        {
          return $this->getUserId();
        }
        return NULL;
      }


      
    public function addLoginToken($userid,$remember = false){
      $cstrong = True;
      $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
      Applecation::$app->dbQuery('INSERT INTO logintokens VALUES(\'\', :token, :user_id,:ipadress,:agent,NOW(),NOW())', array(':token'=>sha1($token), ':user_id'=>$userid, ':ipadress'=>$_SERVER['REMOTE_ADDR'],':agent'=>$_SERVER['HTTP_USER_AGENT']));
      if($remember){
        setcookie("SSID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
        setcookie("SSID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
      }
    }

}

?>