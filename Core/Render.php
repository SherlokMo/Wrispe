<?php 
namespace Core;
use App\Applecation;


/**
 * Class Render
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class Render{


    private $layout;

    private $title;


    public function __construct($layout, $title)
    {
        $this->layout = $layout;
        $this->title = $title;
    }

    function layoutRender($view,$params = [])
    {
        return $this->viewContent($view,$params);
    }

    public function render($view,$params = []): string
    {
        $templateContent = $this->templateRender();
        $viewContent = $this->viewContent($view,$params);
        return str_replace("{{content}}",$viewContent,$templateContent);
    }


    /**
     * buffering view Content (Data we actually are looking for)
     * @return string (HTML code)
     */
    protected function viewContent($view, $params): string
    {

        foreach($params as $key => $value)
        {
            /**
             * Variable variable  ($$)
             * if key is name and value is mohammad then it is as declearing:
             * $name = mohammad
             */
            $$key = $value;
        }

        ob_start();
        include_once Applecation::$ROOT."/App/Views/$view.php";
        return ob_get_clean();
    }

    protected function templateRender(): string
    {
        ob_start();
        include_once Applecation::$ROOT."/public/layout/layouts/$this->layout.php";
        return ob_get_clean();
    }

    

}


?>