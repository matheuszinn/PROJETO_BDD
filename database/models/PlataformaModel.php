<?php


namespace ConexaoPostgres;

use PDO;

class PlataformaModel{
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function get_all(){
        $stmt = $this->pdo->query('SELECT id_plataforma,nome_plataforma from plataforma order by nome_plataforma ');
        $stocks =[];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stocks[] = [
                'id_plataforma' => $row['id_plataforma'],
                'nome_plataforma' => $row['nome_plataforma']
            ];
        }
        return $stocks;
    }

    public function insert_new($nome_plataforma){
        $sql = "insert into plataforma(nome_plataforma) values (:nome_plataforma)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nome_plataforma', $nome_plataforma);

        $stmt->execute();
    }

    public function get_by_key($key){
        $stmt = $this->pdo->query("select id_plataforma,nome_plataforma from plataforma where id_plataforma = $key");
        $plataforma = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
            'id_plataforma' => $plataforma['id_plataforma'],
            'nome_plataforma' => $plataforma['nome_plataforma']
        ];
    }

    public function delete_by_key($key){
        $sql = "delete from plataforma where plataforma.nome_plataforma = '$key'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

}