<?php 
use App\Applecation;

require_once dirname(__DIR__).'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



$app = new Applecation(dirname(__DIR__));

$app->router->filter('Auth',function() use(&$app){ // sending $app with refrence
    if(!$app->isLoggedIn()){
        return $app->response->redirect("/login");
    }
});

$app->router->filter('notAuth',function() use(&$app){
    if($app->isLoggedIn()){
        return $app->response->redirect("/");
    }
});


$app->router->group(['before'=>'Auth'],function() use(&$app){

    $app->router->get('/',['App\Controllers\homeController','index']);

    $app->router->post('/api/post',['App\Controllers\postsController','newPost']);
    
});

$app->router->group(['before'=>'notAuth'],function() use(&$app){

    $app->router->get('/login',['App\Controllers\authController','getLogin']);
    $app->router->get('/register',['App\Controllers\authController','getRegister']); 

    $app->router->post('/register',['App\Controllers\authController','register']);
    $app->router->post('/login',['App\Controllers\authController','login']);

     
});


$app->router->get('404',function(){
    return "not found";
});

$app->run();

?>