<?php 

namespace Core\Database;

/**
 * Class DB
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */
class DB{

    private $pdo;

    function __construct()
    {
        $this->pdo = new \PDO($_ENV['PDO_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);        
    }

    public function connect()
    {
        return new self();
    }

    public function run($query,$params)
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        if(explode(' ', $query)[0] == 'SELECT'){
            $data = $statement->fetchAll();
            return $data;
        }
    }

}



?>