<?php 

namespace Core\Cloud\Azure\tts;

use Core\Cloud\Azure\tts\helpers\configInitiator;


/**
 * Class TTS
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core\Cloud\Azure\tts
 */
class tts{


    private $API_KEY;
    const AccessTokenUri = "https://uksouth.api.cognitive.microsoft.com/sts/v1.0/issueToken";
    const ttsServiceUri = "https://uksouth.tts.speech.microsoft.com/cognitiveservices/v1";
    const VALIDATION_RULE = "ACCESS TOKEN DENIED";

    protected $lang;
    protected $gender;
    protected $voice;

    private $access_token;
    private $buffer;

    private $errors;

    public function __construct($message)
    {
        $this->API_KEY = $_ENV['AZURE_TTS_TOKEN'];
        $this->text = $message;
        $this->setConfig();
        $this->initAccessToken();
        if(!$this->hasErrors())
        {
            $this->buffer = $this->initWave();
        }
        return $this;
    }
    
    public function getBuffer()
    {
        return $this->buffer;
    }

    private function setConfig()
    {
        $config = new configInitiator($this->text);
        $this->lang = $config->getLang();
        $this->gender = $config->getGender();
        $this->voice = $config->getVoice();
    }

    public static function create($message)
    {
        return new self($message);
    }

    private function initAccessToken()
    {
        $options = array(
            'http' => array(
                'header'  => "Ocp-Apim-Subscription-Key: ".$this->API_KEY."\r\n" .
                "content-length: 0\r\n",
                'method'  => 'POST',
            ),
        );  
        $context  = stream_context_create($options);
        $this->access_token = file_get_contents(SELF::AccessTokenUri, false, $context);
        if(!$this->access_token){
            $this->errors = SELF::VALIDATION_RULE;
        }
    }

    private function initWave()
    {
        $SSML = $this->initSSML();
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/ssml+xml\r\n" .
                            "X-Microsoft-OutputFormat: riff-24khz-16bit-mono-pcm\r\n" .
                            "Authorization: "."Bearer ".$this->access_token."\r\n" .
                            "X-Search-AppId: 07D3234E49CE426DAA29772419F436CA\r\n" .
                            "X-Search-ClientID: 1ECFAE91408841A480F00935DC390960\r\n" .
                            "User-Agent: TTSPHP\r\n" .
                            "content-length: ".strlen($SSML)."\r\n",
                'method'  => 'POST',
                'content' => $SSML,
                ),
            );
        $context  = stream_context_create($options);
        return file_get_contents(SELF::ttsServiceUri, false, $context);
    }

    private function initSSML()
    {
        $doc = new \DOMDocument();

        $root = $doc->createElement( "speak" );
        $root->setAttribute( "version" , "1.0" );
        $root->setAttribute( "xml:lang" , $this->lang );
     
        $voice = $doc->createElement( "voice" );
        $voice->setAttribute( "xml:lang" , $this->lang );
        $voice->setAttribute( "xml:gender" , $this->gender );
        $voice->setAttribute( "name" , $this->lang."-".$this->voice); 
     
        $text = $doc->createTextNode($this->text);
     
        $voice->appendChild( $text );
        $root->appendChild( $voice );
        $doc->appendChild( $root );
        return $doc->saveXML();     

    }

    private function hasErrors()
    {
        if($this->errors)
        {
            return true;
        }
        return false;
    }

}

?>