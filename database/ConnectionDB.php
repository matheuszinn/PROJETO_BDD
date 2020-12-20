<?php


namespace ConexaoPostgres;
use PDO;

class ConnectionDB{
    private static $connection;

    public function connect(){
        $params = parse_ini_file('database.ini');
        if($params === false){
            throw new \Exception("Não foi possível ler o arquivo de configuração do banco de dados");
        }

        $conStr = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                        $params['host'],
                        $params['port'],
                        $params['database'],
                        $params['user'],
                        $params['password']);

        $pdo = new  PDO($conStr);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function get(){
        if(null === static::$connection){
            static::$connection = new static();
        }
        return static::$connection;
    }

}