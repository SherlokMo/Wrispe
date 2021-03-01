<?php 

namespace Core;
use App\Applecation;


/**
 * Class Controller
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class Controller{

    public $layout = "main";
    
    protected $title = "Wrispe";


    public $render;


    /**
     * @param string $layout
     */

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    protected function setTitle($title): void
    {
        $this->title = $title;
    }

    private function setRender()
    {
        $this->render = new Render($this->layout,$this->title);
        return $this->render;
    }

    public function renderLayout($view, $params = [])
    {
        return $this->setRender()->layoutRender($view,$params);
    }

    public function render($view, $params = [])
    {
        return $this->setRender()->render($view, $params);
    }


}
?>