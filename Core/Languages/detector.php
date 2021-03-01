<?php 

namespace Core\Languages;

/**
 * Class detector
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class detector
{

    public static function isRTL($value)
    {
        $rtlChar = '/[\x{0590}-\x{083F}]|[\x{08A0}-\x{08FF}]|[\x{FB1D}-\x{FDFF}]|[\x{FE70}-\x{FEFF}]/u';
        return preg_match($rtlChar, $value) != 0;
    }


}

?>