<?php 

namespace App\Models;

use App\Applecation;
use Core\Cloud\Azure\tts\tts;
use Core\Model;
use Core\FileManager\Factory\extensions\audio;


class Post extends Model{

    public $title = "";

    public $context = "";
    
    public function rules(): array
    {
        return [
            'title'=>[
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min'=>2],
                [self::RULE_MAX, 'max'=>64],
            ],
            'context'=>[
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min'=>8],
                [self::RULE_MAX, 'max'=>4096],
            ]
        ];
    }

    /**
     * tablename function
     *
     * @return string
     */
    public function tablename(): string
    {
        return "users";
    }

    public function getPosts()
    {
        return Applecation::$app->dbQuery(
            'SELECT title,
                    file_name,
                    CONCAT_WS(" ",firstname,lastname) AS fullname,
                    CONCAT(LEFT(firstname,1),LEFT(lastname,1)) AS aliasName,
                    avatar,
                    p.createdat as createdat
             FROM posts as p
             INNER JOIN users as u 
             ON p.user_id = u.id
             ORDER BY p.id DESC
             ');
    }    

    public function addPost()
    {

        $post = audio::createFile(tts::create($this->context)->getBuffer());

        $post->export();

        //creating new Post
        Applecation::$app->dbQuery('INSERT INTO posts(user_id,title,context,file_name)
            VALUES(:id,:title,:context,:filename)',
            [
                ':id'=>Applecation::$app->isLoggedIn(),
                ':title'=>$this->title,
                ':context'=>$this->context,
                ':filename'=>$post->getName()
            ]);     
        return true;   
    }

}


?>