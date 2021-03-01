<?php 

namespace Core\FileManager;

use App\Applecation;
use Core\FileManager\Factory\extensions\audio;

/**
 * Class FileManager
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class FileManager
{

    protected $extension;

    const EXTENSIONS_POINTER = [
        'mp3'=>"audio/"
    ];


    protected $buffer;

    const RUNTIME_ROUTE = "/public/runtime/";

    protected $fileName;

    public function __construct($buffer,$extension)
    {
        $this->extension = $extension;
        $this->buffer = $buffer;
        return $this;
    }

    protected function setName()
    {
        $this->fileName = time()."_"."user". Applecation::$app->isLoggedIn() . "." . $this->extension;
    }

    public function getName()
    {
        return $this->fileName;
    }
    
    protected function getPath()
    {
        return Applecation::$ROOT . SELF::RUNTIME_ROUTE . SELF::EXTENSIONS_POINTER[$this->extension] . $this->fileName;
    }

    public function export()
    {
        $this->setName();
        fopen($this->getPath(), "w");
        file_put_contents($this->getPath(),$this->buffer);
    }



}


?>