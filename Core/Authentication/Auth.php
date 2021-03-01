<?php 

namespace Core\Authentication;
use Core\Authentication\Token\loginToken;


/**
 * Class Auth
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core\Authentication
 */
class Auth{

    public $userId;

    private $tokenManager;

    public function __construct()
    {
        $this->tokenManager = new loginToken();

        $this->initAuth();
    }

    private function initAuth()
    {
        $this->userId = $this->tokenManager->checkToken();
    }

    public function isAuth(){
        return $this->userId;
    }
    
    public function authUser($userId)
    {
        return $this->tokenManager->addLoginToken($userId,TRUE);
    }

    
}


?>