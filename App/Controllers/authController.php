<?php 

namespace App\Controllers;

use App\Applecation;
use Core\Controller;
use App\Models\User;


class authController extends Controller
{

    public $layout = "notAuth";
    

    public function getLogin()
    {
        $this->setTitle("Login");
        return $this->render("login");
    }
    
    public function getRegister()
    {
        $this->setTitle("Register");
        return $this->render('register');
    }

    public function register()
    {
        $user = new User();

        $user->loadData(Applecation::$app->request->getBody());
        
        if($user->validate() && $user->save())
        {
            Applecation::$app->auth->authUser($user->getId());
            return Applecation::$app->response->redirect("/");
        }

        return $this->render('register',['error'=>$user->firstError()]);

    }

    public function login()
    {
        $user = new User();
        $user->loadData(Applecation::$app->request->getBody());

        if($user->validateLogin())
        {
            Applecation::$app->auth->authUser($user->getId());
            return Applecation::$app->response->redirect("/");
        }

        return $this->render('login',['error'=>$user->firstError()]);
    }



}

?>