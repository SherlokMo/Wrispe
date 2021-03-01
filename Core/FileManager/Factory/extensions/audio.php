<?php 

namespace Core\FileManager\Factory\extensions;

use Core\FileManager\FileManager;

/**
 * Class audio
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class audio extends FileManager{

    
    public static function createFile($buffer,$extension = "mp3")
    {
        return new self($buffer,$extension);
    }

    public function getDuration()
    {
        
    }

}


?>