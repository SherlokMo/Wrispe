<?php 
namespace App;

use Core\Http\Request;
use Core\Http\Response;
use Core\Database\DB;
use Core\Sanitizer;
use Core\Authentication\Auth;

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

/**
 * Class Applecation
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package App
 */

class Applecation{

    public static $ROOT;

    /**
     * router instance
     *
     * @var [object]
     */
    public $router;

    public $request;

    public $response;

    public $Sanitizer;

    public $DB;

    public $auth;

    private $dispatcher;

    public static $app;

    public $userId;

    public function __construct($rootPath)
    {

        $this->request = new Request();
        $this->Sanitizer = new Sanitizer();
        $this->response = new Response();

        $this->DB = new DB();
        self::$ROOT = $rootPath;
        self::$app = $this;
        $this->router = new RouteCollector();
        $this->auth = new Auth();
        
        $this->userId = $this->checkLoggedIn();

    }


    public function run()
    {
        $this->dispatcher = new Dispatcher($this->router->getData());
        // try {
            $response = $this->dispatcher->dispatch($this->request->getMethod(), $this->request->getUrlParse());
            echo $response;
        // } catch (\Throwable $th) {
        //     $this->response->redirect();
        // }
    }


    protected function checkLoggedIn()
    {
        if($this->auth->isAuth())
        {
            return $this->auth->userId;
        }
        return NULL;
    }

    public function isLoggedIn()
    {
        return $this->userId;
    }

    public function dbQuery($query, $params = [])
    {
        return $this->DB->run($query,$params);
    }
    
    

}


?>