<?php 

namespace Core\Http;


/**
 * Class Response
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class Response{

    
    public function setStatus($code = 403)
    {
        http_response_code($code);
    }

    public function redirect($directory = "404")
    {
        header("Location:$directory");
        return exit;
    }

    public function getJson($arr = []): string
    {
        return json_encode($arr);
    }

}

?>