<?php 

namespace Core\Http;

use App\Applecation;


/**
 * Class Request
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class Request{

    /**
     * Returns method type
     * 
     * @return string
     */

    public function getMethod(): string
    {
        /**
         * Returning lowercase because our $route method parameter is lowercase
         */
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUrlParse(): string
    {
        return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    }

    public function isPost(): bool
    {
        if($this->getMethod() === "POST")
        {
            return true;
        }
        return false;
    }

    public function isGet(): bool
    {
        if($this->getMethod() === "GET")
        {
            return true;
        }
        return false;
    }

    public function getBody(): array
    {
        $body = [];
        if($this->getMethod() === 'GET')
        {

            foreach($_GET as $key => $value)
            {
                $body[$key] = Applecation::$app->Sanitizer->xss_clean($value);
            }

        }

        if($this->getMethod() === 'POST')
        {

            foreach($_POST as $key => $value)
            {
                $body[$key] = Applecation::$app->Sanitizer->xss_clean($value);
            }
            
        }

        return $body;
    }


}


?>