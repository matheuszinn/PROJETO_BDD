<?php


namespace ConexaoPostgres;

use PDO;

class Lista_favoritosModel{
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function delete_by_key($key){
        $sql = ";
               
                ";
        $stmt = $this->pdo->prepare($sql);

        $this->pdo->beginTransaction();

        $this->pdo->exec("delete from lista_favoritos where jogo_nome_fav = '$key'");
        $this->pdo->exec("alter sequence lista_favoritos_id_jogo_seq restart");
        $this->pdo->exec("update lista_favoritos set id_jogo = default;");

        $this->pdo->commit();
    }

    public function get_all(){
        $stmt = $this->pdo->query("select jogo_nome_fav from lista_favoritos order by jogo_nome_fav");
        $stocks = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stocks[] = [
                'jogo_nome_fav' => $row['jogo_nome_fav']
            ];
        }
        return $stocks;
    }

    public function insert_new($jogo_nome_fav){
        $sql = "insert into lista_favoritos(jogo_nome_fav) values (:jogo_nome_fav)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':jogo_nome_fav', $jogo_nome_fav);

        $stmt->execute();
    }
}