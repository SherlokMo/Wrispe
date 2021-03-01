<?php 

namespace Core\Cloud\Azure\tts\helpers;

use Core\Languages\detector;
use App\Applecation;

/**
 * Class configInitiator
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core\Cloud\Azure\tts\helpers
 */
class configInitiator{

    private $text;

    const LANGUAGES = ['ar'=>"ar-EG","en"=>"en-US"];
    const VOICES = [
        'ar-EG'=>[
            'Male'=>[
                'ShakirNeural'
            ],
            'Female'=>[
                'SalmaNeural'
            ]
        ],
        'en-US'=>[
            'Male'=>[
                'GuyNeural'
            ],
            'Female'=>[
                'AriaNeural'
            ]
        ],
    ];


    private $lang;
    private $gender;
    private $voice;

    public function __construct($text)
    {
        $this->text = $text;

        $this->setConfig();
    }


    public function getLang()
    {
        return $this->lang;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getVoice()
    {
        return $this->voice;
    }


    private function setConfig()
    {
        $this->setLanguage();
        $this->setGender();
        $this->setVoice();
    }

    private function setLanguage()
    {
        if(detector::isRTL($this->text))
        {
            $this->lang = SELF::LANGUAGES['ar'];
            return true;
        }
        $this->lang = SELF::LANGUAGES['en'];
    }

    private function setGender()
    {
        $this->gender = Applecation::$app->dbQuery(
                        'SELECT CASE
                                WHEN gender = 0 THEN "Male"
                                ELSE "Female"
                            END as sex
                        FROM 
                            users 
                        WHERE 
                            id=:id'
                        ,[':id'=>Applecation::$app->isLoggedIn()])[0]['sex'];
    }

    private function setVoice()
    {
        $this->voice = SELF::VOICES[$this->getLang()][$this->getGender()][0];
    }


}



?>