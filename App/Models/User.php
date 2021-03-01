<?php 

namespace App\Models;

use App\Applecation;
use Core\Model;

class User extends Model
{
    public $username = '';
    public $firstname = '';
    public $lastname = '';
    public $email = '';
    public $password = '';

    protected $userId;



    /**
     * rules function
     * returns fields rules (to validate)
     * 
     * @return array
     */
    public function rules(): array
    {
        return [
            "username"=>[
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min'=>3],
                [self::RULE_MAX, 'max'=>18],
                [self::RULE_UNIQUE, 'class'=>self::class]
            ],
            "firstname"=>[
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min'=>3],
                [self::RULE_MAX, 'max'=>26]
            ],
            "lastname"=>[
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min'=>3],
                [self::RULE_MAX, 'max'=>26]
            ],
            "email"=>[
                self::RULE_REQUIRED,
                self::RULE_EMAIL,
                [self::RULE_UNIQUE, 'class'=>self::class]
            ],
            "password"=>[
                self::RULE_REQUIRED,
                [self::RULE_MIN,'min'=>8]
            ],
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

    public function save()
    {
        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
        Applecation::$app->dbQuery(
            'INSERT INTO users(username,firstname,lastname,email,password)
             VALUES(:username,:fn,:ln,:email,:password)',
             [
                 ':username'=>$this->username,
                 ':fn'=>$this->firstname,
                 ':ln'=>$this->lastname,
                 ':email'=>$this->email,
                 ':password'=>$this->password,
             ]);
        $this->updateId();
        return true;
    }

    protected function updateId($id = NULL)
    {
        if($id)
        {
            $this->userId = $id;
            return $this->userId;
        }
        $this->userId = Applecation::$app->dbQuery(
            'SELECT id FROM users WHERE email=:email',
            [
                ':email'=>$this->email
            ]
        )[0]['id'];
    }
    
    public function getId()
    {
        return $this->userId;
    }

    public function validateLogin()
    {
        $query = Applecation::$app->dbQuery('SELECT id,password FROM users WHERE (username=:username OR email=:username)',[':username'=>$this->username]);
        if($query)
        {
            if(password_verify($this->password,$query[0]['password'])){
                return $this->updateId($query[0]['id']);
            }
            return $this->addManualError('This password is incorrect');
        }
        return $this->addManualError('This email adress or username does not exist');
    }

}

?>