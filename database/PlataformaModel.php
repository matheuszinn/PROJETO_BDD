<?php


namespace ConexaoPostgres;

use PDO;

class PlataformaModel{
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function get_all(){
        $stmt = $this->pdo->query('SELECT nome_plataforma from plataforma');
        $stocks =[];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stocks[] = [
                'nome_plataforma' => $row['nome_plataforma']
            ];
        }
        return $stocks;
    }

    public function insert_new($nome_plataforma){
        $sql = "insert into plataforma(nome_plataforma) values (':nome_plataforma')";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nome_plataforma', $nome_plataforma);

        $stmt->execute();
    }

    public function get_by_key($key){
        $stmt = $this->pdo->query('select nome_plataforma from plataforma where nome_plataforma = ' . $key);
        $plataforma = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
          'nome_plataforma' => $plataforma['nome_plataforma']
        ];
    }
}